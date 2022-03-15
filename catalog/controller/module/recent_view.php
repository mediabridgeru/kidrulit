<?php

class ControllerModuleRecentView extends Controller
{

    protected function index($setting) {
        static $module = 0;

        $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/recent_view_list.css');

        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->language->load('module/recent_view');

        $this->data['heading_title'] = $this->config->get('recent_view_heading_title_' . $this->config->get('config_language_id'));
        $this->data['display_type'] = $setting['display_type'];
        $this->data['button_cart'] = $this->language->get('button_cart');
        $this->data['text_show_more'] = $this->language->get('text_show_more');

        if ($this->config->get('text_quick_shop')) {
            $this->data['text_quick_shop'] = $this->config->get('text_quick_shop');
        } else {
            $this->data['text_quick_shop'] = $this->language->get('text_quick_shop');
        }

        $this->data['seo_data'] = array();

        $datas = $this->db->query("SELECT `query`, `keyword`  FROM `" . DB_PREFIX . "url_alias`");

        foreach ($datas->rows as $data) {
            if (preg_match("/product_id/i", $data['query'])) {
                $this->data['seo_data'][] = array(
                    'query' => $data['query'], 'keyword' => $data['keyword']
                );
            }
        }

        if (!isset($this->request->get['route'])) {
            $this->request->get['route'] = 'common/home'; // Чтобы не выдавало ошибку, если юзер набрал адрес в браузере руками
        }

        $route = $this->request->get['route'];

        $this->data['products'] = array();

        $products_ids = array();

        if (isset($this->session->data['product_recent_view'])) {
            $products_ids = array_unique(array_reverse($this->session->data['product_recent_view']));
            if ($route == 'product/product') {
                if (isset($this->request->get['product_id'])) {
                    $product_id = (int)$this->request->get['product_id'];
                } else {
                    $product_id = 0;
                }
                foreach ($products_ids as $k1 => $products_id) {
                    if ($products_id == $product_id) {
                        unset($products_ids[$k1]);
                    }
                }
            }
            $this->data['number_product'] = count($products_ids);
            array_splice($products_ids, $setting['limit']);
        }

        if (empty($setting['limit'])) {
            $this->data['limit'] = 4;
        } else {
            $this->data['limit'] = $setting['limit'];
        }

        $imagewidth = $setting['image_width'];
        $imageheight = $setting['image_height'];

        foreach ($products_ids as $product_id) {
            $result = $this->model_catalog_product->getProduct($product_id);
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $imagewidth, $imageheight);
            } else {
                $image = false;
            }

            if (!$image) {
                $image = $this->model_tool_image->resize('no_image.jpg', $imagewidth, $imageheight);
            }

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = false;
            }

            if ((float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $special = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = $result['rating'];
            } else {
                $rating = false;
            }

            $stickers = $this->getStickers($result['product_id']);

            $option_prices = array();

            $this->language->load('myoc/pod');

            $customer_group_id = $this->customer->getCustomerGroupId() ?: '1';

            foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
                $pods_options = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . $option['product_option_id'] . "'")->row;
                foreach ($option['option_value'] as $option_value) {
                    $pods              = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . $option_value['product_option_value_id'] . "'")->rows;
                    $product_discounts = $this->model_catalog_product->getProductDiscounts($result['product_id']);
                    foreach ($pods as $pod) {
                        $customer_group_ids = unserialize($pod['customer_group_ids']);
                        if (!empty($customer_group_ids) && ($customer_group_ids[0] != (string)$customer_group_id)) {
                            continue;
                        }
                        $quantity = $pod['quantity'];
                        if ($result['special']) {
                            $product_base_price = $result['special'];
                        } else {
                            $product_base_price = $result['price'];
                            if ($product_discounts) {
                                foreach ($product_discounts as $product_discount) {
                                    if ($quantity >= $product_discount['quantity']) {
                                        $product_base_price = $product_discount['price'];
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                        if ($pod['calc_method'] === 'o' || $pod['calc_method'] === 'po') {
                            $option_base_price = $option_value['price'];
                            if ($option_value['price_prefix'] === '-') {
                                $option_base_price *= -1;
                            }
                        } else {
                            $option_base_price = 0;
                        }
                        if ($pods_options['flat_rate']) {
                            $option_discount_price   = $pod['price'] / $quantity;
                            $option_discount_special = $pod['special'] / $quantity;
                            $product_total_price     = $product_base_price + ($option_base_price / $quantity);
                        } else {
                            $option_discount_price   = $pod['price'];
                            $option_discount_special = $pod['special'];
                            $product_total_price     = $product_base_price + $option_base_price;
                        }
                        $price_suffix = $special_suffix = '';
                        switch ($pod['price_prefix']) {
                            case '+':
                                $final_price  = $product_total_price + $option_discount_price;
                                $price_prefix = '+';
                                break;
                            case '-':
                                $final_price  = $product_total_price - $option_discount_price;
                                $price_prefix = '-';
                                break;
                            case '=':
                                $final_price  = $option_discount_price;
                                $price_prefix = '';
                                break;
                            case '+%':
                                switch ($pod['calc_method']) {
                                    case 'p':
                                        $final_price = $product_total_price + ($product_base_price * $option_discount_price / 100);
                                        break;
                                    case 'po':
                                        $final_price = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_price / 100);
                                        break;
                                    default: //o
                                        $final_price = $product_total_price + ($option_base_price * $option_discount_price / 100);
                                        break;
                                }
                                $price_prefix = '+';
                                $price_suffix = '%';
                                break;
                            case '-%':
                                switch ($pod['calc_method']) {
                                    case 'p':
                                        $final_price = $product_total_price - ($product_base_price * $option_discount_price / 100);
                                        break;
                                    case 'po':
                                        $final_price = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_price / 100);
                                        break;
                                    default: //o
                                        $final_price = $product_total_price - ($option_base_price * $option_discount_price / 100);
                                        break;
                                }
                                $price_prefix = '-';
                                $price_suffix = '%';
                                break;
                            default:
                                $final_price  = $product_total_price + $option_discount_price;
                                $price_prefix = '+';
                                break;
                        }
                        switch ($pod['special_prefix']) {
                            case '+':
                                $final_special  = $product_total_price + $option_discount_special;
                                $special_prefix = '+';
                                break;
                            case '-':
                                $final_special = $product_total_price - $option_discount_special;
                                if ($option_discount_special === 0) {
                                    $special_prefix = false;
                                } else {
                                    $special_prefix = '-';
                                }
                                break;
                            case '=':
                                $final_special  = $option_discount_special;
                                $special_prefix = '';
                                break;
                            case '+%':
                                switch ($pod['calc_method']) {
                                    case 'p':
                                        $final_special = $product_total_price + ($product_base_price * $option_discount_special / 100);
                                        break;
                                    case 'po':
                                        $final_special = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_special / 100);
                                        break;
                                    default: //o
                                        $final_special = $product_total_price + ($option_base_price * $option_discount_special / 100);
                                        break;
                                }
                                $special_prefix = '+';
                                $special_suffix = '%';
                                break;
                            case '-%':
                                switch ($pod['calc_method']) {
                                    case 'p':
                                        $final_special = $product_total_price - ($product_base_price * $option_discount_special / 100);
                                        break;
                                    case 'po':
                                        $final_special = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_special / 100);
                                        break;
                                    default: //o
                                        $final_special = $product_total_price - ($option_base_price * $option_discount_special / 100);
                                        break;
                                }
                                $special_prefix = '-';
                                $special_suffix = '%';
                                break;
                            default:
                                $final_special  = $product_total_price + $option_discount_special;
                                $special_prefix = '+';
                                break;
                        }
                        if ($pods_options['show_final']) {
                            $raw_price    = $final_price;
                            $price_prefix = $price_suffix = '';
                            $raw_special    = $final_special;
                            $special_prefix = $special_prefix === false ? false : '';
                            $special_suffix = $special_prefix === false ? false : '';
                        } else {
                            $raw_price   = $option_discount_price;
                            $raw_special = $option_discount_special;
                        }
                        $extax       = $this->currency->format($raw_price);
                        $extax_total = $this->currency->format($raw_price * $quantity);
                        if ($price_suffix === '%') {
                            $price       = number_format((float)$raw_price, 2);
                            $extax       = false;
                            $price_total = number_format((float)$raw_price * $quantity, 2);
                            $extax_total = false;
                        } elseif ((float)$raw_price) {
                            $price = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')));
                            if ($pods_options['show_final']) {
                                $price_total = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')) * $quantity);
                            } else {
                                $price_total = $this->currency->format($this->tax->calculate($raw_price * $quantity, $result['tax_class_id'], $this->config->get('config_tax')));
                            }
                        } else {
                            $tax_price = $this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax'));
                            if ($tax_price != 0 && $price_prefix == '-') {
                                $price_prefix = '+';
                            }
                            $price       = $this->currency->format($tax_price);
                            $price_total = $this->currency->format($tax_price * $quantity);
                        }
                        $special_extax       = $this->currency->format($raw_special);
                        $special_extax_total = $this->currency->format($raw_special * $quantity);
                        if ($special_prefix === false || ($pod['date_start'] != '0000-00-00' && $pod['date_start'] > date('Y-m-d')) || ($pod['date_end'] != '0000-00-00' && $pod['date_end'] < date('Y-m-d'))) {
                            $special_price       = false;
                            $special_extax       = false;
                            $special_total       = false;
                            $special_extax_total = false;
                        } elseif ($special_suffix === '%') {
                            $special_price       = number_format((float)$raw_special, 2);
                            $special_extax       = false;
                            $special_total       = number_format((float)$raw_special * $quantity, 2);
                            $special_extax_total = false;
                        } elseif ((float)$raw_special) {
                            $special_price = $this->currency->format($this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax')));
                            if ($pods_options['show_final']) {
                                $special_total = $this->currency->format($this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax')) * $quantity);
                            } else {
                                $special_total = $this->currency->format($this->tax->calculate($raw_special * $quantity, $result['tax_class_id'], $this->config->get('config_tax')));
                            }
                        } else {
                            $tax_special = $this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax'));
                            if ($tax_special != 0 && $special_prefix == '-') {
                                $special_prefix = '+';
                            }
                            $special_price = $this->currency->format($tax_special);
                            $special_total = $this->currency->format($tax_special * $quantity);
                        }
                        if ($pod['special'] !== '0.00') {
                            $option_prices[] = array(
                                'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false, 'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false, 'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false, 'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false, 'special' => ($special_price && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax)) ? $special_prefix . $special_price . $special_suffix : false, 'special_extax' => ($special_price && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax) ? $special_prefix . $special_extax . $special_suffix : false, 'special_total' => ($special_total && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax_total)) ? $special_prefix . $special_total . $special_suffix : false, 'special_extax_total' => ($special_total && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax_total) ? $special_prefix . $special_extax_total . $special_suffix : false,
                            );
                        } else {
                            $option_prices[] = array(
                                'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false, 'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false, 'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false, 'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false
                            );
                        }
                    }
                }
            }
            foreach ($option_prices as $option) {
                if (!isset($option['special'])) {
                    if ($option['price'] <= $price) {
                        $price = $option['price'];
                    }
                    continue;
                }
                if (!$special || $option['special'] <= $special) {
                    $price   = $option['price'];
                    $special = $option['special'];
                }
            }
            $this->data['products'][] = array(
                'product_id' => $result['product_id'],
                'thumb' => $image,
                'name' => $result['name'],
                'price' => $price,
                'special' => $special,
                'rating' => $rating,
                'stickers' => $stickers,
                'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
            );
        }
        $this->data['module'] = $module++;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/recent_view.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/recent_view.tpl';
        } else {
            $this->template = 'default/template/module/recent_view.tpl';
        }
        $this->render();
    }

    public function viewMoreProducts() {
        $this->language->load('module/recent_view');

        $this->data['text_show_more'] = $this->language->get('text_show_more');
        $this->data['button_cart'] = $this->language->get('button_cart');

        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $module = $this->request->get['module'];
        $this->data['module'] = $module;

        $recent_view_module = $this->config->get('recent_view_module');
        $setting = $recent_view_module[$module];

        if (empty($setting['limit'])) {
            $limit = 4;
        } else {
            $limit = $setting['limit'];
        }

        $count = $this->request->get['count'];

        $this->data['limit'] = $limit + $count;
        $this->data['products'] = array();

        $products_ids = array();

        if (isset($this->session->data['product_recent_view'])) {
            $products_ids = array_unique(array_reverse($this->session->data['product_recent_view']));
            $this->data['number_product'] = count($products_ids);
            $products_ids = array_slice($products_ids, (int)$count, (int)$limit);
        }

        $imagewidth = $setting['image_width'];
        $imageheight = $setting['image_height'];

        foreach ($products_ids as $product_id) {
            $result = $this->model_catalog_product->getProduct($product_id);

            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $imagewidth, $imageheight);
            } else {
                $image = false;
            }

            if (!$image) {
                $image = $this->model_tool_image->resize('no_image.jpg', $imagewidth, $imageheight);
            }

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = false;
            }
            if ((float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $special = false;
            }
            if ($this->config->get('config_review_status')) {
                $rating = $result['rating'];
            } else {
                $rating = false;
            }

            $stickers = $this->getStickers($result['product_id']);

            $this->data['products'][] = array(
                'product_id' => $result['product_id'],
                'thumb' => $image,
                'name' => $result['name'],
                'price' => $price,
                'special' => $special,
                'rating' => $rating,
                'stickers' => $stickers,
                'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
            );
        }

        $json = array();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/recent_view_more.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/recent_view_more.tpl';
        } else {
            $this->template = 'default/template/module/recent_view_more.tpl';
        }

        $json['html'] = $this->render();

        $this->response->setOutput(json_encode($json));
    }

    private function getStickers($product_id) {
        $stickers = $this->model_catalog_product->getProductStickerbyProductId($product_id) ;

        if (!$stickers) {
            return;
        }

        $this->data['stickers'] = array();

        foreach ($stickers as $sticker) {
            $this->data['stickers'][] = array(
                'position' => $sticker['position'],
                'image'    => HTTP_SERVER . 'image/' . $sticker['image']
            );
        }


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/stickers.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/stickers.tpl';
        } else {
            $this->template = 'default/template/product/stickers.tpl';
        }

        return $this->render();
    }
}

?>
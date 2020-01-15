<?php

class ControllerProductCategory extends Controller
{

    public function index() {
        $this->language->load('product/category');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
            $this->document->setRobots('noindex,follow');
        } else {
            $filter = '';
        }
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
            $this->document->setRobots('noindex,follow');
        } else {
            $sort = 'p.sort_order';
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        if (isset($this->request->get['coolfilter'])) {
            $coolfilter = $this->request->get['coolfilter'];
            $this->document->setRobots('noindex,follow');
        } else {
            $coolfilter = '';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
            $this->document->setRobots('noindex,follow');
        } else {
            $page = 1;
        }
        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
            $this->document->setRobots('noindex,follow');
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'), 'href' => $this->url->link('common/home'), 'separator' => false
        );
        if (isset($this->request->get['path'])) {
            $url = '';
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            $path = '';
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = (int)array_pop($parts);
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path .= '_' . (int)$path_id;
                }
                $category_info = $this->model_catalog_category->getCategory($path_id);
                if ($category_info || $path_id == 0) {
                    if ($path_id == 0) {
                        $category_info['name'] = $this->language->get('text_all_products');
                    }
                    $this->data['breadcrumbs'][] = array(
                        'text' => $category_info['name'], 'href' => $this->url->link('product/category', 'path=' . $path . $url), 'separator' => $this->language->get('text_separator')
                    );
                }
            }
        } else {
            $category_id = 0;
        }
        $category_info = $this->model_catalog_category->getCategory($category_id);
        if ($category_info || $category_id == 0) {
            if ($category_id == 0) {
                $category_info = array(
                    'name' => $this->language->get('text_all_products'), 'seo_title' => '', 'meta_description' => '', 'meta_keyword' => '', 'seo_h1' => $this->language->get('text_all_products'), 'image' => '', 'description' => ''
                );
                //india style fix
                $this->request->get['path'] = 0;
                //india style fix
            }
            if ($category_info['seo_title']) {
                $this->document->setTitle($category_info['seo_title']);
            } else {
                $this->document->setTitle($category_info['name']);
            }
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
            if ($category_info['seo_h1']) {
                $this->data['heading_title'] = $category_info['seo_h1'];
            } else {
                $this->data['heading_title'] = $category_info['name'];
            }
            $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
            $this->document->addScript('catalog/view/javascript/jquery/jail/jail.min.js');
            $this->data['text_refine'] = $this->language->get('text_refine');
            $this->data['text_empty'] = $this->language->get('text_empty');
            $this->data['text_quantity'] = $this->language->get('text_quantity');
            $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $this->data['text_model'] = $this->language->get('text_model');
            $this->data['text_price'] = $this->language->get('text_price');
            $this->data['text_tax'] = $this->language->get('text_tax');
            $this->data['text_points'] = $this->language->get('text_points');
            $this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $this->data['text_display'] = $this->language->get('text_display');
            $this->data['text_list'] = $this->language->get('text_list');
            $this->data['text_grid'] = $this->language->get('text_grid');
            $this->data['text_sort'] = $this->language->get('text_sort');
            $this->data['text_limit'] = $this->language->get('text_limit');
            $this->data['text_benefits'] = $this->language->get('text_benefits');
            $this->data['button_cart'] = $this->language->get('button_cart');
            $this->data['button_wishlist'] = $this->language->get('button_wishlist');
            $this->data['button_compare'] = $this->language->get('button_compare');
            $this->data['button_continue'] = $this->language->get('button_continue');

            // Set the last category breadcrumb
            $url = '';
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['breadcrumbs'][] = array(
                'text' => $category_info['name'], 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path']), 'separator' => $this->language->get('text_separator')
            );

            if ($category_info['image']) {
                $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                $this->document->setOgImage($this->data['thumb']);
            } else {
                $this->data['thumb'] = '';
            }

            $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->data['description_bottom'] = html_entity_decode($category_info['description_bottom'], ENT_QUOTES, 'UTF-8');
            $this->data['compare'] = $this->url->link('product/compare');

            $url = '';
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $this->data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                $data = array(
                    'filter_category_id' => $result['category_id'],
                    'filter_sub_category' => true,
                    'coolfilter' => $coolfilter
                );

                $product_total = $this->model_catalog_product->getTotalProducts($data);

                $this->data['categories'][] = array(
                    'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                    'count' => $product_total,
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }

            $this->data['products'] = array();

            $data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                'coolfilter' => $coolfilter
            );

            $product_total = $this->model_catalog_product->getTotalProducts($data);

            $results = $this->model_catalog_product->getProducts($data);

            $imagewidth = $this->config->get('config_image_product_width');
            $imageheight = $this->config->get('config_image_product_height');

            foreach ($results as $result) {
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
                    $percent = (int)(100 - $special * 100 / $price);
                } else {
                    $special = false;
                    $percent = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }

                $stickers = $this->getStickers($result['product_id']);

                $this->language->load('product/product');

                $upc_more = (int)$result['upc_more']; // включена галка Имеются товары этой модели с другим ГТД

                if ((int)$result['quantity'] <= 0) {
                    $stock_status = $result['stock_status']; // Нет в наличии
                } elseif ($this->config->get('config_stock_display')) {
                    $stock_status = $result['quantity'];
                } else {
                    $stock_status = $this->language->get('text_instock');
                }

                //ocshop benefits
                $productbenefits = $this->model_catalog_product->getProductBenefitsbyProductId($result['product_id']);
                $benefits = array();
                foreach ($productbenefits as $benefit) {
                    if ($benefit['image'] && file_exists(DIR_IMAGE . $benefit['image'])) {
                        $bimage = $benefit['image'];
                        if ($benefit['type']) {
                            $bimage = $this->model_tool_image->resize($bimage, 25, 25);
                        } else {
                            $bimage = $this->model_tool_image->resize($bimage, 120, 60);
                        }
                    } else {
                        $bimage = 'no_image.jpg';
                    }
                    $benefits[] = array(
                        'benefit_id' => $benefit['benefit_id'],
                        'name' => $benefit['name'],
                        'description' => strip_tags(html_entity_decode($benefit['description'])),
                        'thumb' => $bimage,
                        'link' => $benefit['link'],
                        'type' => $benefit['type']
                        //'sort_order' => $benefit['sort_order']
                    );
                }

                $option_prices = array();

                $this->language->load('myoc/pod');

                $customer_group_id = $this->customer->getCustomerGroupId() ?: '1';

                foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
                    $pods_options = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . $option['product_option_id'] . "'")->row;
                    foreach ($option['option_value'] as $option_value) {
                        $pods = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . $option_value['product_option_value_id'] . "'")->rows;

                        $product_discounts = $this->model_catalog_product->getProductDiscounts($result['product_id']);

                        foreach ($pods as $pod) {
                            $customer_group_ids = unserialize($pod['customer_group_ids']);

                            if ((!empty($customer_group_ids)) && ($customer_group_ids[0] != (string)$customer_group_id)) {
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
                            if ($pod['special'] !== '0.0000') {
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
                //ocshop benefits
                $this->data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'thumbwidth' => $imagewidth,
                    'thumbheight' => $imageheight,
                    'name' => $result['name'],
                    'stock_status' => $stock_status,
                    'not_in_stock' => $stock_status != $this->language->get('text_instock'),
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
                    'description_mini' => html_entity_decode($result['description_mini']),
                    'price' => $price,
                    'special' => $special,
                    'percent' => $percent,
                    'tax' => $tax,
                    'rating' => $rating,
                    'sticker' => $stickers,
                    'benefits' => $benefits,
                    'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                    'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
                );
            }

            $url = '';
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            $this->data['sorts'] = array();

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_default'), 'value' => 'p.sort_order-ASC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'), 'value' => 'pd.name-ASC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'), 'value' => 'pd.name-DESC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'), 'value' => 'p.price-ASC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'), 'value' => 'p.price-DESC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );

            if ($this->config->get('config_review_status')) {
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'), 'value' => 'rating-DESC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'), 'value' => 'rating-ASC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'), 'value' => 'p.model-ASC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
            );

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'), 'value' => 'p.model-DESC', 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
            );

            $url = '';
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            $this->data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $this->data['limits'][] = array(
                    'text' => $value, 'value' => $value, 'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
            }

            $url = '';
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            if (isset($this->request->get['coolfilter'])) {
                $url .= '&coolfilter=' . $this->request->get['coolfilter'];
            }

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
            $this->data['pagination'] = $pagination->render();
            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
            $this->data['limit'] = $limit;
            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/product/category.tpl';
            } else {
                $this->template = 'default/template/product/category.tpl';
            }

            $this->children = array(
                'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header'
            );
            $this->response->setOutput($this->render());
        } else {
            $url = '';
            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'), 'href' => $this->url->link('product/category', $url), 'separator' => $this->language->get('text_separator')
            );
            $this->document->setTitle($this->language->get('text_error'));
            $this->data['heading_title'] = $this->language->get('text_error');
            $this->data['text_error'] = $this->language->get('text_error');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['continue'] = $this->url->link('common/home');
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
            }
            $this->children = array(
                'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/podval', 'common/footer', 'common/header'
            );
            $this->response->setOutput($this->render());
        }
    }

    private function getStickers($product_id) {
        $stickers = $this->model_catalog_product->getProductStickerbyProductId($product_id);
        if (!$stickers) {
            return;
        }
        $this->data['stickers'] = array();
        foreach ($stickers as $sticker) {
            $this->data['stickers'][] = array(
                'position' => $sticker['position'], 'image' => HTTP_SERVER . 'image/' . $sticker['image']
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
<?php
class ControllerProductSearch extends Controller
{
    public function index() {
        $this->language->load('product/search');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        if (isset($this->request->get['search'])) {
            $search = $this->request->get['search'];
        }
        else {
            $search = '';
        }

        if (isset($this->request->get['tag'])) {
            $tag = $this->request->get['tag'];
        }
        elseif (isset($this->request->get['search'])) {
            $tag = $this->request->get['search'];
        }
        else {
            $tag = '';
        }

        if (isset($this->request->get['description'])) {
            $description = $this->request->get['description'];
        }
        else {
            $description = '';
        }

        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        }
        else {
            $category_id = 0;
        }

        if (isset($this->request->get['sub_category'])) {
            $sub_category = $this->request->get['sub_category'];
        }
        else {
            $sub_category = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        }
        else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        }
        else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        }
        else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        }
        else {
            $limit = $this->config->get('config_catalog_limit');
        }

        if (isset($this->request->get['search'])) {
            $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['search']);
        }
        else {
            $this->document->setTitle($this->language->get('heading_title'));
        }

        $this->document->setRobots('noindex,follow');
        $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
        $this->document->addScript('catalog/view/javascript/jquery/jail/jail.min.js');
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home') ,
            'href' => $this->url->link('common/home') ,
            'separator' => false
        );

        $url = '';
        if (isset($this->request->get['search'])) {
            $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['tag'])) {
            $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['description'])) {
            $url.= '&description=' . $this->request->get['description'];
        }

        if (isset($this->request->get['category_id'])) {
            $url.= '&category_id=' . $this->request->get['category_id'];
        }

        if (isset($this->request->get['sub_category'])) {
            $url.= '&sub_category=' . $this->request->get['sub_category'];
        }

        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url.= '&limit=' . $this->request->get['limit'];
        }

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title') ,
            'href' => $this->url->link('product/search', $url) ,
            'separator' => $this->language->get('text_separator')
        );

        if (isset($this->request->get['search'])) {
            $this->data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['search'];
        }
        else {
            $this->data['heading_title'] = $this->language->get('heading_title');
        }

        $this->document->setRobots('noindex,follow');
        $this->data['text_empty'] = $this->language->get('text_empty');
        $this->data['text_critea'] = $this->language->get('text_critea');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_keyword'] = $this->language->get('text_keyword');
        $this->data['text_category'] = $this->language->get('text_category');
        $this->data['text_sub_category'] = $this->language->get('text_sub_category');
        $this->data['text_quantity'] = $this->language->get('text_quantity');
        $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $this->data['text_model'] = $this->language->get('text_model');
        $this->data['text_price'] = $this->language->get('text_price');
        $this->data['text_tax'] = $this->language->get('text_tax');
        $this->data['text_points'] = $this->language->get('text_points');
        $this->data['text_compare'] = sprintf($this->language->get('text_compare') , (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        $this->data['text_display'] = $this->language->get('text_display');
        $this->data['text_list'] = $this->language->get('text_list');
        $this->data['text_grid'] = $this->language->get('text_grid');
        $this->data['text_sort'] = $this->language->get('text_sort');
        $this->data['text_limit'] = $this->language->get('text_limit');
        $this->data['text_benefits'] = $this->language->get('text_benefits');
        $this->data['entry_search'] = $this->language->get('entry_search');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['button_search'] = $this->language->get('button_search');
        $this->data['button_cart'] = $this->language->get('button_cart');
        $this->data['button_wishlist'] = $this->language->get('button_wishlist');
        $this->data['button_compare'] = $this->language->get('button_compare');
        $this->data['compare'] = $this->url->link('product/compare');
        $this->load->model('catalog/category');

        // 3 Level Category Search

        $this->data['categories'] = array();
        $categories_1 = $this->model_catalog_category->getCategories(0);
        foreach($categories_1 as $category_1) {
            $level_2_data = array();
            $categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
            foreach($categories_2 as $category_2) {
                $level_3_data = array();
                $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
                foreach($categories_3 as $category_3) {
                    $level_3_data[] = array(
                        'category_id' => $category_3['category_id'],
                        'name' => $category_3['name'],
                    );
                }

                $level_2_data[] = array(
                    'category_id' => $category_2['category_id'],
                    'name' => $category_2['name'],
                    'children' => $level_3_data
                );
            }

            $this->data['categories'][] = array(
                'category_id' => $category_1['category_id'],
                'name' => $category_1['name'],
                'children' => $level_2_data
            );
        }

        $this->data['products'] = array();
        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $data = array(
                'filter_name' => $search,
                'filter_tag' => $tag,
                'filter_description' => $description,
                'filter_category_id' => $category_id,
                'filter_sub_category' => $sub_category,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );
            $product_total = $this->model_catalog_product->getTotalProducts($data);
            $results = $this->model_catalog_product->getProducts($data);
            $imagewidth = $this->config->get('config_image_product_width');
            $imageheight = $this->config->get('config_image_product_height');
            foreach($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $imagewidth, $imageheight);
                }
                else {
                    $image = false;
                }

                if (!$image) {
                    $image = $this->model_tool_image->resize('no_image.jpg', $imagewidth, $imageheight);
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                }
                else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                }
                else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                }
                else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                }
                else {
                    $rating = false;
                }

                $stickers = $this->getStickers($result['product_id']);

                // ocshop benefits

                $productbenefits = $this->model_catalog_product->getProductBenefitsbyProductId($result['product_id']);
                $benefits = array();
                foreach($productbenefits as $benefit) {
                    if ($benefit['image'] && file_exists(DIR_IMAGE . $benefit['image'])) {
                        $bimage = $benefit['image'];
                        if ($benefit['type']) {
                            $bimage = $this->model_tool_image->resize($bimage, 25, 25);
                        }
                        else {
                            $bimage = $this->model_tool_image->resize($bimage, 120, 60);
                        }
                    }
                    else {
                        $bimage = 'no_image.jpg';
                    }

                    $benefits[] = array(
                        'benefit_id' => $benefit['benefit_id'],
                        'name' => $benefit['name'],
                        'description' => strip_tags(html_entity_decode($benefit['description'])) ,
                        'thumb' => $bimage,
                        'link' => $benefit['link'],
                        'type' => $benefit['type']

                        // 'sort_order' => $benefit['sort_order']

                    );
                }

                $option_prices = array();
                $this->language->load('myoc/pod');
                $customer_group_id = $this->customer->getCustomerGroupId() ? : '1';
                foreach($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
                    $pods_options = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . $option['product_option_id'] . "'")->row;
                    foreach($option['option_value'] as $option_value) {
                        $pods = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . $option_value['product_option_value_id'] . "'")->rows;
                        $product_discounts = $this->model_catalog_product->getProductDiscounts($result['product_id']);
                        foreach($pods as $pod) {
                            $customer_group_ids = unserialize($pod['customer_group_ids']);

                            if (empty($customer_group_ids) || $customer_group_ids[0] != (string)$customer_group_id) {
                                continue;
                            }

                            $quantity = $pod['quantity'];
                            if ($result['special']) {
                                $product_base_price = $result['special'];
                            }
                            else {
                                $product_base_price = $result['price'];
                                if ($product_discounts) {
                                    foreach($product_discounts as $product_discount) {
                                        if ($quantity >= $product_discount['quantity']) {
                                            $product_base_price = $product_discount['price'];
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                }
                            }

                            if ($pod['calc_method'] === 'o' || $pod['calc_method'] === 'po') {
                                $option_base_price = $option_value['price'];
                                if ($option_value['price_prefix'] === '-') {
                                    $option_base_price*= - 1;
                                }
                            }
                            else {
                                $option_base_price = 0;
                            }

                            if ($pods_options['flat_rate']) {
                                $option_discount_price = $pod['price'] / $quantity;
                                $option_discount_special = $pod['special'] / $quantity;
                                $product_total_price = $product_base_price + ($option_base_price / $quantity);
                            }
                            else {
                                $option_discount_price = $pod['price'];
                                $option_discount_special = $pod['special'];
                                $product_total_price = $product_base_price + $option_base_price;
                            }

                            $price_suffix = $special_suffix = '';
                            switch ($pod['price_prefix']) {
                                case '+':
                                    $final_price = $product_total_price + $option_discount_price;
                                    $price_prefix = '+';
                                    break;

                                case '-':
                                    $final_price = $product_total_price - $option_discount_price;
                                    $price_prefix = '-';
                                    break;

                                case '=':
                                    $final_price = $option_discount_price;
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
                                    $final_price = $product_total_price + $option_discount_price;
                                    $price_prefix = '+';
                                    break;
                            }

                            switch ($pod['special_prefix']) {
                                case '+':
                                    $final_special = $product_total_price + $option_discount_special;
                                    $special_prefix = '+';
                                    break;

                                case '-':
                                    $final_special = $product_total_price - $option_discount_special;
                                    if ($option_discount_special === 0) {
                                        $special_prefix = false;
                                    }
                                    else {
                                        $special_prefix = '-';
                                    }

                                    break;

                                case '=':
                                    $final_special = $option_discount_special;
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
                                    $final_special = $product_total_price + $option_discount_special;
                                    $special_prefix = '+';
                                    break;
                            }

                            if ($pods_options['show_final']) {
                                $raw_price = $final_price;
                                $price_prefix = $price_suffix = '';
                                $raw_special = $final_special;
                                $special_prefix = $special_prefix === false ? false : '';
                                $special_suffix = $special_prefix === false ? false : '';
                            }
                            else {
                                $raw_price = $option_discount_price;
                                $raw_special = $option_discount_special;
                            }

                            $extax = $this->currency->format($raw_price);
                            $extax_total = $this->currency->format($raw_price * $quantity);
                            if ($price_suffix === '%') {
                                $price = number_format((float)$raw_price, 2);
                                $extax = false;
                                $price_total = number_format((float)$raw_price * $quantity, 2);
                                $extax_total = false;
                            }
                            elseif ((float)$raw_price) {
                                $price = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')));
                                if ($pods_options['show_final']) {
                                    $price_total = $this->currency->format($this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax')) * $quantity);
                                }
                                else {
                                    $price_total = $this->currency->format($this->tax->calculate($raw_price * $quantity, $result['tax_class_id'], $this->config->get('config_tax')));
                                }
                            }
                            else {
                                $tax_price = $this->tax->calculate($raw_price, $result['tax_class_id'], $this->config->get('config_tax'));
                                if ($tax_price != 0 && $price_prefix == '-') {
                                    $price_prefix = '+';
                                }

                                $price = $this->currency->format($tax_price);
                                $price_total = $this->currency->format($tax_price * $quantity);
                            }

                            $special_extax = $this->currency->format($raw_special);
                            $special_extax_total = $this->currency->format($raw_special * $quantity);
                            if ($special_prefix === false || ($pod['date_start'] != '0000-00-00' && $pod['date_start'] > date('Y-m-d')) || ($pod['date_end'] != '0000-00-00' && $pod['date_end'] < date('Y-m-d'))) {
                                $special_price = false;
                                $special_extax = false;
                                $special_total = false;
                                $special_extax_total = false;
                            }
                            elseif ($special_suffix === '%') {
                                $special_price = number_format((float)$raw_special, 2);
                                $special_extax = false;
                                $special_total = number_format((float)$raw_special * $quantity, 2);
                                $special_extax_total = false;
                            }
                            elseif ((float)$raw_special) {
                                $special_price = $this->currency->format($this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax')));
                                if ($pods_options['show_final']) {
                                    $special_total = $this->currency->format($this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax')) * $quantity);
                                }
                                else {
                                    $special_total = $this->currency->format($this->tax->calculate($raw_special * $quantity, $result['tax_class_id'], $this->config->get('config_tax')));
                                }
                            }
                            else {
                                $tax_special = $this->tax->calculate($raw_special, $result['tax_class_id'], $this->config->get('config_tax'));
                                if ($tax_special != 0 && $special_prefix == '-') {
                                    $special_prefix = '+';
                                }

                                $special_price = $this->currency->format($tax_special);
                                $special_total = $this->currency->format($tax_special * $quantity);
                            }

                            if ($pod['special'] !== '0.0000') {
                                $option_prices[] = array(
                                    'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false,
                                    'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false,
                                    'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false,
                                    'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false,
                                    'special' => ($special_price && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax)) ? $special_prefix . $special_price . $special_suffix : false,
                                    'special_extax' => ($special_price && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax) ? $special_prefix . $special_extax . $special_suffix : false,
                                    'special_total' => ($special_total && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax_total)) ? $special_prefix . $special_total . $special_suffix : false,
                                    'special_extax_total' => ($special_total && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax_total) ? $special_prefix . $special_extax_total . $special_suffix : false,
                                );
                            }
                            else {
                                $option_prices[] = array(
                                    'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false,
                                    'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false,
                                    'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false,
                                    'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false
                                );
                            }
                        }
                    }
                }

                foreach($option_prices as $option) {
                    if (!isset($option['special'])) {
                        if ($option['price'] <= $price) {
                            $price = $option['price'];
                        }

                        continue;
                    }

                    if (!$special || $option['special'] <= $special) {
                        $price = $option['price'];
                        $special = $option['special'];
                    }
                }

                // ocshop benefits

                $this->data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'thumbwidth' => $imagewidth,
                    'thumbheight' => $imageheight,
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')) , 0, 300) . '..',
                    'description_mini' => html_entity_decode($result['description_mini']) ,
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'rating' => $rating,
                    'sticker' => $stickers,
                    'benefits' => $benefits,
                    'reviews' => sprintf($this->language->get('text_reviews') , (int)$result['reviews']) ,
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
                );
            }

            $url = '';
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }

            $this->data['sorts'] = array();
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_default') ,
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url)
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc') ,
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url)
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc') ,
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url)
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc') ,
                'value' => 'p.price-ASC',
                'href' => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url)
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc') ,
                'value' => 'p.price-DESC',
                'href' => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url)
            );
            if ($this->config->get('config_review_status')) {
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc') ,
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
                );
                $this->data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc') ,
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/search', 'sort=rating&order=ASC' . $url)
                );
            }

            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc') ,
                'value' => 'p.model-ASC',
                'href' => $this->url->link('product/search', 'sort=p.model&order=ASC' . $url)
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc') ,
                'value' => 'p.model-DESC',
                'href' => $this->url->link('product/search', 'sort=p.model&order=DESC' . $url)
            );
            $url = '';
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }

            $this->data['limits'] = array();
            $limits = array_unique(array(
                                       $this->config->get('config_catalog_limit') ,
                                       25,
                                       50,
                                       75,
                                       100
                                   ));
            sort($limits);
            foreach($limits as $value) {
                $this->data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/search', $url . '&limit=' . $value)
                );
            }

            $url = '';
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url.= '&limit=' . $this->request->get['limit'];
            }

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('product/search', $url . '&page={page}');
            $this->data['pagination'] = $pagination->render();
        }

        $this->data['search'] = $search;
        $this->data['description'] = $description;
        $this->data['category_id'] = $category_id;
        $this->data['sub_category'] = $sub_category;
        $this->data['sort'] = $sort;
        $this->data['order'] = $order;
        $this->data['limit'] = $limit;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/search.tpl';
        }
        else {
            $this->template = 'default/template/product/search.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );
        $this->response->setOutput($this->render());
    }

    private function getStickers($product_id) {
        $stickers = $this->model_catalog_product->getProductStickerbyProductId($product_id);
        if (!$stickers) {
            return;
        }

        $this->data['stickers'] = array();
        foreach($stickers as $sticker) {
            $this->data['stickers'][] = array(
                'position' => $sticker['position'],
                'image' => HTTP_SERVER . 'image/' . $sticker['image']
            );
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/stickers.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/stickers.tpl';
        }
        else {
            $this->template = 'default/template/product/stickers.tpl';
        }

        return $this->render();
    }
}
?>
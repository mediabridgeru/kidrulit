<?php

class ControllerProductXlsPricelist extends Controller
{

    var $f_image = '';
    var $f_model = '';
    var $f_name = '';
    var $f_stock = '';
    var $f_price = '';
    var $f_special = '';

    var $delim = 0;
    var $l_margin = 0;
    var $xls_pricelist_store = array();
    var $xls_pricelist_category = array();
    var $xls_pricelist_use_image = '';
    var $xls_pricelist_image_width = 50;
    var $xls_pricelist_image_height = 50;
    var $xls_pricelist_title = '';
    var $xls_pricelist_adress = '';
    var $xls_pricelist_phone = '';
    var $xls_pricelist_email = '';
    var $xls_pricelist_link = '';
    var $xls_pricelist_custom_text = '';
    var $xls_pricelist_title_color = '';
    var $xls_pricelist_adress_color = '';
    var $xls_pricelist_phone_color = '';
    var $xls_pricelist_email_color = '';
    var $xls_pricelist_link_color = '';
    var $xls_pricelist_custom_color = '';
    var $xls_pricelist_sort_order = '';
    var $xls_pricelist_currency = '';
    var $xls_pricelist_customer_group = '';
    var $xls_pricelist_attribute_group = '';
    var $xls_pricelist_listname = '';
    var $xls_pricelist_use_options = '';
    var $xls_pricelist_use_attributes = '';
    var $xls_pricelist_nodubles = '';
    var $xls_pricelist_use_quantity = '';
    var $xls_pricelist_use_notinstock = '';
    var $xls_pricelist_language = '';
    var $xls_pricelist_usecache = 'no';
    var $xls_pricelist_memcacheServer = 'localhost';
    var $xls_pricelist_memcachePort = 11211;
    var $xls_pricelist_cacheTime = 600;
    var $xls_pricelist_use_special = '';
    var $xls_pricelist_use_code = '';
    var $xls_pricelist_code = '';
    var $xls_pricelist_model_width = '';
    var $xls_pricelist_name_width = '';
    var $xls_pricelist_stock_width = '';
    var $xls_pricelist_price_width = '';
    var $xls_pricelist_special_width = '';

    var $xls_pricelist_logo = '';
    var $xls_pricelist_logo_width = '';
    var $xls_pricelist_logo_height = '';
    var $xls_pricelist_use_collapse = 0;
    var $xls_pricelist_use_protection = 0;
    var $xls_pricelist_use_password = '';

    var $xls_pricelist_thead_color = '';
    var $xls_pricelist_thead_color_bg = '';
    var $xls_pricelist_underthead_color_bg = '';
    var $xls_pricelist_category0_color = '';
    var $xls_pricelist_category0_color_bg = '';
    var $xls_pricelist_category1_color = '';
    var $xls_pricelist_category1_color_bg = '';
    var $xls_pricelist_category2_color = '';
    var $xls_pricelist_category2_color_bg = '';

    var $xls_pricelist_image_color_bg = '';
    var $xls_pricelist_model_color = '';
    var $xls_pricelist_model_color_bg = '';
    var $xls_pricelist_name_color = '';
    var $xls_pricelist_name_color_bg = '';
    var $xls_pricelist_stock_color = '';
    var $xls_pricelist_stock_color_bg = '';
    var $xls_pricelist_price_color = '';
    var $xls_pricelist_price_color_bg = '';
    var $xls_pricelist_special_color = '';
    var $xls_pricelist_special_color_bg = '';

    var $customer_groups = array();

    var $LNG = array();

    public function index() {

        $json = array();

        $action = 'view';
        if (isset($this->request->post['action'])) {
            $action = $this->request->post['action'];
        } elseif (isset($this->request->get['action'])) {
            $action = $this->request->get['action'];
        }

        if (!$this->config->get('xls_pricelist_view')) {
            if ($action != 'generate' && $action != 'upload') {
                $this->redirect($this->url->link('error/not_found'));
            }
        }

        $this->xls_pricelist_usecache        = $this->config->get('xls_pricelist_usecache');
        $this->xls_pricelist_memcacheServer  = $this->config->get('xls_pricelist_memcacheServer');
        $this->xls_pricelist_memcachePort    = $this->config->get('xls_pricelist_memcachePort');
        $this->xls_pricelist_cacheTime       = $this->config->get('xls_pricelist_cacheTime');
        $this->xls_pricelist_sort_order      = $this->config->get('xls_pricelist_sort_order');
        $this->xls_pricelist_customer_group  = $this->config->get('xls_pricelist_customer_group');
        $this->xls_pricelist_attribute_group = $this->config->get('xls_pricelist_attribute_group');
        $this->xls_pricelist_category        = $this->config->get('xls_pricelist_category');
        $this->xls_pricelist_store           = $this->config->get('xls_pricelist_store');
        $this->xls_pricelist_use_image       = $this->config->get('xls_pricelist_use_image');
        $this->xls_pricelist_use_options     = $this->config->get('xls_pricelist_use_options');
        $this->xls_pricelist_use_attributes  = $this->config->get('xls_pricelist_use_attributes');
        $this->xls_pricelist_nodubles        = $this->config->get('xls_pricelist_nodubles');

        $this->xls_pricelist_use_quantity   = $this->config->get('xls_pricelist_use_quantity');
        $this->xls_pricelist_use_notinstock = $this->config->get('xls_pricelist_use_notinstock');
        $this->xls_pricelist_image_width    = $this->config->get('xls_pricelist_image_width');
        $this->xls_pricelist_image_height   = $this->config->get('xls_pricelist_image_height');
        $this->xls_pricelist_use_special    = $this->config->get('xls_pricelist_use_special');
        $this->xls_pricelist_use_code       = $this->config->get('xls_pricelist_use_code');
        $this->xls_pricelist_code           = $this->config->get('xls_pricelist_code');
        $this->xls_pricelist_model_width    = $this->config->get('xls_pricelist_model_width');
        $this->xls_pricelist_name_width     = $this->config->get('xls_pricelist_name_width');
        $this->xls_pricelist_stock_width    = $this->config->get('xls_pricelist_stock_width');
        $this->xls_pricelist_price_width    = $this->config->get('xls_pricelist_price_width');
        $this->xls_pricelist_special_width  = $this->config->get('xls_pricelist_special_width');
        $this->xls_pricelist_logo           = $this->config->get('xls_pricelist_logo');
        $this->xls_pricelist_logo_width     = $this->config->get('xls_pricelist_logo_width');
        $this->xls_pricelist_logo_height    = $this->config->get('xls_pricelist_logo_height');
        $this->xls_pricelist_use_collapse   = $this->config->get('xls_pricelist_use_collapse');
        $this->xls_pricelist_use_protection = $this->config->get('xls_pricelist_use_protection');
        $this->xls_pricelist_use_password   = $this->config->get('xls_pricelist_use_password');

        $xls_pricelist_description = $this->config->get('xls_pricelist_description');
        $xls_pricelist_colors      = $this->config->get('xls_pricelist_colors');

        $this->xls_pricelist_thead_color         = $xls_pricelist_colors['thead'];
        $this->xls_pricelist_thead_color_bg      = $xls_pricelist_colors['thead_bg'];
        $this->xls_pricelist_underthead_color_bg = $xls_pricelist_colors['underthead_bg'];
        $this->xls_pricelist_category0_color     = $xls_pricelist_colors['category0'];
        $this->xls_pricelist_category0_color_bg  = $xls_pricelist_colors['category0_bg'];
        $this->xls_pricelist_category1_color     = $xls_pricelist_colors['category1'];
        $this->xls_pricelist_category1_color_bg  = $xls_pricelist_colors['category1_bg'];
        $this->xls_pricelist_category2_color     = $xls_pricelist_colors['category2'];
        $this->xls_pricelist_category2_color_bg  = $xls_pricelist_colors['category2_bg'];

        $this->xls_pricelist_image_color_bg   = $xls_pricelist_colors['image_bg'];
        $this->xls_pricelist_model_color      = $xls_pricelist_colors['model'];
        $this->xls_pricelist_model_color_bg   = $xls_pricelist_colors['model_bg'];
        $this->xls_pricelist_name_color       = $xls_pricelist_colors['name'];
        $this->xls_pricelist_name_color_bg    = $xls_pricelist_colors['name_bg'];
        $this->xls_pricelist_stock_color      = $xls_pricelist_colors['stock'];
        $this->xls_pricelist_stock_color_bg   = $xls_pricelist_colors['stock_bg'];
        $this->xls_pricelist_price_color      = $xls_pricelist_colors['price'];
        $this->xls_pricelist_price_color_bg   = $xls_pricelist_colors['price_bg'];
        $this->xls_pricelist_special_color    = $xls_pricelist_colors['special'];
        $this->xls_pricelist_special_color_bg = $xls_pricelist_colors['special_bg'];

        $this->load->model('xls_pricelist/helper_models');
        $customer_groups = array();
        $groups          = $this->model_xls_pricelist_helper_models->getCustomerGroups();
        foreach ($groups as $customer_group) {
            $customer_groups[$customer_group['customer_group_id']] = serialize(array($customer_group['customer_group_id']));
        }
        $this->customer_groups = $customer_groups;

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language) {
            //if($language['language_id']==1)continue;
            $this->xls_pricelist_currency     = $xls_pricelist_description[$language['language_id']]['currency'];
            $this->xls_pricelist_title        = $xls_pricelist_description[$language['language_id']]['title'];
            $this->xls_pricelist_adress       = $xls_pricelist_description[$language['language_id']]['adress'];
            $this->xls_pricelist_phone        = $xls_pricelist_description[$language['language_id']]['phone'];
            $this->xls_pricelist_email        = $xls_pricelist_description[$language['language_id']]['email'];
            $this->xls_pricelist_link         = $xls_pricelist_description[$language['language_id']]['link'];
            $this->xls_pricelist_custom_text  = $xls_pricelist_description[$language['language_id']]['custom_text'];
            $this->xls_pricelist_title_color  = $xls_pricelist_description[$language['language_id']]['title_color'];
            $this->xls_pricelist_adress_color = $xls_pricelist_description[$language['language_id']]['adress_color'];
            $this->xls_pricelist_phone_color  = $xls_pricelist_description[$language['language_id']]['phone_color'];
            $this->xls_pricelist_email_color  = $xls_pricelist_description[$language['language_id']]['email_color'];
            $this->xls_pricelist_link_color   = $xls_pricelist_description[$language['language_id']]['link_color'];
            $this->xls_pricelist_custom_color = $xls_pricelist_description[$language['language_id']]['custom_color'];
            $this->xls_pricelist_listname     = $xls_pricelist_description[$language['language_id']]['listname'];
            $this->xls_pricelist_language     = $language;

            if ($action == 'generate') {
                $this->generate();
            } elseif ($action == 'upload') {
                $this->upload();
            } elseif ($action == 'view') {
                $this->generate('view');
            }

            $json['success'] = 1;
        }

        if (isset($json['success']) && $json['success'])
            $this->response->setOutput(json_encode($json));
    }

    public function view() {

        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $this->redirect($this->url->link('error/not_found'));
        }

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->request->post['action'] != 'generate') {
                $this->redirect($this->url->link('error/not_found'));
            }
        }

        if (isset($this->request->post['xls_pricelist_store'])) {
            $this->xls_pricelist_store = implode('_', $this->request->post['xls_pricelist_store']);
        } else {
            $this->xls_pricelist_store = $this->config->get('xls_pricelist_store');
        }

        if (isset($this->request->post['xls_pricelist_category'])) {
            $this->xls_pricelist_category = implode('_', $this->request->post['xls_pricelist_category']);
        } else {
            $this->xls_pricelist_category = $this->config->get('xls_pricelist_category');
        }
        if (isset($this->request->post['xls_pricelist_use_image'])) {
            $this->xls_pricelist_use_image = $this->request->post['xls_pricelist_use_image'];
        } else {
            $this->xls_pricelist_use_image = $this->config->get('xls_pricelist_use_image');
        }
        if (isset($this->request->post['xls_pricelist_use_options'])) {
            $this->xls_pricelist_use_options = $this->request->post['xls_pricelist_use_options'];
        } else {
            $this->xls_pricelist_use_options = $this->config->get('xls_pricelist_use_options');
        }
        if (isset($this->request->post['xls_pricelist_use_attributes'])) {
            $this->xls_pricelist_use_attributes = $this->request->post['xls_pricelist_use_attributes'];
        } else {
            $this->xls_pricelist_use_attributes = $this->config->get('xls_pricelist_use_attributes');
        }
        if (isset($this->request->post['xls_pricelist_nodubles'])) {
            $this->xls_pricelist_nodubles = $this->request->post['xls_pricelist_nodubles'];
        } else {
            $this->xls_pricelist_nodubles = $this->config->get('xls_pricelist_nodubles');
        }

        if (isset($this->request->post['xls_pricelist_use_quantity'])) {
            $this->xls_pricelist_use_quantity = $this->request->post['xls_pricelist_use_quantity'];
        } else {
            $this->xls_pricelist_use_quantity = $this->config->get('xls_pricelist_use_quantity');
        }

        if (isset($this->request->post['xls_pricelist_use_special'])) {
            $this->xls_pricelist_use_special = $this->request->post['xls_pricelist_use_special'];
        } else {
            $this->xls_pricelist_use_special = $this->config->get('xls_pricelist_use_special');
        }

        if (isset($this->request->post['xls_pricelist_use_code'])) {
            $this->xls_pricelist_use_code = $this->request->post['xls_pricelist_use_code'];
        } else {
            $this->xls_pricelist_use_code = $this->config->get('xls_pricelist_use_code');
        }

        if (isset($this->request->post['xls_pricelist_code'])) {
            $this->xls_pricelist_code = $this->request->post['xls_pricelist_code'];
        } else {
            $this->xls_pricelist_code = $this->config->get('xls_pricelist_code');
        }

        if (isset($this->request->post['xls_pricelist_use_collapse'])) {
            $this->xls_pricelist_use_collapse = $this->request->post['xls_pricelist_use_collapse'];
        } else {
            $this->xls_pricelist_use_collapse = $this->config->get('xls_pricelist_use_collapse');
        }

        if (isset($this->request->post['xls_pricelist_use_protection'])) {
            $this->xls_pricelist_use_protection = $this->request->post['xls_pricelist_use_protection'];
        } else {
            $this->xls_pricelist_use_protection = $this->config->get('xls_pricelist_use_protection');
        }

        if (isset($this->request->post['xls_pricelist_use_password'])) {
            $this->xls_pricelist_use_password = $this->request->post['xls_pricelist_use_password'];
        } else {
            $this->xls_pricelist_use_password = $this->config->get('xls_pricelist_use_password');
        }

        if (isset($this->request->post['xls_pricelist_model_width'])) {
            $this->xls_pricelist_model_width = (int)$this->request->post['xls_pricelist_model_width'] ? $this->request->post['xls_pricelist_model_width'] : 15;
        } else {
            $this->xls_pricelist_model_width = $this->config->get('xls_pricelist_model_width');
        }

        if (isset($this->request->post['xls_pricelist_name_width'])) {
            $this->xls_pricelist_name_width = (int)$this->request->post['xls_pricelist_name_width'] ? $this->request->post['xls_pricelist_name_width'] : 75;
        } else {
            $this->xls_pricelist_name_width = $this->config->get('xls_pricelist_name_width');
        }

        if (isset($this->request->post['xls_pricelist_stock_width'])) {
            $this->xls_pricelist_stock_width = (int)$this->request->post['xls_pricelist_stock_width'] ? $this->request->post['xls_pricelist_stock_width'] : 15;
        } else {
            $this->xls_pricelist_stock_width = $this->config->get('xls_pricelist_stock_width');
        }

        if (isset($this->request->post['xls_pricelist_price_width'])) {
            $this->xls_pricelist_price_width = (int)$this->request->post['xls_pricelist_price_width'] ? $this->request->post['xls_pricelist_price_width'] : 15;
        } else {
            $this->xls_pricelist_price_width = $this->config->get('xls_pricelist_price_width');
        }

        if (isset($this->request->post['xls_pricelist_special_width'])) {
            $this->xls_pricelist_special_width = (int)$this->request->post['xls_pricelist_special_width'] ? $this->request->post['xls_pricelist_special_width'] : 15;
        } else {
            $this->xls_pricelist_special_width = $this->config->get('xls_pricelist_special_width');
        }

        if (isset($this->request->post['xls_pricelist_use_notinstock'])) {
            $this->xls_pricelist_use_notinstock = $this->request->post['xls_pricelist_use_notinstock'];
        } else {
            $this->xls_pricelist_use_notinstock = $this->config->get('xls_pricelist_use_notinstock');
        }

        if (isset($this->request->post['xls_pricelist_usecache'])) {
            $this->xls_pricelist_usecache = $this->request->post['xls_pricelist_usecache'];
        } else {
            $this->xls_pricelist_usecache = $this->config->get('xls_pricelist_usecache');
        }

        if (isset($this->request->post['xls_pricelist_memcacheServer'])) {
            $this->xls_pricelist_memcacheServer = $this->request->post['xls_pricelist_memcacheServer'] ? $this->request->post['xls_pricelist_memcacheServer'] : 'localhost';
        } else {
            $this->xls_pricelist_memcacheServer = $this->config->get('xls_pricelist_memcacheServer');
        }

        if (isset($this->request->post['xls_pricelist_memcachePort'])) {
            $this->xls_pricelist_memcachePort = (int)$this->request->post['xls_pricelist_memcachePort'] ? $this->request->post['xls_pricelist_memcachePort'] : 11211;
        } else {
            $this->xls_pricelist_memcachePort = $this->config->get('xls_pricelist_memcachePort');
        }

        if (isset($this->request->post['xls_pricelist_cacheTime'])) {
            $this->xls_pricelist_cacheTime = (int)$this->request->post['xls_pricelist_cacheTime'] ? $this->request->post['xls_pricelist_cacheTime'] : 600;
        } else {
            $this->xls_pricelist_cacheTime = $this->config->get('xls_pricelist_cacheTime');
        }

        if (isset($this->request->post['xls_pricelist_image_width'])) {
            $this->xls_pricelist_image_width = $this->request->post['xls_pricelist_image_width'];
        } else {
            $this->xls_pricelist_image_width = $this->config->get('xls_pricelist_image_width');
        }

        if (isset($this->request->post['xls_pricelist_image_height'])) {
            $this->xls_pricelist_image_height = $this->request->post['xls_pricelist_image_height'];
        } else {
            $this->xls_pricelist_image_height = $this->config->get('xls_pricelist_image_height');
        }

        if (isset($this->request->post['xls_pricelist_sort_order'])) {
            $this->xls_pricelist_sort_order = $this->request->post['xls_pricelist_sort_order'];
        } else {
            $this->xls_pricelist_sort_order = $this->config->get('xls_pricelist_sort_order');
        }

        if (isset($this->request->post['xls_pricelist_customer_group'])) {
            $this->xls_pricelist_customer_group = implode('_', $this->request->post['xls_pricelist_customer_group']);
        } else {
            $this->xls_pricelist_customer_group = $this->config->get('xls_pricelist_customer_group');
        }

        if (isset($this->request->post['xls_pricelist_attribute_group'])) {
            $this->xls_pricelist_attribute_group = implode('_', $this->request->post['xls_pricelist_attribute_group']);
        } else {
            $this->xls_pricelist_attribute_group = $this->config->get('xls_pricelist_attribute_group');
        }

        if (isset($this->request->post['xls_pricelist_listname'])) {
            $this->xls_pricelist_listname = $this->request->post['xls_pricelist_listname'];
        } else {
            $this->xls_pricelist_listname = $this->config->get('xls_pricelist_listname');
        }

        if (isset($this->request->post['xls_pricelist_logo'])) {
            $this->xls_pricelist_logo = $this->request->post['xls_pricelist_logo'];
        } else {
            $this->xls_pricelist_logo = $this->config->get('xls_pricelist_logo');
        }

        if (isset($this->request->post['xls_pricelist_logo_width'])) {
            $this->xls_pricelist_logo_width = $this->request->post['xls_pricelist_logo_width'];
        } else {
            $this->xls_pricelist_logo_width = $this->config->get('xls_pricelist_logo_width');
        }

        if (isset($this->request->post['xls_pricelist_logo_height'])) {
            $this->xls_pricelist_logo_height = $this->request->post['xls_pricelist_logo_height'];
        } else {
            $this->xls_pricelist_logo_height = $this->config->get('xls_pricelist_logo_height');
        }

        if (isset($this->request->post['xls_pricelist_description'])) {
            $xls_pricelist_description = $this->request->post['xls_pricelist_description'];
        } else {
            $xls_pricelist_description = $this->config->get('xls_pricelist_description');
        }

        if (isset($this->request->post['xls_pricelist_colors'])) {
            $xls_pricelist_colors = $this->request->post['xls_pricelist_colors'];
        } else {
            $xls_pricelist_colors = $this->config->get('xls_pricelist_colors');
        }

        $this->xls_pricelist_thead_color         = $xls_pricelist_colors['thead'];
        $this->xls_pricelist_thead_color_bg      = $xls_pricelist_colors['thead_bg'];
        $this->xls_pricelist_underthead_color_bg = $xls_pricelist_colors['underthead_bg'];
        $this->xls_pricelist_category0_color     = $xls_pricelist_colors['category0'];
        $this->xls_pricelist_category0_color_bg  = $xls_pricelist_colors['category0_bg'];
        $this->xls_pricelist_category1_color     = $xls_pricelist_colors['category1'];
        $this->xls_pricelist_category1_color_bg  = $xls_pricelist_colors['category1_bg'];
        $this->xls_pricelist_category2_color     = $xls_pricelist_colors['category2'];
        $this->xls_pricelist_category2_color_bg  = $xls_pricelist_colors['category2_bg'];
        $this->xls_pricelist_image_color_bg      = $xls_pricelist_colors['image_bg'];
        $this->xls_pricelist_model_color         = $xls_pricelist_colors['model'];
        $this->xls_pricelist_model_color_bg      = $xls_pricelist_colors['model_bg'];
        $this->xls_pricelist_name_color          = $xls_pricelist_colors['name'];
        $this->xls_pricelist_name_color_bg       = $xls_pricelist_colors['name_bg'];
        $this->xls_pricelist_stock_color         = $xls_pricelist_colors['stock'];
        $this->xls_pricelist_stock_color_bg      = $xls_pricelist_colors['stock_bg'];
        $this->xls_pricelist_price_color         = $xls_pricelist_colors['price'];
        $this->xls_pricelist_price_color_bg      = $xls_pricelist_colors['price_bg'];
        $this->xls_pricelist_special_color       = $xls_pricelist_colors['special'];
        $this->xls_pricelist_special_color_bg    = $xls_pricelist_colors['special_bg'];

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language) {
            $this->xls_pricelist_currency     = $xls_pricelist_description[$language['language_id']]['currency'];
            $this->xls_pricelist_title        = $xls_pricelist_description[$language['language_id']]['title'];
            $this->xls_pricelist_adress       = $xls_pricelist_description[$language['language_id']]['adress'];
            $this->xls_pricelist_phone        = $xls_pricelist_description[$language['language_id']]['phone'];
            $this->xls_pricelist_email        = $xls_pricelist_description[$language['language_id']]['email'];
            $this->xls_pricelist_link         = $xls_pricelist_description[$language['language_id']]['link'];
            $this->xls_pricelist_custom_text  = $xls_pricelist_description[$language['language_id']]['custom_text'];
            $this->xls_pricelist_listname     = $xls_pricelist_description[$language['language_id']]['listname'];
            $this->xls_pricelist_title_color  = $xls_pricelist_description[$language['language_id']]['title_color'];
            $this->xls_pricelist_adress_color = $xls_pricelist_description[$language['language_id']]['adress_color'];
            $this->xls_pricelist_phone_color  = $xls_pricelist_description[$language['language_id']]['phone_color'];
            $this->xls_pricelist_email_color  = $xls_pricelist_description[$language['language_id']]['email_color'];
            $this->xls_pricelist_link_color   = $xls_pricelist_description[$language['language_id']]['link_color'];
            $this->xls_pricelist_custom_color = $xls_pricelist_description[$language['language_id']]['custom_color'];
            $this->xls_pricelist_language     = $language;

            $this->generate('view');
            break;
        }
    }

    // Error Handler
    public function error_handler_for_export($errno, $errstr, $errfile, $errline) {
        global $config;
        global $log;

        switch ($errno) {
            case E_NOTICE:
            case E_USER_NOTICE:
                $errors = "Notice";
                break;
            case E_WARNING:
            case E_USER_WARNING:
                $errors = "Warning";
                break;
            case E_ERROR:
            case E_USER_ERROR:
                $errors = "Fatal Error";
                break;
            default:
                $errors = "Unknown";
                break;
        }

        if (($errors == 'Warning') || ($errors == 'Unknown')) {
            return true;
        }

        if ($config->get('config_error_display')) {
            echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
        }

        if ($config->get('config_error_log')) {
            $log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
        }

        return true;
    }

    public function fatal_error_shutdown_handler_for_export() {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            $this->error_handler_for_export(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

    private function upload() {
        $errors = array();
        if (!defined('HTTP_IMAGE')) {
            define('HTTP_IMAGE', HTTP_SERVER . 'image/');
        }

        set_error_handler(array(
            $this,
            'error_handler_for_export'
        ));

        ini_set("memory_limit", "1536M");
        ini_set("max_execution_time", 180);

        $_ = array();
        require(DIR_LANGUAGE . $this->xls_pricelist_language['directory'] . '/product/xls_pricelist.php');
        $this->LNG = $_;

        set_include_path(DIR_SYSTEM . 'PHPExcel/Classes');

        require_once "PHPExcel.php";

        require_once 'PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true); //optional

        $max_filesize      = 20971520; // максимальный размер файла в БАЙТАХ.
        $allowed_filetypes = array(
            '.xlsx'
        ); // Это будут виды файлов, которые пройдут проверку (валидацию).
        $filename          = $_FILES['file']['name']; // получаем название файла (включая его расширение).
        $ext               = substr($filename, strpos($filename, '.'), strlen($filename) - 1); // Получаем расширение из названия файла.
        $file_strip        = str_replace(" ", "_", $filename); //Замещаем пробелы в названии файла
        $upload_path       = DIR_UPLOAD; //устанавливаем путь выгрузки

        // Проверяем, разрешен ли вид файла, если нет - DIE и информируем пользователя.
        if (!in_array($ext, $allowed_filetypes)) {
            $errors[] = 'Загружаемый тип файла недопустим.';
        }
        // Теперь проверяем размер файла, если он слишком большой, то DIE и информируем пользователя.
        if (filesize($_FILES['file']['tmp_name']) > $max_filesize) {
            $errors[] = 'Загружаемый файл слишком большой.';
        }
        // Проверяем, можно ли выгрузить в определенный путь, если нет, то DIE и информируем пользователя.
        if (!is_writable($upload_path)) {
            $errors[] = 'Вы не можете загружать в папку /upload/. Измените права на папку.';
        }
        // Перемещаем файл, если он прошел все проверки.
        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path . $file_strip)) {
            try {
                $objPHPExcel = $objReader->load($upload_path . $file_strip);
            } catch (Exception $e) {
                $errors[] = 'Ошибка: ' . $e->getMessage();
            }
        } else {
            $errors[] = 'Файл ' . $file_strip . ' не загружен. Попробуйте позже.';
        }

        if (!empty($errors)) {
            echo json_encode($errors);
            die();
        }

        $language_id = $this->xls_pricelist_language['language_id'];

        $objWorksheet = $objPHPExcel->getActiveSheet();

        $i     = 1;
        $lines = 0;
        foreach ($objWorksheet->getRowIterator() as $row) {

            $product_id   = $objWorksheet->getCell("A$i")->getValue(); // ID
            $image        = $objWorksheet->getCell("B$i")->getValue(); // Изображение
            $model        = $objWorksheet->getCell("C$i")->getValue(); // Код
            $sku          = $objWorksheet->getCell("D$i")->getValue(); // SKU
            $name         = $objWorksheet->getCell("E$i")->getValue(); // Наименование
            $options      = $objWorksheet->getCell("F$i")->getValue(); // Опции
            $attributes   = $objWorksheet->getCell("G$i")->getValue(); // Атрибуты
            $quantity     = $objWorksheet->getCell("H$i")->getValue(); // На складе
            $price        = $objWorksheet->getCell("I$i")->getValue(); // Розница
            $special      = $objWorksheet->getCell("J$i")->getValue(); // Опт
            $manufacturer = $objWorksheet->getCell("K$i")->getValue(); // Производитель
            $stock_status = $objWorksheet->getCell("L$i")->getValue(); // Cтатус

            if ($product_id != '' && $product_id != 'ID') {

                if ($manufacturer == '') {
                    $manufacturer = 0;
                }

                $stock_status_id = $this->getStatusId($stock_status);
                $status          = 0;
                if ($stock_status == 'В наличии') {
                    $status = 1;
                }

                $manufacturer_id = $this->getManufacturerId($manufacturer);

                $option = $this->getOptionBySKU($product_id, $sku);

                $data = array(
                    'model'           => $model,
                    'sku'             => $sku,
                    'name'            => $name,
                    'option'          => $option,
                    'attributes'      => $attributes,
                    'quantity'        => $quantity,
                    'price'           => $price,
                    'special'         => $special,
                    'manufacturer_id' => $manufacturer_id,
                    'stock_status_id' => $stock_status_id,
                    'status'          => $status
                );

                $this->editProduct($product_id, $data, $language_id);

                $lines++;
            }

            $i++;
        }

        echo json_encode('Загружено ' . $lines . ' строк из таблицы');
        die();
    }

    private function generate($method = '') {
        if (!defined('HTTP_IMAGE')) {
            define('HTTP_IMAGE', HTTP_SERVER . 'image/');
        }
        set_error_handler(array(
            $this,
            'error_handler_for_export'
        ));
        //register_shutdown_function(array($this, 'fatal_error_shutdown_handler_for_export'));

        ini_set("memory_limit", "1536M");
        ini_set("max_execution_time", 180);

        $_ = array();
        require(DIR_LANGUAGE . $this->xls_pricelist_language['directory'] . '/product/xls_pricelist.php');
        $this->LNG = $_;

        set_include_path(DIR_SYSTEM . 'PHPExcel/Classes');

        require_once "PHPExcel.php";

        if (!extension_loaded('zip')) {
            if (!dl('zip.so')) {
                PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
            }
        }

        if ($this->xls_pricelist_usecache != 'no') {
            if ($this->xls_pricelist_usecache == 'file') {
                $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;

                if (ini_get('upload_tmp_dir'))
                    $upload_tmp_dir = ini_get('upload_tmp_dir');
                else
                    $upload_tmp_dir = DIR_DOWNLOAD;

                $cacheSettings = array(
                    'dir' => $upload_tmp_dir
                );

                PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            } elseif ($this->xls_pricelist_usecache == 'memcache') {
                $cacheMethod   = PHPExcel_CachedObjectStorageFactory::cache_to_memcache;
                $cacheSettings = array(
                    'memcacheServer' => '' . $this->xls_pricelist_memcacheServer . '',
                    'memcachePort'   => (int)$this->xls_pricelist_memcachePort,
                    'cacheTime'      => (int)$this->xls_pricelist_cacheTime
                );
                PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            }
        }

        $stores = explode("_", $this->xls_pricelist_store);
        foreach ($stores as $store) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store . "'");

            foreach ($query->rows as $setting) {
                $this->config->set('config_store_id', $store);
                if (!$setting['serialized']) {
                    $this->config->set($setting['key'], $setting['value']);
                } else {
                    $this->config->set($setting['key'], unserialize($setting['value']));
                }
            }
            $workbook = new PHPExcel();

            $this->load->model('xls_pricelist/helper_models');
            $cust_groups = explode("_", $this->xls_pricelist_customer_group);
            $sh          = 0;
            //var_dump($cust_groups);exit;
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($sh);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle('Pricelist');
            /*
            //foreach($cust_groups as $cust_group){
            $this->delim = 0;
            $customer_group = $this->model_xls_pricelist_helper_models->getCustomerGroup($cust_group);
            if(!isset($customer_group['name']))$customer_group = $this->model_xls_pricelist_helper_models->getCustomerGroup1($cust_group, $this->xls_pricelist_language['language_id']);
            if(!$customer_group)continue;
            if(sizeof($cust_groups)==1&&$this->xls_pricelist_listname){
            $workbook->setActiveSheetIndex($sh);
            $worksheet = $worksheet;
            $worksheet->setTitle($this->xls_pricelist_listname );
            }
            else{
            if($sh)$workbook->createSheet();
            $workbook->setActiveSheetIndex($sh);
            $worksheet = $worksheet;
            $worksheet->setTitle($customer_group['name']);
            }
            */
            if ($this->xls_pricelist_use_collapse) {
                $worksheet->setShowSummaryBelow(false); ////collapse
            }
            if ($this->xls_pricelist_use_protection) {
                $worksheet->getProtection()->setPassword($this->xls_pricelist_use_password); ///protection
                $worksheet->getProtection()->setSheet(true); ///protection
            }

            ///////////
            $f_name    = array(
                'font'      => array(
                    'bold'  => false,
                    'color' => array(
                        'argb' => '00' . ($this->xls_pricelist_title_color ? $this->xls_pricelist_title_color : '000000')
                    ),
                    'size'  => 20,
                    'name'  => 'BELL MT'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $f_address = array(
                'font'      => array(
                    'bold'  => false,
                    'color' => array(
                        'argb' => '00' . ($this->xls_pricelist_adress_color ? $this->xls_pricelist_adress_color : '000000')
                    ),
                    'size'  => 14,
                    'name'  => 'BELL MT'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $f_phone   = array(
                'font'      => array(
                    'bold'  => true,
                    'color' => array(
                        'argb' => '00' . ($this->xls_pricelist_phone_color ? $this->xls_pricelist_phone_color : '000000')
                    ),
                    'size'  => 10,
                    'name'  => 'Cambria'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $f_email   = array(
                'font'      => array(
                    'bold'  => true,
                    'color' => array(
                        'argb' => '00' . ($this->xls_pricelist_email_color ? $this->xls_pricelist_email_color : '339966')
                    ),
                    'size'  => 10,
                    'name'  => 'Cambria'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $f_link    = array(
                'font'      => array(
                    'bold'      => false,
                    'underline' => true,
                    'color'     => array(
                        'argb' => '00' . ($this->xls_pricelist_link_color ? $this->xls_pricelist_link_color : '0000ff')
                    ),
                    'size'      => 10,
                    'name'      => 'Arial'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $f_custom  = array(
                'font'      => array(
                    'color' => array(
                        'argb' => '00' . ($this->xls_pricelist_custom_color ? $this->xls_pricelist_custom_color : '000000')
                    ),
                    'size'  => 8,
                    'name'  => 'Arial'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );
            if ($this->xls_pricelist_thead_color_bg) {
                $fu = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_thead_color ? $this->xls_pricelist_thead_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_thead_color_bg
                        )
                    )
                );
            } else {
                $fu = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_thead_color ? $this->xls_pricelist_thead_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_underthead_color_bg) {
                $fe = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_underthead_color_bg
                        )
                    )
                );
            } else {
                $fe = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_BOTTOM
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_category0_color_bg) {
                $fc1 = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_category0_color ? $this->xls_pricelist_category0_color : 'FFFFFF')
                        ),
                        'size'  => 13,
                        'name'  => 'BELL MT'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                        //'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_category0_color_bg
                        )
                    )
                );
            } else {
                $fc1 = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_category0_color ? $this->xls_pricelist_category0_color : 'FFFFFF')
                        ),
                        'size'  => 13,
                        'name'  => 'BELL MT'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                        //'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_category1_color_bg) {
                $fc2 = array(
                    'font'      => array(
                        'bold'   => true,
                        'italic' => true,
                        'color'  => array(
                            'argb' => '00' . ($this->xls_pricelist_category1_color ? $this->xls_pricelist_category1_color : '000000')
                        ),
                        'size'   => 9,
                        'name'   => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                        //'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_category1_color_bg
                        )
                    )
                );
            } else {
                $fc2 = array(
                    'font'      => array(
                        'bold'   => true,
                        'italic' => true,
                        'color'  => array(
                            'argb' => '00' . ($this->xls_pricelist_category1_color ? $this->xls_pricelist_category1_color : '000000')
                        ),
                        'size'   => 9,
                        'name'   => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                        //'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_category2_color_bg) {
                $fc3 = array(
                    'font'      => array(
                        'bold'   => true,
                        'italic' => true,
                        'color'  => array(
                            'argb' => '00' . ($this->xls_pricelist_category2_color ? $this->xls_pricelist_category2_color : '000000')
                        ),
                        'size'   => 8,
                        'name'   => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                        //'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_category2_color_bg
                        )
                    )
                );
            } else {

            }

            if ($this->xls_pricelist_image_color_bg) {
                $this->f_image = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00000000'
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_image_color_bg
                        )
                    )
                );
            } else {
                $this->f_image = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00000000'
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_model_color_bg) {
                $this->f_model = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_model_color ? $this->xls_pricelist_model_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_model_color_bg
                        )
                    )
                );
            } else {
                $this->f_model = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_model_color ? $this->xls_pricelist_model_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_name_color_bg) {
                $this->f_name = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_name_color ? $this->xls_pricelist_name_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_name_color_bg
                        )
                    )
                );
            } else {
                $this->f_name = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_name_color ? $this->xls_pricelist_name_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_stock_color_bg) {
                $this->f_stock = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_stock_color ? $this->xls_pricelist_stock_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_stock_color_bg
                        )
                    )
                );
            } else {
                $this->f_stock = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_stock_color ? $this->xls_pricelist_stock_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_price_color_bg) {
                $this->f_price = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_price_color ? $this->xls_pricelist_price_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_price_color_bg
                        )
                    )
                );
            } else {
                $this->f_price = array(
                    'font'      => array(
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_price_color ? $this->xls_pricelist_price_color : '000000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            if ($this->xls_pricelist_special_color_bg) {
                $this->f_special = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_special_color ? $this->xls_pricelist_special_color : 'FF0000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap'       => true
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'fill'      => array(
                        'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'argb' => '00' . $this->xls_pricelist_special_color_bg
                        )
                    )
                );
            } else {
                $this->f_special = array(
                    'font'      => array(
                        'bold'  => true,
                        'color' => array(
                            'argb' => '00' . ($this->xls_pricelist_special_color ? $this->xls_pricelist_special_color : 'FF0000')
                        ),
                        'size'  => 8,
                        'name'  => 'Arial'
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wrap'       => true
                    ),
                    'borders'   => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
            }

            $fc_arr = array(
                $fc1,
                $fc2,
                $fc3
            );

            $heads = array(
                array(
                    'name'  => 'ID',
                    'check' => true,
                    'width' => 10
                ),
                array(
                    'name'  => 'Изображение',
                    'check' => $this->xls_pricelist_use_image,
                    'width' => $this->xls_pricelist_image_width
                ),
                array(
                    'name'  => 'Код',
                    'check' => $this->xls_pricelist_use_code,
                    'width' => $this->xls_pricelist_model_width
                ),
                array(
                    'name'  => 'SKU',
                    'check' => true,
                    'width' => $this->xls_pricelist_model_width
                ),
                array(
                    'name'  => 'Наименование',
                    'check' => true,
                    'width' => $this->xls_pricelist_name_width
                ),
                array(
                    'name'  => 'Опции',
                    'check' => true,
                    'width' => 20
                ),
                array(
                    'name'  => 'Атрибуты',
                    'check' => true,
                    'width' => 30
                ),
                array(
                    'name'  => 'На складе',
                    'check' => true,
                    'width' => $this->xls_pricelist_stock_width
                ),
                array(
                    'name'  => 'Розница',
                    'check' => true,
                    'width' => $this->xls_pricelist_price_width
                ),
                array(
                    'name'  => 'Опт',
                    'check' => true,
                    'width' => $this->xls_pricelist_price_width
                ),
                array(
                    'name'  => 'Производитель',
                    'check' => true,
                    'width' => 15
                ),
                array(
                    'name'  => 'Cтатус',
                    'check' => true,
                    'width' => $this->xls_pricelist_price_width
                ),
                array(
                    'name'  => 'Акция',
                    'check' => $this->xls_pricelist_use_special,
                    'width' => $this->xls_pricelist_special_width
                )
            );

            $col = 0;
            foreach ($heads as $head) {
                if ($head['check']) {
                    if ($head['name'] == 'Изображение') {
                        $col_width = (($this->xls_pricelist_image_width ? $this->xls_pricelist_image_width + 2 : 52) - 5) / 7;

                        if ($col_width > 12) {
                            $worksheet->getColumnDimension($worksheet->getCellByColumnAndRow($col, 0)->getColumn())->setWidth($col_width);
                            $this->l_margin = $col_width * 7 + 5 - ($this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50);
                        } else {
                            $worksheet->getColumnDimension($worksheet->getCellByColumnAndRow($col, 0)->getColumn())->setWidth(12);
                            $this->l_margin = 12 * 7 + 5 - ($this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50);
                        }
                    } else {
                        $worksheet->getColumnDimension($worksheet->getCellByColumnAndRow($col, 0)->getColumn())->setWidth((int)$head['width']);
                    }

                    $col++;
                }
            }

            ///logo
            if ($this->xls_pricelist_logo) {
                $this->load->model('tool/image');

                $logo = $this->model_tool_image->resize($this->xls_pricelist_logo, $this->xls_pricelist_logo_width ? $this->xls_pricelist_logo_width : 50, $this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height : 50);

                if ($logo) {

                    $rh = ($this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height + 2 : 52) * 3 / 4;
                    $worksheet->getRowDimension('1')->setRowHeight($rh);

                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setPath(str_replace(HTTP_IMAGE, DIR_IMAGE, $logo));
                    $objDrawing->setHeight($this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height : 50);
                    $objDrawing->setWorksheet($worksheet);
                    $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow(1, 1)->getCoordinate());

                    $columnsize = ($worksheet->getColumnDimensionByColumn(1)->getWidth()) * 7 + 5;

                    if ($columnsize > $this->xls_pricelist_logo_width) {
                        $objDrawing->setOffsetX(($columnsize - $this->xls_pricelist_logo_width) / 2);
                    } else {
                        $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                    }
                    $objDrawing->setOffsetY(2);

                    //$worksheet->insertBitmap ( $i , 0 , DIR_CACHE.'tmp.bmp' , $this->l_margin/2+1 , 2 , 1 , 1 );
                }
            }
            ///
            $worksheet->setCellValueByColumnAndRow(4, 2, $this->xls_pricelist_title ? $this->xls_pricelist_title : $this->config->get('config_name'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 2)->getCoordinate())->applyFromArray($f_name);

            $worksheet->setCellValueByColumnAndRow(4, 3, $this->xls_pricelist_adress ? $this->xls_pricelist_adress : $this->config->get('config_address'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 3)->getCoordinate())->applyFromArray($f_address);

            $worksheet->setCellValueByColumnAndRow(4, 4, $this->xls_pricelist_phone ? $this->xls_pricelist_phone : (($this->config->get('config_telephone') ? $this->LNG['text_phone'] . ' ' . $this->config->get('config_telephone') : '') . '     ' . ($this->config->get('config_fax') ? $this->LNG['text_fax'] . ' ' . $this->config->get('config_fax') : '')));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 4)->getCoordinate())->applyFromArray($f_phone);

            $worksheet->setCellValueByColumnAndRow(4, 5, $this->xls_pricelist_email ? $this->xls_pricelist_email : 'e-mail:' . $this->config->get('config_email'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 5)->getCoordinate())->applyFromArray($f_email);

            $worksheet->setCellValueByColumnAndRow(4, 6, $this->config->get('config_url'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 6)->getCoordinate())->applyFromArray($f_link);
            $worksheet->getCellByColumnAndRow(4, 6)->getHyperlink()->setUrl($this->xls_pricelist_link ? $this->xls_pricelist_link : $this->config->get('config_url'));

            if ($this->xls_pricelist_custom_text) {
                $worksheet->setCellValueByColumnAndRow(4, 7, str_replace("\r", "", $this->xls_pricelist_custom_text));
                $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 7)->getCoordinate())->applyFromArray($f_custom);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow(4, 7)->getCoordinate())->getAlignment()->setWrapText(true);
            }

            $col = 0; // Заголовки
            foreach ($heads as $head) {
                if ($head['check']) {
                    $worksheet->setCellValueByColumnAndRow($col, 9, $head['name']);
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, 9)->getCoordinate())->applyFromArray($fu);
                    $worksheet->setCellValueByColumnAndRow($col, 10, '');
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, 10)->getCoordinate())->applyFromArray($fu);

                    if ($head['name'] == 'Опции') {
                        $worksheet->getColumnDimensionByColumn($col)->setAutoSize(true);
                    }
                    if ($head['name'] == 'Атрибуты') {
                        $worksheet->getColumnDimensionByColumn($col)->setAutoSize(true);
                    }

                    $col++;
                }
            }

            $col = 0; // Объединение ячеек
            foreach ($heads as $head) {
                if ($head['check']) {
                    $worksheet->mergeCells($worksheet->getCellByColumnAndRow($col, 9)->getCoordinate() . ':' . $worksheet->getCellByColumnAndRow($col, 9)->getCoordinate());
                    $col++;
                }
            }

            $col = 0; // Пустые ячейки
            foreach ($heads as $head) {
                if ($head['check']) {
                    $worksheet->setCellValueByColumnAndRow($col, 10, '');
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, 10)->getCoordinate())->applyFromArray($fe);
                    $col++;
                }
            }

            ///////////
            $i = 10;
            //$this->load->model('catalog/category');
            //$this->load->model('catalog/product');
            $categories = array();

            $cats = explode("_", $this->xls_pricelist_category);

            foreach ($cats as $category_id) {
                $ccat = $this->model_xls_pricelist_helper_models->getCategory($category_id, $this->xls_pricelist_language['language_id']);
                if ($ccat)
                    $categories[] = $ccat;
            }
            //$categories = $this->model_catalog_category->getCategories(0);

            foreach ($categories as $category) {
                $i++;
                $level = $this->model_xls_pricelist_helper_models->getCategoryLevel($category['category_id'], 0, $this->xls_pricelist_language['language_id']);
                $path  = $this->model_xls_pricelist_helper_models->getCategoryPath($category['category_id'], array(), $this->xls_pricelist_language['language_id']);
                //print $path."<br>";
                $level1 = $level;
                if ($level > 2)
                    $level1 = 2;

                $col = 0; // Категории
                foreach ($heads as $head) {
                    if ($head['check']) {
                        if ($head['name'] == 'Наименование') {
                            $worksheet->setCellValueByColumnAndRow($col, $i, html_entity_decode($category['name'], ENT_QUOTES, 'UTF-8'));
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate())->applyFromArray($fc_arr[$level1]);
                            $worksheet->getCellByColumnAndRow($col, $i)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $path)));
                        } else {
                            $worksheet->setCellValueByColumnAndRow($col, $i, '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate())->applyFromArray($fc_arr[$level1]);
                        }
                        $col++;
                    }
                }

                if ($this->xls_pricelist_use_collapse && $level) {
                    $worksheet->getRowDimension($i)->setOutlineLevel($level); //////collapse
                    $worksheet->getRowDimension($i)->setVisible(false); //////collapse
                    $worksheet->getRowDimension($i)->setCollapsed(true); //////collapse
                }

                $this->getProducts($i, $workbook, $category['category_id'], $path, $level + 1, $cust_groups);

            }
            $sh++;

            //}

            if ($method == 'view') {
                //отдаем пользователю в браузер
                include_once("PHPExcel/Writer/Excel2007.php");

                header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Disposition: attachment;filename="price_' . $this->xls_pricelist_language['code'] . $store . '.xlsx"');

                $objWriter = new PHPExcel_Writer_Excel2007($workbook);
                $objWriter->save('php://output');
                exit();

                break;
            } else {
                include_once("PHPExcel/Writer/Excel2007.php");
                $objWriter = new PHPExcel_Writer_Excel2007($workbook);
                $objWriter->save(DIR_DOWNLOAD . "price_" . $this->xls_pricelist_language['code'] . $store . ".xlsx");
            }
            $workbook->disconnectWorksheets();
            unset($objWriter);
            unset($workbook);
        }
        /*////  uncomment this, if you want to compress generated xls to zip
        if($method!='view'){
        if (file_exists(DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".zip")) unlink(DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".zip");
        $zip = new ZipArchive();
        $filename = DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".zip";
        
        if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
        exit("Cannot open <$filename>\n");
        }
        
        $zip->addFile(DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".xls", "price_".$this->xls_pricelist_language['code'].".xls");
        if (file_exists(DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".xls")) unlink(DIR_DOWNLOAD."price_".$this->xls_pricelist_language['code'].".xls");
        $zip->close();
        }
        ////*/
    }

    private function getProducts(&$i, &$workbook, $category_id, $path, $level, $customer_group_id = '') {
        if ($this->xls_pricelist_use_image) {
            $this->load->model('tool/image');
            //require_once (DIR_SYSTEM . 'xls_price/ToBmp.php');
        }

        $worksheet = $workbook->getActiveSheet();

        list($sort, $order) = explode('-', $this->xls_pricelist_sort_order);

        $data = array(
            'filter_category_id' => $category_id,
            'sort'               => $sort,
            'order'              => $order,
            'start'              => 0,
            'limit'              => 1000000000,
            'customer_group_id'  => $customer_group_id,
            'language_id'        => $this->xls_pricelist_language['language_id'],
            'filter_dubles'      => $this->xls_pricelist_nodubles
        );

        $results = $this->model_xls_pricelist_helper_models->getProducts($data);

        /*$customer_groups = $this->customer_groups;
        $this->load->library('myocpod');
        $pods = $this->model_xls_pricelist_helper_models->getPods();*/

        foreach ($results as $result) {
            $options = $this->model_xls_pricelist_helper_models->getProductOptions($result['product_id'], $this->xls_pricelist_language['language_id']);

            if (is_array($result['price_gid'])) {
                foreach ($result['price_gid'] as $k => $v) {
                    $price_gid[$k] = $this->currency->format($this->tax->calculate(floatval($v), $result['tax_class_id'], $this->config->get('config_tax')), $this->xls_pricelist_currency);
                }
            }

            if ((float)$result['price']) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->xls_pricelist_currency);
            } else {
                $price = false;
            }

            if (!empty($result['special']) && (float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->xls_pricelist_currency);
            } else {
                $special = false;
            }

            if (!count($options)) {
                $col      = 0;
                $rh       = 0;
                $quantity = $result['quantity'];
                if (!$this->xls_pricelist_use_notinstock) {
                    if ($quantity <= 0)
                        continue;
                }

                $status = 'В наличии';
                if ($quantity <= 0) {
                    $status = 'Отсутствует';
                }

                if (!$this->xls_pricelist_use_quantity) {
                    if ($quantity <= 0)
                        $quantity = $this->LNG['text_outofstock'];
                    else
                        $quantity = $this->LNG['text_instock'];
                }
                //$quantity="Нет на складе";
                //elseif($quantity>1000)$quantity=">1000";
                //elseif($quantity>500)$quantity=">500";
                //elseif($quantity>100)$quantity=">100";
                //elseif($quantity>50)$quantity=">50";
                //elseif($quantity>10)$quantity=">10";
                //elseif($quantity>5)$quantity=">5";
                $i++;

                if ($this->xls_pricelist_use_collapse) {
                    $worksheet->getRowDimension($i)->setOutlineLevel($level); ///collapse
                    $worksheet->getRowDimension($i)->setVisible(false); ///collapse
                    $worksheet->getRowDimension($i)->setCollapsed(true); ///collapse
                }

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $result['product_id']);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                $col++;

                if ($this->xls_pricelist_use_image) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                    } else {
                        $image = $this->model_tool_image->resize('no_image.jpg', $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                    }

                    if (!$image) {
                        $image = $this->model_tool_image->resize('no_image.jpg', $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                    }

                    if ($image) {
                        $rh = ($this->xls_pricelist_image_height ? $this->xls_pricelist_image_height + 2 : 52) * 3 / 4;
                        $worksheet->getRowDimension('' . $i . '')->setRowHeight($rh);

                        $objDrawing = new PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath(str_replace(HTTP_IMAGE, DIR_IMAGE, $image));
                        $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate());
                        $objDrawing->setWorksheet($worksheet, true);
                        $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                        $objDrawing->setOffsetY(2);

                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate())->applyFromArray($this->f_image);
                    }

                    $col++;
                }

                $attr_group = '';

                $attribute_groups = explode("_", $this->xls_pricelist_attribute_group);

                $rrh = 0;
                foreach ($this->model_xls_pricelist_helper_models->getProductAttributes($result['product_id'], $this->xls_pricelist_language['language_id']) as $attribute_group) {
                    if (!in_array($attribute_group['attribute_group_id'], $attribute_groups))
                        continue;
                    $attrs = array();
                    $rrh++;

                    if ($this->xls_pricelist_use_attributes)
                        $attr_group .= $attribute_group['name'] . ": ";
                    else
                        $attr_group .= "";

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attrs[] = $attribute['name'] . " - " . $attribute['text'];
                    }
                    $attr_group .= " " . implode(",\r\n", $attrs);
                }

                if ($rrh)
                    $rrh = ($rrh * 11 + 9) + 9;
                if ($rrh > $rh) {
                    $worksheet->getRowDimension('' . $i . '')->setRowHeight($rrh);
                }

                if ($this->xls_pricelist_use_code) {
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_model);
                    $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->setValueExplicit($result['' . $this->xls_pricelist_code . ''], PHPExcel_Cell_DataType::TYPE_STRING);
                    $col++;
                }

                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_model);
                $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->setValueExplicit($result['sku'], PHPExcel_Cell_DataType::TYPE_STRING);
                $col++;

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_name);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->getAlignment()->setWrapText(true);
                $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                $col++;

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, ' ');
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                $col++;

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, html_entity_decode($attr_group, ENT_QUOTES, 'UTF-8'));
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_name);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->getAlignment()->setWrapText(true);
                $col++;

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $quantity);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                $col++;

                if (is_array($price_gid)) {
                    foreach ($price_gid as $k => $v) {
                        $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $v ? $v : '');
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                        $col++;
                    }
                } else {
                    $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $price ? $price : '');
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                    $col++;
                }

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $result['manufacturer'] ? $result['manufacturer'] : '');
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                $col++;

                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $status);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                $col++;

                if ($this->xls_pricelist_use_special) {
                    $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $special ? $special : '');
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_special);
                }
            }

            /************** если есть опции в товаре *****************/
            if ($this->xls_pricelist_use_options) {
                foreach ($options as $option) {

                    //$product_option_id = $option['product_option_id'];
                    //$pods = $pods[$product_option_id];

                    if (!empty($result['special']) && $result['special']) {
                        $product_base_price = $result['special'];
                    } else {
                        $product_base_price = $result['price'];
                    }

                    if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {

                        foreach ($option['option_value'] as $option_value) {

                            $col = 0;

                            $pod_data = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '{$option_value['product_option_value_id']}'")->rows;
                            $quantity = $option_value['quantity'];

                            if (!$this->xls_pricelist_use_notinstock) {
                                if ($quantity <= 0)
                                    continue;
                            }

                            if (!$this->xls_pricelist_use_quantity) {
                                if ($quantity <= 0)
                                    $quantity = $this->LNG['text_outofstock'];
                                else
                                    $quantity = $this->LNG['text_instock'];
                            }

                            $status = 'В наличии';
                            if ($quantity <= 0) {
                                $status = 'Отсутствует';
                            }

                            $i++;
                            $retail_price    = 0; // Розница
                            $wholesale_price = 0; // Опт

                            foreach ($pod_data as $pod) {
                                $customer = unserialize($pod['customer_group_ids']);

                                if (!empty($customer)) {
                                    if ($customer[0] === '1') {
                                        if ((float)$pod['special']) {
                                            switch ($pod['price_prefix']) {
                                                case '=':
                                                    $retail_price = (float)$pod['special'];
                                                    break;
                                                case '-':
                                                    $retail_price = (float)$pod['price'] - (float)$pod['special'];
                                                    break;
                                                case '+':
                                                    $retail_price = (float)$pod['price'] + (float)$pod['special'];
                                                    break;
                                            }
                                        } else {
                                            $retail_price = (float)$pod['price'];
                                        }
                                    } elseif ($customer[0] === '2') {
                                        if ((float)$pod['special']) {
                                            switch ($pod['price_prefix']) {
                                                case '=':
                                                    $wholesale_price = (float)$pod['special'];
                                                    break;
                                                case '-':
                                                    $wholesale_price = (float)$pod['price'] - (float)$pod['special'];
                                                    break;
                                                case '+':
                                                    $wholesale_price = (float)$pod['price'] + (float)$pod['special'];
                                                    break;
                                            }
                                        } else {
                                            $wholesale_price = (float)$pod['price'];
                                        }
                                    }
                                }
                            }

                            // #@$%$%$^!
                            /*if ( $option_value['price_prefix'] == '+' ) {
                                $result_price = $product_base_price + $option_value['price'];
                                $result_special = $result['special'] + $option_value['price'];
                            } elseif ( $option_value['price_prefix'] == '-' ) {
                                $result_price = $product_base_price - $option_value['price'];
                                $result_special = $result['special'] - $option_value['price'];
                            } elseif ( $option_value['price_prefix'] == '=' ) {
                                $result_price = $option_value['price'];
                                $result_special = $option_value['price'];
                            }*/

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $result['product_id']);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                            $col++;

                            if ($this->xls_pricelist_use_image) {
                                if ($option_value['image']) {
                                    $image1 = $this->model_tool_image->resize($option_value['image'], $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                                } else {
                                    $image1 = $this->model_tool_image->resize('no_image.jpg', $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                                }

                                if (!$image1) {
                                    $image1 = $this->model_tool_image->resize('no_image.jpg', $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50, $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                                }

                                if ($image1) {
                                    $rh1 = ($this->xls_pricelist_image_height ? $this->xls_pricelist_image_height + 2 : 52) * 3 / 4;

                                    $worksheet->getRowDimension('' . $i . '')->setRowHeight($rh1);

                                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                                    $objDrawing->setPath(str_replace(HTTP_IMAGE, DIR_IMAGE, $image1));
                                    $objDrawing->setHeight($this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50);
                                    $objDrawing->setWorksheet($worksheet);
                                    $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate());
                                    $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                                    $objDrawing->setOffsetY(2);
                                }

                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $i)->getCoordinate())->applyFromArray($this->f_image);
                                $col++;
                            }

                            /*if ( (float) $result['price'] ) {
                                $price = $this->currency->format( $this->tax->calculate( $result_price, $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                            }*/

                            /*if ( (float) $result['special'] ) {
                                $special = $this->currency->format( $this->tax->calculate( $result_special, $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                            }*/

                            if ($this->xls_pricelist_use_code) {
                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_model);
                                $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->setValueExplicit($result['' . $this->xls_pricelist_code . ''] . '', PHPExcel_Cell_DataType::TYPE_STRING);
                                $col++;
                            }

                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_model);
                            $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->setValueExplicit($option_value['sku'], PHPExcel_Cell_DataType::TYPE_STRING);
                            $col++;

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_name);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->getAlignment()->setWrapText(true);
                            $worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                            $col++;

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, html_entity_decode($option['name'] . ': ' . $option_value['name'], ENT_QUOTES, 'UTF-8'));
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_name);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->getAlignment()->setWrapText(true);
                            $col++;

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, ' ');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                            $col++;

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $quantity);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_stock);
                            $col++;

                            //if ( isset($product_option_datas[$option_value['product_option_value_id']]) ) {
                            //$price_array = $product_option_datas[$option_value['product_option_value_id']];

                            // Цена для опции розница
                            /*if(isset($price_array[1])){
                                $v = $this->currency->format( $this->tax->calculate( $price_array[1]['price'], $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                            } else {
                                $v = false;
                            }*/

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $retail_price);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                            $col++;

                            // Цена для опции опт
                            /*f(isset($price_array[2])){
                                 $v = $this->currency->format( $this->tax->calculate( $price_array[2]['price'], $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                             } else {
                                 $v = false;

                                 if(isset($price_gid[2])){
                                     $v = $this->currency->format( $this->tax->calculate( $price_gid[2], $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                                 }
                             }*/

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $wholesale_price);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                            $col++;

                            /*} else {
                                foreach ( $result['price_gid'] as $k => $v ) {
                                    $v = $this->currency->format( $this->tax->calculate( $v, $result['tax_class_id'], $this->config->get( 'config_tax' ) ), $this->xls_pricelist_currency );
                                    $worksheet->setCellValueByColumnAndRow( $col + $this->delim, $i, $v ? $v : '' );
                                    $worksheet->getStyle( $worksheet->getCellByColumnAndRow( $col + $this->delim, $i )->getCoordinate() )->applyFromArray( $this->f_price );
                                    $col++;
                                }
                            }*/

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, ($result['manufacturer']) ? $result['manufacturer'] : ' ');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                            $col++;

                            $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $status);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_price);
                            $col++;

                            if ($this->xls_pricelist_use_special) {
                                $worksheet->setCellValueByColumnAndRow($col + $this->delim, $i, $special ? $special : '');
                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col + $this->delim, $i)->getCoordinate())->applyFromArray($this->f_special);
                            }

                            if ($this->xls_pricelist_use_collapse) {
                                $worksheet->getRowDimension($i)->setOutlineLevel($level); ///collapse
                                $worksheet->getRowDimension($i)->setVisible(false); ///collapse
                                $worksheet->getRowDimension($i)->setCollapsed(true); ///collapse
                            }
                        }
                    }

                }
            }
        }
    }

    public function getProductId($model) {
        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");
        return $query->row['product_id'];
    }

    public function getStatusId($stock_status) {
        $query = $this->db->query("SELECT stock_status_id FROM " . DB_PREFIX . "stock_status WHERE name = '" . $this->db->escape($stock_status) . "'");
        return $query->row['stock_status_id'];
    }

    public function getManufacturerId($manufacturer) {
        $query = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE name = '" . $this->db->escape($manufacturer) . "'");
        return $query->row['manufacturer_id'];
    }

    public function getOptionBySKU($product_id, $sku) {
        $product_option_data = array();

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.ob_sku = '" . $sku . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->rows as $product_option_value) {
                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id'         => $product_option_value['option_value_id'],
                        'name'                    => $product_option_value['name'],
                        'image'                   => $product_option_value['image'],
                        'quantity'                => $product_option_value['quantity'],
                        'subtract'                => $product_option_value['subtract'],
                        'price'                   => $product_option_value['price'],
                        'price_prefix'            => $product_option_value['price_prefix'],
                        'weight'                  => $product_option_value['weight'],
                        'weight_prefix'           => $product_option_value['weight_prefix']
                    );
                }

                $product_option_data[] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'option_id'         => $product_option['option_id'],
                    'name'              => $product_option['name'],
                    'type'              => $product_option['type'],
                    'option_value'      => $product_option_value_data,
                    'required'          => $product_option['required']
                );
            } else {
                $product_option_data[] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'option_id'         => $product_option['option_id'],
                    'name'              => $product_option['name'],
                    'type'              => $product_option['type'],
                    'option_value'      => $product_option['option_value'],
                    'required'          => $product_option['required']
                );
            }
        }

        if (empty($product_option_data)) {
            return false;
        }

        return $product_option_data[0];
    }

    public function editProduct($product_id, $data, $language_id) {

        $product_sql = "UPDATE " . DB_PREFIX . "product SET ";

        if ($data['option']) {
            $product_option_value_id = (int)$data['option']['option_value'][0]['product_option_value_id'];
            $customer_groups         = $this->customer_groups;

            $pov_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_option_value_id = '" . $product_option_value_id . "'");
            if ($pov_query->num_rows) {
                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$data['quantity'] . "' WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");
            }

            foreach ($customer_groups as $c => $customer_group_ids) {
                if ($c == 1) {
                    $price = (float)$data['price'];
                } elseif ($c == 2) {
                    $price   = (float)$data['price'];
                    $special = (float)$data['special'];
                }

                $pod_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND customer_group_ids = '" . $customer_group_ids . "'");
                if ($pod_query->num_rows) {
                    $option_row = $pod_query->row;
                    if ($option_row['customer_group_ids'] == $customer_group_ids) {
                        $this->db->query("UPDATE " . DB_PREFIX . "myoc_pod SET price = '$price', special = '$special' WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND customer_group_ids = '" . $customer_group_ids . "'");
                    }
                } else {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod SET
							product_option_value_id	= '" . (int)$product_option_value_id . "',
							customer_group_ids		= '" . $this->db->escape($customer_group_ids) . "',
							quantity				= '1',
							calc_method				= 'p',
							price					= '" . $price . "',
							price_prefix			= '=',
							special					= '0.0000',
							special_prefix			= '-',
							option_base_points		= '0',
							points					= '0',
							points_prefix			= '+',
							priority				= '1',
							date_start				= '0000-00-00',
							date_end				= '0000-00-00'");
                }
            }
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "product_special SET price = '" . (float)$data['special'] . "' WHERE product_id = '" . (int)$product_id . "'");
            $product_sql .= "quantity = '" . (int)$data['quantity'] . "', ";
        }

        $product_sql .= "price = '" . (float)$data['price'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'";
        $sql         = $this->db->query($product_sql);
    }
}

?>

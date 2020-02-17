<?php
require 'vendors/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
    var $xls_pricelist_store = [];
    var $xls_pricelist_category = [];
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

    var $customer_groups = [];

    var $LNG = [];

    public function index() {
        $json = [];

        $action = 'download';

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
        $customer_groups = [];
        $groups = $this->model_xls_pricelist_helper_models->getCustomerGroups();
        foreach ($groups as $customer_group) {
            $customer_groups[$customer_group['customer_group_id']] = serialize(array($customer_group['customer_group_id']));
        }
        $this->customer_groups = $customer_groups;

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
            } else {
                $this->generate('download');
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
        $errors = [];
        if (!defined('HTTP_IMAGE')) {
            define('HTTP_IMAGE', HTTP_SERVER . 'image/');
        }

        set_error_handler(array(
            $this,
            'error_handler_for_export'
        ));

        ini_set("memory_limit", "1536M");
        ini_set("max_execution_time", 180);

        $_ = [];
        require(DIR_LANGUAGE . $this->xls_pricelist_language['directory'] . '/product/xls_pricelist.php');
        $this->LNG = $_;

        $max_filesize      = 20971520; // максимальный размер файла в БАЙТАХ.
        $allowed_filetypes = array(
            '.xlsx'
        ); // Это будут виды файлов, которые пройдут проверку (валидацию).
        $filename          = $_FILES['file']['name']; // получаем название файла (включая его расширение).
        $ext               = substr($filename, strpos($filename, '.'), strlen($filename) - 1); // Получаем расширение из названия файла.
        $file_strip        = str_replace(" ", "_", $filename); //Замещаем пробелы в названии файла
        $upload_path       = DIR_UPLOAD; //устанавливаем путь выгрузки

        if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
            $upload_path = preg_replace('/\//', '\\', $upload_path);
        }

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

        $rows = [];

        // Перемещаем файл, если он прошел все проверки.
        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path . $file_strip)) {
            try {
                $inputFileName = $upload_path . $file_strip;

                /**  Identify the type of $inputFileName  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);

                $sheet = $spreadsheet->getActiveSheet();

                /**  Convert Spreadsheet Object to an Array for ease of use  **/
                $rows = $sheet->toArray();
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

        $lines = 0;

        $id_index = 0;
        $image_index = 1;
        $model_index = 2;
        $sku_index = 3;
        $name_index = 4;
        $option_index = 5;
        $attribute_index = 6;
        $quantity_index = 7;
        $price_index = 8;
        $special_index = 9;
        $manufacturer_index = 10;
        $related2_index = 11;
        $status_index = 12;

        if (!empty($rows)) {
            foreach ($rows as $row) {
                if ($row[0]) {
                    if ($row[0] == 'ID') {
                        $id_index = array_search('ID', $row);
                        $image_index = array_search('Изображение', $row);
                        $model_index = array_search('Код', $row);
                        $sku_index = array_search('SKU', $row);
                        $name_index = array_search('Наименование', $row);
                        $option_index = array_search('Опции', $row);
                        $attribute_index = array_search('Атрибуты', $row);
                        $quantity_index = array_search('На складе', $row);
                        $price_index = array_search('Розница', $row);
                        $special_index = array_search('Опт', $row);
                        $manufacturer_index = array_search('Производитель', $row);
                        $related2_index = array_search('Рекомендуемые', $row);
                        $status_index = array_search('Cтатус', $row);
                    } else {
                        $product_id   = (int)$row[$id_index]; // ID
                        $image        = $row[$image_index]; // Изображение
                        $model        = $row[$model_index]; // Код
                        $sku          = $row[$sku_index]; // SKU
                        $name         = $row[$name_index]; // Наименование
                        $options      = $row[$option_index]; // Опции
                        $attributes   = trim($row[$attribute_index]); // Атрибуты
                        $quantity     = (int)$row[$quantity_index]; // На складе
                        $price        = (int)$row[$price_index]; // Розница
                        $special      = (int)$row[$special_index]; // Опт
                        $manufacturer = $row[$manufacturer_index]; // Производитель
                        $related2     = trim($row[$related2_index]); // Рекомендуемые
                        $stock_status = $row[$status_index]; // Cтатус

                        $status = 0;
                        if ($stock_status == 'В наличии') {
                            $status = 1;
                        } elseif ($stock_status == 'Отсутствует') {
                            $stock_status = 'Нет в наличии';
                        }

                        $stock_status_id = $this->getStatusId($stock_status);

                        $manufacturer_id = $this->getManufacturerId($manufacturer);

                        $option = $this->getOptionBySKU($product_id, $sku);

                        $attribute = $this->getAttributes($attributes);

                        $related  = $this->getRelatedByModel($related2);

                        $data = [
                            'model'           => $model,
                            'sku'             => $sku,
                            'name'            => $name,
                            'option'          => $option,
                            'attribute'       => $attribute,
                            'related'         => $related,
                            'quantity'        => $quantity,
                            'price'           => $price,
                            'special'         => $special,
                            'manufacturer_id' => $manufacturer_id,
                            'stock_status_id' => $stock_status_id,
                            'status'          => $status
                        ];

                        $this->editProduct($product_id, $data, $language_id);

                        $lines++;
                    }
                }
            }

            $this->editProductsQuantity();
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
        ini_set("max_execution_time", 1800);

        $_ = [];
        require(DIR_LANGUAGE . $this->xls_pricelist_language['directory'] . '/product/xls_pricelist.php');
        $this->LNG = $_;

        ///////////
        $f_name = [
            'font' => [
                'bold'  => false,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_title_color ? $this->xls_pricelist_title_color : '000000')
                ),
                'size'  => 20,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $f_address = [
            'font' => [
                'bold'  => false,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_adress_color ? $this->xls_pricelist_adress_color : '000000')
                ),
                'size'  => 14,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $f_phone = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_phone_color ? $this->xls_pricelist_phone_color : '000000')
                ),
                'size'  => 10,
                'name'  => 'Cambria'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $f_email = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_email_color ? $this->xls_pricelist_email_color : '339966')
                ),
                'size'  => 10,
                'name'  => 'Cambria'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $f_link = [
            'font' => [
                'bold'      => false,
                'underline' => true,
                'color'     => array(
                    'argb' => '00' . ($this->xls_pricelist_link_color ? $this->xls_pricelist_link_color : '0000ff')
                ),
                'size'      => 10,
                'name'      => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $f_custom = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_custom_color ? $this->xls_pricelist_custom_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        $fu = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_thead_color ? $this->xls_pricelist_thead_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_thead_color_bg) {
            $fu['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_thead_color_bg
                ],
            ];
        }

        $fe = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_underthead_color_bg) {
            $fe['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_underthead_color_bg
                ],
            ];
        }

        $this->f_image = [
            'font' => [
                'color' => array(
                    'argb' => '00000000'
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_image_color_bg) {
            $this->f_image['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_image_color_bg
                ],
            ];
        }

        $this->f_model = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_model_color ? $this->xls_pricelist_model_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_model_color_bg) {
            $this->f_model['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_model_color_bg
                ],
            ];
        }

        $this->f_name = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_name_color ? $this->xls_pricelist_name_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_name_color_bg) {
            $this->f_name['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_name_color_bg
                ],
            ];
        }

        $this->f_stock = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_stock_color ? $this->xls_pricelist_stock_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_stock_color_bg) {
            $this->f_stock['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_stock_color_bg
                ],
            ];
        }

        $this->f_price = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_price_color ? $this->xls_pricelist_price_color : '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_price_color_bg) {
            $this->f_price['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_price_color_bg
                ],
            ];
        }

        $this->f_special = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_special_color ? $this->xls_pricelist_special_color : 'FF0000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_special_color_bg) {
            $this->f_special['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_special_color_bg
                ],
            ];
        }

        $fc1 = [
            'font' => [
                'bold' => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_category0_color ? $this->xls_pricelist_category0_color : 'FFFFFF')
                ),
                'size'  => 13,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category0_color_bg) {
            $fc1['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category0_color_bg
                ],
            ];
        }

        $fc2 = [
            'font' => [
                'bold'   => true,
                'italic' => true,
                'color'  => array(
                    'argb' => '00' . ($this->xls_pricelist_category1_color ? $this->xls_pricelist_category1_color : '000000')
                ),
                'size'   => 9,
                'name'   => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category1_color_bg) {
            $fc2['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category1_color_bg
                ],
            ];
        }

        $fc3 = [
            'font' => [
                'bold'   => true,
                'italic' => true,
                'color'  => array(
                    'argb' => '00' . ($this->xls_pricelist_category2_color ? $this->xls_pricelist_category2_color : '000000')
                ),
                'size'   => 8,
                'name'   => 'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category2_color_bg) {
            $fc3['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category2_color_bg
                ],
            ];
        }

        $fc_arr = [$fc1, $fc2, $fc3];

        if ($this->xls_pricelist_logo || $this->xls_pricelist_use_image) {
            $this->load->model('tool/image');
        }

        $row_height = ($this->xls_pricelist_image_height ? $this->xls_pricelist_image_height + 2 : 52) * 3 / 4;

        $image_height = $this->xls_pricelist_image_height ? $this->xls_pricelist_image_height : 50;
        $image_width = $this->xls_pricelist_image_width ? $this->xls_pricelist_image_width : 50;

        $heads = [
            [
                'name'  => 'ID',
                'check' => true,
                'width' => 5,
            ], [
                'name'  => 'Изображение',
                'check' => $this->xls_pricelist_use_image,
                'width' => $this->xls_pricelist_image_width,
            ], [
                'name'  => 'Код',
                'check' => $this->xls_pricelist_use_code,
                'width' => $this->xls_pricelist_model_width,
            ], [
                'name'  => 'SKU',
                'check' => true,
                'width' => $this->xls_pricelist_model_width,
            ], [
                'name'  => 'Наименование',
                'check' => true,
                'width' => $this->xls_pricelist_name_width,
            ], [
                'name'  => 'Опции',
                'check' => true,
                'width' => 20,
            ], [
                'name'  => 'Атрибуты',
                'check' => true,
                'width' => 30,
            ], [
                'name'  => 'На складе',
                'check' => true,
                'width' => $this->xls_pricelist_stock_width,
            ], [
                'name'  => 'Розница',
                'check' => true,
                'width' => $this->xls_pricelist_price_width,
            ], [
                'name'  => 'Опт',
                'check' => true,
                'width' => $this->xls_pricelist_price_width,
            ], [
                'name'  => 'Производитель',
                'check' => true,
                'width' => 15,
            ], [
                'name'  => 'Рекомендуемые',
                'check' => true,
                'width' => 15,
            ], [
                'name'  => 'Cтатус',
                'check' => true,
                'width' => $this->xls_pricelist_price_width,
            ], [
                'name'  => 'Акция',
                'check' => $this->xls_pricelist_use_special,
                'width' => $this->xls_pricelist_special_width,
            ],
        ];

        $spreadsheet = new Spreadsheet();

        mb_internal_encoding("Windows-1251");

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

            $this->load->model('xls_pricelist/helper_models');
            $cust_groups = explode("_", $this->xls_pricelist_customer_group);

            $this->load->model('catalog/product');

            $sh = 0;

            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet->setTitle('Pricelist');

            if ($this->xls_pricelist_use_collapse) {
                $worksheet->setShowSummaryBelow(false); ////collapse
            }

            if ($this->xls_pricelist_use_protection) {
                $worksheet->getProtection()->setPassword($this->xls_pricelist_use_password); ///protection
                $worksheet->getProtection()->setSheet(true); ///protection
            }

            $row = 1;
            $col = 1;
            $name_column = 'E';
            $name_column_number = 5;
            $last_column = 'L';

            foreach ($heads as $head) {
                if ($head['check']) {
                    $column = $worksheet->getCellByColumnAndRow($col, $row)->getColumn();

                    if ($head['name'] == 'Изображение') {
                        $col_width = (($this->xls_pricelist_image_width ? $this->xls_pricelist_image_width + 2 : 52) - 5) / 7;

                        if ($col_width > 12) {
                            $worksheet->getColumnDimension($column)->setWidth($col_width);
                            $this->l_margin = $col_width * 7 + 5 - ($image_width);
                        } else {
                            $worksheet->getColumnDimension($column)->setWidth(12);
                            $this->l_margin = 12 * 7 + 5 - ($image_width);
                        }
                    } else {
                        if ($head['name'] == 'Наименование') {
                            $name_column_number = $col;
                        }

                        $worksheet->getColumnDimension($column)->setWidth((int)$head['width']);
                    }

                    $last_column = $worksheet->getCellByColumnAndRow($col, $row)->getColumn();

                    $col++;
                }
            }

            $row++;

            ///logo
            if ($this->xls_pricelist_logo) {
                $logo = $this->model_tool_image->resize($this->xls_pricelist_logo, $this->xls_pricelist_logo_width ? $this->xls_pricelist_logo_width : 50, $this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height : 50);

                if ($logo) {

                    $rh = ($this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height + 2 : 52) * 3 / 4;
                    $worksheet->getRowDimension('1')->setRowHeight($rh);

                    $objDrawing = new Drawing();
                    $objDrawing->setName('Image');
                    $objDrawing->setDescription('Image');
                    $objDrawing->setPath(str_replace(HTTP_IMAGE, DIR_IMAGE, $logo));
                    $objDrawing->setHeight($this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height : 50);
                    $objDrawing->setWorksheet($worksheet);

                    $columnsize = ($worksheet->getColumnDimensionByColumn(1)->getWidth()) * 7 + 5;

                    if ($columnsize > $this->xls_pricelist_logo_width) {
                        $objDrawing->setOffsetX(($columnsize - $this->xls_pricelist_logo_width) / 2);
                    } else {
                        $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                    }
                    $objDrawing->setOffsetY(2);
                }

                $row++;
            }
            // 2
            $worksheet->setCellValueByColumnAndRow(5, $row, $this->xls_pricelist_title ? $this->xls_pricelist_title : $this->config->get('config_name'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_name);
            $row++;
            // 3
            $worksheet->setCellValueByColumnAndRow(5, $row, $this->xls_pricelist_adress ? $this->xls_pricelist_adress : $this->config->get('config_address'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_address);
            $row++;
            // 5
            $worksheet->setCellValueByColumnAndRow(5, $row, $this->xls_pricelist_phone ? $this->xls_pricelist_phone : (($this->config->get('config_telephone') ? $this->LNG['text_phone'] . ' ' . $this->config->get('config_telephone') : '') . '     ' . ($this->config->get('config_fax') ? $this->LNG['text_fax'] . ' ' . $this->config->get('config_fax') : '')));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_phone);
            $row++;
            // 5
            $worksheet->setCellValueByColumnAndRow(5, $row, $this->xls_pricelist_email ? $this->xls_pricelist_email : 'e-mail:' . $this->config->get('config_email'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_email);
            $row++;
            // 6
            $worksheet->setCellValueByColumnAndRow(5, $row, $this->config->get('config_url'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_link);
            $worksheet->getCellByColumnAndRow(5, 6)->getHyperlink()->setUrl($this->xls_pricelist_link ? $this->xls_pricelist_link : $this->config->get('config_url'));
            $row++;

            if ($this->xls_pricelist_custom_text) {
                $worksheet->setCellValueByColumnAndRow(5, $row, str_replace("\r", "", $this->xls_pricelist_custom_text));
                $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->applyFromArray($f_custom);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow(5, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                $row++;
            }

            $worksheet->setCellValueByColumnAndRow($col, $row, '');
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($fu);
            $row++;

            $col = 1; // Заголовки
            foreach ($heads as $head) {
                if ($head['check']) {
                    $worksheet->setCellValueByColumnAndRow($col, $row, $head['name']);
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($fu);

                    if ($head['name'] == 'Опции' || $head['name'] == 'Атрибуты' || $head['name'] == 'Рекомендуемые') {
                        $worksheet->getColumnDimensionByColumn($col)->setAutoSize(true);
                    }

                    $col++;
                }
            }

            $row++;

            $categories = [];

            $category_ids = explode("_", $this->xls_pricelist_category);

            foreach ($category_ids as $category_id) {
                $category = $this->model_xls_pricelist_helper_models->getCategory($category_id, $this->xls_pricelist_language['language_id']);
                if ($category) {
                    $categories[] = $category;
                }
            }

            foreach ($categories as $category) {
                $level = $this->model_xls_pricelist_helper_models->getCategoryLevel($category['category_id'], 0, $this->xls_pricelist_language['language_id']);
                $path  = $this->model_xls_pricelist_helper_models->getCategoryPath($category['category_id'], [], $this->xls_pricelist_language['language_id']);

                $level1 = $level;
                if ($level > 2) {
                    $level1 = 2;
                }

                $col = 1; // Категории
                foreach ($heads as $head) {
                    if ($head['check']) {
                        if ($head['name'] == 'Наименование') {
                            $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($category['name'], ENT_QUOTES, 'UTF-8'));
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($fc_arr[$level1]);
                            $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $path)));
                        } else {
                            $worksheet->setCellValueByColumnAndRow($col, $row, '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($fc_arr[$level1]);
                        }
                        $col++;
                    }
                }

                if ($this->xls_pricelist_use_collapse && $level) {
                    $worksheet->getRowDimension($row)->setOutlineLevel($level); //////collapse
                    $worksheet->getRowDimension($row)->setVisible(false); //////collapse
                    $worksheet->getRowDimension($row)->setCollapsed(true); //////collapse
                }

                list($sort, $order) = explode('-', $this->xls_pricelist_sort_order);

                $data = array(
                    'filter_category_id' => $category['category_id'],
                    'sort'               => $sort,
                    'order'              => $order,
                    'start'              => 0,
                    'limit'              => 1000000000,
                    'customer_group_id'  => $cust_groups,
                    'language_id'        => $this->xls_pricelist_language['language_id'],
                    'filter_dubles'      => $this->xls_pricelist_nodubles
                );

                $results = $this->model_xls_pricelist_helper_models->getProducts($data);

                foreach ($results as $result) {
                    $options = [];

                    if ($this->xls_pricelist_use_options) {
                        $options = $this->model_xls_pricelist_helper_models->getProductOptions($result['product_id'], $this->xls_pricelist_language['language_id']);
                    }

                    $related2 = $this->model_xls_pricelist_helper_models->getProductRelated2($result['product_id']);

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

                    if (empty($options)) {
                        $col = 1;
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

                        $row++;

                        if ($this->xls_pricelist_use_collapse) {
                            $worksheet->getRowDimension($row)->setOutlineLevel($level); ///collapse
                            $worksheet->getRowDimension($row)->setVisible(false); ///collapse
                            $worksheet->getRowDimension($row)->setCollapsed(true); ///collapse
                        }

                        $worksheet->setCellValueByColumnAndRow($col, $row, $result['product_id']);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                        $col++;

                        if ($this->xls_pricelist_use_image) {
                            if ($result['image']) {
                                $image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
                            } else {
                                $image = $this->model_tool_image->resize('no_image.jpg', $image_width, $image_height);
                            }

                            if ($image) {
                                $filename = str_replace(HTTP_IMAGE, DIR_IMAGE, $image);

                                if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
                                    $filename = preg_replace('/\//', '\\', $filename);

                                    $encoding = mb_detect_encoding($filename);

                                    if ($encoding == 'UTF-8') {
                                        $filename = mb_convert_encoding($filename, "windows-1251", "utf-8");
                                    }
                                }

                                $worksheet->getRowDimension('' . $row . '')->setRowHeight($row_height);

                                try {
                                    $objDrawing = new Drawing();
                                    $objDrawing->setPath($filename);
                                    $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate());
                                    $objDrawing->setHeight($image_height);
                                    $objDrawing->setWorksheet($worksheet);
                                    $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                                    $objDrawing->setOffsetY(2);

                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_image);
                                } catch(PhpOffice\PhpSpreadsheet\Exception $e) {
                                    $worksheet->setCellValueByColumnAndRow($col, $row, $e->getMessage());
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                                }
                            } else {
                                $worksheet->setCellValueByColumnAndRow($col, $row, 'no image');
                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                            }

                            $col++;
                        }

                        if ($this->xls_pricelist_use_code) {
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                            $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['' . $this->xls_pricelist_code . ''], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            $col++;
                        }

                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['sku'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $col++;

                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_name);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                        $col++;

                        $worksheet->setCellValueByColumnAndRow($col, $row, ' ');
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                        $col++;

                        $attr_groups = [];

                        $attribute_group_ids = explode("_", $this->xls_pricelist_attribute_group); // id всех групп атрибутов

                        $attribute_groups = $this->model_xls_pricelist_helper_models->getProductAttributes($result['product_id'], $this->xls_pricelist_language['language_id']);

                        if (!empty($attribute_groups)) {
                            foreach ($attribute_groups as $attribute_group) {
                                if (!in_array($attribute_group['attribute_group_id'], $attribute_group_ids))
                                    continue;

                                $attributes = [];
                                $attr_group = '';

                                if ($this->xls_pricelist_use_attributes) {
                                    $attr_group .= $attribute_group['name'] . ": ";
                                }

                                foreach ($attribute_group['attribute'] as $attribute) {
                                    $attributes[] = $attribute['name'] . " - " . $attribute['text'];
                                }

                                $attr_group .= implode(" | ", $attributes);

                                $attr_groups[] = $attr_group;
                            }
                        }

                        $attr_string = '';

                        if (!empty($attr_groups)) {
                            $attr_string = implode(",\r\n", $attr_groups);
                            $attr_height = 12 * count($attr_groups);
                            if ($attr_height > $row_height) {
                                $worksheet->getRowDimension('' . $row . '')->setRowHeight($attr_height);
                            }
                        }

                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($attr_string, ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_name);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $col++;

                        $worksheet->setCellValueByColumnAndRow($col, $row, $quantity);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                        $col++;

                        if (is_array($price_gid)) {
                            foreach ($price_gid as $k => $v) {
                                $worksheet->setCellValueByColumnAndRow($col, $row, $v ? $v : '');
                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                $col++;
                            }
                        } else {
                            $worksheet->setCellValueByColumnAndRow($col, $row, $price ? $price : '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                            $col++;
                        }

                        $worksheet->setCellValueByColumnAndRow($col, $row, $result['manufacturer'] ? $result['manufacturer'] : '');
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                        $col++;

                        $related_string = '';

                        if (!empty($related2)) {
                            $related_string = implode(" | ", $related2);
                        }

                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($related_string, ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_name);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $col++;

                        $worksheet->setCellValueByColumnAndRow($col, $row, $status);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                        $col++;

                        if ($this->xls_pricelist_use_special) {
                            $worksheet->setCellValueByColumnAndRow($col, $row, $special ? $special : '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_special);
                        }
                    } else {
                        foreach ($options as $option) {

                            if (!empty($result['special']) && $result['special']) {
                                $product_base_price = $result['special'];
                            } else {
                                $product_base_price = $result['price'];
                            }

                            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                                foreach ($option['option_value'] as $option_value) {

                                    $col = 1;

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

                                    $row++;
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

                                    $worksheet->setCellValueByColumnAndRow($col, $row, $result['product_id']);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                                    $col++;

                                    if ($this->xls_pricelist_use_image) {
                                        if ($option_value['image']) {
                                            $image1 = $this->model_tool_image->resize($option_value['image'], $image_width, $image_height);
                                        } else {
                                            $image1 = $this->model_tool_image->resize('no_image.jpg', $image_width, $image_height);
                                        }

                                        if ($image1) {
                                            $filename = str_replace(HTTP_IMAGE, DIR_IMAGE, $image1);

                                            if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
                                                $filename = preg_replace('/\//', '\\', $filename);

                                                $encoding = mb_detect_encoding($filename);

                                                if ($encoding == 'UTF-8') {
                                                    $filename = mb_convert_encoding($filename, "windows-1251", "utf-8");
                                                }
                                            }

                                            $worksheet->getRowDimension('' . $row . '')->setRowHeight($row_height);

                                            try {
                                                $objDrawing = new Drawing();
                                                $objDrawing->setPath($filename);
                                                $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate());
                                                $objDrawing->setHeight($image_height);
                                                $objDrawing->setWorksheet($worksheet);
                                                $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                                                $objDrawing->setOffsetY(2);

                                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_image);
                                            } catch(PhpOffice\PhpSpreadsheet\Exception $e) {
                                                $worksheet->setCellValueByColumnAndRow($col, $row, $e->getMessage());
                                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                                            }
                                        } else {
                                            $worksheet->setCellValueByColumnAndRow($col, $row, 'no image');
                                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                                        }

                                        $col++;
                                    }

                                    if ($this->xls_pricelist_use_code) {
                                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['' . $this->xls_pricelist_code . ''] . '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                                        $col++;
                                    }

                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_model);
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($option_value['sku'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_name);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($option['name'] . ': ' . $option_value['name'], ENT_QUOTES, 'UTF-8'));
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_name);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, ' ');
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, $quantity);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_stock);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, $retail_price);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, $wholesale_price);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, ($result['manufacturer']) ? $result['manufacturer'] : ' ');
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, ($result['manufacturer']) ? $result['manufacturer'] : ' ');
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                    $col++;

                                    $worksheet->setCellValueByColumnAndRow($col, $row, $status);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_price);
                                    $col++;

                                    if ($this->xls_pricelist_use_special) {
                                        $worksheet->setCellValueByColumnAndRow($col, $row, $special ? $special : '');
                                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($this->f_special);
                                    }

                                    if ($this->xls_pricelist_use_collapse) {
                                        $worksheet->getRowDimension($row)->setOutlineLevel($level); ///collapse
                                        $worksheet->getRowDimension($row)->setVisible(false); ///collapse
                                        $worksheet->getRowDimension($row)->setCollapsed(true); ///collapse
                                    }
                                }
                            }
                        }
                    }
                }

                $row++;
            }
            $sh++;

            if ($method == 'view') {
                $writer = new Html($spreadsheet);
                try {
                    $writer->save('php://output');
                } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
                    echo $e->getMessage();
                }
                
                exit();
                break;
            } elseif ($method == 'download') {
                header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                header('Content-Disposition: attachment;filename="price_download' . $this->xls_pricelist_language['code'] . $store . '.xlsx"');

                $writer = new Xlsx($spreadsheet);
                try {
                    $writer->save('php://output');
                } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                $writer = new Xlsx($spreadsheet);
                try {
                    $writer->save(DIR_DOWNLOAD . "price_" . $this->xls_pricelist_language['code'] . $store . ".xlsx");
                } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
                    echo $e->getMessage();
                }
                break;
            }

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }
    }

    public function getProductId($model) {
        $product_id = 0;

        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

        if ($query->num_rows) {
            $product_id = $query->row['product_id'];
        }

        return $product_id;
    }

    public function getStatusId($stock_status) {
        $stock_status_id = 0;

        $query = $this->db->query("SELECT stock_status_id FROM " . DB_PREFIX . "stock_status WHERE name = '" . $this->db->escape($stock_status) . "'");

        if ($query->num_rows) {
            $stock_status_id = $query->row['stock_status_id'];
        }

        return $stock_status_id;
    }

    /**
     * @param $manufacturer
     * @return int
     */
    public function getManufacturerId($manufacturer) {
        $manufacturer_id = 0;

        $query = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE name = '" . $this->db->escape($manufacturer) . "'");

        if ($query->num_rows) {
            $manufacturer_id = $query->row['manufacturer_id'];
        }

        return $manufacturer_id;
    }

    public function getOptionBySKU($product_id, $sku) {
        $product_option_data = [];

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                $product_option_value_data = [];

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.ob_sku = '" . $sku . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->rows as $product_option_value) {
                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id'         => $product_option_value['option_value_id'],
                        'name'                    => $product_option_value['name'],
                        'image'                   => $product_option_value['image'],
                        'quantity'                => $product_option_value['quantity'],
                        'ob_quantity'             => $product_option_value['ob_quantity'],
                        'ob_sku'                  => $product_option_value['ob_sku'],
                        'ob_image'                => $product_option_value['ob_image'],
                        'ob_kod'                  => $product_option_value['ob_kod'],
                        'ob_upc'                  => $product_option_value['ob_upc'],
                        'subtract'                => $product_option_value['subtract'],
                        'price'                   => $product_option_value['price'],
                        'price_prefix'            => $product_option_value['price_prefix'],
                        'weight'                  => $product_option_value['weight'],
                        'weight_prefix'           => $product_option_value['weight_prefix'],
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

    public function getAttributes($attribute_string) {
        $product_attribute_data = [];

        if ($attribute_string != '') {
            $attribute_groups = explode(",\n", $attribute_string);

            foreach ($attribute_groups as $attribute_group) {
                $attribute_strings = explode(" | ", $attribute_group);

                foreach ($attribute_strings as $attribute_string) {
                    $attribute = explode(" - ", $attribute_string);

                    $attribute_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE name LIKE '%" . $this->db->escape($attribute[0]) . "%'");

                    if ($attribute_query->num_rows) {
                        $product_attribute_data[$attribute_query->row['attribute_id']] = $attribute[1];
                    }
                }
            }
        }

        return $product_attribute_data;
    }

    public function getRelatedByModel($related_string) {
        $product_related = [];

        if ($related_string != '') {
            $models = explode(" | ", $related_string);

            foreach ($models as $model) {
                $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

                if ($product_query->num_rows) {
                    $product_related[] = $product_query->row['product_id'];
                }
            }
        }

        return $product_related;
    }

    public function editProduct($product_id, $data, $language_id) {
        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {

            $product_sql = "UPDATE " . DB_PREFIX . "product SET ";

            if ($data['option']) {
                $product_option_value_id = (int)$data['option']['option_value'][0]['product_option_value_id'];

                $customer_groups = $this->customer_groups;

                $pov_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_option_value_id = '" . $product_option_value_id . "'");
                if ($pov_query->num_rows) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$data['quantity'] . "', ob_quantity = '" . (int)$data['quantity'] . "' WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");
                }

                foreach ($customer_groups as $c => $customer_group_ids) {
                    if ($c == 1) {
                        $price = (float)$data['price'];
                        $special = 0.0000;
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

                $product_sql .= "quantity = '" . (int)$data['quantity'] . "', upc_quantity = '" . (int)$data['quantity'] . "', ";
            }

            if ($data['attribute']) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

                foreach ($data['attribute'] as $attribute_id => $product_attribute_text) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_text) . "'");
                }
            }

            if ($data['related']) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE related_id = '" . (int)$product_id . "'");

                foreach ($data['related'] as $related_id) {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
                }
            }
        }

        $product_sql .= "price = '" . (float)$data['price'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'";
        $sql = $this->db->query($product_sql);
    }

    public function editProductsQuantity() {
        $this->load->model('catalog/product');

        $data = [
            'filter_category_id' => 0,
            'filter_filter'      => '',
            'sort'               => 'p.sort_order',
            'order'              => 'ASC',
            'start'              => 0,
            'limit'              => 10000,
            'coolfilter'         => '',
        ];

        $results = $this->model_catalog_product->getProducts($data);

        if ($results) {
            foreach ($results as $result) {
                $product_id = $result['product_id'];

                $gtd = (isset($result['upc_more']) && $result['upc_more']) ? 1 : 0;

                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$result['upc_quantity'] . "', quantity = '" . (int)$result['upc_quantity'] . "' WHERE product_id = '" . (int)$product_id . "'");

                $product_options = $this->model_catalog_product->getProductOptions($product_id);

                if (empty($product_options)) {
                    if ($gtd) {
                        $this->model_catalog_product->setProductQuantity($product_id, $result['model'], $result['upc_quantity']);
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$result['upc_quantity'] . "' WHERE product_id = '" . $product_id . "'");
                    }
                } else {
                    foreach ($product_options as $product_option) {
                        if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                            if (isset($product_option['option_value']) && count($product_option['option_value']) > 0) {
                                $option_quantity         = 0; // количество в опции
                                $product_option_quantity = 0; // количество в опции товара
                                foreach ($product_option['option_value'] as $product_option_value) {
                                    if ($gtd) {
                                        $option_quantity += $this->model_catalog_product->setGroupOptionQuantity($product_id, $product_option_value['ob_sku'], $product_option_value['ob_quantity']);
                                    } else {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$product_option_value['ob_quantity'] . "' WHERE product_id = '" . $product_id . "' AND ob_sku = '" . $product_option_value['ob_sku'] . "'");
                                    }

                                    $product_option_quantity += (int)$product_option_value['ob_quantity'];
                                }

                                if ($gtd) {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$option_quantity . "' WHERE model = '" . $result['model'] . "'");
                                    $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");

                                    $this->model_catalog_product->setGroupProductQuantity($product_id, $result['model']);
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$product_option_quantity . "', upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
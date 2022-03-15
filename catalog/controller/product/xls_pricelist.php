<?php
require 'vendors/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Exception;

class ControllerProductXlsPricelist extends Controller
{
    private $columns = [];
    private $styles = [];

    public $delim = 0;
    public $l_margin = 0;
    public $xls_pricelist_store = [];
    public $xls_pricelist_category = [];
    public $xls_pricelist_use_image = '';
    public $xls_pricelist_image_width = 50;
    public $xls_pricelist_image_height = 50;
    public $xls_pricelist_title = '';
    public $xls_pricelist_adress = '';
    public $xls_pricelist_phone = '';
    public $xls_pricelist_email = '';
    public $xls_pricelist_link = '';
    public $xls_pricelist_custom_text = '';
    public $xls_pricelist_title_color = '';
    public $xls_pricelist_adress_color = '';
    public $xls_pricelist_phone_color = '';
    public $xls_pricelist_email_color = '';
    public $xls_pricelist_link_color = '';
    public $xls_pricelist_custom_color = '';
    public $xls_pricelist_sort_order = '';
    public $xls_pricelist_currency = '';
    public $xls_pricelist_customer_group = '';
    public $xls_pricelist_attribute_group = '';
    public $xls_pricelist_listname = '';
    public $xls_pricelist_use_options = '';
    public $xls_pricelist_use_attributes = '';
    public $xls_pricelist_nodubles = '';
    public $xls_pricelist_use_quantity = '';
    public $xls_pricelist_use_notinstock = '';
    public $xls_pricelist_language = [];
    public $xls_pricelist_usecache = 'no';
    public $xls_pricelist_memcacheServer = 'localhost';
    public $xls_pricelist_memcachePort = 11211;
    public $xls_pricelist_cacheTime = 600;
    public $xls_pricelist_use_special = '';
    public $xls_pricelist_use_code = '';
    public $xls_pricelist_code = '';
    public $xls_pricelist_model_width = '';
    public $xls_pricelist_name_width = '';
    public $xls_pricelist_stock_width = '';
    public $xls_pricelist_price_width = '';
    public $xls_pricelist_special_width = '';

    public $xls_pricelist_logo = '';
    public $xls_pricelist_logo_width = '';
    public $xls_pricelist_logo_height = '';
    public $xls_pricelist_use_collapse = 0;
    public $xls_pricelist_use_protection = 0;
    public $xls_pricelist_use_password = '';

    public $xls_pricelist_thead_color = '';
    public $xls_pricelist_thead_color_bg = '';
    public $xls_pricelist_underthead_color_bg = '';
    public $xls_pricelist_category0_color = '';
    public $xls_pricelist_category0_color_bg = '';
    public $xls_pricelist_category1_color = '';
    public $xls_pricelist_category1_color_bg = '';
    public $xls_pricelist_category2_color = '';
    public $xls_pricelist_category2_color_bg = '';

    public $xls_pricelist_image_color_bg = '';
    public $xls_pricelist_model_color = '';
    public $xls_pricelist_model_color_bg = '';
    public $xls_pricelist_name_color = '';
    public $xls_pricelist_name_color_bg = '';
    public $xls_pricelist_stock_color = '';
    public $xls_pricelist_stock_color_bg = '';
    public $xls_pricelist_price_color = '';
    public $xls_pricelist_price_color_bg = '';
    public $xls_pricelist_special_color = '';
    public $xls_pricelist_special_color_bg = '';

    public $customer_groups = [];

    public $LNG = [];

    /**
     * @return void
     */
    public function init()
    {
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

        $xls_pricelist_colors = $this->config->get('xls_pricelist_colors');

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

        $this->columns = [
            'id' => [
                'name'  => 'ID',
                'check' => true,
                'width' => 5,
            ],
            'image' => [
                'name'  => 'Изображение',
                'check' => $this->xls_pricelist_use_image,
                'width' => $this->xls_pricelist_image_width,
            ],
            'model' => [
                'name'  => 'Модель',
                'check' => $this->xls_pricelist_use_code,
                'width' => 20,
            ],
            'kod' => [
                'name'  => 'Штрихкод',
                'check' => true,
                'width' => 11,
            ],
            'article' => [
                'name'  => 'Артикул',
                'check' => true,
                'width' => 20,
            ],
            'name' => [
                'name'  => 'Наименование',
                'check' => true,
                'width' => $this->xls_pricelist_name_width,
            ],
            'report_name' => [
                'name'  => 'Наименование для отчётов',
                'check' => true,
                'width' => $this->xls_pricelist_name_width,
            ],
            'options' => [
                'name'  => 'Опции',
                'check' => true,
                'width' => 20,
            ],
            'attributes' => [
                'name'  => 'Атрибуты',
                'check' => true,
                'width' => 30,
            ],
            'instock' => [
                'name'  => 'На складе',
                'check' => true,
                'width' => 10,
            ],
            'retail' => [
                'name'  => 'Розница',
                'check' => true,
                'width' => 10,
            ],
            'wholesale' => [
                'name'  => 'Опт',
                'check' => true,
                'width' => 10,
            ],
            'manufacturer' => [
                'name'  => 'Производитель',
                'check' => true,
                'width' => 15,
            ],
            'featured' => [
                'name'  => 'Рекомендуемые',
                'check' => true,
                'width' => 15,
            ],
            'status' => [
                'name'  => 'Cтатус',
                'check' => true,
                'width' => 11,
            ],
            'action' => [
                'name'  => 'Акция',
                'check' => $this->xls_pricelist_use_special,
                'width' => $this->xls_pricelist_special_width,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function index() {
        $json = [];

        $action = 'download';

        if (isset($this->request->post['action'])) {
            $action = $this->request->post['action'];
        } elseif (isset($this->request->get['action'])) {
            $action = $this->request->get['action'];
        }

        $qty = 0;

        if (isset($this->request->post['qty'])) {
            $qty = (int)$this->request->post['qty'];
        } elseif (isset($this->request->get['qty'])) {
            $qty = (int)$this->request->get['qty'];
        }

        if (!$this->config->get('xls_pricelist_view')) {
            if ($action != 'generate' && $action != 'upload') {
                $this->redirect($this->url->link('error/not_found'));
            }
        }

        $this->load->model('xls_pricelist/helper_models');

        $customer_groups = [];

        $groups = $this->model_xls_pricelist_helper_models->getCustomerGroups();

        foreach ($groups as $customer_group) {
            $customer_groups[$customer_group['customer_group_id']] = serialize(array($customer_group['customer_group_id']));
        }

        $this->customer_groups = $customer_groups;

        $this->init();

        $this->load->model('localisation/language');

        $languages = $this->model_localisation_language->getLanguages();

        $xls_pricelist_description = $this->config->get('xls_pricelist_description');

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
                $this->upload($qty);
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

    /**
     * @return void
     * @throws Exception
     */
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

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @return bool
     */
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

    /**
     * @return void
     */
    public function fatal_error_shutdown_handler_for_export() {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            $this->error_handler_for_export(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

    /**
     * @param int $qty
     * @return void
     * @throws Exception
     */
    private function upload($qty = 0) {
        global $log;

        $errors = [];
        if (!defined('HTTP_IMAGE')) {
            define('HTTP_IMAGE', HTTP_SERVER . 'image/');
        }

        set_error_handler(array(
            $this,
            'error_handler_for_export'
        ));

        ini_set("memory_limit", "1536M");
        ini_set("max_execution_time", 1800);

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
            $inputFileName = $upload_path . $file_strip;

            try {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($inputFileName);
                $worksheet = $spreadsheet->getActiveSheet();
            } catch (Exception $e) {
                $log->write('Ошибка: ' . $e->getMessage());
                $errors[] = 'Ошибка: ' . $e->getMessage();
            }
        } else {
            $log->write('Файл ' . $file_strip . ' не загружен. Попробуйте позже.');
            $errors[] = 'Файл ' . $file_strip . ' не загружен. Попробуйте позже.';
        }

        if (!empty($errors)) {
            echo json_encode($errors);
            die();
        }

        $language_id = $this->xls_pricelist_language['language_id'];

        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        $row0 = 1;
        $lines = 0;
        $id_index = 1;

        $excluded_columns = [
            'image',
        ];

        for ($row = $row0; $row <= $highestRow; ++$row) {
            $product_id = (int)$worksheet->getCellByColumnAndRow($id_index, $row)->getValue(); // ID

            if ($product_id) {
                $params = [];
                $column = $id_index;

                foreach ($this->columns as $slug => $head) {
                    if ($head['check']) {
                        if (!in_array($slug, $excluded_columns)) {
                            $params[$slug] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        $column++;
                    }
                }

                $data = [
                    'model'           => $params['model'] ?: '',
                    'kod'             => $params['kod'] ?: '',
                    'sku'             => $params['article'] ?: '',
                    'name'            => $params['name'] ?: '',
                    'report_name'     => $params['report_name'] ?: '',
                    'option'          => $params['article'] ? $this->getOptionBySKU($product_id, $params['article']) : [],
                    'attribute'       => $params['attributes'] ? $this->getAttributes($params['attributes']) : [],
                    'related'         => $params['featured'] ? $this->getRelatedByModel($params['featured']) : [],
                    'quantity'        => (int)$params['instock'],
                    'price'           => (float)$params['retail'],
                    'special'         => (float)$params['wholesale'],
                    'manufacturer_id' => trim($params['manufacturer']) ? $this->getManufacturerId(trim($params['manufacturer'])) : 0,
                    'stock_status_id' => $params['status'] ? $this->getStatusId($params['status']) : 0,
                    'status'          => ($params['status'] == 'В наличии') ? 1 : 0
                ];

                $this->editProduct($product_id, $data, $language_id, $qty);

                $lines++;
            }
        }

        $spreadsheet->disconnectWorksheets();

        $this->editProductsQuantity();

        echo json_encode('Загружено ' . $lines . ' строк из таблицы');
        die();
    }

    /**
     * @return void
     */
    private function initStyles() {
        $head = []; // Стили шапки

        $head['title'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_title_color ?: '000000')
                ),
                'size'  => 20,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
        ];

        $head['address'] = [
            'font' => [
                'bold'  => false,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_adress_color ?: '000000')
                ),
                'size'  => 14,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $head['phone'] = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_phone_color ?: '000000')
                ),
                'size'  => 10,
                'name'  => 'Cambria'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $head['email'] = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_email_color ?: '339966')
                ),
                'size'  => 10,
                'name'  => 'Cambria'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $head['link'] = [
            'font' => [
                'bold'      => false,
                'underline' => true,
                'color'     => array(
                    'argb' => '00' . ($this->xls_pricelist_link_color ?: '0000ff')
                ),
                'size'      => 10,
                'name'      => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $head['headers'] = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_thead_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_BOTTOM
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_thead_color_bg) {
            $head['headers']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_thead_color_bg
                ],
            ];
        }

        $category = []; // Стили категорий

        $category[0] = [
            'font' => [
                'bold' => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_category0_color ?: 'FFFFFF')
                ),
                'size'  => 13,
                'name'  => 'BELL MT'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category0_color_bg) {
            $category[0]['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category0_color_bg
                ],
            ];
        }

        $category[1] = [
            'font' => [
                'bold'   => true,
                'italic' => true,
                'color'  => array(
                    'argb' => '00' . ($this->xls_pricelist_category1_color ?: '000000')
                ),
                'size'   => 9,
                'name'   => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category1_color_bg) {
            $category[1]['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category1_color_bg
                ],
            ];
        }

        $category[2] = [
            'font' => [
                'bold'   => true,
                'italic' => true,
                'color'  => array(
                    'argb' => '00' . ($this->xls_pricelist_category2_color ?: '000000')
                ),
                'size'   => 8,
                'name'   => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_category2_color_bg) {
            $category[2]['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_category2_color_bg
                ],
            ];
        }

        $table = []; // Стили таблицы

        $table['id'] = $table['id_option'] = [
            'font' => [
                'color' => [
                    'argb' => '00000000'
                ],
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $table['id_option']['fill'] = [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => '00EEEEEE'
            ],
        ];

        $table['name'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_name_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_name_color_bg) {
            $table['name']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_name_color_bg
                ],
            ];
        }

        $table['custom'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_custom_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
        ];

        $table['custom2'] = [
            'font' => [
                'bold'  => true,
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_thead_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_BOTTOM
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_thead_color_bg) {
            $table['custom2']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_thead_color_bg
                ],
            ];
        }

        $table['image'] = [
            'font' => [
                'color' => array(
                    'argb' => '00000000'
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_image_color_bg) {
            $table['image']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_image_color_bg
                ],
            ];
        }

        $table['model'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_model_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_model_color_bg) {
            $table['model']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_model_color_bg
                ],
            ];
        }

        $table['stock'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_stock_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_stock_color_bg) {
            $table['stock']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_stock_color_bg
                ],
            ];
        }

        $table['price'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_price_color ?: '000000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_price_color_bg) {
            $table['price']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_price_color_bg
                ],
            ];
        }

        $table['special'] = [
            'font' => [
                'color' => array(
                    'argb' => '00' . ($this->xls_pricelist_special_color ?: 'FF0000')
                ),
                'size'  => 8,
                'name'  => 'Arial'
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        if ($this->xls_pricelist_special_color_bg) {
            $table['special']['fill'] = [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00' . $this->xls_pricelist_special_color_bg
                ],
            ];
        }

        $this->styles['head'] = $head; // Стили шапки
        $this->styles['category'] = $category; // Стили категорий
        $this->styles['table'] = $table; // Стили таблицы
    }

    /**
     * @param $text
     * @return false|int
     */
    private function isRussian($text) {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    /**
     * @throws Exception
     */
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

        $this->initStyles();

        if ($this->xls_pricelist_logo || $this->xls_pricelist_use_image) {
            $this->load->model('tool/image');
        }

        $spreadsheet = new Spreadsheet();

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
            $name_column = 'F';
            $name_column_number = 6;
            $last_column = 'O';

            $head_style = $this->styles['head'];

            $row_height = $row_height0 = ($this->xls_pricelist_image_height ? $this->xls_pricelist_image_height + 2 : 52) * 3 / 4;

            $image_height = $this->xls_pricelist_image_height ?: 50;
            $image_width = $this->xls_pricelist_image_width ?: 50;

            foreach ($this->columns as $slug => $head) {
                if ($head['check']) {
                    $column = $worksheet->getCellByColumnAndRow($col, $row)->getColumn();

                    if ($slug == 'image') {
                        $col_width = (($this->xls_pricelist_image_width ? $this->xls_pricelist_image_width + 2 : 52) - 5) / 7;

                        if ($col_width > 12) {
                            $worksheet->getColumnDimension($column)->setWidth($col_width);
                            $this->l_margin = $col_width * 7 + 5 - ($image_width);
                        } else {
                            $worksheet->getColumnDimension($column)->setWidth(12);
                            $this->l_margin = 12 * 7 + 5 - ($image_width);
                        }
                    } else {
                        if ($slug == 'name') {
                            $name_column_number = $col;
                        }

                        $worksheet->getColumnDimension($column)->setWidth((int)$head['width']);
                    }

                    $last_column = $worksheet->getCellByColumnAndRow($col, $row)->getColumn();

                    $col++;
                }
            }

            $row++;

            $header_index = 6; // Колонка для заголовка таблицы

            ///logo
            if ($this->xls_pricelist_logo) {
                $logo = $this->model_tool_image->resize($this->xls_pricelist_logo, $this->xls_pricelist_logo_width ?: 50, $this->xls_pricelist_logo_height ?: 50);

                if ($logo) {

                    $rh = ($this->xls_pricelist_logo_height ? $this->xls_pricelist_logo_height + 2 : 52) * 3 / 4;
                    $worksheet->getRowDimension('1')->setRowHeight($rh);

                    $objDrawing = new Drawing();
                    $objDrawing->setName('Image');
                    $objDrawing->setDescription('Image');
                    $objDrawing->setPath(str_replace(HTTP_IMAGE, DIR_IMAGE, $logo));
                    $objDrawing->setHeight($this->xls_pricelist_logo_height ?: 50);
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
            $worksheet->setCellValueByColumnAndRow($header_index, $row, $this->xls_pricelist_title ?: $this->config->get('config_name'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['title']);
            $row++;
            // 3
            $worksheet->setCellValueByColumnAndRow($header_index, $row, $this->xls_pricelist_adress ?: $this->config->get('config_address'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['address']);
            $row++;
            // 4
            $worksheet->setCellValueByColumnAndRow($header_index, $row, $this->xls_pricelist_phone ?: (($this->config->get('config_telephone') ? $this->LNG['text_phone'] . ' ' . $this->config->get('config_telephone') : '') . '     ' . ($this->config->get('config_fax') ? $this->LNG['text_fax'] . ' ' . $this->config->get('config_fax') : '')));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['phone']);
            $row++;
            // 5
            $worksheet->setCellValueByColumnAndRow($header_index, $row, $this->xls_pricelist_email ?: 'e-mail:' . $this->config->get('config_email'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['email']);
            $row++;
            // 6
            $worksheet->setCellValueByColumnAndRow($header_index, $row, $this->config->get('config_url'));
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['link']);
            $worksheet->getCellByColumnAndRow($header_index, $row)->getHyperlink()->setUrl($this->xls_pricelist_link ?: $this->config->get('config_url'));
            $row++;

            if ($this->xls_pricelist_custom_text) {
                $worksheet->setCellValueByColumnAndRow($header_index, $row, str_replace("\r", "", $this->xls_pricelist_custom_text));
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->applyFromArray($head_style['custom']);
                $worksheet->getStyle($worksheet->getCellByColumnAndRow($header_index, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                $row++;
            }

            $worksheet->setCellValueByColumnAndRow($col, $row, '');
            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($head_style['headers']);
            $row++;

            $col = 1; // Заголовки
            foreach ($this->columns as $slug => $head) {
                if ($head['check']) {
                    $worksheet->setCellValueByColumnAndRow($col, $row, $head['name']);
                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($head_style['headers']);

                    if ($slug == 'options' || $slug == 'attributes' || $slug == 'featured') {
                        $worksheet->getColumnDimensionByColumn($col)->setAutoSize(true);
                    }

                    $col++;
                }
            }

            $row++;

            /* Категории */
            $category_style = $this->styles['category'];
            $table_style = $this->styles['table'];

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
                foreach ($this->columns as $slug => $head) {
                    if ($head['check']) {
                        if ($slug == 'name') {
                            $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($category['name'], ENT_QUOTES, 'UTF-8'));
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($category_style[$level1]);
                            $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $path)));
                        } else {
                            $worksheet->setCellValueByColumnAndRow($col, $row, '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($category_style[$level1]);
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

                    $related_string = '';

                    $related2 = $this->model_xls_pricelist_helper_models->getProductRelated2($result['product_id']);

                    if (!empty($related2)) {
                        $related_string = implode(" ", $related2);
                    }

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

                        /* id */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['product_id'], DataType::TYPE_STRING);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['id']);
                        $col++;

                        /* image */
                        if ($this->xls_pricelist_use_image) {
                            if ($result['image']) {
                                $image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);

                                if ($image) {
                                    $filename = str_replace(HTTP_IMAGE, DIR_IMAGE, $image);

                                    $ciryllic = 0;

                                    if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
                                        $ciryllic = $this->isRussian($filename);

                                        if ($ciryllic) {
                                            mb_internal_encoding("Windows-1251");
                                            $filename = mb_convert_encoding($filename, "Windows-1251", "UTF-8");
                                        }
                                    }

                                    try {
                                        $objDrawing = new Drawing();
                                        $objDrawing->setPath($filename);
                                        $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate());
                                        $objDrawing->setHeight($image_height);
                                        $objDrawing->setWorksheet($worksheet);
                                        $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                                        $objDrawing->setOffsetY(2);
                                    } catch(Exception $e) {
                                        $worksheet->setCellValueByColumnAndRow($col, $row, $e->getMessage());
                                    }

                                    if ($ciryllic) {
                                        mb_internal_encoding("UTF-8");
                                    }
                                } else {
                                    $worksheet->setCellValueByColumnAndRow($col, $row, 'no resize image');
                                }
                            } else {
                                $worksheet->setCellValueByColumnAndRow($col, $row, 'no result image');
                            }

                            $worksheet->getRowDimension($row)->setRowHeight($row_height);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['image']);

                            $col++;
                        }

                        /* model */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['model'], DataType::TYPE_STRING);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                        $col++;

                        /* sku */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['sku'], DataType::TYPE_STRING);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                        $col++;

                        /* model */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['model'], DataType::TYPE_STRING);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                        $col++;

                        /* name */
                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                        $col++;

                        /* report_name */
                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['report_name'], ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $col++;

                        /* option */
                        $worksheet->setCellValueByColumnAndRow($col, $row, '');
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
                                $worksheet->getRowDimension('' . $row)->setRowHeight($attr_height);
                            }
                        }

                        /* attribute */
                        $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($attr_string, ENT_QUOTES, 'UTF-8'));
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $col++;

                        /* stock */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($quantity, DataType::TYPE_STRING);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['stock']);
                        $col++;

                        /* retail, wholesale */
                        if (is_array($price_gid)) {
                            foreach ($price_gid as $v) {
                                $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($v ?: '', DataType::TYPE_STRING);
                                $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                                $col++;
                            }
                        } else {
                            $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($price ?: '', DataType::TYPE_STRING);
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                            $col++;
                            $col++;
                        }

                        /* manufacturer */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['manufacturer'] ?: '', DataType::TYPE_STRING);
                        $worksheet->setCellValueByColumnAndRow($col, $row, $result['manufacturer'] ?: '');
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                        $col++;

                        /* featured */
                        $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($related_string ?: '', DataType::TYPE_STRING2);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getNumberFormat()->setFormatCode('@');
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['stock']);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                        $col++;

                        /* status */
                        $worksheet->setCellValueByColumnAndRow($col, $row, $status);
                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                        $col++;

                        /* special */
                        if ($this->xls_pricelist_use_special) {
                            $worksheet->setCellValueByColumnAndRow($col, $row, $special ?: '');
                            $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['special']);
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

                                    /* id */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['product_id'], DataType::TYPE_STRING);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['id_option']);
                                    $col++;

                                    /* image */
                                    if ($this->xls_pricelist_use_image) {
                                        if ($option_value['image']) {
                                            $image = $this->model_tool_image->resize($option_value['image'], $image_width, $image_height);

                                            if ($image) {
                                                $filename = str_replace(HTTP_IMAGE, DIR_IMAGE, $image);

                                                $ciryllic = 0;

                                                if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
                                                    $ciryllic = $this->isRussian($filename);

                                                    if ($ciryllic) {
                                                        mb_internal_encoding("Windows-1251");
                                                        $filename = mb_convert_encoding($filename, "Windows-1251", "UTF-8");
                                                    }
                                                }

                                                try {
                                                    $objDrawing = new Drawing();
                                                    $objDrawing->setPath($filename);
                                                    $objDrawing->setCoordinates($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate());
                                                    $objDrawing->setHeight($image_height);
                                                    $objDrawing->setWorksheet($worksheet);
                                                    $objDrawing->setOffsetX($this->l_margin / 2 + 1);
                                                    $objDrawing->setOffsetY(2);
                                                } catch(Exception $e) {
                                                    $worksheet->setCellValueByColumnAndRow($col, $row, $e->getMessage());
                                                }

                                                if ($ciryllic) {
                                                    mb_internal_encoding("UTF-8");
                                                }
                                            } else {
                                                $worksheet->setCellValueByColumnAndRow($col, $row, 'no resize option image');
                                            }
                                        } else {
                                            $worksheet->setCellValueByColumnAndRow($col, $row, 'no option image');
                                        }

                                        $worksheet->getRowDimension('' . $row)->setRowHeight($row_height);
                                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['image']);

                                        $col++;
                                    }

                                    /* model */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($result['model'], DataType::TYPE_STRING);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                                    $col++;

                                    /* kod */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($option_value['kod'], DataType::TYPE_STRING);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                                    $col++;

                                    /* sku */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($option_value['sku'], DataType::TYPE_STRING);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['model']);
                                    $col++;

                                    /* name */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $worksheet->getCellByColumnAndRow($col, $row)->getHyperlink()->setUrl(str_replace('&amp;', '&', $this->url->link('product/product', 'path=' . $path . '&product_id=' . $result['product_id'])));
                                    $col++;

                                    /* report_name */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($result['report_name'], ENT_QUOTES, 'UTF-8'));
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $col++;

                                    /* option */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, html_entity_decode($option['name'] . ': ' . $option_value['name'], ENT_QUOTES, 'UTF-8'));
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['name']);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $col++;

                                    /* attribute */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, '');
                                    $col++;

                                    /* stock */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($quantity, DataType::TYPE_STRING);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['stock']);
                                    $col++;

                                    /* retail */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, $retail_price);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                                    $col++;

                                    /* wholesale */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, $wholesale_price);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                                    $col++;

                                    /* manufacturer */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, ($result['manufacturer']) ?: ' ');
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                                    $col++;

                                    /* featured */
                                    $worksheet->getCellByColumnAndRow($col, $row)->setValueExplicit($related_string ?: '', DataType::TYPE_STRING2);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getNumberFormat()->setFormatCode('@');
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['stock']);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->getAlignment()->setWrapText(true);
                                    $col++;

                                    /* status */
                                    $worksheet->setCellValueByColumnAndRow($col, $row, $status);
                                    $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['price']);
                                    $col++;

                                    /* special */
                                    if ($this->xls_pricelist_use_special) {
                                        $worksheet->setCellValueByColumnAndRow($col, $row, $special ?: '');
                                        $worksheet->getStyle($worksheet->getCellByColumnAndRow($col, $row)->getCoordinate())->applyFromArray($table_style['special']);
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
                } catch (Exception $e) {
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
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                $writer = new Xlsx($spreadsheet);
                try {
                    $writer->save(DIR_DOWNLOAD . "price_" . $this->xls_pricelist_language['code'] . $store . ".xlsx");
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                break;
            }

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }
    }

    /**
     * @param $model
     * @return int|mixed
     */
    public function getProductId($model) {
        $product_id = 0;

        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

        if ($query->num_rows) {
            $product_id = $query->row['product_id'];
        }

        return $product_id;
    }

    /**
     * @param $stock_status
     * @return int|mixed
     */
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

    /**
     * @param $product_id
     * @param $sku
     * @return array|false|mixed
     */
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

    /**
     * @param $attribute_string
     * @return array
     */
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

    /**
     * @param $related_string
     * @return array
     */
    public function getRelatedByModel($related_string) {
        $product_related = [];

        if ($related_string != '') {
            $models = explode(" ", $related_string);

            foreach ($models as $model) {
                $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

                if ($product_query->num_rows) {
                    $product_related[] = $product_query->row['product_id'];
                }
            }
        }

        return $product_related;
    }

    /**
     * @param int $product_id
     * @param array $data
     * @param int $language_id
     * @param int $qty
     * @return void
     */
    public function editProduct($product_id, $data, $language_id, $qty = 0) {
        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {

            $product_description_sql = "UPDATE " . DB_PREFIX . "product_description SET ";

            $product_description_fields = [];

            if ($data['name']) {
                $product_description_fields[] = "name = '" . $data['name'] . "'";
            }

            if ($data['report_name']) {
                $product_description_fields[] = "report_name = '" . $data['report_name'] . "' ";
            }

            if (!empty($product_description_fields)) {
                $product_description_sql .= implode(", ", $product_description_fields);
            }

            $product_description_sql .= " WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'";

            $this->db->query($product_description_sql);

            $product_sql = "UPDATE " . DB_PREFIX . "product SET ";

            if ($data['option']) {
                $product_option_value_id = (int)$data['option']['option_value'][0]['product_option_value_id'];

                $customer_groups = $this->customer_groups;

                $pov_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_option_value_id = '" . $product_option_value_id . "'");
                if ($pov_query->num_rows) {
                    if ($qty) {
                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$data['quantity'] . "', ob_quantity = '" . (int)$data['quantity'] . "', ob_kod = '" . $data['kod'] . "' WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_kod = '" . $data['kod'] . "' WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");
                    }
                }

                foreach ($customer_groups as $c => $customer_group_ids) {
                    if ($c == 1) {
                        $price = (float)$data['price'];
                        $special = 0.00;
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
							special					= '0.00',
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

                if ($qty) {
                    $product_sql .= "quantity = '" . (int)$data['quantity'] . "', upc_quantity = '" . (int)$data['quantity'] . "', ";
                }
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

            $product_sql .= "price = '" . (float)$data['price'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'";

            $this->db->query($product_sql);
        }
    }

    /**
     * @return void
     */
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

                $upc_more = (isset($result['upc_more']) && $result['upc_more']) ? 1 : 0;

                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$result['upc_quantity'] . "', quantity = '" . (int)$result['upc_quantity'] . "' WHERE product_id = '" . (int)$product_id . "'");

                $product_options = $this->model_catalog_product->getProductOptions($product_id);

                if (empty($product_options)) {
                    if ($upc_more) {
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
                                    if ($upc_more) {
                                        $option_quantity += $this->model_catalog_product->setGroupOptionQuantity($product_id, $product_option_value['ob_sku'], $product_option_value['ob_quantity']);
                                    } else {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$product_option_value['ob_quantity'] . "' WHERE product_id = '" . $product_id . "' AND ob_sku = '" . $product_option_value['ob_sku'] . "'");
                                    }

                                    $product_option_quantity += (int)$product_option_value['ob_quantity'];
                                }

                                if ($upc_more) {
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
<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMReport/IMRepLic100.php';
require_once DIR_SYSTEM . 'IMReport/IMReportHelper.php';
require_once DIR_SYSTEM . 'IMReport/IMReportConfig.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelList.php';

class ControllerModuleIMReport extends Controller {
	private $error = array();
	private $warning = array();
	private $module_version = '2.5.0';

	// Стартовая страница контроллера
	public function index() {
		$this->load->language('module/IMReport');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		$this->AddScriptAndStyles();

		// Загрузка моделей
		$this->load->model('setting/setting');
		$this->load->model('module/IMReport');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('IMReport', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->_formLink('module/IMReport'));
		}

		// Данные
		$data = array();

		////////////////////////////////////
		// Стандартные данные
		////////////////////////////////////

		$data['module_version'] = $this->module_version;
		$data['heading_title'] = $this->language->get('heading_title');
		$data['h1_text'] = $this->language->get('heading_title_h1');
		$data['h2_text'] = $this->language->get('heading_title_h2');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');

		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');


		////////////////////////////////////
		// Добавленные данные
		////////////////////////////////////
		$data['module_label'] = $this->language->get('module_label');
		$data['module_table_header'] = $this->language->get('module_table_header');
		$data['module_js_texts'] = $this->language->get('module_js_texts');
		$data['module_btn_label'] = $this->language->get('module_btn_label');

		// Кнопки
		$data['module_button'] = $this->language->get('module_button');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		////////////////////////////////////
		// Строим хлебные крошки
		////////////////////////////////////
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->_formLink('common/home'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->_formLink('extension/module'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->_formLink('module/IMReport'),
      		'separator' => ' :: '
   		);

		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$data['report_links'] = array();

		////////////////////////////////////
		// Ссылки модуля
		////////////////////////////////////
		$data['report_links']['saveIMRepSettings']
			= $this->_formLink('module/IMReport/saveIMRepSettings');

		$data['report_links']['top_product']
			= $this->_formLink('module/IMReport/getReportData', 'action=topProduct');

		$data['report_links']['client_group']
			= $this->_formLink('module/IMReport/getReportData', 'action=clientGroup');

		$data['report_links']['ship_region']
			= $this->_formLink('module/IMReport/getReportData', 'action=shipRegion');

		$data['report_links']['man_product']
			= $this->_formLink('module/IMReport/getReportData', 'action=manProduct');

		$data['report_links']['order_sales']
			= $this->_formLink('module/IMReport/getReportData', 'action=orderSales');

		// 1.5
		$data['report_links']['client_orders']
			= $this->_formLink('module/IMReport/getReportData', 'action=clientOrders');

		// 1.5
		$data['report_links']['option_sales']
			= $this->_formLink('module/IMReport/getReportData', 'action=optionSales');

		// 1.6.0
		$data['report_links']['product_option_sales']
			= $this->_formLink('module/IMReport/getReportData', 'action=productOptionSales');

		// 1.7.0
		$data['report_links']['product_option_quantity']
			= $this->_formLink('module/IMReport/getReportData', 'action=productOptionQuantity');

		// 1.8.0
		$data['report_links']['stock_control']
			= $this->_formLink('module/IMReport/getReportData', 'action=stockControl');

		// 1.8.0
		$data['report_links']['stock_control_set']
			= $this->_formLink('module/IMReport/getReportData', 'action=stockControlSet');

		// 1.8.0
		$data['report_links']['stock_control_set_data']
			= $this->_formLink('module/IMReport/setReportData', 'action=stockControlSetData');

		// 2.0.0
		$data['report_links']['order_ps']
			= $this->_formLink('module/IMReport/getReportData', 'action=orderPaymShip');

		// 2.2.0
		$data['report_links']['product_nosales']
			= $this->_formLink('module/IMReport/getReportData', 'action=productNoSales');

		// 2.4.0
		$data['report_links']['order_sales_by_day']
			= $this->_formLink('module/IMReport/getReportData', 'action=orderSalesByDay');

		// 2.5.0
		$data['report_links']['order_ship']
			= $this->_formLink('module/IMReport/getReportData', 'action=orderShip');

		////////////////////////////////////
		// Ссылки на контроллеры ядра
		////////////////////////////////////

		$data['report_links']['link_to_client']
			= $this->_formLink('sale/customer/update');

		$data['report_links']['link_to_order']
			= $this->_formLink('sale/order/info');

		$data['report_links']['cancel']
			= $this->_formLink('extension/module');

		$data['report_links']['link_to_product']
			= $this->_formLink('catalog/product/update');

		$data['report_links']['link_to_category']
			= $this->_formLink('catalog/category/update');

		// 2.4.0
		$data['report_links']['link_to_sale_order']
			= $this->_formLink('sale/order');

		// 2.4.0
		////////////////////////////////////
		// Ссылки для ajax загрузки
		////////////////////////////////////
		$data['report_links']['link_ajax_load_cust']
			= $this->_formLink('module/IMReport/getCustomerByFilter');

		$data['report_links']['link_ajax_load_cust_group']
			= $this->_formLink('module/IMReport/getCustomerGroupByFilter');

		$data['modules'] = array();

		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMReport_module'])) {
			$data['modules'] = $this->request->post['IMReport_module'];
		} elseif ($this->config->get('IMReport_module')) {
			$data['modules'] = $this->config->get('IMReport_module');
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		//$template = 'module/IMReport.tpl';
		$this->template = 'module/IMReport.tpl';
		//$data['header'] = $this->load->controller('common/header');
		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['footer'] = $this->load->controller('common/footer');

		setcookie('token', $this->session->data['token']);

		////////////////////////////
		// Загрузка всяких данных и справочников
		////////////////////////////

		$this->getForm($data);

		$this->children = array (
			'common/header',
			'common/footer'
		);

		////////////////////////////
		// Вьюшки
		////////////////////////////

		// Клиенты
		$data['client_orders_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_client.tpl' )
		);

		// Опции продажи
		$data['option_sales_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_option.tpl' )
		);

		// Продажи продукты с опциями
		$data['product_option_sales_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_product_option.tpl' )
		);

		// Опции количество
		$data['product_option_quantity_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_product_option_quantity.tpl' )
		);

		// Контроль остатков
		$data['stock_control_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_stock_control.tpl' )
		);

		// Контроль остатков (настройки)
		$data['stock_control_set_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_stock_control_set.tpl' )
		);

		// Заказы (клиенты, оплаты, доставка)
		$data['order_ps_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_order_ps.tpl' )
		);

		// Настройки модуля
		$data['module_settings_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_settings.tpl' )
		);

		// Товары без продаж
		$data['product_nosales_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_product_nosales.tpl' )
		);

		// 2.4.0
		// Оборот заказов по дням
		$data['order_sales_by_day_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_order_sales_by_day.tpl' )
		);

		// 2.5.0
		// Доставка
		$data['order_ship_view'] = $this->getChild(
			'module/IMReport/getReportView',
			array( 'data' => $data, 'view' => 'IMReport_order_ship.tpl' )
		);

		// Мерджим данные
		$this->data = array_merge($this->data, $data);

		// Вывод
		$this->response->setOutput($this->render());
		//$this->response->setOutput($this->load->view($template, $data));
	}

	////////////////////////////////////////////
	// Подключеие стилей и скриптов
	////////////////////////////////////////////
	protected function AddScriptAndStyles()
	{
		////////////////////////////
		// Поддержка возможностей 2-й версии
		////////////////////////////
		$this->document->addStyle('view/javascript/IMReport/bootstrap.css');
		$this->document->addStyle('view/javascript/IMReport/font-awesome/css/font-awesome.min.css');
		//$this->document->addStyle('view/javascript/IMReport/summernote/summernote.css');
		$this->document->addScript('view/javascript/IMReport/jquery/jquery-2.1.1.min.js');
		$this->document->addScript('view/javascript/IMReport/bootstrap/js/bootstrap.min.js');
		$this->document->addScript('view/javascript/IMReport/jquery.fix.js');
		$this->document->addScript('view/javascript/jquery/superfish/js/superfish.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/moment.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/locale/ru.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('view/javascript/IMReport/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		////////////////////////////
		// Подгрузка необходимого для модуля
		////////////////////////////
		// Поддержка графиков
		$this->document->addScript('view/javascript/IMReport/jquery/flot/jquery.flot.js');
		$this->document->addScript('view/javascript/IMReport/jquery/flot/jquery.flot.resize.min.js');
		// Поддержка графиков
		//$this->document->addScript('view/javascript/jquery/flot/jquery.flot.js');
		//$this->document->addScript('view/javascript/jquery/flot/jquery.flot.resize.min.js');

		// Стандартный скрипт
		$this->document->addScript('view/javascript/IMReport/jquery.imrep.js');

		// Select2
		$this->document->addStyle('view/javascript/IMReport/vendor/select2/select2.min.css');
		$this->document->addScript('view/javascript/IMReport/vendor/select2/select2.full.min.js');

		// Сортировка и фильтрация
		$this->document->addStyle('view/javascript/IMReport/css/jquery.tablesorter.pager.css');
		$this->document->addStyle('view/javascript/IMReport/css/style.css');
		$this->document->addScript('view/javascript/IMReport/jquery.tablesorter.js');
		$this->document->addScript('view/javascript/IMReport/jquery.tablesorter.pager.js');
		$this->document->addScript('view/javascript/IMReport/jquery.tablesorter.imFilter.js');
		$this->document->addScript('view/javascript/IMReport/jquery.imreport.helper.js');
	}

	////////////////////////////////////////////
	// Стандартная функция вьюхи
	////////////////////////////////////////////
	public function getReportView($data = array())
	{
		$viewName = $data['view'];
		$viewData = $data['data'];

		$this->data = array_merge($this->data, $viewData);

		$this->template = 'module/' . $viewName;
		$this->response->setOutput($this->render ());

		//return $this->load->view('module/' . $viewName, $viewData);
	}

	////////////////////////////////////////////
	// Функция подгрузки списка языков и списка категорий
	////////////////////////////////////////////
	private function getForm(&$data) {
		$this->load->model('localisation/language');

		$model_list = new IMReportModelList($this->db, $this->language, $this->config);

		// 1.7.0
		$select_all_items = $this->language->get('select_all_items');

		// 1.7.0
		$data['module_months'] = $this->language->get('module_months');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];

		$this->load->model('module/IMReport');

		// Загружаем категории
		$categories = $model_list->getCategoriesFull();
		$firstItem = array();
		$firstItem[] = array(
			'id' => -1,
			'name' => $select_all_items,
			'status' => 1,
			'sort_order' => -1
		);
		$categories = array_merge($firstItem, $categories);

		$data['list_cat'] = $categories;

		// Загружаем текущий язык и статусы
		$language_id = $this->getCurrentLanguageId($data, true);

		$data['language_id'] = $language_id;
		$data['list_order_status'] = $model_list->getOrderStatus($language_id);

		// Загружаем список пользователей
		$data['list_cust'] = array();// $model_list->getCustomer();

		// Загружаем список групп пользователей
		$data['list_cust_group'] = array();// $model_list->getCustomerGroup($language_id);

		// Загружаем производителей
		$manufacturers = $model_list->getManufacturer();
		$data['list_manufact'] = $manufacturers;

		// 1.5
		// Загружаем список режимов для отчета по клиентам
		$clientModes = array();
		$clientModes[] = array( 'id' => '0', 'name' => 'Стандартный' );
		$clientModes[] = array( 'id' => '1', 'name' => 'Поиск только зарегистрированных (без покупок)' );
		$clientModes[] = array( 'id' => '2', 'name' => 'Поиск утерянных клиентов' );
		// 1.7.0
		$clientModes = $this->model_module_IMReport->translateOrderedList($clientModes, 'name', 'module_client_report_mode');

		$data['list_client_orders_modes'] = $clientModes;

		// 2.0.0
		$data['list_order_ship_name'] = $model_list->getShipNameListFromOrders();
		$data['list_order_ship_code'] = $model_list->getShipCodeListFromOrders();
		$data['list_order_paym_name'] = $model_list->getPaymNameListFromOrders();
		$data['list_order_paym_code'] = $model_list->getPaymCodeListFromOrders();

		// 1.8.0
		$default_min_need_quantity = intval($this->language->get('default_min_need_quantity'));
		$data['default_min_need_quantity'] = $default_min_need_quantity;

		// Есть ли главная категория
		$data['is_have_main_caterogy'] = $this->model_module_IMReport->isHaveMainCategory();
		$list_cat_main = array();
		$list_cat_main[] = array('id' => 0, 'name' => 'Отключено');
		$list_cat_main[] = array('id' => 1, 'name' => 'Включено');
		$data['list_cat_main']
			= $this->model_module_IMReport->translateOrderedList($list_cat_main, 'name', 'module_standard_onoff');

		// 2.1.0
		$list_on_off = array(
			array('id' => 0, 'name' => 'Отключено'),
			array('id' => 1, 'name' => 'Включено'),
		);
		$list_on_off = $this->model_module_IMReport->translateOrderedList($list_on_off, 'name', 'module_standard_onoff');
		$data['list_on_off'] = $list_on_off;

		// 2.1.0
		$list_iconv_enc_csv = array(
			array( 'id' => 0, 'name' => 'Windows-1251' ),
			array( 'id' => 1, 'name' => 'UTF-8 (BOM)' ),
			array( 'id' => 2, 'name' => 'Без кодирования' ),
		);
		$list_iconv_enc_csv = $this->model_module_IMReport->translateOrderedList($list_iconv_enc_csv, 'name', 'module_list_iconv_enc_csv');
		$data['list_iconv_enc_csv'] = $list_iconv_enc_csv;

		// 2.1.0
		$list_module_settings = $this->model_module_IMReport->getModuleSettings();
		$data['list_module_settings'] = $list_module_settings;
		$data['is_product_image_display'] = (int)$list_module_settings['IMReportData_p_img_use'];

		// 2.4.0
		$module_config = new IMReportConfig();
		$data['module_config'] = $module_config->getAllCfg();

		// 2.5.0
		$list_group_by_time = array(
			array( 'id' => 'day', 'name' => 'День' ),
			array( 'id' => 'week', 'name' => 'Неделя' ),
			array( 'id' => 'month', 'name' => 'Месяц' ),
			array( 'id' => 'year', 'name' => 'Год' ),
		);
		$list_group_by_time = $this->model_module_IMReport->translateOrderedList(
			$list_group_by_time, 'name', 'module_list_group_by_time'
		);
		$data['list_group_by_time'] = $list_group_by_time;

		$this->validate();

		$data['error_messages'] = $this->error;
		$data['warning_messages'] = $this->warning;

		$data['lic_info'] = $this->imlic->getInfo();

	}

	////////////////////////////////////////////
	// Получение и установка данных
	////////////////////////////////////////////

	////////////////////////////////////////////
	// Стаднартная функция для получения данных
	////////////////////////////////////////////
	public function getReportData()
	{
		$this->load->model('module/IMReport');
		$action = $this->request->get['action'];
		$json = array();

		if (isset($action) && !empty($action) && $this->validate()) {
			// 2.1.0
			if ((int)method_exists('ModelModuleIMReport', $action)) {
				$json['success'] = 1;
				if (isset($this->request->post['IMReport'])) {
					$json['data'] = $this->model_module_IMReport->$action($this->request->post['IMReport']);
				} else {
					$json['data'] = $this->model_module_IMReport->$action(array());
				}
				// CSV or JSON
				$this->formResponse($json, $this->request->post['IMReport']);
				return;
			}
		}

		$json['success'] = 0;
		$this->response->setOutput(json_encode($json));
	}

	////////////////////////////////////////////
	// Стаднартная функция для установки данных
	////////////////////////////////////////////
	public function setReportData()
	{
		$this->load->model('module/IMReport');
		$action = $this->request->get['action'];
		$json = array();

		if (isset($action) && !empty($action) && $this->validate()) {
			// 2.1.0
			if ((int)method_exists( 'ModelModuleIMReport', $action )) {
				$json['success'] = 1;

				if (isset($this->request->post['IMReport'])) {
					$json['data'] = $this->model_module_IMReport->$action($this->request->post['IMReport']);
				} else {
					$json['data'] = $this->model_module_IMReport->$action(array());
				}
				$this->response->setOutput(json_encode($json));
				return;
			}
		}

		$json['success'] = 0;
		$this->response->setOutput(json_encode($json));
	}

	////////////////////////////////////////////
	// Сохранить настройки генератора
	////////////////////////////////////////////
	public function saveIMRepSettings(){
		$this->load->model('setting/setting');
		$json = array();

		$postData = $this->request->post['IMReport'];

		$currSettingData = $this->model_setting_setting->getSetting('IMReportData');

		// 2.1.0
		$this->_moduleSettingsToIntAndDefault($postData);

		$currSettingData = array_merge($currSettingData, $postData);

		$this->model_setting_setting->editSetting('IMReportData', $currSettingData);

		$json['success'] = 1;

		$this->response->setOutput(json_encode($json));
	}

	// 2.4.0
	////////////////////////////////////////////
	// ajax подгрузка
	////////////////////////////////////////////
	public function getCustomerByFilter()
	{
		$filter = '';
		if (isset($this->request->get['q'])){
			$filter = $this->request->get['q'];
		}
		$json = array();

		$module_config = new IMReportConfig();
		$cfg = $module_config->getAllCfg();

		$model_list = new IMReportModelList($this->db, $this->language, $this->config);
		$json['data'] = $model_list->getCustomerByFilter($filter, $cfg['user']['limit_cust']);

		$json['success'] = 0;
		$this->response->setOutput(json_encode($json));
	}

	public function getCustomerGroupByFilter()
	{
		$this->load->model('localisation/language');
		$data = array();
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$language_id = $this->getCurrentLanguageId($data, true);

		$filter = '';
		if (isset($this->request->get['q'])){
			$filter = $this->request->get['q'];
		}
		$json = array();

		$module_config = new IMReportConfig();
		$cfg = $module_config->getAllCfg();

		$model_list = new IMReportModelList($this->db, $this->language, $this->config);
		$json['data']
			= $model_list->getCustomerGroupByFilter($filter, $cfg['user']['limit_cust_group'], $language_id);

		$json['success'] = 0;
		$this->response->setOutput(json_encode($json));
	}

	// 2.1.0
	////////////////////////////////////////////
	// Проверка значений и корректное сохранение
	////////////////////////////////////////////
	protected function _moduleSettingsToIntAndDefault(&$data)
	{
		if (isset($data) && is_array($data)) {
			$checkFields = array(
				'IMReportData_p_img_use',
				'IMReportData_p_img_w',
				'IMReportData_p_img_h',
				'IMReportData_csv_iconv',
			);
			$checkFields40 = array(
				'IMReportData_p_img_w',
				'IMReportData_p_img_h',
			);
			foreach($checkFields as $name) {
				if (isset($data[$name])) {
					$data[$name] = (int)$data[$name];
					if (in_array($name, $checkFields40)) {
						if ($data[$name] <= 0) {
							$data[$name] = 40;
						}
					}
				}
			}

		}
	}

	//////////////////////////////////
	// Дополнительные функции
	//////////////////////////////////

	protected function formResponse($json, $postModule)
	{
		$currency = $this->getCurrentCurrency();

		$json['currency_pattern']
			= $currency['symbol_left']
				. '[digit]'
			. $currency['symbol_right']
		;
		$json['success'] = 1;

		if (isset($postModule['is_csv']) && (''.$postModule['is_csv'] == '1')) {
			$module_settings = $this->model_module_IMReport->getModuleSettings();
			$this->formCSVNameAndHeader($module_settings);
			$this->response->setOutput($this->getCSVFromData($json['data'], $module_settings));
		}
		else {
			$this->response->setOutput(json_encode($json));
		}
	}

	protected function formCSVNameAndHeader($module_settings = array())
	{
		$price_export = date("Ymd-Hi").'_price_export.csv';

		// 2.1.0
		$encode = '';
		if ((int)$module_settings['IMReportData_csv_iconv'] == 0) {
			$encode = ';charset=windows-1251';
		} else if ((int)$module_settings['IMReportData_csv_iconv'] == 1) {
			$encode = ';charset=utf-8';
		}

		$this->response->addheader('Pragma: public');
		$this->response->addheader('Expires: 0');
		$this->response->addheader('Content-Description: File Transfer');
		$this->response->addheader('Content-Type: application/octet-stream');
		$this->response->addheader('Content-Disposition: attachment; filename=' . $price_export . $encode);
		$this->response->addheader('Content-Transfer-Encoding: binary');
	}

	// Формирование CSV из данных
	protected function getCSVFromData($data, $module_settings = array())
	{
		$output = '';
		$replace = array(';',"\n");
		$is_first_row = true;
		$headerOutput = '';

		// Проходимся по всем строчкам
		foreach($data as $row)
		{
			$is_first_cell = true;

			// Проходимся по всем ячейкам
			foreach($row as $key => $item)
			{
				if ($is_first_cell)
				{
					$is_first_cell = false;
					if ($is_first_row)
					{
						$headerOutput .= str_replace($replace, '', '' . $key);
					}
					$output .= str_replace($replace, '', '' . $item);
				}
				else
				{
					if ($is_first_row)
					{
						$headerOutput .= ';' . str_replace($replace, '', '' . $key);
					}
					$output .= ';' . str_replace($replace, '', '' . $item);
				}
			}

			$is_first_row = false;

			$output .= "\n";
		}

		// 2.1.0
		if ((int)$module_settings['IMReportData_csv_iconv'] == 0) {
			return iconv('UTF-8', 'Windows-1251', $headerOutput . "\n" . $output);
		} else if ((int)$module_settings['IMReportData_csv_iconv'] == 1) {
			return pack("CCC",0xef,0xbb,0xbf) . $headerOutput . "\n" . $output;
		}
		return $headerOutput . "\n" . $output;
	}

	// 1.7.0
	// Получение текущего языка
	protected function getCurrentLanguageId($data, $is_for_admin = false)
	{
		// Загружаем текущий язык и статусы
		$langs_temp = reset($data['languages']);
		$language_id = $langs_temp['language_id'];

		// OC 2.2 :(
		$langs_temp = $this->config->get('config_admin_language');
		if (isset($langs_temp) && !empty($langs_temp))
		{
			foreach($data['languages'] as $key => $lang_item)
			{
				if ($lang_item['code'] == $langs_temp)
				{
					$language_id = $lang_item['language_id'];
				}
			}
			//$language_id = $data['languages'][$this->config->get('config_admin_language')]['language_id'];
		}

		// OC 2.2 :(
		$langs_temp = $this->language->get('code');
		if (isset($langs_temp) && !empty($langs_temp))
		{
			foreach($data['languages'] as $key => $lang_item)
			{
				if ($lang_item['code'] == $langs_temp)
				{
					$language_id = $lang_item['language_id'];
				}
			}
			/*
			if (isset($data['languages'][$this->language->get('code')]))
			{
				$language_id = $data['languages'][$this->language->get('code')]['language_id'];
			}
			*/
		}

		// В админке не нужен язык из сессии
		if ($is_for_admin)
		{
			return $language_id;
		}

		if (isset($this->session->data['language']))
		{
			$langs_temp = $this->session->data['language'];

			foreach($data['languages'] as $key => $lang_item)
			{
				if ($lang_item['code'] == $langs_temp)
				{
					$language_id = $lang_item['language_id'];
				}
			}

			//$language_id = $data['languages'][$this->session->data['language']]['language_id'];
		}

		return $language_id;
	}

	// Получение текущей валюты
	protected function getCurrentCurrency()
	{
		$this->load->model('localisation/currency');
		$currencies = $this->model_localisation_currency->getCurrencies();

		if (method_exists($this->currency, 'getCode')){
			$currency = $currencies[$this->currency->getCode()];
		}
		// OC 2.2 :(
		else {
			$currency = reset($currencies);

			$temp_curr = $this->config->get('config_currency');
			if (isset($temp_curr) && !empty($temp_curr))
			{
				$currency = $currencies[$this->config->get('config_currency')];
			}

			//$temp_curr = $this->session->data['currency'];
			if (isset($this->session->data['currency']) && !empty($this->session->data['currency']))
			{
				$currency = $currencies[$this->session->data['currency']];
			}

		}

		return $currency;
	}

	protected function _formLink($url, $params = '')
	{
		return
			$this->url->link(
				$url,
				$this->_getToken() . ($params == '' ? '' : ('&' . $params)),
				'SSL'
			);
	}

	protected function _getToken()
	{
		return 'token=' . $this->session->data['token'];
	}

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////

	protected $imlic;

	// Проверка, что у пользователя есть необходимые права
	private function validate($only_edit = false) {
		$this->load->model('setting/setting');

		$data = $this->model_setting_setting->getSetting('IMReportData');

		if (!isset($this->imlic) || empty($this->imlic)) {
			$this->imlic = new IMRepLic100(
				$this,
				'IMReport(1.5)',
				(isset($data['IMReportData_key']) ? $data['IMReportData_key'] : ''),
				(isset($data['IMReportData_enc_mess']) ? $data['IMReportData_enc_mess'] : '')
			);
		}

		if (!$only_edit && !$this->imlic->isValid()) {
			$this->error['lic'] = $this->language->get('lic_permission');
		}

		if (!$this->user->hasPermission('modify', 'module/IMReport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	//////////////////////////////////
	// Установка и удаление
	//////////////////////////////////

	/////////////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////////////

	// Добавление кода
	protected function addPHPCode($path, $sign, $searchcode, $addCode, $addCodeAfter = true)
	{
		$content = file_get_contents($path);
		$content = str_replace(
			$searchcode,
			($addCodeAfter ? $searchcode : '')
			. '/* ' . $sign . ' Start */'
				.$addCode
			. '/* ' . $sign . ' End */'
			. (!$addCodeAfter ? $searchcode : ''),
			$content
		);

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}

	// Удаление кода
	protected function removePHPCode($path, $sign)
	{
		$content = file_get_contents($path);

		preg_match_all('!(\/\*)\s?' . $sign . ' Start.+?' . $sign . ' End\s+?(\*\/)!is', $content, $matches);
		foreach ($matches[0] as $match) {
			$content = str_replace($match, '', $content);
		}

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}

	// Добавление кода
	protected function addHTMLCode($path, $sign, $searchcode, $addCode, $addCodeAfter = true)
	{
		$content = file_get_contents($path);
		$content = str_replace(
			$searchcode,
			($addCodeAfter ? $searchcode : '')
			. '<!-- ' . $sign . ' Start -->'
				.$addCode
			. '<!-- ' . $sign . ' End -->'
			. (!$addCodeAfter ? $searchcode : ''),
			$content
		);

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}

	// Удаление кода
	protected function removeHTMLCode($path, $sign)
	{
		$content = file_get_contents($path);

		preg_match_all('!(\<\!\-\-)\s?' . $sign . ' Start.+?' . $sign . ' End\s+?(\-\-\>)!is', $content, $matches);
		foreach ($matches[0] as $match) {
			$content = str_replace($match, '', $content);
		}

		$fp = fopen($path, 'w+');
		fwrite($fp, $content);
		fclose($fp);
	}

	// Установка модуля
	public function install() {
        $this->load->model('module/IMReport');
		$this->model_module_IMReport->install();

		// Указываем, что модуль установлен
		$this->load->model('setting/setting');

        // Добавляем код в php header
		$this->addPHPCode(
			DIR_APPLICATION . 'controller/common/header.php',
			'IMReport',
			'$this->data[\'report_sale_order\'] = $this->url->link(\'report/sale_order\', \'token=\' . $this->session->data[\'token\'], \'SSL\');',
			' $this->data[\'module_imreport\'] = $this->url->link(\'module/IMReport\', \'token=\' . $this->session->data[\'token\'], \'SSL\'); '
		);

        // Добавляем код в tpl header
        $this->addHTMLCode(
        	//DIR_APPLICATION . 'view/template/common/menu.tpl',
        	DIR_APPLICATION . 'view/template/common/header.tpl',
        	'IMReport',
        	'<li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>',
        	'<li id="module_imreport"><a href="<?php echo $module_imreport; ?>">IMReport (1.5)</a></li>',
        	false
        );

        // Перенаправляем на главную страницу
		//$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
		$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
	}

	// Деинсталляция модуля
    public function uninstall() {
        $this->load->model('module/IMReport');
		$this->model_module_IMReport->uninstall();

		// Указываем, что модуль удален
	 	$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('IMReport', array('IMReport_status'=>0));

		// Удаляем код
		$this->removePHPCode(
			//DIR_APPLICATION . 'controller/common/menu.php',
			DIR_APPLICATION . 'controller/common/header.php',
			'IMReport'
		);

		// Удаляем код
		$this->removeHTMLCode(
        	//DIR_APPLICATION . 'view/template/common/menu.tpl',
        	DIR_APPLICATION . 'view/template/common/header.tpl',
        	'IMReport'
		);

        // Перенаправляем на главную страницу
		//$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
		$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);

    }

}

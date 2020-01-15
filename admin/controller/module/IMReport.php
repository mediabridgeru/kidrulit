<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/
class ControllerModuleIMReport extends Controller {
	private $error = array(); 
	
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
						
			//$this->response->redirect($this->url->link('module/IMReport', 'token=' . $this->session->data['token'], 'SSL'));
			$this->redirect($this->url->link('module/IMReport', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		// Данные
		//$data = array();
		
		////////////////////////////////////
		// Стандартные данные
		////////////////////////////////////
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['h1_text'] = $this->language->get('heading_title_h1');
		$this->data['h2_text'] = $this->language->get('heading_title_h2');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		

		////////////////////////////////////
		// Добавленные данные
		////////////////////////////////////
		$this->data['module_label'] = $this->language->get('module_label'); 
		$this->data['module_table_header'] = $this->language->get('module_table_header'); 

		// Кнопки		
		$this->data['module_button'] = $this->language->get('module_button');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		////////////////////////////////////
		// Строим хлебные крошки
		////////////////////////////////////
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/IMReport', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$this->data['report_links'] = array();

		$this->data['report_links']['top_product'] 
			= $this->url->link('module/IMReport/topProduct', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['client_group'] 
			= $this->url->link('module/IMReport/clientGroup', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['ship_region'] 
			= $this->url->link('module/IMReport/shipRegion', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['man_product'] 
			= $this->url->link('module/IMReport/manProduct', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['order_sales'] 
			= $this->url->link('module/IMReport/orderSales', 'token=' . $this->session->data['token'], 'SSL');

		// 1.1
		$this->data['report_links']['client_orders'] 
			= $this->url->link('module/IMReport/clientOrders', 'token=' . $this->session->data['token'], 'SSL');

		// 1.1
		$this->data['report_links']['option_sales'] 
			= $this->url->link('module/IMReport/optionSales', 'token=' . $this->session->data['token'], 'SSL');

		// 1.2.0
		$this->data['report_links']['product_option_sales'] 
			= $this->url->link('module/IMReport/productOptionSales', 'token=' . $this->session->data['token'], 'SSL');

		// 1.3.0
		$this->data['report_links']['product_option_quantity'] 
			= $this->url->link('module/IMReport/productOptionQuantity', 'token=' . $this->session->data['token'], 'SSL');

		// 1.4.0
		$this->data['report_links']['stock_control'] 
			= $this->url->link('module/IMReport/stockControl', 'token=' . $this->session->data['token'], 'SSL');

		// 1.4.0
		$this->data['report_links']['stock_control_set'] 
			= $this->url->link('module/IMReport/stockControlSet', 'token=' . $this->session->data['token'], 'SSL');

		// 1.4.0
		$this->data['report_links']['stock_control_set_data'] 
			= $this->url->link('module/IMReport/stockControlSetData', 'token=' . $this->session->data['token'], 'SSL');

		// 1.1
		$this->data['report_links']['link_to_client'] 
			//= $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'], 'SSL');
			= $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'], 'SSL');

		// 1.1 
		$this->data['report_links']['link_to_order'] 
			//= $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'], 'SSL');
			= $this->url->link('sale/order/info', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['cancel'] 
			= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['link_to_product'] 
			//= $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'], 'SSL');
			= $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['report_links']['link_to_category'] 
			//= $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'], 'SSL');
			= $this->url->link('catalog/category/update', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMReport_module'])) {
			$this->data['modules'] = $this->request->post['IMReport_module'];
		} elseif ($this->config->get('IMReport_module')) { 
			$this->data['modules'] = $this->config->get('IMReport_module');
		}	
		
		$this->load->model('design/layout');
		
		//$data['layouts'] = $this->model_design_layout->getLayouts();
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//$template = 'module/IMReport.tpl';
		$this->template = 'module/IMReport.tpl';
		
		//$data['header'] = $this->load->controller('common/header');
		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['footer'] = $this->load->controller('common/footer');

		setcookie('token', $this->session->data['token']);
		
		//$this->getForm($data);
		$this->getForm($this->data);

		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		// 1.1 
		$this->data['client_orders_view'] = $this->getChild('module/IMReport/clientOrdersView', $this->data);

		// 1.1 
		$this->data['option_sales_view'] = $this->getChild('module/IMReport/optionSalesView', $this->data);

		// 1.2.0
		$this->data['product_option_sales_view'] = $this->getChild('module/IMReport/productOptionSalesView', $this->data);

		// 1.3.0
		$this->data['product_option_quantity_view'] 
			= $this->getChild('module/IMReport/productOptionQuantityView', $this->data);

		// 1.4.0
		$this->data['stock_control_view'] 
			= $this->getChild('module/IMReport/stockControlView', $this->data);

		// 1.4.0
		$this->data['stock_control_set_view'] 
			= $this->getChild('module/IMReport/stockControlSetView', $this->data);
		
		$this->response->setOutput($this->render());

		//$this->response->setOutput($this->load->view($template, $data));
	}

	// Добавление скриптов и стилей
	private function AddScriptAndStyles()
	{
		$this->document->addStyle('view/javascript/IMReport/bootstrap.css');
		$this->document->addStyle('view/javascript/IMReport/font-awesome/css/font-awesome.min.css');
		$this->document->addStyle('view/javascript/IMReport/summernote/summernote.css');
		$this->document->addScript('view/javascript/IMReport/jquery/jquery-2.1.1.min.js');
		$this->document->addScript('view/javascript/IMReport/bootstrap/js/bootstrap.min.js');
		$this->document->addScript('view/javascript/IMReport/jquery.fix.js');
		$this->document->addScript('view/javascript/jquery/superfish/js/superfish.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/moment.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/locale/ru.js');
		$this->document->addScript('view/javascript/IMReport/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('view/javascript/IMReport/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Поддержка графиков
		$this->document->addScript('view/javascript/IMReport/jquery/flot/jquery.flot.js');
		$this->document->addScript('view/javascript/IMReport/jquery/flot/jquery.flot.resize.min.js');

		
		//$this->document->addStyle();
		//$this->document->addScript();
	}

	// 1.2.0
	////////////////////////////////////////////
	// Товары по опциям
	////////////////////////////////////////////
	// Вьюха 
	public function productOptionSalesView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		$this->template = 'module/IMReport_product_option.tpl';
		$this->response->setOutput($this->render ());
	}

	// 1.3.0
	////////////////////////////////////////////
	// Остатки на складе
	////////////////////////////////////////////
	// Вьюха 
	public function productOptionQuantityView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		$this->template = 'module/IMReport_product_option_quantity.tpl';
		$this->response->setOutput($this->render ());
	}

	// 1.4.0
	////////////////////////////////////////////
	// Контроль остатков
	////////////////////////////////////////////
	// Вьюха 
	public function stockControlView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		$this->template = 'module/IMReport_stock_control.tpl';
		$this->response->setOutput($this->render ());
	}

	// 1.4.0
	////////////////////////////////////////////
	// Контроль остатков (настройки)
	////////////////////////////////////////////
	// Вьюха 
	public function stockControlSetView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		$this->template = 'module/IMReport_stock_control_set.tpl';
		$this->response->setOutput($this->render ());
	}
	
	// 1.1
	////////////////////////////////////////////
	// Клиенты
	////////////////////////////////////////////
	// Вьюха по клиентам
	public function clientOrdersView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		//$template = 'module/IMReport.tpl';
		$this->template = 'module/IMReport_client.tpl';
		$this->response->setOutput($this->render ());
	}

	// 1.1
	////////////////////////////////////////////
	// Опции
	////////////////////////////////////////////
	// Вьюха по опциям
	public function optionSalesView($data = array())
	{
		$this->data = array_merge($this->data, $data);
		
		//$template = 'module/IMReport.tpl';
		$this->template = 'module/IMReport_option.tpl';
		$this->response->setOutput($this->render ());
	}

	// Функция подгрузки списка языков и списка категорий
	private function getForm(&$data) {
		$this->load->model('localisation/language');
		
		// 1.3.0
		$select_all_items = $this->language->get('select_all_items'); 
		
		// 1.3.0
		$data['module_months'] = $this->language->get('module_months');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('module/IMReport');

		// Загружаем категории
		$categories = $this->model_module_IMReport->getCategories(0);
		$firstItem = array();
		$firstItem[] = array(
			'id' => -1,
			'name' => $select_all_items,
			'status' => 1,
			'sort_order' => -1
		); 
		$categories = array_merge($firstItem, $categories);

		$data['list_cat'] = $categories;

		// Загружаем производителей
		$manufacturers = $this->model_module_IMReport->getManufacturer();
		$data['list_manufact'] = $manufacturers;

		// 1.1
		// Загружаем список режимов для отчета по клиентам
		$clientModes = array();
		$clientModes[] = array( 'id' => '0', 'name' => 'Стандартный' );
		$clientModes[] = array( 'id' => '1', 'name' => 'Поиск только зарегистрированных (без покупок)' );
		$clientModes[] = array( 'id' => '2', 'name' => 'Поиск утерянных клиентов' );
		// 1.3.0
		$clientModes = $this->model_module_IMReport->translateOrderedList($clientModes, 'name', 'module_client_report_mode');
		
		$data['list_client_orders_modes'] = $clientModes;

		// Загружаем сортироку
		$data['list_top_sort'] = $this->model_module_IMReport->getSortList('top');
		$data['list_client_sort'] = $this->model_module_IMReport->getSortList('client');
		$data['list_ship_region_sort'] = $this->model_module_IMReport->getSortList('ship_region');
		$data['list_man_product_sort'] = $this->model_module_IMReport->getSortList('man_product');
		// 1.1
		$data['list_client_orders_sort'] = $this->model_module_IMReport->getSortList('client_orders');
		$data['list_option_sales_sort'] = $this->model_module_IMReport->getSortList('option_sales');
		// 1.2.0
		$data['list_product_option_sales_sort'] = $this->model_module_IMReport->getSortList('product_option_sales');

		// 1.3.0
		$data['list_product_option_quantity_sort'] 
			= $this->model_module_IMReport->getSortList('product_option_quantity');

		// 1.4.0
		$data['list_stock_control_sort'] 
			= $this->model_module_IMReport->getSortList('stock_control');

		// 1.4.0
		$data['list_stock_control_set_sort'] 
			= $this->model_module_IMReport->getSortList('stock_control_set');
		
		// 1.4.0
		$default_min_need_quantity = intval($this->language->get('default_min_need_quantity'));
		$data['default_min_need_quantity'] = $default_min_need_quantity;
		
		// 1.3.0
		// Загружаем текущий язык и статусы
		$language_id = $this->getCurrentLanguageId($data, true);
		
		$data['language_id'] = $language_id;
		$data['list_order_status'] = $this->model_module_IMReport->getOrderStatus($language_id);
		
		// 1.4.0
		// Есть ли главная категория
		$data['is_have_main_caterogy'] = $this->model_module_IMReport->isHaveMainCategory();
		$list_cat_main = array();
		$list_cat_main[] = array('id' => 0, 'name' => 'Отключено');
		$list_cat_main[] = array('id' => 1, 'name' => 'Включено');
		$data['list_cat_main'] 
			= $this->model_module_IMReport->translateOrderedList($list_cat_main, 'name', 'module_standard_onoff');
	}

	// 1.2.0
	// Получение данных для Товары по опциям
	public function productOptionSales() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->productOptionSales($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// 1.3.0
	// Получение данных для Остатки на складе
	public function productOptionQuantity() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->productOptionQuantity($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// 1.4.0
	// Получение данных для Контроль остатков
	public function stockControl() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->stockControl($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// 1.4.0
	// Получение данных для Контроль остатков (настройки)
	public function stockControlSet() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->stockControlSet($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// 1.4.0
	// Сохранение данных Контроль остатков (настройки)
	public function stockControlSetData() {
		if($this->validate()) {
			$this->load->model('module/IMReport');
			$json = array();
			$this->model_module_IMReport->stockControlSetData($this->request->post['IMReport']);
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMReport');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	// 1.1
	// Получение данных по клиентам
	public function clientOrders() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->clientOrders($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// 1.1
	// Получение данных по опциям
	public function optionSales() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->optionSales($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// Получение ходового товара
	public function topProduct() {
		$this->load->model('module/IMReport');
		$json = array();
		$json['data'] = $this->model_module_IMReport->topProduct($this->request->post['IMReport']);
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}
	
	// Получение группы клиентов
	public function clientGroup() {
		$this->load->model('module/IMReport');
		
		$json = array();
		$json['data'] = $this->model_module_IMReport->clientGroup($this->request->post['IMReport']);
		
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}
	
	// Доставка по регионам
	public function shipRegion() {
		$this->load->model('module/IMReport');
		
		$json = array();
		$json['data'] = $this->model_module_IMReport->shipRegion($this->request->post['IMReport']);
		
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// Произодители (объем продуктов)
	public function manProduct() {
		$this->load->model('module/IMReport');
		
		$json = array();
		$json['data'] = $this->model_module_IMReport->manProduct($this->request->post['IMReport']);
		
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
	}

	// Оборот заказов
	public function orderSales() {
		$this->load->model('module/IMReport');
		
		$json = array();
		$json['data'] = $this->model_module_IMReport->orderSales($this->request->post['IMReport']);
		
		// CSV or JSON		
		$this->formResponse($json, $this->request->post['IMReport']);
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
			$this->formCSVNameAndHeader();
			$this->response->setOutput($this->getCSVFromData($json['data']));
		}
		else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	protected function formCSVNameAndHeader()
	{
		$price_export = date("Ymd-Hi").'_price_export.csv';
		
		$this->response->addheader('Pragma: public');
		$this->response->addheader('Expires: 0');
		$this->response->addheader('Content-Description: File Transfer');
		$this->response->addheader('Content-Type: application/octet-stream');
		$this->response->addheader('Content-Disposition: attachment; filename='.$price_export);
		$this->response->addheader('Content-Transfer-Encoding: binary');
	}
	
	// Формирование CSV из данных
	protected function getCSVFromData($data)
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
		
		return iconv('UTF-8', 'cp1251', $headerOutput . "\n" . $output);
	}
	
	// 1.3.0
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
	
	// Проверка, что у пользователя есть необходимые права
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/IMReport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}

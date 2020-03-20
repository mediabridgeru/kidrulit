<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOLic100.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Models/IMDBOptimizerModelList.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOSettings.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Cache/IMDBOCacheDB.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Cache/IMDBOCacheFile.php';

class ControllerModuleIMDBOptimizer extends Controller
{
	private $error = array();
	private $warning = array();
	private $module_version = '1.3.0';

	/////////////////////////////////////////
	// Основные экшены
	/////////////////////////////////////////
	
	// Стартовая страница контроллера
	public function index()
	{
		$this->load->language('module/IMDBOptimizer');

		$this->document->setTitle($this->language->get('curr_heading_title'));
		$this->AddScriptAndStyles();
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery.imdbo.js');
		
		$this->load->model('setting/setting');
		$this->load->model('module/IMDBOptimizer');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('IMDBOptimizer', $this->request->post);
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->_formLink('module/IMDBOptimizer'));
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
		$data['text_none'] = $this->language->get('text_none');

		// Кнопки и подписи
		$data['module_label'] = $this->language->get('module_label');
		$data['module_btn_label'] = $this->language->get('module_btn_label');

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
			'href'      => $this->_formLink('module/IMDBOptimizer'),
      		'separator' => ' :: '
   		);
		
		////////////////////////////////////
		// Формируем ссылки
		////////////////////////////////////

		$data['replace'] = $this->_formLink('module/IMDBOptimizer/replace');
		$data['cancel'] = $this->_formLink('extension/module');
		$data['modules'] = array();
		
		$data['module_links'] = array(
			'cancel' 
				=> $this->_formLink('extension/module'),
			'getDBData'
				=> $this->_formLink('module/IMDBOptimizer/getDBData'),
			'generateIndexForTable'
				=> $this->_formLink('module/IMDBOptimizer/generateIndexForTable'),
			'removeIndexForTable'
				=> $this->_formLink('module/IMDBOptimizer/removeIndexForTable'),
			'optimizeTable'
				=> $this->_formLink('module/IMDBOptimizer/optimizeTable'),
			'repairTable'
				=> $this->_formLink('module/IMDBOptimizer/repairTable'),
			'saveIMDBOSettings'
				=> $this->_formLink('module/IMDBOptimizer/saveIMDBOSettings'),
			// 1.2.0
			'saveCacheSettings'
				=> $this->_formLink('module/IMDBOptimizer/saveCacheSettings'),
			'clearCache'
				=> $this->_formLink('module/IMDBOptimizer/clearCache'),
		);
		
		////////////////////////////////////
		// Стандартная подгрузка данных и вывод на шаблон
		////////////////////////////////////
		if (isset($this->request->post['IMDBOptimizer_module'])) {
			$data['modules'] = $this->request->post['IMDBOptimizer_module'];
		} elseif ($this->config->get('IMDBOptimizer_module')) { 
			$data['modules'] = $this->config->get('IMDBOptimizer_module');
		}	
		
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		//$template = 'module/IMDBOptimizer.tpl';
		$this->template = 'module/IMDBOptimizer.tpl';

		//$data['header'] = $this->load->controller('common/header');
		//$data['column_left'] = $this->load->controller('common/column_left');
		//$data['footer'] = $this->load->controller('common/footer');

		setcookie('token', $this->session->data['token']);
		
		$this->getForm($data);

		$this->data = array_merge($this->data, $data);

		$this->children = array (
			'common/header',
			'common/footer'
		);

		$data['imdbo_dbopt_view'] = $this->getChild(
			'module/IMDBOptimizer/getDBOView', 
			array( 'data' => $this->data, 'view' => 'IMDBOptimizer_dbopt.tpl' )
		);

		$data['imdbo_service_view'] = $this->getChild(
			'module/IMDBOptimizer/getDBOView', 
			array( 'data' => $this->data, 'view' => 'IMDBOptimizer_service.tpl' )
		);

		// 1.2.0
		$data['imdbo_cache_view'] = $this->getChild(
			'module/IMDBOptimizer/getDBOView', 
			array( 'data' => $this->data, 'view' => 'IMDBOptimizer_cache.tpl' )
		);
		$data['imdbo_settings_view'] = $this->getChild(
			'module/IMDBOptimizer/getDBOView', 
			array( 'data' => $this->data, 'view' => 'IMDBOptimizer_settings.tpl' )
		);

		$this->data = array_merge($this->data, $data);

		$this->response->setOutput($this->render ());
		//$this->response->setOutput($this->load->view($template, $data));
	}

	////////////////////////////////////////////
	// Стандартная функция вьюхи
	////////////////////////////////////////////
	public function getDBOView($data = array())
	{
		$viewName = $data['view'];
		$viewData = $data['data'];
		
		$this->data = array_merge($this->data, $viewData);
		$this->template = 'module/' . $viewName;
		$this->response->setOutput($this->render ());
		//return $this->load->view('module/' . $viewName, $viewData);
	}

	////////////////////////////////////////////
	// Добавление скриптов и стилей
	////////////////////////////////////////////
	private function AddScriptAndStyles()
	{
		$this->document->addStyle('view/javascript/IMDBOptimizer/bootstrap.css');
		$this->document->addStyle('view/javascript/IMDBOptimizer/font-awesome/css/font-awesome.min.css');
		//$this->document->addStyle('view/javascript/IMDBOptimizer/summernote/summernote.css');
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery/jquery-2.1.1.min.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/bootstrap/js/bootstrap.min.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery.fix.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/common.js');
		$this->document->addScript('view/javascript/jquery/superfish/js/superfish.js');
		//$this->document->addScript('view/javascript/IMDBOptimizer/summernote/summernote.js');
		//$this->document->addScript('view/javascript/IMDBOptimizer/summernote/lang/summernote-ru-RU.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery/datetimepicker/moment.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery/datetimepicker/locale/ru.js');
		$this->document->addScript('view/javascript/IMDBOptimizer/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('view/javascript/IMDBOptimizer/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
		
		//$this->document->addStyle();
		//$this->document->addScript();
	}

	////////////////////////////////////////////
	// Функция подгрузки данных
	////////////////////////////////////////////
	private function getForm(&$data) {
		// Формируем список языков
		$this->load->model('localisation/language');
		
		$model_list = new IMDBOptimizerModelList($this->db, $this->language, $this->config);
		
		//////////////////////////////
		// Список таблиц
		//////////////////////////////
		$list_tables = $model_list->getDBTables();
		$data['list_tables'] = $list_tables;

		//////////////////////////////
		// Список вкл, выкл
		//////////////////////////////
		$data['list_on_off'] = array(
			array( 'id' => 0, 'name' => $this->language->get('label_list_off') ),
			array( 'id' => 1, 'name' => $this->language->get('label_list_on') ),
		);

		//////////////////////////////
		// Настройки кэша
		//////////////////////////////
		$settingsProvider = new IMDBOSettings($this->db);
		$data['data_cache'] = $settingsProvider->getSettings('cache');

		//////////////////////////////
		// Стандартная часть
		//////////////////////////////
		
		$data['token'] = $this->session->data['token'];

		$this->validate();

		$data['error_messages'] = $this->error;
		$data['warning_messages'] = $this->warning;
		
		$data['lic_info'] = $this->imllic->getInfo();
	}

	///////////////////////
	// Сохранить настройки генератора
	///////////////////////
	public function saveIMDBOSettings(){
		$this->load->model('setting/setting');
		$this->load->language('module/IMDBOptimizer');
		$json = array();
		
		$postData = $this->request->post['IMDBOptimizer'];
		
		$currSettingData = $this->model_setting_setting->getSetting('IMDBOptimizerData');
		
		$currSettingData = array_merge($currSettingData, $postData);

		$this->model_setting_setting->editSetting('IMDBOptimizerData', $currSettingData);

		$json['success'] = 1;
		
		$this->response->setOutput(json_encode($json));
	}


	///////////////////////
	// Создать индексы для таблицы
	///////////////////////
	public function generateIndexForTable(){
		if($this->validate()) {
			$this->load->language('module/IMDBOptimizer');
			$this->load->model('module/IMDBOptimizer');
			$json = array();
			
			$json = $this->model_module_IMDBOptimizer->generateIndexForTable(
				$this->request->post['IMDBOptimizer']
			);
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	///////////////////////
	// Удалить индексы для таблицы
	///////////////////////
	public function removeIndexForTable(){
		if($this->validate()) {
			$this->load->language('module/IMDBOptimizer');
			$this->load->model('module/IMDBOptimizer');
			$json = array();
			
			$json = $this->model_module_IMDBOptimizer->removeIndexForTable(
				$this->request->post['IMDBOptimizer']
			);
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	///////////////////////
	// Оптимизация таблицы
	///////////////////////
	public function optimizeTable(){
		if($this->validate()) {
			$this->load->language('module/IMDBOptimizer');
			$this->load->model('module/IMDBOptimizer');
			$json = array();
			
			$json = $this->model_module_IMDBOptimizer->optimizeTable(
				$this->request->post['IMDBOptimizer']
			);
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	///////////////////////
	// Починка таблицы
	///////////////////////
	public function repairTable(){
		if($this->validate()) {
			$this->load->language('module/IMDBOptimizer');
			$this->load->model('module/IMDBOptimizer');
			$json = array();
			
			$json = $this->model_module_IMDBOptimizer->repairTable(
				$this->request->post['IMDBOptimizer']
			);
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	///////////////////////
	// Сохранить настройки кэша
	///////////////////////
	public function saveCacheSettings()
	{
		if($this->validate()) {
			$json = array();
			
			if (isset($this->request->post['IMDBOptimizer'])) {
				$post = $this->request->post['IMDBOptimizer'];
				if (isset($post['cache'])) {
					$settingsProvider = new IMDBOSettings($this->db);
					$settingsProvider->updateSettings(
						'cache',
						$post['cache']
					);
				}
			}
			
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

	///////////////////////
	// Удалить кэш
	///////////////////////
	public function clearCache()
	{
		if($this->validate()) {
			$json = array();
			
			$cacheDB = new IMDBOCacheDB($this->db);
			$cacheDB->clearAll();
			
			$cacheFile = new IMDBOCacheFile();
			$cacheFile->clearAll();
			
			$json['success'] = 1;
			
			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}
	///////////////////////
	// Получить текущие данные о таблицах в БД
	///////////////////////
	public function getDBData() {
		if($this->validate()) {
			$this->load->language('module/IMDBOptimizer');
			$this->load->model('module/IMDBOptimizer');
			$json = array();

			$json['report'] = $this->model_module_IMDBOptimizer->getDBData(
				$this->request->post['IMDBOptimizer']
			);
			$json['success'] = 1;

			$this->response->setOutput(json_encode($json));
		}
		else {
			$this->load->language('module/IMDBOptimizer');
			$json = array();
			$json['success'] = 0;
			$json['error_message'] = $this->language->get('error_permission');
			
			$this->response->setOutput(json_encode($json));
		}
	}

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
	
	/////////////////////////////////////////
	// Установка / Деинсталляция
	/////////////////////////////////////////

	// Установка модуля
	public function install() {
        $this->load->model('module/IMDBOptimizer');
		$this->model_module_IMDBOptimizer->install();
		
		$settingsProvider = new IMDBOSettings($this->db);
		$settingsProvider->install();
		
		$cacheDBProvider = new IMDBOCacheDB($this->db);
		$cacheDBProvider->install();

		// Указываем, что модуль установлен
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('IMDBOptimizer', array('IMDBOptimizer_status'=>1));

		$codeRegistry = <<<'HTML'

		if ($key == 'db') {
			if (class_exists('DB')) {
				require_once DIR_SYSTEM . 'IMDBOptimizer/Cache/IMDBOCacheProcessor.php';
				$processor = new IMDBOCacheProcessor($value);
				$this->data[$key] = $processor;
			}
		}
HTML;

		// Добавляем код в registry.php
		$this->addPHPCode(
			DIR_SYSTEM . 'engine/registry.php',
			'IMDBOptimizer',
			'$this->data[$key] = $value;',
			$codeRegistry,
			true
		);
        
        // Перенаправляем на главную страницу
		$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
	}
	
	// Деинсталляция модуля
    public function uninstall() {
        $this->load->model('module/IMDBOptimizer');
		$this->model_module_IMDBOptimizer->uninstall();
		
		$settingsProvider = new IMDBOSettings($this->db);
		$settingsProvider->uninstall();
		
		$cacheDBProvider = new IMDBOCacheDB($this->db);
		$cacheDBProvider->uninstall();
		
		// Указываем, что модуль удален
	 	$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('IMDBOptimizer', array('IMDBOptimizer_status'=>0));
        
        // Удаляем код из registry.php
        $this->removePHPCode(
			DIR_SYSTEM . 'engine/registry.php',
			'IMDBOptimizer'
        );
        
        // Перенаправляем на главную страницу
		$this->response->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
    
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
	
	protected $imllic;
	
	// Проверка, что у пользователя есть необходимые права
	private function validate($only_edit = false) {
		$this->load->model('setting/setting');
		
		$data = $this->model_setting_setting->getSetting('IMDBOptimizerData');

		if (!isset($imllic) || empty($imllic)) {
			$this->imllic = new IMDBOLic100(
				$this,
				'IMDBOptimizer(1.5)',
				(isset($data['IMDBOptimizerData_key']) ? $data['IMDBOptimizerData_key'] : ''),
				(isset($data['IMDBOptimizerData_enc_mess']) ? $data['IMDBOptimizerData_enc_mess'] : '')
			);
		}
		
		if (!$only_edit && !$this->imllic->isValid()) {
			$this->error['lic'] = $this->language->get('lic_permission');
		}
		
		if (!$this->user->hasPermission('modify', 'module/IMDBOptimizer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}

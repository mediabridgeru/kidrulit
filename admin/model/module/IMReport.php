<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/
require_once DIR_SYSTEM . 'IMReport/IMReportHelper.php';
require_once DIR_SYSTEM . 'IMReport/IMReportProcessor.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelTopProduct.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelClientGroup.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelOrderSales.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelClientOrders.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelOptionSales.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelProductOptionSales.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelProductOptionQuantity.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelShipRegion.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelManProduct.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelOrderPaymShip.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelStockControl.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelProductNoSales.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelOrderSalesByDay.php';
require_once DIR_SYSTEM . 'IMReport/Models/IMReportModelOrderShip.php';

class ModelModuleIMReport extends Model
{

	protected $imhelper;

	function __construct($registry)
	{
		parent::__construct($registry);

		$this->load->language('module/IMReport');
		
		$this->imhelper = new IMReportHelper($this->db);
	}

	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////
  
	public function install() 
	{
		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imreport_data_stock_control` (
			  `product_id` int(11) NOT NULL,
			  `product_option_value_id` int(11) NOT NULL,
			  `need` int(11) NOT NULL,
			  PRIMARY KEY (`product_id`, `product_option_value_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);
	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall() 
	{
		// Пока ничего не нужно удалять
	}

	/////////////////////////////////////////
	// Получение данных
	/////////////////////////////////////////

	// Ходовой товар
	public function topProduct($settings) 
	{
		$model = new IMReportModelTopProduct($this->db, $this->language, $this->config);
		// 2.1.0
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResult($settings);
		// 2.1.0
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// Группы клиентов
	public function clientGroup($settings) 
	{
		$model = new IMReportModelClientGroup($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 1.5
	// Клиенты
	public function clientOrders($settings) 
	{
		$model = new IMReportModelClientOrders($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 1.5
	// Опции за период
	public function optionSales($settings) 
	{
		$model = new IMReportModelOptionSales($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 1.6.0
	// Товары по опциям
	public function productOptionSales($settings) 
	{
		$model = new IMReportModelProductOptionSales($this->db, $this->language, $this->config);
		// 2.1.0
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResult($settings);
		// 2.1.0
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// 1.7.0
	// Остатки на складе
	public function productOptionQuantity($settings) 
	{
		$model = new IMReportModelProductOptionQuantity($this->db, $this->language, $this->config);
		// 2.1.0
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResult($settings);
		// 2.1.0
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// Доставка по регионам 
	public function shipRegion($settings) 
	{
		$model = new IMReportModelShipRegion($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// Произодители (объем продуктов)
	public function manProduct($settings) 
	{
		$model = new IMReportModelManProduct($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// Оборот заказов
	public function orderSales($settings) 
	{
		$model = new IMReportModelOrderSales($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 2.0.0
	// Заказы в разрезе оплат и доставки
	public function orderPaymShip($settings) 
	{
		$model = new IMReportModelOrderPaymShip($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 2.5.0
	// Заказы в разрезе оплат и доставки
	public function orderShip($settings)
	{
		$model = new IMReportModelOrderShip($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	// 1.8.0
	// Контроль остатков
	public function stockControl($settings) 
	{
		$model = new IMReportModelStockControl($this->db, $this->language, $this->config);
		// 2.1.0
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResult($settings);
		// 2.1.0
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// 1.8.0
	// Контроль остатков (настройки)
	public function stockControlSet($settings) 
	{
		$model = new IMReportModelStockControl($this->db, $this->language, $this->config);
		// 2.1.0
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResultSet($settings);
		// 2.1.0
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// 1.8.0
	// Установка данных для Контроль остатков (настройки)
	public function stockControlSetData($settings)
	{
		$model = new IMReportModelStockControl($this->db, $this->language, $this->config);
		$model->setData($settings);
	}

	// 2.2.0
	// Товары без продаж
	public function productNoSales($settings) 
	{
		$model = new IMReportModelProductNoSales($this->db, $this->language, $this->config);
		$module_settings = $this->getModuleSettings();
		$settings['module_settings'] = $module_settings;
		$results = $model->getResult($settings);
		$this->_formProductImage($results, $module_settings);
		return $results;
	}

	// 2.4.0
	// Товары без продаж
	public function orderSalesByDay($settings)
	{
		$model = new IMReportModelOrderSalesByDay($this->db, $this->language, $this->config);
		return $model->getResult($settings);
	}

	/////////////////////////////////////////
	// Дополнительные функции
	/////////////////////////////////////////

	// 2.1.0
	// Формируем ссылки для картинок
	protected function _formProductImage(&$results, $module_settings)
	{
		$this->load->model('tool/image');
		
		$is_product_image_display = (int)$module_settings['IMReportData_p_img_use'];
		
		if ($is_product_image_display == 0) 
			return;
		
		$width = (int)$module_settings['IMReportData_p_img_w'];
		$width = $width <= 0 ? 40 : $width;
		$height = (int)$module_settings['IMReportData_p_img_h'];
		$height = $height <= 0 ? 40 : $height;
		
		// 2.4.0
		$last_product_id = -1;
		$last_img = '';
		$standart_img = $this->model_tool_image->resize('no_image.jpg', $width, $height);

		for($cnt = 0; $cnt < count($results); $cnt++) {
			// 2.4.0
			if ((int)$last_product_id == (int)$results[$cnt]['product_id']) {
				$results[$cnt]['product_image_mini'] = $last_img;
			} else {
				if (is_file(DIR_IMAGE . $results[$cnt]['product_image'])) {
					$image = $this->model_tool_image->resize($results[$cnt]['product_image'], $width, $height);
				} else {
					$image = $standart_img;
				}

				$results[$cnt]['product_image_mini'] = $image;
				$last_product_id = (int)$results[$cnt]['product_id'];
				$last_img = $image;
			}
		}
	}

	// 2.1.0
	// Получение настроек модуля
	public function getModuleSettings()
	{
		$this->load->model('setting/setting');
		$list_module_settings = array(
			'IMReportData_p_img_use' => 0,
			'IMReportData_p_img_w' => 40,
			'IMReportData_p_img_h' => 40,
			'IMReportData_csv_iconv' => 0,
		);
		$list_module_settings_curr = $this->model_setting_setting->getSetting('IMReportData');
		$list_module_settings = array_merge($list_module_settings, $list_module_settings_curr);
		return $list_module_settings;
	}

	/////////////////////////////////////////
	// Хелперы для составления запросов
	/////////////////////////////////////////
	
	protected function inQuoteEsc($value) 
	{
		return $this->inQuote($this->db->escape($value));
	}

	protected function inQuote($value) 
	{
		return '\'' . $value . '\'';
	}

	/////////////////////////////////////////
	// Получение списков для фильтра
	/////////////////////////////////////////

	// 1.7.0
	// Перевод упорядоченных списков
	// OC 2.2 ... Ругается на ссылку, так как вызывает через call_user_func
	//public function translateOrderedList(&$resultList, $field_name, $list_name)
	public function translateOrderedList($resultList, $field_name, $list_name)
	{
		$this->load->language('module/IMReport');
		$transList = $this->language->get($list_name);
		
		if (isset($transList) && is_array($transList))
		{
			for ($cnt = 0; $cnt < count($transList); $cnt++)			
			{
				if ($cnt < count($resultList))
				{
					$resultList[$cnt][$field_name] = $transList[$cnt];
				}
			}
		}
		
		return $resultList;
	}

	
	// 1.8.0
	// Проверка, что есть главная категория
	public function isHaveMainCategory()
	{
		return $this->isTableHaveColumn('product_to_category', 'main_category');
	}

	// 1.8.0
	// Есть ли в таблице столбец
	public function isTableHaveColumn($table, $column)
	{
		$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->db->escape($table) . "` "
			. " LIKE '" . $this->db->escape($column) . "'");
			
		if ($result->num_rows) {
			return true;
		} 
		return false;
	}

}

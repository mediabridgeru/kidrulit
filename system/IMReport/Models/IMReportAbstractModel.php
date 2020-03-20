<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMReport/IMReportHelper.php';
require_once DIR_SYSTEM . 'IMReport/IMReportConfig.php';

abstract class IMReportAbstractModel
{
	protected $db;
	
	protected $language;
	
	protected $config;
	
	protected $imhelper;
	
	protected $module_config;

	protected $file_log;

	protected $file_log_text;

	protected $start_time;

	// Конструктор
	function __construct(&$db = null, &$language = null, &$config = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}

		$this->imhelper = new IMReportHelper($this->db);
		
		if (isset($language)) {
			$this->language = &$language;
		}

		if (isset($config)) {
			$this->config = &$config;
		}

		$this->module_config = new IMReportConfig();
	}
	
	// Получение значения из локализации
	public function getLangVal($name = '', $default = '')
	{
		if (isset($name) && trim($name) != '' && isset($this->language)) {
			return $this->language->get($name);
		}
		return $default;
	}
	
	// Проверка, что есть главная категория
	public function isHaveMainCategory()
	{
		return $this->isTableHaveColumn('product_to_category', 'main_category');
	}

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

	// Общая функция для построения фильтра
	public function getWhereFilterByMetaData($settings, $metadata, $wherePart = '')
	{
		$resultFilter = $wherePart;
		
		if (isset($settings) && isset($metadata) && is_array($metadata)) {
			// Общий фильтр построения дат
			if (isset($metadata['date']) && is_array($metadata['date'])) {
				foreach($metadata['date'] as $key => $item) {
					$resultFilter .= $this->imhelper->getWhereFilterDate(
						$settings, $key, $item, $resultFilter
					);
				}
			}

			// Общий фильтр построения списков int
			if (isset($metadata['list_int']) && is_array($metadata['list_int'])) {
				foreach($metadata['list_int'] as $key => $item) {
					$resultFilter .= $this->imhelper->getWhereFilterList(
						$settings, $key, $item, $resultFilter
					);
				}
			}

			// Общий фильтр построения списков string
			if (isset($metadata['list_string']) && is_array($metadata['list_string'])) {
				foreach($metadata['list_string'] as $key => $item) {
					$resultFilter .= $this->imhelper->getWhereFilterListString(
						$settings, $key, $item, $resultFilter
					);
				}
			}

			// Общий фильтр построения фильтра cat_product
			if (isset($metadata['cat_product']) && is_array($metadata['cat_product'])) {
				foreach($metadata['cat_product'] as $key => $item) {
					$resultFilter .= $this->imhelper->getCategoryProductWhereFilter(
						$settings, $key, $item, $this->isHaveMainCategory(), $resultFilter
					);
				}
			}
		}
		
		return $resultFilter;
	}

	// 2.4.0
	////////////////////////////
	// Лог
	////////////////////////////
	public function startSQLLog($sql, $message = '')
	{
		$enable_sql_log = $this->module_config->get('dev', 'enable_sql_log', 0);
		$enable_sql_log_show_query_at_start
			= $this->module_config->get('dev', 'enable_sql_log_show_query_at_start', 0);
		if ($enable_sql_log) {
			$this->file_log = DIR_SYSTEM . 'IMReport/Log/' . date('Y-m-d') . '.log';
			$this->file_log_text = "\n-------------------------------\n";
			$this->file_log_text .= get_class($this) . "\n\n";
			$this->file_log_text .= date("Y-m-d H:i:s") . "\n\n";
			if (!empty($message)) {
				$this->file_log_text .= $message . "\n\n";
			}
			$this->file_log_text .= $sql . "\n\n";
			$this->start_time = microtime(true);

			if ($enable_sql_log_show_query_at_start) {
				$temp = $this->file_log_text;
				$temp .= "Show query \n\n";
				$temp .=  "\n-------------------------------\n";
				file_put_contents($this->file_log, $temp, FILE_APPEND | LOCK_EX);
			}
		}
	}

	public function endSQLLog($message = '')
	{
		$enable_sql_log = $this->module_config->get('dev', 'enable_sql_log', 0);
		if ($enable_sql_log) {
			$time = round(microtime(true) - $this->start_time, 4);
			$this->file_log_text .= "Exec time (s):" . $time . "\n\n";
			if (!empty($message)) {
				$this->file_log_text .= $message . "\n\n";
			}
			$this->file_log_text .= "\n-------------------------------\n";
			file_put_contents($this->file_log, $this->file_log_text, FILE_APPEND | LOCK_EX);
		}
	}

	// 2.4.0
	// Добавление sql кода если включен мультивалютный расчет
	public function addMCC($query = '', $default = '')
	{
		// MCC не готов, нужно в следующих версиях основательно подойти
		// к пересчету для валют кроме базовой
		return $default;

		$enable_multicurrency_calculation
			= (int)$this->module_config->get('engine', 'enable_multicurrency_calculation', 0);

		if ($enable_multicurrency_calculation) {
			return $query;
		}

		return $default;
	}
}

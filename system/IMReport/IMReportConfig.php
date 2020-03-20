<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMReportConfig
{
	protected $data = null;

	function __construct()
	{
		$this->data = parse_ini_file(DIR_SYSTEM . "IMReport/IMReportConfig.ini", true);
	}

	public function get($section, $name, $default = null)
	{
		if (isset($this->data[$section])) {
			if (isset($this->data[$section][$name])) {
				return $this->data[$section][$name];
			}
		}
		return $default;
	}

	public function getAllCfg()
	{
		return array(
			'dev' => array(
				'disable_autoload' => (int)$this->get('dev', 'disable_autoload', 0),
				'enable_sql_log' => (int)$this->get('dev', 'enable_sql_log', 0),
				'enable_sql_log_show_query_at_start'
					=> (int)$this->get('dev', 'enable_sql_log_show_query_at_start', 0),
			),
			'user' => array(
				'limit_cust' => (int)$this->get('user', 'limit_cust', 10),
				'limit_cust_group' => (int)$this->get('user', 'limit_cust_group', 10),
				'ajax_filter_delay' => (int)$this->get('user', 'ajax_filter_delay', 500),
				'table_default_num_rows_displayed'
					=> (int)$this->get('user', 'table_default_num_rows_displayed', 10),
				'report_order_sales_months'
				 	=> (int)$this->get('user', 'report_order_sales_months', 12),
				'report_order_sales_by_day_num'
				 	=> (int)$this->get('user', 'report_order_sales_by_day_num', 31),
			),
			'engine' => array(
				'enable_multicurrency_calculation'
					=> (int)$this->get('engine', 'enable_multicurrency_calculation', 0),
			),
		);
	}
}

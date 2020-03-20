<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelOrderPaymShip extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$wherePart = '';
		
		// Это версия 1513
		$is_1513_or_lower = (version_compare(VERSION, '1.5.1.3') <= 0);

		// В 1.5.1.3 нет кодов
		if($is_1513_or_lower) {
			$wherePart = $this->getWhereFilterByMetaData(
				$settings,
				array(
					'date' => array(
						'filter_date_start' => " DATE(o.date_added) >= ",
						'filter_date_end' => " DATE(o.date_added) <= ",
					),
					'cat_product' => array(
						'cat' => 'p.product_id',
					),
					'list_int' => array(
						'order_status' => ' o.order_status_id ',
					),
					'list_string' => array(
						'order_ship_name' => ' o.shipping_method ',
						'order_paym_name' => ' o.payment_method ',
						'cust' => 'o.customer_id',
						'cust_group' => 'o.customer_group_id',
					),
				)
			);		
		} else {
			$wherePart = $this->getWhereFilterByMetaData(
				$settings,
				array(
					'date' => array(
						'filter_date_start' => " DATE(o.date_added) >= ",
						'filter_date_end' => " DATE(o.date_added) <= ",
					),
					'cat_product' => array(
						'cat' => 'p.product_id',
					),
					'list_int' => array(
						'order_status' => ' o.order_status_id ',
					),
					'list_string' => array(
						'order_ship_name' => ' o.shipping_method ',
						'order_ship_code' => ' o.shipping_code ',
						'order_paym_name' => ' o.payment_method ',
						'order_paym_code' => ' o.payment_code ',
						'cust' => 'o.customer_id',
						'cust_group' => 'o.customer_group_id',
					),
				)
			);		
		}

		// Сам запрос
		$query = 
			' select '
				. ' o.date_added, '
				. ' o.order_id, '
				. ' os.order_status_id, '
				. ' os.name as order_status_name, '
				. ' o.customer_id, '
				. ' concat(ifnull(o.firstname, ""), \' \', ifnull(o.lastname, "")) as client_name, '
				. ' o.shipping_method as ship_name, '
				. (
					$is_1513_or_lower
					? ' "" as ship_code, '
					: ' o.shipping_code as ship_code, '
				)
				. ' o.payment_method as paym_name, '
				. (
					$is_1513_or_lower
					? ' "" as paym_code, '
					: ' o.payment_code as paym_code, '
				)
				. ' o.total ' . $this->addMCC(' * o.currency_value ') . ' as cost '
			. ' from `' . DB_PREFIX . 'order` o '
				. ' join `' . DB_PREFIX . 'order_status` os '
					. ' on o.order_status_id = os.order_status_id '
						. ' and os.language_id = ' . (int)$settings['language_id']
			. ($wherePart == '' ? '' : ' where ' . $wherePart)
			. ' order by o.date_added desc, o.order_id desc '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

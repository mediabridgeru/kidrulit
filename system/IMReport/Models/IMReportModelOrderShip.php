<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelOrderShip extends IMReportAbstractModel
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

		$groupType = 'week';
		$queryGroup = '';

		if (isset($settings['group_by_time']) && !empty($settings['group_by_time'])) {
			if (is_array($settings['group_by_time'])) {
				if (count($settings['group_by_time']) > 0) {
					$groupType = $settings['group_by_time'][0];
				}
			}
		}

		// В 1.5.1.3 нет кодов
		if($is_1513_or_lower) {
			switch($groupType) {
				case 'day';
					$queryGroup .= ' GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), o.shipping_method, ot.title ';
					break;
				default:
				case 'week':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), WEEK(o.date_added), o.shipping_method, ot.title ';
					break;
				case 'month':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), MONTH(o.date_added), o.shipping_method, ot.title ';
					break;
				case 'year':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), o.shipping_method, ot.title ';
					break;
			}
		} else {
			switch($groupType) {
				case 'day';
					$queryGroup .= ' GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), o.shipping_code, o.shipping_method, ot.title ';
					break;
				default:
				case 'week':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), WEEK(o.date_added), o.shipping_code, o.shipping_method, ot.title ';
					break;
				case 'month':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), MONTH(o.date_added), o.shipping_code, o.shipping_method, ot.title ';
					break;
				case 'year':
					$queryGroup .= ' GROUP BY YEAR(o.date_added), o.shipping_code, o.shipping_method, ot.title ';
					break;
			}
		}

		// Сам запрос
		$query =
			' select '
				. ' min(o.date_added) as `date_start`, '
				. ' max(o.date_added) as `date_end`, '
				. ' o.shipping_method as `method`, '
				. (
					$is_1513_or_lower
					? ' "" as `code`, '
					: ' o.shipping_code as `code`, '
				)
				. ' ot.title as `name`, '
				. ' sum( ot.value ' . $this->addMCC(' * o.currency_value ') . ' ) as cost, '
				. ' count(*) as `count` '
			. ' from `' . DB_PREFIX . 'order` o '
				. ' join `' . DB_PREFIX . 'order_status` os '
					. ' on o.order_status_id = os.order_status_id '
						. ' and os.language_id = ' . (int)$settings['language_id']
				. ' join `' . DB_PREFIX . 'order_total` ot '
					. ' on o.order_id = ot.order_id '
						. " and ot.code = 'shipping' "
			. ($wherePart == '' ? '' : ' where ' . $wherePart)
			. $queryGroup
		;

		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

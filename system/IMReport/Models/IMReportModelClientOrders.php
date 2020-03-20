<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelClientOrders extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$wherePart = '';

		// 1.8.0
		$wherePartClient = '';

		// 1.9.0
		$wherePartLast = '';
		$wherePartAll = '';
		
		// 1.9.0
		// Фильтр для поиска последнего отчета
		$wherePartLast .= $this->imhelper->getWhereFilterList($settings, 'order_status_last', ' ol.order_status_id ', $wherePartLast);

		// 1.9.0
		// Фильтр для вычисления общего количества
		$wherePartAll .= $this->imhelper->getWhereFilterList($settings, 'order_status_all', ' o_max.order_status_id ', $wherePartAll);
		
		// Режим отчета
		// 0 - стандарт, 1 - без покупок, 2 - совершивших покупку, но не купивших за период
		$report_mode = (int)(empty($settings['client_orders_modes']) ? '0' : $settings['client_orders_modes']);
		
		// 1.7.0
		// Стартовая дата
		$wherePart .= $this->imhelper->getWhereFilterDate($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);
		// 1.8.0
		$wherePartClient 
			.= $this->imhelper->getWhereFilterDate($settings, 'filter_date_reg_start', 
				" DATE(cust.date_added) >= ", 
				$wherePartClient);

		// 1.7.0
		// Конечная дата
		$wherePart .= $this->imhelper->getWhereFilterDate($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
		// 1.8.0
		$wherePartClient 
			.= $this->imhelper->getWhereFilterDate($settings, 'filter_date_reg_end', 
				" DATE(cust.date_added) <= ", 
				$wherePartClient);
	
		// Фильтр по статусу
		$wherePart .= $this->imhelper->getWhereFilterList($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Формируем подзапрос относительно того, 
		// какой режим включен
		$subQuery = '';

		// 1.7.0
		// Стандартный
		if ($report_mode == 0)
		{
			$subQuery = 
				'select cust.customer_id as customer_id, '
				. ' sum(o.total ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
				. ' count(*) as count, '
				// 1.9.0
				. ' (select max(ol.order_id) ' 
						. ' from `' . DB_PREFIX . 'order` ol ' 
							// 1.9.1
							. ' join `' . DB_PREFIX . 'order_status` os '
								. ' on ol.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . (int)$settings['language_id']
						. ' where ol.customer_id = cust.customer_id '
							. ($wherePartLast == '' ? '' : ' and ' . $wherePartLast)
					. ' ) ' 
					. '  as last_order '
				//. ' max(oi.order_id) as last_order '
				. ' from '
					. ' `' . DB_PREFIX . 'customer` cust '
					. ' join ( select distinct o.order_id, o.customer_id '
						.' from `' . DB_PREFIX . 'order` o '
							. ' join `' . DB_PREFIX . 'order_status` os '
								. ' on o.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . (int)$settings['language_id']
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ' ) oi '
						. ' on oi.customer_id = cust.customer_id '
					. ' join `' . DB_PREFIX . 'order` o '
						. ' on o.order_id = oi.order_id '
				. ' group by cust.customer_id '
			;
		
		}
		// Без покупок
		else if ($report_mode == 1)
		{
			$subQuery = 
				'select cust.customer_id as customer_id, '
				. ' 0 as cost, ' 
				. ' 0 as count, '
				. ' 0 as last_order '
				. ' from '
					. ' `' . DB_PREFIX . 'customer` cust '
					. ' left join `' . DB_PREFIX . 'order` o '
						. ' on o.customer_id = cust.customer_id '
					// 1.9.1
					. ' left join `' . DB_PREFIX . 'order_status` os '
						. ' on o.order_status_id = os.order_status_id '
							. ' and os.language_id = ' . (int)$settings['language_id']
				// 1.9.1
				. ' where o.order_id is null and os.order_status_id is null'
					// 1.7.0
					// 1.8.0
					//. (
					//	$wherePartClientWithoutOrder == '' 
					//	? ''
					//	: ' and ' . $wherePartClientWithoutOrder
					//)
			;
		
		}
		// С покупками, но без покупок за указанный период
		else if ($report_mode == 2)
		{
			$subQuery = 
				'select cust.customer_id as customer_id, '
				. ' 0 as cost, ' 
				. ' 0 as count, '
				// 1.9.0
				. ' (select max(ol.order_id) ' 
						. ' from `' . DB_PREFIX . 'order` ol ' 
							// 1.5.1
							. ' join `' . DB_PREFIX . 'order_status` os '
								. ' on ol.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . (int)$settings['language_id']
						. ' where ol.customer_id = cust.customer_id ' 
							. ($wherePartLast == '' ? '' : ' and ' . $wherePartLast)
					. ') ' 
					. ' as last_order '
				. ' from '
					. '' . DB_PREFIX . 'customer cust '
					. ' left join ( select distinct o.order_id, o.customer_id '
						.' from `' . DB_PREFIX . 'order` o '
							. ' join `' . DB_PREFIX . 'order_status` os '
								. ' on o.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . (int)$settings['language_id']
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ' ) oi '
						. ' on oi.customer_id = cust.customer_id '
				. ' where oi.order_id is null '
					. ' and exists (select distinct oe.customer_id '
										. ' from `' . DB_PREFIX . 'order` oe ' 
										. ' where oe.customer_id = cust.customer_id) '
			;
		}

		// 1.8.0
		// Сам запрос
		$query = 
			' select data.customer_id, '
				. ' ifnull(data.count_all, 0) as count_all, '
				. ' ifnull(data.cost_all, 0) as cost_all, '
				. ' data.cost, '
				. ' data.count, '
				. ' cust.address_id, '
				. ' cust.status, '
				. ' concat(cust.firstname, \' \', cust.lastname) as name, '
				. ' cust.date_added as date_added, '
				. ' cust.email as email, '
				. ' cust.telephone as telephone, '
				. ' ifnull(addr.city, "") as city, '
				. ' data.last_order, '
				. ' ifnull(o_last.date_added, "") as last_order_date '
			. ' from '
					. ' ( ' 
						. ' select ' 
							. ' subdata.*, '
							. ' (select count(*) ' 
								. ' from `' . DB_PREFIX . 'order` o_max '
									// 1.9.1
									. ' join `' . DB_PREFIX . 'order_status` os '
										. ' on o_max.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . (int)$settings['language_id']
								. ' where o_max.customer_id = subdata.customer_id '
									// 1.9.0
									. ($wherePartAll == '' ? '' : ' and ' . $wherePartAll)
							. ' ) as count_all, '
							. ' (select sum(o_max.total' . $this->addMCC(' * o_max.currency_value ') . ') '
								. ' from `' . DB_PREFIX . 'order` o_max '
									// 1.9.1
									. ' join `' . DB_PREFIX . 'order_status` os '
										. ' on o_max.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . (int)$settings['language_id']
								. ' where o_max.customer_id = subdata.customer_id '
									// 1.9.0
									. ($wherePartAll == '' ? '' : ' and ' . $wherePartAll)
							. ' ) as cost_all '
						. ' from '
						. ' ( ' 
							. $subQuery
						. ' ) as subdata '
					. ' )  as data'
				. ' join `' . DB_PREFIX . 'customer` cust '
					. ' on data.customer_id = cust.customer_id '
				. ' left join `' . DB_PREFIX . 'address` addr '
					. ' on cust.address_id = addr.address_id '
						. ' and cust.customer_id = addr.customer_id '
				. ' left join `' . DB_PREFIX . 'order` o_last '
					. ' on data.last_order = o_last.order_id '
			. ($wherePartClient == '' ? '' : ' where ' . $wherePartClient)
			. ' order by data.cost desc, concat(cust.firstname, \' \', cust.lastname) asc  '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

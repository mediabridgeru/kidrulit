<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelClientGroup extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		// Есть ли необходимая таблица
		$is_have_customer_group_desc = $this->isTableCustomerGroupDescription();

		$wherePart = '';

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
					'manufact' => ' p.manufacturer_id ',
				),
			)
		);		
	
		// Сам запрос
		$query = 
			' select cgi.customer_group_id, '
				. ' cgi.cost, '
				. ' cgi.count, '
				. (
					$is_have_customer_group_desc
					? ' ifnull(cgd.name, "' . $this->db->escape($default_name) . '") as customer_group_name '
					: ' ifnull(cg.name, "' . $this->db->escape($default_name) . '") as customer_group_name '
				)
				//. ' ifnull(cgd.name, "' . $this->db->escape($default_name) . '") as customer_group_name '
			. ' from '
					. '( select ifnull(cust_group.customer_group_id, 0) as customer_group_id, '
						. ' sum(o.total ' . $this->addMCC(' * o.currency_value') . ') as cost, '
						. ' count(*) as count  '
						. ' from '
							. ' ( select distinct o.order_id '
								.' from `' . DB_PREFIX . 'order` o '
									. ' join `' . DB_PREFIX . 'order_status` os '
										. ' on o.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . (int)$settings['language_id']
									. ' join `' . DB_PREFIX . 'order_product` op '
										. ' on o.order_id = op.order_id '
									. ' join `' . DB_PREFIX . 'product` p'
										. ' on p.product_id = op.product_id'
									// 1.8.0
									//. ($need_category 
									//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
									//			. ' on p.product_id = ptc.product_id ' 
									//		: '')
								. ($wherePart == '' ? '' : ' where ' . $wherePart)
							. ' ) as oi '
							. ' join `' . DB_PREFIX . 'order` o '
								. ' on o.order_id = oi.order_id '
							. ' left join `' . DB_PREFIX . 'customer` cust '
								. ' on o.customer_id = cust.customer_id '
							. ' left join `' . DB_PREFIX . 'customer_group` cust_group '
								. ' on cust.customer_group_id = cust_group.customer_group_id '
						. ' group by ifnull(cust_group.customer_group_id, 0) '
					. ' )  as cgi'
				. ' left join `' . DB_PREFIX . 'customer_group` cg '
					. ' on cgi.customer_group_id = cg.customer_group_id '
				. (
					$is_have_customer_group_desc
					? (' left join `' . DB_PREFIX . 'customer_group_description` cgd'
						. ' on cg.customer_group_id = cgd.customer_group_id '
							. ' and cgd.language_id = ' . (int)$settings['language_id']
					)
					: ''
				)
			. ' order by cgi.cost desc, customer_group_name asc  '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
	
	// Есть таблица customer_group_description
	protected function isTableCustomerGroupDescription()
	{
		$result = $this->db->query("SHOW TABLES like '" . DB_PREFIX . "customer_group_description'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}
	
}

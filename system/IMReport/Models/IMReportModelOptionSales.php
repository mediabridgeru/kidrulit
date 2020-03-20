<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelOptionSales extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

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
					'cust' => 'o.customer_id',
					'cust_group' => 'o.customer_group_id',
				),
			)
		);		
		
		// Сам запрос
		$query = 
			' select data.option_id, '
				. ' data.option_value_id, '
				. ' data.cost, '
				. ' data.count, '
				. ' ifnull(od.name, "") as option_name, '
				. ' ifnull(ovd.name, "") as option_value_name '
			. ' from '
					. '( select prod_opt.option_id, '
						. ' prod_opt.option_value_id, '
						. ' 0 as cost, ' 
						// 1.5.1
						. ' sum(op.quantity) as count  ' //. ' count(*) as count  ' // op.quantity
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
							. ' join `' . DB_PREFIX . 'order_option` o_opt '
								. ' on o_opt.order_id = oi.order_id '
							// 1.5.1
							. ' join `' . DB_PREFIX . 'order_product` op '
								. ' on o_opt.order_product_id = op.order_product_id '
							. ' join `' . DB_PREFIX . 'product_option_value` prod_opt '
								. 'on prod_opt.product_option_value_id = o_opt.product_option_value_id '
						. ' group by prod_opt.option_id, prod_opt.option_value_id '
					. ' )  as data'
				. ' left join `' . DB_PREFIX . 'option_description` od '
					. ' on od.option_id = data.option_id '
						. ' and od.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` ovd '
					. ' on ovd.option_value_id = data.option_value_id '
						. ' and ovd.language_id = ' . (int)$settings['language_id']
			. ' order by data.count desc, od.name asc, ovd.name asc '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();
		
		return $queryResult->rows;
	}
}

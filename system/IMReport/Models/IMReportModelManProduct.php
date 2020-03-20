<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelManProduct extends IMReportAbstractModel
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
					'cust' => 'o.customer_id',
					'cust_group' => 'o.customer_group_id',
				),
			)
		);		
	
		// Сам запрос
		$query = 
			' select mi.manufacturer_id, '
				. ' mi.cost, '
				. ' mi.count, '
				. ' ifnull(m.name, "' . $this->db->escape($default_name) . '") as man_name '
			. ' from '
					. '( select ifnull(p.manufacturer_id, 0) as manufacturer_id, '
							. ' sum(op.price * op.quantity ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
							. ' sum(op.quantity) as count  '
					. ' from `' . DB_PREFIX . 'order` o '
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
					. ' group by ifnull(p.manufacturer_id, 0) ) as mi'
				. ' left join `' . DB_PREFIX . 'manufacturer` m '
					. ' on mi.manufacturer_id = m.manufacturer_id '
			. ' order by mi.cost desc, ifnull(m.name, "' . $this->db->escape($default_name) . '") asc '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

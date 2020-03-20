<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelShipRegion extends IMReportAbstractModel
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
			' select cgi.country_id, '
				. ' cgi.zone_id, '
				. ' cgi.cost, '
				. ' cgi.count, '
				. ' ifnull(ctr.name, "' . $this->db->escape($default_name) . '") as country_name, '
				. ' ifnull(z.name, "' . $this->db->escape($default_name) . '") as zone_name '
			. ' from '
					. '( select ifnull(o.shipping_country_id, 0) as country_id, '
						. ' ifnull(o.shipping_zone_id, 0) as zone_id, '
						. ' sum(o.total ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
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
						. ' group by ifnull(o.shipping_country_id, 0), ifnull(o.shipping_zone_id, 0) '
					. ' )  as cgi'
				. ' left join `' . DB_PREFIX . 'country` ctr '
					. ' on ctr.country_id = cgi.country_id '
				. ' left join `' . DB_PREFIX . 'zone` z'
					. ' on z.country_id = ctr.country_id '
						. ' and z.zone_id = cgi.zone_id '
			. ' order by cgi.cost desc, ifnull(ctr.name, "' . $this->db->escape($default_name) . '") asc, '
				. ' ifnull(z.name, "' . $this->db->escape($default_name) . '") asc  '
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

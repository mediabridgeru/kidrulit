<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelProductOptionSales extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$module_settings = $this->imhelper->getPostValue($settings, 'module_settings', array());
		$is_product_image_display = (int)$this->imhelper->getPostValue($module_settings, 'IMReportData_p_img_use', 0);

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

		// Подзапрос для получения данных по группам ID
		$querySelectGroupOptionIds = 
			' select ' 
				. 'ifnull( '
					. ' group_concat( '
						. ' concat( o_opt.product_option_id, \'=\', o_opt.product_option_value_id) '
        				. ' order by o_opt.product_option_id asc, '
                        	. ' o_opt.product_option_value_id asc '
                        . 'separator \'===\'), ' 
                 . ' "") as option_group_id '
			. ' from `' . DB_PREFIX . 'order_product` o_prod '
        		. ' left join `' . DB_PREFIX . 'order_option` o_opt '
        			. ' on o_opt.order_product_id = o_prod.order_product_id '
        				. ' and o_opt.product_option_value_id > 0 '
        		. ' left join `' . DB_PREFIX . 'product_option_value` prod_opt '
        			. ' on prod_opt.product_option_value_id = o_opt.product_option_value_id '
        	. ' where o_prod.order_product_id = op.order_product_id '
			. ' group by o_prod.order_product_id '
		;

		// Подзапрос для получения данных по группам Name
		$querySelectGroupOptionNames = 
			' select ' 
				. 'ifnull( '
					. ' group_concat( '
						. ' concat( ifnull(od.name, o_opt.name), \' &gt; \', ifnull(ovd.name, o_opt.value) ) '
        				. ' order by o_opt.product_option_id asc, '
                        	. ' o_opt.product_option_value_id asc '
                        . 'separator \'===\'), ' 
                 . ' "") as option_group_name '
			. ' from `' . DB_PREFIX . 'order_product` o_prod '
        		. ' left join `' . DB_PREFIX . 'order_option` o_opt '
        			. ' on o_opt.order_product_id = o_prod.order_product_id '
        				. ' and o_opt.product_option_value_id > 0 '
        		. ' left join `' . DB_PREFIX . 'product_option_value` prod_opt '
        			. ' on prod_opt.product_option_value_id = o_opt.product_option_value_id '
        		. ' left join `' . DB_PREFIX . 'option_description` od '
        			. ' on od.option_id = prod_opt.option_id'
        				. ' and od.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` ovd '
					. ' on ovd.option_value_id = prod_opt.option_value_id '
						. ' and ovd.language_id = ' . (int)$settings['language_id']
        	. ' where o_prod.order_product_id = op.order_product_id '
			. ' group by o_prod.order_product_id '		;
	
		// Сам запрос
		$query = 
			' select pi.product_id, '
				. ' pi.cost, '
				. ' pi.option_group_id,'
				. ' pi.option_group_name,'
				. ' pi.count, '
				. ' p.model, '
				. ($is_product_image_display 
					? ' p.image as product_image,'
					: ''
				)
				. ' m.name as manufact, '
				. ' pd.name as product_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name '
			. ' from '
					. '( ' 
						. ' select '
							. ' op.product_id, '
							. ' sum(opi.cost) as cost, '
							. ' sum(opi.count) as count, '
							. ' opi.option_group_id, '
							. ' opi.option_group_name '
						. ' from '
						. ' ( '
							. ' select op.order_product_id, '
								. ' op.price * op.quantity ' . $this->addMCC(' * o.currency_value ') . ' as cost, '
								. ' op.quantity as count, '
								. ' ifnull(( ' . $querySelectGroupOptionIds . ' ), "") as option_group_id, '
								. ' ifnull(( ' . $querySelectGroupOptionNames . ' ), "") as option_group_name '
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
						. ' ) as opi'
						. ' join `' . DB_PREFIX . 'order_product` op '
							. ' on op.order_product_id = opi.order_product_id '
						. ' group by op.product_id, opi.option_group_id, opi.option_group_name ' 
					. ') as pi'
				. ' join `' . DB_PREFIX . 'product` p '
					. ' on pi.product_id = p.product_id '
				. ' join `' . DB_PREFIX . 'product_description` pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'manufacturer` m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join `' . DB_PREFIX . 'product_to_category` ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join `' . DB_PREFIX . 'category` cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join `' . DB_PREFIX . 'category_description` catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . (int)$settings['language_id']
			. ' order by pi.count desc, pi.cost desc'
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

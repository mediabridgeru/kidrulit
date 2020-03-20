<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelProductNoSales extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$module_settings = $this->imhelper->getPostValue($settings, 'module_settings', array());
		$is_product_image_display = (int)$this->imhelper->getPostValue($module_settings, 'IMReportData_p_img_use', 0);
		$is_onstore = (int)$this->imhelper->getPostValue($settings, 'onstore', 1);

		$wherePart = '';
		
		$wherePart = $this->getWhereFilterByMetaData(
			$settings,
			array(
				'date' => array(
					'filter_date_start' => " DATE(o.date_added) >= ",
					'filter_date_end' => " DATE(o.date_added) <= ",
					'filter_date_start_aval_product' => " DATE(p.date_available) >= ",
					'filter_date_end_aval_product' => " DATE(p.date_available) <= ",
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
		
		$wherePartProduct = ' pi.product_id is null ';
		
		if ($is_onstore) {
			$wherePartProduct .= ' and p.quantity > 0 ';
		}
		
		$wherePartProduct = $this->getWhereFilterByMetaData(
			$settings,
			array(
				'date' => array(
					'filter_date_start_aval_product' => " DATE(p.date_available) >= ",
					'filter_date_end_aval_product' => " DATE(p.date_available) <= ",
				),
				'cat_product' => array(
					'cat' => 'p.product_id',
				),
				'list_int' => array(
					'manufact' => ' p.manufacturer_id ',
				),
			),
			$wherePartProduct
		);
		
		// Сам запрос
		$query = 
			' select p.product_id, '
				. ' p.price, '
				. ' p.quantity as count, '
				. ' p.model, '
				. ' p.sku, '
				. ($is_product_image_display 
					? ' p.image as product_image,'
					: ''
				)
				. ' m.name as manufact, '
				. ' pd.name as product_name '
			. ' from '
				. ' `' . DB_PREFIX . 'product` p '
				. ' left join ( select distinct op.product_id '
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
						. ' ) as pi'
					. ' on pi.product_id = p.product_id '
				. ' join `' . DB_PREFIX . 'product_description` pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'manufacturer` m '
					. ' on p.manufacturer_id = m.manufacturer_id '
			. ($wherePartProduct == '' ? '' : ' where ' . $wherePartProduct)
			. ' order by p.quantity desc, p.price desc'
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
}

<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelTopProduct extends IMReportAbstractModel
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

		// Сам запрос
		$query =
			' select pi.product_id, '
				. ' pi.cost, '
				. ' pi.count, '
				. ' pi.count_orders, '
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
					. '( select op.product_id, '
							. ' sum(op.price * op.quantity ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
							. ' sum(op.quantity) as count, '
							. ' count(distinct o.order_id) as count_orders '
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
					. ' group by op.product_id ) as pi'
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

<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelStockControl extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$module_settings = $this->imhelper->getPostValue($settings, 'module_settings', array());
		$is_product_image_display = (int)$this->imhelper->getPostValue($module_settings, 'IMReportData_p_img_use', 0);

		// Дефолтное значение минимального остатка
		$default_min_need_quantity = (int)$this->getLangVal('default_min_need_quantity');

		$wherePart = '';

		$wherePart = $this->getWhereFilterByMetaData(
			$settings,
			array(
				'date' => array(
					'filter_date_start' => " DATE(p.date_added) >= ",
					'filter_date_end' => " DATE(p.date_added) <= ",
				),
				'cat_product' => array(
					'cat' => 'p.product_id',
				),
				'list_int' => array(
					'manufact' => ' p.manufacturer_id ',
				),
			)
		);		

		// Получаем минимальный остаток
		$min_need_quantity 
			= isset($settings['min_need_quantity']) 
			? (int)$settings['min_need_quantity']
			: $default_min_need_quantity
		;
	
		// Сам запрос
		$query = 
			' select pi.product_id, '
				. ' ifnull(pi.product_option_value_id, 0) as product_option_value_id, '
				. ' p.quantity as product_quantity, '
				. ' p.subtract as product_subtract, '
				. ' ifnull(pov.quantity, 0) as product_option_value_quantity, '
				. ' ifnull(pov.subtract, 0) as product_option_value_subtract, '
				. ' p.model, '
				. ' m.name as manufact, '
				. ' pd.name as product_name, '
				. ($is_product_image_display 
					? ' p.image as product_image,'
					: ''
				)
				. ' ifnull(opt_d.option_id, 0) as option_id, '
				. ' ifnull(opt_d.name, "") as option_name, '
				. ' ifnull(opt_val_d.option_value_id, 0) as option_value_id, '
				. ' ifnull(opt_val_d.name, "") as option_value_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name, '
				. ' case '
					. ' when ifnull(stock_data.need, -1) < 0 '
						. ' then ' . (int)$min_need_quantity
					. ' else ifnull(stock_data.need, -1) '
				. ' end as need_quantity '
			. ' from '
					. '( ' 
						. ' select '
							. ' p.product_id as product_id, '
							. ' 0 as product_option_value_id, '
							. ' p.quantity as quantity, '
							. ' p.subtract as subtract '
						. ' from `' . DB_PREFIX . 'product` p '
							// 1.8.0
							// . ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
						. ' union '
						. ' select '
							. ' p.product_id as product_id, '
							. ' pov.product_option_value_id as product_option_value_id, '
							. ' pov.quantity as quantity, '
							. ' pov.subtract as subtract '
						. ' from `' . DB_PREFIX . 'product` p '
							. ' join `' . DB_PREFIX . 'product_option_value` pov '
								. ' on p.product_id = pov.product_id '
							// 1.8.0
							//. ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ') as pi'
				. ' join `' . DB_PREFIX . 'product` p '
					. ' on pi.product_id = p.product_id '
				. ' join `' . DB_PREFIX . 'product_description` pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . (int)$settings['language_id']
				// Подгрузка текущих значений минимальных остатков
				. ' left join `' . DB_PREFIX . 'imreport_data_stock_control` stock_data '
					. ' on stock_data.product_id = pi.product_id '
						. ' and stock_data.product_option_value_id = pi.product_option_value_id '
				// Подгрузка опций
				. ' left join `' . DB_PREFIX . 'product_option_value` pov '
					. ' on pi.product_option_value_id = pov.product_option_value_id '
				. ' left join `' . DB_PREFIX . 'option_description` opt_d '
					. ' on pov.option_id = opt_d.option_id '
						. ' and opt_d.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` opt_val_d '
					. ' on pov.option_value_id = opt_val_d.option_value_id '
						. ' and opt_val_d.language_id = ' . (int)$settings['language_id']
				// Стандартные вещи
				. ' left join `' . DB_PREFIX . 'manufacturer` m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join `' . DB_PREFIX . 'product_to_category` ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join `' . DB_PREFIX . 'category` cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join `' . DB_PREFIX . 'category_description` catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . (int)$settings['language_id']
			// Фильтруем по значенияем 
			// Смотрим только те записи, где количество меньше требуемого
			. ' where '
				. ' ifnull(stock_data.need, -1) != 0 '
				. ' and '
					. ' case '
						. 'when ifnull(stock_data.need, -1) < 0 '
							. ' then ' . (int)$min_need_quantity
						. '	else ifnull(stock_data.need, -1) '
					. ' end '
					. ' > '
					. ' pi.quantity '
			. ' order by pd.name asc, ifnull(opt_d.name, "") asc, ifnull(opt_val_d.name, "") asc'
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}

	public function getResultSet($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$module_settings = $this->imhelper->getPostValue($settings, 'module_settings', array());
		$is_product_image_display = (int)$this->imhelper->getPostValue($module_settings, 'IMReportData_p_img_use', 0);

		$wherePart = '';

		$wherePart = $this->getWhereFilterByMetaData(
			$settings,
			array(
				'date' => array(
					'filter_date_start' => " DATE(p.date_added) >= ",
					'filter_date_end' => " DATE(p.date_added) <= ",
				),
				'cat_product' => array(
					'cat' => 'p.product_id',
				),
				'list_int' => array(
					'manufact' => ' p.manufacturer_id ',
				),
			)
		);		

		// Сам запрос
		$query = 
			' select pi.product_id, '
				. ' ifnull(pi.product_option_value_id, 0) as product_option_value_id, '
				. ' p.quantity as product_quantity, '
				. ' p.subtract as product_subtract, '
				. ' ifnull(pov.quantity, 0) as product_option_value_quantity, '
				. ' ifnull(pov.subtract, 0) as product_option_value_subtract, '
				. ' p.model, '
				. ' m.name as manufact, '
				. ' pd.name as product_name, '
				. ($is_product_image_display 
					? ' p.image as product_image,'
					: ''
				)
				. ' ifnull(opt_d.option_id, 0) as option_id, '
				. ' ifnull(opt_d.name, "") as option_name, '
				. ' ifnull(opt_val_d.option_value_id, 0) as option_value_id, '
				. ' ifnull(opt_val_d.name, "") as option_value_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name, '
				. ' ifnull(stock_data.need, -1) as need_quantity '
			. ' from '
					. '( ' 
						. ' select '
							. ' p.product_id as product_id, '
							. ' 0 as product_option_value_id, '
							. ' p.quantity as quantity, '
							. ' p.subtract as subtract '
						. ' from `' . DB_PREFIX . 'product` p '
							// 1.8.0
							// . ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
						. ' union '
						. ' select '
							. ' p.product_id as product_id, '
							. ' pov.product_option_value_id as product_option_value_id, '
							. ' pov.quantity as quantity, '
							. ' pov.subtract as subtract '
						. ' from `' . DB_PREFIX . 'product` p '
							. ' join `' . DB_PREFIX . 'product_option_value` pov '
								. ' on p.product_id = pov.product_id '
							// 1.8.0
							//. ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ') as pi'
				. ' join `' . DB_PREFIX . 'product` p '
					. ' on pi.product_id = p.product_id '
				. ' join `' . DB_PREFIX . 'product_description` pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . (int)$settings['language_id']
				// Подгрузка текущих значений минимальных остатков
				. ' left join `' . DB_PREFIX . 'imreport_data_stock_control` stock_data '
					. ' on stock_data.product_id = pi.product_id '
						. ' and stock_data.product_option_value_id = pi.product_option_value_id '
				// Подгрузка опций
				. ' left join `' . DB_PREFIX . 'product_option_value` pov '
					. ' on pi.product_option_value_id = pov.product_option_value_id '
				. ' left join `' . DB_PREFIX . 'option_description` opt_d '
					. ' on pov.option_id = opt_d.option_id '
						. ' and opt_d.language_id = ' . (int)$settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` opt_val_d '
					. ' on pov.option_value_id = opt_val_d.option_value_id '
						. ' and opt_val_d.language_id = ' . (int)$settings['language_id']
				// Стандартные вещи
				. ' left join `' . DB_PREFIX . 'manufacturer` m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join `' . DB_PREFIX . 'product_to_category` ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join `' . DB_PREFIX . 'category` cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join `' . DB_PREFIX . 'category_description` catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . (int)$settings['language_id']
			. ' order by pd.name asc, ifnull(opt_d.name, "") asc, ifnull(opt_val_d.name, "") asc'
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		return $queryResult->rows;
	}
	
	public function setData($settings)
	{
		// Сохраняем настройки
		if(isset($settings['array_need_quantity']) && is_array($settings['array_need_quantity']))
		{
			foreach($settings['array_need_quantity'] as $item)
			{
				// Сохраняем настройки
				$this->db->query("INSERT INTO `" . DB_PREFIX . "imreport_data_stock_control` "
						. "(product_id, product_option_value_id, need) "
						. " VALUES (" . (int)($item['product_id']) . ", " 
								. (int)($item['product_option_value_id']) . ", " 
								. (int)($item['need']) . " "
						.") " 
					. "ON DUPLICATE KEY UPDATE " 
						. " need=" . (int)($item['need']) . " "
				);
			}
		}
	}
	
}

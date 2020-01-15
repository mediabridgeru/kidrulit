<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/
class ModelModuleIMReport extends Model {

	
	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////
  
	public function install() 
	{
		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imreport_data_stock_control` (
			  `product_id` int(11) NOT NULL,
			  `product_option_value_id` int(11) NOT NULL,
			  `need` int(11) NOT NULL,
			  PRIMARY KEY (`product_id`, `product_option_value_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);
	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall() 
	{
		// Пока ничего не нужно удалять
	}

	/////////////////////////////////////////
	// Получение данных
	/////////////////////////////////////////

	// Ходовой товар
	public function topProduct($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
		// Сам запрос
		$query = 
			' select pi.product_id, '
				. ' pi.cost, '
				. ' pi.count, '
				. ' p.model, '
				. ' m.name as manufact, '
				. ' pd.name as product_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name '
			. ' from '
					. '( select op.product_id, sum(op.price * op.quantity) as cost, sum(op.quantity) as count  '
					. ' from `' . DB_PREFIX . 'order` o '
						. ' join ' . DB_PREFIX . 'order_status os '
							. ' on o.order_status_id = os.order_status_id '
								. ' and os.language_id = ' . $settings['language_id']
						. ' join ' . DB_PREFIX . 'order_product op '
							. ' on o.order_id = op.order_id '
						. ' join ' . DB_PREFIX . 'product p'
							. ' on p.product_id = op.product_id'
						// 1.4.0
						//. ($need_category 
						//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
						//			. ' on p.product_id = ptc.product_id ' 
						//		: '')
					. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ' group by op.product_id ) as pi'
				. ' join ' . DB_PREFIX . 'product p '
					. ' on pi.product_id = p.product_id '
				. ' join ' . DB_PREFIX . 'product_description pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . $settings['language_id']
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join ' . DB_PREFIX . 'product_to_category ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join ' . DB_PREFIX . 'category cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join ' . DB_PREFIX . 'category_description catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . $settings['language_id']
			. $this->getSortBy($settings, ' order by pi.count desc, pi.cost desc')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// Группы клиентов
	public function clientGroup($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		// Есть ли необходимая таблица
		$is_have_customer_group_desc = $this->isTableCustomerGroupDescription();

		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
		// Сам запрос
		$query = 
			' select cgi.customer_group_id, '
				. ' cgi.cost, '
				. ' cgi.count, '
				. (
					$is_have_customer_group_desc
					? ' ifnull(cgd.name, "' . $default_name . '") as customer_group_name '
					: ' ifnull(cg.name, "' . $default_name . '") as customer_group_name '
				)
				//. ' ifnull(cgd.name, "' . $default_name . ") as customer_group_name '
			. ' from '
					. '( select ifnull(cust_group.customer_group_id, 0) as customer_group_id, '
						. ' sum(o.total) as cost, ' 
						. ' count(*) as count  '
						. ' from '
							. ' ( select distinct o.order_id '
								.' from `' . DB_PREFIX . 'order` o '
									. ' join ' . DB_PREFIX . 'order_status os '
										. ' on o.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . $settings['language_id']
									. ' join ' . DB_PREFIX . 'order_product op '
										. ' on o.order_id = op.order_id '
									. ' join ' . DB_PREFIX . 'product p'
										. ' on p.product_id = op.product_id'
									// 1.4.0
									//. ($need_category 
									//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
									//			. ' on p.product_id = ptc.product_id ' 
									//		: '')
								. ($wherePart == '' ? '' : ' where ' . $wherePart)
							. ' ) as oi '
							. ' join `' . DB_PREFIX . 'order` o '
								. ' on o.order_id = oi.order_id '
							. ' left join ' . DB_PREFIX . 'customer cust '
								. ' on o.customer_id = cust.customer_id '
							. ' left join ' . DB_PREFIX . 'customer_group cust_group '
								. ' on cust.customer_group_id = cust_group.customer_group_id '
						. ' group by ifnull(cust_group.customer_group_id, 0) '
					. ' )  as cgi'
				. ' left join ' . DB_PREFIX . 'customer_group cg '
					. ' on cgi.customer_group_id = cg.customer_group_id '
				. (
					$is_have_customer_group_desc
					? (' left join ' . DB_PREFIX . 'customer_group_description cgd'
						. ' on cg.customer_group_id = cgd.customer_group_id '
							. ' and cgd.language_id = ' . $settings['language_id']
					)
					: ''
				)
			. (
				$is_have_customer_group_desc
				? $this->getSortBy($settings, ' order by cgi.cost desc, ifnull(cgd.name, "_") asc  ')
				: str_replace('cgd.name', 'cg.name', $this->getSortBy($settings, ' order by cgi.cost desc, ifnull(cgd.name, "_") asc  '))
			)
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.1
	// Клиенты
	public function clientOrders($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.4.0
		$wherePartClient = '';
		
		// 1.5.0
		$wherePartLast = '';
		$wherePartAll = '';
		
		// 1.5.0
		// Фильтр для поиска последнего отчета
		$wherePartLast .= $this->getWhereFilter($settings, 'order_status_last', ' ol.order_status_id ', $wherePartLast);

		// 1.5.0
		// Фильтр для вычисления общего количества
		$wherePartAll .= $this->getWhereFilter($settings, 'order_status_all', ' o_max.order_status_id ', $wherePartAll);
		
		// Режим отчета
		// 0 - стандарт, 1 - без покупок, 2 - совершивших покупку, но не купивших за период
		$report_mode = intval(empty($settings['client_orders_modes']) ? '0' : $settings['client_orders_modes']);
		
		// 1.3.0
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);
		// 1.4.0
		$wherePartClient 
			.= $this->getDateWhereFilter($settings, 'filter_date_reg_start', 
				" DATE(cust.date_added) >= ", 
				$wherePartClient);

		// 1.3.0
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
		// 1.4.0
		$wherePartClient 
			.= $this->getDateWhereFilter($settings, 'filter_date_reg_end', 
				" DATE(cust.date_added) <= ", 
				$wherePartClient);
	
		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Формируем подзапрос относительно того, 
		// какой режим включен
		$subQuery = '';

		// 1.3.0
		// Стандартный
		if ($report_mode == 0)
		{
			$subQuery = 
				'select cust.customer_id as customer_id, '
				. ' sum(o.total) as cost, ' 
				. ' count(*) as count, '
				// 1.5.0
				. ' (select max(ol.order_id) ' 
						. ' from `' . DB_PREFIX . 'order` ol ' 
							// 1.5.1
							. ' join ' . DB_PREFIX . 'order_status os '
								. ' on ol.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . $settings['language_id']
						. ' where ol.customer_id = cust.customer_id '
							. ($wherePartLast == '' ? '' : ' and ' . $wherePartLast)
					. ' ) ' 
					. '  as last_order '
				//. ' max(oi.order_id) as last_order '
				. ' from '
					. '' . DB_PREFIX . 'customer cust '
					. ' join ( select distinct o.order_id, o.customer_id '
						.' from `' . DB_PREFIX . 'order` o '
							. ' join ' . DB_PREFIX . 'order_status os '
								. ' on o.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . $settings['language_id']
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
					. '' . DB_PREFIX . 'customer cust '
					. ' left join `' . DB_PREFIX . 'order` o '
						. ' on o.customer_id = cust.customer_id '
					// 1.5.1
					. ' left join ' . DB_PREFIX . 'order_status os '
						. ' on o.order_status_id = os.order_status_id '
							. ' and os.language_id = ' . $settings['language_id']
				// 1.5.1
				. ' where o.order_id is null and os.order_status_id is null'
					// 1.2.0
					// 1.4.0
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
				// 1.5.0
				. ' (select max(ol.order_id) ' 
						. ' from `' . DB_PREFIX . 'order` ol ' 
							// 1.5.1
							. ' join ' . DB_PREFIX . 'order_status os '
								. ' on ol.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . $settings['language_id']
						. ' where ol.customer_id = cust.customer_id ' 
							. ($wherePartLast == '' ? '' : ' and ' . $wherePartLast)
					. ') ' 
					. ' as last_order '
				. ' from '
					. '' . DB_PREFIX . 'customer cust '
					. ' left join ( select distinct o.order_id, o.customer_id '
						.' from `' . DB_PREFIX . 'order` o '
							. ' join ' . DB_PREFIX . 'order_status os '
								. ' on o.order_status_id = os.order_status_id '
									. ' and os.language_id = ' . $settings['language_id']
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ' ) oi '
						. ' on oi.customer_id = cust.customer_id '
				. ' where oi.order_id is null '
					. ' and exists (select distinct oe.customer_id '
										. ' from `' . DB_PREFIX . 'order` oe ' 
										. ' where oe.customer_id = cust.customer_id) '
			;
		}

		// 1.4.0
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
									// 1.5.1
									. ' join ' . DB_PREFIX . 'order_status os '
										. ' on o_max.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . $settings['language_id']
								. ' where o_max.customer_id = subdata.customer_id '
									// 1.5.0
									. ($wherePartAll == '' ? '' : ' and ' . $wherePartAll)
							. ' ) as count_all, '
							. ' (select sum(o_max.total) ' 
								. ' from `' . DB_PREFIX . 'order` o_max '
									// 1.5.1
									. ' join ' . DB_PREFIX . 'order_status os '
										. ' on o_max.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . $settings['language_id']
								. ' where o_max.customer_id = subdata.customer_id '
									// 1.5.0
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
			. $this->getSortBy($settings, ' order by data.cost desc, concat(cust.firstname, \' \', cust.lastname) asc  ')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.1
	// Опции за период
	public function optionSales($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
		// Сам запрос
		$query = 
			' select data.option_id, '
				. ' data.option_value_id, '
				. ' data.cost, '
				. ' data.count, '
				. ' od.name as option_name, '
				. ' ovd.name as option_value_name '
			. ' from '
					. '( select prod_opt.option_id, '
						. ' prod_opt.option_value_id, '
						. ' 0 as cost, ' 
						// 1.1.1
						. ' sum(op.quantity) as count  ' //. ' count(*) as count  ' // op.quantity
						. ' from '
							. ' ( select distinct o.order_id '
								.' from `' . DB_PREFIX . 'order` o '
									. ' join ' . DB_PREFIX . 'order_status os '
										. ' on o.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . $settings['language_id']
									. ' join ' . DB_PREFIX . 'order_product op '
										. ' on o.order_id = op.order_id '
									. ' join ' . DB_PREFIX . 'product p'
										. ' on p.product_id = op.product_id'
									// 1.4.0
									//. ($need_category 
									//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
									//			. ' on p.product_id = ptc.product_id ' 
									//		: '')
								. ($wherePart == '' ? '' : ' where ' . $wherePart)
							. ' ) as oi '
							. ' join `' . DB_PREFIX . 'order_option` o_opt '
								. ' on o_opt.order_id = oi.order_id '
							// 1.1.1
							. ' join ' . DB_PREFIX . 'order_product op '
								. ' on o_opt.order_product_id = op.order_product_id '
							. ' join `' . DB_PREFIX . 'product_option_value` prod_opt '
								. 'on prod_opt.product_option_value_id = o_opt.product_option_value_id '
						. ' group by prod_opt.option_id, prod_opt.option_value_id '
					. ' )  as data'
				. ' join `' . DB_PREFIX . 'option_description` od '
					. ' on od.option_id = data.option_id '
						. ' and od.language_id = ' . $settings['language_id']
				. ' join `' . DB_PREFIX . 'option_value_description` ovd '
					. ' on ovd.option_value_id = data.option_value_id '
						. ' and ovd.language_id = ' . $settings['language_id']
			. $this->getSortBy($settings, ' order by data.count desc, od.name asc, ovd.name asc ')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.2.0
	// Товары по опциям
	public function productOptionSales($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
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
						. ' concat( od.name, \' &gt; \', ovd.name ) '
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
        				. ' and od.language_id = ' . $settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` ovd '
					. ' on ovd.option_value_id = prod_opt.option_value_id '
						. ' and ovd.language_id = ' . $settings['language_id']
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
								. ' op.price * op.quantity as cost, ' 
								. ' op.quantity as count, '
								. ' ifnull(( ' . $querySelectGroupOptionIds . ' ), "") as option_group_id, '
								. ' ifnull(( ' . $querySelectGroupOptionNames . ' ), "") as option_group_name '
							. ' from `' . DB_PREFIX . 'order` o '
								. ' join ' . DB_PREFIX . 'order_status os '
									. ' on o.order_status_id = os.order_status_id '
										. ' and os.language_id = ' . $settings['language_id']
								. ' join ' . DB_PREFIX . 'order_product op '
									. ' on o.order_id = op.order_id '
								. ' join ' . DB_PREFIX . 'product p'
									. ' on p.product_id = op.product_id'
								// 1.4.0
								//. ($need_category 
								//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
								//			. ' on p.product_id = ptc.product_id ' 
								//		: '')
							. ($wherePart == '' ? '' : ' where ' . $wherePart)
						. ' ) as opi'
						. ' join ' . DB_PREFIX . 'order_product op '
							. ' on op.order_product_id = opi.order_product_id '
						. ' group by op.product_id, opi.option_group_id, opi.option_group_name ' 
					. ') as pi'
				. ' join ' . DB_PREFIX . 'product p '
					. ' on pi.product_id = p.product_id '
				. ' join ' . DB_PREFIX . 'product_description pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . $settings['language_id']
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join ' . DB_PREFIX . 'product_to_category ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join ' . DB_PREFIX . 'category cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join ' . DB_PREFIX . 'category_description catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . $settings['language_id']
			. $this->getSortBy($settings, ' order by pi.count desc, pi.cost desc')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.3.0
	// Остатки на складе
	public function productOptionQuantity($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(p.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(p.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
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
				. ' ifnull(opt_d.option_id, 0) as option_id, '
				. ' ifnull(opt_d.name, "") as option_name, '
				. ' ifnull(opt_val_d.option_value_id, 0) as option_value_id, '
				. ' ifnull(opt_val_d.name, "") as option_value_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name '
			. ' from '
					. '( ' 
						. ' select '
							. ' p.product_id as product_id, '
							. ' 0 as product_option_value_id, '
							. ' p.quantity as quantity, '
							. ' p.subtract as subtract '
						. ' from `' . DB_PREFIX . 'product` p '
							// 1.4.0
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
							// 1.4.0
							//. ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ') as pi'
				. ' join ' . DB_PREFIX . 'product p '
					. ' on pi.product_id = p.product_id '
				. ' join ' . DB_PREFIX . 'product_description pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . $settings['language_id']
				// Подгрузка опций
				. ' left join `' . DB_PREFIX . 'product_option_value` pov '
					. ' on pi.product_option_value_id = pov.product_option_value_id '
				. ' left join `' . DB_PREFIX . 'option_description` opt_d '
					. ' on pov.option_id = opt_d.option_id '
						. ' and opt_d.language_id = ' . $settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` opt_val_d '
					. ' on pov.option_value_id = opt_val_d.option_value_id '
						. ' and opt_val_d.language_id = ' . $settings['language_id']
				// Стандартные вещи
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join ' . DB_PREFIX . 'product_to_category ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join ' . DB_PREFIX . 'category cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join ' . DB_PREFIX . 'category_description catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . $settings['language_id']
			. $this->getSortBy($settings, ' order by pd.name asc, ifnull(opt_d.name, "") asc, ifnull(opt_val_d.name, "") asc')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.4.0
	// Контроль остатков
	public function stockControl($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 
		
		// 1.4.0
		// Дефолтное значение минимального остатка
		$default_min_need_quantity = intval($this->language->get('default_min_need_quantity'));

		$wherePart = '';

		// 1.4.0
		// Получаем минимальный остаток
		$min_need_quantity 
			= isset($settings['min_need_quantity']) 
			? intval($settings['min_need_quantity'])
			: $default_min_need_quantity
		;
	
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(p.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(p.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
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
				. ' ifnull(opt_d.option_id, 0) as option_id, '
				. ' ifnull(opt_d.name, "") as option_name, '
				. ' ifnull(opt_val_d.option_value_id, 0) as option_value_id, '
				. ' ifnull(opt_val_d.name, "") as option_value_name, '
				. ' ptc.category_id, '
				. ' ifnull(catd.name, "") as category_name, '
				. ' case '
					. ' when ifnull(stock_data.need, -1) < 0 '
						. ' then ' . $min_need_quantity
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
							// 1.4.0
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
							// 1.4.0
							//. ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ') as pi'
				. ' join ' . DB_PREFIX . 'product p '
					. ' on pi.product_id = p.product_id '
				. ' join ' . DB_PREFIX . 'product_description pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . $settings['language_id']
				// Подгрузка текущих значений минимальных остатков
				. ' left join `' . DB_PREFIX . 'imreport_data_stock_control` stock_data '
					. ' on stock_data.product_id = pi.product_id '
						. ' and stock_data.product_option_value_id = pi.product_option_value_id '
				// Подгрузка опций
				. ' left join `' . DB_PREFIX . 'product_option_value` pov '
					. ' on pi.product_option_value_id = pov.product_option_value_id '
				. ' left join `' . DB_PREFIX . 'option_description` opt_d '
					. ' on pov.option_id = opt_d.option_id '
						. ' and opt_d.language_id = ' . $settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` opt_val_d '
					. ' on pov.option_value_id = opt_val_d.option_value_id '
						. ' and opt_val_d.language_id = ' . $settings['language_id']
				// Стандартные вещи
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join ' . DB_PREFIX . 'product_to_category ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join ' . DB_PREFIX . 'category cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join ' . DB_PREFIX . 'category_description catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . $settings['language_id']
			// Фильтруем по значенияем 
			// Смотрим только те записи, где количество меньше требуемого
			. ' where '
				. ' ifnull(stock_data.need, -1) != 0 '
				. ' and '
					. ' case '
						. 'when ifnull(stock_data.need, -1) < 0 '
							. ' then ' . $min_need_quantity
						. '	else ifnull(stock_data.need, -1) '
					. ' end '
					. ' > '
					. ' pi.quantity '
			. $this->getSortBy($settings, ' order by pd.name asc, ifnull(opt_d.name, "") asc, ifnull(opt_val_d.name, "") asc')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.4.0
	// Контроль остатков (настройки)
	public function stockControlSet($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(p.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(p.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
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
							// 1.4.0
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
							// 1.4.0
							//. ($need_category 
							//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
							//			. ' on p.product_id = ptc.product_id ' 
							//		: '')
						. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ') as pi'
				. ' join ' . DB_PREFIX . 'product p '
					. ' on pi.product_id = p.product_id '
				. ' join ' . DB_PREFIX . 'product_description pd '
					. ' on pd.product_id = p.product_id '
						. ' and pd.language_id = ' . $settings['language_id']
				// Подгрузка текущих значений минимальных остатков
				. ' left join `' . DB_PREFIX . 'imreport_data_stock_control` stock_data '
					. ' on stock_data.product_id = pi.product_id '
						. ' and stock_data.product_option_value_id = pi.product_option_value_id '
				// Подгрузка опций
				. ' left join `' . DB_PREFIX . 'product_option_value` pov '
					. ' on pi.product_option_value_id = pov.product_option_value_id '
				. ' left join `' . DB_PREFIX . 'option_description` opt_d '
					. ' on pov.option_id = opt_d.option_id '
						. ' and opt_d.language_id = ' . $settings['language_id']
				. ' left join `' . DB_PREFIX . 'option_value_description` opt_val_d '
					. ' on pov.option_value_id = opt_val_d.option_value_id '
						. ' and opt_val_d.language_id = ' . $settings['language_id']
				// Стандартные вещи
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on p.manufacturer_id = m.manufacturer_id '
				. ' left join ' . DB_PREFIX . 'product_to_category ptc '
					. ' on p.product_id = ptc.product_id '
				. ' left join ' . DB_PREFIX . 'category cat '
					. ' on cat.category_id = ptc.category_id '
				. ' left join ' . DB_PREFIX . 'category_description catd '
					. ' on cat.category_id = catd.category_id '
						. ' and catd.language_id = ' . $settings['language_id']
			. $this->getSortBy($settings, ' order by pd.name asc, ifnull(opt_d.name, "") asc, ifnull(opt_val_d.name, "") asc')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// 1.4.0
	// Установка данных для Контроль остатков (настройки)
	public function stockControlSetData($settings)
	{
		// Сохраняем настройки
		if(isset($settings['array_need_quantity']) && is_array($settings['array_need_quantity']))
		{
			foreach($settings['array_need_quantity'] as $item)
			{
				// Сохраняем настройки
				$this->db->query("INSERT INTO `" . DB_PREFIX . "imreport_data_stock_control` "
						. "(product_id, product_option_value_id, need) "
						. " VALUES (" . intval($item['product_id']) . ", " 
								. intval($item['product_option_value_id']) . ", " 
								. intval($item['need']) . " "
						.") " 
					. "ON DUPLICATE KEY UPDATE " 
						. " need=" . intval($item['need']) . " "
				);
			}
		}
	}

	// Доставка по регионам 
	public function shipRegion($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0		
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0		
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
		// Сам запрос
		$query = 
			' select cgi.country_id, '
				. ' cgi.zone_id, '
				. ' cgi.cost, '
				. ' cgi.count, '
				. ' ifnull(ctr.name, "' . $default_name . '") as country_name, '
				. ' ifnull(z.name, "' . $default_name . '") as zone_name '
			. ' from '
					. '( select ifnull(o.shipping_country_id, 0) as country_id, '
						. ' ifnull(o.shipping_zone_id, 0) as zone_id, '
						. ' sum(o.total) as cost, ' 
						. ' count(*) as count  '
						. ' from '
							. ' ( select distinct o.order_id '
								.' from `' . DB_PREFIX . 'order` o '
									. ' join ' . DB_PREFIX . 'order_status os '
										. ' on o.order_status_id = os.order_status_id '
											. ' and os.language_id = ' . $settings['language_id']
									. ' join ' . DB_PREFIX . 'order_product op '
										. ' on o.order_id = op.order_id '
									. ' join ' . DB_PREFIX . 'product p'
										. ' on p.product_id = op.product_id'
									// 1.4.0
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
				. ' left join ' . DB_PREFIX . 'country ctr '
					. ' on ctr.country_id = cgi.country_id '
				. ' left join ' . DB_PREFIX . 'zone z'
					. ' on z.country_id = ctr.country_id '
						. ' and z.zone_id = cgi.zone_id '
			. $this->getSortBy($settings, ' order by cgi.cost desc, ifnull(ctr.name, "' . $default_name . '") asc, ifnull(z.name, "' . $default_name . '") asc  ')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// Произодители (объем продуктов)
	public function manProduct($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// 1.3.0
		// Стартовая дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_start', " DATE(o.date_added) >= ", $wherePart);

		// 1.3.0
		// Конечная дата
		$wherePart .= $this->getDateWhereFilter($settings, 'filter_date_end', " DATE(o.date_added) <= ", $wherePart);
	
		// 1.4.0
		// Фильтр по категории
		//$category_filter = $this->getWhereFilter($settings, 'cat', ' ptc.category_id ', $wherePart);
		//$need_category = !empty($category_filter);
		//$wherePart .= $category_filter;
		$wherePart .= $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по производителю
		//$wherePart .= $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
	
		// Сам запрос
		$query = 
			' select mi.manufacturer_id, '
				. ' mi.cost, '
				. ' mi.count, '
				. ' ifnull(m.name, "' . $default_name . '") as man_name '
			. ' from '
					. '( select ifnull(p.manufacturer_id, 0) as manufacturer_id, '
							. ' sum(op.price * op.quantity) as cost, '
							. ' sum(op.quantity) as count  '
					. ' from `' . DB_PREFIX . 'order` o '
						. ' join ' . DB_PREFIX . 'order_status os '
							. ' on o.order_status_id = os.order_status_id '
								. ' and os.language_id = ' . $settings['language_id']
						. ' join ' . DB_PREFIX . 'order_product op '
							. ' on o.order_id = op.order_id '
						. ' join ' . DB_PREFIX . 'product p'
							. ' on p.product_id = op.product_id'
						// 1.4.0
						//. ($need_category 
						//		?  ' join ' . DB_PREFIX . 'product_to_category ptc '
						//			. ' on p.product_id = ptc.product_id ' 
						//		: '')
					. ($wherePart == '' ? '' : ' where ' . $wherePart)
					. ' group by ifnull(p.manufacturer_id, 0) ) as mi'
				. ' left join ' . DB_PREFIX . 'manufacturer m '
					. ' on mi.manufacturer_id = m.manufacturer_id '
			. $this->getSortBy($settings, ' order by mi.cost desc, ifnull(m.name, "' . $default_name .'") asc ')
		;
		
		$queryResult = $this->db->query($query);
		
		return $queryResult->rows;
	}

	// Оборот заказов
	public function orderSales($settings) 
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$wherePart = '';
		
		// Стартовая дата
		if (!empty($settings['filter_date_start_month'])
			&& !empty($settings['filter_date_start_year'])) 
		{
			$date = date_create_from_format('d.m.Y',
				'1'
				. '.' . $settings['filter_date_start_month']
				. '.' . $settings['filter_date_start_year']
			);
			$wherePart .= " DATE(o.date_added) >= '" . $date->format('Y-m-d') . "' ";
		}

		// Конечная дата
		if (!empty($settings['filter_date_end_month'])
			&& !empty($settings['filter_date_end_year'])) 
		{
			$date = date_create_from_format('d.m.Y',
				'1'
				. '.' . $settings['filter_date_end_month']
				. '.' . $settings['filter_date_end_year']
			);
			
			$endDate = clone $date;

			$billing_count = '1';
			$billing_unit = 'm';

			$endDate->add( new \DateInterval( 'P' . $billing_count . strtoupper( $billing_unit ) ) );

			if ( intval( $endDate->format( 'n' ) ) > ( intval( $date->format( 'n' ) ) + intval( $billing_count ) ) % 12 )
			{
			    if ( intval( $date->format( 'n' ) ) + intval( $billing_count ) != 12 )
			    {
			        $endDate->modify( 'last day of -1 month' );
			    }
			}
			
			$wherePart .= (empty($wherePart) ? '' : ' and ') 
				. " DATE(o.date_added) < '" . $endDate->format('Y-m-d') . "' ";
		}

		// Фильтр по статусу
		$wherePart .= $this->getWhereFilter($settings, 'order_status', ' o.order_status_id ', $wherePart);
		
		// 1.5.0
		$need_product_join = false;
		
		// 1.5.0
		// Фильтр по категории
		$catFilter = $this->getCategoryWhereFilter($settings, 'cat', 'p.product_id', $wherePart);
		$need_product_join = ($need_product_join || ($catFilter != ''));
		$wherePart .= $catFilter;

		// 1.5.0
		// Фильтр по производителю
		$manFilter = $this->getWhereFilter($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
		$need_product_join = ($need_product_join || ($manFilter != ''));
		$wherePart .= $manFilter;

		// 1.5.0
		// Сам запрос
		$query = 
			' select ' 
				. ' year(o.date_added) as year, '
				. ' month(o.date_added) as month, '
				. ' sum(o.total) as cost, '
				. ' count(*) as count  '
			. ' from ( '
					. ' select '
						.	' distinct o.order_id '
					. ' from `' . DB_PREFIX . 'order` o '
						// 1.5.1
						. ' join ' . DB_PREFIX . 'order_status os '
							. ' on o.order_status_id = os.order_status_id '
								. ' and os.language_id = ' . $settings['language_id']
					. ($need_product_join 
						? (	
							' join `' . DB_PREFIX . 'order_product` op '
								. ' on o.order_id = op.order_id '
							. ' join `' . DB_PREFIX . 'product` p '
								. ' on op.product_id = p.product_id '
						)
						: ''
					)
					. ($wherePart == '' ? '' : ' where ' . $wherePart)
				. ' ) filter '
				. ' join `' . DB_PREFIX . 'order` o '
					. ' on filter.order_id = o.order_id '
			. ' group by year(o.date_added) asc, month(o.date_added) asc'
		;
		
		$queryResult = $this->db->query($query);
		
		// Теперь расчитываем по месяцам
		$searchResult = $queryResult->rows;
		$rowIndex = 0;
		$countRow = count($searchResult);
		
		$result = array();
		
		$start_month = $settings['filter_date_start_month'];
		$start_year = $settings['filter_date_start_year'];
		$end_month = $settings['filter_date_end_month'];
		$end_year = $settings['filter_date_end_year'];
		
		// Пока не прошлись по всем мясецам
		while(($start_year * 100 + $start_month) <= ($end_year * 100 + $end_month))
		{
			if ($countRow > 0 && $rowIndex < $countRow)	
			{
				if (('' . $searchResult[$rowIndex]['year']) == ('' . $start_year)
					&& ('' . $searchResult[$rowIndex]['month']) == ('' . $start_month))
				{
					$result[] = array(
						'year' => $start_year,
						'month' => $start_month,
						'count' => $searchResult[$rowIndex]['count'],
						'cost' => $searchResult[$rowIndex]['cost']
					);	
					$rowIndex++;
				}
				else
				{
					$result[] = array(
						'year' => $start_year,
						'month' => $start_month,
						'count' => 0,
						'cost' => 0
					);	
				}
			}
			else
			{
				$result[] = array(
					'year' => $start_year,
					'month' => $start_month,
					'count' => 0,
					'cost' => 0
				);	
			}
			
			// Переходим к следующему месяцу
			$start_month++;
			if ($start_month > 12)
			{
				$start_month = 1;
				$start_year++;
			}
		}
		
		return $result;
	}

	// Фильтр по спискам
	protected function getWhereFilter($settings, $list_name, $clause, $wherePart)
	{
		$result = '';
		
		if (!isset($settings[$list_name]))
			return $result;
		
		// Если есть , что фильтровать
		if (count($settings[$list_name]) > 0 && !empty($settings[$list_name][0]) 
				&& (('' . $settings[$list_name][0] != '-1') || count($settings[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			if (count($settings[$list_name]) == 1) {
				$result .= $clause . ' = ' . $settings[$list_name][0];
			}
			else {
				$result .= $clause . ' in (' . join(', ', $settings[$list_name]) . ') ';
			}
		}
	
		return $result;
	}

	// 1.4.0
	// Фильтр по спискам для продуктов
	protected function getCategoryWhereFilter($settings, $list_name, $product_field, $wherePart)
	{
		$result = '';
		$is_have_main_category = $this->isHaveMainCategory();
		
		if (!isset($settings[$list_name]))
			return $result;
			
		if ($is_have_main_category && !isset($settings[$list_name . '_main']))
			return $result;
		
		// Если есть , что фильтровать
		if (count($settings[$list_name]) > 0 && !empty($settings[$list_name][0]) 
				&& (('' . $settings[$list_name][0] != '-1') || count($settings[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			$result .= ' exists( '
				. ' select * '
				. ' from `' . DB_PREFIX . 'product_to_category` ptc_filter ' 
				. ' where ptc_filter.product_id = ' . $product_field . ' '
					. ($is_have_main_category && intval($settings[$list_name . '_main']) == 1
						? ' and ptc_filter.main_category = 1 '
						: ''
					)
					. ' and ptc_filter.category_id '
			;
			
			if (count($settings[$list_name]) == 1) {
				$result .= ' = ' . $settings[$list_name][0];
			}
			else {
				$result .= ' in (' . join(', ', $settings[$list_name]) . ') ';
			}
			
			$result .= ' limit 1 ) ';
		}
	
		return $result;
	}
	
	// 1.3.0
	// Фильтр по дате
	protected function getDateWhereFilter($settings, $field_name, $clause, $wherePart)
	{
		if ($wherePart == '' && !empty($settings[$field_name])) {
			$date = date_create_from_format('d.m.Y', $settings[$field_name]);
			return $clause . " '" . $date->format('Y-m-d') . "' ";
		}
		else if (!empty($settings[$field_name])) {
			$date = date_create_from_format('d.m.Y', $settings[$field_name]);
			return " and " . $clause . " '" . $date->format('Y-m-d') . "' ";
		}
		
		return '';
	}


	// Получение порядка сортировки
	protected function getSortBy($settings, $default = ' ')
	{
		$result = '';
		
		if (count($settings['sort']) > 0 && !empty($settings['sort'][0]) 
				&& (('' . $settings['sort'][0] != '-1') || count($settings['sort']) > 1)) {
			if (count($settings['sort']) > 1) {
				$result .= ' order by ' . join(', ', $settings['sort']);
			}			
			else {
				$result .= ' order by ' . $settings['sort'][0];
			}
		}
			
		return (empty($result) ? $default : $result);
	}

	/////////////////////////////////////////
	// Получение списков для фильтра
	/////////////////////////////////////////

	// Получение списка сортировки
	public function getSortList($for = 'top')
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$default_name = $this->db->escape($this->language->get('default_name')); 

		$resultList = array();

		if ($for == 'top')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'pd.name asc', 'name' => 'Продукт (возрастание)');
			$resultList[] = array('id' => 'pd.name desc', 'name' => 'Продукт (убывание)');
			$resultList[] = array('id' => 'p.model asc', 'name' => 'Модель (возрастание)');
			$resultList[] = array('id' => 'p.model desc', 'name' => 'Модель (убывание)');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'pi.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'pi.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'pi.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'pi.cost desc', 'name' => 'Цена (убывание)');
		}
		else if ($for == 'client')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => "ifnull(cgd.name, '_') asc", 'name' => 'Группа (возрастание)');
			$resultList[] = array('id' => "ifnull(cgd.name, '_') desc", 'name' => 'Группа (убывание)');
			$resultList[] = array('id' => 'cgi.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'cgi.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'cgi.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'cgi.cost desc', 'name' => 'Цена (убывание)');
		}
		else if ($for == 'ship_region')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => "ifnull(ctr.name, '" . $default_name . "') asc, ifnull(z.name, '" . $default_name . "') asc",
									 'name' => 'Страна/Регион (возрастание)');
			$resultList[] = array('id' => "ifnull(ctr.name, '" . $default_name . "') desc, ifnull(z.name, '" . $default_name . "') desc",
									 'name' => 'Страна/Регион (убывание)');
			$resultList[] = array('id' => 'cgi.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'cgi.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'cgi.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'cgi.cost desc', 'name' => 'Цена (убывание)');
		}
		else if ($for == 'man_product')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'mi.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'mi.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'mi.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'mi.cost desc', 'name' => 'Цена (убывание)');
		}
		// 1.1
		else if ($for == 'client_orders')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'concat(cust.firstname, \' \', cust.lastname) asc', 'name' => 'Имя клиента (возрастание)');
			$resultList[] = array('id' => 'concat(cust.firstname, \' \', cust.lastname) desc', 'name' => 'Имя клиента (убывание)');
			$resultList[] = array('id' => 'cust.email asc', 'name' => 'Email (возрастание)');
			$resultList[] = array('id' => 'cust.email desc', 'name' => 'Email (убывание)');
			$resultList[] = array('id' => 'cust.telephone asc', 'name' => 'Телефон (возрастание)');
			$resultList[] = array('id' => 'cust.telephone desc', 'name' => 'Телефон (убывание)');
			$resultList[] = array('id' => 'addr.city asc', 'name' => 'Город (возрастание)');
			$resultList[] = array('id' => 'addr.city desc', 'name' => 'Город (убывание)');
			$resultList[] = array('id' => 'cust.status asc', 'name' => 'Статус (возрастание)');
			$resultList[] = array('id' => 'cust.status desc', 'name' => 'Статус (убывание)');
			$resultList[] = array('id' => 'cust.date_added asc', 'name' => 'Регистрация (возрастание)');
			$resultList[] = array('id' => 'cust.date_added desc', 'name' => 'Регистрация (убывание)');
			$resultList[] = array('id' => 'data.last_order asc', 'name' => '# Последний заказ (возрастание)');
			$resultList[] = array('id' => 'data.last_order desc', 'name' => '# Последний заказ (убывание)');
			// 1.2.0
			$resultList[] = array('id' => 'ifnull(o_last.date_added, \'\') asc', 
									'name' => '# Последний заказ - дата (возрастание)');
			$resultList[] = array('id' => 'ifnull(o_last.date_added, \'\') desc', 
									'name' => '# Последний заказ - дата (убывание)');
			$resultList[] = array('id' => 'data.count_all asc', 'name' => 'Количество (Всего) (возрастание)');
			$resultList[] = array('id' => 'data.count_all desc', 'name' => 'Количество (Всего) (убывание)');
			$resultList[] = array('id' => 'data.cost_all asc', 'name' => 'Цена (Всего) (возрастание)');
			$resultList[] = array('id' => 'data.cost_all desc', 'name' => 'Цена (Всего) (убывание)');
			$resultList[] = array('id' => 'data.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'data.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'data.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'data.cost desc', 'name' => 'Цена (убывание)');
		}
		// 1.1
		else if ($for == 'option_sales')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'od.name asc, ovd.name asc', 'name' => 'Наименование опции (возрастание)');
			$resultList[] = array('id' => 'od.name desc, ovd.name desc', 'name' => 'Наименование опции (убывание)');
			$resultList[] = array('id' => 'data.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'data.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'data.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'data.cost desc', 'name' => 'Цена (убывание)');
		}
		// 1.2.0
		else if ($for == 'product_option_sales')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'pd.name asc', 'name' => 'Продукт (возрастание)');
			$resultList[] = array('id' => 'pd.name desc', 'name' => 'Продукт (убывание)');
			$resultList[] = array('id' => 'pi.option_group_name asc', 'name' => 'Опции (возрастание)');
			$resultList[] = array('id' => 'pi.option_group_name desc', 'name' => 'Опции (убывание)');
			$resultList[] = array('id' => 'p.model asc', 'name' => 'Модель (возрастание)');
			$resultList[] = array('id' => 'p.model desc', 'name' => 'Модель (убывание)');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'pi.count asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'pi.count desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'pi.cost asc', 'name' => 'Цена (возрастание)');
			$resultList[] = array('id' => 'pi.cost desc', 'name' => 'Цена (убывание)');
		}
		// 1.3.0
		else if ($for == 'product_option_quantity')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'pd.name asc', 'name' => 'Продукт (возрастание)');
			$resultList[] = array('id' => 'pd.name desc', 'name' => 'Продукт (убывание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') asc, ifnull(opt_val_d.name, \'\') asc', 'name' => 'Опция (возрастание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') desc, ifnull(opt_val_d.name, \'\') desc', 'name' => 'Опция (убывание)');
			$resultList[] = array('id' => 'p.model asc', 'name' => 'Модель (возрастание)');
			$resultList[] = array('id' => 'p.model desc', 'name' => 'Модель (убывание)');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'pi.quantity asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'pi.quantity desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'pi.subtract asc', 'name' => 'Вычитание (возрастание)');
			$resultList[] = array('id' => 'pi.subtract desc', 'name' => 'Вычитание (убывание)');
		}
		// 1.4.0
		else if ($for == 'stock_control')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'pd.name asc', 'name' => 'Продукт (возрастание)');
			$resultList[] = array('id' => 'pd.name desc', 'name' => 'Продукт (убывание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') asc, ifnull(opt_val_d.name, \'\') asc', 'name' => 'Опция (возрастание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') desc, ifnull(opt_val_d.name, \'\') desc', 'name' => 'Опция (убывание)');
			$resultList[] = array('id' => 'p.model asc', 'name' => 'Модель (возрастание)');
			$resultList[] = array('id' => 'p.model desc', 'name' => 'Модель (убывание)');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'pi.subtract asc', 'name' => 'Вычитание (возрастание)');
			$resultList[] = array('id' => 'pi.subtract desc', 'name' => 'Вычитание (убывание)');
			$resultList[] = array('id' => 'pi.quantity asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'pi.quantity desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'ifnull(stock_data.need, -1) asc', 'name' => 'Необходимо (возрастание)');
			$resultList[] = array('id' => 'ifnull(stock_data.need, -1) desc', 'name' => 'Необходимо (убывание)');
		}
		// 1.4.0
		else if ($for == 'stock_control_set')
		{
			$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
			$resultList[] = array('id' => 'pd.name asc', 'name' => 'Продукт (возрастание)');
			$resultList[] = array('id' => 'pd.name desc', 'name' => 'Продукт (убывание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') asc, ifnull(opt_val_d.name, \'\') asc', 'name' => 'Опция (возрастание)');
			$resultList[] = array('id' => 'ifnull(opt_d.name, \'\') desc, ifnull(opt_val_d.name, \'\') desc', 'name' => 'Опция (убывание)');
			$resultList[] = array('id' => 'p.model asc', 'name' => 'Модель (возрастание)');
			$resultList[] = array('id' => 'p.model desc', 'name' => 'Модель (убывание)');
			$resultList[] = array('id' => 'm.name asc', 'name' => 'Производитель (возрастание)');
			$resultList[] = array('id' => 'm.name desc', 'name' => 'Производитель (убывание)');
			$resultList[] = array('id' => 'pi.subtract asc', 'name' => 'Вычитание (возрастание)');
			$resultList[] = array('id' => 'pi.subtract desc', 'name' => 'Вычитание (убывание)');
			$resultList[] = array('id' => 'pi.quantity asc', 'name' => 'Количество (возрастание)');
			$resultList[] = array('id' => 'pi.quantity desc', 'name' => 'Количество (убывание)');
			$resultList[] = array('id' => 'ifnull(stock_data.need, -1) asc', 'name' => 'Необходимо (возрастание)');
			$resultList[] = array('id' => 'ifnull(stock_data.need, -1) desc', 'name' => 'Необходимо (убывание)');
		}
		
		return $this->translateOrderedList($resultList, 'name', 'module_sort_' . $for);
	}

	// 1.3.0
	// Перевод упорядоченных списков
	public function translateOrderedList(&$resultList, $field_name, $list_name)
	{
		$this->load->language('module/IMReport');
		$transList = $this->language->get($list_name);
		
		if (isset($transList) && is_array($transList))
		{
			for ($cnt = 0; $cnt < count($transList); $cnt++)			
			{
				if ($cnt < count($resultList))
				{
					$resultList[$cnt][$field_name] = $transList[$cnt];
				}
			}
		}
		
		return $resultList;
	}

	// Получение списка производителей
	public function getManufacturer()
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$select_all_items = $this->language->get('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name'        => $select_all_items,
			'image'  	  => '',
			'sort_order'  => -1
		);
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "manufacturer m " 
				. " ORDER BY m.sort_order asc, name asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['manufacturer_id'],
				'name'        => $result['name'],
				'image'  	  => $result['image'],
				'sort_order'  => $result['sort_order']
			);
		}	
		
		return $resultList;
	}

	// Получение списка статусов
	public function getOrderStatus($lang_id)
	{
		// 1.3.0
		$this->load->language('module/IMReport');
		$select_all_items = $this->language->get('select_all_items'); 

		$resultList = array();

		$resultList[] = array(
			'id' => -1,
			'name'        => $select_all_items
		);

		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "order_status os " 
				. ' where os.language_id = ' . $lang_id
				. " ORDER BY os.name asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['order_status_id'],
				'name'        => $result['name']
			);
		}	
		
		return $resultList;
	}

	// 1.4.0
	// Проверка, что есть главная категория
	public function isHaveMainCategory()
	{
		return $this->isTableHaveColumn('product_to_category', 'main_category');
	}

	// 1.4.0
	// Есть ли в таблице столбец
	public function isTableHaveColumn($table, $column)
	{
		$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $table . "` LIKE '" . $column . "'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}

	// Есть таблица customer_group_description
	public function isTableCustomerGroupDescription()
	{
		$result = $this->db->query("SHOW TABLES like '" . DB_PREFIX . "customer_group_description'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}
	

	// Получение списка категорий
	public function getCategories($parent_id = 0) 
	{
		$category_data = array();
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT * " 
				. " FROM " . DB_PREFIX . "category c " 
					. " LEFT JOIN " . DB_PREFIX . "category_description cd " 
						. " ON (c.category_id = cd.category_id) " 
				. " WHERE c.parent_id = '" . (int)$parent_id . "' " 
					. " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " 
				. " ORDER BY cd.name ASC"
		);
	
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$category_data[] = array(
				'id' => $result['category_id'],
				'name'        => $this->getPath($result['category_id'], $this->config->get('config_language_id')),
				'status'  	  => $result['status'],
				'sort_order'  => $result['sort_order']
			);
		
			$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
		}	
		
		return $category_data;
	}
	
	// Получение пути
	public function getPath($category_id) 
	{
		// Получаем наименование и ID родительской категории
		$query = $this->db->query("SELECT name, parent_id " 
				. " FROM " . DB_PREFIX . "category c " 
					. " LEFT JOIN " . DB_PREFIX . "category_description cd " 
						. " ON (c.category_id = cd.category_id) " 
				. " WHERE c.category_id = '" . (int)$category_id . "' " 
					. " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " 
				. " ORDER BY c.sort_order, cd.name ASC"
		);
		
		// Если есть родительская категория, то получаем ее
		// Тем самым формируя цепочку
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) 
					. ' > ' 
					. $query->row['name'];
		} 
		// Иначе возвращаем имя категории
		else {
			return $query->row['name'];
		}
	}
}
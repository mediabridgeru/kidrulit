<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelList extends IMReportAbstractModel
{
	// Получение списка имен доставки из заказа
	public function getShipNameListFromOrders()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items,
		);
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT distinct shipping_method as name " 
				. " FROM `" . DB_PREFIX . "order` " 
				. " ORDER BY shipping_method asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (trim($result['name'] == '')) {
				continue;
			}
			$resultList[] = array(
				'id' => $result['name'],
				'name' => $result['name'],
			);
		}	
		
		return $resultList;
	}

	// Получение кодов доставки из заказов
	public function getShipCodeListFromOrders()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items,
		);
		
		// В 1.5.1.3 нет кодов
		if(version_compare(VERSION, '1.5.1.3') <= 0) {
			return $resultList;
		}
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT distinct shipping_code as name " 
				. " FROM `" . DB_PREFIX . "order` " 
				. " ORDER BY shipping_code asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (trim($result['name'] == '')) {
				continue;
			}
			$resultList[] = array(
				'id' => $result['name'],
				'name' => $result['name'],
			);
		}	
		
		return $resultList;
	}

	// Получение списка имен оплат из заказов
	public function getPaymNameListFromOrders()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items,
		);
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT distinct payment_method as name " 
				. " FROM `" . DB_PREFIX . "order` " 
				. " ORDER BY payment_method asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (trim($result['name'] == '')) {
				continue;
			}
			$resultList[] = array(
				'id' => $result['name'],
				'name' => $result['name'],
			);
		}	
		
		return $resultList;
	}

	// Получение списка кодов из заказов
	public function getPaymCodeListFromOrders()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items,
		);

		// В 1.5.1.3 нет кодов
		if(version_compare(VERSION, '1.5.1.3') <= 0) {
			return $resultList;
		}
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT distinct payment_code as name " 
				. " FROM `" . DB_PREFIX . "order` " 
				. " ORDER BY payment_code asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (trim($result['name'] == '')) {
				continue;
			}
			$resultList[] = array(
				'id' => $result['name'],
				'name' => $result['name'],
			);
		}	
		
		return $resultList;
	}

	// Получение списка производителей
	public function getManufacturer()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
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
		$select_all_items = $this->getLangVal('select_all_items'); 

		$resultList = array();

		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items
		);

		// Получаем список категорий на текущем языке
		$query = $this->db->query("SELECT * " 
				. " FROM `" . DB_PREFIX . "order_status` os " 
				. ' where os.language_id = ' . (int)$lang_id
				. " ORDER BY os.name asc"
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['order_status_id'],
				'name' => $result['name']
			);
		}	
		
		return $resultList;
	}

	
	// Получение списка категорий
	public function getCategories($parent_id = 0, $parent_prefix = '') 
	{
		$category_data = array();
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			"SELECT * " 
			. " FROM `" . DB_PREFIX . "category` c " 
				. " LEFT JOIN `" . DB_PREFIX . "category_description` cd " 
					. " ON (c.category_id = cd.category_id) " 
			. " WHERE c.parent_id = '" . (int)$parent_id . "' " 
				. " AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " 
			. " ORDER BY cd.name ASC"
		);
	
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$category_data[] = array(
				'id' => $result['category_id'],
				'name' => $parent_prefix . $result['name'],
				'status' => $result['status'],
				'sort_order' => $result['sort_order']
			);
		
			$category_data = array_merge(
				$category_data, 
				$this->getCategories($result['category_id'], $parent_prefix . $result['name'] . ' > ')
			);
		}	
		
		return $category_data;
	}

	// Получение списка категорий
	public function getCategoriesFull($parent_delimeter = ' > ')
	{
		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			"SELECT c.category_id, c.parent_id, cd.name "
			. " FROM `" . DB_PREFIX . "category` c "
				. " LEFT JOIN `" . DB_PREFIX . "category_description` cd "
					. " ON (c.category_id = cd.category_id) "
			. " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' "
			. " ORDER BY cd.name asc"
		);

		// Формируем ассоциированный список
		$cat_list = array();
		foreach ($query->rows as $result) {
			$cat_list[$result['category_id']] = array(
				'id' => $result['category_id'],
				'pid' => $result['parent_id'],
				'name' => $result['name'],
				'childs' => array(),
			);
		}

		// Формируем дерево
		$cat_tree = array();
		foreach ($cat_list as $key => &$item) {
			if ((int)$item['pid'] <= 0){
				$cat_tree[$key] = &$item;
			} else {
				//Если есть потомки то перебераем массив
				$cat_list[$item['pid']]['childs'][$key] = &$item;
			}
		}
		unset($item);

		$result = $this->_formArrayFromCatTree($cat_tree);

		return $result;
	}

	// Рекурсивная функция формирования списка из дерева
	protected function _formArrayFromCatTree(&$tree, $parent_prefix = '')
	{
		$category_data = array();

		// Формируем результирующий массив
		foreach ($tree as $item) {
			$category_data[] = array(
				'id' => $item['id'],
				'name' => $parent_prefix . $item['name'],
			);

			$category_data = array_merge(
				$category_data,
				$this->_formArrayFromCatTree($item['childs'], $parent_prefix . $item['name'] . ' > ')
			);
		}

		return $category_data;
	}

	// Получение списка производителей
	public function getCustomer()
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		
		$resultList = array();
		
		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items,
		);
		
		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			'SELECT '
				. ' c.customer_id as id, '
				. ' concat(c.firstname, \' \', c.lastname) as name, '
				. ' ifnull(c.email, "") as email, '
				. ' ifnull(c.telephone, "") as phone '
			. ' FROM `' . DB_PREFIX . 'customer` c ' 
			. ' ORDER BY c.firstname asc, c.lastname asc '
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['id'],
				'name' =>
					$result['name']
					. ' / '
					. $result['email']
					. ' / '
					. $result['phone']
					. ' [' . $result['id'] . ']'
				,
			);
		}	
		
		return $resultList;
	}
	
	// 2.4.0
	// Получение списка производителей
	public function getCustomerByFilter($filter, $limit)
	{
		$resultList = array();

		$filter = trim($filter);

		$querySelect =
			'SELECT '
				. ' c.customer_id as id, '
				. ' concat(c.firstname, \' \', c.lastname) as name, '
				. ' ifnull(c.email, "") as email, '
				. ' ifnull(c.telephone, "") as phone '
			. ' FROM `' . DB_PREFIX . 'customer` c '
			. ' WHERE c.firstname like \'%' . $this->db->escape($filter) . '%\''
				. ' or c.lastname like \'%' . $this->db->escape($filter) . '%\''
				. ' or c.email like \'%' . $this->db->escape($filter) . '%\''
				. ' or c.telephone like \'%' . $this->db->escape($filter) . '%\''
				. ' or concat(c.firstname, \' \', c.lastname) like \'%' . $this->db->escape($filter) . '%\''
				. ' or c.customer_id like \'%' . $this->db->escape($filter) . '%\''
			. ' ORDER BY c.firstname asc, c.lastname asc '
			. ' LIMIT ' . (int)$limit
		;

		// Получаем список категорий на текущем языке
		$query = $this->db->query($querySelect);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['id'],
				'name' =>
					$result['name']
					. ' / '
					. $result['email']
					. ' / '
					. $result['phone']
					. ' [' . $result['id'] . ']'
				,
				'text' =>
					$result['name']
					. ' / '
					. $result['email']
					. ' / '
					. $result['phone']
					. ' [' . $result['id'] . ']'
				,
			);
		}

		return $resultList;
	}


	// Получение списка статусов
	public function getCustomerGroup($lang_id)
	{
		$select_all_items = $this->getLangVal('select_all_items'); 
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		// Есть ли необходимая таблица
		$is_have_customer_group_desc = $this->isTableCustomerGroupDescription();
		
		$resultList = array();

		$resultList[] = array(
			'id' => -1,
			'name' => $select_all_items
		);

		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			'SELECT '
				. ' cg.customer_group_id as id, '
				. (
					$is_have_customer_group_desc
					? ' ifnull(cgd.name, "' . $this->db->escape($default_name) . '") as name '
					: ' ifnull(cg.name, "' . $this->db->escape($default_name) . '") as name '
				)
			. ' FROM `' . DB_PREFIX . 'customer_group` cg ' 
				. (
					$is_have_customer_group_desc
					? (' left join `' . DB_PREFIX . 'customer_group_description` cgd'
						. ' on cg.customer_group_id = cgd.customer_group_id '
							. ' and cgd.language_id = ' . (int)$lang_id
					)
					: ''
				)
			. (
				$is_have_customer_group_desc
				? (' ORDER BY ifnull(cgd.name, "' . $this->db->escape($default_name) . '") asc ')
				: (' ORDER BY ifnull(cg.name, "' . $this->db->escape($default_name) . '") asc ')
			)
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['id'],
				'name' => $result['name'] . ' [' . $result['id'] . ']',
			);
		}	
		
		return $resultList;
	}

		// Получение списка статусов
	public function getCustomerGroupByFilter($filter, $limit, $lang_id)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name'));

		// Есть ли необходимая таблица
		$is_have_customer_group_desc = $this->isTableCustomerGroupDescription();

		$resultList = array();

		$filter = trim($filter);

		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			'SELECT '
				. ' cg.customer_group_id as id, '
				. (
					$is_have_customer_group_desc
					? ' ifnull(cgd.name, "' . $this->db->escape($default_name) . '") as name '
					: ' ifnull(cg.name, "' . $this->db->escape($default_name) . '") as name '
				)
			. ' FROM `' . DB_PREFIX . 'customer_group` cg '
				. (
					$is_have_customer_group_desc
					? (' left join `' . DB_PREFIX . 'customer_group_description` cgd'
						. ' on cg.customer_group_id = cgd.customer_group_id '
							. ' and cgd.language_id = ' . (int)$lang_id
					)
					: ''
				)
			. ' WHERE '
				. (
					$is_have_customer_group_desc
					? ' cgd.name like \'%' . $this->db->escape($filter) . '%\''
					: ' cg.name like \'%' . $this->db->escape($filter) . '%\''
				)
				. ' or cg.customer_group_id like \'%' . $this->db->escape($filter) . '%\''
			. (
				$is_have_customer_group_desc
				? (' ORDER BY ifnull(cgd.name, "' . $this->db->escape($default_name) . '") asc ')
				: (' ORDER BY ifnull(cg.name, "' . $this->db->escape($default_name) . '") asc ')
			)
			. ' LIMIT ' . (int)$limit
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['id'],
				'name' => $result['name'] . ' [' . $result['id'] . ']',
				'text' => $result['name'] . ' [' . $result['id'] . ']',
			);
		}

		return $resultList;
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

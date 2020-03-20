<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMDBOptimizerAbstractModel.php';

class IMDBOptimizerModelList extends IMDBOptimizerAbstractModel
{
	
	///////////////////////
	// Список таблиц
	///////////////////////
	public function getDBTables()
	{
		$resultList = array();
		
		// Получаем список атрибутов
		$query = $this->db->query(
			'show tables'
		);
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (!$this->imhelper->startsWith($result['Tables_in_' . DB_DATABASE], DB_PREFIX)) {
				continue;
			}
			$resultList[] = array(
				'id' => $result['Tables_in_' . DB_DATABASE],
				'name' => $result['Tables_in_' . DB_DATABASE],
			);
		}	
		
		return $resultList;
	}

	///////////////////////
	// Список колонок таблицы
	///////////////////////
	public function getTableColumns($table)
	{
		if (!isset($table) || empty($table)) {
			return array();
		}
		
		$query = $this->db->query(
			'show columns from `' . $this->db->escape($table) .'`'
		);
		
		$resultList = array();
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[ strtolower($result['Field']) ] = array(
				'name' => $result['Field'],
				'type' => $result['Type'],
				'null' => $result['Null'],
				'key' => $result['Key'],
				'default' => $result['Default'],
				'extra' => $result['Extra'],
			);
		}	
		
		return $resultList;
	}

	///////////////////////
	// Список индексов таблицы
	///////////////////////
	public function getTableIndexes($table)
	{
		if (!isset($table) || empty($table)) {
			return array();
		}
		
		$query = $this->db->query(
			'show index from `' . $this->db->escape($table) .'`'
		);
		
		$resultList = array();
		
		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			if (!isset($resultList[ strtolower($result['Key_name']) ])) {
				$resultList[ strtolower($result['Key_name']) ] = array(
					'table' => $result['Table'],
					'non_unique' => $result['Non_unique'],
					'key_name' => $result['Key_name'],
					'fields' => array(
						array( 
							'field' => $result['Column_name'], 
							'num' => (int)$result['Seq_in_index'],
						)
					)
				);
			} else {
				$resultList[ strtolower($result['Key_name']) ]['fields'][] = array(
					'field' => $result['Column_name'], 
					'num' => (int)$result['Seq_in_index'],
				);
			}
		}	

		// Сортируем колонки, чтобы точно быть уверенным,
		// что они указаны в порядке следования
		foreach($resultList as &$item) {
			$tempArray = array();
			// Заполняем массив для сортировки
			foreach($item['fields'] as $field) {
				$tempArray[] = $field['num'];
			}
			// Сортируем в порядке следования
			array_multisort($tempArray, $item['fields']);
		}
		// Убираем ссылку от греха подальше
		unset($item);
		
		return $resultList;
	}
}
<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOptimizerHelper.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Models/IMDBOptimizerModelList.php';

if (!defined('IMDBO_NL')) {
	define('IMDBO_NL', "\n");
}

class IMDBOptimizerProcessor
{
	protected $db;
	
	protected $language;
	
	protected $config;
	
	protected $model_lists;
	
	protected $imhelper;
	
	const MAX_INDEX_NAME_LENGTH = 64;
	
	protected $index_prefix = 'imdbo_';

	// Конструктор
	function __construct(&$db = null, &$language = null, &$config = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}

		$this->imhelper = new IMDBOptimizerHelper($this->db);
		
		if (isset($language)) {
			$this->language = &$language;
		}

		if (isset($config)) {
			$this->config = &$config;
		}
		
		$this->model_lists = new IMDBOptimizerModelList($this->db, $this->language, $this->config);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////
	// Получение данных
	////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////
	// Получение данных
	///////////////////////
	public function getDBData($data)
	{
		if (!isset($data) || empty($data) || !is_array($data)) {
			return '----';
		}
		
		$resultReport = '';
		$longdelim = '----------------------------------' . IMDBO_NL;
		$delim = IMDBO_NL;
		
		$tables = $this->imhelper->getPostValue($data, 'tables', array());
		
		// Проходимся по таблицам
		foreach($tables as $item) {
			$resultReport .= $longdelim;
			//////////////////////
			// Таблица
			//////////////////////
			$resultReport .= 'Table: ' . $item . IMDBO_NL;			
			$resultReport .= $longdelim;

			//////////////////////
			// Колонки
			//////////////////////
			$resultReport .= 'Columns: ' . IMDBO_NL;
			$columns = $this->model_lists->getTableColumns($item);
			$tempCols = array();
			// Собираем колонки
			foreach($columns as $key => $col) {
				$tempCols[] = $key;
			}
			$resultReport .= '[ ' . implode(', ', $tempCols) . ' ]' . IMDBO_NL;

			$resultReport .= $delim;

			//////////////////////
			// Индексы
			//////////////////////
			$resultReport .= 'Indexes: ' . IMDBO_NL;
			$indexes = $this->model_lists->getTableIndexes($item);
			$cntInd = 1;
			
			foreach($indexes as $ind) {
				$resultReport .= $cntInd . '. ';
				$resultReport .= $ind['key_name'] . ' - ';
				$resultReport .= 'NonUniq [ ' . $ind['non_unique'] . ' ]' . ' - ';
				
				$tempNamesFields = array();
				
				foreach($ind['fields'] as $field) {
					$tempNamesFields[] = $field['field'];
				}
				
				$resultReport .= '( ' . implode(', ', $tempNamesFields) . ' )' . IMDBO_NL;
				$cntInd++;
			}
			
			$resultReport .= $delim;
		}
		
		return $resultReport;
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Создание индексов
	////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////
	// Генерация индексов для таблицы
	///////////////////////
	public function generateIndexForTable($data)
	{
		if (!isset($data) || empty($data) || !is_array($data)) {
			return array(
				'success' => 0,
				'report' => '---',
				'count' => 0,
				'error' => 1,
			);
		}
		
		//////////////////////
		// Общая и статистическая информация
		//////////////////////
		$resultData = array(
			'success' => 0,
			'report' => '',
			'count' => 0,
			'error' => 0,
		);
		
		// Список индексов, которые необходимо создать
		$indexList = array();

		//////////////////////
		// Собираем данные для колонок
		//////////////////////
		$table = $this->imhelper->getPostValue($data, 'table', '');
		$tableColumns = $this->model_lists->getTableColumns($table);
		
		if (!isset($tableColumns) || empty($table)) {
			$resultData['report'] .= 'Table not exist' . IMDBO_NL;
			return $resultData;
		}
		
		$filterColumn = $this->_getColumnsFilter($data);
		
		// Проходимся по всем колонкам 
		// и смотрим подходят ли они по фильтру
		foreach($tableColumns as $column) {
			if ($this->_checkColumnByFilter($column, $filterColumn)) {
				$indexList[] = array( $column['name'] );
			}
		}
		
		//////////////////////
		// Формируем дополнительные индексы
		// из карты
		//////////////////////
		$indexList = array_merge(
			$indexList, 
			$this->_getIndexesFromMap($table, $tableColumns, $data)
		);

		//////////////////////
		// Создаем все необходимые индексы
		//////////////////////
		$this->_createIndexes($table, $indexList, $resultData);
		
		//////////////////////
		// Возвращаем результат
		//////////////////////
		// Смотрим были ли обнаружены ошибки
		$resultData['success'] = $resultData['error'] == 0 ? 1 : 0;
		
		return $resultData;
	}

	/////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////

	///////////////////////
	// Получение и очистка фильтра
	///////////////////////
	protected function _getColumnsFilter(&$data)
	{
		$filter = array(
			'names' => array(),
			'starts' => array(),
			'ends' => array()
		);
		
		$field_names = $this->imhelper->getPostValue($data, 'field_names', '');
		$field_names = explode(',', $field_names);
		foreach($field_names as $item) {
			$check = trim($item);
			if ( $check == '' ) {
				continue;
			}
			$filter['names'][] = $check;
		}

		$field_starts = $this->imhelper->getPostValue($data, 'field_starts', '');
		$field_starts = explode(',', $field_starts);
		foreach($field_starts as $item) {
			$check = trim($item);
			if ( $check == '' ) {
				continue;
			}
			$filter['starts'][] = $check;
		}

		$field_ends = $this->imhelper->getPostValue($data, 'field_ends', '');
		$field_ends = explode(',', $field_ends);
		foreach($field_ends as $item) {
			$check = trim($item);
			if ( $check == '' ) {
				continue;
			}
			$filter['ends'][] = $check;
		}
		
		return $filter;
	}
	
	///////////////////////
	// Проверяем подходит ли колонка по фильтру
	// Правило ИЛИ
	///////////////////////
	protected function _checkColumnByFilter(&$column, &$filter)
	{
		$name = $column['name'];
		
		foreach($filter['names'] as $checkName) {
			if ($name == $checkName) {
				return true;
			}
		}
		
		foreach($filter['starts'] as $checkStart) {
			if ( $this->imhelper->startsWith($name, $checkStart) ) {
				return true;
			}
		}
		
		foreach($filter['ends'] as $checkEnd) {
			if ( $this->imhelper->endsWith($name, $checkEnd) ) {
				return true;
			}
		}
		
		return false;
	}

	///////////////////////
	// Проверяем есть ли колонка в списке
	///////////////////////
	protected function _checkColumnInTableColumns($colName, &$columns)
	{
		foreach($columns as $col) {
			if ($col['name'] == $colName) {
				return true;
			}
		}
		return false;
	}

	///////////////////////
	// Проверяем подходит ли колонка по фильтру
	///////////////////////
	protected function _getIndexesFromMap($table, &$columns, &$data)
	{
		$returnIndexes = array();
		
		$indexMap = $this->imhelper->getPostValue($data, 'table_index_map', '');
		$indexMap = str_replace('#', DB_PREFIX, $indexMap);
		$indexMap = explode(IMDBO_NL, $indexMap);
		
		// Проходимся по всей карте
		foreach($indexMap as $item) {
			$parts = explode('-', $item);
			if (count($parts) < 2) {
				continue;
			}
			// Разбираем параметры
			$tableInItem = trim($parts[0]);
			
			// Индекс относится к другой таблице
			if ($table != $tableInItem) {
				continue;
			}
			// Смотрим список полей
			$fieldList = explode(',', $parts[1]);
			
			// Строим временный индекс
			$tempIndex = array();
			$is_may_create = true;
			
			foreach($fieldList as $colName) {
				$checkColName = trim($colName);
				if ($this->_checkColumnInTableColumns($checkColName, $columns)) {
					$tempIndex[] = $checkColName;
				} else {
					$is_may_create = false;
					break;
				}
			}
			
			// Если индекс можно построить
			if ($is_may_create && count($tempIndex) > 0) {
				$returnIndexes[] = $tempIndex;
			}
		}
		
		return $returnIndexes;
	}

	///////////////////////
	// Проверяем есть ли уже такой индекс
	///////////////////////
	protected function _isAllreadyIndexExist($index, $currIndexes)
	{
		// Проходимся по всем индексам
		foreach($currIndexes as $oneCurrIndex) {
			// Если количество полей разное, то сразу переходим далее
			if (count($index) != count($oneCurrIndex['fields'])) {
				continue;
			}
			
			$is_have_index = true;
			
			// Смотрим совпадение
			for($cnt = 0; $cnt < count($index); $cnt++) {
				// Если хоть одно поле не совпало, то индексы не одинаковы
				if ($index[$cnt] != $oneCurrIndex['fields'][$cnt]['field']) {
					$is_have_index = false;
					break;
				}
			}
			
			if ($is_have_index) {
				return true;
			}
		}
		
		return false;
	}
	
	///////////////////////
	// Создаем индексы
	///////////////////////
	protected function _createIndexes($table, &$indexList, &$resultData)
	{
		$cnt = 0;
		$resultData['report'] .= 'Indexes:' . IMDBO_NL;
		
		// Проходимся по всему списку индексов
		foreach($indexList as $oneIndex) {
			// Загружаем текущие индексы (каждый раз заново)
			$currIndexes = $this->model_lists->getTableIndexes($table);
			
			$escapedIndex = array();
			
			foreach($oneIndex as $field) {
				$escapedIndex[] = $this->db->escape($field);
			}
			
			$indexName = $this->_formIndexName($escapedIndex, $currIndexes);

			$queryString 
				= 'alter table `' . $this->db->escape($table) . '` '
					. ' add index `' . $this->db->escape($indexName) . '` '
					. ' ( `'
						. implode('`,`', $escapedIndex)
					. '` ) '
			;

			// Индекс уже существует
			if ($this->_isAllreadyIndexExist($oneIndex, $currIndexes)) {
				$resultData['report'] 
					.= 'Info(Exist): (test name - ' . $this->db->escape($indexName) . ') '
						. ' ( `'
							. implode('`,`', $escapedIndex)
						. '` ) '
						. IMDBO_NL
				;
				continue;
			}
			
			$queryResult = $this->db->query($queryString);
			
			if ($queryResult) {
				$cnt++;
				$resultData['count'] = $resultData['count'] + 1;
				$resultData['report'] 
					.= $cnt . '. ' . $this->db->escape($indexName)
						. ' ( `'
							. implode('`,`', $escapedIndex)
						. '` ) '
						. IMDBO_NL
				;
			} else {
				$resultData['error'] = $resultData['error'] + 1;
				$resultData['report'] 
					.= 'Error: ' . $this->db->escape($indexName)
						. ' ( `'
							. implode('`,`', $escapedIndex)
						. '` ) '
						. IMDBO_NL
				;
			}
		}
	}

	///////////////////////
	// Формирование имени индекса
	///////////////////////
	protected function _formIndexName(&$fields, &$currIndexes)
	{
		$indexName = '';
		
		///////////////////////
		// Первый вариант
		// Все колонки помещаются в 64 и такого индекса не существует
		///////////////////////
		$indexName = $this->_getIndexPrefix();
		// Соединяем колонки
		foreach ($fields as $item) {
			$indexName .= ($this->imhelper->endsWith($indexName, '_') ? '' : '_') . strtolower($item);
		}
		// Если индекса такого нет и длина не более 64
		if ( !isset($currIndexes[strtolower($indexName)]) 
			&& strlen($indexName) <= self::MAX_INDEX_NAME_LENGTH
		) {
			return $indexName;
		}

		///////////////////////
		// Второй вариант
		// Все колонки помещаются в 64 и такого индекса не существует
		// Но из каждой колонки используется только первые буквы разделителя '_'
		///////////////////////
		$indexName = $this->_getIndexPrefix();
		// Соединяем колонки
		foreach ($fields as $item) {
			$indexName .= ($this->imhelper->endsWith($indexName, '_') ? '' : '_');
			$partsField = explode('_', strtolower($item));
			foreach ($partsField as $part) {
				$indexName .= substr($part, 0, 1);
			}
		}
		// Если индекса такого нет и длина не более 64
		if ( !isset($currIndexes[strtolower($indexName)]) 
			&& strlen($indexName) <= self::MAX_INDEX_NAME_LENGTH
		) {
			return $indexName;
		}

		///////////////////////
		// Третий вариант
		// Все колонки помещаются в 64 и такого индекса не существует
		// Обрезаем конец второго варианта (если требуется) и формируем нумерацию
		///////////////////////
		
		if (strlen($indexName) > self::MAX_INDEX_NAME_LENGTH - 3) {
			$indexName = substr($indexName, 0 , self::MAX_INDEX_NAME_LENGTH - 3);
		}
		
		$cnt = 1;
		$tempName = '';
		while ($cnt < 100) {
			$tempName = $indexName . ($this->imhelper->endsWith($indexName, '_') ? '' : '_') . $cnt;
			if ( !isset($currIndexes[strtolower($tempName)]) ) {
				return $tempName;
			}
		} 
		
		///////////////////////
		// Четвертый вариант
		// Ничего не остается, как только лишь формировать уник
		///////////////////////
		$cnt = 1;
		$indexName = $this->_getIndexPrefix() . time() . '_' . $cnt;
		while (isset($currIndexes[strtolower($indexName)])) {
			$indexName = $this->_getIndexPrefix() . time() . '_' . $cnt;
			$cnt++;
		}
		
		return $this->imhelper->lenCut($indexName, self::MAX_INDEX_NAME_LENGTH);
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Удаление индексов
	////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////
	// Удаление индексов для таблицы
	///////////////////////
	public function removeIndexForTable($data)
	{
		if (!isset($data) || empty($data) || !is_array($data)) {
			return array(
				'success' => 0,
				'report' => '---',
				'count' => 0,
				'error' => 1,
			);
		}
		
		//////////////////////
		// Общая и статистическая информация
		//////////////////////
		$resultData = array(
			'success' => 0,
			'report' => '',
			'count' => 0,
			'error' => 0,
		);

		// Список индексов, которые необходимо удалить
		$indexList = array();

		//////////////////////
		// Собираем данные об индексах
		//////////////////////
		$table = $this->imhelper->getPostValue($data, 'table', '');
		$tableIndexes = $this->model_lists->getTableIndexes($table);
		
		if ( empty($table) ) {
			$resultData['report'] .= 'Table not exist' . IMDBO_NL;
			return $resultData;
		}

		if ( !isset($tableIndexes) ) {
			$resultData['report'] .= 'Table does not have indexes' . IMDBO_NL;
			return $resultData;
		}

		//////////////////////
		// Проходимся по индексам и собираем те, которые необходимо удалить, 
		// то есть которые начинаются с префикса модуля
		//////////////////////
		foreach ($tableIndexes as $key => $item) {
			if ($this->imhelper->startsWith($key, $this->_getIndexPrefix())) {
				$indexList[] = $item['key_name'];
			}
		}

		//////////////////////
		// Удаляем все необходимые индексы
		//////////////////////
		$this->_removeIndexes($table, $indexList, $resultData);
		
		//////////////////////
		// Возвращаем результат
		//////////////////////
		// Смотрим были ли обнаружены ошибки
		$resultData['success'] = $resultData['error'] == 0 ? 1 : 0;
		
		return $resultData;
	}

	///////////////////////
	// Удаляем индексы
	///////////////////////
	protected function _removeIndexes($table, &$indexList, &$resultData)
	{
		$cnt = 0;
		$resultData['report'] .= 'Indexes:' . IMDBO_NL;
		
		// Проходимся по всему списку индексов
		foreach($indexList as $indexName) {
			$queryString 
				= 'alter table `' . $this->db->escape($table) . '` '
					. ' drop index `' . $this->db->escape($indexName) . '` '
			;

			$queryResult = $this->db->query($queryString);
			
			if ($queryResult) {
				$cnt++;
				$resultData['count'] = $resultData['count'] + 1;
				$resultData['report'] 
					.= $cnt . '. ' . $this->db->escape($indexName) . IMDBO_NL
				;
			} else {
				$resultData['error'] = $resultData['error'] + 1;
				$resultData['report'] 
					.= 'Error: ' . $this->db->escape($indexName) . IMDBO_NL
				;
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Оптимизация таблиц
	////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////
	// Оптимизация таблицы
	///////////////////////
	public function optimizeTable($data)
	{
		if (!isset($data) || empty($data) || !is_array($data)) {
			return array(
				'success' => 0,
				'report' => '---',
				'count' => 0,
				'error' => 1,
			);
		}
		
		//////////////////////
		// Общая и статистическая информация
		//////////////////////
		$resultData = array(
			'success' => 0,
			'report' => '',
			'count' => 0,
			'error' => 0,
		);

		//////////////////////
		// Корректно ли указана таблица
		//////////////////////
		$table = $this->imhelper->getPostValue($data, 'table', '');
		
		if ( empty($table) ) {
			$resultData['report'] .= 'Table not exist' . IMDBO_NL;
			return $resultData;
		}

		//////////////////////
		// Выполняем оптимизацию
		//////////////////////
		$queryString = 'optimize table `' . $this->db->escape($table) . '`';

		$queryResult = $this->db->query($queryString);

		if ($queryResult->rows) {
			$isLastGood = false;
			$resultData['report'] .= '| Op | Msg_type | Msg_text |' . IMDBO_NL;
			foreach($queryResult->rows as $row) {
				$resultData['report'] .= '| ' .$row['Op'] . ' | ';
				$resultData['report'] .= $row['Msg_type'] . ' | ';
				$resultData['report'] .= $row['Msg_text'] . ' | ' . IMDBO_NL;
				$isLastGood 
					= ( strtolower($row['Msg_text']) == 'ok' )
					|| ( trim(strtolower($row['Msg_text'])) == 'table is already up to date' )
				;
			}
			
			if ($isLastGood) {
				$resultData['count'] = 1;
			} else {
				$resultData['error'] = 1;
			}
		}

		//////////////////////
		// Возвращаем результат
		//////////////////////
		// Смотрим были ли обнаружены ошибки
		$resultData['success'] = $resultData['error'] == 0 ? 1 : 0;
		
		return $resultData;
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Починка таблиц
	////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////
	// Починка таблицы
	///////////////////////
	public function repairTable($data)
	{
		if (!isset($data) || empty($data) || !is_array($data)) {
			return array(
				'success' => 0,
				'report' => '---',
				'count' => 0,
				'error' => 1,
			);
		}
		
		//////////////////////
		// Общая и статистическая информация
		//////////////////////
		$resultData = array(
			'success' => 0,
			'report' => '',
			'count' => 0,
			'error' => 0,
		);

		//////////////////////
		// Корректно ли указана таблица
		//////////////////////
		$table = $this->imhelper->getPostValue($data, 'table', '');
		
		if ( empty($table) ) {
			$resultData['report'] .= 'Table not exist' . IMDBO_NL;
			return $resultData;
		}

		//////////////////////
		// Выполняем починку
		//////////////////////
		$queryString = 'repair table `' . $this->db->escape($table) . '`';

		$queryResult = $this->db->query($queryString);

		if ($queryResult->rows) {
			$isLastGood = false;
			$resultData['report'] .= '| Op | Msg_type | Msg_text |' . IMDBO_NL;

			foreach($queryResult->rows as $row) {
				$resultData['report'] .= '| ' .$row['Op'] . ' | ';
				$resultData['report'] .= $row['Msg_type'] . ' | ';
				$resultData['report'] .= $row['Msg_text'] . ' | ' . IMDBO_NL;
				$isLastGood = ( strtolower($row['Msg_text']) == 'ok' );
			}
			
			if ($isLastGood) {
				$resultData['count'] = 1;
			} else {
				$resultData['error'] = 1;
			}
		}

		//////////////////////
		// Возвращаем результат
		//////////////////////
		// Смотрим были ли обнаружены ошибки
		$resultData['success'] = $resultData['error'] == 0 ? 1 : 0;
		
		return $resultData;
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Вспомогательные функции
	////////////////////////////////////////////////////////////////////////////////////////////

	//////////////////////
	// Префикс индексов
	//////////////////////
	protected function _getIndexPrefix()
	{
		return $this->index_prefix;
	}
}
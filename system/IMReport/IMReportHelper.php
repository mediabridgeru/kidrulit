<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMReportHelper
{
	protected $db;
	
	// Конструктор
	function __construct(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}
	}	
	
	// Получение значения из поста
	public function getPostValue(&$data, $name, $default = '')
	{
		if (isset($data) && is_array($data)) {
			if (isset($data[$name])) {
				return $data[$name];
			}
		}
		return $default;
	}

	/**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    public function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
               mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

	// Обрезание строки по длине
	public function lenCut($value, $len)
	{
		if(isset($value) && !empty($value))
			// 1.3
			return mb_substr($value, 0, $len);
		return '';
	}


	// Удаление запрещенных сивмолов для элементов, которые будут внутри мета
	public function replaceStrictHtmlChar($value)
	{
		return str_replace(
		 	array('"'),
		 	array("'"),
		 	$value
		);
	}

	// Удаление тегов и повторяющихся пробелов
	public function stripTags($value)
	{
		return preg_replace('/\s{2,}/', ' ',
			 str_replace( 
			 	array('&nbsp;'),
			 	array(' '),
			 	strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'))
			 )
		);
	}

	// Составление фильтра для даты
	public function getWhereFilterDate($settings, $field_name, $clause, $wherePart)
	{
		try
		{
			if ($wherePart == '' && !empty($settings[$field_name])) {
				//$date = date_create_from_format('d.m.Y', $settings[$field_name]);
				$date = DateTime::createFromFormat('d.m.Y', $settings[$field_name]);
				if (!isset($date) || empty($date)) {
					return '';
				}
				return $this->db->escape($clause) . " '" . $date->format('Y-m-d') . "' ";
			}
			else if (!empty($settings[$field_name])) {
				//$date = date_create_from_format('d.m.Y', $settings[$field_name]);
				$date = DateTime::createFromFormat('d.m.Y', $settings[$field_name]);
				if (!isset($date) || empty($date)) {
					return '';
				}
				return " and " . $this->db->escape($clause) . " '" . $date->format('Y-m-d') . "' ";
			}
		}
		catch(Exception $ex)
		{
			return '';
		}
		return '';
	}

	// Составление фильтра для списка (по умолчанию int)
	public function getWhereFilterList($data, $list_name, $clause, $wherePart)
	{
		$result = '';
		
		if (!isset($data[$list_name]))
			return $result;
		
		// Если есть , что фильтровать
		if (count($data[$list_name]) > 0 && !empty($data[$list_name][0]) 
				&& (('' . $data[$list_name][0] != '-1') || count($data[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			if (!is_array($data[$list_name])) {
				$result .= $this->db->escape($clause) . ' = ' . (int)$data[$list_name];
			}
			else if (count($data[$list_name]) == 1) {
				$result .= $this->db->escape($clause) . ' = ' . (int)$data[$list_name][0];
			}
			else {
				for ($cnt = 0; $cnt < count($data[$list_name]); $cnt++) {
					$data[$list_name][$cnt] = (int)$data[$list_name][$cnt];
				}
				$result .= $this->db->escape($clause) . ' in (' . join(', ', $data[$list_name]) . ') ';
			}
		}
	
		return $result;
	}
	
	// Составление фильтра для списка строк
	public function getWhereFilterListString($data, $list_name, $clause, $wherePart)
	{
		$result = '';
		
		if (!isset($data[$list_name]))
			return $result;
		
		// Если есть , что фильтровать
		if (count($data[$list_name]) > 0 && (!empty($data[$list_name][0]) || (''.$data[$list_name][0]) == '0')
				&& (('' . $data[$list_name][0] != '-1') || count($data[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			if (!is_array($data[$list_name])) {
				$result .= $clause . ' = ' . $this->inQuoteEsc($data[$list_name]);
			}
			else if (count($data[$list_name]) == 1) {
				$result .= $clause . ' = ' . $this->inQuoteEsc($data[$list_name][0]);
			}
			else {
				for ($cnt = 0; $cnt < count($data[$list_name]); $cnt++) {
					$data[$list_name][$cnt] = $this->inQuoteEsc($data[$list_name][$cnt]);
				}
				$result .= $clause . ' in (' . join(', ', $data[$list_name]) . ') ';
			}
		}
	
		return $result;
	}
	
	// Фильтр по спискам для продуктов
	public function getCategoryProductWhereFilter(
		$settings, $list_name, $product_field, $is_have_main_category, $wherePart
	)
	{
		$result = '';
		
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
				. ' where ptc_filter.product_id = ' . $this->db->escape($product_field) . ' '
					. ($is_have_main_category && (int)$settings[$list_name . '_main'] == 1
						? ' and ptc_filter.main_category = 1 '
						: ''
					)
					. ' and ptc_filter.category_id '
			;
			
			if (count($settings[$list_name]) == 1) {
				$result .= ' = ' . (int)$settings[$list_name][0];
			}
			else {
				for ($cnt = 0; $cnt < count($settings[$list_name]); $cnt++) {
					$settings[$list_name][$cnt] = (int)$settings[$list_name][$cnt];
				}
				
				$result .= ' in (' . join(', ', $settings[$list_name]) . ') ';
			}
			
			$result .= ' limit 1 ) ';
		}
	
		return $result;
	}

	// В кавычках одинарных и escape
	public function inQuoteEsc($value) 
	{
		return $this->inQuote($this->db->escape($value));
	}

	// Добавление одинарных кавычек без всего остального
	public function inQuote($value) 
	{
		return '\'' . $value . '\'';
	}

}

<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMDBOptimizerHelper.php';

if (!defined('IMDBO_NL')) {
	define('IMDBO_NL', "\n");
}

class IMDBOSettings
{
	private $db;
	
	private $helper;
	
	public function __construct(&$db)
	{
		if (!isset($db) || empty($db)) {
			exit('Error: IMDBO Could not load database!');
		}
		
		$this->db = &$db;
		
		$this->helper = new IMDBOptimizerHelper($db);
	}

	/////////////////////////////
	// Установка - удаление
	/////////////////////////////
	public function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imdbo_settings` (
			  `imdbo_settings_id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(50) NOT NULL,
			  `key` varchar(200) NOT NULL,
			  `value` text NOT NULL,
			  `serialized` int(11) NOT NULL,
			  PRIMARY KEY (`imdbo_settings_id`),
			  INDEX(`code`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);
		
		////////////////////////////////////
		// Кэш
		// Установка параметров по умолчанию
		////////////////////////////////////
		$currSet = $this->getSettings('cache');
		
		if (!isset($currSet['enable'])) {
			$this->updateSettings('cache', array( 'enable' => 0 ));
		}
		
		if (!isset($currSet['maxdblen'])) {
			$this->updateSettings('cache', array( 'maxdblen' => 20000 ));
		}
		
		if (!isset($currSet['expire'])) {
			$this->updateSettings('cache', array( 'expire' => 3600 ));
		}
		
		if (!isset($currSet['filters'])) {
			$defaultFiltersArray = array(
				'#address',
				'#affiliate',
				'#api',
				'#banner',
				'#cart',
				'#coupon',
				'#currency',
				'#customer',
				'#download',
				'#event',
				'#extension',
				'#filter',
				'#location',
				'#module',
				'#order',
				'#recurring',
				'#return',
				'#setting',
				'#upload',
				'#user',
				'#voucher',
			);
			
			$filterString = '';
			
			foreach($defaultFiltersArray as $item) {
				$filterString .= $item . IMDBO_NL;
			}
			
			$this->updateSettings('cache', array( 'filters' => $filterString ));
		}
		
		if (!isset($currSet['urls'])) {
			$defaultUrlsArray = array(
				'r: #/cart',
				'r: #/cart/',
				'i: =checkout/',
				'r: #/checkout',
				'r: #/checkout/',
				'r: #/simplecheckout',
				'r: #/simplecheckout/',
				'i: =common/cart/',
				'i: =account/',
			);

			$urlsString = '';
			
			foreach($defaultUrlsArray as $item) {
				$urlsString .= $item . IMDBO_NL;
			}
			
			$this->updateSettings('cache', array( 'urls' => $urlsString ));
		}
	}

	public function uninstall()
	{
		if ($this->helper->isTableExists('imdbo_settings')) {
			$currSet = $this->getSettings('cache');
			if (isset($currSet['enable'])) {
				// Выключаем кэш
				$this->updateSettings('cache', array( 'enable' => 0 ));
			}
		}
	}

	/////////////////////////////
	// Интерфейс
	/////////////////////////////
	public function getSettings($code)
	{
		$data = array();
		
		$queryString =
			' select * '
			. ' from `' . DB_PREFIX . 'imdbo_settings` '
			. ' where `code` = \'' . $this->db->escape($code) . '\' '
		;
		
		$query = $this->db->query($queryString);

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = json_decode($result['value'], true);
			}
		}
		
		return $data;
	}
	
	public function setSettings($code, $values)
	{
		$this->deleteSettings($code);
		$queryString = '';
		
		foreach($values as $key => $value)
		{
			$queryString = 
				'insert into `' . DB_PREFIX . 'imdbo_settings` '
				. ' (`code`, `key`, `value`, `serialized`) '
				. ' values( '
					. ' \'' . $this->db->escape($code) . '\', ' 
					. ' \'' . $this->db->escape($key) . '\', ' 
			;
		
			if (!is_array($value)) {
				$queryString .=
						' \'' . $this->db->escape($value) . '\', '
						. ' 0 '
					. ' ) '
				;
			} else {
				$queryString .=
						' \'' . $this->db->escape(json_encode($value)) . '\', '
						. ' 1 '
					. ' ) '
				;
			}
			$this->db->query($queryString);
		}
	}
	
	public function updateSettings($code, $values)
	{
		$currSet = $this->getSettings($code);
		$actSet = array_merge($currSet, $values);
		$this->setSettings($code, $actSet);
	}
	
	public function deleteSettings($code)
	{
		$queryString =
			' delete '
			. ' from `' . DB_PREFIX . 'imdbo_settings` '
			. ' where `code` = \'' . $this->db->escape($code) . '\' '
		;
		
		$query = $this->db->query($queryString);
	}
	
}
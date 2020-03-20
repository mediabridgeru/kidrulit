<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOptimizerHelper.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOptimizerProcessor.php';

class ModelModuleIMDBOptimizer extends Model {

	protected $imhelper;
	protected $improcessor;
	
	function __construct($registry)
	{
		parent::__construct($registry);

		$this->load->language('module/IMDBOptimizer');
		
		$this->imhelper = new IMDBOptimizerHelper($this->db);
		
		$this->improcessor = new IMDBOptimizerProcessor($this->db, $this->language, $this->config);
		
	}

	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////
  
	public function install() 
	{
	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall() 
	{
	}

	/////////////////////////////////////////
	// Получение данных
	/////////////////////////////////////////
	public function getDBData($data = array())
	{
		return $this->improcessor->getDBData($data);
	}
	
	/////////////////////////////////////////
	// Генерация индексов для таблицы
	/////////////////////////////////////////
	public function generateIndexForTable($data = array())
	{
		return $this->improcessor->generateIndexForTable($data);
	}

	/////////////////////////////////////////
	// Удаление индексов для таблицы
	/////////////////////////////////////////
	public function removeIndexForTable($data = array())
	{
		return $this->improcessor->removeIndexForTable($data);
	}

	/////////////////////////////////////////
	// Оптимизация таблицы
	/////////////////////////////////////////
	public function optimizeTable($data = array())
	{
		return $this->improcessor->optimizeTable($data);
	}

	/////////////////////////////////////////
	// Удаление индексов для таблицы
	/////////////////////////////////////////
	public function repairTable($data = array())
	{
		return $this->improcessor->repairTable($data);
	}
}
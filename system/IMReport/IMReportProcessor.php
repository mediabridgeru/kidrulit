<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMReportProcessor
{
	protected $db;
	
	function __construct(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}
	}

	public function install()
	{
	}

	public function uninstall()
	{
	}

}

<?php
class ModelPaymentSbacquiring extends Model {
	private $key;
	private $iv;
	
	public function encrypt($value, $key) {
		return $value;
	}
	
	public function decrypt($value, $key) {
		return $value;
	}

	public function getStatus() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sbacquiring` ORDER BY `yandex_id` DESC");
		return $query->rows;
	}

	public function getPayMethods() {
		
		$sb = array('sbacquiring');
    	$sb_codes = array();  
    	foreach ($sb as $sbcode){if ($this->config->get($sbcode.'_status')){$sb_codes[] = $sbcode;}}

		return $sb_codes;
	}

	public function getProSettings() {
		$setpro = array('debug', 'cart', 'nds', 'nds_important', 'returnpage', 'otlog', 'customName', 'customShip');
		return $setpro;
	}
}
?>
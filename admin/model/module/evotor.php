<?php
class ModelModuleEvotor extends Model {

	public function evotorcurlito($order_info, $order_status_id) {
		$kkmfr_postdata = array(
            'order_id' => (int)$order_info['order_id'],
            'order_status_id' => (int)$order_status_id,
            'code' => hash_hmac('sha256', md5($order_info['order_id'].$this->config->get('evotor_license')), $this->config->get('config_encryption')),
          );
          if ( $curl = curl_init() ) {
              curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=module/evotor/rec');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
              curl_setopt($curl, CURLOPT_POST, true);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $kkmfr_postdata);
              curl_setopt($curl, CURLOPT_USERAGENT, 'art&pr-opencart');
              curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
              curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
              $result = curl_exec($curl);
              curl_close($curl);
          }
          else {
            $this->log->write('Evotor ERROR: No CURL');
          }
	}

	public function getSettings() {
		$setpro = array('status', 'order_status_id_confirm', 'order_status_id_nal_confirm', 'user', /*'firm_name', 'InnKkm', 'order_status_id_return', 'order_status_id_nal_return',*/'payments', 'payments_nal', 'nds', 'nds_important', 'logs', 'customName', 'customShip', 'Timeout', 'errorEmail', 'storeUiid', 'tax_system_code');
		return $setpro;
	}

	public function getValidate() {
		$setvalidate = array('user', 'storeUiid');
		return $setvalidate;
	}

	public function getStatus() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "evotor` ORDER BY `id` DESC");
		return $query->rows;
	}


}
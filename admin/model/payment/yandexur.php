<?php
class ModelPaymentyandexur extends Model {
	private $key;
	private $iv;

	public function changeStatus($order_id, $status) {

		$this->db->query("UPDATE " . DB_PREFIX . "yandexur SET `status` = '" . (int) $status . "' where num_order='" . (int) $order_id . " '");

	}

	
	public function getTotalStatus() {

		$sql = "SELECT COUNT(yandex_id) AS total FROM " . DB_PREFIX . "yandexur WHERE `status` = 1 OR `status` = 2 OR `status` = 3";

		$query = $this->db->query($sql);

		return $query->row['total'];

	}

	public function getStatus($data) {

		$sql = "SELECT * FROM `" . DB_PREFIX . "yandexur` WHERE `status` = 1 OR `status` = 2 OR `status` = 3 ORDER BY `yandex_id` DESC";
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function encrypt($value, $key) {
		$key = hash('sha256', $key, true);
		$iv = mcrypt_create_iv(32, MCRYPT_RAND);
		return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $iv)), '+/=', '-_,');
	}
	
	public function decrypt($value, $key) {
		$key = hash('sha256', $key, true);
		$iv = mcrypt_create_iv(32, MCRYPT_RAND);
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode(strtr($value, '-_,', '+/=')), MCRYPT_MODE_ECB, $iv));
	}

	public function getPayMethods() {
		
		$yu = array('yandexur', 'yandexur_card', 'yandexur_term', 'yandexur_sb', 'yandexur_alfa', 'yandexur_mobile', 'yandexur_wm', 'yandexur_ma', 'yandexur_pb', 'yandexur_qw', 'yandexur_kv', 'yandexur_ep', 'yandexur_ins', 'yandexur_yka', 'yandexur_bsb');
    	$yu_codes = array();  
    	foreach ($yu as $yucode){if ($this->config->get($yucode.'_status')){$yu_codes[] = $yucode;}}

		return $yu_codes;
	}

	public function getPoles() {

		$pt = array();

		$pt['payment_mode_default'] = array('full_prepayment', 'partial_prepayment', 'advance', 'full_payment', 'partial_payment', 'credit', 'credit_payment');
		$pt['payment_mode_source'] = array('default', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location');

		$pt['payment_subject_default'] = array('commodity', 'excise', 'job', 'service', 'gambling_bet', 'gambling_prize', 'lottery', 'lottery_prize', 'intellectual_activity', 'payment', 'agent_commission', 'composite', 'another');
		$pt['payment_subject_source'] = array('default', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location');

		$pt['shipping_tax'] = array('none', '18', '10', '0', '110', '118');

		return $pt;

	}

	public function getProSettings() {
		$setpro = array('debug', 'cart', 'nds', 'nds_important', 'returnpage', 'otlog', 'customName', 'customShip', 'protokol', 'twostage', 'capture', 'trycount', 'trytimeout', 'tax_system_code', 'payment_subject_default', 'payment_subject_source', 'payment_mode_default', 'payment_mode_source', 'show_free_shipping', 'shipping_tax', 'shipinprod');
		return $setpro;
	}

	public function getTwostage($paymentType) {

		if (strpos($paymentType, '_card')) {
			$pt = true;
		} else {
			$pt = false;
		}

		return $pt;
	}

	public function getPaymentType($paymentType) {
		if ($paymentType == 'yandexur'){
			$pt = 'PC';
		}
		if ($paymentType == 'yandexur_card'){
			$pt = 'AC';
		}
		if ($paymentType == 'yandexur_term'){
			$pt = 'GP';
		}
		if ($paymentType == 'yandexur_wm'){
			$pt = 'WM';
		}
		if ($paymentType == 'yandexur_sb'){
			$pt = 'SB';
		}
		if ($paymentType == 'yandexur_alfa'){
			$pt = 'AB';
		}
		if ($paymentType == 'yandexur_mobile'){
			$pt = 'MC';
		}
		if ($paymentType == 'yandexur_mp'){
			$pt = 'MP';
		}
		if ($paymentType == 'yandexur_ma'){
			$pt = 'МА';
		}
		if ($paymentType == 'yandexur_pb'){
			$pt = 'PB';
		}
		if ($paymentType == 'yandexur_qw'){
			$pt = 'QW';
		}
		if ($paymentType == 'yandexur_kv'){
			$pt = 'KV';
		}
		if ($paymentType == 'yandexur_ep'){
			$pt = 'EP';
		}
		if ($paymentType == 'yandexur_ins'){
			$pt = 'CR';
		}
		if ($paymentType == 'yandexur_bsb'){
            $pt = 'BSB';
        }
		if ($paymentType == 'yandexur_yka'){
			$pt = '';
		}
		

		return $pt;
	}
}
?>
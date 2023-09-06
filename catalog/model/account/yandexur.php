<?php
class ModelAccountyandexur extends Model {
	private $key;
	private $iv;

	public function getOrderStatus($order_status_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}

	public function getPaymentStatus($order_id) {
		$query = $this->db->query("SELECT `status` FROM " . DB_PREFIX . "yandexur WHERE num_order = '" . (int)$order_id . "' ");
		
		return $query->row;
	}

	public function yanencrypt($value, $key) {
		$key = hash('sha256', $key, true);
		$iv = mcrypt_create_iv(32, MCRYPT_RAND);
		return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $iv)), '+/=', '-_,');
	}
	
	public function yandecrypt($value, $key) {
		$key = hash('sha256', $key, true);
		$iv = mcrypt_create_iv(32, MCRYPT_RAND);
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode(strtr($value, '-_,', '+/=')), MCRYPT_MODE_ECB, $iv));
	}

	public function getPayMethods() {
		
		$yu = array('yandexur', 'yandexur_card', 'yandexur_term', 'yandexur_sb', 'yandexur_alfa', 'yandexur_mobile', 'yandexur_wm', 'yandexur_pb', 'yandexur_ma', 'yandexur_qw', 'yandexur_kv', 'yandexur_ep', 'yandexur_yka', 'yandexur_bsb', 'yandexur_ins');
    	$yu_codes = array();  
    	foreach ($yu as $yucode){if ($this->config->get($yucode.'_status')){$yu_codes[] = $yucode;}}

		return $yu_codes;
	}

	public function getCustomName($product_id, $place) {

		$query = $this->db->query("SELECT `".$this->db->escape($place)."` FROM " . DB_PREFIX . "product where product_id='".(int)$product_id."' ");
		if ($query->row){
			return $query->row[$place];
		}

	}

	public function getPaymentType($paymentType) {
		if ($paymentType == 'PC'){
			$pt = 'yandexur';
		}
		if ($paymentType == 'AC'){
			$pt = 'yandexur_card';
		}
		if ($paymentType == 'GP'){
			$pt = 'yandexur_term';
		}
		if ($paymentType == 'WM'){
			$pt = 'yandexur_wm';
		}
		if ($paymentType == 'SB'){
			$pt = 'yandexur_sb';
		}
		if ($paymentType == 'AB'){
			$pt = 'yandexur_alfa';
		}
		if ($paymentType == 'MC'){
			$pt = 'yandexur_mobile';
		}
		if ($paymentType == 'MP'){
			$pt = 'yandexur_mp';
		}
		if ($paymentType == 'МА'){
			$pt = 'yandexur_ma';
		}
		if ($paymentType == 'PB'){
			$pt = 'yandexur_pb';
		}
		if ($paymentType == 'QW'){
			$pt = 'yandexur_qw';
		}
		if ($paymentType == 'KV'){
			$pt = 'yandexur_kv';
		}
		if ($paymentType == 'EP'){
			$pt = 'yandexur_ep';
		}
		if ($paymentType == 'CR'){
			$pt = 'yandexur_ins';
		}
		if ($paymentType == 'BSB') {
            $pt = 'yandexur_bsb';
        }
		

		return $pt;
	}

	//API NEW

	public function getPaymentIdByNum($num) {
		$query = $this->db->query("SELECT `sender` FROM " . DB_PREFIX . "yandexur WHERE num_order = '" . (int)$num . "' ");

		return $query->row['sender'];
	}

	public function getPaymentNumById($id) {
		$query = $this->db->query("SELECT `num_order` FROM " . DB_PREFIX . "yandexur WHERE sender = '" . $this->db->escape($id) . "' ");

		return $query->row;
	}

	public function getStatusAndId($order_id) {
		$query = $this->db->query("SELECT `status`, `sender` FROM " . DB_PREFIX . "yandexur WHERE num_order = '" . (int) $order_id . "' ");

		return $query->row;
	}

	public function setPaymentStatus($order_info, $invoiceId = 0, $status = 0, $orderSumAmount = 0, $orderCreatedDatetime = 0) {

		$query = $this->db->query("INSERT INTO `" . DB_PREFIX . "yandexur` SET `num_order` = '" . (int) $order_info['order_id'] . "' , `sum` = '" . $this->db->escape($orderSumAmount) . "' , `date_enroled` = '" . $this->db->escape($orderCreatedDatetime) . "', `date_created` = '" . $this->db->escape($order_info['date_added']) . "', `user` = '" . $this->db->escape($order_info['payment_firstname']) . " " . $this->db->escape($order_info['payment_lastname']) . "', `email` = '" . $this->db->escape($order_info['email']) . "', `status` = '" . (int) $status . "', `sender` = '" . $this->db->escape($invoiceId) . "' ");

	}

	public function updatePaymentStatus($order_info, $invoiceId = 0, $status = 0, $orderSumAmount = 0, $orderCreatedDatetime = 0) {

		$query = $this->db->query("UPDATE " . DB_PREFIX . "yandexur SET `sum` = '" . $this->db->escape($orderSumAmount) . "' , `date_enroled` = '" . $this->db->escape($orderCreatedDatetime) . "', `date_created` = '" . $this->db->escape($order_info['date_added']) . "', `user` = '" . $this->db->escape($order_info['payment_firstname']) . " " . $this->db->escape($order_info['payment_lastname']) . "', `email` = '" . $this->db->escape($order_info['email']) . "', `status` = '" . (int) $status . "', `sender` = '" . $this->db->escape($invoiceId) . "' where num_order='" . (int) $order_info['order_id'] . " '");

	}

	public function getApiPaymentType($paymentType) {

		$pt['code'] = '';
		$pt['conf'] = 'redirect';

		if ($paymentType == 'PC') {
			$pt['code'] = 'yoo_money';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'AC') {
			$pt['code'] = 'bank_card';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'GP') {
			$pt['code'] = 'cash';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'WM') {
			$pt['code'] = 'webmoney';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'SB') {
			$pt['code'] = 'sberbank';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'AB') {
			$pt['code'] = 'alfabank';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'MC') {
			$pt['code'] = 'mobile_balance';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'MP') {
			$pt['code'] = '';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'МА') {
			$pt['code'] = '';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'PB') {
			$pt['code'] = '';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'QW') {
			$pt['code'] = 'qiwi';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'KV') {
			$pt['code'] = '';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'EP') {
			$pt['code'] = '';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'CR') {
			$pt['code'] = 'installments';
			$pt['conf'] = 'redirect';
		}
		if ($paymentType == 'BSB') {
            $pt['code'] = 'b2b_sberbank';
            $pt['conf'] = 'redirect';
        }

		return $pt;

	}

	public function getndscode($nds) {
		$name = '1';

		if ($nds == '0') {
			$name = '2';
		}

		if ($nds == 10) {
			$name = '3';
		}

		if ($nds == 18) {
			$name = '4';
		}

		if ($nds == 110) {
			$name = '5';
		}

		if ($nds == 118) {
			$name = '6';
		}

		return $name;
	}

	public function getCustomFields($order_info, $varabliesd, $paymentcode) {
		$instros = explode('$', $varabliesd);
		$instroz = "";

		if ($order_info['currency_code'] == 'RUB') {
			$currency_code = $order_info['currency_code'];
			$currency_value = $order_info['currency_value'];
		} else {
			$currency_code = 'RUB';
			$currency_value = $this->currency->getValue('RUB');
		}

		if ($this->config->get($paymentcode . '_fixen')) {
			if ($this->config->get($paymentcode . '_fixen') == 'fix') {
				$out_summ = $this->config->get($paymentcode . '_fixen_amount');
			} else {
				$out_summ = $order_info['total'] * $this->config->get($paymentcode . '_fixen_amount') / 100;
			}
		} else {
			$out_summ = $order_info['total'];
		}

		foreach ($instros as $instro) {
			if ($instro == 'href' || $instro == 'orderid' || $instro == 'itogo' || $instro == 'itogobez' || $instro == 'itogozakaz' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis' || $instro == 'totals' || $instro == 'aprovedpayment' || isset($order_info[$instro]) || substr_count($instro, "ordercustom_") || substr_count($instro, "shippingAddresscustom_") || substr_count($instro, "paymentAddresscustom_") || substr_count($instro, "customercustom_") || substr_count($instro, "paymentsimple4_") || substr_count($instro, "shippingsimple4_") || substr_count($instro, "simple4_")) {

				if ($instro == 'href') {
					$instro_other = $order_info['store_url'] . 'index.php?route=account/yandexur' . '&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
				}
				if ($instro == 'orderid') {
					$instro_other = $order_info['order_id'];
				}
				if ($instro == 'itogo') {
					$instro_other = $this->currency->format($out_summ, $currency_code, $currency_value, true);
				}
				if ($instro == 'itogobez') {
					$instro_other = $this->currency->format($out_summ, $currency_code, $currency_value, false);
				}
				if ($instro == 'itogozakaz') {
					$instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
				}
				if ($instro == 'komis') {
					if ($this->config->get($paymentcode . '_komis')) {
						$instro_other = $this->config->get($paymentcode . '_komis') . '%';
					} else { $instro_other = '';}
				}
				if ($instro == 'total-komis') {
					if ($this->config->get($paymentcode . '_komis')) {
						$instro_other = $this->currency->format($out_summ * $this->config->get($paymentcode . '_komis') / 100, $currency_code, $currency_value, true);
					} else { $instro_other = '';}
				}
				if ($instro == 'plus-komis') {
					if ($this->config->get($paymentcode . '_komis')) {
						$instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($paymentcode . '_komis') / 100), $currency_code, $currency_value, true);
					} else { $instro_other = '';}
				}
				if ($instro == 'totals') {
					$instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);
				}

				if (isset($order_info[$instro])) {
					$instro_other = $order_info[$instro];
				}

				if (substr_count($instro, "ordercustom_")) {
					$this->load->model('tool/simplecustom');
					$instro = ltrim($instro, 'order');
					$customx = $this->model_tool_simplecustom->getOrderField($order_info['order_id'], $instro);
					if ($customx) {
						$instro_other = $customx;
					}

				}
				if (substr_count($instro, "shippingAddresscustom_")) {
					$this->load->model('tool/simplecustom');
					$instro = ltrim($instro, 'shippingAddress');
					$customx = $this->model_tool_simplecustom->getShippingAddressField($order_info['order_id'], $instro);
					if ($customx) {
						$instro_other = $customx;
					}
				}
				if (substr_count($instro, "paymentAddresscustom_")) {
					$this->load->model('tool/simplecustom');
					$instro = ltrim($instro, 'shippingAddress');
					$customx = $this->model_tool_simplecustom->getPaymentAddressField($order_info['order_id'], $instro);
					if ($customx) {
						$instro_other = $customx;
					}
				}
				if (substr_count($instro, "customercustom_")) {
					$this->load->model('tool/simplecustom');
					$instro = ltrim($instro, 'customer');
					$customx = $this->model_tool_simplecustom->getCustomerField($order_info['customer_id'], $instro);
					if ($customx) {
						$instro_other = $customx;
					}
				}

				if (substr_count($instro, "paymentsimple4_")) {
					$this->load->model('tool/simplecustom');
					$customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
					$pole = ltrim($instro, 'paymentsimple4');
					$pole = substr($pole, 1);
					if (array_key_exists($pole, $customx) == true) {
						$instro_other = $customx[$pole];
					}
					if (array_key_exists('payment_' . $pole, $customx) == true) {
						$instro_other = $customx['payment_' . $pole];
					}
				}
				if (substr_count($instro, "shippingsimple4_")) {
					$this->load->model('tool/simplecustom');
					$customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
					$pole = ltrim($instro, 'shippingsimple4');
					$pole = substr($pole, 1);
					if (array_key_exists($pole, $customx) == true) {
						$instro_other = $customx[$pole];
					}
					if (array_key_exists('shipping_' . $pole, $customx) == true) {
						$instro_other = $customx['shipping_' . $pole];
					}
				}
				if (substr_count($instro, "simple4_")) {
					$this->load->model('tool/simplecustom');
					$customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
					$pole = ltrim($instro, 'simple4');
					$pole = substr($pole, 1);
					if (array_key_exists($pole, $customx) == true) {
						$instro_other = $customx[$pole];
					}
				}

			} else {
				$instro_other = nl2br(htmlspecialchars_decode($instro));
			}
			$instroz .= $instro_other;
		}
		return $instroz;
	}
}
?>
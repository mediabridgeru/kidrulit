<?php

class ModelModuleEvotor extends Model {

	public function evotorcurlito($order_info, $order_status_id) {
		$kkmfr_postdata = array(
            'order_id' => (int)$order_info['order_id'],
            'order_status_id' => (int)$order_status_id,
            'code' => hash_hmac('sha256', md5($order_info['order_id'].$this->config->get('evotor_license')), $this->config->get('config_encryption')),
          );
          if ( $curl = curl_init() ) {
              curl_setopt($curl, CURLOPT_URL, HTTPS_SERVER . 'index.php?route=module/evotor/rec');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
              curl_setopt($curl, CURLOPT_POST, true);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $kkmfr_postdata);
              curl_setopt($curl, CURLOPT_USERAGENT, 'art&pr-opencart');
              $result = curl_exec($curl);
              curl_close($curl);
          }
          else {
            $this->log->write('Evotor ERROR: No CURL');
          }
	}

	public function addCheck($data) {

		if (isset($data)) {
			foreach ($data as $product) {
				$this->db->query("
					INSERT INTO " . DB_PREFIX . "evotor_receipt SET order_id = '" . (int)$product['order_id'] . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (int)$product['tax'] . "', type = '" . (int)$product['type']. "', receipt_product_number = '" . (int)$product['receipt_product_number']. "', check_id = '" . (int)$product['check_id'] . "' , uuid = '" . $this->db->escape($product['uuid']). "', discount = '" . (float)$product['discount']. "', vat_sum = '" . (float)$product['vat_sum']. "', unit_uuid = '" . $this->db->escape($product['unit_uuid']). "', unit_name = '" . $this->db->escape($product['unit_name']). "', in1 = '" . (int)$product['tag1214'] . "' ");
			}
		}

	}

	public function getCheckProducts($checkid, $type = 0) {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "evotor_receipt where check_id=".(int)$checkid." and type='".(int)$type."' ORDER BY receipt_product_number ASC");
		return $res->rows;
	}

	public function getCheckId($order_id, $type) {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "evotor where order_id=".(int)$order_id." and type='".(int)$type."' ORDER BY id DESC");
		
		if($res->num_rows){
			return $res->row;
		} else {
			$res->row['status'] = false;
			return $res->row;
		}
	}

	public function updCheckId($order_id, $type, $id, $status, $checknum, $returnstatus) {
		$res = $this->db->query("UPDATE " . DB_PREFIX . "evotor SET status=".(int)$status.", date_added=NOW(), return_status='".(int)$returnstatus."', checknum='".(int)$checknum."' where id='".(int)$id." '");
	}

	public function writeCheckId($order_id, $user, $cont, $status, $date, $time = '', $checknum, $pcode, $ElectronicPayment, $Cash, $type) {
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "evotor (order_id, user, email, status, date_created, date_added, checknum, method, electronicpayment, cash, type) values ('".(int)$order_id."','".(int)$user."','".$this->db->escape($cont)."','".(int)$status."','".$date."', NOW(),'".(int)$checknum."','".$this->db->escape($pcode)."','".(float)$ElectronicPayment."','".(float)$Cash."','".(int)$type."')");
			return strval($this->db->getLastId());
		
	}

	public function getCustomName($product_id, $place) {

		$query = $this->db->query("SELECT `".$this->db->escape($place)."` FROM " . DB_PREFIX . "product where product_id='".(int)$product_id."' ");
		if ($query->row){
			return $query->row[$place];
		}

	}

	public function getsystax($tax) {
		$name = 0;

		if ($tax == '1') {
			$name = 'COMMON';
		}

		if ($tax == '6') {
			$name = 'PATENT';
		}

		if ($tax == '2') {
			$name = 'SIMPLIFIED_INCOME';
		}

		if ($tax == '3') {
			$name = 'SIMPLIFIELD_INCOME_OUTCOME';
		}

		if ($tax == '5') {
			$name = 'SINGLE_AGRICULTURE';
		}

		if ($tax == '4') {
			$name = 'SINGLE_IMPUTED_INCOME';
		}

		return $name;
	}

	public function getndsname($nds) {
		$name = 'Без НДС';

		if ($nds == 0) {
			$name = 'НДС 0%';
		}

		if ($nds == 10) {
			$name = 'НДС 10%';
		}

		if ($nds == 18) {
			$name = 'НДС 18%';
		}

		if ($nds == 20) {
			$name = 'НДС 20%';
		}

		if ($nds == 110) {
			$name = 'НДС 10/110';
		}

		if ($nds == 118) {
			$name = 'НДС 18/118';
		}

		return $name;
	}

}


?>
<?php 
class ModelContactsCcrons extends Model {
	public function addNewSend($store_id, $type_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cache_send SET `store_id` = '" . (int)$store_id . "', `send_type` = '" . (int)$type_id . "', date_added = NOW()");
		$send_id = $this->db->getLastId();
		return $send_id;
	}
	
	public function checkFreezeCron($cron_id, $second) {
		$freeze = false;
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "' AND cron_status = '1' ORDER BY date_cronrun DESC LIMIT 1");
	
		if ($query->num_rows) {
			$date_cronrun = strtotime($query->row['date_cronrun']);
			$date_now = strtotime("now");
	
			if (($date_now - $date_cronrun) > $second) {
				$freeze = true;
			}
		}
	
		return $freeze;
	}
	
	public function getCronlimit($limit) {
		$cron_limit = 16;
	
		if ($limit) {
			$result = $limit / 60;
	
			if ($result < 1) {
				$cron_limit = 1;
			} elseif (floor($result) == 1) {
				$cron_limit = 1;
			} elseif (floor($result) == 2) {
				$cron_limit = 2;
			} else {
				$cron_limit = floor($result);
			}
	
			if ($cron_limit > 25) {
				$cron_limit = 25;
			}
		}
		return $cron_limit;
	}
	
	public function setDataNewSend($send_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "contacts_cache_send SET 
		send_to = '" . $this->db->escape($data['send_to']) . "', 
		send_to_data = '" . $this->db->escape($data['send_to_data']) . "', 
		send_region = '" . (int)$data['send_region'] . "', 
		send_country_id = '" . (int)$data['send_country_id'] . "', 
		send_zone_id = '" . (int)$data['send_zone_id'] . "', 
		invers_region = '" . (int)$data['invers_region'] . "', 
		invers_product = '" . (int)$data['invers_product'] . "', 
		invers_category = '" . (int)$data['invers_category'] . "', 
		invers_customer = '" . (int)$data['invers_customer'] . "', 
		invers_client = '" . (int)$data['invers_client'] . "', 
		invers_affiliate = '" . (int)$data['invers_affiliate'] . "', 
		send_products = '" . (int)$data['send_products'] . "', 
		lang_products = '" . (int)$data['lang_products'] . "', 
		language_id = '" . (int)$data['language_id'] . "', 
		subject = '" . $this->db->escape($data['subject']) . "', 
		message = '" . $this->db->escape($data['message']) . "', 
		attachments = '" . $this->db->escape($data['attachments']) . "', 
		attachments_cat = '" . $this->db->escape($data['attachments_cat']) . "', 
		dopurl = '" . $this->db->escape($data['dopurl']) . "', 
		email_total = '" . (int)$data['email_total'] . "', 
		unsub_url = '" . (int)$data['unsub_url'] . "', 
		control_unsub = '" . (int)$data['control_unsub'] . "' 
		WHERE send_id = '" . (int)$send_id . "'";
		
		$query = $this->db->query($sql);
		
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_history SET send_id = '" . (int)$send_id . "' WHERE history_id = '" . (int)$data['history_id'] . "'");
	}
	
	public function setCronNewSend($send_id, $history_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_history SET send_id = '" . (int)$send_id . "' WHERE history_id = '" . (int)$history_id . "'");
	}
	
	public function getCronLastSend($cron_id, $history_id) {
		$query = $this->db->query("SELECT send_id FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "' AND history_id = '" . (int)$history_id . "'");
		if ($query->num_rows) {
			return $query->row['send_id'];
		} else {
			return false;
		}
	}
	
	public function setNewMessageDataCron($send_id, $newmessage) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET newmessage = '" . $this->db->escape($newmessage) . "' WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function delDataSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function saveEmailsToSend($send_id, $emails) {
		foreach ($emails as $email => $data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cache_email SET 
			send_id = '" . (int)$send_id . "', 
			email = '" . $this->db->escape($email) . "', 
			customer_id = '" . (int)$data['customer_id'] . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "', 
			country = '" . $this->db->escape($data['country']) . "', 
			`zone` = '" . $this->db->escape($data['zone']) . "', 
			date_added = '" . $this->db->escape($data['date_added']) . "'");
		}
	}
	
	public function getEmailsToCron($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->rows;
	}
	
	public function saveEmailsToCron($cron_id, $emails) {
		foreach ($emails as $email => $data) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cron_emails SET 
			cron_id = '" . (int)$cron_id . "', 
			email = '" . $this->db->escape($email) . "', 
			customer_id = '" . (int)$data['customer_id'] . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "', 
			country = '" . $this->db->escape($data['country']) . "', 
			`zone` = '" . $this->db->escape($data['zone']) . "', 
			date_added = '" . $this->db->escape($data['date_added']) . "'");
		}
	}
	
	public function delEmailsToCron($cron_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function getEmailsToSend($send_id, $limit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "' LIMIT " . $limit);
		return $query->rows;
	}

	public function getTotalEmailsToSend($send_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT email_id) AS total FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "'");
		return $query->row['total'];
	}
	
	public function removeEmailSend($send_id, $email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "' AND LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	public function addCountMails($send_id = 0, $cron_id = 0, $items = 1) {
		$date = time();
		$day_date = $date - 86400;
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_count_mails WHERE date_send < '" . (int)$day_date . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_count_mails SET send_id = '" . (int)$send_id . "', cron_id = '" . (int)$cron_id . "', items = '" . (int)$items . "', date_send = '" . (int)$date . "'");
	}
	
	public function getCountMails() {
		$totals = array();
		$date = time();
		$hour_date = $date - 3600;
		$day_date = $date - 86400;
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_count_mails WHERE date_send < '" . (int)$day_date . "'");
		
		$tquery = $this->db->query("SELECT COUNT(DISTINCT count_id) AS total FROM " . DB_PREFIX . "contacts_count_mails");
		$totals['day'] = $tquery->row['total'];
		
		$hquery = $this->db->query("SELECT COUNT(DISTINCT count_id) AS total FROM " . DB_PREFIX . "contacts_count_mails WHERE date_send > '" . (int)$hour_date . "'");
		$totals['hour'] = $hquery->row['total'];
		
		return $totals;
	}
	
	public function delNewsletterFromEmail($email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_newsletter WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_emails WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	public function setCheckResult($data) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_emails SET check_status = '" . (int)$data['check_status'] . "', check_text = '" . $this->db->escape($data['check_text']) . "' WHERE cron_id = '" . (int)$data['cron_id'] . "' AND LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "'");
	}
	
	public function addClick($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_clicks SET send_id = '" . (int)$data['send_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', email = '" . $this->db->escape($data['email']) . "', target = '" . $this->db->escape($data['target']) . "', date_added = NOW()");
	}
	
	public function addView($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_views SET send_id = '" . (int)$data['send_id'] . "', customer_id = '" . (int)$data['customer_id'] . "', email = '" . $this->db->escape($data['email']) . "', date_added = NOW()");
	}
	
	public function getDopurl($send_id) {
		$query = $this->db->query("SELECT dopurl FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		if ($query->num_rows) {
			return $query->row['dopurl'];
		} else {
			return false;
		}
	}
	
	public function getDataCron($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_data WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row;
	}
	
	public function getCrons() {
		if ($this->checkLicense()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "contacts_cron WHERE status = '1'";
			$sql .= " ORDER BY cron_id";
			$sql .= " ASC";
			
			$query = $this->db->query($sql);
			return $query->rows;
		} else {
			return array();
		}
	}
	
	public function getCron($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row;
	}
	
	public function getRunCron() {
		$query = $this->db->query("SELECT cron_id FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_status = '1' LIMIT 1");
		if ($query->num_rows) {
			return $query->row['cron_id'];
		} else {
			return false;
		}
	}
	
	public function getRunSend() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_send WHERE send_type = '1' AND `status` = '0' LIMIT 1");
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function setCompleteCronSend($send_id, $email_total = 0) {
		if ($email_total) {
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `status` = '1', email_total = (email_total + " . (int)$email_total . ") WHERE send_id = '" . (int)$send_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `status` = '1' WHERE send_id = '" . (int)$send_id . "'");
		}
	}
	
	public function setPageCron($cron_id, $page) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET step = '" . (int)$page . "' WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function addCronHistory($cron_id) {
		$query = $this->db->query("INSERT " . DB_PREFIX . "contacts_cron_history SET cron_id = '" . (int)$cron_id . "', cron_status = '1', date_cronrun = NOW()");
		$history_id = $this->db->getLastId();
		return $history_id;
	}
	
	public function setCronHistory($history_id, $count_emails = 0) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_history SET count_emails = (count_emails + " . (int)$count_emails . ") WHERE history_id = '" . (int)$history_id . "'");
	}
	
	public function getHistorySend($history_id) {
		$query = $this->db->query("SELECT send_id FROM " . DB_PREFIX . "contacts_cron_history WHERE history_id = '" . (int)$history_id . "'");
		if ($query->num_rows) {
			return $query->row['send_id'];
		} else {
			return false;
		}
	}
	
	public function addLastCronHistory($cron_id, $history_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET history_id = '" . (int)$history_id . "' WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function getLastCronHistory($cron_id) {
		$query = $this->db->query("SELECT history_id FROM " . DB_PREFIX . "contacts_cron WHERE cron_id = '" . (int)$cron_id . "'");
		if ($query->num_rows) {
			return $query->row['history_id'];
		} else {
			return false;
		}
	}
	
	public function stopCron($cron_id, $history_id, $cron_status = 0, $step = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_history SET cron_status = '" . (int)$cron_status . "', date_cronstop = NOW() WHERE history_id = '" . (int)$history_id . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET step = '" . (int)$step . "' WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function otcatCron($cron_id, $date_next, $errors = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET errors = (errors + " . (int)$errors . "), date_next = '" . $this->db->escape($date_next) . "' WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function offCron($cron_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET status = '0', step = '0', history_id = '0' WHERE cron_id = '" . (int)$cron_id . "'");
	}
	
	public function addErrorSend($send_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `errors` = (errors + 1) WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function ClearErrorsSend($send_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `errors` = '0' WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function getErrorsSend($send_id) {
		$query = $this->db->query("SELECT `errors` FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		if ($query->num_rows) {
			return $query->row['errors'];
		} else {
			return false;
		}
	}
	
	public function getCountry($country_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");
		if ($query->num_rows) {
			return $query->row['name'];
		} else {
			return false;
		}
	}
	
	public function getZone($zone_id) {
		$query = $this->db->query("SELECT name FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$zone_id . "'");
		if ($query->num_rows) {
			return $query->row['name'];
		} else {
			return false;
		}
	}
	
	public function getProduct($product_id, $language_id = false, $store_id = null) {
		$time_now = date('Y-m-d H:i') . ':00';
		
		if (!$language_id) {
			$language_id = $this->config->get('config_language_id');
		}

		$sql = "SELECT DISTINCT *, pd.name AS name, p.image, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < '" . $time_now . "') AND (ps.date_end = '0000-00-00' OR ps.date_end > '" . $time_now . "')) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p 
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
	
		if (!is_null($store_id)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
		}
	
		$sql .= " WHERE p.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= '" . $time_now . "'";
	
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
	
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}
	
		$sql .= " AND pd.language_id = '" . (int)$language_id . "'";
	
		if (!is_null($store_id)) {
			$sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
		}
	
		$query = $this->db->query($sql);
		
		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'image'            => $query->row['image'],
				'price'            => $query->row['price'],
				'special'          => $query->row['special'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'rating'           => round($query->row['rating'])
			);
		} else {
			return false;
		}
	}
	
	public function getProductSend($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_product WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->rows;
	}
	
	public function getProductsToSend($cron_id, $type, $language_id = false) {
		$product_data = array();

		$query = $this->db->query("SELECT prod_id FROM " . DB_PREFIX . "contacts_cache_product WHERE cron_id = '" . (int)$cron_id . "' AND type = '" . $this->db->escape($type) . "'");
		
		if ($query->num_rows) {
			$products = explode(',', $query->row['prod_id']);
			if (!empty($products)) {
				foreach ($products as $product_id) {
					$product_info = $this->getProduct($product_id, $language_id);
					if ($product_info) {
						$product_data[$product_id] = $product_info;
					}
				}
			}
		}
		return $product_data;
	}
	
	public function getProductsFromCat($category_id, $limit, $language_id, $store_id) {
		$time_now = date('Y-m-d H:i') . ':00';
		$product_data = array();
		
		$main_category = false;
		
		$mquery = $this->db->query("DESCRIBE `" . DB_PREFIX . "product_to_category`");
		
		foreach ($mquery->rows as $mresult) {
			$fields[] = $mresult['Field'];
		}
		
		if (in_array('main_category', $fields)) {
			$main_category = true;
		}
		
		$sql = "SELECT DISTINCT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c 
		LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE p2c.category_id = '" . (int)$category_id . "'";
	
		if ($main_category) {
			$sql .= " AND p2c.main_category = '1'";
		}
	
		$sql .= " AND p.status = '1' AND p.date_available <= '" . $time_now . "'";
	
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
	
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}
	
		$sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
	
		$sql .= " ORDER BY p.sort_order ASC LIMIT " . (int)$limit;
	
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$product_info = $this->getProduct($result['product_id'], $language_id, $store_id);
			if ($product_info) {
				$product_data[$result['product_id']] = $product_info;
			}
		}
	
		return $product_data;
	}
	
	public function getCatSelectedProducts($category_products, $limit, $language_id, $store_id) {
		$time_now = date('Y-m-d H:i') . ':00';
		$product_data = array();
	
		$implode = array();
		$main_category = false;
	
		if (!empty($category_products)) {
			foreach ($category_products as $category_id) {
				$implode[] = "p2c.category_id = '" . (int)$category_id . "'";
			}
	
			$mquery = $this->db->query("DESCRIBE `" . DB_PREFIX . "product_to_category`");
	
			foreach ($mquery->rows as $mresult) {
				$fields[] = $mresult['Field'];
			}
	
			if (in_array('main_category', $fields)) {
				$main_category = true;
			}
	
			$sql = "SELECT DISTINCT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c 
			LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			WHERE p.status = '1' AND p.date_available <= '" . $time_now . "'";
		
			if ($this->config->get('contacts_skip_price0')) {
				$sql .= " AND p.price > '0'";
			}
	
			if ($this->config->get('contacts_skip_qty0')) {
				$sql .= " AND p.quantity > '0'";
			}
	
			$sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
			
			if ($implode) {
				$sql .= " AND (" . implode(" OR ", $implode) . ")";
	
				if ($main_category) {
					$sql .= " AND p2c.main_category = '1'";
				}
			}
			
			$sql .= " ORDER BY p.sort_order ASC LIMIT " . (int)$limit;

			$query = $this->db->query($sql);
			
			foreach ($query->rows as $result) {
				$product_info = $this->getProduct($result['product_id'], $language_id, $store_id);
				if ($product_info) {
					$product_data[$result['product_id']] = $product_info;
				}
			}
		}
		return $product_data;
	}
	
	public function getFeaturedProducts($limit, $language_id, $store_id) {
		$product_data = array();

		$featured_products = explode(',', $this->config->get('featured_product'));
		$featured_products = array_slice($featured_products, 0, (int)$limit);

		foreach ($featured_products as $product_id) {
			$product_info = $this->getProduct($product_id, $language_id, $store_id);
			if ($product_info) {
				$product_data[$product_id] = $product_info;
			}
		}

		return $product_data;
	}
	
	public function getSpecialsProducts($limit, $language_id, $store_id) {
		$time_now = date('Y-m-d H:i') . ':00';
		$product_data = array();
		
		$sql = "SELECT DISTINCT ps.product_id FROM " . DB_PREFIX . "product_special ps 
		LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE p.status = '1' AND p.date_available <= '" . $time_now . "' 
		AND p2s.store_id = '" . (int)$store_id . "' 
		AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
		AND ((ps.date_start = '0000-00-00' OR ps.date_start < '" . $time_now . "') 
		AND (ps.date_end = '0000-00-00' OR ps.date_end > '" . $time_now . "'))";
		
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
		
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}

		$sql .= " ORDER BY p.sort_order ASC LIMIT " . (int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$product_info = $this->getProduct($result['product_id'], $language_id, $store_id);
			if ($product_info) {
				$product_data[$result['product_id']] = $product_info;
			}
		}
		return $product_data;
	}
	
	public function getBestSellerProducts($limit, $language_id, $store_id) {
		$product_data = array();
		$time_now = date('Y-m-d H:i') . ':00';
		
		$sql = "SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op 
		LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) 
		LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'";
		$sql .= " AND o.store_id = '" . (int)$store_id . "'";
		
		$sql .= " AND p.status = '1' AND p.date_available <= '" . $time_now . "'";
		
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
		
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}
		
		$sql .= " AND p2s.store_id = '" . (int)$store_id . "'";
		
		$sql .= " GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$product_info = $this->getProduct($result['product_id'], $language_id, $store_id);
			if ($product_info) {
				$product_data[$result['product_id']] = $product_info;
			}
		}
		return $product_data;
	}
	
	public function getLatestProducts($limit, $language_id, $store_id) {
		$product_data = array();
		$time_now = date('Y-m-d H:i') . ':00';

		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE p.status = '1' AND p.date_available <= '" . $time_now . "' 
		AND p2s.store_id = '" . (int)$store_id . "'";
		
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
		
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}
		
		$sql .= " ORDER BY p.date_added DESC LIMIT " . (int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$product_info = $this->getProduct($result['product_id'], $language_id, $store_id);
			if ($product_info) {
				$product_data[$result['product_id']] = $product_info;
			}
		}
		return $product_data;
	}
	
	public function getPurchasedsProducts($data) {
		$product_data = array();
		$time_now = date('Y-m-d H:i') . ':00';
	
		$sql = "SELECT op.product_id FROM " . DB_PREFIX . "order_product op 
		LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) 
		LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) 
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
	
		$sql .= " WHERE o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'";
	
		$sql .= " AND o.store_id = '" . (int)$data['store_id'] . "'";
	
		if ($data['customer_id']) {
			$sql .= " AND o.customer_id = '" . (int)$data['customer_id'] . "'";
		} else {
			$sql .= " AND LCASE(o.email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "'";
		}
	
		$sql .= " AND p.status = '1' AND p.date_available <= '" . $time_now . "'";
	
		if ($this->config->get('contacts_skip_price0')) {
			$sql .= " AND p.price > '0'";
		}
	
		if ($this->config->get('contacts_skip_qty0')) {
			$sql .= " AND p.quantity > '0'";
		}
	
		$sql .= " AND p2s.store_id = '" . (int)$data['store_id'] . "'";
	
		$sql .= " GROUP BY op.product_id";
	
		$sort_purchased_first = $this->config->get('contacts_sort_purchased_first') ? $this->config->get('contacts_sort_purchased_first') : 'DESC';
		$sort_purchased_last = $this->config->get('contacts_sort_purchased_last') ? $this->config->get('contacts_sort_purchased_last') : 'DESC';
	
		$sql .= " ORDER BY DATE(o.date_added) " . $sort_purchased_first . ", p.price " . $sort_purchased_last;
	
		$sql .= " LIMIT " . (int)$data['limit'];
	
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$product_info = $this->getProduct($result['product_id'], $data['language_id'], $data['store_id']);
			if ($product_info) {
				$product_data[$result['product_id']] = $product_info;
			}
		}
		return $product_data;
	}
	
	public function getEmailCustomers($data = array()) {
		if ($this->checkLicense()) {
			$customers = array();
	
			$sql = "SELECT DISTINCT c.email, c.customer_id, c.firstname, c.lastname, c.date_added, cy.name AS country, zn.name AS zone FROM " . DB_PREFIX . "customer c";
			
			if (!empty($data['filter_noorder'])) {
				$sql .= " LEFT JOIN (SELECT DISTINCT c2.customer_id FROM " . DB_PREFIX . "customer c2 INNER JOIN `" . DB_PREFIX . "order` o ON (c2.customer_id = o.customer_id) WHERE o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'";
	
				if (!empty($data['filter_store_id'])) {
					$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
				}
	
				$sql .= ") n2 ON (c.customer_id = n2.customer_id)";
			}
			
			$sql .= " LEFT JOIN " . DB_PREFIX . "address ad ON (c.customer_id = ad.customer_id)";
			$sql .= " LEFT JOIN " . DB_PREFIX . "country cy ON (ad.country_id = cy.country_id)";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` zn ON (ad.zone_id = zn.zone_id)";
			$sql .= " WHERE c.status = '1' AND c.email <> ''";
			
			if (!empty($data['filter_newsletter']) || !empty($data['filter_unsubscribe'])) {
				$sql .= " AND c.newsletter = '1'";
			}
			
			if (!empty($data['filter_customer_group_id']) && is_array($data['filter_customer_group_id'])) {
				$gimplode = array();
				
				foreach ($data['filter_customer_group_id'] as $customer_group_id) {
					$gimplode[] = (int)$customer_group_id;
				}
			
				if ($gimplode) {
					$sql .= " AND c.customer_group_id IN (" . implode(", ", $gimplode) . ")";
				}
			}
			
			if (!empty($data['filter_customer_id']) && is_array($data['filter_customer_id'])) {
				$cimplode = array();
				
				foreach ($data['filter_customer_id'] as $customer_id) {
					$cimplode[] = (int)$customer_id;
				}
				
				if ($cimplode) {
					if (!empty($data['invers_customer'])) {
						$sql .= " AND c.customer_id NOT IN (" . implode(", ", $cimplode) . ")";
					} else {
						$sql .= " AND c.customer_id IN (" . implode(", ", $cimplode) . ")";
					}
				}
			}
			
			if (!empty($data['filter_store_id'])) {
				$sql .= " AND c.store_id = '" . (int)$data['filter_store_id'] . "'";
			}
	
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(c.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(c.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
			}
			
			if (!empty($data['filter_noorder'])) {
				$sql .= " AND n2.customer_id IS NULL";
			}
			
			if (!empty($data['invers_region'])) {
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND ad.zone_id <> '" . (int)$data['filter_zone_id'] . "'";
				} elseif (!empty($data['filter_country_id'])) {
					$sql .= " AND ad.country_id <> '" . (int)$data['filter_country_id'] . "'";
				}
			} else {
				if (!empty($data['filter_country_id'])) {
					$sql .= " AND ad.country_id = '" . (int)$data['filter_country_id'] . "'";
				}
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND ad.zone_id = '" . (int)$data['filter_zone_id'] . "'";
				}
			}
			
			$query = $this->db->query($sql);
	
			if ($query->num_rows) {
				$customers = $query->rows;
			}
	
			if ($customers) {
				if (!empty($data['filter_start']) && ((int)$data['filter_start'] > 0)) {
					$filter_start = (int)$data['filter_start'];
				} else {
					$filter_start = 0;
				}
	
				if (!empty($data['filter_limit']) && ((int)$data['filter_limit'] > $filter_start)) {
					$filter_limit = (int)$data['filter_limit'] - (int)$filter_start;
				} elseif (!empty($data['filter_limit']) && ((int)$data['filter_limit'] <= $filter_start)) {
					$filter_limit = 1;
				} else {
					$filter_limit = count($customers);
				}
	
				$customers = array_slice($customers, $filter_start, $filter_limit);
			}
	
			return $customers;
		} else {
			return array();
		}
	}
	
	public function getEmailsByOrdereds($data = array()) {
		if ($this->checkLicense()) {
			$mails = array();
			$main_category = false;
	
			if (isset($data['filter_category'])) {
				$mquery = $this->db->query("DESCRIBE `" . DB_PREFIX . "product_to_category`");
				
				foreach ($mquery->rows as $mresult) {
					$fields[] = $mresult['Field'];
				}
				if (in_array('main_category', $fields)) {
					$main_category = true;
				}
			}
			
			$sql = "SELECT DISTINCT o.email, c.customer_id, o.firstname, o.lastname, c.date_added, o.shipping_country AS country, o.shipping_zone AS zone FROM `" . DB_PREFIX . "order` o";
			$sql .= " LEFT JOIN " . DB_PREFIX . "customer c ON (o.customer_id = c.customer_id)";
			
			$pimplode = array();
			if (!empty($data['filter_products']) && is_array($data['filter_products'])) {
				foreach ($data['filter_products'] as $product_id) {
					$pimplode[] = (int)$product_id;
				}
				
				if ($pimplode) {
					if (!empty($data['invers_product'])) {
						$sql .= " LEFT JOIN (SELECT DISTINCT o2.email FROM `" . DB_PREFIX . "order` o2 INNER JOIN " . DB_PREFIX . "order_product op2 ON (o2.order_id = op2.order_id) WHERE op2.product_id IN (" . implode(", ", $pimplode) . ")) e2 ON (o.email = e2.email)";
					} else {
						$sql .= " INNER JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id)";
					}
				}
			}
			
			$cpimplode = array();
			if (!empty($data['filter_category']) && is_array($data['filter_category'])) {
				foreach ($data['filter_category'] as $category_id) {
					$cpimplode[] = (int)$category_id;
				}
				
				if ($cpimplode) {
					if (!empty($data['invers_category'])) {
						$sql .= " LEFT JOIN (SELECT DISTINCT o2.email FROM `" . DB_PREFIX . "order` o2";
						$sql .= " INNER JOIN " . DB_PREFIX . "order_product op ON (o2.order_id = op.order_id)";
						$sql .= " INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (op.product_id = p2c.product_id) WHERE p2c.category_id IN (" . implode(", ", $cpimplode) . ")";
						if ($main_category) {
							$sql .= " AND p2c.main_category = '1'";
						}
						$sql .= ") e2 ON (o.email = e2.email)";
					} else {
						$sql .= " INNER JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id)";
						$sql .= " INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (op.product_id = p2c.product_id)";
					}
				}
			}
			
			if ($this->config->get('contacts_client_status')) {
				$sql .= " WHERE o.order_status_id > '0'";
			} else {
				$sql .= " WHERE o.order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'";
			}
			
			if (!empty($data['filter_store_id'])) {
				$sql .= " AND o.store_id = '" . (int)$data['filter_store_id'] . "'";
			}
			
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
			}
			
			if (!empty($data['filter_client']) && is_array($data['filter_client'])) {
				$cimplode = array();
				if (!empty($data['invers_client'])) {
					$cimplode[] = "o.email <> ''";
					foreach ($data['filter_client'] as $email) {
						$cimplode[] = "LCASE(o.email) <> '" . $this->db->escape(utf8_strtolower($email)) . "'";
					}
					if ($cimplode) {
						$sql .= " AND (" . implode(" AND ", $cimplode) . ")";
					}
				} else {
					foreach ($data['filter_client'] as $email) {
						$cimplode[] = "LCASE(o.email) = '" . $this->db->escape(utf8_strtolower($email)) . "'";
					}
					if ($cimplode) {
						$sql .= " AND (" . implode(" OR ", $cimplode) . ")";
					}
				}
			} else {
				$sql .= " AND o.email <> ''";
			}
			
			if (!empty($data['invers_region'])) {
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND o.shipping_zone_id <> '" . (int)$data['filter_zone_id'] . "'";
				} elseif (!empty($data['filter_country_id'])) {
					$sql .= " AND o.shipping_country_id <> '" . (int)$data['filter_country_id'] . "'";
				}
			} else {
				if (!empty($data['filter_country_id'])) {
					$sql .= " AND o.shipping_country_id = '" . (int)$data['filter_country_id'] . "'";
				}
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND o.shipping_zone_id = '" . (int)$data['filter_zone_id'] . "'";
				}
			}
			
			if (!empty($data['filter_language_id'])) {
				$sql .= " AND o.language_id = '" . (int)$data['filter_language_id'] . "'";
			}
			
			if (!empty($data['filter_customer_group_id']) && is_array($data['filter_customer_group_id'])) {
				$gimplode = array();
				
				foreach ($data['filter_customer_group_id'] as $customer_group_id) {
					$gimplode[] = (int)$customer_group_id;
				}
			
				if ($gimplode) {
					$sql .= " AND c.customer_group_id IN (" . implode(", ", $gimplode) . ")";
				}
			}
			
			if ($pimplode) {
				if (!empty($data['invers_product'])) {
					$sql .= " AND e2.email IS NULL";
				} else {
					$sql .= " AND op.product_id IN (" . implode(", ", $pimplode) . ")";
				}
			}
			
			if ($cpimplode) {
				if (!empty($data['invers_category'])) {
					$sql .= " AND e2.email IS NULL";
				} else {
					$sql .= " AND p2c.category_id IN (" . implode(", ", $cpimplode) . ")";
					if ($main_category) {
						$sql .= " AND p2c.main_category = '1'";
					}
				}
			}
			
			$query = $this->db->query($sql);
	
			if ($query->num_rows) {
				$mails = $query->rows;
			}
	
			if ($mails) {
				if (!empty($data['filter_start']) && ((int)$data['filter_start'] > 0)) {
					$filter_start = (int)$data['filter_start'];
				} else {
					$filter_start = 0;
				}
	
				if (!empty($data['filter_limit']) && ((int)$data['filter_limit'] > $filter_start)) {
					$filter_limit = (int)$data['filter_limit'] - (int)$filter_start;
				} elseif (!empty($data['filter_limit']) && ((int)$data['filter_limit'] <= $filter_start)) {
					$filter_limit = 1;
				} else {
					$filter_limit = count($mails);
				}
	
				$mails = array_slice($mails, $filter_start, $filter_limit);
			}
	
			return $mails;
		} else {
			return array();
		}
	}
	
	public function addUnsubscribe($email, $send_id = 0, $customer_id = 0) {
		$query = $this->db->query("SELECT unsubscribe_id FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' LIMIT 1");
		if ($query->num_rows) {
			$unsubscribe_id = $query->row['unsubscribe_id'];
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_newsletter SET unsubscribe_id = '" . (int)$unsubscribe_id . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_unsubscribe SET send_id = '" . (int)$send_id . "', customer_id = '" . (int)$customer_id . "', email = '" . $this->db->escape(utf8_strtolower($email)) . "', date_added = NOW()");
			$unsubscribe_id = $this->db->getLastId();
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_newsletter SET unsubscribe_id = '" . (int)$unsubscribe_id . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		}

		if ($customer_id > 0) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '0' WHERE customer_id = '" . (int)$customer_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '0' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		}
	}
	
	public function checkEmailUnsubscribe($email) {
		$check = false;
		$query = $this->db->query("SELECT unsubscribe_id FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' LIMIT 1");
		if ($query->num_rows) {
			$check = true;
		}
		return $check;
	}
	
	public function checkCustomerNewsletter($customer_id) {
		$check = false;
		$query = $this->db->query("SELECT newsletter FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' LIMIT 1");
		if ($query->num_rows) {
			if ($query->row['newsletter'] == 1) {
				$check = true;
			}
		}
		return $check;
	}
	
	public function getCustomerData($customer_id) {
		$sql = "SELECT DISTINCT c.email, c.customer_id, c.firstname, c.lastname, c.date_added, cy.name AS country, zn.name AS zone FROM " . DB_PREFIX . "customer c";
		$sql .= " LEFT JOIN " . DB_PREFIX . "address ad ON (c.customer_id = ad.customer_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country cy ON (ad.country_id = cy.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` zn ON (ad.zone_id = zn.zone_id)";
		$sql .= " WHERE c.customer_id = '" . (int)$customer_id . "' AND c.email <> ''";

		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getNewsletters($data = array()) {
		if ($this->checkLicense()) {
			$newsletters = array();
	
			$sql = "SELECT DISTINCT(cn.newsletter_id), cn.unsubscribe_id, cn.customer_id, cn.email AS cemail, cn.firstname AS nfirstname, cn.lastname AS nlastname, CONCAT(cn.firstname, ' ', cn.lastname) AS nname, c.newsletter, c.firstname, c.lastname, CONCAT(c.firstname, ' ', c.lastname) AS cname, cgd.name AS customer_group, cgp.name AS cgroup FROM " . DB_PREFIX . "contacts_newsletter cn";
			$sql .= " LEFT JOIN " . DB_PREFIX . "contacts_group cgp ON (cn.group_id = cgp.group_id)";
			$sql .= " LEFT JOIN " . DB_PREFIX . "customer c ON (cn.customer_id = c.customer_id)";
			$sql .= " LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id)";
			$sql .= " WHERE cn.email <> ''";
			
			$implode = array();
			
			if (!empty($data['filter_name'])) {
				$implode[] = "CONCAT(cn.firstname, ' ', cn.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}
			
			if (!empty($data['filter_email'])) {
				$implode[] = "cn.email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
			}
			
			if ($implode) {
				$sql .= " AND " . implode(" OR ", $implode);
			}
			
			if (!empty($data['filter_group_id'])) {
				if (is_array($data['filter_group_id'])) {
					$gimplode = array();
					
					foreach ($data['filter_group_id'] as $group_id) {
						$gimplode[] = "cn.group_id = '" . (int)$group_id . "'";
					}
				
					if ($gimplode) {
						$sql .= " AND (" . implode(" OR ", $gimplode) . ")";
					}
				} else {
					$sql .= " AND cn.group_id = '" . (int)$data['filter_group_id'] . "'";
				}
			}

			if (!empty($data['filter_customer_group_id'])) {
				$sql .= " AND c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
			}
			
			if (isset($data['filter_unsubscribe']) && !is_null($data['filter_unsubscribe']) && ($data['filter_unsubscribe'] == '0')) {
				$sql .= " AND cn.unsubscribe_id > '0'";
			}
			
			if (isset($data['filter_unsubscribe']) && !is_null($data['filter_unsubscribe']) && ($data['filter_unsubscribe'] == '1')) {
				$sql .= " AND cn.unsubscribe_id = '0'";
			}
			
			$sql .= " AND (cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' OR cgd.language_id IS null)";
			
			$sort_data = array(
				'cname',
				'cemail',
				'customer_group',
				'cgroup'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY cemail";
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}			

				if ($data['limit'] < 1) {
					$data['limit'] = 10;
				}	
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$query = $this->db->query($sql);
	
			if ($query->num_rows) {
				$newsletters = $query->rows;
			}
	
			if ($newsletters) {
				if (!empty($data['filter_start']) && ((int)$data['filter_start'] > 0)) {
					$filter_start = $data['filter_start'];
				} else {
					$filter_start = 0;
				}
	
				if (!empty($data['filter_limit']) && ((int)$data['filter_limit'] > $filter_start)) {
					$filter_limit = (int)$data['filter_limit'] - (int)$filter_start;
				} elseif (!empty($data['filter_limit']) && ((int)$data['filter_limit'] <= $filter_start)) {
					$filter_limit = 1;
				} else {
					$filter_limit = count($newsletters);
				}
	
				$newsletters = array_slice($newsletters, $filter_start, $filter_limit);
			}
	
			return $newsletters;
		} else {
			return array();
		}
	}
	
	public function getEmailAffiliates($data = array()) {
		if ($this->checkLicense()) {
			$affiliates = array();
	
			$sql = "SELECT DISTINCT af.email, af.firstname, af.lastname, cy.name AS country, zn.name AS zone FROM " . DB_PREFIX . "affiliate af";
			$sql .= " LEFT JOIN " . DB_PREFIX . "country cy ON (af.country_id = cy.country_id)";
			$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` zn ON (af.zone_id = zn.zone_id)";
			$sql .= " WHERE af.email <> ''";
			
			if (!empty($data['filter_affiliate_id']) && is_array($data['filter_affiliate_id'])) {
				$aimplode = array();
				
				if (!empty($data['invers_affiliate'])) {
					foreach ($data['filter_affiliate_id'] as $affiliate_id) {
						$aimplode[] = (int)$affiliate_id;
					}
					if ($aimplode) {
						$sql .= " AND af.affiliate_id NOT IN (" . implode(", ", $aimplode) . ")";
					}
				} else {
					foreach ($data['filter_affiliate_id'] as $affiliate_id) {
						$aimplode[] = (int)$affiliate_id;
					}
					if ($aimplode) {
						$sql .= " AND af.affiliate_id IN (" . implode(", ", $aimplode) . ")";
					}
				}
			}
			
			if (!empty($data['invers_region'])) {
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND af.zone_id <> '" . (int)$data['filter_zone_id'] . "'";
				} elseif (!empty($data['filter_country_id'])) {
					$sql .= " AND af.country_id <> '" . (int)$data['filter_country_id'] . "'";
				}
			} else {
				if (!empty($data['filter_country_id'])) {
					$sql .= " AND af.country_id = '" . (int)$data['filter_country_id'] . "'";
				}
				if (!empty($data['filter_zone_id'])) {
					$sql .= " AND af.zone_id = '" . (int)$data['filter_zone_id'] . "'";
				}
			}
			
			if (!empty($data['filter_date_start'])) {
				$sql .= " AND DATE(af.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
			}
			
			if (!empty($data['filter_date_end'])) {
				$sql .= " AND DATE(af.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
			}
			
			$query = $this->db->query($sql);
	
			if ($query->num_rows) {
				$affiliates = $query->rows;
			}
	
			if ($affiliates) {
				if (!empty($data['filter_start']) && ((int)$data['filter_start'] > 0)) {
					$filter_start = (int)$data['filter_start'];
				} else {
					$filter_start = 0;
				}

				if (!empty($data['filter_limit']) && ((int)$data['filter_limit'] > $filter_start)) {
					$filter_limit = (int)$data['filter_limit'] - (int)$filter_start;
				} elseif (!empty($data['filter_limit']) && ((int)$data['filter_limit'] <= $filter_start)) {
					$filter_limit = 1;
				} else {
					$filter_limit = count($affiliates);
				}

				$affiliates = array_slice($affiliates, $filter_start, $filter_limit);
			}

			return $affiliates;
		} else {
			return array();
		}
	}

	public function getAffiliateData($affiliate_id) {
		$sql = "SELECT DISTINCT af.email, af.firstname, af.lastname, cy.name AS country, zn.name AS zone FROM " . DB_PREFIX . "affiliate af";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country cy ON (af.country_id = cy.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` zn ON (af.zone_id = zn.zone_id)";
		$sql .= " WHERE af.affiliate_id = '" . (int)$affiliate_id . "' AND af.email <> ''";
		
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function checkLicense() {
		$lic = 1;
		return $lic;
	}
	
	public function getShopStore($store_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");
		return $query->row;
	}
}
?>
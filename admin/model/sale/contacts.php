<?php 
class ModelSaleContacts extends Model {
	public function addSendGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_group SET `name` = '" . $this->db->escape($data['name']) . "', `description` = '" . $this->db->escape($data['description']) . "'");
		$group_id = $this->db->getLastId();
		return $group_id;
	}
	
	public function editSendGroup($group_id, $data) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "contacts_group SET `name` = '" . $this->db->escape($data['name']) . "', `description` = '" . $this->db->escape($data['description']) . "' WHERE `group_id` = '" . (int)$group_id . "'");
	}
	
	public function getSendGroup($group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_group WHERE `group_id` = '" . (int)$group_id . "'");
		return $query->row;
	}
	
	public function getSendGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contacts_group";
		
		$sort_data = array(
			'name',
			'group_id'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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
		return $query->rows;
	}
	
	public function getTotalSendGroups() {
		$query = $this->db->query("SELECT COUNT(group_id) AS total FROM " . DB_PREFIX . "contacts_group");
		return $query->row['total'];
	}
	
	public function delSendGroup($group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_group WHERE `group_id` = '" . (int)$group_id . "'");
	}

	public function addNewsletters($group_id, $emails, $move = false) {
		$totals = 0;
		if ($this->checkLicense()) {
			foreach ($emails as $data) {
				$unsubscribe_id = 0;
				
				if ($data['customer_id'] > 0) {
					$cquery = $this->db->query("SELECT `newsletter` FROM " . DB_PREFIX . "customer WHERE `customer_id` = '" . (int)$data['customer_id'] . "' LIMIT 1");
					if ($cquery->num_rows) {
						if ($cquery->row['newsletter'] == '1') {
							$uquery = $this->db->query("SELECT `unsubscribe_id` FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "' LIMIT 1");
							if ($uquery->num_rows) {
								$unsubscribe_id = $uquery->row['unsubscribe_id'];
							}
						} else {
							$uquery = $this->db->query("SELECT `unsubscribe_id` FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "' LIMIT 1");
							if ($uquery->num_rows) {
								$unsubscribe_id = $uquery->row['unsubscribe_id'];
							} else {
								$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_unsubscribe SET send_id = '0', customer_id = '" . (int)$data['customer_id'] . "', `email` = '" . $this->db->escape(utf8_strtolower($data['email'])) . "', date_added = NOW()");
								$unsubscribe_id = $this->db->getLastId();
							}
						}
					}
				} else {
					$uquery = $this->db->query("SELECT `unsubscribe_id` FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "' LIMIT 1");
					if ($uquery->num_rows) {
						$unsubscribe_id = $uquery->row['unsubscribe_id'];
					}
				}
				
				if ($move) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_newsletter WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "'");
				}

				$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_newsletter SET `group_id` = '" . (int)$group_id . "', `customer_id` = '" . (int)$data['customer_id'] . "', `unsubscribe_id` = '" . (int)$unsubscribe_id . "', `email` = '" . $this->db->escape(utf8_strtolower($data['email'])) . "', `firstname` = '" . $this->db->escape($data['firstname']) . "', `lastname` = '" . $this->db->escape($data['lastname']) . "'");
				
				$totals++;
			}
		}
		return $totals;
	}
	
	public function movedNewsletters($group_id, $data = array()) {
		if ($data) {
			$exist_emails = $this->getEmailsNewslettersFromGroup($group_id);
			
			foreach ($data as $newsletter_id) {
				$newsletter_info = $this->getNewsletter($newsletter_id);
				
				if ($newsletter_info) {
					if(!in_array($newsletter_info['email'], $exist_emails)) {
						$this->db->query("UPDATE " . DB_PREFIX . "contacts_newsletter SET `group_id` = '" . (int)$group_id . "' WHERE `newsletter_id` = '" . (int)$newsletter_id . "'");
					} else {
						if($newsletter_info['group_id'] != $group_id) {
							$this->delNewsletter($newsletter_id);
						}
					}
				}
			}
		}
	}
	
	public function addNewsletter($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_newsletter SET 
		`group_id` = '" . (int)$data['group_id'] . "', 
		`customer_id` = '" . (int)$data['customer_id'] . "', 
		`unsubscribe_id` = '" . (int)$data['unsubscribe_id'] . "', 
		`email` = '" . $this->db->escape(utf8_strtolower($data['email'])) . "'");
		
		$newsletter_id = $this->db->getLastId();
		return $newsletter_id;
	}
	
	public function editNewsletter($newsletter_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_newsletter SET 
		`group_id` = '" . (int)$data['group_id'] . "', 
		`customer_id` = '" . (int)$data['customer_id'] . "', 
		`unsubscribe_id` = '" . (int)$data['unsubscribe_id'] . "', 
		`email` = '" . $this->db->escape(utf8_strtolower($data['email'])) . "' WHERE `newsletter_id` = '" . (int)$newsletter_id . "'");
	}
	
	public function delNewsletter($newsletter_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_newsletter WHERE `newsletter_id` = '" . (int)$newsletter_id . "'");
	}
	
	public function delNewsletterFromEmail($email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_newsletter WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_emails WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	public function getNewsletter($newsletter_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_newsletter WHERE `newsletter_id` = '" . (int)$newsletter_id . "'");
		return $query->row;
	}
	
	public function getNewslettersFromEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_newsletter WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		return $query->rows;
	}
	
	public function getNewslettersFromGroup($group_id) {
		$query = $this->db->query("SELECT newsletter_id FROM " . DB_PREFIX . "contacts_newsletter WHERE `group_id` = '" . (int)$group_id . "' ORDER BY `email` ASC");
		return $query->rows;
	}
	
	public function getEmailsNewslettersFromGroup($group_id) {
		$emails = array();
		$query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "contacts_newsletter WHERE `group_id` = '" . (int)$group_id . "'");
		
		if ($query->num_rows) {
			foreach ($query->rows as $email) {
				$emails[] = $email['email'];
			}
		}
		return $emails;
	}
	
	public function getEmailsFromSqlManual($data = array()) {
		$results = array();
		if ($this->checkLicense()) {
			if ($data && !empty($data['sql_table']) && !empty($data['sql_col_email'])) {
				$table = DB_PREFIX . $data['sql_table'];

				$check_table = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "` LIKE '" . $table . "'");

				if($check_table->num_rows > 0) {
					$check_column = $this->db->query("DESCRIBE `" . $table . "`");

					foreach ($check_column->rows as $result) {
						$fields[] = $result['Field'];
					}
					
					if (in_array($data['sql_col_email'], $fields)) {
						$sql = "SELECT `" . $data['sql_col_email'] . "` AS email";
						
						if (in_array($data['sql_col_firstname'], $fields)) {
							$sql .= ", `" . $data['sql_col_firstname'] . "` AS firstname";
						}
						if (in_array($data['sql_col_lastname'], $fields)) {
							$sql .= ", `" . $data['sql_col_lastname'] . "` AS lastname";
						}
						
						$sql .= " FROM `" . $table . "`";
						
						$query = $this->db->query($sql);
						
						if ($query->num_rows) {
							$results = $query->rows;
						}
	
						if ($results) {
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
								$filter_limit = count($results);
							}
	
							$results = array_slice($results, $filter_start, $filter_limit);
						}
					}
				}
			}
		}
		return $results;
	}
	
	public function getTotalNewslettersFromGroup($group_id) {
		$query = $this->db->query("SELECT COUNT(newsletter_id) AS total FROM " . DB_PREFIX . "contacts_newsletter WHERE `group_id` = '" . (int)$group_id . "'");
		return $query->row['total'];
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
	
	public function getTotalNewsletters($data = array()) {
		$sql = "SELECT COUNT(cn.newsletter_id) AS total FROM " . DB_PREFIX . "contacts_newsletter cn";
		$sql .= " LEFT JOIN " . DB_PREFIX . "customer c ON (cn.customer_id = c.customer_id)";
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
		
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function addNewCron($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cron SET name = '" . $this->db->escape($data['name']) . "', checking = '" . (int)$data['checking'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
		$cron_id = $this->db->getLastId();
		return $cron_id;
	}
	
	public function addDataCron($cron_id, $data) {
		if ($this->checkLicense()) {
			$sql = "INSERT INTO " . DB_PREFIX . "contacts_cron_data SET cron_id = '" . (int)$cron_id . "', 
			send_to = '" . $this->db->escape($data['send_to']) . "', 
			send_to_data = '" . $this->db->escape($data['send_to_data']) . "', 
			date_start = '" . $this->db->escape($data['date_start']) . "', 
			date_end = '" . $this->db->escape($data['date_end']) . "', 
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
			`static` = '" . $this->db->escape($data['static']) . "', 
			email_total = '" . (int)$data['email_total'] . "', 
			unsub_url = '" . (int)$data['unsub_url'] . "', 
			limit_start = '" . (int)$data['limit_start'] . "', 
			limit_end = '" . (int)$data['limit_end'] . "', 
			control_unsub = '" . (int)$data['control_unsub'] . "'";
			
			if (isset($data['emnovalid_action'])) {
				$sql .= ", emnovalid_action = '" . (int)$data['emnovalid_action'] . "', embad_action = '" . (int)$data['embad_action'] . "', emsuspect_action = '" . (int)$data['emsuspect_action'] . "'";
			}
			
			$query = $this->db->query($sql);
		}
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
	
	public function getCrons($data = array()) {
		if ($this->checkLicense()) {
			$sql = "SELECT * FROM " . DB_PREFIX . "contacts_cron";
			
			$sort_data = array(
				'name',
				'cron_id'
			);
			
			if (isset($data['checking']) && ($data['checking'])) {
				$sql .= " WHERE checking = '1'";
			}
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY cron_id";	
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
			return $query->rows;
		} else {
			return array();
		}
	}
	
	public function getTotalCrons() {
		$query = $this->db->query("SELECT COUNT(cron_id) AS total FROM " . DB_PREFIX . "contacts_cron");
		return $query->row['total'];
	}
	
	public function getCron($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row;
	}
	
	public function getDataCron($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_data WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row;
	}
	
	public function getCheckCronResult($cron_id) {
		$good = $this->db->query("SELECT COUNT(email) AS total FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "' AND check_status = '1'");
		$novalid = $this->db->query("SELECT COUNT(email) AS total FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "' AND check_status = '2'");
		$bad = $this->db->query("SELECT COUNT(email) AS total FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "' AND check_status = '3'");
		$suspect = $this->db->query("SELECT COUNT(email) AS total FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "' AND check_status = '4'");
		
		$results = array(
			'good'    => $good->row['total'],
			'novalid' => $novalid->row['total'],
			'bad'     => $bad->row['total'],
			'suspect' => $suspect->row['total']
		);
		
		return $results;
	}
	
	public function getCheckCronResultEmails($cron_id, $data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "'";
		
		if (!empty($data['check_status'])) {
			$sql .= " AND check_status = '" . (int)$data['check_status'] . "'";
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getRunCron() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_status = '1'");
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function editCron($cron_id, $data) {
		if ($this->checkLicense()) {
			$query = $this->db->query("SELECT history_id FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "' ORDER BY history_id DESC LIMIT 1");
			if ($query->num_rows) {
				$history_id = $query->row['history_id'];
				$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_history SET cron_status = '0' WHERE history_id = '" . (int)$history_id . "'");
			}
			if (!$data['status']) {
				$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET name = '" . $this->db->escape($data['name']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_next = NULL, period = '" . (int)$data['period'] . "', step = '0', status = '" . (int)$data['status'] . "' WHERE cron_id = '" . (int)$cron_id . "'");
			} else {
				$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron SET name = '" . $this->db->escape($data['name']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_next = NULL, period = '" . (int)$data['period'] . "', status = '" . (int)$data['status'] . "' WHERE cron_id = '" . (int)$cron_id . "'");
			}
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_cron_data SET subject = '" . $this->db->escape($data['subject']) . "', message = '" . $this->db->escape($data['message']) . "' WHERE cron_id = '" . (int)$cron_id . "'");
		}
	}
	
	public function delCron($cron_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron WHERE cron_id = '" . (int)$cron_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_data WHERE cron_id = '" . (int)$cron_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cron_emails WHERE cron_id = '" . (int)$cron_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_product WHERE cron_id = '" . (int)$cron_id . "'");

		$files = glob(DIR_LOGS . 'ccron.' . preg_replace('/[^0-9]/i', '', $cron_id) . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);
				}
    		}
		}
	}
	
	public function getCronLogs($cron_id) {
		$cron_logs = array();
		$files = glob(DIR_LOGS . 'ccron.' . preg_replace('/[^0-9]/i', '', $cron_id) . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					$cron_logs[] = $file;
				}
    		}
		}
		return $cron_logs;
	}
	
	public function getCronCount($cron_id) {
		$query = $this->db->query("SELECT COUNT(history_id) AS total FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row['total'];
	}
	
	public function getCronStatus($cron_id) {
		$query = $this->db->query("SELECT cron_status FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "' ORDER BY history_id DESC LIMIT 1");
		if ($query->num_rows) {
			return $query->row['cron_status'];
		} else {
			return false;
		}
	}
	
	public function getCronSendEmailTotal($cron_id) {
		$query = $this->db->query("SELECT SUM(count_emails) AS total FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->row['total'];
	}
	
	public function getCronHistory($history_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_history WHERE history_id = '" . (int)$history_id . "'");
		return $query->row;
	}
	
	public function getCronHistories($cron_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cron_history WHERE cron_id = '" . (int)$cron_id . "'");
		return $query->rows;
	}

	public function addNewSend($store_id, $type_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cache_send SET `store_id` = '" . (int)$store_id . "', `send_type` = '" . (int)$type_id . "', date_added = NOW()");
		$send_id = $this->db->getLastId();
		return $send_id;
	}
	
	public function setDataNewSend($send_id, $data) {
		if ($this->checkLicense()) {
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
		}
	}
	
	public function setNewMessageDataSend($send_id, $newmessage) {
		$sql = "UPDATE " . DB_PREFIX . "contacts_cache_send SET newmessage = '" . $this->db->escape($newmessage) . "' WHERE send_id = '" . (int)$send_id . "'";
		$query = $this->db->query($sql);
	}
	
	public function getMissingDataSend() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_send WHERE send_type = '1' AND `status` = '0'");
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function getDataSend($send_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		return $query->row;
	}
	
	public function getMessageSend($send_id) {
		$query = $this->db->query("SELECT `message` FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		if ($query->num_rows) {
			return $query->row['message'];
		} else {
			return false;
		}
	}
	
	public function getNewMessageSend($send_id) {
		$query = $this->db->query("SELECT `newmessage` FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		if ($query->num_rows) {
			return $query->row['newmessage'];
		} else {
			return false;
		}
	}
	
	public function getErrorsSend($send_id) {
		$query = $this->db->query("SELECT `errors` FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		if ($query->num_rows) {
			return $query->row['errors'];
		} else {
			return false;
		}
	}
	
	public function addErrorSend($send_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `errors` = (errors + 1) WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function ClearErrorsSend($send_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `errors` = '0' WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function delDataSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_send WHERE send_id = '" . (int)$send_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_product WHERE send_id = '" . (int)$send_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_views WHERE send_id = '" . (int)$send_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_clicks WHERE send_id = '" . (int)$send_id . "'");
	}
	
	public function setCompleteDataSend($send_id, $email_total = 0) {
		if ($email_total > 0) {
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `status` = '1', email_total = '" . (int)$email_total . "' WHERE send_id = '" . (int)$send_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "contacts_cache_send SET `status` = '1' WHERE send_id = '" . (int)$send_id . "'");
		}
	}
	
	public function getCompleteDataSend($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contacts_cache_send WHERE `status` = '1'";
		
		$sort_data = array(
			'date_added'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY date_added";	
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
		
		return $query->rows;
	}
	
	public function getTotalCompleteDataSend($data = array()) {
		$sql = "SELECT COUNT(send_id) AS total FROM " . DB_PREFIX . "contacts_cache_send WHERE `status` = '1'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function setProductToSend($send_id = 0, $cron_id = 0, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_cache_product SET 
		send_id = '" . (int)$send_id . "', 
		cron_id = '" . (int)$cron_id . "', 
		type = '" . $this->db->escape($data['type']) . "', 
		title = '" . $this->db->escape($data['title']) . "', 
		qty = '" . (int)$data['qty'] . "', 
		cat_id = '" . $this->db->escape($data['cat_id']) . "', 
		cat_each = '" . (int)$data['cat_each'] . "', 
		prod_id = '" . $this->db->escape($data['products']) . "'");
	}
	
	public function getProductSend($send_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_product WHERE send_id = '" . (int)$send_id . "'");
		return $query->rows;
	}
	
	public function getProductsToSend($send_id, $type, $language_id = false) {
		$product_data = array();
		if ($this->checkLicense()) {
			$query = $this->db->query("SELECT prod_id FROM " . DB_PREFIX . "contacts_cache_product WHERE send_id = '" . (int)$send_id . "' AND type = '" . $this->db->escape($type) . "'");
			
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
		}
		return $product_data;
	}
	
	public function delProductSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_product WHERE send_id = '" . (int)$send_id . "'");
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
	
	public function getEmailsToSend($send_id, $limit) {
		if ($this->checkLicense()) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "' LIMIT " . $limit);
			return $query->rows;
		} else {
			return array();
		}
	}
	
	public function getTotalEmailsToSend($send_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT email_id) AS total FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "'");
		return $query->row['total'];
	}
	
	public function removeEmailSend($send_id, $email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "' AND LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	public function delEmailsSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_cache_email WHERE send_id = '" . (int)$send_id . "'");
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
	
	public function setSubscribe($email) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_unsubscribe WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_newsletter SET unsubscribe_id = '0' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '1' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
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
	
	public function getTotalUnsubscribesfromSend($send_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT email) AS total FROM " . DB_PREFIX . "contacts_unsubscribe WHERE send_id = '" . (int)$send_id . "'");
		return $query->row['total'];
	}
	
	public function getUnsubscribesfromSend($send_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_unsubscribe WHERE send_id = '" . (int)$send_id . "' ORDER BY date_added DESC");
		return $query->rows;
	}

	public function getTotalViewsfromSend($send_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT email) AS total FROM " . DB_PREFIX . "contacts_views WHERE send_id = '" . (int)$send_id . "'");
		return $query->row['total'];
	}
	
	public function getViewsfromSend($send_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_views WHERE send_id = '" . (int)$send_id . "' ORDER BY date_added DESC");
		return $query->rows;
	}
	
	public function delViewsSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_views WHERE send_id = '" . (int)$send_id . "'");
	}

	public function getTotalClicksfromSend($send_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT email) AS total FROM " . DB_PREFIX . "contacts_clicks WHERE send_id = '" . (int)$send_id . "'");
		return $query->row['total'];
	}
	
	public function getClicksfromSend($send_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_clicks WHERE send_id = '" . (int)$send_id . "' ORDER BY date_added DESC");
		return $query->rows;
	}
	
	public function delClicksSend($send_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_clicks WHERE send_id = '" . (int)$send_id . "'");
	}

	public function getCustomerFromEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		return $query->row;
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

	public function getCustomerData($customer_id) {
		$sql = "SELECT DISTINCT c.email, c.customer_id, c.firstname, c.lastname, c.date_added, cy.name AS country, zn.name AS zone FROM " . DB_PREFIX . "customer c";
		$sql .= " LEFT JOIN " . DB_PREFIX . "address ad ON (c.customer_id = ad.customer_id)";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country cy ON (ad.country_id = cy.country_id)";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "zone` zn ON (ad.zone_id = zn.zone_id)";
		$sql .= " WHERE c.customer_id = '" . (int)$customer_id . "' AND c.email <> ''";

		$query = $this->db->query($sql);
		return $query->row;
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
	
	public function getClients($data = array()) {
		if ($this->checkLicense()) {
			$sql = "SELECT DISTINCT email, CONCAT(firstname, ' ', lastname) AS name FROM `" . DB_PREFIX . "order`";
			
			if ($this->config->get('contacts_client_status')) {
				$sql .= " WHERE order_status_id > '0'";
			} else {
				$sql .= " WHERE order_status_id = '" . (int)$this->config->get('config_complete_status_id') . "'";
			}
			
			$implode = array();
			
			if (!empty($data['filter_name'])) {
				$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}
			
			if (!empty($data['filter_email'])) {
				$implode[] = "email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
			}
			
			if (!empty($data['filter_phone'])) {
				$implode[] = "telephone LIKE '%" . $this->db->escape($data['filter_phone']) . "%'";
			}
			
			if ($implode) {
				$sql .= " AND " . implode(" OR ", $implode);
			}
			
			$sql .= " ORDER BY name ASC LIMIT 10";
			
			$query = $this->db->query($sql);
			return $query->rows;
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

	public function getTemplates($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "contacts_template";
		
		$sort_data = array(
			'name',
			'template_id'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY template_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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
		return $query->rows;
	}
	
	public function getTotalTemplates() {
		$query = $this->db->query("SELECT COUNT(template_id) AS total FROM " . DB_PREFIX . "contacts_template");
		return $query->row['total'];
	}
	
	public function getTemplate($template_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "contacts_template WHERE template_id = '" . (int)$template_id . "'");
		return $query->row;
	}
	
	public function deleteTemplate($template_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "contacts_template WHERE template_id = '" . (int)$template_id . "'");
	}
	
	public function addTemplate($data = array()) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "contacts_template SET name = '" . $this->db->escape($data['name']) . "', subject = '" . $this->db->escape($data['subject']) . "', message = '" . $this->db->escape($data['message']) . "'");
		$template_id = $this->db->getLastId();
		return $template_id;
	}
	
	public function editTemplate($template_id, $data = array()) {
		$this->db->query("UPDATE " . DB_PREFIX . "contacts_template SET name = '" . $this->db->escape($data['name']) . "', subject = '" . $this->db->escape($data['subject']) . "', message = '" . $this->db->escape($data['message']) . "' WHERE template_id = '" . (int)$template_id . "'");
	}
	
	public function getAllsCategories() {
		$sql = "SELECT c.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name, c.parent_id, c.sort_order FROM " . DB_PREFIX . "category c 
		LEFT JOIN " . DB_PREFIX . "category_path cp ON (c.category_id = cp.category_id) 
		LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) 
		LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) 
		WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sql .= " GROUP BY c.category_id ORDER BY name";

		$query = $this->db->query($sql);
		return $query->rows;
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
	
	public function getSelectedProducts($selproducts, $language_id) {
		$product_data = array();
		
		if (!empty($selproducts)) {
			foreach ($selproducts as $product_id) {
				$product_info = $this->getProduct($product_id, $language_id);
				if ($product_info) {
					$product_data[$product_id] = $product_info;
				}
			}
		}
		
		return $product_data;
	}
	
	public function getProductsFromCat($category_id, $limit, $language_id, $store_id) {
		$time_now = date('Y-m-d H:i') . ':00';
		$product_data = array();
		
		if ($this->checkLicense()) {
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
		}
		return $product_data;
	}
	
	public function getCatSelectedProducts($category_products, $limit, $language_id, $store_id) {
		$time_now = date('Y-m-d H:i') . ':00';
		$product_data = array();
	
		if ($this->checkLicense()) {
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
	
		$oimplode = array();
	
		if ($this->config->get('config_complete_status')) {
			foreach ($this->config->get('config_complete_status') as $status_id) {
				$oimplode[] = (int)$status_id;
			}
		}
	
		if ($oimplode) {
			$sql .= " WHERE o.order_status_id IN (" . implode(", ", $oimplode) . ")";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
	
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
	
	public function getCronlimit($limit) {
		$cron_limit = array();
		$cron_limit['limit'] = 16;
		$cron_limit['step'] = 1;
	
		if ($limit) {
			$result = $limit / 60;
	
			if ($result < 1) {
				$cron_limit['limit'] = 1;
				$cron_limit['step'] = 2;
			} elseif (floor($result) == 1) {
				$cron_limit['limit'] = 1;
				$cron_limit['step'] = 1;
			} elseif (floor($result) == 2) {
				$cron_limit['limit'] = 2;
				$cron_limit['step'] = 1;
			} else {
				$cron_limit['limit'] = floor($result);
				$cron_limit['step'] = 1;
			}
	
			if ($cron_limit['limit'] > 25) {
				$cron_limit['limit'] = 25;
			}
		}
		return $cron_limit;
	}
	
	public function checkLicense() {
		$lic = 1;
		return $lic;
	}
	
	public function checkTableBase() {
		$check = false;
	
		$query = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_template");
	
		foreach ($query->rows as $result) {
			$fields[] = $result['Field'];
		}
	
		if (in_array('subject', $fields)) {
			$check = true;
		}
	
		return $check;
	}
	
	public function insertTableBase() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_license` (`contacts_id` int(11) NOT NULL AUTO_INCREMENT, `license` varchar(64) NOT NULL, PRIMARY KEY (`contacts_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_template` (`template_id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `subject` text NOT NULL, `message` longtext NOT NULL, PRIMARY KEY (`template_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$query = $this->db->query("SELECT template_id FROM " . DB_PREFIX . "contacts_template");
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "contacts_template` SET `name` = 'Новое поступление товара', `message` = '&lt;p&gt;Уважаемый {name}, мы рады сообщить вам о новом поступлении продукции в наш магазин.&lt;/p&gt;&lt;p&gt;Только самая качественная и проверенная продукция! Ждем вас за покупками!&lt;/p&gt;&lt;p&gt;{latest}&lt;/p&gt;'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "contacts_template` SET `name` = 'Подарки каждому покупателю', `message` = '&lt;p&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;Здравствуйте {firstname}!&lt;/span&gt;&lt;/p&gt;&lt;p&gt;Теперь в нашем магазине {shopurl} подарки каждому покупателю!&lt;/p&gt;&lt;p&gt;Вы сами выбираете себе подарок на сумму 30% от стоимости заказа!&lt;/p&gt;&lt;p&gt;И это еще не всё, теперь доставка в {zone} у нас бесплатная!&lt;/p&gt;&lt;p&gt;Ждем вас за новыми покупками.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Всегда ваш,&lt;/p&gt;&lt;p&gt;{shopname}&lt;br&gt;&lt;/p&gt;'");
		}
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_unsubscribe` (
		`unsubscribe_id` int(11) NOT NULL AUTO_INCREMENT, 
		`send_id` int(11) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`unsubscribe_id`), KEY `send_id` (`send_id`), KEY `email` (`email`(32))) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_newsletter` (
		`newsletter_id` int(11) NOT NULL AUTO_INCREMENT, 
		`group_id` int(11) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`unsubscribe_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`firstname` varchar(64) NOT NULL, 
		`lastname` varchar(32) NOT NULL, 
		PRIMARY KEY (`newsletter_id`), KEY `group_id` (`group_id`), KEY `customer_id` (`customer_id`), KEY `email` (`email`(32))) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_views` (
		`view_id` int(11) NOT NULL AUTO_INCREMENT, 
		`send_id` int(11) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`view_id`), KEY `send_id` (`send_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_clicks` (
		`click_id` int(11) NOT NULL AUTO_INCREMENT, 
		`send_id` int(11) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`target` text NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`click_id`), KEY `send_id` (`send_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_group` (
		`group_id` int(11) NOT NULL AUTO_INCREMENT, 
		`name` varchar(64) NOT NULL, 
		`description` varchar(255) NOT NULL, 
		PRIMARY KEY (`group_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cache_email` (
		`email_id` int(11) NOT NULL AUTO_INCREMENT, 
		`send_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`firstname` varchar(64) NOT NULL, 
		`lastname` varchar(32) NOT NULL, 
		`country` varchar(32) NOT NULL, 
		`zone` varchar(32) NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`email_id`), KEY `send_id` (`send_id`), KEY `email` (`email`(32))) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cache_send` (
		`send_id` int(11) NOT NULL AUTO_INCREMENT, 
		`store_id` int(11) NOT NULL, 
		`send_type` int(11) NOT NULL, 
		`send_to` varchar(32) NOT NULL, 
		`send_to_data` text NOT NULL, 
		`send_region` tinyint(1) NOT NULL DEFAULT '0', 
		`send_country_id` int(11) NOT NULL, 
		`send_zone_id` int(11) NOT NULL, 
		`invers_region` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_product` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_category` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_customer` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_client` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_affiliate` tinyint(1) NOT NULL DEFAULT '0', 
		`send_products` tinyint(1) NOT NULL DEFAULT '0', 
		`lang_products` int(11) NOT NULL, 
		`language_id` int(11) NOT NULL, 
		`subject` text NOT NULL, 
		`message` longtext NOT NULL, 
		`newmessage` longtext NOT NULL, 
		`attachments` text NOT NULL, 
		`attachments_cat` text NOT NULL, 
		`dopurl` text NOT NULL, 
		`email_total` int(11) NOT NULL, 
		`unsub_url` tinyint(1) NOT NULL DEFAULT '0', 
		`control_unsub` tinyint(1) NOT NULL DEFAULT '0', 
		`status` tinyint(1) NOT NULL DEFAULT '0', 
		`errors` int(11) NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`send_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cache_product` (
		`product_cache_id` int(11) NOT NULL AUTO_INCREMENT, 
		`send_id` int(11) NOT NULL, 
		`cron_id` int(11) NOT NULL, 
		`type` varchar(32) NOT NULL, 
		`title` varchar(255) NOT NULL, 
		`qty` int(11) NOT NULL, 
		`cat_id` text NOT NULL, 
		`cat_each` tinyint(1) NOT NULL DEFAULT '0', 
		`prod_id` text NOT NULL, 
		PRIMARY KEY (`product_cache_id`), KEY `send_id` (`send_id`), KEY `cron_id` (`cron_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cron` (
		`cron_id` int(11) NOT NULL AUTO_INCREMENT, 
		`name` varchar(255) NOT NULL, 
		`checking` tinyint(1) NOT NULL DEFAULT '0', 
		`date_start` datetime NULL DEFAULT NULL, 
		`date_next` datetime NULL DEFAULT NULL, 
		`period` int(11) NOT NULL, 
		`step` int(11) NOT NULL, 
		`history_id` int(11) NOT NULL, 
		`errors` int(11) NOT NULL, 
		`status` tinyint(1) NOT NULL DEFAULT '0', 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`cron_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cron_data` (
		`cron_data_id` int(11) NOT NULL AUTO_INCREMENT, 
		`cron_id` int(11) NOT NULL, 
		`store_id` int(11) NOT NULL, 
		`send_to` varchar(32) NOT NULL, 
		`send_to_data` text NOT NULL, 
		`date_start` date NOT NULL DEFAULT '0000-00-00', 
		`date_end` date NOT NULL DEFAULT '0000-00-00', 
		`send_region` tinyint(1) NOT NULL DEFAULT '0', 
		`send_country_id` int(11) NOT NULL, 
		`send_zone_id` int(11) NOT NULL, 
		`invers_region` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_product` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_category` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_customer` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_client` tinyint(1) NOT NULL DEFAULT '0', 
		`invers_affiliate` tinyint(1) NOT NULL DEFAULT '0', 
		`send_products` tinyint(1) NOT NULL DEFAULT '0', 
		`lang_products` int(11) NOT NULL, 
		`language_id` int(11) NOT NULL, 
		`subject` text NOT NULL, 
		`message` longtext NOT NULL, 
		`attachments` text NOT NULL, 
		`attachments_cat` text NOT NULL, 
		`dopurl` text NOT NULL, 
		`static` varchar(32) NOT NULL, 
		`email_total` int(11) NOT NULL, 
		`unsub_url` tinyint(1) NOT NULL DEFAULT '0', 
		`control_unsub` tinyint(1) NOT NULL DEFAULT '0', 
		`limit_start` int(11) NOT NULL, 
		`limit_end` int(11) NOT NULL, 
		`emnovalid_action` tinyint(1) NOT NULL DEFAULT '0', 
		`embad_action` tinyint(1) NOT NULL DEFAULT '0', 
		`emsuspect_action` tinyint(1) NOT NULL DEFAULT '0', 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		PRIMARY KEY (`cron_data_id`), KEY `cron_id` (`cron_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cron_emails` (
		`cemail_id` int(11) NOT NULL AUTO_INCREMENT, 
		`cron_id` int(11) NOT NULL, 
		`email` varchar(96) NOT NULL, 
		`customer_id` int(11) NOT NULL, 
		`firstname` varchar(64) NOT NULL, 
		`lastname` varchar(32) NOT NULL, 
		`country` varchar(32) NOT NULL, 
		`zone` varchar(32) NOT NULL, 
		`date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		`check_status` tinyint(1) NOT NULL DEFAULT '0', 
		`check_text` text NOT NULL, 
		PRIMARY KEY (`cemail_id`), KEY `cron_id` (`cron_id`), KEY `check_status` (`check_status`), KEY `email` (`email`(32))) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_cron_history` (
		`history_id` int(11) NOT NULL AUTO_INCREMENT, 
		`cron_id` int(11) NOT NULL, 
		`send_id` int(11) NOT NULL, 
		`date_cronrun` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		`date_cronstop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', 
		`count_emails` int(11) NOT NULL, 
		`cron_status` tinyint(1) NOT NULL DEFAULT '0', 
		`text_error` varchar(255) NOT NULL, 
		`log_file` varchar(255) NOT NULL, 
		PRIMARY KEY (`history_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "contacts_count_mails` (
		`count_id` int(11) NOT NULL AUTO_INCREMENT, 
		`cron_id` int(11) NOT NULL, 
		`send_id` int(11) NOT NULL, 
		`items` int(11) NOT NULL, 
		`date_send` int(11) NOT NULL, 
		PRIMARY KEY (`count_id`), KEY `date_send` (`date_send`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$cnquery = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_newsletter");
	
		foreach ($cnquery->rows as $cnresult) {
			$cnfields[] = $cnresult['Field'];
		}
		if (!in_array('lastname', $cnfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_newsletter` ADD `lastname` VARCHAR(32) NOT NULL AFTER `email`");
		}
		if (!in_array('firstname', $cnfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_newsletter` ADD `firstname` VARCHAR(64) NOT NULL AFTER `email`");
		}
	
		$cdquery = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_cron_data");
	
		foreach ($cdquery->rows as $cdresult) {
			$cdfields[] = $cdresult['Field'];
			if ($cdresult['Field'] == 'subject') {
				if ($cdresult['Type'] != 'text') {
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` CHANGE `subject` `subject` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
				}
			}
		}
		if (!in_array('date_end', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `date_end` date NOT NULL DEFAULT '0000-00-00' AFTER `send_to_data`");
		}
		if (!in_array('date_start', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `date_start` date NOT NULL DEFAULT '0000-00-00' AFTER `send_to_data`");
		}
		if (!in_array('email_total', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `email_total` INT(11) NOT NULL AFTER `attachments`");
		}
		if (!in_array('static', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `static` VARCHAR(32) NOT NULL AFTER `attachments`");
		}
		if (!in_array('invers_region', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_region` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_affiliate', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_affiliate` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_client', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_client` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_customer', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_customer` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_category', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_category` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_product', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `invers_product` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('language_id', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `language_id` INT(11) NOT NULL AFTER `send_products`");
		}
		if (!in_array('lang_products', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `lang_products` INT(11) NOT NULL AFTER `send_products`");
		}
		if (!in_array('dopurl', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `dopurl` TEXT NOT NULL AFTER `attachments`");
		}
		if (!in_array('attachments_cat', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `attachments_cat` TEXT NOT NULL AFTER `attachments`");
		}
		if (!in_array('limit_end', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `limit_end` INT(11) NOT NULL AFTER `control_unsub`");
		}
		if (!in_array('limit_start', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `limit_start` INT(11) NOT NULL AFTER `control_unsub`");
		}
		if (!in_array('emsuspect_action', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `emsuspect_action` tinyint(1) NOT NULL DEFAULT '0' AFTER `control_unsub`");
		}
		if (!in_array('embad_action', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `embad_action` tinyint(1) NOT NULL DEFAULT '0' AFTER `control_unsub`");
		}
		if (!in_array('emnovalid_action', $cdfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron_data` ADD `emnovalid_action` tinyint(1) NOT NULL DEFAULT '0' AFTER `control_unsub`");
		}
	
		$ccquery = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_cron");
	
		foreach ($ccquery->rows as $ccresult) {
			$ccfields[] = $ccresult['Field'];
		}
		if (!in_array('checking', $ccfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron` ADD `checking` tinyint(1) NOT NULL DEFAULT '0' AFTER `name`");
		}
		if (!in_array('history_id', $ccfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cron` ADD `history_id` INT(11) NOT NULL AFTER `step`");
		}
	
		$ccsquery = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_cache_send");
	
		foreach ($ccsquery->rows as $ccsresult) {
			$ccsfields[] = $ccsresult['Field'];
			if ($ccsresult['Field'] == 'subject') {
				if ($ccsresult['Type'] != 'text') {
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` CHANGE `subject` `subject` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
				}
			}
		}
		if (!in_array('invers_region', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_region` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_affiliate', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_affiliate` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_client', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_client` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_customer', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_customer` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_category', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_category` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('invers_product', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `invers_product` tinyint(1) NOT NULL DEFAULT '0' AFTER `send_zone_id`");
		}
		if (!in_array('language_id', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `language_id` INT(11) NOT NULL AFTER `send_products`");
		}
		if (!in_array('lang_products', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `lang_products` INT(11) NOT NULL AFTER `send_products`");
		}
		if (!in_array('errors', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `errors` INT(11) NOT NULL AFTER `status`");
		}
		if (!in_array('dopurl', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `dopurl` TEXT NOT NULL AFTER `attachments`");
		}
		if (!in_array('attachments_cat', $ccsfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_cache_send` ADD `attachments_cat` TEXT NOT NULL AFTER `attachments`");
		}
	
		$opsquery = $this->db->query("DESCRIBE " . DB_PREFIX . "order_product");
	
		foreach ($opsquery->rows as $opresult) {
			if ($opresult['Field'] == 'product_id') {
				$opkey = $opresult['Key'];
				if (!$opkey) {
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD INDEX `product_id` (`product_id`) COMMENT ''");
				}
			}
		}
	
		if(!$this->config->get('contacts_count_message')) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `group` = 'contacts'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_mail_protocol', `value` = 'mail', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_mail_from', `value` = '', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_mail_parameter', `value` = '', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_smtp_host', `value` = '', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_smtp_username', `value` = '', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_smtp_password', `value` = '', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_smtp_port', `value` = '25', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_smtp_timeout', `value` = '5', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_count_message', `value` = '1', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_sleep_time', `value` = '4', `serialized` = '0'");
		}
		if(!$this->config->get('contacts_unsub_pattern')) {
			$mask = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,15}$/i';
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_email_pattern', `value` = '" . $this->db->escape($mask) . "', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_count_send_error', `value` = '10', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_admin_limit', `value` = '10', `serialized` = '0'");
			$unsub_pattern = rand(111111, 999999);
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_unsub_pattern', `value` = '" . (int)$unsub_pattern . "', `serialized` = '0'");
		}
		if(!$this->config->get('contacts_reply_badem')) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_check_mode', `value` = '1', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_global_limith', `value` = '1000', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_global_limitd', `value` = '10000', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_ignore_servers', `value` = '@mail.ru | @list.ru | @bk.ru | @inbox.ru | @hotmail.com', `serialized` = '0'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `group` = 'contacts', `key` = 'contacts_reply_badem', `value` = 'user not found | no such user | no such mailbox | invalid mailbox | mailbox unavailable | disabled | relay access denied | relay not permitted | not exist | no such recipient | unknown recipient | recipient unknown | recipient not found | blocked | user unknown | unknown user | account is full | mailbox is full | quota exceed | over quota | overquoted | unrouteable address | name is unknown | administrative prohibition | prohibited | no mailbox here', `serialized` = '0'");
		}
		
		$tquery = $this->db->query("DESCRIBE " . DB_PREFIX . "contacts_template");
		
		foreach ($tquery->rows as $tresult) {
			$tfields[] = $tresult['Field'];
		}
		if (!in_array('subject', $tfields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "contacts_template` ADD `subject` text NOT NULL AFTER `name`");
		}

		$handle = fopen(DIR_LOGS . 'contacts.log', 'w+');
		fclose($handle);
	}
}
?>
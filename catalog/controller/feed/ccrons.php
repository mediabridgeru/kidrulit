<?php 
class ControllerFeedCcrons extends Controller {
	public function index() {
		@set_time_limit(0);
		$this->language->load('contacts/ccrons');
		
		$crons_log = new Log('contacts.log');
		$crons_log->write($this->language->get('text_start_crons'));
		
        if (isset($this->request->get['cont']) && ($this->request->get['cont'] == $this->config->get('contacts_unsub_pattern'))) {
			$this->load->model('contacts/ccrons');
			$status = false;
			
			if (!$this->config->get('contacts_allow_cronsend')) {
				$run_send = $this->model_contacts_ccrons->getRunSend();
				if ($run_send) {
					$status = $this->language->get('error_cronissend');
				}
			}
			
			if (!$status) {
				$run_cron = $this->model_contacts_ccrons->getRunCron();
				if ($run_cron) {
					$status = $this->language->get('error_croniscron');
				}
			}
			
			$cron_id = false;
			$date_now = date('Y-m-d H:i:s');
			
			if (!$status) {
				$crons = $this->model_contacts_ccrons->getCrons();
				
				if (!empty($crons)) {
					foreach ($crons as $cron) {
						if ($cron['date_next']) {
							if ($cron['date_next'] < $date_now) {
								$cron_id = $cron['cron_id'];
								break;
							}
						} elseif ($cron['date_start'] && ($cron['date_start'] < $date_now)) {
							$cron_id = $cron['cron_id'];
							break;
						}
					}
				} else {
					$status = $this->language->get('error_nocrons');
				}

				if ($cron_id) {
					$status = sprintf($this->language->get('text_start_cron'), $cron_id);
				} else {
					$status = $this->language->get('error_nocrons');
				}
			}
			
			$crons_log->write($status);
			
			if ($cron_id) {
				$data = array(
					'status'  => 1,
					'cron_id' => $cron_id
				);

				$this->sendcron($data);
			} else {
				$this->response->setOutput($status);
			}
			
        } else {
			$crons_log->write($this->language->get('error_cronpattern'));
			$this->response->redirect($this->url->link('common/home'));
		}
    }
	
	private function sendcron($data) {
		@set_time_limit(0);
		$step_data = array();
		
		$step_data = $this->send($data);
		
		if ($step_data && $step_data['status']) {
			$this->sendcron($step_data);
		} else {
			return;
		}
	}
	
	private function send($cron_data) {
		@set_time_limit(100);
		$crons_log = new Log('contacts.log');
		$date_now = date('Y-m-d');
		
		$error = false;
		$next = false;
		$step = 0;
		$page = 1;
		$send_id = 0;
		$history_id = 0;
		$date_next = false;
		$otcat_period = false;
		$otcat_hour = false;
		$attention = array();

		if ($cron_data) {
			$cron_id = $cron_data['cron_id'];
			
			if (isset($cron_data['step'])) {
				$step = $cron_data['step'];
			}
			if (isset($cron_data['history_id'])) {
				$history_id = $cron_data['history_id'];
			}
			if (!$history_id) {
				$history_id = $this->model_contacts_ccrons->addCronHistory($cron_id);
			}
			
			$cron_log = new Log('ccron.' . $cron_id . '.' . $history_id . '.log');
			$log_file = 'ccron.' . $cron_id . '.' . $history_id . '.log';
			
			$cron_info = $this->model_contacts_ccrons->getCron($cron_id);
		
			if ($cron_info) {
				if ($cron_info['status']) {
					if ($cron_info['date_next']) {
						if ($cron_info['period']) {
							$time_next = date('H:i:s', strtotime($cron_info['date_next']));
							
							if ($date_now > date('Y-m-d', strtotime($cron_info['date_next']) + 60 * 60 * 24 * $cron_info['period'])) {
								$date_next = date('Y-m-d H:i:s', strtotime($date_now . ' ' . $time_next) + 60 * 60 * 24 * $cron_info['period']);
							} else {
								$date_next = date('Y-m-d H:i:s', strtotime($cron_info['date_next']) + 60 * 60 * 24 * $cron_info['period']);
							}
						}
					} else {
						if ($cron_info['period']) {
							$time_next = date('H:i:s', strtotime($cron_info['date_start']));
							
							if ($date_now > date('Y-m-d', strtotime($cron_info['date_start']) + 60 * 60 * 24 * $cron_info['period'])) {
								$date_next = date('Y-m-d H:i:s', strtotime($date_now . ' ' . $time_next) + 60 * 60 * 24 * $cron_info['period']);
							} else {
								$date_next = date('Y-m-d H:i:s', strtotime($cron_info['date_start']) + 60 * 60 * 24 * $cron_info['period']);
							}
						}
					}
				} else {
					$cron_log->write($this->language->get('error_cronstatus'));
					$error = true;
				}
			} else {
				$cron_log->write($this->language->get('error_croninfo'));
				$error = true;
			}
			
			if (!$error) {
				$send_info = $this->model_contacts_ccrons->getDataCron($cron_id);

				if (empty($send_info)) {
					$cron_log->write = $this->language->get('error_msid_data');
					$error = true;
				} else {
					if (!$send_info['subject'] || trim($send_info['subject'] == '')) {
						$cron_log->write = $this->language->get('error_msid_data');
						$error = true;
					}
					
					if (!$send_info['message'] || trim($send_info['message'] == '')) {
						$cron_log->write = $this->language->get('error_msid_data');
						$error = true;
					}
				}
			}

			if (!$error) {
				require_once(DIR_SYSTEM . 'library/mail_cs.php');
				
				$store_info = $this->model_contacts_ccrons->getShopStore($send_info['store_id']);
				
				if ($store_info) {
					$store_name = $store_info['name'];
					$store_url = $store_info['url'];
				} else {
					$store_name = $this->config->get('config_name');
					$store_url = HTTP_SERVER;
				}

				if ($step) {
					$page = $step;
					$send_id = $this->model_contacts_ccrons->getHistorySend($history_id);
				} else {
					$page = 1;
					$this->cache->delete('ccron');
					$cron_log->write($this->language->get('text_start_send'));
					$send_id = $this->model_contacts_ccrons->addNewSend($send_info['store_id'], 2);
				}
				
				if ($this->config->get('contacts_mail_protocol') && ($this->config->get('contacts_mail_protocol') == 'smtp')) {
					$contacts_mail_protocol = 'smtp';
				} else {
					$contacts_mail_protocol = 'mail';
				}
				
				if ($this->config->get('contacts_smtp_port') && ($this->config->get('contacts_smtp_port') > 0)) {
					$contacts_smtp_port = $this->config->get('contacts_smtp_port');
				} else {
					$contacts_smtp_port = 25;
				}
				
				if ($this->config->get('contacts_smtp_timeout') && ($this->config->get('contacts_smtp_timeout') > 0)) {
					$contacts_smtp_timeout = $this->config->get('contacts_smtp_timeout');
				} else {
					$contacts_smtp_timeout = 5;
				}
				
				if (($this->config->get('contacts_count_message')) && ($this->config->get('contacts_count_message') > 0)) {
					$contacts_count_message = $this->config->get('contacts_count_message');
				} else {
					$contacts_count_message = 3;
				}
				
				if (($this->config->get('contacts_sleep_time')) && ($this->config->get('contacts_sleep_time') > 0)) {
					$contacts_sleep_time = $this->config->get('contacts_sleep_time');
				} else {
					$contacts_sleep_time = 7;
				}
				
				if ($this->config->get('contacts_count_send_error') && ($this->config->get('contacts_count_send_error') > 0)) {
					$contacts_count_error = $this->config->get('contacts_count_send_error');
				} else {
					$contacts_count_error = 3;
				}
				
				if ($send_info['send_region']) {
					$set_region = $send_info['send_region'];
				} else {
					$set_region = false;
				}
				
				if ($send_info['send_country_id']) {
					$country_id = $send_info['send_country_id'];
				} else {
					$country_id = false;
				}
				
				if ($send_info['send_zone_id']) {
					$zone_id = $send_info['send_zone_id'];
				} else {
					$zone_id = false;
				}
				
				if ($send_info['unsub_url']) {
					$set_unsubscribe = $send_info['unsub_url'];
				} else {
					$set_unsubscribe = false;
				}
				
				if ($send_info['control_unsub']) {
					$control_unsubscribe = $send_info['control_unsub'];
				} else {
					$control_unsubscribe = false;
				}

				$shop_country = $this->model_contacts_ccrons->getCountry($this->config->get('config_country_id'));
				$shop_zone = $this->model_contacts_ccrons->getZone($this->config->get('config_zone_id'));
				
				$lang_id = $this->config->get('config_language_id');
				$store_id = $send_info['store_id'];
				$cgroup_id = $this->config->get('config_customer_group_id');
				
				$attachments = array();
				$save_attachments = '';
				
				if ($send_info['attachments']) {
					$send_attachments = explode(',', $send_info['attachments']);
					
					foreach ($send_attachments as $attachment) {
						if ((trim($attachment) != '') && file_exists(DIR_DOWNLOAD . $attachment)) {
							$attachments[] = array(
								'path' => DIR_DOWNLOAD . $attachment
							);
						}
					}
				}
				
				if ($attachments) {
					$save_attachments = implode(',', $send_attachments);
				}
				
				$special = '';
				$bestseller = '';
				$latest = '';
				$featured = '';
				$selproducts = '';
				$catproducts = '';
				
				if ($send_info['send_products']) {
					$insert_products = $send_info['send_products'];
				} else {
					$insert_products = false;
				}
				
				if ($insert_products) {
					$send_product_data = $this->model_contacts_ccrons->getProductSend($cron_id);
					foreach ($send_product_data as $send_product) {
						if ($send_product['type'] == 'special') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$special_limit = $send_product['qty'];
							} else {
								$special_limit = 4;
							}

							$special_products = array();
							
							$special_cache_data = $this->cache->get('ccron.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$special_limit);
							
							if (!isset($special_cache_data)) {
								$specials = $this->model_contacts_ccrons->getSpecialsProducts($special_limit);
								if (!empty($specials)) {
									$special_products = $this->getMailProducts($specials);
								}
								$this->cache->set('ccron.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$special_limit, $special_products);
							} else {
								$special_products = $special_cache_data;
							}

							if ($special_products) {
								$special_template = new Template();
							
								if ($send_product['title']) {
									$special_template->data['title'] = $send_product['title'];
								} else {
									$special_template->data['title'] = $this->language->get('special_title');
								}
							
								$special_template->data['products'] = $special_products;
								$special = $special_template->fetch('default/template/mail/contacts_products.tpl');
							}
							
						} elseif ($send_product['type'] == 'bestseller') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$bestseller_limit = $send_product['qty'];
							} else {
								$bestseller_limit = 4;
							}
							
							$bestseller_products = array();
							
							$bestseller_cache_data = $this->cache->get('ccron.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$bestseller_limit);
							
							if (!isset($bestseller_cache_data)) {
								$bestsellers = $this->model_contacts_ccrons->getBestsellerProducts($bestseller_limit);
								if (!empty($bestsellers)) {
									$bestseller_products = $this->getMailProducts($bestsellers);
								}
								$this->cache->set('ccron.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$bestseller_limit, $bestseller_products);
							} else {
								$bestseller_products = $bestseller_cache_data;
							}
							
							if ($bestseller_products) {
								$bestseller_template = new Template();
								
								if ($send_product['title']) {
									$bestseller_template->data['title'] = $send_product['title'];
								} else {
									$bestseller_template->data['title'] = $this->language->get('bestseller_title');
								}
							
								$bestseller_template->data['products'] = $bestseller_products;
								$bestseller = $bestseller_template->fetch('default/template/mail/contacts_products.tpl');
							}
							
						} elseif ($send_product['type'] == 'latest') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$latest_limit = $send_product['qty'];
							} else {
								$latest_limit = 4;
							}
							
							$latest_products = array();
							
							$latest_cache_data = $this->cache->get('ccron.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$latest_limit);
							
							if (!isset($latest_cache_data)) {
								$latests = $this->model_contacts_ccrons->getLatestProducts($latest_limit);
								if (!empty($latests)) {
									$latest_products = $this->getMailProducts($latests);
								}
								$this->cache->set('ccron.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$latest_limit, $latest_products);
							} else {
								$latest_products = $latest_cache_data;
							}
							
							if ($latest_products) {
								$latest_template = new Template();
								
								if ($send_product['title']) {
									$latest_template->data['title'] = $send_product['title'];
								} else {
									$latest_template->data['title'] = $this->language->get('latest_title');
								}
							
								$latest_template->data['products'] = $latest_products;
								$latest = $latest_template->fetch('default/template/mail/contacts_products.tpl');
							}

						} elseif ($send_product['type'] == 'featured') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$featured_limit = $send_product['qty'];
							} else {
								$featured_limit = 4;
							}
							
							$featured_products = array();
							
							$featured_cache_data = $this->cache->get('ccron.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$featured_limit);
							
							if (!isset($featured_cache_data)) {
								$featureds = $this->model_contacts_ccrons->getFeaturedProducts($featured_limit);
								if (!empty($featureds)) {
									$featured_products = $this->getMailProducts($featureds);
								}
								$this->cache->set('ccron.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$featured_limit, $featured_products);
							} else {
								$featured_products = $featured_cache_data;
							}

							if ($featured_products) {
								$featured_template = new Template();
								
								if ($send_product['title']) {
									$featured_template->data['title'] = $send_product['title'];
								} else {
									$featured_template->data['title'] = $this->language->get('featured_title');
								}
							
								$featured_template->data['products'] = $featured_products;
								$featured = $featured_template->fetch('default/template/mail/contacts_products.tpl');
							}
					
						} elseif ($send_product['type'] == 'selproducts') {
							$selected_products = array();
							
							$selected_cache_data = $this->cache->get('ccron.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id);
							
							if (!isset($selected_cache_data)) {
								$selectproducts = $this->model_contacts_ccrons->getProductsToSend($cron_id, $send_product['type']);
								
								if (!empty($selectproducts)) {
									$selected_products = $this->getMailProducts($selectproducts);
								}
								
								$this->cache->set('ccron.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id, $selected_products);
							} else {
								$selected_products = $selected_cache_data;
							}

							if ($selected_products) {
								$selproducts_template = new Template();
								
								if ($send_product['title']) {
									$selproducts_template->data['title'] = $send_product['title'];
								} else {
									$selproducts_template->data['title'] = $this->language->get('selproducts_title');
								}
							
								$selproducts_template->data['products'] = $selected_products;
								$selproducts = $selproducts_template->fetch('default/template/mail/contacts_products.tpl');
							}
					
						} elseif ($send_product['type'] == 'catproducts') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$catproducts_limit = $send_product['qty'];
							} else {
								$catproducts_limit = 4;
							}
							
							$category_products = array();
							$catproducts_each = false;
							
							$catproduct_cache_data = $this->cache->get('ccron.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$catproducts_limit);

							if (!isset($catproduct_cache_data)) {
								$pcategories = explode(',', $send_product['cat_id']);
								
								if ($send_product['cat_each']) {
									foreach ($pcategories as $pcategory_id) {
										$allcatproducts[] = $this->model_contacts_ccrons->getProductsFromCat($pcategory_id, $catproducts_limit);
									}
									foreach ($allcatproducts as $pid) {
										foreach ($pid as $key => $value) {
											$selcatproducts[$key] = $value;
										}
									}
								} else {
									$selcatproducts = $this->model_contacts_ccrons->getCatSelectedProducts($pcategories, $catproducts_limit);
								}						
								
								if (!empty($selcatproducts)) {
									$category_products = $this->getMailProducts($selcatproducts);
								}
								$this->cache->set('ccron.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$catproducts_limit, $category_products);
							} else {
								$category_products = $catproduct_cache_data;
							}

							if ($category_products) {
								$category_products_template = new Template();
								
								if ($send_product['title']) {
									$category_products_template->data['title'] = $send_product['title'];
								} else {
									$category_products_template->data['title'] = $this->language->get('catproducts_title');
								}
							
								$category_products_template->data['products'] = $category_products;
								$catproducts = $category_products_template->fetch('default/template/mail/contacts_products.tpl');
							}
					
						} else {
							$special = '';
							$bestseller = '';
							$latest = '';
							$featured = '';
							$selproducts = '';
							$catproducts = '';
						}
					}
				}

				$email_total = 0;
				$send_email_total = 0;
				$emails = array();
				$emails_cache = array();
				
				$emails_cache = $this->cache->get('ccron.emails.' . (int)$cron_id);
				
				if ($emails_cache) {

					$emails = $emails_cache['emails'];
					$email_total = $emails_cache['email_total'];

				} else {
				
				  switch ($send_info['send_to']) {
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter' => 1,
							'filter_country_id' => $country_id,
							'filter_zone_id'    => $zone_id
						);

						$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);
					
						foreach ($results as $result) {
							$emails[$result['email']] = array(
								'customer_id'   => $result['customer_id'],
								'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
								'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
								'country'       => $result['country'],
								'zone'          => $result['zone'],
								'date_added'    => $result['date_added']
							);
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						
						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);

						break;
					case 'customer_all':
						$customer_data = array(
							'filter_country_id' => $country_id,
							'filter_zone_id'    => $zone_id
						);

						$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);
				
						foreach ($results as $result) {
							$emails[$result['email']] = array(
								'customer_id'   => $result['customer_id'],
								'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
								'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
								'country'       => $result['country'],
								'zone'          => $result['zone'],
								'date_added'    => $result['date_added']
							);
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						
						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);

						break;
					case 'client_all':
						$customer_data = array(
							'filter_country_id' => $country_id,
							'filter_zone_id'    => $zone_id
						);
						
						$results = $this->model_contacts_ccrons->getEmailsByOrdereds($customer_data);
				
						foreach ($results as $result) {
							$unsuber = false;
							
							if ($control_unsubscribe) {
								if ($this->model_contacts_ccrons->checkEmailUnsubscribe($result['email'])) {
									$unsuber = true;
								}

								if (($result['customer_id'] > 0) && (!$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id']))) {
									$unsuber = true;
								}
							}
							
							if (!$unsuber) {
								$emails[$result['email']] = array(
									'customer_id'   => $result['customer_id'],
									'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
									'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
									'country'       => $result['country'],
									'zone'          => $result['zone'],
									'date_added'    => $result['date_added']
								);
							}
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));

						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);

						break;
					case 'customer_group':
						$filter_customer_group_id = explode(',', $send_info['send_to_data']);

						$customer_data = array(
							'filter_customer_group_id' => $filter_customer_group_id,
							'filter_country_id'        => $country_id,
							'filter_zone_id'           => $zone_id,
							'filter_unsubscribe'       => $control_unsubscribe
						);

						$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);
						
						foreach ($results as $result) {
							$emails[$result['email']] = array(
								'customer_id'   => $result['customer_id'],
								'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
								'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
								'country'       => $result['country'],
								'zone'          => $result['zone'],
								'date_added'    => $result['date_added']
							);
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));

						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);

						break;
					case 'customer':
						$filter_customers = explode(',', $send_info['send_to_data']);
						
						foreach ($filter_customers as $customer_id) {
							$customer_info = $this->model_contacts_ccrons->getCustomerData($customer_id);
							
							if ($customer_info) {
								if (!$control_unsubscribe || $this->model_contacts_ccrons->checkCustomerNewsletter($customer_info['customer_id'])) {
									$emails[$customer_info['email']] = array(
										'customer_id'   => $customer_info['customer_id'],
										'firstname'     => mb_convert_case($customer_info['firstname'], MB_CASE_TITLE, 'UTF-8'),
										'lastname'      => mb_convert_case($customer_info['lastname'], MB_CASE_TITLE, 'UTF-8'),
										'country'       => $customer_info['country'],
										'zone'          => $customer_info['zone'],
										'date_added'    => $customer_info['date_added']
									);
								}
							}
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						
						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);
						
						break;
					case 'send_group':
						$filter_group_id = explode(',', $send_info['send_to_data']);
						
						$customer_data = array(
							'filter_group_id'    => $filter_group_id,
							'filter_unsubscribe' => $control_unsubscribe
						);

						$results = $this->model_contacts_ccrons->getNewsletters($customer_data);
				
						foreach ($results as $result) {
							$emails[$result['cemail']] = array(
								'customer_id'   => $result['customer_id'],
								'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
								'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
								'country'       => '',
								'zone'          => '',
								'date_added'    => ''
							);
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));

						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);
						
						break;
					case 'affiliate_all':
						$affiliate_data = array(
							'filter_country_id' => $country_id,
							'filter_zone_id'    => $zone_id
						);
						
						$results = $this->model_contacts_ccrons->getEmailAffiliates($affiliate_data);
				
						foreach ($results as $result) {
							if (!$control_unsubscribe || !$this->model_contacts_ccrons->checkEmailUnsubscribe($result['email'])) {
								$emails[$result['email']] = array(
										'customer_id'   => '',
										'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
										'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
										'country'       => $result['country'],
										'zone'          => $result['zone'],
										'date_added'    => ''
								);
							}
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));

						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);

						break;
					case 'affiliate':
						$filter_affiliates = explode(',', $send_info['send_to_data']);
						
						foreach ($filter_affiliates as $affiliate_id) {
							$affiliate_info = $this->model_contacts_ccrons->getAffiliateData($affiliate_id);
							
							if ($affiliate_info) {
								if (!$control_unsubscribe || !$this->model_contacts_ccrons->checkEmailUnsubscribe($affiliate_info['email'])) {
									$emails[$affiliate_info['email']] = array(
										'customer_id'   => '',
										'firstname'     => mb_convert_case($affiliate_info['firstname'], MB_CASE_TITLE, 'UTF-8'),
										'lastname'      => mb_convert_case($affiliate_info['lastname'], MB_CASE_TITLE, 'UTF-8'),
										'country'       => $affiliate_info['country'],
										'zone'          => $affiliate_info['zone'],
										'date_added'    => ''
									);
								}
							}
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						
						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);
						
						break;
					case 'product':
						$filter_products = explode(',', $send_info['send_to_data']);
						
						$data = array(
							'filter_products'   => $filter_products,
							'filter_country_id' => $country_id,
							'filter_zone_id'    => $zone_id
						);

						$results = $this->model_contacts_ccrons->getEmailsByOrdereds($data);

						foreach ($results as $result) {
							$unsuber = false;
							
							if ($control_unsubscribe) {
								if ($this->model_contacts_ccrons->checkEmailUnsubscribe($result['email'])) {
									$unsuber = true;
								}

								if (($result['customer_id'] > 0) && (!$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id']))) {
									$unsuber = true;
								}
							}
							
							if (!$unsuber) {
								$emails[$result['email']] = array(
									'customer_id'   => $result['customer_id'],
									'firstname'     => mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8'),
									'lastname'      => mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8'),
									'country'       => $result['country'],
									'zone'          => $result['zone'],
									'date_added'    => $result['date_added']
								);
							}
						}
						
						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));

						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);
						
						break;
					case 'manual':
						$post_manuals = explode(',', preg_replace('/\s/', '', $send_info['send_to_data']));
						$manuals = array_unique($post_manuals);
						
						foreach ($manuals as $manual) {
							if (trim($manual) != '') {
								if (!$control_unsubscribe || !$this->model_contacts_ccrons->checkEmailUnsubscribe($manual)) {
									$emails[$manual] = array(
										'customer_id'   => '',
										'firstname'     => '',
										'lastname'      => '',
										'country'       => '',
										'zone'          => '',
										'date_added'    => ''
									);
								}
							}
						}

						$email_total = count($emails);
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						
						$emails_cache['emails'] = $emails;
						$emails_cache['email_total'] = $email_total;
						$this->cache->set('ccron.emails.' . (int)$cron_id, $emails_cache);
						
						break;
				  }
				}

				if ($page == 1) {
					$data_send = array(
						'store_id'        => $store_id,
						'history_id'      => $history_id,
						'send_to'         => $send_info['send_to'],
						'send_to_data'    => $send_info['send_to_data'],
						'send_region'     => $set_region,
						'send_country_id' => $country_id,
						'send_zone_id'    => $zone_id,
						'send_products'   => $insert_products,
						'subject'         => $send_info['subject'],
						'message'         => $send_info['message'],
						'attachments'     => $save_attachments,
						'email_total'     => $email_total,
						'unsub_url'       => $set_unsubscribe,
						'control_unsub'   => $control_unsubscribe
					);
					
					$this->model_contacts_ccrons->setDataNewSend($send_id, $data_send);
				}
				
				if ($emails) {
					sleep($contacts_sleep_time);
					$start = ($page - 1) * $contacts_count_message;
					$end = $start + $contacts_count_message;
					$lastsend = 0;
					$count_send_error = 0;
					$otcat_hour = false;
					$otcat_period = false;

					if ($end < $email_total) {
						$next = $page + 1;
					} else {
						$lastsend = 1;
						$next = false;
					}
					
					if (($this->config->get('contacts_mail_from')) && ($this->config->get('contacts_mail_from') != '')) {
						$senders = explode(',', preg_replace('/\s/', '', $this->config->get('contacts_mail_from')));
					} else {
						$senders = array($this->config->get('config_email'));
					}
					
					$semails = array_slice($emails, $start, $contacts_count_message);

					foreach ($semails as $email => $customer) {
						if ($count_send_error < $contacts_count_error) {
							if ($this->checkValidEmail($email)) {
								if ($customer['firstname']) {
									$firstname = $customer['firstname'];
								} else {
									$firstname = '';
								}
								if ($customer['lastname']) {
									$lastname = $customer['lastname'];
								} else {
									$lastname = '';
								}
								if ($customer['firstname'] && $customer['lastname']) {
									$name = $customer['firstname'] . ' ' . $customer['lastname'];
								} elseif ($customer['firstname'] && !$customer['lastname']) {
									$name = $customer['firstname'];
								} elseif (!$customer['firstname'] && $customer['lastname']) {
									$name = $customer['lastname'];
								} else {
									$name = $this->language->get('text_client');
								}
								if ($customer['country']) {
									$country = $customer['country'];
								} else {
									$country = $shop_country;
								}
								if ($customer['zone']) {
									$zone = $customer['zone'];
								} else {
									$zone = $shop_zone;
								}

								$shopname = $store_name;
								$shopurl = '<a href="' . $store_url . '">' . $store_name . '</a>';
								
								$tegi_subject = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}');
								$tegi_message = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}','{shopurl}','{special}','{bestseller}','{latest}','{featured}','{selproducts}','{catproducts}');
								
								$replace_subject = array($firstname, $lastname, $name, $country, $zone, $shopname);
								$replace_message = array($firstname, $lastname, $name, $country, $zone, $shopname, $shopurl, $special, $bestseller, $latest, $featured, $selproducts, $catproducts);
								
								$orig_subject = $send_info['subject'];
								$orig_message = $send_info['message'];
							
								$subject_to_send = str_replace($tegi_subject, $replace_subject, $orig_subject);
								$message_to_send = str_replace($tegi_message, $replace_message, $orig_message);

								$controlsumm = md5($email . $this->config->get('contacts_unsub_pattern'));
								
								if ($customer['customer_id']) {
									$sid = base64_encode($send_id . '|' . $email . '|' . $controlsumm . '|' . $customer['customer_id']);
								} else {
									$sid = base64_encode($send_id . '|' . $email . '|' . $controlsumm . '|0');
								}

								$message  = '<html dir="ltr" lang="en">' . "\n";
								$message .= '  <head>' . "\n";
								$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n";
								$message .= '    <title>' . html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
								$message .= '  </head>' . "\n";
								
								$savemessage = $message;
								$savemessage .= '  <body><table style="width:98%;margin-left:auto;margin-right:auto;"><tr><td>' . html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . '</td></tr></table>' . "\n\n";
								$savemessage .= '  </body>' . "\n";
								$savemessage .= '</html>' . "\n";
								
								$controlimage = HTTP_SERVER . 'index.php?route=feed/stats/images&sid=' . $sid;
								$message .= '  <body><table style="width:98%;background:url(' . $controlimage . ');margin-left:auto;margin-right:auto;"><tr><td>' . html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . "\n\n";
								
								if ($set_unsubscribe) {
									$unsubscribe_url = HTTP_SERVER . 'index.php?route=account/success&sid=' . $sid;
									$message .= '   <table style="width:100%;background:#efefef;font-size:12px;"><tr><td style="padding:5px;text-align:center;">' . sprintf($this->language->get('text_unsubscribe'), $unsubscribe_url) . '</td></tr></table>' . "\n";
								} else {
									$message .= '   <table style="width:100%;background:#efefef;font-size:12px;"><tr><td style="padding:5px;text-align:center;">' . $shopurl . '</td></tr></table>' . "\n";
								}

								$message .= '  </td></tr></table></body>' . "\n";
								$message .= '</html>' . "\n";
								
								libxml_use_internal_errors(true);
								$doc = new DOMDocument;
								$doc->loadHTML($message);
								
								foreach ($doc->getElementsByTagName('a') as $ateg) {
									if ($ateg->hasAttribute('href')) {
										$ateg_href = $ateg->getAttribute('href');
										$pos = strpos($ateg_href, 'account/success');
										if($pos === false) {
											$ateg_url = base64_encode($ateg_href);
											$new_url = HTTP_SERVER . 'index.php?route=feed/stats/clck&sid=' . $sid . '&link=' . $ateg_url;
											$ateg->setAttribute('href', $new_url);
										}
									}
								}
								
								$newmessage = $doc->saveHTML();
								libxml_clear_errors();

								if (count($senders) > 1) {
									$number = mt_rand(0, count($senders) - 1);
									$sender = $senders[$number];
								} else {
									$sender = $senders[0];
								}

								$mail = new Mail_CS();
								$mail->protocol = $contacts_mail_protocol;
								$mail->parameter = $this->config->get('contacts_mail_parameter');
								$mail->hostname = $this->config->get('contacts_smtp_host');
								$mail->username = $this->config->get('contacts_smtp_username');
								$mail->password = html_entity_decode($this->config->get('contacts_smtp_password'), ENT_QUOTES, 'UTF-8');
								$mail->port = $contacts_smtp_port;
								$mail->timeout = $contacts_smtp_timeout;
								$mail->setTo($email);
								$mail->setFrom($sender);
								$mail->setMid($sid);
								$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
								if ($set_unsubscribe) {
									$mail->setUnsubscribe($unsubscribe_url);
								}
								if ($attachments) {
									foreach ($attachments as $attachment) {
										$mail->addAttachment($attachment['path']);
									}
								}
								$mail->setSubject(html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8'));
								$mail->setHtml($newmessage);
								$cron_log->write($this->language->get('text_send_email') . $email);
								$send_status = $mail->send();
								if ($send_status == 55) {
									$send_email_total++;
								} elseif (substr($send_status, 0, 4) == 'cerr') {
									$otcat_hour = true;
									$cron_log->write($this->language->get('error_send_' . substr($send_status, 4, 2)) . ' ' . $this->language->get('text_stop_send'));
									break;
								} elseif (substr($send_status, 0, 4) == 'nerr') {
									$cron_log->write($this->language->get('error_send_attention') . ' ' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . ' ' . $this->language->get('text_continues_send'));
									$count_send_error++;
								} else {
									$count_send_error++;
								}
							} else {
								$cron_log->write($this->language->get('text_bad_email') . $email);
							}
						} else {
							$otcat_hour = true;
							$cron_log->write($this->language->get('error_send_count'));
							break;
						}
					}
					
					if($otcat_hour) {
						$this->cache->delete('ccron');
						$lastsend = 0;
						$next = false;
						if ($cron_info['errors'] < 3) {
							$date_next = date('Y-m-d H:i:s', strtotime("+1 hours"));
							$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4, $page);
							$this->model_contacts_ccrons->otcatCron($cron_id, $date_next, 1);
							$cron_log->write($this->language->get('text_otcat_hour'));
							//$cron_log->write('1020');
						} else {
							$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 3);
							$this->model_contacts_ccrons->offCron($cron_id);
							$cron_log->write($this->language->get('text_off_cron'));
							//$cron_log->write('1023');
						}
					}
					
					if($page == 1) {
						$this->model_contacts_ccrons->setNewMessageDataCron($send_id, $savemessage);
					}
				
					if($lastsend == 1) {
						$this->cache->delete('ccron');
						$cron_log->write($this->language->get('text_end_send'));
						$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 2);
						if ($date_next) {
							$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
							//$cron_log->write('1033');
						} else {
							$this->model_contacts_ccrons->offCron($cron_id);
							//$cron_log->write('1036');
						}
					}
					
					$this->model_contacts_ccrons->setCompleteCronSend($send_id, $send_email_total);

				} else {
					$cron_log->write($this->language->get('error_noemails'));
					$otcat_period = true;
				}
			} else {
				$cron_log->write($this->language->get('error_cronstop'));
				$otcat_period = true;
				$send_email_total = 0;
			}
		
			if($otcat_period) {
				$this->cache->delete('ccron');
				$next = false;
				if ($date_next) {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4);
					$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
					$cron_log->write($this->language->get('text_otcat_period'));
					//$cron_log->write('1057');
				} else {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 3);
					$this->model_contacts_ccrons->offCron($cron_id);
					$cron_log->write($this->language->get('text_off_cron'));
					//$cron_log->write('1060');
				}
				if (($page == 1) && ($send_id)) {
					$this->model_contacts_ccrons->delDataSend($send_id);
				}
			}
			
			$this->model_contacts_ccrons->setCronHistory($history_id, $send_email_total, $log_file);
		
			if ($next) {
				$step_data = array(
					'status'     => 1,
					'cron_id'    => $cron_id,
					'step'       => $next,
					'history_id' => $history_id
				);
				return $step_data;
			} else {
				if ($otcat_period || $otcat_hour) {
					$crons_log->write($this->language->get('text_otcat_period'));
				} else {
					$crons_log->write($this->language->get('text_cron_complete'));
				}
				$step_data = array('status' => '');
				return $step_data;
			}
		
		} else {
			$crons_log->write($this->language->get('error_croninfo'));
			$step_data = array('status' => '');
			return $step_data;
		}
	}
	
	private function getMailProducts($results) {
		$products = array();
		
		if ($this->config->get('contacts_product_currency')) {
			$currency = $this->config->get('contacts_product_currency');
		} else {
			$currency = $this->config->get('config_currency');
		}
		
		$this->load->model('tool/image');
		
		if ($this->config->get('contacts_pimage_width') && ($this->config->get('contacts_pimage_width') > 0)) {
			$iwidth = $this->config->get('contacts_pimage_width');
		} else {
			$iwidth = 150;
		}
		
		if ($this->config->get('contacts_pimage_height') && ($this->config->get('contacts_pimage_height') > 0)) {
			$iheight = $this->config->get('contacts_pimage_height');
		} else {
			$iheight = 150;
		}
		
		foreach ($results as $result) {
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], $iwidth, $iheight);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', $iwidth, $iheight);
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($result['special'], $currency);
				$discount = floor((($result['price']-$result['special'])/$result['price'])*100);
			} else {
				$special = false;
				$discount = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = HTTP_SERVER . 'catalog/view/theme/' . $this->config->get('config_template') . '/image/stars-' . $result['rating'] . '.png';
			} else {
				$rating = false;
			}

			$products[] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'discount'   => isset($discount)?'-'.$discount.'%':'',
				'name'    	 => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				'price'   	 => $this->currency->format($result['price'], $currency),
				'model'    	 => $result['model'],
				'sku'    	 => $result['sku'],
				'special' 	 => $special,
				'rating'     => $rating,
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
		}
			
		return $products;
	}

	private function checkValidEmail($email) {
		if ($this->config->get('contacts_email_pattern') && ($this->config->get('contacts_email_pattern') != '')) {
			$pattern = $this->config->get('contacts_email_pattern');
			
			if (preg_match($pattern, $email)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
?>
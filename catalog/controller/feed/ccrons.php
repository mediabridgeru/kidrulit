<?php 
class ControllerFeedCcrons extends Controller {
	private $colvo = 0;
	private $start = 0;
	private $time_limit = 26;
	private $count_message = 1;
	private $time_sleep = 1;
	private $store_config = array();
	
	public function index() {
		$this->config->set('config_error_display', 0);

		$this->language->load('contacts/ccrons');

		$crons_log = new Log('contacts.log');

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
					$freeze = $this->model_contacts_ccrons->checkFreezeCron($run_cron, 300);
	
					if ($freeze) {
						$crons_log->write(sprintf($this->language->get('text_freeze_cron'), $run_cron));
						$crons_log->write($this->language->get('text_restart_cron'));
	
						$cron_info = $this->model_contacts_ccrons->getCron($run_cron);
	
						$this->model_contacts_ccrons->stopCron($cron_info['cron_id'], $cron_info['history_id'], 4, $cron_info['step']);
					} else {
						$status = $this->language->get('error_croniscron');
					}
				}
			}
	
			$cron_id = false;
			$checking = false;
			$step = 0;
			$date_now = date('Y-m-d H:i:s');

			if (!$status) {
				$crons = $this->model_contacts_ccrons->getCrons();
				
				if (!empty($crons)) {
					foreach ($crons as $cron) {
						if ($cron['date_next']) {
							if ($cron['date_next'] < $date_now) {
								$cron_id = $cron['cron_id'];
								$checking = $cron['checking'];
								$step = $cron['step'];
								break;
							}
						} elseif ($cron['date_start'] && ($cron['date_start'] < $date_now)) {
							$cron_id = $cron['cron_id'];
							$checking = $cron['checking'];
							$step = $cron['step'];
							break;
						}
					}
				} else {
					$status = $this->language->get('error_nocrons');
				}

				if ($cron_id) {
					$status = sprintf($this->language->get('text_start_cron'), $cron_id);
					$crons_log->write($status);
				} else {
					$status = $this->language->get('error_nocrons');
				}
			}
			
			if ($cron_id) {
				$data = array(
					'status'  => 1,
					'cron_id' => $cron_id,
					'step'    => $step
				);
				
				if ($checking) {
					$this->sendcroncheck($data);
				} else {
					$this->sendcron($data);
				}
			} else {
				$this->response->setOutput($status);
			}
			
        } else {
			$crons_log->write($this->language->get('error_cronpattern'));
			$this->response->redirect($this->url->link('common/home'));
		}
    }

	private function sendcron($data) {
		$step_data = array();
	
		$start = $this->start;
		$now = strtotime("now");
	
		if (!$start) {
			$start = $now;
			$this->start = $start;
		}
	
		$colvo = $this->colvo;
	
		if ($this->config->get('contacts_cron_limit')) {
			$cron_limit = $this->config->get('contacts_cron_limit');
		} elseif ($this->config->get('contacts_global_limith')) {
			$cron_limit = $this->model_contacts_ccrons->getCronlimit($this->config->get('contacts_global_limith'));
		} else {
			$cron_limit = 16;
		}
	
		if (($colvo < $cron_limit) && (($now - $start) < $this->time_limit)) {
			$step_data = $this->send($data);
			$colvo++;
			$this->colvo = $colvo;
		} else {
			$this->model_contacts_ccrons->stopCron($data['cron_id'], $data['history_id'], 4, $data['step']);
			$step_data = array();
		}
		
		if ($step_data && $step_data['status']) {
			$this->sendcron($step_data);
		} else {
			return;
		}
	}
	
	private function sendcroncheck($data) {
		$step_data = array();
	
		$start = $this->start;
		$now = strtotime("now");
	
		if (!$start) {
			$start = $now;
			$this->start = $start;
		}
	
		if (($now - $start) < $this->time_limit) {
			$step_data = $this->sendcheck($data);
		} else {
			$this->model_contacts_ccrons->stopCron($data['cron_id'], $data['history_id'], 4, $data['step']);
			$step_data = array();
		}
		
		if ($step_data && $step_data['status']) {
			$this->sendcroncheck($step_data);
		} else {
			return;
		}
	}
	
	private function send($cron_data) {
		$crons_log = new Log('contacts.log');
		$date_now = date('Y-m-d');
		
		$error = false;
		$error_limit = false;
		$next = false;
		$step = 0;
		$page = 1;
		$send_id = 0;
		$history_id = 0;

		$date_next = false;
		$otcat_period = false;
		$otcat_hour = false;

		if ($cron_data) {
			$cron_id = $cron_data['cron_id'];

			if (isset($cron_data['step'])) {
				$step = $cron_data['step'];
			}
			if (isset($cron_data['history_id'])) {
				$history_id = $cron_data['history_id'];
			}
	
			if (!$history_id) {
				if ($step) {
					$last_history_id = $this->model_contacts_ccrons->getLastCronHistory($cron_id);
				}
			
				$history_id = $this->model_contacts_ccrons->addCronHistory($cron_id);
	
				$this->model_contacts_ccrons->addLastCronHistory($cron_id, $history_id);
	
				if ($step) {
					$last_send_id = $this->model_contacts_ccrons->getCronLastSend($cron_id, $last_history_id);
					$this->model_contacts_ccrons->setCronNewSend($last_send_id, $history_id);
				}
			}

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
					$crons_log->write($this->language->get('error_cronstatus'));
					$error = true;
				}
			} else {
				$crons_log->write($this->language->get('error_croninfo'));
				$error = true;
			}

			if (!$error) {
				$send_info = $this->model_contacts_ccrons->getDataCron($cron_id);

				if (!empty($send_info)) {
					if (!$send_info['subject'] || trim($send_info['subject'] == '')) {
						$crons_log->write($this->language->get('error_cron_subject'));
						$error = true;
					}
					if (!$send_info['message'] || trim($send_info['message'] == '')) {
						$crons_log->write($this->language->get('error_cron_message'));
						$error = true;
					}
				} else {
					$crons_log->write($this->language->get('error_cron_data'));
					$error = true;
				}
			}
			
			if (!$error) {
				if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
					$total_mails = $this->model_contacts_ccrons->getCountMails();
					
					if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
						$crons_log->write($this->language->get('error_limit_hour') . ' (1001)');
						$error = true;
						$error_limit = true;
						$page = $step ? $step : 1;
					}
					if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
						$crons_log->write($this->language->get('error_limit_day') . ' (1002)');
						$error = true;
						$error_limit = true;
						$page = $step ? $step : 1;
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
					$send_id = $this->model_contacts_ccrons->addNewSend($send_info['store_id'], 2);
				}

				$cron_log = new Log('ccron.' . $cron_id . '.' . $send_id . '.log');
	
				if ($page == 1) {
					$this->cache->delete('ccron');
					$cron_log->write($this->language->get('text_start_send'));
				}
	
				$contacts_mail_protocol = ($this->config->get('contacts_mail_protocol') == 'smtp') ? 'smtp' : 'mail';
	
				$contacts_smtp_port = $this->config->get('contacts_smtp_port') ? $this->config->get('contacts_smtp_port') : 25;
				$contacts_smtp_timeout = $this->config->get('contacts_smtp_timeout') ? $this->config->get('contacts_smtp_timeout') : 5;
				$contacts_count_error = $this->config->get('contacts_count_send_error') ? $this->config->get('contacts_count_send_error') : 10;
	
				$precedence = $this->config->get('contacts_add_precedence') ? $this->config->get('contacts_add_precedence') : '';
	
				$set_region = ($send_info['send_region']) ? $send_info['send_region'] : '';
				$country_id = ($send_info['send_country_id']) ? $send_info['send_country_id'] : '';
				$zone_id = ($send_info['send_zone_id']) ? $send_info['send_zone_id'] : '';
				$invers_region = ($send_info['invers_region']) ? $send_info['invers_region'] : '';
	
				$date_start = ($send_info['date_start'] && ($send_info['date_start'] != '0000-00-00')) ? $send_info['date_start'] : '';
				$date_end = ($send_info['date_end'] && ($send_info['date_end'] != '0000-00-00')) ? $send_info['date_end'] : '';
	
				$limit_start = ($send_info['limit_start']) ? $send_info['limit_start'] : '';
				$limit_end = ($send_info['limit_end']) ? $send_info['limit_end'] : '';
	
				$invers_product = ($send_info['invers_product']) ? $send_info['invers_product'] : '';
				$invers_category = ($send_info['invers_category']) ? $send_info['invers_category'] : '';
				$invers_customer = ($send_info['invers_customer']) ? $send_info['invers_customer'] : '';
				$invers_client = ($send_info['invers_client']) ? $send_info['invers_client'] : '';
				$invers_affiliate = ($send_info['invers_affiliate']) ? $send_info['invers_affiliate'] : '';
				
				$static = ($send_info['static']) ? $send_info['static'] : 'dinamic';
				$send_products = ($send_info['send_products']) ? $send_info['send_products'] : '';
				$dopurl = ($send_info['dopurl']) ? $send_info['dopurl'] : '';
				
				$set_unsubscribe = ($send_info['unsub_url']) ? $send_info['unsub_url'] : '';
				$control_unsubscribe = ($send_info['control_unsub']) ? $send_info['control_unsub'] : '';

				$shop_country = $this->model_contacts_ccrons->getCountry($this->config->get('config_country_id'));
				$shop_zone = $this->model_contacts_ccrons->getZone($this->config->get('config_zone_id'));
	
				if ($send_info['language_id']) {
					$language_id = $send_info['language_id'];
					$lang_id = $language_id;
				} else {
					$language_id = false;
					$lang_id = $this->config->get('config_language_id');
				}
	
				if ($send_info['lang_products']) {
					$lang_id = $send_info['language_id'];
				}
	
				$store_id = $send_info['store_id'];
				$cgroup_id = $this->config->get('config_customer_group_id');
				
				$reply_badem = explode('|', $this->config->get('contacts_reply_badem'));
				$bad_email_action = $this->config->get('contacts_bad_eaction') ? $this->config->get('contacts_bad_eaction') : 0;
	
				$attachments = array();
				$attachments_cat = array();
				$save_attachments = '';
				$save_attachments_cat = '';
	
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
	
				if ($send_info['attachments_cat']) {
					$save_attachments_cat = $send_info['attachments_cat'];
					$files_catalog = str_ireplace('/system/', $send_info['attachments_cat'], DIR_SYSTEM);
	
					if (is_dir($files_catalog)) {
						$files = scandir($files_catalog);
	
						if($files) {
							foreach ($files as $attachment) {
								if(!preg_match("/^[\.]{1,2}$/", $attachment)) {
									$attachments_cat[] = array(
										'path' => $files_catalog . $attachment
									);
								}
							}
						}
					}
				}
	
				$special = '';
				$bestseller = '';
				$latest = '';
				$featured = '';
				$selproducts = '';
				$catproducts = '';
				$add_purchased = false;
	
				if ($send_products) {
					$send_product_data = $this->model_contacts_ccrons->getProductSend($cron_id);

					foreach ($send_product_data as $send_product) {
						if ($send_product['type'] == 'purchased') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$purchased_limit = $send_product['qty'];
							} else {
								$purchased_limit = 4;
							}
	
							if ($send_product['title']) {
								$purchased_title = $send_product['title'];
							} else {
								$purchased_title = $this->language->get('purchased_title');
							}
	
							$add_purchased = true;
						}
	
						if ($send_product['type'] == 'special') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$special_limit = $send_product['qty'];
							} else {
								$special_limit = 4;
							}

							if ($send_product['title']) {
								$special_title = $send_product['title'];
							} else {
								$special_title = $this->language->get('special_title');
							}

							$special_products = array();

							$special_cache_data = $this->cache->get('ccron.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$special_limit);

							if (!isset($special_cache_data)) {
								$specials = $this->model_contacts_ccrons->getSpecialsProducts($special_limit, $lang_id, $store_id);
								if (!empty($specials)) {
									$special_products = $this->getMailProducts($specials);
								}
								$this->cache->set('ccron.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$special_limit, $special_products);
							} else {
								$special_products = $special_cache_data;
							}

							if ($special_products) {
								$special_template = new Template();
								$special_template->data['title'] = $special_title;
								$special_template->data['products'] = $special_products;
								$special = $special_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}

						if ($send_product['type'] == 'bestseller') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$bestseller_limit = $send_product['qty'];
							} else {
								$bestseller_limit = 4;
							}

							if ($send_product['title']) {
								$bestseller_title = $send_product['title'];
							} else {
								$bestseller_title = $this->language->get('bestseller_title');
							}

							$bestseller_products = array();

							$bestseller_cache_data = $this->cache->get('ccron.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$bestseller_limit);

							if (!isset($bestseller_cache_data)) {
								$bestsellers = $this->model_contacts_ccrons->getBestSellerProducts($bestseller_limit, $lang_id, $store_id);
								if (!empty($bestsellers)) {
									$bestseller_products = $this->getMailProducts($bestsellers);
								}
								$this->cache->set('ccron.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$bestseller_limit, $bestseller_products);
							} else {
								$bestseller_products = $bestseller_cache_data;
							}
	
							if ($bestseller_products) {
								$bestseller_template = new Template();
								$bestseller_template->data['title'] = $bestseller_title;
								$bestseller_template->data['products'] = $bestseller_products;
								$bestseller = $bestseller_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}
	
						if ($send_product['type'] == 'latest') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$latest_limit = $send_product['qty'];
							} else {
								$latest_limit = 4;
							}
	
							if ($send_product['title']) {
								$latest_title = $send_product['title'];
							} else {
								$latest_title = $this->language->get('latest_title');
							}
	
							$latest_products = array();
	
							$latest_cache_data = $this->cache->get('ccron.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$latest_limit);
	
							if (!isset($latest_cache_data)) {
								$latests = $this->model_contacts_ccrons->getLatestProducts($latest_limit, $lang_id, $store_id);
								if (!empty($latests)) {
									$latest_products = $this->getMailProducts($latests);
								}
								$this->cache->set('ccron.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$latest_limit, $latest_products);
							} else {
								$latest_products = $latest_cache_data;
							}
	
							if ($latest_products) {
								$latest_template = new Template();
								$latest_template->data['title'] = $latest_title;
								$latest_template->data['products'] = $latest_products;
								$latest = $latest_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}
	
						if ($send_product['type'] == 'featured') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$featured_limit = $send_product['qty'];
							} else {
								$featured_limit = 4;
							}
	
							if ($send_product['title']) {
								$featured_title = $send_product['title'];
							} else {
								$featured_title = $this->language->get('featured_title');
							}
	
							$featured_products = array();
	
							$featured_cache_data = $this->cache->get('ccron.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$featured_limit);
	
							if (!isset($featured_cache_data)) {
								$featureds = $this->model_contacts_ccrons->getFeaturedProducts($featured_limit, $lang_id, $store_id);
								if (!empty($featureds)) {
									$featured_products = $this->getMailProducts($featureds);
								}
								$this->cache->set('ccron.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$featured_limit, $featured_products);
							} else {
								$featured_products = $featured_cache_data;
							}

							if ($featured_products) {
								$featured_template = new Template();
								$featured_template->data['title'] = $featured_title;
								$featured_template->data['products'] = $featured_products;
								$featured = $featured_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}
	
						if ($send_product['type'] == 'selproducts') {
							if ($send_product['title']) {
								$selproducts_title = $send_product['title'];
							} else {
								$selproducts_title = $this->language->get('selproducts_title');
							}
	
							$selected_products = array();
	
							$selected_cache_data = $this->cache->get('ccron.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id);
	
							if (!isset($selected_cache_data)) {
								$selectproducts = $this->model_contacts_ccrons->getProductsToSend($cron_id, $send_product['type'], $lang_id);
	
								if (!empty($selectproducts)) {
									$selected_products = $this->getMailProducts($selectproducts);
								}
	
								$this->cache->set('ccron.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id, $selected_products);
							} else {
								$selected_products = $selected_cache_data;
							}

							if ($selected_products) {
								$selproducts_template = new Template();
								$selproducts_template->data['title'] = $selproducts_title;
								$selproducts_template->data['products'] = $selected_products;
								$selproducts = $selproducts_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}
	
						if ($send_product['type'] == 'catproducts') {
							if ($send_product['qty'] && ($send_product['qty'] > 0)) {
								$catproducts_limit = $send_product['qty'];
							} else {
								$catproducts_limit = 4;
							}
	
							if ($send_product['title']) {
								$catproducts_title = $send_product['title'];
							} else {
								$catproducts_title = $this->language->get('catproducts_title');
							}
	
							$category_products = array();
							$catproducts_each = false;
	
							$catproduct_cache_data = $this->cache->get('ccron.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$cron_id . '.' . (int)$catproducts_limit);

							if (!isset($catproduct_cache_data)) {
								$pcategories = explode(',', $send_product['cat_id']);
	
								if ($send_product['cat_each']) {
									foreach ($pcategories as $pcategory_id) {
										$allcatproducts[] = $this->model_contacts_ccrons->getProductsFromCat($pcategory_id, $catproducts_limit, $lang_id, $store_id);
									}
									foreach ($allcatproducts as $pid) {
										foreach ($pid as $key => $value) {
											$selcatproducts[$key] = $value;
										}
									}
								} else {
									$selcatproducts = $this->model_contacts_ccrons->getCatSelectedProducts($pcategories, $catproducts_limit, $lang_id, $store_id);
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
								$category_products_template->data['title'] = $catproducts_title;
								$category_products_template->data['products'] = $category_products;
								$catproducts = $category_products_template->fetch('default/template/mail/contacts_products.tpl');
							}
						}
					}
				}
	
				$left_total = 0;
				$send_email_total = 0;
				$emails = array();
	
				if ($page == 1) {
					$data_send = array(
						'store_id'         => $store_id,
						'cron_id'          => $cron_id,
						'history_id'       => $history_id,
						'send_to'          => $send_info['send_to'],
						'manual'           => '',
						'send_to_data'     => $send_info['send_to_data'],
						'date_start'       => $date_start,
						'date_end'         => $date_end,
						'send_region'      => $set_region,
						'send_country_id'  => $country_id,
						'send_zone_id'     => $zone_id,
						'invers_region'    => $invers_region,
						'invers_customer'  => $invers_customer,
						'invers_client'    => $invers_client,
						'invers_affiliate' => $invers_affiliate,
						'invers_product'   => $invers_product,
						'invers_category'  => $invers_category,
						'send_products'    => $send_products,
						'lang_products'    => $lang_id,
						'language_id'      => $language_id,
						'subject'          => $send_info['subject'],
						'message'          => $send_info['message'],
						'attachments'      => $save_attachments,
						'attachments_cat'  => $save_attachments_cat,
						'dopurl'           => $dopurl,
						'static'           => $static,
						'unsub_url'        => $set_unsubscribe,
						'control_unsub'    => $control_unsubscribe,
						'limit_start'      => $limit_start,
						'limit_end'        => $limit_end
					);
	
					$all_emails = $this->getAllEmails($data_send);
					$email_total = count($all_emails);
	
					$data_send['email_total'] = 0;
	
					if ($all_emails) {
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						$this->model_contacts_ccrons->setDataNewSend($send_id, $data_send);
						$this->model_contacts_ccrons->saveEmailsToSend($send_id, $all_emails);
					} else {
						$error = true;
						$otcat_period = true;
						if ($static == 'static') {
							$date_next = false;
						}
					}
				}
	
				if (!$error) {
					$results = $this->model_contacts_ccrons->getEmailsToSend($send_id, $this->count_message);

					foreach ($results as $result) {
						$emails[$result['email']] = array(
							'customer_id'   => $result['customer_id'],
							'firstname'     => $result['firstname'],
							'lastname'      => $result['lastname'],
							'country'       => $result['country'],
							'zone'          => $result['zone'],
							'date_added'    => $result['date_added']
						);
					}

					$left_total = $this->model_contacts_ccrons->getTotalEmailsToSend($send_id);
				}
	
				if ($emails) {
					if ($this->time_sleep) {
						sleep($this->time_sleep);
					}
					$lastsend = 0;
					$count_emails = count($emails);
					$count_send_error = $this->model_contacts_ccrons->getErrorsSend($send_id);

					if ($count_emails < $left_total) {
						$next = $page + 1;
					} else {
						$lastsend = 1;
						$next = false;
					}

					if (($this->config->get('contacts_mail_from')) && (trim($this->config->get('contacts_mail_from')) != '')) {
						$senders = explode(',', preg_replace('/\s/', '', $this->config->get('contacts_mail_from')));
					} else {
						$senders = array($this->config->get('config_email'));
					}

					$sender_names = array($store_name);

					if (!$store_id) {
						if (($this->config->get('contacts_mail_fromname')) && (trim($this->config->get('contacts_mail_fromname')) != '')) {
							$sender_names = explode('|', $this->config->get('contacts_mail_fromname'));
						}
					}

					$subjects = explode('|', $send_info['subject']);

					if (($this->config->get('contacts_retpath_email')) && (trim($this->config->get('contacts_retpath_email')) != '')) {
						$retpath_email = trim($this->config->get('contacts_retpath_email'));
					} else {
						$retpath_email = false;
					}

					foreach ($emails as $email => $customer) {
						if ($count_send_error < $contacts_count_error) {
							if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
								$total_mails = $this->model_contacts_ccrons->getCountMails();
								
								if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
									$cron_log->write($this->language->get('error_limit_hour') . ' (1003)');
									$error_limit = true;
								}
								if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
									$cron_log->write($this->language->get('error_limit_day') . ' (1004)');
									$error_limit = true;
								}
							}
							
							if (!$error_limit) {
								if ($this->checkValidEmail($email)) {
									$firstname = $customer['firstname'] ? $customer['firstname'] : '';
									$lastname = $customer['lastname'] ? $customer['lastname'] : '';

									if ($customer['firstname'] && $customer['lastname']) {
										$name = $customer['firstname'] . ' ' . $customer['lastname'];
									} elseif ($customer['firstname'] && !$customer['lastname']) {
										$name = $customer['firstname'];
									} elseif (!$customer['firstname'] && $customer['lastname']) {
										$name = $customer['lastname'];
									} else {
										$name = $this->language->get('text_client');
									}

									$country = $customer['country'] ? $customer['country'] : $shop_country;
									$zone = $customer['zone'] ? $customer['zone'] : $shop_zone;

									if (count($sender_names) > 1) {
										$number = mt_rand(0, count($sender_names) - 1);
										$store_name = trim($sender_names[$number]);
									} else {
										$store_name = trim($sender_names[0]);
									}

									$controlsumm = md5($email . $this->config->get('contacts_unsub_pattern'));

									if ($customer['customer_id']) {
										$sid = base64_encode($send_id . '|' . $email . '|' . $controlsumm . '|' . $customer['customer_id']);
									} else {
										$sid = base64_encode($send_id . '|' . $email . '|' . $controlsumm . '|0');
									}

									$unsubscribe_url = HTTP_SERVER . 'index.php?route=account/success&sid=' . $sid;

									if ($set_unsubscribe) {
										$unsub = sprintf($this->language->get('text_unsubscribe'), $unsubscribe_url);
									} else {
										$unsub = '';
									}

									$buyproducts = '';
	
									if ($add_purchased) {
										$filter_purchased = array(
											'email'       => $email,
											'customer_id' => $customer['customer_id'],
											'language_id' => $lang_id,
											'store_id'    => $store_id,
											'limit'       => $purchased_limit
										);
	
										$purchased_products = array();
	
										$purchaseds = $this->model_contacts_ccrons->getPurchasedsProducts($filter_purchased);
										if (!empty($purchaseds)) {
											$purchased_products = $this->getMailProducts($purchaseds);
										}
	
										if ($purchased_products) {
											$buyproducts_template = new Template();
											$buyproducts_template->data['title'] = $purchased_title;
											$buyproducts_template->data['products'] = $purchased_products;
											$buyproducts = $buyproducts_template->fetch('default/template/mail/contacts_products.tpl');
										}
									}
	
									$shopname = $store_name;
									$shopurl = '<a href="' . $store_url . '">' . $store_name . '</a>';

									$tegi_subject = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}');
									$tegi_message = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}','{shopurl}','{special}','{bestseller}','{latest}','{featured}','{selproducts}','{catproducts}','{buyproducts}','{unsub}');

									$replace_subject = array($firstname, $lastname, $name, $country, $zone, $shopname);
									$replace_message = array($firstname, $lastname, $name, $country, $zone, $shopname, $shopurl, $special, $bestseller, $latest, $featured, $selproducts, $catproducts, $buyproducts, $unsub);

									if (count($subjects) > 1) {
										$number = mt_rand(0, count($subjects) - 1);
										$orig_subject = trim($subjects[$number]);
									} else {
										$orig_subject = trim($subjects[0]);
									}

									$orig_message = $send_info['message'];

									$subject_to_send = str_replace($tegi_subject, $replace_subject, $orig_subject);
									$message_to_send = str_replace($tegi_message, $replace_message, $orig_message);

									$message  = '<html dir="ltr" lang="en">' . "\n";
									$message .= ' <head>' . "\n";
									$message .= '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n";
									$message .= '  <title>' . html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
									$message .= ' </head>' . "\n";

									$savemessage = $message;
									$savemessage .= ' <body><table style="width:98%; margin-left:auto; margin-right:auto;"><tr><td>' . "\n";
									$savemessage .= html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . "\n";
									$savemessage .= ' </td></tr></table></body>' . "\n";
									$savemessage .= '</html>' . "\n";
		
									$controlimage = HTTP_SERVER . 'index.php?route=feed/stats/images&sid=' . $sid;
									$message .= ' <body><table style="width:98%; background:url(' . $controlimage . '); margin-left:auto; margin-right:auto;"><tr><td>' . "\n";
									$message .= html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . "\n\n";
		
									$message .= '  <table style="width:100%; background:#efefef; font-size:12px;"><tr><td style="padding:5px; text-align:center;">' . "\n";
		
									if ($set_unsubscribe) {
										$message .= sprintf($this->language->get('text_unsubscribe'), $unsubscribe_url) . "\n";
									} else {
										$message .= $shopurl . "\n";
									}
	
									$message .= '  </td></tr></table>' . "\n";

									$message .= ' </td></tr></table></body>' . "\n";
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
	
									if ($this->config->get('contacts_add_listid')) {
										$mail->setListid($send_id);
									}
									if ($precedence) {
										$mail->setPrecedence($precedence);
									}
									if ($retpath_email) {
										$mail->setRetpath($retpath_email);
									}
	
									$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
	
									if ($set_unsubscribe) {
										$mail->setUnsubscribe($unsubscribe_url);
									}
									if ($attachments) {
										foreach ($attachments as $attachment) {
											$mail->addAttachment($attachment['path']);
										}
									}
									if ($attachments_cat) {
										foreach ($attachments_cat as $attachment) {
											$mail->addAttachment($attachment['path']);
										}
									}
	
									$mail->setSubject(html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8'));
									$mail->setHtml($newmessage);
									$cron_log->write($this->language->get('text_send_email') . $email);
									
									
									$send_status = $mail->send();
		
	
									if ($send_status == 55) {
										$send_email_total++;
										$this->model_contacts_ccrons->removeEmailSend($send_id, $email);
									} elseif (substr($send_status, 0, 4) == 'cerr') {
										$cron_log->write($this->language->get('error_send_attention') . ' ' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . ' ' . $this->language->get('text_continues_send'));
										$this->model_contacts_ccrons->addErrorSend($send_id);
										$count_send_error++;
									} elseif (substr($send_status, 0, 4) == 'nerr') {
										$cron_log->write($this->language->get('error_send_attention') . ' ' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . ' ' . $this->language->get('text_continues_send'));
										$bad_email = false;
										
										if (substr($send_status, 4, 2) == '24') {
											$this->model_contacts_ccrons->removeEmailSend($send_id, $email);
										}
										
										if ((substr($send_status, 4, 2) == '21') || (substr($send_status, 4, 2) == '22') || (substr($send_status, 4, 2) == '23')) {
											$this->model_contacts_ccrons->removeEmailSend($send_id, $email);
											
											$send_replies = explode('|', $send_status);
											
											if (!empty($send_replies[1]) && !empty($reply_badem)) {
												foreach ($reply_badem as $bad_reply) {
													$bad_text = trim($bad_reply);

													if ($bad_text != '') {
														$pos = stripos($send_replies[1], $bad_text);
														if ($pos !== false) {
															$bad_email = true;
															break;
														}
													}
												}
											}
										}
										
										if ($bad_email) {
											if ($bad_email_action == '1') {
												$this->model_contacts_ccrons->addUnsubscribe($email, $send_id, $customer['customer_id']);
												$cron_log->write($this->language->get('text_bad_email_unsub'));
											}
											if ($bad_email_action == '2') {
												$this->model_contacts_ccrons->addUnsubscribe($email, $send_id, $customer['customer_id']);
												$this->model_contacts_ccrons->delNewsletterFromEmail($email);
												$cron_log->write($this->language->get('text_bad_email_remove'));
											}
										} else {
											$this->model_contacts_ccrons->addErrorSend($send_id);
											$count_send_error++;
										}
									} else {
										$this->model_contacts_ccrons->addErrorSend($send_id);
										$count_send_error++;
									}
									$this->model_contacts_ccrons->addCountMails($send_id, $cron_id, 1);
								} else {
									$cron_log->write($this->language->get('text_bad_email') . $email);
									$this->model_contacts_ccrons->removeEmailSend($send_id, $email);
									
									if ($bad_email_action == '1') {
										$this->model_contacts_ccrons->addUnsubscribe($email, $send_id, $customer['customer_id']);
										$cron_log->write($this->language->get('text_bad_email_unsub'));
									}
									if ($bad_email_action == '2') {
										$this->model_contacts_ccrons->addUnsubscribe($email, $send_id, $customer['customer_id']);
										$this->model_contacts_ccrons->delNewsletterFromEmail($email);
										$cron_log->write($this->language->get('text_bad_email_remove'));
									}
								}
							} else {
								$otcat_hour = true;
								break;
							}
						} else {
							$otcat_hour = true;
							$cron_log->write($this->language->get('error_send_count') . ' (1010)');
							break;
						}
					}
	
					if ($otcat_hour) {
						$lastsend = 0;
					}
	
					if ($page == 1) {
						$savemessage = htmlspecialchars($savemessage, ENT_COMPAT, 'UTF-8');
						$this->model_contacts_ccrons->setNewMessageDataCron($send_id, $savemessage);
					}

					if ($lastsend == 1) {
						$this->cache->delete('ccron');
						$cron_log->write($this->language->get('text_end_send'));
						$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 2);
						if ($date_next) {
							$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
							$cron_log->write($this->language->get('text_otcat_period') . ' (1033)');
						} else {
							$this->model_contacts_ccrons->offCron($cron_id);
							$cron_log->write($this->language->get('text_off_cron') . ' (1036)');
						}
					}

					$this->model_contacts_ccrons->setCompleteCronSend($send_id, $send_email_total);
	
					if (!$lastsend) {
						$this->model_contacts_ccrons->setPageCron($cron_id, $page);
					}

				} else {
					$cron_log->write($this->language->get('error_noemails') . ' (1039)');
					$otcat_period = true;
				}
			} else {
				$crons_log->write($this->language->get('error_cronstop') . ' (1040)');
				if ($error_limit) {
					$otcat_hour = true;
				} else {
					$otcat_period = true;
				}
				$send_email_total = 0;
			}
			
			if ($otcat_hour) {
				$this->cache->delete('ccron');
				$next = false;
				$date_next = date('Y-m-d H:i:s', strtotime("+29 minutes"));
				$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4, $page);
				$this->model_contacts_ccrons->otcatCron($cron_id, $date_next, 1);
				if ($send_id) {
					$this->model_contacts_ccrons->ClearErrorsSend($send_id);
				}
				$crons_log->write($this->language->get('text_otcat_hour') . ' (1020)');
			}

			if ($otcat_period) {
				$this->cache->delete('ccron');
				$next = false;
				if ($date_next) {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4);
					$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
					$crons_log->write($this->language->get('text_otcat_period') . ' (1057)');
				} else {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 3);
					$this->model_contacts_ccrons->offCron($cron_id);
					$crons_log->write($this->language->get('text_off_cron') . ' (1060)');
				}
				if (($page == 1) && ($send_id)) {
					$this->model_contacts_ccrons->delDataSend($send_id);
				}
				if ($send_id) {
					$this->model_contacts_ccrons->ClearErrorsSend($send_id);
				}
			}

			$this->model_contacts_ccrons->setCronHistory($history_id, $send_email_total);

			if ($next) {
				$step_data = array(
					'status'     => 1,
					'cron_id'    => $cron_id,
					'step'       => $next,
					'history_id' => $history_id
				);
				return $step_data;
			} else {
				if (!$otcat_period && !$otcat_hour) {
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

	private function sendcheck($cron_data) {
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

		if ($cron_data) {
			$cron_id = $cron_data['cron_id'];

			if (isset($cron_data['step'])) {
				$step = $cron_data['step'];
			}
			if (isset($cron_data['history_id'])) {
				$history_id = $cron_data['history_id'];
			}
	
			if (!$history_id) {
				if ($step) {
					$last_history_id = $this->model_contacts_ccrons->getLastCronHistory($cron_id);
				}
	
				$history_id = $this->model_contacts_ccrons->addCronHistory($cron_id);
	
				$this->model_contacts_ccrons->addLastCronHistory($cron_id, $history_id);
	
				if ($step) {
					$last_send_id = $this->model_contacts_ccrons->getCronLastSend($cron_id, $last_history_id);
					$this->model_contacts_ccrons->setCronNewSend($last_send_id, $history_id);
				}
			}

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
					$crons_log->write($this->language->get('error_cronstatus'));
					$error = true;
				}
			} else {
				$crons_log->write($this->language->get('error_croninfo'));
				$error = true;
			}

			if (!$error) {
				$send_info = $this->model_contacts_ccrons->getDataCron($cron_id);

				if (!$send_info) {
					$crons_log->write($this->language->get('error_cron_data'));
					$error = true;
				}
			}

			if (!$error) {
				require_once(DIR_SYSTEM . 'library/mail_cc.php');

				if ($step) {
					$page = $step;
					$send_id = $this->model_contacts_ccrons->getHistorySend($history_id);
				} else {
					$page = 1;
					$send_id = $this->model_contacts_ccrons->addNewSend($send_info['store_id'], 2);
				}

				$cron_log = new Log('ccron.' . $cron_id . '.' . $send_id . '.log');
	
				if ($page == 1) {
					$cron_log->write($this->language->get('text_start_send'));
				}
	
				$count_message = 1;
				$count_error = $this->config->get('contacts_count_send_error') ? ($this->config->get('contacts_count_send_error') * 2) : 20;
	
				$static = ($send_info['static']) ? $send_info['static'] : 'dinamic';
				$control_unsubscribe = ($send_info['control_unsub']) ? $send_info['control_unsub'] : '';

				$send_email_total = 0;
				$left_total = 0;
				$emails = array();
	
				if ($page == 1) {
					$data_send = array(
						'store_id'         => $send_info['store_id'],
						'cron_id'          => $cron_id,
						'history_id'       => $history_id,
						'send_to'          => $send_info['send_to'],
						'manual'           => '',
						'send_to_data'     => $send_info['send_to_data'],
						'date_start'       => '',
						'date_end'         => '',
						'send_region'      => '',
						'send_country_id'  => '',
						'send_zone_id'     => '',
						'invers_region'    => '',
						'invers_customer'  => '',
						'invers_client'    => '',
						'invers_affiliate' => '',
						'invers_product'   => '',
						'invers_category'  => '',
						'send_products'    => '',
						'lang_products'    => '',
						'language_id'      => '',
						'subject'          => $send_info['subject'],
						'message'          => $send_info['message'],
						'attachments'      => '',
						'attachments_cat'  => '',
						'dopurl'           => '',
						'static'           => $static,
						'unsub_url'        => '',
						'control_unsub'    => $control_unsubscribe,
						'limit_start'      => '',
						'limit_end'        => ''
					);
	
					$all_emails = $this->getAllEmails($data_send);
	
					if ($all_emails && $this->config->get('contacts_ignore_servers')) {
						$fi_emails = $all_emails;
						$config_ignore_servers = preg_replace('/\s/', '', $this->config->get('contacts_ignore_servers'));
	
						if ($config_ignore_servers != '') {
							$ignore_servers = explode('|', $this->config->get('contacts_ignore_servers'));

							if (!empty($ignore_servers)) {
								foreach($all_emails as $email => $value){
									$email_part = explode('@', $email);

									if (isset($email_part[1])) {
										$email_host = '@' . $email_part[1];
	
										if (in_array($email_host, array_map('trim', $ignore_servers))) {
											if (array_key_exists($email, $fi_emails)) {
												unset($fi_emails[$email]);
											}
										}
									}
								}
								$all_emails = $fi_emails;
							}
						}
					}
	
					$email_total = count($all_emails);
	
					$data_send['email_total'] = 0;
	
					if ($all_emails) {
						$cron_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						$this->model_contacts_ccrons->setDataNewSend($send_id, $data_send);
						$this->model_contacts_ccrons->saveEmailsToSend($send_id, $all_emails);
						if ($static != 'static') {
							$this->model_contacts_ccrons->delEmailsToCron($cron_id);
							$this->model_contacts_ccrons->saveEmailsToCron($cron_id, $all_emails);
						}
					} else {
						$error = true;
						$otcat_period = true;
						if ($static == 'static') {
							$date_next = false;
						}
					}
				}
	
				if (!$error) {
					$results = $this->model_contacts_ccrons->getEmailsToSend($send_id, $count_message);

					foreach ($results as $result) {
						$emails[$result['email']] = array();
					}
	
					$left_total = $this->model_contacts_ccrons->getTotalEmailsToSend($send_id);
				}
	
				if ($emails) {
					$lastsend = 0;
					$count_emails = count($emails);
					$count_send_error = $this->model_contacts_ccrons->getErrorsSend($send_id);
					$check_unsub = false;
					$check_delete = false;
	
					$data_ckresult = array(
						'cron_id'      => $cron_id,
						'check_text'   => '',
						'check_status' => '',
						'email'        => ''
					);

					if ($count_emails < $left_total) {
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

					foreach ($emails as $email => $value) {
						$data_ckresult['email'] = $email;
	
						if ($count_send_error < $count_error) {
							if ($this->checkValidEmail($email)) {
								if (count($senders) > 1) {
									$number = mt_rand(0, count($senders) - 1);
									$sender = $senders[$number];
								} else {
									$sender = $senders[0];
								}

								$mail = new Mail_CC();
								$mail->setTo($email);
								$mail->setFrom($sender);
	
								if ($this->config->get('contacts_debag_checklog')) {
									$mail->setDebag(1);
									$mail->setCronid($cron_id);
									$mail->setHistoryid($history_id);
								}
								
								if ($this->config->get('contacts_check_mode') == '2') {
									$mail->setMode(2);
								}

								$cron_log->write($this->language->get('text_check_email') . $email);
								$check_status = $mail->check_email();
	
								if ($check_status) {
									$status_arr = explode('|', $check_status);
									$check_text = $status_arr[0];
									$check_reply = isset($status_arr[1]) ? $status_arr[1] : '';
	
									$data_ckresult['check_text'] = $check_reply;
	
									if (substr($check_text, 0, 5) == 'error') {
										$cron_log->write($this->language->get('error_check_attention') . ' ' . $this->language->get('error_check_' . substr($check_text, 5, 2)) . ' ' . $this->language->get('text_continues_check') . ' (1100)');
										$this->model_contacts_ccrons->addErrorSend($send_id);
										$count_send_error++;
									} else {
										if (substr($check_text, 0, 5) == 'mcokk') {
											$data_ckresult['check_status'] = 1;
											$cron_log->write($this->language->get('result_check_' . substr($check_text, 5, 2)));
										}
	
										if (substr($check_text, 0, 5) == 'mcbad') {
											$data_ckresult['check_status'] = 3;
											$cron_log->write($this->language->get('result_check_' . substr($check_text, 5, 2)));
	
											if (trim($check_reply) == '') {
												$data_ckresult['check_text'] = $this->language->get('result_check_' . substr($check_text, 5, 2));
											}
	
											if ($send_info['embad_action'] == '1') {
												$check_unsub = true;
											}
											if ($send_info['embad_action'] == '2') {
												$check_unsub = true;
												$check_delete = true;
											}
										}
	
										if (substr($check_text, 0, 5) == 'mcsus') {
											$bad = false;
											$code = substr($check_text, 5, 2);
											$cron_log->write($this->language->get('result_check_' . $code));
	
											if ($code == '13') {
												if ($check_reply && $this->config->get('contacts_reply_badem')) {
													$reply_badem = explode('|', $this->config->get('contacts_reply_badem'));

													if (!empty($reply_badem)) {
														foreach ($reply_badem as $bad_reply) {
															$bad_text = trim($bad_reply);

															if ($bad_text != '') {
																$pos = stripos($check_reply, $bad_text);
																if ($pos !== false) {
																	$bad = true;
																	break;
																}
															}
														}
													}
												}
											}
	
											if ($bad) {
												$data_ckresult['check_status'] = 3;
												$cron_log->write($this->language->get('result_check_33'));
	
												if ($send_info['embad_action'] == '1') {
													$check_unsub = true;
												}
												if ($send_info['embad_action'] == '2') {
													$check_unsub = true;
													$check_delete = true;
												}
											} else {
												$data_ckresult['check_status'] = 4;
												$cron_log->write($this->language->get('result_check_44'));
	
												if ($send_info['emsuspect_action'] == '1') {
													$check_unsub = true;
												}
												if ($send_info['emsuspect_action'] == '2') {
													$check_unsub = true;
													$check_delete = true;
												}
											}
										}
									}
								} else {
									$cron_log->write($this->language->get('error_check_attention') . ' ' . $this->language->get('error_check_00') . ' ' . $this->language->get('text_continues_check') . ' (1101)');
									$this->model_contacts_ccrons->addErrorSend($send_id);
									$count_send_error++;
								}

							} else {
								$data_ckresult['check_status'] = 2;
								$cron_log->write($this->language->get('result_check_22'));
	
								if ($send_info['emnovalid_action'] == '1') {
									$check_unsub = true;
								}
								if ($send_info['emnovalid_action'] == '2') {
									$check_unsub = true;
									$check_delete = true;
								}
							}
	
							if ($data_ckresult['check_status']) {
								$send_email_total++;
								$this->model_contacts_ccrons->setCheckResult($data_ckresult);
								$this->model_contacts_ccrons->removeEmailSend($send_id, $email);
							}
							if ($check_unsub) {
								$this->model_contacts_ccrons->addUnsubscribe($email, $send_id);
							}
							if ($check_delete) {
								$this->model_contacts_ccrons->delNewsletterFromEmail($email);
							}
	
						} else {
							$otcat_hour = true;
							$cron_log->write($this->language->get('error_send_count') . ' (1150)');
							break;
						}
					}
	
					if ($otcat_hour) {
						$lastsend = 0;
						$next = false;
						$date_next = date('Y-m-d H:i:s', strtotime("+29 minutes"));
						$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4, $page);
						$this->model_contacts_ccrons->otcatCron($cron_id, $date_next, 1);
						$this->model_contacts_ccrons->ClearErrorsSend($send_id);
						$cron_log->write($this->language->get('text_otcat_hour') . ' (1120)');
					}
	
					if ($lastsend == 1) {
						$cron_log->write($this->language->get('text_end_send'));
						$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 2);
						if ($date_next) {
							$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
							$cron_log->write($this->language->get('text_otcat_period') . ' (1133)');
						} else {
							$this->model_contacts_ccrons->offCron($cron_id);
							$cron_log->write($this->language->get('text_off_cron') . ' (1136)');
						}
					}
	
					$this->model_contacts_ccrons->setCompleteCronSend($send_id, $send_email_total);
					if (!$lastsend) {
						$this->model_contacts_ccrons->setPageCron($cron_id, $page);
					}

				} else {
					$cron_log->write($this->language->get('error_noemails') . ' (1139)');
					$otcat_period = true;
				}
			} else {
				$crons_log->write($this->language->get('error_cronstop') . ' (1140)');
				$otcat_period = true;
				$send_email_total = 0;
			}
	
			if ($otcat_period) {
				$next = false;
				if ($date_next) {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 4);
					$this->model_contacts_ccrons->otcatCron($cron_id, $date_next);
					$crons_log->write($this->language->get('text_otcat_period') . ' (1157)');
				} else {
					$this->model_contacts_ccrons->stopCron($cron_id, $history_id, 3);
					$this->model_contacts_ccrons->offCron($cron_id);
					$crons_log->write($this->language->get('text_off_cron') . ' (1160)');
				}
				if (($page == 1) && ($send_id)) {
					$this->model_contacts_ccrons->delDataSend($send_id);
				}
				if ($send_id) {
					$this->model_contacts_ccrons->ClearErrorsSend($send_id);
				}
			}
	
			$this->model_contacts_ccrons->setCronHistory($history_id, $send_email_total);
	
			if ($next) {
				$step_data = array(
					'status'     => 1,
					'cron_id'    => $cron_id,
					'step'       => $next,
					'history_id' => $history_id
				);
				return $step_data;
			} else {
				if (!$otcat_period && !$otcat_hour) {
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
	
	private function getAllEmails($data = array()) {
		$emails = array();
	
		if ($data) {
			$this->load->model('contacts/ccrons');
	
			if (($data['static'] == 'static') || ($data['send_to'] == 'manual')) {
				$results = $this->model_contacts_ccrons->getEmailsToCron($data['cron_id']);
	
				foreach ($results as $result) {
					$email = preg_replace('/\s/', '', $result['email']);
					if ($email != '') {
						if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
							$emails[$email] = array(
								'customer_id'   => $result['customer_id'],
								'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
								'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
								'country'       => $result['country'],
								'zone'          => $result['zone'],
								'date_added'    => $result['date_added']
							);
						}
					}
				}
	
			} else {
				if ($data['send_to'] == 'newsletter') {
					$data['send_to'] = 'customer_all';
					$data['control_unsub'] = 1;
				}
	
				if ($data['send_to'] == 'customer') {
					$data['send_to'] = 'customer_select';
				}
	
				switch ($data['send_to']) {
					case 'customer_all':
						$customer_data = array(
							'filter_newsletter'  => $data['control_unsub'],
							'filter_store_id'    => $data['store_id'],
							'filter_country_id'  => $data['send_country_id'],
							'filter_zone_id'     => $data['send_zone_id'],
							'invers_region'      => $data['invers_region'],
							'filter_date_start'  => $data['date_start'],
							'filter_date_end'    => $data['date_end'],
							'filter_start'       => $data['limit_start'],
							'filter_limit'       => $data['limit_end']
						);

						$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
									$emails[$email] = array(
										'customer_id'   => $result['customer_id'],
										'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
										'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
										'country'       => $result['country'],
										'zone'          => $result['zone'],
										'date_added'    => $result['date_added']
									);
								}
							}
						}
						break;
					case 'customer_select':
						if (!empty($data['send_to_data'])) {
							$filter_customer_id = explode(',', $data['send_to_data']);

							$customer_data = array(
								'filter_newsletter'  => $data['control_unsub'],
								'filter_store_id'    => $data['store_id'],
								'filter_country_id'  => $data['send_country_id'],
								'filter_zone_id'     => $data['send_zone_id'],
								'invers_region'      => $data['invers_region'],
								'filter_customer_id' => $filter_customer_id,
								'invers_customer'    => $data['invers_customer'],
								'filter_date_start'  => $data['date_start'],
								'filter_date_end'    => $data['date_end']
							);

							$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);

							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
					case 'customer_group':
						if (!empty($data['send_to_data'])) {
							$filter_customer_group_id = explode(',', $data['send_to_data']);

							$customer_data = array(
								'filter_customer_group_id' => $filter_customer_group_id,
								'filter_store_id'          => $data['store_id'],
								'filter_country_id'        => $data['send_country_id'],
								'filter_zone_id'           => $data['send_zone_id'],
								'filter_newsletter'        => $data['control_unsub'],
								'invers_region'            => $data['invers_region'],
								'filter_date_start'        => $data['date_start'],
								'filter_date_end'          => $data['date_end'],
								'filter_start'             => $data['limit_start'],
								'filter_limit'             => $data['limit_end']
							);

							$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);

							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
					case 'customer_noorder':
						$customer_data = array(
							'filter_store_id'    => $data['store_id'],
							'filter_country_id'        => $data['send_country_id'],
							'filter_zone_id'           => $data['send_zone_id'],
							'filter_newsletter'        => $data['control_unsub'],
							'invers_region'            => $data['invers_region'],
							'filter_date_start'        => $data['date_start'],
							'filter_date_end'          => $data['date_end'],
							'filter_start'             => $data['limit_start'],
							'filter_limit'             => $data['limit_end'],
							'filter_noorder'           => 1
						);

						$results = $this->model_contacts_ccrons->getEmailCustomers($customer_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
									$emails[$email] = array(
										'customer_id'   => $result['customer_id'],
										'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
										'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
										'country'       => $result['country'],
										'zone'          => $result['zone'],
										'date_added'    => $result['date_added']
									);
								}
							}
						}
						break;
					case 'client_all':
						$client_data = array(
							'filter_store_id'    => $data['store_id'],
							'filter_country_id'  => $data['send_country_id'],
							'filter_zone_id'     => $data['send_zone_id'],
							'invers_region'      => $data['invers_region'],
							'filter_language_id' => $data['language_id'],
							'filter_date_start'  => $data['date_start'],
							'filter_date_end'    => $data['date_end'],
							'filter_start'       => $data['limit_start'],
							'filter_limit'       => $data['limit_end']
						);
	
						$results = $this->model_contacts_ccrons->getEmailsByOrdereds($client_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								$unsuber = false;
	
								if ($data['control_unsub']) {
									if ($this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
										$unsuber = true;
									} else {
										if ($result['customer_id'] && !$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id'])) {
											$unsuber = true;
										}
									}
								}
	
								if (!$unsuber) {
									$emails[$email] = array(
										'customer_id'   => $result['customer_id'],
										'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
										'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
										'country'       => $result['country'],
										'zone'          => $result['zone'],
										'date_added'    => $result['date_added']
									);
								}
							}
						}
						break;
					case 'client_select':
						if (!empty($data['send_to_data'])) {
							$filter_client = explode(',', $data['send_to_data']);

							$client_data = array(
								'filter_store_id'    => $data['store_id'],
								'filter_country_id'  => $data['send_country_id'],
								'filter_zone_id'     => $data['send_zone_id'],
								'invers_region'      => $data['invers_region'],
								'filter_client'      => $filter_client,
								'invers_client'      => $data['invers_client'],
								'filter_language_id' => $data['language_id'],
								'filter_date_start'  => $data['date_start'],
								'filter_date_end'    => $data['date_end']
							);
	
							$results = $this->model_contacts_ccrons->getEmailsByOrdereds($client_data);
	
							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									$unsuber = false;
	
									if ($data['control_unsub']) {
										if ($this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if ($result['customer_id'] && !$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id'])) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
					case 'client_group':
						if (!empty($data['send_to_data'])) {
							$filter_customer_group_id = explode(',', $data['send_to_data']);

							$client_data = array(
								'filter_customer_group_id' => $filter_customer_group_id,
								'filter_store_id'          => $data['store_id'],
								'filter_country_id'        => $data['send_country_id'],
								'filter_zone_id'           => $data['send_zone_id'],
								'invers_region'            => $data['invers_region'],
								'filter_language_id'       => $data['language_id'],
								'filter_date_start'        => $data['date_start'],
								'filter_date_end'          => $data['date_end'],
								'filter_start'             => $data['limit_start'],
								'filter_limit'             => $data['limit_end']
							);
	
							$results = $this->model_contacts_ccrons->getEmailsByOrdereds($client_data);
	
							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									$unsuber = false;
	
									if ($data['control_unsub']) {
										if ($this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if ($result['customer_id'] && !$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id'])) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
					case 'send_group':
						if (!empty($data['send_to_data'])) {
							$filter_group_id = explode(',', $data['send_to_data']);

							if (!$data['control_unsub']) {
								$data['control_unsub'] = null;
							}
	
							$customer_data = array(
								'filter_group_id'       => $filter_group_id,
								'filter_unsubscribe'    => $data['control_unsub'],
								'filter_start'          => $data['limit_start'],
								'filter_limit'          => $data['limit_end']
							);

							$results = $this->model_contacts_ccrons->getNewsletters($customer_data);
	
							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['cemail']);
								
								if (trim($result['firstname']) != '') {
									$firstname = $this->upCase($result['firstname']);
								} elseif (trim($result['nfirstname']) != '') {
									$firstname = $this->upCase($result['nfirstname']);
								} else {
									$firstname = '';
								}
								
								if (trim($result['lastname']) != '') {
									$lastname = $this->upCase($result['lastname']);
								} elseif (trim($result['nlastname']) != '') {
									$lastname = $this->upCase($result['nlastname']);
								} else {
									$lastname = '';
								}
								
								$emails[$email] = array(
									'customer_id'   => $result['customer_id'],
									'firstname'     => $firstname,
									'lastname'      => $lastname,
									'country'       => '',
									'zone'          => '',
									'date_added'    => ''
								);
							}
						}
						break;
					case 'affiliate_all':
						$affiliate_data = array(
							'filter_country_id'  => $data['send_country_id'],
							'filter_zone_id'     => $data['send_zone_id'],
							'invers_region'      => $data['invers_region'],
							'filter_date_start'  => $data['date_start'],
							'filter_date_end'    => $data['date_end'],
							'filter_start'       => $data['limit_start'],
							'filter_limit'       => $data['limit_end']
						);
	
						$results = $this->model_contacts_ccrons->getEmailAffiliates($affiliate_data);
	
						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
									$emails[$email] = array(
										'customer_id'   => '',
										'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
										'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
										'country'       => $result['country'],
										'zone'          => $result['zone'],
										'date_added'    => ''
									);
								}
							}
						}
						break;
					case 'affiliate':
						if (!empty($data['send_to_data'])) {
							$filter_affiliate_id = explode(',', $data['send_to_data']);

							$affiliate_data = array(
								'filter_country_id'   => $data['send_country_id'],
								'filter_zone_id'      => $data['send_zone_id'],
								'invers_region'       => $data['invers_region'],
								'filter_affiliate_id' => $filter_affiliate_id,
								'invers_affiliate'    => $data['invers_affiliate'],
								'filter_date_start'   => $data['date_start'],
								'filter_date_end'     => $data['date_end']
							);
	
							$results = $this->model_contacts_ccrons->getEmailAffiliates($affiliate_data);
	
							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									if (!$data['control_unsub'] || !$this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
										$emails[$email] = array(
											'customer_id'   => '',
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => ''
										);
									}
								}
							}
						}
						break;
					case 'product':
						if (!empty($data['send_to_data'])) {
							$filter_products = explode(',', $data['send_to_data']);

							$product_data = array(
								'filter_products'    => $filter_products,
								'filter_store_id'    => $data['store_id'],
								'filter_country_id'  => $data['send_country_id'],
								'filter_zone_id'     => $data['send_zone_id'],
								'invers_region'      => $data['invers_region'],
								'invers_product'     => $data['invers_product'],
								'filter_language_id' => $data['language_id'],
								'filter_date_start'  => $data['date_start'],
								'filter_date_end'    => $data['date_end'],
								'filter_start'       => $data['limit_start'],
								'filter_limit'       => $data['limit_end']
							);

							$results = $this->model_contacts_ccrons->getEmailsByOrdereds($product_data);

							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									$unsuber = false;
	
									if ($data['control_unsub']) {
										if ($this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if ($result['customer_id'] && !$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id'])) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
					case 'category':
						if (!empty($data['send_to_data'])) {
							$filter_category = explode(',', $data['send_to_data']);

							$product_data = array(
								'filter_category'      => $filter_category,
								'filter_store_id'      => $data['store_id'],
								'filter_country_id'    => $data['send_country_id'],
								'filter_zone_id'       => $data['send_zone_id'],
								'invers_region'        => $data['invers_region'],
								'invers_category'      => $data['invers_category'],
								'filter_language_id'   => $data['language_id'],
								'filter_date_start'    => $data['date_start'],
								'filter_date_end'      => $data['date_end'],
								'filter_start'         => $data['limit_start'],
								'filter_limit'         => $data['limit_end']
							);

							$results = $this->model_contacts_ccrons->getEmailsByOrdereds($product_data);

							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									$unsuber = false;
	
									if ($data['control_unsub']) {
										if ($this->model_contacts_ccrons->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if ($result['customer_id'] && !$this->model_contacts_ccrons->checkCustomerNewsletter($result['customer_id'])) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										$emails[$email] = array(
											'customer_id'   => $result['customer_id'],
											'firstname'     => (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '',
											'lastname'      => (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '',
											'country'       => $result['country'],
											'zone'          => $result['zone'],
											'date_added'    => $result['date_added']
										);
									}
								}
							}
						}
						break;
				}
			}
		}
		return $emails;
	}
	
	private function getMailProducts($results) {
		$products = array();
	
		if ($this->config->get('contacts_product_currency')) {
			$currency = $this->config->get('contacts_product_currency');
		} else {
			$currency = $this->config->get('config_currency');
		}
	
		$this->load->model('tool/image');
	
		if ($this->config->get('contacts_pimage_width')) {
			$iwidth = $this->config->get('contacts_pimage_width');
		} else {
			$iwidth = 150;
		}
	
		if ($this->config->get('contacts_pimage_height')) {
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

			if ((float)$result['special'] && (float)$result['price']) {
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
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'], 'SSL')
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
	
	public function upCase($str) {
		if (extension_loaded('mbstring')) {
			$str = mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
		} else {
			$str_upp = utf8_strtoupper($str);
			$str_low = utf8_strtolower($str);
	
			$str_f = utf8_substr($str_upp, 0, 1);
			$str_l = utf8_substr($str_low, 1);
			
			$str = $str_f . $str_l;
		}
		
		return $str;
	}
}
?>
<?php 
class ControllerSaleContacts extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
	
		if (!$this->config->get('contacts_reply_badem')) {
			$this->model_sale_contacts->insertTableBase();
			$this->redirect($this->url->link('sale/contacts', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/contactsa.css');
		$this->document->addStyle('view/javascript/jquery/colorbox/colorbox.css');
		
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['license'] = $this->model_sale_contacts->checkLicense();
		
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_customer_all'] = $this->language->get('text_customer_all');
		$this->data['text_customer_select'] = $this->language->get('text_customer_select');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_customer_noorder'] = $this->language->get('text_customer_noorder');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_client_all'] = $this->language->get('text_client_all');
		$this->data['text_client_select'] = $this->language->get('text_client_select');
		$this->data['text_client_group'] = $this->language->get('text_client_group');
		$this->data['text_send_group'] = $this->language->get('text_send_group');
		$this->data['text_affiliate_all'] = $this->language->get('text_affiliate_all');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_manual'] = $this->language->get('text_manual');
		$this->data['text_fnewsletter'] = $this->language->get('text_fnewsletter');
		$this->data['text_fcustomer_all'] = $this->language->get('text_fcustomer_all');
		$this->data['text_fcustomer_select'] = $this->language->get('text_fcustomer_select');
		$this->data['text_fcustomer_group'] = $this->language->get('text_fcustomer_group');
		$this->data['text_fcustomer_noorder'] = $this->language->get('text_fcustomer_noorder');
		$this->data['text_fcustomer'] = $this->language->get('text_fcustomer');
		$this->data['text_fclient_all'] = $this->language->get('text_fclient_all');
		$this->data['text_fclient_select'] = $this->language->get('text_fclient_select');
		$this->data['text_fclient_group'] = $this->language->get('text_fclient_group');
		$this->data['text_fsend_group'] = $this->language->get('text_fsend_group');
		$this->data['text_faffiliate_all'] = $this->language->get('text_faffiliate_all');
		$this->data['text_faffiliate'] = $this->language->get('text_faffiliate');
		$this->data['text_fproduct'] = $this->language->get('text_fproduct');
		$this->data['text_fcategory'] = $this->language->get('text_fcategory');
		$this->data['text_fmanual'] = $this->language->get('text_fmanual');
		$this->data['text_sql_manual'] = $this->language->get('text_sql_manual');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_close'] = $this->language->get('text_close');
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		$this->data['text_new_newsletters'] = $this->language->get('text_new_newsletters');
		$this->data['text_new_group'] = $this->language->get('text_new_group');
		$this->data['text_start_import'] = $this->language->get('text_start_import');
		$this->data['text_move_newsletters'] = $this->language->get('text_move_newsletters');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['text_run'] = $this->language->get('text_run');
		$this->data['text_new_template'] = $this->language->get('text_new_template');
		$this->data['text_group_edit'] = $this->language->get('text_group_edit');
		$this->data['text_error_license'] = $this->language->get('text_error_license');
		$this->data['text_version'] = $this->language->get('text_version');
		$this->data['text_dinamic'] = $this->language->get('text_dinamic');
		$this->data['text_static'] = $this->language->get('text_static');
		$this->data['text_nothing'] = $this->language->get('text_nothing');
		$this->data['text_unsubs'] = $this->language->get('text_unsubs');
		$this->data['text_unsubs_ok'] = $this->language->get('text_unsubs_ok');
		$this->data['text_unsub_remove'] = $this->language->get('text_unsub_remove');
		$this->data['text_check_info'] = $this->language->get('text_check_info');
		$this->data['text_pop_info'] = $this->language->get('text_pop_info');
		$this->data['text_limit_hour'] = $this->language->get('text_limit_hour');
		$this->data['text_limit_day'] = $this->language->get('text_limit_day');
		$this->data['text_check_mode1'] = $this->language->get('text_check_mode1');
		$this->data['text_check_mode2'] = $this->language->get('text_check_mode2');
		
		$this->data['error_close'] = $this->language->get('error_close');
		$this->data['editor_mode_alert'] = $this->language->get('editor_mode_alert');
	
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_to'] = $this->language->get('entry_to');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_send_group'] = $this->language->get('entry_send_group');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_manual'] = $this->language->get('entry_manual');
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_message'] = $this->language->get('entry_message');
		$this->data['entry_from_newsletter'] = $this->language->get('entry_from_newsletter');
		$this->data['entry_for_group'] = $this->language->get('entry_for_group');
		$this->data['entry_sql_table'] = $this->language->get('entry_sql_table');
		$this->data['entry_sql_email'] = $this->language->get('entry_sql_email');
		$this->data['entry_sql_firstname'] = $this->language->get('entry_sql_firstname');
		$this->data['entry_sql_lastname'] = $this->language->get('entry_sql_lastname');
		$this->data['entry_template_name'] = $this->language->get('entry_template_name');
		$this->data['entry_group_name'] = $this->language->get('entry_group_name');
		$this->data['entry_group_description'] = $this->language->get('entry_group_description');
		$this->data['entry_move_ingroup'] = $this->language->get('entry_move_ingroup');
		$this->data['entry_inversion'] = $this->language->get('entry_inversion');
		$this->data['entry_dopurl'] = $this->language->get('entry_dopurl');
		$this->data['entry_cron_name'] = $this->language->get('entry_cron_name');
		$this->data['entry_cron_start'] = $this->language->get('entry_cron_start');
		$this->data['entry_cron_period'] = $this->language->get('entry_cron_period');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_to_check'] = $this->language->get('entry_to_check');
		$this->data['entry_checke_unsub'] = $this->language->get('entry_checke_unsub');
		$this->data['entry_emnovalid_action'] = $this->language->get('entry_emnovalid_action');
		$this->data['entry_embad_action'] = $this->language->get('entry_embad_action');
		$this->data['entry_emsuspect_action'] = $this->language->get('entry_emsuspect_action');
		
		$this->data['help_icon'] = $this->language->get('help_icon');
		$this->data['help_embad'] = $this->language->get('help_embad');
		$this->data['help_emnovalid'] = $this->language->get('help_emnovalid');
		$this->data['help_emsuspect'] = $this->language->get('help_emsuspect');
		$this->data['help_emremove'] = $this->language->get('help_emremove');
		$this->data['help_dopurl'] = $this->language->get('help_dopurl');
		$this->data['help_retpath'] = $this->language->get('help_retpath');
		$this->data['help_subject'] = $this->language->get('help_subject');
		$this->data['help_cron_url'] = $this->language->get('help_cron_url');
		$this->data['help_bad_eaction'] = $this->language->get('help_bad_eaction');

		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_check'] = $this->language->get('button_check');
		$this->data['button_cron'] = $this->language->get('button_cron');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_dellog'] = $this->language->get('button_dellog');
		$this->data['button_check_mode2'] = $this->language->get('button_check_mode2');
		
		$this->data['tab_send'] = $this->language->get('tab_send');
		$this->data['tab_template'] = $this->language->get('tab_template');
		$this->data['tab_groups'] = $this->language->get('tab_groups');
		$this->data['tab_newsletters'] = $this->language->get('tab_newsletters');
		$this->data['tab_checkmails'] = $this->language->get('tab_checkmails');
		$this->data['tab_crons'] = $this->language->get('tab_crons');
		$this->data['tab_log'] = $this->language->get('tab_log');
		$this->data['tab_statistics'] = $this->language->get('tab_statistics');
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		$this->data['tab_mails'] = $this->language->get('tab_mails');
		
		$this->data['token'] = $this->session->data['token'];

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/contacts', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['cancel'] = $this->url->link('sale/contacts', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['total_mails_alarm'] = false;
		$this->data['total_mails_hour'] = false;
		$this->data['total_mails_day'] = false;
	
		if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
			$total_mails = $this->model_sale_contacts->getCountMails();
			
			$this->data['total_mails_hour'] = $this->config->get('contacts_global_limith') - $total_mails['hour'];
			$this->data['total_mails_day'] = $this->config->get('contacts_global_limitd') - $total_mails['day'];
			
			if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
				$this->data['total_mails_alarm'] = true;
			}
			if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
				$this->data['total_mails_alarm'] = true;
			}
		}
		
		// Send //
		$this->data['text_info_panel'] = $this->language->get('text_info_panel');
		$this->data['text_tegi'] = $this->language->get('text_tegi');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');
		
		$this->data['text_save_template'] = $this->language->get('text_save_template');
		$this->data['text_template_name'] = $this->language->get('text_template_name');
		
		$this->data['entry_period'] = $this->language->get('entry_period');
		$this->data['entry_period_start'] = $this->language->get('entry_period_start');
		$this->data['entry_period_end'] = $this->language->get('entry_period_end');
		$this->data['entry_limit_emails'] = $this->language->get('entry_limit_emails');
		$this->data['entry_limit_start'] = $this->language->get('entry_limit_start');
		$this->data['entry_limit_end'] = $this->language->get('entry_limit_end');
		$this->data['entry_region'] = $this->language->get('entry_region');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_unsubscribe'] = $this->language->get('entry_unsubscribe');
		$this->data['entry_contrl_unsub'] = $this->language->get('entry_contrl_unsub');
		$this->data['entry_insert_products'] = $this->language->get('entry_insert_products');
		$this->data['entry_special'] = $this->language->get('entry_special');
		$this->data['entry_bestseller'] = $this->language->get('entry_bestseller');
		$this->data['entry_featured'] = $this->language->get('entry_featured');
		$this->data['entry_latest'] = $this->language->get('entry_latest');
		$this->data['entry_selected'] = $this->language->get('entry_selected');
		$this->data['entry_pselected'] = $this->language->get('entry_pselected');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_catselected'] = $this->language->get('entry_catselected');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_each'] = $this->language->get('entry_each');
		$this->data['entry_attach'] = $this->language->get('entry_attach');
		$this->data['entry_attach_cat'] = $this->language->get('entry_attach_cat');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_static'] = $this->language->get('entry_static');
		$this->data['entry_purchased'] = $this->language->get('entry_purchased');
		$this->data['entry_planguage'] = $this->language->get('entry_planguage');
		
		$this->data['entry_planguage'] = $this->language->get('entry_planguage');

		$this->data['help_dinamic'] = $this->language->get('help_dinamic');
		$this->data['help_static'] = $this->language->get('help_static');
		
		$this->data['spravka_static'] = $this->language->get('spravka_static');
		$this->data['spravka_tegi'] = $this->language->get('spravka_tegi');
		
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
		
		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		
		$this->data['default_country_id'] = $this->config->get('config_country_id');
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (VERSION >= '1.5.5.1') {
			$this->data['categories'] = $this->model_sale_contacts->getAllsCategories();
		} else {
			$this->load->model('catalog/category');
			$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		}
		$this->data['templates'] = $this->model_sale_contacts->getTemplates();
		$this->data['groups'] = $this->model_sale_contacts->getSendGroups();

		$this->data['control_unsubscribe'] = true;
		// Send //

		// MissingSend //
		$this->data['button_missresend'] = $this->language->get('button_missresend');
		$this->data['button_missremove'] = $this->language->get('button_missremove');
		$this->data['button_misstocomplete'] = $this->language->get('button_misstocomplete');
		$this->data['button_missclose'] = $this->language->get('button_missclose');
		$this->data['button_close'] = $this->language->get('button_close');
		
		$this->data['missing_send'] = array();
		$missing_send = $this->model_sale_contacts->getMissingDataSend();
		
		if ($missing_send) {
			foreach ($missing_send as $msend) {
				$count_miss_emails = $this->model_sale_contacts->getTotalEmailsToSend($msend['send_id']);
				
				$this->data['missing_send'][] = array(
					'send_id'    => $msend['send_id'],
					'send_alarm' => $this->language->get('missins_send_alarm'),
					'send_date'  => sprintf($this->language->get('missins_send_date'), $msend['date_added']),
					'send_title' => sprintf($this->language->get('missins_send_title'), utf8_substr(html_entity_decode($msend['subject'], ENT_QUOTES, 'UTF-8'), 0, 35) . '..'),
					'send_to'    => sprintf($this->language->get('missins_send_to'), $this->language->get('text_' . $msend['send_to'])),
					'send_count' => sprintf($this->language->get('missins_send_count'), $count_miss_emails, $msend['email_total'])
				);
			}
		}
		// MissingSend //
		
		// RunCrons //
		$this->data['run_crons'] = array();
		$run_crons = $this->model_sale_contacts->getRunCron();
		
		if ($run_crons) {
			foreach ($run_crons as $run_cron) {
				$cron_info = $this->model_sale_contacts->getCron($run_cron['cron_id']);
				if ($cron_info) {
					$cron_name = $cron_info['name'];
					
					$data['run_crons'][] = array(
						'cron_id'    => $run_cron['cron_id'],
						'cron_alarm' => sprintf($this->language->get('cron_send_alarm'), $run_cron['cron_id']),
						'cron_title' => sprintf($this->language->get('cron_send_title'), html_entity_decode($cron_name, ENT_QUOTES, 'UTF-8'))
					);
				}
			}
		}
		// RunCrons //
		
		// log //		
		$file = DIR_LOGS . 'contacts.log';
		
		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['log'] = '';
		}
		// log //
		
		// Settintg //
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_mail_real_limit'] = $this->language->get('entry_mail_real_limit');
		$this->data['entry_mail_global_limit'] = $this->language->get('entry_mail_global_limit');
		$this->data['entry_mail_from'] = $this->language->get('entry_mail_from');
		$this->data['entry_mail_fromname'] = $this->language->get('entry_mail_fromname');
		$this->data['entry_email_pattern'] = $this->language->get('entry_email_pattern');
		$this->data['entry_mail_count_error'] = $this->language->get('entry_mail_count_error');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_product_currency'] = $this->language->get('entry_product_currency');
		$this->data['entry_admin_limit'] = $this->language->get('entry_admin_limit');
		$this->data['entry_allow_sendcron'] = $this->language->get('entry_allow_sendcron');
		$this->data['entry_allow_cronsend'] = $this->language->get('entry_allow_cronsend');
		$this->data['entry_cron_url'] = $this->language->get('entry_cron_url');
		$this->data['entry_reply_badem'] = $this->language->get('entry_reply_badem');
		$this->data['entry_ignore_servers'] = $this->language->get('entry_ignore_servers');
		$this->data['entry_debag_checklog'] = $this->language->get('entry_debag_checklog');
		$this->data['entry_spamtest_url'] = $this->language->get('entry_spamtest_url');
		$this->data['entry_skip_price0'] = $this->language->get('entry_skip_price0');
		$this->data['entry_skip_qty0'] = $this->language->get('entry_skip_qty0');
		$this->data['entry_add_listid'] = $this->language->get('entry_add_listid');
		$this->data['entry_add_precedence'] = $this->language->get('entry_add_precedence');
		$this->data['entry_retpath_email'] = $this->language->get('entry_retpath_email');
		$this->data['entry_pop_hostname'] = $this->language->get('entry_pop_hostname');
		$this->data['entry_pop_username'] = $this->language->get('entry_pop_username');
		$this->data['entry_pop_password'] = $this->language->get('entry_pop_password');
		$this->data['entry_pop_port'] = $this->language->get('entry_pop_port');
		$this->data['entry_pop_timeout'] = $this->language->get('entry_pop_timeout');
		$this->data['entry_pop_qty'] = $this->language->get('entry_pop_qty');
		$this->data['entry_check_mode'] = $this->language->get('entry_check_mode');
		$this->data['entry_recomen_mask'] = $this->language->get('entry_recomen_mask');
		$this->data['entry_bad_eaction'] = $this->language->get('entry_bad_eaction');
		$this->data['entry_client_status'] = $this->language->get('entry_client_status');
		$this->data['entry_mail_cron_limit'] = $this->language->get('entry_mail_cron_limit');
		$this->data['help_cron_limit'] = $this->language->get('help_cron_limit');
		$this->data['entry_sort_purchased'] = $this->language->get('entry_sort_purchased');
		
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		$this->data['text_complete_status'] = $this->language->get('text_complete_status');
		$this->data['text_time_asc'] = $this->language->get('text_time_asc');
		$this->data['text_time_desc'] = $this->language->get('text_time_desc');
		$this->data['text_price_asc'] = $this->language->get('text_price_asc');
		$this->data['text_price_desc'] = $this->language->get('text_price_desc');
		
		$this->data['contacts_recomen_mask'] = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,15}$/i';
		
		$this->data['tab_ssmtp'] = $this->language->get('tab_ssmtp');
		$this->data['tab_sprod'] = $this->language->get('tab_sprod');
		$this->data['tab_scheck'] = $this->language->get('tab_scheck');
		$this->data['tab_spop'] = $this->language->get('tab_spop');
		$this->data['tab_sdata'] = $this->language->get('tab_sdata');
		
		$this->load->model('localisation/currency');
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
		
		if ($this->config->get('contacts_mail_protocol') && ($this->config->get('contacts_mail_protocol') != '')) {
			$this->data['contacts_mail_protocol'] = $this->config->get('contacts_mail_protocol');
		} else {
			$this->data['contacts_mail_protocol'] = 'mail';
		}
		
		if ($this->config->get('contacts_mail_from') && ($this->config->get('contacts_mail_from') != '')) {
			$this->data['contacts_mail_from'] = $this->config->get('contacts_mail_from');
		} else {
			$this->data['contacts_mail_from'] = $this->config->get('config_email');
		}
		
		if ($this->config->get('contacts_mail_fromname') && ($this->config->get('contacts_mail_fromname') != '')) {
			$this->data['contacts_mail_fromname'] = $this->config->get('contacts_mail_fromname');
		} else {
			$this->data['contacts_mail_fromname'] = $this->config->get('config_name');
		}
		
		if ($this->config->get('contacts_mail_parameter')) {
			$this->data['contacts_mail_parameter'] = $this->config->get('contacts_mail_parameter');
		} else {
			$this->data['contacts_mail_parameter'] = '';
		}

		if ($this->config->get('contacts_smtp_host')) {
			$this->data['contacts_smtp_host'] = $this->config->get('contacts_smtp_host');
		} else {
			$this->data['contacts_smtp_host'] = '';
		}

		if ($this->config->get('contacts_smtp_username')) {
			$this->data['contacts_smtp_username'] = $this->config->get('contacts_smtp_username');
		} else {
			$this->data['contacts_smtp_username'] = '';
		}
		
		if ($this->config->get('contacts_smtp_password')) {
			$this->data['contacts_smtp_password'] = $this->config->get('contacts_smtp_password');
		} else {
			$this->data['contacts_smtp_password'] = '';
		}
		
		if ($this->config->get('contacts_smtp_port') && ($this->config->get('contacts_smtp_port') > 0)) {
			$this->data['contacts_smtp_port'] = $this->config->get('contacts_smtp_port');
		} else {
			$this->data['contacts_smtp_port'] = 25;
		}
		
		if ($this->config->get('contacts_smtp_timeout') && ($this->config->get('contacts_smtp_timeout') > 0)) {
			$this->data['contacts_smtp_timeout'] = $this->config->get('contacts_smtp_timeout');
		} else {
			$this->data['contacts_smtp_timeout'] = 5;	
		}
		
		if ($this->config->get('contacts_count_message') && ($this->config->get('contacts_count_message') > 0)) {
			$this->data['contacts_count_message'] = $this->config->get('contacts_count_message');
		} else {
			$this->data['contacts_count_message'] = 1;
		}
		
		if ($this->config->get('contacts_sleep_time') && ($this->config->get('contacts_sleep_time') > 0)) {
			$this->data['contacts_sleep_time'] = $this->config->get('contacts_sleep_time');
		} else {
			$this->data['contacts_sleep_time'] = 4;
		}
		
		if ($this->config->get('contacts_global_limith') && ($this->config->get('contacts_global_limith') > 0)) {
			$this->data['contacts_global_limith'] = $this->config->get('contacts_global_limith');
		} else {
			$this->data['contacts_global_limith'] = 0;
		}
		
		if ($this->config->get('contacts_global_limitd') && ($this->config->get('contacts_global_limitd') > 0)) {
			$this->data['contacts_global_limitd'] = $this->config->get('contacts_global_limitd');
		} else {
			$this->data['contacts_global_limitd'] = 0;
		}

		$cron_limit = $this->model_sale_contacts->getCronlimit($this->data['contacts_global_limith']);
	
		$this->data['contacts_cron_limit'] = $cron_limit['limit'];
		$this->data['contacts_cron_step'] = $cron_limit['step'];
		
		if ($this->config->get('contacts_count_send_error') && ($this->config->get('contacts_count_send_error') > 0)) {
			$this->data['contacts_count_send_error'] = $this->config->get('contacts_count_send_error');
		} else {
			$this->data['contacts_count_send_error'] = 10;
		}
		
		if ($this->config->get('contacts_email_pattern')) {
			$this->data['contacts_email_pattern'] = $this->config->get('contacts_email_pattern');
		} else {
			$this->data['contacts_email_pattern'] = '';
		}
		
		if ($this->data['contacts_email_pattern'] != $this->data['contacts_recomen_mask']) {
			$this->data['alarm_email_pattern'] = $this->language->get('text_alarm_email_pattern');
		} else {
			$this->data['alarm_email_pattern'] = '';
		}
		
		if ($this->config->get('contacts_pimage_width') && ($this->config->get('contacts_pimage_width') > 0)) {
			$this->data['contacts_pimage_width'] = $this->config->get('contacts_pimage_width');
		} else {
			$this->data['contacts_pimage_width'] = 150;
		}
		
		if ($this->config->get('contacts_pimage_height') && ($this->config->get('contacts_pimage_height') > 0)) {
			$this->data['contacts_pimage_height'] = $this->config->get('contacts_pimage_height');
		} else {
			$this->data['contacts_pimage_height'] = 150;
		}
		
		if ($this->config->get('contacts_product_currency')) {
			$this->data['contacts_product_currency'] = $this->config->get('contacts_product_currency');
		} else {
			$this->data['contacts_product_currency'] = $this->config->get('config_currency');
		}
		
		if ($this->config->get('contacts_skip_price0')) {
			$this->data['contacts_skip_price0'] = $this->config->get('contacts_skip_price0');
		} else {
			$this->data['contacts_skip_price0'] = '';
		}
		
		if ($this->config->get('contacts_skip_qty0')) {
			$this->data['contacts_skip_qty0'] = $this->config->get('contacts_skip_qty0');
		} else {
			$this->data['contacts_skip_qty0'] = '';
		}

		$this->data['contacts_sort_purchased_first'] = $this->config->get('contacts_sort_purchased_first') ? $this->config->get('contacts_sort_purchased_first') : 'DESC';
		$this->data['contacts_sort_purchased_last'] = $this->config->get('contacts_sort_purchased_last') ? $this->config->get('contacts_sort_purchased_last') : 'DESC';
	
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$this->data['contacts_admin_limit'] = $this->config->get('contacts_admin_limit');
		} else {
			$this->data['contacts_admin_limit'] = 10;
		}
		
		if ($this->config->get('contacts_allow_sendcron')) {
			$this->data['contacts_allow_sendcron'] = $this->config->get('contacts_allow_sendcron');
		} else {
			$this->data['contacts_allow_sendcron'] = '';
		}
		
		if ($this->config->get('contacts_allow_cronsend')) {
			$this->data['contacts_allow_cronsend'] = $this->config->get('contacts_allow_cronsend');
		} else {
			$this->data['contacts_allow_cronsend'] = '';
		}
		
		if ($this->config->get('contacts_add_listid')) {
			$this->data['contacts_add_listid'] = $this->config->get('contacts_add_listid');
		} else {
			$this->data['contacts_add_listid'] = '';
		}
		
		$this->data['precedences'] = array('bulk','junk','list');
		
		if ($this->config->get('contacts_add_precedence')) {
			$this->data['contacts_add_precedence'] = $this->config->get('contacts_add_precedence');
		} else {
			$this->data['contacts_add_precedence'] = '';
		}
		
		if ($this->config->get('contacts_retpath_email')) {
			$this->data['contacts_retpath_email'] = $this->config->get('contacts_retpath_email');
		} else {
			$this->data['contacts_retpath_email'] = '';
		}
		
		$this->data['bad_eactions'] = array();
		$this->data['bad_eactions'][0] = $this->language->get('text_none');
		$this->data['bad_eactions'][1] = $this->language->get('text_unsubs');
		$this->data['bad_eactions'][2] = $this->language->get('text_unsub_remove');
		
		if ($this->config->get('contacts_bad_eaction')) {
			$this->data['contacts_bad_eaction'] = $this->config->get('contacts_bad_eaction');
		} else {
			$this->data['contacts_bad_eaction'] = '0';
		}
		
		if ($this->config->get('contacts_client_status')) {
			$this->data['contacts_client_status'] = $this->config->get('contacts_client_status');
		} else {
			$this->data['contacts_client_status'] = '0';
		}
		
		if ($this->config->get('contacts_check_mode')) {
			$this->data['contacts_check_mode'] = $this->config->get('contacts_check_mode');
		} else {
			$this->data['contacts_check_mode'] = '1';
		}
		
		if ($this->config->get('contacts_reply_badem')) {
			$this->data['contacts_reply_badem'] = $this->config->get('contacts_reply_badem');
		} else {
			$this->data['contacts_reply_badem'] = '';
		}
		
		if ($this->config->get('contacts_ignore_servers')) {
			$this->data['contacts_ignore_servers'] = $this->config->get('contacts_ignore_servers');
		} else {
			$this->data['contacts_ignore_servers'] = '';
		}
		
		if ($this->config->get('contacts_debag_checklog')) {
			$this->data['contacts_debag_checklog'] = $this->config->get('contacts_debag_checklog');
		} else {
			$this->data['contacts_debag_checklog'] = '';
		}
		
		if ($this->config->get('contacts_spamtest_url')) {
			$this->data['contacts_spamtest_url'] = $this->config->get('contacts_spamtest_url');
		} else {
			$this->data['contacts_spamtest_url'] = 'www.mail-tester.com';
		}
		
		if ($this->config->get('contacts_pop_hostname')) {
			$this->data['contacts_pop_hostname'] = $this->config->get('contacts_pop_hostname');
		} else {
			$this->data['contacts_pop_hostname'] = '';
		}

		if ($this->config->get('contacts_pop_username')) {
			$this->data['contacts_pop_username'] = $this->config->get('contacts_pop_username');
		} else {
			$this->data['contacts_pop_username'] = '';
		}
		
		if ($this->config->get('contacts_pop_password')) {
			$this->data['contacts_pop_password'] = $this->config->get('contacts_pop_password');
		} else {
			$this->data['contacts_pop_password'] = '';
		}
		
		if ($this->config->get('contacts_pop_port') && ($this->config->get('contacts_pop_port') > 0)) {
			$this->data['contacts_pop_port'] = $this->config->get('contacts_pop_port');
		} else {
			$this->data['contacts_pop_port'] = 110;
		}
		
		if ($this->config->get('contacts_pop_timeout') && ($this->config->get('contacts_pop_timeout') > 0)) {
			$this->data['contacts_pop_timeout'] = $this->config->get('contacts_pop_timeout');
		} else {
			$this->data['contacts_pop_timeout'] = 5;
		}
		
		if ($this->config->get('contacts_pop_qty') && ($this->config->get('contacts_pop_qty') > 0)) {
			$this->data['contacts_pop_qty'] = $this->config->get('contacts_pop_qty');
		} else {
			$this->data['contacts_pop_qty'] = 100;
		}
		
		$url_replace = array('http://','https://');
		$url_admin = str_ireplace($url_replace, '', HTTP_SERVER);
		$url_catalog = str_ireplace($url_replace, '', HTTP_CATALOG);
	
		$this->data['cron_url'] = str_replace($url_admin, $url_catalog, $this->url->link('feed/ccrons', 'cont=' . $this->config->get('contacts_unsub_pattern')));
		$this->data['help_cron_url'] = sprintf($this->language->get('help_cron_url'), $this->data['contacts_cron_step']);
		
		if ($this->data['contacts_cron_step'] > 1) {
			$this->data['help_cron_url'] .= $this->language->get('text_minutes');
		} else {
			$this->data['help_cron_url'] .= $this->language->get('text_minute');
		}

		$this->cache->delete('contacts');

		$this->template = 'sale/contacts.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	public function crons() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		$this->load->model('localisation/language');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');
		
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_period'] = $this->language->get('column_period');
		$this->data['column_date_next'] = $this->language->get('column_date_next');
		$this->data['column_cron_name'] = $this->language->get('column_cron_name');
		$this->data['column_send_to'] = $this->language->get('column_send_to');
		$this->data['column_static'] = $this->language->get('column_static');
		$this->data['column_email_total'] = $this->language->get('column_email_total');
		$this->data['column_send_total'] = $this->language->get('column_send_total');
		$this->data['column_cron_count'] = $this->language->get('column_cron_count');
		$this->data['column_cron_status'] = $this->language->get('column_cron_status');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_region'] = $this->language->get('column_region');
		$this->data['column_products'] = $this->language->get('column_products');
		$this->data['column_attachments'] = $this->language->get('column_attachments');
		$this->data['column_unsub_url'] = $this->language->get('column_unsub_url');
		$this->data['column_control_unsub'] = $this->language->get('column_control_unsub');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_view_logs'] = $this->language->get('text_view_logs');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_disable'] = $this->language->get('text_disable');
		$this->data['text_static'] = $this->language->get('text_static');
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'cron_id';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
		$lid = $this->config->get('config_language_id') ? $this->config->get('config_language_id') : 1;
		
		$this->data['crons'] = array();
		
		$data = array(
			'sort'     => $sort,
			'order'    => $order,
			'start'    => ($page - 1) * $contacts_admin_limit,
			'limit'    => $contacts_admin_limit
		);

		$crons = $this->model_sale_contacts->getCrons($data);
		
		$crons_total = $this->model_sale_contacts->getTotalCrons();
		
		if (!empty($crons)) {
			$this->load->model('sale/customer_group');
			
			foreach ($crons as $cron) {
				if ($cron['status']) {
					$status_text = $this->language->get('text_status_on');
				} else {
					$status_text = $this->language->get('text_status_off');
				}
				
				$send_to = '';
				$send_data = '';
				
				$cron_info = $this->model_sale_contacts->getDataCron($cron['cron_id']);
				
				if (!empty($cron_info)) {
					$send_to = $this->language->get('text_' . $cron_info['send_to']);
					
					if ($cron_info['send_to'] == 'customer_group') {
						$mcustomer_groups = explode(',', $cron_info['send_to_data']);
						$send_datas = array();
						
						foreach($mcustomer_groups as $mcustomer_group) {
							$group_info = $this->model_sale_customer_group->getCustomerGroupDescriptions($mcustomer_group);
							
							if (!empty($group_info) && isset($group_info[$lid]['name'])) {
								$send_datas[] = $group_info[$lid]['name'];
							}
						}
						
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					if ($cron_info['send_to'] == 'send_group') {
						$msend_groups = explode(',', $cron_info['send_to_data']);
						$send_datas = array();
						
						foreach($msend_groups as $msend_group) {
							$sgroup_info = $this->model_sale_contacts->getSendGroup($msend_group);
							
							if (!empty($sgroup_info) && isset($sgroup_info['name'])) {
								$send_datas[] = html_entity_decode($sgroup_info['name'], ENT_QUOTES, 'UTF-8');
							}
						}
						
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					$send_total = $this->model_sale_contacts->getCronSendEmailTotal($cron['cron_id']);
					$cron_count = $this->model_sale_contacts->getCronCount($cron['cron_id']);
					$cron_status = $this->model_sale_contacts->getCronStatus($cron['cron_id']);
					
					if ($cron_status) {
						$text_cron_status = $this->language->get('text_cstatus' . $cron_status);
					} else {
						$text_cron_status = '';
					}
					
					$language = '';
					if ($cron_info['language_id']) {
						$language_info = $this->model_localisation_language->getLanguage($cron_info['language_id']);
						if (isset($language_info['name'])) {
							$language = $language_info['name'];
						}
					}
					
					$country = '';
					$zone = '';
					if ($cron_info['send_region']) {
						if ($cron_info['send_country_id']) {
							$country_info = $this->model_localisation_country->getCountry($cron_info['send_country_id']);
							if (isset($country_info['name'])) {
								$country = $country_info['name'];
							}
						}
						if ($cron_info['send_zone_id']) {
							$zone_info = $this->model_localisation_zone->getZone($cron_info['send_zone_id']);
							if (isset($zone_info['name'])) {
								$zone = $zone_info['name'];
							}
						}
					}
					
					$invers = ($cron_info['invers_product'] || $cron_info['invers_category'] || $cron_info['invers_customer'] || $cron_info['invers_client'] || $cron_info['invers_affiliate']) ? 1 : 0;
					
					$this->data['crons'][] = array(
						'cron_id'          => $cron['cron_id'],
						'name'             => html_entity_decode($cron['name'], ENT_QUOTES, 'UTF-8'),
						'send_to'          => $send_to,
						'send_data'        => $send_data,
						'date_start'       => $cron['date_start'],
						'date_next'        => $cron['date_next'],
						'period'           => $cron['period'],
						'status'           => $cron['status'],
						'status_text'      => $status_text,
						'send_region'      => $cron_info['send_region'],
						'country'          => $country,
						'zone'             => $zone,
						'invers_region'    => $cron_info['invers_region'],
						'invers_product'   => $cron_info['invers_product'],
						'invers_category'  => $cron_info['invers_category'],
						'invers_customer'  => $cron_info['invers_customer'],
						'invers_client'    => $cron_info['invers_client'],
						'invers_affiliate' => $cron_info['invers_affiliate'],
						'invers'           => $invers,
						'language_id'      => $cron_info['language_id'],
						'language'         => $language,
						'fdate_start'      => $cron_info['date_start'],
						'fdate_end'        => $cron_info['date_end'],
						'limit_start'      => $cron_info['limit_start'],
						'limit_end'        => $cron_info['limit_end'],
						'products'         => $cron_info['send_products'],
						'attachments'      => ($cron_info['attachments']) ? $cron_info['attachments'] : $cron_info['attachments_cat'],
						'static'           => $cron_info['static'],
						'unsub_url'        => $cron_info['unsub_url'],
						'control_unsub'    => $cron_info['control_unsub'],
						'email_total'      => ($cron_info['email_total']) ? $cron_info['email_total'] : '&infin;',
						'send_total'       => $send_total,
						'cron_count'       => $cron_count,
						'cron_status'      => $cron_status,
						'text_cron_status' => $text_cron_status
					);
				}
			}
		}
	
		$pagination = new Pagination();
		$pagination->total = $crons_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/crons', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/contacts_crons.tpl';

		$this->response->setOutput($this->render());
	}
	
	public function templates() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$this->data['column_template_name'] = $this->language->get('column_template_name');
		$this->data['column_subject'] = $this->language->get('column_subject');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_save'] = $this->language->get('text_save');
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'template_id';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
	
		$this->data['templates'] = array();
		
		$data = array(
			'sort'     => $sort,
			'order'    => $order,
			'start'    => ($page - 1) * $contacts_admin_limit,
			'limit'    => $contacts_admin_limit
		);

		$templates = $this->model_sale_contacts->getTemplates($data);
		
		$templates_total = $this->model_sale_contacts->getTotalTemplates();
		
		if (!empty($templates)) {
			foreach ($templates as $template) {
				$this->data['templates'][] = array(
					'template_id'  => $template['template_id'],
					'name'         => html_entity_decode($template['name'], ENT_QUOTES, 'UTF-8'),
					'subject'      => html_entity_decode($template['subject'], ENT_QUOTES, 'UTF-8')
				);
			}
		}
		
		$pagination = new Pagination();
		$pagination->total = $templates_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/templates', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/contacts_templates.tpl';

		$this->response->setOutput($this->render());
	}
	
	public function groups() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$this->data['column_group_name'] = $this->language->get('column_group_name');
		$this->data['column_group_description'] = $this->language->get('column_group_description');
		$this->data['column_group_counts'] = $this->language->get('column_group_counts');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['text_group_edit'] = $this->language->get('text_group_edit');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
	
		$this->data['groups'] = array();
		
		$data = array(
			'sort'     => $sort,
			'order'    => $order,
			'start'    => ($page - 1) * $contacts_admin_limit,
			'limit'    => $contacts_admin_limit
		);

		$groups = $this->model_sale_contacts->getSendGroups($data);
		
		$groups_total = $this->model_sale_contacts->getTotalSendGroups();
		
		if (!empty($groups)) {
			foreach ($groups as $group) {
				$counts = $this->model_sale_contacts->getTotalNewslettersFromGroup($group['group_id']);
				
				$this->data['groups'][] = array(
					'group_id'    => $group['group_id'],
					'name'        => html_entity_decode($group['name'], ENT_QUOTES, 'UTF-8'),
					'description' => $group['description'],
					'counts'      => $counts
				);
			}
		}
		
		$pagination = new Pagination();
		$pagination->total = $groups_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/groups', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/contacts_groups.tpl';

		$this->response->setOutput($this->render());
	}
	
	public function statistics() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$this->data['text_mview'] = $this->language->get('text_mview');
		$this->data['text_nmview'] = $this->language->get('text_nmview');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_send_to'] = $this->language->get('column_send_to');
		$this->data['column_subject'] = $this->language->get('column_subject');
		$this->data['column_region'] = $this->language->get('column_region');
		$this->data['column_language'] = $this->language->get('column_language');
		$this->data['column_products'] = $this->language->get('column_products');
		$this->data['column_attachments'] = $this->language->get('column_attachments');
		$this->data['column_unsub_url'] = $this->language->get('column_unsub_url');
		$this->data['column_control_unsub'] = $this->language->get('column_control_unsub');
		$this->data['column_email_total'] = $this->language->get('column_email_total');
		$this->data['column_email_open'] = $this->language->get('column_email_open');
		$this->data['column_email_click'] = $this->language->get('column_email_click');
		$this->data['column_email_unsub'] = $this->language->get('column_email_unsub');
		$this->data['column_remove'] = $this->language->get('column_remove');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'date_added';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
		$lid = $this->config->get('config_language_id') ? $this->config->get('config_language_id') : 1;
	
		$this->data['mailings'] = array();
		
		$data = array(
			'sort'     => $sort,
			'order'    => $order,
			'start'    => ($page - 1) * $contacts_admin_limit,
			'limit'    => $contacts_admin_limit
		);

		$mailings = $this->model_sale_contacts->getCompleteDataSend($data);
		
		$mailings_total = $this->model_sale_contacts->getTotalCompleteDataSend($data);
		
		if (!empty($mailings)) {
			$this->load->model('localisation/country');
			$this->load->model('localisation/zone');
			$this->load->model('localisation/language');
			$this->load->model('sale/customer_group');
			$country_name = '';
			$country_iso = '';
			$zone_name = '';
			$zone_code = '';
			
			foreach ($mailings as $mailing) {
				if ($mailing['send_region'] && $mailing['send_country_id']) {
					$country_info = $this->model_localisation_country->getCountry($mailing['send_country_id']);
					if(isset($country_info['iso_code_3'])) {
						$country_iso = $country_info['iso_code_3'];
					}
					if(isset($country_info['name'])) {
						$country_name = $country_info['name'];
					}
				}
				if ($mailing['send_region'] && $mailing['send_zone_id']) {
					$zone_info = $this->model_localisation_zone->getZone($mailing['send_zone_id']);
					if(isset($zone_info['code'])) {
						$zone_code = $zone_info['code'];
					}
					if(isset($zone_info['name'])) {
						$zone_name = $zone_info['name'];
					}
				}
				
				$language = '';
				$lang_code = '';
				if ($mailing['language_id']) {
					$language_info = $this->model_localisation_language->getLanguage($mailing['language_id']);
					if (isset($language_info['name'])) {
						$language = $language_info['name'];
					}
					if (isset($language_info['code'])) {
						$lang_code = $language_info['code'];
					}
				}
				
				if ($mailing['send_to'] == 'customer_group') {
					$mcustomer_groups = explode(',', $mailing['send_to_data']);
					$send_datas = array();
					
					foreach($mcustomer_groups as $mcustomer_group) {
						$group_info = $this->model_sale_customer_group->getCustomerGroupDescriptions($mcustomer_group);
						
						if (!empty($group_info) && isset($group_info[$lid]['name'])) {
							$send_datas[] = $group_info[$lid]['name'];
						}
					}
					
					if (!empty($send_datas)) {
						$send_data = implode(', ', $send_datas);
					} else {
						$send_data = '';
					}

				} elseif ($mailing['send_to'] == 'send_group') {
					$msend_groups = explode(',', $mailing['send_to_data']);
					$send_datas = array();
					
					foreach($msend_groups as $msend_group) {
						$sgroup_info = $this->model_sale_contacts->getSendGroup($msend_group);
						
						if (!empty($sgroup_info) && isset($sgroup_info['name'])) {
							$send_datas[] = $sgroup_info['name'];
						}
					}
					
					if (!empty($send_datas)) {
						$send_data = implode(', ', $send_datas);
					} else {
						$send_data = '';
					}
					
				} else {
					$send_data = '';
				}
				
				$email_open = $this->model_sale_contacts->getTotalViewsfromSend($mailing['send_id']);
				$email_click = $this->model_sale_contacts->getTotalClicksfromSend($mailing['send_id']);
				$email_unsub = $this->model_sale_contacts->getTotalUnsubscribesfromSend($mailing['send_id']);
				
				$this->data['mailings'][] = array(
					'send_id'        => $mailing['send_id'],
					'date_added'     => date('d.m.Y', strtotime($mailing['date_added'])),
					'send_to'        => $this->language->get('text_' . $mailing['send_to']),
					'send_data'      => $send_data,
					'subject'        => html_entity_decode($mailing['subject'], ENT_QUOTES, 'UTF-8'),
					'send_region'    => $mailing['send_region'],
					'invers_region'  => $mailing['invers_region'],
					'invers_product' => $mailing['invers_product'],
					'country_name'   => $country_name,
					'country_iso'    => $country_iso,
					'zone_name'      => $zone_name,
					'zone_code'      => $zone_code,
					'language'       => $language,
					'lang_code'      => $lang_code,
					'products'       => $mailing['send_products'],
					'attachments'    => ($mailing['attachments']) ? $mailing['attachments'] : $mailing['attachments_cat'],
					'unsub_url'      => $mailing['unsub_url'],
					'control_unsub'  => $mailing['control_unsub'],
					'email_total'    => $mailing['email_total'],
					'email_open'     => $email_open,
					'email_click'    => $email_click,
					'email_unsub'    => $email_unsub
				);
			}
		}
		
		$pagination = new Pagination();
		$pagination->total = $mailings_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/statistics', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/contacts_statistics.tpl';
		
		$this->response->setOutput($this->render());
	}
	
	public function newsletters() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');

		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_ngroup_name'] = $this->language->get('column_ngroup_name');
		$this->data['column_ncustomer'] = $this->language->get('column_ncustomer');
		$this->data['column_ncustomer_group'] = $this->language->get('column_ncustomer_group');
		$this->data['column_nsubscribe'] = $this->language->get('column_nsubscribe');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		$this->data['text_clear_filter'] = $this->language->get('text_clear_filter');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
		
		$this->data['groups'] = $this->model_sale_contacts->getSendGroups();
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'cemail';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
	
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : '';
		$filter_email = isset($this->request->get['filter_email']) ? $this->request->get['filter_email'] : '';
		$filter_group_id = isset($this->request->get['filter_group_id']) ? $this->request->get['filter_group_id'] : '';
		$filter_customer_group_id = isset($this->request->get['filter_customer_group_id']) ? $this->request->get['filter_customer_group_id'] : '';
		$filter_unsubscribe = isset($this->request->get['filter_unsubscribe']) ? $this->request->get['filter_unsubscribe'] : null;
	
		$this->data['newsletters'] = array();
		
		$data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_group_id'          => $filter_group_id,
			'filter_unsubscribe'       => $filter_unsubscribe,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $contacts_admin_limit,
			'limit'                    => $contacts_admin_limit
		);
		
		$newsletters = $this->model_sale_contacts->getNewsletters($data);
		$newsletters_total = $this->model_sale_contacts->getTotalNewsletters($data);

		if (!empty($newsletters)) {
			foreach ($newsletters as $newsletter) {
				$action = array();
				
				$action[] = array(
					'text'  => $this->language->get('text_subs'),
					'clss'  => 'btn btn-msubscr',
					'onclk' => 'tognewsletter(1, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$action[] = array(
					'text'  => $this->language->get('text_unsubs'),
					'clss'  => 'btn btn-munsubscr',
					'onclk' => 'tognewsletter(2, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$action[] = array(
					'text'  => $this->language->get('text_delete'),
					'clss'  => 'btn btn-mremove',
					'onclk' => 'tognewsletter(3, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$subscriber = true;
				
				if ($newsletter['customer_id'] && !$newsletter['newsletter']) {
					$subscriber = false;
				}
				
				if ($newsletter['unsubscribe_id']) {
					$subscriber = false;
				}
				
				$this->data['newsletters'][] = array(
					'newsletter_id'  => $newsletter['newsletter_id'],
					'email'          => $newsletter['cemail'],
					'group'          => $newsletter['cgroup'],
					'customer_id'    => $newsletter['customer_id'],
					'name'           => !empty($newsletter['cname']) ? $newsletter['cname'] : $newsletter['nname'],
					'subscriber'     => $subscriber,
					'customer_group' => $newsletter['customer_group'],
					'action'         => $action
				);
			}
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_group_id'])) {
			$url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
		}
		
		if (isset($this->request->get['filter_unsubscribe'])) {
			$url .= '&filter_unsubscribe=' . $this->request->get['filter_unsubscribe'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . '&sort=cname' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . '&sort=cemail' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_group'] = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . '&sort=cgroup' . $url, 'SSL');
		
		$this->data['page'] = $page;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_group_id'] = $filter_group_id;
		$this->data['filter_unsubscribe'] = $filter_unsubscribe;
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_group_id'])) {
			$url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
		}
		
		if (isset($this->request->get['filter_unsubscribe'])) {
			$url .= '&filter_unsubscribe=' . $this->request->get['filter_unsubscribe'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $newsletters_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/contacts_newsletters.tpl';
		
		$this->response->setOutput($this->render());
  	}
	
	public function filter_newsletters() {
		$json = array();
		
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'cemail';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
	
		$contacts_admin_limit = $this->config->get('contacts_admin_limit') ? $this->config->get('contacts_admin_limit') : 10;
	
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : '';
		$filter_email = isset($this->request->get['filter_email']) ? $this->request->get['filter_email'] : '';
		$filter_group_id = isset($this->request->get['filter_group_id']) ? $this->request->get['filter_group_id'] : '';
		$filter_customer_group_id = isset($this->request->get['filter_customer_group_id']) ? $this->request->get['filter_customer_group_id'] : '';
		$filter_unsubscribe = isset($this->request->get['filter_unsubscribe']) ? $this->request->get['filter_unsubscribe'] : null;

		$json['newsletters'] = array();
		
		$data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_group_id'          => $filter_group_id,
			'filter_unsubscribe'       => $filter_unsubscribe,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $contacts_admin_limit,
			'limit'                    => $contacts_admin_limit
		);
		
		$newsletters = $this->model_sale_contacts->getNewsletters($data);
		$newsletters_total = $this->model_sale_contacts->getTotalNewsletters($data);

		if (!empty($newsletters)) {
			foreach ($newsletters as $newsletter) {
				$action = array();
				
				$action[] = array(
					'text'  => $this->language->get('text_subs'),
					'clss'  => 'btn btn-msubscr',
					'onclk' => 'tognewsletter(1, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$action[] = array(
					'text'  => $this->language->get('text_unsubs'),
					'clss'  => 'btn btn-munsubscr',
					'onclk' => 'tognewsletter(2, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$action[] = array(
					'text'  => $this->language->get('text_delete'),
					'clss'  => 'btn btn-mremove',
					'onclk' => 'tognewsletter(3, ' . $newsletter['newsletter_id'] . ')'
				);
				
				$subscriber = true;
				
				if ($newsletter['customer_id'] && !$newsletter['newsletter']) {
					$subscriber = false;
				}
				
				if ($newsletter['unsubscribe_id']) {
					$subscriber = false;
				}
				
				$json['newsletters'][] = array(
					'newsletter_id'  => $newsletter['newsletter_id'],
					'email'          => $newsletter['cemail'],
					'group'          => $newsletter['cgroup'],
					'customer_id'    => $newsletter['customer_id'],
					'name'           => !empty($newsletter['cname']) ? $newsletter['cname'] : $newsletter['nname'],
					'subscriber'     => $subscriber,
					'customer_group' => $newsletter['customer_group'],
					'action'         => $action
				);
			}
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_group_id'])) {
			$url .= '&filter_group_id=' . $this->request->get['filter_group_id'];
		}
		
		if (isset($this->request->get['filter_unsubscribe'])) {
			$url .= '&filter_unsubscribe=' . $this->request->get['filter_unsubscribe'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $newsletters_total;
		$pagination->page = $page;
		$pagination->limit = $contacts_admin_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/contacts/newsletters', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$json['pagination'] = $pagination->render();

		$this->response->setOutput(json_encode($json));
  	}
	
	public function checkcrons() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_send_to'] = $this->language->get('column_send_to');
		$this->data['column_check_total'] = $this->language->get('column_send_total');
		$this->data['column_good_total'] = $this->language->get('column_good_total');
		$this->data['column_novalid_total'] = $this->language->get('column_novalid_total');
		$this->data['column_bad_total'] = $this->language->get('column_bad_total');
		$this->data['column_suspect_total'] = $this->language->get('column_suspect_total');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['text_view_logs'] = $this->language->get('text_view_logs');
		$this->data['text_no_data'] = $this->language->get('text_no_data');
	
		$this->data['token'] = $this->session->data['token'];
	
		$lid = $this->config->get('config_language_id') ? $this->config->get('config_language_id') : 1;
	
		$this->data['check_crons'] = array();
	
		$data = array(
			'sort'     => 'cron_id',
			'order'    => 'DESC',
			'checking' => 1,
			'start'    => 0,
			'limit'    => 10
		);
	
		$check_crons = $this->model_sale_contacts->getCrons($data);
	
		if (!empty($check_crons)) {
			$this->load->model('sale/customer_group');
			
			foreach ($check_crons as $cron) {
				$send_to = '';
				$send_data = '';
				
				$cron_info = $this->model_sale_contacts->getDataCron($cron['cron_id']);
				
				if (!empty($cron_info)) {
					$send_to = $this->language->get('text_' . $cron_info['send_to']);
					
					if ($cron_info['send_to'] == 'customer_group') {
						$mcustomer_groups = explode(',', $cron_info['send_to_data']);
						$send_datas = array();
						
						foreach($mcustomer_groups as $mcustomer_group) {
							$group_info = $this->model_sale_customer_group->getCustomerGroupDescriptions($mcustomer_group);
							
							if (!empty($group_info) && isset($group_info[$lid]['name'])) {
								$send_datas[] = $group_info[$lid]['name'];
							}
						}
	
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					if ($cron_info['send_to'] == 'send_group') {
						$msend_groups = explode(',', $cron_info['send_to_data']);
						$send_datas = array();
						
						foreach($msend_groups as $msend_group) {
							$sgroup_info = $this->model_sale_contacts->getSendGroup($msend_group);
							
							if (!empty($sgroup_info) && isset($sgroup_info['name'])) {
								$send_datas[] = html_entity_decode($sgroup_info['name'], ENT_QUOTES, 'UTF-8');
							}
						}
						
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					$send_total = $this->model_sale_contacts->getCronSendEmailTotal($cron['cron_id']);
					$check_results = $this->model_sale_contacts->getCheckCronResult($cron['cron_id']);
					
					$this->data['check_crons'][] = array(
						'cron_id'       => $cron['cron_id'],
						'send_to'       => $send_to,
						'send_data'     => $send_data,
						'date_start'    => $cron['date_start'],
						'check_total'   => $send_total,
						'good_total'    => isset($check_results['good']) ? $check_results['good'] : '',
						'novalid_total' => isset($check_results['novalid']) ? $check_results['novalid'] : '',
						'bad_total'     => isset($check_results['bad']) ? $check_results['bad'] : '',
						'suspect_total' => isset($check_results['suspect']) ? $check_results['suspect'] : ''
					);
				}
			}
		}
		
		$this->template = 'sale/contacts_check.tpl';

		$this->response->setOutput($this->render());
	}
	
	public function checkmode() {
		$this->config->set('config_error_display', 0);
		$json = array();
		
		$this->language->load('sale/contacts');
		
		$file = DIR_LOGS . 'checkmode.log';
		$handle = fopen($file, 'w+');
		fclose($handle);
		
		$contacts_log = new Log('checkmode.log');
		require_once(DIR_SYSTEM . 'library/mail_cc.php');
		
		$contacts_log->write($this->language->get('text_start_send'));
		
		$email = 'info@opencart-group.ru';
		
		if (($this->config->get('contacts_mail_from')) && ($this->config->get('contacts_mail_from') != '')) {
			$senders = explode(',', preg_replace('/\s/', '', $this->config->get('contacts_mail_from')));
		} else {
			$senders = array($this->config->get('config_email'));
		}
		
		$mail = new Mail_CC();
		$mail->setTo($email);
		$mail->setFrom($senders[0]);
		$mail->setTestmode(1);
		$mail->setMode(2);
		$mail->setDebag(1);

		$contacts_log->write($this->language->get('text_check_email') . $email);
		$check_status = $mail->check_email();
		
		if ($check_status) {
			$status_arr = explode('|', $check_status);
			$check_text = $status_arr[0];
			$check_reply = isset($status_arr[1]) ? $status_arr[1] : '';

			if (substr($check_text, 0, 5) == 'mcokk') {
				$json['success'] = $this->language->get('success_checkmode');
			} else {
				$json['error'] = $this->language->get('error_checkmode');
				$contacts_log->write($this->language->get('error_check_' . substr($check_text, 5, 2)));
			}
			
			if ($check_reply) {
				$contacts_log->write($this->language->get('result_check_mode') . $check_reply);
			}
			
		} else {
			$contacts_log->write($this->language->get('error_check_00'));
			$json['error'] = $this->language->get('error_checkmode');
		}
		
		$contacts_log->write($this->language->get('text_end_send'));

		if (file_exists($file)) {
			$json['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$json['log'] = '';
		}

		$this->response->setOutput(json_encode($json));
  	}
	
	public function misssend() {
		$this->config->set('config_error_display', 0);
		
		$json = array();
		$json['error'] = array();
		$json['attention'] = array();
		
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');
		
		$contacts_log = new Log('contacts.log');
		require_once(DIR_SYSTEM . 'library/mail_cs.php');
		
		if (!$this->validate()) {
			$json['error'][] = $this->language->get('error_permission');
		}
		
		if (!$this->config->get('contacts_allow_sendcron')) {
			$run_crons = $this->model_sale_contacts->getRunCron();
			if ($run_crons) {
				$json['error'][] = $this->language->get('error_send_iscron');
			}
		}
		
		if (isset($this->request->get['msid'])) {
			$msend_id = $this->request->get['msid'];
			$missing_send = $this->model_sale_contacts->getDataSend($msend_id);
		} else {
			$msend_id = 0;
			$missing_send = '';
			$json['error'][] = $this->language->get('error_msid');
		}
		
		if (!empty($missing_send)) {
			if (!$missing_send['subject'] || trim($missing_send['subject'] == '')) {
				$json['error'][] = $this->language->get('error_subject');
			}
			if (!$missing_send['message'] || trim($missing_send['message'] == '')) {
				$json['error'][] = $this->language->get('error_message');
			}
		} else {
			$json['error'][] = $this->language->get('error_msid_data');
		}
		
		if (!$json['error']) {
			if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
				$total_mails = $this->model_sale_contacts->getCountMails();
				
				if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
					$contacts_log->write(strip_tags($this->language->get('error_limit_hour')));
					$json['error'][] = $this->language->get('error_limit_hour');
					$json['stop_send'] = $msend_id ? $msend_id : '';
				}
				if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
					$contacts_log->write(strip_tags($this->language->get('error_limit_day')));
					$json['error'][] = $this->language->get('error_limit_day');
					$json['stop_send'] = $msend_id ? $msend_id : '';
				}
			}
		}

		if (!$json['error']) {
			$this->load->model('setting/store');
			$store_info = $this->model_setting_store->getStore($missing_send['store_id']);			
			
			if ($store_info) {
				$store_name = $store_info['name'];
				$store_url = $store_info['url'];
			} else {
				$store_name = $this->config->get('config_name');
				$store_url = HTTP_CATALOG;
			}

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
				$this->cache->delete('contacts');
				$this->model_sale_contacts->ClearErrorsSend($msend_id);
				$contacts_log->write($this->language->get('text_start_missresend'));
			}
			
			if ($this->config->get('contacts_mail_protocol') && ($this->config->get('contacts_mail_protocol') == 'smtp')) {
				$contacts_mail_protocol = 'smtp';
			} else {
				$contacts_mail_protocol = 'mail';
			}
			
			$contacts_smtp_port = $this->config->get('contacts_smtp_port') ? $this->config->get('contacts_smtp_port') : 25;
			$contacts_smtp_timeout = $this->config->get('contacts_smtp_timeout') ? $this->config->get('contacts_smtp_timeout') : 5;
			$contacts_count_message = $this->config->get('contacts_count_message') ? $this->config->get('contacts_count_message') : 1;
			$contacts_sleep_time = $this->config->get('contacts_sleep_time') ? $this->config->get('contacts_sleep_time') : 4;
			$contacts_count_error = $this->config->get('contacts_count_send_error') ? $this->config->get('contacts_count_send_error') : 10;
			
			$precedence = $this->config->get('contacts_add_precedence') ? $this->config->get('contacts_add_precedence') : '';
			$set_unsubscribe = $missing_send['unsub_url'] ? 1 : 0;

			$shop_country = $this->model_sale_contacts->getCountry($this->config->get('config_country_id'));
			$shop_zone = $this->model_sale_contacts->getZone($this->config->get('config_zone_id'));
			
			$store_id = $missing_send['store_id'];
			$cgroup_id = $this->config->get('config_customer_group_id');
			
			$reply_badem = explode('|', $this->config->get('contacts_reply_badem'));
			$bad_email_action = $this->config->get('contacts_bad_eaction') ? $this->config->get('contacts_bad_eaction') : 0;
			
			$send_products = $missing_send['send_products'] ? 1 : 0;
	
			$language_id = $missing_send['language_id'] ? $missing_send['language_id'] : $this->config->get('config_language_id');
			$lang_id = $missing_send['lang_products'] ? $missing_send['lang_products'] : $language_id;

// added 04.07.20
/*	
			
			$special = '';
			$bestseller = '';
			$latest = '';
			$featured = '';
			$selproducts = '';
			$catproducts = '';
			$add_purchased = false;
			
			if ($send_products) {
				$send_product_data = $this->model_sale_contacts->getProductSend($msend_id);
				
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
						
						$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit);
						
						if (!isset($special_cache_data)) {
							$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit, $lang_id, $store_id);
							if (!empty($specials)) {
								$special_products = $this->getMailProducts($specials);
							}
							$this->cache->set('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit, $special_products);
						} else {
							$special_products = $special_cache_data;
						}

						if ($special_products) {
							$special_template = new Template();
							$special_template->data['title'] = $special_title;
							$special_template->data['products'] = $special_products;
							$special = $special_template->fetch('mail/contacts_products.tpl');
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
						
						$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit);
						
						if (!isset($bestseller_cache_data)) {
							$bestsellers = $this->model_sale_contacts->getBestSellerProducts($bestseller_limit, $lang_id, $store_id);
							if (!empty($bestsellers)) {
								$bestseller_products = $this->getMailProducts($bestsellers);
							}
							$this->cache->set('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit, $bestseller_products);
						} else {
							$bestseller_products = $bestseller_cache_data;
						}
						
						if ($bestseller_products) {
							$bestseller_template = new Template();
							$bestseller_template->data['title'] = $bestseller_title;
							$bestseller_template->data['products'] = $bestseller_products;
							$bestseller = $bestseller_template->fetch('mail/contacts_products.tpl');
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
						
						$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit);
						
						if (!isset($latest_cache_data)) {
							$latests = $this->model_sale_contacts->getLatestProducts($latest_limit, $lang_id, $store_id);
							if (!empty($latests)) {
								$latest_products = $this->getMailProducts($latests);
							}
							$this->cache->set('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit, $latest_products);
						} else {
							$latest_products = $latest_cache_data;
						}
						
						if ($latest_products) {
							$latest_template = new Template();
							$latest_template->data['title'] = $latest_title;
							$latest_template->data['products'] = $latest_products;
							$latest = $latest_template->fetch('mail/contacts_products.tpl');
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
						
						$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit);
						
						if (!isset($featured_cache_data)) {
							$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit, $lang_id, $store_id);
							if (!empty($featureds)) {
								$featured_products = $this->getMailProducts($featureds);
							}
							$this->cache->set('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit, $featured_products);
						} else {
							$featured_products = $featured_cache_data;
						}

						if ($featured_products) {
							$featured_template = new Template();
							$featured_template->data['title'] = $featured_title;
							$featured_template->data['products'] = $featured_products;
							$featured = $featured_template->fetch('mail/contacts_products.tpl');
						}
					}
					
					if ($send_product['type'] == 'selproducts') {
						if ($send_product['title']) {
							$selproducts_title = $send_product['title'];
						} else {
							$selproducts_title = $this->language->get('selproducts_title');
						}
						
						$selected_products = array();
						
						$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id);
						
						if (!isset($selected_cache_data)) {
							$selectproducts = $this->model_sale_contacts->getProductsToSend($msend_id, $send_product['type'], $lang_id);
							
							if (!empty($selectproducts)) {
								$selected_products = $this->getMailProducts($selectproducts);
							}
							
							$this->cache->set('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id, $selected_products);
						} else {
							$selected_products = $selected_cache_data;
						}

						if ($selected_products) {
							$selproducts_template = new Template();
							$selproducts_template->data['title'] = $selproducts_title;
							$selproducts_template->data['products'] = $selected_products;
							$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');
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
						
						$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$catproducts_limit);

						if (!isset($catproduct_cache_data)) {
							$pcategories = explode(',', $send_product['cat_id']);
							
							if ($send_product['cat_each']) {
								foreach ($pcategories as $pcategory_id) {
									$allcatproducts[] = $this->model_sale_contacts->getProductsFromCat($pcategory_id, $catproducts_limit, $lang_id, $store_id);
								}
								foreach ($allcatproducts as $pid) {
									foreach ($pid as $key => $value) {
										$selcatproducts[$key] = $value;
									}
								}
							} else {
								$selcatproducts = $this->model_sale_contacts->getCatSelectedProducts($pcategories, $catproducts_limit, $lang_id, $store_id);
							}						
							
							if (!empty($selcatproducts)) {
								$category_products = $this->getMailProducts($selcatproducts);
							}
							$this->cache->set('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$catproducts_limit, $category_products);
						} else {
							$category_products = $catproduct_cache_data;
						}

						if ($category_products) {
							$category_products_template = new Template();
							$category_products_template->data['title'] = $catproducts_title;
							$category_products_template->data['products'] = $category_products;
							$catproducts = $category_products_template->fetch('mail/contacts_products.tpl');
						}
					}
				
				}
			}
*/
// added 04.07.20	

			$left_total = 0;
			$emails = array();
			$attachments = array();
			$attachments_cat = array();
			
			if ($missing_send['attachments']) {
				$send_attachments = explode(',', $missing_send['attachments']);
				
				foreach ($send_attachments as $attachment) {
					if ((trim($attachment) != '') && file_exists(DIR_DOWNLOAD . $attachment)) {
						$attachments[] = array(
							'path' => DIR_DOWNLOAD . $attachment
						);
					}
				}
			}
			
			if ($missing_send['attachments_cat']) {
				$files_catalog = str_ireplace('/system/', $missing_send['attachments_cat'], DIR_SYSTEM);
				
				if(is_dir($files_catalog)) {
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
			
			$results = $this->model_sale_contacts->getEmailsToSend($msend_id, $contacts_count_message);

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
			
			$left_total = $this->model_sale_contacts->getTotalEmailsToSend($msend_id);
			
			if ($emails) {
				if ($page == 1) {
					$contacts_log->write(sprintf($this->language->get('text_count_email'), $left_total));
				}
				if ($page > 1) {
					sleep($contacts_sleep_time);
				} else {
					sleep(2);
				}
				
				$count_emails = count($emails);
				$count_send_error = $this->model_sale_contacts->getErrorsSend($msend_id);
				$lastsend = 0;
				$error_limit = false;

				if ($count_emails < $left_total) {
					$json['success'] = sprintf($this->language->get('text_miss_sent'), $left_total);
				} else {
					$json['success'] = $this->language->get('text_success') . '<br />' . $this->language->get('text_end_send');
					$lastsend = 1;
				}
				
				if ($count_emails < $left_total) {
					$json['next'] = str_replace('&amp;', '&', $this->url->link('sale/contacts/misssend', 'msid=' . $msend_id . '&token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
				} else {
					$json['next'] = '';
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
				
				$subjects = explode('|', $missing_send['subject']);
				
				if (($this->config->get('contacts_retpath_email')) && (trim($this->config->get('contacts_retpath_email')) != '')) {
					$retpath_email = trim($this->config->get('contacts_retpath_email'));
				} else {
					$retpath_email = false;
				}

				foreach ($emails as $email => $customer) {
					if ($count_send_error < $contacts_count_error) {
						if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
							$total_mails = $this->model_sale_contacts->getCountMails();
							
							if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
								$contacts_log->write(strip_tags($this->language->get('error_limit_hour')));
								$json['error'][] = $this->language->get('error_limit_hour');
								$error_limit = true;
							}
							if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
								$contacts_log->write(strip_tags($this->language->get('error_limit_day')));
								$json['error'][] = $this->language->get('error_limit_day');
								$error_limit = true;
							}
							
							$json['hour'] = $this->config->get('contacts_global_limith') - $total_mails['hour'];
							$json['day'] = $this->config->get('contacts_global_limitd') - $total_mails['day'];
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
									$sid = base64_encode($msend_id . '|' . $email . '|' . $controlsumm . '|' . $customer['customer_id']);
								} else {
									$sid = base64_encode($msend_id . '|' . $email . '|' . $controlsumm . '|0');
								}
	
								$unsubscribe_url = HTTP_CATALOG . 'index.php?route=account/success&sid=' . $sid;
	
								if ($set_unsubscribe) {
									$unsub = sprintf($this->language->get('text_unsubscribe'), $unsubscribe_url);
								} else {
									$unsub = '';
								}

// added 04.07.20
								$buyproducts = '';
								$special = '';
								$bestseller = '';
								$latest = '';
								$featured = '';
								$selproducts = '';
								$catproducts = '';
								$add_purchased = false;

								if ($send_products) {
									$send_product_data = $this->model_sale_contacts->getProductSend($msend_id);

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

											$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit);

											if (!isset($special_cache_data)) {
												$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit, $lang_id, $store_id);
												if (!empty($specials)) {
													$special_products = $this->getMailProducts($specials, $customer_group_id, $customer['customer_id']);
												}
												$this->cache->set('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit, $special_products);
											} else {
												$special_products = $special_cache_data;
											}

											if ($special_products) {
												$special_template = new Template();
												$special_template->data['title'] = $special_title;
												$special_template->data['products'] = $special_products;
												$special = $special_template->fetch('mail/contacts_products.tpl');
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

											$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit);

											if (!isset($bestseller_cache_data)) {
												$bestsellers = $this->model_sale_contacts->getBestSellerProducts($bestseller_limit, $lang_id, $store_id);
												if (!empty($bestsellers)) {
													$bestseller_products = $this->getMailProducts($bestsellers, $customer_group_id, $customer['customer_id']);
												}
												$this->cache->set('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit, $bestseller_products);
											} else {
												$bestseller_products = $bestseller_cache_data;
											}

											if ($bestseller_products) {
												$bestseller_template = new Template();
												$bestseller_template->data['title'] = $bestseller_title;
												$bestseller_template->data['products'] = $bestseller_products;
												$bestseller = $bestseller_template->fetch('mail/contacts_products.tpl');
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

											$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit);

											if (!isset($latest_cache_data)) {
												$latests = $this->model_sale_contacts->getLatestProducts($latest_limit, $lang_id, $store_id);
												if (!empty($latests)) {
													$latest_products = $this->getMailProducts($latests, $customer_group_id, $customer['customer_id']);
												}
												$this->cache->set('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit, $latest_products);
											} else {
												$latest_products = $latest_cache_data;
											}

											if ($latest_products) {
												$latest_template = new Template();
												$latest_template->data['title'] = $latest_title;
												$latest_template->data['products'] = $latest_products;
												$latest = $latest_template->fetch('mail/contacts_products.tpl');
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

											$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit);

											if (!isset($featured_cache_data)) {
												$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit, $lang_id, $store_id);
												if (!empty($featureds)) {
													$featured_products = $this->getMailProducts($featureds, $customer_group_id, $customer['customer_id']);
												}
												$this->cache->set('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit, $featured_products);
											} else {
												$featured_products = $featured_cache_data;
											}

											if ($featured_products) {
												$featured_template = new Template();
												$featured_template->data['title'] = $featured_title;
												$featured_template->data['products'] = $featured_products;
												$featured = $featured_template->fetch('mail/contacts_products.tpl');
											}
										}

										if ($send_product['type'] == 'selproducts') {
											if ($send_product['title']) {
												$selproducts_title = $send_product['title'];
											} else {
												$selproducts_title = $this->language->get('selproducts_title');
											}

											$selected_products = array();

											$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id);

											if (!isset($selected_cache_data)) {
												$selectproducts = $this->model_sale_contacts->getProductsToSend($msend_id, $send_product['type'], $lang_id);

												if (!empty($selectproducts)) {
													$selected_products = $this->getMailProducts($selectproducts, $customer_group_id, $customer['customer_id']);
												}

												$this->cache->set('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id, $selected_products);
											} else {
												$selected_products = $selected_cache_data;
											}

											if ($selected_products) {
												$selproducts_template = new Template();
												$selproducts_template->data['title'] = $selproducts_title;
												$selproducts_template->data['products'] = $selected_products;
												$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');
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

											$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$catproducts_limit);

											if (!isset($catproduct_cache_data)) {
												$pcategories = explode(',', $send_product['cat_id']);

												if ($send_product['cat_each']) {
													foreach ($pcategories as $pcategory_id) {
														$allcatproducts[] = $this->model_sale_contacts->getProductsFromCat($pcategory_id, $catproducts_limit, $lang_id, $store_id);
													}
													foreach ($allcatproducts as $pid) {
														foreach ($pid as $key => $value) {
															$selcatproducts[$key] = $value;
														}
													}
												} else {
													$selcatproducts = $this->model_sale_contacts->getCatSelectedProducts($pcategories, $catproducts_limit, $lang_id, $store_id);
												}

												if (!empty($selcatproducts)) {
													$category_products = $this->getMailProducts($selcatproducts, $customer_group_id, $customer['customer_id']);
												}
												$this->cache->set('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$catproducts_limit, $category_products);
											} else {
												$category_products = $catproduct_cache_data;
											}

											if ($category_products) {
												$category_products_template = new Template();
												$category_products_template->data['title'] = $catproducts_title;
												$category_products_template->data['products'] = $category_products;
												$catproducts = $category_products_template->fetch('mail/contacts_products.tpl');
											}
										}
									}

									if ($add_purchased) {
										$filter_purchased = array(
											'email'       => $email,
											'customer_id' => $customer['customer_id'],
											'language_id' => $lang_id,
											'store_id'    => $store_id,
											'limit'       => $purchased_limit
										);
		
										$purchased_products = array();
		
										$purchaseds = $this->model_sale_contacts->getPurchasedsProducts($filter_purchased);
										if (!empty($purchaseds)) {
											$purchased_products = $this->getMailProducts($purchaseds, $customer_group_id, $customer['customer_id']);
										}
		
										if ($purchased_products) {
											$purchased_template = new Template();
											$purchased_template->data['title'] = $purchased_title;
											$purchased_template->data['products'] = $purchased_products;
											$buyproducts = $purchased_template->fetch('mail/contacts_products.tpl');
										}
									}
								}
// added 04.07.20
	
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
								
								$orig_message = $missing_send['message'];
								
								$subject_to_send = str_replace($tegi_subject, $replace_subject, $orig_subject);
								$message_to_send = str_replace($tegi_message, $replace_message, $orig_message);

								$message  = '<html dir="ltr" lang="en">' . "\n";
								$message .= ' <head>' . "\n";
								$message .= '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n";
								$message .= '  <title>' . html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
								$message .= ' </head>' . "\n";
								
								$controlimage = HTTP_CATALOG . 'index.php?route=feed/stats/images&sid=' . $sid;
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
											$new_url = HTTP_CATALOG . 'index.php?route=feed/stats/clck&sid=' . $sid . '&link=' . $ateg_url;
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
									$mail->setListid($msend_id);
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
								$contacts_log->write($this->language->get('text_send_email') . $email);
								$send_status = $mail->send();
								
								if ($send_status == 55) {
									$this->model_sale_contacts->removeEmailSend($msend_id, $email);
								} elseif (substr($send_status, 0, 4) == 'cerr') {
									$lastsend = 0;
									$json['success'] = '';
									$json['next'] = '';
									$json['error'][] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_stop_send');
									$json['stop_send'] = $msend_id;
									break;
								} elseif (substr($send_status, 0, 4) == 'nerr') {
									$json['attention'][] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_continues_send');
									$bad_email = false;
									
									if (substr($send_status, 4, 2) == '24') {
										$this->model_sale_contacts->removeEmailSend($msend_id, $email);
									}
									
									if ((substr($send_status, 4, 2) == '21') || (substr($send_status, 4, 2) == '22') || (substr($send_status, 4, 2) == '23')) {
										$this->model_sale_contacts->removeEmailSend($msend_id, $email);
										
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
											$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
											$contacts_log->write($this->language->get('text_bad_email_unsub'));
										}
										if ($bad_email_action == '2') {
											$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
											$this->model_sale_contacts->delNewsletterFromEmail($email);
											$contacts_log->write($this->language->get('text_bad_email_remove'));
										}
									} else {
										$this->model_sale_contacts->addErrorSend($msend_id);
										$count_send_error++;
									}
								} else {
									$this->model_sale_contacts->addErrorSend($msend_id);
									$count_send_error++;
								}
								$this->model_sale_contacts->addCountMails($msend_id, 0, 1);
								$json['hour']--;
								$json['day']--;
							} else {
								$contacts_log->write($this->language->get('text_bad_email') . $email);
								$this->model_sale_contacts->removeEmailSend($msend_id, $email);
								
								if ($bad_email_action == '1') {
									$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
									$contacts_log->write($this->language->get('text_bad_email_unsub'));
								}
								if ($bad_email_action == '2') {
									$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
									$this->model_sale_contacts->delNewsletterFromEmail($email);
									$contacts_log->write($this->language->get('text_bad_email_remove'));
								}
							}
						} else {
							$lastsend = 0;
							$json['success'] = '';
							$json['next'] = '';
							$json['stop_send'] = $msend_id;
							break;
						}
					} else {
						$contacts_log->write(strip_tags($this->language->get('error_send_count')));
						$lastsend = 0;
						$json['success'] = '';
						$json['next'] = '';
						$json['error'][] = $this->language->get('error_send_count');
						$json['stop_send'] = $msend_id;
						break;
					}
				}
			
				if($lastsend == 1) {
					$this->cache->delete('contacts');
					$contacts_log->write($this->language->get('text_end_send'));

					$this->model_sale_contacts->setCompleteDataSend($msend_id);
					$this->model_sale_contacts->delProductSend($msend_id);
					$this->model_sale_contacts->delEmailsSend($msend_id);
					
					if ($attachments) {
						foreach ($attachments as $attachment) {
							if (file_exists($attachment['path'])) {
								@unlink($attachment['path']);
							}
						}
					}
				}

			} else {
				$this->cache->delete('contacts');
				$contacts_log->write($this->language->get('error_noemails'));
				$json['error'][] = $this->language->get('error_noemails');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function send() {
		$this->config->set('config_error_display', 0);
		
		$json = array();
		$json['error'] = array();
		$json['attention'] = array();
		
		$this->language->load('sale/contacts');
		
		$contacts_log = new Log('contacts.log');
		require_once(DIR_SYSTEM . 'library/mail_cs.php');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('sale/contacts');
			
			if (!$this->validate()) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}
			
			if (!$this->config->get('contacts_allow_sendcron')) {
				$run_crons = $this->model_sale_contacts->getRunCron();
				if ($run_crons) {
					$json['error']['warning'] = $this->language->get('error_send_iscron');
				}
			}

			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}

			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('error_message');
			}
			
			if (!empty($this->request->post['set_period'])) {
				if (!empty($this->request->post['date_start'])) {
					if (date('Y-m-d', strtotime($this->request->post['date_start'])) != $this->request->post['date_start']) {
						$json['error']['warning'] = $this->language->get('error_date_start');
					}
				}
				if (!empty($this->request->post['date_end'])) {
					if (date('Y-m-d', strtotime($this->request->post['date_end'])) != $this->request->post['date_end']) {
						$json['error']['warning'] = $this->language->get('error_date_start');
					}
				}
			}
			
			if (!empty($this->request->post['set_limit'])) {
				if (!empty($this->request->post['limit_start']) && !empty($this->request->post['limit_end'])) {
					if ((int)$this->request->post['limit_start'] > (int)$this->request->post['limit_end']) {
						$json['error']['warning'] = $this->language->get('error_set_limit');
					}
					if ((int)$this->request->post['limit_end'] < 1) {
						$json['error']['warning'] = $this->language->get('error_set_limit');
					}
				}
			}
			
			if (!isset($this->request->get['add_cron']) && !$json['error']) {
				if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
					$total_mails = $this->model_sale_contacts->getCountMails();
					
					if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
						$contacts_log->write(strip_tags($this->language->get('error_limit_hour')));
						$json['error']['warning'] = $this->language->get('error_limit_hour');
						$json['stop_send'] = isset($this->request->get['sid']) ? $this->request->get['sid'] : '';
					}
					if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
						$contacts_log->write(strip_tags($this->language->get('error_limit_day')));
						$json['error']['warning'] = $this->language->get('error_limit_day');
						$json['stop_send'] = isset($this->request->get['sid']) ? $this->request->get['sid'] : '';
					}
				}
			}

			if (!$json['error']) {
				$this->load->model('setting/store');
			
				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);			
				
				if (!empty($store_info)) {
					$store_name = $store_info['name'];
					$store_url = $store_info['url'];
				} else {
					$store_name = $this->config->get('config_name');
					$store_url = HTTP_CATALOG;
				}
				
				$send_id = isset($this->request->get['sid']) ? $this->request->get['sid'] : 0;
				$spam_check = isset($this->request->get['spam_check']) ? 1 : false;
				
				if (isset($this->request->get['add_cron'])) {
					$add_cron = true;
				} else {
					$add_cron = false;
					$cron_id = 0;
				}

				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
					$this->cache->delete('contacts');
					if ($spam_check) {
						$contacts_log->write($this->language->get('text_start_check'));
					} elseif ($add_cron) {
						$data_cron = array(
							'name'     => $this->language->get('text_new_cron'),
							'checking' => 0,
							'status'   => 0
						);
						$cron_id = $this->model_sale_contacts->addNewCron($data_cron);
					} else {
						$handle = fopen(DIR_LOGS . 'contacts.log', 'w+');
						fclose($handle);
						$contacts_log->write($this->language->get('text_start_send'));
						$send_id = $this->model_sale_contacts->addNewSend($this->request->post['store_id'], 1);
					}
				}
	
				$contacts_mail_protocol = ($this->config->get('contacts_mail_protocol') == 'smtp') ? 'smtp' : 'mail';
	
				$contacts_smtp_port = $this->config->get('contacts_smtp_port') ? $this->config->get('contacts_smtp_port') : 25;
				$contacts_smtp_timeout = $this->config->get('contacts_smtp_timeout') ? $this->config->get('contacts_smtp_timeout') : 5;
				$contacts_count_message = $this->config->get('contacts_count_message') ? $this->config->get('contacts_count_message') : 1;
				$contacts_sleep_time = $this->config->get('contacts_sleep_time') ? $this->config->get('contacts_sleep_time') : 4;
				$contacts_count_error = $this->config->get('contacts_count_send_error') ? $this->config->get('contacts_count_send_error') : 10;
				
				$precedence = $this->config->get('contacts_add_precedence') ? $this->config->get('contacts_add_precedence') : '';
				
				$set_region = !empty($this->request->post['set_region']) ? 1 : false;
				if ($set_region) {
					$country_id = !empty($this->request->post['country_id']) ? $this->request->post['country_id'] : false;
					$zone_id = !empty($this->request->post['zone_id']) ? $this->request->post['zone_id'] : false;
					$invers_region = !empty($this->request->post['invers_region']) ? 1 : false;
				} else {
					$country_id = false;
					$zone_id = false;
					$invers_region = false;
				}
				
				$set_period = !empty($this->request->post['set_period']) ? 1 : false;
				if ($set_period) {
					$date_start = !empty($this->request->post['date_start']) ? $this->request->post['date_start'] : false;
					$date_end = !empty($this->request->post['date_end']) ? $this->request->post['date_end'] : false;
				} else {
					$date_start = false;
					$date_end = false;
				}
				
				$set_limit = !empty($this->request->post['set_limit']) ? 1 : false;
				if ($set_limit) {
					$limit_start = !empty($this->request->post['limit_start']) ? $this->request->post['limit_start'] : false;
					$limit_end = !empty($this->request->post['limit_end']) ? $this->request->post['limit_end'] : false;
				} else {
					$limit_start = false;
					$limit_end = false;
				}
				
				$invers_product = !empty($this->request->post['invers_product']) ? 1 : false;
				$invers_category = !empty($this->request->post['invers_category']) ? 1 : false;
				
				$invers_customer = !empty($this->request->post['invers_customer']) ? 1 : false;
				$invers_client = !empty($this->request->post['invers_client']) ? 1 : false;
				$invers_affiliate = !empty($this->request->post['invers_affiliate']) ? 1 : false;
				
				$static = !empty($this->request->post['static']) ? $this->request->post['static'] : 'dinamic';
				$send_products = !empty($this->request->post['insert_products']) ? 1 : false;

				$set_unsubscribe = !empty($this->request->post['set_unsubscribe']) ? 1 : false;
				$control_unsubscribe = !empty($this->request->post['control_unsubscribe']) ? 1 : false;
				
				$dopurl = !empty($this->request->post['dopurl']) ? $this->request->post['dopurl'] : '';
				
				if (!empty($this->request->post['set_language']) && !empty($this->request->post['language_id'])) {
					$language_id = $this->request->post['language_id'];
					$lang_id = $language_id;
				} else {
					$language_id = false;
					$lang_id = $this->config->get('config_language_id');
				}

				if (!empty($this->request->post['set_planguage']) && !empty($this->request->post['planguage_id'])) {
					$lang_id = $this->request->post['planguage_id'];
				}

				$shop_country = $this->model_sale_contacts->getCountry($this->config->get('config_country_id'));
				$shop_zone = $this->model_sale_contacts->getZone($this->config->get('config_zone_id'));
				
				$store_id = $this->request->post['store_id'];
				$cgroup_id = $this->config->get('config_customer_group_id');
				
				$reply_badem = explode('|', $this->config->get('contacts_reply_badem'));
				$bad_email_action = $this->config->get('contacts_bad_eaction') ? $this->config->get('contacts_bad_eaction') : 0;
				
				$special = '';
				$bestseller = '';
				$latest = '';
				$featured = '';
				$selproducts = '';
				$catproducts = '';
				$add_purchased = false;
				
				if ($send_products) {
					if (!empty($this->request->post['purchased'])) {
						if ($this->request->post['purchased_limit'] && ($this->request->post['purchased_limit'] > 0)) {
							$purchased_limit = $this->request->post['purchased_limit'];
						} else {
							$purchased_limit = 4;
						}
	
						if ($this->request->post['purchased_title']) {
							$purchased_title = $this->request->post['purchased_title'];
						} else {
							$purchased_title = $this->language->get('purchased_title');
						}
	
						if ($page == 1) {
							$data_purchased = array(
								'type'     => 'purchased',
								'title'    => $purchased_title,
								'qty'      => $purchased_limit,
								'cat_id'   => '',
								'cat_each' => '',
								'products' => ''
							);
	
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_purchased);
						}
	
						$add_purchased = true;
					}
// added 02.08.20	
/*
					if (!empty($this->request->post['special'])) {
						if ($this->request->post['special_limit'] && ($this->request->post['special_limit'] > 0)) {
							$special_limit = $this->request->post['special_limit'];
						} else {
							$special_limit = 4;
						}
						
						if ($this->request->post['special_title']) {
							$special_title = $this->request->post['special_title'];
						} else {
							$special_title = $this->language->get('special_title');
						}
						
						$special_products = array();
						
						if (!$add_cron) {
							$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$special_limit);
							
							if (!isset($special_cache_data)) {
								$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit, $lang_id, $store_id);
								if (!empty($specials)) {
									$special_products = $this->getMailProducts($specials);
								}
								$this->cache->set('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$special_limit, $special_products);
							} else {
								$special_products = $special_cache_data;
							}
						}

						if ($special_products) {
							$special_template = new Template();
							$special_template->data['title'] = $special_title;
							$special_template->data['products'] = $special_products;
							$special = $special_template->fetch('mail/contacts_products.tpl');
						}
						
						if ($page == 1) {
							$data_special = array(
								'type'     => 'special',
								'title'    => $special_title,
								'qty'      => $special_limit,
								'cat_id'   => '',
								'cat_each' => '',
								'products' => ''
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_special);
						}
					}
					
					if (!empty($this->request->post['bestseller'])) {
						if ($this->request->post['bestseller_limit'] && ($this->request->post['bestseller_limit'] > 0)) {
							$bestseller_limit = $this->request->post['bestseller_limit'];
						} else {
							$bestseller_limit = 4;
						}
						
						if ($this->request->post['bestseller_title']) {
							$bestseller_title = $this->request->post['bestseller_title'];
						} else {
							$bestseller_title = $this->language->get('bestseller_title');
						}
						
						$bestseller_products = array();
						
						if (!$add_cron) {
							$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$bestseller_limit);
							
							if (!isset($bestseller_cache_data)) {
								$bestsellers = $this->model_sale_contacts->getBestSellerProducts($bestseller_limit, $lang_id, $store_id);
								if (!empty($bestsellers)) {
									$bestseller_products = $this->getMailProducts($bestsellers);
								}
								$this->cache->set('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$bestseller_limit, $bestseller_products);
							} else {
								$bestseller_products = $bestseller_cache_data;
							}
						}
						
						if ($bestseller_products) {
							$bestseller_template = new Template();
							$bestseller_template->data['title'] = $bestseller_title;
							$bestseller_template->data['products'] = $bestseller_products;
							$bestseller = $bestseller_template->fetch('mail/contacts_products.tpl');
						}
						
						if ($page == 1) {
							$data_bestseller = array(
								'type'     => 'bestseller',
								'title'    => $bestseller_title,
								'qty'      => $bestseller_limit,
								'cat_id'   => '',
								'cat_each' => '',
								'products' => ''
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_bestseller);
						}
					}
					
					if (!empty($this->request->post['latest'])) {
						if ($this->request->post['latest_limit'] && ($this->request->post['latest_limit'] > 0)) {
							$latest_limit = $this->request->post['latest_limit'];
						} else {
							$latest_limit = 4;
						}
						
						if ($this->request->post['latest_title']) {
							$latest_title = $this->request->post['latest_title'];
						} else {
							$latest_title = $this->language->get('latest_title');
						}
						
						$latest_products = array();
						
						if (!$add_cron) {
							$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$latest_limit);
							
							if (!isset($latest_cache_data)) {
								$latests = $this->model_sale_contacts->getLatestProducts($latest_limit, $lang_id, $store_id);
								if (!empty($latests)) {
									$latest_products = $this->getMailProducts($latests);
								}
								$this->cache->set('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$latest_limit, $latest_products);
							} else {
								$latest_products = $latest_cache_data;
							}
						}
						
						if ($latest_products) {
							$latest_template = new Template();
							$latest_template->data['title'] = $latest_title;
							$latest_template->data['products'] = $latest_products;
							$latest = $latest_template->fetch('mail/contacts_products.tpl');	
						}
						
						if ($page == 1) {
							$data_latest = array(
								'type'     => 'latest',
								'title'    => $latest_title,
								'qty'      => $latest_limit,
								'cat_id'   => '',
								'cat_each' => '',
								'products' => ''
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_latest);
						}
					}
					
					if (!empty($this->request->post['featured'])) {
						if ($this->request->post['featured_limit'] && ($this->request->post['featured_limit'] > 0)) {
							$featured_limit = $this->request->post['featured_limit'];
						} else {
							$featured_limit = 4;
						}
						
						if ($this->request->post['featured_title']) {
							$featured_title = $this->request->post['featured_title'];
						} else {
							$featured_title = $this->language->get('featured_title');
						}
						
						$featured_products = array();
						
						if (!$add_cron) {
							$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$featured_limit);
						
							if (!isset($featured_cache_data)) {
								$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit, $lang_id, $store_id);
								if (!empty($featureds)) {
									$featured_products = $this->getMailProducts($featureds);
								}
								$this->cache->set('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$featured_limit, $featured_products);
							} else {
								$featured_products = $featured_cache_data;
							}
						}

						if ($featured_products) {
							$featured_template = new Template();
							$featured_template->data['title'] = $featured_title;
							$featured_template->data['products'] = $featured_products;
							$featured = $featured_template->fetch('mail/contacts_products.tpl');
						}
						
						if ($page == 1) {
							$data_featured = array(
								'type'     => 'featured',
								'title'    => $featured_title,
								'qty'      => $featured_limit,
								'cat_id'   => '',
								'cat_each' => '',
								'products' => ''
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_featured);
						}
					}

					if (!empty($this->request->post['selectproducts']) && isset($this->request->post['selproducts']) && is_array($this->request->post['selproducts'])) {
						if ($this->request->post['selproducts_title']) {
							$selproducts_title = $this->request->post['selproducts_title'];
						} else {
							$selproducts_title = $this->language->get('selproducts_title');
						}
						
						$selected_products = array();
						
						if (!$add_cron) {
							$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id);
							
							if (!isset($selected_cache_data)) {
								$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts'], $lang_id);
								if (!empty($selecteds)) {
									$selected_products = $this->getMailProducts($selecteds);
								}
								$this->cache->set('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id, $selected_products);
							} else {
								$selected_products = $selected_cache_data;
							}
						}

						if ($selected_products) {
							$selproducts_template = new Template();
							$selproducts_template->data['title'] = $selproducts_title;
							$selproducts_template->data['products'] = $selected_products;
							$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');					
						}
						
						if ($page == 1) {
							$data_selproducts = array(
								'type'     => 'selproducts',
								'title'    => $selproducts_title,
								'qty'      => '',
								'cat_id'   => '',
								'cat_each' => '',
								'products' => implode(',', $this->request->post['selproducts'])
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_selproducts);
						}
					}
					
					if (!empty($this->request->post['catselectproducts']) && isset($this->request->post['catproducts']) && is_array($this->request->post['catproducts'])) {
						if ($this->request->post['catproducts_limit'] && ($this->request->post['catproducts_limit'] > 0)) {
							$catproducts_limit = $this->request->post['catproducts_limit'];
						} else {
							$catproducts_limit = 4;
						}
						
						if ($this->request->post['catproducts_title']) {
							$catproducts_title = $this->request->post['catproducts_title'];
						} else {
							$catproducts_title = $this->language->get('catproducts_title');
						}
						
						if (isset($this->request->post['catproducts_each'])) {
							$catproducts_each = 1;
						} else {
							$catproducts_each = 0;
						}
						
						$category_products = array();
						
						if (!$add_cron) {
							$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$catproducts_limit);
							
							if (!isset($catproduct_cache_data)) {
								if ($catproducts_each) {
									foreach ($this->request->post['catproducts'] as $pcategory_id) {
										$allcatproducts[] = $this->model_sale_contacts->getProductsFromCat($pcategory_id, $catproducts_limit, $lang_id, $store_id);
									}
									foreach ($allcatproducts as $pid) {
										foreach ($pid as $key => $value) {
											$selcatproducts[$key] = $value;
										}
									}
								} else {
									$selcatproducts = $this->model_sale_contacts->getCatSelectedProducts($this->request->post['catproducts'], $catproducts_limit, $lang_id, $store_id);
								}						
								
								if (!empty($selcatproducts)) {
									$category_products = $this->getMailProducts($selcatproducts);
								}
								$this->cache->set('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$catproducts_limit, $category_products);
							} else {
								$category_products = $catproduct_cache_data;
							}
						}

						if ($category_products) {
							$category_products_template = new Template();
							$category_products_template->data['title'] = $catproducts_title;
							$category_products_template->data['products'] = $category_products;
							$catproducts = $category_products_template->fetch('mail/contacts_products.tpl');
						}
						
						if ($page == 1) {
							$data_catproducts = array(
								'type'     => 'catproducts',
								'title'    => $catproducts_title,
								'qty'      => $catproducts_limit,
								'cat_id'   => implode(',', $this->request->post['catproducts']),
								'cat_each' => $catproducts_each,
								'products' => ''
							);
							
							$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_catproducts);
						}
					}
*/ 
// added 02.08.20	
				}
				
				$left_total = 0;
				$emails = array();
				$attachments = array();
				$attachments_cat = array();
				$send_to_data = '';
				$send_attachments = '';
				$send_attachments_cat = '';
				$manual = '';
				
				if (isset($this->request->post['attachments']) && is_array($this->request->post['attachments'])) {
					foreach ($this->request->post['attachments'] as $attachment) {
						if (file_exists(DIR_DOWNLOAD . $attachment)) {
							$attachments[] = array(
								'path' => DIR_DOWNLOAD . $attachment
							);
						}
					}
					if ($attachments) {
						$send_attachments = implode(',', $this->request->post['attachments']);
					}
				}
				
				if (!empty($this->request->post['attachments_cat'])) {
					$send_attachments_cat = $this->request->post['attachments_cat'];
					$files_catalog = str_ireplace('/system/', $this->request->post['attachments_cat'], DIR_SYSTEM);
					
					if(is_dir($files_catalog)) {
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
				
				if ($spam_check) {
					if ($this->config->get('contacts_spamtest_url') == 'www.isnotspam.com') {
						$check_page = file_get_contents('http://www.isnotspam.com/');
						if($check_page !== false) {
							libxml_use_internal_errors(true);
							$blank = new DOMDocument;
							$blank->loadHTML($check_page);
							
							foreach ($blank->getElementsByTagName('input') as $input) {
								if ($input->hasAttribute('name')) {
									$input_name = $input->getAttribute('name');
									$ipos = strpos($input_name, 'email');
									if($ipos !== false) {
										$check_email = $input->getAttribute('value');
										$check_url = 'http://www.isnotspam.com/newlatestreport.php?email=' . urlencode($check_email);
										
										$emails[$check_email] = array(
											'customer_id'   => '',
											'firstname'     => 'Gordon',
											'lastname'      => 'Freeman',
											'country'       => '',
											'zone'          => '',
											'date_added'    => ''
										);
										
										break;
									}
								}
							}
							
							libxml_clear_errors();
							
							if ($emails) {
								$email_total = count($emails);
								$json['check_url'] = $check_url;
							} else {
								$this->cache->delete('contacts');
								$json['error']['warning'] = $this->language->get('error_spam_check');
							}
							
						} else {
							$this->cache->delete('contacts');
							$json['error']['warning'] = $this->language->get('error_spam_check');
						}
					
					} else {
						
						$rmail = '';
						$possible = '1234567890abcdifghjklmnoprstyvwz';
						$lpossible = utf8_strlen($possible);
						$length = 5;
						
						for ($i = 0; $i < $length;) {
							$char = substr($possible, mt_rand(0, $lpossible-1), 1);
							if (!strstr($rmail, $char)) {
								$rmail .= $char;
								$i++;
							}
						}
						
						$check_email = 'web-' . $rmail . '@mail-tester.com';
						$check_url = 'https://www.mail-tester.com/web-' . $rmail;
						
						$emails[$check_email] = array(
							'customer_id'   => '',
							'firstname'     => 'Gordon',
							'lastname'      => 'Freeman',
							'country'       => '',
							'zone'          => '',
							'date_added'    => ''
						);
						
						$email_total = count($emails);
						$json['check_url'] = $check_url;
					}
				}
				
				if (!$spam_check && ($page == 1)) {
					if ($this->request->post['to'] == 'customer_select') {
						if (!empty($this->request->post['customer']) && is_array($this->request->post['customer'])) {
							$send_to_data = implode(',', $this->request->post['customer']);
							if (!$invers_customer) {
								$static = 'static';
							}
						}
					}
					if (($this->request->post['to'] == 'customer_group') || ($this->request->post['to'] == 'client_group')) {
						if (!empty($this->request->post['customer_group_id']) && is_array($this->request->post['customer_group_id'])) {
							$send_to_data = implode(',', $this->request->post['customer_group_id']);
						}
					}
					if ($this->request->post['to'] == 'client_select') {
						if (!empty($this->request->post['client']) && is_array($this->request->post['client'])) {
							$post_clients = array();
							foreach ($this->request->post['client'] as $client) {
								$post_clients[] = $client['email'];
							}
							if ($post_clients) {
								$send_to_data = implode(',', $post_clients);
							}
							if (!$invers_client) {
								$static = 'static';
							}
						}
					}
					if ($this->request->post['to'] == 'send_group') {
						if (!empty($this->request->post['send_group_id']) && is_array($this->request->post['send_group_id'])) {
							$send_to_data = implode(',', $this->request->post['send_group_id']);
							$static = 'dinamic';
						}
					}
					if ($this->request->post['to'] == 'affiliate') {
						if (!empty($this->request->post['affiliate']) && is_array($this->request->post['affiliate'])) {
							$send_to_data = implode(',', $this->request->post['affiliate']);
							if (!$invers_affiliate) {
								$static = 'static';
							}
						}
					}
					if ($this->request->post['to'] == 'product') {
						if (!empty($this->request->post['product']) && is_array($this->request->post['product'])) {
							$send_to_data = implode(',', $this->request->post['product']);
						}
					}
					if ($this->request->post['to'] == 'category') {
						if (!empty($this->request->post['category']) && is_array($this->request->post['category'])) {
							$send_to_data = implode(',', $this->request->post['category']);
						}
					}
					if ($this->request->post['to'] == 'manual') {
						if (!empty($this->request->post['manual'])) {
							$manual = $this->request->post['manual'];
							$static = 'static';
						}
					}

					$data_send = array(
						'store_id'         => $this->request->post['store_id'],
						'send_to'          => $this->request->post['to'],
						'manual'           => $manual,
						'send_to_data'     => $send_to_data,
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
						'subject'          => $this->request->post['subject'],
						'message'          => $this->request->post['message'],
						'attachments'      => $send_attachments,
						'attachments_cat'  => $send_attachments_cat,
						'dopurl'           => $dopurl,
						'static'           => $static,
						'unsub_url'        => $set_unsubscribe,
						'control_unsub'    => $control_unsubscribe,
						'limit_start'      => $limit_start,
						'limit_end'        => $limit_end
					);
					
					$all_emails = $this->getAllEmails($data_send);
					
					$email_total = count($all_emails);
					
					$data_send['email_total'] = $email_total;
					$data_send['manual'] = '';
					
					if ($add_cron) {
						if ($static == 'static') {
							if ($all_emails) {
								$this->model_sale_contacts->addDataCron($cron_id, $data_send);
								$this->model_sale_contacts->saveEmailsToCron($cron_id, $all_emails);
								$contacts_log->write($this->language->get('text_add_cron'));
								$json['add_cron'] = 1;
								$json['success'] = $this->language->get('text_success_cron');
							} else {
								$this->model_sale_contacts->delCron($cron_id);
								$contacts_log->write($this->language->get('error_noemails'));
								$json['error']['warning'] = $this->language->get('error_noemails');
							}
						} else {
							$this->model_sale_contacts->addDataCron($cron_id, $data_send);
							$contacts_log->write($this->language->get('text_add_cron'));
							$json['add_cron'] = 1;
							$json['success'] = $this->language->get('text_success_cron');
						}
						$this->cache->delete('contacts');
					} else {
						if ($all_emails) {
							$this->model_sale_contacts->setDataNewSend($send_id, $data_send);
							$this->model_sale_contacts->saveEmailsToSend($send_id, $all_emails);
							$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
						} else {
							$this->cache->delete('contacts');
							$this->model_sale_contacts->delDataSend($send_id);
							$contacts_log->write($this->language->get('error_noemails'));
							$json['error']['warning'] = $this->language->get('error_noemails');
						}
					}
				}
				
				if (!$json['error']) {
					if (!$spam_check && !$add_cron) {
						$results = $this->model_sale_contacts->getEmailsToSend($send_id, $contacts_count_message);

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
						
						$left_total = $this->model_sale_contacts->getTotalEmailsToSend($send_id);
					}
				
					if ($emails && !$add_cron) {
						if ($page > 1) {
							sleep($contacts_sleep_time);
						} else {
							sleep(2);
						}

						$lastsend = 0;
						$count_emails = count($emails);
						$savemessage = '';
						$error_limit = false;
						
						if ($spam_check) {
							$count_send_error = 0;
						} else {
							$count_send_error = $this->model_sale_contacts->getErrorsSend($send_id);
						}
						
						if (isset($email_total)) {
							$json['info'] = sprintf($this->language->get('text_send_info'), $email_total);
						}
						
						if ($count_emails < $left_total) {
							$json['success'] = sprintf($this->language->get('text_send'), $left_total);
						} else {
							$json['success'] = $this->language->get('text_success') . '<br />' . $this->language->get('text_end_send');
							$lastsend = 1;
						}
						
						if ($count_emails < $left_total) {
							$json['next'] = str_replace('&amp;', '&', $this->url->link('sale/contacts/send', 'sid=' . $send_id . '&token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
						} else {
							$json['next'] = '';
						}
						
						if ($spam_check) {
							$json['next'] = '';
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
						
						$subjects = explode('|', $this->request->post['subject']);
						
						if (($this->config->get('contacts_retpath_email')) && (trim($this->config->get('contacts_retpath_email')) != '')) {
							$retpath_email = trim($this->config->get('contacts_retpath_email'));
						} else {
							$retpath_email = false;
						}
							
						foreach ($emails as $email => $customer) {
							if ($count_send_error < $contacts_count_error) {
								if ($this->config->get('contacts_global_limith') && $this->config->get('contacts_global_limitd')) {
									$total_mails = $this->model_sale_contacts->getCountMails();
									
									if ($total_mails['hour'] >= $this->config->get('contacts_global_limith')) {
										$contacts_log->write(strip_tags($this->language->get('error_limit_hour')));
										$json['error']['warning'] = $this->language->get('error_limit_hour');
										$error_limit = true;
									}
									if ($total_mails['day'] >= $this->config->get('contacts_global_limitd')) {
										$contacts_log->write(strip_tags($this->language->get('error_limit_day')));
										$json['error']['warning'] = $this->language->get('error_limit_day');
										$error_limit = true;
									}
									
									$json['hour'] = $this->config->get('contacts_global_limith') - $total_mails['hour'];
									$json['day'] = $this->config->get('contacts_global_limitd') - $total_mails['day'];
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
	
										$unsubscribe_url = HTTP_CATALOG . 'index.php?route=account/success&sid=' . $sid;
	
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
	
											$purchaseds = $this->model_sale_contacts->getPurchasedsProducts($filter_purchased);
											if (!empty($purchaseds)) {
												$purchased_products = $this->getMailProducts($purchaseds);
											}
	
											if ($purchased_products) {
												$purchased_template = new Template();
												$purchased_template->data['title'] = $purchased_title;
												$purchased_template->data['products'] = $purchased_products;
												$buyproducts = $purchased_template->fetch('mail/contacts_products.tpl');
											}
										}
	
										$shopname = $store_name;
										$shopurl = '<a href="' . $store_url . '">' . $store_name . '</a>';
										
										$tegi_subject = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}');
										$tegi_message = array('{firstname}','{lastname}','{name}','{country}','{zone}','{shopname}','{shopurl}','{special}','{bestseller}','{latest}','{featured}','{selproducts}','{catproducts}','{buyproducts}','{unsub}');
										
// added 02.07.20 $special, $bestseller, $latest, $featured, $selproducts, $catproducts 2986  
										$special = '';
										$bestseller = '';
										$latest = '';
										$featured = '';
										$selproducts = '';
										$catproducts = '';

										if (!empty($this->request->post['set_language']) && !empty($this->request->post['language_id'])) {
											$language_id = $this->request->post['language_id'];
											$lang_id = $language_id;
										} else {
											$language_id = false;
											$lang_id = $this->config->get('config_language_id');
										}

										if (!empty($this->request->post['set_planguage']) && !empty($this->request->post['planguage_id'])) {
											$lang_id = $this->request->post['planguage_id'];
										}

										if (isset($this->request->post['special']) && $this->request->post['special']) {
											if ($this->request->post['special_limit'] && ($this->request->post['special_limit'] > 0)) {
												$special_limit = $this->request->post['special_limit'];
											} else {
												$special_limit = 4;
											}
											
											if ($this->request->post['special_title']) {
												$special_title = $this->request->post['special_title'];
											} else {
												$special_title = $this->language->get('special_title');
											}
											
											$special_products = array();
											
											if (!$add_cron) {
												$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit);
												if (!empty($specials)) {
													$special_products = $this->getMailProducts($specials, $customer_group_id, $customer['customer_id']);
												}
											}

											if ($special_products) {
												$special_template = new Template();
												$special_template->data['title'] = $special_title;
												$special_template->data['products'] = $special_products;
												$special = $special_template->fetch('mail/contacts_products.tpl');
											} else {
												$special = '';
											}
											
											if ($page == 1) {
												$data_special = array(
													'type'     => 'special',
													'title'    => $special_title,
													'qty'      => $special_limit,
													'cat_id'   => '',
													'cat_each' => '',
													'products' => ''
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_special);
											}
										}
										
										if (isset($this->request->post['bestseller']) && $this->request->post['bestseller']) {
											if ($this->request->post['bestseller_limit'] && ($this->request->post['bestseller_limit'] > 0)) {
												$bestseller_limit = $this->request->post['bestseller_limit'];
											} else {
												$bestseller_limit = 4;
											}
											
											if ($this->request->post['bestseller_title']) {
												$bestseller_title = $this->request->post['bestseller_title'];
											} else {
												$bestseller_title = $this->language->get('bestseller_title');
											}
											
											$bestseller_products = array();
											
											if (!$add_cron) {
												$bestsellers = $this->model_sale_contacts->getBestsellerProducts($bestseller_limit);
												if (!empty($bestsellers)) {
													$bestseller_products = $this->getMailProducts($bestsellers, $customer_group_id, $customer['customer_id']);
												}
											}
											
											if ($bestseller_products) {
												$bestseller_template = new Template();
												$bestseller_template->data['title'] = $bestseller_title;
												$bestseller_template->data['products'] = $bestseller_products;
												$bestseller = $bestseller_template->fetch('mail/contacts_products.tpl');
											} else {
												$bestseller = '';
											}
											
											if ($page == 1) {
												$data_bestseller = array(
													'type'     => 'bestseller',
													'title'    => $bestseller_title,
													'qty'      => $bestseller_limit,
													'cat_id'   => '',
													'cat_each' => '',
													'products' => ''
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_bestseller);
											}
											
										}
										
										if (isset($this->request->post['latest']) && $this->request->post['latest']) {
											if ($this->request->post['latest_limit'] && ($this->request->post['latest_limit'] > 0)) {
												$latest_limit = $this->request->post['latest_limit'];
											} else {
												$latest_limit = 4;
											}
											
											if ($this->request->post['latest_title']) {
												$latest_title = $this->request->post['latest_title'];
											} else {
												$latest_title = $this->language->get('latest_title');
											}
											
											$latest_products = array();
											
											if (!$add_cron) {
												$latests = $this->model_sale_contacts->getLatestProducts($latest_limit);
												if (!empty($latests)) {
													$latest_products = $this->getMailProducts($latests, $customer_group_id, $customer['customer_id']);
												}
											}
											
											if ($latest_products) {
												$latest_template = new Template();
												$latest_template->data['title'] = $latest_title;
												$latest_template->data['products'] = $latest_products;
												$latest = $latest_template->fetch('mail/contacts_products.tpl');	
											} else {
												$latest = '';
											}
											
											if ($page == 1) {
												$data_latest = array(
													'type'     => 'latest',
													'title'    => $latest_title,
													'qty'      => $latest_limit,
													'cat_id'   => '',
													'cat_each' => '',
													'products' => ''
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_latest);
											}

										}
										
										if (isset($this->request->post['featured']) && $this->request->post['featured']) {
											if ($this->request->post['featured_limit'] && ($this->request->post['featured_limit'] > 0)) {
												$featured_limit = $this->request->post['featured_limit'];
											} else {
												$featured_limit = 4;
											}
											
											if ($this->request->post['featured_title']) {
												$featured_title = $this->request->post['featured_title'];
											} else {
												$featured_title = $this->language->get('featured_title');
											}
											
											$featured_products = array();
											
											if (!$add_cron) {
												$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit);
												if (!empty($featureds)) {
													$featured_products = $this->getMailProducts($featureds, $customer_group_id, $customer['customer_id']);
												}
											}

											if ($featured_products) {
												$featured_template = new Template();
												$featured_template->data['title'] = $featured_title;
												$featured_template->data['products'] = $featured_products;
												$featured = $featured_template->fetch('mail/contacts_products.tpl');
											} else {
												$featured = '';
											}
											
											if ($page == 1) {
												$data_featured = array(
													'type'     => 'featured',
													'title'    => $featured_title,
													'qty'      => $featured_limit,
													'cat_id'   => '',
													'cat_each' => '',
													'products' => ''
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_featured);
											}
											
										}

										if (isset($this->request->post['selectproducts']) && isset($this->request->post['selproducts']) && is_array($this->request->post['selproducts'])) {
											if ($this->request->post['selproducts_title']) {
												$selproducts_title = $this->request->post['selproducts_title'];
											} else {
												$selproducts_title = $this->language->get('selproducts_title');
											}
											
											$selected_products = array();
											
											if (!$add_cron) {
												$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts'], $lang_id);
												if (!empty($selecteds)) {
													$selected_products = $this->getMailProducts($selecteds, $customer_group_id, $customer['customer_id']);
												}
											}

											if ($selected_products) {
												$selproducts_template = new Template();
												$selproducts_template->data['title'] = $selproducts_title;
												$selproducts_template->data['products'] = $selected_products;
												$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');					
											} else {
												$selproducts = '';
											}
											
											if ($page == 1) {
												$data_selproducts = array(
													'type'     => 'selproducts',
													'title'    => $selproducts_title,
													'qty'      => '',
													'cat_id'   => '',
													'cat_each' => '',
													'products' => implode(',', $this->request->post['selproducts'])
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_selproducts);
											}
											
										}
										
										if (isset($this->request->post['catselectproducts']) && isset($this->request->post['catproducts']) && is_array($this->request->post['catproducts'])) {
											if ($this->request->post['catproducts_limit'] && ($this->request->post['catproducts_limit'] > 0)) {
												$catproducts_limit = $this->request->post['catproducts_limit'];
											} else {
												$catproducts_limit = 4;
											}
											
											if ($this->request->post['catproducts_title']) {
												$catproducts_title = $this->request->post['catproducts_title'];
											} else {
												$catproducts_title = $this->language->get('catproducts_title');
											}
											
											if (isset($this->request->post['catproducts_each'])) {
												$catproducts_each = 1;
											} else {
												$catproducts_each = 0;
											}
											
											$category_products = array();
											
											if (!$add_cron) {
												if ($catproducts_each) {
													foreach ($this->request->post['catproducts'] as $pcategory_id) {
														$allcatproducts[] = $this->model_sale_contacts->getProductsFromCat($pcategory_id, $catproducts_limit);
													}

													foreach ($allcatproducts as $pid) {
														foreach ($pid as $key => $value) {
															$selcatproducts[$key] = $value;
														}
													}
												} else {
													$selcatproducts = $this->model_sale_contacts->getCatSelectedProducts($this->request->post['catproducts'], $catproducts_limit);
												}						
												
												if (!empty($selcatproducts)) {
													$category_products = $this->getMailProducts($selcatproducts, $customer_group_id, $customer['customer_id']);
												}
											}

											if ($category_products) {
												$category_products_template = new Template();
												$category_products_template->data['title'] = $catproducts_title;
												$category_products_template->data['products'] = $category_products;
												$catproducts = $category_products_template->fetch('mail/contacts_products.tpl');
											} else {
												$catproducts = '';
											}
											
											if ($page == 1) {
												$data_catproducts = array(
													'type'     => 'catproducts',
													'title'    => $catproducts_title,
													'qty'      => $catproducts_limit,
													'cat_id'   => implode(',', $this->request->post['catproducts']),
													'cat_each' => $catproducts_each,
													'products' => ''
												);
												
												$this->model_sale_contacts->setProductToSend($send_id, $cron_id, $data_catproducts);
											}
											
										}

										$email_total = 0;
										$emails = array();
										$emails_cache = array();
										$attachments = array();
										$send_to_data = '';
										$send_attachments = '';
// added 02.07.20 $special, $bestseller, $latest, $featured, $selproducts, $catproducts 3378						
										
										$replace_subject = array($firstname, $lastname, $name, $country, $zone, $shopname);
										$replace_message = array($firstname, $lastname, $name, $country, $zone, $shopname, $shopurl, $special, $bestseller, $latest, $featured, $selproducts, $catproducts, $buyproducts, $unsub);
										
										if (count($subjects) > 1) {
											$number = mt_rand(0, count($subjects) - 1);
											$orig_subject = trim($subjects[$number]);
										} else {
											$orig_subject = trim($subjects[0]);
										}
		
										$orig_message = $this->request->post['message'];
		
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
		
										$controlimage = HTTP_CATALOG . 'index.php?route=feed/stats/images&sid=' . $sid;
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
													$new_url = HTTP_CATALOG . 'index.php?route=feed/stats/clck&sid=' . $sid . '&link=' . $ateg_url;
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
										$contacts_log->write($this->language->get('text_send_email') . $email);
										$send_status = $mail->send();
		
										if ($send_status == 55) {
											$this->model_sale_contacts->removeEmailSend($send_id, $email);
										} elseif (substr($send_status, 0, 4) == 'cerr') {
											$lastsend = 0;
											$json['success'] = '';
											$json['next'] = '';
											$json['error']['warning'] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_stop_send');
											$json['stop_send'] = $send_id;
											break;
										} elseif (substr($send_status, 0, 4) == 'nerr') {
											$json['attention'][] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_continues_send');
											$bad_email = false;
											
											if (substr($send_status, 4, 2) == '24') {
												$this->model_sale_contacts->removeEmailSend($send_id, $email);
											}
											
											if ((substr($send_status, 4, 2) == '21') || (substr($send_status, 4, 2) == '22') || (substr($send_status, 4, 2) == '23')) {
												$this->model_sale_contacts->removeEmailSend($send_id, $email);
												
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
													$this->model_sale_contacts->addUnsubscribe($email, $send_id, $customer['customer_id']);
													$contacts_log->write($this->language->get('text_bad_email_unsub'));
												}
												if ($bad_email_action == '2') {
													$this->model_sale_contacts->addUnsubscribe($email, $send_id, $customer['customer_id']);
													$this->model_sale_contacts->delNewsletterFromEmail($email);
													$contacts_log->write($this->language->get('text_bad_email_remove'));
												}
											} else {
												$this->model_sale_contacts->addErrorSend($send_id);
												$count_send_error++;
											}
										} else {
											$this->model_sale_contacts->addErrorSend($send_id);
											$count_send_error++;
										}
										$this->model_sale_contacts->addCountMails($send_id, 0, 1);
										$json['hour']--;
										$json['day']--;
									} else {
										$contacts_log->write($this->language->get('text_bad_email') . $email);
										$this->model_sale_contacts->removeEmailSend($send_id, $email);
										
										if ($bad_email_action == '1') {
											$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
											$contacts_log->write($this->language->get('text_bad_email_unsub'));
										}
										if ($bad_email_action == '2') {
											$this->model_sale_contacts->addUnsubscribe($email, $msend_id, $customer['customer_id']);
											$this->model_sale_contacts->delNewsletterFromEmail($email);
											$contacts_log->write($this->language->get('text_bad_email_remove'));
										}
									}
								} else {
									$lastsend = 0;
									$json['success'] = '';
									$json['next'] = '';
									$json['stop_send'] = $send_id;
									break;
								}
							} else {
								$contacts_log->write(strip_tags($this->language->get('error_send_count')));
								$lastsend = 0;
								$json['success'] = '';
								$json['next'] = '';
								$json['error']['warning'] = $this->language->get('error_send_count');
								$json['stop_send'] = $send_id;
								break;
							}
						}

						if (!$spam_check && ($page == 1)) {
							$savemessage = htmlspecialchars($savemessage, ENT_COMPAT, 'UTF-8');
							$this->model_sale_contacts->setNewMessageDataSend($send_id, $savemessage);
						}
	
						if($lastsend == 1) {
							$this->cache->delete('contacts');
							$contacts_log->write($this->language->get('text_end_send'));
							if(!$spam_check) {
								$this->model_sale_contacts->setCompleteDataSend($send_id);
								$this->model_sale_contacts->delProductSend($send_id);
								$this->model_sale_contacts->delEmailsSend($send_id);
	
								if ($attachments) {
									foreach ($attachments as $attachment) {
										if (file_exists($attachment['path'])) {
											@unlink($attachment['path']);
										}
									}
								}
							}
						}
					}
				}
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function checkemail() {
		$json = array();

		$contacts_log = new Log('contacts.log');
		$this->language->load('sale/contacts');
	
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('sale/contacts');
	
			if (!$this->validate()) {
				$json['error'] = $this->language->get('error_permission');
			}
	
			if (!$json) {
				$static = !empty($this->request->post['static']) ? $this->request->post['static'] : 'dinamic';
				$control_unsubscribe = !empty($this->request->post['control_unsubscribe']) ? 1 : 0;
	
				$emnovalid_action = !empty($this->request->post['emnovalid_action']) ? $this->request->post['emnovalid_action'] : 0;
				$embad_action = !empty($this->request->post['embad_action']) ? $this->request->post['embad_action'] : 0;
				$emsuspect_action = !empty($this->request->post['emsuspect_action']) ? $this->request->post['emsuspect_action'] : 0;
	
				$manual = '';
				$send_to_data = '';
				$emails = array();
	
				$data_cron = array(
					'name'     => $this->language->get('text_checke_cron'),
					'checking' => 1,
					'status'   => 0
				);
	
				$cron_id = $this->model_sale_contacts->addNewCron($data_cron);
	
				if (($this->request->post['to_check'] == 'customer_group') || ($this->request->post['to_check'] == 'client_group')) {
					if (!empty($this->request->post['customer_group_id']) && is_array($this->request->post['customer_group_id'])) {
						$send_to_data = implode(',', $this->request->post['customer_group_id']);
					}
				}
				if ($this->request->post['to_check'] == 'send_group') {
					if (!empty($this->request->post['send_group_id']) && is_array($this->request->post['send_group_id'])) {
						$send_to_data = implode(',', $this->request->post['send_group_id']);
						$static = 'dinamic';
					}
				}
				if ($this->request->post['to_check'] == 'manual') {
					if (!empty($this->request->post['manual'])) {
						$manual = $this->request->post['manual'];
						$static = 'static';
					}
				}
	
				$data_send = array(
					'store_id'         => $this->request->post['store_id'],
					'send_to'          => $this->request->post['to_check'],
					'manual'           => $manual,
					'send_to_data'     => $send_to_data,
					'date_start'       => '',
					'date_end'         => '',
					'send_region'      => '',
					'send_country_id'  => '',
					'send_zone_id'     => '',
					'invers_region'    => '',
					'invers_product'   => '',
					'invers_category'  => '',
					'invers_customer'  => '',
					'invers_client'    => '',
					'invers_affiliate' => '',
					'send_products'    => '',
					'lang_products'    => '',
					'language_id'      => '',
					'subject'          => '1',
					'message'          => '1',
					'attachments'      => '',
					'attachments_cat'  => '',
					'dopurl'           => '',
					'static'           => $static,
					'unsub_url'        => '',
					'control_unsub'    => $control_unsubscribe,
					'limit_start'      => '',
					'limit_end'        => '',
					'emnovalid_action' => $emnovalid_action,
					'embad_action'     => $embad_action,
					'emsuspect_action' => $emsuspect_action
				);
	
				$emails = $this->getAllEmails($data_send);
	
				if ($emails && $this->config->get('contacts_ignore_servers')) {
					$fi_emails = $emails;
					$config_ignore_servers = preg_replace('/\s/', '', $this->config->get('contacts_ignore_servers'));
	
					if ($config_ignore_servers != '') {
						$ignore_servers = explode('|', $this->config->get('contacts_ignore_servers'));

						if (!empty($ignore_servers)) {
							foreach($emails as $email => $value){
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
							$emails = $fi_emails;
						}
					}
				}
	
				$email_total = count($emails);
	
				$data_send['email_total'] = $email_total;
				$data_send['manual'] = '';
	
				if ($static == 'static') {
					if ($emails) {
						$this->model_sale_contacts->addDataCron($cron_id, $data_send);
						$this->model_sale_contacts->saveEmailsToCron($cron_id, $emails);
						$contacts_log->write($this->language->get('text_add_croncke'));
						$json['success'] = sprintf($this->language->get('text_success_croncke'), $email_total);
					} else {
						$this->model_sale_contacts->delCron($cron_id);
						$json['error'] = $this->language->get('error_noemails');
					}
				} else {
					$this->model_sale_contacts->addDataCron($cron_id, $data_send);
					$contacts_log->write($this->language->get('text_add_croncke'));
					$json['success'] = sprintf($this->language->get('text_success_croncke'), $email_total);
				}
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function viewcheckresult() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['cid']) && isset($this->request->get['cst'])) {
			$this->load->model('sale/contacts');
	
			$data = array(
				'check_status' => $this->request->get['cst']
			);
	
			$emails = $this->model_sale_contacts->getCheckCronResultEmails($this->request->get['cid'], $data);
	
			if (!empty($emails)) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;width:700px;margin:5px 20px 5px 5px;position:relative;">';
				$message .= '<table id="checks_' . $this->request->get['cid'] . '" class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td style="width:78px;">' . $this->language->get('column_action') . '</td><td>' . $this->language->get('column_check_text') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
	
				foreach($emails as $email){
					$unsub = $this->model_sale_contacts->checkEmailUnsubscribe($email['email']);
	
					$message .= '<tr>';
					$message .= '<td>' . $email['email'] . '</td>';
					$message .= '<td class="right">';
					if (!$unsub) {
						$message .= '<a onclick="togcheckemails(1,\'' . $email['email'] . '\');$(this).hide();" class="btn btn-munsubscr" title="' . $this->language->get('text_unsubs') . '"></a>';
					}
					$message .= '<a onclick="togcheckemails(2,\'' . $email['email'] . '\');$(this).hide().parent().parent().css(\'opacity\',\'0.5\');" class="btn btn-mremove" title="' . $this->language->get('text_delete') . '"></a></td>';
					$message .= '<td class="right">' . $email['check_text'] . '</td>';
					$message .= '</tr>';
				}
	
				$message .= '</tbody>';
				$message .= $this->getgrouphtml($this->request->get['cid'], 'checks', $this->request->get['cst']);
				$message .= '</table>';
				$message .= '<div id="action_info"></div>';
				$message .= '</div></div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function togcheckresult() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (isset($this->request->get['mode']) && isset($this->request->get['email'])) {
				$this->load->model('sale/contacts');
				if ($this->request->get['mode'] == '1') {
					$this->model_sale_contacts->addUnsubscribe($this->request->get['email']);
					$json['success'] = $this->language->get('text_unsubs_ok');
				} elseif ($this->request->get['mode'] == '2') {
					$this->model_sale_contacts->delNewsletterFromEmail($this->request->get['email']);
					$json['success'] = $this->language->get('text_delete_ok');
				} else {
					$json['error'] = $this->language->get('error_operation');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}

	public function updatemisssend() {
		$json = array();
		$this->language->load('sale/contacts');

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$msend_info = $this->model_sale_contacts->getDataSend($this->request->get['sid']);
	
			if (!empty($msend_info)) {
				$count_miss_emails = $this->model_sale_contacts->getTotalEmailsToSend($this->request->get['sid']);
	
				$json['send_id'] = $msend_info['send_id'];
				$json['send_alarm'] = $this->language->get('missins_send_error');
				$json['send_date'] = sprintf($this->language->get('missins_send_date'), $msend_info['date_added']);
				$json['send_title'] = sprintf($this->language->get('missins_send_title'), utf8_substr(html_entity_decode($msend_info['subject'], ENT_QUOTES, 'UTF-8'), 0, 30) . '..');
				$json['send_to'] = sprintf($this->language->get('missins_send_to'), $this->language->get('text_' . $msend_info['send_to']));
				$json['send_count'] = sprintf($this->language->get('missins_send_count'), $count_miss_emails, $msend_info['email_total']);
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function misstocomplete() {
		$json = array();
		$this->language->load('sale/contacts');

		if (isset($this->request->get['msid']) && $this->validate()) {
			$send_id = $this->request->get['msid'];
			$this->load->model('sale/contacts');
	
			$msend_info = $this->model_sale_contacts->getDataSend($send_id);
			$emails_total = $msend_info['email_total'];

			$count_miss_emails = $this->model_sale_contacts->getTotalEmailsToSend($send_id);
	
			$result = $emails_total - $count_miss_emails;
	
			$this->model_sale_contacts->setCompleteDataSend($send_id, $result);
			$this->model_sale_contacts->delProductSend($send_id);
			$this->model_sale_contacts->delEmailsSend($send_id);

			$json['success'] = $this->language->get('text_misstocomplete_ok');

		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function delmailing() {
		$json = array();
		$this->language->load('sale/contacts');

		if (isset($this->request->get['sid']) && $this->validate()) {
			$this->load->model('sale/contacts');
	
			$this->model_sale_contacts->delDataSend($this->request->get['sid']);
			$json['success'] = $this->language->get('text_missremove_ok');

		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function viewmessage() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');
	
			if(!empty($this->request->get['new'])) {
				$send_message = $this->model_sale_contacts->getNewMessageSend($this->request->get['sid']);
			} else {
				$send_message = $this->model_sale_contacts->getMessageSend($this->request->get['sid']);
			}
	
			if ($send_message) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;margin:5px 20px 5px 5px;position:relative;">' . html_entity_decode($send_message, ENT_QUOTES, 'UTF-8') . '</div>';
				$message .= '</div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function viewunsubscribes() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$unsubscribes = $this->model_sale_contacts->getUnsubscribesfromSend($this->request->get['sid']);
	
			if (!empty($unsubscribes)) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;width:600px;margin:5px 20px 5px 5px;position:relative;">';
				$message .= '<table id="unsubs_' . $this->request->get['sid'] . '" class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td>' . $this->language->get('column_date_added') . '</td><td style="width:38px;">' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
	
				foreach($unsubscribes as $unsubscribe){
					$message .= '<tr>';
					$message .= '<td>' . $unsubscribe['email'] . '</td>';
					$message .= '<td class="center">' . $unsubscribe['date_added'] . '</td>';
					$message .= '<td class="center">' . $unsubscribe['customer_id'] . '</td>';
					$message .= '</tr>';
				}
	
				$message .= '</tbody>';
				$message .= $this->getgrouphtml($this->request->get['sid'], 'unsubs', '0');
				$message .= '</table></div></div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function viewopens() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$views = $this->model_sale_contacts->getViewsfromSend($this->request->get['sid']);
	
			if (!empty($views)) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;width:600px;margin:5px 20px 5px 5px;position:relative;">';
				$message .= '<table id="views_' . $this->request->get['sid'] . '" class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td width:78px;>' . $this->language->get('column_date_added') . '</td><td style="width:38px;">' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
	
				foreach($views as $view){
					$message .= '<tr>';
					$message .= '<td>' . $view['email'] . '</td>';
					$message .= '<td class="center">' . $view['date_added'] . '</td>';
					$message .= '<td class="center">' . $view['customer_id'] . '</td>';
					$message .= '</tr>';
				}
	
				$message .= '</tbody>';
				$message .= $this->getgrouphtml($this->request->get['sid'], 'views', '0');
				$message .= '</table></div></div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function viewclicks() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$clicks = $this->model_sale_contacts->getClicksfromSend($this->request->get['sid']);
	
			if (!empty($clicks)) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;width:700px;margin:5px 20px 5px 5px;position:relative;">';
				$message .= '<table id="clicks_' . $this->request->get['sid'] . '" class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td>' . $this->language->get('column_url') . '</td><td style="width:78px;">' . $this->language->get('column_date_added') . '</td><td style="width:38px;">' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
	
				foreach($clicks as $click){
					$message .= '<tr>';
					$message .= '<td>' . $click['email'] . '</td>';
					$message .= '<td>' . $click['target'] . '</td>';
					$message .= '<td class="center">' . $click['date_added'] . '</td>';
					$message .= '<td class="center">' . $click['customer_id'] . '</td>';
					$message .= '</tr>';
				}
	
				$message .= '</tbody>';
				$message .= $this->getgrouphtml($this->request->get['sid'], 'clicks', '0');
				$message .= '</table></div></div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function getgrouphtml($sid, $smode, $cst) {
		$message = '';
	
		$groups = $this->model_sale_contacts->getSendGroups();
	
		if (!empty($groups)) {
			$colspan = ($smode == 'clicks') ? 4 : 3;
			$message .= '<tfoot>';
			$message .= '<tr><td class="action" colspan="' . $colspan . '">';

			$message .= '<span>' . $this->language->get('text_action_togroup') . '</span>';
	
			$message .= '<select class="for_amode">';
			$message .= ' <option value="1">' . $this->language->get('text_add') . '</option>';
			$message .= ' <option value="2">' . $this->language->get('text_move') . '</option>';
			$message .= '</select>';
	
			$message .= '<span>' . $this->language->get('text_togroup') . '</span>';
	
			$message .= '<select class="for_groups">';
			foreach($groups as $group){
				$message .= ' <option value="' . $group['group_id'] . '">' . $group['name'] . '</option>';
			}
			$message .= '</select>';
	
			$message .= '<a onclick="import_from_stat(' . $sid . ', \'' . $smode . '\', \'' . $cst . '\');" class="btn btn-msuccess">' . $this->language->get('text_run') . '</a>';
	
			$message .= '</td></tr>';
			$message .= '</tfoot>';
		}
		return $message;
	}
	
	public function uploadattach() {
		$json = array();
		$json['error'] = array();
	
		$this->language->load('sale/contacts');
	
		if (!$this->validate()) {
			$json['error'][] = $this->language->get('error_permission');
		} else {
			$this->load->model('sale/contacts');
			$json['files_path'] = array();

			foreach($_FILES as $file){
				if (!empty($file['name'])) {
					$filename = html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8');

					if ($file['error'] != UPLOAD_ERR_OK) {
						$json['error'][] = $this->language->get('error_upload_' . $file['error']) . ' ' . $filename;
	
					} else {
						if (is_uploaded_file($file['tmp_name']) && file_exists($file['tmp_name'])) {
							$path = 'cfiles/' . $filename;
							$files_catalog = DIR_DOWNLOAD . 'cfiles/';
							if(!is_dir($files_catalog)) {
								@mkdir($files_catalog, 0755);
							}
	
							move_uploaded_file($file['tmp_name'], $files_catalog . $filename);

							$json['files_path'][] = array(
								'filename' => $filename,
								'path'     => $path
							);

							$json['success'] = $this->language->get('text_upload_ok');
	
						} else {
							$json['error'][] = $this->language->get('error_upload') . ' ' . $filename;
						}
					}
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function updatelog() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			$file = DIR_LOGS . 'contacts.log';
	
			if (file_exists($file)) {
				$json['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			} else {
				$json['log'] = '';
			}
	
			$json['success'] = $this->language->get('text_update_log');
	
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function clearlog() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			$file = DIR_LOGS . 'contacts.log';
			$handle = fopen($file, 'w+');
			fclose($handle);
			$json['success'] = $this->language->get('text_delete_log');
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function getcron() {
		$json = array();

		if (isset($this->request->get['cron_id'])) {
			$this->load->model('sale/contacts');
			$cron_data = $this->model_sale_contacts->getCron($this->request->get['cron_id']);
			$cron_info = $this->model_sale_contacts->getDataCron($this->request->get['cron_id']);
	
			if (!empty($cron_data)) {
				$json['name'] = html_entity_decode($cron_data['name'], ENT_QUOTES, 'UTF-8');
				$json['subject'] = html_entity_decode($cron_info['subject'], ENT_QUOTES, 'UTF-8');
				$json['message'] = html_entity_decode($cron_info['message'], ENT_QUOTES, 'UTF-8');
				$json['date_start'] = $cron_data['date_start'];
				$json['period'] = $cron_data['period'];
				$json['status'] = $cron_data['status'];
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function savecron() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['cron_name']) < 1) || (utf8_strlen($this->request->post['cron_name']) > 255)) {
				$json['error'] = $this->language->get('error_cron_name');
			}
	
			if (date('Y-m-d H:i:s', strtotime($this->request->post['cron_date_start'])) != $this->request->post['cron_date_start']) {
				$json['error'] = $this->language->get('error_date_start');
			}
	
			$cron_period = !empty($this->request->post['cron_period']) ? $this->request->post['cron_period'] : 0;
			$cron_status = !empty($this->request->post['cron_status']) ? $this->request->post['cron_status'] : 0;
	
			if (!$json) {
				$data = array(
					'name'        => $this->request->post['cron_name'],
					'subject'     => $this->request->post['cron_subject'],
					'message'     => $this->request->post['cron_message'],
					'date_start'  => $this->request->post['cron_date_start'],
					'period'      => $cron_period,
					'status'      => $cron_status
				);
	
				if (!empty($this->request->get['cron_id'])) {
					$this->load->model('sale/contacts');
					$this->model_sale_contacts->editCron($this->request->get['cron_id'], $data);
				}
	
				$json['success'] = $this->language->get('text_success_data');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function delcron() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (!empty($this->request->get['cron_id'])) {
				$this->load->model('sale/contacts');
				$this->model_sale_contacts->delCron($this->request->get['cron_id']);
				$json['success'] = 1;
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function viewcronlogs() {
		$json = array();
		$json['logs'] = array();

		if (isset($this->request->get['cron_id'])) {
			$this->load->model('sale/contacts');

			$logs = $this->model_sale_contacts->getCronLogs($this->request->get['cron_id']);
	
			if (!empty($logs)) {
				foreach($logs as $log){
					$fullname = explode('/', $log);
					$name = array_pop($fullname);
					$json['logs'][] = $name;
				}
			}
		}
		
		if ($json['logs']) {
			natsort($json['logs']);
			$clogs = array_reverse($json['logs']);
			$json['logs'] = $clogs;
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function viewcronlog() {
		$json = array();
	
		if (isset($this->request->get['cronlog']) && file_exists(DIR_LOGS . $this->request->get['cronlog'])) {
			$json['log'] = file_get_contents(DIR_LOGS . $this->request->get['cronlog'], FILE_USE_INCLUDE_PATH, null);
		} else {
			$json['log'] = '';
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function delcronlog() {
		$json = array();
	
		if (isset($this->request->get['cronlog'])) {
			if (file_exists(DIR_LOGS . $this->request->get['cronlog'])) {
				unlink(DIR_LOGS . $this->request->get['cronlog']);
			}
			$json['success'] = 1;
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function viewhistory() {
		$this->language->load('sale/contacts');
	
		$message = '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';

		if (isset($this->request->get['cron_id'])) {
			$this->load->model('sale/contacts');

			$histories = $this->model_sale_contacts->getCronHistories($this->request->get['cron_id']);
	
			if (!empty($histories)) {
				$message = '<div>';
				$message .= '<div style="overflow:auto;width:600px;margin:5px 20px 5px 5px;position:relative;">';
				$message .= '<table class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_date_start') . '</td><td>' . $this->language->get('column_date_end') . '</td><td style="width:48px;">' . $this->language->get('column_email_total') . '</td><td>' . $this->language->get('column_cron_status') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
	
				foreach($histories as $history){
					if ($history['cron_status']) {
						$text_cron_status = $this->language->get('text_cstatus' . $history['cron_status']);
					} else {
						$text_cron_status = '';
					}
					$message .= '<tr>';
					$message .= '<td>' . $history['date_cronrun'] . '</td>';
					$message .= '<td>' . $history['date_cronstop'] . '</td>';
					$message .= '<td class="center">' . $history['count_emails'] . '</td>';
					$message .= '<td class="center">' . $text_cron_status . '</td>';
					$message .= '</tr>';
				}
	
				$message .= '</tbody></table>';
				$message .= '</div></div>';
			}
		}
		$this->response->setOutput($message);
	}
	
	public function getsendgroup() {
		$json = array();

		if (isset($this->request->get['group_id'])) {
			$this->load->model('sale/contacts');
			$group_data = $this->model_sale_contacts->getSendGroup($this->request->get['group_id']);
	
			if (!empty($group_data)) {
				$json['name'] = html_entity_decode($group_data['name'], ENT_QUOTES, 'UTF-8');
				$json['description'] = html_entity_decode($group_data['description'], ENT_QUOTES, 'UTF-8');
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function getsendgroups() {
		$json = array();
		$json['groups'] = array();
	
		$this->load->model('sale/contacts');
		$results = $this->model_sale_contacts->getSendGroups();
	
		if ($results) {
			foreach ($results as $result) {
				$json['groups'][] = array(
					'group_id' => $result['group_id'],
					'name'     => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')
				);					
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function savegroup() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['group_name']) < 1) || (utf8_strlen($this->request->post['group_name']) > 64)) {
				$json['error'] = $this->language->get('error_group_name');
			}
	
			if (utf8_strlen($this->request->post['group_description']) > 255) {
				$json['error'] = $this->language->get('error_group_description');
			}
	
			if (!$json) {
				$this->load->model('sale/contacts');
	
				$data = array(
					'name'        => $this->request->post['group_name'],
					'description' => $this->request->post['group_description']
				);
	
				if (isset($this->request->get['group_id'])) {
					$this->model_sale_contacts->editSendGroup($this->request->get['group_id'], $data);
				} else {
					$json['group_id'] = $this->model_sale_contacts->addSendGroup($data);					
				}
	
				$json['success'] = $this->language->get('text_success_data');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function delgroup() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (isset($this->request->get['group_id'])) {
				$this->load->model('sale/contacts');
				$this->model_sale_contacts->delSendGroup($this->request->get['group_id']);
				$json['success'] = 1;
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function importfromstat() {
		$json = array();
	
		$this->language->load('sale/contacts');
	
		if (!empty($this->request->get['gid']) && !empty($this->request->get['sid']) && !empty($this->request->get['gmode'])) {
			if (!$this->validate()) {
				$json['error'] = $this->language->get('error_permission');
			}
	
			if (!$json) {
				$this->load->model('sale/contacts');
	
				$group_id = $this->request->get['gid'];
				$sid = $this->request->get['sid'];
				$gmode = $this->request->get['gmode'];
				$amode = $this->request->get['amode'];
				$cst = $this->request->get['cst'];
	
				$results = array();
				$news_data = array();
	
				$oldnews = $this->model_sale_contacts->getEmailsNewslettersFromGroup($group_id);
	
				if ($gmode == 'clicks') {
					$results = $this->model_sale_contacts->getClicksfromSend($sid);
				} elseif($gmode == 'views') {
					$results = $this->model_sale_contacts->getViewsfromSend($sid);
				} elseif($gmode == 'unsubs') {
					$results = $this->model_sale_contacts->getUnsubscribesfromSend($sid);
				} elseif($gmode == 'checks') {
					$check_data = array('check_status' => $cst);
					$results = $this->model_sale_contacts->getCheckCronResultEmails($sid, $check_data);
				}
	
				if ($results) {
					foreach ($results as $result) {
						$customer_info = $this->model_sale_contacts->getCustomerFromEmail($result['email']);
						$newsletters_info = $this->model_sale_contacts->getNewslettersFromEmail($result['email']);

						$customer_id = 0;
						$cfirstname = '';
						$clastname = '';
						
						if ($customer_info) {
							$customer_id = $customer_info['customer_id'];
							$cfirstname = (trim($customer_info['firstname']) != '') ? $customer_info['firstname'] : '';
							$clastname = (trim($customer_info['lastname']) != '') ? $customer_info['lastname'] : '';
						}
						
						$nfirstname = '';
						$nlastname = '';
						
						if ($newsletters_info) {
							foreach ($newsletters_info as $newsletter) {
								if ($newsletter['firstname']) {
									$nfirstname = (trim($newsletter['firstname']) != '') ? $newsletter['firstname'] : '';
								}
								if ($newsletter['lastname']) {
									$nlastname = (trim($newsletter['firstname']) != '') ? $newsletter['firstname'] : '';
								}
							}
						}
						
						if ($nfirstname) {
							$firstname = trim($nfirstname);
						} elseif ($cfirstname) {
							$firstname = trim($cfirstname);
						} else {
							$firstname = '';
						}
						
						if ($nlastname) {
							$lastname = trim($nlastname);
						} elseif (!$nfirstname && $cfirstname) {
							$lastname = trim($cfirstname);
						} else {
							$lastname = '';
						}

						$news_data[$result['email']] = array(
							'customer_id'  => $customer_id,
							'email'        => $result['email'],
							'firstname'    => $firstname ? $this->upCase($firstname) : '',
							'lastname'     => $lastname ? $this->upCase($lastname) : ''
						);
					}
				}
	
				if($news_data) {
					$total_add = 0;
					$news = array();
					
					if ($amode == '1') {
						foreach ($news_data as $key => $value) {
							if (!in_array(utf8_strtolower($key), $oldnews)) {
								$news[] = array(
									'customer_id'  => $value['customer_id'],
									'email'        => $value['email'],
									'firstname'    => $value['firstname'],
									'lastname'     => $value['lastname']
								);
							}
						}
						
						if ($news) {
							$total_add = $this->model_sale_contacts->addNewsletters($group_id, $news);
						}

					} else {
						foreach ($news_data as $key => $value) {
							$news[] = array(
								'customer_id'  => $value['customer_id'],
								'email'        => $value['email'],
								'firstname'    => $value['firstname'],
								'lastname'     => $value['lastname']
							);
						}
						
						if ($news) {
							$total_add = $this->model_sale_contacts->addNewsletters($group_id, $news, 1);
						}
					}
					
					$json['success'] = sprintf($this->language->get('text_import_email_total'), $total_add);

				} else {
					$json['error'] = $this->language->get('error_noemails');
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function import_newsletters() {
		$json = array();
	
		$this->language->load('sale/contacts');
	
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->validate()) {
				$json['error'] = $this->language->get('error_permission');
			}
	
			if (!isset($this->request->post['filter_for_group']) || !$this->request->post['filter_for_group']) {
				$json['error'] = $this->language->get('error_for_group');
			}
	
			if (!$json) {
				$this->load->model('sale/contacts');
	
				$group_id = $this->request->post['filter_for_group'];
				$store_id = $this->request->post['store_id'];
	
				$set_region = !empty($this->request->post['from_set_region']) ? 1 : false;
				if ($set_region) {
					$country_id = !empty($this->request->post['from_country_id']) ? $this->request->post['from_country_id'] : false;
					$zone_id = !empty($this->request->post['from_zone_id']) ? $this->request->post['from_zone_id'] : false;
					$invers_region = !empty($this->request->post['invers_region']) ? 1 : false;
				} else {
					$country_id = false;
					$zone_id = false;
					$invers_region = false;
				}
	
				$set_period = !empty($this->request->post['set_period']) ? 1 : false;
				if ($set_period) {
					$date_start = !empty($this->request->post['date_start']) ? $this->request->post['date_start'] : false;
					$date_end = !empty($this->request->post['date_end']) ? $this->request->post['date_end'] : false;
				} else {
					$date_start = false;
					$date_end = false;
				}
	
				$set_limit = !empty($this->request->post['set_limit']) ? 1 : false;
				if ($set_limit) {
					$limit_start = !empty($this->request->post['limit_start']) ? $this->request->post['limit_start'] : false;
					$limit_end = !empty($this->request->post['limit_end']) ? $this->request->post['limit_end'] : false;
				} else {
					$limit_start = false;
					$limit_end = false;
				}
	
				$invers_product = !empty($this->request->post['invers_product']) ? 1 : false;
				$invers_category = !empty($this->request->post['invers_category']) ? 1 : false;
	
				$invers_customer = !empty($this->request->post['invers_customer']) ? 1 : false;
				$invers_client = !empty($this->request->post['invers_client']) ? 1 : false;
				$invers_affiliate = !empty($this->request->post['invers_affiliate']) ? 1 : false;

				$control_unsubscribe = !empty($this->request->post['control_unsubscribe']) ? 1 : false;
	
				if (!empty($this->request->post['from_set_language']) && !empty($this->request->post['from_language_id'])) {
					$language_id = $this->request->post['from_language_id'];
				} else {
					$language_id = false;
				}
	
				$send_to_data = '';
				$manual = '';
	
				if ($this->request->post['from'] == 'customer_select') {
					if (!empty($this->request->post['from_customer']) && is_array($this->request->post['from_customer'])) {
						$send_to_data = implode(',', $this->request->post['from_customer']);
					}
				}
				if (($this->request->post['from'] == 'customer_group') || ($this->request->post['from'] == 'client_group')) {
					if (!empty($this->request->post['from_customer_group_id']) && is_array($this->request->post['from_customer_group_id'])) {
						$send_to_data = implode(',', $this->request->post['from_customer_group_id']);
					}
				}
				if ($this->request->post['from'] == 'client_select') {
					if (!empty($this->request->post['from_client']) && is_array($this->request->post['from_client'])) {
						$post_clients = array();
	
						foreach ($this->request->post['from_client'] as $client) {
							$post_clients[] = $client['email'];
						}
						if ($post_clients) {
							$send_to_data = implode(',', $post_clients);
						}
					}
				}
				if ($this->request->post['from'] == 'send_group') {
					if (!empty($this->request->post['send_group_id']) && is_array($this->request->post['send_group_id'])) {
						$send_to_data = implode(',', $this->request->post['send_group_id']);
					}
				}
				if ($this->request->post['from'] == 'affiliate') {
					if (!empty($this->request->post['from_affiliate']) && is_array($this->request->post['from_affiliate'])) {
						$send_to_data = implode(',', $this->request->post['from_affiliate']);
					}
				}
				if ($this->request->post['from'] == 'product') {
					if (!empty($this->request->post['from_product']) && is_array($this->request->post['from_product'])) {
						$send_to_data = implode(',', $this->request->post['from_product']);
					}
				}
				if ($this->request->post['from'] == 'category') {
					if (!empty($this->request->post['from_category']) && is_array($this->request->post['from_category'])) {
						$send_to_data = implode(',', $this->request->post['from_category']);
					}
				}
				if ($this->request->post['from'] == 'manual') {
					if (!empty($this->request->post['from_manual'])) {
						$manual = $this->request->post['from_manual'];
					}
				}
				if ($this->request->post['from'] == 'sql_manual') {
					$sql_manual = array(
						'sql_table'         => isset($this->request->post['from_sql_table']) ? $this->request->post['from_sql_table'] : '',
						'sql_col_email'     => isset($this->request->post['from_sql_email']) ? $this->request->post['from_sql_email'] : '',
						'sql_col_firstname' => isset($this->request->post['from_sql_firstname']) ? $this->request->post['from_sql_firstname'] : '',
						'sql_col_lastname'  => isset($this->request->post['from_sql_lastname']) ? $this->request->post['from_sql_lastname'] : '',
						'filter_start'      => $limit_start,
						'filter_limit'      => $limit_end
					);
				} else {
					$sql_manual = array();
				}
	
				$news_data = array();
	
				$oldnews = $this->model_sale_contacts->getEmailsNewslettersFromGroup($group_id);
	
				$data_send = array(
					'send_to'          => $this->request->post['from'],
					'manual'           => $manual,
					'sql_manual'       => $sql_manual,
					'send_to_data'     => $send_to_data,
					'date_start'       => $date_start,
					'date_end'         => $date_end,
					'store_id'         => $store_id,
					'send_country_id'  => $country_id,
					'send_zone_id'     => $zone_id,
					'invers_region'    => $invers_region,
					'invers_customer'  => $invers_customer,
					'invers_client'    => $invers_client,
					'invers_affiliate' => $invers_affiliate,
					'invers_product'   => $invers_product,
					'invers_category'  => $invers_category,
					'language_id'      => $language_id,
					'control_unsub'    => $control_unsubscribe,
					'limit_start'      => $limit_start,
					'limit_end'        => $limit_end
				);
	
				$results = $this->getAllEmails($data_send);

				foreach ($results as $email => $result) {
					if (!in_array(utf8_strtolower($email), $oldnews)) {
						$news_data[] = array(
							'customer_id'  => $result['customer_id'],
							'email'        => $email,
							'firstname'    => $result['firstname'],
							'lastname'     => $result['lastname']
						);
					}
				}
	
				if($news_data) {
					$total_add = $this->model_sale_contacts->addNewsletters($group_id, $news_data);
					$json['email_total'] = sprintf($this->language->get('text_import_email_total'), $total_add);
				} else {
					$json['error'] = $this->language->get('error_noemails');
				}
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function delnewsletter() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (isset($this->request->get['newsletter_id'])) {
				$this->load->model('sale/contacts');
				$this->model_sale_contacts->delNewsletter($this->request->get['newsletter_id']);
				$json['success'] = 1;
			}
		} else {
			$json['error'] = $this->language->get('error_newsl_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function delnewsletters() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (!empty($this->request->post['nselected']) && is_array($this->request->post['nselected'])) {
				$this->load->model('sale/contacts');
	
				foreach($this->request->post['nselected'] as $newsletter_id) {
					$this->model_sale_contacts->delNewsletter($newsletter_id);
					$json['newsdell'][] = $newsletter_id;
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function movenewsletters() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if ($this->request->get['group_id']) {
				if (!empty($this->request->post['nselected']) && is_array($this->request->post['nselected'])) {
					$this->load->model('sale/contacts');
					$this->model_sale_contacts->movedNewsletters($this->request->get['group_id'], $this->request->post['nselected']);
					$json['success'] = $this->language->get('text_success_data');
				} else {
					$json['error'] = $this->language->get('error_sel_newsletter');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function tognewsletter() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (isset($this->request->get['newsletter_id'])) {
				$this->load->model('sale/contacts');
				$newsletter_info = $this->model_sale_contacts->getNewsletter($this->request->get['newsletter_id']);
	
				if ($newsletter_info && $newsletter_info['email']) {
					if ($this->request->get['nmode'] == '1') {
						$this->model_sale_contacts->setSubscribe($newsletter_info['email']);
						$json['success'] = $this->language->get('text_subs_ok');
					} elseif ($this->request->get['nmode'] == '2') {
						$this->model_sale_contacts->addUnsubscribe($newsletter_info['email'], 0, $newsletter_info['customer_id']);
						$json['success'] = $this->language->get('text_unsubs_ok');
					}
				}
			}
		} else {
			$json['error'] = $this->language->get('error_newsl_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function gettemplate() {
		$json = array();

		if (isset($this->request->get['template_id'])) {
			$this->load->model('sale/contacts');
			$message_data = $this->model_sale_contacts->getTemplate($this->request->get['template_id']);
	
			if (!empty($message_data)) {
				$json['template_id'] = $message_data['template_id'];
				$json['name'] = html_entity_decode($message_data['name'], ENT_QUOTES, 'UTF-8');
				$json['subject'] = html_entity_decode($message_data['subject'], ENT_QUOTES, 'UTF-8');
				$json['message'] = html_entity_decode($message_data['message'], ENT_QUOTES, 'UTF-8');
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function gettemplates() {
		$json = array();
		$json['templates'] = array();
	
		$this->load->model('sale/contacts');
		$results = $this->model_sale_contacts->getTemplates();
	
		if ($results) {
			foreach ($results as $result) {
				$json['templates'][] = array(
					'template_id' => $result['template_id'],
					'name'        => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
					'subject'     => html_entity_decode($result['subject'], ENT_QUOTES, 'UTF-8')
				);	
			}
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function deltemplate() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if ($this->validate()) {
			if (isset($this->request->get['template_id'])) {
				$this->load->model('sale/contacts');
	
				$this->model_sale_contacts->deleteTemplate($this->request->get['template_id']);
				$json['success'] = $this->language->get('text_delete_template');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function edittemplate() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('sale/contacts');
	
			if ((utf8_strlen($this->request->post['temp_name']) < 1) || (utf8_strlen($this->request->post['temp_name']) > 255)) {
				$json['error'] = $this->language->get('error_name_template');
			} else {
				if (isset($this->request->get['template_id'])) {
					$data = array(
						'name'    => $this->request->post['temp_name'],
						'subject' => $this->request->post['temp_subject'],
						'message' => $this->request->post['temp_message']
					);
					$this->model_sale_contacts->editTemplate($this->request->get['template_id'], $data);
					$json['success'] = $this->language->get('text_success_data');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function addtemplate() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('sale/contacts');
	
			if (isset($this->request->post['temp_name'])) {
				$template_name = $this->request->post['temp_name'];
			} elseif (isset($this->request->post['new_temp_name'])) {
				$template_name = $this->request->post['new_temp_name'];
			} else {
				$template_name = '';
			}
	
			if (isset($this->request->post['temp_subject'])) {
				$template_subject = $this->request->post['temp_subject'];
			} elseif (isset($this->request->post['subject'])) {
				$template_subject = $this->request->post['subject'];
			} else {
				$template_subject = '';
			}
	
			if (isset($this->request->post['temp_message'])) {
				$message = $this->request->post['temp_message'];
			} elseif (isset($this->request->post['message'])) {
				$message = $this->request->post['message'];
			} else {
				$message = '';
			}
	
			if ((utf8_strlen($template_name) < 1) || (utf8_strlen($template_name) > 255)) {
				$json['error'] = $this->language->get('error_name_template');
			} else {
				$data = array(
					'name'    => $template_name,
					'subject' => $template_subject,
					'message' => $message
				);
				$json['template_id'] = $this->model_sale_contacts->addTemplate($data);
				$json['success'] = $this->language->get('text_success_data');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function savesetting() {
		$json = array();
		$this->language->load('sale/contacts');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('sale/contacts');
			$this->load->model('setting/setting');
	
			$data = $this->request->post;
			$data['contacts_unsub_pattern'] = $this->config->get('contacts_unsub_pattern');
	
			$cron_limit = $this->model_sale_contacts->getCronlimit($data['contacts_global_limith']);
	
			$data['contacts_cron_limit'] = $cron_limit['limit'];
			$data['contacts_cron_step'] = $cron_limit['step'];
	
			$this->model_setting_setting->editSetting('contacts', $data);
	
			$json['success'] = $this->language->get('text_success_setting');
			$json['cron_limit'] = $data['contacts_cron_limit'];
			$json['cron_step'] = $data['contacts_cron_step'];
		} else {
			$json['error'] = $this->language->get('error_save_setting');
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function getclients() {
		$json = array();
	
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('sale/contacts');
	
			$data = array(
				'filter_name'  => $this->request->get['filter_name'],
				'filter_email' => $this->request->get['filter_name'],
				'filter_phone' => $this->request->get['filter_name']
			);
	
			$results = $this->model_sale_contacts->getClients($data);
	
			foreach ($results as $result) {
				$json[] = array(
					'name'  => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'email' => $result['email']
				);					
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function getAllEmails($data = array()) {
		$emails = array();
	
		if ($data) {
			$this->load->model('sale/contacts');
	
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

					$results = $this->model_sale_contacts->getEmailCustomers($customer_data);

					foreach ($results as $result) {
						$email = preg_replace('/\s/', '', $result['email']);
						if ($email != '') {
							if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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

						$results = $this->model_sale_contacts->getEmailCustomers($customer_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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

						$results = $this->model_sale_contacts->getEmailCustomers($customer_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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

					$results = $this->model_sale_contacts->getEmailCustomers($customer_data);

					foreach ($results as $result) {
						$email = preg_replace('/\s/', '', $result['email']);
						if ($email != '') {
							if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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
	
					$results = $this->model_sale_contacts->getEmailsByOrdereds($client_data);

					foreach ($results as $result) {
						$email = preg_replace('/\s/', '', $result['email']);
						if ($email != '') {
							$unsuber = false;
	
							if ($data['control_unsub']) {
								if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
									$unsuber = true;
								} else {
									if ($result['customer_id'] && !$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id'])) {
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
	
						$results = $this->model_sale_contacts->getEmailsByOrdereds($client_data);
	
						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								$unsuber = false;
	
								if ($data['control_unsub']) {
									if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
										$unsuber = true;
									} else {
										if ($result['customer_id'] && !$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id'])) {
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
	
						$results = $this->model_sale_contacts->getEmailsByOrdereds($client_data);
	
						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								$unsuber = false;
	
								if ($data['control_unsub']) {
									if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
										$unsuber = true;
									} else {
										if ($result['customer_id'] && !$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id'])) {
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

						$results = $this->model_sale_contacts->getNewsletters($customer_data);
	
						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['cemail']);
							if ($email != '') {
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
	
					$results = $this->model_sale_contacts->getEmailAffiliates($affiliate_data);
	
					foreach ($results as $result) {
						$email = preg_replace('/\s/', '', $result['email']);
						if ($email != '') {
							if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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
	
						$results = $this->model_sale_contacts->getEmailAffiliates($affiliate_data);
	
						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								if (!$data['control_unsub'] || !$this->model_sale_contacts->checkEmailUnsubscribe($email)) {
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

						$results = $this->model_sale_contacts->getEmailsByOrdereds($product_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								$unsuber = false;
	
								if ($data['control_unsub']) {
									if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
										$unsuber = true;
									} else {
										if ($result['customer_id'] && !$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id'])) {
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

						$results = $this->model_sale_contacts->getEmailsByOrdereds($product_data);

						foreach ($results as $result) {
							$email = preg_replace('/\s/', '', $result['email']);
							if ($email != '') {
								$unsuber = false;
	
								if ($data['control_unsub']) {
									if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
										$unsuber = true;
									} else {
										if ($result['customer_id'] && !$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id'])) {
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
				case 'manual':
					if (!empty($data['manual'])) {
						$post_manuals = explode(',', $data['manual']);
	
						if ($post_manuals && (!empty($data['limit_start']) || !empty($data['limit_end']))) {
							if (!empty($data['limit_start']) && ((int)$data['limit_start'] > 0)) {
								$limit_start = (int)$data['limit_start'];
							} else {
								$limit_start = 0;
							}
	
							if (!empty($data['limit_end']) && ((int)$data['limit_end'] > $limit_start)) {
								$limit_end = (int)$data['limit_end'] - (int)$limit_start;
							} else {
								$limit_end = count($post_manuals);
							}
	
							$manuals = array_slice($post_manuals, $limit_start, $limit_end);
						} else {
							$manuals = $post_manuals;
						}
	
						foreach ($manuals as $post_manual) {
							if (trim($post_manual) != '') {
								$data_manuals = explode('|', $post_manual);
	
								if (isset($data_manuals[0]) && (stripos($data_manuals[0], '@') > 0)) {
									$email = preg_replace('/\s/', '', $data_manuals[0]);

									$unsuber = false;
									$customer_info = $this->model_sale_contacts->getCustomerFromEmail($email);
	
									if ($customer_info) {
										$customer_id = $customer_info['customer_id'];
									} else {
										$customer_id = 0;
									}

									if ($data['control_unsub']) {
										if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if (!empty($customer_info) && !$customer_info['newsletter']) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										$mfirstname = '';
										if (isset($data_manuals[1]) && (trim($data_manuals[1]) != '')) {
											$mfirstname = preg_replace('/\s+/', ' ', $data_manuals[1]);
											$mfirstname = trim($mfirstname);
											$firstname = $this->upCase($mfirstname);
										} elseif (!empty($customer_info) && $customer_info['firstname']) {
											$firstname = (trim($customer_info['firstname']) != '') ? $this->upCase($customer_info['firstname']) : '';
										} else {
											$firstname = '';
										}
										if (isset($data_manuals[2]) && (trim($data_manuals[2]) != '')) {
											$mlastname = preg_replace('/\s+/', ' ', $data_manuals[2]);
											$mlastname = trim($mlastname);
											$lastname = $this->upCase($mlastname);
										} elseif (!$mfirstname && !empty($customer_info) && $customer_info['lastname']) {
											$lastname = (trim($customer_info['lastname']) != '') ? $this->upCase($customer_info['lastname']) : '';
										} else {
											$lastname = '';
										}
	
										if (!array_key_exists($email, $emails)) {
											$emails[$email] = array(
												'customer_id'   => $customer_id,
												'firstname'     => $firstname,
												'lastname'      => $lastname,
												'country'       => '',
												'zone'          => '',
												'date_added'    => ''
											);
										}
									}
								}
							}
						}
					}
					break;
				case 'sql_manual':
					if (!empty($data['sql_manual'])) {
						$results = $this->model_sale_contacts->getEmailsFromSqlManual($data['sql_manual']);

						if (!empty($results)) {
							foreach ($results as $result) {
								$email = preg_replace('/\s/', '', $result['email']);
								if ($email != '') {
									$unsuber = false;
									$customer_info = $this->model_sale_contacts->getCustomerFromEmail($email);
	
									if ($customer_info) {
										$customer_id = $customer_info['customer_id'];
									} else {
										$customer_id = 0;
									}

									if ($data['control_unsub']) {
										if ($this->model_sale_contacts->checkEmailUnsubscribe($email)) {
											$unsuber = true;
										} else {
											if (!empty($customer_info) && !$customer_info['newsletter']) {
												$unsuber = true;
											}
										}
									}
	
									if (!$unsuber) {
										if (!array_key_exists($email, $emails)) {
											$qfirstname = '';
											if (!empty($result['firstname'])) {
												$qfirstname = (trim($result['firstname']) != '') ? $this->upCase($result['firstname']) : '';
												$firstname = $qfirstname;
											} elseif (!empty($customer_info) && $customer_info['firstname']) {
												$firstname = (trim($customer_info['firstname']) != '') ? $this->upCase($customer_info['firstname']) : '';
											} else {
												$firstname = '';
											}
											if (!empty($result['lastname'])) {
												$lastname = (trim($result['lastname']) != '') ? $this->upCase($result['lastname']) : '';
											} elseif (!$qfirstname && !empty($customer_info) && $customer_info['lastname']) {
												$lastname = (trim($customer_info['lastname']) != '') ? $this->upCase($customer_info['lastname']) : '';
											} else {
												$lastname = '';
											}
	
											$emails[$email] = array(
												'customer_id'   => $customer_id,
												'firstname'     => $firstname,
												'lastname'      => $lastname,
												'country'       => '',
												'zone'          => '',
												'date_added'    => ''
											);
										}
									}
								}
							}
						}
					}
					break;
			}
		}
		return $emails;
	}
			
	/**
	 * getMailProducts
	 *	переделано 02.08.20
	 * @param  mixed $results
	 * @param  mixed $customer_group_id
	 * @param  mixed $customer_id
	 * @return void
	 */
	public function getMailProducts($results = [], $customer_group_id = 1, $customer_id = 0) {
		$products = [];

		$this->load->model('sale/customer');

		$customer_group_id = $this->model_sale_customer->getCustomer($customer_id)['customer_group_id'];

		$this->load->model('catalog/product');  // added 02.08.20
	
		$url_replace = array('http://','https://');
		$url_admin = str_ireplace($url_replace, '', HTTP_SERVER);
		$url_catalog = str_ireplace($url_replace, '', HTTP_CATALOG);
	
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
	
		foreach ($results as $value) {
			$result = $this->model_catalog_product->getProductMp($value['product_id'], $customer_group_id, $customer_id, 0, 4); // added 02.08.20

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
				$rating = HTTP_CATALOG . 'catalog/view/theme/' . $this->config->get('config_template') . '/image/stars-' . $result['rating'] . '.png';
			} else {
				$rating = false;
			}

			// added			
			$customer_price = 0;

			if ($customer_id && !empty($result['customer_price'])) {
				$customer_prices_arr = unserialize($result['customer_price']);
				foreach($customer_prices_arr as $val) {
					if($val['customer_id'] == $customer_id) {
							$result['price'] = $val['price'];
							$discount = '';
					}
				}
			} 

// added 02.08.20
			$product_options = $this->model_catalog_product->getProductOptionsmp($value['product_id']);
			$price_from = 0;
			if ($product_options) {
				$product_options_data = array();
				$exmpl = 10000000.0000;
				$result['price'] = 0.0000;
				foreach ($product_options as $product_option) {
					$getpod_data  = array(
						'product_option_id' => $product_option['product_option_id'], 
						'customer_id' => $customer_id, 
						'customer_group_id' => $customer_group_id
					);

					$product_options_data_tmp = $this->podindex($getpod_data);

					$product_options_data[] = $product_options_data_tmp;

					if($product_options_data_tmp['option']['price_from'] && ($product_options_data_tmp['option']['price_from'] < $exmpl)) {
						$price_from = $product_options_data_tmp['option']['price_from'];
						$exmpl = $product_options_data_tmp['option']['price_from'];
					}
				}
			}
// added 02.08.20

			$products[] = [
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'discount'   => !empty($discount) ? '-' . $discount . '%' : '',
				'name'    	 => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				'price'   	 => $result['price'] ? $this->currency->format($result['price'], $this->config->get('config_currency')) : ' ',
				'price_nof'  => $result['price'], // added 
				'price_from' => $price_from ? $this->currency->format($price_from, $this->config->get('config_currency')) : ' ', // added
				'model'    	 => $result['model'],
				'sku'    	   => $result['sku'],
				'special' 	 => $special,
				'rating'     => $rating,
				'product_options_data' => [], //$product_options_data,
				'href'    	 => str_replace($url_admin, $url_catalog, $this->url->link('product/product', 'product_id=' . $result['product_id']))
			];
		}
	
		return $products;
	}
	
	public function checkValidEmail($email) {
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
	
	protected function validate() {
		$this->language->load('sale/contacts');
	
		if (!$this->user->hasPermission('modify', 'sale/contacts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

// added 31.07.20
	public function podindex($args) {
		$pods = $this->getPod($args);

		$pod_data['option'] = [];

		if ($pods) {
			$quantities = $pods['quantities'];

			sort($quantities);

			$this->load->model('catalog/product');

			$product_info = $this->model_catalog_product->getProduct($pods['product_id']);
			$product_discounts = $this->model_catalog_product->getProductDiscountsmp($pods['product_id'], $args['customer_group_id']);
			$product_options = $this->model_catalog_product->getProductOptionsmp($pods['product_id']);

			$price_from = 0; // added
			$exmpl = 10000000.0000;
			
			foreach ($product_options as $product_option) {
				if($product_option['product_option_id'] == $args['product_option_id'] && is_array($product_option['option_value'])) {

					$option_discount_data = $product_option_value_data = [];
					$ranges = [];

					foreach ($product_option['option_value'] as $option_value) {

						$prev_pod = $option_value;
						$prev_pod['calc_method'] = 'p';
						$prev_pod['special'] = 0;
						$prev_pod['special_prefix'] = '-';

						foreach ($quantities as $quantity) {

							foreach ($pods['pods'] as $pod) {
								if(isset($pod[$quantity]) && $pod[$quantity]['product_option_value_id'] == $option_value['product_option_value_id']) {
									$pod = $pod[$quantity];
									$prev_pod = $pod;
								} else {
									$pod = $prev_pod;
								}

								$pod['quantity'] = $quantity;

								if($product_info['special']) {
									$product_base_price = $product_info['special'];
								} else {
									$product_base_price = $product_info['price'];

									if($product_discounts) {
										foreach ($product_discounts as $product_discount) {
											if($quantity >= $product_discount['quantity']) {
												$product_base_price = $product_discount['price'];
											} else {
												break;
											}
										}
									}
								}

								if($pod['calc_method'] == 'o' || $pod['calc_method'] == 'po') {

									$option_base_price = $option_value['price'];

									if($option_value['price_prefix'] == '-') {
										$option_base_price *= -1;
									}
								} else {
									$option_base_price = 0;
								}

								if($pods['flat_rate']) {
									$option_discount_price = $pod['price'] / $quantity;
									$option_discount_special = $pod['special'] / $quantity;
									$product_total_price = $product_base_price + ($option_base_price / $quantity);
								} else {
									$option_discount_price = $pod['price'];
									$option_discount_special = $pod['special'];
									$product_total_price = $product_base_price + $option_base_price;
								}

								$price_suffix =
								$special_suffix = '';

								switch ($pod['price_prefix']) {
									case '+':
										$final_price = $product_total_price + $option_discount_price;
										$price_prefix = '+';
										break;
									case '-':
										$final_price = $product_total_price - $option_discount_price;
										$price_prefix = '-';
										break;
									case '=':
										$final_price = $option_discount_price;
										$price_prefix = '';
										break;
									case '+%':
										switch ($pod['calc_method']) {
											case 'p':
											$final_price = $product_total_price + ($product_base_price * $option_discount_price/100);
												break;
											case 'po':
												$final_price = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_price/100);
												break;
											default: //o
												$final_price = $product_total_price + ($option_base_price * $option_discount_price/100);
												break;
										}

										$price_prefix = '+';
										$price_suffix = '%';
										break;

									case '-%':
										switch ($pod['calc_method']) {
											case 'p':
											$final_price = $product_total_price - ($product_base_price * $option_discount_price/100);
												break;
											case 'po':
												$final_price = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_price/100);
												break;
											default: //o
												$final_price = $product_total_price - ($option_base_price * $option_discount_price/100);
												break;
										}

										$price_prefix = '-';
										$price_suffix = '%';
										break;

									default:
										$final_price = $product_total_price + $option_discount_price;
										$price_prefix = '+';
										break;
								}

								switch ($pod['special_prefix']) {
									case '+':
										$final_special = $product_total_price + $option_discount_special;
										$special_prefix = '+';
										break;
									case '-':
										$final_special = $product_total_price - $option_discount_special;
										if($option_discount_special == 0) {
											$special_prefix = false;
										} else {
											$special_prefix = '-';
										}

										break;

									case '=':
										$final_special = $option_discount_special;
										$special_prefix = '';
										break;

									case '+%':
										switch ($pod['calc_method']) {
											case 'p':
											$final_special = $product_total_price + ($product_base_price * $option_discount_special/100);
												break;

											case 'po':
												$final_special = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_special/100);
												break;

											default: //o
												$final_special = $product_total_price + ($option_base_price * $option_discount_special/100);
												break;
										}

										$special_prefix = '+';
										$special_suffix = '%';
										break;

									case '-%':

										switch ($pod['calc_method']) {
											case 'p':
											$final_special = $product_total_price - ($product_base_price * $option_discount_special/100);
												break;

											case 'po':
												$final_special = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_special/100);
												break;

											default: //o
												$final_special = $product_total_price - ($option_base_price * $option_discount_special/100);
												break;
										}

										$special_prefix = '-';
										$special_suffix = '%';
										break;

									default:
										$final_special = $product_total_price + $option_discount_special;
										$special_prefix = '+';
										break;
								}
								
								if($pods['show_final']) {
									$raw_price = $final_price;
									$price_prefix = '';
									$price_suffix = '';

									$raw_special = $final_special;
									$special_prefix = $special_prefix === false ? false : '';
									$special_suffix = $special_prefix === false ? false : '';
								} else {
									$raw_price = $option_discount_price;
									$raw_special = $option_discount_special;
								}

								$extax = $this->currency->format($raw_price);
								$extax_total = $this->currency->format($raw_price * $quantity);

								if($price_suffix == '%') {
									$price = number_format((float)$raw_price, 2);
									$extax = false;
									$price_total = number_format((float)$raw_price * $quantity, 2);
									$extax_total = false;
								} elseif((float)$raw_price) {
									$price = $this->currency->format($this->tax->calculate($raw_price, $product_info['tax_class_id'], $this->config->get('config_tax')));

									if($pods['show_final']) {
										$price_total = $this->currency->format($this->tax->calculate($raw_price, $product_info['tax_class_id'], $this->config->get('config_tax')) * $quantity);
									} else {
										$price_total = $this->currency->format($this->tax->calculate($raw_price * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
									}

								} else {
									$tax_price = $this->tax->calculate($raw_price, $product_info['tax_class_id'], $this->config->get('config_tax'));

									if($tax_price != 0 && $price_prefix == '-') {
										$price_prefix = '+';
									}

									$price = $this->currency->format($tax_price);
									$price_total = $this->currency->format($tax_price * $quantity);
								}

								$special_extax = $this->currency->format($raw_special);
								$special_extax_total = $this->currency->format($raw_special * $quantity);

								if($special_prefix === false || ($pod['date_start'] != '0000-00-00' && $pod['date_start'] > date('Y-m-d')) || ($pod['date_end'] != '0000-00-00' && $pod['date_end'] < date('Y-m-d'))) {
									$special = false;
									$special_extax = false;
									$special_total = false;
									$special_extax_total = false;
								} elseif($special_suffix == '%') {
									$special = number_format((float)$raw_special, 2);
									$special_extax = false;
									$special_total = number_format((float)$raw_special * $quantity, 2);
									$special_extax_total = false;
								} elseif((float)$raw_special) {
									$special = $this->currency->format($this->tax->calculate($raw_special, $product_info['tax_class_id'], $this->config->get('config_tax')));
									if($pods['show_final']) {
										$special_total = $this->currency->format($this->tax->calculate($raw_special, $product_info['tax_class_id'], $this->config->get('config_tax')) * $quantity);
									} else {
										$special_total = $this->currency->format($this->tax->calculate($raw_special * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
									}
								} else {
									$tax_special = $this->tax->calculate($raw_special, $product_info['tax_class_id'], $this->config->get('config_tax'));

									if($tax_special != 0 && $special_prefix == '-') {
										$special_prefix = '+';
									}

									$special = $this->currency->format($tax_special);
									$special_total = $this->currency->format($tax_special * $quantity);
								}
		
								if($raw_price && $raw_price < $exmpl ) {
									$price_from = $raw_price;
									$exmpl = $raw_price;
								}
								if($raw_special && $raw_special < $exmpl ) {
									$price_from = $raw_special;
									$exmpl = $raw_special;
								}

								$option_discount_data[$pod['quantity']] = array(
									'price'					=> ($pods['inc_tax'] == 'y' || $pods['inc_tax'] == 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false,
									'extax'					=> (($pods['inc_tax'] == 'n' || $pods['inc_tax'] == 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false,
									'price_total'			=> ($pods['inc_tax'] == 'y' || $pods['inc_tax'] == 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false,
									'extax_total'			=> (($pods['inc_tax'] == 'n' || $pods['inc_tax'] == 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false,
									'special'				=> ($special && ($pods['inc_tax'] == 'y' || $pods['inc_tax'] == 'both' || !$special_extax)) ? $special_prefix . $special . $special_suffix : false,
									'special_extax'			=> ($special && ($pods['inc_tax'] == 'n' || $pods['inc_tax'] == 'both') && $special_extax) ? $special_prefix . $special_extax . $special_suffix : false,
									'special_total'			=> ($special_total && ($pods['inc_tax'] == 'y' || $pods['inc_tax'] == 'both' || !$special_extax_total)) ? $special_prefix . $special_total . $special_suffix : false,
									'special_extax_total'	=> ($special_total && ($pods['inc_tax'] == 'n' || $pods['inc_tax'] == 'both') && $special_extax_total) ? $special_prefix . $special_extax_total . $special_suffix : false,
								);
							}

							if(end($quantities) == $quantity) {
								$ranges[$quantity] = $quantity . $this->language->get('text_plus');
							} else {
								$u = 0;
								do {
									$u++;
									$upper_quantity = $quantities[$u]-1;
								} while($quantities[$u] <= $quantity);

								$ranges[$quantity] = $quantity . $this->language->get('text_range') . $upper_quantity;
							}
						}

						if($pods['show_final']) {
							if($option_value['price_prefix'] == '+') {
								$option_value_price = ($product_info['special'] ? $product_info['special'] : $product_info['price']) + $option_value['price'];
							} else {
								$option_value_price = ($product_info['special'] ? $product_info['special'] : $product_info['price']) - $option_value['price'];
							}

							$option_value['price_prefix'] = '';
						} else {
							$option_value_price = $option_value['price'];
						}

						$option_price = false;
						$option_extax = false;

						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							if($pods['inc_tax'] == 'y' || $pods['inc_tax'] == 'both') {
								$option_price = $this->currency->format($this->tax->calculate($option_value_price, $product_info['tax_class_id'], $this->config->get('config_tax')));
							}

							if($pods['inc_tax'] == 'n' || $pods['inc_tax'] == 'both') {
								$option_extax = $this->currency->format($option_value_price);
							}
						}

						if (!empty($option_value['ob_image'])) {
							$image = $this->model_tool_image->resize($option_value['ob_image'], 50, 50);
						} else {
							$image = $this->model_tool_image->resize($option_value['image'], 50, 50);
						}

						if (!$image) {
							$image = $this->model_tool_image->resize('no_image.jpg', 50, 50);
						}
			
						if ($option_value_price && $option_value_price < $exmpl ) {
							$price_from = $option_value_price;
							$exmpl = $option_value_price;
						}

						$product_option_value_data[] = array(
							'product_option_value_id'	=> $option_value['product_option_value_id'],
							'option_value_id'			=> $option_value['option_value_id'],
							'name'						=> $option_value['name'],
							'image'						=> $image,
							'price'						=> $option_price,
							'extax'						=> $option_extax,
							'stock'						=> $option_value['quantity'],
							'subtract'					=> $option_value['subtract'],
							'price_prefix'				=> $option_value['price_prefix'],
							'option_discount'			=> $option_discount_data,
						);
					}

					$pod_data['option'] = array(
						'product_option_id'	=> $product_option['product_option_id'],
						'option_id'			=> $product_option['option_id'],
						'name'				=> $product_option['name'],
						'type'				=> $product_option['type'],
						'required'			=> $product_option['required'],
						'table_style'		=> $pods['table_style'],
						'price_format'		=> $pods['price_format'],
						'qty_column'		=> $pods['qty_column'],
						'qty_format'		=> $pods['qty_format'],
						'stock_column'		=> $pods['stock_column'],
						'qty_cart'			=> $pods['qty_cart'],
						'inc_tax'				=> $pods['inc_tax'],
						'quantities'		=> $ranges,
						'price_from'		=> $this->tax->calculate($price_from, $product_info['tax_class_id'], $this->config->get('config_tax')), // added
						'option_value'		=> $product_option_value_data,
					);

					break;
				}
			}

			$pod_data['minimum'] = $product_info['minimum'];
			$pod_data['product_id'] = $product_info['product_id'];

			return $pod_data;
		}
	}

	public function getPod($getpod_data = []) {

		$customer_id_discount = [];
		$pods = [];
		$extension_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE type = 'module' AND code = 'myocpod'");

		if($extension_query->num_rows) {
				if ($getpod_data['customer_group_id']) {
					$customer_group_id = $getpod_data['customer_group_id'];
				} else {
					$customer_group_id = $this->config->get('config_customer_group_id');
				}
            
				$pod_setting_query = $this->db->query("SELECT pods.*,po.product_id FROM " . DB_PREFIX . "myoc_pod_setting pods LEFT JOIN " . DB_PREFIX . "product_option po ON (po.product_option_id = pods.product_option_id)");

				if($pod_setting_query->num_rows) {
					foreach($pod_setting_query->rows as $pod_setting) {
						if(!isset($pods[$pod_setting['product_option_id']])) {
							$pods[$pod_setting['product_option_id']] = array(
									'show_price_product'	=> $pod_setting['show_price_product'],
									'show_price_cart'		=> $pod_setting['show_price_cart'],
									'show_final'			=> $pod_setting['show_final'],
									'table_style'			=> $pod_setting['table_style'],
									'price_format'			=> $pod_setting['price_format'],
									'qty_column'			=> $pod_setting['qty_column'],
									'qty_format'			=> $pod_setting['qty_format'],
									'stock_column'			=> $pod_setting['stock_column'],
									'qty_cart'				=> $pod_setting['qty_cart'],
									'flat_rate'				=> $pod_setting['flat_rate'],
									'cart_discount'			=> $pod_setting['cart_discount'],
									'inc_tax'				=> $pod_setting['inc_tax'],
									'product_id'			=> $pod_setting['product_id'],
									'quantities'			=> [],
									'pods'					=> [],
							);
						}

						$pod_query = $this->db->query("SELECT pod.* FROM " . DB_PREFIX . "myoc_pod pod LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_option_value_id = pod.product_option_value_id) WHERE pov.product_option_id = '" . (int)$pod_setting['product_option_id'] . "' ORDER BY pod.priority, pod.quantity");
						
						if($pod_query->num_rows) {
							foreach($pod_query->rows as $pod) {
								$pod['customer_group_ids'] = unserialize($pod['customer_group_ids']);
								$customer_ids = unserialize($pod['customer_ids']); 

								if(in_array($getpod_data['customer_group_id'], $pod['customer_group_ids'])) {

									if(!isset($pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
										$pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = [];
									}

									$pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
									$pods[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
								}

								if(in_array($getpod_data['customer_id'], $customer_ids)) {
									if(!isset($customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
										$customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = [];
									}

									$customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
									$customer_id_discount[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
								}
							}
							
							if ($customer_id_discount) {
								$pods = array_replace_recursive($pods, $customer_id_discount);
							}
						}
					}
				}
		}

		return $pods[$getpod_data['product_option_id']];
	}
// added
}
?>
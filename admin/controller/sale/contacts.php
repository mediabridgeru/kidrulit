<?php 
class ControllerSaleContacts extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('sale/contacts');
		$this->load->model('sale/contacts');

		if ($this->model_sale_contacts->checkTableBase()) {
			$this->model_sale_contacts->insertTableBase();
			$this->redirect($this->url->link('sale/contacts', 'token=' . $this->session->data['token'], 'SSL'));
		}
 
		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/contacts.css');
		$this->document->addStyle('view/javascript/jquery/colorbox/colorbox.css');
		
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['license'] = $this->model_sale_contacts->checkLicense();
		
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_customer_all'] = $this->language->get('text_customer_all');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_client_all'] = $this->language->get('text_client_all');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_send_group'] = $this->language->get('text_send_group');
		$this->data['text_affiliate_all'] = $this->language->get('text_affiliate_all');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_manual'] = $this->language->get('text_manual');
		$this->data['text_fnewsletter'] = $this->language->get('text_fnewsletter');
		$this->data['text_fcustomer_all'] = $this->language->get('text_fcustomer_all');
		$this->data['text_fcustomer'] = $this->language->get('text_fcustomer');
		$this->data['text_fclient_all'] = $this->language->get('text_fclient_all');
		$this->data['text_fcustomer_group'] = $this->language->get('text_fcustomer_group');
		$this->data['text_fsend_group'] = $this->language->get('text_fsend_group');
		$this->data['text_faffiliate_all'] = $this->language->get('text_faffiliate_all');
		$this->data['text_faffiliate'] = $this->language->get('text_faffiliate');
		$this->data['text_fproduct'] = $this->language->get('text_fproduct');
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
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['text_run'] = $this->language->get('text_run');
		$this->data['text_new_template'] = $this->language->get('text_new_template');
		$this->data['text_group_edit'] = $this->language->get('text_group_edit');
		$this->data['text_error_license'] = $this->language->get('text_error_license');
		$this->data['text_version'] = $this->language->get('text_version');
		
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
		$this->data['entry_sql_column'] = $this->language->get('entry_sql_column');
		$this->data['entry_template_name'] = $this->language->get('entry_template_name');
		$this->data['entry_group_name'] = $this->language->get('entry_group_name');
		$this->data['entry_group_description'] = $this->language->get('entry_group_description');
		$this->data['entry_move_ingroup'] = $this->language->get('entry_move_ingroup');
		
		$this->data['entry_cron_name'] = $this->language->get('entry_cron_name');
		$this->data['entry_cron_start'] = $this->language->get('entry_cron_start');
		$this->data['entry_cron_period'] = $this->language->get('entry_cron_period');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_check'] = $this->language->get('button_check');
		$this->data['button_cron'] = $this->language->get('button_cron');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_dellog'] = $this->language->get('button_dellog');
		
		$this->data['tab_send'] = $this->language->get('tab_send');
		$this->data['tab_template'] = $this->language->get('tab_template');
		$this->data['tab_groups'] = $this->language->get('tab_groups');
		$this->data['tab_newsletters'] = $this->language->get('tab_newsletters');
		$this->data['tab_crons'] = $this->language->get('tab_crons');
		$this->data['tab_log'] = $this->language->get('tab_log');
		$this->data['tab_statistics'] = $this->language->get('tab_statistics');
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		
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
		
		// Send //
		$this->data['text_info_panel'] = $this->language->get('text_info_panel');
		$this->data['text_tegi'] = $this->language->get('text_tegi');
		$this->data['spravka_tegi'] = $this->language->get('spravka_tegi');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_region'] = $this->language->get('text_region');
		
		$this->data['text_save_template'] = $this->language->get('text_save_template');
		$this->data['text_template_name'] = $this->language->get('text_template_name');
		
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_country'] = $this->language->get('entry_country');
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
		$this->data['entry_template'] = $this->language->get('entry_template');
		
		$this->data['help_client_all'] = $this->language->get('help_client_all');
		$this->data['help_customer_all'] = $this->language->get('help_customer_all');
		$this->data['help_newsletter'] = $this->language->get('help_newsletter');
		
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
		
		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		
		$this->data['categories'] = $this->model_sale_contacts->getAllsCategories();
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
					'send_alarm' => sprintf($this->language->get('missins_send_alarm'), $msend['date_added']),
					'send_title' => sprintf($this->language->get('missins_send_title'), html_entity_decode($msend['subject'], ENT_QUOTES, 'UTF-8')),
					'send_info'  => sprintf($this->language->get('missins_send_info'), $this->language->get('text_' . $msend['send_to']), $count_miss_emails, $msend['email_total'])
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
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp');
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_mail_count_message'] = $this->language->get('entry_mail_count_message');
		$this->data['entry_mail_sleep_time'] = $this->language->get('entry_mail_sleep_time');
		$this->data['entry_mail_from'] = $this->language->get('entry_mail_from');
		$this->data['entry_email_pattern'] = $this->language->get('entry_email_pattern');
		$this->data['entry_mail_count_error'] = $this->language->get('entry_mail_count_error');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_product_currency'] = $this->language->get('entry_product_currency');
		$this->data['entry_admin_limit'] = $this->language->get('entry_admin_limit');
		$this->data['entry_allow_sendcron'] = $this->language->get('entry_allow_sendcron');
		$this->data['entry_allow_cronsend'] = $this->language->get('entry_allow_cronsend');
		$this->data['entry_cron_url'] = $this->language->get('entry_cron_url');
		
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
			$this->data['contacts_count_message'] = 3;
		}
		
		if ($this->config->get('contacts_sleep_time') && ($this->config->get('contacts_sleep_time') > 0)) {
			$this->data['contacts_sleep_time'] = $this->config->get('contacts_sleep_time');
		} else {
			$this->data['contacts_sleep_time'] = 7;
		}
		
		if ($this->config->get('contacts_count_send_error') && ($this->config->get('contacts_count_send_error') > 0)) {
			$this->data['contacts_count_send_error'] = $this->config->get('contacts_count_send_error');
		} else {
			$this->data['contacts_count_send_error'] = 3;
		}
		
		if ($this->config->get('contacts_email_pattern')) {
			$this->data['contacts_email_pattern'] = $this->config->get('contacts_email_pattern');
		} else {
			$this->data['contacts_email_pattern'] = '';
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
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$this->data['contacts_admin_limit'] = $this->config->get('contacts_admin_limit');
		} else {
			$this->data['contacts_admin_limit'] = 10;
		}
		
		if ($this->config->get('contacts_allow_sendcron')) {
			$this->data['contacts_allow_sendcron'] = $this->config->get('contacts_allow_sendcron');
		} else {
			$this->data['contacts_allow_sendcron'] = false;
		}
		
		if ($this->config->get('contacts_allow_cronsend')) {
			$this->data['contacts_allow_cronsend'] = $this->config->get('contacts_allow_cronsend');
		} else {
			$this->data['contacts_allow_cronsend'] = false;
		}
		
		$this->data['cron_url'] = str_replace(HTTP_SERVER, HTTP_CATALOG, $this->url->link('feed/ccrons', 'cont=' . $this->config->get('contacts_unsub_pattern')));
		// Settintg //
		
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
		
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_period'] = $this->language->get('column_period');
		$this->data['column_date_next'] = $this->language->get('column_date_next');
		$this->data['column_cron_name'] = $this->language->get('column_cron_name');
		$this->data['column_send_to'] = $this->language->get('column_send_to');
		$this->data['column_email_total'] = $this->language->get('column_email_total');
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
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cron_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
				$send_region = false;
				$products = false;
				$attachments = false;
				$unsub_url = false;
				$control_unsub = false;
				$email_total = 0;
				
				$send_info = $this->model_sale_contacts->getDataCron($cron['cron_id']);
				
				if (!empty($send_info)) {
					$send_to = $this->language->get('text_' . $send_info['send_to']);
					
					if ($send_info['send_to'] == 'customer_group') {
						$mcustomer_groups = explode(',', $send_info['send_to_data']);
						$send_datas = array();
						
						foreach($mcustomer_groups as $mcustomer_group) {
							$group_info = $this->model_sale_customer_group->getCustomerGroupDescriptions($mcustomer_group);
							
							if (!empty($group_info) && isset($group_info[$this->config->get('config_language_id')]['name'])) {
								$send_datas[] = $group_info[$this->config->get('config_language_id')]['name'];
							}
						}
						
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					if ($send_info['send_to'] == 'send_group') {
						$msend_groups = explode(',', $send_info['send_to_data']);
						$send_datas = array();
						
						foreach($msend_groups as $msend_group) {
							$sgroup_info = $this->model_sale_contacts->getSendGroup($msend_group);
							
							if (!empty($sgroup_info) && isset($sgroup_info['name'])) {
								$send_datas[] = $sgroup_info['name'];
							}
						}
						
						if (!empty($send_datas)) {
							$send_data = implode(', ', $send_datas);
						}
					}
					
					$send_region = $send_info['send_region'];
					$products = $send_info['send_products'];
					$attachments = $send_info['attachments'];
					$unsub_url = $send_info['unsub_url'];
					$control_unsub = $send_info['control_unsub'];
					$email_total = $this->model_sale_contacts->getCronEmailTotal($cron['cron_id']);
				}
				
				$cron_count = $this->model_sale_contacts->getCronCount($cron['cron_id']);
				$cron_status = $this->model_sale_contacts->getCronStatus($cron['cron_id']);
				
				if ($cron_status) {
					$text_cron_status = $this->language->get('text_cstatus' . $cron_status);
				} else {
					$text_cron_status = '';
				}
				
				$this->data['crons'][] = array(
					'cron_id'       => $cron['cron_id'],
					'name'          => html_entity_decode($cron['name'], ENT_QUOTES, 'UTF-8'),
					'send_to'       => $send_to,
					'send_data'     => $send_data,
					'date_start'    => $cron['date_start'],
					'date_next'     => $cron['date_next'],
					'period'        => $cron['period'],
					'status'        => $cron['status'],
					'status_text'   => $status_text,
					'send_region'   => $send_region,
					'products'      => $products,
					'attachments'   => $attachments,
					'unsub_url'     => $unsub_url,
					'control_unsub' => $control_unsub,
					'email_total'   => $email_total,
					'cron_count'    => $cron_count,
					'cron_status'   => $cron_status,
					'text_cron_status' => $text_cron_status
				);
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
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['text_save'] = $this->language->get('text_save');
		
		$this->data['text_no_data'] = $this->language->get('text_no_data');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'template_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
					'name'         => html_entity_decode($template['name'], ENT_QUOTES, 'UTF-8')
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
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
					'name'        => $group['name'],
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
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
				
				if ($mailing['send_to'] == 'customer_group') {
					$mcustomer_groups = explode(',', $mailing['send_to_data']);
					$send_datas = array();
					
					foreach($mcustomer_groups as $mcustomer_group) {
						$group_info = $this->model_sale_customer_group->getCustomerGroupDescriptions($mcustomer_group);
						
						if (!empty($group_info) && isset($group_info[$this->config->get('config_language_id')]['name'])) {
							$send_datas[] = $group_info[$this->config->get('config_language_id')]['name'];
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
					'send_id'      => $mailing['send_id'],
					'date_added'   => date('j.m.Y', strtotime($mailing['date_added'])),
					'send_to'      => $this->language->get('text_' . $mailing['send_to']),
					'send_data'    => $send_data,
					'subject'      => html_entity_decode($mailing['subject'], ENT_QUOTES, 'UTF-8'),
					'send_region'  => $mailing['send_region'],
					'country_name' => $country_name,
					'country_iso'  => $country_iso,
					'zone_name'    => $zone_name,
					'zone_code'    => $zone_code,
					'products'     => $mailing['send_products'],
					'attachments'  => $mailing['attachments'],
					'unsub_url'    => $mailing['unsub_url'],
					'control_unsub' => $mailing['control_unsub'],
					'email_total'  => $mailing['email_total'],
					'email_open'   => $email_open,
					'email_click'  => $email_click,
					'email_unsub'  => $email_unsub
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
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}
		
		if (isset($this->request->get['filter_group_id'])) {
			$filter_group_id = $this->request->get['filter_group_id'];
		} else {
			$filter_group_id = '';
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = '';
		}
		
		if (isset($this->request->get['filter_unsubscribe'])) {
			$filter_unsubscribe = $this->request->get['filter_unsubscribe'];
		} else {
			$filter_unsubscribe = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cemail';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
					'name'           => $newsletter['cname'],
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
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}
		
		if (isset($this->request->get['filter_group_id'])) {
			$filter_group_id = $this->request->get['filter_group_id'];
		} else {
			$filter_group_id = '';
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = '';
		}
		
		if (isset($this->request->get['filter_unsubscribe'])) {
			$filter_unsubscribe = $this->request->get['filter_unsubscribe'];
		} else {
			$filter_unsubscribe = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cemail';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if ($this->config->get('contacts_admin_limit') && ($this->config->get('contacts_admin_limit') > 0)) {
			$contacts_admin_limit = $this->config->get('contacts_admin_limit');
		} else {
			$contacts_admin_limit = 10;
		}
		
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
					'name'           => $newsletter['cname'],
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
	
	public function misssend() {
		set_time_limit(100);
		
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
		
		if(!$this->config->get('contacts_allow_sendcron')) {
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

		if (empty($missing_send)) {
			$json['error'][] = $this->language->get('error_msid_data');
		} else {
			if (!$missing_send['subject'] || trim($missing_send['subject'] == '')) {
				$json['error'][] = $this->language->get('error_msid_data');
			}
			
			if (!$missing_send['message'] || trim($missing_send['message'] == '')) {
				$json['error'][] = $this->language->get('error_msid_data');
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
				$contacts_log->write($this->language->get('text_start_missresend'));
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
			
			if ($missing_send['send_region']) {
				$set_region = $missing_send['send_region'];
			} else {
				$set_region = false;
			}
			
			if ($missing_send['send_country_id']) {
				$country_id = $missing_send['send_country_id'];
			} else {
				$country_id = false;
			}
			
			if ($missing_send['send_zone_id']) {
				$zone_id = $missing_send['send_zone_id'];
			} else {
				$zone_id = false;
			}
			
			if ($missing_send['unsub_url']) {
				$set_unsubscribe = $missing_send['unsub_url'];
			} else {
				$set_unsubscribe = false;
			}
			
			if ($missing_send['control_unsub']) {
				$control_unsubscribe = $missing_send['control_unsub'];
			} else {
				$control_unsubscribe = false;
			}

			$shop_country = $this->model_sale_contacts->getCountry($this->config->get('config_country_id'));
			$shop_zone = $this->model_sale_contacts->getZone($this->config->get('config_zone_id'));
			
			$lang_id = $this->config->get('config_language_id');
			$store_id = $missing_send['store_id'];
			$cgroup_id = $this->config->get('config_customer_group_id');
			
			if ($missing_send['send_products']) {
				$insert_products = $missing_send['send_products'];
			} else {
				$insert_products = false;
			}
			
			$attachments = false;
			
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
			
			$special = '';
			$bestseller = '';
			$latest = '';
			$featured = '';
			$selproducts = '';
			$catproducts = '';
			
			if ($insert_products) {
				$send_product_data = $this->model_sale_contacts->getProductSend($msend_id);
				foreach ($send_product_data as $send_product) {
					if ($send_product['type'] == 'special') {
						if ($send_product['qty'] && ($send_product['qty'] > 0)) {
							$special_limit = $send_product['qty'];
						} else {
							$special_limit = 4;
						}

						$special_products = array();
						
						$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit);
						
						if (!isset($special_cache_data)) {
							$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit);
							if (!empty($specials)) {
								$special_products = $this->getMailProducts($specials);
							}
							$this->cache->set('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$special_limit, $special_products);
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
							$special = $special_template->fetch('mail/contacts_products.tpl');
						}
						
					} elseif ($send_product['type'] == 'bestseller') {
						if ($send_product['qty'] && ($send_product['qty'] > 0)) {
							$bestseller_limit = $send_product['qty'];
						} else {
							$bestseller_limit = 4;
						}
						
						$bestseller_products = array();
						
						$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit);
						
						if (!isset($bestseller_cache_data)) {
							$bestsellers = $this->model_sale_contacts->getBestsellerProducts($bestseller_limit);
							if (!empty($bestsellers)) {
								$bestseller_products = $this->getMailProducts($bestsellers);
							}
							$this->cache->set('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$bestseller_limit, $bestseller_products);
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
							$bestseller = $bestseller_template->fetch('mail/contacts_products.tpl');
						}
						
					} elseif ($send_product['type'] == 'latest') {
						if ($send_product['qty'] && ($send_product['qty'] > 0)) {
							$latest_limit = $send_product['qty'];
						} else {
							$latest_limit = 4;
						}
						
						$latest_products = array();
						
						$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit);
						
						if (!isset($latest_cache_data)) {
							$latests = $this->model_sale_contacts->getLatestProducts($latest_limit);
							if (!empty($latests)) {
								$latest_products = $this->getMailProducts($latests);
							}
							$this->cache->set('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$latest_limit, $latest_products);
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
							$latest = $latest_template->fetch('mail/contacts_products.tpl');
						}

					} elseif ($send_product['type'] == 'featured') {
						if ($send_product['qty'] && ($send_product['qty'] > 0)) {
							$featured_limit = $send_product['qty'];
						} else {
							$featured_limit = 4;
						}
						
						$featured_products = array();
						
						$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit);
						
						if (!isset($featured_cache_data)) {
							$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit);
							if (!empty($featureds)) {
								$featured_products = $this->getMailProducts($featureds);
							}
							$this->cache->set('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$featured_limit, $featured_products);
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
							$featured = $featured_template->fetch('mail/contacts_products.tpl');
						}
				
					} elseif ($send_product['type'] == 'selproducts') {
						$selected_products = array();
						
						$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id);
						
						if (!isset($selected_cache_data)) {
							$selectproducts = $this->model_sale_contacts->getProductsToSend($msend_id, $send_product['type']);
							
							if (!empty($selectproducts)) {
								$selected_products = $this->getMailProducts($selectproducts);
							}
							
							$this->cache->set('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id, $selected_products);
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
							$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');
						}
				
					} elseif ($send_product['type'] == 'catproducts') {
						if ($send_product['qty'] && ($send_product['qty'] > 0)) {
							$catproducts_limit = $send_product['qty'];
						} else {
							$catproducts_limit = 4;
						}
						
						$category_products = array();
						$catproducts_each = false;
						
						$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$msend_id . '.' . (int)$catproducts_limit);

						if (!isset($catproduct_cache_data)) {
							$pcategories = explode(',', $send_product['cat_id']);
							
							if ($send_product['cat_each']) {
								foreach ($pcategories as $pcategory_id) {
									$allcatproducts[] = $this->model_sale_contacts->getProductsFromCat($pcategory_id, $catproducts_limit);
								}
								foreach ($allcatproducts as $pid) {
									foreach ($pid as $key => $value) {
										$selcatproducts[$key] = $value;
									}
								}
							} else {
								$selcatproducts = $this->model_sale_contacts->getCatSelectedProducts($pcategories, $catproducts_limit);
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
							
							if ($send_product['title']) {
								$category_products_template->data['title'] = $send_product['title'];
							} else {
								$category_products_template->data['title'] = $this->language->get('catproducts_title');
							}
						
							$category_products_template->data['products'] = $category_products;
							$catproducts = $category_products_template->fetch('mail/contacts_products.tpl');
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
			$emails = array();
			$emails_cache = array();
			
			$emails_cache = $this->cache->get('contacts.emails.' . (int)$msend_id);
			
			if ($emails_cache) {
				
				$emails = $emails_cache['emails'];
				$email_total = $emails_cache['email_total'];
				
			} else {
				$page = 1;
				$results = $this->model_sale_contacts->getEmailsToSend($msend_id);

				foreach ($results as $result) {
					if ($result['firstname'] && trim($result['firstname']) != '') {
						$mfirstname = mb_convert_case($result['firstname'], MB_CASE_TITLE, 'UTF-8');
					} else {
						$mfirstname = '';
					}
					
					if ($result['lastname'] && trim($result['lastname']) != '') {
						$mlastname = mb_convert_case($result['lastname'], MB_CASE_TITLE, 'UTF-8');
					} else {
						$mlastname = '';
					}
					
					$emails[$result['email']] = array(
						'customer_id'   => $result['customer_id'],
						'firstname'     => $mfirstname,
						'lastname'      => $mlastname,
						'country'       => $result['country'],
						'zone'          => $result['zone'],
						'date_added'    => $result['date_added']
					);
				}
				
				$email_total = count($emails);
				
				$emails_cache['emails'] = $emails;
				$emails_cache['email_total'] = $email_total;
				$this->cache->set('contacts.emails.' . (int)$msend_id, $emails_cache);
				
				$contacts_log->write($this->language->get('text_cache_complete'));
				$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
			}

			if ($emails) {
				sleep($contacts_sleep_time);
				$start = ($page - 1) * $contacts_count_message;
				$end = $start + $contacts_count_message;
				$lastsend = 0;
				$count_send_error = 0;
				
				if ($end < $email_total) {
					$json['success'] = sprintf($this->language->get('text_sent'), $end, $email_total);
				} else {
					$json['success'] = $this->language->get('text_success');
					$lastsend = 1;
				}
					
				if ($end < $email_total) {
					$json['next'] = str_replace('&amp;', '&', $this->url->link('sale/contacts/misssend', 'msid=' . $msend_id . '&token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
				} else {
					$json['next'] = '';
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
// added

								$selected_products = array();


								$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts']);

								if (!empty($selecteds)) {
									$selected_products = $this->getMailProducts($selecteds, $customer_group_id, $customer['customer_id']);
								}


								if ($selected_products) {
									$selproducts_template = new Template();
									$selproducts_template->data['title'] = $selproducts_title;
									$selproducts_template->data['products'] = $selected_products;
									$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');					
								} else {
									$selproducts = '';
								}

//							
							$replace_subject = array($firstname, $lastname, $name, $country, $zone, $shopname);
							$replace_message = array($firstname, $lastname, $name, $country, $zone, $shopname, $shopurl, $special, $bestseller, $latest, $featured, $selproducts, $catproducts);
							
							$orig_subject = $missing_send['subject'];
							$orig_message = $missing_send['message'];
						
							$subject_to_send = str_replace($tegi_subject, $replace_subject, $orig_subject);
							$message_to_send = str_replace($tegi_message, $replace_message, $orig_message);

							$controlsumm = md5($email . $this->config->get('contacts_unsub_pattern'));
							
							if ($customer['customer_id']) {
								$sid = base64_encode($msend_id . '|' . $email . '|' . $controlsumm . '|' . $customer['customer_id']);
							} else {
								$sid = base64_encode($msend_id . '|' . $email . '|' . $controlsumm . '|0');
							}

							$message  = '<html dir="ltr" lang="en">' . "\n";
							$message .= '  <head>' . "\n";
							$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n";
							$message .= '    <title>' . html_entity_decode($subject_to_send, ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
							$message .= '  </head>' . "\n";

							$controlimage = HTTP_CATALOG . 'index.php?route=feed/stats/images&sid=' . $sid;
							$message .= '  <body><table style="width:98%;background:url(' . $controlimage . ');margin-left:auto;margin-right:auto;"><tr><td>' . html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . "\n\n";
							
							if ($set_unsubscribe) {
								$unsubscribe_url = HTTP_CATALOG . 'index.php?route=account/success&sid=' . $sid;
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
							$contacts_log->write($this->language->get('text_send_email') . $email);
							$send_status = $mail->send();
							if ($send_status == 55) {
								$this->model_sale_contacts->removeEmailSend($msend_id, $email);
							} elseif (substr($send_status, 0, 4) == 'cerr') {
								$lastsend = 0;
								$json['success'] = '';
								$json['next'] = '';
								$json['error'][] = $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_stop_send');
								$json['stop_send'] = $msend_id;
								break;
							} elseif (substr($send_status, 0, 4) == 'nerr') {
								$json['attention'][] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_continues_send');
								$this->model_sale_contacts->removeEmailSend($msend_id, $email);
								$count_send_error++;
							} else {
								$count_send_error++;
							}
						} else {
							$contacts_log->write($this->language->get('text_bad_email') . $email);
							$this->model_sale_contacts->removeEmailSend($msend_id, $email);
						}
					} else {
						$contacts_log->write($this->language->get('error_send_count'));
						$lastsend = 0;
						$json['success'] = '';
						$json['next'] = '';
						$json['error'][] = $this->language->get('error_send_count');
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
		set_time_limit(100);
		
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
			
			if(!$this->config->get('contacts_allow_sendcron')) {
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
				
				if (isset($this->request->get['sid'])) {
					$send_id = $this->request->get['sid'];
				} else {
					$send_id = 0;
				}
				
				if (isset($this->request->get['spam_check'])) {
					$spam_check = true;
				} else {
					$spam_check = false;
				}
				
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
						$contacts_log->write($this->language->get('text_add_cron'));
						$data_cron = array(
							'name'   => $this->language->get('text_new_cron'),
							'status' => 0
						);
						$cron_id = $this->model_sale_contacts->addNewCron($data_cron);
					} else {
						$contacts_log->write($this->language->get('text_start_send'));
						$send_id = $this->model_sale_contacts->addNewSend($this->request->post['store_id'], 1);
					}
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
				
				if (isset($this->request->post['set_region'])) {
					$set_region = $this->request->post['set_region'];
				} else {
					$set_region = false;
				}
				
				if (isset($this->request->post['country_id'])) {
					$country_id = $this->request->post['country_id'];
				} else {
					$country_id = false;
				}
				
				if (isset($this->request->post['zone_id'])) {
					$zone_id = $this->request->post['zone_id'];
				} else {
					$zone_id = false;
				}
				
				if (isset($this->request->post['set_unsubscribe'])) {
					$set_unsubscribe = $this->request->post['set_unsubscribe'];
				} else {
					$set_unsubscribe = false;
				}
				
				if (isset($this->request->post['control_unsubscribe'])) {
					$control_unsubscribe = $this->request->post['control_unsubscribe'];
				} else {
					$control_unsubscribe = false;
				}

				$shop_country = $this->model_sale_contacts->getCountry($this->config->get('config_country_id'));
				$shop_zone = $this->model_sale_contacts->getZone($this->config->get('config_zone_id'));
				
				$lang_id = $this->config->get('config_language_id');
				$store_id = $this->request->post['store_id'];
				$cgroup_id = $this->config->get('config_customer_group_id');

				if (isset($this->request->post['insert_products'])) {
					$insert_products = $this->request->post['insert_products'];
				} else {
					$insert_products = false;
				}
/*				
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
						$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$special_limit);
						
						if (!isset($special_cache_data)) {
							$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit);
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

				} else {
					$special = '';
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
						$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$bestseller_limit);
						
						if (!isset($bestseller_cache_data)) {
							$bestsellers = $this->model_sale_contacts->getBestsellerProducts($bestseller_limit);
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
					
				} else {
					$bestseller = '';
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
						$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$latest_limit);
						
						if (!isset($latest_cache_data)) {
							$latests = $this->model_sale_contacts->getLatestProducts($latest_limit);
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

				} else {
					$latest = '';
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
						$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$featured_limit);
					
						if (!isset($featured_cache_data)) {
							$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit);
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
					
				} else {
					$featured = '';
				}

				if (isset($this->request->post['selectproducts']) && isset($this->request->post['selproducts']) && is_array($this->request->post['selproducts'])) {
					if ($this->request->post['selproducts_title']) {
						$selproducts_title = $this->request->post['selproducts_title'];
					} else {
						$selproducts_title = $this->language->get('selproducts_title');
					}
					
					$selected_products = array();
					
					if (!$add_cron) {
						$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id);
						
						if (!isset($selected_cache_data)) {
							$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts']);
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
					
				} else {
					$selproducts = '';
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
						$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$catproducts_limit);
						
						if (!isset($catproduct_cache_data)) {
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
					
				} else {
					$catproducts = '';
				}

				$email_total = 0;
				$emails = array();
				$emails_cache = array();
				$attachments = array();
				$send_to_data = '';
				$send_attachments = '';
*/				
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
				
				if ($spam_check) {
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
							$json['check_url'] = $check_url;
						} else {
							$json['error']['warning'] = $this->language->get('error_spam_check');
						}
						
					} else {
						$json['error']['warning'] = $this->language->get('error_spam_check');
					}
				
				} elseif ($add_cron) {
					if ($this->request->post['to'] == 'customer_group') {
						if (isset($this->request->post['customer_group_id']) && !empty($this->request->post['customer_group_id']) && is_array($this->request->post['customer_group_id'])) {
							$send_to_data = implode(',', $this->request->post['customer_group_id']);
						}
					}
					if ($this->request->post['to'] == 'customer') {
						if (isset($this->request->post['customer']) && !empty($this->request->post['customer']) && is_array($this->request->post['customer'])) {
							$send_to_data = implode(',', $this->request->post['customer']);
						}
					}
					if ($this->request->post['to'] == 'send_group') {
						if (isset($this->request->post['send_group_id']) && !empty($this->request->post['send_group_id']) && is_array($this->request->post['send_group_id'])) {
							$send_to_data = implode(',', $this->request->post['send_group_id']);
						}
					}
					if ($this->request->post['to'] == 'affiliate') {
						if (isset($this->request->post['affiliate']) && !empty($this->request->post['affiliate']) && is_array($this->request->post['affiliate'])) {
							$send_to_data = implode(',', $this->request->post['affiliate']);
						}
					}
					if ($this->request->post['to'] == 'product') {
						if (isset($this->request->post['product']) && !empty($this->request->post['product']) && is_array($this->request->post['product'])) {
							$send_to_data = implode(',', $this->request->post['product']);
						}
					}
					if ($this->request->post['to'] == 'manual') {
						if (isset($this->request->post['manual']) && !empty($this->request->post['manual'])) {
							$send_to_data = $this->request->post['manual'];
						}
					}
				
				} else {
				
					$emails_cache = $this->cache->get('contacts.emails.' . (int)$send_id);
					
					if ($emails_cache) {

						$emails = $emails_cache['emails'];
						$email_total = $emails_cache['email_total'];

					} else {
					
					  switch ($this->request->post['to']) {
						case 'newsletter':
							$customer_data = array(
								'filter_newsletter'  => 1,
								'filter_country_id'  => $country_id,
								'filter_zone_id'     => $zone_id
							);

							$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
						
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
							$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
							
							$emails_cache['emails'] = $emails;
							$emails_cache['email_total'] = $email_total;
							$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);

							break;
						case 'customer_all':
							$customer_data = array(
								'filter_country_id'  => $country_id,
								'filter_zone_id'     => $zone_id
							);

							$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
					
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
							$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
							
							$emails_cache['emails'] = $emails;
							$emails_cache['email_total'] = $email_total;
							$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);

							break;
						case 'client_all':
							$customer_data = array(
								'filter_country_id'  => $country_id,
								'filter_zone_id'     => $zone_id
							);
							
							$results = $this->model_sale_contacts->getEmailsByOrdereds($customer_data);
					
							foreach ($results as $result) {
								$unsuber = false;
								
								if ($control_unsubscribe) {
									if ($this->model_sale_contacts->checkEmailUnsubscribe($result['email'])) {
										$unsuber = true;
									}

									if (($result['customer_id'] > 0) && (!$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id']))) {
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
							$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));

							$emails_cache['emails'] = $emails;
							$emails_cache['email_total'] = $email_total;
							$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);

							break;
						case 'customer_group':
							if (isset($this->request->post['customer_group_id']) && !empty($this->request->post['customer_group_id']) && is_array($this->request->post['customer_group_id'])) {
								$customer_data = array(
									'filter_customer_group_id' => $this->request->post['customer_group_id'],
									'filter_country_id'        => $country_id,
									'filter_zone_id'           => $zone_id,
									'filter_unsubscribe'       => $control_unsubscribe
								);
								
								$send_to_data = implode(',', $this->request->post['customer_group_id']);

								$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
						
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
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));

								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
						case 'customer':
							if (isset($this->request->post['customer']) && !empty($this->request->post['customer']) && is_array($this->request->post['customer'])) {
								foreach ($this->request->post['customer'] as $customer_id) {
									$customer_info = $this->model_sale_contacts->getCustomerData($customer_id);
									
									if ($customer_info) {
										if (!$control_unsubscribe || $this->model_sale_contacts->checkCustomerNewsletter($customer_info['customer_id'])) {
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
								
								$send_to_data = implode(',', $this->request->post['customer']);

								$email_total = count($emails);
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
								
								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
						case 'send_group':
							if (isset($this->request->post['send_group_id']) && !empty($this->request->post['send_group_id']) && is_array($this->request->post['send_group_id'])) {
								$customer_data = array(
									'filter_group_id'       => $this->request->post['send_group_id'],
									'filter_unsubscribe'    => $control_unsubscribe
								);
								
								$send_to_data = implode(',', $this->request->post['send_group_id']);

								$results = $this->model_sale_contacts->getNewsletters($customer_data);
						
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
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));

								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
						case 'affiliate_all':
							$affiliate_data = array(
								'filter_country_id'   => $country_id,
								'filter_zone_id'      => $zone_id
							);
							
							$results = $this->model_sale_contacts->getEmailAffiliates($affiliate_data);
					
							foreach ($results as $result) {
								if (!$control_unsubscribe || !$this->model_sale_contacts->checkEmailUnsubscribe($result['email'])) {
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
							$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));

							$emails_cache['emails'] = $emails;
							$emails_cache['email_total'] = $email_total;
							$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);

							break;
						case 'affiliate':
							if (isset($this->request->post['affiliate']) && !empty($this->request->post['affiliate']) && is_array($this->request->post['affiliate'])) {
								foreach ($this->request->post['affiliate'] as $affiliate_id) {
									$affiliate_info = $this->model_sale_contacts->getAffiliateData($affiliate_id);
									
									if ($affiliate_info) {
										if (!$control_unsubscribe || !$this->model_sale_contacts->checkEmailUnsubscribe($affiliate_info['email'])) {
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
								
								$send_to_data = implode(',', $this->request->post['affiliate']);
								
								$email_total = count($emails);
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
								
								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
						case 'product':
							if (isset($this->request->post['product']) && !empty($this->request->post['product']) && is_array($this->request->post['product'])) {
								$data = array(
									'filter_products'     => $this->request->post['product'],
									'filter_country_id'   => $country_id,
									'filter_zone_id'      => $zone_id
								);

								$results = $this->model_sale_contacts->getEmailsByOrdereds($data);

								foreach ($results as $result) {
									$unsuber = false;
									
									if ($control_unsubscribe) {
										if ($this->model_sale_contacts->checkEmailUnsubscribe($result['email'])) {
											$unsuber = true;
										}

										if (($result['customer_id'] > 0) && (!$this->model_sale_contacts->checkCustomerNewsletter($result['customer_id']))) {
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
								
								$send_to_data = implode(',', $this->request->post['product']);
								
								$email_total = count($emails);
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));

								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
						case 'manual':
							if (isset($this->request->post['manual']) && !empty($this->request->post['manual'])) {
								$post_manuals = explode(',', preg_replace('/\s/', '', $this->request->post['manual']));
								$manuals = array_unique($post_manuals);
								foreach ($manuals as $manual) {
									if (trim($manual) != '') {
										if (!$control_unsubscribe || !$this->model_sale_contacts->checkEmailUnsubscribe($manual)) {
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
								$contacts_log->write(sprintf($this->language->get('text_count_email'), $email_total));
								
								$emails_cache['emails'] = $emails;
								$emails_cache['email_total'] = $email_total;
								$this->cache->set('contacts.emails.' . (int)$send_id, $emails_cache);
							}
							break;
					  }
					}
				}

				if (!$spam_check && $page == 1) {
					$data_send = array(
						'store_id'        => $this->request->post['store_id'],
						'send_to'         => $this->request->post['to'],
						'send_to_data'    => $send_to_data,
						'send_region'     => $set_region,
						'send_country_id' => $country_id,
						'send_zone_id'    => $zone_id,
						'send_products'   => $insert_products,
						'subject'         => $this->request->post['subject'],
						'message'         => $this->request->post['message'],
						'attachments'     => $send_attachments,
						'email_total'     => $email_total,
						'unsub_url'       => $set_unsubscribe,
						'control_unsub'   => $control_unsubscribe
					);
					
					if (!$add_cron) {
						$this->model_sale_contacts->setDataNewSend($send_id, $data_send);
					} else {
						$this->model_sale_contacts->addDataCron($cron_id, $data_send);
					}
				}

				if ($emails) {
					if (!$spam_check && $page == 1) {
						$this->model_sale_contacts->saveEmailsToSend($send_id, $emails);
					}
					
					sleep($contacts_sleep_time);
					$start = ($page - 1) * $contacts_count_message;
					$end = $start + $contacts_count_message;
					$lastsend = 0;
					$count_send_error = 0;
					$savemessage = '';
					
					if ($end < $email_total) {
						$json['success'] = sprintf($this->language->get('text_sent'), $end, $email_total);
					} else {
						$json['success'] = $this->language->get('text_success');
						$lastsend = 1;
					}
						
					if ($end < $email_total) {
						$json['next'] = str_replace('&amp;', '&', $this->url->link('sale/contacts/send', 'sid=' . $send_id . '&token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
					} else {
						$json['next'] = '';
					}
					
					if ($spam_check) {
						$json['next'] = '';
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
// added
/*
								$selected_products = array();


								$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts']);

								if (!empty($selecteds)) {
									$selected_products = $this->getMailProducts($selecteds, $customer_group_id, $customer['customer_id']);
								}


								if ($selected_products) {
									$selproducts_template = new Template();
									$selproducts_template->data['title'] = $selproducts_title;
									$selproducts_template->data['products'] = $selected_products;
									$selproducts = $selproducts_template->fetch('mail/contacts_products.tpl');					
								} else {
									$selproducts = '';
								}



*/		

				
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
						//$special_cache_data = $this->cache->get('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$special_limit);
						
						//if (!isset($special_cache_data)) {
							$specials = $this->model_sale_contacts->getSpecialsProducts($special_limit);
							if (!empty($specials)) {
								$special_products = $this->getMailProducts($specials, $customer_group_id, $customer['customer_id']);
							}
							//$this->cache->set('contacts.special.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$special_limit, $special_products);
						//} else {
						//	$special_products = $special_cache_data;
						//}
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

				} else {
					$special = '';
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
						//$bestseller_cache_data = $this->cache->get('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$bestseller_limit);
						
						//if (!isset($bestseller_cache_data)) {
							$bestsellers = $this->model_sale_contacts->getBestsellerProducts($bestseller_limit);
							if (!empty($bestsellers)) {
								$bestseller_products = $this->getMailProducts($bestsellers, $customer_group_id, $customer['customer_id']);
							}
							//$this->cache->set('contacts.bestseller.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$bestseller_limit, $bestseller_products);
						//} else {
						//	$bestseller_products = $bestseller_cache_data;
						//}
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
					
				} else {
					$bestseller = '';
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
						//$latest_cache_data = $this->cache->get('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$latest_limit);
						
						//if (!isset($latest_cache_data)) {
							$latests = $this->model_sale_contacts->getLatestProducts($latest_limit);
							if (!empty($latests)) {
								$latest_products = $this->getMailProducts($latests, $customer_group_id, $customer['customer_id']);
							}
							//$this->cache->set('contacts.latest.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$latest_limit, $latest_products);
						//} else {
						//	$latest_products = $latest_cache_data;
						//}
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

				} else {
					$latest = '';
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
						//$featured_cache_data = $this->cache->get('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$featured_limit);
					
						//if (!isset($featured_cache_data)) {
							$featureds = $this->model_sale_contacts->getFeaturedProducts($featured_limit);
							if (!empty($featureds)) {
								$featured_products = $this->getMailProducts($featureds, $customer_group_id, $customer['customer_id']);
							}
							//$this->cache->set('contacts.featured.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$featured_limit, $featured_products);
						//} else {
						//	$featured_products = $featured_cache_data;
						//}
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
					
				} else {
					$featured = '';
				}

				if (isset($this->request->post['selectproducts']) && isset($this->request->post['selproducts']) && is_array($this->request->post['selproducts'])) {
					if ($this->request->post['selproducts_title']) {
						$selproducts_title = $this->request->post['selproducts_title'];
					} else {
						$selproducts_title = $this->language->get('selproducts_title');
					}
					
					$selected_products = array();
					
					if (!$add_cron) {
						//$selected_cache_data = $this->cache->get('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id);
						
						//if (!isset($selected_cache_data)) {
							$selecteds = $this->model_sale_contacts->getSelectedProducts($this->request->post['selproducts']);
							if (!empty($selecteds)) {
								$selected_products = $this->getMailProducts($selecteds, $customer_group_id, $customer['customer_id']);
							}
							//$this->cache->set('contacts.selected.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id, $selected_products);
						//} else {
							//$selected_products = $selected_cache_data;
						//}
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
					
				} else {
					$selproducts = '';
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
						//$catproduct_cache_data = $this->cache->get('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$catproducts_limit);
						
						//if (!isset($catproduct_cache_data)) {
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
							//$this->cache->set('contacts.catproduct.' . (int)$lang_id . '.' . (int)$store_id . '.' . (int)$cgroup_id . '.' . (int)$send_id . '.' . (int)$catproducts_limit, $category_products);
						//} else {
							//$category_products = $catproduct_cache_data;
						//}
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
					
				} else {
					$catproducts = '';
				}

				$email_total = 0;
				$emails = array();
				$emails_cache = array();
				$attachments = array();
				$send_to_data = '';
				$send_attachments = '';











//								







								$replace_subject = array($firstname, $lastname, $name, $country, $zone, $shopname);
								$replace_message = array($firstname, $lastname, $name, $country, $zone, $shopname, $shopurl, $special, $bestseller, $latest, $featured, $selproducts, $catproducts);
								
								$orig_subject = $this->request->post['subject'];
								$orig_message = $this->request->post['message'];
							
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
								
								$controlimage = HTTP_CATALOG . 'index.php?route=feed/stats/images&sid=' . $sid;
								$message .= '  <body><table style="width:98%;background:url(' . $controlimage . ');margin-left:auto;margin-right:auto;"><tr><td>' . html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8') . "\n\n";
								
								if ($set_unsubscribe) {
									$unsubscribe_url = HTTP_CATALOG . 'index.php?route=account/success&sid=' . $sid;
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
								$contacts_log->write($this->language->get('text_send_email') . $email);
								$send_status = $mail->send();
								if ($send_status == 55) {
									$this->model_sale_contacts->removeEmailSend($send_id, $email);
								} elseif (substr($send_status, 0, 4) == 'cerr') {
									$contacts_log->write('mail critic error ' . $email);
									$lastsend = 0;
									$json['success'] = '';
									$json['next'] = '';
									$json['error']['warning'] = $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_stop_send');
									$json['stop_send'] = $send_id;
									break;
								} elseif (substr($send_status, 0, 4) == 'nerr') {
									$contacts_log->write('mail error ' . $email);
									$json['attention'][] = $this->language->get('error_send_attention') . '<br />' . $this->language->get('error_send_' . substr($send_status, 4, 2)) . '<br />' . $this->language->get('text_continues_send');
									$this->model_sale_contacts->removeEmailSend($send_id, $email);
									$count_send_error++;
								} else {
									$count_send_error++;
								}
							} else {
								$contacts_log->write($this->language->get('text_bad_email') . $email);
								$this->model_sale_contacts->removeEmailSend($send_id, $email);
							}
						} else {
							$contacts_log->write($this->language->get('error_send_count'));
							$lastsend = 0;
							$json['success'] = '';
							$json['next'] = '';
							$json['error']['warning'] = $this->language->get('error_send_count');
							break;
						}
					}

					if(!$spam_check && ($page == 1)) {
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
				
				} elseif ($add_cron) {
					$this->cache->delete('contacts');
					$json['success'] = $this->language->get('text_success_cron');
					$json['next'] = '';
				} else {
					$this->cache->delete('contacts');
					$this->model_sale_contacts->delDataSend($send_id);
					if(!$spam_check) {
						$contacts_log->write($this->language->get('error_noemails'));
						$json['error']['warning'] = $this->language->get('error_noemails');
					}
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
				
				if (isset($this->request->post['from_country_id'])) {
					$country_id = $this->request->post['from_country_id'];
				} else {
					$country_id = false;
				}
				
				if (isset($this->request->post['from_zone_id'])) {
					$zone_id = $this->request->post['from_zone_id'];
				} else {
					$zone_id = false;
				}
				
				$news_data = array();
				
				$for_group_id = $this->request->post['filter_for_group'];
				
				$oldnews = $this->model_sale_contacts->getEmailsNewslettersFromGroup($for_group_id);
				
				  switch ($this->request->post['from']) {
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter'  => 1,
							'filter_country_id'  => $country_id,
							'filter_zone_id'     => $zone_id
						);
						
						$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
					
						foreach ($results as $result) {
							if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
								$news_data[] = array(
									'group_id'     => $for_group_id,
									'customer_id'  => $result['customer_id'],
									'email'        => $result['email']
								);
							}
						}
						break;
					case 'customer_all':
						$customer_data = array(
							'filter_country_id'  => $country_id,
							'filter_zone_id'     => $zone_id
						);
						
						$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
				
						foreach ($results as $result) {
							if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
								$news_data[] = array(
									'group_id'     => $for_group_id,
									'customer_id'  => $result['customer_id'],
									'email'        => $result['email']
								);
							}
						}
						break;
					case 'client_all':
						$customer_data = array(
							'filter_country_id'  => $country_id,
							'filter_zone_id'     => $zone_id
						);
						
						$results = $this->model_sale_contacts->getEmailsByOrdereds($customer_data);
				
						foreach ($results as $result) {
							if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
								$news_data[] = array(
									'group_id'     => $for_group_id,
									'customer_id'  => $result['customer_id'],
									'email'        => $result['email']
								);
							}
						}
						break;
					case 'customer_group':
						if (isset($this->request->post['from_customer_group_id']) && !empty($this->request->post['from_customer_group_id']) && is_array($this->request->post['from_customer_group_id'])) {
							$customer_data = array(
								'filter_customer_group_id' => $this->request->post['from_customer_group_id'],
								'filter_country_id'        => $country_id,
								'filter_zone_id'           => $zone_id
							);

							$results = $this->model_sale_contacts->getEmailCustomers($customer_data);
					
							foreach ($results as $result) {
								if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
									$news_data[] = array(
										'group_id'     => $for_group_id,
										'customer_id'  => $result['customer_id'],
										'email'        => $result['email']
									);
								}
							}
						}
						break;
					case 'customer':
						if (isset($this->request->post['from_customer']) && !empty($this->request->post['from_customer']) && is_array($this->request->post['from_customer'])) {
							foreach ($this->request->post['from_customer'] as $customer_id) {
								$customer_info = $this->model_sale_contacts->getCustomerData($customer_id);
								
								if ($customer_info) {
									if (!in_array(utf8_strtolower($customer_info['email']), $oldnews)) {
										$news_data[] = array(
											'group_id'     => $for_group_id,
											'customer_id'  => $customer_info['customer_id'],
											'email'        => $customer_info['email']
										);
									}
								}
							}
						}
						break;
					case 'send_group':
						if (isset($this->request->post['from_send_group_id']) && !empty($this->request->post['from_send_group_id']) && is_array($this->request->post['from_send_group_id'])) {
							$customer_data = array(
								'filter_group_id'       => $this->request->post['from_send_group_id']
							);

							$results = $this->model_sale_contacts->getNewsletters($customer_data);
					
							foreach ($results as $result) {
								if (!in_array(utf8_strtolower($result['cemail']), $oldnews)) {
									$news_data[] = array(
										'group_id'     => $for_group_id,
										'customer_id'  => $result['customer_id'],
										'email'        => $result['cemail']
									);
								}
							}
						}
						break;
					case 'affiliate_all':
						$affiliate_data = array(
							'filter_country_id'   => $country_id,
							'filter_zone_id'      => $zone_id
						);
						
						$results = $this->model_sale_contacts->getEmailAffiliates($affiliate_data);
				
						foreach ($results as $result) {
							if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
								$customer_info = $this->model_sale_contacts->getCustomerFromEmail($result['email']);
								if ($customer_info) {
									$customer_id = $customer_info['customer_id'];
								} else {
									$customer_id = 0;
								}
								
								$news_data[] = array(
									'group_id'     => $for_group_id,
									'customer_id'  => $customer_id,
									'email'        => $result['email']
								);
							}
						}
						break;
					case 'affiliate':
						if (isset($this->request->post['from_affiliate']) && !empty($this->request->post['from_affiliate']) && is_array($this->request->post['from_affiliate'])) {
							foreach ($this->request->post['from_affiliate'] as $affiliate_id) {
								$affiliate_info = $this->model_sale_contacts->getAffiliateData($affiliate_id);
								
								if ($affiliate_info) {
									if (!in_array(utf8_strtolower($affiliate_info['email']), $oldnews)) {
										$customer_info = $this->model_sale_contacts->getCustomerFromEmail($result['email']);
										if ($customer_info) {
											$customer_id = $customer_info['customer_id'];
										} else {
											$customer_id = 0;
										}
										
										$news_data[] = array(
											'group_id'     => $for_group_id,
											'customer_id'  => $customer_id,
											'email'        => $affiliate_info['email']
										);
									}
								}
							}
						}
						break;
					case 'product':
						if (isset($this->request->post['from_product']) && !empty($this->request->post['from_product']) && is_array($this->request->post['from_product'])) {
							$product_data = array(
								'filter_products'     => $this->request->post['from_product'],
								'filter_country_id'   => $country_id,
								'filter_zone_id'      => $zone_id
							);

							$results = $this->model_sale_contacts->getEmailsByOrdereds($product_data);

							foreach ($results as $result) {
								if (!in_array(utf8_strtolower($result['email']), $oldnews)) {
									$news_data[] = array(
										'group_id'     => $for_group_id,
										'customer_id'  => $result['customer_id'],
										'email'        => $result['email']
									);
								}
							}
						}
						break;
					case 'manual':
						if (!empty($this->request->post['from_manual'])) {
							$post_manuals = explode(',', preg_replace('/\s/', '', $this->request->post['from_manual']));
							$manuals = array_unique($post_manuals);
							
							foreach ($manuals as $manual) {
								if (trim($manual) != '') {
									if (!in_array(utf8_strtolower($manual), $oldnews)) {
										$customer_info = $this->model_sale_contacts->getCustomerFromEmail($manual);
										if ($customer_info) {
											$customer_id = $customer_info['customer_id'];
										} else {
											$customer_id = 0;
										}
										
										$news_data[] = array(
											'group_id'     => $for_group_id,
											'customer_id'  => $customer_id,
											'email'        => $manual
										);
									}
								}
							}
						}
						break;
					case 'sql_manual':
						if (!empty($this->request->post['from_sql_table']) && !empty($this->request->post['from_sql_column'])) {
							$sql_manuals = $this->model_sale_contacts->getEmailsFromSqlManual($this->request->post['from_sql_table'], $this->request->post['from_sql_column']);

							if (!empty($sql_manuals)) {
								$manuals = array_unique($sql_manuals);
								foreach ($manuals as $manual) {
									if (trim($manual) != '') {
										if (!in_array($manual, $oldnews)) {
											$customer_info = $this->model_sale_contacts->getCustomerFromEmail($manual);
											if ($customer_info) {
												$customer_id = $customer_info['customer_id'];
											} else {
												$customer_id = 0;
											}
											
											$news_data[] = array(
												'group_id'     => $for_group_id,
												'customer_id'  => $customer_id,
												'email'        => $manual
											);
										}
									}
								}
							}
						}
						break;						
				  }

				if($news_data) {
					$newsletters = $this->model_sale_contacts->addNewsletters($news_data);
					$json['email_total'] = sprintf($this->language->get('text_import_email_total'), count($newsletters));
				} else {
					$json['error'] = $this->language->get('error_noemails');
				}
			}
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
				$json['send_alarm'] = sprintf($this->language->get('missins_send_alarm'), $msend_info['date_added']);
				$json['send_title'] = sprintf($this->language->get('missins_send_title'), utf8_substr(html_entity_decode($msend_info['subject'], ENT_QUOTES, 'UTF-8'), 0, 30) . '..');
				$json['send_info'] = sprintf($this->language->get('missins_send_info'), $this->language->get('text_' . $msend_info['send_to']), $count_miss_emails, $msend_info['email_total']);
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
		$message = '';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$send_message = $this->model_sale_contacts->getMessageSend($this->request->get['sid']);
			
			if ($send_message) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;margin:5px 20px;position:relative;">' . html_entity_decode($send_message, ENT_QUOTES, 'UTF-8') . '</div>';
				$message .= '</div>';
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
	}
	
	public function viewnewmessage() {
		$this->language->load('sale/contacts');
		$message = '';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$send_message = $this->model_sale_contacts->getNewMessageSend($this->request->get['sid']);
			
			if ($send_message) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;margin:5px 20px;position:relative;">' . html_entity_decode($send_message, ENT_QUOTES, 'UTF-8') . '</div>';
				$message .= '</div>';
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
	}
	
	public function viewunsubscribes() {
		$this->language->load('sale/contacts');
		
		$message = '';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$unsubscribes = $this->model_sale_contacts->getUnsubscribesfromSend($this->request->get['sid']);
			
			if (!empty($unsubscribes)) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;width:500px;5px 20px;position:relative;">';
				$message .= '<table class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td>' . $this->language->get('column_date_added') . '</td><td>' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
				
				foreach($unsubscribes as $unsubscribe){
					$message .= '<tr>';
					$message .= '<td>' . $unsubscribe['email'] . '</td>';
					$message .= '<td class="center">' . $unsubscribe['date_added'] . '</td>';
					$message .= '<td class="center" style="width:48px;">' . $unsubscribe['customer_id'] . '</td>';
					$message .= '</tr>';
				}
				
				$message .= '</tbody></table>';
				$message .= '</div></div>';
				
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
	}
	
	public function viewopens() {
		$this->language->load('sale/contacts');
		
		$message = '';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$views = $this->model_sale_contacts->getViewsfromSend($this->request->get['sid']);
			
			if (!empty($views)) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;width:500px;margin:5px 20px;position:relative;">';
				$message .= '<table class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td>' . $this->language->get('column_date_added') . '</td><td>' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
				
				foreach($views as $view){
					$message .= '<tr>';
					$message .= '<td>' . $view['email'] . '</td>';
					$message .= '<td class="center">' . $view['date_added'] . '</td>';
					$message .= '<td class="center" style="width:48px;">' . $view['customer_id'] . '</td>';
					$message .= '</tr>';
				}
				
				$message .= '</tbody></table>';
				$message .= '</div></div>';
				
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
	}
	
	public function viewclicks() {
		$this->language->load('sale/contacts');
		
		$message = '';

		if (isset($this->request->get['sid'])) {
			$this->load->model('sale/contacts');

			$clicks = $this->model_sale_contacts->getClicksfromSend($this->request->get['sid']);
			
			if (!empty($clicks)) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;width:600px;margin:5px 20px;position:relative;">';
				$message .= '<table class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_email') . '</td><td>' . $this->language->get('column_url') . '</td><td>' . $this->language->get('column_date_added') . '</td><td>' . $this->language->get('column_customer_id') . '</td></tr>';
				$message .= '</thead>';
				$message .= '<tbody>';
				
				foreach($clicks as $click){
					$message .= '<tr>';
					$message .= '<td>' . $click['email'] . '</td>';
					$message .= '<td>' . $click['target'] . '</td>';
					$message .= '<td class="center">' . $click['date_added'] . '</td>';
					$message .= '<td class="center" style="width:48px;">' . $click['customer_id'] . '</td>';
					$message .= '</tr>';
				}
				
				$message .= '</tbody></table>';
				$message .= '</div></div>';
				
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
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
	
	public function getMailProducts($results, $customer_group_id = 1, $customer_id = 0) {
		$products = array();
		$this->load->model('sale/customer');

		$customer_group_id = $this->model_sale_customer->getCustomer($customer_id)['customer_group_id'];

		$this->load->model('catalog/product');  // added


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

		foreach ($results as $value) {

			$result = $this->model_catalog_product->getProductMp($value['product_id'], $customer_group_id, $customer_id, 0, 4); // added

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
							//$special = '';
							$discount = '';
					}
				}
			} 
//

			$product_options = $this->model_catalog_product->getProductOptionsmp($value['product_id']);
			$price_from = 0;
			if($product_options) {
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
//
			$products[] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'discount'   => !empty($discount)?'-'.$discount.'%':'',
				'name'    	 => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				'price'   	 => $result['price'] ? $this->currency->format($result['price'], $this->config->get('config_currency')) : ' ',
				'price_nof'  => $result['price'], // added 
				'price_from' => $price_from ? $this->currency->format($price_from, $this->config->get('config_currency')) : ' ', // added
				'model'    	 => $result['model'],
				'sku'    	 => $result['sku'],
				'special' 	 => $special,
				'rating'     => $rating,
				'product_options_data'     => array(), //$product_options_data,
				'href'    	 => str_replace(HTTP_SERVER, HTTP_CATALOG, $this->url->link('product/product', 'product_id=' . $result['product_id']))
			);
		}
		//print_r($products);
		return $products;
	}

	public function getcron() {
		$json = array();

		if (isset($this->request->get['cron_id'])) {
			$this->load->model('sale/contacts');
			$cron_data = $this->model_sale_contacts->getCron($this->request->get['cron_id']);
			
			if (!empty($cron_data)) {
				$json['name'] = $cron_data['name'];
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
			
			if (isset($this->request->post['cron_period']) && ($this->request->post['cron_period'] > 0)) {
				$cron_period = $this->request->post['cron_period'];
			} else {
				$cron_period = 0;
			}
						
			if (isset($this->request->post['cron_status'])) {
				$status = 1;
			} else {
				$status = 0;
			}
			
			if (!$json) {
				$data = array(
					'name'        => $this->request->post['cron_name'],
					'date_start'  => $this->request->post['cron_date_start'],
					'period'      => $cron_period,
					'status'      => $status
				);
				
				if (isset($this->request->get['cron_id'])) {
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['cron_id'])) {
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
		$json['logs'] = '';

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
		
		if (isset($this->request->get['cronlog']) && file_exists(DIR_LOGS . $this->request->get['cronlog'])) {
			unlink(DIR_LOGS . $this->request->get['cronlog']);
			$json['success'] = 1;
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function viewhistory() {
		$this->language->load('sale/contacts');
		
		$message = '';

		if (isset($this->request->get['cron_id'])) {
			$this->load->model('sale/contacts');

			$histories = $this->model_sale_contacts->getCronHistories($this->request->get['cron_id']);
			
			if (!empty($histories)) {
				$message .= '<div>';
				$message .= '<div style="overflow:auto;width:600px;margin:5px 20px;position:relative;">';
				$message .= '<table class="list info-table">';
				$message .= '<thead>';
				$message .= '<tr><td>' . $this->language->get('column_date_start') . '</td><td>' . $this->language->get('column_date_end') . '</td><td>' . $this->language->get('column_email_total') . '</td><td>' . $this->language->get('column_cron_status') . '</td></tr>';
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
					$message .= '<td class="center" style="width:50px;">' . $history['count_emails'] . '</td>';
					$message .= '<td class="center">' . $text_cron_status . '</td>';
					$message .= '</tr>';
				}
				
				$message .= '</tbody></table>';
				$message .= '</div></div>';
				
			} else {
				$message .= '<div style="width:400px;text-align:center;padding:10px 0;">' . $this->language->get('text_no_data') . '</div>';
			}
		}
		
		$this->response->setOutput($message);
	}
	
	public function getsendgroup() {
		$json = array();

		$this->load->model('sale/contacts');

		if (isset($this->request->get['group_id'])) {
			$group_data = $this->model_sale_contacts->getSendGroup($this->request->get['group_id']);
			if (!empty($group_data)) {
				$json['name'] = $group_data['name'];
				$json['description'] = $group_data['description'];
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function savegroup() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['group_name']) < 1) || (utf8_strlen($this->request->post['group_name']) > 64)) {
				$json['error'] = $this->language->get('error_group_name');
			}
			
			if (utf8_strlen($this->request->post['group_description']) > 255) {
				$json['error'] = $this->language->get('error_group_description');
			}
			
			if (!$json) {
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['group_id'])) {
				$this->model_sale_contacts->delSendGroup($this->request->get['group_id']);
				$json['success'] = 1;
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function delnewsletter() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['newsletter_id'])) {
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->post['nselected']) && !empty($this->request->post['nselected']) && is_array($this->request->post['nselected'])) {
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			$group_id = $this->request->get['group_id'];
			if ($group_id) {
				if (isset($this->request->post['nselected']) && !empty($this->request->post['nselected']) && is_array($this->request->post['nselected'])) {
					$this->model_sale_contacts->movedNewsletters($group_id, $this->request->post['nselected']);
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
	
	public function subnewsletter() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['newsletter_id'])) {
				$newsletter_info = $this->model_sale_contacts->getNewsletter($this->request->get['newsletter_id']);
				
				if ($newsletter_info && $newsletter_info['email']) {
					$this->model_sale_contacts->setSubscribe($newsletter_info['email']);
					$json['success'] = $this->language->get('text_subs_ok');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_newsl_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function unsubnewsletter() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['newsletter_id'])) {
				$newsletter_info = $this->model_sale_contacts->getNewsletter($this->request->get['newsletter_id']);
				
				if ($newsletter_info && $newsletter_info['email']) {
					$this->model_sale_contacts->addUnsubscribe($newsletter_info['email'],0,$newsletter_info['customer_id']);
					$json['success'] = $this->language->get('text_unsubs_ok');
				}
			}
		} else {
			$json['error'] = $this->language->get('error_newsl_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function gettemplate() {
		$json = array();

		$this->load->model('sale/contacts');

		if (isset($this->request->get['template_id'])) {
			$template_id = $this->request->get['template_id'];
			$message_data = $this->model_sale_contacts->getTemplate($template_id);
			if (!empty($message_data)) {
				$json['template_id'] = $message_data['template_id'];
				$json['name'] = $message_data['name'];
				$json['message'] = html_entity_decode($message_data['message'], ENT_QUOTES, 'UTF-8');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function deltemplate() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if ($this->validate()) {
			if (isset($this->request->get['template_id'])) {
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['temp_name']) < 1) || (utf8_strlen($this->request->post['temp_name']) > 255)) {
				$json['error'] = $this->language->get('error_name_template');
			} else {
				if (!isset($this->request->get['template_id'])) {
					$json['error'] = $this->language->get('error_save_template');
				} else {
					$data = array(
						'name'    => $this->request->post['temp_name'],
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
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['new_temp_name']) < 1) || (utf8_strlen($this->request->post['new_temp_name']) > 255)) {
				$json['error'] = $this->language->get('error_name_template');
			} else {
				$data = array(
					'name'    => $this->request->post['new_temp_name'],
					'message' => $this->request->post['message']
				);
				$json['template_id'] = $this->model_sale_contacts->addTemplate($data);
				$json['success'] = $this->language->get('text_success_data');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function addnewtemplate() {
		$json = array();
		
		$this->load->model('sale/contacts');
		$this->language->load('sale/contacts');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((utf8_strlen($this->request->post['temp_name']) < 1) || (utf8_strlen($this->request->post['temp_name']) > 255)) {
				$json['error'] = $this->language->get('error_name_template');
			} else {
				$data = array(
					'name'    => $this->request->post['temp_name'],
					'message' => $this->request->post['temp_message']
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
		
		$this->load->model('setting/setting');
		$this->language->load('sale/contacts');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$data = $this->request->post;
			$data['contacts_unsub_pattern'] = $this->config->get('contacts_unsub_pattern');
			$this->model_setting_setting->editSetting('contacts', $data);
			$json['success'] = $this->language->get('text_success_setting');
		} else {
			$json['error'] = $this->language->get('error_save_setting');
		}
		
		$this->response->setOutput(json_encode($json));
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
	
	public function podindex($args) {
/*
		$this->language->load('myoc/pod');

		$pod_data['text_col_quantity'] = $this->language->get('text_col_quantity');
		$pod_data['text_col_stock'] = $this->language->get('text_col_stock');
		$pod_data['text_select'] = $this->language->get('text_select');
		$pod_data['text_order'] = $this->language->get('text_order');
		$pod_data['text_unit'] = $this->language->get('text_unit');
		$pod_data['text_total'] = $this->language->get('text_total');
		$pod_data['text_price'] = $this->language->get('text_price');
		$pod_data['text_extax'] = $this->language->get('text_extax');
		$pod_data['button_cart'] = $this->language->get('button_cart');
		$pod_data['error_quantity'] = $this->language->get('error_quantity');
		*/

		//$this->getPod($getpod_data);

		$pods = array();
		$pods = $this->getPod($args);

		$pod_data['option'] = array();

		if($pods) {
			
			$quantities = $pods['quantities'];

			sort($quantities);

			$this->load->model('catalog/product');

			$product_info = $this->model_catalog_product->getProduct($pods['product_id']);
			$product_discounts = $this->model_catalog_product->getProductDiscountsmp($pods['product_id'], $args['customer_group_id']);
			$product_options = $this->model_catalog_product->getProductOptionsmp($pods['product_id']);
			$price_from = 0; // added
			$exmpl = 10000000.0000;
			//$i = 0;
			foreach ($product_options as $product_option) {


				if($product_option['product_option_id'] == $args['product_option_id'] && is_array($product_option['option_value'])) {

					$option_discount_data = $product_option_value_data = array();
					$ranges = array();

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
// added			
								if($raw_price && $raw_price < $exmpl ) {
									$price_from = $raw_price;
									$exmpl = $raw_price;
								}
								if($raw_special && $raw_special < $exmpl ) {
									$price_from = $raw_special;
									$exmpl = $raw_special;
								}

								
//
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
// added			
						if($option_value_price && $option_value_price < $exmpl ) {
							$price_from = $option_value_price;
							$exmpl = $option_value_price;
						}
//
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
						//$i++;
						//if($i == 2) {
						//	break;
						//}						
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

/*
		    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/myoc/pod.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/myoc/pod.tpl';
			} else {
				$this->template = 'default/template/myoc/pod.tpl';
			}

			$this->render();	
*/		
		}
	}


// added
	public function getPod($getpod_data = array()) {

		$customer_id_discount = array();
		$pods = array();
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
                                'quantities'			=> array(),
                                'pods'					=> array(),
                            );
                        }

						$pod_query = $this->db->query("SELECT pod.* FROM " . DB_PREFIX . "myoc_pod pod LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_option_value_id = pod.product_option_value_id) WHERE pov.product_option_id = '" . (int)$pod_setting['product_option_id'] . "' ORDER BY pod.priority, pod.quantity");
						
                        if($pod_query->num_rows) {
                            foreach($pod_query->rows as $pod) {
                                $pod['customer_group_ids'] = unserialize($pod['customer_group_ids']);
                                $customer_ids = unserialize($pod['customer_ids']); 

                                if(in_array($getpod_data['customer_group_id'], $pod['customer_group_ids'])) {

                                    if(!isset($pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
                                        $pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = array();
                                    }

                                    $pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
                                    $pods[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
                                }
// adeed
                                if(in_array($getpod_data['customer_id'], $customer_ids)) {
                                    if(!isset($customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
                                        $customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = array();
                                    }
                                    $customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
                                    $customer_id_discount[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
                                    //break;
                                }

                            }
                           
                            if($customer_id_discount) {
                            	$pods = array_replace_recursive($pods, $customer_id_discount);
                            	
                            }
				        }
			        }
				}

		}
		return $pods[$getpod_data['product_option_id']];
		 
	}
}
?>
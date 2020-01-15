<?php
class ControllerShippingCustomerGroup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('shipping/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('customer_group', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_settings'] = $this->language->get('text_settings');
		$this->data['text_modules'] = $this->language->get('text_modules');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
	   		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
	  		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
	   		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
	  		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
	   		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/customer_group', 'token=' . $this->session->data['token'], 'SSL'),
	  		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('shipping/customer_group', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();

		if (isset($this->request->post['customer_group_title'])) {
			$this->data['customer_group_title'] = $this->request->post['customer_group_title'];
		} else {
			$this->data['customer_group_title'] = $this->config->get('customer_group_title');
		}
		
		if (isset($this->request->post['customer_group_sort_order'])) {
			$this->data['customer_group_sort_order'] = $this->request->post['customer_group_sort_order'];
		} else {
			$this->data['customer_group_sort_order'] = $this->config->get('customer_group_sort_order');
		}
		
		if (isset($this->request->post['customer_group_status'])) {
			$this->data['customer_group_status'] = $this->request->post['customer_group_status'];
		} else {
			$this->data['customer_group_status'] = $this->config->get('customer_group_status');
		}
		
		if (isset($this->request->post['customer_group_module'])) {
			$this->data['modules'] = $this->request->post['customer_group_module'];
		} elseif ($this->config->get('customer_group_module')) { 
			$this->data['modules'] = $this->config->get('customer_group_module');
		}
		
		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->template = 'shipping/customer_group.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/customer_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
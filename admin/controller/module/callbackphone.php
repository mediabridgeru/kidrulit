<?php
class ControllerModuleCallbackphone extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/callbackphone');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('callbackphone', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['text_activate'] = $this->language->get('text_activate');
		$this->data['text_comment'] = $this->language->get('text_comment');
		$this->data['text_tel'] = $this->language->get('text_tel');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_fax'] = $this->language->get('text_fax');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_rightside'] = $this->language->get('text_rightside');
		$this->data['text_time'] = $this->language->get('text_time');
		$this->data['text_map'] = $this->language->get('text_map');

		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_mask'] = $this->language->get('entry_mask');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_link_title'] = $this->language->get('entry_link_title');
		$this->data['entry_map'] = $this->language->get('entry_map');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_yes'] = $this->language->get( 'entry_yes' );
		$this->data['entry_no']	= $this->language->get( 'entry_no' );

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_warning'] = $this->error['email'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('module/callbackphone', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

   		$this->data['action'] = $this->url->link('module/callbackphone', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['callbackphone_link_title'])) {
			$this->data['callbackphone_link_title'] = $this->request->post['callbackphone_link_title'];
		} else {
			$this->data['callbackphone_link_title'] = $this->config->get('callbackphone_link_title');
		}

		if (isset($this->request->post['callbackphone_title'])) {
			$this->data['callbackphone_title'] = $this->request->post['callbackphone_title'];
		} else {
			$this->data['callbackphone_title'] = $this->config->get('callbackphone_title');
		}

		if (isset($this->request->post['callbackphone_email'])) {
			$this->data['callbackphone_email'] = $this->request->post['callbackphone_email'];
		} else {
			$this->data['callbackphone_email'] = $this->config->get('callbackphone_email');
		}

		if (isset($this->request->post['callbackphone_required'])) {
			$this->data['callbackphone_required'] = $this->request->post['callbackphone_required'];
		} else {
			$this->data['callbackphone_required'] = $this->config->get('callbackphone_required');
		}

		if (isset($this->request->post['callbackphone_address'])) {
			$this->data['callbackphone_address'] = $this->request->post['callbackphone_address'];
		} else {
			$this->data['callbackphone_address'] = $this->config->get('callbackphone_address');
		}

		if (isset($this->request->post['callbackphone_map'])) {
			$this->data['callbackphone_map'] = $this->request->post['callbackphone_map'];
		} else {
			$this->data['callbackphone_map'] = $this->config->get('callbackphone_map');
		}
	
		if (isset($this->request->post['callbackphone_mapshow'])) {
			$this->data['callbackphone_mapshow'] = $this->request->post['callbackphone_mapshow'];
		} else {
			$this->data['callbackphone_mapshow'] = $this->config->get('callbackphone_mapshow');
		}

		if (isset($this->request->post['callbackphone_telephone'])) {
			$this->data['callbackphone_telephone'] = $this->request->post['callbackphone_telephone'];
		} else {
			$this->data['callbackphone_telephone'] = $this->config->get('callbackphone_telephone');
		}

		if (isset($this->request->post['callbackphone_mask'])) {
			$this->data['callbackphone_mask'] = $this->request->post['callbackphone_mask'];
		} else {
			$this->data['callbackphone_mask'] = $this->config->get('callbackphone_mask');
		}

		if (isset($this->request->post['callbackphone_fax'])) {
			$this->data['callbackphone_fax'] = $this->request->post['callbackphone_fax'];
		} else {
			$this->data['callbackphone_fax'] = $this->config->get('callbackphone_fax');
		}

		if (isset($this->request->post['callbackphone_active_time'])) {
			$this->data['callbackphone_active_time'] = $this->request->post['callbackphone_active_time'];
		} else {
			$this->data['callbackphone_active_time'] = $this->config->get('callbackphone_active_time');
		}

		if (isset($this->request->post['callbackphone_active_comment'])) {
			$this->data['callbackphone_active_comment'] = $this->request->post['callbackphone_active_comment'];
		} else {
			$this->data['callbackphone_active_comment'] = $this->config->get('callbackphone_active_comment');
		}

		if (isset($this->request->post['callbackphone_active_address'])) {
			$this->data['callbackphone_active_address'] = $this->request->post['callbackphone_active_address'];
		} else {
			$this->data['callbackphone_active_address'] = $this->config->get('callbackphone_active_address');
		}

		if (isset($this->request->post['callbackphone_active_tel'])) {
			$this->data['callbackphone_active_tel'] = $this->request->post['callbackphone_active_tel'];
		} else {
			$this->data['callbackphone_active_tel'] = $this->config->get('callbackphone_active_tel');
		}

		if (isset($this->request->post['callbackphone_active_fax'])) {
			$this->data['callbackphone_active_fax'] = $this->request->post['callbackphone_active_fax'];
		} else {
			$this->data['callbackphone_active_fax'] = $this->config->get('callbackphone_active_fax');
		}

		if (isset($this->request->post['callbackphone_active_email'])) {
			$this->data['callbackphone_active_email'] = $this->request->post['callbackphone_active_email'];
		} else {
			$this->data['callbackphone_active_email'] = $this->config->get('callbackphone_active_email');
		}

		if (isset($this->request->post['callbackphone_active_rightside'])) {
			$this->data['callbackphone_active_rightside'] = $this->request->post['callbackphone_active_rightside'];
		} else {
			$this->data['callbackphone_active_rightside'] = $this->config->get('callbackphone_active_rightside');
		}

		$this->data['positions'] = array();

		$this->data['positions'][] = array(
			'position' => 'left',
			'title'    => $this->language->get('text_left'),
		);

		$this->data['positions'][] = array(
			'position' => 'right',
			'title'    => $this->language->get('text_right'),
		);

		if (isset($this->request->post['callbackphone_position'])) {
			$this->data['callbackphone_position'] = $this->request->post['callbackphone_position'];
		} else {
			$this->data['callbackphone_position'] = $this->config->get('callbackphone_position');
		}

		if (isset($this->request->post['callbackphone_status'])) {
			$this->data['callbackphone_status'] = $this->request->post['callbackphone_status'];
		} else {
			$this->data['callbackphone_status'] = $this->config->get('callbackphone_status');
		}

		$this->data['modules'] = array();

		if (isset($this->request->post['callbackphone_module'])) {
			$this->data['modules'] = $this->request->post['callbackphone_module'];
		} elseif ($this->config->get('callbackphone_module')) {
			$this->data['modules'] = $this->config->get('callbackphone_module');
		}

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template = 'module/callbackphone.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}
}
?>
<?php
class ControllerModuleBossProductcategory extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/boss_productcategory');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_productcategory', $this->request->post);	
			
			$this->cache->delete('boss_productcategory');
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_home'] = $this->language->get('text_home');	
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_root_category'] = $this->language->get('text_root_category');
		
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_use_scrolling_panel'] = $this->language->get('entry_use_scrolling_panel');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_category'] = $this->language->get('entry_category');
		
		$this->data['entry_get_products_from'] = $this->language->get('entry_get_products_from');
		
		$this->data['tab_add_tab'] = $this->language->get('tab_add_tab');
		$this->data['tab_popular_products'] = $this->language->get('tab_popular_products');
		$this->data['tab_special_products'] = $this->language->get('tab_special_products');
		$this->data['tab_best_seller_products'] = $this->language->get('tab_best_seller_products');
		$this->data['tab_latest_products'] = $this->language->get('tab_latest_products');
		$this->data['tab_choose_a_category'] = $this->language->get('tab_choose_a_category');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_clear_cache'] = $this->language->get('button_clear_cache');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_image'] = $this->language->get('button_add_image');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['numproduct'])) {
			$this->data['error_numproduct'] = $this->error['numproduct'];
		} else {
			$this->data['error_numproduct'] = array();
		}
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_productcategory', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/boss_productcategory', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
		//category
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		//module		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['boss_productcategory_module'])) {
			$this->data['modules'] = $this->request->post['boss_productcategory_module'];
		} elseif ($this->config->get('boss_productcategory_module')) { 
			$this->data['modules'] = $this->config->get('boss_productcategory_module');
		}	
		
		//image
		$this->load->model('tool/image');						

		//layout
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		//language
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/boss_productcategory.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_productcategory')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['boss_productcategory_module'])) {
			foreach ($this->request->post['boss_productcategory_module'] as $key => $value) {
				if (!$value['limit']) {
					$this->error['numproduct'][$key] = $this->language->get('error_numproduct');
				}
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}					
			}
			
		}
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
}
?>
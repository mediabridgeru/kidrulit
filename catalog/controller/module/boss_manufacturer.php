<?php  
class ControllerModuleBossManufacturer extends Controller {
	public function index($setting) {
	
		$this->language->load('module/boss_manufacturer');	
		$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		$this->data['template'] = $this->config->get('config_template');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['quick_select'] = $this->language->get('quick_select');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		
		if (isset($this->request->get['manufacturer_id'])) {
			$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
		} else {
			$this->data['manufacturer_id'] = 0;
		}
		
		$this->load->model('catalog/manufacturer');
		 
		$this->data['manufacturers'] = array();
		
		$results = $this->model_catalog_manufacturer->getManufacturers();
		
		foreach ($results as $result) {
			$this->data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'href'            => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_manufacturer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_manufacturer.tpl';
		} else {
			$this->template = 'default/template/module/boss_manufacturer.tpl';
		}
		
		$this->render(); 
	}
}
?>
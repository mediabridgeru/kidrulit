<?php  
class ControllerModuleBossQuickshop extends Controller {
	protected function index($setting) {
		
		$this->data['selecters'] = array();
		
		$this->data['selecters'] = explode(",", html_entity_decode($setting['array_class_selected'], ENT_QUOTES, 'UTF-8')); 
				
		if ($setting['text'][$this->config->get('config_language_id')]) {
			$this->data['text'] = $setting['text'][$this->config->get('config_language_id')];
		} else {
			$this->data['text'] = '';
		}
			
		$this->data['width'] =  $setting['width'];
				
		$this->data['seo_data'] = array();
		
		$this->load->model('catalog/product');
		
		$datas = $this->db->query("SELECT `query`, `keyword`  FROM `" . DB_PREFIX . "url_alias`");
		
		foreach ($datas->rows as $data) {
			if(preg_match("/product_id/i", $data['query'])){
				$this->data['seo_data'][]= array(
					'query' => $data['query'],
					'keyword' => $data['keyword']
				);
			}
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_quickshop.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_quickshop.tpl';
		} else {
			$this->template = 'default/template/module/boss_quickshop.tpl';
		}

		$this->render(); 
	}
}
?>
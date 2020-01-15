<?php
class ControllerModuleBlogarticles extends Controller {
    protected function index($setting) {
				
		static $module = 0;
		
		$this->language->load('module/blogarticles');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_more'] = $this->language->get('text_more');
		
		$this->load->model('bossblog/article');
		$this->load->model('tool/image');
		
		$tabs = $this->config->get('blogarticles_check');	
		$this->data['tabs'] = array();	
		
		if (isset($tabs)) {
			foreach($tabs as $tab){
				$article = array();
				$article = $this->model_bossblog_article->getArticle($tab);
						
				if ($article['image']) {
					$image = $this->model_tool_image->resize($article['image'], $setting['width'], $setting['height']);
				} else {
					$image = false;
				}
				
				$this->data['tabs'][] = array(
						'name'	 		=>	strip_tags(html_entity_decode($article['name'], ENT_QUOTES, 'UTF-8')),
						'thumb'       	=>  $image,
						'href'    		=>  $this->url->link('bossblog/article', 'blog_article_id=' . $tab),
				);
			}
		}
			
		$this->data['module'] = $module++; 
	   
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogarticles.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/blogarticles.tpl';
		} else {
			$this->template = 'default/template/module/blogarticles.tpl';
		}
		$this->render();
    }
}

?>
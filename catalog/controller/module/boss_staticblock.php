<?php  
class ControllerModuleBossStaticblock extends Controller {
	protected function index($setting) {

		$this->data['content'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_staticblock.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_staticblock.tpl';
		} else {
			$this->template = 'default/template/module/boss_staticblock.tpl';
		}
		
		$this->render();

	}
}
?>
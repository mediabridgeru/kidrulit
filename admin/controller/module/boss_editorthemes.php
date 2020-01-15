<?php
class ControllerModuleBossEditorthemes extends Controller {
	private $error = array(); 
	private $moduleName = 'boss_editorthemes';
	public function tabModules() {
		$this->data['elayout_default'] = 1;
		if( isset($this->request->get['elayout_id']) ){
			$this->data['elayout_default'] = $this->request->get['elayout_id'];	
		}
		$this->data['layout_modules'] = $this->getModules( $this->data['elayout_default'] );
	}
	
	public function getModules( $layout_id ){
		
		$this->load->model('bossthemes/boss_editorthemes');
		$extensions = $this->model_bossthemes_boss_editorthemes->getExtensions('module');		
		$module_data = array();
		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');
			$this->language->load('module/'.$extension['code']);	
			if ($modules) {
				foreach ($modules as $index => $module) {  
					if( $module['layout_id'] == $layout_id || $module['layout_id'] == 9999){
						$module_data[$module['position']][] = array(
							'title'      => ($this->language->get('heading_title')),
							'code'       => $extension['code'],
							'setting'    => $module,
							'sort_order' => $module['sort_order'],
							'status'     => $module['status'],
							'index'      => $index
						);				
					}
				}
			}
		}
		foreach( $module_data as $position => $modules ){
			$sort_order = array(); 
			foreach ($modules as $key => $value) {
			
				$sort_order[$key] = $value['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $module_data[$position]);
		}
		return $module_data;
		
		//
	}
	
	public function getLang( $key ){
		return $this->language->get( $key ); 
	}
	
	public function ajaxsave(){
		$this->load->model('setting/setting');
		if( isset($this->request->post['modules']) ){
			$modules = $this->request->post['modules'];
			
			foreach( $modules  as $position => $mods ){	
				echo $position."<br>";
				foreach( $mods as $index => $module ){
					$tmp = explode("-",$module);
					if( count($tmp)== 2 ){
						$code = $tmp[0];
						$modindex = $tmp[1];
						$data = array();
						$dbmods = $this->config->get( $code  . '_module');
						if( is_array($dbmods ) ) {
						
							foreach( $dbmods as $dbidx => $dbmod ){
								
								if( $dbidx == $modindex ){
									$dbmod['position'] = $position;
									$dbmod['sort_order'] = $index+1;
									$dbmods[$dbidx] = $dbmod ;
									break;
								}
							}
							$data = $this->model_setting_setting->getSetting( $code );
							if(  is_array($data) ){
								$data[$code."_module"] = $dbmods;
								$this->model_setting_setting->editSetting( $code, $data );	 
							}
						}
					}
				}
			}
		}
	}
	
	public function index() {   
		$this->language->load('module/boss_editorthemes');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_editorthemes', $this->request->post);	

			$this->cache->delete('boss_editorthemes');
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/boss_editorthemes', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['text_list'] = $this->language->get('text_list');
        $this->data['text_grid'] = $this->language->get('text_grid');
		$this->data['text_menu_default'] = $this->language->get('text_menu_default');
        $this->data['text_menu_mega'] = $this->language->get('text_menu_mega');
		$this->data['text_extra'] = $this->language->get('text_extra');
        $this->data['text_large'] = $this->language->get('text_large');
		$this->data['text_medium1'] = $this->language->get('text_medium1');
        $this->data['text_medium2'] = $this->language->get('text_medium2');
		$this->data['text_small'] = $this->language->get('text_small');
		$this->data['text_custom'] = $this->language->get('text_custom');
		$this->data['text_upload_image'] = $this->language->get('text_upload_image');
		$this->data['text_repeat'] = $this->language->get('text_repeat');
		$this->data['text_no_repeat'] = $this->language->get('text_no_repeat');
		$this->data['text_repeat_x'] = $this->language->get('text_repeat_x');
		$this->data['text_repeat_y'] = $this->language->get('text_repeat_y');
		$this->data['text_left_top'] = $this->language->get('text_left_top');
		$this->data['text_right_top'] = $this->language->get('text_right_top');
		$this->data['text_center_top'] = $this->language->get('text_center_top');
		$this->data['text_center_center'] = $this->language->get('text_center_center');
		$this->data['text_color'] = $this->language->get('text_color');
		$this->data['text_link_color'] = $this->language->get('text_link_color');
		$this->data['text_normal'] = $this->language->get('text_normal');
		$this->data['text_hover'] = $this->language->get('text_hover');
		$this->data['text_border_color'] = $this->language->get('text_border_color');
		$this->data['text_color_g_1'] = $this->language->get('text_color_g_1');
		$this->data['text_color_g_2'] = $this->language->get('text_color_g_2');
		$this->data['text_color_g_3'] = $this->language->get('text_color_g_3');
		$this->data['text_color_h_1'] = $this->language->get('text_color_h_1');
		$this->data['text_color_h_2'] = $this->language->get('text_color_h_2');
		$this->data['text_color_h_3'] = $this->language->get('text_color_h_3');
		$this->data['text_color_f_1'] = $this->language->get('text_color_f_1');
		$this->data['text_color_f_2'] = $this->language->get('text_color_f_2');
		$this->data['text_color_f_3'] = $this->language->get('text_color_f_3');
		$this->data['text_color_m_1'] = $this->language->get('text_color_m_1');
		$this->data['text_color_m_2'] = $this->language->get('text_color_m_2');
		$this->data['text_button_color'] = $this->language->get('text_button_color');
		$this->data['text_color_s_1'] = $this->language->get('text_color_s_1');
		$this->data['text_color_s_2'] = $this->language->get('text_color_s_2');
		$this->data['text_color_s_3'] = $this->language->get('text_color_s_3');
		$this->data['text_reset'] = $this->language->get('text_reset');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_font_style'] = $this->language->get('text_font_style');
		$this->data['text_font_size'] = $this->language->get('text_font_size');
		$this->data['text_font_weight'] = $this->language->get('text_font_weight');
		$this->data['text_transform'] = $this->language->get('text_transform');
		$this->data['text_test'] = $this->language->get('text_test');
		
		//entry
		$this->data['entry_show'] = $this->language->get('entry_show');
		$this->data['entry_modecss'] = $this->language->get('entry_modecss');
		$this->data['entry_modecss_set'] = $this->language->get('entry_modecss_set');
        $this->data['entry_box'] = $this->language->get('entry_box');
        $this->data['entry_wide'] = $this->language->get('entry_wide');
		$this->data['entry_respon_set'] = $this->language->get('entry_respon_set');
        $this->data['entry_respon_allow'] = $this->language->get('entry_respon_allow');
		$this->data['entry_product_set'] = $this->language->get('entry_product_set');
        $this->data['entry_product_allow'] = $this->language->get('entry_product_allow');
		$this->data['entry_menu_set'] = $this->language->get('entry_menu_set');
        $this->data['entry_menu_allow'] = $this->language->get('entry_menu_allow');
		$this->data['entry_layout_set'] = $this->language->get('entry_layout_set');
        $this->data['entry_product_view'] = $this->language->get('entry_product_view');
		$this->data['entry_template_set'] = $this->language->get('entry_template_set');
        $this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_g_color'] = $this->language->get('entry_g_color');
		$this->data['entry_back_color'] = $this->language->get('entry_back_color');
        $this->data['entry_back_image'] = $this->language->get('entry_back_image');
		$this->data['entry_repeat'] = $this->language->get('entry_repeat');
		$this->data['entry_position_image'] = $this->language->get('entry_position_image');
		$this->data['entry_h_color'] = $this->language->get('entry_h_color');
		$this->data['entry_f_color'] = $this->language->get('entry_f_color');
		$this->data['entry_m_color'] = $this->language->get('entry_m_color');
		$this->data['entry_back_color_drop'] = $this->language->get('entry_back_color_drop');
		$this->data['entry_back_image_drop'] = $this->language->get('entry_back_image_drop');
		$this->data['entry_s_color'] = $this->language->get('entry_s_color');
		$this->data['entry_p_color'] = $this->language->get('entry_p_color');
		$this->data['entry_p_name_color'] = $this->language->get('entry_p_name_color');
		$this->data['entry_p_des_color'] = $this->language->get('entry_p_des_color');
		$this->data['entry_p_price_color'] = $this->language->get('entry_p_price_color');
		$this->data['entry_p_text_price_color'] = $this->language->get('entry_p_text_price_color');
		$this->data['entry_p_spec_price_color'] = $this->language->get('entry_p_spec_price_color');
		$this->data['entry_p_text_spec_price_color'] = $this->language->get('entry_p_text_spec_price_color');
		$this->data['entry_p_button_color'] = $this->language->get('entry_p_button_color');
		$this->data['entry_p_text_button_color'] = $this->language->get('entry_p_text_button_color');
		$this->data['entry_t_color'] = $this->language->get('entry_t_color');
		$this->data['entry_t_page_color'] = $this->language->get('entry_t_page_color');
		$this->data['entry_t_block_color'] = $this->language->get('entry_t_block_color');
		$this->data['entry_t_bread_color'] = $this->language->get('entry_t_bread_color');
		$this->data['entry_t_bread_1_color'] = $this->language->get('entry_t_bread_1_color');
		$this->data['entry_t_bread_2_color'] = $this->language->get('entry_t_bread_2_color');
		$this->data['entry_g_font'] = $this->language->get('entry_g_font');
		$this->data['entry_h_font'] = $this->language->get('entry_h_font');
		$this->data['entry_h_font_1'] = $this->language->get('entry_h_font_1');
		$this->data['entry_h_font_2'] = $this->language->get('entry_h_font_2');
		$this->data['entry_f_font'] = $this->language->get('entry_f_font');
		$this->data['entry_f_font_1'] = $this->language->get('entry_f_font_1');
		$this->data['entry_f_font_2'] = $this->language->get('entry_f_font_2');
		$this->data['entry_m_font'] = $this->language->get('entry_m_font');
		$this->data['entry_m_font_1'] = $this->language->get('entry_m_font_1');
		$this->data['entry_m_font_2'] = $this->language->get('entry_m_font_2');
		$this->data['entry_s_font'] = $this->language->get('entry_s_font');
		$this->data['entry_s_font_1'] = $this->language->get('entry_s_font_1');
		$this->data['entry_s_font_2'] = $this->language->get('entry_s_font_2');
		$this->data['entry_p_font'] = $this->language->get('entry_p_font');
		$this->data['entry_p_font_name'] = $this->language->get('entry_p_font_name');
		$this->data['entry_p_font_des'] = $this->language->get('entry_p_font_des');
		$this->data['entry_p_font_price'] = $this->language->get('entry_p_font_price');
		$this->data['entry_p_font_cart'] = $this->language->get('entry_p_font_cart');
		$this->data['entry_t_font'] = $this->language->get('entry_t_font');
		$this->data['entry_t_font_page'] = $this->language->get('entry_t_font_page');
		$this->data['entry_t_font_block'] = $this->language->get('entry_t_font_block');
		$this->data['entry_t_font_bread'] = $this->language->get('entry_t_font_bread');
		$this->data['entry_custom_css'] = $this->language->get('entry_custom_css');
		$this->data['entry_custom_java'] = $this->language->get('entry_custom_java');
		
		//tab
		$this->data['tab_setting'] = $this->language->get('tab_setting');
		$this->data['tab_font'] = $this->language->get('tab_font');
		$this->data['tab_css'] = $this->language->get('tab_css');
		$this->data['tab_custom_css'] = $this->language->get('tab_custom_css');
		$this->data['tab_custom_java'] = $this->language->get('tab_custom_java');
		$this->data['tab_color'] = $this->language->get('tab_color');
		$this->data['tab_g_setting'] = $this->language->get('tab_g_setting');
		$this->data['tab_g_layout'] = $this->language->get('tab_g_layout');
		$this->data['tab_general_color'] = $this->language->get('tab_general_color');
		$this->data['tab_header_color'] = $this->language->get('tab_header_color');
		$this->data['tab_footer_color'] = $this->language->get('tab_footer_color');
		$this->data['tab_menu_color'] = $this->language->get('tab_menu_color');
		$this->data['tab_slide_color'] = $this->language->get('tab_slide_color');
		$this->data['tab_product_color'] = $this->language->get('tab_product_color');
		$this->data['tab_title_color'] = $this->language->get('tab_title_color');
		$this->data['tab_general_font'] = $this->language->get('tab_general_font');
		$this->data['tab_header_font'] = $this->language->get('tab_header_font');
		$this->data['tab_footer_font'] = $this->language->get('tab_footer_font');
		$this->data['tab_menu_font'] = $this->language->get('tab_menu_font');
		$this->data['tab_slide_font'] = $this->language->get('tab_slide_font');
		$this->data['tab_product_font'] = $this->language->get('tab_product_font');
		$this->data['tab_title_font'] = $this->language->get('tab_title_font');
		$this->data['tab_layout'] = $this->language->get('tab_layout');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
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
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_editorthemes', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['module'] = array(
						'block_footer_top'=>'',
						'block_footer_center' => '',
						'block_footer_bottom'=>''					
		);
		
		$this->data['action'] = $this->url->link('module/boss_editorthemes', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['ajax_modules_position'] = $this->url->link('module/'.$this->moduleName."/ajaxsave", 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('bossthemes/boss_editorthemes');
		
		$this->data['bg_images'] = $this->model_bossthemes_boss_editorthemes->getBackgrounds();
		
		$this->data['temp_setting_arr'] = $this->model_bossthemes_boss_editorthemes->getColorThemes();
        
        $this->data['temp_name_arr'] = $this->model_bossthemes_boss_editorthemes->getThemeNames();
        
        $colors_data = $this->data['temp_setting_arr'];
        
        $this->data['colors_data'] = json_encode($colors_data);
		
		$this->load->model('tool/image');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 50, 50);
		
		$this->data['b_Color_Data'] = array();
		
		if (isset($this->request->post['b_Color_Data'])) {
            $b_Color_Data = $this->request->post['b_Color_Data'];
		} elseif ($this->config->get('b_Color_Data')) { 
            $b_Color_Data = $this->config->get('b_Color_Data');
		} else{
			$b_Color_Data = '';
		}
		
		$this->data['b_Color_Data'] = $b_Color_Data;
		
		$this->data['b_Font_Data'] = array();
		
		if (isset($this->request->post['b_Font_Data'])) {
            $b_Font_Data = $this->request->post['b_Font_Data'];
		} elseif ($this->config->get('b_Font_Data')) { 
            $b_Font_Data = $this->config->get('b_Font_Data');
		} else{
			$b_Font_Data = '';
		}
		
		$this->data['b_Font_Data'] = $b_Font_Data;
		
		$this->data['b_Setting'] = array();
		
		if (isset($this->request->post['b_Setting'])) {
            $b_Setting = $this->request->post['b_Setting'];
		} elseif ($this->config->get('b_Setting')) { 
            $b_Setting = $this->config->get('b_Setting');
		} else{
			$b_Setting = '';
		}
		
		$this->data['b_Setting'] = $b_Setting;
		
		$this->data['customcode'] = array();
		
		if (isset($this->request->post['customcode'])) {
            $customcode = $this->request->post['customcode'];
		} elseif ($this->config->get('customcode')) { 
            $customcode = $this->config->get('customcode');
		} else{
			$customcode = '';
		}
		
		$this->data['customcode'] = $customcode;
		
		if (isset($this->request->post['b_General_Show'])) {
			$this->data['b_General_Show'] = $this->request->post['b_General_Show'];
		} else {
			$this->data['b_General_Show'] = $this->config->get('b_General_Show');
		}
		
		if (isset($this->request->post['b_Mode_CSS'])) {
			$this->data['b_Mode_CSS'] = $this->request->post['b_Mode_CSS'];
		} else {
			$this->data['b_Mode_CSS'] = $this->config->get('b_Mode_CSS');
		}
				
		if (isset($this->request->post['b_General_P_Display'])) {
			$this->data['b_General_P_Display'] = $this->request->post['b_General_P_Display'];
		} else {
			$this->data['b_General_P_Display'] = $this->config->get('b_General_P_Display');
		}
		
		if (isset($this->request->post['b_General_Menu'])) {
			$this->data['b_General_Menu'] = $this->request->post['b_General_Menu'];
		} else {
			$this->data['b_General_Menu'] = $this->config->get('b_General_Menu');
		}
		
		if (isset($this->request->post['b_Layout_Setting'])) {
			$this->data['b_Layout_Setting'] = $this->request->post['b_Layout_Setting'];
		} else {
			$this->data['b_Layout_Setting'] = $this->config->get('b_Layout_Setting');
		}
		
		if (isset($this->request->post['b_Layout_Setting'])) {
			$b_Layout_Settings = explode(',', $this->request->post['b_Layout_Setting']);
		} else {		
			$b_Layout_Settings = explode(',', $this->config->get('b_Layout_Setting'));
		}
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['boss_editorthemes_module'])) {
			$this->data['modules'] = $this->request->post['boss_editorthemes_module'];
		} elseif ($this->config->get('boss_editorthemes_module')) { 
			$this->data['modules'] = $this->config->get('boss_editorthemes_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->tabModules();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
						
		$this->template = 'module/boss_editorthemes.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_editorthemes')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install() {
        $data = array(
			'b_General_Show'  => 1,
            'b_General_P_Display'   =>'grid',
            'b_General_Menu'  =>1,
			'b_Mode_CSS' => 'wide',
			'b_Layout_Setting' => '6,24-18-12,6-8-12',
            'b_Setting'   => Array ('temp_setting' => 'custom' ),
			'b_Color_Data' => Array (
				'g_bg_image' => 'default',
				'g_upload_bg_image' => '',
				'g_bg_image_repeat' => 'repeat',
				'g_bg_image_position' => 'left top',
				'f_bg_image' => 'default',
				'f_upload_bg_image' => '',
				'f_bg_image_repeat' => 'repeat',
				'f_bg_image_position' => 'left top',
				'mdrop_bg_image' => 'default',
				'mdrop_upload_bg_image' => '',
				'menu_bg_image_repeat' => 'repeat',
				'menu_bg_image_position' => 'left top',
				'mdrop_bg_image_repeat' => 'repeat',
				'mdrop_bg_image_position' => 'left top' ),
				'boss_editorthemes_module' => array(0 => array ('layout_id' => 9999, 'position' => 'footer', 'status' => 1, 'sort_order' => 0))
        );
        
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->editSetting('boss_editorthemes', $data);
 	}
}
?>
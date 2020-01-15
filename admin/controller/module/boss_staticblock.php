<?php
class ControllerModuleBossStaticblock extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/boss_staticblock');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_staticblock', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/boss_staticblock', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_header'] = $this->language->get('text_header');
		$this->data['text_footer'] = $this->language->get('text_footer');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_all'] = $this->language->get('text_all');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_new_block'] = $this->language->get('button_add_new_block');
		
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		//tab
		$this->data['tab_content'] = $this->language->get('tab_content');
		$this->data['tab_header'] = $this->language->get('tab_header');
		$this->data['tab_footer'] = $this->language->get('tab_footer');
		$this->data['tab_header_top'] = $this->language->get('tab_header_top');
		$this->data['tab_header_bottom'] = $this->language->get('tab_header_bottom');
		$this->data['tab_footer_1'] = $this->language->get('tab_footer_1');
		$this->data['tab_footer_2'] = $this->language->get('tab_footer_2');
		$this->data['tab_footer_3'] = $this->language->get('tab_footer_3');
		$this->data['tab_footer_4'] = $this->language->get('tab_footer_4');
		
		$this->data['tab_block'] = $this->language->get('tab_block');
		
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
			'href'      => $this->url->link('module/boss_staticblock', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/boss_staticblock', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['b_Block_Header_Top'] = array();
		
		if (isset($this->request->post['b_Block_Header_Top'])) {
            $b_Block_Header_Top = $this->request->post['b_Block_Header_Top'];
		} elseif ($this->config->get('b_Block_Header_Top')) { 
            $b_Block_Header_Top = $this->config->get('b_Block_Header_Top');
		} else{
			$b_Block_Header_Top = '';
		}
		
		$this->data['b_Block_Header_Top'] = $b_Block_Header_Top;
		
		$this->data['b_Block_Header_Bottom'] = array();
		
		if (isset($this->request->post['b_Block_Header_Bottom'])) {
            $b_Block_Header_Bottom = $this->request->post['b_Block_Header_Bottom'];
		} elseif ($this->config->get('b_Block_Header_Bottom')) { 
            $b_Block_Header_Bottom = $this->config->get('b_Block_Header_Bottom');
		}else{
			$b_Block_Header_Bottom = '';
		}
		
		$this->data['b_Block_Header_Bottom'] = $b_Block_Header_Bottom;
		
		$this->data['b_Block_Footer_1'] = array();
		
		if (isset($this->request->post['b_Block_Footer_1'])) {
            $b_Block_Footer_1 = $this->request->post['b_Block_Footer_1'];
		} elseif ($this->config->get('b_Block_Footer_1')) { 
            $b_Block_Footer_1 = $this->config->get('b_Block_Footer_1');
		} else{
			$b_Block_Footer_1 = '';
		}
		
		$this->data['b_Block_Footer_1'] = $b_Block_Footer_1;
		
		$this->data['b_Block_Footer_2'] = array();
		
		if (isset($this->request->post['b_Block_Footer_2'])) {
            $b_Block_Footer_2 = $this->request->post['b_Block_Footer_2'];
		} elseif ($this->config->get('b_Block_Footer_2')) { 
            $b_Block_Footer_2 = $this->config->get('b_Block_Footer_2');
		}else{
			$b_Block_Footer_2 = '';
		}
		
		$this->data['b_Block_Footer_2'] = $b_Block_Footer_2;
		
		$this->data['b_Block_Footer_3'] = array();
		
		if (isset($this->request->post['b_Block_Footer_3'])) {
            $b_Block_Footer_3 = $this->request->post['b_Block_Footer_3'];
		} elseif ($this->config->get('b_Block_Footer_3')) { 
            $b_Block_Footer_3 = $this->config->get('b_Block_Footer_3');
		}else{
			$b_Block_Footer_3 = '';
		}
		
		$this->data['b_Block_Footer_3'] = $b_Block_Footer_3;
		$this->data['b_Block_Footer_4'] = array();
		
		if (isset($this->request->post['b_Block_Footer_4'])) {
            $b_Block_Footer_4 = $this->request->post['b_Block_Footer_4'];
		} elseif ($this->config->get('b_Block_Footer_4')) { 
            $b_Block_Footer_4= $this->config->get('b_Block_Footer_4');
		}else{
			$b_Block_Footer_4 = '';
		}
		
		$this->data['b_Block_Footer_4'] = $b_Block_Footer_4;
		
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['boss_staticblock_module'])) {
			$this->data['modules'] = $this->request->post['boss_staticblock_module'];
		} elseif ($this->config->get('boss_staticblock_module')) { 
			$this->data['modules'] = $this->config->get('boss_staticblock_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
						
		$this->template = 'module/boss_staticblock.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_staticblock')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	private function getIdLayout($layout_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE LOWER(name) = LOWER('".$layout_name."')");
		return (int)$query->row['layout_id'];
	}
	
	public function install(){
		$this->load->model('setting/setting');
		
		$this->load->model('localisation/language');
			
		$languages = $this->model_localisation_language->getLanguages();
		
		$array_description1 = array();
		$array_description2 = array();
		$array_description3 = array();
		$array_description4 = array();
		$array_description5 = array();
		$array_description6 = array();
		$array_description7 = array();
		
		$b_Block_Header_Top = array();
		$b_Block_Header_Bottom = array();
		$b_Block_Footer_1 = array();
		$b_Block_Footer_2 = array();
		$b_Block_Footer_3 = array();
		$b_Block_Footer_4 = array();
		
						
		foreach($languages as $language){
			$array_description1{$language['language_id']} = '&lt;div class=&quot;boss-static boss-home-deal not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;200&quot;&gt;
&lt;h1&gt;This Month\'s Activities&lt;/h1&gt;

&lt;p&gt;Displaying deals &amp;amp; promotions&lt;/p&gt;

&lt;ul&gt;
	&lt;li&gt;
	&lt;div&gt;&lt;img alt=&quot;November Sales&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_1.jpg&quot; title=&quot;November Sales&quot; /&gt;
	&lt;p&gt;Sed ut perspiciatis unde omnisito iste natus error sit&lt;/p&gt;
	&lt;a href=&quot;#&quot;&gt;Learn more&lt;/a&gt;&lt;/div&gt;
	&lt;/li&gt;
	&lt;li&gt;
	&lt;div&gt;&lt;img alt=&quot;Madagascar Figures&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_2.jpg&quot; title=&quot;Madagascar Figures&quot; /&gt;
	&lt;p&gt;Sed ut perspiciatis unde omnisito iste natus error sit&lt;/p&gt;
	&lt;a href=&quot;#&quot;&gt;Learn more&lt;/a&gt;&lt;/div&gt;
	&lt;/li&gt;
	&lt;li&gt;
	&lt;div&gt;&lt;img alt=&quot;Classic Cartoons&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_3.jpg&quot; title=&quot;Classic Cartoons&quot; /&gt;
	&lt;p&gt;Sed ut perspiciatis unde omnisito iste natus error sit&lt;/p&gt;
	&lt;a href=&quot;#&quot;&gt;Learn more&lt;/a&gt;&lt;/div&gt;
	&lt;/li&gt;
	&lt;li&gt;
	&lt;div&gt;&lt;img alt=&quot;November Sales&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_4.jpg&quot; title=&quot;November Sales&quot; /&gt;
	&lt;p&gt;Sed ut perspiciatis unde omnisito iste natus error sit&lt;/p&gt;
	&lt;a href=&quot;#&quot;&gt;Learn more&lt;/a&gt;&lt;/div&gt;
	&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;';
			$array_description2{$language['language_id']} = '&lt;div class=&quot;boss-banner-home not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;200&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Madagascar Figures&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_3.png&quot; title=&quot;Madagascar Figures&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description3{$language['language_id']} = '&lt;div class=&quot;boss-static boss-home-brands not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;300&quot;&gt;
&lt;h1&gt;Popular Brands&lt;/h1&gt;

&lt;p&gt;Displaying brands&amp;amp;sponsors&lt;/p&gt;

&lt;ul&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_img_1.png&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_img_2.png&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_img_3.png&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_img_4.png&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/static_img_5.png&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;a href=&quot;index.php?route=product/manufacturer&quot;&gt;View all brands&lt;/a&gt;&lt;/div&gt;';
			$array_description4{$language['language_id']} = '&lt;div class=&quot;boss-banner banner-category animated&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Advertising&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_categories.jpg&quot; title=&quot;Advertising&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description5{$language['language_id']} = '&lt;div class=&quot;boss-banner banner-account&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Contact&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_8.jpg&quot; title=&quot;Contact&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description6{$language['language_id']} = '&lt;div class=&quot;boss-banner animated&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Advertising&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_9.jpg&quot; title=&quot;Advertising&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description7{$language['language_id']} = '&lt;div class=&quot;boss-banner animated&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Advertising&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_9.jpg&quot; title=&quot;Advertising&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$b_Block_Header_Top{$language['language_id']} = '&lt;div class=&quot;boss-banner header-bottom-left&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Banner1&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_1.png&quot; title=&quot;Banner1&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$b_Block_Header_Bottom{$language['language_id']} = '&lt;div class=&quot;boss-banner header-bottom-right&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Banner2&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_2.png&quot; title=&quot;Banner2&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$b_Block_Footer_1{$language['language_id']} = '&lt;div class=&quot;boss-static-footer-banner not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;200&quot;&gt;
&lt;ul&gt;
	&lt;li class=&quot;col-xs-24 col-sm-8 col-md-8 col-lg-8&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_5.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li class=&quot;col-xs-24 col-sm-8 col-md-8 col-lg-8&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_6.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li class=&quot;col-xs-24 col-sm-8 col-md-8 col-lg-8&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/banner_7.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;';
			$b_Block_Footer_2{$language['language_id']} = '&lt;div class=&quot;boss-static-footer-2&quot;&gt;
&lt;div class=&quot;delivery not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;200&quot;&gt;
&lt;ul&gt;
	&lt;li&gt;&lt;img alt=&quot;Free Shipping&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/icon_block_1.png&quot; title=&quot;Free Shipping&quot; /&gt;&lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;cs-tooltip&quot; data-original-title=&quot;Free Shipping&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot;&gt;Free Shipping&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;img alt=&quot;Free Return&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/icon_block_2.png&quot; title=&quot;Free Return&quot; /&gt; &lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;cs-tooltip&quot; data-original-title=&quot;Free Return&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot;&gt;Free Return&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;img alt=&quot;Live Chat With Us&quot; class=&quot;pulse&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/icon_block_3.png&quot; title=&quot;Live Chat With Us&quot; /&gt; &lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;cs-tooltip&quot; data-original-title=&quot;Free Return&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot;&gt;Live Chat With Us&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;

&lt;div class=&quot;socialize not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;300&quot;&gt;
&lt;h3&gt;Socialize with us&lt;/h3&gt;

&lt;ul&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Facebook&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Facebook&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/face.png&quot; title=&quot;Facebook&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Twitter&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Twitter&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/twiter.png&quot; title=&quot;Twitter&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Pinterest&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Pinterest&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/pint.png&quot; title=&quot;Pinterest&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Google Plus&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Google&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/google.png&quot; title=&quot;Google Plus&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;Vimeo&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Vimeo&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/vimeo.png&quot; title=&quot;Vimeo&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;rss&quot; class=&quot;cs-tooltip pulse&quot; data-original-title=&quot;Rss&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/rss.png&quot; title=&quot;Rss&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;
&lt;/div&gt;';
			$b_Block_Footer_3{$language['language_id']} = '&lt;div class=&quot;boss-static-footer-logo&quot;&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;kidparadise&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;index.php?route=common/home&quot;&gt;&lt;img alt=&quot;Kidparadise&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/logo_bottom.png&quot; title=&quot;Kidparadise&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$b_Block_Footer_4{$language['language_id']} = '&lt;div class=&quot;boss-static-footer-payment&quot;&gt;
&lt;ul&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;Paypal&quot;&gt;&lt;img alt=&quot;Paypal&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal1.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;Visa&quot;&gt;&lt;img alt=&quot;Visa&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal2.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;American Express&quot;&gt;&lt;img alt=&quot;American Express&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal3.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;Master Card&quot;&gt;&lt;img alt=&quot;Master Card&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal4.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;DHL&quot;&gt;&lt;img alt=&quot;DHL&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal5.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a class=&quot;cs-tooltip&quot; data-original-title=&quot;Tooltip on top&quot; data-placement=&quot;top&quot; data-toggle=&quot;tooltip&quot; href=&quot;#&quot; title=&quot;FedEx&quot;&gt;&lt;img alt=&quot;FedEx&quot; src=&quot;http://demo.bossthemes.com/kidparadise_baby/image/data/bt_kidparadise_baby/paypal6.png&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;';
        }
		


		$data = array(
			'boss_staticblock_module' 	=> array(
				1 => array('description' => $array_description1, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 1),
				2 => array('description' => $array_description2, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 4),
				3 => array('description' => $array_description3, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 6),
				4 => array('description' => $array_description4, 'layout_id' => $this->getIdLayout("category"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 1),
				5 => array('description' => $array_description5, 'layout_id' => $this->getIdLayout("account"), 'store_id' => array(0=>0), 'position' => 'column_left', 'status' => 1, 'sort_order' => 2),
				6 => array('description' => $array_description6, 'layout_id' => $this->getIdLayout("category"), 'store_id' => array(0=>0), 'position' => 'column_left', 'status' => 1, 'sort_order' => 6),
				7 => array('description' => $array_description7, 'layout_id' => $this->getIdLayout("product"), 'store_id' => array(0=>0), 'position' => 'column_left', 'status' => 1, 'sort_order' => 6)
			),
			'b_Block_Header_Top'		=> array('content' => $b_Block_Header_Top, 'status' => 1, 'store_id' => array(0=>0)),
			'b_Block_Header_Bottom'		=> array('content' => $b_Block_Header_Bottom, 'status' => 1, 'store_id' => array(0=>0)),
			'b_Block_Footer_1'			=> array('content' => $b_Block_Footer_1, 'status' => 1, 'store_id' => array(0=>0)),
			'b_Block_Footer_2'			=> array('content' => $b_Block_Footer_2, 'status' => 1, 'store_id' => array(0=>0)),
			'b_Block_Footer_3'			=> array('content' => $b_Block_Footer_3, 'status' => 1, 'store_id' => array(0=>0)),
			'b_Block_Footer_4'			=> array('content' => $b_Block_Footer_4, 'status' => 1, 'store_id' => array(0=>0))
		);

		$this->model_setting_setting->editSetting('boss_staticblock', $data);		
	}
}
?>
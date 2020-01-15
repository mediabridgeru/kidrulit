<?php 
class ControllerModuleBosslogin extends Controller {
	public function index() {
		$this->language->load('module/boss_login');
				
		
		$this->data['text_login'] 		= $this->language->get('text_login');	

		$this->data['text_home'] 		= $this->language->get('text_home');
		$this->data['text_email'] 		= $this->language->get('text_email');
		$this->data['text_logout'] 		= $this->language->get('text_logout');
		
		$this->data['entry_password'] 	= $this->language->get('entry_password');
		$this->data['button_login'] 	= $this->language->get('button_login');
		
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['text_register'] 	= $this->language->get('text_register');
		$this->data['register']		=  $this->url->link('account/register', '', 'SSL');
		
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$this->data['forgotten']		=  $this->url->link('account/forgotten');
		$this->data['action_login'] 	= $this->url->link('account/login', '', 'SSL');
		$this->data['home'] 			= $this->url->link('common/home');		
		$this->data['account'] 			= $this->url->link('account/account', '', 'SSL');
		$this->data['text_account'] 	= $this->language->get('text_account');
		
		$this->data['shopping_cart'] 	= $this->url->link('checkout/cart');
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		
		$this->data['logout'] 			= $this->url->link('account/logout', '', 'SSL');
		$this->data['text_logout'] 		= $this->language->get('text_logout');


		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_login.tpl';
		} else {
			$this->template = 'default/template/module/boss_login.tpl';
		}
				
		$this->response->setOutput($this->render());		
	}
}
?>
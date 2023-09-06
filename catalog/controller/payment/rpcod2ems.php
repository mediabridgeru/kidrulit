<?php
class ControllerPaymentrpcod2ems extends Controller {
	public function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rpcod2ems.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/rpcod2ems.tpl';
		} else {
			$this->template = 'default/template/payment/rpcod2ems.tpl';
		}	
		
		$this->render();
	}
	
	public function confirm() 
	{
	
		if ($this->session->data['payment_method']['code'] == 'rpcod2ems') 
		{
			$this->load->model('checkout/order');
			
			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('rpcod2ems_order_status'));
		}
		
	}
}
?>
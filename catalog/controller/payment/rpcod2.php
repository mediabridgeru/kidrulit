<?php
class ControllerPaymentrpcod2 extends Controller {
	private $pre_text1 = 'Адрес ПВЗ: ';
	
	public function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/rpcod2.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/rpcod2.tpl';
		} else {
			$this->template = 'default/template/payment/rpcod2.tpl';
		}	
		
		$this->render();
	}
	
	public function confirm() 
	{
	
		if ($this->session->data['payment_method']['code'] == 'rpcod2') 
		{
			$this->load->model('checkout/order');
			
			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('rpcod2_order_status'));
		}
		
	}
	
	public function setPostcode()
	{
		$postcode = trim($this->request->post['postcode']);
		if( empty($postcode) || !preg_match("/^[0-9]{6}$/", $postcode) ) 
			exit( json_encode( array("listTypes" => array() ) ) );
		
		$this->load->model('shipping/russianpost2');
		$listtypes = $this->model_shipping_russianpost2->setRpPostcode($postcode);
		
		exit( json_encode( array("listTypes" => $listtypes ) ) );
	}
	
	public function setTerminal()
	{
		$this->load->model('shipping/russianpost2');
		
		$this->model_shipping_russianpost2->setTerminal(); 
	}
	
	public function clearAddressIfNoRp()
	{
		/*
		Array ( [old_address_2] => dom 29, kv 55 [old_address_1] => Ленина, дом 1 )
		*/
		if( !isset($this->session->data['russianpost2_data']) )
			$this->session->data['russianpost2_data'] = array();
		
		if( !empty( $this->request->post['shipping_address_1'] ) && 
			!strstr($this->request->post['shipping_address_1'], $this->pre_text1) 
		)
		{
			$this->session->data['russianpost2_data']['old_address_1'] = $this->request->post['shipping_address_1'];
		}
		elseif( !empty( $this->request->post['payment_address_1'] ) && 
			!strstr($this->request->post['payment_address_1'], $this->pre_text1) 
		)
		{
			$this->session->data['russianpost2_data']['old_address_1'] = $this->request->post['payment_address_1'];
		}
		
		if( !empty( $this->request->post['shipping_address_2'] ) && 
			!strstr($this->request->post['shipping_address_2'], $this->pre_text1) 
		)
		{
			$this->session->data['russianpost2_data']['old_address_2'] = $this->request->post['shipping_address_2'];
		}
		elseif( !empty( $this->request->post['payment_address_2'] ) && 
			!strstr($this->request->post['payment_address_2'], $this->pre_text1) 
		)
		{
			$this->session->data['russianpost2_data']['old_address_2'] = $this->request->post['payment_address_2'];
		}
		
		/*
		if( !empty( $this->request->post['comment'] ) && 
			!strstr($this->request->post['comment'], $this->pre_text1) 
		)
		{
			$this->session->data['russianpost2_data']['old_comment'] = $this->request->post['comment'];
		}
		*/
		
		// ---------
		
		$is_simple = !empty($this->session->data['simple']) ? 1 : 0;
		
		if( isset($this->session->data['shipping_address']['address_1']) &&
			(
				strstr($this->session->data['shipping_address']['address_1'], $this->pre_text1)  
			)
			
		)
		{
			$this->session->data['shipping_address']['address_1'] = '';
		}
		
		if( isset($this->session->data['shipping_address']['address_2']) &&
			(
				strstr( $this->session->data['shipping_address']['address_2'], $this->pre_text1 )  
			)
		)
			$this->session->data['shipping_address']['address_1'] = '';
		
		
		
		if( $is_simple && 
			isset($this->session->data['simple']['shipping_address']['address_1']) && 
			(
				strstr($this->session->data['simple']['shipping_address']['address_1'], $this->pre_text1)  
			)
		)
		{
			$this->session->data['simple']['shipping_address']['address_1'] = '';
		}
		
		if( $is_simple && 
			isset($this->session->data['simple']['shipping_address']['address_2']) && 
			(
				strstr($this->session->data['simple']['shipping_address']['address_2'], $this->pre_text1)  
			)
		)
		{
			$this->session->data['simple']['shipping_address']['address_2'] = '';
		}
		
		if( $is_simple && 
			isset($this->session->data['simple']['payment_address']['address_1']) && 
			(
				strstr($this->session->data['simple']['payment_address']['address_1'], $this->pre_text1)  
			)
		)
		{
			$this->session->data['simple']['payment_address']['address_1'] = '';
		}
		
		if( $is_simple && 
			isset($this->session->data['simple']['payment_address']['address_2']) && 
			(
				strstr($this->session->data['simple']['payment_address']['address_2'], $this->pre_text1)  
			)
		)
		{
			$this->session->data['simple']['payment_address']['address_2'] = '';
		}
		
		if( !empty($this->session->data['russianpost2_data']['old_address_1']) 
			&&  
			isset( $this->session->data['shipping_address']['address_1'] )
		)
			$this->session->data['shipping_address']['address_1'] = $this->session->data['russianpost2_data']['old_address_1'];
		
		if( !empty($this->session->data['russianpost2_data']['old_address_2'])  
			&&  
			isset( $this->session->data['shipping_address']['address_2'] )
		)
			$this->session->data['shipping_address']['address_2'] = $this->session->data['russianpost2_data']['old_address_2'];
		
		if( $is_simple && !empty($this->session->data['russianpost2_data']['old_address_1']) )
		{
			if( !empty($this->session->data['simple']['payment_address']) )
				$this->session->data['simple']['payment_address']['address_1'] = $this->session->data['russianpost2_data']['old_address_1'];
			
			if( !empty($this->session->data['simple']['shipping_address']) )
				$this->session->data['simple']['shipping_address']['address_1'] = $this->session->data['russianpost2_data']['old_address_1'];
		}
		
		if( $is_simple && !empty($this->session->data['russianpost2_data']['old_address_2']) )
		{
			if( !empty($this->session->data['simple']['payment_address']) )
				$this->session->data['simple']['payment_address']['address_2'] = $this->session->data['russianpost2_data']['old_address_2'];
			
			if( !empty($this->session->data['simple']['shipping_address']) )
				$this->session->data['simple']['shipping_address']['address_2'] = $this->session->data['russianpost2_data']['old_address_2'];
		}
		
		$json = array(
			"status" => 'OK', 
			"address_1" => isset( $this->session->data['russianpost2_data']['old_address_1'] ) ? $this->session->data['russianpost2_data']['old_address_1'] : '',
			"address_2" => isset( $this->session->data['russianpost2_data']['old_address_2'] ) ? $this->session->data['russianpost2_data']['old_address_2'] : '', 
			//"comment" => isset( $this->session->data['russianpost2_data']['old_comment'] ) ? $this->session->data['russianpost2_data']['old_comment'] : '',
		);
		
		exit( json_encode($json) );
	}
	
}
?>
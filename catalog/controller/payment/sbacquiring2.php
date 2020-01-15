<?php
class ControllerPaymentsbacquiring2 extends Controller {
	protected function index() {
		$this->load->model('checkout/order');
		$this->language->load('payment/sbacquiring2');
		$this->load->model('account/sbacquiring2');
		$this->data['instructionat'] = $this->config->get('sbacquiring2_instruction_attach');
		$this->data['btnlater'] = $this->config->get('sbacquiring2_button_later');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$action = $this->url->link('account/sbacquiring2/pay');
		$paymentredir = $action .
				'&paymentType=' . 'sbacquiring2' .
				'&order_id='	. $order_info['order_id'] . 
				'&code='        . substr($this->model_account_sbacquiring2->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8) .
				'&first=1';

		$online_url = $this->url->link('account/sbacquiring2', '', 'SSL') .
					'&order_id='	. $order_info['order_id'] . '&code=' . substr($this->model_account_sbacquiring2->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

	  	$this->data['continue'] = $this->url->link('checkout/success', '', 'SSL');

		$this->load->language('account/sbacquiring2');

		if ($this->config->get('sbacquiring2_fixen')) {
			if ($this->config->get('sbacquiring2_fixen') == 'fix'){
			    $out_summ = $this->config->get('sbacquiring2_fixen_amount');
			}
			else{
			    $out_summ = $order_info['total'] * $this->config->get('sbacquiring2_fixen_amount') / 100;
			}
		}
		else{
			$out_summ = $order_info['total'];
		}

		if ($this->config->get('sbacquiring2_createorder_or_notcreate')){
			if ($this->config->get('sbacquiring2_otlog') == 'stock'){
				if ($this->cart->hasStock()) {
					$this->data['notcreate'] = 'notcreate';
				}
			}
			else{
				$this->data['notcreate'] = 'notcreate';
			}
		}

		if ($this->config->get('sbacquiring2_otlog') == 'stock'){
			if ($this->cart->hasStock()) {
				$this->data['pay_url'] = $paymentredir;
			}
			else{
				$this->data['pay_url'] = $this->url->link('checkout/success');
			}

		}

		else if ($this->config->get('sbacquiring2_otlog') == 'pay'){
			$this->data['pay_url'] = $this->url->link('checkout/success');
		}

		else{
			$this->data['pay_url'] = $paymentredir;
		}

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['payment_url'] = $this->url->link('checkout/success');
		$this->data['button_later'] = $this->language->get('button_pay_later');

		if ($this->config->get('sbacquiring2_instruction_attach')){
			$this->data['text_instruction'] = $this->language->get('text_instruction');
			$this->data['sbacquiringi'] = $this->model_account_sbacquiring2->getCustomFields($order_info, $this->config->get('sbacquiring2_instruction_' . $this->config->get('config_language_id')));
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/sbacquiring2.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/sbacquiring2.tpl';
	    } else {
	            $this->template = 'default/template/payment/sbacquiring2.tpl';
	        }
	    
	    $this->render();
	}
	
	public function confirm() {
  		$comment = '';
  		$this->language->load('payment/sbacquiring2');
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
				$out_summ = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
				$inv_id = $this->session->data['order_id'];
		$this->load->model('account/sbacquiring2');
				$action= $order_info['store_url'] . 'index.php?route=account/sbacquiring2';
				$online_url = $action .

				'&order_id='	. $order_info['order_id'] . '&code=' . substr($this->model_account_sbacquiring2->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
		if ($this->config->get('sbacquiring2_otlog') == 'stock'){
			if ($this->cart->hasStock()) {
				$ostatus = $this->config->get('sbacquiring2_on_status_id');
				$comment = sprintf($this->language->get('stock'), $online_url);
			}
			else{
				$ostatus = $this->config->get('sbacquiring2_start_status_id');
				$comment = $this->language->get('no_stock');
			}

		}

		else if ($this->config->get('sbacquiring2_otlog') == 'pay'){
			$ostatus = $this->config->get('sbacquiring2_start_status_id');
		}

		else{
			$ostatus = $this->config->get('sbacquiring2_on_status_id');
		}

			if ($this->config->get('sbacquiring2_mail_instruction_attach')){

				$instroz = $this->model_account_sbacquiring2->getCustomFields($order_info, $this->config->get('sbacquiring2_mail_instruction_' . $this->config->get('config_language_id')));
		    	

		    	$comment1 = $instroz;
		    	$comment .= htmlspecialchars_decode($comment1);
		    	$this->model_checkout_order->confirm($this->session->data['order_id'], $ostatus, $comment, true);
	    	}
	    	else{
				$this->model_checkout_order->confirm($this->session->data['order_id'], $ostatus, $comment, true);
			}
	}
}
?>
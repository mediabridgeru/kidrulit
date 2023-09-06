<?php
class ControllerPaymentYandexurpb extends Controller {
	protected function index() {
		$this->load->model('checkout/order');
		$this->language->load('payment/yandexur_pb');
		$this->data['instructionat'] = $this->config->get('yandexur_pb_instruction_attach');
		$this->data['btnlater'] = $this->config->get('yandexur_pb_button_later');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$this->load->model('account/yandexur');
		$action = $this->url->link('account/yandexur/pay');
		$paymentredir = $action .
				'&paymentType=' . 'yandexur_pb' .
				'&order_id='	. $order_info['order_id'] . 
				'&code='        . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8) .
				'&first=1';

		$online_url = $this->url->link('account/yandexur') .
					'&order_id='	. $order_info['order_id'];

	  	$this->data['continue'] = $this->url->link('checkout/success');

		$this->load->language('account/yandexur_pb');

		if ($this->config->get('yandexur_pb_fixen')) {
			if ($this->config->get('yandexur_pb_fixen') == 'fix'){
			    $out_summ = $this->config->get('yandexur_pb_fixen_amount');
			}
			else{
			    $out_summ = $order_info['total'] * $this->config->get('yandexur_pb_fixen_amount') / 100;
			}
		}
		else{
			$out_summ = $order_info['total'];
		}

		
		if ($this->config->get('yandexur_pb_createorder_or_notcreate')){
			if ($this->config->get('yandexur_pb_otlog') == 'stock'){
				if ($this->cart->hasStock()) {
					$this->data['notcreate'] = 'notcreate';
				}
			}
			else{
				$this->data['notcreate'] = 'notcreate';
			}
		}

		if ($this->config->get('yandexur_pb_otlog') == 'stock'){
			if ($this->cart->hasStock()) {
				$this->data['pay_url'] = $paymentredir;
			}
			else{
				$this->data['pay_url'] = $this->url->link('checkout/success');
			}

		}

		else if ($this->config->get('yandexur_pb_otlog') == 'pay'){
			$this->data['pay_url'] = $this->url->link('checkout/success');
		}

		else{
			$this->data['pay_url'] = $paymentredir;
		}
		
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['payment_url'] = $this->url->link('checkout/success');
		$this->data['button_later'] = $this->language->get('button_pay_later');

		if ($this->config->get('yandexur_pb_instruction_attach')){
			$this->data['text_instruction'] = $this->language->get('text_instruction');

			$instros = explode('$', ($this->config->get('yandexur_pb_instruction_' . $this->config->get('config_language_id'))));
			$instroz = "";
			foreach ($instros as $instro) {
				if ($instro == 'href' || $instro == 'orderid' ||  $instro == 'itogo' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
				    if ($instro == 'href'){
				        $instro_other = $online_url;
				    }
				    if ($instro == 'orderid'){
				        $instro_other = $order_info['order_id'];
					}
					if ($instro == 'itogo'){
					    $instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);
					}
					if ($instro == 'komis'){
						if($this->config->get('yandexur_pb_komis')){
					    	$instro_other = $this->config->get('yandexur_pb_komis') . '%';
						}
						else{$instro_other = '';}
					}
					if ($instro == 'total-komis'){
						if($this->config->get('yandexur_pb_komis')){
					    	$instro_other = $this->currency->format($order_info['total'] * $this->config->get('yandexur_pb_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
						}
						else{$instro_other = '';}
					}
					if ($instro == 'plus-komis'){
						if($this->config->get('yandexur_pb_komis')){
					    	$instro_other = $this->currency->format($order_info['total'] + ($order_info['total'] * $this->config->get('yandexur_pb_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
						}
						else{$instro_other = '';}
					}
				}
				else {
				    $instro_other = htmlspecialchars_decode($instro);
				}
				    $instroz .=  $instro_other;
			}
				$this->data['yandexur_pbi'] = $instroz;
		}
		
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandexur_pb.tpl')) {
	      $this->template = $this->config->get('config_template') . '/template/payment/yandexur_pb.tpl';
	    } else {
	      $this->template = 'default/template/payment/yandexur_pb.tpl';
	    }

	    $this->render();
        
	}
	
	public function confirm() {
		$comment = '';
  		$this->language->load('payment/yandexur_pb');
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
				$out_summ = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
				$inv_id = $this->session->data['order_id'];
		$this->load->model('account/yandexur');
				$action= $order_info['store_url'] . 'index.php?route=account/yandexur';
				$online_url = $action .

				'&order_id='	. $order_info['order_id'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
		if ($this->config->get('yandexur_pb_otlog') == 'stock'){
			if ($this->cart->hasStock()) {
				$ostatus = $this->config->get('yandexur_pb_on_status_id');
				$comment = sprintf($this->language->get('stock'), $online_url);
			}
			else{
				$ostatus = $this->config->get('yandexur_pb_start_status_id');
				$comment = $this->language->get('no_stock');
			}

		}

		else if ($this->config->get('yandexur_pb_otlog') == 'pay'){
			$ostatus = $this->config->get('yandexur_pb_start_status_id');
		}

		else{
			$ostatus = $this->config->get('yandexur_pb_on_status_id');
		}
		
			if ($this->config->get('yandexur_pb_mail_instruction_attach')){
				
		    	$instros = explode('$', ($this->config->get('yandexur_pb_mail_instruction_' . $this->config->get('config_language_id'))));
				      $instroz = "";
				      foreach ($instros as $instro) {
				      	if ($instro == 'href' || $instro == 'orderid' ||  $instro == 'itogo' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
				      		if ($instro == 'href'){
				            	$instro_other = $online_url;
				        	}
				            if ($instro == 'orderid'){
				            	$instro_other = $inv_id;
					       	}
					       	if ($instro == 'itogo'){
					            $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
					       	}
					       	if ($instro == 'komis'){
								if($this->config->get('yandexur_pb_komis')){
							    	$instro_other = $this->config->get('yandexur_pb_komis') . '%';
								}
								else{$instro_other = '';}
							}
							if ($instro == 'total-komis'){
								if($this->config->get('yandexur_pb_komis')){
							    	$instro_other = $this->currency->format($order_info['total'] * $this->config->get('yandexur_pb_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
								}
								else{$instro_other = '';}
							}
							if ($instro == 'plus-komis'){
								if($this->config->get('yandexur_pb_komis')){
							    	$instro_other = $this->currency->format($order_info['total'] + ($order_info['total'] * $this->config->get('yandexur_pb_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
								}
								else{$instro_other = '';}
							}
				       	}
				       	else {
				       		$instro_other = $instro;
				       	}
				       	$instroz .=  $instro_other;
				      }
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
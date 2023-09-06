<?php
class ControllerPaymentYandexurmp extends Controller {
	protected function index() {
		$this->load->model('checkout/order');
		$this->language->load('payment/yandexur_mp');
		$this->data['instructionat'] = $this->config->get('yandexur_mp_instruction_attach');
		$this->data['btnlater'] = $this->config->get('yandexur_mp_button_later');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$this->load->model('account/yandexur');
		$action = $this->url->link('account/yandexur/pay');

	  	$this->data['continue'] = $this->url->link('checkout/success');

		$this->load->language('account/yandexur_mp');

		if ($this->config->get('yandexur_mp_fixen')) {
			if ($this->config->get('yandexur_mp_fixen') == 'fix'){
			    $out_summ = $this->config->get('yandexur_mp_fixen_amount');
			}
			else{
			    $out_summ = $order_info['total'] * $this->config->get('yandexur_mp_fixen_amount') / 100;
			}
		}
		else{
			$out_summ = $order_info['total'];
		}

		
		if ($this->config->get('yandexur_mp_createorder_or_notcreate')) {
			$this->data['notcreate'] = 'notcreate';
		}

		if ($this->config->get('yandexur_mp_returnpage')){
	        $this->data['pay_url'] = $this->url->link('checkout/success');
	    }
	    else {
	        $this->data['pay_url'] = $this->url->link('account/yandexur/success&first=1&order='.$order_info['order_id']);
	    }

		
		
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['payment_url'] = $this->url->link('checkout/success');
		$this->data['button_later'] = $this->language->get('button_pay_later');

		if ($this->config->get('yandexur_mp_instruction_attach')){
			$this->data['text_instruction'] = $this->language->get('text_instruction');

			$instros = explode('$', ($this->config->get('yandexur_mp_instruction_' . $this->config->get('config_language_id'))));
			$instroz = "";
			foreach ($instros as $instro) {
				if ($instro == 'orderid' ||  $instro == 'itogo' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){

				    if ($instro == 'orderid'){
				        $instro_other = $order_info['order_id'];
					}
					if ($instro == 'itogo'){
					    $instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);
					}
					if ($instro == 'komis'){
						if($this->config->get('yandexur_mp_komis')){
					    	$instro_other = $this->config->get('yandexur_mp_komis') . '%';
						}
						else{$instro_other = '';}
					}
					if ($instro == 'total-komis'){
						if($this->config->get('yandexur_mp_komis')){
					    	$instro_other = $this->currency->format($order_info['total'] * $this->config->get('yandexur_mp_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
						}
						else{$instro_other = '';}
					}
					if ($instro == 'plus-komis'){
						if($this->config->get('yandexur_mp_komis')){
					    	$instro_other = $this->currency->format($order_info['total'] + ($order_info['total'] * $this->config->get('yandexur_mp_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
						}
						else{$instro_other = '';}
					}
				}
				else {
				    $instro_other = htmlspecialchars_decode($instro);
				}
				    $instroz .=  $instro_other;
			}
				$this->data['yandexur_mpi'] = $instroz;
		}
		
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/yandexur_mp.tpl')) {
	      $this->template = $this->config->get('config_template') . '/template/payment/yandexur_mp.tpl';
	    } else {
	      $this->template = 'default/template/payment/yandexur_mp.tpl';
	    }

	    $this->render();
        
	}
	
	public function confirm() {
  		$this->language->load('payment/yandexur_mp');
		$this->load->model('checkout/order');
		$ostatus = $this->config->get('yandexur_mp_on_status_id');
		
			if ($this->config->get('yandexur_mp_mail_instruction_attach')){
				$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
				$out_summ = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
				$inv_id = $this->session->data['order_id'];
				$this->load->model('account/yandexur');
				$action= $order_info['store_url'] . 'index.php?route=account/yandexur';

		    	$instros = explode('$', ($this->config->get('yandexur_mp_mail_instruction_' . $this->config->get('config_language_id'))));
				      $instroz = "";
				      foreach ($instros as $instro) {
				      	if ($instro == 'orderid' ||  $instro == 'itogo' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
				      		
				            if ($instro == 'orderid'){
				            	$instro_other = $inv_id;
					       	}
					       	if ($instro == 'itogo'){
					            $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
					       	}
					       	if ($instro == 'komis'){
								if($this->config->get('yandexur_mp_komis')){
							    	$instro_other = $this->config->get('yandexur_mp_komis') . '%';
								}
								else{$instro_other = '';}
							}
							if ($instro == 'total-komis'){
								if($this->config->get('yandexur_mp_komis')){
							    	$instro_other = $this->currency->format($order_info['total'] * $this->config->get('yandexur_mp_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
								}
								else{$instro_other = '';}
							}
							if ($instro == 'plus-komis'){
								if($this->config->get('yandexur_mp_komis')){
							    	$instro_other = $this->currency->format($order_info['total'] + ($order_info['total'] * $this->config->get('yandexur_mp_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
								}
								else{$instro_other = '';}
							}
				       	}
				       	else {
				       		$instro_other = $instro;
				       	}
				       	$instroz .=  $instro_other;
				      }
				$comment = $instroz;
		    	$comment = htmlspecialchars_decode($comment);
		    	$this->model_checkout_order->confirm($this->session->data['order_id'], $ostatus, $comment, true);
	    	}
	    	else{
				$this->model_checkout_order->confirm($this->session->data['order_id'], $ostatus, '', true);
			}
	}
}
?>
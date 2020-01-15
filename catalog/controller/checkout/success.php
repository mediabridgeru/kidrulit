<?php
class ControllerCheckoutSuccess extends Controller { 
	public function index() { 	
	
		if ( isset($this->session->data['order_id']) && ( ! empty($this->session->data['order_id']))  ) {
			$this->session->data['last_order_id'] = $this->session->data['order_id'];
		}

        $this->data['docs'] = 0;

		if (isset($this->session->data['order_id'])) {

// added


	        $this->data['do_hidesbrf_card'] = 1;
	        //if ( $this->customer->isLogged() ) {
	        	$this->load->model('account/order');
	            $scd_tmp = $this->model_account_order->getOrderScd(1, $this->session->data['order_id']);

				$scd = unserialize($scd_tmp[0]['data']);
	            if(!empty($scd['custom_customer_type']['value'])) {
	            	if($scd['custom_customer_type']['value'] != 'individual' && $this->customer->getCustomerGroupId() == 2) {
						$this->data['do_hidesbrf_card'] = 1; 
	            	} else {
	            		$this->data['do_hidesbrf_card'] = 0;
	            	}
	            }        	            	            	            
	        //}

// 


            $this->data['order_id'] = $order_id = $this->session->data['order_id'];

            $codes = array('bank_transfer', 'bank_transfer2'); // коды оплат, для которых надо вывести акты и накладную

            if (isset($this->session->data['payment_method']['code']) && in_array($this->session->data['payment_method']['code'], $codes)) {
                $this->data['docs'] = 1;
                $this->data['invoice'] = $this->url->link('sale/order/invoice', 'excel=1&order_id='.$order_id, 'SSL');
                //$this->data['torg12'] = $this->url->link('sale/order/invoice', 'doctype=torg12&order_id='.$order_id, 'SSL');
                $this->data['torg12'] = $this->url->link('sale/waybill/index', 'doctype=torg12&order_id='.$order_id, 'SSL');
                $this->data['delivery_act'] = $this->url->link('sale/order/invoice', 'doctype=akt&order_id='.$order_id, 'SSL');

                $this->data['html_invoice'] = $this->url->link('sale/order/invoice', 'html=1&order_id='.$order_id, 'SSL');
                $this->data['html_torg12'] = $this->url->link('sale/order/invoice', 'doctype=torg12&order_id='.$order_id, 'SSL');
                $this->data['html_btn'] = '<br /><br /><h3>Если Вы передумали и решили оплатить свой заказ банковской картой, то Вы можете нажать на кнопку далее:</h3>';
                $this->data['html_btn'] .= '<br /><div class="sbacquiring"><a href="'.$this->url->link('account/sbacquiring/change', 'code=' . $order_id . '&order_id=' . $order_id, 'SSL').'"><img src="https://kidrulit.ru/image/banners/card650.jpg"></a></div>';
            }

            $this->cart->clear();

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        } else {
            $this->data['order_id'] = 0;
            $this->data['invoice'] = '/';
            $this->data['torg12'] = '/';
            $this->data['delivery_act'] = '/';
            $this->data['html_invoice'] = '/';
            $this->data['html_torg12'] = '/';
        }

		$this->language->load('checkout/success');

		if (! empty($this->session->data['last_order_id']) ) {
			$this->document->setTitle(sprintf($this->language->get('heading_title_customer'), $this->session->data['last_order_id']));
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/cart'),
			'text'      => $this->language->get('text_basket'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/success'),
			'text'      => $this->language->get('text_success'),
			'separator' => $this->language->get('text_separator')
		);

		if (! empty($this->session->data['last_order_id']) ) {
			$this->data['heading_title'] = sprintf($this->language->get('heading_title_customer'), $this->session->data['last_order_id']);
		} else {
			$this->data['heading_title'] = $this->language->get('heading_title');
		}
		
		if ($this->customer->isLogged()) {
			$this->data['text_message'] = sprintf(
                $this->language->get('text_customer'),
                $this->url->link('account/order/info&order_id=' . $this->session->data['last_order_id'], '', 'SSL'),
                $this->url->link('account/account', '', 'SSL'),
                $this->url->link('account/order', '', 'SSL'),
                $this->url->link('information/contact'),
                $this->url->link('product/special'),
                $this->session->data['last_order_id']
            );
		} else {
            if (! empty($this->session->data['last_order_id']) ) {
                $this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'), $this->session->data['last_order_id']);
            } else {
                $this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
            }
		}

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'			
		);

		$this->response->setOutput($this->render());
	}
}
?>
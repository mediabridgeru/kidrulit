<?php
class ControllerAccountyandexur extends Controller {
    private $error = array();
    public function index() {

      $this->load->model('account/yandexur');
      $yu_codes = $this->model_account_yandexur->getPayMethods();

      if (isset($this->request->get['code']) & isset($this->request->get['order_id'])){
        $inv_id = $this->request->get['order_id'];
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($inv_id);
        $platp = substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
        if ($this->request->get['code'] != $platp) {
        	$this->redirect($this->url->link('error/not_found'));
        }
        if ($order_info['order_id'] == 0){$this->redirect($this->url->link('error/not_found'));}
        if (!$this->customer->isLogged()) {
          $this->data['back'] = $this->url->link('common/home');
        }
        else{
          $this->data['back'] = $this->url->link('account/order');
        }
	      $action = $this->url->link('account/yandexur/pay');
    
    		$this->data['merchant_url'] = $action .

							'&order_id=' 		. $inv_id .
              '&paymentType=' . $order_info['payment_code'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

        $this->load->model('account/yandexur');
        $paystat = $this->model_account_yandexur->getPaymentStatus($inv_id);
        if (!isset($paystat['status'])){$paystat['status'] = 0;}

        $this->data['paystat'] = $paystat['status'];
        $this->load->language('account/'.$order_info['payment_code']);
        $this->data['button_pay'] = $this->language->get('button_pay');
		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['heading_title'] = $this->language->get('heading_title');
    $this->document->setTitle($this->language->get('heading_title'));

        if ($paystat['status'] != 1){

        	if (!in_array($order_info['payment_code'], $yu_codes)) {
		    	$this->redirect($this->url->link('error/not_found'));
		    }

	        	if ($this->config->get($order_info['payment_code'].'_fixen')) {
					if ($this->config->get($order_info['payment_code'].'_fixen') == 'fix'){
					    $out_summ = $this->config->get($order_info['payment_code'].'_fixen_amount');
					}
					else{
					    $out_summ = $order_info['total'] * $this->config->get($order_info['payment_code'].'_fixen_amount') / 100;
					}
				}
				else{
					$out_summ = $order_info['total'];
				}
		        if ($this->config->get($order_info['payment_code'].'_hrefpage_text_attach')) {
		          $this->data['hrefpage_text'] = '';

		          $instros = explode('$', ($this->config->get($order_info['payment_code'].'_hrefpage_text_' . $this->config->get('config_language_id'))));
		                  $instroz = "";
		                  foreach ($instros as $instro) {
		                    if ($instro == 'orderid' ||  $instro == 'itogo' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
		                      
		                        if ($instro == 'orderid'){
		                            $instro_other = $order_info['order_id'];
		                      }
		                      if ($instro == 'itogo'){
		                          $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
		                      }
		                      if ($instro == 'komis'){
		                        if($this->config->get($order_info['payment_code'].'_komis')){
		                            $instro_other = $this->config->get($order_info['payment_code'].'_komis') . '%';
		                        }
		                        else{$instro_other = '';}
		                      }
		                      if ($instro == 'total-komis'){
		                        if($this->config->get($order_info['payment_code'].'_komis')){
		                            $instro_other = $this->currency->format($out_summ * $this->config->get($order_info['payment_code'].'_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
		                        }
		                        else{$instro_other = '';}
		                      }
		                      if ($instro == 'plus-komis'){
		                        if($this->config->get($order_info['payment_code'].'_komis')){
		                            $instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($order_info['payment_code'].'_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
		                        }
		                        else{$instro_other = '';}
		                      }
		                    }
		                    else {
		                      $instro_other = nl2br(htmlspecialchars_decode($instro));
		                    }
		                    $instroz .=  $instro_other;
		                  }

		          $this->data['hrefpage_text'] .= $instroz;
		        }
		        else{        
		        $this->data['send_text'] = $this->language->get('send_text');
		        $this->data['send_text2'] = $this->language->get('send_text2');
		        $this->data['inv_id'] = $inv_id;
		        $this->data['out_summ'] = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
		        }
		}
		else{
			$this->data['hrefpage_text'] = $this->language->get('oplachen');
		}


    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .
           '/template/account/yandexur.tpl')) {

            $this->template = $this->config->get('config_template') .
              '/template/account/yandexur.tpl';
        } else {
            $this->template = 'default/template/account/yandexur.tpl';
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
      else{
        echo "No data";
      }
  }

  public function pay() {
  	if (isset($this->request->get['code']) & isset($this->request->get['order_id'])){

  	  if (isset($this->session->data['order_id'])){
  	  	$sesionord = $this->session->data['order_id'];
  	  }
  	  else{
  	  	$sesionord = '';
  	  }

  	  $this->load->model('account/yandexur');
      $yu_codes = $this->model_account_yandexur->getPayMethods();
      
      
      if (in_array($this->request->get['paymentType'], $yu_codes)) {

      	$codeforpay = $this->request->get['paymentType'];

      	$this->load->model('checkout/order');
      	$order_info = $this->model_checkout_order->getOrder($this->request->get['order_id']);
        
        $data['paymentType'] = $this->config->get($codeforpay.'_methodcode');
        $data['ShopID'] = $this->config->get($codeforpay.'_shopId');
        $data['scid'] = $this->config->get($codeforpay.'_scid');
        if ($this->config->get($codeforpay.'_yadserver')){
        	$data['yadserver'] = 'https://money.yandex.ru/eshop.xml';
    	}
    	else{
    		$data['yadserver'] = 'https://demomoney.yandex.ru/eshop.xml';
    	}
      if ($this->config->get($codeforpay.'_returnpage')){
        $data['shopSuccessURL'] = $this->url->link('checkout/success');
        $data['shopFailURL'] = $this->url->link('checkout/failure');
      }
      else{
        $data['shopSuccessURL'] = $this->url->link('account/yandexur/success');
        $data['shopFailURL'] = $this->url->link('account/yandexur/fail');
      }
        $this->language->load('account/'.$codeforpay);
        if ($this->config->get('config_store_id') == 0){
        	$store_name = $this->config->get('config_name');
        }
        else{
        	$this->load->model('setting/store');
			$stores = $this->model_setting_store->getStores();
			foreach ($stores as $store) {
				if ($this->config->get('config_store_id') == $store['store_id']){
					$store_name = $store['name'];
				}
			}
        }

        $data['order_text'] = $this->language->get('pay_order_text_target') . ' ' . $order_info['order_id'];
        //$this->data['order_text'] = str_replace("'", "", $store_name) . ': ' . $this->language->get('pay_order_text_target') . ' ' . $order_info['order_id'];

        if ($this->config->get($codeforpay.'_komis')) {
        	$proc=$this->config->get($codeforpay.'_komis');
        }
        if ($this->config->get($codeforpay.'_fixen')) {
			if ($this->config->get($codeforpay.'_fixen') == 'fix'){
				$out_summ = $this->config->get($codeforpay.'_fixen_amount');
			}
			else{
				$out_summ = $order_info['total'] * $this->config->get($codeforpay.'_fixen_amount') / 100;
			}
		}
		else {
			$out_summ = $order_info['total'];
		}

		if(!$this->config->get($codeforpay.'_createorder_or_notcreate')){
	          if (isset($this->session->data['order_id'])){
		        if ($this->request->get['order_id'] == $this->session->data['order_id']){
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
		        }
		      }
		  }
      }
      else{
        echo 'error: no payment method';
        exit();
      }
      
      if (is_numeric($out_summ)){
        if ($this->currency->has('RUB')){
          $totalrub = $out_summ;
          if (isset($proc)) {
            $data['total'] = $totalcheck = $this->currency->format(($totalrub*$proc/100)+$totalrub, 'RUB', $this->currency->getValue('RUB'), false);
          }
          else {
            $data['total'] = $totalcheck = $this->currency->format($totalrub, 'RUB', $this->currency->getValue('RUB'), false);
          }
        }
        else{echo 'No currency RUB'; exit();}
      }
      else{
        echo 'error: no total sum';
        exit();
      }

      if (is_numeric($this->request->get['order_id'])){
        $data['order_id'] = $this->request->get['order_id'];
      }
      else{
        echo 'error: no order id';
        exit();
      }

      // CHECKS ONLINE SERVICE START
		  if (!$this->config->get($codeforpay.'_cart')) {


        if ($this->config->get($codeforpay . '_protokol')) {
          $fzpaymentSubject = 'paymentSubjectType';
          $fzpaymentMode = 'paymentMethodType';
        }
        else{

          $fzpaymentSubject = 'payment_subject';
          $fzpaymentMode = 'payment_mode';

        }

		  	if ($order_info['email'] != ''){
          if (!strpos($order_info['email'], '@localhost.net')){
		  		  $ccont = $order_info['email'];
          }
          else{
            $ccont = "+" . preg_replace('/[^0-9]/', '', $order_info['telephone']);
          }
		  	}
		  	else{
		  		$ccont = "+" . preg_replace('/[^0-9]/', '', $order_info['telephone']);
		  	}
            $okassa = array(
                'customerContact' => $ccont,
                'items' => array(),
            );

            if ($this->config->get($codeforpay.'_customShip') != '') {

              $order_info['shipping_method'] = $this->config->get($codeforpay.'_customShip');

            }

            if ($this->config->get($codeforpay.'_customName')) {

              $customname =  $this->config->get($codeforpay.'_customName');

            }

            $payment_mode_default = $this->config->get($codeforpay . '_payment_mode_default');
            $payment_mode_source = false;
            if ($this->config->get($codeforpay . '_payment_mode_source') != 'default') {
              $payment_mode_source = $this->config->get($codeforpay . '_payment_mode_source');
            }

            $payment_subject_default = $this->config->get($codeforpay . '_payment_subject_default');
            $payment_subject_source = false;
            if ($this->config->get($codeforpay . '_payment_subject_source') != 'default') {
              $payment_subject_source = $this->config->get($codeforpay . '_payment_subject_source');
            }

            $this->load->model('account/order');
            $cart_products = $this->model_account_order->getOrderProducts($order_info['order_id']);

            //vouchers
            $vouchersbuy = $this->model_account_order->getOrderVouchers($order_info['order_id']);
            foreach ($vouchersbuy as $voucherbuy) {
                    $cart_products[] = array(
                        'quantity' => 1,
                        'name' => $voucherbuy['description'],
                        'price' => $voucherbuy['amount'],
                        'product_id' => 0
                    );
                
            }
            //vouchers end          

            $totals = $this->model_account_order->getOrderTotals($order_info['order_id']);
			  $tax = 0;
			  $voucher = 0;
			  $shipping = 0;
			  $subtotal = 0;
			  $coupon = 0;
			  foreach($totals as $total) {
				  switch($total['code']){
					 case 'tax':$tax = $total['value'];break;
					 case 'shipping': $shipping = $total['value'];break;
					 case 'sub_total': $subtotal = $total['value'];break;
					 case 'coupon': $coupon = $total['value'];break;
					 case 'voucher': $voucher = $total['value'];break;
				  }
			  }

        // coupon free shipping
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_info['order_id'] . "'");

        if (isset($query->rows)){
          foreach ($query->rows as $row) {
            $sipcoup = $this->db->query("SELECT `shipping` FROM `" . DB_PREFIX . "coupon` WHERE coupon_id = '" . (int)$row['coupon_id'] . "'");
            if ($sipcoup->row['shipping'] == 1) {
              $couponship = true;
            }
          }
        }

        if (isset($couponship)) {
          $shipping = 0;
        }

        // coupon free shipping end

        $ndsval = 1;

        if ($this->config->get($codeforpay.'_nds') == 'important'){
          $ndsval = $this->config->get($codeforpay.'_nds_important');
        }

        if ($this->config->get($codeforpay.'_nds') == 'tovar'){
          $ndson = true;
          $this->load->model('catalog/product');
        }

            if ($this->config->get($codeforpay . '_shipinprod')) {

              $this->config->set($codeforpay . '_show_free_shipping', false);
              $shipping = 0;
            }

            $moden = ($totalcheck - $this->currency->format($shipping, 'RUB', $this->currency->getValue('RUB'), false))/$this->currency->format($subtotal, 'RUB', $this->currency->getValue('RUB'), false);
            $alldiscount = false;
            $alldiscount = false;

            foreach ($cart_products as $cart_product) { 

              $cart_product['payment_mode'] = $payment_mode_default;
              if ($payment_mode_source) {
                $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $payment_mode_source);
                if ($res != '') {
                  $cart_product['payment_mode'] = str_replace(' ', '', $res);
                }
              }
              $cart_product['payment_subject'] = $payment_subject_default;
              if ($payment_subject_source) {
                $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $payment_subject_source);
                if ($res != '') {
                  $cart_product['payment_subject'] = str_replace(' ', '', $res);
                }
              }

              if (isset($customname)) {
                $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $customname);
                if ($res != '') {
                  $cart_product['name'] = $res;
                }
              }

              $tovprice = number_format($this->currency->format($cart_product['price'], 'RUB', $this->currency->getValue('RUB'), false) * $moden, 2, '.', '');
              if ($tovprice < 0){
                $alldiscount = true;
                break;
              }

              $ndsvalue = $ndsval;
              if (isset($ndson)) {
                foreach ($this->config->get($codeforpay.'_classes') as $tax_rule) {
                  
                  $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                    if (isset($tax_rule[$codeforpay.'_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codeforpay.'_nalog'] == $product_info['tax_class_id']) {
                        $ndsvalue = $tax_rule[$codeforpay.'_tax_rule'];
                    }
                }
              }   


                    $okassa['items'][] = array(
                        'quantity' => $cart_product['quantity'],
                        'text' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0 , 128, 'UTF-8'),
                        'tax' => $ndsvalue,
                        'price' => array(
                        'amount' => $tovprice,
                        'currency' => 'RUB'
                        
                        ),
                        $fzpaymentSubject => $cart_product['payment_subject'],
                        $fzpaymentMode => $cart_product['payment_mode'],
                    );
                
            }   

            if ($alldiscount == true){


              $moden = $totalcheck/($this->currency->format($subtotal, 'RUB', $this->currency->getValue('RUB'), false)+$this->currency->format($shipping, 'RUB', $this->currency->getValue('RUB'), false));

                    foreach ($cart_products as $cart_product) { 

                      $cart_product['payment_mode'] = $payment_mode_default;
                      if ($payment_mode_source) {
                        $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $payment_mode_source);
                        if ($res != '') {
                          $cart_product['payment_mode'] = str_replace(' ', '', $res);
                        }
                      }
                      $cart_product['payment_subject'] = $payment_subject_default;
                      if ($payment_subject_source) {
                        $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $payment_subject_source);
                        if ($res != '') {
                          $cart_product['payment_subject'] = str_replace(' ', '', $res);
                        }
                      }

                      if (isset($customname)) {
                        $res = $this->model_account_yandexur->getCustomName($cart_product['product_id'], $customname);
                        if ($res != '') {
                          $cart_product['name'] = $res;
                        }
                      }
              
                    $tovprice = number_format($this->currency->format($cart_product['price'], 'RUB', $this->currency->getValue('RUB'), false) * $moden, 2, '.', '');

                    $ndsvalue = $ndsval;
                    if (isset($ndson)) {
                      foreach ($this->config->get($codeforpay.'_classes') as $tax_rule) {
                        
                        $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                          if (isset($tax_rule[$codeforpay.'_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codeforpay.'_nalog'] == $product_info['tax_class_id']) {
                              $ndsvalue = $tax_rule[$codeforpay.'_tax_rule'];
                          }
                      }
                    }   


                          $okassa['items'][] = array(
                              'quantity' => $cart_product['quantity'],
                              'text' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0 , 128, 'UTF-8'),
                              'tax' => $ndsvalue,
                              'price' => array(
                              'amount' => $tovprice,
                              'currency' => 'RUB'
                              
                              ),
                              $fzpaymentSubject => $cart_product['payment_subject'],
                              $fzpaymentMode => $cart_product['payment_mode'],
                          );
                      
                  }

                  if ($shipping > 0 && $order_info['shipping_code'] != '' || $this->config->get($codeforpay . '_show_free_shipping') && $order_info['shipping_code'] != '') {
                      $okassa['items'][] = array(
                          'quantity' => 1,
                          'text' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0 , 128, 'UTF-8'),
                          'tax' => $this->model_account_yandexur->getndscode($this->config->get($codeforpay . '_shipping_tax')),
                          'price' => array(
                          'amount' => number_format($this->currency->format($shipping, 'RUB', $this->currency->getValue('RUB'), false) * $moden, 2, '.', ''),
                          'currency' => 'RUB'
                          ),
                          $fzpaymentSubject => 'service',
                          $fzpaymentMode => $payment_mode_default,
                      );
                  }



            }


            //kopeyka wars
            $checkitogo = 0;

            foreach ($okassa['items'] as $okas) {
           
              $checkitogo += $okas['quantity']*$okas['price']['amount'];
            
            }
           

            if ($alldiscount == true) {

              $proverkacheck = number_format($totalcheck - $checkitogo,  2, '.', '');
              
            }

            else{

               $proverkacheck = number_format($totalcheck - $this->currency->format($shipping, 'RUB', $this->currency->getValue('RUB'), false) - $checkitogo,  2, '.', '');

            }

            if ($proverkacheck != 0.00) {
                    
              $correctsum = $proverkacheck;
              
              $itemnum = -1;
              $kopwar = false;
              foreach ($okassa['items'] as $item){
                $itemnum +=1;
                if ($item['quantity'] == 1 && $item['price']['amount'] > 0){
                    $okassa['items'][$itemnum]['price']['amount'] = number_format($okassa['items'][$itemnum]['price']['amount'] + $correctsum, 2, '.', '');
                    $kopwar = true;
                    break;
                }

              }
              
              if ($kopwar == false){
                foreach ($okassa['items'] as $item){
                  if ($item['price']['amount'] > 0){
                    $okassa['items'][0]['quantity'] -= 1;
                    $copyprod[] = array(
                        'quantity' => 1,
                        'text' => $okassa['items'][0]['text'],
                        'tax' => $okassa['items'][0]['tax'],
                        'price' => array(
                        'amount' => number_format($okassa['items'][0]['price']['amount'] + $correctsum, 2, '.', ''),
                        'currency' => $okassa['items'][0]['price']['currency']
                        
                        ),
                        $fzpaymentSubject => $okassa['items'][0][$fzpaymentSubject],
                        $fzpaymentMode => $okassa['items'][0][$fzpaymentMode],
                    );
                    array_splice($okassa['items'], 1, 0, $copyprod);
                    $kopwar = true;
                    break;
                  }
                }
              }

            }

            //kopeyka wars end


            if ($shipping > 0 && $alldiscount == false && $order_info['shipping_code'] != '' || $this->config->get($codeforpay . '_show_free_shipping') && $alldiscount == false && $order_info['shipping_code'] != '') {
                $okassa['items'][] = array(
                    'quantity' => 1,
                    'text' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0 , 128, 'UTF-8'),
                    'tax' => $this->model_account_yandexur->getndscode($this->config->get($codeforpay . '_shipping_tax')),
                    'price' => array(
                    'amount' => number_format($this->currency->format($shipping, 'RUB', $this->currency->getValue('RUB'), false), 2, '.', ''),
                    'currency' => 'RUB'
                    ),
                    $fzpaymentSubject => 'service',
                    $fzpaymentMode => $payment_mode_default,
                );
            }


        $data['okassa'] = json_encode($okassa);
        if ($this->config->get($codeforpay.'_debug')) {
          echo '<br/>--------------Товары---------------------------------------<br/>';
	        var_dump($cart_products);
	        echo '<br/><br/>--------------Учитывать-в-заказе---------------------------<br/>';
          var_dump($totals);
          echo '<br/><br/>--------------В-чек----------------------------------------<br/>';
	        var_dump($okassa);
	        echo '<br/><br/>-----------------------------------------------------------<br/>';

	        echo '<br/>--------------Онлайн Чек (Позиции для отладки)-------------<br/>';

	        $numpos = 0;
	        $itogo = 0;

	        $ondsrules = array(
            array(
                'id' => 0,
                'name' => 'Пустой'
            ),
        	  array(
                'id' => 1,
                'name' => 'Без НДС'
            ),
            array(
                'id' => 2,
                'name' => 'НДС 0%'
            ),
            array(
                'id' => 3,
                'name' => 'НДС 10%'
            ), 
            array(
                'id' => 4,
                'name' => 'НДС 18%'
            ),
            array(
                'id' => 5,
                'name' => 'НДС 10/110'
            ),
            array(
                'id' => 6 ,
                'name' => 'НДС 18/118'
            )
        );

          echo '<table>';

	        foreach ($okassa['items'] as $okas) {
	        	$numpos += 1;
	        	$itogo += $okas['quantity']*$okas['price']['amount'];
	        	$otax = $ondsrules[$okas['tax']]['name'];
            echo '<tr><td>';
	        	echo $numpos . '.</td><td>' . $okas['text'] .'</td><td>' . $okas['quantity'] . ' * ' .  $okas['price']['amount'] .'</td><td>' . '   =   ' . $okas['quantity']*$okas['price']['amount'] . '</td></tr>';
            echo '<tr><td></td><td>'.$otax.'</td></tr>';
	        }
	        echo '<tr></tr><tr><td></td><td>ИТОГ: </td><td></td><td> = '.$itogo.'</td></tr>';
          echo '</table>';
	    }
      }
      // CHECKS ONLINE SERVICE END

      $data['email'] = $order_info['email'];
      $data['phone'] = $order_info['telephone'];

      $data['debug'] = $this->config->get($codeforpay.'_debug');
      if (isset($this->request->get['first'])) {
      	$data['first'] = $this->request->get['first'];
      }


      if ($this->config->get($codeforpay . '_protokol')) {

        $this->data = $data;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/yandexur_pay.tpl')) {
          $this->template = $this->config->get('config_template') . '/template/account/yandexur_pay.tpl';
        } else {
          $this->template = 'default/template/account/yandexur_pay.tpl';
        }
        $this->response->setOutput($this->render());

      } else {
        if ($this->config->get($codeforpay . '_cart')) {
          $okassa['items'] = '';
        }
        $this->apiPay($okassa['items'], $data, $codeforpay, $order_info);
      }

      //NEW API END

	 }
		else{
			$this->redirect($this->url->link('error/not_found'));
		}
    }

  public function check() {


  	if (isset($this->request->post['md5']) && isset($this->request->post['paymentType']) && isset($this->request->post['customerNumber'])) {

  		$this->load->model('account/yandexur');
    	$paymentcode = $this->model_account_yandexur->getPaymentType($this->request->post['paymentType']);

  		$this->load->model('checkout/order');

  		if ($this->request->post['paymentType'] != 'MP'){
  			$order_info = $this->model_checkout_order->getOrder($this->request->post['order']);
  		}
  		else{
  			$order_info = $this->model_checkout_order->getOrder(preg_replace('/[^0-9]/', '', $this->request->post['orderDetails']));
  		}
  		if ($this->config->get($paymentcode.'_fixen')) {
			if ($this->config->get($paymentcode.'_fixen') == 'fix'){
			    $totalrub = $this->config->get($paymentcode.'_fixen_amount');
			}
			else{
			    $totalrub = $order_info['total'] * $this->config->get($paymentcode.'_fixen_amount') / 100;
			}
		}
		else{
			$totalrub = $order_info['total'];
		}

  		
		$secret_key = $this->config->get($paymentcode.'_password');
		$shopId = $this->config->get($paymentcode.'_shopId');
		if ($this->config->get($paymentcode.'_komis')){
			$youpayment = $this->currency->format(($totalrub * $this->config->get($paymentcode.'_komis')/100) + $totalrub, 'RUB', $this->currency->getValue('RUB'), false);
		}
		else{
				$youpayment = $this->currency->format($totalrub, 'RUB', $this->currency->getValue('RUB'), false);
		}


		$payments = number_format($this->request->post['orderSumAmount'],2);
		$youpayment = number_format($youpayment,2);
		if($youpayment == $payments){
			$yahash = $this->request->post['md5'];
			$key = $this->config->get('config_encryption');
			$myhash = $this->request->post['action'].';'.$this->request->post['orderSumAmount'].';'.$this->request->post['orderSumCurrencyPaycash'].';'.$this->request->post['orderSumBankPaycash'].';'.$this->request->post['shopId'].';'.$this->request->post['invoiceId'].';'.$this->request->post['customerNumber'].';'.$this->model_account_yandexur->yandecrypt($secret_key, $key);
	  		$myhash = strtoupper(md5($myhash));
		

			if($yahash == $myhash) {
		        $paystat = $this->model_account_yandexur->getPaymentStatus($this->request->post['order']);
		        if (!isset($paystat['status'])){$paystat['status'] = 0;}
		        if ($paystat['status'] != 1){
		  		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<checkOrderResponse performedDatetime =\"" . $this->request->post['orderCreatedDatetime'] . "\" code=\"0\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $shopId . "\"/>";
		  		}
		  		else{
		  			$this->log->write('YandexUr Error: This order alredy payed ');
					echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<checkOrderResponse performedDatetime =\"" . $this->request->post['orderCreatedDatetime'] . "\" code=\"100\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $shopId . "\"/>";
		  		}				
			}
			else{
				$this->log->write('YandexUr Error: Hash not equal');
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<checkOrderResponse performedDatetime =\"" . $this->request->post['orderCreatedDatetime'] . "\" code=\"1\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $shopId . "\"/>";
			}
		}
		else{
			$this->log->write('YandexUr Error: Amount of payment not equal');
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<checkOrderResponse performedDatetime =\"" . $this->request->post['orderCreatedDatetime'] . "\" code=\"100\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $shopId . "\"/>";
		}

  	}
  	else{
  		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<checkOrderResponse performedDatetime =\"" . $this->request->post['orderCreatedDatetime'] . "\" code=\"200\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $shopId . "\"/>";
  	}
  }

  public function callback() {

		if (isset($this->request->post['invoiceId']) && isset($this->request->post['shopId'])) {

			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><paymentAvisoResponse performedDatetime =\"" . $this->request->post['paymentDatetime'] . "\" code=\"0\" invoiceId=\"" . $this->request->post['invoiceId'] . "\" shopId=\"" . $this->request->post['shopId'] . "\"/>";

			$this->load->model('account/yandexur');
			$paymentcode = $this->model_account_yandexur->getPaymentType($this->request->post['paymentType']);
			$this->load->model('checkout/order');
			if ($this->request->post['paymentType'] == 'MP') {
				$ordernum = preg_replace('/[^0-9]/', '', $this->request->post['orderDetails']);
			}
			else{
			    $ordernum = $this->request->post['order'];
			}

			$order_info = $this->model_checkout_order->getOrder($ordernum);
	        $paystat = $this->model_account_yandexur->getPaymentStatus($ordernum);
	        if (!isset($paystat['status'])){$paystat['status'] = 0;}
	        if ($paystat['status'] != 1){

				if (isset($this->request->post['md5']) && isset($this->request->post['paymentType']) && isset($this->request->post['customerNumber'])) {

			  		if ($this->config->get($paymentcode.'_fixen')) {
						if ($this->config->get($paymentcode.'_fixen') == 'fix'){
						    $totalrub = $this->config->get($paymentcode.'_fixen_amount');
						}
						else{
						    $totalrub = $order_info['total'] * $this->config->get($paymentcode.'_fixen_amount') / 100;
						}
					}
					else{
						$totalrub = $order_info['total'];
					}

					$secret_key = $this->config->get($paymentcode.'_password');
					$shopId = $this->config->get($paymentcode.'_shopId');
					if ($this->config->get($paymentcode.'_komis')){
						$youpayment = $this->currency->format(($totalrub * $this->config->get($paymentcode.'_komis')/100) + $totalrub, 'RUB', $this->currency->getValue('RUB'), false);
					}
					else {
						$youpayment = $this->currency->format($totalrub, 'RUB', $this->currency->getValue('RUB'), false);
					}

					$payments = number_format($this->request->post['orderSumAmount'],2);
					$youpayment = number_format($youpayment,2);
					if($youpayment == $payments){
						$yahash = $this->request->post['md5'];
						$key = $this->config->get('config_encryption');
						$myhash = $this->request->post['action'].';'.$this->request->post['orderSumAmount'].';'.$this->request->post['orderSumCurrencyPaycash'].';'.$this->request->post['orderSumBankPaycash'].';'.$this->request->post['shopId'].';'.$this->request->post['invoiceId'].';'.$this->request->post['customerNumber'].';'.$this->model_account_yandexur->yandecrypt($secret_key, $key);
				  		$myhash = strtoupper(md5($myhash));
					

						if($yahash == $myhash) {
							$query = $this->db->query ("INSERT INTO `" . DB_PREFIX . "yandexur` SET `num_order` = '".(int)$order_info['order_id']."' , `sum` = '".$this->db->escape($this->request->post['orderSumAmount'])."' , `date_enroled` = '".$this->db->escape($this->request->post['orderCreatedDatetime'])."', `date_created` = '".$this->db->escape($order_info['date_added'])."', `user` = '".$this->db->escape($order_info['payment_firstname'])." ".$this->db->escape($order_info['payment_lastname'])."', `email` = '".$this->db->escape($order_info['email'])."', `status` = '1', `sender` = '".(int)$this->request->post['invoiceId']."' ");

									if($this->config->get($paymentcode.'_createorder_or_notcreate') && $order_info['order_status_id'] != $this->config->get($paymentcode.'_on_status_id')){
										$this->language->load('payment/'.$paymentcode);
											if ($this->config->get($paymentcode.'_mail_instruction_attach')){
												$inv_id = $order_info['order_id'];
												if ($this->config->get($paymentcode.'_fixen')) {
													if ($this->config->get($paymentcode.'_fixen') == 'fix'){
													    $out_summ = $this->config->get($paymentcode.'_fixen_amount');
													}
													else{
													    $out_summ = $order_info['total'] * $this->config->get($paymentcode.'_fixen_amount') / 100;
													}
												}
												else{
													$out_summ = $order_info['total'];
												}
												$action= $order_info['store_url'] . 'index.php?route=account/yandexur';
												$online_url = $action .

												'&order_id='	. $order_info['order_id'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

										    	$comment  = $this->language->get('text_instruction') . "\n\n";
										    	$instros = explode('$', ($this->config->get($paymentcode.'_mail_instruction_' . $order_info['language_id'])));
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
																if($this->config->get($paymentcode.'_komis')){
															    	$instro_other = $this->config->get($paymentcode.'_komis') . '%';
																}
																else{$instro_other = '';}
															}
															if ($instro == 'total-komis'){
																if($this->config->get($paymentcode.'_komis')){
															    	$instro_other = $this->currency->format($out_summ * $this->config->get($paymentcode.'_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
																}
																else{$instro_other = '';}
															}
															if ($instro == 'plus-komis'){
																if($this->config->get($paymentcode.'_komis')){
															    	$instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($paymentcode.'_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
																}
																else {$instro_other = '';}
															}
												       	}
												       	else {
												       		$instro_other = nl2br($instro);
												       	}
												       	$instroz .=  $instro_other;
												      }
												$comment .= $instroz;
										    	$comment = htmlspecialchars_decode($comment);
										    	$this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), $comment, true);
									    	}
									    	else {
												$this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), true);
											}

											if ($this->config->get($paymentcode.'_success_alert_customer')){
									        	if ($this->config->get($paymentcode.'_success_comment_attach')) {
									          		$instros = explode('$', ($this->config->get($paymentcode.'_success_comment_' . $order_info['language_id'])));
									              	$instroz = "";
									              	foreach ($instros as $instro) {
									                	if ($instro == 'orderid' ||  $instro == 'itogo'){
									                    	if ($instro == 'orderid'){
									                    		$instro_other = $order_info['order_id'];
									                  		}
									                  		if ($instro == 'itogo'){
									                      		$instro_other = $this->currency->format($totalrub, $order_info['currency_code'], $order_info['currency_value'], true);
									                  		}
									                	}
									                	else {
									                  		$instro_other = nl2br(htmlspecialchars_decode($instro));
									                	}
									                	$instroz .=  $instro_other;
									              	}
									          		$message = $instroz;
									          		$this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), $message, true);
									        	}
									        	else{
									          		$message = '';
									          		$this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), $message, true);
									        	}
								    		}
									}

									else {

								    	if ($this->config->get($paymentcode.'_success_alert_customer')){
								        	if ($this->config->get($paymentcode.'_success_comment_attach')) {
								          		$instros = explode('$', ($this->config->get($paymentcode.'_success_comment_' . $order_info['language_id'])));
								              	$instroz = "";
								              	foreach ($instros as $instro) {
								                	if ($instro == 'orderid' ||  $instro == 'itogo'){
								                    	if ($instro == 'orderid'){
								                    		$instro_other = $order_info['order_id'];
								                  		}
								                  		if ($instro == 'itogo'){
								                      		$instro_other = $this->currency->format($totalrub, $order_info['currency_code'], $order_info['currency_value'], true);
								                  		}
								                	}
								                	else {
								                  		$instro_other = nl2br(htmlspecialchars_decode($instro));
								                	}
								                	$instroz .=  $instro_other;
								              	}
								          		$message = $instroz;
								          		$this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), $message, true);
								        	}
								        	else{
								          		$message = '';
								          		$this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), $message, true);
								        	}
								    	}
								    	else{
								      		$this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode.'_order_status_id'), false);
								    	}

									}

						    		if ($this->config->get($paymentcode.'_success_alert_admin')) {
						      
						        		$subject = sprintf(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_info['order_id']);
						        
						        		// Text 
								        $this->load->language('account/'.$paymentcode);
								        $text = sprintf($this->language->get('success_admin_alert'), $order_info['order_id']) . "\n";
								        
								        
								      
								        $mail = new Mail(); 
								        $mail->protocol = $this->config->get('config_mail_protocol');
								        $mail->parameter = $this->config->get('config_mail_parameter');
								        $mail->hostname = $this->config->get('config_smtp_host');
								        $mail->username = $this->config->get('config_smtp_username');
								        $mail->password = $this->config->get('config_smtp_password');
								        $mail->port = $this->config->get('config_smtp_port');
								        $mail->timeout = $this->config->get('config_smtp_timeout');
								        $mail->setTo($this->config->get('config_email'));
								        $mail->setFrom($this->config->get('config_email'));
								        $mail->setSender($order_info['store_name']);
								        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
								        $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
								        $mail->send();
								        
								        // Send to additional alert emails
								        $emails = explode(',', $this->config->get('config_alert_emails'));
						        
						        		foreach ($emails as $email) {
						          			if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						            			$mail->setTo($email);
						            			$mail->send();
						          			}
							    		}
							    	}
						   	}
						else{
							$this->log->write('YandexUr Error: Hash not equal');
						}
					}
					else{
						$this->log->write('YandexUr Error: Amount of payment not equal');
					}

			  	}
			  	else{
			  		echo "No Data";
			  	}
			}

		}
  }

  public function success() {
  	if (isset($this->request->get['order'])){
   		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->request->get['order']);
  	}
  	else{
   		echo 'No order';
   		exit();
  	}

  	if ($this->request->get['order'] == $order_info['order_id']){
      $inv_id = $order_info['order_id'];
      $this->data['inv_id'] = $order_info['order_id'];

      $this->load->model('account/yandexur');

      $action = $this->url->link('account/yandexur');
				$online_url = $action .
				'&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

      $this->data['success_text'] = '';


      $paymentcode = $order_info['payment_code'];

      	if ($this->config->get($paymentcode.'_fixen')) {
			if ($this->config->get($paymentcode.'_fixen') == 'fix'){
			    $out_summ = $this->config->get($paymentcode.'_fixen_amount');
			}
			else{
			    $out_summ = $order_info['total'] * $this->config->get($paymentcode.'_fixen_amount') / 100;
			}
		}
		else{
			$out_summ = $order_info['total'];
		}

      
      	$this->load->language('account/'.$paymentcode);
      	$this->data['heading_title'] = $this->language->get('heading_title');
      	$this->document->setTitle($this->language->get('heading_title'));
      	$this->data['button_ok'] = $this->language->get('button_ok');

      	if ($order_info['order_status_id'] == $this->config->get($paymentcode.'_order_status_id')) {

      	if (isset($this->request->get['first'])) {
	        $this->data['success_text'] .=  $this->language->get('success_text_first');
	    }

      	  	if($this->config->get($paymentcode.'_createorder_or_notcreate')  && isset($this->request->get['first'])){
		        
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
		    }

	      if ($this->config->get($paymentcode.'_success_page_text_attach')) {

	      $instros = explode('$', ($this->config->get($paymentcode.'_success_page_text_' . $this->config->get('config_language_id'))));
	              $instroz = "";
	              foreach ($instros as $instro) {
	                if ($instro == 'orderid' ||  $instro == 'itogo' || $instro== 'href' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
	                  if ($instro == 'orderid'){
	                    $instro_other = $inv_id;
	                  }
	                  if ($instro == 'itogo'){
	                      $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
	                  }
	                  if ($instro == 'href'){
	                      $instro_other = $online_url;
	                  }
	                  if ($instro == 'komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->config->get($paymentcode.'_komis') . '%';
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'total-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ * $this->config->get($paymentcode.'_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'plus-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($paymentcode.'_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                }
	                else {
	                  $instro_other = nl2br(htmlspecialchars_decode($instro));
	                }
	                $instroz .=  $instro_other;
	              }

	      $this->data['success_text'] .= $instroz;
	      }
	      else{
	          $this->data['success_text'] .=  sprintf($this->language->get('success_text'), $inv_id);
	      }
	    }
	    else{

	      	if (isset($this->request->get['first']) && $order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')) {
		        $this->data['success_text'] .=  $this->language->get('success_text_first');
		    }
	    	if ($this->config->get($paymentcode.'_waiting_page_text_attach')) {

	      $instros = explode('$', ($this->config->get($paymentcode.'_waiting_page_text_' . $this->config->get('config_language_id'))));
	              $instroz = "";
	              foreach ($instros as $instro) {
	                if ($instro == 'orderid' ||  $instro == 'itogo' || $instro== 'href' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
	                  if ($instro == 'orderid'){
	                    $instro_other = $inv_id;
	                  }
	                  if ($instro == 'itogo'){
	                      $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
	                  }
	                  if ($instro == 'href'){
	                      $instro_other = $online_url;
	                  }
	                  if ($instro == 'komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->config->get($paymentcode.'_komis') . '%';
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'total-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ * $this->config->get($paymentcode.'_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'plus-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($paymentcode.'_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                }
	                else {
	                  $instro_other = nl2br(htmlspecialchars_decode($instro));
	                }
	                $instroz .=  $instro_other;
	              }

	      $this->data['success_text'] .= $instroz;
	      }
	      else{
	      		if($order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')){
	         		$this->data['success_text'] .=  sprintf($this->language->get('success_text_wait'), $inv_id, $online_url);
	         	}
	         	else{
	          		$this->data['success_text'] .=  sprintf($this->language->get('success_text_wait_noorder'), $online_url);
	          	}
	      }
	    }
	  
      if ($this->customer->isLogged()) {
        
        			
        			if(!$this->config->get($paymentcode.'_createorder_or_notcreate')){ 
        				$this->data['success_text'] .=  sprintf($this->language->get('success_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'));
        			}
        			else{
        				if ($order_info['order_status_id'] == $this->config->get($paymentcode.'_order_status_id')) {
        					$this->data['success_text'] .=  sprintf($this->language->get('success_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'));
        				}
        			}
	        		if ($order_info['order_status_id'] != $this->config->get($paymentcode.'_order_status_id')) {
	        			if($order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')){
	        				$this->data['success_text'] .=  sprintf($this->language->get('waiting_text_loged'), $this->url->link('account/order', '', 'SSL'));
	        			}
	        		}

      }
      
      $this->data['breadcrumbs'] = array();

      $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
      );
      
      if (isset($this->request->get['first'])) {
        $this->language->load('checkout/success');
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
        $this->data['button_ok_url'] = $this->url->link('common/home');
      }
      else{
        if ($this->customer->isLogged()) {
          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('lich'),
            'href'      => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
          );

          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('history'),
            'href'      => $this->url->link('account/order', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
          );
          $this->data['button_ok_url'] = $this->url->link('account/order', '', 'SSL');
        }
        else{
          $this->data['button_ok_url'] = $this->url->link('common/home');
        }
      }

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .
          '/template/account/yandexur_success.tpl')) {

          $this->template = $this->config->get('config_template') .
          '/template/account/yandexur_success.tpl';
      } else {
          $this->template = 'default/template/account/yandexur_success.tpl';
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
    else{
      echo "No data";
    }
  }

  public function fail(){
  	if (isset($this->request->get['order'])){
   		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->request->get['order']);
  	}
  	else{
   		echo 'No order';
   		exit();
  	}

  	if ($this->request->get['order'] == $order_info['order_id']){
  	  $paymentcode = $order_info['payment_code'];
      $inv_id = $order_info['order_id'];
      $this->load->language('account/'.$paymentcode);
      $this->data['heading_title'] = $this->language->get('heading_title_fail');
      $this->document->setTitle($this->language->get('heading_title'));
      $this->data['button_ok'] = $this->language->get('button_ok');
      $this->data['inv_id'] = $order_info['order_id'];

      $this->load->model('account/yandexur');

      $action = $this->url->link('account/yandexur');
				$online_url = $action .
				'&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

      $this->data['fail_text'] = '';

      	if (isset($this->request->get['first']) && $order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')) {
	      	$this->data['fail_text'] .=  $this->language->get('fail_text_first');
	    }
      	if ($this->config->get($paymentcode.'_fixen')) {
			if ($this->config->get($paymentcode.'_fixen') == 'fix'){
			    $out_summ = $this->config->get($paymentcode.'_fixen_amount');
			}
			else{
			    $out_summ = $order_info['total'] * $this->config->get($paymentcode.'_fixen_amount') / 100;
			}
		}
		else{
			$out_summ = $order_info['total'];
		}

	    	if ($this->config->get($paymentcode.'_fail_page_text_attach')) {

	      $instros = explode('$', ($this->config->get($paymentcode.'_fail_page_text_' . $this->config->get('config_language_id'))));
	              $instroz = "";
	              foreach ($instros as $instro) {
	                if ($instro == 'orderid' ||  $instro == 'itogo' || $instro== 'href' || $instro == 'komis' || $instro == 'total-komis' || $instro == 'plus-komis'){
	                  if ($instro == 'orderid'){
	                    $instro_other = $inv_id;
	                  }
	                  if ($instro == 'itogo'){
	                      $instro_other = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
	                  }
	                  if ($instro == 'href'){
	                      $instro_other = $online_url;
	                  }
	                  if ($instro == 'komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->config->get($paymentcode.'_komis') . '%';
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'total-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ * $this->config->get($paymentcode.'_komis')/100, $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                      if ($instro == 'plus-komis'){
	                        if($this->config->get($paymentcode.'_komis')){
	                            $instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get($paymentcode.'_komis')/100), $order_info['currency_code'], $order_info['currency_value'], true);
	                        }
	                        else{$instro_other = '';}
	                      }
	                }
	                else {
	                  $instro_other = nl2br(htmlspecialchars_decode($instro));
	                }
	                $instroz .=  $instro_other;
	              }

	      $this->data['fail_text'] .= $instroz;
	      }
	      else{
	      		if($order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')){
	         		$this->data['fail_text'] .=  sprintf($this->language->get('fail_text'), $inv_id, $online_url, $online_url);
	         	}
	         	else{
	          		$this->data['fail_text'] .=  sprintf($this->language->get('fail_text_noorder'), $online_url);
	          	}
	      }

	  
      if ($this->customer->isLogged()) {
        
        			
        			if($order_info['order_status_id'] == $this->config->get($paymentcode.'_on_status_id')){ 
        				$this->data['fail_text'] .=  sprintf($this->language->get('fail_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'), $this->url->link('account/order', '', 'SSL'));
        			}

      }
      
      $this->data['breadcrumbs'] = array();

      $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
      );
      
      if (isset($this->request->get['first'])) {
        $this->language->load('checkout/success');
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
        $this->data['button_ok_url'] = $this->url->link('common/home');
      }
      else{
        if ($this->customer->isLogged()) {
          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('lich'),
            'href'      => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
          );

          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('history'),
            'href'      => $this->url->link('account/order', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
          );
          $this->data['button_ok_url'] = $this->url->link('account/order', '', 'SSL');
        }
        else{
          $this->data['button_ok_url'] = $this->url->link('common/home');
        }
      }

      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') .
          '/template/account/yandexur_fail.tpl')) {

          $this->template = $this->config->get('config_template') .
          '/template/account/yandexur_fail.tpl';
      } else {
          $this->template = 'default/template/account/yandexur_fail.tpl';
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
    else{
      echo "No data";
    }
  }

//NEW API

  private function apiPay($items, $data, $codeforpay, $order_info) {

    if (isset($data['first'])) {
      $first = '&first=1';
    } else {
      $first = '';
    }

    $type = $this->model_account_yandexur->getApiPaymentType($data['paymentType']);

    $okassa = array(
      'amount' => array(
        'value' => number_format($data['total'], 2, '.', ''),
        'currency' => "RUB",
      ),

    );

    $code = substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

    if ($type['conf'] == 'redirect') {
      $okassa['confirmation'] = array(
        'type' => $type['conf'],
        'return_url' => htmlspecialchars_decode($this->url->link('account/yandexur/status', 'order=' . $order_info['order_id'] . '&code=' . $code . $first, 'SSL')),
      );
    } else {
      $okassa['confirmation'] = array(
        'type' => $type['conf'],
      );
    }

    if (!$this->config->get($codeforpay . '_cart')) {

      $itemapi = array();

      foreach ($items as $item) {
        $itemapi[] = array (

          'description' => $item['text'],
          'quantity' => $item['quantity'],
          'amount' => array(
                'value' => $item['price']['amount'],
                'currency' => $item['price']['currency'],
              ),
          'vat_code' => $item['tax'],
          'payment_subject' => $item['payment_subject'],
          'payment_mode' => $item['payment_mode'],
        );
      }

      $okassa['receipt']['items'] = $itemapi;

      if ($order_info['email'] != '') {
        if (!strpos($order_info['email'], '@localhost.net')) {
          $okassa['receipt']['email'] = $order_info['email'];
        } else {
          $okassa['receipt']['phone'] = preg_replace('/[^0-9]/', '', $order_info['telephone']);
        }
      } else {
        $okassa['receipt']['phone'] = preg_replace('/[^0-9]/', '', $order_info['telephone']);
      }

      if ($this->config->get($codeforpay . '_tax_system_code')) {
        $okassa['receipt']['tax_system_code'] = $this->config->get($codeforpay . '_tax_system_code');
      }

    }

    if ($type['code'] != '') {
      $okassa['payment_method_data'] = array(
        'type' => $type['code'],
      );
    }

    if ($codeforpay == 'yandexur_qiwi' || $codeforpay == 'yandexur_term' || $codeforpay == 'yandexur_mobile' || $codeforpay == 'yandexur_sb'){
      $okassa['payment_method_data']['phone'] = preg_replace('/[^0-9]/', '', $order_info['telephone']);
    }

    if ($data['paymentType'] == 'AB') {
      $okassa['payment_method_data'] = array_merge($okassa['payment_method_data'], array(
        'login' => '123',
      )
      );
    }

    $okassa['save_payment_method'] = false;

    $okassa['metadata'] = array(
      'order_id' => $order_info['order_id'],
    );

    if (!$data['paymentType'] == 'AC') {
      if ($this->config->get($codeforpay . '_capture') == 'auto') {
        $okassa['capture'] = true;
      }
    } else {
      if (!$this->config->get($codeforpay . '_twostage')) {
        if ($this->config->get($codeforpay . '_capture') == 'auto') {
          $okassa['capture'] = true;
        }
      }
    }

    if ($data['paymentType'] == 'BSB') {
        $okassa['capture'] = true;
        $ppusrpose = array();
        $ppusrpose['payment_purpose'] = $this->language->get('pay_order_text_target') . ' ' . $order_info['order_id'];

        if ($this->config->get($codeforpay . '_nds')) {

            $ppconfigrate = $this->config->get($codeforpay . '_nds_important');
            if ($ppconfigrate == 4 || $ppconfigrate == 6) {
                $pprate = '18';
                $pptotal = number_format($data['total']*18/118, 2, '.', '');
            }
            else if ($ppconfigrate == 3 || $ppconfigrate == 5) {
                $pprate = '10';
                $pptotal = number_format($data['total']*10/110, 2, '.', '');
            }
            else{
                $pprate = '7';
                $pptotal = 0.00;
            }

            $ppusrpose['vat_data'] = array(
                'type' => 'calculated',
                'rate' => $pprate,
                'amount' => array(
                    'value' => $pptotal,
                    'currency' => 'RUB',
                ),
            );
        }
        else{
            $ppusrpose['vat_data'] = array(
                'type' => 'untaxed',
            );
        }

        $okassa['payment_method_data'] = array_merge($okassa['payment_method_data'], $ppusrpose);
    }

    $okassa['description'] = $this->language->get('pay_order_text_target') . ' ' . $order_info['order_id'];

    //$okassa['recipient'] = array(
    //        'gateway_id' => '174810',
    //);

    $guid = $this->getGUID();

    $result = $this->getRequest($okassa, $data, $codeforpay, $guid);
    if ($this->config->get($codeforpay . '_debug')) {
      echo '<br/><br/>' . $result;
    }
    $result = json_decode($result);
    
    if (isset($result) && $result != '') {
      if (isset($result->type)) {
        echo 'No Data';
        $this->erConstructor('apiPay', $result->type, $result->description);
      } else {

        $paystat = $this->model_account_yandexur->getPaymentStatus($order_info['order_id']);
        if (!isset($paystat['status'])) {
          $this->model_account_yandexur->setPaymentStatus($order_info, $result->id);
        } else {
          if ($paystat['status'] == 0) {
            $this->model_account_yandexur->updatePaymentStatus($order_info, $result->id);
          }
        }

        if (!$this->config->get($codeforpay . '_debug')) {

          $this->redirect($result->confirmation->confirmation_url);

        }

        if ($this->config->get($codeforpay . '_debug')) {
          echo '<br/><br/><a href="' . $result->confirmation->confirmation_url . '" >Перейти на оплату по ссылке ' . $result->confirmation->confirmation_url . '</a>';
        }

      }
    }
    else{

      $guid = $this->getGUID();

      $result = $this->getRequest($okassa, $data, $codeforpay, $guid);
      if ($this->config->get($codeforpay . '_debug')) {
        echo '<br/><br/>' . $result;
      }
      $result = json_decode($result);
      if (isset($result) && $result != '') {
        if (isset($result->type)) {
          echo 'No Data';
          $this->erConstructor('apiPay', $result->type, $result->description);
        } else {

          $paystat = $this->model_account_yandexur->getPaymentStatus($order_info['order_id']);
          if (!isset($paystat['status'])) {
            $this->model_account_yandexur->setPaymentStatus($order_info, $result->id);
          } else {
            if ($paystat['status'] == 0) {
              $this->model_account_yandexur->updatePaymentStatus($order_info, $result->id);
            }
          }

          if (!$this->config->get($codeforpay . '_debug')) {

            $this->redirect($result->confirmation->confirmation_url);

          }

          if ($this->config->get($codeforpay . '_debug')) {
            echo '<br/><br/><a href="' . $result->confirmation->confirmation_url . '" >Перейти на оплату по ссылке ' . $result->confirmation->confirmation_url . '</a>';
          }

        }
      }

    }
  }

  private function isJSON($string) {
    return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
  }

  private function errorChecker($result, $place) {
    $resulter = json_decode($result);
    if (isset($resulter->type)) {
      if ($resulter->type != 'error') {
        return $result;
      } else {
        $this->erConstructor($place, 'error', $result);
        $this->alertMail('YANDEXUR PRO', 'Запрос в статусе Error ' . $result, 'YANDEXUR PRO', false);
        $resulter->status = 'canceled';
        return json_encode($resulter);
      }
    } else {
      return $result;
    }
  }

  private function doCurlito($server, $guid, $post, $postdata, $credentials, $codeforpay) {

    if ($curl = curl_init()) {
      curl_setopt($curl, CURLOPT_URL, $server);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . $guid));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      if ($post) {
        curl_setopt($curl, CURLOPT_POST, $post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
      }
      curl_setopt($curl, CURLOPT_USERAGENT, 'art&pr-opencart');
      curl_setopt($curl, CURLOPT_USERPWD, $credentials);
      //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
      $result = curl_exec($curl);
      curl_close($curl);
    } else {
      return $this->erConstructor('getRequest', 'error', 'Server Error No CURL');
    }

    if ($this->config->get($codeforpay . '_debug')) {
      $this->log->write($result);
    }

    return $result;

  }

  private function getRequest($postdata = '', $data = '', $codeforpay, $guid = '', $type = '', $post = true, $checker = true) {

    if ($guid == '') {
      $guid = $this->getGUID();
    }

    if ($postdata != '') {
      $postdata = json_encode($postdata);
    }

    if ($data == '') {
      $data = array();
      $data['ShopID'] = $this->config->get($codeforpay . '_shopId');
    }

    if ($this->config->get($codeforpay . '_debug')) {
      echo '<br/>' . $postdata;
    }
    $this->load->model('account/yandexur');
    $credentials = $data['ShopID'] . ':' . $this->model_account_yandexur->yandecrypt($this->config->get($codeforpay . '_password'), $this->config->get('config_encryption'));
    $server = 'https://api.yookassa.ru/v3/payments' . $type;

    $result = $this->doCurlito($server, $guid, $post, $postdata, $credentials, $codeforpay);

    if ($result != '') {
      $resulter = json_decode($result);
      if (isset($resulter->type) && $resulter->type == 'processing') {
        sleep(2);
        $result = $this->doCurlito($server, $guid, $post, $postdata, $credentials, $codeforpay);
        $resulter = json_decode($result);
        if (isset($resulter->type) && $resulter->type == 'processing') {
          sleep(2);
          $result = $this->doCurlito($server, $guid, $post, $postdata, $credentials, $codeforpay);
          $resulter = json_decode($result);
          if (isset($resulter->type) && $resulter->type == 'processing') {
            sleep(2);
            $result = $this->doCurlito($server, $guid, $post, $postdata, $credentials, $codeforpay);
            $resulter = json_decode($result);
            if (isset($resulter->type) && $resulter->type == 'processing') {
              $this->alertMail('YANDEXUR PRO', 'Запрос завис в статусе Processing ' . $result, 'YANDEXUR PRO', false);
            }
          } else {
            return $result;
          }
        } else {
          return $result;
        }
      } else {
        return $result;
      }

    } else {
      if ($checker) {
        return $this->erConstructor('getRequest', 'error', 'No DATA or No connection');
      }
      else{
        return $result;
      }
    }
  }

  private function alertMail($subject, $text, $storename, $adid = true) {

    $mail = new Mail();
    $mail->protocol = $this->config->get('config_mail_protocol');
    $mail->parameter = $this->config->get('config_mail_parameter');
    $mail->hostname = $this->config->get('config_smtp_host');
    $mail->username = $this->config->get('config_smtp_username');
    $mail->password = $this->config->get('config_smtp_password');
    $mail->port = $this->config->get('config_smtp_port');
    $mail->timeout = $this->config->get('config_smtp_timeout');
    $mail->setTo($this->config->get('config_email'));
    $mail->setFrom($this->config->get('config_email'));
    $mail->setSender($storename);
    $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
    $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
    $mail->send();

    if ($adid) {

      // Send to additional alert emails
      $emails = explode(',', $this->config->get('config_alert_emails'));

      foreach ($emails as $email) {
        if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
          $mail->setTo($email);
          $mail->send();
        }
      }
    }

  }

  private function manageYaStatus($payment_id, $codeforpay, $data = '', $capture = '', $post = false, $checker = true) {

    if ($data == '') {
      $data = array();
      $data['ShopID'] = $this->config->get($codeforpay . '_shopId');
    }

    $type = '/' . $payment_id . $capture;
    $result = $this->getRequest('', $data, $codeforpay, '', $type, $post);

    if ($this->config->get($codeforpay . '_debug')) {
      $this->log->write($result);
    }

    if ($capture != '') {
      $functName = $capture;
    } else {
      $functName = '/check';
    }

    if ($checker) {
      return $this->errorChecker($result, 'manageStatus' . $functName);
    }
    else{
      return $result;
    }

  }

  private function checkSum($paySum, $order_info, $codeforpay) {

    if ($this->config->get($codeforpay . '_fixen')) {
      if ($this->config->get($codeforpay . '_fixen') == 'fix') {
        $totalrub = $this->config->get($codeforpay . '_fixen_amount');
      } else {
        $totalrub = $order_info['total'] * $this->config->get($codeforpay . '_fixen_amount') / 100;
      }
    } else {
      $totalrub = $order_info['total'];
    }

    if ($this->config->get($codeforpay . '_komis')) {
      $youpayment = $this->currency->format(($totalrub * $this->config->get($codeforpay . '_komis') / 100) + $totalrub, 'RUB', $this->currency->getValue('RUB'), false);
    } else {
      $youpayment = $this->currency->format($totalrub, 'RUB', $this->currency->getValue('RUB'), false);
    }

    $payments = number_format($paySum, 2);
    $youpayment = number_format($youpayment, 2);

    if ($youpayment == $payments) {
      return true;
    } else {
      $this->log->write('YandexUr Error in order ' . $order_info['order_id'] . ': Amount of payment not equal');
      return false;
    }

  }

  private function statusAlgo($order_info, $codeforpay, $checkstatus, $status) {

    $this->model_account_yandexur->updatePaymentStatus($order_info, $checkstatus->payment_method->id, $status, $checkstatus->amount->value, $checkstatus->created_at);

    $this->load->model('account/yandexur');

    if ($this->config->get($codeforpay . '_createorder_or_notcreate') && $order_info['order_status_id'] != $this->config->get($codeforpay . '_on_status_id')) {
      $this->language->load('payment/' . $codeforpay);
      if ($this->config->get($codeforpay . '_mail_instruction_attach')) {

        $comment = $this->language->get('text_instruction') . "\n\n";
        $comment .= $this->model_account_yandexur->getCustomFields($order_info, $this->config->get($codeforpay . '_mail_instruction_' . $this->config->get('config_language_id')), $codeforpay);
        $comment = htmlspecialchars_decode($comment);
        $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), $comment, true);
      } else {
        $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), '', true);
      }

      if ($this->config->get($codeforpay . '_success_alert_customer')) {
        if ($this->config->get($codeforpay . '_success_comment_attach')) {
          $message = $this->model_account_yandexur->getCustomFields($order_info, $this->config->get($codeforpay . '_success_comment_' . $this->config->get('config_language_id')), $codeforpay);
          $this->model_checkout_order->update($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), $message, true);
        } else {
          $message = '';
          $this->model_checkout_order->update($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), $message, true);
        }
      }
    } else {

      if ($this->config->get($codeforpay . '_success_alert_customer')) {
        if ($this->config->get($codeforpay . '_success_comment_attach')) {
          $message = $this->model_account_yandexur->getCustomFields($order_info, $this->config->get($codeforpay . '_success_comment_' . $this->config->get('config_language_id')), $codeforpay);
          $this->model_checkout_order->update($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), $message, true);
        } else {
          $message = '';
          $this->model_checkout_order->update($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), $message, true);
        }
      } else {
        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($codeforpay . '_order_status_id'), '', false);
      }

    }

    if ($this->config->get($codeforpay . '_success_alert_admin')) {

      $subject = sprintf(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_info['order_id']);

      // Text
      $this->load->language('account/' . $codeforpay);
      $text = sprintf($this->language->get('success_admin_alert'), $order_info['order_id']) . "\n";
      if ($status == 2) {
        $text = sprintf($this->language->get('waiting_admin_alert'), $order_info['order_id']) . "\n";
      }

      $this->alertMail($subject, $text, $order_info['store_name'], true);
    }

  }

  private function writeStatus($payment_id, $codeforpay = '', $data = '', $paystat = '', $order_info = '') {

    if ($data == '') {
      $data = array();
      $data['ShopID'] = $this->config->get($codeforpay . '_shopId');
    }

    if ($paystat == '') {
      $this->load->model('account/yandexur');
      $inv_id = $this->model_account_yandexur->getPaymentNumById($payment_id);
      $inv_id = $inv_id['num_order'];
      $paystat = $this->model_account_yandexur->getPaymentStatus($inv_id);
      $paystat = $paystat['status'];
    }

    if ($order_info == '') {
      $this->load->model('checkout/order');
      if (!isset($inv_id)) {
        $this->load->model('account/yandexur');
        $inv_id = $this->model_account_yandexur->getPaymentNumById($payment_id);
      }
      $order_info = $this->model_checkout_order->getOrder($inv_id);
    }

    if ($codeforpay == '') {
      if (!isset($order_info)) {
        $this->load->model('checkout/order');
        if (!isset($inv_id)) {
          $this->load->model('account/yandexur');
          $inv_id = $this->model_account_yandexur->getPaymentNumById($payment_id);
        }
        $order_info = $this->model_checkout_order->getOrder($inv_id);
      }
      $codeforpay = $order_info['payment_code'];
    }

    $checkstatus = json_decode($this->manageYaStatus($payment_id, $codeforpay, $data));
    $status = 1;

    if ($checkstatus->status == 'waiting_for_capture' && $paystat == 0) {
      if ($this->checkSum($checkstatus->amount->value, $order_info, $codeforpay) && $checkstatus->metadata->order_id == $order_info['order_id']) {
        if (!$this->config->get($codeforpay . '_twostage')) {
          $this->manageYaStatus($payment_id, $codeforpay, $data, '/capture', true);
        } else {
          $status = 2;
        }
        $this->statusAlgo($order_info, $codeforpay, $checkstatus, $status);
      } else {
        $this->manageYaStatus($payment_id, $codeforpay, $data, '/cancel', true);
        $this->alertMail('YANDEXUR PRO', 'Проверка суммы оплаты и суммы в заказе ' . $order_info['order_id'] . ' не совпала или не совпал заказ с id платежа. Платеж ' . $payment_id . '  был отменен ' . json_encode($checkstatus), 'YANDEXUR PRO', false);
        $checkstatus->status = 'canceled';
      }
    }

    if ($checkstatus->status == 'succeeded' && $paystat == 0) {
      if ($this->checkSum($checkstatus->amount->value, $order_info, $codeforpay) && $checkstatus->metadata->order_id == $order_info['order_id']) {
        $this->statusAlgo($order_info, $codeforpay, $checkstatus, $status);
      } else {
        $this->alertMail('YANDEXUR PRO', 'Проверка суммы оплаты и суммы в заказе ' . $order_info['order_id'] . ' не совпала или не совпал заказ с id платежа. Статус заказа не был изменен в магазине. Платеж ' . $payment_id . ' зачислен в кабинет Яндекс.Кассы ' . json_encode($checkstatus), 'YANDEXUR PRO', false);
        $checkstatus->status = 'canceled';
      }
    }

    if ($checkstatus->status == 'succeeded' && $paystat == 2) {
      $this->statusAlgo($order_info, $codeforpay, $checkstatus, $status);
    }

    return $checkstatus;

  }

  public function status() {
    if (isset($this->request->get['code']) && isset($this->request->get['order'])) {
      if (isset($this->request->get['first'])) {
        $first = '&first=1';
      } else {
        $first = '';
      }
      $this->load->model('checkout/order');
      $this->load->model('account/yandexur');
      $inv_id = (int) $this->request->get['order'];
      $order_info = $this->model_checkout_order->getOrder($inv_id);
      $platp = substr($this->model_account_yandexur->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
      if ($order_info['order_id'] == 0) {$this->redirect($this->url->link('error/not_found'));}
      if ($this->request->get['code'] != $platp) {
        $this->redirect($this->url->link('error/not_found'));
      }
      $paystat = $this->model_account_yandexur->getStatusAndId($inv_id);
      $codeforpay = $order_info['payment_code'];
      if (!isset($paystat['status'])) {$paystat['status'] = 0;}

      if ($paystat['status'] != 1) {

        if ($this->config->get($codeforpay . '_capture')) {
          $checkstatus = $this->writeStatus($paystat['sender'], $codeforpay, $data = '', $paystat['status'], $order_info);
        } else {
          $checkstatus = json_decode($this->manageYaStatus($paystat['sender'], $codeforpay));
          //$checkstatus = $this->writeStatus($paystat['sender'], $codeforpay, $data = '', $paystat['status'], $order_info);
        }
        if ($checkstatus->status != 'canceled') {
          if ($this->config->get($codeforpay . '_returnpage')) {
            $this->redirect($this->url->link('checkout/success', 'order_id=' . $inv_id . $first, 'SSL'));
          } else {
            $this->redirect($this->url->link('account/yandexur/success', 'order=' . $inv_id . $first, 'SSL'));
          }
        } else {
          if ($this->config->get($codeforpay . '_returnpage')) {
            $this->redirect($this->url->link('checkout/failure', 'order_id=' . $inv_id . $first, 'SSL'));
          } else {
            $this->redirect($this->url->link('account/yandexur/fail', 'order=' . $inv_id . $first, 'SSL'));
          }
        }
      } else {
        if ($this->config->get($codeforpay . '_returnpage')) {
          $this->redirect($this->url->link('checkout/success', 'order_id=' . $inv_id . $first, 'SSL'));
        } else {
          $this->redirect($this->url->link('account/yandexur/success', 'order=' . $inv_id . $first, 'SSL'));
        }
      }

    } else {
      $this->redirect($this->url->link('error/not_found'));
    }
  }

  private function erConstructor($place, $enum, $text) {
    $result = array(
      'type' => $enum,
      'description' => 'YandexUr Error in ' . $place . ': ' . $text,
    )
    ;

    $this->log->write($result['description']);

    return json_encode($result);

  }

  private function getGUID() {
    if (function_exists('com_create_guid') === true) {
      return trim(com_create_guid(), '{}');
    }

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  public function callbackapi() {

    echo 'OK';

    $res = json_decode(file_get_contents('php://input'));

    if (isset($res->object->metadata->order_id)) {
      $this->load->model('checkout/order');
      $this->load->model('account/yandexur');
      $order_info = $this->model_checkout_order->getOrder((int)$res->object->metadata->order_id);
      $paystat = $this->model_account_yandexur->getPaymentStatus((int)$order_info['order_id']);
      if (isset($paystat['status'])){
        if (isset($res->event) && $res->event == 'payment.succeeded'){
          if ($res->object->payment_method->type == 'b2b_sberbank') {
              $checkstatus = $this->writeStatus($res->object->payment_method->id, $order_info['payment_code'], '', $paystat['status'], $order_info);
          }
        }
        else{
          if (isset($res->object->payment_method->id) && isset($res->event) && $res->event == 'payment.waiting_for_capture') {
            $checkstatus = $this->writeStatus($res->object->payment_method->id, $order_info['payment_code'], '', $paystat['status'], $order_info);
          }
        }
      }
    }

  }

  public function rec () {
    if (isset($this->request->post['code']) && isset($this->request->post['order_id'])) {

      $passport = hash_hmac('sha256', md5((int)$this->request->post['order_id'].$this->request->post['requestName']), $this->config->get('config_encryption'));
      if ($passport == $this->request->post['code']){

        $this->load->model('checkout/order');
        $this->load->model('account/yandexur');
        $order_info = $this->model_checkout_order->getOrder((int)$this->request->post['order_id']);
        $codeforpay = $order_info['payment_code'];
        $payment_id = $this->model_account_yandexur->getPaymentIdByNum($order_info['order_id']);
        //$payment_id = '';

        if ($this->request->post['requestName'] == 'getStatus'){
          
          echo $this->manageYaStatus($payment_id, $codeforpay, '', '', false, false);
        }
        if ($this->request->post['requestName'] == 'cancel'){

          echo $this->manageYaStatus($payment_id, $codeforpay, '', '/cancel', true, false);
        }

        if ($this->request->post['requestName'] == 'capture'){

          echo $this->manageYaStatus($payment_id, $codeforpay, '', '/capture', true, false);

        }
      }
      else{
        $this->load->controller('error/not_found');
      }
    }
    else{
      $this->load->controller('error/not_found');
    }
    
  }


}
?>
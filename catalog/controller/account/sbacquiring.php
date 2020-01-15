<?php

class ControllerAccountsbacquiring extends Controller
{
    private $error = array();

    public function index() {
        $this->load->model('account/sbacquiring');

        $yu_codes = $this->model_account_sbacquiring->getPayMethods();

        if (isset($this->request->get['code']) & isset($this->request->get['order_id'])) {

            $inv_id = $this->request->get['order_id'];

            $this->load->model('checkout/order');
            $this->load->model('account/order');

            $order_info = $this->model_checkout_order->getOrder($inv_id);

            $platp = substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

            if ($this->request->get['code'] != $platp) {
                $this->redirect($this->url->link('error/not_found'));
            }

            if ($order_info['order_id'] == 0) {
                $this->redirect($this->url->link('error/not_found'));
            }

            if (!$this->customer->isLogged()) {
                $this->data['back'] = $this->url->link('common/home');
            } else {
                $this->data['back'] = $this->url->link('account/order');
            }

            $action = $this->url->link('account/sbacquiring/pay', '', 'SSL');

            $this->data['merchant_url'] = $action . '&order_id=' . $inv_id . '&paymentType=' . $order_info['payment_code'] . '&code=' . substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

            $this->load->model('account/sbacquiring');

            $paystat = $this->model_account_sbacquiring->getPaymentStatus($inv_id);

            if (!isset($paystat['status'])) {
                $paystat['status'] = 0;
            }

            $this->data['paystat'] = $paystat['status'];

            $this->load->language('account/' . $order_info['payment_code']);

            $this->data['button_pay']    = $this->language->get('button_pay');
            $this->data['button_back']   = $this->language->get('button_back');
            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->document->setTitle($this->language->get('heading_title'));

            if ($paystat['status'] != 1) {
                if (!in_array($order_info['payment_code'], $yu_codes)) {
                    $this->redirect($this->url->link('error/not_found'));
                }

                if ($this->config->get($order_info['payment_code'] . '_fixen')) {
                    if ($this->config->get($order_info['payment_code'] . '_fixen') == 'fix') {
                        $out_summ = $this->config->get($order_info['payment_code'] . '_fixen_amount');
                    } else {
                        $out_summ = $order_info['total'] * $this->config->get($order_info['payment_code'] . '_fixen_amount') / 100;
                    }
                } else {
                    $out_summ = $order_info['total'];
                }

                if ($this->config->get($order_info['payment_code'] . '_hrefpage_text_attach')) {
                    $this->data['hrefpage_text'] = '';
                    $this->data['hrefpage_text'] = $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($order_info['payment_code'] . '_hrefpage_text_' . $this->config->get('config_language_id')));
                } else {
                    $this->data['send_text']  = $this->language->get('send_text');
                    $this->data['send_text2'] = $this->language->get('send_text2');
                    $this->data['inv_id']     = $inv_id;
                    $this->data['out_summ']   = $this->currency->format($out_summ, $order_info['currency_code'], $order_info['currency_value'], true);
                }
            } else {
                $this->data['hrefpage_text'] = $this->language->get('oplachen');
            }

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sbacquiring.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/account/sbacquiring.tpl';
            } else {
                $this->template = 'default/template/account/sbacquiring.tpl';
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
        } else {
            echo "No data";
        }
    }

    public function pay() {
        if (isset($this->request->get['code']) & isset($this->request->get['order_id'])) {
            $this->load->model('checkout/order');
            $this->load->model('account/sbacquiring');
            $order_info = $this->model_checkout_order->getOrder($this->request->get['order_id']);
            $platp      = substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
            if ($this->request->get['code'] != $platp) {
                $this->redirect($this->url->link('error/not_found'));
            }
            $yu_codes = $this->model_account_sbacquiring->getPayMethods();
            if (in_array($this->request->get['paymentType'], $yu_codes)) {
                $codeforpay = $this->request->get['paymentType'];
                $paymentType = $this->config->get($codeforpay . '_methodcode');
                $userName    = $this->config->get($codeforpay . '_userName');
                $password    = htmlspecialchars_decode($this->model_account_sbacquiring->yandecrypt($this->config->get($codeforpay . '_password'), $this->config->get('config_encryption')));
                if ($this->config->get($codeforpay . '_servadr') == 'real') {
                    $server = 'https://securepayments.sberbank.ru/payment/rest/';
                } else if ($this->config->get($codeforpay . '_servadr') == 'self') {
                    $server = $this->config->get($codeforpay . '_servadr_self');
                } else {
                    $server = 'https://3dsec.sberbank.ru/payment/rest/';
                }
                if ($this->config->get($codeforpay . '_met')) {
                    $server .= 'registerPreAuth.do';
                } else {
                    $server .= 'register.do';
                }
                if ($this->config->get($codeforpay . '_bankcurrency')) {
                    $bankcurrency = $this->config->get($codeforpay . '_bankcurrency_self');
                } else {
                    $bankcurrency = '643';
                }
                if (isset($this->request->get['first'])) {
                    $first = '&first=1';
                } else {
                    $first = '';
                }
                if ($this->config->get($codeforpay . '_returnpage')) {
                    $returnUrl = $this->url->link('checkout/success');
                    $failUrl   = $this->url->link('common/home');
                } else {
                    $returnUrl = htmlspecialchars_decode($this->url->link('account/sbacquiring/success') . '&payment_code=' . $codeforpay . '&ordernum=' . $order_info['order_id'] . '&code=' . $platp . $first);
                    $failUrl   = htmlspecialchars_decode($this->url->link('account/sbacquiring/fail') . '&payment_code=' . $codeforpay . '&ordernum=' . $order_info['order_id'] . '&code=' . $platp . $first);
                }
                $this->language->load('account/' . $codeforpay);
                if ($this->config->get('config_store_id') == 0) {
                    $store_name = $this->config->get('config_name');
                } else {
                    $this->load->model('setting/store');
                    $stores = $this->model_setting_store->getStores();
                    foreach ($stores as $store) {
                        if ($this->config->get('config_store_id') == $store['store_id']) {
                            $store_name = $store['name'];
                        }
                    }
                }
                $description = $store_name . ': ' . $this->language->get('pay_order_text_target') . ' ' . $order_info['order_id'];
                if ($this->config->get($codeforpay . '_komis')) {
                    $proc = $this->config->get($codeforpay . '_komis');
                }
                if ($this->config->get($codeforpay . '_fixen')) {
                    if ($this->config->get($codeforpay . '_fixen') == 'fix') {
                        $out_summ = $this->config->get($codeforpay . '_fixen_amount');
                    } else {
                        $out_summ = $order_info['total'] * $this->config->get($codeforpay . '_fixen_amount') / 100;
                    }
                } else {
                    $out_summ = $order_info['total'];
                }
                if (!$this->config->get($codeforpay . '_createorder_or_notcreate')) {
                    if (isset($this->session->data['order_id'])) {
                        if ($this->request->get['order_id'] == $this->session->data['order_id']) {
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
            } else {
                echo 'error: no payment method';
                exit();
            }
            if ($order_info['currency_code'] == $this->config->get('sbacquiring_currency')) {
                $currency_code  = $order_info['currency_code'];
                $currency_value = $order_info['currency_value'];
            } else {
                $currency_code  = $this->config->get('sbacquiring_currency');
                $currency_value = $this->currency->getValue($this->config->get('sbacquiring_currency'));
            }
            if (is_numeric($out_summ)) {
                $totalrub = $out_summ;
                if (isset($proc)) {
                    $amount = $totalcheck = $this->currency->format(($totalrub * $proc / 100) + $totalrub, $currency_code, $currency_value, false);
                } else {
                    $amount = $totalcheck = $this->currency->format($totalrub, $currency_code, $currency_value, false);
                }
            } else {
                echo 'error: no total sum';
                exit();
            }
            $prices    = preg_replace('/\(.*\)/', '', $amount);
            $delimetr  = substr($prices, -3, 1);
            $delimetr2 = substr($prices, -2, 1);
            $price     = preg_replace('/[^\d]/', '', $prices);
            if ($delimetr2 == ',' || $delimetr2 == '.') {
                $amount = $price . '0';
            } else if ($delimetr == ',' || $delimetr == '.') {
                $amount = $price;
            } else {
                $amount = $price . '00';
            }
            if (is_numeric($this->request->get['order_id'])) {
                $orderNumber = $this->request->get['order_id'];
            } else {
                echo 'error: no order id';
                exit();
            }
            $language = $this->language->get('code');
            $currency = '';
            $okassacheck = '';
            // CHECKS ONLINE SERVICE START
            if (!$this->config->get($codeforpay . '_cart')) {
                if ($order_info['email'] != '') {
                    if (!strpos($order_info['email'], '@localhost.net')) {
                        $okassa = array(
                            'customerDetails' => array(
                                'email' => $order_info['email']
                            ), 'cartItems'    => array(
                                'items' => array()
                            )
                        );
                    } else {
                        $okassa = array(
                            'customerDetails' => array(
                                'phone' => "+" . preg_replace('/[^0-9]/', '', $order_info['telephone'])
                            ), 'cartItems'    => array(
                                'items' => array()
                            )
                        );
                    }
                } else {
                    $okassa = array(
                        'customerDetails' => array(
                            'phone' => "+" . preg_replace('/[^0-9]/', '', $order_info['telephone'])
                        ), 'cartItems'    => array(
                            'items' => array()
                        )
                    );
                }
                if ($this->config->get($codeforpay . '_customShip') != '') {
                    $order_info['shipping_method'] = $this->config->get($codeforpay . '_customShip');
                }
                if ($this->config->get($codeforpay . '_customName')) {
                    $customname = $this->config->get($codeforpay . '_customName');
                }
                $this->load->model('account/order');
                $cart_products = $this->model_account_order->getOrderProducts($order_info['order_id']);
                //vouchers
                $vouchersbuy = $this->model_account_order->getOrderVouchers($order_info['order_id']);
                foreach ($vouchersbuy as $voucherbuy) {
                    $cart_products[] = array(
                        'quantity' => 1, 'name' => $voucherbuy['description'], 'price' => $voucherbuy['amount'], 'product_id' => 0
                    );
                }
                //vouchers end
                $totals   = $this->model_account_order->getOrderTotals($order_info['order_id']);
                $tax      = 0;
                $voucher  = 0;
                $shipping = 0;
                $subtotal = 0;
                $coupon   = 0;
                foreach ($totals as $total) {
                    switch ($total['code']) {
                        case 'tax':
                            $tax = $total['value'];
                            break;
                        case 'shipping':
                            $shipping = $total['value'];
                            break;
                        case 'sub_total':
                            $subtotal = $total['value'];
                            break;
                        case 'coupon':
                            $coupon = $total['value'];
                            break;
                        case 'voucher':
                            $voucher = $total['value'];
                            break;
                    }
                }
                // coupon free shipping
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_info['order_id'] . "'");
                if (isset($query->rows)) {
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
                $ndsval = 0;
                if ($this->config->get($codeforpay . '_nds') == 'important') {
                    $ndsval = $this->config->get($codeforpay . '_nds_important');
                }
                if ($this->config->get($codeforpay . '_nds') == 'tovar') {
                    $ndson = true;
                    $this->load->model('catalog/product');
                }
                $posnum = 0;
                $moden       = ($totalcheck - $this->currency->format($shipping, $currency_code, $currency_value, false)) / $this->currency->format($subtotal, $currency_code, $currency_value, false);
                $alldiscount = false;
                foreach ($cart_products as $cart_product) {
                    $option_itemCode = $this->getOptions($order_info['order_id'], $cart_product['order_product_id']);
                    if (isset($customname)) {
                        $res = $this->model_account_sbacquiring->getCustomName($cart_product['product_id'], $customname);
                        if ($res != '') {
                            $cart_product['name'] = $res;
                        }
                    }
                    $tovprice = number_format($this->currency->format($cart_product['price'], $currency_code, $currency_value, false) * $moden, 2, '.', '');
                    if ($tovprice < 0) {
                        $alldiscount = true;
                        break;
                    }
                    $prices    = preg_replace('/\(.*\)/', '', $tovprice);
                    $delimetr  = substr($prices, -3, 1);
                    $delimetr2 = substr($prices, -2, 1);
                    $price     = preg_replace('/[^\d]/', '', $prices);
                    if ($delimetr2 == ',' || $delimetr2 == '.') {
                        $tovprice = $price . '0';
                    } else if ($delimetr == ',' || $delimetr == '.') {
                        $tovprice = $price;
                    } else {
                        $tovprice = $price . '00';
                    }
                    $ndsvalue = $ndsval;
                    if (isset($ndson)) {
                        foreach ($this->config->get($codeforpay . '_classes') as $tax_rule) {
                            $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                            if (isset($tax_rule[$codeforpay . '_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codeforpay . '_nalog'] == $product_info['tax_class_id']) {
                                $ndsvalue = $tax_rule[$codeforpay . '_tax_rule'];
                            }
                        }
                    }
                    $posnum += 1;
                    $okassa['cartItems']['items'][] = array(
                        'positionId'   => $posnum, 'name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0, 100, 'UTF-8'), 'quantity' => array(
                            'value' => $cart_product['quantity'], 'measure' => 'шт',
                        ), 'itemPrice' => $tovprice, 'itemCode' => $cart_product['model'] . $option_itemCode, 'tax' => array(
                            'taxType' => $ndsvalue,
                        ),
                    );
                }
                if ($alldiscount == true) {
                    $posnum = 0;
                    $moden  = $totalcheck / ($this->currency->format($subtotal, $currency_code, $currency_value, false) + $this->currency->format($shipping, $currency_code, $currency_value, false));
                    foreach ($cart_products as $cart_product) {
                        if (isset($customname)) {
                            $res = $this->model_account_sbacquiring->getCustomName($cart_product['product_id'], $customname);
                            if ($res != '') {
                                $cart_product['name'] = $res;
                            }
                        }
                        $tovprice = number_format($this->currency->format($cart_product['price'], $currency_code, $currency_value, false) * $moden, 2, '.', '');
                        $prices    = preg_replace('/\(.*\)/', '', $tovprice);
                        $delimetr  = substr($prices, -3, 1);
                        $delimetr2 = substr($prices, -2, 1);
                        $price     = preg_replace('/[^\d]/', '', $prices);
                        if ($delimetr2 == ',' || $delimetr2 == '.') {
                            $tovprice = $price . '0';
                        } else if ($delimetr == ',' || $delimetr == '.') {
                            $tovprice = $price;
                        } else {
                            $tovprice = $price . '00';
                        }
                        $ndsvalue = $ndsval;
                        if (isset($ndson)) {
                            foreach ($this->config->get($codeforpay . '_classes') as $tax_rule) {
                                $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                                if (isset($tax_rule[$codeforpay . '_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codeforpay . '_nalog'] == $product_info['tax_class_id']) {
                                    $ndsvalue = $tax_rule[$codeforpay . '_tax_rule'];
                                }
                            }
                        }
                        $posnum += 1;
                        $okassa['cartItems']['items'][] = array(
                            'positionId'   => $posnum, 'name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0, 100, 'UTF-8'), 'quantity' => array(
                                'value' => $cart_product['quantity'], 'measure' => 'шт',
                            ), 'itemPrice' => $tovprice, 'itemCode' => $cart_product['model'] . $option_itemCode, 'tax' => array(
                                'taxType' => $ndsvalue,
                            ),
                        );
                    }
                    if ($shipping >= 0 && $order_info['shipping_code'] != '') {
                        $posnum += 1;
                        $shipping1 = number_format($this->currency->format($shipping, $currency_code, $currency_value, false) * $moden, 2, '.', '');
                        $prices    = preg_replace('/\(.*\)/', '', $shipping1);
                        $delimetr  = substr($prices, -3, 1);
                        $delimetr2 = substr($prices, -2, 1);
                        $price     = preg_replace('/[^\d]/', '', $prices);
                        if ($delimetr2 == ',' || $delimetr2 == '.') {
                            $shipping1 = $price . '0';
                        } else if ($delimetr == ',' || $delimetr == '.') {
                            $shipping1 = $price;
                        } else {
                            $shipping1 = $price . '00';
                        }
                        $okassa['cartItems']['items'][] = array(
                            'positionId'   => $posnum, 'name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0, 100, 'UTF-8'), 'quantity' => array(
                                'value' => 0, 'measure' => 'шт',
                            ), 'itemPrice' => $shipping1, 'itemCode' => $order_info['shipping_code'], 'tax' => array(
                                'taxType' => 0
                            ),
                        );
                    }
                }
                //kopeyka wars
                $checkitogo = 0;
                foreach ($okassa['cartItems']['items'] as $okas) {
                    $checkitogo += $okas['quantity']['value'] * $okas['itemPrice'];
                }
                if ($alldiscount == true) {
                    $proverkacheck = number_format($amount - $checkitogo, 2, '.', '');
                } else {
                    $shipping1 = number_format($this->currency->format($shipping, $currency_code, $currency_value, false), 2, '.', '');
                    $prices    = preg_replace('/\(.*\)/', '', $shipping1);
                    $delimetr  = substr($prices, -3, 1);
                    $delimetr2 = substr($prices, -2, 1);
                    $price     = preg_replace('/[^\d]/', '', $prices);
                    if ($delimetr2 == ',' || $delimetr2 == '.') {
                        $shipping1 = $price . '0';
                    } else if ($delimetr == ',' || $delimetr == '.') {
                        $shipping1 = $price;
                    } else {
                        $shipping1 = $price . '00';
                    }
                    $proverkacheck = number_format($amount - $this->currency->format($shipping1, $currency_code, $currency_value, false) - $checkitogo, 2, '.', '');
                }
                if ($proverkacheck == -0.01 || $proverkacheck == 0.01 || $proverkacheck == 0.02 || $proverkacheck == -0.02 || $proverkacheck == -0.03 || $proverkacheck == 0.03 || $proverkacheck == 0.04 || $proverkacheck == -0.04 || $proverkacheck > 1 || $proverkacheck <= 1 && $proverkacheck != 0.00) {
                    if ($proverkacheck == -0.01) {
                        $correctsum = -0.01;
                    } else if ($proverkacheck == 0.01) {
                        $correctsum = 0.01;
                    } else if ($proverkacheck == 0.02) {
                        $correctsum = 0.02;
                    } else if ($proverkacheck == -0.02) {
                        $correctsum = -0.02;
                    } else if ($proverkacheck == -0.03) {
                        $correctsum = -0.03;
                    } else if ($proverkacheck == 0.03) {
                        $correctsum = 0.03;
                    } else if ($proverkacheck == 0.04) {
                        $correctsum = 0.04;
                    } else if ($proverkacheck == -0.04) {
                        $correctsum = -0.04;
                    } else if ($proverkacheck > 1) {
                        $correctsum = $proverkacheck;
                    } else if ($proverkacheck <= 1 && $proverkacheck != 0.00) {
                        $correctsum = $proverkacheck;
                    }
                    $itemnum = -1;
                    $kopwar  = false;
                    foreach ($okassa['cartItems']['items'] as $item) {
                        $itemnum += 1;
                        if ($item['quantity']['value'] == 1 && $item['itemPrice'] > 0) {
                            $okassa['cartItems']['items'][$itemnum]['itemPrice'] = $okassa['cartItems']['items'][$itemnum]['itemPrice'] + $correctsum;
                            $kopwar                                              = true;
                            break;
                        }
                    }
                    if ($kopwar == false) {
                        foreach ($okassa['cartItems']['items'] as $item) {
                            if ($item['itemPrice'] > 0) {
                                $okassa['cartItems']['items'][0]['quantity']['value'] -= 1;
                                $posnum += 1;
                                $copyprod[] = array(
                                    'positionId'   => $posnum, 'name' => $okassa['cartItems']['items'][0]['name'], 'quantity' => array(
                                        'value' => 1, 'measure' => 'шт',
                                    ), 'itemPrice' => $okassa['cartItems']['items'][0]['itemPrice'] + $correctsum, 'itemCode' => $okassa['cartItems']['items'][0]['itemCode'] . '~COPY', 'tax' => array(
                                        'taxType' => $okassa['cartItems']['items'][0]['tax']['taxType'],
                                    ),
                                );
                                array_splice($okassa['cartItems']['items'], 1, 0, $copyprod);
                                $kopwar = true;
                                break;
                            }
                        }
                    }
                }
                //kopeyka wars end
                if ($shipping >= 0 && $alldiscount == false && $order_info['shipping_code'] != '') {
                    $posnum += 1;
                    $shipping1 = number_format($this->currency->format($shipping, $currency_code, $currency_value, false), 2, '.', '');
                    $prices    = preg_replace('/\(.*\)/', '', $shipping1);
                    $delimetr  = substr($prices, -3, 1);
                    $delimetr2 = substr($prices, -2, 1);
                    $price     = preg_replace('/[^\d]/', '', $prices);
                    if ($delimetr2 == ',' || $delimetr2 == '.') {
                        $shipping1 = $price . '0';
                    } else if ($delimetr == ',' || $delimetr == '.') {
                        $shipping1 = $price;
                    } else {
                        $shipping1 = $price . '00';
                    }
                    if ($shipping1 != '000') {
                        $okassa['cartItems']['items'][] = array(
                            'positionId'   => $posnum, 'name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0, 100, 'UTF-8'), 'quantity' => array(
                                'value' => 1, 'measure' => 'шт',
                            ), 'itemPrice' => $shipping1, 'itemCode' => $order_info['shipping_code'], 'tax' => array(
                                'taxType' => 0
                            ),
                        );
                    }

                }
                $okassacheck = json_encode($okassa);
                if ($this->config->get($codeforpay . '_debug')) {
                    echo '<br/>--------------Товары---------------------------------------<br/>';
                    var_dump($cart_products);
                    echo '<br/><br/>--------------Учитывать-в-заказе---------------------------<br/>';
                    var_dump($totals);
                    echo '<br/><br/>--------------В-чек----------------------------------------<br/>';
                    var_dump($okassa);
                    echo '<br/><br/>-----------------------------------------------------------<br/>';
                    echo '<br/>--------------Онлайн Чек (Позиции для отладки)-------------<br/>';
                    $numpos = 0;
                    $itogo  = 0;
                    $ondsrules = array(
                        array(
                            'id' => 0, 'name' => 'Без НДС'
                        ), array(
                            'id' => 1, 'name' => 'НДС 0%'
                        ), array(
                            'id' => 2, 'name' => 'НДС 10%'
                        ), array(
                            'id' => 3, 'name' => 'НДС 18%'
                        ), array(
                            'id' => 4, 'name' => 'НДС 10/110'
                        ), array(
                            'id' => 5, 'name' => 'НДС 18/118'
                        )
                    );
                    echo '<table>';
                    foreach ($okassa['cartItems']['items'] as $okas) {
                        $numpos += 1;
                        $itogo += $okas['quantity']['value'] * $okas['itemPrice'];
                        $otax = $ondsrules[$okas['tax']['taxType']]['name'];
                        echo '<tr><td>';
                        echo $numpos . '.</td><td>' . $okas['name'] . '</td><td>' . $okas['quantity']['value'] . ' * ' . $okas['itemPrice'] . '</td><td>' . '   =   ' . $okas['quantity']['value'] * $okas['itemPrice'] . '</td></tr>';
                        echo '<tr><td></td><td>' . $otax . '</td></tr>';
                    }
                    echo '<tr></tr><tr><td></td><td>ИТОГ в Копейках: </td><td></td><td> = ' . $itogo . '</td></tr>';
                    echo '<tr></tr><tr><td></td><td>ИТОГ: </td><td></td><td> = ' . ($itogo / 100) . '</td></tr>';
                    echo '</table>';
                }
            }
            // CHECKS ONLINE SERVICE END
            if (isset($this->request->get['first'])) {
                $first = 'first-';
            } else {
                $first = '';
            }
            $ordercompromis = $order_info['order_id'] . '-' . $first . time();
            $jsonParams = array();
            if ($order_info['email'] != '') {
                $jsonParams['email'] = mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['email'])))), 0, 100, 'UTF-8');
            }
            $jsonParams['payment_code'] = $codeforpay;
            if (isset($this->request->get['first'])) {
                $jsonParams['first'] = '1';
            }
            $jsonParams = json_encode($jsonParams);
            if ($this->config->get($codeforpay . '_debug')) {
                echo '<br/>';
                echo 'userName => ' . $userName . '<br/>';
                echo 'password => ' . $password . '<br/>';
                echo 'orderNumber => ' . $ordercompromis . '<br/>';
                echo 'amount => ' . $amount . '<br/>';
                echo 'returnUrl => ' . $returnUrl . '<br/>';
                echo 'failUrl => ' . $failUrl . '<br/>';
                echo 'description => ' . $description . '<br/>';
                echo 'currency => ' . $bankcurrency . '<br/>';
                echo 'orderBundle => ' . $okassacheck . '<br/>';
                echo 'jsonParams => ' . $jsonParams . '<br/>';
                echo 'language => ' . $language;
                exit();
            }
            $postdata = http_build_query(array(
                                             'userName' => $userName, 'password' => $password, 'orderNumber' => $ordercompromis, 'amount' => $amount, 'returnUrl' => $returnUrl, 'failUrl' => $failUrl, 'description' => $description, 'currency' => $bankcurrency, 'orderBundle' => $okassacheck, 'language' => $language, 'jsonParams' => $jsonParams
                                         ));
            if ($this->config->get($codeforpay . '_zapros')) {
                $opts = array(
                    'http' => array(
                        'method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata
                    )
                );
                $context = stream_context_create($opts);
                $result  = file_get_contents($server, false, $context);
            } else {
                if ($curl = curl_init()) {
                    curl_setopt($curl, CURLOPT_URL, $server);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                    $result = curl_exec($curl);
                    curl_close($curl);
                } else {
                    $this->log->write('SberBank error: No curl library in host');
                    echo 'Server Error';
                    exit();
                }
            }
            $result = json_decode($result);
            if (isset($result->formUrl)) {
                $this->session->data['sbacquiring'] = $result->orderId . '~' . $ordercompromis;
                $this->redirect($result->formUrl);
            } else {
                $result = (array)$result;
                $this->log->write('SberBank error: code=' . implode(' - ', $result));
                echo 'No data';
            }
        } else {
            $this->redirect($this->url->link('error/not_found'));
        }
    }

    private function getOptions($order_id, $order_product_id) {
        $for_itemCode = array();
        $options = $this->model_account_order->getOrderOptions($order_id, $order_product_id);
        foreach ($options as $option) {
            if ($option['type'] != 'file') {
                $value = $option['value'];
            } else {
                $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
            }
            /*
            $option_data[] = array(
              'name'  => $option['name'],
              'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
            );*/
            $for_itemCode[] = $option['product_option_id'] . $value;
        }
        if (sizeof($for_itemCode)) {
            $option_itemCode = '&' . hash('crc32b', implode(",", $for_itemCode));
        } else {
            $option_itemCode = '';
        }

        return $option_itemCode;
    }

    public function callback() {
        if (isset($this->request->get['orderNumber']) && isset($this->request->get['operation'])) {
            $this->load->model('account/sbacquiring');
            $this->load->model('checkout/order');
            $sbacquiring_order = explode('-', $this->request->get['orderNumber']);
            $ordernum          = $sbacquiring_order[0];
            if ($sbacquiring_order[0] == 'approved') {
                echo 'approved';
                exit();
            }
            $order_info  = $this->model_checkout_order->getOrder($ordernum);
            $paymentcode = $order_info['payment_code'];
            $paystat     = $this->model_account_sbacquiring->getPaymentStatus($ordernum);
            if (!isset($paystat['status'])) {
                $paystat['status'] = 0;
            }
            if ($paystat['status'] != 1) {
                if ($this->request->get['operation'] == 'deposited' && $this->request->get['status'] == 1 && !$this->config->get($paymentcode . '_met') || $this->request->get['operation'] == 'approved' && $this->request->get['status'] == 1) {
                    $userName = $this->config->get($paymentcode . '_userName');
                    $password = htmlspecialchars_decode($this->model_account_sbacquiring->yandecrypt($this->config->get($paymentcode . '_password'), $this->config->get('config_encryption')));
                    if ($this->config->get($paymentcode . '_servadr') == 'real') {
                        $server = 'https://securepayments.sberbank.ru/payment/rest/';
                    } else if ($this->config->get($paymentcode . '_servadr') == 'self') {
                        $server = $this->config->get($paymentcode . '_servadr_self');
                    } else {
                        $server = 'https://3dsec.sberbank.ru/payment/rest/';
                    }
                    $server .= 'getOrderStatus.do';
                    $language = $this->language->get('code');
                    $postdata = http_build_query(array(
                                                     'userName' => $userName, 'password' => $password, 'orderId' => $this->request->get['mdOrder'], 'language' => $language
                                                 ));
                    if ($this->config->get($paymentcode . '_zapros')) {
                        $opts = array(
                            'http' => array(
                                'method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata
                            )
                        );
                        $context = stream_context_create($opts);
                        $result  = file_get_contents($server, false, $context);
                    } else {
                        if ($curl = curl_init()) {
                            curl_setopt($curl, CURLOPT_URL, $server);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                            $result = curl_exec($curl);
                            curl_close($curl);
                        } else {
                            $this->log->write('SberBank error: No curl');
                            exit();
                        }
                    }
                    $result = json_decode($result);
                    if (isset($result->OrderStatus)) {
                        if ($result->OrderStatus == 2 || $result->OrderStatus == 1) {
                            $payOK = 1;
                        }
                    } else {
                        $result = (array)$result;
                        $this->log->write('SberBank error: code=' . implode(' - ', $result));
                        echo 'No data';
                        exit();
                    }
                } else {
                    echo 'No data';
                    exit();
                }
                if (isset($payOK)) {
                    if ($order_info['currency_code'] == $this->config->get('sbacquiring_currency')) {
                        $currency_code  = $order_info['currency_code'];
                        $currency_value = $order_info['currency_value'];
                    } else {
                        $currency_code  = $this->config->get('sbacquiring_currency');
                        $currency_value = $this->currency->getValue($this->config->get('sbacquiring_currency'));
                    }
                    if ($this->config->get($paymentcode . '_fixen')) {
                        if ($this->config->get($paymentcode . '_fixen') == 'fix') {
                            $totalrub = $this->config->get($paymentcode . '_fixen_amount');
                        } else {
                            $totalrub = $order_info['total'] * $this->config->get($paymentcode . '_fixen_amount') / 100;
                        }
                    } else {
                        $totalrub = $order_info['total'];
                    }
                    if ($this->config->get($paymentcode . '_komis')) {
                        $youpayment = $this->currency->format(($totalrub * $this->config->get($paymentcode . '_komis') / 100) + $totalrub, $currency_code, $currency_value, false);
                    } else {
                        $youpayment = $this->currency->format($totalrub, $currency_code, $currency_value, false);
                    }
                    $payments  = $result->Amount;
                    $amount    = $youpayment;
                    $prices    = preg_replace('/\(.*\)/', '', $amount);
                    $delimetr  = substr($prices, -3, 1);
                    $delimetr2 = substr($prices, -2, 1);
                    $price     = preg_replace('/[^\d]/', '', $prices);
                    if ($delimetr2 == ',' || $delimetr2 == '.') {
                        $amount = $price . '0';
                    } else if ($delimetr == ',' || $delimetr == '.') {
                        $amount = $price;
                    } else {
                        $amount = $price . '00';
                    }
                    if ($amount == $payments) {
                        if ($payments) {
                            $query = $this->db->query("INSERT INTO `" . DB_PREFIX . "sbacquiring` SET `num_order` = '" . (int)$order_info['order_id'] . "' , `sum` = '" . $this->db->escape($youpayment) . "' , `date_enroled` = NOW(), `date_created` = '" . $this->db->escape($order_info['date_added']) . "', `user` = '" . $this->db->escape($order_info['payment_firstname']) . " " . $this->db->escape($order_info['payment_lastname']) . "', `email` = '" . $this->db->escape($order_info['email']) . "', `status` = '1', `sender` = '" . $this->db->escape($this->request->get['mdOrder']) . "' ");
                            if ($this->config->get($paymentcode . '_createorder_or_notcreate') && $order_info['order_status_id'] != $this->config->get($paymentcode . '_on_status_id')) {
                                $this->language->load('payment/' . $paymentcode);
                                if ($this->config->get($paymentcode . '_mail_instruction_attach')) {
                                    $comment = $this->language->get('text_instruction') . "\n\n";
                                    $comment .= $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_mail_instruction_' . $this->config->get('config_language_id')));
                                    $comment = htmlspecialchars_decode($comment);
                                    $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $comment, true);
                                } else {
                                    $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), true);
                                }
                                if ($this->config->get($paymentcode . '_success_alert_customer')) {
                                    if ($this->config->get($paymentcode . '_success_comment_attach')) {
                                        $message = $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_success_comment_' . $this->config->get('config_language_id')));
                                        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                    } else {
                                        $message = '';
                                        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                    }
                                }
                            } else {
                                if ($this->config->get($paymentcode . '_success_alert_customer')) {
                                    if ($this->config->get($paymentcode . '_success_comment_attach')) {
                                        $message = $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_success_comment_' . $this->config->get('config_language_id')));
                                        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                    } else {
                                        $message = '';
                                        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                    }
                                } else {
                                    $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), false);
                                }
                            }
                            if ($this->config->get($paymentcode . '_success_alert_admin')) {
                                $subject = sprintf(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_info['order_id']);
                                // Text
                                $this->load->language('account/' . $paymentcode);
                                $text = sprintf($this->language->get('success_admin_alert'), $order_info['order_id']) . "\n";
                                $mail            = new Mail();
                                $mail->protocol  = $this->config->get('config_mail_protocol');
                                $mail->parameter = $this->config->get('config_mail_parameter');
                                $mail->hostname  = $this->config->get('config_smtp_host');
                                $mail->username  = $this->config->get('config_smtp_username');
                                $mail->password  = $this->config->get('config_smtp_password');
                                $mail->port      = $this->config->get('config_smtp_port');
                                $mail->timeout   = $this->config->get('config_smtp_timeout');
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
                        } else {
                            $this->log->write('SberBank error: ups!');
                        }
                    } else {
                        $this->log->write('SberBank error: Amount of payment not equal');
                    }
                } else {
                    echo "No Data";
                }
            }
        } else {
            echo 'CALLBACK OK';
        }
    }

    public function success() {
        if (isset($this->request->get['orderId']) && isset($this->request->get['payment_code']) && isset($this->request->get['ordernum']) && isset($this->request->get['code'])) {
            $this->load->model('checkout/order');
            $this->load->model('account/sbacquiring');
            $yu_codes = $this->model_account_sbacquiring->getPayMethods();
            if (in_array($this->request->get['payment_code'], $yu_codes)) {
                $paymentcode = $this->request->get['payment_code'];
                if (isset($this->request->get['first'])) {
                    $first = 1;
                }
                $order_info = $this->model_checkout_order->getOrder((int)$this->request->get['ordernum']);
                $platp      = substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
                if ($this->request->get['code'] != $platp) {
                    $this->redirect($this->url->link('error/not_found'));
                }
            } else {
                echo 'No order';
                exit();
            }
        } else {
            echo 'No order';
            exit();
        }
        if (!$this->config->get('sbacquiring_callbackemulate')) {
            // CALLBACK EMULATE
            if ($this->config->get($paymentcode . '_servadr') == 'real') {
                $server = 'https://securepayments.sberbank.ru/payment/rest/';
            } else if ($this->config->get($paymentcode . '_servadr') == 'self') {
                $server = $this->config->get($paymentcode . '_servadr_self');
            } else {
                $server = 'https://3dsec.sberbank.ru/payment/rest/';
            }
            $server .= 'getOrderStatus.do';
            $ordernum = (int)$this->request->get['ordernum'];
            $paystat  = $this->model_account_sbacquiring->getPaymentStatus($ordernum);
            if (!isset($paystat['status'])) {
                $paystat['status'] = 0;
            }
            if ($paystat['status'] != 1) {
                if (isset($this->request->get['orderId'])) {
                    $userName = $this->config->get($paymentcode . '_userName');
                    $password = htmlspecialchars_decode($this->model_account_sbacquiring->yandecrypt($this->config->get($paymentcode . '_password'), $this->config->get('config_encryption')));
                    $language = $this->language->get('code');
                    $postdata = http_build_query(array(
                                                     'userName' => $userName, 'password' => $password, 'orderId' => $this->request->get['orderId'], 'language' => $language
                                                 ));
                    if ($this->config->get($paymentcode . '_zapros')) {
                        $opts = array(
                            'http' => array(
                                'method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata
                            )
                        );
                        $context = stream_context_create($opts);
                        $result  = file_get_contents($server, false, $context);
                    } else {
                        if ($curl = curl_init()) {
                            curl_setopt($curl, CURLOPT_URL, $server);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                            $result = curl_exec($curl);
                            curl_close($curl);
                        } else {
                            $this->log->write('sbank error: No curl');
                            exit();
                        }
                    }
                    $result = json_decode($result);
                    if (isset($result->OrderStatus)) {
                        if ($result->OrderStatus == 2 || $result->OrderStatus == 1) {
                            $payOK = 1;
                        }
                    } else {
                        $result = (array)$result;
                        if (implode(' - ', $result) == '7 - Заказ находится в обработке. Пожалуйста, попробуйте позднее') {
                            if ($curl = curl_init()) {
                                curl_setopt($curl, CURLOPT_URL, $server);
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($curl, CURLOPT_POST, true);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $forcurlpost);
                                $result = curl_exec($curl);
                                curl_close($curl);
                            } else {
                                $this->log->write('sbank error: No curl');
                                exit();
                            }
                            $result = json_decode($result);
                            if (isset($result->OrderStatus)) {
                                if ($result->OrderStatus == 2 || $result->OrderStatus == 1) {
                                    $payOK = 1;
                                }
                            } else {
                                $this->log->write('sbank error: code=' . implode(' - ', $result));
                                echo 'No data';
                                exit();
                            }
                        } else {
                            $this->log->write('sbank error: code=' . implode(' - ', $result));
                            echo 'No data';
                            exit();
                        }
                    }
                } else {
                    echo 'No data';
                    exit();
                }
                $paystat = $this->model_account_sbacquiring->getPaymentStatus($ordernum);
                if (!isset($paystat['status'])) {
                    $paystat['status'] = 0;
                }
                if ($paystat['status'] != 1) {
                    if (isset($payOK)) {
                        if ($order_info['currency_code'] == $this->config->get('sbacquiring_currency')) {
                            $currency_code  = $order_info['currency_code'];
                            $currency_value = $order_info['currency_value'];
                        } else {
                            $currency_code  = $this->config->get('sbacquiring_currency');
                            $currency_value = $this->currency->getValue($this->config->get('sbacquiring_currency'));
                        }
                        if ($this->config->get($paymentcode . '_fixen')) {
                            if ($this->config->get($paymentcode . '_fixen') == 'fix') {
                                $totalrub = $this->config->get($paymentcode . '_fixen_amount');
                            } else {
                                $totalrub = $order_info['total'] * $this->config->get($paymentcode . '_fixen_amount') / 100;
                            }
                        } else {
                            $totalrub = $order_info['total'];
                        }
                        if ($this->config->get($paymentcode . '_komis')) {
                            $youpayment = $this->currency->format(($totalrub * $this->config->get($paymentcode . '_komis') / 100) + $totalrub, $currency_code, $currency_value, false);
                        } else {
                            $youpayment = $this->currency->format($totalrub, $currency_code, $currency_value, false);
                        }
                        $payments  = $result->Amount;
                        $amount    = $youpayment;
                        $prices    = preg_replace('/\(.*\)/', '', $amount);
                        $delimetr  = substr($prices, -3, 1);
                        $delimetr2 = substr($prices, -2, 1);
                        $price     = preg_replace('/[^\d]/', '', $prices);
                        if ($delimetr2 == ',' || $delimetr2 == '.') {
                            $amount = $price . '0';
                        } else if ($delimetr == ',' || $delimetr == '.') {
                            $amount = $price;
                        } else {
                            $amount = $price . '00';
                        }
                        if ($amount == $payments) {
                            if ($payments) {
                                $query = $this->db->query("INSERT INTO `" . DB_PREFIX . "sbacquiring` SET `num_order` = '" . (int)$order_info['order_id'] . "' , `sum` = '" . $this->db->escape($youpayment) . "' , `date_enroled` = NOW(), `date_created` = '" . $this->db->escape($order_info['date_added']) . "', `user` = '" . $this->db->escape($order_info['payment_firstname']) . " " . $this->db->escape($order_info['payment_lastname']) . "', `email` = '" . $this->db->escape($order_info['email']) . "', `status` = '1', `sender` = '" . $this->db->escape($this->request->get['orderId']) . "' ");
                                if ($this->config->get($paymentcode . '_createorder_or_notcreate') && $order_info['order_status_id'] != $this->config->get($paymentcode . '_on_status_id')) {
                                    $this->language->load('payment/' . $paymentcode);
                                    if ($this->config->get($paymentcode . '_mail_instruction_attach')) {
                                        $comment = $this->language->get('text_instruction') . "\n\n";
                                        $comment .= $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_mail_instruction_' . $this->config->get('config_language_id')));
                                        $comment = htmlspecialchars_decode($comment);
                                        $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $comment, true);
                                    } else {
                                        $this->model_checkout_order->confirm($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), true);
                                    }
                                    if ($this->config->get($paymentcode . '_success_alert_customer')) {
                                        if ($this->config->get($paymentcode . '_success_comment_attach')) {
                                            $message = $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_success_comment_' . $this->config->get('config_language_id')));
                                            $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                        } else {
                                            $message = '';
                                            $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                        }
                                    }
                                } else {
                                    if ($this->config->get($paymentcode . '_success_alert_customer')) {
                                        if ($this->config->get($paymentcode . '_success_comment_attach')) {
                                            $message = $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_success_comment_' . $this->config->get('config_language_id')));
                                            $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                        } else {
                                            $message = '';
                                            $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), $message, true);
                                        }
                                    } else {
                                        $this->model_checkout_order->update($order_info['order_id'], $this->config->get($paymentcode . '_order_status_id'), false);
                                    }
                                }
                                if ($this->config->get($paymentcode . '_success_alert_admin')) {
                                    $subject = sprintf(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_info['order_id']);
                                    // Text
                                    $this->load->language('account/' . $paymentcode);
                                    $text = sprintf($this->language->get('success_admin_alert'), $order_info['order_id']) . "\n";
                                    $mail            = new Mail();
                                    $mail->protocol  = $this->config->get('config_mail_protocol');
                                    $mail->parameter = $this->config->get('config_mail_parameter');
                                    $mail->hostname  = $this->config->get('config_smtp_host');
                                    $mail->username  = $this->config->get('config_smtp_username');
                                    $mail->password  = $this->config->get('config_smtp_password');
                                    $mail->port      = $this->config->get('config_smtp_port');
                                    $mail->timeout   = $this->config->get('config_smtp_timeout');
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
                            } else {
                                $this->log->write('SberBank error: ups!');
                            }
                        } else {
                            $this->log->write('SberBank error: Amount of payment not equal');
                        }
                    }
                }
            }
            // CALLBACK EMULATE END
        }
        if ($order_info['order_id']) {
            $inv_id               = $order_info['order_id'];
            $this->data['inv_id'] = $order_info['order_id'];
            $action     = $this->url->link('account/sbacquiring');
            $online_url = $action . '&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
            $this->data['success_text'] = '';
            $paymentcode = $order_info['payment_code'];
            if ($this->config->get($paymentcode . '_fixen')) {
                if ($this->config->get($paymentcode . '_fixen') == 'fix') {
                    $out_summ = $this->config->get($paymentcode . '_fixen_amount');
                } else {
                    $out_summ = $order_info['total'] * $this->config->get($paymentcode . '_fixen_amount') / 100;
                }
            } else {
                $out_summ = $order_info['total'];
            }
            $this->load->language('account/' . $paymentcode);
            $this->data['heading_title'] = $this->language->get('heading_title');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->data['button_ok'] = $this->language->get('button_ok');
            //if ($order_info['order_status_id'] == $this->config->get($paymentcode.'_order_status_id')) {
            if (true) {
                if (isset($first)) {
                    $this->data['success_text'] .= $this->language->get('success_text_first');
                }
                if ($this->config->get($paymentcode . '_createorder_or_notcreate') && isset($first)) {
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
                if ($this->config->get($paymentcode . '_success_page_text_attach')) {
                    $this->data['success_text'] .= $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_success_page_text_' . $this->config->get('config_language_id')));
                } else {
                    $this->data['success_text'] .= sprintf($this->language->get('success_text'), $inv_id);
                }
            } else {
                if (isset($first) && $order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                    $this->data['success_text'] .= $this->language->get('success_text_first');
                }
                if ($this->config->get($paymentcode . '_waiting_page_text_attach')) {
                    $this->data['success_text'] .= $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_waiting_page_text_' . $this->config->get('config_language_id')));
                } else {
                    if ($order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                        $this->data['success_text'] .= sprintf($this->language->get('success_text_wait'), $inv_id, $online_url);
                    } else {
                        $this->data['success_text'] .= sprintf($this->language->get('success_text_wait_noorder'), $online_url);
                    }
                }
            }
            if ($this->customer->isLogged()) {
                if (!$this->config->get($paymentcode . '_createorder_or_notcreate')) {
                    $this->data['success_text'] .= sprintf($this->language->get('success_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'));
                } else {
                    if ($order_info['order_status_id'] == $this->config->get($paymentcode . '_order_status_id')) {
                        $this->data['success_text'] .= sprintf($this->language->get('success_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'));
                    }
                }
                if ($order_info['order_status_id'] != $this->config->get($paymentcode . '_order_status_id')) {
                    if ($order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                        $this->data['success_text'] .= sprintf($this->language->get('waiting_text_loged'), $this->url->link('account/order', '', 'SSL'));
                    }
                }
            }
            $this->data['breadcrumbs'] = array();
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'), 'href' => $this->url->link('common/home'), 'separator' => false
            );
            if (isset($first)) {
                $this->language->load('checkout/success');
                $this->data['breadcrumbs'][] = array(
                    'href' => $this->url->link('checkout/cart'), 'text' => $this->language->get('text_basket'), 'separator' => $this->language->get('text_separator')
                );
                $this->data['breadcrumbs'][] = array(
                    'href' => $this->url->link('checkout/checkout', '', 'SSL'), 'text' => $this->language->get('text_checkout'), 'separator' => $this->language->get('text_separator')
                );
                $this->data['button_ok_url'] = $this->url->link('common/home');
            } else {
                if ($this->customer->isLogged()) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $this->language->get('lich'), 'href' => $this->url->link('account/account', '', 'SSL'), 'separator' => $this->language->get('text_separator')
                    );
                    $this->data['breadcrumbs'][] = array(
                        'text' => $this->language->get('history'), 'href' => $this->url->link('account/order', '', 'SSL'), 'separator' => $this->language->get('text_separator')
                    );
                    $this->data['button_ok_url'] = $this->url->link('account/order', '', 'SSL');
                } else {
                    $this->data['button_ok_url'] = $this->url->link('common/home');
                }
            }
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sbacquiring_success.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/account/sbacquiring_success.tpl';
            } else {
                $this->template = 'default/template/account/sbacquiring_success.tpl';
            }
            $this->children = array(
                'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header'
            );
            $this->response->setOutput($this->render());
        } else {
            echo "No data";
        }
    }

    public function fail() {
        if (isset($this->request->get['orderId']) && isset($this->request->get['payment_code']) && isset($this->request->get['ordernum']) && isset($this->request->get['code'])) {
            $this->load->model('checkout/order');
            $this->load->model('account/sbacquiring');
            $yu_codes = $this->model_account_sbacquiring->getPayMethods();
            if (in_array($this->request->get['payment_code'], $yu_codes)) {
                $paymentcode = $this->request->get['payment_code'];
                if (isset($this->request->get['first'])) {
                    $first = 1;
                }
                $order_info = $this->model_checkout_order->getOrder((int)$this->request->get['ordernum']);
                $platp      = substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
                if ($this->request->get['code'] != $platp) {
                    $this->redirect($this->url->link('error/not_found'));
                }
            } else {
                echo 'No order';
                exit();
            }
        } else {
            echo 'No order';
            exit();
        }
        if ($this->request->get['ordernum'] == $order_info['order_id']) {
            $paymentcode = $order_info['payment_code'];
            $inv_id      = $order_info['order_id'];
            $this->load->language('account/' . $paymentcode);
            $this->data['heading_title'] = $this->language->get('heading_title_fail');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->data['button_ok'] = $this->language->get('button_ok');
            $this->data['inv_id']    = $order_info['order_id'];
            $action     = $this->url->link('account/' . $paymentcode);
            $online_url = $action . '&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_account_sbacquiring->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
            $this->data['fail_text'] = '';
            if (isset($first) && $order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                $this->data['fail_text'] .= $this->language->get('fail_text_first');
            }
            if ($this->config->get($paymentcode . '_fixen')) {
                if ($this->config->get($paymentcode . '_fixen') == 'fix') {
                    $out_summ = $this->config->get($paymentcode . '_fixen_amount');
                } else {
                    $out_summ = $order_info['total'] * $this->config->get($paymentcode . '_fixen_amount') / 100;
                }
            } else {
                $out_summ = $order_info['total'];
            }
            if ($this->config->get($paymentcode . '_fail_page_text_attach')) {
                $this->data['fail_text'] .= $this->model_account_sbacquiring->getCustomFields($order_info, $this->config->get($paymentcode . '_fail_page_text_' . $this->config->get('config_language_id')));
            } else {
                if ($order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                    $this->data['fail_text'] .= sprintf($this->language->get('fail_text'), $inv_id, $online_url, $online_url);
                } else {
                    $this->data['fail_text'] .= sprintf($this->language->get('fail_text_noorder'), $online_url);
                }
            }
            if ($this->customer->isLogged()) {
                if ($order_info['order_status_id'] == $this->config->get($paymentcode . '_on_status_id')) {
                    $this->data['fail_text'] .= sprintf($this->language->get('fail_text_loged'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/order/info&order_id=' . $inv_id, '', 'SSL'), $this->url->link('account/order', '', 'SSL'));
                }
            }
            $this->data['breadcrumbs'] = array();
            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'), 'href' => $this->url->link('common/home'), 'separator' => false
            );
            if (isset($first)) {
                $this->language->load('checkout/success');
                $this->data['breadcrumbs'][] = array(
                    'href' => $this->url->link('checkout/cart'), 'text' => $this->language->get('text_basket'), 'separator' => $this->language->get('text_separator')
                );
                $this->data['breadcrumbs'][] = array(
                    'href' => $this->url->link('checkout/checkout', '', 'SSL'), 'text' => $this->language->get('text_checkout'), 'separator' => $this->language->get('text_separator')
                );
                $this->data['button_ok_url'] = $this->url->link('common/home');
            } else {
                if ($this->customer->isLogged()) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $this->language->get('lich'), 'href' => $this->url->link('account/account', '', 'SSL'), 'separator' => $this->language->get('text_separator')
                    );
                    $this->data['breadcrumbs'][] = array(
                        'text' => $this->language->get('history'), 'href' => $this->url->link('account/order', '', 'SSL'), 'separator' => $this->language->get('text_separator')
                    );
                    $this->data['button_ok_url'] = $this->url->link('account/order', '', 'SSL');
                } else {
                    $this->data['button_ok_url'] = $this->url->link('common/home');
                }
            }
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sbacquiring_fail.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/account/sbacquiring_fail.tpl';
            } else {
                $this->template = 'default/template/account/sbacquiring_fail.tpl';
            }
            $this->children = array(
                'common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header'
            );
            $this->response->setOutput($this->render());
        } else {
            echo "No data";
        }
    }

    public function change() {
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];

            $this->load->model('checkout/order');
            $this->load->model('account/order');

            $order_info = $this->model_checkout_order->getOrder($order_id);

            $this->load->language('payment/sbacquiring');
            $payment_method = $this->language->get('text_title');

            $order_info['payment_code'] = 'sbacquiring';
            $order_info['payment_method'] = $payment_method;
            $order_info['affiliate_id'] = 0;
            $this->model_account_order->editOrder($order_id, $order_info);

            $this->redirect($this->url->link('account/sbacquiring', 'code=' . $order_id . '&order_id=' . $order_id));
        }
    }
}

?>
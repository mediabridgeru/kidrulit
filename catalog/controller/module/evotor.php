<?php
class ControllerModuleEvotor extends Controller {
    private $error          = array();
    private $codefor        = 'evotor';
    private static $_PARAMS = array(
        'AutoCheck' => '',
        'Timeout'   => '',
    );

    public function rec () {
        if (isset($this->request->post['code']) && isset($this->request->post['order_id'])) {

            $passport = hash_hmac('sha256', md5((int)$this->request->post['order_id'].$this->config->get('evotor_license')), $this->config->get('config_encryption'));
            if ($passport == $this->request->post['code']){
                $this->load->model('checkout/order');
                $order_data = $this->model_checkout_order->getOrder((int)$this->request->post['order_id']);
                if (isset($this->request->post['order_status_id'])) {
                    $order_data['order_status_id'] = (int)$this->request->post['order_status_id'];
                }
                $this->eventPrintCheck($order_data);
            }
            else{
                $this->getChild('error/not_found');
            }
        }
        else{
            $this->getChild('error/not_found');
        }
        
    }

    private function checkParam($Param, $checkParam = '') {
        $default = '';
        if ($Param == 'Timeout') {
            $default = 60;
        }

        if ($Param == 'AutoCheck') {
            $default = true;
        }

        $checkParam = ($checkParam != '') ? $checkParam : $this->config->get($this->codefor . '_' . $Param);
        $checkParam = ($checkParam != '') ? $checkParam : $default;
        return $checkParam;
    }

    public function eventPrintCheck($order_data) {

        if ($this->config->get('evotor_status')) {

            if ($this->config->get('evotor_payments')) {

                $evotor_order_status_id_confirm = $this->config->get('evotor_order_status_id_confirm') ? $this->config->get('evotor_order_status_id_confirm') : array();

                if (in_array($order_data['order_status_id'], $evotor_order_status_id_confirm) && in_array($order_data['payment_code'], $this->config->get('evotor_payments'))) {

                    if (in_array($order_data['order_status_id'], $evotor_order_status_id_confirm)) {
                        $type = 0;
                    } else {
                        $type = 1;
                    }

                    $doCheckb          = 1;
                    $currency          = $this->getCurrency($order_data['currency_code'], $order_data['currency_value']);
                    $ElectronicPayment = $this->currency->format($order_data['total'], $currency['code'], $currency['value'], false);
                    $Cash              = 0;

                }
            }

            if ($this->config->get('evotor_payments_nal')) {

                $evotor_order_status_id_nal_confirm = $this->config->get('evotor_order_status_id_nal_confirm') ? $this->config->get('evotor_order_status_id_nal_confirm') : array();
                $evotor_order_status_id_nal_return  = $this->config->get('evotor_order_status_id_nal_return') ? $this->config->get('evotor_order_status_id_nal_return') : array();

                if (((in_array($order_data['order_status_id'], $evotor_order_status_id_nal_confirm) || in_array($order_data['order_status_id'], $evotor_order_status_id_nal_return)) && in_array($order_data['payment_code'], $this->config->get('evotor_payments_nal')))) {

                    if (in_array($order_data['order_status_id'], $evotor_order_status_id_nal_confirm)) {
                        $type = 0;
                    } else {
                        $type = 1;
                    }

                    $doCheckb          = 1;
                    $currency          = $this->getCurrency($order_data['currency_code'], $order_data['currency_value']);
                    $ElectronicPayment = 0;
                    $Cash              = $this->currency->format($order_data['total'], $currency['code'], $currency['value'], false);

                }
            }

            if (isset($doCheckb)) {

                $first             = false;
                $checkinbaseReturn = 0;

                $this->load->model('module/evotor');

                $checkinbase = $this->model_module_evotor->getCheckId($order_data['order_id'], $type);

                if ($checkinbase['status'] != 1) {

                    if ($type == 0) {

                        if ($checkinbase['status'] === false) {

                            $checkinbase['id']     = $this->model_module_evotor->writeCheckId($order_data['order_id'], $order_data['customer_id'], $this->ccont($order_data['email'], $order_data['telephone']), 0, $order_data['date_added'], '', '', $order_data['payment_code'], $ElectronicPayment, $Cash, $type);
                            $first                 = true;
                            $checkinbase['status'] = true;
                        } else {
                            $ElectronicPayment = $checkinbase['electronicpayment'];
                            $Cash              = $checkinbase['cash'];
                        }

                    } else {
                        if ($checkinbase['status'] === false) {

                            $checkinbase = $this->model_module_evotor->getCheckId($order_data['order_id'], 0);
                            if ($checkinbase['status'] === false) {
                                $this->erConstructor('eventPrintCheck', 2, 'No first Check for order ' . $order_data['order_id'] . ' , no return now!');
                                exit();
                            }
                            $ElectronicPayment = $checkinbase['electronicpayment'];
                            $Cash              = $checkinbase['cash'];
                            $checkinbaseReturn = $checkinbase['id'];

                            $checkinbase['id'] = $this->model_module_evotor->writeCheckId($order_data['order_id'], $this->checkParam('CashierName'), $order_data['customer_id'], $this->ccont($order_data['email'], $order_data['telephone']), 0, $order_data['date_added'], '', '', $order_data['payment_code'], $ElectronicPayment, $Cash, $type);

                            $first = true;

                        } else {
                            $ElectronicPayment = $checkinbase['electronicpayment'];
                            $Cash              = $checkinbase['cash'];
                            $checkinbaseReturn = $checkinbase['id'];
                        }
                    }

                    if ($checkinbase['status'] !== false) {

                        $result = $this->printCheck($order_data, $type, self::$_PARAMS, $ElectronicPayment, $Cash, 0, 0, 0, $first, $checkinbase['id'], $checkinbaseReturn);

                        if (!isset($result->added) || isset($result->warning)) {

                            $this->erMail(json_encode($result), $order_data);
                            $this->model_module_evotor->updCheckId($order_data['order_id'], $type, $checkinbase['id'], 2, 0, 0);

                        } else {
                            if ($type == 1) {
                                $returnstatus = 1;
                                $doc_num      = $order_data['order_id'] . '-return';
                            } else {
                                $returnstatus = 0;
                                $doc_num      = $order_data['order_id'];
                            }
                            $this->model_module_evotor->updCheckId($order_data['order_id'], $type, $checkinbase['id'], 1, $doc_num, $returnstatus);

                        }
                    } else {
                        $this->erConstructor('eventPrintCheck', 2, 'No Check for order ' . $order_data['order_id']);
                    }
                } else {
                    $this->erConstructor('eventPrintCheck', 2, 'This Check for order ' . $order_data['order_id'] . ' already exist');
                }

            }
        }

    }

    private function saveCheck($data, $type, $order_id, $checkinbaseid) {

        $this->load->model('module/evotor');
        $num     = 0;
        $receipt = array();
        foreach ($data as $product) {
            $num += 1;
            $receipt[] = array(

                'order_id'               => $order_id,
                'product_id'             => $product['product_id'],
                'name'                   => $product['good_name'],
                'model'                  => $product['model'],
                'quantity'               => $product['quantity'],
                'price'                  => $product['price'],
                'total'                  => $product['dsum'],
                'tax'                    => $product['vat_rate'],
                'type'                   => $type,
                'receipt_product_number' => $num,
                'check_id'               => $checkinbaseid,

                'dsum'                   => $product['dsum'],
                'uuid'                   => $product['good_uuid'],
                'discount'               => $product['discount'],
                'vat_sum'                => $product['vat_sum'],
                'unit_uuid'              => $product['unit_uuid'],
                'unit_name'              => $product['unit_name'],
                'tag1214'                => $product['tag1214'],
                'product_type'           => $product['product_type'],

            );

        }

        $this->model_module_evotor->addCheck($receipt);

    }

    private function checkGet($_PARAMS, $order_info, $totalcheck, $checkinbaseid, $type) {

        $this->load->model('module/evotor');
        $cart_products = $this->model_module_evotor->getCheckProducts($checkinbaseid, $type);

        foreach ($cart_products as $cart_product) {

            $okassa['goods'][] = array(
                'good_uuid' => $cart_product['uuid'],
                'good_name' => $cart_product['name'],
                'quantity'  => $cart_product['quantity'],
                'price'     => $cart_product['price'],
                //'dsum'      => $cart_product['dsum'],
                'dsum'      => $cart_product['price'] * $cart_product['quantity'],
                'discount'  => $cart_product['discount'],
                'vat_rate'  => $cart_product['tax'],
                'vat_sum'   => $cart_product['vat_sum'],
                'unit_uuid' => $cart_product['unit_uuid'],
                'unit_name' => $cart_product['unit_name'],
                'tag1214'   =>  $cart_product['tag1214'],
                'product_type' => $cart_product['product_type'],
            );

        }

        return $okassa['goods'];

    }

    private function getRequest($okassa, $command = '') {

        if ($this->config->get('evotor_logs')) {
            $this->evotorLog($okassa);
        }
        $postdata = '['.json_encode($okassa).']';
        if ($this->config->get('evotor_logs')) {
            $this->evotorLog($postdata);
        }

        $token = $this->config->get('evotor_user');
        $storUuid = $this->config->get('evotor_storeUiid');

        $server = 'https://epsapi.akitorg.ru/api/v1/stores/'.$storUuid.'/'.$command;

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $server);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($curl, CURLOPT_USERAGENT, 'art&pr-opencart');
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Authorization: '.$token));
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->checkParam('Timeout'));

                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        } else {
            return $this->erConstructor('getRequest', 2, 'Server Error No CURL');
        }

        if ($result != '') {

            return $result;

        } else {

            return $this->erConstructor('getRequest', 2, 'No DATA or No connection');
        }
    }

    private function getCurrency($currency_code, $currency_value) {

        $currency = array();

        if ($currency_code == 'RUB') {
            $currency['code']  = $currency_code;
            $currency['value'] = $currency_value;
        } else {
            $currency['code']  = 'RUB';
            $currency['value'] = $this->currency->getValue('RUB');
        }

        return $currency;
    }

    private function getGUID() {
        /*
        if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
         */

        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

    }

    private function evotorLog($data) {

        if (!isset($evotorLog)) {
            $evotorLog = new Log('evotor.log');
        }

        $evotorLog->write($data);

    }

    private function erMail($data, $order_info) {

        $subject = 'evotor NOTIFICATION SYSTEM';
        $text    = "ERROR AUTOMATICAL CHECK #" . $order_info['order_id'] . " REPORT\nReason: " . $data;

        $mail                = new Mail();
        $mail->protocol      = $this->config->get('config_mail_protocol');
        $mail->parameter     = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');

        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText($text);

        $emails = explode(',', $this->config->get('evotor_errorEmail'));

        foreach ($emails as $email) {
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->setTo($email);
                $mail->send();
            }
        }

    }

    private function ccont($email, $telephone) {

        if ($email != '') {
            if (!strpos($email, '@localhost.net')) {
                $ccont = $email;
            } else {
                $ccont = "+" . preg_replace('/[^0-9]/', '', $telephone);
            }
        } else {
            $ccont = "+" . preg_replace('/[^0-9]/', '', $telephone);
        }

        return $ccont;

    }

    private function printCheck($order_info, $type, $_PARAMS, $ElectronicPayment = 0, $Cash = 0, $AdvancePayment = 0, $Credit = 0, $CashProvision = 0, $first = false, $checkinbaseid, $checkinbaseReturn = 0) {

        if ($order_info) {

            $this->load->model('module/evotor');

            $totalcheck = $ElectronicPayment + $Cash + $AdvancePayment + $CashProvision;

            $codefor = $this->codefor;

            $guid = $this->getGUID();

            $ccont = $this->ccont($order_info['email'], $order_info['telephone']);

            if ($ElectronicPayment > 0) {
                $pay_type = 1;
            } else {
                $pay_type = 0;
            }

            if ($type == 1) {
                $returnstatus = 1;
                $doc_num      = $order_info['order_id'] . '-return';
            } else {
                $returnstatus = 0;
                $doc_num      = $order_info['order_id'];
            }

            $okassa =
            array(
                'uuid'         => $order_info['order_id'] . '-' . HTTPS_SERVER,
                'doc_date'     => $order_info['date_modified'],
                'doc_num'      => $doc_num,
                'client_uuid'  => $order_info['customer_id'],
                'client_name'  => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
                'dsum'         => $totalcheck,
                'debt'         => $totalcheck,
                'info'         => $order_info['order_id'],
                'emailphone'   => $ccont,
                'pay_type'     => $pay_type,
                'firm_address' => HTTPS_SERVER,
            );

            if ($this->config->get('evotor_tax_system_code')) {
                $okassa['firm_ts'] = $this->model_module_evotor->getsystax($this->config->get('evotor_tax_system_code'));
            }

            if ($type == 0 && $first) {

                $okassa['goods'] = $this->checkGen($_PARAMS, $order_info, $totalcheck);
                $this->saveCheck($okassa['goods'], $type, $order_info['order_id'], $checkinbaseid);

            } else {
                if ($type == 1) {
                    if ($first) {
                        $okassa['goods'] = $this->checkGet($_PARAMS, $order_info, $totalcheck, $checkinbaseReturn, 0);
                        $this->saveCheck($okassa['goods'], $type, $order_info['order_id'], $checkinbaseid);
                    } else {
                        $okassa['goods'] = $this->checkGet($_PARAMS, $order_info, $totalcheck, $checkinbaseid, $type);
                    }
                } else {
                    $okassa['goods'] = $this->checkGet($_PARAMS, $order_info, $totalcheck, $checkinbaseid, $type);
                }

            }

            $result = $this->getRequest($okassa, 'sales/add');

            if (isset($result)) {
                if ($this->config->get('evotor_logs')) {
                    $this->evotorLog($result);
                }

                $result = json_decode($result);

                return $result;

            } else {

                return $this->erConstructor('printCheck', 2, 'No DATA in printCheck');
            }

        }

    }

    private function checkGen($_PARAMS, $order_info, $totalcheck) {

        $codefor  = $this->codefor;
        $currency = $this->getCurrency($order_info['currency_code'], $order_info['currency_value']);
        $this->load->model('module/evotor');

        if ($this->checkParam('AutoCheck', $_PARAMS['AutoCheck']) && $this->config->get('evotor_customShip') != '') {

            $order_info['shipping_method'] = $this->config->get('evotor_customShip');

        }

        if ($this->checkParam('AutoCheck', $_PARAMS['AutoCheck']) && $this->config->get('evotor_customName')) {

            $customname = $this->config->get('evotor_customName');

        }

        $this->load->model('account/order');
        $cart_products = $this->model_account_order->getOrderProducts($order_info['order_id']);

        //vouchers
        $vouchersbuy = $this->model_account_order->getOrderVouchers($order_info['order_id']);
        foreach ($vouchersbuy as $voucherbuy) {
            $cart_products[] = array(
                'quantity'   => 1,
                'name'       => $voucherbuy['description'],
                'price'      => $voucherbuy['amount'],
                'product_id' => 0,
                'model'      => $voucherbuy['code'],
            );

        }
        //vouchers end

        $totals   = $this->model_account_order->getOrderTotals($order_info['order_id']);
        $tax      = 0;
        $voucher  = 0;
        $shipping = 0;
        $subtotal = 0;
        $coupon   = 0;

        $paytotals = 0;

        foreach ($totals as $total) {
            switch ($total['code']) {
                case 'tax':$tax = $total['value'];
                    break;
                case 'shipping':$shipping = $total['value'];
                    break;
                case 'sub_total':$subtotal = $total['value'];
                    break;
                case 'coupon':$coupon = $total['value'];
                    break;
                case 'voucher':$voucher = $total['value'];
                    break;

                case 'paytotals':$paytotals = $total;
                    break;
            }
        }

        //aditional totals +

        /*

        if ($paytotals['value'] > 0){
        $cart_products[] = array(
        'quantity' => 1,
        'name' => $paytotals['title'],
        'price' => $paytotals['value'],
        'product_id' => 0,
        'signcalculationobject' => 4,
        'nds' => -1,
        'model' => $paytotals['code'],
        );
        }

         */
        //end additional totals +

        // coupon free shipping


        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int) $order_info['order_id'] . "'");

        if (isset($query->rows)) {
            foreach ($query->rows as $row) {
                $sipcoup = $this->db->query("SELECT `shipping` FROM `" . DB_PREFIX . "coupon` WHERE coupon_id = '" . (int) $row['coupon_id'] . "'");
                if ($sipcoup->row['shipping'] == 1) {
                    $couponship = true;
                }
            }
        }

        if (isset($couponship)) {
            $shipping = 0;
        }

        // coupon free shipping end

        //aditional totals +

        //$subtotal += $paytotals['value'];

        $aditionalses = $shipping;

        //end additional totals +

        $ndsval = '';

        if ($this->config->get('evotor_nds') == 'important') {
            $ndsval = $this->config->get('evotor_nds_important');
        }

        if ($this->config->get('evotor_nds') == 'tovar') {
            $ndson = true;
            $this->load->model('catalog/product');
        }

        if ($subtotal != 0) {
            $moden = ($totalcheck - $this->currency->format($aditionalses, $currency['code'], $currency['value'], false)) / $this->currency->format($subtotal, $currency['code'], $currency['value'], false);
        } else {
            $moden = ($totalcheck - $this->currency->format($aditionalses, $currency['code'], $currency['value'], false));
        }
        $alldiscount = false;

        foreach ($cart_products as $cart_product) {

            $option_itemCode = $this->getOptions($order_info['order_id'], $cart_product['order_product_id']);

            if (isset($customname)) {
                $res = $this->model_module_evotor->getCustomName($cart_product['product_id'], $customname);
                if ($res != '') {
                    $cart_product['name'] = $res;
                }
            }

            $tovprice = number_format($this->currency->format($cart_product['price'], $currency['code'], $currency['value'], false) * $moden, 2, '.', '');
            if ($tovprice < 0) {
                $alldiscount = true;
                break;
            }

            $ndsvalue = $ndsval;
            if (isset($ndson)) {
                foreach ($this->config->get($codefor . '_classes') as $tax_rule) {

                    $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                    if (isset($tax_rule[$codefor . '_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codefor . '_nalog'] == $product_info['tax_class_id']) {
                        $ndsvalue = $tax_rule[$codefor . '_tax_rule'];
                    }
                }
            }

            if (isset($cart_product['nds'])) {
                $ndstovar = $cart_product['nds'];
            }
            else{
                $ndstovar = $ndsvalue;
            }

            if ($ndstovar > 0) {
                $vat_sum = number_format((number_format($this->currency->format($cart_product['price'], $currency['code'], $currency['value'], false), 2, '.', '') * $cart_product['quantity']) * $ndstovar / (100 + $ndstovar), 2, '.', '');
            } else {
                $vat_sum = 0.00;
            }

            $okassa['goods'][] = array(

                'good_uuid' => $cart_product['product_id'] . $option_itemCode,
                'good_name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0, 64, 'UTF-8'),
                'quantity'  => $cart_product['quantity'],
                'price'     => $tovprice,
                'dsum'      => $tovprice * $cart_product['quantity'],
                'discount'  => '',
                'vat_rate'  => $ndstovar,
                'vat_sum'   => $vat_sum,
                'unit_uuid' => 'sht',
                'unit_name' => 'шт.',
                'tag1214'               => '1',
                'product_type'          => 'NORMAL',

                'product_id'            => $cart_product['product_id'],
                'model'                 => $cart_product['model'],

            );

        }

        if ($alldiscount == true) {

            $moden = $totalcheck / ($this->currency->format($subtotal, $currency['code'], $currency['value'], false) + $this->currency->format($aditionalses, $currency['code'], $currency['value'], false));

            foreach ($cart_products as $cart_product) {

                $option_itemCode = $this->getOptions($order_info['order_id'], $cart_product['order_product_id']);

                if (isset($customname)) {
                    $res = $this->model_module_evotor->getCustomName($cart_product['product_id'], $customname);
                    if ($res != '') {
                        $cart_product['name'] = $res;
                    }
                }

                $tovprice = number_format($this->currency->format($cart_product['price'], $currency['code'], $currency['value'], false) * $moden, 2, '.', '');

                $ndsvalue = $ndsval;
                if (isset($ndson)) {
                    foreach ($this->config->get($codefor . '_classes') as $tax_rule) {

                        $product_info = $this->model_catalog_product->getProduct($cart_product['product_id']);
                        if (isset($tax_rule[$codefor . '_nalog']) && isset($product_info['tax_class_id']) && $tax_rule[$codefor . '_nalog'] == $product_info['tax_class_id']) {
                            $ndsvalue = $tax_rule[$codefor . '_tax_rule'];
                        }
                    }
                }

                if (isset($cart_product['nds'])) {
                    $ndstovar = $cart_product['nds'];
                }
                else{
                    $ndstovar = $ndsvalue;
                }

                if ($ndstovar > 0) {
                    $vat_sum = number_format((number_format($this->currency->format($cart_product['price'], $currency['code'], $currency['value'], false), 2, '.', '') * $cart_product['quantity']) * $ndstovar / (100 + $ndstovar), 2, '.', '');
                } else {
                    $vat_sum = 0.00;
                }

                $okassa['goods'][] = array(

                    'good_uuid' => $cart_product['product_id'] . $option_itemCode,
                    'good_name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($cart_product['name'])))), 0, 64, 'UTF-8'),
                    'quantity'  => $cart_product['quantity'],
                    'price'     => $tovprice,
                    'dsum'      => $tovprice * $cart_product['quantity'],
                    //'discount'  => number_format($this->currency->format($cart_product['price'], $currency['code'], $currency['value'], false), 2, '.', '') - $tovprice,
                    'discount'  => '',
                    'vat_rate'  => $ndstovar,
                    'vat_sum'   => $vat_sum,
                    'unit_uuid' => 'sht',
                    'unit_name' => 'шт.',
                    'tag1214'                => '1',
                    'product_type'           => 'NORMAL',

                    'product_id'            => $cart_product['product_id'],
                    'model'                 => $cart_product['model'],

                );

            }

            if ($shipping >= 0 && $order_info['shipping_code'] != '') {
                $okassa['goods'][] = array(

                    'good_uuid' => $order_info['shipping_code'],
                    'good_name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0, 64, 'UTF-8'),
                    'quantity'  => 1,
                    'price'     => number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false) * $moden, 2, '.', ''),
                    'dsum'      => number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false) * $moden, 2, '.', ''),
                    'discount'  => '',
                    //'discount'  => number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false), 2, '.', '') - number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false) * $moden, 2, '.', ''),
                    'vat_rate'  => 0,
                    'vat_sum'   => '',
                    'unit_uuid' => 'sht',
                    'unit_name' => 'шт.',
                    'tag1214'                => '1',
                    'product_type'           => 'SERVICE',

                    'product_id'            => 0,
                    'model'                 => $order_info['shipping_code'],
                );

            }

        }

        //kopeyka wars
        $checkitogo = 0;

        foreach ($okassa['goods'] as $okas) {

            $checkitogo += $okas['dsum'];

        }

        if ($alldiscount == true) {

            $proverkacheck = number_format($totalcheck - $checkitogo, 2, '.', '');

        } else {

            $proverkacheck = number_format($totalcheck - $this->currency->format($aditionalses, $currency['code'], $currency['value'], false) - $checkitogo, 2, '.', '');

        }

        if ($proverkacheck != 0.00) {
            
            $correctsum = $proverkacheck;
            
            $itemnum = -1;
            $kopwar  = false;
            foreach ($okassa['goods'] as $item) {
                $itemnum += 1;
                if ($item['quantity'] == 1 && $item['price'] > 0) {
                    $okassa['goods'][$itemnum]['price']  = number_format($okassa['goods'][$itemnum]['price'] + $correctsum, 2, '.', '');
                    $okassa['goods'][$itemnum]['dsum']  = number_format($okassa['goods'][$itemnum]['dsum'] + $correctsum, 2, '.', '');
                    $kopwar                                                 = true;
                    break;
                }

            }

            if ($kopwar == false) {
                foreach ($okassa['goods'] as $item) {
                    if ($item['price'] > 0) {

                        if ($okassa['goods'][0]['vat_rate'] > 0) {
                            $vat_sum = number_format((number_format($okassa['goods'][0]['price'] + $correctsum, 2, '.', '') * $cart_product['quantity']) * $okassa['goods'][0]['vat_rate'] / (100 + $okassa['goods'][0]['vat_rate']), 2, '.', '');
                        } else {
                            $vat_sum = 0.00;
                        }

                        $okassa['goods'][0]['Quantity'] -= 1;
                        $copyprod[] = array(

                            'good_uuid' => $okassa['goods'][0]['good_uuid'] . '~COPY',
                            'good_name' => $okassa['goods'][0]['good_name'],
                            'quantity'  => 1,
                            'price'     => number_format($okassa['goods'][0]['price'] + $correctsum, 2, '.', ''),
                            'dsum'      => number_format($okassa['goods'][0]['price'] + $correctsum, 2, '.', ''),
                            'discount'  => $okassa['goods'][0]['discount'],
                            //'discount'  => $okassa['goods'][0]['discount'] + $correctsum,
                            'vat_rate'  => $okassa['goods'][0]['vat_rate'],
                            'vat_sum'   => $vat_sum,
                            'unit_uuid' => $okassa['goods'][0]['unit_uuid'],
                            'unit_name' =>  $okassa['goods'][0]['unit_name'],
                            'tag1214'   => $okassa['goods'][0]['tag1214'],
                            'product_type'   => $okassa['goods'][0]['product_type'],

                            'product_id'            => $okassa['goods'][0]['product_id'],
                            'model'                 => $okassa['goods'][0]['model'],

                        );
                        array_splice($okassa['goods'], 1, 0, $copyprod);
                        $kopwar = true;
                        break;
                    }
                }
            }

        }

        //kopeyka wars end

        if ($shipping >= 0 && $alldiscount == false && $order_info['shipping_code'] != '') {
            $okassa['goods'][] = array(

                'good_uuid' => $order_info['shipping_code'],
                'good_name' => mb_substr(addslashes(stripslashes(str_replace("'", '', htmlspecialchars_decode($order_info['shipping_method'])))), 0, 64, 'UTF-8'),
                'quantity'  => 1,
                'price'     => number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false), 2, '.', ''),
                'dsum'      => number_format($this->currency->format($shipping, $currency['code'], $currency['value'], false), 2, '.', ''),
                'discount'  => '',
                'vat_rate'  => 0,
                'vat_sum'   => '',
                'unit_uuid' => 'sht',
                'unit_name' => 'шт.',
                'tag1214'                => '1',
                'product_type'           => 'SERVICE',

                'product_id'            => 0,
                'model'                 => $order_info['shipping_code'],
            );
        }

        if ($this->config->get($codefor . '_logs')) {
            $this->evotorLog('--------------Товары---------------------------------------');
            $this->evotorLog($cart_products);
            $this->evotorLog('--------------Учитывать-в-заказе---------------------------');
            $this->evotorLog($totals);
            $this->evotorLog('--------------В-чек----------------------------------------');
            $this->evotorLog($okassa);
            $this->evotorLog('-----------------------------------------------------------');

            $this->evotorLog('--------------Онлайн Чек (Позиции для отладки)-------------');

            $numpos = 0;
            $itogo  = 0;

            foreach ($okassa['goods'] as $okas) {
                $numpos += 1;
                $sumer = $okas['price'] * $okas['quantity'];
                $itogo += $sumer;
                $this->evotorLog($numpos . '     ' . $okas['good_name'] . '     ' . $okas['quantity'] . ' * ' .  $okas['price'] . '     ' . '   =   ' . $sumer . '     ' . "\n" .
                    '     ' . $this->model_module_evotor->getndsname($okas['vat_rate']) . '     ');
            }
/*
echo '<tr></tr><tr><td></td><td>ИТОГО: </td><td></td><td> = '.$itogo.'</td></tr>';
echo '</table>';

echo '<br/>';
echo $postdata;

if (isset($result)){
$this->evotorLog($result);
}

 */

        }
        return $okassa['goods'];
    }

    private function getOptions ($order_id, $order_product_id) {

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

              $for_itemCode[] = $option['product_option_id'].$value;
          }

          if (sizeof($for_itemCode)) {

            $option_itemCode = '&' . hash ('crc32b', implode(",", $for_itemCode));

          }

          else{
            $option_itemCode = '';
          }
          

              return $option_itemCode;

    }

    private function erConstructor($place, $enum, $text) {

        $result = array(
            'Error'  => 'evotor Error in ' . $place . ': ' . $text,
            'Status' => $enum,
        );

        $this->evotorLog($result['Error']);

        return json_encode($result);
    }

}
?>
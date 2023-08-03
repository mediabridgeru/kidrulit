<?php

require_once 'sbacquiring.php';
class ModelAccountsbacquiring2 extends ModelAccountsbacquiring {
	private $key;
	private $iv;

	public function getPaymentStatus($order_id) {
		$query = $this->db->query("SELECT `status` FROM " . DB_PREFIX . "sbacquiring2 WHERE num_order = '" . (int)$order_id . "' ");
		
		return $query->row;
	}

    public function getPayMethods() {
        $yu = ['sbacquiring2'];
        $yu_codes = [];

        foreach ($yu as $yucode) {
            if ($this->config->get($yucode . '_status')) {
                $yu_codes[] = $yucode;
            }
        }

        return $yu_codes;
    }

    public function getPaymentType($paymentType) {
        $pt = '';

		if ($paymentType == 'PC'){
			$pt = 'sbacquiring2';
		}		

		return $pt;
	}

	public function getCustomFields($order_info, $varabliesd) {
        $instros = explode('$', $varabliesd);
        $instroz = "";

        if ($order_info['currency_code'] == $this->config->get('sbacquiring2_currency')) {
            $currency_code = $order_info['currency_code'];
            $currency_value = $order_info['currency_value'];
        } else {
           $currency_code = $this->config->get('sbacquiring2_currency');
           $currency_value = $this->currency->getValue($this->config->get('sbacquiring2_currency'));
        }

        if ($this->config->get('sbacquiring2_fixen')) {
            if ($this->config->get('sbacquiring2_fixen') == 'fix'){
                $out_summ = $this->config->get('sbacquiring2_fixen_amount');
            } else {
                $out_summ = $order_info['total'] * $this->config->get('sbacquiring2_fixen_amount') / 100;
            }
        } else{
            $out_summ = $order_info['total'];
        }

        foreach ($instros as $instro) {
            if ($instro == 'href'
                || $instro == 'orderid'
                || $instro == 'card4num'
                || $instro == 'itogo'
                || $instro == 'itogobez'
                || $instro == 'itogozakaz'
                || $instro == 'komis'
                || $instro == 'total-komis'
                || $instro == 'plus-komis'
                || $instro == 'totals'
                || $instro == 'aprovedpayment'
                || $instro == 'nds'
                || $instro == 'bvnds'
                || isset($order_info[$instro])
                || substr_count($instro, "ordercustom_")
                || substr_count($instro, "shippingAddresscustom_")
                || substr_count($instro, "paymentAddresscustom_")
                || substr_count($instro, "customercustom_")
                || substr_count($instro, "paymentsimple4_")
                || substr_count($instro, "shippingsimple4_")
                || substr_count($instro, "simple4_")) {
                if ($instro == 'href') {
                    $action = $order_info['store_url'] . 'index.php?route=account/sbacquiring2';
                    $instro_other = $action . '&order_id='    . $order_info['order_id'] . '&code=' . substr($this->yanencrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);
                }

                if ($instro == 'orderid') {
                    $instro_other = $order_info['order_id'];
                }

                if ($instro == 'itogo') {
                    $instro_other = $this->currency->format($out_summ, $currency_code, $currency_value, true);
                }

                if ($instro == 'itogobez') {
                    $instro_other = $this->currency->format($out_summ, $currency_code, $currency_value, false);
                }

                if ($instro == 'itogozakaz') {
                    $instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
                }

                if ($instro == 'komis') {
                    if ($this->config->get('sbacquiring2_komis')) {
                        $instro_other = $this->config->get('sbacquiring2_komis') . '%';
                    } else {
                        $instro_other = '';
                    }
                }

                if ($instro == 'total-komis') {
                    if ($this->config->get('sbacquiring2_komis')) {
                        $instro_other = $this->currency->format($out_summ * $this->config->get('sbacquiring2_komis')/100,  $currency_code, $currency_value, true);
                    } else {
                        $instro_other = '';
                    }
                }

                if ($instro == 'plus-komis') {
                    if($this->config->get('sbacquiring2_komis')) {
                        $instro_other = $this->currency->format($out_summ + ($out_summ * $this->config->get('sbacquiring2_komis')/100),  $currency_code, $currency_value, true);
                    } else {
                        $instro_other = '';
                    }
                }

                if ($instro == 'totals') {
                    $instro_other = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], true);
                }

                if ($instro == 'nds') {
                    $this->load->model('account/order');
                    $totals = $this->model_account_order->getOrderTotals($order_info['order_id']);
                    $taxesnds = '';
                    $ndschislo = '';
                    $ndschislo2 = '';

                    foreach ($totals as $total) {
                        if ($total['code'] == 'tax') {
                            $taxes = true;
                            $taxesnds += $total['value'];
                        }
                    }

                    if ($this->config->get('cash_plusplus_prends') == 'all') {
                        $ndschislo = number_format(floatval(ltrim(preg_replace('/[^0-9.]/', '', str_replace(" ","", $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false)/118*18)), " .")), 2, '.', ' ');
                    }

                    if ($this->config->get('cash_plusplus_prends') == 'prod') {
                        $products = $this->model_account_order->getOrderProducts($order_info['order_id']);
                        $ndstaxes ='';
                        foreach ($products as $product) {
                            $ndstaxes += $product['total'];
                        }

                        $ndschislo2 = number_format(floatval(ltrim(preg_replace('/[^0-9.]/', '', str_replace(" ","", $ndstaxes/118*18)), " .")), 2, '.', ' ');

                    }

                    $instro_other = $this->currency->format($taxesnds, $order_info['currency_code'], $order_info['currency_value'], false) + $ndschislo + $ndschislo2;
                }

                if (isset($order_info[$instro])) {
                    $instro_other = $order_info[$instro];
                }

                if (substr_count($instro, "ordercustom_")) {
                    $this->load->model('tool/simplecustom');
                    $instro = ltrim($instro, 'order');
                    $customx = $this->model_tool_simplecustom->getOrderField($order_info['order_id'], $instro);
                    if ($customx) {
                         $instro_other = $customx;
                    }
                }

                if (substr_count($instro, "shippingAddresscustom_")) {
                    $this->load->model('tool/simplecustom');
                    $instro = ltrim($instro, 'shippingAddress');
                    $customx = $this->model_tool_simplecustom->getShippingAddressField($order_info['order_id'], $instro);
                    if ($customx){
                        $instro_other = $customx;
                    }
                }

                if (substr_count($instro, "paymentAddresscustom_")) {
                    $this->load->model('tool/simplecustom');
                    $instro = ltrim($instro, 'shippingAddress');
                    $customx = $this->model_tool_simplecustom->getPaymentAddressField($order_info['order_id'], $instro);
                    if ($customx){
                        $instro_other = $customx;
                    }
                }

                if (substr_count($instro, "customercustom_")) {
                    $this->load->model('tool/simplecustom');
                    $instro = ltrim($instro, 'customer');
                    $customx = $this->model_tool_simplecustom->getCustomerField($order_info['customer_id'], $instro);
                    if ($customx){
                        $instro_other = $customx;
                    }
                }

                if (substr_count($instro, "paymentsimple4_")) {
                    $this->load->model('tool/simplecustom');
                    $customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
                    $pole = ltrim($instro, 'paymentsimple4');
                    $pole = substr($pole, 1);
                    if (array_key_exists($pole , $customx) == true){
                    $instro_other = $customx[$pole];
                    }
                    if (array_key_exists('payment_' . $pole , $customx) == true){
                      $instro_other = $customx['payment_' . $pole];
                    }
                }

                if (substr_count($instro, "shippingsimple4_")) {
                    $this->load->model('tool/simplecustom');
                    $customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
                    $pole = ltrim($instro, 'shippingsimple4');
                    $pole = substr($pole, 1);
                    if (array_key_exists($pole , $customx) == true){
                    $instro_other = $customx[$pole];
                    }
                    if (array_key_exists('shipping_' . $pole , $customx) == true){
                      $instro_other = $customx['shipping_' . $pole];
                    }
                }

                if (substr_count($instro, "simple4_")) {
                    $this->load->model('tool/simplecustom');
                    $customx = $this->model_tool_simplecustom->getCustomFields('order', $order_info['order_id']);
                    $pole = ltrim($instro, 'simple4');
                    $pole = substr($pole, 1);
                    if (array_key_exists($pole , $customx) == true) {
                        $instro_other = $customx[$pole];
                    }
                }
            } else {
                $instro_other = nl2br(htmlspecialchars_decode($instro));
            }

            $instroz .=  $instro_other;
        }

        return $instroz;
    }
}
?>
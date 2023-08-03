<?php
class ControllerPaymentBBPayment extends Controller {
    protected function index() {
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        
        $this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/success';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bb.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/bb.tpl';
        } else {
            $this->template = 'default/template/payment/bb.tpl';
        }

        $this->render();
    }

    public function confirm() {
        $this->load->model('checkout/order');

        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('bb_payment_order_status_id'));
    }
}
?>
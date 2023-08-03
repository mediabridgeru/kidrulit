<?php
class ControllerPaymentBBPayment extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('payment/bb_payment');

        $this->document->setTitle($this->language->get('heading_title')); 

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->model_setting_setting->editSetting('bb_payment', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
        }

        $this->data['heading_title']      = $this->language->get('heading_title');
        
        $this->data['text_enabled']       = $this->language->get('text_enabled');
        $this->data['text_disabled']      = $this->language->get('text_disabled');
        
        $this->data['entry_order_status'] = $this->language->get('entry_order_status');
        $this->data['entry_status']       = $this->language->get('entry_status');
        $this->data['entry_sort_order']   = $this->language->get('entry_sort_order');


        $this->data['entry_use_total']    = $this->language->get('entry_use_total');
        $this->data['entry_total_from_hint']  = $this->language->get('entry_total_from_hint');
        $this->data['entry_total_to_hint']    = $this->language->get('entry_total_to_hint');

        $this->data['button_save']        = $this->language->get('button_save');
        $this->data['button_cancel']      = $this->language->get('button_cancel');
        
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
            'text'      => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
            'text'      => $this->language->get('text_payment'),
            'separator' => ' :: '
        );

        $this->document->breadcrumbs[] = array(
            'href'      => HTTPS_SERVER . 'index.php?route=payment/bb_payment&token=' . $this->session->data['token'],
            'text'      => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/bb_payment&token=' . $this->session->data['token'];

        $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];

        if (isset($this->request->post['bb_payment_order_status_id'])) {
            $this->data['bb_payment_order_status_id'] = $this->request->post['bb_payment_order_status_id'];
        } else {
            $this->data['bb_payment_order_status_id'] = $this->config->get('bb_payment_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['bb_payment_status'])) {
            $this->data['bb_payment_status'] = $this->request->post['bb_payment_status'];
        } else {
            $this->data['bb_payment_status'] = $this->config->get('bb_payment_status');
        }

        if (isset($this->request->post['bb_payment_sort_order'])) {
            $this->data['bb_payment_sort_order'] = $this->request->post['bb_payment_sort_order'];
        } else {
            $this->data['bb_payment_sort_order'] = $this->config->get('bb_payment_sort_order');
        }

        if (isset($this->request->post['bb_payment_total_to'])) {
            $this->data['bb_payment_total_to'] = $this->request->post['bb_payment_total_to'];
        } else {
            $this->data['bb_payment_total_to'] = $this->config->get('bb_payment_total_to');
        }

        if (isset($this->request->post['bb_payment_total_from'])) {
            $this->data['bb_payment_total_from'] = $this->request->post['bb_payment_total_from'];
        } else {
            $this->data['bb_payment_total_from'] = $this->config->get('bb_payment_total_from');
        }

        if (!isset($this->data['bb_payment_total_from'])) $this->data['bb_payment_total_from'] = 0;
        if (!isset($this->data['bb_payment_total_to'])) $this->data['bb_payment_total_to'] = 0;

        $this->template = 'payment/bb.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/bb_payment')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>
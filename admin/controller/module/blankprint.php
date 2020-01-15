<?php

class ControllerModuleBlankPrint extends Controller
{
    private $error = array();


    public function formBlankPrint()
    {
        $full = array(" город", "улица", "набережная", "проспект", "поселок", "переулок", "район", "набережная", "площадь", "бульвар", "шоссе", " дом", "корпус", "строение", "квартира", "область");
        $short = array(" г.", "ул.", "наб.", "пр-кт.", "п.", "пер.", "р-он.", "наб.", "пл.", "б-р.", "ш.", " д.", "корп.", "стр.", "кв.", "обл.");

        $order_id = 0;
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        }

        $this->load->model('sale/order');
        $order_info = $this->model_sale_order->getOrder($order_id);
        $from_module = $this->config->get('blankprint_module');

        if (isset($from_module)) {
            if (isset($from_module['settings'])) {
                $settings = $from_module['settings'];
                $this->data['settings'] = $settings;
                $this->data['bkey'] = $settings['bkey'];
            }

            $profiles = array();
            foreach ($from_module as $key => $value) {
                if (is_int($key)) {
                    $profiles[$key] = array_map('html_entity_decode', $value);
                    if ($settings['short_addr'] == 'on') $profiles[$key]['shop_addr'] = str_ireplace($full, $short, $profiles[$key]['shop_addr']);
                }
            }

            $this->data['profiles'] = $profiles;

        } else {
            $this->data['profiles'] = array();
            $this->data['settings'] = array();
        }

        $p = $this->model_sale_order->getOrderProducts($order_id);

        $products = array();

        foreach ($p as $product) {
            $products[] = array(
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price']
            );
        }

        if (isset($settings['opis']))
            $this->data['products'] = array_merge($products, $settings['opis']);
        else
            $this->data['products'] = $products;

        $this->load->model('tool/simplecustom');
        $custom = $this->model_tool_simplecustom->loadData('order', $order_id);
        $middlename = '';
        if (isset($custom['custom_lastname']) && $custom['custom_lastname']['label'] && $custom['custom_lastname']['label'] == 'Отчество') {
            $middlename = trim($custom['custom_lastname']['value']);
        } elseif (isset($custom['custom_middlename']) && $custom['custom_middlename']['label'] && $custom['custom_middlename']['label'] == 'Отчество') {
            $middlename = trim($custom['custom_middlename']['value']);
        }

        $this->data['client_name'] = trim($order_info['shipping_lastname']) . ' ' . trim($order_info['shipping_firstname']) . ' ' . $middlename;
        $this->data['client_index'] = $order_info['shipping_postcode'];
        $this->data['client_city'] = $order_info['shipping_city'];


        if ($settings['country'] == 'off')
            $this->data['client_addr'] = trim($order_info['shipping_address_1'] . $order_info['shipping_address_2'] . ', ' . $order_info['shipping_city'] . ', ' . $order_info['shipping_zone']);
        else
            $this->data['client_addr'] = trim(str_replace(',', '', $order_info['shipping_address_1']) . str_replace(',', '', $order_info['shipping_address_2']) . ', ' . str_replace(',', '', $order_info['shipping_city']) . ' ' . str_replace(',', '', $order_info['shipping_zone']) . ', ' . str_replace(',', '', $order_info['shipping_country']));

        if ($settings['short_addr'] == 'on') $this->data['client_addr'] = str_ireplace($full, $short, $this->data['client_addr']);

        $this->data['client_phone'] = $order_info['telephone'];

        $pr_total = 0;
        foreach ($this->data['products'] as $product)
            $pr_total += $product['price'] * $product['quantity'];

        if ($settings['typesum'] == 'auto') {
            $this->data['sum_ob'] = $order_info['total'];
            $this->data['sum_nal'] = $order_info['total'];

        } else {
            $this->data['sum_ob'] = $order_info['total'];
            $this->data['sum_nal'] = 0;
        }

        $this->template = 'module/blankprint_form.tpl';
        $this->response->setOutput($this->render());

    }


    public function index()
    {

        $this->load->language('module/blankprint');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('blankprint', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['entry_profile'] = $this->language->get('entry_profile');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_fio'] = $this->language->get('entry_fio');
        $this->data['entry_zip'] = $this->language->get('entry_zip');
        $this->data['entry_address'] = $this->language->get('entry_address');

        $this->data['entry_jurfiz'] = $this->language->get('entry_jurfiz');

        $this->data['entry_docname'] = $this->language->get('entry_docname');
        $this->data['entry_doccode'] = $this->language->get('entry_doccode');
        $this->data['entry_docissued'] = $this->language->get('entry_docissued');
        $this->data['entry_docdate'] = $this->language->get('entry_docdate');

        $this->data['entry_inn'] = $this->language->get('entry_inn');
        $this->data['entry_korr'] = $this->language->get('entry_korr');
        $this->data['entry_bank'] = $this->language->get('entry_bank');
        $this->data['entry_rs'] = $this->language->get('entry_rs');
        $this->data['entry_bik'] = $this->language->get('entry_bik');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_profile'] = $this->language->get('button_add_profile');
        $this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['tab_module'] = $this->language->get('tab_module');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/blankprint', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/blankprint', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['token'] = $this->session->data['token'];

        $this->data['modules'] = array();

        if (isset($this->request->post['blankprint_module'])) {
            $this->data['blankprint_module'] = $this->request->post['blankprint_module'];
        } elseif ($this->config->get('blankprint_module')) {
            $this->data['blankprint_module'] = $this->config->get('blankprint_module');
        }

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        $this->template = 'module/blankprint.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/blankprint')) {
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
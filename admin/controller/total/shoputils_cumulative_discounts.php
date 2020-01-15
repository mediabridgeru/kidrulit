<?php
/*
 * Shoputils
 *
 * ПРИМЕЧАНИЕ К ЛИЦЕНЗИОННОМУ СОГЛАШЕНИЮ
 *
 * Этот файл связан лицензионным соглашением, которое можно найти в архиве,
 * вместе с этим файлом. Файл лицензии называется: LICENSE.1.5.x.RUS.txt
 * Так же лицензионное соглашение можно найти по адресу:
 * http://opencart.shoputils.ru/LICENSE.1.5.x.RUS.txt
 * 
 * =================================================================
 * OPENCART 1.5.x ПРИМЕЧАНИЕ ПО ИСПОЛЬЗОВАНИЮ
 * =================================================================
 *  Этот файл предназначен для Opencart 1.5.x. Shoputils не
 *  гарантирует правильную работу этого расширения на любой другой 
 *  версии Opencart, кроме Opencart 1.5.x. 
 *  Shoputils не поддерживает программное обеспечение для других 
 *  версий Opencart.
 * =================================================================
*/

class ControllerTotalShoputilsCumulativeDiscounts extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('total/shoputils_cumulative_discounts');

        $this->load->model('total/shoputils_cumulative_discounts');
        $this->load->model('setting/store');
        $this->load->model('localisation/language');
        $this->load->model('localisation/order_status');
        $this->load->model('sale/customer_group');
        $this->load->model('install/shoputils_cumulative_discounts');

        $this->model_install_shoputils_cumulative_discounts->install();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->request->post['shoputils_cumulative_discounts_statuses'] = implode(',', $this->request->post['shoputils_cumulative_discounts_statuses']);

            $values = $this->_key_values_intersect($this->request->post, array('shoputils_cumulative_discounts_statuses', 'shoputils_cumulative_discounts_status', 'shoputils_cumulative_discounts_sort_order'));
            $this->model_setting_setting->editSetting('shoputils_cumulative_discounts', $values);

            $this->model_total_shoputils_cumulative_discounts->editDiscounts($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->makeUrl('extension/total'));
        }

        $this->document->setTitle($this->language->get('heading_title'));
        $this->_setData(array(
            'heading_title',
            'text_enabled',
            'text_disabled',
            'text_default',
            'tab_general',
            'tab_cumulative_discounts',
            'entry_status',
            'entry_sort_order',
            'entry_discount_order_statuses',
            'entry_discount_order_statuses_help',
            'entry_discount_params',
            'entry_discount_params_help',
            'entry_discount_customer_groups',
            'entry_discount_customer_groups_help',
            'entry_discount_days',
            'entry_discount_days_help',
            'entry_discount_description',
            'entry_discount_description_help',
            'entry_discount_description_default',
            'entry_discount_summ' => sprintf($this->language->get('entry_discount_summ'), $this->config->get('config_currency')),
            'entry_discount_summ_help',
            'entry_discount_percent',
            'entry_discount_percent_help',
            'entry_discount_stores',
            'entry_discount_stores_help',
            'entry_discount_help',
            'button_save',
            'button_cancel',
            'button_add_discount',
            'button_remove_discount',
            'entry_description_before',
            'entry_description_before_help',
            'entry_description_after',
            'entry_description_after_help',
        ));

        if ($this->config->get('default_config_name')){
            $this->data['text_default'] = $this->config->get('default_config_name');
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->makeUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->makeUrl('extension/total'),
            'text' => $this->language->get('text_total'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->makeUrl('total/shoputils_cumulative_discounts'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->makeUrl('total/shoputils_cumulative_discounts');

        $this->data['cancel'] = $this->makeUrl('extension/total');

        if (isset($this->request->post['shoputils_cumulative_discounts_status'])) {
            $this->data['shoputils_cumulative_discounts_status'] = $this->request->post['shoputils_cumulative_discounts_status'];
        } else {
            $this->data['shoputils_cumulative_discounts_status'] = $this->config->get('shoputils_cumulative_discounts_status');
        }

        if (isset($this->request->post['shoputils_cumulative_discounts_sort_order'])) {
            $this->data['shoputils_cumulative_discounts_sort_order'] = $this->request->post['shoputils_cumulative_discounts_sort_order'];
        } else {
            $this->data['shoputils_cumulative_discounts_sort_order'] = $this->config->get('shoputils_cumulative_discounts_sort_order');
        }
        if (isset($this->request->post['shoputils_cumulative_discounts_statuses'])) {
            $this->data['shoputils_cumulative_discounts_statuses'] = explode(',', $this->request->post['shoputils_cumulative_discounts_statuses']);
        } else {
            $this->data['shoputils_cumulative_discounts_statuses'] = explode(',', $this->config->get('shoputils_cumulative_discounts_statuses'));
        }

        $this->data['discounts'] = $this->model_total_shoputils_cumulative_discounts->getAllDiscounts();
        $this->data['cmsdata'] = $this->model_total_shoputils_cumulative_discounts->getDiscountsCMSData();
        $this->data['stores'] = $this->model_setting_store->getStores();
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        $this->template = 'total/shoputils_cumulative_discounts.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'total/shoputils_cumulative_discounts')) {
            $this->error['warning'] = $this->language->get('error_permission');
        } else if (!isset($this->request->post['shoputils_cumulative_discounts_statuses']) || !$this->request->post['shoputils_cumulative_discounts_statuses']) {
            $this->error['warning'] = $this->language->get('error_need_select_order_status');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function _key_values_intersect($values, $keys) {
        $key_val_int = array();
        foreach ($keys AS $key) {
            if (array_key_exists($key, $values))
                $key_val_int[$key] = $values[$key];
        }
        return $key_val_int;
    }

    private function _setData($values) {
        foreach ($values as $key => $value) {
            if (is_int($key)) {
                $this->data[$value] = $this->language->get($value);
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    function makeUrl($route, $url = ''){
        return str_replace('&amp;', '&', $this->url->link($route, $url.'&token=' . $this->session->data['token'], 'SSL'));
    }
}
?>
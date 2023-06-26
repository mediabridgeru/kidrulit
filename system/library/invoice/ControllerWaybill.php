<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendors/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class ControllerWaybill
{

    protected $registry;
    protected $data;

    // Errors messages
    const ERROR_UNKNOWN = 'errUnknown';
    const ERROR_UNKNOWN_CMD = 'errUnknownCmd';

    public function __construct($registry) {
        $this->registry = $registry;
        $this->errors = [];
    }

    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }

    public function get_language_code() {
        if (empty($this->language_code)) {
            $this->language_code = str_replace('-', '_', strtolower($this->config->get('config_language')));
        }
        return $this->language_code;
    }

    public function load_language($path) {
        $language = $this->language;
        if (isset($language) && method_exists($language, 'load')) {
            $this->language->load($path);
            unset($language);
            return;
        }

        $load = $this->load;
        if (isset($load) && method_exists($load, 'language')) {
            $this->load->language($path);
            unset($load);
            return;
        }
    }

    /**
     * Normalize error messages
     *
     * @return array
     * @author Dmitry (dio) Levashov
     **/
    public function error() {
        $errors = [];

        foreach (func_get_args() as $msg) {
            if (is_array($msg)) {
                $errors = array_merge($errors, $msg);
            } else {
                $errors[] = $msg;
            }
        }

        return count($errors) ? $errors : [self::ERROR_UNKNOWN];
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function invoice($orders = [])
    {
        $this->language->load('sale/documents');
        $this->language->load('sale/order');

        $this->load->helper('spreadsheet');

        $this->data['title'] = $this->language->get('heading_title');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_SERVER;
        } else {
            $this->data['base'] = HTTP_SERVER;
        }

        $this->data['direction'] = $this->language->get('direction');
        $this->data['language'] = $this->language->get('code');

        $this->data['text_invoice'] = $this->language->get('text_invoice');

        $this->data['heading_title_pko'] = $this->language->get('heading_title_pko');
        $this->data['ko1'] = $this->language->get('ko1');
        $this->data['header_second'] = $this->language->get('header_second');
        $this->data['entry_org'] = $this->language->get('entry_org');
        $this->data['entry_codes'] = $this->language->get('entry_codes');
        $this->data['entry_kwit'] = $this->language->get('entry_kwit');
        $this->data['entry_okud_form'] = $this->language->get('entry_okud_form');
        $this->data['entry_to_pko'] = $this->language->get('entry_to_pko');
        $this->data['entry_okpo'] = $this->language->get('entry_okpo');
        $this->data['entry_get_from'] = $this->language->get('entry_get_from');
        $this->data['entry_struct'] = $this->language->get('entry_struct');
        $this->data['entry_pko'] = $this->language->get('entry_pko');
        $this->data['entry_num'] = $this->language->get('entry_num');
        $this->data['entry_date'] = $this->language->get('entry_date');
        $this->data['entry_osn'] = $this->language->get('entry_osn');
        $this->data['entry_debet'] = $this->language->get('entry_debet');
        $this->data['entry_kredit'] = $this->language->get('entry_kredit');
        $this->data['entry_sum'] = $this->language->get('entry_sum');
        $this->data['entry_kcn'] = $this->language->get('entry_kcn');
        $this->data['entry_order_no'] = $this->language->get('entry_order_no');
        $this->data['entry_ksp'] = $this->language->get('entry_ksp');
        $this->data['entry_ksss'] = $this->language->get('entry_ksss');
        $this->data['entry_au'] = $this->language->get('entry_au');
        $this->data['entry_sum_prop'] = $this->language->get('entry_sum_prop');
        $this->data['entry_from'] = $this->language->get('entry_from');
        $this->data['entry_digits'] = $this->language->get('entry_digits');
        $this->data['entry_also'] = $this->language->get('entry_also');
        $this->data['entry_prop'] = $this->language->get('entry_prop');
        $this->data['entry_nds'] = $this->language->get('entry_nds');
        $this->data['entry_mp'] = $this->language->get('entry_mp');
        $this->data['entry_pril'] = $this->language->get('entry_pril');
        $this->data['entry_buh'] = $this->language->get('entry_buh');
        $this->data['entry_podp_ras'] = $this->language->get('entry_podp_ras');
        $this->data['entry_podp'] = $this->language->get('entry_podp');
        $this->data['entry_kass'] = $this->language->get('entry_kass');
        $this->data['entry_get_kass'] = $this->language->get('entry_get_kass');
        $this->data['entry_not_selected'] = $this->language->get('entry_not_selected');
        $this->data['entry_payer'] = $this->language->get('entry_payer');
        $this->data['entry_products'] = $this->language->get('entry_products');
        $this->data['entry_kolvo'] = $this->language->get('entry_kolvo');
        $this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_manager'] = $this->language->get('entry_manager');
        $this->data['entry_rk'] = $this->language->get('entry_rk');
        $this->data['entry_pbuh'] = $this->language->get('entry_pbuh');
        $this->data['entry_itog'] = $this->language->get('entry_itog');
        $this->data['entry_vtch'] = $this->language->get('entry_vtch');
        $this->data['entry_itog_s_nds'] = $this->language->get('entry_itog_s_nds');
        $this->data['entry_post'] = $this->language->get('entry_post');
        $this->data['osn'] = $this->language->get('osn');
        $this->data['entry_kod_au'] = $this->language->get('entry_kod_au');
        $this->data['entry_paycheck'] = $this->language->get('entry_paycheck');
        $this->data['entry_all_naim'] = $this->language->get('entry_all_naim');
        $this->data['entry_to_summ'] = $this->language->get('entry_to_summ');
        $this->data['entry_who_gave'] = $this->language->get('entry_who_gave');
        $this->data['entry_who_receive'] = $this->language->get('entry_who_receive');
        $this->data['entry_product'] = $this->language->get('entry_product');
        $this->data['entry_real_text'] = $this->language->get('entry_real_text');
        $this->data['entry_buh_dov'] = $this->language->get('entry_buh_dov');
        $this->data['entry_rk_dov'] = $this->language->get('entry_rk_dov');

        $this->data['text_order_id'] = $this->language->get('text_order_id');
        $this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
        $this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['text_fax'] = $this->language->get('text_fax');
        $this->data['text_to'] = $this->language->get('text_to');
        $this->data['text_company_id'] = $this->language->get('text_company_id');
        $this->data['text_tax_id'] = $this->language->get('text_tax_id');
        $this->data['text_ship_to'] = $this->language->get('text_ship_to');
        $this->data['text_payment_method'] = $this->language->get('text_payment_method');
        $this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

        $this->data['column_product'] = $this->language->get('column_product');
        $this->data['column_model'] = $this->language->get('column_model');
        $this->data['column_quantity'] = $this->language->get('column_quantity');
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_comment'] = $this->language->get('column_comment');

        $this->load->model('sale/order');
        $this->load->model('setting/setting');

        $order_id = 0;

        if (!empty($orders)) {
            $order_id = $orders[0];
        } elseif (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        }

        $order_info = $this->model_sale_order->getOrder($order_id);

        if ($order_info) {
            $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

            if ($store_info) {
                $store_address = $store_info['config_address'];
                $store_email = $store_info['config_email'];
                $store_telephone = $store_info['config_telephone'];
                $store_fax = $store_info['config_fax'];
                $store_buh = isset($store_info['config_glbuh']) ? $store_info['config_glbuh'] : '';
                $store_kass = isset($store_info['config_kass']) ? $store_info['config_kass'] : '';
                $store_owner = isset($store_info['config_owner']) ? $store_info['config_owner'] : '';
                $store_manager = isset($store_info['config_manager']) ? $store_info['config_manager'] : '';
                $store_rk_dov = isset($store_info['config_rk_dov']) ? $store_info['config_rk_dov'] : '';
                $store_buh_dov = isset($store_info['config_buh_dov']) ? $store_info['config_buh_dov'] : '';
                $store_org = isset($store_info['config_org']) ? $store_info['config_org'] : '';
                $store_inn = isset($store_info['config_inn']) ? $store_info['config_inn'] : '';
                $store_requisites = isset($store_info['config_requisites']) ? $store_info['config_requisites'] : '';
            } else {
                $store_address = $this->config->get('config_address');
                $store_email = $this->config->get('config_email');
                $store_telephone = $this->config->get('config_telephone');
                $store_fax = $this->config->get('config_fax');
                $store_buh = $this->config->get('config_glbuh');
                $store_kass = $this->config->get('config_kass');
                $store_owner = $this->config->get('config_owner');
                $store_manager = $this->config->get('config_manager');
                $store_rk_dov = $this->config->get('config_rk_dov');
                $store_buh_dov = $this->config->get('config_buh_dov');
                $store_org = $this->config->get('config_org');
                $store_inn = $this->config->get('config_inn');
                $store_requisites = $this->config->get('config_requisites');
            }

            if ($order_info['invoice_no']) {
                $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $invoice_no = '';
            }

            $customer_type = '';

            $middlename = '';

            $inn = '';
            $kpp = '';
            $okpo = '';
            $company_telefon = '';
            $custom_company = '';

            $checking_account = ''; // Расчетный счет
            $cor_account = ''; // Кор. счет
            $bank_bic = ''; // БИК банка
            $bank_name = ''; // Наименование банка

            if (!$order_info['customer_id']) {
                $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '0' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
            } else {
                $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
            }

            if (isset($customer_custom['data'])) {
                $customer_custom = unserialize($customer_custom['data']);

                $customer_type = isset($customer_custom['custom_customer_type']) ? "{$customer_custom['custom_customer_type']['value']}": '';
                $middlename = isset($customer_custom['custom_middlename']) ? "{$customer_custom['custom_middlename']['value']}": '';

                if ($customer_type == 'ip') {
                    $inn = !empty($customer_custom['custom_inn']) ? "ИНН {$customer_custom['custom_inn']['value']}" : '';
                    $kpp = !empty($customer_custom['custom_kpp']) ? "КПП {$customer_custom['custom_kpp']['value']}" : '';
                    $okpo = !empty($customer_custom['custom_okpo']) ? "{$customer_custom['custom_okpo']['value']}" : '';
                    $company_telefon = !empty($customer_custom['custom_company_telefon']) ? "{$customer_custom['custom_company_telefon']['value']}" : '';
                    $custom_company = !empty($customer_custom['custom_company']) ? "{$customer_custom['custom_company']['value']}" : '';

                    $checking_account = !empty($customer_custom['custom_checking_account']) ? "{$customer_custom['custom_checking_account']['value']}" : '';
                    $cor_account = !empty($customer_custom['custom_cor_account']) ? "{$customer_custom['custom_cor_account']['value']}" : '';
                    $bank_bic = !empty($customer_custom['custom_bank_bic']) ? "{$customer_custom['custom_bank_bic']['value']}" : '';
                    $bank_name = !empty($customer_custom['custom_bank_name']) ? "{$customer_custom['custom_bank_name']['value']}" : '';
                } elseif ($customer_type == 'legal') {
                    $inn = !empty($customer_custom['custom_legal_inn']) ? "ИНН {$customer_custom['custom_legal_inn']['value']}" : '';
                    $kpp = !empty($customer_custom['custom_legal_kpp']) ? "КПП {$customer_custom['custom_legal_kpp']['value']}" : '';
                    $okpo = !empty($customer_custom['custom_legal_okpo']) ? "{$customer_custom['custom_legal_okpo']['value']}" : '';
                    $company_telefon = !empty($customer_custom['custom_legal_company_telefon']) ? "{$customer_custom['custom_legal_company_telefon']['value']}" : '';
                    $custom_company = !empty($customer_custom['custom_legal_company']) ? "{$customer_custom['custom_legal_company']['value']}" : '';

                    $checking_account = !empty($customer_custom['custom_legal_checking_account']) ? "{$customer_custom['custom_legal_checking_account']['value']}" : '';
                    $cor_account = !empty($customer_custom['custom_legal_cor_account']) ? "{$customer_custom['custom_legal_cor_account']['value']}" : '';
                    $bank_bic = !empty($customer_custom['custom_legal_bank_bic']) ? "{$customer_custom['custom_legal_bank_bic']['value']}" : '';
                    $bank_name = !empty($customer_custom['custom_legal_bank_name']) ? "{$customer_custom['custom_legal_bank_name']['value']}" : '';
                }
            }

            $find = [
                // Custom fields
                '{customer_type}',
                '{patronymic}',

                '{inn}',
                '{kpp}',
                '{custom_company}',

                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}'
            ];

            $replace = [
                // Custom fields
                'customer_type' => $customer_type,
                'patronymic'    => $middlename,

                'inn'            => $inn,
                'kpp'            => $kpp,
                'custom_company' => $custom_company,

                'firstname' => $order_info['payment_firstname'],
                'lastname'  => $order_info['payment_lastname'],
                'company'   => $order_info['payment_company'],
                'address_1' => $order_info['payment_address_1'],
                'address_2' => $order_info['payment_address_2'],
                'city'      => $order_info['payment_city'],
                'postcode'  => $order_info['payment_postcode'],
                'zone'      => $order_info['payment_zone'],
                'zone_code' => $order_info['payment_zone_code'],
                'country'   => $order_info['payment_country'],
            ];

            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                if (strlen($custom_company)) {
                    $format = '{custom_company}'."\n".'{inn}'."\n".'{kpp}'."\n".'{postcode}'."\n".'{zone}'."\n".'{city}'."\n".'{address_1}'."\n".'{address_2}';
                } else {
                    if ($customer_type != 'individual') {
                        $format = '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
                    } else {
                        $format = '{lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
                    }
                }
            }

            $payment_address = str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format))));

            $shipping_address = $payment_address;

            $product_data = [];

            $products = $this->model_sale_order->getOrderProducts($order_id);

            $clean_products_total = 0;
            $clean_products_nds   = 0;
            $products_total       = 0;

            foreach ($products as $product) {
                $products_total++;
                $sku = $this->model_sale_order->getProductSKU($product['product_id']);
                $report_name = $this->model_sale_order->getReportName($product['product_id']); // Название товара для отчетов
                $weight = $this->model_sale_order->getProductWeight($product['product_id']);

                $c_temp_total = ($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0));
                $clean_products_total += $c_temp_total;
                $clean_products_nds += round($c_temp_total * 18 / 118, 2);

                $option_data = array();

                $options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

                if (!empty($options)) {
                    foreach ($options as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                        }

                        $option_data[] = array(
                            'name'  => $option['name'],
                            'value' => $value
                        );
                    }
                }

                if ($product['tax'] != 0)
                    $nds = $this->currency->format(round(($product['total'] * 1.18 - $product['total']), 2), $order_info['currency_code'], $order_info['currency_value'], '', false); // Считаем НДС - 18%
                else
                    $nds = $this->currency->format(0, $order_info['currency_code'], $order_info['currency_value'], '', false); // Считаем НДС - 0%

                $free_nds = $this->currency->format(round(($product['total']) / $product['quantity'], 2), $order_info['currency_value'], '', false);

                $product_data[] = array(
                    'name'     => $product['name'],
                    'model'    => $product['model'],
                    'option'   => $option_data,
                    'quantity' => $product['quantity'],
                    'report_name' => $report_name,
                    'nds'      => $nds,
                    'free_nds' => $free_nds,
                    'sku'      => $sku[0]['sku'],
                    'tax'      => $product['tax'],
                    'weight'   => $weight,

                    'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], '', false)
                );
            }

            $voucher_data = array();

            $vouchers = $this->model_sale_order->getOrderVouchers($order_id);

            foreach ($vouchers as $voucher) {
                $voucher_data[] = array(
                    'description' => $voucher['description'],
                    'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $shipping_cost = 0;

            $total_data = $this->model_sale_order->getOrderTotals($order_id);

            $ind = 0;
            if (isset($total_data)) {
                foreach ($total_data as $total_d) {
                    if ($total_d['code'] == 'total') {
                        $ind = $total_d['text'];
                    }
                    if ($total_d['code'] == 'shipping') {
                        $shipping_cost = $total_d['value'];
                    }
                }
            }

            $telephone = $order_info['telephone'];

            if ($company_telefon) {
                $telephone = $company_telefon;
            }

            $this->data['orders'][] = array(
                'total_2_str'                 => mb_ucfirst(num2str($ind)),
                'products_order_total'        => isset($clean_products_total) ? $clean_products_total : '',
                'products_order_total_valute' => $this->currency->format(isset($clean_products_total) ? $clean_products_total : '0'),
                'products_order_total_prop'   => mb_ucfirst(num2str(isset($clean_products_total) ? $clean_products_total : 0)),
                'products_total'              => mb_ucfirst(prop(isset($products_total) ? $products_total : 0)),
                'clean_products_nds'          => isset($clean_products_nds) ? $clean_products_nds : '0',


                'order_id'                    => $order_id,
                'invoice_no'                  => $invoice_no,
                'okpo'                        => $okpo,
                'company_telefon'             => $company_telefon,
                'date_added'                  => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
                'date_added_rus'              => html_entity_decode(russian_date(date($this->language->get('date_format_short'), strtotime($order_info['date_added'])))),
                'store_name'                  => $order_info['store_name'],
                'store_url'                   => rtrim($order_info['store_url'], '/'),
                'store_address'               => nl2br($store_address),
                'store_email'                 => $store_email,
                'store_org'                   => $store_org,
                'store_inn'                   => $store_inn,
                'store_requisites'            => $store_requisites,
                'store_telephone'             => $store_telephone,
                'store_fax'                   => $store_fax,
                'email'                       => $order_info['email'],
                'telephone'                   => $telephone,
                'shipping_address'            => $shipping_address,
                'shipping_method'             => $order_info['shipping_method'],
                'payment_address'             => $payment_address,
                'payment_company_id'          => $order_info['payment_company_id'],
                'payment_tax_id'              => $order_info['payment_tax_id'],
                'payment_method'              => $order_info['payment_method'],
                'product'                     => $product_data,
                'voucher'                     => $voucher_data,
                'checking_account'            => $checking_account,
                'cor_account'                 => $cor_account,
                'bank_bic'                    => $bank_bic,
                'bank_name'                   => $bank_name,
                'firstname'                   => $order_info['firstname'],
                'lastname'                    => $order_info['lastname'],
                'buh'                         => isset($store_buh) ? $store_buh : '',
                'kass'                        => isset($store_kass) ? $store_kass : '',
                'owner'                       => isset($store_owner) ? $store_owner : '',
                'manager'                     => isset($store_manager) ? $store_manager : '',
                'store_rk_dov'                => isset($store_rk_dov) ? $store_rk_dov : '',
                'store_buh_dov'               => isset($store_buh_dov) ? $store_buh_dov : '',

                'all_nds'                     => $this->currency->format(round((($ind * 18) / 118), 2), $order_info['currency_code'], $order_info['currency_value']), // Считаем полный НДС - 18%,
                'free_all_sum'                => $ind,
                'date_rus'                    => russian_date(date($this->language->get('date_format_short'), strtotime($order_info['date_added']))),
                'index_nova'                  => str_replace(',', '-', str_replace('.', '-', str_replace('р.', '', $ind))),
                'full_total_text'             => num2str($ind),

                'total'                       => $total_data,
                'comment'                     => nl2br($order_info['comment'])
            );

            $order = $this->data['orders'][0];
            $order['shipping_code'] = $order_info['shipping_code'];
            $order['shipping_method'] = $order_info['shipping_method'];
            $order['shipping_cost'] = $shipping_cost;

            $doctype = '';
            $grid = false;

            if (isset($this->request->get['excel']) || isset($this->request->get['excel7'])) {
                $grid = true;
            }

            if (isset($this->request->get['doctype'])) {
                $doctype = $this->request->get['doctype'];
            }

            if ($doctype == 'invoice') {
                $spreadsheet = $this->make_invoice_spreadsheet($order, $grid);
                $header = 'Content-Disposition: attachment; filename=Заказ_' . $order['order_id'] . '.xlsx';
            } elseif ($doctype == 'torg12') {
                $spreadsheet = $this->make_torg12_spreadsheet($order, $grid);
                $header = 'Content-Disposition: attachment; filename=Торг12_' . $order['order_id'] . '.xlsx';
            }

            if (!empty($spreadsheet)) {
                if (isset($this->request->get['excel']) || isset($this->request->get['excel7'])) {
                    ob_start();
                    $writer = new Xlsx($spreadsheet);
                    $writer->save('php://output');
                    $excelOutput = ob_get_clean();

                    $this->response->addheader('Cache-Control: public');// needed for internet explorer
                    $this->response->addheader('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    $this->response->addheader('Content-Transfer-Encoding: binary');

                    $this->response->addheader($header);

                    if (function_exists('mb_strlen')) {
                        header("Content-Length:" . mb_strlen($excelOutput, '8bit'));
                    } else {
                        header("Content-Length:" . strlen($excelOutput));
                    }

                    $this->response->setOutput($excelOutput);
                } else {
                    $writer = new Html($spreadsheet);
                    $writer->save('php://output');
                    exit();
                }
            }
        } else {
            $this->response->setOutput('Нет номера заказа!');
        }
    }

    /**
     *  Вставка строки-копии перед заданной
     *
     * @param Worksheet $sheet
     * @param int $rowNumber номер строки, которую копируем
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function insertRow(Worksheet $sheet, $rowNumber)
    {
        $sheet->insertNewRowBefore($rowNumber, 1);

        $srcColumnStart = 'A'; // A
        $srcRowStart = ($rowNumber-1); // 35
        $srcColumnEnd = $sheet->getHighestColumn(); // BK
        $srcRowEnd = ($rowNumber-1); // 35

        $destColumnStart = 'A'; // A
        $destRowStart = $rowNumber; // 36

        // For looping purposes we need to convert the indexes instead
        // Note: We need to subtract 1 since column are 0-based and not 1-based like this method acts.

        $srcColumnStart = Coordinate::columnIndexFromString($srcColumnStart) - 1;
        $srcColumnEnd = Coordinate::columnIndexFromString($srcColumnEnd) - 1;
        $destColumnStart = Coordinate::columnIndexFromString($destColumnStart) - 1;

        $rowCount = 0;
        for ($row = $srcRowStart; $row <= $srcRowEnd; $row++) {
            $colCount = 0;
            for ($col = $srcColumnStart; $col <= $srcColumnEnd; $col++) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $style = $sheet->getStyleByColumnAndRow($col, $row);
                $dstCell = Coordinate::stringFromColumnIndex($destColumnStart + $colCount) . (string)($destRowStart + $rowCount);
                $sheet->setCellValue($dstCell, $cell->getValue());
                $sheet->duplicateStyle($style, $dstCell);

                // Set width of column, but only once per row
                if ($rowCount === 0) {
                    $w = $sheet->getColumnDimensionByColumn($col)->getWidth();
                    $sheet->getColumnDimensionByColumn($destColumnStart + $colCount)->setAutoSize(false);
                    $sheet->getColumnDimensionByColumn($destColumnStart + $colCount)->setWidth($w);
                }

                $colCount++;
            }

            $h = $sheet->getRowDimension($row)->getRowHeight();
            $sheet->getRowDimension($destRowStart + $rowCount)->setRowHeight($h);

            $rowCount++;
        }

        foreach ($sheet->getMergeCells() as $mergeCell) {
            $mc = explode(":", (string)$mergeCell);
            $mergeColSrcStart = Coordinate::columnIndexFromString(preg_replace("/[0-9]*/", "", $mc[0])) - 1;
            $mergeColSrcEnd = Coordinate::columnIndexFromString(preg_replace("/[0-9]*/", "", $mc[1])) - 1;
            $mergeRowSrcStart = ((int)preg_replace("/[A-Z]*/", "", $mc[0]));
            $mergeRowSrcEnd = ((int)preg_replace("/[A-Z]*/", "", $mc[1]));

            $relativeColStart = $mergeColSrcStart - $srcColumnStart;
            $relativeColEnd = $mergeColSrcEnd - $srcColumnStart;
            $relativeRowStart = $mergeRowSrcStart - $srcRowStart;
            $relativeRowEnd = $mergeRowSrcEnd - $srcRowStart;

            if (0 <= $mergeRowSrcStart && $mergeRowSrcStart >= $srcRowStart && $mergeRowSrcEnd <= $srcRowEnd) {
                $targetColStart = Coordinate::stringFromColumnIndex($destColumnStart + $relativeColStart + 1);
                $targetColEnd = Coordinate::stringFromColumnIndex($destColumnStart + $relativeColEnd + 1);
                $targetRowStart = $destRowStart + $relativeRowStart;
                $targetRowEnd = $destRowStart + $relativeRowEnd;

                $merge = (string)$targetColStart . (string)($targetRowStart) . ":" . (string)$targetColEnd . (string)($targetRowEnd);
                //Merge target cells
                $sheet->mergeCells($merge);
            }
        }
    }

    /**
     * @param array $order
     * @param bool $grid отображать сетку
     *
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function make_invoice_spreadsheet(array $order, $grid = false)
    {
        $order_id = $order['order_id'];

        $format_number = NumberFormat::FORMAT_NUMBER_00;

        set_time_limit(0);
        ini_set("memory_limit", "64M");

        $fileType = 'Xlsx';
        $fileName = 'invoice.xlsx';

        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($_SERVER['DOCUMENT_ROOT'] . '/docs/' . $fileName);

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator("admin")
            ->setLastModifiedBy("admin")
            ->setTitle("Заказ № {$order_id}")
            ->setSubject("Заказ № {$order_id}")
            ->setDescription(
                "Заказ № {$order_id} от {$order['date_added_rus']}г."
            )
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Заказ");

        $sheet->setShowGridlines($grid);

        $order['payment_address'] = html_entity_decode($order['payment_address']);

        $sheet->SetCellValue('B12', 'Заказ № ' . $order['order_id'] . ' от ' . $order['date_added_rus'] . ' г.');
        $sheet->SetCellValue('H18', $order['payment_address'] . ', тел.: ' . $order['telephone']);
        $sheet->SetCellValue('H20', $order['payment_address'] . ', тел.: ' . $order['telephone']);

        $total_row = 24;
        $total_rows = 0;
        $order_total = 0;
        $totals = [];

        foreach ($order['total'] as $total) {
            $value = (float)$total['value'];

            if ($total['code'] == 'sub_total') {
                $totals[] = $total;
            } elseif ($total['code'] == 'transfer_total') {
                if ($value) {
                    try { // добавляем строку для наценки или скидки
                        $this->insertRow($sheet, $total_row + 1);

                        $totals[] = $total;
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
            } elseif ($total['code'] == 'shipping') {
                if ($order['payment_include'] == '1' && $value > 0) {
                    try { // добавляем строку для доставки
                        $this->insertRow($sheet, $total_row + 1);

                        $totals[] = $total;
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
            } elseif ($total['code'] == 'total') {
                $totals[] = [
                    'code' => 'nds',
                    'title' => 'Без налога (НДС)',
                    'value' => ''
                ];

                $order_total = $total['value'];

                $totals[] = $total;
            }
        }

        if (!empty($totals)) {
            foreach ($totals as $total) {
                $value = $order_total;

                if ($order['payment_include'] == '1') {
                    $value = $total['value'];
                }

                $sheet->SetCellValue('B' . ($total_row + $total_rows), $total['title']);

                $sheet->SetCellValue('AH' . ($total_row + $total_rows), $value);

                $sheet->getStyle('AH' . ($total_row + $total_rows))->getNumberFormat()->setFormatCode($format_number);

                $total_rows++;
            }
        }

        $sheet->SetCellValue('B' . ($total_row+$total_rows), 'Всего наименований ' . count($order['product']) . ', на сумму ' . number_format((float)$order_total, 2, ',', ' ') . ' руб.');
        $sheet->SetCellValue('B' . ($total_row+$total_rows+1), mb_ucfirst(num2str($order_total)));

        $r = 23;

        $i = 1;
        $quality = 0;
        $cell = [];

        foreach ($order['product'] as $product) {
            $sheet->insertNewRowBefore($r, 1);

            $cell[] = 'B' . $r . ':C' . $r;// номер
            $cell[] = 'D' . $r . ':G' . $r;// Артикул
            $cell[] = 'H' . $r . ':X' . $r;// Товары (работы, услуги)
            $cell[] = 'Y' . $r . ':AA' . $r;// Кол-во
            $cell[] = 'AB' . $r . ':AC' . $r;// Ед.
            $cell[] = 'AD' . $r . ':AG' . $r;// Цена
            $cell[] = 'AH' . $r . ':AL' . $r;// Сумма

            foreach ($cell as $cel) {
                $sheet->mergeCells($cel);
            }

            $pname = html_entity_decode($product['report_name']);

            foreach ($product['option'] as $option) {
                $pname .= ' ' . $option['value'];
            }

            $height = 14 + intval(strlen($product['model']));
            $sheet->getRowDimension($r)->setRowHeight($height);

            $sheet->getStyle("B$r:AL$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $sheet->getStyle("H$r:X$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->getStyle('AD' . $r)->getNumberFormat()->setFormatCode($format_number);
            $sheet->getStyle('AH' . $r)->getNumberFormat()->setFormatCode($format_number);

            $sheet->SetCellValue('B' . $r, $i);
            $sheet->SetCellValue('D' . $r, $product['model']);
            $sheet->SetCellValue('H' . $r, $pname);
            $sheet->SetCellValue('Y' . $r, $product['quantity']);
            $sheet->SetCellValue('AB' . $r, 'шт.');
            $sheet->SetCellValue('AD' . $r, $product['price']);
            $sheet->SetCellValue('AH' . $r, $product['total']);

            $quality += $product['quantity'];

            $i++;
            $r++;
        }

        return $spreadsheet;
    }

    private function setFont0($sheet) {
        $fontSize0 = ['font'  => ['size'  => 0]];
        $highestRow = $sheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $sheet->getStyle('A' . $row)->applyFromArray($fontSize0);
            $sheet->SetCellValue('BK' . $row, '');
        }
    }

    /**
     * @param array $order
     * @param bool $grid
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function make_torg12_spreadsheet(array $order, $grid = false)
    {
        $order_id = $order['order_id'];

        $format_number = NumberFormat::FORMAT_NUMBER_00;

        set_time_limit(0);
        ini_set("memory_limit", "64M");

        $fileType = 'Xlsx';
        $fileName = 'torg12.xlsx';

        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($_SERVER['DOCUMENT_ROOT'] . '/docs/' . $fileName);

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getPageMargins()->setTop(0.1);
        $sheet->getPageMargins()->setRight(0.1);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0.1);

        $sheet->getPageSetup()->setHorizontalCentered(true);

        $spreadsheet->getProperties()
            ->setCreator("admin")
            ->setLastModifiedBy("admin")
            ->setTitle("ТОРГ12 № {$order_id}")
            ->setSubject("ТОРГ12 № {$order_id}")
            ->setDescription(
                "ТОРГ12 № {$order_id} от {$order['date_added_rus']}г."
            )
            ->setKeywords("office 2007 openxml php")
            ->setCategory("ТОРГ12");

        $spreadsheet->setActiveSheetIndex(0);

        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        $sheet->setShowGridlines($grid);

        $payment_address = html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']);

        $accounts = '';

        if ($order['checking_account']) {
            $accounts .= 'Р/сч ' . $order['checking_account'];
        }

        if ($order['cor_account']) {
            if ($accounts) {
                $accounts .= ', ';
            }

            $accounts .= 'К/сч ' . $order['cor_account'];
        }

        if ($order['bank_bic']) {
            if ($accounts) {
                $accounts .= ', ';
            }

            $accounts .= 'БИК ' . $order['bank_bic'];
        }

        if ($order['bank_name']) {
            if ($accounts) {
                $accounts .= ', ';
            }

            $accounts .= $order['bank_name'];
        }

        if ($accounts) {
            $accounts = html_entity_decode($accounts);

            $payment_address .= ', ' . $accounts;
        }

        $sheet->SetCellValue('AC24', $order['order_id']);
        $sheet->SetCellValue('AJ24', $order['date_added']);
        $sheet->SetCellValue('I52', $order['date_added_rus']);
        $sheet->SetCellValue('I12', $payment_address);
        $sheet->SetCellValue('I17', $payment_address);

        $date = date('d.m.Y', strtotime($order['date_added']));
        $sheet->SetCellValue('I19', 'Счет-заказ № ' . $order['order_id'] . ' от ' . $date);

        $sheet->SetCellValue('BC12', $order['okpo']);
        $sheet->SetCellValue('BC17', $order['okpo']);

        $total_row = 30;
        $total_rows = 0;
        $order_total = 0;

        $totals = []; // суммы, которые надо показать

        foreach ($order['total'] as $total) {
            $value = (float)$total['value'];

            if ($total['code'] == 'sub_total') {
                $order_total = $total['value'];

                $totals[] = $total;
            } elseif ($total['code'] == 'transfer_total') {
                if ($value) {
                    try { // добавляем строку для наценки или скидки
                        $this->insertRow($sheet, $total_row + 1);

                        $totals[] = $total;
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
            } elseif ($total['code'] == 'shipping') {
                if ($order['payment_include'] == '1' && $value > 0) {
                    try { // добавляем строку для доставки
                        $this->insertRow($sheet, $total_row + 1);

                        $totals[] = $total;
                    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
            } elseif ($total['code'] == 'total') {
                $totals[] = $total;
            }
        }

        foreach ($totals as $total) {
            $value = $order_total;

            if ($order['payment_include'] == '1') {
                $value = $total['value'];
            }

            $sheet->SetCellValue('S' . ($total_row + $total_rows), $total['title']);

            $sheet->SetCellValue('AW' . ($total_row + $total_rows), $value);
            $sheet->SetCellValue('BG' . ($total_row + $total_rows), $value);

            $sheet->getStyle('AW' . ($total_row + $total_rows))->getNumberFormat()->setFormatCode($format_number);
            $sheet->getStyle('BG' . ($total_row + $total_rows))->getNumberFormat()->setFormatCode($format_number);

            $total_rows++;
        }

        $sheet->SetCellValue('G' . ($total_row + $total_rows + 1), $order['products_total']);
        $sheet->SetCellValue('L' . ($total_row + $total_rows + 10), mb_ucfirst(num2str($order_total)));

        $r = $total_row;

        $i = 1;
        $quality = 0;
        $cell = [];

        foreach ($order['product'] as $product) {
            $sheet->insertNewRowBefore($r, 1);

            $cell[] = 'B' . $r . ':D' . $r;// номер
            $cell[] = 'E' . $r . ':U' . $r;// наименование
            $cell[] = 'V' . $r . ':W' . $r;// код
            $cell[] = 'X' . $r . ':Y' . $r;// Артикул
            $cell[] = 'Z' . $r . ':AA' . $r;// Цвет
            $cell[] = 'AB' . $r . ':AD' . $r;// шт
            $cell[] = 'AE' . $r . ':AG' . $r;// океи
            $cell[] = 'AH' . $r . ':AI' . $r;// Вид упаковки
            $cell[] = 'AJ' . $r . ':AK' . $r;// в одном месте
            $cell[] = 'AL' . $r . ':AM' . $r;// мест, штук
            $cell[] = 'AN' . $r . ':AP' . $r;// Масса брутто
            $cell[] = 'AQ' . $r . ':AS' . $r;// Количество (масса нетто)
            $cell[] = 'AT' . $r . ':AV' . $r;// Цена руб. коп
            $cell[] = 'AW' . $r . ':AY' . $r;// Сумма без учета НДС, руб. коп
            $cell[] = 'AZ' . $r . ':BB' . $r;// ставка,%
            $cell[] = 'BC' . $r . ':BF' . $r;// сумма, руб. коп
            $cell[] = 'BG' . $r . ':BJ' . $r;// Сумма с учетом НДС, руб. коп

            foreach ($cell as $cel) {
                $sheet->mergeCells($cel);
            }

            $default_height = 12;
            $report_name = htmlspecialchars_decode($product['report_name']);

            $height = 12 + 6 * intval(mb_strlen($product['model'], "UTF-8") / 10);

            if ($height > $default_height) {
                $default_height = $height;
            }

            $height = 12 + 6 * intval(mb_strlen($report_name, "UTF-8") / 50);

            if ($height > $default_height) {
                $default_height = $height;
            }

            $sheet->getRowDimension($r)->setRowHeight($default_height);

            $sheet->getStyle('E' . $r . ':BK' . $r)->getAlignment()->setWrapText(true);

            $sheet->getStyle("B$r:BJ$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $sheet->getStyle("E$r:U$r")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $sheet->getStyle('AT' . $r)->getNumberFormat()->setFormatCode($format_number);
            $sheet->getStyle('AW' . $r)->getNumberFormat()->setFormatCode($format_number);
            $sheet->getStyle('BG' . $r)->getNumberFormat()->setFormatCode($format_number);

            $sheet->SetCellValue('B' . $r, $i);
            $sheet->SetCellValue('E' . $r, htmlspecialchars_decode($product['report_name']));
            $sheet->SetCellValue('X' . $r, $product['model']);
            $sheet->SetCellValue('AB' . $r, 'шт.');
            $sheet->SetCellValue('AE' . $r, '796');
            $sheet->SetCellValue('AH' . $r, '');
            $sheet->SetCellValue('AQ' . $r, $product['quantity']);
            $sheet->SetCellValue('AT' . $r, $product['price']);
            $sheet->SetCellValue('AW' . $r, $product['total']);
            $sheet->SetCellValue('AZ' . $r, 'Без НДС');
            $sheet->SetCellValue('BG' . $r, $product['total']);

            $sheet->getStyle('E' . $r)->getAlignment()->setIndent(1);

            $quality += $product['quantity'];

            $sheet->setBreak("A$r", Worksheet::BREAK_ROW);

            $i++;
            $r++;
        }

        $finish = 32 + count($order['product']);

        $sheet->getStyle('AT30:AT' . $finish)->getNumberFormat()->setFormatCode($format_number);
        $sheet->getStyle('AW30:AW' . $finish)->getNumberFormat()->setFormatCode($format_number);
        $sheet->getStyle('BG30:BG' . $finish)->getNumberFormat()->setFormatCode($format_number);

        $sheet->SetCellValue("AQ$r", $quality);

        $r += $total_rows - 1;

        $sheet->SetCellValue("AQ$r", $quality);

        $this->setFont0($sheet);

        if ($r > 50) {
            $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(26, 29);
            $sheet->getHeaderFooter()
                ->setOddHeader('&L&B' . $spreadsheet->getProperties()->getTitle() . '&R Страница &P из &N');
            $sheet->getHeaderFooter()
                ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&R Страница &P из &N');
        }

        return $spreadsheet;
    }

    public function log($string)
    {
        file_put_contents("php://stderr", date("Y-m-d H:i:s:").rtrim(is_array($string) ? json_encode($string) : $string)."\n");
    }
}

<?php
include_once("xlsxwriter.class.php");

require 'vendors/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class ControllerSaleOrder extends Controller
{
    private $error = array();

    public function index() {
        $this->language->load('sale/documents');

        $this->language->load('sale/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/order');

    }

    /**
     * переводит первый символ строки в верхний регистр
     *
     * @param string $string
     * @param string $enc
     *
     * @return string
     */
    public function mb_ucfirst($string, $enc = 'UTF-8') {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }

    public function num2str2($inns, $stripkop = false) {
        $num = str_replace(' ', '', $inns);
        $num = str_replace('р.', '', $num);
        $num = str_replace('.', ',', $num);
        //print $num.'<br>';
        $inn      = $num;
        $nol      = 'ноль';
        $str[100] = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $str[11]  = array('', 'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать', 'двадцать');
        $str[10]  = array('', 'десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $sex      = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'), // m
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять') // f
        );
        $forms    = array(
            array('копейка', 'копейки', 'копеек', 1), // 10^-2
            array('рубль', 'рубля', 'рублей', 0), // 10^ 0
            array('тысяча', 'тысячи', 'тысяч', 1), // 10^ 3
            array('миллион', 'миллиона', 'миллионов', 0), // 10^ 6
            array('миллиард', 'миллиарда', 'миллиардов', 0), // 10^ 9
            array('триллион', 'триллиона', 'триллионов', 0), // 10^12
        );
        $out      = $tmp = array();

        $tmp = explode('.', str_replace(',', '.', $inn));
        $rub = number_format((float)$tmp[0], 0, '', '-');
        if ($rub == 0) $out[] = $nol;
        // нормализация копеек
        $kop      = isset($tmp[1]) ? substr(str_pad($tmp[1], 2, '0', STR_PAD_RIGHT), 0, 2) : '00';
        $segments = explode('-', $rub);
        $offset   = sizeof($segments);
        if ((int)$rub == 0) { // если 0 рублей
            $o[] = $nol;
            $o[] = $this->morph2(0, $forms[1][0], $forms[1][1], $forms[1][2]);
        } else {
            foreach ($segments as $k => $lev) {
                $sexi = (int)$forms[$offset][3]; // определяем род
                $ri   = (int)$lev; // текущий сегмент
                if ($ri == 0 && $offset > 1) { // если сегмент==0 & не последний уровень(там Units)
                    $offset--;
                    continue;
                }
                // нормализация
                $ri = str_pad($ri, 3, '0', STR_PAD_LEFT);
                // получаем циферки для анализа
                $r1  = (int)substr($ri, 0, 1); //первая цифра
                $r2  = (int)substr($ri, 1, 1); //вторая
                $r3  = (int)substr($ri, 2, 1); //третья
                $r22 = (int)$r2 . $r3; //вторая и третья
                // разгребаем порядки
                if ($ri > 99) $o[] = $str[100][$r1]; // Сотни
                if ($r22 > 20) { // >20
                    $o[] = $str[10][$r2];
                    $o[] = $sex[$sexi][$r3];
                } else { // <=20
                    if ($r22 > 9) $o[] = $str[11][$r22 - 9]; // 10-20
                    elseif ($r22 > 0) $o[] = $sex[$sexi][$r3]; // 1-9
                }
                // Рубли
                $o[] = $this->morph2($ri, $forms[$offset][0], $forms[$offset][1], $forms[$offset][2]);
                $offset--;
            }
        }
        // Копейки
        if (!$stripkop) {
            $o[] = $kop;
            $o[] = $this->morph2($kop, $forms[0][0], $forms[0][1], $forms[0][2]);
        }

        return preg_replace("/s{2,}/", ' ', implode(' ', $o));
    }

    /**
     * Склоняем словоформу
     */
    private function morph2($n, $f1, $f2, $f5) {
        $n  = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $f5;
        if ($n1 > 1 && $n1 < 5) return $f2;
        if ($n1 == 1) return $f1;

        return $f5;
    }

    private function prop($num) {
        # Все варианты написания чисел прописью от 0 до 999 скомпонуем в один небольшой массив
        $m = array(
            array('ноль'),
            array('-', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'),
            array('-', '-', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'),
            array('-', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'),
            array('-', 'одна', 'две')
        ); # Все варианты написания разрядов прописью скомпануем в один небольшой массив
        $r = array(
            array('...ллион', '', 'а', 'ов'), // используется для всех неизвестно больших разрядов
            array('тысяч', 'а', 'и', ''), array('миллион', '', 'а', 'ов'), array('миллиард', '', 'а', 'ов'), array('триллион', '', 'а', 'ов'), array('квадриллион', '', 'а', 'ов'),
            array('квинтиллион', '', 'а', 'ов')
        ); // ,array(... список можно продолжить );
        if ($num == 0) return $m[0][0]; # Если число ноль, сразу сообщить об этом и выйти
        $o = array(); # Сюда записываем все получаемые результаты преобразования
        # Разложим исходное число на несколько трехзначных чисел и каждое полученное такое число обработаем отдельно
        foreach (array_reverse(str_split(str_pad($num, ceil(strlen($num) / 3) * 3, '0', STR_PAD_LEFT), 3)) as $k => $p) {
            $o[$k] = array();
            # Алгоритм, преобразующий трехзначное число в строку прописью
            foreach ($n = str_split($p) as $kk => $pp)
                if (!$pp) continue;
                else
                    switch ($kk) {
                        case 0:
                            $o[$k][] = $m[4][$pp];
                            break;
                        case 1:
                            if ($pp == 1) {
                                $o[$k][] = $m[2][$n[2]];
                                break 2;
                            } else
                                $o[$k][] = $m[3][$pp];
                            break;
                        case 2:
                            if (($k == 1) && ($pp <= 2))
                                $o[$k][] = $m[5][$pp];
                            else
                                $o[$k][] = $m[1][$pp];
                            break;
                    }
            $p *= 1;
            if (!$r[$k]) $r[$k] = reset($r);
            # Алгоритм, добавляющий разряд, учитывающий окончание руского языка
            if ($p && $k)
                switch (true) {
                    case preg_match("/^[1]$|^\\d*[0,2-9][1]$/", $p):
                        $o[$k][] = $r[$k][0] . $r[$k][1];
                        break;
                    case preg_match("/^[2-4]$|\\d*[0,2-9][2-4]$/", $p):
                        $o[$k][] = $r[$k][0] . $r[$k][2];
                        break;
                    default:
                        $o[$k][] = $r[$k][0] . $r[$k][3];
                        break;
                }
            $o[$k] = implode(' ', $o[$k]);
        }

        return implode(' ', array_reverse($o));
    }

    private function russian_date($date) {
        $date = explode(".", $date);
        switch ($date[1]) {
            case 1:
                $m = 'января';
                break;
            case 2:
                $m = 'февраля';
                break;
            case 3:
                $m = 'марта';
                break;
            case 4:
                $m = 'апреля';
                break;
            case 5:
                $m = 'мая';
                break;
            case 6:
                $m = 'июня';
                break;
            case 7:
                $m = 'июля';
                break;
            case 8:
                $m = 'августа';
                break;
            case 9:
                $m = 'сентября';
                break;
            case 10:
                $m = 'октября';
                break;
            case 11:
                $m = 'ноября';
                break;
            case 12:
                $m = 'декабря';
                break;
        }

        return $date[0] . '&nbsp;' . $m . '&nbsp;' . $date[2];
    }

    public function createInvoiceNo() {
        $this->language->load('sale/documents');

        $this->language->load('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'checkout/order')) {
            $json['error'] = $this->language->get('error_permission');
        } elseif (isset($this->request->get['order_id'])) {
            $this->load->model('sale/order');

            $invoice_no = $this->model_sale_order->createInvoiceNo($this->request->get['order_id']);

            if ($invoice_no) {
                $json['invoice_no'] = $invoice_no;
            } else {
                $json['error'] = $this->language->get('error_action');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function invoice() {
        $this->language->load('sale/documents');

        $this->language->load('sale/order');

        $this->data['title'] = $this->language->get('heading_title');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_SERVER;
        } else {
            $this->data['base'] = HTTP_SERVER;
        }

        $this->data['direction'] = $this->language->get('direction');
        $this->data['language'] = $this->language->get('code');

        $this->data['text_invoice'] = $this->language->get('text_invoice');

        $this->language->load('sale/documents');
        $this->data['heading_title_pko']  = $this->language->get('heading_title_pko');
        $this->data['ko1']                = $this->language->get('ko1');
        $this->data['header_second']      = $this->language->get('header_second');
        $this->data['entry_org']          = $this->language->get('entry_org');
        $this->data['entry_codes']        = $this->language->get('entry_codes');
        $this->data['entry_kwit']         = $this->language->get('entry_kwit');
        $this->data['entry_okud_form']    = $this->language->get('entry_okud_form');
        $this->data['entry_to_pko']       = $this->language->get('entry_to_pko');
        $this->data['entry_okpo']         = $this->language->get('entry_okpo');
        $this->data['entry_get_from']     = $this->language->get('entry_get_from');
        $this->data['entry_struct']       = $this->language->get('entry_struct');
        $this->data['entry_pko']          = $this->language->get('entry_pko');
        $this->data['entry_num']          = $this->language->get('entry_num');
        $this->data['entry_date']         = $this->language->get('entry_date');
        $this->data['entry_osn']          = $this->language->get('entry_osn');
        $this->data['entry_debet']        = $this->language->get('entry_debet');
        $this->data['entry_kredit']       = $this->language->get('entry_kredit');
        $this->data['entry_sum']          = $this->language->get('entry_sum');
        $this->data['entry_kcn']          = $this->language->get('entry_kcn');
        $this->data['entry_order_no']     = $this->language->get('entry_order_no');
        $this->data['entry_ksp']          = $this->language->get('entry_ksp');
        $this->data['entry_ksss']         = $this->language->get('entry_ksss');
        $this->data['entry_au']           = $this->language->get('entry_au');
        $this->data['entry_sum_prop']     = $this->language->get('entry_sum_prop');
        $this->data['entry_from']         = $this->language->get('entry_from');
        $this->data['entry_digits']       = $this->language->get('entry_digits');
        $this->data['entry_also']         = $this->language->get('entry_also');
        $this->data['entry_prop']         = $this->language->get('entry_prop');
        $this->data['entry_nds']          = $this->language->get('entry_nds');
        $this->data['entry_mp']           = $this->language->get('entry_mp');
        $this->data['entry_pril']         = $this->language->get('entry_pril');
        $this->data['entry_buh']          = $this->language->get('entry_buh');
        $this->data['entry_podp_ras']     = $this->language->get('entry_podp_ras');
        $this->data['entry_podp']         = $this->language->get('entry_podp');
        $this->data['entry_kass']         = $this->language->get('entry_kass');
        $this->data['entry_get_kass']     = $this->language->get('entry_get_kass');
        $this->data['entry_not_selected'] = $this->language->get('entry_not_selected');
        $this->data['entry_payer']        = $this->language->get('entry_payer');
        $this->data['entry_products']     = $this->language->get('entry_products');
        $this->data['entry_kolvo']        = $this->language->get('entry_kolvo');
        $this->data['entry_price']        = $this->language->get('entry_price');
        $this->data['entry_manager']      = $this->language->get('entry_manager');
        $this->data['entry_rk']           = $this->language->get('entry_rk');
        $this->data['entry_pbuh']         = $this->language->get('entry_pbuh');
        $this->data['entry_itog']         = $this->language->get('entry_itog');
        $this->data['entry_vtch']         = $this->language->get('entry_vtch');
        $this->data['entry_itog_s_nds']   = $this->language->get('entry_itog_s_nds');
        $this->data['entry_post']         = $this->language->get('entry_post');
        $this->data['osn']                = $this->language->get('osn');
        $this->data['entry_kod_au']       = $this->language->get('entry_kod_au');
        $this->data['entry_paycheck']     = $this->language->get('entry_paycheck');
        $this->data['entry_all_naim']     = $this->language->get('entry_all_naim');
        $this->data['entry_to_summ']      = $this->language->get('entry_to_summ');
        $this->data['entry_who_gave']     = $this->language->get('entry_who_gave');
        $this->data['entry_who_receive']  = $this->language->get('entry_who_receive');
        $this->data['entry_product']      = $this->language->get('entry_product');
        $this->data['entry_real_text']    = $this->language->get('entry_real_text');
        $this->data['entry_buh_dov']      = $this->language->get('entry_buh_dov');
        $this->data['entry_rk_dov']       = $this->language->get('entry_rk_dov');

        $this->data['text_order_id']        = $this->language->get('text_order_id');
        $this->data['text_invoice_no']      = $this->language->get('text_invoice_no');
        $this->data['text_invoice_date']    = $this->language->get('text_invoice_date');
        $this->data['text_date_added']      = $this->language->get('text_date_added');
        $this->data['text_telephone']       = $this->language->get('text_telephone');
        $this->data['text_fax']             = $this->language->get('text_fax');
        $this->data['text_to']              = $this->language->get('text_to');
        $this->data['text_company_id']      = $this->language->get('text_company_id');
        $this->data['text_tax_id']          = $this->language->get('text_tax_id');
        $this->data['text_ship_to']         = $this->language->get('text_ship_to');
        $this->data['text_payment_method']  = $this->language->get('text_payment_method');
        $this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

        $this->data['column_product']  = $this->language->get('column_product');
        $this->data['column_model']    = $this->language->get('column_model');
        $this->data['column_quantity'] = $this->language->get('column_quantity');
        $this->data['column_price']    = $this->language->get('column_price');
        $this->data['column_total']    = $this->language->get('column_total');
        $this->data['column_comment']  = $this->language->get('column_comment');

        $this->load->model('sale/order');
        $this->load->model('setting/setting');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }

        $order_info = $this->model_sale_order->getOrder($order_id);

        if ($order_info) {
            $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

            if ($store_info) {
                $store_address   = $store_info['config_address'];
                $store_email     = $store_info['config_email'];
                $store_telephone = $store_info['config_telephone'];
                $store_fax       = $store_info['config_fax'];
                $store_buh       = isset($store_info['config_glbuh']) ? $store_info['config_glbuh'] : '';
                $store_kass      = isset($store_info['config_kass']) ? $store_info['config_kass'] : '';
                $store_owner     = isset($store_info['config_owner']) ? $store_info['config_owner'] : '';
                $store_manager   = isset($store_info['config_manager']) ? $store_info['config_manager'] : '';
                $store_rk_dov    = isset($store_info['config_rk_dov']) ? $store_info['config_rk_dov'] : '';
                $store_buh_dov   = isset($store_info['config_buh_dov']) ? $store_info['config_buh_dov'] : '';
                $store_org       = isset($store_info['config_org']) ? $store_info['config_org'] : '';
                $store_inn       = isset($store_info['config_inn']) ? $store_info['config_inn'] : '';
                $store_requisites  = isset($store_info['config_requisites']) ? $store_info['config_requisites'] : '';
            } else {
                $store_address   = $this->config->get('config_address');
                $store_email     = $this->config->get('config_email');
                $store_telephone = $this->config->get('config_telephone');
                $store_fax       = $this->config->get('config_fax');
                $store_buh       = $this->config->get('config_glbuh');
                $store_kass      = $this->config->get('config_kass');
                $store_owner     = $this->config->get('config_owner');
                $store_manager   = $this->config->get('config_manager');
                $store_rk_dov    = $this->config->get('config_rk_dov');
                $store_buh_dov   = $this->config->get('config_buh_dov');
                $store_org       = $this->config->get('config_org');
                $store_inn       = $this->config->get('config_inn');
                $store_requisites  = $this->config->get('config_requisites');
            }

            if ($order_info['invoice_no']) {
                $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $invoice_no = '';
            }

            if ($order_info['shipping_address_format']) {
                $format = $order_info['shipping_address_format'];
            } else {
                $format = '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
            }

            $find = array(
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
            );

            $replace = array(
                'firstname' => $order_info['shipping_firstname'],
                'lastname'  => $order_info['shipping_lastname'],
                'company'   => $order_info['shipping_company'],
                'address_1' => $order_info['shipping_address_1'],
                'address_2' => $order_info['shipping_address_2'],
                'city'      => $order_info['shipping_city'],
                'postcode'  => $order_info['shipping_postcode'],
                'zone'      => $order_info['shipping_zone'],
                'zone_code' => $order_info['shipping_zone_code'],
                'country'   => $order_info['shipping_country']
            );

            $shipping_address = str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ' ,', trim(str_replace($find, $replace, $format))));

            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                $format = '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
            }

            if (!$order_info['customer_id']) {
                $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '0' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
            } else {
                $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
            }

            if (isset($customer_custom['data'])) {
                $customer_custom = unserialize($customer_custom['data']);
            }

            $find = array(
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
            );

            $customer_type = isset($customer_custom['custom_customer_type']) ? "{$customer_custom['custom_customer_type']['value']}": '';

            if ($customer_type == 'ip') {
                $inn = !empty($customer_custom['custom_inn']) ? "ИНН {$customer_custom['custom_inn']['value']}" : '';
                $kpp = !empty($customer_custom['custom_kpp']) ? "КПП {$customer_custom['custom_kpp']['value']}" : '';
                $custom_company = !empty($customer_custom['custom_company']) ? "{$customer_custom['custom_company']['value']}" : '';
            } elseif ($customer_type == 'legal') {
                $inn = !empty($customer_custom['custom_legal_inn']) ? "ИНН {$customer_custom['custom_legal_inn']['value']}" : '';
                $kpp = !empty($customer_custom['custom_legal_kpp']) ? "КПП {$customer_custom['custom_legal_kpp']['value']}" : '';
                $custom_company = !empty($customer_custom['custom_legal_company']) ? "{$customer_custom['custom_legal_company']['value']}" : '';
            } else {
                $inn =  '';
                $kpp =  '';
                $custom_company = '';
            }

            $replace = array(
                // Custom fields
                'customer_type'  => isset($customer_custom['custom_customer_type']) ? "{$customer_custom['custom_customer_type']['text']}" : '',
                'patronymic'     => isset($customer_custom['custom_middlename']['value']) ? "{$customer_custom['custom_middlename']['value']}" : '',
                'inn' => $inn,
                'kpp' => $kpp,
                'custom_company' => $custom_company,

                'firstname'      => $order_info['payment_firstname'],
                'lastname'       => $order_info['payment_lastname'],
                'company'        => $order_info['payment_company'],
                'address_1'      => $order_info['payment_address_1'],
                'address_2'      => $order_info['payment_address_2'],
                'city'           => $order_info['payment_city'],
                'postcode'       => $order_info['payment_postcode'],
                'zone'           => $order_info['payment_zone'],
                'zone_code'      => $order_info['payment_zone_code'],
                'country'        => $order_info['payment_country']
            );

            if (strlen($replace['custom_company']))
                if ($format == '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}')
                    $format = '{custom_company}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';

            $payment_address = str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format))));

            $product_data = array();

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

            $this->data['orders'][] = array(
                'total_2_str'                 => $this->mb_ucfirst($this->num2str2($ind)),
                'products_order_total'        => isset($clean_products_total) ? $clean_products_total : '',
                'products_order_total_valute' => $this->currency->format(isset($clean_products_total) ? $clean_products_total : '0'),
                'products_order_total_prop'   => $this->mb_ucfirst($this->num2str2(isset($clean_products_total) ? $clean_products_total : 0)),
                'products_total'              => $this->mb_ucfirst($this->prop(isset($products_total) ? $products_total : 0)),
                'clean_products_nds'          => isset($clean_products_nds) ? $clean_products_nds : '0',

                'order_id'                    => $order_id,
                'invoice_no'                  => $invoice_no,
                'date_added'                  => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
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
                'telephone'                   => $order_info['telephone'],
                'shipping_address'            => $shipping_address,
                'shipping_method'             => $order_info['shipping_method'],
                'payment_address'             => $payment_address,
                'payment_company_id'          => $order_info['payment_company_id'],
                'payment_tax_id'              => $order_info['payment_tax_id'],
                'payment_method'              => $order_info['payment_method'],
                'product'                     => $product_data,
                'voucher'                     => $voucher_data,
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
                'date_rus'                    => $this->russian_date(date($this->language->get('date_format_short'), strtotime($order_info['date_added']))),
                'index_nova'                  => str_replace(',', '-', str_replace('.', '-', str_replace('р.', '', $ind))),
                'full_total_text'             => $this->num2str2($ind),

                'total'                       => $total_data,
                'comment'                     => nl2br($order_info['comment'])
            );

            $order = $this->data['orders'][0];
            $order['shipping_code'] = $order_info['shipping_code'];
            $order['shipping_method'] = $order_info['shipping_method'];
            $order['shipping_cost'] = $shipping_cost;

            if (isset($this->request->get['html'])) {
                $spreadsheet = $this->make_spreadsheet($order, false);

                $writer = new Html($spreadsheet);
                $writer->save('php://output');
            } elseif (isset($this->request->get['excel'])) {
                $spreadsheet = $this->make_spreadsheet($order, true);

                ob_start();
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                $excelOutput = ob_get_clean();

                $this->response->addheader('Cache-Control: public');// needed for internet explorer
                $this->response->addheader('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $this->response->addheader('Content-Transfer-Encoding: binary');
                $this->response->addheader('Content-Disposition: attachment; filename=Заказ_' . $order['order_id'] . '.xlsx');
                if (function_exists('mb_strlen')) {
                    header("Content-Length:" . mb_strlen($excelOutput, '8bit'));
                } else {
                    header("Content-Length:" . strlen($excelOutput));
                }

                $this->response->setOutput($excelOutput);
            } else {

                if (isset($this->request->get['doctype'])) {
                    $doctype = $this->request->get['doctype'];
                    $this->template = $this->config->get('config_template') . '/template/sale/documents/order_' . $doctype . '.tpl';
                } else {
                    $this->template = $this->config->get('config_template') . '/template/sale/order_invoice.tpl';
                }

                $this->response->setOutput($this->render());
            }
        } else {
            $this->response->setOutput('Нет номера заказа!');
        }
    }

    /**
     * @param $order
     * @param $grid bool отображать сетку
     *
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function make_spreadsheet($order, $grid = false) {
        $order_id = $order['order_id'];

        $font8 = [
            'font' => [
                'name' => 'Arial',
                'bold' => false,
                'size' => 8,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $font9 = [
            'font' => [
                'name' => 'Arial',
                'bold' => false,
                'size' => 9,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $font9b = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'size' => 9,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $font10 = [
            'font' => [
                'name' => 'Arial',
                'bold' => false,
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $border_thin = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10)->setName('Arial');

        $spreadsheet->getProperties()
                    ->setCreator("admin")
                    ->setLastModifiedBy("admin")
                    ->setTitle("Заказ № {$order_id}")
                    ->setSubject("Заказ № {$order_id}")
                    ->setDescription(
                        "Заказ № {$order_id} от {$order['date_added']}г."
                    )
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Заказ");

        $sheet->getPageMargins()->setTop(0.1);
        $sheet->getPageMargins()->setRight(0);
        $sheet->getPageMargins()->setLeft(0.1);
        $sheet->getPageMargins()->setBottom(0);

        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(false);

        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getPageSetup()->setOrientation('portrait');

        $sheet->setShowGridlines($grid);

        for ($r = 1;$r < 40;$r++) {
            $sheet->getColumnDimensionByColumn($r)->setWidth(3.5);
        }

        /* задаём ширину колонок */
        $sheet->getColumnDimension("A")->setWidth(1);
        $sheet->getColumnDimension("AM")->setWidth(1);

        $r = 1;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->mergeCells("B$r:AL$r"); // 2
        $sheet->getStyle("B$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->getRowDimension($r)->setRowHeight(36);
        $sheet->setCellValue("B$r", 'Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.');
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:AL".($r+6))->applyFromArray($font10); // 4
        $sheet->mergeCells("B$r:S".($r+1));
        $sheet->setCellValue("B$r", 'СБЕРБАНК РОССИИ ПАО Г. МОСКВА');
        $sheet->getStyle("B$r:S".($r+2))->applyFromArray($border_thin);
        $sheet->mergeCells("T$r:V$r");
        $sheet->setCellValue("T$r", 'БИК');
        $sheet->getStyle("T$r:V$r")->applyFromArray($border_thin);
        $sheet->mergeCells("W$r:AL$r");
        $sheet->setCellValue("W$r", '044525225');
        $sheet->getStyle("W$r:AL".($r+2))->applyFromArray($border_thin);
        $r++;

        $sheet->mergeCells("T$r:V".($r+1));
        $sheet->setCellValue("T$r", 'Сч. №');
        $sheet->getStyle("T$r:V".($r+1))->applyFromArray($border_thin);
        $sheet->mergeCells("W$r:AL".($r+1));
        $sheet->setCellValue("W$r", '30101810400000000225');
        $r++;


        $sheet->mergeCells("B$r:S$r"); // 6
        $sheet->getStyle("B$r:S$r")->applyFromArray($font8);
        $sheet->getStyle("B$r:S$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue("B$r", 'Банк получателя');
        $r++;

        $sheet->mergeCells("B$r:D$r");
        $sheet->setCellValue("B$r", 'ИНН');
        $sheet->mergeCells("E$r:J$r");
        $sheet->setCellValueExplicit("E$r", '502912149767', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle("B$r:J$r")->applyFromArray($border_thin);
        $sheet->mergeCells("K$r:M$r");
        $sheet->setCellValue("K$r", 'КПП');
        $sheet->mergeCells("N$r:S$r");
        $sheet->setCellValue("N$r", ' ');
        $sheet->getStyle("K$r:S$r")->applyFromArray($border_thin);
        $sheet->mergeCells("T$r:V".($r+3));
        $sheet->setCellValue("T$r", 'Сч. №');
        $sheet->getStyle("T$r:V".($r+3))->applyFromArray($border_thin);
        $sheet->mergeCells("W$r:AL".($r+3));
        $sheet->setCellValue("W$r", '40802810940000010248');
        $sheet->getStyle("W$r:AL".($r+3))->applyFromArray($border_thin);
        $r++;

        $sheet->mergeCells("B$r:S".($r+1)); // 8
        $sheet->getStyle("B$r:S$r")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("B$r", 'Индивидуальный предприниматель Масенко Елена Владимировна');
        $sheet->getStyle("B$r:S".($r+2))->applyFromArray($border_thin);
        $r++;

        $r++;

        $sheet->mergeCells("B$r:S$r"); // 10
        $sheet->getStyle("B$r:S$r")->applyFromArray($font8);
        $sheet->getStyle("B$r:S$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue("B$r", 'Получатель');
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:AL".($r+10))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $date = strtotime($order['date_added']); // 12
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $sheet->mergeCells("B$r:AL$r");
        $sheet->getStyle("B$r:AL$r")->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension($r)->setRowHeight(36);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("B$r:AL$r")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->setCellValue("B$r", 'Заказ № ' . $order['order_id'] . ' от ' . strftime('%d %B %Y', $date) . ' г.');
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
        $sheet->getRowDimension($r)->setRowHeight(30);
        $sheet->mergeCells("B$r:G$r"); // 14
        $sheet->setCellValue("B$r", 'Поставщик');
        $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
        $sheet->mergeCells("H$r:AL$r");
        $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("H$r", 'Индивидуальный предприниматель Масенко Елена Владимировна, ИНН 502912149767, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: 8-909-628-81-40');
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
        $sheet->getRowDimension($r)->setRowHeight(30);
        $sheet->mergeCells("B$r:G$r"); // 16
        $sheet->setCellValue("B$r", 'Грузоотправитель');
        $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
        $sheet->mergeCells("H$r:AL$r");
        $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("H$r", 'Индивидуальный предприниматель Масенко Елена Владимировна, ИНН 502912149767, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: 8-909-628-81-40');
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
        $sheet->getRowDimension($r)->setRowHeight(30);
        $sheet->mergeCells("B$r:G$r"); // 18
        $sheet->setCellValue("B$r", 'Покупатель:');
        $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
        $sheet->mergeCells("H$r:AL$r");
        $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("H$r", html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']));
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
        $sheet->getRowDimension($r)->setRowHeight(30);
        $sheet->mergeCells("B$r:G$r"); // 20
        $sheet->setCellValue("B$r", 'Грузополучатель:');
        $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
        $sheet->mergeCells("H$r:AL$r");
        $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("H$r", html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']));
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:AL$r")->applyFromArray($font10);
        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:C$r"); // 22
        $sheet->setCellValue("B$r", '№:');
        $sheet->getStyle("B$r:C$r")->applyFromArray($border_thin);
        $sheet->mergeCells("D$r:G$r");
        $sheet->setCellValue("D$r", 'Артикул');
        $sheet->getStyle("D$r:G$r")->applyFromArray($border_thin);
        $sheet->mergeCells("H$r:X$r");
        $sheet->setCellValue("H$r", 'Товары (работы, услуги)');
        $sheet->getStyle("H$r:X$r")->applyFromArray($border_thin);
        $sheet->mergeCells("Y$r:AA$r");
        $sheet->setCellValue("Y$r", 'Кол-во');
        $sheet->getStyle("Y$r:AA$r")->applyFromArray($border_thin);
        $sheet->mergeCells("AB$r:AC$r");
        $sheet->setCellValue("AB$r", 'Ед.');
        $sheet->getStyle("AB$r:AC$r")->applyFromArray($border_thin);
        $sheet->mergeCells("AD$r:AG$r");
        $sheet->setCellValue("AD$r", 'Цена');
        $sheet->getStyle("AD$r:AG$r")->applyFromArray($border_thin);
        $sheet->mergeCells("AH$r:AL$r");
        $sheet->setCellValue("AH$r", 'Сумма');
        $sheet->getStyle("AH$r:AL$r")->applyFromArray($border_thin);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setIndent(0);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setWrapText(true);
        $sheet->getStyle("B$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
        $r++;

        $i   = 0;
        $sum = 0.00;
        foreach ($order['product'] as $product) {
            $i++;
            $clean_total = (float)str_replace(',', '', $product['total']);
            $sum += $clean_total;

            $pname       = html_entity_decode($product['report_name']);
            $s['height'] = 14 + 6 * intval(strlen($pname) / 55);
            foreach ($product['option'] as $option)
                $pname .= ' ' . $option['value'];

            $product['price'] = str_replace(",", "", $product['price']);

            $sheet->getStyle("B$r:S$r")->applyFromArray($font8);
            $sheet->getRowDimension($r)->setRowHeight(30);

            $sheet->mergeCells("B$r:C$r");
            $sheet->getStyle("B$r:C$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $sheet->setCellValue("B$r", $i);
            $sheet->getStyle("B$r:C$r")->applyFromArray($border_thin);

            $sheet->mergeCells("D$r:G$r");
            $sheet->setCellValue("D$r", $product['model']);
            $sheet->getStyle("D$r:G$r")->applyFromArray($border_thin);

            $sheet->mergeCells("H$r:X$r");
            $sheet->getStyle("H$r:X$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("H$r", $pname);
            $sheet->getStyle("H$r:X$r")->applyFromArray($border_thin);

            $sheet->mergeCells("Y$r:AA$r");
            $sheet->getStyle("Y$r:AA$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $sheet->setCellValue("Y$r", $product['quantity']);
            $sheet->getStyle("Y$r:AA$r")->applyFromArray($border_thin);

            $sheet->mergeCells("AB$r:AC$r");
            $sheet->getStyle("AB$r:AC$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $sheet->setCellValue("AB$r", 'шт');
            $sheet->getStyle("AB$r:AC$r")->applyFromArray($border_thin);

            $sheet->mergeCells("AD$r:AG$r");
            $sheet->getStyle("AD$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue("AD$r", number_format($product['price'], 2, ",", " "));
            $sheet->getStyle("AD$r:AG$r")->applyFromArray($border_thin);

            $sheet->mergeCells("AH$r:AL$r");
            $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue("AH$r", number_format($clean_total, 2, ",", " "));
            $sheet->getStyle("AH$r:AL$r")->applyFromArray($border_thin);

            $r++;
        }

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:AG$r");
        $sheet->setCellValue("B$r", 'Итого:');
        $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->mergeCells("AH$r:AL$r");
        $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue("AH$r", number_format($sum, 2, ",", " "));
        $r++;

        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:AG$r");
        $sheet->setCellValue("B$r", 'Без налога (НДС)');
        $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->mergeCells("AH$r:AL$r");
        $sheet->setCellValue("AH$r", ' ');
        $r++;

        if ($order['shipping_code'] == 'customer_group.customer_group1' || $order['shipping_code'] == 'customer_group.customer_group2' || $order['shipping_code'] == 'customer_group.customer_group5' || $order['shipping_code'] == 'customer_group.customer_group6') {
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:AG$r");
            $sheet->setCellValue("B$r", $order['shipping_method'] . ':');
            $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->mergeCells("AH$r:AL$r");
            $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue("AH$r", number_format($order['shipping_cost'], 2, ",", " "));
            $sum += $order['shipping_cost'];
            $r++;
        }

        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:AG$r");
        $sheet->setCellValue("B$r", 'Всего к оплате:');
        $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->mergeCells("AH$r:AL$r");
        $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue("AH$r", number_format($sum, 2, ",", " "));
        $r++;

        $sheet->mergeCells("B$r:AL$r");
        $sheet->setCellValue("B$r", "Всего наименований ".count($order['product']).", на сумму ". number_format($order['free_all_sum'], 2, ',', ' ') ." руб.");
        $r++;

        $sheet->mergeCells("B$r:AL$r");
        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->setCellValue("B$r", $order['total_2_str']);
        $r++;

        $sheet->mergeCells("B$r:AL$r");
        $sheet->setCellValue("B$r", '');
        $sheet->getRowDimension($r)->setRowHeight(6);
        $sheet->getStyle("B$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:F$r");
        $sheet->setCellValue("B$r", 'Руководитель');
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'Масенко Е. В.');
        $r++;

        $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
        $sheet->mergeCells("H$r:P$r");
        $sheet->setCellValue("H$r", 'должность');
        $sheet->getStyle("H$r:P$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->mergeCells("R$r:AA$r");
        $sheet->setCellValue("R$r", 'подпись');
        $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'расшифровка подписи');
        $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:L$r");
        $sheet->setCellValue("B$r", 'Главный (старший) бухгалтер');
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'Масенко Е. В.');
        $r++;

        $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
        $sheet->mergeCells("H$r:P$r");
        $sheet->setCellValue("H$r", ' ');
        $sheet->mergeCells("R$r:AA$r");
        $sheet->setCellValue("R$r", 'подпись');
        $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'расшифровка подписи');
        $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $r++;

        $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

        $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
        $sheet->mergeCells("B$r:L$r");
        $sheet->setCellValue("B$r", 'Ответственный');
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'Масенко Е. В.');
        $r++;

        $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
        $sheet->mergeCells("H$r:P$r");
        $sheet->setCellValue("H$r", ' ');
        $sheet->mergeCells("R$r:AA$r");
        $sheet->setCellValue("R$r", 'подпись');
        $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->mergeCells("AC$r:AL$r");
        $sheet->setCellValue("AC$r", 'расшифровка подписи');
        $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $r++;

        return $spreadsheet;
    }

    public function make_xlsx_invoice($order) {
        $writer         = new XLSXWriter();
        $sheet          = 'Sheet1';
        $col_widths     = array_fill(0, 39, 2.9);
        $col_widths[0]  = 1;
        $col_widths[38] = 1;
        $writer->writeSheetHeader($sheet, $rowdata = array("" => ""), $col_options = array('widths' => $col_widths), $row_options = array('height' => 1));

        $writer->writeSheetRow($sheet, $rowdata = array("", "Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате\nобязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту\nприхода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта."), $row_options = array('height' => 36, 'halign' => 'center', 'valign' => 'center', 'font-size' => 8, 'wrap_text' => true));

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));

        $r               = array_fill(0, 39, "");
        $r[1]            = "СБЕРБАНК РОССИИ ПАО Г. МОСКВА";
        $r[19]           = "БИК";
        $r[22]           = "044525225";
        $s               = array_fill(0, 39, array('font-size' => 10, 'valign' => 'top', 'border' => 'top', 'border-style' => 'thin'));
        $s['height']     = 14;
        $s[0]['border']  = '';
        $s[1]['border']  = 'left,top';
        $s[19]['border'] = 'left,top';
        $s[21]['border'] = 'right,top';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 3, $start_col = 1, $end_row = 4, $end_col = 18);
        $writer->markMergedCell($sheet, $start_row = 3, $start_col = 19, $end_row = 3, $end_col = 21);
        $writer->markMergedCell($sheet, $start_row = 3, $start_col = 22, $end_row = 3, $end_col = 37);

        $f = array_fill(0, 39, "string");
        $writer->updateFormat($sheet, $f);
        $r               = array_fill(0, 39, "");
        $r[19]           = "Сч. №";
        $r[22]           = "30101810400000000225";
        $s               = array_fill(0, 39, array('font-size' => 10, 'valign' => 'top', 'border-style' => 'thin'));
        $s['height']     = 14;
        $s[1]['border']  = 'left';
        $s[19]['border'] = 'left,top';
        $s[20]['border'] = 'top';
        $s[21]['border'] = 'right,top';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 4, $start_col = 19, $end_row = 5, $end_col = 21);
        $writer->markMergedCell($sheet, $start_row = 4, $start_col = 22, $end_row = 5, $end_col = 37);

        $r               = array_fill(0, 39, "");
        $r[1]            = "Банк получателя";
        $s               = array_fill(0, 39, array('font-size' => 8, 'valign' => 'top', 'border-style' => 'thin', 'border' => 'bottom'));
        $s['height']     = 10;
        $s[0]['border']  = '';
        $s[1]['border']  = 'left,bottom';
        $s[19]['border'] = 'left,bottom';
        $s[20]['border'] = 'bottom';
        $s[21]['border'] = 'right,bottom';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 5, $start_col = 1, $end_row = 5, $end_col = 18);

        $r               = array_fill(0, 39, "");
        $r[1]            = "ИНН";
        $r[3]            = "502912149767";
        $r[10]           = "КПП";
        $r[19]           = "Сч. №";
        $r[22]           = "40802810940000010248";
        $s               = array_fill(0, 39, array('font-size' => 10, 'valign' => 'top', 'border-style' => 'thin'));
        $s['height']     = 12;
        $s[1]['border']  = 'left';
        $s[10]['border'] = 'left';
        $s[18]['border'] = 'right,bottom';
        $s[19]['border'] = 'left';
        $s[22]['border'] = 'left';
        $s[37]['border'] = 'right';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 1, $end_row = 6, $end_col = 2);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 3, $end_row = 6, $end_col = 9);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 10, $end_row = 6, $end_col = 12);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 13, $end_row = 6, $end_col = 18);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 19, $end_row = 9, $end_col = 21);
        $writer->markMergedCell($sheet, $start_row = 6, $start_col = 22, $end_row = 9, $end_col = 37);

        $r              = array_fill(0, 39, "");
        $r[1]           = "Индивидуальный предприниматель Масенко Елена Владимировна";
        $s              = array_fill(0, 39, array('font-size' => 10, 'valign' => 'top', 'border-style' => 'thin', 'wrap_text' => true));
        $s['height']    = 10;
        $s[1]['border'] = 'left,top';
        for ($i = 2; $i <= 18; $i++)
            $s[$i]['border'] = 'top';
        $s[19]['border'] = 'left';
        $s[18]['border'] = 'right';
        $s[22]['border'] = 'left';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 7, $start_col = 1, $end_row = 8, $end_col = 18);

        $s               = array_fill(0, 39, array('border-style' => 'thin'));
        $s['height']     = 15;
        $s[0]['border']  = 'right';
        $s[1]['border']  = 'left';
        $s[18]['border'] = 'right';
        $s[19]['border'] = 'left';
        $s[22]['border'] = 'left';
        $s[37]['border'] = 'right';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = array_fill(0, 39, ""), $row_options = $s);

        $r               = array_fill(0, 39, "");
        $r[1]            = "Получатель";
        $s               = array_fill(0, 39, array('font-size' => 8, 'border-style' => 'thin', 'border' => 'bottom'));
        $s['height']     = 10;
        $s[0]['border']  = '';
        $s[1]['border']  = 'left,bottom';
        $s[18]['border'] = 'right,bottom';
        $s[19]['border'] = 'left,bottom';
        $s[22]['border'] = 'left,bottom';
        $s[38]['border'] = 'left';
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 9, $start_col = 1, $end_row = 9, $end_col = 18);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));

        $date = strtotime($order['date_added']);
        setlocale(LC_ALL, 'ru_RU.UTF-8');

        $s           = array_fill(0, 39, array('valign' => 'center', 'font-size' => 14, 'font-style' => 'bold', 'border' => 'bottom', 'border-style' => 'medium'));
        $s['height'] = 36;
        $s[0]        = array();
        $s[38]       = array();
        $writer->writeSheetRow($sheet, $rowdata = array("", "Заказ № " . $order['order_id'] . " от " . strftime('%d %B %Y', $date) . " г."), $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 11, $start_col = 1, $end_row = 11, $end_col = 37);

        $r           = array_fill(0, 39, "");
        $s           = array_fill(0, 39, array('border' => 'top', 'border-style' => 'medium'));
        $s[0]        = array();
        $s[38]       = array();
        $s['height'] = 11;
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);

        $r           = array_fill(0, 39, "");
        $r[1]        = "Поставщик:";
        $r[7]        = "Индивидуальный предприниматель Масенко Елена Владимировна, ИНН 502912149767, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: 8-909-628-81-40";
        $s           = array_fill(0, 39, array());
        $s['height'] = 28;
        $s[1]        = array('valign' => 'center', 'font-size' => 9);
        $s[7]        = array('font-style' => 'bold', 'valign' => 'center', 'wrap_text' => true, 'font-size' => 9);
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 13, $start_col = 1, $end_row = 13, $end_col = 6);
        $writer->markMergedCell($sheet, $start_row = 13, $start_col = 7, $end_row = 13, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));

        $r           = array_fill(0, 39, "");
        $r[1]        = "Грузоотправитель:";
        $r[7]        = "Индивидуальный предприниматель Масенко Елена Владимировна, ИНН 502912149767, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: 8-909-628-81-40";
        $s           = array_fill(0, 39, array());
        $s['height'] = 28;
        $s[1]        = array('valign' => 'center', 'font-size' => 9);
        $s[7]        = array('font-style' => 'bold', 'valign' => 'center', 'wrap_text' => true, 'font-size' => 9);
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 15, $start_col = 1, $end_row = 15, $end_col = 6);
        $writer->markMergedCell($sheet, $start_row = 15, $start_col = 7, $end_row = 15, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));


        $r    = array_fill(0, 39, "");
        $r[1] = "Покупатель:";
        $r[7] = html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']) ;
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 17, $start_col = 1, $end_row = 17, $end_col = 6);
        $writer->markMergedCell($sheet, $start_row = 17, $start_col = 7, $end_row = 17, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));

        $r    = array_fill(0, 39, "");
        $r[1] = "Грузополучатель:";
        $r[7] = html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']) ;
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 19, $start_col = 1, $end_row = 19, $end_col = 6);
        $writer->markMergedCell($sheet, $start_row = 19, $start_col = 7, $end_row = 19, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 11));

        // table products header

        $r               = array_fill(0, 39, "");
        $r[1]            = "№";
        $r[3]            = "Артикул";
        $r[7]            = "Товары (работы, услуги)";
        $r[24]           = "Кол-во";
        $r[27]           = "Ед.";
        $r[29]           = "Цена";
        $r[33]           = "Сумма";
        $s               = array_fill(0, 39, array('halign' => 'center', 'font-size' => 10, 'font-style' => 'bold', 'border' => 'top,bottom', 'border-style' => 'thin'));
        $s[0]['border']  = 'right';
        $s[1]['border']  = 'left,top,bottom';
        $s[3]['border']  = 'left,top,bottom';
        $s[7]['border']  = 'left,top,bottom';
        $s[24]['border'] = 'left,top,bottom';
        $s[27]['border'] = 'left,top,bottom';
        $s[29]['border'] = 'left,top,bottom';
        $s[33]['border'] = 'left,top,bottom';
        $s[38]['border'] = 'left';
        //$s['height'] = 14;

        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 1, $end_row = 21, $end_col = 2);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 3, $end_row = 21, $end_col = 6);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 7, $end_row = 21, $end_col = 23);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 24, $end_row = 21, $end_col = 26);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 27, $end_row = 21, $end_col = 28);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 29, $end_row = 21, $end_col = 32);
        $writer->markMergedCell($sheet, $start_row = 21, $start_col = 33, $end_row = 21, $end_col = 37);

        // table products content

        $f     = array_fill(0, 39, "string");
        $f[24] = "0";
        $f[29] = "#,##0.00";
        $f[33] = "#,##0.00";
        $writer->updateFormat($sheet, $f);

        $s = array_fill(0, 39, array('font-size' => 8, 'border' => 'top,bottom', 'border-style' => 'thin', 'valign' => 'top'));
        //$s['height'] = 14;
        $s[0]['border']    = 'right';
        $s[1]['border']    = 'left,top,bottom';
        $s[1]['halign']    = 'center';
        $s[3]['border']    = 'left,top,bottom';
        $s[7]['border']    = 'left,top,bottom';
        $s[7]['wrap_text'] = true;
        $s[24]['border']   = 'left,top,bottom';
        $s[27]['border']   = 'left,top,bottom';
        $s[29]['border']   = 'left,top,bottom';
        $s[29]['halign']   = 'right';
        $s[33]['border']   = 'left,top,bottom';
        $s[33]['halign']   = 'right';
        $s[38]['border']   = 'left';

        $i   = 0;
        $sum = 0.00;
        foreach ($order['product'] as $product) {
            $i++;
            $clean_total = (float)str_replace(',', '', $product['total']);
            $sum += $clean_total;

            $r           = array_fill(0, 39, "");
            $r[1]        = $i;
            $r[3]        = $product['model'];
            $pname       = html_entity_decode($product['name']);
            $s['height'] = 14 + 6 * intval(strlen($pname) / 55);
            foreach ($product['option'] as $option)
                $pname .= ' ' . $option['value'];
            $r[7]  = $pname;
            $r[24] = $product['quantity'];
            $r[27] = "шт";
            $product['price'] = str_replace(",", "", $product['price']);
            $r[29] = $product['price'];
            $r[33] = $clean_total;

            $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 1, $end_row = 21 + $i, $end_col = 2);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 3, $end_row = 21 + $i, $end_col = 6);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 7, $end_row = 21 + $i, $end_col = 23);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 24, $end_row = 21 + $i, $end_col = 26);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 27, $end_row = 21 + $i, $end_col = 28);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 29, $end_row = 21 + $i, $end_col = 32);
            $writer->markMergedCell($sheet, $start_row = 21 + $i, $start_col = 33, $end_row = 21 + $i, $end_col = 37);
        }
        $table_end = 21 + count($order['product']);

        $writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height' => 8));

        $f[29] = "string";
        $writer->updateFormat($sheet, $f);

        $r     = array_fill(0, 39, "");
        $r[29] = "Итого:";
        $r[33] = $sum;
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        $writer->markMergedCell($sheet, $start_row = $table_end + 2, $start_col = 29, $end_row = $table_end + 2, $end_col = 32);
        $writer->markMergedCell($sheet, $start_row = $table_end + 2, $start_col = 33, $end_row = $table_end + 2, $end_col = 37);

        $r     = array_fill(0, 39, "");
        $r[27] = "Без налога (НДС)";
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        $writer->markMergedCell($sheet, $start_row = $table_end + 3, $start_col = 27, $end_row = $table_end + 3, $end_col = 32);
        $writer->markMergedCell($sheet, $start_row = $table_end + 3, $start_col = 33, $end_row = $table_end + 3, $end_col = 37);

        $r     = array_fill(0, 39, "");
        $r[27] = "Всего к оплате:";
        $r[33] = $sum;
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        $writer->markMergedCell($sheet, $start_row = $table_end + 4, $start_col = 27, $end_row = $table_end + 4, $end_col = 32);
        $writer->markMergedCell($sheet, $start_row = $table_end + 4, $start_col = 33, $end_row = $table_end + 4, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array("","Всего наименований ".count($order['product']).", на сумму ". number_format($order['free_all_sum'], 2, ',', ' ') ." руб."), $row_options = array('height'=>14,'valign'=>'center','font-size'=>10) );
        $writer->markMergedCell($sheet, $start_row=$table_end + 5, $start_col=1, $end_row=$table_end + 5, $end_col=37);

        $writer->writeSheetRow($sheet, $rowdata = array("",$order['total_2_str']), $row_options =  array('height'=>14,'valign'=>'center','font-size'=>10, 'font-style'=>'bold') );
        $writer->markMergedCell($sheet, $start_row=$table_end + 6, $start_col=1, $end_row=$table_end + 6, $end_col=37);

        $writer->writeSheetRow($sheet, $rowdata = array("", ""), $row_options = array('height' => 6));
        $s           = array_fill(0, 39, array('border' => 'top', 'border-style' => 'medium'));
        $s['height'] = 6;
        $s[0]        = array();
        $s[38]       = array();
        $writer->writeSheetRow($sheet, $rowdata = array_fill(0, 39, ""), $row_options = $s);

        $writer->writeSheetRow($sheet, $rowdata = array(), $row_options = array('height' => 15));

        $r     = array_fill(0, 39, "");
        $r[1]  = "Руководитель";
        $r[28] = "Масенко Е. В.";
        $s     = array_fill(0, 39, array('border-style' => 'thin'));
        for ($i = 7; $i <= 15; $i++)
            $s[$i]['border'] = 'bottom';
        for ($i = 17; $i <= 26; $i++)
            $s[$i]['border'] = 'bottom';
        for ($i = 28; $i <= 37; $i++)
            $s[$i]['border'] = 'bottom';
        $s['height'] = 14;
        $s[1]        = array('font-style' => 'bold', 'font-size' => 9);
        $s[28]       = array('font-style' => 'bold', 'font-size' => 10, 'halign' => 'center');
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 10, $start_col = 28, $end_row = $table_end + 10, $end_col = 37);
        $writer->markMergedCell($sheet, $start_row = $table_end + 10, $start_col = 7, $end_row = $table_end + 10, $end_col = 15);
        $writer->markMergedCell($sheet, $start_row = $table_end + 10, $start_col = 1, $end_row = $table_end + 10, $end_col = 5);

        $r           = array_fill(0, 39, "");
        $r[7]        = "должность";
        $r[17]       = "подпись";
        $r[28]       = "расшифровка подписи";
        $s           = array_fill(0, 39, array('border-style' => 'thin'));
        $s['height'] = 14;
        $s[7]        = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');

        $s[17] = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');
        $s[28] = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');

        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 11, $start_col = 7, $end_row = $table_end + 11, $end_col = 15);
        $writer->markMergedCell($sheet, $start_row = $table_end + 11, $start_col = 17, $end_row = $table_end + 11, $end_col = 26);
        $writer->markMergedCell($sheet, $start_row = $table_end + 11, $start_col = 28, $end_row = $table_end + 11, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(), $row_options = array('height' => 14));

        $r           = array_fill(0, 39, "");
        $r[1]        = "Главный (старший) бухгалтер";
        $r[28]       = "Масенко Е. В.";
        $s           = array_fill(0, 39, array('border-style' => 'thin'));
        $s['height'] = 14;
        for ($i = 17; $i <= 26; $i++)
            $s[$i]['border'] = 'bottom';
        for ($i = 28; $i <= 37; $i++)
            $s[$i]['border'] = 'bottom';
        $s[1]  = array('font-style' => 'bold', 'font-size' => 9);
        $s[28] = array('font-style' => 'bold', 'font-size' => 10, 'halign' => 'center');
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 13, $start_col = 1, $end_row = $table_end + 13, $end_col = 10);
        $writer->markMergedCell($sheet, $start_row = $table_end + 13, $start_col = 28, $end_row = $table_end + 13, $end_col = 37);

        $r           = array_fill(0, 39, "");
        $r[17]       = "подпись";
        $r[28]       = "расшифровка подписи";
        $s           = array_fill(0, 39, array());
        $s['height'] = 14;
        $s[17]       = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');
        $s[28]       = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 14, $start_col = 17, $end_row = $table_end + 14, $end_col = 26);
        $writer->markMergedCell($sheet, $start_row = $table_end + 14, $start_col = 28, $end_row = $table_end + 14, $end_col = 37);

        $writer->writeSheetRow($sheet, $rowdata = array(), $row_options = array('height' => 14));

        $r           = array_fill(0, 39, "");
        $r[1]        = "Ответственный";
        $r[28]       = "Масенко Е. В.";
        $s           = array_fill(0, 39, array());
        $s['height'] = 14;
        for ($i = 17; $i <= 26; $i++)
            $s[$i]['border'] = 'bottom';
        for ($i = 28; $i <= 37; $i++)
            $s[$i]['border'] = 'bottom';
        $s[1]  = array('font-style' => 'bold', 'font-size' => 9);
        $s[28] = array('font-style' => 'bold', 'font-size' => 10, 'halign' => 'center');
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 16, $start_col = 1, $end_row = $table_end + 16, $end_col = 5);
        $writer->markMergedCell($sheet, $start_row = $table_end + 16, $start_col = 28, $end_row = $table_end + 16, $end_col = 37);

        $r           = array_fill(0, 39, "");
        $r[17]       = "подпись";
        $r[28]       = "расшифровка подписи";
        $s           = array_fill(0, 39, array());
        $s['height'] = 14;
        $s[17]       = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');
        $s[28]       = array('border' => 'top', 'border-style' => 'thin', 'font-size' => 8, 'halign' => 'center', 'valign' => 'bottom');
        $writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s);
        $writer->markMergedCell($sheet, $start_row = $table_end + 17, $start_col = 17, $end_row = $table_end + 17, $end_col = 26);
        $writer->markMergedCell($sheet, $start_row = $table_end + 17, $start_col = 28, $end_row = $table_end + 17, $end_col = 37);
        // done

        $writer->markMergedCell($sheet, $start_row = 0, $start_col = 0, $end_row = 0, $end_col = 38);
        $writer->markMergedCell($sheet, $start_row = 1, $start_col = 1, $end_row = 1, $end_col = 37);

        return $writer->writeToString();
    }

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     */
    public function num2str($num) {
        $nul     = 'ноль';
        $ten     = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20     = array(
            'десять', 'одиннадцать', 'двенадцать', 'тринадцать',
            'четырнадцать', 'пятнадцать', 'шестнадцать',
            'семнадцать', 'восемнадцать', 'девятнадцать'
        );
        $tens    = array(
            2 => 'двадцать', 'тридцать', 'сорок',
            'пятьдесят', 'шестьдесят', 'семьдесят',
            'восемьдесят', 'девяносто'
        );
        $hundred = array(
            '', 'сто', 'двести',
            'триста', 'четыреста', 'пятьсот',
            'шестьсот', 'семьсот', 'восемьсот',
            'девятьсот'
        );
        $unit    = array( // Units
                          array('копейка', 'копейки', 'копеек', 1),
                          array('рубль', 'рубля', 'рублей', 0),
                          array('тысяча', 'тысячи', 'тысяч', 1),
                          array('миллион', 'миллиона', 'миллионов', 0),
                          array('миллиард', 'миллиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode(',', str_replace('.', ',', sprintf("%015.2f", $num)));
        $out = array();
        if ((int)$rub > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!(int)$v) {
                    continue;
                }
                $uk     = count($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                } # 20-99
                else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                } # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            } //foreach
        } else {
            $out[] = $nul;
        }
        $out[] = $this->morph((int)$rub, $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . $this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop

        return trim(preg_replace('/ {2,}/', ' ', implode(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    public function morph($n, $f1, $f2, $f5) {
        $n = abs((int)$n) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }
        $n %= 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }
        if ($n === 1) {
            return $f1;
        }

        return $f5;
    }
}

?>
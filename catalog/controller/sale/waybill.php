<?php

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline) {
    global $config;
    global $log;

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $errors = "Notice";
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $errors = "Warning";
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $errors = "Fatal Error";
            break;
        default:
            $errors = "Unknown";
            break;
    }

    if (($errors == 'Warning') || ($errors == 'Unknown')) {
        return true;
    }

    if ($config->get('config_error_display')) {
        echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
    }

    if ($config->get('config_error_log')) {
        $log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }

    return true;
}

class ControllerSaleWaybill extends Controller
{
    public function index() {
        if ($this->validate()) {
            $this->load->model('sale/wborder');
            ini_set("memory_limit", "128M");
            set_time_limit(1800);

            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            }

            if (isset($order_id)) {
                $this->download($order_id);
            }

        } else {
            return $this->forward('error/permission');
        }
    }


    private function download($order_id) {
        set_error_handler('error_handler_for_export', E_ALL);
        register_shutdown_function('fatal_error_shutdown_handler_for_export');
        set_time_limit(0);
        ini_set("memory_limit", "64M");

        chdir('system/PHPExcel');
        set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
        include 'PHPExcel/IOFactory.php';
        chdir('../../docs');

        $fileType = 'Excel5';
        $fileName = 'torg12.xls';

        $this->load->helper('spreadsheet');

        $order_info = $this->model_sale_wborder->getOrder($order_id);

        if ($order_info) {

            if ($order_info['invoice_no']) {
                $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $invoice_no = '';
            }

            if ($order_info['shipping_address_format']) {
                $format = $order_info['shipping_address_format'];
            } else {
                $format = '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n"
                    . '{address_2}';
            }

            $find = [
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}',
            ];

            $replace = [
                'firstname' => $order_info['shipping_firstname'],
                'lastname'  => $order_info['shipping_lastname'],
                'company'   => $order_info['shipping_company'],
                'address_1' => $order_info['shipping_address_1'],
                'address_2' => $order_info['shipping_address_2'],
                'city'      => $order_info['shipping_city'],
                'postcode'  => $order_info['shipping_postcode'],
                'zone'      => $order_info['shipping_zone'],
                'zone_code' => $order_info['shipping_zone_code'],
                'country'   => $order_info['shipping_country'],
            ];

            $shipping_address = str_replace(["\r\n", "\r", "\n"],
                ', ',
                preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], ' ,', trim(str_replace($find, $replace, $format))));

            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                $format = '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n"
                    . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}'
                    . "\n" . '{address_2}' . "\n" . '{bic}' . "\n" . '{checking}' . "\n" . '{bank_name}' . "\n"
                    . '{cor_account}';
            }

            if (!$order_info['customer_id']) {
                $customer_custom = $this->db->query(
                    "SELECT `data` FROM `simple_custom_data` WHERE customer_id = '0' AND object_type = '1' AND object_id = '{$order_info['order_id']}'"
                )->row;
            } else {
                $customer_custom = $this->db->query(
                    "SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '1' AND object_id = '{$order_info['order_id']}'"
                )->row;
            }

            if (isset($customer_custom['data'])) {
                $customer_custom = unserialize($customer_custom['data']);
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
                '{country}',
                // added
                '{bic}',
                '{checking}',
                '{bank_name}',
                '{cor_account}',
                //

            ];

            $customer_type = isset($customer_custom['custom_customer_type'])
                ? "{$customer_custom['custom_customer_type']['value']}" : '';
            // added
            $bic = !empty($customer_custom['custom_bank_bic']) ? "БИК {$customer_custom['custom_bank_bic']['value']}"
                : '';
            $checking = !empty($customer_custom['custom_checking_account'])
                ? "Расчетный счет {$customer_custom['custom_checking_account']['value']}" : '';
            $bank_name = !empty($customer_custom['custom_bank_name'])
                ? "Наименование банка {$customer_custom['custom_bank_name']['value']}" : '';
            $cor_account = !empty($customer_custom['custom_cor_account'])
                ? "Кор. счет {$customer_custom['custom_cor_account']['value']}" : '';
            //
            if ($customer_type == 'ip') {
                $inn = !empty($customer_custom['custom_inn']) ? "ИНН {$customer_custom['custom_inn']['value']}" : '';
                $kpp = !empty($customer_custom['custom_kpp']) ? "КПП {$customer_custom['custom_kpp']['value']}" : '';
                $custom_company = !empty($customer_custom['custom_company'])
                    ? "{$customer_custom['custom_company']['value']}" : '';
            } elseif ($customer_type == 'legal') {
                $inn = !empty($customer_custom['custom_legal_inn'])
                    ? "ИНН {$customer_custom['custom_legal_inn']['value']}" : '';
                $kpp = !empty($customer_custom['custom_legal_kpp'])
                    ? "КПП {$customer_custom['custom_legal_kpp']['value']}" : '';
                $custom_company = !empty($customer_custom['custom_legal_company'])
                    ? "{$customer_custom['custom_legal_company']['value']}" : '';
            } else {
                $inn = '';
                $kpp = '';
                $custom_company = '';
            }

            $replace = [
                'customer_type'  => isset($customer_custom['custom_customer_type'])
                    ? "{$customer_custom['custom_customer_type']['text']}" : '',
                'patronymic'     => isset($customer_custom['custom_middlename']['value'])
                    ? "{$customer_custom['custom_middlename']['value']}" : '',
                'inn'            => $inn,
                'kpp'            => $kpp,
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
                'country'        => $order_info['payment_country'],
                // added
                'bic'            => $bic,
                'checking'       => $checking,
                'bank_name'      => $bank_name,
                'cor_account'    => $cor_account,
                //
            ];

            if (strlen($replace['custom_company'])) {
                if ($format == '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}'
                    . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n"
                    . '{address_1}' . "\n" . '{address_2}' . "\n" . '{bic}' . "\n" . '{checking}' . "\n" . '{bank_name}'
                    . "\n" . '{cor_account}'
                ) {
                    $format = '{custom_company}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{postcode}' . "\n"
                        . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{bic}'
                        . "\n" . '{checking}' . "\n" . '{bank_name}' . "\n" . '{cor_account}';
                }
            }

            $payment_address = str_replace(["\r\n", "\r", "\n"],
                ', ',
                preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], ', ', trim(str_replace($find, $replace, $format))));
            $product_data = [];

            $products = $this->model_sale_wborder->getOrderProducts($order_id);

            $products_total = 0;

            foreach ($products as $product) {
                $products_total++;
                $report_name = $this->model_sale_wborder->getReportName($product['product_id']);

                $kod = '';
                $sku = $this->model_sale_wborder->getProductSKU($product['product_id']);
                if (!empty($sku[0]['sku'])) {
                    $kod = $sku[0]['sku'];
                }

                $color = '';
                $attributes = $this->model_sale_wborder->getProductAttributes($product['product_id']);
                if (!empty($attributes)) {
                    foreach ($attributes as $attribute) {
                        if ($attribute['name'] == 'Цвет') {
                            $color = $attribute['attribute'][0]['text'];
                        }
                    }
                }

                $option_data = [];

                $options = $this->model_sale_wborder->getOrderOptions($order_id, $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                    }

                    $option_data[] = [
                        'name'  => $option['name'],
                        'value' => $value,
                    ];

                    $kod = $this->model_sale_wborder->getOrderOptionKod($order_id, $option['order_option_id']);
                    $color = $this->model_sale_wborder->getOrderOptionColor($order_id, $option['order_option_id']);
                }

                $weight = $this->model_sale_wborder->getProductWeight($product['product_id']);

                $product_data[] = [
                    'name'        => $product['name'],
                    'model'       => $product['model'],
                    'kod'         => $kod,
                    'color'       => $color,
                    'quantity'    => $product['quantity'],
                    'report_name' => $report_name,
                    'price'       => $this->currency->format(
                        $product['price'],
                        $order_info['currency_code'],
                        $order_info['currency_value']
                    ),
                    'price_value' => $product['price'],
                    'total'       => $this->currency->format(
                        $product['total'],
                        $order_info['currency_code'],
                        $order_info['currency_value']
                    ),
                ];
            }

            $total_data = $this->model_sale_wborder->getOrderTotals($order_id);

            $order = [
                'order_id'         => $order_id,
                'invoice_no'       => $invoice_no,
                'invoice_date'     => date($this->language->get('date_format_short'), strtotime('now')),
                'date_added'       => date(
                    $this->language->get('date_format_short'),
                    strtotime($order_info['date_added'])
                ),
                'date_added_rus'   => html_entity_decode(
                    russian_date(
                        date($this->language->get('date_format_short'), strtotime($order_info['date_added']))
                    )
                ),
                'email'            => $order_info['email'],
                'telephone'        => $order_info['telephone'],
                'payment_address'  => html_entity_decode($payment_address),
                'shipping_address' => html_entity_decode($shipping_address),
                'product'          => $product_data,
                'product_total'    => mb_ucfirst(prop(isset($products_total) ? $products_total : 0)),
                'total'            => $total_data,
                'total_rus'        => mb_ucfirst(num2str($total_data)),
            ];
        }

        $objReader = PHPExcel_IOFactory::createReader($fileType);

        $objPHPExcel = $objReader->load($fileName);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('AL29', $order['order_id']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AP29', $order['date_added']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I57', $order['date_added_rus']);

        $objPHPExcel->getActiveSheet()->SetCellValue(
            'I13',
            $order['payment_address'] . ', тел.: ' . $order['telephone']
        );

        $objPHPExcel->getActiveSheet()->SetCellValue(
            'I19',
            $order['payment_address'] . ', тел.: ' . $order['telephone']
        );

        $objPHPExcel->getActiveSheet()->SetCellValue('G38', $order['product_total']);

        foreach ($order['total'] as $total) {
            if ($total['code'] == 'total') {
                $objPHPExcel->getActiveSheet()->SetCellValue('AW35', $total['value']);
                $objPHPExcel->getActiveSheet()->SetCellValue('BG35', $total['value']);
                $objPHPExcel->getActiveSheet()->SetCellValue('AW36', $total['value']);
                $objPHPExcel->getActiveSheet()->SetCellValue('BG36', $total['value']);

                $objPHPExcel->getActiveSheet()->SetCellValue(
                    'K47',
                    mb_ucfirst(num2str($total['value']))
                );

                $objPHPExcel->getActiveSheet()->getStyle('AW35')->getNumberFormat()->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                );
                $objPHPExcel->getActiveSheet()->getStyle('BG35')->getNumberFormat()->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                );
                $objPHPExcel->getActiveSheet()->getStyle('AW36')->getNumberFormat()->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                );
                $objPHPExcel->getActiveSheet()->getStyle('BG36')->getNumberFormat()->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                );
            }
        }

        $numcell = 34;
        $i = 1;
        $quality = 0;
        $cell = [];

        foreach ($order['product'] as $product) {
            $numcell++;

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($numcell, 1);

            $cell[] = 'B' . $numcell . ':D' . $numcell;
            $cell[] = 'E' . $numcell . ':R' . $numcell;
            $cell[] = 'S' . $numcell . ':U' . $numcell;
            $cell[] = 'V' . $numcell . ':X' . $numcell;
            $cell[] = 'Y' . $numcell . ':AA' . $numcell;
            $cell[] = 'AB' . $numcell . ':AD' . $numcell;
            $cell[] = 'AE' . $numcell . ':AG' . $numcell;
            $cell[] = 'AH' . $numcell . ':AI' . $numcell;
            $cell[] = 'AJ' . $numcell . ':AK' . $numcell;
            $cell[] = 'AL' . $numcell . ':AM' . $numcell;
            $cell[] = 'AN' . $numcell . ':AP' . $numcell;
            $cell[] = 'AQ' . $numcell . ':AS' . $numcell;
            $cell[] = 'AT' . $numcell . ':AV' . $numcell;
            $cell[] = 'AW' . $numcell . ':AY' . $numcell;
            $cell[] = 'AZ' . $numcell . ':BB' . $numcell;
            $cell[] = 'BC' . $numcell . ':BF' . $numcell;
            $cell[] = 'BG' . $numcell . ':BJ' . $numcell;

            foreach ($cell as $cel) {
                $objPHPExcel->getActiveSheet()->mergeCells($cel);
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $numcell, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue(
                'E' . $numcell,
                htmlspecialchars_decode($product['report_name'])
            );

            $objPHPExcel->getActiveSheet()->setCellValueExplicit(
                'S' . $numcell,
                $product['kod'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $numcell, $product['model']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $numcell, $product['color']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $numcell, 'шт.');
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $numcell, '796');
            //$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$numcell, 'шт.');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $numcell, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $numcell, $product['quantity']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $numcell, $product['price']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AW' . $numcell, $product['total']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AZ' . $numcell, 'Без НДС');
            $objPHPExcel->getActiveSheet()->SetCellValue('BG' . $numcell, $product['total']);

            $quality += $product['quantity'];
            $i++;
        }

        $finish = 35 + count($order['product']);

        $objPHPExcel->getActiveSheet()->getStyle('AT35:AT' . $finish)->getNumberFormat()->setFormatCode(
            PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
        );
        $objPHPExcel->getActiveSheet()->getStyle('AW35:AW' . $finish)->getNumberFormat()->setFormatCode(
            PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
        );
        $objPHPExcel->getActiveSheet()->getStyle('BG35:BG' . $finish)->getNumberFormat()->setFormatCode(
            PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
        );

        $numcell++;
        $cell = 'AQ' . $numcell;
        $objPHPExcel->getActiveSheet()->SetCellValue($cell, $quality);

        $cell = 'AQ' . ($numcell + 1);
        $objPHPExcel->getActiveSheet()->SetCellValue($cell, $quality);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ТОРГ12_' . $order['order_id'] . '.xls"');
        $objWriter->save('php://output');
        exit;
    }

    private function validate() {
        //if (!$this->user->hasPermission('modify', 'sale/waybill')) {
        //$this->error['warning'] = $this->language->get('error_permission');
        //}

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

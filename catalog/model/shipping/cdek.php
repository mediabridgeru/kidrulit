<?php /* 05.12.18 убрал лишние переводы строки */
require_once('response_parser.php');

class ModelShippingCdek extends Model
{
    private $length_class_id = 1; // cm
    private $weight_class_id = 1; // kg
    private $text_tariff_empty = '<b>(Стоимость уточнит оператор)</b>';

    function __construct($registry)
    {
        parent::__construct($registry);

        $this->length_class_id = $this->config->get('cdek_length_class_id');
        $this->weight_class_id = $this->config->get('cdek_weight_class_id');
    }

    public function getQuote($address)
    {
        if (!file_exists(DIR_APPLICATION . 'model' . DIRECTORY_SEPARATOR . 'shipping' . DIRECTORY_SEPARATOR . 'CalculatePriceDeliveryCdek.php')) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: file CalculatePriceDeliveryCdek.php not found!');
            }

            return false;
        }

        require_once DIR_APPLICATION . 'model' . DIRECTORY_SEPARATOR . 'shipping' . DIRECTORY_SEPARATOR . 'CalculatePriceDeliveryCdek.php';

        if (!class_exists('CalculatePriceDeliveryCdek')) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: class CalculatePriceDeliveryCdek not found!');
            }

            return false;
        }

        $address = $this->initAddress($address);
        if ($this->isAdmin()) {

            $this->config->set('cdek_view_type', 'old');
            $this->config->set('cdek_period', '0');
            $this->config->set('cdek_delivery_data', '0');
            $this->config->set('cdek_pvz_more_one', 'split');

        }

        if (in_array($this->config->get('cdek_view_type'), array('group', 'map'))) {
            $this->config->set('cdek_pvz_more_one', 'split');
        }

        $this->load->language('shipping/cdek');

        $quote_data = [];

        $status = TRUE;

        if (!is_array($this->config->get('cdek_store')) || !in_array($this->config->get('config_store_id'), $this->config->get('cdek_store'))) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: не выбран магазин!');
            }

            $status = false;
        }

        /*if (!$this->currency->getId('RUB')) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: в системе не найдена валюта "RUB"!');
            }

            $status = false;
        }*/

        if (!$city_from = $this->config->get('cdek_city_from_id')) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: не выбран город отправки!');
            }

            $status = false;
        }

        $cart_init = 0; // корзина открыта в первый раз?

        if (isset($this->session->data['cart_init'])) {
            $cart_init = (int)$this->session->data['cart_init'];
        }

        $products = $this->cart->getProducts();

        $cdek_default_weight = $this->config->get('cdek_default_weight');

        $weight = 0;

        if ($cdek_default_weight['use']) {

            $default_weight = (float)$this->weight->convert($cdek_default_weight['value'], $this->weight_class_id, $this->config->get('config_weight_class_id'));

            switch ($cdek_default_weight['work_mode']) {
                case 'order':
                    $weight = $default_weight;
                    break;
                case 'all':
                case 'optional':

                    foreach ($products as $product) {

                        if ($cdek_default_weight['work_mode'] == 'all') {
                            $weight += $default_weight;
                        } else {

                            if ((float)$product['weight'] > 0) {
                                $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
                            } else {
                                $weight += $default_weight;
                            }

                        }

                    }

                    break;
            }

        } else {
            $weight = $this->cart->getWeight();
        }

        if ($this->config->get('config_weight_class_id') != $this->weight_class_id) {
            $weight = $this->weight->convert($weight, $this->config->get('config_weight_class_id'), $this->weight_class_id);
        }

        $packing_min_weight = $this->weight->convert((float)$this->config->get('cdek_packing_min_weight'), $this->config->get('cdek_packing_weight_class_id'), $this->weight_class_id);
        $packing_value = $this->weight->convert((float)$this->config->get('cdek_packing_value'), $this->config->get('cdek_packing_weight_class_id'), $this->weight_class_id);

        if ($packing_value) {

            $packing_weight = 0;

            switch ($this->config->get('cdek_packing_mode')) {
                case 'fixed':
                    $packing_weight = $packing_value;
                    break;
                case 'all_percent':
                    $packing_weight = ($weight / 100) * $packing_value;
                    break;
            }

            if ($packing_min_weight && $packing_min_weight > $packing_weight) {
                $packing_weight = $packing_min_weight;
            }

            if ($this->config->get('cdek_packing_prefix') == '+') {
                $weight += $packing_weight;
            } else {
                $weight -= (float)min($packing_weight, $weight);
            }

        } elseif ($packing_min_weight) {
            $weight += $packing_min_weight;
        }

        $min_weight = (float)$this->config->get('cdek_min_weight');
        $max_weight = (float)$this->config->get('cdek_max_weight');

        if ($status && (($min_weight > 0 && $weight < $min_weight) || ($max_weight > 0 && $weight > $max_weight))) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: превышены ограничения по весу!');
            }

            $status = false;
        }

        if ((float)$this->config->get('cdek_additional_weight')) {
            $weight += (float)$this->config->get('cdek_additional_weight');
        }

        if ($this->config->get('cdek_log')) {
            $this->log->write('СДЭК: вес заказа ' . $weight);
        }

        $total = $this->cart->getTotal();

        $min_total = (float)$this->config->get('cdek_min_total');
        $max_total = (float)$this->config->get('cdek_max_total');

        if ($status && (($min_total > 0 && $total < $min_total) || ($max_total > 0 && $total > $max_total))) {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: превышены ограничения по стоимости!');
            }

            $status = false;
        }

        if ($cart_init) {
            $params = [];

            $params['total'] = $total;
            $params['products'] = $products;
            $params['address'] = $address;
            $params['city_from'] = $city_from;
            $params['weight'] = $weight;

            $load_url = 'index.php?route=shipping/cdek/getCdek';
            $title = '<script>
                            $.ajax({
                              type: "POST",
                              url: "'.$load_url.'",
                              dataType: "json",
                              data: '.json_encode($params).'
                            }).done(function( quotes ) {
                                if (quotes) {
                                    let $cdek = $("body").find(".load_cdek");
                                    let cdek_html = getCdekHtml(quotes);
                                    $cdek.replaceWith(cdek_html);
                                }
                            });
                            </script>';

            $title .= '<div class="cdek-info">Получаем данные от СДЭК</div>';

            $quote_data['empty'] = array(
                'code'         => 'cdek.load',
                'load'         => 1,
                'title'        => $title,
                'cost'         => 0,
                'tax_class_id' => $this->config->get('cdek_tax_class_id'),
                'text'         => ''
            );
        } else {
            $countries = [];
            $empty_country = false;

            if (empty($address['country_id'])) {
                $address['country_id'] = $this->config->get('config_country_id');
            }

            $to_data = $this->db->query("SELECT name FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$address['country_id'] . "' LIMIT 1")->row;

            if ($to_data) {
                $countries = $this->prepareCountry($to_data['name']);
            } else {
                $empty_country = TRUE;
            }

            $regions = [];
            $empty_zone = false;

            if (empty($address['zone_id'])) {
                $empty_zone = TRUE;
            } elseif (is_array($this->config->get('cdek_use_region')) && in_array($address['country_id'], $this->config->get('cdek_use_region'))) {
                $empty_zone = TRUE;
            }

            if (!$empty_zone) {

                $to_data = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$address['zone_id'] . "' LIMIT 1")->row;

                if ($to_data) {
                    $regions = $this->prepareRegion($to_data['name']);
                } else {
                    $empty_zone = TRUE;
                }

            }

            $address['city'] = $this->clearText($address['city']);

            if ('' != $address['city']) {

                $cities = array($address['city']);
                $cities[] = preg_replace('|[^a-zа-яё]|isu', ' ', $address['city']);
                $cities[] = preg_replace('|[^a-zа-яё]|isu', '-', $address['city']);

                $cities = array_map('trim', $cities);
                $cities = array_filter($cities);

                foreach ($cities as $city) {

                    $cdek_cities = $this->getCity($city);

                    if (is_array($cdek_cities) && isset($cdek_cities['geonames']) && count($cdek_cities['geonames'])) {

                        $address['city'] = $city;

                        break;
                    }
                }
            }

            $city_ignore = [];

            if ($this->config->get('cdek_city_ignore')) {

                $city_ignore = explode(', ', $this->config->get('cdek_city_ignore'));
                $city_ignore = array_map('trim', $city_ignore);
                $city_ignore = array_filter($city_ignore);
                $city_ignore = array_map(array($this, 'clearText'), $city_ignore);

            }

            if (empty($cdek_cities['geonames']) && !empty($address['postcode'])) {

                $address_list = $this->getAddressByPostcode($address['postcode']);

                if ($address_list) {

                    foreach ($address_list as $address_item) {

                        $cdek_cities = $this->getCity($address_item['city']);

                        if (is_array($cdek_cities) && isset($cdek_cities['geonames']) && count($cdek_cities['geonames'])) {

                            $address['city'] = $this->clearText($address_item['city']);

                            if (!empty($address_item['zone'])) {
                                $regions = $this->prepareRegion($address_item['zone']);
                            }

                            $empty_country = true;
                            break;
                        }
                    }
                }
            }

            if (empty($cdek_cities['geonames']) && $this->config->get('cdek_check_ip')) {

                $id_address = $this->getAddressByIP();

                if ($id_address) {

                    $cdek_cities = $this->getCity($id_address['city']);

                    if (is_array($cdek_cities) && isset($cdek_cities['geonames']) && count($cdek_cities['geonames'])) {

                        $address['city'] = $this->clearText($id_address['city']);
                        $regions = $this->prepareRegion($id_address['zone']);

                        $empty_country = true;
                    }
                }
            }

            if (in_array($this->clearText($address['city']), $city_ignore)) {

                if ($this->config->get('cdek_log')) {
                    $this->log->write('СДЭК: город «' . $address['city'] . '» доставка запрещена!');
                }

                return false;
            }

            $empty_info = $this->config->get('cdek_empty');

            if (!empty($cdek_cities['geonames'])) {

                $available = [];

                if ($status) {

                    foreach ($cdek_cities['geonames'] as $city_info) {

                        if (!empty($address['postcode']) && !empty($city_info['postCodeArray']) && in_array($address['postcode'], $city_info['postCodeArray'])) {

                            $city_info['relevance'] = 1;

                            $available[] = $city_info;

                            break;

                        }

                        if (!$empty_country && !in_array($this->clearText($city_info['countryName']), $countries)) {
                            continue;
                        }

                        if (!$empty_zone && !empty($city_info['regionName'])) {

                            list($region) = explode(' ', str_replace('обл.', '', trim($city_info['regionName'])));

                            if (!in_array($this->clearText($region), $regions)) {
                                continue;
                            }
                        }

                        list($city)= explode(',', $city_info['name']);

                        $relevance = 0;

                        if ($this->clearText($city) == $this->clearText($address['city'])) {
                            $relevance = 1;
                        } elseif (mb_strpos($this->clearText($city), $this->clearText($address['city'])) === 0) {
                            $relevance = 0.5;
                        }

                        if (0 < $relevance) {

                            $city_info['relevance'] = $relevance;

                            $available[] = $city_info;
                        }
                    }
                }

                if ($count = count($available)) {

                    if ($count > 1) {

                        $sort_order = [];

                        foreach ($available as $key => $value) {
                            $sort_order[$key] = $value['relevance'] + (int)($this->clearText($address['city']) == $this->clearText($value['cityName']));
                        }

                        array_multisort($sort_order, SORT_DESC, $available);

                        $available = array($available[0]);
                    }

                    $available_city = reset($available);

                    $city_to = $available_city['id'];

                    if ($this->config->get('cdek_log')) {
                        $this->log->write('СДЭК: Город получателя «' . $available_city['name'] . '» (' . $city_to . ')');
                    }

                    $calc = new CalculatePriceDeliveryCdek();

                    $calc->setSenderCityId($city_from);
                    $calc->setReceiverCityId($city_to);

                    $day = (is_numeric($this->config->get('cdek_append_day'))) ? trim($this->config->get('cdek_append_day')) : 0;
                    $date = date('Y-m-d', strtotime('+' . (float)$day . ' day'));
                    $calc->setDateExecute($date);

                    if ($this->config->get('cdek_login') != '' && $this->config->get('cdek_password') != '') {
                        $calc->setAuth($this->config->get('cdek_login'), $this->config->get('cdek_password'));
                    }

                    $cdek_default_size = $this->config->get('cdek_default_size');

                    $volume = 0;

                    if ($cdek_default_size['use']) {

                        $default_volume = 0;

                        switch ($cdek_default_size['type']) {
                            case 'volume':
                                $default_volume = (float)$cdek_default_size['volume'];
                                break;
                            case 'size':
                                $default_volume = $this->getVolume(array($cdek_default_size['size_a'], $cdek_default_size['size_b'], $cdek_default_size['size_c']), $this->length_class_id);
                                break;
                        }

                        switch ($cdek_default_size['work_mode']) {
                            case 'order':
                                $volume = $default_volume;
                                break;
                            case 'all':
                            case 'optional':

                                foreach ($products as $product) {

                                    if ($cdek_default_size['work_mode'] == 'all') {
                                        $product_volume = $default_volume;
                                    } else {

                                        $product_volume = $this->getVolume(array($product['length'], $product['width'], $product['height']), $product['length_class_id']);

                                        if (!$product_volume) {
                                            $product_volume = $default_volume;
                                        }

                                    }

                                    $volume += $product['quantity'] * (float)$product_volume;

                                }

                                break;
                        }

                    } else {

                        foreach ($products as $product) {

                            $product_volume = $this->getVolume(array($product['length'], $product['width'], $product['height']), $product['length_class_id']);

                            if (!$product_volume) {
                                $product_volume = 0;
                            }

                            $volume += $product['quantity'] * $product_volume;
                        }

                    }

                    if ($this->config->get('cdek_log')) {
                        $this->log->write('СДЭК: объем ' . $volume);
                    }

                    if (!$volume) {

                        if ($this->config->get('cdek_log')) {
                            $this->log->write('СДЭК: не удалось рассчитать объем, возможно не заданы размеры товара или не установлено значение по умолчанию в настройках модуля!');
                        }

                        /*$status = false;*/
                    }

                    if (!$weight) {

                        if ($this->config->get('cdek_log')) {
                            $this->log->write('СДЭК: не заполнен вес у товара!');
                        }

                        /*$status = false;*/
                    }

                    if ($status) {

                        $calc->addGoodsItemByVolume($weight, $volume);

                        if (!$this->config->get('cdek_custmer_tariff_list')) {

                            if ($this->config->get('cdek_log')) {
                                $this->log->write('СДЭК: список тарифов пуст!');
                            }

                            $status = false;
                        }

                        if ($status) {

                            $geo_zones = [];

                            $query = $this->db->query("SELECT DISTINCT geo_zone_id FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

                            if ($query->num_rows) {
                                foreach ($query->rows as $row) {
                                    $geo_zones[$row['geo_zone_id']] = $row['geo_zone_id'];
                                }

                            }

                            if ($this->customer->isLogged()) {
                                $customer_group_id = $this->customer->getCustomerGroupId();
                            } else {
                                $customer_group_id = $this->config->get('config_customer_group_id');
                            }

                            $cdek_tariff_list = $this->config->get('cdek_tariff_list');

                            $results = $tariff_list = [];

                            foreach ($this->config->get('cdek_custmer_tariff_list') as $key => $tariff_info) {

                                if (empty($cdek_tariff_list[$tariff_info['tariff_id']])) continue;

                                $tariff_title = !empty($tariff_info['title'][$this->config->get('config_language_id')]) ? $tariff_info['title'][$this->config->get('config_language_id')] : $cdek_tariff_list[$tariff_info['tariff_id']]['title'];

                                if (!empty($tariff_info['customer_group_id']) && !in_array($customer_group_id, $tariff_info['customer_group_id'])) continue;

                                $min_weight = (float)$tariff_info['min_weight'];
                                $max_weight = (float)$tariff_info['max_weight'];

                                if (($min_weight > 0 && $weight < $min_weight) || ($max_weight > 0 && $weight > $max_weight)) {

                                    if ($this->config->get('cdek_log')) {
                                        $this->log->write('СДЭК: Тариф «' . $tariff_title . '» превышены ограничения по весу!');
                                    }

                                    continue;
                                }

                                $min_total = (float)$tariff_info['min_total'];
                                $max_total = (float)$tariff_info['max_total'];

                                if (($min_total > 0 && $total < $min_total) || ($max_total > 0 && $total > $max_total)) {

                                    if ($this->config->get('cdek_log')) {
                                        $this->log->write('СДЭК: Тариф «' . $tariff_title . '» превышены ограничения по стоимости!');
                                    }

                                    continue;
                                }

                                if (!empty($tariff_info['geo_zone'])) {

                                    $intersect = array_intersect($tariff_info['geo_zone'], $geo_zones);

                                    if (!$intersect) {
                                        continue;
                                    }

                                } else {
                                    $key = 'all';
                                }

                                $tariff_list[$tariff_info['tariff_id']][$key] = $tariff_info;
                            }

                            if (!$tariff_list) {

                                if ($this->config->get('cdek_log')) {
                                    $this->log->write('СДЭК: Не сформирован список тарифов для текущей географической зоны!');
                                }

                                $status = false;
                            }

                            if ($status) {

                                foreach ($tariff_list as $tariff_id => &$items) {

                                    if (count($items) > 1) {

                                        if (array_key_exists('all', $items)) unset($items['all']);

                                        $sort_order = [];

                                        foreach ($items as $key => $item) {
                                            $sort_order[$key] = $item['sort_order'];
                                        }

                                        array_multisort($sort_order, SORT_ASC, $items);

                                        $items = reset($items);

                                    } elseif (count($items) == 1)  {
                                        $items = reset($items);
                                    } else {
                                        continue;
                                    }

                                    if ($this->config->get('cdek_work_mode') == 'single') {
                                        $calc->addTariffPriority($tariff_id, $items['sort_order']);
                                    }
                                }

                                if ($this->config->get('cdek_work_mode') == 'single') {

                                    if ($result = $this->getResult($calc, $total)) {
                                        $results[] = $result;
                                    }

                                } else {

                                    foreach ($tariff_list as $tariff_info) {

                                        $calc->setTariffId($tariff_info['tariff_id']);

                                        if ($result = $this->getResult($calc, $total)) {
                                            $results[] = $result;
                                        } elseif (!empty($tariff_info['empty'])) {

                                            $results[] = array(
                                                'tariffId' => $tariff_info['tariff_id'],
                                                'currency' => $this->config->get('config_currency'),
                                                'empty' => true,
                                                'priceByCurrency' => 0,
                                                'deliveryPeriodMin' => '',
                                                'deliveryPeriodMax' => '',
                                                'deliveryDateMin' => '',
                                                'deliveryDateMax' => ''
                                            );
                                        }
                                    }
                                }

                                if (!empty($results)) {

                                    $sub_total = $this->cart->getSubTotal();

                                    foreach ($results as $shipping_info) {

                                        if (array_key_exists($shipping_info['tariffId'], $cdek_tariff_list)) {

                                            $tariff_info = $cdek_tariff_list[$shipping_info['tariffId']];

                                            $type = 'PVZ';

                                            if (isset($tariff_info['postomat'])) {
                                                $type = 'POSTOMAT';
                                            }

                                            $usePVZ = in_array($tariff_info['mode_id'], array(2, 4)) && (isset($tariff_info['postomat']) || $this->config->get('cdek_weight_limit') || $this->config->get('cdek_show_pvz'));

                                            if ($usePVZ) {
                                                $pvz_list = $this->getPVZList($type, $city_to, $weight);
                                            } else {
                                                $pvz_list = [];
                                            }

                                            if (!$this->config->get('cdek_empty_address') && trim($address['address_1']) == '' && in_array($tariff_info['mode_id'], array(1, 3))) {

                                                if ($this->config->get('cdek_log')) {
                                                    $this->log->write('СДЭК: пустой адрес доставки для тарифа ' . $shipping_info['tariffId']);
                                                }

                                                continue;
                                            }

                                            if (!$this->currency->getId($shipping_info['currency'])) {

                                                if ($this->config->get('cdek_log')) {
                                                    $this->log->write('СДЭК: не найдена валюта на сайте (' . $shipping_info['currency'] . ')');
                                                }

                                                continue;

                                            }

                                            if ($this->config->get('config_currency') == $shipping_info['currency']) {
                                                $price = $shipping_info['priceByCurrency'];
                                            } else {
                                                $price = $this->currency->convert($shipping_info['priceByCurrency'], $shipping_info['currency'], $this->config->get('config_currency'));
                                            }

                                            if ($this->config->get('cdek_insurance')) {
                                                $price += ($sub_total / 100) * 0.75;
                                            }

                                            $customer_tariff_info = $tariff_list[$shipping_info['tariffId']];

                                            $discounts = $this->getDiscount($sub_total, $shipping_info['tariffId'], $geo_zones);

                                            foreach ($discounts as $discount_info) {

                                                $markup = (float)$discount_info['value'];

                                                switch ($discount_info['mode']) {
                                                    case 'percent':
                                                        $markup = ($sub_total / 100) * $markup;
                                                        break;
                                                    case 'percent_shipping':
                                                        $markup = ($price / 100) * $markup;
                                                        break;
                                                    case 'percent_cod':
                                                        $markup = (($sub_total + $price) / 100) * $markup;
                                                        break;
                                                }

                                                if ($discount_info['prefix'] == '+') {
                                                    $price += (float)$markup;
                                                } else {
                                                    $price -= (float)$markup;
                                                }

                                                if ($price < 0) {
                                                    $price = 0;
                                                }

                                            }

                                            // Округление
                                            if ($this->config->get('cdek_rounding')) {

                                                switch ($this->config->get('cdek_rounding_type')) {
                                                    case 'floor':
                                                        $price = floor($price);
                                                        break;
                                                    case 'ceil':
                                                        $price = ceil($price);
                                                        break;
                                                    default:
                                                        $price = round($price);
                                                }

                                            }

                                            if (!empty($customer_tariff_info['title'][$this->config->get('config_language_id')])) {
                                                $description = $customer_tariff_info['title'][$this->config->get('config_language_id')];
                                            } else {

                                                $description = $tariff_info['title'];

                                                if (in_array($tariff_info['mode_id'], array(2, 4))) {
                                                    $description .= ' (до пункта выдачи)';
                                                } else {
                                                    $description .= ' (курьером до двери)';
                                                }
                                            }

                                            $tariff_title_clear = $tariff_title_short = $description;

                                            if ($this->config->get('cdek_period') || (!empty($pvz_list) && in_array($tariff_info['mode_id'], array(2, 4)))) {
                                                $description .= ':';
                                            }

                                            if ($this->config->get('cdek_period')) {

                                                $period = array_unique(array($shipping_info['deliveryPeriodMin'], $shipping_info['deliveryPeriodMax']));

                                                if (reset($period)) {

                                                    if ((float)$this->config->get('cdek_more_days')) {
                                                        foreach ($period as &$period_item) $period_item += (float)$this->config->get('cdek_more_days');
                                                    }

                                                    $description .= ' Срок доставки ' . implode('–', $period) . ' ' . $this->declination(max($period), array('день', 'дня', 'дней')) . '.';

                                                }

                                            }

                                            if ($this->config->get('cdek_delivery_data')) {

                                                $period = array_unique(array_map(array($this, 'normalizeDate'), array($shipping_info['deliveryDateMin'], $shipping_info['deliveryDateMax'])));

                                                if (reset($period)) {

                                                    if ((float)$this->config->get('cdek_more_days')) {
                                                        foreach ($period as &$delivery_date) $delivery_date = date('Y.m.d', strtotime('+' . (int)$this->config->get('cdek_more_days') . ' day', strtotime(implode('.', array_reverse(explode('.', $delivery_date))))));
                                                    }

                                                    if (count($period) == 1) {
                                                        $description .= ' Планируемая дата доставки ' . $period[0] . '.';
                                                    } else {
                                                        $description .= ' Планируемая дата доставки с ' . $period[0] . ' по ' . $period[1] . '.';
                                                    }

                                                }
                                            }

                                            $names = [];

                                            $quote_description = '';

                                            $empty_description = !empty($shipping_info['empty']) ? $this->text_tariff_empty : '';

                                            if (in_array($tariff_info['mode_id'], array(2, 4))) {

                                                if ($usePVZ && !$pvz_list) {

                                                    if ($this->config->get('cdek_log')) {
                                                        $this->log->write('СДЭК: не удалось получить список ПВЗ для тарифа «' . $tariff_info['title'] . '»');
                                                    }

                                                    continue;
                                                }

                                                if ($this->config->get('cdek_show_pvz')) {

                                                    if (in_array($this->config->get('cdek_view_type'), array('group', 'map'))) {

                                                        $first_pvz = null;

                                                        if (isset($this->session->data['cdek_last_pvz'][$shipping_info['tariffId']])) {

                                                            $active = $this->session->data['cdek_last_pvz'][$shipping_info['tariffId']];

                                                            foreach ($pvz_list as $item) {

                                                                if ($item['code'] == $active) {
                                                                    $first_pvz = $item;

                                                                }

                                                            }

                                                        }

                                                        if (empty($first_pvz)) {
                                                            $first_pvz = reset($pvz_list);
                                                        }

                                                        if ('map' == $this->config->get('cdek_view_type')) {

                                                            $data = array(
                                                                'tariff_id' => $shipping_info['tariffId'],
                                                                'city'		=> $available_city,
                                                                'pvz'		=> $pvz_list,
                                                                'description' => $empty_description
                                                            );

                                                            $quote_description = $this->getMap($data);
                                                        } else {
                                                            $quote_description = $this->getHTML($shipping_info['tariffId'], $pvz_list, $empty_description);
                                                        }

                                                        $names[$first_pvz['code']] = $description;

                                                        $tariff_title_short .= ': ' . $first_pvz['address'];


                                                    } else {

                                                        if ($empty_description) {
                                                            $quote_description = $this->getBlankDescription($empty_description);
                                                        }

                                                        foreach ($pvz_list as $pvz_info) {
                                                            $names[$pvz_info['code']] = $description . ' '/*' Пункт выдачи заказов: '*/ . $pvz_info['address_full'];
                                                        }

                                                    }

                                                } else {

                                                    if ($empty_description) {
                                                        $quote_description = $this->getBlankDescription($empty_description);
                                                    }

                                                    $names[] = $description;
                                                }

                                            } else {

                                                if ($empty_description) {
                                                    $quote_description = $this->getBlankDescription($empty_description);
                                                }

                                                $names[] = $description;
                                            }

                                            $cod = !isset($shipping_info['cashOnDelivery']) || ((float)$shipping_info['cashOnDelivery'] && $total >= (float)$shipping_info['cashOnDelivery']);

                                            foreach ($names as $key => $description) {

                                                if (in_array($tariff_info['mode_id'], array(2, 4))) {
                                                    $code = 'pvz_';
                                                } else {
                                                    $code = 'cur_';
                                                }

                                                $code .= $shipping_info['tariffId'];
                                                $cdek_code = 'cdek.' . $code;

                                                if (!is_numeric($key) && (!$this->config->get('cdek_hide_pvz') || ($this->config->get('cdek_hide_pvz') && !in_array($this->config->get('cdek_view_type'), array('group', 'map'))))) {
                                                    $code .= '_' . $key;
                                                }

                                                if ($this->customer->isLogged()) {
                                                    $customer_group_id = $this->customer->getCustomerGroupId();
                                                } else {
                                                    $customer_group_id = $this->config->get('config_customer_group_id');
                                                }

                                                $quote_data_item = array(
                                                    'code'			=> $cdek_code,
                                                    'cod'			=> $cod,
                                                    'pvz'			=> $key,
                                                    'title'			=> $description,
                                                    'cost'			=> 0,
                                                    'tax_class_id'	=> $this->config->get('cdek_tax_class_id'),
                                                    'text'	        => ($customer_group_id == 2 ? '<b>оценочно</b> ' : '') . $this->currency->format($this->tax->calculate($price, $this->config->get('cdek_tax_class_id'), $this->config->get('config_tax')))
                                                );

                                                if ('' != $quote_description) {

                                                    $quote_data_item['title'] = $tariff_title_short;

                                                    $quote_data_item += array(
                                                        'title_sub'		=> $description,
                                                        'title_clear'	=> $tariff_title_clear,
                                                        'description'	=> $quote_description
                                                    );

                                                }

                                                $quote_data[$code] = $quote_data_item;
                                            }

                                        }

                                    }

                                } else {

                                    if ($this->config->get('cdek_log')) {
                                        $this->log->write('СДЭК: нет результатов для вывода!');
                                    }

                                }
                            }
                        }
                    }

                } else {

                    if ($this->config->get('cdek_log')) {
                        $this->log->write('СДЭК: не определен подходящий город!');
                    }

                }

            } else {

                if ($this->config->get('cdek_log')) {
                    $this->log->write('СДЭК: город доставки не определен!');
                }

            }
        }

        $method_data = [];

        if (!$quote_data && !empty($empty_info['use']) && $address['country_id'] == 176) {

            if (!empty($empty_info['title'][$this->config->get('config_language_id')])) {
                $title = $empty_info['title'][$this->config->get('config_language_id')];
            } else {
                $title = $this->language->get('text_title');
            }

            if (!empty($empty_info['cost'])) {
                $price = (float)$empty_info['cost'];
            } else {
                $price = 0;
            }

            $quote_data['empty'] = array(
                'code'         => 'cdek.empty',
                'title'        => $title,
                'cost'         => $price,
                'tax_class_id' => $this->config->get('cdek_tax_class_id'),
                'text'         => $this->currency->format($this->tax->calculate($price, $this->config->get('cdek_tax_class_id'), $this->config->get('config_tax')))
            );

        }

        if ($quote_data) {

            $title_info = $this->config->get('cdek_title');

            if (!empty($title_info[$this->config->get('config_language_id')])) {
                $title = $title_info[$this->config->get('config_language_id')];
            } else {
                $title = $this->language->get('text_title');
            }

            $method_data = array(
                'code'       => 'cdek',
                'title'      => $title,
                'quote'      => $quote_data,
                'sort_order' => (int)$this->config->get('cdek_sort_order'),
                'error'      => false
            );
        }

        return $method_data;
    }

    private function initAddress($address)
    {
        foreach (array('country_id', 'zone_id') as $field) {

            if (!isset($address[$field])) {
                $address[$field] = 0;
            }

        }

        foreach (array('address_1', 'city', 'postcode') as $field) {

            if (!isset($address[$field])) {
                $address[$field] = '';
            }

        }

        if (!empty($address['city'])) {
            $address['city'] = preg_replace('/^\s*г\.?\s+/isu', '', $address['city']);
        }

        return $address;
    }

    private function getCity($city)
    {
        return $city ? $this->getURL('http://api.cdek.ru/city/getListByTerm/json.php?q=' . urlencode($city) . '&name_startsWith=' . urlencode($city), 'json') : false;
    }

    private function getMap($data)
    {
        static $first_call = true;

        $first_pvz = null;

        if (isset($this->session->data['cdek_last_pvz'][$data['tariff_id']])) {

            $last_pvz = $this->session->data['cdek_last_pvz'][$data['tariff_id']];

            foreach ($data['pvz'] as $item) {

                if ($item['code'] == $last_pvz) {
                    $first_pvz = $item;
                }

            }

        }

        if (empty($first_pvz)) {
            $first_pvz = reset($data['pvz']);
        }

        $active_pvz = $first_pvz['code'];

        $html = '';

        if ($first_call) {

            $html .= '<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
            $html .= '<script src="/catalog/view/javascript/cdek/bootstrap-list-filter.js" type="text/javascript"></script>';
            $html .= '<script type="text/javascript" src="/catalog/view/javascript/cdek/cdek.map.js"></script>';
            $html .= '<style type="text/css"> ';
            $html .= '.js-link{text-decoration:none!important;border-bottom:1px dashed  #23a1d1;margin-bottom:15px;display:inline-block;line-height:1.5em} ';
            $html .= '.js-link:hover{border-color:transparent}';
            $html .= '</style>';

            $first_call = false;
        }

        $html .= '<div class="cdek-container" style="margin-top:5px">';

        if (!empty($data['description'])) {
            $html .= $data['description'];
            $html .= '<br />';
        }

        $html .= '<div class="cdek-pvz-info" style="margin-top:5px;margin-bottom:5px">';
        $html .= '	<strong>Адрес</strong>: ' . $first_pvz['address_short'];
        $html .= '<br />';

        if (!empty($first_pvz['phone'])) {
            $html .= '	<strong>Телефон</strong>: ' . $first_pvz['phone'] . '<br />';
        }

        if (!empty($first_pvz['work_time'])) {
            $html .= '<strong>Режим работы</strong>: ' . $first_pvz['work_time'];
        }

        $html .= '</div>';

        if (count($data['pvz']) > 1) {
            $html .= '<a href="javascript:void(0);" onClick="event.preventDefault(); event.stopPropagation(); showMap(this);" class="js-link" data-id="' . $data['tariff_id'] . '" data-active="' . $active_pvz . '" data-city="' . $data['city']['id'] . '">Выбрать другой пункт выдачи</a>';
        }

        $html .= '</div>';

        return $html;
    }

    private function getHTML($tariff_id, $pvz_list, $description = '')
    {
        static $first_call = true;

        if (isset($this->session->data['cdek_last_pvz'][$tariff_id])) {

            $last_pvz = $this->session->data['cdek_last_pvz'][$tariff_id];

            foreach ($pvz_list as $item) {

                if ($item['code'] == $last_pvz) {
                    $first_pvz = $item;
                }
            }
        }

        if (empty($first_pvz)) {
            $first_pvz = reset($pvz_list);
        }

        $active_pvz = $first_pvz['code'];

        $html = '';

        if ($first_call) {

            $html .= '<script type="text/javascript" src="/catalog/view/javascript/cdek/cdek.js"></script>';

            $first_call = false;
        }

        $html .= '<div class="cdek-container" style="margin-top:5px;margin-bottom:5px">';

        if ($description) {
            $html .= $description;
            $html .= '<br />';
        }

        if (count($pvz_list) > 1) {

            $html .= '	<select onChange="event.preventDefault(); event.stopPropagation(); changePVZ(this);" class="cdek-pvz-list" data-id="' . $tariff_id . '" data-active="' . $active_pvz . '" style="margin-top:5px;margin-bottom:5px">';

            foreach ($pvz_list as $pvz_info) {
                $html .= '	<option ' . ($active_pvz == $pvz_info['code'] ? 'selected="selected"' : '') . ' value="' . $pvz_info['code'] . '" data-worktime="' . $pvz_info['work_time'] . '" data-address="' . $pvz_info['address_short'] . '" data-phone="' . $pvz_info['phone'] . '">' . $pvz_info['address'] . '</option>';
            }

            $html .= '	</select>';

        }

        $html .= '<div class="cdek-pvz-info" style="margin-top:5px">';
        $html .= '	<strong>Адрес</strong>: ' . $first_pvz['address_short'];

        $html .= '<br />';

        if (!empty($first_pvz['phone'])) {
            $html .= '	<strong>Телефон</strong>: ' . $first_pvz['phone'] . '<br />';
        }

        if (!empty($first_pvz['work_time'])) {
            $html .= '<strong>Режим работы</strong>: ' . $first_pvz['work_time'];
        }

        $html .= '</div></div>';

        return $html;
    }

    private function getBlankDescription($description = '')
    {
        $html = '';

        if ('' != $description) {

            $html .= '<div class="cdek-container" style="margin-top:5px;margin-bottom:5px">';
            $html .= $description;
            $html .= '</div>';

        }

        return $html;
    }

    private function getResult(CalculatePriceDeliveryCdek &$calc, $total = 0)
    {
        $result = false;

        if (true === $calc->calculate()) {

            $response = $calc->getResult();

            if (!$this->config->get('cdek_cache_on_delivery') || !array_key_exists('cashOnDelivery', $response['result']) || ($this->config->get('cdek_cache_on_delivery') && (float)$response['result']['cashOnDelivery'] && $total >= (float)$response['result']['cashOnDelivery'])) {
                $result = $response['result'];
            }

        } else {

            $error = $calc->getError();

            if (isset($error['error']) && !empty($error) && $this->config->get('cdek_log')) {
                foreach($error['error'] as $error_info) {
                    $this->log->write('СДЭК: ' . $error_info['text']);
                }
            }

        }

        return $result;
    }

    private function getPVZList($type, $city_id, $weight = 0)
    {
        static $all = [];

        if (!$all) {
            $all = $this->getPVZAll($weight);
        }

        $pvz_list = [];

        if (isset($all[$type][$city_id])) {

            $pvz_list = $all[$type][$city_id];

            $sort_order = [];

            foreach ($pvz_list as $key => $pvz_info) {
                $sort_order[$key] = $pvz_info['address'];
            }

            array_multisort($sort_order, SORT_ASC, $pvz_list);

            if ($this->config->get('cdek_pvz_more_one') == 'first') {
                $pvz_list = array(reset($pvz_list));
            }

        } else {

            if ($this->config->get('cdek_log')) {
                $this->log->write('СДЭК: Для выбранного города список пунктов выдачи отсутствует!');
            }

        }

        return $pvz_list;
    }

    public function getPVZAll($weight = 0)
    {
        $pvz_list = $this->cache->get('cdek.shipping.pvz');

        if (!$pvz_list) {

            $pvz_list = [];

            $servers = array(
                'http://integration.cdek.ru/',
                'http://int.cdek.ru/',
                /*'http://lk.cdek.ru:11443/',
                'http://gw.edostavka.ru:11443/',*/
                'https://integration.cdek.ru/'
            );

            foreach ($servers as $server) {

                $pvz_list_data = $this->getURL($server . 'pvzlist.php?type=ALL');

                if (!empty($pvz_list_data)) {
                    break;
                }

            }

            if (!empty($pvz_list_data) && isset($pvz_list_data->Pvz)) {

                $use_limit = $this->config->get('cdek_weight_limit');

                $ignore = [];

                if ($this->config->get('cdek_pvz_ignore')) {

                    $ignore = explode(',', $this->config->get('cdek_pvz_ignore'));
                    $ignore = array_map('trim', $ignore);
                    $ignore = array_filter($ignore);
                    $ignore = array_map(array($this, 'clearText'), $ignore);

                }

                foreach ($pvz_list_data->Pvz as $pvz_info) {

                    if (in_array($this->clearText((string)$pvz_info['Code']), $ignore)) {
                        continue;
                    }

                    if (empty($pvz_info['City']) || empty($pvz_info['Address'])) {
                        continue;
                    }

                    $key = md5($pvz_info['Address']);
                    $type = (string)$pvz_info['Type'];
                    $city_id = (int)$pvz_info['CityCode'];

                    if (!empty($pvz_list[$type][$city_id][$key])) continue;

                    if (isset($pvz_info->WeightLimit)) {

                        $min_weight = (float)$pvz_info->WeightLimit['WeightMin'];
                        $max_weight = (float)$pvz_info->WeightLimit['WeightMax'];

                        if ($use_limit && (($min_weight > 0 && $weight < $min_weight) || ($max_weight > 0 && $weight > $max_weight))) {

                            if ($this->config->get('cdek_log')) {
                                $this->log->write('СДЭК: превышены ограничения по весу для ПВЗ ' . $pvz_info['Name'] . ' по адресу: ' . $pvz_info['Address'] . '!');
                            }

                            continue;
                        }
                    }

                    $pvz_address = 'г. ' . (string)$pvz_info['City'] . ', ' . $this->mb_ucfirst((string)$pvz_info['Address'], 'UTF-8', true) . '.';

                    $work_time = $phone = '';

                    if (!empty($pvz_info['WorkTime']) && trim($pvz_info['WorkTime']) != '-') {
                        $work_time = (string)$pvz_info['WorkTime'];
                        $pvz_address .= ' Режим работы: ' . $work_time . '.';
                    }

                    if (!empty($pvz_info['Phone']) && trim($pvz_info['Phone']) != '-') {
                        $phone = (string)$pvz_info['Phone'];
                        $pvz_address .= ' Телефон: ' . $phone . '.';
                    }

                    $pvz_list[$type][$city_id][$key] = array(
                        'address'		=> $this->mb_ucfirst((string)$pvz_info['Address'], 'UTF-8', true),
                        'address_full'	=> $pvz_address,
                        'address_short'	=> 'г. ' . (string)$pvz_info['City'] . ', ' . $this->mb_ucfirst((string)$pvz_info['Address'], 'UTF-8', true),
                        'code'			=> (string)$pvz_info['Code'],
                        'name'			=> (string)$pvz_info['Name'],
                        'work_time'		=> $work_time,
                        'phone'			=> $phone,
                        'x'				=> (string)$pvz_info['coordX'],
                        'y'				=> (string)$pvz_info['coordY']
                    );
                }

                $this->cache->set('cdek.shipping.pvz', $pvz_list);
            }

            if (!$pvz_list) {

                if ($this->config->get('cdek_log')) {
                    $this->log->write('СДЭК: Не удалось получить список точек выдачи. Возможно произошла ошибка на сервере СДЭК или на вашем хостинге заблокирован порт 11443.');
                }

            }

        }

        return $pvz_list;
    }

    private function getDiscount($total, $tariff_Id = 0, $geo_zones = [])
    {
        $discounts = [];

        $cdek_discounts = $this->config->get('cdek_discounts');

        if (!empty($cdek_discounts)) {

            if ($this->customer->isLogged()) {
                $customer_group_id = $this->customer->getCustomerGroupId();
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }

            foreach ($cdek_discounts as $key => $discount_info) {

                $item_status = TRUE;

                if ((!empty($discount_info['customer_group_id']) && !in_array($customer_group_id, $discount_info['customer_group_id']))) {
                    $item_status = false;
                }

                if (!empty($discount_info['geo_zone'])) {

                    $intersect = array_intersect($discount_info['geo_zone'], $geo_zones);

                    if (!$intersect) {
                        $item_status = false;
                    }

                }

                if (!isset($discount_info['tariff_id'])) $discount_info['tariff_id'] = [];

                if ($item_status && (float)$discount_info['total'] <= $total && (!$discount_info['tariff_id'] || in_array($tariff_Id, $discount_info['tariff_id']))) {
                    $discounts[$discount_info['prefix'] . '_' . $discount_info['mode']] = $discount_info;
                }
            }
        }

        return $discounts;
    }

    private function prepareRegion($name = '')
    {
        $regions = [];

        $parts = explode(' ', $name);
        $parts = array_map(array($this, 'clearText'), $parts);

        if (in_array($parts[0], array('московская', 'москва'))) {
            $regions[] = 'москва';
            $regions[] = 'московская';
        } elseif (in_array($parts[0], array('ленинградская', 'санкт-петербург'))) {
            $regions[] = 'санкт-петербург';
            $regions[] = 'ленинградская';
        } elseif (mb_strpos($parts[0], 'респ') === 0) {
            $regions[] = $parts[1];
        } elseif (in_array($parts[0], array('киев', 'киевская'))) { // Украина
            $regions[] = 'киевская';
            $regions[] = 'киев';
        } elseif (in_array($parts[0], array('винница', 'винницкая'))) { // Украина
            $regions[] = 'винница';
            $regions[] = 'винницкая';
        } elseif (in_array($parts[0], array('днепропетровск', 'днепропетровская'))) { // Украина
            $regions[] = 'днепропетровск';
            $regions[] = 'днепропетровская';
        } elseif (in_array($parts[0], array('чувашская'))) {
            $regions[] = 'чувашия';
        } elseif (in_array($parts[0], array('удмуртская'))) {
            $regions[] = 'удмуртия';
        } else {
            $regions = $parts;
        }

        return $regions;
    }

    private function prepareCountry($name = '')
    {
        $countries = [];

        $name = $this->clearText($name);

        if (in_array($name, array('российская федерация', 'россия', 'russia', 'russian', 'russian federation'))) {
            $countries[] = 'россия';
        } elseif(in_array($name, array('украина', 'ukraine'))) {
            $countries[] = 'украина';
        } elseif(in_array($name, array('белоруссия', 'белоруссия (беларусь)', 'беларусь', '(беларусь)', 'belarus'))) {
            $countries[] = 'белоруссия (беларусь)';
        } elseif(in_array($name, array('казахстан', 'kazakhstan'))) {
            $countries[] = 'казахстан';
        } elseif(in_array($name, array('сша', 'соединенные штаты америки', 'соединенные штаты', 'usa', 'united states'))) {
            $countries[] = 'сша';
        } elseif(in_array($name, array('aзербайджан', 'azerbaijan'))) {
            $countries[] = 'aзербайджан';
        } elseif(in_array($name, array('узбекистан', 'uzbekistan'))) {
            $countries[] = 'узбекистан';
        } elseif(in_array($name, array('китайская народная республика', 'сhina'))) {
            $countries[] = 'китай (кнр)';
        } else {
            $countries[] = $name;
        }

        return $countries;
    }

    private function normalizeDate($value = '')
    {
        return str_replace('-', '.', $value);
    }

    private function clearText($value)
    {
        $value = mb_convert_case($value, MB_CASE_LOWER, "UTF-8");
        return trim($value);
    }

    private function isAdmin()
    {
        return !empty($this->request->get['route']) && 'checkout/manual' == $this->request->get['route'];
    }

    private function declination($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    private function getVolume($data, $length_class_id)
    {
        if ($length_class_id != $this->length_class_id) {
            array_walk($data, array($this, 'convertItem'), $length_class_id);
        }

        $p = 1;

        foreach ($data as $value) {
            $p *= (float)$value;
        }

        return $p / 1000000;
    }

    private function convertItem(&$value, $key, $length_class_id)
    {
        $value = $this->length->convert($value, $length_class_id, $this->length_class_id);
    }

    private function getURL($url, $type = 'xml')
    {
        return parser_factoty::convert($type, $this->getUrlData($url));
    }

    private function getUrlData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);

        $out = curl_exec($ch);

        curl_close($ch);

        return $out;
    }

    private function mb_ucfirst($str, $enc = 'utf-8', $lower = false)
    {
        $str = (string)$str;

        if ($lower) {
            $str = mb_strtolower($str, $enc);
        }

        return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc) . mb_substr($str, 1, mb_strlen($str, $enc), $enc);
    }

    private function getAddressByPostcode($postcode)
    {
        if ($this->validatePostcode($postcode)) {

            $response = $this->getURL('http://api.print-post.com/api/index/v2/?index=' . $postcode, 'json');

            if ($response) {

                if (!empty($response['error'])) {
                    return false;
                }

                $address_list = [];

                if (empty($response['city']) && !empty($response['region'])) {
                    $response['city'] = $response['region'];
                }

                foreach (array('city', 'megalopolis') as $field) {

                    if (!empty($response[$field])) {

                        $address = array(
                            'city' => $response[$field],
                        );

                        if (!empty($response['region'])) {
                            $address['zone'] = $response['region'];
                        }

                        $address_list[] = $address;
                    }
                }

                return $address_list;
            }
        }

        return false;
    }

    private function validatePostcode($postcode)
    {
        return 1 === preg_match('/^\d{6}$/is', $postcode);
    }

    private function getAddressByIP()
    {
        $ip = $this->getIP();

        $address = $this->getURL('http://ipgeobase.ru:7020/geo?ip=' . $ip, 'xml');

        if ($address) {

            if ($address->ip) {

                return array(
                    'city' => (string)$address->ip->city,
                    'zone' => (string)$address->ip->region
                );

            }

        }

        return false;
    }

    private function getIP()
    {
        $ip = false;

        $source = array(
            'X_REAL_IP',
            'CLIENT_IP',
            'VIA',
            'X_FORWARDED',
            'FORWARDED_FOR',
            'FORWARDED',
            'FORWARDED_FOR_IP',
            'HTTP_PROXY_CONNECTION',
            'HTTP_VIA',
            'HTTP_FORWARDED_FOR',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'X_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR_IP'
        );

        foreach ($source as $header) {

            if (!empty($this->request->server[$header])) {

                $ips = $this->getIpFromText($this->request->server[$header]);

                if ($ips) {

                    $ip = array_shift($ips);

                    break;
                }

            }
        }

        if (!$ip) {
            $ip = $this->request->server['REMOTE_ADDR'];
        }

        return $ip;
    }

    private function getIpFromText($str = '')
    {
        $ips = [];

        if (!is_scalar($str) || '' == trim($str)) {
            return $ips;
        }

        foreach (array(',', ';', ' ', '_') as $delim) {

            $parts = explode($delim, $str);

            foreach ($parts as $part) {

                if (filter_var($part, FILTER_VALIDATE_IP) !== false) {
                    $ips[] = $part;
                }

            }
        }

        return $ips;
    }
}
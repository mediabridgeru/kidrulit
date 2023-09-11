<?php

class ModelShippingBB extends Model
{
    private $api_token;
    private $sucrh;
    private $log_mode;
    private $m_geoZones;
    private $delivery_period    = false;
    private $kd_delivery_period = false;
    private $custom_params;
    const CUSTOM_PARAMS_FILENAME = 'bb.json';

    public function __construct($registry) {
        parent::__construct($registry);
        $this->registry = $registry;
        $versionDigits = explode('.', VERSION);
        $this->opencartVersion = floatval(
            $versionDigits[0] . $versionDigits[1] . $versionDigits[2] . '.' . (isset($versionDigits[3]) ? $versionDigits[3] : 0)
        );
        $extensionDir = $this->opencartVersion < 230 ? '' : 'extension/';
        $paramsFilePath = DIR_APPLICATION . 'model/' . $extensionDir . 'shipping/' . self::CUSTOM_PARAMS_FILENAME;
        $this->custom_params = [];
        if (file_exists($paramsFilePath)) {
            $this->custom_params = @json_decode(file_get_contents($paramsFilePath), true);
            $this->logInfo('Custom BB params was loaded: ' . file_get_contents($paramsFilePath));
        }
    }

    private static $replace_zones = null;

    public function getReplaceZones() {
        if (self::$replace_zones == null) {
            $bb_regions = file_get_contents(DIR_APPLICATION . '/model/shipping/bb_regions.txt');
            self::$replace_zones = json_decode($bb_regions, true);
            if (self::$replace_zones == null) {
                $this->logError('Bad or not found bb_regions.txt, check that BOM prefix not exist');
            }
        }
        return self::$replace_zones;
    }

    public function getZoneIdByName($sp05f874) {
        $sp05f874 = mb_strtoupper($sp05f874, 'UTF-8');
        $this->load->model('localisation/zone');
        $spf366ec = $this->m_geoZones
        == null ? $this->model_localisation_zone->getZonesByCountryId($this->getCountryId()) : $this->m_geoZones;
        $sp38eadd = false;
        $this->m_geoZones = $spf366ec;
        $replacedZones = $this->getReplaceZones();
        foreach ($spf366ec as $spc1234e) {
            $spcca2b3 = ltrim(mb_strtoupper($spc1234e['name'], 'UTF-8'));
            if ($sp05f874 == $spcca2b3 && $sp05f874 == 'САНКТ-ПЕТЕРБУРГ') {
                $sp38eadd = true;
            } elseif ($sp05f874 == $spcca2b3 && $sp05f874 == 'МОСКВА') {
                $sp38eadd = true;
            } elseif (array_key_exists($spcca2b3, $replacedZones)) {
                $spcca2b3 = $replacedZones[$spcca2b3];
            }
            if ($sp05f874 == 'КРЫМ РЕСПУБЛИКА' && mb_strstr($spcca2b3, 'КРЫМ')) {
                $sp38eadd = true;
            } elseif ($spcca2b3 == $sp05f874) {
                $sp38eadd = true;
            }
            if ($sp38eadd) {
                return $spc1234e['zone_id'];
                break;
            }
        }
        $this->logError('Zone id not found for BB Area: ' . $sp05f874);
        return 0;
    }

    private function writeToLog($logType, $data) {
        if ($this->log_mode) {
            $stream = fopen(DIR_LOGS . 'bb.log', 'a');
            fwrite(
                $stream, date('d.m.Y H:i:s') . ' [' . $logType . '] ' . $data . '
'
            );
            fclose($stream);
        }
    }

    private function logInfo($data) {
        $this->writeToLog('INFO', $data);
    }

    private function logError($data) {
        $this->writeToLog('ERROR', $data);
    }

    private function getSettingsValue($key, $zoneId = '') {
        return $zoneId == ''
            ? $this->config->get('bb_' . $key)
            : $this->config->get('bb_' . $zoneId . '_' . $key);
    }

    private function getConfigValue($key, $default = '', $zoneId = '') {
        $value = $zoneId == ''
            ? $this->config->get('bb_' . $key)
            : $this->config->get('bb_' . $zoneId . '_' . $key);

        return is_null($value) ? $default : $value;
    }

    private function curlRequest($requestUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html, application/xhtml+xml',
            'Accept-Language: ru-RU',
            'Pragma: no-cache',
            'Connection: Keep-Alive',
        ]);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $stream = null;
        if ($this->log_mode) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $stream = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $stream);
        }
        $result = curl_exec($ch);
        if ($this->log_mode && $result === false) {
            $this->logError(
                sprintf('cUrl error (#%d): %s',
                    curl_errno($ch),
                    htmlspecialchars(curl_error($ch)
                    )
                )
            );
            rewind($stream);
            $spe7829b = stream_get_contents($stream);
            $this->logError(
                'Verbose information:',
                htmlspecialchars($spe7829b), ''
            );
            return '';
        }
        $info = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        $resultStrings = explode('
', $result);
        $urlWithLocation = $requestUrl;
        $stringsQuantity = count($resultStrings);
        for ($i = 0; $i < $stringsQuantity; $i++) {
            if (strpos($resultStrings[$i], 'Location:') !== false) {
                $urlWithLocation = trim(str_replace('Location:', '', $resultStrings[$i]));
                break;
            }
        }
        if ($urlWithLocation == $requestUrl) {
            $result = substr($result, $info);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlWithLocation);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: text/html, application/xhtml+xml',
                'Accept-Language: ru-RU',
                'Pragma: no-cache',
                'Connection: Keep-Alive',
            ]);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            if ($this->log_mode) {
                curl_setopt($ch, CURLOPT_VERBOSE, true);
                $stream = fopen('php://temp', 'w+');
                curl_setopt($ch, CURLOPT_STDERR, $stream);
            }
            $result = curl_exec($ch);
            if ($this->log_mode && $result === false) {
                $this->logError(
                    sprintf(
                        'cUrl error (#%d): %s',
                        curl_errno($ch),
                        htmlspecialchars(curl_error($ch))
                    )
                );
                rewind($stream);
                $spe7829b = stream_get_contents($stream);
                $this->logError('Verbose information:', htmlspecialchars($spe7829b), '');
                return '';
            }
            curl_close($ch);
        }
        return $result;
    }

    private function getParams($paramType, $getToken, $params = []) {
        $params['method'] = $paramType;
        if ($getToken) {
            $this->api_token = $this->getSettingsValue('api_token');
            $this->log_mode = $this->getSettingsValue('debug_mode');
        }
        $api_url = $this->getSettingsValue('api_url');
        if (!empty($this->custom_params) && isset($this->custom_params['api_url'])) {
            $api_url = $this->custom_params['api_url'];
        }
        $this->sucrh = '';
        if (!empty($this->custom_params) && isset($this->custom_params['sucrh'])) {
            $this->sucrh = $this->custom_params['sucrh'];
        }
        $params['token'] = isset($this->session->data['bb_api_token']) ? $this->session->data['bb_api_token'] : $this->api_token;
        $requestUrl = $api_url . '/json.php?' . http_build_query($params);
        $this->logInfo('Call API: ' . $requestUrl);
        $curlResponse = $this->curlRequest($requestUrl);
        $json = json_decode($curlResponse, true);
        if (empty($json)) {
            $this->logError('Call ' . $paramType . ' failed: Empty response');
            return [];
        }
        if (isset($json['err'])) {
            $this->logError('Call ' . $paramType . ' failed: ' . $json['err']);
            return [];
        }
        if (isset($json[0]['err'])) {
            $this->logError('Call ' . $paramType . ' failed: ' . $json[0]['err']);
            return [];
        }
        if ($paramType != 'DeliveryCosts') {
            $curlResponse = '';
        }
        $this->logInfo('Call ' . $paramType . ' OK ' . $curlResponse);
        return $json;
    }

    private function getCourierListCities($getToken = false) {
        $cacheCode = 'clc';
        $courierListCities = $this->cache->get('bb.' . $cacheCode);
        if (!$courierListCities) {
            $courierListCities = $this->getParams('CourierListCities', $getToken);
            $this->cache->set('bb.' . $cacheCode, $courierListCities);
        }
        return $courierListCities;
    }

    private function specdada($getToken = false) {
        $cacheCode = 'lc';
        $listCities = $this->cache->get('bb.' . $cacheCode);
        if (!$listCities) {
            $listCities = $this->getParams('ListCities', $getToken);
            $this->cache->set('bb.' . $cacheCode, $listCities);
        }
        return $listCities;
    }

    private function getZipCheck($postcode, $getToken = false) {
        $cacheCode = $postcode;
        $zipCheck = $this->cache->get('bb.zc.' . $cacheCode);
        if (!$zipCheck) {
            $zipCheck = $this->getParams('ZipCheck', $getToken, ['Zip' => $postcode]);
            $this->cache->set('bb.zc.' . $cacheCode, $zipCheck);
        }
        return $zipCheck;
    }

    private function getPVZByCode($check_weight, $cityCode, $getToken) {
        $prepaid_pvz_only = $this->getConfigValue('prepaid_pvz_only', 0);
        if ($this->cart->getWeight() > 0) {
            $cartWeight = intval($this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), 2))
                + $this->getSettingsValue('package_weight');
        } else {
            $cartWeight = $this->getSettingsValue('package_weight');
        }
        $listPointsCode = $cityCode ? $cityCode . $cartWeight . $prepaid_pvz_only : 'all' . $cartWeight . $prepaid_pvz_only;
        $listPoints = $this->cache->get('bb.lp.' . $listPointsCode);
        if (!$listPoints) {
            if ($cityCode !== 0) {
                $listPoints = $this->getParams('ListPoints', $getToken, [
                    'CityCode' => $cityCode,
                    'prepaid'  => $prepaid_pvz_only ? 0 : 1,
                ]);
            } else {
                $listPoints = $this->getParams('ListPoints', $getToken, ['prepaid' => $prepaid_pvz_only ? 0 : 1]);
            }
            $sp031228 = false;
            $sp34f6bf = false;
            foreach ($listPoints as $pointIndex => $point) {
                if ($check_weight && $point['LoadLimit'] < $cartWeight / 1000) {
                    $sp031228 = true;
                    $this->logInfo('Skip PVZ ' . $point['Code'] . ' - weight limit: ' . $point['LoadLimit']);
                    unset($listPoints[$pointIndex]);
                } else {
                    if (isset($this->session->data['bb_shipping_pvz_id'])
                        && $point['Code'] === $this->session->data['bb_shipping_pvz_id']
                    ) {
                        $sp34f6bf = true;
                    }
                    if ($point['Area'] == '') {
                        $listPoints[$pointIndex]['Area'] = $point['CityName'];
                    }
                }
            }
            $this->cache->set('bb.lp.' . $listPointsCode, $listPoints);
            if ($sp031228 && !$sp34f6bf) {
                unset($this->session->data['bb_shipping_pvz_id']);
                unset($this->session->data['bb_shipping_city_id']);
                unset($this->session->data['bb_shipping_cod']);
            }
        }
        return $listPoints;
    }

    public function getPVZMapPoints() {
        $sp175491 = $this->getPVZByCode($this->getSettingsValue('check_weight'), 0, true);
        $sp978dd4 = [];
        $spe3389a = [];
        $zonesQuery = $this->db->query(
            'SELECT * FROM ' . DB_PREFIX . 'zone_to_geo_zone WHERE country_id = \'' . $this->getCountryId()
            . '\' AND (zone_id <> \'0\')'
        );
        if ($zonesQuery->num_rows) {
            $geoZones = $zonesQuery->rows;
            foreach ($geoZones as $geoZone) {
                $geoZoneId = $geoZone['geo_zone_id'];
                if ($this->getSettingsValue('status', $geoZoneId)) {
                    $sp20fc75 = $this->getSettingsValue('shipping_type', $geoZoneId);
                    if (!$sp20fc75) {
                        if (!in_array($geoZone['zone_id'], $spe3389a)) {
                            $spe3389a[] = $geoZone['zone_id'];
                        }
                    }
                }
            }
        }
        if (empty($spe3389a)) {
            return $sp175491;
        }
        $this->log_mode = $this->getSettingsValue('debug_mode');
        foreach ($sp175491 as $sp947e41) {
            if ($sp947e41['Country'] == 'Казахстан') {
                continue;
            }
            $sp0f3685 = $this->getZoneIdByName($sp947e41['Area']);
            if ($sp0f3685) {
                if (!in_array($sp0f3685, $spe3389a)) {
                    $sp978dd4[] = $sp947e41;
                } else {
                    $this->logInfo('Skip Map PVZ points ' . $sp947e41['Name'] . ' in area: ' . $sp0f3685);
                }
            } else {
                $this->logError('Zone id not found for Area: ' . $sp947e41['Area']);
            }
        }
        return $sp978dd4;
    }

    private function getDeliveryCostPrice($pvz_id, $cartWeight, $volume, $totalSum, $paysum = 0, $getToken = false) {
        if (isset($this->session->data['bb_foreign_shop']) && $this->session->data['bb_foreign_shop']) {
            return $this->sp212570($pvz_id, $cartWeight, $totalSum, 1, 1, $getToken);
        }

        $deliveryCostsCode = md5(
            $pvz_id . $cartWeight . $volume['height'] . $volume['width'] . $volume['depth'] . $totalSum . $paysum);

        $deliveryCosts = $this->cache->get('bb.dc.' . $deliveryCostsCode);

        if (!$deliveryCosts) {
            $deliveryCosts = $this->getParams('DeliveryCosts', $getToken, [
                'weight'   => $cartWeight,
                'target'   => $pvz_id,
                'ordersum' => $totalSum,
                'paysum'   => $paysum,
                'height'   => $volume['height'],
                'width'    => $volume['width'],
                'depth'    => $volume['depth'],
                'cms'      => 'OpenCart15',
                'sucrh'    => $this->sucrh,
            ]);
            $this->cache->set('bb.dc.' . $deliveryCostsCode, $deliveryCosts);
        }

        $this->delivery_period = isset($deliveryCosts['delivery_period']) ? $deliveryCosts['delivery_period'] : false;

        return isset($deliveryCosts['price']) ? $deliveryCosts['price'] : -1;
    }

    private function spc7c7f3($calcOptions, $postcode, $cartWeight, $volume, $totalSum, $paysum = 0, $getToken = false) {
        $deliveryCostsCode = md5(
            $postcode . $cartWeight . $volume['height'] . $volume['width'] . $volume['depth'] . $totalSum . $paysum);

        $deliveryCosts = $this->cache->get('bb.dck.' . $deliveryCostsCode);

        if (!$deliveryCosts) {
            $deliveryCosts = $this->getParams('DeliveryCosts', $getToken, [
                'weight'   => $cartWeight,
                'zip'      => $postcode,
                'ordersum' => $totalSum,
                'paysum'   => $paysum,
                'height'   => $volume['height'],
                'width'    => $volume['width'],
                'depth'    => $volume['depth'],
                'cms'      => 'OpenCart15',
                'sucrh'    => $this->sucrh,
            ]);

            $this->cache->set('bb.dck.' . $deliveryCostsCode, $deliveryCosts);
        }

        $this->kd_delivery_period = isset($deliveryCosts['delivery_period']) ? $deliveryCosts['delivery_period'] : false;

        $spd9d302 = isset($deliveryCosts['price']) && $deliveryCosts['price'] > 0 ? $deliveryCosts['price'] : -1;

        if ($spd9d302 >= 0) {
            $rate_value = (int)$calcOptions['rate_value'];
            if ($calcOptions['rate_option'] == 0) {
                $spd9d302 += $rate_value;
            } elseif ($calcOptions['rate_option'] == 1) {
                $spd9d302 += round($totalSum / 100 * $rate_value, 1, PHP_ROUND_HALF_UP);
            }
        }

        return $spd9d302;
    }

    private function sp212570($pvz_id, $cartWeight, $totalSum, $type, $foreign_insurance, $getToken = false) {
        $foreign_insurance = (int)$this->getSettingsValue('foreign_insurance');

        $deliveryCostsFCode = md5($pvz_id . $cartWeight . $type . $totalSum . $foreign_insurance);

        $deliveryCostsF = $this->cache->get('bb.dcf.' . $deliveryCostsFCode);

        if (!$deliveryCostsF) {
            $deliveryCostsF = $this->getParams('DeliveryCostsF', $getToken, [
                'weight'    => $cartWeight,
                'type'      => $type,
                'target'    => $pvz_id,
                'ordersum'  => $totalSum,
                'insurance' => $foreign_insurance,
            ]);

            $this->cache->set('bb.dcf.' . $deliveryCostsFCode, $deliveryCostsF);
        }

        $this->delivery_period = isset($deliveryCostsF['delivery_period']) ? $deliveryCostsF['delivery_period'] : false;

        return isset($deliveryCostsF['price']) ? $deliveryCostsF['price'] : -1;
    }

    private function getDeliveryPrice($calcOptions, $pvz_id, $shippingPVZTariffZone, $cartWeight, $totalSum, $paysum = 0) {
        $shippingPVZTariffZone = preg_replace('/[^0-9]/', '', $shippingPVZTariffZone);

        $this->delivery_period = false;
        $this->kd_delivery_period = false;

        if ($calcOptions['calc_type'] == 1) {
            $this->delivery_period = $calcOptions['fix_delivery_period'];
        }

        if ($calcOptions['use_tariff_zones']) {
            $spbb70f0 = 'tariff_zone_' . $shippingPVZTariffZone;
            $this->logInfo('Calculation pvz_id=' . $pvz_id . ' via tariff zone: ' . $shippingPVZTariffZone);
            $deliveryPrice = $this->getSettingsValue($spbb70f0);
        } else {
            $deliveryPrice = $calcOptions['calc_type']
            == 1 ? $calcOptions['fix_rate'] : $this->getDeliveryCostPrice($pvz_id, $cartWeight, $this->getCartVolume(), $totalSum, $paysum);
        }

        if ($deliveryPrice >= 0) {
            $rate_value = (int)$calcOptions['rate_value'];
            if ($calcOptions['rate_option'] == 0) {
                $deliveryPrice += $rate_value;
            } elseif ($calcOptions['rate_option'] == 1) {
                $deliveryPrice += round($totalSum / 100 * $rate_value, 1, PHP_ROUND_HALF_UP);
            }
        } else {
            $this->logError('Wrong base price: ' . $deliveryPrice);
            return $deliveryPrice;
        }

        if (isset($calcOptions['free_ship']) && (int)($calcOptions['free_ship'] > 0) && $totalSum >= $calcOptions['free_ship']) {
            $deliveryPrice = 0;
        }

        return $deliveryPrice;
    }

    public function getGeoCodingData() {
        $shipping_customer_zone = isset($this->session->data['bb_shipping_customer_zone']) ? $this->session->data['bb_shipping_customer_zone'] : '';
        $shipping_customer_city = isset($this->session->data['bb_shipping_customer_city']) ? $this->session->data['bb_shipping_customer_city'] : '';

        $mapData = [];
        $mapData['location'] = '55.76, 37.64';
        $mapData['zoom'] = 6;

        if ($shipping_customer_zone == '' && $shipping_customer_city == '') {
            return $mapData;
        }

        $requestUrl = 'http://geocode-maps.yandex.ru/1.x/?';
        $requestParams = ['geocode' => 'Россия ' . $shipping_customer_zone . ' ' . $shipping_customer_city, 'kind' => 'locality', 'format' => 'json'];
        $requestParams['apikey'] = $this->getSettingsValue('yandex_map_key');

        if (empty($requestParams['apikey'])) {
            if (!empty($this->custom_params) && isset($this->custom_params['geo_api_key'])) {
                $geo_api_key = $this->custom_params['geo_api_key'];
                if (!empty($geo_api_key)) {
                    $requestParams['apikey'] = $geo_api_key;
                }
            }
        }

        $response = $this->curlRequest($requestUrl . http_build_query($requestParams));

        if ($response) {
            $json = json_decode($response, true);

            if (array_key_exists('error', $json)) {
                $this->log_mode = $this->getSettingsValue('debug_mode');
                if (array_key_exists('message', $json)) {
                    $this->logError($json['message']);
                } else {
                    $this->logError('Your IP was banned by Yandex API. You need to create your own API Key https://developer.tech.yandex.ru/services');
                }
                return $mapData;
            }

            $featureMember = $json['response']['GeoObjectCollection']['featureMember'];

            if (count($featureMember)) {
                $firstMember = $featureMember[0];
                $coords = explode(' ', $firstMember['GeoObject']['Point']['pos']);
                $mapData['location'] = $coords[1] . ',' . $coords[0];
                $mapData['zoom'] = 10;

                if ($shipping_customer_city == '') {
                    $mapData['zoom'] = 7;
                }
            }
        }
        return $mapData;
    }

    private function isCanCourier($address) {
        $canCourier = false;
        $citiName = mb_strtoupper($address['city'], 'UTF-8');

        if ($citiName == '') {
            return false;
        }

        if (isset($this->session->data['bb_foreign_shop']) && $this->session->data['bb_foreign_shop']) {
            $courierListCities = [];
            $this->logInfo('Switch to Foreign Shop mode...');
        } else {
            $courierListCities = $this->getCourierListCities();
        }

        if (!count($courierListCities)) {
            $this->logInfo('Empty CourierListCities. Try to calculate via Zip: ' . $address['postcode']);
            $spd94fa8 = $this->getZipCheck($address['postcode']);

            if (isset($spd94fa8[0]['ExpressDelivery'])) {
                if ($spd94fa8[0]['ExpressDelivery']) {
                    $canCourier = true;
                    unset($this->session->data['bb_shipping_wrong_kd_index']);
                } else {
                    $this->logInfo('isCityHasKDPoints by index not available: ZIP=' . $address['postcode']);
                }
            }

            return $canCourier;
        }

        foreach ($courierListCities as $courierListCity) {
            if (mb_strtoupper($courierListCity['City'], 'UTF-8') == $citiName) {
                $canCourier = true;
            }
        }

        return $canCourier;
    }

    private function getCityPoints($check_weight, $address) {
        $citiName = mb_strtoupper($address['city'], 'UTF-8');
        $allPoints = $this->specdada();
        $replacedZones = $this->getReplaceZones();
        $pvzCounts = [];

        foreach ($allPoints as $pvz) {
            if (!array_key_exists($pvz['Name'], $pvzCounts)) {
                $pvzCounts[$pvz['Name']] = 1;
            } else {
                $pvzCounts[$pvz['Name']] += 1;
            }
        }

        foreach ($allPoints as $pvz) {
            if (mb_strtoupper($pvz['Name'], 'UTF-8') == $citiName) {
                if ($pvzCounts[$pvz['Name']] > 1) {
                    $sp7b5ce1 = mb_strtoupper($pvz['UniqName'], 'UTF-8');
                    $region = isset($address['zone']) ? ltrim(mb_strtoupper($address['zone'], 'UTF-8')) : '';
                    if (array_key_exists($region, $replacedZones)) {
                        $region = $replacedZones[$region];
                    }
                    if (strpos($sp7b5ce1, $region) === false) {
                        continue;
                    }
                }

                $cityCode = $pvz['Code'];
                $cityPoints = $this->getPVZByCode($check_weight, $cityCode, false);

                if (count($cityPoints)) {
                    $firstPoint = reset($cityPoints);
                    $pvzRegion = mb_strtoupper($firstPoint['Area'], 'UTF-8');
                    $region = isset($address['zone']) ? ltrim(mb_strtoupper($address['zone'], 'UTF-8')) : '';

                    if (mb_strstr($region, 'КРЫМ')) {
                        $region = 'КРЫМ РЕСПУБЛИКА';
                    }

                    if (array_key_exists($region, $replacedZones)) {
                        $region = $replacedZones[$region];
                    }

                    $isPeterburg = ltrim(mb_strtoupper($firstPoint['Area'], 'UTF-8')) == 'САНКТ-ПЕТЕРБУРГ';
                    $isCrimea = ltrim(mb_strtoupper($firstPoint['Area'], 'UTF-8')) == 'КРЫМ РЕСП';
                    $isMoscow = ltrim(mb_strtoupper($firstPoint['Area'], 'UTF-8')) == 'МОСКВА';

                    if ($region == $pvzRegion || $isPeterburg || $isMoscow || $isCrimea) {
                        return $cityPoints;
                    }
                }
                break;
            }
        }

        return [];
    }

    private function getCalcOptions($address) {
        $calcOptions = [];
        $calcOptions['calc_type'] = 0;
        $calcOptions['fix_rate'] = 0;
        $calcOptions['fix_delivery_period'] = 0;
        $calcOptions['rate_value'] = 0;
        $calcOptions['rate_option'] = 0;
        $calcOptions['shipping_type'] = 0;
        $calcOptions['kd_free_too'] = 0;
        $calcOptions['allow_cod'] = 0;
        $calcOptions['kd_delivery_zone'] = 0;
        $calcOptions['free_ship'] = 0;
        $calcOptions['free_total'] = 0;
        $calcOptions['free_total_to'] = 0;
        $calcOptions['use_tariff_zones'] = $this->getSettingsValue('calc_type') == 2;
        $calcOptions['round'] = $this->getSettingsValue('round');
        $spe6b5e4 = false;
        $this->session->data['bb_foreign_shop'] = $this->getSettingsValue('foreign_mode') == 1;
        $postcode = isset($address['postcode']) ? $address['postcode'] : '';
        $this->session->data['bb_shipping_wrong_kd_index'] = $postcode
        == '' ? $this->language->get('error_empty_kd_post_index') : $this->language->get('error_wrong_kd_post_index');
        if (isset($address['country_id']) && isset($address['zone_id'])) {
            $this->logInfo('Zone: ' . $address['zone_id'] . ', Country: ' . $address['country_id']);
            $zonesQuery = $this->db->query(
                'SELECT * FROM ' . DB_PREFIX . 'zone_to_geo_zone WHERE country_id = \'' . (int)$address['country_id']
                . '\' AND (zone_id = \'' . (int)$address['zone_id'] . '\' OR zone_id = \'0\') ORDER BY zone_id DESC'
            );
            if ($zonesQuery->num_rows) {
                $geoZones = $zonesQuery->rows;
                foreach ($geoZones as $geoZone) {
                    $geoZoneId = $geoZone['geo_zone_id'];
                    if ($this->getSettingsValue('status', $geoZoneId)) {
                        $this->logInfo('Calc geozone: ' . $geoZoneId);
                        $calcOptions['calc_type'] = $this->getSettingsValue('calc_type', $geoZoneId);
                        $calcOptions['fix_rate'] = $this->getSettingsValue('fix_rate', $geoZoneId);
                        $calcOptions['rate_value'] = $this->getSettingsValue('rate_value', $geoZoneId);
                        $calcOptions['rate_option'] = $this->getSettingsValue('rate_option', $geoZoneId);
                        $calcOptions['shipping_type'] = $this->getSettingsValue('shipping_type', $geoZoneId);
                        $calcOptions['allow_cod'] = $this->getSettingsValue('allow_cod', $geoZoneId);
                        $calcOptions['free_ship'] = $this->getConfigValue('free_ship', 0, $geoZoneId);
                        $calcOptions['kd_free_too'] = $this->getConfigValue('kd_free_too', 0, $geoZoneId);
                        $calcOptions['free_total'] = $this->getConfigValue('free_total', 0, $geoZoneId);
                        $calcOptions['free_total_to'] = $this->getConfigValue('free_total_to', 0, $geoZoneId);
                        $calcOptions['fix_delivery_period'] = $this->getConfigValue('fix_delivery_period', 5, $geoZoneId);
                        $spe6b5e4 = true;
                        break;
                    }
                }
            }
        }

        if (!$spe6b5e4) {
            $this->logInfo('No geozones, use defaults');
            $calcOptions['calc_type'] = $this->getSettingsValue('calc_type');
            $calcOptions['fix_rate'] = $this->getSettingsValue('fix_rate');
            $calcOptions['rate_value'] = $this->getSettingsValue('rate_value');
            $calcOptions['rate_option'] = $this->getSettingsValue('rate_option');
            $calcOptions['shipping_type'] = $this->getSettingsValue('shipping_type');
            $calcOptions['allow_cod'] = $this->getSettingsValue('allow_cod');
            $calcOptions['free_ship'] = $this->getConfigValue('free_ship', 0);
            $calcOptions['kd_free_too'] = $this->getConfigValue('kd_free_too', 0);
            $calcOptions['free_total'] = $this->getConfigValue('free_total', 0);
            $calcOptions['free_total_to'] = $this->getConfigValue('free_total_to', 0);
            $calcOptions['fix_delivery_period'] = $this->getConfigValue('fix_delivery_period', 5);
        }

        if ($calcOptions['shipping_type']) {
            if (strlen($postcode) == 6) {
                $spd94fa8 = $this->getZipCheck($postcode);
                if (isset($spd94fa8[0]['ExpressDelivery'])) {
                    if ($spd94fa8[0]['ExpressDelivery']) {
                        $calcOptions['kd_delivery_zone'] = $spd94fa8[0]['ZoneExpressDelivery'];
                        unset($this->session->data['bb_shipping_wrong_kd_index']);
                    } else {
                        $this->logInfo('KD is not available: ZIP=' . $postcode);
                    }
                }
            } else {
                $this->logInfo('Empty or wrong ZIP: ' . $postcode . ' KD will be charged as max zone 2');
            }
        }

        return $calcOptions;
    }

    public function getPVZById($spab22f7, $getToken) {
        $pvzByCode = $this->getPVZByCode($this->getSettingsValue('check_weight'), 0, $getToken);

        foreach ($pvzByCode as $sp947e41) {
            if ($sp947e41['Code'] === $spab22f7) {
                return $sp947e41;
            }
        }

        return false;
    }

    private function getCountryId() {
        $country_id = $this->getSettingsValue('country_id');

        if (!$country_id) {
            $country_id = 176;
        }

        return $country_id;
    }

    private function getTotalSum() {
        if (!$this->getSettingsValue('total_type')) {
            return $this->cart->getSubTotal();
        }

        $this->load->model('setting/extension');

        $total_data = [];
        $total = 0;
        $taxes = $this->cart->getTaxes();

        if ($this->config->get('config_customer_price') && $this->customer->isLogged()
            || !$this->config->get('config_customer_price')
        ) {
            $sort_order = [];

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    if ($result['code'] != 'shipping') {
                        $this->load->model('total/' . $result['code']);
                        $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                    }
                }
            }
        } else {
            return $this->cart->getSubTotal();
        }

        return $total;
    }

    public function pvzSort($sp6faf31, $spf8f5c9) {
        return strcmp($sp6faf31['AddressReduce'], $spf8f5c9['AddressReduce']);
    }

    function getQuote($address, $data = null) {
        $error = false;
        $sp48c2e7 = strlen($address['postcode']) == 6;
        $this->log_mode = $this->getSettingsValue('debug_mode');
        $this->api_token = $this->getSettingsValue('api_token');
        $isRussia = $address['country_id'] == $this->getCountryId() && $address['zone_id'];

        if (!$isRussia) {
            $this->logInfo(
                'Not Russia or Region is not selected: ' . $address['country_id'] . ' ' . $address['zone_id']
            );
            return false;
        }

        $this->session->data['bb_shipping_customer_zone'] = isset($address['zone']) ? $address['zone'] : '';
        $this->session->data['bb_shipping_customer_city'] = isset($address['city']) ? $address['city'] : '';
        $sp6f96da = defined('MAIN_CATALOG') ? MAIN_CATALOG : HTTP_SERVER;

        $this->language->load('shipping/bb');
        $calcOptions = $this->getCalcOptions($address);
        if (!$calcOptions['shipping_type']) {
            $this->logInfo('Could not calculate. Disabled in this area');
            return false;
        }

        $config_currency = $this->currency->getCode();

        if ($calcOptions['free_total'] && $this->getTotalSum() < $calcOptions['free_total']) {
            $this->logInfo(
                'Could not calculate. Too low cart total (' . $this->getTotalSum() . ' < ' . $calcOptions['free_total']
                . ') to use Boxberry shipping.'
            );
            return false;
        }

        if ($calcOptions['free_total_to'] && $this->getTotalSum() >= $calcOptions['free_total_to']) {
            $this->logInfo(
                'Could not calculate. Too high cart total (' . $this->getTotalSum() . ' >= ' . $calcOptions['free_total_to']
                . ') to use Boxberry shipping.'
            );
            return false;
        }

        $show_icons = $this->getSettingsValue('show_icons');
        $pickupIcon = $show_icons ? HTTP_SERVER . 'image/delivery_bb/pickup.gif' : '';
        $kdIcon = $show_icons ? HTTP_SERVER . 'image/delivery_bb/kd.gif' : '';
        $quote = [];
        $vqmod_simple_edost = dirname(DIR_SYSTEM) . '/vqmod/xml/vqmod_simple_edost.xml';
        $simplePath = DIR_SYSTEM . '/library/simple/simple.php';
        $vqmod_simple_edostExist = file_exists($vqmod_simple_edost);
        $simpleExist = file_exists($simplePath);
        $deliveryPriceValue = 0;
        $shippingCostValue = 0;
        $manyPVZ = false;
        $text_select_pvz = $this->language->get('text_select_pvz');
        $bb_html = '';
        $shipping_pvz = false;

        if (!empty($data) && is_array($data)) {
            $totalSum = isset($data['total']) ? $data['total'] : $this->getTotalSum();
            $cartWeight = isset($data['weight']) ? $data['weight'] : $this->cart->getWeight();
            $sp8d32aa = isset($data['bb_pvz_id']) ? $data['bb_pvz_id'] : 0;
            $allFreeShipping = $calcOptions['shipping_type'] == 1 || $calcOptions['shipping_type'] == 2;
            $allCourierShipping = $calcOptions['shipping_type'] == 1 || $calcOptions['shipping_type'] == 3;

            if ($allCourierShipping) {
                $allCourierShipping = $this->isCanCourier($address);
            }

            $sp4e2dd6 = -1;
            $shippingCostValue = -1;
            $spc1e03f = $calcOptions['calc_type'] == 1 && $calcOptions['fix_rate'] == 0
                || isset($calcOptions['free_ship'])
                && (int)($calcOptions['free_ship'] > 0)
                && $totalSum >= $calcOptions['free_ship'];
            if ($allFreeShipping) {
                $sp4e2dd6 = $spc1e03f ? 0 : $this->getDeliveryPrice($calcOptions, $sp8d32aa, 1, $cartWeight, $totalSum);
            }

            if ($allCourierShipping) {
                if (!$spc1e03f) {
                    $courierPrice = 200;
                    if ($calcOptions['kd_delivery_zone'] == 1) {
                        $courierPrice = 150;
                    }
                    $shippingCostValue = $sp4e2dd6 + $courierPrice;
                } else {
                    $shippingCostValue = 0;
                }
            }

            $quote = [];

            if ($sp4e2dd6 >= 0) {
                $text_pickup_description = '';
                $show_delivery_period = $this->getConfigValue('show_delivery_period', false);
                if ($show_delivery_period && $this->delivery_period != -1 && $this->delivery_period != false) {
                    $processing_days = (int)$this->getConfigValue('processing_days', 0) + (int)$this->delivery_period;
                    $workDaysCases = explode(';', $this->language->get('text_work_days'));
                    $text_pickup_description = sprintf($this->language->get('text_pickup_delivery_period'), $this->daysCase($processing_days, $workDaysCases));
                }

                $quote['pickup'] = [
                    'code'         => 'bb.pickup',
                    'title'        => $this->language->get('text_pickup_description') . ' #' . $sp8d32aa . ' '
                        . $text_pickup_description,
                    'cost'         => $sp4e2dd6,
                    'tax_class_id' => $this->config->get('bb_tax_class_id'),
                    'text'         => $this->currency->format($this->tax->calculate($sp4e2dd6, $this->config->get('bb_tax_class_id'), $this->config->get('config_tax'))),
                ];
            }

            if ($shippingCostValue >= 0) {
                $quote['kd'] = [
                    'code'         => 'bb.kd',
                    'title'        => $this->language->get('text_kd_description'),
                    'cost'         => $shippingCostValue,
                    'tax_class_id' => $this->config->get('bb_tax_class_id'),
                    'text'         => $this->currency->format($this->tax->calculate($shippingCostValue, $this->config->get('bb_tax_class_id'), $this->config->get('config_tax'))),
                ];
            }

            return [
                'code'       => 'bb',
                'title'      => $this->language->get('text_title'),
                'quote'      => $quote,
                'sort_order' => $this->config->get('bb_sort_order'),
                'error'      => $error,
            ];
        }

        $check_weight = $this->getSettingsValue('check_weight');
        if (!isset($this->session->data['bb_shipping_pvz_id']) || !isset($this->session->data['bb_shipping_city_id'])) {
            $cityPoints = $this->getCityPoints($check_weight, $address);

            if (count($cityPoints)) {
                $shipping_pvz = reset($cityPoints);
            }

            if (count($cityPoints) == 1) {
                $this->session->data['bb_shipping_typed_zone_id'] = $address['zone_id'];
                $this->session->data['bb_shipping_typed_city'] = $address['city'];
                $this->session->data['bb_shipping_pvz_id'] = $shipping_pvz['Code'];
                $this->session->data['bb_shipping_city_id'] = $shipping_pvz['CityCode'];
            } else {
                if (count($cityPoints) > 1) {
                    $manyPVZ = true;
                }
            }
        } else {
            $bb_shipping_pvz_id = $this->session->data['bb_shipping_pvz_id'];
            $sp93a19e = false;
            $shipping_typed = isset($this->session->data['bb_shipping_typed_zone_id'])
                && isset($this->session->data['bb_shipping_typed_city']);
            if ($shipping_typed) {
                if (!$this->customer->isLogged()) {
                    if ($address['zone_id'] != $this->session->data['bb_shipping_typed_zone_id']
                        || $address['city'] != $this->session->data['bb_shipping_typed_city']
                    ) {
                        $sp93a19e = true;
                    }
                }
            }

            if (!$shipping_typed) {
                $this->session->data['bb_shipping_typed_zone_id'] = $address['zone_id'];
                $this->session->data['bb_shipping_typed_city'] = $address['city'];
            }

            if ($sp93a19e) {
                unset($this->session->data['bb_shipping_pvz_id']);
                unset($this->session->data['bb_shipping_city_id']);
                unset($this->session->data['bb_shipping_cod']);
                $cityPoints = $this->getCityPoints($check_weight, $address);

                if (count($cityPoints) == 1) {
                    $shipping_pvz = reset($cityPoints);
                    $this->session->data['bb_shipping_typed_zone_id'] = $address['zone_id'];
                    $this->session->data['bb_shipping_typed_city'] = $address['city'];
                    $this->session->data['bb_shipping_pvz_id'] = $shipping_pvz['Code'];
                    $this->session->data['bb_shipping_city_id'] = $shipping_pvz['CityCode'];
                } else {
                    if (count($cityPoints) > 1) {
                        $manyPVZ = true;
                    }
                }
            } else {
                $cityCode = $this->session->data['bb_shipping_city_id'];
                $pvzByCode = $this->getPVZByCode($check_weight, $cityCode, false);
                $shipping_pvz = false;
                foreach ($pvzByCode as $pvz) {
                    if ($pvz['Code'] === $bb_shipping_pvz_id) {
                        $shipping_pvz = $pvz;
                        break;
                    }
                }
            }
        }

        $allFreeShipping = $calcOptions['shipping_type'] == 1 || $calcOptions['shipping_type'] == 2;
        $allCourierShipping = $calcOptions['shipping_type'] == 1 || $calcOptions['shipping_type'] == 3;
        if ($allCourierShipping) {
            $allCourierShipping = $this->isCanCourier($address);
        }

        if ($this->cart->getWeight() > 0) {
            $cartWeight = intval($this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), 2))
                + $this->getSettingsValue('package_weight');
        } else {
            $cartWeight = $this->getSettingsValue('package_weight');
        }

        $select_pvz = $this->getConfigValue('select_pvz', 0);
        if ($select_pvz == 1 || $select_pvz == 2) {
            $sp754fa5 = $this->getCityPoints($check_weight, $address);
            if (!empty($sp754fa5) && count($sp754fa5) > 1) {
                $firstPoint = reset($sp754fa5);
                $spf04109 = $firstPoint['CityCode'];
                $spc6706b = '<option value="0">' . $this->language->get('text_select_pvz_list') . '</option>';
                $pvzByCode = $this->getPVZByCode($check_weight, $spf04109, false);
                if (empty($pvzByCode)) {
                    unset($this->session->data['bb_shipping_pvz_id']);
                }
                uasort($pvzByCode, [$this, 'pvzSort']);
                foreach ($pvzByCode as $pvz) {
                    $sp887239 = isset($this->session->data['bb_shipping_pvz_id'])
                    && $pvz['Code'] === $this->session->data['bb_shipping_pvz_id'] ? 'selected' : '';
                    $spbae0d0 = array_key_exists('AddressReduce', $pvz) ? $pvz['AddressReduce'] : $pvz['Name'];
                    $spc6706b .= '<option ' . $sp887239 . ' value="' . $pvz['Code'] . '">' . $spbae0d0
                        . '</option>';
                }
                $bb_html = '<span style="display: block; margin-top: 2px; margin-bottom: 8px;"><select onchange="bb_callback($(this).val()); $(\'input[value=&quot;bb.pickup&quot;]\').prop(\'checked\', true); return false;">'
                    . $spc6706b . '</select></span>';
            }
        }

        if ($shipping_pvz) {
            if (!$manyPVZ) {
                $workSchedule = array_key_exists('WorkSchedule', $shipping_pvz) ? $shipping_pvz['WorkSchedule'] : $shipping_pvz['WorkShedule'];
                $this->session->data['bb_shipping_office_addr1'] = $shipping_pvz['Address'];
                $this->session->data['bb_shipping_office_addr2'] = $shipping_pvz['Phone'] . ', ' . $workSchedule;
            }

            $shippingPVZCode = $shipping_pvz['Code'];
            $totalSum = $this->getTotalSum();

            if ($this->cart->getWeight() > 0) {
                $cartWeight = intval($this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), 2))
                    + $this->getSettingsValue('package_weight');
            } else {
                $cartWeight = $this->getSettingsValue('package_weight');
            }

            $this->session->data['bb_shipping_cod'] = false;

            if ($calcOptions['allow_cod']) {
                if (!$manyPVZ) {
                    $this->session->data['bb_shipping_cod'] = $shipping_pvz['OnlyPrepaidOrders'] == 'No';
                } else {
                    $this->session->data['bb_shipping_cod'] = true;
                }
            }

            $shippingPVZTariffZone = $shipping_pvz['TariffZone'];
            $deliveryPriceValue = $this->getDeliveryPrice($calcOptions, $shippingPVZCode, $shippingPVZTariffZone, $cartWeight, $totalSum);
            if ($deliveryPriceValue < 0) {
                $this->logError('Bad response from BB server. Quit.');
                return false;
            }

            if (!$manyPVZ) {
                $text_select_pvz = $this->language->get('text_change_pvz');
                $spb1eb30 = explode('_', $shipping_pvz['Name']);
                $spbae0d0 = empty($spb1eb30) ? $shipping_pvz['Name'] : $spb1eb30[0];
                $workSchedule = array_key_exists('WorkSchedule', $shipping_pvz) ? $shipping_pvz['WorkSchedule'] : $shipping_pvz['WorkShedule'];
                $bb_html .= '<div id="bb-pvz-block" style="margin: 9px;"><b><span id="bb-pvz-name">' . $spbae0d0
                    . '</span></b><br><span id="bb-pvz-addr-short">' . $shipping_pvz['AddressReduce'] . '</span><br>'
                    . $this->language->get('text_phone') . '<span id="bb-pvz-phone">' . $shipping_pvz['Phone'] . '</span>'
                    . $this->language->get('text_work') . '<span id="bb-pvz-work">' . $workSchedule . '</span></div>';
            }
        }

        if ($allCourierShipping) {
            $totalSum = $this->getTotalSum();
            if ($this->cart->getWeight() > 0) {
                $cartWeight = intval($this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), 2))
                    + $this->getSettingsValue('package_weight');
            } else {
                $cartWeight = $this->getSettingsValue('package_weight');
            }
            
            if (isset($this->session->data['bb_foreign_shop']) && $this->session->data['bb_foreign_shop']) {
                $shippingCostValue = $this->sp212570($address['postcode'], $cartWeight, $totalSum, 2, 1);
            } else {
                $spc1e03f = $calcOptions['calc_type'] == 1 && $calcOptions['fix_rate'] == 0
                    || isset($calcOptions['free_ship'])
                    && (int)($calcOptions['free_ship'] > 0)
                    && $this->getTotalSum() >= $calcOptions['free_ship'];
                if ($spc1e03f && $calcOptions['kd_free_too']) {
                    $shippingCostValue = 0;
                } else {
                    $postcode = $address['postcode'];
                    if (!empty($postcode) && strlen($postcode) == 6) {
                        $shippingCostValue = $this->spc7c7f3($calcOptions, $postcode, $cartWeight, $this->getCartVolume(), $totalSum);
                        if ($shippingCostValue <= 0) {
                            $this->logError('KD devivery: bad response from BB server. KD disabled.');
                            $allCourierShipping = false;
                        }
                    } else {
                        $courierPrice = 200;
                        if ($calcOptions['kd_delivery_zone'] == 1) {
                            $courierPrice = 150;
                        }
                        $shippingCostValue = $deliveryPriceValue + $courierPrice;
                    }
                }
            }
        }

        $costExist = $deliveryPriceValue >= 0 && $shipping_pvz;
        if (!$costExist) {
            $deliveryPriceValue = 0;
        }

        $shippingMethode = $this->customer->isLogged() ? 'shipping_method' : 'guest_shipping';

        $validateUrl = '$.ajax({url:"index.php?route=checkout/' . $shippingMethode
            . '/validate",type:"post",data:$("#shipping-address input[type=text], #shipping-address select"),dataType:"json",success:function(json){$.ajax({url:"index.php?route=checkout/shipping_method",dataType:"html",success:function(html){$("#shipping-method .checkout-content").html(html); var selector = "input[value=\'"+sel_sm+"\']"; $(selector).prop("checked", true); }});}});';

        $sp3c13a1 = !$allFreeShipping;

        $codePrefix = 'bb';
        $text_pickup = '';
        if ($sp3c13a1) {
            $codePrefix = 'fake';
            $text_pickup = $this->language->get('text_pickup_denied');
            $costExist = false;
            $deliveryPriceValue = 0;
        }

        $mapPointsLink = '';
        if ($select_pvz == 0 || $select_pvz == 2) {
            $getPvzMapPointsUrl = '\'' . $this->url->link('checkout/bb/getPvzMapPoints', '', 'SSL') . '\'';
            $mapPointsLink = '<a id="bb-pvz-link" ' . $this->language->get('text_pvz_select_style')
                . ' href="#" onclick="bb_select_pvz(' . $getPvzMapPointsUrl . ',bb_callback); return false"> ' . $text_select_pvz
                . '</a>';
        }

        $bb_html .= '<script type="text/javascript">function bb_callback(pvz_id){$.get("index.php?route=checkout/bb/select_pvz&pvz_id="+pvz_id,function(data){if(data.skip)return;$("#checkout_address_main_city").val(data.city);$("#checkout_address_main_zone_id").val(data.zone_id);$("#checkout_address_address_1").val(data.addr1);if($("input[name=\'shipping_address_same\']").is(":checked")){$("#checkout_customer_main_city").val(data.city);$("#checkout_customer_main_zone_id").val(data.zone_id);$("#checkout_customer_address_1").val(data.addr1);};$("#shipping_address_city").val(data.city);$("#shipping_address_zone_id").val(data.zone_id);$("#shipping_address_address_1").val(data.addr1);if($("input[name=\'address_same\']").is(":checked")){$("#payment_address_city").val(data.city);$("#payment_address_zone_id").val(data.zone_id);$("#payment_address_address_1").val(data.addr1);};$("#shipping-address").find("input[name=city]").val(data.city);$("#shipping-address").find("select[name=zone_id]").val(data.zone_id);$("#shipping-address").find("input[name=address_1]").val(data.addr1);var sel_sm=$("input[name=shipping_method]:checked").val();if(typeof reloadAll=="function"){reloadAll()}else if(typeof simplecheckout_reload=="function")simplecheckout_reload("bb");else{'
            . $validateUrl . '}},function(){},"json");}</script>' . $text_pickup . $mapPointsLink;

        $foreign_currency = $this->getSettingsValue('foreign_currency');
        $currencyCode = isset($this->session->data['bb_foreign_shop']) && $this->session->data['bb_foreign_shop'] ? $foreign_currency : 'RUB';

        $deliveryPriceRub = $this->tax->calculate($deliveryPriceValue, $this->getSettingsValue('tax_class_id'), $this->config->get('config_tax'));
        $deliveryPrice = $this->currency->convert($deliveryPriceRub, $currencyCode, $config_currency);

        $deliveryCost = $deliveryPrice;
        if (isset($calcOptions['round']) && $calcOptions['round'] != '') {
            $precision = -(int)$calcOptions['round'];
            $deliveryCost = round($deliveryPrice, $precision);
        }

        $text = $costExist ? $this->currency->format($deliveryCost, $config_currency, 1.0) : '';
        $text_pickup_description = '';

        $show_delivery_period = $this->getConfigValue('show_delivery_period', false);

        if ($show_delivery_period && $this->delivery_period != -1 && $this->delivery_period != false) {
            $processing_days = (int)$this->getConfigValue('processing_days', 0) + (int)$this->delivery_period;
            $workDaysCases = explode(';', $this->language->get('text_work_days'));
            $text_pickup_description = sprintf($this->language->get('text_pickup_delivery_period'), $this->daysCase($processing_days, $workDaysCases));
        }

        if ($codePrefix == 'bb') {
            $quote['pickup'] = [
                'code'         => $codePrefix . '.pickup',
                'img'          => $pickupIcon,
                'bb_html'      => $bb_html,
                'description'  => $vqmod_simple_edostExist && !$simpleExist ? '' : $bb_html,
                'title'        => $this->language->get('text_pickup_description') . $text_pickup_description,
                'cost'         => $deliveryCost / $this->currency->getValue(),
                'tax_class_id' => $this->config->get('bb_tax_class_id'),
                'text'         => $text,
            ];
        }

        if ($allCourierShipping) {
            $shippingCostRub = $this->tax->calculate($shippingCostValue, $this->getSettingsValue('tax_class_id'), $this->config->get('config_tax'));
            $shippingPrice = $this->currency->convert($shippingCostRub, $currencyCode, $config_currency);
            $shippingCost = $shippingPrice;

            if (isset($calcOptions['round']) && $calcOptions['round'] != '') {
                $precision = -(int)$calcOptions['round'];
                $shippingCost = round($shippingPrice, $precision);
            }

            $text_kd_description = '';

            if ($show_delivery_period && $this->kd_delivery_period != -1 && $this->kd_delivery_period != false) {
                $processing_days = (int)$this->getConfigValue('processing_days', 0) + (int)$this->kd_delivery_period;
                $workDaysCases = explode(';', $this->language->get('text_work_days'));
                $text_kd_description = sprintf($this->language->get('text_pickup_delivery_period'), $this->daysCase($processing_days, $workDaysCases));
            }

            $shippingCostText = $this->currency->format($shippingCost, $config_currency, 1.0);

            $quote['kd'] = [
                'code'         => 'bb.kd',
                'img'          => $kdIcon,
                'title'        => $this->language->get('text_kd_description') . $text_kd_description,
                'cost'         => $shippingCost / $this->currency->getValue(),
                'tax_class_id' => $this->config->get('bb_tax_class_id'),
                'text'         => $shippingCostText,
            ];
        }
        return [
            'code'       => 'bb',
            'title'      => $this->language->get('text_title'),
            'quote'      => $quote,
            'sort_order' => $this->config->get('bb_sort_order'),
            'error'      => $error,
        ];
    }

    private function daysCase($days, $declensions) {
        $keys = [2, 0, 1, 1, 1, 2];
        return $days . ' ' . $declensions[$days % 100 > 4 && $days % 100 < 20
                ? 2
                : $keys[min(
                    $days % 10, 5
                )]];
    }

    private function getCartVolume() {
        $package_size_calc_type = $this->getConfigValue('package_size_calc_type', 0);

        if ($package_size_calc_type == 1) {
            return [
                'depth'  => $this->getConfigValue('package_depth', 0),
                'width'  => $this->getConfigValue('package_width', 0),
                'height' => $this->getConfigValue('package_height', 0),
            ];
        }

        $data = null;
        $cartProducts = $this->cart->getProducts();
        $productIndex = 0;

        foreach ($cartProducts as $product) {
            $length = $this->length->convert($product['length'], $product['length_class_id'], 1);
            $width = $this->length->convert($product['width'], $product['length_class_id'], 1);
            $height = $this->length->convert($product['height'], $product['length_class_id'], 1);

            if ($product['quantity'] > 399) {
                $data = $this->getPalette($length, $width, $height, $product['quantity']);
            } else {
                for ($productCounter = 0; $productCounter < $product['quantity']; $productCounter++) {
                    $data[$productIndex]['X'] = $length;
                    $data[$productIndex]['Y'] = $width;
                    $data[$productIndex]['Z'] = $height;

                    $productIndex++;
                }
            }
        }

        return $this->getVolume($data);
    }

    private function getPalette($length, $width, $height, $quantity) {
        $data = null;

        $maxQuantity = 400; // максимальное количество

        $sizes = [
            'length' => $length,
            'width' => $width,
            'height' => $height,
        ];

        $sortedSizes = $sizes;

        arsort($sortedSizes);

        $size1 = (float)array_shift($sortedSizes); // максимальный размер
        $size2 = (float)array_shift($sortedSizes); // средний размер
        $size3 = (float)array_shift($sortedSizes); // минимальный размер

        $quantity2 = $size1 / $size2; // количество средних, которое укладывается в максимальном размере
        $quantity3 = $size1 / $size3; // количество минимальных, которое укладывается в максимальном размере

        $delta2 = $quantity2 - floor($quantity2); // точность совпадения
        $delta3 = $quantity3 - floor($quantity3); // точность совпадения

        $dim2 = $size2; // второй размер средний
        $dim3 = $size3; // третий размер минимальный
        $delta = $delta2; // разница со средним

        if ($delta3 < $delta2) {
            $dim2 = $size3; // второй размер минимальный
            $dim3 = $size2; // третий размер средний
            $delta = $delta3; // разница с минимальным
        }

        $quantity2 = floor($size1 / $dim2) - 1; // количество товаров в паллете по Y
        $quantity3 = 2; // количество товаров в паллете по Z
        $length2 = $dim2; // длина по Y
        $length3 = $dim3; // длина по Z
        $paletteQuantity = 0; // количество паллет
        $allQuantity = $maxQuantity + 1; // общее количество товаров

        while ($allQuantity > $maxQuantity) {
            $quantity2++;

            $length2 = $quantity2 * $dim2;

            if ($length2 > $size1) {
                $quantity3++;
                $quantity2 = floor($quantity2 / 2) + 1;
            }

            $paletteQuantity = floor($quantity / $quantity2 / $quantity3);
            $allQuantity = $quantity + $paletteQuantity - $paletteQuantity * $quantity2 * $quantity3;
        }

        $productIndex = 0;

        while ($productIndex < $paletteQuantity) {
            $data[$productIndex]['X'] = $size1;
            $data[$productIndex]['Y'] = $dim2 * $quantity2;
            $data[$productIndex]['Z'] = $dim3 * $quantity3;

            $productIndex++;
        }

        while ($productIndex < $allQuantity) {
            $data[$productIndex]['X'] = $length;
            $data[$productIndex]['Y'] = $width;
            $data[$productIndex]['Z'] = $height;

            $productIndex++;
        }

        return $data;
    }

    private function getVolume($data) {
        $countData = count($data);

        for ($counter1 = 1; $counter1 < $countData; $counter1++) {
            for ($counter0 = $counter1 - 1; $counter0 < $countData; $counter0++) {
                for ($i = 0; $i <= 1; $i++) {
                    if ($data[$counter0]['X'] < $data[$counter0]['Y']) {
                        $tmpSize = $data[$counter0]['X'];
                        $data[$counter0]['X'] = $data[$counter0]['Y'];
                        $data[$counter0]['Y'] = $tmpSize;
                    }
                    if ($i == 0 && $data[$counter0]['Y'] < $data[$counter0]['Z']) {
                        $tmpSize = $data[$counter0]['Y'];
                        $data[$counter0]['Y'] = $data[$counter0]['Z'];
                        $data[$counter0]['Z'] = $tmpSize;
                    }
                }

                $data[$counter0]['Sum'] = $data[$counter0]['X'] + $data[$counter0]['Y'] + $data[$counter0]['Z'];
            }

            for ($counter0 = $counter1; $counter0 < $countData; $counter0++) {
                for ($i = $counter1; $i < $countData; $i++) {
                    if ($data[$i - 1]['Sum'] > $data[$i]['Sum']) {
                        $tmpData = $data[$i];
                        $data[$i] = $data[$i - 1];
                        $data[$i - 1] = $tmpData;
                    }
                }
            }

            if ($data[$counter1 - 1]['X'] > $data[$counter1]['X']) {
                $data[$counter1]['X'] = $data[$counter1 - 1]['X'];
            }

            if ($data[$counter1 - 1]['Y'] > $data[$counter1]['Y']) {
                $data[$counter1]['Y'] = $data[$counter1 - 1]['Y'];
            }

            $data[$counter1]['Z'] = $data[$counter1]['Z'] + $data[$counter1 - 1]['Z'];
            $data[$counter1]['Sum'] = $data[$counter1]['X'] + $data[$counter1]['Y'] + $data[$counter1]['Z'];
        }

        return [
            'depth'  => Round($data[$countData - 1]['X'], 2),
            'width'  => Round($data[$countData - 1]['Y'], 2),
            'height' => Round($data[$countData - 1]['Z'], 2),
        ];
    }
}
<?php

require_once dirname(__FILE__) . '/../../../catalog/model/payment/yoomoney/autoload.php';

use YooKassa\Model\NotificationEventType;

class ModelPaymentYoomoneyOauth extends Model
{
    const OAUTH_APP_URL = 'https://yookassa.ru/integration/oauth-cms';
    const MODULE_NAME = 'yoomoney';
    const CMS_NAME = 'opencart';

    private $yoomoneyModel;
    private $patmentKassa;

    /**
     * Формирует параметры, инициирует отправку, получает результат запроса на получение URL
     * для авторизации пользователя в OAuth приложении
     *
     * @return string[] - массив для последующей кодировки в JSON для передачи в JS
     */
    public function getOauthConnectUrl()
    {
        $data = array(
            'state' => $this->getOauthState(),
            'cms' => self::CMS_NAME,
            'host' => $_SERVER['HTTP_HOST']
        );

        $this->log('info', 'Request: ' . json_encode($data));

        $options = array(
            CURLOPT_URL => self::OAUTH_APP_URL . '/authorization',
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        );

        try {
            $response = $this->makeRequest($options);
        } catch (Exception $e) {
            $this->log('error', 'Failed to get OAuth token: ' . $e->getMessage());
            return array('error' => 'Got error while getting OAuth link.');
        }

        $data = json_decode($response, true);

        if (!isset($data['oauth_url'])) {
            $error = empty($data['error']) ? 'OAuth URL not found' : $data['error'];
            $this->log('error', 'Got error while getting OAuth link. Response body: ' . $response);
            return array('error' => $error);
        }

        return array('oauth_url' => $data['oauth_url']);
    }

    /**
     * Формирует параметры, инициирует отправку, получает результат запроса на получение токена,
     * проверяет ответ на запрос, инициирует сохранение токена в БД
     *
     * @return string[] - массив для последующей кодировки в JSON для передачи в JS
     */
    public function getOauthToken()
    {
        $data = array(
            'state' => $this->getOauthState()
        );

        $this->log('info', 'Sending request for OAuth token. Request parameters: ' . json_encode($data));

        $options = array(
            CURLOPT_URL => self::OAUTH_APP_URL . '/get-token',
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        );

        try {
            $response = $this->makeRequest($options);
        } catch (Exception $e) {
            $this->log('error', 'Failed to get OAuth token: ' . $e->getMessage());
            return array('error' => 'Got error while getting OAuth token.');
        }

        $data = json_decode($response, true);

        if (!isset($data['access_token'])) {
            $error = empty($data['error']) ? 'OAuth token not found' : $data['error'];
            $this->log('error', 'Got error while getting OAuth token. Response body: ' . $response);
            return array('error' => $error);
        }

        if (!isset($data['expires_in'])) {
            $error = empty($data['error']) ? 'Expires_in parameter not found' : $data['error'];
            $this->log('error', $error . '. Response body: ' . $response);
            return array('error' => $error);
        }

        $token = $this->getYooMoneyPaymentKassa()->getOauthToken();

        if ($token) {
            $this->log('info', 'Old token found. Trying to revoke.');
            $this->revokeToken($token);
        }

        $this->saveSettings(array(
                'yoomoney_kassa_access_token' => $data['access_token'],
                'yoomoney_kassa_token_expires_in' => $data['expires_in']
        ));

        $this->getYooMoneyPaymentKassa()->setOauthToken($data['access_token']);

        try {
            $this->subscribe();
            $this->saveShopInfo();
        } catch (Exception $e) {
            $this->log('error', $e->getMessage());
            return array('error' => 'Failed to get shop info');
        }

        return array('success' => true);
    }

    /**
     * Формирует параметры, инициирует отправку, получает результат запроса на отзыва токена
     *
     * @param string $token - OAuth токен
     * @return string[]|void
     */
    private function revokeToken($token)
    {
        $data = array(
            'state' => $this->getOauthState(),
            'token' => $token,
            'cms' => self::CMS_NAME
        );

        $options = array(
            CURLOPT_URL => self::OAUTH_APP_URL . '/revoke-token',
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        );

        try {
            $response = $this->makeRequest($options);
        } catch (Exception $e) {
            $this->log('error', 'Failed to get OAuth token: ' . $e->getMessage());
            return array('error' => 'Got error while getting OAuth token.');
        }

        $data = json_decode($response, true);

        if (!isset($data['success'])) {
            $error = empty($data['error']) ? 'Got error while revoking OAuth token' : $data['error'];
            $this->log('error', 'Got error while revoking OAuth token. Response body: ' . $response);
            return array('error' => $error);
        }

        $this->log('info', 'Token revoked successfully');
    }

    /**
     * Выполянет запрос с полученными параметрами
     *
     * @param array $options - массив curl опций
     * @return bool|string
     * @throws Exception
     */
    private function makeRequest($options)
    {
        $optionsConst = array(
            CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1
        );
        $options = $optionsConst + $options;
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status !== 200) {
            throw new Exception(
                'Response status code is not 200. Code: ' . $status . ' Response: ' . $result
            );
        }

        return $result;
    }

    /**
     * Проверяет в БД state и возвращает его, если нету в БД, генерирует его
     *
     * @return string state - уникальный id для запросов в OAuth приложение
     */
    private function getOauthState()
    {
        $state = $this->getYooMoneyPaymentKassa()->getOauthCmsState();

        if (!$state) {
            $state = substr(md5(time()), 0, 12);
            $this->saveSettings(array('yoomoney_kassa_oauth_state' => $state));
        }

        return $state;
    }

    /**
     *
     * @return YooMoneyPaymentKassa object - Объект с настройками модуля
     */
    private function getYooMoneyPaymentKassa()
    {
        if (!$this->patmentKassa) {
            require_once YOOMONEY_MODULE_PATH . '/YooMoneyPaymentMethod.php';

            $this->patmentKassa = $this
                ->getYoomoneyModel()
                ->init($this->config)
                ->getPaymentMethod(YooMoneyPaymentMethod::MODE_KASSA);
        }

        return $this->patmentKassa;
    }

    /**
     * Запись в лог. Использует основную функцию из файла yoomoney.php
     *
     * @param $level
     * @param $message
     * @param $context
     * @return void
     */
    private function log($level, $message, $context = null)
    {
        $this->getYoomoneyModel()->log($level, $message, $context);
    }

    /**
     * Получает инфомацию о магазине в Юkassa и вызывает ф-ю для сохранения ее в БД
     *
     * @return void
     * @throws Exception
     */
    private function saveShopInfo()
    {
        $shopInfo = $this->getClient()->me();

        if (!isset($shopInfo['account_id'], $shopInfo['test'], $shopInfo['fiscalization_enabled'])) {
            throw new \Exception('Failed to save shop info. Response: ' . json_encode($shopInfo));
        }

        $this->saveSettings(array(
            'yoomoney_kassa_shop_id' => $shopInfo['account_id'],
            'yoomoney_kassa_password' => '',
        ));
    }

    /**
     * @return ModelPaymentYoomoney object - Объкт класса admin/model/payment/yoomoney.php
     */
    private function getYoomoneyModel()
    {
        if (!$this->yoomoneyModel) {
            $this->load->model('payment/yoomoney');
            $this->yoomoneyModel = $this->model_payment_yoomoney;
        }
        return $this->yoomoneyModel;
    }

    /**
     * Проверяет существующие подписки, удаляет некорректные и создает новые
     *
     * @return void
     * @throws Exception
     */
    private function subscribe()
    {
        $needWebHookList = array(
            NotificationEventType::PAYMENT_SUCCEEDED,
            NotificationEventType::PAYMENT_CANCELED,
            NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE,
            NotificationEventType::REFUND_SUCCEEDED,
        );

        $url = new Url(HTTP_CATALOG);
        $webHookUrl = str_replace(
            'http://',
            'https://',
            $url->link('payment/' . self::MODULE_NAME . '/capture', '', true)
        );

        $currentWebHookList = $this->getClient()->getWebhooks()->getItems();

        foreach ($needWebHookList as $event) {
            $hookIsSet = false;
            foreach ($currentWebHookList as $webHook) {
                if ($webHook->getEvent() === $event) {
                    if ($webHook->getUrl() === $webHookUrl) {
                        $hookIsSet = true;
                        continue;
                    }

                    $this->getClient()->removeWebhook($webHook->getId());
                }
            }
            if (!$hookIsSet) {
                $this->getClient()->addWebhook(array('event' => $event, 'url' => $webHookUrl));
            }
        }
    }

    /**
     * Производит запись в БД данных с предварительным удалением
     *
     * @param array $data - массив вида {key} => {value}, где key и value - соответсвующие поля в таблице oc_setting
     * @return void
     */
    private function saveSettings($data)
    {
        foreach ($data as $key => $value) {
            $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = '" . $key . "' AND `group` = '" . $this->db->escape(self::MODULE_NAME) . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `group` = '" . $this->db->escape(self::MODULE_NAME) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
        }
    }

    /**
     * @return \YooKassa\Client
     */
    private function getClient()
    {
        return $this->getYooMoneyPaymentKassa()->getYookassaClient($this->getYoomoneyModel());
    }
}
<?php

use YooKassa\Model\PaymentMethodType;

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'yoomoney.php';
require_once DIR_APPLICATION.'/model/payment/yoomoney/YooMoneySbbolException.php';


class ControllerPaymentYoomoneyB2BSberbank extends ControllerPaymentYoomoney
{
    const MODE_KASSA = 1;

    /**
     * @var ModelPaymentYoomoneyB2BSberbank Модель работы с платежами
     */
    private $_model;

    /**
     * @var array Массив с информацией о текущем заказе
     */
    private $_orderInfo;

    /**
     * Экшен отображения страницы выбора способа оплаты
     */
    protected function index()
    {
        $this->payment($this->getOrderInfo());
    }

    /**
     * Экшен создания платежа на стороне ЮKassa
     *
     * После создания осуществляет редирект на страницу оплаты на стороне кассы. Доступен только для способа оплаты
     * через кассу, для платежей в кошелёк и с помощью платёжки просто редиректит на страницу корзины.
     */
    public function create()
    {
        $cart      = $this->cart;
        $session   = $cart->session;
        $coupon    = empty($session->data['coupon']) ? null : $session->data['coupon'];
        $orderInfo = $this->getOrderInfo('order_id', false);
        if ($orderInfo === null) {
            $this->jsonError('Корзина пуста');
        }

        $orderInfo['coupon'] = $coupon;

        $this->language->load('payment/yoomoney');

        $this->getModel()->log('info', 'Создание платежа для заказа №'.$orderInfo['order_id']);
        /** @var YooMoneyPaymentKassa $paymentMethod */
        $paymentMethod = $this->getModel()->getPaymentMethod(self::MODE_KASSA);
        if (!$paymentMethod->isModeKassa()) {
            $this->jsonError('Ошибка настройки модуля');
        }
        if (!isset($_GET['paymentType'])) {
            $this->jsonError('Не указан способ оплаты');
        }
        $paymentType = $_GET['paymentType'];
        if ($paymentType != PaymentMethodType::B2B_SBERBANK) {
            $this->jsonError('Указан неверный способ оплаты');
        }

        try {
            $payment = $this->getModel()->createPayment($paymentMethod, $orderInfo);
        } catch (YooMoneySbbolException $e) {
            $this->jsonError($this->language->get('b2b_tax_rates_error'));
        }
        if ($payment === null) {
            $this->jsonError('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты');
        }
        $result = array(
            'success'  => true,
            'redirect' => $this->url->link('payment/yoomoney/confirm', 'order_id='.$orderInfo['order_id'], 'SSL'),
        );
        /** @var \YooKassa\Model\Confirmation\ConfirmationRedirect $confirmation */
        $confirmation = $payment->getConfirmation();
        if ($confirmation === null) {
            $this->getModel()->log('warning', 'Confirmation in created payment equals null');
        } elseif ($confirmation->getType() === \YooKassa\Model\ConfirmationType::REDIRECT) {
            $result['redirect'] = $confirmation->getConfirmationUrl();
        }
        if ($paymentMethod->getCreateOrderBeforeRedirect()) {
            $this->getModel()->confirmOrder($paymentMethod, $orderInfo['order_id']);
        }
        if ($paymentMethod->getClearCartBeforeRedirect()) {
            $this->cart->clear();
        }

        echo json_encode($result);
        exit();
    }

    /**
     * Метод отображения способов оплаты пользователю
     *
     * @param $orderInfo
     * @param bool $child
     */
    private function payment($orderInfo, $child = false)
    {
        $this->language->load('payment/yoomoney');
        $paymentMethod = $this->getModel()->getPaymentMethod($this->config->get('yoomoney_mode'));

        if (isset($orderInfo['email'])) {
            $this->data['email'] = $orderInfo['email'];
        }
        if (isset($orderInfo['telephone'])) {
            $this->data['phone'] = $orderInfo['telephone'];
        }

        $this->data['cmsname']        = ($child) ? 'opencart-extracall' : 'opencart';
        $this->data['sum']            = $this->currency->format(
            $orderInfo['total'], $orderInfo['currency_code'], $orderInfo['currency_value'], false
        );
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['order_id']       = $orderInfo['order_id'];
        $this->data['paymentMethod']  = $paymentMethod;
        $this->data['lang']           = $this->language;

        $this->assignKassaB2bSberbank($paymentMethod);

        if (file_exists(DIR_TEMPLATE.$this->config->get('wconfig_template').'/template/payment/yoomoney.tpl')) {
            $this->template = $this->config->get('config_template').'/template/payment/yoomoney.tpl';
        } else {
            $this->template = 'default/template/payment/yoomoney.tpl';
        }
        if ($child) {
            $this->children = array(
                'common/column_left',
                'common/column_right',
                'common/footer',
                'common/header',
            );
        }

        $this->response->addHeader('Content-Type: text/html; charset=utf-8');
        $this->response->setOutput($this->render());
    }

    public function assignKassaB2bSberbank(YooMoneyPaymentKassa $paymentMethod)
    {
        $this->data['tpl'] = 'kassab2bsberbank';

        $this->data['allow_methods'] = array();

        $this->data['validate_url'] = $this->url->link('payment/yoomoneyb2bsberbank/create', '', 'SSL');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['imageurl'] = $this->config->get('config_ssl').'image/';
        } else {
            $this->data['imageurl'] = $this->config->get('config_url').'image/';
        }

        $this->data['method_label'] = $this->language->get('yoomoney_b2b_sberbank');
    }


    /**
     * Возвращает модель работы с платежами, если модель ещё не инстацирована, создаёт её
     * @return ModelPaymentYoomoneyB2BSberbank Модель работы с платежами
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $this->load->model('payment/yoomoneyb2bsberbank');
            $this->_model = $this->model_payment_yoomoneyb2bsberbank;
        }

        return $this->_model;
    }
}

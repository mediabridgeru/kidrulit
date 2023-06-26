<?php
// Heading
$_['heading_title'] = 'YooMoney';

// Text
$_['text_yoomoney'] = '<a onclick="window.open(\'https://yoomoney.ru\');"><img src="view/image/payment/yoomoney.png" alt="YooMoney" title="YooMoney" /></a>';

$_['text_success']     = 'Settings saved';
$_['text_need_update'] = "Your module version is outdated. You can <a target='_blank' href='https://git.yoomoney.ru/projects/CMS/repos/cms-opencart15'>download and install</a> a new one (%s)";

$_['yoomoney_license'] = '<p>By using this program in any way, you fully and unconditionally accept the terms of the license agreement as posted at <a href="https://yoomoney.ru/doc.xml?id=527132">https://yoomoney.ru/doc.xml?id=527132</a>(hereinafter referred to "license agreement"). If you do not accept any part of the terms of the license agreement, you are forbidden to use the program for any purpose.</p>';

$_['error_permission']                      = 'You don\'t have the permission to use this module!';
$_['error_empty_payment']                   = 'Please select at least one option from the list';
$_['error_payment_not_found']               = 'Payment not found!';
$_['error_yoomoney_kassa_shop_id']          = 'Specify shopId';
$_['error_yoomoney_kassa_password']         = 'Specify secret key';
$_['error_invalid_shop_password']           = 'Invalid format for the secret key';
$_['error_install_widget']                  = 'Чтобы покупатели могли заплатить вам через Apple Pay, <a href="https://yookassa.ru/docs/merchant.ru.yandex.kassa">скачайте файл apple-developer-merchantid-domain-association</a> и добавьте его в папку ./well-known на вашем сайте. Если не знаете, как это сделать, обратитесь к администратору сайта или в поддержку хостинга. Не забудьте также подключить оплату через Apple Pay <a href="https://yookassa.ru/my/payment-methods/settings#applePay">в личном кабинете ЮKassa</a>. <a href="https://yookassa.ru/developers/payment-forms/widget#apple-pay-configuration">Почитать о подключении Apple Pay в документации ЮKassa</a>';

$_['module_settings_header']                = "Settings";
$_['module_license']                        = "By using the module, you accept its <a href='https://yoomoney.ru/doc.xml?id=527132' target='_blank'>terms of use</a>.";
$_['module_version']                        = "Module version ";
$_['kassa_tab_label']                       = "YooKassa";
$_['kassa_header_description']              = "To start operating the module, connect your store to <a target=\"_blank\" href=\"https://yookassa.ru/en/\">YooKassa</a>.";
$_['kassa_test_mode_info']                  = 'You have enabled the test mode. Check the payment making process. <a href="https://yookassa.ru/docs/support/payments/onboarding/integration" target="_blank">Learn more</a>';
$_['kassa_enable']                          = "Enable payment acceptance via YooKassa";
$_['check_url_help']                        = "Copy this link to the Check URL and Aviso URL fields in the settings section of your YooKassa\'s Merchant Profile";
$_['kassa_account_header']                  = "Parameters from YooKassa\'s Merchant Profile";
$_['kassa_shop_id_label']                   = 'shopId';
$_['kassa_shop_id_help']                    = 'Copy your shopId from your YooKassa\'s Merchant Profile';
$_['kassa_password_label']                  = 'Secret key';
$_['kassa_password_help']                   = 'Issue and activate the secret key under your YooKassa\'s Merchant Profile. Then copy it here.';
$_['kassa_account_help']                    = "Shop ID, scid, ShopPassword can be found in the <a href='https://yookassa.ru/my' target='_blank'>Merchant Profile</a> after the onboarding process.";
$_['kassa_payment_config_header']           = 'Check the preferable scenario of selecting the payment method';
$_['kassa_payment_mode_label']              = 'Select payment method';
$_['kassa_payment_mode_smart_pay']          = 'On YooKassa\'s site';
$_['kassa_payment_mode_shop_pay']           = 'On the store\'s site';
$_['kassa_add_installments_button']         = 'Add the Installments payment method to checkout page';
$_['kassa_add_installments_block_label']    = 'Add the information block about Installments to product descriptions';
$_['kassa_payment_mode_help']               = "<a href='https://yookassa.ru/docs/payment-solution/payment-form/basics' target='_blank'>More about payment scenarios</a>";
$_['kassa_payment_method_label']            = "Check payment methods from the contract";
$_['forwork_money']                         = "";
$_['enable_money']                          = "Enable payment acceptance to the YooMoney Wallet";
$_['redirectUrl_help']                      = "Copy this link to the Redirect URL field at the <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>notifications settings page</a>.";
$_['account_head']                          = "Payment acceptance settings";
$_['wallet']                                = "Wallet number";
$_['password']                              = "Codeword";
$_['account_help']                          = "The codeword should be copied from the <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>notifications settings page</a> at the YooMoney website";
$_['option_wallet']                         = "Select payment method";
$_['kassa_payment_method_default']          = "Payment method by default";
$_['kassa_success_page_label']              = "Successful payment page";
$_['kassa_page_default']                    = "Standard---";
$_['kassa_success_page_description']        = "The customer will see this page once they pay for the order";
$_['kassa_failure_page_label']              = "Failure page";
$_['page_standart']                         = "Standard---";
$_['kassa_failure_page_description']        = "The customer will see this page if something goes wrong: for example, if there's not enough funds on their card";
$_['successMP_label']                       = "Success page for the Payment by Card on Delivery method";
$_['successMP_help']                        = "This page contains delivery information. Specify the terms of the delivery and the payment here";
$_['kassa_page_title_label']                = "Payment service title";
$_['kassa_page_title_help']                 = "This title will be shown to the customer";
$_['kassa_description_title']               = 'Transaction data';
$_['kassa_description_default_placeholder'] = 'Payment for order No. %order_id%';
$_['kassa_description_help']                = 'Full description of the transaction that the user will see during the checkout process. You can find it in your YooKassa Merchant Profile. For example, "Payment for order No. 72". Limitations: no more than 128 symbols.';
$_['kassa_send_receipt_label']              = 'Send data for receipts to YooMoney (54-FZ)';
$_['kassa_all_tax_rate_label']              = 'VAT';
$_['kassa_tax_rate_table_label']            = ' transmit to YooKassa as ';
$_['kassa_default_tax_system_label']        = 'Default tax system';
$_['kassa_default_tax_system_description']  = 'Select the default tax system. This parameter is only required if you have several tax systems, otherwise it is not passed.';
$_['kassa_tax_system_1_label']              = 'General tax system';
$_['kassa_tax_system_2_label']              = 'Simplified (STS, income)';
$_['kassa_tax_system_3_label']              = 'Simplified (STS, income with costs deducted)';
$_['kassa_tax_system_4_label']              = 'Unified tax on imputed income (ENVD)';
$_['kassa_tax_system_5_label']              = 'Unified agricultural tax (ESN)';
$_['kassa_tax_system_6_label']              = 'Patent Based Tax System';
$_['kassa_default_tax_rate_label']          = 'Default rate';
$_['kassa_default_tax_rate_description']    = 'The default rate will be shown in the receipt unless another rate was specified in the product\'s card.';
$_['kassa_tax_rate_label']                  = 'Rate at your store';
$_['kassa_tax_rate_description']            = 'Compare rates';
$_['kassa_tax_rate_site_header']            = 'Rate at your store';
$_['kassa_tax_rate_kassa_header']           = 'Rate for the receipt to the tax service';
$_['kassa_feature_header']                  = "Additional settings for administrator";
$_['kassa_debug_label']                     = "Record of debugging information";
$_['kassa_view_logs']                       = 'View logs';
$_['disable']                               = "Disable";
$_['enable']                                = "Enable";
$_['kassa_second_receipt_header']           = "Second Receipt";
$_['kassa_second_receipt_description']      = "Two checks need to be formed if the customer makes an advance payment and then receives the goods or services. The first check — when the money comes to your account, the second — when shipping goods or performing services.<br> <a href='https://yookassa.ru/developers/54fz/payments#settlement-receipt' target='_blank'>Read about the second check in YooKassa</a>";
$_['kassa_second_receipt_enable_label']     = "Generate a second receipt when the order changes to the status";
$_['kassa_second_receipt_help_info']        = "If there are items in the order with the signs «Full prepayment» — the second check will be sent automatically when the order enters the selected status.";
$_['kassa_second_receipt_history_info']     = "The second receipt was sent. Amount %s rubles.";
$_['kassa_debug_description']               = "Only required if YooKassa\'s specialists ask for it";
$_['kassa_before_redirect_label']           = 'When the user proceeds to checkout';
$_['kassa_create_order_label']              = 'Create an unpaid order in the dashboard';
$_['kassa_clear_cart_label']                = 'Delete items from the cart';
$_['kassa_order_status_label']              = "Order status after the payment";
$_['kassa_ordering_label']                  = "Sorting order";
$_['kassa_geo_zone_label']                  = "Area of display";
$_['kassa_all_zones']                       = 'All areas';
$_['kassa_notification_url_label']          = 'Address for notifications';
$_['kassa_notification_url_description']    = 'Only required if YooKassa\'s specialists ask for it';
$_['kassa_page_title_default']              = 'YooKassa (bank cards, e-money, etc.)';

$_['kassa_currency']                     = 'The payment currency in the YooKassa';
$_['kassa_currency_convert']             = 'Convert an amount from the store\'s current currency';
$_['kassa_currency_help']                = 'Currency must match in the YooKassa and in the store';
$_['kassa_currency_convert_help']        = 'A value from the store\'s currency list is used. If the currency is not in the list – the exchange rate of the Central Bank of the Russian Federation.';

$_['wallet_tab_label']                = 'YooMoney';
$_['wallet_header_description']       = '';
$_['wallet_enable']                   = 'Enable payment acceptance to the YooMoney Wallet';
$_['wallet_redirect_url_description'] = "Copy this link to the Redirect URL field at the <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>notifications settings page</a>.";
$_['wallet_account_head']             = 'Payment acceptance settings';
$_['wallet_number_label']             = 'Wallet number';
$_['wallet_password_label']           = 'Codeword';
$_['wallet_account_description']      = "The codeword should be copied from the <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>notifications settings page</a> at the YooMoney website";
$_['wallet_option_label']             = 'Payment methods';
$_['wallet_feature_header']           = 'Additional settings for administrator';
$_['wallet_debug_label']              = 'Record of debugging information';
$_['wallet_debug_description']        = "Only required if YooKassa\'s specialists ask for it";
$_['wallet_before_redirect_label']    = 'When the user proceeds to checkout';
$_['wallet_create_order_label']       = 'Create an unpaid order in the dashboard';
$_['wallet_clear_cart_label']         = 'Delete items from the cart';
$_['wallet_order_status_label']       = "Order status after the payment";
$_['wallet_ordering_label']           = "Sorting order";
$_['wallet_geo_zone_label']           = "Area of display";
$_['wallet_all_zones']                = 'All areas';

$_['tab_updater']                             = 'Updates';
$_['updater_header']                          = 'Module updates';
$_['updater_enable']                          = 'Enable module updates';
$_['updater_error_text_restore']              = 'Unable to restore the data from the backup. More about the error in the <a href="%s">module\'s logs</a>';
$_['updater_error_text_remove']               = 'Unable to delete backup %s. More about the error in the <a href="%s">module\'s logs</a>';
$_['updater_restore_success_text']            = 'Backup %s successfully deleted';
$_['updater_check_version_flash_message']     = 'Module version %s successfully downloaded and installed';
$_['updater_error_text_unpack_failed']        = 'Unable to extract archive %s. More about the error in <a href="%s">module\'s logs</a>';
$_['updater_error_text_create_backup_failed'] = 'Unable to create a backup copy of the installed module version. More about the error in <a href="%s">module\'s logs</a>';
$_['updater_error_text_load_failed']          = 'Unable to load the archive, please try again. More about the error in <a href="%s">module\'s logs</a>';
$_['updater_log_text_load_failed']            = 'Unable to load the archive with the update';

$_['order_captured_text']       = 'Payment for order No. %s confirmed';
$_['payments_list_title']       = 'List of payments';
$_['payments_list_breadcrumbs'] = 'List of payment methods available via the YooMoney module';

$_['text_repay'] = 'Pay';
$_['text_order'] = 'Order';
$_['text_comment'] = 'Comment';

$_['text_method_yoomoney'] = 'YooMoney';
$_['text_method_bank_card']    = 'Debit or credit cards—Visa, Mastercard, Maestro, MIR';
$_['text_method_cash']         = "Cash";
$_['text_method_mobile']       = 'Direct carrier billing—Beeline, MegaFon, MTS, Tele2';
$_['text_method_webmoney']     = 'Webmoney';
$_['text_method_alfabank']     = 'Alfa-Click';
$_['text_method_sberbank']     = 'SberPay';
$_['text_method_ma']           = 'MasterPass';
$_['text_method_pb']           = 'Promsvyazbank';
$_['text_method_qiwi']         = 'QIWI Wallet';
$_['text_method_qp']           = 'Deferred payment (QPPI.ru)';
$_['text_method_mp']           = 'Mobile payment kiosk';
$_['text_method_installments'] = 'Installments';
$_['text_method_tinkoff_bank'] = 'Tinkoff online banking';
$_['text_method_widget']       = 'Payment widget from YooKassa (cards, Apple Pay and Google Play)';
$_['bank_cards_title']         = 'Bank cards';
$_['cash_title']               = 'Cash via payment kiosks';
$_['mobile_balance_title']     = 'Direct carrier billing';

$_['text_vat_none'] = 'Without VAT';
$_['text_vat_10']   = 'Applicable rate 10/110';
$_['text_vat_20']   = 'Applicable rate 20/120';

$_['kassa_hold_setting_label']        = 'Deferred payment';
$_['kassa_hold_setting_description']  = 'If the option is enabled, payments from cards are carried out in 2 stages: the client\'s amount is frozen, and you need to manually confirm its withdrawal through the admin panel.';
$_['kassa_hold_order_statuses_label'] = 'Which status should be assigned to the order if it\'s:';
$_['kassa_hold_order_status_label']   = 'awaiting confirmation';
$_['kassa_hold_order_status_help']    = 'the order status changes to this once the notification from YooMoney is received, until store\'s operator confirms or cancels the payment';
$_['kassa_cancel_order_status_label'] = 'canceled';
$_['kassa_cancel_order_status_help']  = 'the order status changes to this after the payment is canceled';
$_['kassa_hold_capture_form_link']    = 'Подтверждение';

$_['captures_title']           = 'Подтверждение платежа';
$_['captures_new']             = 'Подтверждение платежа';
$_['captures_expires_date']    = 'Подтвердить до';
$_['captures_payment_data']    = 'Данные платежа';
$_['captures_payment_id']      = 'Номер транзакции в ЮKassa';
$_['captures_order_id']        = 'Номер заказа';
$_['captures_payment_method']  = 'Способ оплаты';
$_['captures_payment_sum']     = 'Сумма платежа';
$_['captures_capture_data']    = '';
$_['captures_capture_sum']     = 'Сумма подтверждения';
$_['captures_capture_create']  = 'Подтвердить платеж';
$_['captures_capture_cancel']  = 'Отменить платеж';
$_['captures_captured']        = 'Платеж подтвержден';
$_['captures_capture_success'] = 'Вы подтвердили платёж в ЮKassa.';
$_['captures_capture_fail']    = 'Платёж не подтвердился. Попробуйте ещё раз.';
$_['captures_cancel_success']  = 'Вы отменили платёж в ЮKassa. Деньги вернутся клиенту.';
$_['captures_cancel_fail']     = 'Платёж не отменился. Попробуйте ещё раз.';

$_['b2b_sberbank_label']             = 'Enable payments via Sberbank Business Online';
$_['b2b_sberbank_on_label']          = 'If you enable this option, you will be able to accept online payments from legal entities. Learn more at the <a href="https://yookassa.ru/en/">YooKassa website</a>.';
$_['b2b_sberbank_template_label']    = 'Template for payment details';
$_['b2b_sberbank_vat_default_label'] = 'Default VAT rate';
$_['b2b_sberbank_template_help']     = 'These payment details will be shown in the payment order.';
$_['b2b_sberbank_vat_default_help']  = 'This rate will be sent to Sberbank Business Online if there\'s no other rate indicated in the payment description.';
$_['b2b_sberbank_vat_label']         = 'Compare the VAT rates in your store with the rates for Sberbank Business Online';
$_['b2b_sberbank_vat_cms_label']     = 'VAT rate at your store';
$_['b2b_sberbank_vat_sbbol_label']   = 'VAT rate for Sberbank Business Online';
$_['b2b_tax_rate_untaxed_label']     = 'Without VAT';
$_['b2b_tax_rate_7_label']           = '7%';
$_['b2b_tax_rate_10_label']          = '10%';
$_['b2b_tax_rate_18_label']          = '18%';
$_['b2b_sberbank_tax_message']       = 'There is a restriction for payments via Sberbank Business Online: one receipt can only contain products with the same VAT rate. If the client wants to pay for products with different VAT rates at the same time, we will show him the message explaining that it\'s not possible.';

$_['nps_text'] = '';

$_['kassa_default_payment_mode_label']    = 'Method of calculation';
$_['kassa_default_payment_subject_label'] = 'Subject of calculation';
$_['ffd_help_message']                    = 'The payment method and payment subject attributes are taken from the payment_mode and payment_subject product attributes. Their values can be specified separately in the product card if necessary. <a href="https://yookassa.ru/developers/54fz/basics#ffd-1-05">Learn more.</a><br>Default values will be applied to products where the values of these attributes aren\'t specified:';

$_['kassa_auth_connect_title']     = 'Link your website on Opencart to the YooMoney Merchant Profile';
$_['kassa_auth_connect_error']     = 'Something went wrong. Refresh the page and try again.';
$_['kassa_auth_connect_btn_title'] = 'Connect your store';
$_['kassa_auth_change_btn_title']  = 'Change store';
$_['kassa_auth_test_shop']         = 'Test store';
$_['kassa_auth_real_shop']         = 'Real store';
$_['kassa_auth_help']              = '<b>Where to find the ShopID and secret key</b><br>The sign-in data will be automatically loaded here from the Merchant Profile. Click <b>Change store</b>:<br>&mdash;&nbsp;sign in to YooMoney in the pop-up window,<br>&mdash;&nbsp;allow Opencart to access your data';
$_['kassa_auth_switch_mode']       = '<b>To switch from the test store to the real store, click "Switch store"</b><br/>In the pop-up window, sign in to your account, give YooMoney access, and select the required store.';
$_['kassa_auth_connection_error']  = '<b>Couldn\'t link the website to your Merchant Profile</b><br/>Connect your store to YooMoney again. If it doesn\'t work, contact tech support.';
$_['kassa_auth_connect_to_kassa']  = 'Connect store to YooMoney again';
$_['kassa_auth_enable_54fz_title'] = 'To activate your online sales register, enable sending data for receipts to YooMoney';
$_['kassa_auth_enable_54fz']       = '<b>Important</b>: if you selected not to link the payment to the receipt, then you don\'t need to enable this feature.';

$_['kassa_error_invalid_credentials'] = '<b>Couldn\'t link the website to your Merchant Profile</b><br>Sign in to YooMoney, and the correct data will get autofilled here. If it doesn\'t work, contact tech support.';

$_['kassa_breadcrumbs_heading_title'] = 'YooKassa payment module\'s logs';
$_['kassa_breadcrumbs_logs']          = 'Logs';
$_['kassa_breadcrumbs_extension']     = 'Payment extensions';
$_['kassa_breadcrumbs_home']          = 'Homepage';

$_['log_title']    = 'YooKassa payment module\'s logs';
$_['log_download'] = 'Download the log file';
$_['log_clear']    = 'Clear the log file';
$_['log_empty']    = 'The log file is empty';
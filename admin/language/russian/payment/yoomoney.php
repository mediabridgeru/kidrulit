<?php
// Heading
$_['heading_title'] = 'ЮMoney';

// Text
$_['text_yoomoney'] = '<a onclick="window.open(\'https://yoomoney.ru\');"><img src="view/image/payment/yoomoney.png" alt="ЮMoney" title="ЮMoney" /></a>';

$_['text_success']     = 'Настройки модуля обновлены!';
$_['kassa_all_zones']  = 'Все зоны';
$_['text_need_update'] = "У вас неактуальная версия модуля. Вы можете <a target='_blank' href='https://git.yoomoney.ru/projects/CMS/repos/cms-opencart15'>загрузить и установить</a> новую (%s)";

$_['yoomoney_license'] = '<p>Любое использование Вами программы означает полное и безоговорочное принятие Вами условий лицензионного договора, размещенного по адресу <a href="https://yoomoney.ru/doc.xml?id=527132">https://yoomoney.ru/doc.xml?id=527132</a>(далее – «Лицензионный договор»). Если Вы не принимаете условия Лицензионного договора в полном объёме, Вы не имеете права использовать программу в каких-либо целях.</p>';

$_['error_permission']                      = 'У Вас нет прав для управления этим модулем!';
$_['error_empty_payment']                   = 'Нужно выбрать хотя бы один метод оплаты!';
$_['error_payment_not_found']               = 'Платеж не найден!';
$_['error_yoomoney_kassa_shop_id']          = 'Укажите идентификатор магазина (shopId)';
$_['error_yoomoney_kassa_password']         = 'Укажите секретный ключ (shopPassword)';
$_['error_invalid_shop_password']           = 'Секретный ключ указан в не верном формате';
$_['error_install_widget']                  = 'Чтобы покупатели могли заплатить вам через Apple Pay, <a href="https://yookassa.ru/docs/merchant.ru.yandex.kassa">скачайте файл apple-developer-merchantid-domain-association</a> и добавьте его в папку ./well-known на вашем сайте. Если не знаете, как это сделать, обратитесь к администратору сайта или в поддержку хостинга. Не забудьте также подключить оплату через Apple Pay <a href="https://yookassa.ru/my/payment-methods/settings#applePay">в личном кабинете ЮKassa</a>. <a href="https://yookassa.ru/developers/payment-forms/widget#apple-pay-configuration">Почитать о подключении Apple Pay в документации ЮKassa</a>';

$_['module_settings_header']                = "Настройки";
$_['module_license']                        = "Работая с модулем, вы автоматически соглашаетесь с <a href='https://yoomoney.ru/doc.xml?id=527132' target='_blank'>условиями его использования</a>.";
$_['module_version']                        = "Версия модуля ";
$_['kassa_tab_label']                       = "ЮKassa";
$_['kassa_header_description']              = "Для работы с модулем нужно подключить магазин к <a target=\"_blank\" href=\"https://yookassa.ru/\">ЮKassa</a>.";
$_['kassa_test_mode_info']                  = 'Вы включили тестовый режим приема платежей. Проверьте, как проходит оплата. <a href="https://yookassa.ru/docs/support/payments/onboarding/integration#" target="_blank">Подробнее</a>';
$_['kassa_enable']                          = "Включить приём платежей через ЮKassa";
$_['check_url_help']                        = "Скопируйте эту ссылку в поля Check URL и Aviso URL в настройках личного кабинета ЮKassa";
$_['kassa_account_header']                  = "Параметры из личного кабинета ЮKassa";
$_['kassa_shop_id_label']                   = 'shopId';
$_['kassa_shop_id_help']                    = 'Скопируйте shopId из личного кабинета ЮKassa';
$_['kassa_password_label']                  = 'Секретный ключ';
$_['kassa_password_help']                   = 'Выпустите и активируйте секретный ключ в <a href="https://yookassa.ru/my" target="_blank">личном кабинете ЮKassa</a>. Потом скопируйте его сюда.';
$_['kassa_account_help']                    = "Shop ID, scid, ShopPassword можно посмотреть в <a href='https://yookassa.ru/my' target='_blank'>личном кабинете</a> после подключения ЮKassa.";
$_['kassa_payment_config_header']           = 'Настройка сценария оплаты';
$_['kassa_payment_mode_label']              = 'Выбор способа оплаты';
$_['kassa_payment_mode_smart_pay']          = 'На стороне ЮKassa';
$_['kassa_payment_mode_shop_pay']           = 'На стороне магазина';
$_['kassa_add_installments_button']         = 'Добавить кнопку «Заплатить по частям» на страницу оформления заказа';
$_['kassa_add_installments_block_label']    = 'Добавить блок «Заплатить по частям» в карточки товаров';
$_['kassa_payment_mode_help']               = "<a href='https://yookassa.ru/docs/payment-solution/payment-form/basics' target='_blank'>Подробнее о сценариях оплаты</a>";
$_['kassa_payment_method_label']            = "Отметьте способы оплаты, которые указаны в вашем договоре с ЮMoney";
$_['forwork_money']                         = "";
$_['enable_money']                          = "Включить прием платежей в кошелек ЮMoney";
$_['redirectUrl_help']                      = "Скопируйте эту ссылку в поле Redirect URL на <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>странице настройки уведомлений</a>.";
$_['account_head']                          = "Настройки приема платежей";
$_['wallet']                                = "Номер кошелька";
$_['password']                              = "Секретное слово";
$_['account_help']                          = "Cекретное слово нужно скопировать со <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>странице настройки уведомлений</a> на сайте ЮMoney";
$_['option_wallet']                         = "Способы оплаты";
$_['kassa_payment_method_default']          = "Способ оплаты по умолчанию";
$_['kassa_success_page_label']              = "Страница успеха платежа";
$_['kassa_page_default']                    = "Стандартная---";
$_['kassa_success_page_description']        = "Эту страницу увидит покупатель, когда оплатит заказ";
$_['kassa_failure_page_label']              = "Страница отказа";
$_['page_standart']                         = "Стандартная---";
$_['kassa_failure_page_description']        = "Эту страницу увидит покупатель, если что-то пойдет не так: например, если ему не хватит денег на карте";
$_['successMP_label']                       = "Страница успеха для способа «Оплата картой при доставке»";
$_['successMP_help']                        = "Это страница с информацией о доставке. Укажите на ней, когда привезут товар и как его можно будет оплатить";
$_['kassa_page_title_label']                = "Название платежного сервиса";
$_['kassa_page_title_help']                 = "Это название увидит пользователь";
$_['kassa_description_title']               = "Описание платежа";
$_['kassa_description_default_placeholder'] = "Оплата заказа №%order_id%";
$_['kassa_description_help']                = "Это описание транзакции, которое пользователь увидит при оплате, а вы — в личном кабинете ЮKassa. <br>
Ограничение для описания — 128 символов.";
$_['kassa_send_receipt_label']              = 'Отправлять в ЮKassa данные для чеков (54-ФЗ)';
$_['kassa_all_tax_rate_label']              = 'НДС';
$_['kassa_tax_rate_table_label']            = '';
$_['kassa_default_tax_system_label']        = 'Система налогообложения по умолчанию';
$_['kassa_default_tax_system_description']  = 'Выберите систему налогообложения по умолчанию. Параметр необходим, только если у вас несколько систем налогообложения, в остальных случаях не передается.';
$_['kassa_tax_system_1_label']              = 'Общая система налогообложения';
$_['kassa_tax_system_2_label']              = 'Упрощенная (УСН, доходы)';
$_['kassa_tax_system_3_label']              = 'Упрощенная (УСН, доходы минус расходы)';
$_['kassa_tax_system_4_label']              = 'Единый налог на вмененный доход (ЕНВД)';
$_['kassa_tax_system_5_label']              = 'Единый сельскохозяйственный налог (ЕСН)';
$_['kassa_tax_system_6_label']              = 'Патентная система налогообложения';
$_['kassa_default_tax_rate_label']          = 'Ставка по умолчанию';
$_['kassa_default_tax_rate_description']    = 'Ставка по умолчанию будет в чеке, если в карточке товара не указана другая ставка.';
$_['kassa_tax_rate_label']                  = 'Ставка в вашем магазине';
$_['kassa_tax_rate_description']            = 'Сопоставьте ставки';
$_['kassa_tax_rate_site_header']            = 'Ставка в вашем магазине';
$_['kassa_tax_rate_kassa_header']           = 'Ставка для чека в налоговую';
$_['kassa_feature_header']                  = "Дополнительные настройки для администратора";
$_['kassa_debug_label']                     = "Запись отладочной информации";
$_['kassa_view_logs']                       = 'Просмотр имеющихся логов';
$_['disable']                               = "Отключена";
$_['enable']                                = "Включена";
$_['kassa_second_receipt_header']           = "Второй чек";
$_['kassa_second_receipt_description']      = "Два чека нужно формировать, если покупатель вносит предоплату и потом получает товар или услугу. Первый чек — когда деньги поступают вам на счёт, второй — при отгрузке товаров или выполнении услуг.<br> <a target=\"_blank\" href=\"https://yookassa.ru/developers/54fz/payments#settlement-receipt\">Читать про второй чек в ЮKassa</a>";
$_['kassa_second_receipt_enable_label']     = "Формировать второй чек при переходе заказа в статус";
$_['kassa_second_receipt_help_info']        = "Если в заказе будут позиции с признаками «Полная предоплата» — второй чек отправится автоматически, когда заказ перейдёт в выбранный статус.";
$_['kassa_second_receipt_history_info']     = "Отправлен второй чек. Сумма %s рублей.";
$_['kassa_debug_description']               = "Настройку нужно будет поменять, только если попросят специалисты ЮMoney";
$_['kassa_before_redirect_label']           = 'Когда пользователь переходит к оплате';
$_['kassa_create_order_label']              = 'Создать неоплаченный заказ в панели управления';
$_['kassa_clear_cart_label']                = 'Удалить товары из корзины';
$_['kassa_order_status_label']              = "Статус заказа после оплаты";
$_['kassa_ordering_label']                  = "Порядок сортировки";
$_['kassa_geo_zone_label']                  = "Регион отображения";
$_['kassa_notification_url_label']          = 'Адрес для уведомлений';
$_['kassa_notification_url_description']    = 'Этот адрес понадобится, только если его попросят специалисты ЮKassa';
$_['kassa_page_title_default']              = 'ЮKassa (банковские карты, электронные деньги и другое)';

$_['kassa_currency']                     = 'Валюта платежа в ЮKassa';
$_['kassa_currency_convert']             = 'Конвертировать сумму из текущей валюты магазина';
$_['kassa_currency_help']                = 'Валюты в ЮKassa и в магазине должны совпадать';
$_['kassa_currency_convert_help']        = 'Используется значение из списка валют магазина. Если валюты нет в списке – курс ЦБ РФ.';

$_['wallet_tab_label']                = 'ЮMoney';
$_['wallet_header_description']       = '';
$_['wallet_enable']                   = 'Включить прием платежей в кошелек ЮMoney';
$_['wallet_redirect_url_description'] = "Скопируйте эту ссылку в поле Redirect URL на <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>странице настройки уведомлений</a>.";
$_['wallet_account_head']             = 'Настройки приема платежей';
$_['wallet_number_label']             = 'Номер кошелька';
$_['wallet_password_label']           = 'Секретное слово';
$_['wallet_account_description']      = "Cекретное слово нужно скопировать со <a href='https://yoomoney.ru/transfer/myservices/http-notification' target='_blank'>странице настройки уведомлений</a> на сайте ЮMoney";
$_['wallet_option_label']             = 'Способы оплаты';
$_['wallet_feature_header']           = 'Дополнительные настройки для администратора';
$_['wallet_debug_label']              = 'Запись отладочной информации';
$_['wallet_debug_description']        = "Настройку нужно будет поменять, только если попросят специалисты ЮMoney";
$_['wallet_before_redirect_label']    = 'Когда пользователь переходит к оплате';
$_['wallet_create_order_label']       = 'Создать неоплаченный заказ в панели управления';
$_['wallet_clear_cart_label']         = 'Удалить товары из корзины';
$_['wallet_order_status_label']       = "Статус заказа после оплаты";
$_['wallet_ordering_label']           = "Порядок сортировки";
$_['wallet_geo_zone_label']           = "Регион отображения";
$_['wallet_all_zones']                = 'Все зоны';

$_['tab_updater']                             = 'Обновления';
$_['updater_header']                          = 'Обновление модуля';
$_['updater_enable']                          = 'Включить возможность обновления модуля';
$_['updater_error_text_restore']              = 'Не удалось восстановить данные из резервной копии, подробную информацию о произошедшей ошибке можно найти в <a href="%s">логах модуля</a>';
$_['updater_error_text_remove']               = 'Не удалось удалить резервную копию %s, подробную информацию о произошедшей ошибке можно найти в <a href="%s">логах модуля</a>';
$_['updater_restore_success_text']            = 'Резервная копия %s был успешно удалён';
$_['updater_check_version_flash_message']     = 'Версия модуля %s была успешно загружена и установлена';
$_['updater_error_text_unpack_failed']        = 'Не удалось распаковать загруженный архив %s. Подробная информация об ошибке — в <a href="%s">логах модуля</a>';
$_['updater_error_text_create_backup_failed'] = 'Не удалось создать резервную копию установленной версии модуля. Подробная информация об ошибке — в <a href="%s">логах модуля</a>';
$_['updater_error_text_load_failed']          = 'Не удалось загрузить архив, попробуйте еще раз. Подробная информация об ошибке — в <a href="%s">логах модуля</a>';
$_['updater_log_text_load_failed']            = 'Не удалось загрузить архив с обновлением';

$_['order_captured_text']       = 'Платёж для заказа №%s подтверждён';
$_['payments_list_title']       = 'Список платежей';
$_['payments_list_breadcrumbs'] = 'Список платежей через модуль ЮKassa';

$_['text_repay'] = 'Оплатить';
$_['text_order'] = 'Заказ';
$_['text_comment'] = 'Комментарий';

$_['text_method_yoomoney'] = 'ЮMoney';
$_['text_method_bank_card']    = 'Банковские карты — Visa, Mastercard и Maestro, «Мир»';
$_['text_method_cash']         = "Наличные";
$_['text_method_mobile']       = 'Баланс мобильного — Билайн, Мегафон, МТС, Tele2';
$_['text_method_webmoney']     = 'Webmoney';
$_['text_method_alfabank']     = 'Альфа-Клик';
$_['text_method_sberbank']     = 'SberPay';
$_['text_method_ma']           = 'MasterPass';
$_['text_method_pb']           = 'Интернет-банк Промсвязьбанка';
$_['text_method_qiwi']         = 'QIWI Wallet';
$_['text_method_qp']           = 'Доверительный платеж (Куппи.ру)';
$_['text_method_mp']           = 'Мобильный терминал';
$_['text_method_installments'] = 'Заплатить по частям';
$_['text_method_tinkoff_bank'] = 'Интернет-банк Тинькофф';
$_['text_method_widget']       = 'Платёжный виджет ЮKassa (карты, Apple Pay и Google Pay)';
$_['bank_cards_title']         = 'Банковские карты';
$_['cash_title']               = 'Наличные через терминалы';
$_['mobile_balance_title']     = 'Баланс мобильного';

$_['text_vat_none'] = 'без НДС';
$_['text_vat_10']   = 'Расчетная ставка 10/110';
$_['text_vat_20']   = 'Расчетная ставка 20/120';

$_['kassa_hold_setting_label']        = 'Включить отложенную оплату';
$_['kassa_hold_setting_description']  = 'Если опция включена, платежи с карт проходят в 2 этапа: у клиента сумма замораживается, и вам вручную нужно подтвердить её списание – через панель администратора.  <a href="https://yookassa.ru/holdirovanie/" target="_blank">Подробное описание Холдирования.</a>';
$_['kassa_hold_order_statuses_label'] = 'Какой статус присваивать заказу, если он:';
$_['kassa_hold_order_status_label']   = 'ожидает подтверждения';
$_['kassa_hold_order_status_help']    = 'заказ переходит в этот статус при поступлении и остается в нем пока оператор магазина не подтвердит или не отменит платеж';
$_['kassa_cancel_order_status_label'] = 'отменен';
$_['kassa_cancel_order_status_help']  = 'заказ переходит в этот статус после отмены платежа';
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

$_['nps_text'] = 'Помогите нам улучшить модуль ЮKassa — ответьте на %s один вопрос %s';

$_['b2b_sberbank_label']             = 'Включить платежи через Сбербанк Бизнес Онлайн';
$_['b2b_sberbank_on_label']          = 'Если эта опция включена, вы можете принимать онлайн-платежи от юрлиц. Подробнее — <a href="https://yookassa.ru">на сайте ЮKassa.</a>';
$_['b2b_sberbank_template_label']    = 'Шаблон для назначения платежа';
$_['b2b_sberbank_vat_default_label'] = 'Ставка НДС по умолчанию';
$_['b2b_sberbank_template_help']     = 'Это назначение платежа будет в платёжном поручении.';
$_['b2b_sberbank_vat_default_help']  = 'Эта ставка передаётся в Сбербанк Бизнес Онлайн, если в карточке товара не указана другая ставка.';
$_['b2b_sberbank_vat_label']         = 'Сопоставьте ставки НДС в вашем магазине со ставками для Сбербанка Бизнес Онлайн';
$_['b2b_sberbank_vat_cms_label']     = 'Ставка НДС в вашем магазине';
$_['b2b_sberbank_vat_sbbol_label']   = 'Ставка НДС для Сбербанк Бизнес Онлайн';
$_['b2b_tax_rate_untaxed_label']     = 'Без НДС';
$_['b2b_tax_rate_7_label']           = '7%';
$_['b2b_tax_rate_10_label']          = '10%';
$_['b2b_tax_rate_18_label']          = '18%';
$_['b2b_sberbank_tax_message']       = 'При оплате через Сбербанк Бизнес Онлайн есть ограничение: в одном чеке могут быть только товары с одинаковой ставкой НДС. Если клиент захочет оплатить за один раз товары с разными ставками — мы покажем ему сообщение, что так сделать не получится.';

$_['kassa_default_payment_mode_label']    = 'Признак способа расчета';
$_['kassa_default_payment_subject_label'] = 'Признак предмета расчета';
$_['ffd_help_message']                    = 'Признаки предмета расчёта и способа расчёта берутся из атрибутов товара payment_mode и payment_subject . Их значения можно задать отдельно в карточке товара, если это потребуется. <a href="https://yookassa.ru/developers/54fz/basics#ffd-1-05">Подробнее.</a><br>Для товаров, у которых значения этих атрибутов не заданы, будем применять значения по умолчанию:';

$_['kassa_auth_connect_title']     = 'Свяжите ваш сайт на OpenCart с личным кабинетом ЮKassa';
$_['kassa_auth_connect_error']     = 'Что-то пошло не так. Перезагрузите страницу и попробуйте ещё раз.';
$_['kassa_auth_connect_btn_title'] = 'Подключить магазин';
$_['kassa_auth_change_btn_title']  = 'Сменить магазин';
$_['kassa_auth_test_shop']         = 'Тестовый магазин';
$_['kassa_auth_real_shop']         = 'Боевой магазин';
$_['kassa_auth_help']              = '<b>Где найти ShopID и секретный ключ</b><br>Данные автоматически подтянутся сюда из&nbsp;личного кабинета. Для этого нажмите на&nbsp;<b>Сменить магазин</b>:<br>&mdash;&nbsp;во&nbsp;всплывающем окне войдите в&nbsp;ЮKassa<br>&mdash;&nbsp;разрешите поделиться данными с&nbsp;OpenCart';
$_['kassa_auth_enable_54fz_title'] = 'Чтобы онлайн-касса заработала, включите отправку в ЮKassa данных для чеков';
$_['kassa_auth_enable_54fz']       = '<b>Важно</b>: если в личном кабинете ЮKassa вы выбрали не связывать платёж и чек, то ставить галочку не нужно.';
$_['kassa_auth_switch_mode']       = '<b>Чтобы перейти с тестового магазина на настоящий, нажмите на кнопку «Сменить магазин»</b><br/> Во всплывающем окне войдите в личный кабинет, разрешите доступ к ЮKassa и выберите нужный магазин.';
$_['kassa_auth_connection_error']  = '<b>Не получилось связать сайт с личным кабинетом</b><br/>Переподключите ЮKassa. Если не получилось, обратитесь в техподдержку.';
$_['kassa_auth_connect_to_kassa']  = 'Переподключить ЮKassa';

$_['kassa_error_invalid_credentials'] = '<b>Не получилось связать сайт с личным кабинетом</b><br>Войдите в ЮKassa, чтобы сюда автоматически подгрузились правильные данные. Если не получилось, обратитесь в техподдержку.';

$_['kassa_breadcrumbs_heading_title'] = 'Журнал сообщений платежного модуля ЮMoney';
$_['kassa_breadcrumbs_logs']          = 'Журнал сообщений';
$_['kassa_breadcrumbs_extension']     = 'Модули платежей';
$_['kassa_breadcrumbs_home']          = 'Главная';

$_['log_title']    = 'Журнал сообщений платежного модуля ЮMoney';
$_['log_download'] = 'Скачать файл сообщений';
$_['log_clear']    = 'Очистить файл сообщений';
$_['log_empty']    = 'Журнал сообщений пуст.';
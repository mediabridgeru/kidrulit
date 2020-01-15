<?php
$_['entry_debug']      = 'Отладка передачи данных<br/><small>прерывает переход на оплату и выводит передаваемые данные на экран</small>';
$_['entry_cart']      = 'Передача корзины<br/><small>передача данных для формирования онлайн чека (54-ФЗ)</small>';
$_['entry_nds']      = 'НДС при передачи корзины';
$_['entry_nds_tovar']      = 'Из карточки товара';
$_['entry_nds_important']      = 'Принудительно';
$_['entry_nds_no']      = 'Без НДС';
$_['entry_tax']      = 'Налоги указанные в карточке товаров<br/><small>Обязательно создайте налоговый класс если первое поле справа пустое (система-локализация-налоги-налоговый класс), налоговые ставки создавать не надо. Укажите нужный налоговый класс в редактировании товара, а в таблице справа установите соответствие вашего налогового класса ставке НДС.</small>';

$_['entry_nds_important_nol']      = '0%';
$_['entry_nds_important_10']      = '10%';
$_['entry_nds_important_18']      = '18%';
$_['entry_nds_important_118']      = '18/118';
$_['entry_nds_important_110']      = '10/110';

$_['entry_returnpage']      = 'Страница возврата (success и fail)';
$_['entry_returnpage_self']      = 'Своя от модуля';
$_['entry_returnpage_default']      = 'Стандартная от магазина';

$_['entry_otlog']      = 'Режим перехода к оплате<br/><small><b>Стандартный</b> - оплата сразу после офрмления заказа.<br/><b>Отложенная оплата</b> - Разрешена только после проверки заказа.<br/><b>Контроль наличия товаров</b> - Все товары в корзине в наличии - работает стандартный режим, все или несколько товаров не в наличии - работает отложенный режим.</small>';
$_['entry_otlog_standard']      = 'Стандартный';
$_['entry_otlog_pay']      = 'Отложенная оплата';
$_['entry_otlog_stock']      = 'Контроль наличия товаров';

$_['heading_title']      = 'СберБанк эквайринг PRO (Расширенный протокол)';
$_['entry_userName']     = 'Логин API';
$_['entry_password']     = 'Пароль API';
$_['entry_komis'] 		 = 'Комиссия или скидка с покупателя<br/><small>Для скидки установите отрицательное значение</small>';
$_['entry_fixen']        = 'Cумма к оплате';
$_['entry_fixen_order']  = 'Заказ';
$_['entry_fixen_proc']   = 'Процент от заказа';
$_['entry_fixen_fix']    = 'Фиксированная';
$_['entry_fixen_amount'] = 'Сумма или процент к оплате';
$_['entry_minpay'] 		 = 'Минимальная сумма заказа(ели меньше то метод не отображается)';
$_['entry_maxpay'] 		 = 'Максимальная сумма заказа(ели больше то метод не отображается)';
$_['entry_start_status']    = 'Статус после оформления заказа<br/><small>Только для Отложенной оплаты</small>';
$_['entry_on_status']    = 'Статус заказа после неуспешной или ожидаемой оплаты<br/>Статус для активации Отложенной оплаты';
$_['entry_order_status'] = 'Статус после удачной оплаты';
$_['entry_geo_zone']     = 'Регион доступности оплаты';
$_['entry_status']       = 'Статус';
$_['entry_sort_order']   = 'Сортировка';
$_['entry_style']        = 'Вид кнопки под стиль темы';
$_['text_payment']       = 'Оплата';
$_['text_order']         = 'Заказы';
$_['status_title']       = 'Оплаченные заказы';
$_['text_success']       = 'Настройки сохранены';
$_['text_my']       	 = 'Свой';
$_['text_default']       = 'По умолчанию';

$_['entry_met']       			= 'Способ транзакции';
$_['entry_met_odnostage']       = 'Одностадийная';
$_['entry_met_preautoriz']      = 'Двухстадийная (c предавторизацией)';

$_['entry_sbacquiring_instruction'] 				= 'Инструкция при оформлении заказа:<br/><small>Поддерживает переменные:<br/>$href$ - ссылка на оплату<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/>а также html теги.</small>';
$_['entry_sbacquiring_instruction_tab']      		= 'Использовать инструкцию при оформлении заказа?';
$_['entry_sbacquiring_mail_instruction_tab']      	= 'Использовать инструкцию в письме с заказом?';
$_['entry_sbacquiring_mail_instruction']      		= 'Инструкция в письме с заказом:<br/><small>Поддерживает переменные:<br/>$href$ - ссылка на оплату<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/> а также html теги.</small>';
$_['entry_sbacquiring_success_comment_tab']      	= 'Использовать комментарий покупателю в письме о успешной оплате?';
$_['entry_sbacquiring_success_comment']      		= 'Комментарий покупателю в письме о успешной оплате:<br/><small>Поддерживает переменные:<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа</small>';
$_['entry_sbacquiring_name_tab']      				= 'Текст в название метода оплаты?';
$_['entry_sbacquiring_name']      					= 'Название метода оплаты';
$_['entry_sbacquiring_success_alert_admin_tab']    = 'Письмо администратору при успешной оплате';
$_['entry_sbacquiring_success_alert_customer_tab'] = 'Письмо покупателю при успешной оплате';
$_['entry_sbacquiring_success_page_tab']      		= 'Свой текст на странице успешной оплаты?';
$_['entry_sbacquiring_success_page_text']     		= 'Текст на странице успешной оплаты:<br/><small>Поддерживает переменные:<br/>$href$ - ссылка на оплату<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/>а также html теги.</small>';
$_['entry_sbacquiring_waiting_page_tab']      		= 'Свой текст на странице ожидаемой оплаты?';
$_['entry_sbacquiring_waiting_page_text']      	= 'Текст на странице ожидаемой оплаты:<br/><small>Поддерживает переменные:<br/>$href$ - ссылка на оплату<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/>а также html теги.</small>';
$_['entry_button_later']      					= 'Кнопка оплатить позже в оформлении заказа';

$_['entry_sbacquiring_hrefpage_tab']      			= 'Свой текст на странице после перехода по ссылки из письма или из личного кабинета?';
$_['entry_sbacquiring_hrefpage']      				= 'Текст на странице после перехода по ссылки из письма или из личного кабинета:<br/><small>Поддерживает переменные:<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма заказа<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/>а также html теги.</small>';

$_['text_createorder_or_notcreate']       = 'Создавать заказ после оплаты<br/><small>Если "Нет" то заказ создатся сразу, независимого от того прошла оплата или нет.</small>';

$_['entry_fail_page_tab']      = 'Свой текст на странице не успешной оплаты?';
$_['entry_fail_page_text']      = 'Текст на странице не успешной оплаты:<br/><small>Поддерживает переменные:<br/>$href$ - ссылка на оплату<br/>$orderid$ - номер заказа<br/>$itogo$ - сумма оплаты<br/>$komis$ - комисcия в процентах<br/>$total-komis$ - посчитанная комиссия от суммы<br/>$plus-komis$ - сумма с комиссией<br/>а также html теги.</small>';

$_['entry_servadr']      					= 'Адрес сервера';
$_['entry_servadr_test']      					= 'Тестовые платежи <small>https://3dsec.sberbank.ru/payment/</small>';
$_['entry_servadr_real']      					= 'Реальные платежи <small>https://securepayments.sberbank.ru/payment/</small>&nbsp&nbsp&nbsp';
$_['entry_servadr_self']      					= 'Свой&nbsp&nbsp&nbsp';
$_['entry_self']      					= 'Свой адрес сервера<br/><small>Адрес в формате<br/>https://domainname.ru/xxxxx/xxxxxx<br/>адрес до rest включительно/xxxxx</small>';

$_['entry_zapros']      					= 'Метод запросов к банку<br/><small>Если вы получаете в логе ошибку SberBank error: code= без кода то используйте метод File_Get_Contents';
$_['entry_curl']      					= 'Curl (рекомендуется)';
$_['entry_fgc']      					= 'File_Get_Contents (только если проблемы с curl)';

$_['entry_currency']      					= 'Код валюты мерчанта<br/><small>Код валюты Вашего счета Вы можете узнать в банке</small>';
$_['entry_currency_rub']      				= 'По умолчанию (643 - Рубль)';
$_['entry_currency_self']      				= 'Свой';
$_['entry_currency_self_text']      		= 'Свой код валюты';

$_['entry_currency_convert']      			= 'Валюта магазина для оплаты<br/><small>Если оформление заказа в другой валюте, то при переходе на оплату будет происходить конвертация по курсу магазина в указанную валюту</small>';

$_['entry_callbackemulate']      		= 'Проверка платежа и смена статуса заказа на странице удачной оплаты';
$_['entry_callbackemulate_yes']      		= 'Да';
$_['entry_callbackemulate_no']      		= 'Нет (только по callback от банка или без смены)';

$_['entry_customName']      = 'Альтернативное название товара в чеке:<br/><small>Стандартное название товара будет заменено из указанного поля карточки товара)</small>';
$_['entry_customShip']      = 'Альтернативное название доставки в чеке:<br/><small>Название доставки всегда будет заменяться на указанное, при пустом значении поля замена не производится';
$_['text_UPC']        = 'UPC';
$_['text_EAN']        = 'EAN';
$_['text_JAN']        = 'JAN';
$_['text_ISBN']        = 'ISBN';
$_['text_MPN']        = 'MPN';


//Ошибки
$_['entry_license']   = 'Лицензионный ключ';
$_['error_license']   = 'Введите Лицензионный ключ!<br/><small>Купить ключ можно на <a href="http://store.pe-art.ru">http://store.pe-art.ru</a></small>';
$_['error_key_er']    = 'Неправильный Лицензионный ключ!<br/><small>Ключ действителен только для одного домена. Купить ключ можно на <a href="http://store.pe-art.ru">http://store.pe-art.ru</a></small>';
$_['error_shopId']    = 'Введите идентификатор контрагента (shopId) полученный от яндекс.денег';
$_['error_scid'] 	  = 'Введите номер витрины контрагента (scid) полученный от яндекс.денег';
$_['error_password']  = 'Введите секретное слово';
$_['error_self']  	  = 'Введите адрес сервера';

$_['pay_text_mail'] 								= 'Перейти на оплату можно по ссылке';
$_['pay_text_admin'] 								= 'Ссылка на оплату:';

//Статус
$_['yandex_id']   = 'ID';
$_['num_order']   = 'Номер заказа';
$_['sum']   = 'Сумма';
$_['user']   = 'Пользователь';
$_['email']   = 'email';
$_['date_created']   = 'Дата создания';
$_['date_enroled']   = 'Дата оплаты';
$_['sender']   = 'Идентификатор операции';
?>
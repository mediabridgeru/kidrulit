<?php
$_['heading_title']      = 'Эвотор - ИМ Чек по заказу';
$_['entry_user']     	 = 'Токен приложения:<br/><small>Необходима установка приложения <a href="https://market.evotor.ru/store/apps/a094737d-d89c-4243-aaea-6b2bd8c96461" target="_blank">Чек по документу API</a>. После установки вы получите токен приложения.</small>';
$_['entry_storeUiid']     = 'StoreUUID:';
$_['entry_Timeout']     = 'Таймаут (сек.):<br/><small>Время (сек) ожидания выполнения команды.<br/>Если не указано - то значение по умолчанию 60 сек</small>';
$_['entry_firm_name']    = 'Наименование юридического лица';
$_['entry_InnKkm']       = 'ИНН юридического лица';
$_['entry_errorEmail']       = 'Email для оповещения при сбое:<br/><small>Уведомления о сбое автоматеческой регистрации прихода или возврата<br/>(Возможно несколько - через запятую, без пробелов)</small>';
$_['entry_status']       = 'Статус:';
$_['entry_order_status_id_confirm']       = 'Статус для автоматичекой передачи чека Электронного прихода:';
$_['entry_order_status_id_return']       = 'Статус для автоматичекой передачи чека Электронного возврата:';
$_['entry_order_status_id_nal_confirm']       = 'Статус для автоматичекой передачи чека Наличного прихода:';
$_['entry_order_status_id_nal_return']       = 'Статус для автоматичекой передачи чека Наличного возврата:';
$_['entry_payments']       = 'Способы Электронной оплаты, для которых требуется автоматическая передача чеков:';
$_['entry_payments_nal']       = 'Способы Наличной оплаты, для которых требуется автоматическая передача чеков:';
$_['entry_log']      = 'Запись передаваемых данных в журнал:';
$_['entry_nds']      = 'НДС:';
$_['entry_nds_tovar']      = 'Из карточки товара';
$_['entry_nds_important']      = 'Принудительно';
$_['entry_nds_no']      = 'Без НДС';
$_['entry_tax']      = 'Налоги указанные в карточке товаров<br/><small>Обязательно создайте налоговый класс если первое поле справа пустое (система-локализация-налоги-налоговый класс), налоговые ставки создавать не надо. Укажите нужный налоговый класс в редактировании товара, а в таблице справа установите соответствие вашего налогового класса ставке НДС.</small>';

$_['entry_nds_important_nol']      = '0%';
$_['entry_nds_important_10']      = '10%';
$_['entry_nds_important_18']      = '18%';
$_['entry_nds_important_118']      = '18/118';
$_['entry_nds_important_110']      = '10/110';


$_['entry_logs']      = 'Журнал передачи данных:<br/><small>Записывает данные в */logs/kkfm.log</small>';
$_['entry_customName']      = 'Альтернативное название товара:<br/><small>Стандартное название товара будет заменено из указанного поля карточки товара)</small>';
$_['entry_customShip']      = 'Альтернативное название доставки:<br/><small>Название доставки всегда будет заменяться на указанное, при пустом значении поля замена не производится';

// Text
$_['text_extension']   = 'Модули';
$_['text_success']     = 'Настройки модуля обновлены!';
$_['text_edit']        = 'Редактирование модуля';
$_['text_UPC']        = 'UPC';
$_['text_EAN']        = 'EAN';
$_['text_JAN']        = 'JAN';
$_['text_ISBN']        = 'ISBN';
$_['text_MPN']        = 'MPN';
$_['text_default']        = 'По умолчанию';

$_['text_token']   = 'Получить';
$_['text_vibor']       = 'Получите и выберите значение';

//LOGS
// Heading
$_['heading_title_logs']	   = 'Журнал Эвотор';

// Text
$_['text_success_logs']	   = 'Журнал Эвотор успешно очищен!';
$_['text_list_logs']       = 'Список ошибок';
$_['text_setup']       = 'Настройки Эвотор';

// Error
$_['error_warning_logs']	   = 'ВНИМАНИЕ: Your log file %s is %s!';
$_['error_permission_logs'] = 'У вас нет прав что бы очистить журнал!';

//Ошибки
$_['entry_license']   = 'Лицензионный ключ:';
$_['error_license']   = 'Введите Лицензионный ключ!<br/><small>Купить ключ можно на <a href="https://store.pe-art.ru">https://store.pe-art.ru</a></small>';
$_['error_key_er']    = 'Неправильный Лицензионный ключ!<br/><small>Ключ действителен только для одного домена. Купить ключ можно на <a href="https://store.pe-art.ru">https://store.pe-art.ru</a></small>';
$_['error_user'] 	  = 'Введите Токен приложения!';
$_['error_storeUiid'] 	  = 'Получите значения и выберите одно!';


//CHECKS
$_['heading_title_checks']	   = 'Чеки Эвотор';
$_['text_id']   = 'ID';
$_['text_order_id']   = 'Номер заказа';
$_['text_cashiername']   = 'Кассир';
$_['text_user']   = 'ID Покупателя';
$_['text_email']   = 'Контакт';
$_['text_status']   = 'Статус';
$_['text_date_created']   = 'Дата создания заказа';
$_['text_date_added']   = 'Дата чека';
$_['text_checknum']   = 'Номер чека';
$_['text_method']   = 'Код метода оплаты';
$_['text_electronicpayment']   = 'Сумма электронными';
$_['text_cash']   = 'Сумма наличными';
$_['text_type']   = 'Тип чека';
$_['text_type_prihod']   = 'Приход';
$_['text_type_return']   = 'Возврат';

$_['text_status_wait']   = 'Ожидание';
$_['text_status_ok']   = 'Зарегистрирован';
$_['text_status_error']   = 'Ошибка';
$_['text_status_curier']   = 'Курьер';
$_['text_order']   = 'Заказы';


$_['text_view']   = 'Просмотр';
$_['text_dellete']   = 'Удалить';

$_['entry_tax_system_code'] = 'Система налогообложения магазина:<br/><small>Параметр необходим, только если у вас несколько систем налогообложения.</small>';
$_['text_tax_system_code_default'] = 'По умолчанию';
$_['text_tax_system_code_1'] = 'Общая система налогообложения';
$_['text_tax_system_code_2'] = 'Упрощенная (УСН, доходы)';
$_['text_tax_system_code_3'] = 'Упрощенная (УСН, доходы минус расходы)';
$_['text_tax_system_code_4'] = 'Единый налог на вмененный доход (ЕНВД)';
$_['text_tax_system_code_5'] = 'Единый сельскохозяйственный налог (ЕСН)';
$_['text_tax_system_code_6'] = 'Патентная система налогообложения';


?>
<?php
// Heading
$_['heading_title']    = 'Boxberry';

// Tab
$_['tab_general']      = 'Общие настройки';

// Text
$_['text_shipping']    = 'Доставка';
$_['text_zone_label']    = 'Зона: ';
$_['text_success']     = 'Настройки модуля обновлены!';
$_['text_calc_api']     = 'Использовать API Boxberry';
$_['text_manually']     = 'Указать стоимость вручную';
$_['text_tariff_zones'] = 'Фиксированные цены для каждой тарифной зоны';
$_['text_add_cost_type_fixed'] = 'Надбавка/скидка фиксированной суммы';
$_['text_add_cost_type_percent'] = 'Надбавка/скидка в процентах от стоимости заказа';
$_['text_shipping_type_no_delivery'] = 'Нет доставки';
$_['text_shipping_type_all'] = 'Все доступные виды доставки';
$_['text_shipping_type_pickup'] = 'Самовывоз из ПВЗ';
$_['text_shipping_type_kd'] = 'Только курьерская доставка';
$_['text_license_name']   = 'Имя владельца лицензии';
$_['text_license_id']   = 'Идентификатор лицензии';
$_['text_license_info']   = 'Данные о лицензии';
$_['text_license_id_hint']   = 'Передайте посредством ЛС или на адрес <strong style="color: #38B0E3">acuteopencart@gmail.com</strong> значение данного поля автору модуля для получения лицензии.<br><p style="color: red;"><b>ВНИМАНИЕ: При запросе лицензии по email не забывайте указывать данные о покупке (место покупки, ник и т.п.). Письма, содержащие лишь ID будут удаляться без ответа!</b></p>';
$_['text_license_info_hint']   = 'Вставьте сюда полученную от автора модуля информацию о лицензии';
$_['text_round_no_round'] = 'Без округления';
$_['text_round_integer'] = 'До целого числа (без копеек)';
$_['text_round_10'] = 'До десятков';
$_['text_round_100'] = 'До сотен';
$_['text_free_subtotal'] = 'стоимости товаров в заказе';
$_['text_free_total'] = 'итоговой стоимости заказа';
$_['text_pvz_select_method'] = 'Способ выбора ПВЗ покупателем';

// Button
$_['button_copy_settings'] = 'Скопировать настройки для всех географических зон';

// Entry
$_['entry_cost']       = 'Дополнительная надбавка/скидка к заказу:';
$_['entry_calc_type']  = 'Способ расчета доставки:';
$_['entry_kd_zone_1_cost'] = 'Стоимость курьерской доставки - зона 1:';
$_['entry_kd_zone_2_cost'] = 'Стоимость курьерской доставки - зона 2:';
$_['entry_api_token']  = 'API-Токен:';
$_['entry_api_url']  = 'URL API сервиса:';
$_['entry_tax_class']  = 'Налоговый класс:';
$_['entry_status']     = 'Статус:';
$_['entry_sort_order'] = 'Порядок сортировки:';
$_['entry_shipping_type'] = 'Доступные виды доставки';
$_['entry_allow_cod'] = 'Разрешить наложенный платеж';
$_['entry_debug_mode'] = 'Режим отладки (bb.log)';
$_['entry_package_weight'] = 'Прибавить вес упаковки, г:';
$_['entry_show_icons'] = 'Отображать иконки доставки и оплаты Boxberry';
$_['entry_free_ship'] = 'Бесплатная доставка начиная с суммы заказа:';
$_['entry_kd_free_too'] = 'Бесплатная доставка действует и для КД';
$_['entry_free_total'] = 'Использовать доставку, начиная от суммы корзины: ';
$_['entry_free_total_to'] = '&nbsp;&nbsp;до: ';
$_['entry_free_total_to_hint'] = ' (0 - без ограничения сверху)';
$_['entry_country'] = 'Страна:';
$_['entry_round'] = 'Округление стоимости:';
$_['entry_package_height'] = ' высота, ';
$_['entry_package_width'] = ' ширина, ';
$_['entry_package_depth'] = ' глубина';
$_['entry_package_size'] = 'Размеры отправления, см:';
$_['entry_package_size_auto'] = 'Автоматический расчет на основании размеров товаров в корзине';
$_['entry_package_size_manual'] = 'Задать следующие фиксированные размеры';
$_['entry_foreign'] = 'Режим зарубежного магазина:';
$_['entry_currency'] = 'Валюта ЛК зарубежного магазина:';
$_['entry_insurance'] = 'Ценность отправки для зарубежного магазина:';
$_['entry_processing_days'] = 'Срок обработки заказа, рабочих дней:';
$_['entry_delivery_period'] = 'Отображать срок доставки (в днях, включая срок обработки):';
$_['entry_delivery_date'] = 'Отображать дату ожидаемой доставки:';
$_['entry_fix_delivery_period'] = 'Доставка, рабочих дней: ';
$_['entry_targetstart'] = 'Код пункта приема посылок. <br><b>Оставьте поле пустым, если не знаете, что сюда вносить!</b>';
$_['entry_total_type'] = 'Расчет стоимости доставки и бесплатности считать от: ';
$_['entry_pvz_select_map'] = 'Выбор на карте';
$_['entry_pvz_select_list'] = 'Выбор списком';
$_['entry_pvz_select_both'] = 'Предлагать оба варианта';
$_['entry_check_weight'] = 'Включить ограничение по весу отправления для ПВЗ';
$_['entry_prepaid_pvz_only'] = 'Работа только с ПВЗ с возможностью оплаты при получении заказа';
$_['entry_yandex_map_key'] = 'Ключ API Яндекс Карт ("JavaScript API и HTTP Геокодер") получить <a target="_blank" href="https://developer.tech.yandex.ru/services">тут</a>';

// Error
$_['error_permission'] = 'У Вас нет прав для управления этим модулем!';
$_['error_key'] = 'Укажите API-Токен сервиса Boxberry, API Url и Ключ Яндекс карт или установите статус модуля "Отключено"';
$_['error_no_license']   = 'Для сохранения настроек вы должны указать валидные данные лицензии, полученные от автора модуля!';
?>
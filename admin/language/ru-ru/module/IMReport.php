<?php
/*
	Author: Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
	Loc: Rus
*/
// Heading
$_['heading_title']       = '<img src="view/image/country.png" style="width: 14px;margin-bottom: -2px;margin-right: 5px;">IMReport (OC 1.5)';
$_['curr_heading_title']       = 'IMReport (OC 1.5) - Расширенная отчетность продаж и заказов';
$_['heading_title_h1']       = 'IMReport - Расширенная отчетность';
// Text
$_['text_module']         = 'Модули';
$_['text_success']        = 'Модуль IMReport успешно обновлен!';
$_['text_content_top']    = 'Верх страницы';
$_['text_content_bottom'] = 'Низ страницы';
$_['text_column_left']    = 'Левая колонка';
$_['text_column_right']   = 'Правая колонка';
$_['text_none']   = '';

// 1.7.0
$_['select_all_items'] = 'Все элементы';
$_['default_name'] = '--- Без имени ---';
// 1.8.0
$_['default_min_need_quantity'] = 10;

// Labels
$_['module_label'] = array(
	'label_top_product' => 'Ходовой товар',
	'label_client_group' => 'Группы клиентов',
	'label_ship_region' => 'Заказы по регионам (доставка)',
	'label_man_product' => 'Производители (объем продуктов)',
	'label_order_sales' => 'Оборот заказов',
	'label_client_orders' => 'Клиенты',
	'label_option_sales' => 'Опции',
	'label_product_option_sales' => 'Товары по опциям',
	// 1.8.0
	'label_min_need_quantity' => 'Минимальное количество (по умолчанию)',
	// 1.7.0
	'label_product_option_quantity' => 'Остаток на складе',
	// 1.8.0
	'label_stock_control' => 'Контроль остатков',
	// 1.8.0
	'label_stock_control_set' => 'Контроль остатков (настройки)',
	'label_filter_date_start' => 'Дата начала',
	'label_filter_date_end' => 'Дата окончания',
	// 1.8.0
	'label_filter_date_reg_start' => 'Регистрация (начало)',
	// 1.8.0
	'label_filter_date_reg_end' => 'Регистрация (конец)',
	'label_filter_date_start_month' => 'Месяц (начало)',
	'label_filter_date_start_year' => 'Год (начало)',
	'label_filter_date_end_month' => 'Месяц (конец)',
	'label_filter_date_end_year' => 'Год (конец)',
	'label_filter_order_status' => 'Статус заказа',
	'label_filter_cat' => 'Категория',
	'label_filter_manufact' => 'Производитель',
	'label_filter_sort' => 'Сортировка',
	'list_client_orders_modes' => 'Режим отчета',
	// 2.0.0
	'label_filter_order_paym_name' => 'Оплата - Название',
	'label_filter_order_paym_code' => 'Оплата - Код',
	'label_filter_order_ship_name' => 'Доставка - Название',
	'label_filter_order_ship_code' => 'Доставка - Код',
	// 2.5.0
	'label_filter_group_by' => 'Группировка по',
	// 1.7.0
	'label_count' => 'Количество',
	'label_sum' => 'Цена',
	'label_enabled' => 'Включено',
	'label_disabled' => 'Отключено',
	// 1.8.0
	'label_main_category' => 'Главная категория',
	// 1.9.0
	'label_ul_gr_product_option' => 'Продукты и Опции',
	'label_ul_gr_stock' => 'Склад',
	'label_ul_gr_customers' => 'Клиенты и Группы',
	'label_ul_gr_others' => 'Прочие отчеты',
	'label_filter_order_status_last' => 'Статус заказа (Последний)',
	'label_filter_order_status_all' => 'Статус заказа (Все)',
	// 2.0.0
	'label_ul_gr_orders' => 'Заказы',
	'label_order_ps' => 'Заказы (клиенты, доставка, оплата)',
	'label_filter_cust_group' => 'Группы клиентов',
	'label_filter_cust' => 'Клиенты',
	'label_module_settings' => 'Настройки',
	'label_lic_key' => 'Лицензия - Ключ 1',
	'label_lic_enc_mess' => 'Лицензия - Ключ 2',
	'label_lic_date_until' => 'Лицензия - Дата окончания',
	// 2.1.0
	'label_setting_h_license' => 'Лицензия',
	'label_setting_h_csv_iconv' => 'Настройка кодировки CSV',
	'label_setting_csv_iconv' => 'Кодировка CSV файлов',
	'label_setting_h_product_image' => 'Настройка изображений товаров',
	'label_setting_p_img_use' => 'Включить изображения',
	'label_setting_p_img_w' => 'Ширина изображений',
	'label_setting_p_img_h' => 'Высота изображений',
	// 2.2.0
	'label_product_nosales' => 'Товары без спроса',
	'label_filter_onstore' => 'Проверять наличие на складе',
	'label_filter_date_start_aval_product' => 'Поступл. с (продукт)',
	'label_filter_date_end_aval_product' => 'Поступл. до (продукт)',
	// 2.4.0
	'label_order_sales_by_day' => 'Оборот заказов по дням',
	// 2.5.0
	'label_order_ship' => 'Доставка',
);

// Buttons
$_['module_button'] = array(
	'button_cancel' => 'Вернуться',
	'button_filter' => 'Фильтровать',
	'button_csv' => 'CSV файл',
	// 1.8.0
	'button_save' => 'Сохранить',
	'status_save' => 'Сохраняем...',
	// 1.7.0
	'status_get' => 'Получаем данные...',
	'status_ok' => 'Данные получены!',
	'status_fail' => 'При загрузке возникли ошибки!',
	// 2.0.0
	'button_save_settings' => 'Сохранить настройки',
	// 2.2.0
	'button_rpns_1m' => '1 Месяц',
	'button_rpns_3m' => '3 Месяца',
	'button_rpns_6m' => '6 Месяцев',
);

// Table headers_list
$_['module_table_header'] = array(
	'table_top_product_cat' => 'Категория',
	'table_top_product_name' => 'Название',
	'table_top_product_model' => 'Модель',
	'table_top_product_manufact' => 'Производитель',
	'table_top_product_count' => 'Количество',
	'table_top_product_cost' => 'Итого',
	// 2.4.0
	'table_top_product_count_orders' => 'Заказы',
	'table_client_group_name' => 'Группа клиентов',
	'table_client_group_count' => 'Количество',
	'table_client_group_cost' => 'Итого',
	'table_ship_region_name' => 'Страна > Регион',
	'table_ship_region_count' => 'Количество',
	'table_ship_region_cost' => 'Итого',
	'table_man_product_name' => 'Производитель',
	'table_man_product_count' => 'Количество',
	'table_man_product_cost' => 'Итого',
	'table_order_sales_name' => 'Месяц',
	'table_order_sales_count' => 'Количество',
	'table_order_sales_cost' => 'Итого',
	'table_client_orders_name' => 'Имя клиента',
	'table_client_orders_email' => 'E-mail',
	'table_client_orders_phone' => 'Телефон',
	'table_client_orders_city' => 'Город',
	'table_client_orders_status' => 'Статус',
	'table_client_orders_date_added' => 'Регистрация',
	'table_client_orders_last_order' => '# Последний заказ',
	// 1.8.0
	'table_client_orders_count_all' => 'Количество (всего)',
	// 1.8.0
	'table_client_orders_cost_all' => 'Итого (всего)',
	'table_client_orders_count' => 'Количество',
	'table_client_orders_cost' => 'Итого',
	'table_option_sales_name' => 'Наименование опции',
	'table_option_sales_count' => 'Количество',
	'table_option_sales_cost' => 'Итого',
	'table_product_option_name' => 'Название',
	'table_product_option_list_option' => 'Опции',
	'table_product_option_cat' => 'Категория',
	'table_product_option_model' => 'Модель',
	'table_product_option_manufact' => 'Производитель',
	'table_product_option_count' => 'Количество',
	'table_product_option_cost' => 'Итого',
	'table_footer_all' => 'Итого',
	// 1.7.0
	'table_product_option_quantity_name' => 'Название',
	'table_product_option_quantity_option' => 'Опция',
	'table_product_option_quantity_cat' => 'Категория',
	'table_product_option_quantity_model' => 'Модель',
	'table_product_option_quantity_manufact' => 'Производитель',
	'table_product_option_quantity_count' => 'Количество',
	'table_product_option_quantity_subtract' => 'Вычитание',
	// 1.8.0
	'table_stock_control_name' => 'Название',
	'table_stock_control_option' => 'Опция',
	'table_stock_control_cat' => 'Категория',
	'table_stock_control_model' => 'Модель',
	'table_stock_control_manufact' => 'Производитель',
	'table_stock_control_curr_count' => 'Количество',
	'table_stock_control_need_count' => 'Необходимо',
	'table_stock_control_subtract' => 'Вычитание',
	// 1.9.0
	'table_stock_control_edit' => '<i class="fa fa-edit"></i>',
	// 1.8.0
	'table_stock_control_set_name' => 'Название',
	'table_stock_control_set_option' => 'Опция',
	'table_stock_control_set_cat' => 'Категория',
	'table_stock_control_set_model' => 'Модель',
	'table_stock_control_set_manufact' => 'Производитель',
	'table_stock_control_set_curr_count' => 'Количество',
	'table_stock_control_set_need_count' => 'Необходимо',
	'table_stock_control_set_subtract' => 'Вычитание',
	// 2.0.0
	'table_order_ps_date_added' => 'Дата',
	'table_order_ps_order_id' => 'Заказ',
	'table_order_ps_order_status' => 'Статус',
	'table_order_ps_client' => 'Клиент',
	'table_order_ps_paym' => 'Оплата',
	'table_order_ps_ship' => 'Доставка',
	'table_order_ps_cost' => 'Итого',
	// 2.2.0
	'table_product_nosales_name' => 'Названием',
	'table_product_nosales_model' => 'Модель',
	'table_product_nosales_sku' => 'Артикул',
	'table_product_nosales_manufact' => 'Производитель',
	'table_product_nosales_count' => 'Количество',
	'table_product_nosales_price' => 'Цена',
	// 2.4.0
	'table_order_sales_by_day_date_added' => 'Дата',
	'table_order_sales_by_day_cost_sub' => 'Сумма',
	'table_order_sales_by_day_cost_ship' => 'Доставка',
	'table_order_sales_by_day_cost_diff' => 'Корректор (разница)',
	'table_order_sales_by_day_count' => 'Количество',
	'table_order_sales_by_day_cost' => 'Итого',
	// 2.5.0
	'table_order_ship_date_start' => 'Дата начала',
	'table_order_ship_date_end' => 'Дата окончания',
	'table_order_ship_code' => 'Код',
	'table_order_ship_method' => 'Метод',
	'table_order_ship_title' => 'Название',
	'table_order_ship_count' => 'Количество',
	'table_order_ship_cost' => 'Итого',
);

// 1.7.0
// Months
$_['module_months'] = array(
	'Январь', 'Февраль', 'Март',
	'Апрель', 'Май', 'Июнь',
	'Июль', 'Август', 'Сентябрь',
	'Октябрь', 'Ноябрь', 'Декабрь'
);

// 1.7.0
// Client Report Mode
$_['module_client_report_mode'] = array(
	'Стандартный',
	'Поиск только зарегистрированных (без покупок)',
	'Поиск утерянных клиентов'
);

// Error
$_['error_permission'] = 'У Вас нет прав для изменения модуля IMReport!';
$_['lic_permission'] = 'Необходимо ввести лицензионные параметры';

////////////////////////////////////////////
// Translate List
////////////////////////////////////////////
$_['module_standard_onoff'] = array(
	'Отключено',
	'Включено'
);

// 2.1.0
$_['module_list_iconv_enc_csv'] = array(
	'Windows-1251',
	'UTF-8 (BOM)',
	'Без кодирования',
);

// 2.5.0
$_['module_list_group_by_time'] = array(
	'День',
	'Неделя',
	'Месяц',
	'Год',
);

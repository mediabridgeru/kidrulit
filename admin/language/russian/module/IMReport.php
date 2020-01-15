<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
	Loc: Rus
*/
// Heading
$_['heading_title']       = 'IMReport (1.5)';
$_['curr_heading_title']       = 'IMReport (1.5) - Расширенная отчетность продаж и заказов';
$_['heading_title_h1']       = 'IMReport (1.5)';
$_['heading_title_h2']       = 'Расширенная отчетность [ dev.imirochnik@gmail.com | <a href="http://ida-freewares.ru/">Ida-Freewares.ru</a> ]';
// Text
$_['text_module']         = 'Модули';
$_['text_success']        = 'Модуль IMReport (1.5) успешно обновлен!';
$_['text_content_top']    = 'Верх страницы';
$_['text_content_bottom'] = 'Низ страницы';
$_['text_column_left']    = 'Левая колонка';
$_['text_column_right']   = 'Правая колонка';
$_['text_none']   = '';

// 1.3.0
$_['select_all_items'] = 'Все элементы';
$_['default_name'] = '--- Без имени ---';
// 1.4.0
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
	// 1.4.0
	'label_min_need_quantity' => 'Минимальное количество (по умолчанию)',
	// 1.3.0
	'label_product_option_quantity' => 'Остаток на складе',
	// 1.4.0
	'label_stock_control' => 'Контроль остатков',
	// 1.4.0
	'label_stock_control_set' => 'Контроль остатков (настройки)',
	'label_filter_date_start' => 'Дата начала',
	'label_filter_date_end' => 'Дата окончания',
	// 1.4.0
	'label_filter_date_reg_start' => 'Регистрация (начало)',
	// 1.4.0
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
	// 1.3.0
	'label_count' => 'Количество',
	'label_sum' => 'Цена',
	'label_enabled' => 'Включено',
	'label_disabled' => 'Отключено',
	// 1.4.0
	'label_main_category' => 'Главная категория',
	// 1.5.0
	'label_ul_gr_product_option' => 'Продукты и Опции',
	'label_ul_gr_stock' => 'Склад',
	'label_ul_gr_customers' => 'Клиенты и Группы',
	'label_ul_gr_others' => 'Прочие отчеты',
	'label_filter_order_status_last' => 'Статус заказа (Последний)',
	'label_filter_order_status_all' => 'Статус заказа (Все)',
);

// Buttons
$_['module_button'] = array(
	'button_cancel' => 'Вернуться',
	'button_filter' => 'Фильтровать',
	'button_csv' => 'CSV файл',
	// 1.4.0
	'button_save' => 'Сохранить',
	'status_save' => 'Сохраняем...',
	// 1.3.0
	'status_get' => 'Получаем данные...',
	'status_ok' => 'Операция выполнена!',
	'status_fail' => 'Возникли ошибки!'
);

// Table headers_list
$_['module_table_header'] = array(
	'table_top_product_cat' => 'Категория',
	'table_top_product_name' => 'Название',
	'table_top_product_model' => 'Модель',
	'table_top_product_manufact' => 'Производитель',
	'table_top_product_count' => 'Количество',
	'table_top_product_cost' => 'Итого',
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
	// 1.4.0
	'table_client_orders_count_all' => 'Количество (всего)',
	// 1.4.0
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
	// 1.3.0
	'table_product_option_quantity_name' => 'Название',
	'table_product_option_quantity_option' => 'Опция',
	'table_product_option_quantity_cat' => 'Категория',
	'table_product_option_quantity_model' => 'Модель',
	'table_product_option_quantity_manufact' => 'Производитель',
	'table_product_option_quantity_count' => 'Количество',
	'table_product_option_quantity_subtract' => 'Вычитание',
	// 1.4.0
	'table_stock_control_name' => 'Название',
	'table_stock_control_option' => 'Опция',
	'table_stock_control_cat' => 'Категория',
	'table_stock_control_model' => 'Модель',
	'table_stock_control_manufact' => 'Производитель',
	'table_stock_control_curr_count' => 'Количество',
	'table_stock_control_need_count' => 'Необходимо',
	'table_stock_control_subtract' => 'Вычитание',
	// 1.5.0
	'table_stock_control_edit' => '<i class="fa fa-edit"></i>',
	// 1.4.0
	'table_stock_control_set_name' => 'Название',
	'table_stock_control_set_option' => 'Опция',
	'table_stock_control_set_cat' => 'Категория',
	'table_stock_control_set_model' => 'Модель',
	'table_stock_control_set_manufact' => 'Производитель',
	'table_stock_control_set_curr_count' => 'Количество',
	'table_stock_control_set_need_count' => 'Необходимо',
	'table_stock_control_set_subtract' => 'Вычитание',
);

// 1.3.0
// Months
$_['module_months'] = array(
	'Январь', 'Февраль', 'Март',
	'Апрель', 'Май', 'Июнь',
	'Июль', 'Август', 'Сентябрь',
	'Октябрь', 'Ноябрь', 'Декабрь'
);

// 1.3.0
// Client Report Mode
$_['module_client_report_mode'] = array(
	'Стандартный',
	'Поиск только зарегистрированных (без покупок)',
	'Поиск утерянных клиентов'
);

// Error
$_['error_permission']    = 'У Вас нет прав для изменения модуля IMReport!';


////////////////////////////////////////////
// 1.3.0
// Sort Area
////////////////////////////////////////////
$_['module_sort_top'] = array(
	'По умолчанию',
	'Продукт (возрастание)',
	'Продукт (убывание)',
	'Модель (возрастание)',
	'Модель (убывание)',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_client'] = array(
	'По умолчанию',
	'Группа (возрастание)',
	'Группа (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_ship_region'] = array(
	'По умолчанию',
	'Страна/Регион (возрастание)',
	'Страна/Регион (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_man_product'] = array(
	'По умолчанию',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_client_orders'] = array(
	'По умолчанию',
	'Имя клиента (возрастание)',
	'Имя клиента (убывание)',
	'Email (возрастание)',
	'Email (убывание)',
	'Телефон (возрастание)',
	'Телефон (убывание)',
	'Город (возрастание)',
	'Город (убывание)',
	'Статус (возрастание)',
	'Статус (убывание)',
	'Регистрация (возрастание)',
	'Регистрация (убывание)',
	'# Последний заказ (возрастание)',
	'# Последний заказ (убывание)',
	'# Последний заказ - дата (возрастание)',
	'# Последний заказ - дата (убывание)',
	// 1.4.0
	'Количество (Всего) (возрастание)',
	'Количество (Всего) (убывание)',
	'Цена (Всего) (возрастание)',
	'Цена (Всего) (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_option_sales'] = array(
	'По умолчанию',
	'Наименование опции (возрастание)',
	'Наименование опции (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);

$_['module_sort_product_option_sales'] = array(
	'По умолчанию',
	'Продукт (возрастание)',
	'Продукт (убывание)',
	'Опции (возрастание)',
	'Опции (убывание)',
	'Модель (возрастание)',
	'Модель (убывание)',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Цена (возрастание)',
	'Цена (убывание)',
);		

$_['module_sort_product_option_quantity'] = array(
	'По умолчанию',
	'Продукт (возрастание)',
	'Продукт (убывание)',
	'Опции (возрастание)',
	'Опции (убывание)',
	'Модель (возрастание)',
	'Модель (убывание)',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Вычитание (возрастание)',
	'Вычитание (убывание)',
);		

// 1.4.0
$_['module_standard_onoff'] = array(
	'Отключено',
	'Включено'
);

// 1.4.0
$_['module_sort_stock_control'] = array(
	'По умолчанию',
	'Продукт (возрастание)',
	'Продукт (убывание)',
	'Опции (возрастание)',
	'Опции (убывание)',
	'Модель (возрастание)',
	'Модель (убывание)',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Вычитание (возрастание)',
	'Вычитание (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Необходимо (возрастание)',
	'Необходимо (убывание)',
);		

// 1.4.0
$_['module_sort_stock_control_set'] = array(
	'По умолчанию',
	'Продукт (возрастание)',
	'Продукт (убывание)',
	'Опции (возрастание)',
	'Опции (убывание)',
	'Модель (возрастание)',
	'Модель (убывание)',
	'Производитель (возрастание)',
	'Производитель (убывание)',
	'Вычитание (возрастание)',
	'Вычитание (убывание)',
	'Количество (возрастание)',
	'Количество (убывание)',
	'Необходимо (возрастание)',
	'Необходимо (убывание)',
);		

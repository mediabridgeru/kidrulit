<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
	Loc: Eng
*/
// Heading
$_['heading_title']       = 'IMReport (1.5)';
$_['curr_heading_title']       = 'IMReport (1.5) - Extended reporting';
$_['heading_title_h1']       = 'IMReport (1.5)';
$_['heading_title_h2']       = 'Extended reporting [ dev.imirochnik@gmail.com | <a href="http://ida-freewares.ru/">Ida-Freewares.ru</a> ]';
// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Module IMReport (1.5) success updated!';
$_['text_content_top']    = 'Top';
$_['text_content_bottom'] = 'Bottom';
$_['text_column_left']    = 'Left column';
$_['text_column_right']   = 'Right column';
$_['text_none']   = '';

// 1.3.0
$_['select_all_items'] = 'All items';
$_['default_name'] = '--- Noname ---';
// 1.4.0
$_['default_min_need_quantity'] = 10;

// Labels
$_['module_label'] = array(
	'label_top_product' => 'Product',
	'label_client_group' => 'Customer Groups',
	'label_ship_region' => 'Orders by Region (Shipping)',
	'label_man_product' => 'Manufacturers (Products)',
	'label_order_sales' => 'Orders',
	'label_client_orders' => 'Customers',
	'label_option_sales' => 'Options',
	'label_product_option_sales' => 'Product by Options',
	// 1.4.0
	'label_min_need_quantity' => 'Minimum quantity (Default)',
	// 1.3.0
	'label_product_option_quantity' => 'Stock balance',
	// 1.4.0
	'label_stock_control' => 'Stock balance control',
	// 1.4.0
	'label_stock_control_set' => 'Stock balance control (settings)',
	'label_filter_date_start' => 'Date (From)',
	'label_filter_date_end' => 'Date (To)',
	// 1.4.0
	'label_filter_date_reg_start' => 'Register (From)',
	// 1.4.0
	'label_filter_date_reg_end' => 'Register (To)',
	'label_filter_date_start_month' => 'Month (From)',
	'label_filter_date_start_year' => 'Year (From)',
	'label_filter_date_end_month' => 'Month (To)',
	'label_filter_date_end_year' => 'Year (To)',
	'label_filter_order_status' => 'Order status',
	'label_filter_cat' => 'Category',
	'label_filter_manufact' => 'Manufacturer',
	'label_filter_sort' => 'Sort',
	'list_client_orders_modes' => 'Report mode',
	// 1.3.0
	'label_count' => 'Count',
	'label_sum' => 'Sum',
	'label_enabled' => 'On',
	'label_disabled' => 'Off',
	// 1.4.0
	'label_main_category' => 'Main category',
	// 1.5.0
	'label_ul_gr_product_option' => 'Products and Options',
	'label_ul_gr_stock' => 'Stock',
	'label_ul_gr_customers' => 'Customers and Groups',
	'label_ul_gr_others' => 'Other reports',
	'label_filter_order_status_last' => 'Order status (Last)',
	'label_filter_order_status_all' => 'Order status (All)',
);

// Buttons
$_['module_button'] = array(
	'button_cancel' => 'Cancel',
	'button_filter' => 'Filter',
	'button_csv' => 'CSV file',
	// 1.4.0
	'button_save' => 'Save',
	'status_save' => 'Save...',
	// 1.3.0
	'status_get' => 'Get data...',
	'status_ok' => 'Success',
	'status_fail' => 'Fail'
);

// Table headers_list
$_['module_table_header'] = array(
	'table_top_product_cat' => 'Category',
	'table_top_product_name' => 'Name',
	'table_top_product_model' => 'Model',
	'table_top_product_manufact' => 'Manufacturer',
	'table_top_product_count' => 'Count',
	'table_top_product_cost' => 'Sum',
	'table_client_group_name' => 'Group',
	'table_client_group_count' => 'Count',
	'table_client_group_cost' => 'Sum',
	'table_ship_region_name' => 'Country > Region',
	'table_ship_region_count' => 'Count',
	'table_ship_region_cost' => 'Sum',
	'table_man_product_name' => 'Manufacturer',
	'table_man_product_count' => 'Count',
	'table_man_product_cost' => 'Sum',
	'table_order_sales_name' => 'Month',
	'table_order_sales_count' => 'Count',
	'table_order_sales_cost' => 'Sum',
	'table_client_orders_name' => 'Client name',
	'table_client_orders_email' => 'E-mail',
	'table_client_orders_phone' => 'Phone',
	'table_client_orders_city' => 'City',
	'table_client_orders_status' => 'Status',
	'table_client_orders_date_added' => 'Added',
	'table_client_orders_last_order' => '# Last order',
	// 1.4.0
	'table_client_orders_count_all' => 'Count (All)',
	// 1.4.0
	'table_client_orders_cost_all' => 'Sum (All)',
	'table_client_orders_count' => 'Count',
	'table_client_orders_cost' => 'Sum',
	'table_option_sales_name' => 'Option name',
	'table_option_sales_count' => 'Count',
	'table_option_sales_cost' => 'Sum',
	'table_product_option_name' => 'Name',
	'table_product_option_list_option' => 'Options',
	'table_product_option_cat' => 'Category',
	'table_product_option_model' => 'Model',
	'table_product_option_manufact' => 'Manufacturer',
	'table_product_option_count' => 'Count',
	'table_product_option_cost' => 'Sum',
	'table_footer_all' => 'Sum',
	// 1.3.0
	'table_product_option_quantity_name' => 'Name',
	'table_product_option_quantity_option' => 'Option',
	'table_product_option_quantity_cat' => 'Category',
	'table_product_option_quantity_model' => 'Model',
	'table_product_option_quantity_manufact' => 'Manufacturer',
	'table_product_option_quantity_count' => 'Quantity',
	'table_product_option_quantity_subtract' => 'Subtract',
	// 1.4.0
	'table_stock_control_name' => 'Name',
	'table_stock_control_option' => 'Option',
	'table_stock_control_cat' => 'Category',
	'table_stock_control_model' => 'Model',
	'table_stock_control_manufact' => 'Manufacturer',
	'table_stock_control_curr_count' => 'Quantity',
	'table_stock_control_need_count' => 'Need',
	'table_stock_control_subtract' => 'Subtract',
	// 1.5.0
	'table_stock_control_edit' => '<i class="fa fa-edit"></i>',
	// 1.4.0
	'table_stock_control_set_name' => 'Name',
	'table_stock_control_set_option' => 'Option',
	'table_stock_control_set_cat' => 'Category',
	'table_stock_control_set_model' => 'Model',
	'table_stock_control_set_manufact' => 'Manufacturer',
	'table_stock_control_set_curr_count' => 'Quantity',
	'table_stock_control_set_need_count' => 'Need',
	'table_stock_control_set_subtract' => 'Subtract',
);

// 1.3.0
// Months
$_['module_months'] = array(
	'January', 'February', 'March',
	'April', 'May', 'June',
	'July', 'August', 'September',
	'October', 'November', 'December'
);

// 1.3.0
// Client Report Mode
$_['module_client_report_mode'] = array(
	'Standard',
	'Search only registered (no shopping)',
	'Search lost customers'
);

// Error
$_['error_permission']    = 'You are not authorized to change the module IMReport!';


////////////////////////////////////////////
// 1.3.0
// Sort Area
////////////////////////////////////////////
$_['module_sort_top'] = array(
	'Default',
	'Product (Asc)',
	'Product (Desc)',
	'Model (Asc)',
	'Model (Desc)',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_client'] = array(
	'Default',
	'Group (Asc)',
	'Group (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_ship_region'] = array(
	'Default',
	'Country/Region (Asc)',
	'Country/Region (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_man_product'] = array(
	'Default',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_client_orders'] = array(
	'Default',
	'Client name (Asc)',
	'Client name (Desc)',
	'Email (Asc)',
	'Email (Desc)',
	'Phone (Asc)',
	'Phone (Desc)',
	'City (Asc)',
	'City (Desc)',
	'Status (Asc)',
	'Status (Desc)',
	'Added (Asc)',
	'Added (Desc)',
	'# Last order (Asc)',
	'# Last order (Desc)',
	'# Last order - Date Added (Asc)',
	'# Last order - Date Added (Desc)',
	// 1.4.0
	'Count (All) (Asc)',
	'Count (All) (Desc)',
	'Sum (All) (Asc)',
	'Sum (All) (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_option_sales'] = array(
	'Default',
	'Option name (Asc)',
	'Option name (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);

$_['module_sort_product_option_sales'] = array(
	'Default',
	'Product (Asc)',
	'Product (Desc)',
	'Options (Asc)',
	'Options (Desc)',
	'Model (Asc)',
	'Model (Desc)',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Count (Asc)',
	'Count (Desc)',
	'Sum (Asc)',
	'Sum (Desc)',
);		

$_['module_sort_product_option_quantity'] = array(
	'Default',
	'Product (Asc)',
	'Product (Desc)',
	'Options (Asc)',
	'Options (Desc)',
	'Model (Asc)',
	'Model (Desc)',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Quantity (Asc)',
	'Quantity (Desc)',
	'Subtract (Asc)',
	'Subtract (Desc)',
);		

// 1.4.0
$_['module_standard_onoff'] = array(
	'Off',
	'On'
);

// 1.4.0
$_['module_sort_stock_control'] = array(
	'Default',
	'Product (Asc)',
	'Product (Desc)',
	'Options (Asc)',
	'Options (Desc)',
	'Model (Asc)',
	'Model (Desc)',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Subtract (Asc)',
	'Subtract (Desc)',
	'Quantity (Asc)',
	'Quantity (Desc)',
	'Need (Asc)',
	'Need (Desc)',
);		

// 1.4.0
$_['module_sort_stock_control_set'] = array(
	'Default',
	'Product (Asc)',
	'Product (Desc)',
	'Options (Asc)',
	'Options (Desc)',
	'Model (Asc)',
	'Model (Desc)',
	'Manufacturer (Asc)',
	'Manufacturer (Desc)',
	'Subtract (Asc)',
	'Subtract (Desc)',
	'Quantity (Asc)',
	'Quantity (Desc)',
	'Need (Asc)',
	'Need (Desc)',
);		


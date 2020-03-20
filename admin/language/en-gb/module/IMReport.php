<?php
/*
	Author: Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
	Loc: Eng
*/
// Heading
$_['heading_title']       = '<img src="view/image/country.png" style="width: 14px;margin-bottom: -2px;margin-right: 5px;">IMReport (OC 1.5)';
$_['curr_heading_title']       = 'IMReport (OC 1.5) - Extended reporting';
$_['heading_title_h1']       = 'IMReport - Extended reporting';
// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Module IMReport success updated!';
$_['text_content_top']    = 'Top';
$_['text_content_bottom'] = 'Bottom';
$_['text_column_left']    = 'Left column';
$_['text_column_right']   = 'Right column';
$_['text_none']   = '';

// 1.7.0
$_['select_all_items'] = 'All items';
$_['default_name'] = '--- Noname ---';
// 1.8.0
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
	// 1.8.0
	'label_min_need_quantity' => 'Minimum quantity (Default)',
	// 1.7.0
	'label_product_option_quantity' => 'Stock balance',
	// 1.8.0
	'label_stock_control' => 'Stock balance control',
	// 1.8.0
	'label_stock_control_set' => 'Stock balance control (settings)',
	'label_filter_date_start' => 'Date (From)',
	'label_filter_date_end' => 'Date (To)',
	// 1.8.0
	'label_filter_date_reg_start' => 'Register (From)',
	// 1.8.0
	'label_filter_date_reg_end' => 'Register (To)',
	'label_filter_date_start_month' => 'Month (From)',
	'label_filter_date_start_year' => 'Year (From)',
	'label_filter_date_end_month' => 'Month (To)',
	'label_filter_date_end_year' => 'Year (конец)',
	'label_filter_order_status' => 'Order status',
	'label_filter_cat' => 'Category',
	'label_filter_manufact' => 'Manufacturer',
	'label_filter_sort' => 'Sort',
	'list_client_orders_modes' => 'Report mode',
	// 2.0.0
	'label_filter_order_paym_name' => 'Payment - Name',
	'label_filter_order_paym_code' => 'Payment - Code',
	'label_filter_order_ship_name' => 'Shipping - Name',
	'label_filter_order_ship_code' => 'Shipping - Code',
	// 2.5.0
	'label_filter_group_by' => 'Group by',
	// 1.7.0
	'label_count' => 'Count',
	'label_sum' => 'Sum',
	'label_enabled' => 'On',
	'label_disabled' => 'Off',
	// 1.8.0
	'label_main_category' => 'Main category',
	// 1.9.0
	'label_ul_gr_product_option' => 'Products and Options',
	'label_ul_gr_stock' => 'Stock',
	'label_ul_gr_customers' => 'Customers and Groups',
	'label_ul_gr_others' => 'Other reports',
	'label_filter_order_status_last' => 'Order status (Last)',
	'label_filter_order_status_all' => 'Order status (All)',
	// 2.0.0
	'label_ul_gr_orders' => 'Orders',
	'label_order_ps' => 'Orders (customer, shipping, payment)',
	'label_filter_cust_group' => 'Customer Groups',
	'label_filter_cust' => 'Customers',
	'label_module_settings' => 'Settings',
	'label_lic_key' => 'License - Key 1',
	'label_lic_enc_mess' => 'License - Key 2',
	'label_lic_date_until' => 'License - Until date',
	// 2.1.0
	'label_setting_h_license' => 'License',
	'label_setting_h_csv_iconv' => 'CSV encoding settings',
	'label_setting_csv_iconv' => 'CSV encoding',
	'label_setting_h_product_image' => 'Product image settings',
	'label_setting_p_img_use' => 'Enable image',
	'label_setting_p_img_w' => 'Width',
	'label_setting_p_img_h' => 'Height',
	// 2.2.0
	'label_product_nosales' => 'Product - No Sales',
	'label_filter_onstore' => 'Is have on store',
	'label_filter_date_start_aval_product' => 'Receipt From (Product)',
	'label_filter_date_end_aval_product' => 'Receipt To (Product)',
	// 2.4.0
	'label_order_sales_by_day' => 'Orders by Days',
	// 2.5.0
	'label_order_ship' => 'Shipping',
);

// Buttons
$_['module_button'] = array(
	'button_cancel' => 'Cancel',
	'button_filter' => 'Filter',
	'button_csv' => 'CSV file',
	// 1.8.0
	'button_save' => 'Save',
	'status_save' => 'Save...',
	// 1.7.0
	'status_get' => 'Get data...',
	'status_ok' => 'Success',
	'status_fail' => 'Fail',
	// 2.0.0
	'button_save_settings' => 'Save settings',
	// 2.2.0
	'button_rpns_1m' => '1 Month',
	'button_rpns_3m' => '3 Months',
	'button_rpns_6m' => '6 Months',
);

// Table headers_list
$_['module_table_header'] = array(
	'table_top_product_cat' => 'Category',
	'table_top_product_name' => 'Name',
	'table_top_product_model' => 'Model',
	'table_top_product_manufact' => 'Manufacturer',
	'table_top_product_count' => 'Count',
	'table_top_product_cost' => 'Sum',
	// 2.4.0
	'table_top_product_count_orders' => 'Orders',
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
	// 1.8.0
	'table_client_orders_count_all' => 'Count (All)',
	// 1.8.0
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
	// 1.7.0
	'table_product_option_quantity_name' => 'Name',
	'table_product_option_quantity_option' => 'Option',
	'table_product_option_quantity_cat' => 'Category',
	'table_product_option_quantity_model' => 'Model',
	'table_product_option_quantity_manufact' => 'Manufacturer',
	'table_product_option_quantity_count' => 'Quantity',
	'table_product_option_quantity_subtract' => 'Subtract',
	// 1.8.0
	'table_stock_control_name' => 'Name',
	'table_stock_control_option' => 'Option',
	'table_stock_control_cat' => 'Category',
	'table_stock_control_model' => 'Model',
	'table_stock_control_manufact' => 'Manufacturer',
	'table_stock_control_curr_count' => 'Quantity',
	'table_stock_control_need_count' => 'Need',
	'table_stock_control_subtract' => 'Subtract',
	// 1.9.0
	'table_stock_control_edit' => '<i class="fa fa-edit"></i>',
	// 1.8.0
	'table_stock_control_set_name' => 'Name',
	'table_stock_control_set_option' => 'Option',
	'table_stock_control_set_cat' => 'Category',
	'table_stock_control_set_model' => 'Model',
	'table_stock_control_set_manufact' => 'Manufacturer',
	'table_stock_control_set_curr_count' => 'Quantity',
	'table_stock_control_set_need_count' => 'Need',
	'table_stock_control_set_subtract' => 'Subtract',
	// 2.0.0
	'table_order_ps_date_added' => 'Date',
	'table_order_ps_order_id' => 'Order',
	'table_order_ps_order_status' => 'Status',
	'table_order_ps_client' => 'Client',
	'table_order_ps_paym' => 'Payment',
	'table_order_ps_ship' => 'Shipping',
	'table_order_ps_cost' => 'Sum',
	// 2.2.0
	'table_product_nosales_name' => 'Name',
	'table_product_nosales_model' => 'Model',
	'table_product_nosales_sku' => 'SKU',
	'table_product_nosales_manufact' => 'Manufacturer',
	'table_product_nosales_count' => 'Count',
	'table_product_nosales_price' => 'Price',
	// 2.4.0
	'table_order_sales_by_day_date_added' => 'Date',
	'table_order_sales_by_day_cost_sub' => 'Sub Total',
	'table_order_sales_by_day_cost_ship' => 'Shipping',
	'table_order_sales_by_day_cost_diff' => 'Diff',
	'table_order_sales_by_day_count' => 'Count',
	'table_order_sales_by_day_cost' => 'Sum',
	// 2.5.0
	'table_order_ship_date_start' => 'Date start',
	'table_order_ship_date_end' => 'Date end',
	'table_order_ship_code' => 'Code',
	'table_order_ship_method' => 'Method',
	'table_order_ship_title' => 'Name',
	'table_order_ship_count' => 'Count',
	'table_order_ship_cost' => 'Sum',
);

// 1.7.0
// Months
$_['module_months'] = array(
	'January', 'February', 'March',
	'April', 'May', 'June',
	'July', 'August', 'September',
	'October', 'November', 'December'
);

// 1.7.0
// Client Report Mode
$_['module_client_report_mode'] = array(
	'Standard',
	'Search only registered (no shopping)',
	'Search lost customers'
);

// Error
$_['error_permission']    = 'You are not authorized to change the module IMReport!';
$_['lic_permission'] = 'Enter license parameters';

////////////////////////////////////////////
// Translate List
////////////////////////////////////////////
$_['module_standard_onoff'] = array(
	'Off',
	'On'
);

// 2.1.0
$_['module_list_iconv_enc_csv'] = array(
	'Windows-1251',
	'UTF-8 (BOM)',
	'Set no encoding',
);

// 2.5.0
$_['module_list_group_by_time'] = array(
	'Day',
	'Week',
	'Month',
	'Year',
);

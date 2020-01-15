<?php
$_['heading_title']      = 'SberBank acquiring - Two stage';
$_['entry_userName']     = 'Login API';
$_['entry_password']     = 'Password API';
$_['entry_komis'] 		 = 'Commission or discount from the buyer<br/><small>For discount set minus</small>';
$_['entry_fixen']        = 'Pay amount';
$_['entry_fixen_order']  = 'Order';
$_['entry_fixen_proc']   = 'Percent of order';
$_['entry_fixen_fix']    = 'Fix';
$_['entry_fixen_amount'] = 'Sum or Percent for pay';
$_['entry_minpay'] 		 = 'The minimum amount of the order (ate less then the method is not displayed)';
$_['entry_maxpay'] 		 = 'The maximum amount of the order (ate more then the method is not displayed)';
$_['entry_on_status']    = 'Order status after a failed or expected payment';
$_['entry_order_status'] = 'Status after successful payment';
$_['entry_geo_zone']     = 'Region availability payment';
$_['entry_status']       = 'Status';
$_['entry_sort_order']   = 'Sort';
$_['entry_style']        = 'View button to the style of the theme';
$_['text_payment']       = 'Payment';
$_['text_order']         = 'Orders';
$_['status_title']       = 'Paid orders';
$_['text_success']       = 'The settings are saved';
$_['text_my']       	 = 'Your';
$_['text_default']       = 'Default';

$_['entry_met']       			= 'Method of transaction';
$_['entry_met_odnostage']       = 'One-step';
$_['entry_met_preautoriz']      = 'Two-stage (with preauthorization)';

$_['entry_servadr']      					= 'Server address';
$_['entry_servadr_test']      					= 'Test payment <small>https://test.paymentgate.ru/testpayment/</small>';
$_['entry_servadr_real']      					= 'Real payment <small>https://pay.alfabank.ru/payment/</small>&nbsp&nbsp&nbsp';
$_['entry_servadr_self']      					= 'Self&nbsp&nbsp&nbsp';
$_['entry_self']      					= 'Self payment address<br/><small>Address format<br/>https://domainname.ru/xxxxx/xxxxx<br/>address near rest included/xxxxx</small>';

$_['entry_zapros']      					= 'Method<br/><small>If you take error SberBank error: code= without code, use method File_Get_Contents';
$_['entry_curl']      					= 'Curl (recomended)';
$_['entry_fgc']      					= 'File_Get_Contents (only if trouble with curl)';

$_['entry_currency']      					= 'Currency code<br/><small>You make answer in bank</small>';
$_['entry_currency_rub']      				= 'Default (643 - RUB)';
$_['entry_currency_self']      				= 'Self';
$_['entry_currency_self_text']      		= 'Self currency code';

$_['entry_currency_convert']      			= 'Shop currency<br/><small>convert if order in other currency</small>';

$_['entry_callbackemulate']      		= 'Check payment in success page';
$_['entry_callbackemulate_yes']      		= 'Yes';
$_['entry_callbackemulate_no']      		= 'No (only callback or without change payment status)';

$_['entry_sbacquiring_instruction'] = 'Instructions when ordering:<br/><small>Supports variables:<br/>$href$ - reference to the payment<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';
$_['entry_sbacquiring_instruction_tab']      = 'Use the instructions when ordering?';
$_['entry_sbacquiring_mail_instruction_tab']      = 'Use the instructions in the letter with the order?';
$_['entry_sbacquiring_mail_instruction']      = 'Instruction in a letter to the order:<br/><small>Supports variables:<br/>$href$ - reference to the payment<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';
$_['entry_sbacquiring_success_comment_tab']      = 'Used successfully in a letter to the buyer of your successful payment?';
$_['entry_sbacquiring_success_comment']      = 'Successfully the buyer in writing of successful payment:<br/><small>Supports variables:<br/>$orderid$ - order number<br/>$itogo$ - order amount</small>';
$_['entry_sbacquiring_name_tab']      = 'The text in the name of the method of payment?';
$_['entry_sbacquiring_name']      = 'Name of the method of payment';
$_['entry_sbacquiring_success_alert_admin_tab']      = 'Mail to the administrator upon successful payment';
$_['entry_sbacquiring_success_alert_customer_tab']      = 'Letter to the buyer upon successful payment';
$_['entry_sbacquiring_success_page_tab']      = 'Your text on the page successful payment?';
$_['entry_sbacquiring_success_page_text']      = 'Text on the page successful payment:<br/><small>Supports variables:<br/>$href$ - reference to the payment<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';
$_['entry_sbacquiring_waiting_page_tab']      = 'Your text on the page of the expected payment?';
$_['entry_sbacquiring_waiting_page_text']      = 'The text on the page, the expected payment:<br/><small>Supports variables:<br/>$href$ - reference to the payment<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';
$_['entry_button_later']      = 'Button to pay later in the ordering process';

$_['entry_sbacquiring_hrefpage_tab']      = 'Your text on the page after following a link from an email or from your account?';
$_['entry_sbacquiring_hrefpage']      = 'Text on the page after following a link from an email or from your account:<br/><small>Supports variables:<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';

$_['text_createorder_or_notcreate']       = 'Create order after payment<br/><small>If "No" then the order at once creators, independent of whether or not payment has passed.</small>';

$_['pay_text_mail'] 								= 'Go to the payment by the link';
$_['pay_text_admin'] 								= 'Link for online pay:';

$_['entry_fail_page_tab']      = 'Your text on the page fail payment?';
$_['entry_fail_page_text']     = 'Text on the page fail payment:<br/><small>Supports variables:<br/>$href$ - reference to the payment<br/>$orderid$ - order number<br/>$itogo$ - order amount<br/>$komis$ - comission Percentage<br/>$total-komis$ - calculate the commission of the amount<br/>$plus-komis$ - programming with the Commission<br/>as well as html tags.</small>';


//Errors
$_['entry_license'] = 'License key';

$_['error_license']    = 'Enter the license key!<br/><small>Buy a key, you can at http://store.pe-art.ru</small>';
$_['error_key_er']     = 'Invalid license key!<br/><small>The key is only valid for a single domain. Buy a key, you can buy http://store.pe-art.ru</small>';
$_['error_shopId']    = 'Enter the ID of the counterparty (shopId) resulting from Yandex.money';
$_['error_scid'] 	  = 'Enter the number of showcase counterparty (scid) resulting from Yandex.money';
$_['error_password']  = 'Enter the secret word';

//Status page
$_['yandex_id']   = 'ID';
$_['num_order']   = 'Order number';
$_['sum']   = 'Sum';
$_['user']   = 'User';
$_['email']   = 'email';
$_['date_created']   = 'Date created';
$_['date_enroled']   = 'Date enroled';
$_['sender']   = 'Transaction Identifier';

?>
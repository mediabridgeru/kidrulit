<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="view/template/sale/documents/order_fact.stylesheet.css" />
</head>
<body link=blue vlink=purple>
<?php $count = 0; foreach ($orders as $order) { 
 $count++;
 $totals = array('kol'=>0, 'sum_wo_nds'=>0, 'sum_nds'=>0, 'sum_w_nds' => 0);
 ?>
<br>
<br>
 <div <? if (count($orders)>1){ print 'style="page-break-after: always;"';} ?> >
<table border=0 cellpadding=0 cellspacing=0 width=1243 style='border-collapse:
 collapse;table-layout:fixed;width:936pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <col class=xl65 width=202 style='mso-width-source:userset;mso-width-alt:8618;
 width:152pt'>
 <col class=xl65 width=37 style='mso-width-source:userset;mso-width-alt:1578;
 width:28pt'>
 <col class=xl65 width=15 style='mso-width-source:userset;mso-width-alt:640;
 width:11pt'>
 <col class=xl65 width=32 style='mso-width-source:userset;mso-width-alt:1365;
 width:24pt'>
 <col class=xl65 width=28 style='mso-width-source:userset;mso-width-alt:1194;
 width:21pt'>
 <col class=xl65 width=8 style='mso-width-source:userset;mso-width-alt:341;
 width:6pt'>
 <col class=xl65 width=50 style='mso-width-source:userset;mso-width-alt:2133;
 width:38pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=55 style='mso-width-source:userset;mso-width-alt:2346;
 width:41pt'>
 <col class=xl65 width=42 style='mso-width-source:userset;mso-width-alt:1792;
 width:32pt'>
 <col class=xl65 width=36 style='mso-width-source:userset;mso-width-alt:1536;
 width:27pt'>
 <col class=xl65 width=21 style='mso-width-source:userset;mso-width-alt:896;
 width:16pt'>
 <col class=xl65 width=62 style='mso-width-source:userset;mso-width-alt:2645;
 width:47pt'>
 <col class=xl65 width=14 style='mso-width-source:userset;mso-width-alt:597;
 width:11pt'>
 <col class=xl65 width=49 style='mso-width-source:userset;mso-width-alt:2090;
 width:37pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=89 style='mso-width-source:userset;mso-width-alt:3797;
 width:67pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=63 style='mso-width-source:userset;mso-width-alt:2688;
 width:47pt'>
 <col class=xl65 width=16 style='mso-width-source:userset;mso-width-alt:682;
 width:12pt'>
 <col class=xl65 width=75 style='mso-width-source:userset;mso-width-alt:3200;
 width:56pt'>
 <col class=xl65 width=28 style='mso-width-source:userset;mso-width-alt:1194;
 width:21pt'>
 <col class=xl65 width=60 style='mso-width-source:userset;mso-width-alt:2560;
 width:45pt'>
 <col class=xl65 width=80 style='mso-width-source:userset;mso-width-alt:3413;
 width:60pt'>
 <col class=xl65 width=129 style='mso-width-source:userset;mso-width-alt:5504;
 width:97pt'>
 <col class=xl65 width=5 style='mso-width-source:userset;mso-width-alt:213;
 width:4pt'>
 <tr class=xl65 height=74 style='mso-height-source:userset;height:56.1pt'>
  <td colspan=27 height=74 class=xl85 width=1238 style='height:56.1pt;
  width:932pt'>Приложение № 1<br>
    к постановлению Правительства Российской Федерации<br>
    от 26 декабря 2011 г. № 1137</td>
  <td class=xl65 width=5 style='width:4pt'></td>
 </tr>
 <tr class=xl65 height=25 style='mso-height-source:userset;height:18.95pt'>
  <td height=25 class=xl65 style='height:18.95pt'></td>
  <td class=xl66 colspan=12 style='mso-ignore:colspan'>Счет-фактура № <input type='text' class='noborder' style='font-size: 16px'> от <? print $order['date_rus']; ?> г.</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=25 style='mso-height-source:userset;height:18.95pt'>
  <td height=25 class=xl65 style='height:18.95pt'></td>
  <td class=xl67 colspan=2 style='mso-ignore:colspan'>Исправление № -- от --</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Продавец: <? print $order['store_name']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Адрес: <? print $order['store_address']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>ИНН/КПП продавца:
  2224103849/220945002</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Грузоотправитель и его адрес: <? print $order['store_name']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Грузополучатель и его адрес: <? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>К
  платежно-расчетному документу № -- от --</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Покупатель: <? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>Адрес:</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=26 class=xl68 width=1231 style='width:927pt'>ИНН/КПП покупателя:</td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl69 colspan=4 style='mso-ignore:colspan'>Валюта: наименование, код Российский рубль, 643</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=44 style='mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl65 style='height:33.0pt'></td>
  <td colspan=2 rowspan=2 class=xl86 width=239 style='width:180pt'>Наименование
  товара (описание выполненных работ, оказанных услуг), имущественного права</td>
  <td colspan=5 class=xl86 width=133 style='width:100pt'>Единица<br>
    измерения</td>
  <td colspan=2 rowspan=2 class=xl86 width=68 style='width:51pt'>Коли-<br>
    чество <br>
    (объем)</td>
  <td colspan=2 rowspan=2 class=xl86 width=78 style='width:59pt'>Цена (тариф)
  за единицу измерения</td>
  <td colspan=3 rowspan=2 class=xl86 width=97 style='width:74pt'>Стоимость
  товаров (работ, услуг), имущественных прав без налога - всего</td>
  <td colspan=2 rowspan=2 class=xl86 width=62 style='width:47pt'>В том<br>
    числе<br>
    сумма <br>
    акциза</td>
  <td rowspan=2 class=xl86 width=89 style='width:67pt'>Налоговая ставка</td>
  <td colspan=4 rowspan=2 class=xl86 width=93 style='width:70pt'>Сумма налога,
  предъявляемая покупателю</td>
  <td colspan=2 rowspan=2 class=xl87 width=103 style='width:77pt'>Стоимость
  товаров (работ, услуг), имущественных прав с налогом - всего</td>
  <td colspan=2 class=xl87 width=140 style='border-left:none;width:105pt'>Страна<br>
    происхождения товара</td>
  <td rowspan=2 class=xl87 width=129 style='width:97pt'>Номер<br>
    таможенной<br>
    декларации</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=44 style='mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl65 style='height:33.0pt'></td>
  <td colspan=2 class=xl88>код</td>
  <td colspan=3 class=xl86 width=86 style='width:65pt'>условное обозначение
  (национальное)</td>
  <td class=xl70 width=60 style='border-left:none;width:45pt'>цифровой код</td>
  <td class=xl70 width=80 style='border-left:none;width:60pt'>краткое
  наименование</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=2 class=xl71>1</td>
  <td colspan=2 class=xl71>2</td>
  <td colspan=3 class=xl72>2а</td>
  <td colspan=2 class=xl71>3</td>
  <td colspan=2 class=xl71>4</td>
  <td colspan=3 class=xl71>5</td>
  <td colspan=2 class=xl71>6</td>
  <td class=xl71>7</td>
  <td colspan=4 class=xl71>8</td>
  <td colspan=2 class=xl73>9</td>
  <td class=xl71 style='border-left:none'>10</td>
  <td class=xl72>10а</td>
  <td class=xl73>11</td>
  <td class=xl65></td>
 </tr>
  <? if ($order['product']){
	 
	 $product_count = 0;
	 foreach($order['product'] as $product){
	 $product_count++;
	 ?>
 <tr class=xl69 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td height=29 class=xl69 style='height:21.95pt'></td>
  <td colspan=2 class=xl74 width=239 style='width:180pt;padding-left: 10px;vertical-align:middle;'><? print $product['name']; ?></td>
  <td colspan=2 class=xl75 style='border-left:none;text-align: center;vertical-align: middle'>796</td>
  <td colspan=3 class=xl75 style='border-left:none;text-align: center;vertical-align: middle'>шт</td>
  <td colspan=2 class=xl89 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['quantity']; ?></td>
  <td colspan=2 class=xl90 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['free_nds']; ?></td>
  <td colspan=3 class=xl90 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['free_nds']; ?></td>
  <td colspan=2 class=xl91 style='border-left:none;text-align: center;vertical-align: middle'>без акциза</td>
  <td class=xl75 style='border-top:none;border-left:none;text-align: center;vertical-align: middle'><? print round($product['tax'],0); ?>%</td>
  <td colspan=4 class=xl90 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['nds']; ?></td>
  <td colspan=2 class=xl90 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['total']; ?></td>
  <td class=xl74 width=60 style='border-top:none;border-left:none;width:45pt;text-align: center;vertical-align: middle'>--</td>
  <td class=xl74 width=80 style='border-top:none;border-left:none;width:60pt;text-align: center;vertical-align: middle'>--</td>
  <td class=xl74 width=129 style='border-top:none;border-left:none;width:97pt;text-align: center;vertical-align: middle'>--</td>
  <td class=xl69></td>
 </tr>
  <? 
    $totals['kol']+=$product['quantity'];
    $totals['sum_wo_nds'] += $product['free_nds'];
    $totals['sum_nds'] += $product['nds'];
	$totals['sum_w_nds'] += $product['total'];
  } }?>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl77 style='border-top:none'>Всего к оплате</td>
  <td class=xl76 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td class=xl78 style='border-top:none'>&nbsp;</td>
  <td colspan=3 class=xl93 style='text-align: center;vertical-align: middle'><? print number_format($totals['sum_wo_nds'],2); ?></td>
  <td colspan=2 class=xl94 style='border-left:none;text-align: center;vertical-align: middle'>Х</td>
  <td class=xl79 style='border-top:none'>&nbsp;</td>
  <td colspan=4 class=xl95 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($totals['sum_nds'],2); ?></td>
  <td colspan=2 class=xl93 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($totals['sum_w_nds'],2); ?></td>
  <td class=xl80 style='border-top:none'>&nbsp;</td>
  <td class=xl80 style='border-top:none'>&nbsp;</td>
  <td class=xl80 style='border-top:none'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=15 style='height:11.45pt'>
  <td height=15 class=xl65 style='height:11.45pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td height=29 class=xl65 style='height:21.95pt'></td>
  <td class=xl68 width=202 style='width:152pt'>Руководитель организации<br>
    или иное уполномоченное лицо</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl96 width=160 style='width:121pt'><? print $order['owner']; ?></td>
  <td colspan=5 class=xl68 width=182 style='width:138pt'>Главный
  бухгалтер<br>
    или иное уполномоченное лицо</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=3 class=xl96 width=154 style='width:115pt'><? print $order['buh']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl65 style='height:9.0pt'></td>
  <td class=xl65></td>
  <td colspan=4 class=xl97>(подпись)</td>
  <td class=xl65></td>
  <td colspan=4 class=xl97>(ф.и.о.)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=3 class=xl82 align=center style='mso-ignore:colspan'>(подпись)</td>
  <td class=xl65></td>
  <td colspan=3 class=xl97>(ф.и.о.)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=18 style='mso-height-source:userset;height:14.1pt'>
  <td height=18 class=xl65 style='height:14.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 class=xl98><? print $order['store_rk_dov']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=3 class=xl98><? print $order['store_buh_dov']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td colspan=2 height=29 class=xl99 width=209 style='height:21.95pt;
  width:157pt'>Индивидуальный предприниматель</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl96 width=160 style='width:121pt'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=10 class=xl100 width=395 style='width:298pt'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=21 style='mso-height-source:userset;height:15.95pt'>
  <td height=21 class=xl65 style='height:15.95pt'></td>
  <td class=xl65></td>
  <td colspan=4 class=xl97>(подпись)</td>
  <td class=xl65></td>
  <td colspan=4 class=xl97>(ф.и.о.)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=10 class=xl83 align=center width=395 style='mso-ignore:colspan;
  width:298pt'>(реквизиты свидетельства о государственной <br>
    регистрации индивидуального предпринимателя)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>

</table>
</div>
<br>
<br>

<? } ?>
<? if ($count == 0){ ?>
 <br><br>
 <div style='margin: 0 auto; width:200px; height: 200px;'><? print $entry_not_selected; ?></div>
<? } ?>
</body>

</html>
<style>
.noborder{
 border: 0px !important;
 text-align: center;
 font-weight: bold;
 text-transform: uppercase;
 font-size: 16px;
}
</style>
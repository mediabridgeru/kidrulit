<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="view/template/sale/documents/order_pko.stylesheet.css" />
</head>
<body>
<? $count = 0;?>
<?php foreach ($orders as $order) { $count++;?>
<br>
<br>
 <div style="page-break-after: always;">
<table border=0 cellpadding=0 cellspacing=0 width=714 style='border-collapse:
 collapse;table-layout:fixed;width:538pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <col class=xl65 width=70 style='mso-width-source:userset;mso-width-alt:2986;
 width:53pt'>
 <col class=xl65 width=44 style='mso-width-source:userset;mso-width-alt:1877;
 width:33pt'>
 <col class=xl65 width=70 style='mso-width-source:userset;mso-width-alt:2986;
 width:53pt'>
 <col class=xl65 width=63 style='mso-width-source:userset;mso-width-alt:2688;
 width:47pt'>
 <col class=xl65 width=60 style='mso-width-source:userset;mso-width-alt:2560;
 width:45pt'>
 <col class=xl65 width=88 style='mso-width-source:userset;mso-width-alt:3754;
 width:66pt'>
 <col class=xl65 width=57 style='mso-width-source:userset;mso-width-alt:2432;
 width:43pt'>
 <col class=xl65 width=33 style='mso-width-source:userset;mso-width-alt:1408;
 width:25pt'>
 <col class=xl65 width=14 span=2 style='mso-width-source:userset;mso-width-alt:
 597;width:11pt'>
 <col class=xl65 width=66 style='mso-width-source:userset;mso-width-alt:2816;
 width:50pt'>
 <col class=xl65 width=31 style='mso-width-source:userset;mso-width-alt:1322;
 width:23pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=39 style='mso-width-source:userset;mso-width-alt:1664;
 width:29pt'>
 <col class=xl65 width=38 style='mso-width-source:userset;mso-width-alt:1621;
 width:29pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <tr class=xl65 height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl65 width=7 style='height:9.0pt;width:5pt'></td>
  <td class=xl65 width=70 style='width:53pt'><? print $ko1;?></td>
  <td class=xl65 width=44 style='width:33pt'></td>
  <td class=xl65 width=70 style='width:53pt'></td>
  <td class=xl65 width=63 style='width:47pt'></td>
  <td class=xl65 width=60 style='width:45pt'></td>
  <td class=xl65 width=88 style='width:66pt'></td>
  <td class=xl65 width=57 style='width:43pt'></td>
  <td class=xl66 width=33 style='width:25pt'></td>
  <td class=xl67 width=14 style='width:11pt'></td>
  <td class=xl68 width=14 style='width:11pt'>&nbsp;</td>
  <td colspan=5 rowspan=2 class=xl102 width=187 style='width:141pt'><?php echo $order['store_name']; ?></td>
  <td class=xl65 width=7 style='width:5pt'></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65><? print $header_second; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl66></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 class=xl69 align=center style='mso-ignore:colspan'><? print $entry_org; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl71 colspan=4 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl103 width=90 style='width:68pt'><? print $entry_codes; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 class=xl72 align=center style='mso-ignore:colspan'><? print $entry_kwit; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=5 class=xl104 width=307 style='width:231pt'><?php echo $order['store_name']; ?></td>
  <td class=xl74><? print $entry_okud_form; ?></td>
  <td colspan=2 class=xl105 width=90 style='width:68pt'>0310001</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 class=xl104 width=187 style='width:141pt'><? print $entry_to_pko; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=5 class=xl75 align=center style='mso-ignore:colspan'><? print $entry_org; ?></td>
  <td class=xl74><? print $entry_okpo; ?></td>
  <td colspan=2 class=xl106>96973078</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl74>№</td>
  <td colspan=4 class=xl107><input type='text' class='noborder' id='order-no1' onkeyup="javascript:swap(this.value)" value="<? print $order['order_id']; ?>"></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=5 rowspan=2 class=xl108 width=307 style='width:231pt;text-align:center'><?php echo $order['store_name']; ?></td>
  <td class=xl76></td>
  <td colspan=2 rowspan=2 class=xl109 width=90 style='width:68pt'>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl74>от</td>
  <td colspan=4 class=xl107><?php echo $order['date_rus']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 class=xl78><? print $entry_get_from; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td colspan=5 class=xl79><? print $entry_struct; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl110 width=187 style='width:141pt;text-align: center'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=4 style='mso-height-source:userset;height:3.0pt'>
  <td height=4 class=xl65 style='height:3.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl65 style='height:21.0pt'></td>
  <td class="xl65 xl80"><? print $entry_pko; ?></td>
  <td class="xl65"></td>
  <td class=xl65></td>
  <td class=xl80></td>
  <td colspan=2 class=xl111 width=148 style='width:111pt'><? print $entry_num; ?></td>
  <td colspan=2 class=xl103 width=90 style='width:68pt'><? print $entry_date; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl112><input type='text' class='noborder'  onkeyup="javascript:swap(this.value)"  id='order-no2' value="<? print $order['order_id']; ?>"></td>
  <td colspan=2 class=xl112 style='border-left:none'><?php echo $order['date_added']; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 rowspan=2 class=xl65><? print $osn; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=8 style='mso-height-source:userset;height:6.0pt'>
  <td height=8 class=xl65 style='height:6.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl81 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl81 width=7 style='height:12.0pt;width:5pt'></td>
  <td rowspan=4 class=xl103 width=70 style='width:53pt'><? print $entry_debet; ?></td>
  <td colspan=4 class=xl103 width=237 style='border-left:none;width:178pt'><? print $entry_kredit; ?></td>
  <td rowspan=4 class=xl103 width=88 style='width:66pt'><? print $entry_sum; ?></td>
  <td rowspan=4 class=xl113 width=57 style='width:43pt'><? print $entry_kcn; ?></td>
  <td rowspan=4 class=xl103 width=33 style='width:25pt'>&nbsp;</td>
  <td class=xl82 width=14 style='width:11pt'></td>
  <td class=xl83 width=14 style='width:11pt'>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl110 width=187 style='width:141pt'>
  <?php print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  print $entry_from;  print $order['date_rus']; ?>
  </td>
  <td class=xl81 width=7 style='width:5pt'></td>
 </tr>
 <tr class=xl81 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl81 width=7 style='height:12.0pt;width:5pt'></td>
  <td rowspan=3 class=xl103 width=44 style='border-top:none;width:33pt'>&nbsp;</td>
  <td rowspan=3 class=xl114 width=70 style='border-top:none;width:53pt'><? print $entry_ksp; ?></td>
  <td rowspan=3 class=xl114 width=63 style='border-top:none;width:47pt'><? print $entry_ksss?></td>
  <td rowspan=3 class=xl114 width=60 style='border-top:none;width:45pt'><? print $entry_kod_au?></td>
  <td class=xl84 width=14 style='width:11pt'></td>
  <td class=xl85 width=14 style='width:11pt'>&nbsp;</td>
  <td class=xl81 width=7 style='width:5pt'></td>
 </tr>
 <tr class=xl81 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl81 width=7 style='height:12.0pt;width:5pt'></td>
  <td class=xl84 width=14 style='width:11pt'></td>
  <td class=xl85 width=14 style='width:11pt'>&nbsp;</td>
  <td class=xl81 width=7 style='width:5pt'></td>
 </tr>
 <tr class=xl81 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl81 width=7 style='height:12.0pt;width:5pt'></td>
  <td class=xl82 width=14 style='width:11pt'></td>
  <td class=xl83 width=14 style='width:11pt'>&nbsp;</td>
  <td class=xl81 width=66 style='width:50pt'></td>
  <td class=xl81 width=31 style='width:23pt'></td>
  <td class=xl81 width=13 style='width:10pt'></td>
  <td class=xl81 width=39 style='width:29pt'></td>
  <td class=xl81 width=38 style='width:29pt'></td>
  <td class=xl81 width=7 style='width:5pt'></td>
 </tr>
 <tr class=xl65 height=21 style='mso-height-source:userset;height:15.95pt'>
  <td height=21 class=xl65 style='height:15.95pt'></td>
  <td class=xl86>50.01</td>
  <td class=xl87 style='border-left:none'>&nbsp;</td>
  <td class=xl88 style='border-left:none'>&nbsp;</td>
  <td class=xl88 style='border-left:none'>62.01</td>
  <td class=xl88 style='border-left:none'>&nbsp;</td>
  <td class=xl89 style='text-align: center; border-left:none'><? print $order['index_nova'];  ?></td>
  <td class=xl88 style='border-left:none'>&nbsp;</td>
  <td class=xl90 style='border-left:none'>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65><? print $entry_sum_prop?></td>
  <td colspan=4 class=xl107>
  <? print $order['index_nova']; ?>
  </td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl79><? print $entry_digits; ?></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65><? print $entry_get_from; ?></td>
  <td class=xl78 colspan=4 style='mso-ignore:colspan'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl108 width=187 style='width:141pt;text-align: center'><? print $order['total_2_str'];?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=4 style='mso-height-source:userset;height:3.0pt'>
  <td height=4 class=xl65 style='height:3.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65><? print $entry_osn; ?></td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=8 rowspan=2 class=xl110 width=485 style='width:365pt'><? print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  ?> от <? print $order['date_rus']; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl91 style='border-top:none'><? print $entry_also; ?></td>
  <td colspan=4 class=xl79><? print $entry_prop; ?></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl115 width=187 style='width:141pt'><? print $entry_nds; ?> 
  <? print $order['all_nds']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl65><? print $entry_sum_prop; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl92></td>
  <td class=xl93>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=8 rowspan=2 class=xl108 width=485 style='width:365pt;text-align: center'><? print $order['products_order_total_prop'];?></td>
  <td class=xl92></td>
  <td class=xl93>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl94></td>
  <td class=xl95>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl107><? print $order['date_rus']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td colspan=8 class=xl79><? print $entry_prop; ?></td>
  <td class=xl92></td>
  <td class=xl93>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl96><? print $entry_also; ?></td>
  <td class=xl97 colspan=3 style='mso-ignore:colspan'><? print $entry_nds; print $order['all_nds']; ?></td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl98 colspan=2 style='mso-ignore:colspan'><? print $entry_mp; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl96><? print $entry_pril; ?></td>
  <td colspan=7 class=xl110 width=415 style='width:312pt'><?php print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  ?> от <? print $order['date_rus']; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl99 colspan=4 style='mso-ignore:colspan'><? print $entry_buh; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl98 colspan=2 style='mso-ignore:colspan'><? print $entry_buh; ?></td>
  <td class=xl100>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td colspan=3 class=xl108 width=178 style='width:134pt;text-align: center'><? print $order['buh']; ?></td>
  <td class=xl67></td>
  <td class=xl68>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=3 class=xl108 width=90 style='width:68pt;text-align: center'><? print $order['buh']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69 align=center><? print $entry_podp; ?></td>
  <td class=xl75>&nbsp;</td>
  <td class=xl69></td>
  <td colspan=3 class=xl116><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
  <td class=xl101>&nbsp;</td>
  <td class=xl79><? print $entry_podp; ?></td>
  <td class=xl65></td>
  <td colspan=3 class=xl69 align=center style='mso-ignore:colspan'><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl71 colspan=3 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl101>&nbsp;</td>
  <td class=xl98><? print $entry_kass; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl98 colspan=2 style='mso-ignore:colspan'><? print $entry_get_kass; ?></td>
  <td class=xl100>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td colspan=3 class=xl108 width=178 style='width:134pt;text-align: center'><? print $order['kass']; ?></td>
  <td class=xl65></td>
  <td class=xl101>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=3 class=xl108 width=90 style='width:68pt;text-align: center'><? print $order['kass']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69 align=center><? print $entry_podp; ?></td>
  <td class=xl75>&nbsp;</td>
  <td class=xl69></td>
  <td colspan=3 class=xl116><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
  <td class=xl101>&nbsp;</td>
  <td class=xl79><? print $entry_podp; ?></td>
  <td class=xl65></td>
  <td colspan=3 class=xl69 align=center style='mso-ignore:colspan'><? print $entry_podp_ras; ?></td>
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
<script language='javascript'>
function swap(val){
	var e = document.getElementById('order-no1');
	e.value = val;
	var e = document.getElementById('order-no2');
	e.value = val;
} 
</script>
<style>
.noborder{
 border: 0px !important;
 text-align: center;
}

</style>
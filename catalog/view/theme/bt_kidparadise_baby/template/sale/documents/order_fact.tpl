<?
if(isset($_GET['excel7'])){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=fact-" . time() . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
</head>
<body link=blue vlink=purple>
<?php $count = 0; foreach ($orders as $order) { 
 $count++;
 $totals = array('kol'=>0, 'sum_wo_nds'=>0, 'sum_nds'=>0, 'sum_w_nds' => 0);
 ?>
<br>
<br>
 <div <? if (count($orders)>1){ print 'style="page-break-after: always;"';} ?> >
<table border=0 cellpadding=0 cellspacing=0 width=1243 style='font-size:8.0pt;border-collapse:
 collapse;table-layout:fixed;width:936pt'>
 <col class=xl65 width=7 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:5pt'>
 <col class=xl65 width=202 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:8618;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:152pt'>
 <col class=xl65 width=37 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1578;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:28pt'>
 <col class=xl65 width=15 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:640;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:11pt'>
 <col class=xl65 width=32 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1365;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:24pt'>
 <col class=xl65 width=28 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1194;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:21pt'>
 <col class=xl65 width=8 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:341;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:6pt'>
 <col class=xl65 width=50 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2133;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:38pt'>
 <col class=xl65 width=13 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:10pt'>
 <col class=xl65 width=55 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2346;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:41pt'>
 <col class=xl65 width=42 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1792;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:32pt'>
 <col class=xl65 width=36 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1536;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:27pt'>
 <col class=xl65 width=21 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:896;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:16pt'>
 <col class=xl65 width=62 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2645;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:47pt'>
 <col class=xl65 width=14 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:597;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:11pt'>
 <col class=xl65 width=49 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2090;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:37pt'>
 <col class=xl65 width=13 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:10pt'>
 <col class=xl65 width=89 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:3797;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:67pt'>
 <col class=xl65 width=1 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:42;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:1pt'>
 <col class=xl65 width=13 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:10pt'>
 <col class=xl65 width=63 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2688;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:47pt'>
 <col class=xl65 width=16 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:682;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:12pt'>
 <col class=xl65 width=75 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:3200;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:56pt'>
 <col class=xl65 width=28 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1194;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:21pt'>
 <col class=xl65 width=60 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2560;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:45pt'>
 <col class=xl65 width=80 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:3413;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:60pt'>
 <col class=xl65 width=129 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:5504;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:97pt'>
 <col class=xl65 width=5 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:213;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;
 width:4pt'>
 <tr class=xl65 height=74 style='font-size:8.0pt;mso-height-source:userset;height:56.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td colspan=27 height=74 class=xl85 width=1238 style='font-size:8.0pt;height:56.1pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;vertical-align:top;white-space:normal;
  width:932pt'>Приложение № 1<br>
    к постановлению Правительства Российской Федерации<br>
    от 26 декабря 2011 г. № 1137</td>
  <td class=xl65 width=5 style='font-size:8.0pt;width:4pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=25 style='font-size:8.0pt;mso-height-source:userset;height:18.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=25 class=xl65 style='font-size:8.0pt;height:18.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 colspan=12 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:14.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'>Счет-фактура № ______<!--<input type='text' class='noborder' style='font-size:8.0pt;font-size: 16px'>--> от <? print $order['date_rus']; ?> г.</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=25 style='font-size:8.0pt;mso-height-source:userset;height:18.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=25 class=xl65 style='font-size:8.0pt;height:18.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl67 colspan=2 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:14.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>Исправление № -- от --</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Продавец: <? print $order['store_name']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Адрес: <? print $order['store_address']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>ИНН/КПП продавца:
  2224103849/220945002</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Грузоотправитель и его адрес: <? print $order['store_name']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Грузополучатель и его адрес: <? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>К
  платежно-расчетному документу № -- от --</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Покупатель: <? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Адрес:</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=26 class=xl68 width=1231 style='font-size:8.0pt;width:927pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>ИНН/КПП покупателя:</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl69 colspan=4 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'>Валюта: наименование, код Российский рубль, 643</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=44 style='font-size:8.0pt;mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl65 style='font-size:8.0pt;height:33.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=2 rowspan=2 class=xl86 width=239 style='font-size:8.0pt;width:180pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Наименование
  товара (описание выполненных работ, оказанных услуг), имущественного права</td>
  <td colspan=5 class=xl86 width=133 style='font-size:8.0pt;width:100pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Единица<br>
    измерения</td>
  <td colspan=2 rowspan=2 class=xl86 width=68 style='font-size:8.0pt;width:51pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Коли-<br>
    чество <br>
    (объем)</td>
  <td colspan=2 rowspan=2 class=xl86 width=78 style='font-size:8.0pt;width:59pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Цена (тариф)
  за единицу измерения</td>
  <td colspan=3 rowspan=2 class=xl86 width=97 style='font-size:8.0pt;width:74pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Стоимость
  товаров (работ, услуг), имущественных прав без налога - всего</td>
  <td colspan=2 rowspan=2 class=xl86 width=62 style='font-size:8.0pt;width:47pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>В том<br>
    числе<br>
    сумма <br>
    акциза</td>
  <td rowspan=2 class=xl86 width=89 style='font-size:8.0pt;width:67pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Налоговая ставка</td>
  <td colspan=4 rowspan=2 class=xl86 width=93 style='font-size:8.0pt;width:70pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>Сумма налога,
  предъявляемая покупателю</td>
  <td colspan=2 rowspan=2 class=xl87 width=103 style='font-size:8.0pt;width:77pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Стоимость
  товаров (работ, услуг), имущественных прав с налогом - всего</td>
  <td colspan=2 class=xl87 width=140 style='font-size:8.0pt;border-left:none;width:105pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Страна<br>
    происхождения товара</td>
  <td rowspan=2 class=xl87 width=129 style='font-size:8.0pt;width:97pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Номер<br>
    таможенной<br>
    декларации</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=44 style='font-size:8.0pt;mso-height-source:userset;height:33.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=44 class=xl65 style='font-size:8.0pt;height:33.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=2 class=xl88 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;	border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>код</td>
  <td colspan=3 class=xl86 width=86 style='font-size:8.0pt;width:65pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>условное обозначение
  (национальное)</td>
  <td class=xl70 width=60 style='font-size:8.0pt;border-left:none;width:45pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:none;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>цифровой код</td>
  <td class=xl70 width=80 style='font-size:8.0pt;border-left:none;width:60pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:none;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>краткое
  наименование</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=2 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>1</td>
  <td colspan=2 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>2</td>
  <td colspan=3 class=xl72 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:"0\0022а\0022";text-align:center;vertical-align:middle;	border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>2а</td>
  <td colspan=2 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>3</td>
  <td colspan=2 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>4</td>
  <td colspan=3 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>5</td>
  <td colspan=2 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>6</td>
  <td class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>7</td>
  <td colspan=4 class=xl71 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>8</td>
  <td colspan=2 class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>9</td>
  <td class=xl71 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>10</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:"0\0022а\0022";text-align:center;vertical-align:middle;	border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>10а</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:0;text-align:center;vertical-align:middle;border-top:none;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>11</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
  <? if ($order['product']){
	 
	 $product_count = 0;
	 foreach($order['product'] as $product){
	 $product_count++;
	 ?>
 <tr class=xl69 height=29 style='font-size:8.0pt;mso-height-source:userset;height:21.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'>
  <td height=29 class=xl69 style='font-size:8.0pt;height:21.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'></td>
  <td colspan=2 class=xl74 width=239 style='font-size:8.0pt;width:180pt;padding-left: 10px;vertical-align:middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;white-space:normal;'><? print $product['report_name']; ?></td>
  <td colspan=2 class=xl75 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;'>796</td>
  <td colspan=3 class=xl75 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;'>шт</td>
  <td colspan=2 class=xl89 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:"0\.000";text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['quantity']; ?></td>
  <td colspan=2 class=xl90 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['free_nds']; ?></td>
  <td colspan=3 class=xl90 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['free_nds']; ?></td>
  <td colspan=2 class=xl91 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;vertical-align:top;border:0.5pt solid black;'>без акциза</td>
  <td class=xl75 style='font-size:8.0pt;border-top:none;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;'><? print round($product['tax'],0); ?>%</td>
  <td colspan=4 class=xl90 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['nds']; ?></td>
  <td colspan=2 class=xl90 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['total']; ?></td>
  <td class=xl74 width=60 style='font-size:8.0pt;border-top:none;border-left:none;width:45pt;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;white-space:normal;'>--</td>
  <td class=xl74 width=80 style='font-size:8.0pt;border-top:none;border-left:none;width:60pt;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;white-space:normal;'>--</td>
  <td class=xl74 width=129 style='font-size:8.0pt;border-top:none;border-left:none;width:97pt;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;border:0.5pt solid black;white-space:normal;'>--</td>
  <td class=xl69 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'></td>
 </tr>
  <? 
    $totals['kol']+=$product['quantity'];
    $totals['sum_wo_nds'] += $product['free_nds'];
    $totals['sum_nds'] += $product['nds'];
	$totals['sum_w_nds'] += $product['total'];
  } }?>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl77 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>Всего к оплате</td>
  <td class=xl76 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=3 class=xl93 style='font-size:8.0pt;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Standard;text-align:right;border:0.5pt solid black;'><? print number_format($totals['sum_wo_nds'],2); ?></td>
  <td colspan=2 class=xl94 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>Х</td>
  <td class=xl79 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center-across;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=4 class=xl95 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print number_format($totals['sum_nds'],2); ?></td>
  <td colspan=2 class=xl93 style='font-size:8.0pt;border-left:none;text-align: center;vertical-align: middle;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Standard;text-align:right;border:0.5pt solid black;'><? print number_format($totals['sum_w_nds'],2); ?></td>
  <td class=xl80 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl80 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl80 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr height=15 style='font-size:8.0pt;height:11.45pt'>
  <td height=15 class=xl65 style='font-size:8.0pt;height:11.45pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=29 style='font-size:8.0pt;mso-height-source:userset;height:21.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=29 class=xl65 style='font-size:8.0pt;height:21.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl68 width=202 style='font-size:8.0pt;width:152pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Руководитель организации<br>
    или иное уполномоченное лицо</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl96 width=160 style='font-size:8.0pt;width:121pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['owner']; ?></td>
  <td colspan=5 class=xl68 width=182 style='font-size:8.0pt;width:138pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Главный
  бухгалтер<br>
    или иное уполномоченное лицо</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=3 class=xl96 width=154 style='font-size:8.0pt;width:115pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['buh']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=12 style='font-size:8.0pt;mso-height-source:userset;height:9.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=12 class=xl65 style='font-size:8.0pt;height:9.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl97 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:top;'>(подпись)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl97 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:top;'>(ф.и.о.)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=3 class=xl82 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center-across;vertical-align:top;'>(подпись)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=3 class=xl97 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:top;'>(ф.и.о.)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=18 style='font-size:8.0pt;mso-height-source:userset;height:14.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=18 class=xl65 style='font-size:8.0pt;height:14.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl98 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'><? print $order['store_rk_dov']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=3 class=xl98 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'><? print $order['store_buh_dov']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=29 style='font-size:8.0pt;mso-height-source:userset;height:21.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td colspan=2 height=29 class=xl99 width=209 style='font-size:8.0pt;height:21.95pt;
  width:157pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;white-space:normal;'>Индивидуальный предприниматель</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl81 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;	border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl96 width=160 style='font-size:8.0pt;width:121pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=10 class=xl100 width=395 style='font-size:8.0pt;width:298pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=21 style='font-size:8.0pt;mso-height-source:userset;height:15.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=21 class=xl65 style='font-size:8.0pt;height:15.95pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl97 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:top;'>(подпись)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=4 class=xl97 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:top;'>(ф.и.о.)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td colspan=10 class=xl83 align=center width=395 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center-across;white-space:normal;
  width:298pt'>(реквизиты свидетельства о государственной <br>
    регистрации индивидуального предпринимателя)</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>

</table>
</div>
<br>
<br>

<? } ?>
<? if ($count == 0){ ?>
 <br><br>
 <div style='font-size:8.0pt;margin: 0 auto; width:200px; height: 200px;'><? print $entry_not_selected; ?></div>
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
tr
	{mso-height-source:auto;}
col
	{mso-width-source:auto;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	border:none;
	mso-protection:locked visible;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
</style>
<?//if (isset($library)){require_once $library . 'ocbase_documents.php';}?>
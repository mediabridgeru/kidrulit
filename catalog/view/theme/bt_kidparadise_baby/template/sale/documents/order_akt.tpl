<?
if(isset($_GET['excel7'])){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=act-" . time() . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
</head>
<body link=blue vlink=purple>
<? $count = 0;?>
<?php foreach ($orders as $order) { $count++;?>
<br>
<br>
<table border=0 cellpadding=0 cellspacing=0 width="800" style='font-size:8.0pt;border-collapse:collapse;table-layout:fixed;width:633pt'>
<colgroup>
    <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;width:5pt'>
    <col class=xl65 width=40 style='mso-width-source:userset;mso-width-alt:1706;mso-style-parent:style0;text-align:left;width:30pt'>
    <col class=xl65 width=30 style='mso-width-source:userset;mso-width-alt:3029;mso-style-parent:style0;text-align:left;width:23pt'>
    <col class=xl65 width=14 style='mso-width-source:userset;mso-width-alt:597;mso-style-parent:style0;text-align:left;width:15pt'>
    <col class=xl65 width=91 style='mso-width-source:userset;mso-width-alt:3882;mso-style-parent:style0;text-align:left;width:68pt'>
    <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:14pt'>
    <col class=xl65 width=12 style='mso-width-source:userset;mso-width-alt:512;mso-style-parent:style0;text-align:left;width:9pt'>
    <col class=xl65 width=65 style='mso-width-source:userset;mso-width-alt:2773;mso-style-parent:style0;text-align:left;width:49pt'>
    <col class=xl65 width=39 style='mso-width-source:userset;mso-width-alt:1664;mso-style-parent:style0;text-align:left;width:33pt'>
    <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left;width:10pt'>

    <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;width:5pt'>
    <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;mso-style-parent:style0;text-align:left;width:5pt'>
    <col class=xl65 width=39 style='mso-width-source:userset;mso-width-alt:1664;mso-style-parent:style0;text-align:left;width:29pt'>
    <col class=xl65 width=42 style='mso-width-source:userset;mso-width-alt:1792;mso-style-parent:style0;text-align:left;width:32pt'>
    <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:14pt'>
    <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left;width:19pt'>
    <col class=xl65 width=3 style='mso-width-source:userset;mso-width-alt:128;mso-style-parent:style0;text-align:left; width:2pt'>
    <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left; width:10pt'>
    <col class=xl65 width=27 style='mso-width-source:userset;mso-width-alt:1152;mso-style-parent:style0;text-align:left; width:20pt'>
    <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left; width:10pt'>

    <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:14pt'>
    <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left;width:19pt'>
    <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;mso-style-parent:style0;text-align:left;width:15pt'>
    <col class=xl65 width=22 style='mso-width-source:userset;mso-width-alt:938;mso-style-parent:style0;text-align:left;width:17pt'>
    <col class=xl65 width=36 style='mso-width-source:userset;mso-width-alt:1749;mso-style-parent:style0;text-align:left;width:25pt'>
    <col class=xl65 width=21 style='mso-width-source:userset;mso-width-alt:1920;mso-style-parent:style0;text-align:left;width:15pt'>
    <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;mso-style-parent:style0;text-align:left;width:8pt'>
    <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left;width:19pt'>
    <col class=xl65 width=9 style='mso-width-source:userset;mso-width-alt:170;mso-style-parent:style0;text-align:left;width:7pt'>
    <col class=xl65 width=17 style='mso-width-source:userset;mso-width-alt:896;mso-style-parent:style0;text-align:left;width:12pt'>

    <col class=xl65 width=51 style='mso-width-source:userset;mso-width-alt:2176;mso-style-parent:style0;text-align:left;width:38pt'>
    <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;mso-style-parent:style0;text-align:left;width:1pt'>
    <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;mso-style-parent:style0;text-align:left;width:8pt'>
</colgroup>
 <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr class=xl65 style='font-size:8.0pt;mso-height-source:userset;width:16pt;mso-style-parent:style0;text-align:left;'>
  <td height="29" class="xl65" style="font-size:8.0pt;height:21.95pt;width:16pt;mso-style-parent:style0;text-align:left;">&nbsp;</td>
  <td colspan="2" class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;text-align:left;border-bottom:0.5pt solid black;'>&nbsp;</td>
  <td colspan="29" class=xl73 style='mso-style-parent:style0;font-size:14.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;border-bottom:0.5pt solid black;'>Акт № <? print $order['order_id']; ?><? print $entry_from.$order['date_rus']; ?></td>
  <td class=xl65  style='font-size:8.0pt;width:16pt;mso-style-parent:style0;text-align:left;border-bottom:0.5pt solid black;'></td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 height="53" style='font-size:9.0pt;width:16pt;mso-style-parent:style0;height:40pt;'></td>
  <td colspan="3" class=xl74 style='mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'>Исполнитель:</td>
  <td colspan="29" class=xl75 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><? echo $order['store_org'].', ИНН '.$order['store_inn'].', '.$order['store_address'].', тел.: '.$order['store_telephone'].', '.$order['store_requisites']; ?></td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 height="47" style='font-size:8.0pt;width:16pt;mso-style-parent:style0;height:35pt;'></td>
  <td colspan="3" class=xl74 style='mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'>Заказчик:</td>
  <td colspan="29" class=xl75 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><? echo $order['payment_address'] . ', тел.: ' . $order['telephone']; ?></td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 height="29" style='font-size:8.0pt;width:16pt;mso-style-parent:style0;text-align:left;height:21.95pt;'></td>
  <td class=xl76 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;'>№</td>
  <td colspan="18" class=xl77 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:.5pt solid black;white-space:normal;'>Наименование,
  характеристика, артикул работ, услуг</td>
  <td colspan=3 class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:.5pt solid black;'>Кол-во</td>
  <td colspan=2 class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:.5pt solid black;'>Ед.</td>
  <td colspan=4 class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:.5pt solid black;'>Цена</td>
  <td colspan=4 class=xl79 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:.5pt solid black;'>Сумма</td>
 </tr>
 <?
	 $count = 0;
	 foreach($order['total'] as $total){
	 if ($total['code']!='shipping') continue;
	 $count++;
	 ?>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 height="29" style='font-size:9.0pt;width:16pt;mso-style-parent:style0;text-align:left;height:21.95pt;'></td>
  <td class=xl80 style='font-size:9.0pt;mso-style-parent:style0;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:.5pt solid black;border-bottom:.5pt solid black;border-left:0.5pt solid black;'><? print $count;?></td>
  <td colspan="18" class=xl81 width=364 style='font-size:9.0pt;mso-style-parent:style0;text-align:left;vertical-align:middle;border-top:.5pt solid black;border-bottom:.5pt solid black;border-left:.5pt solid black;white-space:normal;'><? print $total['title']; ?></td>
  <td colspan=3 class=xl82 width=63 style='font-size:9.0pt;width:48pt;mso-style-parent:style0;mso-number-format:"0";text-align:right;vertical-align:middle;border-top:.5pt solid black;border-bottom:.5pt solid black;border-left:.5pt solid black;white-space:normal;'>1</td>
  <td colspan=2 class=xl81 width=42 style='font-size:9.0pt;width:32pt;mso-style-parent:style0;text-align:left;vertical-align:middle;border-top:.5pt solid black;border-bottom:.5pt solid black;border-left:.5pt solid black;white-space:normal;'>&nbsp;</td>
  <td colspan=4 class=xl83 width=84 style='font-size:9.0pt;width:64pt;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:middle;border-top:.5pt solid black;border-bottom:.5pt solid black;border-left:.5pt solid black;white-space:normal;'><? print number_format($total['text'], 2, ',', ' '); ?></td>
  <td colspan=4 class=xl84 width=84 style='font-size:9.0pt;width:64pt;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:middle;border-top:.5pt solid black;border-right:0.5pt solid black;border-bottom:.5pt solid black;border-left:.5pt solid black;white-space:normal;'><? print number_format($total['text'], 2, ',', ' '); ?></td>
 </tr>
 <? //}  ?>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <? $total_summ = ''; ?>
    <tr>
        <td class=xl65 style='font-size:9.0pt;width:16pt;mso-style-parent:style0;'></td>
        <td class=xl65 colspan="24" style='font-size:9.0pt;mso-style-parent:style0;'></td>
        <td class=xl65 colspan="4" style='font-size:9.0pt;mso-style-parent:style0;text-align:right;'>Итого:<? //print $total['title'];?></td>
        <td class=xl65 colspan="4" style='font-size:9.0pt;mso-style-parent:style0;text-align:right;mso-number-format:Fixed;'><? print number_format($total['text'], 2, ',', ' '); ?></td>
    </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan="32" class=xl86 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'><? print $entry_all_naim.' '.$count; ?>, <? print $entry_to_summ.' ' . number_format($total['text'], 2, ',', ' ');
  ?></td>
 </tr>
 <tr>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan=31 class=xl75 width=658 style='width:501pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><? print $order['shipping_method']; ?></td>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <? } ?>
 <tr style='font-size:8.0pt;mso-height-source:userset;'>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan=32 class=xl87 style='mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;white-space:normal;'>Вышеперечисленные
  услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и
  срокам оказания услуг не имеет.</td>
 </tr>
 <tr class=xl65 style='font-size:8.0pt;mso-height-source:userset;'>
     <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'>&nbsp;</td>
  <td colspan="32" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;border-bottom:.5pt solid black;'>&nbsp;</td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan="3" class=xl88 width=133 style='font-size:8.0pt;width:101pt;mso-style-parent:style0;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;white-space:normal;'>Руководитель</td>
  <td class=xl69 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan="7" class=xl89 width=147 style='width:112pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:.5pt solid black;border-left:none;white-space:normal;'><? print $order['owner']; ?></td>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan="5" class=xl70 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'>Заказчик</td>
  <td class=xl71 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-left:none;'>&nbsp;</td>
  <td colspan="12" class=xl89 width=147 style='width:112pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:.5pt solid black;border-left:none;white-space:normal;'><? print strtoupper($order['firstname'].' '.$order['lastname']); ?></td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;border:none;'>&nbsp;</td>
     <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;border:none;'>&nbsp;</td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:4.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 <tr>
  <td class=xl65 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;'></td>
  <td colspan="10" class=xl90 style='font-size:8.0pt;mso-style-parent:style0;text-align:right;border:none;'>Доверенность <? print $order['store_rk_dov']; ?></td>
  <td colspan="21" class=xl91 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
 </tr>
    <tr><td colspan="33" class=xl65 style='font-size:8.0pt;mso-style-parent:style0;'>&nbsp;</td></tr>
 </table>
<? } ?>
<? if ($count == 0){ ?>
 <br><br>
 <div style='font-size:8.0pt;margin: 0 auto; width:200px; height: 200px;'><? print $entry_not_selected; ?></div>
<? } ?>
</body>

</html>
<style>
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
	mso-style-name:ќбычный;
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
<? //require_once $library . 'ocbase_documents.php';?>
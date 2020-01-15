<?
if(isset($_GET['excel7'])){
$name = 'name';
if(!empty($orders)){
$name = $orders[0]['order_id'];
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=torg12-" . $name . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <style type="text/css" media="print">
        @page {
            size: landscape;
        }
    </style>
</head>

<body link=blue vlink=purple style='font-size:8.0pt;'>
<?php $count = 0; foreach ($orders as $order) {
 $count++;
 $totals = array('kol'=>0, 'sum_wo_nds'=>0, 'sum_nds'=>0, 'sum_w_nds' => 0);
 ?>
<br>
<br>
 <div <? if (count($orders)>1){ print 'style="page-break-after: always;"';} ?> >
<table border=0 cellpadding=0 cellspacing=0 width=1100 style='border-collapse:collapse;table-layout:fixed;width:1440px'>
<colgroup>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;width:5pt'>
 <col class=xl65 width=40 style='mso-width-source:userset;mso-width-alt:1706;mso-style-parent:style0;text-align:left;width:30pt'>
 <col class=xl65 width=71 style='mso-width-source:userset;mso-width-alt:3029;mso-style-parent:style0;text-align:left;width:53pt'>
 <col class=xl65 width=14 style='mso-width-source:userset;mso-width-alt:597;mso-style-parent:style0;text-align:left;width:11pt'>
 <col class=xl65 width=91 style='mso-width-source:userset;mso-width-alt:3882;mso-style-parent:style0;text-align:left;width:68pt'>
 <col class=xl65 width=24 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:18pt'>
 <col class=xl65 width=24 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:18pt'>
 <col class=xl65 width=48 style='mso-width-source:userset;mso-width-alt:2400;mso-style-parent:style0;text-align:left;width:36pt'>
 <col class=xl65 width=30 style='mso-width-source:userset;mso-width-alt:1264;mso-style-parent:style0;text-align:left;width:24pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left;width:10pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;width:5pt'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;mso-style-parent:style0;text-align:left;width:5pt'>
 <col class=xl65 width=30 style='mso-width-source:userset;mso-width-alt:1664;mso-style-parent:style0;text-align:left;width:21pt'>
 <col class=xl65 width=30 style='mso-width-source:userset;mso-width-alt:1792;mso-style-parent:style0;text-align:left;width:21pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:14pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left; width:19pt'>
 <col class=xl65 width=3 style='mso-width-source:userset;mso-width-alt:128;mso-style-parent:style0;text-align:left; width:2pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left; width:10pt'>
 <col class=xl65 width=27 style='mso-width-source:userset;mso-width-alt:1152;mso-style-parent:style0;text-align:left; width:20pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left; width:10pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;
 width:14pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left;
 width:19pt'>
 <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;mso-style-parent:style0;text-align:left;
 width:15pt'>
 <col class=xl65 width=22 style='mso-width-source:userset;mso-width-alt:938;mso-style-parent:style0;text-align:left;
 width:17pt'>
 <col class=xl65 width=36 style='mso-width-source:userset;mso-width-alt:1749;mso-style-parent:style0;text-align:left;width:25pt'>
 <col class=xl65 width=21 style='mso-width-source:userset;mso-width-alt:1920;mso-style-parent:style0;text-align:left;width:15pt'>
 <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;mso-style-parent:style0;text-align:left;
 width:8pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;mso-style-parent:style0;text-align:left;
 width:19pt'>
 <col class=xl65 width=9 style='mso-width-source:userset;mso-width-alt:170;mso-style-parent:style0;text-align:left;width:7pt'>
 <col class=xl65 width=17 style='mso-width-source:userset;mso-width-alt:896;mso-style-parent:style0;text-align:left;width:12pt'>
 <col class=xl65 width=51 style='mso-width-source:userset;mso-width-alt:2176;mso-style-parent:style0;text-align:left;
 width:38pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;mso-style-parent:style0;text-align:left;
 width:1pt'>
 <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;mso-style-parent:style0;text-align:left;
 width:8pt'>
 <col class=xl65 width=9 style='mso-width-source:userset;mso-width-alt:170;mso-style-parent:style0;text-align:left;width:7pt'>
 <col class=xl65 width=34 style='mso-width-source:userset;mso-width-alt:2432;mso-style-parent:style0;text-align:left;width:25pt'>
 <col class=xl65 width=24 style='mso-width-source:userset;mso-width-alt:1109;mso-style-parent:style0;text-align:left;width:18pt'>
 <col class=xl65 width=16 style='mso-width-source:userset;mso-width-alt:768;mso-style-parent:style0;text-align:left;width:12pt'>
 <col class=xl65 width=30 style='mso-width-source:userset;mso-width-alt:1578;mso-style-parent:style0;text-align:left;width:22pt'>
 <col class=xl65 width=12 style='mso-width-source:userset;mso-width-alt:512;mso-style-parent:style0;text-align:left;
 width:9pt'>
 <col class=xl65 width=78 style='mso-width-source:userset;mso-width-alt:3328;mso-style-parent:style0;text-align:left;
 width:59pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;mso-style-parent:style0;text-align:left;
 width:1pt'>
 <col class=xl65 width=2 style='mso-width-source:userset;mso-width-alt:85;mso-style-parent:style0;text-align:left;width:2pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;
 width:5pt'>
</colgroup>
 <tr class=xl65 height=21 style='mso-height-source:userset;height:15.95pt'>
  <td colspan=40 height=21 class=xl123 width=1090 style='height:15.95pt;mso-style-parent:style0;font-size:6.0pt;text-align:right;white-space:normal;
  width:823pt'>Унифицированная форма № ТОРГ-12<br>
    Утверждена постановлением Госкомстата России от 25.12.98 № 132</td>
  <td class=xl65 width=1 style='width:1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=2 style='width:2pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=7 style='width:5pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=17 style='mso-height-source:userset;height:12.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=17 class=xl65 style='height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl66 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;vertical-align:middle;'></td>
  <td class=xl66 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;vertical-align:middle;'></td>
  <td class=xl67 style='mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Коды</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=31 rowspan=2 class=xl124 width=840 style='width:634pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? echo $order['store_org'].', ИНН '.$order['store_inn'].', '.$order['store_address'].', тел.: '.$order['store_telephone'].', '.$order['store_requisites']; ?></td>
  <td class=xl65 colspan=7 style='mso-style-parent:style0;text-align:right;'>Форма по ОКУД&nbsp;</td>
  <td class=xl68 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;	border-bottom:none;border-left:0.5pt solid black;'>0330212</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 colspan=3 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>по ОКПО&nbsp;</td>
  <td class=xl71 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;mso-number-format:"0";text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>181497743</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl72 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>организация-грузоотправитель, адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td rowspan=2 class=xl125 style='mso-style-parent:style0;font-size:9.0pt;text-align:left;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=35 class=xl112 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl74 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl74 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td colspan=27 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>структурное
  подразделение</td>
  <td class=xl70 colspan="9" style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Вид деятельности по ОКДП&nbsp;</td>
  <td class=xl75 style='border-top:none'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl126 width=111 style='width:83pt;mso-style-parent:style0;font-size:9.0pt;text-align:right;white-space:normal;'>Грузополучатель</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? echo $order['payment_address'] . ', тел.: ' . $order['telephone']; ?></td>
  <td class=xl70 colspan=3 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>по ОКПО&nbsp;</td>
  <td class=xl76 style="mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;">&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>организация, адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td rowspan=4 class=xl71 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;mso-number-format:"0";text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>181497743</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl126 width=111 style='width:83pt;mso-style-parent:style0;font-size:9.0pt;text-align:right;white-space:normal;'>Адрес доставки</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? echo $order['shipping_address']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>адрес
  доставки</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Поставщик</td>
  <td colspan=33 class=xl124 height=43 width=827 style='height:25pt;width:625pt;mso-style-parent:style0;text-align:left;font-size: 9pt;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? echo $order['store_org'].', ИНН '.$order['store_inn'].', '.$order['store_address'].', тел.: '.$order['store_telephone'].', '.$order['store_requisites']; ?></td>
  <td class=xl70 colspan=3 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>по ОКПО&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>организация,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td rowspan=2 class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Плательщик</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? echo $order['payment_address'] . ', тел.: ' . $order['telephone']; ?></td>
  <td class=xl70 colspan=3 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>по ОКПО&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>организация,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 rowspan=2 class=xl127 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;border:0.5pt solid black;'>номер</td>
  <td rowspan=2 class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Основание</td>
  <td colspan=33 class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>Основной договор</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>договор,
  заказ-наряд</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl127 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;border:0.5pt solid black;'>дата</td>
  <td class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl67 style='mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Номер документа</td>
  <td colspan=6 class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Дата составления</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 colspan=8 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Транспортная накладная&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td colspan=2 class=xl127 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;border:0.5pt solid black;'>номер</td>
  <td class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl79 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;'></td>
  <td class=xl79 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;'></td>
  <td class=xl79 colspan=6 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;width: 100pt'>ТОВАРНАЯ НАКЛАДНАЯ</td>
  <td class=xl80 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'></td>
  <td colspan=4 class=xl128 style='mso-style-parent:style0;font-size:9.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border:1.5pt solid black;'><? print $order['order_id']; ?></td>
  <td colspan=6 class=xl129 style='border-left:none;mso-style-parent:style0;font-size:9.0pt;text-align:center;vertical-align:middle;border:1.5pt solid black;'><? print $order['date_added']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl127 style='mso-style-parent:style0;font-size:9.0pt;text-align:right;border:0.5pt solid black;'>дата</td>
  <td class=xl78 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:none;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 colspan="4" style='mso-style-parent:style0;font-size:9.0pt;text-align:right;'>Вид операции</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl81 style='mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl82 height=14 style='mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;vertical-align:top;'>
  <td height=14 class=xl82 style='height:11.1pt;mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl83 style='mso-style-parent:style0;font-style:italic;text-align:right;vertical-align:top;'></td>
  <td class=xl83 style='mso-style-parent:style0;font-style:italic;text-align:right;vertical-align:top;'></td>
  <td class=xl83 style='mso-style-parent:style0;font-style:italic;text-align:right;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;font-style:italic;text-align:right;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;font-style:italic;text-align:right;vertical-align:top;'></td>
 </tr>
 <tr class=xl82 style='mso-height-source:userset;height:12pt'>
  <td class=xl84 style='mso-height-source:userset;height:12pt;mso-style-parent:style0;text-align:left;vertical-align:top;border:1px solid redborder:none;'>&nbsp;</td>
  <td rowspan=2 class=xl85 width=40 style='width:30pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;mso-line-height-alt:2pt'>Номер по поряд-ку</td>
  <td colspan="9" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Товар</td>
  <td colspan="4" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Ед. измерения</td>
  <td colspan="2" rowspan=2 class=xl85 width=42 style='font-size: 6.4pt;width:32pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Вид упаковки</td>
  <td colspan="6" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Количество</td>
  <td colspan="2" rowspan=2 class=xl85 width=63 style='width:48pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Масса брутто</td>
  <td colspan="2" rowspan=2 class="xl85 style7" width=63 style='width:48pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Количес-<br>тво (масса нетто)</td>
  <td colspan="4" rowspan=2 class=xl85 width=81 style='width:61pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Цена,<br>
    руб. коп.</td>
  <td colspan="4" rowspan=2 class=xl85 width=82 style='width:60pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Сумма
  без<br>
    учета НДС,<br>
    руб. коп.</td>
  <td colspan="4" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>НДС</td>
  <td colspan="1" rowspan=2 class=xl85 width=81 style='width:60pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>Сумма с<br>
    учетом <br>
    НДС, <br>
    руб. коп.</td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
 </tr>
 <tr class=xl82 style='mso-height-source:userset;height:37pt;mso-style-parent:style0;text-align:left;vertical-align:top;'>
  <td class=xl84 style='height:37pt;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;'>&nbsp;</td>
  <td colspan="3" class=xl85 width=194 style='border-left:none;width:146pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>наименование,
  характеристика, сорт, артикул товара</td>
  <td colspan="3" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>код</td>
     <td colspan="1" class="xl67 style7" style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Артикул</td>
     <td colspan="2" class=xl67 style='border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;'>Цвет</td>
  <td colspan="2" class=xl85 width=35 style='border-left:none;width:30pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>наиме-
  нование</td>
  <td colspan=2 class=xl85 width=25 style='border-left:none;width:20pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>код по ОКЕИ</td>
  <td colspan="3" class=xl85 width=43 style='border-left:none;width:33pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>в одном месте</td>
  <td colspan="3" class=xl85 width=56 style='border-left:none;width:42pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>мест,<br>
    штук</td>
  <td colspan="2" class=xl85 width=57 style='border-top:none;border-left:none;width:43pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>ставка,
  %</td>
  <td colspan="2" class=xl85 width=81 style='border-left:none;width:62pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>сумма,
  <br>
    руб. коп.</td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
 </tr>
 <tr class=xl86 height=14 style='mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;vertical-align:middle;'>
  <td height=14 class=xl87 style='height:11.1pt;mso-style-parent:style0;text-align:left;vertical-align:middle;border:none;'>&nbsp;</td>
  <td class=xl88 style='border-top:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border:0.5pt solid black;'>1</td>
  <td colspan="3" class=xl88 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border:0.5pt solid black;'>2</td>
  <td colspan="3" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>3</td>
     <td class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'> </td>
     <td colspan="2" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'> </td>
     <td colspan="2" class=xl88 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border:0.5pt solid black;'>4</td>
  <td class=xl89 colspan="2" style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>5</td>
  <td colspan="2" class=xl89 style='border-top:none;border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>6</td>
  <td colspan="3" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>7</td>
  <td colspan="3" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>8</td>
  <td colspan="2" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>9</td>
  <td colspan="2" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>10</td>
  <td colspan="4" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>11</td>
  <td colspan="4" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>12</td>
  <td colspan="2" class=xl88 style='border-top:none;border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border:0.5pt solid black;'>13</td>
  <td colspan="2" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>14</td>
  <td colspan="1" class=xl89 style='border-left:none;mso-style-parent:style0;font-size:7.0pt;mso-number-format:"0";text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>15</td>
  <td class=xl86 style='mso-style-parent:style0;text-align:left;vertical-align:middle;'></td>
  <td class=xl86 style='mso-style-parent:style0;text-align:left;vertical-align:middle;'></td>
 </tr>
  <? if ($order['product']){
	 $product_count = 0;
	 $product_weight = 0;
	 foreach($order['product'] as $product){
	 $product_weight += (float)$product['weight'];
	 $product_count++;
	 ?>
 <tr class=xl82 style='mso-height-source:userset;mso-style-parent:style0;text-align:left;vertical-align:top;'>
  <td class=xl84 style='mso-style-parent:style0;text-align:left;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl90 style='border-top:none;mso-style-parent:style0;mso-number-format:"0";text-align:center;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $product_count; ?></td>
  <td colspan="3" class=xl130 width=194 style='width:146pt;padding-left: 10px;mso-style-parent:style0;text-align:left;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>
      <?php print $product['report_name']; ?>
      <?php if (!empty($product['option']) && is_array($product['option'])) : ?><br>
      <em><?php echo $product['option'][0]['name']; ?> - <?php echo $product['option'][0]['value']; ?></em>
      <?php endif; ?>
  </td>
  <td colspan="3" class=xl131 width=77 style='width:58pt;mso-style-parent:style0;text-align:left;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $product['kod']; ?></td>
     <td class=xl131 width=77 style='width:58pt;mso-style-parent:style0;text-align:left;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $product['model']; ?></td>
     <td colspan="2" class=xl131 width=77 style='width:58pt;mso-style-parent:style0;text-align:left;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $product['color']; ?></td>
     <td colspan="2" class=xl132 style='text-align: center;mso-style-parent:style0;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>шт</td>
  <td colspan="2" class=xl133 width=45 style='width:34pt;mso-style-parent:style0;mso-number-format:"0";text-align:center;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;
	white-space:normal;'>796</td>
  <td colspan="2" class=xl91 style='text-align: center;mso-style-parent:style0;vertical-align:top;border:0.5pt solid black;'>шт</td>
  <td colspan="3" class=xl134 style='border-left:none;mso-style-parent:style0;mso-number-format:"0";text-align:center;vertical-align:top;border:0.5pt solid black;'>&nbsp;</td>
  <td colspan="3" class=xl134 style='border-left:none;mso-style-parent:style0;mso-number-format:"0";text-align:center;vertical-align:top;border:0.5pt solid black;'>&nbsp;</td>
  <td colspan="2" class=xl94 style='mso-style-parent:style0;text-align:right;vertical-align:top;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan="2" class=xl135 style='border-left:none;mso-style-parent:style0;mso-number-format:"0\.000";text-align:right;vertical-align:top;border:0.5pt solid black;'><? print $product['quantity']; ?></td>
  <td colspan="4" class=xl136 style='border-left:none;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:top;border:0.5pt solid black;'><? print number_format($product['free_nds'], 2, ',', ' '); ?></td>
  <td colspan="4" class=xl137 style='border-left:none;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($product['free_nds']*$product['quantity'], 2, ',', ' '); ?></td>
  <td colspan="2" class=xl95 style='border-top:none;mso-style-parent:style0;mso-number-format:Fixed;text-align:center;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print ($product['tax'] == 0) ? 'Без НДС' : round($product['tax'],0); ?></td>
  <td colspan="2" class=xl138 style='mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:top;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print ($product['tax'] == 0) ? '' : number_format($product['nds'], 2, ',', ' '); ?></td>
  <td colspan="1" class=xl139 style='border-left:none;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;vertical-align:top;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($product['total'], 2, ',', ' '); ?></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
  <td class=xl82 style='mso-style-parent:style0;text-align:left;vertical-align:top;'></td>
 </tr>
  <?
    $totals['kol']+=$product['quantity'];
    $totals['sum_wo_nds'] += $product['free_nds']*$product['quantity'];
    $totals['sum_nds'] += $product['nds'];
	$totals['sum_w_nds'] += $product['total'];
  } }?>

    <tr height="20" style='mso-height-source:userset;height:15pt'>
        <td height="20" class=xl96 style='height:15pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
        <td class=xl97 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl99 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl98 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl98 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl98 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl100 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl100 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl97 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl101 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl101 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl100 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl100 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td class=xl100 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
        <td colspan="5" class=xl102 style='mso-style-parent:style0;vertical-align: middle;text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>Итого</td>
        <td colspan="1" class=xl102 style='mso-style-parent:style0;text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'></td>
        <td colspan="3" class=xl140 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:"0";text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
        <td colspan="2" class=xl104 style='mso-style-parent:style0;text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
        <td colspan="2" class=xl141 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:"0\.000";text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><?php echo $totals['kol'] ?></td>
        <td colspan="4" class=xl142 style='vertical-align: middle;mso-style-parent:style0;text-align:center;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>Х</td>
        <td colspan="4" class=xl143 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($totals['sum_wo_nds'], 2, ',', ' '); ?></td>
        <td colspan="2" class=xl106 style='mso-style-parent:style0;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;border-top:none;text-align: center;vertical-align: middle'>Х</td>
        <td colspan=2 class=xl143 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print ($totals['sum_nds'] == 0) ? '' : number_format($totals['sum_nds'], 2, ',', ' '); ?></td>
        <td colspan="1" class=xl144 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($totals['sum_w_nds'], 2, ',', ' '); ?></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
    </tr>
    <tr height="20" style='mso-height-source:userset;height:15pt'>
        <td height="20" class=xl96 style='height:15pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td colspan="7" class=xl107 style='mso-style-parent:style0;vertical-align: middle;text-align:right;'>Всего по накладной</td>
        <td colspan="1" class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td colspan="3" class=xl146 style='vertical-align: middle;mso-style-parent:style0;mso-number-format:"0";text-align:right;border:0.5pt solid black;'>&nbsp;</td>
        <td colspan="2" class=xl110 style='border-top:none;mso-style-parent:style0;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
        <td colspan="2" class=xl147 style='border-left:none;vertical-align: middle;mso-style-parent:style0;mso-number-format:"0\.000";text-align:right;border:0.5pt solid black;'><?php echo $totals['kol'] ?></td>
        <td colspan="4" class=xl91 style='border-left:none;vertical-align: middle;mso-style-parent:style0;text-align:center;border:0.5pt solid black;'>Х</td>
        <td colspan="4" class=xl136 style='border-left:none;vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print number_format($totals['sum_wo_nds'], 2, ',', ' '); ?></td>
        <td colspan="2" class=xl91 style='border-top:none;border-left:none;vertical-align: middle;mso-style-parent:style0;text-align:center;border:0.5pt solid black;'>Х</td>
        <td colspan=2 class=xl136 style='border-left:none;vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print ($totals['sum_nds'] == 0) ? '' : number_format($totals['sum_nds'], 2, ',', ' '); ?></td>
        <td colspan="1" class=xl136 style='border-left:none;vertical-align: middle;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print number_format($totals['sum_w_nds'], 2, ',', ' '); ?></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
        <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
    </tr>

 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 colspan=5 style='mso-ignore:colspan'>Товарная накладная имеет приложение на</td>
  <td class=xl111 style='mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl112  style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'>и содержит</td>
  <td class=xl113 colspan=2 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'></td>
  <td class=xl113 style='mso-ignore:colspan;text-align: center'><? print $order['products_total']; ?></td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl114 style='border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 colspan=7 style='mso-ignore:colspan'>порядковых номеров
  записей</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=19 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>прописью</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td colspan=9 rowspan=2 class=xl148 style='mso-style-parent:style0;text-align:left;border:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 rowspan=3 class=xl149 width=134 style='width:101pt; text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65></td>
     <td class=xl65></td>
     <td class=xl65></td>
  <td class=xl65 colspan=5 style='mso-ignore:colspan'>&nbsp;Масса груза (нетто)</td>
  <td class=xl65></td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=4 class=xl150 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>прописью</td>
  <td colspan=4 class=xl151 style='mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 rowspan=2 class=xl148 style='mso-style-parent:style0;text-align:left;border:0.5pt solid black;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65>Всего мест</td>
  <td class=xl65></td>
     <td class=xl65></td>
     <td class=xl65></td>
  <td class=xl65 colspan=6 style='mso-ignore:colspan'>&nbsp;Масса груза (брутто)</td>
  <td class=xl113 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl115 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=4 class=xl150 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>прописью</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>прописью</td>
  <td colspan=4 class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>&nbsp;</td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl65 colspan=6 style='mso-ignore:colspan'>Приложение (паспорта,
  сертификаты и т.п.) на</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>листах</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl107 style='mso-style-parent:style0;text-align:right;'></td>
  <td class=xl107 colspan=5 style='mso-style-parent:style0;text-align:left;'>По доверенности №</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.0pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl120 colspan=2 style='mso-style-parent:style0;text-align:center;'>от</td>
  
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
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
  <td colspan=3 class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>прописью</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
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
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl121 colspan=4 style='mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;'>Всего отпущено<span
  style='mso-spacerun:yes'>  </span>на сумму</td>
  <td colspan=13 class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 rowspan=2 class=xl149 width=445 style='width:337pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=17 class=xl152 width=516 style='width:389pt;mso-style-parent:style0;font-weight:700;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['products_order_total_prop'];?></td>
  <td class=xl65></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>выданной</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td colspan=16 class=xl153 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>прописью</td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>кем, кому (организация, должность, фамилия, и. о.)</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl65 style='height:18.0pt'></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>Отпуск груза разрешил</td>
  <td colspan=3 class=xl154 width=121 style='width:91pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $entry_rk; ?></td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['owner']; ?></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl154 width=445 style='width:337pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>должность</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>расшифровка
  подписи</td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl65 style='height:18.0pt'></td>
  <td class=xl121 colspan=4 style='mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;'>Главный (старший)
  бухгалтер</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['buh']; ?></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td colspan="4" class=xl65 style='mso-ignore:colspan'>Груз принял</td>
  <td class=xl65>&nbsp;</td>
  <td colspan="4" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td colspan="4" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td colspan="8" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=3 rowspan=2 class=xl149 width=121 style='width:91pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $entry_manager; ?></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>расшифровка
  подписи</td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan="4" class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>должность</td>
  <td class=xl65></td>
  <td colspan="4" class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>подпись</td>
  <td class=xl65></td>
  <td colspan="8" class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>расшифровка
  подписи</td>
  <td class=xl65></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:14.1pt'>
  <td height=18 class=xl65 style='height:14.1pt'></td>
  <td colspan="3" class=xl65 style='mso-ignore:colspan'>Отпуск груза произвел</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['manager']; ?></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td colspan="4" class=xl65 style='mso-ignore:colspan'>Груз получил</td>
  <td class=xl65></td>
     <td colspan="4" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td colspan="4" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
   <td class=xl65>&nbsp;</td>
  <td colspan="8" class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>должность</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>расшифровка
  подписи</td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl82 colspan=5 style='mso-ignore:colspan mso-style-parent:style0;text-align:left;vertical-align:top;height: 14pt'>грузополучатель</td>
  <td colspan="4" class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>должность</td>
  <td class=xl65></td>
  <td colspan="4" class=xl118 style='mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;border:none;'>подпись</td>
  <td class=xl65></td>
  <td colspan="8" class=xl72 align=center style='mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border:none;'>расшифровка
  подписи</td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
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
 <? $parts = explode('&nbsp;', $order['date_rus']); ?>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl107 style='mso-style-parent:style0;text-align:right;'></td>
  <td class=xl107 style='mso-style-parent:style0;text-align:right;'></td>
  <td class=xl107 colspan=2 style='mso-style-parent:style0;text-align:right;'>М.П.</td>
    <td class=xl107 style='mso-style-parent:style0;text-align:right;'><? print $parts[0]; ?></td>
  <td class=xl107 style='mso-style-parent:style0;text-align:right;'></td>
  <td class=xl69 style='text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><? print $parts[1]; ?></td> 
  <td class=xl69 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 colspan=4 style='mso-ignore:colspan'><? print $parts[2]; ?> года</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl122 align=center style='mso-ignore:colspan;mso-style-parent:style0;text-align:center-across;'>М.П.</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65 colspan=9 style='mso-ignore:colspan'>&quot;<span
  style='mso-spacerun:yes'>     </span>&quot; _____________ 20<span
  style='mso-spacerun:yes'>     </span>года</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
	font-size:7.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-line-height: exactly; line-height: 100%; line-height: 16px;
	mso-font-charset:0;
	border:none;
	mso-protection:locked visible;
	mso-style-name:обычный;
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
	.excel{
	 position: absolute;
	 top: 30px;
	 right: 30px;
	 opacity: 0.7;
	 cursor: pointer;
	}
td.style7
{
font-size:7.0pt;
mso-line-height: exactly; line-height: 100%; line-height: 12px;
}
</style>
<? //require_once $library . 'ocbase_documents.php';?>
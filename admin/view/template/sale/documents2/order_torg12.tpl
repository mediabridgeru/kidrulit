<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="view/template/sale/documents/order_torg12.stylesheet.css" />
</head>
<body link=blue vlink=purple>
<?php $count = 0; foreach ($orders as $order) { 
 $count++;
 $totals = array('kol'=>0, 'sum_wo_nds'=>0, 'sum_nds'=>0, 'sum_w_nds' => 0);
 ?>
<br>
<br>
 <div <? if (count($orders)>1){ print 'style="page-break-after: always;"';} ?> >
<table border=0 cellpadding=0 cellspacing=0 width=1100 style='border-collapse:
 collapse;table-layout:fixed;width:831pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <col class=xl65 width=40 style='mso-width-source:userset;mso-width-alt:1706;
 width:30pt'>
 <col class=xl65 width=71 style='mso-width-source:userset;mso-width-alt:3029;
 width:53pt'>
 <col class=xl65 width=14 style='mso-width-source:userset;mso-width-alt:597;
 width:11pt'>
 <col class=xl65 width=91 style='mso-width-source:userset;mso-width-alt:3882;
 width:68pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;
 width:14pt'>
 <col class=xl65 width=12 style='mso-width-source:userset;mso-width-alt:512;
 width:9pt'>
 <col class=xl65 width=65 style='mso-width-source:userset;mso-width-alt:2773;
 width:49pt'>
 <col class=xl65 width=39 style='mso-width-source:userset;mso-width-alt:1664;
 width:29pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;
 width:5pt'>
 <col class=xl65 width=39 style='mso-width-source:userset;mso-width-alt:1664;
 width:29pt'>
 <col class=xl65 width=42 style='mso-width-source:userset;mso-width-alt:1792;
 width:32pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;
 width:14pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;
 width:19pt'>
 <col class=xl65 width=3 style='mso-width-source:userset;mso-width-alt:128;
 width:2pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=27 style='mso-width-source:userset;mso-width-alt:1152;
 width:20pt'>
 <col class=xl65 width=13 style='mso-width-source:userset;mso-width-alt:554;
 width:10pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;
 width:14pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;
 width:19pt'>
 <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;
 width:15pt'>
 <col class=xl65 width=22 style='mso-width-source:userset;mso-width-alt:938;
 width:17pt'>
 <col class=xl65 width=41 style='mso-width-source:userset;mso-width-alt:1749;
 width:31pt'>
 <col class=xl65 width=45 style='mso-width-source:userset;mso-width-alt:1920;
 width:34pt'>
 <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;
 width:8pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;
 width:19pt'>
 <col class=xl65 width=4 style='mso-width-source:userset;mso-width-alt:170;
 width:3pt'>
 <col class=xl65 width=21 style='mso-width-source:userset;mso-width-alt:896;
 width:16pt'>
 <col class=xl65 width=51 style='mso-width-source:userset;mso-width-alt:2176;
 width:38pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=11 style='mso-width-source:userset;mso-width-alt:469;
 width:8pt'>
 <col class=xl65 width=4 style='mso-width-source:userset;mso-width-alt:170;
 width:3pt'>
 <col class=xl65 width=57 style='mso-width-source:userset;mso-width-alt:2432;
 width:43pt'>
 <col class=xl65 width=26 style='mso-width-source:userset;mso-width-alt:1109;
 width:20pt'>
 <col class=xl65 width=18 style='mso-width-source:userset;mso-width-alt:768;
 width:14pt'>
 <col class=xl65 width=37 style='mso-width-source:userset;mso-width-alt:1578;
 width:28pt'>
 <col class=xl65 width=12 style='mso-width-source:userset;mso-width-alt:512;
 width:9pt'>
 <col class=xl65 width=78 style='mso-width-source:userset;mso-width-alt:3328;
 width:59pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=2 style='mso-width-source:userset;mso-width-alt:85;
 width:2pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <tr class=xl65 height=21 style='mso-height-source:userset;height:15.95pt'>
  <td colspan=40 height=21 class=xl123 width=1090 style='height:15.95pt;
  width:823pt'>Унифицированная форма № ТОРГ-12<br>
    Утверждена постановлением Госкомстата России от 25.12.98 № 132</td>
  <td class=xl65 width=1 style='width:1pt'></td>
  <td class=xl65 width=2 style='width:2pt'></td>
  <td class=xl65 width=7 style='width:5pt'></td>
 </tr>
 <tr class=xl65 height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
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
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl67>Коды</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td colspan=31 rowspan=2 class=xl124 width=840 style='width:634pt'><? print $order['store_name'].' '.$order['store_address']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65>Форма по ОКУД</td>
  <td class=xl65></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl68>0330212</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl70>по ОКПО</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl71>96973078</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>организация-грузоотправитель,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td rowspan=2 class=xl125>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td colspan=35 class=xl112>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl74>&nbsp;</td>
  <td class=xl74>&nbsp;</td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>структурное
  подразделение</td>
  <td class=xl70>Вид деятельности по ОКДП</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl75 style='border-top:none'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td colspan=2 class=xl126 width=111 style='width:83pt'>Грузополучатель</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl70>по ОКПО</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl76>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>организация,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td rowspan=4 class=xl71>96973078</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td colspan=2 class=xl126 width=111 style='width:83pt'>Адрес доставки</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt'><? print $order['shipping_address']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>адрес
  доставки</td>
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
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70>Поставщик</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt'><? print $order['store_name'].' '.$order['store_address']; ?></td>
  <td class=xl70>по ОКПО</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>организация,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td rowspan=2 class=xl78>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70>Плательщик</td>
  <td colspan=33 class=xl124 width=827 style='width:625pt'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl70>по ОКПО</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>организация,
  адрес, телефон, факс, банковские реквизиты</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 rowspan=2 class=xl127>номер</td>
  <td rowspan=2 class=xl78>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70>Основание</td>
  <td colspan=33 class=xl112>-</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=29 class=xl73 align=center style='mso-ignore:colspan'>договор,
  заказ-наряд</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl127>дата</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
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
  <td colspan=3 class=xl67>Номер документа</td>
  <td colspan=6 class=xl67 style='border-left:none'>Дата составления</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70>Транспортная накладная</td>
  <td class=xl65></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl65></td>
  <td colspan=2 class=xl127>номер</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl79>ТОВАРНАЯ НАКЛАДНАЯ</td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl80></td>
  <td colspan=3 class=xl128><input type='text' class='noborder' style='width:40px;font-size: 12px'></td>
  <td colspan=6 class=xl129 style='border-left:none'><? print $order['date_added']; ?></td>
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
  <td colspan=2 class=xl127>дата</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='height:12.0pt'></td>
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
  <td class=xl70></td>
  <td class=xl70>Вид операции</td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl81>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl82 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl82 style='height:11.1pt'></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl82></td>
  <td class=xl83></td>
  <td class=xl83></td>
  <td class=xl83></td>
  <td class=xl82></td>
  <td class=xl82></td>
 </tr>
 <tr class=xl82 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl84 style='height:11.1pt'>&nbsp;</td>
  <td rowspan=2 class=xl85 width=40 style='width:30pt'>Но-<br>
    мер<br>
    по по-<br>
    рядку</td>
  <td colspan=6 class=xl67 style='border-left:none'>Товар</td>
  <td colspan=5 class=xl67 style='border-left:none'>Ед. измерения</td>
  <td rowspan=2 class=xl85 width=42 style='width:32pt'>Вид упаковки</td>
  <td colspan=6 class=xl67 style='border-left:none'>Количество</td>
  <td colspan=3 rowspan=2 class=xl85 width=63 style='width:48pt'>Масса брутто</td>
  <td colspan=2 rowspan=2 class=xl85 width=63 style='width:48pt'>Коли-<br>
    чество <br>
    (масса <br>
    нетто)</td>
  <td colspan=3 rowspan=2 class=xl85 width=81 style='width:61pt'>Цена,<br>
    руб. коп.</td>
  <td colspan=6 rowspan=2 class=xl85 width=92 style='width:69pt'>Сумма
  без<br>
    учета НДС,<br>
    руб. коп.</td>
  <td colspan=4 class=xl67 style='border-left:none'>НДС</td>
  <td colspan=3 rowspan=2 class=xl85 width=91 style='width:69pt'>Сумма с<br>
    учетом <br>
    НДС, <br>
    руб. коп.</td>
  <td class=xl82></td>
  <td class=xl82></td>
 </tr>
 <tr class=xl82 height=44 style='mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl84 style='height:33.0pt'>&nbsp;</td>
  <td colspan=4 class=xl85 width=194 style='border-left:none;width:146pt'>наименование,
  характеристика, сорт, артикул товара</td>
  <td colspan=2 class=xl67 style='border-left:none'>код</td>
  <td colspan=3 class=xl85 width=59 style='border-left:none;width:44pt'>наиме-
  нование</td>
  <td colspan=2 class=xl85 width=45 style='border-left:none;width:34pt'>код по
  ОКЕИ</td>
  <td colspan=2 class=xl85 width=43 style='border-left:none;width:33pt'>в одном
  месте</td>
  <td colspan=4 class=xl85 width=56 style='border-left:none;width:42pt'>мест,<br>
    штук</td>
  <td class=xl85 width=57 style='border-top:none;border-left:none;width:43pt'>ставка,
  %</td>
  <td colspan=3 class=xl85 width=81 style='border-left:none;width:62pt'>сумма,
  <br>
    руб. коп.</td>
  <td class=xl82></td>
  <td class=xl82></td>
 </tr>
 <tr class=xl86 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl87 style='height:11.1pt'>&nbsp;</td>
  <td class=xl88 style='border-top:none'>1</td>
  <td colspan=4 class=xl88 style='border-left:none'>2</td>
  <td colspan=2 class=xl89 style='border-left:none'>3</td>
  <td colspan=3 class=xl88 style='border-left:none'>4</td>
  <td colspan=2 class=xl89 style='border-left:none'>5</td>
  <td class=xl89 style='border-top:none;border-left:none'>6</td>
  <td colspan=2 class=xl89 style='border-left:none'>7</td>
  <td colspan=4 class=xl89 style='border-left:none'>8</td>
  <td colspan=3 class=xl89 style='border-left:none'>9</td>
  <td colspan=2 class=xl89 style='border-left:none'>10</td>
  <td colspan=3 class=xl89 style='border-left:none'>11</td>
  <td colspan=6 class=xl89 style='border-left:none'>12</td>
  <td class=xl88 style='border-top:none;border-left:none'>13</td>
  <td colspan=3 class=xl89 style='border-left:none'>14</td>
  <td colspan=3 class=xl89 style='border-left:none'>15</td>
  <td class=xl86></td>
  <td class=xl86></td>
 </tr>
  <? if ($order['product']){
	 
	 $product_count = 0;
	 foreach($order['product'] as $product){
	 $product_count++;
	 ?>
 <tr class=xl82 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td height=29 class=xl84 style='height:21.95pt'>&nbsp;</td>
  <td class=xl90 style='border-top:none;text-align: center; vertical-align: middle'><? print $product_count; ?></td>
  <td colspan=4 class=xl130 width=194 style='width:146pt;padding-left: 10px;vertical-align:middle;'><? print $product['name']; ?></td>
  <td colspan=2 class=xl131 width=77 style='width:58pt;text-align: center;vertical-align: middle'><? print $product['sku']; ?></td>
  <td colspan=3 class=xl132 style='text-align: center;vertical-align: middle'>шт</td>
  <td colspan=2 class=xl133 width=45 style='width:34pt;text-align: center;vertical-align: middle'>796</td>
  <td class=xl91 style='text-align: center;vertical-align: middle'>шт</td>
  <td colspan=2 class=xl134 style='border-left:none;text-align: center;vertical-align: middle'>1</td>
  <td colspan=4 class=xl134 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['quantity']; ?></td>
  <td class=xl93 style='border-left:none'>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl94>&nbsp;</td>
  <td colspan=2 class=xl135 style='border-left:none;text-align: center;vertical-align: middle'><? print $product['quantity']; ?></td>
  <td colspan=3 class=xl136 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($product['free_nds'],2); ?></td>
  <td colspan=6 class=xl137 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($product['free_nds']*$product['quantity'],2); ?></td>
  <td class=xl95 style='border-top:none;text-align: center;vertical-align: middle'><? print round($product['tax'],0); ?></td>
  <td colspan=3 class=xl138 style='text-align: center;vertical-align: middle'><? print number_format($product['nds'],2); ?></td>
  <td colspan=3 class=xl139 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($product['total'],2); ?></td>
  <td class=xl82></td>
  <td class=xl82></td>
 </tr>
  <? 
    $totals['kol']+=$product['quantity'];
    $totals['sum_wo_nds'] += $product['free_nds']*$product['quantity'];
    $totals['sum_nds'] += $product['nds'];
	$totals['sum_w_nds'] += $product['total'];
  } }?>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl96 style='height:11.1pt'>&nbsp;</td>
  <td class=xl97 style='border-top:none'>&nbsp;</td>
  <td class=xl99 style='border-top:none'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl97 style='border-top:none'>&nbsp;</td>
  <td class=xl101 style='border-top:none'>&nbsp;</td>
  <td class=xl101 style='border-top:none'>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl102>Итого</td>
  <td class=xl102></td>
  <td colspan=4 class=xl140 style='text-align: center;vertical-align: middle'><? print $totals['kol']; ?></td>
  <td class=xl104>&nbsp;</td>
  <td class=xl103>&nbsp;</td>
  <td class=xl105>&nbsp;</td>
  <td colspan=2 class=xl141 style='text-align: center;vertical-align: middle'><? print $totals['kol']; ?></td>
  <td colspan=3 class=xl142 style='text-align: center;vertical-align: middle'>Х</td>
  <td colspan=6 class=xl143 style='text-align: center;vertical-align: middle'><? print number_format($totals['sum_wo_nds'],2); ?></td>
  <td class=xl106 style='border-top:none;text-align: center;vertical-align: middle'>Х</td>
  <td colspan=3 class=xl143 style='text-align: center;vertical-align: middle'><? print number_format($totals['sum_nds'],2); ?></td>
  <td colspan=3 class=xl144 style='text-align: center;vertical-align: middle'><? print number_format($totals['sum_w_nds'], 2); ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl96 style='height:11.1pt'>&nbsp;</td>
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
  <td class=xl107>Всего по накладной</td>
  <td class=xl65></td>
  <td class=xl107></td>
  <td class=xl107></td>
  <td colspan=4 class=xl146 style='text-align: center;vertical-align: middle'><? print $totals['kol']; ?></td>
  <td class=xl109 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl110 style='border-top:none'>&nbsp;</td>
  <td colspan=2 class=xl147 style='border-left:none;text-align: center;vertical-align: middle'><? print $totals['kol']; ?></td>
  <td colspan=3 class=xl91 style='border-left:none;text-align: center;vertical-align: middle'>Х</td>
  <td colspan=6 class=xl136 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($totals['sum_wo_nds'],2); ?></td>
  <td class=xl91 style='border-top:none;border-left:none;text-align: center;vertical-align: middle'>Х</td>
  <td colspan=3 class=xl136 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($totals['sum_nds'],2); ?></td>
  <td colspan=3 class=xl136 style='border-left:none;text-align: center;vertical-align: middle'><? print number_format($totals['sum_w_nds'], 2); ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65 colspan=5 style='mso-ignore:colspan'>Товарная накладная имеет
  приложение на</td>
  <td class=xl111>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl112>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65>и содержит</td>
  <td class=xl113 colspan=2 ></td>
  <td class=xl113 style='mso-ignore:colspan;text-align: center'><? print $order['products_total']; ?></td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl114 style='border-top:none'>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65 colspan=7 style='mso-ignore:colspan'>порядковых номеров
  записей</td>
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
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=19 class=xl72 align=center style='mso-ignore:colspan'>прописью</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 rowspan=2 class=xl148>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 rowspan=3 class=xl149 width=134 style='width:101pt; text-align: center'><? print $order['products_total']; ?></td>
  <td class=xl65></td>
  <td class=xl65 colspan=5 style='mso-ignore:colspan'>Масса груза (нетто)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl113>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td colspan=4 class=xl150>&nbsp;</td>
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
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan'>прописью</td>
  <td colspan=4 class=xl151>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 rowspan=2 class=xl148>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65>Всего мест</td>
  <td class=xl65></td>
  <td class=xl65 colspan=6 style='mso-ignore:colspan'>Масса груза (брутто)</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl113>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td class=xl115>&nbsp;</td>
  <td colspan=4 class=xl150>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 class=xl118>прописью</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan'>прописью</td>
  <td colspan=4 class=xl118>&nbsp;</td>
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
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>листах</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl107></td>
  <td class=xl107>По доверенности №</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl120>от</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
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
  <td colspan=3 class=xl118>прописью</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119>&nbsp;</td>
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
  <td class=xl121 colspan=4 style='mso-ignore:colspan'>Всего отпущено<span
  style='mso-spacerun:yes'>  </span>на сумму</td>
  <td colspan=13 class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 rowspan=2 class=xl149 width=445 style='width:337pt'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=17 class=xl152 width=516 style='width:389pt'><? print $order['products_order_total_prop'];?></td>
  <td class=xl65></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>выданной</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td colspan=16 class=xl153>прописью</td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl118>кем, кому (организация, должность, фамилия, и. о.)</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=44 style='mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl65 style='height:33.0pt'></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>Отпуск груза разрешил</td>
  <td colspan=3 class=xl154 width=121 style='width:91pt'><? print $entry_rk; ?></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt'><? print $order['owner']; ?></td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl154 width=445 style='width:337pt'>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl118>должность</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan'>расшифровка
  подписи</td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=18 class=xl118>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr height=44 style='mso-height-source:userset;height:33.0pt'>
  <td height=44 class=xl65 style='height:33.0pt'></td>
  <td class=xl121 colspan=4 style='mso-ignore:colspan'>Главный (старший)
  бухгалтер</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt'><? print $order['buh']; ?></td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65 colspan=4 style='mso-ignore:colspan'>Груз принял</td>
  <td class=xl65></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=10 style='mso-height-source:userset;height:8.1pt'>
  <td height=10 class=xl65 style='height:8.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=3 rowspan=2 class=xl149 width=121 style='width:91pt'><? print $entry_manager; ?></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan'>расшифровка
  подписи</td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan'>должность</td>
  <td class=xl65></td>
  <td colspan=4 class=xl118>подпись</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan'>расшифровка
  подписи</td>
  <td class=xl65></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:14.1pt'>
  <td height=18 class=xl65 style='height:14.1pt'></td>
  <td class=xl65 colspan=3 style='mso-ignore:colspan'>Отпуск груза произвел</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=7 class=xl154 width=140 style='width:106pt'><? print $order['manager']; ?></td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65 colspan=4 style='mso-ignore:colspan'>Груз получил</td>
  <td class=xl65></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=4 class=xl69>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=13 style='mso-height-source:userset;height:9.95pt'>
  <td height=13 class=xl65 style='height:9.95pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl118>должность</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan'>подпись</td>
  <td class=xl65></td>
  <td colspan=7 class=xl72 align=center style='mso-ignore:colspan'>расшифровка
  подписи</td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl82 colspan=5 style='mso-ignore:colspan'>грузополучатель</td>
  <td colspan=2 class=xl72 align=center style='mso-ignore:colspan'>должность</td>
  <td class=xl65></td>
  <td colspan=4 class=xl118>подпись</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=9 class=xl72 align=center style='mso-ignore:colspan'>расшифровка
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
  <td class=xl119>&nbsp;</td>
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
  <td class=xl107></td>
  <td class=xl107></td>
  <td class=xl107>М.П.</td>
  <td class=xl65></td>
  <td class=xl107><? print $parts[0]; ?></td>
  <td class=xl107></td>
  <td class=xl69 style='text-align: center'><? print $parts[1]; ?></td>
  <td class=xl69>&nbsp;</td>
  <td class=xl65 colspan=4 style='mso-ignore:colspan'><? print $parts[2]; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl119>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=2 class=xl122 align=center style='mso-ignore:colspan'>М.П.</td>
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
.noborder{
 border: 0px !important;
 text-align: center;
 font-weight: bold;
 text-transform: uppercase;
 font-size: 16px;
}
</style>
<?
if(isset($_GET['excel7'])){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=pko-" . time() . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
</head>
<body>
<? $count = 0;?>
<?php foreach ($orders as $order) { $count++;?>
<br>
<br>
 <div style="page-break-after: always;">
<table border=0 cellpadding=0 cellspacing=0 width=714 style='font-size:8.0pt;border-collapse:
 collapse;table-layout:fixed;width:538pt'>
 <col class=xl65 width=7 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;
 width:5pt'>
 <col class=xl65 width=70 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2986;mso-style-parent:style0;text-align:left;
 width:53pt'>
 <col class=xl65 width=44 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1877;mso-style-parent:style0;text-align:left;
 width:33pt'>
 <col class=xl65 width=70 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2986;mso-style-parent:style0;text-align:left;
 width:53pt'>
 <col class=xl65 width=63 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2688;mso-style-parent:style0;text-align:left;
 width:47pt'>
 <col class=xl65 width=60 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2560;mso-style-parent:style0;text-align:left;
 width:45pt'>
 <col class=xl65 width=88 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:3754;mso-style-parent:style0;text-align:left;
 width:66pt'>
 <col class=xl65 width=57 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2432;mso-style-parent:style0;text-align:left;
 width:43pt'>
 <col class=xl65 width=33 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1408;mso-style-parent:style0;text-align:left;
 width:25pt'>
 <col class=xl65 width=14 span=2 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:mso-style-parent:style0;text-align:left;
 597;width:11pt'>
 <col class=xl65 width=66 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:2816;mso-style-parent:style0;text-align:left;
 width:50pt'>
 <col class=xl65 width=31 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1322;mso-style-parent:style0;text-align:left;
 width:23pt'>
 <col class=xl65 width=13 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:554;mso-style-parent:style0;text-align:left;
 width:10pt'>
 <col class=xl65 width=39 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1664;mso-style-parent:style0;text-align:left;
 width:29pt'>
 <col class=xl65 width=38 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1621;mso-style-parent:style0;text-align:left;
 width:29pt'>
 <col class=xl65 width=7 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;
 width:5pt'>
 <tr class=xl65 height=12 style='font-size:8.0pt;mso-height-source:userset;height:9.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=12 class=xl65 width=7 style='font-size:8.0pt;height:9.0pt;width:5pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=70 style='font-size:8.0pt;width:53pt;mso-style-parent:style0;text-align:left;'><? print $ko1;?></td>
  <td class=xl65 width=44 style='font-size:8.0pt;width:33pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=70 style='font-size:8.0pt;width:53pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=63 style='font-size:8.0pt;width:47pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=60 style='font-size:8.0pt;width:45pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=88 style='font-size:8.0pt;width:66pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=57 style='font-size:8.0pt;width:43pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl66 width=33 style='font-size:8.0pt;width:25pt;mso-style-parent:style0;font-size:6.0pt;text-align:right;'></td>
  <td class=xl67 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=2 class=xl102 width=187 style='font-size:8.0pt;width:141pt;mso-style-parent:style0;font-weight:700;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><?php echo $order['store_name']; ?></td>
  <td class=xl65 width=7 style='font-size:8.0pt;width:5pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $header_second; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:right;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 class=xl69 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'><? print $entry_org; ?></td>
  <td class=xl65  style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl71 colspan=4 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;color:white;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl103 width=90 style='font-size:8.0pt;width:68pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_codes; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 class=xl72 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:center-across;'><? print $entry_kwit; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=5 class=xl104 width=307 style='font-size:8.0pt;width:231pt;mso-style-parent:style0;text-align:center;white-space:normal;'><?php echo $order['store_name']; ?></td>
  <td class=xl74 style='font-size:8.0pt;mso-style-parent:style0;text-align:right;'><? print $entry_okud_form; ?></td>
  <td colspan=2 class=xl105 width=90 style='font-size:8.0pt;width:68pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;mso-number-format:0000000;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:1.0pt solid black;border-bottom:0.5pt solid black;border-left:1.0pt solid black;white-space:normal;'>0310001</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 class=xl104 width=187 style='font-size:8.0pt;width:141pt;mso-style-parent:style0;text-align:center;white-space:normal;'><? print $entry_to_pko; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=5 class=xl75 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'><? print $entry_org; ?></td>
  <td class=xl74 style='font-size:8.0pt;mso-style-parent:style0;text-align:right;'><? print $entry_okpo; ?></td>
  <td colspan=2 class=xl106 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;mso-number-format:0;text-align:center;border-top:0.5pt solid black;border-right:1.0pt solid black;border-bottom:0.5pt solid black;border-left:1.0pt solid black;'>96973078</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl74 style='font-size:8.0pt;mso-style-parent:style0;text-align:right;'>№</td>
  <td colspan=4 class=xl107 style='font-size:8.0pt;mso-style-parent:style0;font-weight:700;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><!--<input type='text' class='noborder' id='order-no1' onkeyup="javascript:swap(this.value)" value="--><? print $order['order_id']; ?><!--" --></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=5 rowspan=2 class=xl108 width=307 style='font-size:8.0pt;width:231pt;text-align:center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><?php echo $order['store_name']; ?></td>
  <td class=xl76 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;text-align:left;'></td>
  <td colspan=2 rowspan=2 class=xl109 width=90 style='font-size:8.0pt;width:68pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:1.0pt solid black;border-bottom:1.0pt solid black;border-left:1.0pt solid black;white-space:normal;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl74 style='font-size:8.0pt;mso-style-parent:style0;text-align:right;'>от</td>
  <td colspan=4 class=xl107 style='font-size:8.0pt;mso-style-parent:style0;font-weight:700;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><?php echo $order['date_rus']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=16 class=xl65 style='font-size:8.0pt;height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl77 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:0.5pt solid black;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'><? print $entry_get_from; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=5 class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_struct; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl110 width=187 style='font-size:8.0pt;width:141pt;text-align: center;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;white-space:normal;'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=4 style='font-size:8.0pt;mso-height-source:userset;height:3.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=4 class=xl65 style='font-size:8.0pt;height:3.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=28 style='font-size:8.0pt;mso-height-source:userset;height:21.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=28 class=xl65 style='font-size:8.0pt;height:21.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class="xl65 xl80" style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;mso-style-parent:style0;text-align:left;'><? print $entry_pko; ?></td>
  <td class="xl65" style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl80 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;text-align:right;vertical-align:middle;'></td>
  <td colspan=2 class=xl111 width=148 style='font-size:8.0pt;width:111pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;white-space:normal;'><? print $entry_num; ?></td>
  <td colspan=2 class=xl103 width=90 style='font-size:8.0pt;width:68pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_date; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl65 style='font-size:8.0pt;height:12.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl112 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;text-align:center;border:1.0pt solid black;'><!--<input type='text' class='noborder'  onkeyup="javascript:swap(this.value)"  id='order-no2' value="--><? print $order['order_id']; ?><!--">-->	</td>
  <td colspan=2 class=xl112 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;font-size:9.0pt;text-align:center;border:1.0pt solid black;'><?php echo $order['date_added']; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=2 class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $osn; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=8 style='font-size:8.0pt;mso-height-source:userset;height:6.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=8 class=xl65 style='font-size:8.0pt;height:6.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl81 height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'>
  <td height=16 class=xl81 width=7 style='font-size:8.0pt;height:12.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td rowspan=4 class=xl103 width=70 style='font-size:8.0pt;width:53pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_debet; ?></td>
  <td colspan=4 class=xl103 width=237 style='font-size:8.0pt;border-left:none;width:178pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_kredit; ?></td>
  <td rowspan=4 class=xl103 width=88 style='font-size:8.0pt;width:66pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_sum; ?></td>
  <td rowspan=4 class=xl113 width=57 style='font-size:8.0pt;width:43pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'><? print $entry_kcn; ?></td>
  <td rowspan=4 class=xl103 width=33 style='font-size:8.0pt;width:25pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>&nbsp;</td>
  <td class=xl82 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;white-space:normal;mso-rotate:90;'></td>
  <td class=xl83 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;white-space:normal;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl110 width=187 style='font-size:8.0pt;width:141pt;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;white-space:normal;'>
  <?php print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  print $entry_from;  print $order['date_rus']; ?>
  </td>
  <td class=xl81 width=7 style='font-size:8.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
 </tr>
 <tr class=xl81 height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'>
  <td height=16 class=xl81 width=7 style='font-size:8.0pt;height:12.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td rowspan=3 class=xl103 width=44 style='font-size:8.0pt;border-top:none;width:33pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border:0.5pt solid black;white-space:normal;'>&nbsp;</td>
  <td rowspan=3 class=xl114 width=70 style='font-size:8.0pt;border-top:none;width:53pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;white-space:normal;'><? print $entry_ksp; ?></td>
  <td rowspan=3 class=xl114 width=63 style='font-size:8.0pt;border-top:none;width:47pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;white-space:normal;'><? print $entry_ksss?></td>
  <td rowspan=3 class=xl114 width=60 style='font-size:8.0pt;border-top:none;width:45pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;white-space:normal;'><? print $entry_kod_au?></td>
  <td class=xl84 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;white-space:normal;'></td>
  <td class=xl85 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;white-space:normal;'>&nbsp;</td>
  <td class=xl81 width=7 style='font-size:8.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
 </tr>
 <tr class=xl81 height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'>
  <td height=16 class=xl81 width=7 style='font-size:8.0pt;height:12.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl84 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;white-space:normal;'></td>
  <td class=xl85 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;white-space:normal;'>&nbsp;</td>
  <td class=xl81 width=7 style='font-size:8.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
 </tr>
 <tr class=xl81 height=16 style='font-size:8.0pt;mso-height-source:userset;height:12.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'>
  <td height=16 class=xl81 width=7 style='font-size:8.0pt;height:12.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl82 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;white-space:normal;mso-rotate:90;'></td>
  <td class=xl83 width=14 style='font-size:8.0pt;width:11pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;white-space:normal;mso-rotate:90;'>&nbsp;</td>
  <td class=xl81 width=66 style='font-size:8.0pt;width:50pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl81 width=31 style='font-size:8.0pt;width:23pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl81 width=13 style='font-size:8.0pt;width:10pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl81 width=39 style='font-size:8.0pt;width:29pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl81 width=38 style='font-size:8.0pt;width:29pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
  <td class=xl81 width=7 style='font-size:8.0pt;width:5pt;mso-style-parent:style0;text-align:center;vertical-align:top;white-space:normal;'></td>
 </tr>
 <tr class=xl65 height=21 style='font-size:8.0pt;mso-height-source:userset;height:15.95pt'>
  <td height=21 class=xl65 style='font-size:8.0pt;height:15.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl86 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;border-left:1.0pt solid black;'>50.01</td>
  <td class=xl87 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:left;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl88 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;	border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl88 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;	border-left:0.5pt solid black;'>62.01</td>
  <td class=xl88 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;	border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl89 style='font-size:8.0pt;text-align: center; border-left:none;mso-style-parent:style0;mso-number-format:Standard;text-align:right;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;border-left:0.5pt solid black;'><? print $order['index_nova'];  ?></td>
  <td class=xl88 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:1.0pt solid black;	border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl90 style='font-size:8.0pt;border-left:none;mso-style-parent:style0;text-align:left;vertical-align:middle;border-top:0.5pt solid black;border-right:1.0pt solid black;border-bottom:1.0pt solid black;border-left:0.5pt solid black;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $entry_sum_prop?></td>
  <td colspan=4 class=xl107 style='font-size:8.0pt;mso-style-parent:style0;font-weight:700;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>
  <? print $order['index_nova']; ?>
  </td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_digits; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $entry_get_from; ?></td>
  <td class=xl78 colspan=4 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;text-align:left;border:none;'><? print $order['firstname'].' '.$order['lastname']; ?></td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl108 width=187 style='font-size:8.0pt;width:141pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['total_2_str'];?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=4 style='font-size:8.0pt;mso-height-source:userset;height:3.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=4 class=xl65 style='font-size:8.0pt;height:3.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $entry_osn; ?></td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=8 rowspan=2 class=xl110 width=485 style='font-size:8.0pt;width:365pt;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;white-space:normal;'><? print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  ?> от <? print $order['date_rus']; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl91 style='font-size:8.0pt;border-top:none;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'><? print $entry_also; ?></td>
  <td colspan=4 class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_prop; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td colspan=5 rowspan=3 class=xl115 width=187 style='font-size:8.0pt;width:141pt;mso-style-parent:style0;text-align:left;vertical-align:top;white-space:normal;'><? print $entry_nds; ?> 
  <? print $order['all_nds']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=13 style='font-size:8.0pt;mso-height-source:userset;height:9.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=13 class=xl65 style='font-size:8.0pt;height:9.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $entry_sum_prop; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl92 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;'></td>
  <td class=xl93 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=8 rowspan=2 class=xl108 width=485 style='font-size:8.0pt;width:365pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['products_order_total_prop'];?></td>
  <td class=xl92 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;'></td>
  <td class=xl93 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl94 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;'></td>
  <td class=xl95 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl107 style='font-size:8.0pt;mso-style-parent:style0;font-weight:700;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><? print $order['date_rus']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=8 class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_prop; ?></td>
  <td class=xl92 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;'></td>
  <td class=xl93 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl96 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;vertical-align:top;'><? print $entry_also; ?></td>
  <td class=xl97 colspan=3 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;'><? print $entry_nds; print $order['all_nds']; ?></td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl78 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl98 colspan=2 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;'><? print $entry_mp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl96 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;vertical-align:top;'><? print $entry_pril; ?></td>
  <td colspan=7 class=xl110 width=415 style='font-size:8.0pt;width:312pt;mso-style-parent:style0;text-align:left;vertical-align:top;border:none;white-space:normal;'><?php print $entry_order_no; if ($order['invoice_no']) { echo $order['invoice_no']; }else  echo $order['order_id'];  ?> от <? print $order['date_rus']; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl99 colspan=4 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;vertical-align:top;'><? print $entry_buh; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=9 style='font-size:8.0pt;mso-height-source:userset;height:6.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=9 class=xl65 style='font-size:8.0pt;height:6.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl98 colspan=2 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;'><? print $entry_buh; ?></td>
  <td class=xl100 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;text-align:center-across;'></td>
  <td colspan=3 class=xl108 width=178 style='font-size:8.0pt;width:134pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['buh']; ?></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;mso-rotate:90;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:middle;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;mso-rotate:90;'>&nbsp;</td>
  <td class=xl100 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=3 class=xl108 width=90 style='font-size:8.0pt;width:68pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['buh']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 align=center style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl75 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'></td>
  <td colspan=3 class=xl116 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl101 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=3 class=xl69 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=13 style='font-size:8.0pt;mso-height-source:userset;height:9.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=13 class=xl65 style='font-size:8.0pt;height:9.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl71 colspan=3 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;color:white;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl101 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl98 style='font-size:8.0pt;mso-style-parent:style0;font-weight:700;text-align:left;'><? print $entry_kass; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl98 colspan=2 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-weight:700;text-align:left;'><? print $entry_get_kass; ?></td>
  <td class=xl100 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;text-align:center-across;'></td>
  <td colspan=3 class=xl108 width=178 style='font-size:8.0pt;width:134pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['kass']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl101 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl100 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=3 class=xl108 width=90 style='font-size:8.0pt;width:68pt;text-align: center;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['kass']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=10 style='font-size:8.0pt;mso-height-source:userset;height:8.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=10 class=xl65 style='font-size:8.0pt;height:8.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 align=center style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl75 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl69 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'></td>
  <td colspan=3 class=xl116 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl101 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:none;border-left:0.5pt dashed black;'>&nbsp;</td>
  <td class=xl79 style='font-size:8.0pt;mso-style-parent:style0;font-size:6.0pt;text-align:center;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=3 class=xl69 align=center style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:6.0pt;text-align:center-across;vertical-align:top;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
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
<?//if (isset($library)){require_once $library . 'ocbase_documents.php';}?>
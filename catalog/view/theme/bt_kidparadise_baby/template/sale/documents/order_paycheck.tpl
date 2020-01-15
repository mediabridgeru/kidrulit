<?
if(isset($_GET['excel7'])){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=paycheck-" . time() . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta name=ProgId content=Excel.Sheet>
<!--<link rel=Stylesheet href="view/template/sale/documents/order_paycheck.stylesheet.css">-->
</head>
<body link=blue vlink=purple>
<? $count = 0;?>
<?php  foreach ($orders as $order) { $count++;?>
<br>
<br>
 <div style="page-break-after: always;">
<table border=0 cellpadding=0 cellspacing=0 width=837 style='font-size:8.0pt;border-collapse:
 collapse;table-layout:fixed;width:638pt'>
 <col class=xl65 width=7 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:298;mso-style-parent:style0;text-align:left;
 width:5pt'>
 <col class=xl65 width=21 span=35 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:
 896;width:16pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=25 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:1066;
 width:19pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=1 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:42;
 width:1pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=20 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:853;
 width:15pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=1 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:42;
 width:1pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=20 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:853;
 width:15pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=1 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:42;
 width:1pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=20 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:853;
 width:15pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=1 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:42;
 width:1pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=6 style='font-size:8.0pt;mso-width-source:userset;mso-width-alt:256;
 width:5pt;mso-style-parent:style0;text-align:left;'>
 
 
 <tr class=xl65 height=48 style='font-size:8.0pt;mso-height-source:userset;height:36.0pt;mso-style-parent:style0;text-align:left;'>
  <td height=48 class=xl65 style='font-size:8.0pt;height:36.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=42 class=xl93 style='font-size:8.0pt;mso-style-parent:style0;font-size:14.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><? print $entry_paycheck.' '.$order['date_rus']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=15 style='font-size:8.0pt;height:11.45pt'>
  <td height=15 class=xl65 style='font-size:8.0pt;height:11.45pt'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl94 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_post; ?></td>
  <td colspan=38 class=xl95 width=739 style='font-size:8.0pt;width:563pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><?php echo $order['store_name']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl66 height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'>
  <td height=14 class=xl66 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
  <td class=xl66 style='font-size:8.0pt;mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl94 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_payer; ?></td>
  <td colspan=38 class=xl95 width=739 style='font-size:8.0pt;width:563pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'>
   <? 
   $payer = $order['firstname'].' '.$order['lastname'];
      if ($order['telephone']!==''){
	   $payer .= ', '.$order['telephone'];
	  }
   
      print $order['shipping_address']?$order['shipping_address']:$payer;  
   
   ?>
   </td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=15 style='font-size:8.0pt;height:11.45pt'>
  <td height=15 class=xl65 style='font-size:8.0pt;height:11.45pt'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 rowspan=2 class=xl96 width=42 style='font-size:8.0pt;width:32pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'>№</td>
  <td colspan=24 rowspan=2 class=xl97 width=504 style='font-size:8.0pt;width:384pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $entry_products; ?></td>
  <td colspan=5 rowspan=2 class=xl97 width=105 style='font-size:8.0pt;width:80pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $entry_kolvo; ?></td>
  <td colspan=4 rowspan=2 class=xl97 width=84 style='font-size:8.0pt;width:64pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $entry_price; ?></td>
  <td colspan=8 rowspan=2 class=xl98 width=89 style='font-size:8.0pt;width:68pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $entry_sum_prop; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <? if ($order['product']){
	 
	 $count = 0;
	 foreach($order['product'] as $product){
	 $count++;
	 ?>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:15.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=2 class=xl99 style='font-size:8.0pt;mso-style-parent:style0;mso-number-format:0;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $count;?></td>
  <td colspan=24 class=xl100 width=504 style='font-size:8.0pt;border-left:none;width:384pt;padding-left:20px;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;white-space:normal;'><? print $product['name']; ?></td>
  <td colspan=2 class=xl101 style='font-size:8.0pt;text-align:center;mso-style-parent:style0;mso-number-format:0;text-align:right;border:0.5pt solid black;'><? print $product['quantity']; ?></td>
  <td colspan=3 class=xl102 style='font-size:8.0pt;border-left:none;text-align:center;mso-style-parent:style0;text-align:right;border:0.5pt solid black;'>шт</td>
  <td colspan=4 class=xl103 style='font-size:8.0pt;border-left:none;text-align:center;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print number_format($product['free_nds'],2); ?></td>
  <td colspan=8 class=xl104 style='font-size:8.0pt;border-left:none;text-align:center;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($product['total'],2); ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
	 <? }
	 } ?>
 <tr class=xl65 height=6 style='font-size:8.0pt;mso-height-source:userset;height:5.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=6 class=xl65 style='font-size:8.0pt;height:5.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <? $total_summ = '';
    foreach($order['total'] as $total){
		if ($total['code'] == 'total'){
			$total_summ = $total['text'];
		}
	 ?>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'><? print $total['title'];?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl68 style='font-size:8.0pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;' ></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=4 class=xl68 style='font-size:8.0pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td colspan=8 class=xl105 style='font-size:8.0pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;'><? print $total['text']; ?></td>
  <td class=xl65></td>
 </tr>
 <? } ?>
 
 
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=42 class=xl107 style='font-size:8.0pt;mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'><? print $entry_all_naim.' '.$count; ?>, <? print $entry_to_summ.' '.$total_summ; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=42 class=xl108 style='font-size:8.0pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;'><? print $order['products_order_total_prop'];?></td>
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
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=9 style='font-size:8.0pt;mso-height-source:userset;height:6.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=9 class=xl65 style='font-size:8.0pt;height:6.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=15 style='font-size:8.0pt;height:11.45pt'>
  <td height=15 class=xl65 style='font-size:8.0pt;height:11.45pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=5 class=xl69 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_rk; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl71 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=14 class=xl109 width=294 style='font-size:8.0pt;width:224pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['owner']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 colspan=6 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_pbuh;?></td>
  
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl71 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=14 class=xl109 width=294 style='font-size:8.0pt;width:224pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['buh']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl73 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl74 width=21 style='font-size:8.0pt;width:16pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border:none;white-space:normal;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='font-size:8.0pt;mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='font-size:8.0pt;height:12.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 colspan=4 style='font-size:8.0pt;mso-ignore:colspan;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_manager; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='font-size:8.0pt;mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;border:none;'>&nbsp;</td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=14 class=xl109 width=294 style='font-size:8.0pt;width:224pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;white-space:normal;'><? print $order['manager']; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='font-size:8.0pt;mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='font-size:8.0pt;height:11.1pt'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=12 class=xl110 style='font-size:8.0pt;mso-style-parent:style0;text-align:center;vertical-align:top;'><? print $entry_podp_ras; ?></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='font-size:8.0pt;mso-style-parent:style0;text-align:left;'></td>
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
	mso-style-name:Обычный;
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
<? 
 ?>
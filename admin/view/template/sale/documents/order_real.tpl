<?
if(isset($_GET['excel7'])){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=real-" . time() . ".xls;");
header("Content-Transfer-Encoding: -binary");
}
?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
</head>
<body link=blue vlink=purple style='font-size:8.0pt;'>
<? $count = 0;?>
<?php foreach ($orders as $order) { $count++;?>
<br>
<br>
 <div style="page-break-after: always;">
<table border=0 cellpadding=0 cellspacing=0 width=831 style='border-collapse:
 collapse;table-layout:fixed;width:634pt'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;mso-style-parent:style0;text-align:left;
 width:5pt'>
 <col class=xl65 width=21 span=39 style='mso-width-source:userset;mso-width-alt:
 896;width:16pt;mso-style-parent:style0;text-align:left;'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;mso-style-parent:style0;text-align:left;
 width:5pt'>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt;mso-style-parent:style0;text-align:left;'>
  <td height=14 class=xl65 width=6 style='height:11.1pt;width:5pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=21 style='width:16pt;mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 width=6 style='width:5pt'></td>
 </tr>
 <tr class=xl65 height=29 style='mso-height-source:userset;height:21.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=29 class=xl65 style='height:21.95pt;mso-style-parent:style0;text-align:left;'></td>
  <td colspan=27 class=xl73 style='mso-style-parent:style0;font-size:14.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;border-top:none;	border-right:none;border-bottom:0.5pt solid black;border-left:none;'><? print $entry_real_text; ?><!--<input type='text' class='noborder'>--><? print $entry_from.$order['date_rus']; ?></td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=15 style='height:11.45pt'>
  <td height=15 class=xl65 style='height:11.45pt;mso-style-parent:style0;text-align:left;'></td>
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
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=5 class=xl74 style='mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_post; ?></td>
  <td colspan=23 class=xl75 width=483 style='width:368pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><?php echo $order['store_name']; ?></td>
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
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt;mso-style-parent:style0;text-align:left;'>
  <td height=9 class=xl65 style='height:6.95pt;mso-style-parent:style0;text-align:left;'></td>
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
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=5 class=xl74 style='mso-style-parent:style0;font-size:9.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:middle;'><? print $entry_payer; ?></td>
  <td colspan=23 class=xl75 width=483 style='width:368pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'>
     <? 
   $payer = $order['firstname'].' '.$order['lastname'];
      if ($order['telephone']!==''){
	   $payer .= ', '.$order['telephone'];
	  }
   
      print $order['shipping_address']?$order['shipping_address']:$payer;  
   
   ?>

  </td>
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
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
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
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=2 rowspan=2 class=xl76 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;	border-top:0.5pt solid black;border-right:none;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'>№</td>
  <td colspan=24 rowspan=2 class=xl77 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:0.5pt solid black;'><? print $entry_product; ?></td>
  <td colspan=5 rowspan=2 class=xl78 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $entry_kolvo; ?></td>
  <td colspan=4 rowspan=2 class=xl78 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $entry_price; ?></td>
  <td colspan=4 rowspan=2 class=xl79 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:center;vertical-align:middle;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $entry_sum_prop; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <? if ($order['product']){
	 
	 $count = 0;
	 foreach($order['product'] as $product){
	 $count++;
	 ?>
 
  <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=2 class=xl80 style='text-align:center;mso-style-parent:style0;mso-number-format:0;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print $count;?></td>
  <td colspan=24 class=xl81 width=504 style='border-left:none;width:384pt;padding-left:10px;mso-style-parent:style0;text-align:left;border:0.5pt solid black;white-space:normal;'><? print $product['report_name']; ?></td>
  <td colspan=2 class=xl82 style='border-left:none;text-align:center;mso-style-parent:style0;mso-number-format:0;text-align:right;border:0.5pt solid black;'><? print $product['quantity']; ?></td>
  <td colspan=3 class=xl83 style='border-left:none;text-align:center;mso-style-parent:style0;text-align:right;border:0.5pt solid black;'>шт</td>
  <td colspan=4 class=xl84 style='border-left:none;text-align:center;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border:0.5pt solid black;'><? print number_format($product['free_nds'],2); ?></td>
  <td colspan=4 class=xl85 style='border-left:none;text-align:center;mso-style-parent:style0;mso-number-format:Fixed;text-align:right;border-top:0.5pt solid black;border-right:0.5pt solid black;border-bottom:0.5pt solid black;border-left:0.5pt solid black;'><? print number_format($product['total'],2); ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <?
  }
	 } ?>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl67 style='mso-style-parent:style0;text-align:left;border-top:0.5pt solid black;border-right:none;border-bottom:none;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
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
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td colspan=4 class=xl68 style='text-align:left;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'><? print $entry_itog; ?></td>
  <td colspan=4 class=xl86 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;'><? print $order['products_order_total']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl69 height=17 style='mso-height-source:userset;height:12.95pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'>
  <td height=17 class=xl69 style='height:12.95pt;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'><? print $entry_vtch; ?></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td class=xl68 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'></td>
  <td colspan=4 class=xl86 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;mso-number-format:Fixed;text-align:right;'><? print $order['clean_products_nds']; ?></td>
  <td class=xl69 style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'></td>
 </tr>
 <? $total_summ = '';
    //print $order['all_nds'];
	//print_r($order['total']);
	foreach($order['total'] as $total){
		if ($total['code'] == 'total'){
			$total_summ = $total['text'];
		}
	}
 ?>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
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
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=39 class=xl87 style='mso-style-parent:style0;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;'><? print $entry_all_naim.' '.$count; ?>, <? print $entry_to_summ.' '.$order['products_order_total_valute']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=39 class=xl75 width=819 style='width:624pt;mso-style-parent:style0;font-size:9.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;vertical-align:top;white-space:normal;'><? print $order['products_order_total_prop']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl66 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=15 style='height:11.45pt'>
  <td height=15 class=xl65 style='height:11.45pt'></td>
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
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class= style='mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;'><? print $entry_who_gave; ?></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl71 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl71 style='mso-style-parent:style0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=8 class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'><? print $order['manager']; ?></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl69 colspan=3 style='mso-ignore:colspan;mso-style-parent:style0;font-size:10.0pt;font-weight:700;font-family:Arial, sans-serif;mso-font-charset:0;	text-align:left;'><? print $entry_who_receive; ?></td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl70 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:left;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td colspan=8 class=xl72 style='mso-style-parent:style0;font-size:10.0pt;font-family:Arial, sans-serif;mso-font-charset:0;text-align:right;border-top:none;border-right:none;border-bottom:0.5pt solid black;border-left:none;'>&nbsp;</td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
  <td class=xl65 style='mso-style-parent:style0;text-align:left;'></td>
 </tr>

</table>
</div>
<br>
<br>

<? }  ?>
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
 width:55px;
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
.xl65
	{mso-style-parent:style0;text-align:left;}
</style>
<?//if (isset($library)){require_once $library . 'ocbase_documents.php';}?>
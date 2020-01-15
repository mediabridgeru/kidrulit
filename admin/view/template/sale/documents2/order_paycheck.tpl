<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<meta name=ProgId content=Excel.Sheet>
<link rel=Stylesheet href="view/template/sale/documents/order_paycheck.stylesheet.css">
</head>
<body link=blue vlink=purple>
<? $count = 0;?>
<?php  foreach ($orders as $order) { $count++;?>
<br>
<br>
 <div style="page-break-after: always;">
<table border=0 cellpadding=0 cellspacing=0 width=837 style='border-collapse:
 collapse;table-layout:fixed;width:638pt'>
 <col class=xl65 width=7 style='mso-width-source:userset;mso-width-alt:298;
 width:5pt'>
 <col class=xl65 width=21 span=35 style='mso-width-source:userset;mso-width-alt:
 896;width:16pt'>
 <col class=xl65 width=25 style='mso-width-source:userset;mso-width-alt:1066;
 width:19pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;
 width:15pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;
 width:15pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=20 style='mso-width-source:userset;mso-width-alt:853;
 width:15pt'>
 <col class=xl65 width=1 style='mso-width-source:userset;mso-width-alt:42;
 width:1pt'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;
 width:5pt'>
 
 
 <tr class=xl65 height=48 style='mso-height-source:userset;height:36.0pt'>
  <td height=48 class=xl65 style='height:36.0pt'></td>
  <td colspan=42 class=xl93><? print $entry_paycheck.' '.$order['date_rus']; ?></td>
  <td class=xl65></td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=4 class=xl94><? print $entry_post; ?></td>
  <td colspan=38 class=xl95 width=739 style='width:563pt'><?php echo $order['store_name']; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr class=xl66 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl66 style='height:11.1pt'></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
  <td class=xl66></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=4 class=xl94><? print $entry_payer; ?></td>
  <td colspan=38 class=xl95 width=739 style='width:563pt'>
   <? 
   $payer = $order['firstname'].' '.$order['lastname'];
      if ($order['telephone']!==''){
	   $payer .= ', '.$order['telephone'];
	  }
   
      print $order['shipping_address']?$order['shipping_address']:$payer;  
   
   ?>
   </td>
  <td class=xl65></td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=2 rowspan=2 class=xl96 width=42 style='width:32pt'>№</td>
  <td colspan=24 rowspan=2 class=xl97 width=504 style='width:384pt'><? print $entry_products; ?></td>
  <td colspan=5 rowspan=2 class=xl97 width=105 style='width:80pt'><? print $entry_kolvo; ?></td>
  <td colspan=4 rowspan=2 class=xl97 width=84 style='width:64pt'><? print $entry_price; ?></td>
  <td colspan=8 rowspan=2 class=xl98 width=89 style='width:68pt'><? print $entry_sum_prop; ?></td>
  <td class=xl65></td>
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
 </tr>
 <? if ($order['product']){
	 
	 $count = 0;
	 foreach($order['product'] as $product){
	 $count++;
	 ?>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=2 class=xl99><? print $count;?></td>
  <td colspan=24 class=xl100 width=504 style='border-left:none;width:384pt;padding-left:20px;'><? print $product['name']; ?></td>
  <td colspan=2 class=xl101 style='text-align:center'><? print $product['quantity']; ?></td>
  <td colspan=3 class=xl102 style='border-left:none;text-align:center'>шт</td>
  <td colspan=4 class=xl103 style='border-left:none;text-align:center'><? print number_format($product['free_nds'],2); ?></td>
  <td colspan=8 class=xl104 style='border-left:none;text-align:center'><? print number_format($product['total'],2); ?></td>
  <td class=xl65></td>
 </tr>
	 <? }
	 } ?>
 <tr class=xl65 height=6 style='mso-height-source:userset;height:5.1pt'>
  <td height=6 class=xl65 style='height:5.1pt'></td>
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
  <td class=xl67>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <? $total_summ = '';
    foreach($order['total'] as $total){
		if ($total['code'] == 'total'){
			$total_summ = $total['text'];
		}
	 ?>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
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
  <td class=xl68 style='text-align: left'><? print $total['title'];?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl68 ></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=4 class=xl68 ></td>
  <td colspan=8 class=xl105><? print $total['text']; ?></td>
  <td class=xl65></td>
 </tr>
 <? } ?>
 
 
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=42 class=xl107><? print $entry_all_naim.' '.$count; ?>, <? print $entry_to_summ.' '.$total_summ; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=42 class=xl108><? print $order['products_order_total_prop'];?></td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt'></td>
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
  <td class=xl65></td>
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
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td colspan=5 class=xl69><? print $entry_rk; ?></td>
  <td class=xl65></td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl71>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=14 class=xl109 width=294 style='width:224pt'><? print $order['owner']; ?></td>
  <td class=xl65></td>
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
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td class=xl69 colspan=4 style='mso-ignore:colspan'><? print $entry_pbuh;?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl71>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=14 class=xl109 width=294 style='width:224pt'><? print $order['buh']; ?></td>
  <td class=xl65></td>
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
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl74 width=21 style='width:16pt'>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt'></td>
  <td class=xl69 colspan=4 style='mso-ignore:colspan'><? print $entry_manager; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl70>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl65></td>
  <td colspan=14 class=xl109 width=294 style='width:224pt'><? print $order['manager']; ?></td>
  <td class=xl65></td>
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
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp; ?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td colspan=12 class=xl110><? print $entry_podp_ras; ?></td>
  <td class=xl65></td>
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
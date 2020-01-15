<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="view/template/sale/documents/order_real.stylesheet.css" />
</head>
<body link=blue vlink=purple>
<?php foreach ($orders as $order) { $count++;?>
 <div <? if (count($orders)>1){ ?> style="page-break-after: always;"<? } ?> >
<table border=0 cellpadding=0 cellspacing=0 width=531 style='border-collapse:
 collapse;table-layout:fixed;width:534pх' class="vmain">
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;
 width:5pt'>
 <col class=xl65 width=21 span=39 style='mso-width-source:userset;mso-width-alt:
 896;width:16pt'>
 <col class=xl65 width=6 style='mso-width-source:userset;mso-width-alt:256;
 width:5pt'>
 <tr class=xl65 height=29 style='mso-height-source:userset;height:21.95pt'>
  <td height=29 class=xl65 style='height:21.95pt'></td>
  <td><img src="./view/template/sale/documents/logo.jpg"></td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl64>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65></td>
  <td class=xl65>&nbsp;</td>
  <td class="xl65 vrightphone" style="vertical-align: top;padding-top: 35px;font-size: 18px;"><span>8-800-775-20-39</span><br><span>8-495-133-75-39</span><br><span class="vemail" style='margin-left: -60px'>info@magazin-poputi.ru</span></td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  </tr>
 <tr height=15 style='height:11.45pt'>
  <td height=15 style='height:11.45pt;font-size:14px;padding-left:20px;'>Благодарим за заказ в интернет-магазине "По пути"!</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
  <td style='border-bottom: 1px solid #ccc'>
  <br>
  <?
       
	  $shipping = $order['shipping_address'];
	  $m = explode(',',$shipping);
	  // вычленяем фио
	  if (strlen($shipping)>120){ 
	 // имя
	 $name = $m[0];
	 $count = 0;
	 $shipping = '';
	 for($i=1; $i<=count($m)-1; $i++){
	  $count++;
	  if ($count  == count($m)-1)
	   $shipping .= '<br>';
	   $shipping .= $m[$i];
	  if ($count != count($m)-1) $shipping .=', ';
	 }
	}else 
	for($i=1; $i<=count($m)-1; $i++){
	 $shippinng .= $m[$i].', ';
	}
  ?>
  <table style="width:700px; padding-left: 18px">
   <tr class="border-left-right f12"><td class="theader" colspan=2 style='background-color: #dddddd;padding:10px; font-size: 12px;'>Детализация заказа</td></tr>
   <tr class="border-left-right f12"><td style='width:350px'>№ заказа: <span><? print $order['order_id']; ?></span></td><td style='width:350px;border-right: 1px solid #ccc'>Заказчик: <? print $name; ?></td></tr>
   <tr class="border-left-right f12"><td style='width:350px'>Дата заказа: <span><? print $order['date_added']; ?></span></td><td style='width:350px;border-right: 1px solid #ccc'>E-mail: <span><? print $order['email']; ?></span></td></tr>
   <tr class="border-left-right f12"><td style='width:350px'>Способ оплаты: <span><? print $order['payment_method']; ?></span></td><td style='width:350px;border-right: 1px solid #ccc'>Телефон: <span><? print $order['telephone']; ?></span></td></tr>
   <tr class="border-left-right f12"><td style='width:350px'>Способ доставки: <span><? print $order['shipping_method']; ?></span></td><td style='width:350px;border-right: 1px solid #ccc'></td></tr>
   <tr class="border-left-right f12"><td style='width:350px;border-bottom: 1px solid #ccc;'>Адрес доставки:<br> 
   <span>
	<? 
	 print $shipping; 
	?>
	</span></td>
   <td style='width:350px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
  </table></td>
  
  
  </tr>
 <tr><td><br><br><br></td></tr>
 <tr><td colspan=36 class="tcheck" style='text-align: center;font-size: 15px;'>ТОВАРНЫЙ ЧЕК №<? print $order['order_id']; ?> от <? print $order['date_added']; ?></td></tr>
 <tr><td><br><br></td></tr>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt;padding-left: 25px; font-size: 14px;'>Продавец: <? echo $order['store_name'];?></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr><td><td></tr>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt;padding-left: 25px; font-size: 14px;'>ИП Чекуряев С.В., ИНН: 732818576237, ОГРНИП 315732800006738 </td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr><td><br><td></tr>
 
 <tr height=14 style='mso-height-source:userset;height:11.1pt;padding-left: 20px'>
  <td style='width: 30px'>&nbsp;</td>
  <td style='width: 30px'>&nbsp;</td>
  <td colspan=19 rowspan=2 class="xl77 theader" style='text-align:left;background-color: #dddddd;border: 1px solid #ccc;padding-left: 10px'><? print $entry_product; ?></td>
  <td colspan=5 rowspan=2 class="xl78 theader" style='background-color: #dddddd;border: 1px solid #ccc'><? print $entry_kolvo; ?></td>
  <td colspan=4 rowspan=2 class="xl78 theader" style='background-color: #dddddd;border: 1px solid #ccc'><? print $entry_price; ?></td>
  <td colspan=4 rowspan=2 class="xl79 theader" style='background-color: #dddddd;border: 1px solid #ccc'>Итого:</td>
  <td class=xl65></td>
 </tr>
 <tr class=xl65 height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td class=xl65></td>
 </tr>
 <? if ($order['product']){
	 
	 $count = 0;
	 foreach($order['product'] as $product){
	 $count++;
	 ?>
 
  <tr height=14 style='mso-height-source:userset;height:11.1pt;'>
  <td style='width: 30px'>&nbsp;</td>
  <td style='width: 30px'>&nbsp;</td>
  <td colspan=19 class=xl81 width=504 style='vertical-align: middle;width:384pt;padding-left:10px;padding-top: 5px;border: 1px solid #ccc'>
   <? print $product['name']; ?>
   <? 
    foreach($product['option'] as $option){
	 print '<br>&nbsp;&nbsp;<small>-'.$option['value'].'</small>';
	}
   ?>
   </td>
  <td colspan=5 class=xl82 style='vertical-align: middle;border-left:none;text-align:center;border: 1px solid #ccc'><? print $product['quantity']; ?></td>
  <td colspan=4 class=xl84 style='vertical-align: middle;border-left:none;text-align:center;border: 1px solid #ccc'><? print number_format($product['free_nds'],2); ?></td>
  <td colspan=4 class=xl85 style='vertical-align: middle;border-left:none;text-align:center;border: 1px solid #ccc'><? print number_format($product['total'],2); ?></td>
  <td class=xl65></td>
 </tr>
 <?
  }
	 } ?>
 <? foreach($order['total'] as $total){ ?>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt;'>
  <td height=9 class=xl65 style='height:6.95pt;'></td>
  <td>&nbsp;</td>
  <td class=x65 style='border-left: 1px solid #ccc;'>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65>&nbsp;</td>
  <td class=x65 colspan=15 style='text-align: right;padding-right: 25px'>&nbsp;<? print $total['title'];?></td>
  <td class=x65 style='text-align: right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? print $total['text']; ?></td>
  <td class=x65>&nbsp;</td>
  <td class=x65 >&nbsp;</td>
  <td class=x65  style=' border-right: 1px solid #ccc'>&nbsp;</td>
 </tr>
 <? } ?>
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
  <td class=xl68></td>
  <td colspan=4 class=xl68 style='text-align:left'></td>
  <td colspan=4 class=xl86></td>
  <td class=xl65></td>
 </tr>
 <? $total_summ = '';
	foreach($order['total'] as $total){
		if ($total['code'] == 'total'){
			$total_summ = $total['text'];
		}
	}
 ?>
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
 </tr>
 <tr height=14 style='mso-height-source:userset;height:11.1pt'>
  <td height=14 class=xl65 style='height:11.1pt'></td>
  <td colspan=39 class=xl87 style='padding-left: 20px; font-size: 12px;'>Всего: (Сумма прописью) <? print $order['total_2_str']; ?></td>
  <td class=xl65></td>
 </tr>
 <tr><td><br><br></td></tr>
 <tr height=17 style='mso-height-source:userset;height:12.95pt'>
  <td height=17 class=xl65 style='height:12.95pt;padding-left: 25px; font-size: 14px;'>Подпись продавца_____________      м.п.</td>
  <td colspan=39 class=xl75 width=819 style='width:624pt'></td>
  <td class=xl65></td>
 </tr>
 <tr><td><br><br></td></tr>
 <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt;padding-left: 25px;font-size: 12px'>Покупатель: Товар получен без повреждений, претензий к внешнему виду и комплектности не имею. С порядком обме-<br>на, возврата и эксплуатации ознакомлен</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65></td>
 </tr>
 <tr><td><br><br></td></tr>
 <tr height=15 style='height:11.45pt'>
  <td height=15 class=xl65 style='height:11.45pt;padding-left: 25px;font-size: 14px'>Подпись покупателя __________________</td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
  <td class=xl65></td>
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
 <tr><td><br><br></td></tr>
  <tr class=xl65 height=9 style='mso-height-source:userset;height:6.95pt'>
  <td height=9 class=xl65 style='height:6.95pt;padding-left: 25px;font-size: 12px'>Правила дистанционной торговли<br>
  Потребитель вправе отказаться от товара в любое время до его передачи, а после &nbsp;передачи в течении &nbsp;четырнадцати<br> дней. <br>
  Возврат товара надлежащего качества возможен в случае, если сохранены его товарный вид(упаковка),
  потребительс-<br>кие  свойства, а так же документ, подтверждающий факт и условия покупки данного товара.<br> 
  Отсутствие у потребителя документа, подтверждающего факт и условие покупки данного товара, не лишает
  его возмож-<br> ности&nbsp; ссылаться &nbsp;на &nbsp;другие &nbsp;доказательства&nbsp; приобретения&nbsp; товара &nbsp;у данного продавца. "Статья 26.1. Дистанционный<br> способ продажи товара(введен Федеральным законом от 21.12.2004 #171-Ф3)."
  </td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65>&nbsp;</td>
  <td class=xl65></td>
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
.border-left-right{
 border-left: 1px solid #ccc; border-right: 1px solid #ccc;
}
.x167{
 border-style: none none none !important;
}
 .f12 td{
 font-size: 12px;
 padding-left: 10px;
 font-weight: bold;
 padding-top: 3px;
 border-left: 1px solid #ccc;
 }
 .f12 td span{
  width: 50%;
  font-weight: normal;
 }
 .x65{
  padding-top:3px !important;
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
 }
@media print{
 .theader{background-color: #dddddd;
    padding: 10px;
    font-size: 12px;
	-webkit-print-color-adjust: exact;
	}
  body{
  -webkit-transform: scaleX(0.8);
  -moz-transform: scaleX(0.8);
  -o-transform: scaleX(0.8);
  -ms-transform: scaleX(0.8);
  }
	} 
</style>

<!--  .vmain{
   margin: 0 auto;
  }
 html, body, span, td{
  font-size: 16px;
 }
 .vrightphone span:not(.vemail){
  margin-left: 120px !important;
 }
 .vemail{
  margin-left: 70px !important;
 }
 table{
  width: 780px;
 }
 .tcheck{
  font-size: 20px;
 }
 

-->
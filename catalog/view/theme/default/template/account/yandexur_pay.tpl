<?php if ($debug == 1) { ?><xmp class="codetext"><?php } ?>
<form method="POST" name="form" action="<?php echo $yadserver; ?>"> 
	<input type="hidden" name="ShopID" value="<?php echo $ShopID; ?>">
	<input type="hidden" name="scid" value="<?php echo $scid; ?>">
	<input type="hidden" name="sum" value="<?php echo $total; ?>" data-type="number" >
	<input type="hidden" name="customerNumber" value="<?php echo $order_text; ?>" >
	<input type="hidden" name="shopSuccessURL" value="<?php echo $shopSuccessURL; ?>" >
	<input type="hidden" name="shopFailURL" value="<?php echo $shopFailURL; ?>" >
	<input type="hidden" name="cps_email" value="<?php echo $email; ?>" >
	<input type="hidden" name="cps_phone" value="<?php if ($paymentType != 'WM') { echo $phone; } ?>" >
 	<input type="hidden" name="paymentType" value="<?php echo $paymentType; ?>">
 	<input type="hidden" name="orderNumber" value="<?php echo $order_id; ?>">
 	<input type="hidden" name="order" value="<?php echo $order_id; ?>">
	<?php if (isset($okassa)){ ?><input type="hidden" name="ym_merchant_receipt" value='<?php echo $okassa; ?>'>
    <?php } ?>
    <?php if (isset($first)){ ?><input type="hidden" name="first" value="1">
<?php } ?>
</form>
<?php if ($debug != 1) { ?>  
<script>
document.form.submit();
</script>
<?php } if ($debug == 1) { ?>
</xmp>
<?php } ?>

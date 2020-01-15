<?php if ($instructionat){ ?>
<h2><?php echo $text_instruction; ?></h2>
<div class="content">
  <p><?php echo $sbacquiringi; ?></p>
</div>
<?php } ?>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>
<?php if ($btnlater){ ?><div class="left"><input class="paylater button" type="button" value="<?php echo $button_later; ?>" id="button-pay"  style="float:right;"/></div> <?php } ?>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
		<?php if (!isset($notcreate)) { ?>
		url: 'index.php?route=payment/sbacquiring/confirm',
		<?php } ?>
		success: function() {
			location = '<?php echo $pay_url; ?>';
		}		
	});
});
<?php if ($btnlater){ ?>
$('#button-pay').bind('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/sbacquiring/confirm',
		success: function() {
			location = '<?php echo $payment_url; ?>';
		}		
	});
});
<?php } ?>
//--></script>

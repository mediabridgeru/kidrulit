<div class="buttons">
    <div class="right">
        <a id="bb_confirm" class="button"><span><?php echo $button_confirm; ?></span></a>
    </div>
</div>
<script type="text/javascript"><!--
$('#bb_confirm').click(function() {
	$.ajax({
		type: 'GET',
		url: 'index.php?route=payment/bb_payment/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>

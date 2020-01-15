<?php if (count($currencies) > 1) { ?>
<form  id="formcurrency" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
 	<div id="currency">  
		<label class="select">
		<select id="currencybox" onchange=" $('input[name=\'currency_code\']').attr('value', this.value).submit(); $('#formcurrency').submit();">
			  <?php foreach ($currencies as $currency) { ?>
			  <option id="<?php echo $currency['code']; ?>"  value="<?php echo $currency['code']; ?>" <?php if ($currency['code'] == $currency_code) echo("selected='selected'") ?>>
				  <?php if ($currency['symbol_left']) { ?>
						<?php echo $currency['code']; ?>
				  <?php } else { ?>
						<?php echo $currency['code']; ?>
				  <?php } ?>
			  </option>
			  <?php } ?>
		</select>
		</label>
		<input type="hidden" name="currency_code" value="" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
	</div>
</form>

<script type="text/javascript"><!--
$(document).ready(function() {
$(".boss_select").selectbox();
});
//--></script>
<?php } ?>

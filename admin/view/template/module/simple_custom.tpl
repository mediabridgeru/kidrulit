<h2>Simple Data</h2>
<table class="form">
<?php if ($type == 'customer'){ ?>
	<?php foreach ($custom_fields as $key => $field) { ?>
	  <?php $value = (isset($custom[$key])) ? $custom[$key]['value']:'' ;?>
	  <tr>
		<td><?php echo $field['label']['ru']; ?></td>
		<td>
			<?php if($field['type'] == 'text'){ ?>
				<input name="<?php echo $key; ?>" type="text" value="<?php echo $value; ?>" />
			<?php } else { ?>
				<select name="<?php echo $key; ?>" type="text">
					<?php foreach (explode(';',$field['values']['ru']) as $value_label) { 
						if(strlen($value_label) == 0) continue;
						list($option_value, $option_label) = explode('=',$value_label);
						?>
						<option <?php echo ($option_value == $value)?'selected':'' ; ?> value="<?php echo $option_value; ?>">
							<?php echo $option_label; ?>
						</option>
					<?php } ?>
				</select>
			<?php } ?>
		</td>
	  </tr>
	<?php } ?>
	<?php foreach ($custom_typed_fields as $type => $fields) { ?>
	<tr>
		<td></td>
		<td><b><?php if ($type == 'ip_type') { ?>ИП<?php } ?>
			<?php if ($type == 'legal_type') { ?>Юридическое лицо<?php } ?></b>
		</td>
	</tr>
		<?php foreach ($fields as $key => $field) { ?>
		<?php $value = (isset($custom[$key])) ? $custom[$key]['value']:'' ;?>
		<tr>
			<td><?php echo $field['label']['ru']; ?></td>
			<td>
				<?php if($field['type'] == 'text'){ ?>
				<input name="<?php echo $key; ?>" type="text" value="<?php echo $value; ?>" size="120">
				<?php } else { ?>
				<select name="<?php echo $key; ?>" type="text">
					<?php foreach (explode(';',$field['values']['ru']) as $value_label) {
							if(strlen($value_label) == 0) continue;
							list($option_value, $option_label) = explode('=',$value_label);
							?>
					<option <?php echo ($option_value == $value)?'selected':'' ; ?> value="<?php echo $option_value; ?>">
					<?php echo $option_label; ?>
					</option>
					<?php } ?>
				</select>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	<?php } ?>
<?php } else { ?>
	<?php foreach ($custom as $key => $field) { ?>
		<tr>
			<td><?php echo $field['label']; ?></td>
			<td><?php echo $field['value']; ?></td>
		</tr>
	<?php } ?>
<?php } ?>
</table>
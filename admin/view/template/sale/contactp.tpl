<div class="block-box">
<?php if (!empty($mails['error'])) { ?>
	<div class="mails-error"><?php echo $mails['error']; ?></div>
<?php } else { ?>
	<?php if (!empty($mails['mails'])) { ?>
	<div id="vtabs-mails" class="vtabs">
		<?php foreach ($mails['mails'] as $key => $mail) { ?>
		<div class="vtabs-mail-head">
			<input type="checkbox" name="selected[]" value="<?php echo $key; ?>" />
			<a onclick="getmailbody('<?php echo $key; ?>','0');" href="#tab-mail-<?php echo $key; ?>" class="vtabs-mail"><?php echo $mail['subject']; ?><br /><?php echo $mail['from']; ?></a>
		</div>
		<?php } ?>
	</div>
	<?php foreach ($mails['mails'] as $key => $mail) { ?>
	<div id="tab-mail-<?php echo $key; ?>" class="vtabs-content vtabs-content-mail">
		<div class="block-content content-mail">
			<table class="form">
			<?php if ($mail['headers']) { ?>
			  <tbody class="mail-headers">
				<?php foreach ($mail['headers'] as $name => $value) { ?>
					<?php if ($name == 'subject') { ?><tr><td><?php echo $text_subject; ?></td><td><?php echo $value; ?></td></tr><?php } ?>
					<?php if ($name == 'from') { ?><tr><td><?php echo $text_from; ?></td><td><?php echo $value; ?></td></tr><?php } ?>
					<?php if ($name == 'to') { ?><tr><td><?php echo $text_to; ?></td><td><?php echo $value; ?></td></tr><?php } ?>
					<?php if ($name == 'date') { ?><tr><td><?php echo $text_date; ?></td><td><?php echo $value; ?></td></tr><?php } ?>
					<?php if ($name == 'x-failed-recipients') { ?><tr><td><?php echo $name; ?></td><td class="failed-recipient"><?php echo $value; ?></td></tr><?php } ?>
				<?php } ?>
			  </tbody>
			<?php } ?>
			  <tbody class="mail-separator">
				<tr>
				  <td colspan="2">
					<div class="mail-buttons">
						<a onclick="getmailbody('<?php echo $key; ?>','1');" class="btn btn-mview" title="<?php echo $text_viewraw; ?>"></a>
					</div>
				  </td>
				</tr>
			  </tbody>
			  <tbody class="mail-body">
				<tr>
				  <td class="body-block" colspan="2"></td>
				</tr>
			  </tbody>
			</table>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
<?php } ?>
<script type="text/javascript"><!--	
$('#vtabs-mails a').tabs();
//--></script>
</div>
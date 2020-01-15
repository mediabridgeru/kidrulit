<table class="list">
	<thead>
	  <tr>
		<td class="center icon">№</td>
		<td class="center date"><?php echo $column_date_added; ?></td>
		<td class="center sendto"><?php echo $column_send_to; ?></td>
		<td class="center subject"><?php echo $column_subject; ?></td>
		<td class="center icon hidemd"><img src="view/image/contacts/internet24.png" title="<?php echo $column_region; ?>" /></td>
		<td class="center icon hidemd"><img src="view/image/contacts/nvtv24.png" title="<?php echo $column_products; ?>" /></td>
		<td class="center icon hidemd"><img src="view/image/contacts/attachment24.png" title="<?php echo $column_attachments; ?>" /></td>
		<td class="center icon hidemd"><img src="view/image/contacts/postman24.png" title="<?php echo $column_unsub_url; ?>" /></td>
		<td class="center icon hidemd"><img src="view/image/contacts/spy24.png" title="<?php echo $column_control_unsub; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/group24.png" title="<?php echo $column_email_total; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/mview24.png" title="<?php echo $column_email_open; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/groupnew24.png" title="<?php echo $column_email_click; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/unsub24.png" title="<?php echo $column_email_unsub; ?>" /></td>
		<td class="center action"><?php echo $column_action; ?></td>
	  </tr>
	</thead>
	<tbody>
	<?php if ($mailings) { ?>
		<?php foreach ($mailings as $mailing) { ?>
		<tr id="mailing_<?php echo $mailing['send_id']; ?>">
			<td class="center"><?php echo $mailing['send_id']; ?></td>
			<td class="center"><?php echo $mailing['date_added']; ?></td>
			<td class="left"><?php echo $mailing['send_to']; ?>
				<?php if($mailing['send_data']) { ?>
					(<?php echo $mailing['send_data']; ?>)
				<?php } ?>
			</td>
			<td class="left send-subject"><?php echo $mailing['subject']; ?></td>
			<td class="center send-region hidemd">
				<?php if($mailing['send_region']) { ?>
					<div title="<?php echo $mailing['country_name']; ?>"><?php echo $mailing['country_iso']; ?></div>
					<div title="<?php echo $mailing['zone_name']; ?>"><?php echo $mailing['zone_code']; ?></div>
				<?php } else { ?><div>-</div><?php } ?>
			</td>
			<td class="center hidemd">
				<?php if($mailing['products']) { ?><img src="view/image/success.png" /><?php } else { ?><div>-</div><?php } ?>
			</td>
			<td class="center hidemd">
				<?php if($mailing['attachments']) { ?><img src="view/image/success.png" /><?php } else { ?><div>-</div><?php } ?>
			</td>
			<td class="center hidemd">
				<?php if($mailing['unsub_url']) { ?><img src="view/image/success.png" /><?php } else { ?><div>-</div><?php } ?>
			</td>
			<td class="center hidemd">
				<?php if($mailing['control_unsub']) { ?><img src="view/image/success.png" /><?php } else { ?><div>-</div><?php } ?>
			</td>
			<td class="center"><?php echo $mailing['email_total']; ?></td>
			<td class="center">
				<a onclick="viewopens('<?php echo $mailing['send_id']; ?>');"><?php echo $mailing['email_open']; ?></a>
			</td>
			<td class="center">
				<a onclick="viewclicks('<?php echo $mailing['send_id']; ?>');"><?php echo $mailing['email_click']; ?></a>
			</td>
			<td class="center">
				<a onclick="viewunsub('<?php echo $mailing['send_id']; ?>');"><?php echo $mailing['email_unsub']; ?></a>
			</td>
			<td class="right">
				<a onclick="viewmessage('<?php echo $mailing['send_id']; ?>');" class="btn btn-mview" title="<?php echo $text_mview; ?>"></a>
				<a onclick="viewnewmessage('<?php echo $mailing['send_id']; ?>');" class="btn btn-nmview" title="<?php echo $text_nmview; ?>"></a>
				<a onclick="delmailing('<?php echo $mailing['send_id']; ?>');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a>
			</td>
		</tr>
		<?php } ?>
		<?php } else { ?>
			<tr class="nomailing">
			  <td class="center" colspan="14"><?php echo $text_no_data; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
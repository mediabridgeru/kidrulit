<table class="list">
	<thead>
	  <tr>
		<td class="center numbers">№</td>
		<td class="center date"><?php echo $column_date_start; ?></td>
		<td class="center period"><?php echo $column_period; ?></td>
		<td class="center date"><?php echo $column_date_next; ?></td>
		<td class="center name"><?php echo $column_cron_name; ?></td>
		<td class="center sendto"><?php echo $column_send_to; ?></td>
		<td class="center email-total"><img src="view/image/contacts/customers20.png" title="<?php echo $column_email_total; ?>" /></td>
		<td class="center cron-count"><img src="view/image/contacts/count20.png" title="<?php echo $column_cron_count; ?>" /></td>
		<td class="center cron-status"><?php echo $column_cron_status; ?></td>
		<td class="center status"><?php echo $column_status; ?></td>
		<td class="center action"><?php echo $column_action; ?></td>
	  </tr>
	</thead>
	<tbody>
	<?php if ($crons) { ?>
		<?php foreach ($crons as $cron) { ?>
		<tr id="cron_<?php echo $cron['cron_id']; ?>">
			<td class="center"><?php echo $cron['cron_id']; ?></td>
			<td class="center td-cdatestart"><?php echo $cron['date_start']; ?></td>
			<td class="center td-cperiod"><?php echo $cron['period']; ?></td>
			<td class="center td-cdatenext"><?php echo $cron['date_next']; ?></td>
			<td class="left"><div class="cname"><?php echo $cron['name']; ?></div>
				<div class="cron-icons">
				<?php if($cron['send_region']) { ?>
					<img src="view/image/contacts/internet16.png" title="<?php echo $column_region; ?>" />
				<?php } ?>
				<?php if($cron['products']) { ?>
					<img src="view/image/contacts/nvtv16.png" title="<?php echo $column_products; ?>" />
				<?php } ?>
				<?php if($cron['attachments']) { ?>
					<img src="view/image/contacts/attachment16.png" title="<?php echo $column_attachments; ?>" />
				<?php } ?>
				<?php if($cron['unsub_url']) { ?>
					<img src="view/image/contacts/postman16.png" title="<?php echo $column_unsub_url; ?>" />
				<?php } ?>
				<?php if($cron['control_unsub']) { ?>
					<img src="view/image/contacts/spy16.png" title="<?php echo $column_control_unsub; ?>" />
				<?php } ?>
				</div>
			</td>
			<td class="left"><?php echo $cron['send_to']; ?>
				<?php if($cron['send_data']) { ?>
					(<?php echo $cron['send_data']; ?>)
				<?php } ?>
			</td>
			<td class="center"><?php echo $cron['email_total']; ?></td>
			<td class="center">
				<?php if($cron['cron_count']) { ?>
					<a onclick="viewhistory('<?php echo $cron['cron_id']; ?>');"><?php echo $cron['cron_count']; ?></a>
				<?php } ?>
			</td>
			<td class="center td-cstatus">
				<?php if($cron['cron_status']) { ?>
					<?php echo $cron['text_cron_status']; ?>
				<?php } ?>
			</td>
			<td class="center">
				<?php if($cron['status']) { ?><img src="view/image/success.png" /><?php } else { ?><img src="view/image/warning.png" /><?php } ?>
			</td>
			<td class="right">
				<a onclick="viewcronlogs('<?php echo $cron['cron_id']; ?>');" class="btn btn-mview" title="<?php echo $text_view_logs; ?>"></a>
				<a onclick="editcron('<?php echo $cron['cron_id']; ?>');" class="btn btn-medit" title="<?php echo $text_edit; ?>"></a>
				<a onclick="delcron('<?php echo $cron['cron_id']; ?>');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a>
			</td>
		</tr>
		<?php } ?>
	<?php } else { ?>
		<tr class="nocrons">
		  <td class="center" colspan="11"><?php echo $text_no_data; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
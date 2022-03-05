<table class="list">
	<thead>
	  <tr>
		<td class="center date"><?php echo $column_date_start; ?></td>
		<td class="center sendto"><?php echo $column_send_to; ?></td>
		<td class="center icon"><img src="view/image/contacts/customers20.png" title="<?php echo $column_check_total; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/good20.png" title="<?php echo $column_good_total; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/novalid20.png" title="<?php echo $column_novalid_total; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/bad20.png" title="<?php echo $column_bad_total; ?>" /></td>
		<td class="center icon"><img src="view/image/contacts/suspect20.png" title="<?php echo $column_suspect_total; ?>" /></td>
		<td class="center action"></td>
	  </tr>
	</thead>
	<tbody>
	<?php if ($check_crons) { ?>
		<?php foreach ($check_crons as $cron) { ?>
		<tr id="check_cron_<?php echo $cron['cron_id']; ?>">
			<td class="center td-cdatestart"><?php echo $cron['date_start']; ?></td>
			<td class="left"><?php echo $cron['send_to']; ?> <?php if ($cron['send_data']) { ?>(<?php echo $cron['send_data']; ?>)<?php } ?></td>
			<td class="center"><?php echo $cron['check_total']; ?></td>
			<td class="center"><a onclick="viewcheckemails('<?php echo $cron['cron_id']; ?>','1');"><?php echo $cron['good_total']; ?></a></td>
			<td class="center"><a onclick="viewcheckemails('<?php echo $cron['cron_id']; ?>','2');"><?php echo $cron['novalid_total']; ?></a></td>
			<td class="center"><a onclick="viewcheckemails('<?php echo $cron['cron_id']; ?>','3');"><?php echo $cron['bad_total']; ?></a></td>
			<td class="center"><a onclick="viewcheckemails('<?php echo $cron['cron_id']; ?>','4');"><?php echo $cron['suspect_total']; ?></a></td>
			<td class="right">
				<a onclick="viewchecklogs('<?php echo $cron['cron_id']; ?>');" class="btn btn-mview" title="<?php echo $text_view_logs; ?>"></a>
			</td>
		</tr>
		<?php } ?>
	<?php } else { ?>
		<tr class="nocrons">
		  <td class="center" colspan="8"><?php echo $text_no_data; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
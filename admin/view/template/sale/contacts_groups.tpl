<table class="list">
	<thead>
	  <tr>
		<td class="center icon">№</td>
		<td class="center gname"><?php echo $column_group_name; ?></td>
		<td class="center gdescript"><?php echo $column_group_description; ?></td>
		<td class="center gcounts"><?php echo $column_group_counts; ?></td>
		<td class="center gaction"><?php echo $column_action; ?></td>
	  </tr>
	</thead>
	<tbody>
	<?php if ($groups) { ?>
		<?php foreach ($groups as $group) { ?>
		<tr id="group_<?php echo $group['group_id']; ?>">
			<td class="center"><?php echo $group['group_id']; ?></td>
			<td class="left td-gname"><?php echo $group['name']; ?></td>
			<td class="left td-gdescript"><?php echo $group['description']; ?></td>
			<td class="center"><?php echo $group['counts']; ?></td>
			<td class="right">
				<a onclick="editgroup('<?php echo $group['group_id']; ?>');" class="btn btn-medit" title="<?php echo $text_group_edit; ?>"></a>
				<a onclick="delgroup('<?php echo $group['group_id']; ?>');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a>
			</td>
		</tr>
		<?php } ?>
	<?php } else { ?>
		<tr class="nogroups">
		  <td class="center" colspan="5"><?php echo $text_no_data; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
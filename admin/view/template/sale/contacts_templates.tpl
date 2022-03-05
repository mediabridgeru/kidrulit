<table class="list">
	<thead>
	  <tr>
	  <td class="center"><?php echo $column_template_name; ?></td>
	  <td class="center"><?php echo $column_subject; ?></td>
	  <td class="center taction"><?php echo $column_action; ?></td>
	  </tr>
	</thead>
	<tbody>
	<?php if ($templates) { ?>
		<?php foreach ($templates as $template) { ?>
		<tr id="template_<?php echo $template['template_id']; ?>">
			<td class="left"><?php echo $template['name']; ?></td>
			<td class="left"><?php echo $template['subject']; ?></td>
			<td class="right">
				<a onclick="viewtemplate('<?php echo $template['template_id']; ?>');" class="btn btn-medit" title="<?php echo $text_edit; ?>"></a>
				<a onclick="deltemplate('<?php echo $template['template_id']; ?>');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a>
			</td>
		</tr>
		<?php } ?>
	<?php } else { ?>
		<tr class="notemplates">
		  <td class="center" colspan="3"><?php echo $text_no_data; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
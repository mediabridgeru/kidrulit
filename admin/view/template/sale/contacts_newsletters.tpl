<input hidden id="npage" value="<?php echo $page ?>">
<input hidden id="nsort" value="<?php echo $sort ?>">
<input hidden id="norder" value="<?php echo $order ?>">
<table class="list">
  <thead>
    <tr id="nhead">
	  <td width="1" class="center"><input type="checkbox" id="ncheck" onclick="$('input[name*=\'nselected\']').attr('checked', this.checked);" /></td>
      <td class="center nemail">
		<?php if ($sort == 'cemail') { ?>
			<a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
		<?php } else { ?>
			<a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
		<?php } ?>
	  </td>
      <td class="center ngroup">
		<?php if ($sort == 'cgroup') { ?>
			<a href="<?php echo $sort_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ngroup_name; ?></a>
		<?php } else { ?>
			<a href="<?php echo $sort_group; ?>"><?php echo $column_ngroup_name; ?></a>
		<?php } ?>
	  </td>
      <td class="center nname">
		<?php if ($sort == 'cname') { ?>
			<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ncustomer; ?></a>
		<?php } else { ?>
			<a href="<?php echo $sort_name; ?>"><?php echo $column_ncustomer; ?></a>
		<?php } ?>
	  </td>
      <td class="center cgroup">
		<?php if ($sort == 'customer_group') { ?>
			<a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ncustomer_group; ?></a>
		<?php } else { ?>
			<a href="<?php echo $sort_customer_group; ?>"><?php echo $column_ncustomer_group; ?></a>
		<?php } ?>
	  </td>
      <td class="center nsubscribe"><?php echo $column_nsubscribe; ?></td>
	  <td class="center naction"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
	<tr class="filter">
	  <td></td>
	  <td class="center"><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
	  <td class="center"><select name="filter_group_id">
		  <option value="*"></option>
		  <?php foreach ($groups as $group) { ?>
		  <?php if ($group['group_id'] == $filter_group_id) { ?>
		  <option value="<?php echo $group['group_id']; ?>" selected="selected"><?php echo $group['name']; ?></option>
		  <?php } else { ?>
		  <option value="<?php echo $group['group_id']; ?>"><?php echo $group['name']; ?></option>
		  <?php } ?>
		  <?php } ?>
		</select></td>
	  <td class="center"><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
	  <td class="center"><select name="filter_customer_group_id">
		  <option value="*"></option>
		  <?php foreach ($customer_groups as $customer_group) { ?>
		  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
		  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
		  <?php } else { ?>
		  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
		  <?php } ?>
		  <?php } ?>
		</select></td>
	  <td class="center"><select name="filter_unsubscribe">
		  <option value="*"></option>
		  <?php if ($filter_unsubscribe) { ?>
		  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
		  <?php } else { ?>
		  <option value="1"><?php echo $text_yes; ?></option>
		  <?php } ?>
		  <?php if (!is_null($filter_unsubscribe) && !$filter_unsubscribe) { ?>
		  <option value="0" selected="selected"><?php echo $text_no; ?></option>
		  <?php } else { ?>
		  <option value="0"><?php echo $text_no; ?></option>		  
		  <?php } ?>
		</select></td>
		<td class="right"><a onclick="clear_nfilter();" class="btn btn-mclear" title="<?php echo $text_clear_filter; ?>"></a></td>
	</tr>
  </tbody>
  <tbody>
    <?php if ($newsletters) { ?>
    <?php foreach ($newsletters as $newsletter) { ?>
    <tr id="newsletter_<?php echo $newsletter['newsletter_id']; ?>">
	  <td class="center"><input type="checkbox" name="nselected[]" value="<?php echo $newsletter['newsletter_id']; ?>" /></td>
      <td class="left"><?php echo $newsletter['email']; ?></td>
      <td class="left"><?php echo $newsletter['group']; ?></td>
      <td class="left"><?php echo $newsletter['name']; ?></td>
      <td class="left"><?php echo $newsletter['customer_group']; ?></td>
	  <td class="center"><?php if ($newsletter['subscriber']) { ?><div class="subscriber"></div><?php } else { ?><div class="unsubscriber"></div><?php } ?></td>
	  <td class="right action">
	    <?php foreach ($newsletter['action'] as $action) { ?><a onclick="<?php echo $action['onclk']; ?>" class="<?php echo $action['clss']; ?>" title="<?php echo $action['text']; ?>"></a><?php } ?>
	  </td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="7"><?php echo $text_no_data; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="pagination"><?php echo $pagination; ?></div>
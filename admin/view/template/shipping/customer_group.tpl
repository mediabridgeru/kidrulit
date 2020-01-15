<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#modules').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="modules">
      <div class="htabs">
        <a href="#tab-general" class="selected" style="display: inline;"><?php echo $text_settings; ?></a>
        <a href="#tab-modules" style="display: inline;"><?php echo $text_modules; ?></a>
      </div>
      <div id="tab-general" style="display: block;">
        <table class="form">
          <tr>
            <td><?php echo $entry_title; ?></td>
            <td><input name="customer_group_title" size="50" value="<?php echo $customer_group_title; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input name="customer_group_sort_order" size="1" value="<?php echo $customer_group_sort_order; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="customer_group_status">
                <?php if ($customer_group_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </div>
      <div id="tab-modules" style="display: block;">
        <div class="vtabs"> 
		<?php $module_row = 1;?>
		  <?php foreach ($modules as $module) { ?>
		  <a href="#tab-module-<?php echo $module_row ; ?>" id="module-<?php echo $module_row ; ?>"><?php echo $text_module; ?> <?php echo $module_row ; ?>&nbsp;<img src="view/image/delete.png" alt="" 
			onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
		  <?php $module_row++; ?>
	      <?php } ?>
          <span class="addModule" id="module-add"><?php echo $button_add_module; ?> &nbsp;<img src="view/image/add.png" alt="" onclick="addModule();"/></span>
        </div>
        <?php $module_row = 1;?>
		<?php foreach ($modules as $module) { ?>
        <div id="tab-module-<?php echo $module_row;?>" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_name; ?></td>
              <td><input type="text" name="customer_group_module[<?php echo $module_row; ?>][name]" value="<?php echo $module['name']; ?>" size="100" /></td>
            </tr>		
            <tr>
              <td><?php echo $entry_rate; ?></td>
			  <td><textarea name="customer_group_module[<?php echo $module_row; ?>][rate]" cols="40" rows="5"><?php echo $module['rate']; ?></textarea></td>
            </tr>
          <tr>
          <td><?php echo $entry_customer_group; ?></td>
          <td><select name="customer_group_module[<?php echo $module_row; ?>][customer_group_id]">
    	      <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($customer_groups as $customer_group) { ?>
              <?php if ($customer_group['customer_group_id'] == $module['customer_group_id']) { ?>
              <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_tax; ?></td>
          <td><select name="customer_group_module[<?php echo $module_row; ?>][tax_class_id]">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $module['tax_class_id']) { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="customer_group_module[<?php echo $module_row; ?>][geo_zone_id]">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $module['geo_zone_id']) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="customer_group_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		</table>
        </div>
		<?php $module_row++; ?>
		<?php } ?>
		</div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = '<?php echo $module_row; ?>';

function addModule() {

	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	html += '  <table class="form">';
	html += '    <tr>';
	html += '      <td><?php echo $entry_name; ?></td>';
	html += '      <td><input type="text" name="customer_group_module[' + module_row + '][name]" value="" /></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_rate; ?></td>';
	html += '	  <td><textarea name="customer_group_module[' + module_row + '][rate]" cols="40" rows="5"></textarea></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_customer_group; ?></td>';
	html += '      <td><select name="customer_group_module[' + module_row + '][customer_group_id]">';
	html += '          <option value="0"><?php echo $text_none; ?></option>';
	<?php foreach ($customer_groups as $customer_group) { ?>
	html += '          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
	<?php } ?>
	html += '        </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_tax; ?></td>';
	html += '      <td><select name="customer_group_module[' + module_row + '][tax_class_id]">';
	html += '          <option value="0"><?php echo $text_none; ?></option>';
	<?php foreach ($tax_classes as $tax_class) { ?>
	html += '          <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
	<?php } ?>
	html += '        </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_geo_zone; ?></td>';
	html += '      <td><select name="customer_group_module[' + module_row + '][geo_zone_id]">';
	html += '          <option value="0"><?php echo $text_all_zones; ?></option>';
	<?php foreach ($geo_zones as $geo_zone) { ?>
	html += '          <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
	<?php } ?>
	html += '          </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_status; ?></td>';
	html += '      <td><select name="customer_group_module[' + module_row + '][status]">';
	html += '          <option value="1"><?php echo $text_enabled; ?></option>';
	html += '          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '          </select></td>';
	html += '    </tr>';
	html += '  </table>';
	html += '</div>';
	
	$('#tab-modules').append(html);	
	
	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $text_module; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.vtabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	module_row++;
}
//--></script>
<script type="text/javascript"><!--
$('.htabs a').tabs();

$('.vtabs a').tabs();
//--></script>
<?php echo $footer; ?>
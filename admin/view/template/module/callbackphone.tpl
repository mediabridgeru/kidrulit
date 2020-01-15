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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">

      <tr>
        <td><?php echo $entry_title; ?></td>
        <td><input type="text" name="callbackphone_title" size="50" value="<?php echo $callbackphone_title; ?>" /></td>
      </tr>

  		<tr>
  		  <td><?php echo $entry_link_title; ?></td>
  		  <td><input type="text" name="callbackphone_link_title" size="50" value="<?php echo $callbackphone_link_title; ?>" /></td>
  		</tr>

	    <tr>
        <td><?php echo $entry_email; ?></td>
        <td><input type="text" name="callbackphone_email" value="<?php echo $callbackphone_email; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_required; ?></td>
        <td><input type="text" name="callbackphone_required" value="<?php echo $callbackphone_required; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_telephone; ?></td>
        <td><input type="text" name="callbackphone_telephone" value="<?php echo $callbackphone_telephone; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_mask; ?></td>
        <td><input type="text" name="callbackphone_mask" value="<?php echo $callbackphone_mask; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_fax; ?></td>
        <td><input type="text" name="callbackphone_fax" value="<?php echo $callbackphone_fax; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_address; ?></td>
        <td><input type="text" name="callbackphone_address" value="<?php echo $callbackphone_address; ?>" size="50" /></td>
      </tr>

      <tr>
        <td><?php echo $entry_map; ?></td>
        <td valign="top"><textarea name="callbackphone_map" style="margin-right:20px;width:270px;height:90px;resize:vertical;float:left;"><?php echo $callbackphone_map; ?></textarea></td>
      </tr>

      <tr>
        <td><?php echo $text_activate; ?></td>
        <td>

<table>
  <tr>
    <td><?php echo $text_time; ?></td>
    <td>
      <select name="callbackphone_active_time">
        <?php if ($callbackphone_active_time == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_comment; ?></td>
    <td>
      <select name="callbackphone_active_comment">
        <?php if ($callbackphone_active_comment == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_map; ?></td>
    <td>
      <select name="callbackphone_mapshow">
        <?php if ($callbackphone_mapshow == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_address; ?></td>
    <td>
      <select name="callbackphone_active_address">
        <?php if ($callbackphone_active_address == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
<tr>
    <td><?php echo $text_tel; ?></td>
    <td>
      <select name="callbackphone_active_tel">
        <?php if ($callbackphone_active_tel == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_fax; ?></td>
    <td>
      <select name="callbackphone_active_fax">
        <?php if ($callbackphone_active_fax == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_email; ?></td>
    <td>
      <select name="callbackphone_active_email">
        <?php if ($callbackphone_active_email == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><?php echo $text_rightside; ?></td>
    <td>
      <select name="callbackphone_active_rightside">
        <?php if ($callbackphone_active_rightside == '1') { ?>
        <option value="1" selected="selected">Показать</option>
        <option value="2">Скрыть</option>
        <?php } else { ?>
        <option value="1">Показать</option>
        <option value="2" selected="selected">Скрыть</option>
        <?php } ?>
      </select>
    </td>
  </tr>
</table>
             
           
             
           
        </td>
      </tr>
      
      </table>
     <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><select name="callbackphone_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="callbackphone_module[<?php echo $module_row; ?>][position]">
                <?php if ($module['position'] == 'content_top') { ?>
                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                <?php } else { ?>
                <option value="content_top"><?php echo $text_content_top; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'content_bottom') { ?>
                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                <?php } else { ?>
                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="callbackphone_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="callbackphone_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="4"></td>
            <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
  <div style="text-align:center; color:#666666;"><br />Модуль "Заказ обратного звонка" разработал <noindex><a href="https://fl-worker.free-lance.ru/">FL-worker</a></noindex>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="callbackphone_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="callbackphone_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="callbackphone_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="callbackphone_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}
//--></script>
<?php echo $footer; ?>
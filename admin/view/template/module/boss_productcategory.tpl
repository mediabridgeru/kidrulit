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
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_title; ?></td>
			  <td class="left"><?php echo $entry_category; ?></td>			  
              <td class="left"><?php echo $entry_get_products_from; ?></td>
			  <td class="left"><?php echo $entry_image; ?></td>
			  <td class="left"><?php echo $entry_limit; ?></td>
			  <td class="left"><?php echo $entry_use_scrolling_panel; ?></td>
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
				<td class="left">
				<?php foreach ($languages as $language) { ?>
				  <input name="boss_productcategory_module[<?php echo $module_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['title'][$language['language_id']]) ? $module['title'][$language['language_id']] : ''; ?>" />
				  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
				<?php } ?></td>
			
				<td class="left">	
					<select name="boss_productcategory_module[<?php echo $module_row; ?>][type_category]">
					<?php if(isset($categories) && is_array($categories)){ ?>
					<?php foreach ($categories as $category) { ?>
					<option value="<?php echo $category['category_id']; ?>"  <?php if (isset($module['type_category']) && $category['category_id']== $module['type_category']) echo "selected=\"selected\""; ?>>
					<?php echo addslashes($category['name']); ?>
					</option>
					<?php } } ?>
					</select>				
				</td>										
				<td class="left"><select name="boss_productcategory_module[<?php echo $module_row; ?>][filter_type]">
                  <?php if ($module['filter_type'] == 'popular') { ?>
                  <option value="popular" selected="selected"><?php echo $tab_popular_products; ?></option>
                  <?php } else { ?>
                  <option value="popular"><?php echo $tab_popular_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'special') { ?>
                  <option value="special" selected="selected"><?php echo $tab_special_products; ?></option>
                  <?php } else { ?>
                  <option value="special"><?php echo $tab_special_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'bestseller') { ?>
                  <option value="bestseller" selected="selected"><?php echo $tab_best_seller_products; ?></option>
                  <?php } else { ?>
                  <option value="bestseller"><?php echo $tab_best_seller_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'lastest') { ?>
                  <option value="lastest" selected="selected"><?php echo $tab_latest_products; ?></option>
                  <?php } else { ?>
                  <option value="lastest"><?php echo $tab_latest_products; ?></option>
                  <?php } ?>
				  
                </select>				
				</td>
			  <td class="left"><input type="text" name="boss_productcategory_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
                <input type="text" name="boss_productcategory_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
                <?php if (isset($error_image[$module_row])) { ?>
                <span class="error"><?php echo $error_image[$module_row]; ?></span>
                <?php } ?></td>
              <td class="left"><input type="text" name="boss_productcategory_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="3" />
			    <?php if (isset($error_numproduct[$module_row])) { ?>
                <span class="error"><?php echo $error_numproduct[$module_row]; ?></span>
                <?php } ?></td>
			  <td class="left"><select name="boss_productcategory_module[<?php echo $module_row; ?>][use_scrolling_panel]">
                  <?php if ($module['use_scrolling_panel']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
				</td>
			  <td class="left"><select name="boss_productcategory_module[<?php echo $module_row; ?>][layout_id]">
				  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="boss_productcategory_module[<?php echo $module_row; ?>][position]">
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
                </select></td>
              <td class="left"><select name="boss_productcategory_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="boss_productcategory_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="10"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>	
  <script type="text/javascript"><!--
    var module_row = <?php echo $module_row; ?>;

    function addModule() {	
      html  = '<tbody id="module-row' + module_row + '">';
      html += '  <tr>';
	   html += '<td class="left">';
	  <?php foreach ($languages as $language) { ?>
		html += '<input name="boss_productcategory_module[' + module_row + '][title][<?php echo $language['language_id']; ?>]" />';
		html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	  <?php } ?>
		html += '</td>';
		html += '<td class="left">';
		html += '<select name="boss_productcategory_module[' + module_row +'][type_category]">';
		<?php if(isset($categories) && is_array($categories)){ ?>
		<?php foreach ($categories as $category) { ?>
		html += '<option value="<?php echo $category['category_id']; ?>">';
		html+= '<?php echo addslashes($category['name']); ?></option>';
		<?php } } ?>
		html += '</select>';
				
		html += '</td>';	 	  
	  html += '<td class="left"><select name="boss_productcategory_module[' + module_row + '][filter_type]" >';
	  html += '	 <option value="popular"><?php echo $tab_popular_products; ?></option>';
	  html += '	 <option value="special"><?php echo $tab_special_products; ?></option>';
	  html += '  <option value="bestseller"><?php echo $tab_best_seller_products; ?></option>';
	  html += '  <option value="lastest"><?php echo $tab_latest_products; ?></option>';	  
	  html += '</select></td>';
	  html += '    <td class="left"><input type="text" name="boss_productcategory_module[' + module_row + '][image_width]" value="300" size="3" /> <input type="text" name="boss_productcategory_module[' + module_row + '][image_height]" value="300" size="3" /></td>';	
	  html += '    <td class="left"><input type="text" name="boss_productcategory_module[' + module_row + '][limit]" value="20" size="3" /></td>';
	  html += '    <td class="left"><select name="boss_productcategory_module[' + module_row + '][use_scrolling_panel]">';
      html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
      html += '      <option value="0"><?php echo $text_disabled; ?></option>';
      html += '    </select>';
	  html += '	   </td>';
      html += '    <td class="left"><select name="boss_productcategory_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>" <?php if($layout['layout_id']==1) echo "selected=\"selected\""?>><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
      html += '    </select></td>';
      html += '    <td class="left"><select name="boss_productcategory_module[' + module_row + '][position]">';
      html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
      html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
      html += '    </select></td>';
      html += '    <td class="left"><select name="boss_productcategory_module[' + module_row + '][status]">';
      html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
      html += '      <option value="0"><?php echo $text_disabled; ?></option>';
      html += '    </select></td>';
      html += '    <td class="right"><input type="text" name="boss_productcategory_module[' + module_row + '][sort_order]" value="2" size="3" /></td>';
      html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
      html += '  </tr>';
      html += '</tbody>';
	
      $('#module tfoot').before(html);
	
      module_row++;
    }
    //--></script> 
  <script type="text/javascript"><!--
    function image_upload(field, thumb) {
      $('#dialog').remove();
	
      $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
      $('#dialog').dialog({
        title: '<?php echo $text_image_manager; ?>',
        close: function (event, ui) {
          if ($('#' + field).attr('value')) {
            $.ajax({
              url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
              dataType: 'text',
              success: function(data) {
                $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
              }
            });
          }
        },	
        bgiframe: false,
        width: 700,
        height: 400,
        resizable: false,
        modal: false
      });
    };
    //--></script>
<?php echo $footer; ?>

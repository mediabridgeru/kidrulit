<?php
if( $menu ): 
$module_row= 'ss';
?>
<?php  //var_dump($menu); ?>
<?php if( $menu['megamenu_id'] > 0 ) { ?>
<h2><?php echo sprintf($text_edit_menu, $menu['title'], $menu['megamenu_id']);?></h2>
<?php } else { ?>
<h2><?php echo $text_create_new;?></h2>
<?php } ?>
<div>
	<h4>Menu Information</h4>
	 <div id="language-<?php echo $module_row; ?>" class="htabs languagetabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#tab-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="tab-language-<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
				<td>Title</td>
				<td><input name="megamenu_description[<?php echo $language['language_id'];?>][title]" value="<?php echo (isset($menu_description[$language['language_id']]['title'])?$menu_description[$language['language_id']]['title']:"" );?>"/></td>
              </tr>
            </table>
          </div>
          <?php } ?>
	<h4>Menu Type</h4>
	<input type="hidden" id="megamenu_item" name="megamenu[item]" value="<?php echo $menu['item'];?>" />
	<table class="form">
		<?php $params = json_decode($menu['params'], true); ?>
		<?php $ids = explode(',', $menu['item']);?>
		<?php //print_r($ids);die; ?>
		
		<?php //print_r($ids);die; ?>
		<tr>
			<td><?php echo $this->language->get('entry_status');?></td>
				
			<td>
				<select type="list" name="megamenu[status]" >
					<?php foreach( $status as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['status']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr>
			<td><?php echo $this->language->get('entry_type');?></td>
				
			<td>
				<select name="megamenu[type]" id="megamenutype">
					<?php foreach(  $megamenutypes as $mt => $val ){ ?>
					<option value="<?php echo $mt; ?>" <?php if($mt == $menu['type']) {?> selected="selected" <?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr id="megamenutype-url" class="megamenutype">
			<td><?php echo $this->language->get('entry_url');?></td>
			<td>
				<input type="text" name="megamenu[url]" value="<?php echo $menu['url'];?>" size="50"/>
			</td>
		</tr>
		<tr id="megamenutype-category" class="megamenutype">
		<td><?php echo $this->language->get('entry_category');?></td>
		<td>
			<div id="opt_category">
				<p><span><?php echo $text_show_image; ?></span>
				<select name="megamenu[params][category_show_img]">
				  <?php if ($params['category_show_img']) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
				  <?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				  <?php } ?>
				</select> 
				&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $text_w_x_h; ?></span><input type="text" name="megamenu[params][category_img_w]" value="<?php echo $params['category_img_w']; ?>" size="3" /><input type="text" name="megamenu[params][category_img_h]" value="<?php echo $params['category_img_h']; ?>" size="3" /></p>
				<p><span><?php echo $text_show_sub_category; ?></span><select name="megamenu[params][category_show_sub]">
				  <?php if ($params['category_show_sub']) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
				  <?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				  <?php } ?>
				</select></p>
				<p><span><?php echo $text_show_parent_category; ?></span><select name="megamenu[params][category_show_parent]">
				  <?php if ($params['category_show_parent']) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
				  <?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				  <?php } ?>
				</select></p>
				<span><?php echo $text_choose_parent_category; ?></span><div class="scrollbox">
					<div class="odd">
					  <?php if (isset($ids) && $ids[0] == 0) { ?>
						<input type="radio" name="megamenutype-category" value="0" checked="checked" />
					  <?php } else { ?>
						<input type="radio" name="megamenutype-category" value="0" />
					  <?php } ?>
					  <?php echo $text_root_category; ?>
					</div>
					<?php $divclass = 'odd'; ?>
					<?php foreach ($categories as $category) { ?>
					  <?php $divclass = ($divclass == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $divclass; ?>">
					  <?php if (($ids[0]!='') && $category['category_id'] == $ids[0]) { ?>
						<input type="radio" name="megamenutype-category" value="<?php echo $category['category_id']; ?>" checked="checked" />
					  <?php } else { ?>
						<input type="radio" name="megamenutype-category" value="<?php echo $category['category_id']; ?>" />
					  <?php } ?>
					  <?php echo $category['name']; ?>
					  </div>
					<?php } ?>
				</div>
			</div>
		</td>
		</tr>
		<tr id="megamenutype-product" class="megamenutype">
			<td><?php echo $this->language->get('entry_product');?></td>
			<!--<td>
				<input type="text" name="megamenu-product" value="<?php echo $menu['megamenu-product'];?>" size="50"/>
				<i><?php echo $this->language->get('text_explain_input_auto');?></i>
			</td>-->
			<td>
				<div id="opt_product">
					<p><span><?php echo $text_show_image; ?></span><select name="megamenu[params][product_show_img]">
						<?php if ($params['product_show_img']) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					</select> 
						&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $text_w_x_h; ?></span><input type="text" name="megamenu[params][product_img_w]" value="<?php echo $params['product_img_w']; ?>" size="3" /><input type="text" name="megamenu[params][product_img_h]" value="<?php echo $params['product_img_h']; ?>" size="3" /></p>
					<p><span><?php echo $this->language->get('text_products_autocomplete'); ?></span><input type="text" name="product_autocomplete" /></p>
					<div class="scrollbox" id="product_list">
						<?php $divclass = 'odd'; ?>
						<?php if($ids[0]!='') { ?>
							<?php foreach ($ids as $product_id) { ?>
								<?php $divclass = ($divclass == 'even' ? 'odd' : 'even'); ?>
							  <div class="<?php echo $divclass; ?>" id="product-item-<?php echo $product_id; ?>"><?php echo isset($products_name[$product_id])?$products_name[$product_id]:""; ?><img src="view/image/delete.png" /><input name="bossmegamenu[product_ids][]" type="hidden" value="<?php echo $product_id; ?>" /></div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
		<tr id="megamenutype-manufacturer" class="megamenutype">
			<td><?php echo $this->language->get('entry_manufacturer');?></td>
			<td>
				<p><span><?php echo $this->language->get('text_show_image'); ?></span><select name="megamenu[params][manufacturer_img]">
						 <?php if ($params['manufacturer_img']) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else { ?> 
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $this->language->get('text_w_x_h'); ?></span><input type="text" name="megamenu[params][manufacturer_img_w]" value="<?php echo $params['manufacturer_img_w']; ?>" size="3" /><input type="text" name="megamenu[params][manufacturer_img_h]" value="<?php echo $params['manufacturer_img_h']; ?>" size="3" /></p><br />
				<p><span><?php echo $this->language->get('text_show_name'); ?></span><select name="megamenu[params][manufacturer_name]">
						  <?php if ($params['manufacturer_name']) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select></p> <br />
				<span><?php echo $this->language->get('text_choose_manufacturers');?></span>
				<div class="scrollbox">
					<?php $divclass = 'odd'; ?>
					<?php foreach ($manufacturers as $manufacturer) { ?>
						<?php $divclass = ($divclass == 'even' ? 'odd' : 'even'); ?>
						<div class="<?php echo $divclass; ?>">
							<?php if(($ids[0]!='') && in_array($manufacturer['manufacturer_id'], $ids)) { ?>
								<input type="checkbox" name="megamenu-manufacturer" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
							<?php } else { ?>
								<input type="checkbox" name="megamenu-manufacturer" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
							<?php } ?>
							<?php echo $manufacturer['name']; ?>
						</div>
					<?php } ?>
				</div>
			</td>
		</tr>
		<tr id="megamenutype-information" class="megamenutype">
			<td><?php echo $this->language->get('entry_information');?></td>
			<td>
				<div id="opt_information">
					<p></p><span><?php echo $this->language->get('text_choose_informations'); ?></span>
					<div class="scrollbox">
						<?php $divclass = 'odd'; ?>
						<?php foreach ($informations as $information) { ?>
						  <?php $divclass = ($divclass == 'even' ? 'odd' : 'even'); ?>
						  <div class="<?php echo $divclass; ?>">
						  <?php if(($ids[0]!='') && in_array($information['information_id'], $ids)) { ?>
							<input type="checkbox" name="megamenu-information" value="<?php echo $information['information_id']; ?>" checked="checked" />
						  <?php } else { ?>
							<input type="checkbox" name="megamenu-information" value="<?php echo $information['information_id']; ?>" />
						  <?php } ?>
						  <?php echo $information['title']; ?>
						  </div>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
		<tr id="megamenutype-html" class="megamenutype">
			<td><?php echo $this->language->get('entry_html');?></td>
			<td>
				<textarea type="text" name="megamenu[content_text]"  size="50"><?php echo $menu['content_text'];?></textarea>
				<i><?php echo $this->language->get('text_explain_input_html');?></i>
			</td>
		</tr>
	</table>	
	<h4>Menu Params</h4>	  
	 <table class="form">
		<tr>
			<td><?php echo $this->language->get('entry_parent_id');?></td>
				
			<td>
				<?php echo $menus;?>
 			</td>
		</tr>
		<tr>
			<td><?php echo $this->language->get('entry_menuclass');?></td>
				
			<td>
				<input type="text" name="megamenu[menu_class]" value="<?php echo $menu['menu_class']?>"/>
				
 			</td>
		</tr>	
		<tr>
			<td><?php echo $this->language->get('entry_showtitle');?></td>
				
			<td>
				<select type="list" name="megamenu[show_title]" >
					<?php foreach( $status as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['show_title']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->language->get("entry_columns");?>
			</td>
				
			<td>
				<input type="text" name="megamenu[colums]" value="<?php echo $menu['colums']?>"/>
 			</td>
		</tr>
	</table>
	<input type="hidden" name="megamenu[megamenu_id]" value="<?php echo $menu['megamenu_id']?>"/>
</div>
<?php endif; ?>

<script type="text/javascript"> 

CKEDITOR.replace('megamenu[content_text]', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

$( ".languagetabs a" ).tabs();
$(".megamenutype").hide();
$("#megamenutype-"+ $("#megamenutype").val()).show();
$("#megamenutype").change( function(){
	$(".megamenutype").hide();
	$("#megamenutype-"+$(this).val()).show();
} );
   
$('input[name="megamenu-manufacturer"]').change(function() {
	var value_effect = '';
   $("input[name='megamenu-manufacturer']:checked").each(function(){
	
		var str = $(this).val();
		value_effect = value_effect + str + ',';
	});
	$('input[name=\'megamenu[item]\']').val(value_effect);
}) 

$('input[name="megamenu-information"]').change(function() {
	var value_effect = '';
   $("input[name='megamenu-information']:checked").each(function(){
	
		var str = $(this).val();
		value_effect = value_effect + str + ',';
	});
	$('input[name=\'megamenu[item]\']').val(value_effect);
})

$('input[name="megamenutype-category"]').change(function() {
	var value_effect = '';
   $("input[name='megamenutype-category']:checked").each(function(){
	
		var str = $(this).val();
		value_effect = str;
	});
	$('input[name=\'megamenu[item]\']').val(value_effect);
})

$('input[name=\'product_autocomplete\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#product-item-' + ui.item.value).remove();
		
		$('#product_list').append('<div id="product-item-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input name="bossmegamenu[product_ids][]" type="hidden" value="' + ui.item.value + '" /></div>');
		
		$('#product_list div:odd').attr('class', 'odd');
		$('#product_list div:even').attr('class', 'even');
		
		data = $.map($('#product_list input'), function(element){
			return $(element).attr('value');
		});
						
		$('input[name=\'megamenu[item]\']').attr('value', data.join());
		
		return false;
	},
	focus: function(event, ui) {
		return false;
	}
});
$('#product_list div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product_list div:odd').attr('class', 'odd');
	$('#product_list div:even').attr('class', 'even');
	
	data = $.map($('#product_list input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'megamenu[item]\']').attr('value', data.join());
});

</script>
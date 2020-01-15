<?php
 echo $header; 

	$module_row=0; 

?>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div id="ajaxloading" class="hide">
	<div class="loading"><b>processing request...</b></div>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	  <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
	  <a onclick="__submit('save-edit')" class="button"><?php echo $this->language->get('button_save_edit'); ?></a>
	  <a onclick="__submit('save-new')" class="button"><?php echo $this->language->get('button_save_new'); ?></a>
	  <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="megamenu">
				<div class="megamenu-form">
					<div class="htabs" id="mainTabs">
						<a href="#megamenunew"><?php echo $text_create_new;?></a>
						<a href="#megamenusetting"><?php echo $this->language->get("text_menu_setting");?></a>
					</div> <!-- End .mainTabs -->
					<div id="megamenusetting" style="margin-left:26px">
						<h3><?php echo $this->language->get("text_menu_setting");?></h3>
						<table class="form">
							<tr>
							  <td><?php echo $entry_layout; ?></td>
							  <td><select name="boss_megamenu_module[<?php echo $module_row; ?>][layout_id]">
								 <?php foreach ($layouts as $layout) { ?>
								  <?php if ($layout['layout_id'] == $modules[0]['layout_id']) { ?>
								  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
								  <?php } else { ?>
								  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
								  <?php } ?>
								  <?php } ?>
								</select></td>
							</tr>
							<tr>
							  <td><?php echo $entry_position; ?></td>
							  <td><select name="boss_megamenu_module[<?php echo $module_row; ?>][position]">
								  <?php foreach( $positions as $pos ) { ?>
								  <?php if ($modules[0]['position'] == $pos) { ?>
								  <option value="<?php echo $pos;?>" selected="selected"><?php echo $this->language->get('text_'.$pos); ?></option>
								  <?php } else { ?>
								  <option value="<?php echo $pos;?>"><?php echo $this->language->get('text_'.$pos); ?></option>
								  <?php } ?>
								  <?php } ?> 
								</select></td>
							</tr>
							<tr>
							  <td><?php echo $entry_status; ?></td>
							  <td><select name="boss_megamenu_module[<?php echo $module_row; ?>][status]">
								  <?php if ($modules[0]['status']) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select></td>
							</tr>
							<tr>
							  <td><?php echo $entry_sort_order; ?></td>
							  <td><input type="text" name="boss_megamenu_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $modules[0]['sort_order']; ?>" size="3" /></td>
							</tr>
							<tr>
							  <td><?php echo $entry_menu_width; ?></td>
							  <td><input type="text" name="boss_megamenu_module[<?php echo $module_row; ?>][menu_width]" value="<?php echo $modules[0]['menu_width']; ?>" size="3" /></td>
							</tr>
							<tr>
							  <td><?php echo $entry_num_column; ?></td>
							  <td><input type="text" name="boss_megamenu_module[<?php echo $module_row; ?>][num_column]" value="<?php echo $modules[0]['num_column']; ?>" size="3" /></td>
							</tr>
							<tr>
								<td><?php echo $entry_store; ?></td>
								<td><div class="scrollbox">
									<?php $class = 'even'; ?>
									<div class="<?php echo $class; ?>">
										<?php if (isset($modules[0]['store_id']) && in_array(0, $modules[0]['store_id'])) { ?>
											<input type="checkbox" name="boss_megamenu_module[<?php echo $module_row; ?>][store_id][]" value="0" checked="checked" />
										<?php } else { ?>
											<input type="checkbox" name="boss_megamenu_module[<?php echo $module_row; ?>][store_id][]" value="0" />
										<?php } ?>
									<?php echo $text_default; ?>
									</div>
									<?php foreach ($stores as $store) { ?>
										<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
										<div class="<?php echo $class; ?>">
											<?php if (isset($modules[0]['store_id']) && in_array($store['store_id'], $modules[0]['store_id'])) { ?>
												<input type="checkbox" name="boss_megamenu_module[<?php echo $module_row; ?>][store_id][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
												<?php echo $store['name']; ?>
											<?php } else { ?>
												<input type="checkbox" name="boss_megamenu_module[<?php echo $module_row; ?>][store_id][]" value="<?php echo $store['store_id']; ?>" />
												<?php echo $store['name']; ?>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
								</td>
							</tr>
						</table>
					</div>
					<div id="megamenunew" style="margin-left:26px">
						<div class="tree-megamenu">
							<h3><?php echo $this->language->get('text_treemenu');?></h3>
							<?php echo $tree; ?>
							<input type="button" class="button" name="serialize" id="serialize" value="Update" />
							<p style="clear:both;color:blue"><?php echo '*Note: '. $this->language->get("text_explain_drapanddrop");?></p>
						</div>
						<div id="megamenu-form">
							<?php require( "boss_megamenu_form.tpl" );?>
						</div>
					</div>

				</div>
			</div>
		</div>
			<input type="hidden" value="" name="save_mode" id="save_mode"/>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#mainTabs a').tabs();
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
 <script type="text/javascript" class="source below">
 function __submit( m ){
	$("#save_mode").val( m );
	$('#form').submit();
 }
	$('ol.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 2,

			isTree: true,
			expandOnHover: 700,
			startCollapsed: true
		});
	
	$('#serialize').click(function(){
			var serialized = $('ol.sortable').nestedSortable('serialize');
			 $.ajax({
			//async : false,
			type: 'POST',
			dataType:'json',
			url: "<?php echo str_replace("&amp;","&",$updateTree);?>",
			data : serialized, 
			success : function (r) {
				 
			}
		});
	})
	$(".quickedit").click( function(){
		
		var id = $(this).attr("rel").replace("id_","");
		$.post( "<?php echo str_replace("&amp;","&",$actionGetInfo);?>", {
			"id":id,	
			"rand":Math.random()},
			function(data){
				$("#megamenu-form").html( data );
			});
	} );
	$(".quickdel").click( function(){
		if( confirm("<?php echo $this->language->get("message_delete");?>") ){
			var id = $(this).attr("rel").replace("id_","");
			window.location.href="<?php echo str_replace("&amp;","&",$actionDel);?>&id="+id;
		}
	} );
	$(document).ajaxSend(function() {
		$("#ajaxloading").show();
	});
	$(document).ajaxComplete(function() {
		$("#ajaxloading").hide();
	});
</script>

<?php echo $footer; ?>
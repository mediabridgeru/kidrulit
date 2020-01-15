<div id="ajaxloading" class="hide">
	<div class="loading"><b>processing request...</b></div>
</div>
  
<div class="clearfix">
	<table class="form">
		<tr>
			<td>
			<b>Show modules on Layout</b>
			</td>
			<td>
			<select name="elayout_id" onchange="window.location.href='<?php echo preg_replace("#elayout_id\s*=\s*\d+#","",$action); ?>&elayout_id='+this.value">
				<?php foreach( $layouts as $layout ) { 
					$selected = $layout['layout_id'] == $elayout_default ? 'selected="selected"' : "";
				?>
				<option value="<?php echo $layout['layout_id'];?>" <?php echo $selected;?>><?php echo $layout['name'];?></option>
				<?php } ?>
			</select>
			</td>
			<td><a class="button button-action" style="background:orange">Save config layout</a></td>
		</tr>
	</table>		
</div>



<p><?php echo $this->getLang("text_explain_modules_function");?></p>
<div class="theme-layout clearfix">
			
		<div class="header clearfix">
			<div class="pos">Header</div>
	
		</div>
		<div class="slideshow  edit-container clearfix" data-position="mainmenu">
			<div class="explain"></div>
			<div class="pos">Main Menu</div>
			<?php if( isset($layout_modules['mainmenu']) ){  
				foreach( $layout_modules['mainmenu'] as $modulepos ) {
			?>
				<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="mainmenu" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
						<div class="edit-module">
							<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo '  #'.$modulepos['index'];?>
						</div>
					</div>
			<?php } }?>
			
		</div>
		
		<div class="slideshow  edit-container clearfix"  data-position="slideshow">
			<div class="pos">Slideshow</div>
			<?php if( isset($layout_modules['slideshow']) ){  
				foreach( $layout_modules['slideshow'] as $modulepos ) {
			?>
			<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="slideshow" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
				<div class="edit-module">
					<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo '  #'.$modulepos['index'];?>
				</div>
			</div>
			<?php } }?>
		</div>
		<div class="columns clearfix">
			<div class="column-left edit-container" data-position="column_left">
				<div class="pos">Column Left</div>
				<?php if( isset($layout_modules['column_left']) ){  
					foreach( $layout_modules['column_left'] as $modulepos ) {
				?>
					<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="column_left" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
							<div class="edit-module">
								<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo '  #'.$modulepos['index'];?>
							</div>
					</div>
				<?php } }?>
			</div>
			<div class="column-center">
				<div class="content-top edit-container" data-position="content_top">
					<div class="pos">Content Top</div>
					<?php if( isset($layout_modules['content_top']) ){  
					foreach( $layout_modules['content_top'] as $modulepos ) {  
					?>
						<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="content_top" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
							<div class="edit-module">
								<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo '  #'.$modulepos['index'];?>
							</div>
						</div>
					<?php } }?>
				</div>
				
				<div class="content-bottom edit-container" data-position="content_bottom">
					<div class="pos">Content Bottom</div>
					<?php if( isset($layout_modules['content_bottom']) ){  
					foreach( $layout_modules['content_bottom'] as $modulepos ) {
					?>
						<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="content_bottom" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
							<div class="edit-module">
								<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo '  #'.$modulepos['index'];?>
							</div>
						</div>
					<?php } }?>
				</div>
				
			</div>
			<div class="column-right edit-container" data-position="column_right">
				<div class="pos">Column Right</div>
				<?php if( isset($layout_modules['column_right']) ){  
					foreach( $layout_modules['column_right'] as $modulepos ) {
				?>
				<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="column_right" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
						<div class="edit-module">
							<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo ' #'.$modulepos['index'];?>
						</div>
					</div>
				<?php } }?>
				
			</div>
		</div>
		<div class="layout-footer clearfix">
			<div class="footer edit-container" data-position="footer">
				<div class="pos">Footer</div>
		
				<?php if( isset($layout_modules['footer']) ){  
					foreach( $layout_modules['footer'] as $modulepos ) {
				?>
					<div class="module-pos <?php if( !$modulepos['status']){ ?>mod-disable<?php } ?>" data-position="footer" data-id="<?php echo $modulepos['code']."-".$modulepos['index'];?>">
							<div class="edit-module">
								<a target="_blank" href="<?php echo $this->url->link('module/'.$modulepos['code'],'token='.$token);?>"><b><?php echo $modulepos['title'].'</b>'; ?></a> <?php echo ' #'.$modulepos['index'];?>
							</div>
						</div>
				<?php } }?>
			</div>
		</div>
	
	<p style="color:blue">
		* Note: update position and sort orders of modules could not work smoothly for modules having more than 2 instances in same page layout
	</p>
</div>
<script type="text/javascript">
$('.theme-layout .edit-container').sortable( {
			connectWith: '.theme-layout .edit-container',
			containment: '.theme-layout',
			forceHelperSize: true,
			forcePlaceholderSize: true,
			placeholder: 'placeholder',
			handle:".edit-module"
		});
		
	
	
$(document).ajaxSend(function() {
	$("#ajaxloading").show();
});
$(document).ajaxComplete(function() {
	$("#ajaxloading").hide();
});	
</script>
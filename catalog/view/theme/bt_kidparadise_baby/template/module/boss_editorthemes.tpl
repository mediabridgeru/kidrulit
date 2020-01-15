<?php 
if($status){
	if($data_template){
		echo $data_template;
	} else { ?>
	<div class="cpanelContainer" style="display:none; clear:both;">
		<div class="boss-themedesign">
			<div class="cpanel_icon">
				<span>icon</span>
			</div> <!-- End .cpanel_icon-->
			<div class="boss-themedesign-info">
			<h2>Theme Design</h2>
			<ul id="bt_category">
				<li> <!-- Design background -->
					<span class="expand">Design Background</span>
					<ul class="design_background"> 
						<li><h3>Body Background</h3></li>
						<?php foreach ($bg_images as $image => $settings) {?>
						<li><a onclick="addBackground('<?php echo $settings;?>','body')"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
						<?php } ?>
					</ul>
					
					<ul class="design_background"> 
						<li><h3>Header Background</h3></li>
						<?php foreach ($bg_images as $image => $settings) {?>
						<li><a onclick="addBackground('<?php echo $settings;?>','header')"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
						<?php } ?>
					</ul>
					
					<ul class="design_background"> 
						<li><h3>Footer Background</h3></li>
						<?php foreach ($bg_images as $image => $settings) {?>
						<li><a onclick="addBackground('<?php echo $settings;?>','footer')"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
						<?php } ?>
					</ul>
				</li> <!-- End Design background-->
				
				<li><!-- Mode Css-->
					<span class="expand">Mode CSS</span>
					<?php $b_Mode_CSS = $this->config->get('b_Mode_CSS'); ?>
					<ul class="mode_css"> 
						<li><input type="radio" id="mode_boxed" value="boxed" onclick="changeModeCSS('boxed')" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'boxed') echo ' checked="checked"'; ?> /> Box</li>
						<li><input type="radio" id="mode_wide" value="wide" onclick="changeModeCSS('wide')" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'wide') echo ' checked="checked"'; ?> /> Wide</li>
					</ul>
				</li>
				
				<li><!-- product grid view-->
					<span class="expand">Product Grid View</span>
					<?php $b_Layout_Setting = $this->config->get('b_Layout_Setting'); ?>
					<ul class="mode_css"> 
						<li><p><input type="radio" id="view_8_24-16-8_8-12-24" value="8,24-16-8,8-12-24" onclick="changeProductView('8','24-16-8','8-12-24');storeTotalStorage('8','24-16-8','8-12-24');" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '8,24-16-8,8-12-24') echo ' checked="checked"'; ?> /> Extra</p></li>
						<li><p><input type="radio" id="view_6_24-18-12_6-8-12" value="6,24-18-12,6-8-12" onclick="changeProductView('6','24-18-12','6-8-12');storeTotalStorage('6','24-18-12','6-8-12');" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '6,24-18-12,6-8-12')  echo ' checked="checked"'; ?> /> Large</p></li>
						
						<li><p><input type="radio"  id="view_5_24-19-14_cs5-6-8" value="5,24-19-14,cs5-6-8" onclick="changeProductView('5','24-19-14','cs5-6-8');storeTotalStorage('5','24-19-14','cs5-6-8');" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '5,24-19-14,cs5-6-8') echo ' checked="checked"'; ?> /> Medium</p></li>
						
						<li><p><input type="radio" id="view_4_24-20-16_4-cs5-6" value="4,24-20-16,4-cs5-6" onclick="changeProductView('4','24-20-16','4-cs5-6');storeTotalStorage('4','24-20-16','4-cs5-6');" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '4,24-20-16,4-cs5-6') echo ' checked="checked"'; ?> /> Small</p></li>
					</ul>
				</li>
				
				<li><!-- Font setting-->
					<span class="expand">Font Setting</span>
					<ul class="accordion_content"> 
						<?php
							$json = file_get_contents("catalog/view/theme/".$this->config->get('config_template')."/fonts/webfonts.json", true);
							$decode = json_decode($json, true);
							$webfonts = array();
							foreach ($decode['items'] as $key => $value) {
								// FONT FAMILY
								$item_family = $decode['items'][$key]['family'];
								$item_family_trunc =  str_replace(' ','+',$item_family);
								$webfonts[$item_family_trunc] = $item_family;
							}
							//print_r ($default);
							$defaultFont = array( 
								'Arial', 
								'Verdana', 
								'Helvetica', 
								'Lucida Grande', 
								'Trebuchet MS', 
								'Times New Roman', 
								'Tahoma', 
								'Georgia'
								);
							$FontWeight = array( 'default','normal', 'bold' );
							
						?>
						<?php $FontsSizes = array( 
							'default', '10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', 
							'26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px',
							'34px', '35px', '36px', '37px', '38px', '39px', '40px', '41px',
							'42px', '43px', '44px', '45px', '46px', '47px', '48px', '49px', '50px'
						); ?>
						<?php 
							$b_Font_Data = array();
							$b_Font_Data = $this->config->get('b_Font_Data');
						?>
						<?php $objXML = simplexml_load_file("config_xml/font_setting.xml"); ?>
						<?php foreach ($objXML->children() as $child) {	
							foreach($child->children() as $childOFchild){ ?>
							<?php if($childOFchild->frontend=='true'){ ?>
							<li><h3><?php echo $childOFchild->text; ?></h3>
								<div class="boss_font">
									<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('<?php echo $childOFchild->style; ?>','<?php echo $childOFchild->class_name; ?>')">
										<option>default</option>
										<optgroup label="HTML default fonts">
										<?php foreach ($defaultFont as $key) { ?>
											<?php ($key ==  $b_Font_Data[''.$childOFchild->style.'']) ? $selected = 'selected' : $selected = ''; ?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
										<?php } ?>
										</optgroup>
										<optgroup label="Google fonts">
										<?php foreach ($webfonts as $key => $face ) { ?>
											<?php ($key ==  $b_Font_Data[''.$childOFchild->style.'']) ? $selected = 'selected' : $selected=''; ?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $face; ?></option>
										<?php } ?>
										</optgroup>
									</select>
								</div>
								<div class="boss_size">
									<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('<?php echo $childOFchild->size; ?>','<?php echo $childOFchild->class_name; ?>')">
										<?php foreach ($FontsSizes as $key) { ?>
											<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
										<?php } ?>
									</select>
								</div>
							</li>
						<?php } } }?>
					</ul>
				</li> <!-- End font setting-->
				
				<li><!-- Color setting-->
					<span class="expand">Color Setting</span>
					<ul class="accordion_content"> 
						<li><h3>Template Color</h3>
							<div class="boss_color_scheme">
								<?php
									$b_Setting = $this->config->get('b_Setting');
									$b_Color_Data = $this->config->get('b_Color_Data');
								?>
								<select id="temp_setting" name="b_Setting[temp_setting]" onchange="changeTemplate(this.value);">
									<option value="custom" <?php ($b_Setting['temp_setting']) =='custom' ? $selected = 'selected' : $selected = ''; ?>>Custom</option>
									<?php foreach ($temp_setting_arr as $key => $value){ ?>
										<?php if ($key == $b_Setting['temp_setting']){ ?>
											<option value="<?php echo $key; ?>" selected="selected"><?php echo $temp_name_arr[$key]; ?></option>
										<?php } else{ ?>
											<option value="<?php echo $key; ?>"><?php echo $temp_name_arr[$key]; ?></option>
										<?php } ?>
									 <?php } ?>
								</select>
							</div>
						</li>
						<?php $objXML = simplexml_load_file("config_xml/color_setting.xml"); ?>
						<?php foreach ($objXML->children() as $child) { ?>
							<li><h2 class="title"><?php echo $child->getName();  ?></h2></li>
						<?php foreach($child->children() as $childOFchild){ ?>
							<?php if($childOFchild->frontend=='true'){ ?>
								<li> 
									<h3><?php echo $childOFchild->text; ?></h3>
								<?php foreach($childOFchild->children() as $childOF){ ?>
								<?php if($childOF->itemshow=="true"){ ?>
									<?php if($childOF->text || $childOF->name ){ ?>
									<?php if($childOF->text && $childOF->name ){ echo '<p>'; } ?>
										<?php if($childOF->text){ ?>
											<span><?php echo $childOF->text; ?></span>
										<?php } ?>
										<?php if($childOF->name){ ?>
											<input size=6 type="text" class="hex" style="width:50px" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>" />
										<?php } ?>
									<?php if($childOF->text && $childOF->name ){ echo '</p>'; } ?>
									<?php	} ?>
								<?php	} ?>
								<?php	} ?>
								</li> 
						<?php } } } ?>
					</ul>
				</li> <!-- End Color setting -->
				
			</ul>
			<ul class="reset"><li><span class="button_black"><input class="button special_bt" type="button" value="Reset" onclick="ResetAll()" /></span>
				<input type="hidden" id="colors_data" name="colors_data" value='<?php echo $colors_data; ?>' /></li></ul>
			</div>
		</div> <!-- End .boss-themedesign-->
	<script type="text/javascript"><!--
	var jsprefix = 'res_';
	//--></script>
	<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.dcjqaccordion.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/bossthemes/bossthemes.setting.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.total-storage.min.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/bossthemes/colorpicker.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/bossthemes/eye.js"></script>
	<?php include "catalog/view/javascript/bossthemes/layout.js.php"; ?>
	
	<script type="text/javascript"><!--
	/*$(window).ready(function(){
		$(window).click(function() {
			$('.colorpicker').hide();
		});
		$('input[type="text"]').focus(function() {
			$('.colorpicker').hide();
		});
	});*/
	$(document).ready(function() {			
		$('.hex').focus(function() {			
			$('.colorpicker').hide();			
		});		
		$(document).click(function(e) {
			var checkName=e.target.className;
			if (checkName != 'colorpicker' && checkName != 'colorpicker_color' && checkName != 'check_hide' && checkName != 'colorpicker_hue' && checkName != 'colorpicker_new_color' && checkName != 'colorpicker_current_color' && checkName != 'colorpicker_hex' && checkName != 'colorpicker_rgb_r colorpicker_field' && checkName != 'colorpicker_rgb_g colorpicker_field' && checkName != 'colorpicker_rgb_b colorpicker_field' && checkName != 'colorpicker_hsb_h colorpicker_field' && checkName != 'colorpicker_hsb_s colorpicker_field' && checkName != 'colorpicker_hsb_b colorpicker_field'){			
				$('.colorpicker').hide();			
			}
		});		
	});
	//--></script>
	<script type="text/javascript"><!--
	<?php $objXMLFont = simplexml_load_file("config_xml/font_setting.xml"); ?>
	$('.cpanelContainer').css("display", "block");
	var colorsData = jQuery.parseJSON($("#colors_data").val());
	<?php $objXML = simplexml_load_file("config_xml/color_setting.xml");
	$code_color = array();
	foreach ($objXML->children() as $child){
		foreach($child->children() as $childOFchild){
			foreach($childOFchild->children() as $childOF){ 
				if($childOF->name!=''){
					$code_color[] = $childOF->name;
				}
			}
		}	
	}
	?>
	var id_Color_List = Array(
	<?php foreach ($code_color as $color) {
	if($color==end($code_color))
		echo "'".$color."'";
	else
		echo "'".$color."'".", ";
	} ?>);

	//--></script>
	<script type="text/javascript"><!--
	$(document).ready(function() {
		class_array_new = $.totalStorage(jsprefix + 'changeProductView');
		if (class_array_new) {
			changeProductView(class_array_new[0],class_array_new[1],class_array_new[2]);
			$('#view_'+ class_array_new[0] + '_' + class_array_new[1] + '_' + class_array_new[2]).attr("checked",true);
		}else{
			loadGird();
		}
		var template = '<?php echo($b_Setting['temp_setting']); ?>';
		//changeTemplate(template);
		$('.display').bind('click', function() {
			if (!(($('#content .product-grid .col-xs-24').length)||($('#content .product-list .col-xs-24').length))) {
				loadGird();
			}
		});
	});
	//--></script>
	</div> <!-- End .cpanelContainer -->
	<?php } ?>
<?php }else{ ?>
	<script type="text/javascript"><!--
	loadGird();
	function loadGird()
	{
		<?php $b_Layout_Settings = explode(',', $product_gird); ?>
		var class_left_right = '<?php echo $b_Layout_Settings[0] ; ?>';
		var class_content_str = '<?php echo $b_Layout_Settings[1] ; ?>';
		var class_product_str = '<?php echo $b_Layout_Settings[2] ; ?>';
		changeProductView(class_left_right,class_content_str,class_product_str);
	}
	function changeProductView(class_left_right,class_content_str,class_product_str){
		var class_left = class_left_right;
		var class_right = class_left_right;
		var class_content_arr = new Array();
		var class_product_arr = new Array();
		class_content_arr = class_content_str.split("-");
		class_product_arr = class_product_str.split("-");
		if($("#column-right").length > 0 && $("#column-left").length > 0){
			class_content = class_content_arr[2];
			class_product = class_product_arr[2];
		}else if($("#column-right").length > 0 || $("#column-left").length > 0){
			class_content = class_content_arr[1];
			class_product = class_product_arr[1];
		}else{
			class_content = class_content_arr[0];
			class_product = class_product_arr[0];
		}
		$('.product-grid > div').removeClass();
		$('.product-grid > div').addClass('col-lg-'+class_product +  ' col-md-'+class_product + ' col-sm-'+class_product + ' col-xs-24');
		
		$('.product-list > div').removeClass();
		$('.product-list > div').addClass('col-lg-'+class_product +  ' col-md-'+class_product + ' col-sm-'+class_product + ' col-xs-24');
		
		$('.article-grid > div').removeClass();
		$('.article-grid > div').addClass('col-lg-'+class_product +  ' col-md-'+class_product + ' col-sm-'+class_product + ' col-xs-24');
		
		$('.article-list > div').removeClass();
		$('.article-list > div').addClass('col-lg-'+class_product +  ' col-md-'+class_product + ' col-sm-'+class_product + ' col-xs-24');
		
		$('#content').removeClass();
		$('#content').addClass('col-lg-'+class_content +  ' col-md-'+class_content + ' col-sm-'+class_content + ' col-xs-24');
		
		if($("#column-left").length > 0)
		{
			$('#column-left').removeClass();
			$('#column-left').addClass('col-lg-'+class_left +  ' col-md-'+class_left + ' col-sm-'+class_left + ' col-xs-24');
		}
		if($("#column-right").length > 0)
		{
			$('#column-right').removeClass();
			$('#column-right').addClass('col-lg-'+class_right +  ' col-md-'+class_right + ' col-sm-'+class_right + ' col-xs-24');
		}
	}
	//--></script>
<?php } ?>
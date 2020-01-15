<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div> <!-- End .breadcrumb-->
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
		</div> <!-- End .heading -->
		
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="htabs" id="mainTabs">
					<a href="#ThemeSetting"><?php echo $tab_setting; ?></a>
					<a href="#ThemeFonts"><?php echo $tab_font; ?></a>
					<a href="#ThemeColors"><?php echo $tab_color; ?></a>
					<a href="#customcode"><?php echo $tab_css; ?></a>
					<a href="#customlayout"><?php echo $tab_layout; ?></a>
				</div> <!-- End .mainTabs -->
				<!-- CUSTOM THEME SETTING -->
				<div id="ThemeSetting" class="htabs-content">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td valign="top" >
								<div id="tabs0" class="vtabs">
									<a href="#tab_general_setting"><?php echo $tab_g_setting; ?></a>
									<a href="#tab_layout_setting"><?php echo $tab_g_layout; ?></a>
								</div> <!-- End #tabs0 -->
								
								<!-- CUSTOM GENERAL SETTING -->
								<div id="tab_general_setting" class="vtabs-content">
									<div class="box">
										<div class="heading">
											<h1><?php echo $tab_g_setting; ?></h1>
										</div>
										<div class="content">
											<table class="form">
												<tr>
													<td><?php echo $entry_show; ?></td>
													<td class="left">
														<select name="b_General_Show">
															<?php if ($b_General_Show) { ?>
																<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
																<option value="0"><?php echo $text_disabled; ?></option>
															<?php } else { ?>
																<option value="1"><?php echo $text_enabled; ?></option>
																<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td><h3><strong><?php echo $entry_modecss_set; ?></strong></h3></td>
													<td></td>
												</tr>
												<tr>
													<td><?php echo $entry_modecss; ?></td>
													<td class="left">
														<input type="radio" value="boxed" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'boxed') echo ' checked="checked"'; ?> /> <?php echo $entry_box; ?>
														<input type="radio" value="wide" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'wide') echo ' checked="checked"'; ?> /> <?php echo $entry_wide; ?>
													</td>
												</tr>
												<tr>
													<td><h3><strong><?php echo $entry_product_set; ?></strong></h3></td>
													<td></td>
												</tr>
												<tr>
													<td><?php echo $entry_product_allow ?></td>
													<td class="left">
														<select name="b_General_P_Display">
															<?php if ($b_General_P_Display=='grid') { ?>
																<option value="grid" selected="selected"><?php echo $text_grid; ?></option>
																<option value="list"><?php echo $text_list; ?></option>
															<?php } else { ?>
																<option value="grid"><?php echo $text_grid; ?></option>
																<option value="list" selected="selected"><?php echo $text_list; ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
												<tr>
													<td><h3><strong><?php echo $entry_menu_set; ?></strong></h3></td>
													<td></td>
												</tr>
												<tr>
													<td><?php echo $entry_menu_allow; ?></td>
													<td class="left">
														<select name="b_General_Menu">
															<?php if ($b_General_Menu) { ?>
																<option value="1" selected="selected"><?php echo $text_menu_mega; ?></option>
																<option value="0"><?php echo $text_menu_default; ?></option>
															<?php } else { ?>
																<option value="1"><?php echo $text_menu_mega; ?></option>
																<option value="0" selected="selected"><?php echo $text_menu_default; ?></option>
															<?php } ?>
														</select>
													</td>
												</tr>
											</table>
											<input type="hidden" name="boss_editorthemes_module[0][layout_id]" value="9999" />
											<input type="hidden" name="boss_editorthemes_module[0][position]" value="footer" />
											<input type="hidden" name="boss_editorthemes_module[0][sort_order]" value="0" />
											<input type="hidden" name="boss_editorthemes_module[0][status]" value="1" />
											
										</div>
									</div>
								</div>
								<!-- END CUSTOM GENERAL SETTING -->

								<!-- CUSTOM LAYOUT SETTING -->
								<div id="tab_layout_setting" class="vtabs-content">
									<div class="box">
										<div class="heading">
											<h1><?php echo $entry_layout_set; ?></h1>
										</div>
										<div class="content">
											<table class="form">
												<tr><h3><?php echo $entry_product_view; ?></h3></tr>
												<tr>
													<td><input type="radio" value="8,24-16-8,8-12-24" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '8,24-16-8,8-12-24') echo ' checked="checked"'; ?> /> <?php echo $text_extra; ?>
													</td>
												</tr>
												<tr>
													<td><input type="radio" value="6,24-18-12,6-8-12" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '6,24-18-12,6-8-12') echo ' checked="checked"'; ?> /> <?php echo $text_large; ?>
													</td>
												</tr>
												<tr>
													<td><input type="radio" value="5,24-19-14,cs5-6-8" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '5,24-19-14,cs5-6-8') echo ' checked="checked"'; ?> /> <?php echo $text_medium1; ?>
													</td>
												</tr>
												<tr>
													<td><input type="radio" value="4,24-20-16,4-cs5-6" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '4,24-20-16,4-cs5-6') echo ' checked="checked"'; ?> /> <?php echo $text_small; ?>
													</td>
												</tr>
                                                <tr>
                                                    <td><input type="radio" value="6,24-18-16,4-cs5-6" name="b_Layout_Setting" <?php if ($b_Layout_Setting == '6,24-18-16,4-cs5-6') echo ' checked="checked"'; ?> /> <?php echo $text_small . ' (Custom)'; ?>
                                                    </td>
                                                </tr>
											</table>
										</div>
									</div>
								</div>
								<!-- END CUSTOM LAYOUT SETTING -->
							</td>
						</tr>
					</table>
				</div>
				<!-- END CUSTOM THEME SETTING -->
				
				<!-- CUSTOM THEME FONTS -->
				<div id="ThemeFonts" class="htabs-content">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td valign="top" >
								<div id="tabs2" class="vtabs">
									<a href="#tab_general_font"><?php echo $tab_general_font; ?></a>
									<a href="#tab_header_font"><?php echo $tab_header_font; ?></a>
									<a href="#tab_footer_font"><?php echo $tab_footer_font; ?></a>
									<a href="#tab_menu_font"><?php echo $tab_menu_font; ?></a>
									<a href="#tab_product_font"><?php echo $tab_product_font; ?></a>
									<a href="#tab_title_font"><?php echo $tab_title_font; ?></a>
									<input type="button" class="button" onclick="ResetFont();" value="<?php echo $text_reset; ?>" />
								</div> <!-- End #tabs2 -->
								<?php
									$json = file_get_contents("view/font/webfonts.json", true);
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
								<?php $FontsTransform = array( 'default', 'capitalize', 'lowercase', 'uppercase' ); ?>
								
								<!-- CUSTOM GENERAL FONTS -->
								<?php $objXML = simplexml_load_file("../config_xml/font_setting.xml"); ?>
								<div id="tab_general_font" class="vtabs-content">
									<h3><?php echo $entry_g_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='general'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
												</tr>
												<tr>
													<td><?php echo $text_font_style; ?></td>
													<td>
														<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
															<option><?php echo $text_default; ?></option>
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
														</select><br /><br />
														<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
													</td>
												</tr>
												<tr>
												<td><?php echo $text_font_size; ?></td>
												<td>
													<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<?php foreach ($FontsSizes as $key) { ?>
															<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
															<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
											<tr>
												<td><?php echo $text_font_weight; ?></td>
												<td>
													<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<?php foreach ($FontWeight as $key) { ?>
															<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
															<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
											<tr>
												<td><?php echo $text_transform; ?></td>
												<td>
													<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<?php foreach ($FontsTransform as $key) { ?>
															<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
															<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
											<script type="text/javascript"><!--
												$(document).ready(function() {
													selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
													selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
													selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
													selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
												});
											//--></script>
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM GENERAL FONTS -->
								
								<!-- CUSTOM HEADER FONTS -->
								<div id="tab_header_font" class="vtabs-content">
									<h3><?php echo $entry_h_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
										if($child->getName()=='header'){
											foreach($child->children() as $childOFchild){ ?>
											<tr> 
												<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
											</tr>
											<tr>
												<td><?php echo $text_font_style; ?></td>
												<td>
													<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<option><?php echo $text_default; ?></option>
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
													</select><br /><br />
													<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
												</td>
											</tr>
											<tr>
											<td><?php echo $text_font_size; ?></td>
											<td>
												<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsSizes as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_font_weight; ?></td>
											<td>
												<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontWeight as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_transform; ?></td>
											<td>
												<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsTransform as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
											});
										//--></script>
									<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM HEADER FONTS -->
								
								<!-- CUSTOM FOOTER FONTS -->
								<div id="tab_footer_font" class="vtabs-content">
									<h3><?php echo $entry_f_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
										if($child->getName()=='footer'){
											foreach($child->children() as $childOFchild){ ?>
											<tr> 
												<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
											</tr>
											<tr>
												<td><?php echo $text_font_style; ?></td>
												<td>
													<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<option><?php echo $text_default; ?></option>
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
													</select><br /><br />
													<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
												</td>
											</tr>
											<tr>
											<td><?php echo $text_font_size; ?></td>
											<td>
												<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsSizes as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_font_weight; ?></td>
											<td>
												<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontWeight as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_transform; ?></td>
											<td>
												<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsTransform as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
											});
										//--></script>
									<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM FOOTER FONTS -->
								
								<!-- CUSTOM MENU FONTS -->
								<div id="tab_menu_font" class="vtabs-content">
									<h3><?php echo $entry_m_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
										if($child->getName()=='menu'){
											foreach($child->children() as $childOFchild){ ?>
											<tr> 
												<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
											</tr>
											<tr>
												<td><?php echo $text_font_style; ?></td>
												<td>
													<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<option><?php echo $text_default; ?></option>
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
													</select><br /><br />
													<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
												</td>
											</tr>
											<tr>
											<td><?php echo $text_font_size; ?></td>
											<td>
												<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsSizes as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_font_weight; ?></td>
											<td>
												<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontWeight as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_transform; ?></td>
											<td>
												<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsTransform as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
											});
										//--></script>
									<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM MENU FONTS -->
									
								<!-- CUSTOM PRODUCT FONTS -->
								<div id="tab_product_font" class="vtabs-content">
									<h3><?php echo $entry_p_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
										if($child->getName()=='product'){
											foreach($child->children() as $childOFchild){ ?>
											<tr> 
												<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
											</tr>
											<tr>
												<td><?php echo $text_font_style; ?></td>
												<td>
													<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<option><?php echo $text_default; ?></option>
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
													</select><br /><br />
													<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
												</td>
											</tr>
											<tr>
											<td><?php echo $text_font_size; ?></td>
											<td>
												<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsSizes as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_font_weight; ?></td>
											<td>
												<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontWeight as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_transform; ?></td>
											<td>
												<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsTransform as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
											});
										//--></script>
									<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM PRODUCT FONTS -->
								
								<!-- CUSTOM TITLE FONTS -->
								<div id="tab_title_font" class="vtabs-content">
									<h3><?php echo $entry_t_font; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
										if($child->getName()=='title'){
											foreach($child->children() as $childOFchild){ ?>
											<tr> 
												<td><h3><strong><?php echo $childOFchild->text; ?></strong></h3></td>
											</tr>
											<tr>
												<td><?php echo $text_font_style; ?></td>
												<td>
													<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>')">
														<option><?php echo $text_default; ?></option>
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
													</select><br /><br />
													<span id="span_<?php echo $childOFchild->style; ?>" style="font-family:<?php echo $b_Font_Data[''.$childOFchild->style.'']; ?>"><?php echo $text_test; ?></span>
												</td>
											</tr>
											<tr>
											<td><?php echo $text_font_size; ?></td>
											<td>
												<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsSizes as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_font_weight; ?></td>
											<td>
												<select id="<?php echo $childOFchild->weight; ?>" name="b_Font_Data[<?php echo $childOFchild->weight; ?>]" onchange="selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontWeight as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->weight.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td><?php echo $text_transform; ?></td>
											<td>
												<select id="<?php echo $childOFchild->transform; ?>" name="b_Font_Data[<?php echo $childOFchild->transform; ?>]" onchange="selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')">
													<?php foreach ($FontsTransform as $key) { ?>
														<?php ($key ==  $b_Font_Data[''.$childOFchild->transform.'']) ? $selected = 'selected' : $selected=''; ?>
														<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('#<?php echo $childOFchild->style; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontSize('#<?php echo $childOFchild->size; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontWeight('#<?php echo $childOFchild->weight; ?>','#span_<?php echo $childOFchild->style; ?>');
												selectedFontTrans('#<?php echo $childOFchild->transform; ?>','#span_<?php echo $childOFchild->style; ?>')
											});
										//--></script>
									<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM TITLE FONTS -->
								
							</td>
						</tr>
					</table>
				</div>
				<!-- END CUSTOM THEME FONTS -->
				
				<!-- CUSTOM THEME COLORS -->
				<div id="ThemeColors" class="htabs-content">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td valign="top" >
								<div id="tabs1" class="vtabs">
									<a href="#tab_general_color"><?php echo $tab_general_color; ?></a>
									<a href="#tab_header_color"><?php echo $tab_header_color; ?></a>
									<a href="#tab_footer_color"><?php echo $tab_footer_color; ?></a>
									<a href="#tab_menu_color"><?php echo $tab_menu_color; ?></a>
									<a href="#tab_product_color"><?php echo $tab_product_color; ?></a>
									<a href="#tab_title_color"><?php echo $tab_title_color; ?></a>
									<input type="button" class="button" onclick="ResetColor();" value="<?php echo $text_reset; ?>"/>
								</div> <!-- End #tabs1 -->
								
								<!-- CUSTOM TEAMPLATE SETTING -->
								<div id="template_setting" class="vtabs-content">
									<h3><?php echo $entry_template_set; ?></h3>
									<table class="form">
										<tr>
											<td><label><?php echo $entry_template; ?></label></td>
											<td>
												<select id="temp_setting" name="b_Setting[temp_setting]" onchange="changeTemplate();">
													<option value="custom" <?php ($b_Setting['temp_setting']) =='custom' ? $selected = 'selected' : $selected = ''; ?>><?php echo $text_custom; ?></option>
													<?php foreach ($temp_setting_arr as $key => $value){ ?>
														<?php if ($key == $b_Setting['temp_setting']){ ?>
															<option value="<?php echo $key; ?>" selected="selected"><?php echo $temp_name_arr[$key]; ?></option>
														<?php } else{ ?>
															<option value="<?php echo $key; ?>"><?php echo $temp_name_arr[$key]; ?></option>
														<?php } ?>
													 <?php } ?>
												</select>
											</td>
										</tr>
									</table>
								</div>
								<!-- END CUSTOM TEAMPLATE SETTING -->
								
								<!-- CUSTOM GENERAL COLORS -->
								<?php $objXML = simplexml_load_file("../config_xml/color_setting.xml"); ?>

								<div id="tab_general_color" class="vtabs-content">
									<h3><?php echo $entry_g_color; ?></h3>
									<table class="form">
										<tr>
											<td><label><?php echo $entry_back_image; ?></label></td>
											<td>
												<div class="bg_image">
													<span class="g_bg_image" style="background:url('view/image/background/back_0.png') repeat;float:left;margin:0 10px 10px 0">
														<input type="radio" name="b_Color_Data[g_bg_image]" value="default" <?php if ($b_Color_Data['g_bg_image'] == 'default') echo ' checked="checked"'; ?> />
													</span>
													<?php foreach ($bg_images as $image => $settings) {?>
														<span class="g_bg_image" style="background:url('view/image/background/<?php echo $settings; ?>') repeat;float:left;margin:0 10px 10px 0">
														<input type="radio" name="b_Color_Data[g_bg_image]" value="<?php echo$settings; ?>" <?php if ($b_Color_Data['g_bg_image'] == $settings) echo ' checked="checked"'; ?> /> </span>
													<?php }?>
													<span><input type="radio" name="b_Color_Data[g_bg_image]" value="g_upload_bg_image" <?php if ($b_Color_Data['g_bg_image'] == 'g_upload_bg_image') echo ' checked="checked"'; ?> /><?php echo $text_upload_image; ?></span>
												</div>
												<div class="upload_image">
													<?php if(($b_Color_Data['g_upload_bg_image'])!=''){ ?>
														<img src="../image/<?php echo $b_Color_Data['g_upload_bg_image']; ?>" width="100px" height="50px" alt="" id="g_thumb" />
													<?php } ?>
													<?php if($b_Color_Data['g_upload_bg_image']==''){ ?>
														<img src="<?php echo $no_image; ?>" id="g_thumb" />
													<?php } ?>
													<input type="hidden" name="b_Color_Data[g_upload_bg_image]" value="<?php echo $b_Color_Data['g_upload_bg_image']; ?>" id="g_image" />
													  <br />
													<a onclick="image_upload('g_image', 'g_thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#g_thumb').attr('src', '<?php echo $no_image; ?>'); $('#g_image').attr('value', '');"><?php echo $text_clear; ?></a>
												</div>
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_repeat; ?></span>
													<select name="b_Color_Data[g_bg_image_repeat]">
														<option value="repeat"<?php if ($b_Color_Data['g_bg_image_repeat'] == 'repeat') echo ' selected="selected"'; ?>><?php echo $text_repeat; ?></option>
														<option value="no-repeat"<?php if ($b_Color_Data['g_bg_image_repeat'] == 'no-repeat') echo ' selected="selected"'; ?>><?php echo $text_no_repeat; ?></option>
														<option value="repeat-x"<?php if ($b_Color_Data['g_bg_image_repeat'] == 'repeat-x') echo ' selected="selected"'; ?>><?php echo $text_repeat_x; ?></option>
														<option value="repeat-y"<?php if ($b_Color_Data['g_bg_image_repeat'] == 'repeat-y') echo ' selected="selected"'; ?>><?php echo $text_repeat_y; ?></option>
														
													</select>
												</div><br />
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_position_image; ?></span>
													<select name="b_Color_Data[g_bg_image_position]">
														<option value="left top"<?php if ($b_Color_Data['g_bg_image_position'] == 'left top') echo ' selected="selected"'; ?>><?php echo $text_left_top; ?></option>
														<option value="right top"<?php if ($b_Color_Data['g_bg_image_position'] == 'right top') echo ' selected="selected"'; ?>><?php echo $text_right_top; ?></option>
														<option value="center top"<?php if ($b_Color_Data['g_bg_image_position'] == 'center top') echo ' selected="selected"'; ?>><?php echo $text_center_top; ?></option>
														<option value="center center"<?php if ($b_Color_Data['g_bg_image_position'] == 'center center') echo ' selected="selected"'; ?>><?php echo $text_center_center; ?></option>
													</select>
												</div>
											</td>
										</tr>
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='general'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM GENERAL COLORS -->
								
								<!-- CUSTOM HEADER COLORS -->
								<div id="tab_header_color" class="vtabs-content">
									<h3><?php echo $entry_h_color; ?></h3>
									<table class="form">
																											
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='header'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM HEADER COLORS -->
								
								<!-- CUSTOM FOOTER COLORS -->
								<div id="tab_footer_color" class="vtabs-content">
									<h3><?php echo $entry_f_color; ?></h3>
									<table class="form">
										<tr>
											<td><label><?php echo $entry_back_image; ?></label></td>
											<td>
												<div class="bg_image">
													<span class="f_bg_image" style="background:url('view/image/background/back_0.png') repeat;float:left;margin:0 10px 10px 0">
													<input type="radio" name="b_Color_Data[f_bg_image]" value="default" <?php if ($b_Color_Data['f_bg_image'] == 'default') echo ' checked="checked"'; ?> />
													</span>
												<?php foreach ($bg_images as $image => $settings) {?>
													<span class="f_bg_image" style="background:url('view/image/background/<?php echo $settings; ?>') repeat;float:left;margin:0 10px 10px 0">
													<input type="radio" name="b_Color_Data[f_bg_image]" value="<?php echo$settings; ?>" <?php if ($b_Color_Data['f_bg_image'] == $settings) echo ' checked="checked"'; ?> /> </span>
												<?php }?>
													<span><input type="radio" name="b_Color_Data[f_bg_image]" value="f_upload_bg_image" <?php if ($b_Color_Data['f_bg_image'] == 'f_upload_bg_image') echo ' checked="checked"'; ?> /><?php echo $text_upload_image; ?></span>
												</div>
												<div class="upload_image">
													<?php if($b_Color_Data['f_upload_bg_image']!=''){ ?>
														<img src="../image/<?php echo $b_Color_Data['f_upload_bg_image']; ?>" width="100px" height="50px" alt="" id="f_thumb" />
													<?php } ?>
													<?php if($b_Color_Data['f_upload_bg_image']==''){ ?>
														<img src="<?php echo $no_image; ?>" id="f_thumb" />
													<?php } ?>
													<input type="hidden" name="b_Color_Data[f_upload_bg_image]" value="<?php echo $b_Color_Data['f_upload_bg_image']; ?>" id="f_image" />
													  <br />
													<a onclick="image_upload('f_image', 'f_thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#f_thumb').attr('src', '<?php echo $no_image; ?>'); $('#f_image').attr('value', '');"><?php echo $text_clear; ?></a>
												</div>
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_repeat; ?></span>
													<select name="b_Color_Data[f_bg_image_repeat]">
														<option value="repeat"<?php if ($b_Color_Data['f_bg_image_repeat'] == 'repeat') echo ' selected="selected"'; ?>><?php echo $text_repeat; ?></option>
														<option value="no-repeat"<?php if ($b_Color_Data['f_bg_image_repeat'] == 'no-repeat') echo ' selected="selected"'; ?>><?php echo $text_no_repeat; ?></option>
														<option value="repeat-x"<?php if ($b_Color_Data['f_bg_image_repeat'] == 'repeat-x') echo ' selected="selected"'; ?>><?php echo $text_repeat_x; ?></option>
														<option value="repeat-y"<?php if ($b_Color_Data['f_bg_image_repeat'] == 'repeat-y') echo ' selected="selected"'; ?>><?php echo $text_repeat_y; ?></option>
													</select>
												</div><br />
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_position_image; ?></span>
													<select name="b_Color_Data[f_bg_image_position]">
														<option value="left top"<?php if ($b_Color_Data['f_bg_image_position'] == 'left top') echo ' selected="selected"'; ?>><?php echo $text_left_top; ?></option>
														<option value="right top"<?php if ($b_Color_Data['f_bg_image_position'] == 'right top') echo ' selected="selected"'; ?>><?php echo $text_right_top; ?></option>
														<option value="center top"<?php if ($b_Color_Data['f_bg_image_position'] == 'center top') echo ' selected="selected"'; ?>><?php echo $text_center_top; ?></option>
														<option value="center center"<?php if ($b_Color_Data['f_bg_image_position'] == 'center center') echo ' selected="selected"'; ?>><?php echo $text_center_center; ?></option>
													</select>
												</div>
											</td>
										</tr>
																	
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='footer'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM FOOTER COLORS -->
								
								<!-- CUSTOM MENU COLORS -->
								<div id="tab_menu_color" class="vtabs-content">
									<h3><?php echo $entry_m_color; ?></h3>
									<table class="form">
										
										<tr>
											<td><label><?php echo $entry_back_image_drop; ?></label></td>
											<td>
												<div class="bg_image">
													<span class="mdrop_bg_image" style="background:url('view/image/background/back_0.png') repeat;float:left;margin:0 10px 10px 0">
													<input type="radio" name="b_Color_Data[mdrop_bg_image]" value="default" <?php if ($b_Color_Data['mdrop_bg_image'] == 'default') echo ' checked="checked"'; ?> />
													</span>
												<?php foreach ($bg_images as $image => $settings) {?>
													<span class="mdrop_bg_image" style="background:url('view/image/background/<?php echo $settings; ?>') repeat;float:left;margin:0 10px 10px 0">
													<input type="radio" name="b_Color_Data[mdrop_bg_image]" value="<?php echo$settings; ?>" <?php if ($b_Color_Data['mdrop_bg_image'] == $settings) echo ' checked="checked"'; ?> /> </span>
												<?php }?>
													<span><input type="radio" name="b_Color_Data[mdrop_bg_image]" value="mdrop_upload_bg_image" <?php if ($b_Color_Data['mdrop_bg_image'] == 'mdrop_upload_bg_image') echo ' checked="checked"'; ?> /><?php echo $text_upload_image; ?></span>
												</div>
												<div class="upload_image">
													<?php if($b_Color_Data['mdrop_upload_bg_image']!=''){ ?>
														<img src="../image/<?php echo $b_Color_Data['mdrop_upload_bg_image']; ?>" width="100px" height="50px" alt="" id="m_drop_thumb" />
													<?php } ?>
													<?php if($b_Color_Data['mdrop_upload_bg_image']==''){ ?>
														<img src="<?php echo $no_image; ?>" id="m_drop_thumb" />
													<?php } ?>
													<input type="hidden" name="b_Color_Data[mdrop_upload_bg_image]" value="<?php echo $b_Color_Data['mdrop_upload_bg_image']; ?>" id="m_drop_image" />
													  <br />
													<a onclick="image_upload('m_drop_image', 'm_drop_thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#m_drop_thumb').attr('src', '<?php echo $no_image; ?>'); $('#m_drop_image').attr('value', '');"><?php echo $text_clear; ?></a>
												</div>
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_repeat; ?></span>
													<select name="b_Color_Data[mdrop_bg_image_repeat]">
														<option value="repeat"<?php if ($b_Color_Data['mdrop_bg_image_repeat'] == 'repeat') echo ' selected="selected"'; ?>><?php echo $text_repeat; ?></option>
														<option value="no-repeat"<?php if ($b_Color_Data['mdrop_bg_image_repeat'] == 'no-repeat') echo ' selected="selected"'; ?>><?php echo $text_no_repeat; ?></option>
														<option value="repeat-x"<?php if ($b_Color_Data['mdrop_bg_image_repeat'] == 'repeat-x') echo ' selected="selected"'; ?>><?php echo $text_repeat_x; ?></option>
														<option value="repeat-y"<?php if ($b_Color_Data['mdrop_bg_image_repeat'] == 'repeat-y') echo ' selected="selected"'; ?>><?php echo $text_repeat_y; ?></option>
														
													</select>
												</div><br />
												<div class="image_repeat" style="clear:both;">
													<span><?php echo $entry_position_image; ?></span>
													<select name="b_Color_Data[mdrop_bg_image_position]">
														<option value="left top"<?php if ($b_Color_Data['mdrop_bg_image_position'] == 'left top') echo ' selected="selected"'; ?>><?php echo $text_left_top; ?></option>
														<option value="right top"<?php if ($b_Color_Data['mdrop_bg_image_position'] == 'right top') echo ' selected="selected"'; ?>><?php echo $text_right_top; ?></option>
														<option value="center top"<?php if ($b_Color_Data['mdrop_bg_image_position'] == 'center top') echo ' selected="selected"'; ?>><?php echo $text_center_top; ?></option>
														<option value="center center"<?php if ($b_Color_Data['mdrop_bg_image_position'] == 'center center') echo ' selected="selected"'; ?>><?php echo $text_center_center; ?></option>
													</select>
												</div>
											</td>
										</tr>
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='menu'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM MENU COLORS -->							
								
								
								<!-- CUSTOM PRODUCT COLORS -->
								<div id="tab_product_color" class="vtabs-content">
									<h3><?php echo $entry_p_color; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='product'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM PRODUCT COLORS -->
								
								<!-- CUSTOM TITLE COLORS -->
								<div id="tab_title_color" class="vtabs-content">
									<h3><?php echo $entry_t_color; ?></h3>
									<table class="form">
										<?php foreach ($objXML->children() as $child) {	
											if($child->getName()=='title'){
												foreach($child->children() as $childOFchild){ ?>
												<tr> 
													<td><label><?php echo $childOFchild->text; ?></label></td>
													<td>
												<?php foreach($childOFchild->children() as $childOF){ ?>
													
													<?php if($childOF->text){ ?>
														<span><?php echo $childOF->text; ?></span>
													<?php } ?>
													<?php if($childOF->name){ ?>
														<?php if(isset($b_Color_Data[''.$childOF->name.''])) { ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>">
														<?php } else{ ?>
															<input size=6 type="text" class="hex" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="">
														<?php } ?>
													
													<?php } ?>
												<?php	} ?>
													</td>
												</tr> 
										<?php } } } ?>
									</table>
								</div>
								<!-- END CUSTOM TITLE COLORS -->
							</td>
						</tr>
						<input type="hidden" id="colors_data" name="colors_data" value='<?php echo $colors_data; ?>' />
					</table>
				</div>
				
				<!-- END CUSTOM THEME COLORS -->
				
				<!-- CUSTOMIZE CODE -->
				<div id="customcode" class="htabs-content">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr>
							<td valign="top" >
								<div id="tabscode" class="vtabs">
									<a href="#tab_custom_css"><?php echo $tab_custom_css; ?></a>
									<a href="#tab_custom_java"><?php echo $tab_custom_java; ?></a>
								</div> <!-- End #tabscode -->
								<!-- CUSTOM CSS -->
								<div id="tab_custom_css" class="vtabs-content">
									<h3><?php echo $entry_custom_css; ?></h3>
									<p><span>This is advanded feature for who having knowledge of CSS Language. You put css rules in below</span></p><br />
									<textarea name="customcode[custom_css]" rows="16" cols="80"><?php echo ($customcode!='')?$customcode['custom_css']:''; ?></textarea>
								</div>
								
								<!-- CUSTOM Javascript -->
								<div id="tab_custom_java" class="vtabs-content">
									<h3><?php echo $entry_custom_java; ?></h3>
									<p><span>Add javascript code. Please be carefull</span></p><br />
									<textarea name="customcode[custom_java]" rows="16" cols="80"><?php echo ($customcode!='')?$customcode['custom_java']:''; ?></textarea>
								</div>
							</td>
						</tr>
					</table>
				</div>
				
				<!-- END CUSTOMIZE CODE -->
				
				<!-- CUSTOM POSITION MODUlE-->
				<div id="customlayout" class="htabs-content">
					<?php include( "boss_editorthemes_layout.tpl" ); ?>
				</div>
				<!-- END CUSTOM POSITION MODUlE -->
			</form>
		</div> <!-- End .content -->
	</div> <!-- End .box -->
</div>
<script type="text/javascript" src="view/javascript/bossthemes/colorpicker.js"></script>
<script type="text/javascript" src="view/javascript/bossthemes/eye.js"></script>
<script type="text/javascript" src="view/javascript/bossthemes/layout.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/bossthemes/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/bossthemes/layout.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/bossthemes/bossthemes.css" />
<script type="text/javascript"><!--
<?php
$objXML_font = simplexml_load_file("../config_xml/font_setting.xml");
$code_font = array();
foreach ($objXML_font->children() as $child){
	foreach($child->children() as $childOFchild){
		$code_font[] = $childOFchild->style;
		$code_font[] = $childOFchild->size;
		$code_font[] = $childOFchild->weight;
		$code_font[] = $childOFchild->transform;	
	}	
} 
 $count_code_font = count($code_font);
?>

var id_Font_List = Array(<?php foreach ($code_font as $key => $font) {
								if($key == ($count_code_font - 1))
									echo "'".$font."'";
								else
									echo "'".$font."'".", ";
								
								} ?>);
								
<?php
$objXML = simplexml_load_file("../config_xml/color_setting.xml");
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
var id_Color_List = Array(<?php foreach ($code_color as $color) {
								if($color==end($code_color))
									echo "'".$color."'";
								else
									echo "'".$color."'".", ";
								
								} ?>);
var colorsData = jQuery.parseJSON($("#colors_data").val());
function changeTemplate() {
	themeName = $("#temp_setting").val();
    themeData = colorsData[themeName];
	for(var i = 0 ; i < id_Color_List.length; i++ ){
		var idName = id_Color_List[i];
		$("#" + id_Color_List[i]).css('background', '#' + themeData[idName]);
		$("#" + id_Color_List[i]).val(themeData[idName]);
	};
};
//--></script>
<script type="text/javascript"><!--
function selectedFontStyle($id,$span){
	var span = $($span);
	var idSelect = $($id);
	if(idSelect.val() == 'Arial'){
		span.css("font-family",'Arial');
		span.css("display",'');
	}else if(idSelect.val() == 'Verdana'){
		span.css("font-family",'Verdana');
		span.css("display",'');
	}else if(idSelect.val() == 'Helvetica'){
		span.css("font-family",'Helvetica');
		span.css("display",'');
	}else if(idSelect.val() == 'Lucida Grande'){
		span.css("font-family",'Lucida Grande');
		span.css("display",'');
	}else if(idSelect.val() == 'Trebuchet MS'){
		span.css("font-family",'Trebuchet MS');
		span.css("display",'');
	}else if(idSelect.val() == 'Times New Roman'){
		span.css("font-family",'Times New Roman');
		span.css("display",'');
	}else if(idSelect.val() == 'Tahoma'){
		span.css("font-family",'Tahoma');
		span.css("display",'');
	}else if(idSelect.val() == 'Georgia'){
		span.css("font-family",'Georgia');
		span.css("display",'');
	}else if(idSelect.val() == 'default'){
		span.css("font-family",'');
		span.css("display",'none');
	}else {
		var font = 	idSelect.val().replace(/\+/g," ");
		
		$('head').append('<link id="link_' + idSelect + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + font + '">');
		span.css("font-family",'"'+ font +'"');
		span.css("display",'');
	}
}
function selectedFontWeight($id,$span){
	var span = $($span);
	var idSelect = $($id);
	if(idSelect.val() == 'default'){
		span.css("font-weight",'');	
	}else {
		span.css("font-weight",idSelect.val());
	}
}

function selectedFontSize($id,$span){
	var span = $($span);
	var idSelect = $($id);
	if(idSelect.val() == 'default'){
		span.css("font-size",'');	
	}else {
		span.css("font-size",idSelect.val());
	}
}

function selectedFontTrans($id,$span){
	var span = $($span);
	var idSelect = $($id);
	if(idSelect.val() == 'default'){
		span.css("text-transform",'');	
	}else {
		span.css("text-transform",idSelect.val());
	}
}
$(document).ready( function(){		
		$(".button-action").click( function(){
			$('#action_type').val( $(this).attr("rel") );
			var string = 'rand='+Math.random();
			var hook = '';
			$(".ui-sortable").each( function(){
				if( $(this).attr("data-position") && $(".module-pos",this).length>0) {
					var position = $(this).attr("data-position");
					$(".module-pos",this).each( function(){
						if( $(this).attr("data-id") != "" ){
							hook += "modules["+position+"][]="+$(this).attr("data-id")+"&";
						}				
					} );
					string = string.replace(/\,$/,"");
					hook = hook.replace(/\,$/,"");
				}	
			} );
			var unhook = '';

			$.ajax({
			  type: 'POST',
			  url: '<?php echo str_replace("&amp;","&",$ajax_modules_position);?>',
			  data: string+"&"+hook+unhook,
			  success: function(){
				$('#sform').submit();
			  }
			});
		return false; 
	} );
} );

//--></script>
<script type="text/javascript"><!--
<!-- TABS -->
$('#mainTabs a').tabs();
$('#tabs0 a').tabs();
$('#tabscode a').tabs();
$('#tabs01 a').tabs();
$('#tabs1 a').tabs();
$('#tabs2 a').tabs();
$('#languages a').tabs(); 
//--></script>
<script type="text/javascript"><!--
function image_upload(field,thumb) {
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
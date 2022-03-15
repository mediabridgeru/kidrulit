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
    <div class="buttons"><a onclick="$('#form').attr('target', '_self'); $('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
	<div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-option"><?php echo $tab_option; ?></a><a href="#tab-image"><?php echo $tab_image; ?></a><a href="#tab-design"><?php echo $tab_design; ?></a><a href="#tab-upload">Загрузка прайс-листа</a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div id="tab-general">
			<table class="form">

			<tr>
				  <td><span class="required">*</span><?php echo $entry_store; ?></td>
				  <td><div class="scrollbox">
					  <?php $class = 'even'; ?>
					  <div class="<?php echo $class; ?>">
						<?php if (in_array(0, $xls_pricelist_store)) { ?>
						<input type="checkbox" name="xls_pricelist_store[]" value="0" checked="checked" />
						<?php echo $text_default; ?>
						<?php } else { ?>
						<input type="checkbox" name="xls_pricelist_store[]" value="0" />
						<?php echo $text_default; ?>
						<?php } ?>
					  </div>
					  <?php foreach ($stores as $store) { ?>
					  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $class; ?>">
						<?php if (in_array($store['store_id'], $xls_pricelist_store)) { ?>
						<input type="checkbox" name="xls_pricelist_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
						<?php echo $store['name']; ?>
						<?php } else { ?>
						<input type="checkbox" name="xls_pricelist_store[]" value="<?php echo $store['store_id']; ?>" />
						<?php echo $store['name']; ?>
						<?php } ?>
					  </div>
					  <?php } ?>
					</div>
					<?php if (isset($error_xls_pricelist_store)) { ?>
					  <span class="error"><?php echo $error_xls_pricelist_store; ?></span>
					  <?php } ?>
					</td>
				</tr>
			<tr>
				<td><span class="required">*</span> <?php echo $entry_category; ?></td>
				<td>
					<div class="scrollbox">
					<?php $class = 'odd'; ?>
					<?php foreach ($categories as $category) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
					  <?php if (in_array($category['category_id'], $xls_pricelist_category)) { ?>
					  <input class="xls_pricelist_category" type="checkbox" name="xls_pricelist_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
					  <?php echo $category['name']; ?>
					  <?php } else { ?>
					  <input class="xls_pricelist_category" type="checkbox" name="xls_pricelist_category[]" value="<?php echo $category['category_id']; ?>" />
					  <?php echo $category['name']; ?>
					  <?php } ?>
					</div>
					<?php } ?>
				  </div>
				  <br>
				  <a href="#" onclick="$('.scrollbox .xls_pricelist_category').prop('checked', !($('.scrollbox .xls_pricelist_category').is(':checked'))); return false;"><?php echo $text_select_all; ?></a> 
				  <?php if (isset($error_xls_pricelist_category)) { ?>
					  <span class="error"><?php echo $error_xls_pricelist_category; ?></span>
					  <?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_nodubles; ?></td>
				<td>
				<select name="xls_pricelist_nodubles">
					<?php if($xls_pricelist_nodubles){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_sort_order; ?></td>
				<td>
				<select name="xls_pricelist_sort_order">
					<?php foreach ($sorts as $sorts) { ?>
						<?php if ($sorts['value'] == $xls_pricelist_sort_order) { ?>
						<option value="<?php echo $sorts['value']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sorts['value']; ?>"><?php echo $sorts['text']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo $entry_customer_group; ?></td>
				<td>
					<div class="scrollbox">
					<?php $class = 'odd'; ?>
					<?php foreach ($customer_groups as $customer_group) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
					  <?php if (in_array($customer_group['customer_group_id'], $xls_pricelist_customer_group)) { ?>
					  <input class="xls_pricelist_customer_group" type="checkbox" name="xls_pricelist_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
					  <?php echo $customer_group['name']; ?>
					  <?php } else { ?>
					  <input class="xls_pricelist_customer_group" type="checkbox" name="xls_pricelist_customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
					  <?php echo $customer_group['name']; ?>
					  <?php } ?>
					</div>
					<?php } ?>
				  </div>
				  <br>
				  <a href="#" onclick="$('.scrollbox .xls_pricelist_customer_group').prop('checked', !($('.scrollbox .xls_pricelist_customer_group').is(':checked'))); return false;"><?php echo $text_select_all; ?></a> 
				  
				  <?php if (isset($error_xls_pricelist_customer_group)) { ?>
					  <span class="error"><?php echo $error_xls_pricelist_customer_group; ?></span>
					  <?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_attribute_groups; ?></td>
				<td>
					<div class="scrollbox">
					<?php $class = 'odd'; ?>
					<?php foreach ($attribute_groups as $attribute_group) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
					  <?php if (in_array($attribute_group['attribute_group_id'], $xls_pricelist_attribute_group)) { ?>
					  <input class="xls_pricelist_attribute_group" type="checkbox" name="xls_pricelist_attribute_group[]" value="<?php echo $attribute_group['attribute_group_id']; ?>" checked="checked" />
					  <?php echo $attribute_group['name']; ?>
					  <?php } else { ?>
					  <input class="xls_pricelist_attribute_group" type="checkbox" name="xls_pricelist_attribute_group[]" value="<?php echo $attribute_group['attribute_group_id']; ?>" />
					  <?php echo $attribute_group['name']; ?>
					  <?php } ?>
					</div>
					<?php } ?>
				  </div>
				  <br>
				  <a href="#" onclick="$('.scrollbox .xls_pricelist_attribute_group').prop('checked', !($('.scrollbox .xls_pricelist_attribute_group').is(':checked'))); return false;"><?php echo $text_select_all; ?></a> 
				  
				</td>
			</tr>
			
			</table>
            <table class="form">
                <tr >
                    <td></td>
                    <td>
                        <input type="hidden" name="action" value="generate" />
                        <a onclick="$('#form').attr('target', '_blank'); $('#form').attr('action', '<?php echo $view; ?>'); $('#form').submit();" class="button"><?php echo $button_view; ?></a>
                    </td>
                </tr>
            </table>
		</div>
		<div id="tab-data">
			
			  <div id="languages" class="htabs">
				<?php foreach ($languages as $language) { ?>
				<a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
				<?php } ?>
			  </div>
			  <?php foreach ($languages as $language) { ?>
			  <div id="language<?php echo $language['language_id']; ?>">
              <table class="form">
                <tr >
                    <td><?php echo $entry_title; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['title'] : ''; ?>" size="67"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][title_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['title_color'])&&$xls_pricelist_description[$language['language_id']]['title_color'] ? $xls_pricelist_description[$language['language_id']]['title_color'] : '000000'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_adress; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][adress]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['adress'] : ''; ?>" size="67"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][adress_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['adress_color'])&&$xls_pricelist_description[$language['language_id']]['adress_color'] ? $xls_pricelist_description[$language['language_id']]['adress_color'] : '000000'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_phone; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][phone]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['phone'] : ''; ?>" size="67"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][phone_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['phone_color'])&&$xls_pricelist_description[$language['language_id']]['phone_color'] ? $xls_pricelist_description[$language['language_id']]['phone_color'] : '000000'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_email; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][email]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['email'] : ''; ?>" size="67"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][email_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['email_color'])&&$xls_pricelist_description[$language['language_id']]['email_color'] ? $xls_pricelist_description[$language['language_id']]['email_color'] : '339966'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_link; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][link]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['link'] : ''; ?>" size="67"/>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][link_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['link_color'])&&$xls_pricelist_description[$language['language_id']]['link_color'] ? $xls_pricelist_description[$language['language_id']]['link_color'] : '0000FF'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_custom_text; ?></td>
                    <td>
                    <textarea name="xls_pricelist_description[<?php echo $language['language_id']; ?>][custom_text]" cols="67" rows="5"><?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['custom_text'] : ''; ?></textarea>
                    &nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="jpicker"  name="xls_pricelist_description[<?php echo $language['language_id']; ?>][custom_color]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]['custom_color'])&&$xls_pricelist_description[$language['language_id']]['custom_color'] ? $xls_pricelist_description[$language['language_id']]['custom_color'] : '000000'; ?>" />
                    </td>
                </tr>
                <tr >
                    <td><?php echo $entry_text_list; ?></td>
                    <td>
                    <input type="text" name="xls_pricelist_description[<?php echo $language['language_id']; ?>][listname]" value="<?php echo isset($xls_pricelist_description[$language['language_id']]) ? $xls_pricelist_description[$language['language_id']]['listname'] : ''; ?>" size="30"/>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $entry_currency; ?></td>
                    <td>
                    <select name="xls_pricelist_description[<?php echo $language['language_id']; ?>][currency]">
                        <?php foreach ($currencies as $currency) { ?>
                            <?php if ($currency['code'] == $xls_pricelist_description[$language['language_id']]['currency']) { ?>
                            <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    </td>
                </tr>
              </table>
			  </div>
			  <?php } ?>

		</div>
		<div id="tab-option">
			<table class="form">
			<tr>
				<td><?php echo $entry_use_attributes; ?></td>
				<td>
				<select name="xls_pricelist_use_attributes">
					<?php if($xls_pricelist_use_attributes){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_options; ?></td>
				<td>
				<select name="xls_pricelist_use_options">
					<?php if($xls_pricelist_use_options){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_notinstock; ?></td>
				<td>
				<select name="xls_pricelist_use_notinstock">
					<?php if($xls_pricelist_use_notinstock){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_quantity; ?></td>
				<td>
				<select name="xls_pricelist_use_quantity">
					<?php if($xls_pricelist_use_quantity){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_view; ?></td>
				<td>
				<select name="xls_pricelist_view">
					<?php if($xls_pricelist_view){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $entry_use_code; ?></td>
				<td>
				<select name="xls_pricelist_use_code">
					<?php if($xls_pricelist_use_code){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="entry_code" <?php if($xls_pricelist_use_code==0) echo 'style="display:none;"'; ?>>
				<td><?php echo $entry_code; ?></td>
				<td>
				<select name="xls_pricelist_code">
					<option <?php if($xls_pricelist_code=="model")echo 'selected'; ?> value="model">model</option>
					<option <?php if($xls_pricelist_code=="sku")echo 'selected'; ?> value="sku">sku</option>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_special; ?></td>
				<td>
				<select name="xls_pricelist_use_special">
					<?php if($xls_pricelist_use_special){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_cache; ?></td>
				<td>
				<select name="xls_pricelist_usecache">
					<option <?php if($xls_pricelist_usecache=="no")echo 'selected'; ?> value="no"><?php echo $text_no; ?></option>
					<option <?php if($xls_pricelist_usecache=="file")echo 'selected'; ?> value="file">file</option>
					<option <?php if($xls_pricelist_usecache=="memcache")echo 'selected'; ?> value="memcache">memcache *</option>
				</select>
				<div class="memcache_params"<?php if($xls_pricelist_usecache!='memcache')echo 'style="display:none;"'; ?>>
				<br />
				<?php echo $entry_memcache_warning; ?><br />
				memcacheServer: <input type="text" name="xls_pricelist_memcacheServer" value="<?php echo $xls_pricelist_memcacheServer; ?>" /><br />
				memcachePort: <input type="text" name="xls_pricelist_memcachePort" value="<?php echo $xls_pricelist_memcachePort; ?>" /><br />
				cacheTime: <input type="text" name="xls_pricelist_cacheTime" value="<?php echo $xls_pricelist_cacheTime; ?>" />
				
				</div>
				</td>
			</tr>
			
			</table>
		</div>
		<div id="tab-image">
			<table class="form">
				<tr>
					<td><?php echo $entry_logo; ?></td>
					<td>
						<div class="image"><img src="<?php echo $logo; ?>" alt="" id="thumb-logo" />
						  <input type="hidden" name="xls_pricelist_logo" value="<?php echo $xls_pricelist_logo; ?>" id="logo" />
						  <br />
						  <a onclick="image_upload('logo', 'thumb-logo');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');"><?php echo $text_clear; ?></a></div>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_logo_dimensions; ?></td>
					<td>
					<input type="text" name="xls_pricelist_logo_width" value="<?php echo $xls_pricelist_logo_width; ?>" size="3"/>
					 x 
					<input type="text" name="xls_pricelist_logo_height" value="<?php echo $xls_pricelist_logo_height; ?>" size="3"/>
					<?php if (isset($error_xls_pricelist_dimensions1)) { ?>
						  <span class="error"><?php echo $error_xls_pricelist_dimensions1; ?></span>
						  <?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_use_image; ?></td>
					<td>
					<select name="xls_pricelist_use_image">
						<?php if($xls_pricelist_use_image){ ?>
						<option value="0"><?php echo $text_no; ?></option>
						<option value="1" selected="selected"><?php echo $text_yes; ?></option>
						<?php }else{ ?>
						<option value="0" selected="selected"><?php echo $text_no; ?></option>
						<option value="1"><?php echo $text_yes; ?></option>
						<?php } ?>
					</select>
					</td>
				</tr>
				<tr >
					<td><?php echo $entry_image_dimensions; ?></td>
					<td>
					<input type="text" name="xls_pricelist_image_width" value="<?php echo $xls_pricelist_image_width; ?>" size="3"/>
					 x 
					<input type="text" name="xls_pricelist_image_height" value="<?php echo $xls_pricelist_image_height; ?>" size="3"/>
					<?php if (isset($error_xls_pricelist_dimensions)) { ?>
						  <span class="error"><?php echo $error_xls_pricelist_dimensions; ?></span>
						  <?php } ?>
					</td>
				</tr>
			</table>
		</div>
		<div id="tab-design">
			<table class="form">
			<tr>
				<td><?php echo $entry_dimensions; ?></td>
				<td>
					<table>
						<tr>
							<td>
								<?php echo $entry_model; ?>
							</td>
							<td>
								<?php echo $entry_name; ?>
							</td>
							<td>
								<?php echo $entry_stock; ?>
							</td>
							<td>
								<?php echo $entry_price; ?>
							</td>
							<td>
								<?php echo $entry_special; ?>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="xls_pricelist_model_width" value="<?php echo $xls_pricelist_model_width; ?>" />
							</td>
							<td>
								<input type="text" name="xls_pricelist_name_width" value="<?php echo $xls_pricelist_name_width; ?>" />
							</td>
							<td>
								<input type="text" name="xls_pricelist_stock_width" value="<?php echo $xls_pricelist_stock_width; ?>" />
							</td>
							<td>
								<input type="text" name="xls_pricelist_price_width" value="<?php echo $xls_pricelist_price_width; ?>" />
							</td>
							<td>
								<input type="text" name="xls_pricelist_special_width" value="<?php echo $xls_pricelist_special_width; ?>" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_collapse; ?></td>
				<td>
				<select name="xls_pricelist_use_collapse">
					<?php if($xls_pricelist_use_collapse){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_use_protection; ?></td>
				<td>
				<select name="xls_pricelist_use_protection" onchange="lavascript:if($(this).val()==1){$('#use_password').fadeIn('slow');}else{$('#use_password').fadeOut('slow');}">
					<?php if($xls_pricelist_use_protection){ ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php }else{ ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				</select>
				<span id="use_password" <?php if(!$xls_pricelist_use_protection) echo'style="display:none;"'; ?>>&nbsp;&nbsp;&nbsp;<?php echo $entry_use_password; ?>&nbsp;<input type="text" name="xls_pricelist_use_password" value="<?php echo $xls_pricelist_use_password; ?>" /></span>
				</td>
			</tr>
			<tr >
				<td colspan=2 align=center><?php echo $entry_colors; ?></td>
			</tr>
			<tr>
				<td><?php echo $entry_thead_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[thead]" value="<?php echo $xls_pricelist_colors['thead']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[thead_bg]" value="<?php echo $xls_pricelist_colors['thead_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_underthead_color; ?></td>
				<td>
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[underthead_bg]" value="<?php echo $xls_pricelist_colors['underthead_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_category0_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category0]" value="<?php echo $xls_pricelist_colors['category0']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category0_bg]" value="<?php echo $xls_pricelist_colors['category0_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_category1_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category1]" value="<?php echo $xls_pricelist_colors['category1']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category1_bg]" value="<?php echo $xls_pricelist_colors['category1_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_category2_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category2]" value="<?php echo $xls_pricelist_colors['category2']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[category2_bg]" value="<?php echo $xls_pricelist_colors['category2_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_image_color; ?></td>
				<td>
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[image_bg]" value="<?php echo $xls_pricelist_colors['image_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_model_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[model]" value="<?php echo $xls_pricelist_colors['model']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[model_bg]" value="<?php echo $xls_pricelist_colors['model_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_name_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[name]" value="<?php echo $xls_pricelist_colors['name']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[name_bg]" value="<?php echo $xls_pricelist_colors['name_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_stock_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[stock]" value="<?php echo $xls_pricelist_colors['stock']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[stock_bg]" value="<?php echo $xls_pricelist_colors['stock_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_price_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[price]" value="<?php echo $xls_pricelist_colors['price']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[price_bg]" value="<?php echo $xls_pricelist_colors['price_bg']; ?>" />
				</td>
			</tr>
			<tr>
				<td><?php echo $entry_special_color; ?></td>
				<td>
					<?php echo $entry_color_text; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[special]" value="<?php echo $xls_pricelist_colors['special']; ?>" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $entry_color_bg; ?>&nbsp;
					<input type="hidden" class="jpicker"  name="xls_pricelist_colors[special_bg]" value="<?php echo $xls_pricelist_colors['special_bg']; ?>" />
				</td>
			</tr>
			</table>
		</div>
        <div id="tab-upload">
            <table class="form">
                <tr>
                    <td colspan="4">Выбор файла прайс-листа</td>
                </tr>
				<tr>
					<td>Загрузка с количеством товара</td>
					<td style="width:200px">
						<input id="xls_priceupload" class="input" type="file" name="xls_priceupload" />
					</td>
					<td style="width:300px"><div style="display:none" class="loading"><img src="view/image/loading.gif" alt="Loading" /> Loading, please wait...</div></td>
					<td style="width:400px"><div style="display:none" class="result"></div></td>
				</tr>
				<tr>
					<td>Загрузка без количества товара</td>
					<td style="width:200px">
						<input id="xls_priceupload2" class="input" type="file" name="xls_priceupload" />
					</td>
					<td style="width:300px"><div style="display:none" class="loading"><img src="view/image/loading.gif" alt="Loading" /> Loading, please wait...</div></td>
					<td style="width:400px"><div style="display:none" class="result"></div></td>
				</tr>
            </table>
        </div>
	</form>
	</div> 
    
  </div>
</div>
<script>
    $(document).ready(function(){
        $('.jpicker').jPicker({
            window:
            {
                expandable: true,
                position:
                {
                    x: 'right', // acceptable values "left", "center", "right", "screenCenter", or relative px value
                    y: 'bottom', // acceptable values "top", "bottom", "center", or relative px value
                }
            },
            images:
            {
                clientPath: 'view/javascript/jquery/jpicker/images/' // Path to image files
            },

        });
    });

	uploadPriceList('xls_priceupload', true);
	uploadPriceList('xls_priceupload2', false);

	function uploadPriceList(id, qty) {
		const $upload = $('#'+id);
		const $loading = $upload.closest('tr').find('.loading');
		const $result = $upload.closest('tr').find('.result');
		let url = '<?php echo HTTP_CATALOG; ?>index.php?route=product/xls_pricelist&action=upload';

		if (qty) {
			url += '&qty=1';
		}

		const priceupload = new AjaxUpload('#'+id, {
			action: url,
			name: 'file',
			autoSubmit: true,
			responseType: 'text',
			onSubmit: function (file, extension) {
				$loading.show();
				$result.hide();
				$upload.attr('disabled', true);
			},
			onComplete: function (file, json) {
				$loading.hide();
				$upload.attr('disabled', false);
				const results = JSON.parse(json);
				let result = '';

				if (Array.isArray(results)) {
					$(results).each(function (i, v) {
						result = result + '<p>' + i + '. ' + v + '</p>';
					});
				} else {
					result = '<p>' + results + '</p>';
				}

				$result.show().html(result);
			}
		});
	}
</script>
<script>
$('input, select').change(function(){
	$('#xls_pricelist').html('<a class="top" style="color:red;" ><?php echo $text_save; ?></a>');
});

$('select[name="xls_pricelist_usecache"]').change(function(){
	if($(this).val()=='memcache')$('div.memcache_params').fadeIn('slow');
	else $('div.memcache_params').fadeOut('slow');							
});

$('select[name="xls_pricelist_use_code"]').change(function(){
	if($(this).val()==1)$('tr.entry_code').show();
	else $('tr.entry_code').hide();							
});

</script>
<script>
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
</script>
<script>
$('#tabs a').tabs(); 
$('#languages a').tabs();
</script>
<?php echo $footer; ?>
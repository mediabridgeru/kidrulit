<?php echo $header; ?>
<div id="content" class="content-contacts">
  <div class="box">
	<?php if (!$license) { ?>
	<div class="error-license"><?php echo $text_error_license; ?></div>
	<?php } ?>
    <div class="content">
	<div id="tabs" class="vtabs">
		<a href="#tab-send" class="vtabs-send"><?php echo $tab_send; ?></a>
		<a href="#tab-template" class="vtabs-template"><?php echo $tab_template; ?></a>
		<a href="#tab-groups" class="vtabs-groups"><?php echo $tab_groups; ?></a>
		<a href="#tab-newsletters" class="vtabs-newsletters"><?php echo $tab_newsletters; ?></a>
		<a href="#tab-checkmails" class="vtabs-checkmails"><?php echo $tab_checkmails; ?></a>
		<a href="#tab-crons" class="vtabs-crons"><?php echo $tab_crons; ?></a>
		<a href="#tab-statistics" class="vtabs-statistics"><?php echo $tab_statistics; ?></a>
		<a href="#tab-log" class="vtabs-log"><?php echo $tab_log; ?></a>
		<a href="#tab-setting" class="vtabs-setting"><?php echo $tab_setting; ?></a>
		<span class="vtabs-separator"></span>
		<a href="#tab-mails" class="vtabs-mails"><?php echo $tab_mails; ?></a>
	</div>
	<div id="tab-send" class="vtabs-content">
	  <div class="buttons buttons-send right">
		<a id="button-cron" onclick="send('index.php?route=sale/contacts/send&add_cron=1&token=<?php echo $token; ?>');" title="<?php echo $button_cron; ?>" class="btn btn-cron"></a>
		<a id="button-check" onclick="send('index.php?route=sale/contacts/send&spam_check=1&token=<?php echo $token; ?>');" title="<?php echo $button_check; ?>" class="btn btn-check"></a>
		<a id="button-send" onclick="send('index.php?route=sale/contacts/send&token=<?php echo $token; ?>');" title="<?php echo $button_send; ?>" class="btn btn-send"></a>
		<a href="<?php echo $cancel; ?>" title="<?php echo $button_cancel; ?>" class="btn btn-cancel"></a>
	  </div>
	  <div class="block-contents">
		<div class="block-content content-attention" id="attention_block" style="display:none;">
		  <?php if ($missing_send) { ?>
		  <?php foreach ($missing_send as $msend) { ?>
			<div class="attention misssend-attention" id="misssend_<?php echo $msend['send_id']; ?>">
				<div class="info-block">
					<div class="malarm"><?php echo $msend['send_alarm']; ?></div>
					<div class="minfo"><?php echo $msend['send_date']; ?><br /><?php echo $msend['send_title']; ?><br /><?php echo $msend['send_to']; ?><br /><?php echo $msend['send_count']; ?></div>
				</div>
				<div class="buttons-block">
					<a class="btn btn-msend" title="<?php echo $button_missresend; ?>" onclick="missresend('index.php?route=sale/contacts/misssend&msid=<?php echo $msend['send_id']; ?>&token=<?php echo $token; ?>')"></a>
					<a class="btn btn-mtocompl" title="<?php echo $button_misstocomplete; ?>" onclick="misstocomplete('<?php echo $msend['send_id']; ?>')"></a>
					<a class="btn btn-mremove" title="<?php echo $button_missremove; ?>" onclick="missremove('<?php echo $msend['send_id']; ?>')"></a>
				</div>
				<div class="close-block">
					<img src="view/image/contacts/close-icon18.png" class="close" title="<?php echo $button_missclose; ?>" />
				</div>
			</div>
		  <?php } ?>
		  <?php } ?>
		  <?php if ($run_crons) { ?>
		  <?php foreach ($run_crons as $run_cron) { ?>
			<div class="attention misssend-attention" id="runcron_<?php echo $run_cron['cron_id']; ?>">
				<div class="info-block">
					<?php echo $run_cron['cron_alarm']; ?><br />
					<?php echo $run_cron['cron_title']; ?>
				</div>
				<div class="close-block">
					<img src="view/image/contacts/close-icon18.png" class="close" title="<?php echo $button_missclose; ?>" />
				</div>
			</div>
		  <?php } ?>
		  <?php } ?>
		</div>
		<div class="block-content content-send" id="send_block">
        <table id="mail" class="form">
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><select name="store_id">
                <option value="0"><?php echo $text_default; ?></option>
                <?php foreach ($stores as $store) { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?></select>
				<div id="attention_toggle" title="<?php echo $text_info_panel; ?>"></div>
				<?php if ($total_mails_hour !== false) { ?>
				<div id="attention_limit"<?php if ($total_mails_alarm) { ?> class="attention-warning"<?php } ?>>
					<div id="limit_hour" title="<?php echo $text_limit_hour; ?>"><?php echo $total_mails_hour; ?></div>
					<div id="limit_day" title="<?php echo $text_limit_day; ?>"><?php echo $total_mails_day; ?></div>
				</div>
				<?php } ?>
			</td>
          </tr>
		  <tbody class="to-yellow">
          <tr>
            <td><?php echo $entry_to; ?></td>
            <td>
				<select name="to">
					<option value="customer_all"><?php echo $text_customer_all; ?></option>
					<option value="customer_select"><?php echo $text_customer_select; ?></option>
					<option value="customer_group"><?php echo $text_customer_group; ?></option>
					<option value="customer_noorder"><?php echo $text_customer_noorder; ?></option>
					<option value="client_all"><?php echo $text_client_all; ?></option>
					<option value="client_select"><?php echo $text_client_select; ?></option>
					<option value="client_group"><?php echo $text_client_group; ?></option>
					<option value="send_group"><?php echo $text_send_group; ?></option>
					<option value="affiliate_all"><?php echo $text_affiliate_all; ?></option>
					<option value="affiliate"><?php echo $text_affiliate; ?></option>
					<option value="product"><?php echo $text_product; ?></option>
					<option value="category"><?php echo $text_category; ?></option>
					<option value="manual"><?php echo $text_manual; ?></option>
				</select>
			</td>
          </tr>
		  </tbody>
          <tbody id="to-customer-group" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_customer_group; ?></td>
              <td>
			    <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="customer_group_id[]" value="<?php echo $customer_group['customer_group_id']; ?>" /><?php echo $customer_group['name']; ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-customer-select" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_customer; ?></td>
              <td><input type="text" name="customers" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
			    <div id="customer" class="scrollbox"></div>
				<div class="select-block invers-block line-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_customer" value="1" />
				</div>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-client-select" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_customer; ?></td>
              <td><input type="text" name="clients" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
			    <div id="client" class="scrollbox"></div>
				<div class="select-block invers-block line-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_client" value="1" />
				</div>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-send-group" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_send_group; ?></td>
              <td>
			    <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($groups as $group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="send_group_id[]" value="<?php echo $group['group_id']; ?>" /><?php echo $group['name']; ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-affiliate" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_affiliate; ?></td>
              <td><input type="text" name="affiliates" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
			    <div id="affiliate" class="scrollbox"></div>
				<div class="select-block invers-block line-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_affiliate" value="1" />
				</div>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-product" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_product; ?></td>
              <td><input type="text" name="products" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
				<div id="product" class="scrollbox"></div>
				<div class="select-block invers-block line-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_product" value="1" />
				</div>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-category" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_category; ?></td>
              <td>
			    <div style="margin-bottom:5px;">
					<div class="scrollbox">
					  <?php $class = 'odd'; ?>
					  <?php foreach ($categories as $category) { ?>
					  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $class; ?>">
						<input type="checkbox" name="category[]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?>
					  </div>
					  <?php } ?>
					</div>
					<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
				</div>
				<div class="select-block invers-block line-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_category" value="1" />
				</div>
			  </td>
			</tr> 
		  </tbody>
		  <tbody id="to-manual" class="to to-yellow" style="display:none;">
            <tr>
              <td><?php echo $entry_manual; ?></td>
              <td><textarea name="manual" class="input-manual"></textarea></td>
            </tr>
          </tbody>
          <tbody id="period-body" class="to-yellow">
		  <tr>
            <td><?php echo $entry_period; ?></td>
			<td>
				<div class="select-block">
					<input class="filter-checkbox" type="checkbox" name="set_period" value="1" />
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_period_start; ?></span><input type="text" name="date_start" value="" class="date" />
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_period_end; ?></span><input type="text" name="date_end" value="" class="date" />
				</div>
			</td>
          </tr>
		  </tbody>
          <tbody id="region-body" class="to-yellow">
		  <tr>
            <td><?php echo $entry_region; ?></td>
			<td>
				<div class="select-block">
					<input class="filter-checkbox" type="checkbox" name="set_region" value="1" />
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_country; ?></span>
					<select name="country_id">
						<option value=""><?php echo $text_select; ?></option>
						<?php foreach ($countries as $country) { ?>
							<?php if ($country['country_id'] == $default_country_id) { ?>
							<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_zone; ?></span><select name="zone_id"></select>
				</div>
				<div class="select-block filter-block invers-block">
					<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_region" value="1" />
				</div>
			</td>
          </tr>
		  </tbody>
          <tbody id="language-body" class="to-yellow" style="display:none;">
		  <tr>
            <td><?php echo $entry_language; ?></td>
			<td>
				<div class="select-block">
					<input class="filter-checkbox" type="checkbox" name="set_language" value="1" />
				</div>
				<div class="select-block filter-block">
					<select name="language_id">
						<option value=""><?php echo $text_select; ?></option>
						<?php foreach ($languages as $language) { ?>
							<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</td>
          </tr>
		  </tbody>
		  <tbody id="limit-body" class="to-yellow">
		  <tr>
            <td><?php echo $entry_limit_emails; ?></td>
			<td>
				<div class="select-block">
					<input class="filter-checkbox" type="checkbox" name="set_limit" value="1" />
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_limit_start; ?></span><input type="text" name="limit_start" value="" class="limit" />
				</div>
				<div class="select-block filter-block">
					<span><?php echo $entry_limit_end; ?></span><input type="text" name="limit_end" value="" class="limit" />
				</div>
			</td>
          </tr>
          </tbody>
          <tr>
            <td><?php echo $entry_static; ?><?php echo $spravka_static; ?></td>
            <td><div class="select-block">
					<select name="static">
						<option value="dinamic"><?php echo $text_dinamic; ?></option>
						<option value="static"><?php echo $text_static; ?></option>
					</select>
				</div>
				<div class="select-block">
					<span class="help help-dinamic"><?php echo $help_dinamic; ?></span><span class="help help-static hidden"><?php echo $help_static; ?></span>
				</div>
			</td>
          </tr>
		  <tr>
			<td><?php echo $entry_unsubscribe; ?></td>
			<td><input type="checkbox" name="set_unsubscribe" value="1" checked="checked" /></td>
		  </tr>
		  <tr>
			<td><?php echo $entry_contrl_unsub; ?></td>
			<td><input type="checkbox" name="control_unsubscribe" value="1" checked="checked" /></td>
		  </tr>
		  <tbody class="to-green">
		  <tr>
			<td><?php echo $entry_insert_products; ?></td>
			<td><input type="checkbox" id="insert_products" name="insert_products" value="1" /></td>
		  </tr>
		  </tbody>
          <tbody id="products-body" class="to-green">
            <tr>
              <td><?php echo $entry_purchased; ?></td>
              <td><input id="entry_purchased" name="purchased" type="checkbox" value="1" class="products-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="purchased_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="purchased_limit" value="" style="width:30px;" /></div>
			  </td>
            </tr>
            <tr>
              <td><?php echo $entry_special; ?></td>
              <td><input id="entry_special" name="special" type="checkbox" value="1" class="products-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="special_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="special_limit" value="" style="width:30px;" /></div>
			  </td>
            </tr>
            <tr>
              <td><?php echo $entry_bestseller; ?></td>
              <td><input id="entry_bestseller" name="bestseller" type="checkbox" value="1" class="products-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="bestseller_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="bestseller_limit" value="" style="width:30px;" /></div>
			  </td>
            </tr>
            <tr>
              <td><?php echo $entry_featured; ?></td>
              <td><input id="entry_featured" name="featured" type="checkbox" value="1" class="products-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="featured_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="featured_limit" value="" style="width:30px;" /></div>
			  </td>
            </tr>
            <tr>
              <td><?php echo $entry_latest; ?></td>
              <td><input id="entry_latest" name="latest" type="checkbox" value="1" class="products-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="latest_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="latest_limit" value="" style="width:30px;" /></div>
			  </td>
            </tr>
            <tr>
              <td><?php echo $entry_selected; ?></td>
              <td><input id="entry_selected" name="selectproducts" type="checkbox" value="1" class="sproducts-checkbox" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="selproducts_title" value="" style="width:350px;" /></div>
			  </td>
            </tr>
            <tr class="showsel">
              <td><?php echo $entry_pselected; ?></td>
              <td><input type="text" name="sproducts" value="" style="width:450px;"/></td>
            </tr>
            <tr class="showsel">
              <td>&nbsp;</td>
              <td><div id="selproduct" class="scrollbox"></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_catselected; ?></td>
              <td><input id="entry_catselected" name="catselectproducts" type="checkbox" value="1" />
				  <div class="products-block"><?php echo $entry_title; ?> <input type="text" name="catproducts_title" value="" style="width:350px;" /></div>
				  <div class="products-block"><?php echo $entry_limit; ?> <input type="text" name="catproducts_limit" value="" style="width:30px;" /></div>
				  <div class="products-block"><?php echo $entry_each; ?> <input type="checkbox" name="catproducts_each" value="1" /></div>
			  </td>
            </tr>
            <tr class="showcatsel">
              <td><?php echo $entry_category; ?></td>
              <td><div id="entry_category" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="catproducts[]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
            </tr> 
			<tr>
				<td><?php echo $entry_planguage; ?></td>
				<td>
					<div class="select-block">
						<input class="filter-checkbox" type="checkbox" name="set_planguage" value="1" />
					</div>
					<div class="select-block filter-block">
						<select name="planguage_id">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($languages as $language) { ?>
								<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</td>
			</tr>
          </tbody>
          <tr>
            <td><?php echo $entry_template; ?></td>
            <td>
				<select name="template_id">
                  <option value="0" selected="selected"><?php echo $text_none; ?></option>
                  <?php foreach ($templates as $template) { ?>
					<option value="<?php echo $template['template_id']; ?>"><?php echo $template['name']; ?></option>
                  <?php } ?>
				</select>
			</td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_subject; ?></td>
            <td><input id="new_temp_subject" type="text" name="subject" value="" style="width:85%;margin-bottom:3px;" />
			<span class="help" style="margin:0;"><?php echo $help_subject; ?></span>
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_message; ?></td>
            <td><textarea id="message1" name="message"></textarea></td>
          </tr>
          <tr>
            <td><?php echo $text_save_template; ?></td>
            <td><input id="new_temp_name" type="text" name="new_temp_name" value="" />&nbsp;
			<a class="btn btn-msave" title="<?php echo $text_save; ?>" onclick="addtemplate();" id="savetempl"></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_attach; ?></td>
            <td>
				<span id="info_files"></span>
				<input type="file" style="display:none;" multiple="multiple" id="input_upload" />
				<a id="button_fclear" title="<?php echo $text_delete; ?>" class="btn btn-mremove"></a>
				<a id="button_select" title="<?php echo $button_upload; ?>" class="btn btn-mupload"></a>
				<div id="warning_upload"></div>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_attach_cat; ?></td>
            <td><input type="text" name="attachments_cat" value="" placeholder="/my_folder/" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_dopurl; ?></td>
            <td><input type="text" name="dopurl" value="" placeholder="utm_source=mailpro&utm_medium=email&utm_campaign={sid}" style="width:85%;margin-bottom:3px;" />
			<span class="help" style="margin:0;"><?php echo $help_dopurl; ?></span>
			</td>
          </tr>
          <tr>
            <td><?php echo $text_tegi; ?></td>
            <td class="spravka_tegi"><div class="help"><?php echo $spravka_tegi; ?></div></td>
          </tr>
        </table>
		</div>
	  </div>
	</div>

	<div id="tab-template" class="vtabs-content">
	  <div class="buttons buttons-add right">
		<a onclick="updatetemplates();" class="btn btn-update" title="<?php echo $button_update; ?>"></a>
		<a onclick="newtemplate();" class="btn btn-addnew" title="<?php echo $text_new_template; ?>"></a>
	  </div>
	  <div class="block-content content-templates" id="templates"></div>
	  
	  <div class="block-content content-template" id="content_template">
		<table id="template" class="list">
          <tr>
			<td class="left" style="width:200px;"><span class="required">*</span> <?php echo $entry_template_name; ?></td>
			<td class="left"><input type="text" id="temp_name" name="temp_name" value="" /></td>
		  </tr>
          <tr>
			<td class="left" style="width:200px;"><?php echo $entry_subject; ?></td>
			<td class="left"><input type="text" id="temp_subject" name="temp_subject" value="" style="width:85%;" /></td>
		  </tr>
          <tr>
			<td class="left" style="width:200px;"><span class="required">*</span> <?php echo $entry_message; ?></td>
			<td class="left"><textarea id="message2" name="temp_message"></textarea></td>
		  </tr>
          <tr>
		    <td class="left" style="width:200px;"><?php echo $text_save; ?></td>
			<td class="left"><a title="<?php echo $text_save; ?>" class="btn btn-msave" id="save_template"></a></td>
		  </tr>
		</table>
	  </div>
	</div>

	<div id="tab-groups" class="vtabs-content">
	  <div class="buttons buttons-groups right">
		<a onclick="updategroup();" class="btn btn-update" title="<?php echo $button_update; ?>"></a>
		<a onclick="newgroup();" class="btn btn-addnew" title="<?php echo $text_new_group; ?>"></a>
	  </div>
		<div class="block-content content-groups" id="groups"></div>
	
		<div class="block-content content-group" id="content_group">
			<table id="group" class="list">
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_group_name; ?></td>
				<td class="left"><input type="text" id="group_name" name="group_name" value="" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_group_description; ?></td>
				<td class="left"><input type="text" id="group_description" name="group_description" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $text_save; ?></td>
				<td class="left"><a id="save_group" title="<?php echo $text_save; ?>" class="btn btn-msave"></a></td>
			  </tr>
			</table>
		</div>
	</div>
	
	<div id="tab-newsletters" class="vtabs-content">
		<div class="buttons buttons-newsletters right">
			<div id="movenews"><?php echo $entry_move_ingroup; ?>
				<select id="move_for_group">
				  <?php foreach ($groups as $group) { ?>
					<option value="<?php echo $group['group_id']; ?>"><?php echo $group['name']; ?></option>
				  <?php } ?>
				</select>
				<a onclick="movenewsletters();" class="btn btn-msuccess" title="<?php echo $text_run; ?>"><?php echo $text_run; ?></a>
			</div>
			<a id="move_newsletters" class="btn btn-movenews" title="<?php echo $text_move_newsletters; ?>"></a>
			<a onclick="addnewsletters();" class="btn btn-addnews" title="<?php echo $text_new_newsletters; ?>"></a>
			<a onclick="updatenewsletters();" class="btn btn-update" title="<?php echo $button_update; ?>"></a>
			<a onclick="delnewsletters();" class="btn btn-remove" title="<?php echo $text_delete; ?>"></a>
		</div>
		<div class="block-content content-newsletters" id="newsletters"></div>
		
		<div class="block-content content-newsletter" id="content_newsletter">
			<table id="newsletter" class="list">
			  <tr>
			    <td class="left" style="width:200px;"><?php echo $entry_for_group; ?></td>
			    <td><select name="filter_for_group">
				  <?php foreach ($groups as $group) { ?>
					<option value="<?php echo $group['group_id']; ?>"><?php echo $group['name']; ?></option>
				  <?php } ?>
				  </select>
				</td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_from_newsletter; ?></td>
				<td><select name="from">
					<option value="customer_all"><?php echo $text_fcustomer_all; ?></option>
					<option value="customer_select"><?php echo $text_fcustomer_select; ?></option>
					<option value="customer_group"><?php echo $text_fcustomer_group; ?></option>
					<option value="customer_noorder"><?php echo $text_fcustomer_noorder; ?></option>
					<option value="client_all"><?php echo $text_fclient_all; ?></option>
					<option value="client_select"><?php echo $text_fclient_select; ?></option>
					<option value="client_group"><?php echo $text_fclient_group; ?></option>
					<option value="send_group"><?php echo $text_fsend_group; ?></option>
					<option value="affiliate_all"><?php echo $text_faffiliate_all; ?></option>
					<option value="affiliate"><?php echo $text_faffiliate; ?></option>
					<option value="product"><?php echo $text_fproduct; ?></option>
					<option value="category"><?php echo $text_fcategory; ?></option>
					<option value="manual"><?php echo $text_fmanual; ?></option>
					<option value="sql_manual"><?php echo $text_sql_manual; ?></option>
					</select>
				</td>
			  </tr>
			  <tbody id="from-customer-group" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_customer_group; ?></td>
				  <td>
					<div class="scrollbox">
					  <?php $class = 'odd'; ?>
					  <?php foreach ($customer_groups as $customer_group) { ?>
					  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $class; ?>">
						<input type="checkbox" name="from_customer_group_id[]" value="<?php echo $customer_group['customer_group_id']; ?>" /><?php echo $customer_group['name']; ?>
					  </div>
					  <?php } ?>
					</div>
					<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-customer-select" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_customer; ?></td>
				  <td><input type="text" name="from_customers" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_customers" class="scrollbox"></div>
					<div class="select-block invers-block line-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_customer" value="1" />
					</div>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-client-select" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_customer; ?></td>
				  <td><input type="text" name="from_clients" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_clients" class="scrollbox"></div>
					<div class="select-block invers-block line-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_client" value="1" />
					</div>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-send-group" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_send_group; ?></td>
				  <td>
					<div class="scrollbox">
					  <?php $class = 'odd'; ?>
					  <?php foreach ($groups as $group) { ?>
					  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $class; ?>">
						<input type="checkbox" name="send_group_id[]" value="<?php echo $group['group_id']; ?>" /><?php echo $group['name']; ?>
					  </div>
					  <?php } ?>
					</div>
					<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-affiliate" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_affiliate; ?></td>
				  <td><input type="text" name="from_affiliates" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_affiliates" class="scrollbox"></div>
					<div class="select-block invers-block line-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_affiliate" value="1" />
					</div>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-product" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_product; ?></td>
				  <td><input type="text" name="from_products" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_products" class="scrollbox"></div>
					<div class="select-block invers-block line-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_product" value="1" />
					</div>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-category" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_category; ?></td>
				  <td>
				    <div style="margin-bottom:5px;">
						<div class="scrollbox">
						  <?php $class = 'odd'; ?>
						  <?php foreach ($categories as $category) { ?>
						  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						  <div class="<?php echo $class; ?>">
							<input type="checkbox" name="from_category[]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?>
						  </div>
						  <?php } ?>
						</div>
						<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
					</div>
					<div class="select-block invers-block line-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_category" value="1" />
					</div>
				  </td>
				</tr> 
			  </tbody>
			  <tbody id="from-manual" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_manual; ?></td>
				  <td><textarea name="from_manual" class="input-manual"></textarea></td>
				</tr>
			  </tbody>
			  <tbody id="from-sql-manual" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_sql_table; ?></td>
				  <td><input type="text" name="from_sql_table" value="" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_sql_email; ?></td>
				  <td><input type="text" name="from_sql_email" value="" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_sql_firstname; ?></td>
				  <td><input type="text" name="from_sql_firstname" value="" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_sql_lastname; ?></td>
				  <td><input type="text" name="from_sql_lastname" value="" /></td>
				</tr>
			  </tbody>
			  <tbody id="from-period-body">
			  <tr>
				<td><?php echo $entry_period; ?></td>
				<td>
					<div class="select-block">
						<input class="filter-checkbox" type="checkbox" name="set_period" value="1" />
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_period_start; ?></span><input type="text" name="date_start" value="" class="date" />
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_period_end; ?></span><input type="text" name="date_end" value="" class="date" />
					</div>
				</td>
			  </tr>
			  </tbody>
			  <tbody id="from-region-body">
			  <tr>
				<td><?php echo $entry_region; ?></td>
				<td>
					<div class="select-block">
						<input class="filter-checkbox" type="checkbox" name="from_set_region" value="1" />
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_country; ?></span>
						<select name="from_country_id">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($countries as $country) { ?>
								<?php if ($country['country_id'] == $default_country_id) { ?>
								<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_zone; ?></span><select name="from_zone_id"></select>
					</div>
					<div class="select-block filter-block invers-block">
						<span><?php echo $entry_inversion; ?></span><input type="checkbox" name="invers_region" value="1" />
					</div>
				</td>
			  </tr>
			  </tbody>
			  <tbody id="from-language-body" style="display:none;">
			  <tr>
				<td><?php echo $entry_language; ?></td>
				<td>
					<div class="select-block">
						<input class="filter-checkbox" type="checkbox" name="from_set_language" value="1" />
					</div>
					<div class="select-block filter-block">
						<select name="from_language_id">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($languages as $language) { ?>
								<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</td>
			  </tr>
			  </tbody>
			  <tbody id="from-limit-body">
			  <tr>
				<td><?php echo $entry_limit_emails; ?></td>
				<td>
					<div class="select-block">
						<input class="filter-checkbox" type="checkbox" name="set_limit" value="1" />
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_limit_start; ?></span><input type="text" name="limit_start" value="" class="limit" />
					</div>
					<div class="select-block filter-block">
						<span><?php echo $entry_limit_end; ?></span><input type="text" name="limit_end" value="" class="limit" />
					</div>
				</td>
			  </tr>
			  </tbody>
			  <tbody id="from-store-body">
			  <tr>
				<td><?php echo $entry_store; ?></td>
				<td><select name="store_id">
					<option value="0"><?php echo $text_default; ?></option>
					<?php foreach ($stores as $store) { ?>
					<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
					<?php } ?></select>
				</td>
			  </tr>
			  </tbody>
			  <tr>
				<td><?php echo $entry_contrl_unsub; ?></td>
				<td><input type="checkbox" name="control_unsubscribe" value="1" checked="checked" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $text_save; ?></td>
				<td class="left"><a id="save_newsletters" title="<?php echo $text_start_import; ?>" class="btn btn-msave"></a></td>
			  </tr>
			</table>
		</div>
	</div>

	<div id="tab-checkmails" class="vtabs-content">
	  <div class="buttons buttons-checkmails right">
	    <a onclick="updatecheckcron();" title="<?php echo $button_update; ?>" class="btn btn-update"></a>
		<a id="button-checkmail" onclick="checkemail();" title="<?php echo $button_cron; ?>" class="btn btn-cron"></a>
	  </div>
	  <div class="block-contents">
	  <div class="block-content content-attention" id="attention_check" style="display:none;"></div>
	  <div class="block-content content-checkmails" id="checkmail_block">
		<div class="block-box">
			<div class="pull-left">
				<table id="checkmail" class="form">
				  <tbody class="to-yellow">
				  <tr>
					<td><?php echo $entry_store; ?></td>
					<td><select name="store_id">
						<option value="0"><?php echo $text_default; ?></option>
						<?php foreach ($stores as $store) { ?>
						<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
						<?php } ?></select>
					</td>
				  </tr>
				  </tbody>
				  <tbody class="to-yellow">
				  <tr>
					<td><?php echo $entry_to_check; ?></td>
					<td><select name="to_check">
						<option value="customer_all"><?php echo $text_fcustomer_all; ?></option>
						<option value="client_all"><?php echo $text_fclient_all; ?></option>
						<option value="customer_group"><?php echo $text_fcustomer_group; ?></option>
						<option value="client_group"><?php echo $text_fclient_group; ?></option>
						<option value="send_group"><?php echo $text_fsend_group; ?></option>
						<option value="affiliate_all"><?php echo $text_faffiliate_all; ?></option>
						<option value="manual"><?php echo $text_manual; ?></option>
						</select>
					</td>
				  </tr>
				  </tbody>
				  <tbody id="to_check_customer_group" class="to to-yellow" style="display:none;">
					<tr>
					  <td><?php echo $entry_customer_group; ?></td>
					  <td>
						<div class="scrollbox">
						  <?php $class = 'odd'; ?>
						  <?php foreach ($customer_groups as $customer_group) { ?>
						  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						  <div class="<?php echo $class; ?>">
							<input type="checkbox" name="customer_group_id[]" value="<?php echo $customer_group['customer_group_id']; ?>" /><?php echo $customer_group['name']; ?>
						  </div>
						  <?php } ?>
						</div>
						<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
					  </td>
					</tr>
				  </tbody>
				  <tbody id="to_check_send_group" class="to to-yellow" style="display:none;">
					<tr>
					  <td><?php echo $entry_send_group; ?></td>
					  <td>
						<div class="scrollbox">
						  <?php $class = 'odd'; ?>
						  <?php foreach ($groups as $group) { ?>
						  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						  <div class="<?php echo $class; ?>">
							<input type="checkbox" name="send_group_id[]" value="<?php echo $group['group_id']; ?>" /><?php echo $group['name']; ?>
						  </div>
						  <?php } ?>
						</div>
						<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> <span>/</span> <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
					  </td>
					</tr>
				  </tbody>
				  <tbody id="to_check_manual" class="to to-yellow" style="display:none;">
					<tr>
					  <td><?php echo $entry_manual; ?></td>
					  <td><textarea name="manual" class="input-manual"></textarea></td>
					</tr>
				  </tbody>
				  <tr>
					<td><?php echo $entry_static; ?></td>
					<td><div class="select-block">
							<select name="static">
								<option value="dinamic"><?php echo $text_dinamic; ?></option>
								<option value="static"><?php echo $text_static; ?></option>
							</select>
						</div>
						<div class="select-block">
							<span class="help help-dinamic help-icon" title="<?php echo $help_dinamic; ?>"><?php echo $help_icon; ?></span><span class="help help-static help-icon hidden" title="<?php echo $help_static; ?>"><?php echo $help_icon; ?></span>
						</div>
					</td>
				  </tr>
				  <tr>
					<td><?php echo $entry_checke_unsub; ?></td>
					<td><input type="checkbox" name="control_unsubscribe" value="1" checked="checked" /></td>
				  </tr>
				  <tr>
					<td><?php echo $entry_emnovalid_action; ?></td>
					<td><div class="select-block">
							<select name="emnovalid_action">
								<option value="0"><?php echo $text_nothing; ?></option>
								<option value="1"><?php echo $text_unsubs; ?></option>
								<option value="2"><?php echo $text_unsub_remove; ?></option>
							</select>
						</div>
						<div class="select-block">
							<span class="help help-icon" title="<?php echo $help_emnovalid; ?>"><?php echo $help_icon; ?></span>
						</div>
					</td>
				  </tr>
				  <tr>
					<td><?php echo $entry_embad_action; ?></td>
					<td><div class="select-block">
							<select name="embad_action">
								<option value="0"><?php echo $text_nothing; ?></option>
								<option value="1"><?php echo $text_unsubs; ?></option>
								<option value="2"><?php echo $text_unsub_remove; ?></option>
							</select>
						</div>
						<div class="select-block">
							<span class="help help-icon" title="<?php echo $help_embad; ?>"><?php echo $help_icon; ?></span>
						</div>
					</td>
				  </tr>
				  <tr>
					<td><?php echo $entry_emsuspect_action; ?></td>
					<td><div class="select-block">
							<select name="emsuspect_action">
								<option value="0"><?php echo $text_nothing; ?></option>
								<option value="1"><?php echo $text_unsubs; ?></option>
								<option value="2"><?php echo $text_unsub_remove; ?></option>
							</select>
						</div>
						<div class="select-block">
							<span class="help help-icon" title="<?php echo $help_emsuspect; ?>"><?php echo $help_icon; ?></span>
						</div>
					</td>
				  </tr>
				  <tr>
					<td colspan="2"><span class="help">**<?php echo $help_emremove; ?></span></td>
				  </tr>
				</table>
			</div>
			<div class="pull-right">
				<table id="resultmail" class="form">
				  <tr>
					<td>
					<div class="resultmail-box">
						<div class="top-box"><?php echo $text_check_info; ?></div>
						<div class="info-box"></div>
					</div>
					</td>
				  </tr>
				</table>
			</div>
		</div>
	  </div>
	  <div class="block-content content-checkmail" id="logs_check"></div>
	  </div>
	</div>
	
	<div id="tab-crons" class="vtabs-content">
		<div class="buttons buttons-crons right">
			<a onclick="updatecron();" title="<?php echo $button_update; ?>" class="btn btn-update"></a>
		</div>
		<div class="block-content content-crons" id="crons"></div>
	
		<div class="block-content content-cron" id="content_cron">
			<table id="cron" class="list">
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_cron_name; ?></td>
				<td class="left"><input type="text" id="cron_name" name="cron_name" value="" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_cron_start; ?></td>
				<td class="left"><input type="text" id="cron_date_start" name="cron_date_start" class="datetime" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_cron_period; ?></td>
				<td class="left"><input type="text" id="cron_period" name="cron_period" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $entry_status; ?></td>
				<td class="left"><input type="checkbox" id="cron_status" name="cron_status" value="1" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><?php echo $text_save; ?></td>
				<td class="left"><a id="save_cron" title="<?php echo $text_save; ?>" class="btn btn-msave"></a></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><span class="required">*</span> <?php echo $entry_subject; ?></td>
				<td class="left"><input type="text" id="cron_subject" name="cron_subject" value="" style="width:85%;" /></td>
			  </tr>
			  <tr>
				<td class="left" style="width:200px;"><span class="required">*</span> <?php echo $entry_message; ?></td>
				<td class="left"><textarea id="cron_message" name="cron_message"></textarea></td>
			  </tr>
			</table>
		</div>
		<div class="block-content content-cron" id="logs_cron"></div>
	</div>

	<div id="tab-statistics" class="vtabs-content">
		<div class="buttons buttons-statistics right">
			<a onclick="updatestat();" title="<?php echo $button_update; ?>" class="btn btn-update"></a>
		</div>
		<div class="block-content content-statistics" id="statistics"></div>
	</div>
	
	<div id="tab-log" class="vtabs-content">
		<div class="buttons buttons-log right">
			<div class="status-log" style="display:inline-block;"></div>
			<a onclick="updatelog();" title="<?php echo $button_update; ?>" class="btn btn-update"></a>
			<a onclick="clearlog();" title="<?php echo $button_clear; ?>" class="btn btn-remove"></a>
		</div>
		<div class="block-content content-log">
			<textarea wrap="off" id="logarea"><?php echo $log; ?></textarea>
		</div>
	</div>

	<div id="tab-setting" class="vtabs-content">
		<div class="buttons buttons-setting right">
			<a id="button-savesetting" title="<?php echo $button_save; ?>" class="btn btn-save"></a>
		</div>
		<div class="block-content content-setting" id="contacts-setting">
		  <div id="tabs-setting" class="htabs">
		    <a href="#tab-ssmtp" class="htabs-ssmtp"><?php echo $tab_ssmtp; ?></a>
			<a href="#tab-sprod" class="htabs-sprod"><?php echo $tab_sprod; ?></a>
			<a href="#tab-scheck" class="htabs-scheck"><?php echo $tab_scheck; ?></a>
			<a href="#tab-spop" class="htabs-spop"><?php echo $tab_spop; ?></a>
			<a href="#tab-sdata" class="htabs-sdata"><?php echo $tab_sdata; ?></a>
		  </div>
		  <div id="tab-ssmtp">
			<table class="form">
				<tr>
				  <td><?php echo $entry_mail_real_limit; ?></td>
				  <td>
					<input type="text" name="contacts_count_message" value="<?php echo $contacts_count_message; ?>" class="half" />
					<input type="text" name="contacts_sleep_time" value="<?php echo $contacts_sleep_time; ?>" class="half" />
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_global_limit; ?></td>
				  <td>
					<input type="text" name="contacts_global_limith" value="<?php echo $contacts_global_limith; ?>" class="half" />
					<input type="text" name="contacts_global_limitd" value="<?php echo $contacts_global_limitd; ?>" class="half" />
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_cron_limit; ?></td>
				  <td>
					<input type="text" name="contacts_cron_limit" value="<?php echo $contacts_cron_limit; ?>" style="background: #f1f1f1;" class="half" readonly />
					<input type="text" name="contacts_cron_step" value="<?php echo $contacts_cron_step; ?>" style="background: #f1f1f1;" class="half" readonly /><div class="help"><?php echo $help_cron_limit; ?></div>
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_count_error; ?></td>
				  <td><input type="text" name="contacts_count_send_error" value="<?php echo $contacts_count_send_error; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_from; ?></td>
				  <td><input type="text" name="contacts_mail_from" value="<?php echo $contacts_mail_from; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_fromname; ?></td>
				  <td><textarea name="contacts_mail_fromname" class="input-manual" style="min-height:40px;"><?php echo $contacts_mail_fromname; ?></textarea></td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_protocol; ?></td>
				  <td><select name="contacts_mail_protocol">
					  <?php if ($contacts_mail_protocol == 'mail') { ?>
					  <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
					  <?php } else { ?>
					  <option value="mail"><?php echo $text_mail; ?></option>
					  <?php } ?>
					  <?php if ($contacts_mail_protocol == 'smtp') { ?>
					  <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
					  <?php } else { ?>
					  <option value="smtp"><?php echo $text_smtp; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_mail_parameter; ?></td>
				  <td><input type="text" name="contacts_mail_parameter" value="<?php echo $contacts_mail_parameter; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_smtp_host; ?></td>
				  <td><input type="text" name="contacts_smtp_host" value="<?php echo $contacts_smtp_host; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_smtp_username; ?></td>
				  <td><input type="text" name="contacts_smtp_username" value="<?php echo $contacts_smtp_username; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_smtp_password; ?></td>
				  <td><input type="text" name="contacts_smtp_password" value="<?php echo $contacts_smtp_password; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_smtp_port; ?></td>
				  <td><input type="text" name="contacts_smtp_port" value="<?php echo $contacts_smtp_port; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_smtp_timeout; ?></td>
				  <td><input type="text" name="contacts_smtp_timeout" value="<?php echo $contacts_smtp_timeout; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_add_listid; ?></td>
				  <td>
				  <?php if ($contacts_add_listid) { ?>
					<input type="checkbox" name="contacts_add_listid" value="1" checked="checked" />
				  <?php } else { ?>
					<input type="checkbox" name="contacts_add_listid" value="1" />
				  <?php } ?>
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_add_precedence; ?></td>
				  <td><select name="contacts_add_precedence">
					  <option value=""><?php echo $text_none; ?></option>
					  <?php foreach($precedences as $precedence) { ?>
					  <?php if ($precedence == $contacts_add_precedence) { ?>
					  <option value="<?php echo $precedence; ?>" selected="selected"><?php echo $precedence; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $precedence; ?>"><?php echo $precedence; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select></td>
				</tr>
				<tr class="retpath-email">
				  <td><?php echo $entry_retpath_email; ?></td>
				  <td><input type="text" name="contacts_retpath_email" value="<?php echo $contacts_retpath_email; ?>" /><span class="help"><?php echo $help_retpath; ?></span></td>
				</tr>
				<tr>
				  <td><?php echo $entry_bad_eaction; ?></td>
				  <td><select name="contacts_bad_eaction">
					  <?php foreach($bad_eactions as $key => $bad_eaction) { ?>
					  <?php if ($key == $contacts_bad_eaction) { ?>
					  <option value="<?php echo $key; ?>" selected="selected"><?php echo $bad_eaction; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $key; ?>"><?php echo $bad_eaction; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select><span class="help"><?php echo $help_bad_eaction; ?></span></td>
				</tr>
				<tr>
				  <td><?php echo $entry_client_status; ?></td>
				  <td><select name="contacts_client_status">
					  <?php if ($contacts_client_status) { ?>
					  <option value="1" selected="selected"><?php echo $text_all_status; ?></option>
					  <option value="0"><?php echo $text_complete_status; ?></option>
					  <?php } else { ?>
					  <option value="0" selected="selected"><?php echo $text_complete_status; ?></option>
					  <option value="1"><?php echo $text_all_status; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
			  </table>
		  </div>

		  <div id="tab-sprod">
			<table class="form">
			  <tbody class="to-green">
				<tr>
				  <td><?php echo $entry_image_product; ?></td>
				  <td>
				  <input type="text" name="contacts_pimage_width" value="<?php echo $contacts_pimage_width; ?>" class="half" />
				  <input type="text" name="contacts_pimage_height" value="<?php echo $contacts_pimage_height; ?>" class="half" />
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_product_currency; ?></td>
				  <td><select name="contacts_product_currency">
					  <?php foreach ($currencies as $currency) { ?>
					  <?php if ($currency['code'] == $contacts_product_currency) { ?>
					  <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_skip_price0; ?></td>
				  <td>
				  <?php if ($contacts_skip_price0) { ?>
					<input type="checkbox" name="contacts_skip_price0" value="1" checked="checked" />
				  <?php } else { ?>
					<input type="checkbox" name="contacts_skip_price0" value="1" />
				  <?php } ?>
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_skip_qty0; ?></td>
				  <td>
				  <?php if ($contacts_skip_qty0) { ?>
					<input type="checkbox" name="contacts_skip_qty0" value="1" checked="checked" />
				  <?php } else { ?>
					<input type="checkbox" name="contacts_skip_qty0" value="1" />
				  <?php } ?>
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_sort_purchased; ?></td>
				  <td><select name="contacts_sort_purchased_first">
					  <?php if ($contacts_sort_purchased_first == 'ASC') { ?>
					  <option value="ASC" selected="selected"><?php echo text_time_asc; ?></option>
					  <option value="DESC"><?php echo $text_time_desc; ?></option>
					  <?php } else { ?>
					  <option value="ASC"><?php echo $text_time_asc; ?></option>
					  <option value="DESC" selected="selected"><?php echo $text_time_desc; ?></option>
					  <?php } ?>
					</select> / <select name="contacts_sort_purchased_last">
					  <?php if ($contacts_sort_purchased_last == 'ASC') { ?>
					  <option value="ASC" selected="selected"><?php echo $text_price_asc; ?></option>
					  <option value="DESC"><?php echo $text_price_desc; ?></option>
					  <?php } else { ?>
					  <option value="ASC"><?php echo $text_price_asc; ?></option>
					  <option value="DESC" selected="selected"><?php echo $text_price_desc; ?></option>
					  <?php } ?>
					</select>
					</td>
				</tr>
			  </tbody>
			</table>
		  </div>
		  
		  <div id="tab-scheck">
			<table class="form">
			  <tbody class="to-red">
				<tr>
				  <td><?php echo $entry_email_pattern; ?></td>
				  <td>
					<input type="text" name="contacts_email_pattern" value="<?php echo $contacts_email_pattern; ?>" /><a onclick="setmask();" title="<?php echo $entry_recomen_mask; ?>" class="btn btn-msubscr"></a><span style="display:inline-block;vertical-align:middle;padding:0 10px;color:#c54343;"><?php echo $alarm_email_pattern; ?></span>
					<input type="hidden" id="recomend_mask" value="<?php echo $contacts_recomen_mask; ?>" />
				  </td>
				</tr>
				<tr>
				  <td><?php echo $entry_check_mode; ?></td>
				  <td><select name="contacts_check_mode">
					  <?php if ($contacts_check_mode == '2') { ?>
					  <option value="2" selected="selected"><?php echo $text_check_mode2; ?></option>
					  <option value="1"><?php echo $text_check_mode1; ?></option>
					  <?php } else { ?>
					  <option value="1" selected="selected"><?php echo $text_check_mode1; ?></option>
					  <option value="2"><?php echo $text_check_mode2; ?></option>
					  <?php } ?>
					</select><a onclick="checkmode2();" id="button_checkmode" title="<?php echo $button_check_mode2; ?>" class="btn btn-msubscr"></a></td>
				</tr>
				<tr>
				  <td><?php echo $entry_reply_badem; ?></td>
				  <td><textarea name="contacts_reply_badem" class="input-manual" style="min-height:60px;"><?php echo $contacts_reply_badem; ?></textarea></td>
				</tr>
				<tr>
				  <td><?php echo $entry_ignore_servers; ?></td>
				  <td><textarea name="contacts_ignore_servers" class="input-manual" style="min-height:40px;"><?php echo $contacts_ignore_servers; ?></textarea></td>
				</tr>
				<tr>
				  <td><?php echo $entry_debag_checklog; ?></td>
				  <td>
				  <?php if ($contacts_debag_checklog) { ?>
					<input type="checkbox" name="contacts_debag_checklog" value="1" checked="checked" />
				  <?php } else { ?>
					<input type="checkbox" name="contacts_debag_checklog" value="1" />
				  <?php } ?>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="mode_checklog">
				<tr>
				  <td colspan="2"></td>
				</tr>
			  </tbody>
			</table>
		  </div>
		  
		  <div id="tab-spop">
			<table class="form">
			  <tbody class="">
				<tr>
				  <td><?php echo $entry_pop_hostname; ?></td>
				  <td><input type="text" name="contacts_pop_hostname" value="<?php echo $contacts_pop_hostname; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pop_username; ?></td>
				  <td><input type="text" name="contacts_pop_username" value="<?php echo $contacts_pop_username; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pop_password; ?></td>
				  <td><input type="text" name="contacts_pop_password" value="<?php echo $contacts_pop_password; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pop_port; ?></td>
				  <td><input type="text" name="contacts_pop_port" value="<?php echo $contacts_pop_port; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pop_timeout; ?></td>
				  <td><input type="text" name="contacts_pop_timeout" value="<?php echo $contacts_pop_timeout; ?>" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pop_qty; ?></td>
				  <td><input type="text" name="contacts_pop_qty" value="<?php echo $contacts_pop_qty; ?>" /></td>
				</tr>
			  </tbody>
			</table>
		  </div>
		  
		  <div id="tab-sdata">
			<table class="form">
			<tr>
			  <td><?php echo $entry_admin_limit; ?></td>
			  <td><input type="text" name="contacts_admin_limit" value="<?php echo $contacts_admin_limit; ?>" /></td>
			</tr>
			<tr>
			  <td><?php echo $entry_spamtest_url; ?></td>
			  <td><select name="contacts_spamtest_url">
				  <?php if ($contacts_spamtest_url == 'www.mail-tester.com') { ?>
				  <option value="www.mail-tester.com" selected="selected">www.mail-tester.com</option>
				  <option value="www.isnotspam.com">www.isnotspam.com</option>
				  <?php } else { ?>
				  <option value="www.isnotspam.com" selected="selected">www.isnotspam.com</option>
				  <option value="www.mail-tester.com">www.mail-tester.com</option>
				  <?php } ?>
				</select></td>
			</tr>
			<tr>
			  <td><?php echo $entry_allow_sendcron; ?></td>
			  <td>
			  <?php if ($contacts_allow_sendcron) { ?>
				<input type="checkbox" name="contacts_allow_sendcron" value="1" checked="checked" />
			  <?php } else { ?>
				<input type="checkbox" name="contacts_allow_sendcron" value="1" />
			  <?php } ?>
			  </td>
			</tr>
			<tr>
			  <td><?php echo $entry_allow_cronsend; ?></td>
			  <td>
			  <?php if ($contacts_allow_cronsend) { ?>
				<input type="checkbox" name="contacts_allow_cronsend" value="1" checked="checked" />
			  <?php } else { ?>
				<input type="checkbox" name="contacts_allow_cronsend" value="1" />
			  <?php } ?>
			  </td>
			</tr>
			<tr>
			  <td><?php echo $entry_cron_url; ?></td>
			  <td><span><?php echo $cron_url; ?></span></td>
			</tr>
			<tr>
			  <td colspan="2"><span class="help"><?php echo $help_cron_url; ?></span></td>
			</tr>
			</table>
		  </div>
		</div>
	</div>

	<div id="tab-mails" class="vtabs-content">
		<div class="buttons buttons-mails right">
			<a onclick="updatemails();" title="<?php echo $button_update; ?>" class="btn btn-update"></a>
			<a onclick="removemails();" title="<?php echo $button_clear; ?>" class="btn btn-remove"></a>
		</div>
		<div class="block-content content-mails" id="mails"><div class="mails-error"><?php echo $text_pop_info; ?></div></div>
	</div>
	
	</div>
	<div class="version"><?php echo $text_version; ?></div>
  </div>
</div>
<script id="newsletterTemplate" type="text/x-jquery-tmpl">
<tr id="newsletter_${newsletter_id}">
	<td class="center"><input type="checkbox" name="nselected[]" value="${newsletter_id}" /></td>
	<td class="left">${email}</td>
	<td class="left">${group}</td>
	<td class="left">${name}</td>
	<td class="left">${customer_group}</td>
	<td class="center">{{if subscriber}}<div class="subscriber"></div>{{else}}<div class="unsubscriber"></div>{{/if}}</td>
	<td class="right action">{{each action}}<a onclick="${onclk}" class="${clss}" title="${text}"></a>{{/each}}</td>
</tr>
</script>
<script type="text/javascript" src="view/javascript/jquery/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
var wkdir = 'index.php?route=sale/contacts/';
var wkdirp = 'index.php?route=sale/contactp/';
var wkwait = '<span class="wait"><img src="view/image/contacts/loading.svg" alt="" />&nbsp;</span>';
var wkwait2 = '<span class="wait"><img src="view/image/contacts/wait.svg" alt="" />&nbsp;</span>';
var tokken = '&token=<?php echo $token; ?>';

$('#newsletters').load(wkdir + 'newsletters' + tokken);

function updatenewsletters() {
	$('#newsletters table.list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#newsletters').empty().load(wkdir + 'newsletters' + tokken);
	}, 600);
}

function nfilter() {
	furl = wkdir + 'filter_newsletters' + tokken;

	furl += '&page=' + $('#npage').val();

	if ($('#nsort').val()) {
		furl += '&sort=' + $('#nsort').val();
	}
	if ($('#norder').val()) {
		furl += '&order=' + $('#norder').val();
	}
	
	var filter_name = $('#newsletters input[name=\'filter_name\']').attr('value');
	if (filter_name) {
		furl += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('#newsletters input[name=\'filter_email\']').attr('value');
	if (filter_email) {
		furl += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_group_id = $('#newsletters select[name=\'filter_group_id\']').attr('value');
	if (filter_group_id != '*') {
		furl += '&filter_group_id=' + encodeURIComponent(filter_group_id);
	}

	var filter_customer_group_id = $('#newsletters select[name=\'filter_customer_group_id\']').attr('value');
	if (filter_customer_group_id != '*') {
		furl += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}
	
	var filter_unsubscribe = $('#newsletters select[name=\'filter_unsubscribe\']').attr('value');
	if (filter_unsubscribe != '*') {
		furl += '&filter_unsubscribe=' + encodeURIComponent(filter_unsubscribe);
	}

	$.ajax({
		url: furl,
		dataType: 'json',
		success : function(json) {
			$('#newsletters table.list tr:gt(1)').remove();
			$("#newsletterTemplate").tmpl(json.newsletters).appendTo("#newsletters table.list");
			$('#newsletters .pagination').html(json.pagination);
		}
	});
	
	$('#ncheck').attr('checked', false);
}

function clear_nfilter() {
	$('#newsletters tr.filter select option:selected').prop('selected', false);
	$('#newsletters tr.filter input').val('');
	nfilter();
	return false;
}

function gsUV(e, t, v) {
    var n = String(e).split("?");
    var r = "";
    if (n[1]) {
        var i = n[1].split("&");
        for (var s = 0; s <= i.length; s++) {
            if (i[s]) {
                var o = i[s].split("=");
                if (o[0] && o[0] == t) {
                    r = o[1];
                    if (v != undefined) {
                        i[s] = o[0] +'=' + v;
                    }
                    break;
                }
            }
        }
    }
    if (v != undefined) {
        return n[0] +'?'+ i.join('&');
    }
    return r;
}

$('#newsletters .filter input').live('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#npage').val(1);
		nfilter();
	}
});

$('#newsletters .filter select').live('change', function() {
	$('#npage').val(1);
	nfilter();
});

$('#newsletters .pagination .links a').live("click", function() {
	var npage = gsUV($(this).attr('href'), 'page');
	$('#npage').val(npage);
	nfilter();
	return false;
});

$('#move_newsletters').live("click", function() {
	$('#newsletters .success, .warning, .error').remove();
	$('#movenews').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
});

$('#nhead a').live("click", function() {
	var nsort = gsUV($(this).attr('href'), 'sort');
	$('#nsort').val(nsort);
	var norder = gsUV($(this).attr('href'), 'order');
	$('#norder').val(norder);
	$(this).attr('href', gsUV($(this).attr('href'), 'order', norder=='DESC'?'ASC':'DESC'));
	$('#nhead a').removeAttr('class');
	this.className = norder.toLowerCase();
	nfilter();
	return false;
});

$('#save_newsletters').on("click", function() {
	var newsdata = $('#newsletter select, #newsletter input:text, #newsletter input:hidden, #newsletter input:checked, #newsletter textarea').serialize();
	$.ajax({
		url: wkdir + 'import_newsletters' + tokken,
		type: 'post',
		data: newsdata,
		dataType: 'json',
		beforeSend: function() {
			$('#save_newsletters').hide().after(wkwait);
		},
		success: function(json) {
			$('#newsletter .success, .warning, .error, .wait').remove();
			if (json['error']) {
				$('#save_newsletters').show().after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('#newsletter .warning').fadeIn('slow');
			}
			if (json['email_total']) {
				$('#save_newsletters').show().after('<div class="success" style="display: none;">' + json['email_total'] + '</div>');
				$('#newsletter .success').fadeIn('slow');
				setTimeout (function() {$('#npage').val(1);clear_nfilter();}, 600);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function delnewsletters() {
	$.ajax({
		url: wkdir + 'delnewsletters' + tokken,
		type: 'post',
		data: $('#newsletters input:checked'),
		dataType: 'json',
		beforeSend: function() {
			$('#newsletters .success, .warning, .error').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('.buttons-newsletters').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			
			if (json['newsdell']) {
				$.each(json['newsdell'], function(index, value){
					$('#newsletter_' + value).fadeOut('slow');
				});
				setTimeout (function() {$('#npage').val(1);nfilter();}, 600);
			}
		}
	});
}

function movenewsletters() {
	var new_gid = $('#move_for_group').val();
	$.ajax({
		url: wkdir + 'movenewsletters&group_id='+ new_gid + tokken,
		type: 'post',
		data: $('#newsletters input:checked'),
		dataType: 'json',
		beforeSend: function() {
			$('#tab-newsletters .success, .warning, .error').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('#movenews').fadeOut('slow', function() {
					$('.buttons-newsletters').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
					$('.warning').fadeIn('slow');
				});
			}
			if (json['success']) {
				$('#movenews').fadeOut('slow', function() {
					$('.buttons-newsletters').prepend('<div class="success" style="display: none;">' + json['success'] + '</div>');
					$('.success').fadeIn('slow').addClass('fordel');
					setTimeout (function() {$('#tab-newsletters .fordel').fadeOut().remove();}, 2000);
					setTimeout (function() {$('#npage').val(1);clear_nfilter();}, 600);
				});
			}
		}
	});
}

function addnewsletters() {
	$('#content_newsletter').fadeIn('slow');
	$('html, body').stop().animate({scrollTop: $('#newsletter').offset().top}, 1000);
}

function tognewsletter(tognews, nid) {
	if (tognews == 3) {
		var togurl = wkdir + 'delnewsletter&newsletter_id='+ nid + tokken;
	} else {
		var togurl = wkdir + 'tognewsletter&newsletter_id='+ nid +'&nmode='+ tognews + tokken;
	}
	$.ajax({
		url: togurl,
		dataType: 'json',
		beforeSend: function() {
			$('#newsletters .warning, #newsletters .error').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('#newsletter_' + nid + ' .btn-msubscr, #newsletter_' + nid + ' .btn-munsubscr').fadeOut('fast');
				$('#newsletter_' + nid + ' .btn-mremove').fadeOut('fast', function() {
					$('#newsletter_' + nid + ' .btn-mremove').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
					$('#newsletters .warning').fadeIn('slow');
				});
				setTimeout (function() {
					$('#newsletters .warning').fadeOut('fast', function() {
						$(this).remove();
						$('#newsletter_' + nid + ' .btn').fadeIn('slow');
					});
				}, 3000);
			}
			if (json['success']) {
				if ((tognews == 1) || (tognews == 2)) {
					$('#newsletter_' + nid + ' .btn-msubscr, #newsletter_' + nid + ' .btn-munsubscr').fadeOut('fast');
					$('#newsletter_' + nid + ' .btn-mremove').fadeOut('fast', function() {
						$('#newsletter_' + nid + ' .btn-mremove').after('<div class="success success-' + nid + '" style="display: none;">' + json['success'] + '</div>');
						$('#newsletters .success-' + nid).fadeIn('slow');
					});
					$('#newsletter_' + nid + ' .subscriber, #newsletter_' + nid + ' .unsubscriber').removeClass().addClass('tognews');
					if (tognews == 1) {
						$('#newsletter_' + nid + ' .tognews').removeClass().addClass('subscriber');
					} else if (tognews == 2) {
						$('#newsletter_' + nid + ' .tognews').removeClass().addClass('unsubscriber');
					}
					setTimeout (function() {
						$('#newsletters .success-' + nid).fadeOut('fast', function() {
							$(this).remove();
							$('#newsletter_' + nid + ' .btn').fadeIn('slow');
						});
					}, 3000);
				} else if (tognews == 3) {
					$('#newsletter_' + nid).fadeOut('slow', function() {$(this).remove();});
				}
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
function updatemails() {
	$('#mails .block-box').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#mails').empty().append(wkwait2).load('index.php?route=sale/contactp' + tokken);
	}, 600);
}

function getmailbody(mid, mraw) {
	$.ajax({
		url: wkdirp + 'getbodymail&mail_id='+ mid +'&mraw='+ mraw + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#mails .mail-body .body-block').empty();
			$('#tab-mail-'+ mid +' .mail-body .body-block').append(wkwait);
		},
		success: function(json) {
			$('#tab-mails .wait').remove();
			
			if (json['error']) {
				$('#tab-mail-'+ mid +' .mail-body .body-block').append('<div class="mails-error">'+ json['error'] +'</div>');
			}
			
			if (json['body']) {
				if (json['body'] != '') {
					html = '<div class="htabs mail-body-tabs">';
					
					if (json['body']['text'] && (json['body']['text'] != '')) {
						html += ' <a href="#mail-body-tab-text-'+ mid +'">TEXT</a>';
					}
					if (json['body']['html'] && (json['body']['html'] != '')) {
						html += ' <a href="#mail-body-tab-html-'+ mid +'">HTML</a>';
					}
					
					html += '</div>';
					
					if (json['body']['text'] && (json['body']['text'] != '')) {
						html += '<div id="mail-body-tab-text-'+ mid +'" class="mail-body-item">';
						
						$.each(json['body']['text'], function(index, value){
							html += ' <div class="item-text"><pre>'+ value +'</pre></div>';
						});
						html += '</div>';
					}
					if (json['body']['html'] && (json['body']['html'] != '')) {
						html += '<div id="mail-body-tab-html-'+ mid +'" class="mail-body-item">';
						
						$.each(json['body']['html'], function(index, value){
							html += ' <div class="item-html">'+ value +'</div>';
						});
						html += '</div>';
					}
					
					$('#tab-mail-'+ mid +' .mail-body .body-block').append(html);
					$('#tab-mail-'+ mid +' .mail-body .mail-body-tabs a').tabs();
				}
			}
			
			if (json['unsub']) {
				$('#tab-mail-'+ mid +' .failed-recipient span, #tab-mail-'+ mid +' .failed-recipient a').remove();
				if (json['unsub'] == '1') {
					$('#tab-mail-'+ mid +' .mail-headers .failed-recipient').append('<span class=""><?php echo $text_unsubs_ok; ?></span>');
				} else {
					$('#tab-mail-'+ mid +' .mail-headers .failed-recipient').append('<a onclick="unsubemail(\''+ mid +'\',\''+ json['unsub'] +'\');" class="btn btn-munsubscr" title="<?php echo $text_unsubs; ?>"></a>');
				}
			}
			
			if (json['mraw']) {
				$('#tab-mail-'+ mid +' .mail-body .body-block').append('<textarea class="raw-mail"></textarea>');
				$('#tab-mail-'+ mid +' .mail-body .body-block textarea').val(json['mraw']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function unsubemail(mid, email) {
	$('#tab-mail-'+ mid +' .failed-recipient a').hide();
	$.ajax({
		url: wkdir + 'togcheckresult&mode=1&email=' + encodeURIComponent(email) + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-mail-'+ mid +' .failed-recipient').append(wkwait);
		},
		success: function(json) {
			$('#tab-mails .wait').remove();
			if (json['error']) {
				$('#tab-mail-'+ mid +' .failed-recipient').append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('#tab-mail-'+ mid +' .warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#tab-mail-'+ mid +' .failed-recipient').append('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#tab-mail-'+ mid +' .success').fadeIn('slow');
				setTimeout (function() {$('#tab-mail-'+ mid +' .success').remove();}, 4000);
			}
		}
	});
}

function removemails() {
	$('#tab-mails .buttons-mails a').hide();
	var selmails = $('#vtabs-mails input:checked').serialize();
	$.ajax({
		url: wkdirp + 'removemails' + tokken,
		type: 'post',
		data: selmails,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-mails .success, #tab-mails .warning').remove();
			$('#tab-mails .buttons-mails').prepend(wkwait);
		},
		success: function(json) {
			$('#tab-mails .wait').remove();
			
			if (json['error']) {
				$('#tab-mails .buttons-mails').prepend('<div class="warning warning-remove" style="display: none;">' + json['error'] + '</div>');
				$('#tab-mails .buttons-mails .warning').fadeIn('slow');
				setTimeout (function() {$('#tab-mails .buttons-mails .warning').remove();}, 4000);
			}
			if (json['success']) {
				$('#tab-mails .buttons-mails').prepend('<div class="success success-remove" style="display: none;">' + json['success'] + '</div>');
				$('#tab-mails .buttons-mails .success').fadeIn('slow');
				setTimeout (function() {$('#tab-mails .buttons-mails .success').remove();}, 4000);
				
				if (json['attention']) {
					$('#vtabs-mails input').prop('checked', false);
					$('#mails .block-box').animate({'opacity': '0.3'}, 'slow');
					$('#mails .mail-body .body-block').empty();
					
					html = '<div class="mails-error">';
					$.each(json['attention'], function(index, value){
						html += '<div class="attention" style="display: none;">' + value + '</div>';
					});
					html += '</div>';
					
					$('#mails').prepend(html);
					$('#mails .attention').fadeIn('slow');
				} else {
					updatemails();
				}
			}
			$('#tab-mails .buttons-mails a').show();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
//--></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('message1', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager' + tokken
});
CKEDITOR.replace('message2', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager' + tokken
});
CKEDITOR.replace('cron_message', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager' + tokken,
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager' + tokken
});

$('#tabs a').tabs();
$('#tabs-setting a').tabs();

$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'hh:mm:ss'
});
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>
<script type="text/javascript"><!--
var cron_message = $('#cron_message');

$('#crons').load(wkdir + 'crons' + tokken);

$('#crons .pagination a').live('click', function() {
	$('#crons').load(this.href);
	return false;
});

function updatecron() {
	$('#crons table.list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#crons').empty().load(wkdir + 'crons' + tokken);
	}, 600);
}

function viewcronlog(clin) {
	var filename = $('#actab-'+ clin).text();
	$.ajax({
		url: wkdir + 'viewcronlog&cronlog='+ filename + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#ctab-'+ clin +' textarea').val('');
		},
		success: function(json) {
			if (json['log']) {
				$('#ctab-'+ clin +' textarea').val(json['log']);
			}
		}
	});
}

function delcronlog(clin) {
	var filename = $('#actab-'+ clin).text();
	$.ajax({
		url: wkdir + 'delcronlog&cronlog='+ filename + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#ctab-'+ clin +' textarea').val('');
		},
		success: function(json) {
			if (json['success']) {
				$('#ctab-'+ clin +' textarea, #actab-'+ clin).fadeOut('slow', function() {$(this).remove();});
			}
		}
	});
}

function viewcronlogs(cid) {
	$.ajax({
		url: wkdir + 'viewcronlogs&cron_id='+ cid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#cron .success, .warning, .error').remove();
			$('#tab-crons .content-cron').hide();
			$('#logs_cron').empty();
		},
		complete: function() {
			$('html, body').stop().animate({scrollTop: $('#logs_cron').offset().top}, 1000);
		},
		success: function(json) {
			if (json['logs'] != '') {
				var html = '<div id="ctabs" class="vtabs">';
				
				$.each(json['logs'], function(index, value){
					html += ' <li>';
					html += '  <a onclick="viewcronlog('+ index +')" id="actab-'+ index +'" class="vtabs-log" href="#ctab-'+ index +'">'+ value +'</a>';
					html += '  <div class="close-block" onclick="delcronlog('+ index +')" title="<?php echo $button_dellog; ?>"></div>';
					html += ' </li>';
				});
				
				html += '</div>';
				
				$.each(json['logs'], function(index, value){
					html += '<div id="ctab-'+ index +'" class="vtabs-content">';
					html += ' <textarea wrap="off"></textarea>';
					html += '</div>';
				});

				$('#logs_cron').append(html);
				$('#ctabs a').tabs();
				viewcronlog(0);
				$('#logs_cron').fadeIn('slow');
			}
		}
	});
}

function editcron(cid) {
	$('#logs_cron').hide();
	var editor = CKEDITOR.instances.cron_message;
	$.ajax({
		url: wkdir + 'getcron&cron_id='+ cid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#content_cron').slideDown('slow');
			$('#cron .success, .warning, .error').remove();
			$('#cron_name, #cron_subject, #cron_date_start, #cron_period').val('');
			cron_message.val('');
			editor.setData('');
		},
		complete: function() {
			$('html, body').stop().animate({scrollTop: $('#cron').offset().top}, 1000);
		},
		success: function(json) {
			if (json['name']) {
				$('#cron_name').val(json['name']);
			}
			if (json['subject']) {
				$('#cron_subject').val(json['subject']);
			}
			if (json['message']) {
				if (editor.mode == "wysiwyg") {
					editor.insertHtml(json['message']);
				} else {
					alert('<?php echo $editor_mode_alert; ?>');
				}
			}
			if (json['date_start']) {
				$('#cron_date_start').val(json['date_start']);
			}
			if (json['period']) {
				$('#cron_period').val(json['period']);
			}
			if (json['status'] > 0) {
				$('#cron_status').attr('checked', true);
			} else {
				$('#cron_status').attr('checked', false);
			}
			$('#save_cron').attr('onclick', 'savecron('+ cid +');');
		}
	});
}

function savecron(cid) {
	cron_message.val(CKEDITOR.instances.cron_message.getData());
	$.ajax({
		url: wkdir + 'savecron&cron_id='+ cid + tokken,
		type: 'post',
		data: $('#cron input:text, #cron input:checked, #cron textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#cron .success, .warning, .error').remove();
			$('#save_cron').attr('disabled', true).hide().before(wkwait);
		},
		complete: function() {
			$('#save_cron').attr('disabled', false).css('display', 'inline-block');
			$('.wait').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('#save_cron').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				updatecron();
				$('#save_cron').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#cron .success').fadeIn('slow');
			}
		}
	});
}

function delcron(cid) {
	$.ajax({
		url: wkdir + 'delcron&cron_id='+ cid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#cron .success, .warning, .error').remove();
			$('#cron_name, #cron_subject, #cron_date_start, #cron_period').val('');
			cron_message.val('');
			CKEDITOR.instances.cron_message.setData('');
			$('#cron_status').attr('checked', false);
			$('#save_cron').attr('onclick', '');
			$('#content_cron').fadeOut('slow');
		},
		success: function(json) {
			if (json['error']) {
				$('.buttons-crons').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#cron_' + cid).fadeOut('slow', function() {$(this).remove();});
			}
		}
	});
}

function viewhistory(cid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewhistory&cron_id="+ cid + tokken
	});
}
//--></script>
<script type="text/javascript"><!--
$('#resultmail .info-box').load(wkdir + 'checkcrons' + tokken);

function updatecheckcron() {
	$('#resultmail .info-box .list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#resultmail .info-box').empty().load(wkdir + 'checkcrons' + tokken);
	}, 600);
}

function viewcheckemails(cid, cst) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewcheckresult&cid="+ cid +"&cst=" + cst + tokken
	});
}

function togcheckemails(mode, email) {
	$.ajax({
		url: wkdir + 'togcheckresult&mode='+ mode +'&email=' + encodeURIComponent(email) + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#action_info').empty();
		},
		success: function(json) {
			if (json['error']) {
				$('#action_info').append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('#action_info .warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#action_info').append('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#action_info .success').fadeIn('slow');
			}
		}
	});
}

function viewchecklog(clin) {
	var filename = $('#cactab-'+ clin).text();
	$.ajax({
		url: wkdir + 'viewcronlog&cronlog='+ filename + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#cctab-'+ clin +' textarea').val('');
		},
		success: function(json) {
			if (json['log']) {
				$('#cctab-'+ clin +' textarea').val(json['log']);
			}
		}
	});
}

function delchecklog(clin) {
	var filename = $('#cactab-'+ clin).text();
	$.ajax({
		url: wkdir + 'delcronlog&cronlog='+ filename + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#cctab-'+ clin +' textarea').val('');
		},
		success: function(json) {
			if (json['success']) {
				$('#cctab-'+ clin +' textarea, #cactab-'+ clin).fadeOut('slow', function() {$(this).remove();});
			}
		}
	});
}

function viewchecklogs(cid) {
	$.ajax({
		url: wkdir + 'viewcronlogs&cron_id='+ cid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-checkmails .content-checkmail').hide();
			$('#logs_check').empty();
		},
		complete: function() {
			$('html, body').stop().animate({scrollTop: $('#logs_check').offset().top}, 1000);
		},
		success: function(json) {
			if (json['logs'] != '') {
				var html = '<div id="cctabs" class="vtabs">';
				
				$.each(json['logs'], function(index, value){
					html += ' <li>';
					html += '  <a onclick="viewchecklog('+ index +')" id="cactab-'+ index +'" class="vtabs-log" href="#cctab-'+ index +'">'+ value +'</a>';
					html += '  <div class="close-block" onclick="delchecklog('+ index +')" title="<?php echo $button_dellog; ?>"></div>';
					html += ' </li>';
				});
				
				html += '</div>';
				
				$.each(json['logs'], function(index, value){
					html += '<div id="cctab-'+ index +'" class="vtabs-content">';
					html += ' <textarea wrap="off"></textarea>';
					html += '</div>';
				});

				$('#logs_check').append(html);
				$('#cctabs a').tabs();
				viewchecklog(0);
				$('#logs_check').fadeIn('slow');
			}
		}
	});
}

$('#statistics').load(wkdir + 'statistics' + tokken);

$('#statistics .pagination a').live('click', function() {
	$('#statistics').load(this.href);
	return false;
});

function updatestat() {
	$('#statistics table.list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#statistics').empty().load(wkdir + 'statistics' + tokken);
	}, 600);
}

function delmailing(sid) {
	$.ajax({
		url: wkdir + 'delmailing&sid='+ sid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#mailing_' + sid + ' a.btn').hide();
		},
		success: function(json) {
			$('#statistics .success, .warning, .error').remove();
			if (json['error']) {
				$('#mailing_' + sid + ' a.btn').show();
				$('#mailing_' + sid + ' td.send-subject').empty().append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#mailing_' + sid).fadeOut('slow', function() {$(this).remove();});
			}
		}
	});
}

function viewmessage(sid, mnew) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewmessage&sid="+ sid + "&new="+ mnew + tokken
	});
}

function viewunsub(sid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewunsubscribes&sid="+ sid + tokken
	});
}

function viewopens(sid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewopens&sid="+ sid + tokken
	});
}

function viewclicks(sid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewclicks&sid="+ sid + tokken
	});
}

function resultcheck(url) {
	$.colorbox({
		iframe:true,
		width:"85%",
		height:"85%",
		href: url
	});
}

function import_from_stat(sid, gmode, cst) {
	var gid = $('#'+ gmode +'_'+ sid +' tfoot select.for_groups').val();
	var amode = $('#'+ gmode +'_'+ sid +' tfoot select.for_amode').val();
	if (gid) {
		$.ajax({
			url: wkdir + 'importfromstat&sid='+ sid +'&gmode='+ gmode +'&amode='+ amode +'&gid='+ gid +'&cst='+ cst + tokken,
			dataType: 'json',
			beforeSend: function() {
				$('#'+ gmode +'_'+ sid +' tfoot .btn').attr('onclick', '');
			},
			success: function(json) {
				$('#'+ gmode +'_'+ sid +' tfoot td.action').children().animate({'opacity': '0'}, 'slow');
				if (json['error']) {
					$('#'+ gmode +'_'+ sid +' tfoot td.action').empty().append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
					$('.warning').fadeIn('slow');
				}
				if (json['success']) {
					$('#'+ gmode +'_'+ sid +' tfoot td.action').empty().append('<div class="success" style="display: none;">' + json['success'] + '</div>');
					$('.success').fadeIn('slow');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
//--></script>
<script type="text/javascript"><!--
function attshow() {
	$("#attention_block, #send_block").addClass("open");
	$('#attention_block').slideDown(600);
}

function atthide() {
	$("#attention_block, #send_block").removeClass("open");
	$('#attention_block').slideUp(600, function() {$('#attention_block .success-empty').remove();});
}

function attckshow() {
	$("#attention_check, #checkmail_block").addClass("open");
	$('#attention_check').slideDown(600);
}

$('#attention_toggle').on("click", function() {
	if($("#attention_block").hasClass("open")) {
		atthide();
	} else {
		$("#attention_block, #send_block").addClass("open");
		if ($('#attention_block > div').size()) {
			$('#attention_block').slideDown(600);
		} else {
			$('#attention_block').append('<div class="success success-empty"><?php echo $text_no_data; ?></div>');
			$('#attention_block').slideDown(600);
		}
	}
});

$('.attention .close').live("click", function() {
	$(this).parent().parent().fadeOut(600, function() {
		$(this).remove();
		if (!$('#attention_block > div').size()) {atthide();}
	});
});

$('.filter-checkbox').on("click", function() {
	if($(this).prop('checked')) {
		$(this).parent().parent().find('.filter-block').css('display', 'table-cell').animate({'opacity': '1'}, 'slow');
	} else {
		$(this).parent().parent().find('.filter-block').fadeOut('slow', function() {$(this).css('opacity', '0');});
	}
});	

$('#insert_products').on("click", function() {
	if($(this).prop('checked')) {
		$('#products-body').show('slow');
	} else {
		$('#products-body').hide('slow');
		$('#products-body input[type=\'checkbox\']').attr('checked', false);
		$('.products-block').animate({'opacity': '0'}, 'slow').hide('slow');
		$('.showsel, .showcatsel').hide();
	}
});

$('#mail .products-checkbox').on("click", function() {
	if($(this).prop('checked')) {
		$(this).parent().find('.products-block').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
	} else {
		$(this).parent().find('.products-block').animate({'opacity': '0'}, 'slow').hide('slow');
	}
});

$('#entry_selected').on("click", function() {
	if($(this).prop('checked')) {
		$(this).parent().find('.products-block').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
		$('.showsel').show('slow').animate({'opacity': '1'}, 'slow');
	} else {
		$(this).parent().find('.products-block').animate({'opacity': '0'}, 'slow').hide('slow');
		$('.showsel').animate({'opacity': '0'}, 'slow').hide();
	}
});

$('#entry_catselected').on("click", function() {
	if($(this).prop('checked')) {
		$(this).parent().find('.products-block').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
		$('.showcatsel').show('slow').animate({'opacity': '1'}, 'slow');
	} else {
		$('#entry_category input[type=\'checkbox\']').attr('checked', false);
		$(this).parent().find('.products-block').animate({'opacity': '0'}, 'slow').hide('slow');
		$('.showcatsel').animate({'opacity': '0'}, 'slow').hide();
	}
});

function missremove(msid) {
	$.ajax({
		url: wkdir + 'delmailing&sid='+ msid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#misssend_' + msid + ' a.btn').attr('onclick', '');
		},
		success: function(json) {
			$('.success, .warning, .error').remove();
			if (json['error']) {
				$('#misssend_' + msid).addClass('error-permission');
			}
			if (json['success']) {
				$('#misssend_' + msid).addClass('fordel').fadeOut('slow', function() {
					$(this).empty().append('<div style="text-align:center;">' + json['success'] + '</div>').fadeIn('slow');
				});
				setTimeout (function() {
					$('.attention.fordel').fadeOut('slow', function() {
						$(this).remove();
						if (!$('#attention_block > div').size()) {
							atthide();
						}
					});
				}, 3000);
			}
		}
	});
}

function misstocomplete(msid) {
	$.ajax({
		url: wkdir + 'misstocomplete&msid='+ msid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#misssend_' + msid + ' a.btn').attr('onclick', '');
		},
		success: function(json) {
			$('.success, .warning, .error').remove();
			if (json['error']) {
				$('#misssend_' + msid).addClass('error-permission');
			}
			if (json['success']) {
				$('#misssend_' + msid).addClass('fordel').fadeOut('slow', function() {
					$(this).empty().append('<div style="text-align:center;">' + json['success'] + '</div>').fadeIn('slow');
				});
				updatestat();
				setTimeout (function() {
					$('.attention.fordel').fadeOut('slow', function() {
						$(this).remove();
						if (!$('#attention_block > div').size()) {
							atthide();
						}
					});
				}, 3000);
			}
		}
	});
}

function updatemisssend(sid) {
	$.ajax({
		url: wkdir + 'updatemisssend&sid='+ sid + tokken,
		dataType: 'json',
		success: function(json) {
			if (json['send_id']) {
				html = '';
				html += '<div class="info-block">';
				html += ' <div class="malarm">' + json['send_alarm'] + '</div>';
				html += ' <div class="minfo">' + json['send_count'] + '</div>';
				html += '</div>';
				
				html += '<div class="buttons-block">';
				html += ' <a class="btn btn-msend" title="<?php echo $button_missresend; ?>" onclick="missresend(\'index.php?route=sale/contacts/misssend&msid=' + json['send_id'] + '&token=<?php echo $token; ?>\')"></a>';
				html += ' <a class="btn btn-mtocompl" title="<?php echo $button_misstocomplete; ?>" onclick="misstocomplete(' + json['send_id'] + ')"></a>';
				html += ' <a class="btn btn-mremove" title="<?php echo $button_missremove; ?>" onclick="missremove(' + json['send_id'] + ')"></a>';
				html += '</div>';
				
				$('#attention_block').append('<div class="attention misssend-attention stop-attention" id="misssend_'+ json['send_id'] +'" style="display: none;"></div>');
				$('#misssend_'+ json['send_id']).html(html).fadeIn(800);
			}
		}
	});
}

function updatelog() {
	$.ajax({
		url: wkdir + 'updatelog' + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-log .buttons-log').prepend(wkwait);
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			$('#tab-log .success, #tab-log .warning').remove();
			if (json['error']) {
				$('.status-log').append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#logarea').val('');
				if (json['log']) {
					$('#logarea').val(json['log']);
				}
				$('.status-log').append('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#tab-log .success').fadeIn('slow');
				setTimeout (function() {$('#tab-log .success').fadeOut('slow', function() {$(this).remove();});}, 3000);
			}
		}
	});
}

function clearlog() {
	$.ajax({
		url: wkdir + 'clearlog' + tokken,
		dataType: 'json',
		success: function(json) {
			$('#tab-log .success, #tab-log .warning').remove();
			if (json['error']) {
				$('.status-log').append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#logarea').val('');
				$('.status-log').append('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#tab-log .success').fadeIn('slow');
				setTimeout (function() {$('#tab-log .success').fadeOut('slow', function() {$(this).remove();});}, 3000);
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$('#groups').load(wkdir + 'groups' + tokken);

$('#groups .pagination a').live('click', function() {
	$('#groups').load(this.href);
	return false;
});

function updategroup() {
	$('#groups table.list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#groups').empty().load(wkdir + 'groups' + tokken);
	}, 600);
}

function newgroup() {
	$('#group_name, #group_description').val('');
	$('#content_group').fadeIn('slow');
	$('#group .success, .warning, .error').remove();
	$('#save_group').attr('onclick', 'savegroup(0);');
	$('html, body').stop().animate({scrollTop: $('#group').offset().top}, 1000);
}

function reloadgroup() {
	$.ajax({
		url: wkdir + 'getsendgroups' + tokken,
		dataType: 'json',
		success: function(json) {
			html = '';
			html2 = '';
			html3 = '<option value="*"></option>';
			cl = 'odd';
			if (json['groups'] != '') {
				for (i = 0; i < json['groups'].length; i++) {
					html += '<option value="' + json['groups'][i]['group_id'] + '">' + json['groups'][i]['name'] + '</option>';
					if (cl == 'odd') {cl = 'even';} else {cl = 'odd';}
					html2 += '<div class="'+ cl +'"><input type="checkbox" name="send_group_id[]" value="' + json['groups'][i]['group_id'] + '" />' + json['groups'][i]['name'] + '</div>';
				}
			}
			html3 += html;
			
			$('#to-send-group .scrollbox').empty().html(html2);
			$('#from-send-group .scrollbox').empty().html(html2);
			$('#to_check_send_group .scrollbox').empty().html(html2);
			$('#newsletter select[name=\'filter_for_group\']').html(html);
			$('#newsletters select[name=\'filter_group_id\']').html(html3);
			$('#move_for_group').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function savegroup(gid) {
	var group_name = $('#group_name').val();
	var group_desc = $('#group_description').val();
	if (gid > 0) {
		var url = wkdir + 'savegroup&group_id='+ gid + tokken
	} else {
		var url = wkdir + 'savegroup' + tokken
	}
	$.ajax({
		url: url,
		type: 'post',
		data: $('#group_name, #group_description'),
		dataType: 'json',
		beforeSend: function() {
			$('#group .success, #group .warning').remove();
			$('#save_group').hide().before(wkwait);
		},
		complete: function() {
			$('#save_group').css('display', 'inline-block');
			$('.wait').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('#save_group').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				if (json['group_id']) {
					$('.nogroups').remove();
					$('#groups tbody').prepend('<tr class="newline" id="group_' + json['group_id'] + '"><td class="center">' + json['group_id'] + '</td><td class="left">'+ group_name +'</td><td class="left">'+ group_desc +'</td><td class="center"></td><td class="right"><a onclick="editgroup('+json['group_id']+');" class="btn btn-edit" title="<?php echo $text_group_edit; ?>"></a><a onclick="delgroup('+json['group_id']+');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a></td></tr>');
					$('#save_group').attr('onclick', 'savegroup('+ json['group_id'] +', 0);');
				} else {
					$('#group_' + gid + ' .td-gname').empty().append(group_name);
					$('#group_' + gid + ' .td-gdescript').empty().append(group_desc);
				}
				$('#save_group').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#group .success').fadeIn('slow');
				reloadgroup();
			}
		}
	});
}

function editgroup(gid) {
	$.ajax({
		url: wkdir + 'getsendgroup&group_id='+ gid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#group .success, #group .warning').remove();
			$('#group_name, #group_description').val('');
			$('#content_group').fadeIn('slow');
		},
		complete: function() {
			$('html, body').stop().animate({scrollTop: $('#group').offset().top}, 1000);
		},
		success: function(json) {
			$('#group_name').val(json['name']);
			if (json['description']) {
				$('#group_description').val(json['description']);
			}
			$('#save_group').attr('onclick', 'savegroup('+ gid +');');
			reloadgroup();
		}
	});
}

function delgroup(gid) {
	$.ajax({
		url: wkdir + 'delgroup&group_id='+ gid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#group .success, #group .warning').remove();
			$('#group_name, #group_description').val('');
			$('#save_group').attr('onclick', '');
			$('#content_group').fadeOut('slow');
		},
		success: function(json) {
			if (json['error']) {
				$('.buttons-groups').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#group_' + gid).fadeOut('slow', function() {$(this).remove();});
				reloadgroup();
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
var message1 = $('#message1');
var message2 = $('#message2');

$('#templates').load(wkdir + 'templates' + tokken);

$('#templates .pagination a').live('click', function() {
	$('#templates').load(this.href);
	return false;
});

function updatetemplates() {
	$('#templates table.list').animate({'opacity': '0'}, 'slow');
	setTimeout (function() {
		$('#templates').empty().load(wkdir + 'templates' + tokken);
	}, 600);
}

function newtemplate() {
	$('#content_template').fadeIn('slow');
	$('#temp_name').val('');
	message2.val('');
	CKEDITOR.instances.message2.setData('');
	$('#template .success, #template .warning').remove();
	$('#save_template').attr('onclick', 'addnewtemplate();');
	$('html, body').stop().animate({scrollTop: $('#template').offset().top}, 1000);
}

function reloadtemplate() {
	$.ajax({
		url: wkdir + 'gettemplates' + tokken,
		dataType: 'json',
		success: function(json) {
			html = '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			
			if (json['templates'] != '') {
				for (i = 0; i < json['templates'].length; i++) {
					html += '<option value="' + json['templates'][i]['template_id'] + '">' + json['templates'][i]['name'] + '</option>';
				}
			}
			
			$('#mail select[name=\'template_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function addnewtemplate() {
	var new_name = $('#temp_name').val();
	var new_subject = $('#temp_subject').val();
	message2.val(CKEDITOR.instances.message2.getData());
	$.ajax({
		url: wkdir + 'addtemplate' + tokken,
		type: 'post',
		data: $('#template input, #template textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#save_template').after(wkwait);
		},
		complete: function() {
			$('.wait').remove();
			message2.val('');
		},
		success: function(json) {
			$('#template .success, #template .warning').remove();
			if (json['error']) {
				$('#save_template').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('.notemplates').remove();
				$('#templates tbody').prepend('<tr class="newline" id="template_'+json['template_id']+'"><td class="left">'+new_name+'</td><td class="left">'+new_subject+'</td><td class="right"><a onclick="viewtemplate('+json['template_id']+');" class="btn btn-mview" style="margin-right:3px;" title="<?php echo $text_view; ?>"></a><a onclick="deltemplate('+json['template_id']+');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a></td></tr>');
				$('#save_template').attr('onclick', 'savetemplate(' + json['template_id'] + ');').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#template .success').fadeIn('slow');
				reloadtemplate();
			}
		}
	});
}

function savetemplate(tplid) {
	message2.val(CKEDITOR.instances.message2.getData());
	$.ajax({
		url: wkdir + 'edittemplate&template_id='+ tplid + tokken,
		type: 'post',
		data: $('#template input, #template textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#save_template').hide().after(wkwait);
		},
		complete: function() {
			$('#save_template').css('display', 'inline-block');
			$('.wait').remove();
			message2.val('');
		},
		success: function(json) {
			$('#template .success, #template .warning').remove();
			if (json['error']) {
				$('#save_template').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#save_template').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#template .success').fadeIn('slow');
				updatetemplates();
				reloadtemplate();
			}
		}
	});
}

function addtemplate() {
	var new_name = $('#new_temp_name').val();
	var new_subject = $('#new_temp_subject').val();
	message1.val(CKEDITOR.instances.message1.getData());
	$.ajax({
		url: wkdir + 'addtemplate' + tokken,
		type: 'post',
		data: $('#new_temp_name, #new_temp_subject, #mail textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#savetempl').hide().after(wkwait);
		},
		complete: function() {
			$('#savetempl').css('display', 'inline-block');
			$('.wait').remove();
			message1.val('');
		},
		success: function(json) {
			$('#mail .success, #mail .warning').remove();
			if (json['error']) {
				$('#savetempl').after('<div class="warning" style="display: none;">'+ json['error'] +'</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('.notemplates').remove();
				$('#templates tbody').prepend('<tr class="newline" id="template_'+ json['template_id'] +'"><td class="left">'+ new_name +'</td><td class="left">'+ new_subject +'</td><td class="right"><a onclick="viewtemplate('+ json['template_id'] +');" class="btn btn-medit" style="margin-right:3px;" title="<?php echo $text_edit; ?>"></a><a onclick="deltemplate('+ json['template_id'] +');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a></td></tr>');
				$('#savetempl').after('<div class="success" style="display: none;">'+ json['success'] +'</div>');
				$('#mail .success').fadeIn('slow');
				reloadtemplate();
			}
		}
	});
}

function deltemplate(tplid) {
	$.ajax({
		url: wkdir + 'deltemplate&template_id='+ tplid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#template_' + tplid + ' .btn').hide();
			$('#temp_name, #temp_subject').val('');
			message2.val('');
			CKEDITOR.instances.message2.setData('');
			$('#save_template').attr('onclick', '');
			$('#content_template').fadeOut('slow');
		},
		success: function(json) {
			$('#template .success, #template .warning').remove();
			if (json['error']) {
				$('.buttons-add').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#template_' + tplid).fadeOut('slow', function() {$(this).remove();});
				reloadtemplate();
			}
		}
	});
}

function viewtemplate(tplid) {
	var editor = CKEDITOR.instances.message2;
	$.ajax({
		url: wkdir + 'gettemplate&template_id='+ tplid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#content_template').slideDown('slow');
			$('#content_template .success, #content_template .warning').remove();
			$('#temp_name, #temp_subject').val('');
			message2.val('');
			editor.setData('');
		},
		success: function(json) {
			$('#temp_name').val(json['name']);
			$('#temp_subject').val(json['subject']);
			if (json['message']) {
				if(editor.mode=="wysiwyg") {
					editor.insertHtml(json['message']);
				} else {
					alert('<?php echo $editor_mode_alert; ?>');
				}
			}
			$('#save_template').attr('onclick', 'savetemplate(' + tplid + ');');
		}
	});
}

function loadtemplate(tplid) {
	var editor = CKEDITOR.instances.message1;
	$.ajax({
		url: wkdir + 'gettemplate&template_id='+ tplid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'template_id\']').after(wkwait);
			$('#mail input[name=\'subject\']').val('');
			message1.val('');
			editor.setData('');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['subject']) {
				$('#mail input[name=\'subject\']').val(json['subject']);
			}
			if (json['message']) {
				if(editor.mode=="wysiwyg") {
					editor.insertHtml(json['message']);
				} else {
					alert('<?php echo $editor_mode_alert; ?>');
				}
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$('#button-savesetting').on('click', function() {
	var sett = $('#contacts-setting select, #contacts-setting input:text, #contacts-setting input:checked, #contacts-setting textarea').serialize();
	$.ajax({
		url: wkdir +'savesetting'+ tokken,
		type: 'post',
		data: sett,
		dataType: 'json',
		success: function(json) {
			$('.success-setting, .warning-setting').remove();
			
			if (json['error']) {
				$('.buttons-setting').prepend('<div class="warning warning-setting" style="display: none;">' + json['error'] + '</div>');
				$('.warning-setting').fadeIn('slow');
			}
			if (json['success']) {
				$('#contacts-setting input[name=\'contacts_cron_limit\']').val(json['cron_limit']);
				$('#contacts-setting input[name=\'contacts_cron_step\']').val(json['cron_step']);
				$('#contacts-setting .cron-step').text(json['cron_step']);
				$('.buttons-setting').prepend('<div class="success success-setting" style="display: none;">' + json['success'] + '</div>');
				$('.success-setting').fadeIn('slow');
				setTimeout ("$('.success-setting').fadeOut('slow');", 3000);
			}
		}
	});
});

function setmask() {
	var mask = $('#recomend_mask').val();
	$('#contacts-setting input[name=\'contacts_email_pattern\']').val(mask);
}

$('#mail select[name=\'static\']').bind('change', function() {
	$(this).parent().parent().find('.help').addClass('hidden');
	$(this).parent().parent().find('.help-' + this.value).removeClass('hidden');
});

$('#checkmail select[name=\'static\']').bind('change', function() {
	$(this).parent().parent().find('.help').addClass('hidden');
	$(this).parent().parent().find('.help-' + this.value).removeClass('hidden');
});

function openfrom(fvl) {
	if ((fvl == 'customer_group') || (fvl == 'client_group')) {
		$('#from-customer-group').addClass('open').show(1000);
	} else {
		$('#from-' + fvl.replace('_', '-')).addClass('open').show(1000);
	}
}

$('#newsletter select[name=\'from\']').bind('change', function() {
	var fromvalue = this.value;
	if ($('#newsletter .from.open').size()) {
		$('#newsletter .from.open').removeClass('open').hide('fast', function() {openfrom(fromvalue);});
	} else {
		openfrom(fromvalue);
	}
	if ((fromvalue == 'manual') || (fromvalue == 'sql_manual') || (fromvalue == 'send_group')) {
		$('#newsletter input[name=\'from_set_region\'], #newsletter input[name=\'set_period\']').attr('checked', false).attr('disabled', true);
		$('#from-region-body .filter-block, #from-period-body .filter-block').hide(200);
		$('#from-region-body, #from-period-body').hide(200);
	} else {
		$('#newsletter input[name=\'from_set_region\'], #newsletter input[name=\'set_period\']').attr('disabled', false).css('display', 'inline-block');
		$('#from-region-body, #from-period-body').show(600);
	}
	if ((fromvalue == 'client_all') || (fromvalue == 'client_select') || (fromvalue == 'client_group') || (fromvalue == 'product') || (fromvalue == 'category')) {
		$('#newsletter input[name=\'from_set_language\']').attr('disabled', false).css('display', 'inline-block');
		$('#from-language-body').show(600);
	} else {
		$('#newsletter input[name=\'from_set_language\']').attr('checked', false).attr('disabled', true);
		$('#from-language-body .filter-block').hide(200);
		$('#from-language-body').hide(200);
	}
});

function opento(tvl) {
	if ((tvl == 'customer_group') || (tvl == 'client_group')) {
		$('#to-customer-group').addClass('open').show(1000);
	} else {
		$('#to-' + tvl.replace('_', '-')).addClass('open').show(1000);
	}
}

$('#mail select[name=\'to\']').bind('change', function() {
	var tovalue = this.value;
	$('#mail select[name=\'static\']').attr('disabled', false);
	$('#mail .invers-block input').attr('checked', false);
	
	if ($('#mail .to.open').size()) {
		$('#mail .to.open').removeClass('open').hide('fast', function() {opento(tovalue);});
	} else {
		opento(tovalue);
	}
	if ((tovalue == 'manual') || (tovalue == 'send_group')) {
		$('#mail input[name=\'set_region\'], #mail input[name=\'set_period\']').attr('checked', false).attr('disabled', true);
		$('#region-body .filter-block, #period-body .filter-block').hide(200);
		$('#region-body, #period-body').hide(200);
	} else {
		$('#mail input[name=\'set_region\'], #mail input[name=\'set_period\']').attr('disabled', false).css('display', 'inline-block');
		$('#region-body, #period-body').show(600);
	}
	if ((tovalue == 'manual') || (tovalue == 'customer_select') || (tovalue == 'client_select') || (tovalue == 'affiliate')) {
		$('#mail select[name=\'static\']').attr('value', 'static').trigger('change');
		$('#mail select[name=\'static\']').attr('disabled', true);
	}
	if (tovalue == 'send_group') {
		$('#mail select[name=\'static\']').attr('value', 'dinamic').trigger('change');
		$('#mail select[name=\'static\']').attr('disabled', true);
	}
	if ((tovalue == 'client_all') || (tovalue == 'client_select') || (tovalue == 'client_group') || (tovalue == 'product') || (tovalue == 'category')) {
		$('#mail input[name=\'set_language\']').attr('disabled', false).css('display', 'inline-block');
		$('#language-body').show(600);
	} else {
		$('#mail input[name=\'set_language\']').attr('checked', false).attr('disabled', true);
		$('#language-body .filter-block').hide(200);
		$('#language-body').hide(200);
	}
});

$('#mail input[name=\'invers_customer\'], #mail input[name=\'invers_client\'], #mail input[name=\'invers_affiliate\']').on("click", function() {
	if($(this).prop('checked')) {
		$('#mail select[name=\'static\']').attr('disabled', false);
	} else {
		$('#mail select[name=\'static\']').attr('value', 'static').trigger('change');
		$('#mail select[name=\'static\']').attr('disabled', true);
	}
});

function opencheck(ckvl) {
	if ((ckvl == 'customer_group') || (ckvl == 'client_group')) {
		$('#to_check_customer_group').addClass('open').show(1000);
	} else {
		$('#to_check_' + ckvl).addClass('open').show(1000);
	}
}

$('#checkmail select[name=\'to_check\']').bind('change', function() {
	var tockvalue = this.value;
	$('#checkmail select[name=\'static\']').attr('disabled', false);
	
	if ($('#checkmail .to.open').size()) {
		$('#checkmail .to.open').removeClass('open').hide('fast', function() {opencheck(tockvalue);});
	} else {
		opencheck(tockvalue);
	}
	if (tockvalue == 'manual') {
		$('#checkmail select[name=\'static\']').attr('value', 'static').trigger('change');
		$('#checkmail select[name=\'static\']').attr('disabled', true);
	}
	if (tockvalue == 'send_group') {
		$('#checkmail select[name=\'static\']').attr('value', 'dinamic').trigger('change');
		$('#checkmail select[name=\'static\']').attr('disabled', true);
	}
});

$('#mail select[name=\'to\']').trigger('change');
$('#newsletter select[name=\'from\']').trigger('change');
$('#checkmail select[name=\'to_check\']').trigger('change');
$('#mail select[name=\'static\']').trigger('change');
$('#checkmail select[name=\'static\']').trigger('change');

$('select[name=\'template_id\']').bind('change', function() {
	var templ = this.value;
	if (templ > 0) {
		loadtemplate(templ);
	} else {
		CKEDITOR.instances.message1.setData('');
		message1.val('');
	}
});

$('select[name=\'country_id\']').bind('change', function() {
	if (this.value > 0) {
		$.ajax({
			url: 'index.php?route=setting/setting/country'+ tokken +'&country_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'zone_id\']').css('opacity', '0.3');
			},
			complete: function() {
				$('select[name=\'zone_id\']').css('opacity', '1');
			},
			success: function(json) {
				html = '<option value=""><?php echo $text_select; ?></option>';
				
				if (json['zone'] != '') {
					for (i = 0; i < json['zone'].length; i++) {
						html += '<option value="' + json['zone'][i]['zone_id'] + '"';
						html += '>' + json['zone'][i]['name'] + '</option>';
					}
				} else {
					html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
				}
				
				$('select[name=\'zone_id\']').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

$('select[name=\'country_id\']').trigger('change');

$('select[name=\'from_country_id\']').bind('change', function() {
	if (this.value > 0) {
		$.ajax({
			url: 'index.php?route=setting/setting/country'+ tokken +'&country_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'from_zone_id\']').css('opacity', '0.3');
			},
			complete: function() {
				$('select[name=\'from_zone_id\']').css('opacity', '1');
			},
			success: function(json) {
				html = '<option value=""><?php echo $text_select; ?></option>';
				
				if (json['zone'] != '') {
					for (i = 0; i < json['zone'].length; i++) {
						html += '<option value="' + json['zone'][i]['zone_id'] + '"';
						html += '>' + json['zone'][i]['name'] + '</option>';
					}
				} else {
					html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
				}
				
				$('select[name=\'from_zone_id\']').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

$('select[name=\'from_country_id\']').trigger('change');

$('select[name=\'contacts_check_mode\']').bind('change', function() {
	if (this.value == 2) {
		$('#button_checkmode').fadeIn();
	} else {
		$('#button_checkmode').hide();
	}
});

$('select[name=\'contacts_check_mode\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				currentCategory = item.category;
			}
			self._renderItem(ul, item);
		});
	}
});

$('input[name=\'from_customers\']').catcomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete'+ tokken +'&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#from_customer' + ui.item.value).remove();
		$('#div_customers').append('<div id="from_customer' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="from_customer[]" value="' + ui.item.value + '" /></div>');
		$('#div_customers div:odd').attr('class', 'odd');
		$('#div_customers div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#div_customers div img').live('click', function() {
	$(this).parent().remove();
	$('#div_customers div:odd').attr('class', 'odd');
	$('#div_customers div:even').attr('class', 'even');
});

$('input[name=\'customers\']').catcomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete'+ tokken +'&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#customer' + ui.item.value).remove();
		$('#customer').append('<div id="customer' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="customer[]" value="' + ui.item.value + '" /></div>');
		$('#customer div:odd').attr('class', 'odd');
		$('#customer div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#customer div img').live('click', function() {
	$(this).parent().remove();
	$('#customer div:odd').attr('class', 'odd');
	$('#customer div:even').attr('class', 'even');	
});

var fclients = 0;
$('input[name=\'from_clients\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: wkdir + 'getclients'+ tokken +'&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.email
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#div_clients input').each(function(i, elem) {
			if ($(this).val() == ui.item.value) {
				$(this).parent().remove();
			}
		});
		inputs = '';
		inputs += '<input type="hidden" name="client['+ fclients +'][email]" value="' + ui.item.value + '" />';
		$('#div_clients').append('<div id="from_client' + fclients + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" />'+ inputs +'</div>');
		$('#div_clients div:odd').attr('class', 'odd');
		$('#div_clients div:even').attr('class', 'even');
		fclients++;
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#div_clients div img').live('click', function() {
	$(this).parent().remove();
	$('#div_clients div:odd').attr('class', 'odd');
	$('#div_clients div:even').attr('class', 'even');
});

var clients = 0;
$('input[name=\'clients\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: wkdir + 'getclients'+ tokken +'&filter_name=' + encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.email
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#client input').each(function(i, elem) {
			if ($(this).val() == ui.item.value) {
				$(this).parent().remove();
			}
		});
		inputs = '';
		inputs += '<input type="hidden" name="client['+ clients +'][email]" value="' + ui.item.value + '" />';
		$('#client').append('<div id="client' + clients + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" />'+ inputs +'</div>');
		$('#client div:odd').attr('class', 'odd');
		$('#client div:even').attr('class', 'even');
		clients++;
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#client div img').live('click', function() {
	$(this).parent().remove();
	$('#client div:odd').attr('class', 'odd');
	$('#client div:even').attr('class', 'even');	
});

$('input[name=\'affiliates\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/affiliate/autocomplete'+ tokken +'&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.affiliate_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#affiliate' + ui.item.value).remove();
		$('#affiliate').append('<div id="affiliate' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="affiliate[]" value="' + ui.item.value + '" /></div>');
		$('#affiliate div:odd').attr('class', 'odd');
		$('#affiliate div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#affiliate div img').live('click', function() {
	$(this).parent().remove();
	$('#affiliate div:odd').attr('class', 'odd');
	$('#affiliate div:even').attr('class', 'even');	
});

$('input[name=\'from_affiliates\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/affiliate/autocomplete'+ tokken +'&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.affiliate_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#from_affiliate' + ui.item.value).remove();
		$('#div_affiliates').append('<div id="from_affiliate' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="from_affiliate[]" value="' + ui.item.value + '" /></div>');
		$('#div_affiliates div:odd').attr('class', 'odd');
		$('#div_affiliates div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#div_affiliates div img').live('click', function() {
	$(this).parent().remove();
	$('#div_affiliates div:odd').attr('class', 'odd');
	$('#div_affiliates div:even').attr('class', 'even');	
});

$('input[name=\'products\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete'+ tokken +'&filter_name=' +  encodeURIComponent(request.term),
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
		$('#product' + ui.item.value).remove();
		$('#product').append('<div id="product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product[]" value="' + ui.item.value + '" /></div>');
		$('#product div:odd').attr('class', 'odd');
		$('#product div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#product div img').live('click', function() {
	$(this).parent().remove();
	$('#product div:odd').attr('class', 'odd');
	$('#product div:even').attr('class', 'even');	
});

$('input[name=\'from_products\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete'+ tokken +'&filter_name=' +  encodeURIComponent(request.term),
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
		$('#from_product' + ui.item.value).remove();
		$('#div_products').append('<div id="from_product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="from_product[]" value="' + ui.item.value + '" /></div>');
		$('#div_products div:odd').attr('class', 'odd');
		$('#div_products div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#div_products div img').live('click', function() {
	$(this).parent().remove();
	$('#div_products div:odd').attr('class', 'odd');
	$('#div_products div:even').attr('class', 'even');	
});

$('input[name=\'sproducts\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete'+ tokken +'&filter_name=' +  encodeURIComponent(request.term),
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
		$('#selproduct' + ui.item.value).remove();
		$('#selproduct').append('<div id="selproduct' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="selproducts[]" value="' + ui.item.value + '" /></div>');
		$('#selproduct div:odd').attr('class', 'odd');
		$('#selproduct div:even').attr('class', 'even');
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('#selproduct div img').live('click', function() {
	$(this).parent().remove();
	$('#selproduct div:odd').attr('class', 'odd');
	$('#selproduct div:even').attr('class', 'even');	
});
//--></script>
<script type="text/javascript"><!--
var nowsend = null;
function missresend(url) {
	if (!nowsend) {
		$('.success, .warning, .error, .info, .attention').remove();
		$('#button-send, #button-cron, #button-check').hide();
		$('#attention_block').prepend('<div class="success wait-text" style="color:red;"><?php echo $text_wait; ?></div>');
	}
	nowsend = 1;
	$.ajax({
		url: url,
		dataType: 'json',
		beforeSend: function() {
			$('.success-send, .warning, .error, .info-send, .attention-send').remove();
			$('#button-cron').before(wkwait2);
			attshow();
		},
		complete: function() {
			$('.wait-text').remove();
		},				
		success: function(json) {
			$('.wait, .success').remove();
			
			if (json['error'] != '') {
				for (i = 0; i < json['error'].length; i++) {
					$('#attention_block').append('<div class="warning" style="display: none;">' + json['error'][i] + '</div>');
				}
				$('#button-send, #button-cron, #button-check').show();
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('.warning').fadeIn('slow');
				nowsend = null;
			}
			
			if (json['next']) {
				if (json['success']) {
					$('#attention_block').append('<div class="success">' + json['success'] + '</div>');
					missresend(json['next']);
				}
			} else {
				if (json['success']) {
					$('#attention_block .info').addClass('info-send');
					$('#attention_block .attention').addClass('attention-send');
					$('#attention_block').append('<div class="success success-send" style="display: none;">' + json['success'] + '</div>');
					$('.success').fadeIn('slow');
					updatestat();
				} else {
					$('.success').fadeOut('slow');
				}
				$('#button-send, #button-cron, #button-check').show();
				nowsend = null;
			}
			
			if (json['attention'] != '') {
				for (i = 0; i < json['attention'].length; i++) {
					$('#attention_block').append('<div class="attention" style="display: none;">' + json['attention'][i] + '</div>');
				}
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('.attention').fadeIn('slow');
			}
			
			if (typeof(json['hour']) != 'undefined') {
				$('#limit_hour').text(json['hour']);
			}
			
			if (typeof(json['day']) != 'undefined') {
				$('#limit_day').text(json['day']);
			}
			
			if (json['stop_send']) {
				$('#button-send, #button-cron, #button-check').show();
				nowsend = null;
				updatemisssend(json['stop_send']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			nowsend = null;
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function send(url) {
	if (!nowsend) {
		$('.success, .warning, .error, .info, .attention').remove();
		$('#button-send, #button-cron, #button-check').hide();
		$('#attention_block').prepend('<div class="success wait-text" style="color:red;"><?php echo $text_wait; ?></div>');
	}
	nowsend = 1;
	message1.val(CKEDITOR.instances.message1.getData());
	var datta = $('#mail select, #mail input:hidden, #mail input:text, #mail input:checked, #mail textarea').serialize();
	$.ajax({
		url: url,
		type: 'post',
		data: datta,
		dataType: 'json',
		beforeSend: function() {
			$('.success-send, .warning, .error, .info-send, .attention-send').remove();
			$('#button-cron').before(wkwait2);
			attshow();
		},
		complete: function() {
			$('.wait-text').remove();
		},				
		success: function(json) {
			$('.wait, .success').remove();
			
			if (json['info']) {
				$('#attention_block').append('<div class="info">' + json['info'] + '</div>');
			}
	
			if (json['error'] != '') {
				$('#attention_block .info').addClass('info-send');
				$('#attention_block .attention').addClass('attention-send');
				if (json['error']['warning']) {
					$('#attention_block').append('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
				}
				if (json['error']['subject']) {
					$('#attention_block').append('<div class="warning" style="display: none;">' + json['error']['subject'] + '</div>');
					$('input[name=\'subject\']').after('<span class="error">' + json['error']['subject'] + '</span>');
				}
				if (json['error']['message']) {
					$('#attention_block').append('<div class="warning" style="display: none;">' + json['error']['message'] + '</div>');
					$('textarea[name=\'message\']').parent().append('<span class="error">' + json['error']['message'] + '</span>');
				}
				$('#button-send, #button-cron, #button-check').show();
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('.warning').fadeIn('slow');
				nowsend = null;
			}
			
			if (json['next']) {
				if (json['success']) {
					$('#attention_block').append('<div class="success">' + json['success'] + '</div>');
					send(json['next']);
				}
			} else {
				if (json['success']) {
					$('#attention_block .info').addClass('info-send');
					$('#attention_block .attention').addClass('attention-send');
					$('#attention_block').append('<div class="success success-send" style="display: none;">' + json['success'] + '</div>');
					$('.success').fadeIn('slow');
					
					if (json['check_url']) {
						resultcheck(json['check_url']);
					} else {
						$('#input_upload, #info_files, #button_fclear').empty().hide();
						updatestat();
					}
					if (json['add_cron']) {
						updatecron();
					}
				} else {
					$('.success').fadeOut('slow');
				}
				$('#button-send, #button-cron, #button-check').show();
				nowsend = null;
			}
			
			if (json['attention'] != '') {
				for (i = 0; i < json['attention'].length; i++) {
					$('#attention_block').append('<div class="attention" style="display: none;">' + json['attention'][i] + '</div>');
				}
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('.attention').fadeIn('slow');
			}
			
			if (typeof(json['hour']) != 'undefined') {
				$('#limit_hour').text(json['hour']);
			}
			
			if (typeof(json['day']) != 'undefined') {
				$('#limit_day').text(json['day']);
			}
			
			if (json['stop_send']) {
				$('#button-send, #button-cron, #button-check').show();
				nowsend = null;
				updatemisssend(json['stop_send']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			nowsend = null;
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function checkemail() {
	var ckdata = $('#checkmail select, #checkmail input:hidden, #checkmail input:text, #checkmail input:checked, #checkmail textarea').serialize();
	$.ajax({
		url: wkdir + 'checkemail' + tokken,
		type: 'post',
		data: ckdata,
		dataType: 'json',
		beforeSend: function() {
			$('.success-check, .warning-check').remove();
			$('#tab-checkmails .buttons a.btn').hide();
		},
		success: function(json) {
			$('.wait').remove();
			$('#tab-checkmails .buttons a.btn').show();
			
			if (json['error']) {
				$('#attention_check').append('<div class="warning warning-check">' + json['error']['warning'] + '</div>');
				attckshow();
			}

			if (json['success']) {
				$('#attention_check').append('<div class="success success-check">' + json['success'] + '</div>');
				attckshow();
				updatecheckcron();
				updatecron();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function checkmode2() {
	$.ajax({
		url: wkdir + 'checkmode' + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#mode_checklog tr td').empty();
			$('#button_checkmode').hide().after(wkwait);
		},
		success: function(json) {
			$('.wait').remove();
			$('#button_checkmode').show();
			
			$('#mode_checklog tr td').append('<div class="checkmode-info"></div>');
			
			if (json['error']) {
				$('#mode_checklog .checkmode-info').append('<div class="warning">' + json['error'] + '</div>');
				if (json['log']) {
					$('#mode_checklog .checkmode-info').append('<textarea class="checkmode-warning"></textarea>');
					$('#mode_checklog textarea').val(json['log']);
				}
			}

			if (json['success']) {
				$('#mode_checklog .checkmode-info').append('<div class="success">' + json['success'] + '</div>');
				if (json['log']) {
					$('#mode_checklog .checkmode-info').append('<textarea class="checkmode-success"></textarea>');
					$('#mode_checklog textarea').val(json['log']);
				}
			}
			$('#mode_checklog .checkmode-info').slideDown('slow');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

window.onbeforeunload = function(evt) {
	if (nowsend) {
		evt = evt || window.event;
		evt.returnValue = "<?php echo $error_close; ?>";
	}
}

<?php if ($missing_send) { ?>
setTimeout (function() {
	attshow();
}, 2000);
<?php } ?>

$('#content_template').hide();

$('#button_fclear').on('click', function() {
	$(this).hide();
	$('.success-upload').remove();
	$('#input_upload, #info_files, #warning_upload').empty().hide();
});

$('#button_select').on('click', function() {
	$('#input_upload').click();
});
 
$('#input_upload').change(function(event){
	$('#button_select').hide();
    var files = this.files;
    event.stopPropagation();
    event.preventDefault();
 
    var data = new FormData();
    $.each(files, function(key, value){
        data.append(key, value);
    });

    $.ajax({
        url: wkdir + 'uploadattach' + tokken,
        type: 'post',
        data: data,
        cache: false,
        dataType: 'json',
		responseType: 'json',
        processData: false,
        contentType: false,
		beforeSend: function() {
			$('.success-upload, .warning, .error').remove();
			$('#info_files').empty();
			$('#button_select').after('<img src="view/image/loading.gif" class="loading" style="padding-right: 5px;" />');
		},
        success: function(json, textStatus, jqXHR ){
			$('#input_upload').empty();
			$('.loading').remove();
		    $('#info_files, #button_select, #button_fclear').css('display', 'inline-block');
			if (json['files_path'] != '') {
				$.each(json['files_path'], function(index, value){
					var html = '<span>'+value.filename+'</span><input type="hidden" name="attachments[]" value="'+ value.path +'" />';
					$('#info_files').append(html).fadeIn('slow');
				});
			}
			if (json['success']) {
				$('#button_select').after('<div class="success success-upload" style="display: none;">' + json['success'] + '</div>');
				$('.success-upload').fadeIn('slow');
			}
			if (json['error'] != '') {
				$.each(json['error'], function(index, value){
					$('#warning_upload').append('<div class="warning" style="display:none;">' + value + '</div>');
					$('.warning').fadeIn('slow');
				});
			}
        },
        error: function(jqXHR, textStatus, errorThrown){
			$('#input_upload').empty();
			$('.loading').remove();
			$('#info_files, #button_select').show();
			$('#info_files').html('<span style="color:red;">'+ textStatus +'</span>');
			console.log('AJAX Error: ' + textStatus );
        }
    });
});
//--></script>
<?php echo $footer; ?>
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
		<a href="#tab-crons" class="vtabs-crons"><?php echo $tab_crons; ?></a>
		<a href="#tab-statistics" class="vtabs-statistics"><?php echo $tab_statistics; ?></a>
		<a href="#tab-log" class="vtabs-log"><?php echo $tab_log; ?></a>
		<a href="#tab-setting" class="vtabs-setting"><?php echo $tab_setting; ?></a>
	</div>

	<div id="tab-send" class="vtabs-content">
	  <div class="buttons buttons-send right">
		<a id="button-cron" onclick="send('index.php?route=sale/contacts/send&add_cron=1&token=<?php echo $token; ?>');" title="<?php echo $button_cron; ?>" class="btn btn-cron"></a>
		<a id="button-check" onclick="send('index.php?route=sale/contacts/send&spam_check=1&token=<?php echo $token; ?>');" title="<?php echo $button_check; ?>" class="btn btn-check"></a>
		<a id="button-send" onclick="send('index.php?route=sale/contacts/send&token=<?php echo $token; ?>');" title="<?php echo $button_send; ?>" class="btn btn-send"></a>
		<a href="<?php echo $cancel; ?>" title="<?php echo $button_cancel; ?>" class="btn btn-cancel"></a>
	  </div>
	  <div class="block-contents">
		<div class="block-content content-send" id="send_block">
        <table id="mail" class="form">
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><select name="store_id">
                <option value="0"><?php echo $text_default; ?></option>
                <?php foreach ($stores as $store) { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
              </select><div id="attention_toggle" title="<?php echo $text_info_panel; ?>"></div></td>
          </tr>
          <tr>
            <td><?php echo $entry_to; ?></td>
            <td><select name="to">
                <option value="newsletter"><?php echo $text_newsletter; ?></option>
                <option value="customer_all"><?php echo $text_customer_all; ?></option>
				<option value="client_all"><?php echo $text_client_all; ?></option>
                <option value="customer_group"><?php echo $text_customer_group; ?></option>
                <option value="customer"><?php echo $text_customer; ?></option>
				<option value="send_group"><?php echo $text_send_group; ?></option>
                <option value="affiliate_all"><?php echo $text_affiliate_all; ?></option>
                <option value="affiliate"><?php echo $text_affiliate; ?></option>
                <option value="product"><?php echo $text_product; ?></option>
				<option value="manual"><?php echo $text_manual; ?></option>
                </select>
			</td>
          </tr>
          <tbody id="to-customer-group" class="to" style="display:none;">
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
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-customer" class="to" style="display:none;">
            <tr>
              <td><?php echo $entry_customer; ?></td>
              <td><input type="text" name="customers" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="customer" class="scrollbox"></div></td>
            </tr>
          </tbody>
          <tbody id="to-send-group" class="to" style="display:none;">
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
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
			  </td>
            </tr>
          </tbody>
          <tbody id="to-affiliate" class="to" style="display:none;">
            <tr>
              <td><?php echo $entry_affiliate; ?></td>
              <td><input type="text" name="affiliates" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="affiliate" class="scrollbox"></div></td>
            </tr>
          </tbody>
          <tbody id="to-product" class="to" style="display:none;">
            <tr>
              <td><?php echo $entry_product; ?></td>
              <td><input type="text" name="products" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product" class="scrollbox"></div></td>
            </tr>
          </tbody>
          <tbody id="to-manual" class="to" style="display:none;">
            <tr>
              <td><?php echo $entry_manual; ?></td>
              <td><textarea name="manual" value="" class="input-manual"></textarea></td>
            </tr>
          </tbody>
          <tbody id="region-body">
		  <tr>
            <td><?php echo $text_region; ?></td>
			<td>
				<div class="select-block region-block">
					<input id="region" type="checkbox" name="set_region" value="1" />
				</div>
				<div class="select-block select-region">
					<div class="select-block">
						<span><?php echo $entry_country; ?></span>&nbsp;&nbsp;
						<select name="country_id">
						<option value=""><?php echo $text_select; ?></option>
						<?php foreach ($countries as $country) { ?>
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
						<?php } ?>
						</select>
					</div>
					<div class="select-block">
						<span><?php echo $entry_zone; ?></span>&nbsp;&nbsp;<select name="zone_id"></select>
					</div>
				</div>
			</td>
          </tr>
		  </tbody>
		  <tr>
			<td><?php echo $entry_unsubscribe; ?></td>
			<td><input id="unsubscribe" type="checkbox" name="set_unsubscribe" value="1" /></td>
		  </tr>				
		  <tr>
			<td><?php echo $entry_contrl_unsub; ?></td>
			<td><?php if ($control_unsubscribe) { ?>
					<input type="checkbox" name="control_unsubscribe" value="1" checked="checked" />
				<?php } else { ?>
					<input type="checkbox" name="control_unsubscribe" value="1" />
				<?php } ?></td>
		  </tr>
		  <tr>
			<td><?php echo $entry_insert_products; ?></td>
			<td><input type="checkbox" id="insert_products" name="insert_products" value="1" /></td>
		  </tr>
          <tbody id="products-body">
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
              <td><div id="selproduct" class="scrollbox" style="width:450px;"></div></td>
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
              <td><div id="entry_category" class="scrollbox" style="width:450px;height:auto;min-height:50px;max-height:200px;">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="catproducts[]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
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
            <td><input type="text" name="subject" value="" style="width:80%;"/></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_message; ?></td>
            <td><textarea id="message1" name="message"></textarea></td>
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
            <td><?php echo $text_save_template; ?></td>
            <td><input id="new_temp_name" type="text" name="new_temp_name" value="" />&nbsp;
			<a class="btn btn-msave" title="<?php echo $text_save; ?>" onclick="addtemplate();" id="savetempl"></a></td>
          </tr>
          <tr>
            <td><?php echo $text_tegi; ?></td>
            <td class="spravka_tegi"><?php echo $spravka_tegi; ?></td>
          </tr>
        </table>
		</div>
		<div class="block-content content-attention" id="attention_block">
		  <?php if ($missing_send) { ?>
		  <?php foreach ($missing_send as $msend) { ?>
			<div class="attention misssend-attention" id="misssend_<?php echo $msend['send_id']; ?>">
				<div class="info-block">
					<?php echo $msend['send_alarm']; ?><br />
					<?php echo $msend['send_title']; ?><br />
					<?php echo $msend['send_info']; ?>
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
	  </div>
	</div>

	<div id="tab-template" class="vtabs-content">
	  <div class="buttons buttons-add right">
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
					<option value="newsletter"><?php echo $text_fnewsletter; ?></option>
					<option value="customer_all"><?php echo $text_fcustomer_all; ?></option>
					<option value="client_all"><?php echo $text_fclient_all; ?></option>
					<option value="customer_group"><?php echo $text_fcustomer_group; ?></option>
					<option value="customer"><?php echo $text_fcustomer; ?></option>
					<option value="send_group"><?php echo $text_fsend_group; ?></option>
					<option value="affiliate_all"><?php echo $text_faffiliate_all; ?></option>
					<option value="affiliate"><?php echo $text_faffiliate; ?></option>
					<option value="product"><?php echo $text_fproduct; ?></option>
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
					<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
				  </td>
				</tr>
			  </tbody>
			  <tbody id="from-customer" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_customer; ?></td>
				  <td><input type="text" name="from_customers" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_customers" class="scrollbox"></div></td>
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
						<input type="checkbox" name="from_send_group_id[]" value="<?php echo $group['group_id']; ?>" /><?php echo $group['name']; ?>
					  </div>
					  <?php } ?>
					</div>
					<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
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
				  <td><div id="div_affiliates" class="scrollbox"></div></td>
				</tr>
			  </tbody>
			  <tbody id="from-product" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_product; ?></td>
				  <td><input type="text" name="from_products" value="" /></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><div id="div_products" class="scrollbox"></div></td>
				</tr>
			  </tbody>
			  <tbody id="from-manual" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_manual; ?></td>
				  <td><textarea name="from_manual" value="" class="input-manual"></textarea></td>
				</tr>
			  </tbody>
			  <tbody id="from-sql-manual" class="from" style="display:none;">
				<tr>
				  <td><?php echo $entry_sql_table; ?></td>
				  <td><input type="text" name="from_sql_table" value="" /></td>
				</tr>
				<tr>
				  <td><?php echo $entry_sql_column; ?></td>
				  <td><input type="text" name="from_sql_column" value="" /></td>
				</tr>
			  </tbody>
			  <tbody id="from-region-body">
			  <tr>
				<td><?php echo $text_region; ?></td>
				<td>
					<div class="select-block region-block">
						<input id="from_region" type="checkbox" name="from_set_region" value="1" />
					</div>
					<div class="select-block select-region">
						<div class="select-block">
							<span><?php echo $entry_country; ?></span>&nbsp;&nbsp;
							<select name="from_country_id">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($countries as $country) { ?>
								<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="select-block">
							<span><?php echo $entry_zone; ?></span>&nbsp;&nbsp;<select name="from_zone_id"></select>
						</div>
					</div>
				</td>
			  </tr>
			  </tbody>
			  
			  <tr>
				<td class="left" style="width:200px;"><?php echo $text_save; ?></td>
				<td class="left"><a id="save_newsletters" title="<?php echo $text_start_import; ?>" class="btn btn-msave"></a></td>
			  </tr>
			</table>
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
		<div class="block-content content-setting">
          <table class="form" id="contacts-setting">
		    <tr>
              <td><?php echo $entry_mail_count_message; ?></td>
              <td><input type="text" name="contacts_count_message" value="<?php echo $contacts_count_message; ?>" /></td>
            </tr>
		    <tr>
              <td><?php echo $entry_mail_sleep_time; ?></td>
              <td><input type="text" name="contacts_sleep_time" value="<?php echo $contacts_sleep_time; ?>" /></td>
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
              <td><?php echo $entry_email_pattern; ?></td>
              <td><input type="text" name="contacts_email_pattern" value="<?php echo $contacts_email_pattern; ?>" /></td>
            </tr>
			<tr>
              <td><?php echo $entry_admin_limit; ?></td>
              <td><input type="text" name="contacts_admin_limit" value="<?php echo $contacts_admin_limit; ?>" /></td>
            </tr>
			<tr>
              <td><?php echo $entry_image_product; ?></td>
              <td>
			  <input type="text" name="contacts_pimage_width" value="<?php echo $contacts_pimage_width; ?>" style="width:110px;min-width:110px;" />
			  <input type="text" name="contacts_pimage_height" value="<?php echo $contacts_pimage_height; ?>" style="width:110px;min-width:110px;" />
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
              <td><span style=""><?php echo $cron_url; ?></span></td>
            </tr>
          </table>
		</div>
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
	<td class="right">{{each action}}<a onclick="${onclk}" class="${clss}" title="${text}"></a>{{/each}}</td>
</tr>
</script>
<script type="text/javascript" src="view/javascript/jquery/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
var wkdir = 'index.php?route=sale/contacts/';
var wkwait = '<span class="wait"><img src="view/image/loading.gif" alt="" />&nbsp;</span>';
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
			$('#save_newsletters').attr('disabled', true).hide().after(wkwait);
		},
		success: function(json) {
			$('#newsletter .success, .warning, .error, .wait').remove();
			if (json['error']) {
				$('#save_newsletters').attr('disabled', false).show().after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('#newsletter .warning').fadeIn('slow');
			}
			if (json['email_total']) {
				$('#save_newsletters').attr('disabled', false).show().after('<div class="success" style="display: none;">' + json['email_total'] + '</div>');
				$('#newsletter .success').fadeIn('slow');
				setTimeout (function() {$('#npage').val(1);clear_nfilter();}, 600);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
					setTimeout ("$('#tab-newsletters .fordel').fadeOut().remove();", 2000);
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
	} else if (tognews == 2) {
		var togurl = wkdir + 'unsubnewsletter&newsletter_id='+ nid + tokken;
	} else {
		var togurl = wkdir + 'subnewsletter&newsletter_id='+ nid + tokken;
	}
	$.ajax({
		url: togurl,
		dataType: 'json',
		beforeSend: function() {
			$('#newsletters .success, .warning, .error').remove();
		},
		success: function(json) {
			if (json['error']) {
				$('#newsletter_' + nid + ' .btn-mremove').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('#newsletters .warning').fadeIn('slow');
				setTimeout ("$('#newsletters .warning').remove();", 3000);
				setTimeout (function() {
					$('#newsletter_' + nid + ' .btn').fadeIn();
				}, 4000);
			}
			
			if (json['success']) {
				if ((tognews == 1) || (tognews == 2)) {
					$('#newsletter_' + nid + ' .btn-msubscr, #newsletter_' + nid + ' .btn-munsubscr').fadeOut('fast');
					$('#newsletter_' + nid + ' .btn-mremove').fadeOut('fast', function() {
						$('#newsletter_' + nid + ' .btn-mremove').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
						$('#newsletters .success').fadeIn('slow');
					});
					$('#newsletter_' + nid + ' .subscriber, #newsletter_' + nid + ' .unsubscriber').removeClass().addClass('tognews');
					if (tognews == 1) {
						$('#newsletter_' + nid + ' .tognews').removeClass().addClass('subscriber');
					} else if (tognews == 2) {
						$('#newsletter_' + nid + ' .tognews').removeClass().addClass('unsubscriber');
					}
					setTimeout ("$('#newsletters .success').fadeOut();", 3000);
					setTimeout (function() {
						$('#newsletters .success').remove();
						$('#newsletter_' + nid + ' .btn').fadeIn();
					}, 4000);
				} else if (tognews == 3) {
					$('#newsletter_' + nid).fadeOut('slow').addClass('fordel');
					setTimeout ("$('#newsletters .fordel').remove();", 2000);
				}
			}
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

$('#tabs a').tabs();

$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:mm:ss'
});
//--></script> 
<script type="text/javascript"><!--
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
				$('#ctab-'+ clin +' textarea, #actab-'+ clin).fadeOut('slow').addClass('fordel');
				setTimeout ("$('#logs_cron .fordel').remove();", 2000);
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
			$('#cron_name, #cron_date_start, #cron_period').val('');
			$('.content-cron').hide();
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
	$.ajax({
		url: wkdir + 'getcron&cron_id='+ cid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#cron .success, .warning, .error').remove();
			$('#cron_name, #cron_date_start, #cron_period').val('');
			$('.content-cron').hide();
			$('#content_cron').fadeIn('slow');
		},
		complete: function() {
			$('html, body').stop().animate({scrollTop: $('#cron').offset().top}, 1000);
		},
		success: function(json) {
			if (json['name']) {
				$('#cron_name').val(json['name']);
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
	$.ajax({
		url: wkdir + 'savecron&cron_id='+ cid + tokken,
		type: 'post',
		data: $('#cron input:text, #cron input:checked'),
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
			$('#cron_name, #cron_date_start, #cron_period').val('');
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
				$('#cron_' + cid).fadeOut('slow').addClass('fordel');
				setTimeout ("$('#cron .fordel').remove();", 2000);
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
			$('#mailing_' + sid + ' a.btn').attr('disabled', true).hide();
		},
		success: function(json) {
			$('#statistics .success, .warning, .error').remove();
			if (json['error']) {
				$('#mailing_' + sid + ' a.btn').attr('disabled', false).show();
				$('#mailing_' + sid + ' td.send-subject').empty().append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#mailing_' + sid).fadeOut('slow').addClass('fordel');
				setTimeout ("$('#statistics .fordel').remove();", 2000);
			}
		}
	});
}

function viewmessage(sid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewmessage&sid="+ sid + tokken
	});
}

function viewnewmessage(sid) {
	$.colorbox({
		maxWidth: "85%",
		maxHeight: "85%",
		href: wkdir + "viewnewmessage&sid="+ sid + tokken
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
//--></script>
<script type="text/javascript"><!--
$('.attention .close').live("click", function() {
	$(this).parent().parent().addClass('fordel').fadeOut();
	setTimeout ("$('.attention.fordel').remove();", 2000);
});

$('#attention_toggle').on("click", function(e) {
	$('#attention_block, #send_block').toggleClass('open');

	if($("#send_block").hasClass("open")) {
		$('#send_block').animate({'width': '79%'}, 'slow');
	} else {
		$('#send_block').animate({'width': '100%'}, 'slow');
	}
});

function attshow() {
	if(!$("#send_block").hasClass("open")) {
		$("#attention_block, #send_block").addClass("open");
		$('#send_block').animate({'width': '79%'}, 'slow');
	}
}

function atthide() {
	$("#attention_block, #send_block").removeClass("open");
	$('#send_block').animate({'width': '100%'}, 'slow');
}

$('#region').on("click", function() {
	if($(this).prop('checked')) {
		$('#mail .select-region').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
	} else {
		$('#mail .select-region').animate({'opacity': '0'}, 'slow').hide();
		$('select[name=\'country_id\']').val('0');
		$('select[name=\'zone_id\']').val('0');
	}
});

$('#from_region').on("click", function() {
	if($(this).prop('checked')) {
		$('#newsletter .select-region').css('display', 'inline-block').animate({'opacity': '1'}, 'slow');
	} else {
		$('#newsletter .select-region').animate({'opacity': '0'}, 'slow').hide('slow');
		$('select[name=\'from_country_id\']').val('0');
		$('select[name=\'from_zone_id\']').val('0');
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
			$('#misssend_' + msid + ' a.btn').attr('disabled', true).hide();
		},
		success: function(json) {
			$('.warning, .error').remove();
			if (json['error']) {
				$('#misssend_' + msid + ' a.btn').attr('disabled', false).show();
				$('#misssend_' + msid).after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#misssend_' + msid).fadeOut('slow').addClass('fordel').empty().append('<div style="text-align:center;">' + json['success'] + '</div>').fadeIn('slow');
				setTimeout ("$('.attention.fordel').fadeOut('slow');", 3000);
				setTimeout ("$('.attention.fordel').remove();", 4000);
			}
		}
	});
}

function misstocomplete(msid) {
	$.ajax({
		url: wkdir + 'misstocomplete&msid='+ msid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#misssend_' + msid + ' a.btn').attr('disabled', true).hide();
		},
		success: function(json) {
			$('.success, .warning, .error').remove();
			if (json['error']) {
				$('#misssend_' + msid + ' a.btn').attr('disabled', false).show();
				$('#misssend_' + msid).after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#misssend_' + msid).addClass('fordel').empty().append('<div style="text-align:center;">' + json['success'] + '</div>');
				setTimeout ("$('.attention.fordel').fadeOut('slow');", 3000);
				setTimeout ("$('.attention.fordel').remove();", 4000);
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
				html += '<div class="info-block">'+ json['send_alarm'] + '<br />' + json['send_title'] + '<br />' + json['send_info'] + '</div>';

				html += '<div class="buttons-block">';
				html += ' <a class="btn btn-msend" title="<?php echo $button_missresend; ?>" onclick="missresend(\'index.php?route=sale/contacts/misssend&msid=' + json['send_id'] + '&token=<?php echo $token; ?>\')"></a>';
				html += ' <a class="btn btn-mtocompl" title="<?php echo $button_misstocomplete; ?>" onclick="misstocomplete(' + json['send_id'] + ')"></a>';
				html += ' <a class="btn btn-mremove" title="<?php echo $button_missremove; ?>" onclick="missremove(' + json['send_id'] + ')"></a>';
				
				html += '</div>';
				html += '<div class="close-block"><img src="view/image/contacts/close-icon18.png" class="close" title="<?php echo $button_missclose; ?>" /></div>';
				
				$('#attention_block').append('<div class="attention misssend-attention" id="misssend_'+ json['send_id'] +'" style="display: none;"></div>');
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
			$('#tab-log .success, .warning, .error').remove();
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
				setTimeout ("$('#tab-log .success').fadeOut('slow');", 3000);
				setTimeout ("$('#tab-log .success').remove();", 4000);
			}
		}
	});
}

function clearlog() {
	$.ajax({
		url: wkdir + 'clearlog' + tokken,
		dataType: 'json',
		success: function(json) {
			$('#tab-log .success, .warning, .error').remove();
			if (json['error']) {
				$('.status-log').append('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#logarea').val('');
				$('.status-log').append('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#tab-log .success').fadeIn('slow');
				setTimeout ("$('#tab-log .success').fadeOut('slow');", 3000);
				setTimeout ("$('#tab-log .success').remove();", 4000);
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

function newgroup() {
	$('#group_name, #group_description').val('');
	$('#content_group').fadeIn('slow');
	$('#group .success, .warning, .error').remove();
	$('#save_group').attr('onclick', 'savegroup(0);');
	$('html, body').stop().animate({scrollTop: $('#group').offset().top}, 1000);
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
			$('#group .success, .warning, .error').remove();
			$('#save_group').attr('disabled', true).hide().before(wkwait);
		},
		complete: function() {
			$('#save_group').attr('disabled', false).css('display', 'inline-block');
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
			}
		}
	});
}

function editgroup(gid) {
	$.ajax({
		url: wkdir + 'getsendgroup&group_id='+ gid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#group .success, .warning, .error').remove();
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
		}
	});
}

function delgroup(gid) {
	$.ajax({
		url: wkdir + 'delgroup&group_id='+ gid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#group .success, .warning, .error').remove();
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
				$('#group_' + gid).fadeOut('slow').addClass('fordel');
				setTimeout ("$('#group .fordel').remove();", 2000);
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

function newtemplate() {
	$('#temp_name').val('');
	message2.val('');
	CKEDITOR.instances.message2.setData('');
	$('#content_template').fadeIn('slow');
	$('#template .success, .warning, .error').remove();
	$('#save_template').attr('onclick', 'addnewtemplate();');
	$('html, body').stop().animate({scrollTop: $('#template').offset().top}, 1000);
}

function addnewtemplate() {
	var new_name = $('#temp_name').val();
	message2.val(CKEDITOR.instances.message2.getData());
	$.ajax({
		url: wkdir + 'addnewtemplate' + tokken,
		type: 'post',
		data: $('#template input, #template textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#save_template').attr('disabled', true).after(wkwait);
		},
		complete: function() {
			$('#save_template').attr('disabled', false);
			$('.wait').remove();
			message2.val('');
		},
		success: function(json) {
			$('#template .success, .warning, .error').remove();
			if (json['error']) {
				$('#save_template').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('.notemplates').remove();
				$('#templates tbody').prepend('<tr class="newline" id="template_'+json['template_id']+'"><td class="left">'+new_name+'</td><td class="right"><a onclick="viewtemplate('+json['template_id']+');" class="btn btn-mview" style="margin-right:3px;" title="<?php echo $text_view; ?>"></a><a onclick="deltemplate('+json['template_id']+');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a></td></tr>');
				$('#save_template').attr('onclick', 'savetemplate(' + json['template_id'] + ');').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#template .success').fadeIn('slow');
			}
		}
	});
}

function savetemplate(tplid) {
	message2.val(CKEDITOR.instances.message2.getData());
	var tmpl_name = $('#temp_name').val();
	$.ajax({
		url: wkdir + 'edittemplate&template_id='+ tplid + tokken,
		type: 'post',
		data: $('#template input, #template textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#save_template').attr('disabled', true).hide().after(wkwait);
		},
		complete: function() {
			$('#save_template').attr('disabled', false).css('display', 'inline-block');
			$('.wait').remove();
			message2.val('');
		},
		success: function(json) {
			$('#template .success, .warning, .error').remove();
			if (json['error']) {
				$('#save_template').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('#template_'+tplid+' .left').empty().append(tmpl_name);
				$('#save_template').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#template .success').fadeIn('slow');
			}
		}
	});
}

function addtemplate() {
	var new_name = $('#new_temp_name').val();
	message1.val(CKEDITOR.instances.message1.getData());
	$.ajax({
		url: wkdir + 'addtemplate' + tokken,
		type: 'post',
		data: $('#new_temp_name, #mail textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#savetempl').attr('disabled', true).hide().after(wkwait);
		},
		complete: function() {
			$('#savetempl').attr('disabled', false).css('display', 'inline-block');
			$('.wait').remove();
			message1.val('');
		},
		success: function(json) {
			$('#mail .success, .warning, .error').remove();
			
			if (json['error']) {
				$('#savetempl').after('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('.notemplates').remove();
				$('#templates tbody').prepend('<tr class="newline" id="template_'+json['template_id']+'"><td class="left">'+new_name+'</td><td class="right"><a onclick="viewtemplate('+json['template_id']+');" class="btn btn-mview" style="margin-right:3px;" title="<?php echo $text_view; ?>"></a><a onclick="deltemplate('+json['template_id']+');" class="btn btn-mremove" title="<?php echo $text_delete; ?>"></a></td></tr>');
				$('#savetempl').after('<div class="success" style="display: none;">' + json['success'] + '</div>');
				$('#mail .success').fadeIn('slow');
			}
		}
	});
}

function deltemplate(tplid) {
	$.ajax({
		url: wkdir + 'deltemplate&template_id='+ tplid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('#temp_name').val('');
			message2.val('');
			CKEDITOR.instances.message2.setData('');
			$('#save_template').attr('onclick', '');
			$('#content_template').fadeOut('slow');
		},
		success: function(json) {
			$('#template .success, .warning, .error').remove();
			
			if (json['error']) {
				$('.buttons-add').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				$('#template_' + tplid).fadeOut('slow').addClass('fordel');
				setTimeout ("$('#template .fordel').remove();", 2000);
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
			$('#template .success, .warning, .error').remove();
			$('#temp_name').val('');
			message2.val('');
			editor.setData('');
			$('#content_template').fadeIn('slow');
		},
		success: function(json) {
			$('#temp_name').val(json['name']);
			if (json['message']) {
				if(editor.mode=="wysiwyg") {
					editor.insertHtml(json['message']);
				} else {
					alert('<?php echo $editor_mode_alert; ?>');
				}
			}
			$('#save_template').attr('onclick', 'savetemplate(' + tplid + ');');
			$('html, body').stop().animate({scrollTop: $('#template').offset().top}, 1000);
		}
	});
}

function loadtemplate(tplid) {
	var editor = CKEDITOR.instances.message1;
	$.ajax({
		url: wkdir + 'gettemplate&template_id='+ tplid + tokken,
		dataType: 'json',
		beforeSend: function() {
			$('.success, .warning, .error').remove();
			$('select[name=\'template_id\']').after(wkwait);
			message1.val('');
			editor.setData('');
		},
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
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
	$.ajax({
		url: wkdir +'savesetting'+ tokken,
		type: 'post',
		data: $('#contacts-setting select, #contacts-setting input:text, #contacts-setting input:checked'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-savesetting').attr('disabled', true);
		},
		complete: function() {
			$('#button-savesetting').attr('disabled', false);
		},
		success: function(json) {
			$('.success-setting, .warning, .error').remove();
			
			if (json['error']) {
				$('.buttons-setting').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				$('.warning').fadeIn('slow');
			}
			if (json['success']) {
				$('.buttons-setting').prepend('<div class="success success-setting" style="display: none;">' + json['success'] + '</div>');
				$('.success-setting').fadeIn('slow');
				setTimeout ("$('.success-setting').fadeOut('slow');", 3000);
			}
		}
	});
});

$('select[name=\'from\']').bind('change', function() {
	$('#newsletter .region-block').css('display', 'inline-block');
	$('input[name=\'from_set_region\']').attr('disabled', false).css('display', 'inline-block');
	$('#newsletter .from').hide(200);
	$('#from-' + $(this).attr('value').replace('_', '-')).show(1000);
	if ($(this).attr('value') == 'affiliate' || $(this).attr('value') == 'customer' || $(this).attr('value') == 'manual' || $(this).attr('value') == 'sql_manual' || $(this).attr('value') == 'send_group') {
		$('#newsletter .select-region').hide(200);
		$('input[name=\'from_set_region\']').attr('checked', false).attr('disabled', true);
	}
});

$('select[name=\'to\']').bind('change', function() {
	$('#mail .region-block').css('display', 'inline-block');
	$('input[name=\'set_region\']').attr('disabled', false).css('display', 'inline-block');
	$('input[name=\'control_unsubscribe\']').attr('disabled', false).attr('checked', true);
	$('#mail .to').hide(200);
	$('#to-' + $(this).attr('value').replace('_', '-')).show(1000);
	if ($(this).attr('value') == 'affiliate' || $(this).attr('value') == 'customer' || $(this).attr('value') == 'manual' || $(this).attr('value') == 'send_group') {
		$('#mail .select-region').hide(200);
		$('input[name=\'set_region\']').attr('checked', false).attr('disabled', true);
	}
	if ($(this).attr('value') == 'newsletter') {
		$('input[name=\'control_unsubscribe\']').attr('checked', true).attr('disabled', true);
	}
	if ($(this).attr('value') == 'customer_all') {
		$('input[name=\'control_unsubscribe\']').attr('checked', false).attr('disabled', true);
	}
});

$('select[name=\'to\']').trigger('change');
$('select[name=\'from\']').trigger('change');

$('select[name=\'template_id\']').bind('change', function() {
	var templ = $('select[name=\'template_id\']').val();
	if (templ > 0) {
		loadtemplate(templ);
	} else {
		CKEDITOR.instances.message1.setData('');
		message1.val('');
	}
});

$('select[name=\'template_id\']').trigger('change');

$('select[name=\'country_id\']').bind('change', function() {
	if (this.value > 0) {
		$.ajax({
			url: 'index.php?route=setting/setting/country'+ tokken +'&country_id=' + this.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
			},		
			complete: function() {
				$('.wait').remove();
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
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
				$('select[name=\'from_country_id\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
			},		
			complete: function() {
				$('.wait').remove();
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
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
});

$('select[name=\'from_country_id\']').trigger('change');
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
	nowsend = 1;
	$.ajax({
		url: url,
		dataType: 'json',
		beforeSend: function() {
			$('.success-send, .warning, .error').remove();
			$('.attention').fadeOut();
			$('#button-send, #button-cron, #button-check').attr('disabled', true).hide();
			$('#button-cron').before(wkwait);
			$('#attention_block').prepend('<div class="success wait-text" style="color:red;"><?php echo $text_wait; ?></div>');
			attshow();
		},
		complete: function() {
			$('.wait-text').remove();
		},				
		success: function(json) {
			$('.wait, .success, .attention').remove();
			$('#button-send, #button-cron, #button-check').attr('disabled', false).show();
			
			if (json['error'] != '') {
				for (i = 0; i < json['error'].length; i++) {
					$('#attention_block').append('<div class="warning" style="display: none;">' + json['error'][i] + '</div>');
				}
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
					$('#attention_block').append('<div class="success success-send" style="display: none;">' + json['success'] + '</div>');
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					$('.success').fadeIn('slow');
				} else {
					$('.success').fadeOut('slow');
				}
				nowsend = null;
			}
			
			if (json['stop_send']) {
				updatemisssend(json['stop_send']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

function send(url) {
	nowsend = 1;
	message1.val(CKEDITOR.instances.message1.getData());
	var datta = $('#mail select, #mail input:hidden, #mail input:text, #mail input:checked, #mail textarea').serialize();
	$.ajax({
		url: url,
		type: 'post',
		data: datta,
		dataType: 'json',
		beforeSend: function() {
			$('.success-send, .warning, .error').remove();
			$('.attention').fadeOut();
			$('#button-send, #button-cron, #button-check').attr('disabled', true).hide();
			$('#button-cron').before(wkwait);
			$('#attention_block').prepend('<div class="success wait-text" style="color:red;"><?php echo $text_wait; ?></div>');
			attshow();
		},
		complete: function() {
			$('.wait-text').remove();
		},				
		success: function(json) {
			$('.wait, .success, .attention').remove();
			$('#button-send, #button-cron, #button-check').attr('disabled', false).show();
			
			if (json['error']) {
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
					$('#attention_block').append('<div class="success success-send" style="display: none;">' + json['success'] + '</div>');
					$('.success').fadeIn('slow');
					if (json['check_url']) {
						resultcheck(json['check_url']);
					} else {
						$('#input_upload, #info_files, #button_fclear').empty().hide();
					}
				} else {
					$('.success').fadeOut('slow');
				}
				nowsend = null;
			}
			
			if (json['stop_send']) {
				updatemisssend(json['stop_send']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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

$('#content_template').fadeOut('slow');

$('#button_fclear').on('click', function() {
	$(this).hide();
	$('.success-upload').remove();
	$('#input_upload, #info_files, #warning_upload').empty().hide();
});

$('#button_select').on('click', function() {
	$('#input_upload').click();
});
 
$('#input_upload').change(function(){
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
            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
        }
    });
});
//--></script>
<?php echo $footer; ?>
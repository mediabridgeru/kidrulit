<?php
/*
    @author: Igor Mirochnik
    @copyright:  Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
*/

?>
<?php 

	if (!function_exists('echoText'))
	{
		function echoText($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				echo $lang_settings[$lang_id][$name];
			}
			else {
				echo $lang_settings['default'][$name];
			}
		}
	}

	if (!function_exists('echoTextArea'))
	{
		function echoTextArea($lang_settings, $lang_id, $name) {
			if (isset($lang_settings[$lang_id])) {
				echo $lang_settings[$lang_id][$name];
			}
			else {
				echo $lang_settings['default'][$name];
			}
		}
	}
	
	if (!function_exists('echoSelectss'))
	{
		function echoSelectss($lang_settings, $lang_id, $name, $val) {
			$is_selected = false;
			if (isset($lang_settings[$lang_id])) {
				$is_selected = ('' . $lang_settings[$lang_id][$name] == '' . $val);
			}
			else {
				$is_selected = ('' . $lang_settings['default'][$name] == '' . $val);
			}
			
			echo $is_selected ? 'selected="selected"' : '';
		}
	}
	
	if (!function_exists('echoSelect'))
	{
		// Формирование html select
		function echoSelect($name, $data, $curr_val, $append_class = '', 
							$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			$result = '<select name="' . $name . '" ' 
						. ' class="form-control ' . $append_class . '" '
						. ($is_multi ? ' multiple="multiple" ' : '') 
				. ' >';
			
			foreach($data as $key => $item)
			{
				$result .= '<option value="' . $item[$val_name] . '" '
							. (('' . $item[$val_name] == $curr_val )? ' selected="selected" ' : '')	. '>'
						. $item[$text_name]
					. '</option>';
			}
			
			return $result . '</select>';
		}
	}
	
	// 1.3.0
	if (!function_exists('echoSelectMonth'))
	{
		// Месяца
		function echoSelectMonth($module_months, $name, $curr_val, $append_class = '')
		{
			$result = '<select name="' . $name . '" ' 
						. ' class="form-control ' . $append_class . '" '
				. ' >';
			
			$data = array(
				array('id' => 1, 'name' => 'Январь'),
				array('id' => 2, 'name' => 'Февраль'),
				array('id' => 3, 'name' => 'Март'),
				array('id' => 4, 'name' => 'Апрель'),
				array('id' => 5, 'name' => 'Май'),
				array('id' => 6, 'name' => 'Июнь'),
				array('id' => 7, 'name' => 'Июль'),
				array('id' => 8, 'name' => 'Август'),
				array('id' => 9, 'name' => 'Сентябрь'),
				array('id' => 10, 'name' => 'Октябрь'),
				array('id' => 11, 'name' => 'Ноябрь'),
				array('id' => 12, 'name' => 'Декабрь'),
			);

			if (isset($module_months) && is_array($module_months))
			{
				for($cnt = 0; $cnt < count($module_months); $cnt++)
				{
					if ($cnt < count($data))
					{
						$data[$cnt]['name'] = $module_months[$cnt];
					}
				}
			}
			
			foreach($data as $key => $item)
			{
				$result .= '<option value="' . $item['id'] . '" '
							. (('' . $item['id'] == $curr_val )? ' selected="selected" ' : '')	. '>'
						. $item['name']
					. '</option>';
			}
			
			return $result . '</select>';
		}
	}

	if (!function_exists('echoSelectYear'))
	{
		// Года
		function echoSelectYear($name, $curr_val, $append_class = '')
		{
			$result = '<select name="' . $name . '" ' 
						. ' class="form-control ' . $append_class . '" '
				. ' >';

			for ($cnt = 1990; $cnt <= 2050; $cnt++)		
			{
				$result .= '<option value="' . $cnt . '" '
							. (('' . $cnt == $curr_val )? ' selected="selected" ' : '')	. '>'
						. $cnt
					. '</option>';
			}
			
			return $result . '</select>';
		}
	}
	
	if (!function_exists('label'))
	{
		function label($module_label, $name)
		{
			if (isset($module_label)) {
			    if (is_array($module_label)) {
			        if (isset($module_label[$name])) {
			            return $module_label[$name];
					}
			    }
			}
		    return $name;
		}
	}
?>

<!-- ------------ -->
<!-- Stock Control Set -->
<!-- ------------ -->
<div class="tab-pane" id="stock_control_set">
	<form class="form" 
		action="<?php echo $report_links['stock_control_set']; ?>" method="post" 
		actionsave = "<?php echo $report_links['stock_control_set_data']; ?>"
		enctype="multipart/form-data" 
		id="form_stock_control_set"
	>
		<input type="hidden" name="IMReport[language_id]" value="<?php echo $language_id; ?>" />
		<div class="well">
			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_filter_cat'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[cat][]', $list_cat, '', 'filter-category', true); ?>
				  </div>
				  <!-- Main Category start -->
				  <?php
				  	if ($is_have_main_caterogy)
				  	{
				  ?>
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_main_category'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[cat_main]', $list_cat_main, ''); ?>
				  </div>
				  <?php
					}
				  ?>
				  <!-- Main Category end -->
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_filter_manufact'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[manufact][]', $list_manufact, '', '', true); ?>
				  </div>

				</div>
				<div class="col-sm-6">
				  	<div class="form-group">
					    <label class="control-label" for="input-date-start">
					    	<?php echo label($module_label, 'label_filter_date_start'); ?>
					    </label>
					    <div class="input-group date">
					      	<input type="text" name="IMReport[filter_date_start]" 
					      		value="<?php echo date('d.m.Y'); ?>" 
					      		placeholder="<?php echo label($module_label, 'label_filter_date_start'); ?>" 
					      		data-date-format="DD.MM.YYYY" 
					      		class="form-control"/>
					      	<span class="input-group-btn">
					      	<button type="button" class="btn btn-default">
					      		<i class="fa fa-calendar"></i>
					      	</button>
					      	</span>
					    </div>
				  	</div>
				  	<div class="form-group">
					    <label class="control-label" for="input-date-end">
					    	<?php echo label($module_label, 'label_filter_date_end'); ?>
					    </label>
					    <div class="input-group date">
					      	<input type="text" name="IMReport[filter_date_end]" 
					      		value="<?php echo date('d.m.Y'); ?>" 
					      		placeholder="<?php echo label($module_label, 'label_filter_date_end'); ?>" 
					      		data-date-format="DD.MM.YYYY" 
					      		class="form-control"/>
					      	<span class="input-group-btn">
					      	<button type="button" class="btn btn-default">
					      		<i class="fa fa-calendar"></i>
					      	</button>
					      	</span>
					    </div>
				  	</div>
				</div>
				<div class="col-sm-12 report-btn-group">
					<button type="button"  
					  		class="btn btn-warning pull-right button-save">
						<i class="fa fa-save"></i> 
					  	<?php echo $module_button['button_save']; ?>
					</button>
					<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<button type="button"  
					  		class="btn btn-primary pull-right button-filter">
						<i class="fa fa-search"></i> 
					  	<?php echo $module_button['button_filter']; ?>
					</button>
					<span id="save_status_stock_control_set"></span>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-results">
				<thead>
					<tr>
						<?php if ($is_product_image_display) { ?>
							<th><i class="fa fa-camera"></i></th>
						<?php } ?>
						<th><?php echo label($module_table_header, 'table_stock_control_set_name'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_option'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_cat'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_model'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_manufact'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_subtract'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_curr_count'); ?></th>
						<th><?php echo label($module_table_header, 'table_stock_control_set_need_count'); ?></th>
					</tr>	
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</form>
</div>

<script type="text/javascript">
	
	var link_to_product = "<?php echo $report_links['link_to_product'];  ?>",
		link_to_category = "<?php echo $report_links['link_to_category'];  ?>",
		link_to_stock_control_set_data = "<?php echo $report_links['stock_control_set_data'];  ?>",
		// customer_id
		link_to_client = "<?php echo $report_links['link_to_client'];  ?>",
		table_footer_all = "<?php echo label($module_table_header, 'table_footer_all');  ?>",
		previousPoint = null, 
		previousLabel = null,
		// 2.1.0
		is_product_image_display = <?php echo $is_product_image_display; ?>
	;
	
	function IMR_loadStockControlSet(form) {
		imrep.setTextStatus(form, {
			selector: '#save_status_stock_control_set',
			text: ajaxStatusSpan.getData
		});
		
		jQuery.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serializeArray(),
			dataType: 'json',
			success: function (json) {
				if (json['success']) {
					imrep.setTextSuccess(form, {
						selector: '#save_status_stock_control_set',
						text: ajaxStatusSpan.ok
					});
					
					var tbody = form.find('table.table-results tbody'),
						last_id = -1,
						all_count = 0,
						all_need_count = 0,
						all_curr_count = 0,
						cntDataRow = 0,
						all_cost = new Number(0)
					;
					
					tbody.html('');
					
					// Заполняем таблицу данными
					for (var cnt = 0; cnt < json['data'].length; cnt++) {
						var item = json['data'][cnt],
							countRow 
								= tbody.find('tr[id="id-' 
												+ item['product_id'] 
												+ '-' 
												+ item['product_option_value_id'] + '"]').length
						;
						
						if (countRow == 0) {
							var row = jQuery('<tr>'),
								pattern = json['currency_pattern'],
								is_option = parseInt(item['product_option_value_id']) > 0;
							;
							
							row.prop('id', 'id-' + item['product_id'] + '-' + item['product_option_value_id']);
							
							tbody.append(row);
							
							all_count += 
								is_option
								? parseInt(item['product_option_value_quantity'])
								: parseInt(item['product_quantity'])
							;
							
							all_need_count += parseInt(item['need_quantity']);
							
							row.html(
								(is_product_image_display
									? (
										'<td class="text-center">'
											+ '<img src="' + item['product_image_mini'] + '" />'
										+ '</td>'
									)
									: ''
								)
								+ '<td class="text-left">'
									+ formLink(link_to_product, item['product_name'], 
												'product_id', item['product_id'])
								+ '</td>'
								+ '<td class="text-left">'
									+ ( is_option
										? ( item['option_name'] + ' &gt; ' + item['option_value_name'])
										: ''
									)
								+ '</td>'
								+ '<td class="text-left category">'
									+ (item['category_id'] 
										? IMR_formLink(link_to_category, 
												jQuery(form
													.find('select.filter-category option[value="' 
															+ item['category_id'] + '"]')
												).text(), 
												'category_id', item['category_id'])
										: '')
								+ '</td>'
								+ '<td class="text-left">'
									+ item['model'] //decodeURIComponent(item['model'])
								+ '</td>'
								+ '<td class="text-left">'
									+ (item['manufact'] == 'null' || !item['manufact']
										? ''
										: item['manufact']) //decodeURIComponent(item['manufact']))
								+ '</td>'
								+ '<td class="text-right">'
									+ ( is_option
										? (parseInt(item['product_option_value_subtract']) > 0 
											? tableFieldStatus.on 
											: tableFieldStatus.off
										)
										: (parseInt(item['product_subtract']) > 0 
											? tableFieldStatus.on 
											: tableFieldStatus.off
										)
									)
								+ '</td>'
								+ '<td class="text-right">'
									+ ( is_option
										? parseInt(item['product_option_value_quantity'])
										: parseInt(item['product_quantity'])
									)
								+ '</td>'
								+ '<td class="text-right input-style-min">'
									+ '<input type="text" '
										+ ' class="form-control text-right" '
										+ ' name="IMReport[array_need_quantity][' + cntDataRow + '][need]" '
										+ ' value="' + item['need_quantity'] + '" '
									+ '/>'
									+ '<input type="hidden" '
										+ ' name="IMReport[array_need_quantity][' + cntDataRow + '][product_id]" '
										+ ' value="' + item['product_id'] + '" '
									+ '/>'
									+ '<input type="hidden" '
										+ ' name="IMReport[array_need_quantity][' + cntDataRow + '][product_option_value_id]" '
										+ ' value="' + item['product_option_value_id'] + '" '
									+ '/>'
									+ '<span class="need-info">' 
										+ item['need_quantity'] 
									+ '</span>'
								+ '</td>'
							);
							
							cntDataRow++;
						}
						else {
							var row = tbody.find('tr[id="id-' 
												+ item['product_id'] 
												+ '-' 
												+ item['product_option_value_id'] + '"]'),
								cellCat = row.find('td.category')
							;
							
							cellCat.html(
								cellCat.html()
								+ (item['category_id'] 
										? '<br/>' 
											+ IMR_formLink(link_to_category, 
												jQuery(form
													.find('select.filter-category option[value="' 
															+ item['category_id'] + '"]')
												).text(), 
												'category_id', item['category_id'])
										: '')
							);
						}
					}
					
					all_curr_count = all_count;
					
					//tuneUpTable(form, 5, ('' + all_curr_count + ' ( ' + all_need_count + ' ) '), 0, json['currency_pattern'], true, true);
					IMR_tuneUpTable(form, {
						colspan: 5 + (!!is_product_image_display),
						count: ('' + all_curr_count + ' ( ' + all_need_count + ' ) '),
						cost: 0,
						pattern: json['currency_pattern'],
						not_need_cost: true,
						not_need_footer: true,
						num_rows_displayed: module_config.user.table_default_num_rows_displayed
					});
					
				} else {
					imrep.setTextFail(form, {
						selector: '#save_status_stock_control_set',
						text: ajaxStatusSpan.fail
					});
				}
			}
		});
	}
	
	function IMR_stockControlSetData(form)
	{
		imrep.setTextStatus(form, {
			selector: '#save_status_stock_control_set',
			text: ajaxStatusSpan.getData
		});
		
		jQuery.ajax({
			url: form.attr('actionsave'),
			type: 'post',
			//data: form.serializeArray(),
			data: $.tablesorter.serializeArray(form.find('table.table-results')),
			dataType: 'json',
			success: function (json) {
				if (json['success']) {
					// Перезагрузка формы
					IMR_loadStockControlSet(form);
					
				} else {
					imrep.setTextFail(form, {
						selector: '#save_status_stock_control_set',
						text: ajaxStatusSpan.fail
					});
				}
			}
		});
	}
	
	
	jQuery(function () {
		jQuery('#form_stock_control_set button.button-save').click(function () {
			IMR_stockControlSetData(jQuery(this).closest('form'));
		});
	});
				
	
</script>
<!-- --------------------------------------------------- -->
<!-- OpenCart Style End -->
<!-- --------------------------------------------------- -->

<style type="text/css">

	/* Fix */
	
	#header .div3 img
	{
		vertical-align:baseline;
	}
	
	#menu > ul li li
	{
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
		min-height: 27px;
		min-width: 155px;
		margin: 0px;
	}

	#menu > ul li li a
	{
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	
	#menu > ul li ul ul
	{
		margin-top: -27px;
	}
	
	.breadcrumb
	{
		margin-bottom: 0px;
	}
	
	.breadcrumb a
	{
		text-decoration: underline;
	}
	
	.form-group 
	{
	    padding-top: 15px;
	    padding-bottom: 15px;
	    margin-bottom: 0;
	}
	
	/* Fix End */
	
	.form-group span.blue
	{
		color: #000042;
    	font-size: 15px;
	}
	
	table.table-results tfoot td
	{
		font-weight: bold;
	}
	
	#form_stock_control_set table.table-results tbody tr input.form-control 
	{
	    line-height: 10px;
	    height: 25px;
	    margin-top: -3px;
	    max-width: 70px;
		display: inline-block;
		float: left;
	}
	
	#form_stock_control_set table.table-results tbody tr span.need-info
	{
		display: inline-block;
		padding-left: 6px;
		color: #3C8EBB;
	}
	
	#save_status_stock_control_set.success
	{
    	color: green;
	    top: 10px;
	    position: relative;
	}

	#save_status_stock_control_set.fail
	{
    	color: red;
	    top: 10px;
	    position: relative;
	}

	.imreport-order-sales
	{
		width: 100%; 
		height: 260px; 
		position: relative; 
		overflow: hidden; 
		background-color: rgb(255, 255, 255);
	}

</style>

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
<!-- Client Orders -->
<!-- ------------ -->
<div class="tab-pane" id="client_orders">
	<form class="form" 
		action="<?php echo $report_links['client_orders']; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_client_orders"
	>
		<input type="hidden" name="IMReport[language_id]" value="<?php echo $language_id; ?>" />
		<div class="well">
			<div class="row">
				<div class="col-sm-3">
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_filter_order_status'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[order_status][]', $list_order_status, '', '', true); ?>
				  </div>
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'list_client_orders_modes'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[client_orders_modes]', $list_client_orders_modes, '', ''); ?>
				  </div>
				</div>
				<div class="col-sm-3">
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_filter_order_status_last'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[order_status_last][]', $list_order_status, '', '', true); ?>
				  </div>
				  <div class="form-group">
				    <label class="control-label">
				    	<?php echo label($module_label, 'label_filter_order_status_all'); ?>
				    </label>
				    <?php echo echoSelect('IMReport[order_status_all][]', $list_order_status, '', '', true); ?>
				  </div>
			   </div>
			  <div class="col-sm-3">
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
			  </div>
			  <div class="col-sm-3">
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
			  <div class="col-sm-3">
			  	<div class="form-group">
				    <label class="control-label" for="input-date-start">
				    	<?php echo label($module_label, 'label_filter_date_reg_start'); ?>
				    </label>
				    <div class="input-group date">
				      	<input type="text" name="IMReport[filter_date_reg_start]" 
				      		value="<?php echo date('d.m.Y'); ?>" 
				      		placeholder="<?php echo label($module_label, 'label_filter_date_reg_start'); ?>" 
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
			  <div class="col-sm-3">
			  	<div class="form-group">
				    <label class="control-label" for="input-date-end">
				    	<?php echo label($module_label, 'label_filter_date_reg_end'); ?>
				    </label>
				    <div class="input-group date">
				      	<input type="text" name="IMReport[filter_date_reg_end]" 
				      		value="<?php echo date('d.m.Y'); ?>" 
				      		placeholder="<?php echo label($module_label, 'label_filter_date_reg_end'); ?>" 
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
					  		class="btn btn-success pull-right button-csv">
						<i class="fa fa-copy"></i> 
					  	<?php echo $module_button['button_csv']; ?>
					</button>
					<span class="pull-right">&nbsp;&nbsp;&nbsp;</span>
					<button type="button"  
					  		class="btn btn-primary pull-right button-filter">
						<i class="fa fa-search"></i> 
					  	<?php echo $module_button['button_filter']; ?>
					</button>
					<span id="save_status_client_orders"></span>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-results">
				<thead>
					<tr>
						<th><?php echo label($module_table_header, 'table_client_orders_name'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_email'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_phone'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_city'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_status'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_date_added'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_last_order'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_count_all'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_cost_all'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_count'); ?></th>
						<th><?php echo label($module_table_header, 'table_client_orders_cost'); ?></th>
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
		// customer_id
		link_to_client = "<?php echo $report_links['link_to_client'];  ?>",
		// order_id
		link_to_order =  "<?php echo $report_links['link_to_order'];  ?>",
		table_footer_all = "<?php echo label($module_table_header, 'table_footer_all');  ?>",
		previousPoint = null, 
		previousLabel = null,
		// 1.3.0
		clientOrdersStatus = {
			on: "<?php echo label($module_label, 'label_enabled');  ?>",
			off: "<?php echo label($module_label, 'label_disabled');  ?>"
		}
	;
	
	function IMR_loadClientOrders(form) {
		imrep.setTextStatus(form, {
			selector: '#save_status_client_orders',
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
						selector: '#save_status_client_orders',
						text: ajaxStatusSpan.ok
					});
					
					var tbody = form.find('table.table-results tbody'),
						all_count = 0,
						all_cost = new Number(0)
					;
					
					tbody.html('');
					
					// Заполняем таблицу данными
					for (var cnt = 0; cnt < json['data'].length; cnt++) {
						var item = json['data'][cnt];
						
						var row = jQuery('<tr>'),
							pattern = json['currency_pattern']
						;
						
						tbody.append(row);

						all_count += parseInt(item['count']);
						all_cost += new Number(item['cost']);
						
						row.html(
							'<td class="text-left">'
								+ IMR_formLink(link_to_client, item['name'], 
										'customer_id', item['customer_id'])
							+ '</td>'
							+ '<td class="text-left">'
								+ item['email']
							+ '</td>'
							+ '<td class="text-left">'
								+ item['telephone']
							+ '</td>'
							+ '<td class="text-left">'
								+ item['city']
							+ '</td>'
							+ '<td class="text-left">'
								+ ('' + item['status'] == '1' ? clientOrdersStatus.on : clientOrdersStatus.off)
							+ '</td>'
							+ '<td class="text-left">'
								+ IMR_toDate(item['date_added'])
							+ '</td>'
							+ '<td class="text-right">'
								+ ('' + item['last_order'] != '0' && '' + item['last_order'] != 'null'
									? IMR_formLink(link_to_order, 
										item['last_order'] + ' # ' + IMR_toDate(item['last_order_date']) + '  ', 
										'order_id', item['last_order'])
									: '')
							+ '</td>'
							+ '<td class="text-right">'
								+ item['count_all']
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost_all']).toFixed(2)))
							+ '</td>'
							+ '<td class="text-right">'
								+ item['count']
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
							+ '</td>'
						);
					}
					
					//tuneUpTable(form, 9, all_count, all_cost, json['currency_pattern']);
					IMR_tuneUpTable(form, {
						colspan: 9,
						count: all_count,
						cost: all_cost,
						pattern: json['currency_pattern'],
						num_rows_displayed: module_config.user.table_default_num_rows_displayed
					});
				} else {
					imrep.setTextFail(form, {
						selector: '#save_status_client_orders',
						text: ajaxStatusSpan.fail
					});
				}
			}
		});
	}
				
	
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
	
	#save_status_client_orders.success
	{
    	color: green;
	    top: 10px;
	    position: relative;
	}

	#save_status_client_orders.fail
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

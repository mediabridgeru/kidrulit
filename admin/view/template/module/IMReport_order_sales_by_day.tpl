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
<!-- Order Payment Shipping -->
<!-- ------------ -->
<div class="tab-pane" id="order_sales_by_day">
	<form class="form"
		action="<?php echo $report_links['order_sales_by_day']; ?>" method="post"
		enctype="multipart/form-data"
		id="form_order_sales_by_day"
	>
		<input type="hidden" name="IMReport[language_id]" value="<?php echo $language_id; ?>" />
		<div class="well">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">
							<?php echo label($module_label, 'label_filter_order_status'); ?>
						</label>
						<?php echo echoSelect('IMReport[order_status][]', $list_order_status, '', '', true); ?>
					</div>
					<div class="form-group">
						<label class="control-label">
							<?php echo label($module_label, 'label_filter_cat'); ?>
						</label>
						<?php echo echoSelect('IMReport[cat][]', $list_cat,
												'', 'filter-category', true); ?>
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
				</div>
				<div class="col-sm-6">
						<div class="form-group">
								<label class="control-label">
									<?php echo label($module_label, 'label_filter_manufact'); ?>
								</label>
								<?php echo echoSelect('IMReport[manufact][]', $list_manufact,
														'', '', true); ?>
						</div>
				  	<div class="form-group">
					    <label class="control-label" for="input-date-start">
					    	<?php echo label($module_label, 'label_filter_date_start'); ?>
					    </label>
					    <div class="input-group date">
					      	<input type="text" name="IMReport[filter_date_start]"
					      		value="<?php
											echo date('d.m.Y', strtotime("-" . (int)($module_config['user']['report_order_sales_by_day_num']) . " day"));
										?>"
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
					<span id="save_status_order_sales_by_day"></span>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="imreport-order-sales-by-day"></div>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered table-results">
				<thead>
					<tr>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_date_added'); ?></th>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_cost_sub'); ?></th>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_cost_ship'); ?></th>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_cost_diff'); ?></th>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_count'); ?></th>
						<th><?php echo label($module_table_header, 'table_order_sales_by_day_cost'); ?></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</form>
</div>

<script type="text/javascript">

	var link_to_sale_order = "<?php echo $report_links['link_to_sale_order'];  ?>",
		table_footer_all = "<?php echo label($module_table_header, 'table_footer_all');  ?>",
		previousPoint = null,
		previousLabel = null,
		orderSalesByDayGraph = {
			'cost_sub': "<?php echo label($module_table_header, 'table_order_sales_by_day_cost_sub');  ?>",
			'cost_ship': "<?php echo label($module_table_header, 'table_order_sales_by_day_cost_ship');  ?>",
			'cost_diff': "<?php echo label($module_table_header, 'table_order_sales_by_day_cost_diff');  ?>",
			'count': "<?php echo label($module_table_header, 'table_order_sales_by_day_count');  ?>",
			'cost': "<?php echo label($module_table_header, 'table_order_sales_by_day_cost');  ?>"
		}
	;

	function IMR_loadOrderSalesByDayGraph(form, data, pattern) {
		if (data.length < 1)
			return;

		(window.graphStorage = (graphStorage || {})).order_sales_by_day = [];

		var cloneData = $.extend(true, {}, data),
			series = [{
				data: [],
				label: orderSalesByDayGraph.count, //'Количество',
				color: 1,
				yaxis: 1,
				bars: {
					show: true,
					fill: true,
					fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.9}] },
					align: "center",
				}
			}, {
				data: [],
				label: orderSalesByDayGraph.cost_sub, //'Цена',
				color: 2,
				yaxis: 2,
				points: { show: true, radius: 2 },
				lines: {
					show: true,
					fill: true,
					fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.0}] }
				}
			}, {
				data: [],
				label: orderSalesByDayGraph.cost_ship, //'Цена',
				color: 3,
				yaxis: 2,
				//points: { show: true },
				lines: {
					show: true,
					fill: true,
					fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.0}] }
				}
			}, {
				data: [],
				label: orderSalesByDayGraph.cost_diff, //'Цена',
				color: 4,
				yaxis: 2,
				//points: { show: true },
				lines: {
					show: true,
					fill: true,
					fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.0}] }
				}
			}, {
				data: [],
				label: orderSalesByDayGraph.cost, //'Цена',
				color: 5,
				yaxis: 2,
				//points: { show: true },
				lines: {
					show: true,
					fill: true,
					fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.0}] }
				}
			}],
			ticks = []
		;

		for (var cnt = 0; cnt < data.length; cnt++)
		{
			series[0].data.push([ cnt, data[cnt]['count'] ]);
			series[1].data.push([ cnt, data[cnt]['cost_sub'] ]);
			series[2].data.push([ cnt, data[cnt]['cost_ship'] ]);
			series[3].data.push([ cnt, data[cnt]['cost_diff'] ]);
			series[4].data.push([ cnt, data[cnt]['cost'] ]);
			graphStorage.order_sales_by_day.push({
				date_added: IMR_toDateOnly(data[cnt]['date_added']),
				count: data[cnt]['count'],
				cost_sub: data[cnt]['cost_sub'],
				cost_ship: data[cnt]['cost_ship'],
				cost_diff: data[cnt]['cost_diff'],
				cost: data[cnt]['cost']
			});
			if (data.length <= 7) {
				ticks.push(cnt);
			} else {
				var moduleVal = parseInt(data.length / 7);
				if (cnt % moduleVal == 0)
					ticks.push(cnt);
			}
		}

		jQuery('form .imreport-order-sales-by-day').plot(series, {
			xaxis: {
				reserveSpace: true,
				alignTicksWithAxis: 1,
				position: 'bottom',
				ticks: ticks,
				tickFormatter: function (val, axis) {
					return IMR_toDateOnly(data[val]['date_added']);
				}
			},
			yaxes: [{
				reserveSpace: true,
				position: 'left'
			}, {
				alignTicksWithAxis: 1,
				reserveSpace: true,
				position: 'right',
				tickFormatter: function (val, axis) {
					return pattern.replace('[digit]', (new Number(val).toFixed(2)));
				}
			}],
			grid: {
				borderColor: '#E7E7E7',
				aboveData: false,
				hoverable: true,
				mouseActiveRadius: 50,
				axisMargin: 20
			}
		});

		var showTooltip = function (x, y, color, contents) {
			$('<div id="imreport-order-sales-by-day-tooltip">' + contents + '</div>').css({
					position: 'absolute',
					display: 'none',
					top: y - 120,
					left: x - 50,
					border: '1px solid ' + color,
					padding: '5px 10px',
					'font-size': '11px',
					'background-color': '#fff',
					'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
					opacity: 0.9
				}).appendTo("body").fadeIn(200);
		}

		jQuery('form .imreport-order-sales-by-day').bind('mouseout', function (event, pos, item) {
			$("#imreport-order-sales-by-day-tooltip").remove();
			previousPoint = null;
		});

		jQuery('form .imreport-order-sales-by-day').bind('plothover', function (event, pos, item) {
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					previousLabel = item.series.label;
					$("#imreport-order-sales-by-day-tooltip").remove();

					var x = item.datapoint[0],
						y = item.datapoint[1],
						seriesIndex = item.seriesIndex
					;

					var color = item.series.color;

					var tooltip_text =
						'<strong style="text-decoration: underline;">'
							+ IMR_toDateOnly(graphStorage.order_sales_by_day[x]['date_added'])
						+ "</strong>"
						+ "<br/>"
						+ "<strong style=\"color: #127aa4;\">" + orderSalesByDayGraph.count + "</strong>"
						+ ": <strong style=\"color: #127aa4;\">" + graphStorage.order_sales_by_day[x]['count'] + "</strong>"
						+ "<br/>"
						+ "<strong>" + orderSalesByDayGraph.cost_sub + "</strong>"
						+ ": <strong>"
							+ pattern.replace('[digit]', (new Number(graphStorage.order_sales_by_day[x]['cost_sub']).toFixed(2)))
						+ "</strong>"
						+ "<br/>"
						+ "<strong>" + orderSalesByDayGraph.cost_ship + "</strong>"
						+ ": <strong>"
							+ pattern.replace('[digit]', (new Number(graphStorage.order_sales_by_day[x]['cost_ship']).toFixed(2)))
						+ "</strong>"
						+ "<br/>"
						+ "<strong>" + orderSalesByDayGraph.cost_diff + "</strong>"
						+ ": <strong>"
							+ pattern.replace('[digit]', (new Number(graphStorage.order_sales_by_day[x]['cost_diff']).toFixed(2)))
						+ "</strong>"
						+ "<br/>"
						+ "<strong style=\"color: green;\">" + orderSalesByDayGraph.cost + "</strong>"
						+ ": <strong style=\"color: green;\">"
							+ pattern.replace('[digit]', (new Number(graphStorage.order_sales_by_day[x]['cost']).toFixed(2)))
						+ "</strong>"
					;

					showTooltip(pos.pageX, pos.pageY, color, tooltip_text);
				} else {
					$("#imreport-order-sales-by-day-tooltip").css({
						top: pos.pageY - 120,
						left: pos.pageX - 50,
					});
				}
			}
		});

		jQuery('#module_reports a.menu-order-sales-by-day').bind('shown.bs.tab', function (e) {
			jQuery('form .imreport-order-sales-by-day').plot(series, {
				xaxis: {
					reserveSpace: true,
					alignTicksWithAxis: 1,
					position: 'bottom',
					ticks: ticks,
					tickFormatter: function (val, axis) {
						return IMR_toDateOnly(data[val]['date_added']);
					}
				},
				yaxes: [{
					reserveSpace: true,
					position: 'left'
				}, {
					alignTicksWithAxis: 1,
					reserveSpace: true,
					position: 'right',
					tickFormatter: function (val, axis) {
						return pattern.replace('[digit]', (new Number(val).toFixed(2)));
					}
				}],
				grid: {
					borderColor: '#E7E7E7',
					aboveData: false,
					hoverable: true,
					mouseActiveRadius: 50,
					axisMargin: 20
				}
			});
			jQuery('#module_reports a.menu-order-sales-by-day').unbind('shown.bs.tab');
		});
	}

	function IMR_loadOrderSalesByDay(form) {
		imrep.setTextStatus(form, {
			selector: '#save_status_order_sales_by_day',
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
						selector: '#save_status_order_sales_by_day',
						text: ajaxStatusSpan.ok
					});

					var tbody = form.find('table.table-results tbody'),
						last_id = -1,
						all_count = 0,
						all_cost = new Number(0),
						all_cost_sub = new Number(0),
						all_cost_ship = new Number(0),
						all_cost_diff = new Number(0)
					;

					tbody.html('');

					// Заполняем таблицу данными
					for (var cnt = 0; cnt < json['data'].length; cnt++) {
						var item = json['data'][cnt]
						;

						var row = jQuery('<tr>'),
							pattern = json['currency_pattern'],
							is_option = parseInt(item['product_option_value_id']) > 0;
						;

						tbody.append(row);

						all_cost += new Number(item['cost']);
						all_cost_sub += new Number(item['cost_sub']);
						all_cost_ship += new Number(item['cost_ship']);
						all_cost_diff += new Number(item['cost_diff']);
						all_count += parseInt(item['count']);

						row.html(
							'<td class="text-left">'
								+ IMR_formLink( link_to_sale_order, IMR_toDateOnly(item['date_added']),
										'filter_date_added', item['date_added'] )
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost_sub']).toFixed(2)))
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost_ship']).toFixed(2)))
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost_diff']).toFixed(2)))
							+ '</td>'
							+ '<td class="text-right">'
								+ item['count']
							+ '</td>'
							+ '<td class="text-right">'
								+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
							+ '</td>'
						);

					}

					//tuneUpTable(form, 6, all_count, all_cost, json['currency_pattern'], false, false, true);
					IMR_tuneUpTable(form, {
						colspan: 1,
						count: all_count,
						cost: all_cost,
						pattern: json['currency_pattern'],
            num_rows_displayed: module_config.user.table_default_num_rows_displayed,
						footer_fields: [
							{ val: all_cost_sub, is_cost: true },
							{ val: all_cost_ship, is_cost: true },
							{ val: all_cost_diff, is_cost: true }
						]
					});
					IMR_loadOrderSalesByDayGraph(form, json['data'], json['currency_pattern']);
				} else {
					imrep.setTextFail(form, {
						selector: '#save_status_order_sales_by_day',
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
	.imreport-order-sales-by-day
	{
		width: 100%;
		height: 260px;
		position: relative;
		overflow: hidden;
		background-color: rgb(255, 255, 255);
	}

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

	#save_status_order_ps.success
	{
    	color: green;
	    top: 10px;
	    position: relative;
	}

	#save_status_order_ps.fail
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

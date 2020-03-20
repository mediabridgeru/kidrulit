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
<?php echo $header; ?><?php //echo $column_left; ?>

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
	
	// 1.7.0
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


	// Распечатка js текстов
	if (!function_exists('echoModuleJSText'))
	{
		function echoModuleJSText($data)
		{
			if (!isset($data) || !is_array($data) || count($data) == 0) {
				return '';
			}
			
			$resultArray = array();
			
			foreach($data as $key => $item) {
				$resultArray[] = '\'' . $key . '\'' . ': \'' . $item . '\'';
			}
			
			return join(", ", $resultArray);
		}
	}

?>

<div id="content">
	<!--<div class="container-fluid page-header">-->
		<div class="breadcrumb">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php echo $breadcrumb['separator']; ?>
		  			<a href="<?php echo $breadcrumb['href']; ?>">
		  		<?php echo $breadcrumb['text']; ?></a>
		  	<?php } ?>
		</div>
	<!--</div>-->

	<?php 
		if (isset($error_messages) && is_array($error_messages)) { 
			foreach($error_messages as $err) {
	?>
			<div class="container-fluid">
				<div class="alert alert-danger">
					<?php echo $err; ?>
				</div>
			</div>
	<?php 
			}
		} 
	?>

	<?php 
		if (isset($warning_messages) && is_array($warning_messages)) { 
			foreach($warning_messages as $err) {
	?>
			<div class="container-fluid">
				<div class="alert alert-warning">
					<?php echo $err; ?>
				</div>
			</div>
	<?php 
			}
		} 
	?>

	<div class="box">
		<div class="container-fluid">
		  	<div class="heading">
				<h3>
					<?php echo $h1_text; ?>
				</h3>
				<br/>
		  	</div>
		</div>
	  	<div style="clear:both;"></div>
		<div class="content IMReport" >
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style Start -->
			<!-- --------------------------------------------------- -->
			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-pills" id="module_reports">
							<li>
								<a href="#order_sales" data-toggle="tab">
									<i class="fa fa-bar-chart"></i>
									<?php echo label($module_label, 'label_order_sales'); ?>
								</a>
							</li>
							<!-- Заказы -->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<?php echo label($module_label, 'label_ul_gr_orders'); ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a class="menu-order-sales-by-day" href="#order_sales_by_day" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_order_sales_by_day'); ?>
										</a>
									</li>
									<li>
										<a href="#order_ps" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_order_ps'); ?>
										</a>
									</li>
									<li>
										<a href="#ship_region" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_ship_region'); ?>
										</a>
									</li>
									<li>
										<a href="#order_ship" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_order_ship'); ?>
										</a>
									</li>
								</ul>
							</li>							
							<!-- Продукты и опции -->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<?php echo label($module_label, 'label_ul_gr_product_option'); ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#top_product" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_top_product'); ?>
										</a>
									</li>
									<li>
										<a href="#product_option_sales" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_product_option_sales'); ?>
										</a>
									</li>
									<li>
										<a href="#product_nosales" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_product_nosales'); ?>
										</a>
									</li>
									<li>
										<a href="#option_sales" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_option_sales'); ?>
										</a>
									</li>
								</ul>
							</li>
							<!-- Склад -->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<?php echo label($module_label, 'label_ul_gr_stock'); ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#product_option_quantity" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_product_option_quantity'); ?>
										</a>
									</li>
									<li>
										<a href="#stock_control" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_stock_control'); ?>
										</a>
									</li>
									<li>
										<a href="#stock_control_set" data-toggle="tab">
											<i class="fa fa-gear"></i>
											<?php echo label($module_label, 'label_stock_control_set'); ?>
										</a>
									</li>
								</ul>
							</li>
							<!-- Клиенты -->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<?php echo label($module_label, 'label_ul_gr_customers'); ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#client_orders" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_client_orders'); ?>
										</a>
									</li>
									<li>
										<a href="#client_group" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_client_group'); ?>
										</a>
									</li>
								</ul>
							</li>
							<!-- Прочие -->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<?php echo label($module_label, 'label_ul_gr_others'); ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#man_product" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_man_product'); ?>
										</a>
									</li>
								</ul>
							</li>
							<li >
								<a href="#module_settings" data-toggle="tab">
									<i class="fa fa-cogs"></i>
									<?php echo label($module_label, 'label_module_settings'); ?>
								</a>
							</li>
						</ul>
						
						<div class="tab-content">
							<!-- ------------ -->
							<!-- Order Sales -->
							<!-- ------------ -->
							<div class="tab-pane" id="order_sales">
								<form class="form" 
									action="<?php echo $report_links['order_sales']; ?>" method="post" 
									enctype="multipart/form-data" 
									id="form_order_sales"
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
											</div>
											<div class="col-sm-3 clear">
											  	<div class="form-group">
												    <label class="control-label" for="input-date-start">
												    	<?php echo label($module_label, 'label_filter_date_start_month'); ?>
												    </label>
											    	<?php 
											    		echo 
											    		echoSelectMonth($module_months, 
											    			'IMReport[filter_date_start_month]', 
															(12 + (int)date('m') - (int)$module_config['user']['report_order_sales_months'] % 12 ) % 12 + 1,
											    			//(date('m') == '12' ? '1' : date('m') + 1),
											    			'select-months'
											    		); ?>
											  	</div>
											</div>
											<div class="col-sm-3">
											  	<div class="form-group">
												    <label class="control-label" for="input-date-start">
												    	<?php echo label($module_label, 'label_filter_date_start_year'); ?>
												    </label>
											    	<?php 
											    		echo 
											    		echoSelectYear(
											    			'IMReport[filter_date_start_year]', 
																(
																	(int)date('Y')
																	- (int)(
																			( 12 - (int)date('m') - 1 + (int)$module_config['user']['report_order_sales_months'] )
																			/ 12
																	)
																)
											    			//(date('m') == '12' ? date('Y') :  (date('Y') - 1))
											    		);
													?>
											  	</div>
											</div>
											<div class="col-sm-3">
											  	<div class="form-group">
												    <label class="control-label" for="input-date-start">
												    	<?php echo label($module_label, 'label_filter_date_end_month'); ?>
												    </label>
											    	<?php 
											    		echo 
											    		echoSelectMonth($module_months, 
											    			'IMReport[filter_date_end_month]', 
											    			date('m')
											    		); ?>
											  	</div>
											</div>
											<div class="col-sm-3">
											  	<div class="form-group">
												    <label class="control-label" for="input-date-start">
												    	<?php echo label($module_label, 'label_filter_date_end_year'); ?>
												    </label>
											    	<?php 
											    		echo 
											    		echoSelectYear(
											    			'IMReport[filter_date_end_year]', 
											    			date('Y')
											    		); ?>
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
												<span id="save_status_order_sales"></span>
											</div>
										</div>
									</div>
									
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="imreport-order-sales"></div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-bordered table-results">
											<thead>
												<tr>
													<th><?php echo label($module_table_header, 'table_order_sales_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_order_sales_count'); ?></th>
													<th><?php echo label($module_table_header, 'table_order_sales_cost'); ?></th>
												</tr>	
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</form>
							</div>
							<!-- ------------ -->
							<!-- Top Product -->
							<!-- ------------ -->
							<div class="tab-pane" id="top_product">
								<form class="form" 
									action="<?php echo $report_links['top_product']; ?>" method="post" 
									enctype="multipart/form-data" 
									id="form_top_product"
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

											</div>
											<div class="col-sm-6">
											  <div class="form-group">
											    <label class="control-label">
											    	<?php echo label($module_label, 'label_filter_manufact'); ?>
											    </label>
											    <?php echo echoSelect('IMReport[manufact][]', $list_manufact, '', '', true); ?>
											  </div>
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
												<span id="save_status"></span>
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
													<th><?php echo label($module_table_header, 'table_top_product_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_cat'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_model'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_manufact'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_count_orders'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_count'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_cost'); ?></th>
												</tr>	
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</form>
							</div>
							<!-- ------------ -->
							<!-- Product Option Sales -->
							<!-- ------------ -->
							<?php echo $product_option_sales_view; ?>

							<!-- ------------ -->
							<!-- Product No Sales -->
							<!-- ------------ -->
							<?php echo $product_nosales_view; ?>

							<!-- ------------ -->
							<!-- Product Option Quantity -->
							<!-- ------------ -->
							<?php echo $product_option_quantity_view; ?>

							<!-- ------------ -->
							<!-- Order PS (payment, shipping) -->
							<!-- ------------ -->
							<?php echo $order_ps_view; ?>

							<!-- ------------ -->
							<!-- 2.5.0 -->
							<!-- Shipping -->
							<!-- ------------ -->
							<?php echo $order_ship_view; ?>

							<!-- ------------ -->
							<!-- 2.4.0 -->
							<!-- Order Sales By Day -->
							<!-- ------------ -->
							<?php echo $order_sales_by_day_view; ?>

							<!-- ------------ -->
							<!-- Stock Control -->
							<!-- ------------ -->
							<?php echo $stock_control_view; ?>

							<!-- ------------ -->
							<!-- Stock Control Set -->
							<!-- ------------ -->
							<?php echo $stock_control_set_view; ?>

							<!-- ------------ -->
							<!-- Option Sales -->
							<!-- ------------ -->
							<?php echo $option_sales_view; ?>
							
							<!-- ------------ -->
							<!-- Client Orders -->
							<!-- ------------ -->
							<?php echo $client_orders_view; ?>
							
							<!-- ------------ -->
							<!-- Client Group -->
							<!-- ------------ -->
							<div class="tab-pane" id="client_group">
								<form class="form" 
									action="<?php echo $report_links['client_group']; ?>" method="post" 
									enctype="multipart/form-data" 
									id="form_client_group"
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

											</div>
											<div class="col-sm-6">
											  <div class="form-group">
											    <label class="control-label">
											    	<?php echo label($module_label, 'label_filter_manufact'); ?>
											    </label>
											    <?php echo echoSelect('IMReport[manufact][]', $list_manufact, '', '', true); ?>
											  </div>
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
												<span id="save_status_client"></span>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-results">
											<thead>
												<tr>
													<th><?php echo label($module_table_header, 'table_client_group_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_client_group_count'); ?></th>
													<th><?php echo label($module_table_header, 'table_client_group_cost'); ?></th>
												</tr>	
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</form>
							</div>
							<!-- ------------ -->
							<!-- Ship Region -->
							<!-- ------------ -->
							<div class="tab-pane" id="ship_region">
								<form class="form" 
									action="<?php echo $report_links['ship_region']; ?>" method="post" 
									enctype="multipart/form-data" 
									id="form_ship_region"
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
											</div>
											<div class="col-sm-6">
											  <div class="form-group">
											    <label class="control-label">
											    	<?php echo label($module_label, 'label_filter_manufact'); ?>
											    </label>
											    <?php echo echoSelect('IMReport[manufact][]', $list_manufact, '', '', true); ?>
											  </div>
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
												<span id="save_status_ship_region"></span>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-results">
											<thead>
												<tr>
													<th><?php echo label($module_table_header, 'table_ship_region_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_ship_region_count'); ?></th>
													<th><?php echo label($module_table_header, 'table_ship_region_cost'); ?></th>
												</tr>	
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</form>
							</div>
							<!-- ------------ -->
							<!-- Man Product -->
							<!-- ------------ -->
							<div class="tab-pane" id="man_product">
								<form class="form" 
									action="<?php echo $report_links['man_product']; ?>" method="post" 
									enctype="multipart/form-data" 
									id="form_man_product"
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
												<span id="save_status_man_product"></span>
											</div>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-results">
											<thead>
												<tr>
													<th><?php echo label($module_table_header, 'table_man_product_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_man_product_count'); ?></th>
													<th><?php echo label($module_table_header, 'table_man_product_cost'); ?></th>
												</tr>	
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</form>
							</div>
						
							<!-- ------------ -->
							<!-- Module Settings -->
							<!-- ------------ -->
							<div class="tab-pane" id="module_settings">
								<?php echo $module_settings_view; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ------------ -->
			<!-- Copy -->
			<!-- ------------ -->
			<div class="container-fluid imreport-copyright">
				<div class="panel panel-default">
					<div class="panel-body">
					Igor Mirochnik &copy; IMReport <?php echo $module_version; ?>
					| <a href="mailto:dev.imirochnik@gmail.com"><i class="fa fa-envelope-o fa-fw"></i> dev.imirochnik@gmail.com</a>
					| <a href="http://im-cloud.ru/" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> IM-Cloud.ru</a>
					</div>
				</div>
			</div>

			<!-- ------------ -->
			<!-- Filter Source -->
			<!-- ------------ -->
			<div class="hidden filter-source">
				<div class="filter-cust col-sm-6">
					<div class="form-group">
						<label class="control-label">
							<?php echo label($module_label, 'label_filter_cust'); ?>
						</label>
						<?php echo echoSelect('IMReport[cust][]', $list_cust, '', '', true); ?>
					</div>
				</div>
				<div class="filter-cust-group col-sm-6">
					<div class="form-group">
						<label class="control-label">
							<?php echo label($module_label, 'label_filter_cust_group'); ?>
						</label>
						<?php echo echoSelect('IMReport[cust_group][]', $list_cust_group, '', '', true); ?>
					</div>
				</div>
			</div>

			<script type="text/javascript">
				var module_config = {
					dev: {
						disable_autoload: <?php echo $module_config['dev']['disable_autoload']; ?>
					},
					user: {
						table_default_num_rows_displayed: <?php echo $module_config['user']['table_default_num_rows_displayed']; ?>,
						ajax_filter_delay: <?php echo $module_config['user']['ajax_filter_delay']; ?>
					}
				};

				var module_texts = {
					<?php echo echoModuleJSText($module_js_texts); ?>
				};
				
				var link_to_product = "<?php echo $report_links['link_to_product'];  ?>",
					link_to_category = "<?php echo $report_links['link_to_category'];  ?>",
					link_ajax_load_cust = "<?php echo $report_links['link_ajax_load_cust'];  ?>"
						.replace('&amp;', '&'),
					link_ajax_load_cust_group = "<?php echo $report_links['link_ajax_load_cust_group'];  ?>"
						.replace('&amp;', '&'),
					table_footer_all = "<?php echo label($module_table_header, 'table_footer_all');  ?>",
					previousPoint = null, 
					previousLabel = null,
					orderSalesGraph = {
						count: "<?php echo label($module_label, 'label_count');  ?>",
						sum: "<?php echo label($module_label, 'label_sum');  ?>"
					},
					ajaxStatusSpan = {
						getData: "<?php echo label($module_button, 'status_get');  ?>",
						save:  "<?php echo label($module_button, 'status_save');  ?>",
						ok: "<?php echo label($module_button, 'status_ok');  ?>",
						fail: "<?php echo label($module_button, 'status_fail');  ?>",
					},
					// 1.3.0
					tableFieldStatus = {
						on: "<?php echo label($module_label, 'label_enabled');  ?>",
						off: "<?php echo label($module_label, 'label_disabled');  ?>"
					},
					// 2.1.0
					is_product_image_display = <?php echo $is_product_image_display; ?>
				;
				
				// 2.4.0
				var graphStorage = (graphStorage || {});

				function formLink(link, name, param_name, param_id) {
					var result = '<a target="_blank" ';
					result += ' href="' + link + '&' + param_name + '=' + param_id  + '" >';
					//result += decodeURIComponent(name);
					result += name;
					return result + '</a>';
				}
				
				function IMR_loadTopProduct(form) {
					imrep.setTextStatus(form, {
						selector: '#save_status',
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
									selector: '#save_status',
									text: ajaxStatusSpan.ok
								});
								
								var tbody = form.find('table.table-results tbody'),
									last_id = -1,
									all_count = 0,
									all_cost = new Number(0)
								;
								
								tbody.html('');
								
								// Заполняем таблицу данными
								for (var cnt = 0; cnt < json['data'].length; cnt++) {
									var item = json['data'][cnt],
										countRow = tbody.find('tr[id="id-' + item['product_id'] + '"]').length
									;
									
									if (countRow == 0) {
										var row = jQuery('<tr>'),
											pattern = json['currency_pattern']
										;
										
										row.prop('id', 'id-' + item['product_id']);
										
										tbody.append(row);
										
										all_count += parseInt(item['count']);
										all_cost += new Number(item['cost']);
										
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
												+ IMR_formLink(link_to_product, item['product_name'], 
															'product_id', item['product_id'])
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
												+ item['count_orders']
											+ '</td>'
											+ '<td class="text-right">'
												+ item['count']
											+ '</td>'
											+ '<td class="text-right">'
												+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
											+ '</td>'
										);
									}
									else {
										var row = tbody.find('tr[id="id-' + item['product_id'] + '"]'),
											cellCat = row.find('td.category')
										;
										
										cellCat.html(
											cellCat.html()
											+ (item['category_id'] 
													? '<br/>' 
														+ formLink(link_to_category, 
															jQuery(form
																.find('select.filter-category option[value="' 
																		+ item['category_id'] + '"]')
															).text(), 
															'category_id', item['category_id'])
													: '')
										);
									}
								}
								
								//tuneUpTable(form, 4, all_count, all_cost, json['currency_pattern']);
								IMR_tuneUpTable(form, {
									colspan: 5 + (!!is_product_image_display),
									count: all_count,
									cost: all_cost,
									pattern: json['currency_pattern'],
									num_rows_displayed: module_config.user.table_default_num_rows_displayed
								});
								
							} else {
								imrep.setTextFail(form, {
									selector: '#save_status',
									text: ajaxStatusSpan.fail
								});
							}
						}
					});
				}
				
				function IMR_loadClientGroup(form) {
					imrep.setTextStatus(form, {
						selector: '#save_status_client',
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
									selector: '#save_status_client',
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
											+ //decodeURIComponent(
											(
												(item['customer_group_name'] == '_'
													? '<Без группы>'
													: item['customer_group_name']
												)
											)
										+ '</td>'
										+ '<td class="text-right">'
											+ item['count']
										+ '</td>'
										+ '<td class="text-right">'
											+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
										+ '</td>'
									);
								}
								
								IMR_tuneUpTable(form, {
									colspan: 1,
									count: all_count,
									cost: all_cost,
									pattern: json['currency_pattern'],
									num_rows_displayed: module_config.user.table_default_num_rows_displayed
								});
							} else {
								imrep.setTextFail(form, {
									selector: '#save_status_client',
									text: ajaxStatusSpan.fail
								});
							}
						}
					});
				}
				
				function IMR_loadShipRegion(form) {
					imrep.setTextStatus(form, {
						selector: '#save_status_ship_region',
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
									selector: '#save_status_ship_region',
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
											+ item['country_name'] + ' &gt; ' + item['zone_name']
										+ '</td>'
										+ '<td class="text-right">'
											+ item['count']
										+ '</td>'
										+ '<td class="text-right">'
											+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
										+ '</td>'
									);
								}
								
								//tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
								IMR_tuneUpTable(form, {
									colspan: 1,
									count: all_count,
									cost: all_cost,
									pattern: json['currency_pattern'],
									num_rows_displayed: module_config.user.table_default_num_rows_displayed
								});
							} else {
								imrep.setTextFail(form, {
									selector: '#save_status_ship_region',
									text: ajaxStatusSpan.fail
								});
							}
						}
					});
				}

				function IMR_loadManProduct(form) {
					imrep.setTextStatus(form, {
						selector: '#save_status_man_product',
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
									selector: '#save_status_man_product',
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
											+ item['man_name']
										+ '</td>'
										+ '<td class="text-right">'
											+ item['count']
										+ '</td>'
										+ '<td class="text-right">'
											+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
										+ '</td>'
									);
								}
								
								//tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
								IMR_tuneUpTable(form, {
									colspan: 1,
									count: all_count,
									cost: all_cost,
									pattern: json['currency_pattern'],
									num_rows_displayed: module_config.user.table_default_num_rows_displayed
								});
							} else {
								imrep.setTextFail(form, {
									selector: '#save_status_man_product',
									text: ajaxStatusSpan.fail
								});
							}
						}
					});
				}
				
				function IMR_loadOrderSalesGraph(form, data, pattern, monthMap) {
					if (data.length < 1)
						return;
					
					(window.graphStorage = (graphStorage || {})).order_sales = [];

					var cloneData = $.extend(true, {}, data),
						series = [{ 
							data: [],
							label: orderSalesGraph.count, //'Количество',
							color: '#1c94c4',
							yaxis: 1,
		                    bars: {
		                        show: true,
		                        fill: true,
		                        fillColor: { colors: [{ opacity: 0.2 }, { opacity: 0.9}] },
		                        align: "center",
		                    }
						}, { 
							data: [],
							label: orderSalesGraph.sum, //'Цена',
							color: 'green', 
							yaxis: 2,
							points: { show: true },
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
						var currdate = parseInt(data[cnt]['year']) * 100 + parseInt(data[cnt]['month'])
						;
						series[0].data.push([ cnt, data[cnt]['count'] ]);
						series[1].data.push([ cnt, data[cnt]['cost'] ]);
						graphStorage.order_sales.push({
							month: data[cnt]['month'],
							year: data[cnt]['year'],
							count: data[cnt]['count'],
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
					
					jQuery('form .imreport-order-sales').plot(series, {
						xaxis: {
                        	reserveSpace: true,
                        	alignTicksWithAxis: 1,
                        	position: 'bottom',
                        	ticks: ticks,
							tickFormatter: function (val, axis) {
	                            return monthMap['' + data[val]['month']] + '<br/>' + data[val]['year'];
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
						$('<div id="imreport-order-sales-tooltip">' + contents + '</div>').css({
					        position: 'absolute',
					        display: 'none',
							top: y - 80,
							left: x - 50,
					        border: '1px solid ' + color,
					        padding: '5px 10px',
					        'font-size': '11px',
					        'background-color': '#fff',
					        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
					        opacity: 0.9
					    }).appendTo("body").fadeIn(200);
					}
					
					jQuery('form .imreport-order-sales').bind('mouseout', function (event, pos, item) {
						$("#imreport-order-sales-tooltip").remove();
						previousPoint = null;
					});

					jQuery('form .imreport-order-sales').bind('plothover', function (event, pos, item) {
						 if (item) {
							if (previousPoint != item.dataIndex) {
				                previousPoint = item.dataIndex;
				                previousLabel = item.series.label;
				                $("#imreport-order-sales-tooltip").remove();
				                
				                var x = item.datapoint[0],
				                	y = item.datapoint[1],
				                	seriesIndex = item.seriesIndex
				                ;

				                var color = item.series.color;

								var tooltip_text =
									'<strong style="text-decoration: underline;">' + monthMap['' + graphStorage.order_sales[x]['month']]
									 	+ ' ' + graphStorage.order_sales[x]['year'] + "</strong>"
									+ "<br/>"
									+ "<strong style=\"color: #127aa4;\">" + orderSalesGraph.count + "</strong>"
									+ ": <strong style=\"color: #127aa4;\">" + graphStorage.order_sales[x]['count'] + "</strong>"
									+ "<br/>"
									+ "<strong style=\"color: green;\">" + orderSalesGraph.sum + "</strong>"
									+ ": <strong style=\"color: green;\">"
									 	+ pattern.replace('[digit]', (new Number(graphStorage.order_sales[x]['cost']).toFixed(2)))
									+ "</strong>"
								;

								showTooltip(pos.pageX, pos.pageY, color, tooltip_text);
							} else {
								$("#imreport-order-sales-tooltip").css({
									top: pos.pageY - 80,
									left: pos.pageX - 50,
								});
							}
						}
					});
				}
				
				function IMR_loadOrderSales(form) {
					imrep.setTextStatus(form, {
						selector: '#save_status_order_sales',
						text: ajaxStatusSpan.getData
					});
					
					var monthMap = {
							'1': 'Январь', '2': 'Февраль', '3': 'Март',
							'4': 'Апрель', '5': 'Май', '6': 'Июнь',
							'7': 'Июль', '8': 'Август', '9': 'Сентябрь',
							'10': 'Октябрь', '11': 'Ноябрь', '12': 'Декабрь'
						},
						select = form.find('.select-months:eq(0)')
					;
					
					// 1.3.0
					select.find('option').each(function (k, i) {
						monthMap['' + jQuery(this).val()] = jQuery(this).text();
					});
					
					jQuery.ajax({
						url: form.attr('action'),
						type: 'post',
						data: form.serializeArray(),
						dataType: 'json',
						success: function (json) {
							if (json['success']) {
								imrep.setTextSuccess(form, {
									selector: '#save_status_order_sales',
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
											+ monthMap['' + item['month']]
											+ ' '
											+ item['year']
										+ '</td>'
										+ '<td class="text-right">'
											+ item['count']
										+ '</td>'
										+ '<td class="text-right">'
											//+ new Number(item['cost']).toFixed(2)
											+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
										+ '</td>'
									);
								}
								
								//tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
								IMR_tuneUpTable(form, {
									colspan: 1,
									count: all_count,
									cost: all_cost,
									pattern: json['currency_pattern'],
									num_rows_displayed: module_config.user.table_default_num_rows_displayed
								});
								
								IMR_loadOrderSalesGraph(form, json['data'], json['currency_pattern'], monthMap);
							} else {
								imrep.setTextFail(form, {
									selector: '#save_status_order_sales',
									text: ajaxStatusSpan.fail
								});
							}
						}
					});
				}
				
				function IMR_loadData(form) {
					
					form.find('.input-csv').remove();
					
					if (form[0].id == 'form_top_product') {
						IMR_loadTopProduct(form);
					}
					else if(form[0].id == 'form_client_group') {
						IMR_loadClientGroup(form);
					}
					else if(form[0].id == 'form_ship_region') {
						IMR_loadShipRegion(form);
					}
					else if(form[0].id == 'form_man_product') {
						IMR_loadManProduct(form);
					}
					else if(form[0].id == 'form_order_sales') {
						IMR_loadOrderSales(form);
					}
					else if(form[0].id == 'form_client_orders') {
						IMR_loadClientOrders(form);
					}
					else if(form[0].id == 'form_option_sales') {
						IMR_loadOptionSales(form);
					}
					else if(form[0].id == 'form_product_option_sales') {
						IMR_loadProductOptionSales(form);
					}
					else if(form[0].id == 'form_product_option_quantity') {
						IMR_loadProductOptionQuantity(form);
					}
					else if(form[0].id == 'form_stock_control') {
						IMR_loadStockControl(form);
					}
					else if(form[0].id == 'form_stock_control_set') {
						IMR_loadStockControlSet(form);
					}
					else if(form[0].id == 'form_order_ps') {
						IMR_loadOrderPaymShip(form);
					}
					else if(form[0].id == 'form_product_nosales') {
						IMR_loadProductNoSales(form);
					}
					else if(form[0].id == 'form_order_sales_by_day') {
						IMR_loadOrderSalesByDay(form);
					}
					else if(form[0].id == 'form_order_ship') {
						IMR_loadOrderShip(form);
					}
				}
				
				function IMR_loadDataCSV(form) {
					form.append(
						'<input type="hidden" class="input-csv" name="IMReport[is_csv]" value="1" />'
					);
					
					form.submit();
				}
				
				// Добавление фильтров
				function IMR_appendFiltersToReports() 
				{
					var report = jQuery('.IMReport'),
						supportIds = [
							'form_option_sales',
							'form_order_sales',
							'form_order_ps',
							'form_ship_region',
							'form_top_product',
							'form_product_option_sales',
							'form_product_nosales',
							'form_man_product',
							'form_order_sales_by_day',
							'form_order_ship'
						],
						dataSourceCust = report.find('.filter-source .filter-cust'),
						dataSourceCustGroup = report.find('.filter-source .filter-cust-group')
					;
					
					report.find('form').each(function () {
						if (jQuery.inArray(this.id, supportIds) > -1) {
							var item = jQuery(this),
								btnGroup = item.find('.report-btn-group'),
								dataDestCust = dataSourceCust.clone(),
								dataDestCustGroup = dataSourceCustGroup.clone()
							;
							
							dataDestCust.find('select').addClass('select2-ajax');
							dataDestCust.find('select').addClass('select2-ajax-cust');
							dataDestCustGroup.find('select').addClass('select2-ajax');
							dataDestCustGroup.find('select').addClass('select2-ajax-cust-group');

							// Добавляем очистку выравнивания
							btnGroup.parent().prepend(jQuery('<div class="clear"></div>'));
							// Добавляем фильтры
							btnGroup.parent().prepend(dataDestCust);
							btnGroup.parent().prepend(dataDestCustGroup);

						}
					});
				}
				
				jQuery(function () {

					jQuery('#module_reports a:first').tab('show');
					
					jQuery('.date').datetimepicker({
						pickTime: false
					});
					
					// Добавляем фильтры
					IMR_appendFiltersToReports();

					// Select 2
					jQuery('.IMReport form').each(function () {
						var form = jQuery(this)
						;
						
						form.find('.well .row select').addClass('to-select2');
					});

					// Задержка перед выбором
					setTimeout(function () {
						jQuery('.IMReport select.to-select2.disabled')
						.attr('disabled', 'disabled');
						
						jQuery('.IMReport select.to-select2:not(.select2-ajax)').select2({
							language: "ru", 
							dropdownAutoWidth: 'true',
							width: '100%'
						});

						jQuery('.IMReport select.to-select2.select2-ajax.select2-ajax-cust').select2({
							language: "ru",
							dropdownAutoWidth: 'true',
							width: '100%',
							ajax: {
								url: link_ajax_load_cust,
								delay: module_config.user.ajax_filter_delay,
								dataType: 'json',
								processResults: function (data) {
						      // Tranforms the top-level key of the response object from 'items' to 'results'
						      return {
						        results: data.data
						      };
						    }
							}
						});

						jQuery('.IMReport select.to-select2.select2-ajax.select2-ajax-cust-group').select2({
							language: "ru",
							dropdownAutoWidth: 'true',
							width: '100%',
							ajax: {
								url: link_ajax_load_cust_group,
								delay: module_config.user.ajax_filter_delay,
								dataType: 'json',
								processResults: function (data) {
						      // Tranforms the top-level key of the response object from 'items' to 'results'
						      return {
						        results: data.data
						      };
						    }
							}
						});
					}, 400);

					// Подгружаем данные
					if (module_config.dev.disable_autoload + '' == '0') {					
						IMR_loadData(jQuery('#top_product form'));
						IMR_loadData(jQuery('#client_group form'));
						IMR_loadData(jQuery('#ship_region form'));
						IMR_loadData(jQuery('#man_product form'));
						IMR_loadData(jQuery('#order_sales form'));
						IMR_loadData(jQuery('#client_orders form'));
						IMR_loadData(jQuery('#option_sales form'));
						IMR_loadData(jQuery('#product_option_sales form'));
						IMR_loadData(jQuery('#product_option_quantity form'));
						IMR_loadData(jQuery('#stock_control form'));
						IMR_loadData(jQuery('#stock_control_set form'));
						IMR_loadData(jQuery('#order_ps form'));
						IMR_loadData(jQuery('#product_nosales form'));
						// 2.4.0
						IMR_loadData(jQuery('#order_sales_by_day form'));
						// 2.5.0
						IMR_loadData(jQuery('#order_ship form'));
					}
					
					jQuery('.button-filter').click(function () {
						IMR_loadData(jQuery(this).closest('form'));
					});

					jQuery('.button-csv').click(function () {
						IMR_loadDataCSV(jQuery(this).closest('form'));
					});

					// Сохраняем настройки IMRep
					jQuery('.IMReport .btn-imrep-settings-save').click(function (e) {
						e.preventDefault();
						IMR_saveIMRepSettings(jQuery(this).closest('form'));
						return false;
					});
				});

			</script>
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style End -->
			<!-- --------------------------------------------------- -->
		</div>
		
  	</div>
</div>

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

	.breadcrumb a img
	{
		margin-bottom: 2px !important;
	}
	
	.form-group 
	{
	    padding-top: 15px;
	    padding-bottom: 15px;
	    margin-bottom: 0;
	}

	.input-group.date input.form-control
	{
	    padding: 3px;
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
	
	table.table-results caption .left-part
	{
		padding-left: 0px;
	}

	table.table-results caption .right-part
	{
		padding-right: 0px;
	}
	
	#save_status.success,
	#save_status_client.success,
	#save_status_ship_region.success,
	#save_status_man_product.success,
	#save_status_order_sales.success,
	#save_status_order_sales_by_day.success
	{
    	color: green;
	    top: 10px;
	    position: relative;
	}

	#save_status.fail,
	#save_status_client.fail,
	#save_status_ship_region.fail,
	#save_status_man_product.fail,
	#save_status_order_sales.fail,
	#save_status_order_sales_by_day.fail
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

	/* 1.7.0 */
	.table-results > tbody > tr:nth-child(2n+1) > td 
	{
	   background-color: #f2f2f2;
	}

	.table-results thead th.head-counter
	{
		width: 35px;
	}

	.form-group 
	{
	    padding-top: 5px;
	    padding-bottom: 5px;
	    margin-bottom: 0;
	}

	/* Print */

	@media print  {
		.panel-body
		{
			padding: 0px;
		}
		header 
		{ 
			background: none !important;
			display: none !important;
		}
		header img { -webkit-filter: invert(100%);
		filter: invert(100%); }
		header, footer, nav, .breadcrumb, caption, .well, ul, h1,h2,h3
		{
			display: none !important;
			border: 0px;
		}

		a[href]:after
		{
			content: "" !important;
		}
		
		.container-fluid.page-header,
		.panel-default
		{
			border: 0px !important;
		}
		
		.container-fluid
		{
			padding: 0px !important;
			margin: 0px !important;
		}
		
		table td
		{
			font-size: 11px;
		}
		
		.IMReport table.table-results
		{
			width: 100%;
		}
		
		table td input,
		.IMReport table.table-results tbody tr input.form-control
		{
			display: none !important;
		}
		
		.imreport-copyright
		{
			display: none !important;
		}

		/* Fix print 1.5 */

		header, 
		#header, 
		#header *,
		#header .div1,
		#header .div2,
		#header .div3,
		#footer,
		#footer *
		{ 
			background: none !important;
			display: none !important;
		}
		
		.tab-pane,
		.select2.select2-container,
		select.form-control,
		.bootstrap-datetimepicker-widget,
		.well .form-group,
		.nav.nav-pills,
		.filter-source
		{
			display: none;
		}
		
		.tab-pane.active
		{
			display: block;
		}

		.box > .content
		{
			border: 0px !important;
		}

		.text-right
		{
		    text-align: right;
		}

		table.table-results
		{
			text-align: left;
		}

		.table-bordered
		{
			border-collapse: collapse;
		}

		.table-bordered,
		.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, 
		.table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, 
		.table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td
		{
			border: 1px solid #ddd;
			padding: 8px;
			line-height: 1.42857;
   			page-break-inside: avoid;
		}
		
		.flot-y-axis
		{
			display: block;
		}

		.panel-body
		{
			padding: 0px;
		}
		
		.imreport-order-sales
		{
			display: none;
		}
		
		table.table-results a:after,
		table.table-results a[href]:after
		{
			content: "" !important;
		}
		
		table.table-results a
		{
			text-decoration: none;
			color: black;
		}
		
		.box > .content
		{
		    border: 0px !important;
		    padding: 0px;
		}
		
		.box > .container-fluid
		{
			display: none;
		}
		
		#content
		{
			padding: 0px;
    		margin: 0px;
		}
		
		/* End Fix print 1.5 */
		
	}

</style>

<?php echo $footer; ?>

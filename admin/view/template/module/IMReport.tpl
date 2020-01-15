<?php echo $header; ?><?php //echo $column_left; ?>

<?php 
	/*
		Author: Igor Mirochnik
		Site: http://ida-freewares.ru
		Email: dev.imirochnik@gmail.com
		Type: commercial
	*/

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

	<?php if ($error_warning) { ?>
		<div class="warning">
			<?php echo $error_warning; ?>
		</div>
	<?php } ?>

	<div class="box">
		<div class="container-fluid">
		  	<div class="heading">
		    	<h1>
		    		<?php echo $h1_text; ?> - <small><?php echo $h2_text; ?></small>
		    	</h1>
				<br/>
		  	</div>
		</div>
	  	<div style="clear:both;"></div>
		<div class="content" >
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
										<a href="#ship_region" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_ship_region'); ?>
										</a>
									</li>
									<li>
										<a href="#man_product" data-toggle="tab">
											<i class="fa fa-bar-chart"></i>
											<?php echo label($module_label, 'label_man_product'); ?>
										</a>
									</li>
								</ul>
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
											<div class="col-sm-3">
											  	<div class="form-group">
												    <label class="control-label" for="input-date-start">
												    	<?php echo label($module_label, 'label_filter_date_start_month'); ?>
												    </label>
											    	<?php 
											    		echo 
											    		echoSelectMonth($module_months, 
											    			'IMReport[filter_date_start_month]', 
											    			(date('m') == '12' ? '1' : date('m') + 1),
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
											    			(date('m') == '12' ? date('Y') :  (date('Y') - 1))
											    		); ?>
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
											<div class="col-sm-12">
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
												<div class="form-group">
													<label class="control-label">
														<?php echo label($module_label, 'label_filter_sort') ?>
													</label>
													<?php echo echoSelect('IMReport[sort][]', $list_top_sort, '', ''); ?>
												</div>
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
													<th><?php echo label($module_table_header, 'table_top_product_name'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_cat'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_model'); ?></th>
													<th><?php echo label($module_table_header, 'table_top_product_manufact'); ?></th>
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
							<!-- Product Option Quantity -->
							<!-- ------------ -->
							<?php echo $product_option_quantity_view; ?>

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
												<div class="form-group">
													<label class="control-label">
														<?php echo label($module_label, 'label_filter_sort') ?>
													</label>
													<?php echo echoSelect('IMReport[sort][]', $list_client_sort, '', ''); ?>
												</div>
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
												<div class="form-group">
													<label class="control-label">
														<?php echo label($module_label, 'label_filter_sort') ?>
													</label>
													<?php echo echoSelect('IMReport[sort][]', $list_ship_region_sort, '', ''); ?>
												</div>
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
												<div class="form-group">
													<label class="control-label">
														<?php echo label($module_label, 'label_filter_sort') ?>
													</label>
													<?php echo echoSelect('IMReport[sort][]', $list_man_product_sort, '', ''); ?>
												</div>
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
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				
				var link_to_product = "<?php echo $report_links['link_to_product'];  ?>",
					link_to_category = "<?php echo $report_links['link_to_category'];  ?>",
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
					}
				;
				
				function formLink(link, name, param_name, param_id) {
					var result = '<a target="_blank" ';
					result += ' href="' + link + '&' + param_name + '=' + param_id  + '" >';
					//result += decodeURIComponent(name);
					result += name;
					return result + '</a>';
				}
				
				function loadTopProduct(form) {
					jQuery('#save_status').removeClass('fail').removeClass('success')
					.html(ajaxStatusSpan.getData);
					
					jQuery.ajax({
						url: form.attr('action'),
						type: 'post',
						data: form.serializeArray(),
						dataType: 'json',
						success: function (json) {
							if (json['success']) {
								jQuery('#save_status').removeClass('fail').addClass('success')
								.html(ajaxStatusSpan.ok);
								
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
											'<td class="text-left">'
												+ formLink(link_to_product, item['product_name'], 
															'product_id', item['product_id'])
											+ '</td>'
											+ '<td class="text-left category">'
												+ (item['category_id'] 
													? formLink(link_to_category, 
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
								
								tuneUpTable(form, 4, all_count, all_cost, json['currency_pattern']);
								
							} else {
								jQuery('#save_status').removeClass('success').addClass('fail')
								.html(ajaxStatusSpan.fail);
							}
						}
					});
				}
				
				function loadClientGroup(form) {
					jQuery('#save_status_client').removeClass('fail').removeClass('success')
					.html(ajaxStatusSpan.getData);
					
					jQuery.ajax({
						url: form.attr('action'),
						type: 'post',
						data: form.serializeArray(),
						dataType: 'json',
						success: function (json) {
							if (json['success']) {
								jQuery('#save_status_client').removeClass('fail').addClass('success')
								.html(ajaxStatusSpan.ok);
								
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
								
								tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
							} else {
								jQuery('#save_status_client').removeClass('success').addClass('fail')
								.html(ajaxStatusSpan.fail);
							}
						}
					});
				}
				
				function loadShipRegion(form) {
					jQuery('#save_status_ship_region').removeClass('fail').removeClass('success')
					.html(ajaxStatusSpan.getData);
					
					jQuery.ajax({
						url: form.attr('action'),
						type: 'post',
						data: form.serializeArray(),
						dataType: 'json',
						success: function (json) {
							if (json['success']) {
								jQuery('#save_status_ship_region').removeClass('fail').addClass('success')
								.html(ajaxStatusSpan.ok);
								
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
								
								tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
							} else {
								jQuery('#save_status_ship_region').removeClass('success').addClass('fail')
								.html(ajaxStatusSpan.fail);
							}
						}
					});
				}

				function loadManProduct(form) {
					jQuery('#save_status_man_product').removeClass('fail').removeClass('success')
					.html(ajaxStatusSpan.getData);
					
					jQuery.ajax({
						url: form.attr('action'),
						type: 'post',
						data: form.serializeArray(),
						dataType: 'json',
						success: function (json) {
							if (json['success']) {
								jQuery('#save_status_man_product').removeClass('fail').addClass('success')
								.html(ajaxStatusSpan.ok);
								
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
								
								tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
							} else {
								jQuery('#save_status_man_product').removeClass('success').addClass('fail')
								.html(ajaxStatusSpan.fail);
							}
						}
					});
				}
				
				function loadOrderSalesGraph(form, data, pattern, monthMap) {
					if (data.length < 1)
						return;
					
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
						ticks.push(cnt);
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
					        top: y - 40,
					        left: x - 60,
					        border: '1px solid ' + color,
					        padding: '5px 10px',
					        'font-size': '11px',
					        'background-color': '#fff',
					        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
					        opacity: 0.9
					    }).appendTo("body").fadeIn(200);
					}
					
					jQuery('form .imreport-order-sales').bind('plothover', function (event, pos, item) {
						 if (item) {
				            if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
				                previousPoint = item.dataIndex;
				                previousLabel = item.series.label;
				                $("#imreport-order-sales-tooltip").remove();
				                
				                var x = item.datapoint[0],
				                	y = item.datapoint[1],
				                	seriesIndex = item.seriesIndex
				                ;

				                var color = item.series.color;

				                showTooltip(item.pageX, item.pageY, color,
				                			"<strong>" + item.series.label + "</strong>"
				                            + " : <strong>" 
				                            	+ (seriesIndex == 0 
				                            		? y 
				                            		: pattern.replace('[digit]', (new Number(y).toFixed(2))))
				                            + "</strong> "
								);
				            }
				        } else {
				            $("#imreport-order-sales-tooltip").remove();
				            previousPoint = null;
				        }
					});
				}
				
				function loadOrderSales(form) {
					jQuery('#save_status_order_sales').removeClass('fail').removeClass('success')
					.html(ajaxStatusSpan.getData);
					
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
								jQuery('#save_status_order_sales').removeClass('fail').addClass('success')
								.html(ajaxStatusSpan.ok);
								
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
											+ pattern.replace('[digit]', (new Number(item['cost']).toFixed(2)))
										+ '</td>'
									);
								}
								
								tuneUpTable(form, 1, all_count, all_cost, json['currency_pattern']);
								
								loadOrderSalesGraph(form, json['data'], json['currency_pattern'], monthMap);
							} else {
								jQuery('#save_status_order_sales').removeClass('success').addClass('fail')
								.html(ajaxStatusSpan.fail);
							}
						}
					});
				}
				
				function loadData(form) {
					
					form.find('.input-csv').remove();
					
					if (form[0].id == 'form_top_product') {
						loadTopProduct(form);
					}
					else if(form[0].id == 'form_client_group') {
						loadClientGroup(form);
					}
					else if(form[0].id == 'form_ship_region') {
						loadShipRegion(form);
					}
					else if(form[0].id == 'form_man_product') {
						loadManProduct(form);
					}
					else if(form[0].id == 'form_order_sales') {
						loadOrderSales(form);
					}
					else if(form[0].id == 'form_client_orders') {
						loadClientOrders(form);
					}
					else if(form[0].id == 'form_option_sales') {
						loadOptionSales(form);
					}
					else if(form[0].id == 'form_product_option_sales') {
						loadProductOptionSales(form);
					}
					else if(form[0].id == 'form_product_option_quantity') {
						loadProductOptionQuantity(form);
					}
					else if(form[0].id == 'form_stock_control') {
						loadStockControl(form);
					}
					else if(form[0].id == 'form_stock_control_set') {
						loadStockControlSet(form);
					}
				}
				
				function tuneUpTable(form, colspan, count, cost, pattern, not_need_cost, not_need_footer) {
					var table = form.find('table.table-results')
					;
					
					// Добавляем автосчетчик
					table.find('thead th.head-counter').remove();
					jQuery('<th class="head-counter">#</th>')
					.insertBefore(table.find('thead tr:eq(0) th:eq(0)'))
					;
					
					table.find('tbody').find('tr').each(function (k, i) {
						var row = jQuery(this)
						;
						jQuery('<td>' + (k + 1) + '</td>').insertBefore(row.find('td:eq(0)'));
					});
					
					// Подвал не нужен
					if (not_need_footer)
						return;
					
					// Формируем подвал
					if (table.children('tfoot').length == 0) {
						table.append('<tfoot>');
					}
					
					var foot = table.children('tfoot')
					;
					
					foot.html('');
					
					foot.append(
						'<tr>'
							+ '<td colspan="' + (colspan + 1) + '">'
								+ table_footer_all
							+ '</td>'
							+ '<td class="text-right">'
								+ count
							+ '</td>'
							+ ( !not_need_cost
								?('<td class="text-right">'
									+ pattern.replace('[digit]', (new Number(cost).toFixed(2)))
								+ '</td>')
								: ''
							)
						+ '</tr>'
					);
				}
				
				function loadDataCSV(form) {
					form.append(
						'<input type="hidden" class="input-csv" name="IMReport[is_csv]" value="1" />'
					);
					
					form.submit();
				}
				
				jQuery(function () {

					jQuery('#module_reports a:first').tab('show');
					
					jQuery('.date').datetimepicker({
						pickTime: false
					});
					
					// Подгружаем данные
					loadData(jQuery('#top_product form'));
					loadData(jQuery('#client_group form'));
					loadData(jQuery('#ship_region form'));
					loadData(jQuery('#man_product form'));
					loadData(jQuery('#order_sales form'));
					loadData(jQuery('#client_orders form'));
					loadData(jQuery('#option_sales form'));
					loadData(jQuery('#product_option_sales form'));
					loadData(jQuery('#product_option_quantity form'));
					loadData(jQuery('#stock_control form'));
					loadData(jQuery('#stock_control_set form'));
					
					jQuery('.button-filter').click(function () {
						loadData(jQuery(this).closest('form'));
					});

					jQuery('.button-csv').click(function () {
						loadDataCSV(jQuery(this).closest('form'));
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
	
	#save_status.success,
	#save_status_client.success,
	#save_status_ship_region.success,
	#save_status_man_product.success,
	#save_status_order_sales.success
	{
    	color: green;
	    top: 10px;
	    position: relative;
	}

	#save_status.fail,
	#save_status_client.fail,
	#save_status_ship_region.fail,
	#save_status_man_product.fail,
	#save_status_order_sales.fail
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

	/* 1.3.0 */
	.table-results > tbody > tr:nth-child(2n+1) > td 
	{
	   background-color: #f2f2f2;
	}

	.table-results thead th.head-counter
	{
		width: 10px;
	}

	.form-group 
	{
	    padding-top: 5px;
	    padding-bottom: 5px;
	    margin-bottom: 0;
	}

</style>

<?php echo $footer; ?>
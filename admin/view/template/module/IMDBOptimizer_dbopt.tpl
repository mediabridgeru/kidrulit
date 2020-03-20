<?php 
	/*
		Author: Igor Mirochnik
		Site: http://ida-freewares.ru
	    Site: http://im-cloud.ru
		Email: dev.imirochnik@gmail.com
		Type: commercial
	*/

	// Формирование html select
	if (!function_exists('echoHtmlSelect'))
	{
		function echoHtmlSelect($name, $data, $curr_val = '', $append_class = '', 
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

	if (!function_exists('echoHtmlSelectMany'))
	{
		function echoHtmlSelectMany($name, $data, $append_class = '', 
							$val_name = 'id', $text_name = 'name')
		{
			$result = '<div class="well well-sm ' . $append_class . '" style="height: 150px; overflow: auto;">';
			$result .= '<input type="hidden" value="-1" name="' . $name . '" />';
			
			foreach($data as $key => $item)
			{
				if (''.$item[$val_name] == '-1')
				{
					continue;
				}
				else
				{
					$result .= '<div class="checkbox">'
		                  	. ' <label> '
								. '<input type="checkbox" name="' . $name . '" value="' . $item[$val_name] . '"> '
		                    	. $item[$text_name]                                      
		                    . ' </label> '
		                . '</div>'
					;
				}
			}

			$result .= '</div>';

			$result .= '<a class="iml-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Выделить всё</a>'
				. ' / '
				. '<a class="iml-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Снять выделение</a>'
			;
			
			return $result;
		}
	}

	if (!function_exists('echoHtmlSelectType'))
	{
		function echoHtmlSelectType($name, $curr_val, $append_class = '', $is_multi = false)
		{
			return echoHtmlSelect($name,
				array(
					array('id' => '1','name' => 'Заменить пустые'),
					array('id' => '2','name' => 'Добавить, если не хватает'),
					array('id' => '3','name' => 'Перезаписать')
				),
				$curr_val,
				$append_class,
				$is_multi,
				'id',
				'name'
			);
		}
	}

	if (!function_exists('echoHtmlSelectTypeSearch'))
	{
		function echoHtmlSelectTypeSearch($name, $curr_val, $append_class = '', $is_multi = false)
		{
			return echoHtmlSelect($name,
				array(
					array('id' => 'regular_word','name' => 'Искать только нормальные слова (только буквы)'),
					array('id' => 'regular_word_digit','name' => 'Искать цифро-буквенные комбинации с дефисом')
				),
				$curr_val,
				$append_class,
				$is_multi,
				'id',
				'name'
			);
		}
	}

	if (!function_exists('echoLabel'))
	{
		function echoLabel($module_label, $name)
		{
			if (isset($module_label)) {
				if (is_array($module_label)) {
					if (isset($module_label[$name]))
						return $module_label[$name];
				}
			}
			return $name;
		}
	}

	if (!function_exists('echoDate'))
	{
		function echoDate($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group">'
				    . '<label class="control-label" for="">'
				    	. echoLabel($module_label, $label)
				    . '</label>'
				    . '<div class="input-group date">'
				      	.' <input type="text" '
				      		. ' name="' . $name . '" '
				      		. ' value="' . $value . '" '
				      		. ' placeholder="' . echoLabel($module_label, $label) . '"'
				      		. ' data-date-format="DD.MM.YYYY"'
				      		. ' class="form-control ' . $append_class . '"/>'
				      	. '<span class="input-group-btn">'
				      	. '<button type="button" class="btn btn-default">'
				      		. '<i class="fa fa-calendar"></i>'
				      	. '</button>'
				      	.'</span>'
				    . '</div>'
			  	. '</div>'
		  	;
		}
	}
	
	if (!function_exists('echoTextAreaControl'))
	{
		function echoTextAreaControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. '<textarea '
	      					. ' name="' . $name . '" '
	      					. ' placeholder="' . echoLabel($module_label, $label) . '" '
	      					. ' class="form-control ' . $append_class . '">'
	      						. $value
	      				. '</textarea>'
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoInputControl'))
	{
		function echoInputControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. '<input '
	      				
	      					. ' type="textbox"'
	      					. ' name="' . $name . '" '
	      					. ' value="' . $value . '" '
	      					. ' placeholder="' . echoLabel($module_label, $label) . '" '
	      					. ' class="form-control ' . $append_class . '"/>'
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoSelectControl'))
	{
		function echoSelectControl($data, $name, $module_label, $label = '', $value = '', $append_class = '',
									$is_multi = false, $val_name = 'id', $text_name = 'name')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelect($name, $data, $value, $append_class, $is_multi, $val_name, $text_name)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
	if (!function_exists('echoTypeControl'))
	{
		function echoTypeControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelectType($name, $value, $append_class, false)
					. '</div>'
		  		. '</div>'
			;
		}
	}

	if (!function_exists('echoTypeSearchControl'))
	{
		function echoTypeSearchControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group ">'
	    			. '<label class=" control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="">'
	      				. echoHtmlSelectTypeSearch($name, $value, $append_class, false)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
?>

<!-- ------------ -->
<!-- DBOpt -->
<!-- ------------ -->
<div class="tab-pane" id="imdbopt">
		
	<form class="form IMDBOptimizer-form" 
		action="<?php echo $replace; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_inmdbo_index"
	>

		<div class="well">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger">
						Прежде, чем выполнять генерацию индексов, 
						настоятельно рекомендуется <b>сделать бэкап всей базы данных</b>
					</div>
				</div>
				<!-------------------------->
				<!-- Filter -->
				<!-------------------------->
		
				<div class="col-sm-6">
					<div class="form-group">
					<label class="control-label">
					<?php echo 
						echoLabel($module_label, 'label_filter_tables'); ?>
					</label>
					<?php echo 
						echoHtmlSelectMany('tables', $list_tables, 'imdbo-tables-select'); ?>
					</div>
				</div>

				<div class="col-sm-6">
					<?php
						echo
						//$name, $module_label, $label = '', $value = '', $append_class = '')
						echoInputControl(
							'IMDBOptimizer[field_names]',
							$module_label,
							'label_field_names',
							'',
							''
						);
					?>
					<?php
						echo
						//$name, $module_label, $label = '', $value = '', $append_class = '')
						echoInputControl(
							'IMDBOptimizer[field_starts]',
							$module_label,
							'label_field_starts',
							'',
							''
						);
					?>
					<?php
						echo
						echoInputControl(
							'IMDBOptimizer[field_ends]',
							$module_label,
							'label_field_ends',
							'_id',
							''
						);
					?>
				</div>
				
				<div class="col-sm-12">
					<?php
						$default_map_value =
							'#product - model' . "\n"
							. '#product - status' . "\n"
							. '#product_to_category - main_category' . "\n"
							. '#product_image - sort_order' . "\n"
							. '#product_option_value - subtract' . "\n"
							. '#product_option_value - quantity' . "\n"
							. '#setting - code' . "\n"
							. '#setting - key' . "\n"
							. '#setting - serialized' . "\n"
							. '#url_alias - query ' . "\n"
						;
						echo
						echoTextAreaControl(
							'IMDBOptimizer[table_index_map]',
							$module_label,
							'label_field_table_index_map',
							$default_map_value,
							''
						);
					?>
				</div>

				<div class="col-sm-12">
					<hr/>
				</div>
			
				<!-------------------------->
				<!-- Buttons -->
				<!-------------------------->
				
				<div class="col-sm-12">
					<div class="form-group">
						<div class="buttons">
							<a class="button btn-im-generate btn btn-success" 
								style="color:white">
								<i class="fa fa-save"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_generate'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<a class="button btn-im-remove btn btn-danger" 
								style="color:white">
								<i class="fa fa-remove"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_remove'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<a class="button btn-im-show-data btn btn-info" 
								style="color:white">
								<i class="fa fa-sliders"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_show_data'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<span class="generate-status"></span>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<hr/>
				</div>

				<!-------------------------->
				<!-- Log -->
				<!-------------------------->

				<div class="col-sm-12">
					<?php
						echo
						echoTextAreaControl(
							'log',
							$module_label,
							'label_field_log',
							'',
							'imdbo-log-container'
						);
					?>
				</div>
				
				<div class="col-sm-12">
					<hr/>
				</div>
				
			</div>
		</div>

	</form>
</div>

<script type="text/javascript">
	
	// Генерация индексов для одной таблицы в БД
	function IMDBO_generateIndexForTable(form, data, listTables, currNum, onLoad)
	{
		if (listTables.length <= currNum) {
			if (typeof(onLoad) === 'function') {
				onLoad(form);
				return;
			}
		}
		
		var sendData = [],
			logTextArea = form.find('.imdbo-log-container')
		;
		
		for(var cnt = 0; cnt < data.length; cnt++) {
			sendData.push(data[cnt]);
		}
		
		sendData.push({
			name: 'IMDBOptimizer[table]',
			value: listTables[currNum]
		});
		
		logTextArea.val(
			logTextArea.val()
			+ '\n------------------------\n'
			+ (currNum + 1) + '. ' + listTables[currNum]
			+ '\n------------------------\n'
			+ module_texts.startGen
		);
		
		logTextArea[0].scrollTop = logTextArea[0].scrollHeight; 
		
		IMDBO_ajaxOperation({
			form: form,
			data: sendData,
			url: module_links.generateIndexForTable,
			status: {
				selector: 'not-need',
				text: {
					action: '',
					success: '',
					fail: ''
				}
			},
			onLoad: function (json) {
				var logTextArea = form.find('.imdbo-log-container')
				;
				
				logTextArea.val(
					logTextArea.val() 
					+ '\n'
					+ json['report']
					+ '\n'
					+ (json['success'] ? module_texts.genOk : module_texts.genFail)
					+ '\n------------------------\n'
				);
				
				var count = parseInt(json['count']),
					error = parseInt(json['error']),
					currResults = form.data('results')
				;
				
				currResults.count += isNaN(count) ? 0 : count;
				currResults.error += isNaN(error) ? 0 : error;
				
				form.data('results', currResults);
				
				logTextArea[0].scrollTop = logTextArea[0].scrollHeight;
				
				IMDBO_generateIndexForTable(
					form, data, listTables, currNum + 1, onLoad
				)
			}
		});	
	}
	
	// Рекурсивный обход
	function IMDBO_generateIndexes(form, onLoad)
	{
		var logTextArea = form.find('.imdbo-log-container'),
			sendData = form.serializeArray(),
			tables = form.find('input[name="tables"]:checked'),
			listTables = []
		;
		
		tables.each(function () {
			listTables.push(jQuery(this).val());
		});
		
		logTextArea.val('');
		logTextArea[0].scrollTop = logTextArea[0].scrollHeight; 
		
		imdbo.setTextStatus(form, {
	        selector: '.generate-status',
	        text: module_texts.startGen
	    });
	    
	    form.data('results', {
	    	count: 0,
	    	error: 0
	    });
	    
	    IMDBO_generateIndexForTable(
	    	form, sendData, listTables, 0, function (form) {
				imdbo.setTextSuccess(form, {
			        selector: '.generate-status',
			        text: module_texts.genOk
			    });
			    
			    var currResults = form.data('results')
			    ;
			    
			    logTextArea.val(
			    	logTextArea.val()
			    	+ '\n------------------------------------------------\n'
			    	+ module_texts.genIndAll + currResults.count
			    	+ '\n'
			    	+ module_texts.genIndAllErr + currResults.error
			    	+ '\n'
			    	+ module_texts.genOk
			    );
			    logTextArea[0].scrollTop = logTextArea[0].scrollHeight;
			}
	    );
	}

	// Удаление индексов для одной таблицы в БД
	function IMDBO_removeIndexForTable(form, data, listTables, currNum, onLoad)
	{
		if (listTables.length <= currNum) {
			if (typeof(onLoad) === 'function') {
				onLoad(form);
				return;
			}
		}
		
		var sendData = [],
			logTextArea = form.find('.imdbo-log-container')
		;
		
		for(var cnt = 0; cnt < data.length; cnt++) {
			sendData.push(data[cnt]);
		}
		
		sendData.push({
			name: 'IMDBOptimizer[table]',
			value: listTables[currNum]
		});
		
		logTextArea.val(
			logTextArea.val()
			+ '\n------------------------\n'
			+ (currNum + 1) + '. ' + listTables[currNum]
			+ '\n------------------------\n'
			+ module_texts.startRemove
		);
		
		logTextArea[0].scrollTop = logTextArea[0].scrollHeight; 
		
		IMDBO_ajaxOperation({
			form: form,
			data: sendData,
			url: module_links.removeIndexForTable,
			status: {
				selector: 'not-need',
				text: {
					action: '',
					success: '',
					fail: ''
				}
			},
			onLoad: function (json) {
				var logTextArea = form.find('.imdbo-log-container')
				;
				
				logTextArea.val(
					logTextArea.val() 
					+ '\n'
					+ json['report']
					+ '\n'
					+ (json['success'] ? module_texts.removeOk : module_texts.removeFail)
					+ '\n------------------------\n'
				);
				
				var count = parseInt(json['count']),
					error = parseInt(json['error']),
					currResults = form.data('results')
				;
				
				currResults.count += isNaN(count) ? 0 : count;
				currResults.error += isNaN(error) ? 0 : error;
				
				form.data('results', currResults);
				
				logTextArea[0].scrollTop = logTextArea[0].scrollHeight;
				
				IMDBO_removeIndexForTable(
					form, data, listTables, currNum + 1, onLoad
				)
			}
		});	
	}
	
	// Рекурсивный обход
	function IMDBO_removeIndexes(form, onLoad)
	{
		var logTextArea = form.find('.imdbo-log-container'),
			sendData = form.serializeArray(),
			tables = form.find('input[name="tables"]:checked'),
			listTables = []
		;
		
		tables.each(function () {
			listTables.push(jQuery(this).val());
		});
		
		logTextArea.val('');
		logTextArea[0].scrollTop = logTextArea[0].scrollHeight; 
		
		imdbo.setTextStatus(form, {
	        selector: '.generate-status',
	        text: module_texts.startRemove
	    });
	    
	    form.data('results', {
	    	count: 0,
	    	error: 0
	    });
	    
	    IMDBO_removeIndexForTable(
	    	form, sendData, listTables, 0, function (form) {
				imdbo.setTextSuccess(form, {
			        selector: '.generate-status',
			        text: module_texts.removeOk
			    });
			    
			    var currResults = form.data('results')
			    ;
			    
			    logTextArea.val(
			    	logTextArea.val()
			    	+ '\n------------------------------------------------\n'
			    	+ module_texts.removeIndAll + currResults.count
			    	+ '\n'
			    	+ module_texts.removeIndAllErr + currResults.error
			    	+ '\n'
			    	+ module_texts.removeOk
			    );
			    logTextArea[0].scrollTop = logTextArea[0].scrollHeight;
			}
	    );
	}
	
	//////////////////////////////////////////////
	// Загрузка DOM
	//////////////////////////////////////////////
	jQuery(function () {
		jQuery('#imdbopt .btn-im-generate').click(function () {
			IMDBO_generateIndexes(jQuery(this).closest('form'));
		});

		jQuery('#imdbopt .btn-im-show-data').click(function () {
			IMDBO_getDBData(jQuery(this).closest('form'));
		});

		jQuery('#imdbopt .btn-im-remove').click(function () {
			IMDBO_removeIndexes(jQuery(this).closest('form'));
		});
	});
</script>


<style type="text/css">
	.IMDBOptimizer .form-group 
	{
	    padding-top: 15px;
	    padding-bottom: 15px;
	    margin-bottom: 0;
	}

	.IMDBOptimizer .form-group span.blue
	{
		color: #000042;
    	font-size: 15px;
	}

	.IMDBOptimizer .clear
	{
		clear: both;
	}

	.IMDBOptimizer .well .row .form-group
	{
	    padding-top: 5px;
	    padding-bottom: 8px;
	    margin-bottom: 0;
	}

	.IMDBOptimizer .hidden
	{
		display: none;
	}
	
	select.im-product-list-select 
	{
	    height: 305px;
	}

	.IMDBOptimizer .iml-cursor
	{
		cursor: pointer;
	}
	
	.IMDBOptimizer .save-status.success,
	.IMDBOptimizer .generate-status.success,
	.IMDBOptimizer .generate-schema-status.success,
	.IMDBOptimizer .get-product-status.success,
	.IMDBOptimizer .get-delete-settings-status.success
	{
    	color: green;
	}

	.IMDBOptimizer .save-status.fail,
	.IMDBOptimizer .generate-status.fail,
	.IMDBOptimizer .generate-schema-status.fail,
	.IMDBOptimizer .get-product-status.fail,
	.IMDBOptimizer .get-delete-settings-status.fail
	{
    	color: red;
	}

	.IMDBOptimizer .textcontrol-min-height
	{
		min-height: 100px;
	}

</style>

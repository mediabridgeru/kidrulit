<?php echo $header; ?><?php //echo $column_left; ?>

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

			$result .= '<a class="imdbo-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', true);">Выделить всё</a>'
				. ' / '
				. '<a class="imdbo-cursor" onclick="$(this).parent().find(\':checkbox\').prop(\'checked\', false);">Снять выделение</a>'
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
		<div class="content IMDBOptimizer" >
			<!-- --------------------------------------------------- -->
			<!-- OpenCart Style Start -->
			<!-- --------------------------------------------------- -->
			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
					<ul class="nav nav-pills" id="imdbo-tabs">
						<li>
							<a href="#imdbopt" data-toggle="tab">
								<i class="fa fa-share-alt"></i>
								<?php echo echoLabel($module_label, 'label_tab_dbopt'); ?>
							</a>	
						</li>
						<li>
							<a href="#imdbopt-service" data-toggle="tab">
								<i class="fa fa-laptop"></i>
								<?php echo echoLabel($module_label, 'label_tab_service'); ?>
							</a>	
						</li>
						<li>
							<a href="#imdbopt-cache" data-toggle="tab">
								<i class="fa fa-history"></i>
								<?php echo echoLabel($module_label, 'label_tab_cache'); ?>
							</a>	
						</li>
						<li>
							<a href="#imdbosettings" data-toggle="tab">
								<i class="fa fa-cog"></i>
								<?php echo echoLabel($module_label, 'label_tab_settings'); ?>
							</a>
						</li>
					</ul>
					<div class="tab-content">
					<!-- ------------ -->
					<!-- DBOPT -->
					<!-- ------------ -->
					<?php echo $imdbo_dbopt_view; ?>

					<!-- ------------ -->
					<!-- DBOPT Service -->
					<!-- ------------ -->
					<?php echo $imdbo_service_view; ?>

					<!-- ------------ -->
					<!-- DBOPT Cache -->
					<!-- ------------ -->
					<?php echo $imdbo_cache_view; ?>

					<!-- ------------ -->
					<!-- Settings -->
					<!-- ------------ -->
					<?php echo $imdbo_settings_view; ?>
				
					</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="panel panel-default">
					<div class="panel-body">
					Igor Mirochnik &copy; IMDBOptimizer <?php echo $module_version; ?>
					| <a href="mailto:dev.imirochnik@gmail.com"><i class="fa fa-envelope-o fa-fw"></i> dev.imirochnik@gmail.com</a>
					| <a href="http://im-cloud.ru/" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> IM-Cloud.ru</a>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				var module_links = {
					cancel: 
						decodeURIComponent('<?php echo $module_links["cancel"] ?>')
						.replace('&amp;', '&'),
					getDBData: 
						decodeURIComponent('<?php echo $module_links["getDBData"] ?>')
						.replace('&amp;', '&'),
					generateIndexForTable: 
						decodeURIComponent('<?php echo $module_links["generateIndexForTable"] ?>')
						.replace('&amp;', '&'),
					removeIndexForTable: 
						decodeURIComponent('<?php echo $module_links["removeIndexForTable"] ?>')
						.replace('&amp;', '&'),
					optimizeTable: 
						decodeURIComponent('<?php echo $module_links["optimizeTable"] ?>')
						.replace('&amp;', '&'),
					repairTable: 
						decodeURIComponent('<?php echo $module_links["repairTable"] ?>')
						.replace('&amp;', '&'),
					saveIMDBOSettings:
						decodeURIComponent('<?php echo $module_links["saveIMDBOSettings"] ?>')
						.replace('&amp;', '&'),
					saveCacheSettings:
						decodeURIComponent('<?php echo $module_links["saveCacheSettings"] ?>')
						.replace('&amp;', '&'),
					clearCache:
						decodeURIComponent('<?php echo $module_links["clearCache"] ?>')
						.replace('&amp;', '&')
				};
				var module_label = {
					attrAdd: "<?php echo echoLabel($module_btn_label, 'button_attr_add'); ?>",
					optionAdd: "<?php echo echoLabel($module_btn_label, 'button_option_add'); ?>"
				};
			</script>
			<script type="text/javascript">
				var module_texts = {
					save: 'Сохраняем...',
					saveSetOk: 'Настройки cохранены!',
					saveSetFail: 'Настройки не cохранены!',
					// Генерация
					startGen: 'Начинаем генерацию...',
					genOk: 'Генерация завершена!',
					genFail: 'Генерация не завершена!',
					genIndAll: 'Сгенерировано индексов: ',
					genIndAllErr: 'Количество ошибок: ',
					// Удаление
					startRemove: 'Начинаем удаление...',
					removeOk: 'Удаление завершено!',
					removeFail: 'Удаление не завершено!',
					removeIndAll: 'Удалено индексов: ',
					removeIndAllErr: 'Количество ошибок: ',
					// Оптимизация
					startOptimize: 'Начинаем оптимизацию...',
					optimizeOk: 'Оптимизация завершена!',
					optimizeFail: 'Оптимизация не завершена!',
					optimizeAll: 'Оптимизировано таблиц: ',
					optimizeAllErr: 'Количество ошибок: ',
					// Починка
					startRepair: 'Начинаем починку...',
					repairOk: 'Починка завершена!',
					repairFail: 'Починка не завершена!',
					repairAll: 'Починено таблиц: ',
					repairAllErr: 'Количество ошибок: '
				};
				
				var module_labels = {
				};
			</script>
			<script type="text/javascript">
				
				// Ajax-операция
				function IMDBO_ajaxOperation(options) {
					var form = options.form
					;
					
					if (jQuery(form).length == 0 || !options.form)
						return;
					
					if ((options.status || {}).selector) {
					    imdbo.setTextStatus(form, {
					        selector: options.status.selector,
					        inTable: !!options.status.inTable,
					        text: options.status.text.action
					    });
					}
					
					// Выполняем запрос
					jQuery.ajax({
						type: 'POST',
						url: options.url,		
						data: (options.data ? options.data : form.serializeArray()),
						dataType: 'json',
						success: function(json) {
							if ((options.status || {}).selector) {
								if (json['success']) {
								    imdbo.setTextSuccess(form, {
								        selector: options.status.selector,
								        inTable: !!options.status.inTable,
								        text: options.status.text.success
								    });
								}
								else {
								    imdbo.setTextFail(form, {
								        selector: options.status.selector,
								        inTable: !!options.status.inTable,
								        text: options.status.text.fail
								    });
								}
							}
							if(typeof options.onLoad == 'function') {
								options.onLoad(json);
							}
						}
					});
				}
			
				function IMDBO_saveIMDBOSettings(form, isNoReload) {
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;
					
				    imdbo.setTextStatus(form, {
				        selector: '.save-imdbo-settings-status',
				        text: module_texts.save
				    });

					// Сохраняем данные
					jQuery.ajax({
						type: 'POST',
						url: module_links.saveIMDBOSettings,		
						data: form.serializeArray(),
						dataType: 'json',
						success: function(json) {
							if (json['success']) {
							    imdbo.setTextSuccess(form, {
							        selector: '.save-imdbo-settings-status',
							        text: module_texts.saveSetOk,
							        onAnimate: function () {
							        	if (!isNoReload) {
											window.location = window.location;
											if (window.location.reload) {
												window.location.reload();
											}
										}
									}
							    });
							} else {
							    imdbo.setTextFail(form, {
							        selector: '.save-imdbo-settings-status',
							        text: module_texts.saveSetFail
							    });
							}
						}
					});				
				}

				// Получить данные таблиц
				function IMDBO_getDBData(form, onLoad) 
				{
					// Форма еще не выстроена
					if (form.serializeArray().length == 0)
						return;
					
					var sendData = form.serializeArray(),
						tables = form.find('input[name="tables"]:checked')
					;
					
					tables.each(function () {
						sendData.push({
							name: 'IMDBOptimizer[tables][]',
							value: jQuery(this).val()
						});
					});
					
					IMDBO_ajaxOperation({
						form: form,
						data: sendData,
						url: module_links.getDBData,
						status: {
							selector: '.generate-status',
							text: {
								action: 'Загружаем...',
								success: 'Данные загружены!',
								fail: 'Данные не загружены!'
							}
						},
						onLoad: function (json) {
							if(json['success']) {
								var logTextArea = form.find('.imdbo-log-container')
								;
								
								logTextArea.val('');
								logTextArea[0].scrollTop = logTextArea[0].scrollHeight;
								
								logTextArea.val(json['report']);
							}
							
							if (typeof(onLoad) === 'function') {
								onLoad(form, json);
							}
						}
					});	
				}
	
				jQuery(function () {
					
					jQuery('#imdbo-tabs a:first').tab('show');
					
					// Сохраняем настройки IMDBO
					jQuery('.IMDBOptimizer .btn-imdbo-settings-save').click(function () {
						IMDBO_saveIMDBOSettings(jQuery(this).closest('form'));
					});

					// Сохраняем настройки IMDBO без перезагрузки
					jQuery('.IMDBOptimizer .btn-imdbo-settings-save-no-reload').click(function () {
						IMDBO_saveIMDBOSettings(jQuery(this).closest('form'), true);
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

	.IMDBOptimizer a.btn 
	{
	    display: inline-block;
	    margin-bottom: 0;
	    font-weight: normal;
	    text-align: center;
	    vertical-align: middle;
	    touch-action: manipulation;
	    cursor: pointer;
	    background-image: none;
	    border: 1px solid transparent;
	    white-space: nowrap;
	    padding: 8px 13px;
	    font-size: 12px;
	    line-height: 1.42857;
	    border-radius: 3px;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	}

	.IMDBOptimizer a.btn-info 
	{
	    color: #fff;
	    background-color: #5bc0de;
	    border-color: #39b3d7;
	}

	.IMDBOptimizer a.btn-danger 
	{
		color: #fff;
		background-color: #f56b6b;
		border-color: #f24545;
	}
	
	.IMDBOptimizer a.btn-warning
	{
		color: #fff;
		background-color: #f38733;
		border-color: #ef710e;
	}

	.IMDBOptimizer a.btn-success 
	{
	    color: #fff;
	    background-color: #8fbb6c;
	    border-color: #7aae50;
	}
	
	.IMDBOptimizer a.btn-primary 
	{
	    color: #fff;
	    background-color: #1e91cf;
	    border-color: #1978ab;
	}
	
	.IMDBOptimizer input[type='text'], 
	.IMDBOptimizer input[type='password'] 
	{
	    padding: 12px;
	}
	
	/* Fix End */
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

	.IMDBOptimizer textarea.form-control
	{
		min-height: 120px;
	}

	.IMDBOptimizer textarea.form-control.imdbo-log-container
	{
		min-height: 250px;
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

	.IMDBOptimizer .imdbo-cursor
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

<?php echo $footer; ?>

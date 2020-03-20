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
	
?>

<!-- ------------ -->
<!-- DBOpt Service -->
<!-- ------------ -->
<div class="tab-pane" id="imdbopt-cache">
		
	<form class="form IMDBOptimizer-form" 
		action="<?php echo $replace; ?>" method="post" 
		enctype="multipart/form-data" 
		id="form_imdbo_cache"
	>

		<div class="well">
			<div class="row">
				<div class="col-sm-12">
					<?php
						echo
						//$data, $name, $module_label, $label = '', $value = '', $append_class = '',
						//			$is_multi = false, $val_name = 'id', $text_name = 'name'
						echoSelectControl(
							$list_on_off,
							'IMDBOptimizer[cache][enable]',
							$module_label,
							'label_field_cache_enable',
							isset($data_cache['enable']) ? $data_cache['enable'] : 0,
							''
						);
					?>
				</div>
				<div class="col-sm-6">
					<?php
						echo
						//$name, $module_label, $label = '', $value = '', $append_class = '')
						echoInputControl(
							'IMDBOptimizer[cache][maxdblen]',
							$module_label,
							'label_field_cache_maxdblen',
							isset($data_cache['maxdblen']) ? $data_cache['maxdblen'] : 20000,
							''
						);
					?>
				</div>
				<div class="col-sm-6">
					<?php
						echo
						//$name, $module_label, $label = '', $value = '', $append_class = '')
						echoInputControl(
							'IMDBOptimizer[cache][expire]',
							$module_label,
							'label_field_cache_expire',
							isset($data_cache['expire']) ? $data_cache['expire'] : 3600,
							''
						);
					?>
				</div>
				<div class="col-sm-12">
					<?php
						echo echoTextAreaControl(
							'IMDBOptimizer[cache][filters]',
							$module_label,
							'label_field_cache_filters',
							isset($data_cache['filters']) ? $data_cache['filters'] : '',
							''
						);
					?>
				</div>
				<div class="col-sm-12">
					<?php
						echo echoTextAreaControl(
							'IMDBOptimizer[cache][urls]',
							$module_label,
							'label_field_cache_urls',
							isset($data_cache['urls']) ? $data_cache['urls'] : '',
							''
						);
					?>
				</div>
				
				<!-------------------------->
				<!-- Buttons -->
				<!-------------------------->
				
				<div class="col-sm-12">
					<div class="form-group">
						<div class="buttons">
							<a class="button btn-im-save btn btn-success" 
								style="color:white">
								<i class="fa fa-save"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_save_cache_settings'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							<a class="button btn-im-clear-cache btn btn-danger" 
								style="color:white">
								<i class="fa fa-remove"></i> &nbsp; 
								<?php echo 
									echoLabel($module_btn_label, 'button_clear_cache'); ?>
							</a>
							&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;
							<span class="generate-status"></span>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<hr/>
				</div>

			</div>
		</div>

	</form>
</div>

<script type="text/javascript">

	function IMDBO_saveCacheSettings(form, onLoad)
	{
		// Форма еще не выстроена
		if (form.serializeArray().length == 0)
			return;
		
		IMDBO_ajaxOperation({
			form: form,
			data: form.serializeArray(),
			url: module_links.saveCacheSettings,
			status: {
				selector: '.generate-status',
				text: {
					action: 'Сохраняем...',
					success: 'Данные сохранены!',
					fail: 'Данные не сохранены!'
				}
			},
			onLoad: function (json) {
				if (typeof(onLoad) === 'function') {
					onLoad(form, json);
				}
			}
		});	
	}

	function IMDBO_clearCache(form, onLoad)
	{
		// Форма еще не выстроена
		if (form.serializeArray().length == 0)
			return;
		
		IMDBO_ajaxOperation({
			form: form,
			data: form.serializeArray(),
			url: module_links.clearCache,
			status: {
				selector: '.generate-status',
				text: {
					action: 'Удаляем...',
					success: 'Кэш удален!',
					fail: 'Кэш не удален!'
				}
			},
			onLoad: function (json) {
				if (typeof(onLoad) === 'function') {
					onLoad(form, json);
				}
			}
		});	
	}

	//////////////////////////////////////////////
	// Загрузка DOM
	//////////////////////////////////////////////
	jQuery(function () {
		jQuery('#imdbopt-cache .btn-im-save').click(function () {
			IMDBO_saveCacheSettings(jQuery(this).closest('form'));
		});

		jQuery('#imdbopt-cache .btn-im-clear-cache').click(function () {
			IMDBO_clearCache(jQuery(this).closest('form'));
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

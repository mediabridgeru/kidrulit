<?php
/*
    @author: Igor Mirochnik
    @copyright:  Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
*/

	if (!function_exists('echoHtmlSelect')) {
		// Формирование html select
		function echoHtmlSelect($name, $data, $curr_val, $append_class = '', 
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

	if (!function_exists('echoLabel')) {
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

	if (!function_exists('echoDate')) {
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
	
	if (!function_exists('echoTextAreaControl')) {
		function echoTextAreaControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class="col-sm-3 control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="col-sm-9">'
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

	if (!function_exists('echoInputControl')) {
		function echoInputControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return 
				'<div class="form-group ">'
	    			. '<label class="col-sm-3 control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="col-sm-9">'
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
	
	if (!function_exists('echoSelectControl')) {
		function echoSelectControl($name, $data, $module_label, $label = '', $value = '', $append_class = '', $is_multi = false)
		{
			return
				'<div class="form-group ">'
	    			. '<label class="col-sm-3 control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="col-sm-9">'
	      				. echoHtmlSelect($name, $data, $value, $append_class, $is_multi)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
	if (!function_exists('echoTypeControl')) {
		function echoTypeControl($name, $module_label, $label = '', $value = '', $append_class = '')
		{
			return
				'<div class="form-group ">'
	    			. '<label class="col-sm-3 control-label" for="">'
	    				. echoLabel($module_label, $label)
	    			. '</label>'
	    			. '<div class="col-sm-9">'
	      				. echoHtmlSelectType($name, $value, $append_class, false)
					. '</div>'
		  		. '</div>'
			;
		}
	}
	
?>

<div class="">
<form class="form imrep-form-settings"
	action="<?php echo $report_links['saveIMRepSettings']; ?>" method="post" 
>
	<div class="well">
		<div class="row">
			<div class="col-sm-12">
				<h3>
					<?php echo echoLabel($module_label, 'label_setting_h_product_image'); ?>
				</h3>
				<hr/>
			</div>
			<div class="col-sm-12">
				<?php 
					echo echoSelectControl(
						'IMReport[IMReportData_p_img_use]',
						$list_on_off,
						$module_label,
						'label_setting_p_img_use',
						$list_module_settings['IMReportData_p_img_use'],
						'',
						false
					);
				?>
			</div>
			<div class="col-sm-12">
				<?php 
					echo echoInputControl(
						'IMReport[IMReportData_p_img_w]',
						$module_label,
						'label_setting_p_img_w',
						$list_module_settings['IMReportData_p_img_w'],
						''
					); 
				?>
			</div>
			<div class="col-sm-12">
				<?php 
					echo echoInputControl(
						'IMReport[IMReportData_p_img_h]',
						$module_label,
						'label_setting_p_img_h',
						$list_module_settings['IMReportData_p_img_h'],
						''
					); 
				?>
			</div>
			<div class="col-sm-12">
				<hr/>
			</div>
			<div class="col-sm-12">
				<h3>
					<?php echo echoLabel($module_label, 'label_setting_h_csv_iconv'); ?>
				</h3>
				<hr/>
			</div>
			<div class="col-sm-12">
				<?php 
					echo echoSelectControl(
						'IMReport[IMReportData_csv_iconv]',
						$list_iconv_enc_csv,
						$module_label,
						'label_setting_csv_iconv',
						$list_module_settings['IMReportData_csv_iconv'],
						'',
						false
					);
				?>
			</div>
			<div class="col-sm-12">
				<hr/>
			</div>
			<div class="col-sm-12">
				<h3>
					<?php echo echoLabel($module_label, 'label_setting_h_license'); ?>
				</h3>
				<hr/>
			</div>
			<div class="col-sm-12">
				<?php
					echo echoTextAreaControl(
						'IMReport[IMReportData_key]',
						$module_label,
						'label_lic_key',
						$lic_info["key"],
						'textcontrol-min-height'
					);
				?>
			</div>
			<div class="col-sm-12">
				<?php
					echo echoInputControl(
						'IMReport[IMReportData_enc_mess]',
						$module_label,
						'label_lic_enc_mess',
						$lic_info["enc_mess"],
						''
					);
				?>
			</div>

			<div class="col-sm-12">
				<?php
					echo echoInputControl(
						'date_until',
						$module_label,
						'label_lic_date_until',
						$lic_info["date_until"],
						''
					);
				?>
			</div>
			<div class="col-sm-12">
				<hr/>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<div class="buttons">
						<button class="button btn btn-imrep-settings-save btn btn-primary" 
							style="color:white">
							<i class="fa fa-save"></i> &nbsp; 
							<?php echo 
								echoLabel($module_button, 'button_save_settings'); ?>
						</button>
						<span class="save-imrep-settings-status"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>

<script type="text/javascript">
	////////////////////////////////////////
	// Сохранение настроек				
	////////////////////////////////////////
	
	function IMR_saveIMRepSettings(form) {
		// Форма еще не выстроена
		if (form.serializeArray().length == 0)
			return;
		
	    imrep.setTextStatus(form, {
	        selector: '.save-imrep-settings-status',
	        text: ajaxStatusSpan.save
	    });

		// Сохраняем данные
		jQuery.ajax({
			type: 'POST',
			url: form.attr('action'),		
			data: form.serializeArray(),
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
				    imrep.setTextSuccess(form, {
				        selector: '.save-imrep-settings-status',
				        text: ajaxStatusSpan.ok,
				        onAnimate: function () {
							window.location = window.location;
							if (window.location.reload) {
								window.location.reload();
							}
						}
				    });
				} else {
				    imci.setTextFail(form, {
				        selector: '.save-imrep-settings-status',
				        text: ajaxStatusSpan.fail
				    });
				}
			}
		});				
	}
</script>

<style type="text/css">
	.form-group span.blue
	{
		color: #000042;
    	font-size: 15px;
	}
	
	.IMReport .imrep-form-settings textarea
	{
		height: 100px;
	}
	
	.IMReport .form-group label.col-sm-3.control-label 
	{
	    line-height: 35px;
	    margin: 0px;
	}

	.IMReport .well .row .form-group
	{
	    padding-top: 5px;
	    padding-bottom: 8px;
	    margin-bottom: 0;
	}

</style>

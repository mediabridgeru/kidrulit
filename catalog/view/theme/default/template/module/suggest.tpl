<?php
if ($suggest_status == 1) {
	?>
    <script type="text/javascript">
        var status = '<?php echo $suggest_status;?>';
        function initFields(ev) {
            var e = ev || false;
            if (status == '1') {
                $('div.content').css('overflow', 'visible');
				<?php
				if (!empty($suggest_fio)) {
				foreach ($suggest_fio as $suggest_fio_group_key=>$suggest_fio_group) {
				$fio_group_is_active=0;
				if (isset($suggest_fio_group['data']) && !empty($suggest_fio_group['data']))
					foreach ($suggest_fio_group['data'] as $key=>$fio_field) {
						if ($fio_field['status']==1) {
							$fio_group_is_active=1;
							break;
						}
					}
				if ($fio_group_is_active) {
				?>
                FullNameSuggestions.init({
                    fields: [
						<?php
						foreach ($suggest_fio_group['data'] as $fio_field) {
							if ($fio_field['status']==1) {
								$fio_field['group_key']=$suggest_fio_group_key;
								$fio_field['group_id']=$suggest_fio_group['group_id'];
								unset($fio_field['status']);
								echo json_encode($fio_field).','."\n";
							}
						}
						?>

                    ],
                    tips: "<?php echo $suggest_tips;?>",
                    correction: "<?php echo $suggest_correction; ?>",
                });
				<?php
				}
				}
				}
				?>
				<?php
				if (!empty($suggest_address)) {
				foreach ($suggest_address as $suggest_address_group_key=>$suggest_address_group) {
				$address_group_is_active=0;
				if (isset($suggest_address_group['data']) && !empty($suggest_address_group['data']))
					foreach ($suggest_address_group['data'] as $key=>$address_field) {
						if ($address_field['status']==1) {
							$address_group_is_active=1;
							break;
						}
					}
				if ($address_group_is_active) {
				?>

                FullAddressSuggestions.init({
                    fields: [
						<?php
						$last_active_key=0;
						foreach ($suggest_address_group['data'] as $address_field) {
							if ($address_field['status']==1) {
								if ($address_field['type']=='input') {
									//$last_active_key=$key;
								}
								$address_field['group_key']=$suggest_address_group_key;
								$address_field['group_id']=$suggest_address_group['group_id'];
								$last_active_key++;
								unset($address_field['status']);
								echo json_encode($address_field).','."\n";
							} else { $last_active_key=$last_active_key-1; }
						}
						?>
                    ],
                    group_key: "<?php echo $suggest_address_group_key;?>",
                    event: e,
                    last_active_key: "<?php echo $last_active_key; ?>",
                    tips: "<?php echo $suggest_tips;?>",
                    geoLocation: <?php echo ($suggest_geo==1) ? 'true' : 'false'; ?>

                });
				<?php }
				}
				}
				?>
				<?php
				if (!empty($suggest_email)) {
				foreach ($suggest_email as $suggest_email_group_key=>$suggest_email_group) {
				$email_group_is_active=0;
				if (isset($suggest_email_group['data']) && !empty($suggest_email_group['data']))
					foreach ($suggest_email_group['data'] as $key=>$email_field) {
						if ($email_field['status']==1) {
							$email_group_is_active=1;
							break;
						}
					}
				if ($email_group_is_active) {
				?>
                EmailSuggestions.init({
                    fields: [
						<?php foreach ($suggest_email_group['data'] as $email_field) {
						if ($email_field['status']==1) {
							$email_field['group_key']=$suggest_email_group_key;
							$email_field['group_id']=$suggest_email_group['group_id'];
							unset($email_field['status']);
							echo json_encode($email_field).','."\n";
						}
					}
						?>
                    ],
                    tips: "<?php echo $suggest_tips;?>",
                    correction: "<?php echo $suggest_correction; ?>",
                });
				<?php }
				}
				}
				?>
				<?php if ($address_group_is_active) { ?>

                //var fieldname = FullAddressSuggestions.options.fields[FullAddressSuggestions.options.last_active_key].name;

                //if ($("input[name*='" + fieldname + "']").suggestions()) {
                //   $("input[name*='" + fieldname + "']").suggestions().fixData();
                // }
				<?php } ?>
            }
        }

        $(document).ready(function (e) {
            initFields();
            $(document).ajaxComplete(function (e, xhr, settings) {
                if (settings.url.indexOf("checkout/") > 0 || settings.url.indexOf("account/") > 0) {
                    initFields(e);
                }
            });

            $('input[name*="custom_inn"]').suggestions({
                serviceUrl: "index.php?route=module/suggest/request&r=",
                type: "PARTY",
                deferRequestBy: 200,
                count: 10,

                onSelect: function(suggestion) {
                    var data = suggestion.data;
                    $(this).val(data.inn);
                    $('input[name*="custom_kpp"]').val(data.kpp);
                    $('input[name*="custom_law_address"]').val(data.address.value);
                    $('input[name*="custom_company"]').val(data.name.full_with_opf);
                }
            });

            $('input[name*="custom_bank_bic"]').suggestions({
                serviceUrl: "index.php?route=module/suggest/request&r=",
                type: "BANK",
                deferRequestBy: 200,
                count: 10,

                onSelect: function(suggestion) {
                    var data = suggestion.data;
                    $(this).val(data.bic);
                    $('input[name*="custom_bank_name"]').val(data.name.full);
                    $('input[name*="custom_cor_account"]').val(data.correspondent_account);
                }
            });
        });

    </script>
<?php } ?>
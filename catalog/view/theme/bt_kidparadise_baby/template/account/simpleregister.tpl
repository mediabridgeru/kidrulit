<?php 
$simple_page = 'simpleregister';
include $simple->tpl_header();
include $simple->tpl_static();
?>
<div class="simple-content">
    <p class="simpleregister-have-account"><?php echo $text_account_already; ?></p>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="simpleregister">
        <div class="simpleregister">
            <?php
                $first_field = reset($customer_fields); 
                $first_field_header = !empty($first_field) && $first_field['type'] == 'header'; 
                $i = 0;
                $j = 0;
            ?>
            <?php if ($first_field_header) { ?>
                <?php echo $first_field['tag_open'] ?><?php echo $first_field['label'] ?><?php echo $first_field['tag_close'] ?>
            <?php } ?>
                <div class="simpleregister-block-content">
                <table class="simplecheckout-customer">
                    <?php foreach ($customer_fields as $field) { ?>
                        <?php if ($field['type'] == 'hidden') { continue; } ?>
                        <?php if ($j == 0 && $simple_registration_view_customer_type) { ?>
                            <tr>
                                <td class="simplecheckout-customer-left">
                                    <span class="simplecheckout-required">*</span>
                                    <?php echo $entry_customer_type ?>
                                </td>
                                <td class="simplecheckout-customer-right">
                                    <?php if ($simple_type_of_selection_of_group == 'select') { ?>
                                    <select name="customer_group_id" onchange="$('#simpleregister').submit();">
                                        <?php foreach ($customer_groups as $id => $name) { ?>
                                        <option value="<?php echo $id ?>" <?php echo $id == $customer_group_id ? 'selected="selected"' : '' ?>><?php echo $name ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } else { ?>
                                        <?php foreach ($customer_groups as $id => $name) { ?>
                                        <label><input type="radio" name="customer_group_id" onchange="$('#simpleregister').submit();" value="<?php echo $id ?>" <?php echo $id == $customer_group_id ? 'checked="checked"' : '' ?>><?php echo $name ?></label><br>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $j++; ?>
                        <?php } ?>
                        <?php $i++ ?>
                        <?php if ($field['type'] == 'header') { ?>
                        <?php if ($i == 1) { ?>
                            <?php continue; ?>
                        <?php } else { ?>
                        </table>
                        </div>
                        <?php echo $field['tag_open'] ?><?php echo $field['label'] ?><?php echo $field['tag_close'] ?>
                        <div class="simpleregister-block-content">
                        <table class="simplecheckout-customer">
                        <?php } ?>
                        <?php } else { ?>
                            <tr class="simple_table_row <?php echo (!empty($field['object_field'])) ? $field['object_field'] : ''; ?>">
                                <td class="simplecheckout-customer-left">
                                    <?php if ($field['required']) { ?>
                                        <span class="simplecheckout-required">*</span>
                                    <?php } ?>
                                    <?php echo $field['label'] ?>
                                </td>
                                <td class="simplecheckout-customer-right">
                                    <?php echo $simple->html_field($field) ?>
                                    <?php if (!empty($field['error']) && $simple_create_account) { ?>
                                        <span class="simplecheckout-error-text"><?php echo $field['error']; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($field['id'] == 'main_email') { ?>
                            <?php if ($simple_registration_view_email_confirm) { ?>
                            <tr>
                                <td class="simplecheckout-customer-left">
                                    <span class="simplecheckout-required">*</span>
                                    <?php echo $entry_email_confirm ?>
                                </td>
                                <td class="simplecheckout-customer-right">
                                    <input name="email_confirm" id="email_confirm" type="text" value="<?php echo $email_confirm ?>">
                                    <span class="simplecheckout-error-text" id="email_confirm_error" <?php if (!($email_confirm_error && $simple_create_account)) { ?>style="display:none;"<?php } ?>><?php echo $error_email_confirm; ?></span>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr <?php echo $simple_registration_generate_password ? 'style="display:none;"' : '' ?>>
                                <td class="simplecheckout-customer-left">
                                    <span class="simplecheckout-required">*</span>
                                    <?php echo $entry_password ?>:
                                </td>
                                <td class="simplecheckout-customer-right">
                                    <input type="password" name="password" value="<?php echo $password ?>">
                                    <?php if ($error_password && $simple_create_account) { ?>
                                        <span class="simplecheckout-error-text"><?php echo $error_password; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php if ($simple_registration_password_confirm) { ?>
                            <tr <?php echo $simple_registration_generate_password ? 'style="display:none;"' : '' ?>>
                                <td class="simplecheckout-customer-left">
                                    <span class="simplecheckout-required">*</span>
                                    <?php echo $entry_password_confirm ?>:
                                </td>
                                <td class="simplecheckout-customer-right">
                                    <input type="password" name="password_confirm" value="<?php echo $password_confirm ?>">
                                    <?php if ($error_password_confirm && $simple_create_account) { ?>
                                        <span class="simplecheckout-error-text"><?php echo $error_password_confirm; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($simple_registration_subscribe == 2) { ?>
                        <tr>
                          <td class="simplecheckout-customer-left"><?php echo $entry_newsletter; ?></td>
                          <td class="simplecheckout-customer-right">
                            <label><input type="radio" name="subscribe" value="1" <?php if ($subscribe) { ?>checked="checked"<?php } ?> /><?php echo $text_yes; ?></label>
                            <label><input type="radio" name="subscribe" value="0" <?php if (!$subscribe) { ?>checked="checked"<?php } ?> /><?php echo $text_no; ?></label>
                          </td>
                        </tr>
                    <?php } ?>
                    <?php if ($simple_registration_captcha) { ?>
                        <tr>
                            <td class="simplecheckout-customer-left">
                                <span class="simplecheckout-required">*</span>
                                <?php echo $entry_captcha ?>:
                            </td>
                            <td class="simplecheckout-customer-right">
                                <input type="text" name="captcha" value="" />
                                <?php if ($error_captcha && $simple_create_account) { ?>
                                    <span class="simplecheckout-error-text"><?php echo $error_captcha; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                          <td class="simplecheckout-customer-left"></td>
                          <td class="simplecheckout-customer-right"><img src="index.php?<?php echo $simple->tpl_joomla_route() ?>route=product/product/captcha" alt="" id="captcha" /></td>
                        </tr>
                    <?php } ?>
                </table>        
                <?php foreach ($customer_fields as $field) { ?>
                    <?php if ($field['type'] != 'hidden') { continue; } ?>
                    <?php echo $simple->html_field($field) ?>
                <?php } ?>
                <input type="hidden" name="simple_create_account" id="simple_create_account" value="">
            </div>
        </div>
        <div>
            <input type="checkbox" id="acceptance" name="acceptance" <?php if(isset($acceptance)) echo "checked"; ?>>
            <label for="acceptance">Даю согласие на обработку персональных данных</label><br>
            <small>Ставя отметку, я даю свое согласие на обработку моих персональных данных в соответствии с законом №152-ФЗ «О персональных данных» от 27.07.2006 и принимаю условия <a href="<?php echo $oferta; ?>" style="color: #e85e5e;">Пользовательского соглашения&#8203;&#8203;</a></small>
        </div>
        <div class="simpleregister-button-block buttons">
            <div class="simpleregister-button-right">
                <?php if ($simple_registration_agreement_checkbox) { ?>
                    <label><input type="checkbox" name="agree" value="1" <?php if ($agree == 1) { ?>checked="checked"<?php } ?> /><?php echo $text_agree; ?></label>&nbsp;
                <?php } ?>
                <a onclick="if(!$('#acceptance')[0].checked){alert('Необходимо согласиться с условиями пользовательского соглашения!');return false;}$('#simple_create_account').val(1);$('#simpleregister').submit();" class="button btn"><span><?php echo $button_continue; ?></span></a>
            </div>
        </div>
    </form>
</div>
<script>
    function set_customer_type() {
        var custom_customer_type = $('input[name*="custom_customer_type"]:checked').val();
        if (custom_customer_type === 'individual') {
            $('.simple_table_row.ip_type, .simple_table_row.legal_type').hide();
        } else
        if (custom_customer_type === 'ip') {
            $('.simple_table_row.ip_type').show();
            $('.simple_table_row.legal_type').hide();
        } else
        if (custom_customer_type === 'legal') {
            $('.simple_table_row.ip_type').hide();
            $('.simple_table_row.legal_type').show();
        }
    }

    $(document).ready(function() {
        set_customer_type();

        $('input[name*="custom_customer_type"]').change(function() {
            set_customer_type();
        });
    });
</script>
<?php include $simple->tpl_footer() ?>
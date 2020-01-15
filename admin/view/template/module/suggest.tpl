<?php echo $header; ?>
    <style>
        #fio-field-values input, #fio-field-values select {
            width: 70%;
        }
    </style>
<div id="content">
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
        href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
<div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>

    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a
            onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
    </div>
</div>
<div class="content">
<div id="tabs" class="htabs">
    <a href="#tab-general" class="selected" style="display: inline;">Основные настройки</a>
    <a href="#tab-fields" style="display: inline;">Настройки полей</a>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div id="tab-general" style="display: block;">
    <table id="module" class="form">
        <tr>
            <td>
                <span class="required">*</span>
                <?php echo $entry_api; ?>
            </td>
            <td>
                <input type="hidden" name="suggest_version" value="<?php echo $version; ?>" />
                <input name="suggest_api" size="50" value="<?php echo $suggest_api; ?>" />
                <?php if (isset($error_api)) { ?>
                    <span class="error"><?php echo $error_api; ?></span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $entry_tips; ?>
            </td>
            <td>
                <input name="suggest_tips" value="<?php echo $suggest_tips; ?>" />
            </td>
        </tr>
        <tr>
            <td><?php echo $entry_geo; ?></td>
            <td>
                <select name="suggest_geo">
                    <?php if ($suggest_geo) { ?>
                        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                        <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                        <option value="1"><?php echo $text_yes; ?></option>
                        <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $entry_status; ?></td>
            <td class="left">
                <select name="suggest_status">
                    <?php if ($suggest_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php echo "Установить демо-данные настроек полей:"; ?></td>
            <td>
                <input type="submit"
                       formaction="<?php echo $this->url->link('module/suggest/installDefaultDemoData', 'token=' . $this->session->data['token'], 'SSL'); ?>"
                       name="demo_default" value="Обычный заказ\регистрация" />
                <input type="submit"
                       formaction="<?php echo $this->url->link('module/suggest/installSimpleDemoData', 'token=' . $this->session->data['token'], 'SSL'); ?>"
                       name="demo_default" value="Simple - упрощенная регистрация и заказ" />
            </td>
        </tr>
    </table>
</div>
<div id="tab-fields" style="display: block;">
<div class="vtabs">
    <a href="#tab-fio-fields" class="selected">ФИО</a>
    <a href="#tab-address-fields">Адрес</a>
    <a href="#tab-email-fields">E-mail</a>
</div>
<div id="tab-fio-fields" class="vtabs-content" style="display: block;">
    <?php
    $fio_group_key = 0;
    if (!empty($fio_groups)) {
        foreach ($fio_groups as $fio_group_key => $fio_group) {
            ?>
            <div class="box" id="suggest_fio-group_<?php echo $fio_group_key; ?>">
                <div class="heading"><h2 class="dadata-heading"><span>группа <?php echo $fio_group_key + 1; ?></span>
                    </h2></div>
                <table class="form list" style="margin-bottom: 0;">
                    <tr>
                        <td>html-идентификатор группы<br>(id # или class .):</td>
                        <td><input type="text" size="50" name="suggest_fio[<?php echo $fio_group_key; ?>][group_id]"
                                   value="<?php echo $fio_group['group_id']; ?>"></td>
                    </tr>
                </table>
                <table id="fio-field-values" class="list">
                    <thead>
                    <tr>
                        <td class="left"><?php echo "Имя поля (атрибут name)"; ?></td>
                        <td class="left"><?php echo "Что подсказывать" ?></td>
                        <td class="left"><?php echo "Статус"; ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="left">
                            <span class="help">html-атрибут "name"</span>
                        </td>
                        <td class="left">
                            <span class="help">Для выбора нескольких значений используйте ctrl+клик.</span>
                        </td>
                        <td class="left">
                            <span class="help">Активность подсказок.</span>
                        </td>
                        <td>
                            <span class="help">Действия.</span>
                        </td>
                    </tr>
                    </tbody>
                    <?php
                    $fio_field_key = 0;
                    if (isset($fio_group['data']) && !empty($fio_group['data']))
                        foreach ($fio_group['data'] as $fio_field_key => $fio_field) {
                            ?>
                            <tbody id="fio-field-value-row_<?php echo $fio_group_key; ?>_<?php echo $fio_field_key; ?>">
                            <tr>
                                <td class="left"><input type="text"
                                                        name="suggest_fio[<?php echo $fio_group_key; ?>][data][<?php echo $fio_field_key; ?>][name]"
                                                        value="<?php echo $fio_field['name']; ?>" size="40" /></td>
                                <td class="left"><select multiple
                                                         name="suggest_fio[<?php echo $fio_group_key; ?>][data][<?php echo $fio_field_key; ?>][parts][]">
                                        <?php if (isset($fio_field_parts_data)) { ?>
                                            <?php foreach ($fio_field_parts_data as $fio_field_part_data) { ?>
                                                <?php
                                                $fio_part_selected_trigger = 0;
                                                foreach ($fio_field['parts'] as $fio_field_saved_part) {
                                                    if ($fio_field_saved_part == $fio_field_part_data['value']) {
                                                        ?>
                                                        <option value="<?php echo $fio_field_part_data['value']; ?>"
                                                                selected="selected"><?php echo $fio_field_part_data['name']; ?></option>
                                                        <?php
                                                        $fio_part_selected_trigger = 1;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <?php if ($fio_part_selected_trigger == 0) { ?>
                                                    <option
                                                        value="<?php echo $fio_field_part_data['value']; ?>"><?php echo $fio_field_part_data['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td class="left">
                                    <select
                                        name="suggest_fio[<?php echo $fio_group_key; ?>][data][<?php echo $fio_field_key; ?>][status]">
                                        <?php if ($fio_field['status']) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="left"><a
                                        onclick="$('#fio-field-value-row_<?php echo $fio_group_key; ?>_<?php echo $fio_field_key; ?>').remove();"
                                        class="button"><?php echo $button_remove; ?></a></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="left"><a onclick="addFioFieldValue(<?php echo $fio_group_key; ?>);"
                                           class="button"><?php echo "Добавить поле"; ?></a></td>
                        <td class="left"><a onclick="$('#suggest_fio-group_<?php echo $fio_group_key; ?>').remove();"
                                            class="button"><?php echo "Удалить группу"; ?></a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        <?php
        }
    } ?>
    <a onclick="addFioGroup();" id="addFioGroup" class="button">Добавить группу</a>
</div>
<div id="tab-address-fields" class="vtabs-content" style="display: block;">
    <?php
    $address_group_key = 0;
    if (!empty($address_groups)) {
        foreach ($address_groups as $address_group_key => $address_group) {
            ?>
            <div class="box" id="suggest_address-group_<?php echo $address_group_key; ?>">
                <div class="heading"><h2 class="dadata-heading"><span>группа <?php echo $address_group_key + 1; ?></span>
                    </h2></div>
                <table class="form list" style="margin-bottom: 0;">
                    <tr>
                        <td>html-идентификатор группы<br>(id # или class .):</td>
                        <td><input type="text" size="50" name="suggest_address[<?php echo $address_group_key; ?>][group_id]"
                                   value="<?php echo $address_group['group_id']; ?>"></td>
                    </tr>
                </table>
                <table id="address-field-values" class="list">
                    <thead>
                    <tr>
                        <td class="left"><?php echo "Имя поля (атрибут name)"; ?></td>
                        <td class="left"><?php echo "Тип поля"; ?></td>
                        <td class="left"><?php echo "Что подсказывать/чем заполнять" ?></td>
                        <td class="left"><?php echo "Область поиска (атрибут name)" ?></td>
                        <td class="left"><?php echo "Статус"; ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="left">
                            <span class="help">html-атрибут "name".</span>
                        </td>
                        <td class="left">
										<span class="help">
											input или select
										</span>
                        </td>
                        <td class="left">
                            <span class="help">Для выбора нескольких значений используйте ctrl+клик.</span>
                        </td>
                        <td class="left">
										<span class="help">должен совпадать с одним из имен полей подсказок.<br />
											Устанавливает область поиска подсказок.
										</span>
                        </td>
                        <td class="left">
                            <span class="help">Активность подсказок.</span>
                        </td>
                        <td>
                            <span class="help">Действия.</span>
                        </td>
                    </tr>
                    </tbody>
                    <?php
                    $address_field_key = 0;
                    if (isset($address_group['data']) && !empty($address_group['data']))
                        foreach ($address_group['data'] as $address_field_key => $address_field) {
                        ?>
                        <tbody id="address-field-value-row_<?php echo $address_group_key; ?>_<?php echo $address_field_key; ?>">
                        <tr>
                            <td class="left"><input type="text"
                                                    name="suggest_address[<?php echo $address_group_key;?>][data][<?php echo $address_field_key; ?>][name]"
                                                    value="<?php echo $address_field['name']; ?>" size="40" /></td>
                            <td class="left">
                                <select name="suggest_address[<?php echo $address_group_key;?>][data][<?php echo $address_field_key; ?>][type]">
                                    <?php foreach ($fieldTypes as $addFieldType) {
                                        if ($address_field['type'] == $addFieldType['value']) {
                                            ?>
                                            <option value="<?php echo $addFieldType['value']; ?>"
                                                    selected="selected"><?php echo $addFieldType['name']; ?></option>
                                        <?php
                                        } else {
                                            ?>
                                            <option
                                                value="<?php echo $addFieldType['value']; ?>"><?php echo $addFieldType['name']; ?></option>
                                        <?php
                                        }
                                    } ?>
                                </select>
                            </td>
                            <td class="left"><select multiple
                                                     name="suggest_address[<?php echo $address_group_key;?>][data][<?php echo $address_field_key; ?>][parts_suggest][]"
                                                     size="7">
                                    <?php
                                    if (isset($address_field_parts_data)) {
                                        ?>
                                        <?php foreach ($address_field_parts_data as $address_field_part_data) { ?>
                                            <?php
                                            $address_part_selected_trigger = 0;
                                            foreach ($address_field['parts_suggest'] as $address_field_saved_part) {
                                                if ($address_field_saved_part == $address_field_part_data['value']) {
                                                    ?>
                                                    <option value="<?php echo $address_field_part_data['value']; ?>"
                                                            selected="selected"><?php echo $address_field_part_data['name']; ?></option>
                                                    <?php
                                                    $address_part_selected_trigger = 1;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <?php if ($address_part_selected_trigger == 0) { ?>
                                                <option
                                                    value="<?php echo $address_field_part_data['value']; ?>"><?php echo $address_field_part_data['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left"><input type="text"
                                                    name="suggest_address[<?php echo $address_group_key;?>][data][<?php echo $address_field_key; ?>][constraint]"
                                                    value="<?php echo $address_field['constraint']; ?>" size="40" />
                            </td>
                            <td class="left">
                                <select name="suggest_address[<?php echo $address_group_key;?>][data][<?php echo $address_field_key; ?>][status]">
                                    <?php if ($address_field['status']) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="left"><a
                                    onclick="$('#address-field-value-row_<?php echo $address_group_key;?>_<?php echo $address_field_key; ?>').remove();"
                                    class="button"><?php echo $button_remove; ?></a></td>
                        </tr>
                        </tbody>
                    <?php } ?>
                    <tfoot>
                    <tr>
                        <td colspan="5" class="left"><a onclick="addAddressFieldValue(<?php echo $address_group_key;?>);"
                                           class="button"><?php echo "Добавить поле"; ?></a></td>
                        <td class="left"><a onclick="$('#suggest_address-group_<?php echo $address_group_key; ?>').remove();"
                                            class="button"><?php echo "Удалить группу"; ?></a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        <?php
        }
    } ?>
    <a onclick="addAddressGroup();" id="addAddressGroup" class="button">Добавить группу</a>
</div>
<div id="tab-email-fields" class="vtabs-content" style="display: block;">
<?php
$email_group_key = 0;
if (!empty($email_groups)) {
    foreach ($email_groups as $email_group_key => $email_group) {
        ?>
        <div class="box" id="suggest_email-group_<?php echo $email_group_key; ?>">
            <div class="heading"><h2 class="dadata-heading"><span>группа <?php echo $email_group_key + 1; ?></span>
                </h2></div>
            <table class="form list" style="margin-bottom: 0;">
                <tr>
                    <td>html-идентификатор группы<br>(id # или class .):</td>
                    <td><input type="text" size="50" name="suggest_email[<?php echo $email_group_key; ?>][group_id]"
                               value="<?php echo $email_group['group_id']; ?>"></td>
                </tr>
            </table>
        <table id="email-field-values" class="list">
        <thead>
        <tr>
            <td class="left"><?php echo "Имя поля (name):"; ?></td>
            <td class="left"><?php echo "Статус:"; ?></td>
            <td></td>
        </tr>
        </thead>
            <tbody>
            <tr>
                <td class="left">
                    <span class="help">html-атрибут "name", только поля типа input.</span>
                </td>

                <td class="left">
                    <span class="help">Активность подсказок.</span>
                </td>
                <td class="left">
                    <span class="help">Действия.</span>
                </td>
            </tr>
            </tbody>
    <?php
    $email_field_key = 0;
    if (isset($email_group['data']) && !empty($email_group['data']))
        foreach ($email_group['data'] as $email_field_key => $email_field) {
    ?>
    <tbody id="email-field-value-row_<?php echo $email_group_key; ?>_<?php echo $email_field_key; ?>">
    <tr>
            <td class="left">
            <input size="40" name="suggest_email[<?php echo $email_group_key; ?>][data][<?php echo $email_field_key; ?>][name]"
                   value="<?php echo isset($email_field['name']) ? $email_field['name'] : ''; ?>" />
            </td>
            <td class="left">
                <select name="suggest_email[<?php echo $email_group_key; ?>][data][<?php echo $email_field_key; ?>][status]">
                    <?php if (isset($email_field['status']) && $email_field['status']) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="left"><a
                onclick="$('#email-field-value-row_<?php echo $email_group_key;?>_<?php echo $email_field_key; ?>').remove();"
                class="button"><?php echo $button_remove; ?></a>
            </td>
        </tr>
    </tbody>
    <?php } ?>
            <tfoot>
            <tr>
                <td colspan="2" class="left"><a onclick="addEmailFieldValue(<?php echo $email_group_key;?>);"
                                   class="button"><?php echo "Добавить поле"; ?></a></td>
                <td class="left"><a onclick="$('#suggest_email-group_<?php echo $email_group_key; ?>').remove();"
                                    class="button"><?php echo "Удалить группу"; ?></a></td>
            </tr>
            </tfoot>
    </table>
   </div>
        <?php }
    } ?>
    <a onclick="addEmailGroup();" id="addEmailGroup" class="button">Добавить группу</a>
</div>
</div>
<?php foreach ($modules as $mod_id => $mod_val)
    foreach ($mod_val as $attr_id => $attr_val) {
        ?>
        <input type="hidden" value="<?php echo $attr_val ?>"
               name="suggest_module[<?php echo $mod_id ?>][<?php echo $attr_id ?>]" />
    <?php } ?>
</form>
				<span class="help"
                      style="text-align: center;clear:both;">Автор модуля: Александр Ефремов.<br /> Skype:<a
                        href="skype:efremovav91">efremovav91</a>, E-mail: <a
                        href="mailto:alex_uralsk14@mail.ru">alex_uralsk14@mail.ru</a><br />Все права защищены.</span>
</div>
</div>
<script type="text/javascript">
    $("#tabs a").tabs();
    $('#tab-fields .vtabs a').tabs();
</script>
<script type="text/javascript"><!--
    var fio_group_keys = [];
    <?php if (!empty($fio_groups)) {
        foreach ($fio_groups as $fio_group_key=>$fio_group) {
            $fio_fields_count=0;
            if (isset($fio_group['data']) && !empty($fio_group['data'])) {
                $fio_fields_count=count($fio_group['data']);
            } ?>
        fio_group_keys[<?php echo $fio_group_key;?>] =<?php echo $fio_fields_count; ?>;
        <?php }
    } ?>
    var address_group_keys =[];
    <?php if (!empty($address_groups)) {
            foreach ($address_groups as $address_group_key=>$address_group) {
                $address_fields_count=0;
                if (isset($address_group['data']) && !empty($address_group['data'])) {
                    $address_fields_count=count($address_group['data']);
                } ?>
    address_group_keys[<?php echo $address_group_key;?>] =<?php echo $address_fields_count; ?>;
    <?php }
    } ?>
    var email_group_keys =[];
    <?php if (!empty($email_groups)) {
            foreach ($email_groups as $email_group_key=>$email_group) {
                $email_fields_count=0;
                if (isset($email_group['data']) && !empty($email_group['data'])) {
                    $email_fields_count=count($email_group['data']);
                } ?>
    email_group_keys[<?php echo $email_group_key;?>] =<?php echo $email_fields_count; ?>;
    <?php }
    } ?>

    var fio_groups_count=<?php echo count($fio_groups); ?>;
    var address_groups_count=<?php echo count($address_groups); ?>;
    var email_groups_count=<?php echo count($email_groups); ?>;

    function addFioGroup() {
        var group_key=0;
        var new_group_index=fio_group_keys.length;
        if (fio_groups_count>0) {
            group_key=fio_groups_count;
        }
        group_key++;

        html ='<div class="box" id="suggest_fio-group_'+new_group_index+'">';
        html+='<div class="heading"><h2 class="dadata-heading"><span>группа '+group_key+'</span></h2></div>';
        html+='<table class="form list" style="margin-bottom: 0;"><tr>';
        html+='<td>html-идентификатор группы<br>(id # или class .):</td>';
        html+='<td><input type="text" size="50" name="suggest_fio['+new_group_index+'][group_id]" value=""></td>';
        html+='</tr></table>';
        html+='<table id="fio-field-values" class="list"><thead><tr>';
        html+='<td class="left">Имя поля (атрибут name)</td>';
        html+='<td class="left">Что подсказывать</td>';
        html+='<td class="left">Статус</td>';
        html+='<td></td></tr></thead>';
        html+='<tbody><tr>';
        html+='<td class="left"><span class="help">html-атрибут "name".</span></td>';
        html+='<td class="left"><span class="help">Для выбора нескольких значений используйте ctrl+клик.</span></td>';
        html+='<td class="left"><span class="help">Активность подсказок.</span></td>';
        html+='<td><span class="help">Действия.</span></td>';
        html+='</tr></tbody>';
        html+='<tfoot><tr>';
        html+='<td colspan="3" class="left"><a onclick="addFioFieldValue('+new_group_index+');" class="button">Добавить поле</a></td>';
        html+='<td class="left"><a onclick=\'$("#suggest_fio-group_'+new_group_index+'").remove();\' class="button">Удалить группу</a></td>';
        html+='</tr></tfoot></table></div>';
        $('#addFioGroup').before(html);
        fio_groups_count++;
        fio_group_keys[new_group_index]=0;

    }

    function addAddressGroup() {
        var group_key=0;
        var new_group_index=address_group_keys.length;
        if (address_groups_count>0) {
            group_key=address_groups_count;
        }
        group_key++;

        html ='<div class="box" id="suggest_address-group_'+new_group_index+'">';
        html+='<div class="heading"><h2 class="dadata-heading"><span>группа '+group_key+'</span></h2></div>';
        html+='<table class="form list" style="margin-bottom: 0;"><tr>';
        html+='<td>html-идентификатор группы<br>(id # или class .):</td>';
        html+='<td><input type="text" size="50" name="suggest_address['+new_group_index+'][group_id]" value=""></td>';
        html+='</tr></table>';
        html+='<table id="address-field-values" class="list"><thead><tr>';
        html+='<td class="left">Имя поля (атрибут name)</td>';
        html+='<td class="left">Тип поля</td>';
        html+='<td class="left">Что подсказывать</td>';
        html+='<td class="left">Область поиска (атрибут name)</td>';
        html+='<td class="left">Статус</td>';
        html+='<td></td></tr></thead>';
        html+='<tbody><tr>';
        html+='<td class="left"><span class="help">html-атрибут "name".</span></td>';
        html+='<td class="left"><span class="help">input или select</span></td>';
        html+='<td class="left"><span class="help">Для выбора нескольких значений используйте ctrl+клик.</span></td>';
        html+='<td class="left"><span class="help">';
        html+='должен совпадать с одним из имен полей подсказок.<br>Устанавливает область поиска подсказок.</span></td>';
        html+='<td class="left"><span class="help">Активность подсказок.</span></td>';
        html+='<td><span class="help">Действия.</span></td>';
        html+='</tr></tbody>';
        html+='<tfoot><tr>';
        html+='<td colspan="5" class="left"><a onclick="addAddressFieldValue('+new_group_index+');" class="button">Добавить поле</a></td>';
        html+='<td class="left"><a onclick=\'$("#suggest_address-group_'+new_group_index+'").remove();\' class="button">Удалить группу</a></td>';
        html+='</tr></tfoot></table></div>';
        $('#addAddressGroup').before(html);
        address_groups_count++;
        address_group_keys[new_group_index]=0;
    }

    function addEmailGroup() {
        var group_key=0;
        var new_group_index=email_group_keys.length;
        if (email_groups_count>0) {
            group_key=email_groups_count;
        }
        group_key++;

        html ='<div class="box" id="suggest_email-group_'+new_group_index+'">';
        html+='<div class="heading"><h2 class="dadata-heading"><span>группа '+group_key+'</span></h2></div>';
        html+='<table class="form list" style="margin-bottom: 0;"><tr>';
        html+='<td>html-идентификатор группы<br>(id # или class .):</td>';
        html+='<td><input type="text" size="50" name="suggest_email['+new_group_index+'][group_id]" value=""></td>';
        html+='</tr></table>';
        html+='<table id="email-field-values" class="list"><thead><tr>';
        html+='<td class="left">Имя поля (name)</td>';
        html+='<td class="left">Статус</td>';
        html+='<td></td></tr></thead>';
        html+='<tbody><tr>';
        html+='<td class="left"><span class="help">html-атрибут "name", только поля типа input.</span></td>';
        html+='<td class="left"><span class="help">Активность подсказок.</span></td>';
        html+='<td><span class="help">Действия.</span></td>';
        html+='</tr></tbody>';
        html+='<tfoot><tr>';
        html+='<td colspan="2" class="left"><a onclick="addEmailFieldValue('+new_group_index+');" class="button">Добавить поле</a></td>';
        html+='<td class="left"><a onclick=\'$("#suggest_email-group_'+new_group_index+'").remove();\' class="button">Удалить группу</a></td>';
        html+='</tr></tfoot></table></div>';
        $('#addEmailGroup').before(html);
        email_groups_count++;
        email_group_keys[new_group_index]=0;
    }

    function addFioFieldValue(current_fio_group_key) {
        html = '<tbody id="fio-field-value-row_' + current_fio_group_key + '_' + fio_group_keys[current_fio_group_key] + '">';
        html += '<tr>';
        html += '<td class="left"><input type="text" name="suggest_fio[' + current_fio_group_key + '][data][' + fio_group_keys[current_fio_group_key] + '][name]" size="40" /></td>';
        html += '<td class="left"><select multiple name="suggest_fio[' + current_fio_group_key + '][data][' + fio_group_keys[current_fio_group_key] + '][parts][]">';
        <?php if (isset($fio_field_parts_data)) { ?>
        <?php foreach ($fio_field_parts_data as $fio_field_part_data) { ?>
        html += '<option value="<?php echo $fio_field_part_data['value']; ?>"><?php echo $fio_field_part_data['name']; ?></option>';
        <?php }
    } ?>
        html += '</select></td>';
        html += '<td class="left"><select name="suggest_fio[' + current_fio_group_key + '][data][' + fio_group_keys[current_fio_group_key] + '][status]">';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>'
        html += '</select></td>';
        html += '<td class="left"><a onclick="$(\'#fio-field-value-row_' + current_fio_group_key + '_' + fio_group_keys[current_fio_group_key] + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
        html += '  </tr>';
        html += '</tbody>';
        fio_group_keys[current_fio_group_key]++;
        $('#suggest_fio-group_' + current_fio_group_key + ' tfoot').before(html);
    }

    function addAddressFieldValue(current_address_group_key) {
        html = '<tbody id="address-field-value-row_' + current_address_group_key + '_'+address_group_keys[current_address_group_key]+'">';
        html += '<tr>';
        html += '<td class="left"><input type="text" name="suggest_address[' + current_address_group_key + '][data][' + address_group_keys[current_address_group_key] + '][name]" size="40" /></td>';
        html += '<td><select name="suggest_address[' + current_address_group_key + '][data][' + address_group_keys[current_address_group_key] + '][type]">';
        <?php foreach ($fieldTypes as $addFieldType) { ?>

        html += '<option value="<?php echo $addFieldType['value']; ?>"><?php echo $addFieldType['name']; ?></option>';
        <?php }
    ?>
        html += '</select></td>';
        html += '<td><select multiple name="suggest_address[' + current_address_group_key + '][data][' + address_group_keys[current_address_group_key] + '][parts_suggest][]" size="7">';
        <?php if (isset($address_field_parts_data)) { ?>
        <?php foreach ($address_field_parts_data as $address_field_part_data) { ?>
        html += '<option value="<?php echo $address_field_part_data['value']; ?>"><?php echo $address_field_part_data['name']; ?></option>';
        <?php }
    } ?>
        html += '</select></td>';
        html += '<td class="left"><input type="text" name="suggest_address[' + current_address_group_key + '][data][' + address_group_keys[current_address_group_key] + '][constraint]" size="40" /></td>';
        html += '<td class="left"><select name="suggest_address[' + current_address_group_key + '][data][' + address_group_keys[current_address_group_key] + '][status]">';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>'
        html += '</select></td>';
        html += '<td class="left"><a onclick="$(\'#address-field-value-row_' +current_address_group_key + '_'+address_group_keys[current_address_group_key]+'\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
        html += '  </tr>';
        html += '</tbody>';
        address_group_keys[current_address_group_key]++;
        $('#suggest_address-group_' + current_address_group_key + ' tfoot').before(html);
    }

    function addEmailFieldValue(current_email_group_key) {
        html = '<tbody id="email-field-value-row_' + current_email_group_key + '_' + email_group_keys[current_email_group_key] + '">';
        html += '<tr>';
        html += '<td class="left"><input type="text" name="suggest_email[' + current_email_group_key + '][data][' + email_group_keys[current_email_group_key] + '][name]" size="40" /></td>';
        html += '<td class="left"><select name="suggest_email[' + current_email_group_key + '][data][' + email_group_keys[current_email_group_key] + '][status]">';
        html += '<option value="0"><?php echo $text_disabled; ?></option>';
        html += '<option value="1"><?php echo $text_enabled; ?></option>'
        html += '</select></td>';
        html += '<td class="left"><a onclick="$(\'#email-field-value-row_' + current_email_group_key + '_' + email_group_keys[current_email_group_key] + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
        html += '  </tr>';
        html += '</tbody>';
        email_group_keys[current_email_group_key]++;
        $('#suggest_email-group_' + current_email_group_key + ' tfoot').before(html);
    }
    //--></script>
<?php echo $footer; ?>
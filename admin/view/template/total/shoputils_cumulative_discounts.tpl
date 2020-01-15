<?php
/*
 * Shoputils
 *
 * ПРИМЕЧАНИЕ К ЛИЦЕНЗИОННОМУ СОГЛАШЕНИЮ
 *
 * Этот файл связан лицензионным соглашением, которое можно найти в архиве,
 * вместе с этим файлом. Файл лицензии называется: LICENSE.1.5.x.RUS.txt
 * Так же лицензионное соглашение можно найти по адресу:
 * http://opencart.shoputils.ru/LICENSE.1.5.x.RUS.txt
 * 
 * =================================================================
 * OPENCART 1.5.x ПРИМЕЧАНИЕ ПО ИСПОЛЬЗОВАНИЮ
 * =================================================================
 *  Этот файл предназначен для Opencart 1.5.x. Shoputils не
 *  гарантирует правильную работу этого расширения на любой другой 
 *  версии Opencart, кроме Opencart 1.5.x. 
 *  Shoputils не поддерживает программное обеспечение для других 
 *  версий Opencart.
 * =================================================================
*/
?>
<?php echo $header; ?>
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
    <h1><img src="view/image/total.png"><?php echo $heading_title; ?></h1>

    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a
            onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    </div>
</div>
<div class="content">
<div id="tabs" class="htabs"><a href="#tab_general"><?php echo $tab_general; ?></a><a
        href="#tab_discount"><?php echo $tab_cumulative_discounts; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div id="tab_general">
        <table class="form">
            <tr>
                <td><?php echo $entry_status; ?></td>
                <td><select name="shoputils_cumulative_discounts_status">
                    <?php if ($shoputils_cumulative_discounts_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                </select></td>
            </tr>
            <tr>
                <td><?php echo $entry_sort_order; ?></td>
                <td><input type="text" name="shoputils_cumulative_discounts_sort_order"
                           value="<?php echo $shoputils_cumulative_discounts_sort_order; ?>" size="1"/></td>
            </tr>
            <tr>
                <td><?php echo $entry_discount_order_statuses; ?>
                    <div class="help"><?php echo $entry_discount_order_statuses_help ?></div>
                </td>
                <td>
                    <div class="scrollbox">
                        <?php $class = 'even'; ?>
                        <?php foreach ($order_statuses as $status) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                            <?php if (in_array($status['order_status_id'], $shoputils_cumulative_discounts_statuses)) { ?>
                            <input type="checkbox" name="shoputils_cumulative_discounts_statuses[]"
                                   value="<?php echo $status['order_status_id']; ?>" checked/>
                            <?php } else { ?>
                            <input type="checkbox" name="shoputils_cumulative_discounts_statuses[]"
                                   value="<?php echo $status['order_status_id']; ?>"/>
                            <?php } ?>
                            <?php echo $status['name']; ?>
                        </div>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <?php if ($language['status']) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img
                    src="view/image/flags/<?php echo $language['image']; ?>"
                    title="<?php echo $language['name']; ?>"/> <?php echo $language['name']; ?></a>
            <?php } ?>
            <?php } ?>
        </div>
        <?php foreach ($languages as $language) { ?>
        <?php if ($language['status']) { ?>
        <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
                <tr>
                    <td><?php echo $entry_description_before; ?><br><span
                            class="help"><?php echo $entry_description_before_help; ?></span></td>
                    <td><textarea id="description_before<?php echo $language['language_id']; ?>"
                                  name="cmsdata[<?php echo $language['language_id']; ?>][description_before]"><?php echo isset($cmsdata[$language['language_id']]) ? $cmsdata[$language['language_id']]['description_before'] : ''; ?></textarea>
                </tr>
                <tr>
                    <td><?php echo $entry_description_after; ?><br><span
                            class="help"><?php echo $entry_description_after_help; ?></span></td>
                    <td><textarea id="description_after<?php echo $language['language_id']; ?>"
                                  name="cmsdata[<?php echo $language['language_id']; ?>][description_after]"><?php echo isset($cmsdata[$language['language_id']]) ? $cmsdata[$language['language_id']]['description_after'] : ''; ?></textarea>
                </tr>
            </table>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
    <div id="tab_discount">
        <table id="discount" class="list">
            <thead>
            <tr>
                <td width="35%" class="left" rowspan="2"><?php echo $entry_discount_params; ?><br/><span
                        class="help"><?php echo $entry_discount_params_help; ?></span></td>
                <td class="left"><?php echo $entry_discount_stores; ?><br/><span
                        class="help"><?php echo $entry_discount_stores_help; ?></span></td>
                <td width="20%" class="left" rowspan="2"><?php echo $entry_discount_description; ?><br/><span
                        class="help"><?php echo $entry_discount_description_help; ?></span></td>
                <td class="left" rowspan="2"></td>
            </tr>
            <tr>
                <td class="left"><?php echo $entry_discount_customer_groups; ?><br/><span
                        class="help"><?php echo $entry_discount_customer_groups_help; ?></span></td>
            </tr>
            </thead>
            <?php $discount_row = 0; ?>
            <?php foreach ($discounts as $discount) {
            $discount_stores = $discount['stores'];  
            $discount_customer_groups = $discount['customer_groups'];  
            $discount_descriptions = $discount['descriptions'];  
          ?>
            <tbody id="discount_row<?php echo $discount_row; ?>">
            <tr>
                <td rowspan="2">
                    <table width="100%" class="list">
                        <tr>
                            <td class="left"><?php echo $entry_discount_days; ?><br/><span
                                    class="help"><?php echo $entry_discount_days_help; ?></td>
                            <td class="center"><input type="text"
                                                      name="discounts[<?php echo $discount_row; ?>][days]"
                                                      value="<?php echo $discount['days']; ?>" size="8"/>
                        </tr>
                        <tr>
                            <td class="left"><?php echo $entry_discount_summ; ?><br/><span
                                    class="help"><?php echo $entry_discount_summ_help; ?></td>
                            <td class="center"><input type="text"
                                                      name="discounts[<?php echo $discount_row; ?>][summ]"
                                                      value="<?php echo $discount['summ']; ?>" size="8"/>
                        </tr>
                        <tr>
                            <td class="left"><?php echo $entry_discount_percent; ?><br/><span
                                    class="help"><?php echo $entry_discount_percent_help; ?></td>
                            <td class="center"><input type="text"
                                                      name="discounts[<?php echo $discount_row; ?>][percent]"
                                                      value="<?php echo $discount['percent']; ?>" size="8"/>
                        </tr>
                    </table>
                </td>
                <td class="left">
                    <div class="scrollbox">
                        <?php $class = 'even'; ?>
                        <div class="<?php echo $class; ?>">
                            <?php if (in_array(0, $discount_stores)) { ?>
                            <input type="checkbox" name="discounts[<?php echo $discount_row; ?>][stores][0]"
                                   value="0" checked/>
                            <?php echo $text_default; ?>
                            <?php } else { ?>
                            <input type="checkbox" name="discounts[<?php echo $discount_row; ?>][stores][0]"
                                   value="0"/>
                            <?php echo $text_default; ?>
                            <?php } ?>
                        </div>
                        <?php foreach ($stores as $store) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                            <?php if (in_array($store['store_id'], $discount_stores)) { ?>
                            <input type="checkbox" name="discounts[<?php echo $discount_row; ?>][stores][]"
                                   value="<?php echo $store['store_id']; ?>" checked/>
                            <?php echo $store['name']; ?>
                            <?php } else { ?>
                            <input type="checkbox" name="discounts[<?php echo $discount_row; ?>][stores][]; ?>"
                                   value="<?php echo $store['store_id']; ?>"/>
                            <?php echo $store['name']; ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </td>
                <td class="left" rowspan="2">
                    <?php foreach ($languages as $language) { ?>
                    <img src="view/image/flags/<?php echo $language['image'] ?>"
                         title="<?php echo $language['name'] ?>"/>&nbsp;<span class="bold"><?php echo $language['name'] ?>: </span><br/>
                    <textarea type="text" cols="38" rows="4"
                              name="discounts[<?php echo $discount_row; ?>][descriptions][<?php echo $language['language_id'] ?>]"><?php echo $discount_descriptions[$language['language_id']]?></textarea>
                    <?php } ?>
                </td>
                <td class="center" rowspan="2"><a
                        onclick="$('#discount_row<?php echo $discount_row; ?>').remove();"
                        class="button"><span><?php echo $button_remove_discount; ?></span></a></td>
            </tr>
            <tr>
                <td class="left">
                    <div class="scrollbox">
                        <?php $class = 'odd'; ?>
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                            <?php if (in_array($customer_group['customer_group_id'], $discount_customer_groups)) { ?>
                            <input type="checkbox"
                                   name="discounts[<?php echo $discount_row; ?>][customer_groups][]"
                                   value="<?php echo $customer_group['customer_group_id']; ?>" checked/>
                            <?php echo $customer_group['name']; ?>
                            <?php } else { ?>
                            <input type="checkbox"
                                   name="discounts[<?php echo $discount_row; ?>][customer_groups][]; ?>"
                                   value="<?php echo $customer_group['customer_group_id']; ?>"/>
                            <?php echo $customer_group['name']; ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            </tbody>
            <?php $discount_row++; }?>
            <tfoot>
            <tr>
                <td colspan="3"><span class="help"><?php echo $entry_discount_help?></span></td>
                <td class="center"><a onclick="addDiscount();"
                                      class="button"><span><?php echo $button_add_discount; ?></span></a></td>
            </tr>
            </tfoot>
        </table>
    </div>
</form>
</div>
</div>
</div>

<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
	var html  = '<tbody id="discount_row' + discount_row + '">';
	html += '<tr>';
	html += '<td rowspan="2">';
    html += '<table width="100%" class="list">';
    html += '<tr>';
    html += '<td class="left"><?php echo $entry_discount_days; ?><br/><span class="help"><?php echo $entry_discount_days_help; ?></td>';
    html += '<td class="center"><input type="text" name="discounts[' + discount_row + '][days]" value="" size="8" /></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td class="left"><?php echo $entry_discount_summ; ?><br/><span class="help"><?php echo $entry_discount_summ_help; ?></td>';
    html += '<td class="center"><input type="text" name="discounts[' + discount_row + '][summ]" value="" size="8" /></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td class="left"><?php echo $entry_discount_percent; ?><br/><span class="help"><?php echo $entry_discount_percent_help; ?></td>';
    html += '<td class="center"><input type="text" name="discounts[' + discount_row + '][percent]" value="" size="8" /></td>';
    html += '</tr>';
    html += '</table>';
	html += '</td>';
    html += '<td class="left">';
    html += '<div class="scrollbox">';
    <?php $class = 'even'; ?>
    html += '<div class="<?php echo $class; ?>">';
    html += '<input type="checkbox" name="discounts[' + discount_row + '][stores][]" value="0" checked />' + '<?php echo $text_default; ?>';
    html += '</div>';
    <?php foreach ($stores as $store) { ?>
    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '<div class="<?php echo $class; ?>">';
    html += '<input type="checkbox" name="discounts[' + discount_row + '][stores][]" value="<?php echo $store['store_id']; ?>" />' + '<?php echo $store['name']; ?>';
    html += '</div>';
    <?php } ?>
    html += '</div>';
    html += '</select>';
    html += '</td>';
    html += '<td class="left" rowspan="2">';
    <?php foreach ($languages as $language) { ?>
    html += '<img src="view/image/flags/<?php echo $language['image'] ?>" title="<?php echo $language['name'] ?>" />&nbsp;<span class="bold"><?php echo $language['name'] ?>: </span><br/>';
    html += '<textarea type="text" cols="38" rows="4" name="discounts[' + discount_row + '][descriptions][<?php echo $language['language_id'] ?>]" ><?php echo $entry_discount_description_default?></textarea>';
    <?php } ?>
    html += '</td>';
	html += '<td class="center" rowspan="2"><a onclick="$(\'#discount_row' + discount_row + '\').remove();" class="button"><span><?php echo $button_remove_discount; ?></span></a></td>';
	html += '</tr>';
    html += '<tr>';
    html += '<td class="left">';
    html += '<div class="scrollbox">';
    <?php $class = 'odd'; ?>
    <?php foreach ($customer_groups as $customer_group) { ?>
    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '<div class="<?php echo $class; ?>">';
    html += '<input type="checkbox" name="discounts[' + discount_row + '][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" />' + '<?php echo $customer_group['name']; ?>';
    html += '</div>';
    <?php } ?>
    html += '</div>';
    html += '</td>';
    html += '</tr>';
    html += '</tbody>';

	$('#discount tfoot').before(html);

	discount_row++;
}

//--></script>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
<?php if ($language['status']) { ?>
CKEDITOR.replace('description_before<?php echo $language['language_id']; ?>');
CKEDITOR.replace('description_after<?php echo $language['language_id']; ?>');
<?php } ?>
<?php } ?>
//--></script>


<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>
<?php echo $footer; ?>
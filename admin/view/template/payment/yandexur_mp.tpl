<?php echo $header; ?>
<style type="text/css">
.col-sm-3, .col-sm-2{
  float: left;
  margin: 0px  20px ;
}
.row {
  width: 320px;
  clear: both;
}
.fa-plus:after {
  content: "Добавить";
}
.fa-trash-o:after {
  content: "Удалить";
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
        <table class="form">
        <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_license; ?></td>
        <td><input type="text" name="<?php echo $pname; ?>_license" value="<?php if (isset(${"{$pname}_license"})){ echo ${"{$pname}_license"}; }?>" />
          <br />
          <?php if ($error_license) { ?>
          <span class="error"><?php echo $error_license; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_shopId; ?></td>
        <td><input type="text" name="<?php echo $pname; ?>_shopId" value="<?php if (isset(${"{$pname}_shopId"})){ echo ${"{$pname}_shopId"}; }?>" />
          <br />
          <?php if ($error_shopId) { ?>
          <span class="error"><?php echo $error_shopId; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_scid; ?></td>
        <td><input type="text" name="<?php echo $pname; ?>_scid" value="<?php if (isset(${"{$pname}_scid"})){ echo ${"{$pname}_scid"}; }?>" />
          <br />
          <?php if ($error_scid) { ?>
          <span class="error"><?php echo $error_scid; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
        <td><span class="required">*</span> <?php echo $entry_password; ?></td>
        <td><input type="password" name="<?php echo $pname; ?>_password" value="<?php if (isset(${"{$pname}_password"})){ echo ${"{$pname}_password"}; }?>" />
          <br />
          <?php if ($error_password) { ?>
          <span class="error"><?php echo $error_password; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> paymentAvisoURL:</td>
          <td><?php echo $copy_result_url; ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> checkURL:</td>
          <td><?php echo $copy_checkURL; ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> SuccessUrl, FailUrl:</td>
          <td><?php echo $copy_fail_success_URL; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_returnpage; ?></td>
          <td><?php if ($yandexurpro_returnpage) { ?>
            <input type="radio" name="<?php echo $pname; ?>_returnpage" value="1" checked="checked" />
            <?php echo $entry_returnpage_default; ?>
            <input type="radio" name="<?php echo $pname; ?>_returnpage" value="0" />
            <?php echo $entry_returnpage_self; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_returnpage" value="1" />
            <?php echo $entry_returnpage_default; ?>
            <input type="radio" name="<?php echo $pname; ?>_returnpage" value="0" checked="checked" />
            <?php echo $entry_returnpage_self; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_name_tab; ?></td>
          <td><?php if (${"{$pname}_name_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_name_attach" value="1" checked="checked" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_name_attach" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_name_attach" value="1" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_name_attach" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_name; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_name_<?php echo $language['language_id']; ?>" cols="50" rows="1"><?php echo isset(${"{$pname}_name_{$language['language_id']}"}) ? ${"{$pname}_name_{$language['language_id']}"} : ''; ?></textarea><br />
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fixen ; ?></td>
          <td><?php if (${"{$pname}_fixen"} == 'proc') { ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="fix" />
            <?php echo $entry_fixen_fix; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="proc" checked="checked" />
            <?php echo $entry_fixen_proc; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="0" />
            <?php echo $entry_fixen_order; ?>
            <?php } else if(${"{$pname}_fixen"} == 'fix'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="fix" checked="checked" />
            <?php echo $entry_fixen_fix; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="proc" />
            <?php echo $entry_fixen_proc; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="0" />
            <?php echo $entry_fixen_order; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="fix" />
            <?php echo $entry_fixen_fix; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="proc" />
            <?php echo $entry_fixen_proc; ?>
            <input type="radio" name="<?php echo $pname; ?>_fixen" value="0" checked="checked" />
            <?php echo $entry_fixen_order; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fixen_amount; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_fixen_amount" value="<?php echo isset(${"{$pname}_fixen_amount"}) ? ${"{$pname}_fixen_amount"} : ''; ?>" ><br />
          <?php if ($error_fixen) { ?>
          <span class="error"><?php echo $error_fixen; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_komis; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_komis" value="<?php echo isset(${"{$pname}_komis"}) ? ${"{$pname}_komis"} : ''; ?>" >%</td>
        </tr>
        <tr>
          <td><?php echo $entry_minpay; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_minpay" value="<?php echo isset(${"{$pname}_minpay"}) ? ${"{$pname}_minpay"} : ''; ?>" >руб.</td>
        </tr>
        <tr>
          <td><?php echo $entry_maxpay; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_maxpay" value="<?php echo isset(${"{$pname}_maxpay"}) ? ${"{$pname}_maxpay"} : ''; ?>" >руб.</td>
        </tr>
        <tr>
          <td><?php echo $entry_success_alert_admin_tab; ?></td>
          <td><?php if (${"{$pname}_success_alert_admin"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_admin" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_admin" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_admin" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_admin" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_success_alert_customer_tab; ?></td>
          <td><?php if (${"{$pname}_success_alert_customer"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_customer" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_customer" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_customer" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_alert_customer" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_instruction_tab; ?></td>
          <td><?php if (${"{$pname}_instruction_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_instruction_attach" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_instruction_attach" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_instruction_attach" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_instruction_attach" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_instruction; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_instruction_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_instruction_{$language['language_id']}"}) ? ${"{$pname}_instruction_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_mail_instruction_tab; ?></td>
          <td><?php if (${"{$pname}_mail_instruction_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_mail_instruction_attach" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_mail_instruction_attach" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_mail_instruction_attach" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_mail_instruction_attach" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_mail_instruction; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_mail_instruction_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_mail_instruction_{$language['language_id']}"}) ? ${"{$pname}_mail_instruction_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_success_comment_tab; ?></td>
          <td><?php if (${"{$pname}_success_comment_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_comment_attach" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_comment_attach" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_comment_attach" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_comment_attach" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_success_comment; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_success_comment_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_success_comment_{$language['language_id']}"}) ? ${"{$pname}_success_comment_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
         <tr>
          <td><?php echo $entry_waiting_page_tab; ?></td>
          <td><?php if (${"{$pname}_waiting_page_text_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_waiting_page_text_attach" value="1" checked="checked" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_waiting_page_text_attach" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_waiting_page_text_attach" value="1" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_waiting_page_text_attach" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_waiting_page_text; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_waiting_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_waiting_page_text_{$language['language_id']}"}) ? ${"{$pname}_waiting_page_text_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
        <tr>
        <td><?php echo $entry_on_status_mp; ?></td>
        <td><select name="<?php echo $pname; ?>_on_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == ${"{$pname}_on_status_id"}) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="<?php echo $pname; ?>_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == ${"{$pname}_order_status_id"}) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td><?php echo $entry_geo_zone; ?></td>
        <td><select name="<?php echo $pname; ?>_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == ${"{$pname}_geo_zone_id"}) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="<?php echo $pname; ?>_status">
            <?php if (${"{$pname}_status"}) { ?>
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
          <td><input type="text" name="<?php echo $pname; ?>_sort_order" value="<?php echo ${"{$pname}_sort_order"}; ?>" size="1" /></td>
        </tr>
      </table>

        </div>
        <input type="hidden" name="<?php echo $pname; ?>_methodcode" value="<?php echo $methodcode; ?>" />
      </form>
    </div>
      <p style="text-align:center;">YandexUr <?php echo $version ?></p>
  </div>
</div>
<script>
  var class_row = <?php echo $class_row; ?>;

  var addClassRow = function() {
    html = '<label class="control-label class-row'+ class_row +'"></label>';
    html += '<div class="row class-row'+ class_row +'">';
    html += '<div class="col-sm-3">';
    html += '<select name="<?php echo $pname; ?>_classes['+ class_row +'][<?php echo $pname; ?>_nalog]" class="form-control">';
    html += '<?php foreach ($tax_classes as $tax_class) { ?>';
    html += '<option <?php echo $tax_class["tax_class_id"] == $class[$pname."_nalog"] ? "selected" : ""; ?> value="<?php echo $tax_class["tax_class_id"];?>"><?php echo $tax_class["title"];?></option>';
    html += '<?php } ?>';
    html += '</select>';
    html += '</div>';
    html += '<div class="col-sm-3">';
    html += '<select name="<?php echo $pname; ?>_classes['+ class_row +'][<?php echo $pname; ?>_tax_rule]" class="form-control">';
    html += '<?php foreach ($tax_rules as $tax) { ?>';
    html += '<option <?php echo $tax["id"] == $class[$pname."_tax_rule"] ? "selected" : ""; ?> value="<?php echo $tax["id"];?>"><?php echo $tax["name"];?></option>';
    html += '<?php } ?>';
    html += '</select>';
    html += '</div>';
    html += '<div class="col-sm-1">';
    html += '<button type="button" onclick="$(\'.class-row' + class_row + '\').remove();" class="btn btn-danger button_remove_rule_tax"><i class="fa fa-trash-o"></i></button>';
    html += '</div>';
    $('.rule_tax:last').after(html);

    class_row++;
  }

  $(document).ready(function() {
    $('#tovar_tab').click(function () {
      $('.hidetovar').show('fast');
      $('.hideimportant').hide('fast');
    });
    $('#important_tab').click(function () {
      $('.hidetovar').hide('fast');
      $('.hideimportant').show('fast');
    });
    $('#no_tab').click(function () {
      $('.hidetovar').hide('fast');
      $('.hideimportant').hide('fast');
    });
    $('#pay_tab').click(function () {
      $('#create').prop("checked", true);
      $('.hideotlog').hide('fast');
      $('.showotlog').show('fast');
    });
    $('#stock_tab').click(function () {
      $('#create').prop("checked", true);
      $('.hideotlog').hide('fast');
      $('.showotlog').show('fast');
    });
    $('#standard_tab').click(function () {
      $('.hideotlog').show('fast');
      $('.showotlog').hide('fast');
    });
  });
</script>
<?php echo $footer; ?> 
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
          <td width="25%"><?php echo $entry_protokol; ?></td>
          <td><?php if ($yandexurpro_protokol) { ?>
            <input type="radio" name="<?php echo $pname; ?>_protokol" id="http" value="1" checked="checked" />
            <?php echo $text_http; ?>
            <input type="radio" name="<?php echo $pname; ?>_protokol" id="api" value="0" />
            <?php echo $text_api; ?>
            <?php } else { ?>
            <?php if ($methodcode != 'BSB') { ?>
            <input type="radio" name="<?php echo $pname; ?>_protokol" id="http" value="1" />
            <?php echo $text_http; ?>
            <?php } ?>
            <input type="radio" name="<?php echo $pname; ?>_protokol" id="api" value="0" checked="checked" />
            <?php echo $text_api; ?>
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
        <tr class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td width="25%"><span class="required">*</span> <?php echo $entry_scid; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_scid" value="<?php if (isset(${"{$pname}_scid"})){ echo ${"{$pname}_scid"}; }?>" />
          <br />
          <?php if ($error_scid) { ?>
          <span class="error"><?php echo $error_scid; ?></span>
          <?php } ?></td>
        </tr>
        <tr class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td width="25%"><?php echo $entry_yadserver; ?></td>
          <td><?php if (${"{$pname}_yadserver"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_yadserver" value="1" checked="checked" />
            <?php echo $entry_yadserver_real; ?>
            <input type="radio" name="<?php echo $pname; ?>_yadserver" value="0" />
            <?php echo $entry_yadserver_demo; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_yadserver" value="1" />
            <?php echo $entry_yadserver_real; ?>
            <input type="radio" name="<?php echo $pname; ?>_yadserver" value="0" checked="checked" />
            <?php echo $entry_yadserver_demo; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?> ><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td class="protokol2" <?php if ($yandexurpro_protokol) {?>style="display:none;"<?php } ?> ><span class="required">*</span> <?php echo $entry_password2; ?></td>
          <td><input type="password" name="<?php echo $pname; ?>_password" value="<?php if (isset(${"{$pname}_password"})){ echo ${"{$pname}_password"}; }?>" />
          <br />
          <?php if ($error_password) { ?>
          <span class="error"><?php echo $error_password; ?></span>
          <?php } ?></td>
        </tr>
        <tr class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><span class="required">*</span> checkURL:</td>
          <td><?php echo $copy_checkURL; ?></td>
        </tr>
        <tr class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><span class="required">*</span> paymentAvisoURL:</td>
          <td><?php echo $copy_result_url; ?></td>
        </tr>
        <tr class="protokol" <?php if (!$yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><span class="required">*</span> SuccessUrl, FailUrl:</td>
          <td><?php echo $copy_fail_success_URL; ?></td>
        </tr>
        <?php if ($twostage_show === true) { ?>
        <tr class="protokol2" <?php if ($yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td width="25%"><?php echo $entry_twostage; ?></td>
          <td><?php if ($yandexurpro_twostage) { ?>
            <input type="radio" name="<?php echo $pname; ?>_twostage" value="1" checked="checked" />
            <?php echo $text_twostage; ?>
            <input type="radio" name="<?php echo $pname; ?>_twostage" value="0" />
            <?php echo $text_onestage; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_twostage" value="1" />
            <?php echo $text_twostage; ?>
            <input type="radio" name="<?php echo $pname; ?>_twostage" value="0" checked="checked" />
            <?php echo $text_onestage; ?>
            <?php } ?></td>
        </tr>
        <?php } ?>

        <tr class="protokol2" <?php if ($yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><?php echo $entry_capture ; ?></td>
          <td>
            <?php if($yandexurpro_capture == 'auto'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_capture" class="capture_on_tab" value="auto" checked="checked" />
            <?php echo $text_capture_auto; ?>
            <input type="radio" name="<?php echo $pname; ?>_capture" class="capture_off_tab" value="0" />
            <?php echo $text_capture_callback; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_capture" class="capture_on_tab" value="auto" />
            <?php echo $text_capture_auto; ?>
            <input type="radio" name="<?php echo $pname; ?>_capture" class="capture_off_tab" value="0" checked="checked" />
            <?php echo $text_capture_callback; ?>
            <?php } ?></td>
        </tr>
        <tr class="protokol2" <?php if ($yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><span class="required">*</span> <?php echo $entry_callback; ?></td>
          <td><?php echo $copy_result_url.'api'; ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_debug; ?></td>
          <td><?php if ($yandexurpro_debug) { ?>
            <input type="radio" name="<?php echo $pname; ?>_debug" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_debug" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_debug" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_debug" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
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
          <td><?php echo $entry_otlog ; ?></td>
          <td><?php if ($yandexurpro_otlog == 'pay') { ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="stock_tab" value="stock" />
            <?php echo $entry_otlog_stock; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="pay_tab" value="pay" checked="checked" />
            <?php echo $entry_otlog_pay; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="standard_tab" value="0" />
            <?php echo $entry_otlog_standard; ?>
            <?php } else if($yandexurpro_otlog == 'stock'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="stock_tab" value="stock" checked="checked" />
            <?php echo $entry_otlog_stock; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="pay_tab" value="pay" />
            <?php echo $entry_otlog_pay; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="standard_tab" value="0" />
            <?php echo $entry_otlog_standard; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="stock_tab" value="stock" />
            <?php echo $entry_otlog_stock; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="pay_tab" value="pay" />
            <?php echo $entry_otlog_pay; ?>
            <input type="radio" name="<?php echo $pname; ?>_otlog" id="standard_tab" value="0" checked="checked" />
            <?php echo $entry_otlog_standard; ?>
            <?php } ?></td>
        </tr>
        <?php if ($methodcode != 'BSB') { ?>
        <tr>
          <td><?php echo $entry_cart; ?></td>
          <td><?php if ($yandexurpro_cart) { ?>
            <input type="radio" name="<?php echo $pname; ?>_cart" value="1" checked="checked" />
            <?php echo $text_no; ?>
            <input type="radio" name="<?php echo $pname; ?>_cart" value="0" />
            <?php echo $text_yes; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_cart" value="1" />
            <?php echo $text_no; ?>
            <input type="radio" name="<?php echo $pname; ?>_cart" value="0" checked="checked" />
            <?php echo $text_yes; ?>
            <?php } ?></td>
        </tr>
        <tr class="protokol2" <?php if ($yandexurpro_protokol) {?>style="display:none;"<?php } ?>>
          <td><?php echo $entry_tax_system_code ; ?></td>
          <td>
            <?php if($yandexurpro_tax_system_code == '6'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" checked="checked" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else if($yandexurpro_tax_system_code == '5'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" checked="checked" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else if($yandexurpro_tax_system_code == '4'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" checked="checked" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else if($yandexurpro_tax_system_code == '3'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" checked="checked" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else if($yandexurpro_tax_system_code == '2'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" checked="checked" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else if($yandexurpro_tax_system_code == '1'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" checked="checked" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="6" />
            <?php echo $text_tax_system_code_6; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="5" />
            <?php echo $text_tax_system_code_5; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="4" />
            <?php echo $text_tax_system_code_4; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="3" />
            <?php echo $text_tax_system_code_3; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="2" />
            <?php echo $text_tax_system_code_2; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="1" />
            <?php echo $text_tax_system_code_1; ?><br/>
            <input type="radio" name="<?php echo $pname; ?>_tax_system_code" value="0" checked="checked" />
            <?php echo $text_tax_system_code_default; ?>
            <?php } ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td><?php echo $entry_nds ; ?></td>
          <td><?php if ($yandexurpro_nds == 'important') { ?>
            <?php if ($methodcode != 'BSB') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" />
            <?php echo $entry_nds_tovar; ?>
            <?php } ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" checked="checked" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" />
            <?php echo $entry_nds_no; ?>
            <?php } else if($yandexurpro_nds == 'tovar'){ ?>
            <?php if ($methodcode != 'BSB') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" checked="checked" />
            <?php echo $entry_nds_tovar; ?>
            <?php } ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" />
            <?php echo $entry_nds_no; ?>
            <?php } else { ?>
            <?php if ($methodcode != 'BSB') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" />
            <?php echo $entry_nds_tovar; ?>
            <?php } ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" checked="checked" />
            <?php echo $entry_nds_no; ?>
            <?php } ?></td>
        </tr>
        <tr class="hideimportant" <?php if ($yandexurpro_nds != 'important') {?>style="display:none;"<?php } ?>>
          <td><?php echo $entry_nds_important ; ?></td>
          <td><?php if ($yandexurpro_nds_important == '3') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="6" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" checked="checked" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($yandexurpro_nds_important == '4'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="6" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" checked="checked" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($yandexurpro_nds_important == '6'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="6" checked="checked" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($yandexurpro_nds_important == '5'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="6" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" checked="checked" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="6" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" checked="checked" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } ?></td>
        </tr>
        <tr class="hidetovar" <?php if ($yandexurpro_nds != 'tovar') {?>style="display:none;"<?php } ?>>

          <td><?php echo $entry_tax; ?></td>
          <td>
            
            <?php $class_row = 0; ?>
          <?php foreach ($yandexurpro_classes as $class) { ?>
          <?php if ($class_row > 0) { ?>
          <label class="control-label class-row<?php echo $class_row; ?>"></label>
          <?php } ?>
          <div class="row rule_tax class-row<?php echo $class_row; ?>">
            <div class="col-sm-3">
              <select name="<?php echo $pname; ?>_classes[<?php echo $class_row; ?>][<?php echo $pname; ?>_nalog]" class="form-control">
                <?php foreach ($tax_classes as $tax_class) { ?>
                <option <?php echo $tax_class['tax_class_id'] == $class[$pname.'_nalog'] ? 'selected' : ''; ?> value="<?php echo $tax_class['tax_class_id'];?>"><?php echo $tax_class['title'];?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-3">
              <select name="<?php echo $pname; ?>_classes[<?php echo $class_row; ?>][<?php echo $pname; ?>_tax_rule]" class="form-control">
                <?php foreach ($tax_rules as $tax) { ?>
                <option <?php echo $tax['id'] == $class[$pname.'_tax_rule'] ? 'selected' : ''; ?> value="<?php echo $tax['id'];?>"><?php echo $tax['name'];?></option>
                <?php } ?>
              </select>
            </div>
            <?php if ($class_row > 0) { ?>
            <div class="col-sm-1">
              <button type="button" onclick="$('.class-row<?php echo $class_row; ?>').remove();" class="btn btn-primary button_remove_rule_tax">Удалить</button>
            </div>
            <?php } ?>
            <?php $class_row++; ?>
          </div>
          <?php } ?>
          <label class="control-label"></label>
          <div class="row">
            <div class="col-sm-2">
              <button type="button" id="button_add_taxt_rule" onclick="addClassRow()" class="btn btn-primary"><i class="fa fa-plus"></i></button>
            </div>
          </div>

          </td>
        </tr>
        <?php if ($methodcode != 'BSB') { ?>
        <tr>
          <?php $pole = 'payment_mode_default'; ?>
          <td><?php echo ${"entry_{$pole}"}; ?></td>
          <td>
            <select name="<?php echo $pname; ?>_<?php echo $pole; ?>">
            <?php foreach ($manypoles[$pole] as $ar) { ?>
            <?php if (${"yandexurpro_{$pole}"} == $ar) { ?>
            <option value="<?php echo $ar; ?>" selected="selected"/><?php echo ${"text_{$pole}_{$ar}"}; ?></option>
            <?php } else { ?>
              <option value="<?php echo $ar; ?>" /><?php echo ${"text_{$pole}_{$ar}"}; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <?php $pole = 'payment_mode_source'; ?>
          <td><?php echo ${"entry_{$pole}"}; ?></td>
          <td>
            <select name="<?php echo $pname; ?>_<?php echo $pole; ?>">
            <?php foreach ($manypoles[$pole] as $ar) { ?>
            <?php if (${"yandexurpro_{$pole}"} == $ar) { ?>
            <option value="<?php echo $ar; ?>" selected="selected"/><?php echo ${"text_{$ar}"}; ?></option>
            <?php } else { ?>
              <option value="<?php echo $ar; ?>" /><?php echo ${"text_{$ar}"}; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <?php $pole = 'payment_subject_default'; ?>
          <td><?php echo ${"entry_{$pole}"}; ?></td>
          <td>
            <select name="<?php echo $pname; ?>_<?php echo $pole; ?>">
            <?php foreach ($manypoles[$pole] as $ar) { ?>
            <?php if (${"yandexurpro_{$pole}"} == $ar) { ?>
            <option value="<?php echo $ar; ?>" selected="selected"/><?php echo ${"text_{$pole}_{$ar}"}; ?></option>
            <?php } else { ?>
              <option value="<?php echo $ar; ?>" /><?php echo ${"text_{$pole}_{$ar}"}; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <?php $pole = 'payment_subject_source'; ?>
          <td><?php echo ${"entry_{$pole}"}; ?></td>
          <td>
            <select name="<?php echo $pname; ?>_<?php echo $pole; ?>">
            <?php foreach ($manypoles[$pole] as $ar) { ?>
            <?php if (${"yandexurpro_{$pole}"} == $ar) { ?>
            <option value="<?php echo $ar; ?>" selected="selected"/><?php echo ${"text_{$ar}"}; ?></option>
            <?php } else { ?>
              <option value="<?php echo $ar; ?>" /><?php echo ${"text_{$ar}"}; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_customName ; ?></td>
          <td><?php if ($yandexurpro_customName == 'upc') { ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" checked="checked" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" />
            <?php echo $text_default; ?>
            <?php } else if($yandexurpro_customName == 'ean'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" checked="checked" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" />
            <?php echo $text_default; ?>
            <?php } else if($yandexurpro_customName == 'mpn'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" checked="checked" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" />
            <?php echo $text_default; ?>
            <?php } else if($yandexurpro_customName == 'isbn'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" checked="checked" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" />
            <?php echo $text_default; ?>
            <?php } else if($yandexurpro_customName == 'jan'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" checked="checked" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="mpn" />
            <?php echo $text_MPN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="isbn" />
            <?php echo $text_ISBN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="jan" />
            <?php echo $text_JAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="ean" />
            <?php echo $text_EAN; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="upc" />
            <?php echo $text_UPC; ?>
            <input type="radio" name="<?php echo $pname; ?>_customName" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_shipinprod; ?></td>
          <td><?php if ($yandexurpro_shipinprod) { ?>
            <input type="radio" name="<?php echo $pname; ?>_shipinprod" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_shipinprod" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_shipinprod" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_shipinprod" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_customShip; ?></td>
          <td><input name="<?php echo $pname; ?>_customShip" value="<?php if (isset($yandexurpro_customShip)){ echo $yandexurpro_customShip; }?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_show_free_shipping; ?></td>
          <td><?php if ($yandexurpro_show_free_shipping) { ?>
            <input type="radio" name="<?php echo $pname; ?>_show_free_shipping" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_show_free_shipping" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_show_free_shipping" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_show_free_shipping" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <?php $pole = 'shipping_tax'; ?>
          <td><?php echo ${"entry_{$pole}"}; ?></td>
          <td>
            <select name="<?php echo $pname; ?>_<?php echo $pole; ?>">
            <?php foreach ($manypoles[$pole] as $ar) { ?>
            <?php if (${"yandexurpro_{$pole}"} == $ar) { ?>
            <option value="<?php echo $ar; ?>" selected="selected"/><?php echo ${"entry_nds_important_{$ar}"}; ?></option>
            <?php } else { ?>
              <option value="<?php echo $ar; ?>" /><?php echo ${"entry_nds_important_{$ar}"}; ?></option>
            <?php } ?>
            <?php } ?>
            </select>
          </td>
        </tr>
        <?php } ?>
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
          <td><?php echo $entry_style; ?></td>
          <td><?php if (${"{$pname}_style"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_style" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_style" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_style" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_style" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_button_later; ?></td>
          <td><?php if (${"{$pname}_button_later"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_button_later" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_button_later" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_button_later" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_button_later" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr class="hideotlog" <?php if ($yandexurpro_otlog == 'pay') {?>style="display:none;"<?php } ?>>
          <td><?php echo $text_createorder_or_notcreate; ?></td>
          <td><?php if (${"{$pname}_createorder_or_notcreate"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_createorder_or_notcreate" value="1" checked="checked" id="nocreate" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_createorder_or_notcreate" value="0" id="create" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_createorder_or_notcreate" value="1" id="nocreate" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_createorder_or_notcreate" value="0" checked="checked" id="create" />
            <?php echo $text_no; ?>
            <?php } ?></td>
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
          <td><?php echo $entry_hrefpage_tab; ?></td>
          <td><?php if (${"{$pname}_hrefpage_text_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_hrefpage_text_attach" value="1" checked="checked" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_hrefpage_text_attach" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_hrefpage_text_attach" value="1" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_hrefpage_text_attach" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_hrefpage; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_hrefpage_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_hrefpage_text_{$language['language_id']}"}) ? ${"{$pname}_hrefpage_text_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_success_page_tab; ?></td>
          <td><?php if (${"{$pname}_success_page_text_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_page_text_attach" value="1" checked="checked" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_page_text_attach" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_success_page_text_attach" value="1" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_success_page_text_attach" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_success_page_text; ?></td>
          <td><?php foreach ($languages as $language) { ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_success_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_success_page_text_{$language['language_id']}"}) ? ${"{$pname}_success_page_text_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
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
          <td><?php echo $entry_fail_page_tab; ?></td>
          <td><?php if (${"{$pname}_fail_page_text_attach"}) { ?>
            <input type="radio" name="<?php echo $pname; ?>_fail_page_text_attach" value="1" checked="checked" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_fail_page_text_attach" value="0" />
            <?php echo $text_default; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_fail_page_text_attach" value="1" />
            <?php echo $text_my; ?>
            <input type="radio" name="<?php echo $pname; ?>_fail_page_text_attach" value="0" checked="checked" />
            <?php echo $text_default; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fail_page_text; ?></td>
          <td><?php foreach ($languages as $language) { ?>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="<?php echo $pname; ?>_fail_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${"{$pname}_fail_page_text_{$language['language_id']}"}) ? ${"{$pname}_fail_page_text_{$language['language_id']}"} : ''; ?></textarea><br /><?php } ?></td>
        </tr>
        <tr class="showotlog" <?php if ($yandexurpro_otlog != 'stock' && $yandexurpro_otlog != 'pay') {?>style="display:none;"<?php } ?>>
        <td><?php echo $entry_start_status; ?></td>
        <td><select name="<?php echo $pname; ?>_start_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == ${"{$pname}_start_status_id"}) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        </tr>
        <tr>
        <td><?php echo $entry_on_status; ?></td>
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
    $('#api').click(function () {
      $('.protokol').hide('fast');
      $('.protokol2').show('fast');
      var capt = $('input[name=<?php echo $pname; ?>_capture]:checked').val();
      if (capt != 'all' & capt != 'auto') {
        $('.capture').hide('fast');
      }
    });
    $('#http').click(function () {
      $('.protokol').show('fast');
      $('.protokol2').hide('fast');
    });
    $('.capture_on_tab').click(function () {
      $('.capture').show('fast');
    });
    $('.capture_off_tab').click(function () {
      $('.capture').hide('fast');
    });
  });
</script>
<?php echo $footer; ?> 
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
      <div class="buttons"><a href="<?php echo $checks; ?>" class="button"><?php echo $text_checks; ?></a>
        <a href="<?php echo $logs; ?>" class="button"><?php echo $text_logs; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
      	<tr>
          <td width="20%" class="required"><?php echo $entry_license; ?></td>
          <td><input type="text" name="<?php echo $pname; ?>_license" value="<?php if (isset(${"{$pname}_license"})){ echo ${"{$pname}_license"}; }?>" />
          <br />
          <?php if ($error_license) { ?>
          <span class="error"><?php echo $error_license; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td class="required"><?php echo $entry_user; ?></td>
          <td><input id="tok" name="<?php echo $pname; ?>_user" value="<?php if (isset($evotorpro_user)){ echo $evotorpro_user; }?>" />
          <br />
          <?php if ($error_user) { ?>
          <span class="error"><?php echo $error_user; ?></span>
          <?php } ?></td>
        </tr>
        <tr>
          <td class="required"><?php echo $entry_storeUiid; ?></td>
          <td>
            <select id="su" name="<?php echo $pname; ?>_storeUiid">
            <?php if ($evotorpro_storeUiid) {  ?>
              <option value="<?php echo $evotorpro_storeUiid; ?>" selected="selected"><?php echo $evotorpro_storeUiid; ?></option>
            <?php } else { ?>
              <option value="0"><?php echo $text_vibor; ?></option>
            <?php } ?>
            </select> 
              <input type="button" value="<?php echo $text_token; ?>" id="getuiid" class="button btn btn-default" />
          <br />
          <?php if ($error_storeUiid) { ?>
          <span class="error"><?php echo $error_storeUiid; ?></span>
          <?php } ?></td>
        </tr>
        <?php /* ?>
        <tr>
          <td><?php echo $entry_Timeout; ?></td>
          <td><input name="<?php echo $pname; ?>_Timeout" value="<?php if (isset($evotorpro_Timeout)){ echo $evotorpro_Timeout; }?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_firm_name; ?></td>
          <td><input name="<?php echo $pname; ?>_firm_name" value="<?php if (isset($evotorpro_firm_name)){ echo $evotorpro_firm_name; }?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_InnKkm; ?></td>
          <td><input name="<?php echo $pname; ?>_InnKkm" value="<?php if (isset($evotorpro_InnKkm)){ echo $evotorpro_InnKkm; }?>" /></td>
        </tr>
        <?php */ ?>
        <tr>
          <td><?php echo $entry_logs; ?></td>
          <td><?php if ($evotorpro_logs) { ?>
            <input type="radio" name="<?php echo $pname; ?>_logs" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_logs" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_logs" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_logs" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_tax_system_code ; ?></td>
          <td>
            <?php if($evotorpro_tax_system_code == '6'){ ?>
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
            <?php } else if($evotorpro_tax_system_code == '5'){ ?>
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
            <?php } else if($evotorpro_tax_system_code == '4'){ ?>
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
            <?php } else if($evotorpro_tax_system_code == '3'){ ?>
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
            <?php } else if($evotorpro_tax_system_code == '2'){ ?>
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
            <?php } else if($evotorpro_tax_system_code == '1'){ ?>
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
        <tr>
          <td><?php echo $entry_nds ; ?></td>
          <td><?php if ($evotorpro_nds == 'important') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" />
            <?php echo $entry_nds_tovar; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" checked="checked" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" />
            <?php echo $entry_nds_no; ?>
            <?php } else if($evotorpro_nds == 'tovar'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" checked="checked" />
            <?php echo $entry_nds_tovar; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" />
            <?php echo $entry_nds_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" />
            <?php echo $entry_nds_tovar; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" />
            <?php echo $entry_nds_important; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" checked="checked" />
            <?php echo $entry_nds_no; ?>
            <?php } ?></td>
        </tr>
        <tr class="hideimportant" <?php if ($evotorpro_nds != 'important') {?>style="display:none;"<?php } ?>>
          <td><?php echo $entry_nds_important ; ?></td>
          <td><?php if ($evotorpro_nds_important == '10') { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="118" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="110" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="10" checked="checked" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="0" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($evotorpro_nds_important == '18'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="118" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="110" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" checked="checked" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="10" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="0" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($evotorpro_nds_important == '118'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="118" checked="checked" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="110" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="10" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="0" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else if($evotorpro_nds_important == '110'){ ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="118" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="110" checked="checked" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="10" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="0" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="118" />
            <?php echo $entry_nds_important_118; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="110" />
            <?php echo $entry_nds_important_110; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="18" />
            <?php echo $entry_nds_important_18; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="10" />
            <?php echo $entry_nds_important_10; ?>
            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="0" checked="checked" />
            <?php echo $entry_nds_important_nol; ?>
            <?php } ?></td>
        </tr>
        <tr class="hidetovar" <?php if ($evotorpro_nds != 'tovar') {?>style="display:none;"<?php } ?>>

          <td><?php echo $entry_tax; ?></td>
          <td>
            
            <?php $class_row = 0; ?>
          <?php foreach ($evotorpro_classes as $class) { ?>
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
        <tr>
                  <td><?php echo $entry_payments; ?></td>
                  <td>
                    <?php $i = 0; foreach ($payment_on as $payment_code => $payment_name) { $i++; ?>
                      <input name="<?php echo $pname; ?>_payments[]" value="<?php echo $payment_code ?>" <?php if (isset($evotorpro_payments)){ foreach($evotorpro_payments as $payment){ if ($payment == $payment_code){ echo 'checked';  }}} ?> type="checkbox" > <label for="<?php echo $pname; ?>_payments_<?php echo $i; ?>"><?php echo $payment_name; ?></label><br/><?php } ?>
                   </td>
                </tr>
                <tr>
                  <td><?php echo $entry_order_status_id_confirm; ?></td>
                  <td>
                    <?php $i = 0; foreach ($order_statuses as $order_statuse) { $i++; ?>
                    <input name="<?php echo $pname; ?>_order_status_id_confirm[]"  value="<?php echo $order_statuse['order_status_id'] ?>" <?php if (isset($evotorpro_order_status_id_confirm)){ foreach($evotorpro_order_status_id_confirm as $statuse){ if ($statuse == $order_statuse['order_status_id']){ echo 'checked';  }}} ?> type="checkbox" > <label for="<?php echo $pname; ?>_order_status_id_confirm_<?php echo $i; ?>"><?php echo $order_statuse['name']; ?></label><br/><?php } ?>
                  </td>
                </tr>
        <tr>
        <tr>
                  <td><?php echo $entry_payments_nal; ?></td>
                  <td>
                    <?php $i = 0; foreach ($payment_on as $payment_code => $payment_name) { $i++; ?>
                      <input name="<?php echo $pname; ?>_payments_nal[]" value="<?php echo $payment_code ?>" <?php if (isset($evotorpro_payments_nal)){ foreach($evotorpro_payments_nal as $payment_nal){ if ($payment_nal == $payment_code){ echo 'checked';  }}} ?> type="checkbox" > <label for="<?php echo $pname; ?>_payments_nal_<?php echo $i; ?>"><?php echo $payment_name; ?></label><br/><?php } ?>
                   </td>
                </tr>
                <tr>
                  <td><?php echo $entry_order_status_id_nal_confirm; ?></td>
                  <td>
                    <?php $i = 0; foreach ($order_statuses as $order_statuse_nal) { $i++; ?>
                    <input name="<?php echo $pname; ?>_order_status_id_nal_confirm[]"  value="<?php echo $order_statuse_nal['order_status_id'] ?>" <?php if (isset($evotorpro_order_status_id_nal_confirm)){ foreach($evotorpro_order_status_id_nal_confirm as $statuse_nal){ if ($statuse_nal == $order_statuse_nal['order_status_id']){ echo 'checked';  }}} ?> type="checkbox" > <label for="<?php echo $pname; ?>_order_status_id_nal_confirm_<?php echo $i; ?>"><?php echo $order_statuse_nal['name']; ?></label><br/><?php } ?>
                  </td>
                </tr>
        <tr>
          <td><?php echo $entry_errorEmail; ?></td>
          <td><input name="<?php echo $pname; ?>_errorEmail" value="<?php if (isset($evotorpro_errorEmail)){ echo $evotorpro_errorEmail; }?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_customName ; ?></td>
          <td><?php if ($evotorpro_customName == 'upc') { ?>
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
            <?php } else if($evotorpro_customName == 'ean'){ ?>
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
            <?php } else if($evotorpro_customName == 'mpn'){ ?>
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
            <?php } else if($evotorpro_customName == 'isbn'){ ?>
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
            <?php } else if($evotorpro_customName == 'jan'){ ?>
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
          <td><?php echo $entry_customShip; ?></td>
          <td><input name="<?php echo $pname; ?>_customShip" value="<?php if (isset($evotorpro_customShip)){ echo $evotorpro_customShip; }?>" /></td>
        </tr>
        <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="<?php echo $pname; ?>_status">
            <?php if ($evotorpro_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
        </tr>
      </table>
        </div>
      </form>
    </div>
      <p style="text-align:center;"><?php echo $pname . ' IMCHECK ' . $version; ?></p>
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
  });


  $('#getuiid').on('click', function() {
    $.ajax({
    url: '<?php echo $storeuuid; ?>&tok=' + $("#tok").val(),
    dataType: 'json',
    beforeSend: function() {
      $('#getuiid').button('loading');
    },
    complete: function() {
      $('#getuiid').button('reset');
    },
    success: function(json) {
      if (json['suiid']) {
        $('#su').empty();
        $.each(json['suiid'], function(){
            $("#su").append( $('<option value=' + this.uuid + '>' + this.name + '</option>'));
        })
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
</script>
<?php echo $footer; ?> 
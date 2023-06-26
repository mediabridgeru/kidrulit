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
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <div class="content">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <table class="form">
                        <tr>
                            <td width="25%"><span class="required">*</span> <?php echo $entry_license; ?></td>
                            <td><input type="text" name="sbacquiring2_license" value="<?php if (isset($sbacquiring2_license)){ echo $sbacquiring2_license; }?>" />
                                <br />
                                <?php if ($error_license) { ?>
                                <span class="error"><?php echo $error_license; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td width="25%"><span class="required">*</span> <?php echo $entry_userName; ?></td>
                            <td><input type="text" name="sbacquiring2_userName" value="<?php if (isset($sbacquiring2_userName)){ echo $sbacquiring2_userName; }?>" />
                                <br />
                                <?php if ($error_userName) { ?>
                                <span class="error"><?php echo $error_userName; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
                            <td><input type="password" name="sbacquiring2_password" value="<?php if (isset($sbacquiring2_userName)){ echo $sbacquiring2_password; }?>" />
                                <br />
                                <?php if ($error_password) { ?>
                                <span class="error"><?php echo $error_password; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_met; ?></td>
                            <td><?php if ($sbacquiring2_met) { ?>
                                <input type="radio" name="sbacquiring2_met" value="1" checked="checked" />
                                <?php echo $entry_met_preautoriz; ?>
                                <input type="radio" name="sbacquiring2_met" value="0" />
                                <?php echo $entry_met_odnostage; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_met" value="1" />
                                <?php echo $entry_met_preautoriz; ?>
                                <input type="radio" name="sbacquiring2_met" value="0" checked="checked" />
                                <?php echo $entry_met_odnostage; ?>
                                <?php } ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $entry_servadr ; ?></td>
                            <td><?php if ($sbacquiring2_servadr == 'real') { ?>
                                <input type="radio" name="sbacquiring2_servadr" value="self" />
                                <?php echo $entry_servadr_self; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="real" checked="checked" />
                                <?php echo $entry_servadr_real; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="0" />
                                <?php echo $entry_servadr_test; ?>
                                <?php } else if($sbacquiring2_servadr == 'self'){ ?>
                                <input type="radio" name="sbacquiring2_servadr" value="self" checked="checked" />
                                <?php echo $entry_servadr_self; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="real" />
                                <?php echo $entry_servadr_real; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="0" />
                                <?php echo $entry_servadr_test; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_servadr" value="self" />
                                <?php echo $entry_servadr_self; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="real" />
                                <?php echo $entry_servadr_real; ?>
                                <input type="radio" name="sbacquiring2_servadr" value="0" checked="checked" />
                                <?php echo $entry_servadr_test; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_self; ?></td>
                            <td><input type="text" name="sbacquiring2_servadr_self" value="<?php echo isset($sbacquiring2_servadr_self) ? $sbacquiring2_servadr_self : ''; ?>" ><br />
                                <?php if ($error_self) { ?>
                                <span class="error"><?php echo $error_self; ?></span>
                                <?php } ?></td>
                        </tr>
		        <tr>
          <td><?php echo $entry_checkcert; ?></td>
          <td><?php if ($sbacquiringpro_checkcert) { ?>
            <input type="radio" name="<?php echo $pname; ?>_checkcert" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_checkcert" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="<?php echo $pname; ?>_checkcert" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="<?php echo $pname; ?>_checkcert" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
                        <tr>
                            <td><?php echo $entry_zapros; ?></td>
                            <td><?php if ($sbacquiring2_zapros) { ?>
                                <input type="radio" name="sbacquiring2_zapros" value="1" checked="checked" />
                                <?php echo $entry_fgc; ?>
                                <input type="radio" name="sbacquiring2_zapros" value="0" />
                                <?php echo $entry_curl; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_zapros" value="1" />
                                <?php echo $entry_fgc; ?>
                                <input type="radio" name="sbacquiring2_zapros" value="0" checked="checked" />
                                <?php echo $entry_curl; ?>
                                <?php } ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $entry_currency; ?></td>
                            <td><?php if ($sbacquiring2_bankcurrency) { ?>
                                <input type="radio" name="sbacquiring2_bankcurrency" value="1" checked="checked" />
                                <?php echo $entry_currency_self; ?>
                                <input type="radio" name="sbacquiring2_bankcurrency" value="0" />
                                <?php echo $entry_currency_rub; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_bankcurrency" value="1" />
                                <?php echo $entry_currency_self; ?>
                                <input type="radio" name="sbacquiring2_bankcurrency" value="0" checked="checked" />
                                <?php echo $entry_currency_rub; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_currency_self_text; ?></td>
                            <td><input type="text" name="sbacquiring2_bankcurrency_self" value="<?php echo isset($sbacquiring2_bankcurrency_self) ? $sbacquiring2_bankcurrency_self : ''; ?>" ><br />
                                <?php if ($error_currency_self) { ?>
                                <span class="error"><?php echo $error_currency_self; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_currency_convert; ?></td>
                            <td><select name="sbacquiring2_currency">
                                    <?php foreach ($currencies as $currency) { ?>
                                    <?php if ($currency['code'] == $sbacquiring2_currency) { ?>
                                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_callbackemulate; ?></td>
                            <td><?php if ($sbacquiring2_callbackemulate) { ?>
                                <input type="radio" name="sbacquiring2_callbackemulate" value="1" checked="checked" />
                                <?php echo $entry_callbackemulate_no; ?>
                                <input type="radio" name="sbacquiring2_callbackemulate" value="0" />
                                <?php echo $entry_callbackemulate_yes; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_callbackemulate" value="1" />
                                <?php echo $entry_callbackemulate_no; ?>
                                <input type="radio" name="sbacquiring2_callbackemulate" value="0" checked="checked" />
                                <?php echo $entry_callbackemulate_yes; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><span class="required">*</span> callback:</td>
                            <td><?php echo $copy_result_url; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_debug; ?></td>
                            <td><?php if ($sbacquiringpro_debug) { ?>
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
                            <td><?php if ($sbacquiringpro_returnpage) { ?>
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
                            <td><?php if ($sbacquiringpro_otlog == 'pay') { ?>
                                <input type="radio" name="<?php echo $pname; ?>_otlog" id="stock_tab" value="stock" />
                                <?php echo $entry_otlog_stock; ?>
                                <input type="radio" name="<?php echo $pname; ?>_otlog" id="pay_tab" value="pay" checked="checked" />
                                <?php echo $entry_otlog_pay; ?>
                                <input type="radio" name="<?php echo $pname; ?>_otlog" id="standard_tab" value="0" />
                                <?php echo $entry_otlog_standard; ?>
                                <?php } else if($sbacquiringpro_otlog == 'stock'){ ?>
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
                        <tr>
                            <td><?php echo $entry_cart; ?></td>
                            <td><?php if ($sbacquiringpro_cart) { ?>
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
                        <tr>
                            <td><?php echo $entry_nds ; ?></td>
                            <td><?php if ($sbacquiringpro_nds == 'important') { ?>
                                <input type="radio" name="<?php echo $pname; ?>_nds" id="tovar_tab" value="tovar" />
                                <?php echo $entry_nds_tovar; ?>
                                <input type="radio" name="<?php echo $pname; ?>_nds" id="important_tab" value="important" checked="checked" />
                                <?php echo $entry_nds_important; ?>
                                <input type="radio" name="<?php echo $pname; ?>_nds" id="no_tab" value="0" />
                                <?php echo $entry_nds_no; ?>
                                <?php } else if($sbacquiringpro_nds == 'tovar'){ ?>
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
                        <tr class="hideimportant" <?php if ($sbacquiringpro_nds != 'important') {?>style="display:none;"<?php } ?>>
                        <td><?php echo $entry_nds_important ; ?></td>
                        <td><?php if ($sbacquiringpro_nds_important == '2') { ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
                            <?php echo $entry_nds_important_118; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
                            <?php echo $entry_nds_important_110; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
                            <?php echo $entry_nds_important_18; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" checked="checked" />
                            <?php echo $entry_nds_important_10; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="1" />
                            <?php echo $entry_nds_important_nol; ?>
                            <?php } else if($sbacquiringpro_nds_important == '3'){ ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
                            <?php echo $entry_nds_important_118; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
                            <?php echo $entry_nds_important_110; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" checked="checked" />
                            <?php echo $entry_nds_important_18; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
                            <?php echo $entry_nds_important_10; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="1" />
                            <?php echo $entry_nds_important_nol; ?>
                            <?php } else if($sbacquiringpro_nds_important == '5'){ ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" checked="checked" />
                            <?php echo $entry_nds_important_118; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
                            <?php echo $entry_nds_important_110; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
                            <?php echo $entry_nds_important_18; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
                            <?php echo $entry_nds_important_10; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="1" />
                            <?php echo $entry_nds_important_nol; ?>
                            <?php } else if($sbacquiringpro_nds_important == '4'){ ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
                            <?php echo $entry_nds_important_118; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" checked="checked" />
                            <?php echo $entry_nds_important_110; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
                            <?php echo $entry_nds_important_18; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
                            <?php echo $entry_nds_important_10; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="1" />
                            <?php echo $entry_nds_important_nol; ?>
                            <?php } else { ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="5" />
                            <?php echo $entry_nds_important_118; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="4" />
                            <?php echo $entry_nds_important_110; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="3" />
                            <?php echo $entry_nds_important_18; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="2" />
                            <?php echo $entry_nds_important_10; ?>
                            <input type="radio" name="<?php echo $pname; ?>_nds_important" value="1" checked="checked" />
                            <?php echo $entry_nds_important_nol; ?>
                            <?php } ?></td>
                        </tr>
                        <tr class="hidetovar" <?php if ($sbacquiringpro_nds != 'tovar') {?>style="display:none;"<?php } ?>>

                        <td><?php echo $entry_tax; ?></td>
                        <td>

                            <?php $class_row = 0; ?>
                            <?php foreach ($sbacquiringpro_classes as $class) { ?>
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
                            <td><?php echo $entry_customName ; ?></td>
                            <td><?php if ($sbacquiringpro_customName == 'upc') { ?>
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
                                <?php } else if($sbacquiringpro_customName == 'ean'){ ?>
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
                                <?php } else if($sbacquiringpro_customName == 'mpn'){ ?>
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
                                <?php } else if($sbacquiringpro_customName == 'isbn'){ ?>
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
                                <?php } else if($sbacquiringpro_customName == 'jan'){ ?>
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
                            <td><input name="<?php echo $pname; ?>_customShip" value="<?php if (isset($sbacquiringpro_customShip)){ echo $sbacquiringpro_customShip; }?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_name_tab; ?></td>
                            <td><?php if ($sbacquiring2_name_attach) { ?>
                                <input type="radio" name="sbacquiring2_name_attach" value="1" checked="checked" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_name_attach" value="0" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_name_attach" value="1" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_name_attach" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_name; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_name_<?php echo $language['language_id']; ?>" cols="50" rows="1"><?php echo isset(${'sbacquiring2_name_' . $language['language_id']}) ? ${'sbacquiring2_name_' . $language['language_id']} : ''; ?></textarea><br />
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_fixen ; ?></td>
                            <td><?php if ($sbacquiring2_fixen == 'proc') { ?>
                                <input type="radio" name="sbacquiring2_fixen" value="fix" />
                                <?php echo $entry_fixen_fix; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="proc" checked="checked" />
                                <?php echo $entry_fixen_proc; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="0" />
                                <?php echo $entry_fixen_order; ?>
                                <?php } else if($sbacquiring2_fixen == 'fix'){ ?>
                                <input type="radio" name="sbacquiring2_fixen" value="fix" checked="checked" />
                                <?php echo $entry_fixen_fix; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="proc" />
                                <?php echo $entry_fixen_proc; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="0" />
                                <?php echo $entry_fixen_order; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_fixen" value="fix" />
                                <?php echo $entry_fixen_fix; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="proc" />
                                <?php echo $entry_fixen_proc; ?>
                                <input type="radio" name="sbacquiring2_fixen" value="0" checked="checked" />
                                <?php echo $entry_fixen_order; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_fixen_amount; ?></td>
                            <td><input type="text" name="sbacquiring2_fixen_amount" value="<?php echo isset($sbacquiring2_fixen_amount) ? $sbacquiring2_fixen_amount : ''; ?>" ><br />
                                <?php if ($error_fixen) { ?>
                                <span class="error"><?php echo $error_fixen; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_komis; ?></td>
                            <td><input type="text" name="sbacquiring2_komis" value="<?php echo isset($sbacquiring2_komis) ? $sbacquiring2_komis : ''; ?>" >%</td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_minpay; ?></td>
                            <td><input type="text" name="sbacquiring2_minpay" value="<?php echo isset($sbacquiring2_minpay) ? $sbacquiring2_minpay : ''; ?>" ></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_maxpay; ?></td>
                            <td><input type="text" name="sbacquiring2_maxpay" value="<?php echo isset($sbacquiring2_maxpay) ? $sbacquiring2_maxpay : ''; ?>" ></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_style; ?></td>
                            <td><?php if ($sbacquiring2_style) { ?>
                                <input type="radio" name="sbacquiring2_style" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_style" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_style" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_style" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_button_later; ?></td>
                            <td><?php if ($sbacquiring2_button_later) { ?>
                                <input type="radio" name="sbacquiring2_button_later" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_button_later" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_button_later" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_button_later" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $text_createorder_or_notcreate; ?></td>
                            <td><?php if ($sbacquiring2_createorder_or_notcreate) { ?>
                                <input type="radio" name="sbacquiring2_createorder_or_notcreate" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_createorder_or_notcreate" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_createorder_or_notcreate" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_createorder_or_notcreate" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_alert_admin_tab; ?></td>
                            <td><?php if ($sbacquiring2_success_alert_admin) { ?>
                                <input type="radio" name="sbacquiring2_success_alert_admin" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_alert_admin" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_success_alert_admin" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_alert_admin" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_alert_customer_tab; ?></td>
                            <td><?php if ($sbacquiring2_success_alert_customer) { ?>
                                <input type="radio" name="sbacquiring2_success_alert_customer" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_alert_customer" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_success_alert_customer" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_alert_customer" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_instruction_tab; ?></td>
                            <td><?php if ($sbacquiring2_instruction_attach) { ?>
                                <input type="radio" name="sbacquiring2_instruction_attach" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_instruction_attach" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_instruction_attach" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_instruction_attach" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_instruction; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_instruction_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_instruction_' . $language['language_id']}) ? ${'sbacquiring2_instruction_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_mail_instruction_tab; ?></td>
                            <td><?php if ($sbacquiring2_mail_instruction_attach) { ?>
                                <input type="radio" name="sbacquiring2_mail_instruction_attach" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_mail_instruction_attach" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_mail_instruction_attach" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_mail_instruction_attach" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_mail_instruction; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_mail_instruction_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_mail_instruction_' . $language['language_id']}) ? ${'sbacquiring2_mail_instruction_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_comment_tab; ?></td>
                            <td><?php if ($sbacquiring2_success_comment_attach) { ?>
                                <input type="radio" name="sbacquiring2_success_comment_attach" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_comment_attach" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_success_comment_attach" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="sbacquiring2_success_comment_attach" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_comment; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_success_comment_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_success_comment_' . $language['language_id']}) ? ${'sbacquiring2_success_comment_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_hrefpage_tab; ?></td>
                            <td><?php if ($sbacquiring2_hrefpage_text_attach) { ?>
                                <input type="radio" name="sbacquiring2_hrefpage_text_attach" value="1" checked="checked" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_hrefpage_text_attach" value="0" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_hrefpage_text_attach" value="1" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_hrefpage_text_attach" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_hrefpage; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_hrefpage_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_hrefpage_text_' . $language['language_id']}) ? ${'sbacquiring2_hrefpage_text_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_page_tab; ?></td>
                            <td><?php if ($sbacquiring2_success_page_text_attach) { ?>
                                <input type="radio" name="sbacquiring2_success_page_text_attach" value="1" checked="checked" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_success_page_text_attach" value="0" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_success_page_text_attach" value="1" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_success_page_text_attach" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_success_page_text; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_success_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_success_page_text_' . $language['language_id']}) ? ${'sbacquiring2_success_page_text_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <?php /* ?><tr>
                            <td><?php echo $entry_sbacquiring_waiting_page_tab; ?></td>
                            <td><?php if ($sbacquiring2_waiting_page_text_attach) { ?>
                                <input type="radio" name="sbacquiring2_waiting_page_text_attach" value="1" checked="checked" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_waiting_page_text_attach" value="0" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_waiting_page_text_attach" value="1" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_waiting_page_text_attach" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sbacquiring_waiting_page_text; ?></td>
                            <td><?php foreach ($languages as $language) { ?><img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_waiting_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_waiting_page_text_' . $language['language_id']}) ? ${'sbacquiring2_waiting_page_text_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <?php */ ?>
                        <tr>
                            <td><?php echo $entry_fail_page_tab; ?></td>
                            <td><?php if ($sbacquiring2_fail_page_text_attach) { ?>
                                <input type="radio" name="sbacquiring2_fail_page_text_attach" value="1" checked="checked" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_fail_page_text_attach" value="0" />
                                <?php echo $text_default; ?>
                                <?php } else { ?>
                                <input type="radio" name="sbacquiring2_fail_page_text_attach" value="1" />
                                <?php echo $text_my; ?>
                                <input type="radio" name="sbacquiring2_fail_page_text_attach" value="0" checked="checked" />
                                <?php echo $text_default; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_fail_page_text; ?></td>
                            <td><?php foreach ($languages as $language) { ?>
                                <img src="<?php echo $language['imgsrc']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align:top;"/> <textarea name="sbacquiring2_fail_page_text_<?php echo $language['language_id']; ?>" cols="50" rows="3"><?php echo isset(${'sbacquiring2_fail_page_text_' . $language['language_id']}) ? ${'sbacquiring2_fail_page_text_' . $language['language_id']} : ''; ?></textarea><br /><?php } ?></td>
                        </tr>
                        <tr class="showotlog" <?php if ($sbacquiringpro_otlog != 'stock' && $sbacquiringpro_otlog != 'pay') {?>style="display:none;"<?php } ?>>
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
                            <td><select name="sbacquiring2_geo_zone_id">
                                    <option value="0"><?php echo $text_all_zones; ?></option>
                                    <?php foreach ($geo_zones as $geo_zone) { ?>
                                    <?php if ($geo_zone['geo_zone_id'] == $sbacquiring2_geo_zone_id) { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td><select name="sbacquiring2_status">
                                    <?php if ($sbacquiring2_status) { ?>
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
                            <td><input type="text" name="sbacquiring2_sort_order" value="<?php echo $sbacquiring2_sort_order; ?>" size="1" /></td>
                        </tr>
                    </table>

            </div>
            <input type="hidden" name="sbacquiring2_methodcode" value="SBA" />
            </form>
        </div>
        <p style="text-align:center;">sbacquiring <?php echo $version ?></p>
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
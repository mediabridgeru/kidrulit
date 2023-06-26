<?php

/**
 * @var YooMoneyPaymentKassa $kassa
 * @var Language $lang
 */

use YooKassa\Model\PaymentMethodType;

?>
<div role="tabpanel" class="tab-pane<?php echo ($lastActiveTab == 'tab-kassa' ? ' active' : ''); ?>" id="kassa">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-sm-9 col-sm-offset-3" style="padding-top: 15px;">
                    <p><?php echo $lang->get('kassa_header_description'); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-9 col-sm-offset-3" style="padding-left: 35px;">
                    <label class="checkbox control-label" for="yoomoney_kassa_enable">
                        <input type="checkbox" name="yoomoney_kassa_enable"
                               class="cls_yoomoney_kassamode yoomoney_mode qa-enable-yookassa-checkbox"
                               id="yoomoney_kassa_enable"
                               value="1" <?php echo ($kassa->isEnabled() ? 'checked' : ''); ?> />
                        <?php echo $lang->get('kassa_enable'); ?>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <?php include dirname(__FILE__) . '/parts/auth.tpl'; ?>

    <!-- Payment method -->
    <div class="row">
        <h4 class="form-heading"><?php echo $lang->get('kassa_payment_config_header'); ?></h4>
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $lang->get('kassa_payment_mode_label'); ?></label>
                    <div class="col-sm-9">
                        <label for="yoomoney_kassa_payment_mode_kassa" class="control-label radio-inline">
                            <input type="radio" name="yoomoney_kassa_payment_mode" id="yoomoney_kassa_payment_mode_kassa"
                                class="cls_yoomoney_paymode qa-yookassa-mode" value="kassa"
                                <?php echo ($kassa->getEPL() ? 'checked' : ''); ?> />
                            <?php echo $lang->get('kassa_payment_mode_smart_pay'); ?>
                        </label>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3 selectPayKassa">
                        <div class="checkbox">
                            <label for="yoomoney_kassa_add_installments_button" class="radio-inline control-label">
                                <input type="checkbox" name="yoomoney_kassa_add_installments_button"
                                       id="yoomoney_kassa_add_installments_button"
                                       value="1"<?php echo ($kassa->isAddInstallmentsButton() ? ' checked="checked"' : ''); ?> />
                                <?php echo $lang->get('kassa_add_installments_button'); ?>
                            </label>
                        </div>
                        <div class="checkbox" style="padding: 0 0 0 20px;">
                            <label class="radio-inline control-label">
                                <input type="checkbox" name="yoomoney_kassa_add_installments_block"
                                       value="1"<?php echo $kassa->getAddInstallmentsBlock() ? ' checked="checked"' : ''; ?> />
                                <?php echo $lang->get('kassa_add_installments_block_label'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3">
                        <label for="yoomoney_kassa_payment_mode_shop" class="radio-inline control-label">
                            <input type="radio" name="yoomoney_kassa_payment_mode" id="yoomoney_kassa_payment_mode_shop"
                                class="cls_yoomoney_paymode qa-shop-mode" value="shop"
                                <?php echo ($kassa->getEPL() ? '' : 'checked'); ?> />
                            <?php echo $lang->get('kassa_payment_mode_shop_pay'); ?>
                        </label>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3 selectPayOpt">
                        <p style="margin: 15px 0 0;"><?php echo $lang->get('kassa_payment_method_label'); ?></p>
                        <div style="display:none" id="kassa-payment-method-warning" class="alert alert-warning"></div>
                        <?php foreach ($kassa->getPaymentMethods() as $val => $name) : ?>
                            <?php if ($kassa->isTestMode() && !in_array($val, array(PaymentMethodType::YOO_MONEY, PaymentMethodType::BANK_CARD))) continue; ?>
                            <div class="checkbox">
                                <label>
                                    <input name="yoomoney_kassa_payment_options[]" class="cls_yoomoney_paymentOpt qa-<?= $val; ?>-checkbox" type="checkbox"
                                           value="<?php echo $val; ?>"
                                        <?php echo ($kassa->isPaymentMethodEnabled($val) ? 'checked' : '') ?> />
                                    <?php echo htmlspecialchars($name); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        <div class="checkbox" style="padding: 0 0 0 20px;">
                            <label class="radio-inline control-label">
                                <input type="checkbox" name="yoomoney_kassa_add_installments_block"
                                       value="1"<?php echo $kassa->getAddInstallmentsBlock() ? ' checked="checked"' : ''; ?> />
                                <?php echo $lang->get('kassa_add_installments_block_label'); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Currency Start-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="yoomoney-kassa-currency"><?= $lang->get('kassa_currency')?></label>
                        <div class="col-sm-4">
                            <select id="yoomoney-kassa-currency" name="yoomoney_kassa_currency" class="form-control">
                                <?php foreach ($kassa_currencies as $code => $data): ?>
                                    <option value="<?= $code ?>"<?= $kassa->getCurrency() == $code ? ' selected' : '' ?>><?= $data['code'] ?> (<?= $data['title'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block"><?= $lang->get('kassa_currency_help')?></p>
                        </div>
                        <div class="col-sm-5">
                            <label class="form-check-label">
                                <input type="checkbox" name="yoomoney_kassa_currency_convert" value="on"
                                       id="currency_convert"
                                       class="form-check-input"<?= $kassa->getCurrencyConvert() ? ' checked' : '' ?> />
                                <?= $lang->get('kassa_currency_convert')?>
                            </label>
                            <p class="help-block"><?= $lang->get('kassa_currency_convert_help')?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sbbol Start-->
        <div class="row">
            <div class="col-md-12">
                <div class="form-horizontal">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_page_success"><?php echo $lang->get('b2b_sberbank_label'); ?></label>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <label>
                                <input type="checkbox" id="kassa-b2b-sberbank-on" name="yoomoney_kassa_b2b_sberbank_enabled"
                                       value="on"<?php echo $kassa->getB2bSberbankEnabled() ? ' checked' : ''; ?> />
                                <span><?php echo $lang->get('b2b_sberbank_on_label'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"
                                   for="b2b-sberbank-description-template"><?= $lang->get('b2b_sberbank_template_label') ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="yoomoney_kassa_b2b_sberbank_payment_purpose"
                                       value="<?= $kassa->getB2bSberbankPaymentPurpose() ?>"
                                       placeholder="<?= $lang->get('kassa_default_payment_description') ?>"
                                       id="_b2b_sberbank_payment_purpose" class="form-control"/>
                                <p class="help-block"><?= $lang->get('b2b_sberbank_template_help'); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="kassa-b2b-tax-rate-default">
                                <?php echo $lang->get('b2b_sberbank_vat_default_label'); ?>
                            </label>
                            <div class="col-sm-9">
                                <select id="kassa-b2b-tax-rate-default" name="yoomoney_kassa_b2b_tax_rate_default"
                                        class="form-control">
                                    <?php foreach ($b2bTaxRates as $id => $name) : ?>
                                        <option value="<?php echo $id; ?>"<?php echo $kassa->getB2bSberbankDefaultTaxRate() == $id ? ' selected' : ''; ?>><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block"><?php echo $lang->get('b2b_sberbank_vat_default_help'); ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <?php echo $lang->get('b2b_sberbank_vat_label'); ?>
                            </label>
                            <div class="col-sm-9">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><?php echo $lang->get('b2b_sberbank_vat_cms_label'); ?></th>
                                        <th><?php echo $lang->get('b2b_sberbank_vat_sbbol_label'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($tax_classes as $id => $name) : ?>
                                        <tr>
                                            <td>
                                                <label class="control-label"
                                                       for="kassa-tax-rate-<?php echo $id; ?>"><?php echo $name; ?></td>
                                            <td>
                                                <select id="kassa-b2b-tax-rate-<?php echo $id; ?>"
                                                        name="yoomoney_kassa_b2b_tax_rates[<?php echo $id; ?>]"
                                                        class="form-control">
                                                    <?php $v = $kassa->getB2bTaxRateId($id);
                                                    foreach ($b2bTaxRates as $taxRateId => $taxRateName) : ?>
                                                        <option value="<?php echo $taxRateId; ?>"<?php echo $v == $taxRateId ? ' selected' : ''; ?>><?php echo $taxRateName; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p class="help-block"><?php echo $lang->get('b2b_sberbank_tax_message'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <!-- Success page start   -->
                <div class="form-group" id="yoomoney-success-page">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_page_success"><?php echo $lang->get('kassa_success_page_label'); ?></label>
                    <div class="col-sm-8">
                        <select name="yoomoney_kassa_page_success" id="yoomoney_kassa_page_success" class="form-control">
                            <option value="0" <?php if ($kassa->getSuccessPageId() <= 0) echo 'selected="selected"'; ?>>---<?php echo $lang->get('kassa_page_default'); ?></option>
                            <?php foreach ($pages_mpos as $id => $title) :
                            $mp_checked = ($id == $kassa->getSuccessPageId()) ? 'selected="selected"':''; ?>
                            <option value="<?php echo $id; ?>" <?php echo $mp_checked;?>><?php echo $title; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"><?php echo $lang->get('kassa_success_page_description'); ?></p>
                    </div>
                </div>
                <!-- Failure page start   -->
                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_page_failure"><?php echo $lang->get('kassa_failure_page_label'); ?></label>
                    <div class="col-sm-8">
                        <select name="yoomoney_kassa_page_failure" id="yoomoney_kassa_page_failure" class="form-control">
                            <option value="0" <?php if ($kassa->getFailurePageId() <= 0) echo 'selected="selected"'; ?>>---<?php echo $lang->get('kassa_page_default'); ?></option>
                            <?php foreach ($pages_mpos as $id => $title) :
                            $mp_checked = ($id == $kassa->getFailurePageId())?'selected="selected"':''; ?>
                            <option value="<?php echo $id; ?>" <?php echo $mp_checked;?>><?php echo $title; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"><?php echo $lang->get('kassa_failure_page_description'); ?></p>
                    </div>
                </div>
                <!-- Payment method name start -->
                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_payment_method_name"><?php echo $lang->get('kassa_page_title_label'); ?></label>
                    <div class="col-sm-8">
                        <input name="yoomoney_kassa_payment_method_name" type="text" class="form-control"
                               id="yoomoney_kassa_payment_method_name" value="<?php echo empty($yoomoney_kassa_payment_method_name) ? $lang->get('kassa_page_title_default') : $yoomoney_kassa_payment_method_name; ?>" />
                        <p class="help-block"><?php echo $lang->get('kassa_page_title_help'); ?></p>
                    </div>
                </div>
                <!-- Transaction template start -->
                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_description_template"><?php echo $lang->get('kassa_description_title'); ?></label>
                    <div class="col-sm-8">
                        <input name="yoomoney_kassa_description_template" type="text" class="form-control"
                               id="yoomoney_kassa_description_template" value="<?= $yoomoney_kassa_description_template ?: $lang->get('kassa_description_default_placeholder'); ?>" />
                        <p class="help-block"><?php echo $lang->get('kassa_description_help'); ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_enable_hold_mode"><?= $lang->get('kassa_hold_setting_label'); ?></label>
                    <div class="col-sm-8">
                        <div class="checkbox">
                            <input class="qa-enable-hold-control" type="checkbox" name="yoomoney_kassa_enable_hold_mode" id="yoomoney_kassa_enable_hold_mode"
                                       value="1" <?= $kassa->isHoldModeEnable() ? 'checked' : ''; ?> />
                            <span><?= $lang->get('kassa_hold_setting_description'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="with-hold-only col-sm-offset-3">
                    <div style="margin: 0 0 10px 27px;">
                        <label><?php echo $lang->get('kassa_hold_order_statuses_label'); ?></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3"
                               for="yoomoney_kassa_hold_order_status"><?php echo $lang->get('kassa_hold_order_status_label'); ?></label>
                        <div class="col-sm-7">
                            <select name="yoomoney_kassa_hold_order_status" id="yoomoney_kassa_hold_order_status"
                                    class="form-control" data-toggle="tooltip" data-placement="left" title="">
                                <?php foreach ($orderStatusList as $id => $status): ?>
                                    <option value="<?php echo $id; ?>"<?= $id == $kassa->getHoldOrderStatusId() ? ' selected="selected"' : ''; ?>><?= htmlspecialchars($status); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block">
                                <?= $lang->get('kassa_hold_order_status_help'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3"
                               for="yoomoney_kassa_cancel_order_status"><?php echo $lang->get('kassa_cancel_order_status_label'); ?></label>
                        <div class="col-sm-7">
                            <select name="yoomoney_kassa_cancel_order_status" id="yoomoney_kassa_cancel_order_status"
                                    class="form-control" data-toggle="tooltip" data-placement="left" title="">
                                <?php foreach ($orderStatusList as $id => $status): ?>
                                    <option value="<?php echo $id; ?>"<?= $id == $kassa->getCancelOrderStatusId() ? ' selected="selected"' : ''; ?>><?= htmlspecialchars($status); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block">
                                <?= $lang->get('kassa_cancel_order_status_help'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 54-ФЗ -->
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <h4><?= $lang->get('kassa_auth_enable_54fz_title') ?></h4>
                        <p><?= $lang->get('kassa_auth_enable_54fz') ?></p>
                    </div>
                    <label class="col-sm-3 control-label"><?php echo $lang->get('kassa_send_receipt_label'); ?></label>
                    <div class="col-sm-9">
                        <label class="radio-inline" for="yoomoney_kassa_send_receipt_off">
                            <input type="radio" name="yoomoney_kassa_send_receipt" id="yoomoney_kassa_send_receipt_off"
                                   class="cls_yoomoney_54lawmode qa-disable-receipt-control" value="0"
                                <?php if ($yoomoney_kassa_send_receipt != '1') { echo "checked"; }?>> <?php echo $lang->get('disable'); ?>
                        </label>
                        <label class="radio-inline" for="yoomoney_kassa_send_receipt_on">
                            <input type="radio" name="yoomoney_kassa_send_receipt" id="yoomoney_kassa_send_receipt_on"
                                   class="cls_yoomoney_54lawmode qa-enable-receipt-control" value="1"
                                <?php if ($yoomoney_kassa_send_receipt == '1') { echo "checked"; }?>> <?php echo $lang->get('enable'); ?>
                        </label>
                    </div>
                </div>
                <div class="form-group select54Law">
                    <label class="col-sm-3 control-label"><?php echo $lang->get('kassa_all_tax_rate_label'); ?></label>
                    <div class="col-sm-8">
                        <p style="padding-top: 8px;"><b><?php echo $lang->get('kassa_default_tax_rate_label'); ?></b></p>
                        <select name="yoomoney_kassa_receipt_tax_id[default]" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                            <?php foreach ($kassa_taxes as $tax_id => $tax_name) : ?>
                                <?php if (isset($yoomoney_kassa_receipt_tax_id["default"]) && $tax_id == $yoomoney_kassa_receipt_tax_id["default"]) : ?>
                                <option value="<?php echo $tax_id; ?>" selected="selected"><?php echo $tax_name; ?></option>
                                <?php else : ?>
                                <option value="<?php echo $tax_id; ?>"><?php echo $tax_name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"><?php echo $lang->get('kassa_default_tax_rate_description'); ?></p>
                    </div>
                    <div class="col-sm-8 col-sm-offset-3">
                        <p style="padding-top: 15px;"><b><?php echo $lang->get('kassa_tax_rate_description'); ?></b></p>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th><?php echo $lang->get('kassa_tax_rate_site_header'); ?></th>
                                <th><?php echo $lang->get('kassa_tax_rate_kassa_header'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tax_classes as $id => $title) : ?>
                            <tr>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <select name="yoomoney_kassa_receipt_tax_id[<?php echo $id; ?>]" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                                    <?php foreach ($kassa_taxes as $tax_id => $tax_name) : ?>
                                        <?php if (isset($yoomoney_kassa_receipt_tax_id[$id]) && $tax_id == $yoomoney_kassa_receipt_tax_id[$id]) : ?>
                                        <option value="<?php echo $tax_id; ?>" selected="selected"><?php echo $tax_name; ?></option>
                                        <?php else : ?>
                                        <option value="<?php echo $tax_id; ?>"><?php echo $tax_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8 col-sm-offset-3">
                        <p style="padding-top: 8px;"><b><?php echo $lang->get('kassa_default_tax_system_label'); ?></b></p>
                        <select name="yoomoney_kassa_default_tax_system" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                            <option value="">-</option>
                            <?php foreach ($kassa_tax_systems as $tax_id => $tax_name) : ?>
                                <?php if (isset($yoomoney_kassa_default_tax_system) && $tax_id == $yoomoney_kassa_default_tax_system) : ?>
                                    <option value="<?php echo $tax_id; ?>" selected="selected"><?php echo $tax_name; ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $tax_id; ?>"><?php echo $tax_name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"><?php echo $lang->get('kassa_default_tax_system_description'); ?></p>
                    </div>
                    <div class="col-sm-8 col-sm-offset-3">
                        <p class="help-block"><?php echo $lang->get('ffd_help_message'); ?></p>
                        <p style="padding-top: 8px;"><b><?php echo $lang->get('kassa_default_payment_mode_label'); ?></b></p>
                        <select name="yoomoney_kassa_default_payment_mode" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                            <?php foreach ($paymentModeEnum as $paymentMode => $paymentModeTitle) : ?>
                                <option value="<?php echo $paymentMode; ?>" <?= $kassa->getDefaultPaymentMode() != $paymentMode ?: 'selected="selected"'?>><?php echo $paymentModeTitle; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-8 col-sm-offset-3">
                        <p style="padding-top: 8px;"><b><?php echo $lang->get('kassa_default_payment_subject_label'); ?></b></p>
                        <select name="yoomoney_kassa_default_payment_subject" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                            <?php foreach ($paymentSubjectEnum as $paymentSubject => $paymentSubjectTitle) : ?>
                                <option value="<?php echo $paymentSubject ; ?>" <?= $kassa->getDefaultPaymentSubject() != $paymentSubject ?: 'selected="selected"'?>><?php echo $paymentSubjectTitle; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Second receipt -->

                    <div class="col-sm-8 col-sm-offset-3">
                        <p style="padding-top: 8px;">
                            <div class="checkbox">
                                <label>
                                    <input type="hidden"   name="yoomoney_kassa_second_receipt_enable" value="0"/>
                                    <input type="checkbox" name="yoomoney_kassa_second_receipt_enable"
                                           id="yoomoney_kassa_second_receipt_enable"
                                           class="qa-second-receipt-enable"
                                        <?= $kassa->isSecondReceiptEnable() ? 'checked' : ''; ?> value="1"/>
                                    <b><?php echo $lang->get('kassa_second_receipt_header'); ?></b>
                                </label>
                            </div>
                        </p>

                        <p><?php echo $lang->get('kassa_second_receipt_description'); ?></p>

                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td style="border: none">
                                        <?= $lang->get('kassa_second_receipt_enable_label'); ?>
                                    </td>
                                    <td style="border: none">
                                        <select id="yoomoney_kassa_second_receipt_status"
                                                name="yoomoney_kassa_second_receipt_status"
                                                class="form-control col-xl-4 col-md-4 qa-second-receipt-status-select"
                                                data-toggle="tooltip"
                                                data-placement="left" title="">
                                            <?php foreach ($orderStatusList as $id => $status) : ?>
                                                    <option value="<?php echo $id; ?>"<?php echo ($id != $kassa->getSecondReceiptStatus() ?: ' selected="selected"'); ?>><?php echo htmlspecialchars($status); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="help-block"><?php echo $lang->get('kassa_second_receipt_help_info'); ?></p>

                    </div>

                    <!-- -->

                </div>
                <!-- -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3"><?php echo $lang->get('kassa_notification_url_label'); ?></label>
                    <div class="col-sm-8">
                        <input class="form-control disabled" value="<?php echo htmlspecialchars($callback_url); ?>" disabled>
                        <p class="help-block"><?php echo $lang->get('kassa_notification_url_description'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h4 class="form-heading"><?php echo $lang->get('kassa_feature_header'); ?></h4>
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="yoomoney_kassa_debug_mode" class="col-sm-3 control-label"><?php echo $lang->get('kassa_debug_label'); ?></label>
                    <div class="col-sm-9">
                        <label class="radio-inline" for="yoomoney_kassa_debug_mode_off">
                            <input type="radio" name="yoomoney_kassa_debug_mode" id="yoomoney_kassa_debug_mode_off"
                                   class="cls_yoomoney_debugmode" value="0" <?php if ($yoomoney_kassa_debug_mode != '1') { echo "checked"; }?> />
                            <?php echo $lang->get('disable'); ?>
                        </label>
                        <label class="radio-inline" for="yoomoney_kassa_debug_mode_on">
                            <input type="radio" name="yoomoney_kassa_debug_mode" id="yoomoney_kassa_debug_mode_on"
                                   class="cls_yoomoney_debugmode" value="1" <?php if ($yoomoney_kassa_debug_mode == '1') { echo "checked"; }?> />
                            <?php echo $lang->get('enable'); ?>
                        </label>
                        <p class="help-block"><?php echo $lang->get('kassa_debug_description'); ?></p>
                        <p class="help-block"><a href="<?php echo $kassa_logs_link; ?>"><?php echo $lang->get('kassa_view_logs'); ?></a></p>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-sm-3 control-label">Список платежей через модуль ЮKassa</label>
                    <div class="col-sm-9">
                        <p class="help-block"><a href="<?php echo $kassa_payments_link; ?>">Открыть список</a></p>
                    </div>
                </div>
                -->
                <div class="form-group">
                    <div class="col-sm-3 control-label"><strong><?php echo $lang->get('kassa_before_redirect_label'); ?></strong></div>
                    <div class="col-sm-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="yoomoney_kassa_create_order_before_redirect" id="yoomoney_kassa_create_order_before_redirect"
                                       value="1" <?php echo ($kassa->getCreateOrderBeforeRedirect() ? 'checked' : ''); ?> />
                                <?php echo $lang->get('kassa_create_order_label'); ?>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="yoomoney_kassa_clear_cart_before_redirect" id="yoomoney_kassa_clear_cart_before_redirect"
                                       value="1" <?php echo ($kassa->getClearCartBeforeRedirect() ? 'checked' : ''); ?> />
                                <?php echo $lang->get('kassa_clear_cart_label'); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="yoomoney-new-status">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_new_order_status"><?php echo $lang->get('kassa_order_status_label'); ?></label>
                    <div class="col-sm-8">
                        <select name="yoomoney_kassa_new_order_status" id="yoomoney_kassa_new_order_status" class="form-control" data-toggle="tooltip" data-placement="left" title="">
                            <?php foreach ($orderStatusList as $id => $status) : ?>
                            <option value="<?php echo $id; ?>"<?php echo ($id == $yoomoney_kassa_new_order_status ? ' selected="selected"' : ''); ?>><?php echo htmlspecialchars($status); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_sort_order"><?php echo $lang->get('kassa_ordering_label'); ?></label>
                    <div class="col-sm-8">
                        <input name="yoomoney_kassa_sort_order" id="yoomoney_kassa_sort_order" type="text" class="form-control"
                               value="<?php echo (int) $yoomoney_kassa_sort_order; ?>" />
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="yoomoney_kassa_id_zone"><?php echo $lang->get('kassa_geo_zone_label'); ?></label>
                    <div class="col-sm-8">
                        <select name="yoomoney_kassa_id_zone" id="yoomoney_kassa_id_zone" class="form-control">
                            <option value="0"><?php echo $lang->get('kassa_all_zones'); ?></option>
                            <?php foreach ($geoZoneList as $id => $geoZone) : ?>
                            <option value="<?php echo $id; ?>"<?php echo ($id == $yoomoney_kassa_id_zone ? ' selected="selected"' : ''); ?>><?php echo htmlspecialchars($geoZone); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
</div>
<!-- для tab-kassa -->

<script>

jQuery(document).ready(function() {

    function getRadioValue(elements) {
        for (var i = 0; i < elements.length; ++i) {
            if (elements[i].checked) {
                return elements[i].value;
            }
        }
        return elements[0].value;
    }

    function triggerPaymentMode(value) {
        if (value == 'kassa') {
            jQuery('.selectPayOpt').slideUp();
            jQuery('.selectPayKassa').slideDown();
        } else {
            jQuery('.selectPayOpt').slideDown();
            jQuery('.selectPayKassa').slideUp();
        }
    }

    function triggerReceipt(value) {
        if (value == '1') {
            jQuery('.select54Law').slideDown();
        } else {
            jQuery('.select54Law').slideUp();
        }
    }

    var paymentMode = jQuery('input[name=yoomoney_kassa_payment_mode]');
    paymentMode.change(function () {
        triggerPaymentMode(this.value);
    });
    triggerPaymentMode(getRadioValue(paymentMode));

    var sendReceipt = jQuery('input[name=yoomoney_kassa_send_receipt]');
    sendReceipt.change(function () {
        triggerReceipt(this.value);
    });
    triggerReceipt(getRadioValue(sendReceipt));

    function triggerEnableHold() {
        if ($('#yoomoney_kassa_enable_hold_mode').prop("checked")) {
            $('.with-hold-only').slideDown();
        } else {
            $('.with-hold-only').slideUp();
        }
    }

    jQuery('.selectPayOpt input').change(function () {
        if (jQuery(this).val() !== 'widget') {
            return;
        } else if (!jQuery(this).prop('checked')) {
            return;
        }

        jQuery.ajax({
            url: "<?php echo htmlspecialchars_decode($install_widget_link); ?>",
            dataType: "json",
            method: "GET",
            success: function (data) {
                if (!data.ok) {
                    jQuery('#kassa-payment-method-warning').html(data.error).show();
                }
            },
        });
    })

    $('#yoomoney_kassa_enable_hold_mode').on('change', triggerEnableHold);
    triggerEnableHold();

    $('input[name=yoomoney_kassa_add_installments_block]').on('change', function () {
        var checked = this.checked;
        $('input[name=yoomoney_kassa_add_installments_block]').each(function() {
            this.checked = checked;
        });
    });
});

</script>

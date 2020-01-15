<?php
class ControllerPaymentSbacquiring2 extends Controller {
	private $error = array();
	private $pname = 'sbacquiring2';
	private $ver = '1.5.0.0.0.2.1.1';

	public function index($payname = 'sbacquiring2') {
        $pname = isset($payname['name']) ? $payname['name'] : $this->pname;

        $this->data['version'] = $this->ver;

        $this->install();

        $this->load->language('payment/sbacquiringpro');
        $this->load->language('payment/sbacquiring2');
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->model_setting_setting->editSetting('sbacquiring2', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->error['license'])) {
            $this->data['error_license'] = $this->error['license'];
        } else {
            $this->data['error_license'] = '';
        }

        if (isset($this->request->post['sbacquiring2_license'])) {
            $this->data['sbacquiring2_license'] = $this->request->post['sbacquiring2_license'];
        } else {
            $this->data['sbacquiring2_license'] = $this->config->get('sbacquiring2_license');
        }

        $this->data['entry_license'] = $this->language->get('entry_license');
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_liqpay'] = $this->language->get('text_liqpay');
        $this->data['text_card'] = $this->language->get('text_card');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['entry_userName'] = $this->language->get('entry_userName');
        $this->data['entry_scid'] = $this->language->get('entry_scid');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['copy_result_url'] = HTTPS_CATALOG . 'index.php?route=account/sbacquiring2/callback';
        $this->data['entry_sbacquiring_name_tab'] = $this->language->get('entry_sbacquiring_name_tab');
        $this->data['text_my'] = $this->language->get('text_my');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['entry_komis'] = $this->language->get('entry_komis');
        $this->data['entry_minpay'] = $this->language->get('entry_minpay');
        $this->data['entry_maxpay'] = $this->language->get('entry_maxpay');
        $this->data['entry_style'] = $this->language->get('entry_style');
        $this->data['entry_start_status'] = $this->language->get('entry_start_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_on_status'] = $this->language->get('entry_on_status');
        $this->data['entry_order_status'] = $this->language->get('entry_order_status');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['entry_sbacquiring_instruction_tab'] = $this->language->get('entry_sbacquiring_instruction_tab');
        $this->data['entry_sbacquiring_instruction'] = $this->language->get('entry_sbacquiring_instruction');
        $this->data['entry_sbacquiring_mail_instruction_tab'] = $this->language->get('entry_sbacquiring_mail_instruction_tab');
        $this->data['entry_sbacquiring_mail_instruction'] = $this->language->get('entry_sbacquiring_mail_instruction');
        $this->data['entry_sbacquiring_hrefpage_tab'] = $this->language->get('entry_sbacquiring_hrefpage_tab');
        $this->data['entry_sbacquiring_hrefpage'] = $this->language->get('entry_sbacquiring_hrefpage');
        $this->data['entry_sbacquiring_success_comment_tab'] = $this->language->get('entry_sbacquiring_success_comment_tab');
        $this->data['entry_sbacquiring_success_comment'] = $this->language->get('entry_sbacquiring_success_comment');
        $this->data['entry_sbacquiring_name'] = $this->language->get('entry_sbacquiring_name');
        $this->data['entry_sbacquiring_success_alert_admin_tab'] = $this->language->get('entry_sbacquiring_success_alert_admin_tab');
        $this->data['entry_sbacquiring_success_alert_customer_tab'] = $this->language->get('entry_sbacquiring_success_alert_customer_tab');
        $this->data['entry_sbacquiring_success_page_tab'] = $this->language->get('entry_sbacquiring_success_page_tab');
        $this->data['entry_sbacquiring_success_page_text'] = $this->language->get('entry_sbacquiring_success_page_text');
        $this->data['entry_sbacquiring_waiting_page_tab'] = $this->language->get('entry_sbacquiring_waiting_page_tab');
        $this->data['entry_sbacquiring_waiting_page_text'] = $this->language->get('entry_sbacquiring_waiting_page_text');
        $this->data['entry_button_later'] = $this->language->get('entry_button_later');
        $this->data['entry_fixen'] = $this->language->get('entry_fixen');
        $this->data['entry_fixen_order'] = $this->language->get('entry_fixen_order');
        $this->data['entry_fixen_proc'] = $this->language->get('entry_fixen_proc');
        $this->data['entry_fixen_fix'] = $this->language->get('entry_fixen_fix');
        $this->data['entry_fixen_amount'] = $this->language->get('entry_fixen_amount');
        $this->data['text_createorder_or_notcreate'] = $this->language->get('text_createorder_or_notcreate');
        $this->data['entry_fail_page_tab'] = $this->language->get('entry_fail_page_tab');
        $this->data['entry_fail_page_text'] = $this->language->get('entry_fail_page_text');
        $this->data['entry_met'] = $this->language->get('entry_met');
        $this->data['entry_met_odnostage'] = $this->language->get('entry_met_odnostage');
        $this->data['entry_met_preautoriz'] = $this->language->get('entry_met_preautoriz');
        $this->data['entry_servadr'] = $this->language->get('entry_servadr');
        $this->data['entry_servadr_test'] = $this->language->get('entry_servadr_test');
        $this->data['entry_servadr_real'] = $this->language->get('entry_servadr_real');
        $this->data['entry_servadr_self'] = $this->language->get('entry_servadr_self');
        $this->data['entry_self'] = $this->language->get('entry_self');
        $this->data['entry_zapros'] = $this->language->get('entry_zapros');
        $this->data['entry_curl'] = $this->language->get('entry_curl');
        $this->data['entry_fgc'] = $this->language->get('entry_fgc');
        $this->data['entry_currency'] = $this->language->get('entry_currency');
        $this->data['entry_currency_rub'] = $this->language->get('entry_currency_rub');
        $this->data['entry_currency_self'] = $this->language->get('entry_currency_self');
        $this->data['entry_currency_self_text'] = $this->language->get('entry_currency_self_text');
        $this->data['entry_currency_convert'] = $this->language->get('entry_currency_convert');
        $this->data['entry_callbackemulate'] = $this->language->get('entry_callbackemulate');
        $this->data['entry_callbackemulate_yes'] = $this->language->get('entry_callbackemulate_yes');
        $this->data['entry_callbackemulate_no'] = $this->language->get('entry_callbackemulate_no');
        $this->data['text_UPC'] = $this->language->get('text_UPC');
        $this->data['text_JAN'] = $this->language->get('text_JAN');
        $this->data['text_ISBN'] = $this->language->get('text_ISBN');
        $this->data['text_MPN'] = $this->language->get('text_MPN');
        $this->data['text_EAN'] = $this->language->get('text_EAN');

        if (isset($this->error['self'])) {
            $this->data['error_self'] = $this->error['self'];
        } else {
            $this->data['error_self'] = '';
        }

        if (isset($this->error['currency_self'])) {
            $this->data['error_currency_self'] = $this->error['currency_self'];
        } else {
            $this->data['error_currency_self'] = '';
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['userName'])) {
            $this->data['error_userName'] = $this->error['userName'];
        } else {
            $this->data['error_userName'] = '';
        }

        if (isset($this->error['yadserver'])) {
            $this->data['error_yadserver'] = $this->error['yadserver'];
        } else {
            $this->data['error_yadserver'] = '';
        }

        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }

        $this->data['pname'] = $pname;
        $this->load->model('payment/sbacquiring2');
        $setpros = $this->model_payment_sbacquiring2->getProSettings();

        $this->data['entry_nds_tovar'] = $this->language->get('entry_nds_tovar');
        $this->data['entry_nds_important'] = $this->language->get('entry_nds_important');
        $this->data['entry_nds_no'] = $this->language->get('entry_nds_no');
        $this->data['entry_nds_important_nol'] = $this->language->get('entry_nds_important_nol');
        $this->data['entry_nds_important_10'] = $this->language->get('entry_nds_important_10');
        $this->data['entry_nds_important_18'] = $this->language->get('entry_nds_important_18');
        $this->data['entry_nds_important_110'] = $this->language->get('entry_nds_important_110');
        $this->data['entry_nds_important_118'] = $this->language->get('entry_nds_important_118');
        $this->data['entry_tax'] = $this->language->get('entry_tax');
        $this->data['entry_returnpage_self'] = $this->language->get('entry_returnpage_self');
        $this->data['entry_returnpage_default'] = $this->language->get('entry_returnpage_default');
        $this->data['entry_otlog_standard'] = $this->language->get('entry_otlog_standard');
        $this->data['entry_otlog_pay'] = $this->language->get('entry_otlog_pay');
        $this->data['entry_otlog_stock'] = $this->language->get('entry_otlog_stock');

        foreach ($setpros as $setpro) {
            $this->data['entry_' . $setpro] = $this->language->get('entry_' . $setpro);
            if (isset($this->request->post[$pname . '_' . $setpro])){
                $this->data['sbacquiringpro_' . $setpro] = $this->request->post[$pname . '_' . $setpro];
            } else {
                $this->data['sbacquiringpro_' . $setpro] = $this->config->get($pname . '_' . $setpro);
            }}

        if (isset($this->request->post[$pname . '_classes'])) {
            $this->data['sbacquiringpro_classes'] = $this->request->post[$pname . '_classes'];
        } elseif ($this->config->get($pname . '_classes') && isset($this->config->get($pname . '_classes')[0][$pname . '_nalog'])) {
            $this->data['sbacquiringpro_classes'] = $this->config->get($pname . '_classes');
        } else {
            $this->data['sbacquiringpro_classes'] = array(array($pname . '_nalog' => 0, $pname . '_tax_rule' => round(0)));
        }

        $this->data['tax_rules'] = array(
            array(
                'id' => 0,
                'name' => $this->language->get('entry_nds_no')
            ),
            array(
                'id' => 1,
                'name' => $this->language->get('entry_nds_important_nol')
            ),
            array(
                'id' => 2,
                'name' => $this->language->get('entry_nds_important_10')
            ),
            array(
                'id' => 3,
                'name' => $this->language->get('entry_nds_important_18')
            ),
            array(
                'id' => 4,
                'name' => $this->language->get('entry_nds_important_110')
            ),
            array(
                'id' => 5,
                'name' => $this->language->get('entry_nds_important_118')
            )
        );

        $this->load->model('localisation/tax_class');
        $this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $this->data['languages'] = $languages;
        foreach ($languages as $language) {
            if (isset($this->request->post['sbacquiring2_name_' . $language['language_id']])) {
                $this->data['sbacquiring2_name_' . $language['language_id']] = $this->request->post['sbacquiring2_name_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_name_' . $language['language_id']] = $this->config->get('sbacquiring2_name_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_instruction'])) {
                $this->data['sbacquiring2_instruction_' . $language['language_id']] = $this->request->post['sbacquiring2_instruction_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_instruction_' . $language['language_id']] = $this->config->get('sbacquiring2_instruction_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_mail_instruction_' . $language['language_id']])) {
                $this->data['sbacquiring2_mail_instruction_' . $language['language_id']] = $this->request->post['sbacquiring2_mail_instruction_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_mail_instruction_' . $language['language_id']] = $this->config->get('sbacquiring2_mail_instruction_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_success_comment_' . $language['language_id']])) {
                $this->data['sbacquiring2_success_comment_' . $language['language_id']] = $this->request->post['sbacquiring2_success_comment_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_success_comment_' . $language['language_id']] = $this->config->get('sbacquiring2_success_comment_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_success_page_text_' . $language['language_id']])) {
                $this->data['sbacquiring2_success_page_text_' . $language['language_id']] = $this->request->post['sbacquiring2_success_page_text_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_success_page_text_' . $language['language_id']] = $this->config->get('sbacquiring2_success_page_text_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_hrefpage_text_' . $language['language_id']])) {
                $this->data['sbacquiring2_hrefpage_text_' . $language['language_id']] = $this->request->post['sbacquiring2_hrefpage_text_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_hrefpage_text_' . $language['language_id']] = $this->config->get('sbacquiring2_hrefpage_text_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_waiting_page_text_' . $language['language_id']])) {
                $this->data['sbacquiring2_waiting_page_text_' . $language['language_id']] = $this->request->post['sbacquiring2_waiting_page_text_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_waiting_page_text_' . $language['language_id']] = $this->config->get('sbacquiring2_waiting_page_text_' . $language['language_id']);
            }
            if (isset($this->request->post['sbacquiring2_fail_page_text_' . $language['language_id']])) {
                $this->data['sbacquiring2_fail_page_text_' . $language['language_id']] = $this->request->post['sbacquiring2_fail_page_text_' . $language['language_id']];
            } else {
                $this->data['sbacquiring2_fail_page_text_' . $language['language_id']] = $this->config->get('sbacquiring2_fail_page_text_' . $language['language_id']);
            }
        }

        if (isset($this->request->post['sbacquiring2_komis'])) {
            $this->data['sbacquiring2_komis'] = $this->request->post['sbacquiring2_komis'];
        } else {
            $this->data['sbacquiring2_komis'] = $this->config->get('sbacquiring2_komis');
        }

        if (isset($this->request->post['sbacquiring2_minpay'])) {
            $this->data['sbacquiring2_minpay'] = $this->request->post['sbacquiring2_minpay'];
        } else {
            $this->data['sbacquiring2_minpay'] = $this->config->get('sbacquiring2_minpay');
        }

        if (isset($this->request->post['sbacquiring2_maxpay'])) {
            $this->data['sbacquiring2_maxpay'] = $this->request->post['sbacquiring2_maxpay'];
        } else {
            $this->data['sbacquiring2_maxpay'] = $this->config->get('sbacquiring2_maxpay');
        }

        if (isset($this->request->post['sbacquiring2_style'])) {
            $this->data['sbacquiring2_style'] = $this->request->post['sbacquiring2_style'];
        } else {
            $this->data['sbacquiring2_style'] = $this->config->get('sbacquiring2_style');
        }

        if (isset($this->request->post['sbacquiring2_instruction_attach'])) {
            $this->data['sbacquiring2_instruction_attach'] = $this->request->post['sbacquiring2_instruction_attach'];
        } else {
            $this->data['sbacquiring2_instruction_attach'] = $this->config->get('sbacquiring2_instruction_attach');
        }

        if (isset($this->request->post['sbacquiring2_name_attach'])) {
            $this->data['sbacquiring2_name_attach'] = $this->request->post['sbacquiring2_name_attach'];
        } else {
            $this->data['sbacquiring2_name_attach'] = $this->config->get('sbacquiring2_name_attach');
        }

        if (isset($this->request->post['sbacquiring2_success_alert_admin'])) {
            $this->data['sbacquiring2_success_alert_admin'] = $this->request->post['sbacquiring2_success_alert_admin'];
        } else {
            $this->data['sbacquiring2_success_alert_admin'] = $this->config->get('sbacquiring2_success_alert_admin');
        }

        if (isset($this->request->post['sbacquiring2_success_alert_customer'])) {
            $this->data['sbacquiring2_success_alert_customer'] = $this->request->post['sbacquiring2_success_alert_customer'];
        } else {
            $this->data['sbacquiring2_success_alert_customer'] = $this->config->get('sbacquiring2_success_alert_customer');
        }

        if (isset($this->request->post['sbacquiring2_mail_instruction_attach'])) {
            $this->data['sbacquiring2_mail_instruction_attach'] = $this->request->post['sbacquiring2_mail_instruction_attach'];
        } else {
            $this->data['sbacquiring2_mail_instruction_attach'] = $this->config->get('sbacquiring2_mail_instruction_attach');
        }

        if (isset($this->request->post['sbacquiring2_success_comment_attach'])) {
            $this->data['sbacquiring2_success_comment_attach'] = $this->request->post['sbacquiring2_success_comment_attach'];
        } else {
            $this->data['sbacquiring2_success_comment_attach'] = $this->config->get('sbacquiring2_success_comment_attach');
        }

        if (isset($this->request->post['sbacquiring2_success_page_text_attach'])) {
            $this->data['sbacquiring2_success_page_text_attach'] = $this->request->post['sbacquiring2_success_page_text_attach'];
        } else {
            $this->data['sbacquiring2_success_page_text_attach'] = $this->config->get('sbacquiring2_success_page_text_attach');
        }

        if (isset($this->request->post['sbacquiring2_hrefpage_text_attach'])) {
            $this->data['sbacquiring2_hrefpage_text_attach'] = $this->request->post['sbacquiring2_hrefpage_text_attach'];
        } else {
            $this->data['sbacquiring2_hrefpage_text_attach'] = $this->config->get('sbacquiring2_hrefpage_text_attach');
        }

        if (isset($this->request->post['sbacquiring2_waiting_page_text_attach'])) {
            $this->data['sbacquiring2_waiting_page_text_attach'] = $this->request->post['sbacquiring2_waiting_page_text_attach'];
        } else {
            $this->data['sbacquiring2_waiting_page_text_attach'] = $this->config->get('sbacquiring2_waiting_page_text_attach');
        }

        if (isset($this->request->post['sbacquiring2_button_later'])) {
            $this->data['sbacquiring2_button_later'] = $this->request->post['sbacquiring2_button_later'];
        } else {
            $this->data['sbacquiring2_button_later'] = $this->config->get('sbacquiring2_button_later');
        }

        if (isset($this->request->post['sbacquiring2_fixen'])) {
            $this->data['sbacquiring2_fixen'] = $this->request->post['sbacquiring2_fixen'];
        } else {
            $this->data['sbacquiring2_fixen'] = $this->config->get('sbacquiring2_fixen');
        }

        if (isset($this->error['fixen'])) {
            $this->data['error_fixen'] = $this->error['fixen'];
        } else {
            $this->data['error_fixen'] = '';
        }

        if (isset($this->request->post['sbacquiring2_fixen_amount'])) {
            $this->data['sbacquiring2_fixen_amount'] = $this->request->post['sbacquiring2_fixen_amount'];
        } else {
            $this->data['sbacquiring2_fixen_amount'] = $this->config->get('sbacquiring2_fixen_amount');
        }

        if (isset($this->request->post['sbacquiring2_createorder_or_notcreate'])) {
            $this->data['sbacquiring2_createorder_or_notcreate'] = $this->request->post['sbacquiring2_createorder_or_notcreate'];
        } else {
            $this->data['sbacquiring2_createorder_or_notcreate'] = $this->config->get('sbacquiring2_createorder_or_notcreate');
        }

        if (isset($this->request->post['sbacquiring2_fail_page_text_attach'])) {
            $this->data['sbacquiring2_fail_page_text_attach'] = $this->request->post['sbacquiring2_fail_page_text_attach'];
        } else {
            $this->data['sbacquiring2_fail_page_text_attach'] = $this->config->get('sbacquiring2_fail_page_text_attach');
        }

        if (isset($this->request->post['sbacquiring2_met'])) {
            $this->data['sbacquiring2_met'] = $this->request->post['sbacquiring2_met'];
        } else {
            $this->data['sbacquiring2_met'] = $this->config->get('sbacquiring2_met');
        }

        if (isset($this->request->post['sbacquiring2_servadr'])) {
            $this->data['sbacquiring2_servadr'] = $this->request->post['sbacquiring2_servadr'];
        } else {
            $this->data['sbacquiring2_servadr'] = $this->config->get('sbacquiring2_servadr');
        }

        if (isset($this->request->post['sbacquiring2_servadr_self'])) {
            $this->data['sbacquiring2_servadr_self'] = $this->request->post['sbacquiring2_servadr_self'];
        } else {
            $this->data['sbacquiring2_servadr_self'] = $this->config->get('sbacquiring2_servadr_self');
        }

        if (isset($this->request->post['sbacquiring2_zapros'])) {
            $this->data['sbacquiring2_zapros'] = $this->request->post['sbacquiring2_zapros'];
        } else {
            $this->data['sbacquiring2_zapros'] = $this->config->get('sbacquiring2_zapros');
        }

        if (isset($this->request->post['bacquiring_bankcurrency'])) {
            $this->data['sbacquiring2_bankcurrency'] = $this->request->post['sbacquiring2_bankcurrency'];
        } else {
            $this->data['sbacquiring2_bankcurrency'] = $this->config->get('sbacquiring2_bankcurrency');
        }

        if (isset($this->request->post['sbacquiring2_bankcurrency_self'])) {
            $this->data['sbacquiring2_bankcurrency_self'] = $this->request->post['sbacquiring2_bankcurrency_self'];
        } else {
            $this->data['sbacquiring2_bankcurrency_self'] = $this->config->get('sbacquiring2_bankcurrency_self');
        }

        if (isset($this->request->post['sbacquiring2_currency_convert'])) {
            $this->data['sbacquiring2_currency_convert'] = $this->request->post['sbacquiring2_currency_convert'];
        } else {
            $this->data['sbacquiring2_currency_convert'] = $this->config->get('sbacquiring2_currency_convert');
        }
        $this->load->model('localisation/currency');
        $this->data['currencies'] = $this->model_localisation_currency->getCurrencies();

        if (isset($this->request->post['sbacquiring2_currency'])) {
            $this->data['sbacquiring2_currency'] = $this->request->post['sbacquiring2_currency'];
        } else {
            $this->data['sbacquiring2_currency'] = $this->config->get('sbacquiring2_currency');
        }

        if (isset($this->request->post['sbacquiring2_callbackemulate'])) {
            $this->data['sbacquiring2_callbackemulate'] = $this->request->post['sbacquiring2_callbackemulate'];
        } else {
            $this->data['sbacquiring2_callbackemulate'] = $this->config->get('sbacquiring2_callbackemulate');
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/sbacquiring2', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('payment/sbacquiring2', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['sbacquiring2_userName'])){
            $this->data['sbacquiring2_userName'] = $this->request->post['sbacquiring2_userName'];
        } else {
            $this->data['sbacquiring2_userName'] = $this->config->get('sbacquiring2_userName');
        }

        if (isset($this->request->post['sbacquiring2_password'])) {
            $this->data['sbacquiring2_password'] = $this->request->post['sbacquiring2_password'];
        } else {
            if ($this->config->get('sbacquiring2_password')) {
                $this->data['sbacquiring2_password'] = '**********';
            }
        }

        if (isset($this->request->post[$pname . '_start_status_id'])) {
            $this->data[$pname . '_start_status_id'] = $this->request->post[$pname . '_start_status_id'];
        } else {
            $this->data[$pname . '_start_status_id'] = $this->config->get($pname . '_start_status_id');
        }

        if (isset($this->request->post['sbacquiring2_on_status_id'])) {
            $this->data['sbacquiring2_on_status_id'] = $this->request->post['sbacquiring2_on_status_id'];
        } else {
            $this->data['sbacquiring2_on_status_id'] = $this->config->get('sbacquiring2_on_status_id');
        }

        if (isset($this->request->post['sbacquiring2_order_status_id'])) {
            $this->data['sbacquiring2_order_status_id'] = $this->request->post['sbacquiring2_order_status_id'];
        } else {
            $this->data['sbacquiring2_order_status_id'] = $this->config->get('sbacquiring2_order_status_id');
        }

        $this->load->model('localisation/order_status');
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['sbacquiring2_geo_zone_id'])) {
            $this->data['sbacquiring2_geo_zone_id'] = $this->request->post['sbacquiring2_geo_zone_id'];
        } else {
            $this->data['sbacquiring2_geo_zone_id'] = $this->config->get('sbacquiring2_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['sbacquiring2_status'])) {
            $this->data['sbacquiring2_status'] = $this->request->post['sbacquiring2_status'];
        } else {
            $this->data['sbacquiring2_status'] = $this->config->get('sbacquiring2_status');
        }

        if (isset($this->request->post['sbacquiring2_sort_order'])) {
            $this->data['sbacquiring2_sort_order'] = $this->request->post['sbacquiring2_sort_order'];
        } else {
            $this->data['sbacquiring2_sort_order'] = $this->config->get('sbacquiring2_sort_order');
        }

        foreach ($this->data['languages'] as $key => $language) {
            $this->data['languages'][$key]['imgsrc'] = 'view/image/flags/' . $language['image'];
        }
        
        $this->template = 'payment/sbacquiring2.tpl';
        $this->children = array(
            'common/header', 'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

    public function install() {
        $query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "sbacquiring2 (yandex_id INT(11) AUTO_INCREMENT, num_order INT(8), sum DECIMAL(15,2), user TEXT, email TEXT, status INT(1), date_created DATETIME, date_enroled TEXT, sender TEXT, label TEXT, PRIMARY KEY (yandex_id))");
        $query = $this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` (query,keyword) SELECT * FROM (SELECT 'account/sbacquiring/callback','sbacquiring_callback') AS tmp WHERE NOT EXISTS ( SELECT query FROM `" . DB_PREFIX . "url_alias` WHERE query = 'account/sbacquiring/callback') LIMIT 1;");
    }

  public function status() {
  	$this->load->language('payment/sbacquiringpro');
	$this->document->setTitle ($this->language->get('heading_title'));
    $this->data['heading_title'] = $this->language->get('heading_title');
    $this->data['status_title'] = $this->language->get('status_title');

    $this->data['yandex_id'] = $this->language->get('yandex_id');
    $this->data['num_order'] = $this->language->get('num_order');
    $this->data['sum'] = $this->language->get('sum');
    $this->data['user'] = $this->language->get('user');
    $this->data['email'] = $this->language->get('email');
    $this->data['date_created'] = $this->language->get('date_created');
    $this->data['date_enroled'] = $this->language->get('date_enroled');
    $this->data['sender'] = $this->language->get('sender');

    $this->load->model('payment/sbacquiring');
    $viewstatuses = $this->model_payment_sbacquiring->getStatus();
    $this->data['viewstatuses'] = $viewstatuses;

    $this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_order'),
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'payment/sbacquiring_view_status.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}

  	private function validate(){
		if (!$this->user->hasPermission('modify', 'payment/sbacquiring2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['sbacquiring2_userName']) {
			$this->error['userName'] = $this->language->get('error_userName');
		}

		if (!$this->request->post['sbacquiring2_password']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['sbacquiring2_password']) {
			$this->load->model('payment/sbacquiring2');
			$keyz = $this->config->get('config_encryption');
			if ($this->request->post['sbacquiring2_password'] == '**********'){$this->request->post['sbacquiring2_password'] = $this->model_payment_sbacquiring2->decrypt($this->config->get('sbacquiring2_password'), $keyz);}
			$this->request->post['sbacquiring2_password'] = $this->model_payment_sbacquiring2->encrypt($this->request->post['sbacquiring2_password'], $keyz);
  		}

  		if ($this->request->post['sbacquiring2_fixen']) {
			if (!$this->request->post['sbacquiring2_fixen_amount']) {
				$this->error['fixen'] = $this->language->get('error_fixen');
			}
		}

		if ($this->request->post['sbacquiring2_servadr'] == 'self') {
			if (!$this->request->post['sbacquiring2_servadr_self']) {
				$this->error['self'] = $this->language->get('error_self');
			}
		}

		if ($this->request->post['sbacquiring2_bankcurrency']) {
			if (!$this->request->post['sbacquiring2_bankcurrency_self']) {
				$this->error['currency_self'] = $this->language->get('error_currency_self');
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
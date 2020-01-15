<?php

class ControllerAccountCopyData extends Controller
{
    public function index() {

        $json = array();

        $count = 0;

        $simple_custom_data = $this->db->query("SELECT * FROM `simple_custom_data` WHERE `data` <> 'a:0:{}' ORDER BY object_id");

        if ($simple_custom_data->num_rows) {
            foreach ($simple_custom_data->rows as $custom_data) {
                $object_id = $custom_data['object_id'];
                $object_type = $custom_data['object_type'];

                $data = unserialize($custom_data['data']);

                if (!empty($data) && count($data) > 1) {
                    if (!empty($data['custom_customer_type']) && ($data['custom_customer_type']['value'] != 'individual')) {
                        if (isset($data['custom_inn']) && isset($data['custom_legal_inn']) && $data['custom_inn']['value'] != '' && $data['custom_legal_inn']['value'] == '') {
                            $data['custom_legal_inn']['value'] = $data['custom_inn']['value'];
                            $data['custom_legal_inn']['text'] = $data['custom_inn']['text'];
                        }
                        if (isset($data['custom_bank_bic']) && isset($data['custom_legal_bank_bic']) && $data['custom_bank_bic']['value'] != '' && $data['custom_legal_bank_bic']['value'] == '') {
                            $data['custom_legal_bank_bic']['value'] = $data['custom_bank_bic']['value'];
                            $data['custom_legal_bank_bic']['text'] = $data['custom_bank_bic']['text'];
                        }
                        if (isset($data['custom_checking_account']) && isset($data['custom_legal_checking_account']) && $data['custom_checking_account']['value'] != '' && $data['custom_legal_checking_account']['value'] == '') {
                            $data['custom_legal_checking_account']['value'] = $data['custom_checking_account']['value'];
                            $data['custom_legal_checking_account']['text'] = $data['custom_checking_account']['text'];
                        }
                        if (isset($data['custom_law_address']) && isset($data['custom_legal_address']) && $data['custom_law_address']['value'] != '' && $data['custom_legal_address']['value'] == '') {
                            $data['custom_legal_address']['value'] = $data['custom_law_address']['value'];
                            $data['custom_legal_address']['text'] = $data['custom_law_address']['text'];
                        }
                        if (isset($data['custom_company']) && isset($data['custom_legal_company']) && $data['custom_company']['value'] != '' && $data['custom_legal_company']['value'] == '') {
                            $data['custom_legal_company']['value'] = $data['custom_company']['value'];
                            $data['custom_legal_company']['text'] = $data['custom_company']['text'];
                        }
                        if (isset($data['custom_kpp']) && isset($data['custom_legal_kpp']) && $data['custom_kpp']['value'] != '' && $data['custom_legal_kpp']['value'] == '') {
                            $data['custom_legal_kpp']['value'] = $data['custom_kpp']['value'];
                            $data['custom_legal_kpp']['text'] = $data['custom_kpp']['text'];
                        }
                        if (isset($data['custom_bank_name']) && isset($data['custom_legal_bank_name']) && $data['custom_bank_name']['value'] != '' && $data['custom_legal_bank_name']['value'] == '') {
                            $data['custom_legal_bank_name']['value'] = $data['custom_bank_name']['value'];
                            $data['custom_legal_bank_name']['text'] = $data['custom_bank_name']['text'];
                        }
                        if (isset($data['custom_cor_account']) && isset($data['custom_legal_cor_account']) && $data['custom_cor_account']['value'] != '' && $data['custom_legal_cor_account']['value'] == '') {
                            $data['custom_legal_cor_account']['value'] = $data['custom_cor_account']['value'];
                            $data['custom_legal_cor_account']['text'] = $data['custom_cor_account']['text'];
                        }

                        $new_data = serialize($data);

                        $this->db->query("UPDATE `simple_custom_data` SET `data` = '" . $new_data . "' WHERE object_type = '" . $object_type . "' AND object_id = '" . (int)$object_id . "'");

                        $count++;
                    }
                }
            }
        }

        $json['success'] = $count;

        $this->response->setOutput(json_encode($json));
    }
}

?>
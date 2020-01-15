<?php

class ModelPaymentsbacquiring2 extends Model
{
    public function getMethod($address, $total) {
        $this->load->language('payment/sbacquiring2');
        if ($total > 0) {
            $status = true;
            if ($this->config->get('sbacquiring2_status')) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('sbacquiring2_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
                if (!$this->config->get('sbacquiring2_geo_zone_id')) {
                    $status = true;
                    if ($this->config->get('sbacquiring2_minpay')) {
                        if ($this->currency->format($total, $this->config->get('sbacquiring2_currency'), $this->currency->getValue($this->config->get('sbacquiring2_currency')), false) <= $this->config->get('sbacquiring2_minpay')) {
                            $status = false;
                        }
                    }
                    if ($this->config->get('sbacquiring2_maxpay')) {
                        if ($this->currency->format($total, $this->config->get('sbacquiring2_currency'), $this->currency->getValue($this->config->get('sbacquiring2_currency')), false) >= $this->config->get('sbacquiring2_maxpay')) {
                            $status = false;
                        }
                    }
                } elseif ($query->num_rows) {
                    $status = true;
                    if ($this->config->get('sbacquiring2_minpay')) {
                        if ($this->currency->format($total, $this->config->get('sbacquiring2_currency'), $this->currency->getValue($this->config->get('sbacquiring2_currency')), false) <= $this->config->get('sbacquiring2_minpay')) {
                            $status = false;
                        }
                    }
                    if ($this->config->get('sbacquiring2_maxpay')) {
                        if ($this->currency->format($total, $this->config->get('sbacquiring2_currency'), $this->currency->getValue($this->config->get('sbacquiring2_currency')), false) >= $this->config->get('sbacquiring2_maxpay')) {
                            $status = false;
                        }
                    }
                } else {
                    $status = false;
                }
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        $method_data = array();
        if ($status) {
            if ($this->config->get('sbacquiring2_name_attach')) {
                $metname = htmlspecialchars_decode($this->config->get('sbacquiring2_name_' . $this->config->get('config_language_id')));
            } else {
                $metname = $this->language->get('text_title');
            }
            $method_data = array(
                'code'       => 'sbacquiring2',
                'title'      => $metname,
                'image'      => $this->language->get('image'),
                'sort_order' => $this->config->get('sbacquiring2_sort_order')
            );
        }

        return $method_data;
    }
}

?>
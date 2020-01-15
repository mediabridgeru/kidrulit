<?php
class ModelShippingCustomerGroup extends Model {
    public function getQuote($address) {
        $this->language->load('shipping/customer_group');

        $method_data = array();

        if (!$this->config->get('customer_group_status'))
        {
            return $method_data;
        }

        $modules = $this->config->get('customer_group_module');

        if (!$modules) {
            return $method_data;
        }

        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $cart_total = $this->cart->getTotal();

        $quote_data = array();

        foreach ($modules as $index => $module) {

            if (!$module['status']) {
                continue;
            }

            if ((int)$module['customer_group_id'] != $customer_group_id) {
                continue;
            }

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$module['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

            if (!$module['geo_zone_id']) {
                $status = true;
            } elseif ($query->num_rows) {
                $status = true;
            } else {
                $status = false;
            }

            if ($status) {
                $cost = 0;

                $rates = explode(',', $module['rate']);
                foreach ($rates as $rate) {
                    $data = explode(':', $rate);

                    if ($cart_total >= $data[0]) {
                        if (isset($data[1])) {
                            $cost = $data[1];
                        }
                    }
                }

                $quote_data['customer_group' . $index] = array(
                    'code'         => 'customer_group.customer_group' . $index,
                    'title'        => $module['name'],
                    'cost'         => $cost,
                    'tax_class_id' => $module['tax_class_id'],
                    'text'         => $this->currency->format($this->tax->calculate($cost, $module['tax_class_id'], $this->config->get('config_tax')))
                );
            }
        }

        if ($quote_data) {
            $method_data = array(
                'code'       => 'customer_group',
                'title'      => $this->config->get('customer_group_title'),
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('customer_group_sort_order'),
                'error'      => false
            );
        }

        return $method_data;
    }
}
?>
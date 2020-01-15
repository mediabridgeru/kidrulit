<?php
class Myocpod
{
    private $pods                 = array();
    private $customer_id_discount = array(); // added

    public function __construct($registry) {

        $this->db = $registry->get('db');
        $this->config = $registry->get('config');
        $this->customer = $registry->get('customer');
        $this->session = $registry->get('session');
        $this->tax = $registry->get('tax');
        $this->currency = $registry->get('currency');
        $this->cache = $registry->get('cache');

        $extension_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE type = 'module' AND code = 'myocpod'");

        if ($extension_query->num_rows) {
            if ($this->customer->isLogged()) {
                $customer_group_id = $this->customer->getCustomerGroupId();
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }

            $this->pods = $this->cache->get('myoc.pods.' . $customer_group_id);

            if (!$this->pods) {
                $pod_setting_query = $this->db->query("SELECT pods.*,po.product_id FROM " . DB_PREFIX . "myoc_pod_setting pods LEFT JOIN " . DB_PREFIX . "product_option po ON (po.product_option_id = pods.product_option_id)");

                if ($pod_setting_query->num_rows) {
                    foreach ($pod_setting_query->rows as $pod_setting) {
                        if (!isset($this->pods[$pod_setting['product_option_id']])) {
                            $this->pods[$pod_setting['product_option_id']] = array(
                                'show_price_product' => $pod_setting['show_price_product'],
                                'show_price_cart'    => $pod_setting['show_price_cart'],
                                'show_final'         => $pod_setting['show_final'],
                                'table_style'        => $pod_setting['table_style'],
                                'price_format'       => $pod_setting['price_format'],
                                'qty_column'         => $pod_setting['qty_column'],
                                'qty_format'         => $pod_setting['qty_format'],
                                'stock_column'       => $pod_setting['stock_column'],
                                'qty_cart'           => $pod_setting['qty_cart'],
                                'flat_rate'          => $pod_setting['flat_rate'],
                                'cart_discount'      => $pod_setting['cart_discount'],
                                'inc_tax'            => $pod_setting['inc_tax'],
                                'product_id'         => $pod_setting['product_id'],
                                'quantities'         => array(),
                                'pods'               => array(),
                            );
                        }

                        $pod_query = $this->db->query("SELECT pod.* FROM " . DB_PREFIX . "myoc_pod pod LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_option_value_id = pod.product_option_value_id) WHERE pov.product_option_id = '" . (int)$pod_setting['product_option_id'] . "' ORDER BY pod.priority, pod.quantity");

                        if ($pod_query->num_rows) {
                            foreach ($pod_query->rows as $pod) {
                                $pod['customer_group_ids'] = unserialize($pod['customer_group_ids']);
                                $customer_ids = unserialize($pod['customer_ids']); // added

                                if (in_array($customer_group_id, $pod['customer_group_ids'])) {

                                    if (!isset($this->pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
                                        $this->pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = array();
                                    }

                                    $this->pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
                                    $this->pods[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
                                }
                            // adeed
                                if (!empty($customer_ids) && in_array($this->customer->isLogged(), $customer_ids)) {

                                    if (!isset($this->customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
                                        $this->customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = array();
                                    }
                                    $this->customer_id_discount[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$pod['quantity']] = $pod;
                                    $this->customer_id_discount[$pod_setting['product_option_id']]['quantities'][$pod['quantity']] = $pod['quantity'];
                                }
                            }
                            // added
                            if ($this->customer_id_discount) {
                                $this->pods = array_replace_recursive($this->pods, $this->customer_id_discount);
                            }
                        }
                    }
                }

                $this->cache->set('myoc.pods.' . $customer_group_id, $this->pods);
            }
        }
    }

    public function getPod($product_option_id) {
        if (!empty($this->pods) && isset($this->pods[$product_option_id])) {
            return $this->pods[$product_option_id];
        }

        return false;
    }

    public function setPods($pods) {
        $this->pods = $pods;

        return $this;
    }

    public function showPod($product_option_id) {
        if ($this->getPod($product_option_id) && (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price'))) {
            return $this->pods[$product_option_id]['show_price_product'];
        }

        return false;
    }

    public function isQtyCart($product_id) {
        $po_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
        if ($po_query->num_rows) {
            foreach ($po_query->rows as $product_option) {
                if ($this->getPod($product_option['product_option_id'])) {
                    if ($this->pods[$product_option['product_option_id']]['qty_cart']) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function getCartOptionCount($product_id) {
        $pod_count = array();
        if (isset($this->session->data['cart'])) {
            foreach ($this->session->data['cart'] as $key => $quantity) {
                $cart_product = explode(':', $key);
                $cart_product_id = $cart_product[0];

                if ($cart_product_id == $product_id) {
                    if (!empty($cart_product[1])) {
                        $options = unserialize(base64_decode($cart_product[1]));
                    } else {
                        $options = array();
                    }

                    foreach ($options as $product_option_id => $value) {
                        $option_query = $this->db->query("SELECT o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "'");

                        if ($option_query->num_rows && isset($this->pods[$product_option_id]) && $this->pods[$product_option_id]['cart_discount']) {
                            if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image' || $option_query->row['type'] == 'multiple') {
                                $option_value_query = $this->db->query("SELECT pov.option_value_id FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "'");

                                if ($option_value_query->num_rows) {
                                    if (!isset($pod_count[$value])) {
                                        $pod_count[$value] = $quantity;
                                    } else {
                                        $pod_count[$value] += $quantity;
                                    }
                                }
                            } elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
                                foreach ($value as $product_option_value_id) {
                                    $option_value_query = $this->db->query("SELECT pov.option_value_id FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "'");

                                    if ($option_value_query->num_rows) {
                                        if (!isset($pod_count[$product_option_value_id])) {
                                            $pod_count[$product_option_value_id] = $quantity;
                                        } else {
                                            $pod_count[$product_option_value_id] += $quantity;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $pod_count;
    }

    public function getOptionData($option_data, $product_base_price, $qty) {
        foreach ($option_data as $option_id => $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $option_data[$option_id] = array_merge($option, $this->getOptionValueDiscount($option['product_option_value_id'], $product_base_price, $qty));
                if ($this->getPod($option_data[$option_id]['product_option_id']) && !$this->pods[$option_data[$option_id]['product_option_id']]['show_price_cart']) {
                    $option_data[$option_id]['price'] = false;
                }
            }
        }

        return $option_data;
    }

    public function getOptionPrice($option_data, $product_base_price, $qty, $special = true) {
        $option_price = 0;
        foreach ($option_data as $option_id => $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $pod = $this->getOptionValueDiscount($option['product_option_value_id'], $product_base_price, $qty);
                if ($pod['special'] !== false && $special) {
                    if ($pod['special_prefix'] == '+') {
                        $option_price += $pod['special'];
                    } elseif ($pod['special_prefix'] == '-') {
                        $option_price -= $pod['special'];
                    }
                } else {
                    if ($pod['price_prefix'] == '+') {
                        $option_price += $pod['price'];
                    } elseif ($pod['price_prefix'] == '-') {
                        $option_price -= $pod['price'];
                    }
                }
            }
        }

        return $option_price;
    }

    public function getOptionPoints($option_data, $product_base_price, $qty) {
        $option_points = 0;
        foreach ($option_data as $option_id => $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $pod = $this->getOptionValueDiscount($option['product_option_value_id'], $product_base_price, $qty);
                if ($pod['points_prefix'] == '+') {
                    $option_points += $pod['points'];
                } elseif ($pod['points_prefix'] == '-') {
                    $option_points -= $pod['points'];
                }
            }
        }

        return $option_points;
    }

    public function getOptionWeight($option_data, $product_base_price, $qty) {
        $option_weight = 0;
        foreach ($option_data as $option_id => $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $pod = $this->getOptionValueDiscount($option['product_option_value_id'], $product_base_price, $qty);
                if ($pod['weight_prefix'] == '+') {
                    $option_weight += $pod['weight'];
                } elseif ($pod['weight_prefix'] == '-') {
                    $option_weight -= $pod['weight'];
                }
            }
        }

        return $option_weight;
    }

    private function getOptionValueDiscount($product_option_value_id, $product_base_price, $qty) {
        $pov_query = $this->db->query("SELECT pov.*,pods.* FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "myoc_pod_setting pods ON (pov.product_option_id = pods.product_option_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "'");

        $option_value = array(
            'price'          => $pov_query->row['price'],
            'price_prefix'   => $pov_query->row['price_prefix'],
            'special'        => false,
            'special_prefix' => false,
            'points'         => $pov_query->row['points'],
            'points_prefix'  => $pov_query->row['points_prefix'],
            'weight'         => $pov_query->row['weight'],
            'weight_prefix'  => $pov_query->row['weight_prefix'],
            'qty_cart'       => $pov_query->row['qty_cart'],
        );

        $pod_cart_count = $this->getCartOptionCount($pov_query->row['product_id']);

        $pods = $this->getPod($pov_query->row['product_option_id']);

        if ($pods && isset($pods['pods'][$product_option_value_id])) {
            rsort($pods['quantities']);
            foreach ($pods['quantities'] as $quantity) {
                if ($quantity <= (isset($pod_cart_count[$product_option_value_id]) ? $pod_cart_count[$product_option_value_id] : $qty) && isset($pods['pods'][$product_option_value_id][$quantity])) {
                    $pod = $pods['pods'][$product_option_value_id][$quantity];

                    $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p WHERE p.product_id = '" . (int)$pov_query->row['product_id'] . "' AND p.date_available <= NOW() AND p.status = '1'");

                    $product_base_points = $product_query->row['points'];

                    if ($pod['calc_method'] == 'o' || $pod['calc_method'] == 'po') {
                        $option_base_price = $option_value['price'];
                        if ($option_value['price_prefix'] == '-') {
                            $option_base_price *= -1;
                        }
                    } else {
                        $option_base_price = 0;
                    }

                    if ($pod['option_base_points']) {
                        $option_base_points = $option_value['points'];
                        if ($option_value['points_prefix'] == '-') {
                            $option_base_points *= -1;
                        }
                    } else {
                        $option_base_points = 0;
                    }

                    switch ($pod['price_prefix']) {
                        case '+':
                            $pod['price'] = $option_base_price + $pod['price'];
                            break;
                        case '-':
                            $pod['price'] = $option_base_price - $pod['price'];
                            break;
                        case '=':
                            if ($pods['flat_rate']) {
                                $pod['price'] -= ($product_base_price * $qty);
                            } else {
                                $pod['price'] -= $product_base_price;
                            }
                            break;
                        case '+%':
                            switch ($pod['calc_method']) {
                                case 'p':
                                    $pod['price'] = ($product_base_price * $pod['price'] / 100);
                                    break;
                                case 'po':
                                    $pod['price'] = $option_base_price + ($product_base_price + $option_base_price) * $pod['price'] / 100;
                                    break;
                                default: //o
                                    $pod['price'] = $option_base_price + ($option_base_price * $pod['price'] / 100);
                                    break;
                            }
                            break;
                        case '-%':
                            switch ($pod['calc_method']) {
                                case 'p':
                                    $pod['price'] = ($product_base_price * -$pod['price'] / 100);
                                    break;
                                case 'po':
                                    $pod['price'] = $option_base_price + ($product_base_price + $option_base_price) * -$pod['price'] / 100;
                                    break;
                                default: //o
                                    $pod['price'] = $option_base_price - ($option_base_price * $pod['price'] / 100);
                                    break;
                            }
                            break;
                        default:
                            $pod['price'] = $option_base_price + $pod['price'];
                            break;
                    }

                    switch ($pod['special_prefix']) {
                        case '+':
                            $pod['special'] = $option_base_price + $pod['special'];
                            break;
                        case '-':
                            if ((float)$pod['special'] == 0) {
                                $pod['special'] = false;
                            } else {
                                $pod['special'] = $option_base_price - $pod['special'];
                            }
                            break;
                        case '=':
                            if ($pods['flat_rate']) {
                                $pod['special'] -= ($product_base_price * $qty);
                            } else {
                                $pod['special'] -= $product_base_price;
                            }
                            break;
                        case '+%':
                            switch ($pod['calc_method']) {
                                case 'p':
                                    $pod['special'] = ($product_base_price * $pod['special'] / 100);
                                    break;
                                case 'po':
                                    $pod['special'] = $option_base_price + ($product_base_price + $option_base_price) * $pod['special'] / 100;
                                    break;
                                default: //o
                                    $pod['special'] = $option_base_price + ($option_base_price * $pod['special'] / 100);
                                    break;
                            }
                            break;
                        case '-%':
                            switch ($pod['calc_method']) {
                                case 'p':
                                    $pod['special'] = ($product_base_price * -$pod['special'] / 100);
                                    break;
                                case 'po':
                                    $pod['special'] = $option_base_price + ($product_base_price + $option_base_price) * -$pod['special'] / 100;
                                    break;
                                default: //o
                                    $pod['special'] = $option_base_price - ($option_base_price * $pod['special'] / 100);
                                    break;
                            }
                            break;
                        default:
                            $pod['special'] = $option_base_price + $pod['special'];
                            break;
                    }

                    switch ($pod['points_prefix']) {
                        case '+':
                            $pod['points'] = $option_base_points + $pod['points'];
                            break;
                        case '-':
                            $pod['points'] = $option_base_points - $pod['points'];
                            break;
                        case '=':
                            if ($pods['flat_rate']) {
                                $pod['points'] -= ($product_base_points * $qty);
                            } else {
                                $pod['points'] -= $product_base_points;
                            }
                            break;
                        case '+%':
                            if ($option_base_points) {
                                $pod['points'] = $option_base_points + ($option_base_points * $pod['points'] / 100);
                            } else {
                                $pod['points'] = ($product_base_points * $pod['points'] / 100);
                            }
                            break;
                        case '-%':
                            if ($option_base_points) {
                                $pod['points'] = $option_base_points - ($option_base_points * $pod['points'] / 100);
                            } else {
                                $pod['points'] = ($product_base_points * -$pod['points'] / 100);
                            }
                            break;
                        default:
                            $pod['points'] = $option_base_points + $pod['points'];
                            break;
                    }

                    if ($pods['flat_rate']) {
                        $pod['price'] /= $qty;
                        $pod['special'] = $pod['special'] === false ? false : $pod['special'] / $qty;
                        $pod['points'] /= $qty;
                        $option_value['weight'] /= $qty;
                    }

                    $option_value['price_prefix'] = (float)$pod['price'] < 0 ? '-' : '+';
                    $option_value['price'] = abs($pod['price']);
                    if ($pod['special'] !== false && ($pod['date_start'] == '0000-00-00' || $pod['date_start'] < date('Y-m-d')) && ($pod['date_end'] == '0000-00-00' || $pod['date_end'] > date('Y-m-d'))) {
                        $option_value['special_prefix'] = (float)$pod['special'] < 0 ? '-' : '+';
                        $option_value['special'] = abs($pod['special']);
                    }
                    $option_value['points_prefix'] = (float)$pod['points'] < 0 ? '-' : '+';
                    $option_value['points'] = abs($pod['points']);

                    return $option_value;
                }
            }
        }
        if ($pov_query->row['flat_rate']) {
            $option_value['price'] /= $qty;
            $option_value['points'] /= $qty;
            $option_value['weight'] /= $qty;
        }

        return $option_value;
    }
}
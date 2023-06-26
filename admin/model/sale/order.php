<?php
class ModelSaleOrder extends Model
{
    /**
     * @param $order_id
     * @param $order_product
     */
    public function changeOrderProductQuantity($order_id, $order_product) {
        $product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product` WHERE product_id = '" . (int)$order_product['product_id'] . "'");
        $upc_more = (int)$product_query->row['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
        $product_model = $product_query->row['model'];

        $subtracted_product_quantity = $subtracted_option_quantity = (int)$order_product['quantity']; // количество товаров, которое списано у всей группы
        $order_subtracted_products = []; // массив товаров, у которых списано количество

        $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

        if ($upc_more) {
            $group_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p WHERE p.model = '" . $product_model . "' AND p.upc_quantity > 0 ORDER BY p.upc, p.date_added");

            if ($order_option_query->num_rows) {
                foreach ($order_option_query->rows as $option) {
                    $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$option['product_option_value_id'] . "'");

                    if ($product_option_value_query->num_rows) {
                        $ob_sku = $product_option_value_query->row['ob_sku'];

                        $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = pov.product_id) WHERE pov.ob_sku = '" . $ob_sku . "' AND pov.ob_quantity > 0 ORDER BY pov.ob_upc, p.date_added");

                        if ($product_option_value_query->num_rows) {
                            foreach ($product_option_value_query->rows as $product_option_value) {
                                if ($subtracted_option_quantity) {
                                    if ($subtracted_option_quantity < (int)$product_option_value['ob_quantity']) {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity - " . $subtracted_option_quantity . ") WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                                        $order_subtracted_products[$product_option_value['product_id']] = (int)$subtracted_option_quantity;
                                        $subtracted_option_quantity = 0;
                                    } else {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = 0 WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                                        $order_subtracted_products[$product_option_value['product_id']] = (int)$product_option_value['ob_quantity'];
                                        $subtracted_option_quantity -= (int)$product_option_value['ob_quantity'];
                                    }
                                }
                            }

                            $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE ob_sku = '" . $ob_sku . "'");
                        }
                    }
                }

                if ($group_product_query->num_rows) {
                    foreach ($group_product_query->rows as $product) {
                        if ($subtracted_product_quantity) {
                            if ($subtracted_product_quantity < (int)$product['upc_quantity']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity - " . $subtracted_product_quantity . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                $subtracted_product_quantity = 0;
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = 0 WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                $subtracted_product_quantity -= (int)$product['upc_quantity'];
                            }
                        }
                    }

                    $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE model = '" . $product_model . "'");

                    if (!empty($order_subtracted_products)) {
                        $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '" . $this->db->escape(serialize($order_subtracted_products)) . "' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                    }
                }
            } else {
                if ($group_product_query->num_rows) {
                    foreach ($group_product_query->rows as $product) {
                        if ($subtracted_product_quantity) {
                            if ($subtracted_product_quantity < (int)$product['upc_quantity']) {
                                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity - " . $subtracted_product_quantity . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                $order_subtracted_products[$product['product_id']] = (int)$subtracted_product_quantity;
                                $subtracted_product_quantity = 0;
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = 0 WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                $subtracted_product_quantity -= (int)$product['upc_quantity'];
                                $order_subtracted_products[$product['product_id']] = (int)$product['upc_quantity'];
                            }
                        }
                    }

                    $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE model = '" . $product_model . "'");

                    if (!empty($order_subtracted_products)) {
                        $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '" . $this->db->escape(serialize($order_subtracted_products)) . "' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                    }
                }
            }
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . "), upc_quantity = (upc_quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

            if ($order_option_query->num_rows) {
                foreach ($order_option_query->rows as $option) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . "), ob_quantity = (ob_quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
                }
            }
        }
    }

    public function addOrder($data) {
		$this->load->model('setting/store');

		$store_info = $this->model_setting_store->getStore($data['store_id']);

		if ($store_info) {
			$store_name = $store_info['name'];
			$store_url = $store_info['url'];
		} else {
			$store_name = $this->config->get('config_name');
			$store_url = HTTP_CATALOG;
		}

		$this->load->model('setting/setting');

		$setting_info = $this->model_setting_setting->getSetting('setting', $data['store_id']);

		if (isset($setting_info['invoice_prefix'])) {
			$invoice_prefix = $setting_info['invoice_prefix'];
		} else {
			$invoice_prefix = $this->config->get('config_invoice_prefix');
		}

		$this->load->model('localisation/country');

		$this->load->model('localisation/zone');

		$country_info = $this->model_localisation_country->getCountry($data['shipping_country_id']);

		if ($country_info) {
			$shipping_country = $country_info['name'];
			$shipping_address_format = $country_info['address_format'];
		} else {
			$shipping_country = '';	
			$shipping_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}	

		$zone_info = $this->model_localisation_zone->getZone($data['shipping_zone_id']);

		if ($zone_info) {
			$shipping_zone = $zone_info['name'];
		} else {
			$shipping_zone = '';			
		}	

		$country_info = $this->model_localisation_country->getCountry($data['payment_country_id']);

		if ($country_info) {
			$payment_country = $country_info['name'];
			$payment_address_format = $country_info['address_format'];			
		} else {
			$payment_country = '';	
			$payment_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';					
		}

		$zone_info = $this->model_localisation_zone->getZone($data['payment_zone_id']);

		if ($zone_info) {
			$payment_zone = $zone_info['name'];
		} else {
			$payment_zone = '';			
		}	

		$this->load->model('localisation/currency');

		$currency_info = $this->model_localisation_currency->getCurrencyByCode($this->config->get('config_currency'));

		if ($currency_info) {
			$currency_id = $currency_info['currency_id'];
			$currency_code = $currency_info['code'];
			$currency_value = $currency_info['value'];
		} else {
			$currency_id = 0;
			$currency_code = $this->config->get('config_currency');
			$currency_value = 1.00000;			
		}

        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($invoice_prefix) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($store_name) . "',store_url = '" . $this->db->escape($store_url) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($payment_country) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($payment_zone) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($payment_address_format) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($shipping_country) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($shipping_zone) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($shipping_address_format) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', cdek  = '" . (int)$data['shipping_cdek_cost'] . "', order_status_id = '" . (int)$data['order_status_id'] . "', affiliate_id  = '" . (int)$data['affiliate_id'] . "', language_id = '" . (int)$this->config->get('config_language_id') . "', currency_id = '" . (int)$currency_id . "', currency_code = '" . $this->db->escape($currency_code) . "', currency_value = '" . (float)$currency_value . "', date_added = NOW(), date_modified = NOW()"); // added cdek

		$order_id = $this->db->getLastId();

		if (isset($data['order_product'])) {
			foreach ($data['order_product'] as $order_product) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$order_product['product_id'] . "', name = '" . $this->db->escape($order_product['name']) . "', model = '" . $this->db->escape($order_product['model']) . "', quantity = '" . (int)$order_product['quantity'] . "', price = '" . (float)$order_product['price'] . "', total = '" . (float)$order_product['total'] . "', tax = '" . (float)$order_product['tax'] . "', reward = '" . (int)$order_product['reward'] . "'");

                $order_product['order_product_id'] = $order_product_id = $this->db->getLastId();

                if (isset($order_product['order_option'])) {
                    foreach ($order_product['order_option'] as $order_option) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$order_option['product_option_id'] . "', product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "', name = '" . $this->db->escape($order_option['name']) . "', `value` = '" . $this->db->escape($order_option['value']) . "', `type` = '" . $this->db->escape($order_option['type']) . "'");
                    }
                }

                $this->changeOrderProductQuantity($order_id, $order_product);
			}
		}

		if (isset($data['order_voucher'])) {	
			foreach ($data['order_voucher'] as $order_voucher) {	
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', voucher_id = '" . (int)$order_voucher['voucher_id'] . "', description = '" . $this->db->escape($order_voucher['description']) . "', code = '" . $this->db->escape($order_voucher['code']) . "', from_name = '" . $this->db->escape($order_voucher['from_name']) . "', from_email = '" . $this->db->escape($order_voucher['from_email']) . "', to_name = '" . $this->db->escape($order_voucher['to_name']) . "', to_email = '" . $this->db->escape($order_voucher['to_email']) . "', voucher_theme_id = '" . (int)$order_voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($order_voucher['message']) . "', amount = '" . (float)$order_voucher['amount'] . "'");

				$this->db->query("UPDATE " . DB_PREFIX . "voucher SET order_id = '" . (int)$order_id . "' WHERE voucher_id = '" . (int)$order_voucher['voucher_id'] . "'");
			}
		}

		// Get the total
		$total = 0;

		if (isset($data['order_total'])) {		
			foreach ($data['order_total'] as $order_total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($order_total['code']) . "', title = '" . $this->db->escape($order_total['title']) . "', text = '" . $this->db->escape($order_total['text']) . "', `value` = '" . (float)$order_total['value'] . "', sort_order = '" . (int)$order_total['sort_order'] . "'");
			}

			$total += $order_total['value'];
		}

		// Affiliate
		$affiliate_id = 0;
		$commission = 0;

		if (!empty($data['affiliate_id'])) {
			$this->load->model('sale/affiliate');

			$affiliate_info = $this->model_sale_affiliate->getAffiliate($data['affiliate_id']);

			if ($affiliate_info) {
				$affiliate_id = $affiliate_info['affiliate_id']; 
				$commission = ($total / 100) * $affiliate_info['commission']; 
			}
		}

		// Update order total			 
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . (float)$total . "', affiliate_id = '" . (int)$affiliate_id . "', commission = '" . (float)$commission . "' WHERE order_id = '" . (int)$order_id . "'");

	}

	public function editOrder($order_id, $data) {

		$this->load->model('localisation/country');

		$this->load->model('localisation/zone');

		$country_info = $this->model_localisation_country->getCountry($data['shipping_country_id']);

		if ($country_info) {
			$shipping_country = $country_info['name'];
			$shipping_address_format = $country_info['address_format'];
		} else {
			$shipping_country = '';	
			$shipping_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}	

		$zone_info = $this->model_localisation_zone->getZone($data['shipping_zone_id']);

		if ($zone_info) {
			$shipping_zone = $zone_info['name'];
		} else {
			$shipping_zone = '';			
		}	

		$country_info = $this->model_localisation_country->getCountry($data['payment_country_id']);

		if ($country_info) {
			$payment_country = $country_info['name'];
			$payment_address_format = $country_info['address_format'];			
		} else {
			$payment_country = '';	
			$payment_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';					
		}

		$zone_info = $this->model_localisation_zone->getZone($data['payment_zone_id']);

		if ($zone_info) {
			$payment_zone = $zone_info['name'];
		} else {
			$payment_zone = '';			
		}

        $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE object_type = '2' AND object_id = '{$data['customer_id']}'")->row;

        if (isset($customer_custom['data'])) {
            $customer_custom = unserialize($customer_custom['data']);

            if (!empty($data['custom_warehouse_tasks'])) {
                $customer_custom['custom_warehouse_tasks']['value'] = $data['custom_warehouse_tasks'];
            } else {
                $customer_custom['custom_warehouse_tasks']['value'] = '';
            }
            if (!empty($data['custom_manager_tasks'])) {
                $customer_custom['custom_manager_tasks']['value'] = $data['custom_manager_tasks'];
            } else {
                $customer_custom['custom_manager_tasks']['value'] = '';
            }
            if (!empty($data['custom_special_comments'])) {
                $customer_custom['custom_special_comments']['value'] = $data['custom_special_comments'];
            } else {
                $customer_custom['custom_special_comments']['value'] = '';
            }

            $query = $this->db->query("UPDATE simple_custom_data SET data = '" . serialize($customer_custom) . "'
                                    WHERE object_type = '2' AND object_id = '" . (int)$data['customer_id'] . "'");
        }

        $order_status_id = 0; // старый статус заказа
        $cancel_status_id = 9; // статус Отмена и аннулирование
        $process_status_id = 2; // статус В обработке

        // Узнаём статус, который стоял до изменения
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");

        if ($order_status_query->num_rows) {
            $order_status_id = $order_status_query->row['order_status_id'];
        }

        // Restock products before subtracting the stock later on
        if (!($order_status_id == $cancel_status_id && $data['order_status_id'] == $process_status_id)) {
            $order_products_query = $this->db->query("SELECT op.order_product_id, op.product_id, p.upc_more, op.quantity, op.products, op.model AS model, p.model AS product_model FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id) WHERE order_id = '" . (int)$order_id . "'");

            if ($order_products_query->num_rows) {
                foreach ($order_products_query->rows as $order_product) {
                    $upc_more = (int)$order_product['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                    $order_subtracted_products = unserialize($order_product['products']); // массив товаров, у которых списано количество

                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                    if ($order_option_query->num_rows) {
                        foreach ($order_option_query->rows as $order_option) {
                            $product_option_id = $order_option['product_option_id'];
                            $product_option_value_id = $order_option['product_option_value_id'];

                            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND product_option_id = '" . (int)$product_option_id . "'");

                            if ($product_option_value_query->num_rows) {
                                $option_value_id = $product_option_value_query->row['option_value_id'];

                                if ($upc_more && !empty($order_subtracted_products)) {
                                    foreach ($order_subtracted_products as $product_id => $quantity) {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                    }

                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE ob_sku = '" . $order_product['model'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . "), ob_quantity = (ob_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                }
                            }
                        }
                    }

                    if ($upc_more && !empty($order_subtracted_products)) {
                        foreach ($order_subtracted_products as $product_id => $quantity) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "'");
                        }

                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE model = '" . $order_product['product_model'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . "), upc_quantity = (upc_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                    }
                }
            }
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($payment_country) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($payment_zone) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($payment_address_format) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "',  shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($shipping_country) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($shipping_zone) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($shipping_address_format) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', cdek  = '" . (int)$data['shipping_cdek_cost'] . "', order_status_id = '" . (int)$data['order_status_id'] . "', affiliate_id  = '" . (int)$data['affiliate_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");// added cdek

        $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");

        if (isset($data['order_product'])) {
            foreach ($data['order_product'] as $order_product) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_product_id = '" . (int)$order_product['order_product_id'] . "', order_id = '" . (int)$order_id . "', product_id = '" . (int)$order_product['product_id'] . "', name = '" . $this->db->escape($order_product['name']) . "', products = '" . $this->db->escape($order_product['products']) . "', model = '" . $this->db->escape($order_product['model']) . "', quantity = '" . (int)$order_product['quantity'] . "', price = '" . (float)$order_product['price'] . "', total = '" . (float)$order_product['total'] . "', tax = '" . (float)$order_product['tax'] . "', reward = '" . (int)$order_product['reward'] . "'");

                $order_product_id = $order_product['order_product_id'] = $this->db->getLastId();

                if (isset($order_product['order_option'])) {
                    foreach ($order_product['order_option'] as $oo => $order_option) {
                        if (!empty($order_option['order_option_id'])) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_option_id = '" . (int)$order_option['order_option_id'] . "', order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$order_option['product_option_id'] . "', product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "', name = '" . $this->db->escape($order_option['name']) . "', `value` = '" . $this->db->escape($order_option['value']) . "', `type` = '" . $this->db->escape($order_option['type']) . "'");
                        } else {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$order_option['product_option_id'] . "', product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "', name = '" . $this->db->escape($order_option['name']) . "', `value` = '" . $this->db->escape($order_option['value']) . "', `type` = '" . $this->db->escape($order_option['type']) . "'");

                            $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                            if ($order_option_query->num_rows) {
                                $order_product['order_option'][$oo]['order_product_id'] = $order_product_id;
                                $order_product['order_option'][$oo]['order_option_id'] = $order_option_query->row['order_option_id'];
                            }
                        }
                    }
                }

                if (isset($order_product['order_download'])) {
                    foreach ($order_product['order_download'] as $order_download) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_download SET order_download_id = '" . (int)$order_download['order_download_id'] . "', order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', name = '" . $this->db->escape($order_download['name']) . "', filename = '" . $this->db->escape($order_download['filename']) . "', mask = '" . $this->db->escape($order_download['mask']) . "', remaining = '" . (int)$order_download['remaining'] . "'");
                    }
                }

                if (!($order_status_id != $cancel_status_id && $data['order_status_id'] == $cancel_status_id)) {
                    $product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product` WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                    $upc_more = (int)$product_query->row['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                    $product_model = $product_query->row['model'];

                    $subtracted_product_quantity = $subtracted_option_quantity = (int)$order_product['quantity']; // количество товаров, которое списано у всей группы
                    $order_subtracted_products = []; // массив товаров, у которых списано количество

                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                    if ($upc_more) {
                        $group_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p WHERE p.model = '" . $product_model . "' AND p.upc_quantity > 0 ORDER BY p.upc, p.date_added");

                        if ($order_option_query->num_rows) {
                            foreach ($order_option_query->rows as $option) {
                                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$option['product_option_value_id'] . "'");

                                if ($product_option_value_query->num_rows) {
                                    $ob_sku = $product_option_value_query->row['ob_sku'];

                                    $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = pov.product_id) WHERE pov.ob_sku = '" . $ob_sku . "' AND pov.ob_quantity > 0 ORDER BY pov.ob_upc, p.date_added");

                                    if ($product_option_value_query->num_rows) {
                                        foreach ($product_option_value_query->rows as $product_option_value) {
                                            if ($subtracted_option_quantity) {
                                                if ($subtracted_option_quantity < (int)$product_option_value['ob_quantity']) {
                                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity - " . $subtracted_option_quantity . ") WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                                                    $order_subtracted_products[$product_option_value['product_id']] = (int)$subtracted_option_quantity;
                                                    $subtracted_option_quantity = 0;
                                                } else {
                                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = 0 WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                                                    $order_subtracted_products[$product_option_value['product_id']] = (int)$product_option_value['ob_quantity'];
                                                    $subtracted_option_quantity -= (int)$product_option_value['ob_quantity'];
                                                }
                                            }
                                        }

                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE ob_sku = '" . $ob_sku . "'");
                                    }
                                }
                            }

                            if ($group_product_query->num_rows) {
                                foreach ($group_product_query->rows as $product) {
                                    if ($subtracted_product_quantity) {
                                        if ($subtracted_product_quantity < (int)$product['upc_quantity']) {
                                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity - " . $subtracted_product_quantity . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                            $subtracted_product_quantity = 0;
                                        } else {
                                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = 0 WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                            $subtracted_product_quantity -= (int)$product['upc_quantity'];
                                        }
                                    }
                                }

                                $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE model = '" . $product_model . "'");

                                if (!empty($order_subtracted_products)) {
                                    $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '" . $this->db->escape(serialize($order_subtracted_products)) . "' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                                }
                            }
                        } else {
                            if ($group_product_query->num_rows) {
                                foreach ($group_product_query->rows as $product) {
                                    if ($subtracted_product_quantity) {
                                        if ($subtracted_product_quantity < (int)$product['upc_quantity']) {
                                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity - " . $subtracted_product_quantity . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                            $order_subtracted_products[$product['product_id']] = (int)$subtracted_product_quantity;
                                            $subtracted_product_quantity = 0;
                                        } else {
                                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = 0 WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");
                                            $subtracted_product_quantity -= (int)$product['upc_quantity'];
                                            $order_subtracted_products[$product['product_id']] = (int)$product['upc_quantity'];
                                        }
                                    }
                                }

                                $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE model = '" . $product_model . "'");

                                if (!empty($order_subtracted_products)) {
                                    $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '" . $this->db->escape(serialize($order_subtracted_products)) . "' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "order_product SET products = '' WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");
                                }
                            }
                        }
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . "), upc_quantity = (upc_quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

                        if ($order_option_query->num_rows) {
                            foreach ($order_option_query->rows as $option) {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . "), ob_quantity = (ob_quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
                            }
                        }
                    }
                }
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

        if (isset($data['order_voucher'])) {
            foreach ($data['order_voucher'] as $order_voucher) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_voucher_id = '" . (int)$order_voucher['order_voucher_id'] . "', order_id = '" . (int)$order_id . "', voucher_id = '" . (int)$order_voucher['voucher_id'] . "', description = '" . $this->db->escape($order_voucher['description']) . "', code = '" . $this->db->escape($order_voucher['code']) . "', from_name = '" . $this->db->escape($order_voucher['from_name']) . "', from_email = '" . $this->db->escape($order_voucher['from_email']) . "', to_name = '" . $this->db->escape($order_voucher['to_name']) . "', to_email = '" . $this->db->escape($order_voucher['to_email']) . "', voucher_theme_id = '" . (int)$order_voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($order_voucher['message']) . "', amount = '" . (float)$order_voucher['amount'] . "'");

                $this->db->query("UPDATE " . DB_PREFIX . "voucher SET order_id = '" . (int)$order_id . "' WHERE voucher_id = '" . (int)$order_voucher['voucher_id'] . "'");
            }
        }

        // Get the total
        $total = 0;

        $this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");

        if (isset($data['order_total'])) {
            foreach ($data['order_total'] as $order_total) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_total_id = '" . (int)$order_total['order_total_id'] . "', order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($order_total['code']) . "', title = '" . $this->db->escape($order_total['title']) . "', text = '" . $this->db->escape($order_total['text']) . "', `value` = '" . (float)$order_total['value'] . "', sort_order = '" . (int)$order_total['sort_order'] . "'");
            }

            $total += $order_total['value'];
        }

        // Affiliate
        $affiliate_id = 0;
        $commission = 0;

        if (!empty($data['affiliate_id'])) {
            $this->load->model('sale/affiliate');

            $affiliate_info = $this->model_sale_affiliate->getAffiliate($data['affiliate_id']);

            if ($affiliate_info) {
                $affiliate_id = $affiliate_info['affiliate_id'];
                $commission = ($total / 100) * $affiliate_info['commission'];
            }
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . (float)$total . "', affiliate_id = '" . (int)$affiliate_id . "', commission = '" . (float)$commission . "' WHERE order_id = '" . (int)$order_id . "'");
    }

    public function deleteOrder($order_id) {
        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");
        $row = $this->db->query("SELECT `order_status_id` FROM `" . DB_PREFIX . "order` WHERE `order_id` = " . (int)$order_id)->row;
        	
		if ($row['order_status_id'] !== '9') { // Не возвращать товары на склад при удалении заказа со статусом "Отмена и аннулирование"
            if ($order_query->num_rows) {
                $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

                foreach($product_query->rows as $product) {
                    $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

                    $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

                    foreach ($option_query->rows as $option) {
                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
                    }
                }
            }
        }

        $this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_fraud WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE `or`, ort FROM " . DB_PREFIX . "order_recurring `or`, " . DB_PREFIX . "order_recurring_transaction ort WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
    }

    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

        if ($order_query->num_rows) {
            $reward = 0;

            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

            foreach ($order_product_query->rows as $product) {
                $reward += $product['reward'];
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            if ($order_query->row['affiliate_id']) {
                $affiliate_id = $order_query->row['affiliate_id'];
            } else {
                $affiliate_id = 0;
            }

            $this->load->model('sale/affiliate');

            $affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);

            if ($affiliate_info) {
                $affiliate_firstname = $affiliate_info['firstname'];
                $affiliate_lastname = $affiliate_info['lastname'];
            } else {
                $affiliate_firstname = '';
                $affiliate_lastname = '';
            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];
                $language_filename = $language_info['filename'];
                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';
                $language_filename = '';
                $language_directory = '';
            }

            return array(
                'order_id'                => $order_query->row['order_id'],
                'invoice_no'              => $order_query->row['invoice_no'],
                'invoice_prefix'          => $order_query->row['invoice_prefix'],
                'store_id'                => $order_query->row['store_id'],
                'store_name'              => $order_query->row['store_name'],
                'store_url'               => $order_query->row['store_url'],
                'customer_id'             => $order_query->row['customer_id'],
                'customer'                => $order_query->row['customer'],
                'customer_group_id'       => $order_query->row['customer_group_id'],
                'firstname'               => $order_query->row['firstname'],
                'lastname'                => $order_query->row['lastname'],
                'telephone'               => $order_query->row['telephone'],
                'fax'                     => $order_query->row['fax'],
                'email'                   => $order_query->row['email'],
                'payment_firstname'       => $order_query->row['payment_firstname'],
                'payment_lastname'        => $order_query->row['payment_lastname'],
                'payment_company'         => $order_query->row['payment_company'],
                'payment_company_id'      => $order_query->row['payment_company_id'],
                'payment_tax_id'          => $order_query->row['payment_tax_id'],
                'payment_address_1'       => $order_query->row['payment_address_1'],
                'payment_address_2'       => $order_query->row['payment_address_2'],
                'payment_postcode'        => $order_query->row['payment_postcode'],
                'payment_city'            => $order_query->row['payment_city'],
                'payment_zone_id'         => $order_query->row['payment_zone_id'],
                'payment_zone'            => $order_query->row['payment_zone'],
                'payment_zone_code'       => $payment_zone_code,
                'payment_country_id'      => $order_query->row['payment_country_id'],
                'payment_country'         => $order_query->row['payment_country'],
                'payment_iso_code_2'      => $payment_iso_code_2,
                'payment_iso_code_3'      => $payment_iso_code_3,
                'payment_address_format'  => $order_query->row['payment_address_format'],
                'payment_method'          => $order_query->row['payment_method'],
                'payment_code'            => $order_query->row['payment_code'],
                'shipping_firstname'      => $order_query->row['shipping_firstname'],
                'shipping_lastname'       => $order_query->row['shipping_lastname'],
                'shipping_company'        => $order_query->row['shipping_company'],
                'shipping_address_1'      => $order_query->row['shipping_address_1'],
                'shipping_address_2'      => $order_query->row['shipping_address_2'],
                'shipping_postcode'       => $order_query->row['shipping_postcode'],
                'shipping_city'           => $order_query->row['shipping_city'],
                'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
                'shipping_zone'           => $order_query->row['shipping_zone'],
                'shipping_zone_code'      => $shipping_zone_code,
                'shipping_country_id'     => $order_query->row['shipping_country_id'],
                'shipping_country'        => $order_query->row['shipping_country'],
                'shipping_iso_code_2'     => $shipping_iso_code_2,
                'shipping_iso_code_3'     => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_method'         => $order_query->row['shipping_method'],
                'shipping_code'           => $order_query->row['shipping_code'],
                'shipping_pvz'            => $order_query->row['shipping_pvz'],
                'comment'                 => $order_query->row['comment'],
                'total'                   => $order_query->row['total'],
                'shipping_cdek_cost'      => $order_query->row['cdek'], // added
                'reward'                  => $reward,
                'order_status_id'         => $order_query->row['order_status_id'],
                'affiliate_id'            => $order_query->row['affiliate_id'],
                'affiliate_firstname'     => $affiliate_firstname,
                'affiliate_lastname'      => $affiliate_lastname,
                'commission'              => $order_query->row['commission'],
                'language_id'             => $order_query->row['language_id'],
                'language_code'           => $language_code,
                'language_filename'       => $language_filename,
                'language_directory'      => $language_directory,
                'currency_id'             => $order_query->row['currency_id'],
                'currency_code'           => $order_query->row['currency_code'],
                'currency_value'          => $order_query->row['currency_value'],
                'ip'                      => $order_query->row['ip'],
                'forwarded_ip'            => $order_query->row['forwarded_ip'],
                'user_agent'              => $order_query->row['user_agent'],
                'accept_language'         => $order_query->row['accept_language'],
                'date_added'              => $order_query->row['date_added'],
                'date_modified'           => $order_query->row['date_modified']
            );
        } else {
            return false;
        }
    }

    public function getOrders($data = array()) {
        $sql = "SELECT o.order_id, o.order_status_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, o.total, o.currency_code, o.customer_id, o.currency_value, o.cdek, o.shipping_code, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql .= " WHERE o.order_status_id > '0'";
        }

        if (!empty($data['filter_order_id'])) {
            $sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
        }

        if (!empty($data['filter_customer'])) {
            $sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
        }

        $sort_data = array(
            'o.order_id',
            'customer',
            'customer_id',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        $orders = [];

        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $row['tasks'] = $this->getOrderTasks($row['customer_id']);

                $orders[] = $row;
            }
        }

        return $orders;
    }

    public function getOrderTasks($customer_id) {
        $tasks = [];

        $custom_warehouse_tasks = ''; // Задачи склада
        $custom_manager_tasks = ''; // Задачи менеджеру
        $custom_special_comments = ''; // Особые комментарии

        $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE object_type = '2' AND object_id = '{$customer_id}'")->row;

        if (isset($customer_custom['data'])) {
            $customer_custom = unserialize($customer_custom['data']);

            if (!empty($customer_custom['custom_warehouse_tasks'])) {
                $custom_warehouse_tasks = $customer_custom['custom_warehouse_tasks']['value'];
            }

            if (!empty($customer_custom['custom_manager_tasks'])) {
                $custom_manager_tasks = $customer_custom['custom_manager_tasks']['value'];
            }

            if (!empty($customer_custom['custom_special_comments'])) {
                $custom_special_comments = $customer_custom['custom_special_comments']['value'];
            }
        }

        $tasks['custom_warehouse_tasks'] = $custom_warehouse_tasks;
        $tasks['custom_manager_tasks'] = $custom_manager_tasks;
        $tasks['custom_special_comments'] = $custom_special_comments;

        return $tasks;
    }

    public function getOrderProducts($order_id) {
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

        return $query->rows;
    }

    public function getProductImage($product_id) {
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

        if ($query->num_rows) {
            return $query->row['image'];
        } else {
            return 'no_image.jpg';
        }
    }

    public function getProducOptiontImage($product_option_value_id) {
        $query = $this->db->query("SELECT ob_image FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "'");

        if ($query->num_rows) {
            return $query->row['ob_image'];
        } else {
            return 'no_image.jpg';
        }
    }

    public function getReportName($product_id) {
        $query = $this->db->query("SELECT report_name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

        return $query->row['report_name'];
    }

    /**
     * @param $order_id
     * @param $new_status_id
     * @return bool
     */
    public function updateStatus($order_id, $new_status_id) {
        $order_status_id = 0; // старый статус заказа
        $cancel_status_id = 9; // статус Отмена и аннулирование
        $process_status_id = 2; // статус В обработке

        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_id = '" . (int)$order_id . "'");

        if ($order_status_query->num_rows) {
            $order_status_id = $order_status_query->row['order_status_id'];
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$new_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$new_status_id . "', notify = '1', date_added = NOW()");

        $order_info = $this->getOrder($order_id);

        if ($order_status_id != $cancel_status_id && $new_status_id == $cancel_status_id) { // если статус изменился с любого на Отмена и аннулирование
            $order_products_query = $this->db->query("SELECT op.order_product_id, op.product_id, p.upc_more, op.quantity, op.products, op.model AS model, p.model AS product_model FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id) WHERE order_id = '" . (int)$order_id . "'");

            if ($order_products_query->num_rows) {
                foreach ($order_products_query->rows as $order_product) {
                    $upc_more = (int)$order_product['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                    $order_subtracted_products = unserialize($order_product['products']); // массив товаров, у которых списано количество

                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                    if ($order_option_query->num_rows) {
                        foreach ($order_option_query->rows as $order_option) {
                            $product_option_id = $order_option['product_option_id'];
                            $product_option_value_id = $order_option['product_option_value_id'];

                            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND product_option_id = '" . (int)$product_option_id . "'");

                            if ($product_option_value_query->num_rows) {
                                $option_value_id = $product_option_value_query->row['option_value_id'];

                                if ($upc_more && !empty($order_subtracted_products)) {
                                    foreach ($order_subtracted_products as $product_id => $quantity) {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                    }

                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE ob_sku = '" . $order_product['model'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . "), ob_quantity = (ob_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                }
                            }
                        }
                    }

                    if ($upc_more && !empty($order_subtracted_products)) {
                        foreach ($order_subtracted_products as $product_id => $quantity) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "'");
                        }

                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE model = '" . $order_product['product_model'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . "), upc_quantity = (upc_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                    }
                }
            }
        } elseif ($order_status_id == $cancel_status_id && $new_status_id == $process_status_id) { // если статус изменился с Отмена и аннулирование на В обработке
            $order_products_query = $this->db->query("SELECT op.order_product_id, op.product_id, p.upc_more, op.quantity, op.products, op.model AS model, p.model AS product_model FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id) WHERE order_id = '" . (int)$order_id . "'");

            if ($order_products_query->num_rows) {
                foreach ($order_products_query->rows as $order_product) {
                    $upc_more = (int)$order_product['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                    $order_subtracted_products = unserialize($order_product['products']); // массив товаров, у которых списано количество

                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                    if ($order_option_query->num_rows) {
                        foreach ($order_option_query->rows as $order_option) {
                            $product_option_id = $order_option['product_option_id'];
                            $product_option_value_id = $order_option['product_option_value_id'];

                            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND product_option_id = '" . (int)$product_option_id . "'");

                            if ($product_option_value_query->num_rows) {
                                $option_value_id = $product_option_value_query->row['option_value_id'];

                                if ($upc_more && !empty($order_subtracted_products)) {
                                    foreach ($order_subtracted_products as $product_id => $quantity) {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity - " . $quantity . ") WHERE product_id = '" . (int)$product_id . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                    }

                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . $order_product['quantity'] . ") WHERE ob_sku = '" . $order_product['model'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . $order_product['quantity'] . "), ob_quantity = (ob_quantity - " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                }
                            }
                        }
                    }

                    if ($upc_more && !empty($order_subtracted_products)) {
                        foreach ($order_subtracted_products as $product_id => $quantity) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity - " . $quantity . ") WHERE product_id = '" . (int)$product_id . "'");
                        }

                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . $order_product['quantity'] . ") WHERE model = '" . $order_product['product_model'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . $order_product['quantity'] . "), upc_quantity = (upc_quantity - " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                    }
                }
            }
        }

        $language = new Language($order_info['language_directory']);
        $language->load($order_info['language_filename']);
        $language->load('mail/order');

        $subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_id);

        $message  = $language->get('text_order') . ' ' . $order_id . "\n";
        $message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$new_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

        if ($order_status_query->num_rows) {
            $message .= $language->get('text_order_status') . "\n";
            $message .= $order_status_query->row['name'] . "\n\n";
        }

        if ($order_info['customer_id']) {
            $message .= $language->get('text_link') . "\n";
            $message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";
        }

        $this->load->model('payment/sbacquiring');
        $sb_codes = $this->model_payment_sbacquiring->getPayMethods();

        if (!empty($sb_codes)) {
            $this->language->load('payment/sbacquiringpro');

            foreach ($sb_codes as $sbcode) {
                if ($this->config->get($sbcode . '_on_status_id') == (int)$new_status_id && $order_info['payment_code'] == $sbcode) {
                    $action = $order_info['store_url'] . 'index.php?route=account/sbacquiring';
                    $merchant_url = $action . '&order_id=' . $order_info['order_id'] . '&code=' . substr($this->model_payment_sbacquiring->encrypt($order_info['order_id'], $this->config->get('config_encryption')), 0, 8);

                    $merchant_url = "<a href=' " . $merchant_url . "'>" . $merchant_url . "</a>";
                    $this->language->load('payment/' . $sbcode);
                    $message .= $this->language->get('pay_text_mail') . "\n";
                    $message .= strip_tags(html_entity_decode($merchant_url, ENT_QUOTES, 'UTF-8')) . "\n\n";
                }
            }
        }

        $message .= $language->get('text_comment') . "\n\n";

        $message .= $language->get('text_footer');

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');
        $mail->setTo($order_info['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($order_info['store_name']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();

        return true;
    }

    public function getOrderOptionKod($order_id, $order_option_id) {
        $query = $this->db->query("SELECT ob_kod FROM " . DB_PREFIX . "order_option AS oo LEFT JOIN " . DB_PREFIX . "product_option_value pov ON pov.product_option_value_id = oo.product_option_value_id WHERE order_id = '" . (int)$order_id . "' AND order_option_id = '" . (int)$order_option_id . "'");

        return $query->row['ob_kod'];
    }

    public function getOrderOptionColor($order_id, $order_option_id) {
        $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_option AS oo WHERE order_id = '" . (int)$order_id . "' AND order_option_id = '" . (int)$order_option_id . "' AND name = 'Расцветки'");

        if ($query->num_rows) {
            return $query->row['value'];
        } else {
            return '';
        }
    }

    public function getProductAttributes($product_id) {
        $product_attribute_group_data = array();

        $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
            $product_attribute_data = array();

            $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

            foreach ($product_attribute_query->rows as $product_attribute) {
                $product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name'         => $product_attribute['name'],
                    'text'         => $product_attribute['text']
                );
            }

            $product_attribute_group_data[] = array(
                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
                'name'               => $product_attribute_group['name'],
                'attribute'          => $product_attribute_data
            );
        }

        return $product_attribute_group_data;
    }

    public function getOrderOption($order_id, $order_option_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_option_id = '" . (int)$order_option_id . "'");

        return $query->row;
    }

    /**
     * @param $order_product
     * @param $current_order_products
     * @return bool
     */
    public function getOrderOptionStock($order_product, $current_order_products) {
        $stock = true;
        $product_id = $order_product['product_id'];
        $quantity = (int)$order_product['quantity'];

        foreach ($order_product['order_option'] as $order_option) {
            $option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$order_option['product_option_id'] . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

            if ($option_query->num_rows) {
                if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
                    $option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) WHERE pov.product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' AND pov.product_option_id = '" . (int)$order_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                    if ($option_value_query->num_rows) {
                        $option_value_quantity = (int)$option_value_query->row['quantity'];

                        if (!empty($current_order_products[$product_id . ($option_value_query->row['ob_sku'] ?: '')])) {
                            $q = (int)$current_order_products[$product_id . ($option_value_query->row['ob_sku'] ?: '')]; // количество товара в корзине
                            if ($option_value_query->row['subtract'] && ($option_value_quantity  + $q < $quantity)) {
                                $stock = false;
                            }
                        } else {
                            if ($option_value_query->row['subtract'] && ($option_value_quantity < $quantity)) {
                                $stock = false;
                            }
                        }
                    }
                } elseif ($option_query->row['type'] == 'checkbox' && is_array($order_option)) {
                    foreach ($order_option as $order_option_value) {
                        $option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) WHERE pov.product_option_value_id = '" . (int)$order_option_value['product_option_value_id'] . "' AND pov.product_option_id = '" . (int)$order_option_value['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                        if ($option_value_query->num_rows) {
                            $option_value_quantity = (int)$option_value_query->row['quantity'];

                            if (!empty($current_order_products[$product_id . ($option_value_query->row['ob_sku'] ?: '')])) {
                                $q = (int)$current_order_products[$product_id . ($option_value_query->row['ob_sku'] ?: '')];
                                if ($option_value_query->row['subtract'] && ($option_value_quantity  + $q < $quantity)) {
                                    $stock = false;
                                }
                            } else {
                                if ($option_value_query->row['subtract'] && ($option_value_quantity < $quantity)) {
                                    $stock = false;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $stock;
    }

    public function getOrderOptions($order_id, $order_product_id) {
        $query = $this->db->query("SELECT oo.* FROM " . DB_PREFIX . "order_option AS oo LEFT JOIN " . DB_PREFIX . "product_option po USING(product_option_id) LEFT JOIN `" . DB_PREFIX . "option` o USING(option_id) WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' ORDER BY o.sort_order");

        return $query->rows;
    }

    public function getProductWeight($product_id) {
        $query = $this->db->query("SELECT weight, weight_class_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

        return $query->row['weight'];
    }

    public function getOrderDownloads($order_id, $order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

        return $query->rows;
    }

    public function getOrderVouchers($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

        return $query->rows;
    }

    public function getOrderVoucherByVoucherId($voucher_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

        return $query->row;
    }

    public function getOrderTotals($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

        return $query->rows;
    }

    public function getTotalOrders($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql .= " WHERE order_status_id > '0'";
        }

        if (!empty($data['filter_order_id'])) {
            $sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
        }

        if (!empty($data['filter_customer'])) {
            $sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND total = '" . (float)$data['filter_total'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalOrdersByStoreId($store_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

        return $query->row['total'];
    }

    public function getTotalOrdersByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByLanguageId($language_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByCurrencyId($currency_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalSales() {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalSalesByYear($year) {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . (int)$year . "'");

        return $query->row['total'];
    }

    public function createInvoiceNo($order_id) {
        $order_info = $this->getOrder($order_id);

        if ($order_info && !$order_info['invoice_no']) {
            $query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

            if ($query->row['invoice_no']) {
                $invoice_no = $query->row['invoice_no'] + 1;
            } else {
                $invoice_no = 1;
            }

            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

            return $order_info['invoice_prefix'] . $invoice_no;
        }
    }

    public function addOrderHistory($order_id, $data) {
        $order_status_id = '0'; // старый статус заказа
        $cancel_status_id = '9'; // статус Отмена и аннулирование
        $process_status_id = '2'; // статус В обработке

        // Узнаём статус, который стоял до изменения
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_status_id > '0' AND order_id = '" . (int)$order_id . "'");
        if ($order_status_query->num_rows) {
            $order_status_id = $order_status_query->row['order_status_id'];
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

        $order_products_query = $this->db->query("SELECT op.order_product_id, op.product_id, p.upc_more, op.quantity, op.products, op.model AS model, p.model AS product_model FROM " . DB_PREFIX . "order_product op LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = op.product_id) WHERE order_id = '" . (int)$order_id . "'");

        if ($order_products_query->num_rows) {
            // Restock products before subtracting the stock later on
            if (!($order_status_id == $cancel_status_id && $data['order_status_id'] == $process_status_id)) {
                foreach ($order_products_query->rows as $order_product) {
                    $upc_more = (int)$order_product['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                    $order_subtracted_products = []; // массив товаров, у которых списано количество
                    if ($order_product['products'] != '') {
                        $order_subtracted_products = unserialize($order_product['products']); // массив товаров, у которых списано количество
                    }

                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" . (int)$order_product['order_product_id'] . "'");

                    if ($order_option_query->num_rows) {
                        foreach ($order_option_query->rows as $order_option) {
                            $product_option_id = $order_option['product_option_id'];
                            $product_option_value_id = $order_option['product_option_value_id'];

                            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value_id . "' AND product_option_id = '" . (int)$product_option_id . "'");

                            if ($product_option_value_query->num_rows) {
                                $option_value_id = $product_option_value_query->row['option_value_id'];

                                if ($upc_more && !empty($order_subtracted_products)) {
                                    foreach ($order_subtracted_products as $product_id => $quantity) {
                                        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ob_quantity = (ob_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                    }

                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE ob_sku = '" . $order_product['model'] . "'");
                                } else {
                                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . $order_product['quantity'] . "), ob_quantity = (ob_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND option_value_id = '" . (int)$option_value_id . "'");
                                }
                            }
                        }
                    }

                    if ($upc_more && !empty($order_subtracted_products)) {
                        foreach ($order_subtracted_products as $product_id => $quantity) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = (upc_quantity + " . $quantity . ") WHERE product_id = '" . (int)$product_id . "'");
                        }

                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . ") WHERE model = '" . $order_product['product_model'] . "'");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity + " . $order_product['quantity'] . "), upc_quantity = (upc_quantity + " . $order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                    }
                }
            }

            if (!($order_status_id != $cancel_status_id && $data['order_status_id'] == $cancel_status_id)) {
                foreach ($order_products_query->rows as $order_product) {
                    $this->changeOrderProductQuantity($order_id, $order_product);
                }
            }
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

        $order_info = $this->getOrder($order_id);

            // Send out any gift voucher mails
        if ($this->config->get('config_complete_status_id') == $data['order_status_id']) {
            $this->load->model('sale/voucher');

            $results = $this->getOrderVouchers($order_id);

            foreach ($results as $result) {
                $this->model_sale_voucher->sendVoucher($result['voucher_id']);
            }
        }

        if ($data['notify']) {
            $language = new Language($order_info['language_directory']);
            $language->load($order_info['language_filename']);
            $language->load('mail/order');

            $subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_id);

            $message  = $language->get('text_order') . ' ' . $order_id . "\n";
            $message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

            $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$data['order_status_id'] . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

            if ($order_status_query->num_rows) {
                $message .= $language->get('text_order_status') . "\n";
                $message .= $order_status_query->row['name'] . "\n\n";
            }

            if ($order_info['customer_id']) {
                $message .= $language->get('text_link') . "\n";
                $message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";
            }

            if ($data['comment']) {
                $message .= $language->get('text_comment') . "\n\n";
                $message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
            }

            $message .= $language->get('text_footer');

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($order_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($order_info['store_name']);
            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }

    }

    public function getOrderHistories($order_id, $start = 0, $limit = 10) {
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

        return $query->rows;
    }

    public function getTotalOrderHistories($order_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

        return $query->row['total'];
    }

    public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

        return $query->row['total'];
    }

    public function getEmailsByProductsOrdered($products, $start, $end) {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int)$product_id . "'";
        }

        $query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

        return $query->rows;
    }

    public function getTotalEmailsByProductsOrdered($products) {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int)$product_id . "'";
        }

        $query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

        return $query->row['total'];
    }
}
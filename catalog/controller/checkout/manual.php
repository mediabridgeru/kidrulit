<?php 
class ControllerCheckoutManual extends Controller {
	public function index() {
		$this->language->load('checkout/manual');

		$json = array();

		$this->load->library('user');

		$this->user = new User($this->registry);

		if ($this->user->isLogged() && $this->user->hasPermission('modify', 'sale/order')) {
			// Reset everything
			$this->cart->clear();
			$this->customer->logout();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);			
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			// Settings
			$this->load->model('setting/setting');

			$settings = $this->model_setting_setting->getSetting('config', $this->request->post['store_id']);

			foreach ($settings as $key => $value) {
				$this->config->set($key, $value);
			}

			// Customer
			if ($this->request->post['customer_id']) {
				$this->load->model('account/customer');

				$customer_info = $this->model_account_customer->getCustomer($this->request->post['customer_id']);

				if ($customer_info) {
					$this->customer->login($customer_info['email'], '', true);
					$this->cart->clear();
				} else {
					$json['error']['customer'] = $this->language->get('error_customer');
				}
			} else {
				// Customer Group
				$this->config->set('config_customer_group_id', $this->request->post['customer_group_id']);
			}

			// Product
			$this->load->model('catalog/product');
            $this->load->model('sale/order');

            $order_id = 0;

            if (isset($this->request->post['order_id'])) {
                $order_id = $this->request->post['order_id'];
            }

			$current_product_ids = []; // ID товаров, которые были в заказе до добавления
            $current_products_quantity = []; // количества товаров, которые были в заказе до добавления
            $order_db_subtracted_products = []; // товары в заказе с гтд, из которых бралось количество

            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

            if ($order_product_query->num_rows) {
                foreach ($order_product_query->rows as $order_product) {
                    /* FIX: Сохраняем ид продуктов заказа и формируем уникальный индекс состоящий из ид и модели */
                    /* Если модель отсутствует, то order_product_id не будет найден. */
                    $current_product_ids[$order_product['product_id'] . ($order_product['model'] ?: '')] = $order_product['order_product_id'];
                    $current_products_quantity[$order_product['product_id'] . ($order_product['model'] ?: '')] = $order_product['quantity'];

                    if (!empty($order_product['products'])) {
                        $order_db_subtracted_products[$order_product['product_id'] . $order_product['model']] = unserialize($order_product['products']); // массив товаров, у которых списано количество
                    }
                }
            }

            $order_page_subtracted_products = []; // товары в заказе с гтд, из которых бралось количество до добавления текущего товара

			if (isset($this->request->post['order_product'])) { // товары, которые были на странице заказа до добавления текущего товара
				foreach ($this->request->post['order_product'] as $order_page_product) {
					$product_info = $this->model_catalog_product->getProduct($order_page_product['product_id']);

					if ($product_info) {
                        if (!empty($order_page_product['products'])) {
                            $order_page_subtracted_products[$order_page_product['product_id'] . $order_page_product['model']] = unserialize($order_page_product['products']); // массив товаров, у которых списано количество
                        }

						$option_data = [];

						if (isset($order_page_product['order_option'])) {
							foreach ($order_page_product['order_option'] as $option) {
								if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { 
									$option_data[$option['product_option_id']] = $option['product_option_value_id'];
								} elseif ($option['type'] == 'checkbox') {
									$option_data[$option['product_option_id']][] = $option['product_option_value_id'];
								} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
									$option_data[$option['product_option_id']] = $option['value'];						
								}
							}
						}

						$this->cart->add($order_page_product['product_id'], $order_page_product['quantity'], $option_data);
					}
				}
			}

			if (isset($this->request->post['product_id'])) { // товары, которые добавлены в заказ по кнопке Добавить товар
				$product_id = $this->request->post['product_id'];

                $product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if (isset($this->request->post['quantity'])) {
						$quantity = (int)$this->request->post['quantity'];
					} else {
						$quantity = 1;
					}

					if (isset($this->request->post['option'])) {
						$option = array_filter($this->request->post['option']);
					} else {
						$option = array();	
					}

                    $gtd = (int)$product_info['upc_more']; // включена галка Имеются товары этой модели с другим ГТД

                    if ($gtd) {
                        $product_model = $product_info['model'];

                        if (!empty($order_db_subtracted_products[$product_id . $product_model])) {
                            $cart_old_subtracted_products = $order_db_subtracted_products[$product_id . $product_model]; // массив товаров, у которых были вычеты количества в заказе
                            $cart_new_subtracted_products = $order_page_subtracted_products[$product_id . $product_model]; // массив товаров, у которых были вычеты количества на странице заказа до добавления текущего товара

                            $group_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p WHERE p.model = '" . $product_model . "' AND p.upc_quantity > 0 ORDER BY p.upc, p.date_added");

                            if ($group_product_query->num_rows) { // массив всех товаров с такой моделью
                                $new_subtracted_product_quantity = $subtracted_option_quantity = $quantity; // количество новых товаров, которое списано у всей группы

                                foreach ($group_product_query->rows as $product) {
                                    if ($new_subtracted_product_quantity) {
                                        if (isset($cart_old_subtracted_products[$product['product_id']])) {
                                            $cart_old_subtracted_quantity = $cart_old_subtracted_products[$product['product_id']];
                                        } else {
                                            $cart_old_subtracted_quantity = 0; // количество товаров, которое было отнято у очередного товара
                                        }

                                        if (isset($cart_new_subtracted_products[$product['product_id']])) {
                                            $cart_new_subtracted_quantity = $cart_new_subtracted_products[$product['product_id']];
                                        } else {
                                            $cart_new_subtracted_quantity = 0; // количество товаров, которое было отнято у очередного товара
                                        }

                                        if (($cart_new_subtracted_quantity - $cart_old_subtracted_quantity + $new_subtracted_product_quantity) < (int)$product['upc_quantity']) {
                                            $order_page_subtracted_products[$product_id . $product_model][$product['product_id']] = $cart_new_subtracted_quantity + $new_subtracted_product_quantity;
                                            $new_subtracted_product_quantity = 0;
                                        } else {
                                            $new_subtracted_product_quantity = $cart_new_subtracted_quantity - $cart_old_subtracted_quantity + $new_subtracted_product_quantity - (int)$product['upc_quantity'];
                                            $order_page_subtracted_products[$product_id . $product_model][$product['product_id']] = $cart_old_subtracted_quantity + (int)$product['upc_quantity'];
                                        }
                                    }
                                }
                            }
                        }
                    }

					$product_options = $this->model_catalog_product->getProductOptions($product_id);

					foreach ($product_options as $product_option) {
						if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
							$json['error']['product']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
						}
					}

					if (!isset($json['error']['product']['option'])) {
						$this->cart->add($product_id, $quantity, $option);
					}
				}
			}

			// Stock
			if (!$this->cart->hasStock($current_products_quantity) && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$json['error']['product']['stock'] = $this->language->get('error_stock');
			}		

			// Tax
			if ($this->cart->hasShipping()) {
				$this->tax->setShippingAddress($this->request->post['shipping_country_id'], $this->request->post['shipping_zone_id']);
			} else {
				$this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
			}

			$this->tax->setPaymentAddress($this->request->post['payment_country_id'], $this->request->post['payment_zone_id']);				
			$this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));	

			// Products
			$json['order_product'] = [];

			$cart_products = $this->cart->getProducts($current_products_quantity); // все товары в корзине после добавления

			foreach ($cart_products as $product) {
                $products = [];
                $subtracted_products = '';

			    if (isset($order_page_subtracted_products[$product['product_id'].$product['model']])) {
                    $products = $order_page_subtracted_products[$product['product_id'].$product['model']];

                    foreach ($products as $product_id => $qty) {
                        $subtracted_products .= '<br>' . $product_id . ' - ' . $qty;
                    }
                }

				$product_total = 0;

				foreach ($cart_products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}	

				if ($product['minimum'] > $product_total) {
					$json['error']['product']['minimum'][] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

                $option_data = array();

                foreach ($product['option'] as $option) {
                    $order_option_id  = '';
                    $order_product_id = '';

                    $order_option = $this->model_sale_order->getOrderOptionByProductOptionValueId($order_id, $option['product_option_value_id']);

                    if (!empty($order_option)) {
                        $order_option_id  = $order_option['order_option_id'];
                        $order_product_id = $order_option['order_product_id'];
                    }

                    $option_data[] = array(
                        'order_option_id'         => $order_option_id,
                        'order_product_id'        => $order_product_id,
                        'product_option_id'       => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'name'                    => $option['name'],
                        'value'                   => $option['option_value'],
                        'type'                    => $option['type'],
                    );
                }

				$download_data = array();

				foreach ($product['download'] as $download) {
					$download_data[] = array(
						'name'      => $download['name'],
						'filename'  => $download['filename'],
						'mask'      => $download['mask'],
						'remaining' => $download['remaining']
					);
				}

				if (empty($products)) {
                    $products = '';
                } else {
                    $products = serialize($products);
                }

                $json['order_product'][] = array(
                    'order_product_ids' => $current_product_ids,
                    'product_id'        => $product['product_id'],
                    'name'              => $product['name'],
                    'model'             => $product['model'],
                    'option'            => $option_data,
                    'download'          => $download_data,
                    'quantity'          => $product['quantity'],
                    'stock'             => $product['stock'],
                    'db_quantity'       => $product['db_quantity'],
                    'products'          => $products,
                    'subtracted_products' => $subtracted_products,
                    'price'             => $product['price'],
                    'total'             => $product['total'],
                    'tax'               => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward'            => $product['reward'],
                );
			}

			// Voucher
			$this->session->data['vouchers'] = array();

			if (isset($this->request->post['order_voucher'])) {
				foreach ($this->request->post['order_voucher'] as $voucher) {
					$this->session->data['vouchers'][] = array(
						'voucher_id'       => $voucher['voucher_id'],
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'], 
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']    
					);
				}
			}

			// Add a new voucher if set
			if (isset($this->request->post['from_name']) && isset($this->request->post['from_email']) && isset($this->request->post['to_name']) && isset($this->request->post['to_email']) && isset($this->request->post['amount'])) {
				if ((utf8_strlen($this->request->post['from_name']) < 1) || (utf8_strlen($this->request->post['from_name']) > 64)) {
					$json['error']['vouchers']['from_name'] = $this->language->get('error_from_name');
				}  

				if ((utf8_strlen($this->request->post['from_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['from_email'])) {
					$json['error']['vouchers']['from_email'] = $this->language->get('error_email');
				}

				if ((utf8_strlen($this->request->post['to_name']) < 1) || (utf8_strlen($this->request->post['to_name']) > 64)) {
					$json['error']['vouchers']['to_name'] = $this->language->get('error_to_name');
				}       

				if ((utf8_strlen($this->request->post['to_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['to_email'])) {
					$json['error']['vouchers']['to_email'] = $this->language->get('error_email');
				}

				if (($this->request->post['amount'] < 1) || ($this->request->post['amount'] > 1000)) {
					$json['error']['vouchers']['amount'] = sprintf($this->language->get('error_amount'), $this->currency->format(1, false, 1), $this->currency->format(1000, false, 1) . ' ' . $this->config->get('config_currency'));
				}

				if (!isset($json['error']['vouchers'])) { 
					$voucher_data = array(
						'order_id'         => 0,
						'code'             => substr(md5(mt_rand()), 0, 10),
						'from_name'        => $this->request->post['from_name'],
						'from_email'       => $this->request->post['from_email'],
						'to_name'          => $this->request->post['to_name'],
						'to_email'         => $this->request->post['to_email'],
						'voucher_theme_id' => $this->request->post['voucher_theme_id'], 
						'message'          => $this->request->post['message'],
						'amount'           => $this->request->post['amount'],
						'status'           => true             
					); 

					$this->load->model('checkout/voucher');

					$voucher_id = $this->model_checkout_voucher->addVoucher(0, $voucher_data);  

					$this->session->data['vouchers'][] = array(
						'voucher_id'       => $voucher_id,
						'description'      => sprintf($this->language->get('text_for'), $this->currency->format($this->request->post['amount'], $this->config->get('config_currency')), $this->request->post['to_name']),
						'code'             => substr(md5(mt_rand()), 0, 10),
						'from_name'        => $this->request->post['from_name'],
						'from_email'       => $this->request->post['from_email'],
						'to_name'          => $this->request->post['to_name'],
						'to_email'         => $this->request->post['to_email'],
						'voucher_theme_id' => $this->request->post['voucher_theme_id'], 
						'message'          => $this->request->post['message'],
						'amount'           => $this->request->post['amount']            
					); 
				}
			}

			$json['order_voucher'] = array();

			foreach ($this->session->data['vouchers'] as $voucher) {
				$json['order_voucher'][] = array(
					'voucher_id'       => $voucher['voucher_id'],
					'description'      => $voucher['description'],
					'code'             => $voucher['code'],
					'from_name'        => $voucher['from_name'],
					'from_email'       => $voucher['from_email'],
					'to_name'          => $voucher['to_name'],
					'to_email'         => $voucher['to_email'],
					'voucher_theme_id' => $voucher['voucher_theme_id'], 
					'message'          => $voucher['message'],
					'amount'           => $voucher['amount']    
				);
			}

			$this->load->model('setting/extension');

			$this->load->model('localisation/country');

			$this->load->model('localisation/zone');

			// Shipping
			$json['shipping_method'] = array();

			if ($this->cart->hasShipping()) {		
				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($this->request->post['shipping_country_id']);

				if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['shipping_postcode']) < 2) || (utf8_strlen($this->request->post['shipping_postcode']) > 10)) {
					$json['error']['shipping']['postcode'] = $this->language->get('error_postcode');
				}

				if ($this->request->post['shipping_country_id'] == '') {
					$json['error']['shipping']['country'] = $this->language->get('error_country');
				}

				if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
					$json['error']['shipping']['zone'] = $this->language->get('error_zone');
				}

				if (!isset($json['error']['shipping'])) {
					if ($country_info) {
						$country = $country_info['name'];
						$iso_code_2 = $country_info['iso_code_2'];
						$iso_code_3 = $country_info['iso_code_3'];
						$address_format = $country_info['address_format'];
					} else {
						$country = '';
						$iso_code_2 = '';
						$iso_code_3 = '';	
						$address_format = '';
					}

					$zone_info = $this->model_localisation_zone->getZone($this->request->post['shipping_zone_id']);

					if ($zone_info) {
						$zone = $zone_info['name'];
						$zone_code = $zone_info['code'];
					} else {
						$zone = '';
						$zone_code = '';
					}					

					$address_data = array(
						'firstname'      => $this->request->post['shipping_firstname'],
						'lastname'       => $this->request->post['shipping_lastname'],
						'company'        => $this->request->post['shipping_company'],
						'address_1'      => $this->request->post['shipping_address_1'],
						'address_2'      => $this->request->post['shipping_address_2'],
						'postcode'       => $this->request->post['shipping_postcode'],
						'city'           => $this->request->post['shipping_city'],
						'zone_id'        => $this->request->post['shipping_zone_id'],
						'zone'           => $zone,
						'zone_code'      => $zone_code,
						'country_id'     => $this->request->post['shipping_country_id'],
						'country'        => $country,	
						'iso_code_2'     => $iso_code_2,
						'iso_code_3'     => $iso_code_3,
						'address_format' => $address_format
					);

					$results = $this->model_setting_extension->getExtensions('shipping');

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('shipping/' . $result['code']);

							$quote = $this->{'model_shipping_' . $result['code']}->getQuote($address_data);

							if ($quote) {
                                if ($quote['code'] == 'cdek') {
                                    $cdek_quote = array();

                                    foreach ($quote['quote'] as $q => $quote_item) {
                                        $title = $quote_item['title'];
                                        $pos1 = mb_stripos($title, " Режим", 0, "UTF-8");
                                        $title = iconv_substr ($title, 0 , $pos1 , "UTF-8");
                                        $cdek_quote[$q] = array(
                                            'code'         => $quote_item['code'],
                                            'cod'          => $quote_item['cod'],
                                            'pvz'          => $quote_item['pvz'],
                                            'title'        => $title,
                                            'cost'         => $quote_item['cost'],
                                            'tax_class_id' => $quote_item['tax_class_id'],
                                            'text'         => $quote_item['text']
                                        );
                                    }

                                    $json['shipping_method'][$result['code']] = array(
                                        'title'      => $quote['title'],
                                        'quote'      => $cdek_quote,
                                        'sort_order' => $quote['sort_order'],
                                        'error'      => $quote['error']
                                    );
                                } else {
                                    $json['shipping_method'][$result['code']] = array(
                                        'title'      => $quote['title'],
                                        'quote'      => $quote['quote'],
                                        'sort_order' => $quote['sort_order'],
                                        'error'      => $quote['error']
                                    );
                                }
							}
						}
					}

					$sort_order = array();

					foreach ($json['shipping_method'] as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $json['shipping_method']);

					if (!$json['shipping_method']) {
						$json['error']['shipping_method'] = $this->language->get('error_no_shipping');
					} elseif ($this->request->post['shipping_code']) {
						$shipping = explode('.', $this->request->post['shipping_code']);
                        $shipping_pvz = $this->request->post['shipping_pvz'];

                        if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($json['shipping_method'][$shipping[0]]['quote'][$shipping[1]])) {
                            if (isset($shipping[0]) && $shipping[0] == 'cdek') {
                                if ($shipping_pvz === 0) {
                                    $json['error']['shipping_method'] = $this->language->get('error_shipping');
                                } else {
                                    $shipping_method = $json['shipping_method'][$shipping[0]]['quote'][$shipping[1] . '_' . $shipping_pvz];
                                    $this->session->data['shipping_method'] = $shipping_method;
                                }
                            } else {
                                $json['error']['shipping_method'] = $this->language->get('error_shipping');
                            }
                        } else {
                            $this->session->data['shipping_method'] = $json['shipping_method'][$shipping[0]]['quote'][$shipping[1]];
                        }
					}
				}
			}

			// Coupon
			if (!empty($this->request->post['coupon'])) {
				$this->load->model('checkout/coupon');

				$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);			

				if ($coupon_info) {					
					$this->session->data['coupon'] = $this->request->post['coupon'];
				} else {
					$json['error']['coupon'] = $this->language->get('error_coupon');
				}
			}

			// Voucher
			if (!empty($this->request->post['voucher'])) {
				$this->load->model('checkout/voucher');

				$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);			

				if ($voucher_info) {					
					$this->session->data['voucher'] = $this->request->post['voucher'];
				} else {
					$json['error']['voucher'] = $this->language->get('error_voucher');
				}
			}

			// Reward Points
			if (!empty($this->request->post['reward'])) {
				$points = $this->customer->getRewardPoints();

				if ($this->request->post['reward'] > $points) {
					$json['error']['reward'] = sprintf($this->language->get('error_points'), $this->request->post['reward']);
				}

				if (!isset($json['error']['reward'])) {
					$points_total = 0;

					foreach ($this->cart->getProducts() as $product) {
						if ($product['points']) {
							$points_total += $product['points'];
						}
					}				

					if ($this->request->post['reward'] > $points_total) {
						$json['error']['reward'] = sprintf($this->language->get('error_maximum'), $points_total);
					}

					if (!isset($json['error']['reward'])) {		
						$this->session->data['reward'] = $this->request->post['reward'];
					}
				}
			}

			// Totals
			$json['order_total'] = array();					
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$sort_order = array(); 

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($json['order_total'], $total, $taxes);
				}

				$sort_order = array(); 

				foreach ($json['order_total'] as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $json['order_total']);				
			}

			// Payment
			if ($this->request->post['payment_country_id'] == '') {
				$json['error']['payment']['country'] = $this->language->get('error_country');
			}

			if (!isset($this->request->post['payment_zone_id']) || $this->request->post['payment_zone_id'] == '') {
				$json['error']['payment']['zone'] = $this->language->get('error_zone');
			}		

			if (!isset($json['error']['payment'])) {
				$json['payment_methods'] = array();

				$country_info = $this->model_localisation_country->getCountry($this->request->post['payment_country_id']);

				if ($country_info) {
					$country = $country_info['name'];
					$iso_code_2 = $country_info['iso_code_2'];
					$iso_code_3 = $country_info['iso_code_3'];
					$address_format = $country_info['address_format'];
				} else {
					$country = '';
					$iso_code_2 = '';
					$iso_code_3 = '';	
					$address_format = '';
				}

				$zone_info = $this->model_localisation_zone->getZone($this->request->post['payment_zone_id']);

				if ($zone_info) {
					$zone = $zone_info['name'];
					$zone_code = $zone_info['code'];
				} else {
					$zone = '';
					$zone_code = '';
				}					

				$address_data = array(
					'firstname'      => $this->request->post['payment_firstname'],
					'lastname'       => $this->request->post['payment_lastname'],
					'company'        => $this->request->post['payment_company'],
					'address_1'      => $this->request->post['payment_address_1'],
					'address_2'      => $this->request->post['payment_address_2'],
					'postcode'       => $this->request->post['payment_postcode'],
					'city'           => $this->request->post['payment_city'],
					'zone_id'        => $this->request->post['payment_zone_id'],
					'zone'           => $zone,
					'zone_code'      => $zone_code,
					'country_id'     => $this->request->post['payment_country_id'],
					'country'        => $country,	
					'iso_code_2'     => $iso_code_2,
					'iso_code_3'     => $iso_code_3,
					'address_format' => $address_format
				);

				$json['payment_method'] = array();

				$results = $this->model_setting_extension->getExtensions('payment');

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('payment/' . $result['code']);

						$method = $this->{'model_payment_' . $result['code']}->getMethod($address_data, $total); 

						if ($method) {
							$json['payment_method'][$result['code']] = $method;
						}
					}
				}

				$sort_order = array(); 

				foreach ($json['payment_method'] as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $json['payment_method']);	

				if (!$json['payment_method']) {
					$json['error']['payment_method'] = $this->language->get('error_no_payment');
				} elseif ($this->request->post['payment_code']) {			
					if (!isset($json['payment_method'][$this->request->post['payment_code']])) {
						$json['error']['payment_method'] = $this->language->get('error_payment');
					}
				}
			}

			if (!isset($json['error'])) { 
				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error']['warning'] = $this->language->get('error_warning');
			}

			// Reset everything
			$this->cart->clear();
			$this->customer->logout();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
		} else {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		$this->response->setOutput(json_encode($json));	
	}
}
?>
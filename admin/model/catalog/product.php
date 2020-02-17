<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
        $customer_price = (isset($data['customer_price']) && $data['customer_price']) ? serialize($data['customer_price']) : '';

        $upc_more = (isset($data['upc_more']) && $data['upc_more']) ? 1 : 0;

        $pod_status = $this->getPodStatus();

        $this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', upc_more = '" . $upc_more . "', upc_quantity = '" . (int)$data['upc_quantity'] . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', customer_price = '" . $this->db->escape($customer_price) . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$product_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', report_name = '" . $this->db->escape($value['report_name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', description_mini = '" . $this->db->escape($value['description_mini']) . "', tag = '" . $this->db->escape($value['tag']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

					$product_option_id = $this->db->getLastId();

                    if ($pod_status && isset($product_option['show_price_product'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod_setting SET
                            product_option_id = '" . (int)$product_option_id . "',
                            show_price_product = '" . (int)$product_option['show_price_product'] . "',
                            show_price_cart = '" . (int)$product_option['show_price_cart'] . "',
                            show_final = '" . (int)$product_option['show_final'] . "',
                            table_style = '" . $this->db->escape($product_option['table_style']) . "',
                            price_format = '" . $this->db->escape($product_option['price_format']) . "',
                            qty_column = '" . (int)$product_option['qty_column'] . "',
                            qty_format = '" . $this->db->escape($product_option['qty_format']) . "',
                            stock_column = '" . (int)$product_option['stock_column'] . "',
                            qty_cart = '" . (int)$product_option['qty_cart'] . "',
                            flat_rate = '" . (int)$product_option['flat_rate'] . "',
                            cart_discount = '" . (int)$product_option['cart_discount'] . "',
                            inc_tax = '" . $this->db->escape($product_option['inc_tax']) . "'");
                        $this->cache->delete('myoc.pods');
                    }

					if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0 ) {
                        $option_quantity = 0; // количество в опции
                        $product_option_quantity = 0; // количество в опции товара
						foreach ($product_option['product_option_value'] as $product_option_value) {
                            $ov_sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'";
                            if(isset($product_option_value['ob_sku'])) {
                                $ov_sql .= ", ob_sku = '" . $this->db->escape($product_option_value['ob_sku']) . "'";
                            }
                            if(isset($product_option_value['ob_upc'])) {
                                $ov_sql .= ", ob_upc = '" . $this->db->escape($product_option_value['ob_upc']) . "'";
                            }
                            if(isset($product_option_value['ob_quantity'])) {
                                $ov_sql .= ", ob_quantity = '" . $this->db->escape($product_option_value['ob_quantity']) . "'";
                            }
                            if(isset($product_option_value['ob_kod'])) {
                                $ov_sql .= ", ob_kod = '" . $this->db->escape($product_option_value['ob_kod']) . "'";
                            }
                            if(isset($product_option_value['ob_info'])) {
                                $ov_sql .= ", ob_info = '" . $this->db->escape($product_option_value['ob_info']) . "'";
                            }
                            if(isset($product_option_value['ob_image'])) {
                                $ov_sql .= ", ob_image = '" . $this->db->escape($product_option_value['ob_image']) . "'";
                            }
                            if(isset($product_option_value['ob_sku_override'])) {
                                $ov_sql .= ", ob_sku_override = '" . $this->db->escape($product_option_value['ob_sku_override']) . "'";
                            }
                            $this->db->query($ov_sql);

                            $myoc_product_option_value_id = $this->db->getLastId();

                            if($pod_status && isset($product_option_value['pod']) && !empty($product_option_value['pod'])) {
                                foreach($product_option_value['pod'] as $pod) {
                                    if(!isset($pod['customer_group_ids'])) {
                                        $pod['customer_group_ids'] = [];
                                    }
                                    // added
                                    if(!isset($pod['customer_ids'])) {
                                        $pod['customer_ids'] = [];
                                    }
                                    //
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod SET
							product_option_value_id	= '" . (int)$myoc_product_option_value_id . "',
							customer_group_ids		= '" . $this->db->escape(serialize($pod['customer_group_ids'])) . "',
							customer_ids		= '" . $this->db->escape(serialize($pod['customer_ids'])) . "',
							quantity				= '" . (int)$pod['quantity'] . "',
							calc_method				= '" . $this->db->escape($pod['calc_method']) . "',
							price					= '" . (float)$pod['price'] . "',
							price_prefix			= '" . $this->db->escape($pod['price_prefix']) . "',
							special					= '" . (float)$pod['special'] . "',
							special_prefix			= '" . $this->db->escape($pod['special_prefix']) . "',
							option_base_points		= '" . (isset($pod['option_base_points']) && $pod['option_base_points'] ? 1 : 0) . "',
							points					= '" . (int)$pod['points'] . "',
							points_prefix			= '" . $this->db->escape($pod['points_prefix']) . "',
							priority				= '" . (int)$pod['priority'] . "',
							date_start				= '" . $this->db->escape($pod['date_start']) . "',
							date_end				= '" . $this->db->escape($pod['date_end']) . "'");
                                }
                                $this->cache->delete('myoc.pods');
                            }

                            if ($upc_more) {
                                $option_quantity += $this->setGroupOptionQuantity($product_id, $product_option_value['ob_sku'], $product_option_value['ob_quantity']);
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$product_option_value['ob_quantity'] . "' WHERE product_id = '" . $product_id . "' AND ob_sku = '" . $product_option_value['ob_sku'] . "'");
                            }

                            $product_option_quantity += (int)$product_option_value['ob_quantity'];
						}

                        if ($upc_more) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$option_quantity . "' WHERE model = '" . $data['model'] . "'");
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");

                            $this->setGroupProductQuantity($product_id, $data['model']);
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$product_option_quantity . "', upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");
                        }
					}else{
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '".$product_option_id."'");
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		} else {
            if ($upc_more) {
                $this->setProductQuantity($product_id, $data['model'], $data['upc_quantity']);
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$data['upc_quantity'] . "' WHERE product_id = '" . $product_id . "'");
            }
        }

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
		
		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['product_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
		}

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['product_related2'])) {
			foreach ($data['product_related2'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['blog_related_product'])) {
			foreach ($data['blog_related_product'] as $article_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$product_id . "' AND article_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related_product SET product_id = '" . (int)$product_id . "', article_id = '" . (int)$article_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$article_id . "' AND article_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related_product SET product_id = '" . (int)$article_id . "', article_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
			}
		}
		//ocshop benefits

		if (isset($data['product_benefits'])) {
			foreach ($data['product_benefits'] as $benefit_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_benefit SET product_id = '" . (int)$product_id . "', benefit_id = '" . (int)$benefit_id . "'");
			}
		}
		//ocshop benefits

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		
		$this->cache->delete('seo_pro');
        $this->cache->delete('seo_url');

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['product_profiles'])) {
			foreach ($data['product_profiles'] as $profile) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$profile['customer_group_id'] . ", `profile_id` = " . (int)$profile['profile_id']);
			}
		}

		if (isset($data['product_stickers'])) {
			foreach ($data['product_stickers'] as $key => $sticker_id) {
				if ($sticker_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_sticker SET product_id = '" . (int)$product_id . "', position = '" . (int)$key . "', sticker_id = '" . (int)$sticker_id . "'");
				}
			}
		}

		$this->cache->delete('product');
		
		return $product_id;
	}

	public function editProduct($product_id, $data) {
        $customer_price = (isset($data['customer_price']) && $data['customer_price']) ? serialize($data['customer_price']) : '';

        $upc_more = (isset($data['upc_more']) && $data['upc_more']) ? 1 : 0;

        $pod_status = $this->getPodStatus();

        $this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', upc_more = '" . $upc_more . "', upc_quantity = '" . (int)$data['upc_quantity'] . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', customer_price = '" . $this->db->escape($customer_price) . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', report_name = '" . $this->db->escape($value['report_name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', description_mini = '" . $this->db->escape($value['description_mini']) . "', tag = '" . $this->db->escape($value['tag']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

        if (isset($data['product_option'])) {
            foreach ($data['product_option'] as $product_option) {
                if ($pod_status) {
                    $this->db->query("DELETE FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
                }
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

                    $product_option_id = $this->db->getLastId();

                    if ($pod_status && isset($product_option['show_price_product'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod_setting SET
                            product_option_id = '" . (int)$product_option_id . "',
                            show_price_product = '" . (int)$product_option['show_price_product'] . "',
                            show_price_cart = '" . (int)$product_option['show_price_cart'] . "',
                            show_final = '" . (int)$product_option['show_final'] . "',
                            table_style = '" . $this->db->escape($product_option['table_style']) . "',
                            price_format = '" . $this->db->escape($product_option['price_format']) . "',
                            qty_column = '" . (int)$product_option['qty_column'] . "',
                            qty_format = '" . $this->db->escape($product_option['qty_format']) . "',
                            stock_column = '" . (int)$product_option['stock_column'] . "',
                            qty_cart = '" . (int)$product_option['qty_cart'] . "',
                            flat_rate = '" . (int)$product_option['flat_rate'] . "',
                            cart_discount = '" . (int)$product_option['cart_discount'] . "',
                            inc_tax = '" . $this->db->escape($product_option['inc_tax']) . "'");
                        $this->cache->delete('myoc.pods');
                    }

                    if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0) {
                        $option_quantity = 0; // количество в опции
                        $product_option_quantity = 0; // количество в опции товара
                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            if ($pod_status) {
                                $this->db->query("DELETE FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                            }

                            $ov_sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . $this->db->escape($product_option_value['quantity']) . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'";
                            if (isset($product_option_value['ob_sku'])) {
                                $ov_sql .= ", ob_sku = '" . $this->db->escape($product_option_value['ob_sku']) . "'";
                            }
                            if (isset($product_option_value['ob_upc'])) {
                                $ov_sql .= ", ob_upc = '" . $this->db->escape($product_option_value['ob_upc']) . "'";
                            }
                            if (isset($product_option_value['ob_quantity'])) {
                                $ov_sql .= ", ob_quantity = '" . $this->db->escape($product_option_value['ob_quantity']) . "'";
                            }
                            if (isset($product_option_value['ob_kod'])) {
                                $ov_sql .= ", ob_kod = '" . $this->db->escape($product_option_value['ob_kod']) . "'";
                            }
                            if (isset($product_option_value['ob_info'])) {
                                $ov_sql .= ", ob_info = '" . $this->db->escape($product_option_value['ob_info']) . "'";
                            }
                            if (isset($product_option_value['ob_image'])) {
                                $ov_sql .= ", ob_image = '" . $this->db->escape($product_option_value['ob_image']) . "'";
                            }
                            if (isset($product_option_value['ob_sku_override'])) {
                                $ov_sql .= ", ob_sku_override = '" . $this->db->escape($product_option_value['ob_sku_override']) . "'";
                            }
                            $this->db->query($ov_sql);

                            $myoc_product_option_value_id = $this->db->getLastId();

                            if($pod_status && isset($product_option_value['pod']) && !empty($product_option_value['pod'])) {
                                foreach($product_option_value['pod'] as $pod) {
                                    if(!isset($pod['customer_group_ids'])) {
                                        $pod['customer_group_ids'] = [];
                                    }
                                    // added
                                    if(!isset($pod['customer_ids'])) {
                                        $pod['customer_ids'] = [];
                                    }
                                    //
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod SET
							product_option_value_id	= '" . (int)$myoc_product_option_value_id . "',
							customer_group_ids		= '" . $this->db->escape(serialize($pod['customer_group_ids'])) . "',
							customer_ids		= '" . $this->db->escape(serialize($pod['customer_ids'])) . "',
							quantity				= '" . (int)$pod['quantity'] . "',
							calc_method				= '" . $this->db->escape($pod['calc_method']) . "',
							price					= '" . (float)$pod['price'] . "',
							price_prefix			= '" . $this->db->escape($pod['price_prefix']) . "',
							special					= '" . (float)$pod['special'] . "',
							special_prefix			= '" . $this->db->escape($pod['special_prefix']) . "',
							option_base_points		= '" . (isset($pod['option_base_points']) && $pod['option_base_points'] ? 1 : 0) . "',
							points					= '" . (int)$pod['points'] . "',
							points_prefix			= '" . $this->db->escape($pod['points_prefix']) . "',
							priority				= '" . (int)$pod['priority'] . "',
							date_start				= '" . $this->db->escape($pod['date_start']) . "',
							date_end				= '" . $this->db->escape($pod['date_end']) . "'");
                                }
                                $this->cache->delete('myoc.pods');
                            }

                            if ($upc_more) {
                                $option_quantity += $this->setGroupOptionQuantity($product_id, $product_option_value['ob_sku'], $product_option_value['ob_quantity']);
                            } else {
                                $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$product_option_value['ob_quantity'] . "' WHERE product_id = '" . $product_id . "' AND ob_sku = '" . $product_option_value['ob_sku'] . "'");
                            }

                            $product_option_quantity += (int)$product_option_value['ob_quantity'];
                        }

                        if ($upc_more) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$option_quantity . "' WHERE model = '" . $data['model'] . "'");
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");

                            $this->setGroupProductQuantity($product_id, $data['model']);
                        } else {
                            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$product_option_quantity . "', upc_quantity = '" . (int)$product_option_quantity . "' WHERE product_id = '" . $product_id . "'");
                        }
                    } else {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_option_id = '" . $product_option_id . "'");
                    }
                } else {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
                }
            }
        } else {
            if ($upc_more) {
                $this->setProductQuantity($product_id, $data['model'], $data['upc_quantity']);
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$data['upc_quantity'] . "' WHERE product_id = '" . $product_id . "'");
            }
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}
		
		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['product_category'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE related_id = '" . (int)$product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE article_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['product_related2'])) {
			foreach ($data['product_related2'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related2 SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['blog_related_product'])) {
			foreach ($data['blog_related_product'] as $article_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$product_id . "' AND article_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related_product SET product_id = '" . (int)$product_id . "', article_id = '" . (int)$article_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$article_id . "' AND article_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related_product SET product_id = '" . (int)$article_id . "', article_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}		
//ocshop benefits

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_benefit WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_benefits'])) {
			foreach ($data['product_benefits'] as $benefit_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_benefit SET product_id = '" . (int)$product_id . "', benefit_id = '" . (int)$benefit_id . "'");
			}
		}

//ocshop benefits
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_sticker WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_stickers'])) {
			foreach ($data['product_stickers'] as $key => $sticker_id) {
				if ($sticker_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_sticker SET product_id = '" . (int)$product_id . "', position = '" . (int)$key . "', sticker_id = '" . (int)$sticker_id . "'");
				}
			}
		}
		
		$this->cache->delete('seo_pro');
        $this->cache->delete('seo_url');

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int)$product_id);		if (isset($data['product_profiles'])) {			foreach ($data['product_profiles'] as $profile) {				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_profile` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$profile['customer_group_id'] . ", `profile_id` = " . (int)$profile['profile_id']);			}		}		$this->cache->delete('product');
		return $product_id;
	}
	
	public function editProductStatus($product_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . (int)$status . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
        $this->cache->delete('product');
		
		return $product_id;
    }

	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['sku'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_filter' => $this->getProductFilters($product_id)));
			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));		
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_related2' => $this->getProductRelated2($product_id)));
			$data = array_merge($data, array('blog_related_product' => $this->getArticleRelated($product_id)));
			$data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
			$data = array_merge($data, array('product_profiles' => $this->getProfiles($product_id)));

			$this->addProduct($data);
		}
	}

	public function deleteProduct($product_id) {
        $pod_status = $this->getPodStatus();

        if ($pod_status) {
            $po_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$product_id . "'");
            if ($po_query->num_rows) {
                foreach ($po_query->rows as $product_option) {
                    $this->db->query("DELETE FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
                }
            }

            $pov_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$product_id . "'");
            if ($pov_query->num_rows) {
                foreach ($pov_query->rows as $product_option_value) {
                    $this->db->query("DELETE FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
                }
            }
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related2 WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related_product WHERE article_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_profile WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");

		//ocshop benefits
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_benefit WHERE product_id = '" . (int)$product_id . "'");
		//ocshop benefits

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

		$this->cache->delete('product');
		
		return $product_id;
	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getProductCatNames($product_id) {				
		$query = $this->db->query("SELECT p2c.category_id FROM " . DB_PREFIX . "product_to_category p2c ".
					  "WHERE product_id = '" . (int)$product_id . "' order by category_id");

		$categories = array();
		$this->load->model('catalog/category');
		foreach ($query->rows as $row) {
			$categories[] = $this->model_catalog_category->getCategory($row['category_id']);
		}			
		return $categories;
	}

	public function getProducts($data = array()) {
		$sql = "SELECT p.*, pd.*,  po.option_id,  m.name as 'm_name' FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_option po ON (p.product_id = po.product_id)";
        $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_upc_quantity']) && !is_null($data['filter_upc_quantity'])) {
			$sql .= " AND p.upc_quantity = '" . $this->db->escape($data['filter_upc_quantity']) . "'";
		}

        if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
            $sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $implode_data = array();

                $implode_data[] = "category_id = '" . (int)$data['filter_category_id'] . "'";

                $this->load->model('catalog/category');

                $categories = $this->model_catalog_category->getCategories($data['filter_category_id']);

                foreach ($categories as $category) {
                    $implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
                }

                $sql .= " AND (" . implode(' OR ', $implode_data) . ")";
            } else {
                if ($data['filter_category_id'] == 'null') {
                    $sql .= " AND p2c.category_id is null ";
                } else {
                    $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                }
            }
        }
        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.upc_quantity',
            'p.quantity',
			'p.status',
			'p.sort_order'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY pd.name";	
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

		return $query->rows;
	}

	public function getProductDescriptions($product_id) {
		$product_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
                'report_name'      => $result['report_name'],
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'description'      => $result['description'],
				'description_mini' => $result['description_mini'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'tag'              => $result['tag']
			);
		}

		return $product_description_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	public function getProductMainCategoryId($product_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['category_id'] : 0);
	}

	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();

			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}

			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}

		return $product_attribute_data;
	}

	public function getProductOptions($product_id) {
        $this->load->model('sale/customer');

        $pod = [];

        $pod_status = $this->getPodStatus();

		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
            $pod_setting_query = [];
            if($pod_status) {
                $pod_setting_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
            }
            $product_option['show_price_product'] = false;
            $product_option['show_price_cart'] = false;
            $product_option['show_final'] = false;
            $product_option['table_style'] = false;
            $product_option['price_format'] = false;
            $product_option['qty_column'] = false;
            $product_option['qty_format'] = false;
            $product_option['stock_column'] = false;
            $product_option['qty_cart'] = false;
            $product_option['flat_rate'] = false;
            $product_option['cart_discount'] = false;
            $product_option['inc_tax'] = false;
            if($pod_setting_query && $pod_setting_query->num_rows) {
                $product_option = array_merge($product_option, $pod_setting_query->row);
            }

			$product_option_value_data = array();	

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ob_sku");

			foreach ($product_option_value_query->rows as $product_option_value) {
                if($pod_status) {
                    $pod_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' ORDER BY priority, quantity");

                    if($pod_query->num_rows) {
                        $pod = [];
                        foreach($pod_query->rows as $pod_row){
                            if (!empty($pod_row['customer_group_ids'])) {
                                if (is_array($pod_row['customer_group_ids'])) {
                                    $customer_group_ids = $pod_row['customer_group_ids'];
                                } else {
                                    $customer_group_ids = unserialize($pod_row['customer_group_ids']);
                                }

                                $pod_row['customer_group_ids'] = $customer_group_ids;
                            }

                            if (!empty($pod_row['customer_ids'])) {
                                $customers = [];

                                if (is_array($pod_row['customer_ids'])) {
                                    $customer_ids = $pod_row['customer_ids'];
                                } else {
                                    $customer_ids = unserialize($pod_row['customer_ids']);
                                }

                                $pod_row['customer_ids'] = $customer_ids;

                                if (!empty($customer_ids)) {
                                    foreach ($customer_ids as $customer_id) {
                                        $customer = $this->model_sale_customer->getCustomer($customer_id);
                                        if ($customer['lastname'] != '') {
                                            $customer['firstname'] = $customer['firstname'] . ' ' . $customer['lastname'];
                                        }

                                        $customers[] = [
                                            'id' => $customer_id,
                                            'name' => $customer['firstname']
                                        ];
                                    }
                                }

                                $pod_row['customers'] = $customers;
                            }

                            $pod[] = $pod_row;
                        }
                    }
                }

				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
                    'pod'                     => $pod,
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']	,
                    'ob_sku'                  	 => $product_option_value['ob_sku'], //Q: Options Boost
                    'ob_upc'                  	 => $product_option_value['ob_upc'],     // 150919
                    'ob_quantity'                => $product_option_value['ob_quantity'],// 150919
                    'ob_kod'                  	 => $product_option_value['ob_kod'], //Q: Options Boost
                    'ob_info'                    => $product_option_value['ob_info'], //Q: Options Boost
                    'ob_image'                   => $product_option_value['ob_image'], //Q: Options Boost
                    'ob_sku_override'            => $product_option_value['ob_sku_override'], //Q: Options Boost
				);
			}

            $product_option_data[] = array(
                'show_price_product' => $product_option['show_price_product'],
                'show_price_cart' => $product_option['show_price_cart'],
                'show_final' => $product_option['show_final'],
                'table_style' => $product_option['table_style'],
                'price_format' => $product_option['price_format'],
                'qty_column' => $product_option['qty_column'],
                'qty_format' => $product_option['qty_format'],
                'stock_column' => $product_option['stock_column'],
                'qty_cart' => $product_option['qty_cart'],
                'flat_rate' => $product_option['flat_rate'],
                'cart_discount' => $product_option['cart_discount'],
                'inc_tax' => $product_option['inc_tax'],

                'product_option_id'    => $product_option['product_option_id'],
                'option_id'            => $product_option['option_id'],
                'name'                 => $product_option['name'],
                'type'                 => $product_option['type'],
                'product_option_value' => $product_option_value_data,
                'option_value'         => $product_option['option_value'],
                'required'             => $product_option['required']
            );
		}

		return $product_option_data;
	}

    /**
     * @param $order_option
     * @return array
     */
	public function getProductOptionValue($order_option) {
        $product_option_value_data = [];

        $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$order_option['product_option_id'] . "' AND product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' ORDER BY ob_sku");

        if ($product_option_value_query->num_rows) {
            $product_option_value_data = $product_option_value_query->row;
        }

        return $product_option_value_data;
    }

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

    // added
    public function getProductDiscountsmp($product_id, $customer_group_id = 1) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < '" . $this->NOW . "') AND (date_end = '0000-00-00' OR date_end > '" . $this->NOW . "')) ORDER BY quantity ASC, priority ASC, price ASC");

        return $query->rows;
    }
    public function getProductOptionsmp($product_id) {
        $product_option_data = array();

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->rows as $product_option_value) {

                    $this->load->model('tool/image');

                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id'         => $product_option_value['option_value_id'],
                        'name'                    => $product_option_value['name'],
                        'image'                   => $product_option_value['image'],
                        'quantity'                => $product_option_value['quantity'],
                        'subtract'                => $product_option_value['subtract'],
                        'price'                   => $product_option_value['price'],
                        'price_prefix'            => $product_option_value['price_prefix'],
                        'weight'                  => $product_option_value['weight'],
                        'weight_prefix'           => $product_option_value['weight_prefix'],
                        'ob_sku'                  	 => $product_option_value['ob_sku'], //Q: Options Boost
                        'ob_upc'                  	 => $product_option_value['ob_upc'],     // 150919
                        'ob_quantity'                => $product_option_value['ob_quantity'],// 150919
                        'ob_kod'                  	 => $product_option_value['ob_kod'], //Q: Options Boost
                        'ob_info'                    => $product_option_value['ob_info'], //Q: Options Boost
                        'ob_image'                   => $product_option_value['ob_image'], //Q: Options Boost
                        'ob_sku_override'            => $product_option_value['ob_sku_override'], //Q: Options Boost
                    );
                }

                $product_option_data[] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'option_id'         => $product_option['option_id'],
                    'name'              => $product_option['name'],
                    'type'              => $product_option['type'],
                    'option_value'      => $product_option_value_data,
                    'required'          => $product_option['required']
                );
            } else {
                $product_option_data[] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'option_id'         => $product_option['option_id'],
                    'name'              => $product_option['name'],
                    'type'              => $product_option['type'],
                    'option_value'      => $product_option['option_value'],
                    'required'          => $product_option['required']
                );
            }
        }

        return $product_option_data;
    }

    //added
    public function getProductMp($product_id, $customer_group = 0, $customer_id, $store_id = 0, $language_id = 4) {

        //if (is_callable(array('ControllerJetcacheJetcache', 'hook_getProduct'))) {
        //	$this->controller_jetcache_jetcache->hook_getProduct($product_id);
        //}

        if ($customer_group) {
            $customer_group_id = $customer_group;
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < '" . date("Y-m-d") . "') AND (pd2.date_end = '0000-00-00' OR pd2.date_end > '" . date("Y-m-d") . "')) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < '" . date("Y-m-d") . "') AND (ps.date_end = '0000-00-00' OR ps.date_end > '" . date("Y-m-d") . "')) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$language_id . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$language_id . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$language_id . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$language_id . "' AND p.status = '1' AND p.date_available <= '" . date("Y-m-d") . "' AND p2s.store_id = '" . (int)$store_id . "'");

        $customer_price = 0;

        if ($customer_id && !empty($query->row['customer_price'])) {
            $customer_prices_arr = unserialize($query->row['customer_price']);
            foreach($customer_prices_arr as $val) {
                if($val['customer_id'] == $customer_id) {
                    $customer_price = $val['price'];
                }
            }
        }

        if ($query->num_rows) {
            return array(
                'product_id'       => $query->row['product_id'],
                'seo_title'        => $query->row['seo_title'],
                'seo_h1'           => $query->row['seo_h1'],
                'name'             => $query->row['name'],
                'description'      => $query->row['description'],
                'description_mini' => $query->row['description_mini'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword'     => $query->row['meta_keyword'], 'custom_title' => $query->row['custom_title'], 'custom_h1' => $query->row['custom_h1'], 'custom_alt' => $query->row['custom_alt'],
                'tag'              => $query->row['tag'],
                'model'            => $query->row['model'],
                'sku'              => $query->row['sku'],
                'upc'              => $query->row['upc'],
                'upc_more'         => $query->row['upc_more'],     // 150919 Имеются товары этой модели с другим ГТД
                'upc_quantity'     => $query->row['upc_quantity'], // 150919 Количество товара
                'ean'              => $query->row['ean'],
                'jan'              => $query->row['jan'],
                'isbn'             => $query->row['isbn'],
                'mpn'              => $query->row['mpn'],
                'location'         => $query->row['location'],
                'quantity'         => $query->row['quantity'],
                'stock_status'     => $query->row['stock_status'],
                'image'            => $query->row['image'],
                'manufacturer_id'  => $query->row['manufacturer_id'],
                'manufacturer'     => $query->row['manufacturer'],
                //'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
                //'special'          => $query->row['special'],
                'price'            => ($customer_price ? $customer_price :($query->row['discount'] ? $query->row['discount'] : $query->row['price'])), // added
                'special'          => $customer_price ? 0 : $query->row['special'],// added
                'reward'           => $query->row['reward'],
                'points'           => $query->row['points'],
                'tax_class_id'     => $query->row['tax_class_id'],
                'date_available'   => $query->row['date_available'],
                'weight'           => $query->row['weight'],
                'weight_class_id'  => $query->row['weight_class_id'],
                'length'           => $query->row['length'],
                'width'            => $query->row['width'],
                'height'           => $query->row['height'],
                'length_class_id'  => $query->row['length_class_id'],
                'subtract'         => $query->row['subtract'],
                'rating'           => round($query->row['rating']),
                'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
                'minimum'          => $query->row['minimum'],
                'sort_order'       => $query->row['sort_order'],
                'status'           => $query->row['status'],
                'date_added'       => $query->row['date_added'],
                'date_modified'    => $query->row['date_modified'],
                'viewed'           => $query->row['viewed']
            );
        } else {
            return false;
        }
    }
    //

	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getProductRewards($product_id) {
		$product_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $product_reward_data;
	}

	public function getProductDownloads($product_id) {
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}

		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $product_layout_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}
	
	public function getProductRelated2($product_id) {
		$product_related2_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related2 WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related2_data[] = $result['related_id'];
		}
		
		return $product_related2_data;
	}
	
	public function getArticleRelated($article_id) {
		$article_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_related_product WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['product_id'];
		}
		
		return $article_related_data;
	}

	public function getProfiles($product_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_profile` WHERE product_id = " . (int)$product_id)->rows;
	}	
	//ocshop benefits
	public function getBenefits($product_id) {
		
		$benefits = array();
	
		$query  =  $this->db->query("SELECT benefit_id FROM `" . DB_PREFIX . "product_to_benefit` WHERE product_id = " . (int)$product_id);
	
		foreach ($query->rows as $result) {
			$benefits[] = $result['benefit_id'];
		}
		
		return $benefits;
	}
	//ocshop benefits
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_upc_quantity']) && !is_null($data['filter_upc_quantity'])) {
			$sql .= " AND p.upc_quantity = '" . $this->db->escape($data['filter_upc_quantity']) . "'";
		}

        if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
            $sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
        }

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				
				$this->load->model('catalog/category');
				
				$categories = $this->model_catalog_category->getCategories($data['filter_category_id']);
				
				foreach ($categories as $category) {
					$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				    if ($data['filter_category_id'] == 'null') {
					$sql .= " AND p2c.category_id is null ";
				    } else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				    }
			}
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}	

	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}	

	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}	

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}


// added
	public function deleteStickers($agry) {

		$result = '';

		if(!empty($agry)) {

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_sticker");

			$result = 'ok';
		}

		return $result;
	}

    public function getPodStatus() {
        $extension_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `code` = 'myocpod'");

        return $extension_query->num_rows;
    }

    /**
     * @param $product_id
     * @param $model
     * @param $upc_quantity
     * @return mixed
     */
    public function setProductGtdQuantity($product_id, $model, $upc_quantity) {
        $quantity = $upc_quantity;

        $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$upc_quantity . "' WHERE product_id = '" . $product_id . "'");

        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id <> '" . $product_id . "' AND model = '" . $model . "' AND upc_quantity > '0' ORDER BY product_id");

        if ($product_query->num_rows) {
            foreach ($product_query->rows as $product) {
                $quantity += $product['upc_quantity'];
            }
        }

        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE model = '" . $model . "'");

        return $quantity;
    }

    /**
     * @param $product_id
     * @param $model
     * @param $quantity
     *
     * @return void
     */
    public function setProductQuantity($product_id, $model, $quantity) {
        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id <> '" . $product_id . "' AND model = '" . $model . "' AND upc_quantity > '0' ORDER BY product_id");

        if ($product_query->num_rows) {
            foreach ($product_query->rows as $product) {
                $quantity += $product['upc_quantity'];
            }
        }

        $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . (int)$quantity . "' WHERE model = '" . $model . "'");
    }

    /**
     * @param $product_id
     * @param $model
     *
     * @return void
     */
    public function setGroupProductQuantity($product_id, $model) {
        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id <> '" . $product_id . "' AND model = '" . $model . "' ORDER BY product_id");

        if ($product_query->num_rows) {
            foreach ($product_query->rows as $product) {
                $upc_quantity = 0;

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_id = '" . $product['product_id'] . "' AND pov.ob_quantity > '0' ORDER BY pov.ob_sku");

                if ($product_option_value_query->num_rows) {
                    foreach ($product_option_value_query->rows as $product_option_value) {
                        $upc_quantity += $product_option_value['ob_quantity'];
                    }
                }

                $this->db->query("UPDATE " . DB_PREFIX . "product SET upc_quantity = '" . (int)$upc_quantity . "' WHERE product_id = '" . $product['product_id'] . "'");
            }
        }
    }

    /**
     * @param $product_id
     * @param $sku
     * @param $quantity
     *
     * @return mixed
     */
    public function setGroupOptionQuantity($product_id, $sku, $quantity) {
        $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_id <> '" . $product_id . "' AND pov.ob_sku = '" . $sku . "' AND pov.ob_quantity > '0' ORDER BY pov.product_id");

        if ($product_option_value_query->num_rows) {
            foreach ($product_option_value_query->rows as $product_option_value) {
                $quantity += $product_option_value['ob_quantity'];
            }
        }

        $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = '" . (int)$quantity . "' WHERE ob_sku = '" . $sku . "'");

        return $quantity;
    }
//	
}

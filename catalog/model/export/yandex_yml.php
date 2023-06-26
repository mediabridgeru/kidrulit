<?php
class ModelExportYandexYml extends Model {
	private function isOldVersion() {
		$v = explode('.', VERSION);
		return $v[2] < 3;
	}

	public function getCategory() {
		$query = $this->db->query("SELECT cd.name, c.category_id, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' AND c.sort_order <> '-1'");

		return $query->rows;
	}

	public function getProduct($allowed_categories, $blacklist_type, $blacklist, $out_of_stock_id, $vendor_required = true, $allowed_manufacturers = '', $with_related = false) {
		$sql_blacklist = '';
		if ($blacklist) {
			$sql_blacklist = " AND ".($blacklist_type == 'black' ? "NOT" : "")."(p.product_id IN (" . $this->db->escape($blacklist) . "))";
		}
		$sql_seo_fields = '';
		$query = $this->db->query("SELECT
			p.*, pd.*, m.name AS manufacturer, p2c.category_id, IFNULL(pd2.price, p.price) AS price, ps.price AS special, wcd.unit AS weight_unit"
			. ($with_related ? ", GROUP_CONCAT(DISTINCT CAST(pr.related_id AS CHAR) SEPARATOR ',') AS rel " : "") . "
			FROM " . DB_PREFIX . "product p
			JOIN " . DB_PREFIX . "product_to_category AS p2c ON (p.product_id = p2c.product_id)
			LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ps.date_start < NOW() AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())
			LEFT JOIN " . DB_PREFIX . "product_discount pd2 ON (p.product_id = pd2.product_id) AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND pd2.date_start < NOW() AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())
			LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (p.weight_class_id = wcd.weight_class_id) AND wcd.language_id='" . (int)$this->config->get('config_language_id') . "'"
			. ($with_related ? "LEFT JOIN " . DB_PREFIX . "product_related pr ON (p.product_id = pr.product_id AND p.date_available <= NOW() AND p.status = '1')" : "") . "
			WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"
				.($allowed_categories ? " AND p2c.category_id IN (" . $this->db->escape($allowed_categories) . ")" : "")
				.$sql_blacklist
				.($allowed_manufacturers ? " AND p.manufacturer_id IN (" . $this->db->escape($allowed_manufacturers) . ")" : "") . "
				AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				AND p.date_available <= NOW() 
				AND p.status = '1'
				AND (p.quantity > '0' OR p.stock_status_id != '" . (int)$out_of_stock_id . "')
				GROUP BY p.product_id ORDER BY p.product_id");
		return $query->rows;
	}

	public function getProductImages($numpictures = 9) {
		$query = $this->db->query("SELECT product_id, image FROM " . DB_PREFIX . "product_image ORDER BY product_id".($this->isOldVersion() ? "" : ", sort_order"));
		$ret = array();
		foreach($query->rows as $row) {
			if (!isset($ret[$row['product_id']])) {
				$ret[$row['product_id']] = array();
			}
			if (count($ret[$row['product_id']]) < $numpictures)
				$ret[$row['product_id']][] = $row['image'];
		}
		return $ret;
	}

	public function getProductOptions($option_ids, $product_id) {
		$lang = (int)$this->config->get('config_language_id');
		
		$query = $this->db->query("SELECT pov.*, od.name AS option_name, ovd.name
			FROM " . DB_PREFIX . "product_option_value pov 
			LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id)
			LEFT JOIN " . DB_PREFIX . "option_description od ON (od.option_id = pov.option_id) AND (od.language_id = '$lang')
			WHERE pov.option_id IN (". implode(',', array_map('intval', $option_ids)) .") AND pov.product_id = '". (int)$product_id."'
				AND ovd.language_id = '$lang'");
		return $query->rows;
	}
	
	public function getAttributes($attr_ids) {
		if (!$attr_ids) return array();
		$query = $this->db->query("SELECT a.attribute_id, ad.name
			FROM " . DB_PREFIX . "attribute a
			LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id)
			WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
				AND a.attribute_id IN (" . $this->db->escape($attr_ids) . ")
				ORDER BY a.attribute_id, ad.name");
		$ret = array();
		foreach($query->rows as $row) {
			$ret[$row['attribute_id']] = $row['name'];
		}
		return $ret;
	}
	
	public function getProductAttributes($product_id) {
		$query = $this->db->query("SELECT pa.attribute_id, pa.text, ad.name
			FROM " . DB_PREFIX . "product_attribute pa
			LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (pa.attribute_id = ad.attribute_id)
			WHERE pa.product_id = '" . (int)$product_id . "'
				AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "'
				AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
				ORDER BY pa.attribute_id");
		return $query->rows;
	}

	public function getPodsOptions($product_option_id)
	{
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . $product_option_id . "'")->row;
	}

	public function getPods($product_option_value_id)
	{
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . $product_option_value_id . "'")->rows;
	}

	public function getProductDiscounts($product_id, $customer_group_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < '" . $this->NOW . "') AND (date_end = '0000-00-00' OR date_end > '" . $this->NOW . "')) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getOptionPrice($product, $option, $data)
	{
		$option_price = [];

		$pods_options = $this->getPodsOptions($option['product_option_id']);

		$pods = $this->getPods($option['product_option_value_id']);

		$product_discounts = $this->getProductDiscounts($product['product_id'], $data['customer_group_id']);

		foreach ($pods as $pod) {
			$customer_group_ids = unserialize($pod['customer_group_ids']);

			if ((!empty($customer_group_ids)) && ($customer_group_ids[0] != (string)$data['customer_group_id'])) {
				continue;
			}

			$quantity = $pod['quantity'];

			if ($product['special']) {
				$product_base_price = $product['special'];
			} else {
				$product_base_price = $product['price'];
				if ($product_discounts) {
					foreach ($product_discounts as $product_discount) {
						if ($quantity >= $product_discount['quantity']) {
							$product_base_price = $product_discount['price'];
						} else {
							break;
						}
					}
				}
			}

			if ($pod['calc_method'] === 'o' || $pod['calc_method'] === 'po') {
				$option_base_price = $option['price'];
				if ($option['price_prefix'] === '-') {
					$option_base_price *= -1;
				}
			} else {
				$option_base_price = 0;
			}

			if ($pods_options['flat_rate']) {
				$option_discount_price   = $pod['price'] / $quantity;
				$option_discount_special = $pod['special'] / $quantity;
				$product_total_price     = $product_base_price + ($option_base_price / $quantity);
			} else {
				$option_discount_price   = $pod['price'];
				$option_discount_special = $pod['special'];
				$product_total_price     = $product_base_price + $option_base_price;
			}

			$price_suffix = $special_suffix = '';

			switch ($pod['price_prefix']) {
				case '+':
					$final_price  = $product_total_price + $option_discount_price;
					$price_prefix = '+';
					break;
				case '-':
					$final_price  = $product_total_price - $option_discount_price;
					$price_prefix = '-';
					break;
				case '=':
					$final_price  = $option_discount_price;
					$price_prefix = '';
					break;
				case '+%':
					switch ($pod['calc_method']) {
						case 'p':
							$final_price = $product_total_price + ($product_base_price * $option_discount_price / 100);
							break;
						case 'po':
							$final_price = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_price / 100);
							break;
						default: //o
							$final_price = $product_total_price + ($option_base_price * $option_discount_price / 100);
							break;
					}
					$price_prefix = '+';
					$price_suffix = '%';
					break;
				case '-%':
					switch ($pod['calc_method']) {
						case 'p':
							$final_price = $product_total_price - ($product_base_price * $option_discount_price / 100);
							break;
						case 'po':
							$final_price = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_price / 100);
							break;
						default: //o
							$final_price = $product_total_price - ($option_base_price * $option_discount_price / 100);
							break;
					}
					$price_prefix = '-';
					$price_suffix = '%';
					break;
				default:
					$final_price  = $product_total_price + $option_discount_price;
					$price_prefix = '+';
					break;
			}
			switch ($pod['special_prefix']) {
				case '+':
					$final_special  = $product_total_price + $option_discount_special;
					$special_prefix = '+';
					break;
				case '-':
					$final_special = $product_total_price - $option_discount_special;
					if ($option_discount_special === 0) {
						$special_prefix = false;
					} else {
						$special_prefix = '-';
					}
					break;
				case '=':
					$final_special  = $option_discount_special;
					$special_prefix = '';
					break;
				case '+%':
					switch ($pod['calc_method']) {
						case 'p':
							$final_special = $product_total_price + ($product_base_price * $option_discount_special / 100);
							break;
						case 'po':
							$final_special = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_special / 100);
							break;
						default: //o
							$final_special = $product_total_price + ($option_base_price * $option_discount_special / 100);
							break;
					}
					$special_prefix = '+';
					$special_suffix = '%';
					break;
				case '-%':
					switch ($pod['calc_method']) {
						case 'p':
							$final_special = $product_total_price - ($product_base_price * $option_discount_special / 100);
							break;
						case 'po':
							$final_special = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_special / 100);
							break;
						default: //o
							$final_special = $product_total_price - ($option_base_price * $option_discount_special / 100);
							break;
					}
					$special_prefix = '-';
					$special_suffix = '%';
					break;
				default:
					$final_special  = $product_total_price + $option_discount_special;
					$special_prefix = '+';
					break;
			}

			if ($pods_options['show_final']) {
				$raw_price    = $final_price;
				$price_prefix = $price_suffix = '';
				$raw_special    = $final_special;
				$special_prefix = $special_prefix === false ? false : '';
				$special_suffix = $special_prefix === false ? false : '';
			} else {
				$raw_price   = $option_discount_price;
				$raw_special = $option_discount_special;
			}

			$extax       = $this->currency->format($raw_price);
			$extax_total = $this->currency->format($raw_price * $quantity);

			if ($price_suffix === '%') {
				$price       = number_format((float)$raw_price, 2);
				$extax       = false;
				$price_total = number_format((float)$raw_price * $quantity, 2);
				$extax_total = false;
			} elseif ((float)$raw_price) {
				$price = $this->currency->format($this->tax->calculate($raw_price, $product['tax_class_id'], $this->config->get('config_tax')));
				if ($pods_options['show_final']) {
					$price_total = $this->currency->format($this->tax->calculate($raw_price, $product['tax_class_id'], $this->config->get('config_tax')) * $quantity);
				} else {
					$price_total = $this->currency->format($this->tax->calculate($raw_price * $quantity, $product['tax_class_id'], $this->config->get('config_tax')));
				}
			} else {
				$tax_price = $this->tax->calculate($raw_price, $product['tax_class_id'], $this->config->get('config_tax'));
				if ($tax_price != 0 && $price_prefix == '-') {
					$price_prefix = '+';
				}
				$price       = $this->currency->format($tax_price);
				$price_total = $this->currency->format($tax_price * $quantity);
			}

			$special_extax       = $this->currency->format($raw_special);
			$special_extax_total = $this->currency->format($raw_special * $quantity);

			if ($special_prefix === false || ($pod['date_start'] != '0000-00-00' && $pod['date_start'] > date('Y-m-d')) || ($pod['date_end'] != '0000-00-00' && $pod['date_end'] < date('Y-m-d'))) {
				$special_price       = false;
				$special_extax       = false;
				$special_total       = false;
				$special_extax_total = false;
			} elseif ($special_suffix === '%') {
				$special_price       = number_format((float)$raw_special, 2);
				$special_extax       = false;
				$special_total       = number_format((float)$raw_special * $quantity, 2);
				$special_extax_total = false;
			} elseif ((float)$raw_special) {
				$special_price = $this->currency->format($this->tax->calculate($raw_special, $product['tax_class_id'], $this->config->get('config_tax')));
				if ($pods_options['show_final']) {
					$special_total = $this->currency->format($this->tax->calculate($raw_special, $product['tax_class_id'], $this->config->get('config_tax')) * $quantity);
				} else {
					$special_total = $this->currency->format($this->tax->calculate($raw_special * $quantity, $product['tax_class_id'], $this->config->get('config_tax')));
				}
			} else {
				$tax_special = $this->tax->calculate($raw_special, $product['tax_class_id'], $this->config->get('config_tax'));
				if ($tax_special != 0 && $special_prefix == '-') {
					$special_prefix = '+';
				}
				$special_price = $this->currency->format($tax_special);
				$special_total = $this->currency->format($tax_special * $quantity);
			}

			if ((float)$pod['special'] != 0) {
				$option_price = [
					'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false, 'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false, 'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false, 'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false, 'special' => ($special_price && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax)) ? $special_prefix . $special_price . $special_suffix : false, 'special_extax' => ($special_price && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax) ? $special_prefix . $special_extax . $special_suffix : false, 'special_total' => ($special_total && ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$special_extax_total)) ? $special_prefix . $special_total . $special_suffix : false, 'special_extax_total' => ($special_total && ($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $special_extax_total) ? $special_prefix . $special_extax_total . $special_suffix : false,
				];
			} else {
				$option_price = [
					'price' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax) ? $price_prefix . $price . $price_suffix : false, 'extax' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax) ? $price_prefix . $extax . $price_suffix : false, 'price_total' => ($pods_options['inc_tax'] === 'y' || $pods_options['inc_tax'] === 'both' || !$extax_total) ? $price_prefix . $price_total . $price_suffix : false, 'extax_total' => (($pods_options['inc_tax'] === 'n' || $pods_options['inc_tax'] === 'both') && $extax_total) ? $price_prefix . $extax_total . $price_suffix : false
				];
			}
		}

		return $option_price;
	}
}

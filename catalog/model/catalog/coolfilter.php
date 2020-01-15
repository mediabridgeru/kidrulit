<?php

class ModelCatalogCoolfilter extends Model {

	public function getOptionByCoolfilterGroupsId($coolfilter_group_id, $category_id) {
		
		$coolfilter_group_id = (int)$coolfilter_group_id;
		
		$options_data = array();
		
		if ($this->checkGroup($coolfilter_group_id, $category_id)) {
			
			$options_data = $this->cache->get('option.' . $coolfilter_group_id . '.' . $this->config->get('config_language_id'));

			if(!$options_data && !is_array($options_data)) {
			
				$query = $this->db->query("SELECT co.*, cod.*, stl.style_id, tp.type_index	FROM `" . DB_PREFIX . "category_option` co LEFT JOIN `" . DB_PREFIX . "category_option_description` cod ON (co.option_id = cod.option_id) LEFT JOIN `" . DB_PREFIX . "style_option` stl ON (co.option_id = stl.option_id) LEFT JOIN `" . DB_PREFIX . "type_option` tp ON (co.option_id = tp.option_id) WHERE co.option_id IN (SELECT option_id FROM `" . DB_PREFIX . "coolfilter_group_option_to_coolfilter_group` WHERE coolfilter_group_id = " . $coolfilter_group_id . ") AND co.status = 1 AND cod.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY co.sort_order");
				  
				$options_data = $query->rows;  
				
				$this->cache->set('option.' . $coolfilter_group_id . '.' . $this->config->get('config_language_id'), $options_data);

			}
			
		}
		return $options_data;
	
	}
  
	public function checkGroup ($coolfilter_group_id, $category_id) {
		$query = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "coolfilter_group_to_category` WHERE coolfilter_group_id = '" . (int)$coolfilter_group_id . "'");
		$group_categories = $query->rows;
		
		if (!empty($group_categories)) {
			$query = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "coolfilter_group_to_category` WHERE coolfilter_group_id = '" . (int)$coolfilter_group_id . "' AND category_id = '" . $category_id . "'");
			$group_categories = $query->rows;
			if (!empty($group_categories)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
  
	public function getManufacterItemNames($categories_id) {
		
		$categories_hash = md5($categories_id);
		
		$cache_data = $this->cache->get('get_manufacter_items_names.' . $categories_hash . '.' . $this->config->get('config_language_id'));
		
		if (!$cache_data && !is_array($cache_data)) {
		
			$query = $this->db->query("SELECT DISTINCT mnf.manufacturer_id as value, mnf.name, mnf.image FROM `" . DB_PREFIX . "manufacturer` mnf LEFT JOIN `" . DB_PREFIX . "product` as prd ON (mnf.manufacturer_id = prd.manufacturer_id) WHERE prd.product_id IN (SELECT product_id FROM `" . DB_PREFIX . "product_to_category` WHERE prd.status != '0' AND category_id IN (" . $this->db->escape($categories_id) . ")) ORDER BY mnf.name");
			
			$manufacters = $query->rows;
			
			$this->cache->set('get_manufacter_items_names.' . $categories_hash . '.' . $this->config->get('config_language_id'), $manufacters);
		}
		else {
			$manufacters = $cache_data;
		}
		
		return $manufacters;
	
	}
	
	public function getOptionItemNames($coolfilter_options_id, $categories_id) {
		
		$categories_hash = md5($categories_id);
		$cache_data = $this->cache->get('get_option_items_names.' . $coolfilter_options_id . '.' . $categories_hash . '.' . $this->config->get('config_language_id'));
		$cache_data = null;
		if (!$cache_data && !is_array($cache_data)) {
		
			$query = $this->db->query("SELECT DISTINCT prd.option_value_id as value, prd.option_id as id, opt.name, opv.image 
										FROM `" . DB_PREFIX . "product_option_value` prd LEFT JOIN `" . DB_PREFIX . "option_value_description` as opt ON (opt.option_value_id=prd.option_value_id 
										AND opt.option_value_id=prd.option_value_id) 
										LEFT JOIN `" . DB_PREFIX . "option_value` as opv ON (opv.option_value_id=prd.option_value_id) 
										WHERE prd.option_id IN (" . $this->db->escape($coolfilter_options_id) . ") AND opt.language_id = '" . (int)$this->config->get('config_language_id') . "' 
										AND prd.product_id IN (SELECT p2c.product_id 
										FROM `" . DB_PREFIX . "product_to_category` p2c 
										LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) 
										WHERE p.status != 0 AND p2c.category_id IN (" . $this->db->escape($categories_id) . ")) 
										ORDER BY opt.name");
			
			$options = $query->rows;
			$this->cache->get('get_option_items_names.' . $coolfilter_options_id . '.' . $categories_hash . '.' . $this->config->get('config_language_id'), $options);
		}
		else {
			$options = $cache_data;
		}
		
		return $options;
	
	}
	
	 public function getAttributeItemNames($coolfilter_attributes_id, $categories_id) {
			
		$query = $this->db->query("SELECT DISTINCT text as value, pa.attribute_id as id, text as name 
									FROM `" . DB_PREFIX . "product_attribute` pa WHERE pa.attribute_id IN (" . $this->db->escape($coolfilter_attributes_id) . ") 
									AND language_id = '" . (int)$this->config->get('config_language_id') . "' 
									AND pa.product_id IN (SELECT p2c.product_id FROM `" . DB_PREFIX . "product_to_category` p2c 
									LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) 
									WHERE p.status != 0 AND category_id IN (" . $this->db->escape($categories_id) . ")) ORDER BY text=0, -text DESC, text");
		
		return $query->rows;
	
	}
	
	
 public function getParametereItemNames($coolfilter_parameteres_id, $categories_id) {

			$sql = "SELECT DISTINCT f.filter_id as value, f.filter_group_id as id,  fd.name as name FROM `" . DB_PREFIX . "filter` f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) WHERE f.filter_group_id IN (" . $this->db->escape($coolfilter_parameteres_id) . ") AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order ";
			$query = $this->db->query($sql);
		
	
		return $query->rows;

	
	}
	
	public function getPriceItemNames($categories_id) {
			
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$query = $this->db->query("
			SELECT DISTINCT p.product_id,p.price 
			FROM `" . DB_PREFIX . "product` p 
			LEFT JOIN `" . DB_PREFIX . "product_to_category` pc 
			ON (p.product_id = pc.product_id) WHERE p.status = 1 AND pc.category_id IN (" . $this->db->escape($categories_id) . ") ");


		$products = $query->rows;
		
		if ($products) {
	
			$product_ids = array();
			
			foreach ($products as $product) {
				$product_ids[] = $product['product_id'];
			}
	
			$products_id_to_string = implode(",", $product_ids);
	
			$query = $this->db->query("
				SELECT DISTINCT pd.product_id,pd.price as discount 
				FROM `" . DB_PREFIX . "product` p 
				LEFT JOIN `" . DB_PREFIX . "product_discount` pd 
				ON (p.product_id = pd.product_id) 
				AND pd.quantity > 0
				AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) 
				AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) 
				WHERE p.product_id IN (" . $this->db->escape($products_id_to_string) . ")  
	        	ORDER BY pd.priority DESC, pd.price DESC ");
			$product_discounts = $query->rows;
	
			$query = $this->db->query("
				SELECT DISTINCT ps.product_id,ps.price as special 
				FROM `" . DB_PREFIX . "product` p  
				LEFT JOIN `" . DB_PREFIX . "product_special` ps 
				ON (p.product_id = ps.product_id) 
				AND ps.customer_group_id = '" . $customer_group_id . "' 
				AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
				AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))
				WHERE p.product_id IN (" . $this->db->escape($products_id_to_string) . ") 
				ORDER BY ps.priority DESC, ps.price DESC ");
			$product_specials = $query->rows;
	
	
	
			foreach ($products as $key => $product) {
				$product_id = $product['product_id'];
				foreach ($product_discounts as $product_discount) {
					if ($product_discount['product_id'] == $product_id) {
						$products[$key]['price'] = $product_discount['discount'];
					}
				}
				foreach ($product_specials as $product_special) {
					if ($product_special['product_id'] == $product_id) {
						$products[$key]['price'] = $product_special['special'];
					}
				}
			}
	
			$product_prices = array();
			
			foreach ($products as $product) {
				$product_prices[] = $product['price'];
			}
	
			$minprice = min($product_prices);
			$maxprice = max($product_prices);
			
		} else {
			$minprice = NULL;
			$maxprice = NULL;
		}	
			$prices_value = array(
				0 => array('name' => 'min_price',
						   'value'=> $minprice,
						   'image'=> ''),
				1 => array('name' => 'max_price',
						   'value'=> $maxprice,
						   'image'=> '')
			);
		
		
		return $prices_value;
	
	}
	
	
	private function getCategoryTree() {
	
		$cache_data = $this->cache->get('category_tree.' . $this->config->get('config_language_id'));
		
		if(!$cache_data && !is_array($cache_data)) {
			
			$query = $this->db->query("SELECT category_id,parent_id FROM `" . DB_PREFIX . "category` ORDER BY parent_id");
			$tree = $query->rows;
			
			$category_tree = array();
			
			foreach($tree as $brench) {
			
				$category_tree[$brench['parent_id']][] = $brench['category_id'];
			
			}
			
			$this->cache->set('category_tree.' . $this->config->get('config_language_id'), $category_tree);
			
		}else{	
			$category_tree = $cache_data; 
		}
		
		
		return $category_tree;
		
	}
	
	
	public function getChildrenCategorie($category_id) {
	
		
		$category_hash = md5($category_id);
		$cache_data = $this->cache->get('get_children_categorie.' . $category_hash . '.' . $this->config->get('config_language_id'));
		
		if(!$cache_data && !is_array($cache_data)) {
			$tree = $this->getCategoryTree();
			$categories = $this->getChildrenRec($category_id, $tree);
			
			$this->cache->set('get_children_categorie.' . $category_hash . '.' . $this->config->get('config_language_id'), $categories);
			
		}
		else {
			$categories = $cache_data;
		}
		
		return $categories;
	
	}
	
	private function getChildrenRec($category_id, $tree) {
		
		$categories = array();
		
		if ( !isset($tree[$category_id]) )
			return $categories;
			
		$level = $tree[$category_id];
		
		for ($i=0; $i < count($level); $i++) {
		
			$children_category_id = $level[$i];
			$categories[] = $children_category_id;
			
			if ( isset($tree[$children_category_id]) ){
				$categories = array_merge_recursive($categories, $this->getChildrenRec($children_category_id, $tree));
			}
			
		}
		
		return $categories;
	}
	
}

?>
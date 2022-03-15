<?php
class ModelMyocPod extends Model {
	public function copyOptionDiscount($source_product_id, $target_product_id) {
		if($target_product_id == $source_product_id) {
			return false;
		}
		$source_product_options_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$source_product_id . "'");
		$target_product_options_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$target_product_id . "'");
		$source_product_option_values_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$source_product_id . "'");
		$target_product_option_values_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$target_product_id . "'");
		
		if($source_product_options_query->num_rows) {
			foreach ($source_product_options_query->rows as $source_product_option) {
				$myoc_pod_setting_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod_setting` WHERE product_option_id = '" . (int)$source_product_option['product_option_id'] . "'");
				if($myoc_pod_setting_query->num_rows && $target_product_options_query->num_rows) {
					foreach ($target_product_options_query->rows as $target_product_option) {
						if($target_product_option['option_id'] == $source_product_option['option_id']) {
							$this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "myoc_pod_setting SET
								product_option_id = '" . (int)$target_product_option['product_option_id'] . "',
								show_price_product = '" . (int)$myoc_pod_setting_query->row['show_price_product'] . "',
								show_price_cart = '" . (int)$myoc_pod_setting_query->row['show_price_cart'] . "',
								show_final = '" . (int)$myoc_pod_setting_query->row['show_final'] . "',
								flat_rate = '" . (int)$myoc_pod_setting_query->row['flat_rate'] . "',
								cart_discount = '" . (int)$myoc_pod_setting_query->row['cart_discount'] . "',
								inc_tax = '" . $this->db->escape($myoc_pod_setting_query->row['inc_tax']) . "',
								table_style = '" . $this->db->escape($myoc_pod_setting_query->row['table_style']) . "',
								price_format = '" . $this->db->escape($myoc_pod_setting_query->row['price_format']) . "',
								qty_column = '" . (int)$myoc_pod_setting_query->row['qty_column'] . "',
								qty_format = '" . $this->db->escape($myoc_pod_setting_query->row['qty_format']) . "',
								stock_column = '" . (int)$myoc_pod_setting_query->row['stock_column'] . "',
								qty_cart = '" . (int)$myoc_pod_setting_query->row['qty_cart'] . "'");
						}
					}					
				}
			}
		}
		if($target_product_option_values_query->num_rows) {
			foreach ($target_product_option_values_query->rows as $target_product_option_value) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$target_product_option_value['product_option_value_id'] . "'");
			}
		}
		if($source_product_option_values_query->num_rows) {
			foreach ($source_product_option_values_query->rows as $source_product_option_value) {
				$myoc_pod_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod` WHERE product_option_value_id = '" . (int)$source_product_option_value['product_option_value_id'] . "'");
				if($myoc_pod_query->num_rows && $target_product_option_values_query->num_rows) {
					foreach ($target_product_option_values_query->rows as $target_product_option_value) {
						if($target_product_option_value['option_value_id'] == $source_product_option_value['option_value_id']) {
							foreach ($myoc_pod_query->rows as $myoc_pod) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "myoc_pod SET
									product_option_value_id = '" . (int)$target_product_option_value['product_option_value_id'] . "',
									customer_group_ids = '" . $this->db->escape($myoc_pod['customer_group_ids']) . "',
									quantity = '" . (int)$myoc_pod['quantity'] . "',
									calc_method = '" . $this->db->escape($myoc_pod['calc_method']) . "',
									price = '" . (float)$myoc_pod['price'] . "',
									price_prefix = '" . $this->db->escape($myoc_pod['price_prefix']) . "',
									special = '" . (float)$myoc_pod['special'] . "',
									special_prefix = '" . $this->db->escape($myoc_pod['special_prefix']) . "',
									option_base_points = '" . (int)$myoc_pod['option_base_points'] . "',
									points = '" . (int)$myoc_pod['points'] . "',
									points_prefix = '" . $this->db->escape($myoc_pod['points_prefix']) . "',
									priority = '" . (int)$myoc_pod['priority'] . "',
									date_start = '" . $this->db->escape($myoc_pod['date_start']) . "',
									date_end = '" . $this->db->escape($myoc_pod['date_end']) . "'");
							}
						}
					}
				}
			}
		}
	}
	public function copyOption($source_product_id, $target_product_id) {
		if($target_product_id == $source_product_id) {
			return false;
		}
		$product_options_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` WHERE product_id = '" . (int)$source_product_id . "'");
		$product_option_values_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE product_id = '" . (int)$source_product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$target_product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$target_product_id . "'");
		
		if($product_options_query->num_rows) {
			foreach ($product_options_query->rows as $product_option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET
					product_id = '" . (int)$target_product_id . "',
					option_id = '" . (int)$product_option['option_id'] . "',
					option_value = '" . $this->db->escape($product_option['option_value']) . "',
					required = '" . (int)$product_option['required'] . "'");

				$product_option_id = $this->db->getLastId();

				if($product_option_values_query->num_rows) {
					foreach ($product_option_values_query->rows as $product_option_value) {
						if($product_option_value['product_option_id'] == $product_option['product_option_id']) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET
								product_option_id = '" . (int)$product_option_id . "',
								product_id = '" . (int)$target_product_id . "',
								option_id = '" . (int)$product_option_value['option_id'] . "',
								option_value_id = '" . (int)$product_option_value['option_value_id'] . "',
								quantity = '" . (int)$product_option_value['quantity'] . "',
								subtract = '" . $this->db->escape($product_option_value['subtract']) . "',
								price = '" . (float)$product_option_value['price'] . "',
								price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "',
								points = '" . (int)$product_option_value['points'] . "',
								points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "',
								weight = '" . (float)$product_option_value['weight'] . "',
								weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						}
					}
				}
			}
		}
	}
	public function installTable()
	{
		$this->upgradeTable();
  		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "myoc_pod` (
			`pod_id` int(11) NOT NULL AUTO_INCREMENT,
			`product_option_value_id` int(11) NOT NULL,
			`customer_group_ids` TEXT NOT NULL,
			`quantity` int(11) NOT NULL,
			`calc_method` ENUM('p', 'po', 'o') NOT NULL DEFAULT 'p',
			`price` decimal(15,2) NOT NULL DEFAULT '0.00',
			`price_prefix` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+',
			`special` decimal(15,2) NOT NULL DEFAULT '0.00',
			`special_prefix` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
			`option_base_points` tinyint(1) NOT NULL DEFAULT '0',
			`points` int(8) NOT NULL DEFAULT '0',
			`points_prefix` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+',
			`priority` int(5) NOT NULL DEFAULT '1',
			`date_start` date NOT NULL DEFAULT '0000-00-00',
			`date_end` date NOT NULL DEFAULT '0000-00-00',
			PRIMARY KEY (`pod_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;");
  		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "myoc_pod_setting` (
			`product_option_id` int(11) NOT NULL,
			`show_price_product` tinyint(1) NOT NULL,
			`show_price_cart` tinyint(1) NOT NULL,
			`show_final` tinyint(1) NOT NULL,
			`flat_rate` tinyint(1) NOT NULL,
			`cart_discount` tinyint(1) NOT NULL DEFAULT '0',
			`inc_tax` enum('y','n','both') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
			`table_style` enum('h','v') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'h',
			`price_format` enum('unit','total','both') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'total',
			`qty_column` tinyint(1) NOT NULL DEFAULT '1',
			`qty_format` enum('single','range') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single',
			`stock_column` tinyint(1) NOT NULL DEFAULT '0',
			`qty_cart` tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`product_option_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
  		$this->db->query("INSERT IGNORE INTO `" . DB_PREFIX . "myoc_pod_setting` (
			`product_option_id`,
			`show_price_product`,
			`show_price_cart`,
			`show_final`,
			`flat_rate`,
			`cart_discount`,
			`inc_tax`,
			`table_style`,
			`price_format`,
			`qty_column`,
			`qty_format`,
			`stock_column`,
			`qty_cart`)
			SELECT `product_option_id`,1,1,0,0,0,'y','h','total',1,'single',0,0 FROM `" . DB_PREFIX . "product_option`;");
	}

	public function uninstallTable()
	{
		$this->db->query("DROP TABLE IF EXISTS 
			`" . DB_PREFIX . "myoc_pod`,
			`" . DB_PREFIX . "myoc_pod_setting`;");
	}

	public function upgradeTable()
	{
		//from v1.2.1
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_value_discount'");
		if($query->num_rows)
		{
			$this->db->query("RENAME TABLE  `" . DB_PREFIX . "product_option_value_discount` TO  `" . DB_PREFIX . "myoc_product_option_value_discount` ;");
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "myoc_product_option` (
			  `product_option_id` int(11) NOT NULL,
			  `show_price` TINYINT( 1 ) NOT NULL,
			  `show_final` TINYINT( 1 ) NOT NULL,
			  `flat_rate` TINYINT( 1 ) NOT NULL,
			  PRIMARY KEY (`product_option_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
			$this->db->query("INSERT INTO " . DB_PREFIX . "myoc_product_option SELECT `product_option_id`,`show_price`,`show_final`,`flat_rate` FROM " . DB_PREFIX . "product_option");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "product_option` DROP `show_price`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "product_option` DROP `show_final`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "product_option` DROP `flat_rate`");
		}

		//from v1.3.1
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "myoc_product_option_value_discount'");
		if($query->num_rows)
		{
			$this->db->query("RENAME TABLE  `" . DB_PREFIX . "myoc_product_option_value_discount` TO  `" . DB_PREFIX . "myoc_pod` ;");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `product_option_value_discount_id` `pod_id` INT(11) NOT NULL AUTO_INCREMENT");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `quantity` `quantity` INT(11) NOT NULL");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `priority` `priority` INT(5) NOT NULL DEFAULT '1' AFTER `points_prefix`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` ADD `option_base_price` TINYINT(1) NOT NULL DEFAULT '0' AFTER `quantity`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `price_prefix` `price_prefix` VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+'");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` ADD `special` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `price_prefix`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` ADD `special_prefix` VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-' AFTER `special`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` ADD `option_base_points` TINYINT(1) NOT NULL DEFAULT '0' AFTER `special_prefix`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `points` `points` INT(8) NOT NULL DEFAULT '0' AFTER `option_base_points`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod` CHANGE `points_prefix` `points_prefix` VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+'");

			$this->db->query("RENAME TABLE  `" . DB_PREFIX . "myoc_product_option` TO  `" . DB_PREFIX . "myoc_pod_setting` ;");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod_setting` CHANGE `show_price` `show_price_product` TINYINT( 1 ) NOT NULL");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod_setting` ADD `show_price_cart` TINYINT( 1 ) NOT NULL AFTER `show_price_product`");
			$this->db->query("ALTER TABLE  `" . DB_PREFIX . "myoc_pod_setting` ADD `table_style` ENUM('h','v') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'h',
				ADD `price_format` ENUM('unit','total','both') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'total',
				ADD `qty_column` TINYINT( 1 ) NOT NULL DEFAULT '1',
				ADD `qty_cart` TINYINT( 1 ) NOT NULL DEFAULT '0'");
		}

		//from v1.4
		$status = true;
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "myoc_pod_setting'");
		if($query->num_rows)
		{
			$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "myoc_pod_setting`;");
			foreach ($query->rows as $column_data) {
				if($column_data['Field'] == 'qty_format')
				{
					$status = false;
					break;
				}
			}
			if($status) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod_setting` ADD `qty_format` enum('single','range') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single'");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod_setting` ADD `stock_column` tinyint(1) NOT NULL DEFAULT '0'");
			}
		}

		//from v1.5 to v1.5.1
		$status = true;
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "myoc_pod_setting'");
		if($query->num_rows)
		{
			$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "myoc_pod_setting`;");
			foreach ($query->rows as $column_data) {
				if($column_data['Field'] == 'inc_tax')
				{
					$status = false;
					break;
				}
			}
			if($status) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod_setting` ADD `inc_tax` enum('y','n','both') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y' AFTER `flat_rate`");
			}
		}

		//from v1.5 to v1.5.1
		$status = true;
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "myoc_pod_setting'");
		if($query->num_rows)
		{
			$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "myoc_pod_setting`;");
			foreach ($query->rows as $column_data) {
				if($column_data['Field'] == 'cart_discount')
				{
					$status = false;
					break;
				}
			}
			if($status) {
				$pods = $this->db->query("SELECT * FROM `" . DB_PREFIX . "myoc_pod`;");

				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod_setting` ADD `cart_discount` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `flat_rate`;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod` CHANGE  `customer_group_id`  `customer_group_ids` TEXT NOT NULL ;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod` ADD  `calc_method` ENUM(  'p',  'po',  'o' ) NOT NULL DEFAULT  'p' AFTER  `quantity` ;");
				
				if($pods->num_rows) {
					foreach ($pods->rows as $row) {
						$calc_method = $row['option_base_price'] == 1 ? 'o' : 'p';
						$this->db->query("UPDATE  `" . DB_PREFIX . "myoc_pod` SET `customer_group_ids` = '" . $this->db->escape(serialize(array($row['customer_group_id']))) . "', `calc_method` =  '" . $calc_method . "' WHERE `pod_id` = '" . (int)$row['pod_id'] . "';");
					}
				}

				$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_pod` DROP `option_base_price`;");
			}
		}
	}
}
?>
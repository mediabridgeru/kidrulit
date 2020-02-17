<?php

class ModelXlsPricelistHelperModels extends Model
{

    public function getCustomerGroup($customer_group_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");

        return $query->row;
    }

    public function getCustomerGroup1($customer_group_id, $language_id) {
        //$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "'"); /// �� ����� ���� ���������� ����� �� ����� �� ����� �� ����������� � CMS. ��� ��� �������� ���� ������.
        return $query->row;
    }

    public function getCustomerGroups() {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

    public function getCategoryLevel($category_id, $level = 0, $language_id) {
        $query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$language_id . "' ORDER BY c.sort_order, cd.name ASC");
        if ($query->row['parent_id']) {
            $level++;

            return $this->getCategoryLevel($query->row['parent_id'], $level, $language_id);
        } else {
            return $level;
        }
    }

    public function getCategoryPath($category_id, $path = [], $language_id) {
        $path[] = $category_id;
        $query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$language_id . "' ORDER BY c.sort_order, cd.name ASC");

        if ($query->row['parent_id']) {
            return $this->getCategoryPath($query->row['parent_id'], $path, $language_id);
        } else {
            $path = array_reverse($path);

            return implode('_', $path);
        }
    }

    public function getProduct($product_id, $customer_group_id = '', $language_id) {
        if (empty($customer_group_id)) {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$language_id . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$language_id . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$language_id . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$language_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
        //echo "SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$language_id . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$language_id . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$language_id . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$language_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";exit;

        if ($query->num_rows) {
            if (is_array($customer_group_id)) {
                foreach ($customer_group_id as $gid) {
                    //$discount = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = $product_id AND pd2.customer_group_id = '" . (int)$gid . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1");
                    $discount = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = $product_id AND ps.customer_group_id = '" . (int)$gid . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1");
                    if ($discount->num_rows) {
                        $query->row['price_gid'][$gid] = $discount->row['price'];
                    } else {
                        $query->row['price_gid'][$gid] = $query->row['price'];
                    }

                    $special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = $product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1");
                    if ($special->num_rows) {
                        $query->row['special_gid'][$gid] = $special->row['price'];
                    } else {
                        $query->row['special_gid'][$gid] = false;
                    }
                }
            } else {
                $discount = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = $product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1");
                if ($discount->num_rows) {
                    $query->row['price_gid'][$customer_group_id] = $discount->row['price'];
                } else {
                    $query->row['price_gid'][$customer_group_id] = $query->row['price'];
                }
            }
            //() AS discount
            //(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special
            //(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward
            //$query->row['price'] = ($query->row['discount'] ? $query->row['discount'] : $query->row['price']);
            $query->row['rating'] = (int)$query->row['rating'];

            return $query->row;
        } else {
            return false;
        }
    }

    public function getProducts($data = []) {

        if (!empty($data['customer_group_id'])) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $language_id = $data['language_id'];
        $cache = md5(http_build_query($data));

        $product_data = $this->cache->get('product.' . (int)$language_id . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache);

        if (!$product_data) {
            $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
            if (!empty($data['filter_tag'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id)";
            }
            if (!empty($data['filter_category_id'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
            }
            $sql .= " WHERE pd.language_id = '" . (int)$language_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
            if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
                $sql .= " AND (";
                if (!empty($data['filter_name'])) {
                    $implode = [];
                    $words = explode(' ', $data['filter_name']);
                    foreach ($words as $word) {
                        if (!empty($data['filter_description'])) {
                            $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                        } else {
                            $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                        }
                    }
                    if ($implode) {
                        $sql .= " " . implode(" OR ", $implode) . "";
                    }
                }
                if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                    $sql .= " OR ";
                }
                if (!empty($data['filter_tag'])) {
                    $implode = [];
                    $words = explode(' ', $data['filter_tag']);
                    foreach ($words as $word) {
                        $implode[] = "LCASE(pt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND pt.language_id = '" . (int)$language_id . "'";
                    }
                    if ($implode) {
                        $sql .= " " . implode(" OR ", $implode) . "";
                    }
                }
                $sql .= ")";
            }

            if (!empty($data['filter_category_id'])) {
                if (!empty($data['filter_sub_category'])) {
                    $implode_data = [];
                    $implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                    $this->load->model('catalog/category');
                    $categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
                    foreach ($categories as $category_id) {
                        $implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
                    }
                    $sql .= " AND (" . implode(' OR ', $implode_data) . ")";
                } else {
                    if (!empty($data['filter_dubles'])) {
                        $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "' AND p2c.main_category = '1'";
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
                'pd.name', 'p.model', 'p.quantity', 'p.price', 'rating', 'p.sort_order', 'p.date_added',
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                    $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
                } else {
                    $sql .= " ORDER BY " . $data['sort'];
                }
            } else {
                $sql .= " ORDER BY p.sort_order";
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

            $product_data = [];
            $query = $this->db->query($sql);
            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id'], $customer_group_id, $language_id);
            }

            $this->cache->set('product.' . (int)$language_id . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $product_data);
        }

        return $product_data;
    }

    public function getProductOptions($product_id, $language_id) {
        $product_option_data = [];

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN " . DB_PREFIX . "option o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$language_id . "' ORDER BY o.sort_order");

        if ($product_option_query->num_rows) {
            foreach ($product_option_query->rows as $product_option) {
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                    $product_option_value_data = [];

                    $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$language_id . "' ORDER BY ov.sort_order");

                    if ($product_option_value_query->num_rows) {
                        foreach ($product_option_value_query->rows as $product_option_value) {
                            $product_option_value_data[] = array(
                                'product_option_value_id' => $product_option_value['product_option_value_id'], 'option_value_id' => $product_option_value['option_value_id'], 'name' => $product_option_value['name'], 'image' => $product_option_value['ob_image'], 'quantity' => $product_option_value['quantity'], 'subtract' => $product_option_value['subtract'], 'price' => $product_option_value['price'], 'price_prefix' => $product_option_value['price_prefix'], 'weight' => $product_option_value['weight'], 'weight_prefix' => $product_option_value['weight_prefix'], 'sku' => $product_option_value['ob_sku'],
                            );
                        }
                    }

                    $product_option_data[] = array(
                        'product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'option_value' => $product_option_value_data, 'required' => $product_option['required'],
                    );

                } else {
                    $product_option_data[] = array(
                        'product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'option_value' => $product_option['option_value'], 'required' => $product_option['required'],
                    );
                }
            }
        }

        return $product_option_data;
    }

    public function getProductAttributes($product_id, $language_id) {
        $product_attribute_group_data = [];

        $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$language_id . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

        if ($product_attribute_group_query->num_rows) {
            foreach ($product_attribute_group_query->rows as $product_attribute_group) {
                $product_attribute_data = [];
                $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$language_id . "' AND pa.language_id = '" . (int)$language_id . "' ORDER BY a.sort_order, ad.name");
                foreach ($product_attribute_query->rows as $product_attribute) {
                    $product_attribute_data[] = array(
                        'attribute_id' => $product_attribute['attribute_id'], 'name' => $product_attribute['name'], 'text' => $product_attribute['text'],
                    );
                }
                $product_attribute_group_data[] = array(
                    'attribute_group_id' => $product_attribute_group['attribute_group_id'], 'name' => $product_attribute_group['name'], 'attribute' => $product_attribute_data,
                );
            }
        }

        return $product_attribute_group_data;
    }

    public function getCategory($category_id, $language_id) {
        return $this->getCategories((int)$category_id, 'by_id', $language_id);
    }

    public function getCategories($id = 0, $type = 'by_parent', $language_id) {
        $data = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$language_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1' ORDER BY c.parent_id, c.sort_order, cd.name");

        foreach ($query->rows as $row) {
            $data['by_id'][$row['category_id']] = $row;
            $data['by_parent'][$row['parent_id']][] = $row;
        }

        return ((isset($data[$type]) && isset($data[$type][$id])) ? $data[$type][$id] : []);
    }

    public function getPods() {
        $pods = [];
        
        $pod_setting_query = $this->db->query("SELECT pods.*,po.product_id FROM " . DB_PREFIX . "myoc_pod_setting pods LEFT JOIN " . DB_PREFIX . "product_option po ON (po.product_option_id = pods.product_option_id)");

        if ($pod_setting_query->num_rows) {
            foreach ($pod_setting_query->rows as $pod_setting) {
                if (!isset($pods[$pod_setting['product_option_id']])) {
                    $pods[$pod_setting['product_option_id']] = array(
                        'show_price_product' => $pod_setting['show_price_product'], 'show_price_cart' => $pod_setting['show_price_cart'], 'show_final' => $pod_setting['show_final'], 'table_style' => $pod_setting['table_style'], 'price_format' => $pod_setting['price_format'], 'qty_column' => $pod_setting['qty_column'], 'qty_format' => $pod_setting['qty_format'], 'stock_column' => $pod_setting['stock_column'], 'qty_cart' => $pod_setting['qty_cart'], 'flat_rate' => $pod_setting['flat_rate'], 'cart_discount' => $pod_setting['cart_discount'], 'inc_tax' => $pod_setting['inc_tax'], 'product_id' => $pod_setting['product_id'], 'quantities' => [], 'pods' => [],
                    );
                }
                $pod_query = $this->db->query("SELECT pod.* FROM " . DB_PREFIX . "myoc_pod pod LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_option_value_id = pod.product_option_value_id) WHERE pov.product_option_id = '" . (int)$pod_setting['product_option_id'] . "' ORDER BY pod.priority, pod.quantity");
                if ($pod_query->num_rows) {
                    foreach ($pod_query->rows as $pod) {
                        $customer_group_id = unserialize($pod['customer_group_ids']);
                        if (!isset($pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']])) {
                            $pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']] = [];
                        }
                        $pods[$pod_setting['product_option_id']]['pods'][$pod['product_option_value_id']][$customer_group_id[0]] = $pod;
                    }
                }
            }
        }

        return $pods;
    }

    /**
     * @param $product_id
     * @return array
     */
    public function getProductRelated2($product_id) {
        $related = [];

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related2 pr2 LEFT JOIN " . DB_PREFIX . "product p ON (pr2.related_id = p.product_id) WHERE pr2.product_id = '" . (int)$product_id . "' ORDER BY pr2.related_id ASC");

        if ($query->num_rows) {
            foreach ($query->rows as $result) {
                $related[$result['related_id']] = $result['model'];
            }
        }

        return $related;
    }
}
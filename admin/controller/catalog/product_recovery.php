<?php
class ControllerCatalogProductRecovery extends Controller {
    public function index() {
        $this->language->load('catalog/product');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $data = array(
            'filter_category_id' => 0,
            'filter_filter' => '',
            'sort' => 'p.sort_order',
            'order' => 'ASC',
            'start' => 0,
            'limit' => 10000,
            'coolfilter' => ''
        );

        $results = $this->model_catalog_product->getProducts($data);

        $simple_products = [];
        $option_products = [];
        $simple_gtd_products = [];
        $option_gtd_products = [];
        $negative_products = [];

        if ($results) {
            foreach ($results as $result) {
                $product_id = $result['product_id'];
                $upc_more = (int)$result['upc_more']; // включена галка Имеются товары этой модели с другим ГТД
                $href = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL');

                $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

                if (!empty($product_options)) {
                    foreach ($product_options as $product_option) {
                        if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {

                            if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0) {
                                $product_option_quantity = 0; // количество в опции товара

                                foreach ($product_option['product_option_value'] as $product_option_value) {
                                    if ($product_option_value['quantity'] < 0 || $product_option_value['ob_quantity'] < 0) {
                                        $negative_products[] = [
                                            'product_id' => $product_id,
                                            'model' => $result['model'],
                                            'gtd' => (($upc_more)?1:0),
                                            'description' => 'Количество в опции '.$product_option_value['ob_sku'].' отрицательное',
                                            'product_quantity' => $product_option_value['ob_quantity'],
                                            'quantity' => $product_option_value['quantity'],
                                            'href' => $href,
                                        ];
                                    }

                                    if ($upc_more) {
                                        $error_quantity = $this->checkGroupOptionValueQuantity($product_option_value['ob_sku'], $product_option_value['ob_quantity']);
                                        if ($error_quantity) {
                                            $option_gtd_products[] = [
                                                'product_id' => $product_id,
                                                'model' => $result['model'],
                                                'gtd' => (($upc_more)?1:0),
                                                'description' => $product_option_value['ob_sku'],
                                                'product_quantity' => $product_option_value['ob_quantity'],
                                                'quantity' => $product_option_value['quantity'],
                                                'href' => $href,
                                            ];
                                        }
                                    } else {
                                        if ($product_option_value['quantity'] != $product_option_value['ob_quantity']) {
                                            $option_products[] = [
                                                'product_id' => $product_id,
                                                'model' => $result['model'],
                                                'gtd' => (($upc_more)?1:0),
                                                'description' => 'Количество в опции '.$product_option_value['ob_sku'].' не равно количеству в группе опции',
                                                'product_quantity' => $product_option_value['ob_quantity'],
                                                'quantity' => $product_option_value['quantity'],
                                                'href' => $href,
                                            ];
                                        }
                                    }

                                    $product_option_quantity += (int)$product_option_value['ob_quantity'];
                                }

                                if ($upc_more) {

                                } else {
                                    if ($result['upc_quantity'] != $product_option_quantity) {
                                        $option_products[] = [
                                            'product_id' => $product_id,
                                            'model' => $result['model'],
                                            'gtd' => (($upc_more)?1:0),
                                            'description' => 'Сумма опций в товаре '.$product_option_quantity.' не равна количеству товара',
                                            'product_quantity' => $result['upc_quantity'],
                                            'quantity' => $result['quantity'],
                                            'href' => $href,
                                        ];
                                    }

                                    if ($result['quantity'] != $product_option_quantity) {
                                        $option_products[] = [
                                            'product_id' => $product_id,
                                            'model' => $result['model'],
                                            'gtd' => (($upc_more)?1:0),
                                            'description' => 'Сумма опций в товаре '.$product_option_quantity.' не равна количеству товара в группе',
                                            'product_quantity' => $result['upc_quantity'],
                                            'quantity' => $result['quantity'],
                                            'href' => $href,
                                        ];
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($result['quantity'] < 0 || $result['upc_quantity'] < 0) { // Сумма товаров в группе не равно количество товара в группе в данном товаре
                        $negative_products[] = [
                            'product_id' => $product_id,
                            'model' => $result['model'],
                            'gtd' => (($upc_more)?1:0),
                            'description' => 'Количество товаров отрицательное',
                            'product_quantity' => $result['upc_quantity'],
                            'quantity' => $result['quantity'],
                            'href' => $href,
                        ];
                    }

                    if ($upc_more) {
                        $product_quantity = $this->getProductQuantityByModel($result['model']);

                        if ($product_quantity != $result['quantity']) { // Сумма товаров в группе не равно количество товара в группе в данном товаре
                            $simple_gtd_products[] = [
                                'product_id' => $product_id,
                                'model' => $result['model'],
                                'gtd' => (($upc_more)?1:0),
                                'description' => 'Сумма товаров в группе '.$product_quantity,
                                'product_quantity' => $result['upc_quantity'],
                                'quantity' => $result['quantity'],
                                'href' => $href,
                            ];
                        }
                    } else {
                        $product_quantity = $result['upc_quantity'];

                        if ($product_quantity != $result['quantity']) { // Сумма товаров в группе не равно количество товара в группе в данном товаре
                            $simple_products[] = [
                                'product_id' => $product_id,
                                'model' => $result['model'],
                                'gtd' => (($upc_more)?1:0),
                                'description' => 'Сумма товаров в группе '.$product_quantity,
                                'product_quantity' => $result['upc_quantity'],
                                'quantity' => $result['quantity'],
                                'href' => $href,
                            ];
                        }
                    }
                }
            }
        }

        $this->data['negative_products'] = $negative_products;
        $this->data['simple_products'] = $simple_products;
        $this->data['option_products'] = $option_products;
        $this->data['simple_gtd_products'] = $simple_gtd_products;
        $this->data['option_gtd_products'] = $option_gtd_products;

        $this->getForm();
    }

    protected function getForm() {
        $this->data['heading_title'] = 'Проверка количества товаров в группах';

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_plus'] = $this->language->get('text_plus');
        $this->data['text_minus'] = $this->language->get('text_minus');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
        $this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_option'] = $this->language->get('text_option');
        $this->data['text_option_value'] = $this->language->get('text_option_value');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_percent'] = $this->language->get('text_percent');
        $this->data['text_amount'] = $this->language->get('text_amount');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_apply'] = $this->language->get('button_apply');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['token'] = $this->session->data['token'];

        $this->template = 'catalog/product_recovery.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    /**
     * @param $model
     *
     * @return int
     */
    public function getProductQuantityByModel($model) {
        $quantity = 0;

        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE model = '" . $model . "' AND upc_quantity > '0' ORDER BY product_id");

        if ($product_query->num_rows) {
            foreach ($product_query->rows as $product) {
                $quantity += $product['upc_quantity'];
            }
        }

        return $quantity;
    }

    /**
     * @param $product_id
     * @param $model
     * @param $upc_quantity
     *
     * @return void
     */
    public function setProductQuantity($product_id, $model, $upc_quantity) {
        $quantity = $upc_quantity;

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
     * @param $sku
     * @param $quantity
     *
     * @return mixed
     */
    public function checkGroupOptionValueQuantity($sku, $quantity) {
        $ob_quantity = 0;

        $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE pov.ob_sku = '" . $sku . "' AND pov.ob_quantity > '0' ORDER BY pov.product_id");

        if ($product_option_value_query->num_rows) {
            foreach ($product_option_value_query->rows as $product_option_value) {
                $ob_quantity += $product_option_value['ob_quantity'];
            }
        }

        $res = ((int)$quantity == $ob_quantity) ? 0 : 1;

        return $res;
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
}
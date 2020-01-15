<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['wishlist']);

			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle($this->language->get('heading_title'));	

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/wishlist'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');	

		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_stock'] = $this->language->get('column_stock');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['products'] = array();

		foreach ($this->session->data['wishlist'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                } else {
                    $image = false;
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                $product_discounts = $this->model_catalog_product->getProductDiscounts($product_id);
                $product_options = $this->model_catalog_product->getProductOptions($product_id);

                $quantity = 0;
                $option_quantity = false;

                if (!empty($product_options)) {
                    foreach ($product_options as $product_option) {
                        $product_option_id = $product_option['product_option_id'];

                        if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                            $option_value = current($product_option['option_value']);

                            $pods = $this->myocpod->getPod($product_option_id);

                            if($pods) {
                                $quantities = $pods['quantities'];

                                sort($quantities);

                                if($product_option['product_option_id'] == $product_option_id && is_array($product_option['option_value'])) {

                                    $option_discount_data = $product_option_value_data = array();
                                    $ranges = array();

                                    $prev_pod = $option_value;
                                    $prev_pod['calc_method'] = 'p';
                                    $prev_pod['special'] = 0;
                                    $prev_pod['special_prefix'] = '-';

                                    foreach ($quantities as $quantity) {

                                        foreach ($pods['pods'] as $pod) {
                                            if(isset($pod[$quantity]) && $pod[$quantity]['product_option_value_id'] == $option_value['product_option_value_id']) {
                                                $pod = $pod[$quantity];
                                                $prev_pod = $pod;
                                            } else {
                                                $pod = $prev_pod;
                                            }

                                            $pod['quantity'] = $quantity;

                                            if($product_info['special']) {
                                                $product_base_price = $product_info['special'];
                                            } else {
                                                $product_base_price = $product_info['price'];

                                                if($product_discounts) {
                                                    foreach ($product_discounts as $product_discount) {
                                                        if($quantity >= $product_discount['quantity']) {
                                                            $product_base_price = $product_discount['price'];
                                                        } else {
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                            if($pod['calc_method'] == 'o' || $pod['calc_method'] == 'po') {

                                                $option_base_price = $option_value['price'];

                                                if($option_value['price_prefix'] == '-') {
                                                    $option_base_price *= -1;
                                                }
                                            } else {
                                                $option_base_price = 0;
                                            }

                                            if($pods['flat_rate']) {
                                                $option_discount_price = $pod['price'] / $quantity;
                                                $option_discount_special = $pod['special'] / $quantity;
                                                $product_total_price = $product_base_price + ($option_base_price / $quantity);
                                            } else {
                                                $option_discount_price = $pod['price'];
                                                $option_discount_special = $pod['special'];
                                                $product_total_price = $product_base_price + $option_base_price;
                                            }

                                            $price_suffix =
                                            $special_suffix = '';

                                            switch ($pod['price_prefix']) {
                                                case '+':
                                                    $final_price = $product_total_price + $option_discount_price;
                                                    $price_prefix = '+';
                                                    break;
                                                case '-':
                                                    $final_price = $product_total_price - $option_discount_price;
                                                    $price_prefix = '-';
                                                    break;
                                                case '=':
                                                    $final_price = $option_discount_price;
                                                    $price_prefix = '';
                                                    break;
                                                case '+%':
                                                    switch ($pod['calc_method']) {
                                                        case 'p':
                                                            $final_price = $product_total_price + ($product_base_price * $option_discount_price/100);
                                                            break;
                                                        case 'po':
                                                            $final_price = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_price/100);
                                                            break;
                                                        default: //o
                                                            $final_price = $product_total_price + ($option_base_price * $option_discount_price/100);
                                                            break;

                                                    }

                                                    $price_prefix = '+';
                                                    $price_suffix = '%';
                                                    break;

                                                case '-%':
                                                    switch ($pod['calc_method']) {
                                                        case 'p':
                                                            $final_price = $product_total_price - ($product_base_price * $option_discount_price/100);
                                                            break;
                                                        case 'po':
                                                            $final_price = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_price/100);
                                                            break;
                                                        default: //o
                                                            $final_price = $product_total_price - ($option_base_price * $option_discount_price/100);
                                                            break;
                                                    }

                                                    $price_prefix = '-';
                                                    $price_suffix = '%';
                                                    break;

                                                default:
                                                    $final_price = $product_total_price + $option_discount_price;
                                                    $price_prefix = '+';
                                                    break;
                                            }

                                            switch ($pod['special_prefix']) {
                                                case '+':
                                                    $final_special = $product_total_price + $option_discount_special;
                                                    $special_prefix = '+';
                                                    break;
                                                case '-':
                                                    $final_special = $product_total_price - $option_discount_special;
                                                    if($option_discount_special == 0) {
                                                        $special_prefix = false;
                                                    } else {
                                                        $special_prefix = '-';
                                                    }

                                                    break;

                                                case '=':
                                                    $final_special = $option_discount_special;
                                                    $special_prefix = '';
                                                    break;

                                                case '+%':
                                                    switch ($pod['calc_method']) {
                                                        case 'p':
                                                            $final_special = $product_total_price + ($product_base_price * $option_discount_special/100);
                                                            break;

                                                        case 'po':
                                                            $final_special = $product_total_price + (($product_base_price + $option_base_price) * $option_discount_special/100);
                                                            break;

                                                        default: //o
                                                            $final_special = $product_total_price + ($option_base_price * $option_discount_special/100);
                                                            break;
                                                    }

                                                    $special_prefix = '+';
                                                    $special_suffix = '%';
                                                    break;

                                                case '-%':

                                                    switch ($pod['calc_method']) {
                                                        case 'p':
                                                            $final_special = $product_total_price - ($product_base_price * $option_discount_special/100);
                                                            break;

                                                        case 'po':
                                                            $final_special = $product_total_price - (($product_base_price + $option_base_price) * $option_discount_special/100);
                                                            break;

                                                        default: //o
                                                            $final_special = $product_total_price - ($option_base_price * $option_discount_special/100);
                                                            break;
                                                    }

                                                    $special_prefix = '-';
                                                    $special_suffix = '%';
                                                    break;

                                                default:
                                                    $final_special = $product_total_price + $option_discount_special;
                                                    $special_prefix = '+';
                                                    break;

                                            }

                                            if($pods['show_final']) {
                                                $raw_price = $final_price;
                                                $price_prefix =
                                                $price_suffix = '';

                                                $raw_special = $final_special;
                                                $special_prefix = $special_prefix === false ? false : '';
                                                $special_suffix = $special_prefix === false ? false : '';
                                            } else {
                                                $raw_price = $option_discount_price;
                                                $raw_special = $option_discount_special;
                                            }

                                            if($price_suffix == '%') {
                                                $price = number_format((float)$raw_price, 2);
                                            } elseif((float)$raw_price) {
                                                $price = $this->currency->format($this->tax->calculate($raw_price, $product_info['tax_class_id'], $this->config->get('config_tax')));
                                            } else {
                                                $tax_price = $this->tax->calculate($raw_price, $product_info['tax_class_id'], $this->config->get('config_tax'));
                                                $price = $this->currency->format($tax_price);
                                            }

                                            if($special_prefix === false || ($pod['date_start'] != '0000-00-00' && $pod['date_start'] > date('Y-m-d')) || ($pod['date_end'] != '0000-00-00' && $pod['date_end'] < date('Y-m-d'))) {
                                                $special = false;
                                            } elseif($special_suffix == '%') {
                                                $special = number_format((float)$raw_special, 2);
                                            } elseif((float)$raw_special) {
                                                $special = $this->currency->format($this->tax->calculate($raw_special, $product_info['tax_class_id'], $this->config->get('config_tax')));
                                            } else {
                                                $tax_special = $this->tax->calculate($raw_special, $product_info['tax_class_id'], $this->config->get('config_tax'));
                                                $special = $this->currency->format($tax_special);
                                            }
                                        }

                                        if(end($quantities) == $quantity) {
                                            $ranges[$quantity] = $quantity . $this->language->get('text_plus');
                                        } else {
                                            $u = 0;
                                            do {
                                                $u++;
                                                $upper_quantity = $quantities[$u]-1;
                                            } while($quantities[$u] <= $quantity);

                                            $ranges[$quantity] = $quantity . $this->language->get('text_range') . $upper_quantity;
                                        }
                                    }

                                    if (!empty($option_value['ob_image'])) {
                                        $image = $this->model_tool_image->resize($option_value['ob_image'], 50, 50);
                                    } else {
                                        $image = $this->model_tool_image->resize($option_value['image'], 50, 50);
                                    }

                                    if (!$image) {
                                        $image = $this->model_tool_image->resize('no_image.jpg', 50, 50);
                                    }

                                    break;
                                }
                            } else {
                                if($product_info['special']) {
                                    $product_base_price = $product_info['special'];
                                } else {
                                    $product_base_price = $product_info['price'];
                                }

                                if(isset($option_value['quantity'])){
                                    $option_quantity = true;
                                    $quantity += (int)$option_value['quantity'];
                                }

                                if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                                    switch ($option_value['price_prefix']) {
                                        case '+':
                                            $final_price = $product_base_price + $option_value['price'];
                                            break;
                                        case '-':
                                            $final_price = $product_base_price - $option_value['price'];
                                            break;
                                        case '=':
                                            $final_price = $product_base_price;
                                            break;

                                        default:
                                            $final_price = $product_base_price;
                                            break;
                                    }

                                    if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                        $price = $this->currency->format($this->tax->calculate($final_price, $product_info['tax_class_id'], $this->config->get('config_tax')));
                                    }

                                    if(!empty($option_value['ob_image'])){
                                        $image = $this->model_tool_image->resize($option_value['ob_image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                                    }
                                }
                            }
                        }

                        break;
                    }
                }

                if ($option_quantity) {
                    if ($quantity <= 0) {
                        $stock = $product_info['stock_status'];
                    } elseif ($this->config->get('config_stock_display')) {
                        $stock = $quantity;
                    } else {
                        $stock = $this->language->get('text_instock');
                    }
                } else {
                    if ($product_info['quantity'] <= 0) {
                        $stock = $product_info['stock_status'];
                    } elseif ($this->config->get('config_stock_display')) {
                        $stock = $product_info['quantity'];
                    } else {
                        $stock = $this->language->get('text_instock');
                    }
                }

                if (!$image) {
                    $image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                }

				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,		
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);
			} else {
				unset($this->session->data['wishlist'][$key]);
			}
		}	

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/wishlist.tpl';
		} else {
			$this->template = 'default/template/account/wishlist.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());		
	}

	public function add() {
		$this->language->load('account/wishlist');

		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {	
				$this->session->data['wishlist'][] = $this->request->post['product_id'];
			}

			if ($this->customer->isLogged()) {			
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			} else {
				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			}

			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}	

		$this->response->setOutput(json_encode($json));
	}

    public function clear() {
        $this->language->load('account/wishlist');

        $json = array();

        $json['success'] = 'Все закладки удалены!';

        $this->session->data['wishlist'] = array();

        $this->response->setOutput(json_encode($json));
    }
}
?>
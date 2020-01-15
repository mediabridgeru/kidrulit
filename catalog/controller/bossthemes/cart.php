<?php 
class ControllerBossthemesCart extends Controller {
	public function add() {
		
		$json = array();
		
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
    
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {	

			$this->language->load('checkout/cart');
			
			$this->language->load('bossthemes/cart');
					
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
			} else {
				$quantity = 1;
			}
														
			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = [];
			}
			
            if (isset($this->request->post['profile_id'])) {
                $profile_id = $this->request->post['profile_id'];
            } else {
                $profile_id = 0;
            }

			$product_options = $this->model_catalog_product->getProductOptions($product_id);
			
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}
			
            $profiles = $this->model_catalog_product->getProfiles($product_id);
            
            if ($profiles) {
                $profile_ids = array();
                
                foreach ($profiles as $profile) {
                    $profile_ids[] = $profile['profile_id'];
                }
                
                if (!in_array($profile_id, $profile_ids)) {
                    $json['error']['profile'] = $this->language->get('error_profile_required');
                }
            }
			
			if (!$json) {
                $this->cart->add($product_id, $quantity, $option, $profile_id);

				$this->load->model('tool/image'); 
				$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
        
				$json['title'] = $this->language->get('text_title');
				$json['thumb'] = sprintf($this->language->get('text_thumb'),  $this->url->link('product/product', 'product_id=' . $product_id), $image);
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_id), $product_info['name'], $this->url->link('checkout/cart'));
				
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				
				// Totals
				$this->load->model('setting/extension');
				
				$total_data = array();					
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
			
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
					
					$sort_order = array(); 
				  
					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
		
					array_multisort($sort_order, SORT_ASC, $total_data);			
				}
				
				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $product_id));
			}
		}
		
		$this->response->setOutput(json_encode($json));		
	}
}
<?php
class ControllerModuleBossProductCategory extends Controller {
	protected function index($setting) {
		static $module = 0;
		$this->language->load('module/boss_productcategory');		
		$this->document->addScript('catalog/view/javascript/bossthemes/jquery.carouFredSel-6.2.0-packed.js');		
		
		$this->data['use_scrolling_panel'] = $setting['use_scrolling_panel'];
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['template'] = $this->config->get('config_template');
		
		$this->data['title_left'] = $this->language->get('title_left');
		$this->data['title_right'] = $this->language->get('title_right');
		// tab
		$this->load->model('bossthemes/boss_productcategory');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$filter_type = $setting['filter_type'];
		$type_category = $setting['type_category'];
		//print_r($type_category);die();
		$results = array();
		if ($filter_type == "popular") {
			$results = $this->model_bossthemes_boss_productcategory->btGetPopularProducts($setting['limit'],$type_category);
		}
		if ($filter_type == "special") {
			$data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting['limit']
			);
			$results = $this->model_bossthemes_boss_productcategory->btGetProductSpecials($data,$type_category);
		}
		if ($filter_type == "bestseller") {
			$results = $this->model_bossthemes_boss_productcategory->btGetBestSellerProducts($setting['limit'],$type_category);
		}
		if ($filter_type == "lastest") {
			$results = $this->model_bossthemes_boss_productcategory->btGetLatestProducts($setting['limit'],$type_category);
		}		
		
		$products = array();
		if(is_array($results))	{
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
					/*$module_label = $this->config->get('boss_label_products_setting');
					$this->load->model('bosslabelproducts/bossimage');
					$checklabel = $this->model_bosslabelproducts_bossimage->checkLabel($result['product_id']);
					if($checklabel == 1){
						$image = $this->model_bosslabelproducts_bossimage->label_resize($result['image'], $setting['image_width'], $setting['image_height'], $result['product_id']);					
					}else{
						$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
					}*/
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) { 
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
				
				$products[] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'model'    	 => $result['model'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
		}
		
		
		$this->data['tab'] = array();
		$this->data['tab'] = array(
			'title'	 		 =>	$setting['title'][$this->config->get('config_language_id')],			
			'products'       => $products
		);
		// end tab
		
		$this->data['module'] = $module++;
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_productcategory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_productcategory.tpl';
		} else {
			$this->template = 'default/template/module/boss_productcategory.tpl';
		}
		
		$this->cache->set('boss_productcategory.' . (int)$this->config->get('config_language_id'),$this->render());

		$this->render();
		
	}
}
?>
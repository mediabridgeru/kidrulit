<?php  
class ControllerModulecategoryacc extends Controller {
	protected $category_id = 0;
	protected $path = array();
	
	protected function index() {
		$this->language->load('module/category_acc');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }
        
        if (isset($parts[0])) {
            $top_category_id = $parts[0];
        } else {
            $top_category_id = 0;
        }
		
		$cur_category_id = array_pop($parts);
		
		$this->data['categories'] = array();
		
		$categories_1 = $this->model_catalog_category->getCategories($this->config->get('category_acc_category'));
		
		foreach ($categories_1 as $category_1) {
			if (isset($category_1['top'])) {
				$total1 = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category_1['category_id']));
				$level_2_data = array();
				$active = 0;
				$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
				
				foreach ($categories_2 as $category_2) {
					$total2 = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category_2['category_id']));
					$active2 = ($category_2['category_id'] == $cur_category_id) ? 1 : 0;

                    $level_3_data = array();

                    $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

                    foreach ($categories_3 as $category_3) {
                        $total3 = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category_3['category_id']));
                        $active3 = ($category_3['category_id'] == $cur_category_id) ? 1 : 0;

                        if ($active3 == 1) { $active = 1 ;}

                        $level_3_data[] = array(
                            'active'   => $active3,
                            'name'     => $category_3['name'] . ($this->config->get('config_product_count')&&$total3 ? ' (' . $total3 . ')' : ''),
                            'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
                        );
                    }

					if ($active2 == 1) { $active = 1 ;}
					
					$level_2_data[] = array(
						'active'   => $active2,
						'name'     => $category_2['name'] . ($this->config->get('config_product_count')&&$total2 ? ' (' . $total2 . ')' : ''),
						'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id']),
                        'children' => $level_3_data,
					);					
				}
				
				// Level 1
				
				$active1 = ($category_1['category_id'] == $cur_category_id) ? 1 : 0;
				
				if ($active == 1) { $active1 = 1 ;}
				
				$categories[] = array(
					'active'   => $active1,
					'name'     => $category_1['name'] . ($this->config->get('config_product_count')&&$total1 ? ' (' . $total1 . ')' : ''),
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id']),
                    'children' => $level_2_data,
					'id'       => $category_1['category_id']
				);
			}
		}

        $this->data['categories'] = $categories;
		
		$this->id = 'category_acc';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_acc.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category_acc.tpl';
		} else {
			$this->template = 'default/template/module/category_acc.tpl';
		}
		
		$this->render();
  	}
	
}
?>
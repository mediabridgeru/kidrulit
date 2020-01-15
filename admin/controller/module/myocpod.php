<?php
class ControllerModuleMyocpod extends Controller {	
	private $error = array();
	
	public function index()
	{
		$this->load->language('module/myocpod');

		$this->document->setTitle($this->language->get('common_title'));

		$this->load->model('catalog/product');
		$this->load->model('myoc/pod');
		$this->model_myoc_pod->upgradeTable();
		$this->cache->delete('myoc.pods');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if(isset($this->request->post['target_products'])) {
				foreach ($this->request->post['target_products'] as $target_product_id) {
					$this->model_myoc_pod->copyOption($this->request->post['source_product'], $target_product_id);
					$this->model_myoc_pod->copyOptionDiscount($this->request->post['source_product'], $target_product_id);
				}
			}
			if(isset($this->request->post['target_categories'])) {
				foreach ($this->request->post['target_categories'] as $target_category_id) {
					$target_products = $this->model_catalog_product->getProductsByCategoryId($target_category_id);
					if(!empty($target_products)) {
						foreach ($target_products as $target_product) {
							$this->model_myoc_pod->copyOption($this->request->post['source_product'], $target_product['product_id']);
							$this->model_myoc_pod->copyOptionDiscount($this->request->post['source_product'], $target_product['product_id']);
						}
					}
				}
			}
		  	
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->data['heading_title'] = $this->language->get('common_title');

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_copy'] = $this->language->get('button_copy');

		$this->data['entry_product_source'] = $this->language->get('entry_product_source');
		$this->data['entry_product_target'] = $this->language->get('entry_product_target');
		$this->data['entry_category_target'] = $this->language->get('entry_category_target');

		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_copy_warning'] = $this->language->get('text_copy_warning');
		$this->data['text_nothing'] = sprintf($this->language->get('text_nothing'), $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'));
		
		$this->data['myoc_copyright'] = $this->language->get('myoc_copyright');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_module'),
			'href'		=> $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('common_title'),
			'href'		=> $this->url->link('module/myocpod', 'token=' . $this->session->data['token'], 'SSL'),
			'separator'	=> ' :: '
		);
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['source_product'])) {
			$this->data['error_source_product'] = $this->error['source_product'];
		} else {
			$this->data['error_source_product'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['copy'] = $this->url->link('module/myocpod', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];

		$this->data['products'] = $this->model_catalog_product->getProducts(array(
			'sort' => 'name',
			'order' => 'ASC'
		));

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(array(
			'sort' => 'name',
			'order' => 'ASC'
		));

		$this->data['category_products'] = array();
		
		foreach ($this->data['categories'] as $category) {
			$products = $this->model_catalog_product->getProductsByCategoryId($category['category_id']);
			if($products)
			{
				$this->data['category_products'][$category['category_id']] = array();
				foreach ($products as $product) {
					$this->data['category_products'][$category['category_id']][$product['product_id']] = $product['name'];
				}
			}
		}

		$this->template = 'myoc/pod.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'module/myocpod')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if($this->request->post['source_product'] == 0) {
			$this->error['source_product'] = $this->language->get('error_source_product');
		}

		return !$this->error;
	}

	public function install()
	{
		$this->load->model('myoc/pod');
		$this->model_myoc_pod->installTable();
	}

	public function uninstall()
	{
		$this->load->model('myoc/pod');
		$this->model_myoc_pod->uninstallTable();
	}
}
?>
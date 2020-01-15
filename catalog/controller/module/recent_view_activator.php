<?php
class ControllerModuleRecentViewActivator extends Controller {
	protected function index($setting) {
				
		if (isset($this->request->get['product_id'])){
			$this->session->data['product_recent_view'][] = $this->request->get['product_id'];
		}
	}
}
?>
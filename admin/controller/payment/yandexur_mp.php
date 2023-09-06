<?php
class ControllerPaymentyandexurmp extends Controller {
	private $error = array();
	private $pname = 'yandexur_mp';

	public function index() {
    
		ob_start();
    	$this->getChild('payment/yandexur', array('name' => $this->pname));
    	$this->response->output();
    	$response = ob_get_clean();

	}
}
?>
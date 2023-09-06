<?php
class ControllerPaymentYandexuryka extends Controller {
	private $error = array();
	private $pname = 'yandexur_yka';

	public function index() {
    
		ob_start();
    	$this->getChild('payment/yandexur', array('name' => $this->pname));
    	$this->response->output();
    	$response = ob_get_clean();

	}
}
?>
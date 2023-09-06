<?php
class ControllerPaymentyandexuralfa extends Controller {
	private $error = array();
	private $pname = 'yandexur_alfa';

	public function index() {

		ob_start();
    	$this->getChild('payment/yandexur', array('name' => $this->pname));
    	$this->response->output();
    	$response = ob_get_clean();

	}
}
?>
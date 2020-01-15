<?php
class ControllerShippingRussianpost2f1 extends Controller {

	public function index() 
	{
		$this->redirect($this->url->link('shipping/russianpost2', 'token=' . $this->session->data['token'], 'SSL') );
	}
	
	public function install()
	{
		$this->redirect(  $this->url->link('extension/shipping/install', 'token=' . $this->session->data['token']. '&extension=russianpost', 'SSL')  );
	}
	
	public function uninstall()
	{
		$this->redirect(  $this->url->link('extension/shipping/uninstall', 'token=' . $this->session->data['token']. '&extension=russianpost', 'SSL')  );
	}
}

?>
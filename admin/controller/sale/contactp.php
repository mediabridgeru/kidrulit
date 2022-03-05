<?php 
class ControllerSaleContactp extends Controller {
	private $error = array();
	
	public function index() {
		require_once(DIR_SYSTEM . 'library/pop_cs.php');
		
		$this->language->load('sale/contactp');
		
		if ($this->validate()) {
			$this->data['text_from'] = $this->language->get('text_from');
			$this->data['text_to'] = $this->language->get('text_to');
			$this->data['text_subject'] = $this->language->get('text_subject');
			$this->data['text_date'] = $this->language->get('text_date');
			$this->data['text_viewraw'] = $this->language->get('text_viewraw');
			
			$contacts_pop_port = $this->config->get('contacts_pop_port') ? $this->config->get('contacts_pop_port') : 110;
			$contacts_pop_timeout = $this->config->get('contacts_pop_timeout') ? $this->config->get('contacts_pop_timeout') : 5;
			$contacts_pop_qty = $this->config->get('contacts_pop_qty') ? $this->config->get('contacts_pop_qty') : 100;
			
			$pop3 = new Pop_CS();
			$pop3->setHost($this->config->get('contacts_pop_hostname'));
			$pop3->setUser($this->config->get('contacts_pop_username'));
			$pop3->setPass(html_entity_decode($this->config->get('contacts_pop_password'), ENT_QUOTES, 'UTF-8'));
			$pop3->port = $contacts_pop_port;
			$pop3->timeout = $contacts_pop_timeout;
			$pop3->qty = $contacts_pop_qty;
			
			$this->data['mails'] = $pop3->get_mails();
		} else {
			$this->data['mails']['error'] = $this->language->get('error_permission');
		}

		$this->template = 'sale/contactp.tpl';
		
		$this->response->setOutput($this->render());
	}

	public function getbodymail() {
		$json = array();
		
		$this->language->load('sale/contactp');
		
		if (isset($this->request->get['mail_id'])) {
			require_once(DIR_SYSTEM . 'library/pop_cs.php');
			
			$mraw = isset($this->request->get['mraw']) ? $this->request->get['mraw'] : 0;
			
			$contacts_pop_port = $this->config->get('contacts_pop_port') ? $this->config->get('contacts_pop_port') : 110;
			$contacts_pop_timeout = $this->config->get('contacts_pop_timeout') ? $this->config->get('contacts_pop_timeout') : 5;
			
			$pop3 = new Pop_CS();
			$pop3->setHost($this->config->get('contacts_pop_hostname'));
			$pop3->setUser($this->config->get('contacts_pop_username'));
			$pop3->setPass(html_entity_decode($this->config->get('contacts_pop_password'), ENT_QUOTES, 'UTF-8'));
			$pop3->port = $contacts_pop_port;
			$pop3->timeout = $contacts_pop_timeout;
			
			$result = $pop3->get_mail($this->request->get['mail_id'], $mraw);
			
			if ($result) {
				if (!empty($result['headers']) && !empty($result['headers']['x-failed-recipients'])) {
					$this->load->model('sale/contacts');
					
					$unsub = $this->model_sale_contacts->checkEmailUnsubscribe($result['headers']['x-failed-recipients']);
					
					if ($unsub) {
						$result['unsub'] = 1;
					} else {
						$result['unsub'] = $result['headers']['x-failed-recipients'];
					}
				}
				
				$json = $result;
			} else {
				$json['error'] = $this->language->get('error_get_mail');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function removemails() {
		$json = array();
		
		$this->language->load('sale/contactp');
		
		if ($this->validate()) {
			if (!empty($this->request->post['selected'])) {
				require_once(DIR_SYSTEM . 'library/pop_cs.php');
				
				$contacts_pop_port = $this->config->get('contacts_pop_port') ? $this->config->get('contacts_pop_port') : 110;
				$contacts_pop_timeout = $this->config->get('contacts_pop_timeout') ? $this->config->get('contacts_pop_timeout') : 5;
				
				$pop3 = new Pop_CS();
				$pop3->setHost($this->config->get('contacts_pop_hostname'));
				$pop3->setUser($this->config->get('contacts_pop_username'));
				$pop3->setPass(html_entity_decode($this->config->get('contacts_pop_password'), ENT_QUOTES, 'UTF-8'));
				$pop3->port = $contacts_pop_port;
				$pop3->timeout = $contacts_pop_timeout;
				
				$result = $pop3->del_mails($this->request->post['selected']);
				
				if ($result) {
					if (isset($result['success'])) {
						$result['success'] = sprintf($this->language->get('success_del_mails'), $result['success']);
					}
					$json = $result;
				} else {
					$json['error'] = $this->language->get('error_operation');
				}
			} else {
				$json['error'] = $this->language->get('error_operation');
			}
		} else {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	protected function validate() {
		$this->language->load('sale/contactp');
		
		if (!$this->user->hasPermission('modify', 'sale/contactp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
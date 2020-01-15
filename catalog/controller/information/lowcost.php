<?php 
class ControllerInformationLowcost extends Controller {
	public function index() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($this->validate()) {
				$name = $this->request->post["name"];
				$email = $this->request->post["email"];
				$phone = $this->request->post["phone"];
				$link = $this->request->post["link"];
				$message = $this->request->post["message"];
				$product_id = $this->request->post["product"];
				$product = $this->url->link("product/product", "product_id=" . $this->request->post["product"]);
				
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');				
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->request->post['email']);
				$mail->setSender($this->request->post['name']);
				$mail->setSubject(html_entity_decode("Пользователь нашел товар ID ".$product_id. " дешевле."), ENT_QUOTES, 'UTF-8');
				$mailtext  = "Имя: " . $name . "\n";
				$mailtext .= "Email: " . $email . "\n";
				$mailtext .= "Телефон: " . $phone . "\n";
				$mailtext .= "Ссылка на более дешевый товар: " . $link . "\n";
				$mailtext .= "Сообщение: " . $message . "\n";
				$mailtext .= "ID товара: " . $product_id . "\n";
				$mailtext .= "Ссылка на товар на сайте: " . $product;
				
				$mail->setText(strip_tags(html_entity_decode($mailtext, ENT_QUOTES, 'UTF-8')));
				$mail->send();
				$t = Array();
				$t["success"] = 1;
				$this->response->setOutput(json_encode($t));
			} else {
				$t = Array();
				$t["error"] = 1;
				$this->response->setOutput(json_encode($t));
			}
		} 
	}


	protected function validate() {
		$rSecret = '6Lf_34kUAAAAAJZs55NXR0YTyqaJrY7gYFtHXAVI'; 
		$rCode = $this->request->post['g-recaptcha-response'];
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$curl = curl_init('https://www.google.com/recaptcha/api/siteverify');

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret='.$rSecret.'&response='.$rCode.'&remoteip='.$ip);
		curl_setopt($curl, CURLINFO_HEADER_OUT, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$res = curl_exec($curl);
		curl_close($curl);
		$res = json_decode($res, true);
		
		
		if(!$res['success']) {
			return false;
		} else {
			return true;
		}
	}

}
?>

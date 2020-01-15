<?php
class ControllerModuleCallbackphone extends Controller {
	public function index() {
		$this->language->load('module/callbackphone');

		$this->data['text_placeholder_name'] = $this->language->get('text_placeholder_name');
		$this->data['text_placeholder_telphone'] = $this->language->get('text_placeholder_telphone');
		$this->data['text_placeholder_callup'] = $this->language->get('text_placeholder_callup');
		$this->data['text_placeholder_callto'] = $this->language->get('text_placeholder_callto');
		$this->data['text_placeholder_comment'] = $this->language->get('text_placeholder_comment');

		$this->data['config_telephone'] = $this->config->get('config_telephone');
		$this->data['config_fax'] = $this->config->get('config_fax');
		$this->data['config_email'] = $this->config->get('config_email');
		$this->data['config_address'] = $this->config->get('config_address');

		$this->data['callbackphone_title'] = $this->config->get('callbackphone_title');
		$this->data['callbackphone_required'] = $this->config->get('callbackphone_required');
		$this->data['callbackphone_telephone'] = $this->config->get('callbackphone_telephone');
		$this->data['callbackphone_fax'] = $this->config->get('callbackphone_fax');
		$this->data['callbackphone_email'] = $this->config->get('callbackphone_email');
		$this->data['callbackphone_address'] = $this->config->get('callbackphone_address');
		$this->data['callbackphone_map'] = html_entity_decode($this->config->get('callbackphone_map'), ENT_QUOTES, 'UTF-8');
		$this->data['callbackphone_mapshow'] = $this->config->get('callbackphone_mapshow');
		$this->data['callbackphone_mask'] = $this->config->get('callbackphone_mask');

		$this->data['callbackphone_active_comment'] = $this->config->get('callbackphone_active_comment');
		$this->data['callbackphone_active_tel'] = $this->config->get('callbackphone_active_tel');
		$this->data['callbackphone_active_address'] = $this->config->get('callbackphone_active_address');
		$this->data['callbackphone_active_fax'] = $this->config->get('callbackphone_active_fax');
		$this->data['callbackphone_active_email'] = $this->config->get('callbackphone_active_email');
		$this->data['callbackphone_active_rightside'] = $this->config->get('callbackphone_active_rightside');
		$this->data['callbackphone_active_time'] = $this->config->get('callbackphone_active_time');

		$this->data['uri'] = $this->request->server['REQUEST_URI'];
        $this->data['action'] = HTTPS_SERVER . 'index.php?route=module/callbackphone/send';
		$this->id = 'callbackphone';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/callbackphone.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/callbackphone.tpl';
		} else {
			$this->template = 'default/template/module/callbackphone.tpl';
		}

		$this->render();

	}

	public function send() {

				$this->language->load('module/callbackphone');

				$sendsemail = $this->config->get('callbackphone_email');
				if (!empty($sendsemail)) {
	            	$ourmail = $this->config->get('callbackphone_email');
	            } else {
					$ourmail = $this->config->get('config_email');
				}

	            $mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');
	            $mail->setTo($ourmail);
	            $mail->setFrom('info@'.substr(preg_replace("#/$#", "", $this->config->get('config_url')), 7));
	            $mail->setSender('info@'.substr(preg_replace("#/$#", "", $this->config->get('config_url')), 7));
	            $mail->setSubject("Заказ обратного звонка");
	           
	            $callbackphonename = $this->request->post['callbackphonename'];
				$callbackphonetel = $this->request->post['callbackphonetel'];
				$callbackphonecomment = $this->request->post['callbackphonecomment'];
				$callup = $this->request->post['callup'];
				$callto = $this->request->post['callto'];

				$email_callbackphone_name = $this->language->get('email_callbackphone_name');
				$email_callbackphone_tel = $this->language->get('email_callbackphone_tel');
				$email_callbackphone_comment = $this->language->get('email_callbackphone_comment');
				$email_callbackphone_callup = $this->language->get('email_callbackphone_callup');
				$email_callbackphone_callto = $this->language->get('email_callbackphone_callto');

	           	$MailCom = "$email_callbackphone_name: $callbackphonename\r\n$email_callbackphone_tel: $callbackphonetel\r\n$email_callbackphone_comment: $callbackphonecomment\r\n$email_callbackphone_callup: $callup\r\n$email_callbackphone_callto: $callto";
	           
	            $mail->setText(strip_tags(html_entity_decode($MailCom, ENT_QUOTES, 'UTF-8')));

				if (!empty($callbackphonename) && !empty($callbackphonetel) && preg_match('/^\p{L}+$/u', $callbackphonename)) {

				echo $success = "Заказ обратного звонка отправлен успешно!<br />Наш менеджер Вам перезвонит.";

	            $mail->send();
				
				} else {

				echo $error = "Вы не заполнили обязательные поля!";
				
				}


      


	}


}
?>
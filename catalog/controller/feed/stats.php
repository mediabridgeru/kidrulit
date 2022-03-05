<?php 
class ControllerFeedStats extends Controller {
	public function index() {
        $this->response->redirect($this->url->link('common/home'));
    }
	
    public function images() {
        if (isset($this->request->get['sid']) && ($this->request->get['sid'] != '')) {
			$sid = base64_decode($this->request->get['sid']);
			$sid_data = explode('|', $sid);
			
			$send_id = $sid_data[0];
            $email = $sid_data[1];
			$check = $sid_data[2];
			$customer_id = $sid_data[3];
			
			$controlsumm = md5($email . $this->config->get('contacts_unsub_pattern'));
			
			if ($controlsumm == $check) {
				$this->load->model('contacts/ccrons');
				
				$data_view = array(
					'send_id'     => $send_id,
					'customer_id' => $customer_id,
					'email'       => $email
				);
				
				$this->model_contacts_ccrons->addView($data_view);
            }
        }
		
		$image = imagecreatetruecolor(10, 10);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		$background = imagecolorallocatealpha($image, 252, 252, 252, 100);
		imagecolortransparent($image, $background);
		
		imagefilledrectangle($image, 0, 0, 10, 10, $background);

		header('Content-Type: image/png');

		imagepng($image);
		imagedestroy($image);
    }

    public function clck() {
        if (isset($this->request->get['sid']) && ($this->request->get['sid'] != '') && isset($this->request->get['link']) && ($this->request->get['link'] != '')) {
			$sid = base64_decode($this->request->get['sid']);
			$sid_data = explode('|', $sid);
			
			$send_id = $sid_data[0];
            $email = $sid_data[1];
			$check = $sid_data[2];
			$customer_id = $sid_data[3];
			
			$link = base64_decode($this->request->get['link']);
			$pos = stripos($link, 'account/success');
			$controlsumm = md5($email . $this->config->get('contacts_unsub_pattern'));
			
			if ($send_id) {
				if (($controlsumm == $check) && ($pos === false)) {
					$this->load->model('contacts/ccrons');
					
					$data_clk = array(
						'send_id'     => $send_id,
						'customer_id' => $customer_id,
						'email'       => $email,
						'target'      => $link
					);
					
					$this->model_contacts_ccrons->addClick($data_clk);

					$dopurl = $this->model_contacts_ccrons->getDopurl($send_id);
					
					if ($dopurl) {
						$dopurl = str_replace('{sid}', $send_id, $dopurl);
						$dopurl = preg_replace('/^\?/', '', $dopurl);
						$dopurl = preg_replace('/^&amp;amp;/', '', $dopurl);
						$dopurl = preg_replace('/^&amp;/', '', $dopurl);
						
						$posq = stripos($link, '?');
						
						if ($posq === false) {
							$link .= '?' . $dopurl;
						} else {
							$link .= '&amp;' . $dopurl;
						}
					}
				}
			}
			
			$link = str_replace(array('&amp;amp;','&amp;'), '&', $link);
			
			header('Location: ' . $link);
			exit;
        } else {
			$this->response->redirect($this->url->link('common/home'));
		}
    }
}
?>
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
                $this->db->query("INSERT INTO " . DB_PREFIX . "contacts_views SET send_id = '" . (int)$send_id . "', customer_id = '" . (int)$customer_id . "', email = '" . $this->db->escape($email) . "', date_added = NOW()");
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
			
			if (($controlsumm == $check) && ($pos === false)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "contacts_clicks SET send_id = '" . (int)$send_id . "', customer_id = '" . (int)$customer_id . "', email = '" . $this->db->escape($email) . "', target = '" . $this->db->escape($link) . "', date_added = NOW()");
            }

			$this->response->redirect($link);

        } else {
			$this->response->redirect($this->url->link('common/home'));
		}
    }
}
?>
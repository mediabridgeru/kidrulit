<?php
class ModelPaymentyandexurwm extends Model { 
public function getMethod($address, $total) {
		$this->load->language('payment/yandexur_wm');
		
		if ($total > 0) {
			$status = true;
			if ($this->config->get('yandexur_wm_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('yandexur_wm_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if (!$this->config->get('yandexur_wm_geo_zone_id')) {
					$status = TRUE;
					if ($this->config->get('yandexur_wm_minpay')){
						if ($this->currency->format($total, 'RUB', $this->currency->getValue('RUB'), false) <= $this->config->get('yandexur_wm_minpay')) {
							$status = false;
						}
					}
					if ($this->config->get('yandexur_wm_maxpay')){
						if ($this->currency->format($total, 'RUB', $this->currency->getValue('RUB'), false) >= $this->config->get('yandexur_wm_maxpay')) {
							$status = false;
						}
					}
				} elseif ($query->num_rows) {
					$status = TRUE;
					if ($this->config->get('yandexur_wm_minpay')){
						if ($this->currency->format($total, 'RUB', $this->currency->getValue('RUB'), false) <= $this->config->get('yandexur_wm_minpay')) {
							$status = false;
						}
					}
					if ($this->config->get('yandexur_wm_maxpay')){
						if ($this->currency->format($total, 'RUB', $this->currency->getValue('RUB'), false) >= $this->config->get('yandexur_wm_maxpay')) {
							$status = false;
						}
					}
				} else {
					$status = FALSE;
				}
			} else {
				$status = FALSE;
			}
		} else {
			$status = false;
		}
		
    
		$method_data = array();
		if ($status) {  
			if ($this->config->get('yandexur_wm_name_attach')) {
				$metname = htmlspecialchars_decode($this->config->get('yandexur_wm_name_' . $this->config->get('config_language_id')));
			}
			else{
				$metname = $this->language->get('text_title');
			}
			$method_data = array( 
				'code'       => 'yandexur_wm',
				'title'      => $metname,
				'sort_order' => $this->config->get('yandexur_wm_sort_order')
			);
		}
		
    	return $method_data;
  	}
}
?>
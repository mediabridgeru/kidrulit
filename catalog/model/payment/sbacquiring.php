<?php
class ModelPaymentsbacquiring extends Model { 
public function getMethod($address, $total) {
		$this->load->language('payment/sbacquiring');
		
		if ($total > 0) {
			$status = true;

			if ($this->config->get('sbacquiring_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('sbacquiring_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if (!$this->config->get('sbacquiring_geo_zone_id')) {
					$status = TRUE;
					if ($this->config->get('sbacquiring_minpay')){
						if ($this->currency->format($total, $this->config->get('sbacquiring_currency'), $this->currency->getValue($this->config->get('sbacquiring_currency')), false) <= $this->config->get('sbacquiring_minpay')) {
							$status = false;
						}
					}
					if ($this->config->get('sbacquiring_maxpay')){
						if ($this->currency->format($total, $this->config->get('sbacquiring_currency'), $this->currency->getValue($this->config->get('sbacquiring_currency')), false) >= $this->config->get('sbacquiring_maxpay')) {
								$status = false;
							}
					}
				} elseif ($query->num_rows) {
					$status = TRUE;

					if ($this->config->get('sbacquiring_minpay')){
											if ($this->currency->format($total, $this->config->get('sbacquiring_currency'), $this->currency->getValue($this->config->get('sbacquiring_currency')), false) <= $this->config->get('sbacquiring_minpay')) {
												$status = false;
											}
										}
					if ($this->config->get('sbacquiring_maxpay')){
						if ($this->currency->format($total, $this->config->get('sbacquiring_currency'), $this->currency->getValue($this->config->get('sbacquiring_currency')), false) >= $this->config->get('sbacquiring_maxpay')) {
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
			if ($this->config->get('sbacquiring_name_attach')) {
				$metname = htmlspecialchars_decode($this->config->get('sbacquiring_name_' . $this->config->get('config_language_id')));
			}
			else{
				$metname = $this->language->get('text_title');
			}
			$method_data = array( 
				'code'       => 'sbacquiring',
				'title'      => $metname,
                'image'      => $this->language->get('image'),
				'sort_order' => $this->config->get('sbacquiring_sort_order')
			);
		}
		
    	return $method_data;
  	}
}
?>
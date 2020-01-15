<?php
class ModelTotalRpcodtotal2 extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) 
	{
		if( isset($this->session->data['payment_method']['code']) && 
			$this->config->get('russianpost2_is_cod_included') == 'inmod' &&
			(
				$this->session->data['payment_method']['code'] == 'rpcod2' ||
				(
					isset($this->session->data['shipping_method']['code']) &&
					strstr($this->session->data['shipping_method']['code'], 'russianpost2') && 
					$this->config->get('russianpost2_cod_script') == 'onlyshipping' &&
					$this->checkIsCodShippingMethod($this->session->data['shipping_method']['code'])
				)
			)
		)
		{
			$ar = $this->config->get('russianpost2_rpcodtotal_title');
			$title = html_entity_decode($ar[ $this->config->get('config_language_id') ]);
			
			/* start 2402 */
			$commission = '';
			
				$this->load->model('shipping/russianpost2');
				$RUB = $this->model_shipping_russianpost2->getRubCode();
				$config_currency = $this->model_shipping_russianpost2->getConfigCurrency();
				$rub_total = $this->currency->convert($total, $config_currency, $RUB);
				
				$commission_rub = $this->model_shipping_russianpost2->getTariffCodPrice(
									$rub_total,
									$this->config->get('russianpost2_from_postcode') 
								);
								
				$commission = $this->currency->convert($commission_rub, $RUB, $config_currency);
				
			
			
			if( $this->config->get('russianpost2_is_cod_included') == 'inmod' )
			{
				$title = str_replace("{price}", $this->currency->format($commission), $title);
				
				$total_data[] = array( 
					'code'       => 'rpcodtotal2',
					'title'      => $title,
					'text'       => $this->currency->format($commission),
					'value'      => $commission,
					'sort_order' => $this->config->get('rpcodtotal2_sort_order')
				);
				
				$total += $commission;
			}
		}			
	}
	
	private function checkIsCodShippingMethod($code)
	{
		list($code1, $code2) = explode(".", $code);
		
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "russianpost2_current_methods`
		WHERE code = '".$this->db->escape($code1)."'");
		
		if( !$query->row['data'] )
			return false;
		
		$data = unserialize($query->row['data']);
		
		foreach($data['submethods'] as $submethod )
		{
			if( $submethod['code'] == $code )
			{
				if( !empty($submethod['is_show_cod']) )
					return true;
				else
					return false;
			}
		}
		
		return false;
	}
}
?>
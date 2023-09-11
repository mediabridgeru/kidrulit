<?php
// NEW CLASS0
class ModelShippingRussianpost2 extends Model {
	
	private $RP2;
	private $ORDER = array();
	private $PRODUCTS = array();
	private $PRODUCT_BOXES = array();
	private $CONFIG_KEYS = array();
	private $SYST = array();
	private $CONFIG = array();
	private $error = array();
	private $stop = 0;
	private $is_cod = 0;
	private $rp_selected_pvz = array();
	private $PVZ_LIST = array();
	private $OPS_ONLY_LIST = array();
	private $PVZ_PAYMENT_LIST = array();
	private $OPS_ONLY_PAYMENT_LIST = array(); 
	private $NOOPS_ONLY_PAYMENT_LIST = array(); 
	private $NOOPS_ONLY_LIST = array(); 
	 
	private $is_yandexjs_allready_added = 0; 
	private $is_module_js_allready_added = 0; 
	private $is_widget_js_allready_added = 0;  
	
	private $currencies = array();
	
	private $code1 = '';
	private $code2 = '';
	
	private $SOURCES = array();
	private $SERVICES = array();
	private $PACKS = array();
	private $tariff_data = array();
	private $combinateLAFF_cache = array();
	private $postcalc_data = array();
	private $otpravka_data = array(); 
	private $tariff_srok_data = array(); 
	private $customer_group_id = 0; 
	private $stop_curl = array();  
	private $NDS = 20;
	private $NDS_KOEF = 1.2;
	private $rp_ops_index = array();
	private $SQL_CACHE = array();
	private $pre_text1 = 'Адрес ПВЗ: ';
	
	
	function getQuote($address)
	{
		$this->initClass();
		
		if( $this->config_get('russianpost2_debug') == 'log' )
		{
			$this->log->write('ADDRESS: '.print_r($address, 1));
		}
		
		if( !$this->config_get('russianpost2_status') )
		{
			return false;
		}
		
		$this->stop = 0;
		$this->is_cod = 0;
		if( !empty( $address['is_cod'] ) )
			$this->is_cod = 1;
		
		if( $this->isNeedUploadTarifs() )
		{
			$this->uplaodTarifs();
		}
		
		$this->setConfig();
		
		/*
			$this->CONFIG_KEYS
		*/
		$this->prepareConfigKeys();
		
		$this->setRpOpsFromSession(); 
		
		/*
			$this->SYST
		*/
		$this->prepareSystemParams();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		/*
			$this->CONFIG
		*/
		$this->prepareConfigParams();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		/*
			$this->ORDER
		*/
		$this->ORDER = $this->prepareOrderGeo($address);
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		/*
			$this->PRODUCTS
		*/
		$this->PRODUCTS = array();
		$this->prepareProducts();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		$this->prepareOrder();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		$this->ORDER['filters'] = $this->prepareOrderFilters();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		/*
			$this->SOURCES
		*/
		
		$this->prepareSources();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		
		$this->PACKS = $this->preparePacks();
		/*
			$this->SERVICES
		*/
		
		$this->prepareServices();
		
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		
		// ==============
		
		if( !empty( $address['is_cod'] ) )
		{
			$this->is_cod = 1;
			$this->code1 = $address['code1'];
			$this->code2 = $address['code2'];
			
			if( !$this->checkIsCODAvailable() )
			{
				$this->showErrors();
				return false;
			}
			
		}
		
		// ============
		
		$method_number = 0;
		
		if( !empty( $address['method_number'] ) )
			$method_number = $address['method_number'];
	
		$method = $this->getMethod($method_number);
		
		$this->addError('RESULT ('.$method_number.'): method_data: '.print_r($method, 1), 0);
			
		if( $this->stop )
		{
			$this->showErrors();
			return false;
		}
		else
		{
			$this->showErrors();
		}
		
		return $method;
	}
	
	private function setConfig()
	{
		if( $this->config_get('russianpost2_debug') )
		{
			$this->config->set('russianpost2_api_tariff_cache', 0);
			$this->config->set('russianpost2_api_postcalc_cache', 0);
			$this->config->set('russianpost2_api_otpravka_cache', 0);
		}
	}
	
	public function checkFilterFromPayment($filter_id, $address)
	{
		$this->prepareConfigKeys();
		$this->prepareSystemParams();
		$this->prepareProducts();
		$this->ORDER = $this->prepareOrderGeo($address); 
		$this->prepareOrder();
		
		if( $this->isOrderComplianceFilter($filter_id) )
			return true;
		else
			return false;
	}
	
	private function isNeedUploadTarifs()
	{
		return false;
		/*
		<select name="russianpost2_api_synx_mode">
              <option value="each_day">1 раз в день в оформлении заказа (НЕ рекомендуется)</option>
              <option value="each_week">1 раз в неделю в оформлении заказа (приемлемо)</option>
              <option value="each_month" selected="selected">1 раз в неделю в оформлении заказа (приемлемо)</option>
              <option value="by_button">Нажатием кнопки</option>
              <option value="by_cron">По CRON 1 раз в день (рекомендуется)</option>
            </select>
		*/
		
		if( !$this->config_get('russianpost2_last_upload_date') )
		{
			return true;
		}
		
		if( $this->config_get('russianpost2_api_synx_mode') == 'each_day' && 
			$this->config_get('russianpost2_last_upload_date') != date("Y-m-d")
		)
		{
			return true;
		}
		elseif(
			$this->config_get('russianpost2_api_synx_mode') == 'each_week' && 
			$this->config_get('russianpost2_last_upload_date') != date("Y-m-d")
		)
		{
			$diff = abs(strtotime(date("Y-m-d")) - strtotime($this->config_get('russianpost2_last_upload_date') ) );
			
			$days = ceil($diff / (60*60*24));
			
			if( $days > 7 )
			{
				return true;
			}
		}
		elseif(
			$this->config_get('russianpost2_api_synx_mode') == 'each_month' && 
			$this->config_get('russianpost2_last_upload_date') != date("Y-m-d")
		)
		{
			$diff = abs(strtotime(date("Y-m-d")) - strtotime($this->config_get('russianpost2_last_upload_date') ) );
			
			$days = ceil($diff / (60*60*24));
			
			if( $days > 30 )
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function getPhpVersion()
	{
		if( file_exists( DIR_SYSTEM."library/russianpost2/license.php" ) )
			return '';
		$raw = phpversion();
		$ar = explode('.', $raw);
		
		if( $ar[0] == 7 )
		{
			if( empty($ar[1]) || $ar[1] == 0 )
				return 70;
			elseif( $ar[1] == 1 )
				return 71;
			else
				return 72;
		}
		elseif($ar[0] == 5 && !empty($ar[1]) && $ar[1] == 3)
		{
			return 53;
		}
		elseif($ar[0] == 5 && !empty($ar[1]) && $ar[1] == 4)
		{
			return 54;
		}
		elseif($ar[0] == 5 && !empty($ar[1]) && $ar[1] == 5)
		{
			return 55;
		}
		else
		{
			return 5;
		}
		
	}
	
	
	public function initClass() 
	{
		if( !class_exists('ClassLicense') )
			include_once( DIR_SYSTEM."library/russianpost2/license".$this->getPhpVersion().".php" );
		
		if( !class_exists('ClassRussianpost2') ) 
			include_once( DIR_SYSTEM."library/russianpost2/russianpost2.php" );
		
		$this->RP2 = new ClassRussianpost2($this->registry);
	}
	
	private function uplaodTarifs()
	{
		$this->initClass();
		
		$lstatus = $this->RP2->uploadData(); 
		
		if( $lstatus && (int)$lstatus >= 0 )
		{
			$this->RP2->updateOneSetting('russianpost2_last_upload_date', date("Y-m-d"), 'russianpost2nodel' ); 
		}
		else
		{
			return false;
		}
	}
	
	
	private function checkIsCODAvailable()
	{
		if( $this->config_get('russianpost2_cod_maxtotal') && $this->ORDER['final']['total_without_shipping'] > $this->config_get('russianpost2_cod_maxtotal') ) 
		{
			$this->addError('Фильтр по максимальной цене налож.платежа', 0);
			return false;
		}
		
		if($this->config_get('russianpost2_cod_mintotal') && $this->ORDER['final']['total_without_shipping'] < $this->config_get('russianpost2_cod_mintotal') )
		{	
			$this->addError('Фильтр по минимальной цене налож.платежа', 0);
			return false;
		}
		
		if( $this->ORDER['to']['iso_code_2'] != 'RU'  )
		{	
			$this->addError('Налож.платеж работает только в России', 0);
			return false;
		}
		
		$russianpost2_methods = $this->config_get('russianpost2_methods');
		
		foreach($russianpost2_methods as $method)
		{
			if( $method['code'] == $this->code1 )
			{
				foreach($method['submethods'] as $submethod)
				{
					if( $submethod['code'] == $this->code1.'.'.$this->code2 )
					{
						if( empty( $submethod['is_show_cod'] ) )
						{
							$this->addError('Налож.платеж отключен для метода '.$this->code1.'.'.$this->code2, 0);
							return false;
						}
						
						if( !empty($submethod['services'][0]['service']) && 
							strstr($submethod['services'][0]['service'], 'ecom') &&
							!empty($this->session->data['rp_delivery_point_index']) &&
							!$this->checkIsCompulsoryPvz(
								$this->session->data['rp_delivery_point_index']
							)
						)
						{
							$this->addError('Налож.платеж недоступен для ПВЗ №'.$this->session->data['rp_delivery_point_index'], 0);
							return false;
						}
					}
				}
			}
		}
		
		if( $this->code2 == 'parcel_online' )
		{
			if( !empty($this->session->data['rp_delivery_point_index']) &&
				!$this->checkIsCompulsoryPvz(
					$this->session->data['rp_delivery_point_index']
				)
			)
			{
				$this->addError('Налож.платеж недоступен для ПВЗ №'.$this->session->data['rp_delivery_point_index'], 0);
				return false;
			}
		}
		return true;
	}
	
	private function getCurrentPackKey( $types, $is_pack=1 )
	{
		if( preg_match("/^c/", $is_pack ) )
		{
			$pack_key = preg_replace("/^c/", "", $is_pack);
			return $pack_key+1;
		}
		elseif( $is_pack!=1 )
		{
			return $is_pack;
		}
	
		$packs = array();
		
		if( is_array($types) )
		{
			foreach($types as $pack_key)
			{
				if( isset($this->PACKS[$pack_key]) )
				$packs[$pack_key] = $this->PACKS[$pack_key];
			}			
		}
		else
		{
			foreach($this->PACKS as $pack_key=>$pack)
			{
				if( !empty($pack['status']) )
				{
					$packs[ $pack_key ] = $pack;
				}
			}
		}
		
		foreach( $packs as $pack_key=>$pack )
		{
			if( !empty($pack['status'])  )
			{
				if( $pack['length'] == 0 ) $pack['length'] = 1;
				if( $pack['width'] == 0 ) $pack['width'] = 1;
				if( $pack['height'] == 0 ) $pack['height'] = 1;
				
				if(
					$this->combinateLAFF(
						array(
							"length" => $pack['length'],
							"width" => $pack['width'],
							"height" => $pack['height']
						), 
						$this->PRODUCT_BOXES
					) == 1 
				)
				{
					if( preg_match("/^\d+$/", $pack_key) )
					{
						$pack_key = (int)$pack_key + 1;
					}
					
					return $pack_key;
				} 
			}
		}
		
		if( is_array($types) )
		{
			return 'korob_xl';
		}
		
		return false;
	}
	
	private function preparePacks()
	{
		$results = array();
		$russianpost2_packs = $this->config_get('russianpost2_packs');
		
		if( !empty($russianpost2_packs) )
		{
			foreach($russianpost2_packs as $pack_key=>$pack)
			{
				#if( empty( $pack['status'] ) )
				#	continue;
				
				if( empty( $pack['price'] ) )
					$pack['price'] = 0;
				
				$pack['key'] = $pack_key;
				$results[ $pack_key ] = $pack;
			}
		}
		
		$russianpost2_custom_packs = $this->config_get('russianpost2_custom_packs');
		
		if( !empty($russianpost2_custom_packs) )
		{
			foreach($russianpost2_custom_packs as $i=>$pack)
			{
				#if( empty( $pack['status'] ) )
				#	continue;
				
				if( empty( $pack['price'] ) )
					$pack['price'] = 0;
				
				$pack['key'] = $i;
				$results[ $i ] = $pack;
			}
		}
		
		if( $results )
		{
			$sort_order = array();
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $value['price'];
			}

			array_multisort($sort_order, SORT_ASC, $results);
		}
		
		$hash = array();
		
		foreach($results as $result)
		{
			$hash[ $result['key'] ] = $result;
		}
		
		return $hash;
	}
	
	private function getDimensionsByDelivery($service_key, 
		$delivery, 
		$length_cm, 
		$width_cm, 
		$height_cm
	)
	{
		if( strtolower($service_key) == 'parcel_10' )
			$service_key = 'parcel_20'; 
		
		if( $delivery['maxwidth'] == 0 && $delivery['maxheight'] == 0 && $delivery['maxlength'] == 0 )
		{
			return array(
				$length_cm,
				$width_cm, 
				$height_cm
			);
		}
		
		if(
			$this->combinateLAFF(
						array(
							"length" => $delivery['maxlength']/10,
							"width" => $delivery['maxwidth']/10,
							"height" => $delivery['maxheight']/10
						), 
						$this->PRODUCT_BOXES
			) == 1
		)
		{
			return array(
				$delivery['maxlength']/10,
				$delivery['maxwidth']/10, 
				$delivery['maxheight']/10
			);
		}
		
		return array(
				$length_cm,
				$width_cm, 
				$height_cm
		);
	}
	
	private function prepareConfigKeys()
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_config
			WHERE `type` = 'table_profile'");
		
		$this->CONFIG_KEYS = array();
		
		foreach($query->rows as $row)
		{
			$this->CONFIG_KEYS[ $row['config_key'] ] = $row;
		}
	}
	
	private function prepareServices()
	{
		$query_delivery = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_delivery_types");
		
		$delivery_hash = array();
		foreach($query_delivery->rows as $row)
		{
			$data = $this->getDataTableRow('delivery_types', $row['data']);
			if( $data )
			{
				foreach( $data as $key=>$val )
				{
					$row[ $key ] = $val;
				}
			} 
			
			$delivery_hash[ $row['type_key'] ] = $row;
		}
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_services");
		$russianpost2_options = $this->config_get('russianpost2_options');
		
		$russianpost2_services2api_list = $this->config_get('russianpost2_services2api_list');
		
		
		foreach($query->rows as $row)
		{
			$data = $this->getDataTableRow('services', $row['data']);
			if( $data )
			{
				foreach( $data as $key=>$val )
				{
					$row[ $key ] = $val;
				}
			} 
			
			$row['DELIVERY'] = isset( $delivery_hash[ $row['type_key'] ] ) ? $delivery_hash[ $row['type_key'] ] : '';
			$this->SERVICES[ $row['service_key'] ] = $row;
		}
		
		foreach($query->rows as $row)
		{
			$service_key = $row['service_key'];
			if( !empty( $this->SERVICES[ $row['service_key'] ]['service_parent'] ) )
				$service_key = $this->SERVICES[ $row['service_key'] ]['service_parent'];
			
			if( isset($russianpost2_options[ $service_key ]) )
			$this->SERVICES[ $row['service_key'] ]['options'] = $russianpost2_options[ $service_key ];
			
			if( !empty($this->SERVICES[ $row['service_key'] ]['options']['is_1rub_insured']['status']) )
				$this->SERVICES[ $row['service_key'] ]['is_1rub_insured'] = 1;
			else
				$this->SERVICES[ $row['service_key'] ]['is_1rub_insured'] = 0;
			
			$key = $row['service_key'];
			$key = str_replace("_20", "", $key);
			$key = str_replace("_50", "", $key);
			
			if( !empty( $russianpost2_services2api_list[ $key ]['service_name_z'] ) )
			{
				$this->SERVICES[ $row['service_key'] ]['service_name_z'] = $russianpost2_services2api_list[ $key ]['service_name_z'];
			}
		}
		
		$custom_services = $this->getCustomServices();
		
		foreach($custom_services as $row)
		{ 
			$this->SERVICES[ $row['custom_id'] ] = $row; 
		}
		
		if( empty($this->SERVICES) )
		{
			$this->addError('Недоступны сервисы', 1);
		}
		
		foreach($this->SERVICES as $i=>$service)
		{
			if( !empty($service['options']['is_split']['status']) 
				||
				(
					!empty($service['service_parent']) &&
					!empty($this->SERVICES[ $service['service_parent'] ] ) &&
					!empty($this->SERVICES[ $service['service_parent'] ]['options']['is_split']['status']) 
				)
			)
			{
				if( empty($service['service_parent']) )
					$service['service_parent'] = $service['service_key'];
				
				$this->SERVICES[ 'split_'.$i ] = $service; 
			}
		}	
	}
	
	
	private function prepareSources()
	{
		$apis = array();
		
		if( $this->config_get('russianpost2_api_tariff_status') )
		{
			$apis['tariff'] = array(
				"source_key" => "tariff",
				"status" => $this->config_get('russianpost2_api_tariff_status'),
				"sort_order" => $this->config_get('russianpost2_api_tariff_sort_order'),
				"name" => 'API tariff.pochta.ru',
			);
		}
		else
		{
			$this->addError('API tariff.pochta.ru - отключен', 0);
		}
		
		if( $this->config_get('russianpost2_api_otpravka_status') && 
			$this->config_get('russianpost2_api_otpravka_token') &&
			$this->config_get('russianpost2_api_otpravka_key')  
		)
		{
			$apis['otpravka'] = array(
				"source_key" => "otpravka",
				"status" => $this->config_get('russianpost2_api_otpravka_status'),
				"sort_order" => $this->config_get('russianpost2_api_otpravka_sort_order'),
				"name" => 'API Почты России',
			);
		}
		else
		{
			$this->addError('API otpravka.pochta.ru - отключен или не указаны реквизиты', 0);
		}
		
		if( $this->config_get('russianpost2_api_postcalc_status') && 
			$this->config_get('russianpost2_api_postcalc_key') 
		)
		{
			$apis['postcalc'] = array(
				"source_key" => "postcalc",
				"status" => $this->config_get('russianpost2_api_postcalc_status'),
				"sort_order" => $this->config_get('russianpost2_api_postcalc_sort_order'),
				"name" => 'API Postcalc',
			);
		}
		else
		{
			$this->addError('API postcalc.ru - отключен или не указан ключ домена', 0);
		}
		
		$results = array();
		
		foreach($apis as $api)
		{
			$results[ $api["source_key"] ] = $api;
		}
		
		if( empty($results) )
		{
			$this->addError('Не подключен ни один API', 1);
		}
		
		$sort_order = array();

		foreach ($results as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $results);
		
		$this->SOURCES = $results;
	}
	
	private function getMethod($method_number)
	{
		$russianpost2_methods = array_values( $this->sortByKey( $this->config_get('russianpost2_methods') ) );
		
		$method = array();
		if( !$this->is_cod )
		{
			if( isset( $russianpost2_methods[ $method_number ]['code'] ) )
			{
				$method_code  = $russianpost2_methods[ $method_number ]['code'];
			}
			else
			{
				if( $method_number == 0 )
					$method_code = 'russianpost2';
				else
					$method_code = 'russianpost2f'.$method_number;
			}
			
			foreach($russianpost2_methods as $item)
			{
				if( $method_code == $item['code'] )
				{
					$method = $item;
					break;
				}
			}
		}
		else
		{
			foreach($russianpost2_methods as $item)
			{
				if( $item['code'] == $this->code1 
				|| $this->code1 == 'any'
				)
				{
					$method = $item;
					break;
				}
			}
		}
		
		// --------
		
		
		if( empty($method['status']) )
		{	
			$this->addError('('.(isset($method['code']) ? $method['code'] : '').') Группа методов отключена', 1);
			return false;
		}		 
		
		
		if( !empty( $method['filters'] ) )
		{
			$is_in = 0;
			$is_noempty = 0;
			
			foreach($method['filters'] as $filter_id)
			{
				if( empty($filter_id) ) continue;
				$is_noempty = 1;
				
				if( in_array( $filter_id, $this->ORDER['filters'] ) )
				{
					$is_in++;
				}
			}
			
			if( $is_in != count($method['filters']) && $is_noempty ) 
			{
				$this->addError('('.$method['code'].') Заказ не соответствует фильтру(ам) группы методов', 1);
				return false;
			}
		}
		
		if( empty($method['submethods']) )
		{
			$this->addError('('.$method['code'].') У группы методов нет методов', 1);
			return false;
		}
		
		$method['submethods'] = $this->sortByKey( $method['submethods'] );
		$pre_quote_data = array();
		
		foreach($method['submethods'] as $submethod)
		{
			if( empty( $submethod['status'] ) )
			{
				$this->addError('('.$method['code'].'.'.$submethod['code'].') Метод отключен');
				continue;
			}
			
			if( $this->is_cod )
			{
				if( $submethod['code'] != $this->code1.'.'.$this->code2 
				&& $this->code1 != 'any'
				)
				{
					continue;
				}
			}
			
			
			$pack_key = '';
			if( !empty($submethod['is_pack']) )
				$pack_key = $this->getCurrentPackKey( 
					'all', $submethod['is_pack']
				);
						
			if( !empty( $submethod['filters'] ) )
			{
				$CURRENT_ORDER = $this->getOrderWithAdds(
					'', $this->ORDER, $pack_key
				);
				
				$current_filters = $this->prepareOrderFilters($CURRENT_ORDER); 
				
				$is_in = 0;
				$is_noempty = 0;
					
				foreach($submethod['filters'] as $filter_id)
				{
					if( !empty($filter_id) )
					$is_noempty = 1;
					
					if( in_array($filter_id, $current_filters ) )
					{
						$is_in++;
					}
				}
					
				if( $is_in!= count($submethod['filters']) && $is_noempty ) 
				{
					$this->addError('('.$method['code'].'.'.$submethod['code'].') Заказ не соответствует фильтру(ам) метода');
					continue;
				}
			}
			
			if( empty( $submethod['services'] ) )
			{
				$this->addError('('.$method['code'].'.'.$submethod['code'].') Не заданы сервисы для метода');
				continue;
			}
			
			$available_services = array();
			
			foreach($submethod['services'] as $service)
			{
				$service['service'] = $this->getRealServiceKey($service['service']);
				
				if( empty($this->SERVICES[ $service['service'] ]) )
				{
					$this->addError('('.$method['code'].'.'.$submethod['code'].') Тариф '.$service['service']." отсутвует в базе");
					continue;
				}
				
				if( !empty( $this->ORDER['to']['iso_code_2'] ) && !empty($service['service']) 
					&& $service['service']!= 'free' 
					&& !preg_match("/^\d+$/", $service['service'] ))
				{
					if( $this->ORDER['to']['iso_code_2'] == 'RU' && 
						$this->SERVICES[ $service['service'] ]['area_type'] == 'FOREIGN' )
						continue;
					elseif( $this->ORDER['to']['iso_code_2'] != 'RU' && 
							$this->SERVICES[ $service['service'] ]['area_type'] == 'INNER' )
						continue;
				}
				
				if( strstr($service['service'], 'parcel_online') && !empty( $submethod["showmap"]) &&
					$submethod["pvztype"] == "NOOPS_ONLY_LIST" && empty($this->NOOPS_ONLY_LIST)
				)
				{
					$this->addError('('.$method['code'].'.'.$submethod['code'].') В населенном пункте нет почтаматов');
					continue;
				}
				
				if( 
					!empty($service['service'])
					&&
					(
						empty($service['filter']) || 
						( !empty($this->ORDER['filters']) && 
						in_array(  $service['filter'], $this->ORDER['filters'] ) )
					)
					/*
					&&
					(
						empty( $this->ORDER['is_avia_only'] ) || 
						strstr( $service['service'], 'avia' )
						
						|| !empty($this->SERVICES[ $service['service'] ]['aviasensitive'])
					)
					*/
				)
				{
					$pack_key = '';
					if( !empty($submethod['is_pack']) )
						$pack_key = $this->getCurrentPackKey(
							'all', $submethod['is_pack']
						);
						
					$CURRENT_ORDER = $this->getOrderWithAdds(
						$service['service'], $this->ORDER, $pack_key
					);
					
					
					$list = array();
					if( ($service['service'] != 'parcel' && $service['service'] != 'parcel_insured' ) || (
							$this->config->get('russianpost2_clienttype') != 'corporate' &&
							!empty( $this->SERVICES[ $service['service'] ]['options']['is_standart_available']['status'] )
						)
					)
					{
						$list[] = $service['service'];
					}
					
					if( $service['service'] == 'parcel' )
					{
						$list[] = 'parcel_20';
						$list[] = 'parcel_50';
					}
					elseif( $service['service'] == 'parcel_insured' )
					{
						$list[] = 'parcel_20_insured';
						$list[] = 'parcel_50_insured';
					}
					elseif( $service['service'] == 'parcel_insured_avia' )
					{
						$list[] = 'parcel_20_insured_avia';
						$list[] = 'parcel_50_insured_avia';
					}
					
					
					$stop = 0; 
					foreach($list as $serv_key)
					{
						if( !$stop && 
							(
								$service['service'] == 'free' 
								|| preg_match("/^[\d]+$/", $service['service']) 
								|| $this->isOrderComplianceService(
									$serv_key, 
									$CURRENT_ORDER, 
									$method['code'].'.'.$submethod['code'], 
									isset($submethod['pvztype']) ? $submethod['pvztype'] : ''
								)
							)
						)
						{
							#$stop = 1;
							$available_services[] = array(
									"order" => $CURRENT_ORDER,
									"service_key" => $serv_key
							);
						}
					}
				}
			}
			
			// ------------
			
			if( empty($available_services) )
			{
				$this->addError('('.$method['code'].'.'.$submethod['code'].') Ни один сервис не прошел по размерам/весу.');
				continue;
			}		
			
			$sort_services = array();
			
			foreach($available_services as $a_service )
			{
				if( $a_service['service_key'] == 'free' )
				{
					$cod_cost = 0;
					
					if( $this->is_cod && $this->ORDER['to']['iso_code_2'] == 'RU' )
					{
						$cod_cost = $this->getCodCost($a_service['order']['final']['total_without_shipping_rub'], 
										  0, 
										  $a_service['order']['from']['postcode']
											  ,
											  $a_service['service_key']);
					}
					
					$sort_services[] = array(
						"service_key" => $a_service['service_key'],
						"cost" => 0,
						"min_srok" => '',
						"max_srok" => '',
						"insurance" => '',
						"cod_cost" => $cod_cost
						,	
						"weight_g" => $a_service['order']['final']['sum_weight_gramm'],
						"weight_kg" => $a_service['order']['final']['sum_weight_gramm'] / 1000,
						"dimensions_cm" => $a_service['order']['final']['sum_length_cm'].'x'.
								$a_service['order']['final']['max_width_cm'].'x'.
								$a_service['order']['final']['max_height_cm']
						
					);
					
					continue;
				}
				elseif( preg_match("/^[\d]+$/", $a_service['service_key']) )
				{
					$custom_service = $this->getCustomService(
						$a_service['service_key'], 
						count( $this->PRODUCTS ) 
					);
					
					if( $custom_service )
					{
						$cod_cost = 0;
						if( $this->is_cod && $this->ORDER['to']['iso_code_2'] == 'RU' )
						{
							$cod_cost = $this->getCodCost(
											  $a_service['order']['final']['total_without_shipping_rub'], 
											  $custom_service['price'], 
											  $a_service['order']['from']['postcode']
											  ,
											  $a_service['service_key']);
						}
						
						$sort_services[] = array(
							"service_key" => $a_service['service_key'],
							"custom_service_name" => $custom_service['name'],
							"cost" => $custom_service['price'],
							"min_srok" => '',
							"max_srok" => '',
							"insurance" => '',
							"cod_cost" => $cod_cost,
							"weight_g" => $a_service['order']['final']['sum_weight_gramm'],
							"weight_kg" => $a_service['order']['final']['sum_weight_gramm'] / 1000,
							"dimensions_cm" => $a_service['order']['final']['sum_length_cm'].'x'.
								$a_service['order']['final']['max_width_cm'].'x'.
								$a_service['order']['final']['max_height_cm']
							
						);
					}
					continue;
				}
				
				$calc_service_key = $a_service['service_key'];
				$is_1rub_insured = 0;
				if( !strstr($a_service['service_key'], "insured") 
					&& $this->SERVICES[ $a_service['service_key'] ]['is_1rub_insured']
				)
				{
					$is_1rub_insured = 1;
					if( strstr($a_service['service_key'], "_registered")  )
						$calc_service_key = str_replace("_registered", '_insured', $calc_service_key);
					else
						$calc_service_key .= '_insured';
				}
				
				$pack_key = '';
				if( !empty($submethod['is_pack']) )
				$pack_key = $this->getCurrentPackKey( 'all', $submethod['is_pack'] );
				
				if( !empty($submethod['is_pack']) && 
					empty($pack_key) && 
					$this->config_get('russianpost2_is_pack_limit') == 'hide' )
				{
					$this->addError('('.$method['code'].'.'.$submethod['code'].') - не подходит ни одна упаковка');
					continue;
				}
				
				$is_stop = 0;
				
				$data = array();
				
				if( !strstr($calc_service_key, 'split') )
				{
					$data = $this->calculateService( 
						$calc_service_key, 
						$a_service['order']['final']['sum_weight_gramm'], 
						$a_service['order']['final']['sum_length_cm'], 
						$a_service['order']['final']['max_width_cm'], 
						$a_service['order']['final']['max_height_cm'],
						$is_1rub_insured ? -1 : $a_service['order']['final']['total_without_shipping_rub'], 
						$a_service['order']['from'],
						$a_service['order']['to'],
						$a_service['order']['final']['dop_cost_rub'],
						$a_service['order']['final']['dop_srok'],
						$a_service['order']['final']['dop_delivery_perc'], 
						$a_service['order']['final']['dop_cost'], 
						$pack_key
						, $this->getPvzPostcode($submethod, $calc_service_key)
						, $this->checkIsNeedSrokCalc($submethod) 
					);
				}
				else
				{
					
					$is_1rub_insured = 0;  
					
					$calc_service_key = str_replace("split_", "", $calc_service_key);
					
					if( $calc_service_key == 'parcel' )
					{
						$is_1rub_insured = !empty($this->SERVICES[ 'parcel' ]['is_1rub_insured']) 
											? 1 : 0; 
						$calc_service_key = 'parcel_50';
					}
					elseif( $calc_service_key == 'parcel_insured' )
					{ 
						$calc_service_key = 'parcel_50_insured';
					}
					#else 
					#	$calc_service_key = 'parcel_50_insured';
					

					$split_conditions = $this->getSplitConditions(
						$a_service['order'],
						!empty( $this->SERVICES[ $calc_service_key ]['service_parent'] ) ? 
						$this->SERVICES[ $calc_service_key ]['service_parent'] : 
						$calc_service_key
					);
					
					if( !$split_conditions )
					{	
						$this->addError('('.$calc_service_key.') Один из товаров не проходит по весу/габаритам/сумме_сторон для данного тарифа ');
						continue;
					}
					
					$sum_cost = 0;
					
					foreach($split_conditions as $i=>$condition)
					{ 
						
						$pack_key = '';
						if( !empty($submethod['is_pack']) )
							$pack_key = $this->getCurrentPackKey('all', $submethod['is_pack'] );
						
						
						$data = $this->calculateService( 
							$calc_service_key, 
							$condition['weight'], 
							$condition['length'], 
							$condition['width'], 
							$condition['height'],
							$is_1rub_insured ? -1 : $condition['total'], 
							$a_service['order']['from'],
							$a_service['order']['to'],
							$a_service['order']['final']['dop_cost_rub'],
							$a_service['order']['final']['dop_srok'],
							$a_service['order']['final']['dop_delivery_perc'], 
							$a_service['order']['final']['dop_cost'], 
							$pack_key
							, $this->getPvzPostcode($submethod, $calc_service_key)
							, $this->checkIsNeedSrokCalc($submethod) 
						);
						
						if( !$data )
						{
							$is_stop = 1;
							$this->addError('('.$submethod['code'].') ошибка одного из запросов в split');
						}
						else
						{
							$this->addError('Цена отправления ('.($i+1).') +'.$data['cost']);
							$sum_cost += $data['cost'];
						}
					}
					
					$this->addError('Сумма отправления: '.$sum_cost);
					$data['cost'] = $sum_cost;
				}
				
				$data['weight_g'] = $a_service['order']['final']['sum_weight_gramm'];
				$data['weight_kg'] = $a_service['order']['final']['sum_weight_gramm'] / 1000;
				$data['dimensions_cm'] = $a_service['order']['final']['sum_length_cm'].'x'.
					$a_service['order']['final']['max_width_cm'].'x'.
					$a_service['order']['final']['max_height_cm'];
				
				
				if( $a_service['order']['final']['set'] > -1 )
				{
					$this->addError('Цена доставки заданная в надбавке: '.$a_service['order']['final']['set']); 
					$data['cost'] = $a_service['order']['final']['set']; 
				}
				
				if( $data && !$is_stop  && isset($data['cost']) )
				{
					$data['service_key'] = $a_service['service_key'];
					
					$sort_services[] = $data;
				}
			}
			
			if( empty($sort_services) )
			{
				$this->addError('('.$submethod['code'].') Нет доступных сервисов');
				continue;
			} 
			
			if( $submethod['services_sorttype'] == 'order' )
			{
				$submethod['service'] = $sort_services[0];
			}
			elseif( $submethod['services_sorttype'] == 'minprice' )
			{
				$sort_services = $this->sortByKey($sort_services, 'cost' );
				$submethod['service'] = $sort_services[0];
			}
			else
			{
				$sort_services = $this->sortByKey($sort_services, 'max_srok' );
				$submethod['service'] = $sort_services[0];
			}
			
			list($submethod['code1'], $submethod['code2']) = explode(".", $submethod['code']);
			
			// ------------
			
			$pre_quote_data[] = $submethod;
		}
		
		// ----------
		
		if( empty($pre_quote_data) )
		{
			$this->addError('('.$method['code'].'.'.$submethod['code'].') Нет доступных методов', 1);
			return false;
		}
		
		if( !$this->is_cod )
		{
			$quote_data = array();
			
			foreach($pre_quote_data as $item)
			{
				if( !isset($item['service']['cost']) )
					continue;
				
				$this->addError('cost: pre_quote_data: '.$item['service']['cost'], 0);
				
				if( $this->config_get('russianpost2_is_cod_included') == 'incost' && 
					strstr( $item['service']['service_key'], 'insured' )
					
					&& 
					!empty( $item['is_show_cod'] )
				)
				{
					$item['service']['cost'] += $item['service']['cod_cost'];
				}
				
				$this->addError('cost: pre_quote_data: incost: '.$item['service']['cost'], 0);
				
				$item['service']['shipping_cost'] = $item['service']['cost'];
				
				
				if( !empty( $item['adds'] ) )
				{
					$item['submethod_dops'] = $this->getSubmethodAdds( $item['adds'], $item['service']['cost'] );
				}
				
				if( !empty( $item['submethod_dops'] ) )
				{
					list(
						$item['service']['cost'],
						$item['service']['min_srok'],
						$item['service']['max_srok']
					) = $this->addSubmethodAdds(
						$item['submethod_dops'],
						$item['service']['cost'],
						$item['service']['min_srok'],
						$item['service']['max_srok']
					);
				}
				
				$this->addError('cost: pre_quote_data: submethod_dops: cost: '.$item['service']['cost'], 0);
				
				
				if( $this->isCommissionTagInTitle($item['title']) && 
					empty($item['service']['cod_cost']) 
				)
				{
					$item['service']['cod_cost'] = $this->getCodCost(
							   $this->ORDER['final']['total_without_shipping'], 
							   $item['service']['cost'], 
							   $this->ORDER['from']['postcode']
							   ,
							   $item['service']['service_key']
					);
				}
				
				$item['service']['cost'] = $this->getOkrugl($item['service']['cost']);
				
				$this->addError('cost: pre_quote_data: okrugl: '.$item['service']['cost'], 0);
				
				$vr = '';
				list($submethod_title, $submethod_title_with_no_pvz) = $this->getSubmethodTitle($item);
				list($submethod_description, $submethod_description_with_no_pvz) = $this->getSubmethodTitle($item, true);
				
				$quote_data[$item['code2']] = array(
					'code'         => $item['code1'].'.'.$item['code2'],
					'title'        		=> $submethod_title,
					'title_with_no_pvz' => $submethod_title_with_no_pvz,
					'description'        => $submethod_description,
					'description_with_no_pvz' => $submethod_description_with_no_pvz,
					
					'html_image'   =>  $this->config_get('russianpost2_icons_format') == 'inname' ? $this->isAddHtmlImage($item) : '',
					'img'   => $this->config_get('russianpost2_icons_format') == 'inimg' ? $this->getSubmethodImg($item, 60, 32) : '',
					'image'   => $this->config_get('russianpost2_icons_format') == 'inimage'  ? $this->getSubmethodImg($item ) : '',
					'raw_image' =>$item['image'],
					'is_show_image' => !empty($submethod['is_show_image']) ? true : false,
					'image_width' =>$item['image_width'],
					'image_height' =>$item['image_height'],  
					
					'russianpost2_weight_gramm' => $item['service']['weight_g'],
					'russianpost2_dimensions_cm' => $item['service']['dimensions_cm'],
					'service_key' =>$item['service']['service_key'],
					"srok" => $this->implodeSrok($item['service']['min_srok'], $item['service']['max_srok']),
					
					'cod_cost'         => isset($item['service']['cod_cost']) ? $this->customConvert( $item['service']['cod_cost'], $this->SYST['RUB'], $this->SYST['config_currency'] ) : false,

					'cost'         => $this->customConvert( $item['service']['cost'], $this->SYST['RUB'], $this->SYST['config_currency'] ),
					'tax_class_id' => $this->config_get('russianpost2_tax_class_id'),
					'text'         => $this->currency->format( $this->tax->calculate($this->customConvert( $item['service']['cost'], $this->SYST['RUB'], $this->SYST['config_currency'] ), $this->config_get('russianpost2_tax_class_id'), $this->config_get('config_tax') ) ) ,
					'showmap' => isset($item['showmap']) ? $item['showmap'] : 0,
					'pvztype' => isset($item['pvztype']) ? $item['pvztype'] : (  
						!empty($item['showmap_skipnopay']) ? "PVZ_PAYMENT_LIST" : "PVZ_LIST"
					),
				);
			} 
			
			$method_data = array(
				'code'       => $item['code1'],
				'title'      => $this->getMethodName($method),
				'img_rp' 	 => $this->getMethodImg($method),
				'quote'      => $quote_data,
				'sort_order' => $this->getMethodSortOrder($method_number, $method),
				'error'      => false
			);
			
			return $method_data;
		}
		else
		{
			if(  $this->config->get("simple_status") && isset($this->session->data['simple']) || $this->code1 == 'any' )
				return array(
							isset($pre_quote_data[0]['service']['cod_cost']) ? $pre_quote_data[0]['service']['cod_cost'] : 0, 
							$pre_quote_data[0]['service']['cost'],
						);
			else
			{
				foreach($pre_quote_data as $item)
				{
					if( $item['code1'] == $this->code1 && 
						$item['code2'] == $this->code2 && 
						!empty( $item['is_show_cod'] )
					)
					{
						return array(
							$item['service']['cod_cost'],
							$item['service']['cost'],
						);
					}
				}
			}
		}
		
		
		/*
			$quote_data['item'] = array(
				'code'         => 'item.item',
				'title'        => $this->language->get('text_description'),
				'cost'         => $this->config_get('item_cost') * $items,
				'tax_class_id' => $this->config_get('item_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($this->config_get('item_cost') * $items, $this->config_get('item_tax_class_id'), $this->config_get('config_tax')))
			);

			$method_data = array(
				'code'       => 'item',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config_get('item_sort_order'),
				'error'      => false
			);
		*/
	}
	
	private function getMethodSortOrder($method_number, $method)
	{	
		$sort_order = 0;
		$is_in = 0;

		if( !empty($method['sort_orders']) && !empty($this->ORDER['filters']) )
		{
			foreach($method['sort_orders'] as $item)
			{
				foreach($this->ORDER['filters'] as $filter_id)
				{
					if( $item['filter'] == $filter_id )
					{
						$is_in = 1;
						$sort_order = (float)$item['sort_order'];
					}
				}
			}
		}

		if( !$is_in )
		{
			$sort_order = (float)$method['sort_order'];
		} 
		
		if( $this->config_get('russianpost2_sort_order_type') == 'absolute' )
		{
			return $sort_order;
		}
		else
		{
			if( $sort_order == 0 )
				return (float)$this->config_get('russianpost2_sort_order');
			else
				return (float)$this->config_get('russianpost2_sort_order') + ( (float)$sort_order / 10 );
		}
	}
	
	private function getSubmethodAdds($adds, $delivery_cost)
	{
		$adds_ar = array();
		if( is_array($adds) )
		{
			foreach( $adds as $adds_id)
			{
				$adds_ar[] = (int)$adds_id;
			}
		}
		else
		{
			$adds_ar[] = (int)$adds;
		}
		
		
		$query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_adds 
									WHERE adds_id IN (".implode(",", $adds_ar).")");
		
		if( !empty($query->rows) )
		{
			$results = array();
			
			foreach($query->rows as $row)
			{
				$data = unserialize($row['data']);
				if( empty($data['status']) ) continue;
				
				if( !empty( $row['filter_deliverycost_from'] ) )
				{
					if( $delivery_cost < $row['filter_deliverycost_from'] )
						continue;
				}
				
				if( !empty( $row['filter_deliverycost_to'] ) )
				{
					if( $delivery_cost > $row['filter_deliverycost_to'] )
						continue;
				}
				
				$results[] = array(
					"cost" => $data['cost'],
					"srok" => $data['srok'],
					"costtype" => $data['costtype'],
				);
			}
			
			return $results;
		}
	}
	
	private function addSubmethodAdds($adds, $cost, $min_srok, $max_srok)
	{
		$result = array(
			"cost" => $cost,
			"min_srok" => (int)$min_srok,
			"max_srok" => (int)$max_srok,
		);
		
		foreach($adds as $item)
		{
			if( empty($item['costtype']) || 
				$item['costtype'] == 'fix' )
			{
				$result['cost'] += $item['cost'];
			}
			elseif( $item['costtype'] == 'fix2products' )
			{
				$result['cost'] += $item['cost'] * count( $this->PRODUCTS );
			}
			elseif( $item['costtype'] == 'delivery_perc' )
			{
				$result['cost'] += ($cost * $item['cost'] / 100 );
			}
			elseif( $item['costtype'] == 'products_perc' )
			{
				$result['cost'] += ($this->ORDER['final']['total_without_shipping'] * $item['cost'] / 100 );
			}
			elseif( $item['costtype'] == 'total_perc' )
			{
				$result['cost'] += (($this->ORDER['final']['total_without_shipping'] + $cost) * $item['cost'] / 100 );
			}
			
			if( !empty( $item['min_srok'] ) || !empty( $item['max_srok'] )  )
			{
				$result['min_srok'] += (int)$item['srok'];
				$result['max_srok'] += (int)$item['srok'];
			}
		}
		
		
		foreach($adds as $item)
		{
			if( $item['costtype'] == 'minvalue' && $result["cost"] < $item['cost'] )
			{
				$result['cost'] = $item['cost'];
			}
		} 
		
		if( $result["cost"] < 0 )
			$result["cost"] = 0;
		
		return array(
			$result["cost"],
			$result["min_srok"],
			$result["max_srok"]
		);
	}			
	
	private function getMethodName( $method )
	{
		$title = html_entity_decode($method['title'][ $this->config_get('config_language_id') ], ENT_QUOTES, 'UTF-8');;
		
		if( !empty($method['is_show_image']) && 
			file_exists(DIR_IMAGE.$method['image']) && 
			!strstr($method['image'], "no_image") 
		)
		{
			$this->load->model('tool/image');
			
			$html = $this->config_get('russianpost2_submethod_image_html');
			
			$image_url = $this->model_tool_image->resize( $method['image'], $method['image_width'], $method['image_height'] );
			
			$html = str_replace("{title}", $title, $html);
			$html = str_replace("{image_url}", $image_url, $html);
			$html = str_replace("{width}", $method['image_width'], $html);
			$html = str_replace("{height}", $method['image_height'], $html);
			
			$title = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
		}
		
		return $title;
	}
	
	private function plusNds( $cost )
	{
		$koef = $this->NDS_KOEF; 
		 
		return $cost * $koef;
	}
	
	private function minusNds( $cost )
	{
		$koef = $this->NDS_KOEF; 
		 
		return $cost / $koef; 
	}
	
	private function custom_unserialize($s)
	{
		if( is_array($s) ) return $s;
	
		if(
			stristr($s, '{' ) != false &&
			stristr($s, '}' ) != false &&
			stristr($s, ';' ) != false &&
			stristr($s, ':' ) != false
		){
			return unserialize($s);
		}else{
			return $s;
		}

	}
	
	public function formatData($text, $data)
	{
		if( is_array($text) )
		{
			if( isset($text[ $this->config_get('config_language_id') ]) )
				$text = $text[ $this->config_get('config_language_id') ];
			else
				return "";
		}
		else
		{
			$text = $this->config_get($text);
			$text = $this->custom_unserialize($text);
			
			if( isset($text[ $this->config_get('config_language_id') ]) )
				$text = $text[ $this->config_get('config_language_id') ];
			else
				return "";
		}
		
		if( !empty($text) && !empty($data) )
		{
			foreach($data as $key=>$val)
			{
				if( is_string($val) || is_int($val) || is_float($val)  )
					$text = str_replace("{".$key."}", $val, $text);
				else
					$text = str_replace("{".$key."}", "", $text);
			}
		}
		
		return $text;
	}
	
	private function getMethodImg($method, $width=0, $height=0)
	{ 
		if( file_exists(DIR_IMAGE.$method['image']) && 
			!strstr($method['image'], "no_image") 
		)
		{
			if( !$width )
			{
				$width = $method['image_width'];
				$height = $method['image_height'];
			}
			
			$this->load->model('tool/image');
				
			$image_url = $this->model_tool_image->resize( 
					$method['image'], 
					$width, 
					$height
			);
			
			return $image_url;
		}
	}
	
	private function getSubmethodImg($submethod, $width=0, $height=0)
	{
		if( !empty($this->request->get['route']) 
			&&
			$this->request->get['route'] == 'api/shipping/methods'
		)
		{
			return;
		}
		
		if( !empty($submethod['is_show_image']) && 
			file_exists(DIR_IMAGE.$submethod['image']) && 
			!strstr($submethod['image'], "no_image") 
		)
		{
			if( !$width )
			{
				$width = $submethod['image_width'];
				$height = $submethod['image_height'];
			}
			
			$this->load->model('tool/image');
				
			$image_url = $this->model_tool_image->resize( 
					$submethod['image'], 
					$width, 
					$height
			);
			
			return $image_url;
		}
	}
	 
	private function getPvzListByListtype($listtype)
	{
		$ops_list = array();
		
		if($listtype == 'OPS_ONLY_PAYMENT_LIST' )
			$ops_list = $this->OPS_ONLY_PAYMENT_LIST; 
		elseif($listtype == 'OPS_ONLY_LIST' )
			$ops_list = $this->OPS_ONLY_LIST; 
		elseif($listtype == 'NOOPS_ONLY_PAYMENT_LIST' )
			$ops_list = $this->NOOPS_ONLY_PAYMENT_LIST; 
		elseif($listtype == 'NOOPS_ONLY_LIST' )
			$ops_list = $this->NOOPS_ONLY_LIST; 
		elseif($listtype == 'PVZ_PAYMENT_LIST' )
			$ops_list = $this->PVZ_PAYMENT_LIST; 
		elseif($listtype == 'PVZ_LIST' )
			$ops_list = $this->PVZ_LIST;
		
		return $ops_list;
	}	
	
	private function getPvzPostcode($submethod, $service_key)
	{
		$listtype = $this->RP2->getPvzType($submethod, $service_key);
		
		if( !$listtype )
			return '';
		
		$ops_list = $this->getPvzListByListtype($listtype);  
		
		if( !$ops_list )
			return '';
		
		
		if( !empty($this->rp_selected_pvz[ $listtype ]) && $this->isPvzIn($ops_list, $this->rp_selected_pvz[ $listtype ]) )
		{
			return $this->rp_selected_pvz[ $listtype ];
		}
			
		if( strstr( $service_key, 'parcel_online' ) || strstr( $service_key, 'ecom_marketplace' ) )
		{
			if( strstr($submethod['pvztype'], "NOOPS") )
			{
				foreach($ops_list as $ops)
				{
					if( preg_match("/^9/", $ops['postcode']) )
					{
						return $ops['postcode'];
					}
				}
			} 
		}
	}
	
	private function checkIsNeedSrokCalc($submethod)
	{
		$russianpost2_ops_descblock = $this->config_get('russianpost2_ops_descblock');
		
		if( !empty( $russianpost2_ops_descblock[ $this->config_get('config_language_id') ] ) && 
			( strstr($russianpost2_ops_descblock[ $this->config_get('config_language_id') ], "{srok_block}") || 
			  strstr($russianpost2_ops_descblock[ $this->config_get('config_language_id') ], "{srok}") 
			) 
		)
		{
			return true;
		}
		if( empty($submethod['title']) || !is_array($submethod['title']) )
			return false;
		
		foreach($submethod['title'] as $title)
		{
			if( strstr($title, "{srok_block}") || strstr($title, "{srok}") || strstr($title, "{srok_date}") )
				return true;
		}
		
		if( empty($submethod['desc']) || !is_array($submethod['desc']) )
			return false;
		
		foreach($submethod['desc'] as $desc)
		{
			if( strstr($desc, "{srok_block}") || strstr($desc, "{srok}") || strstr($desc, "{srok_date}") )
				return true;
		}
		
		return false;
	}
	
	private function getSubmethodTitle( $submethod, $is_desc = false)
	{
		if ( $is_desc && !isset($submethod['desc']) )
			return ['', ''];
		$country_block = "";
		
		$russianpost2_tag_country_block = $this->config_get('russianpost2_tag_country_block');
		
		if( isset($russianpost2_tag_country_block[ $this->config_get('config_language_id') ]) 
			&&
			$this->ORDER['to']['iso_code_2'] != 'RU' 
		)
		{
			$country_block = $russianpost2_tag_country_block[ $this->config_get('config_language_id') ];
			$country_block = str_replace("{to_country}", $this->ORDER['to']['country'], $country_block);
		}
		
		// ---------
		
		$insurance_block = '';
		$russianpost2_tag_insurance_block = $this->config_get('russianpost2_tag_insurance_block');
		
		if( isset($russianpost2_tag_insurance_block[ $this->config_get('config_language_id') ]) 
			&&
			$submethod['service']['insurance'] 
			&&
			strstr($submethod['service']['service_key'], 'insured')
		)
		{
			$insurance_block = $russianpost2_tag_insurance_block[ $this->config_get('config_language_id') ];
			$insurance_block = str_replace("{insurance}", $submethod['service']['insurance'], $insurance_block);
		}
		
		// ---------
		
		$srok_date = ""; 
		
		if(  (int)$submethod['service']['max_srok']  )
		{
			$srok_date = date("d.m.Y", strtotime("+".$submethod['service']['max_srok']." day")); 
		}
		$srok_block = "";
		
		$russianpost2_tag_srok_block = $this->config_get('russianpost2_tag_srok_block');
		
		if( isset($russianpost2_tag_srok_block[ $this->config_get('config_language_id') ]) 
			&&
			$submethod['service']['min_srok'] 
		)
		{
			$srok_block = $russianpost2_tag_srok_block[ $this->config_get('config_language_id') ];
			
			$srok_block = str_replace("{srok}", $this->implodeSrok($submethod['service']['min_srok'], $submethod['service']['max_srok']), $srok_block);
		
			if( $submethod['service']['max_srok'] )
				$srok_block = str_replace("{srok_date}", 
					$srok_date, 
					$srok_block
				);
		}
		
		// ---------
		
		$service_name = '';
		$service_name_z = '';
		if( !empty($submethod['service']['custom_service_name']) )
		{
			$service_name = $submethod['service']['custom_service_name'];
			$service_name_z = '';
		}
		elseif( $submethod['service']['service_key'] == 'free' )
		{
			$service_name = '';
			$service_name_z = '';
		}
		else
		{
			$service_name = $this->SERVICES[ $submethod['service']['service_key'] ]['service_name'];
			$service_name_z = $this->SERVICES[ $submethod['service']['service_key'] ]['service_name_z'];
		}
		
		$russianpost2_tag_commission_block = $this->config_get('russianpost2_tag_commission_block');
				
		$commission = '';
		$commission_block = '';
		if( !empty($submethod['service']['cod_cost']) )
		{
			$commission = $this->currency->format( $this->customConvert(  
				$submethod['service']['cod_cost'], 
				$this->SYST['RUB'], 
				$this->SYST['config_currency'] ), $this->SYST['config_currency'] );
				
			$commission_block = $russianpost2_tag_commission_block[ $this->config_get('config_language_id') ];
			$commission_block = str_replace("{commission}", $commission, $commission_block);
		}
		
		$key = 'title';
		if( $is_desc )
			$key = 'desc';
		
		$title = html_entity_decode($this->formatData( $submethod[$key], 
			array(
					"service_name" => $service_name,
					"service_name_z" => $service_name_z,
					"from_region" => $this->ORDER['from']['zone'],
					"from_city" => $this->ORDER['from']['city'],
					"to_country" => $this->ORDER['to']['country'],
					"country_block" => $country_block,
					"to_region" => isset($this->ORDER['to']['zone']) ? $this->ORDER['to']['zone'] : '' ,
					"to_city" => $this->ORDER['to']['city'],
					"insurance" => $submethod['service']['insurance'],
					"insurance_block" => $insurance_block,
					"commission" => $commission,
					"commission_block" => $commission_block,
					"weight_kg" => round($submethod['service']['weight_kg'], 2),
					"weight_g" => round($submethod['service']['weight_g']),
					"dimensions_cm" => $submethod['service']['dimensions_cm'],
					"shipping_cost" => $submethod['service']['shipping_cost'],
					"srok" => $this->implodeSrok($submethod['service']['min_srok'], $submethod['service']['max_srok']),
					"srok_block" => $srok_block,
					"srok_date" => $srok_date,
			)
		), ENT_QUOTES, 'UTF-8');	
		
		$title_with_no_pvz = $title;
		if( strstr($title, "{ops_block}") || strstr($title, "{pvz_block}") || 
			strstr($title, "{pvz_partners_block}") ||  
			 strstr($title, "{pvz_rupost_block}") || !empty($submethod['showmap']) )
		{
			
			$listtype = $this->RP2->getPvzType($submethod, $submethod['service']['service_key']); 
			$ops_list = $this->getPvzListByListtype($listtype);  
			
			
			$ops_block = '';
			 
			
			if( $ops_list )
			{
				$firstOps = array();
				
				if( !empty($this->rp_selected_pvz[ $listtype ]) )
				{
					$firstOps = $this->getCurrentOpsByCode(
						$this->rp_selected_pvz[ $listtype ],
						$ops_list
					);
				} 
				elseif( !empty( $this->rp_selected_pvz) )
				{
					foreach($this->rp_selected_pvz as $lt=>$postcode)
					{
						if( $lt !== $listtype )
						{
							if( !empty($this->rp_selected_pvz[ $lt ]) && 
								$firstOps = $this->getCurrentOpsByCode(
									$this->rp_selected_pvz[ $lt ], 
									$ops_list
								)
							)
								break;
						}
					}
				}
				elseif( !empty($ops_list[0]) )
				{
					$firstOps = $ops_list[0];
				}
				
				$ar = explode(",", $firstOps['address']);
				unset($ar[0]);
				
				$firstOps['address'] = implode(",", $ar);
								 
				$ops_block = $this->formatData( 	
					'russianpost2_tag_ops_block', 
					array(
						'ops_address'  => $firstOps['address'],
						'postcode'   => $firstOps['postcode'],
						'ops_worktime' => $this->getWorkTime( $firstOps['wtime'] ) 
					)
				);
			}	   
			
			$title .= " ".strip_tags(html_entity_decode($ops_block, ENT_QUOTES, 'UTF-8'), "<span>"); 
			$title_with_no_pvz .= " {ops_block}";
		}
		
		
		$title_with_no_pvz = str_replace("{ops_block}", "", $title_with_no_pvz);
		$title_with_no_pvz = str_replace("{pvz_block}", "", $title_with_no_pvz);
		$title_with_no_pvz = str_replace("{pvz_partners_block}", "", $title_with_no_pvz);
		$title_with_no_pvz = str_replace("{pvz_rupost_block}", "", $title_with_no_pvz);
		
		$title = str_replace("{ops_block}", "", $title);
		$title = str_replace("{pvz_block}", "", $title);
		$title = str_replace("{pvz_partners_block}", "", $title);
		$title = str_replace("{pvz_rupost_block}", "", $title);
		
		return array($title, $title_with_no_pvz); 
	}
	
	// Диспетчерская функция между API
	private function calculateService($service_key, $weight_gramm, $sum_length_cm, $max_width_cm, $max_height_cm, $total_without_shipping_rub, $from, $to, $dop_cost_rub, $dop_srok
	 
		, $dop_delivery_perc 
		, $dop_delivery_cost  
		, $pack_key
		, $pvz_postcode 
		, $is_need_srok_calc
	) 
	{
		$this->addError('calculate service: '.$this->SERVICES[ $service_key ]['service_name'].' ('.$service_key.') '.' | '.$weight_gramm.' g | '.$sum_length_cm.'x'.$max_width_cm.'x'.$max_height_cm.' cm | '.$total_without_shipping_rub.' rub | '.$from['ems_code'].' - '.$from['city'].' - '.$from['iso_code_2'].' - '.$to['ems_code'].' - '.$to['city'].' - '.$dop_cost_rub, 0);
		
		#$top_service_key = $this->getTopServiceKey( $service_key );
		
		$result = array();
		
		$sources = $this->getServiceSources( $service_key, $to['postcode'] );
		
		if( !$sources )
		{
			$this->addError('API сервиса '.$service_key." - отключены", 0);
			return false; 
		}
		else
		{
			$this->addError('Доступные API: '.print_r($sources, 1), 0);
		}
		
		if( $pack_key && !empty($this->PACKS[ preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key ]['price']) )
		{
			$total_without_shipping_rub += (float)$this->PACKS[ preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key ]['price'];
		}
		 
		foreach($sources as $source)
		{   
			if( $source == 'otpravka' && ( empty($to['postcode']) && $to['iso_code_2'] == 'RU' ) )
			{
				$this->addError('Почтовый Индекс получателя неизвестен, API сервиса '.$service_key." не работает если неизвестен индекс", 0);
				continue;
			} 
			
			if( $source == 'tariff' && 
				$to['iso_code_2'] == 'RU' && 
				empty($to['postcode']) ) 
			{
				$this->addError('Почтовый Индекс получателя неизвестен, API сервиса '.$service_key." не работает если неизвестен индекс", 0);
				continue;
			}
			
			if( $source == 'tariff' )
			{
				$tariff_data = $this->getTariffData( 
					$service_key, 
					$weight_gramm, 
					$sum_length_cm, 
					$max_width_cm, 
					$max_height_cm,
					$total_without_shipping_rub, 
					$from, 
					$to,
					$dop_cost_rub,
					$pack_key
					, $pvz_postcode
				);
				
				if( $tariff_data == 'curl_error' )
				{
					$this->addError('TARIFF - curl error', 0);
					continue; 
				}
				
				if( empty($tariff_data['cost']) )
				{
					$this->addError('TARIFF - рассчет неудался', 0);
					break;
				}
				else
				{
					if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) 
						|| !$this->config_get('russianpost2_is_nds')
					)
					{		
						$this->addError('cost (no nds): '.$tariff_data['cost'], 0);
					}
					else
					{
						$this->addError('cost (nds included): '.$tariff_data['cost'], 0);
					}
					
					$cod_cost = 0;
					
					if( $this->is_cod || 
						$this->config_get('russianpost2_is_cod_included') == 'incost' )
					{
						
						$cod_cost = $this->getCodCost($total_without_shipping_rub, 
								   $tariff_data['cost'], 
								   $from['postcode']
								   ,
								   $service_key);
					}
					
					
					if( $this->config_get('russianpost2_is_cod_included') == 'incost' )
					{
						###$tariff_data['cost'] += $cod_cost;
					}
					
					
					
					$result = array(
							"cost" => $tariff_data['cost'],
							"min_srok" => isset( $tariff_data['min_srok'] ) ?  $tariff_data['min_srok'] : 0,
							"max_srok" => isset( $tariff_data['max_srok'] ) ?  $tariff_data['max_srok'] : 0,
							"insurance" => $this->getInsuranceCostText($service_key, 
							$total_without_shipping_rub, $tariff_data['cost'] ),
							"cod_cost" => $cod_cost, 
							"is_pack_off" => isset($tariff_data['is_pack_off']) ? $tariff_data['is_pack_off'] : 0
							
					);
				}
			}
			elseif( $source == 'postcalc' )
			{
				$postcalc_data = $this->getPostcalcData( 
					$service_key, 
					$weight_gramm, 
					$sum_length_cm, 
					$max_width_cm, 
					$max_height_cm,
					$total_without_shipping_rub, 
					$from, 
					$to,
					$dop_cost_rub
					, $pvz_postcode
				);
				
				if( $postcalc_data == 'curl_error' )
				{
					$this->addError('POSTCALC - curl error', 0);
					continue; 
				}
				
				if( empty($postcalc_data['cost']) )
				{
					$this->addError('POSTCALC - рассчет неудался', 0);
					break;
				}
				else
				{
					$this->addError('cost: base-postcalc: '.$postcalc_data['cost'], 0);
					
					$postcalc_data['cost'] = $this->plusOptionsCost( $service_key, $postcalc_data['cost'] );
					
					$this->addError('cost: after plusOptionsCost: '.$postcalc_data['cost'], 0);
					
					if( $this->config_get('russianpost2_cod_tariftype') == 'set' 
							&&
							$this->config_get('russianpost2_cod_tariftype_percent')
					)
					{
						$total_rub = $this->getInsuranceCostRUB( $total_without_shipping_rub, $postcalc_data['cost'] );
						$postcalc_data['cod_cost'] = $total_rub * (float)$this->config_get('russianpost2_cod_tariftype_percent') / 100;
							
						if( $this->config_get('russianpost2_cod_tariftype_minvalue') 
							&&
							$postcalc_data['cod_cost'] < (float)$this->config_get('russianpost2_cod_tariftype_minvalue')
						)
						{
							$postcalc_data['cod_cost'] = (float)$this->config_get('russianpost2_cod_tariftype_minvalue');
						}
					}
					
					if( $this->config_get('russianpost2_is_cod_included') == 'incost' )
					{
						###$postcalc_data['cost'] += $postcalc_data['cod_cost'];
					}
					
					$result = array(
							"cost" => $postcalc_data['cost'],
							"min_srok" => $postcalc_data['min_srok'],
							"max_srok" => $postcalc_data['max_srok'],
							"insurance" => $this->getInsuranceCostText($service_key, $total_without_shipping_rub, $postcalc_data['cost'] ),
							"cod_cost" => $postcalc_data['cod_cost']
					);
				}
			}
			elseif( $source == 'otpravka' )
			{
				$otpravka_data = $this->getOtpravkaData( 
					$service_key, 
					$weight_gramm, 
					$sum_length_cm, 
					$max_width_cm, 
					$max_height_cm,
					$total_without_shipping_rub, 
					$from, 
					$to,
					$dop_cost_rub,
					$this->ORDER['is_caution']
					, $pvz_postcode
				); 
				
				if( $otpravka_data == 'curl_error' )
				{
					$this->addError('otpravka.pochta.ru - curl error', 0);
					continue; 
				}

				
				if( empty($otpravka_data['cost']) )
				{
					$this->addError('otpravka.pochta.ru - рассчет неудался', 0);
					continue;
				}
				else
				{
					$this->addError('cost: base-otpravka: '.$otpravka_data['cost'], 0);
					
					$otpravka_data['cost'] = $this->plusOptionsCost( $service_key, $otpravka_data['cost'] );
					
					$this->addError('cost: after plusOptionsCost: '.$otpravka_data['cost'], 0);
					
					$result = array(
							"cost" => $otpravka_data['cost'],
							"min_srok" => $otpravka_data['min_srok'],
							"max_srok" => $otpravka_data['max_srok'],
							
							"insurance" => $this->getInsuranceCostText($service_key, $total_without_shipping_rub, $otpravka_data['cost']),
					);
					
					if( $this->is_cod || $this->config_get('russianpost2_is_cod_included') == 'incost'  )
					{
						$total_rub = $this->getInsuranceCostRUB( $total_without_shipping_rub, $otpravka_data['cost'] );
						 
						if( $this->config_get('russianpost2_cod_tariftype') == 'set' 
								&&
								$this->config_get('russianpost2_cod_tariftype_percent')
						)
						{
							$result["cod_cost"] = $total_rub * (float)$this->config_get('russianpost2_cod_tariftype_percent') / 100;
								
							if( $this->config_get('russianpost2_cod_tariftype_minvalue') 
								&&
								$result["cod_cost"] < (float)$this->config_get('russianpost2_cod_tariftype_minvalue')
							)
							{
								$result["cod_cost"] = (float)$this->config_get('russianpost2_cod_tariftype_minvalue');
							}
						
							if( $this->config_get('russianpost2_is_cod_included') == 'incost' 
								&& $result['cod_cost'])
							{
							###	$result['cost'] += $result['cod_cost'];
							}
						}
						else
						{
							$result["cod_cost"] = 0;							
							if( $cod_cost = $this->getTariffCodPrice($total_rub, $from['postcode'], $service_key) )
							{
								$result["cod_cost"] = $cod_cost;
							}  
						
							if( $this->config_get('russianpost2_is_cod_included') == 'incost' 
								&& $result['cod_cost']
							)
							{
							###	$result['cost'] += $result['cod_cost'];
							}
						}
					}
				}
			}
			break;
		}
		 
		
		if( empty($result["cost"]) )
		{
			return false;
		}
		
		if( isset($result["cost"]) )
		{
			if( !empty($dop_delivery_perc)  )
			{
				$result["cost"] += $result["cost"] * $dop_delivery_perc / 100;
			}
			
			$this->addError('cost: dop_delivery_perc: '.$result["cost"], 0);
			
			if( !empty($dop_cost_rub)  )
			{
				$result["cost"] += $dop_cost_rub;
			}
			
			$this->addError('cost: dop_delivery_cost: '.$result["cost"], 0);
			
			if( $pack_key && empty($result["is_pack_off"]) )
			{
				if( preg_match("/^\d+$/", $pack_key) )
				{
					$pack_key -= 1;
				} 
				
				$result["cost"] += $this->PACKS[ $pack_key ]['price'];
			}
				
			$this->addError('cost: PACKS: '.$result["cost"], 0);
		}
		
		if( $this->ORDER['to']['iso_code_2'] != 'RU' )
			return $result;
		
		if( $this->config_get('russianpost2_customsrok') 
			&& isset($this->SERVICES[ $service_key ]['transport_type']) 
			&& !empty($this->ORDER['to']['ems_code']) 
			&& !empty($this->ORDER['to']['iso_code_2']) 
			&& $this->ORDER['to']['iso_code_2'] == 'RU'
		)
		{
			$russianpost2_customsrok = $this->config_get('russianpost2_customsrok');
			$key = strtolower($this->SERVICES[ $service_key ]['transport_type']);
			if( !empty($this->ORDER['is_capital']) )
				$key .= '_capital';
			else
				$key .= '_region';
			
			if( !empty($russianpost2_customsrok[ $this->ORDER['to']['ems_code'] ][ $key.'_from' ]) )
				$result["min_srok"] = $russianpost2_customsrok[ $this->ORDER['to']['ems_code'] ][ $key.'_from' ];
			
			if( !empty($russianpost2_customsrok[ $this->ORDER['to']['ems_code'] ][ $key.'_to' ]) )
				$result["max_srok"] = $russianpost2_customsrok[ $this->ORDER['to']['ems_code'] ][ $key.'_to' ];
		}
		
		
		if( $is_need_srok_calc )
		{
			if( empty($result["max_srok"]) )
			{
				$this->addError('TARIFF SROK REQUEST(1): start', 0);
				
				if( $tariff_data = $this->getTariffSrok($service_key, 
								   $weight_gramm, 
								   $sum_length_cm, 
								   $max_width_cm, 
								   $max_height_cm,  
								   $total_without_shipping_rub, 
								   $from, 
								   $to, 
								   $dop_cost_rub
				))
				{
					$result["min_srok"] = $tariff_data["min_srok"];
					$result["max_srok"] = $tariff_data["max_srok"];
				}
				
				if( !empty($tariff_data) )
				{
					if( isset($tariff_data['max_srok']) )
						$result["max_srok"] = $tariff_data['max_srok'];
					
					if( isset($tariff_data['min_srok']) )
						$result["min_srok"] = $tariff_data['min_srok'];
				
					if( isset($tariff_data['min_srok']) && isset($tariff_data['max_srok']) )
						$this->addError('TARIFF SROK REQUEST(1): '.$result["min_srok"].'-'.$result["max_srok"].' END', 0);
					else
					{
						$this->addError('TARIFF SROK REQUEST(1): nodata-1', 0);
						$result["min_srok"] = '';
						$result["max_srok"] = '';
					}
				}
				else
				{
					$this->addError('TARIFF SROK REQUEST(1): nodata-2', 0);
				}
			}
			
			if( empty($result["max_srok"]) && $this->config_get('russianpost2_if_nosrok_calculated_additional') &&
				$to['city'] != $this->ORDER['to']['capital']
			)
			{
				$this->addError('TARIFF SROK REQUEST(2): start', 0);
				$custom_to = $to;
				
				$custom_to['user_postcode'] = $this->ORDER['to']['capital_postcode'];
				$custom_to['city'] = $this->ORDER['to']['capital'];
				
				$tariff_data = $this->getTariffSrok($service_key, 
								   $weight_gramm, 
								   $sum_length_cm, 
								   $max_width_cm, 
								   $max_height_cm,  
								   $total_without_shipping_rub, 
								   $from, 
								   $to, 
								   $dop_cost_rub
				);
				
				if( !empty($tariff_data) )
				{
					if( isset($tariff_data['max_srok']) )
						$result["max_srok"] = $tariff_data['max_srok'];
					
					if( isset($tariff_data['min_srok']) )
						$result["min_srok"] = $tariff_data['min_srok'];
				
					if( isset($tariff_data['min_srok']) && isset($tariff_data['max_srok']) )
						$this->addError('TARIFF SROK REQUEST(2): '.$result["min_srok"].'-'.$result["max_srok"].' END', 0);
					else
					{
						$this->addError('TARIFF SROK REQUEST(2): nodata-1', 0);
						$result["min_srok"] = '';
						$result["max_srok"] = '';
					}
				}
				else
				{
					$this->addError('TARIFF SROK REQUEST(2): nodata-2', 0);
				}
		
				if( $result["max_srok"] )
					$result["max_srok"] = (int)$result["max_srok"] + (int)$this->config_get('russianpost2_if_nosrok_calculated_additional');
					
				if( $result["min_srok"] )
					$result["min_srok"] = (int)$result["min_srok"] + (int)$this->config_get('russianpost2_if_nosrok_calculated_additional');
			} 
		}
		
		if( (int)$result["min_srok"] > 0 && (int)$dop_srok > 0 )
		{
			$result["min_srok"] = (int)$result["min_srok"] + (int)$dop_srok;
		}
		
		if( (int)$result["max_srok"] > 0 && (int)$dop_srok > 0 )
		{
			$result["max_srok"] = (int)$result["max_srok"] + (int)$dop_srok;
		}
		
		return $result;
	}
	
	private function getSrokByCity( $service_key, $from_ems_code, $from_city, $to_ems_code, $to_city )
	{
		$service_key = str_replace("_insured", "", $service_key);
		
		if( $service_key == 'parcel_20' || $service_key == 'parcel_50' )
			$service_key = 'parcel';
		
		$wh = '';
		if( $from_ems_code )
		$wh = " from_code = '".$this->db->escape($from_ems_code)."' AND ";
		
		$sql = "SELECT * FROM  " . DB_PREFIX . "russianpost2_city2city 
		WHERE 
		  ".$wh."
		   to_code = '".$this->db->escape($to_ems_code)."'
		  AND (
			from_city = '".$this->db->escape($from_city)."' OR 
			from_city LIKE '%,".$this->db->escape($from_city).",%'
		  )
		  AND (
			to_city = '".$this->db->escape($to_city)."' OR 
			to_city LIKE '%,".$this->db->escape($to_city).",%'
		  )
		  "; 
		$query = $this->db_query($sql);
		
		if( empty($query->row['data']) ) return array(0, 0);
		
		$result = $this->makeDataHash('city2city', $query->row['data']);
		
		if( !empty( $result[$service_key.'_minsrok'] ) &&
			!empty( $result[$service_key.'_maxsrok'] )
		)
		return array( $result[$service_key.'_minsrok'], $result[$service_key.'_maxsrok'] );
		
		return array(0, 0);
	}
	
	private function getSrokByRegion( $service_key, $from_ems_code, $to_ems_code, $to_city )
	{ 
		$service_key = str_replace("_insured", "", $service_key);
		
		if( $service_key == 'parcel_20' || $service_key == 'parcel_50' )
			$service_key = 'parcel';
		
		$sql = "SELECT * FROM  " . DB_PREFIX . "russianpost2_regions2regions 
		WHERE 
		   from_region = '".$this->db->escape($from_ems_code)."' AND 
		   to_region = '".$this->db->escape($to_ems_code)."'";
		  
		$query = $this->db_query($sql);
		
		if( empty($query->row['data']) ) return array(0, 0);
		
		$result = $this->makeDataHash('regions2regions', $query->row['data']);
		
		if( !empty( $result[$service_key.'_minsrok'] ) &&
			!empty( $result[$service_key.'_maxsrok'] )
		)
		{
			$sql = "SELECT * FROM  " . DB_PREFIX . "russianpost2_regions  
			WHERE 
			   ems_code = '".$this->db->escape($to_ems_code)."' AND 
			   capital = '".$this->db->escape($to_city)."'";
			  
			$query = $this->db_query($sql);
			
			if( !$query->row )
			{ 
				return array( $result[$service_key.'_minsrok']+1, $result[$service_key.'_maxsrok']+2 );
			}
			else
			{
				return array( $result[$service_key.'_minsrok'], $result[$service_key.'_maxsrok'] );
			}
			
			
		}
		return array(0, 0);
	}
	
	private function getCustomServices( )
	{
		return $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_customs ")->rows;
	}
	
	private function getCustomService($custom_id, $count_products )
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_customs 
		WHERE custom_id = '".(int)$custom_id."'");
		
		if( !$query->row )
			return array();
		
		$price = 0;
		
		if( $query->row['type'] == 'single' )
			$price = $query->row['price'];
		else
			$price = $query->row['price'] * $count_products;
		
		if( !empty($query->row['currency']) )
		{
			$price = $this->customConvert( $price, $query->row['currency'], $this->SYST['RUB'] );
		}
		
		return array(
			"name" => $query->row["name"],
			"price" => $price,
		);
	}
	
	private function plusOptionsCost($service_key, $cost)
	{
		if( !empty( $this->SERVICES[ $service_key ]['service_parent'] ) )
		{
			$service_key = $this->SERVICES[ $service_key ]['service_parent'];
		}
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_options WHERE service_key = '".$this->db->escape($service_key)."'");
		
		$options_hash = array();
		
		foreach($query->rows as $row)
		{
			$options_hash[ $row['fieldname'] ] = $row;
		}
		
		$russianpost2_options = $this->config_get('russianpost2_options');
		
		if( empty( $russianpost2_options[$service_key] ) )
			return $cost;
		
		
		$dop_cost = 0;
		foreach($russianpost2_options[$service_key] as $key=>$value)
		{
			if( empty($value['status']) ) continue;
			
			if( strstr($service_key, 'foreign') )
			{
				if( $key == 'is_notify' )
				{
					if(
						(
							strstr($service_key, 'parcel') 
							||
							strstr($service_key, 'smallpack') 
							||
							strstr($service_key, 'packm') 
						)
						&& empty($ORDER['to']['country_data']['parcels_is_notify_available']) 					
					)
					{
						continue;
					}
					elseif(
						(
							strstr($this->service_key, 'mail')  || 
							strstr($this->service_key, 'printed') 
						)
						&& empty($ORDER['to']['country_data']['letters_is_notify_available']) 					
					)
					{
						continue;
					}
				}
				
				
				if( $key == 'is_make_opis' )
				{
					if(
						(
							strstr($service_key, 'parcel') 
							||
							strstr($service_key, 'smallpack') 
							||
							strstr($service_key, 'packm') 
						)
						&& empty($ORDER['to']['country_data']['parcels_is_opis_available']) 					
					)
					{
						continue;
					}
					elseif(
						(
							strstr($this->service_key, 'mail')  || 
							strstr($this->service_key, 'printed') 
						)
						&& empty($ORDER['to']['country_data']['parcels_is_opis_available']) 					
					)
					{
						continue;
					}
				}
			}
			
			if( !empty( $options_hash[$key]['option_cost'] ) &&
				$key != 'is_check_complete' 
			) 
			{
				if( !empty($this->SERVICES[$this->service_key]['options']['is_no_nds']['status']) 
					|| !$this->config_get('russianpost2_is_nds')
				)
				{		
					$dop_cost += (float)$options_hash[$key]['option_cost'];
				}
				else
				{
					$dop_cost += (float)$this->plusNds($options_hash[$key]['option_cost']);
				}
			}
			elseif( $key == 'is_sms' )
			{
				/*
				if( !empty($this->CONFIG['config_user_with_dogovor']) )
				{
					#$dop_cost += $this->CONFIG['config_sms_cost_for_corp'];
				}
				else
				{
					#$dop_cost += $this->CONFIG['config_sms_cost_for_nocorp'];
				}
				*/
			}

		}
		
		
		return $cost + $dop_cost;
	}
	
	
	protected function getPostcodeByCityRegionCode($zone_id, $city, $is_postamats=false, $limit=0)
	{
		$wh = "";
		if( !$is_postamats )
			$wh = " AND rin.postcode NOT LIKE '9%' ";
		else
			$wh = " AND rin.postcode LIKE '9%' ";
		
		
		$wh_limit = "";
		if( $limit )
			$wh_limit = " LIMIT ".$limit; 
		
		$query = $this->db_query("SELECT rin.* FROM 
		`" . DB_PREFIX . "zone` z 
		JOIN `" . DB_PREFIX . "russianpost2_regions` r ON z.zone_id=r.id_oc
		JOIN `" . DB_PREFIX . "russianpost2_indexes` rin ON rin.region_id=r.id   
		WHERE z.zone_id = '".(int)$zone_id."'
		AND rin.city = '".$this->db->escape( trim($city) )."'".$wh." ".$wh_limit);
	
		if( $limit )
			return $query->rows;
		
		
		if( isset($query->row['postcode']) )
			return $query->row['postcode'];
			
			
		$query = $this->db_query("SELECT * FROM 
		`" . DB_PREFIX . "zone` z 
		JOIN `" . DB_PREFIX . "russianpost2_regions` r ON z.zone_id=r.id_oc
		JOIN `" . DB_PREFIX . "russianpost2_cities` rc ON rc.region_id=r.id   
		WHERE z.zone_id = '".(int)$zone_id."'
		AND rc.city = '".$this->db->escape( trim($city) )."' ");
		
		if( isset($query->row['start']) )
		return $query->row['start'];
	}	
	
	protected function getCityByPostcode($postcode)
	{
		$query = $this->db_query("SELECT * FROM `" . DB_PREFIX . "russianpost2_cities` 
		WHERE `start` = '".$this->db->escape( trim($postcode) )."' ");
		
		if( isset($query->row['city']) )
		return $query->row['city'];
	}	 
	
	protected function getRegionByPostcode($postcode)
	{
		$query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_indexes ri
								  JOIN " . DB_PREFIX . "russianpost2_regions rr ON ri.region_id = rr.id
								  WHERE ri.postcode='".(int)$postcode."'");
		if( !empty($query->row['id_oc']) )
			return array('zone_id' => $query->row['id_oc']);
		
		$index2 = substr($postcode, 0, 2);
		$index3 = substr($postcode, 0, 3);
		
		$query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_regions");
		
		$russianpost2_regions2zones = $this->config_get('russianpost2_regions2zones');
		
		$config_query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_config 
			WHERE config_key = 'regions'");
			
		foreach($query->rows as $row)
		{
			$result = $this->makeDataHash('regions', $row['data'], $config_query->row);
			
			if( strstr($result['index3'], ','.$index3.',') )
			{
				$row['zone_id'] = !empty($row['id_oc']) ? $row['id_oc'] : (
									!empty($russianpost2_regions2zones[$row['ems_code']][0]) ? 
										$russianpost2_regions2zones[$row['ems_code']][0] : '' );
				return $row;
			}
		}
		
		foreach($query->rows as $row)
		{ 
			$result = $this->makeDataHash('regions', $row['data'], $config_query->row);
			
			if(  strstr($result['index2'], ','.$index2.',')  && empty($result['index3']) )
			{
				$row['zone_id'] = !empty($row['id_oc']) ? $row['id_oc'] : (
									!empty($russianpost2_regions2zones[$row['ems_code']][0]) ? 
										$russianpost2_regions2zones[$row['ems_code']][0] : '' );
				return $row;
			}
		}
	}	
	
	public function getZoneByWidgetRegion($widget_region)
	{
		$query = $this->db_query("SELECT rr.*, z.name as name, z.zone_id 
			FROM  " . DB_PREFIX . "russianpost2_regions rr JOIN 
									" . DB_PREFIX . "zone z
								   ON
									rr.id_oc = z.zone_id");
		
		$russianpost2_regions2zones = $this->config_get('russianpost2_regions2zones');
		
		$config_query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_config 
			WHERE config_key = 'regions'");
			
		foreach($query->rows as $row)
		{
			$result = $this->makeDataHash('regions', $row['data'], $config_query->row);
			
			if( !empty($result['widget_region']) && $result['widget_region'] == $widget_region )
			{
				return $row;
			}
		}
		
		return false;
	}
	
	private function getInsuranceCostRUB($total_without_shipping_rub, $shipping_cost)
	{
		if( $this->config_get('russianpost2_insurance_base') == 'total' )
		{
			return $total_without_shipping_rub+$shipping_cost;
		}
		else
		{
			return $total_without_shipping_rub;
		}
	}
	
	private function getInsuranceCostText($service_key, $total_without_shipping_rub, $shipping_cost)
	{
		if( !strstr($service_key, "insured") )
		{
			return '';
		}
		
		if( $this->config_get('russianpost2_insurance_base') == 'total' )
		{
			return $this->currency->format( $this->customConvert(  $total_without_shipping_rub+$shipping_cost, $this->SYST['RUB'], $this->SYST['config_currency'] ) );
		}
		else
		{
			return $this->currency->format( $this->customConvert(  $total_without_shipping_rub, $this->SYST['RUB'], $this->SYST['config_currency'] ) );
		}
	}
	
	public function getApiKeyByUrl( $url )
	{
		$key = '';
		
		if( strstr($url, 'postcalc') )
			return 'postcalc'; 
		elseif( strstr($url, 'otpravka') )
			return 'otpravka';
		elseif( strstr($url, 'tariff') )
			return 'tariff';
		elseif( strstr($url, 'delivery.pochta.ru') )
			return 'tariff';
		elseif( strstr($url, 'api.print-post.com') )
			return 'print-post';
	}
	
	private function isAddHtmlImage($submethod)
	{
		if( !empty($submethod['is_show_image']) && 
			file_exists(DIR_IMAGE.$submethod['image']) && 
			!strstr($submethod['image'], "no_image") 
			&& (
			empty($this->request->get['route']) ||
			$this->request->get['route'] != 'api/shipping/methods' )
		)
			return $submethod['image'].'x'.$submethod['image_width'].'x'.$submethod['image_height'];
		else
			return 0;
	}
	
	private function isPvzService($service_key)
	{
		if( strstr($service_key, 'ecom') )
			return true;
		else
			return false;
	}
	
	
	public function setRpHTMLToQuote($shipping_methods)
	{ 
		/*
			$this->CONFIG_KEYS
		*/
		$this->prepareConfigKeys();
		
		if( $this->config_get('russianpost2_debug') )
			$this->log->write( "PR2-DEBUG: setRpHTMLToQuote start");
				
		if( empty($shipping_methods['russianpost2']['quote']) 
			&& empty($shipping_methods['russianpost2f1']['quote'])
			&& empty($shipping_methods['russianpost2f2']['quote'])
			&& empty($shipping_methods['russianpost2f3']['quote']) )
		{
			if( $this->config_get('russianpost2_debug') )
				$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M1");
			return $shipping_methods;
		}
		
		$this->setRpOpsFromSession(); 
		 
		$address = array();
		
		
		if( !empty( $this->request->get['route']  )  && 
			$this->request->get['route'] == 'quickcheckout/shipping_method' &&
			isset( $this->request->post['city'] ) 
			&&
			isset( $this->request->post['zone_id'] )   
			&&
			isset( $this->session->data['shipping_address'] )   
		)
		{
			$address = $this->session->data['shipping_address'];

			if( isset($this->request->post['city']) )
				$address['city'] = $this->request->post['city'];
			if( isset($this->request->post['zone_id']) )
				$address['zone_id'] = $this->request->post['zone_id'];
			if( isset($this->request->post['country_id']) )
				$address['country_id'] = $this->request->post['country_id'];
			if( isset($this->request->post['postcode']) )
				$address['postcode'] = $this->request->post['postcode'];
			
			
			if( $this->config_get('russianpost2_debug') )
				$this->log->write( "PR2-DEBUG: setRpHTMLToQuote use address-0");
		}
		elseif(  $this->config->get("simple_status") && !empty($this->session->data['simple']['shipping_address']) )
			$address = $this->session->data['simple']['shipping_address'];
		elseif( !empty($this->session->data['shipping_address']) )
			$address = $this->session->data['shipping_address'];
		elseif( !empty($this->session->data['payment_address']) )
			$address = $this->session->data['payment_address'];
		else
		{
			if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {					
				$address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		
			} elseif (isset($this->session->data['guest']['shipping'])) {
				$address = $this->session->data['guest']['shipping'];
			}
			
			if( empty($address) )
			{ 
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M2");
				foreach($shipping_methods as $key=>$val)
				{
					foreach( $shipping_methods[ $key ]['quote'] as $key2=>$val2 )
					{
						if( isset($shipping_methods[ $key ]['quote'][$key2]['dpd_html']) )
							$shipping_methods[ $key ]['quote'][$key2]['dpd_html'] = '';
					}
				}	
				return $shipping_methods; 
			}
		}
		
		$this->ORDER = $this->prepareOrderGeo($address);
		
		if( !$this->ORDER['to'] )
		{
			if( $this->config_get('russianpost2_debug') )
				$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M3");
			foreach($shipping_methods as $key=>$val)
			{
				foreach( $shipping_methods[ $key ]['quote'] as $key2=>$val2 )
				{
					if( isset($shipping_methods[ $key ]['quote'][$key2]['dpd_html']) )
						$shipping_methods[ $key ]['quote'][$key2]['dpd_html'] = '';
				}
			}
			return $shipping_methods;
		}
		 
		 
		$this->is_yandexjs_allready_added = 0; 
		$this->is_module_js_allready_added = 0; 
		$this->is_widget_js_allready_added = 0;  
		
		foreach($shipping_methods as $method)
		{
			foreach($method['quote'] as $quote)
			{
				if( !empty($quote['dpd_html']) && 
					strstr($quote['dpd_html'], 'https://api-maps.yandex.ru/2.1/?lang=ru_RU') )
				{
					$this->is_yandexjs_allready_added = 1;
				}
				elseif( !empty($quote['dpd_html']) && 
					strstr($quote['dpd_html'], 'https://api-maps.yandex.ru/2.1/?lang=ru_RU') )
				{
					$this->is_yandexjs_allready_added = 1;
				}
			}
		}
		
		if( $this->config_get('russianpost2_debug') )
			$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M1");
		
		$this->load->model('tool/image');
			
		$currentPvzList = array();
		$currentpvz = array();
		$is_first = 1;
		
		$ops_tags = array(
			"pvz_block", 
			"ops_block", 
			"pvz_partners_block",
			"pvz_rupost_block", 
		);      
		
		for($i=0;$i<10;$i++)
		{
			if( $this->config_get('russianpost2_debug') )
				$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M2");
			
			$txt = '';
			if( $i )
					$txt = 'f'.$i;
			if( empty($shipping_methods['russianpost2'.$txt]) )
				continue;
				
			if( $this->config_get('russianpost2_debug') )
				$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M3");
			
			foreach($shipping_methods['russianpost2'.$txt]['quote'] as $key=>$val)
			{
				$code = 'russianpost2'.$txt.'.'.$key;
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M4");
				
				if( empty( $shipping_methods['russianpost2'.$txt]  ) )
					continue;
				
				
				$shipping_mehod = $shipping_methods['russianpost2'.$txt]['quote'][$key];
				
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M5");
				 
				if( !empty($shipping_mehod['html_image']) 
					&& 
					strstr($shipping_mehod['html_image'], 'x') )
				{
					$html = $this->config_get('russianpost2_submethod_image_html');
			
					list($image, $width, $height) = explode("x", $shipping_mehod['html_image']);
					
					$image_url = $this->model_tool_image->resize($image, $width, $height );
					
					$html = str_replace("{title}", $shipping_mehod['title'], $html);
					$html = str_replace("{image_url}", $image_url, $html);
					$html = str_replace("{width}", $width, $html);
					$html = str_replace("{height}", $height, $html);
					
					$shipping_mehod['title'] = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
					$shipping_mehod['html_image'] = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
					$shipping_methods['russianpost2'.$txt]['quote'][$key]['html_image'] = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
					
				}
				
				$shipping_mehod['dpd_title_short'] = $shipping_mehod['title_with_no_pvz'];
				
				if( !empty($shipping_mehod['is_show_image']) && 
						file_exists(DIR_IMAGE.$shipping_mehod['raw_image']) && 
						!strstr($shipping_mehod['image'], "no_image") 
					)
				{
					
					$html = $this->config_get('russianpost2_method_image_html'); 
					$image_url = $this->model_tool_image->resize( $shipping_mehod['raw_image'], $shipping_mehod['image_width'], $shipping_mehod['image_height'] );
					
					$html = str_replace("{title}", $shipping_mehod['dpd_title_short'], $html);
					$html = str_replace("{image_url}", $image_url, $html);
					$html = str_replace("{width}", $shipping_mehod['image_width'], $html);
					$html = str_replace("{height}", $shipping_mehod['image_height'], $html);
					
					$shipping_mehod['dpd_title_short'] = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
				}
				
				$shipping_methods['russianpost2'.$txt]['quote'][$key]['dpd_title_short'] = $shipping_mehod['dpd_title_short'];
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M6: ".$shipping_mehod['title']);
				
				if( empty( $shipping_mehod['service_key'] ) 
					|| 
					!$this->isOpsService( $shipping_mehod['service_key'] )
				)
				{
					if( $this->config_get('russianpost2_debug') )
						$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code."): no ops service END");
					
					$shipping_mehod['dpd_html'] = '';
					continue;
				}
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M7");
				
				
				$tag_type = ''; 
				
				$is_ops_tag = 0;
				
				foreach($ops_tags as $tag_key)
				{
					if(
						strstr(
							$shipping_mehod['title_with_no_pvz'], 
							'{'.$tag_key.'}'
						)
					)
						$is_ops_tag = 1;
				}
				
				if( !$is_ops_tag && empty($shipping_mehod['showmap']) )
				{					
					if( $this->config_get('russianpost2_debug') )
						$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") no showmap END");
					continue;
				}
				
				 
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M7.1");
				
				$listtype = $this->RP2->getPvzType($shipping_mehod, $shipping_mehod['service_key']);
				$pvz_list = $this->getPvzListByListtype($listtype); 
				
				if( !$pvz_list )
				{
					if( $this->config_get('russianpost2_debug') )
						$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") empty PVZ_LIST END");
					continue;
				}
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M8: ".$listtype);
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M9: ".$tag_type);
				
				$firstPvz = array();
				
				if( !empty( $this->rp_selected_pvz[ $listtype ] ) )
				{
					$firstPvz = $this->getCurrentOpsByCode(
						$this->rp_selected_pvz[ $listtype ], 
						$pvz_list
					);
				}
				elseif( !empty( $this->rp_selected_pvz) )
				{
					foreach($this->rp_selected_pvz as $lt=>$postcode)
					{
						if( $lt !== $listtype )
						{
							if( !empty($this->rp_selected_pvz[ $lt ]) && 
								$firstPvz = $this->getCurrentOpsByCode(
									$this->rp_selected_pvz[ $lt ], 
									$pvz_list
								)
							)
								break;
						}
					}
				} 
				
				if( empty( $firstPvz ) && !empty($pvz_list[0]) )
				{
					$firstPvz = $pvz_list[0];
				}
					 
				if( empty($firstPvz) )
				{
					if( $this->config_get('russianpost2_debug') )
						$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") empty firstPvz END");
					continue;
				}
				
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M10");
				
				
				//$shipping_mehod['dpd_title_short'] = strip_tags(html_entity_decode($shipping_mehod['dpd_title_short'], ENT_QUOTES, 'UTF-8')); 
				
				$firstOps_block = $this->formatData( 	
					'russianpost2_tag_ops_block', 
					array(
						'ops_address'  => $firstPvz['address'],
						'postcode'   => $firstPvz['postcode'],
						'ops_worktime' => $this->getWorkTime( $firstPvz['wtime'] )
					)
				);
				
				//$shipping_mehod['title'] .= " ".strip_tags(html_entity_decode($firstOps_block, ENT_QUOTES, 'UTF-8')); 
				
				$rp_html = '';
				
				foreach($pvz_list as $x=>$ops)
				{ 
					$pvz_list[$x]['title_with_no_pvz'] = $shipping_mehod['title_with_no_pvz'];
					$pvz_list[$x]['listtype'] = $listtype;
					//$pvz_list[$x]['wtime'] = $this->getWorkTime( $ops['wtime'] );
					
					$stop = 0;
					
					$ar = explode(",", $ops['address']);
					unset($ar[0]);
					$ops['address'] = implode(",", $ar); 
								
					$ops_block = $this->formatData( 	
						'russianpost2_tag_ops_block', 
						array(
							'ops_address'  => $ops['address'],
							'postcode'   => $ops['postcode'],
							'ops_worktime' => $this->getWorkTime( $ops['wtime'] )
						)
					);
					$pvz_list[$x]['title'] = $shipping_mehod['title_with_no_pvz'].' '.$ops_block;
					
					$pvz_list[$x]['cost'] = $shipping_mehod['cost'];
					$pvz_list[$x]['cost_text'] = strip_tags($shipping_mehod['text']);
							
					if( !empty($shipping_mehod['description']) )
					{
						$pvz_list[$x]['description_with_no_pvz'] = $shipping_mehod['description_with_no_pvz'];
						$pvz_list[$x]['description_with_no_pvz'] = $shipping_mehod['description'].' '.$ops_block;
						
						$shipping_mehod['description'] = str_replace(
							$ops_block, 
							"",
							$shipping_mehod['description']
						); 
							
						$pvz_list[$x]['description'] = str_replace(
							"{ops_block}", 
							$ops_block, 
							$shipping_mehod['description_with_no_pvz']
						); 
					}
				}
					
						
				$rp_html = $this->getOpsHTML(
					$firstPvz,
					$pvz_list, 
					'russianpost2'.$txt.'_'.$key,
					$this->getParentServiceKey($shipping_mehod['service_key']),
					$listtype
					, $shipping_mehod
				);
					
				$rp_html = str_replace("{weight_gramm}", 
										$shipping_mehod['russianpost2_weight_gramm'], 
										$rp_html); 
							
				$rp_html = str_replace("{input_id}", 
										$shipping_mehod['code'], 
										$rp_html); 		
										
			
				
				//if( $this->config_get('russianpost2_debug') )
				//	$this->log->write( "PR2-DEBUG: setRpHTMLToQuote(".$code.") M11: ".$rp_html);
				
				$rp_html .= $this->getJsAndCssLinks( 
						$shipping_mehod['service_key'],
						$shipping_mehod
				);
				
				
				$item_keys = array('title', 'description');
				
				foreach($item_keys as $item_key)
				{
					$shipping_mehod[$item_key] = str_replace(
						"{ops_block}", 
						"",
						$shipping_mehod[$item_key]
					); 
					
					$shipping_mehod[$item_key] = str_replace(
						"{pvz_block}", 
						"",
						$shipping_mehod[$item_key]
					); 
					
					$shipping_mehod[$item_key] = str_replace(
						"{listtype}", 
						$listtype,
						$shipping_mehod[$item_key]
					);
				}	
				
				
				if( $this->config_get('russianpost2_map_show') == 'description' )
				{ 
					//if( $this->config_get('russianpost2_debug') )
					//	$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M12(".$code."): ".$rp_html);
					
					$shipping_mehod['description'] = str_replace("{input_id}", 
										$shipping_mehod['code'], 
										$shipping_mehod['description_with_no_pvz']);
					
					$shipping_mehod['description'] .= $this->getJsAndCssLinks( 
						$shipping_mehod['service_key'], 						
						$shipping_mehod
					);
					
					$shipping_mehod['description'] .= '<div >'. $rp_html."</div>"; 
					$shipping_mehod['dpd_html'] = ' ';
				}
				else
				{
					//if( $this->config_get('russianpost2_debug') )
					//	$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M13(".$code."): ".$rp_html);
					
					$shipping_mehod['dpd_html'] =  '<div >'. $rp_html."</div>";  
					$shipping_mehod['description'] = '';
				}
				 
				$shipping_methods['russianpost2'.$txt]['quote'][$key] = $shipping_mehod;
				 
				if( $this->config_get('russianpost2_debug') )
					$this->log->write( "PR2-DEBUG: setRpHTMLToQuote M14(".$code.") row END");
			}
		}
		
		if( $this->config_get('russianpost2_debug') )
			$this->log->write( "PR2-DEBUG: setRpHTMLToQuote SUCCESS END");
		 
		return $shipping_methods;
	}
	
	public function setRpPostcodeFromCheckout($module, $post_data)
	{
		if( $module == 'simple' )
		{
			if( !empty($post_data['shipping_address']['postcode']) &&
				isset($this->session->data['simple']['shipping_address']['postcode']) &&
				$post_data['shipping_address']['postcode'] != $this->session->data['simple']['shipping_address']['postcode']
				&&
				!empty($this->session->data['shipping_methods']['russianpost2']['quote'])
			)
			{
				$this->setRpPostcode($post_data['shipping_address']['postcode']);
			}
		}
		
	}	
	
	public function setRpPostcode($postcode)
	{
		if( empty($this->session->data['shipping_methods']['russianpost2']['quote']) )
			return;
		
		if( !isset($this->session->data['rp_selected_pvz']) )
			$this->session->data['rp_selected_pvz'] = array();
		
		$listtypes = array();
		
		foreach($this->session->data['shipping_methods']['russianpost2']['quote'] as $quote)
		{
			if( empty($quote['pvztype']) )
				continue; 
			
			if( strstr($quote['pvztype'], 'NOOPS_ONLY' ) )
				continue; 
			
			$listtypes[] = $quote['pvztype'];
			
			setcookie('rp_selected_pvz___'.$quote['pvztype'], $postcode, time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);   
			
			$this->session->data['rp_selected_pvz'][$quote['pvztype']] = $postcode;
		}
		
		return array_unique($listtypes);
	}
	
	private function setRpOpsFromSession()
	{
		if( !empty( $this->session->data['rp_selected_pvz'] ) )
		{
			$this->rp_selected_pvz = $this->session->data['rp_selected_pvz'];
		}
		
		foreach($this->request->cookie as $key=>$val)
		{
			if( strstr($key, 'rp_selected_pvz___') )
			{
				$ar = explode('___', $key);
				$this->rp_selected_pvz[$ar[1]] = $val;
			}
		}
	}
	
	public function checkIsCompulsoryPvz($rp_delivery_point_index)
	{ 
		$sql = "SELECT * FROM `" . DB_PREFIX . "russianpost2_indexes` 
				WHERE postcode = '".$this->db->escape($rp_delivery_point_index)."'
				 AND ( (card_payment = 1 OR cash_payment = 1) OR ( 
					type_post_office = 'GOPS' OR type_post_office = 'SOPS' OR type_post_office = 'PPS' OR type_post_office = ''
				) )
				";
		
		return $this->db_query($sql)->row;
	} 
	 
	
	public function getWorkTime($work_time)
	{ 
		if( !$work_time )
			return;
		
		if( !strstr($work_time, "|") )
		{  
			return $this->formatData(
				'russianpost2_ops_worktime_block',
				array(
					'lines' => $work_time
				)
			);
		}
			
		$ar = explode("|", $work_time);
		
		if( !$ar )
			return;
		
		if( !is_array($ar) )
		{ 
			return $this->formatData(
				'russianpost2_ops_worktime_block',
				array(
					'lines' => $work_time
				)
			);
		}
		
		$intervals = array();
		foreach($ar as $value)
		{
			//$value = str_replace("открыто: ", "", $value);
			
		
			if( !strstr($value, ", ") )
				continue;
			
			$wtime = '';
			$dtime = '';
			$ar2 = explode(", ", $value);
			
			$day = $ar2[0];
			unset($ar2[0]);	
			
			
			if( trim($ar2[1]) == 'выходной' )
			{
				$dtime = 'выходной';
				$wtime = 'выходной';
			}
			else
			{	
				$ar3 = array();
				preg_match("/(\d+)\:(\d+)\s\-\s(\d+)\:(\d+)/", $ar2[1], $ar3);
			
				if( !isset($ar3[1]) || !isset($ar3[2]) || !isset($ar3[3]) || !isset($ar3[4]) )
					continue;
			
				$wtime = $ar3[1].':'.$ar3[2].' - '.$ar3[3].':'.$ar3[4];
				 
				if( !empty($ar2[2]) && !strstr($ar2[2], 'null') )
				{
					$ar3 = array();
					preg_match("/(\d+)\:(\d+)\s\-\s(\d+)\:(\d+)/", $ar2[2], $ar3);
					
					if( !empty($ar3[1]) && !empty($ar3[3]) )
						$dtime = $ar3[1].' - '.$ar3[3];
				}
			}
			
			
			if( empty( $intervals[$wtime.'-'.$dtime] ) )
			{
				$intervals[$wtime.'-'.$dtime] = array(
					'wtime' => $wtime, 
					'dtime' => $dtime, 
					'days' => array($day) 
				);
			}
			else 
			{
				$days = $intervals[$wtime.'-'.$dtime]['days'];
				$days[] = $day;
				$intervals[$wtime.'-'.$dtime] = array('wtime' => $wtime, 'dtime' => $dtime, 'days' => $days );
			} 
		}
		
		$lines = ''; 
		 
		
		foreach($intervals as $inter)
		{
			$line = '';
			if($inter['wtime'] == 'выходной')
				$line = $this->formatData('russianpost2_pvz_worktime_weekendline', array());
			elseif( !empty($inter['dtime']) )
				$line = $this->formatData('russianpost2_pvz_worktime_workline_withdinner', array());
			else
				$line = $this->formatData('russianpost2_pvz_worktime_workline_nodinner', array());
			
			$line = str_replace("{days}", implode(", ", $inter['days']), $line);
			
			if( $inter['wtime'] != 'выходной')
			{
				$ar = explode(" - ", $inter['wtime']);
				
				$line = str_replace("{start}", $ar[0], $line);
				$line = str_replace("{end}", $ar[1], $line);
				
				if( !empty($inter['dtime']) )
				{
					$ar2 = explode(" - ", $inter['dtime']);
					$line = str_replace("{dstart}", $ar2[0], $line);
					$line = str_replace("{dend}", $ar2[1], $line);
				}
			}
			
			$lines .= $line." "; 
		}
		
		$lines = trim($lines);   
		
		return $this->formatData(
			'russianpost2_ops_worktime_block',
			array(
				'lines' => $lines
			)
		);
	} 
	
	public function getPvzByCode($postcode)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "russianpost2_indexes` 
				WHERE  postcode = '".$this->db->escape($postcode)."'"; 
		return $this->db_query($sql)->row;
	}
	
	public function getCurrentPvzByCode($code, $pvz_list, $is_no_take_first = 0)
	{
		foreach($pvz_list as $pvz)
		{
			if( $pvz['delivery_point_index'] == $code )
			{
				return $pvz;
			}
		}
		
		if( $is_no_take_first )
			return false;
		else
			return isset( $pvz_list[0] ) ? $pvz_list[0] : '';
	}
	
	private function getPvzList($region_id, $city, $is_payment = 0, $type = '')
	{ 
		$this->initClass(); 
		return $this->RP2->getPvzList($region_id, $city, $is_payment, $type);
	}
	
	private function getParentServiceKey($service_key)
	{
		if( $service_key == 'free' || preg_match("/^[\d]+$/", $service_key) )
		{
			return $service_key;
		} 
		
		$service_key = str_replace('_avia', '', $service_key);  
		$service_key = str_replace('_insured', '', $service_key);  
		$service_key = str_replace('_registered', '', $service_key);  
		
		return $service_key;
	}
	
	
	private function getOpsHTML($current_ops, $ops_list, $key, $service_key, $listtype, $shipping_method)  
	{
		$title = '';
		$current = '';
		$html = '';
		
		if( count($ops_list) > 1 )
		{
			$html .= '<div id="rp-'.$key.'">';
			
			$tmp = html_entity_decode(
				$this->formatData( 'russianpost2_ops_selectblock', array("type"=>"ops") )
			);
			
			$tmp = str_replace(
				"{select_id}", 
				$key,
				$tmp
			);
			
			$is_map_widget = $this->RP2->getMapwidgetCodeId($service_key , $shipping_method, '', $this->ORDER['to']['region_id'] );
				
			
			$options_str = '';
			$i = 0;
			foreach($ops_list as $i=>$ops)
			{ 
				if( !$is_map_widget && $ops['lat'] == -1 )
					continue;
				
			
				$ar = explode(",", $ops['address']);
				unset($ar[0]); 
				$ops['short_address'] = implode(",", $ar);
				
				$ops['work_time'] = $this->getWorkTime( $ops['wtime'] ); 
			
				$option_text = $this->formatData(
					'russianpost2_ops_selecttitle',
					array( 
						'address' => $ops['short_address'],
						'postcode' => $ops['postcode']
					)
				);
				
				$i++;
				$is_selected = 0;
				if(  !empty($current_ops['postcode']) && $ops['postcode'] == $current_ops['postcode'] ) 
				{
					$current = $ops;
					$is_selected = 1;
				}
				
				$dat = '{input_id}|'.$key.'|'.
				$ops['postcode'].'|'.
				$ops['cost'].'|'.
				$ops['work_time'].'|'.
				$ops['title'].'|'.
				$ops['short_address'].'||'.
				//'https://maps.yandex.ru/?z=17&text='.urlencode($ops['address']).'|'.
				$ops['cost_text'].'|'.
				$ops['lat'].'|'.
				$ops['lon'].'||'.$service_key.'||'.
				$ops['city'].'|'.
				$listtype;
			
				 
				$dat = str_replace("'", "\'", $dat);
				
				$options_str .= "<option value='". $ops['postcode']."' 
				data-dat='".$dat.
				"'";
				
				if( $is_selected )
					$options_str .= ' selected ';
			
				$options_str .= '>'. $option_text .'</option>';
			}
			
			$tmp = str_replace( "{options}",  $options_str, $tmp );
			if( $mapcode = $this->RP2->getMapwidgetCodeId($service_key , $shipping_method, '', $this->ORDER['to']['region_id'] ) )
			{ 
				$ops_list[0]['cost_text'] = strip_tags($ops_list[0]['cost_text']); 
				
				$region = $this->RP2->getRegionById( $ops_list[0]['region_id'] );
				
				$widget_region2 = isset($region['widget_region2']) ? $region['widget_region2'] : '';
				
				$ops_list[0]['title_with_no_pvz'] = str_replace('"', "\'", $ops_list[0]['title_with_no_pvz']);
				
				$tmp = str_replace( 
					"{selectlink}",  
					'javascript: showRpMapWidget(\''.$mapcode.'\', \'{input_id}\', \''.$key.'\', \''.$current_ops['city'].'\', \'ops\', \''.$ops_list[0]['title_with_no_pvz'].'\', \''.$ops_list[0]['cost'].'\', \''.$ops_list[0]['cost_text'].'\', \'{weight_gramm}\', \''.$current_ops['postcode'].'\', \''.$widget_region2.'\' )',  
					$tmp
				);
			}
			else
			{ 
				$tmp = str_replace( 
					"{selectlink}",  
					'javascript: showRpMap(\'{input_id}\', \''.$key.'\', \''.$ops_list[0]['city'].'\', \'ops\')', 
					$tmp
				);
			}
				 
			if( $this->config_get('config_theme') == 'theme_lightshop' )
				$tmp .= '<script>initCustomSelect($("#'.$key .'"));</script>';
			
			$html .= $tmp; 
		}
		else
		{
			$html .= "<div>"; 
		}
		 
		if( !$current )
		{
			$current = isset( $ops_list[0] ) ? $ops_list[0] : '';
		}
		
		if( $current )
		{ 
			$maplink = '';
			$maplink_block = '';
			
			if( count($ops_list) == 1 )
				$maplink = ''; //'https://maps.yandex.ru/?z=17&text='.urlencode($current['address']);
			
			$current['wtime'] = $this->getWorkTime( $current['wtime'] );
			
			$russianpost2_tag_srok_block = $this->config_get('russianpost2_tag_srok_block');
		
			$html .= html_entity_decode($this->formatData(
				'russianpost2_ops_descblock',
				array(
					"postcode" => '<span id="rp-ops-postcode{input_id}">'.$current['postcode'].'</span>',
					"address" => '<span id="rp-ops-address{input_id}">'.$current['address'].'</span>',
					"worktime_block" => '<span id="rp-ops-work_time{input_id}">'.$current['wtime'].'</span>',
					"maplink" => $maplink,
					"srok_block" => $shipping_method['srok'] ? str_replace("{srok}", $shipping_method['srok'], $russianpost2_tag_srok_block[ $this->config_get('config_language_id') ]) : ""
				)
			));
			
			
			
			if( count($ops_list) == 1 )
			{
				$html = str_replace($maplink.'"', $maplink.'" target=_blank', $html);
			}
			
		}
		
		$html .= '</div>';
		
		return $html;
	} 
	
	private function getCurrentOpsByCode($code, $ops_list)
	{
		foreach($ops_list as $ops)
		{
			if( $ops['postcode'] == $code )
			{
				return $ops;
			}
		}
		
		return isset( $ops_list[0] ) ? $ops_list[0] : '';
	}
	
	
	private function isOpsService($service_key)
	{
		if(strstr($service_key, "foreign"))
			return false;
		else
			return true;
		if( strstr($service_key, 'parcel_online') 
			||
			strstr($service_key, 'courier_online') 
			||
			strstr($service_key, 'ems_optimal') 
		)
			return true;
		else
			return false;
	} 
	 
	private function getJsAndCssLinks( 
		$service_key = '',
		$shipping_method = array()
	) 
	{
		$html = '';
		$type = 'pvz';
		
		$show_allways = 0; 
		if( ( $this->config->get('simple_status') || isset($this->session->data['simple']) ) && $this->config->get('simple_settings') )
		{
			$simple_settings = json_decode($this->config->get('simple_settings'), 1);  
			
			if( !empty($simple_settings['checkout'][0]['shipping']['displayDescriptionOnlyForSelected']) && $this->config_get('russianpost2_map_show') == 'description' )
			{
				$show_allways = 1;
			}
		}
		  
		if( $mapcode = $this->RP2->getMapwidgetCodeId($service_key, $shipping_method, '', $this->ORDER['to']['region_id']) )
		{ 
			if( !$this->is_widget_js_allready_added || $show_allways )
			{
				$html = '<script type="text/javascript" src="/catalog/view/javascript/russianpost2-widget.js?12345"></script>';
				$html .= '<script type="text/javascript" src="https://widget.pochta.ru/map/widget/widget.js"></script>';
				$html .= '<link href="catalog/view/theme/default/stylesheet/russianpost2.css" rel="stylesheet">';
				$this->is_widget_js_allready_added = 1;
			}
		}
		else
		{ 
			if( !$this->is_module_js_allready_added || $show_allways )
			{
				$html = '<script type="text/javascript" src="/catalog/view/javascript/russianpost2.js?12345"></script>';
				$html .= '<link href="catalog/view/theme/default/stylesheet/russianpost2.css" rel="stylesheet">';
				$this->is_module_js_allready_added = 1;
			}
				
			if( (!$this->is_yandexjs_allready_added || $show_allways ) && !$this->config_get('russianpost2_hide_map_js'))  
			{
				$html .= '<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
				$this->is_yandexjs_allready_added = 1;
			}
		}
		 
		$html .= '<script>';
		$html .= ' $(document).delegate(\'input[name="shipping_address[postcode]"]\', \'change\', function() { ';
		
		$html .= ' changeRPPostcode( $(this).val() ); ';
		
		$html .= ' });</script>'; 
		
		if( $this->config_get('russianpost2_pvz_address_set') )
		{
			$html .= '<script>';
			$html .= ' $(document).delegate(\'input[name="shipping_method"]\', \'click\', function() { ';
			
			//$html .= ' var rpServiceCode = $(this).val(); ';
			//$html .= ' rpServiceCode = rpServiceCode.replace("russianpost2.", ""); '; 
			//$html .= ' rpServiceCode = rpServiceCode.replace("_'.$type.'", ""); ';
			//$html .= ' setRPPVZFromSelect( "#russianpost2_pvz_sel"+rpServiceCode+"_pvz", 0, "'.$type.'" ); ';
			
			$html .= ' if( !$(this).val().match(/^russianpost2/) ) clearAddressIfNoRp($(this).val()); ';
			$html .= ' else setRPPVZFromSelect( $("#"+$(this).val().replace(".", "_") ), 0, "'.$type.'" ); ';
			$html .= ' });</script>'; 
		}
		
		
		return $html;
	}
	
	
	/*
	 * Возвращает посткалк-коды всех подключенных тарифов
	 */
	public function getPostcalcTariffKeys()
	{
		$result = array();
		
		$russianpost2_methods = $this->config_get('russianpost2_methods');
		$russianpost2_services2api_list = $this->config_get('russianpost2_services2api_list');
		
		foreach($russianpost2_methods as $method)
		{
			foreach($method['submethods'] as $submethod)
			{
				foreach($submethod['services'] as $service)
				{
					$service_key = $service['service'];
					
					if( !empty( $this->SERVICES[ $service_key ]['postcalc_tariff_key'] ) )
					{
						if( !empty($russianpost2_services2api_list[$service_key]['source']) &&
							$russianpost2_services2api_list[$service_key]['source'] == 'postcalc' )
						{
							$result[] = $this->SERVICES[ $service_key ]['postcalc_tariff_key'];
						}
					}
				}
			}
		}
		
		return array_flip( array_flip( $result ) );
	}
	
	public function getCurl($url, $method='GET', $destination='', $request_headers='')
	{
		
		$api_key = $this->getApiKeyByUrl($url);
		
		if( !empty( $this->stop_curl[ $api_key ] ) )
		{
			$this->addError('getCurl: '.$url.' stopped', 0);
			return 'curl_error';
		} 
		
		if( $response = $this->getCacheData($api_key, $url, $destination) )
		{
			$this->addError('getCurl: '.$url.' --- data from cache');
			return $response;
		}
		else
		{
			$this->addError('getCurl: '.$url.' --- data from request');
		}
		
		$timeout = 1;
		if( (int)$this->config_get('russianpost2_'.$api_key.'_curl_lifetime') > 0 )
			$timeout = (int)$this->config_get('russianpost2_'.$api_key.'_curl_lifetime');
		
		$c = curl_init( $url  );
			
		if( $method == 'POST' )                                       
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "POST");     
		
		if( $destination )                              
		curl_setopt($c, CURLOPT_POSTFIELDS, $destination );    
		
		if( $request_headers )                              
		curl_setopt($c, CURLOPT_HTTPHEADER, $request_headers);   
		
		if( strstr($url, 'https://') )
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
			
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $timeout); 
		curl_setopt($c, CURLOPT_TIMEOUT, $timeout); //timeout in seconds
		$res = curl_exec($c);
		
		$inf = curl_getinfo($c);
		
		if( !$res )
		{
			$res = 'curl_error';
			$this->stop_curl[ $api_key ] = 1;  
			$this->addError('getCurl: empty answer', 0);
		}
			
		if( isset($inf['total_time']) )
			$this->addError('getCurl: TIME: '.$inf['total_time'], 0);
		else
			$this->addError('getCurl: no info', 0);
			
		curl_close($c);
		
		$this->saveCacheData($api_key, $url, $destination, $res);
		
		return $res;
	}
	
	private function getTariffData($service_key, 
		$weight_gramm, 
		$length_cm, 
		$width_cm, 
		$height_cm,  
		$total_without_shipping_rub, 
		$from, 
		$to, 
		$dop_cost_rub,
		$pack_key
		, $pvz_postcode
	)
	{
		$this->tariff_data = $this->requestTariffData(
											 $service_key,
											 $weight_gramm, 
											 $length_cm, 
											 $width_cm, 
											 $height_cm, 
											 $total_without_shipping_rub, 
											 $from, 
											 $to,
											 $dop_cost_rub,
											 $pack_key
											, $pvz_postcode
									);
		if( $this->tariff_data == 'curl_error' )
		{
			$this->tariff_data = '';
			return 'curl_error';
		}
		
		if( !$this->tariff_data )
			return false;
		
		$result = $this->getServiceDataFromTariffData($service_key, $this->tariff_data);
		
		$min_srok = false;
		$max_srok = false;
		if($result['srok'])
		{
			list( $min_srok, $max_srok ) = $this->explodeSrok( $result['srok'] );
		}
		
		return array(
					"cost" => $result['cost'],
					"is_pack_off" => isset( $result['is_pack_off'] ) ? $result['is_pack_off'] : 0,
					"min_srok" => $min_srok,
					"max_srok" => $max_srok
		);
	}
	
	private function isCommissionTagInTitle($text)
	{
		if( is_array($text) )
		{
			$text = $text[ $this->config_get('config_language_id') ];
		}
		
		if( strstr($text, "commission") )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getCodCost($total_without_shipping_rub, $shipping_cost_rub, $from_postcode,
	$service_key = '')
	{ 
		$pref = '';
		if( strstr($service_key, 'ems') 
			&&
			$this->config_get('russianpost2_cod_tariftype_ems_percent')
		)
		{
			$pref = 'ems_';
		}
		
		$total_rub = $this->getInsuranceCostRUB(  $total_without_shipping_rub, $shipping_cost_rub );
						
		if( $this->config_get('russianpost2_cod_tariftype') == 'set' 
			&&
			$this->config_get('russianpost2_cod_tariftype_'.$pref.'percent')
		)
		{
			$cod_cost = $total_rub * (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'percent') / 100;
							
			if( $this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue') 
				&&
				$cod_cost < (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue')
			)
			{
				$cod_cost = (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue');
			}
		}
		else
		{
			$cod_cost = $this->getTariffCodPrice($total_rub, $from_postcode);
		}
		
		return $cod_cost;
	}
	
	public function getTariffCodPrice($total_rub, $from_postcode, $service_key = '')
	{
		$pref = '';
		if( strstr($service_key, 'ems') 
			&&
			$this->config_get('russianpost2_cod_tariftype_ems_percent')
		)
		{
			$pref = 'ems_';
		}
		
		if( $this->config_get('russianpost2_cod_tariftype') == 'set' &&
			$this->config_get('russianpost2_cod_tariftype_'.$pref.'percent')
		)
		{
			$cod_cost = $total_rub * (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'percent') / 100;
							
			if( $this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue') 
				&&
				$cod_cost < (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue')
			)
			{
				$cod_cost = (float)$this->config_get('russianpost2_cod_tariftype_'.$pref.'minvalue');
			}
			
			return $cod_cost;
		}
		
		
		$total_rub *= 100;
		$total_rub = round($total_rub );
		
		$url = "https://tariff.pochta.ru/tariff/v1/calculate?json&object=1000&";
		$url .= "from=".$from_postcode."&sum=".$total_rub;
		
		$json = $this->getCurl($url);
		
		if( $json && $json!='curl_error' )
		{
			$response = json_decode($json, 1);
			
			if( !empty($response['paynds']) )
			{
				return (float)$response['paynds'] / 100;
			}
		}
	}
	
	private function minusInsurance($tariff_data)
	{
		$ins_price = 0;
		foreach( $tariff_data['tariff'] as $row )
		{
			if( strstr($row['name'], 'Плата за объявленную цен') )
			{
				$ins_price = $row['cover']['valnds'];
			}
		}
		
		
		$total_shipping = ((float)$tariff_data['paynds'] - (float)$ins_price) / 100;
		
		return $this->minusNds( $total_shipping );
	}
	
	private function plusTotalInsurance($tariff_data, $total_without_shipping_rub )
	{	
		$ins_price = 0;
		$percent = 0;
		
		if( is_array($tariff_data['tariff']) )
		{
			foreach( $tariff_data['tariff'] as $row )
			{
				if( strstr($row['name'], 'Плата за объявленную цен') )
				{
					$percent = (float)$row['cover']['valnds'] * 100 / (float)$tariff_data['sumoc'];
					$ins_price = (float)$row['cover']['valnds'];
				}
			}
		}
		
		$total_shipping = ((float)$tariff_data['paynds'] - (float)$ins_price) / 100;
		
		$total_value = $total_without_shipping_rub;
		
		
		if( $this->config_get('russianpost2_insurance_base') == 'total' )
		{
			$total_value += (float)$total_shipping;
		}
		
		$result = (float)$total_value * (float)$percent / 100; 
		
		return $this->minusNds( $result ); 
	}
	
	private function getServiceDataFromTariffData($service_key, $tariff_data )
	{
		if( empty($tariff_data['paynds']) )
			return array(
				"cost" => 0,
				"srok" => 0,
			);
			
		$cost = 0; 
		
		if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) 
			|| !$this->config_get('russianpost2_is_nds')
		)
		{		
			$cost = $this->minusNds( $tariff_data['paynds'] ) / 100;
			$this->addError('getServiceDataFromTariffData: '.($tariff_data['paynds']/100).' minusNds = '.$cost, 0);
		}
		else	
		{
			$cost = $tariff_data['paynds'] / 100;
		}
		
		$srok = false;
		
		if( !empty($tariff_data['delivery']) 
			&&
			(
				!empty($tariff_data['delivery']['max']) 
				||
				!empty($tariff_data['delivery']['min']) 
			)
		)
		{
			if( 
				!empty($tariff_data['delivery']['max']) && 
				!empty($tariff_data['delivery']['min'])  
			)
				$srok = $tariff_data['delivery']['min'].'-'.$tariff_data['delivery']['max'];
			elseif( !empty($tariff_data['delivery']['max']) )
				$srok = $tariff_data['delivery']['max'];
			elseif( !empty($tariff_data['delivery']['min']) )
				$srok = $tariff_data['delivery']['min'];
		}
		
		
		return array(
			"cost" => $cost, //$data['Доставка'],
			"srok" => $srok,
			"is_pack_off" => isset( $tariff_data['is_pack_off'] ) ? $tariff_data['is_pack_off'] : 0
			
		);
	}
	
	/*
	{"version": "1.8.11.233", 
			"id": 27030, 
			"name": "Посылка стандарт", 
			"typ": 27, 
			"cat": 3, 
			"dir": 0, 
			"from": 660017, 
			"to": 620146, 
			"weight": 432, 
			"pack": 10, 
			"date": 20171204, 
			"postoffice": [
			{"index": 660017, "region": 1004, "place": 1000000029014, "
			parent": 660999, "aviaport": ["Красноярск"], "aviazone": 49, 
			"cregion": 1},
			{"index": 620146, "region": 1065, "place": 1000000134499, 
			"parent": 620999, "aviaport": ["Екатеринбург"], 
			"aviazone": 43, "cregion": 1}], 
			"typcatname": "Посылка стандарт", 
			"trans": 5, 
			"transid": 4, 
			"transname": "Ускоренно", 
			"tariff": [{
				"id":"606/606xb2", 
				"name":"Плата за доставку посылки стандарт", 
				"from":"КРАСНОЯРСК 17", 
				"fromi":660017, 
				"to":"ЕКАТЕРИНБУРГ 146", 
				"toi":620146, 
				"ground": {"val":21186, "valnds":25000}}
			], 
			"ground": {"val":21186, "valnds":25000}, 
			"pay": 21186, 
			"paynds": 25000, 
			"date-first": 20160101
			}
	*/
	private function setTariffObject($service_key, $PARAMS)
	{
		$tarif_key = '';
		$params = '';
		
		if( strstr($this->SERVICES[ $service_key ]['tariff_key'], "|") )
		{
			list($tarif_key, $params) = explode("|", $this->SERVICES[ $service_key ]['tariff_key']);
			
			$ar = explode("=", $params);
			$PARAMS[ $ar[0] ] = $ar[1];
		}
		else
		{
			$tarif_key = $this->SERVICES[ $service_key ]['tariff_key'];
		}
		
		$PARAMS['object'] = $tarif_key;
		return $PARAMS;
	}	
	
	
	private function requestTariffData( $service_key, $weight_gramm, $length_cm, $width_cm, 
	$height_cm, $total_without_shipping_rub, $from, $to, $dop_cost_rub, $pack_key
		, $pvz_postcode='' )
	{ 
		
		$PARAMS = array(
			"json" => '', 
			"errorcode" => 1,
			#"object" => '47030', // ???
			"closed" => 0,
			"from" => $from['postcode'],
			//"to" => $to['postcode'],
			//"country" => '',
			"weight" => ceil($weight_gramm),
			"size" => ceil($length_cm).'x'.ceil($width_cm).'x'.ceil($height_cm),
			#"pack" => '10',
			#"isavia" => 0,
			"date" => date("Ymd"),
			"delivery" => 1
		);
		
		$delivery_url = '/delivery';
		if( strstr($service_key, "business_courier") || strstr($service_key, "courier_online") || strstr($service_key, "foreign") )
		{
			$delivery_url = "";
		}
		
		if( $to['iso_code_2'] == 'RU' )
		{
			$PARAMS['to'] = $to['postcode'];
		}
		else
		{
			$PARAMS['country'] = $to['tariff_country_id']; 
		}
		
		if( $PARAMS['weight'] < 100 && strstr($service_key, "printed") )
		{
			$PARAMS['weight'] = 100;
		}
		
		if( strstr($service_key, "ecom_marketplace") )
		{
			if( strstr($service_key, "ecom_marketplace_express") )
				$PARAMS['transtype'] = 4;
			else
				$PARAMS['transtype'] = 1;
		}
		
		
		$PARAMS = $this->setTariffObject($service_key, $PARAMS);
		
		if( $total_without_shipping_rub == -1 )
			$total_without_shipping_rub = 1;
		
		$is_need_ins = 0;
		
		if( strstr($service_key, "_insured") )
		{
			if(
				$total_without_shipping_rub == 1  
				||
				(
					$total_without_shipping_rub <= (int)$this->SERVICES[ $service_key ]['limitcost'] &&
					$this->config_get('russianpost2_insurance_base') != 'total'
				)
			)
			{
				$PARAMS["sumoc"] = round($total_without_shipping_rub * 100);

				if( $this->config_get('russianpost2_is_no_insurance_limit') == 1 &&
					$PARAMS["sumoc"] > (int)$this->SERVICES[ $service_key ]['limitcost'] * 100 )
				{ 
					$PARAMS["sumoc"] = (int)$this->SERVICES[ $service_key ]['limitcost'] * 100;
				}
			}
			else
			{
				$is_need_ins = 1;
				$PARAMS["sumoc"] = 100;
			}
		} 
		elseif( $this->isPvzService($service_key)  )
		{
			if( !strstr($service_key, "insured") )
				$PARAMS["sumoc"] = 100; 
			else
				$PARAMS["sumoc"] = round($total_without_shipping_rub * 100); 
		}
		
		// ---------
		
		if( preg_match("/^[\d]+$/", $pack_key) )
		{
			$pack_key = '';
		}
		
		if( !empty( $this->SERVICES[ $service_key ]['is_pack_required'] ) )   
		{
			$pack_key = $this->getCurrentPackKey(
				explode("|", $this->SERVICES[ $service_key ]['available_packs'])
			);
		}
		
		if( $pack_key )
		{
			$PARAMS['pack'] = $this->PACKS[ preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key ]['tariff_pack_id'];
		}
		
		// ---------
		
		$servs = array();
		
		if( !empty($this->SERVICES[ $service_key ]['options']) )
		{
			foreach( $this->SERVICES[ $service_key ]['options'] as $key=>$option )
			{
				if( 
					( $service_key == 'ems_optimal' || $service_key == 'ems_optimal_insured' )
					&&
					$key == 'is_courier'
				)
					continue;
					
				if( !empty($option['status']) )
				{
					if( empty( $option['available_tariff_key'] )
						||
						strstr("|".$option['available_tariff_key']."|", "|".$PARAMS['object']."|" )
					)
					{
						if( preg_match("/^[\d]+$/", trim($option['tariff_service_id'])) )
						{
							$servs[] = $option['tariff_service_id'];
						}
						elseif( $option['tariff_service_id'] )
						{
							$ar = explode("=", $option['tariff_service_id']);
							$PARAMS[ $ar[0] ] = $option['status'];
						}
					}
				}
			}
		}	
		
		
		if( 
			( 
				strstr($service_key, 'parcel_10') || 
				strstr($service_key, 'parcel_20') || 
				strstr($service_key, 'parcel_50') 
			)
			&&
			(
				(float)$length_cm + (float)$width_cm + (float)$height_cm > 120
				|| 
				$this->combinateLAFF(
						array(
							"length" => 60,
							"width" => 60,
							"height" => 60
						), 
						$this->PRODUCT_BOXES,
						(40 * 40 * 40)
				) != 1 
			)
		)
		{  
			$servs[] = 12;
		}
		
		if( !empty($this->ORDER['is_caution']) )
		{
			$servs[] = 4;
		}
		
		if( $this->config->get('russianpost2_clienttype') == 'corporate' )
		{
			$servs[] = 28;
		}
		elseif( $this->config->get('russianpost2_clienttype') == 'common' )
		{
			if (($key = array_search(28, $servs)) !== false) {
				unset($servs[$key]);
			}
		}
		
		
		if( $servs )
		{
			$PARAMS[ 'service' ] = implode(",", $servs);
		}
		
		if( $dogovor = $this->getDogovor() )
		{
			$PARAMS[ 'dogovor' ] = $dogovor;
		}
		
		
		$base_url = 'https://tariff.pochta.ru/v2/calculate/tariff'.$delivery_url.'?'; 
		$json = '';
		
		if( $to['iso_code_2'] == 'RU' )
		{
			
			$postcodes = array();
			
			if( !empty( $pvz_postcode ) )
				$postcodes[] = $pvz_postcode;
			
			if( !empty($to['user_postcode']) )
				$postcodes[] = $to['user_postcode'];
				
			if( 
				$this->config_get('russianpost2_ifnopostcode') == 'off' || 
				(
					!$this->config_get('russianpost2_ifnouserpostcode') &&
					(
						strstr($service_key, 'ems_optimal') ||  
						strstr($service_key, 'courier_online') 
					)
				)
			)
			{
				//none
			}
			else
			{
				if( !empty($to['city_postcode']) )
				{
					$postcodes[] = $to['city_postcode'];
				}
					
				if( !empty($to['region_postcode']) )
				{
					$postcodes[] = $to['region_postcode'];
				}
			}
			 
			
			$postcodes = array_flip( array_flip( $postcodes ) );
			foreach($postcodes as $postcode)
			{
				if( !empty($postcode) )
				{
					$PARAMS['to'] = $postcode;
					$PARAMS['from'] = $this->getServicePostcode($service_key, $from['postcode'], $postcode);
					
					if( strstr($service_key, "parcel_online") )
					{
						if( preg_match("/^9/", $postcode) )
						{
							if( strstr($service_key, "insured") )
							{
								$PARAMS['object'] = 23090;
							}
							else
							{
								$PARAMS['object'] = 23080;
							}
						}
					}

					
					$url = $base_url.http_build_query($PARAMS);
					$this->addError('TARIFF-DATA: PARAMS:'.$url, 0);
				 
					$json = $this->getCurl($url); 
					
					if( $json == 'curl_error' )
					{
						return 'curl_error';
					}
					
					if( ( strstr($json, 'временно не работает') || strstr($json, 'Отправление нельзя доставить из') )
						&& !empty($to['zone_id']) 
						&& preg_match("/^9/", $PARAMS['to']) 
					)
					{
						$this->addError($PARAMS['to']." - временно не работает", 0); 
						
						$postamats = $this->getPostcodeByCityRegionCode($to['zone_id'], $to['city'], true, 4);
						
						foreach($postamats as $postamat)
						{
							$PARAMS['to'] = $postamat['postcode'];
							$url = $base_url.http_build_query($PARAMS);
							$json = $this->getCurl($url); 
							
							if( $json == 'curl_error' )
							{
								return 'curl_error';
							}
							
							if( strstr($json, 'временно не работает') )
							{
								$this->addError($PARAMS['to']." - временно не работает", 0); 
								continue;
							}
							else
								break;
						} 
					}
					
					$response = json_decode($json, 1);
					
					if( !empty($response['paynds'] ) )
					{
						break;
					}
				}
			}
		}
		else
		{
			if( strstr($service_key, '_avia') )
				$PARAMS['isavia'] = 2;
			else
				$PARAMS['isavia'] = 0;
				
			$url = 'https://tariff.pochta.ru/v2/calculate/tariff'.$delivery_url.'?'. http_build_query($PARAMS);
			
			$this->addError('TARIFF-DATA: PARAMS:'.$url, 0);
			
			$json = $this->getCurl($url);
			
			if( $json == 'curl_error' )
			{
				return 'curl_error';
			}
					
			$response = json_decode($json, 1);
			
			if( !empty($json) && 
				!empty($response['errors'][0]['msg']) && 
				(
					strstr($response['errors'][0]['msg'], 'Невозможно рассчитать плановую дату доставки') 
					||
					strstr($response['errors'][0]['msg'], 'Не удалось определить ММПО экспорта') 
				)
			)
			{
				$base_url = 'https://tariff.pochta.ru/v2/calculate/tariff'.$delivery_url.'?'; 
				$url = $base_url. http_build_query($PARAMS);
				
				$this->addError('Не рассчитался срок доставки, меняем URL: '.$url, 0);
				
				$json = $this->getCurl($url);
			} 
			
		}
		
		if( $json == 'curl_error' )
		{
			return 'curl_error';
		}
		
		if( $json )
		{
			if( empty($json) )
				return false;
			
			$response = json_decode($json, 1);
			
			if(  empty($response['paynds']) && !empty( $response['errors'][0]['msg'] ) )
			{
				$this->addError('TARIFF-DATA: '.$response['errors'][0]['msg'], 0);
				return false;
			}
			
			
			if( empty($response['paynds']) )
			{
				$this->addError('TARIFF-DATA: '.print_r($response, 1), 0);
				return false;
			}
			
			$shipping_cost = (float)$response['paynds'] / 100; 
			
			$this->addError('TARIFF-DATA: shipping_cost: '.$shipping_cost, 0);
			
			if(
				$is_need_ins &&
				strstr($service_key, '_insured')
			)
			{
				
				$sumoc = 10000;
				$shipping_cost -= 0.01;
				
				$PARAMS["sumoc"] = round($sumoc * 100); 
				
				$url = $base_url. http_build_query($PARAMS);
				$this->addError('TARIFF-DATA: SUMOC:'.$url, 0);
				$json = $this->getCurl($url);
				$response2 = json_decode($json, 1);
					
				if( empty($response2['paynds']) )
				{
					$this->addError('TARIFF-DATA: '.print_r($response2, 1), 0);
					return false;
				}
				
				if(
					$this->config_get('russianpost2_insurance_base') == 'total'
					||
					(
						(
							$this->config_get('russianpost2_insurance_base') != 'total'
							&&
							(float)$total_without_shipping_rub > (int)$this->SERVICES[ $service_key ]['limitcost']
						)
						&&
						$this->config_get('russianpost2_is_no_insurance_limit') == 2
					)
				)
				{
					$all_cost = (float)$response2['paynds'] / 100; 
					
					$shipping_cost = round($shipping_cost);
					
					$this->addError('TARIFF-DATA: shipping_cost: '.$shipping_cost, 0);
					$this->addError('TARIFF-DATA: all_cost: '.$all_cost, 0);
					
					$pre_ins_cost = (float)$all_cost - (float)$shipping_cost;
					
					$this->addError('TARIFF-DATA: pre_ins_cost: '.$pre_ins_cost, 0);
					
					$ins_perc = ( $pre_ins_cost * 100 ) / 10000;
					
					$this->addError('TARIFF-DATA: ins_perc: '.$ins_perc, 0);
					
					$ins_cost = 0;
					
					$insured_sum = 0;
					
					if( $this->config_get('russianpost2_insurance_base') == 'total' )
					{
						$insured_sum = (float)$total_without_shipping_rub + (float)$shipping_cost;
					}
					else
					{
						$insured_sum = (float)$total_without_shipping_rub;
					}
					
					$this->addError('TARIFF-DATA: insured_sum: '.$insured_sum, 0);
					
					$ins_cost = ( (float)$ins_perc * (float)$insured_sum ) / 100;
					
					$this->addError('TARIFF-DATA: ins_cost: '.$ins_cost, 0);
					
					//$total_base = (float)$insured_sum + (float)$ins_cost;
					
					//$ins_cost2 = ( (float)$total_base * (float)$ins_perc ) / 100;
					
					//$this->addError('TARIFF-DATA: ins_cost2: '.$ins_cost2, 0);
					
					//$total_cost = (float)$ins_cost2 + (float)$shipping_cost;
					
					$total_cost = (float)$ins_cost + (float)$shipping_cost;
					
					//$this->addError('TARIFF-DATA: Base for ALL insurance: '.$total_base, 0);
					
					
					$this->addError('TARIFF-DATA: cost with ALL insurance: '.$total_cost, 0);
					
					$response['paynds'] = (float)$total_cost * 100; 
				}
				else
				{
					$response['paynds'] = (float)$response2['paynds'];
					$total_cost = (float)$response2['paynds'] / 100;
					$this->addError('TARIFF-DATA: cost with insurance: '.$total_cost, 0);
				}
			} 
			 
			if( $pack_key 
				&& !empty($response['name']) 
				&& $response['name'] == 'Посылка стандарт' 
				&& !empty( $this->SERVICES[ str_replace("_insured", "", $service_key) ]['options']['is_pack_off']['status'] )
			)
			{
				$response['is_pack_off'] = 1;
			} 
			return $response;
		}
		
		return false;
	}
	
	private function getTariffSrok($service_key, 
								   $weight_gramm, 
								   $length_cm, 
								   $width_cm, 
								   $height_cm,  
								   $total_without_shipping_rub, 
								   $from, 
								   $to, 
								   $dop_cost_rub)
	{
		
		$this->tariff_srok_data[$service_key] = $this->requestTariffSrokData(
											 $service_key,
											 $from, 
											 $to
											 );
		
		$result = $this->getServiceDataFromTariffSrokData($service_key, $this->tariff_srok_data[$service_key]);
		
		if( !$result ) return false;
		
		list( $min_srok, $max_srok ) = $this->explodeSrok( $result['srok'] );
		
		return array(
					"min_srok" => $min_srok,
					"max_srok" => $max_srok
				);
	}
	
	private function requestTariffSrokData(
		$service_key,
		$from, 
		$to
	)
	{
		$this->addError('requestTariffSrokData - 1', 0);
		
		if( empty( $this->SERVICES[ $service_key ]['tariff_mailtype'] ) )
			return false;
		
		$this->addError('requestTariffSrokData - 2', 0);
		
		$PARAMS = array(
			"json" => '',  
			"object" => $this->SERVICES[ $service_key ]['tariff_key'],
			"from" => $from['postcode'],
		);
		
		$postcodes = array(
			$to['postcode']
		);
			
		
		if( !empty($to['city_postcode']) )
			$postcodes[] = $to['city_postcode'];
			
		if( !empty($to['region_postcode']) )
			$postcodes[] = $to['region_postcode'];
			
		$postcodes = array_flip( array_flip( $postcodes ) );
			
		$json = '';
		$response = '';
		$this->addError('requestTariffSrokData - 3: '.print_r($postcodes, 1), 0);
		foreach($postcodes as $postcode)
		{
			if( !empty($postcode) )
			{
				$PARAMS['to'] = $postcode;
				if( preg_match("/^9/", $PARAMS['to']  )  )
				{
					$russianpost2_services2api_list = $this->config_get('russianpost2_services2api_list');
				
					if( !empty($russianpost2_services2api_list['parcel_online_postamat']['postcode']) )
					{
						$PARAMS['from'] = $russianpost2_services2api_list['parcel_online_postamat']['postcode'];
					}
				}
				
				$url = 'https://delivery.pochta.ru/v2/calculate/delivery?'.
							http_build_query($PARAMS);
				
				$this->addError('TARIFF-SROK-DATA: PARAMS:'.$url, 0);
				
				$json = $this->getCurl($url);
				$this->addError('TARIFF-SROK-DATA: RESPONSE: '.$json, 0);
				if( $json == 'curl_error' )
					return false;
				
				$response = json_decode($json, 1);
				
				if( !empty($response['delivery']['min']) )
				{
					#$this->addError('TARIFF-DATA: ERROR: '.$response['errors'][0]['msg'], 0);
					break;
				}
			}
		}
		
		if($json)
		{
			$response = json_decode($json, 1);
			return $response;
		}
		
		return false;
	}
	
	private function getMultistoreId()
	{
		if( !empty($this->request->get['route'])
			 && $this->request->get['route'] == 'api/shipping/methods'
			 && $this->config_get('multistore_status') 
			 && !empty($this->request->get['order_id'])
		)
		{
			$sql = "SELECT * FROM `" . DB_PREFIX . "order` 
					WHERE order_id = '".(int)$this->request->get['order_id']."'";
			
			$order_info = $this->db_query($sql)->row;			
			
			if( !empty($order_info['multistore_id']) )
			{
				return $order_info['multistore_id'];
			}
		}
		elseif( !empty($this->request->cookie['multistore_id']) && 
			(
				empty($this->request->get['route']) ||
				$this->request->get['route'] != 'api/shipping/methods'
			)
		)
		{
			return $this->request->cookie['multistore_id'];
		}
	}
	
	private function getServicePostcode($service_key, $default_postcode, $to_postcode)
	{ 
		$service_key = str_replace('_insured', '', $service_key );
		
		if(  $service_key == 'parcel_online' && preg_match("/^9/", $to_postcode ) )
		{
			$service_key = "parcel_online_postamat";
		}
		
		if( strstr($service_key, 'parcel_20') )
			$service_key = str_replace('parcel_20', 'parcel', $service_key);
		elseif( strstr($service_key, 'parcel_50') )
			$service_key = str_replace('parcel_50', 'parcel', $service_key);
		
		$hash = array(); 
		$is_in = 0;
		
		$multistore_id = $this->getMultistoreId();
		
		if( $multistore_id )
		{
			$russianpost2_sklads = $this->config_get('russianpost2_sklads');
			
			if( !empty($russianpost2_sklads) )
			{
				foreach( $russianpost2_sklads as $sklad )
				{
					if( $sklad['multistore_id'] == $multistore_id )
					{
						$ORDER['SKLAD_FROM'] = array(
							"russianpost2_from_postcode" => trim( $sklad['postcode'] ),
							"russianpost2_from_city" => trim( $sklad['city'] ),
							"russianpost2_from_region" => trim( $sklad['region'] ), 
						);
					}
				}
			}
		}
		
		if( !$is_in )
		{
			$russianpost2_services2api_list = $this->config_get('russianpost2_services2api_list');
			foreach($russianpost2_services2api_list as $serv_key=>$item)
			{
				if( !empty($item['postcode']) )
				{
					$hash[$serv_key] = $item['postcode'];
				}
			} 
		}
		
		if( !empty( $hash[$service_key]) )
		{
			return trim($hash[$service_key]);
		}
		
		return $default_postcode;
	}
	
	private function isNoRemoteRegion($ems_code)
	{
		$list = array(
			'region--amurskaja-oblast',
			'region--arhangelskaja-oblast',
			'region--respublika-burjatija',
			'region--kamchatskij-kraj',
			'region--krasnojarskij-kraj',
			'region--magadanskaja-oblast',
			'region--respublika-saha-yakutija',
			'region--tomskaja-oblast',
			'region--tjumenskaja-oblast',
			'region--khabarovskij-kraj',
			'region--khanty-mansijskij-ao',
			'region--yamalo-neneckij-ao'
		);
		
		if( in_array($ems_code, $list ) )
			return false;
		else 
			return true;
	}
	
	private function getServiceDataFromTariffSrokData($service_key, $tariff_srok_data)
	{ 
		if( !empty($tariff_srok_data['delivery']['min']) )
		{
			return array(
				'srok' => $tariff_srok_data['delivery']['min'].'-'.$tariff_srok_data['delivery']['max']
			);
		}
		
		return false;
	}
	
	private function getPostcalcData($service_key, $weight_gramm, $length_cm, $width_cm, $height_cm, 
	$total_without_shipping_rub, $from, $to, $dop_cost_rub
		, $pvz_postcode)
	{
		$this->postcalc_data = $this->requestPostcalcData(
											 $service_key,
											 $weight_gramm, 
											 $length_cm, 
											 $width_cm, 
											 $height_cm, 
											 $total_without_shipping_rub, 
											 $from, 
											 $to,
											 $dop_cost_rub
											, $pvz_postcode
									);
					
		if( $this->postcalc_data == 'curl_error' )
		{
			$this->postcalc_data = '';
			return 'curl_error'; 
		}
		
		if( !$this->postcalc_data )
			return false;
		
		$result = $this->getServiceDataFromPostcalcData($service_key, $this->postcalc_data);
		
		if( !$result ) return false;
		###$result['cost'] = $this->minusNds( $result['cost'] );
		
		list( $min_srok, $max_srok ) = $this->explodeSrok( $result['srok'] );
		
		return array(
					"cost" => $result['cost'],
					"min_srok" => $min_srok,
					"max_srok" => $max_srok,
					"cod_cost"	=> $result['cod_cost']
				);
	}
	
	private function implodeSrok($min_srok, $max_srok)
	{
		if( !$min_srok && !$max_srok )
		{
			return '';
		}
		
		if( $min_srok == $max_srok )
		{
			return trim($min_srok);
		}
		else
		{
			return trim($min_srok).'-'.trim($max_srok);
		}
	}
	
	private function explodeSrok($srok)
	{
		if( strstr($srok, "-") )
		{
			$ar = explode("-", $srok );
			
			return array( trim($ar[0]), trim($ar[1]) );
		}
		else
		{
			return array( trim($srok), trim($srok) );
		}
	}
	
	
	
	private function requestPostcalcData( $service_key, $weight_gramm, $length_cm, $width_cm, $height_cm, $total_without_shipping_rub, $from, $to, $dop_cost_rub
											 , $pvz_postcode = '' 
											)
	{
		$url_hash = array();
		
		if( $this->config_get('russianpost2_api_postcalc_key') )
			$url_hash["key"] = $this->config_get('russianpost2_api_postcalc_key');
		
		$url_hash["st"] = $this->request->server['HTTP_HOST'];
		$url_hash["ml"] = $this->config_get('russianpost2_api_postcalc_email');
		$url_hash["f"]  = $from['postcode'];
		$url_hash["c"]  = $to['iso_code_2'];
		$url_hash["o"]  = "php";
		$url_hash["cs"]  = "UTF-8";
		$url_hash["w"]  = round($weight_gramm);
		$url_hash["d"]  =  date('Y-m-d', strtotime( date('Y-m-d').' +1 Weekday') );
		$url_hash["s"]  = 0;
		$url_hash["e"]  = 0;
		
		
		$url_hash["v"] = 0;
		
		if( strstr($service_key, 'foreign') )
		{
			if( strstr($service_key, 'insured') )
			{
				$url_hash["v"]  = round($total_without_shipping_rub);
			}
		}
		else
		{
			$url_hash["v"]  = round($total_without_shipping_rub);
		}
		
		if( $url_hash["v"] )
		{
			if( $this->config_get('russianpost2_is_no_insurance_limit') == 1 && 
				$total_without_shipping_rub > (int)$this->SERVICES[ $service_key ]['limitcost']  )
			{
				$url_hash["v"]  = (int)$this->SERVICES[ $service_key ]['limitcost'];
			}
		}
		
		if( 
			( 
				strstr($service_key, 'parcel_10') || 
				strstr($service_key, 'parcel_20') || 
				strstr($service_key, 'parcel_50') 
			)
			&&
			(
				(float)$length_cm + (float)$width_cm + (float)$height_cm > 120
				|| 
				$this->combinateLAFF(
						array(
							"length" => 60,
							"width" => 60,
							"height" => 60
						), 
						$this->PRODUCT_BOXES
				) != 1
			)
		)
		{  
			$url_hash["sv"] = 'ng';
		}
		
		if( $this->config->get('russianpost2_clienttype') == 'corporate' )
		{
			$url_hash['co'] = 1;
		}
		elseif( $this->config->get('russianpost2_clienttype') == 'common' )
		{
			$url_hash['co'] = 0;
		}
		
		
		if( !empty($this->SERVICES[ $service_key ]['options']) )
		{
			foreach( $this->SERVICES[ $service_key ]['options'] as $key=>$option )
			{
				if( 
					( $service_key == 'ems_optimal' || $service_key == 'ems_optimal_insured' )
					&&
					$key == 'is_courier'
				)
					continue;
					
				if( !empty($option['status']) )
				{
					if( $option['tariff_service_id'] == 28 ) // Корпоративный клиент
					{
						$url_hash['co'] = 1;
					}
					elseif( $key == 'is_negabarit' )
					{
						$url_hash["sv"] = 'ng';
					}
				}
			}
		}	
		
		if( $total_without_shipping_rub == -1 )
		{
			$url_hash["v"]  = 1;
			$url_hash["ib"]  = "p";
		}
		elseif( $this->config_get('russianpost2_insurance_base') == 'total' )
			$url_hash["ib"]  = "f"; // страховать всю сумму заказа
		else
			$url_hash["ib"]  = "p"; // страховать только товары
		
		#$url_hash["pr"]  = $dop_cost_rub; // пользовательская наценка
		$url_hash["pr"]  = 0;
		
		$url_hash["vt"]  = 1; // НДС не включен в тариф
		
		if( $postcalc_tariff_keys = $this->getPostcalcTariffKeys() )
		{
			$url_hash["p"]  = implode(",", $postcalc_tariff_keys); 
		}
		
		$postcodes = array();
		
		if( !empty( $pvz_postcode ) )
			$postcodes[] = $pvz_postcode;
		
		if( 
			$this->config_get('russianpost2_ifnopostcode') == 'off' ||
			(
				!$this->config_get('russianpost2_ifnouserpostcode') &&
				(
					strstr($service_key, 'ems_optimal') || 
					strstr($service_key, 'parcel_online') ||
					strstr($service_key, 'courier_online') 
				)
			)
		)
		{
			if( empty($to['user_postcode']) )
			{
				$this->addError('POSTCALC-DATA: no user postcode', 0);
				return false;
			}
			
			$postcodes = array(
				$to['user_postcode']
			);
		}
		else
		{
			if( !empty($to['user_postcode']) )
				$postcodes = array( $to['user_postcode'] );
			
			if( !empty($to['city_postcode']) )
			{
				$postcodes[] = $to['city_postcode'];
			}
			else
			{
				$postcodes[] = $to['region_postcode'];
			}
			$postcodes[] = 'city';
		}
		
		
		
		
		foreach($postcodes as $postcode)
		{
			if( $postcode != 'city' )
				$url_hash['t'] = $postcode;
			else
			{
				if( !empty($to['ems_name']) )
					$url_hash["t"]  = $to['city'].', '.$to['ems_name'];
				else
					$url_hash["t"]  = $to['city'];
			}
		
			$url_hash['f'] = $this->getServicePostcode(
				$service_key, 
				$this->ORDER['SKLAD_FROM']['russianpost2_from_postcode'],
				$postcode
			);
			
			$url = 'http://api.postcalc.ru/?'.http_build_query($url_hash);
			
			$this->addError('POSTCALC-URL: '.$url, 0);
			
			$response = $this->getCurl($url);
			
			if( $response == 'curl_error' )
				return 'curl_error';
			
			// Добавляем распаковку:
			if( is_string($response) && substr($response,0,3) == "\x1f\x8b\x08" ) 
			{
				$response = gzinflate(substr($response,10,-8));
				
				if( $response && $this->isSerialized( $response ) )
				{
					//$this->addError('POSTCALC-DATA: '.$response, 0);
					
					$response = unserialize($response);
					
					if( !empty($response["Status"]) && $response["Status"] == 'BAD_TO_INDEX' )
						continue;
					
					if( empty($response["Отправления"]) )
						return false;
					else
						return $response;
				}
			}
		}
		
		
		return false;
	}
	
	// =====================
	
	public function getCodeByCityName($city)
	{
		$russianpost2_city_hash = array();
		if( $this->config_get('russianpost2_city_hash') ) 
		{
			$russianpost2_city_hash = unserialize( $this->config_get('russianpost2_city_hash') );
		}
		else
		{
			$pay_data = '{"rsp":{"stat":"ok","locations":[{"value":"city--abakan","name":"АБАКАН","type":"cities"},{"value":"city--anadyr","name":"АНАДЫРЬ","type":"cities"},{"value":"city--anapa","name":"АНАПА","type":"cities"},{"value":"city--arhangelsk","name":"АРХАНГЕЛЬСК","type":"cities"},{"value":"city--astrahan","name":"АСТРАХАНЬ","type":"cities"},{"value":"city--bajkonur","name":"БАЙКОНУР","type":"cities"},{"value":"city--barnaul","name":"БАРНАУЛ","type":"cities"},{"value":"city--belgorod","name":"БЕЛГОРОД","type":"cities"},{"value":"city--birobidzhan","name":"БИРОБИДЖАН","type":"cities"},{"value":"city--blagoveshhensk","name":"БЛАГОВЕЩЕНСК","type":"cities"},{"value":"city--brjansk","name":"БРЯНСК","type":"cities"},{"value":"city--velikij-novgorod","name":"ВЕЛИКИЙ НОВГОРОД","type":"cities"},{"value":"city--vladivostok","name":"ВЛАДИВОСТОК","type":"cities"},{"value":"city--vladikavkaz","name":"ВЛАДИКАВКАЗ","type":"cities"},{"value":"city--vladimir","name":"ВЛАДИМИР","type":"cities"},{"value":"city--volgograd","name":"ВОЛГОГРАД","type":"cities"},{"value":"city--vologda","name":"ВОЛОГДА","type":"cities"},{"value":"city--vorkuta","name":"ВОРКУТА","type":"cities"},{"value":"city--voronezh","name":"ВОРОНЕЖ","type":"cities"},{"value":"city--gorno-altajsk","name":"ГОРНО-АЛТАЙСК","type":"cities"},{"value":"city--groznyj","name":"ГРОЗНЫЙ","type":"cities"},{"value":"city--dudinka","name":"ДУДИНКА","type":"cities"},{"value":"city--ekaterinburg","name":"ЕКАТЕРИНБУРГ","type":"cities"},{"value":"city--elizovo","name":"ЕЛИЗОВО","type":"cities"},{"value":"city--ivanovo","name":"ИВАНОВО","type":"cities"},{"value":"city--izhevsk","name":"ИЖЕВСК","type":"cities"},{"value":"city--irkutsk","name":"ИРКУТСК","type":"cities"},{"value":"city--ioshkar-ola","name":"ЙОШКАР-ОЛА","type":"cities"},{"value":"city--kazan","name":"КАЗАНЬ","type":"cities"},{"value":"city--kaliningrad","name":"КАЛИНИНГРАД","type":"cities"},{"value":"city--kaluga","name":"КАЛУГА","type":"cities"},{"value":"city--kemerovo","name":"КЕМЕРОВО","type":"cities"},{"value":"city--kirov","name":"КИРОВ","type":"cities"},{"value":"city--kostomuksha","name":"КОСТОМУКША","type":"cities"},{"value":"city--kostroma","name":"КОСТРОМА","type":"cities"},{"value":"city--krasnodar","name":"КРАСНОДАР","type":"cities"},{"value":"city--krasnojarsk","name":"КРАСНОЯРСК","type":"cities"},{"value":"city--kurgan","name":"КУРГАН","type":"cities"},{"value":"city--kursk","name":"КУРСК","type":"cities"},{"value":"city--kyzyl","name":"КЫЗЫЛ","type":"cities"},{"value":"city--lipeck","name":"ЛИПЕЦК","type":"cities"},{"value":"city--magadan","name":"МАГАДАН","type":"cities"},{"value":"city--magnitogorsk","name":"МАГНИТОГОРСК","type":"cities"},{"value":"city--majkop","name":"МАЙКОП","type":"cities"},{"value":"city--mahachkala","name":"МАХАЧКАЛА","type":"cities"},{"value":"city--mineralnye-vody","name":"МИНЕРАЛЬНЫЕ ВОДЫ","type":"cities"},{"value":"city--mirnyj","name":"МИРНЫЙ","type":"cities"},{"value":"city--moskva","name":"МОСКВА","type":"cities"},{"value":"city--murmansk","name":"МУРМАНСК","type":"cities"},{"value":"city--mytishhi","name":"МЫТИЩИ","type":"cities"},{"value":"city--naberezhnye-chelny","name":"НАБЕРЕЖНЫЕ ЧЕЛНЫ","type":"cities"},{"value":"city--nadym","name":"НАДЫМ","type":"cities"},{"value":"city--nazran","name":"НАЗРАНЬ","type":"cities"},{"value":"city--nalchik","name":"НАЛЬЧИК","type":"cities"},{"value":"city--narjan-mar","name":"НАРЬЯН-МАР","type":"cities"},{"value":"city--nerjungri","name":"НЕРЮНГРИ","type":"cities"},{"value":"city--neftejugansk","name":"НЕФТЕЮГАНСК","type":"cities"},{"value":"city--nizhnevartovsk","name":"НИЖНЕВАРТОВСК","type":"cities"},{"value":"city--nizhnij-novgorod","name":"НИЖНИЙ НОВГОРОД","type":"cities"},{"value":"city--novokuzneck","name":"НОВОКУЗНЕЦК","type":"cities"},{"value":"city--novorossijsk","name":"НОВОРОССИЙСК","type":"cities"},{"value":"city--novosibirsk","name":"НОВОСИБИРСК","type":"cities"},{"value":"city--novyj-urengoj","name":"НОВЫЙ УРЕНГОЙ","type":"cities"},{"value":"city--norilsk","name":"НОРИЛЬСК","type":"cities"},{"value":"city--nojabrsk","name":"НОЯБРЬСК","type":"cities"},{"value":"city--omsk","name":"ОМСК","type":"cities"},{"value":"city--orel","name":"ОРЁЛ","type":"cities"},{"value":"city--orenburg","name":"ОРЕНБУРГ","type":"cities"},{"value":"city--penza","name":"ПЕНЗА","type":"cities"},{"value":"city--perm","name":"ПЕРМЬ","type":"cities"},{"value":"city--petrozavodsk","name":"ПЕТРОЗАВОДСК","type":"cities"},{"value":"city--petropavlovsk-kamchatskij","name":"ПЕТРОПАВЛОВСК-КАМЧАТСКИЙ","type":"cities"},{"value":"city--pskov","name":"ПСКОВ","type":"cities"},{"value":"city--rostov-na-donu","name":"РОСТОВ-НА-ДОНУ","type":"cities"},{"value":"city--rjazan","name":"РЯЗАНЬ","type":"cities"},{"value":"city--salehard","name":"САЛЕХАРД","type":"cities"},{"value":"city--samara","name":"САМАРА","type":"cities"},{"value":"city--sankt-peterburg","name":"САНКТ-ПЕТЕРБУРГ","type":"cities"},{"value":"city--saransk","name":"САРАНСК","type":"cities"},{"value":"city--saratov","name":"САРАТОВ","type":"cities"},{"value":"city--smolensk","name":"СМОЛЕНСК","type":"cities"},{"value":"city--sochi","name":"СОЧИ","type":"cities"},{"value":"city--stavropol","name":"СТАВРОПОЛЬ","type":"cities"},{"value":"city--strezhevoj","name":"СТРЕЖЕВОЙ","type":"cities"},{"value":"city--surgut","name":"СУРГУТ","type":"cities"},{"value":"city--syktyvkar","name":"СЫКТЫВКАР","type":"cities"},{"value":"city--tambov","name":"ТАМБОВ","type":"cities"},{"value":"city--tver","name":"ТВЕРЬ","type":"cities"},{"value":"city--toljatti","name":"ТОЛЬЯТТИ","type":"cities"},{"value":"city--tomsk","name":"ТОМСК","type":"cities"},{"value":"city--tula","name":"ТУЛА","type":"cities"},{"value":"city--tynda","name":"ТЫНДА","type":"cities"},{"value":"city--tjumen","name":"ТЮМЕНЬ","type":"cities"},{"value":"city--ulan-udje","name":"УЛАН-УДЭ","type":"cities"},{"value":"city--uljanovsk","name":"УЛЬЯНОВСК","type":"cities"},{"value":"city--usinsk","name":"УСИНСК","type":"cities"},{"value":"city--ufa","name":"УФА","type":"cities"},{"value":"city--uhta","name":"УХТА","type":"cities"},{"value":"city--khabarovsk","name":"ХАБАРОВСК","type":"cities"},{"value":"city--khanty-mansijsk","name":"ХАНТЫ-МАНСИЙСК","type":"cities"},{"value":"city--kholmsk","name":"ХОЛМСК","type":"cities"},{"value":"city--cheboksary","name":"ЧЕБОКСАРЫ","type":"cities"},{"value":"city--cheljabinsk","name":"ЧЕЛЯБИНСК","type":"cities"},{"value":"city--cherepovec","name":"ЧЕРЕПОВЕЦ","type":"cities"},{"value":"city--cherkessk","name":"ЧЕРКЕССК","type":"cities"},{"value":"city--chita","name":"ЧИТА","type":"cities"},{"value":"city--elista","name":"ЭЛИСТА","type":"cities"},{"value":"city--yuzhno-sahalinsk","name":"ЮЖНО-САХАЛИНСК","type":"cities"},{"value":"city--yakutsk","name":"ЯКУТСК","type":"cities"},{"value":"city--yaroslavl","name":"ЯРОСЛАВЛЬ","type":"cities"},{"value":"city--sevastopol","name":"СЕВАСТОПОЛЬ","type":"cities"},{"value":"city--simferopol","name":"СИМФЕРОПОЛЬ","type":"cities"}]}}';
		
			
			$data = json_decode($pay_data , 1);
			
			if( empty($data['rsp']['locations']) )
				return false;
			
			$russianpost2_city_hash = array();
			
			foreach($data['rsp']['locations'] as $loc )
			{
				$russianpost2_city_hash[ $this->tolow($loc['name']) ] = $loc['value'];
			}
			
			$this->initClass();
			$this->RP2->updateOneSetting('russianpost2_city_hash',serialize( $russianpost2_city_hash ) ); 
	
		}
		
		if(!$russianpost2_city_hash) return false;
		
		if( !empty($russianpost2_city_hash[ $this->tolow($city) ]) )
		{
			return $russianpost2_city_hash[ $this->tolow($city) ];
		}
		
	}	
	
	private function isSerialized( $data ) {
		// if it isn't a string, it isn't serialized
		if ( !is_string( $data ) )
			return false;
		$data = trim( $data );
		if ( 'N;' == $data )
			return true;
		if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
			return false;
		switch ( $badions[1] ) {
			case 'a' :
			case 'O' :
			case 's' :
				if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
					return true;
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
					return true;
				break;
		}
		return false;
	}

	private function getOtpravkaData($service_key, $weight_gramm, $length_cm, $width_cm, $height_cm, $total_without_shipping_rub, $from, $to, $dop_cost_rub, $is_caution
											 
											, $pvz_postcode 
											)
	{
		$this->otpravka_data[$service_key] = $this->requestOtpravkaData(
											 $service_key,
											 $weight_gramm, 
											 $length_cm, 
											 $width_cm, 
											 $height_cm, 
											 $total_without_shipping_rub, 
											 $from, 
											 $to,
											 $dop_cost_rub,
											 $is_caution
											, $pvz_postcode
									); 
		
		if( $this->otpravka_data[$service_key] == 'curl_error' )
		{
			$this->otpravka_data[$service_key] = '';
			return 'curl_error';
		}
		
		
		if( empty($this->otpravka_data[$service_key]) )
			return false;
		
		$result = $this->getServiceDataFromOtpravkaData($service_key, 
														$this->otpravka_data[$service_key], 
													    $total_without_shipping_rub);
		
		list( $min_srok, $max_srok ) = $this->explodeSrok( $result['srok'] );
		
		return array(
					"cost" => $result['cost'],
					"min_srok" => $min_srok,
					"max_srok" => $max_srok,
				);
	}
	
	private function requestOtpravkaData( $service_key, $weight_gramm, 
	 $length_cm, 
	 $width_cm, 
	 $height_cm, 
	$total_without_shipping_rub, $from, $to, $dop_cost_rub, $is_caution, $pvz_postcode='' )
	{
		$request_headers = array(
			"Content-Type: application/json",
			"Accept: application/json;charset=UTF-8",
			"Authorization: AccessToken " . $this->config_get('russianpost2_api_otpravka_token'),
			"X-User-Authorization: Basic " . $this->config_get('russianpost2_api_otpravka_key')
		);
		
		$mail_category = '';
		if( strstr($service_key, "insured") || $total_without_shipping_rub == -1 )
			$mail_category = 'WITH_DECLARED_VALUE';
		else
			$mail_category = $this->SERVICES[ $service_key ]['otpravka_category'];
		
		if( 
			( 
				strstr($service_key, 'parcel_10') || 
				strstr($service_key, 'parcel_20') || 
				strstr($service_key, 'parcel_50') 
			)
			&&
			(
				(float)$length_cm + (float)$width_cm + (float)$height_cm <= 120
				&& 
				$this->combinateLAFF(
						array(
							"length" => 60,
							"width" => 60,
							"height" => 60
						), 
						$this->PRODUCT_BOXES,
						(40 * 40 * 40)
				) == 1
			)
		)
		{  
			$length_cm = 40;
			$width_cm = 40;
			$height_cm = 40;
		}
		else
		{
			list( $length_cm, $width_cm, $height_cm ) = $this->getDimensionsByDelivery(
				$service_key, 
				$this->SERVICES[ $service_key ]['DELIVERY'], 
				$length_cm, 
				$width_cm, 
				$height_cm
			);
		}
		
		$destination = array(
			"index-from" => $from['postcode'], //125124
			#"index-to" => $to['postcode'],  
			"mail-category" => $mail_category, // ORDINARY ORDERED WITH_DECLARED_VALUE WITH_DECLARED_VALUE_AND_CASH_ON_DELIVERY
			"mail-type" => $this->SERVICES[ $service_key ]['otpravka_type'], // LETTER POSTAL_PARCEL BANDEROL EMS ONLINE_COURIER ONLINE_PARCEL
			"mass" => ceil($weight_gramm),
			"rcp-pays-shipping" => "false",
			"dimension" => array(
				"height" => $height_cm,
				"length" => $length_cm,
				"width" => $width_cm
			),
			"fragile" =>  $is_caution ? "true" : "false"
		);
		
		if( !empty($this->SERVICES[$service_key]['options']['is_check_complete']['status']) )	
		{
			$destination["completeness-checking"] = true;
		}
		
		if( !empty($this->SERVICES[$service_key]['options']['is_check_content']['status']) )	
		{
			$destination["contents-checking"] = true;
		} 
		
		if( $this->ORDER['to']['iso_code_2'] != 'RU' )
			$destination['mail-direct'] = $to['tariff_country_id'];
			
		if( strstr($service_key, 'avia') )
			$destination['transport-type'] = "AVIA";
		else
			$destination['transport-type'] = "SURFACE";
		
		if( strstr($service_key, "ecom_marketplace") )
		{
			$destination["mail-category"] = 'WITH_DECLARED_VALUE';
			
			if( strstr($service_key, "ecom_marketplace_express") )
				$destination["transport-type"] = "EXPRESS";
			else
				$destination["transport-type"] = "SURFACE"; 
		}
		
		if( strstr($this->SERVICES[ $service_key ]['otpravka_type'], "EMS_OPTIMAL" ) 
			&& strstr( $service_key, 'courier')
		)
		{
			$destination["courier"] = "true";
		}
		
		if( $service_key == 'ems_foreign' )
		{
			$destination["entries-type"] = 'SALE_OF_GOODS';
		}
		elseif( $service_key == 'ems_foreign_doc' )
		{
			$destination["entries-type"] = 'DOCUMENT';
		}
		
		if( strstr($service_key, "insured") || $total_without_shipping_rub == -1 )
		{
			if( $total_without_shipping_rub == -1 )
				$total_without_shipping_rub = 1;
			
			$destination['declared-value'] = $total_without_shipping_rub * 100;
			
			if( $this->config_get('russianpost2_is_no_insurance_limit') == 1 && 
				$destination['declared-value'] > (int)$this->SERVICES[ $service_key ]['limitcost'] * 100 )
			{
				$destination['declared-value'] = (int)$this->SERVICES[ $service_key ]['limitcost'] * 100;
			}
			elseif(
				 $this->config_get('russianpost2_is_no_insurance_limit') == 2 && 
				$destination['declared-value'] > (int)$this->SERVICES[ $service_key ]['limitcost'] * 100
			)
			{
				$destination['declared-value'] = 10000 * 100;
			}
			
			if( $destination['declared-value'] < 1000 * 100 &&
				$this->config_get('russianpost2_insurance_base') == 'total' 
			)
			{
				$destination['declared-value'] = 1000 * 100;
			}
		}
		elseif( 
			strstr($service_key, "ecom_marketplace") &&  !strstr($service_key, "insured")
		)
		{
			$destination['declared-value'] = 100;
		} 
		
		$url = 'https://otpravka-api.pochta.ru/1.0/tariff';
		
		if( $this->ORDER['to']['iso_code_2'] != 'RU' )
		{
			$destination['index-from'] = $this->config_get('russianpost2_from_postcode');
			
			$this->addError('OTPRAVKA-DATA: PARAMS: '.print_r($destination, 1), 0 );
			$this->addError('OTPRAVKA-DATA: доставка заграницу', 0 );
			$this->addError('OTPRAVKA-DATA: REQUEST: '.json_encode( $destination ), 0 );
				
			$result = $this->getCurl($url, 'POST', json_encode( $destination ), $request_headers);
				
			if( $result == 'curl_error' )
			{
				$this->addError('OTPRAVKA-DATA: curl_error', 0);
				return 'curl_error';
			}
				
			$this->addError('OTPRAVKA-DATA: RESPONSE: '.print_r($result, 1), 0 );
			
			if( !$result )
			{
				$this->addError('OTPRAVKA-DATA: empty data', 0);
				return false;
			}
			
			if( !strstr($result, 'total-rate') ) 
			{
				$this->addError('OTPRAVKA-DATA: error '.$result, 0);
				return false;
			}
				
			$data = json_decode( $result, 1 );
							
			if( $data['total-rate'] == 0 )
			{
				$this->addError('OTPRAVKA-DATA: null total ', 0);
				return false;
			}
			
			$this->addError('OTPRAVKA-DATA: SUCCESS', 0);
		}
		else
		{
			$postcodes = array();
			
			if( !empty( $pvz_postcode ) )
				$postcodes[] = $pvz_postcode;
			
			if( 
				!$this->config_get('russianpost2_is_ignore_user_postcode') &&
				!empty($to['user_postcode'])
			)
				$postcodes[] = $to['user_postcode'];
				
			if( 
				$this->config_get('russianpost2_ifnopostcode') == 'off' || 
				(
					!$this->config_get('russianpost2_ifnouserpostcode') &&
					(
						strstr($service_key, 'ems_optimal') || 
						strstr($service_key, 'parcel_online') ||
						strstr($service_key, 'courier_online') 
					)
				)
			)
			{
				if( empty($to['user_postcode']) )
				{
					$this->addError('OTPRAVKA-DATA: no user postcode', 0);
					return false;
				}
				
				$postcodes[] = $to['postcode'];
			} 
			
			if( !empty($to['city_postcode']) )
			{
				if( $this->config_get('russianpost2_ifnopostcode') == 'on' &&
					(
						$this->config_get('russianpost2_ifnouserpostcode') ||
						(
							!strstr($service_key, 'ems_optimal') &&
							!strstr($service_key, 'parcel_online') && 
							!strstr($service_key, 'courier_online') 
						)
					) )
				{
					$postcodes[] = $to['city_postcode'];
				}
			}
			
			if( $this->config_get('russianpost2_ifnopostcode') == 'on' &&
				(
					!strstr($service_key, 'ems_optimal') &&
					!strstr($service_key, 'parcel_online') && 
					!strstr($service_key, 'courier_online')  
				) 
			)
				$postcodes[] = $to['region_postcode'];
				
			$data = array();
			$result = array();
			
			$postcodes = array_flip( array_flip( $postcodes ) );
			
			foreach($postcodes as $postcode)
			{
				$this->addError('OTPRAVKA-DATA: индекс получателя: '.$postcode, 0 );
				
				$destination["index-to"] = $postcode;
				
				if( preg_match("/^9/", $postcode )  )
				{
					if( strstr($service_key, "parcel_online") )
					{ 
						if( strstr($service_key, "insured") || $total_without_shipping_rub == -1  )
							$destination["mail-category"] = 'COMBINED_WITH_DECLARED_VALUE';
						else
							$destination["mail-category"] = "COMBINED_ORDINARY"; 
						
						$destination["mail-type"] = "ONLINE_PARCEL";
						$destination["transport-type"] = "COMBINED";  
					}
				}
				
				$destination['index-from'] = $this->getServicePostcode(
					$service_key, 
					$from['postcode'],
					$postcode
				);
				
				$this->addError('OTPRAVKA-DATA: REQUEST: '.json_encode( $destination ), 0 );
				
				$result = $this->getCurl($url, 'POST', json_encode( $destination ), $request_headers);
				
				if( !$result )
				{
					$this->addError('OTPRAVKA-DATA: empty data', 0);
					continue;
				}
				
				if( $result == 'curl_error' )
				{
					$this->addError('OTPRAVKA-DATA: curl_error', 0);
					return 'curl_error';
				}
				
				$this->addError('OTPRAVKA-DATA: RESPONSE: '.$result, 0 );
				
				if( strstr($result, 'Instance PostalOperatorTuple not found for params') 
						&&
						strstr($result, $from['postcode']) 
						&&
						!empty( $from['postcode1'] )
				)
				{
					$this->addError('OTPRAVKA-DATA: меняем индекст отправления: '.$from['postcode1'], 0 );
					$destination["index-from"] = $from['postcode1'];
					
					$this->addError('OTPRAVKA-DATA: REQUEST: '.json_encode( $destination ), 0 );
				
					$result = $this->getCurl($url, 'POST', json_encode( $destination ), $request_headers); 
					
					if( !$result )
					{
						$this->addError('OTPRAVKA-DATA: empty data', 0);
						continue;
					}
					
					if( $result == 'curl_error' )
					{
						$this->addError('OTPRAVKA-DATA: curl_error', 0);
						return 'curl_error';
					}
					
					$this->addError('OTPRAVKA-DATA: RESPONSE: '.$result, 0 );
				} 
					
				if( !strstr($result, 'total-rate') ) 
				{
					$this->addError('OTPRAVKA-DATA: error '.$result, 0);
					continue;
				}
				
				$data = json_decode( $result, 1 );
							
				if( $data['total-rate'] == 0 )
				{
					$this->addError('OTPRAVKA-DATA: null total ', 0);
					continue;
				}
				

				$this->addError('OTPRAVKA-DATA: SUCCESS', 0 );
				break;
			}
		}
		
		$this->addError('OTPRAVKA-DATA: RESULT: '.print_r($data, 1),  0);
			
		return $data;
	}
	
	
	private function getOtpravkaTypeSize(
		$length_cm, 
		$width_cm, 
		$height_cm,
		$PRODUCT_BOXES = array()
	)
	{
		list(
			$length_cm, $width_cm, $height_cm
		) = $this->getSizeValues($length_cm, $width_cm, $height_cm);
			
		$list = array(
			"S" => array("length" => 26, "width" => 17, "height" => 8 ),
			"M" => array("length" => 30, "width" => 20, "height" => 15 ),
			"L" => array("length" => 40, "width" => 27, "height" => 18 ),
			"XL" => array("length" => 53, "width" => 26, "height" => 22 ),
			"OVERSIZED" => array("length" => 60, "width" => 60, "height" => 60 ), // sum = 140
		);

		
		foreach($list as $key=>$container)
		{
			
			$c_levels = $this->combinateLAFF($container, $this->PRODUCT_BOXES);
			
			if( $c_levels == 1 )
			{
				if( $key != 'OVERSIZED' || 
					((float)$length_cm + (float)$width_cm + (float)$height_cm) < 140
				)
				{
					return $key; 
				}
			}
		}
		
		return false;
	}
	
	private function getServiceDataFromOtpravkaData($service_key, $otpravka_data, $total_without_shipping_rub)
	{
		$cost = 0; 
		if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) )	
			$cost = (float)$otpravka_data['total-rate'] / 100;
		else
			$cost = ((float)$otpravka_data['total-rate'] + (float)$otpravka_data['total-vat']) / 100;
		
		
		if( !empty($otpravka_data['insurance-rate']['rate']) 
			&&
			strstr($service_key, 'insured')
		)
		{
			if( $total_without_shipping_rub == -1 )
				$total_without_shipping_rub = 1;
			
			if( $this->config_get('russianpost2_insurance_base') != 'total' && 
				$total_without_shipping_rub <= (int)$this->SERVICES[ $service_key ]['limitcost']
			)
			{
				// none
			}
			else
			{
				$base = $total_without_shipping_rub;
				
				if( $base > (int)$this->SERVICES[ $service_key ]['limitcost'] && 
					$this->config_get('russianpost2_is_no_insurance_limit') == 1 )
					$base = (int)$this->SERVICES[ $service_key ]['limitcost'];
				elseif(
					$base > (int)$this->SERVICES[ $service_key ]['limitcost'] && 
					$this->config_get('russianpost2_is_no_insurance_limit') == 2
				)
					$base = 10000;
					
				if( $base < 1000 )
					$base = 1000;
				
				$this->addError('OTPRAVKA-DATA: ins_base: '.$base, 0);
			
				$ins_cost = 0;
				if( !empty($otpravka_data['insurance-rate']['vat']) )
					$ins_cost = ($otpravka_data['insurance-rate']['rate'] + $otpravka_data['insurance-rate']['vat']) / 100;
				else
					$ins_cost = $otpravka_data['insurance-rate']['rate'] / 100;
				
				$this->addError('OTPRAVKA-DATA: ins_cost: '.$ins_cost, 0);
			
				$ins_perc = $ins_cost * 100 / $base;  
			
				$this->addError('OTPRAVKA-DATA: ins_perc: '.$ins_perc, 0); 
				
				$old_total_cost = 0; 
				if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) )	
					$old_total_cost = (float)$otpravka_data['total-rate'] / 100;
				else
					$old_total_cost = ((float)$otpravka_data['total-rate'] + (float)$otpravka_data['total-vat'])/100;
				
				$this->addError('OTPRAVKA-DATA: old_total_cost: '.$old_total_cost, 0); 
				
				$delivery_cost = $old_total_cost - $ins_cost;
				
				$this->addError('OTPRAVKA-DATA: delivery_cost: '.$delivery_cost, 0); 
				
				$real_ins_cost = 0;
				
				$base2 = 0;
				if( $this->config_get('russianpost2_insurance_base') == 'total' )
					$base2 = $delivery_cost + $total_without_shipping_rub;
				else
					$base2 = $total_without_shipping_rub;
				
				if( $base2 > (int)$this->SERVICES[ $service_key ]['limitcost'] && 
					$this->config_get('russianpost2_is_no_insurance_limit') == 1
				)
					$base2 = $this->SERVICES[ $service_key ]['limitcost'];
				
				$this->addError('OTPRAVKA-DATA: ins_base2: '.$base2, 0); 
				
				$real_ins_cost = $base2 * $ins_perc / 100;
				
				$this->addError('OTPRAVKA-DATA: real_ins_cost: '.$real_ins_cost, 0); 
				
				$cost = $delivery_cost + $real_ins_cost;
				
				$this->addError('OTPRAVKA-DATA: result_cost: '.$cost, 0); 
			}
			
		}
		
		if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) 
			|| !$this->config_get('russianpost2_is_nds')
		)
		{
			$pre_cost = $cost;
			$cost = $this->minusNds( $cost );
			$this->addError('getServiceDataFromOtpravkaData: '.$pre_cost.' minusNds = '.$cost, 0);
		}
		
		$srok = false;
		
		if( !empty($otpravka_data['delivery-time']) 
			&&
			(
				!empty($otpravka_data['delivery-time']['max-days']) 
				||
				!empty($otpravka_data['delivery-time']['min-days']) 
			)
		)
		{
			if( 
				!empty($otpravka_data['delivery-time']['max-days']) && 
				!empty($otpravka_data['delivery-time']['min-days'])  
			)
				$srok = $otpravka_data['delivery-time']['min-days'].'-'.$otpravka_data['delivery-time']['max-days'];
			elseif( !empty($otpravka_data['delivery-time']['max-days']) )
				$srok = $otpravka_data['delivery-time']['max-days'];
			elseif( !empty($otpravka_data['delivery-time']['min-days']) )
				$srok = $otpravka_data['delivery-time']['min-days'];
		}
		
		return array(
			"cost" => $cost, //$data['Доставка'],
			"srok" => $srok
		);
	}
	
	private function getServiceDataFromPostcalcData($service_key, $postcalc_data)
	{
		$postcalc_key = $this->SERVICES[ $service_key ]['postcalc_key'];
		$data = array();
		
		
		if( empty($postcalc_data['Отправления'][$postcalc_key]) )
		{
			$this->addError('POSTCALC-DATA: ('.$postcalc_key.') - нет данных', 0);
			return false;
		}
		else
		{
			$data = $postcalc_data['Отправления'][$postcalc_key];
		}
		
		if( empty($data['Количество']) || $data['Количество'] != 1 )
		{
			$this->addError('POSTCALC-DATA: ('.$postcalc_key.') количество != 1', 0);
			return false;
		}
		
		if( empty($data['Доставка']) )
		{
			$this->addError('POSTCALC-DATA: ('.$postcalc_key.') Доставка - пустое значение', 0);
			return false;
		}
		
		$cost = 0;
		if( strstr($service_key, "insured") )
		{
			$cost = $data['Доставка'];
		}
		else
		{
			$cost = $data['Тариф'];
		}
		
		$cod_cost = 0;
		
		if( isset($data['НаложенныйПлатеж']) )
		$cod_cost = $data['НаложенныйПлатеж'];
		
		if( !empty($this->SERVICES[$service_key]['options']['is_no_nds']['status']) 
			|| !$this->config_get('russianpost2_is_nds')
		)
		{
			$pre_cost = $cost;
			$cost = $this->minusNds( $cost );
			$this->addError('getServiceDataFromPostcalcData: '.$pre_cost.' minusNds = '.$cost, 0);
		}
		
		return array(
			"cost" => $cost, //$data['Доставка'],
			"cod_cost" => $cod_cost,
			"srok" => !empty($data['СрокДоставки']) ? $data['СрокДоставки'] : 0
		);
	}
	
	private function getCacheData($source, $url, $request_data)
	{
		if( !$this->config_get('russianpost2_api_'.$source.'_cache') && $source != 'print-post'  )
			return;
		
		$key = $url."|".$request_data;
		
	
		$md5_key = md5($key);
		  
		$lifetime = 10;
		if( $source == 'tariff' ||  $source == 'tariff_srok' )
			$lifetime = (int)$this->config_get('russianpost2_tariff_cache_lifetime');
		elseif( $source == 'postcalc' )
			$lifetime = (int)$this->config_get('russianpost2_postcalc_cache_lifetime');
		elseif( $source == 'otpravka' )
			$lifetime = (int)$this->config_get('russianpost2_otpravka_cache_lifetime');
			
		if( !$lifetime )
			$lifetime = 10;
		
		$this->db_query("DELETE FROM `" . DB_PREFIX . "russianpost2_cache` 
						  WHERE DATE_ADD(cdate, INTERVAL ".(int)$lifetime." DAY) < NOW() AND source = '".$this->db->escape($source)."'");
		 
		
		$sql = "SELECT * FROM `" . DB_PREFIX . "russianpost2_cache` 
				WHERE md5_key = '".$this->db->escape($md5_key)."' AND source = '".$this->db->escape($source)."' ORDER BY id DESC";
		
		$query = $this->db_query($sql);				  
		 
		if( $query->row )
		{
			return $query->row['response_data'];
		}
	}
	
	private function saveCacheData($source, $url, $request_data, $response_data)
	{ 
		if( !$this->config_get('russianpost2_api_'.$source.'_cache') && $source != 'print-post'  )
			return;
		
		$key = $url."|".$request_data;
		$md5_key = md5($key);
		
		$check = $this->db_query("SELECT * FROM `" . DB_PREFIX . "russianpost2_cache` 
		WHERE md5_key = '".$this->db->escape($md5_key)."'   AND source = '".$this->db->escape($source)."'");
		
		if( !$check->row )
			$this->db_query("INSERT INTO `" . DB_PREFIX . "russianpost2_cache` 
									SET
										md5_key = '".$this->db->escape($md5_key)."',
										source = '".$this->db->escape($source)."',
										key_data = '".$this->db->escape($key)."',
										response_data = '".$this->db->escape( $response_data )."',
										cdate = NOW() ");
		else
			$this->db_query("UPDATE `" . DB_PREFIX . "russianpost2_cache` 
									SET
										key_data = '".$this->db->escape($key)."',
										response_data = '".$this->db->escape( $response_data)."',
										cdate = NOW() 
									WHERE 
										md5_key = '".$this->db->escape($md5_key)."' AND 
										source = '".$this->db->escape($source)."'
									");
	}
	
	private function getFormulaParams($formula_key)
	{
		$query = $this->db_query("SELECT * FROM `" . DB_PREFIX . "russianpost2_formuls` WHERE formula_group = '".$this->db->escape($formula_key)."'");
		
		return $query->rows;
	}
	
	
	private function getServiceSources($service_key, $to_postcode)
	{
		$services = array();
		$service_1 = '';
		
		$russianpost2_services2api_list = $this->config_get('russianpost2_services2api_list');
		
		if( strstr($service_key, 'parcel_10') )
			$service_key = str_replace("parcel_10", "parcel", $service_key);
		if( strstr($service_key, 'parcel_20') )
			$service_key = str_replace("parcel_20", "parcel", $service_key);
		if( strstr($service_key, 'parcel_50') )
			$service_key = str_replace("parcel_50", "parcel", $service_key);
			
		if( !empty( $russianpost2_services2api_list[$service_key]['source'] ) 
			&& 
			strstr( $this->SERVICES[ $service_key ]['source'], $russianpost2_services2api_list[$service_key]['source'] )
			&&
			!empty( $this->SOURCES[ $russianpost2_services2api_list[$service_key]['source'] ] )
		)
		{
			$service_1 = $russianpost2_services2api_list[$service_key]['source'];
			$services[] = $russianpost2_services2api_list[$service_key]['source'];
		}
		
		// -----
		
		$sources = $this->SERVICES[ $service_key ]['source'];
		
		foreach($this->SOURCES as $source_key=>$source)
		{
			if( strstr($this->SERVICES[ $service_key ]['source'], $source_key) 
				&& $service_1 != $source_key
			)
			{
				$services[] = $source_key;
			}
		}
		
		return $services;
	}
	
	
	private function getDeliveryTypeByService($service) 
	{
		if( strstr($service, 'split_parcel' ) && !strstr($service, 'split_parcel_online' ) )
		{
			$service = 'parcel_50';
		}
		$service = str_replace("split_", "", $service);
		
		$result = array();
		
		$query2 = $this->db_query("SELECT * FROM `" . DB_PREFIX . "russianpost2_config` WHERE config_key = 'delivery_types'");
		$column_hash = explode(":", $query2->row['value']);
		
		// -------
		
		$sql = "SELECT dt.* 
		FROM `" . DB_PREFIX . "russianpost2_services` s 
		JOIN `" . DB_PREFIX . "russianpost2_delivery_types` dt
		ON s.type_key = dt.type_key
		WHERE s.service_key = '".$this->db->escape($service)."'";
		
		$query = $this->db_query($sql);
		
		// -------
		
		$data_ar = explode("|", $query->row['data']);
		
		foreach($data_ar as $i=>$value)
		{
			$query->row['data_'.$column_hash[$i]] = $value;
		}
		
		// ------
		
		$row = $query->row;
		$type_key = $query->row['type_key'];
		$delivery_types_info = $this->config_get("russianpost2_delivery_types");
		
		$result = array(
			"type_key" 		=> $type_key,
			"type_name" 	=> $row["type_name"],
			"type_name_z" 	=> $row["type_name"],
			"maxweight" 	=> $row["data_maxweight"],
			"maxlength" 	=> $row["data_maxlength"],
			"maxwidth" 		=> $row["data_maxwidth"],
			"maxheight" 	=> $row["data_maxheight"],
			"maxsum" 		=> $row["data_maxsum"],
			"maxsumokrugl" 	=> $row["data_maxsumokrugl"],
		);
		
		if( isset($delivery_types_info[ $type_key ]['type_name_z']) )
		{
			$result['type_name_z'] = $delivery_types_info[ $type_key ]['type_name_z'];
		}
		
		if( isset($delivery_types_info[ $type_key ]['maxweight_mode']) && 	
			$delivery_types_info[ $type_key ]['maxweight_mode'] != 'auto' )
		{
			$result['maxweight'] = $delivery_types_info[ $type_key ]['maxweight'];
		}

		if( isset($delivery_types_info[ $type_key ]['maxlength_mode']) && 	
			$delivery_types_info[ $type_key ]['maxlength_mode'] != 'auto' )
		{
			$result['maxwidth'] = $delivery_types_info[ $type_key ]['maxwidth'];
		}
		
		if( isset($delivery_types_info[ $type_key ]['maxlength_mode']) && 	
			$delivery_types_info[ $type_key ]['maxlength_mode'] != 'auto' )
		{
			$result['maxwidth'] = $delivery_types_info[ $type_key ]['maxwidth'];
		}
		
		if( isset($delivery_types_info[ $type_key ]['maxlength_mode']) && 	
			$delivery_types_info[ $type_key ]['maxlength_mode'] != 'auto' )
		{
			$result['maxheight'] = $delivery_types_info[ $type_key ]['maxheight'];
		}
		
		if( isset($delivery_types_info[ $type_key ]['maxsum_mode']) && 	
			$delivery_types_info[ $type_key ]['maxsum_mode'] != 'auto' )
		{
			$result['maxsum'] = $delivery_types_info[ $type_key ]['maxsum'];
		}
		
		
		$result['maxlength'] = (float)$result['maxlength'] / 10;
		$result['maxwidth'] = (float)$result['maxwidth'] / 10;
		$result['maxheight'] = (float)$result['maxheight'] / 10;
		$result['maxsum'] = (float)$result['maxsum'] / 10; 
		
		return $result;
	}
	
	
	private function getSplitConditions( $CURRENT_ORDER, $service_key = 'parcel_50' )
	{
		if( $service_key == 'parcel' || $service_key == 'parcel_20' )
			$service_key = 'parcel_50';
		
		$delivery_type = $this->getDeliveryTypeByService($service_key);
		
		$MAXWEIGHT = $delivery_type['maxweight'];
		
		$MAXSUM = $delivery_type['maxsum'];
		
		$container = array(
					"length" => $delivery_type['maxlength'] ,
					"width" => $delivery_type['maxwidth'] ,
					"height" => $delivery_type['maxheight'] 
		);
		
		$boxes = array();
		$deliveries = array();
		
		$split_deliveries = array();
		$skip_hash = array();
		
		foreach($this->PRODUCTS as $i=>$product)
		{
			if( !empty($product['set_split']) )
			{
				$skip_hash[$i] = 1;
				$split_deliveries[] = array();
				
				$res_weight = (float)$product["weight_gramm"] + ((float)$CURRENT_ORDER['final']['dop_weight_gramm'] / count($this->PRODUCTS) );
				$res_length = (float)$product["length_cm"] + ((float)$CURRENT_ORDER['final']['dop_length_cm'] / count($this->PRODUCTS) );
				$res_width = (float)$product["width_cm"] + ( (float)$CURRENT_ORDER['final']['dop_width_cm'] / count($this->PRODUCTS) );
				$res_height = (float)$product["height_cm"] + ( (float)$CURRENT_ORDER['final']['dop_height_cm'] / count($this->PRODUCTS) );
				$res_price = (float)$product["price_rub"];
			
				list( $res_length, $res_height, $res_width ) = $this->getSizeValues($res_length, $res_width, $res_height);
			
				$split_deliveries[ count($split_deliveries)-1 ][] = array(
									"length" => $res_length,
									"width"  => $res_width,
									"height" => $res_height,
									"price" => $res_price,
									"weight" => $res_weight
				);
			}
		}
			
		
		foreach($this->PRODUCTS as $i=>$product)
		{
			if( !empty($skip_hash[$i]) )
				continue;
			$res_weight = (float)$product["weight_gramm"] + ((float)$CURRENT_ORDER['final']['dop_weight_gramm'] / count($this->PRODUCTS) );
			$res_length = (float)$product["length_cm"] + ((float)$CURRENT_ORDER['final']['dop_length_cm'] / count($this->PRODUCTS) );
			$res_width = (float)$product["width_cm"] + ( (float)$CURRENT_ORDER['final']['dop_width_cm'] / count($this->PRODUCTS) );
			$res_height = (float)$product["height_cm"] + ( (float)$CURRENT_ORDER['final']['dop_height_cm'] / count($this->PRODUCTS) );
			$res_price = (float)$product["price_rub"];
			
			list( $res_length, $res_height, $res_width ) = $this->getSizeValues($res_length, $res_width, $res_height);
				
			$boxes  = array(
				"length" => $res_length,
				"width"  => $res_width,
				"height" => $res_height,
				"price" => $res_price,
				"weight" => $res_weight
			);
			
		
			$c_levels = $this->combinateLAFF($container, $boxes);
			
			$current_weight = $this->getArrayWeight( array($boxes) );
			 
			$current_lengthsum = $this->getArrayLengthSum( array($boxes) );
			
			if( $c_levels != 1 || $current_weight > $MAXWEIGHT || 
				( $MAXSUM > 0 && $current_lengthsum > $MAXSUM )
			)
			{
				return false;
			}
			
			if( !$deliveries )
				$deliveries[] = array();
			
			$is_in = 0;
			
			foreach($deliveries as $i=>$item)
			{
				if( !$is_in )
				{
					$l_boxes = $deliveries[$i];
					$l_boxes[] = $boxes;
							
					if( 
						(
							$container['length'] == 0 ||
							$this->combinateLAFF($container, $l_boxes) == 1 
						) &&
						$this->getArrayWeight($l_boxes) <= $MAXWEIGHT
						&& 
						(
							$MAXSUM == 0 ||
							$this->getArrayLengthSum($l_boxes) <= $MAXSUM
						)
					)
					{
						$is_in = 1;
						$deliveries[$i][] = $boxes; 
					}
				} 
			}
			
			if( !$is_in )
			{
				$deliveries[] = array($boxes);
			}
		} 
		
		if( !empty($split_deliveries) )
			$deliveries = array_merge($deliveries, $split_deliveries);
			
		$results = array();
		
		foreach($deliveries as $i=>$boxes)
		{
			$sumweight = 0;
			$sumprice = 0;
			$sumwidth = 0;
			$maxlength = 0;
			$maxheight = 0;
			
			foreach( $boxes as $box)
			{
				$sumweight += (float)$box['weight'];
				$sumwidth += (float)$box['width'];
				$sumprice += (float)$box['price'];
				
				if( (float)$box['length'] > (float)$maxlength )
					$maxlength = $box['length'];
				
				if( (float)$box['height'] > (float)$maxheight )
					$maxheight = $box['height'];
			}
			
			if(  $sumweight || $maxlength)
			{
				$results[] = array(
					"length" => $maxlength,
					"width"  => $sumwidth,
					"height" => $maxheight,
					"total"	 => $sumprice,
					"weight" => $sumweight
				);
			}
		}
		
		return $results;
	}
	
	private function getArrayLengthSum($boxes)
	{
		$sumwidth = 0;
		$maxheight = 0;
		$maxlength = 0;
		
		foreach($boxes as $box)
		{
			$res_length = (float)$box["length"];
			$res_width = (float)$box["width"];
			$res_height = (float)$box["height"];
					
			list( $res_length, $res_height, $res_width ) = $this->getSizeValues($res_length, $res_width, $res_height);
					
			$sumwidth += $res_width;
					
			if( (float)$res_length > (float)$maxlength )
				$maxlength = $res_length;
					
			if( (float)$res_height > (float)$maxheight )
				$maxheight = $res_height;
		}
		
		return $sumwidth+$maxlength+$maxheight;
	}
	
	
	private function getArrayWeight($array)
	{
		$sum_weight = 0;
		
		foreach($array as $item)
		{
			$sum_weight += $item['weight'];
		}
		
		return $sum_weight;
	}
	
	private function isTableExists( $table_key )
	{
		$query = $this->db_query("SHOW TABLES LIKE '" . DB_PREFIX . $this->db->escape($table_key). "'");
		
		return empty($query->row) ? false : true;
	}
	
	private function checkOpsDB()
	{
		if( !$this->isTableExists( 'russianpost2_indexes' ) )
		{
			$this->db_query("CREATE TABLE IF NOT EXISTS 
				`" . DB_PREFIX . "russianpost2_indexes` (
				`id` int(11) NOT NULL auto_increment,
				`region_id` int(11) NOT NULL,
				`postcode` varchar(100) NOT NULL,
				`address` varchar(300) NOT NULL,
				`wtime` varchar(300) NOT NULL,
				`city` varchar(300) NOT NULL,
				`lat` varchar(100) NOT NULL,
				`lon` varchar(100) NOT NULL,
				`is_online_parcel` int(11) NOT NULL,
				`is_online_courier` int(11) NOT NULL,
				`is_ems_optimal` int(11) NOT NULL,
				PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		}
	}
	
	private function isOrderComplianceService($service, $CURRENT_ORDER, $key, $pvztype)
	{
		if( 
			strstr($service, "parcel_online") &&  
			$pvztype == 'NOOPS_ONLY_LIST' || $pvztype == 'NOOPS_ONLY_PAYMENT_LIST' 
		)
		{
			if( 
					$this->getOtpravkaTypeSize( 
						$CURRENT_ORDER['final']['sum_length_cm'], 
						$CURRENT_ORDER['final']['max_width_cm'], 
						$CURRENT_ORDER['final']['max_height_cm'], 
						$this->PRODUCT_BOXES
					) 
			)
			{
				return true;
			}
			else
			{
				$this->addError('('.$key.') '.$service.' - габариты не соответствуют лимитам ПВЗ ('.
				$CURRENT_ORDER['final']['sum_length_cm'].'x'.$CURRENT_ORDER['final']['max_width_cm'].'x'.$CURRENT_ORDER['final']['max_height_cm'].")" , 
				0);
			
				return false;
			}
		}
		
		$delivery_type = $this->getDeliveryTypeByService( $service );

		list( $delivery_type['maxlength'], $delivery_type['maxwidth'], $delivery_type['maxheight'] ) = $this->getSizeValues($delivery_type['maxlength'], $delivery_type['maxwidth'], $delivery_type['maxheight']);
		
		
		if( (float)$CURRENT_ORDER['final']['sum_weight_gramm']  > (float)$delivery_type['maxweight'] 
			&& !strstr($service, 'split')
		)
		{
			if( !empty($CURRENT_ORDER['final']['dop_weight_gramm']) )
			{
				$pre_weight = (float)$CURRENT_ORDER['final']['sum_weight_gramm'] - $CURRENT_ORDER['final']['dop_weight_gramm'];
				
				$this->addError('('.$key.') '.$service.' - вес не соответствует ('.$pre_weight.' + '.$CURRENT_ORDER['final']['dop_weight_gramm'].' > '.$delivery_type['maxweight'].'). '.
				$delivery_type['maxweight'].' г. (orderdop: '.$CURRENT_ORDER['final']['dop_weight_gramm'].' г. )', 0);
			}
			else
			{
				$this->addError('('.$key.') '.$service.' - вес не соответствует ('.$CURRENT_ORDER['final']['sum_weight_gramm'].' > '.$delivery_type['maxweight'].'). '.
				$delivery_type['maxweight'].' г. (orderdop: '.$CURRENT_ORDER['final']['dop_weight_gramm'].' г. )', 0);
			}
		
			
			return false;
		} 
		
		
		/*
		list( $ORDER['final']['max_length_cm'], $ORDER['final']['max_width_cm'], $ORDER['final']['max_height_cm'] ) = $this->getSizeValues($ORDER['final']['max_length_cm'], $ORDER['final']['max_width_cm'], $ORDER['final']['max_height_cm']);
		*/
		if( $delivery_type['maxlength'] > 0 && $delivery_type['maxwidth'] > 0 && $delivery_type['maxheight'] > 0 )
		{
			$container = array(
					"length" => $delivery_type['maxlength'],
					"width" => $delivery_type['maxwidth'],
					"height" => $delivery_type['maxheight']
			);
			
			$c_levels = $this->combinateLAFF($container, $this->PRODUCT_BOXES);
			
			if( strstr($service, 'split_' ) )
			{
				foreach($this->PRODUCT_BOXES as $box)
				{
					if( (float)$box['length'] > (float)$container['length'] 
						||
						(float)$box['width'] > (float)$container['width'] 
						||
						(float)$box['height'] > (float)$container['height'] 
					)
					{
						$this->addError('('.$key.') '.$service.' - габариты хотябы одного из товаров не соответствуют. '.
						$delivery_type['maxlength'].'x'.$delivery_type['maxwidth'].'x'.$delivery_type['maxheight'].' < '.$box['length'].'x'.$box['width'].'x'.$box['height'], 1);
						return false;
					}
				}
				
			}
			elseif( (int)$c_levels != 1 )
			{
				$this->addError('('.$key.') '.$service.' - габариты отправления не соответствуют. '.print_r($container, 1).' /// '.print_r($this->PRODUCT_BOXES, 1), 0);
				
				return false;
			}
		}
		
		if( $delivery_type['maxsum'] > 0 )
		{
			
			if( strstr($service, 'split_' ) )
			{
				foreach($this->PRODUCT_BOXES as $box)
				{
					$res_width = (float)$box["width"] + ( (float)$CURRENT_ORDER['final']['dop_width_cm'] / count($this->PRODUCTS) );
					$res_height = (float)$box["height"] + ( (float)$CURRENT_ORDER['final']['dop_height_cm'] / count($this->PRODUCTS) );
					$res_length = (float)$box["length"] + ( (float)$CURRENT_ORDER['final']['dop_length_cm'] / count($this->PRODUCTS) );
					
					if( $delivery_type['maxsum'] < (float)$box['width']+(float)$box['height']+(float)$box['length'] )
					{
						$this->addError('('.$key.') '.$service.' - сумма одной из коробок больше максимально-допустимой суммы тех сторон отправления. '.
						(float)$res_width.'+'.(float)$res_height.'+'.(float)$res_length.' > '. $delivery_type['maxsum'].' (из них adds: '.$CURRENT_ORDER['final']['dop_length_cm'].'x'.$CURRENT_ORDER['final']['dop_width_cm'].'x'.$CURRENT_ORDER['final']['dop_height_cm'].')', 0);
						
						return false;
					}
				}
			}
			else
			{
				$sumwidth = 0;
				$maxheight = 0;
				$maxlength = 0;
				
				foreach($this->PRODUCT_BOXES as $box)
				{
					$res_length = (float)$box["length"] + ( (float)$CURRENT_ORDER['final']['dop_length_cm'] / count($this->PRODUCTS) );
					$res_width = (float)$box["width"] + ( (float)$CURRENT_ORDER['final']['dop_width_cm'] / count($this->PRODUCTS) );
					$res_height = (float)$box["height"] + ( (float)$CURRENT_ORDER['final']['dop_height_cm'] / count($this->PRODUCTS) );
					
					list( $res_length, $res_height, $res_width ) = $this->getSizeValues($res_length, $res_width, $res_height);
					
					$sumwidth += $res_width;
					
					if( (float)$res_length > (float)$maxlength )
						$maxlength = $res_length;
					
					if( (float)$res_height > (float)$maxheight )
						$maxheight = $res_height;
				}
			
				if( $delivery_type['maxsum'] < $sumwidth+$maxheight+$maxlength )
				{
					$this->addError('('.$key.') '.$service.' - сумма сторон не соответствует. '.
					(float)$sumwidth.'+'.(float)$maxheight.'+'.(float)$maxlength.' > '. $delivery_type['maxsum'].' (из них adds: '.$CURRENT_ORDER['final']['dop_length_cm'].'x'.$CURRENT_ORDER['final']['dop_width_cm'].'x'.$CURRENT_ORDER['final']['dop_height_cm'].')', 0);
					
					return false;
				}
			}
		}
		
		if( $delivery_type['maxsumokrugl'] > 0 )
		{
			$sumwidth = 0;
			$maxheight = 0;
			$maxlength = 0;
			
			foreach($this->PRODUCTS as $product)
			{
				$res_length = $product["length_cm"] + ( $CURRENT_ORDER['final']['dop_length_cm'] / count($this->PRODUCTS) );
				$res_width = $product["width_cm"] + ( $CURRENT_ORDER['final']['dop_width_cm'] / count($this->PRODUCTS) );
				$res_height = $product["height_cm"] + ( $CURRENT_ORDER['final']['dop_height_cm'] / count($this->PRODUCTS) );
				
				list( $res_length, $res_height, $res_width ) = $this->getSizeValues($res_length, $res_width, $res_height);
				
				$sumwidth += $res_width;
				
				if( $res_length > $maxlength )
					$maxlength = $res_length;
				
				if( $res_height > $maxheight )
					$maxheight = $res_height;
			}
			
			if( $delivery_type['maxsumokrugl'] < $maxlength + ($maxheight*2) + ($maxlength*2) )
			{
				$this->addError('('.$key.') '.$service.' - maxsumokrugl не соответствует. ', 0);
				return false;
			}
			 
		}
		
		
		return true;
	}
	
	private function getCurrencies()
	{
		if( !empty( $this->currencies )  )
			return $this->currencies;
			
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "currency");
		
		$hash = array();
		
		foreach($query->rows as $row)
		{
			$hash[ $row['code'] ] = $row;
		}
		
		$this->currencies = $hash;
		return $hash;
	}
	protected function customConvert($sum, $from, $to, $type="")
	{
		$currencies = $this->getCurrencies();
		
		if( $from == $this->SYST['RUB'] && $to == $this->SYST['config_currency'] &&
			$to != $from && 
			isset($currencies[ $to ]) && isset($currencies[ $to ]['value']) &&
			isset($currencies[ $from ]) && isset($currencies[ $from ]['value']) &&
			$currencies[ $to ]['value'] != 1 && 
			$currencies[ $from ]['value'] == 1 )
		{
			$this->addError('Конвертация валют не выполнена', 0);
			return $sum;
		}
		
		return $this->currency->convert($sum, $from, $to);
	}
	
	private function getOrderWithAdds($service, $ORDER, $pack_key)
	{
		$ORDER['final'] = array(
            'dop_cost' 	   	   => 0,
            'dop_cost_rub' 	   => 0,
			
            'dop_delivery_perc' => 0,
            'set' => -1,
			'dop_weight_gramm' => 0,
			'dop_width_cm'	   => 0,
			'dop_height_cm'	   => 0,
			'dop_length_cm'	   => 0,
			'dop_length_cm'	   => 0,
			'sum_weight_gramm' => $ORDER['pre']['sum_weight_gramm'],
			'dop_srok'	   => 0,
			
			
			'total_without_shipping' => $ORDER['final']['total_without_shipping'],
			'total_without_shipping_rub' => $this->customConvert( $ORDER['final']['total_without_shipping'], $this->SYST['config_currency'], $this->SYST['RUB'] ),
		);
	
		$russianpost2_order_adds = $this->sortByKey( $this->config_get('russianpost2_order_adds') );
		
		if( !empty($russianpost2_order_adds) )
		{
			$counter = 0;
			
			foreach($russianpost2_order_adds as $adds)
			{
				if( empty($adds['status']) ) continue;
				$is_filter_noempty = 0;
				
				if( !empty($adds['filters']) )
				{
					$is_in = 0;
					
					foreach($adds['filters'] as $filter_id)
					{
						if( !empty($filter_id) )
						$is_filter_noempty = 1;
						
						if( in_array($filter_id, $ORDER['filters'] ) )
						{
							$is_in = 1;
						}
					}
						
					if( !$is_in ) 
					{
						continue;
					}
				}
				
				// ------
				if( !empty($adds['services']) && $service )
				{
					$is_in = 0;
					$is_noempty = 0;
						
					foreach($adds['services'] as $adds_service)
					{
						if( !empty($service) )
						$is_noempty = 1;
					
						if( $adds_service == $service )
						{
							$is_in = 1;
						}
					}
						
					if( !$is_in && $is_noempty ) 
					{
						continue;
					}
				}
				
				if( !empty($adds['filters']) )
				{
					$counter++;
				}
				
				if( $this->config_get('russianpost2_order_adds_type') != 'byfilter' 
					||
					(
						$this->config_get('russianpost2_order_adds_type') == 'byfilter' && 
						$is_filter_noempty == 0
					)
					||
					(
						$this->config_get('russianpost2_order_adds_type') == 'byfilter' && 
						$is_filter_noempty == 1 && $counter == 1
					)
				)
				{
					
					
					if( !empty($adds['srok']) )
					{
						$ORDER['final']['dop_srok'] += $adds['srok'];
					}
					
					if( !empty($adds['weight']) )
					{
						if( empty($adds['weighttype']) || $adds['weighttype'] == 'fix' )
						{
							$ORDER['final']['dop_weight_gramm'] += (float)$adds['weight'];
							$ORDER['final']['sum_weight_gramm'] += (float)$adds['weight'];
						}
						else // percent
						{
							$ORDER['final']['dop_weight_gramm'] += ceil((float)$adds['weight'] * $ORDER['pre']['sum_weight_gramm'] / 100);
							$ORDER['final']['sum_weight_gramm'] += ceil((float)$adds['weight'] * $ORDER['pre']['sum_weight_gramm'] / 100);
						}
					}
					
					list( $adds['length'], $adds['height'], $adds['width'] ) = $this->getSizeValues($adds['length'], $adds['width'], $adds['height']);
					
					if( !empty($adds['width']) )
					{
						$ORDER['final']['dop_width_cm'] += $adds['width'];
					}
					
					if( !empty($adds['height']) )
					{
						$ORDER['final']['dop_height_cm'] += $adds['height'];
					}
					
					if( !empty($adds['length']) ) 
					{
						$ORDER['final']['dop_length_cm'] += $adds['length'];
					}
					
					if( $adds['costtype'] == 'set' )
					{
						$ORDER['final']['set'] = (float)$adds['cost'];
					}
					
					if( !empty($adds['cost']) ) 
					{
						if( empty( $adds['costtype'] ) )
							$adds['costtype'] = 'fix';
						
						
						if( $adds['costtype'] == 'fix' )
						{
							$ORDER['final']['dop_cost'] += $adds['cost'];
						}
						elseif( $adds['costtype'] == 'fix2products' )
						{
							$ORDER['final']['dop_cost'] += $adds['cost'] * count( $this->PRODUCTS );
						}
						elseif( $adds['costtype'] == 'products_perc' )
						{
							$ORDER['final']['dop_cost'] += $adds['cost'] * $this->ORDER['final']['total_without_shipping'] / 100;
						}
						elseif( $adds['costtype'] == 'delivery_perc' )
						{
							$ORDER['final']['dop_delivery_perc'] = $adds['cost'];
						}
					}
				}
				
				// ------
				
				if( $this->config_get('russianpost2_order_adds_type') == 'one' )
				{
					break;
				}
			}
		}
		
		$ORDER['final']['sum_length_cm'] = $ORDER['pre']['sum_length_cm'] 	+ $ORDER['final']['dop_length_cm'];
		$ORDER['final']['max_width_cm']  = $ORDER['pre']['max_width_cm'] 	+ $ORDER['final']['dop_width_cm'];
		$ORDER['final']['max_height_cm'] = $ORDER['pre']['max_height_cm'] 	+ $ORDER['final']['dop_height_cm'];
		
		if( $ORDER['final']['dop_cost'] != 0 )
			$ORDER['final']['dop_cost_rub'] = $this->customConvert($ORDER['final']['dop_cost'], $this->SYST['config_currency'], $this->SYST['RUB'] );
		
		if( !empty( $this->PACKS[preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key] ) && 
			!empty( $this->PACKS[preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key]['dopweight'] ) )
		{
			$ORDER['final']['dop_weight_gramm'] += (float)$this->PACKS[preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key]['dopweight'];
			$ORDER['final']['sum_weight_gramm'] += (float)$this->PACKS[preg_match("/^\d+$/", $pack_key) ? $pack_key-1 : $pack_key]['dopweight'];
		}
		
		if( $ORDER['final']['sum_weight_gramm'] > 0 && $ORDER['final']['sum_weight_gramm'] < 1 )
			$ORDER['final']['sum_weight_gramm'] = 1;
			
			
		return $ORDER;
	}
	
	private function prepareOrderFilters( $ORDER = array())
	{
		$filters = array();
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_filters WHERE `type`='order' ORDER BY sort_order");
		
		foreach( $query->rows as $filter )
		{
			if( $this->isOrderComplianceFilter($filter, $ORDER) )
			{
				$filters[] = $filter['filter_id'];
			}
		}
		
		
		return $filters;
	}
	
	
	public function getRubCode()
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "currency 
		WHERE   code='RUB' OR 
				code='RUR' OR 
				TRIM(title)='Рубль' OR 
				TRIM(title)='Руб'   OR 
				TRIM(title)='руб.'  OR 
				TRIM(title)='rub.'  
		");
		
		if( empty($query->row['code']) )
		{
			$this->addError('Не определена валюта Рубль.', 1);
		}
		else
		{
			return $query->row['code'];
		}
	}
	
	
	private function getGrammId($is_array=0)
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "weight_class_description WHERE TRIM(unit)='g' OR TRIM(unit)='g.' OR TRIM(unit)='г' OR TRIM(unit)='г.' OR TRIM(unit)='грам' OR TRIM(unit)='грамм' OR TRIM(unit)='gramm' OR TRIM(unit)='gram' 
		OR
		TRIM(title)='g' OR TRIM(title)='g.' OR TRIM(title)='г' OR TRIM(title)='г.' OR TRIM(title)='грам' OR TRIM(title)='грамм' OR TRIM(title)='gramm' OR TRIM(title)='gram' 
		");
		
		if( !isset($query->row['weight_class_id']) )
		{
			$this->addError('Не определена единица веса Грамм.', 1);
		}
		else
		{
			if( $is_array )
			{
				$list = array();
				
				foreach($query->rows as $row)
				{
					$list[] = $row['weight_class_id'];
				}
				
				return $list;
			}
			else
			{
				return $query->row['weight_class_id'];
			}
		}
	}
	
	private function getCmId()
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "length_class_description WHERE TRIM(unit)='Centimeter' OR TRIM(unit)='Cm' OR TRIM(unit)='см' OR TRIM(unit)='см.' OR TRIM(unit)='cm.' OR TRIM(unit)='сантиметр'
		OR TRIM(title)='Centimeter' OR TRIM(title)='Cm' OR TRIM(title)='см' OR TRIM(title)='см.' OR TRIM(title)='cm.' OR TRIM(title)='сантиметр'
		");
		
		if( empty($query->row['length_class_id']) )
		{
			$this->addError('Не определена единица длины Сантиметр.', 1);
		}
		else
		{
			return $query->row['length_class_id'];
		}
	}
	
	public function getOkrugl($cost)
	{
		if( $this->config_get('russianpost2_okrugl') )
		{
			if( $this->config_get('russianpost2_okrugl') == 'round' )
				$cost = round($cost);
			elseif( $this->config_get('russianpost2_okrugl') == 'ceil' )
				$cost = ceil($cost);
			elseif( $this->config_get('russianpost2_okrugl') == 'floor' )
				$cost = floor($cost);
			elseif( $this->config_get('russianpost2_okrugl') == '10ceil' )
				$cost = ceil( $cost / 10 ) * 10;
		}
		
		return $cost;
	}
	
	public function getConfigCurrency()
	{
		if( !$this->config_get('config_store_id') ) return $this->config_get('config_currency');
		
		
		$query = $this->db_query("SELECT * FROM `" . DB_PREFIX . "setting` 
								   WHERE store_id= 0 
								   AND `key` = 'config_currency'
								   AND `".$this->getSettingField()."` = 'config'");
		
		return $query->row['value'];
	}
	
	private function getSettingField()
	{	
		$check_group = $this->db_query("SHOW COLUMNS FROM `".DB_PREFIX."setting` LIKE 'group'");
		
		if( !empty($check_group->rows) )
		{
			return 'group';
		}
		
		return 'code';
	}
	
	private function prepareSystemParams()
	{
		$this->SYST['RUB'] = $this->getRubCode();
		$this->SYST['GRAMM_ID'] = $this->getGrammId();
		$this->SYST['GRAMM_IDS'] = $this->getGrammId(1);
		$this->SYST['CM_ID'] = $this->getCmId();
		
		$this->SYST['config_currency'] = $this->getConfigCurrency();
	
		$this->customer_group_id = $this->customer->getCustomerGroupId();
		if( !$this->customer_group_id )
			$this->customer_group_id = $this->config_get('config_customer_group_id');
		 
	}
	
	private $sql_counter = 0;
	private function db_query($sql)
	{
		if( isset($this->SQL_CACHE[$sql]) )
		{
			return $this->SQL_CACHE[$sql];
		}
		
		$this->sql_counter++;
		
		#### $this->log->write("SQL (".$this->sql_counter."): ".$sql);
		
		$result = $this->db->query($sql);
		 
		if( 
			( strstr($sql, "SELECT ") && strstr($sql, "WHERE ") ) ||
			( strstr($sql, 'SHOW TABLES LIKE') ) ||
			( strstr($sql, 'DELETE FROM') )
			
		)
		{ 
			$this->SQL_CACHE[$sql] = $result;
		}
		
		return $result;
	}
	
	private function config_get($key)
	{
		return $this->config->get($key);
	}
	
	
	
	
	private function prepareConfigParams()
	{
		$this->CONFIG = $this->config_get('russianpost2_configs');
	}
	
	private function prepareProducts()
	{
		$is_all_products_have_null_size = 1;
		$this->ORDER['is_caution'] = 0;
		$this->ORDER['count_products'] = 0;
		$products = $this->cart->getProducts();
		
		if( empty($products) )
		{
			$this->addError('В корзине нет товаров', 1); 
		}
		
		foreach($products as $product)
		{
			$this->ORDER['count_products']++;
			
			$query_product = $this->db_query("SELECT * FROM 
					" . DB_PREFIX . "product 
				WHERE 
					product_id = '".(int)$product['product_id']."'")->row;
			
			
			$result = array(
				"weight_gramm"  => 0,
				"weight_kg" 	=> 0,
				"length_cm" 	=> 0,
				"width_cm" 		=> 0,
				"height_cm"		=> 0,
				"product_id" 	=> $product['product_id'],
				"name" 			=> $product['name'],
				"price" 		=> $product['price'], 
				"price_rub" 	=> $this->customConvert( $product['price'], 
									$this->SYST['config_currency'], 
									$this->SYST['RUB'] )
				,
				"is_nosumweight" 		=> 0,
				"is_nosumlength" 		=> 0,
			);
			
			
			
			if( 
				$this->config_get('russianpost2_weight_source') == 'cart'
				||
				( !isset($query_product['weight']) && !isset($query_product['weight_class_id']) )
			)
			{
				$query_product['weight'] = $product['weight'] / $product['quantity'];
				$query_product['weight_class_id'] = $product['weight_class_id'];
			}
			
			$result_products = array();
			
			if( $product['shipping'] ) 
			{
				// ----------
				
				$product['weight_gramm'] = $this->weight->convert($query_product['weight'], $query_product['weight_class_id'], $this->SYST['GRAMM_ID']);
				
				if( !empty($product['option']) )
				{
					foreach($product['option'] as $option)
					{
						if( !empty($option['weight']) && $option['weight'] != 0 )
						{
							$product['weight_gramm'] += (float)$this->weight->convert($option['weight'], $query_product['weight_class_id'], $this->SYST['GRAMM_ID']);
						}
					}
				}
				
				if( 
					$this->config_get('russianpost2_order_replace_weight') && 
					$this->config_get('russianpost2_order_default_weight')
				)
				{
					$product['weight_gramm'] = ( (float)$this->config_get('russianpost2_order_default_weight') / count($products) ) / $product['quantity'];
				}
				elseif(
					(
						(
							$product['weight_gramm'] == 0 && 
							$this->config_get('russianpost2_product_nullweight') == 'setdefault' 
						)
						||
						$this->config_get('russianpost2_product_replace_weight')
					)
					&& $this->config_get('russianpost2_product_default_weight') 
				)
				{
					$product['weight_gramm'] = $this->config_get('russianpost2_product_default_weight');
				}
				
				$product['weight_kg'] = $product['weight_gramm'] / 100;
				
				$product['length_cm'] = $this->length->convert($product['length'], $product['length_class_id'], $this->SYST['CM_ID']);
				
				$product['width_cm'] = $this->length->convert($product['width'], $product['length_class_id'], $this->SYST['CM_ID']);
				
				$product['height_cm'] = $this->length->convert($product['height'], $product['length_class_id'], $this->SYST['CM_ID']);
				
				if( 
					$this->config_get('russianpost2_order_replace_size') && 
					$this->config_get('russianpost2_order_default_length') && 
					$this->config_get('russianpost2_order_default_width') && 
					$this->config_get('russianpost2_order_default_height')
				)
				{
					$product['length_cm'] = ((float)$this->config_get('russianpost2_order_default_length') / count($products)) / $product['quantity'] ;
					$product['width_cm']  = ((float)$this->config_get('russianpost2_order_default_width') / count($products)) / $product['quantity'] ;
					$product['height_cm'] = ((float)$this->config_get('russianpost2_order_default_height') / count($products)) / $product['quantity'] ;
				}
				elseif( 
					(
						(
							$product['length_cm'] == 0 && 
							$product['width_cm'] == 0 && 
							$product['height_cm'] == 0 
						) 
						||
						$this->config_get('russianpost2_product_replace_size')
					)
					&& $this->config_get('russianpost2_product_nullsize') == 'setdefault' 
					
				)
				{
					$product['length_cm'] = $this->config_get('russianpost2_product_default_length')+0;
					$product['width_cm'] = $this->config_get('russianpost2_product_default_width')+0;
					$product['height_cm'] = $this->config_get('russianpost2_product_default_height')+0;
				}
				
				// -------
				if( 
					( $product['length_cm'] != 0 && ( $product['width_cm'] != 0 || $product['height_cm'] != 0 ) ) ||
					( $product['height_cm'] != 0 && ( $product['width_cm'] != 0 || $product['length_cm'] != 0 ) ) ||
					( $product['width_cm'] != 0 && ( $product['length_cm'] != 0 || $product['height_cm'] != 0 ) ) 
				)
					$is_all_products_have_null_size = 0;
				
				list( $dop_weight_gramm, $dop_length_cm, $dop_width_cm, $dop_height_cm, 
					$result['is_nosumweight'], $result['is_nosumlength']
					, $result['set_split'] ) = $this->getProductDops($product); 
				
				#if( $product['weight_gramm'] > 0 )
				#{
					$product['weight_gramm']  += $dop_weight_gramm;
				#}
				
				#if( $product['length_cm'] > 0 )
				#{
					$product['length_cm']  += $dop_length_cm;
				#}
				
				#if( $product['width_cm'] > 0 )
				#{
					$product['width_cm']  += $dop_width_cm;
				#}
				
				#if( $product['height_cm'] > 0 )
				#{
					$product['height_cm']  += $dop_height_cm;
				#}
				
				$result['weight_gramm'] = $product['weight_gramm'];
				$result['weight_kg'] = $result['weight_gramm'] / 1000;
				
				
				list($result['length_cm'], $result['height_cm'], $result['width_cm'] ) = $this->getSizeValues($product['length_cm'], $product['width_cm'], $product['height_cm']);
				
				
				$result['filters'] = $this->getProductFilters($product);
			}
			
			
			$this->PRODUCTS[] = $result;
			if( $product['quantity'] > 1 )
			{
				for($i=0; $i<$product['quantity']-1; $i++)
				{
					if( ($product['quantity'] - ($i+1)) < 1 )
					{
						$deli = ($product['quantity']-($i+1));
						
						$result['weight_gramm'] *= $deli;
						$result['weight_kg'] *= $deli;
						
						$result['length_cm'] *= $deli;
						$result['width_cm'] *= $deli;
						$result['height_cm'] *= $deli;
					}
					
					if( $result['is_nosumweight'] )
					{
						
						$result['weight_gramm'] = 0;
						$result['weight_kg'] = 0;
					}
						
					if( $result['is_nosumlength'] )
					{
						$result['length_cm'] = 0;
						$result['width_cm'] = 0;
						$result['height_cm'] = 0;
					}
					
					$this->PRODUCTS[] = $result;
				}
			}
			elseif( $product['quantity'] < 1 )
			{
				$this->PRODUCTS[ count($this->PRODUCTS)-1 ]['weight_gramm'] *= $product['quantity'];
				$this->PRODUCTS[ count($this->PRODUCTS)-1 ]['weight_kg'] *= $product['quantity'];
				
				$this->PRODUCTS[ count($this->PRODUCTS)-1 ]['length_cm'] *= $product['quantity'];
				$this->PRODUCTS[ count($this->PRODUCTS)-1 ]['width_cm'] *= $product['quantity'];
				$this->PRODUCTS[ count($this->PRODUCTS)-1 ]['height_cm'] *= $product['quantity']; 
			}
		}
		
		
		if( 
			$is_all_products_have_null_size && 
			$this->config_get('russianpost2_order_nullsize') == 'setnull' 
		)
		{
			$this->addError('Нулевой размер всех товаров в заказе', 1); 
		}
	}
	
	private function getProductFilters($product)
	{
		$filters = array();
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_filters WHERE `type`='product' ORDER BY sort_order");
		
		foreach($query->rows as $filter)
		{
			if( $this->isProductComplianceFilter($product, $filter) )
			{
				$filters[] = $filter['filter_id'];
			}
		}
		
		return $filters;
	}
	
	private function getProductDops($product)
	{
		$dop_weight_gramm = 0;
		$dop_length_cm 	= 0;
		$dop_width_cm 	= 0; 
		$dop_height_cm 	= 0;
		$is_caution = 0;
		$is_nosumweight = 0;
		$is_nosumlength = 0; 
		$is_set_split = 0;
		
		$query_product = $this->db_query("SELECT * FROM 
				" . DB_PREFIX . "product 
			WHERE 
				product_id = '".(int)$product['product_id']."'")->row;
					
		$product_weight_gramm = 0;
		
		if( in_array($query_product['weight_class_id'], $this->SYST['GRAMM_IDS']) )
		{
			$product_weight_gramm = $query_product['weight'];
		}
		else
		{
			$product_weight_gramm = $this->weight->convert(
				$query_product['weight'], $query_product['weight_class_id'], $this->SYST['GRAMM_ID']
			);
		}

		if( !empty($product['option']) )
		{
			foreach($product['option'] as $option)
			{
				if( !empty($option['weight']) && $option['weight'] != 0 )
				{
					$product_weight_gramm += (float)$this->weight->convert($option['weight'], $query_product['weight_class_id'], $this->SYST['GRAMM_ID']);
				}
			}
		}
		
		if( !empty($product['option']) )
		{
			foreach($product['option'] as $option)
			{
				if( !empty($option['weight']) && $option['weight'] != 0 )
				{
					$product_weight_gramm += (float)$this->weight->convert(
						$option['weight'],
						$query_product['weight_class_id'], 
						$this->SYST['GRAMM_ID']
					);
				}
			}
		}
		
		$russianpost2_product_adds = $this->sortByKey( $this->config_get('russianpost2_product_adds') );
		
		if( !empty($russianpost2_product_adds) ) 
		{
			$stopp = 0;
			foreach($russianpost2_product_adds as $adds)
			{
				if( $adds['caution'] || !empty($adds['nosumweight']) || !empty($adds['nosumlength']) || !empty($adds['set_split'])  )
				{
					if( empty( $adds['filters'] ) )
					{
						if( $adds['caution'] )
							$is_caution = 1;
						if( !empty($adds['nosumweight']) )
							$is_nosumweight = 1;
						if( !empty($adds['nosumlength']) )
							$is_nosumlength = 1;
						if( !empty($adds['set_split']) )
							$is_set_split = 1;
					}
					else
					{
						foreach($adds['filters'] as $filter_id)
						{ 
							if( $this->isProductComplianceFilter($product, $filter_id) )
							{
								if( $adds['caution'] )
									$is_caution = 1;
								if( !empty($adds['nosumweight']) )
									$is_nosumweight = 1;
								if( !empty($adds['nosumlength']) )
									$is_nosumlength = 1;
								if( !empty($adds['set_split']) )
									$is_set_split = 1;
							}
						}
					}
				} 
				
				if( $stopp ) continue;
				
				// -----------
				
				if( empty( $adds['filters'] ) )
				{
					if( $adds['weight'] ) {
						
						if( empty($adds['weighttype']) || $adds['weighttype'] == 'fix' )
						{
							$dop_weight_gramm += (float)$adds['weight'];
						}
						else // percent
						{
							$dop_weight_gramm += ceil( $product_weight_gramm * $adds['weight'] / 100 );
						}
					}
					if( $adds['length'] ) $dop_length_gramm += $adds['length'];
					if( $adds['width'] ) $dop_width_gramm += $adds['width'];
					if( $adds['height'] ) $dop_height_gramm += $adds['height'];
					
					if( $this->config_get('russianpost2_product_adds_type') == 'one' )
					{
						$stopp = 1;
					}
				}
				else
				{
					$stop = 0;
					foreach($adds['filters'] as $filter_id)
					{
						if( $stop == 0 && $this->isProductComplianceFilter($product, $filter_id) )
						{
							if( $adds['weight'] ) $dop_weight_gramm += $adds['weight'];
							if( $adds['length'] ) $dop_length_gramm += $adds['length'];
							if( $adds['width'] )  $dop_width_gramm 	+= $adds['width'];
							if( $adds['height'] ) $dop_height_gramm += $adds['height'];
							
							$stop = 1;
						}
					}
					
					if( $this->config_get('russianpost2_product_adds_type') != 'all' ) // one || byfillter
					{
						$stopp = 1;
					}
				}
			}
		}
		
		// -------
		
		if( $is_caution )
			$this->ORDER['is_caution'] = 1;
			
		return array(
			$dop_weight_gramm,
			$dop_length_cm,
			$dop_width_cm,
			$dop_height_cm
			, $is_nosumweight
			, $is_nosumlength
			, $is_set_split
		);
	}
	
	private function getDogovor( )
	{
		if( $this->config_get('russianpost2_clienttype') != 'corporate'  )
		{
			return false;
		}
		
		if( !$this->config_get('russianpost2_tariff_dogovor') || !$this->config_get('russianpost2_tariff_inn') )
		{
			return false;
		}
		
		if( empty($this->ORDER['from']['kladr'])  )
		{
			return false;
		}
		
		return $this->ORDER['from']['kladr'].'-'.$this->config_get('russianpost2_tariff_inn').'-'.$this->config_get('russianpost2_tariff_dogovor');
	}
	
	private function getRealServiceKey($service_key)
	{
		if( $service_key == 'free' || preg_match("/^[\d]+$/", $service_key) )
		{
			return $service_key;
		}
		
		$real_service_key = $service_key;
		
		$russianpost2_options = $this->config_get('russianpost2_options');
		
		if( !empty( $russianpost2_options[ $service_key ]['is_avia']['status'] ) 
			&&
			empty( $russianpost2_options[ $service_key ]['is_avia']['is_dedicated'] ) 
		)
		{
			$real_service_key .= '_avia';
		}
		
		if( !empty( $russianpost2_options[ $service_key ]['is_insured']['status'] ) 
			&&
			empty( $russianpost2_options[ $service_key ]['is_insured']['is_dedicated'] ) 
		)
		{
			$real_service_key .= '_insured';
		}
		elseif( 
			!empty( $russianpost2_options[ $service_key ]['is_registered']['status'] ) 
			&&
			empty( $russianpost2_options[ $service_key ]['is_registered']['is_dedicated'] ) 
		)
		{
			$real_service_key .= '_registered';
		}
		
		return $real_service_key;
	}
	
	private function isOrderComplianceFilter($filter, $CURRENT_ORDER = array())
	{
		if( !is_array($filter) )
		$filter = $this->getFilter( $filter );
		
		if( empty($filter) ) 
			return false;
		
		$data = unserialize($filter['data']);
		
		if( empty( $data['status'] ) ) return false;
		
		if( !empty( $data['customer_groups'] ) )
		{
			$is_in = 0;
			foreach($data['customer_groups'] as $customer_group_id)
			{
				if( $this->customer_group_id == $customer_group_id )
				{
					$is_in = 1;
				}
			}
			
			if( !$is_in )
			{
				return false;
			}
		}
		
		
		if( !empty( $data['productfilter'] ) )
		{
			$count = 0;
			foreach($this->PRODUCTS as $product)
			{
				if( !empty($product['filters']) )
				{
					 foreach($product['filters'] as $product_filter_id)
					 {
						 if( $product_filter_id == $data['productfilter'] )
						 {
							 $count++;
						 }
					 }
				}
			}
			
			if( $data['productfilter_type'] == 'one' && !$count ) 
				return false;
			
			if( $data['productfilter_type'] == 'except' && $count )  
				return false; 
			
			if( $data['productfilter_type'] == 'all' && $count != count($this->PRODUCTS) ) 
				return false;
		}
		
		
		if( !empty( $data['filter_regions']  ) )
		{
			$is_in = 0;
			
			foreach($data['filter_regions'] as $region )
			{
				$is_region = 0;
				$is_city = 0;
			
				if( $this->ORDER['to']['iso_code_2'] == 'RU' )
				{
					if( $region['ems_code'] == '' )
					{
						$is_region = 1;
					}
					elseif( strstr( $region['ems_code'], "geozone_" ) && 
						$this->isZoneInGeoZone($this->ORDER['to']['country_id'], 
											   isset($this->ORDER['to']['zone_id']) ? $this->ORDER['to']['zone_id'] : 0, 
						
						str_replace("geozone_", "", $region['ems_code']) )
					)
					{
						$is_region = 1;
					}
					elseif( $region['ems_code'] == $this->ORDER['to']['ems_code'] )
					{
						$is_region = 1;
					}
				}
				else
				{
					if( strstr( $region['ems_code'], "geozone_" ) && 
						$this->isZoneInGeoZone($this->ORDER['to']['country_id'], 
						
						isset($this->ORDER['to']['zone_id']) ? $this->ORDER['to']['zone_id'] : 0, 
						
						str_replace("geozone_", "", $region['ems_code']) )
					)
					{
						$is_region = 1;
					}
				}
				
				// -----
				
				if( empty($region['cities']) )
				{
					$is_city = 1;
				}
				else
				{
					$delimeter = ',';
					if( strstr($region['cities'], ";") )
						$delimeter = ';';
					
					$cities = explode($delimeter, $region['cities']);
					
					foreach($cities as $city)
					{
						$city = trim($city);
						
						if( $this->tolow($city) == $this->tolow($this->ORDER['to']['city']) )
						{
							$is_city = 1;
						}
					}
				}
				
				if( $is_city && $is_region )
				{
					$is_in = 1;
					break;
				}
				
			}
			
			
			if( !$is_in )
			{
				if( empty( $data['filter_regions_type'] ) || 
					$data['filter_regions_type'] == 'include_only' )
					return false;
			}
			else
			{
				if( !empty( $data['filter_regions_type'] ) && 
					$data['filter_regions_type'] == 'exclude' )
					return false;
			}
		}
		
		if( !empty( $data['price_from'] ) && (float)$this->ORDER['final']["total_without_shipping"] < (float)$data['price_from'] )
		{
			return false;
		}
		
		if( !empty( $data['price_to'] ) && (float)$this->ORDER['final']["total_without_shipping"] > (float)$data['price_to'] )
		{
			return false;
		} 
		
		$weight  = $this->ORDER['pre']['sum_weight_gramm'];
			
		if( $CURRENT_ORDER ) 
			$weight  = $CURRENT_ORDER['final']['sum_weight_gramm'];
				
		if( !empty( $data['weight_from'] ) && (float)$weight < (float)$data['weight_from'] )
		{
			return false;
		}
		
		if( !empty( $data['weight_to'] ) && (float)$weight > (float)$data['weight_to'] )
		{
			return false;
		} 
		
		// ---
		
		if( !empty( $data['count_items_from'] ) && count($this->PRODUCT_BOXES) < (float)$data['count_items_from'] )
		{
			return false;
		}
		
		if( !empty( $data['count_items_to'] ) && count($this->PRODUCT_BOXES) > (float)$data['count_items_to'] )
		{
			return false;
		}   
		
		// ---
		
		if( !empty( $data['count_products_from'] ) && $this->ORDER['count_products'] < (float)$data['count_products_from'] )
		{
			return false;
		}
		
		if( !empty( $data['count_products_to'] ) && $this->ORDER['count_products'] > (float)$data['count_products_to'] )
		{
			return false;
		}   
		   
		if( !empty( $data['length_to'] ) && !empty( $data['width_to'] ) && !empty( $data['height_to'] ) )
		{
			$container = array(
				"length" => $data['length_to'],
				"width" => $data['width_to'],
				"height" => $data['height_to']
			);
			
			foreach($this->PRODUCT_BOXES as $item)
			{
				list($width, $height, $length) = $this->getSizeValues($item['width'], $item['height'], $item['length']);
				list($container_width, $container_height, $container_length
				) = $this->getSizeValues($container['width'], $container['height'], $container['length']);
					
				if( $width > $container_width || $height > $container_height || $length > $container_length  )
				{
					return false;
				}
			}
			
			$c_levels = $this->combinateLAFF($container, $this->PRODUCT_BOXES); 
			
			if( $c_levels != 1 )
				return false;
		}
		
		if( !empty( $data['length_from'] ) && !empty( $data['length_from'] ) && !empty( $data['length_from'] ) )
		{
			$container = array(
				"length" => $data['length_from'],
				"width" => $data['length_from'],
				"height" => $data['length_from']
			);
			
			$c_levels = $this->combinateLAFF($container, $this->PRODUCT_BOXES); 
			
			if( $c_levels == 1 )
				return false;
		}
		
		return true;
	}
	
	private function isZoneInGeoZone($country_id, $zone_id, $geo_zone_id)
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id. "' AND country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')");
		
		if( $query->row ) return true;
		else return false;
	}
	
	
	public function getCountryData( $iso_code )
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_countries WHERE iso_code = '".$this->db->escape($iso_code)."'");
		
		$result = $this->makeDataHash('counties', $query->row['data']);
		
		$result['iso_code'] = $query->row['iso_code'];
		$result['country_name'] = $query->row['country_name'];
		
		return $result;
	}
	
	private function makeDataHash($key, $data_str, $config_data = array())
	{
		if( empty( $config_data ) )
		{
			$query = $this->db_query("SELECT * FROM  " . DB_PREFIX . "russianpost2_config 
			WHERE config_key = '".$this->db->escape($key)."'");
			
			$config_data = $query->row;
		}
		
		$keys = explode(":", $config_data['value']);
		$data = explode("|", $data_str);
		
		$result = array();
		
		foreach( $keys as $i=>$key )
		{
			$result[ $key ] = $data[ $i ];
		}
		
		return $result;
	}
	
	private function isProductComplianceFilter($product, $filter)
	{
		if( !is_array($filter) )
		$filter = $this->getFilter( $filter );
		
		if( empty($filter) ) 
			return false;
		
		$data = unserialize($filter['data']);
		
		if( empty( $data['status'] ) ) return false;
		
		
		if( !empty( $data['filter_category'] ) )
		{
			$wh_ar = array();
			foreach($data['filter_category'] as $category_id)
			{
				$wh_ar[] = (int)$category_id;
			}
			
			$sql = "SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id='".(int)$product['product_id']."' AND category_id IN (".implode(",", $wh_ar).") ";
			
			$query = $this->db_query($sql);
			
			if( empty($query->row ) ) 
				return false;
		}
		
		if( !empty( $data['filter_manufacturer'] ) )
		{
			$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "product 
			WHERE product_id='".(int)$product['product_id']."'");
			
			if( empty($query->row['manufacturer_id'] ) || 
				!in_array($query->row['manufacturer_id'], $data['filter_manufacturer']) ) 
			{
				return false;
			}
		}
		
		if( !empty( $data['filter_productname'] ) )
		{
			$where = '';
			
			if( $data['filter_productname_searchtype'] == 'sub' )
			{
				$where = " pd.name LIKE '%".$this->db->escape($data['filter_productname'])."%' ";
			}
			elseif( $data['filter_productname_searchtype'] == 'sub_noright' )
			{
				$where = " pd.name LIKE '".$this->db->escape($data['filter_productname'])."%' ";
			}
			elseif( $data['filter_productname_searchtype'] == 'sub_noleft' )
			{
				$where = " pd.name LIKE '%".$this->db->escape($data['filter_productname'])."' ";
			}
			else // strict
			{
				$where = " pd.name = '".$this->db->escape($data['filter_productname'])."' ";
			}
			
			
			$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "product p 
			JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
			WHERE p.product_id='".(int)$product['product_id']."' AND " . $where );
			
			if( !$query->row ) 
				return false;
		}
		
		if( !empty( $data['filter_productmodel'] ) )
		{
			$where = '';
			
			if( $data['filter_productmodel_searchtype'] == 'sub' )
			{
				$where = " p.model LIKE '%".$this->db->escape($data['filter_productmodel'])."%' ";
			}
			elseif( $data['filter_productmodel_searchtype'] == 'sub_noright' )
			{
				$where = " p.model LIKE '".$this->db->escape($data['filter_productmodel'])."%' ";
			}
			elseif( $data['filter_productmodel_searchtype'] == 'sub_noleft' )
			{
				$where = " p.model LIKE '%".$this->db->escape($data['filter_productmodel'])."' ";
			}
			else // strict
			{
				$where = " p.model = '".$this->db->escape($data['filter_productmodel'])."' ";
			}
			
			$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "product p 
			WHERE product_id='".(int)$product['product_id']."' AND " . $where );
			
			if( !$query->row ) 
				return false;
		}
		
		
		if( !empty( $data['price_from'] ) && (float)$product['price'] < (float)$data['price_from'] )
		{
			return false;
		}
		
		if( !empty( $data['price_to'] ) && (float)$product['price'] > (float)$data['price_to'] )
		{
			return false;
		} 
		
		if( !empty( $data['weight_from'] ) && (float)$product['weight_gramm'] < (float)$data['weight_from'] )
		{
			return false;
		}
		
		if( !empty( $data['weight_to'] ) && (float)$product['weight_gramm'] > (float)$data['weight_to'] )
		{
			return false;
		} 
		
		// ---
		
		if( !empty( $data['length_from'] ) && (float)$product['length_cm'] < (float)$data['length_from'] )
		{
			return false;
		}
		
		if( !empty( $data['length_to'] ) && (float)$product['length_cm'] > (float)$data['length_to'] )
		{
			return false;
		} 
		
		// ---
		
		if( !empty( $data['width_from'] ) && (float)$product['width_cm'] < (float)$data['width_from'] )
		{
			return false;
		}
		
		if( !empty( $data['width_to'] ) && (float)$product['width_cm'] > (float)$data['width_to'] )
		{
			return false;
		} 
		// ---
		
		if( !empty( $data['height_from'] ) && (float)$product['height_cm'] < (float)$data['height_from'] )
		{
			return false;
		}
		
		if( !empty( $data['height_to'] ) && (float)$product['height_cm'] > (float)$data['height_to'] )
		{
			return false;
		}  
		// ---
		
		if( !empty( $data['count_products_from'] ) && (float)$product['quantity'] < (float)$data['count_products_from'] )
		{
			return false;
		}
		
		if( !empty( $data['count_products_to'] ) && (float)$product['quantity'] > (float)$data['count_products_to'] )
		{
			return false;
		}   
		
		return true;
	}
	
	private function getFilter($filter_id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "russianpost2_filters` WHERE filter_id = '".(int)$filter_id."'";
		
		$query = $this->db_query($sql);
		
		return $query->row;
	}
	
	private function prepareOrder()
	{
		$this->ORDER["final"] = array(
				"total_without_shipping" => $this->getTotalSum(1)
		);
		
		if( $this->config_get('russianpost2_is_custom_calc_function') 
			&&
			file_exists(DIR_SYSTEM."helper/russianpost2.php")
		)
		{
			include_once(DIR_SYSTEM."helper/russianpost2.php");
			
			if( function_exists('russianpost2WeightCalc') )
			{
				$this->ORDER['pre'] = russianpost2WeightCalc($this->PRODUCTS, $this->registry);
			}
			
			if( !empty($this->ORDER['pre']) )
				return;
		}
		
		$sum_weight_gramm = 0;
		
		$max_weight_gramm = 0;
		$max_width_cm = 0;
		$max_height_cm = 0;
		$max_length_cm = 0;
		$sum_length_cm = 0;
		/*
			Array
			(
				[0] => Array
					(
						[weight_gramm] => 10000
						[weight_kg] => 10
						[length_cm] => 10
						[width_cm] => 10
						[height_cm] => 10
						[product_id] => 40
						[name] => iPhone
						[price] => 100
					)

			)
		*/
		
		$this->PRODUCT_BOXES = array();
		
		$sum_volume = 0;
		foreach( $this->PRODUCTS as $product )
		{
			if( $product['weight_gramm'] > $max_weight_gramm  )
			$max_weight_gramm = $product['weight_gramm'];
		
			
			list( $product['width_cm'], $product['height_cm'], $product['length_cm'] ) = $this->getSizeValues($product['width_cm'], $product['height_cm'], $product['length_cm']);
			
			if( (float)$product['width_cm'] > (float)$max_width_cm  )
			$max_width_cm = $product['width_cm'];
			
			if( (float)$product['height_cm'] > (float)$max_height_cm  )
			$max_height_cm = $product['height_cm'];
			
			if( (float)$product['length_cm'] > (float)$max_length_cm  )
			$max_length_cm = $product['length_cm'];
			
			$sum_weight_gramm += (float)$product['weight_gramm'];
			$sum_length_cm += (float)$product['length_cm'];
			
			
			$this->PRODUCT_BOXES[] = array(
				"length" => $product['length_cm'] == 0 ? 1 : $product['length_cm'],
				"width"  => $product['width_cm'] == 0 ? 1 : $product['width_cm'],
				"height" => $product['height_cm'] == 0 ? 1 : $product['height_cm'],
			);
		}
		
		// -------
		
		if(
			$this->config_get('russianpost2_order_default_weight') 
			&& 
			(
				(
					$sum_weight_gramm == 0 &&
					$this->config_get('russianpost2_order_nullweight') == 'setdefault' 
				)	
				||
				$this->config_get('russianpost2_order_replace_weight')
			)
			
		)
		{
			$sum_weight_gramm = $this->config_get('russianpost2_order_default_weight')+0;
		}
		
		if( $this->config_get('russianpost2_order_default_width') &&
			$this->config_get('russianpost2_order_default_length') &&
			$this->config_get('russianpost2_order_default_height') && 
			(
				(
					$max_width_cm == 0 && $max_height_cm == 0 && $max_length_cm == 0 
					&&  $this->config_get('russianpost2_order_nullweight') == 'setdefault' 
				)
				||
				$this->config_get('russianpost2_order_replace_size')
			)
		)
		{
			$max_width_cm  = $this->config_get('russianpost2_order_default_width')+0;
			$max_length_cm = $this->config_get('russianpost2_order_default_length')+0;
			$sum_length_cm = $this->config_get('russianpost2_order_default_length')+0;
			$max_height_cm = $this->config_get('russianpost2_order_default_height')+0;
			
			foreach($this->PRODUCT_BOXES as $i=>$val )
			{
				$this->PRODUCT_BOXES[$i]["length"] = $max_width_cm;
				$this->PRODUCT_BOXES[$i]["width"] = $max_length_cm;
				$this->PRODUCT_BOXES[$i]["height"] = $sum_length_cm / count($this->PRODUCT_BOXES);
				
			}
		}

		
		$volume_cm = ($sum_length_cm/100) * ($max_width_cm/100) * ($max_height_cm/100);
		
		
		### $c_levels = $this->combinateLAFF($container, $boxes);
		
		if( $sum_weight_gramm == 0 )
		{
			$this->addError('У товара нулевой вес', 1);
		}
		
		if( $this->config_get('russianpost2_use_max_product_weight') )
			$sum_weight_gramm = $max_weight_gramm;
		
		$this->ORDER['pre'] = array(
				"sum_weight_gramm"  => $sum_weight_gramm,
				"max_weight_gramm"  => $max_weight_gramm,
				"sum_length_cm" 	=> $sum_length_cm,
				"max_width_cm" 		=> $max_width_cm,
				"max_height_cm" 	=> $max_height_cm,
				"max_length_cm" 	=> $max_length_cm,
				"volume_cm" 		=> $volume_cm,
		);
		
	}
	
	public function getTotalSum($skip=0)
	{
		if(  version_compare(VERSION, '2.2.0.0') >= 0 )
		{
			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 
			$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
			);
			
				 
			$this->load->model('setting/extension');
				
			$sort_order = array(); 
				
			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				if( version_compare(VERSION, '3.0.0.0') >= 0  )
					$sort_order[$key] = $this->config_get("total_".$value['code'] . '_sort_order');
				else
					$sort_order[$key] = $this->config_get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config_get($result['code'] . '_status')) {
					
					if( version_compare(VERSION, '2.3.0.0') >= 0  )
					{
						$this->load->model('extension/total/' . $result['code']);
					}
					else
					{
						$this->load->model('total/' . $result['code']);
					}
					
					if( $skip && 
						(
							$result['code'] == 'rpcodonly2' ||
							$result['code'] == 'rpcodtotal2' ||
							$result['code'] == 'total' ||
							$result['code'] == 'shipping'
						)
					) continue;
					
					// We have to put the totals in an array so that they pass by reference.
					
					$voucher = '';
					if( $result['code'] == 'voucher' && !empty($this->session->data['voucher']) )
						$voucher = $this->session->data['voucher'];
					
					if( version_compare(VERSION, '2.3.0.0') >= 0  )
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					else
						$this->{'model_total_' . $result['code']}->getTotal($total_data);
					
					
					if( $result['code'] == 'voucher' && empty($this->session->data['voucher']) && 
						$voucher
					)
						$this->session->data['voucher'] = $voucher;
				}
			}
			
			return $total;
		}
		else
		{
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
				 
			$this->load->model('setting/extension');
				
			$sort_order = array(); 
				
			$results = $this->model_setting_extension->getExtensions('total');
					
			foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config_get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config_get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
			
					if( $skip && 
						(
							$result['code'] == 'rpcodonly2' ||
							$result['code'] == 'rpcodtotal2' ||
							$result['code'] == 'total' ||
							$result['code'] == 'shipping'
						)
					) continue;
					
					
					$voucher = '';
					if( $result['code'] == 'voucher' && !empty($this->session->data['voucher']) )
						$voucher = $this->session->data['voucher'];
					
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					
					
					if( $result['code'] == 'voucher' && empty($this->session->data['voucher']) && 
						$voucher
					)
						$this->session->data['voucher'] = $voucher;
				}
			}
			
			return $total;
		}
	}
	
	private function prepareOrderGeo($address)
	{
		$this->initClass();
		$ORDER = array();
		
		foreach($address as $key=>$val)
		{
			if( is_array($val) ) continue;
			$address[$key] = trim($val);
		}
		
		if( !isset($address['country_id']) ) $address['country_id'] = '';
		if( !isset($address['country']) ) $address['country'] = '';
		if( !isset($address['zone_id']) ) $address['zone_id'] = '';
		if( !isset($address['zone']) ) $address['zone'] = '';
		if( !isset($address['city']) ) $address['city'] = '';
		if( !isset($address['postcode']) ) $address['postcode'] = '';
		
		$address['postcode'] = preg_replace("/[^0-9]/", "", $address['postcode']);
		if( $address['postcode'] && !preg_match("/^[0-9]{6}$/", $address['postcode']) )
		{
			$this->addError('Несуществующий индекс: '.$address['postcode'], 0);
			$address['postcode'] = '';
		}
		
		
		if( $this->config_get('russianpost2_is_ignore_user_postcode') && 
			!empty($address['postcode'] ) )
		{
			if( $this->config_get('russianpost2_is_ignore_user_postcode') == 1 )
			{
				$address['postcode'] = '';
				$this->addError('Обнуляем почтовый индекс получателя', 0);
			}
			elseif( $this->config_get('russianpost2_is_ignore_user_postcode') == 2 &&
				!empty($address['zone_id'])
			)
			{
				$region = $this->getRegionByPostcode( $address['postcode'] );
				
				if( !empty($region['zone_id']) && $region['zone_id'] != $address['zone_id'] )
				{
					$address['postcode'] = '';
					$this->addError('Обнуляем почтовый индекс получателя (2)', 0);
				}
				
			}
		}
		
		// -------
		
		$russia = $this->RP2->getRussiaCountry();
		
		if( !$russia )
		{
			$this->addError('В списке стран магазина не определена Россия (то есть страна с кодом "RU")', 1);
		}
		
		$ru_country_id = isset( $russia['country_id'] ) ? $russia['country_id'] : '';
		
		$ORDER['from']['country_id'] = isset($russia['country_id']) ? (int)$russia['country_id'] : '';
		$ORDER['from']['country'] = isset($russia['name']) ? $russia['name'] : '';
		$ORDER['from']['iso_code_2'] = 'RU';
		$ORDER['from']['iso_code_3'] = 'RUS';
		
		$ORDER['SKLAD_FROM'] = array(
			"russianpost2_from_postcode" => trim( $this->config_get('russianpost2_from_postcode') ),
			"russianpost2_from_city" => trim( $this->config_get('russianpost2_from_city') ),
			"russianpost2_from_region" => trim( $this->config_get('russianpost2_from_region') ), 
		);
		
		$multistore_id = $this->getMultistoreId();
		
		if( $multistore_id )
		{
			$russianpost2_sklads = $this->config_get('russianpost2_sklads');
			
			foreach( $russianpost2_sklads as $sklad )
			{
				if( $sklad['multistore_id'] == $multistore_id )
				{
					$ORDER['SKLAD_FROM'] = array(
						"russianpost2_from_postcode" => trim( $sklad['postcode'] ),
						"russianpost2_from_city" => trim( $sklad['city'] ),
						"russianpost2_from_region" => trim( $sklad['region'] ), 
					);
				}
			}
		}
		
		if( !$ORDER['SKLAD_FROM']['russianpost2_from_region'] )
		{
			$this->addError('Не определен регион отправления (1)', 1);
		}
		
		$from_zone = $this->getZoneById( $ORDER['SKLAD_FROM']['russianpost2_from_region'] );
		
		if( empty( $from_zone ) )
		{
			$this->addError('Не определен регион отправления (2)', 1);
		}
		
		$ORDER['from']['zone'] 	= isset( $from_zone['name'] ) ? $from_zone['name'] : '';
		$ORDER['from']['zone_id'] = isset( $from_zone['zone_id'] ) ? $from_zone['zone_id'] : '';
		$ORDER['from']['ems_code'] = isset( $from_zone['ems_code'] ) ? $from_zone['ems_code'] : '';
		$ORDER['from']['ems_ems'] = isset( $from_zone['ems_ems'] ) ? $from_zone['ems_ems'] : '';
		
		$ORDER['from']['city'] = $this->getValidCity( trim( $ORDER['SKLAD_FROM']['russianpost2_from_city'] ));
		
		$ORDER['from']['kladr'] = '';
		
		if( !empty( $from_zone['data']) )
		{
			$data = $this->getDataTableRow('regions', $from_zone['data']);
			$ORDER['from']['kladr'] = !empty($data['kladr']) ? $data['kladr'] : '';
		}
		
		if( strstr($ORDER['SKLAD_FROM']['russianpost2_from_postcode'], ",") )
		{
			$ar = explode(",", $ORDER['SKLAD_FROM']['russianpost2_from_postcode']);
			$ORDER['from']['postcode'] = trim($ar[0]);
			
			for($i=1; $i<count($ar); $i++)
			{
				$ORDER['from']['postcode'.$i] = $ar[$i]; 
			}
		}
		else
		{
			$ORDER['from']['postcode'] = trim( $ORDER['SKLAD_FROM']['russianpost2_from_postcode'] );
		}
		
		$ORDER['from']['kladr'] = '';
		
		if( !empty( $from_zone['data']) )
		{
			$data = $this->getDataTableRow('regions', $from_zone['data']);
			$ORDER['from']['kladr'] = !empty($data['kladr']) ? $data['kladr'] : '';
		}
		
		if( strstr($this->config_get('russianpost2_from_postcode'), ",") )
		{
			$ar = explode(",", $this->config_get('russianpost2_from_postcode'));
			$ORDER['from']['postcode'] = trim($ar[0]);
			
			for($i=1; $i<count($ar); $i++)
			{
				$ORDER['from']['postcode'.$i] = $ar[$i]; 
			}
		}
		else
		{
			$ORDER['from']['postcode'] = trim( $this->config_get('russianpost2_from_postcode') );
		}
		
		if( empty($ORDER['from']['city']) )
		{
			$this->addError('Не определен город отправления', 1);
		}
		
		// =================
		
		if( empty($address['country_id']) && 
			$this->config_get('russianpost2_ifnocountry') == 'default' &&
			$ru_country_id
		)
		{
			$address['country_id'] = $ru_country_id;
		}
		elseif( empty($address['country_id']) )
		{
			$this->addError('Не определена страна доставки (1)', 1);
		}
		
		$to_country = $this->getCountryById($address['country_id']);
		
		if( empty($to_country) )
		{
			$this->addError('Не определена страна доставки (2)', 1);
		}
		
		$address['country_id'] = $to_country['country_id'];
		$ORDER['to']['country_id'] = $address['country_id'];
		$ORDER['to']['country'] = isset($to_country['name']) ? $to_country['name'] : '';
		$ORDER['to']['iso_code_2'] = isset($to_country['iso_code_2']) ? $to_country['iso_code_2'] : '';
		$ORDER['to']['iso_code_3'] = isset($to_country['iso_code_3']) ? $to_country['iso_code_3'] : '';
		
		$ORDER['to']['tariff_country_id'] = isset($to_country['tariff_country_id']) ? $to_country['tariff_country_id'] : '';
		$ORDER['to']['region_postcode'] = '';
		 
		// ----
		$ORDER['to']['city_postcode'] = '';
		$ORDER['to']['user_postcode'] = '';
		$ORDER['to']['region_id'] = '';
		$ORDER['to']['capital_postcode'] = '';
		$ORDER['to']['capital'] = '';
		
		if( $ORDER['to']['iso_code_2'] == 'RU' )
		{
			if( !empty($address['postcode']) && !preg_match("/^9/", $address['postcode']) )
			{ 
				if( empty($address['zone_id']) )
				{
					$region = $this->getRegionByPostcode( $address['postcode'] );
					
					if( $region )
					{
						$address['zone_id'] = $region['zone_id'];
					}
				}
				
				if( empty($address['city']) )
				{
					$address['city'] = $this->getCityByPostcode( $address['postcode'] ); 
				} 
			}
			
			if( 
				$this->config_get('russianpost2_printpost_api_status')
				&&
				( empty( $address['city'] ) || empty( $address['zone_id'] ) ) 
				&&
				!empty( $address['postcode'] )
			)
			{ 
				
				if( empty($address['city']) || empty($address['zone_id']) )
				{ 
					$page = '';
					$url = 'http://api.print-post.com/api/index/v2/?index='.$address['postcode'];
					
					$page = $this->getCurl($url);
					
					$ar = array();
					if( !empty($page) && preg_match("/\"city\":\"([^\"]+)\"/", $page) )
					{
						$json = json_decode($page, 1);
						
						if( !empty($json['city']) && empty($address['city']) )
						{					
							$address['city'] = $json['city'];
						}
					
						if( !empty($json['region']) ) 
						{	
							$to_zone = $this->detectZoneByKoren($json['region']);
							
							if( $to_zone && empty($address['zone_id']) )
							{
								$address['zone_id'] = $to_zone['zone_id'];
								$address['zone'] = $to_zone['name'];
								$to_zone['ems_code'] = $to_zone['ems_code'];
								$to_zone['ems_ems'] = $to_zone['ems_ems'];
							}
						}
					} 
				} 
			}
			
			if( empty($address['zone_id']) && !empty($address['postcode']) )
			{ 
				$region = $this->getRegionByPostcode( $address['postcode'] );
				
				if( !empty($region['zone_id']) )
				{
					$address['zone_id'] = $region['zone_id'];
				}
			}
			
			if( empty($address['zone_id']) && 
				$this->config_get('russianpost2_ifnoregion') == 'default'  &&
				$address['country_id'] == $ru_country_id
			)
			{
				$address['zone_id'] = $this->config_get('russianpost2_default_region');
			}
			
			if( empty( $address['city'] ) && 
				$this->config_get('russianpost2_ifnocity') == 'default'  &&
				$address['country_id'] == $ru_country_id
			)
			{
				$address['city'] = $this->config_get('russianpost2_default_city');
			}
			
			
			if( !empty($address['zone_id']) )
			{
				$zone_data = $this->getZoneById($address['zone_id']);
				
				if( $this->tolow($zone_data['capital']) == $this->tolow( trim($address['city']) ) )
					$ORDER['to']['region_postcode'] = $zone_data['capital_postcode'];
				elseif( $this->config_get('russianpost2_calc_by_region_for_remote') || 
						$this->isNoRemoteRegion($zone_data['ems_code'])
						||
						$this->is_cod )
					$ORDER['to']['region_postcode'] = $zone_data['region_postcode'];
				
				
				//$ORDER['to']['region_id'] = isset($zone_data['id']) ? $zone_data['id'] : '';
			}
			
			if( !empty($address['zone_id']) && !empty($address['city']) )
			{
				$ORDER['to']['city_postcode'] = $this->getPostcodeByCityRegionCode( 
					$address['zone_id'], $address['city']
				);
			}
			 
			
			if( !empty($address['postcode']) && !preg_match("/^9/", $address['postcode']) )
			{
				$ORDER['to']['user_postcode'] = $address['postcode'];
				if( empty($address['zone_id']) )
				{
					$region = $this->getRegionByPostcode( $address['postcode'] );
					
					if( $region )
					{
						$address['zone_id'] = $region['zone_id'];
					}
				}
				
				if( empty($address['city']) )
				{
					$address['city'] = $this->getCityByPostcode( $address['postcode'] ); 
				} 
			}
			else
			{
				if( !empty($address['zone_id']) && !empty($address['city']) 
					&& !empty($ORDER['to']['city_postcode'])
				)
				{
					$address['postcode'] = $ORDER['to']['city_postcode'];
				}
				
				if( !empty($address['zone_id']) && empty($address['postcode']) 
					&& !empty($ORDER['to']['region_postcode'])
				)
				{
					$address['postcode'] = $ORDER['to']['region_postcode'];
				}
			} 
			
			
			 
			if( empty($address['postcode']) && 
				!empty($address['city']) && !empty($address['zone_id']) )
			{
				$address['postcode'] = $this->getPostcodeByCityRegionCode(
						$address['zone_id'], $address['city']
				);
			} 
			
			$to_zone = $this->getZoneById( $address['zone_id'] );
			
			if( empty($to_zone) )
			{
				$address['zone_id'] = '';
			}
			else
			{
				$address['zone'] = $to_zone['name'];
			}
			
			$ORDER['to']['zone_id'] 	= $address['zone_id'];
			$ORDER['to']['zone'] 		= $address['zone'];  
			
			$ORDER['to']['ems_name'] 	= isset( $to_zone['name'] ) ? $to_zone['name'] : '';
			
			$ORDER['to']['ems_code'] = isset( $to_zone['ems_code'] ) ? $to_zone['ems_code'] : '';
			$ORDER['to']['ems_ems'] = isset( $to_zone['ems_ems'] ) ? $to_zone['ems_ems'] : '';
			if( !empty( $to_zone['capital'] ) )
			{
				$ORDER['to']['capital_postcode'] = $to_zone['capital_postcode']; 
				$ORDER['to']['capital'] = $to_zone['capital'];
			}
		}
		elseif( !empty($ORDER['to']['iso_code_2']) )
		{
			$ORDER['to']['ems_code'] = '';
			$ORDER['to']['ems_ems'] = '';
			
			$ORDER['to']['country_data'] = $this->getCountryData($ORDER['to']['iso_code_2']);
		}
		else
		{
			$ORDER['to']['iso_code_2'] = '';
		}
		
		if( empty($address['zone_id']) && $ORDER['to']['iso_code_2'] == 'RU' )
		{
			$this->addError('Не определен регион доставки', 1);
		}
		
		if( empty($address['city']) && $ORDER['to']['iso_code_2'] == 'RU' 
		)
		{
			if( $ORDER['to']['iso_code_2']=='RU'  )
			$this->addError('Не определен город доставки', 1);
		}
		
		
		$ORDER['to']['city'] 		= $this->getValidCity( $address['city'] );
		$ORDER['to']['postcode']  = $address['postcode'];
		
		
		if( $ORDER['to']['iso_code_2']=='RU' )
		{
			$ORDER['is_avia_only'] = $this->checkIsAviaOnly($ORDER['to']['ems_code'], $ORDER['to']['city'], $ORDER['to']['postcode']);
			$ORDER['is_capital'] = $this->checkIsCapital($ORDER['to']['ems_code'], $ORDER['to']['city']);
			
			if( !$this->checkIsAvailable($ORDER['from'], $ORDER['to']) )
			{
				$this->addError('Доставка в '.$ORDER['to']['city'].' запрещена в данный период', 1);
			}
			
			$ORDER['to']['is_remote'] = $this->checkIsRemote($ORDER['to']['ems_code'], $ORDER['to']['city'], $ORDER['to']['postcode']);
			
		}
		else
		{
			$ORDER['to']['is_remote'] = 0;
			$ORDER['is_avia_only'] = 0;
		}
		
		if( $ORDER['to']['iso_code_2']=='RU' )
		{
			if( !empty($ORDER['to']['zone_id'] ) )
			{
				$zone_data = $this->getZoneById($ORDER['to']['zone_id'] );
				$ORDER['to']['region_id'] = isset($zone_data['id']) ? $zone_data['id'] : '';
			}
			  
			
			$this->PVZ_LIST = $this->getPvzList(  
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city']
											);
			
			$this->OPS_ONLY_LIST = $this->getPvzList( 
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city'],
											  0,
											  'rupost'
											);
			
			$this->NOOPS_ONLY_LIST = $this->getPvzList(  
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city'],
											  0,
											  'noops'
											);  
											
			$this->PVZ_PAYMENT_LIST = $this->getPvzList(  
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city'],
											  1
											); 
			
			$this->OPS_ONLY_PAYMENT_LIST = $this->getPvzList(  
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city'],
											  1,
											  'rupost'
											); 							
			
			$this->NOOPS_ONLY_PAYMENT_LIST = $this->getPvzList( 
											  $ORDER['to']['region_id'], 
											  $ORDER['to']['city'],
											  1,
											  'noops'
											); 
					
		}	
 
		return $ORDER;
	}
	
	private function isPvzIn($list, $postcode)
	{
		foreach($list as $item)
		{
			if( trim($item['postcode']) == trim($postcode) )
				return true;
		}
		
		return false;
	}
	protected $aviaOnlyRegions = array(
		"region--magadanskaja-oblast" => 1,
		"region--kamchatskij-kraj" => 1,
		"region--sahalinskaja-oblast" => 1,
		"region--respublika-saha-yakutija" => 1,
		"region--neneckij-ao" => 1,
		"region--chukotskij-ao" => 1,
		"region--yamalo-neneckij-ao" => 1,
	);
	
	private function checkIsAviaOnly($ems_code, $city, $postcode)
	{
		if( !empty( $this->aviaOnlyRegions[$ems_code] ) )
		{
			return 1;
		}
		
		$where = '';
		
		if( $postcode )
		{
			$where = " postcode = '".(int)$postcode."' ";
		}
		else
		{
			$where = " ems_code = '".$this->db->escape($ems_code)."' AND city = '".$this->db->escape($city)."' ";
		}
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_remote WHERE ".$where." AND limit_type LIKE '%Авиа%'");
		
		$cur_date = date("nd");
		
		foreach($query->rows as $row)
		{
			$row['start'] = $this->prepareDate($row['start']);
			$row['end'] = $this->prepareDate($row['end']);
			
			if( !$row['start'] || !$row['end'] ) continue;
			
			// ---------
			
			if( $cur_date >= $row['start'] && $cur_date <= $row['end'] )
			{
				return 1;				
			}
		}
		
		return 0;
	}
	
	private function checkIsAvailable($from, $to)
	{
		$where = '';
		
		if( $to['postcode'] )
		{
			$where = " postcode = '".(int)$to['postcode']."' ";
		}
		else
		{
			$where = " ems_code = '".$this->db->escape($to['ems_code'])."' AND city = '".$this->db->escape($to['city'])."' ";
		}
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_remote WHERE ".$where." AND limit_type='Запрещена'");
		
		if( empty($query->row) )
		{
			return 1;
		}
		
		$postcalc_data = $this->requestPostcalcData(
											 'parcel',
											 1000, 
											 10, 
											 10, 
											 10, 
											 1000, 
											 $from, 
											 $to,
											 0
									);
		
		if( !empty( $postcalc_data['Отправления']['ЦеннаяПосылка']['НетРасчета'] ) )
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}
	
	
	private function prepareDate($raw_date)
	{
		if( !$raw_date ) return false;
		if( !strstr($raw_date, '.') ) return false;
		
		$ar = explode(".", $raw_date);
		$d = $ar[0]+0;
		$m = $ar[1]+0;
			
		if(strlen($d) == 1) 
		$d = '0'.$d;
			
		return $m.$d;
	}
	
	public function addPostcodeIfItNeeded($postcode, $zone_id, $city, $data)
	{
		$check_query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_indexes WHERE postcode = '".$this->db->escape($postcode)."'");
		 
		if( $check_query->row )
			return;
		
		
		$region_query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_regions WHERE id_oc = '".(int)$zone_id."'"); 
		
		if( !$region_query->row )
			return;
		
		$address = $region_query->row['ems_name'].', '.$city.', '.$data['addressTo'];
		//г. Москва, Москва, Мясницкая ул, дом 26А
		
		$sql = "INSERT INTO " . DB_PREFIX . "russianpost2_indexes SET 
			region_id = '".(int)$region_query->row['id']."',
			postcode = '".$this->db->escape($postcode)."',
			address = '".$this->db->escape($address)."',
			city = '".$this->db->escape($city)."',
			lat = '-1',
			lon = '-1',
			is_online_parcel = 1
		";
		$this->db_query($sql); 
	}
	
	private function checkIsRemote($ems_code, $city, $postcode)
	{
		if( $postcode )
		{
			$where = " postcode = '".(int)$postcode."' ";
		}
		else
		{
			$where = " ems_code = '".$this->db->escape($ems_code)."' AND city = '".$this->db->escape($city)."' ";
		}
		
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "russianpost2_remote WHERE ".$where);
		if( $query->row ){ 
			
			if( $query->rows )
			{
				foreach($query->rows as $row)
				{
					if($row['start'] && $row['end'])
					{
						list($start_d, $start_m) = explode(".", $row['start']);
						list($end_d, $end_m)  = explode(".", $row['end']);
						
						if( $start_d < 10 ) $start_d = '0'.$start_d;
						if( $end_d < 10 ) $end_d = '0'.$end_d;
						
						$start = $start_m.$start_d;
						$end   = $end_m.$end_d;
						
						$cur = date("md");
						
						$start += 0;
						$end += 0;
						$cur += 0;
						
						if(  $cur < $start || $cur > $end )
							continue;
					}
						
					return 1;
				}
				
				return 0;
			}
			
		}
		else return 0;
	}
	
	private function getEmsCodeByZoneId($zone_id)
	{
		$russianpost2_regions2zones = $this->config_get('russianpost2_regions2zones');
			
		foreach( $russianpost2_regions2zones as $ems_code=> $zones)
		{
			if( !empty($zones) )
			{
				foreach($zones as $zzone_id)
				{
					if( $zone_id == $zzone_id)
					{
						return str_replace('__', ".", $ems_code);
					}
				}
			}
		}
	}
	
	public function setTerminal()
	{
		$code = $this->request->post['code'];
		$title = $this->request->post['title'];
		$cost = $this->request->post['cost'];
		$text = $this->request->post['text'];
		$type = isset($this->request->post['type']) ? $this->request->post['type'] : 'pvz';
		$city = isset( $this->request->post['city'] ) ? $this->request->post['city'] : '';
		
		if( empty($code) ) exit("ERROR-1");
		
		$listtype = isset($this->request->post['listtype']) ? $this->request->post['listtype'] : 'OPS_ONLY_LIST';
		 
		if( preg_match("/^9/", $this->request->post['delivery_point_index']) && preg_match("/^OPS/", $listtype))
		{
			$listtype = preg_replace("/^OPS/", "NOOPS", $listtype);
		}
		elseif( !preg_match("/^9/", $this->request->post['delivery_point_index']) && preg_match("/^NOOPS/", $listtype))
		{
			$listtype = preg_replace("/^NOOPS/", "OPS", $listtype);
		}
		
		 
		if( !isset($this->session->data['rp_selected_pvz']) )
			$this->session->data['rp_selected_pvz'] = array();
		
		$this->session->data['rp_selected_pvz'][$listtype] = $this->request->post['delivery_point_index'];
		
		setcookie('rp_selected_pvz___'.$listtype, $this->request->post['delivery_point_index'], time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
		
		$this->session->data['rp_last_selected_postcode'] = $this->request->post['delivery_point_index'];
		
		$code_ar = explode("_", $code);
		$title =  html_entity_decode($title, ENT_QUOTES, 'UTF-8');

		if( !empty($this->session->data['shipping_address']['postcode']) )
			$this->session->data['shipping_address']['postcode'] = $this->request->post['delivery_point_index'];
		
		if( !empty($this->session->data['payment_address']['postcode']) )
			$this->session->data['payment_address']['postcode'] = $this->request->post['delivery_point_index'];
		
		if( !empty($this->session->data['simple']) )
		{
			if( !empty($this->session->data['simple']['shipping_address']['postcode']) )
				$this->session->data['simple']['shipping_address']['postcode'] = $this->request->post['delivery_point_index'];
		
			if( !empty($this->session->data['simple']['payment_address']['postcode']) )
				$this->session->data['simple']['payment_address']['postcode'] = $this->request->post['delivery_point_index'];
		}
		
		
		$code = $code_ar[0].'.'.$code_ar[1];
		
		$new_zone_id = '';
		$new_city = ''; 
		
		if( !empty( $this->request->post['regionTo'] ) && isset($this->session->data['shipping_address']['zone_id']) )
		{ 
			$new_zone = $this->getZoneByWidgetRegion(
				$this->request->post['regionTo']
			); 
			
			if( $new_zone['zone_id'] != $this->session->data['shipping_address']['zone_id']
				||
				(
					!empty( $this->request->post['cityTo'] ) && 
					!empty( $this->session->data['shipping_address']['city'] ) && 
					$this->preparedCity( $this->request->post['cityTo'] ) != $this->session->data['shipping_address']['city']
				)
			)
			{
				$shipping_address = $this->session->data['shipping_address'];
				$shipping_address['postcode'] = $this->request->post['delivery_point_index'];
				$shipping_address['city'] = $this->preparedCity( $this->request->post['cityTo'] );
				$shipping_address['zone_id'] = $new_zone['zone_id']; 
				$shipping_address['zone'] = $new_zone['name']; 
						
				$new_zone_id = $new_zone['zone_id'];
				$new_city = $shipping_address['city']; 
				
				$quote = $this->getQuote(
					$shipping_address
				);
				
				$this->session->data['shipping_address'] = $shipping_address;
				
				$this->session->data['shipping_methods'][$code_ar[0]]['quote'] = $quote;
				
				foreach($quote as $code2 => $quot)
				{
					if( $code2 == $code_ar[1] )
					{
						$cost = $quot['cost'];
						$text = $quot['text'];
					}
				}
			}
			$this->addPostcodeIfItNeeded(
				$this->request->post['delivery_point_index'],
				$new_zone['zone_id'],
				$this->preparedCity( $this->request->post['cityTo'] ),
				$this->request->post
			);
		}
		$this->session->data['shipping_method']['code'] = $code;
		$this->session->data['shipping_method']['title'] = $title;
		if( $cost ) 
		{
			$this->session->data['shipping_method']['cost'] = $cost;
			$this->session->data['shipping_method']['text'] = $text;
		}
		$this->session->data['shipping_method']['tax_class_id'] = false;
		
		$this->session->data['shipping_methods'][$code_ar[0]]['quote'][ $code_ar[1] ]['title'] = $title;
		if( $cost ) 
		{
			$this->session->data['shipping_methods'][$code_ar[0]]['quote'][ $code_ar[1] ]['cost'] = $cost;
			$this->session->data['shipping_methods'][$code_ar[0]]['quote'][ $code_ar[1] ]['text'] = $text;
		}
		$this->session->data['shipping_methods'][$code_ar[0]]['quote'][ $code_ar[1] ]['tax_class_id'] = false; 
		
		$is_simple = !empty($this->session->data['simple']) ? 1 : 0;
		
		if( $is_simple )
		{
			if( !empty($this->session->data['simple']['shipping_address']['address_1']) && 
				!strstr($this->session->data['simple']['shipping_address']['address_1'], $this->pre_text1) 
			)
				$this->session->data['russianpost2_data']['old_address_1'] = $this->session->data['simple']['shipping_address']['address_1'];
				
			if( !empty($this->session->data['simple']['shipping_address']['address_2']) && 
				!strstr($this->session->data['simple']['shipping_address']['address_2'], $this->pre_text1) 
			)
				$this->session->data['russianpost2_data']['old_address_2'] = $this->session->data['simple']['shipping_address']['address_2'];
						
		}
		else
		{
			if(
				!empty($this->session->data['shipping_address']['address_1']) && 
				!strstr($this->session->data['shipping_address']['address_1'], $this->pre_text1) 
			)
				$this->session->data['russianpost2_data']['old_address_1'] = $this->session->data['shipping_address']['address_1'];
			
			if(
				!empty($this->session->data['shipping_address']['address_2']) && 
				!strstr($this->session->data['shipping_address']['address_2'], $this->pre_text1) 
			)
				$this->session->data['russianpost2_data']['old_address_2'] = $this->session->data['shipping_address']['address_2'];
		}
		
		$pvz = $this->getPvzByCode($this->request->post['delivery_point_index']);
		
		$rp_opsinfo = '';
		
		if( $this->request->post['delivery_point_index'] && $pvz)  
		{ 
			$rp_opsinfo = strip_tags(html_entity_decode($this->formatData( 	
					'russianpost2_tag_ops_block', 
					array(
						'ops_address'  => $pvz['address'],
						'postcode'   => $pvz['postcode'],
						'ops_worktime' => $this->getWorkTime( $pvz['wtime'] )
					)
			), ENT_QUOTES, 'UTF-8'), "<span>");
		} 
		
		$json = array(
			"status" => 'OK',
			"address_1" => '',
			"address_2" => '',
			"new_zone_id" => $new_zone_id,
			"new_city" => $new_city,
			"city" => $this->preparedCity( $city ),
			"new_postcode" => $this->request->post['delivery_point_index']  ,
			"rp_opsinfo" => $rp_opsinfo
		);
		
		if( $this->config->get('russianpost2_pvz_address_set') && $pvz && 
			preg_match("/^9/", $this->request->post['delivery_point_index'])
		)
		{
			$text_infield = $this->pre_text1.strip_tags(html_entity_decode($this->formatData( 
				'russianpost2_pvz_address_infield', 
				array(
					'ops_address'  => $this->request->post['address'],
					'postcode'   => $pvz['postcode']
				)
			), ENT_QUOTES, 'UTF-8'), "<span>");
			
			if( $this->config->get('russianpost2_pvz_address_set') == 'address_1' )
			{
				$json['address_1'] = $text_infield;
				if( isset( $this->session->data['shipping_address']['address_1'] ) ) 
					$this->session->data['shipping_address']['address_1'] = $text_infield;
				if( $is_simple )
				{
					if( isset( $this->session->data['simple']['payment_address']['address_1'] ) ) 
						$this->session->data['simple']['payment_address']['address_1'] = $text_infield;
					if( isset( $this->session->data['simple']['shipping_address']['address_1'] ) ) 
						$this->session->data['simple']['shipping_address']['address_1'] = $text_infield;
				}
				if( isset( $this->session->data['payment_address']['address_1'] ) ) 
					$this->session->data['payment_address']['address_1'] = $text_infield;
				

			}
			elseif( $this->config->get('russianpost2_pvz_address_set') == 'address_2' )
			{
				$json['address_2'] = $text_infield;
				if( isset( $this->session->data['shipping_address']['address_2'] ) ) 
					$this->session->data['shipping_address']['address_2'] = $text_infield;
				if( $is_simple )
				{
					if( isset( $this->session->data['simple']['payment_address']['address_2'] ) ) 
						$this->session->data['simple']['payment_address']['address_2'] = $text_infield;
					if( isset( $this->session->data['simple']['shipping_address']['address_2'] ) ) 
						$this->session->data['simple']['shipping_address']['address_2'] = $text_infield;
				}
				if( isset( $this->session->data['payment_address']['address_2'] ) ) 
					$this->session->data['payment_address']['address_2'] = $text_infield;
				

			}
		}
		else if( $this->config->get('russianpost2_ops_address_set') && $pvz && 
			!preg_match("/^9/", $this->request->post['delivery_point_index'])
		)
		{
			$text_infield = $this->pre_text1.strip_tags(html_entity_decode($this->formatData( 
				'russianpost2_pvz_address_infield', 
				array(
					'ops_address'  => $this->request->post['address'],
					'postcode'   => $pvz['postcode']
				)
			), ENT_QUOTES, 'UTF-8'), "<span>");
			
			if( $this->config->get('russianpost2_ops_address_set') == 'address_1' )
			{
				$json['address_1'] = $text_infield;
				if( isset( $this->session->data['shipping_address']['address_1'] ) ) 
					$this->session->data['shipping_address']['address_1'] = $text_infield;
				if( $is_simple )
				{
					if( isset( $this->session->data['simple']['payment_address']['address_1'] ) ) 
						$this->session->data['simple']['payment_address']['address_1'] = $text_infield;
					if( isset( $this->session->data['simple']['shipping_address']['address_1'] ) ) 
						$this->session->data['simple']['shipping_address']['address_1'] = $text_infield;
				}

				if( isset( $this->session->data['payment_address']['address_1'] ) ) 
					$this->session->data['payment_address']['address_1'] = $text_infield;
				
			}
			elseif( $this->config->get('russianpost2_ops_address_set') == 'address_2' )
			{
				$json['address_2'] = $text_infield;
				if( isset( $this->session->data['shipping_address']['address_2'] ) ) 
					$this->session->data['shipping_address']['address_2'] = $text_infield;
				if( $is_simple )
				{
					if( isset( $this->session->data['simple']['payment_address']['address_2'] ) ) 
						$this->session->data['simple']['payment_address']['address_2'] = $text_infield;
					if( isset( $this->session->data['simple']['shipping_address']['address_2'] ) ) 
						$this->session->data['simple']['shipping_address']['address_2'] = $text_infield;
				}
				if( isset( $this->session->data['payment_address']['address_2'] ) ) 
					$this->session->data['payment_address']['address_2'] = $text_infield;
				

			} 
		}
		
		exit( json_encode($json) );
	}
	
	
	
	private function preparedCity($city)
	{
		$city = trim($city);
		
		if( !strstr($city, " ") )
			return $city;
		
		$city_ar = explode(" ", $city);
		
		if( $city_ar[0] == 'г' )
			unset($city_ar[0]); 
		
		return implode(" ", $city_ar);
	}
	private function getZoneById($zone_id)
	{
		if( $this->config_get('russianpost2_regions2zones') )
		{
			if( $ems_code = $this->getEmsCodeByZoneId($zone_id) )
			{
				$sql = "SELECT rr.*
						FROM " . DB_PREFIX . "russianpost2_regions rr 
						WHERE rr.ems_code = '".$this->db->escape($ems_code)."'";
							
				$query = $this->db_query($sql);
							
				$sql = "SELECT *
						FROM " . DB_PREFIX . "zone 
						WHERE zone_id = '".(int)$zone_id."'";
							
				$query2 = $this->db_query($sql);
							
				$query->row['name'] = $query2->row['name'];
				$query->row['zone_id'] = $zone_id;
				
				$data = $this->getDataTableRow('regions', $query->row['data']);
				
				$query->row['region_postcode'] = $data['region_postcode'];
				$query->row['capital_postcode'] = $data['capital_postcode'];
				
				return $query->row;
			}
		}
		
		$sql = "SELECT rr.*, z.name as name, z.zone_id as zone_id 
				FROM " . DB_PREFIX . "russianpost2_regions rr 
								   JOIN 
									" . DB_PREFIX . "zone z
								   ON
									rr.id_oc = z.zone_id
									WHERE z.zone_id = '".(int)$zone_id."'";
		
		$query = $this->db_query($sql);
		
		if( empty($query->row['data']) ) return false;
		
		$data = $this->getDataTableRow('regions', $query->row['data']);
		
		$query->row['region_postcode'] = $data['region_postcode'];
		$query->row['capital_postcode'] = $data['capital_postcode'];
		
		return $query->row;
	}
	
	
	private function checkIsCapital($ems_code, $city)
	{
		$sql = "SELECT rr.*
				FROM " . DB_PREFIX . "russianpost2_regions rr 
				WHERE ems_code = '".$this->db->escape($ems_code)."' 
				AND `capital` = '".$this->db->escape($city)."'";
							
		$query = $this->db_query($sql);
		
		if( $query->row )
			return 1;
		else
			return 0;
	}
	
	private function detectZoneByKoren($region)
	{
		$query = $this->db_query("SELECT *, z.name as name, z.zone_id as zone_id 
								   FROM " . DB_PREFIX . "russianpost2_regions rr 
								   JOIN 
									" . DB_PREFIX . "zone z
								   ON
									rr.id_oc = z.zone_id
		");
		
		foreach( $query->rows as $row)
		{
			$korens = $this->tolow($row['korens']);
			
			$ar = explode(":", $korens); 
			
			$minus_list = array();
			
			foreach($ar as $koren)
			{
				if( preg_match("/^\-/", $koren) )
				{
					$koren = preg_replace("/^\-/", "", $koren);
					$minus_list[] = $this->tolow($koren);
				}
			}
			
			foreach($ar as $koren)
			{	
				$stop = 0;
				foreach($minus_list as $kor)
				{
					if( strstr($this->tolow($region), $kor) )
					{
						$stop = 1;
					}
				}
			
				if( strstr($this->tolow($region), $koren) && !$stop )
				{
					return $row;
				}
			}
		}
		
		return array();
	}
	
	private function getConfigData($country_id)
	{
		$sql ="SELECT c.* FROM `" . DB_PREFIX . "country` c 
		LEFT JOIN `" . DB_PREFIX . "russianpost2_countries` rc
		ON rc.iso_code = c.iso_code_2
		WHERE country_id='".(int)$country_id."' AND (
			c.iso_code_2 = 'RU' OR rc.iso_code IS NOT NULL
		)";
		
		$query = $this->db_query($sql);
		
		return $query->row;
	}
	
	
	private function getDataTableRow($config_key, $data_str)
	{
		$keys = array();
		if( !empty($this->CONFIG_KEYS[ trim($config_key) ]['value'] ) )
		{
			$keys = explode(":", $this->CONFIG_KEYS[ $config_key ]['value'] );
		} 
		
		$ar = explode("|", $data_str);
		$data = array();
		for( $i=0; $i<count($ar); $i++ )
		{
			$data[ $keys[$i] ] = $ar[ $i ];
		}
		
		return $data;
	}
	
	private function getCountryById($country_id)
	{
		if( $this->config_get('russianpost2_countries_list') )
		{
			$sql ="SELECT * FROM `" . DB_PREFIX . "country` 
			WHERE country_id='".(int)$country_id."'";
			$query = $this->db_query($sql);

			if( empty($query->row) ) return false;

			if( $query->row['iso_code_2'] == 'RU' )
				return $query->row;

			$russianpost2_countries_list = $this->config_get('russianpost2_countries_list');
			if( empty($russianpost2_countries_list[$country_id]) )
				return false;

			
		
			$sql ="SELECT * FROM `" . DB_PREFIX . "russianpost2_countries` 
			WHERE id='".(int)$russianpost2_countries_list[$country_id]."'";
			
			$query2 = $this->db_query($sql);
			$data = $this->getDataTableRow('counties', $query2->row['data']);
			
			// ----
			$sql ="SELECT * FROM `" . DB_PREFIX . "country` 
			WHERE iso_code_2='".$this->db->escape($query2->row['iso_code'])."'";
			
			$query3 = $this->db_query($sql);
			if( $query3->row )
			{ 
				$query3->row['name'] = $query->row['name'];
				$query3->row["tariff_country_id"] = isset( $data['tariff_country_id'] ) ? $data['tariff_country_id'] : '';
				
				return $query3->row;
			} 
			
			return array(
				"country_id" => $country_id,
				"iso_code_2" => $query2->row['iso_code'],
				"iso_code_3" => $query->row['iso_code_3'],
				"name" => $query->row['name'],
				"tariff_country_id" => isset( $data['tariff_country_id'] ) ? $data['tariff_country_id'] : ''
				
			);
		}
		else
		{
			$sql ="SELECT c.*, rc.data FROM `" . DB_PREFIX . "country` c 
			LEFT JOIN `" . DB_PREFIX . "russianpost2_countries` rc
			ON rc.iso_code = c.iso_code_2
			WHERE country_id='".(int)$country_id."' AND (
				c.iso_code_2 = 'RU' OR rc.iso_code IS NOT NULL
			)";
			
			$query = $this->db_query($sql);
			
			$data = $this->getDataTableRow('counties', $query->row['data']);
			 
			$query->row["tariff_country_id"] = isset( $data['tariff_country_id'] ) ? $data['tariff_country_id'] : '';
				
			
			
			return $query->row;
		}
		
	}
	
	private function getRussiaCountry()
	{
		$query = $this->db_query("SELECT * FROM " . DB_PREFIX . "country WHERE iso_code_2='RU'");
		
		return $query->row;
	}
	
	public function sortByKey($array, $key = 'sort_order')
	{
		if( empty($array) || !is_array($array) ) return array();
		
		$sort_order = array();
		foreach($array  as $i=>$row) 
		{
			if( isset($row[ $key ]) )
				$sort_order[$i] = $row[ $key ];
			else
				$sort_order[$i] = 0;
		}

		array_multisort($sort_order, SORT_ASC, $array);
		
		return $array;
	}
	
	private function getSizeValues($vr_length, $vr_width, $vr_height)
	{
		$vr_length = (float)$vr_length;
		$vr_width = (float)$vr_width;
		$vr_height = (float)$vr_height;
		
		$val1 = 0;
		$val2 = 0;
		$val3 = 0;
		
		if( $vr_length == max($vr_length, $vr_width, $vr_height) )
		{
			$val1 = $vr_length;
			
			if( $vr_width > $vr_height )
			{
				$val2 = $vr_width;
				$val3 = $vr_height;
			}
			else
			{
				$val2 = $vr_height;
				$val3 = $vr_width;
			}
		}
		elseif( $vr_width == max($vr_length, $vr_width, $vr_height) )
		{
			$val1 = $vr_width;
			
			if( $vr_length > $vr_height )
			{
				$val2 = $vr_length;
				$val3 = $vr_height;
			}
			else
			{
				$val2 = $vr_height;
				$val3 = $vr_length;
			}
		}
		elseif( $vr_height == max($vr_length, $vr_width, $vr_height) )
		{
			$val1 = $vr_height;
			
			if( $vr_length > $vr_width )
			{
				$val2 = $vr_length;
				$val3 = $vr_width;
			}
			else
			{
				$val2 = $vr_width;
				$val3 = $vr_length;
			}			
		}
		
		return array($val1, $val2, $val3);
	}
	
	
	
	private function combinateLAFF($container, $boxes, $max_volume = 0)
	{ 
		$res_boxes = array();
		
		$max_height = 0;
		$max_length = 0;
		$max_width = 0;
		$sum_height = 0; 
		
		$cach_key = md5(json_encode($container).'|'.json_encode($boxes)."|".$max_volume);
		
		if( isset( $this->combinateLAFF_cache[$cach_key] ) )
			return $this->combinateLAFF_cache[$cach_key];
		
		$sum_volume = 0; 
		
		list($container['length'], $container['width'], $container['height']) = $this->getSizeValues($container['length'], $container['width'], $container['height']);
		
		
		foreach($boxes as $item)
		{
			$sum_volume += ($item['length'] * $item['width'] * $item['height']);
			
			list($cur_length, $cur_width, $cur_height) = $this->getSizeValues($item['length'], 
																					  $item['width'], 
																					  $item['height'] );
													
			if( $cur_height  > $max_height )  $max_height  = $cur_height;
			if( $cur_length > $max_length ) $max_length = $cur_length;
			if( $cur_width  > $max_width )  $max_width  = $cur_width;
			
			$sum_height += $cur_height;
			
			$res_boxes[] = array(
					"width" => (int)$item['width'],
					"height" => (int)$item['height'],
					"length" => (int)$item['length']
			);
			
			
			list($max_width, $max_length, $sum_height) = $this->getSizeValues($max_width, $max_length, $sum_height);
			
			if( 
				$cur_length > $container['length'] || 
				$cur_width > $container['width'] || 
				$cur_height > $container['height']  
			)
			{ 
				$this->combinateLAFF_cache[$cach_key] = 0; 
				return 0;
			}										
		}
		
		if( $sum_volume > ($container['length'] * $container['width'] *  $container['height'] ) )
		{ 
			$this->combinateLAFF_cache[$cach_key] = 2; 
			return 2;
		}
		
		if( $max_volume && 
			floor($sum_volume) > floor($max_volume)  )
		{ 
			$this->combinateLAFF_cache[$cach_key] = 2; 
			return 2;
		}
		
		
		if( $container['width'] >= $max_width && 
			$container['length'] >= $max_length && 
			$container['height'] >= $sum_height  )
		{
			$this->combinateLAFF_cache[$cach_key] = 1; 
			return 1;
		} 
		elseif( count($boxes) > 100 )
		{ 
			$this->combinateLAFF_cache[$cach_key] = 1; 
			return 1;
		}  
		
		$boxes = $res_boxes;
		
	
		$is_debug = 0;
		
		$lp = new LAFFPack1();
		
		$lp->pack($boxes, $container);
		
		$c_levels = $lp->get_levels();
		
		if( $c_levels == 1 ) 
		{
			$this->combinateLAFF_cache[$cach_key] = 1;
			return 1;
		}
		else
		{
			$this->combinateLAFF_cache[$cach_key] = 2;
			return 2;
		}
	}					
	
	// ================================================
	
	private function showErrors()
	{
		if( $this->error && $this->config_get('russianpost2_debug') )
		{
			if( $this->config_get('russianpost2_debug') == 'log' )
			{
				foreach($this->error as $error)
				{
					$this->log->write($error);
				}
			}
			else
			{
				header('Content-Type: text/html; charset=utf-8');
				
				foreach($this->error as $error)
				{
					echo $error."<hr>";
				}
				
				echo '<b>Чтобы отключить отображение ошибок - отключите настройку "Режим отладки" в настройках модуля Почта России 2.0</b><hr>';
			}
		}
	}
	
	
	private function addError($value, $is_critical=0)
	{
		if( strstr($value, 'https://tariff.pochta.ru/v2/calculate/tariff/delivery?json') )
		{
			$value = str_replace(
				'https://tariff.pochta.ru/v2/calculate/tariff/delivery?json', 
				'https://tariff.pochta.ru/v2/calculate/tariff/delivery?html',
				$value
			);
		}
		
		if( strstr($value, 'https://tariff.pochta.ru/v2/calculate/tariff?json') )
		{
			$value = str_replace(
				'https://tariff.pochta.ru/v2/calculate/tariff?json', 
				'https://tariff.pochta.ru/v2/calculate/tariff?html',
				$value
			);
		}
		
		
		$this->error[] = $value;
		if( $is_critical )
		{
			$this->stop = 1;
		}
	}
	
	private function cmp($a, $b)
	{
		if ($a['sort_order'] == $b['sort_order']) {
			return 0;
		}
		return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
	}

	private function tolow($text)
	{
		$locale_top = array("А", "Б", "В", "Г", "Д", "Е", "ё", "Ё", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ь", "Ы", "Ъ", "Э", "Ю", "Я");
		$locale_bot = array("а", "б", "в", "г", "д", "е", "е", "е", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ь", "ы", "ъ", "э", "ю", "я");
	
		return str_replace($locale_top, $locale_bot, $text);
	}
	
	private function toup($text)
	{
		$locale_top = array("А", "Б", "В", "Г", "Д", "Е", "ё", "Ё", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ь", "Ы", "Ъ", "Э", "Ю", "Я");
		$locale_bot = array("а", "б", "в", "г", "д", "е", "е", "е", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ь", "ы", "ъ", "э", "ю", "я");
	
		return str_replace($locale_bot, $locale_top, $text);
	}
	
	private function getValidCity($city)
	{
		if( strstr($city, ",") )
		{
			$city_ar = explode(",", $city);
			$city = trim($city_ar[0]); 
		}
		
		$city = preg_replace("/\./", " ", $city);
		$city = trim($city);
		$city = preg_replace("/[\s]+/", " ", $city);
		
		$ar = explode(" ", $city);
		
		if( count($ar) > 1 )
		{
			$prefix_ar = array("ав", "ау", "г", "го", "д", "дп", "дс", "ж/", 
				"жи", "ка", "кв", "кп", "м", "ма", "мк", "На", "нп", "от", "п", "п/", 
				"пг", "пр", "р-", "рз",
			);
			
			if( in_array($ar[0], $prefix_ar) )
			{
				unset($ar[0]);
				$city = implode(" ", $ar);
			}
		}
		
		$hash = array();
		
		$hash[ $this->tolow('ПЕТРОПАВЛОВСК КАМЧАТСКИЙ') ] = "ПЕТРОПАВЛОВСК-КАМЧАТСКИЙ";
		$hash[ $this->tolow('ПЕТРОПАВЛОВСККАМЧАТСКИЙ') ] = "ПЕТРОПАВЛОВСК-КАМЧАТСКИЙ";
		
		$hash[ $this->tolow('САНКТ ПЕТЕРБУРГ') ] = "САНКТ-ПЕТЕРБУРГ";
		$hash[ $this->tolow('ПЕТЕРБУРГ') ] = "САНКТ-ПЕТЕРБУРГ";
		$hash[ $this->tolow('САНКТПЕТЕРБУРГ') ] = "САНКТ-ПЕТЕРБУРГ";
		
		$hash[ $this->tolow('УСТЬ КАМЧАТСК') ] = "УСТЬ-КАМЧАТСК";
		$hash[ $this->tolow('УСТЬКАМЧАТСК') ] = "УСТЬ-КАМЧАТСК";

		$hash[ $this->tolow('УСТЬ КУЙГА') ] = "УСТЬ-КУЙГА";
		$hash[ $this->tolow('УСТЬКУЙГА') ] = "УСТЬ-КУЙГА";

		$hash[ $this->tolow('УСТЬ КУТ') ] = "УСТЬ-КУТ";
		$hash[ $this->tolow('УСТЬКУТ') ] = "УСТЬ-КУТ";
	
		$hash[ $this->tolow('УСТЬ МАЯ') ] = "УСТЬ-МАЯ";
		$hash[ $this->tolow('УСТЬМАЯ') ] = "УСТЬ-МАЯ";
		
		$hash[ $this->tolow('УСТЬ НЕРА') ] = "УСТЬ-НЕРА";
		$hash[ $this->tolow('УСТЬНЕРА') ] = "УСТЬ-НЕРА";
		
		$hash[ $this->tolow('УСТЬ ХАЙРЮЗОВО') ] = "УСТЬ-ХАЙРЮЗОВО";
		$hash[ $this->tolow('УСТЬХАЙРЮЗОВО') ] = "УСТЬ-ХАЙРЮЗОВО";
		
		$hash[ $this->tolow('ХАНТЫ МАНСИЙСК') ] = "ХАНТЫ-МАНСИЙСК";
		$hash[ $this->tolow('ХАНТЫМАНСИЙСК') ] = "ХАНТЫ-МАНСИЙСК";

		$hash[ $this->tolow('ЮЖНО КУРИЛЬСК') ] = "ЮЖНО-КУРИЛЬСК";
		$hash[ $this->tolow('ЮЖНОКУРИЛЬСК') ] = "ЮЖНО-КУРИЛЬСК";
 	
		$hash[ $this->tolow('ЮЖНО САХАЛИНСК') ] = "ЮЖНО-САХАЛИНСК";
		$hash[ $this->tolow('ЮЖНОСАХАЛИНСК') ] = "ЮЖНО-САХАЛИНСК";
		
		$hash[ $this->tolow('АБАГА ЦЕНТРАЛЬНАЯ') ] = "АБАГА-ЦЕНТРАЛЬНАЯ";
		$hash[ $this->tolow('АБАГАЦЕНТРАЛЬНАЯ') ] = "АБАГА-ЦЕНТРАЛЬНАЯ";
		
		$hash[ $this->tolow('АЛЕКО КЮЕЛЬ') ] = "АЛЕКО-КЮЕЛЬ";
		$hash[ $this->tolow('АЛЕКОКЮЕЛЬ') ] = "АЛЕКО-КЮЕЛЬ";
		
		$hash[ $this->tolow('БАТАГАЙ АЛЫТА') ] = "БАТАГАЙ-АЛЫТА";
		$hash[ $this->tolow('БАТАГАЙАЛЫТА') ] = "БАТАГАЙ-АЛЫТА";
		
		$hash[ $this->tolow('БУОР СЫСЫ') ] = "БУОР-СЫСЫ";
		$hash[ $this->tolow('БУОРСЫСЫ') ] = "БУОР-СЫСЫ";
		
		$hash[ $this->tolow('БЯСЬ КЮЕЛЬ') ] = "БЯСЬ-КЮЕЛЬ";
		$hash[ $this->tolow('БЯСЬКЮЕЛЬ') ] = "БЯСЬ-КЮЕЛЬ";
		
		$hash[ $this->tolow('ГОРНО ЧУЙСКИЙ') ] = "ГОРНО-ЧУЙСКИЙ";
		$hash[ $this->tolow('ГОРНОЧУЙСКИЙ') ] = "ГОРНО-ЧУЙСКИЙ";
		
		$hash[ $this->tolow('ДЕ КАСТРИ') ] = "ДЕ-КАСТРИ";
		$hash[ $this->tolow('ДЕКАСТРИ') ] = "ДЕ-КАСТРИ";
		
		$hash[ $this->tolow('КИЕНГ КЮЕЛЬ') ] = "КИЕНГ-КЮЕЛЬ";
		$hash[ $this->tolow('КИЕНГКЮЕЛЬ') ] = "КИЕНГ-КЮЕЛЬ";
		
		$hash[ $this->tolow('КУДУ КЮЕЛЬ') ] = "КУДУ-КЮЕЛЬ";
		$hash[ $this->tolow('КУДУКЮЕЛЬ') ] = "КУДУ-КЮЕЛЬ";
		
		$hash[ $this->tolow('КУЛУН ЕЛЬБЮТ') ] = "КУЛУН-ЕЛЬБЮТ";
		$hash[ $this->tolow('КУЛУНЕЛЬБЮТ') ] = "КУЛУН-ЕЛЬБЮТ";
		
		$hash[ $this->tolow('НАРЬЯН МАР') ] = "НАРЬЯН-МАР";
		$hash[ $this->tolow('НАРЬЯНМАР') ] = "НАРЬЯН-МАР";
		
		$hash[ $this->tolow('НЕРЮКТЯЙИНСК ВТОРОЙ') ] = "НЕРЮКТЯЙИНСК-ВТОРОЙ";
		$hash[ $this->tolow('НЕРЮКТЯЙИНСКВТОРОЙ') ] = "НЕРЮКТЯЙИНСК-ВТОРОЙ";
		
		$hash[ $this->tolow('НЕРЮКТЯЙИНСК ПЕРВЫЙ') ] = "НЕРЮКТЯЙИНСК-ПЕРВЫЙ";
		$hash[ $this->tolow('НЕРЮКТЯЙИНСКПЕРВЫЙ') ] = "НЕРЮКТЯЙИНСК-ПЕРВЫЙ";
		
		$hash[ $this->tolow('НИКОЛАЕВСК НА АМУРЕ') ] = "НИКОЛАЕВСК-НА-АМУРЕ";
		$hash[ $this->tolow('НИКОЛАЕВСКНААМУРЕ') ] = "НИКОЛАЕВСК-НА-АМУРЕ";
		
		$hash[ $this->tolow('НОВАЯ ИНЯ') ] = "НОВАЯ ИНЯ";
	    $hash[ $this->tolow('НОВОЕ УСТЬЕ') ] = "НОВОЕ УСТЬЕ";
		$hash[ $this->tolow('НОВОЕ ЧАПЛИНО') ] = "НОВОЕ ЧАПЛИНО";
		
		$hash[ $this->tolow('СЕВЕРО ЕНИСЕЙСКИЙ') ] = "СЕВЕРО-ЕНИСЕЙСКИЙ";
		$hash[ $this->tolow('СЕВЕРОЕНИСЕЙСКИЙ') ] = "СЕВЕРО-ЕНИСЕЙСКИЙ";
		
		$hash[ $this->tolow('СЫЛГЫ ЫЫТАР') ] = "СЫЛГЫ-ЫЫТАР";
		$hash[ $this->tolow('СЫЛГЫЫЫТАР') ] = "СЫЛГЫ-ЫЫТАР";
		
		$hash[ $this->tolow('УСТЬ АВАМ') ] = "УСТЬ-АВАМ";
		$hash[ $this->tolow('УСТЬАВАМ') ] = "УСТЬ-АВАМ";
		
		$hash[ $this->tolow('УСТЬ АНЗАС') ] = "УСТЬ-АНЗАС";
		$hash[ $this->tolow('УСТЬАНЗАС') ] = "УСТЬ-АНЗАС";
		
		$hash[ $this->tolow('УСТЬ БЕЛАЯ') ] = "УСТЬ-БЕЛАЯ";
		$hash[ $this->tolow('УСТЬБЕЛАЯ') ] = "УСТЬ-БЕЛАЯ";
		
		$hash[ $this->tolow('УСТЬ КАРА') ] = "УСТЬ-КАРА";
		$hash[ $this->tolow('УСТЬКАРА') ] = "УСТЬ-КАРА";
		
		$hash[ $this->tolow('УСТЬ КУЙГА') ] = "УСТЬ-КУЙГА";
		$hash[ $this->tolow('УСТЬКУЙГА') ] = "УСТЬ-КУЙГА";
		
		$hash[ $this->tolow('УСТЬ КЫМА') ] = "УСТЬ-КЫМА";
		$hash[ $this->tolow('УСТЬКЫМА') ] = "УСТЬ-КЫМА";
		
		$hash[ $this->tolow('УСТЬ НЕРА') ] = "УСТЬ-НЕРА";
		$hash[ $this->tolow('УСТЬНЕРА') ] = "УСТЬ-НЕРА";
		
		$hash[ $this->tolow('УСТЬ ОМЧУГ') ] = "УСТЬ-ОМЧУГ";
		$hash[ $this->tolow('УСТЬОМЧУГ') ] = "УСТЬ-ОМЧУГ";
		
		$hash[ $this->tolow('УСТЬ ПИТ') ] = "УСТЬ-ПИТ";
		$hash[ $this->tolow('УСТЬПИТ') ] = "УСТЬ-ПИТ";
		
		$hash[ $this->tolow('УСТЬ ПОРТ') ] = "УСТЬ-ПОРТ";
		$hash[ $this->tolow('УСТЬПОРТ') ] = "УСТЬ-ПОРТ";
		
		$hash[ $this->tolow('УСТЬ СОБОЛЕВКА') ] = "УСТЬ-СОБОЛЕВКА";
		$hash[ $this->tolow('УСТЬСОБОЛЕВКА') ] = "УСТЬ-СОБОЛЕВКА";
		
		$hash[ $this->tolow('УСТЬ ТЫМ') ] = "УСТЬ-ТЫМ";
		$hash[ $this->tolow('УСТЬТЫМ') ] = "УСТЬ-ТЫМ";
		
		$hash[ $this->tolow('УСТЬ ХАЙРЮЗОВО') ] = "УСТЬ-ХАЙРЮЗОВО";
		$hash[ $this->tolow('УСТЬХАЙРЮЗОВО') ] = "УСТЬ-ХАЙРЮЗОВО";
		
		$hash[ $this->tolow('УСТЬ ЧУЛАСЫ') ] = "УСТЬ-ЧУЛАСЫ";
		$hash[ $this->tolow('УСТЬЧУЛАСЫ') ] = "УСТЬ-ЧУЛАСЫ";
		
		$hash[ $this->tolow('УСТЬ ЯНСК') ] = "УСТЬ-ЯНСК";
		$hash[ $this->tolow('УСТЬЯНСК') ] = "УСТЬ-ЯНСК";
		
		$hash[ $this->tolow('УСУН КЮЕЛЬ') ] = "УСУН-КЮЕЛЬ";
		$hash[ $this->tolow('УСУНКЮЕЛЬ') ] = "УСУН-КЮЕЛЬ";
		
		$hash[ $this->tolow('ХОРЕЙ ВЕР') ] = "ХОРЕЙ-ВЕР";
		$hash[ $this->tolow('ХОРЕЙВЕР') ] = "ХОРЕЙ-ВЕР";
		
		$hash[ $this->tolow('ЭСЭ ХАЙЯ') ] = "ЭСЭ-ХАЙЯ";
		$hash[ $this->tolow('ЭСЭХАЙЯ') ] = "ЭСЭ-ХАЙЯ";
		
		$hash[ $this->tolow('ЮРЮНГ ХАЯ') ] = "ЮРЮНГ-ХАЯ";
		$hash[ $this->tolow('ЮРЮНГХАЯ') ] = "ЮРЮНГ-ХАЯ";
		
		$hash[ $this->tolow('РОСТОВ НА ДОНУ') ] = "РОСТОВ-НА-ДОНУ";
		$hash[ $this->tolow('РОСТОВНАДОНУ') ] = "РОСТОВ-НА-ДОНУ";
		
		$hash[ $this->tolow('СЕВЕРО ЕНИСЕЙСК') ] = "СЕВЕРО-ЕНИСЕЙСК";
		$hash[ $this->tolow('СЕВЕРОЕНИСЕЙСК') ] = "СЕВЕРО-ЕНИСЕЙСК";
		
		$hash[ $this->tolow('СЕВЕРО ЭВЕНСК') ] = "СЕВЕРО-ЭВЕНСК";
		$hash[ $this->tolow('СЕВЕРОЭВЕНСК') ] = "СЕВЕРО-ЭВЕНСК";
	
		if( isset(  $hash[ $this->tolow($city) ] ) ) return $hash[ $this->tolow($city) ];
		else return $city;
		
	}
}

/* **************************************************************
Copyright for class LAFFPack1
-----
https://github.com/mdeboer/php-laff/
Copyright (C) 2012 Maarten de Boer

Permission is hereby granted, free of charge, 
to any person obtaining a copy of this software and associated documentation 
files (the "Software"), to deal in the Software without restriction, 
including without limitation the rights to use, copy, modify, merge, publish, 
distribute, sublicense, and/or sell copies of the Software, 
and to permit persons to whom the Software is furnished to do so, 
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY 
OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO 
THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS 
OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
******************************************************************/

class LAFFPack1 
{
    /**
     * Array of boxes to pack
     *
     * @var array
     */
    private $boxes = null;

    /**
     * Array of boxes that have been packed
     *
     * @var array
     */
    private $packed_boxes = null;

    /**
     * Current level we're packing (0 based index)
     *
     * @var int
     */
    private $level = -1;

    /**
     * Current container dimensions
     *
     * @var array
     */
    private $container_dimensions = null;

    /**
     * Constructor of the BoxPacking class
     *
     * @param array $boxes     Array of boxes to pack
     * @param array $container Container size (required length and width keys)
     */
    public function __construct($boxes = null, $container = null)
    {
        if (isset($boxes) && is_array($boxes)) {
            $this->boxes        = $boxes;
            $this->packed_boxes = array();

            // Calculate container size
            if (!is_array($container)) {
                $this->container_dimensions = $this->_calc_container_dimensions();
            } else {
                // Calculate container size
                if (!is_array($container)) {
                    $this->container_dimensions = $this->_calc_container_dimensions();
                } else {
                    if (!array_key_exists('length', $container) ||
                        !array_key_exists('width', $container)) {
                        throw new \InvalidArgumentException("Function _pack only accepts array (length, width, height) as argument for $container");
                    }

                    $this->container_dimensions['length'] = $container['length'];
                    $this->container_dimensions['width']  = $container['width'];

                    // Note: do NOT set height, it will be calculated on-the-go
                    $this->container_dimensions['height'] = 0;
                }
            }
        }
    }

    /**
     * Start packing boxes
     *
     * @param array $boxes
     * @param array $container Set fixed container dimensions
     */
    public function pack($boxes = null, $container = null)
    {
        if (isset($boxes) && is_array($boxes)) {
            $this->boxes                = $boxes;
            $this->packed_boxes         = array();
            $this->level                = -1;
            $this->container_dimensions = null;

            // Calculate container size
            if (!is_array($container)) {
                $this->container_dimensions = $this->_calc_container_dimensions();
            } else {
                if (!array_key_exists('length', $container) ||
                    !array_key_exists('width', $container)) {
                    throw new \InvalidArgumentException("Pack function only accepts array (length, width, height) as argument for \$container");
                }

                $this->container_dimensions['length'] = $container['length'];
                $this->container_dimensions['width']  = $container['width'];

                // Note: do NOT set height, it will be calculated on-the-go
                $this->container_dimensions['height'] = 0;
            }
        }

        if (!isset($this->boxes)) {
            throw new \InvalidArgumentException("Pack function only accepts array (length, width, height) as argument for \$boxes or no boxes given!");
        }

        $this->pack_level();
    }

    /**
     * Get remaining boxes to pack
     *
     * @return array
     */
    public function get_remaining_boxes()
    {
        return $this->boxes;
    }

    /**
     * Get packed boxes
     *
     * @return array
     */
    public function get_packed_boxes()
    {
        return $this->packed_boxes;
    }

    /**
     * Get container dimensions
     *
     * @return array
     */
    function get_container_dimensions()
    {
        return $this->container_dimensions;
    }

    /**
     * Get container volume
     *
     * @return float
     */
    public function get_container_volume()
    {
        if (!isset($this->container_dimensions)) {
            return 0;
        }

        return $this->_get_volume($this->container_dimensions);
    }

    /**
     * Get number of levels
     *
     * @return int
     */
    public function get_levels()
    {
        return $this->level + 1;
    }

    /**
     * Get total volume of packed boxes
     *
     * @return float
     */
    public function get_packed_volume()
    {
        if (!isset($this->packed_boxes)) {
            return 0;
        }

        $volume = 0;

        for ($i = 0; $i < count(array_keys($this->packed_boxes)); $i++) {
            foreach ($this->packed_boxes[$i] as $box) {
                $volume += $this->_get_volume($box);
            }
        }

        return $volume;
    }

    /**
     * Get number of levels
     *
     * @return int
     */
    public function get_remaining_volume()
    {
        if (!isset($this->packed_boxes)) {
            return 0;
        }

        $volume = 0;

        foreach ($this->boxes as $box) {
            $volume += $this->_get_volume($box);
        }

        return $volume;
    }

    /**
     * Get dimensions of specified level
     *
     * @param int $level
     *
     * @return array
     */
    public function get_level_dimensions($level = 0)
    {
        if ($level < 0 || $level > $this->level || !array_key_exists($level, $this->packed_boxes)) {
            throw new \OutOfRangeException(sprintf('Level %d not found!', $level));
        }

        $boxes = $this->packed_boxes;
        $edges = array('length', 'width', 'height');

        // Get longest edge
        $le    = $this->_calc_longest_edge($boxes[$level], $edges);
        $edges = array_diff($edges, array($le['edge_name']));

        // Re-iterate and get longest edge now (second longest)
        $sle = $this->_calc_longest_edge($boxes[$level], $edges);

        return array(
            'width'  => $le['edge_size'],
            'length' => $sle['edge_size'],
            'height' => $boxes[$level][0]['height']
        );
    }

    /**
     * Get longest edge from boxes
     *
     * @param array $boxes
     * @param array $edges Edges to select the longest from
     *
     * @return array
     */
    public function _calc_longest_edge($boxes, $edges = array('length', 'width', 'height'))
    {
        if (!isset($boxes) || !is_array($boxes)) {
            throw new \InvalidArgumentException('_calc_longest_edge function requires an array of boxes, ' . count($boxes) . ' given');
        }

        // Longest edge
        $le  = null;        // Longest edge
        $lef = null;    // Edge field (length | width | height) that is longest

        // Get longest edges
        foreach ($boxes as $k => $box) {
            foreach ($edges as $edge) {
                if (array_key_exists($edge, $box) && $box[$edge] > $le) {
                    $le  = $box[$edge];
                    $lef = $edge;
                }
            }
        }

        return array(
            'edge_size' => $le,
            'edge_name' => $lef
        );
    }

    /**
     * Calculate container dimensions
     *
     * @return array
     */
    public function _calc_container_dimensions()
    {
        if (!isset($this->boxes)) {
            return array(
                'length' => 0,
                'width'  => 0,
                'height' => 0
            );
        }

        $boxes = $this->boxes;

        $edges = array('length', 'width', 'height');

        // Get longest edge
        $le    = $this->_calc_longest_edge($boxes, $edges);
        $edges = array_diff($edges, array($le['edge_name']));

        // Re-iterate and get longest edge now (second longest)
        $sle = $this->_calc_longest_edge($boxes, $edges);

        return array(
            'length' => $le['edge_size'],
            'width'  => $sle['edge_size'],
            'height' => 0
        );
    }

    /**
     * Utility function to swap two elements in an array
     *
     * @param array $array
     * @param mixed $el1 Index of item to be swapped
     * @param mixed $el2 Index of item to swap with
     *
     * @return array
     */
    public function _swap($array, $el1, $el2)
    {
        if (!array_key_exists($el1, $array) || !array_key_exists($el2, $array)) {
            throw new \InvalidArgumentException("Both element to be swapped need to exist in the supplied array");
        }

        $tmp         = $array[$el1];
        $array[$el1] = $array[$el2];
        $array[$el2] = $tmp;

        return $array;
    }

    /**
     * Utility function that returns the total volume of a box / container
     *
     * @param array $box
     *
     * @return float
     */
    public function _get_volume($box)
    {
        if (!is_array($box) || count(array_keys($box)) < 3) {
            throw new \InvalidArgumentException("_get_volume function only accepts arrays with 3 values (length, width, height)");
        }

        $box = array_filter($box, 'strlen');
        
        return (isset($box['length'])?$box['length']:$box[0]) * (isset($box['width'])?$box['width']:$box[1]) * (isset($box['height'])?$box['height']:$box[2]);;
    }

    /**
     * Check if box fits in specified space
     *
     * @param array $box   Box to fit in space
     * @param array $space Space to fit box in
     *
     * @return bool
     */
    private function _try_fit_box($box, $space)
    {
        if (count($box) < 3) {
            throw new \InvalidArgumentException("_try_fit_box function parameter $box only accepts arrays with 3 values (length, width, height)");
        }

        if (count($space) < 3) {
            throw new \InvalidArgumentException("_try_fit_box function parameter $space only accepts arrays with 3 values (length, width, height)");
        }

        for ($i = 0; $i < count($box); $i++) {
            if (array_key_exists($i, $space)) {
                if ($box[$i] > $space[$i]) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check if box fits in specified space
     * and rotate (3d) if necessary
     *
     * @param array $box   Box to fit in space
     * @param array $space Space to fit box in
     *
     * @return bool
     */
    public function _box_fits($box, $space)
    {
        $box   = array_values($box);
        $space = array_values($space);

        if ($this->_try_fit_box($box, $space)) {
            return true;
        }

        for ($i = 0; $i < count($box); $i++) {
            // Temp box size
            $t_box = $box;

            // Remove fixed column from list to be swapped
            unset($t_box[$i]);

            // Keys to be swapped
            $t_keys = array_keys($t_box);

            // Temp box with swapped sides
            $s_box = $this->_swap($box, $t_keys[0], $t_keys[1]);

            if ($this->_try_fit_box($s_box, $space)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Start a new packing level
     */
    private function pack_level()
    {
        $biggest_box_index = null;
        $biggest_surface   = 0;

        $this->level++;

        // Find biggest (widest surface) box with minimum height
        foreach ($this->boxes as $k => $box) {
            $surface = $box['length'] * $box['width'];

            if ($surface > $biggest_surface) {
                $biggest_surface   = $surface;
                $biggest_box_index = $k;
            } elseif ($surface == $biggest_surface) {
                if (!isset($biggest_box_index) || (isset($biggest_box_index) && $box['height'] < $this->boxes[$biggest_box_index]['height'])) {
                    $biggest_box_index = $k;
                }
            }
        }

        // Get biggest box as object
        $biggest_box                        = $this->boxes[$biggest_box_index];
        $this->packed_boxes[$this->level][] = $biggest_box;

        // Set container height (ck = ck + ci)
        $this->container_dimensions['height'] += $biggest_box['height'];

        // Remove box from array (ki = ki - 1)
        unset($this->boxes[$biggest_box_index]);

        // Check if all boxes have been packed
        if (count($this->boxes) == 0) {
            return;
        }

        $c_area = $this->container_dimensions['length'] * $this->container_dimensions['width'];
        $p_area = $biggest_box['length'] * $biggest_box['width'];

        // No space left (not even when rotated / length and width swapped)
        if ($c_area - $p_area <= 0) {
            $this->pack_level();
        } else { // Space left, check if a package fits in
            $spaces = array();

            if ($this->container_dimensions['length'] - $biggest_box['length'] > 0) {
                $spaces[] = array(
                    'length' => $this->container_dimensions['length'] - $biggest_box['length'],
                    'width'  => $this->container_dimensions['width'],
                    'height' => $biggest_box['height']
                );
            }

            if ($this->container_dimensions['width'] - $biggest_box['width'] > 0) {
                $spaces[] = array(
                    'length' => $biggest_box['length'],
                    'width'  => $this->container_dimensions['width'] - $biggest_box['width'],
                    'height' => $biggest_box['height']
                );
            }

            // Fill each space with boxes
            foreach ($spaces as $space) {
                $this->_fill_space($space);
            }

            // Start packing remaining boxes on a new level
            if (count($this->boxes) > 0) {
                $this->pack_level();
            }
        }
    }

    /**
     * Fills space with boxes recursively
     *
     * @param array $space
     */
    private function _fill_space($space)
    {

        // Total space volume
        $s_volume = $this->_get_volume($space);

        $fitting_box_index  = null;
        $fitting_box_volume = null;

        foreach ($this->boxes as $k => $box) {
            // Skip boxes that have a higher volume than target space
            if ($this->_get_volume($box) > $s_volume) {
                continue;
            }

            if ($this->_box_fits($box, $space)) {
                $b_volume = $this->_get_volume($box);

                if (!isset($fitting_box_volume) || $b_volume > $fitting_box_volume) {
                    $fitting_box_index  = $k;
                    $fitting_box_volume = $b_volume;
                }
            }
        }

        if (isset($fitting_box_index)) {
            $box = $this->boxes[$fitting_box_index];

            // Pack box
            $this->packed_boxes[$this->level][] = $this->boxes[$fitting_box_index];
            unset($this->boxes[$fitting_box_index]);

            // Calculate remaining space left (in current space)
            $new_spaces = array();

            if ($space['length'] - $box['length'] > 0) {
                $new_spaces[] = array(
                    'length' => $space['length'] - $box['length'],
                    'width'  => $space['width'],
                    'height' => $box['height']
                );
            }

            if ($space['width'] - $box['width'] > 0) {
                $new_spaces[] = array(
                    'length' => $box['length'],
                    'width'  => $space['width'] - $box['width'],
                    'height' => $box['height']
                );
            }

            if (count($new_spaces) > 0) {
                foreach ($new_spaces as $new_space) {
                    $this->_fill_space($new_space);
                }
            }
        }
    }
}
?>
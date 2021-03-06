<?php
class ControllerShippingCdek extends Controller
{
	private $error = array();
	
	const VERSION = '1.9.4';
	
	public function index()
	{
		$this->load->language('shipping/cdek');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (!extension_loaded('curl')) {
			$this->error['warning'] = $this->language->get('error_curl');
		}
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && !isset($this->error['warning'])) {
			
			if ($this->request->post['apply']) {
				$url = $this->url->link('shipping/cdek', 'token=' . $this->session->data['token'], 'SSL');
			} else {
				$url = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			}
			
			unset($this->request->post['apply']);

            if (in_array($this->request->post['cdek_view_type'], array('group', 'map'))) {
                $this->request->post['cdek_pvz_more_one'] = 'split';
            }
			
			$this->model_setting_setting->editSetting('cdek', $this->request->post);
			
			$this->saveTariffList();

			// Clear cache PVZ
			$this->cache->delete('cdek.shipping.pvz');
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($url);
		}
		
		$this->load->model('sale/customer_group');
		$this->load->model('localisation/geo_zone');
		$this->load->model('localisation/country');
		$this->load->model('localisation/tax_class');
		$this->load->model('localisation/language');
		$this->load->model('localisation/length_class');
		$this->load->model('localisation/weight_class');
		
		$this->document->addStyle('view/stylesheet/cdek.css');
		$this->document->addScript('view/javascript/jquery/jquery.tablednd.0.7.min.js');
				
		$this->data['heading_title'] = $this->language->get('heading_title') . ' v' . self::VERSION;

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_date_current'] = $this->language->get('text_date_current');
		$this->data['text_date_append'] = $this->language->get('text_date_append');
		$this->data['text_day'] = $this->language->get('text_day');
		$this->data['text_insurance_cost'] = $this->language->get('text_insurance_cost');
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_help_auth'] = $this->language->get('text_help_auth');
		$this->data['text_drag'] = $this->language->get('text_drag');
		$this->data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$this->data['text_tariff'] = $this->language->get('text_tariff');
		$this->data['text_help_im'] = $this->language->get('text_help_im');
		$this->data['text_show_password'] = $this->language->get('text_show_password');
		$this->data['text_hide_password'] = $this->language->get('text_hide_password');
		$this->data['text_more_attention'] = $this->language->get('text_more_attention');
		$this->data['text_view_type_attention'] = $this->language->get('text_view_type_attention');
		$this->data['text_volume_attention'] = $this->language->get('text_volume_attention');
		$this->data['text_from'] = $this->language->get('text_from');
		$this->data['text_discount_help'] = $this->language->get('text_discount_help');
		$this->data['text_short_length'] = $this->language->get('text_short_length');
		$this->data['text_short_width'] = $this->language->get('text_short_width');
		$this->data['text_short_height'] = $this->language->get('text_short_height');
		$this->data['text_all_tariff'] = $this->language->get('text_all_tariff');
		$this->data['text_tariff_auth'] = $this->language->get('text_tariff_auth');
		$this->data['text_weight'] = $this->language->get('text_weight');

		$this->data['entry_more_days'] = $this->language->get('entry_more_days');
		$this->data['entry_log'] = $this->language->get('entry_log');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_period'] = $this->language->get('entry_period');
		$this->data['entry_delivery_data'] = $this->language->get('entry_delivery_data');
		$this->data['entry_empty_address'] = $this->language->get('entry_empty_address');
		$this->data['entry_show_pvz'] = $this->language->get('entry_show_pvz');
		$this->data['entry_work_mode'] = $this->language->get('entry_work_mode');
		$this->data['entry_max_weight'] = $this->language->get('entry_max_weight');
		$this->data['entry_cache_on_delivery'] = $this->language->get('entry_cache_on_delivery');
		$this->data['entry_city_from'] = $this->language->get('entry_city_from');
		$this->data['entry_length_class'] = $this->language->get('entry_length_class');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_default_size'] = $this->language->get('entry_default_size');
		$this->data['entry_volume'] = $this->language->get('entry_volume');
		$this->data['entry_default_weight_use'] = $this->language->get('entry_default_weight_use');
		$this->data['entry_default_weight'] = $this->language->get('entry_default_weight');
		$this->data['entry_default_weight_work_mode'] = $this->language->get('entry_default_weight_work_mode');
		$this->data['entry_size'] = $this->language->get('entry_size');
		$this->data['entry_login'] = $this->language->get('entry_login');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_additional_weight'] = $this->language->get('entry_additional_weight');
		$this->data['entry_min_weight'] = $this->language->get('entry_min_weight');
		$this->data['entry_max_weight'] = $this->language->get('entry_max_weight');
		$this->data['entry_min_total'] = $this->language->get('entry_min_total');
		$this->data['entry_max_total'] = $this->language->get('entry_max_total');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_date_execute'] = $this->language->get('entry_date_execute');
		$this->data['entry_pvz_more_one'] = $this->language->get('entry_pvz_more_one');
		$this->data['entry_weight_limit'] = $this->language->get('entry_weight_limit');
		$this->data['entry_use_region'] = $this->language->get('entry_use_region');
		$this->data['entry_check_ip'] = $this->language->get('entry_check_ip');
		$this->data['entry_default_size_type'] = $this->language->get('entry_default_size_type');
		$this->data['entry_default_size_work_mode'] = $this->language->get('entry_default_size_work_mode');
		$this->data['entry_packing_min_weight'] = $this->language->get('entry_packing_min_weight');
		$this->data['entry_packing_additional_weight'] = $this->language->get('entry_packing_additional_weight');
		$this->data['entry_city_ignore'] = $this->language->get('entry_city_ignore');
		$this->data['entry_pvz_ignore'] = $this->language->get('entry_pvz_ignore');
		$this->data['entry_empty'] = $this->language->get('entry_empty');
		$this->data['entry_empty_cost'] = $this->language->get('entry_empty_cost');
		$this->data['entry_insurance'] = $this->language->get('entry_insurance');
        $this->data['entry_hide_pvz'] = $this->language->get('entry_hide_pvz');
		$this->data['entry_view_type'] = $this->language->get('entry_view_type');
		$this->data['entry_rounding'] = $this->language->get('entry_rounding');
		$this->data['entry_rounding_type'] = $this->language->get('entry_rounding_type');

		$this->data['column_tariff'] = $this->language->get('column_tariff');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_mode'] = $this->language->get('column_mode');
		$this->data['column_markup'] = $this->language->get('column_markup');
		$this->data['column_limit'] = $this->language->get('column_limit');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_geo_zone'] = $this->language->get('column_geo_zone');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_tax_class'] = $this->language->get('column_tax_class');
		$this->data['column_discount_type'] = $this->language->get('column_discount_type');
		$this->data['column_discount_value'] = $this->language->get('column_discount_value');
		$this->data['column_empty'] = $this->language->get('column_empty');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_auth'] = $this->language->get('tab_auth');
		$this->data['tab_tariff'] = $this->language->get('tab_tariff');
		$this->data['tab_package'] = $this->language->get('tab_package');
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_additional'] = $this->language->get('tab_additional');
		$this->data['tab_empty'] = $this->language->get('tab_empty');
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['error'] = $this->error;
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/cdek', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['boolean_variables'] = array($this->language->get('text_no'), $this->language->get('text_yes'));
		
		$this->data['size_types'] = array(
			'volume' => $this->language->get('text_size_type_volume'),
			'size'	 => $this->language->get('text_size_type_size'),
		);
		
		$this->data['default_work_mode'] = array(
			'order'		=> $this->language->get('text_mode_order'),
			'all'		=> $this->language->get('text_mode_product_all'),
			'optional'	=> $this->language->get('text_mode_product_optional')
		);
		
		$this->data['pvz_more_one_action'] = array(
			'first' => $this->language->get('text_first'),
			//'merge' => $this->language->get('text_merge'),
			'split' => $this->language->get('text_split')
		);

		$this->data['work_mode'] = array(
			'single' => $this->language->get('text_single'),
			'more'	 => $this->language->get('text_more')
		);
		
		$this->data['discount_type'] = array(
			'fixed'				=> $this->language->get('text_fixed'),
			'percent'			=> $this->language->get('text_percent_source_product'),
			'percent_shipping'	=> $this->language->get('text_percent_shipping'),
			'percent_cod'		=> $this->language->get('text_percent_source_cod')
		);
		
		$this->data['additional_weight_mode'] = array(
			'fixed'			=> $this->language->get('text_weight_fixed'),
			'all_percent'	=> $this->language->get('text_weight_all')
		);
		
		$this->data['action'] = $this->url->link('shipping/cdek', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['cdek_title'])) {
			$this->data['cdek_title'] = $this->request->post['cdek_title'];
		} else {
			$this->data['cdek_title'] = $this->config->get('cdek_title');
		}
		
		if (isset($this->request->post['cdek_cache_on_delivery'])) {
			$this->data['cdek_cache_on_delivery'] = $this->request->post['cdek_cache_on_delivery'];
		} else {
			$this->data['cdek_cache_on_delivery'] = $this->config->get('cdek_cache_on_delivery');
		}
		
		if (isset($this->request->post['cdek_weight_limit'])) {
			$this->data['cdek_weight_limit'] = $this->request->post['cdek_weight_limit'];
		} else {
			$this->data['cdek_weight_limit'] = $this->config->get('cdek_weight_limit');
		}
		
		if (isset($this->request->post['cdek_use_region'])) {
			$this->data['cdek_use_region'] = $this->request->post['cdek_use_region'];
		} elseif (!is_null($this->config->get('cdek_use_region'))) {
			$this->data['cdek_use_region'] = $this->config->get('cdek_use_region');
		} else {
			$this->data['cdek_use_region'] = array();
		}
		
		if (isset($this->request->post['cdek_use_region_russia'])) {
			$this->data['cdek_use_region_russia'] = $this->request->post['cdek_use_region_russia'];
		} elseif (!is_null($this->config->get('cdek_use_region_russia'))) {
			$this->data['cdek_use_region_russia'] = $this->config->get('cdek_use_region_russia');
		} else {
			$this->data['cdek_use_region_russia'] = 1;
		}
		
		if (isset($this->request->post['cdek_log'])) {
			$this->data['cdek_log'] = $this->request->post['cdek_log'];
		} else {
			$this->data['cdek_log'] = $this->config->get('cdek_log');
		}
		
		if (isset($this->request->post['cdek_custmer_tariff_list'])) {
			$this->data['cdek_custmer_tariff_list'] = $this->request->post['cdek_custmer_tariff_list'];
		} elseif ($this->config->get('cdek_custmer_tariff_list')) {
			$this->data['cdek_custmer_tariff_list'] = $this->config->get('cdek_custmer_tariff_list');
		} else {
			$this->data['cdek_custmer_tariff_list'] = array();
		}
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->data['tariff_list'] = array();

		$tariff_list = $this->getTariffList();

		$tariff_groups = $this->getTariffGroups();

		$tariff_mode = $this->getTariffMode();

		foreach ($tariff_list as $tariff_id => &$tariff_info) {

			if (!isset($this->data['tariff_list'][$tariff_info['group_id']])) {

				$this->data['tariff_list'][$tariff_info['group_id']] = array(
					'title'	=> $tariff_groups[$tariff_info['group_id']],
					'list'	=> array()
				);

			}

			if (!empty($tariff_info['weight'])) {
				$tariff_info['weight'] = $this->getWeightText($tariff_info['weight']);
			}

			$mode = $tariff_mode[$tariff_info['mode_id']];

			$tariff_info += array(
				'title_full'	=> $tariff_info['title'] . ' (' . $mode['code'] . ')',
				'mode'			=> $mode
			);

			$this->data['tariff_list'][$tariff_info['group_id']]['list'][$tariff_id] = $tariff_info;
		}

		if (isset($this->data['cdek_custmer_tariff_list'])) {
		
			foreach ($this->data['cdek_custmer_tariff_list'] as $tariff_row => $tariff_info) {
				
				if (array_key_exists('tariff_id', $tariff_info) && array_key_exists($tariff_info['tariff_id'], $tariff_list)) {
					
					$tariff_id = $tariff_info['tariff_id'];
				
					$title = $tariff_list[$tariff_id]['title'];
					
					if (array_key_exists('im', $tariff_list[$tariff_id])) {
						$title .= ' ***'; 
					}
					
					$this->data['cdek_custmer_tariff_list'][$tariff_row] += array(
						'tariff_name'	=> $title,
						'im'			=> isset($tariff_list[$tariff_id]['im']),
						'mode_name'		=> $tariff_mode[$tariff_info['mode_id']]['title'],
						'weight'		=> $tariff_list[$tariff_id]['weight'],
						'note'			=> $tariff_list[$tariff_id]['note']
					);
					
				} else {
					unset($this->data['cdek_tariff_list'][$tariff_row]);
				}
			}
		
		}
		
		if (isset($this->request->post['cdek_work_mode'])) {
			$this->data['cdek_work_mode'] = $this->request->post['cdek_work_mode'];
		} else {
			$this->data['cdek_work_mode'] = $this->config->get('cdek_work_mode');
		}
		
		if (isset($this->request->post['cdek_show_pvz'])) {
			$this->data['cdek_show_pvz'] = $this->request->post['cdek_show_pvz'];
		} else {
			$this->data['cdek_show_pvz'] = $this->config->get('cdek_show_pvz');
		}

		$this->data['view_types'] = array(
            'default'   => $this->language->get('text_view_type_default'),
            'group'     => $this->language->get('text_view_type_group'),
            'map'       => $this->language->get('text_view_type_map')
		);

		if (isset($this->request->post['cdek_view_type'])) {
			$this->data['cdek_view_type'] = $this->request->post['cdek_view_type'];
		} else {
			$this->data['cdek_view_type'] = $this->config->get('cdek_view_type');
		}
		
		if (isset($this->request->post['cdek_pvz_more_one'])) {
			$this->data['cdek_pvz_more_one'] = $this->request->post['cdek_pvz_more_one'];
		} else {
			$this->data['cdek_pvz_more_one'] = $this->config->get('cdek_pvz_more_one');
		}
		
		if (isset($this->request->post['cdek_default_size'])) {
			$this->data['cdek_default_size'] = $this->request->post['cdek_default_size'];
		} else {
			$this->data['cdek_default_size'] = $this->config->get('cdek_default_size');
		}
		
		if (isset($this->request->post['cdek_default_weight'])) {
			$this->data['cdek_default_weight'] = $this->request->post['cdek_default_weight'];
		} else {
			$this->data['cdek_default_weight'] = $this->config->get('cdek_default_weight');
		}
		
		if (isset($this->request->post['cdek_tax_class_id'])) {
			$this->data['cdek_tax_class_id'] = $this->request->post['cdek_tax_class_id'];
		} else {
			$this->data['cdek_tax_class_id'] = $this->config->get('cdek_tax_class_id');
		}
		
		if (isset($this->request->post['cdek_geo_zone_id'])) {
			$this->data['cdek_geo_zone_id'] = $this->request->post['cdek_geo_zone_id'];
		} else {
			$this->data['cdek_geo_zone_id'] = $this->config->get('cdek_geo_zone_id');
		}
		
		if (isset($this->request->post['cdek_customer_group_id'])) {
			$this->data['cdek_customer_group_id'] = $this->request->post['cdek_customer_group_id'];
		} else {
			$this->data['cdek_customer_group_id'] = $this->config->get('cdek_customer_group_id');
		}
		
		if (isset($this->request->post['cdek_status'])) {
			$this->data['cdek_status'] = $this->request->post['cdek_status'];
		} else {
			$this->data['cdek_status'] = $this->config->get('cdek_status');
		}
		
		if (isset($this->request->post['cdek_period'])) {
			$this->data['cdek_period'] = $this->request->post['cdek_period'];
		} else {
			$this->data['cdek_period'] = $this->config->get('cdek_period');
		}
		
		if (isset($this->request->post['cdek_delivery_data'])) {
			$this->data['cdek_delivery_data'] = $this->request->post['cdek_delivery_data'];
		} else {
			$this->data['cdek_delivery_data'] = $this->config->get('cdek_delivery_data');
		}
		
		if (isset($this->request->post['cdek_empty_address'])) {
			$this->data['cdek_empty_address'] = $this->request->post['cdek_empty_address'];
		} elseif ($this->config->get('cdek_empty_address') !== null) {
			$this->data['cdek_empty_address'] = $this->config->get('cdek_empty_address');
		} else {
			$this->data['cdek_empty_address'] = 1;
		}

		if (isset($this->request->post['cdek_check_ip'])) {
			$this->data['cdek_check_ip'] = $this->request->post['cdek_check_ip'];
		} else {
			$this->data['cdek_check_ip'] = $this->config->get('cdek_check_ip');
		}
		
		if (isset($this->request->post['cdek_min_weight'])) {
			$this->data['cdek_min_weight'] = $this->request->post['cdek_min_weight'];
		} else {
			$this->data['cdek_min_weight'] = $this->config->get('cdek_min_weight');
		}
		
		if (isset($this->request->post['cdek_max_weight'])) {
			$this->data['cdek_max_weight'] = $this->request->post['cdek_max_weight'];
		} else {
			$this->data['cdek_max_weight'] = $this->config->get('cdek_max_weight');
		}
		
		if (isset($this->request->post['cdek_min_total'])) {
			$this->data['cdek_min_total'] = $this->request->post['cdek_min_total'];
		} else {
			$this->data['cdek_min_total'] = $this->config->get('cdek_min_total');
		}
		
		if (isset($this->request->post['cdek_max_total'])) {
			$this->data['cdek_max_total'] = $this->request->post['cdek_max_total'];
		} else {
			$this->data['cdek_max_total'] = $this->config->get('cdek_max_total');
		}
		
		if (isset($this->request->post['cdek_city_from'])) {
			$this->data['cdek_city_from'] = $this->request->post['cdek_city_from'];
		} else {
			$this->data['cdek_city_from'] = $this->config->get('cdek_city_from');
		}
		
		if (isset($this->request->post['cdek_length_class_id'])) {
			$this->data['cdek_length_class_id'] = $this->request->post['cdek_length_class_id'];
		} elseif ($this->config->get('cdek_length_class_id')) {
			$this->data['cdek_length_class_id'] = $this->config->get('cdek_length_class_id');
		} else {
			$this->data['cdek_length_class_id'] = 1;
		}
		
		if (isset($this->request->post['cdek_weight_class_id'])) {
			$this->data['cdek_weight_class_id'] = $this->request->post['cdek_weight_class_id'];
		} elseif ($this->config->get('cdek_weight_class_id')) {
			$this->data['cdek_weight_class_id'] = $this->config->get('cdek_weight_class_id');
		} else {
			$this->data['cdek_weight_class_id'] = 1;
		}
		
		if (isset($this->request->post['cdek_city_from_id'])) {
			$this->data['cdek_city_from_id'] = $this->request->post['cdek_city_from_id'];
		} else {
			$this->data['cdek_city_from_id'] = $this->config->get('cdek_city_from_id');
		}
		
		if (isset($this->request->post['cdek_append_day'])) {
			$this->data['cdek_append_day'] = $this->request->post['cdek_append_day'];
		} else {
			$this->data['cdek_append_day'] = (int)$this->config->get('cdek_append_day');
		}
		
		if (isset($this->request->post['cdek_more_days'])) {
			$this->data['cdek_more_days'] = $this->request->post['cdek_more_days'];
		} else {
			$this->data['cdek_more_days'] = (int)$this->config->get('cdek_more_days');
		}
		
		if (isset($this->request->post['cdek_login'])) {
			$this->data['cdek_login'] = $this->request->post['cdek_login'];
		} else {
			$this->data['cdek_login'] = $this->config->get('cdek_login');
		}
		
		if (isset($this->request->post['cdek_password'])) {
			$this->data['cdek_password'] = $this->request->post['cdek_password'];
		} else {
			$this->data['cdek_password'] = $this->config->get('cdek_password');
		}
		
		if (isset($this->request->post['cdek_store'])) {
			$this->data['cdek_store'] = $this->request->post['cdek_store'];
		} elseif($this->config->get('cdek_store')) {
			$this->data['cdek_store'] = $this->config->get('cdek_store');
		} else {
			$this->data['cdek_store'] = array();
		}
		
		if (isset($this->request->post['cdek_sort_order'])) {
			$this->data['cdek_sort_order'] = $this->request->post['cdek_sort_order'];
		} else {
			$this->data['cdek_sort_order'] = $this->config->get('cdek_sort_order');
		}
		
		if (isset($this->request->post['cdek_packing_weight_class_id'])) {
			$this->data['cdek_packing_weight_class_id'] = $this->request->post['cdek_packing_weight_class_id'];
		} else {
			$this->data['cdek_packing_weight_class_id'] = $this->config->get('cdek_packing_weight_class_id');
		}
		
		if (isset($this->request->post['cdek_packing_prefix'])) {
			$this->data['cdek_packing_prefix'] = $this->request->post['cdek_packing_prefix'];
		} else {
			$this->data['cdek_packing_prefix'] = $this->config->get('cdek_packing_prefix');
		}
		
		if (isset($this->request->post['cdek_packing_mode'])) {
			$this->data['cdek_packing_mode'] = $this->request->post['cdek_packing_mode'];
		} else {
			$this->data['cdek_packing_mode'] = $this->config->get('cdek_packing_mode');
		}
		
		if (isset($this->request->post['cdek_packing_value'])) {
			$this->data['cdek_packing_value'] = $this->request->post['cdek_packing_value'];
		} else {
			$this->data['cdek_packing_value'] = $this->config->get('cdek_packing_value');
		}
		
		if (isset($this->request->post['cdek_packing_min_weight'])) {
			$this->data['cdek_packing_min_weight'] = $this->request->post['cdek_packing_min_weight'];
		} else {
			$this->data['cdek_packing_min_weight'] = $this->config->get('cdek_packing_min_weight');
		}
		
		if (isset($this->request->post['cdek_discounts'])) {
			$this->data['cdek_discounts'] = $this->request->post['cdek_discounts'];
		} elseif ($this->config->get('cdek_discounts')) {
			$this->data['cdek_discounts'] = $this->config->get('cdek_discounts');
		} else {
			$this->data['cdek_discounts'] = array();
		}
		
		if (isset($this->request->post['cdek_city_ignore'])) {
			$this->data['cdek_city_ignore'] = $this->request->post['cdek_city_ignore'];
		} else {
			$this->data['cdek_city_ignore'] = $this->config->get('cdek_city_ignore');
		}

		if (isset($this->request->post['cdek_pvz_ignore'])) {
			$this->data['cdek_pvz_ignore'] = $this->request->post['cdek_pvz_ignore'];
		} else {
			$this->data['cdek_pvz_ignore'] = $this->config->get('cdek_pvz_ignore');
		}
		
		if (isset($this->request->post['cdek_empty'])) {
			$this->data['cdek_empty'] = $this->request->post['cdek_empty'];
		} else {
			$this->data['cdek_empty'] = $this->config->get('cdek_empty');
		}

		if (isset($this->request->post['cdek_insurance'])) {
			$this->data['cdek_insurance'] = $this->request->post['cdek_insurance'];
		} else {
			$this->data['cdek_insurance'] = $this->config->get('cdek_insurance');
		}

        if (isset($this->request->post['cdek_hide_pvz'])) {
            $this->data['cdek_hide_pvz'] = $this->request->post['cdek_hide_pvz'];
        } else {
            $this->data['cdek_hide_pvz'] = $this->config->get('cdek_hide_pvz');
        }

		if (isset($this->request->post['cdek_rounding'])) {
			$this->data['cdek_rounding'] = $this->request->post['cdek_rounding'];
		} else {
			$this->data['cdek_rounding'] = $this->config->get('cdek_rounding');
		}

		if (isset($this->request->post['cdek_rounding_type'])) {
			$this->data['cdek_rounding_type'] = $this->request->post['cdek_rounding_type'];
		} else {
			$this->data['cdek_rounding_type'] = $this->config->get('cdek_rounding_type');
		}

		$this->data['rounding_types'] = array(
			'round' => $this->language->get('text_rounding_type_round'),
			'floor' => $this->language->get('text_rounding_type_floor'),
			'ceil' => $this->language->get('text_rounding_type_ceil')
		);

		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = array();
		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'	   => $this->language->get('text_store_default')
		);
		
		$this->data['stores'] = array_merge($this->data['stores'], $this->model_setting_store->getStores());
		
		$this->template = 'shipping/cdek.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'shipping/cdek')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} else {
			
			if (!isset($this->request->post['cdek_city_from_id']) || $this->request->post['cdek_city_from_id'] == 0) {
				$this->error['cdek_city_from'] = $this->language->get('error_cdek_city_from');
			}
			
			foreach (array('cdek_weight_class_id', 'cdek_length_class_id') as $item) {
				if (!$this->request->post[$item]) $this->error[$item] = $this->language->get('error_empty');
			}
			
			if ($this->request->post['cdek_default_size']['use']) {
				
				$default_size = $this->request->post['cdek_default_size'];
				
				switch ($default_size['type']) {
					case 'volume':
					
						if (!is_numeric($default_size['volume'])) {
							$this->error['cdek_default_size']['volume'] = $this->language->get('error_numeric');
						} elseif ($default_size['volume'] <= 0) {
							$this->error['cdek_default_size']['volume'] = $this->language->get('error_positive_numeric');
						}
					
						break;
					case 'size':
					
						foreach (array('size_a', 'size_b', 'size_c') as $item) {
							
							if (!is_numeric($default_size[$item])) {
								$this->error['cdek_default_size']['size'] = $this->language->get('error_numeric');
								break;
							} elseif ($default_size[$item] <= 0) {
								$this->error['cdek_default_size']['size'] = $this->language->get('error_positive_numeric');
								break;
							}
							
						}
					
						break;
				}
				
			}
			
			if ($this->request->post['cdek_default_weight']['use']) {
				
				$default_weight = $this->request->post['cdek_default_weight'];
				
				if (!is_numeric($default_weight['value'])) {
					$this->error['cdek_default_weight']['value'] = $this->language->get('error_numeric');
				} elseif ($default_weight['value'] <= 0) {
					$this->error['cdek_default_weight']['value'] = $this->language->get('error_positive_numeric');
				}
				
			}
			
			foreach (array('cdek_append_day', 'cdek_max_weight', 'cdek_min_weight', 'cdek_min_total', 'cdek_max_total', 'cdek_sort_order', 'cdek_packing_value', 'cdek_more_days') as $item) {
				if ($this->request->post[$item] != "" && !is_numeric($this->request->post[$item])) {
					$this->error[$item] = $this->language->get('error_numeric');
				}
			}
			
			if ($this->request->post['cdek_packing_min_weight'] != "") {
				
				if (!is_numeric($this->request->post['cdek_packing_min_weight'])) {
					$this->error['cdek_packing_min_weight'] = $this->language->get('error_numeric');
				} elseif ($this->request->post['cdek_packing_min_weight'] <= 0) {
					$this->error['cdek_packing_min_weight'] = $this->language->get('error_positive_numeric');
				}
				
			}
			
			if (!isset($this->request->post['cdek_custmer_tariff_list']) || empty($this->request->post['cdek_custmer_tariff_list'])) {
				$this->error['tariff_list'] = $this->language->get('error_tariff_list');
			} else {
				
				$geo_zones = $tariff_exists = array();
				
				$this->load->model('localisation/geo_zone');
				
				foreach ($this->model_localisation_geo_zone->getGeoZones() as $item) {
					$geo_zones[$item['geo_zone_id']] = '«' . $item['name'] . '»';
				}
				
				foreach ($this->request->post['cdek_custmer_tariff_list'] as $tariff_row => $tariff_info) {
					
					$tariff_id = $tariff_info['tariff_id'];
					
					foreach (array('max_weight', 'min_weight', 'min_total', 'max_total') as $item) {
						if ($tariff_info[$item] != "" && !is_numeric($tariff_info[$item])) {
							$this->error['tariff_list_item'][$tariff_row][$item] = $this->language->get('error_numeric');
						} elseif (is_numeric($tariff_info[$item]) && $tariff_info[$item] <= 0) {
							$this->error['tariff_list_item'][$tariff_row][$item] = $this->language->get('error_positive_numeric');
						}
					}
					
					$geo_zone = !empty($tariff_info['geo_zone']) ? array_flip($tariff_info['geo_zone']) : array('all' => 'all');
					
					if (array_key_exists($tariff_id, $tariff_exists)) {
						
						$exists = array_intersect_key($geo_zone, $tariff_exists[$tariff_id]);
						
						if (!empty($exists)) {
							
							$error_zones = array();
							
							foreach (array_keys($exists) as $zone_id) {
								if (array_key_exists($zone_id, $geo_zones)) {
									$error_zones[] = $geo_zones[$zone_id];
								} elseif ($zone_id == 'all')  {
									$error_zones[] = 'все регионы';
								}
							}
							
							if (!empty($error_zones)) {
								$this->error['tariff_list_item'][$tariff_row]['exists'] = sprintf($this->language->get('error_tariff_item_exists'), implode(', ', array_unique($error_zones)));
							}
						}
						
						$tariff_exists[$tariff_id] += $geo_zone;
						
					} else {
						$tariff_exists[$tariff_id] = $geo_zone;
					}
					
				}
				
			}
			
			if (!empty($this->request->post['cdek_discounts'])) {
				
				foreach ($this->request->post['cdek_discounts'] as $discount_row => $discount_data) {
					
					if ($discount_data['total'] == "" || !is_numeric($discount_data['total'])) {
						$this->error['cdek_discounts'][$discount_row]['total'] = $this->language->get('error_numeric');
					}
					
					if ($discount_data['value'] == '') {
						$this->error['cdek_discounts'][$discount_row]['value'] = $this->language->get('error_empty');
					} elseif (!is_numeric($discount_data['value'])) {
						$this->error['cdek_discounts'][$discount_row]['value'] = $this->language->get('error_numeric');
					}
					
				}
			}
			
			if (!empty($this->request->post['cdek_empty']['use'])) {
				
				if ($this->request->post['cdek_empty']['cost'] != "" && !is_numeric($this->request->post['cdek_empty']['cost'])) {
					$this->error['cdek_empty']['cost'] = $this->language->get('error_numeric');
				}
				
			}
			
			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	private function getTariffMode()
	{
		return array(
			1 => array(
				'title'	=> 'дверь-дверь',
				'code'	=> 'Д-Д'
			),
			2 => array(
				'title'	=> 'дверь-склад',
				'code'	=> 'Д-С'
			),
			3 => array(
				'title'	=> 'склад-дверь',
				'code'	=> 'С-Д'
			),
			4 => array(
				'title'	=> 'склад-склад',
				'code'	=> 'С-С'
			)
		);
	}

	private function getTariffGroups()
	{
		return array(
			1 => 'Тарифы только для Интернет-магазинов',
			2 => 'Тарифы Китайский экспресс',
			3 => 'Тарифы для обычной доставки',
			4 => 'Тарифы для международной доставки'
		);
	}
	
	private function getTariffList()
	{
		return array(
			136 => array(
				'title'		=> 'Посылка',
				'group_id'	=> 1,
				'mode_id'	=> 4,
				'im'        => 1,
				'weight'    => array('max' => 30),
				'note'      => 'Услуга экономичной доставки товаров по России для компаний, осуществляющих дистанционную торговлю.',
			),
			137 => array(
				'title'		=> 'Посылка',
				'group_id'	=> 1,
				'mode_id'	=> 3,
				'im'		=> 1,
				'weight'    => array('max' => 30),
				'note'      => 'Услуга экономичной доставки товаров по России для компаний, осуществляющих дистанционную торговлю.'
			),
			138 => array(
				'title'		=> 'Посылка',
				'group_id'	=> 1,
				'mode_id'	=> 2,
				'im'		=> 1,
				'weight'    => array('max' => 30),
				'note'      => 'Услуга экономичной доставки товаров по России для компаний, осуществляющих дистанционную торговлю.'
			),
			139 => array(
				'title'		=> 'Посылка',
				'group_id'	=> 1,
				'mode_id'	=> 1,
				'im'		=> 1,
				'weight'    => array('max' => 30),
				'note'      => 'Услуга экономичной доставки товаров по России для компаний, осуществляющих дистанционную торговлю.',
			),
			233 => array(
				'title'		=> 'Экономичная посылка',
				'group_id'	=> 1,
				'mode_id'	=> 3,
				'im'		=> 1,
				'weight'    => array('max' => 50),
				'note'      => 'Услуга экономичной наземной доставки товаров по России для компаний, осуществляющих дистанционную торговлю. Услуга действует по направлениям из Москвы в подразделения СДЭК, находящиеся за Уралом и в Крым.',
			),
			234 => array(
				'title'		=> 'Экономичная посылка',
				'group_id'	=> 1,
				'mode_id'	=> 4,
				'im'		=> 1,
				'weight'    => array('max' => 50),
				'note'      => '',
			),
			301 => array(
				'title'		=> 'До постомата InPost',
				'group_id'	=> 1,
				'mode_id'	=> 2,
				'im'		=> 1,
				'weight'    => array(),
				'note'      => 'Услуга доставки товаров по России с использованием постоматов. Для компаний, осуществляющих дистанционную торговлю.<br /><br />Характеристики услуги:<ul type="circle"><li>по услуге принимаются только одноместные заказы</li><li>выбранный при оформлении заказа постомат изменить на другой нельзя</li><li>при невозможности использования постоматов осуществляется доставка до ПВЗ СДЭК или «до двери» клиента с изменением тарификации на услугу «Посылка»</li><li>срок хранения заказа в ячейке: 5 дней с момента закладки в постомат</li><li>возможность приема наложенного платежа</li></ul>3 вида ячеек:<ol><li>А (8*38*64 см)— до 5 кг</li><li>В (19*38*64 см) — до 7 кг</li><li>С (41*38*64 см)— до 20 кг</li></ol>',
				'postomat'	=> true
			),
			302 => array(
				'title'		=> 'До постомата InPost',
				'group_id'	=> 1,
				'mode_id'	=> 4,
				'im'		=> 1,
				'weight'    => array(),
				'note'      => 'Услуга доставки товаров по России с использованием постоматов. Для компаний, осуществляющих дистанционную торговлю.<br /><br />Характеристики услуги:<ul type="circle"><li>по услуге принимаются только одноместные заказы</li><li>выбранный при оформлении заказа постомат изменить на другой нельзя</li><li>при невозможности использования постоматов осуществляется доставка до ПВЗ СДЭК или «до двери» клиента с изменением тарификации на услугу «Посылка»</li><li>срок хранения заказа в ячейке: 5 дней с момента закладки в постомат</li><li>возможность приема наложенного платежа</li></ul>3 вида ячеек:<ol><li>А (8*38*64 см)— до 5 кг</li><li>В (19*38*64 см) — до 7 кг</li><li>С (41*38*64 см)— до 20 кг</li></ol>',
				'postomat'	=> true
			),
			243 => array(
				'title'		=> 'Китайский экспресс',
				'group_id'	=> 2,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Услуга по доставке из Китая в Россию, Белоруссию и Казахстан.<br /><br />Стоимость разбита по интервалам:<ul type="circle"><li>до 200 гр;</li><li>каждые последующие 100 гр до 1 кг;</li><li>каждый последующий 1кг свыше 1 кг.</li></ul>',
			),
			245 => array(
				'title'		=> 'Китайский экспресс',
				'group_id'	=> 2,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Услуга по доставке из Китая в Россию, Белоруссию и Казахстан.<br /><br />Стоимость разбита по интервалам:<ul type="circle"><li>до 200 гр;</li><li>каждые последующие 100 гр до 1 кг;</li><li>каждый последующий 1кг свыше 1 кг.</li></ul>',
			),
			246 => array(
				'title'		=> 'Китайский экспресс',
				'group_id'	=> 2,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Услуга по доставке из Китая в Россию, Белоруссию и Казахстан.<br /><br />Стоимость разбита по интервалам:<ul type="circle"><li>до 200 гр;</li><li>каждые последующие 100 гр до 1 кг;</li><li>каждый последующий 1кг свыше 1 кг.</li></ul>',
			),
			247 => array(
				'title'		=> 'Китайский экспресс',
				'group_id'	=> 2,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Услуга по доставке из Китая в Россию, Белоруссию и Казахстан.<br /><br />Стоимость разбита по интервалам:<ul type="circle"><li>до 200 гр;</li><li>каждые последующие 100 гр до 1 кг;</li><li>каждый последующий 1кг свыше 1 кг.</li></ul>',
			),
			1	=> array(
				'title'		=> 'Экспресс лайт',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('max' => 30),
				'note'      => 'Классическая экспресс-доставка по России документов и грузов'
			),
			3 => array(
				'title'		=> 'Супер-экспресс до 18',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу.'
			),
			5 => array(
				'title'		=> 'Экономичный экспресс',
				'group_id'	=> 3,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Недорогая доставка грузов по России ЖД и автотранспортом (доставка грузов с увеличением сроков).'
			),
			10 => array(
				'title'		=> 'Экспресс лайт',
				'group_id'	=> 3,
				'mode_id'	=> 4,
				'weight'    => array('max' => 30),
				'note'      => 'Классическая экспресс-доставка по России документов и грузов.'
			),
			11 => array(
				'title'		=> 'Экспресс лайт',
				'group_id'	=> 3,
				'mode_id'	=> 3,
				'weight'    => array('max' => 30),
				'note'      => 'Классическая экспресс-доставка по России документов и грузов.'
			),
			12 => array(
				'title'		=> 'Экспресс лайт',
				'group_id'	=> 3,
				'mode_id'	=> 2,
				'weight'    => array('max' => 30),
				'note'      => 'Классическая экспресс-доставка по России документов и грузов.'
			),
			15 => array(
				'title'		=> 'Экспресс тяжеловесы',
				'group_id'	=> 3,
				'mode_id'	=> 4,
				'weight'    => array('min' => 30),
				'note'      => 'Классическая экспресс-доставка по России грузов.'
			),
			16 => array(
				'title'		=> 'Экспресс тяжеловесы',
				'group_id'	=> 3,
				'mode_id'	=> 3,
				'weight'    => array('min' => 30),
				'note'      => 'Классическая экспресс-доставка по России грузов.'
			),
			17 => array(
				'title'		=> 'Экспресс тяжеловесы',
				'group_id'	=> 3,
				'mode_id'	=> 2,
				'weight'    => array('min' => 30),
				'note'      => 'Классическая экспресс-доставка по России грузов.'
			),
			18 => array(
				'title'		=> 'Экспресс тяжеловесы',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('min' => 30),
				'note'      => 'Классическая экспресс-доставка по России грузов.'
			),
			57 => array(
				'title'		=> 'Супер-экспресс до 9',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('max' => 5),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу (доставка за 1-2 суток).'
			),
			58 => array(
				'title'		=> 'Супер-экспресс до 10',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('max' => 5),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу (доставка за 1-2 суток).'
			),
			59 => array(
				'title'		=> 'Супер-экспресс до 12',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('max' => 5),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу (доставка за 1-2 суток).'
			),
			60 => array(
				'title'		=> 'Супер-экспресс до 14',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array('max' => 5),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу (доставка за 1-2 суток).'
			),
			61 => array(
				'title'		=> 'Супер-экспресс до 16',
				'group_id'	=> 3,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Срочная доставка документов и грузов «из рук в руки» по России к определенному часу (доставка за 1-2 суток).'
			),
			62 => array(
				'title'		=> 'Магистральный экспресс',
				'group_id'	=> 3,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Быстрая экономичная доставка грузов по России'
			),
			63 => array(
				'title'		=> 'Магистральный супер-экспресс',
				'group_id'	=> 3,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Быстрая экономичная доставка грузов к определенному часу'
			),
			7 => array(
				'title'		=> 'Международный экспресс документы',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array('max' => 1.5),
				'note'      => 'Экспресс-доставка за/из-за границы документов и писем'
			),
			8 => array(
				'title'		=> 'Международный экспресс грузы',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array('min' => 0.5, 'max' => 30),
				'note'      => 'Экспресс-доставка за/из-за границы грузов и посылок от 0,5 кг до 30 кг.'
			),
			161 => array(
				'title'		=> 'Международный экспресс Внуково VKO',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Внуково г. Москва'
			),
			162 => array(
				'title'		=> 'Международный экспресс Внуково VKO',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Внуково г. Москва'
			),
			163 => array(
				'title'		=> 'Международный экспресс Внуково VKO',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Внуково г. Москва'
			),
			164 => array(
				'title'		=> 'Международный экспресс Внуково VKO',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Внуково г. Москва'
			),
			166 => array(
				'title'		=> 'Международный экспресс Кольцово SVX',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кольцово г. Екатеринбург'
			),
			167 => array(
				'title'		=> 'Международный экспресс Кольцово SVX',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кольцово г. Екатеринбург'
			),
			168 => array(
				'title'		=> 'Международный экспресс Кольцово SVX',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кольцово г. Екатеринбург'
			),
			169 => array(
				'title'		=> 'Международный экспресс Кольцово SVX',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кольцово г. Екатеринбург'
			),
			170 => array(
				'title'		=> 'Международный экспресс Толмачево OVB',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Толмачево г. Новосибирск'
			),
			171 => array(
				'title'		=> 'Международный экспресс Толмачево OVB',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Толмачево г. Новосибирск'
			),
			172 => array(
				'title'		=> 'Международный экспресс Толмачево OVB',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Толмачево г. Новосибирск'
			),
			173 => array(
				'title'		=> 'Международный экспресс Толмачево OVB',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Толмачево г. Новосибирск'
			),
			174 => array(
				'title'		=> 'Международный экспресс Кневичи VVO',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кневичи г. Владивосток'
			),
			175 => array(
				'title'		=> 'Международный экспресс Кневичи VVO',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кневичи г. Владивосток'
			),
			176 => array(
				'title'		=> 'Международный экспресс Кневичи VVO',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кневичи г. Владивосток'
			),
			177 => array(
				'title'		=> 'Международный экспресс Кневичи VVO',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Доставка через аэропорт Кневичи г. Владивосток'
			),
			178 => array(
				'title'		=> 'Международный экспресс грузы',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array('min' => 0.5, 'max' => 30),
				'note'      => 'Экспресс-доставка за/из-за границы грузов и посылок от 0,5 кг до 30 кг.'
			),
			179 => array(
				'title'		=> 'Международный экспресс грузы',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array('min' => 0.5, 'max' => 30),
				'note'      => 'Экспресс-доставка за/из-за границы грузов и посылок от 0,5 кг до 30 кг.'
			),
			180 => array(
				'title'		=> 'Международный экспресс грузы',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array('min' => 0.5, 'max' => 30),
				'note'      => 'Экспресс-доставка за/из-за границы грузов и посылок от 0,5 кг до 30 кг.'
			),
			181 => array(
				'title'		=> 'Международный экспресс документы',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array('max' => 1.5),
				'note'      => 'Экспресс-доставка за/из-за границы документов и писем'
			),
			182 => array(
				'title'		=> 'Международный экспресс документы',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array('max' => 1.5),
				'note'      => 'Экспресс-доставка за/из-за границы документов и писем'
			),
			183 => array(
				'title'		=> 'Международный экспресс документы',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array('max' => 1.5),
				'note'      => 'Экспресс-доставка за/из-за границы документов и писем'
			),
			184 => array(
				'title'		=> 'Международный экономичный экспресс',
				'group_id'	=> 4,
				'mode_id'	=> 1,
				'weight'    => array(),
				'note'      => 'Доставка морем'
			),
			185 => array(
				'title'		=> 'Международный экономичный экспресс',
				'group_id'	=> 4,
				'mode_id'	=> 4,
				'weight'    => array(),
				'note'      => 'Доставка морем'
			),
			186 => array(
				'title'		=> 'Международный экономичный экспресс',
				'group_id'	=> 4,
				'mode_id'	=> 3,
				'weight'    => array(),
				'note'      => 'Доставка морем'
			),
			187 => array(
				'title'		=> 'Международный экономичный экспресс',
				'group_id'	=> 4,
				'mode_id'	=> 2,
				'weight'    => array(),
				'note'      => 'Доставка морем'
			)
		);
	}

	private function getWeightText($weight)
	{
		$text = '';

		if (!empty($weight['min'])) {
			$text .= 'от ' . $weight['min'] . ' кг. ';
		}

		if (!empty($weight['max'])) {
			$text .= 'до ' . $weight['max'] . ' кг.';
		}

		return trim($text);
	}

	private function getStores()
	{
		$this->load->model('setting/store');

		$stores = $this->model_setting_store->getStores();
		$stores[] = array('store_id' => 0, 'name' => $this->config->get('config_name'));

		return $stores;
	}

	private function saveTariffList()
	{
		$this->load->model('setting/setting');

		$tariff_list = array(
			'cdek_tariff_list' => $this->getTariffList()
		);

		foreach ($this->getStores() as $key => $store_info) {
			$this->model_setting_setting->editSetting('cdek_tariff_list', $tariff_list, $store_info['store_id']);
		}
	}

	public function uninstall()
	{
		$this->load->model('setting/setting');

		foreach ($this->getStores() as $key => $store_info) {
			$this->model_setting_setting->deleteSetting('cdek_tariff_list', $store_info['store_id']);
		}
	}
}

<?php
class ControllerShippingBB extends Controller {
	private $error = array();

    private function initField($field_name, $default_value = '') {
        if (isset($this->request->post[$field_name])) {
            $this->data[$field_name] = $this->request->post[$field_name];
        } elseif (!is_null($this->config->get($field_name))) {
            $this->data[$field_name] = $this->config->get($field_name);
        } else {
            $this->data[$field_name] = $default_value;
        }
    }

    public function index() {
		$this->language->load('shipping/bb');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		$settings_file = DIR_CATALOG . 'model/shipping/bb.json';
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bb', $this->request->post);		
					
            $this->clear_cache();
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

        $text_strings = array(
            'heading_title',
            'text_enabled',
            'text_yes',
            'text_no',
            'text_disabled',
            'text_all_zones',
            'text_none',
            'text_calc_api',
            'text_manually',
            'text_tariff_zones',
            'text_zone_label',
            'text_add_cost_type_fixed',
            'text_add_cost_type_percent',
            'text_shipping_type_all',
            'text_shipping_type_no_delivery',
            'text_shipping_type_pickup',
            'text_shipping_type_kd',
            'tab_general',
            'text_license_name',
            'text_license_id',
            'text_license_info',
            'text_license_id_hint',
            'text_license_info_hint',
            'text_round_no_round',
            'text_round_integer',
            'text_round_10',
            'text_round_100',
            'text_pvz_select_method',
            'entry_prepaid_pvz_only',
            'entry_cost',
            'entry_calc_type',
            'entry_api_token',
            'entry_api_url',
            'entry_tax_class',
            'entry_status',
            'entry_sort_order',
            'entry_shipping_type',
            'entry_allow_cod',
            'entry_kd_zone_1_cost',
            'entry_kd_zone_2_cost',
            'entry_debug_mode',
            'entry_package_weight',
            'entry_show_icons',
            'entry_free_ship',
            'entry_kd_free_too',
            'entry_free_total',
            'entry_free_total_to',
            'entry_free_total_to_hint',
            'entry_country',
            'entry_round',
            'entry_targetstart',
            'button_save',
            'button_cancel',
            'button_copy_settings',
            'entry_package_height',
            'entry_package_width',
            'entry_package_depth',
            'entry_package_size',
            'entry_package_size_auto',
            'entry_package_size_manual',
            'entry_foreign',
            'entry_currency',
            'entry_insurance',
            'entry_processing_days',
            'entry_delivery_period',
            'entry_delivery_date',
            'entry_fix_delivery_period',
            'entry_total_type',
            'text_free_subtotal',
            'text_free_total',
            'entry_pvz_select_map',
            'entry_pvz_select_list',
            'entry_pvz_select_both',
            'entry_check_weight',
            'entry_yandex_map_key'
        );

        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }

        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

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
			'href'      => $this->url->link('shipping/bb', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/bb', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        $this->initField('bb_calc_type', 0);
        $this->initField('bb_fix_rate', 0);
        $this->initField('bb_rate_option', 0);
        $this->initField('bb_rate_value', 0);
        $this->initField('bb_allow_cod', 0);
        $this->initField('bb_shipping_type', 1);
        $this->initField('bb_api_token');
        $this->initField('bb_sort_order');
        $this->initField('bb_tax_class_id');
        $this->initField('bb_status');
        $this->initField('bb_debug_mode', 0);
        $this->initField('bb_package_weight', 300);
        $this->initField('bb_free_ship', 0);
        $this->initField('bb_kd_free_too', 0);
        $this->initField('bb_free_total', 0);
        $this->initField('bb_free_total_to', 0);
        $this->initField('bb_show_icons', 1);
        $this->initField('bb_package_size_calc_type', 0);
        $this->initField('bb_license_name', $this->config->get('config_owner'));
        $this->initField('bb_license_info');
        $this->initField('bb_tariff_zone_1', 0);
        $this->initField('bb_tariff_zone_2', 0);
        $this->initField('bb_tariff_zone_3', 0);
        $this->initField('bb_tariff_zone_4', 0);
        $this->initField('bb_tariff_zone_5', 0);
        $this->initField('bb_tariff_zone_6', 0);
        $this->initField('bb_tariff_zone_7', 0);
        $this->initField('bb_tariff_zone_8', 0);
        $this->initField('bb_tariff_zone_9', 0);
        $this->initField('bb_country_id', 176);
        $this->initField('bb_round', '');
        $this->initField('bb_package_width', '');
        $this->initField('bb_package_height', '');
        $this->initField('bb_package_depth', '');
        $this->initField('bb_foreign_mode', 0);
        $this->initField('bb_foreign_currency', 'EUR');
        $this->initField('bb_foreign_insurance', 0);
        $this->initField('bb_processing_days', 1);
        $this->initField('bb_show_delivery_period', 1);
        $this->initField('bb_show_delivery_date', 0);
        $this->initField('bb_fix_delivery_period', 5);
        $this->initField('bb_targetstart', '');
        $this->initField('bb_total_type', 0);
        $this->initField('bb_select_pvz', 0);
        $this->initField('bb_check_weight', 1);
        $this->initField('bb_prepaid_pvz_only', 0);

        $yandex_key = '';
        $api_url = 'http://api.boxberry.ru';

        if (file_exists($settings_file)) {
            $json = file_get_contents($settings_file);
            $settings = json_decode($json, true);
            if (array_key_exists('geo_api_key', $settings))
                $yandex_key = $settings['geo_api_key'];
            if (array_key_exists('api_url', $settings))
                $api_url = $settings['api_url'];
        }
        $this->initField('bb_api_url', $api_url);
        $this->initField('bb_yandex_map_key', $yandex_key);

        $this->load->model('localisation/country');
        $this->data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/tax_class');

        $this->data['token'] = $this->session->data['token'];

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        foreach ($this->data['geo_zones'] as $geo_zone) {
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_rate_option', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_calc_type', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_fix_rate', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_rate_value', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_shipping_type', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_allow_cod', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_status', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_free_ship', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_kd_free_too', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_free_total', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_free_total_to', 0);
            $this->initField('bb_' . $geo_zone['geo_zone_id'] . '_fix_delivery_period', 5);
        }

		$this->template = 'shipping/bb.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function clear_cache() {
        $json = array();
        $json['result'] = 'ok';
        $glb = glob(DIR_CACHE . "cache.bb.*");
        if (is_array($glb)) {
            $files = array_filter($glb, 'is_file');
            foreach ($files as $file) unlink($file);
        }
        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));
    }

    public function license() {
        $json = array();
        $json['id'] = '';
        if (isset($this->request->post['license_name'])) {
            $lic_name = trim(strip_tags($this->request->post['license_name']));

            $json['id'] = base64_encode('['.md5(HTTP_CATALOG).'|'.HTTP_CATALOG.'|'.substr($lic_name, 0, 8).']');
            $json['name'] = $lic_name;
        }
        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));
    }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/bb')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if (!$this->request->post['bb_api_token'] || !$this->request->post['bb_yandex_map_key'] || !$this->request->post['bb_api_url']) {
            if ($this->request->post['bb_status'])
                $this->error['warning'] = $this->language->get('error_key');
        }
        if (!(isset($this->request->post['bb_license_info'])) || ($this->request->post['bb_license_info'] == ''))
            $this->error['warning'] = $this->language->get('error_no_license');

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
<?php
class ControllerCheckoutBB extends Controller {
    public function index() {}

    private function cmp_func($a, $b) {
        return strcmp(mb_strtoupper($a['Name']), mb_strtoupper($b['Name']));
    }

    public function getPvzMapPoints() {
        $this->load->model('shipping/bb');

        $points = $this->model_shipping_bb->getPVZMapPoints();

        $json = array();
        $om = array();
        $cities = array();

        $om['type'] = 'FeatureCollection';
        $features = array();

        $selected_pvz = (isset($this->session->data['bb_shipping_pvz_id']) && $this->session->data['bb_shipping_pvz_id']) ? $this->session->data['bb_shipping_pvz_id'] : 0;
        $position = array('location' => '55.76, 37.64', 'zoom' => 10);

        foreach($points as $point) {
            $gps = false;
            if (isset($point['Gps'])) {
                $gps = $point['Gps'];
            }
            if (isset($point['GPS'])) {
                $gps = $point['GPS'];
            }
            if (!$gps) continue;
	    $gps = preg_replace('/\s/', '', $gps);

            if (!isset($cities[$point['CityCode']])) {
                $cities[$point['CityCode']] = array('Name' => $point['CityName'], 'GPS' => $gps);
            }
            if ($selected_pvz && $point['Code'] === $selected_pvz) {
                $position['location'] = $gps;
                $position['zoom'] = 15;
            }
            $feature = array();
            $feature['type'] = 'Feature';
            $feature['id'] = $point['Code'];
            $geometry = array();
            $geometry['type'] = 'Point';
            $geometry['coordinates'] = explode(',', $gps);
            $feature['geometry'] = $geometry;
            $properties = array();
            $properties['pvz_id'] = $point['Code'];
            $pvz_name_arr = explode('_', $point['Name']);
            $properties['pvz_name'] = empty($pvz_name_arr) ? $point['Name'] : $pvz_name_arr[0];
            $properties['pvz_addr'] = $point['Address'];
            $properties['phone'] = $point['Phone'];
            $properties['cod'] = ($point['OnlyPrepaidOrders'] == 'No') ? 0 : 1;
            $properties['no_kd'] = isset($point['NalKD']) ? ($point['NalKD'] == 'No') : '';
            $schedule = array_key_exists('WorkSchedule', $point) ? $point['WorkSchedule'] : $point['WorkShedule'];
            $properties['work'] = $schedule;
            $properties['zone'] = $point['TariffZone'];
            $properties['city'] = $point['CityCode'];
	    $properties['period'] = $point['DeliveryPeriod'];
            $feature['properties'] = $properties;
            $features[] = $feature;
        }

        usort($cities, array($this, "cmp_func"));
        $ret = '<ul style="-webkit-padding-start: 10px; list-style: none;">';
        foreach($cities as $key=>$city) {
            $ret .= '<li style="margin-bottom: 1em;"><a href="#" style="outline:none; text-transform: uppercase; cursor: pointer; text-decoration: none;font-size: 18px;" data-city="'.$key.'" data-gps="'.$city['GPS'].'" class="select-city-anchor">'.$city['Name'].'</a></li>';
        }
        $ret .= '</ul>';

        $om['features'] = $features;
        $json['om'] = $om;
        $json['cities'] = $ret;

        if (!$selected_pvz) {
            $position = $this->model_shipping_bb->getGeoCodingData();
        }
        $json['position'] = $position;

        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));

    }

    public function select_pvz() {
        $json = array();
        $pvz_id = isset($this->request->get['pvz_id']) ? $this->request->get['pvz_id'] : 0;
        $json['skip'] = 1;
        $json['id'] = $pvz_id;
        if ($pvz_id) {
            $this->load->model('shipping/bb');
            $result = $this->model_shipping_bb->getPVZById($pvz_id, true);
            if ($result) {
                $this->session->data['bb_shipping_pvz_id'] = $pvz_id;
                $this->session->data['bb_shipping_city_id'] = $result['CityCode'];
                $this->session->data['bb_shipping_typed_city'] = $result['CityName'];
                $this->session->data['bb_shipping_typed_zone_id'] = $this->model_shipping_bb->getZoneIdByName($result['Area']);
                $this->session->data['bb_shipping_office_addr1'] = $result['Address'];
                $schedule = array_key_exists('WorkSchedule', $result) ? $result['WorkSchedule'] : $result['WorkShedule'];
                $this->session->data['bb_shipping_office_addr2'] = $result['Phone'].', '.$schedule;
                $json['city'] = $this->session->data['bb_shipping_typed_city'];
                $json['zone_id'] = $this->session->data['bb_shipping_typed_zone_id'];
                $json['addr1'] = $result['AddressReduce'];
                $json['skip'] = 0;
            }
            else
                $json['id'] = 0;
        }
        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));
    }
}
?>
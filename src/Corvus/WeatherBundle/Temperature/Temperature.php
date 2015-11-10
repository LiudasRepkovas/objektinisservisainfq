<?php

namespace Corvus\WeatherBundle\Temperature;

class Temperature
{
    private $target = 'https://api.forecast.io/forecast/';
    private $api_key;

    public function set_key($api_key){
        $this->api_key = $api_key;
    }

    private function request($latitude, $longitude, $time = null, $options = array())
    {
        $request_url = $this->target
            . $this->api_key
            . '/'
            . $latitude
            . ','
            . $longitude
            . ((is_null($time)) ? '' : ','. $time);
        if (!empty($options)) {
            $request_url .= '?'. http_build_query($options);
        }

        $response = json_decode(file_get_contents($request_url));
        $response->headers = $http_response_header;
        return $response;
    }

    public function get($latitude, $longitude, $time = null, $options = array())
    {
        return $this->request($latitude, $longitude, $time, $options);
    }

    public function get_current_temperature($latitude, $longitude, $time = null, $options = array()){
        return $this->request($latitude, $longitude, $time, $options)->currently->temperature;
    }
}

<?php

namespace Modules\Weather\Block;

use Magento\Framework\View\Element\Template;

class WeatherBlock extends Template
{
  public function getText() {
        return "Hello World";
  }

  public function __construct(\Magento\Framework\View\Element\Template\Context $context) {
  		parent::__construct($context);
  }
  public function getWeatherInfoIn($cityName): array
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://api.weatherapi.com/v1/current.json?key=96eec83018d7446c844151444240612&q=$cityName&aqi=no");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);

    $data = json_decode($result, TRUE);
    curl_close($curl);
    $res['name'] = $data['location']['name'];
    $res['cond'] = $data['current']['condition']['icon'];
    $res['temp'] = round($data['current']['temp_c'], 1);
    $res['wind'] = $data['current']['wind_kph'];
    $res['clouds'] = $data['current']['cloud'];
    $res['humidity'] = $data['current']['humidity'];
    return $res;
  }
}

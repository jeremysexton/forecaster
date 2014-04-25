<?php
class Plugin_forecaster extends Plugin {
	
	var $meta = array(
		'name' => 'Forecaster',
		'description' => 'A Statamic plugin to retrieve weather information from Forecast.io',
		'version' => '1.0',
		'author' => 'Jeremy Sexton',
		'author_url' => 'http://jeremysexton.net',
		'author_twitter' => '@jeremysexton'
	);
	
	public function index() {
	
		$api_key = $this->config["api_key"]; // Replace with your own Forecast API Key
		$api_start = "https://api.forecast.io/forecast/";
		$lat = $this->fetchParam('latitude', $this->config["default_lat"]);
		$long = $this->fetchParam('longitude', $this->config["default_long"]);
		$date = $this->fetchParam('date', null);
		$time = $this->fetchParam('time', null);
		$units = $this->fetchParam('units', $this->config["default_units"]);

		$date = strtotime($date);
		$time = strtotime($time);
		
		if ($date != "") {
					
			$url = $api_start.$api_key."/".$lat.",".$long.",".$date."T".$time."?units=".$units."&exclude=daily,minutely,hourly,alerts,flags";
			
		} else {
			
			$url = $api_start.$api_key."/".$lat.",".$long."?units=".$units."&exclude=daily,minutely,hourly,alerts,flags";
			
		}
				
		$data = file_get_contents($url);
		$results = json_decode($data, TRUE);
		
		$results = $results["currently"];
		
		return $results;
	
	}
	
}
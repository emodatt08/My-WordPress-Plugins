<?php

class Weather_Widget extends WP_Widget {

	private $url;
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$this->url = "http://api.weatherapi.com/v1/current.json";
		$widget_ops = array( 
			'classname' => 'weather_domain',
			'description' => 'Get Weather Project',
		);
		parent::__construct( 'weather_widget', 'Weather Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		//get and set values 	
		$instance = [
			'country' => (!empty($instance['country'])) ? strip_tags($instance['country']) : '',
			'region' => (!empty($instance['region'])) ? strip_tags($instance['region']) : '',
			'coordinates' => (!empty($instance['latitude'])) ? strip_tags($instance['latitude'].",".$instance['longitude']) : '',
			'temp' => (!empty($instance['temp_type']) && $instance['temp_type'] == "celsius") ? "temp_c" : 'temp_f',
			'alerts' => $instance['show_alerts'] ? true : false,
			'env' => (!empty($instance['env'])) ? strip_tags($instance['env']) : '',
			'use_geolocation' => (!empty($instance['use_geolocation'])) ? strip_tags($instance['use_geolocation']) : '',
		];

			
		echo $args['before_widget'];

		$weather = $this->getWeather($instance);
		echo $weather;
			
        ?>

			
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
        //Call form function
        return $this->getForm($instance);
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        return $this->getUpdateForm($new_instance, $old_instance);
	}

	private function getUpdateForm($new_instance, $old_instance){
		$instance = [
				'country' => (!empty($new_instance['country'])) ? strip_tags($new_instance['country']) : '',
				'region' => (!empty($new_instance['region'])) ? strip_tags($new_instance['region']) : '',
                'latitude' => (!empty($new_instance['latitude'])) ? strip_tags($new_instance['latitude']) : '',
                'longitude' => (!empty($new_instance['longitude'])) ? strip_tags($new_instance['longitude']) : '',
				'temp_type' => (!empty($new_instance['temp_type'])) ? strip_tags($new_instance['temp_type']) : '',
				'show_alerts' => (!empty($new_instance['show_alerts'])) ? strip_tags($new_instance['show_alerts']) : '',
				'use_geolocation'=>(!empty($new_instance['use_geolocation'])) ? strip_tags($new_instance['use_geolocation']) : '',
				'env'=>(!empty($new_instance['env'])) ? strip_tags($new_instance['env']) : ''
		];

		return $instance;
	}

    /**
     * Gets and Displays the form
     *
     * @param [type] $instance
     * @return void
     */
    private function getForm($instance){
        $country = $instance['country'];
        $region = $instance['region'];
        $latitude = $instance['latitude'];
        $longitude = $instance['longitude'];
		$temp_type = $instance['temp_type'];
		$use_geolocation = $instance['use_geolocation'];
		$env = $instance['env'];
       
        ?>
          	<p>
            <label for="<?php echo $this->get_field_id('latitude'); ?>"><?php _e('Latitude: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('latitude'); ?>" name="<?php echo $this->get_field_name('latitude'); ?>" value="<?php echo esc_attr($latitude); ?>" class="widefat">
            </p>

			<p>
            <label for="<?php echo $this->get_field_id('longitude'); ?>"><?php _e('Longitude: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('longitude'); ?>" name="<?php echo $this->get_field_name('longitude'); ?>" value="<?php echo esc_attr($longitude); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('country'); ?>"><?php _e('Country: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('country'); ?>" name="<?php echo $this->get_field_name('country'); ?>" value="<?php echo esc_attr($country); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('region'); ?>"><?php _e('Region: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('region'); ?>" name="<?php echo $this->get_field_name('region'); ?>" value="<?php echo esc_attr($region); ?>" >
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('temp_type'); ?>"><?php _e('Temperature Type: '); ?></label><br>
                <select class="widefat" name="<?php echo $this->get_field_name('temp_type'); ?>" id="<?php echo $this->get_field_id('temp_type'); ?>">
                    <option value="<?php echo esc_attr("fahrenheit"); ?>" <?php echo ($temp_type =="fahrenheit") ? "selected":""; ?> >   <?php echo __('Fahrenheit'); ?></option>
                    <option value="<?php echo esc_attr("celsius"); ?>" <?php echo ($temp_type =="celsius") ? "selected":""; ?> >   <?php echo __('Celsius'); ?></option>
                </select>
            </p>

			<p>
			<label for="<?php echo $this->get_field_id('env'); ?>"><?php _e('Environment(Development or Live): '); ?></label><br>
                <select class="widefat" name="<?php echo $this->get_field_name('env'); ?>" id="<?php echo $this->get_field_id('env'); ?>">
                    <option value="<?php echo esc_attr("live"); ?>" <?php echo ($env =="live") ? "selected":""; ?> >   <?php echo __('Live'); ?></option>
                    <option value="<?php echo esc_attr("test"); ?>" <?php echo ($env =="test") ? "selected":""; ?> >   <?php echo __('Test'); ?></option>
                </select>
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('show_alerts'); ?>"><?php _e('Show Alerts?: '); ?></label><br>
                <input type="checkbox" <?php checked($instance['show_alerts'], 'on'); ?> id="<?php echo $this->get_field_id('show_alerts'); ?>" name="<?php echo $this->get_field_name('show_alerts'); ?>"  class="checkbox">
			</p>
			
			<p>
            <label for="<?php echo $this->get_field_id('use_geolocation'); ?>"><?php _e('Use Geolocation?: '); ?></label><br>
                <input type="checkbox" <?php checked($instance['use_geolocation'], 'on'); ?> id="<?php echo $this->get_field_id('use_geolocation'); ?>" name="<?php echo $this->get_field_name('use_geolocation'); ?>"  class="checkbox">
            </p>

			

        <?php
    }


	/**
	 * Fetch Data With Curl
	 *
	 * @param [type] $url
	 * @return void
	 */
	public function fetch($data_array){

				$url = $this->setUrl($data_array);
		
      
				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				));

				$response = curl_exec($curl);

				curl_close($curl);
				// echo "<pre>";
				// var_dump($url, $response); die;
				return $response;

         }
		 /**
		  * Get Github Repos via curls
		  *
		  * @param [type] $title
		  * @param [type] $username
		  * @param [type] $count
		  * @return void
		  */
		 private function getWeather($data_array){
				if($data_array['use_geolocation'] == "on"){
					$geoplugin = new geoPlugin();
					$geoplugin->locate( ($data_array['env'] == "test") ? "41.210.13.250":"" );
					$data_array['country'] = str_replace(" ", "%20",$geoplugin->countryName);
					$data_array['region'] = str_replace(" ", "%20",$geoplugin->regionName);
					$data_array['coordinates'] = $geoplugin->latitude.",".$geoplugin->longitude;

				}
				// echo "<pre>";
				// print_r($data_array); die;
				$weatherReportResponse = $this->fetch($data_array);
				$output = "";
				if(isset($weatherReportResponse)){
					$weather = json_decode($weatherReportResponse);
					// echo "<pre>";
					// print_r($data_array); die;
					?>
						<ul class="repos"> 
							<li>
							
							<div class="weather"><strong><?php echo __("State: ", "weather_domain" )?> </strong><?php echo $weather->location->name; ?> </div>
							<div class="weather"><strong><?php echo __("Condition: ", "weather_domain" )?> </strong><?php echo $weather->current->condition->text; ?> <img class="weather-icon" src="<?php echo $weather->current->condition->icon; ?>"></div>		
							<div class="weather"><strong><?php echo __("Region: ", "weather_domain" )?> </strong><?php echo $weather->location->region; ?></div>
							<div class="weather"><strong><?php echo __("Timezone: ", "weather_domain" )?> </strong><?php echo  $weather->location->tz_id; ?></div>
							<div class="weather"><strong><?php echo __("Time: ", "weather_domain" )?> </strong><?php echo $weather->location->localtime; ?></div>
							<div class="weather"><?php echo ($data_array['temp'] == "temp_c") ?  __("Celsius: ", "weather_domain" ). $weather->current->temp_c."°C" : __("Fahrenheit: ", "weather_domain" ).$weather->current->temp_f."°F"; ?></div>
							<div class="weather"><?php echo ($weather->current->is_day) ? __("Period: Day", "weather_domain" ) : __("Period: Night", "weather_domain" ) ; ?></div>
							
							</li>
						</ul>

					<?php
					
								
				}

			
				return $output;
		 }
		 /**
		  * Set URL Query
		  */
		 private function setUrl($data){
			 $weather_options = get_option("weather_settings");
			 return $this->url."?key=".$weather_options['weather_api_key'].
			 "&q=".$data['country']."&q=".$data['region']."&q=".$data['coordinates']."&q=".$data['temp'].
			 "&alerts=".$data['alerts'];
		 }

  
}
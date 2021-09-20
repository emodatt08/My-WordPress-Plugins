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
		$instance = [
			'country' => (!empty($instance['country'])) ? strip_tags($instance['country']) : '',
			'region' => (!empty($instance['region'])) ? strip_tags($instance['region']) : '',
			'latitude' => (!empty($instance['latitude'])) ? strip_tags($instance['latitude']) : '',
			'longitude' => (!empty($instance['longitude'])) ? strip_tags($instance['longitude']) : '',
			'temp_type' => (!empty($instance['temp_type'])) ? strip_tags($instance['temp_type']) : '',
			'show_alerts' => (!empty($instance['show_alerts'])) ? strip_tags($instance['show_alerts']) : '',
		];
			//get and set values 	
			// echo $args['before_widget'];
			

			// if(isset($instance['title'])){
			// 	$title = apply_filters('widget_title', $instance['title']);
			// 	echo $args['before_title'].$title.$args['after_title'];
			// }else{
			// 	$title = "Chat";
			// }	
			

			// if(isset($instance['username'])){
			// 	$username = esc_attr($instance['username']);
			// }else{
			// 	$username = "emodatt08";
			// }

			// if(isset($instance['count'])){
			// 	$count = esc_attr($instance['count']);
			// }else{
			// 	$count = 2;
			// }
		
			// //show repos
			$weather = $this->getWeather($instance);
			

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
                <select class="widefat" name="<?php echo $this->get_field_id('temp_type'); ?>" id="<?php echo $this->get_field_id('temp_type'); ?>">
                    <option value="<?php echo esc_attr("fahrenheit"); ?>" <?php echo ($temp_type =="fahrenheit") ? "selected":""; ?>> <?php echo __('Fahrenheit'); ?></option>
                    <option value="<?php echo esc_attr("celsius"); ?> <?php echo ($temp_type =="celsius") ? "selected":""; ?>"><?php echo __('Celsius'); ?></option>
                </select>
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('show_alerts'); ?>"><?php _e('Show Alerts?: '); ?></label><br>
                <input type="checkbox" <?php checked($instance['show_alerts'], 'on'); ?> id="<?php echo $this->get_field_id('show_alerts'); ?>" name="<?php echo $this->get_field_name('show_alerts'); ?>"  class="checkbox">
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
		$url = $this->url."?key".$weather_options['weather_api_key'];
        $agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36";
 
             $curl = curl_init();
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($curl, CURLOPT_HEADER, false);
             curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
             curl_setopt($curl, CURLOPT_URL, $url);
             curl_setopt($curl, CURLOPT_REFERER, $url);
             //curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
             curl_setopt($curl, CURLOPT_USERAGENT, $agent);
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
             $response = curl_exec($curl);
             curl_close($response);
            //var_dump($str, $url); die;
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
			 
			$repos = $this->fetch($data_array);
			if(isset($repos)){
				$repos = json_decode($repos);
				$output = '<ul class="repos"> ';

				foreach($repos as $repo){
					$output .= '<li>
					<div class="repo-title">"'.$repo->name.'" </div>
					<div class="repo-desc">"'.$repo->description.'" </div>
					<a href="'.$repo->html_url.'" target="_blank"> See More </a>
					</li>';
				}

				$output .= '</ul>';
			}


			
		 }

  
}
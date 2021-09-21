<?php
/**
 * Plugin Name: AppsMo Weather Project
 * Description: Enables a user to get the weather report
 * Version: 1.2
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
    exit;
}
  //Global options variable
  $weather_options = get_option('weather_settings');
 //Load scripts
 if(is_admin()){
    require_once(plugin_dir_path(__FILE__).'/includes/weather-settings.php');
 }
 require_once(plugin_dir_path(__FILE__).'/includes/geoplugin.class.php');
 require_once(plugin_dir_path(__FILE__).'/includes/weather-scripts.php');
 require_once(plugin_dir_path(__FILE__).'/includes/weather-widget.php');


 function register_weather_projects(){
     register_widget('Weather_Widget');
 }

 add_action('widgets_init', "register_weather_projects");
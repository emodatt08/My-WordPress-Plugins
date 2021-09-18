<?php
/**
 * Plugin Name:AppsMo Youtube Videos
 * Description: Enables users to get Youtube videos into their wordpress app
 * Version: 1.0
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
    exit;
}


 //Load js and css scripts
 require_once(plugin_dir_path(__FILE__).'/includes/youtube-scripts.php');
 //load shortcode
 require_once(plugin_dir_path(__FILE__).'/includes/youtube-shortcode.php');

 if(is_admin()){
     //Load custom post types
    require_once(plugin_dir_path(__FILE__).'/includes/youtube-cpt.php');
    //load input fields
    require_once(plugin_dir_path(__FILE__).'/includes/youtube-fields.php');
 }

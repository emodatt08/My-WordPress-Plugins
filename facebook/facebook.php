<?php

/**
 * Plugin Name: AppsMo Facebook Footer Link
 * Description: Adds a facebook profile link to the end of posts
 * Version: 1.5
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
     exit;
 }

  //Global options variable
  $ffl_options = get_option('ffl_settings');
 //Load Scripts
 require_once(plugin_dir_path(__DIR__).'/facebook/includes/facebook-footer-scripts.php');
 //Load Contents
 require_once(plugin_dir_path(__DIR__).'/facebook/includes/facebook-footer-links-content.php');
 if(is_admin()){
  //Load Settings
  require_once(plugin_dir_path(__DIR__).'/facebook/includes/facebook-footer-links-settings.php');
 }
 
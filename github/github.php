<?php
/**
 * Plugin Name: AppsMo GitHub Projects
 * Description: Enables a user to list their github projects via a widget
 * Version: 1.2
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
    exit;
}

 //Load scripts
 require_once(plugin_dir_path(__FILE__).'/includes/github-scripts.php');
 require_once(plugin_dir_path(__FILE__).'/includes/github-class.php');


 function register_github_projects(){
     register_widget('GitHub_Widget');
 }

 add_action('widgets_init', "register_github_projects");
<?php
/**
 * Plugin Name: AppsMo NewsLetter Subscriptions
 * Description: Gives the ability to receive newsletter subscription and email them to users
 * Version: 1.2
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
    exit;
}

 //Load scripts
 require_once(plugin_dir_path(__FILE__).'/includes/news-letter-scripts.php');
 require_once(plugin_dir_path(__FILE__).'/includes/news-letter-class.php');


 function register_newsletter_subscriber(){
     register_widget('Newsletter_Subscriber_Widget');
 }

 add_action('widgets_init', "register_newsletter_subscriber");
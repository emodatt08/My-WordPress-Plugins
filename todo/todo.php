<?php
/**
 * Plugin Name:AppsMo Todo List
 * Description: Enables users to add todo lists easily
 * Version: 1.7
 * Author: Sadat Hillary Kollan
 * Company: AppsMo Ventures
 */

 //Exit if accessed directly
 if(!defined('ABSPATH')){
     exit;
 }

 //Load scripts
 require_once(plugin_dir_path(__FILE__).'/includes/todo-scripts.php');
 //load shortcode
 require_once(plugin_dir_path(__FILE__).'/includes/todo-list-shortcode.php');

 if(is_admin()){
     //Load custom post types
    require_once(plugin_dir_path(__FILE__).'/includes/todo-list-cpt.php');
    //load input fields
    require_once(plugin_dir_path(__FILE__).'/includes/todo-list-fields.php');
 }

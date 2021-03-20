<?php
/**
 * Add main scripts
 *
 * @return void
 */
function ffs_add_scripts(){
    wp_enqueue_style('ffs-main-style', plugins_url().'/facebook/css/style.css');
    wp_enqueue_script('ffs-main-script', plugins_url().'/facebook/js/main.js');
}


add_action('wp_enqueue_scripts', 'ffs_add_scripts');
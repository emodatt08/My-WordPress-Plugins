<?php
//if admin add scripts
if(is_admin()){
function yt_admin_add_scripts(){
        wp_enqueue_script('yt-admin-main-script', plugins_url().'/youtube/js/youtube.js', array('jquery'));
        wp_enqueue_style('yt-admin-main-style', plugins_url().'/youtube/css/styleAdmin.css');
    }
    add_action('admin_init','yt_admin_add_scripts');
}

//Add scripts
function yt_add_scripts(){
    wp_enqueue_script('yt-main-script', plugins_url().'/youtube/js/youtube.js', array('jquery'));
    wp_enqueue_style('yt-main-style', plugins_url().'/youtube/css/style.css');
}
add_action('wp_enqueue_scripts','yt_add_scripts');
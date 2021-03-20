<?php

function nl_add_scripts(){
    wp_enqueue_style('nl-main-style', plugins_url().'/appsmo_newsletter/css/style.css');
    wp_enqueue_script('nl-main-script', plugins_url().'/appsmo_newsletter/js/script.js', ['jquery']);
}

add_action('wp_enqueue_scripts', 'nl_add_scripts');
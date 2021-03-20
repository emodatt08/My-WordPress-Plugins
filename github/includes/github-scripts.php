<?php

function gt_add_scripts(){
    wp_enqueue_style('gt-main-style', plugins_url().'/github/css/style.css');
    wp_enqueue_script('gt-main-script', plugins_url().'/github/js/script.js', ['jquery']);
}

add_action('wp_enqueue_scripts', 'gt_add_scripts');
<?php
//for only admins
if(is_admin()){
    function td_add_admin_scripts(){
        wp_enqueue_style('td-main-admin-style', plugins_url().'/todo/style/style-admin.css');
    }
    
    add_action('admin_init','td_add_admin_scripts');
}

function td_add_scripts(){
    wp_enqueue_script('td-main-script', plugins_url().'/todo/js/script.js');
    wp_enqueue_style('td-main-style', plugins_url().'/todo/style/style.css');
}
add_action('wp_enqueue_scripts','td_add_scripts');
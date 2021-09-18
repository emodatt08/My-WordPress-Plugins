<?php


function yt_register_video(){
    $singular_name = apply_filters('yt_label_single', 'Video');
    $plural_name = apply_filters('yt_label_plural', 'Videos');
    
    $labels = [
        'name'          => $plural,
        'singular_name' => $singular,
        'add_new'       => 'Add New',
        'add_new_item'  => 'Add New '. $singular,
        'edit'          => 'Edit '. $singular,
        'new_item'      => 'New '. $singular,
        'view'          => 'View',
        'view_item'     => 'View '. $singular,
        'search_items'  => 'Search '. $plural,
        'not found'     =>  'No '.$plural. ' found',
        'not_found_in_trash' => 'No '.$plural. ' found',
        'menu_name'     => $plural
    ];

    $args = apply_filters('yt_videos_args', [
        'labels'        => $labels,
        'description'   => $plural.' by category',
        'taxonomies'    => ['category'],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-video-alt',
        'show_in_nav_menus' => true,
        'query_var'     => true,
        'can_export'    => true,
        'rewrite'       => ['slug' => 'youtube'],
        'capability_type'  =>  'post',
        'supports'      => ['title']

    ]);

    register_post_type('video', $args);
}

add_action('init', 'yt_register_video');
<?php

///create custom post types
//todo because its our custom post type

function td_register_todo(){
    $singular = apply_filters('td_label_single', 'Todo');
    $plural = apply_filters('td_label_plural', 'Todos');

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

    $args = apply_filters('td_args', [
        'labels'        => $labels,
        'description'   => $plural.' by category',
        'taxonomies'    => ['category'],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-edit',
        'show_in_nav_menus' => true,
        'query_var'     => true,
        'can_export'    => true,
        'rewrite'       => ['slug' => 'todo'],
        'capability_type'  =>  'post',
        'supports'      => ['title']

    ]);

    //register post type
    register_post_type('todo', $args);

}

add_action('init', 'td_register_todo');
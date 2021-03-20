<?php


/**
 * Shortcode for listing todos
 *
 * @param [type] $atts
 * @param [type] $content
 * @return void
 */
function td_list_todos($atts, $content = null){
    global $post;
    //creating attributes and defaults
    $atts = shortcode_atts([
        'title'     => 'AppsMo Todos',
        'count'     => 10,
        'category'  => 'all'
    ], $atts);
        //check category query 
    if($atts['category'] == "all"){
        $terms = '';
    }else{
        $terms = [
            [
                'taxonomy'  => 'category',
                'field'     => 'slug',
                'terms'     => $atts['category']
            ]
        ];
    }


    //args
    $args = [
        'post_type'         => 'todo',
        'post_status'       => 'publish',
        'orderBy'           => 'due_date',
        'order'             => 'ASC',
        'post_per_page'     =>  $atts['count'],
        'tax_query'         => $terms
    ];

    // get all todos
    $todos = new WP_Query($args);
    //check for todos
    if($todos->have_posts()){
        //get category slug
        $category = str_replace('-', ' ', $atts['category']);
        $category = strtolower($category);

        //build output variable
        $output .= '<div class="todo-list">';
        while($todos->have_posts()){
            $todos->the_post();

            //Get Field values
            $priority = get_post_meta($post->ID, 'priority', true);
            $details = get_post_meta($post->ID, 'details', true);
            $due_date = get_post_meta($post->ID, 'due_date', true);

            $output .= '<div class="todo">';
            $output .= '<h4>'.get_the_title().'</h4>';
            $output .= '<div>'.$details.'</div>';
            $output .= '<div class="priority-'.strtolower($priority).'">Priority: '.$priority.'</div>';
            $output.= '<div class="due_date">Due Date: '.$due_date.'</div>';
            $output .=  '</div>';
        }
        $output .= '<div><br>';

        //Reset Post Data
        wp_reset_postdata();
        return $output;
    }else{
        return '<p>No Todos</p>';
    }
}


//cast shortcode
add_shortcode('todos', 'td_list_todos');
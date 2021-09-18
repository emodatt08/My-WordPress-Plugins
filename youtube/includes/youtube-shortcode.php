<?php
/**
 * Function to list the videos
 *
 * @param [type] $atts
 * @param [type] $content
 * @return void
 */
function yt_list_videos($atts, $content=null){
    global $post;
    $atts = shortcode_atts([
        'title' => 'Video gallery',
        'count' => 20,
        'category' => 'all'
    ]);

    //check category with the short code
    if($atts['category'] == 'all'){
        $terms = '';
    }else{
        $terms = [
            [
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $atts['category']
            ]
            ];
    }
    //Query Args
    $args = [
        'post_type'     => 'video',
        'post_status'   => 'publish',
        'orderby'       => 'created',
        'order'         => 'DESC',
        'posts_per_page'=> $atts['count'],
        'tax_query'     => $terms
];

    //fetch videos
    $videos = new WP_Query($args);
    //check for videos
    if($videos->have_posts()){
        $category = str_replace('-', ' ', $atts['category']);

         //Init Output
         $output = '';
         //Build Output
         $output .= '<div class = "video-list">';
        
         while($videos->have_posts()){
            $videos->the_posts();
             //Get field values
            $video_id = get_post_meta($post->ID, 'video_id', true);
            //Get field values
            $details = get_post_meta($post->ID, 'details', true);

            $output.='<div class="yt-video">';
            $output.= '<h4>'.get_the_title().'</h4>';
            if(get_settings('yt_setting_disable_fullscreen')){
                $output.= ' <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }else{
                $output.= ' <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ></iframe>';
            }
            $output.= '<div>'.$details.'</div>';
            $output.='</div><br></hr>';
         }
        
         $output .= '</div>';
         //reset post data
         wp_reset_postdata();
         return $ouput;
    }else{
       
        return '<p> No videos at the moment </p>';
    }
}

//set shortcode
add_shortcode('videos', "yt_list_videos");
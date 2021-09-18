<?php
function yt_add_fields_metabox(){
    add_meta_box(
        'yt_todo_fields',
        __('Video Fields'),
        'yt_todo_fields_callback',
        'video',
        'normal',
        'default'   
    );
}

add_action('add_meta_boxes', 'yt_add_fields_metabox');
/**
 * CallBack function for fields
 *
 * @param [type] $post
 * @return void
 */
function yt_todo_fields_callback($post){
    $yt_stored_meta = get_post_meta($post->ID);
    ?>
        <div class="wrap video-form">
            <div class="form-group">
                <label for="video-id" class="video-id">
                    <?php esc_html_e('Video ID', 'yt_domain'); ?>
                </label>
                <input type="text" name="video_id" id="video-id" value="<?php if(!empty( $yt_stored_meta['video_id'])) echo esc_attr($yt_stored_meta['video_id'][0]) ; ?>">
            </div>

            <div class="form-group">
                <label for="video-id" class="video-id">
                    <?php esc_html_e('Details', 'yt_domain'); ?>
                </label>
                <?php
                    $content = get_post_meta($post->ID, 'details', true);
                    $editor = 'details';
                    $settings = ['textarea_rows' => 5, 'media_buttons' => false];
                    $wp_editor($content, $editor, $settings);
                ?>
            </div>

            <?php if($yt_stored_meta['video_id'][0]){
                $video_id = esc_attr($yt_stored_meta['video_id'][0]);
                ?>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php } ?>


        </div>
    <?php

     // Use nonce for verification
     wp_nonce_field(plugin_basename( __FILE__ ), 'wpse28342' );
}

function yt_video_save($post_id){
    if ( !wp_verify_nonce( $_POST['wpse28342'], plugin_basename( __FILE__ ) ) ){

        return;
    }

    if(isset($_POST['video_id'])){
        update_post_meta($post_id, 'video_id', sanitize_text_field($_POST['video_id']));
    }
    if(isset($_POST['details'])){
        update_post_meta($post->ID, 'details', sanitize_text_field($_POST['details']));
    }

}
add_action('save_post', 'yt_video_save');


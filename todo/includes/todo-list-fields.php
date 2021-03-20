<?php

function td_add_fields_metabox(){
    add_meta_box(
        'td_todo_fields',
        __('Todo Fields'),
        'td_todo_fields_callback',
        'todo',
        'normal',
        'default'   
    );
}

add_action('add_meta_boxes', 'td_add_fields_metabox');

//callback to display fields meta box content
function td_todo_fields_callback($post){
    //wp_nonce_field(basename(__FILE__), 'wp_todos_nonce');
    $td_stored_meta = get_post_meta($post->ID);
    ?>
        <div class="wrap todo-form">
            <div class="form-group">
                <label for="priority"> <?php esc_html_e('Priority', 'td_domain') ?></label>
                   
                    <select name="priority" id="priority">
                        <?php 
                        $option_val = ['Low', 'Normal', 'High'];
                        foreach($option_val as $key => $value){
                            if($value == $td_stored_meta['priority'][0]){
                                ?>
                                    <option selected value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php
                            }else{
                                ?>
                                    <option  value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php
                            }
                            }
                        
                        
                        ?>
                    </select>
                
            </div>
    

            <div class="form-group">
                <label for="details"> <?php esc_html_e('Details', 'td_domain') ?></label>  
                <?php 
                    $content = get_post_meta($post->ID, 'details',true); 
                    $editor = 'details';
                    $settings = [
                        'textarea_rows' => 5,
                        'media_buttons' => true
                    ];
                    wp_editor($content, $editor, $settings);
                ?>
            </div>


            <div class="form-group">
                <label for="due-date"> <?php esc_html_e('Due Date', 'td_domain') ?></label>
                   
                    <input type="date" name="due_date" id="due_date" value="<?php if(!empty($td_stored_meta['due_date'])) echo esc_attr($td_stored_meta['due_date'][0]); ?>">
                
            </div>
        </div>
    <?php

    // Use nonce for verification
    wp_nonce_field(plugin_basename( __FILE__ ), 'wpse28341' );
}

function td_todos_save($post_id){
    global $post;
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wp_todos_nonce']) && wp_verify_nonce($_POST['wp_todos_nonce'], basename(__FILE__))) ? 'true':'false';
    //var_dump($post_id, $is_autosave,  $is_revision,  $is_valid_nonce); die;
    // if($is_autosave || $is_revision || !$is_valid_nonce ){
    //     return;
    // }

    if ( !wp_verify_nonce( $_POST['wpse28341'], plugin_basename( __FILE__ ) ) ){

        return;
    }
         
    // if ( !wp_verify_nonce( $_POST['wp_todos_nonce'], plugin_basename( __FILE__ ) ) ){
    //     var_dump("Didint", $post->ID, $_POST['wp_todos_nonce'], plugin_basename( __FILE__ ), $_POST['priority'],$_POST['details'], $_POST['due_date']
    // ); die;
    //     return;
    // }
   


    if(isset($_POST['priority'])){
        update_post_meta($post->ID, 'priority', sanitize_text_field($_POST['priority']));
    }
    if(isset($_POST['details'])){
        update_post_meta($post->ID, 'details', sanitize_text_field($_POST['details']));
    }
    if(isset($_POST['due_date'])){
        update_post_meta($post->ID, 'due_date', sanitize_text_field($_POST['due_date']));
    }


    
}


add_action('save_post', 'td_todos_save');
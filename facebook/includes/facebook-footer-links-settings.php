<?php
/**
 * Create menu link
 *
 * @param [type] $content
 * @return void
 */
function ffl_add_options_menu($content){
    add_options_page(
        'Facebook Footer Link Options',
        'Facebook Footer Link',
        'manage_options',
        'ffl-options',
        'ffl_options_content');
}


function ffl_options_content(){

    //Init Options Global
    global $ffl_options;
    ob_start(); ?>
        <div class="wrap">
            <h2><?php _e("Facebook Footer Link Settings", "ffl_domain"); ?></h2>
            <p><?php _e("Settings for the Facebook Footer Link plugin", "ffl_domain"); ?></p>
            <form action="options.php" method="post">
                <?php settings_fields('ffl_settings_group'); ?>
                <table class="form-table">
                    <tbody>

                        <tr>
                            <th scope="row"><label for="ffl_settings[enable]"><?php _e('Enable', 'ffl_domain'); ?> </label></th>
                            <td><input type="checkbox" name="ffl_settings[enable]" id="ffl_settings[enable]" value="1" <?php checked('1', $ffl_options['enable']);?></td>
                            
                        </tr>

                        <tr>
                            <th scope="row"><label for="ffl_settings[facebook_url]"><?php _e('Facebook Profile Url', 'ffl_domain'); ?> </label></th>
                            <td><input type="text" name="ffl_settings[facebook_url]" id="ffl_settings[facebook_url]" value="<?php echo $ffl_options['facebook_url']; ?>" class="regular-text">
                             <p class="description"><?php _e('Enter your Facebook Profile Url', 'ffl_domain'); ?></p></td>

                        </tr>

                        <tr>
                            <th scope="row"><label for="ffl_settings[link_color]"><?php _e('Link Color', 'ffl_domain'); ?> </label></th>
                            <td><input type="text" name="ffl_settings[link_color]" id="ffl_settings[link_color]" value="<?php echo $ffl_options['link_color']; ?>" class="regular-text">
                             <p class="description"><?php _e('Enter a color or Hex value', 'ffl_domain'); ?></p></td>

                        </tr>

                        <tr>
                            <th scope="row"><label for="ffl_settings[show_in_feed]"><?php _e('Show In  Posts feed', 'ffl_domain'); ?> </label></th>
                            <td><input type="checkbox" name="ffl_settings[show_in_feed]" id="ffl_settings[show_in_feed]" value="<?php echo $ffl_options['show_in_feed']; ?>" <?php echo (isset($ffl_options['show_in_feed'])) ? "checked":""; ?> class="regular-text">
                             <p class="description"><?php _e('Show In  Posts feed', 'ffl_domain'); ?></p></td>

                        </tr>
                       
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="submit" id="submit" value="<?php _e('Save Changes', 'ffl_domain'); ?>" class="button button-primary'"></p>
            </form>
        </div>
    <?php 
    echo ob_get_clean();
}


add_action('admin_menu', 'ffl_add_options_menu');

/**
 * Registers Settings to Wordpress admin menu
 *
 * @return void
 */
function ffl_register_settings(){
    register_setting('ffl_settings_group', 'ffl_settings');

}

add_action('admin_init', 'ffl_register_settings');

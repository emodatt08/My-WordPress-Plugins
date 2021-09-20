<?php
/**
 * Create menu link
 *
 * @param [type] $content
 * @return void
 */
function weather_add_options_menu($content){
    add_options_page(
        'AppsMo Weather Settings',
        'Weather Settings',
        'manage_options',
        'weather-options',
        'weather_options_content');
}


function weather_options_content(){

    //Init Options Global
    global $weather_options;
    ob_start(); ?>
        <div class="wrap">
            <h2><?php _e("AppsMo Weather Settings", "weather_domain"); ?></h2>
            <p><?php _e("Settings for Appsmo Weather Widget Plugin", "weather_domain"); ?></p>
            <form action="options.php" method="post">
                <?php settings_fields('weather_settings_group'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="weather_settings[weather_api_key]"><?php _e('Weather API Key', 'weather_domain'); ?> </label></th>
                            <td><input type="text" name="weather_settings[weather_api_key]" id="weather_settings[weather_api_key]" value="<?php echo $weather_options['weather_api_key']; ?>" class="regular-text">
                             <p class="description"><?php _e('Enter your API Key', 'weather_domain'); ?></p></td>
                        </tr>                     
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="submit" id="submit" value="<?php _e('Save Changes', 'weather_domain'); ?>" class="button button-primary'"></p>
            </form>
        </div>
    <?php 
    echo ob_get_clean();
}


add_action('admin_menu', 'weather_add_options_menu');

/**
 * Registers Settings to Wordpress admin menu
 *
 * @return void
 */
function weather_register_settings(){
    register_setting('weather_settings_group', 'weather_settings');

}

add_action('admin_init', 'weather_register_settings');

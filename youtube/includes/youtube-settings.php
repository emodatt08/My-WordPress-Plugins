<?php

function yt_settings_api_init(){
    add_settings_section(
        'yt_setting_section',
        'AppsMo Youtube Vid Gallery Settings',
        'yt_setting_section_callback',
        'reading'
    );

    add_settings_field(
        'yt_setting_disable_fullscreen',
        'Disable FullScreen',
        'yt_setting_disable_fullscreen_callback',
        'reading',
        'yt_setting_section'
    );

    register_setting('reading', 'yt_setting_disable_fullscreen');
}

add_section('admin_init', 'yt_settings_api_init');


function yt_setting_section_callback(){
    echo '<p>Settings For AppsMo Youtube Video Gallery </p>';
}

function yt_setting_disable_fullscreen_callback(){
    echo '<input name="yt_setting_disable_fullscreen" 
    id="yt_setting_disable_fullscreen" type="checkbox" value="1" class="code"
    '.checked(1, get_option('yt_setting_disable_fullscreen_callback'), false).'
    "> ';
}
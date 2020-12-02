<?php

function admin_top_level_menu_bootstrap() {
    $kernlLogoUrl = plugin_dir_url(__FILE__) . "/img/logo.png";
    $kernlLogoUrl = str_replace("/partials/", "", $kernlLogoUrl);
    include plugin_dir_path( __FILE__ ) . '/html/admin_top_level_menu.html.php';
}

function admin_settings_menu_bootstrap() {
    include plugin_dir_path( __FILE__ ) . '/html/admin_settings_menu.html.php';
}

function admin_response_time_ttfb_bootstrap() {
    include plugin_dir_path( __FILE__ ) . '/html/admin_response_time_ttfb_menu.html.php';
}

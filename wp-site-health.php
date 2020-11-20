<?php
/**
 * Plugin Name:       WP Site Health
 * Plugin URI:        https://kernl.us/wp-site-health
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Kernl.us
 * Author URI:        https://kernl.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-site-health
 * Domain Path:       /languages
 */

// If called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

define( 'WP_SITE_HEALTH_VERSION', '1.0.0' );

// Activation bootstrap
// function activate_wp_site_health() {
// 	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-health-activator.php';
// 	Wp_Site_Health_Activator::activate();
// }
// register_activation_hook( __FILE__, 'activate_wp_site_health' );

// // Deactivation bootstrap
// function deactivate_wp_site_health() {
// 	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-health-deactivator.php';
// 	Wp_Site_Health_Deactivator::deactivate();
// }
// register_deactivation_hook( __FILE__, 'deactivate_wp_site_health' );

// Include base plugin class and instantiate
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-health.php';
$plugin = new Wp_Site_Health();
$plugin->run();

?>
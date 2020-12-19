<?php
/**
 * Plugin Name:       WP Site Performance Monitor
 * Plugin URI:        https://kernl.us/wp-site-performance-monitor
 * Description:       The Kernl WP Site Performance Monitor periodically checks your site performance and allows you to track your response time, time to first byte (TTFB), and Lighthouse scores all from your WordPress admin.
 * Version:           1.0.0
 * Author:            Kernl.us
 * Author URI:        https://kernl.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-site-performance-monitor
 * Domain Path:       /languages
 */

// If called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

define( 'KERNL_SPM_WP_SITE_HEALTH_VERSION', '1.0.0' );

// Activation bootstrap
function kernl_spm_activate_wp_site_health() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-performance-monitor-activator.php';
	Wp_Site_Performance_monitor_Activator::activate();
}
register_activation_hook( __FILE__, 'kernl_spm_activate_wp_site_health' );

// Deactivation bootstrap
function kernl_spm_deactivate_wp_site_health() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-performance-monitor-deactivator.php';
	Wp_Site_Performance_monitor_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'kernl_spm_deactivate_wp_site_health' );

// Include base plugin class, partials, and instantiate
require plugin_dir_path( __FILE__ ) . 'admin/partials/wp-site-performance-monitor-admin-display.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-site-performance-monitor.php';
$plugin = new Kernl_Wp_Site_Performance_monitor();
$plugin->run();

?>
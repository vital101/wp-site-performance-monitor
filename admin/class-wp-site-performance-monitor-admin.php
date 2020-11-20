<?php
class Wp_Site_Performance_monitor_Admin {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-site-performance-monitor-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( "{$this->plugin_name}-vue", plugin_dir_url( __FILE__ ) . 'js/lib/vue.js', array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-site-performance-monitor-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function register_menu() {
		add_submenu_page(
			'options-general.php',
			'Site Performance Monitor',
			'Site Performance Monitor',
			'administrator',
			'wp-site-performance-monitor-settings',
			'admin_settings_menu_bootstrap'
		);
	}

}

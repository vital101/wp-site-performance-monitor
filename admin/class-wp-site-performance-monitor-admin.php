<?php
define("KERNL_SPM_INCLUDE_AT_BOTTOM", true);
define("KERNL_SPM_NO_DEPENDENCIES", []);

class Wp_Site_Performance_monitor_Admin {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		// Bootstrap Styles
		$bootstrapPath = plugin_dir_url(__FILE__) . 'css/bootstrap.min.css';
		wp_enqueue_style(
			$this->plugin_name . '-bootstrap',
			$bootstrapPath,
			KERNL_SPM_NO_DEPENDENCIES,
			$this->version,
			'all'
		);
		// Production
		$cssDir = plugin_dir_path( __FILE__ ) . 'js/build/css';
		$cssFiles = scandir($cssDir);
		foreach($cssFiles as $file) {
			if (preg_match('/(commons\..+\.css)/i', $file, $m)) {
				wp_enqueue_style(
					$this->plugin_name,
					plugin_dir_url( __FILE__ ) . "js/build/css/{$file}",
					array($this->plugin_name . '-bootstrap'),
					$this->version,
					'all'
				);

			}
		}
	}

	public function enqueue_scripts() {
		$webpackRuntime = null;
		$commons = null;
		$index = null;

		// Find all the webpack bundle files.
		$jsDir = plugin_dir_path( __FILE__ ) . 'js/build/js';
		$jsFiles = scandir($jsDir);
		foreach($jsFiles as $file) {
			if (strpos($file, 'LICENSE') === false) {
				if (preg_match('/webpack-runtime\..+\.js$/i', $file, $m)) {
					$webpackRuntime = $file;
				}

				if (preg_match('/commons\..+\.js$/i', $file, $m)) {
					$commons = $file;
				}

				if (preg_match('/^index\..+\.js$/i', $file, $m)) {
					$index = $file;
				}
			}
		}

		// Enqueue the webpack scripts
		wp_enqueue_script(
			"{$this->plugin_name}-webpack-runtime",
			plugin_dir_url( __FILE__ ) . "js/build/js/{$webpackRuntime}",
			KERNL_SPM_NO_DEPENDENCIES,
			$this->version,
			KERNL_SPM_INCLUDE_AT_BOTTOM
		);
		wp_enqueue_script(
			"{$this->plugin_name}-commons",
			plugin_dir_url( __FILE__ ) . "js/build/js/{$commons}",
			array(
				"{$this->plugin_name}-webpack-runtime",
			),
			$this->version,
			KERNL_SPM_INCLUDE_AT_BOTTOM
		);
		wp_enqueue_script(
			"{$this->plugin_name}-index",
			plugin_dir_url( __FILE__ ) . "js/build/js/{$index}",
			array(
				"{$this->plugin_name}-webpack-runtime",
				"{$this->plugin_name}-commons"
			),
			$this->version,
			KERNL_SPM_INCLUDE_AT_BOTTOM
		);

		// WP REST API
		$scripts = array(
			"{$this->plugin_name}-webpack-runtime",
			"{$this->plugin_name}-commons",
			"{$this->plugin_name}-index"
		);
		foreach($scripts as $handle) {
			wp_localize_script($handle, 'wpApiSettings', array(
				'root' => esc_url_raw( rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' )
			));
		}
	}

	public function register_menu() {
		add_menu_page(
			'Site Performance Monitor',
			'Site Performance Monitor',
			'administrator',
			'site-performance-monitor',
			'admin_top_level_menu_bootstrap',
			'dashicons-chart-bar'
		);

		// add_submenu_page(
		// 	'site-performance-monitor',
		// 	'Settings',
		// 	'Settings',
		// 	'administrator',
		// 	'wp-site-performance-monitor-settings',
		// 	'admin_settings_menu_bootstrap'
		// );
	}

}

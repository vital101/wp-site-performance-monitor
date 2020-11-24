<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 */
class Kernl_Wp_Site_Performance_monitor {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'WP_SITE_HEALTH_VERSION' ) ) {
			$this->version = WP_SITE_HEALTH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-site-performance-monitor';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-site-performance-monitor-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-site-performance-monitor-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-site-performance-monitor-admin.php';

		$this->loader = new Wp_Site_Performance_monitor_Loader();

	}

	private function set_locale() {
		$plugin_i18n = new Wp_Site_Performance_monitor_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Site_Performance_monitor_Admin( $this->get_plugin_name(), $this->get_version() );

		// Required Scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Menus
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu' );

		// REST API
		add_action( 'rest_api_init', function () {
			register_rest_route('kernl/v1', '/status', array(
				'methods' => 'GET',
				'callback' => array($this, 'status'),
				'permission_callback' => function () {
					return current_user_can('edit_others_posts');
				}
			));
		});
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Site_Performance_monitor_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function status(WP_REST_Request $request) {
        $optionStatus = get_option('kernl-spm-setup-complete', 'false');
        if (!$optionStatus) {
            add_option('kernl-spm-setup-complete', 'false');
		}
        return array(
			"setupComplete" => $optionStatus === 'false' ? false : true
		);
    }

}

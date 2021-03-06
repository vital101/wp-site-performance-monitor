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
		if ( defined( 'KERNL_SPM_WP_SITE_HEALTH_VERSION' ) ) {
			$this->version = KERNL_SPM_WP_SITE_HEALTH_VERSION;
		} else {
			$this->version = '1';
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
				'methods' => 'GET,POST',
				'callback' => array($this, 'status'),
				'permission_callback' => function () {
					return current_user_can('edit_others_posts');
				}
			));

			register_rest_route('kernl/v1', '/site', array(
				'methods' => 'GET,POST',
				'callback' => array($this, 'site'),
				'permission_callback' => function () {
					return current_user_can('edit_others_posts');
				}
			));
		});

		// Add the admin notice if needed.
		$cacheFoundNotice = get_transient('kernl-cache-found-notice');
		if ($cacheFoundNotice) {
			add_action('admin_notices', array($this, 'cacheFoundNotice'));
		}
	}

	public function run() { $this->loader->run(); }
	public function get_plugin_name() { return $this->plugin_name; }
	public function get_loader() { return $this->loader; }
	public function get_version() { return $this->version; }

	public function site(WP_REST_Request $request) {
		if ($request->get_method() == 'GET') {
			return array(
				"siteId" => get_option('kernl-spm-site-id', false)
			);
		}

		if ($request->get_method() == 'POST') {
			$data = $request->get_json_params();
			$siteIdOption = get_option('kernl-spm-site-id', false);
			if (!$siteIdOption) {
				add_option('kernl-spm-site-id', $data["siteId"]);
			} else {
				update_option('kernl-spm-site-id', $data["siteId"]);
			}

			return array(
				"siteId" => get_option('kernl-spm-site-id', false)
			);
		}
	}

	public function status(WP_REST_Request $request) {
		if ($request->get_method() == 'GET') {
			$optionStatus = get_option('kernl-spm-setup-complete', 'false');
			if (!$optionStatus) {
				add_option('kernl-spm-setup-complete', 'false');
			}
			return array(
				"setupComplete" => $optionStatus === 'false' ? false : true
			);
		}

		if ($request->get_method() == 'POST') {
			$optionStatus = get_option('kernl-spm-setup-complete', 'false');
			if (!$optionStatus) {
				add_option('kernl-spm-setup-complete', 'true');
			} else {
				update_option('kernl-spm-setup-complete', 'true');
			}

			return array(
				"setupComplete" => true
			);
		}
	}

	public function cacheFoundNotice() {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<strong>WP Site Performance Monitor: </strong>
				A caching plugin has been detected on your site. In order for WP Site Performance monitor to work correctly, please clear your cache.
			</p>
		</div>
		<?php
	}

}

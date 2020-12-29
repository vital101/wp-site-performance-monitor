<?php

class Wp_Site_Performance_monitor_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-site-performance-monitor',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

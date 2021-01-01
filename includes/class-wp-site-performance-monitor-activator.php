<?php

/**
 * Fired during plugin activation.
 */
class Wp_Site_Performance_monitor_Activator {

	public static function activate() {
		self::setSiteHash();
		self::cacheActivationNotice();
	}

	public static function setSiteHash() {
		// Note: We need to have some sort of exception for local
		//  installs. Basically disable everything if localhost or ip address
		//  This will not work on localhost/127.0.0.1 etc.
		$siteUrl = get_site_url();
		$siteHash = md5("kernl-spm-{$siteUrl}");
		if (!get_option("kernl-site-id", false)) {
			add_option("kernl-site-id", $siteHash);
		}
	}

	public static function cacheActivationNotice() {
		$plugins = get_plugins();
		$cachingPluginFound = false;
		foreach($plugins as $key => $value) {
			$name = strtolower($value['Name']);
			if(strpos($name, 'cache') !== false) {
				$cachingPluginFound = true;
			}
			if(strpos($name, 'hummingbird') !== false) {
				$cachingPluginFound = true;
			}
		}
		if ($cachingPluginFound) {
			set_transient('kernl-cache-found-notice', true, 5);
		}
	}
}

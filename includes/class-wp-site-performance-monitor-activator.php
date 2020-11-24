<?php

/**
 * Fired during plugin activation.
 */
class Wp_Site_Performance_monitor_Activator {

	public static function activate() {
		self::setSiteHash();
	}

	public static function setSiteHash() {
		// Note: We need to have some sort of exception for local
		//  installs. Basically disable everything if localhost or ip address
		//  This will not work on localhost/127.0.0.1 etc.
		$siteUrl = get_site_url();
		$siteHash = md5("kernl-spm-{$siteUrl}");
		if (!get_option("kernl-spm-hash", false)) {
			add_option("kernl-spm-hash", $siteHash);
		}
	}

}

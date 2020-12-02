<?php
/**
 * Fired during plugin deactivation.
 */
class Wp_Site_Performance_monitor_Deactivator {

	public static function deactivate() {
		$siteUrl = get_site_url();
		$siteHash = md5("kernl-spm-{$siteUrl}");
		delete_option("kernl-site-id");
	}
}

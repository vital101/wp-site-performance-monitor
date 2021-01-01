=== WP Site Performance Monitor ===
Contributors: kernl
Tags: performance,monitor,health,response time,ttfb,lighthouse
Requires at least: 5.0
Tested up to: 5.6
Stable tag: 1.0.3
Requires PHP: 7.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Kernl WP Site Performance Monitor periodically checks your site performance and allows you to track your response time, time to first byte (TTFB), and Lighthouse scores all from your WordPress admin.

== Description ==

The [Kernl](https://kernl.us) WP Site Performance Monitor tracks your WordPress site performance all from the comfort of your own WordPress Admin. Easily keep track of:

- Response time - We will check your site's response time every 10 minutes and graph it out over the past 24 hours.
- Time to first byte (TTFB) - In addition to response time, we track TTFB so you know how quickly your site responds initially to requests.
- Lighthouse Scores - The same tool that powers [Google's PageSpeed Insights](https://developers.google.com/speed/pagespeed/insights/) is automatically run against your site once a day.

== Installation ==

1. Install Kernl WP Site Performance Monitor.
2. Activate Kernl WP Site Performance Monitor.
3. Go the `Site Performance Monitor` menu and follow the directions.

== Frequently Asked Questions ==

= Does this cost anything? =

Nope, it's 100% free!

= What happens if I have trouble? =

Use the support forums on WordPress.org or email jack AT kernl.us.

== Screenshots ==

1. The WP Site Performance Monitor dashboard.
2. Response time over the last 24 hours.
3. Time to first byte (TTFB) over the last 24 hours.
4. Google Lighthouse scores for today.

== Changelog ==

= 1.0.3 =
* Adding an admin notice on plugin activation if caching plugins are installed that directs the user to clear their cache.

= 1.0.2 =
* Release 1.0.1 contained a fatal error that prevented the plugin from starting. This resolves it.

= 1.0.1 =
* Upgraded Javascript dependencies.
* Added additional copy if you run into an error while attempting to bootstrap the plugin. It directs the user to clear their cache if one is installed.

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.3 =
Usability improvements for first time users during activation.

= 1.0.2 =
Resolves a fatal error that prevented the plugin from starting.

= 1.0.1 =
Dependency upgrades and additional copy around potential error states.

= 1.0.0 =
Initial release.
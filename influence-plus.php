<?php
/*
Plugin Name: Influence Plus
Description: Extensions and enhancements to the Influence WordPress theme.
Version: trunk
Author: Greg Priday
Author URI: http://siteorigin.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

function influence_plus_init(){

	// Check that we're using Influence and that it's definitely the SiteOrigin version
	if( get_option('template') == 'influence' && defined( 'SITEORIGIN_THEME_VERSION' ) ) {
		include plugin_dir_path(__FILE__) . '/customizer/customizer.php';
		include plugin_dir_path(__FILE__) . '/main.php';

		// Add the updates plugin
		include plugin_dir_path(__FILE__) . '/wp-updates.php';
		new WPUpdatesPluginUpdater_467( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__) );
	}
}
add_action('init', 'influence_plus_init', 1);
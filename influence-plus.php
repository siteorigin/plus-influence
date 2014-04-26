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

	if( get_option('template') == 'influence' && function_exists( 'siteorigin_setting' ) ) {
		include plugin_dir_path(__FILE__) . '/main.php';
		include plugin_dir_path(__FILE__) . '/customizer/customizer.php';
	}

}
add_action('init', 'influence_plus_init');
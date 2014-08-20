<?php

// Do this to remove notifications
if( !defined('SITEORIGIN_IS_PREMIUM') ) define('SITEORIGIN_IS_PREMIUM', true);

include plugin_dir_path(__FILE__) . '/customizer.php';
include plugin_dir_path(__FILE__) . '/slider.php';

/**
 * Add the missing settings
 */
function influence_plus_theme_settings(){
	siteorigin_settings_add_field( 'logo', 'retina_logo', 'media' );
	siteorigin_settings_add_field( 'general', 'attribution', 'checkbox' );
	siteorigin_settings_add_field( 'home', 'slider_shortcode', 'text' );
}
add_action('admin_init', 'influence_plus_theme_settings', 15);

/**
 * Add the retina logo attribute
 *
 * @param $attr
 *
 * @return mixed
 */
function influence_plus_add_retina_logo($attr){
	$logo = siteorigin_setting('logo_retina_logo');

	if( !empty($logo) ) {
		$image = wp_get_attachment_image_src($logo, 'full');
		$attr['data-retina-image'] = $image[0];
	}

	return $attr;
}
add_filter('influence_logo_image_attributes', 'influence_plus_add_retina_logo');

/**
 * Remove attribution
 *
 * @param $credits
 *
 * @return string
 */
function influence_plus_filter_attribution($credits){
	if( !siteorigin_setting('general_attribution') ) return '';
	else return $credits;
}
add_filter('influence_credits_siteorigin', 'influence_plus_filter_attribution');
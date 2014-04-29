<?php

function influence_plus_customizer_init(){
	$sections = apply_filters( 'influence_plus_customizer_sections', array(
		'influence_fonts' => array(
			'title' => __('Fonts', 'plus-influence'),
			'priority' => 30,
		),

		'influence_general' => array(
			'title' => __('General', 'plus-influence'),
			'priority' => 40,
		),

		'influence_sidebar' => array(
			'title' => __('Sidebar Menu', 'plus-influence'),
			'priority' => 50,
		),

		'influence_footer' => array(
			'title' => __('Footer', 'plus-influence'),
			'priority' => 100,
		),

	) );

	$settings = apply_filters( 'influence_plus_customizer_settings', array(
		'influence_fonts' => array(

			'body_font' => array(
				'type' => 'font',
				'title' => __('Body Font', 'plus-influence'),
				'default' => 'Helvetica Neue',
				'selector' => 'body,button,input,select,textarea',
			),

			'heading_font' => array(
				'type' => 'font',
				'title' => __('Heading Font', 'plus-influence'),
				'default' => 'Montserrat',
				'selector' => 'h1,h2,h3,h4,h5,h6',
			),
		),

		'influence_sidebar' => array(

			'background' => array(
				'type' => 'color',
				'title' => __('Sidebar Background', 'influence'),
				'default' => '#22211f',
				'selector' => '#main-menu',
				'property' => 'background-color',
			),

			'background_image' => array(
				'type' => 'image',
				'title' => __('Sidebar Background Image', 'influence'),
				'default' => false,
				'selector' => '#main-menu',
				'property' => 'background-image',
			),

			'heading_color' => array(
				'type' => 'color',
				'title' => __('Heading Color', 'influence'),
				'default' => '#ebe9e5',
				'selector' => '#main-menu .widgets aside.widget .widget-title',
				'property' => 'color',
			),

			'heading_size' => array(
				'type' => 'measurement',
				'title' => __('Widget Heading Size', 'influence'),
				'default' => 1.4,
				'unit' => 'em',
				'selector' => '#main-menu .widgets aside.widget .widget-title',
				'property' => 'font-size',
			),

			'text' => array(
				'type' => 'color',
				'title' => __('Widget Text', 'influence'),
				'default' => '#bab9b5',
				'selector' => '#main-menu .widgets aside.widget',
				'property' => 'color',
			),

			'links' => array(
				'type' => 'color',
				'title' => __('Widget and Menu Links', 'influence'),
				'default' => '#c8c6c3',
				'selector' => '#main-menu .menu ul li a, #main-menu .widgets aside.widget a',
				'property' => 'color',
			),
		),

		'influence_footer' => array(

			'background' => array(
				'type' => 'color',
				'title' => __('Footer Background', 'influence'),
				'default' => '#2d2c2c',
				'selector' => '#colophon',
				'property' => 'background-color',
			),

			'background_image' => array(
				'type' => 'image',
				'title' => __('Footer Background Image', 'influence'),
				'default' => false,
				'selector' => '#colophon',
				'property' => 'background-image',
			),

			'heading_color' => array(
				'type' => 'color',
				'title' => __('Heading Color', 'influence'),
				'default' => '#ebe9e5',
				'selector' => '#footer-widgets aside.widget .widget-title',
				'property' => 'color',
			),

			'heading_size' => array(
				'type' => 'measurement',
				'title' => __('Heading Size', 'influence'),
				'default' => 1.5,
				'unit' => 'em',
				'selector' => '#footer-widgets aside.widget .widget-title',
				'property' => 'font-size',
			),

			'text' => array(
				'type' => 'color',
				'title' => __('Text', 'influence'),
				'default' => '#bab9b5',
				'selector' => '#footer-widgets aside.widget',
				'property' => 'color',
			),

			'links' => array(
				'type' => 'color',
				'title' => __('Links', 'influence'),
				'default' => '#c8c6c3',
				'selector' => '#footer-widgets aside.widget a',
				'property' => 'color',
			),
		),
	) );

	global $siteorigin_influence_customizer;
	$siteorigin_influence_customizer = new SiteOrigin_Customizer_Helper($settings, $sections, 'influence', plugin_dir_url(__FILE__).'/customizer/');
}
add_action('init', 'influence_plus_customizer_init');

/**
 * @param WP_Customize_Manager $wp_customize
 */
function influence_customizer_register($wp_customize){
	global $siteorigin_influence_customizer;
	$siteorigin_influence_customizer->customize_register($wp_customize);
}
add_action( 'customize_register', 'influence_customizer_register', 15 );

/**
 * Display the styles
 */
function influence_customizer_style() {
	global $siteorigin_influence_customizer;
	$builder = $siteorigin_influence_customizer->create_css_builder();

	// Add any extra CSS customizations
	echo $builder->css();
}
add_action('wp_head', 'influence_customizer_style', 20);
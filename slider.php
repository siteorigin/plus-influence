<?php

/**
 * Display the shortcode slider
 *
 * @param $code
 *
 * @return string
 */
function influence_plus_display_slider($code){
	if( !is_front_page() || siteorigin_setting('home_displays') != 'shortcode' || !siteorigin_setting('home_slider_shortcode') ) return $code;

	$code = '<div id="under-masthead-slider" ' . ( siteorigin_setting('home_slider_margin') ? '' : 'class="remove-bottom-margin"' ) . '>' . do_shortcode( siteorigin_setting('home_slider_shortcode') ) . '</div>';
	return $code;
}
add_filter('influence_after_header', 'influence_plus_display_slider');

/**
 * Add the page slider meta boxes.
 */
function influence_plus_add_page_meta_boxes(){
	// If the user is using Influence Plus, then that will handle this metabox instead.
	add_meta_box(
		'influence-slider',
		__('Influence Page Slider', 'influence'),
		'influence_plus_display_page_slider_meta_box',
		'page',
		'side'
	);
}
add_action('add_meta_boxes', 'influence_plus_add_page_meta_boxes');

/**
 * Display the meta box for setting up the page slider.
 *
 * @param $post
 * @param $args
 */
function influence_plus_display_page_slider_meta_box($post, $args){
	$slider = get_post_meta($post->ID, 'influence_page_slider', true);
	$slider = wp_parse_args(
		!empty($slider) ? $slider : array(),
		array(
			'shortcode' => '',
			'move' => false,
			'margin' => true,
		)
	);

	?>
	<p>
		<label><?php _e('Slider Shortcode', 'influence-plus') ?></label>
		<input type="text" name="influence_page_slider[shortcode]" class="widefat" value="<?php echo esc_attr($slider['shortcode']) ?>" />
	</p>
	<p><?php _e('Or', 'influence-plus') ?></p>
	<p>
		<label>
			<input type="checkbox" name="influence_page_slider[move]" class="widefat" <?php checked($slider['move']) ?> />
			<?php _e('Use First Page Builder Row', 'influence-plus') ?>
		</label>
		<br/>
		<small class="description">
			<?php _e('Moves first row into the header', 'influence-plus') ?>
		</small>
	</p>
	<hr/>
	<p>
		<label>
			<input type="checkbox" name="influence_page_slider[margin]" class="widefat" <?php checked($slider['margin']) ?> />
			<?php _e('Add Margin Below Slider', 'influence-plus') ?>
		</label>
		<br/>
	</p>
	<?php
	wp_nonce_field('save', '_influenceslider_nonce');
}

/**
 * Save the slider data
 *
 * @param $post_id
 */
function influence_plus_slider_save_post($post_id){
	if( !current_user_can('edit_post', $post_id) ) return;
	if( !isset($_POST['_influenceslider_nonce']) || !wp_verify_nonce($_POST['_influenceslider_nonce'], 'save') ) return;


	$slider = $_POST['influence_page_slider'];
	$slider['shortcode'] = !empty($slider['shortcode']) ? $slider['shortcode'] : '';
	$slider['move'] = !empty($slider['move']);
	$slider['margin'] = !empty($slider['margin']);

	update_post_meta($post_id, 'influence_page_slider', $slider);
}
add_action('save_post', 'influence_plus_slider_save_post');

/**
 * Display the shortcode slider
 *
 * @param $code
 *
 * @return string
 */
function influence_plus_display_page_slider($code){
	if( !is_page() ) return $code;

	$slider = get_post_meta(get_the_ID(), 'influence_page_slider', true);

	if( isset($slider['move']) && $slider['move']) {
		$panels_data = get_post_meta( get_the_ID(), 'panels_data', true );
		if(empty($panels_data)) return;

		$top_area_widgets = array();

		for($i = 0; $i < count($panels_data['widgets']); $i++) {
			if($panels_data['widgets'][$i]['info']['grid'] == 0){
				$top_area_widgets[] = $panels_data['widgets'][$i];
			}
		}

		// Now, we're going to render these widgets
		ob_start();
		foreach($top_area_widgets as $top_widget) {
			the_widget($top_widget['info']['class'], $top_widget);
		}
		$code = '<div id="under-masthead-slider" ' . ( !empty($slider['margin']) ? '' : 'class="remove-bottom-margin"' ) . '>' . ob_get_clean() . '</div>';
	}
	else if(!empty($slider['shortcode'])) {
		$code = '<div id="under-masthead-slider" ' . ( !empty($slider['margin']) ? '' : 'class="remove-bottom-margin"' ) . '>' . do_shortcode( $slider['shortcode'] ) . '</div>';
	}

	return $code;
}
add_filter('influence_after_header', 'influence_plus_display_page_slider');

/**
 * Filter the Page Builder data to remove the first row of widgets.
 *
 * @param $data
 * @param $post_id
 *
 * @return mixed
 */
function influence_plus_replace_panels_data($data, $post_id){

	if( is_page() && get_the_ID() == $post_id ) {

		$slider = get_post_meta(get_the_ID(), 'influence_page_slider', true);
		if( isset($slider['move']) && $slider['move']) {

			unset($data['grids'][0]);
			$data['grids'] = array_values($data['grids']);


			$to = count($data['grid_cells']);
			for($i = 0; $i < $to; $i++) {
				if($data['grid_cells'][$i]['grid'] == 0){
					unset($data['grid_cells'][$i]);
				}
				else {
					$data['grid_cells'][$i]['grid']--;
				}
			}
			$data['grid_cells'] = array_values($data['grid_cells']);

			$to = count($data['widgets']);
			for($i = 0; $i < $to; $i++) {
				if($data['widgets'][$i]['info']['grid'] == 0){
					unset($data['widgets'][$i]);
				}
				else {
					$data['widgets'][$i]['info']['grid']--;
				}
			}
			$data['widgets'] = array_values($data['widgets']);

		}

	}


	return $data;
}
add_filter('siteorigin_panels_data', 'influence_plus_replace_panels_data', 10, 2);
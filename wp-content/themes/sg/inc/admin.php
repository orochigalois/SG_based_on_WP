<?php

function lp_login_logo() {
	?>
	<style type="text/css">
		.login h1 a {
			background-image: url('<?= lp_theme_url(); ?>/images/header-logo.png') !important;
			padding-bottom: 0px !important;
			background-size: contain !important;
			background-position: center !important;
			height: 52px !important;
			width: 237px !important;
		}
	</style>
	<?php
}
add_action('login_enqueue_scripts', 'lp_login_logo');

function lp_dashboard_setup() {
	// Remove dashboard widgets
	//remove_meta_box('dashboard_primary', 'dashboard', 'side');
	//remove_meta_box('dashboard_secondary', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'lp_dashboard_setup');

/*function lp_remove_admin_menus() {
	remove_menu_page('edit.php');
}
add_action('admin_menu', 'lp_remove_admin_menus');*/

// Put the WP editor back on page_for_posts
/*function editor_on_page_for_posts($post) {
	if($post->ID == get_option('page_for_posts')) {
		remove_action('edit_form_after_title', '_wp_posts_page_notice');
		add_post_type_support('page', 'editor');
	}
}
add_action('edit_form_after_title', 'editor_on_page_for_posts', 0);*/

/*function lp_add_mce_colours($settings) {
	$colours = array(
		'000000' => 'Black',
		'FFFFFF' => 'White',
	);

	if(!empty($colours)) {
		$map = array();
		foreach($colours as $value => $label) {
			$map[] = '"'.$value.'","'.$label.'"';
		}

		$settings['textcolor_map'] = '['.implode($map, ',').']';
	}

	return $settings;
}
add_filter('tiny_mce_before_init', 'lp_add_mce_colours');*/

function lp_add_mce_styleselect($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'lp_add_mce_styleselect');

function lp_add_mce_styles($init_array) {
	$style_formats = array(
		array(  
			'title' => 'Button link',
			'selector' => 'a',
			'classes' => 'button'
		),
		array(  
			'title' => 'Desktop-only image',
			'selector' => 'img',
			'classes' => 'hidden-mobile'
		),
		array(  
			'title' => 'Mobile-only image',
			'selector' => 'img',
			'classes' => 'hidden-desktop'
		),
		/*array(  
			'title' => 'Width label',
			'inline' => 'span',
			'classes' => 'label'
		),*/
	);

	$init_array['style_formats'] = json_encode($style_formats);

	return $init_array;
} 
add_filter('tiny_mce_before_init', 'lp_add_mce_styles');

// Add to editor image size dropdown
/*function lp_media_sizes_dropdown($sizes) {
	$sizes['container_width'] = 'Container width';

	return $sizes;
}
add_filter('image_size_names_choose', 'lp_media_sizes_dropdown');*/

// Stop TinyMCE from stripping &nbsp;'s
function lp_mce_allow_nbsp($init_array) {
    $init_array['entities'] .= ',160,nbsp';
    $init_array['entity_encoding'] = 'named';

    return $init_array;
}
add_filter('tiny_mce_before_init', 'lp_mce_allow_nbsp');

// Disable plugin update notices
//remove_action('load-update-core.php', 'wp_update_plugins');
//add_filter('pre_site_transient_update_plugins', '__return_null');

// Add "attachment" post type to link popup search
function lp_link_query($query) {
	$query['post_type'][] = 'attachment';
	$query['post_status'] = array($query['post_status'], 'inherit');

	return $query;
}
add_filter('wp_link_query_args', 'lp_link_query', 10, 1);

function lp_link_query_results($results) {
	array_walk($results, function(&$r) {
		$post = get_post($r['ID']);
		if($post->post_type == 'attachment') {
			$r['permalink'] = $post->guid;
		}
	});

	return $results;
}
add_filter('wp_link_query', 'lp_link_query_results', 10, 1);

<?php

function lp_enqueue_frontend()
{
	// Dequeue existing scripts
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');

	// Third-party styles
	//wp_enqueue_style('fa', ''//pro.fontawesome.com/releases/v5.8.1/css/all.css');

	// Our styles
	wp_enqueue_style('main-style', get_template_directory_uri() . '/dist/css/main.min.css');

	// Third-party scripts
	wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.3.1.min.js', '', '', true);
	wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', '', '', true);

	if (defined('LP_GMAPS_KEY') && LP_GMAPS_KEY) {
		wp_enqueue_script('gmaps_api', 'https://maps.googleapis.com/maps/api/js?key=' . LP_GMAPS_KEY, '', '', true);
	}

	// Our scripts
	wp_enqueue_script('vendor-script', get_template_directory_uri() . '/dist/js/vendor.min.js', '', '', true);
	wp_enqueue_script('main-script', get_template_directory_uri() . '/dist/js/main.min.js', '', '', true);
}
add_action('wp_enqueue_scripts', 'lp_enqueue_frontend');

function lp_enqueue_admin()
{
	//add_editor_style(get_template_directory_uri().'/dist/css/editor-styles.css');

	// Our styles
	wp_enqueue_style('main-style', get_template_directory_uri() . '/dist/css/main.min.css');

	// Third-party scripts
	wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.3.1.min.js', '', '', true);
	wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', '', '', true);

	wp_enqueue_script('main-script', get_template_directory_uri() . '/dist/js/main.min.js', '', '', true);

	global $plugin_page;
	if($plugin_page=='sg_dictation_page'){
		wp_enqueue_script('_game_dictation-script', get_template_directory_uri() . '/dist/js/_game_dictation.min.js', '', '', true);
	}
	if($plugin_page=='sg_library_page'){
		wp_enqueue_script('_library-script', get_template_directory_uri() . '/dist/js/_library.min.js', '', '', true);
	}
	
}
add_action('admin_init', 'lp_enqueue_admin');
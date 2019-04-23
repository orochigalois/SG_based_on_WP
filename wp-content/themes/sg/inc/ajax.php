<?php

/*function ajax_load_post(){
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		die('false');
	}

	$query = new WP_Query(array(
		'p' => absint($_GET['id']),
	));

	$template = locate_template('partials/post.php');

	if($query->have_posts()) {
		while($query->have_posts()) {
			$query->the_post();
			include $template;
		}
	}

	exit();
}
add_action('wp_ajax_nopriv_load_post', 'ajax_load_post');
add_action('wp_ajax_load_post', 'ajax_load_post');*/

/*function ajax_more_posts(){
	if(!isset($_GET['paged']) || !is_numeric($_GET['paged'])) {
		die('false');
	}

	$query = new WP_Query(array(
		'paged' => absint($_GET['paged']),
	));

	$template = lp_theme_dir().'/partials/post.php';

	ob_start();
	if($query->have_posts()) {
		while($query->have_posts()) {
			$query->the_post();
			include $template;
		}
	}
	$html = ob_get_clean();

	print json_encode(array(
		'has_next_page' => lp_has_next_page($query),
		'html' => $html,
	));

	exit();
}
add_action('wp_ajax_nopriv_more_posts', 'ajax_more_posts');
add_action('wp_ajax_more_posts', 'ajax_more_posts');*/
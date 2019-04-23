<?php

function lp_register_theme_support() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'lp_register_theme_support');

function lp_register_image_sizes() {
	add_image_size('max_width', 1920, 0, false);
	add_image_size('container_width', 1200, 0, false);
	add_image_size('xs_width', 768, 0, false);
}
add_action('after_setup_theme', 'lp_register_image_sizes');

function lp_register_menus() {
	//register_nav_menu('header-menu', 'Header Menu');
}
add_action('init', 'lp_register_menus');

function lp_register_sidebars() {
	/*register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'description' => '',
		'before_widget' => '<div id="%1$s" class="sidebar %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));*/
}
add_action('widgets_init', 'lp_register_sidebars');

function lp_register_post_types() {
	/*register_post_type('project', array(
		'labels'		=> array(
			'name'			   => __( 'Projects' ),
			'singular_name'	  => __( 'Project' ),
			'add_new'			=> __( 'Add New' ),
			'add_new_item'	   => __( 'Add New Project' ),
			'edit_item'		  => __( 'Edit Project' ),
			'new_item'		   => __( 'New Project' ),
			'all_items'		  => __( 'All Projects' ),
			'view_item'		  => __( 'View Project' ),
			'search_items'	   => __( 'Search Project' ),
			'not_found'		  => __( 'No Projects found' ),
			'not_found_in_trash' => __( 'No Projects found in the Trash' ),
			'parent_item_colon'  => '',
			'menu_name'		  => 'Projects'
		),
		'public'		=> true,
		'supports'	  => array( 'title', 'editor', 'revisions' ),
		'taxonomies'	=> array('category'),
		'has_archive'   => 'projects',
		'menu_icon'	 => 'dashicons-hammer',
		'rewrite'	   => array('slug' => 'project', 'with_front' => true),
	));*/
}
add_action('init', 'lp_register_post_types');

function lp_register_taxonomies() {
	/*register_taxonomy('project-status', array('project'), array(
		'labels'			=> array(
			'name'			  => _x( 'Project Statuses', 'taxonomy general name' ),
			'singular_name'	 => _x( 'Project Status', 'taxonomy singular name' ),
			'search_items'	  => __( 'Search Project Statuses' ),
			'all_items'		 => __( 'All Project Statuses' ),
			'parent_item'	   => __( 'Parent Project Status' ),
			'parent_item_colon' => __( 'Parent Project Status:' ),
			'edit_item'		 => __( 'Edit Project Status' ),
			'update_item'	   => __( 'Update Project Status' ),
			'add_new_item'	  => __( 'Add New Project Status' ),
			'new_item_name'	 => __( 'New Project Status Name' ),
			'menu_name'		 => __( 'Project Statuses' ),
		),
		'hierarchical'	  => true,
		'show_ui'		   => true,
		'show_in_menu'	  => true,
	));*/
}
add_action('init', 'lp_register_taxonomies');

function lp_register_rewrite_rules() {
	//add_rewrite_rule('^projects/([^/]+)/?$', 'index.php?post_type=project&project_status=$matches[1]]', 'top');
}
add_action('init', 'lp_register_rewrite_rules');

function lp_register_query_vars($vars) {
	//$vars[] = 'project_status';

	return $vars;
}
add_action('query_vars', 'lp_register_query_vars');
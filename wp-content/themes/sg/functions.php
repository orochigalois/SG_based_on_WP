<?php

require 'inc/constants.php';

require 'inc/acf.php';
require 'inc/admin.php';
require 'inc/ajax.php';
require 'inc/cf7.php';
require 'inc/enqueue.php';
require 'inc/menus.php';
require 'inc/misc.php';
require 'inc/register.php';


function is_blog () {
	return (is_archive() || is_author() || is_category() || is_single() || is_tag()) && 'post' == get_post_type();
}

// remove p around img
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// put a div around tables
function filter_div_on_table($content){
    return preg_replace('/(<table.*<\/table\>)/si','<div class="table-wrap">$0</div>', $content);
}
add_filter('the_content', 'filter_div_on_table');

// put a div around oembed
function filter_div_on_oembed($html, $url, $attr, $post_id) {
    return '<div class="oembed">'.$html.'</div>';
}
add_filter('embed_oembed_html', 'filter_div_on_oembed', 100, 4);

// Set the homepage <title> attribute;
/*function different_document_title($title) {
    if(lp_is_homepage()) {
        $title = get_bloginfo('name');
    }

    return $title;
}
add_filter('pre_get_document_title', 'different_document_title', 100);*/

// Filter the main queries
/*function filter_get_posts($query) {
	if(!is_admin()) {
		if($query->is_main_query() && $query->is_post_type_archive('project')) {
			$query->set('posts_per_page', 12);
		}
	}

	return $query;
}
add_filter('pre_get_posts', 'filter_get_posts');*/

// Reroute inaccessible pages to 404
function reroute_to_404($template) {
	if(get_field('page_inaccessible')) {
		return locate_template('404.php');
	}
	else {
		return $template;
	}
}
add_filter('template_include', 'reroute_to_404');

// Redirect to a URL
function redirect_to_url() {
	$redirect = get_field('page_redirect');
	if($redirect && $redirect['url']) {
		wp_redirect($redirect['url']);
	}
}
add_action('template_redirect', 'redirect_to_url');

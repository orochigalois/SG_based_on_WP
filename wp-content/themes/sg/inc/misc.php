<?php


function lp_is_plugin_active($plugin_file)
{
	static $plugins = null;

	if (!$plugins) {
		$plugins = get_option('active_plugins');
	}

	return in_array($plugin_file, $plugins);
}

function lp_parse_mime($mime)
{
	preg_match('/.*\/(\w*)\+?.*/', $mime, $matches);
	return $matches[1];
}

/*
	Query utils
*/
function lp_has_next_page($query = null)
{
	if (!$query) {
		global $wp_query;
		$query = $wp_query;
	}

	$paged = $query->get('paged');
	if ($paged < 1) {
		$paged = 1;
	}

	return $paged < $query->max_num_pages;
}

function lp_acf_source($source = null)
{
	if (is_front_page()) {
		$source = get_option('page_on_front');
	} else if (is_home()) {
		$source = get_option('page_for_posts');
	} else if (!$source && !is_search() && !is_404()) {
		global $post;
		$source = $post->ID;
	}

	return $source;
}

function lp_get_primary_term($taxonomy, $id = false)
{
	$id = ($id ? $id : get_the_ID());

	$term = false;
	if (class_exists('WPSEO_Primary_Term')) {
		$primary_term = new WPSEO_Primary_Term($taxonomy, $id);
		$term = get_term($primary_term->get_primary_term());
	}

	if (!$term || is_wp_error($term)) {
		$terms = get_the_terms($id, $taxonomy);

		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $t) {
				if ($t->parent !== 0) {
					$term = $t;
					break;
				}
			}
		}

		if ((!$term || is_wp_error($term)) && !empty($terms) && !is_wp_error($terms)) {
			$term = reset($terms);
		}
	}

	return $term;
}

function lp_count_results_for_posttype($post_type, $wp_query = null)
{
	if ($wp_query == null) {
		global $wp_query;
	}

	$args = array_merge(
		$wp_query->query,
		array(
			'post_type' => explode(',', $post_type),
			'posts_per_page' => 1,
			'paged' => 1,
		)
	);

	$transient_key = 'lp_count_results_' . md5(json_encode($args));

	$num_posts = get_transient($transient_key);
	if ($num_posts === false) {
		$query = new WP_Query($args);
		$num_posts = $query->found_posts;

		set_transient($transient_key, $num_posts, WEEK_IN_SECONDS);
	}

	return $num_posts;
}

// Helper to get the full list of post IDs for the given WP_Query
function lp_get_current_query_post_ids($in_query = null)
{
	static $posts = false;

	if (!$posts) {
		if (!$in_query) {
			global $wp_query;
			$in_query = $wp_query;
		}

		$query_args = $in_query->query_vars;
		$query_args['fields'] = 'ids';
		$query_args['posts_per_page'] = -1;
		$query_args['paged'] = 0;
		$query_args['nopaging'] = true;

		$query = new WP_Query($query_args);

		$posts = $query->posts;
	}

	return $posts;
}

/*
	Template utilities
*/
function lp_theme_url()
{
	return get_stylesheet_directory_uri();
}

function lp_theme_dir()
{
	return get_stylesheet_directory();
}

function lp_theme_partial($path, $args = array())
{
	extract($args);
	include lp_theme_dir() . $path;
}

function lp_image_dir()
{
	echo lp_theme_url() . '/images';
}

/*
 	Convert a given string to a slug
*/
function lp_slugify($text)
{
	return sanitize_title($text);
}


/*
	SVG icons
*/
function lp_icon($id)
{
	$viewboxes = array();

	return '<svg class="icon" viewBox="' . (isset($viewboxes[$id]) ? $viewboxes[$id] : '0 0 64 64') . '"><use xlink:href="#Icons/' . $id . '"></use></svg>';
}

function lp_icon_file($name)
{
	return file_get_contents(lp_theme_dir() . '/images/' . $name . '.svg');
}

function lp_file_contents($path)
{
	return file_get_contents(lp_theme_dir() . $path);
}

/*
	Font Awesome
*/
function lp_fa($icon, $alt = '')
{
	return '<i class="fa ' . $icon . '" aria-hidden="true"></i>' . ($alt ? '<span class="sr-only">' . $alt . '</span>' : '');
}

/*
	Convert an iframe (like from an ACF oEmbed field) to a Vimeo background embed
*/
function lp_convert_embed_to_vimeo_background($embed)
{
	if ($embed && strpos($embed, 'vimeo.com') !== false) {
		$embed = lp_add_params_to_embed($embed, array('background' => 1));
	}

	return $embed;
}

/*
	Add extra parameters to an embed's src attribute
*/
function lp_add_params_to_embed($embed, $params)
{
	// Break at the src attribute
	$embed = explode('src="', $embed, 2);
	$before_src = $embed[0];

	// Break after the src attribute value
	$embed = explode('"', $embed[1], 2);
	$after_src = $embed[1];

	// Add the background parameter to the src attribute value
	$src = $embed[0];
	$src = add_query_arg($params, $src);

	// Reassemble
	$embed = $before_src . 'src="' . $src . '"' . $after_src;

	return $embed;
}



//_______________________________________________________________________________________SG logic begins
function write_log($log)
{

	if (is_array($log) || is_object($log)) {
		error_log(print_r($log, true));
	} else {
		error_log($log);
	}
}

function is_sentence_game()
{
	global $current_user;

	$sg_word_or_sentence = get_user_meta($current_user->ID, 'sg_word_or_sentence', true);

	if ($sg_word_or_sentence == "sentence") {
		return true;
	} else {
		return false;
	}
}



function multiexplode($delimiters, $string)
{
	$ready = str_replace($delimiters, $delimiters[0], $string);
	$launch = explode($delimiters[0], $ready);
	return  $launch;
}


function get_all_delimiters($string, &$delimiters)
{
	$array = str_split($string);

	foreach ($array as $char) {

		if ($char == '?' || $char == '!' || $char == '.' || $char == ':')
			$delimiters[] = $char;
	}
}


function randomPassword()
{
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

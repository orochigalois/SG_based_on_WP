<?php
session_start();
set_time_limit(0);
date_default_timezone_set('Australia/Melbourne');


require 'inc/misc.php';
require 'inc/constants.php';
require 'inc/acf.php';
require 'inc/admin.php';
require 'inc/ajax.php';
require 'inc/cf7.php';
require 'inc/enqueue.php';
require 'inc/menus.php';
require 'inc/register.php';
require 'inc/profile.php';
require 'inc/hammerspoon.php';
require 'inc/update.php';
require 'inc/delete.php';
require 'inc/curl.php';
require 'inc/googleimage.php';
require 'inc/score.php';
require 'inc/tts.php';


function is_blog()
{
	return (is_archive() || is_author() || is_category() || is_single() || is_tag()) && 'post' == get_post_type();
}

// remove p around img
function filter_ptags_on_images($content)
{
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// put a div around tables
function filter_div_on_table($content)
{
	return preg_replace('/(<table.*<\/table\>)/si', '<div class="table-wrap">$0</div>', $content);
}
add_filter('the_content', 'filter_div_on_table');

// put a div around oembed
function filter_div_on_oembed($html, $url, $attr, $post_id)
{
	return '<div class="oembed">' . $html . '</div>';
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
function reroute_to_404($template)
{
	if (get_field('page_inaccessible')) {
		return locate_template('404.php');
	} else {
		return $template;
	}
}
add_filter('template_include', 'reroute_to_404');

// Redirect to a URL
function redirect_to_url()
{
	$redirect = get_field('page_redirect');
	if ($redirect && $redirect['url']) {
		wp_redirect($redirect['url']);
	}
}
add_action('template_redirect', 'redirect_to_url');


//_______________________________________________________________________________________SG logic begins
function wpse239290_user_welcome_notice()
{
	// Make sure that the user is assigned to the subscriber role, specifically.
	// Alternatively, capabilities can be checked with current_user_can(), but roles are not supposed to be checked this way.
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}

	// Make sure the profile or dashboard screens are being viewed.
	$screen = get_current_screen();
	if (!$screen || ('profile' !== $screen->id && 'dashboard' !== $screen->id)) {
		return;
	}

	// Show a friendly green notice, and allow it to be dismissed (it will re-appear if the page is reloaded though).
	$class = 'notice notice-success is-dismissible';

	// Customize the HTML to  fit your preferences.
	$message = '<p>Looking for the <a href="http://example.com/form">Example Form</a></p>';

	printf('<div class="%1$s"><div class="subscriberProfile">%2$s</div></div>', $class, $message);
}
// add_action( 'admin_notices', 'wpse239290_user_welcome_notice' );





/**
 * All pages
 */
function sg_admin_menu()
{
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}
	add_menu_page('Upload Vocabulary Lists', 'Upload', 'read', 'sg_upload_page', 'sg_upload', 'dashicons-translation', 110);
	add_menu_page('Library', 'Library', 'read', 'sg_library_page', 'sg_library', 'dashicons-admin-page', 111);
	add_menu_page('Dictation Game', 'Dictation', 'read', 'sg_dictation_page', 'sg_dictation', 'dashicons-editor-spellcheck', 112);
	add_menu_page('Sentence Game', 'Sentence', 'read', 'sg_sentence_page', 'sg_sentence', 'dashicons-editor-spellcheck', 113);
	//add_menu_page('Test', 'Test', 'read', 'sg_test_page', 'sg_test', 'dashicons-editor-spellcheck', 200);
}

function sg_upload()
{
	require 'templates/upload.php';
}
function sg_library()
{
	require 'templates/library.php';
}
function sg_test()
{
	require 'templates/test.php';
}
function sg_dictation()
{
	require 'templates/game_dictation.php';
}
function sg_sentence()
{
	require 'templates/game_sentence.php';
}
add_action('admin_menu', 'sg_admin_menu');


/**
 * prepare ajax script
 */
function add_to_admin_header()
{
	?>
	<script type="text/javascript">
		var _ajaxurl = '<?= admin_url("admin-ajax.php"); ?>';
		var _pageid = '<?= get_the_ID(); ?>';
		var _imagedir = '<?php lp_image_dir(); ?>';
	</script>
<?php
}
add_action('admin_head', 'add_to_admin_header');




/**
 * sg_initialize_user
 */
function sg_initialize_user($user_id)
{
	//step1. create folders
	$upload_dir = wp_upload_dir();
	mkdir($upload_dir['basedir'] . '/userdata' . $user_id, 0777);
	mkdir($upload_dir['basedir'] . '/userdata' . $user_id . '/paragraph', 0777);
	mkdir($upload_dir['basedir'] . '/userdata' . $user_id . '/sentence', 0777);
	mkdir($upload_dir['basedir'] . '/userdata' . $user_id . '/word', 0777);
	mkdir($upload_dir['basedir'] . '/userdata' . $user_id . '/picture', 0777);

	//step2. create 'sg_word_or_sentence' meta
	update_user_meta($user_id, 'sg_word_or_sentence', 'word'); //It's a word game by default

	//step3. create 'sg_user_token' meta, used by REST API
	$password = randomPassword();
	update_user_meta($user_id, "sg_user_token", $password);
}
add_action('user_register', 'sg_initialize_user', 10, 1);




/**
 * add_current_wordlist_in_admin_bar
 */
function add_current_wordlist_in_admin_bar()
{
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(array(
		'id' => 'wpse-form-in-admin-bar',
		'parent' => 'top-secondary',
		'title' => '<p class="sg-current-label">Current wordlist: <span></span></p>'
	));
}
add_action('admin_bar_menu', 'add_current_wordlist_in_admin_bar');




/**
 * print_word_or_sentence_icon_on_admin_bar
 */
function print_word_or_sentence_icon_on_admin_bar($wp_admin_bar)
{

	$user = wp_get_current_user();
	$sg_word_or_sentence = get_user_meta($user->ID, 'sg_word_or_sentence', true);

	if ($sg_word_or_sentence == "sentence") {
		$wp_logo_menu_args = array(
			'id'    => 'wp-logo',
			'title' => '<span class="ab-icon ab-sentence"></span>',
			'href'  => '#',
		);
	} else {
		$wp_logo_menu_args = array(
			'id'    => 'wp-logo',
			'title' => '<span class="ab-icon"></span>',
			'href'  => '#',
		);
	}


	// Set tabindex="0" to make sub menus accessible when no URL is available.

	$wp_logo_menu_args['meta'] = array(
		'tabindex' => 0,
	);


	$wp_admin_bar->add_menu($wp_logo_menu_args);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'wp-logo',
			'id'     => 'word',
			'title'  => __('Word'),
			'href'   => 'index.php?sg_word_or_sentence=word',
		)
	);


	$wp_admin_bar->add_menu(
		array(
			'parent' => 'wp-logo',
			'id'     => 'sentence',
			'title'  => __('Sentence'),
			'href'   => 'index.php?sg_word_or_sentence=sentence',
		)
	);
}



function customize_menu()
{
	remove_action('admin_bar_menu', 'wp_admin_bar_wp_menu', 10);
	remove_action('admin_bar_menu', 'wp_admin_bar_site_menu', 30);

	add_action('admin_bar_menu', 'print_word_or_sentence_icon_on_admin_bar', 10);
}
//choose the right time to remove_action, that's why the priority '100' being there
add_action('admin_init', 'customize_menu', 100);



/**
 * fire when switch word/sentence game
 */
function sg_word_or_sentence()
{
	if (isset($_GET['sg_word_or_sentence'])) {
		$user = wp_get_current_user();
		update_user_meta($user->ID, 'sg_word_or_sentence', $_GET['sg_word_or_sentence']);
	}
}
add_action('load-index.php', 'sg_word_or_sentence', 1, 0);


/**
 * customize_footer
 */
function customize_footer()
{
	remove_filter('update_footer', 'core_update_footer');
	add_filter('update_footer', 'code_is_poetry', 5);

	function code_is_poetry()
	{
		return 'Code is Poetry';
	}
}
add_action('admin_menu', 'customize_footer');


/**
 * disable_default_dashboard_widgets
 */
function disable_default_dashboard_widgets()
{
	global $wp_meta_boxes;
	// wp..
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	// bbpress
	unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
	// yoast seo
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
	// gravity forms
	unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);


/**
 * add_roadmap_widgets
 */
function add_roadmap_widgets()
{
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}

	wp_add_dashboard_widget(
		'dashboard_widget_roadmap',         // Widget slug.
		'Roadmap',         // Title.
		'dashboard_widget_roadmap_function' // Display function.
	);
}
function dashboard_widget_roadmap_function()
{

	include_once('partials/widget_roadmap.php');
}
add_action('wp_dashboard_setup', 'add_roadmap_widgets');


/**
 * add_overview_widgets
 */
function add_overview_widgets()
{
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}

	wp_add_dashboard_widget(
		'dashboard_widget_overview',         // Widget slug.
		'Overview',         // Title.
		'dashboard_widget_overview_function' // Display function.
	);
}
function dashboard_widget_overview_function()
{
	include_once('partials/widget_overview.php');
}
add_action('wp_dashboard_setup', 'add_overview_widgets');



/**
 * add_wordlist_widgets
 */
function add_wordlist_widgets()
{
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}

	wp_add_dashboard_widget(
		'dashboard_widget_wordlist',         // Widget slug.
		'Wordlist',         // Title.
		'dashboard_widget_wordlist_function' // Display function.
	);
}
function dashboard_widget_wordlist_function()
{
	include_once('partials/widget_wordlist.php');
}
add_action('wp_dashboard_setup', 'add_wordlist_widgets');




//temporary use
// add_action('init', 'add_meta_to_all');
// function add_meta_to_all()
// {
// 	$custom_query = array('posts_per_page' => '-1', 'post_type' => 'attachment', 'post_status' => 'inherit');
// 	$author_posts = new WP_Query($custom_query);


// 	while ($author_posts->have_posts()) : $author_posts->the_post();
// 		update_post_meta(get_the_ID(), 'sg_word_or_sentence', 'word');

// 	endwhile;
// 	wp_reset_postdata();
// }

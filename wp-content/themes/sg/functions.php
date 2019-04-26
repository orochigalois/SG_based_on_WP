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



function wpse239290_user_welcome_notice() {
    // Make sure that the user is assigned to the subscriber role, specifically.
    // Alternatively, capabilities can be checked with current_user_can(), but roles are not supposed to be checked this way.
    $user = wp_get_current_user();
    if ( ! in_array( 'subscriber', $user->roles ) ) {
        return;
    }

    // Make sure the profile or dashboard screens are being viewed.
    $screen = get_current_screen();
    if ( ! $screen || ( 'profile' !== $screen->id && 'dashboard' !== $screen->id ) ) {
        return;
    }

    // Show a friendly green notice, and allow it to be dismissed (it will re-appear if the page is reloaded though).
    $class = 'notice notice-success is-dismissible';

    // Customize the HTML to  fit your preferences.
    $message = '<p>Looking for the <a href="http://example.com/form">Example Form</a></p>';

    printf( '<div class="%1$s"><div class="subscriberProfile">%2$s</div></div>', $class, $message ); 
}
add_action( 'admin_notices', 'wpse239290_user_welcome_notice' );






function sg_admin_menu()
{
	$user = wp_get_current_user();
	if (!in_array('subscriber', $user->roles)) {
		return;
	}
	add_menu_page('Upload Vocabulary Lists', 'Upload', 'read', 'sg_upload_page', 'sg_upload', 'dashicons-translation', 110);
	add_menu_page('Library', 'Library', 'read', 'sg_library_page', 'sg_library', 'dashicons-admin-page', 111);
}

function sg_upload()
{
	require 'templates/upload.php'; 
}
function sg_library()
{
	require 'templates/library.php'; 
}


add_action('admin_menu', 'sg_admin_menu');



function add_to_admin_header() {
 ?>
    <script type="text/javascript">
		var _ajaxurl = '<?= admin_url("admin-ajax.php"); ?>';
		var _pageid = '<?= get_the_ID(); ?>';
		var _imagedir = '<?php lp_image_dir(); ?>';
	</script>
<?php 
}
add_action( 'admin_head', 'add_to_admin_header' );



add_action( 'user_register', 'create_user_folder', 10, 1 );

function create_user_folder( $user_id ) {

	$upload_dir = wp_upload_dir();
	mkdir($upload_dir['basedir'].'/userdata'.$user_id,0777);
	mkdir($upload_dir['basedir'].'/userdata'.$user_id.'/sentence',0777);
	mkdir($upload_dir['basedir'].'/userdata'.$user_id.'/word',0777);
	mkdir($upload_dir['basedir'].'/userdata'.$user_id.'/picture',0777);
}



function wpse_form_in_admin_bar() {
    global $wp_admin_bar;

    $wp_admin_bar->add_menu( array(
        'id' => 'wpse-form-in-admin-bar',
        'parent' => 'top-secondary',
        'title' => '<p class="sg-current-label">Current wordlist: <span></span></p>'
    ) );
}
add_action( 'admin_bar_menu', 'wpse_form_in_admin_bar' );
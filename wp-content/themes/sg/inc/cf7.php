<?php

// send thankyou edm
/*function lp_register($form) {
    // Fields
    $submission = WPCF7_Submission::get_instance();
    $data = $submission->get_posted_data();

    // $site_url = 'http://' . $_SERVER["SERVER_NAME"];
    // absolute URL to PROD for easy testing on stage / local
    $site_url = 'http://yoururl.com.au/wp-content/themes/yourtheme';

    // Full name
    $name = $data['first-name'];

    // Email
    $email = $data['email'];

    $to = $email;

    $subject = 'Site Name  - Registration';
    $body = file_get_contents(get_template_directory() . '/email/index.html');

    // TEMPLATE SET UP
    $body = str_replace('%%NAME%%', strtoupper($name), $body);
    $body = str_replace('%%SITEURL%%', $site_url, $body);

    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Site Name <noreply@yoururl.com.au>');

    wp_mail( $to, $subject, $body, $headers );
}
add_action('wpcf7_before_send_mail', 'lp_register');*/

// Change 'Flamingo' admin menu title
/*function customize_post_admin_menu_labels() {
    global $menu;
    global $submenu;
    $menu[26][0] = 'Submissions';
    $submenu['flamingo'][1][0] = 'Submissions';
    echo '';
}
add_action( 'admin_menu', 'customize_post_admin_menu_labels' );*/

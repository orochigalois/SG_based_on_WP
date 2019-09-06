<?php
function ajax_delete_book()
{
    $post_id = $_GET['post_id'];

    $file = get_attached_file($post_id);
    unlink($file);
    wp_delete_post($post_id);


    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_delete_book', 'ajax_delete_book');
add_action('wp_ajax_delete_book', 'ajax_delete_book');

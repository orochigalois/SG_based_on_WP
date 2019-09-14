<?php
function ajax_delete_book()
{
    $post_id = $_GET['post_id'];

    //delete file
    $file = get_attached_file($post_id);
    unlink($file);

    //delete post
    wp_delete_post($post_id);

    //delete sound&picture

    global $current_user;
    $upload_dir = wp_upload_dir();

    $sound_path = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_*';
    $picture_path = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $post_id . '_*';

    shell_exec('rm -fr ' . $sound_path);
    shell_exec('rm -fr ' . $picture_path);



    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_delete_book', 'ajax_delete_book');
add_action('wp_ajax_delete_book', 'ajax_delete_book');

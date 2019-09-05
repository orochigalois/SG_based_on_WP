<?php

/*
http://sg.local/wp-admin/admin-ajax.php?action=collect_sentence&sentence=can+anyone+think+of+simple+cassette+splash+pages+we+have+done+semi+recently%3F.&sg_user_token=1azf21T1
*/
function ajax_collect_sentence()
{


    $sentence = $_GET['sentence'];
    //remove backslash
    $sentence = str_replace('\\', '', $sentence);
    $sg_user_token = $_GET['sg_user_token'];

    $users = get_users(array('meta_key' => 'sg_user_token', 'meta_value' => $sg_user_token));

    if (isset($users[0]))
        $user_id = $users[0]->id;
    else {
        $result['status'] = "Your token is not correct";
        print json_encode($result);
        wp_die();
    }


    $file_exist = false;

    //It opens and writes to the end of the file or creates a new file if it doesn’t exist.
    $wp_upload_dir = wp_upload_dir();
    $my_file_name = $wp_upload_dir['path'] . '/sentence_collection_' . date('Y-m-d') . '_by_user_' . $user_id . '.txt';

    if (file_exists($my_file_name)) {
        $file_exist = true;
    }

    $fp = fopen($my_file_name, "a");

    fwrite($fp, $sentence);
    fclose($fp);

    if (!$file_exist) {
        // $filename should be the path to a file in the upload directory.
        $filename = $my_file_name;

        // The ID of the post this attachment is for.
        $parent_post_id = 0;

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($filename), null);

        $serialized_data = array();
        $serialized_data[] = trim($sentence);
        $serialized_data = maybe_serialize($serialized_data);

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => $serialized_data,
            'post_status' => 'inherit',
            'post_author' => $user_id
        );

        // Insert the attachment.
        $post_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
        update_post_meta($post_id, 'sg_word_or_sentence', 'sentence');
        update_user_meta($user_id, 'sg_current_sentence_post_id_for_REST_API', $post_id);
    } else {
        $sg_current_sentence_post_id_for_REST_API = get_user_meta($user_id, 'sg_current_sentence_post_id_for_REST_API', true);

        $serialized_data = get_content_in_the($sg_current_sentence_post_id_for_REST_API);
        $serialized_data[] = trim($sentence);
        $serialized_data = maybe_serialize($serialized_data);

        $my_post = array(
            'ID' => $sg_current_sentence_post_id_for_REST_API,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    }



    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_collect_sentence', 'ajax_collect_sentence');
add_action('wp_ajax_collect_sentence', 'ajax_collect_sentence');







function ajax_collect_word()
{
    $word = $_GET['word'];
    //remove backslash
    $word = str_replace('\\', '', $word);
    $sg_user_token = $_GET['sg_user_token'];

    $users = get_users(array('meta_key' => 'sg_user_token', 'meta_value' => $sg_user_token));

    if (isset($users[0]))
        $user_id = $users[0]->id;
    else {
        $result['status'] = "Your token is not correct";
        print json_encode($result);
        wp_die();
    }


    $file_exist = false;

    //It opens and writes to the end of the file or creates a new file if it doesn’t exist.
    $wp_upload_dir = wp_upload_dir();
    $my_file_name = $wp_upload_dir['path'] . '/word_collection_' . date('Y-m-d') . '_by_user_' . $user_id . '.txt';

    if (file_exists($my_file_name)) {
        $file_exist = true;
    }

    $fp = fopen($my_file_name, "a");

    fwrite($fp, $word);
    fclose($fp);

    if (!$file_exist) {
        // $filename should be the path to a file in the upload directory.
        $filename = $my_file_name;

        // The ID of the post this attachment is for.
        $parent_post_id = 0;

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($filename), null);

        $serialized_data = array();
        $line = array();
        $line['word'] = trim($word);
        $line['sentence'] = '';
        $serialized_data[] = $line;
        $serialized_data = maybe_serialize($serialized_data);

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => $serialized_data,
            'post_status' => 'inherit',
            'post_author' => $user_id
        );

        // Insert the attachment.
        $post_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
        update_post_meta($post_id, 'sg_word_or_sentence', 'word');
        update_user_meta($user_id, 'sg_current_word_post_id_for_REST_API', $post_id);
    } else {
        $sg_current_word_post_id_for_REST_API = get_user_meta($user_id, 'sg_current_word_post_id_for_REST_API', true);

        $serialized_data = get_content_in_the($sg_current_word_post_id_for_REST_API);
        $line = array();
        $line['word'] = trim($word);
        $line['sentence'] = '';
        $serialized_data[] = $line;

        $serialized_data = maybe_serialize($serialized_data);

        $my_post = array(
            'ID' => $sg_current_word_post_id_for_REST_API,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    }



    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_collect_word', 'ajax_collect_word');
add_action('wp_ajax_collect_word', 'ajax_collect_word');








function ajax_collect_sentence_for_word()
{
    $sentence = $_GET['sentence'];
    //remove backslash
    $sentence = str_replace('\\', '', $sentence);
    $sg_user_token = $_GET['sg_user_token'];

    $users = get_users(array('meta_key' => 'sg_user_token', 'meta_value' => $sg_user_token));

    if (isset($users[0]))
        $user_id = $users[0]->id;
    else {
        $result['status'] = "Your token is not correct";
        print json_encode($result);
        wp_die();
    }



    //It opens and writes to the end of the file or creates a new file if it doesn’t exist.
    $wp_upload_dir = wp_upload_dir();
    $my_file_name = $wp_upload_dir['path'] . '/word_collection_' . date('Y-m-d') . '_by_user_' . $user_id . '.txt';

    if (file_exists($my_file_name)) {
        $fp = fopen($my_file_name, "a");
        fwrite($fp, ',' . $sentence . '\n');
        fclose($fp);

        $sg_current_word_post_id_for_REST_API = get_user_meta($user_id, 'sg_current_word_post_id_for_REST_API', true);
        $serialized_data = get_content_in_the($sg_current_word_post_id_for_REST_API);

        $last_index = count($serialized_data) - 1;
        $serialized_data[$last_index]['sentence'] = trim($sentence);

        $serialized_data = maybe_serialize($serialized_data);

        $my_post = array(
            'ID' => $sg_current_word_post_id_for_REST_API,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    } else {
        $result['status'] = "You need to collect a word first";
        print json_encode($result);
        wp_die();
    }



    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_collect_sentence_for_word', 'ajax_collect_sentence_for_word');
add_action('wp_ajax_collect_sentence_for_word', 'ajax_collect_sentence_for_word');

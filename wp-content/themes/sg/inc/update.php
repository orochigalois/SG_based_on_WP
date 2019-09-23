<?php
function ajax_update_title()
{
    $post_id = $_GET['post_id'];
    $title = $_GET['title'];

    //Step1. update file name in upload folder
    $file = get_attached_file($post_id);
    $path = pathinfo($file);
    //dirname = File Path
    //basename = Filename.Extension
    //extension = Extension
    //filename = Filename

    $newfile = $path['dirname'] . "/" . $title . "." . $path['extension'];

    rename($file, $newfile);
    update_attached_file($post_id, $newfile);

    //Step2. update file name in wp_post
    $my_post = array(
        'ID' => $post_id,
        'post_title' => $title,
    );

    wp_update_post($my_post);

    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_update_title', 'ajax_update_title');
add_action('wp_ajax_update_title', 'ajax_update_title');



function ajax_update_word()
{
    $post_id = $_GET['post_id'];
    $index = $_GET['index'];

    $word = $_GET['word'];
    $sentence = $_GET['sentence'];

    //Step1. update sentence in file
    $file = get_attached_file($post_id);

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $lines[$index] = $word . ',' . $sentence;
    file_put_contents($file, implode("\n", $lines));

    //Step2. update $word_matrix



    $book = new Book($post_id);
    $word_matrix = $book->get_matrix();

    $word_matrix[$index]['word'] = $word;
    $word_matrix[$index]['sentence'] = $sentence;

    $book->write_to_db($word_matrix);


    //Step3. reload the voice

    $user = wp_get_current_user();
    $user_info = get_user_meta($user->ID);

    if (isset($user_info['sg_tts'])) {
        if ($user_info['sg_tts'][0] == 'voicerss') {
            get_wordSound_by_voicerss_tts($word_matrix, "no", $post_id, $index);
        } else {
            get_wordSound_by_google_tts($word_matrix, "no", $post_id, $index);
        }
    } else {
        get_wordSound_by_google_tts($word_matrix, "no", $post_id, $index);
    }


    //Step4. return
    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_update_word', 'ajax_update_word');
add_action('wp_ajax_update_word', 'ajax_update_word');


function ajax_update_sentence()
{
    $post_id = $_GET['post_id'];
    $index = $_GET['index'];

    $sentence = stripslashes($_GET['sentence']);

    //Step1. update sentence in file
    $filepath = get_attached_file($post_id);
    $csvdata = file_get_contents($filepath);

    $delimiters = array();
    $snippets = array();

    $result_string = "";

    get_all_delimiters($csvdata, $delimiters);

    $lines = multiexplode(array("?", ".", "!", ":"), $csvdata);
    foreach ($lines as $i => $line) {

        if (trim($line) != "") {

            $snippets[$i] = trim($line);
        }
    }

    $snippets[$index] = $sentence;

    foreach ($snippets as $i => $part) {
        if (isset($delimiters[$i]))
            $result_string .= $part . $delimiters[$i];
        else
            $result_string .= $part;
    }


    file_put_contents($filepath, $result_string);


    //Step2. update sentence in db

    $book = new Book($post_id);
    $word_matrix = $book->get_matrix();

    $word_matrix[$index]['sentence'] = $sentence;

    $book->write_to_db($word_matrix);


    //Step3. reload the voice
    $user = wp_get_current_user();
    $user_info = get_user_meta($user->ID);

    if (isset($user_info['sg_tts'])) {
        if ($user_info['sg_tts'][0] == 'voicerss') {
            get_wordSound_by_voicerss_tts($word_matrix, "yes", $post_id, $index);
        } else {
            get_wordSound_by_google_tts($word_matrix, "yes", $post_id, $index);
        }
    } else {
        get_wordSound_by_google_tts($word_matrix, "yes", $post_id, $index);
    }

    //Step4. return
    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_update_sentence', 'ajax_update_sentence');
add_action('wp_ajax_update_sentence', 'ajax_update_sentence');

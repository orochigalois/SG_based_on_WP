<?php



function get_wordImage($wordmatrix, $isSentenceGame, $post_id)
{
    global $current_user;

    $upload_dir = wp_upload_dir();
    foreach ($wordmatrix as $i => $row) {

        if ($isSentenceGame == 'yes') {
            $keyword = $row['sentence'];
        } else {
            $keyword = $row['word'];
        }
        $wordcode = rawurlencode($keyword);
        //parameters refer to https://developers.google.com/custom-search/v1/cse/list
        $word_url =  'https://www.googleapis.com/customsearch/v1?start=1&num=1&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=large&q=' . $wordcode;


        $result = curl_request($word_url);
        $jsonobj = json_decode($result);

        $image_link = "";

        foreach ($jsonobj->items as $value) {
            $image_link = $value->link;
        }

        $image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $post_id . '_' . $i;

        curl_save_file($image_link, $image_saveTo);
    }
}



function ajax_get_images()
{
    $start = (intval($_GET["page"]) - 1) * 9 + 1;
    $wordcode = rawurlencode($_GET["word"]);
    $extraWord = rawurlencode($_GET["extraWord"]);
    $url =  'https://www.googleapis.com/customsearch/v1?start=' . $start . '&num=9&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=large&q=' . $wordcode . '+' . $extraWord;


    $result = curl_request($url);
    $jsonobj = json_decode($result);

    $return_str = '<ul>';


    foreach ($jsonobj->items as $value) {
        $return_str = $return_str . '<li><img referrerpolicy="no-referrer" src="'
            . $value->link . '" /></li>';
    }

    $return_str = $return_str . '</ul>';

    echo $return_str;
    wp_die(); //otherwise you will get a trailing zero appended to your return string.

}
add_action('wp_ajax_nopriv_get_images', 'ajax_get_images');
add_action('wp_ajax_get_images', 'ajax_get_images');


function ajax_save_images()
{
    global $current_user;

    $upload_dir = wp_upload_dir();


    $image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $_GET['picture_name'];

    curl_save_file($_GET["imageUrl"], $image_saveTo);
    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_save_images', 'ajax_save_images');
add_action('wp_ajax_save_images', 'ajax_save_images');

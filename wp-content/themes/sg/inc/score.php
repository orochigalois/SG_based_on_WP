<?php

function ajax_updateScore()
{
    $score_meta = date("Y-m-d H:i:s");
    add_post_meta($_GET['post_id'], 'sg_done_once', $score_meta);

    $result['status'] = "success";
    print json_encode($result);
    wp_die();
}
add_action('wp_ajax_nopriv_updateScore', 'ajax_updateScore');
add_action('wp_ajax_updateScore', 'ajax_updateScore');

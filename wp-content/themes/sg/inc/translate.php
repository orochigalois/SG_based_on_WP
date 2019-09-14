<?php

use Google\Cloud\Translate\TranslateClient;

/**
 * if $line_index=NULL, then reload all
 */
function get_word_translation(&$word_matrix, $isSentenceGame, $post_id, $line_index)
{
    $user = wp_get_current_user();
    $user_info = get_user_meta($user->ID);

    $translate = new TranslateClient();


    $target_language_code = 'zh';

    if (isset($user_info['sg_your_native_language'])) {
        $target_language_code = $user_info['sg_your_native_language'][0];
    }

    if (is_null($line_index)) {
        foreach ($word_matrix->data as $i => $row) {
            if ($isSentenceGame == 'yes') {
                $result = $translate->translate($row['sentence'], [
                    'target' => $target_language_code,
                ]);
                $word_matrix->data[$i]['translation'] = $result['text'];
            } else {
                $result = $translate->translate($row['word'], [
                    'target' => $target_language_code,
                ]);
                $word_matrix->data[$i]['translation'] = $result['text'];
            }
        }
    } else {
        if ($isSentenceGame == 'yes') {
            $result = $translate->translate($word_matrix->data[$line_index]['sentence'], [
                'target' => $target_language_code,
            ]);
            $word_matrix->data[$line_index]['translation'] = $result['text'];
        } else {
            $result = $translate->translate($word_matrix->data[$line_index]['word'], [
                'target' => $target_language_code,
            ]);
            $word_matrix->data[$line_index]['translation'] = $result['text'];
        }
    }

    $word_matrix->write_to_db();
}

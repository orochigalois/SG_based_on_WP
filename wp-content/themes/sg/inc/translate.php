<?php

use Google\Cloud\Translate\TranslateClient;

/**
 * if $line_index=NULL, then reload all
 */
function get_word_translation($isSentenceGame, $post_id, $line_index)
{
    $user = wp_get_current_user();
    $user_info = get_user_meta($user->ID);

    $translate = new TranslateClient();

    $book = new Book($post_id);
    $word_matrix = $book->get_matrix();

    $target_language_code = 'zh';

    if (isset($user_info['sg_your_native_language'])) {
        $target_language_code = $user_info['sg_your_native_language'][0];
    }

    if (is_null($line_index)) {
        foreach ($word_matrix as $i => $row) {

            $result = $translate->translate($row['word'], [
                'target' => $target_language_code,
            ]);
            $word_matrix[$i]['word_in_native_language'] = $result['text'];

            $result = $translate->translate($row['sentence'], [
                'target' => $target_language_code,
            ]);
            $word_matrix[$i]['sentence_in_native_language'] = $result['text'];
        }
    } else {
        $result = $translate->translate($word_matrix[$line_index]['word'], [
            'target' => $target_language_code,
        ]);
        $word_matrix[$line_index]['word_in_native_language'] = $result['text'];

        $result = $translate->translate($word_matrix[$line_index]['sentence'], [
            'target' => $target_language_code,
        ]);
        $word_matrix[$line_index]['sentence_in_native_language'] = $result['text'];
    }

    $book->write_to_db($word_matrix);
}

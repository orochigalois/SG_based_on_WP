<?php

use Google\Cloud\Translate\TranslateClient;

/**
 * if $line_index=NULL, then reload all
 */
function get_word_translation($wordmatrix, $isSentenceGame, $post_id, $line_index)
{
    $user = wp_get_current_user();
    $user_info = get_user_meta($user->ID);

    $translate = new TranslateClient();


    $target_language_code = 'zh';

    if (isset($user_info['sg_your_native_language'])) {
        $target_language_code = $user_info['sg_your_native_language'][0];
    }


    $serialized_data = array();

    if (is_null($line_index)) {
        foreach ($wordmatrix as $i => $wordline) {
            if ($isSentenceGame == 'yes') {
                // $sentence = str_replace("\r", "", $wordline['sentence']);

                // if ($sentence != '') {
                //     $synthesisInputText = (new SynthesisInput())
                //         ->setText($sentence);

                //     $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                //     $audioContent = $response->getAudioContent();
                //     $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/paragraph' . '/' . $post_id . '_' . $i . '.mp3';

                //     file_put_contents($sentence_saveTo, $audioContent);
                // }
            } else {
                $serialized_data[$i]['word'] = $wordline['word'];
                $serialized_data[$i]['sentence'] = $wordline['sentence'];
                $result = $translate->translate($wordline['word'], [
                    'target' => $target_language_code,
                ]);

                $serialized_data[$i]['translate'] = $result[text];
            }
        }
    } else {


        if ($isSentenceGame == 'yes') {
            // $sentence = str_replace("\r", "", $wordmatrix[$line_index]['sentence']);

            // if ($sentence != '') {
            //     $synthesisInputText = (new SynthesisInput())
            //         ->setText($sentence);

            //     $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
            //     $audioContent = $response->getAudioContent();
            //     $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/paragraph' . '/' . $post_id . '_' . $line_index . '.mp3';

            //     file_put_contents($sentence_saveTo, $audioContent);
            // }
        } else {
            foreach ($wordmatrix as $i => $wordline) {
                $serialized_data[$i]['word'] = $wordline['word'];
                $serialized_data[$i]['sentence'] = $wordline['sentence'];
                $serialized_data[$i]['translate'] = $wordline['sentence'];
            }

            $word = $wordmatrix[$line_index]['word'];
            $result = $translate->translate($word, [
                'target' => $target_language_code,
            ]);
            $serialized_data[$line_index]['translate'] = $result[text];
        }
    }

    $serialized_data = maybe_serialize($serialized_data);

    $my_post = array(
        'ID'           => $post_id,
        'post_content' => $serialized_data,
    );
    // Update the post into the database
    wp_update_post($my_post);
}

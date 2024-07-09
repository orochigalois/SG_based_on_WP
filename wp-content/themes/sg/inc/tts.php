<?php

// Imports the Cloud Client Library
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/**
 * if $line_index=NULL, then reload all
 */
function get_wordSound_by_google_tts($wordmatrix, $isSentenceGame, $post_id, $line_index)
{
    global $current_user;

    $upload_dir = wp_upload_dir();
    $base_dir = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound';

    // Ensure base directory exists
    if (!file_exists($base_dir)) {
        mkdir($base_dir, 0755, true);
    }

    // Instantiates a client
    $client = new TextToSpeechClient();

    // Build the voice request
    $voice = (new VoiceSelectionParams())
        ->setLanguageCode('en-US')
        ->setSsmlGender(SsmlVoiceGender::MALE);

    // Effects profile
    $effectsProfileId = "telephony-class-application";

    // Select the type of audio file you want returned
    $audioConfig = (new AudioConfig())
        ->setAudioEncoding(AudioEncoding::MP3)
        ->setEffectsProfileId(array($effectsProfileId));

    // Helper function to synthesize speech and save to file
    function synthesizeAndSave($client, $text, $voice, $audioConfig, $filePath)
    {
        // Ensure the directory exists before saving
        $dir = dirname($filePath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $synthesisInputText = (new SynthesisInput())->setText($text);
        $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
        $audioContent = $response->getAudioContent();
        file_put_contents($filePath, $audioContent);
    }

    // Process the word matrix
    if (is_null($line_index)) {
        foreach ($wordmatrix as $i => $row) {
            if ($isSentenceGame === 'yes') {
                $sentence = $row['sentence'];
                $sentence_saveTo = $base_dir . '/' . $post_id . '_' . $i . '_s.mp3';
                synthesizeAndSave($client, $sentence, $voice, $audioConfig, $sentence_saveTo);
            } else {
                $word = $row['word'];
                $sentence = $row['sentence'];

                $word_saveTo = $base_dir . '/' . $post_id . '_' . $i . '.mp3';
                synthesizeAndSave($client, $word, $voice, $audioConfig, $word_saveTo);

                if ($sentence != '') {
                    $sentence_saveTo = $base_dir . '/' . $post_id . '_' . $i . '_s.mp3';
                    synthesizeAndSave($client, $sentence, $voice, $audioConfig, $sentence_saveTo);
                }
            }
        }
    } else {
        if ($isSentenceGame === 'yes') {
            $sentence = $wordmatrix[$line_index]['sentence'];
            $sentence_saveTo = $base_dir . '/' . $post_id . '_' . $line_index . '_s.mp3';
            synthesizeAndSave($client, $sentence, $voice, $audioConfig, $sentence_saveTo);
        } else {
            $word = $wordmatrix[$line_index]['word'];
            $sentence = $wordmatrix[$line_index]['sentence'];

            $word_saveTo = $base_dir . '/' . $post_id . '_' . $line_index . '.mp3';
            synthesizeAndSave($client, $word, $voice, $audioConfig, $word_saveTo);

            if ($sentence != '') {
                $sentence_saveTo = $base_dir . '/' . $post_id . '_' . $line_index . '_s.mp3';
                synthesizeAndSave($client, $sentence, $voice, $audioConfig, $sentence_saveTo);
            }
        }
    }
}

/**
 * if $line_index=NULL, then reload all
 */
function get_wordSound_by_voicerss_tts($wordmatrix, $isSentenceGame, $post_id, $line_index)
{
    global $current_user;

    $upload_dir = wp_upload_dir();

    if (is_null($line_index)) {
        foreach ($wordmatrix as $i => $row) {
            if ($isSentenceGame == 'yes') {
                //do nothing, voicerss_tts can not handle sentence
            } else {
                $word = $row['word'];
                $url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $word;
                $saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $i . '.mp3';
                curl_save_file($url, $saveTo);
            }
        }
    } else {
        if ($isSentenceGame == 'yes') {
            //do nothing, voicerss_tts can not handle sentence
        } else {
            $word = $wordmatrix[$line_index]['word'];
            $url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $word;
            $saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $line_index . '.mp3';
            curl_save_file($url, $saveTo);
        }
    }
}

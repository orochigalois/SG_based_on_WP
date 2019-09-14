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

    // instantiates a client
    $client = new TextToSpeechClient();
    // build the voice request, select the language code ("en-US") and the ssml
    // voice gender

    // All LanguageCodes refer to: https://cloud.google.com/text-to-speech/docs/voices
    $voice = (new VoiceSelectionParams())
        ->setLanguageCode('en-US')
        ->setSsmlGender(SsmlVoiceGender::MALE);

    // Effects profile
    $effectsProfileId = "telephony-class-application";

    // select the type of audio file you want returned
    $audioConfig = (new AudioConfig())
        ->setAudioEncoding(AudioEncoding::MP3)
        ->setEffectsProfileId(array($effectsProfileId));

    if (is_null($line_index)) {
        foreach ($wordmatrix as $i => $row) {
            if ($isSentenceGame == 'yes') {
                $sentence = $row['sentence'];
                $synthesisInputText = (new SynthesisInput())
                    ->setText($sentence);

                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();
                $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $i . '_s.mp3';

                file_put_contents($sentence_saveTo, $audioContent);
            } else {
                $word = $row['word'];
                $sentence = $row['sentence'];

                $synthesisInputText = (new SynthesisInput())
                    ->setText($word);

                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();

                $word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $i . '.mp3';

                // the response's audioContent is binary
                file_put_contents($word_saveTo, $audioContent);

                if ($sentence != '') {

                    $synthesisInputText->setText($sentence);

                    $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                    $audioContent = $response->getAudioContent();
                    $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $i . '_s.mp3';
                    file_put_contents($sentence_saveTo, $audioContent);
                }
            }
        }
    } else {

        if ($isSentenceGame == 'yes') {
            $sentence = $wordmatrix[$line_index]['sentence'];


            $synthesisInputText = (new SynthesisInput())
                ->setText($sentence);

            $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();

            $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $line_index . '_s.mp3';

            file_put_contents($sentence_saveTo, $audioContent);
        } else {
            $word = $wordmatrix[$line_index]['word'];
            $sentence = $wordmatrix[$line_index]['sentence'];

            $synthesisInputText = (new SynthesisInput())
                ->setText($word);

            $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();

            $word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $line_index . '.mp3';

            file_put_contents($word_saveTo, $audioContent);


            if ($sentence != '') {

                $synthesisInputText->setText($sentence);

                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();

                $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sound' . '/' . $post_id . '_' . $line_index . '_s.mp3';

                file_put_contents($sentence_saveTo, $audioContent);
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

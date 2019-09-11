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
        foreach ($wordmatrix as $i => $wordline) {


            if ($isSentenceGame == 'yes') {
                $sentence = str_replace("\r", "", $wordline['sentence']);



                if ($sentence != '') {
                    $synthesisInputText = (new SynthesisInput())
                        ->setText($sentence);

                    $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                    $audioContent = $response->getAudioContent();
                    $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/paragraph' . '/' . $post_id . '_' . $i . '.mp3';

                    file_put_contents($sentence_saveTo, $audioContent);
                }
            } else {
                $word = strtolower($wordline['word']);
                //If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
                $sentence = str_replace("\r", "", $wordline['sentence']);




                // sets text to be synthesised
                $synthesisInputText = (new SynthesisInput())
                    ->setText($word);



                // perform text-to-speech request on the text input with selected voice
                // parameters and audio file type
                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();





                $word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/word' . '/' . $word . '.mp3';


                // the response's audioContent is binary
                file_put_contents($word_saveTo, $audioContent);



                if ($sentence != '') {

                    $synthesisInputText->setText($sentence);

                    $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                    $audioContent = $response->getAudioContent();
                    $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sentence' . '/' . $word . '.mp3';

                    file_put_contents($sentence_saveTo, $audioContent);
                }
            }
        }
    } else {




        if ($isSentenceGame == 'yes') {
            $sentence = str_replace("\r", "", $wordmatrix[$line_index]['sentence']);



            if ($sentence != '') {
                $synthesisInputText = (new SynthesisInput())
                    ->setText($sentence);

                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();
                $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/paragraph' . '/' . $post_id . '_' . $line_index . '.mp3';

                file_put_contents($sentence_saveTo, $audioContent);
            }
        } else {
            $word = strtolower($wordmatrix[$line_index]['word']);
            //If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
            $sentence = str_replace("\r", "", $wordmatrix[$line_index]['sentence']);




            // sets text to be synthesised
            $synthesisInputText = (new SynthesisInput())
                ->setText($word);



            // perform text-to-speech request on the text input with selected voice
            // parameters and audio file type
            $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();





            $word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/word' . '/' . $word . '.mp3';


            // the response's audioContent is binary
            file_put_contents($word_saveTo, $audioContent);



            if ($sentence != '') {

                $synthesisInputText->setText($sentence);

                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();
                $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sentence' . '/' . $word . '.mp3';

                file_put_contents($sentence_saveTo, $audioContent);
            }
        }
    }
}
function get_wordSound_by_voicerss_tts($wordmatrix, $isSentenceGame)
{
    global $current_user;

    $upload_dir = wp_upload_dir();
    foreach ($wordmatrix as $wordline) {
        if ($isSentenceGame == 'yes') {
            //do nothing, voicerss_tts can not handle sentence
        } else {
            $word = strtolower($wordline['word']);
            //If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
            $sentence = str_replace("\r", "", $wordline['sentence']);

            $word_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $word;



            $word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/word' . '/' . $word . '.mp3';

            curl_save_file($word_url, $word_saveTo);


            if ($sentence != '') {
                $sentence_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $sentence;
                $sentence_url = str_replace(" ", "%20", $sentence_url);
                $sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sentence' . '/' . $word . '.mp3';

                curl_save_file($sentence_url, $sentence_saveTo);
            }
        }
    }
}

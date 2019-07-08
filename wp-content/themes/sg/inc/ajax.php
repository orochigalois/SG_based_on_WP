<?php

// getcwd() will return /Users/xinyin/Project/SG_based_on_WP/wp-admin/ , so we need going to parent folder
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . getcwd() . '/../wp-content/themes/sg/ShootingGame-98707e444ec6.json');

// [START tts_quickstart]
// includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

// Imports the Cloud Client Library
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

date_default_timezone_set('Australia/Melbourne');


session_start();
set_time_limit(0);

define('USER_AGENT', 'Mozilla/4.0');


function curl_request($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
function curl_save_file($url, $saveTo)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$fp = fopen($saveTo, 'w');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
	$result = curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}



function get_wordMatrix($wordlist_id, $already_loaded)
{

	//parse csv
	$filepath = get_attached_file($wordlist_id);

	$csvdata = file_get_contents($filepath);

	if ($already_loaded != 'yes') {
		//trim and put it back
		$csvdata = trim($csvdata);
		$csvdata = preg_replace("/[\r\n]+/", "\n", $csvdata);
		$csvdata = preg_replace("/[，]/u", ',', $csvdata);

		file_put_contents($filepath, $csvdata);
	}

	$count=0;
	$lines = explode("\n", $csvdata); // split data by new lines
	foreach ($lines as $i => $line) {
		$count++;
		$values = explode(',', $line, 2); // split lines by commas
		$wordmatrix[$i]['word'] = trim($values[0]);
		unset($values[0]);
		if (isset($values[1])) {
			$wordmatrix[$i]['sentence'] = trim($values[1]);
			unset($values[1]);
		} else {
			$wordmatrix[$i]['sentence'] = "";
		}
	}
	//save word count
	if (!add_post_meta($wordlist_id, '_sg_word_count', $count, true)) {
		update_post_meta($wordlist_id, '_sg_word_count', $count);
	}
	

	return $wordmatrix;
}

function get_wordSound_by_google_tts($wordmatrix)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $wordline) {
		$word = strtolower($wordline['word']);
		//If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
		$sentence = str_replace("\r", "", $wordline['sentence']);


		// instantiates a client
		$client = new TextToSpeechClient();

		// sets text to be synthesised
		$synthesisInputText = (new SynthesisInput())
			->setText($word);

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
function get_wordSound_by_voicerss_tts($wordmatrix)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $wordline) {
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


function get_wordImage($wordmatrix)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $wordline) {
		$word = strtolower($wordline['word']);
		$wordcode = rawurlencode($word);
		//parameters refer to https://developers.google.com/custom-search/v1/cse/list
		$word_url =  'https://www.googleapis.com/customsearch/v1?start=1&num=1&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=large&q=' . $wordcode;


		$result = curl_request($word_url);
		// write_log($result);
		$jsonobj = json_decode($result);

		// write_log($jsonobj);
		$image_link = "";

		foreach ($jsonobj->items as $value) {
			$image_link = $value->link;
		}
		// write_log($image_link);
		$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $word;


		curl_save_file($image_link, $image_saveTo);
	}
}





//_____________________________________________________________________________________Get all words
function ajax_getWords()
{
	$wordlist_id = $_GET['wordlist_id'];

	$already_loaded = (!empty($_GET['already_loaded']) ? (string)$_GET['already_loaded'] : 'no');

	$wordMatrix = get_wordMatrix($wordlist_id, $already_loaded);

	if ($already_loaded != 'yes') {

		$user = wp_get_current_user();
		$user_info = get_user_meta($user->ID);

		if (isset($user_info['tts'])) {
			if ($user_info['tts'][0] == 'voicerss') {
				get_wordSound_by_voicerss_tts($wordMatrix);
			} else {
				get_wordSound_by_google_tts($wordMatrix);
			}
		} else {
			get_wordSound_by_google_tts($wordMatrix);
		}

		get_wordImage($wordMatrix);
	}


	$result['status'] = "success";
	$result['wordMatrix'] = $wordMatrix;;

	if (!add_post_meta($wordlist_id, '_sg_wordlist_already_loaded', 'yes', true)) {
		update_post_meta($wordlist_id, '_sg_wordlist_already_loaded', 'yes');
	}


	//store $wordmatrix
	$_SESSION['wordMatrix'] = $wordMatrix;

	//store $wordlist_id
	$_SESSION['wordlist_id'] = $wordlist_id;
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_getWords', 'ajax_getWords');
add_action('wp_ajax_getWords', 'ajax_getWords');





function ajax_updateScore()
{
	date_default_timezone_set('Australia/Melbourne');
	$score_meta = date("Y-m-d H:i:s");
	add_post_meta($_GET['wordlist_id'], '_sg_dictation_score', $score_meta);


	$result['status'] = "success";
	print json_encode($result);
}
add_action('wp_ajax_nopriv_updateScore', 'ajax_updateScore');
add_action('wp_ajax_updateScore', 'ajax_updateScore');



function ajax_get_images()
{
	$start = (intval($_GET["page"]) - 1) * 9 + 1;
	$wordcode = rawurlencode($_GET["word"]);
	$url =  'https://www.googleapis.com/customsearch/v1?start=' . $start . '&num=9&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=large&q=' . $wordcode;


	$result = curl_request($url);
	$jsonobj = json_decode($result);

	$return_str = '<ul>';


	foreach ($jsonobj->items as $value) {
		$return_str = $return_str . '<li><img src="'
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
	$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $_GET["word"];

	curl_save_file($_GET["imageUrl"], $image_saveTo);
	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_save_images', 'ajax_save_images');
add_action('wp_ajax_save_images', 'ajax_save_images');



function ajax_update_title()
{
	$wordlist_id = $_GET['wordlist_id'];

	$title = $_GET['title'];

	$file = get_attached_file($wordlist_id);
    $path = pathinfo($file);
        //dirname   = File Path
        //basename  = Filename.Extension
        //extension = Extension
        //filename  = Filename

    $newfile = $path['dirname']."/".$title.".".$path['extension'];

    rename($file, $newfile);    
	update_attached_file( $wordlist_id, $newfile );


	$my_post = array(
		'ID'           => $wordlist_id,
		'post_title'   => $title,
	);
  
	wp_update_post( $my_post );

	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_update_title', 'ajax_update_title');
add_action('wp_ajax_update_title', 'ajax_update_title');



function ajax_update_word()
{
	$wordlist_id = $_GET['wordlist_id'];
	$index = $_GET['index'];

	$word = $_GET['word'];
	$sentence = $_GET['sentence'];

	$file = get_attached_file($wordlist_id);

	$lines = file($file, FILE_IGNORE_NEW_LINES);
	$lines[$index] = $word.','.$sentence;
	file_put_contents($file, implode("\n", $lines));

	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_update_word', 'ajax_update_word');
add_action('wp_ajax_update_word', 'ajax_update_word');
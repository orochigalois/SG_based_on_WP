<?php

// getcwd() will return /Users/xinyin/Project/SG_based_on_WP/wp-admin/ , so we need going to parent folder
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . getcwd() . '/../wp-content/themes/sg/ShootingGame-98707e444ec6.json');

// [START tts_quickstart]
// includes the autoloader for libraries installed with composer
require __DIR__ . '/../vendor/autoload.php';

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



function prepare_wordMatrix($post_id, $isSentenceGame)
{
	$lines = get_content_in_the($post_id);
	if ($isSentenceGame == "yes") {
		foreach ($lines as $i => $line) {
			$wordmatrix[$i]['sentence'] = $line;
		}
	} else {
		$wordmatrix = $lines;
	}
	return $wordmatrix;
}


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


function get_wordImage($wordmatrix, $isSentenceGame, $post_id)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $i => $wordline) {

		if ($isSentenceGame == 'yes') {
			$word = strtolower($wordline['sentence']);
		} else {
			$word = strtolower($wordline['word']);
		}
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

		if ($isSentenceGame == 'yes') {



			$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $post_id . '_' . $i;
		} else {
			$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $word;
		}



		curl_save_file($image_link, $image_saveTo);
	}
}





//__________________________________________________________________________________________________________ALL ajax interface
function ajax_getWords()
{
	$post_id = $_GET['post_id'];
	$isSentenceGame = $_GET['isSentenceGame'];
	$already_loaded = (!empty($_GET['already_loaded']) ? (string) $_GET['already_loaded'] : 'no');

	$wordMatrix = prepare_wordMatrix($post_id, $isSentenceGame);

	if ($already_loaded != 'yes') {

		$user = wp_get_current_user();
		$user_info = get_user_meta($user->ID);

		if (isset($user_info['tts'])) {
			if ($user_info['tts'][0] == 'voicerss') {
				get_wordSound_by_voicerss_tts($wordMatrix, $isSentenceGame);
			} else {
				get_wordSound_by_google_tts($wordMatrix, $isSentenceGame, $post_id, NULL);
			}
		} else {
			get_wordSound_by_google_tts($wordMatrix, $isSentenceGame, $post_id, NULL);
		}

		get_wordImage($wordMatrix, $isSentenceGame, $post_id);

		update_post_meta($post_id, 'sg_already_loaded', 'yes');
	}


	$result['status'] = "success";
	$result['wordMatrix'] = $wordMatrix;;


	//store $wordmatrix
	$_SESSION['wordMatrix'] = $wordMatrix;

	//store $post_id
	$_SESSION['post_id'] = $post_id;
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_getWords', 'ajax_getWords');
add_action('wp_ajax_getWords', 'ajax_getWords');





function ajax_updateScore()
{
	date_default_timezone_set('Australia/Melbourne');
	$score_meta = date("Y-m-d H:i:s");
	add_post_meta($_GET['post_id'], 'sg_done_once', $score_meta);

	$result['status'] = "success";
	print json_encode($result);
	wp_die();
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
	$isSentenceGame = $_GET['isSentenceGame'];

	if ($isSentenceGame == 'yes') {
		$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $_GET["sentence"];
	} else {
		$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $_GET["word"];
	}
	curl_save_file($_GET["imageUrl"], $image_saveTo);
	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_save_images', 'ajax_save_images');
add_action('wp_ajax_save_images', 'ajax_save_images');



function ajax_update_title()
{
	$post_id = $_GET['post_id'];
	$title = $_GET['title'];

	//Step1. update file name in upload folder
	$file = get_attached_file($post_id);
	$path = pathinfo($file);
	//dirname   = File Path
	//basename  = Filename.Extension
	//extension = Extension
	//filename  = Filename

	$newfile = $path['dirname'] . "/" . $title . "." . $path['extension'];

	rename($file, $newfile);
	update_attached_file($post_id, $newfile);

	//Step2. update file name in wp_post
	$my_post = array(
		'ID'           => $post_id,
		'post_title'   => $title,
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

	//Step2. update sentence in db
	$lines = get_content_in_the($post_id);

	$lines[$index]['word'] = $word;
	$lines[$index]['sentence'] = $sentence;

	$serialized_data = maybe_serialize($lines);

	$my_post = array(
		'ID'           => $post_id,
		'post_content' => $serialized_data,
	);
	wp_update_post($my_post);

	//Step3. refresh the wordMatrix

	$wordMatrix = $_SESSION['wordMatrix'];
	$wordMatrix[$index]['word'] = $word;
	$wordMatrix[$index]['sentence'] = $sentence;
	$_SESSION['wordMatrix'] = $wordMatrix;

	//Step4. reload the voice
	get_wordSound_by_google_tts($_SESSION['wordMatrix'], "no", $post_id, $index);


	//Step5. return
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
	$lines = get_content_in_the($post_id);

	$lines[$index] = $sentence;

	$serialized_data = maybe_serialize($lines);

	$my_post = array(
		'ID'           => $post_id,
		'post_content' => $serialized_data,
	);
	wp_update_post($my_post);



	//Step3. refresh the wordMatrix

	$wordMatrix = $_SESSION['wordMatrix'];
	$wordMatrix[$index] = $sentence;
	$_SESSION['wordMatrix'] = $wordMatrix;

	//Step4. reload the voice
	get_wordSound_by_google_tts($_SESSION['wordMatrix'], "yes", $post_id, $index);

	//Step5. return
	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_update_sentence', 'ajax_update_sentence');
add_action('wp_ajax_update_sentence', 'ajax_update_sentence');



/*
http://sg.local/wp-admin/admin-ajax.php?action=collect_sentence&sentence=I love you.&user_id=7
*/
function ajax_collect_sentence()
{


	$sentence = $_GET['sentence'];
	//remove backslash
	$sentence = str_replace('\\', '', $sentence);
	$sg_user_token = $_GET['sg_user_token'];

	$users = get_users(array('meta_key' => 'sg_user_token', 'meta_value' => $sg_user_token));

	if (isset($users[0]))
		$user_id = $users[0]->id;
	else {
		$result['status'] = "Your token is not correct";
		print json_encode($result);
		wp_die();
	}


	$file_exist = false;

	//It opens and writes to the end of the file or creates a new file if it doesn’t exist.
	$wp_upload_dir = wp_upload_dir();
	$my_file_name = $wp_upload_dir['path'] . '/' . $user_id . '_collection_' . date('Y-m-d') . '.txt';

	if (file_exists($my_file_name)) {
		$file_exist = true;
	}

	$fp = fopen($my_file_name, "a");

	fwrite($fp, $sentence);
	fclose($fp);

	if (!$file_exist) {
		// $filename should be the path to a file in the upload directory.
		$filename = $my_file_name;

		// The ID of the post this attachment is for.
		$parent_post_id = 0;

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype(basename($filename), null);

		$serialized_data = array();
		$serialized_data[] = trim($sentence);
		$serialized_data = maybe_serialize($serialized_data);

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content'   => $serialized_data,
			'post_status'    => 'inherit',
			'post_author'    => $user_id
		);

		// Insert the attachment.
		$post_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
		update_post_meta($post_id, 'sg_word_or_sentence', 'sentence');
		update_user_meta($user_id, 'sg_current_sentence_post_id_for_REST_API', $post_id);
	} else {
		$sg_current_sentence_post_id_for_REST_API = get_user_meta($user_id, 'sg_current_sentence_post_id_for_REST_API', true);

		$serialized_data = get_content_in_the($sg_current_sentence_post_id_for_REST_API);
		$serialized_data[] = trim($sentence);
		$serialized_data = maybe_serialize($serialized_data);

		$my_post = array(
			'ID'           => $sg_current_sentence_post_id_for_REST_API,
			'post_content' => $serialized_data,
		);
		// Update the post into the database
		wp_update_post($my_post);
	}



	$result['status'] = "success";
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_collect_sentence', 'ajax_collect_sentence');
add_action('wp_ajax_collect_sentence', 'ajax_collect_sentence');

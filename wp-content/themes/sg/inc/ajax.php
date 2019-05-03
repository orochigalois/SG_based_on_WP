<?php
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



function get_wordMatrix($wordlist_id)
{

	//parse csv
	$filepath = get_attached_file($wordlist_id);

	$csvdata = file_get_contents($filepath);
	$lines = explode("\n", $csvdata); // split data by new lines
	foreach ($lines as $i => $line) {
		$values = explode(',', $line); // split lines by commas
		$wordmatrix[$i]['word'] = trim($values[0]);
		unset($values[0]);
		$wordmatrix[$i]['sentence'] = trim($values[1]);
		unset($values[1]);
	}

	return $wordmatrix;
}

function get_wordSound($wordmatrix)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $wordline) {
		$word = strtolower($wordline['word']);
		//If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
		$sentence = str_replace("\r", "", $wordline['sentence']);

		$word_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $word;



		$word_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/word' . '/' . $word . '.mp3';

		// curl_save_file($word_url, $word_saveTo);


		if (!file_exists($word_saveTo)) {
			curl_save_file($word_url, $word_saveTo);
		}
		if (abs(filesize($word_saveTo)) < 2000) {
			curl_save_file($word_url, $word_saveTo);
		}

		if ($sentence != '') {
			$sentence_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $sentence;
			$sentence_url = str_replace(" ", "%20", $sentence_url);
			$sentence_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/sentence' . '/' . $word . '.mp3';

			// curl_save_file($sentence_url, $sentence_saveTo);

			if (!file_exists($sentence_saveTo)) {
				curl_save_file($sentence_url, $sentence_saveTo);
			}
			if (abs(filesize($sentence_saveTo)) < 2000) {
				curl_save_file($sentence_url, $sentence_saveTo);
			}
		}


		
	}
}



function get_wordImage($wordmatrix)
{
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach ($wordmatrix as $wordline) {
		$word = strtolower($wordline['word']);

		//parameters refer to https://developers.google.com/custom-search/v1/cse/list
		$word_url =  'https://www.googleapis.com/customsearch/v1?start=1&num=1&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=large&q='. $word;


		$result=curl_request($word_url);
		$jsonobj = json_decode($result);
		$image_link="";

		foreach($jsonobj->items as $value)
		{                        
			$image_link = $value->link;
		}

		$image_saveTo = $upload_dir['basedir'] . '/userdata' . $current_user->ID . '/picture' . '/' . $word;

		// curl_save_file($word_url, $image_saveTo);


		if (!file_exists($image_saveTo)) {
			curl_save_file($image_link, $image_saveTo);
		}
		if (abs(filesize($image_saveTo)) < 2000) {
			curl_save_file($image_link, $image_saveTo);
		}

		
	}
}





//_____________________________________________________________________________________Get all words
function ajax_getWords()
{
	$wordlist_id = (!empty($_GET['wordlist_id']) ? (string)$_GET['wordlist_id'] : '');
	$wordMatrix = get_wordMatrix($wordlist_id);

	get_wordSound($wordMatrix);

	$image = get_wordImage($wordMatrix);





	$result['status'] = "success";
	$result['wordMatrix'] = $wordMatrix;
	$result['image'] = $image;


	//store $wordmatrix
	$_SESSION['wordMatrix']=$wordMatrix;
	print json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_getWords', 'ajax_getWords');
add_action('wp_ajax_getWords', 'ajax_getWords');

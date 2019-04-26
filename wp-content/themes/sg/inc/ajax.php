<?php
set_time_limit(0);
////////If a proxy should be used in server,update this 2 constants
define('USE_PROXY', false);
define('PROXY_ADDRESS', 'http://10.10.5.18:8080');

define('USER_AGENT', 'Mozilla/4.0');

////////This is account key for bing
define('BING_ACCOUNT_KEY', 'kw/qlYGBk1WPFi6b+GyC/o6BzxO+0cEiXn/GRw7ba60=');

function curl_return_string($url)
{
	$ch = curl_init();
	if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_ADDRESS);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	curl_setopt ($ch, CURLOPT_HEADER, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	$result = curl_exec ($ch);
	curl_close($ch);
	return $result;
}
function curl_through_bing($url)
{
	$headers = array(
	        "Authorization: Basic " . base64_encode(BING_ACCOUNT_KEY . ":" . BING_ACCOUNT_KEY)
	    );
	
	$ch = curl_init();
	if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_ADDRESS);
	
	// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec ($ch);
	curl_close($ch);
	return $result;
}
function curl_save_file($url,$saveTo)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	$fp = fopen ($saveTo, 'w');
	curl_setopt ($ch, CURLOPT_FILE, $fp);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	$result = curl_exec ($ch);
	curl_close($ch);
	fclose($fp);
}



function ajax_downloadSound(){
	$title = (!empty($_GET['title']) ? (string) $_GET['title'] : '');
	$wordlist_id = (!empty($_GET['wordlist_id']) ? (string) $_GET['wordlist_id'] : '');

	//1.parse csv
	$filepath=get_attached_file( $wordlist_id );


	$csvdata = file_get_contents($filepath);
	$lines = explode("\n", $csvdata); // split data by new lines
	foreach ($lines as $i => $line) {
		$values = explode(',', $line); // split lines by commas
		// set values removing them as we ago
		$wordmatrix[$i]['word'] = trim($values[0]); unset($values[0]);
		$wordmatrix[$i]['sentence'] = trim($values[1]); unset($values[1]);
	}






	//2.get sounds
	global $current_user;

	$upload_dir = wp_upload_dir();
	foreach($wordmatrix as $wordline){
		$word = strtolower($wordline['word']);
		//If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
		$sentence = str_replace("\r", "", $wordline['sentence']);

		$word_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $word;

		
		
		$word_saveTo = $upload_dir['basedir'].'/userdata' . $current_user->ID . '/word' .'/'. $word . '.mp3';

		curl_save_file($word_url, $word_saveTo);


		// if (!file_exists($word_saveTo)) {
		// 	curl_save_file($word_url, $word_saveTo);
		// }
		// if (abs(filesize($word_saveTo)) < 2000) {
		// 	curl_save_file($word_url, $word_saveTo);
		// }

		$sentence_url = "http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=" . $sentence;
		$sentence_url = str_replace(" ", "%20", $sentence_url);
		$sentence_saveTo = $upload_dir['basedir'].'/userdata' . $current_user->ID . '/sentence' .'/'. $word . '.mp3';

		curl_save_file($sentence_url, $sentence_saveTo);

		// if (!file_exists($sentence_saveTo)) {
		// 	curl_save_file($sentence_url, $sentence_saveTo);
		// }
		// if (abs(filesize($sentence_saveTo)) < 2000) {
		// 	curl_save_file($sentence_url, $sentence_saveTo);
		// }
	}


	//3.get image


	$result['status']="success";
	$result['title']=$title;

	print json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_downloadSound', 'ajax_downloadSound');
add_action('wp_ajax_downloadSound', 'ajax_downloadSound');
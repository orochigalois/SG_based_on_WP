<?php 

$url='http://api.voicerss.org/?key=67f9eca9271045e38b2cfa24fe9c887a&hl=en-us&src=nice';
$saveTo='/Users/xinyin/Project/SG_based_on_WP/wp-content/uploads/userdata2/word/nice.mp3';
$saveTo='/Users/xinyin/Project/SG_based_on_WP/wp-content/uploads/userdata2/nice.mp3';
$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	$fp = fopen ($saveTo, 'w');
	curl_setopt ($ch, CURLOPT_FILE, $fp);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	$result = curl_exec ($ch);
	curl_close($ch);
	fclose($fp);?>




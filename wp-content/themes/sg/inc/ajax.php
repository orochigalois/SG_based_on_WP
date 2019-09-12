<?php

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


function ajax_getWords()
{
	$post_id = $_GET['post_id'];
	$isSentenceGame = $_GET['isSentenceGame'];
	$already_loaded = (!empty($_GET['already_loaded']) ? (string) $_GET['already_loaded'] : 'no');

	$wordMatrix = prepare_wordMatrix($post_id, $isSentenceGame);

	if ($already_loaded != 'yes') {

		$user = wp_get_current_user();
		$user_info = get_user_meta($user->ID);

		if (isset($user_info['sg_tts'])) {
			if ($user_info['sg_tts'][0] == 'voicerss') {
				get_wordSound_by_voicerss_tts($wordMatrix, $isSentenceGame);
			} else {
				get_wordSound_by_google_tts($wordMatrix, $isSentenceGame, $post_id, NULL);
			}
		} else {
			get_wordSound_by_google_tts($wordMatrix, $isSentenceGame, $post_id, NULL);
		}

		get_word_translation($wordMatrix, $isSentenceGame, $post_id, NULL);

		get_wordImage($wordMatrix, $isSentenceGame, $post_id);

		update_post_meta($post_id, 'sg_already_loaded', 'yes');
	}

	$wordMatrix = prepare_wordMatrix($post_id, $isSentenceGame);
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

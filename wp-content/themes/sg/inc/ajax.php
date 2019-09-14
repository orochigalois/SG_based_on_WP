<?php


function ajax_getWords()
{
	$post_id = $_GET['post_id'];
	$isSentenceGame = $_GET['isSentenceGame'];
	$already_loaded = (!empty($_GET['already_loaded']) ? (string) $_GET['already_loaded'] : 'no');

	$word_matrix = new WordMatrix($post_id);

	if ($already_loaded != 'yes') {

		$user = wp_get_current_user();
		$user_info = get_user_meta($user->ID);

		if (isset($user_info['sg_tts'])) {
			if ($user_info['sg_tts'][0] == 'voicerss') {
				get_wordSound_by_voicerss_tts($word_matrix->data, $isSentenceGame, $post_id, NULL);
			} else {
				get_wordSound_by_google_tts($word_matrix->data, $isSentenceGame, $post_id, NULL);
			}
		} else {
			get_wordSound_by_google_tts($word_matrix->data, $isSentenceGame, $post_id, NULL);
		}

		get_wordImage($word_matrix->data, $isSentenceGame, $post_id);

		get_word_translation($word_matrix, $isSentenceGame, $post_id, NULL);

		update_post_meta($post_id, 'sg_already_loaded', 'yes');
	}

	$result['status'] = "success";
	$result['wordMatrix'] = $word_matrix->data;;

	//store $post_id
	update_user_meta($user->ID, "sg_current_post", $post_id);
	print json_encode($result);
	wp_die();
}
add_action('wp_ajax_nopriv_getWords', 'ajax_getWords');
add_action('wp_ajax_getWords', 'ajax_getWords');

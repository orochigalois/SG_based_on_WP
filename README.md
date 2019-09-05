# SG_based_on_WP


1. All meta name in DB should start with 'sg_' , let's list all metas we use

In wp_usermeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_current_sentence_post_id_for_REST_API  (value: post_id)    single

In wp_postmeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_already_loaded    (value: yes / no)    single
sg_done_once    (value: something like 2017-01-12 07:56:23 etc.)    multiple

2. 
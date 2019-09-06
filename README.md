# SG_based_on_WP


1. All meta name in DB should start with 'sg_' , let's list all metas we use

In wp_usermeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_current_sentence_post_id_for_REST_API  (value: post_id)    single
sg_current_word_post_id_for_REST_API    (value: post_id)    single

In wp_postmeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_already_loaded    (value: yes / no)    single
sg_done_once    (value: something like 2017-01-12 07:56:23 etc.)    multiple

2. How to deploy on a new server

a.create a new db, import sg_2019-09-04_clean_version_with_mailgun_setup.sql, run srdb

b.remove all under wp-content\uploads\

c.upload all files to server

d.chmod -R 777 wp-content/upload

d.register a new user and it's good to go

e.update admin password,deactive all plugins


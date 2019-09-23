# Dev Note


###1. All meta name in DB should start with 'sg_' , let's list all metas we use

In wp_usermeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_current_sentence_post_id_for_REST_API  (value: post_id)    single
sg_current_word_post_id_for_REST_API    (value: post_id)    single
sg_your_native_language (value: zh / en / ... etc.)    single
sg_tts (value: google / voicerss)    single
sg_current_post  (value: post_id)   single

In wp_postmeta:

sg_word_or_sentence   (value: sentence / word)    single
sg_already_loaded    (value: yes / no)    single
sg_done_once    (value: something like 2017-01-12 07:56:23 etc.)    multiple

###2. How to deploy on a new server

a.install php-curl on the server

b.google image API got a IP restriction, update the rule on API cloud console to allow the new server's IP

c.create a new db, import sg_2019-09-04_clean_version_with_mailgun_setup.sql, run srdb

d.remove all under wp-content\uploads\

e.upload all files to server

f.chmod -R 777 wp-content  (otherwise delog.log will not be created)

g.register a new user and it's good to go

h.update admin password,deactive all plugins



###3.ShootingGame-98707e444ec6.json is a universal key for all google cloud API(tts,translate, etc.)


###4.compposer.json is the only file you need to generate the google API vendor folder. 
run
composer install


###5. File Sample
Word Game:
userdata3/sound/3_1.mp3  (word)
userdata3/sound/3_1s.mp3  (sentence)
userdata3/picture/3_1

Sentence Game:
userdata3/sound/4_1s.mp3  (sentence)
userdata3/picture/4_1


###6. DB Sample

Array
(
    [0] => Array
        (
            [word] => what
            [word_in_native_language] => 什么
            [sentence] => what is a test
            [sentence_in_native_language] => 什么是测试
        )

    [1] => Array
        (
            [word] => girl
            [word_in_native_language] => 女孩
            [sentence] => good girl
            [sentence_in_native_language] => 好女孩
        )

)


###7. How to set up a brand new app for test

a.delete db and import sg_2019-09-17_clean_version_with_mailgun_setup_ready_to_go.sql, there is only one account named 'test' in it
b.remove 'wp-content/uploads' folder
c.duplicate folder 'uploads_for_test', rename it to 'uploads'
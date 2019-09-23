<?php
class Book
{
    public $post_id;

    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    public function upload_content()
    {
        //Step1. update post meta 'sg_word_or_sentence'
        $user = wp_get_current_user();
        $sg_word_or_sentence = get_user_meta($user->ID, 'sg_word_or_sentence', true);

        if ($sg_word_or_sentence == "sentence") {
            update_post_meta($this->post_id, 'sg_word_or_sentence', 'sentence');
        } else {
            update_post_meta($this->post_id, 'sg_word_or_sentence', 'word');
        }

        //Step2. import&serialize file data to field 'post_content'
        $filepath = get_attached_file($this->post_id);
        $filedata = file_get_contents($filepath);

        //tidy up the raw data
        $filedata = trim($filedata);
        $filedata = preg_replace("/[，]/u", ',', $filedata);
        $filedata = preg_replace("/[。]/u", '.', $filedata);
        $filedata = preg_replace("/[？]/u", '?', $filedata);
        $filedata = preg_replace("/[！]/u", '!', $filedata);

        $count = 0;
        $serialized_data = array();

        if ($sg_word_or_sentence == "sentence") {
            //Multiple spaces and newlines are replaced with a single space.
            $filedata = preg_replace('/\s+/', ' ', $filedata);

            $lines = multiexplode(array("?", ".", "!", ":", ";"), $filedata);


            foreach ($lines as $i => $line) {

                if (trim($line) != "") {
                    $count++;
                    $serialized_data[$i]['word'] = "";
                    $serialized_data[$i]['word_in_native_language'] = "";
                    $serialized_data[$i]['sentence'] = trim($line);
                    $serialized_data[$i]['sentence_in_native_language'] = "";
                }
            }
        } else {
            $filedata = preg_replace("/[\r\n]+/", "\n", $filedata);

            $lines = explode("\n", $filedata); // split data by new lines
            foreach ($lines as $i => $line) {
                $count++;
                $values = explode(',', $line, 2); // split lines by commas
                $serialized_data[$i]['word'] = trim($values[0]);
                unset($values[0]);
                if (isset($values[1])) {
                    $serialized_data[$i]['sentence'] = trim($values[1]);
                    unset($values[1]);
                } else {
                    $serialized_data[$i]['sentence'] = "";
                }
                $serialized_data[$i]['word_in_native_language'] = "";
                $serialized_data[$i]['sentence_in_native_language'] = "";
            }
        }


        $serialized_data = maybe_serialize($serialized_data);

        $my_post = array(
            'ID'           => $this->post_id,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    }


    public function get_matrix()
    {
        $my_post = get_post($this->post_id);
        $content = $my_post->post_content;
        $matrix = maybe_unserialize($content);
        return $matrix;
    }

    public function write_to_db($matrix)
    {
        $serialized_data = maybe_serialize($matrix);

        $my_post = array(
            'ID'           => $this->post_id,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    }
}

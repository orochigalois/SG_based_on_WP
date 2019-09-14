<?php
class WordMatrix
{
    public $data;
    public $post_id;

    public function __construct($post_id)
    {
        $this->post_id = $post_id;
        $my_post = get_post($post_id);
        $content = $my_post->post_content;
        $this->data = maybe_unserialize($content);
    }
    public function refresh_data($post_id)
    {
        $this->post_id = $post_id;
        $my_post = get_post($post_id);
        $content = $my_post->post_content;
        $this->data = maybe_unserialize($content);
    }
    public function write_to_db()
    {
        $serialized_data = maybe_serialize($this->data);

        $my_post = array(
            'ID'           => $this->post_id,
            'post_content' => $serialized_data,
        );
        // Update the post into the database
        wp_update_post($my_post);
    }

    public function count()
    {
        return count($this->data);
    }
}

<?php
global $wpdb;
global $current_user;

$sg_word_or_sentence = get_user_meta($current_user->ID, 'sg_word_or_sentence', true);

if ($sg_word_or_sentence == "sentence") :
    $type = "sentence";
else :
    $type = "word";
endif;


$all_scored_posts = $wpdb->get_results(
    "
    select c.meta_value, c.post_title from
    (select a.post_id, a.meta_value, b.post_title from wp_postmeta a left join wp_posts b on a.post_id=b.id where a.`meta_key`='sg_done_once' and b.post_author='{$current_user->ID}' order by `meta_value` desc) c 
    left join 
    wp_postmeta d 
    on c.post_id=d.post_id where d.`meta_key`='sg_word_or_sentence' and d.`meta_value`='{$type}'
    order by `meta_value` desc
    "
);
echo "<table><tr>
<th>complete time</th>
<th>vocabulary name</th>
</tr>";
foreach ($all_scored_posts as $score) {
    echo "<tr><td>" . $score->meta_value . "</td><td>" . $score->post_title . "</td></tr>";
}
echo "</table>";

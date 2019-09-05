<?php
global $wpdb;
global $current_user;

$sg_word_or_sentence = get_user_meta($current_user->ID, 'sg_word_or_sentence', true);

if ($sg_word_or_sentence == "sentence") :
    $type = "sentence";
else :
    $type = "word";
endif;

$SQL_get_scored_posts = "
        select c.post_id, c.post_title, c.times FROM 
        (SELECT post_id, post_title,COUNT(meta_key) as times FROM wp_postmeta a left join wp_posts b on a.post_id=b.id
            WHERE meta_key='sg_done_once' and b.post_author='{$current_user->ID}' group by post_id order by COUNT(meta_key) desc,`meta_value` desc) c left join wp_postmeta d on c.post_id=d.post_id where d.`meta_key`='sg_word_or_sentence' and d.`meta_value`='{$type}'
            ";

$SQL_get_all_posts = "
        SELECT ID,post_title from wp_posts a left join wp_postmeta b on a.id=b.post_id 
        WHERE post_author='{$current_user->ID}' and b.`meta_key`='sg_word_or_sentence' and b.`meta_value`='{$type}'
        ";

$all_scored_posts = $wpdb->get_results($SQL_get_scored_posts);
$all_posts = $wpdb->get_results($SQL_get_all_posts);

$items_count = 0;
$complete_times = 0;

echo "<table>
    <tr>
    <th>vocabulary name</th>
    <th>items count</th>
    <th>complete times</th>
    </tr>";
foreach ($all_scored_posts as $score) {
    $items_count += get_how_many_items_in_the($score->post_id);
    $complete_times += $score->times;
    echo "<tr><td>" . $score->post_title . "</td><td>" . get_how_many_items_in_the($score->post_id) . "</td><td>" . $score->times . "</td></tr>";
}
foreach ($all_posts as $sentence_post) {
    if (!has_been_ever_practised($sentence_post->ID, $all_scored_posts)) {
        $items_count += get_how_many_items_in_the($sentence_post->ID);
        echo "<tr><td>" . $sentence_post->post_title . "</td><td>" . get_how_many_items_in_the($sentence_post->ID) . "</td><td class='red'>0</td></tr>";
    }
}
echo "<tr>
    <td>total</td>
    <td>" . $items_count . "</td>
    <td>" . $complete_times . "</td>
    </tr>";
echo "</table>";



function has_been_ever_practised($id, $all_scored_posts)
{
    foreach ($all_scored_posts as $score) {
        if ($score->post_id == $id) {
            return true;
        }
    }
    return false;
}


<?php
global $wpdb;
global $current_user;

$sg_word_or_sentence = get_user_meta($current_user->ID, 'sg_word_or_sentence', true);



if ($sg_word_or_sentence == "sentence") {
    echo "<table><tr>
    <th>sentence</th>
    <th>date</th>
    </tr>";

    $all_posts = $wpdb->get_results(
        "
        SELECT a.ID,a.post_date from {$wpdb->posts} a left join {$wpdb->postmeta} b on a.id=b.post_id WHERE post_author='{$current_user->ID}' and meta_key='sg_word_or_sentence' and meta_value='sentence'
        "
    );

    foreach ($all_posts as $sentence_post) {


        $book = new Book($sentence_post->ID);
        $word_matrix = $book->get_matrix();

        foreach ($word_matrix as $i => $line) {
            echo "<tr>";
            echo "<td>" . $line . "</td>";
            echo "<td style='width:150px;'>" . $sentence_post->post_date . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {

    echo "<table><tr>
<th>word</th>
<th>sentence</th>
<th>date</th>
</tr>";

    $all_posts = $wpdb->get_results(
        "
	SELECT a.ID,a.post_date from {$wpdb->posts} a left join {$wpdb->postmeta} b on a.id=b.post_id WHERE post_author='{$current_user->ID}' and meta_key='sg_word_or_sentence' and meta_value='word'
    "
    );

    foreach ($all_posts as $word_post) {


        $book = new Book($word_post->ID);
        $word_matrix = $book->get_matrix();


        foreach ($word_matrix as $i => $line) {
            echo "<tr>";
            echo "<td>" . $line['word'] . "</td>";
            echo "<td>" . $line['sentence']  . "</td>";
            echo "<td style='width:150px;'>" . $word_post->post_date . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}





?>
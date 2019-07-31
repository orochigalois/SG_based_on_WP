

<?php
global $wpdb;
global $current_user;

$user = wp_get_current_user();
$main_entry = get_user_meta($user->ID, 'main_entry', true);

if ($main_entry == "sentence") {
    $score_meta_key = '_sg_sentence_score';
} else {
    $score_meta_key = '_sg_dictation_score';
}

$scores = $wpdb->get_results(
    "
	SELECT a.meta_value, b.post_title FROM {$wpdb->postmeta} a left join {$wpdb->posts} b on a.post_id=b.id
    WHERE meta_key='{$score_meta_key}' and b.post_author='{$current_user->ID}' order by `meta_value` desc
    "
);
echo "<table><tr>
<th>complete time</th>
<th>vocabulary</th>
</tr>";
foreach ($scores as $score) {
    echo "<tr><td>" . $score->meta_value . "</td><td>" . $score->post_title . "</td></tr>";
}
echo "</table>";


?>
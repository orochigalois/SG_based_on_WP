

<?php 
global $wpdb;
global $current_user;
$scores = $wpdb->get_results( 
	"
	SELECT post_title,COUNT(meta_key) as times FROM {$wpdb->postmeta} a left join {$wpdb->posts} b on a.post_id=b.id
    WHERE meta_key='_sg_dictation_score' and b.post_author='{$current_user->ID}' group by post_id order by `meta_value` desc
    "
);
echo "<ul>";
foreach ( $scores as $score ) 
{
    echo "<li>".$score->post_title."&nbsp;&nbsp;|&nbsp;&nbsp;".$score->times."</li>";
}
echo "</ul>";


 ?>
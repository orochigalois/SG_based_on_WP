

<?php 
global $wpdb;

$scores = $wpdb->get_results( 
	"
	SELECT a.meta_value, b.post_title FROM {$wpdb->postmeta} a left join {$wpdb->posts} b on a.post_id=b.id
    WHERE meta_key='_sg_dictation_score' order by `meta_value` desc
	"
);
echo "<ul>";
foreach ( $scores as $score ) 
{
    echo "<li>".$score->meta_value."&nbsp;&nbsp;|&nbsp;&nbsp;".$score->post_title."</li>";
}
echo "</ul>";


 ?>
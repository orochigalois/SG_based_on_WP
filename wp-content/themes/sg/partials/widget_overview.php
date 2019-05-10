

<?php 
global $wpdb;
global $current_user;
$scores = $wpdb->get_results( 
	"
	SELECT post_id, post_title,COUNT(meta_key) as times FROM {$wpdb->postmeta} a left join {$wpdb->posts} b on a.post_id=b.id
    WHERE meta_key='_sg_dictation_score' and b.post_author='{$current_user->ID}' group by post_id order by COUNT(meta_key) desc,`meta_value` desc
    "
);

$all_ids = $wpdb->get_results( 
	"
	SELECT ID,post_title from {$wpdb->posts}
    WHERE post_author='{$current_user->ID}'
    "
);
echo "<table><tr>
<th>vocabulary</th>
<th>complete</th>
</tr>";
foreach ( $scores as $score ) 
{
    echo "<tr><td>".$score->post_title."</td><td>".$score->times."</td></tr>";
}
foreach ( $all_ids as $all_id )
{
    if(!id_is_in_score($scores,$all_id->ID))
        echo "<tr><td>".$all_id->post_title."</td><td class='red'>0</td></tr>";
}
echo "</table>";


function id_is_in_score($scores,$all_id){
    foreach ( $scores as $score ) 
    {
        if($score->post_id==$all_id)
        {
            return true;
        }
            
    }
    return false;

}

 ?>
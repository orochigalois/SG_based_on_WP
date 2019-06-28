

<?php 
global $wpdb;
global $current_user;
$scores = $wpdb->get_results( 
    "select c.post_id, c.post_title, c.times, d.`meta_value` as words FROM 
    (SELECT post_id, post_title,COUNT(meta_key) as times FROM wp_postmeta a left join wp_posts b on a.post_id=b.id
        WHERE meta_key='_sg_dictation_score' and b.post_author='{$current_user->ID}' group by post_id order by COUNT(meta_key) desc,`meta_value` desc) c left join wp_postmeta d on c.post_id=d.post_id where d.`meta_key`='_sg_word_count'"
);

$all_ids = $wpdb->get_results( 
	"
	SELECT ID,post_title,b.`meta_value` as words from {$wpdb->posts} a left join wp_postmeta b on a.id=b.post_id 
    WHERE post_author='{$current_user->ID}' and b.`meta_key`='_sg_word_count'
    "
);
$total_words=0;
$total_times=0;

echo "<table><tr>
<th>vocabulary</th>
<th>words</th>
<th>complete</th>
</tr>";
foreach ( $scores as $score ) 
{
    $total_words+=$score->words;
    $total_times+=$score->times;
    echo "<tr><td>".$score->post_title."</td><td>".$score->words."</td><td>".$score->times."</td></tr>";
}
foreach ( $all_ids as $all_id )
{
    if(!id_is_in_score($scores,$all_id->ID))
    {
        $total_words+=$all_id->words;
        echo "<tr><td>".$all_id->post_title."</td><td>".$all_id->words."</td><td class='red'>0</td></tr>";
    }
}
echo "<tr>
<td class='red'>total</td>
<td>".$total_words."</td>
<td>".$total_times."</td>
</tr>";
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
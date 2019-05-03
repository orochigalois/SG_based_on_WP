<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
        wp_get_current_user();
        echo $current_user->ID;
        ?>
    </div>
</div>
<div class="library_container">
<?php
//
// use this to gererate image for text file
// https://php.net/manual/en/function.imagettftext.php
if (is_user_logged_in()) :

	global $current_user;
	wp_get_current_user();
	$date = '';
	$author_query = array('posts_per_page' => '-1', 'author' => $current_user->ID, 'post_type' => 'attachment', 'post_status' => 'inherit', 'orderby' => 'publish_date', 'order' => 'DESC');
	$author_posts = new WP_Query($author_query);
	while ($author_posts->have_posts()) : $author_posts->the_post();


		if ($date != get_the_date('Y/m/d')) {
			if($date!='')
				echo '</div>';
			$date = get_the_date('Y/m/d');
			printDate($date);
			echo '<div class="shelf">';
		}

		echo '<div class="book_container">';
		echo '<div class="book" data-wordlist_id="'.get_the_ID().'">'.get_the_title().'</div>';
		echo '</div>';


		?>

		
	<?php
endwhile;
echo '</div>';

endif;


function printDate($date)
{
	echo '<div class="app-calendar">';
	echo '<div id="weekday">monday</div>';
	echo '<div id="day">' . $date . '</div>';
	echo '</div>';
}


?>
</div>


<?php include_once('library_modal.php'); ?>

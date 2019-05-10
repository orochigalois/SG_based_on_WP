<div class="hidden_data" style="display:none;">
    <div class="hidden_data__userID">
        <?php global $current_user;
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
	$first_in=true;
	global $current_user;
	$date = '';
	$author_query = array('posts_per_page' => '-1', 'author' => $current_user->ID, 'post_type' => 'attachment', 'post_status' => 'inherit', 'orderby' => 'publish_date', 'order' => 'DESC');
	$author_posts = new WP_Query($author_query);
	while ($author_posts->have_posts()) : $author_posts->the_post();

		$first_in=false;
		if ($date != get_the_date('Y/m/d')) {
			if($date!='')
				echo '</div>';
			$date = get_the_date('Y/m/d');
			
			global $wp_locale;
			$the_weekday = $wp_locale->get_weekday( mysql2date( 'w', get_post()->post_date, false ) );
	
			printDate($date,$the_weekday);
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


function printDate($date,$the_weekday)
{
	echo '<div class="app-calendar">';
	echo "<div id=\"weekday\">{$the_weekday}</div>";
	echo '<div id="day">' . $date . '</div>';
	echo '</div>';
}


?>

<?php if($first_in): ?>
<h1 style="color:white;">Welcome! It's empty in the library! Please go to <a href="<?php echo esc_url( get_admin_url()."admin.php?page=sg_upload_page"); ?>">Upload</a> page first.</h1>
<?php endif; ?>
</div>


<?php include_once('library_modal.php'); ?>

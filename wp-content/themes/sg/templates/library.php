<?php
//
// use this to gererate image for text file
// https://php.net/manual/en/function.imagettftext.php
if (is_user_logged_in()) :

	global $current_user;
	wp_get_current_user();
	$date = '';
	$author_query = array('posts_per_page' => '-1', 'author' => $current_user->ID, 'post_type' => 'attachment', 'post_status' => 'inherit', 'orderby' => 'publish_date','order' => 'DESC');
	$author_posts = new WP_Query($author_query);
	while ($author_posts->have_posts()) : $author_posts->the_post();


	if ( $date != get_the_date('Y/m/d') ) {
		$date = get_the_date('Y/m/d');
		printDate($date);
		echo '<br />';
		
	}
	the_title(); // or whatever you want here.
	echo '<br />';

		?>

		<!-- <a target="_blank" href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>        -->
		<!-- <a class="sg_wordlist" target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" data-wordlist_id="<?= get_the_ID(); ?>"><?php the_title(); ?></a> -->
	<?php
endwhile;

else :

	echo "not logged in";

endif;


function printDate($date){
	echo '<div class="app-calendar">';
	echo '<div id="weekday">monday</div>';
	echo '<div id="day">'.$date.'</div>';
	echo '</div>';
}


function printBook($date){
	echo '<div class="app-calendar">';
	echo '<div id="weekday">monday</div>';
	echo '<div id="day">'.$date.'</div>';
	echo '</div>';
}

?>



	

	



	<div class="shelf">
		<div class="shelf-row">
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
		</div>
		<div class="shelf-row">
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
		</div>
		<div class="shelf-row">
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
			<div class="book" sample="steve-jobs"></div>
		</div>
	</div>

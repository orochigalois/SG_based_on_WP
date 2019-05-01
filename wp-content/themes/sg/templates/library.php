<?php 
//
// use this to gererate image for text file
// https://php.net/manual/en/function.imagettftext.php
if ( is_user_logged_in() ):

    global $current_user;
    wp_get_current_user();
    $author_query = array('posts_per_page' => '-1','author' => $current_user->ID,'post_type' => 'attachment','post_status' => 'inherit');
    $author_posts = new WP_Query($author_query);
    while($author_posts->have_posts()) : $author_posts->the_post();
    ?>

        <!-- <a target="_blank" href="<?php echo wp_get_attachment_url( get_the_ID() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>        -->
        <a class="sg_wordlist" target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" data-wordlist_id="<?= get_the_ID(); ?>"><?php the_title(); ?></a>       
    <?php           
    endwhile;

else :

    echo "not logged in";

endif;

?>


	<div class="bookshelf">
		<div class="shelf">
			<div class="row-1">
				<div class="loc">
					<div> <div class="sample book1" sample="steve-jobs"></div> </div>
					<div> <div class="sample book2" sample="html5"></div> </div>
					<div> <div class="sample book3" sample="docs"></div> </div>
				</div>
			</div>
			<div class="row-2">
				<div class="loc">
					<div> <div class="sample book4" sample="magazine1"></div> </div>
					<div> <div class="sample book5" sample="magazine2"></div> </div>
					<div> <div class="sample book6" sample="magazine3"></div> </div>
				</div>
			</div>
		</div>
	</div>

<?php get_header(); ?>

<div class="container">
	<?php if(have_posts()): ?>
		<div class="posts">
			<?php while(have_posts()): the_post(); ?>
				<div class="post">
					<?php include locate_template('partials/post.php'); ?>
				</div>
			<?php endwhile; ?>
			<div class="pagination">
				<?php
					print paginate_links(array(
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $wp_query->max_num_pages,
						'prev_text' => lp_fa('fa fa-angle-left', 'Previous'),
						'next_text' => lp_fa('fa fa-angle-right', 'Next'),
						'type'      => 'list',
						'end_size'  => 3,
						'mid_size'  => 3
					));
				?>
			</div>
		</div>
	<?php else: ?>
		<div class="no-posts">
			<p>No posts were found</p>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>

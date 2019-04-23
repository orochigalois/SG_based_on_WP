<?php
the_post();
get_header(); 
?>

<div class="container">
	<h1>Sitemap</h1>
	<ul>
		<?php wp_list_pages(array('title_li'=>'')); ?>
	</ul>
</div>

<?php get_footer(); ?>
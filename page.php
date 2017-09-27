<?php
/**
 * Index Page
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */

get_header();
while ( have_posts() ){ the_post();?>
	<div class="container">
		<?php the_content(); ?>
	</div>
<?php }
get_footer();
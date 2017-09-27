<?php
/**
 * Single Portfolio Page
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */
get_header();
?>
<?php while ( have_posts() ): the_post(); ?>
  <section class="main-top-slider no-offset mobile-pagination">
    <div class="bg layer-hold" style="background-image: url(<?php the_post_thumbnail_url();?>)"></div>
    <div class="vertical-align full">
      <div class="container">
        <div class="type-2 caption">
          <div class="empty-sm-80 empty-xs-60"></div>
          <h1 class="h1 title"><?php the_title();?></h1>
          <div class="empty-sm-15 empty-xs-15"></div>
          <div class="simple-text col-3 lg">
            <?php the_excerpt(); ?>
          </div>
        </div> 
      </div>
    </div>
  </section>
  <section class="section">
    <div class="empty-sm-50 empty-xs-40"></div>
  </section> 
  <div class="container">
    <?php the_content(); ?>
  </div>
<?php endwhile; ?>
<?php get_footer();
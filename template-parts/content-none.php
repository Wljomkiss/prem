<?php
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package nrg_premium
 *
 */

?>
<div class="blog-post blog-post-inner">
  <div class="none-post" style="text-align: center;">
      <p style="font-size: 24px; line-height: 30px;"><?php print esc_html__( 'There are no results for your request','nrg_premium' ) ?></p>
      <p style="font-size: 22px; line-height: 30px;"><?php print esc_html__( 'Try to search for another request','nrg_premium' ) ?></p>
      <?php get_search_form( true ); ?>
      <a href="<?php echo esc_url( home_url( '/' ) );?>" style="margin-top: 30px;"><?php print esc_html__( 'Back Home','nrg_premium' ) ?></a>
  </div>
</div>





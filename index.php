<?php
/**
 * The main template file.
 *
 * @package nrg_premium
 * @since 1.0.0
 *
 */
get_header(); ?>
<section class="blog-wr">
  <div class="container">
    <div class="blog-post-list row">
      <div class="col-md-9">
        <div class="content-area  text-center">
          <div class="blog-post-wr">
            <?php 
              if ( have_posts() ) {
                while ( have_posts() ) {
                  the_post(); 
                    $format = get_post_format();
                    $format = ( $format === false) ? 'default' : $format;
                  get_template_part('template-parts/content', $format);
                }
              ?>
          </div>
        </div>
        <div class="nav-wrapper blog-pag">
          <?php the_posts_pagination( array(
              'mid_size'           => 1,
              'prev_text'          => '<i class="fa fa-chevron-left"></i>',
              'next_text'          => '<i class="fa fa-chevron-right"></i>',
              'screen_reader_text' => ' ',
            )); ?>
        </div>
      </div>
      <div class="col-md-3">
        <?php get_sidebar(); ?>
      </div>
      <?php } else {
        get_template_part( 'template-parts/content', 'none' ); ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <?php get_sidebar(); ?>
      </div>
        <?php } 
      ?>
    </div>
  </div>
</section>
<?php get_footer();
$custom_css = '';
$blog_color = nrgOption('blog_color');
if( isset($blog_color) && $blog_color ){
  $custom_css.= '.button-blog.link-style-1:before {border-color:'.$blog_color.';}';
  $custom_css.= '.button-blog.link-style-1:after {background:'.$blog_color.';}';
  $custom_css.= '.button-blog.link-style-1 span{color: '.$blog_color.' !important;}';
  $custom_css.= '.button-blog.link-style-1:hover span{color: #fff !important;}';
  $custom_css.= '.blog-post h4:hover {color:'.$blog_color.'!important;}';
  $custom_css.= '.page-numbers.current{color:'.$blog_color.'}';
  $custom_css.= '.page-numbers:hover{color:'.$blog_color.'}';
}
if( $custom_css ){ ?>
<style type="text/css"><?php echo esc_attr($custom_css); ?></style>
<?php } ?>

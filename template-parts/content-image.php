<?php
/**
 *
 * Post Image
 * @since 1.0
 * @version 1.0.0
 *
 */

?>
<?php $post_class_sticky = 'blog-post blog-post-inner sticky-post'?>
<div <?php if (is_sticky()) { wp_kses_post(post_class($post_class_sticky));
  } else {wp_kses_post(post_class('blog-post blog-post-inner'));}
 ?> id="post-<?php the_ID(); ?>">
    <?php if ( has_post_thumbnail() ) : ?>
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
    <?php endif; ?>
    <div class="post-line-info">
      <div class="line-item"><span class="fa fa-calendar"></span><?php the_time(get_option('date_format'));?></div>
      <div class="line-item"><span class="fa fa-user"></span><?php the_author(); ?></div>
      <div class="line-item"><span class="fa fa-comments"></span><?php comments_number('0','1','%' ); ?></div>
      <div class="line-item"><span class="fa fa-eye"></span><?php print wp_kses_post( wpb_get_post_views( get_the_ID() ) ); ?></div>
    </div>
    <?php if (is_sticky()) {echo wp_kses_post('<i class="fa fa-thumb-tack" aria-hidden="true"></i>');} ?>
    <?php
      the_title( sprintf( '<a href="%s"><h4>', esc_url( get_permalink() ) ), '</h4></a>' );
    ?>
    <?php echo the_excerpt(); ?>
 <div class="text-center but-read">
    <a href="<?php the_permalink(); ?>" class="main-link link-style-1 button-blog"><span><?php echo esc_html__('read more','nrg_premium') ?></span></a>  
  </div>
</div>
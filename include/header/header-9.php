<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';

}?>
    <header class="header-style-7">
      <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="logo flex-align">
        <?php nrg_premium_logo(); ?>
      </a>    
      <div class="nav">
        <?php 
          if( has_nav_menu( 'mag-menu_3' ) ){
            wp_nav_menu(
              array(
                'container'      => '',
                'items_wrap'     => '<ul class="table-cell">%3$s</ul>',
                'theme_location' => 'mag-menu_3',
                'depth'          => 2
              )
            );
          } else {
            print '<div class="no-menu">'.esc_html__( 'Please register Header Navigation from', 'nrg_premium' ).' <a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'" target="_blank">'.esc_html__( 'Appearance &gt; Menus', 'nrg_premium' ).'</a></div>';
          }
        ?>   
      </div>
      <div class="more-link"><span></span></div>
      <?php $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        'order'      => 'DESC',
        'orderby'    => 'date',
      );
      $query = new WP_Query( $args ); ?>
      <?php if ($query->have_posts()) { ?>
      <div class="sub-nav-menu-icon"><a href="#"><i class="dark-color"></i></a></div>
        <div class="sub-menu-right horizontal-type">
          <div class="swiper-container gutter-15" data-mode="horizontal" data-autoplay="0" data-effect="slide" data-slides-per-view="responsive" data-loop="0" data-speed="800" data-add-slides="4" data-lg-slides="4" data-md-slides="3" data-sm-slides="2" data-xs-slides="1">
            <div class="swiper-wrapper">
              <?php while ( $query->have_posts() ) {
              $query->the_post(); ?>
                <div class="swiper-slide">
                  <div class="mag-item-1 type-img min-sm-height">
                    <div class="bg layer-hold type-4" style="background-image: url(<?php the_post_thumbnail_url();?>)"></div> 
                    <div class="text">
                        <div class="sub-title sm col-1"><i><?php the_time(get_option('date_format')); ?></i></div>
                        <div class="empty-sm-10 empty-xs-10"></div>
                        <div class="caption type-2">
                          <h3 class="h5 sm title no-tr">
                            <a href="<?php the_permalink();?>" class="text-line-animate sm"><?php the_title();?></a>
                          </h3>
                        </div>
                        <div class="info-bar type-2 bottom-align">
                          <?php
                            nrg_premium_get_simple_likes_button(get_the_ID());
                            $comments_count = wp_count_comments(get_the_ID());
                            echo wp_kses_post( '<div><i class="fa fa-comment-o"></i><span>'.$comments_count->total_comments.'</span></div>' );
                          ?>
                        </div>
                    </div>
                  </div>
                </div>
              <?php }
                wp_reset_postdata();
              ?>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div> 
      <?php } ?>
      <div class="submenu-layer type-2"></div>    
    </header> 
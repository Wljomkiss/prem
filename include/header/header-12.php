<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
} ?>

  <header class="header-style-5 ph header <?php echo esc_html($bg_trans);?>" id="home">
    <div class="nav-menu-icon rel scrol-nav-menu-icon"><a href="#"><i></i></a></div>    
    <div class="center-menu-block center-align">
      <div class="nav-menu-icon rel"><a href="#"><i></i></a></div>
      <div class="custome-padd-100">
        <div class="empty-sm-30 empty-xs-30"></div>
        <div class="caption text-center">
          <h1 class="h2 title"><?php the_title(); ?></h1> 
          <div class="empty-sm-15 empty-xs-15"></div>
        </div>
      </div> 
    </div>
    <?php
    if( isset($post_meta['cats']) && $post_meta['cats'] ){
      $folio_args = array(
        'post_type'      => 'portfolio',
        'posts_per_page'  => 10,
        'order'           => 'DESC',
        'tax_query'       => array(
          array(
            'taxonomy' => 'portfolio_categories',
            'field'    => 'id',
            'terms'    => $post_meta['cats']
        ))
      );
      $folio_post = new WP_Query( $folio_args );
      if ( $folio_post->have_posts() ) { ?>
        <div class="row">
          <?php $i = 1;
          while ( $folio_post->have_posts() ) { $folio_post->the_post(); ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?php the_permalink();?> " class="photo-header-item">
                <img src="<?php echo aq_resize( get_the_post_thumbnail_url(), 362, 246, true, true, true ); ?>" alt="">
                <div class="vertical-align full">
                  <div class="caption type-2 text-center">
                    <h6 class="h6 title"><?php the_title(); ?></h6>
                    <div class="empty-sm-10 empty-xs-10"></div>
                    <div class="sub-title ls col-10"><?php the_excerpt(); ?></div>
                  </div>
                </div>   
              </a>
              <div class="empty-sm-30 empty-xs-30"></div>
            </div>
            <?php if ($i==5) { ?>
              <div class="col-md-6 col-sm-6 col-xs-12">
              </div>
            <?php } ?>
          <?php $i++ ;
          }
          wp_reset_postdata(); ?>
        </div>
      <?php } 
    } ?>
    <div class="navigation">
      <div class="close-menu close-header-12"><img src="<?php echo NRG_PREMIUM_URI; ?>/assets/img/close-12.png" alt=""></div>
      <nav>
        <?php 
          if( has_nav_menu( 'photography-menu' ) ){
            $nav_menu = array(
              'container'      => '',
              'items_wrap'     => '<ul class="table-cell">%3$s</ul>',
              'theme_location' => 'photography-menu',
              'depth'          => 2,
              'walker'         => new nrg_premium_Walker_Nav_Menu()
            );
            wp_nav_menu($nav_menu);
          } else {
            print '<div class="no-menu">'.esc_html__( 'Please register Header Navigation from', 'nrg_premium' ).' <a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'" target="_blank">'.esc_html__( 'Appearance &gt; Menus', 'nrg_premium' ).'</a></div>';
          }
        ?>
      </nav>
    </div>
  </header>
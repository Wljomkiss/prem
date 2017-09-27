<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
}?>

    <header class="header-style-4 header type-2 <?php echo esc_html($bg_trans);?>">
     <div class="navigation">
      <div class="container">
         <div class="top-menu">
         <div class="nav-menu-icon"><a href="#" class="vertical-align"><i class="dark-color"></i></a></div> 
          <div class="logo">
              <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="table-cell">
                <?php nrg_premium_logo(); ?>
              </a>
          </div>   
          <nav>
            <?php 
                if( has_nav_menu( 'primary-menu' ) ){
                  wp_nav_menu(
                    array(
                      'container'      => '',
                      'items_wrap'     => '<ul class="table-cell">%3$s</ul>',
                      'theme_location' => 'primary-menu',
                      'depth'          => 2
                    )
                  );
                } else {
                  print '<div class="no-menu">'.esc_html__( 'Please register Header Navigation from', 'nrg_premium' ).' <a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'" target="_blank">'.esc_html__( 'Appearance &gt; Menus', 'nrg_premium' ).'</a></div>';
                }
              ?>       
          </nav>
          <a href="#" class="serch-button vertical-align"><span class="fa fa-search"></span></a>
         <div class="sub-nav-menu-icon"><a href="#"><i class="dark-color"></i></a></div>
      </div>
        <div class="bottom-menu">
          <?php $args = array(
            'taxonomy' => 'category',
            'hide_empty' => true,
          );
          $terms = get_terms( $args ); 
          if ($terms) { ?>
            <ul>
              <?php foreach ($terms as $key => $term) { ?>
                   <li><a href="<?php echo esc_url( home_url( '/' )).'category/'.esc_html($term->slug); ?>"><?php echo esc_html($term->name);?></a></li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
        </div>          
      </div>
      <div class="sub-menu-right">
        <div class="close-sub-menu"><img src="<?php echo NRG_PREMIUM_URI; ?>/assets/img/close.png" alt=""></div> 
        <?php if ( is_active_sidebar( 'mag_2_sidebar' ) ) : ?>
          <?php dynamic_sidebar( 'mag_2_sidebar' ); ?>
        <?php endif; ?>
      </div>
      <div class="submenu-layer"></div>    
    </header>
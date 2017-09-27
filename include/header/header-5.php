<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
$scroll_bg ='';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
}

if( isset($post_meta['header_scroll_bg']) && $post_meta['header_scroll_bg'] && $post_meta['header_scroll_bg'] == 'enable') {
  $scroll_bg = 'color-dark-3';
} ?>

    <header class="header-style-3 type-5 header <?php echo esc_html($bg_trans);?> <?php echo esc_html($scroll_bg); ?>">
        <div class="navigation">
           <div class="logo">
            <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="table-cell">
              <?php nrg_premium_logo_2(); ?>
            </a>
          </div>
          <div class="nav-menu-icon"><a href="#" class="vertical-align"><i class="white-color"></i></a></div>   
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
                <div class="header-folow fin">
                    <?php nrg_premium_get_social(); ?>
                </div>
            </nav>
        </div>
    </header>
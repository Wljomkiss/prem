<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
}?>

    <header class="header-style-3 type-3 header color-white header-sub-menu header-shadow <?php echo esc_html($bg_trans); ?>">
        <div class="navigation">
           <div class="logo">
             <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="table-cell">
                <?php nrg_premium_logo(); ?>
             </a>
          </div>
          <div class="nav-menu-icon"><a href="#" class="vertical-align"><i class="dark-color"></i></a></div>    
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
                <div class="header-folow">
                  <a href="#" class="serch-button"><span class="fa fa-search"></span></a>
                </div>
            </nav>
            <div class="sub-nav-menu-icon"><a href="#"><i></i></a></div>
        </div>
        <div class="sub-menu-right">
           <div class="empty-sm-35 empty-xs-30"></div>
            <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="sub-menu-logo">
              <?php nrg_premium_logo(); ?>
            </a>
            <?php if( has_nav_menu( 'footer-menu' ) ){
              wp_nav_menu(
                array(
                  'container'      => '',
                  'items_wrap'     => '<ul class="sub-nuvigation">%3$s</ul>',
                  'theme_location' => 'footer-menu',
                  'depth'          => 2
                  )
                );
              } else {
                print '<div class="no-menu">'.esc_html__( 'Please register Header Navigation from', 'nrg_premium' ).' <a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'" target="_blank">'.esc_html__( 'Appearance &gt; Menus', 'nrg_premium' ).'</a></div>';
              }
            ?>
            <div class="empty-md-60 empty-sm-40 empty-xs-40"></div>
            <?php nrg_premium_address_helper(); ?>
            <?php //$header_social = nrgOption('header_search');
            //if ($header_social == true) { ?>
              <div class="empty-sm-30 empty-xs-30"></div>
              <div class="follow-link text-center">
                <?php nrg_premium_get_social(); ?>
              </div>
            <?php // } ?> 
            <div class="empty-sm-35 empty-xs-30"></div>
        </div>
        <div class="submenu-layer"></div>
    </header>
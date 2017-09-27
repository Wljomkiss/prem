<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';

}?>
  

  <header class="header-style-6 color-type-10 <?php echo esc_html($bg_trans);?>">
    <div class="empty-sm-60 empty-xs-30"></div>
    <div class="logo">
      <a href="<?php print esc_url( home_url( '/' ) ); ?>">
        <?php nrg_premium_logo_2(); ?>
      </a>
    </div>
    <div class="nav-menu-icon"><a href="#"><i i class="white-color"></i></a></div>    
    <div class="navigation">
      <nav>
        <?php 
          if( has_nav_menu( 'onepage-menu_3' ) ){
          wp_nav_menu(
            array(
              'container'      => '',
              'items_wrap'     => '<ul class="table-cell">%3$s</ul>',
              'theme_location' => 'onepage-menu_3',
              'depth'          => 2,
              'walker'         => new nrg_premium_Walker_Nav_Menu()
            )
          );
          } else {
            print '<div class="no-menu">'.esc_html__( 'Please register Header Navigation from', 'nrg_premium' ).' <a href="'.esc_url( admin_url( 'nav-menus.php' ) ).'" target="_blank">'.esc_html__( 'Appearance &gt; Menus', 'nrg_premium' ).'</a></div>';
          }
        ?>     
      </nav>
      <?php $phone_info = nrgOption('phone_info');
        $output_phone = preg_replace( '/[^0-9]/', "", $phone_info );
        if ($phone_info) { ?>
          <a href="tel:+3<?php echo esc_html($output_phone); ?>" class="link"><?php echo esc_html($phone_info); ?></a>
      <?php } ?>
      <div class="empty-sm-40 empty-xs-30"></div>
      <?php // $header_social = nrgOption('header_search');
       // if ($header_social == true) { ?>
          <div class="header-folow align-center folow-style-3">
            <?php nrg_premium_get_social(); ?>
          </div>
        <?php  //} ?> 
      <div class="empty-sm-40 empty-xs-30"></div>
    </div>
  </header>
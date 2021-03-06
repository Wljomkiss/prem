<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
}?>
<header class="header-style-3 type-4 header <?php echo esc_html($bg_trans); ?>">
  <div class="top-menu">
    <div class="link-wrap"> 
      <div class="header-link-contact">
        <?php 
        $email_info = nrgOption('email_info');
        $phone_info = nrgOption('phone_info');
        $output_phone = preg_replace( '/[^0-9]/', "", $phone_info );
        ?>
        <a href="tel:+<?php print esc_html($output_phone); ?>"><?php print esc_html__('Reseption:', 'nrg_premium'); print esc_html($phone_info); ?></a>
      </div>
      <div class="header-link-contact">
        <a href="mailto:<?php print esc_html($email_info);?>"><?php print esc_html__('Email:', 'nrg_premium'); print esc_html($email_info);?></a>
      </div>
    </div>
        <div class="header-folow">
          <a href="#" class="serch-button"><span class="fa fa-search"></span></a>
          <?php nrg_premium_get_social(); ?>
        </div>   
  </div> 
  <div class="navigation">
    <div class="logo">
      <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="table-cell">
        <?php nrg_premium_logo_2(); ?>
      </a>
    </div>
    <div class="nav-menu-icon"><a href="#" class="vertical-align"><i class="bg-main"></i></a></div>   
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
        <?php if( class_exists('WooCommerce') ){ 
          global $woocommerce; 
          $cart_url = $woocommerce->cart->get_cart_url();
          $cart_count = $woocommerce->cart->cart_contents_count;
          $cart_total = $woocommerce->cart->get_cart_total(); ?> 
          <ul>
            <li class="shop-card-item">
              <div class="link-like">
                <a href="<?php echo esc_url(home_url('/')); ?>wishlist" class="table-cell"><b class="fa fa-heart-o"></b></a>
              </div>
              <?php if ($cart_count >= '1') { ?>
                <div class="link-shop"><a href="<?php echo $cart_url ?>" class="table-cell"><b class="fa fa-shopping-basket"></b><span class="txt">
                    <?php print $cart_count; 
                    if ($cart_count == '1'){print esc_html__(' item ', 'nrg_premium');} else { print esc_html__(' items ','nrg_premium');}; 
                    print $cart_total ?></span></a>
                  <?php woocommerce_mini_cart();?>
                </div>
              <?php } ?>
            </li>
          </ul>
        <?php } ?> 
    </nav>
  </div>
</header>
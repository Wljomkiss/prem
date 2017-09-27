<?php 
$post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
$bg_trans = '';
if( isset($post_meta['header_transparent']) && $post_meta['header_transparent'] && $post_meta['header_transparent'] == 'yes') {
  $bg_trans = 'no-bg';
}?>

<header class="header-style-1 header <?php echo esc_html($bg_trans); ?>">
    <div class="container-fluid">
        <div class="logo">
            <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="table-cell">
	            <?php nrg_premium_logo(); ?>
            </a>
        </div>
        <div class="nav-menu-icon"><a href="#" class="table-cell"><i></i></a></div>   
        <div class="navigation">
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
			<?php $header_social = nrgOption('header_social');
			$header_search = nrgOption('header_search'); ?>
				<div class="header-folow folow-style-1">
					<a href="#" class="serch-button"><span class="fa fa-search"></span></a>
					<?php nrg_premium_get_social();?>
				</div>
      </div>
    </div>
</header>
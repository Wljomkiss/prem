<footer class="footer-style-1 footer-4">
  <div class="empty-lg-60 empty-md-60 empty-sm-50 empty-xs-40"></div> 
  <div class="container-fluid">
    <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
      <?php nrg_premium_logo();?> 
    </a>
    <div class="empty-sm-50 empty-xs-40"></div>
    <?php wp_nav_menu(
            array(
              'container'      => '',
              'items_wrap'     => '<ul class="footer-link-menu type-2">%3$s</ul>',
              'theme_location' => 'footer-menu',
              'depth'          => 1
            )
          );
      ?> 
    <div class="empty-sm-50 empty-xs-40"></div>
    <div class="footer-folow-2 second-font">
      <?php nrg_premium_footer_social(); ?>
    </div>
    <div class="empty-sm-40 empty-xs-30"></div>
    <?php nrg_premium_copyright(); ?>
  </div>
  <div class="empty-lg-90 empty-md-80 empty-sm-60 empty-xs-60"></div> 
</footer>  

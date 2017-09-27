<?php
// $post_meta = get_post_meta( get_the_ID(), '_custom_page_options', true ); 
// if( isset($post_meta['instagram_userid']) && $post_meta['instagram_userid'] && $post_meta['instagram_userid'] == 'yes') {
//   $instagram_userid = $post_meta['instagram_userid'];
// }
// if( isset($post_meta['img_limit']) && $post_meta['img_limit'] && $post_meta['img_limit'] == 'yes') {
//   $img_limit = $post_meta['img_limit'];
// }
// if( isset($post_meta['instagram_access_token']) && $post_meta['instagram_access_token'] && $post_meta['instagram_access_token'] == 'yes') {
//   $instagram_access_token = $post_meta['instagram_access_token'];
// }
// $inst_id    = uniqid();
?>

<footer class="footer-style-2">
  <div class="empty-lg-80 empty-md-80 empty-sm-60 empty-xs-60"></div> 
  <div class="container">
    <div class="row">
      <a href="<?php print esc_url( home_url( '/' ) ); ?>" class="f-logo">
        <?php nrg_premium_logo_2();?>
      </a>
      <div class="col-md-6 col-md-offset-3">
        <div class="empty-sm-40 empty-xs-30"></div>
        <div class="subcribe-form">
          <label class="subscribe-label"><?php print esc_html__( 'Subscribe |', 'nrg_premium' ) ?></label>
          <?php echo do_shortcode('[yikes-mailchimp form="1"]');?>
        </div>
      </div>
      <div class="empty-sm-30 empty-xs-15"></div>
      <?php wp_nav_menu(
              array(
                'container'      => '',
                'items_wrap'     => '<ul class="footer-nav">%3$s</ul>',
                'theme_location' => 'footer-menu',
                'depth'          => 1
              )
            );
        ?> 
      <div class="empty-sm-20"></div>
      <?php nrg_premium_copyright(); ?>
    </div>
  </div> 
  <div class="empty-lg-80 empty-md-80 empty-sm-40 empty-xs-40"></div>
    <div class="follow-wide-link">
      <?php nrg_premium_footer_social(); ?>
    </div>
      <!-- <div class="footer-instagram some-wrap" id="<?php echo $inst_id;?>"> -->
      <!-- </div> -->
<!--       <script type="text/javascript">
        jQuery(document).ready(function($) {
          //Instagram
          try{Typekit.load();}catch(e){}
          var feed = new Instafeed({
            get: 'user',
            userId: '<?php echo $instagram_userid; ?>',
            'limit': '<?php echo $img_limit; ?>',
            accessToken: '<?php echo $instagram_access_token; ?>',
            template: '<a href="{{link}}"><img src="{{image}}" alt=""></a>',
            target: '<?php echo $inst_id;?>',
            resolution: 'standard_resolution',
            after: function() {}
          });
          feed.run();
        });
      </script> -->
</footer>
<?php 
    if( is_woocommerce() || is_cart() || is_checkout() )
      $id = ( wc_get_page_id('shop') ? wc_get_page_id('shop') : get_the_ID() );
    else 
      $id = get_the_ID();

    $post_meta     = get_post_meta( $id, '_custom_page_options', true );
    $footer_layout = nrgOption('footer_layout');
      
    if( isset($post_meta['footer_layout']) && $post_meta['footer_layout'] && $post_meta['footer_layout'] != 'default' )
      get_template_part( 'include/footer/footer', $post_meta['footer_layout'] );
    elseif( $footer_layout )
      get_template_part( 'include/footer/footer', $footer_layout );
    else
      get_template_part( 'include/footer/footer', '1' ); 
    ?>
    </div>   

    <!-- SEARCH POPUP-->
    <div class="search-popup">
      <div class="vertical-align">
        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
              <div class="search-form-wr">
                <?php get_search_form(true); ?>
                <a href="#" class="close"><span>+</span></a>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div>
    <?php wp_footer(); ?>
  </body>
</html> 
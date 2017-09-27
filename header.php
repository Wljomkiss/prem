<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <?php nrg_premium_favicon(); ?>
    <?php wp_head(); ?>
  </head>
<body <?php body_class(); ?>>
  <div class="preloader">
    <div class="img">
      <?php nrg_premium_logo(); ?>
    </div>       
  </div>
  <div class="border-1"></div>
  <div class="border-2"></div>
  <?php
    $post_meta     = get_post_meta( get_the_ID(), '_custom_page_options', true );
    $header_layout = nrgOption('header_layout');
  ?>

  <div class="main-content <?php if( isset($post_meta['header_layout']) && $post_meta['header_layout'] && $post_meta['header_layout'] == '11') { echo esc_html('offset-left-250'); } ?>   ">
    <!-- header layout -->
    <?php 
    if( is_woocommerce() || is_cart() || is_checkout() ){
      if( is_cart() || is_checkout()){
        echo '<div class="empty-md-180"></div>';
      }
      get_template_part( 'include/header/header', '4' );
    } else {
      if( isset($post_meta['header_layout']) && $post_meta['header_layout'] && $post_meta['header_layout'] != 'default' )
          get_template_part( 'include/header/header', $post_meta['header_layout'] );
      elseif( $header_layout )
        get_template_part( 'include/header/header', $header_layout );
      else
        get_template_part( 'include/header/header', '1' );
    }
<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section>
		<div class="empty-lg-140 empty-md-100 empty-sm-60 empty-xs-60"></div>
		<div class="container">
			<div class="caption text-center">
                <h2 class="h2 title"><?php _e( 'Related Products', 'nrg_premium' ); ?></h2>
                <div class="empty-sm-15 empty-xs-15"></div>
                <div class="simple-text md col-1">
                    <p><i><?php _e( 'Mauris eleifend nisi justo, in volutpat magna scelerisque eget', 'nrg_premium' ); ?></i></p>
                </div>
                <div class="empty-md-80 empty-sm-40 empty-xs-40"></div>
            </div>  
			<div class="related products">
				<?php woocommerce_product_loop_start(); ?>
					<div class="row">
						<div class="swiper-container gutter-15" data-mode="horizontal" data-autoplay="0" data-effect="slide" data-slides-per-view="responsive" data-loop="0" data-speed="800" data-add-slides="4" data-lg-slides="4" data-md-slides="3" data-sm-slides="2" data-xs-slides="1">
							<div class="swiper-wrapper">
								<?php foreach ( $related_products as $related_product ) : ?>
									<div class="swiper-slide">	
										<?php
									 	$post_object = get_post( $related_product->get_id() );
										setup_postdata( $GLOBALS['post'] =& $post_object );
										wc_get_template_part( 'content', 'product' ); ?>
									</div>
								<?php endforeach; ?>

							</div>
						<div class="pagination pagination-hide"></div>
					</div> 
				</div>
				<?php woocommerce_product_loop_end(); ?>
			</div>
			<div class="empty-md-70 empty-sm-40 empty-xs-40"></div>
		</div>
	</section>

<?php endif;

wp_reset_postdata();





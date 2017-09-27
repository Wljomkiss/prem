<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header(); 
// if ( is_post_type_archive( 'product' ) && 0 === absint( get_query_var( 'paged' ) ) ) {
	$shop_page   = get_post( wc_get_page_id( 'shop' ) );
	if ( $shop_page ) {
		print wc_format_content( $shop_page->post_content );
	}
// }
		?>
<section class="section">
   <div class="empty-sm-60 empty-xs-60"></div> 
		<div class="container">
		    <div class="row">
		        <div class="col-md-9 col-md-push-3 col-sm-12">
	            	<?php if ( have_posts() ) : ?>
			            <div class="product-bar">
			                <div class="row">
								<?php
									/**
									 * woocommerce_before_shop_loop hook.
									 *
									 * @hooked woocommerce_result_count - 20
									 * @hooked woocommerce_catalog_ordering - 30
									 */
									do_action( 'woocommerce_before_shop_loop' );
								?>
			                </div>     
			            </div> 
		            	<div class="empty-sm-30 empty-xs-30"></div>
		            	<div class="row">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<?php wc_get_template_part( 'content', 'product' ); ?>
								</div>
							<?php endwhile; // end of the loop. ?>
								<div class="empty-sm-30 empty-xs-30"></div>
								<div class="shop-pag-wr"><?php
									/**
									 * woocommerce_after_shop_loop hook.
									 *
									 * @hooked woocommerce_pagination - 10
									 */
									do_action( 'woocommerce_after_shop_loop' );
								?></div>
							<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
							<?php wc_get_template( 'loop/no-products-found.php' ); ?>
							<?php endif; ?>
					</div>
		            <div class="empty-lg-0 empty-md-0 empty-sm-60 empty-xs-60"></div> 
		        </div>
				<div class="col-md-3 col-md-pull-9 col-sm-12">
					<?php if(is_active_sidebar( 'shop_sidebar')):
						dynamic_sidebar( 'shop_sidebar' );
					endif; ?>
				</div>
		    </div>
		</div>
    <div class="empty-lg-140 empty-md-100 empty-sm-80 empty-xs-60"></div>
</section>
<?php get_footer(); ?>

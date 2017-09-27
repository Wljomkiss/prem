<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>
	<section class="section">
       	<div class="empty-sm-100 empty-xs-60"></div>
       	<div class="empty-sm-100 empty-xs-80"></div> 
        <div class="container">
            <div class="row">
				<?php if ( is_active_sidebar( 'shop_sidebar' ) ) { ?>
					<div class="col-md-9 col-md-push-3 col-sm-12">
				<?php } else { ?>
					<div class="col-md-12 col-sm-12">
				<?php } ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'single-product' ); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
				<!-- Custom sidebar -->
				<?php if ( is_active_sidebar( 'shop_sidebar' ) ) : ?>
					<div class="col-md-3 col-md-pull-9 col-sm-12">
						<?php dynamic_sidebar( 'shop_sidebar' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php woocommerce_output_related_products(); ?>
	<?php endwhile; // end of the loop. ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		//do_action( 'woocommerce_after_main_content' );
	?>
<?php get_footer(); ?>
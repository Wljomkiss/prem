<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $post;
?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
$swich_parent = '';
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-lg-7 col-md-6">
			<div class="slider-swiching">
				<div class="swiper-container product-slider container-swich" data-mode="horizontal" data-autoplay="0" data-effect="slide" data-slides-per-view="1" data-loop="0" data-speed="800">
					<div class="swiper-wrapper">
						<div class="swiper-slide images">
							<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">   
						</div>
						<?php 
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								foreach ( $attachment_ids as $attachment_id ) {
									$image_link  = wp_get_attachment_image_url($attachment_id, '', true); 
									?>
									<div class="swiper-slide">
										<img src="<?php echo esc_url( $image_link ); ?>" alt="<?php the_title(); ?>">
									</div>
							<?php 
									$swich_parent.= '<div class="swiper-slide">';
									$swich_parent.= '<div class="slide-swich">';
									$swich_parent.= '<img src="'.esc_url( $image_link ).'" alt="'.get_the_title().'">';
									$swich_parent.= '</div>';
									$swich_parent.= '</div>';
								}
							}
						?>
					</div>
					<div class="pagination pagination-hide"></div>
				</div>
				<div class="swiper-container swich-parent product-preview" data-mode="horizontal" data-autoplay="0" data-effect="slide" data-slides-per-view="responsive" data-loop="0" data-speed="800" data-add-slides="4" data-lg-slides="4" data-md-slides="4" data-sm-slides="3" data-xs-slides="3">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="slide-swich">
								<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"> 
							</div>
						</div>
						<?php print $swich_parent; ?>	
					</div>
					<div class="pagination pagination-hide"></div>
				</div>
			</div> 
		</div>
		<div class="col-lg-5 col-md-6">
			<div class="main-desc">
				<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>
		<div class="col-md-12">
			<?php
				/**
				 * woocommerce_after_single_product_summary hook.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>

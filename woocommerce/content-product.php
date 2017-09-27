<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$terms = get_the_terms( $product->get_id(), 'product_cat' );
$categories = '';
if( $terms )
	foreach( $terms as $term )
		$categories.= $term->slug.' ';
?>

<div class="product-item <?php echo esc_html($categories); ?> <?php if ( $product->is_on_sale()){print esc_html_e('hot', 'nrg_premium');} ?>">
	<div class="image">
		<?php if ( $product->is_on_sale() ) : ?>
			<div class="category"><?php print esc_html_e('Hot', 'nrg_premium'); ?></div>
		<?php endif; ?>
		<div class="prod-view"><a href="#"><?php print esc_html_e('quick view', 'nrg_premium'); ?></a></div>
		<img src="<?php the_post_thumbnail_url(); ?>" alt="" class="resp-img">
		<div class="product-button">
			<a href="<?php the_permalink(); ?>" class="prod-more"><?php print esc_html_e( 'viev more', 'nrg_premium' ) ?></a>    
			<div href="#" class="prod-icon-link add-to-wish">
				<i class="fa fa-heart-o"></i>
				<i class="fa fa-heart"></i>
				<?php print do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
			</div>    
			<a href="#" class="prod-icon-link add-to-cart" data-quantity="1" data-postid="<?php print wp_kses_post( $product->get_id() ); ?>">
				<i class="fa fa-shopping-basket"></i>
				<i class="fa fa-spinner"></i>
				<i class="fa fa-check-circle-o"></i>
			</a>    
		</div>
	</div> 
	<div class="text">
		<div class="empty-sm-20 empty-xs-20"></div>    
		<h6 class="h6 title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
		<i class="prod-subtitle"><?php echo get_the_excerpt(); ?></i>
		<span class="prod-price"><?php print $product->get_price_html();?></span>
	</div>   
</div>





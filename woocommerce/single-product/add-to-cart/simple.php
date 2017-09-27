<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	<form class="cart" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<div class="empty-sm-35 empty-xs-30"></div>
	 	<div class="setting-item">
			<h6 class="h7 title"><?php print esc_html_e('quantity:', 'nrg_premium'); ?></h6>
			<div class="empty-sm-15 empty-xs-15"></div>
			<?php
				if ( ! $product->is_sold_individually() ) {
					woocommerce_quantity_input( array(
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
						'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
					) );
				}
			?>
		</div>
		<!-- buttons -->
		<div class="empty-sm-40 empty-xs-40"></div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
	 			<button type="submit" class="single_add_to_cart_button button alt link-style-3 type-full"><?php print esc_html_e('add to bag', 'nrg_premium'); ?></button>
				<div class="empty-lg-0 empty-md-0 empty-sm-0 empty-xs-10"></div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php print do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>

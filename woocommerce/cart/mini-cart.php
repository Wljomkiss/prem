<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
global $product,$woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="card-popup">
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$attributes = $_product->get_attributes();

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					$cart_url = $woocommerce->cart->get_cart_url();
					$checkout_url = $woocommerce->cart->get_checkout_url(); 
					$cart_total = $woocommerce->cart->get_cart_total();
					?>
					<div class="card-item">
						<div class="close-block close-card"><span>+</span></div>
						<div class="image">
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
						</div>
						<div class="text">
							<h6 class="h8 title"><a href="<?php echo esc_url( $product_permalink ); ?>"><?php print $product_name; ?></a></h6>
							<span><?php print esc_html__('Quantity: ', 'nrg_premium'); print $cart_item['quantity']; ?></span>
							<b><?php print $woocommerce->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></b>
						</div> 
						<div class="empty-sm-30 empty-xs-30"></div>
					</div>
   					<?php
				}
			}
		?>	
			<div class="total">
				<h6 class="h8"><?php print esc_html__('subtotal:', 'nrg_premium') ?></h6>
				<b><?php print esc_attr($cart_total); ?></b>
			</div>
			<div class="empty-sm-30 empty-xs-30"></div>
			<div class="buttons">
				<div class="col-half"> 
					<a href="<?php echo esc_url($cart_url); ?>" class="view"><?php print esc_html__('view cart', 'nrg_premium') ?></a>
				</div>
				<div class="col-half">   
					<a href="<?php echo esc_url($checkout_url); ?>" class="chekout"><?php print esc_html__('checkout', 'nrg_premium') ?></a>
				</div>
			</div>
	<?php else : ?>
		<div class="card-popup"><?php esc_html__( 'No products in the cart', 'nrg_premium' ); ?></div>
	<?php endif; ?>

</div><!-- end product list -->

<?php do_action( 'woocommerce_after_mini_cart' ); ?>



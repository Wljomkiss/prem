<?php
/**
 * Empty cart page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>
<p class="cart-empty">
	<?php _e( 'Your cart is currently empty.', 'nrg_premium' ) ?>
</p>
<?php do_action( 'woocommerce_cart_is_empty' ); ?>
<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php _e( 'Return To Shop', 'nrg_premium' ) ?>
		</a>
	</p>
<?php endif; ?>

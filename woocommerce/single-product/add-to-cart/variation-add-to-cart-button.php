<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<div class="empty-sm-35 empty-xs-30"></div>
	<!-- quantity -->
	<div class="setting-item">
		<h6 class="h7 title"><?php print esc_html_e('quantity:', 'nrg_premium'); ?></h6>
		<div class="empty-sm-15 empty-xs-15"></div>
			<?php if ( ! $product->is_sold_individually() ) : ?>
				<?php 
					woocommerce_quantity_input( array(
						'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
					) );
				?>
			<?php endif; ?>
	</div>
	<!-- buttons -->
	<div class="empty-sm-40 empty-xs-40"></div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<button type="submit" class="single_add_to_cart_button button alt link-style-3 type-full"><?php echo esc_html_e( 'add to bag', 'nrg_premium'); ?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="0" />
			<div class="empty-lg-0 empty-md-0 empty-sm-0 empty-xs-10"></div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php print do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
		</div>
	</div>
</div>

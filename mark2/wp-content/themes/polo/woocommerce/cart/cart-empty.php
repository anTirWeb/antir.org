<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

/**
 * @hooked wc_empty_cart_message - 10
 *
 */
?>
<div class="p-t-10 m-b-20 text-center">

    <div class="heading-fancy heading-line text-center">
        <h4><?php esc_html_e('Your cart is currently empty.','polo');?></h4>
    </div><!--heading-fancy heading-line text-center-->

	<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop">
            <a class="button color button-3d rounded icon-left empty-card-button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                <span><?php esc_html_e( 'Return To Shop', 'polo' ) ?></span>
            </a>
        </p>
	<?php endif; ?>
</div><!--p-t-10 m-b-20 text-center-->


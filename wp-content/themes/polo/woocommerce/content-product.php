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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 2 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
?>

<div <?php post_class(); ?>>
	<div class="product-image">
	<?php
	/**
	 * polo_woo_shop_product_images hook.
	 *
	 * @hooked polo_shop_product_images - 5
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked polo_wishlist_add - 15
	 * @hooked polo_shop_product_overview - 20
	 */
	do_action('polo_woo_shop_product_images');
	?>
	</div>

	<div class="product-description">
	<?php
	/**
	 * polo_woo_product_summary hook.
	 *
	 * @hooked polo_woo_product_category - 5
	 * @hooked polo_woo_product_title - 10
	 * @hooked polo_woo_product_price - 15
	 * @hooked polo_woo_product_rating - 20
	 */
	do_action( 'polo_woo_shop_product_summary' );
	?>
	</div>
</div>
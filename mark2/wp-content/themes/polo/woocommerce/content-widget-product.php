<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$price = str_replace( '<span class="amount">', '<span class="amount"><ins>', $product->get_price_html() );
$price = str_replace( '</span>', '</ins></span>', $price );

$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
if ( isset( $thumb[0] ) && ! empty( $thumb[0] ) ) {
	$thumb = $thumb[0];
} else {
	$thumb = POLO_ROOT_URL . '/library/img/no-image.png';
} ?>
<div class="product">
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

    <div class="product-image">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><img src="<?php echo esc_url( polo_theme_thumb( $thumb, '380', '507') ); ?>" alt="">
		</a>
	</div>

	<div class="product-description">
		<div class="product-category"><?php echo ($product->get_categories( ', ' )); ?></div>
		<div class="product-title">
			<h3>
				<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>"><?php esc_attr( the_title() ); ?></a>
			</h3>
		</div>
		<div class="product-price"><?php echo ($price); ?>
		</div>
		<div class="product-rate">
			<?php woocommerce_template_loop_rating(); ?>
		</div>
	</div>
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</div>

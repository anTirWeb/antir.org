<?php
global $product;
$price = str_replace( '<span class="amount">', '<span class="amount"><ins>', $product->get_price_html() );
$price = str_replace( '</span>', '</ins></span>', $price );

$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
if ( isset( $thumb[0] ) && ! empty( $thumb[0] ) ) {
	$thumb = $thumb[0];
} else {
	$thumb = POLO_ROOT_URL . '/library/img/no-image.png';
}

?>
<div class="product">
	<div class="product-image">
		<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>"><img src="<?php echo esc_url( polo_theme_thumb( $thumb, '380', '507', true ) ); ?>" alt="">
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

</div>

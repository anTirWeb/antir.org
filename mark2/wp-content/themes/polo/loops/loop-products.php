<?php

global $product_query;

//Query args
if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
} else {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}

$items_number      = reactor_option( 'woo_shop_items' );
$meta_items_number = reactor_option( 'woo_shop_items', '', 'meta_products_page_options' );
if ( isset( $meta_items_number ) && ! empty( $meta_items_number ) ) {
	$items_number = $meta_items_number;
}

$args = array(
	'post_type'      => 'product',
	'paged'          => $paged,
	'posts_per_page' => $items_number
);

$product_query = new WP_Query( $args );

$shop_columns      = reactor_option( 'shop_columns_number', '2' );
$meta_shop_columns = reactor_option( 'shop_columns_number', '', 'meta_products_page_options' );
if ( isset( $meta_shop_columns ) && ! empty( $meta_shop_columns ) && ! ( 'default' === $meta_shop_columns ) ) {
	$shop_columns = $meta_shop_columns;
}

$meta_shop_columns = reactor_option( 'shop_columns_number', '', 'meta_products_page_options' );
if ( isset( $meta_shop_columns ) && ! empty( $meta_shop_columns ) && ! ( 'default' === $meta_shop_columns ) ) {
	$shop_columns = $meta_shop_columns;
}

$shop_title      = polo_do_multilang_text(reactor_option( 'woo_shop_title' ));
$meta_shop_title = polo_do_multilang_text(reactor_option( 'woo_shop_title', '', 'meta_products_page_options' ));
if ( isset( $meta_shop_title ) && ! empty( $meta_shop_title ) ) {
	$shop_title = $meta_shop_title;
}
$shop_description     = reactor_option( 'woo_shop_description' );
$meta_shop_descrition = reactor_option( 'woo_shop_description', '', 'meta_products_page_options' );
if ( isset( $meta_shop_descrition ) && ! empty( $meta_shop_descrition ) ) {
	$shop_description = $meta_shop_descrition;
}

if ( '3' === $shop_columns ) {
	$column_class = 'col-md-4';
} elseif ( '4' === $shop_columns ) {
	$column_class = 'col-md-3';
} elseif ( '6' === $shop_columns ) {
	$column_class = 'col-md-2';
} else {
	$column_class = 'col-md-6';
}

$page_layout      = reactor_option( 'shop-main-sidebar' );
$meta_page_layout = reactor_option( 'meta-page-main-sidebar', '', 'meta_page_options' );
if ( isset( $meta_page_layout ) && ! empty( $meta_page_layout ) && ! ( 'default' === $meta_page_layout ) ) {
	$page_layout = $meta_page_layout;
}
$i = 1;
?>
<div class="row m-b-20">
<div class="col-md-12 p-t-10 m-b-20">

	<?php if ( isset( $shop_title ) && ! empty( $shop_title ) ) { ?>
		<h3 class="m-b-20"><?php echo esc_attr( $shop_title ); ?></h3>
	<?php } ?>

	<?php if ( isset( $shop_description ) && ! empty( $shop_description ) ) { ?>
		<p><?php echo apply_filters( 'polo_shop_description', $shop_description ); ?></p>
	<?php } ?>


</div><!--col-md-6 p-t-10 m-b-20-->
</div><!--.row m-b-20-->
<div class="shop">

	<div class="row">

		<?php if ( $product_query->have_posts() ) { ?>

			<div class="row">

			<?php while ( $product_query->have_posts() ) {

				$product_query->the_post(); ?>

				<div class="<?php echo esc_attr( $column_class ); ?>">

					<?php include POLO_ROOT_PATH . '/woocommerce/content-product.php'; ?>

				</div><!--columns-->

				<?php if ( $i % $shop_columns === 0 && ($i < $items_number) ) { ?>

					</div>
					<div class="row">

				<?php } ?>

				<?php $i ++; ?>

			<?php } ?>

			</div>

		<?php } ?>
	</div><!--row-->
</div><!--shop--!>

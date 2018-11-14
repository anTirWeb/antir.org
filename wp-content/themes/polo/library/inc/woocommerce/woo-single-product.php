<?php
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'polo_woo_product_after', 'woocommerce_output_related_products', 20 );

function polo_woo_product_category() {

	global $product;

	$output = '';

	$output .= '<div class="product-category">';

	$output .= wc_get_product_category_list( get_the_ID(),', ' );

	$output .= '</div>';

	echo apply_filters( 'polo_single_product_category', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_category', 5 );
add_action( 'polo_woo_shop_product_summary', 'polo_woo_product_category', 5 );

function polo_woo_product_title() {

	$output = '';

	$output .= '<div class="product-title">';
	$output .= '<h3>' . esc_attr( get_the_title( get_the_ID() ) ) . '</h3>';
	$output .= '</div>';

	echo apply_filters( 'polo_single_product_title', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_title', 10 );

function polo_woo_product_price() {

	global $product;

	$price = str_replace('<span class="amount">','<span class="amount"><ins>',$product->get_price_html());
	$price = str_replace('</span>','</ins></span>',$price);

	$output = '';

	$output .= '<div class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
	$output .= $price;

	$output .= '<meta itemprop="price" content="' . esc_attr( $product->get_price() ) . '" />';
	$output .= '<meta itemprop="priceCurrency" content="' . esc_attr( get_woocommerce_currency() ) . '" />';

	if ( $product->is_in_stock() ) {
		$schema_url = 'http://schema.org/InStock';
	} else {
		$schema_url = 'http://schema.org/OutOfStock';
	}

	$output .= '<link itemprop="availability" href="' . esc_url( $schema_url ) . '" />';

	$output .= '</div>';

	echo apply_filters( 'polo_single_product_price', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_price', 15 );
add_action( 'polo_woo_shop_product_summary', 'polo_woo_product_price', 15 );

function polo_woo_product_rating() {

	global $product;

	if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
		return;
	}

	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();

	$output = '';

	if ( $rating_count > 0 ) {

		$output .= '<div class="product-rate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
		$output .= '<div class="star-rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'polo' ), $average ) . '">';
		$output .= '<span style="width:' . ( ( $average / 5 ) * 100 ) . '%"></span>';
		$output .= '</div>';//star-rating
		$output .= '</div>';//.product-rate

		if ( comments_open() ) {
			$output .= '<div class="product-reviews">';
			$output .= '<a href="#reviews" rel="nofollow">';
			$output .= sprintf( _n( '%s customer review', '%s customer reviews', $review_count, 'polo' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' );
			$output .= '</a>';
			$output .= '</div>';//.product-reviews
		}

	}

	echo apply_filters( 'polo_single_product_rating', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_rating', 20 );
add_action( 'polo_woo_shop_product_summary', 'polo_woo_product_rating', 20 );

function polo_woo_product_excerpt() {

	global $post;

	$output = '';

	$output .= '<div class="seperator m-b-10"></div>';

	$output .= '<p>' . $post->post_excerpt . '</p>';

	echo apply_filters( 'polo_single_product_excerpt', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_excerpt', 30 );

function polo_woo_product_tags() {

	global $product, $post;
	$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

	$output = '';

	$output .= '<div class="product-meta">';

	$output .= $product->get_tags( ', ', '<p>' . _n( 'Tag:', 'Tags:', $tag_count, 'polo' ) . ' ', '</p>' );

	$output .= '</div>';

	$output .= '<div class="seperator m-t-20 m-b-10"></div>';

	echo apply_filters( 'polo_single_product_tags', $output );

}

add_action( 'polo_woo_product_summary', 'polo_woo_product_tags', 40 );

add_action( 'polo_woo_product_summary', 'woocommerce_template_single_add_to_cart', 50 );

function polo_woo_product_reviews(){

	$output = '';

	$output .= '<div class="col-md-6">';

	ob_start();
	comments_template();
	$output .= ob_get_clean();

	$output .= '</div>';

	echo apply_filters('polo_single_product_reviews',$output);

}

add_action('polo_woo_product_dopinfo','polo_woo_product_reviews',5);

function polo_woo_product_additional_info(){

	$output = '';

	$output .= '<div class="col-md-6">';
	$output .= '</div>';

	echo apply_filters('polo_single_product_add_info',$output);

}

add_action('polo_woo_product_dopinfo','polo_woo_product_additional_info',10);

add_filter( 'woocommerce_output_related_products_args', 'polo_related_posts_number' );
function polo_related_posts_number( $args ) {
	$args['posts_per_page'] = 6;
	return $args;
}
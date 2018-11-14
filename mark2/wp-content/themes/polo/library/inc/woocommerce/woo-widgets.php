<?php
function polo_before_product_widget( $html ) {

	$html = '';

	return $html;
}

add_filter( 'woocommerce_before_widget_product_list', 'polo_before_product_widget' );

function polo_after_product_widget( $html ) {
	$html = '';

	return $html;
}

add_filter( 'woocommerce_after_widget_product_list', 'polo_after_product_widget' );
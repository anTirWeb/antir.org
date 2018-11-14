<?php

//Logotype
$logo_image = reactor_option( 'logotype-image' );
if ( is_singular( 'portfolio' ) ) {
	$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'meta_portfolio_heading_options' );
} else {
	$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'meta_page_options' );
}
if ( isset( $meta_logo_image ) && ! empty( $meta_logo_image ) ) {
	$logo_image = $meta_logo_image;
}
//Retina logotype
$retina_image = reactor_option( 'logotype-image-retina' );
if ( is_singular( 'portfolio' ) ) {
	$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'meta_portfolio_heading_options' );
} else {
	$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'meta_page_options' );
}
if ( isset( $meta_retina_image ) && ! empty( $meta_retina_image ) ) {
	$retina_image = $meta_retina_image;
}

$logotype_image  = $logo_image ? wp_get_attachment_url( $logo_image ) : '';
$logotype_retina = $retina_image ? wp_get_attachment_url( $retina_image ) : '';

if ( isset( $logotype_retina ) && ! ( $logotype_retina == '' ) ) {
	$image_size = wp_get_attachment_metadata( $retina_image );
	if ( $logotype_retina ) {
		$image_size = absint( $image_size['width'] / 2 );
	}
	$logo_image = '<img src="' . esc_url($logotype_retina) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" style="width:' . $image_size . 'px">';
} elseif ( isset( $logotype_image ) && ! ( $logotype_image == '' ) ) {
	$logo_image = '<img src="' . esc_url($logotype_image) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
} else {
	$logo_image = '';
}
if ( isset( $logotype_retina ) && ! empty( $logotype_retina ) ) {
	$logo_data = 'data-dark-logo="' . $logotype_retina . '"';
} elseif ( isset( $logotype_image ) && ! empty( $logotype_image ) ) {
	$logo_data = 'data-dark-logo="' . $logotype_image . '"';
} else {
	$logo_data = '';
}

$top_bar_socicons    = reactor_option( 'top-bar-soc-icons' );

$copyright_text = reactor_option( 'copyright-text' );
if ( function_exists( 'icl_object_id' ) ) {
	$current_language = ICL_LANGUAGE_CODE;
	$copyright_text   = $copyright_text[ $current_language ];
}

if ( is_array( $copyright_text ) ) {
	$copyright_text = array_slice( $copyright_text, 0, 1 );
	$copyright_text = implode( $copyright_text );
}


$output = '';

$output .= '<div id="side-panel">';
$output .= '<div class="side-panel-wrap">';

//Logo
$output .= '<div id="panel-logo">';
$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" class="logo" ' . $logo_data . '>';
$output .= $logo_image;
$output .= '</a>';
$output .= '</div>';//.logo

$output .= '<div class="navbar-collapse collapse main-menu-collapse navigation-wrap">';
$output .= '<div class="container">';

$output .= '<nav id="mainMenu" class="main-menu mega-menu">';
$menu_output = polo_main_menu();
$output .= $menu_output;
$output .= '</nav>';

$output .= '</div>';//container
$output .= '</div>';//.navbar-collapse
//endmenu

if ( isset( $top_bar_socicons ) && is_array( $top_bar_socicons ) && ! empty( $top_bar_socicons ) ) {
	$output .= '<div class="panel-widget">';
	$output .= '<div class="social-icons social-icons-colored">';

	$output .= '<ul>';

	foreach ( $top_bar_socicons as $single_socicon ) {
		if ( 'google-plus' === $single_socicon['social-network-icon'] ) {
			$output .= '<li class="social-google">';
		} else {
			$output .= '<li class="social-' . $single_socicon['social-network-icon'] . '">';
		}
		$output .= '<a href="' . esc_url($single_socicon['social-network-url']) . '"><i class="fa fa-' . $single_socicon['social-network-icon'] . '"></i></a>';
		$output .= '</li>';
	}

	$output .= '</ul>';

	$output .= '</div>';/*social-icons*/
	$output .= '</div>';/*panel-widget*/
}

$output .= '<div class="panel-widget side-panel-footer">';
$output .= '<div class="copyright-text text-center">';
$output .= $copyright_text;
$output .= '</div>';
$output .= '</div>';

$output .= '</div>';/*side-panel-wrap*/
$output .= '</div>';/*side-panel*/


echo apply_filters( 'polo_side_menu', $output );


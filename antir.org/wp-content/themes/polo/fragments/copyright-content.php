<?php
//footer copyright section
$footer_copyright_enable      = reactor_option( 'footer-copyright-enable' );
$copyright_text               = reactor_option( 'copyright-text', '' );
$footer_soc_links             = reactor_option( 'footer-soclinks-enable' );
$soc_icons                    = reactor_option( 'top-bar-soc-icons' );
$footer_soc_links_style       = reactor_option( 'footer-social-link-style' );
$footer_soc_links_transparent = reactor_option( 'footer-soclinks-transparency-enable' );


$copyright_text = polo_do_multilang_text( $copyright_text );


$output = '';
/*
 * Footer copyright section
 */


if ( isset( $footer_copyright_enable ) && ( true === $footer_copyright_enable ) ) {
	$output .= '<div class="copyright-content">';

	$output .= '<div class="container">';

	$output .= '<div class="row">';

	if ( isset( $copyright_text ) && ! empty( $copyright_text ) ) {
		$width_class = isset( $footer_soc_links ) && ! empty( $footer_soc_links ) ? 'col-md-6' : 'text-center';
		$output .= '<div class="copyright-text ' . esc_attr( $width_class ) . '">';
		$output .= do_shortcode( $copyright_text );
		$output .= '</div>';// .copyright-text col-md-6
	}
	if ( isset( $footer_soc_links ) && ( true === $footer_soc_links ) ) {

		$style_class = 'colored' === $footer_soc_links_style ? 'social-icons-colored' : '';
		$width_class = isset( $copyright_text ) && ! empty( $copyright_text ) ? 'col-md-6' : 'text-center';
		$icons_align = $width_class === 'text-center' ? 'center' : 'right';

		$output .= '<div class="' . esc_attr( $width_class ) . '">';
		if ( isset( $soc_icons ) && is_array( $soc_icons ) && ! empty( $soc_icons ) ) {
			$output .= '<div class="social-icons  ' . esc_attr( $icons_align . $style_class ) . '">';
			$output .= '<ul>';
			foreach ( $soc_icons as $single_socicon ) {
				$output .= '<li class="social-' . $single_socicon['social-network-icon'] . '">';
				$output .= '<a href="' . esc_url( $single_socicon['social-network-url'] ) . '"><i class="fa fa-' . $single_socicon['social-network-icon'] . '"></i></a>';
				$output .= '</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';//.social-icons
		}
		$output .= '</div>';//.col-md-6
	}
	$output .= '</div>';//.row
	$output .= '</div>';//.container
	$output .= '</div>';//copyright-content
}

echo( $output );
<?php
function polo_do_footer() {

	get_template_part( 'fragments/footer' );

}

add_action( 'polo_footer_inside', 'polo_do_footer', 5 );

if ( ! function_exists( 'polo_footer_sidebars' ) ) {

	function polo_footer_sidebars( $layout = 'style_1' ) {

		$output = '';

		if ( 'style_2' === $layout ) {

			$output .= '<div class="col-md-6">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';


			$output .= '<div class="col-md-6">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';

		} elseif ( 'style_3' === $layout ) {

			$output .= '<div class="col-md-4">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';


			$output .= '<div class="col-md-4">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';


			$output .= '<div class="col-md-4">';
			$output .= polo_get_sidebar( 'sidebar-footer-3' );
			$output .= '</div>';

		} elseif ( 'style_4' === $layout ) {

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';


			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';


			$output .= '<div class="col-md-6">';
			$output .= polo_get_sidebar( 'sidebar-footer-3' );
			$output .= '</div>';

		} elseif ( 'style_5' === $layout ) {

			$output .= '<div class="col-md-6">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';


			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';


			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-3' );
			$output .= '</div>';

		} elseif ( 'style_6' === $layout ) {

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';


			$output .= '<div class="col-md-6">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';


			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-3' );
			$output .= '</div>';

		} elseif ( 'style_7' === $layout ) {

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-2' );
			$output .= '</div>';

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-3' );
			$output .= '</div>';

			$output .= '<div class="col-md-3">';
			$output .= polo_get_sidebar( 'sidebar-footer-4' );
			$output .= '</div>';

		} elseif ( 'style_8' === $layout ) {

			$output .= '';

		} else {

			$output .= '<div class="col-md-12">';
			$output .= polo_get_sidebar( 'sidebar-footer-1' );
			$output .= '</div>';

		}

		return $output;

	}

}

/**
 * Footer links and site info
 * in footer.php
 *
 * @since 1.0.0
 */
function polo_tracking_code() {
	if ( ( reactor_option( 'tracking-code', '' ) !== '' ) && ( reactor_option( 'tracking-code' ) != 'jQuery(document).ready(function(){\n\n});' ) ) {
		echo '<script>' . reactor_option( 'tracking-code' ) . '</script>';
	}
	if ( reactor_option( 'js-code', '' ) !== '' ) {
		echo '<script>' . reactor_option( 'js-code' ) . '</script>';
	}
}

add_action( 'polo_footer_after', 'polo_tracking_code', 1 );
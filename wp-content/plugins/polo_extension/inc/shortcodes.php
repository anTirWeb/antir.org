<?php
/******************************
 * Theme standard shortcodes
 ******************************/

function crum_wp_url_shortcode() {
	$output = '<a href=" http://wordpress.org/" title=" Wordpress">Wordpress</a>';

	return $output;
}

function crum_site_url_shortcode() {
	$output = '<a href=" ' . home_url() . '" title=" ' . get_bloginfo( 'name' ) . '">' . get_bloginfo( 'name' ) . '</a>';

	return $output;
}

function crum_theme_url_shortcode() {
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme();
		$theme_uri  = $theme_data->get( 'ThemeURI' );
		$theme_name = $theme_data->get( 'Name' );
	}
	$output = '<a href=" ' . $theme_uri . '" title="' . $theme_name . '">' . $theme_name . '</a>';

	return $output;
}

function crum_login_url_shortcode() {
	$output = '<a href=" ' . wp_login_url( home_url() ) . '" title=" Login">Login</a>';

	return $output;
}

function crum_logout_url_shortcode() {
	$output = '<a href=" ' . wp_logout_url( home_url() ) . '" title=" Logout">Logout</a>';

	return $output;
}

function crum_site_title_shortcode() {
	$output = get_bloginfo( 'name' );

	return $output;
}

function crum_site_tagline_shortcode() {
	$output = get_bloginfo( 'description' );

	return $output;
}

function crum_current_year_shortcode() {
	$output = date( "Y" );

	return $output;
}

add_shortcode( 'wp-url', 'crum_wp_url_shortcode' );
add_shortcode( 'site-url', 'crum_site_url_shortcode' );
add_shortcode( 'theme-url', 'crum_theme_url_shortcode' );
add_shortcode( 'login-url', 'crum_login_url_shortcode' );
add_shortcode( 'logout-url', 'crum_logout_url_shortcode' );
add_shortcode( 'site-title', 'crum_site_title_shortcode' );
add_shortcode( 'site-tagline', 'crum_site_tagline_shortcode' );
add_shortcode( 'current-year', 'crum_current_year_shortcode' );

function crum_subform( $atts = array() ) {

	$return = $style = $block_class = $prepend = $thankyou = $jsthanks = $emailholder = $submittxt = '';

	extract( shortcode_atts( array(
		"style"       => 'style_1',
		"block_class" => '',
		"prepend"     => '',
		"emailholder" => esc_html__( 'Email Address', 'polo_extension' ),
		"jsthanks"    => false,
		"thankyou"    => esc_html__( 'Thank you for subscribing to our mailing list', 'polo_extension' ),
	), $atts ) );

	$action = ( isset( $_SERVER["REQUEST_URI"] ) ) ? $_SERVER["REQUEST_URI"] : '';

	$form_id = uniqid( 'subscribe' );

	$button_class = 'btn-primary';

	if ( function_exists( 'reactor_option' ) ) {
		$footer_style = reactor_option( 'footer-color-scheme' );
	} else {
		$footer_style = '';
	}

	$return .= '<form id="'.$form_id.'" action="' . $action . '" class="form-inline crum-subscribe-form" method="post" data-msg="' . $thankyou . '" data-error="' . esc_html__( 'Please, fill email field with correct info.', 'polo_extension' ) . '">
	<input class="crum_hiddenfield" name="crum_subscribe" type="hidden" value="1">';

	$return .= '<div class="input-group">';

	if ( 'style_2' === $style ) {
		$return .= '<div class="input-group-addon"><i class="fa fa-paper-plane"></i></div>';
		$button_text = esc_html__( 'Subscribe', 'polo_extension' );
		if ( 'footer-colored' === $footer_style ) {
			$button_class = 'btn-default';
		}
	} else {
		$button_text = '<i class="fa fa-paper-plane"></i>';
	}

	$return .= '<input class="form-control required email" name="crum_email" type="email" placeholder="' . $emailholder . '" required/>';

	$return .= '<span class="input-group-btn">';

	$return .= '<button type="submit" id="widget-subscribe-submit-button" class="btn ' . $button_class . '">' . $button_text . '</button>';

	$return .= '</span>';//.input-group-btn

	$return .= '</div>';//.input-group

	$return .= '<div class="form-popup"><div class="form-popup-close-layer"></div><div class="form-popup-content"><div class="text"></div></div></div>';

	$return .= '</form>';

	return $return;
}

/*
 * MCE editor shortcodes
 */

function dropcap_shortcode( $atts, $content = null ) {

	$shortcode_atts = shortcode_atts( array(
		'style' => '',
		'shape' => '',
		'size'  => '',
	), $atts );

	$class = array();

	$class[] = 'dropcap';

	if ( 'colored' === $shortcode_atts['style'] ) {
		$class[] = 'dropcap-colored';
	}

	if ( 'circle' === $shortcode_atts['shape'] ) {
		$class[] = 'dropcap-circle';
	}

	if ( 'large' === $shortcode_atts['size'] ) {
		$class[] = 'dropcap-large';
	} elseif ( 'small' === $shortcode_atts['size'] ) {
		$class[] = 'dropcap-small';
	}

	$class = implode( ' ', $class );

	$output = '';

	$output .= '<span class="' . $class . '">';
	$output .= $content;
	$output .= '</span>';//.$class

	return $output;

}

add_shortcode( 'crumina_dropcap', 'dropcap_shortcode' );

function crum_text_highlight( $atts, $content = null ) {

	$shortcode_atts = shortcode_atts( array(
		'style' => 'default',
		'size'  => 'normal',
	), $atts );

	$before = $after = '';

	$class = array();

	$class[] = 'highlight';

	if ( 'small' === $shortcode_atts['size'] ) {
		$class[] = 'highlight-small';
	} elseif ( 'large' === $shortcode_atts['size'] ) {
		$class[] = 'highlight-large';
	}

	if ( 'colored' === $shortcode_atts['style'] ) {
		$class[] = 'highlight-colored';
	} elseif ( 'deleted' === $shortcode_atts['style'] ) {
		$class[] = 'highlight-colored';
		$before  = '<del>';
		$after   = '</del>';
	} elseif ( 'bootstrap' === $shortcode_atts['style'] ) {
		$class[] = '';
		$before  = '<mark>';
		$after   = '</mark>';
	}

	$class = implode( ' ', $class );

	$output = '';

	if ( ! ( 'bootstrap' === $shortcode_atts['style'] ) ) {
		$output .= '<span class="' . $class . '">';
	}
	$output .= $before;
	$output .= $content;
	$output .= $after;
	if ( ! ( 'bootstrap' === $shortcode_atts['style'] ) ) {
		$output .= '</span>';//.$class
	}

	return $output;

}

add_shortcode( 'crumina_text_highlight', 'crum_text_highlight' );

function crumina_label( $atts, $content = null ) {

	$shortcode_atts = shortcode_atts( array(
		'style' => 'default',
	), $atts );

	$output = '';

	$output .= '<span class="label label-' . $shortcode_atts['style'] . '">';
	$output .= $content;
	$output .= '</span>';//.$class

	return $output;

}

add_shortcode( 'crumina_label', 'crumina_label' );

function crumina_tooltip( $atts, $content = null ) {

	$shortcode_atts = shortcode_atts( array(
		'title' => '',
		'align' => 'left',
	), $atts );

	$output = '';

	$output .= '<span data-toggle="tooltip" data-placement="' . $shortcode_atts['align'] . '" title="' . $shortcode_atts['title'] . '">';
	$output .= $content;
	$output .= '</span>';

	return $output;

}

add_shortcode( 'crumina_tooltip', 'crumina_tooltip' );


function crumina_styled_list( $atts, $content = null ) {

	$shortcode_atts = shortcode_atts( array(
		'icon' => '',
	), $atts );

	if ( ! ( substr_count( $content, '<ul' ) == 0 ) ) {
		$output = preg_replace( '/<ul/', '<ul class="styled-list" data-icon="' . $shortcode_atts['icon'] . '"', $content );
	} else {
		$output = $content;
	}

	return $output;

}

add_shortcode( 'crumina_styled_list', 'crumina_styled_list' );

function crumina_text_rotator( $atts, $content = null ) {

	$output = '';

	$shortcode_atts = shortcode_atts( array(
		'text'         => '',
		'animation'    => '',
		'rotate_speed' => '',
	), $atts );

	$output .= '<span class="text-rotator" ';
	if ( isset( $shortcode_atts['animation'] ) && ! empty( $shortcode_atts['animation'] ) ) {
		$output .= 'data-rotate-effect="' . $shortcode_atts['animation'] . '" ';
	}
	if ( isset( $shortcode_atts['rotate_speed'] ) && ! empty( $shortcode_atts['rotate_speed'] ) ) {
		$output .= 'data-rotate-speed="' . $shortcode_atts['rotate_speed'] . '000"';
	}
	$output .= '>' . $content . ',' . $shortcode_atts['text'] . '</span>';

	return $output;

}

add_shortcode( 'crumina_text_rotator', 'crumina_text_rotator' );

function crumina_onepage_scroll( $atts, $content = null ) {

	$output = '';

	$shortcode_atts = shortcode_atts( array(
		'id'    => '',
		'color' => '',
	), $atts );

	$output .= '<div class="text-center text-' . $shortcode_atts['color'] . '">';
	$output .= '<a href="#' . $shortcode_atts['id'] . '" class="scroll-to"><i class="fa fa-chevron-down fa-2x"></i></a>';
	$output .= '</div>';

	return $output;

}

add_shortcode( 'crumina_onepage_scroll', 'crumina_onepage_scroll' );
<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css_animation
 * @var $css
 * @var $content - shortcode content
 * Shortcode class
 * @var $this    WPBakeryShortCode_VC_Column_text
 */
$el_class = $css = $animation = $animation_delay = $custom_delay = '';
$atts     = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'wpb_text_column wpb_content_element ';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$animation_data = $animation_data_delay = $align_class = '';

if ( isset( $animation ) && ! empty( $animation ) ) {

	if ( isset( $animation ) && ! empty( $animation ) ) {
		$animation_data = 'data-animation="' . $animation . '"';
	}
	if ( isset( $animation_delay ) && ! empty( $animation_delay ) ) {
		if ( 'custom' === $animation_delay ) {
			$animation_delay = $custom_delay;
		}
		$animation_data_delay = 'data-animation-delay="' . $animation_delay . '"';
	}
}

$output = '
	<div class="' . esc_attr( $css_class ) . '" ' . $animation_data . ' ' . $animation_data_delay . '>
		<div class="wpb_wrapper">
			' . wpb_js_remove_wpautop( $content, true ) . '
		</div>
	</div>
';

echo ($output);

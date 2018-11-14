<?php
$this_post = get_post( get_the_ID() );

$content = $this_post->post_content;
preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

$output = '';

$output .= '<section id="section1" class="parallax no-padding" data-stellar-background-ratio="0.6">';
$output .= '<div class="background-overlay-one"></div>';
$output .= '<div class="container">';

if ( isset( $matches[0][0] ) && ! empty( $matches[0][0] ) ) {
	$output .= do_shortcode( $matches[0][0] );
}

$output .= '</div>';/*container*/
$output .= '</section>';

echo apply_filters( 'polo_before_header_section', $output );
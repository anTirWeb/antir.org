<?php
/*
 *Template for page display
 */
?>

<?php
$page_layout = 'page-main-sidebar';
$page_width  = 'page-sidebar-width';
?>

<?php
$section_class = array();
$page_meta     = get_post_meta( get_the_ID(), 'meta_page_options', true );
if ( isset( $page_meta['top_padding_disable'] ) && true === $page_meta['top_padding_disable'] ) {
	$section_class[] = 'no-padding-top';
}
if ( isset( $page_meta['bottom_padding_disable'] ) && true === $page_meta['bottom_padding_disable'] ) {
	$section_class[] = 'no-padding-bottom';
}
$section_class = implode( ' ', $section_class );
?>

<?php get_header(); ?>

<?php
$before_content_shortcode = polo_do_multilang_text(reactor_option( 'before_content_shortcode', '', 'before_content_shortcode_section' ));

$before_content_shortcode_t_p = reactor_option( 'content_shortcode_top_padding', '', 'before_content_shortcode_section' );
$before_content_shortcode_b_p = reactor_option( 'content_shortcode_bottom_padding', '', 'before_content_shortcode_section' );

$output = '';

if ( isset( $before_content_shortcode ) && ! empty( $before_content_shortcode ) ) {
	$shortcode_section_bg = reactor_option( 'before_content_shortcode_bg', '', 'before_content_shortcode_section' );

	$shortcode_section_style = '';

	if ( isset( $shortcode_section_bg ) && ! empty( $shortcode_section_bg ) && is_array( $shortcode_section_bg ) ) {
		$shortcode_section_style .= 'style="';
		if ( isset( $shortcode_section_bg['image'] ) && ! empty( $shortcode_section_bg['image'] ) ) {
			$shortcode_section_style .= 'background-image:url(' . $shortcode_section_bg['image'] . ');';
		}
		if ( isset( $shortcode_section_bg['color'] ) && ! empty( $shortcode_section_bg['color'] ) ) {
			$shortcode_section_style .= 'background-color:' . $shortcode_section_bg['color'] . ';';
		}
		if ( isset( $shortcode_section_bg['repeat'] ) && ! empty( $shortcode_section_bg['repeat'] ) ) {
			$shortcode_section_style .= 'background-repeat:' . $shortcode_section_bg['repeat'] . ';';
		}
		if ( isset( $shortcode_section_bg['position'] ) && ! empty( $shortcode_section_bg['position'] ) ) {
			$shortcode_section_style .= 'background-position:' . $shortcode_section_bg['position'] . ';';
		}
		if ( isset( $shortcode_section_bg['attachment'] ) && ! empty( $shortcode_section_bg['attachment'] ) ) {
			$shortcode_section_style .= 'background-attachment:' . $shortcode_section_bg['attachment'] . ';';
		}
		$shortcode_section_style .= '""';
	}

	$output .= '<section class="' . esc_attr( $before_content_shortcode_t_p ) . ' ' . $before_content_shortcode_b_p . '" ' . $shortcode_section_style . '>';
	$output .= '<div class="container">';
	$output .= do_shortcode( $before_content_shortcode );
	$output .= '</div>';/*container*/
	$output .= '</section>';
}
echo apply_filters( 'polo_before_content_shortcode', $output );
?>

<?php polo_content_before(); ?>

<section class="content <?php echo esc_attr( $section_class ); ?>">

	<div class="container">

		<?php polo_set_layout( $page_layout, $page_width, true ); ?>

		<?php
		polo_inner_content_before();

		while ( have_posts() ) : the_post();

			polo_post_before();

			the_content();

			polo_post_after();

		endwhile;

		polo_inner_content_after();
		?>

		<?php polo_set_layout( $page_layout, $page_width, false ); ?>

	</div>
	<!--.content-->

</section><!--.content-->

<?php polo_content_after(); ?>

<?php get_footer(); ?>

<?php
/**
 * Template Name: News Page
 *
 */
?>

<?php
$blog_style        = reactor_option( 'blog_style' );
$masonry_fullwidht = reactor_option( 'masonry_fullwidth' );

$meta_blog_style = reactor_option( 'blog_style', '', 'meta_news_page_options' );
if ( isset( $meta_blog_style ) && ! empty( $meta_blog_style ) && ! ( 'default' === $meta_blog_style ) ) {
	$blog_style = $meta_blog_style;
}
$meta_masonry_fullwidth = polo_metaselect_to_switch( reactor_option( 'masonry_fullwidth', '', 'meta_news_page_options' ) );
if ( ! ( null === $meta_masonry_fullwidth ) ) {
	$masonry_fullwidht = $meta_masonry_fullwidth;
}

$container_class = 'container';

if ( isset( $blog_style ) && ( 'masonry' === $blog_style ) && isset( $masonry_fullwidht ) && true === $masonry_fullwidht ) {
	$container_class = 'container-fluid';
}
$section_class = array();
$page_meta     = get_post_meta( get_the_ID(), 'meta_page_options', true );
if ( isset( $page_meta['top_padding_disable'] ) && true === $page_meta['top_padding_disable'] ) {
	$section_class[] = 'no-padding-top';
}
if ( isset( $page_meta['bottom_padding_disable'] ) && true === $page_meta['bottom_padding_disable'] ) {
	$section_class[] = 'no-padding-bottom';
}
$header_style = reactor_option( 'header_style' );
if ( is_singular( 'portfolio' ) ) {
	$meta_header_style = reactor_option( 'header_style', '', 'meta_portfolio_heading_options' );
} else {
	$meta_header_style = reactor_option( 'header_style', '', 'meta_page_options' );
}
if ( isset( $meta_header_style ) && ! empty( $meta_header_style ) && ! ( 'default' === $meta_header_style ) ) {
	$header_style = $meta_header_style;
}
if ( 'side' === $header_style ) {
	$section_class[] = 'background-grey p-10';
}

$section_class = implode( ' ', $section_class );
?>

<?php get_header(); ?>

<?php
$before_content_shortcode = reactor_option( 'before_content_shortcode', '', 'before_content_shortcode_section' );
$before_content_shortcode = polo_do_multilang_text( $before_content_shortcode );

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

	<div class="<?php echo esc_attr( $container_class ); ?>">
		<?php polo_page_before(); ?>

		<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', true ); ?>

		<?php
		while ( have_posts() ) : the_post();

			the_content();

		endwhile;
		?>

		<?php polo_loop_before(); ?>
		<div class="row">
			<?php // get the news page loop
			get_template_part( 'loops/loop', 'newspage' ); ?>
		</div>
		<?php polo_loop_after(); ?>


		<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', false ); ?>

		<?php polo_page_after(); ?>

	</div>
	<!--.content-->

</section><!--.content-->

<?php polo_content_after(); ?>

<?php get_footer(); ?>

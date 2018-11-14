<?php
/**
 * Template Name: Top Section Page
 *
 */
?>

<?php
$page_layout = 'page-main-sidebar';
$page_width  = 'page-sidebar-width';

$this_post = get_post( get_the_ID() );
$content   = $this_post->post_content;
preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

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

<?php polo_content_before(); ?>

<section class="content <?php echo esc_attr( $section_class ); ?>">

	<div class="container">

		<?php polo_set_layout( $page_layout, $page_width, true ); ?>

		<?php
		polo_inner_content_before();

		while ( have_posts() ) : the_post();

			polo_post_before();

			if ( isset( $matches[0][0] ) && ! empty( $matches[0][0] ) ) {
				$page_content = get_the_content();
				$page_content = str_replace( $matches[0][0], '', $page_content );
				$page_content = do_shortcode( $page_content );
				echo apply_filters( 'polo_top_section_page_content', $page_content );
			} else {
				the_content();
			}

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

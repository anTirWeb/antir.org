<?php
/**
 * Template Name: Portfolio Page
 *
 */
?>

<?php
$full_width      = reactor_option( 'enable_fullwidth' );
$meta_full_width = polo_metaselect_to_switch( reactor_option( 'meta_enable_fullwidth', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_full_width ) ) {
	$full_width = $meta_full_width;
}
if ( true === $full_width ) {
	$container_class = 'container-fluid';
} else {
	$container_class = 'container';
}
$section_class = array();
$page_meta     = get_post_meta( get_the_ID(), 'meta_page_options', true );
if ( isset( $page_meta['top_padding_disable'] ) && true === $page_meta['top_padding_disable'] ) {
	$section_class[] = 'no-padding-top';
}
if ( isset( $page_meta['bottom_padding_disable'] ) && true === $page_meta['bottom_padding_disable'] ) {
	$section_class[] = 'no-padding-bottom';
}
$section_class = implode( ' ', $section_class );
$gray_bg       = reactor_option( 'enable_gray_bg' );
$meta_gray_bg  = polo_metaselect_to_switch( reactor_option( 'meta_enable_gray_bg', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_gray_bg ) ) {
	$gray_bg = $meta_gray_bg;
}
?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

<?php if ( isset( $gray_bg ) && ( true === $gray_bg ) ){ ?>
<section id="content" class="background-grey">
	<?php }else{ ?>
	<section class="content <?php echo esc_attr( $section_class ); ?>">
		<?php } ?>

		<div class="portfolio <?php echo esc_attr( $container_class ); ?>">
			<?php polo_page_before(); ?>

			<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', true ); ?>

			<?php while ( have_posts() ) : the_post();

				the_content();

			endwhile; ?>

			<?php polo_loop_before(); ?>

			<?php  get_template_part( 'loops/loop', 'portfolio' ); ?>

			<?php polo_loop_after(); ?>

			<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', false ); ?>

			<?php polo_page_after(); ?>

		</div>
		<!--.content-->

	</section><!--.content-->

	<?php polo_content_after(); ?>

	<?php get_footer(); ?>

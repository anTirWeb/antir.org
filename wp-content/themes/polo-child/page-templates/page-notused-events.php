<?php
/**
 * Template Name: Events List Page
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

<?php
$preloader_data = polo_theme_preloader();
?>

<body <?php body_class(); echo apply_filters('polo_preloader_data',$preloader_data);?> >
<!-- WRAPPER -->
<div class="wrapper">

	<section class="p-t-0 p-b-0">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php while ( have_posts() ): the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
					
					<p>using template: wp-content/themes/polo-child/page-templates/page-events.php</p>
				</div>
			</div>
		</div>
	</section>

</div>
<!-- END: WRAPPER -->


	<?php polo_content_after(); ?>

	<?php get_footer(); ?>
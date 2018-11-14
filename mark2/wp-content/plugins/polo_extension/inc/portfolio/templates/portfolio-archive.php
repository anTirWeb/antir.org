<?php
/**
 * The template for displaying archive pages
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */
?>

<?php get_header(); ?>

<?php if ( function_exists( 'polo_content_before' ) ) {
	polo_content_before();
} ?>

	<section class="content">

		<div class="portfolio container">
			<?php if ( function_exists( 'polo_page_before' ) ) {
				polo_page_before();
			} ?>

			<?php if ( function_exists( 'polo_set_layout' ) ) {
				polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', true );
			} ?>

			<?php if ( function_exists( 'polo_loop_before' ) ) {
				polo_loop_before();
			} ?>

			<?php // get the news page loop
			require_once( PLUGIN_PATH . 'inc/portfolio/templates/loop-portfolio.php' ); ?>

			<?php if ( function_exists( 'polo_loop_after' ) ) {
				polo_loop_after();
			} ?>


			<?php if ( function_exists( 'polo_set_layout' ) ) {
				polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', false );
			} ?>

			<?php if ( function_exists( 'polo_page_after' ) ) {
				polo_page_after();
			} ?>

		</div>
		<!--.content-->

	</section><!--.content-->

<?php if ( function_exists( 'polo_content_after' ) ) {
	polo_content_after();
} ?>

<?php get_footer(); ?>
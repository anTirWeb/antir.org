<?php
/**
 * The default template file
 *
 * @package Polo
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

	<section class="content">

		<div class="container">
			<?php polo_page_before(); ?>

			<?php polo_set_layout( 'archive-main-sidebar', 'archive-sidebar-width', true ); ?>

			<?php polo_loop_before(); ?>

			<?php // get the news page loop
			get_template_part( 'loops/loop' ); ?>

			<?php polo_set_layout( 'archive-main-sidebar', 'archive-sidebar-width', false ); ?>

			<?php polo_loop_after(); ?>

			<?php polo_page_after(); ?>

		</div>
		<!--.content-->

	</section><!--.content-->

<?php polo_content_after(); ?>

<?php get_footer(); ?>
<?php
/**
 * The sidebar template containing the main widget area
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */
?>

<?php polo_sidebar_before(); ?>
<?php

// if layout has one sidebar and the sidebar is active
if(post_type_exists( 'product' ) && is_singular( 'product' ) && is_active_sidebar('shop-2') || function_exists('is_shop') && is_shop() || is_page_template('page-templates/shop-page.php')):?>

	<aside id="primary-sidebar" role="complementary">
		<?php dynamic_sidebar( 'shop-2' ); ?>
	</aside><!-- #sidebar -->

<?php elseif ( is_active_sidebar( 'secondary-sidebar' ) ) : ?>

	<aside id="primary-sidebar" role="complementary">
		<?php dynamic_sidebar( 'secondary-sidebar' ); ?>
	</aside><!-- #sidebar -->

<?php // else show an alert
else : ?>

	<aside id="primary-sidebar" role="complementary">
		<div class="jumbotron"><p><?php esc_html_e( 'Add some widgets to this area!', 'polo' ); ?></p></div>
	</aside><!-- #sidebar -->

<?php endif; ?>

<?php polo_sidebar_after(); ?>
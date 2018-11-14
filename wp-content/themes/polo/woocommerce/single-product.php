<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<?php
	$before_footer_shortcode = reactor_option('woo_shortcode');
	$layout = reactor_option('single-product-sidebar');
	$meta_layout = reactor_option('meta-product-main-sidebar','','single_product_layout');
	if(isset($meta_layout) && !empty($meta_layout) && !('default' === $meta_layout)){
		$layout = $meta_layout;
	}
?>

<?php get_header(); ?>

<?php polo_woo_product_before(); ?>

<section id="product-page" class="product-page p-b-40">

	<div class="container">

		<?php polo_set_layout( 'single-product-sidebar', '', true ); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php set_query_var('layout',$layout)?>

			<?php if ( function_exists( 'wc_get_template_part' ) ) {
				wc_get_template_part( 'content', 'single-product' );
			} ?>

		<?php endwhile; // end of the loop. ?>

		<?php polo_set_layout( 'single-product-sidebar', '', false ); ?>


	</div><!--.container-->

</section><!--#product-page-->

<section class="p-t-0">
	<div class="container">
		<?php polo_woo_product_after(); ?>
	</div><!--container-->
</section>

<?php if(isset($before_footer_shortcode) && !empty($before_footer_shortcode)){?>
<section class="background-grey p-t-40 p-b-0">

	<div class="container">

		<?php echo do_shortcode($before_footer_shortcode);?>

	</div>

</section>
<?php }?>
<?php get_footer(); ?>

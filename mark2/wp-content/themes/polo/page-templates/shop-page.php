<?php
/**
 * Template Name: Shop Page
 *
 */
?>

<?php
$before_footer_shortcode = reactor_option( 'woo_shortcode' );
$meta_shortcode = reactor_option('woo_shortcode','','meta_products_page_options');
if(isset($meta_shortcode) && !empty($meta_shortcode)){
	$before_footer_shortcode = $meta_shortcode;
}
$shop_fullwidth = reactor_option( 'shop_fullwidth' );
$shop_layout    = reactor_option( 'shop-main-sidebar','','meta-page-main-sidebar' );
$meta_shop_layout    = reactor_option( 'meta-page-main-sidebar','','meta_page_options' );

if(isset($meta_shop_layout) && !empty($meta_shop_layout) && !('default' === $meta_shop_layout)){
	$shop_layout = $meta_shop_layout;
}

$meta_shop_fullwidth = reactor_option('shop_fullwidth','','meta_products_page_options');
if(isset($meta_shop_fullwidth) && !empty($meta_shop_fullwidth) && !('default' === $meta_shop_fullwidth)){

	if('true' === $meta_shop_fullwidth){
		$shop_fullwidth = true;
	}elseif('false' === $meta_shop_fullwidth){
		$shop_fullwidth = false;
	}

}

if ( true === $shop_fullwidth && ( '1col-fixed' === $shop_layout ) ) {
	$width_class = 'container-fluid';
} else {
	$width_class = 'container';
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
?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

	<section class="content <?php echo esc_attr( $section_class ); ?>">

		<div class="<?php echo esc_attr( $width_class ); ?>">
			<?php polo_page_before(); ?>

			<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', true ); ?>

			<?php
			while ( have_posts() ) : the_post();

				the_content();

			endwhile;
			?>

			<?php polo_loop_before(); ?>

			<?php // get the news page loop
			get_template_part( 'loops/loop', 'products' ); ?>

			<?php polo_loop_after(); ?>


			<?php polo_set_layout( 'page-main-sidebar', 'page-sidebar-width', false ); ?>

			<?php polo_page_after(); ?>

		</div>
		<!--.content-->

	</section><!--.content-->
<?php if ( isset( $before_footer_shortcode ) && ! empty( $before_footer_shortcode ) ) { ?>
	<section class="background-grey p-t-40 p-b-0">

		<div class="container">

			<?php echo do_shortcode( $before_footer_shortcode ); ?>

		</div>

	</section>
<?php } ?>
<?php polo_content_after(); ?>

<?php get_footer(); ?>
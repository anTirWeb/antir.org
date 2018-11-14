<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<?php
$shop_title              = polo_do_multilang_text(reactor_option( 'woo_shop_title' ));
$shop_description        = reactor_option( 'woo_shop_description' );
$shop_layout             = reactor_option( 'shop-main-sidebar' );
$before_footer_shortcode = reactor_option( 'woo_shortcode' );

$shop_columns   = reactor_option( 'shop_columns_number', '2' );
$shop_fullwidth = reactor_option( 'shop_fullwidth' );

if ( '3' === $shop_columns ) {
	$column_class = 'col-md-4';
} elseif ( '4' === $shop_columns ) {
	$column_class = 'col-md-3';
} elseif ( '6' === $shop_columns ) {
	$column_class = 'col-md-2';
} else {
	$column_class = 'col-md-6';
}

if ( true === $shop_fullwidth && ( '1col-fixed' === $shop_layout ) ) {
	$width_class = 'container-fluid';
} else {
	$width_class = 'container';
}

$i = 1;

$per_page = get_query_var( 'posts_per_page' );

?>
<?php get_header(); ?>

<section>

	<div class="<?php echo esc_attr( $width_class ); ?>">

		<?php polo_set_layout( 'shop-main-sidebar', '', true ); ?>

        <header class="woocommerce-products-header">

			<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>

        </header>
        <div class="row m-b-20">

			<?php if ( ! ( '2c-b-fixed' === $shop_layout ) ) {
				if ( isset( $shop_title ) && ! empty( $shop_title ) ||
				     isset( $shop_description ) && ! empty( $shop_description )
				) {
					$sorting_calls_class = 'col-md-3'; ?>
                    <div class="col-md-6">
						<?php if ( isset( $shop_title ) && ! empty( $shop_title ) ) { ?>
                            <h3 class="m-b-10"><?php echo esc_attr( $shop_title ); ?></h3>
						<?php } ?>
						<?php if ( isset( $shop_description ) && ! empty( $shop_description ) ) { ?>
                            <p class="m-b-0"><?php echo apply_filters( 'polo_shop_description', $shop_description ); ?></p>
						<?php } ?>
                    </div><!--col-md-6 p-t-10 m-b-20-->
					<?php
				} else {
					$sorting_calls_class = 'col-md-6';
				}
				?>
				<div class="<?php echo esc_attr($sorting_calls_class); ?>">
					<div class="order-select">
						<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
						?>
					</div><!--order-select-->
				</div><!--col-md-3-->
                <div class="<?php echo esc_attr($sorting_calls_class); ?>">
					<div class="order-select">
						<?php polo_woo_product_additional_filter(); ?>
					</div>
				</div><!--col-md-3-->

			<?php } else { ?>

				<div class="col-md-6">
					<div class="order-select">
						<h6><?php esc_html_e( 'Sort by', 'polo' ); ?></h6>
						<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
						?>
					</div><!--order-select-->
				</div><!--col-md-3-->

				<div class="col-md-6">
					<div class="order-select">
						<h6><?php esc_html_e( 'Products on page', 'polo' ); ?></h6>
						<?php
						polo_woo_product_additional_filter();
						?>
					</div>
				</div><!--col-md-3-->
			<?php } ?>

		</div><!--row m-b-20-->

		<div class="shop">
				

				<?php if ( have_posts() ) : ?>
                    <?php
                    /**
                     * woocommerce_before_shop_loop hook.
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
					//do_action( 'woocommerce_before_shop_loop' );
                    ?>

					<?php woocommerce_product_loop_start(); ?>

                    <?php woocommerce_product_subcategories(); ?>
                    <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="<?php echo esc_attr( $column_class ); ?>">

                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>

                            <?php if ( $i % $shop_columns === 0 && ( $i < $per_page ) ) { ?>
                                </div>
                                <div class="row">
                            <?php } ?>

                            <?php $i ++; ?>

                        <?php endwhile; // end of the loop. ?>
                    </div>
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php
					/**
					 * woocommerce_no_products_found hook.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
					?>

				<?php endif; ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
			/**
			 * woocommerce_after_shop_loop hook.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
			?>

	        <?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			//do_action( 'woocommerce_after_main_content' );
			?>
			<?php
			polo_page_links( array( 'type' => 'numbered' ) );
			?>

		</div><!--shop-->

		<?php polo_set_layout( 'shop-main-sidebar', '', false ); ?>

	</div><!--container-->

</section>

<?php if ( isset( $before_footer_shortcode ) && ! empty( $before_footer_shortcode ) ) { ?>
	<section class="background-grey p-t-40 p-b-0">

		<div class="container">

			<?php echo do_shortcode( $before_footer_shortcode ); ?>

		</div>

	</section>
<?php } ?>
<?php get_footer(); ?>

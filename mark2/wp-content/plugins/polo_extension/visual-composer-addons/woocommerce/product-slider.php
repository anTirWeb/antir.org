<?php
if ( ! class_exists( 'Crumina_Product_Slider' ) ) {

	class Crumina_Product_Slider {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'slider_init' ) );
			add_shortcode( 'crumina_product_slider', array( &$this, 'slider_form' ) );

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_product_slider_cache' ) ) {

				$tmp = get_option( 'crum_product_slider_cache' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_product_slider_transient' . $transient_id;
				update_option( 'crum_product_slider_cache', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_product_slider_transient' . $transient_id;

				add_option( 'crum_product_slider_cache', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_product_slider_cache' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_product_slider_cache' );
		}

		function slider_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'     => esc_html__( 'Polo Product slider', 'polo_extension' ),
						'base'     => 'crumina_product_slider',
						'icon'     => 'product-slider',
						'category' => esc_html__( 'Polo Woocommerce', 'polo_extension' ),
						'params'   => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'classic' => $assets_dir . 'product-slider-classic.png',
									'fancy'   => $assets_dir . 'product-slider-fancy.png',
								),
								'std'         => 'list',
							),
							array(
								'type'        => 'loop',
								'heading'     => esc_html__( 'Loop parameters', 'polo_extension' ),
								'param_name'  => 'loop',
								'settings'    => array(
									'post_type'  => array( 'hidden' => true, 'value' => 'product' ),
									'size'       => array( 'hidden' => false, 'value' => 12 ),
									'order_by'   => array( 'value' => 'date' ),
									'categories' => array( 'hidden' => true, 'value' => '' ),
									'tags'       => array( 'hidden' => true, 'value' => '' ),
									'tax_query'  => array( 'hidden' => false, 'value' => '' ),
									'by_id'      => array( 'hidden' => true, 'value' => '' ),
									'authors'    => array( 'hidden' => false, 'value' => '' )
								),
								'description' => esc_html__( 'Number of posts, Order parameters, Select category, Tags, Author, etc.', 'polo_extension' )
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name'       => 'slides_to_show',
								'min'              => 0,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'tab_id',
								'param_name'       => 'transient_id',
								'heading'          => esc_html__( 'Block ID', 'crum' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
								'param_name'  => 'el_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
							),
						)
					)
				);
			}

		}

		function slider_form( $atts, $content = null ) {

			$output = $layout = $loop = $slides_to_show = $transient_id = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'layout'         => 'classic',
						'loop'           => 'size:12|order_by:date|order:ASC|post_type:product',
						'slides_to_show' => '3',
						'transient_id'   => '',
						'el_class'       => '',
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}

			$this->getLoop( $loop );

			$args = $this->loop_args;

			if ( ( ! isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'product';
			}
			if ( function_exists( 'pll_current_language' ) ) {
				$transient_id = $transient_id . '_' . pll_current_language();
			}
			if ( false === ( $the_query = get_transient( 'crum_product_slider_transient' . $transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_product_slider_transient' . $transient_id, $the_query );
				$this->update_id_option( $transient_id );
			}

			if ( $the_query->have_posts() ) {

				$output .= '<div class="woocommerce">';

				if('fancy' === $layout){
					$output .= '<div class="grid-articles carousel post-carousel" data-carousel-col="' . $slides_to_show . '" data-carousel-margins="0" data-carousel-auto-play="true">';

					while ( $the_query->have_posts() ): $the_query->the_post();

						ob_start();
						include PLUGIN_PATH . '/visual-composer-addons/templates/format-product-fancy.php';
						$output .= ob_get_clean();

					endwhile;

					$output .= '</div>';/*grid-articles*/

				}else{

					$output .= '<div class="carousel shop-products" data-carousel-col="' . $slides_to_show . '">';

					while ( $the_query->have_posts() ): $the_query->the_post();

						ob_start();
						include PLUGIN_PATH . '/visual-composer-addons/templates/format-product-grid.php';
						$output .= ob_get_clean();

					endwhile;

					$output .= '</div>';/*carousel*/
				}

				$output .= '</div>';//woocommerce

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Product_Slider' ) ) {
	$Crumina_Product_Slider = new Crumina_Product_Slider;
}
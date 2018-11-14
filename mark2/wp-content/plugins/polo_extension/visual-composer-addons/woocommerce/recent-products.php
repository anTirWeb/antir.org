<?php
if ( ! class_exists( 'Crumina_Recent_Products' ) ) {

	class Crumina_Recent_Products {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'products_init' ) );
			add_shortcode( 'crumina_recent_products', array( &$this, 'products_form' ) );

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_recent_products_cache' ) ) {

				$tmp = get_option( 'crum_recent_products_cache' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_recent_products_transient' . $transient_id;
				update_option( 'crum_recent_products_cache', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_products_transient' . $transient_id;

				add_option( 'crum_recent_products_cache', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_recent_products_cache' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_recent_products_cache' );
		}

		function products_init() {
			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/' );
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(

						'name'     => esc_html__( 'Polo Recent Products', 'polo_extension' ),
						'base'     => 'crumina_recent_products',
						'icon'     => 'recent-product',
						'category' => esc_html__( 'Polo Woocommerce', 'polo_extension' ),
						'params'   => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'list' => $assets_dir . 'products-list.png',
									'grid' => $assets_dir . 'products-grid.png',
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
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Columns number', 'polo_extension' ),
								'param_name' => 'columns_number',
								'value'      => array(
									'2 ' . esc_html__( 'columns', 'polo_extension' ) => '2',
									'3 ' . esc_html__( 'columns', 'polo_extension' ) => '3',
									'4 ' . esc_html__( 'columns', 'polo_extension' ) => '4',
									'5 ' . esc_html__( 'columns', 'polo_extension' ) => '5',
									'6 ' . esc_html__( 'columns', 'polo_extension' ) => '6',

								),
								'dependency' => array(
									'element' => 'layout',
									'value'   => 'grid'
								),
							),
							array(
								'type'       => 'tab_id',
								'param_name' => 'transient_id',
								'heading'    => esc_html__( 'Block ID', 'crum' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
								'param_name'  => 'el_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Animation', 'polo_extension' ),
								'value'       => array_flip( crum_vc_animations() ),
								'group'       => esc_html__( 'Animation', 'polo_extension' ),
								'admin_label' => true,
								'param_name'  => 'animation',
							),
							array(
								"type"       => "dropdown",
								"class"      => "",
								"heading"    => esc_html__( "Animation delay", 'polo_extension' ),
								"param_name" => "animation_delay",
								"value"      => array(
									esc_html__( 'none', 'polo_extension' )   => '0',
									'0.5 sec'                                => '500',
									'1.0 sec'                                => '1000',
									'1.5 sec'                                => '1500',
									'2.0 sec'                                => '2000',
									'2.5 sec'                                => '2500',
									esc_html__( 'custom', 'polo_extension' ) => 'custom',
								),
								'group'      => esc_html__( 'Animation', 'polo_extension' ),
								"dependency" => Array(
									"element"   => "animation",
									"not_empty" => true
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Custom animation delay', 'polo_extension' ),
								'param_name'  => 'custom_delay',
								'description' => esc_html__( 'Custom animation delay in milliseconds', 'polo_extension' ),
								'group'       => esc_html__( 'Animation', 'polo_extension' ),
								"dependency"  => Array(
									"element" => "animation_delay",
									"value"   => 'custom'
								),
							),
						)

					)
				);
			}

		}

		function products_form( $atts, $content ) {

			$output = $layout = $loop = $columns_number = $transient_id = $el_class = $animation = $animation_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'layout'          => 'list',
						'loop'            => 'size:12|order_by:date|order:ASC|post_type:product',
						'columns_number'  => '2',
						'transient_id'    => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
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
			if ( false === ( $the_query = get_transient( 'crum_recent_products_transient' . $transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_recent_products_transient' . $transient_id, $the_query );
				$this->update_id_option( $transient_id );
			}

			$animation_data = $animation_data_delay = '';

			if ( isset( $animation ) && ! empty( $animation ) ) {

				if ( isset( $animation ) && ! empty( $animation ) ) {
					$animation_data = 'data-animation="' . $animation . '"';
				}
				if ( isset( $animation_delay ) && ! empty( $animation_delay ) ) {
					if ( 'custom' === $animation_delay ) {
						$animation_delay = $custom_delay;
					}
					$animation_data_delay = 'data-animation-delay="' . $animation_delay . '"';
				}
			}

			if ( $the_query->have_posts() ) {

				$output .= '<div class="woocommerce '.$el_class.'" '.$animation_data.' '.$animation_data_delay.'>';

				if ( 'grid' === $layout ) {

					$i = 1;

					if ( '3' === $columns_number ) {
						$column_class = 'col-md-4';
					} elseif ( '4' === $columns_number ) {
						$column_class = 'col-md-3';
					} elseif ( '6' === $columns_number ) {
						$column_class = 'col-md-2';
					} else {
						$column_class = 'col-md-6';
					}

					$output .= '<div class="shop">';
					$output .= '<div class="row">';

					while ( $the_query->have_posts() ) : $the_query->the_post();

						$output .= '<div class="' . $column_class . '">';

						ob_start();
						include PLUGIN_PATH . '/visual-composer-addons/templates/format-product-grid.php';
						$output .= ob_get_clean();

						$output .= '</div>';/*columns*/

						if ( $i % $columns_number === 0 && ( $i < $args['posts_per_page'] ) ) {

							$output .= '</div>';
							$output .= '<div class="row">';

						}

						$i ++;
					endwhile;

					$output .= '</div>';/*row*/
					$output .= '</div>';/*shop*/

				} else {

					$output .= '<div class="widget-shop recent-products-list">';

					while ( $the_query->have_posts() ) : $the_query->the_post();

						ob_start();
						include PLUGIN_PATH . '/visual-composer-addons/templates/format-product-list.php';
						$output .= ob_get_clean();

					endwhile;

					$output .= '</div>';/*widget-shop*/

				}

				$output .= '</div>';
			}

			wp_reset_query();

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Recent_Products' ) ) {
	$Crumina_Recent_Products = new Crumina_Recent_Products;
}
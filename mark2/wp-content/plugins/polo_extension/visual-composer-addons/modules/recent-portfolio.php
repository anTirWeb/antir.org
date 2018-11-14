<?php
if ( ! class_exists( 'Crumina_Recent_Portfolio' ) ) {
	class Crumina_Recent_Portfolio {
		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'recent_portfolio_init' ) );
			add_shortcode( 'crumina_recent_portfolio', array( &$this, 'recent_portfolio_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}


		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_recent_portfolio_cache' ) ) {

				$tmp = get_option( 'crum_recent_portfolio_cache' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_recent_portfolio_transient' . $transient_id;
				update_option( 'crum_recent_portfolio_cache', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_portfolio_transient' . $transient_id;

				add_option( 'crum_recent_portfolio_cache', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_recent_portfolio_cache' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_recent_portfolio_cache' );
		}

		function recent_portfolio_init() {
			if ( function_exists( 'vc_map' ) ) {

				$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/recent-portfolio/' );

				vc_map(
					array(
						'name'        => esc_html__( 'Polo Recent Portfolios', 'polo_extension' ),
						'base'        => 'crumina_recent_portfolio',
						'icon'        => 'portfolio_grid_icon',
						'category'    => esc_html__( 'Polo Modules', 'polo_extension' ),
						'description' => esc_html__( 'Add block with portfolio grid', 'polo_extension' ),
						'params'      => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'default' => $assets_dir . 'portfolio-hover-default.png',
									'alea'    => $assets_dir . 'portfolio-hover-alea.png',
									'ariol'   => $assets_dir . 'portfolio-hover-areol.png',
									'dia'     => $assets_dir . 'portfolio-hover-dia.png',
									'dorian'  => $assets_dir . 'portfolio-hover-dorian.png',
									'emma'    => $assets_dir . 'portfolio-hover-emma.png',
									'erdi'    => $assets_dir . 'portfolio-hover-erdi.png',
									'juna'    => $assets_dir . 'portfolio-hover-juna.png',
									'resa'    => $assets_dir . 'portfolio-hover-resa.png',
									'retro'   => $assets_dir . 'portfolio-hover-retro.png',
									'victor'  => $assets_dir . 'portfolio-hover-victor.png',
									'bleron'  => $assets_dir . 'portfolio-hover-bleron.png',
								),
								'std'         => 'default',
								'group'       => esc_attr__( 'Layout', 'polo_extension' ),
							),
							array(
								'type'             => 'dropdown',
								'class'            => '',
								'heading'          => esc_html__( 'Block style', 'polo_extension' ),
								'param_name'       => 'block_style',
								'value'            => array(
									esc_html__( 'Classic', 'polo_extension' ) => 'classic',
									esc_html__( 'Masonry', 'polo_extension' ) => 'masonry',

								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'dependency'       => array(
									'element' => 'layout',
									'value'   => 'default'
								)
							),
							array(
								'type'             => 'dropdown',
								'class'            => '',
								'heading'          => esc_html__( 'Columns number', 'polo_extension' ),
								'param_name'       => 'columns_number',
								'value'            => array(
									'2 ' . esc_html__( 'columns', 'polo_extension' ) => '2',
									'3 ' . esc_html__( 'columns', 'polo_extension' ) => '3',
									'4 ' . esc_html__( 'columns', 'polo_extension' ) => '4',
									'5 ' . esc_html__( 'columns', 'polo_extension' ) => '5',
									'6 ' . esc_html__( 'columns', 'polo_extension' ) => '6',

								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
							),
							array(
								'type'        => 'loop',
								'heading'     => esc_html__( 'Loop parameters', 'polo_extension' ),
								'param_name'  => 'loop',
								'settings'    => array(
									'post_type'  => array( 'hidden' => true, 'value' => 'portfolio' ),
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
								'type'             => 'checkbox',
								'class'            => '',
								'heading'          => esc_html__( 'Sorting panel', 'polo_extension' ),
								'param_name'       => 'enable_panel',
								'value'            => array(
									esc_html__( 'Enable', 'polo_extension' ) => '1',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								'description'      => '',
							),
							array(
								'type'             => 'dropdown',
								'class'            => '',
								'heading'          => esc_html__( 'Sorting panel style', 'polo_extension' ),
								'param_name'       => 'sorting_panel_style',
								'value'            => array(
									esc_html__( 'Default', 'polo_extension' )     => 'default',
									esc_html__( 'Classic', 'polo_extension' )     => 'classic',
									esc_html__( 'Transparent', 'polo_extension' ) => 'transparent',

								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'dependency'       => array(
									'element' => 'layout',
									'value'   => 'default'
								)
							),
							array(
								'type'             => 'checkbox',
								'class'            => '',
								'heading'          => esc_html__( 'Item space', 'polo_extension' ),
								'param_name'       => 'enable_space',
								'value'            => array(
									esc_html__( 'Enable', 'polo_extension' ) => '1',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								'description'      => '',
							),
							array(
								'type'             => 'dropdown',
								'class'            => '',
								'heading'          => esc_html__( 'Space size', 'polo_extension' ),
								'param_name'       => 'space_size',
								'value'            => array(
									'1%' => '1',
									'2%' => '2',
									'3%' => '3',
									'4%' => '4',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'dependency'       => Array(
									'element' => 'enable_space',
									'value'   => '1'
								),
							),
							array(
								'type'       => 'tab_id',
								'param_name' => 'transient_id',
								'heading'    => esc_html__( 'Block ID', 'crum' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => __( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
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
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Animation delay', 'polo_extension' ),
								'param_name' => 'animation_delay',
								'value'      => array(
									esc_html__( 'none', 'polo_extension' )   => '0',
									'0.5 sec'                                => '500',
									'1.0 sec'                                => '1000',
									'1.5 sec'                                => '1500',
									'2.0 sec'                                => '2000',
									'2.5 sec'                                => '2500',
									esc_html__( 'custom', 'polo_extension' ) => 'custom',
								),
								'group'      => esc_html__( 'Animation', 'polo_extension' ),
								'dependency' => Array(
									'element'   => 'animation',
									'not_empty' => true
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Custom animation delay', 'polo_extension' ),
								'param_name'  => 'custom_delay',
								'description' => esc_html__( 'Custom animation delay in milliseconds', 'polo_extension' ),
								'group'       => esc_html__( 'Animation', 'polo_extension' ),
								'dependency'  => Array(
									'element' => 'animation_delay',
									'value'   => 'custom'
								),
							),
						),
					)
				);
			}
		}

		function recent_portfolio_form( $atts, $content = null ) {

			$layout       = $block_style = $loop = $columns_number = $enable_panel = $sorting_panel_style = $enable_space = $space_size = '';
			$transient_id = $el_class = $animation = $animation_delay = $custom_delay = '';
			extract(
				shortcode_atts(
					array(
						'layout'              => 'default',
						'block_style'         => 'classic',
						'loop'                => 'size:12|order_by:date|order:ASC|post_type:portfolio',
						'columns_number'      => '2',
						'enable_panel'        => '',
						'sorting_panel_style' => 'default',
						'enable_space'        => '',
						'space_size'          => '1',
						'transient_id'        => '',
						'el_class'            => '',
						'animation'           => '',
						'animation_delay'     => '0',
						'custom_delay'        => '',
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}

			$output = '';

			$this->getLoop( $loop );

			$args = $this->loop_args;

			if ( ( ! isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'portfolio';
			}
			if ( function_exists( 'pll_current_language' ) ) {
				$transient_id = $transient_id . '_' . pll_current_language();
			}
			if ( false === ( $the_query = get_transient( 'crum_recent_portfolio_transient' . $transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_recent_portfolio_transient' . $transient_id, $the_query );
				$this->update_id_option( $transient_id );
			}

			if ( '1' === $enable_space ) {
				$space = $space_size;
			} else {
				$space = '0';
			}

			if ( $the_query->have_posts() ) {

				if ( function_exists('polo_folio_active_categories') ) {
					$categories_to_display = polo_folio_active_categories($the_query);
				} else {
					$categories_to_display = array();
				}

				set_query_var( 'hover_style', $layout );
				set_query_var( 'block_style', $block_style );

				$output .= '<div class="portfolio">';

				if ( '1' === $enable_panel && function_exists( 'polo_category_submenu' ) ) {
					$included_cats = $excluded_cats = array();
					if ( isset( $args['tax_query'] ) && ! empty( $args['tax_query'] ) ) {
						foreach ( $args['tax_query'] as $single_part ) {
							if ( is_array( $single_part ) && array_key_exists( 'operator', $single_part ) ) {
								if ( 'IN' === $single_part['operator'] ) {
									$included_cats = $single_part['terms'];
								} elseif ( 'NOT IN' === $single_part['operator'] ) {
									$excluded_cats = $single_part['terms'];
								}
							}
						}
					}
					$category_submenu_args = array(
						'taxonomy'     => 'portfolio-category',
						'filter_style' => $sorting_panel_style,
					);

					if ( isset( $included_cats ) && ! empty( $included_cats ) ) {
						$category_submenu_args['terms_args'] = array( 'include' => $included_cats );
					} elseif ( isset( $excluded_cats ) && ! empty( $excluded_cats ) ) {
						$category_submenu_args['terms_args'] = array( 'exclude' => $excluded_cats );
					} elseif ( isset( $categories_to_display ) && is_array( $categories_to_display ) ) {
						$category_submenu_args['terms_args'] = array( 'include' => array_unique( $categories_to_display ) );
					}

					ob_start();
					polo_category_submenu( $category_submenu_args );
					$output .= ob_get_clean();
				}

				$output .= '<div id="isotope" class="isotope portfolio-items" data-isotope-item-space="' . $space . '" data-isotope-mode="masonry" data-isotope-col="' . $columns_number . '" data-isotope-item=".portfolio-item">';

				while ( $the_query->have_posts() ) : $the_query->the_post();

					ob_start();
					include PLUGIN_PATH . '/visual-composer-addons/templates/format-portfolio.php';
					$output .= ob_get_clean();

				endwhile;

				$output .= '</div>';//#isotope

				$output .= '</div>';//.portfolio


			}

			wp_reset_postdata();


			return $output;

		}

	}
}
if ( class_exists( 'Crumina_Recent_Portfolio' ) ) {
	$Crumina_Recent_Portfolio = new Crumina_Recent_Portfolio;
}
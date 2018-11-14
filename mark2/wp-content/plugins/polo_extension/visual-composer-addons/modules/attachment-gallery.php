<?php
if ( ! class_exists( 'Crumina_VC_Attachments_Categories' ) ) {

	class Crumina_VC_Attachments_Categories {

		function __construct() {
			add_action( 'admin_init', array( &$this, 'attachment_categories_init' ) );
			add_shortcode( 'crum_vc_attach_cats', array( &$this, 'attachment_categories_form' ) );

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'crum_widget_id' );

			return $uniue_id;
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_attachments' ) ) {

				$tmp = get_option( 'crum_cached_attachments' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_atts_categories_transient' . $transient_id;
				update_option( 'crum_cached_attachments', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_atts_categories_transient' . $transient_id;

				add_option( 'crum_cached_attachments', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_attachments' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_attachments' );
		}

		function attachment_categories_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"            => esc_html__( "Polo Attachments categories", "crum" ),
						"base"            => "crum_vc_attach_cats",
						"icon"            => "attachment-category",
						'content_element' => true,
						"category"        => esc_html__( 'Polo Modules', 'polo_extension' ),
						"description"     => esc_html__( "Displays grid of attachments from selected categories", 'crum' ),
						"params"          => array(
							array(
								"type"       => "textfield",
								"class"      => "",
								"heading"    => esc_html__( "Title", 'polo_extension' ),
								"param_name" => "title",
							),
							array(
								"type"       => "textfield",
								"class"      => "",
								"heading"    => esc_html__( "Description", 'polo_extension' ),
								"param_name" => "description",
							),
							array(
								'type'       => 'number',
								'heading'    => esc_html__( 'Custom title font size', 'polo_extension' ),
								'param_name' => 'custom_font_size',
								'min'        => 0,
								'std'        => '',
							),
							array(
								"type"        => "loop",
								"heading"     => esc_html__( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'size'       => array( 'hidden' => false, 'value' => 4 ),
									'post_type'  => array( 'hidden' => true, 'value' => 'attachment' ),
									'order_by'   => array( 'value' => 'date' ),
									'categories' => array( 'hidden' => true ),
									'tags'       => array( 'hidden' => true ),
								),
								"description" => esc_html__( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
							),
							array(
								"type"       => "tab_id",
								"param_name" => "transient_id",
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

		function attachment_categories_form( $atts, $content ) {

			$loop  = $transient_id = $animation = $animation_delay = $custom_delay = $el_class = $output = '';
			$title = $description = $custom_font_size = '';

			extract(
				shortcode_atts(
					array(
						'loop'             => 'size:4|order_by:date|order:ASC|post_type:attachment',
						'title'            => '',
						'custom_font_size' => '',
						'description'      => '',
						'el_class'         => '',
						'animation'        => '',
						'transient_id'     => '',
						'animation_delay'  => '0',
						'custom_delay'     => '',
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}
			$this->getLoop( $loop );


			$terms           = get_terms( 'attachments_categories' );
			$non_select_cats = array();
			//if ( $displaying_type == '1_column' ) {
			$args = $this->loop_args;

			if ( ! ( isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'attachment';
			}
			$args['post_mime_type'] = 'image';
			$args['post_status']    = 'inherit';
			if ( function_exists( 'pll_current_language' ) ) {
				$transient_id = $transient_id . '_' . pll_current_language();
			}

			$default_sort = 'false';

			if ( ! isset( $args['tax_query'] ) ) {
				$default_sort = 'true';
				foreach ( $terms as $single_term ) {
					$non_select_cats[] = $single_term->term_id;
				}
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'attachments_categories',
						'field'    => 'term_id',
						'terms'    => $non_select_cats,
						'operator' => 'IN'
					),
				);
			}

			if ( false === ( $attach_cats_query = get_transient( 'crum_atts_categories_transient' . $transient_id ) ) ) {
				$attach_cats_query = new WP_Query( $args );

				set_transient( 'crum_atts_categories_transient' . $transient_id, $attach_cats_query );

				$this->update_id_option( $transient_id );
			}

			$cats_array = array();
			$i          = 0;
			foreach ( $terms as $term ) {
				$cats_array[ $i ]['name'] = $term->name;
				$cats_array[ $i ]['slug'] = str_replace( '-', '_', $term->slug );
				$i ++;
			}
			if ( isset( $args['tax_query'] ) && ! ( 'true' === $default_sort ) ) {
				$exclude    = 'false';
				$all_cats   = $cats_array;
				$cats_array = array();
				unset( $args['tax_query']['relation'] );
				$j = 0;
				foreach ( $args['tax_query'] as $custom_category ) {
					if ( 'NOT IN' === $custom_category['operator'] ) {
						$exclude = 'true';
					} else {
						$exclude = 'false';
					}
					foreach ( $custom_category['terms'] as $single_category_term ) {
						$custom_selected_category = get_term_by( 'id', $single_category_term, $custom_category['taxonomy'] );
						$cats_array[ $j ]['name'] = $custom_selected_category->name;
						$cats_array[ $j ]['slug'] = str_replace( '-', '_', $custom_selected_category->slug );
						$j ++;
					}

				}

				if ( 'true' == $exclude ) {
					$custom_selection = $cats_array;
					$cats_array       = array();
					foreach ( $all_cats as $single ) {
						if ( ! ( in_array( $single, $custom_selection ) ) ) {
							$cats_array[] = $single;
						}
					}
				}

			}


			$animation_data = $animation_data_delay = $animation_data_delay_1 = '';

			if ( isset( $animation ) && ! empty( $animation ) ) {

				if ( isset( $animation ) && ! empty( $animation ) ) {
					$animation_data = 'data-animation="' . $animation . '"';
				}
				if ( isset( $animation_delay ) && ! empty( $animation_delay ) ) {
					if ( 'custom' === $animation_delay ) {
						$animation_delay = $custom_delay;
					}
					$animation_data_delay   = 'data-animation-delay="' . $animation_delay . '"';
					$animation_data_delay_1 = 'data-animation-delay="' . ( intval( $animation_delay ) + 200 ) . '"';
				}
			}

			if ( $attach_cats_query->have_posts() ) :

				$output .= '<div class="row">';

				$output .= '<div ' . $animation_data . ' ' . $animation_data_delay . ' class="col-md-4">';

				if ( isset( $title ) && ! empty( $title ) ) {

					if ( isset( $custom_font_size ) && ! empty( $custom_font_size ) ) {
						$custom_line_height = intval( $custom_font_size ) + 20;
						$custom_title_style = 'style="font-size:' . $custom_font_size . 'px !important; line-height:' . $custom_line_height . 'px !important;"';
					} else {
						$custom_title_style = '';
					}

					$output .= '<h1 class="text-large" ' . $custom_title_style . '>' . $title . '</h1>';
				}

				if ( isset( $description ) && ! empty( $description ) ) {
					$output .= '<h3><i>' . $description . '</i></h3>';
				}

				$output .= '<ul class="portfolio-filter" id="portfolio-filter" data-isotope-nav="isotope">';
				$output .= '<li class="ptf-active" data-filter="*">' . esc_html__( 'Show All', 'polo_extension' ) . '</li>';
				foreach ( $cats_array as $single_cat ) {
					$output .= '<li data-filter=".' . $single_cat['slug'] . '">' . $single_cat['name'] . '</li>';
				}
				$output .= '</ul>';

				$output .= '</div>';/*col-md-4*/

				$output .= '<div ' . $animation_data_delay_1 . ' ' . $animation_data . ' class="col-md-8">';

				$output .= '<div id="isotope" class="isotope" data-isotope-mode="masonry" data-isotope-item-space="1" data-isotope-col="3" data-lightbox-type="gallery">';

				while ( $attach_cats_query->have_posts() ) : $attach_cats_query->the_post();

					if ( has_term( '', 'attachments_categories', get_the_ID() ) ) {
						$image_class = array();

						$image_categories = wp_get_post_terms( get_the_ID(), 'attachments_categories' );
						if ( ! is_wp_error( $image_categories ) ) {
							foreach ( $image_categories as $single_category ) {
								$image_class[] = str_replace( '-', '_', $single_category->slug );
							}
						}


						$parsed = parse_url( wp_get_attachment_url( get_the_ID() ) );
						$url    = dirname( $parsed ['path'] ) . '/' . rawurlencode( basename( $parsed['path'] ) );

						$image_width  = '960';
						$image_height = '640';

						$output .= '<div class="isotope-item ' . implode( ' ', $image_class ) . '">';
						$output .= '<div class="effect effect-default">';

						$output .= '<img src="' . esc_url( polo_theme_thumb( $url, $image_width, $image_height, true ) ) . '" alt="">';
						$output .= '<div class="image-box-content">';
						$output .= '<p>';
						$output .= '<a href="' . $url . '" title="" data-lightbox="gallery-item"><i class="fa fa-expand"></i></a>';
						$output .= '</p>';
						$output .= '</div>';

						$output .= '</div>';
						$output .= '</div>';

					}//sorting-item

				endwhile;

				$output .= '</div>';/*#isotope*/

				$output .= '</div>';/*col-md-8*/


				$output .= '</div>';/*row*/


			endif;

			wp_reset_query();

			return $output;
		}

	}

}

if ( class_exists( 'Crumina_VC_Attachments_Categories' ) ) {
	$Crumina_VC_Attachments_Categories = new Crumina_VC_Attachments_Categories;
}
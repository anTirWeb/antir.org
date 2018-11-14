<?php
if ( ! class_exists( 'Crumina_Clients_Presentation' ) ) {

	class Crumina_Clients_Presentation {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crumina_clients_presentation_init' ) );
			add_shortcode( 'crumina_clients_presentation', array( &$this, 'crumina_clients_presentation_form' ) );
		}

		function crumina_clients_presentation_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/clients/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Clients presentation", 'polo_extension' ),
						"base"                    => "crumina_clients_presentation",
						"icon"                    => "client_presentation",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'main_layout',
								'options'     => array(
									'default'  => $assets_dir . 'classic.png',
									'grid'     => $assets_dir . 'grid.png',
									'carousel' => $assets_dir . 'carousel.png',
								),
								'std'         => 'default',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Grid style', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Default', 'crum' )  => 'default',
									esc_html__( 'Bordered', 'crum' ) => 'bordered',
								),
								'dependency' => array(
									'element' => 'main_layout',
									'value'   => array( 'grid' )
								),
								'param_name' => 'grid_style',
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Clients', 'polo_extension' ),
								'param_name' => 'clients',
								'params'     => array(
									array(
										'type'        => 'attach_image',
										'heading'     => esc_html__( 'Client photo', 'polo_extension' ),
										'param_name'  => 'client_photo',
										'value'       => '',
										'admin_label' => true,
										'description' => esc_html__( 'Select image from media library.', 'polo_extension' ),
									),
									array(
										"type"       => "vc_link",
										"class"      => "",
										"heading"    => esc_html__( "Client link ", 'polo_extension' ),
										"param_name" => "client_link",
										"value"      => "",
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Client description title', 'polo_extension' ),
										'param_name' => 'client_description_title',
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Client description', 'polo_extension' ),
										'param_name' => 'client_description',
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
								'param_name'  => 'el_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Columns number', 'polo_extension' ),
								'value'      => array(
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
									6 => 6
								),
								'dependency' => array(
									'element' => 'main_layout',
									'value'   => array( 'default', 'grid' )
								),
								'param_name' => 'columns',
								'group'      => esc_html__( 'Default settings', 'polo_extension' ),
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Carousel style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Default', 'cruum' )          => 'default',
									esc_html__( 'With description', 'cruum' ) => 'desc',
								),
								'dependency'       => array(
									'element' => 'main_layout',
									'value'   => array( 'carousel' )
								),
								'param_name'       => 'carousel_style',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'group'            => esc_html__( 'Carousel settings', 'polo_extension' ),
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Controls style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Dots', 'cruum' )   => 'dots',
									esc_html__( 'Arrows', 'cruum' ) => 'arrows',
								),
								'dependency'       => array(
									'element' => 'carousel_style',
									'value'   => array( 'default' )
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								'param_name'       => 'controls_style',
								'group'            => esc_html__( 'Carousel settings', 'polo_extension' ),
							),
							array(
								'type'       => 'number',
								'heading'    => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name' => 'slides_to_show',
								'min'        => 0,
								'std'        => '6',
								'dependency' => array(
									'element' => 'main_layout',
									'value'   => array( 'carousel' )
								),
								'group'      => esc_html__( 'Carousel settings', 'polo_extension' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'       => 'number',
								'heading'    => esc_html__( 'Slides space', 'polo_extension' ),
								'param_name' => 'slides_space',
								'description' => esc_html__('Space between slides in px','polo_extension'),
								'min'        => 0,
								'std'        => '',
								'dependency' => array(
									'element' => 'main_layout',
									'value'   => array( 'carousel' )
								),
								'group'      => esc_html__( 'Carousel settings', 'polo_extension' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => esc_html__( "Title", 'polo_extension' ),
								"param_name"  => "title",
								"admin_label" => false,
								"value"       => "",
								'dependency'  => array(
									'element' => 'main_layout',
									'value'   => array( 'carousel' )
								),
								'group'       => esc_html__( 'Carousel settings', 'polo_extension' ),
							),
							array(
								"type"        => "textarea",
								"class"       => "",
								"heading"     => esc_html__( "Description", 'polo_extension' ),
								"param_name"  => "description",
								"admin_label" => false,
								"value"       => "",
								'dependency'  => array(
									'element' => 'main_layout',
									'value'   => array( 'carousel' )
								),
								'group'       => esc_html__( 'Carousel settings', 'polo_extension' ),
							),

						)
					)
				);
			}

		}

		function do_images( $clients, $tag ) {

			$width  = '380';
			$height = '285';

			$output = '';

			if ( is_array( $clients ) ) {
				foreach ( $clients as $single_client ) {
					$image_url = wp_get_attachment_image_src( $single_client['client_photo'], 'full' );
					$image_url = polo_theme_thumb( $image_url[0], $width, $height, true, 'c' );
					if ( function_exists( 'vc_build_link' ) && isset($single_client['client_link']) ) {
						$href = vc_build_link( $single_client['client_link'] );
					}
					if ( isset( $href['target'] ) && ( ' _blank' === $href['target'] ) ) {
						$target = 'target="_blank"';
					} else {
						$target = '';
					}
					if ( isset( $href['url'] ) && ! empty( $href['url'] ) ) {
						$link = $href['url'];
					} else {
						$link = '#';
					}
					$link_content = 'href="' . $link . '" ' . $target . '';
					if ( isset( $single_client['client_description_title'] ) && ! empty( $single_client['client_description_title'] ) || ( isset( $single_client['client_description'] ) && ! empty( $single_client['client_description'] ) ) ) {
						$link_content .= 'title="" data-placement="top" data-toggle="popover" data-container="body" data-trigger="hover" ';
						if ( isset( $single_client['client_description_title'] ) && ! empty( $single_client['client_description_title'] ) ) {
							$link_content .= 'data-original-title="' . $single_client['client_description_title'] . '" ';
						}
						if ( isset( $single_client['client_description'] ) && ! empty( $single_client['client_description'] ) ) {
							$link_content .= 'data-content="' . $single_client['client_description'] . '"';
						}
					}
					$output .= '<' . $tag . '>';
					$output .= '<a ' . $link_content . '>';
					$output .= '<img src="' . $image_url . '" alt="' . get_the_title( $single_client['client_photo'] ) . '">';
					$output .= '</a>';
					$output .= '</' . $tag . '>';
				}
			}

			return $output;

		}

		function crumina_clients_presentation_form( $atts, $content = null ) {

			$output = $main_layout = $grid_style = $clients = $columns = $grid_border = $carousel_style = $controls_style = $slides_to_show = $slides_space = $title = $description = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'main_layout'    => 'default',
						'grid_style'     => 'default',
						'clients'        => '',
						'columns'        => '2',
						'grid_border'    => '',
						'carousel_style' => 'default',
						'controls_style' => 'dots',
						'slides_to_show' => '6',
						'slides_space'   => '',
						'title'          => '',
						'description'    => '',
						'el_class'       => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$clients = (array) vc_param_group_parse_atts( $clients );
			}

			$class = array();

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'grid' === $main_layout ) {
				$class[] = 'clients-grey';
				if ( 'bordered' === $grid_style ) {
					$class[] = 'clients-border';
				}
			}

			$data_space = '';
			if ( isset( $slides_space ) && ! empty( $slides_space ) ) {
				$data_space = 'data-carousel-margins="' . $slides_space . '"';
			}

			$class = implode( ' ', $class );

			if ( 'carousel' === $main_layout ) {

				if ( 'desc' === $carousel_style ) {

					$output .= '<div class="row clients-carousel carousel-description-clients carousel-description-style ">';

					$output .= '<div class="col-md-4">';
					$output .= '<div class="description">';
					if ( isset( $title ) && ! empty( $title ) ) {
						$output .= '<h2>' . $title . '</h2>';
					}
					if ( isset( $description ) && ! empty( $description ) ) {
						$output .= $description;
					}
					$output .= '</div>';//.description
					$output .= '</div>';//.col-md-4

					$output .= '<div class="col-md-8">';

					$output .= '<div class="carousel" data-carousel-col="' . $slides_to_show . '" ' . $data_space . '>';
					$output .= $this->do_images( $clients, 'div' );
					$output .= '</div>';//.carousel

					$output .= '</div>';//.col-md-8


					$output .= '</div>';//.row clients-carousel carousel-description-clients carousel-description-style

				} else {
					if ( 'dots' === $controls_style ) {
						$controls_data = 'data-carousel-dots="true"';
					} else {
						$controls_data = '';
					}

					$output .= '<div class="carousel clients-carousel" data-carousel-col="' . $slides_to_show . '" ' . $controls_data . ' ' . $data_space . '>';

					$output .= $this->do_images( $clients, 'div' );

					$output .= '</div>';
				}

			} else {

				$output .= '<ul class="grid grid-' . $columns . '-columns ' . $class . '">';

				$output .= $this->do_images( $clients, 'li' );

				$output .= '</ul>';//.grid grid-'.$columns.'-columns

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Clients_Presentation' ) ) {
	$Crumina_Clients_Presentation = new Crumina_Clients_Presentation;
}
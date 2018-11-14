<?php
if ( ! class_exists( 'Crumina_Fancy_Gallery' ) ) {

	class Crumina_Fancy_Gallery {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'gallery_init' ) );
			add_shortcode( 'crumina_fancy_gallery', array( &$this, 'gallery_form' ) );
		}

		function gallery_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Image gallery fancy", 'polo_extension' ),
						"base"                    => "crumina_fancy_gallery",
						"icon"                    => "icon-wpb-images-stack",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Images', 'polo_extension' ),
								'param_name' => 'fancy_images',
								'params'     => array(
									array(
										'type'        => 'attach_image',
										'heading'     => esc_html__( 'Image', 'polo_extension' ),
										'param_name'  => 'fancy_image',
										'value'       => '',
										'description' => esc_html__( 'Select images from media library.', 'polo_extension' ),
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Image Title', 'polo_extension' ),
										'param_name' => 'title',
									),
									array(
										'type'             => 'dropdown',
										"heading"          => esc_html__( "Title style", 'polo_extension' ),
										'value'            => array(
											esc_html__( 'Light', 'polo_extension' ) => 'light',
											esc_html__( 'Dark', 'polo_extension' )  => 'dark',
										),
										"param_name"       => "title_style",
										'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									),
									array(
										'type'             => 'dropdown',
										"heading"          => esc_html__( "Title align", 'polo_extension' ),
										'value'            => array(
											esc_html__( 'Left', 'polo_extension' )   => 'left',
											esc_html__( 'Right', 'polo_extension' )  => 'right',
											esc_html__( 'Center', 'polo_extension' ) => 'center',
										),
										"param_name"       => "title_align",
										'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
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

		function gallery_form( $atts, $content = null ) {

			$output = $el_class = $fancy_images = '';

			$animation      = $animation_delay = $custom_delay = '';
			$animation_data = $animation_data_delay = '';

			extract(
				shortcode_atts(
					array(
						'fancy_images'    => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

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

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$fancy_images = (array) vc_param_group_parse_atts( $fancy_images );
			}

			if ( isset( $fancy_images ) && ! empty( $fancy_images ) ) {

				$output .= '<div id="isotope" class="boxed-grid decor-category isotope ' . $el_class . '" data-isotope-item-space="2" data-isotope-mode="masonry" data-isotope-col="3" data-isotope-item=".grid-box-item" ' . $animation_delay . ' ' . $animation_data_delay . '>';

				$i = 1;

				foreach ( $fancy_images as $single_image ) {

					if ( 'dark' === $single_image['title_style'] ) {
						$title_style = 'text-dark';
					} else {
						$title_style = '';
					}

					$title_align = 'text-' . $single_image['title_align'];

					$image_full = wp_get_attachment_image_src( $single_image['fancy_image'], 'full' );

					if ( 2 === $i ) {
						$image_url = polo_theme_thumb( $image_full[0], '595', '830', true, 'c' );
					} else {
						$image_url = polo_theme_thumb( $image_full[0], '600', '399', true, 'c' );
					}

					$output .= '<div class="grid-box-item ' . $title_style . ' ' . $title_align . '">';
					$output .= '<a class="fit-img" href="#">';
					$output .= '<img alt="' . $i . '" src="' . esc_url( $image_url ) . '">';
					$output .= '<span class="title dark">' . $single_image['title'] . '</span>';
					$output .= '</a>';
					$output .= '</div>';

					$i ++;
					if ( 6 === $i ) {
						$i = 1;
					}

				}

				$output .= '</div>';

			}

			return $output;

		}


	}

}

if ( class_exists( 'Crumina_Fancy_Gallery' ) ) {
	$Crumina_Fancy_Gallery = new Crumina_Fancy_Gallery;
}
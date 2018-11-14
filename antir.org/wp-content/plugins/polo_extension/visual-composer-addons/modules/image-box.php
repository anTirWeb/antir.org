<?php
if ( ! class_exists( 'Crumina_Image_Box' ) ) {

	class Crumina_Image_Box {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'box_init' ) );
			add_shortcode( 'crumina_image_box', array( &$this, 'box_form' ) );
		}

		function box_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Image box", 'polo_extension' ),
						"base"                    => "crumina_image_box",
						"icon"                    => "image-box",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								"type"       => "textfield",
								"class"      => "",
								"heading"    => esc_html__( "Title", 'polo_extension' ),
								"param_name" => "title",
							),
							array(
								"type"       => "textarea",
								"class"      => "",
								"heading"    => esc_html__( "Description", 'polo_extension' ),
								"param_name" => "description",
							),
							array(
								'type'       => 'attach_image',
								'heading'    => esc_html__( 'Image', 'polo_extension' ),
								'param_name' => 'image',
								'value'      => '',
							),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__( 'Change image on hover?', 'polo_extension' ),
                                'param_name' => 'enable_hover_image',
                                'description' => esc_html__( 'If checked, image will be replaced by other one on hover.', 'polo_extension' ),
                                'value' => array( esc_html__( 'Yes', 'polo_extension' ) => true ),
                            ),
                            array(
                                'type'       => 'attach_image',
                                'heading'    => esc_html__( 'Hover image', 'polo_extension' ),
                                'param_name' => 'hover_image',
                                'value'      => '',
                                'dependency' => array(
                                    'element' => 'enable_hover_image',
                                    'not_empty' => true,
                                ),
                            ),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image width', 'polo_extension' ),
								'param_name'       => 'image_width',
								'min'              => 0,
								'std'              => '180',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image height', 'polo_extension' ),
								'param_name'       => 'image_height',
								'min'              => 0,
								'std'              => '180',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								"type"       => "dropdown",
								"class"      => "",
								"heading"    => esc_html__( "Title tag", 'polo_extension' ),
								"param_name" => "title_tag",
								"value"      => array(
									'h1' => 'h1',
									'h2' => 'h2',
									'h3' => 'h3',
									'h4' => 'h4',
									'h5' => 'h5',
									'h6' => 'h6',
								),
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

		function box_form( $atts, $content = null ) {

			$output = $title = $title_tag = $description = $image = $image_width = $image_height = $el_class = $animation = $animation_delay = $custom_delay = $enable_hover_image = $hover_image = '';

			extract(
				shortcode_atts(
					array(
						'title'             => '',
						'title_tag'         => 'h1',
						'description'       => '',
						'image'             => '',
						'enable_hover_image'=> '',
						'hover_image'       => '',
						'image_width'       => '180',
						'image_height'      => '180',
						'el_class'          => '',
						'animation'         => '',
						'animation_delay'   => '0',
						'custom_delay'      => '',
					), $atts
				)
			);

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


			$output .= '<div class="text-center ' . esc_attr( $el_class ) . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			$image_full = wp_get_attachment_image_src( $image, 'full' );
			$image_url  = polo_theme_thumb( $image_full[0], $image_width, $image_height, true, 'c' );

            $image_hover_full = wp_get_attachment_image_src( $hover_image, 'full' );
            $image_hover_url  = polo_theme_thumb( $image_hover_full[0], $image_width, $image_height, true, 'c' );

            if($enable_hover_image){
                $image_div_class = 'image-box-hover';
            }else{
                $image_div_class = '';
            }
			$output .= '<div class="'.$image_div_class.'">';
			if ( isset( $image_url ) && ! empty( $image_url ) ) {
				$output .= '<img src="' . $image_url . '" style="margin-bottom:16px;" class="main-image">';
			}
            if ($enable_hover_image && isset( $image_hover_url ) && ! empty( $image_hover_url ) ) {
                $output .= '<img src="' . $image_hover_url . '" style="margin-bottom:16px;" class="hover-image">';
            }
            $output .= '</div>';

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<' . $title_tag . '>' . $title . '</' . $title_tag . '>';
			}

			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<p>' . $description . '</p>';
			}

			$output .= '</div>';

			return $output;
		}

	}

}

if ( class_exists( 'Crumina_Image_Box' ) ) {
	$Crumina_Image_Box = new Crumina_Image_Box;
}
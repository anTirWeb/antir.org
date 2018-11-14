<?php
if ( ! class_exists( 'Crumina_Rotating_Text' ) ) {

	class Crumina_Rotating_Text {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'rotate_init' ) );
			add_shortcode( 'crum_rotating_text', array( &$this, 'rotate_form' ) );
		}

		function rotate_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Rotating text", 'polo_extension' ),
						"base"                    => "crum_rotating_text",
						"icon"                    => "rotating-text",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Rotating text', 'polo_extension' ),
								'param_name' => 'rotating_text',
								'params'     => array(
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Text', 'polo_extension' ),
										'param_name' => 'text',
									)
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Text size", 'polo_extension' ),
								"param_name"       => "text_size",
								"value"            => array(
									esc_html__( 'Small', 'polo_extension' )       => 'small',
									esc_html__( 'Medium', 'polo_extension' )      => 'medium',
									esc_html__( 'Large', 'polo_extension' )       => 'large',
									esc_html__( 'Extra large', 'polo_extension' ) => 'extra_large',
								),
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Text color", 'polo_extension' ),
								"param_name"       => "text_color",
								"value"            => array(
									esc_html__( 'Dark', 'polo_extension' )   => 'dark',
									esc_html__( 'Light', 'polo_extension' )  => 'light',
									esc_html__( 'Custom', 'polo_extension' ) => 'custom',
								),
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								"type"             => "colorpicker",
								"class"            => "",
								"heading"          => esc_html__( "Custom text color", 'polo_extension' ),
								"param_name"       => "custom_text_color",
								"value"            => "",
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								'dependency'       => array(
									'element' => 'text_color',
									'value'   => array( 'custom' )
								)
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Rotate speed in seconds', 'polo_extension' ),
								'param_name'       => 'rotate_speed',
								'min'              => 0,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Rotation effect", 'polo_extension' ),
								"param_name"       => "rotation_effect",
								"value"            => array(
									'Bounce'      => 'bounce',
									'Flash'       => 'flash',
									'Pulse'       => 'pulse',
									'Rubber Band' => 'rubberBand',
									'Shake'       => 'shake',
									'Swing'       => 'swing',
									'Tada'        => 'tada',
									'Wobble'      => 'wobble',
									'BounceIn'    => 'bounceIn',
									'FadeIn'      => 'fadeIn',
									'Flip'        => 'flip',
									'RotateIn'    => 'rotateIn',
									'SlideInUp'   => 'slideInUp',
									'ZoomIn'      => 'zoomIn',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
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

		function rotate_form( $atts, $content = null ) {

			$output = $rotating_text = $text_size = $text_color = $custom_text_color = $rotate_speed = $rotation_effect = '';

			$el_class = $animation = $animation_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'rotating_text'     => '',
						'text_size'         => 'small',
						'text_color'        => 'dark',
						'custom_text_color' => '',
						'rotate_speed'      => '3',
						'rotation_effect'   => 'bounce',
						'el_class'          => '',
						'animation'         => '',
						'animation_delay'   => '0',
						'custom_delay'      => '',
					), $atts
				)
			);

			$animation_data = $animation_data_delay = $custom_style = $color_class = '';
			$class          = $result = array();

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
				$rotating_text = (array) vc_param_group_parse_atts( $rotating_text );
			}

			if ( isset( $custom_text_color ) && ! empty( $custom_text_color ) && ( 'custom' === $text_color ) ) {
				$custom_style = 'style="color:' . $custom_text_color . '"';
			}

			if ( 'light' === $text_color ) {
				$class[] = 'text-light';
			}
			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}
			$class[] = 'text-' . str_replace( '_', '-', $text_size );

			$class = implode( ' ', $class );

			foreach ( $rotating_text as $single_text ) {
				$result[] = $single_text['text'];
			}

			$output .= '<h1 class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . ' ' . $custom_style . '>';
			$output .= '<span class="text-rotator" data-rotate-effect="' . $rotation_effect . '" data-rotate-speed="' . $rotate_speed . '000">';
			$output .= implode( ', ', $result );
			$output .= '</span>';
			$output .= '</h1>';


			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Rotating_Text' ) ) {
	$Crumina_Rotating_Text = new Crumina_Rotating_Text;
}
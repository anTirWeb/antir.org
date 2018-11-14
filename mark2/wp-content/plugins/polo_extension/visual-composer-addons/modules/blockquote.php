<?php
if ( ! class_exists( 'Crumina_Blockquote' ) ) {

	class Crumina_Blockquote {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crumina_blockquote_init' ) );
			add_shortcode( 'crumina_blockquote', array( &$this, 'crumina_blockquote_form' ) );
		}

		function crumina_blockquote_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/blockquote/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Blockquote", 'polo_extension' ),
						"base"                    => "crumina_blockquote",
						"icon"                    => "blockquote_icon",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'radio_image_select',
								'heading'    => esc_html__( 'Style', 'polo_extension' ),
								'options'    => array(
									'style_1' => $assets_dir . 'default.png',
									'style_2' => $assets_dir . 'reverse.png',
									'style_3' => $assets_dir . 'quoted.png',
									'style_4' => $assets_dir . 'simple.png',
									'style_5' => $assets_dir . 'colored.png',
									'style_6' => $assets_dir . 'dark.png',
									'custom'  => $assets_dir . 'custom.png',
								),
								'std'        => 'style_1',
								'param_name' => 'style',
							),
							array(
								'type'        => 'textarea_html',
								'heading'     => esc_html__( 'Content', 'polo_extension' ),
								'param_name'  => 'content',
								'description' => esc_html__( 'Alert content', 'polo_extension' ),
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Cite author', 'polo_extension' ),
								'param_name' => 'author',
							),
							array(
								"type"             => "colorpicker",
								"class"            => "",
								"heading"          => esc_html__( "Background Color", 'polo_extension' ),
								"param_name"       => "bg_color",
								"value"            => "",
								'dependency'       => array(
									'element' => 'style',
									'value'   => 'custom'
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "colorpicker",
								"class"            => "",
								"heading"          => esc_html__( "Text Color", 'polo_extension' ),
								"param_name"       => "text_color",
								"value"            => "",
								'dependency'       => array(
									'element' => 'style',
									'value'   => 'custom'
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

		function crumina_blockquote_form( $atts, $content = null ) {

			$output = $style = $author = $bg_color = $text_color = $el_class = $animation = $animation_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'style'           => 'style_1',
						'author'          => '',
						'bg_color'        => '',
						'text_color'      => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			$class = array();

			$module_style = $animation_data = $animation_data_delay = '';

			if ( 'style_2' === $style ) {
				$class[] = 'blockquote-reverse';
			} elseif ( 'style_3' === $style ) {
				$class[] = 'blockquote-fancy';
			} elseif ( 'style_4' === $style ) {
				$class[] = 'blockquote-simple';
			} elseif ( 'style_5' === $style ) {
				$class[] = 'blockquote-color text-light';
			} elseif ( 'style_6' === $style ) {
				$class[] = 'blockquote-dark text-light';
			} elseif ( 'custom' === $style ) {
				if ( isset( $bg_color ) && ! empty( $bg_color ) || isset( $text_color ) && ! empty( $text_color ) ) {
					$class[] = 'blockquote-color-custom';
					$module_style .= 'style="';
					if ( isset( $bg_color ) && ! empty( $bg_color ) ) {
						$module_style .= 'background-color:' . $bg_color . ';';
					}
					if ( isset( $text_color ) && ! empty( $text_color ) ) {
						$module_style .= 'color: ' . $text_color . ';';
					}
					$module_style .= '"';
				}
			}

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class = $el_class;
			}

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

			$class = implode( ' ', $class );

			$output .= '<blockquote class="' . $class . '" ' . $module_style . ' ' . $animation_data . ' ' . $animation_data_delay . '>';
			$output .= '<p>' . $content . '</p>';
			if ( isset( $author ) && ! empty( $author ) ) {
				$output .= '<small>' . esc_html__( 'by ', 'polo_extension' ) . '<cite>' . $author . '</cite></small>';
			}
			$output .= '</blockquote>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Blockquote' ) ) {
	$Crumina_Blockquote = new Crumina_Blockquote;
}
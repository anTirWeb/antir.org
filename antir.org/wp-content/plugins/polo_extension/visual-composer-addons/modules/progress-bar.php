<?php
if ( ! class_exists( 'Crumina_Progress_Bar' ) ) {

	class Crumina_Progress_Bar {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'progress_bar_init' ) );
			add_shortcode( 'crumina_progress_bar', array( &$this, 'progress_bar_form' ) );
		}

		function progress_bar_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Progress bar", 'polo_extension' ),
						"base"                    => "crumina_progress_bar",
						"icon"                    => "icon-wpb-graph",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'polo_extension' ),
								'param_name' => 'title',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Value', 'polo_extension' ),
								'param_name'       => 'value',
								'min'              => 0,
								'max'              => 100,
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Size', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Default', 'polo_extension' )     => 'default',
									esc_html__( 'Medium', 'polo_extension' )      => 'medium',
									esc_html__( 'Small', 'polo_extension' )       => 'small',
									esc_html__( 'Extra small', 'polo_extension' ) => 'extra_small',
								),
								'param_name'       => 'size',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Title position', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Inline', 'polo_extension' ) => 'inline',
									esc_html__( 'On top', 'polo_extension' ) => 'top',
								),
								'dependency' => array(
									'element' => 'size',
									'value'   => 'default'
								),
								'param_name' => 'title_position',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Animation delay', 'polo_extension' ),
								'value'            => array(
									'0'    => '0',
									'100'  => '100',
									'200'  => '200',
									'300'  => '300',
									'400'  => '400',
									'500'  => '500',
									'600'  => '600',
									'700'  => '700',
									'800'  => '800',
									'900'  => '900',
									'1000' => '1000',
									'1100' => '1100',
									'1200' => '1200',
									'1300' => '1300',
									'1400' => '1400',
									'1500' => '1500',
									'1600' => '1600',
									'1700' => '1700',
									'1800' => '1800',
									'1900' => '1900',
									'2000' => '2000',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'param_name'       => 'animation_delay',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Rounded bar", 'polo_extension' ),
								"param_name"       => "radius",
								"value"            => array(
									esc_html__( "Enable", 'polo_extension' )  => "1",
									esc_html__( "Disable", 'polo_extension' ) => "0",
								),
								'std'              => '0',
								"description"      => "",
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => esc_html__( "Style", 'polo_extension' ),
								"param_name"  => "style",
								"value"       => array(
									esc_html__( "Custom color", 'polo_extension' )  => "custom_color",
									esc_html__( "No background", 'polo_extension' ) => "no_bg",
									esc_html__( "Transparent", 'polo_extension' )   => "transparent",
								),
								'std'         => 'custom_color',
								"description" => "",
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Color', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Default', 'polo_extension' ) => 'default',
									'turquoise'                               => 'turquoise',
									'green sea'                               => 'green-sea',
									'emerald'                                 => 'emerald',
									'nephritis'                               => 'nephritis',
									'peter river'                             => 'peter-river',
									'belize hole'                             => 'belize-hole',
									'amethyst'                                => 'amethyst',
									'wisteria'                                => 'wisteria',
									'wet asphalt'                             => 'wet-asphalt',
									'midnight blue'                           => 'midnight-blue',
									'sun flower'                              => 'sun-flower',
									'orange'                                  => 'orange',
									esc_html__( 'Custom', 'polo_extension' )  => 'custom',
								),
								'dependency' => array(
									'element' => 'style',
									'value'   => 'custom_color'
								),
								'param_name' => 'color',
							),
							array(
								"type"       => "colorpicker",
								"class"      => "",
								"heading"    => esc_html__( "Custom Color", 'polo_extension' ),
								"param_name" => "pb_custom_color",
								"value"      => "",
								"dependency" => Array(
									"element" => "color",
									"value"   => array( "custom" )
								),
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

		function progress_bar_form( $atts, $content = null ) {

			$title = $value = $size = $title_position = $style = $radius = $color = $pb_custom_color = $el_class = $animation_delay = '';

			extract(
				shortcode_atts(
					array(
						'title'           => '',
						'value'           => '',
						'size'            => 'default',
						'title_position'  => 'inline',
						'style'           => 'custom_color',
						'radius'          => '0',
						'color'           => 'default',
						'pb_custom_color' => '',
						'el_class'        => '',
						'animation_delay' => '0',
					), $atts
				)
			);

			$output = $custom_style = $custom_style_small = '';

			$classes = array();

			if ( 'transparent' === $style ) {
				$classes[] = 'transparent';
			} elseif ( 'no_bg' === $style ) {
				$classes[] = 'no-bg';
				$classes[] = 'color';
			} else {
				if ( ! ( 'default' === $color ) ) {
					$classes[] = 'color-' . $color;
				} else {
					$classes[] = 'color';
				}
			}

			if ( 'default' === $size && 'top' === $title_position || ! ( 'default' === $size ) ) {
				$classes[] = 'title-up';
			}

			if ( ! ( 'default' === $size ) ) {
				if ( ! ( 'extra_small' === $size ) ) {
					$classes[] = $size;
				} else {
					$classes[] = 'small extra-small';
				}
			}

			if ( '1' === $radius ) {
				$classes[] = 'radius';
			}

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$classes[] = $el_class;
			}

			if ( 'custom' === $color ) {
				if ( 'default' === $size ) {
					$custom_style .= 'style="';
					$custom_style .= 'border-color: ' . $pb_custom_color . ';';
					$custom_style .= 'background: ' . $pb_custom_color . '';
					$custom_style .= '"';
				} else {
					$custom_style_small .= 'style="';
					$custom_style_small .= 'border-color: ' . $pb_custom_color . ';';
					$custom_style_small .= 'background: ' . $pb_custom_color . '';
					$custom_style_small .= '"';
				}
			}

			$classes = implode( ' ', $classes );

			$output .= '<div class="progress-bar-container ' . $classes . '" ' . $custom_style . '>';
			$output .= '<div class="progress-bar " data-percent = "' . $value . '" data-delay = "' . $animation_delay . '" data-type = "%" '.$custom_style_small.'>';
			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<div class="progress-title" >' . $title . '</div >';
			}
			$output .= '</div >';
			$output .= '</div >';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Progress_Bar' ) ) {
	$Crumina_Progress_Bar = new Crumina_Progress_Bar;
}
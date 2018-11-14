<?php
if ( ! class_exists( 'Crumina_Button' ) ) {

	class Crumina_Button {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crumins_button_init' ) );
			add_shortcode( 'crumina_button', array( &$this, 'crumina_button_form' ) );
		}

		function crumins_button_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Button", 'polo_extension' ),
						"base"                    => "crumina_button",
						"icon"                    => "icon-wpb-ui-button",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Button size', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Normal', 'polo_extension' ) => 'default',
										esc_html__( 'Small', 'polo_extension' )  => 'small',
										esc_html__( 'Large', 'polo_extension' )  => 'large',
									),
									'admin_label'      => true,
									'param_name'       => 'button_size',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Button type', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Default', 'polo_extension' )     => 'default',
										esc_html__( '3D', 'polo_extension' )          => '3d',
										esc_html__( 'Bordered', 'polo_extension' )    => 'bordered',
										esc_html__( 'Transparent', 'polo_extension' ) => 'transparent',
									),
									'admin_label'      => true,
									'param_name'       => 'button_type',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Button style', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Default', 'polo_extension' )          => 'default',
										esc_html__( 'Rounded', 'polo_extension' )          => 'rounded',
										esc_html__( 'Full Rounded', 'polo_extension' )     => 'full_rounded',
										esc_html__( 'Animated', 'polo_extension' )         => 'animated',
										esc_html__( 'Rounded+animated', 'polo_extension' ) => 'animated_rounded',
									),
									'admin_label'      => true,
									'param_name'       => 'button_style',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Button align', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Left', 'polo_extension' )   => 'left',
										esc_html__( 'Right', 'polo_extension' )  => 'right',
										esc_html__( 'Center', 'polo_extension' ) => 'center',
										esc_html__( 'Inline', 'polo_extension' ) => 'inline',
									),
									'admin_label'      => true,
									'param_name'       => 'button_align',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
							),
							crum_do_vc_map_icon(),
							array(
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Icon position', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Left', 'polo_extension' )  => 'left',
										esc_html__( 'Right', 'polo_extension' ) => 'right',
									),
									'admin_label' => true,
									'param_name'  => 'icon_align',
									'dependency'  => array(
										'element'            => 'button_style',
										'value_not_equal_to' => array( 'animated', 'animated_rounded' )
									)
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Icon position', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Left', 'polo_extension' )   => 'left',
										esc_html__( 'Right', 'polo_extension' )  => 'right',
										esc_html__( 'Top', 'polo_extension' )    => 'top',
										esc_html__( 'Bottom', 'polo_extension' ) => 'bottom',
									),
									'admin_label' => true,
									'param_name'  => 'icon_align_animated',
									'dependency'  => array(
										'element' => 'button_style',
										'value'   => array( 'animated', 'animated_rounded' )
									)
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Animated style', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Default', 'polo_extension' ) => 'default',
										esc_html__( 'Fill', 'polo_extension' )    => 'fill',
									),
									'admin_label' => true,
									'param_name'  => 'animated_style',
									'dependency'  => array(
										'element' => 'button_style',
										'value'   => array( 'animated', 'animated_rounded' )
									)
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Fill style', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Default', 'polo_extension' )    => 'default',
										esc_html__( 'Horizontal', 'polo_extension' ) => 'horizontal',
										esc_html__( 'Vertical', 'polo_extension' )   => 'vertical',
									),
									'admin_label' => true,
									'param_name'  => 'fill_style',
									'dependency'  => array( 'element' => 'animated_style', 'value' => 'fill' )
								),
								array(
									"type"        => "vc_link",
									"class"       => "",
									"heading"     => esc_html__( "Button link ", 'polo_extension' ),
									"param_name"  => "button_link",
									"value"       => "",
									'group'       => esc_html__( 'Attributes', 'polo_extension' ),
									"description" => esc_html__( "You can link or remove the existing link on the button from here.", 'polo_extension' ),
								),
								array(
									"type"        => "textfield",
									"class"       => "",
									"heading"     => esc_html__( "Button text", 'polo_extension' ),
									"param_name"  => "button_text",
									"admin_label" => false,
									"value"       => "",
									'group'       => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Color", 'polo_extension' ),
									"param_name"       => "button_color",
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
									"value"            => array(
										esc_html__( 'None', 'polo_extension' )           => '',
										esc_html__( 'Aqua', 'polo_extension' )           => 'aqua',
										esc_html__( 'Colored', 'polo_extension' )        => 'color',
										esc_html__( 'Blue default', 'polo_extension' )   => 'blue',
										esc_html__( 'Blue dark', 'polo_extension' )      => 'blue-dark',
										esc_html__( 'Shark', 'polo_extension' )          => 'shark',
										esc_html__( 'Purple light', 'polo_extension' )   => 'purple-light',
										esc_html__( 'Purple default', 'polo_extension' ) => 'purple',
										esc_html__( 'Purple dark', 'polo_extension' )    => 'purple-dark',
										esc_html__( 'Red dark', 'polo_extension' )       => 'red-dark',
										esc_html__( 'Red default', 'polo_extension' )    => 'red',
										esc_html__( 'Red light', 'polo_extension' )      => 'red-light',
										esc_html__( 'Pink dark', 'polo_extension' )      => 'pink-dark',
										esc_html__( 'Pink default', 'polo_extension' )   => 'pink',
										esc_html__( 'Orange dark', 'polo_extension' )    => 'orange-dark',
										esc_html__( 'Orange default', 'polo_extension' ) => 'orange',
										esc_html__( 'Amber', 'polo_extension' )          => 'amber',
										esc_html__( 'Green', 'polo_extension' )          => 'green',
										esc_html__( 'Orange light', 'polo_extension' )   => 'orange-light',
										esc_html__( 'Yellow', 'polo_extension' )         => 'yellow',
										esc_html__( 'Brown default', 'polo_extension' )  => 'brown',
										esc_html__( 'Brown light', 'polo_extension' )    => 'brown-light',
										esc_html__( 'Black default', 'polo_extension' )  => 'black',
										esc_html__( 'Black light', 'polo_extension' )    => 'black-light',
										esc_html__( 'Grey dark', 'polo_extension' )      => 'grey-dark',
										esc_html__( 'Custom', 'polo_extension' )         => 'custom',
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array(
										'element'            => 'button_type',
										'value_not_equal_to' => 'transparent'
									)
								),
								array(
									"type"             => "checkbox",
									"class"            => "",
									"heading"          => esc_html__( "Fullwidth button", 'polo_extension' ),
									"param_name"       => "button_fullwidth",
									"value"            => array(
										esc_html__( "Enable", 'polo_extension' ) => "1",
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Background Color", 'polo_extension' ),
									"param_name"       => "button_bg_color",
									"value"            => "",
									"dependency"       => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Text Color", 'polo_extension' ),
									"param_name"       => "button_text_color",
									"value"            => "",
									"dependency"       => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Border Color", 'polo_extension' ),
									"param_name"       => "button_border_color",
									"value"            => "",
									"dependency"       => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Border width', 'polo_extension' ),
									'param_name'       => 'border_width',
									'min'              => 0,
									"dependency"       => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'group'            => esc_html__( 'Attributes', 'polo_extension' ),
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
									'group'       => esc_html__( 'Attributes', 'polo_extension' ),
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
					)
				);
			}

		}

		function crumina_button_form( $atts, $content = null ) {

			$button_size = $button_type = $button_align = $button_style = $animated_style = $fill_style = $icon_align = $icon_align_animated = '';
			$button_link = $button_text = $button_color = $button_bg_color = $button_text_color = $button_border_color = $border_width = $button_fullwidth = $el_class = $animation = $animation_delay = '';
			$icon_type   = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom = '';

			$output = $icon = $custom_style = $animation_data = $animation_data_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'button_size'         => 'default',
						'button_type'         => 'default',
						'button_style'        => 'default',
						'button_align'        => 'left',
						'icon_type'           => '',
						'icon_fontawesome'    => 'fa fa-adjust',
						'icon_openiconic'     => 'vc-oi vc-oi-dial',
						'icon_typicons'       => 'typcn typcn-adjust-brightness',
						'icon_entypo'         => 'entypo-icon entypo-icon-note',
						'icon_linecons'       => 'vc_li vc_li-heart',
						'icon_custom_icon'    => '',
						'animated_style'      => 'default',
						'fill_style'          => 'default',
						'icon_align'          => 'left',
						'icon_align_animated' => 'left',
						'button_link'         => '',
						'button_text'         => '',
						'button_color'        => '',
						'button_bg_color'     => '',
						'button_text_color'   => '',
						'button_border_color' => '',
						'border_width'        => '',
						'button_fullwidth'    => '',
						'el_class'            => '',
						'animation'           => '',
						'animation_delay'     => '0',
						'custom_delay'        => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_build_link' ) ) {
				$href = vc_build_link( $button_link );
			}
			$link = isset( $href['url'] ) && ! empty( $href['url'] ) ? $href['url'] : '#';
			$target = isset( $href['target'] ) && ! empty( $href['target'] ) ? $href['target'] : '_self';

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
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

			$class   = array();
			$class[] = 'button';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'small' === $button_size ) {
				$class[] = 'small';
			} elseif ( 'large' === $button_size ) {
				$class[] = 'large';
			}

			if ( '1' === $button_fullwidth ) {
				$class[] = 'fullwidth';
			}

			if ( '3d' === $button_type ) {
				$class[] = 'button-3d';
			} elseif ( 'bordered' === $button_type ) {
				$class[] = 'border';
			} elseif ( 'transparent' === $button_type ) {
				$class[] = 'transparent';
			}

			if ( 'rounded' === $button_style ) {
				$class[] = 'rounded';
			} elseif ( 'full_rounded' === $button_style ) {
				$class[] = 'full-rounded';
			} elseif ( 'animated' === $button_style || 'animated_rounded' === $button_style ) {

				$class[] = 'effect';

				if ( 'animated_rounded' === $button_style ) {
					$class[] = 'rounded';
				}

				if ( 'fill' === $animated_style ) {

					if ( 'horizontal' === $fill_style ) {
						$class[] = 'fill-horizontal';
					} elseif ( 'vertical' === $fill_style ) {
						$class[] = 'fill-vertical';
					} else {
						$class[] = 'fill';
					}

				}
				if ( ! empty( $icon ) ) {
					if ( 'right' === $icon_align_animated ) {
						$class[] = 'icon-right';
					} elseif ( 'top' === $icon_align_animated ) {
						$class[] = 'icon-top';
					} elseif ( 'bottom' === $icon_align_animated ) {
						$class[] = 'icon-bottom';
					} else {
						$class[] = 'icon-left';
					}
				}
			}

			if ( ! empty( $icon ) && ! ( 'animated' === $button_style ) ) {
				if ( 'left' === $icon_align ) {
					$class[] = 'icon-left';
				} else {
					$class[] = 'icon-right';
				}
			}

			if ( isset( $button_color ) && ! empty( $button_color ) && ! ( 'transparent' === $button_type ) ) {
				$class[] = $button_color;
			}


			if ( 'custom' === $button_color ) {

				$custom_style .= 'style="';

				if ( isset( $border_width ) && ! empty( $border_width ) ) {

					$custom_style .= 'border-width:' . $border_width . 'px;';

				} elseif ( empty( $border_width ) && 'default' === $button_type && ! empty( $button_bg_color ) ) {
					$custom_style .= 'border:none;';
				}

				if ( isset( $button_border_color ) && ! empty( $button_border_color ) ) {
					if ( '3d' === $button_type && function_exists( 'adjustBrightness' ) ) {
						$custom_style .= 'border-color: ' . adjustBrightness( $button_border_color, - 30 ) . ';';
					} else {
						$custom_style .= 'border-color:' . $button_border_color . ';';
					}
				}

				if ( isset( $button_bg_color ) && ! empty( $button_bg_color ) ) {
					$custom_style .= 'background-color:' . $button_bg_color . ';';
				}
				if ( isset( $button_text_color ) && ! empty( $button_text_color ) ) {
					$custom_style .= 'color:' . $button_text_color . ';';
				}

				$custom_style .= '"';

			}

			$class = implode( ' ', $class );

			if ( ! ( 'left' === $button_align ) ) {
				$output .= '<div class="text-' . $button_align . '">';
			}

			$output .= '<a class="' . $class . '" href="' . $link . '" target="' . $target . '" ' . $custom_style . ' ' . $animation_data . $animation_data_delay . '>';
			$output .= '<span>';
			if ( ! empty( $icon ) && ! ( 'right' === $icon_align ) ) {
				$output .= $icon;
			}
			$output .= $button_text;
			if ( ! empty( $icon ) && ! ( 'animated' === $button_style ) && 'right' === $icon_align ) {
				$output .= $icon;
			}
			$output .= '</span>';
			$output .= '</a>';

			if ( ! ( 'left' === $button_align ) ) {
				$output .= '</div>';
			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Button' ) ) {
	$Crumina_Button = new Crumina_Button;
}
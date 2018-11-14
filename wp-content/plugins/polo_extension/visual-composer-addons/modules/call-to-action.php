<?php
if ( ! class_exists( 'Crumina_CTA' ) ) {

	class Crumina_CTA {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'cta_init' ) );
			add_shortcode( 'crum_cta', array( &$this, 'cta_form' ) );
		}

		function cta_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/call-to-action/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Call to action", 'polo_extension' ),
						"base"                    => "crum_cta",
						"icon"                    => "icon-wpb-call-to-action",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'heading'     => esc_html__( 'Layout', 'polo_extension' ),
									'description' => '',
									'type'        => 'radio_image_select',
									'param_name'  => 'layout',
									'options'     => array(
										'left'   => $assets_dir . 'button-right.png',
										'center' => $assets_dir . 'button-center.png',
										'right'  => $assets_dir . 'button-left.png',
									),
									'std'         => 'default',
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Style', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Default', 'polo_extension' )      => 'default',
										esc_html__( 'Bordered', 'polo_extension' )     => 'bordered',
										esc_html__( 'Colored', 'polo_extension' )      => 'colored',
										esc_html__( 'Dark', 'polo_extension' )         => 'dark',
										esc_html__( 'With pattern', 'polo_extension' ) => 'pattern',
									),
									'admin_label' => true,
									'param_name'  => 'style',
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Pattern', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Pattern', 'polo_extension' ) . ' 1' => 'background-pattern',
										esc_html__( 'Pattern', 'polo_extension' ) . ' 2' => 'background-pattern-1',
										esc_html__( 'Pattern', 'polo_extension' ) . ' 3' => 'background-pattern-2',
										esc_html__( 'Pattern', 'polo_extension' ) . ' 4' => 'background-pattern-3',
										esc_html__( 'Custom', 'polo_extension' )         => 'custom',

									),
									"dependency"  => Array(
										"element" => "style",
										"value"   => 'pattern'
									),
									'admin_label' => true,
									'param_name'  => 'pattern',
								),
								array(
									'type'             => 'attach_image',
									'heading'          => esc_html__( 'Pattern image', 'polo_extension' ),
									'param_name'       => 'pattern_image',
									'value'            => '',
									"dependency"       => Array(
										"element" => "pattern",
										"value"   => 'custom'
									),
									'description'      => esc_html__( 'Select image from media library.', 'polo_extension' ),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "CTA Color", 'polo_extension' ),
									"param_name"       => "cta_color",
									"value"            => "",
									"dependency"       => Array(
										"element" => "pattern",
										"value"   => array( "custom" )
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Size', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Default', 'polo_extension' ) => 'default',
										esc_html__( 'Small', 'polo_extension' )   => 'small',
										esc_html__( 'Large', 'polo_extension' )   => 'large',
									),
									'admin_label'      => true,
									'param_name'       => 'size',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Full width", 'polo_extension' ),
									"param_name"       => "full_width",
									"value"            => array(
										esc_html__( 'Disable', 'polo_extension' ) => '0',
										esc_html__( 'Enable', 'polo_extension' )  => '1',
									),
									'dependency'       => array(
										'element' => 'size',
										'value'   => 'default',
									),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Border radius", 'polo_extension' ),
									"param_name"       => "border_radius",
									"value"            => array(
										esc_html__( 'Enable', 'polo_extension' ) => '0',
										esc_html__( 'Disable', 'polo_extension' )  => '1',
									),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Title', 'polo_extension' ),
									'param_name' => 'title',
								),
								array(
									'type'       => 'textarea',
									'heading'    => esc_html__( 'Description', 'polo_extension' ),
									'param_name' => 'description',
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),
							),
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
									'group'            => esc_html__( 'Button', 'polo_extension' ),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
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
									'group'            => esc_html__( 'Button', 'polo_extension' ),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Button style', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Default', 'polo_extension' )      => 'default',
										esc_html__( 'Rounded', 'polo_extension' )      => 'rounded',
										esc_html__( 'Full Rounded', 'polo_extension' ) => 'full_rounded',
										esc_html__( 'Animated', 'polo_extension' )     => 'animated',
										esc_html__( 'Rounded+animated', 'polo_extension' ) => 'animated_rounded',
									),
									'admin_label'      => true,
									'param_name'       => 'button_style',
									'group'            => esc_html__( 'Button', 'polo_extension' ),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
							),
							crum_do_vc_map_icon( esc_html__( 'Button', 'polo_extension' ) ),
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
									'group'       => esc_html__( 'Button', 'polo_extension' ),
									'dependency'  => array(
										'element'            => 'button_style',
										'value_not_equal_to' => 'animated'
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
									'group'       => esc_html__( 'Button', 'polo_extension' ),
									'dependency'  => array( 'element' => 'button_style', 'value' => 'animated' )
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
									'group'       => esc_html__( 'Button', 'polo_extension' ),
									'dependency'  => array( 'element' => 'button_style', 'value' => 'animated' )
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
									'group'       => esc_html__( 'Button', 'polo_extension' ),
									'dependency'  => array( 'element' => 'animated_style', 'value' => 'fill' )
								),
								array(
									"type"        => "vc_link",
									"class"       => "",
									"heading"     => esc_html__( "Button link ", 'polo_extension' ),
									"param_name"  => "button_link",
									"value"       => "",
									'group'       => esc_html__( 'Button', 'polo_extension' ),
									"description" => esc_html__( "You can link or remove the existing link on the button from here.", 'polo_extension' ),
								),
								array(
									"type"        => "textfield",
									"class"       => "",
									"heading"     => esc_html__( "Button text", 'polo_extension' ),
									"param_name"  => "button_text",
									"admin_label" => false,
									"value"       => "",
									'group'       => esc_html__( 'Button', 'polo_extension' ),
								),
								array(
									"type"       => "dropdown",
									"class"      => "",
									"heading"    => esc_html__( "Color", 'polo_extension' ),
									"param_name" => "button_color",
									'group'      => esc_html__( 'Button', 'polo_extension' ),
									"value"      => array(
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
									'dependency' => array(
										'element'            => 'button_type',
										'value_not_equal_to' => 'transparent'
									)
								),
								array(
									"type"       => "colorpicker",
									"class"      => "",
									"heading"    => esc_html__( "Background Color", 'polo_extension' ),
									"param_name" => "button_bg_color",
									"value"      => "",
									"dependency" => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'group'      => esc_html__( 'Button', 'polo_extension' ),
								),
								array(
									"type"       => "colorpicker",
									"class"      => "",
									"heading"    => esc_html__( "Text Color", 'polo_extension' ),
									"param_name" => "button_text_color",
									"value"      => "",
									"dependency" => Array(
										"element" => "button_color",
										"value"   => array( "custom" )
									),
									'group'      => esc_html__( 'Button', 'polo_extension' ),
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Animation', 'polo_extension' ),
									'value'       => array_flip( crum_vc_animations() ),
									'admin_label' => true,
									'param_name'  => 'animation',
									'group'       => esc_html__( 'Animation', 'polo_extension' ),
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

		function cta_form( $atts, $content = null ) {

			$layout      = $style = $size = $full_width = $border_radius = $title = $description = $pattern = $pattern_image = $cta_color = $animation = $animation_delay = $el_class = $custom_delay = '';
			$button_size = $button_type = $button_style = $icon_align = $icon_align_animated = $animated_style = $fill_style = $button_link = $button_text = $button_color = $button_bg_color = $button_text_color = '';
			$icon_type   = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';

			extract(
				shortcode_atts(
					array(
						'layout'              => 'left',
						'style'               => 'default',
						'size'                => 'default',
						'full_width'          => '0',
						'border_radius'          => '0',
						'title'               => '',
						'description'         => '',
						'pattern'             => 'background-pattern',
						'pattern_image'       => '',
						'cta_color'           => '',
						'button_size'         => 'default',
						'button_type'         => 'default',
						'button_style'        => 'default',
						'icon_align'          => 'left',
						'icon_align_animated' => 'left',
						'animated_style'      => 'default',
						'fill_style'          => 'default',
						'button_link'         => '',
						'button_text'         => '',
						'button_color'        => '',
						'button_bg_color'     => '',
						'button_text_color'   => '',
						'icon_type'           => '',
						'icon_fontawesome'    => 'fa fa-adjust',
						'icon_openiconic'     => 'vc-oi vc-oi-dial',
						'icon_typicons'       => 'typcn typcn-adjust-brightness',
						'icon_entypo'         => 'entypo-icon entypo-icon-note',
						'icon_linecons'       => 'vc_li vc_li-heart',
						'icon_custom_icon'    => '',
						'animation'           => '',
						'animation_delay'     => '0',
						'custom_delay'        => '',
						'el_class'            => '',
					), $atts
				)
			);

			$output = $animation_data = $animation_data_delay = $pattern_style = '';

			$class = array();

			$class[] = 'jumbotron';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'center' === $layout ) {
				$class[] = 'jumbotron-center';
			} elseif ( 'right' === $layout ) {
				$class[] = 'jumbotron-right';
			}

			if ( 'bordered' === $style ) {
				$class[] = 'jumbotron-border';
			} elseif ( 'colored' === $style ) {
				$class[] = 'background-colored text-light';
			} elseif ( 'dark' === $style ) {
				$class[] = 'background-dark text-light';
			} elseif ( 'pattern' === $style ) {
				if ( ! ( 'custom' === $pattern ) ) {
					$class[] = $pattern;
				} else {
					$class[] = 'pattern-custom';
					$pattern_style .= 'style="';
					if ( isset( $pattern_image ) && ! empty( $pattern_image ) ) {
						$image_url = wp_get_attachment_image_src( $pattern_image, 'full' );
						$pattern_style .= 'background-image:url(' . $image_url[0] . ');';
					}
					if ( isset( $cta_color ) && ! empty( $cta_color ) ) {
						$pattern_style .= 'color:' . $cta_color . ';';
					}
					$pattern_style .= '"';
				}
			}

			if ( 'small' === $size ) {
				$class[] = 'jumbotron-small';
			} elseif ( 'large' === $size ) {
				$class[] = 'jumbotron-large';
			}

			if ( '1' === $full_width ) {
				$class[] = 'jumbotron-fullwidth';
			}

			if('1' === $border_radius){
				$class[] = 'jumbotron-no-border-radius';
			}

			$class = implode( ' ', $class );

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

			$button_atts = array(
				'button_size'         => $button_size,
				'button_type'         => $button_type,
				'button_style'        => $button_style,
				'icon_type'           => $icon_type,
				'icon_fontawesome'    => $icon_fontawesome,
				'icon_openiconic'     => $icon_openiconic,
				'icon_typicons'       => $icon_typicons,
				'icon_entypo'         => $icon_entypo,
				'icon_linecons'       => $icon_linecons,
				'icon_custom_icon'    => $icon_custom_icon,
				'icon_align'          => $icon_align,
				'icon_align_animated' => $icon_align_animated,
				'animated_style'      => $animated_style,
				'fill_style'          => $fill_style,
				'button_link'         => $button_link,
				'button_text'         => $button_text,
				'button_color'        => $button_color,
				'button_bg_color'     => $button_bg_color,
				'button_text_color'   => $button_text_color,
			);

			$button = do_shortcode( polo_do_button_shortcode( $button_atts ) );

			$output .= '<div class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . ' ' . $pattern_style . '>';

			if ( '1' === $full_width ) {
				$output .= '<div class="container">';
			}

			if ( isset( $title ) && ! empty( $title ) ) {
				if ( 'large' === $size ) {
					$output .= '<h1>' . $title . '</h1>';
				} else {
					$output .= '<h3>' . $title . '</h3>';
				}
			}

			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= wpautop( $description );
			}

			$output .= $button;

			if ( '1' === $full_width ) {
				$output .= '</div>';
			}

			$output .= '</div>';//.$class

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_CTA' ) ) {
	$Crumina_CTA = new Crumina_CTA;
}
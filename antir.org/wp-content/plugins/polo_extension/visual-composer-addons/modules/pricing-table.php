<?php
if ( ! class_exists( 'Crumina_Pricing_Table' ) ) {

	class Crumina_Pricing_Table {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'table_init' ) );
			add_shortcode( 'crumina_pricing_table', array( &$this, 'table_form' ) );
			add_shortcode( 'crumina_pricing_table_wrap', array( &$this, 'table_wrap_form' ) );
		}

		function table_init() {

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"                    => esc_html__( "Polo Pricing Table", 'polo_extension' ),
						"base"                    => "crumina_pricing_table_wrap",
						"icon"                    => "pricing-tables",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"as_parent"               => array( 'only' => 'crumina_pricing_table' ),
						"js_view"                 => 'VcColumnView',
						"params"                  => array(
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Columns number', 'polo_extension' ),
								'value'            => array(
									'2 ' . esc_html__( 'columns', 'polo_extension' ) => '2',
									'3 ' . esc_html__( 'columns', 'polo_extension' ) => '3',
									'4 ' . esc_html__( 'columns', 'polo_extension' ) => '4',
									'5 ' . esc_html__( 'columns', 'polo_extension' ) => '5',
								),
								'admin_label'      => true,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'param_name'       => 'columns_number',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Margin between columns", 'polo_extension' ),
								"param_name"       => "margin",
								"value"            => array(
									esc_html__( 'Disable', 'polo_extension' ) => '0',
									esc_html__( 'Enable', 'polo_extension' )  => '1',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Colored", 'polo_extension' ),
								"param_name"       => "colored",
								"value"            => array(
									esc_html__( 'Disable', 'polo_extension' ) => '0',
									esc_html__( 'Enable', 'polo_extension' )  => '1',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Transparent", 'polo_extension' ),
								"param_name"       => "transparent",
								"value"            => array(
									esc_html__( 'Disable', 'polo_extension' ) => '0',
									esc_html__( 'Enable', 'polo_extension' )  => '1',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Animation', 'polo_extension' ),
								'value'       => array_flip( crum_vc_animations() ),
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
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
								'param_name'  => 'el_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
							),
						)
					)
				);

				vc_map(
					array(
						"name"                    => esc_html__( "Pricing Table column", 'polo_extension' ),
						"base"                    => "crumina_pricing_table",
						"icon"                    => "",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"as_child"                => array( 'only' => 'crumina_pricing_table_wrap' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Title', 'polo_extension' ),
									'param_name' => 'title',
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Description', 'polo_extension' ),
									'param_name' => 'description',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Currency  symbol', 'polo_extension' ),
									'param_name'       => 'currency_symbol',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Price', 'polo_extension' ),
									'param_name'       => 'price',
									'min'              => 0,
									'std'              => 50,
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Time interval', 'polo_extension' ),
									'param_name'       => 'time_interval',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'       => 'param_group',
									'heading'    => esc_html__( 'Table fields', 'polo_extension' ),
									'param_name' => 'table_fields',
									'params'     => array_merge(
										array(
											array(
												'type'       => 'textfield',
												'heading'    => esc_html__( 'Title', 'polo_extension' ),
												'param_name' => 'title',
											)
										),
										crum_do_vc_map_icon()
									),
									'callbacks'  => array(
										'after_add' => 'vcChartParamAfterAddCallback',
									),
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Featured text', 'polo_extension' ),
									'param_name' => 'featured_text',
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Featured", 'polo_extension' ),
									"param_name"       => "featured",
									"value"            => array(
										esc_html__( 'Disable', 'polo_extension' ) => '0',
										esc_html__( 'Enable', 'polo_extension' )  => '1',
									),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
							), array_merge(
								array(
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
										'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
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
										'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
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
								)
							)

						)
					)
				);
			}

		}

		function table_wrap_form( $atts, $content = null ) {

			$columns_number = $margin = $transparent = $colored = $animation = $animation_delay = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'columns_number'  => '3',
						'margin'          => '0',
						'transparent'     => '0',
						'colored'         => '0',
						'animation'       => '',
						'animation_delay' => '',
						'el_class'        => '',
					), $atts
				)
			);

			$class = array();

			$class[] = 'pricing-table';

			if ( '0' === $margin ) {
				$class[] = 'col-no-margin';
			}

			if ( '1' === $transparent ) {
				$class[] = 'transparent';
			}

			if ( '1' === $colored ) {
				$class[] = 'colored';
			}

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			switch ( $columns_number ) {
				case '2':
					$width = '6';
					break;
				case '3':
					$width = '4';
					break;
				case '4':
					$width = '3';
					break;
				case '5':
					$width = '2';
					break;
				default:
					$width = '3';
			}

			$class = implode( ' ', $class );

			$pattern = get_shortcode_regex();
			preg_match_all( '/' . $pattern . '/s', $content, $matches );

			$output = '';

			$output .= '<div class="' . $class . '">';

			if ( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
				foreach ( $matches[0] as $single_column ) {

					$output .= '<div class="col-md-' . $width . ' col-sm-12 col-xs-12">';

					if ( isset( $animation ) && ! empty( $animation ) ) {
						$single_column = str_replace( 'crumina_pricing_table', 'crumina_pricing_table animation="' . $animation . '" animation_delay="' . $animation_delay . '"', $single_column );
						$output .= do_shortcode( $single_column );
					} else {
						$output .= do_shortcode( $single_column );
					}

					$output .= '</div>';//.col

				}
			}

			$output .= '</div>';//.pricing-table

			return $output;

		}

		function table_form( $atts, $content = null ) {

			$title       = $description = $currency_symbol = $price = $time_interval = $table_fields = $featured_text = $featured = $custom_delay = '';
			$button_type = $button_style = $icon_align = $icon_align_animated = $animated_style = $fill_style = $button_link = $button_text = $button_color = $button_bg_color = $button_text_color = '';
			$icon_type   = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = '';
			$animation   = $animation_delay = '';


			extract(
				shortcode_atts(
					array(
						'title'               => '',
						'description'         => '',
						'currency_symbol'     => '',
						'price'               => '',
						'time_interval'       => '',
						'table_fields'        => '',
						'featured_text'       => '',
						'featured'            => '0',
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
						'animation'           => '',
						'animation_delay'     => '0',
						'custom_delay'        => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$table_fields = (array) vc_param_group_parse_atts( $table_fields );
			}

			$output = $icon = $button = $animation_data = $animation_data_delay = '';

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

			$class = array();

			$class[] = 'plan';

			if ( '1' === $featured ) {
				$class[] = 'featured';
			}

			$class = implode( ' ', $class );

			$button_atts = array(
				'button_type'         => $button_type,
				'button_style'        => $button_style,
				'icon_type'           => $icon_type,
				'icon_fontawesome'    => $icon_fontawesome,
				'icon_openiconic'     => $icon_openiconic,
				'icon_typicons'       => $icon_typicons,
				'icon_entypo'         => $icon_entypo,
				'icon_linecons'       => $icon_linecons,
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

			$output .= '<div class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			$output .= '<div class="plan-header">';

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h4>' . $title . '</h4>';
			}

			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<p class="text-muted">' . $description . '</p>';
			}

			if ( isset( $price ) && ! empty( $price ) ) {
				$output .= '<div class="plan-price">';
				if ( isset( $currency_symbol ) && ! empty( $currency_symbol ) ) {
					$output .= '<sup>' . $currency_symbol . '</sup>';
				}
				$output .= $price;
				if ( isset( $time_interval ) && ! empty( $time_interval ) ) {
					$output .= '<span>' . $time_interval . '</span>';
				}
				$output .= '</div>';//.plan-price
			}

			$output .= $button;

			$output .= '</div>';//.plan-header

			$output .= '<div class="plan-list">';
			$output .= '<ul>';

			foreach ( $table_fields as $single_field ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $single_field['icon_type'] ) ) {
					vc_icon_element_fonts_enqueue( $single_field['icon_type'] );
				}
				if ( isset( $single_field['icon_type'] ) && ! empty( $single_field['icon_type'] ) ) {
					$icon = '<i class="' . $single_field[ 'icon_' . $single_field['icon_type'] ] . '" ></i>';
				}
				$output .= '<li>' . $icon . ' ' . $single_field['title'] . '</li>';
			}

			if ( isset( $featured_text ) && ! empty( $featured_text ) ) {
				$output .= '<li class="plan-featured-item text-center">' . $featured_text . '</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';//.plan-list

			$output .= '</div>';//.plan

			return $output;

		}

	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Crumina_Pricing_Table_Wrap extends WPBakeryShortCodesContainer {
	}

}

if ( class_exists( 'Crumina_Pricing_Table' ) ) {
	$Crumina_Pricing_Table = new Crumina_Pricing_Table;
}
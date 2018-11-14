<?php
if ( ! class_exists( 'Crumina_Counter' ) ) {

	class Crumina_Counter {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_counter_init' ) );
			add_shortcode( 'crumina_counter', array( &$this, 'crum_counter_form' ) );
		}

		function crum_counter_init() {

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"                    => esc_html__( "Polo Counter", 'polo_extension' ),
						"base"                    => "crumina_counter",
						"icon"                    => "counter",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Counter start number', 'polo_extension' ),
									'param_name'       => 'counter_start',
									'min'              => 0,
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Counter end number', 'polo_extension' ),
									'param_name'       => 'counter_end',
									'min'              => 0,
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Counter speed in seconds', 'polo_extension' ),
									'param_name'       => 'counter_speed',
									'min'              => 0,
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Counter Color", 'polo_extension' ),
									"param_name"       => "counter_color",
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Description Color", 'polo_extension' ),
									"param_name"       => "description_color",
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Size', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Normal', 'polo_extension' )      => 'default',
										esc_html__( 'Small', 'polo_extension' )       => 'small',
										esc_html__( 'Large', 'polo_extension' )       => 'large',
										esc_html__( 'Extra Large', 'polo_extension' ) => 'text_large',
									),
									'admin_label'      => true,
									'param_name'       => 'size',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Separator before description', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Disable', 'polo_extension' ) => 'disable',
										esc_html__( 'Enable', 'polo_extension' )  => 'enable',
									),
									'param_name'       => 'desc_separator',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									"type"       => "textfield",
									"class"      => "",
									"heading"    => esc_html__( "Description", 'polo_extension' ),
									"param_name" => "description",
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),
							),
							crum_do_vc_map_icon( esc_html__( 'Icon', 'polo_extension' ) ),
							array(
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Icon Color", 'polo_extension' ),
									"param_name"       => "icon_color",
									'group'            => esc_html__( 'Icon', 'polo_extension' ),
									'dependency'       => array(
										'element'   => 'icon_type',
										'not_empty' => true,
									),
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Icon position', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Left', 'polo_extension' )       => 'left',
										esc_html__( 'Top', 'polo_extension' )        => 'top',
										esc_html__( 'Background', 'polo_extension' ) => 'background',
									),
									'dependency'       => array(
										'element'   => 'icon_type',
										'not_empty' => true,
									),
									'group'            => esc_html__( 'Icon', 'polo_extension' ),
									'param_name'       => 'icon_position',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Icon circle border', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'None', 'polo_extension' )      => '',
										esc_html__( 'Permanent', 'polo_extension' ) => 'permanent',
										esc_html__( 'On hover', 'polo_extension' )  => 'hover',
									),
									'dependency'       => array(
										'element'            => 'icon_position',
										'value_not_equal_to' => 'background',
									),
									'group'            => esc_html__( 'Icon', 'polo_extension' ),
									'param_name'       => 'circle_border',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"       => "vc_link",
									"class"      => "",
									"heading"    => esc_html__( "Link ", 'polo_extension' ),
									"param_name" => "icon_link",
									"value"      => "",
									'dependency' => array(
										'element'   => 'icon_type',
										'not_empty' => true,
									),
									'group'      => esc_html__( 'Icon', 'polo_extension' ),
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Animation', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'None', 'polo_extension' )        => '',
										esc_html__( 'Bounce', 'polo_extension' )      => 'bounce',
										esc_html__( 'Flash', 'polo_extension' )       => 'flash',
										esc_html__( 'Pulse', 'polo_extension' )       => 'pulse',
										esc_html__( 'Shake', 'polo_extension' )       => 'shake',
										esc_html__( 'Swing', 'polo_extension' )       => 'swing',
										esc_html__( 'Rubber band', 'polo_extension' ) => 'rubberBand',
										esc_html__( 'Tada', 'polo_extension' )        => 'tada',
										esc_html__( 'Wobble', 'polo_extension' )      => 'wobble',
									),
									'group'       => esc_html__( 'Animation', 'polo_extension' ),
									'admin_label' => true,
									'param_name'  => 'animation',
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Animation delay", 'polo_extension' ),
									"param_name"       => "animation_delay",
									"value"            => array(
										esc_html__( 'none', 'polo_extension' ) => '0',
										'0.5 sec'                              => '500',
										'1.0 sec'                              => '1000',
										'1.5 sec'                              => '1500',
										'2.0 sec'                              => '2000',
										'2.5 sec'                              => '2500',
									),
									'group'            => esc_html__( 'Animation', 'polo_extension' ),
									"dependency"       => Array(
										"element"   => "animation",
										"not_empty" => true
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									"type"             => "checkbox",
									"class"            => "",
									"heading"          => esc_html__( "Infinite animation", 'polo_extension' ),
									"param_name"       => "infinite_animation",
									"value"            => array(
										esc_html__( "Enable", 'polo_extension' ) => "1",
									),
									"description"      => "",
									"dependency"       => Array(
										"element"   => "animation",
										"not_empty" => true
									),
									'group'            => esc_html__( 'Animation', 'polo_extension' ),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
								),
							)
						)
					)
				);

			}

		}

		function crum_counter_form( $atts, $content = null ) {

			$counter_start = $counter_end = $counter_color = $description_color = $counter_speed = $size = $desc_separator = $description = $el_class = '';
			$icon_type     = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';
			$icon_color    = $icon_position = $circle_border = $animation = $animation_delay = $infinite_animation = $icon_link = '';

			$output = $counter_color = '';

			extract(
				shortcode_atts(
					array(
						'counter_start'      => '',
						'counter_end'        => '',
						'counter_speed'      => '1',
						'counter_color'      => '',
						'description_color'      => '',
						'size'               => 'default',
						'desc_separator'     => 'disable',
						'description'        => '',
						'el_class'           => '',
						'icon_type'          => '',
						'icon_fontawesome'   => 'fa fa-adjust',
						'icon_openiconic'    => 'vc-oi vc-oi-dial',
						'icon_typicons'      => 'typcn typcn-adjust-brightness',
						'icon_entypo'        => 'entypo-icon entypo-icon-note',
						'icon_linecons'      => 'vc_li vc_li-heart',
						'icon_custom_icon'   => '',
						'icon_color'         => '',
						'icon_link'          => '',
						'icon_position'      => 'left',
						'circle_border'      => '',
						'animation'          => '',
						'animation_delay'    => '0',
						'infinite_animation' => '',
					), $atts
				)
			);

			$icon       = null;
			$icon_style = $counter_style = $description_style = '';

			if ( isset( $icon_color ) && ! empty( $icon_color ) ) {
				$icon_style = 'style="color:' . $icon_color . ';';
				if ( isset( $icon_position ) && 'background' === $icon_position ) {
					$icon_style .= 'font-size: 110px;';
				}
				$icon_style .= '"';
			}
			if(isset($description_color) && !empty($description_color)){
				$description_style .= 'style="color:'.$description_color.'"';
			}

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ' . $icon_style . '></i>';
			}


			if ( function_exists( 'vc_build_link' ) ) {
				$href = vc_build_link( $icon_link );
			}
			if ( isset( $href['url'] ) && ! empty( $href['url'] ) ) {
				$link = $href['url'];
			} else {
				$link = '#';
			}

			if ( isset( $href['target'] ) && ( ' _blank' === $href['target'] ) ) {
				$target = 'target="_blank"';
			} else {
				$target = '';
			}

			$class = array();

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}
			if ( isset( $size ) && ! ( 'default' === $size ) ) {
				$class[] = str_replace( '_', '-', $size );
			}

			if ( isset( $counter_color ) && ! empty( $counter_color ) ) {
				$counter_style = 'style="color:' . $counter_color . '"';
			}

			$class = implode( ' ', $class );

			if ( ! ( null === $icon ) ) {

				$infnite = $bg_data = $border_class = '';

				if ( '1' === $infinite_animation ) {
					$infnite = 'infinite';
				}

				if ( isset( $circle_border ) && 'permanent' === $circle_border ) {
					$border_class = 'border';
				}

				if ( 'background' === $icon_position ) {
					$icon_bg_class = 'medium fancy';
					$bg_data       = 'data-animation="' . $animation . ' ' . $infnite . '"';
				} elseif ( 'top' === $icon_position ) {
					if ( ! empty( $circle_border ) ) {
						$icon_bg_class = 'effect medium ' . $border_class . ' center';
					} else {
						$icon_bg_class = 'effect center clean';
					}
				} else {
					$icon_bg_class = 'effect medium ' . $border_class . '';
				}

				$output .= '<div class="icon-box ' . $icon_bg_class . '" >';

				$output .= '<div class="icon" ' . $bg_data . '>';
				$output .= '<a href="' . $link . '" ' . $target . '>' . $icon . '</a>';
				$output .= '</div>';//.icon

				$output .= '<div class="counter ' . $class . '" ' . $counter_style . '>';
				$output .= '<span data-speed="' . $counter_speed . '000" data-refresh-interval="50" data-to="' . $counter_end . '" data-from="' . $counter_start . '" data-seperator="true"></span>';
				$output .= '</div>';//.counter

				if ( 'enable' === $desc_separator ) {
					$output .= '<div class="seperator seperator-small"></div>';
				}

				if ( isset( $description ) && ! empty( $description ) ) {
					$output .= '<p ' . $description_style . '>' . $description . '</p>';
				}

				$output .= '</div>';//.icon-box

			} else {
				$output .= '<div class="text-center">';
				$output .= '<div class="counter ' . $class . '" ' . $counter_style . '>';
				$output .= '<span data-speed="' . $counter_speed . '000" data-refresh-interval="50" data-to="' . $counter_end . '" data-from="' . $counter_start . '" data-seperator="true"></span>';
				$output .= '</div>';//.counter
				if ( 'enable' === $desc_separator ) {
					$output .= '<div class="seperator seperator-small"></div>';
				}
				if ( isset( $description ) && ! empty( $description ) ) {
					$output .= '<p ' . $description_style . '>' . $description . '</p>';
				}
				$output .= '</div>';//.text-center
			}


			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Counter' ) ) {
	$Crumina_Counter = new Crumina_Counter;
}
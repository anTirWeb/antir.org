<?php
if ( ! class_exists( 'Crumina_Pie_Chart' ) ) {

	class Crumina_Pie_Chart {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'pie_chart_init' ) );
			add_shortcode( 'crumina_pie_chart', array( &$this, 'pie_chart_form' ) );
		}

		function pie_chart_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Pie chart", 'polo_extension' ),
						"base"                    => "crumina_pie_chart",
						"icon"                    => "icon-wpb-vc_pie",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Style', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Default', 'polo_extension' )   => 'default',
										esc_html__( 'With icon', 'polo_extension' ) => 'icon',
									),
									'admin_label'      => true,
									'param_name'       => 'style',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Chart color", 'polo_extension' ),
									"param_name"       => "chart_color",
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Content color", 'polo_extension' ),
									"param_name"       => "number_icon_color",
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Chart value', 'polo_extension' ),
									'param_name'       => 'chart_value',
									'min'              => 0,
									'std'              => 50,
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Chart width', 'polo_extension' ),
									'min'              => 0,
									'admin_label'      => true,
									'param_name'       => 'chart_width',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Size', 'polo_extension' ),
									'min'              => 0,
									'admin_label'      => true,
									'param_name'       => 'size',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Title', 'polo_extension' ),
									'param_name' => 'title',
									'group'      => esc_html__( 'Content', 'polo_extension' ),
								),
								array(
									'type'       => 'textarea',
									'heading'    => esc_html__( 'Description', 'polo_extension' ),
									'param_name' => 'description',
									'group'      => esc_html__( 'Content', 'polo_extension' ),
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'group'       => esc_html__( 'Content', 'polo_extension' ),
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),
							),
							crum_do_vc_map_icon( null, array( 'element' => 'style', 'value' => 'icon' ) )
						)
					)
				);
			}
		}

		function pie_chart_form( $atts, $content = null ) {

			$output = $style = $chart_width = $size = $chart_color = $number_icon_color = $chart_value = $title = $description = $animation = $animation_delay = '';

			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_custom_icon = $icon = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'             => 'default',
						'chart_width'       => '',
						'size'              => '',
						'chart_value'       => '50',
						'chart_color'       => '',
						'number_icon_color' => '',
						'title'             => '',
						'description'       => '',
						'animation'         => '',
						'animation_delay'   => '0',
						'icon_type'         => '',
						'icon_fontawesome'  => 'fa fa-adjust',
						'icon_openiconic'   => 'vc-oi vc-oi-dial',
						'icon_typicons'     => 'typcn typcn-adjust-brightness',
						'icon_entypo'       => 'entypo-icon entypo-icon-note',
						'icon_linecons'     => 'vc_li vc_li-heart',
						'icon_custom_icon'  => '',
					), $atts
				)
			);

			if ( isset( $number_icon_color ) && ! empty( $number_icon_color ) ) {
				$inner_style = 'style="color: ' . $number_icon_color . ' !important"';
				$colored_class = 'pie-chart-colored';
			} else {
				$inner_style = $colored_class = '';
			}

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				if ( 100 > intval( $size ) ) {
					$icon_class = 'text-small';
				} else {
					$icon_class = '';
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . ' ' . $icon_class . '" ></i>';
			}

			if ( 'icon' === $style ) {
				$chart_inner = $icon;
			} else {
				if ( 100 > intval( $size ) ) {
					$chart_inner = '<span class="percent text-small"></span>';
				} else {
					$chart_inner = '<span class="percent"></span>';
				}
			}

			if ( isset( $chart_width ) && ! empty( $chart_width ) ) {
				$data_width = 'data-width="' . $chart_width . '"';
			} else {
				$data_width = '';
			}

			if ( isset( $size ) && ! empty( $size ) ) {
				$data_size = 'data-size="' . $size . '"';
			} else {
				$data_size = '';
			}

			$output .= '<div class="text-center ' . $el_class . ' '.$colored_class.'" ' . $inner_style . '>';
			$output .= ' <div class="pie-chart" data-percent="' . $chart_value . '" data-color="' . $chart_color . '" ' . $data_width . ' ' . $data_size . '> ' . $chart_inner . ' </div>';
			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h4>' . $title . '</h4>';
			}
			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<p>' . $description . '</p>';
			}
			$output .= '</div>';//.text-center

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Pie_Chart' ) ) {
	$Crumina_Pie_Chart = new Crumina_Pie_Chart;
}
<?php
if ( ! class_exists( 'Crumina_Separator' ) ) {

	class Crumina_Separator {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'separator_init' ) );
			add_shortcode( 'crumina_separator', array( &$this, 'separator_form' ) );
		}

		function separator_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Separator", 'polo_extension' ),
						"base"                    => "crumina_separator",
						"icon"                    => "icon-wpb-ui-separator",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array_merge(
							array(
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Type', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'With text', 'polo_extension' ) => 'text',
										esc_html__( 'With icon', 'polo_extension' ) => 'icon',
									),
									'admin_label'      => true,
									'param_name'       => 'type',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Style', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Solid', 'polo_extension' )  => 'solid',
										esc_html__( 'Dashed', 'polo_extension' ) => 'dashed',
									),
									'admin_label'      => true,
									'param_name'       => 'style',
									'dependency'       => array(
										'element' => 'type',
										'value'   => 'icon'
									),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Style', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Solid', 'polo_extension' )    => 'solid',
										esc_html__( 'Dashed', 'polo_extension' )   => 'dashed',
										esc_html__( 'Centered', 'polo_extension' ) => 'centered',
									),
									'admin_label'      => true,
									'param_name'       => 'style_text',
									'dependency'       => array(
										'element' => 'type',
										'value'   => 'text'
									),
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Width', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Full', 'polo_extension' )   => 'full',
										esc_html__( 'Medium', 'polo_extension' ) => 'medium',
										esc_html__( 'Small', 'polo_extension' )  => 'small',
									),
									'param_name'       => 'width',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc no-top-padding',
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Align', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Center', 'polo_extension' ) => 'center',
										esc_html__( 'Left', 'polo_extension' )   => 'left',
										esc_html__( 'Right', 'polo_extension' )  => 'right',
									),
									'param_name' => 'align',
									'dependency' => array(
										'element' => 'type',
										'value'   => 'icon'
									)
								),
								array(
									"type"       => "textfield",
									"class"      => "",
									"heading"    => esc_html__( "Separator text", 'polo_extension' ),
									"param_name" => "sep_text",
									'dependency' => array(
										'element' => 'type',
										'value'   => 'text'
									)
								),
							),
							crum_do_vc_map_icon( null, array( 'element' => 'type', 'value' => 'icon' ) ),
							array(
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
					)
				);
			}

		}

		function separator_form( $atts, $content = null ) {

			$type = $style = $style_text = $width = $align = $sep_text = $animation = $animation_delay = $el_class = $custom_delay = '';

			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';

			extract(
				shortcode_atts(
					array(
						'type'             => 'text',
						'style'            => 'solid',
						'style_text'       => 'solid',
						'width'            => 'full',
						'align'            => 'center',
						'sep_text'         => '',
						'el_class'         => '',
						'icon_type'        => '',
						'icon_fontawesome' => 'fa fa-adjust',
						'icon_openiconic'  => 'vc-oi vc-oi-dial',
						'icon_typicons'    => 'typcn typcn-adjust-brightness',
						'icon_entypo'      => 'entypo-icon entypo-icon-note',
						'icon_linecons'    => 'vc_li vc_li-heart',
						'icon_custom_icon' => '',
						'animation'        => '',
						'animation_delay'  => '0',
						'custom_delay'     => '',
					), $atts
				)
			);

			$output = $icon = $animation_data = $animation_data_delay = '';

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

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
			}

			if ( 'icon' === $type ) {
				$sep_content = $icon;
			} else {
				if ( isset( $sep_text ) && ! empty( $sep_text ) && ! ( 'centered' === $style_text ) ) {
					$sep_content = '<span>' . $sep_text . '</span>';
				} elseif ( isset( $sep_text ) && ! empty( $sep_text ) && ( 'centered' === $style_text ) ) {
					$sep_content = '<abbr>' . $sep_text . '</abbr>';
				} else {
					$sep_content = '';
				}
			}

			$class = array();

			$class[] = 'seperator';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( ( 'icon' === $type && 'dashed' === $style ) || ( 'text' === $type && 'dashed' === $style_text ) ) {
				$class[] = 'dotted';
			}

			if ( ! ( 'full' === $width ) ) {
				$class[] = 'seperator-' . $width;
			}

			if ( 'icon' === $type && isset( $align ) && ! ( 'center' === $align ) ) {
				$class[] = $align;
			}

			$class = implode( ' ', $class );

			if ( 'text' === $type && 'centered' === $style_text ) {
				$output .= '<div class="hr-title hr-long center ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>' . $sep_content . '</div>';
			} else {
				$output .= '<div class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . '>' . $sep_content . '</div>';
			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Separator' ) ) {
	$Crumina_Separator = new Crumina_Separator;
}
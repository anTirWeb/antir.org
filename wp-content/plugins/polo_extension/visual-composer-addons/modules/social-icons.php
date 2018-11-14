<?php
if ( ! class_exists( 'Crumina_Social_Icons' ) ) {

	class Crumina_Social_Icons {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'icons_init' ) );
			add_shortcode( 'crumina_social_icons', array( &$this, 'icons_form' ) );
		}

		function icons_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Social icons", 'polo_extension' ),
						"base"                    => "crumina_social_icons",
						"icon"                    => "socials-buttons",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Simple', 'polo_extension' )   => 'default',
									esc_html__( 'Bordered', 'polo_extension' ) => 'bordered',
									esc_html__( 'Round', 'polo_extension' )    => 'rounded',
									esc_html__( 'Colored', 'polo_extension' )  => 'colored',
									esc_html__( 'Light Colored', 'polo_extension' )  => 'light_colored',
								),
								'admin_label'      => true,
								'param_name'       => 'style',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Size', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Normal', 'polo_extension' ) => 'default',
									esc_html__( 'Medium', 'polo_extension' ) => 'medium',
									esc_html__( 'Large', 'polo_extension' )  => 'large',
								),
								'admin_label'      => true,
								'param_name'       => 'size',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Social icons', 'polo_extension' ),
								'param_name' => 'soc_icons',
								'params'     => array(
									array(
										'type'       => 'dropdown',
										'heading'    => esc_html__( 'Social network', 'polo_extension' ),
										'value'      => array_flip( crum_soc_networks_list() ),
										'param_name' => 'soc_network',
									),
									array(
										"type"       => "textfield",
										"class"      => "",
										"heading"    => esc_html__( "Link ", 'polo_extension' ),
										"param_name" => "soc_link",
										"value"      => "",
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
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

		function icons_form( $atts, $content = null ) {

			$style = $size = $soc_icons = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'     => 'default',
						'size'      => 'default',
						'soc_icons' => '',
						'el_class'  => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$soc_icons = (array) vc_param_group_parse_atts( $soc_icons );
			}

			$class = array();

			$class[] = 'social-icons';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'bordered' === $style ) {
				$class[] = 'social-icons-border';
			} elseif ( 'rounded' === $style ) {
				$class[] = 'social-icons-border social-icons-rounded';
			} elseif ( 'colored' === $style ) {
				$class[] = 'social-icons-colored';
			} elseif('light_colored' === $style){
				$class[] = 'social-icons-light social-icons-colored-hover';
			}

			if ( 'medium' === $size ) {
				$class[] = 'social-icons-medium';
			} elseif ( 'large' === $size ) {
				$class[] = 'social-icons-large';
			}

			$class = implode( ' ', $class );

			$output = '';

			$output .= '<div class="' . $class . '">';
			if ( isset( $soc_icons ) && is_array( $soc_icons ) ) {
				$output .= '<ul>';
				foreach ( $soc_icons as $single_icon ) {
					if ( 'pinterest-p' === $single_icon['soc_network'] ) {
						$output .= '<li class="social-pinterest">';
					} else {
						$output .= '<li class="social-' . $single_icon['soc_network'] . '">';
					}
					if(isset($single_icon['soc_link']) && !empty($single_icon['soc_link'])){
						$soc_link = esc_url($single_icon['soc_link']);
					}else{
						$soc_link = '#';
					}
					$output .= '<a href="' . $soc_link . '">';
					if ( 'google' === $single_icon['soc_network'] ) {
						$output .= '<i class="fa fa-google-plus"></i>';
					} elseif ( 'wikipedia' === $single_icon['soc_network'] ) {
						$output .= '<i class="fa fa-wikipedia-w"></i>';
					} else {
						$output .= '<i class="fa fa-' . $single_icon['soc_network'] . '"></i>';
					}
					$output .= '</a>';
					$output .= '</li>';
				}
				$output .= '</ul>';
			}
			$output .= '</div>';//.$class

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Social_Icons' ) ) {
	$Crumina_Social_Icons = new Crumina_Social_Icons;
}
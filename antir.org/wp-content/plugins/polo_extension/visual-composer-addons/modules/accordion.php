<?php
if ( ! class_exists( 'Crumina_Accordion' ) ) {

	/**
	 * Class Crumina_Accordion
	 */
	class Crumina_Accordion {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_accordion_init' ) );
			add_shortcode( 'crumina_accordion', array( &$this, 'crum_accordion_form' ) );
		}

		/**
		 * Admin options
		 */
		function crum_accordion_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/accordion/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Accordion/Toggle", 'polo_extension' ),
						"base"                    => "crumina_accordion",
						"icon"                    => "icon-wpb-ui-accordion",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'default'             => $assets_dir . 'accordion-default.png',
									'fancy'               => $assets_dir . 'accordion-fancy.png',
									'fancy_clean'         => $assets_dir . 'accordion-clean.png',
									'fancy_radius'        => $assets_dir . 'accordion-fancy-rounded.png',
									'radius_clean'        => $assets_dir . 'accordion-clean-round.png',
									'clean'               => $assets_dir . 'accordion-clear.png',
									'radius_border'       => $assets_dir . 'accordion-fancy-border.png',
									'clean_radius_border' => $assets_dir . 'accordion-clean-border.png',
									'colored'             => $assets_dir . 'accordion-color.png',
									'border_bottom'       => $assets_dir . 'accordion-border-bottom.png',
									'colored_border'      => $assets_dir . 'accordion-border-color.png',
									'simple_transparent'  => $assets_dir . 'accordion-transparent.png',
								),
								'std'         => 'default',
								'group'       => esc_attr__( 'Layout', 'polo_extension' ),
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Module type', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Accordion', 'polo_extension' ) => 'accordion',
									esc_html__( 'Toggle', 'polo_extension' )    => 'toggle',
								),
								'admin_label' => true,
								'param_name'  => 'module_type',
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Accordion tabs', 'polo_extension' ),
								'param_name' => 'tabs',
								'params'     => array_merge(
									array(
										array(
											'type'        => 'textfield',
											'heading'     => esc_html__( 'Title', 'polo_extension' ),
											'param_name'  => 'title',
											'description' => esc_html__( 'Accordion tab title', 'polo_extension' ),
										)
									),
									crum_do_vc_map_icon(),
									array(
										array(
											'type'        => 'textarea',
											'heading'     => esc_html__( 'Content', 'polo_extension' ),
											'param_name'  => 'tab_text',
											'description' => esc_html__( 'Accordion tab content', 'polo_extension' ),
										),
										array(
											'type'        => 'dropdown',
											"heading"     => esc_html__( "Active", 'polo_extension' ),
											'value'       => array(
												esc_html__( 'No', 'polo_extension' )    => '0',
												esc_html__( 'Yes', 'polo_extension' ) => '1',
											),
											"param_name"  => "tab_active",
										),
									)
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

		/**
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function crum_accordion_form( $atts, $content = null ) {

			$layout = $module_type = $tabs = $animation = $animation_delay = $el_class = '';

			$output = $icon = $animation_data = $animation_data_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'module_type'     => 'accordion',
						'layout'          => 'default',
						'tabs'            => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$tabs = (array) vc_param_group_parse_atts( $tabs );
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

			$class = array();

			$class[] = 'accordion';

			if ( 'toggle' === $module_type ) {
				$class[] = 'toggle';
			}

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'fancy' === $layout ) {
				$class[] = 'fancy';
			} elseif ( 'fancy_clean' === $layout ) {
				$class[] = 'fancy clean';
			} elseif ( 'fancy_radius' === $layout ) {
				$class[] = 'fancy radius';
			} elseif ( 'radius_clean' === $layout ) {
				$class[] = 'fancy radius clean';
			} elseif ( 'clean' === $layout ) {
				$class[] = 'clean';
			} elseif ( 'radius_border' === $layout ) {
				$class[] = 'radius border';
			} elseif ( 'clean_radius_border' === $layout ) {
				$class[] = 'clean radius border';
			} elseif ( 'colored' === $layout ) {
				$class[] = 'color';
			} elseif ( 'border_bottom' === $layout ) {
				$class[] = 'clean border-bottom';
			} elseif ( 'colored_border' === $layout ) {
				$class[] = 'clean color-border-bottom';
			} elseif ( 'simple_transparent' === $layout ) {
				$class[] = 'fancy clean accordion-transparent';
			}

			$class = implode( ' ', $class );

			$output .= '<div class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			if ( is_array( $tabs ) && ! empty( $tabs ) ) {
				$has_active = false;
				foreach ( $tabs as $single_tab ) {

					if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && isset($single_tab['icon_type']) &&  ! ( 'custom_icon' === $single_tab['icon_type'] ) ) {
						vc_icon_element_fonts_enqueue( $single_tab['icon_type'] );
					}

					if ( isset( $single_tab['icon_type'] ) && ! empty( $single_tab['icon_type'] ) ) {
						$icon = '<i class="' . $single_tab[ 'icon_' . $single_tab['icon_type'] ] . '" ></i>';
					}

					if ( isset( $single_tab['tab_active'] ) && ( '1' === $single_tab['tab_active'] ) && ( false == $has_active ) ) {
						$active_class = 'ac-active';
						if ( ! 'toggle' === $module_type ) {
							$has_active = true;
						}
					} else {
						$active_class = '';
					}

					$output .= '<div class="ac-item ' . $active_class . '">';

					$output .= '<h5 class="ac-title">' . $icon . $single_tab['title'] . '</h5>';
					$output .= '<div class="ac-content">' . do_shortcode( $single_tab['tab_text'] ) . '</div>';

					$output .= '</div>';//.ac-item

				}

			}

			$output .= '</div>';//.class

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Accordion' ) ) {
	$Crumina_Accordion = new Crumina_Accordion;
}
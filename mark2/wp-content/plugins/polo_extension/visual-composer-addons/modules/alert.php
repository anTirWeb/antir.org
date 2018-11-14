<?php
if ( ! class_exists( 'Crumina_Alert' ) ) {

	/**
	 * Class Crumina_Alert
	 */
	class Crumina_Alert {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_alert_init' ) );
			add_shortcode( 'crumina_alert', array( &$this, 'crum_alert_form' ) );
		}

		/**
		 *Admin options
		 */
		function crum_alert_init() {

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"                    => esc_html__( "Polo Alert box", 'polo_extension' ),
						"base"                    => "crumina_alert",
						"icon"                    => "alert-box",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Alert type', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Success', 'polo_extension' ) => 'success',
										esc_html__( 'Info', 'polo_extension' )    => 'info',
										esc_html__( 'Warning', 'polo_extension' ) => 'warning',
										esc_html__( 'Danger', 'polo_extension' )  => 'danger',
									),
									'admin_label' => true,
									'param_name'  => 'type',
								),
								array(
									"type"        => "checkbox",
									"class"       => "",
									"heading"     => esc_html__( "Dismissible", 'polo_extension' ),
									"param_name"  => "alert_dismiss",
									"value"       => array(
										esc_html__( "Enable", 'polo_extension' ) => "1",
									),
									"description" => "",
								),
							),
							crum_do_vc_map_icon(),
							array(
								array(
									'type'        => 'textarea_html',
									'heading'     => esc_html__( 'Content', 'polo_extension' ),
									'param_name'  => 'content',
									'description' => esc_html__( 'Alert content', 'polo_extension' ),
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

						),
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
		function crum_alert_form( $atts, $content = null ) {

			$type      = $alert_dismiss = $output = $icon = $animation_data = $animation_data_delay = $el_class = $custom_delay = '';
			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';

			extract(
				shortcode_atts(
					array(
						'type'             => 'success',
						'alert_dismiss'    => '',
						'icon_type'        => '',
						'el_class'         => '',
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

			if ( '1' === $alert_dismiss ) {
				$dismiss_class = 'alert-dismissible';
			} else {
				$dismiss_class = '';
			}

			$output .= '<div class="alert alert-' . $type . ' ' . $el_class . ' ' . $dismiss_class . '" role="alert" ' . $animation_data . ' ' . $animation_data_delay . '>';
			if ( '1' === $alert_dismiss ) {
				$output .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>';
			}
			$content = str_replace( '<a ', '<a class="alert-link"', $content );

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
			}
			$output .= $icon . ' ';

			$output .= $content;

			$output .= '</div>';//.alert

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Alert' ) ) {
	$Crumina_Alert = new Crumina_Alert;
}
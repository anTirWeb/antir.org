<?php
if ( ! class_exists( 'Crumina_Countdown' ) ) {

	class Crumina_Countdown {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_countdown_init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_shortcode( 'crumina_countdown', array( &$this, 'crum_countdown_form' ) );
		}

		function admin_scripts() {
			global $wp_scripts;

			wp_enqueue_style( 'datetime-picker', PLUGIN_URL . 'assets/css/admin/datepicker.css' );
			wp_enqueue_script( 'jquery-ui-datepicker' );

		}

		function crum_countdown_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Countdown", 'polo_extension' ),
						"base"                    => "crumina_countdown",
						"icon"                    => "countdown",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								"type"       => "datetimepicker",
								"heading"    => esc_html__( "Date", 'polo_extension' ),
								"param_name" => "countdown_timer",
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' ) => 'default',
									esc_html__( 'Circle', 'polo_extension' )  => 'circle',
									esc_html__( 'Square', 'polo_extension' )  => 'square',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Size', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' ) => 'default',
									esc_html__( 'Medium', 'polo_extension' )  => 'medium',
									esc_html__( 'Small', 'polo_extension' )   => 'small',
								),
								'admin_label' => true,
								'param_name'  => 'size',
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

		function crum_countdown_form( $atts, $content = null ) {

			$countdown_timer = $style = $size = $el_class = $animation = $animation_delay = $custom_delay = $output = '';

			extract(
				shortcode_atts(
					array(
						'countdown_timer' => '',
						'style'           => 'default',
						'size'            => 'default',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			$animation_data = $animation_data_delay = '';

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

			$class[] = 'countdown';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'circle' === $style ) {
				$class[] = 'circle';
			} elseif ( 'square' === $style ) {
				$class[] = 'rectangle';
			}

			if ( 'medium' === $size ) {
				$class[] = 'medium';
			} elseif ( 'small' === $size ) {
				$class[] = 'small';
			}

			$class = implode( ' ', $class );

			$output .= '<div class="' . $class . '" data-labels="'.esc_attr__('Days,Hours,Minutes,Seconds','polo_extension').'" data-countdown="' . $countdown_timer . ' 00:00:00" ' . $animation_data . ' ' . $animation_data_delay . ' ></div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Countdown' ) ) {
	$Crumina_Countdown = new Crumina_Countdown;
}
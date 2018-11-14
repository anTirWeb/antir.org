<?php
if ( ! class_exists( 'Crumina_Panel' ) ) {
	class Crumina_Panel {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'panel_init' ) );
			add_shortcode( 'crumina_panel', array( &$this, 'panel_form' ) );
		}

		function panel_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Panel", 'polo_extension' ),
						"base"                    => "crumina_panel",
						"icon"                    => "polo-panel",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' ) => 'default',
									esc_html__( 'Primary', 'polo_extension' ) => 'primary',
									esc_html__( 'Success', 'polo_extension' ) => 'success',
									esc_html__( 'Info', 'polo_extension' )    => 'info',
									esc_html__( 'Warning', 'polo_extension' ) => 'warning',
									esc_html__( 'Danger', 'polo_extension' )  => 'danger',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Header title', 'polo_extension' ),
								'param_name' => 'title',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Title style', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Simple text', 'polo_extension' ) => 'text',
									esc_html__( 'Heading', 'polo_extension' )     => 'heading',
								),
								'param_name' => 'title_style',
								'dependency' => array(
									'element'   => 'title',
									'not_empty' => true,
								)
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Footer title', 'polo_extension' ),
								'param_name' => 'footer_title',
							),
							array(
								'type'       => 'textarea_html',
								'heading'    => esc_html__( 'Description', 'polo_extension' ),
								'param_name' => 'content',
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

		function panel_form( $atts, $content = null ) {

			$style = $title = $title_style = $footer_title = $el_class = $animation = $animation_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'style'           => 'default',
						'title'           => '',
						'title_style'     => 'text',
						'footer_title'    => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			$output = '';

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

			$output .= '<div class="panel panel-' . $style . ' ' . $el_class . '" ' . $animation_data . $animation_data_delay . '>';

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<div class="panel-heading">';
				if ( 'heading' === $title_style ) {
					$output .= '<h3 class="panel-title">' . $title . '</h3>';
				} else {
					$output .= $title;
				}
				$output .= '</div>';//.panel-heading
			}

			$output .= '<div class="panel-body">';
			$output .= $content;
			$output .= '</div>';

			if ( isset( $footer_title ) && ! empty( $footer_title ) ) {
				$output .= '<div class="panel-footer">' . $footer_title . '</div>';
			}

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Panel' ) ) {
	$Crumina_Panel = new Crumina_Panel;
}
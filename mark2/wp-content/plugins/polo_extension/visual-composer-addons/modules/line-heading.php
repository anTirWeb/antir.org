<?php
if ( ! class_exists( 'Crumina_Lined_Heading' ) ) {

	class Crumina_Lined_Heading {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'heading_init' ) );
			add_shortcode( 'crumina_heading_with_line', array( &$this, 'heading_form' ) );

		}

		function heading_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Heading with line", 'polo_extension' ),
						"base"                    => "crumina_heading_with_line",
						"icon"                    => "icon-wpb-ui-custom_heading",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(

							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Heading', 'polo_extension' ),
								'param_name' => 'heading',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Align', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Right', 'polo_extension' )  => 'right',
									esc_html__( 'Center', 'polo_extension' ) => 'center',
								),
								'param_name'       => 'align',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'       => 'crumina_font_container',
								'heading'    => '',
								'param_name' => 'heading_font_options',
								'settings'   => array(
									'fields' => array(
										'tag' => 'h2',
										'letter_spacing',
										'font_size',
										'line_height',
										'color',
										'font_style'
									),
								),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Custom font weight', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Default', 'polo_extension' ) => '',
									'100'                                     => '100',
									'200'                                     => '200',
									'300'                                     => '300',
									'400'                                     => '400',
									'500'                                     => '500',
									'600'                                     => '600',
									'700'                                     => '700',
									'800'                                     => '800',
									'900'                                     => '900',
								),
								'param_name' => 'heading_font_weight',
							),
							array(
								'type'        => 'checkbox',
								'heading'     => esc_html__( 'Use custom font family?', 'crum' ),
								'param_name'  => 'heading_use_google_fonts',
								'value'       => array( esc_html__( 'Yes', 'crum' ) => 'yes' ),
								'description' => esc_html__( 'Use font family from google.', 'crum' ),
							),
							array(
								'type'       => 'google_fonts',
								'param_name' => 'heading_custom_fonts',
								'value'      => '',
								'settings'   => array(
									'fields' => array(
										'font_family_description' => esc_html__( 'Select font family.', 'crum' ),
										'font_style_description'  => esc_html__( 'Select font styling.', 'crum' ),
									),
								),
								'dependency' => array(
									'element' => 'heading_use_google_fonts',
									'value'   => 'yes',
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

		function heading_form( $atts, $content = null ) {

			$output = $heading = $align = $heading_font_options = $heading_font_weight = $heading_use_google_fonts = $heading_custom_fonts = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'heading'                  => '',
						'align'                    => 'left',
						'heading_font_options'     => '',
						'heading_font_weight'      => '',
						'heading_use_google_fonts' => '',
						'heading_custom_fonts'     => '',
						'el_class'                 => '',
					), $atts
				)
			);

			if ( 'right' === $align ) {
				$align_class = 'text-right';
			} elseif ( 'center' === $align ) {
				$align_class = 'heading-center';
			} else {
				$align_class = 'text-left';
			}

			$output .= '<div class="heading-fancy heading-line ' . $align_class . ' ' . $el_class . '">';

			if ( isset( $heading ) && ! empty( $heading ) ) {
				$heading_font_options = _crum_parse_text_shortcode_params( $heading_font_options, '', $heading_use_google_fonts, $heading_custom_fonts );
				$heading_style        = $heading_font_options['style'];
				if ( isset( $heading_font_weight ) && ! empty( $heading_font_weight ) ) {
					if ( ! empty( $heading_style ) ) {
						if ( true === $heading_font_options['bold'] ) {
							$heading_style = str_replace( 'bold', $heading_font_weight, $heading_style );
						} else {
							$heading_style = str_replace( 'style="', 'style="font-weight:' . $heading_font_weight . '; ', $heading_style );
						}
					} else {
						$heading_style = 'style="font-weight:' . $heading_font_weight . ';"';
					}
				}

				$output .= '<' . $heading_font_options['tag'] . ' ' . $heading_style . '>' . $heading . '</' . $heading_font_options['tag'] . '>';
			}

			$output .= '</div>';/*heading-fancy heading-line*/

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Lined_Heading' ) ) {
	$Crumina_Lined_Heading = new Crumina_Lined_Heading;
}
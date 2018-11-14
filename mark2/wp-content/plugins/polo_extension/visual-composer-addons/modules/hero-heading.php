<?php
if ( ! class_exists( 'Crumina_Hero_Heading' ) ) {

	class Crumina_Hero_Heading {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'hero_heading_init' ) );
			add_shortcode( 'crum_hero_heading', array( &$this, 'hero_heading_form' ) );
		}

		function hero_heading_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Hero Heading", 'polo_extension' ),
						"base"                    => "crum_hero_heading",
						"icon"                    => "heading",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'type'       => 'textarea_html',
								'heading'    => esc_html__( 'Heading', 'polo_extension' ),
								'param_name' => 'content',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Subheading', 'polo_extension' ),
								'param_name' => 'subheading',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Align', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Right', 'polo_extension' )  => 'right',
									esc_html__( 'Center', 'polo_extension' ) => 'center',
								),
								'param_name' => 'align',
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
								'param_name'  => 'el_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
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
								'group'      => esc_html__( 'Typography', 'crum' ),
							),
							array(
								'type'        => 'checkbox',
								'heading'     => esc_html__( 'Use custom font family?', 'crum' ),
								'param_name'  => 'heading_use_google_fonts',
								'value'       => array( esc_html__( 'Yes', 'crum' ) => 'yes' ),
								'description' => esc_html__( 'Use font family from google.', 'crum' ),
								'group'       => esc_html__( 'Typography', 'crum' ),
							),
							array(
								'type'       => 'google_fonts',
								'param_name' => 'heading_custom_fonts',
								'value'      => '',
								'group'      => esc_html__( 'Title', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
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
						)
					)
				);
			}

		}

		function hero_heading_form( $atts, $content = null ) {

			$output               = $align = $el_class = $subheading = '';
			$heading_font_options = $heading_use_google_fonts = $heading_custom_fonts = '';

			extract(
				shortcode_atts(
					array(
						'align'                    => 'left',
						'subheading'               => '',
						'el_class'                 => '',
						'heading_font_options'     => '',
						'heading_use_google_fonts' => '',
						'heading_custom_fonts'     => '',
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

			$heading_font_options = _crum_parse_text_shortcode_params( $heading_font_options, '', $heading_use_google_fonts, $heading_custom_fonts );
			$heading_style        = $heading_font_options['style'];

			$output .= '<div class="hero-heading '.$el_class.'">';
			$output .= '<' . $heading_font_options['tag'] . ' class="' . $align_class . '" ' . $heading_style . '>' . do_shortcode( $content ) . '</' . $heading_font_options['tag'] . '>';
			if ( isset( $subheading ) && ! empty( $subheading ) ) {
				$output .= '<p class="lead ' . $align_class . '">' . $subheading . '</p>';
			}
			$output .= '</div>';/*hero-heading-2*/

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Hero_Heading' ) ) {
	$Crumina_Hero_Heading = new Crumina_Hero_Heading;
}
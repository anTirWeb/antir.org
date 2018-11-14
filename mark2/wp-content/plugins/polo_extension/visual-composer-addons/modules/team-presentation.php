<?php
if ( ! class_exists( 'Crumina_Team_Presentation' ) ) {

	class Crumina_Team_Presentation {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_team_presentation_init' ) );
			add_shortcode( 'crumina_team_presentation', array( &$this, 'crum_team_presentation_form' ) );
		}

		function crum_team_presentation_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Team presentation", 'polo_extension' ),
						"base"                    => "crumina_team_presentation",
						"class"                   => "",
						"icon"                    => "team-presentation",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"as_parent"               => array( 'only' => 'crumina_team_member' ),
						"content_element"         => true,
						"js_view"                 => 'VcColumnView',
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' )          => 'default',
									esc_html__( 'With description', 'polo_extension' ) => 'with_desc',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Controls style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Dots', 'polo_extension' )   => 'dots',
									esc_html__( 'Arrows', 'polo_extension' ) => 'arrows',
								),
								'admin_label' => true,
								'param_name'  => 'controls_style',
								'dependency'  => array(
									'element' => 'style',
									'value'   => array( 'default' )
								),
							),
							array(
								'type'       => 'number',
								'heading'    => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name' => 'slides_to_show',
								'min'        => 0,
								'std'        => '6',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'polo_extension' ),
								'param_name' => 'title',
								'dependency' => array(
									'element' => 'style',
									'value'   => 'with_desc'
								)
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Description', 'polo_extension' ),
								'param_name' => 'description',
								'dependency' => array(
									'element' => 'style',
									'value'   => 'with_desc'
								)
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

		function crum_team_presentation_form( $atts, $content = null ) {

			$output = $style = $controls_style = $slides_to_show = $title = $description = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'          => 'default',
						'controls_style' => 'dots',
						'slides_to_show' => '6',
						'title'          => '',
						'description'    => '',
						'el_class'       => '',
					), $atts
				)
			);

			if ( 'dots' === $controls_style && 'default' === $style ) {
				$data_controls = 'data-carousel-dots="true"';
			} else {
				$data_controls = '';
			}

			$class = array();

			$class[] = 'carousel clients-carousel';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			$class = implode( ' ', $class );

			$pattern = get_shortcode_regex();
			preg_match_all( '/' . $pattern . '/s', $content, $matches );

			if ( isset( $matches[0] ) && is_array( $matches[0] ) ) {
				if ( 'with_desc' === $style ) {

					$output .= '<div class="row carousel-description-style '.$el_class.'">';

					$output .= '<div class="col-md-4">';

					$output .= '<div class="description">';

					if ( isset( $title ) && ! empty( $title ) ) {
						$output .= '<h2>' . $title . '</h2>';
					}

					if ( isset( $description ) && ! empty( $description ) ) {
						$output .= wpautop( $description );
					}

					$output .= '</div>';//.description

					$output .= '</div>';//.col-md-4

					$output .= '<div class="col-md-8">';

					$output .= '<div class="carousel" data-lightbox-type="gallery" data-carousel-col="' . $slides_to_show . '">';

					foreach ( $matches[0] as $single_team_member ) {
						$output .= '<div class="featured-box">' . do_shortcode( $single_team_member ) . '</div>';
					}

					$output .= '</div>';//.carousel

					$output .= '</div>';//.col-md-8


					$output .= '</div>';//.carousel-description-style

				} else {
					$output .= '<div class="' . $class . '" data-carousel-col="' . $slides_to_show . '" ' . $data_controls . '>';

					foreach ( $matches[0] as $single_team_member ) {
						$output .= '<div>' . do_shortcode( $single_team_member ) . '</div>';
					}

					$output .= '</div>';
				}
			}

			return $output;

		}

	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Crumina_Team_Presentation extends WPBakeryShortCodesContainer {
	}

}

if ( class_exists( 'Crumina_Team_Presentation' ) ) {
	$Crumina_Team_Presentation = new Crumina_Team_Presentation;
}
<?php
if ( ! class_exists( 'Crumina_Youtube_Carousel' ) ) {

	class Crumina_Youtube_Carousel {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'carousel_init' ) );
			add_shortcode( 'crumina_youtube_carousel', array( &$this, 'carousel_form' ) );
		}

		function carousel_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Youtube video carousel", 'polo_extension' ),
						"base"                    => "crumina_youtube_carousel",
						"icon"                    => "youtube-video",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Slides', 'polo_extension' ),
								'param_name' => 'videos',
								'params'     => array(
									array(
										'type'        => 'textfield',
										'heading'     => esc_html__( 'Video', 'polo_extension' ),
										'param_name'  => 'url',
										'description' => esc_html__( 'Youtube video url', 'polo_extension' ),
									)
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Controls style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Dots', 'polo_extension' )   => 'dots',
									esc_html__( 'Arrows', 'polo_extension' ) => 'arrows',
								),
								'admin_label'      => true,
								'param_name'       => 'controls_style',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name'       => 'slides_to_show',
								'min'              => 0,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'        => 'textfield',
								'heading'     => __( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
							),
						)
					)
				);
			}

		}

		function carousel_form( $atts, $content = null ) {

			$videos = $slides_to_show = $controls_style = $el_class = $output = $data_dots = '';

			extract(
				shortcode_atts(
					array(
						'videos'         => '',
						'slides_to_show' => '3',
						'controls_style' => 'dots',
						'el_class'       => '',
					), $atts
				)
			);

			if ( 'dots' === $controls_style ) {
				$data_dots = 'data-carousel-dots="true"';
			}

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$videos = (array) vc_param_group_parse_atts( $videos );
			}

			$output .= '<div class="carousel ' . $el_class . '" data-carousel-video="true" data-carousel-col="' . $slides_to_show . '" data-carousel-col-md="2" data-carousel-col-sm="2" data-carousel-margins="0" ' . $data_dots . '>';

			foreach ( $videos as $single_video ) {
				$output .= '<div class="item-video">';
				$output .= '<a class="owl-video" href="' . $single_video['url'] . '"></a>';
				$output .= '</div>';
			}

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Youtube_Carousel' ) ) {
	$Crumina_Youtube_Carousel = new Crumina_Youtube_Carousel;
}
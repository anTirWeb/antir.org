<?php
if ( ! class_exists( 'Crumina_Rolling_Banner' ) ) {

	class Crumina_Rolling_Banner {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'banner_init' ) );
			add_shortcode( 'crumina_rolling_banner', array( &$this, 'banner_form' ) );

		}

		function banner_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(

						"name"                    => esc_html__( "Polo Rolling Banner", 'polo_extension' ),
						"base"                    => "crumina_rolling_banner",
						"icon"                    => "",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'polo_extension' ),
								'param_name' => 'title',
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Items', 'polo_extension' ),
								'param_name' => 'items',
								'params'     => array(
									array(
										'type'        => 'textfield',
										'heading'     => esc_html__( 'Item text', 'polo_extension' ),
										'param_name'  => 'title',
										'description' => esc_html__( 'Rolling banner item text', 'polo_extension' ),
									),
									array(
										'type'        => 'textfield',
										'heading'     => esc_html__( 'Item link', 'polo_extension' ),
										'param_name'  => 'link',
										'description' => esc_html__( 'Rolling banner item link', 'polo_extension' ),
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

		function banner_form( $atts, $content = null ) {

			$title = $items = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'title'    => '',
						'items'    => '',
						'el_class' => '',
					), $atts
				)
			);

			$output .= '<div class="news-ticker">';

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<div class="news-ticker-title">';
				$output .= '<h4>' . $title . '</h4>';
				$output .= '</div>';
			}

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$items = (array) vc_param_group_parse_atts( $items );
			}

			if ( isset( $items ) && ! empty( $items ) ) {
				$output .= '<div class="news-ticker-content">';
				foreach ( $items as $single_item ) {

					if ( isset( $single_item['link'] ) && ! empty( $single_item['link'] ) ) {
						$link = $single_item['link'];
					} else {
						$link = '#';
					}

					if ( isset( $single_item['title'] ) && ! empty( $single_item['title'] ) ) {
						$item_title = $single_item['title'];
					} else {
						$item_title = '';
					}

					if ( ! empty( $item_title ) ) {
						$output .= '<a href="' . esc_url( $link ) . '">' . $item_title . '</a>';
					}

				}
				$output .= '</div>';
			}

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Rolling_Banner' ) ) {
	$Crumina_Rolling_Banner = new Crumina_Rolling_Banner;
}
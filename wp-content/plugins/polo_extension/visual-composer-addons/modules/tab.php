<?php
if ( ! class_exists( 'Crumina_Tab' ) ) {

	class Crumina_Tab {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'tab_init' ) );
			add_shortcode( 'crumina_tab', array( &$this, 'tab_form' ) );
		}

		function tab_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Tab", 'polo_extension' ),
						"base"                    => "crumina_tab",
						"icon"                    => "",
						"category"                => esc_html__( 'Tabs', 'polo_extension' ),
						"show_settings_on_create" => true,
						'as_child'                => array(
							'only' => 'crumina_horizontal_tabs,crumina_vertical_tabs',
						),
						'params'                  => array_merge(
							array(
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Tab Title', 'polo_extension' ),
									'param_name'  => 'tab_title',
									'description' => esc_html__( 'Tab title', 'polo_extension' ),
								),
							),
							crum_do_vc_map_icon(),
							array(
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Content Title', 'polo_extension' ),
									'param_name'  => 'content_title',
									'description' => esc_html__( 'Content title', 'polo_extension' ),
								),
								array(
									'type'        => 'textarea_html',
									'heading'     => esc_html__( 'Content', 'polo_extension' ),
									'param_name'  => 'content',
									'description' => esc_html__( 'Tab content', 'polo_extension' ),
								),
								array(
									'type'       => 'el_id',
									'param_name' => 'tab_id',
									'settings'   => array(
										'auto_generate' => true,
									),
									'heading'    => esc_html__( 'Tab ID', 'polo_extension' ),
								),
							)
						)
					)
				);
			}

		}

		function tab_form( $atts, $content = null ) {

			$tab_title = $content_title  = $tab_id = $active = '';
			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';

			extract(
				shortcode_atts(
					array(
						'tab_title'        => '',
						'content_title'    => '',
						'tab_text'         => '',
						'tab_id'           => '',
						'active'           => '',
						'icon_type'        => '',
						'icon_fontawesome' => 'fa fa-adjust',
						'icon_openiconic'  => 'vc-oi vc-oi-dial',
						'icon_typicons'    => 'typcn typcn-adjust-brightness',
						'icon_entypo'      => 'entypo-icon entypo-icon-note',
						'icon_linecons'    => 'vc_li vc_li-heart',
						'icon_custom_icon' => '',
					), $atts
				)
			);

			$output = $icon = '';

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
			}

			$output .= '<li class="' . $active . '">';
			$output .= '<a href="#' . $tab_id . '">';
			$output .= $icon;
			if ( isset( $tab_title ) && ! empty( $tab_title ) ) {
				$output .= $tab_title;
			}
			$output .= '</a>';
			$output .= '</li>';

			$output .= '<span class="tab-delimiter"></span>';

			$output .= '<div id="' . $tab_id . '" class="tab-pane ' . $active . '">';

			if ( isset( $content_title ) && ! empty( $content_title ) ) {
				$output .= '<h4>' . $content_title . '</h4>';
			}

			if ( isset( $content ) && ! empty( $content ) ) {
//				$output .= '<p>' . wpautop( $tab_text ) . '</p>';
				$output .= wpb_js_remove_wpautop( $content, true );
			}

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Tab' ) ) {
	$Crumina_Tab = new Crumina_Tab;
}
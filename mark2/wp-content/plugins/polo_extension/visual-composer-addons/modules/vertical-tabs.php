<?php
if ( ! class_exists( 'Crumina_Vertical_Tabs' ) ) {

	class Crumina_Vertical_Tabs {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'tabs_init' ) );
			add_shortcode( 'crumina_vertical_tabs', array( &$this, 'tabs_form' ) );
		}

		function tabs_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Vertical tabs", 'polo_extension' ),
						"base"                    => "crumina_vertical_tabs",
						"icon"                    => "icon-wpb-ui-tab-content-vertical",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"as_parent"               => array( 'only' => 'crumina_tab' ),
						"content_element"         => true,
						"js_view"                 => 'VcColumnView',
						"params"                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' )     => 'default',
									esc_html__( 'With border', 'polo_extension' ) => 'with_border',
									esc_html__( 'Colored', 'polo_extension' )     => 'colored',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Controls align', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Left', 'polo_extension' )  => 'left',
									esc_html__( 'Right', 'polo_extension' ) => 'right',
								),
								'admin_label' => true,
								'param_name'  => 'controls_align',
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

		function tabs_form( $atts, $content = null ) {

			$style = $controls_align = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'          => 'default',
						'controls_align' => 'left',
						'el_class'       => '',
					), $atts
				)
			);

			$output = '';

			$class    = array();
			$controls = $contents = '';
			preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

			if ( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
				$i = 0;
				foreach ( $matches[0] as $single_tab_shortcode ) {
					if ( 0 === $i ) {
						$tab_html = do_shortcode( str_replace( '[crumina_tab', '[crumina_tab active="active" ', $single_tab_shortcode ) );
					} else {
						$tab_html = do_shortcode( $single_tab_shortcode );
					}
					$tabs = explode( '<span class="tab-delimiter"></span>', $tab_html );
					if ( isset( $tabs[0] ) && ! empty( $tabs[0] ) ) {
						$controls .= $tabs[0];
					}
					if ( isset( $tabs[1] ) && ! empty( $tabs[1] ) ) {
						$contents .= $tabs[1];
					}
					$i ++;
				}
			}

			$class[] = 'tabs tabs-vertical';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'with_border' === $style ) {
				$class[] = 'border';
			} elseif ( 'colored' === $style ) {
				$class[] = 'color';
			}

			if ( 'right' === $controls_align ) {
				$class[] = 'tabs-right"';
			}

			//coz all " in html attributes are changed to " by some reason
			$contents = str_replace('``','"',$contents);

			$class = implode( ' ', $class );

			$output .= '<div class="' . $class . '">';

			$output .= '<ul class="tabs-navigation">';

			$output .= $controls;

			$output .= '</ul>';//.tabs-navigation

			$output .= '<div class="tabs-content">';

			$output .= $contents;

			$output .= '</div>';//.tabs-content

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Crumina_Vertical_Tabs extends WPBakeryShortCodesContainer {
	}

}

if ( class_exists( 'Crumina_Vertical_Tabs' ) ) {
	$Crumina_Vertical_Tabs = new Crumina_Vertical_Tabs;
}
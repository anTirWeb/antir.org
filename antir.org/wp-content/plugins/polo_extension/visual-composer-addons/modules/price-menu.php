<?php
if ( ! ( class_exists( 'Crumina_Price_Menu' ) ) ) {

	class Crumina_Price_Menu {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'price_menu_init' ) );
			add_shortcode( 'crumina_price_menu', array( &$this, 'price_menu_form' ) );
		}

		function price_menu_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Price Menu", 'polo_extension' ),
						"base"                    => "crumina_price_menu",
						"icon"                    => "price-menu",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(

							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Menu items', 'polo_extension' ),
								'param_name' => 'menu',
								'params'     => array(
									array(
										'type'        => 'attach_image',
										'heading'     => esc_html__( 'Photo', 'polo_extension' ),
										'param_name'  => 'photo',
										'value'       => '',
										'admin_label' => true,
										'description' => esc_html__( 'Select image from media library.', 'polo_extension' ),
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Title', 'polo_extension' ),
										'param_name' => 'title',
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Description', 'polo_extension' ),
										'param_name' => 'description',
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Price', 'polo_extension' ),
										'param_name' => 'prise',
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								"type"       => "dropdown",
								"class"      => "",
								"heading"    => esc_html__( "Items align", 'polo_extension' ),
								"param_name" => "items_align",
								"value"      => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Center', 'polo_extension' ) => 'center',
								),
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

		function price_menu_form( $atts, $content = null ) {

			wp_enqueue_style( 'crum-nothing-you-could-do-font' );

			$output         = $menu = $items_align = $el_class = $animation = $animation_delay = $custom_delay = '';
			$animation_data = $animation_data_delay = '';
			extract(
				shortcode_atts(
					array(
						'menu'            => '',
						'items_align'     => 'left',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$menu = (array) vc_param_group_parse_atts( $menu );
			}

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

			if ( 'left' === $items_align ) {
				$img_style = 'style="margin-right: 20px;"';
			} else {
				$img_style = '';
			}

			if ( isset( $menu ) && ! empty( $menu ) ) {
				if ( 'center' === $items_align ) {
					$output .= '<div class="text-center">';
				}
				$output .= '<ul class="price-menu-list ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				foreach ( $menu as $single_item ) {

					$output .= '<li>';

					if ( isset( $single_item['photo'] ) && ! empty( $single_item['photo'] ) ) {
						$image_url = wp_get_attachment_image_src( $single_item['photo'], 'full' );
						$image_url = polo_theme_thumb( $image_url[0], '100', '100', true, 'c' );
						$output .= '<img src="' . $image_url . '" ' . $img_style . ' >';
					}

					if ( isset( $single_item['title'] ) && ! empty( $single_item['title'] ) ) {
						$output .= '<h2 class="font-nothing-you-could-do">' . $single_item['title'] . '</h2>';
					}
					if ( isset( $single_item['description'] ) && ! empty( $single_item['description'] ) ) {
						$output .= '<p>' . $single_item['description'] . '</p>';
					}
					if ( isset( $single_item['prise'] ) && ! empty( $single_item['prise'] ) ) {
						$output .= '<h3>' . $single_item['prise'] . '</h3>';
					}

					$output .= '</li>';

				}

				$output .= '</ul>';
				if ( 'center' === $items_align ) {
					$output .= '</div>';
				}
			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Price_Menu' ) ) {
	$Crumina_Price_Menu = new Crumina_Price_Menu;
}
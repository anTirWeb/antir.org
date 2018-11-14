<?php
if ( ! class_exists( 'Crumina_Promo_Box' ) ) {

	class Crumina_Promo_Box {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'box_init' ) );
			add_shortcode( 'crumina_promo_box', array( &$this, 'box_form' ) );
		}

		function box_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'     => esc_html__( 'Polo Shop promo box', 'polo_extension' ),
						'base'     => 'crumina_promo_box',
						'icon'     => 'promo-shop',
						'category' => esc_html__( 'Polo Woocommerce', 'polo_extension' ),
						'params'   => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'polo_extension' ),
								'param_name' => 'title',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Description', 'polo_extension' ),
								'param_name' => 'description',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Button text', 'polo_extension' ),
								'param_name' => 'button_text',
							),
							array(
								'type'        => 'vc_link',
								'class'       => '',
								'heading'     => esc_html__( 'Button link ', 'polo_extension' ),
								'param_name'  => 'button_link',
								'value'       => '',
								'description' => esc_html__( 'You can link or remove the existing link on the button from here.', 'polo_extension' ),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Text align', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Right', 'polo_extension' )  => 'right',
									esc_html__( 'Center', 'polo_extension' ) => 'center',
								),
								'param_name' => 'text_align',
								'group'      => esc_html__( 'Styling', 'polo_extension' ),
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Text color', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Dark', 'polo_extension' )   => 'dark',
									esc_html__( 'Light', 'polo_extension' )  => 'light',
									esc_html__( 'Custom', 'polo_extension' ) => 'custom',
								),
								'param_name' => 'text_color',
								'group'      => esc_html__( 'Styling', 'polo_extension' ),
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Button type', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Default', 'polo_extension' )     => 'default',
									esc_html__( '3D', 'polo_extension' )          => '3d',
									esc_html__( 'Bordered', 'polo_extension' )    => 'bordered',
									esc_html__( 'Transparent', 'polo_extension' ) => 'transparent',
								),
								'admin_label'      => true,
								'param_name'       => 'button_type',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'group'      => esc_html__( 'Styling', 'polo_extension' ),
							),
							array(
								"type"             => "dropdown",
								"class"            => "",
								"heading"          => esc_html__( "Color", 'polo_extension' ),
								"param_name"       => "button_color",
								"value"            => array(
									esc_html__( 'None', 'polo_extension' )           => '',
									esc_html__( 'Aqua', 'polo_extension' )           => 'aqua',
									esc_html__( 'Colored', 'polo_extension' )        => 'color',
									esc_html__( 'Blue default', 'polo_extension' )   => 'blue',
									esc_html__( 'Blue dark', 'polo_extension' )      => 'blue-dark',
									esc_html__( 'Shark', 'polo_extension' )          => 'shark',
									esc_html__( 'Purple light', 'polo_extension' )   => 'purple-light',
									esc_html__( 'Purple default', 'polo_extension' ) => 'purple',
									esc_html__( 'Purple dark', 'polo_extension' )    => 'purple-dark',
									esc_html__( 'Red dark', 'polo_extension' )       => 'red-dark',
									esc_html__( 'Red default', 'polo_extension' )    => 'red',
									esc_html__( 'Red light', 'polo_extension' )      => 'red-light',
									esc_html__( 'Pink dark', 'polo_extension' )      => 'pink-dark',
									esc_html__( 'Pink default', 'polo_extension' )   => 'pink',
									esc_html__( 'Orange dark', 'polo_extension' )    => 'orange-dark',
									esc_html__( 'Orange default', 'polo_extension' ) => 'orange',
									esc_html__( 'Amber', 'polo_extension' )          => 'amber',
									esc_html__( 'Green', 'polo_extension' )          => 'green',
									esc_html__( 'Orange light', 'polo_extension' )   => 'orange-light',
									esc_html__( 'Yellow', 'polo_extension' )         => 'yellow',
									esc_html__( 'Brown default', 'polo_extension' )  => 'brown',
									esc_html__( 'Brown light', 'polo_extension' )    => 'brown-light',
									esc_html__( 'Black default', 'polo_extension' )  => 'black',
									esc_html__( 'Black light', 'polo_extension' )    => 'black-light',
									esc_html__( 'Grey dark', 'polo_extension' )      => 'grey-dark',
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'group'      => esc_html__( 'Styling', 'polo_extension' ),
								'dependency'       => array(
									'element'            => 'button_type',
									'value_not_equal_to' => 'transparent'
								)
							),
							array(
								'type'       => 'colorpicker',
								'class'      => '',
								'heading'    => esc_html__( 'Custom text color', 'polo_extension' ),
								'param_name' => 'custom_text_color',
								'value'      => '',
								'group'      => esc_html__( 'Styling', 'polo_extension' ),
								'dependency' => array( 'element' => 'text_color', 'value' => 'custom' )
							),
							array(
								'type'             => 'attach_image',
								'heading'          => esc_html__( 'Background image', 'polo_extension' ),
								'param_name'       => 'bg_image',
								'value'            => '',
								'admin_label'      => true,
								'group'            => esc_html__( 'Styling', 'polo_extension' ),
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Border width', 'polo_extension' ),
								'param_name'       => 'border_width',
								'min'              => 0,
								'std'              => 8,
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								'group'            => esc_html__( 'Styling', 'polo_extension' ),
							),
							array(
								'type'             => 'colorpicker',
								'class'            => '',
								'heading'          => esc_html__( 'Border Color', 'polo_extension' ),
								'param_name'       => 'border_color',
								'value'            => '#eee',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
								'group'            => esc_html__( 'Styling', 'polo_extension' ),
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
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Animation delay', 'polo_extension' ),
								'param_name' => 'animation_delay',
								'value'      => array(
									esc_html__( 'none', 'polo_extension' )   => '0',
									'0.5 sec'                                => '500',
									'1.0 sec'                                => '1000',
									'1.5 sec'                                => '1500',
									'2.0 sec'                                => '2000',
									'2.5 sec'                                => '2500',
									esc_html__( 'custom', 'polo_extension' ) => 'custom',
								),
								'group'      => esc_html__( 'Animation', 'polo_extension' ),
								'dependency' => Array(
									'element'   => 'animation',
									'not_empty' => true
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Custom animation delay', 'polo_extension' ),
								'param_name'  => 'custom_delay',
								'description' => esc_html__( 'Custom animation delay in milliseconds', 'polo_extension' ),
								'group'       => esc_html__( 'Animation', 'polo_extension' ),
								'dependency'  => Array(
									'element' => 'animation_delay',
									'value'   => 'custom'
								),
							),
						)
					)
				);
			}

		}

		function box_form( $atts, $content = null ) {

			$output = $title = $description = $button_text = $button_link = $text_align = $text_color = $custom_text_color = '';

			$bg_image = $border_width = $border_color = $block_style = '';
			$button_type = $button_color = '';
			$button_class = array();
			$el_class = $animation = $animation_delay = $custom_delay = '';

			extract(
				shortcode_atts(
					array(
						'title'             => '',
						'description'       => '',
						'button_text'       => '',
						'button_link'       => '',
						'text_align'        => 'left',
						'text_color'        => 'dark',
						'custom_text_color' => '',
						'button_color'      => '',
						'button_type'       => '',
						'bg_image'          => '',
						'border_width'      => '8',
						'border_color'      => '#eee',
						'el_class'          => '',
						'animation'         => '',
						'animation_delay'   => '0',
						'custom_delay'      => '',
					), $atts
				)
			);

			$animation_data = $animation_data_delay = $color_class = '';

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

			if ( function_exists( 'vc_build_link' ) ) {
				$href = vc_build_link( $button_link );
			}

			if ( isset( $href['url'] ) && ! empty( $href['url'] ) ) {
				$link = $href['url'];
			} else {
				$link = '#';
			}

			$image_url = wp_get_attachment_image_src( $bg_image, 'full' );
			$image_url = polo_theme_thumb( $image_url[0], '550', '382', true, 'c' );


			$block_style .= 'style="';
			if ( isset( $image_url ) && ! empty( $image_url ) ) {
				$block_style .= 'background-image:url(' . $image_url . ');';
			}
			$block_style .= 'border-color:' . $border_color . ';';
			$block_style .= 'border-width:' . $border_width . 'px;';
			if ( 'custom' === $text_color && isset( $custom_text_color ) && ! empty( $custom_text_color ) ) {
				$block_style .= 'color:' . $custom_text_color . ';';
			}
			$block_style .= '"';

			if ( 'light' === $text_color ) {
				$color_class = 'text-light';
			} elseif ( 'dark' === $text_color ) {
				$color_class = 'text-dark';
			} else {
				$color_class = 'text-custom';
			}

			$output .= '<div class="shop-promo-box text-' . $text_align . ' ' . $color_class . '" ' . $block_style . ' ' . $animation_data . ' ' . $animation_data_delay . '>';
			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h2>' . $title . '</h2>';
			}
			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<p class="m-b-0">' . $description . '</p>';
			}


			if ( '3d' === $button_type ) {
				$button_class[] = 'button-3d';
			} elseif ( 'bordered' === $button_type ) {
				$button_class[] = 'border';
			} elseif ( 'transparent' === $button_type ) {
				$button_class[] = 'transparent';
			}
			if ( isset( $button_color ) && ! empty( $button_color ) && ! ( 'transparent' === $button_type ) ) {
				$button_class[] = $button_color;
			} else {
				if ( 'light' === $text_color ) {
					$button_class[] = 'button-light';
				} elseif ( 'dark' === $text_color ) {
					$button_class[] = 'button-dark';
				}
			}
			$output .= '<a class="button rounded ' . esc_attr( implode( ' ', $button_class ) ) . '" href="' . $link . '">';
			$output .= $button_text;
			$output .= '</a>';

			$output .= '</div>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Promo_Box' ) ) {
	$Crumina_Promo_Box = new Crumina_Promo_Box;
}
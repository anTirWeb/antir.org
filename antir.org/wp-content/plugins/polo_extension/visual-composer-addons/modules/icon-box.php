<?php
if ( ! class_exists( 'Crumina_Icon_Box' ) ) {

	class Crumina_Icon_Box {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'icon_box_init' ) );
			add_shortcode( 'crumina_icon_box', array( &$this, 'icon_box_form' ) );
		}

		function icon_box_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Icon box", 'polo_extension' ),
						"base"                    => "crumina_icon_box",
						"icon"                    => "icon-box",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Style', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Default', 'polo_extension' ) => 'default',
										esc_html__( 'Clean', 'polo_extension' )   => 'clean',
										esc_html__( 'Border', 'polo_extension' )  => 'border',
										esc_html__( 'Fancy', 'polo_extension' )   => 'fancy',
										esc_html__( 'Grey', 'polo_extension' )    => 'grey',
										esc_html__( 'Colored', 'polo_extension' ) => 'colored',
										esc_html__( 'Boxed', 'polo_extension' )   => 'boxed',
									),
									'admin_label' => true,
									'param_name'  => 'style',
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Border style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Circle', 'polo_extension' ) => 'circle',
										esc_html__( 'Square', 'polo_extension' ) => 'square',
									),
									'param_name' => 'border_style',
									'dependency' => array(
										'element' => 'style',
										'value'   => array( 'default', 'border', 'grey', 'colored' ),
									)
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Animate style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'None', 'polo_extension' )        => '',
										esc_html__( 'Bounce', 'polo_extension' )      => 'bounce',
										esc_html__( 'Flash', 'polo_extension' )       => 'flash',
										esc_html__( 'Pulse', 'polo_extension' )       => 'pulse',
										esc_html__( 'Shake', 'polo_extension' )       => 'shake',
										esc_html__( 'Swing', 'polo_extension' )       => 'swing',
										esc_html__( 'Rubber band', 'polo_extension' ) => 'rubberBand',
										esc_html__( 'Tada', 'polo_extension' )        => 'tada',
										esc_html__( 'Wobble', 'polo_extension' )      => 'wobble',
									),
									'dependency' => array(
										'element' => 'style',
										'value'   => 'fancy',
									),
									'param_name' => 'animate_style',
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Boxed style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Default', 'polo_extension' ) => 'default',
										esc_html__( 'Process', 'polo_extension' ) => 'process',
									),
									'dependency' => array(
										'element' => 'style',
										'value'   => 'boxed',
									),
									'param_name' => 'boxed_style',
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Align', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Left', 'polo_extension' )   => 'left',
										esc_html__( 'Right', 'polo_extension' )  => 'right',
										esc_html__( 'Center', 'polo_extension' ) => 'center',
									),
									'admin_label'      => true,
									'param_name'       => 'align',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array(
										'element'            => 'style',
										'value_not_equal_to' => 'boxed',
									)
								),
								array(
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Size', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Normal', 'polo_extension' ) => 'default',
										esc_html__( 'Small', 'polo_extension' )  => 'small',
										esc_html__( 'Large', 'polo_extension' )  => 'large',
									),
									'admin_label'      => true,
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'param_name'       => 'size',
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),
								array(
									"type"       => "textfield",
									"class"      => "",
									"heading"    => esc_html__( "Title", 'polo_extension' ),
									"param_name" => "title",
									'group'      => esc_html__( 'Content', 'polo_extension' ),
								),
								array(
									"type"       => "textarea",
									"class"      => "",
									"heading"    => esc_html__( "Description", 'polo_extension' ),
									"param_name" => "description",
									'group'      => esc_html__( 'Content', 'polo_extension' ),
								),
							),
							crum_do_vc_map_icon( esc_html__( 'Icon', 'polo_extension' ) ),
							array(
								array(
									"type"        => "vc_link",
									"class"       => "",
									"heading"     => esc_html__( "Icon link ", 'polo_extension' ),
									"param_name"  => "icon_link",
									"value"       => "",
									'group'       => esc_html__( 'Icon', 'polo_extension' ),
									"description" => esc_html__( "You can link or remove the existing link on the button from here.", 'polo_extension' ),
								),
								array(
									"type"             => "checkbox",
									"class"            => "",
									"heading"          => esc_html__( "Use main site color for icon", 'polo_extension' ),
									"param_name"       => "main_site_color",
									"value"            => array(
										esc_html__( "Enable", 'polo_extension' ) => "1",
									),
									'dependency'       => array(
										'element' => 'style',
										'value'   => 'border'
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc no-top-padding',
									'group'            => esc_html__( 'Icon', 'polo_extension' ),
									"description"      => "",
								),
								array(
									"type"             => "colorpicker",
									"class"            => "",
									"heading"          => esc_html__( "Icon Color", 'polo_extension' ),
									"param_name"       => "icon_color",
									"value"            => "",
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'group'            => esc_html__( 'Icon', 'polo_extension' ),
									'dependency'       => array(
										'element' => 'style',
										'value'   => array( 'default', 'clean', 'border', 'fancy', 'boxed' )
									)
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
					)
				);
			}

		}

		function icon_box_form( $atts, $content = null ) {

			$style = $border_style = $boxed_style = $align = $size = $animate_style = $custom_delay = '';

			$title = $description = $el_class = $main_site_color = '';

			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = $icon_link = $icon_color = '';

			extract(
				shortcode_atts(
					array(
						'style'            => 'default',
						'border_style'     => 'circle',
						'boxed_style'      => 'default',
						'align'            => 'left',
						'size'             => 'default',
						'animate_style'    => '',
						'title'            => '',
						'description'      => '',
						'el_class'         => '',
						'icon_type'        => '',
						'icon_fontawesome' => 'fa fa-adjust',
						'icon_openiconic'  => 'vc-oi vc-oi-dial',
						'icon_typicons'    => 'typcn typcn-adjust-brightness',
						'icon_entypo'      => 'entypo-icon entypo-icon-note',
						'icon_linecons'    => 'vc_li vc_li-heart',
						'icon_custom_icon' => '',
						'icon_link'        => '',
						'icon_color'       => '',
						'main_site_color'  => '',
						'animation'        => '',
						'animation_delay'  => '0',
						'custom_delay'     => '',
					), $atts
				)
			);

			$output = $icon = $link = $animate_icon_data = $animation_data = $animation_data_delay = '';

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

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon_style = '';
				if ( isset( $icon_color ) && ! empty( $icon_color ) && ! ( 'grey' === $style ) && ! ( 'colored' === $style ) && ! ( '1' === $main_site_color ) ) {
					$icon_style .= 'style="';
					$icon_style .= 'color:' . $icon_color . '';
					$icon_style .= '"';
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ' . $icon_style . '></i>';
			}
			if ( isset( $main_site_color ) && ! ( '1' === $main_site_color ) && ! empty($icon_color)) {
				?>
				<style>
					.icon-box.effect .icon i:after {
						box-shadow: 0 0 0 3px <?php echo $main_site_color ?>;
					}
				</style>
				<?php

			}else{
				?>
				<style>
					.icon-box.effect .icon i:after {
						box-shadow: 0 0 0 3px <?php echo $icon_color ?>;
					}
					.icon-box.border.color .icon i{
						color: <?php echo $icon_color ?>;
					}
				</style>
				<?php
			}


			if ( function_exists( 'vc_build_link' ) ) {
				$href = vc_build_link( $icon_link );

			}
			if ( isset( $href['url'] ) && ! empty( $href['url'] ) ) {
				$link = $href['url'];
			}


			$class = array();

			$class[] = 'icon-box effect';

			if ( isset( $el_class ) && ! empty( $el_class ) ) {
				$class[] = $el_class;
			}

			if ( 'small' === $size ) {
				$class[] = 'small';
			} elseif ( 'large' === $size ) {
				$class[] = 'large';
			} else {
				$class[] = 'medium';
			}

			if ( 'clean' === $style ) {
				$class[] = 'clean';
			} elseif ( 'border' === $style ) {
				$class[] = 'border';
				if ( '1' === $main_site_color ) {
					$class[] = 'color';
				}
				if ( 'square' === $border_style ) {
					$class[] = 'square';
				}
			} elseif ( 'fancy' === $style ) {
				$class[] = 'fancy';

				if ( isset( $animate_style ) && ! empty( $animate_style ) ) {
					$animate_icon_data = 'data-animation="' . $animate_style . ' infinite"';
				}

			} elseif ( 'grey' === $style ) {
				$class[] = 'light';
				if ( 'square' === $border_style ) {
					$class[] = 'square';
				}
			} elseif ( 'colored' === $style ) {
				$class[] = 'color';
				if ( 'square' === $border_style ) {
					$class[] = 'square';
				}
			} elseif ( 'boxed' === $style ) {
				$class[] = 'center';
				if ( 'process' === $boxed_style ) {
					$class[] = 'process';
				} else {
					$class[] = 'box-type process';
				}
			} else {
				if ( 'square' === $border_style ) {
					$class[] = 'square';
				}
			}

			if ( 'center' === $align ) {
				$class[] = 'center';
			} elseif ( 'right' === $align ) {
				$class[] = 'icon-box-right medium';
			}

			$class = implode( ' ', $class );

			$output .= '<div class="' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			if ( isset( $icon ) && ! empty( $icon ) ) {
				$output .= '<div class="icon" ' . $animate_icon_data . ' style="border-color:'.$icon_color.'">';

				if ( isset( $link ) && ! empty( $link ) ) {
					$output .= '<a href="' . $link . '" target="'.(isset($href['target']) ? trim($href['target']) : '' ).'">';
				}
				$output .= $icon;
				if ( isset( $link ) && ! empty( $link ) ) {
					$output .= '</a>';
				}
				$output .= '</div>';
			}

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h3>' . $title . '</h3>';
			}

			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= wpautop( $description );
			}

			$output .= '</div>';//.$class

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Icon_Box' ) ) {
	$Crumina_Icon_Box = new Crumina_Icon_Box;
}
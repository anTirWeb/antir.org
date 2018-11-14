<?php
if ( ! class_exists( 'Crumina_Heading' ) ) {

	class Crumina_Heading {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'heading_init' ) );
			add_shortcode( 'crumina_heading', array( &$this, 'heading_form' ) );
		}

		function heading_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/headings/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Heading", 'polo_extension' ),
						"base"                    => "crumina_heading",
						"icon"                    => "icon-wpb-ui-custom_heading",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array_merge(
							array(
								array(
									'heading'     => esc_html__( 'Layout', 'polo_extension' ),
									'description' => '',
									'type'        => 'radio_image_select',
									'param_name'  => 'layout',
									'options'     => array(
										'underlined'        => $assets_dir . 'underlined.png',
										'simple'            => $assets_dir . 'simple.png',
										'simple_icon'       => $assets_dir . 'simple-icon.png',
										'medium'            => $assets_dir . 'medium.png',
										'medium_underlined' => $assets_dir . 'medium-underlined.png',
										'large'             => $assets_dir . 'large-title.png',
										'subtitle'          => $assets_dir . 'subtitle.png',
										'decorated'         => $assets_dir . 'decorated.png',
										'custom'            => $assets_dir . 'custom.png',
									),
									'std'         => 'default',
									'group'       => esc_attr__( 'Layout', 'polo_extension' ),
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Section heading', 'polo_extension' ) => 'section',
										esc_html__( 'Module heading', 'polo_extension' )  => 'module',
									),
									'param_name' => 'style',
									'dependency' => array(
										'element' => 'layout',
										'value'   => 'custom'
									),
								),
								array(
									'type'       => 'textarea',
									'heading'    => esc_html__( 'Heading', 'polo_extension' ),
									'param_name' => 'heading',
									'dependency' => array(
										'element'            => 'layout',
										'value_not_equal_to' => 'subtitle'
									)
								),
								array(
									'type'       => 'textarea',
									'heading'    => esc_html__( 'Subheading', 'polo_extension' ),
									'param_name' => 'subheading',
									'dependency' => array(
										'element'            => 'layout',
										'value_not_equal_to' => 'decorated'
									)
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
									'type'             => 'dropdown',
									'heading'          => esc_html__( 'Text color', 'polo_extension' ),
									'value'            => array(
										esc_html__( 'Dark', 'polo_extension' )  => 'dark',
										esc_html__( 'Light', 'polo_extension' ) => 'light',
									),
									'param_name'       => 'heading_text_color',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array(
										'element'            => 'layout',
										'value_not_equal_to' => 'custom'
									),
								),
								array(
									'type'             => 'attach_image',
									'heading'          => esc_html__( 'Left image', 'polo_extension' ),
									'param_name'       => 'left_image',
									'value'            => '',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'decorated' )
								),
								array(
									'type'             => 'attach_image',
									'heading'          => esc_html__( 'Right image', 'polo_extension' ),
									'param_name'       => 'right_image',
									'value'            => '',
									'admin_label'      => true,
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'decorated' )
								),
								array(
									'type'             => 'number',
									'heading'          => esc_html__( 'Delimiter width (px)', 'polo_extension' ),
									'param_name'       => 'delim_width',
									'min'              => 0,
									'std'              => '30',
									'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
									'dependency'       => array(
										'element' => 'layout',
										'value'   => array( 'underlined', 'custom' )
									),
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Margin after heading', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'None', 'polo_extension' ) => '',
										'0px'                                  => 'm-b-0',
										'5px'                                  => 'm-b-5',
										'10px'                                 => 'm-b-10',
										'15px'                                 => 'm-b-15',
										'20px'                                 => 'm-b-20',
										'25px'                                 => 'm-b-25',
										'30px'                                 => 'm-b-30',
										'35px'                                 => 'm-b-35',
										'40px'                                 => 'm-b-40',
										'50px'                                 => 'm-b-50',
										'60px'                                 => 'm-b-60',
										'70px'                                 => 'm-b-70',
										'80px'                                 => 'm-b-80',
										'90px'                                 => 'm-b-90',
										'100px'                                => 'm-b-100',
										'150px'                                => 'm-b-150',
										'200px'                                => 'm-b-200',
									),
									'param_name' => 'heading_margin',
									'dependency' => array(
										'element'            => 'layout',
										'value_not_equal_to' => 'simple',
									)
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
									'dependency' => array(
										'element' => 'layout',
										'value'   => array( 'custom', 'decorated' )
									),
									'group'      => esc_html__( 'Title', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
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
									'dependency' => array(
										'element' => 'layout',
										'value'   => array( 'custom', 'decorated' )
									),
									'group'      => esc_html__( 'Title', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
								),
								array(
									'type'        => 'checkbox',
									'heading'     => esc_html__( 'Use custom font family?', 'crum' ),
									'param_name'  => 'heading_use_google_fonts',
									'value'       => array( esc_html__( 'Yes', 'crum' ) => 'yes' ),
									'description' => esc_html__( 'Use font family from google.', 'crum' ),
									'group'       => esc_html__( 'Title', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
									'dependency'  => array(
										'element' => 'layout',
										'value'   => array( 'custom', 'decorated' )
									),
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
								array(
									'type'       => 'crumina_font_container',
									'heading'    => '',
									'param_name' => 'subheading_font_options',
									'settings'   => array(
										'fields' => array(
											'tag' => 'span',
											'letter_spacing',
											'font_size',
											'line_height',
											'color',
											'font_style'
										),
									),
									'dependency' => array(
										'element' => 'layout',
										'value'   => 'custom'
									),
									'group'      => esc_html__( 'Subtitle', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
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
									'param_name' => 'subheading_font_weight',
									'dependency' => array(
										'element' => 'layout',
										'value'   => 'custom'
									),
									'group'      => esc_html__( 'Subtitle', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'subheading_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
									'group'       => esc_html__( 'Subtitle', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
									'dependency'  => array(
										'element' => 'layout',
										'value'   => 'custom'
									),
								),
								array(
									'type'        => 'checkbox',
									'heading'     => esc_html__( 'Use custom font family?', 'crum' ),
									'param_name'  => 'subheading_use_google_fonts',
									'value'       => array( esc_html__( 'Yes', 'crum' ) => 'yes' ),
									'description' => esc_html__( 'Use font family from google.', 'crum' ),
									'group'       => esc_html__( 'Subtitle', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
									'dependency'  => array(
										'element' => 'layout',
										'value'   => 'custom'
									),
								),
								array(
									'type'       => 'google_fonts',
									'param_name' => 'subheading_custom_fonts',
									'value'      => '',
									'group'      => esc_html__( 'Subtitle', 'crum' ) . ' ' . esc_attr__( 'Typography', 'crum' ),
									'settings'   => array(
										'fields' => array(
											'font_family_description' => esc_html__( 'Select font family.', 'crum' ),
											'font_style_description'  => esc_html__( 'Select font styling.', 'crum' ),
										),
									),
									'dependency' => array(
										'element' => 'subheading_use_google_fonts',
										'value'   => 'yes',
									),
								),
							),
							crum_do_vc_map_icon( esc_html__( 'Icon', 'polo_extension' ), array(
								'element' => 'layout',
								'value'   => 'simple_icon'
							) ),
							array(
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

		function heading_form( $atts, $content = null ) {

			$heading                 = $subheading = $align = $heading_text_color = $delim_width = $heading_margin = $style = $el_class = $animation = $animation_delay = $layout = $custom_delay = '';
			$heading_font_options    = $heading_use_google_fonts = $heading_custom_fonts = '';
			$subheading_font_options = $subheading_use_google_fonts = $subheading_custom_fonts = $subheading_class = '';
			$icon_type               = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';
			$left_image              = $right_image = '';
			$heading_font_weight     = $subheading_font_weight = '';
			extract(
				shortcode_atts(
					array(
						'heading'                     => '',
						'subheading'                  => '',
						'align'                       => 'left',
						'delim_width'                 => '30',
						'heading_margin'              => '',
						'heading_text_color'          => 'dark',
						'layout'                      => 'underlined',
						'style'                       => 'section',
						'el_class'                    => '',
						'left_image'                  => '',
						'right_image'                 => '',
						'heading_font_options'        => '',
						'heading_font_weight'         => '',
						'heading_use_google_fonts'    => '',
						'heading_custom_fonts'        => '',
						'subheading_font_options'     => '',
						'subheading_font_weight'      => '',
						'subheading_class'            => '',
						'subheading_use_google_fonts' => '',
						'subheading_custom_fonts'     => '',
						'icon_type'                   => '',
						'icon_fontawesome'            => 'fa fa-adjust',
						'icon_openiconic'             => 'vc-oi vc-oi-dial',
						'icon_typicons'               => 'typcn typcn-adjust-brightness',
						'icon_entypo'                 => 'entypo-icon entypo-icon-note',
						'icon_linecons'               => 'vc_li vc_li-heart',
						'icon_custom_icon'            => '',
						'animation'                   => '',
						'animation_delay'             => '0',
						'custom_delay'                => '',
					), $atts
				)
			);

			$output = $animation_data = $animation_data_delay = $delim_style = $align_class = '';

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

			if ( 'right' === $align ) {
				$align_class = 'text-right';
			} elseif ( 'center' === $align ) {
				$align_class = 'heading-center';
			} else {
				$align_class = 'text-left';
			}

			if ( 'light' === $heading_text_color ) {
				$color_class = 'text-light';
			} else {
				$color_class = '';
			}

			if ( isset( $heading_margin ) && ! empty( $heading_margin ) ) {
				$margin = $heading_margin;
			} else {
				$margin = '';
			}

			if ( 'custom' === $layout ) {

				$class = array();

				if ( ! ( 'module' === $style ) ) {
					$class[] = 'custom-heading';
				}

				if ( isset( $el_class ) && ! empty( $el_class ) ) {
					$class[] = $el_class;
				}

				$class = implode( ' ', $class );

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="' . $margin . ' ' . $class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

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

				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$subheading_font_options = _crum_parse_text_shortcode_params( $subheading_font_options, $subheading_class, $subheading_use_google_fonts, $subheading_custom_fonts );
					$subheading_style        = $subheading_font_options['style'];
					if ( isset( $subheading_font_weight ) && ! empty( $subheading_font_weight ) ) {
						if ( ! empty( $subheading_style ) ) {
							if ( true === $heading_font_options['bold'] ) {
								$subheading_style = str_replace( 'bold', $subheading_font_weight, $subheading_style );
							} else {
								$subheading_style = str_replace( 'style="', 'style="font-weight:' . $subheading_font_weight . '; ', $subheading_style );
							}
						} else {
							$subheading_style = 'style="font-weight:' . $subheading_font_weight . ';"';
						}
					}
					if ( ! ( 'module' === $style ) ) {
						$custom_class = 'class="' . $subheading_font_options['class'] . '"';
					} else {
						$custom_class = '';
					}
					$output .= '<' . $subheading_font_options['tag'] . ' ' . $custom_class . ' ' . $subheading_style . '>' . ( $subheading ) . '</' . $subheading_font_options['tag'] . '>';
				}

				$delim_style = '';

				if ( ( isset( $heading_font_options['color'] ) && ! empty( $heading_font_options['color'] ) ) || ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) ) {

					$delim_style .= 'style="';
					if ( isset( $heading_font_options['color'] ) && ! empty( $heading_font_options['color'] ) ) {
						$delim_style .= 'border-top-color:' . $heading_font_options['color'] . '; ';
					}
					if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
						$delim_style .= 'width:' . $delim_width . 'px;';
					}
					$delim_style .= '"';

				}

				if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
					$output .= '<span class="custom-heading-delim" ' . $delim_style . '></span>';
				}

				$output .= '</div>';//.$class
				$output .= '</div>';//.margin
			} elseif ( 'simple' === $layout ) {

				$output .= '<div class="' . $align_class . ' m-b-60">';

				$output .= '<div class=" ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h2>' . $heading . '</h2>';
				}
				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= wpautop( $subheading );
				}

				$output .= '</div>';//el_class
				$output .= '</div>';//.text-center m-b-60

			} elseif ( 'medium' === $layout ) {

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="' . $margin . ' ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';
				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h3 class="text-medium m-b-5">' . $heading . '</h3>';
				}
				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= wpautop( $subheading );
				}
				$output .= '</div>';/*el_class*/
				$output .= '</div>';/*margin*/

			} elseif ( 'large' === $layout ) {

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="' . $margin . ' ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h1 class="heading-jumbo">' . $heading . '</h1>';
				}

				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= '<p class="lead">' . $subheading . '</p>';
				}

				$output .= '</div>';/*el_class*/
				$output .= '</div>';/*margin*/

			} elseif ( 'subtitle' === $layout ) {

				$output .= '<div class=" ' . $color_class . '">';
				$output .= '<div class="' . $margin . ' ' . $align_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';
				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= '<p class="lead">' . $subheading . '</pclass>';
				}
				$output .= '</div>';/*el_class*/
				$output .= '</div>';/*margin*/

			} elseif ( 'medium_underlined' === $layout ) {


				if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
					$delim_style = 'style="width:' . $delim_width . 'px;"';
				}

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="custom-heading ' . $margin . '  ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h2>' . $heading . '</h2>';
				}

				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= '<p>' . $subheading . '</p>';
				}

				if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
					$output .= '<span class="custom-heading-delim" ' . $delim_style . '></span>';
				}

				$output .= '</div>';//.custom-heading
				$output .= '</div>';//.margin

			} elseif ( 'simple_icon' === $layout ) {

				if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
					if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
						vc_icon_element_fonts_enqueue( $icon_type );
					}
					$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
				} else {
					$icon = '';
				}

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="' . $margin . ' ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h4>' . $icon . ' ' . $heading . '</h4>';
				}
				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= '<p>' . $subheading . '</p>';
				}

				$output .= '</div>';/*el_class*/
				$output .= '</div>';/*margin*/

			} elseif ( 'decorated' === $layout ) {

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

					$output .= '<div class="' . $align_class . ' ">';
					$output .= '<' . $heading_font_options['tag'] . ' class="' . $margin . '" ' . $heading_style . '>';
					if ( isset( $left_image ) && ! empty( $left_image ) ) {
						$left_image_url = wp_get_attachment_image_src( $left_image, 'full' );
						$left_image_url = polo_theme_thumb( $left_image_url[0], '157', '78', true, 'c' );
						$output .= '<img src="' . $left_image_url . '">';
					}
					$output .= $heading;
					if ( isset( $right_image ) && ! empty( $right_image ) ) {
						$right_image_url = wp_get_attachment_image_src( $right_image, 'full' );
						$right_image_url = polo_theme_thumb( $right_image_url[0], '157', '78', true, 'c' );
						$output .= '<img src="' . $right_image_url . '">';
					}
					$output .= '</' . $heading_font_options['tag'] . '>';
					$output .= '</div>';/*align*/
				}

			} else {

				if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
					$delim_style = 'style="width:' . $delim_width . 'px;"';
				}

				$output .= '<div class=" ' . $align_class . '">';
				$output .= '<div class="custom-heading ' . $margin . ' ' . $color_class . ' ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

				if ( isset( $heading ) && ! empty( $heading ) ) {
					$output .= '<h2>' . $heading . '</h2>';
				}

				if ( isset( $subheading ) && ! empty( $subheading ) ) {
					$output .= '<span class="lead">' . $subheading . '</span>';
				}

				if ( isset( $delim_width ) && ! empty( $delim_width ) && ( $delim_width > 0 ) ) {
					$output .= '<span class="custom-heading-delim" ' . $delim_style . '></span>';
				}

				$output .= '</div>';//.custom-heading
				$output .= '</div>';//.margin

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Heading' ) ) {
	$Crumina_Heading = new Crumina_Heading;
}
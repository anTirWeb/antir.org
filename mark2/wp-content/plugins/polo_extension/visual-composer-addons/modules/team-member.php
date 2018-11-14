<?php
if ( ! class_exists( 'Crumina_Team_member' ) ) {

	class Crumina_Team_member {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'crum_team_member_init' ) );
			add_shortcode( 'crumina_team_member', array( &$this, 'crum_team_member_form' ) );
		}

		function crum_team_member_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Team member", 'polo_extension' ),
						"base"                    => "crumina_team_member",
						"icon"                    => "team-members",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' )      => 'default',
									esc_html__( 'Circle', 'polo_extension' )       => 'circle',
									esc_html__( 'Circle small', 'polo_extension' ) => 'circle_small',
									esc_html__( 'With hover', 'polo_extension' )   => 'hover',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
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
								'heading'    => esc_html__( 'Name', 'polo_extension' ),
								'param_name' => 'name',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Profession', 'polo_extension' ),
								'param_name' => 'profession',
							),
							array(
								'type'       => 'textarea_raw_html',
								'heading'    => esc_html__( 'Description', 'polo_extension' ),
								'param_name' => 'description',
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Social networks', 'polo_extension' ),
								'param_name' => 'soc_networks',
								'params'     => array(
									array(
										'type'       => 'dropdown',
										'heading'    => esc_html__( 'Social network', 'polo_extension' ),
										'value'      => array_flip( crum_soc_networks_list() ),
										'param_name' => 'soc_network',
									),
									array(
										"type"       => "textfield",
										"class"      => "",
										"heading"    => esc_html__( "Link ", 'polo_extension' ),
										"param_name" => "client_link",
										"value"      => "",
									),
								),
								'group'      => esc_html__( 'Social networks', 'polo_extension' ),
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

		function crum_team_member_form( $atts, $content = null ) {

			$output    = $style = $photo = $name = $profession = $description = $soc_networks = $el_class = $custom_delay = '';
			$animation = $animation_delay = $animation_data = $animation_data_delay = '';

			extract(
				shortcode_atts(
					array(
						'style'           => 'default',
						'photo'           => '',
						'name'            => '',
						'profession'      => '',
						'description'     => '',
						'soc_networks'    => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			$width  = '300';
			$height = '300';

			$animation_data = $animation_data_delay = '';

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
			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$soc_networks = (array) vc_param_group_parse_atts( $soc_networks );
			}

			if ( base64_encode( base64_decode( $description, true ) ) === $description ) {
				$description = rawurldecode( base64_decode( $description ) );
			}

			$soc_net_output = '';

			if ( isset( $soc_networks ) && ! empty( $soc_networks ) && is_array( $soc_networks ) && ! empty( $soc_networks[0]['client_link'] ) && isset( $soc_networks[0]['client_link'] ) ) {

				if ( 'hover' === $style ) {

					$soc_net_output .= '<p>';
					foreach ( $soc_networks as $single_socnetwork ) {
						if ( isset( $single_socnetwork['client_link'] ) && ! empty( $single_socnetwork['client_link'] ) ) {
							$client_link = $single_socnetwork['client_link'];
						if ( 'google' === $single_socnetwork['soc_network'] ) {
							$soc_net_output .= '<a href = "' . $client_link . '" ><i class="fa fa-google-plus" ></i ></a >';
						} elseif ( 'wikipedia' === $single_socnetwork['soc_network'] ) {
							$soc_net_output .= '<a href = "' . $client_link . '" ><i class="fa fa-wikipedia-w" ></i ></a >';
						} else {
							$soc_net_output .= '<a href = "' . $client_link . '" ><i class="fa fa-' . $single_socnetwork['soc_network'] . '" ></i ></a >';
						}
						}
					}
					$soc_net_output .= '</p>';

				} else {
					$soc_net_output .= '<div class="social-icons social-icons-border m-t-10 text-center">';
					$soc_net_output .= '<ul>';

					foreach ( $soc_networks as $single_socnetwork ) {
						if ( isset( $single_socnetwork['client_link'] ) && ! empty( $single_socnetwork['client_link'] ) ) {
							$client_link = $single_socnetwork['client_link'];

						if ( 'google' === $single_socnetwork['soc_network'] ) {
							$soc_net_output .= '<li class="social-' . $single_socnetwork['soc_network'] . '" ><a href = "' . $client_link . '" ><i class="fa fa-google-plus" ></i ></a ></li >';
						} elseif ( 'wikipedia' === $single_socnetwork['soc_network'] ) {
							$soc_net_output .= '<li class="social-' . $single_socnetwork['soc_network'] . '" ><a href = "' . $client_link . '" ><i class="fa fa-wikipedia-w" ></i ></a ></li >';
						} else {
							$soc_net_output .= '<li class="social-' . $single_socnetwork['soc_network'] . '" ><a href = "' . $client_link . '" ><i class="fa fa-' . $single_socnetwork['soc_network'] . '" ></i ></a ></li >';
						}
						}
					}

					$soc_net_output .= '</ul>';
					$soc_net_output .= '</div>';
				}
			}

			$img_class = array();

			if ( 'circle' === $style ) {
				$img_class[] = 'circle-image large';
			} elseif ( 'circle_small' === $style ) {
				$img_class[] = 'circle-image small';
			}

			$img_class = implode( ' ', $img_class );

			$desc_class = array();

			if ( ! ( 'default' === $style ) ) {
				$desc_class[] = 'text-center';
			}

			$desc_class = implode( ' ', $desc_class );

			$image_url = wp_get_attachment_image_src( $photo, 'full' );
			$image_url = polo_theme_thumb( $image_url[0], $width, $height, true, 'c' );

			$output .= '<div class="team-member '.$el_class.'" ' . $animation_data . ' ' . $animation_data_delay . '>';

			if ( ! ( 'hover' === $style ) ) {
				$output .= '<div class="image-box ' . $img_class . '">';
				$output .= '<img src="' . $image_url . '" alt="">';
				$output .= '</div>';//.image-box
			} else {
				$output .= '<div class="effect effect-default">';
				$output .= '<img src="' . $image_url . '" alt="">';
				$output .= '<div class="image-box-content">';
				$output .= $soc_net_output;
				$output .= '</div>';//.image-box-content
				$output .= '</div>';//.effect effect-default
			}
			$output .= '<div class="image-box-description ' . $desc_class . '">';
			if ( isset( $name ) && ! empty( $name ) ) {
				$output .= '<h4>' . $name . '</h4>';
			}
			if ( isset( $profession ) && ! empty( $profession ) ) {
				$output .= '<p class="subtitle">' . $profession . '</p>';
			}
			$output .= '<hr class="line">';
			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<div>' . $description . '</div>';
			}

			if ( ! ( 'hover' === $style ) ) {
				$output .= $soc_net_output;
			}

			$output .= '</div>';
			$output .= '</div>';//.team-member

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Team_member' ) ) {
	$Crumina_Team_member = new Crumina_Team_member;
}
<?php
if ( ! class_exists( 'Crumina_Subscribe_Form' ) ) {

	class Crumina_Subscribe_Form {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'subscribe_init' ) );
			add_shortcode( 'crumina_subscribe_form', array( &$this, 'subscribe_form' ) );
		}

		function subscribe_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/subscribe/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Subscribe form", 'polo_extension' ),
						"base"                    => "crumina_subscribe_form",
						"icon"                    => "subscribe-form",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array_merge(
							array(
								array(
									'heading'          => esc_html__( 'Layout', 'polo_extension' ),
									'description'      => '',
									'type'             => 'radio_image_select',
									'param_name'       => 'layout',
									'options'          => array(
										'style_1' => $assets_dir . 'simple.png',
										'style_2' => $assets_dir . 'extended.png',
									),
									'std'              => 'default',
								),
								array(
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Form align", 'polo_extension' ),
									"param_name"       => "form_align",
									"value"            => array(
										esc_html__( 'Left', 'polo_extension' )   => 'left',
										esc_html__( 'Right', 'polo_extension' )  => 'right',
										esc_html__( 'Center', 'polo_extension' ) => 'center',
									),
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
									"type"             => "dropdown",
									"class"            => "",
									"heading"          => esc_html__( "Description position", 'polo_extension' ),
									"param_name"       => "description_position",
									"value"            => array(
										esc_html__( 'Top', 'polo_extension' )    => 'top',
										esc_html__( 'Bottom', 'polo_extension' ) => 'bottom',
									),
								),

								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Email field placeholder', 'polo_extension' ),
									'param_name' => 'email_placeholder',
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Thanking message text', 'polo_extension' ),
									'param_name' => 'thankyou_mesage',
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'  => 'el_class',
									'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),

							),
							crum_do_vc_map_icon( esc_html__( 'Button', 'polo_extension' ) ),
							array(
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Button text', 'polo_extension' ),
									'param_name' => 'button_text',
									'group'      => esc_html__( 'Button', 'polo_extension' )
								),
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Button style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Default', 'polo_extension' ) => 'default',
										esc_html__( 'Light', 'polo_extension' )   => 'light',
									),
									'param_name' => 'button_style',
									'group'      => esc_html__( 'Button', 'polo_extension' ),
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Animation', 'polo_extension' ),
									'value'       => array_flip( crum_vc_animations() ),
									'admin_label' => true,
									'param_name'  => 'animation',
									'group'       => esc_html__( 'Animation', 'polo_extension' ),
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
								array(
									'type'             => 'tab_id',
									'param_name'       => 'form_id',
									'settings'         => array(
										'auto_generate' => true,
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'heading'          => esc_html__( 'Form ID', 'polo_extension' ),
								),
							)
						)
					)
				);

			}

		}

		function subscribe_form( $atts, $content = null ) {

			global $wpdb;

			$layout      = $form_align = $title = $description = $description_position = $email_placeholder = $animation = $animation_delay = $el_class = $custom_delay = '';
			$icon_type   = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';
			$button_text = $button_style = $form_id = $thankyou_mesage = '';
			extract(
				shortcode_atts(
					array(
						'layout'               => 'style_1',
						'form_align'           => 'left',
						'title'                => '',
						'description'          => '',
						'description_position' => 'top',
						'email_placeholder'    => '',
						'thankyou_mesage'      => '',
						'button_text'          => esc_html__( 'Subscribe', 'polo_extension' ),
						'button_style'         => 'default',
						'el_class'             => '',
						'icon_type'            => '',
						'icon_fontawesome'     => 'fa fa-adjust',
						'icon_openiconic'      => 'vc-oi vc-oi-dial',
						'icon_typicons'        => 'typcn typcn-adjust-brightness',
						'icon_entypo'          => 'entypo-icon entypo-icon-note',
						'icon_linecons'        => 'vc_li vc_li-heart',
						'icon_custom_icon'     => '',
						'animation'            => '',
						'animation_delay'      => '0',
						'custom_delay'         => '',
						'form_id'              => '',
					), $atts
				)
			);

			$animation_data = $animation_data_delay = '';

			$action = ( isset( $_SERVER["REQUEST_URI"] ) ) ? $_SERVER["REQUEST_URI"] : '';

			if ( 'light' === $button_style ) {
				$button_class = 'btn-white';
			} else {
				$button_class = 'btn-primary';
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

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
			} else {
				$icon = '<i class="fa fa-paper-plane"></i>';
			}

			$output = '';

			$output .= '<div class="widget clearfix widget-newsletter text-' . $form_align . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			$output .= '<form id="widget-subscribe-form" action="' . $action . '" class="form-inline" method="post" data-msg="' . $thankyou_mesage . '" data-error="' . esc_html__( 'Please, fill email field with correct info.', 'polo_extension' ) . '">';
			$output .= '<input class="crum_hiddenfield" name="crum_subscribe" type="hidden" value="1">';

			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h3>' . $title . '</h3>';
			}

			if ( isset( $description ) && ! empty( $description ) && ( 'top' === $description_position ) ) {
				$output .= '<small>' . $description . '</small>';
			}

			$output .= '<div class="input-group">';

			if ( 'style_2' === $layout ) {
				$output .= '<div class="input-group-addon">' . $icon . '</div>';
				$button_text = esc_html__( 'Subscribe', 'polo_extension' );
			} else {
				$button_text = $icon;
			}

			$output .= '<input class="form-control required email" name="crum_email" type="email" placeholder="' . $email_placeholder . '" required/>';

			$output .= '<span class="input-group-btn">';

			$output .= '<button type="submit" id="widget-subscribe-submit-button" class="btn ' . $button_class . '">' . $button_text . '</button>';

			$output .= '</span>';//.input-group-btn

			$output .= '</div>';//.input-group

			if ( isset( $description ) && ! empty( $description ) && ( 'bottom' === $description_position ) ) {
				$output .= '<small class="text-light">' . $description . '</small>';
			}

			$output .= '<div class="form-popup"><div class="form-popup-close-layer"></div><div class="form-popup-content"><div class="text"></div></div></div>';

			$output .= '</form>';

			$output .= '</div>';//.widget clearfix widget-newsletter

			if ( isset( $_POST['crum_subscribe'] ) && $_POST['crum_subscribe'] ) {

				$email = $_POST['crum_email'];
				if ( is_email( $email ) ) {
					$emails = $wpdb->get_col( "SELECT crum_email FROM  " . $wpdb->prefix . "crumsubscribe" );
					if ( ! ( in_array( $email, $emails ) ) ) {
						$wpdb->query( "insert into " . $wpdb->prefix . "crumsubscribe ( crum_email) values ( '" . esc_attr( $email ) . "')" );
					}
				}
			}

			return $output;


		}

	}

}

if ( class_exists( 'Crumina_Subscribe_Form' ) ) {
	$Crumina_Subscribe_Form = new Crumina_Subscribe_Form;
}
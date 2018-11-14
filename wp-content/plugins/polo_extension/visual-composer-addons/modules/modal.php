<?php
if ( ! class_exists( 'Crumina_Modal' ) ) {

	class Crumina_Modal {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'modal_init' ) );
			add_shortcode( 'crumina_modal', array( &$this, 'modal_form' ) );
		}

		function modal_init() {

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"                    => esc_html__( "Polo Modal", 'polo_extension' ),
						"base"                    => "crumina_modal",
						"class"                   => "",
						"icon"                    => "modal-box",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"as_parent"               => array( 'only' => array( 'vc_row_inner' ) ),
						"content_element"         => true,
						"js_view"                 => 'VcColumnView',
						"show_settings_on_create" => true,
						"params"                  => array_merge(
							array(
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
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Button text', 'polo_extension' ),
									'param_name'       => 'button_text',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'description'      => esc_html__( 'Add text for modal button' )
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'       => 'el_class',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'description'      => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),

							),
							crum_do_vc_map_icon( esc_html__( 'Icon', 'polo_extension' ) ),
							array(
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Modal size', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Medium', 'polo_extension' ) => 'medium',
										esc_html__( 'Small', 'polo_extension' )  => 'small',
										esc_html__( 'Large', 'polo_extension' )  => 'large',
									),
									'admin_label' => true,
									'param_name'  => 'size',
									'group'       => esc_html__( 'Modal window', 'polo_extension' ),
								),
								array(
									'type'       => 'textfield',
									'heading'    => esc_html__( 'Modal window title', 'polo_extension' ),
									'param_name' => 'modal_title',
									'group'      => esc_html__( 'Modal window', 'polo_extension' ),
								),
								array(
									'type'        => 'dropdown',
									'heading'     => esc_html__( 'Border', 'polo_extension' ),
									'value'       => array(
										esc_html__( 'Yes', 'polo_extension' ) => 'yes',
										esc_html__( 'No', 'polo_extension' )  => 'no',

									),
									'admin_label' => true,
									'param_name'  => 'border',
									'group'       => esc_html__( 'Modal window', 'polo_extension' ),
								),

							)
						)
					)
				);

			}

		}

		function modal_form( $atts, $content = null ) {

			$title = $description = $button_text = $el_class = $size = $modal_title = $modal_close_text = $second_button_text = $second_button_link = $el_id = $border = '';

			$icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_custom_icon = '';

			extract(
				shortcode_atts(
					array(
						'title'            => '',
						'description'      => '',
						'button_text'      => '',
						'el_class'         => '',
						'size'             => 'medium',
						'modal_title'      => '',
						'icon_type'        => '',
						'icon_fontawesome' => 'fa fa-adjust',
						'icon_openiconic'  => 'vc-oi vc-oi-dial',
						'icon_typicons'    => 'typcn typcn-adjust-brightness',
						'icon_entypo'      => 'entypo-icon entypo-icon-note',
						'icon_linecons'    => 'vc_li vc_li-heart',
						'icon_custom_icon' => '',
						'border'           => 'yes',
					), $atts
				)
			);

			$output = $icon = $size_class = '';

			if ( 'small' === $size ) {
				$size_class = 'modal-sm';
			} elseif ( 'large' === $size ) {
				$size_class = 'modal-lg';
			}

			$el_id = uniqid('modal');

			if ( empty( $button_text ) ) {
				$button_text = esc_html__( 'Modal', 'polo_extension' );
			}

			if ( isset( $icon_type ) && ! empty( $icon_type ) ) {
				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ! ( 'custom_icon' === $icon_type ) ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
				$icon = '<i class="' . ${'icon_' . $icon_type} . '" ></i>';
			}

			if ( 'yes' === $border){
				$border = 'jumbotron-border';
			}
			else{
				$border = 'jumbotron-border-none';
			}
			$output .= '<div class="modal-box ' . $el_class . '">';
			$output .= '<div class="jumbotron jumbotron-small ' . $border.'">';
			if ( isset( $title ) && ! empty( $title ) ) {
				$output .= '<h3>' . $title . '</h3>';
			}
			if ( isset( $description ) && ! empty( $description ) ) {
				$output .= '<p>' . wpautop( $description ) . '</p>';
			}
			$output .= '<a class="button color button-3d rounded effect icon-left" data-target="#modal-' . $el_id . '" data-toggle="modal" href=""><span>' . $icon . $button_text . '</span></a>';
			$output .= '</div>';//.jumbotron
			$output .= '</div>';//.text-center

			$output .= '<div class="modal fade" id="modal-' . $el_id . '" tabindex="-1" role="modal" aria-labelledby="modal-label" aria-hidden="true" style="display: none;">';

			$output .= '<div class="modal-dialog ' . $size_class . '">';

			$output .= '<div class="modal-content">';

			$output .= '<div class="modal-header">';
			$output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
			if ( isset( $modal_title ) && ! empty( $modal_title ) ) {
				$output .= '<h4 class="modal-title" id="modal-label">' . $modal_title . '</h4>';
			}
			$output .= '</div>';//.modal-header

			$output .= '<div class="modal-body">';
			$output .= '<div class="row">';
			$output .= do_shortcode( $content );
			$output .= '</div>';//.row
			$output .= '</div>';//.modal-body

			$output .= '</div>';//.modal-content

			$output .= '</div>';//.modal-dialog

			$output .= '</div>';//#modal

			return $output;

		}

	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Crumina_Modal extends WPBakeryShortCodesContainer {
	}

}

if ( class_exists( 'Crumina_Modal' ) ) {
	$Crumina_Modal = new Crumina_Modal;
}
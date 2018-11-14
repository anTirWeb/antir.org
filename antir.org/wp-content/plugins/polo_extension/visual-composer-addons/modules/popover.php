<?php
if ( ! class_exists( 'Crumina_Popover' ) ) {

	class Crumina_Popover {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'popover_init' ) );
			add_shortcode( 'crumina_popover', array( &$this, 'popover_form' ) );
		}

		function popover_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Button with popover", 'polo_extension' ),
						"base"                    => "crumina_popover",
						"icon"                    => "popover",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' )   => 'default',
									esc_html__( 'With HTML', 'polo_extension' ) => 'html',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Tooltip align', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Right', 'polo_extension' )  => 'right',
									esc_html__( 'Top', 'polo_extension' )    => 'top',
									esc_html__( 'Bottom', 'polo_extension' ) => 'bottom',
								),
								'admin_label' => true,
								'param_name'  => 'align',
								'dependency'  => array(
									'element' => 'style',
									'value'   => 'default'
								)
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Button text', 'polo_extension' ),
								'param_name' => 'button_text',
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Popover title', 'polo_extension' ),
								'param_name' => 'popover_title',
								'group'      => esc_html__( 'Popover', 'polo_extension' )
							),
							array(
								'type'       => 'textarea_html',
								'heading'    => esc_html__( 'Popover content', 'polo_extension' ),
								'param_name' => 'content',
								'group'      => esc_html__( 'Popover', 'polo_extension' )
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

		function popover_form( $atts, $content = null ) {

			$style = $align = $button_text = $button_style = $popover_title = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'         => 'default',
						'align'         => 'left',
						'button_text'   => '',
						'button_style'  => 'default',
						'popover_title' => '',
						'el_class'      => '',
					), $atts
				)
			);

			$output = $data_container = '';

			$button_class = 'btn btn-default';

			if ( 'html' === $style ) {
				$data_placement = 'top';
			} else {
				$data_placement = $align;
				$data_container = 'data-container="body"';
			}

			$output .= '<button type="button" class="' . $button_class . '" ' . $data_container . ' data-toggle="popover" data-placement="' . $data_placement . '" ';
			if ( isset( $popover_title ) && ! empty( $popover_title ) ) {
				$output .= 'title="' . $popover_title . '" ';
			}

			if ( isset( $content ) && ! empty( $content ) ) {
				$output .= 'data-content="' . ( htmlspecialchars( apply_filters( 'the_content', $content ) ) ) . '"';
			}
			$output .= '>';
			$output .= $button_text;
			$output .= ' </button>';

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Popover' ) ) {
	$Crumina_Popover = new Crumina_Popover;
}
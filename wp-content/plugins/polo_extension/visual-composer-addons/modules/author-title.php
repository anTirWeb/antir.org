<?php
if ( ! class_exists( 'Crumina_Author_Title' ) ) {

	class Crumina_Author_Title {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'title_init' ) );
			add_shortcode( 'crumina_author_title', array( &$this, 'title_form' ) );

		}

		function title_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Author Title", 'polo_extension' ),
						"base"                    => "crumina_author_title",
						"icon"                    => "icon-wpb-ui-custom_heading",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Heading', 'polo_extension' ),
								'param_name' => 'heading',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Align', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'Left', 'polo_extension' )   => 'left',
									esc_html__( 'Right', 'polo_extension' )  => 'right',
									esc_html__( 'Center', 'polo_extension' ) => 'center',
								),
								'param_name' => 'align',
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

		function title_form( $atts, $content = null ) {

			wp_enqueue_style('crum-author-title');

			$heading = $align = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'heading'  => '',
						'align'    => 'left',
						'el_class' => '',
					), $atts
				)
			);

			if(isset($heading) && !empty($heading)){

				$output .= '<div class="blog-author-title text-'.$align.'">';
				$output .= $heading;
				$output .= '</div>';

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Author_Title' ) ) {
	$Crumina_Author_Title = new Crumina_Author_Title;
}
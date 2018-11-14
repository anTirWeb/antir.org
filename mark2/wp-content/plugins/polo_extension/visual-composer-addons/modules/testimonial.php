<?php
if ( ! class_exists( 'Crumina_Testimonial' ) ) {

	class Crumina_Testimonial {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'testimonial_init' ) );
			add_shortcode( 'crumina_testimonial', array( &$this, 'testimonial_form' ) );
		}

		function testimonial_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Testimonial", 'polo_extension' ),
						"base"                    => "crumina_testimonial",
						"icon"                    => "testimonial",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Style', 'polo_extension' ),
								'value'       => array(
									esc_html__( 'Default', 'polo_extension' )  => 'default',
									esc_html__( 'Simple', 'polo_extension' )  => 'simple',
									esc_html__( 'Card box', 'polo_extension' ) => 'card_box',
								),
								'admin_label' => true,
								'param_name'  => 'style',
							),
							array(
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Name', 'polo_extension' ),
								'param_name'       => 'name',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Profession', 'polo_extension' ),
								'param_name'       => 'profession',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Testimonial text', 'polo_extension' ),
								'param_name' => 'description',
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
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Testimonial video', 'polo_extension' ),
								'param_name'       => 'video_url',
								'description'      => esc_html__( 'Link on embed video', 'polo_extension' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Transparent', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Disable', 'polo_extension' ) => '0',
									esc_html__( 'Enable', 'polo_extension' )  => '1',
								),
								'admin_label'      => true,
								'param_name'       => 'transparent',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'dependency'       => array(
									'element' => 'style',
									'value'   => 'default'
								)
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

		function testimonial_form( $atts, $content = null ) {

			$style = $name = $in_slider = $profession = $description = $photo = $video_url = $transparent = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'style'       => 'default',
						'name'        => '',
						'in_slider' => 'false',
						'profession'  => '',
						'description' => '',
						'transparent' => '0',
						'photo'       => '',
						'video_url'   => '',
						'el_class'    => '',
					), $atts
				)
			);

			$width  = '240';
			$height = '240';

			if ( isset( $photo ) && ! empty( $photo ) ) {
				$image_url = wp_get_attachment_image_src( $photo, 'full' );
				$image_url = polo_theme_thumb( $image_url[0], $width, $height, true, 'c' );
			}

			$output = $transparent_class = '';

			if ( 'card_box' === $style ) {

				$output .= '<div class="testimonial testimonial-card ' . $el_class . '">';
				$output .= ' <div class="testimonial-image">';
				if ( isset( $image_url ) && ! empty( $image_url ) ) {
					$output .= '<img class="round" src="' . esc_url( $image_url ) . '" alt="image">';
				}
				if ( isset( $name ) && ! empty( $name ) ) {
					$output .= '<h4>' . $name . '</h4>';
				}
				if ( isset( $profession ) && ! empty( $profession ) ) {
					$output .= '<p class="subtitle">' . $profession . '</p>';
				}
				$output .= '</div>';//.testimonial-image

				if ( isset( $video_url ) && ! empty( $video_url ) ) {
					$output .= '<p class="testimonial-video-button">';
					$output .= '<a href="' . esc_url( $video_url ) . '" data-lightbox-type="iframe"><i class="fa fa-play-circle-o"></i></a>';
					$output .= '</p>';//.testimonial-video-button
				}

				$output .= '<div class="testimonial-description">';
				if ( isset( $description ) && ! empty( $description ) ) {
					$output .= wpautop($description);
				}
				$output .= '</div>';
				$output .= '</div>';//.testimonial-card

			} else {

				if ( '1' === $transparent ) {
					$transparent_class = 'testimonial-transparent';
				}

				if('simple' === $style){
					$simple_class = 'testimonial-simple';
				}else{
					$simple_class = '';
				}

				$output .= '<div class="testimonial ' . $el_class . ' ' . $transparent_class . ' '.$simple_class.'">';

				if ( !('true' === $in_slider) || !('simple' === $style) ) {
					$output .= '<div class="testimonial-description">';
					if ( isset( $description ) && ! empty( $description ) ) {
						$output .= wpautop( $description );
					}

					if ( isset( $video_url ) && ! empty( $video_url ) ) {
						$output .= '<div class="testimonial-video-button">';
						$output .= '<a href="' . esc_url( $video_url ) . '" data-lightbox-type="iframe"><i class="fa fa-play-circle-o"></i></a>';
						$output .= '</div>';//.testimonial-video-button
					}

					$output .= '</div>';//.testimonial-description
				}
				$output .= '<div class="testimonial-image">';
				if ( isset( $image_url ) && ! empty( $image_url ) ) {
					$output .= '<img class="round" src="' . $image_url . '" alt="image">';
				}
				if ( isset( $name ) && ! empty( $name ) ) {
					$output .= '<h4>' . $name . '</h4>';
				}
				if ( isset( $profession ) && ! empty( $profession ) ) {
					$output .= '<p class="subtitle">' . $profession . '</p>';
				}
				$output .= '</div>';//.testimonial-image
				if ( 'true' === $in_slider && 'simple' === $style ) {
					$output .= '<div class="testimonial-description">';
					if ( isset( $description ) && ! empty( $description ) ) {
						$output .= wpautop( $description );
					}
					$output .= '</div>';//.testimonial-description
				}
				$output .= '</div>';
			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Testimonial' ) ) {
	$Crumina_Testimonial = new Crumina_Testimonial;
}
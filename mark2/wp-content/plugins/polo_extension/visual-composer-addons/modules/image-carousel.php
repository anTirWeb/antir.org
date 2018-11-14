<?php
if ( ! class_exists( 'Crumina_Image_Gallery' ) ) {

	class Crumina_Image_Gallery {

		function __construct() {
			add_action( 'vc_before_init', array( $this, 'gallery_init' ) );
			add_shortcode( 'crumina_image_gallery', array( &$this, 'gallery_form' ) );
		}

		function gallery_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Image carousel", 'polo_extension' ),
						"base"                    => "crumina_image_gallery",
						"icon"                    => "icon-wpb-images-carousel",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'        => 'attach_images',
								'heading'     => esc_html__( 'Galllery images', 'polo_extension' ),
								'param_name'  => 'gallery',
								'value'       => '',
								'description' => esc_html__( 'Select images from media library.', 'polo_extension' ),
							),
                            array(
                                'type'        => 'checkbox',
                                'heading'     => esc_html__( 'Use caption instead of title?', 'polo_extension' ),
                                'param_name'  => 'use_caption',
                                'value'       => array(esc_html__('Yes', 'polo_extension') => true),
                            ),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Simple', 'polo_extension' )                 => 'default',
									esc_html__( 'With lightbox', 'polo_extension' )          => 'lightbox',
								),
								'admin_label'      => true,
								'param_name'       => 'style',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Controls style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Dots', 'polo_extension' )   => 'dots',
									esc_html__( 'Arrows', 'polo_extension' ) => 'arrows',
								),
								'admin_label'      => true,
								'param_name'       => 'controls_style',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name'       => 'slides_to_show',
								'min'              => 0,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image width', 'polo_extension' ),
								'param_name'       => 'custom_image_width',
								'min'              => 0,
								'std'              => '600',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
                                'description'      => esc_html__('Enter 0 for max width', 'polo_extension'),
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image height', 'polo_extension' ),
								'param_name'       => 'custom_image_height',
								'min'              => 0,
								'std'              => '400',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
                                'description'      => esc_html__('Enter 0 for max height', 'polo_extension'),
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

		function gallery_form( $atts, $content = null ) {

			$gallery = $style = $controls_style = $slides_to_show = $custom_image_width = $custom_image_height = $el_class = $use_caption = '';

			extract(
				shortcode_atts(
					array(
						'gallery'             => '',
						'style'               => 'default',
						'controls_style'      => 'dots',
						'slides_to_show'      => '3',
						'custom_image_width'  => '600',
						'custom_image_height' => '400',
						'el_class'            => '',
                        'use_caption'         => '',
					), $atts
				)
			);

			$gallery = explode( ',', $gallery );

            $width = $custom_image_width;
            $height = $custom_image_height;

			$data_dots = '';

			if ( 'dots' === $controls_style ) {
				$data_dots = 'data-carousel-dots="true"';
			}

			$output = '';

			$output .= '<div class="carousel" data-carousel-col="' . $slides_to_show . '" ' . $data_dots . ' data-lightbox-type="gallery">';

			foreach ( $gallery as $single_id ) {
				$image_full = wp_get_attachment_image_src( $single_id, 'full' );
				$image_url  = polo_theme_thumb( $image_full[0], $width, $height, true, 'c' );

				if ( 'lightbox' === $style ) {

                    $title = $use_caption ? wp_get_attachment_caption($single_id) : get_the_title( $single_id );
					$output .= '<div class="effect effect-default">';
					$output .= '<img src="' . $image_url . '" alt="">';
					$output .= '<div class="image-box-content">';
					$output .= '<p>';
					$output .= '<a href="' . $image_full[0] . '" title="' . $title . '" data-lightbox="gallery-item"><i class="fa fa-expand"></i></a>';
					$output .= '</p>';
					$output .= '</div>';
					$output .= '</div>';

				} else {
					$output .= '<img src="' . $image_url . '"/>';
				}
			}

			$output .= '</div>';//.carousel

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Image_Gallery' ) ) {
	$Crumina_Image_Gallery = new Crumina_Image_Gallery;
}
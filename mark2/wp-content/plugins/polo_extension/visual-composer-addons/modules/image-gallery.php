<?php
if ( ! class_exists( 'Crumina_Image_Grid' ) ) {

	class Crumina_Image_Grid {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'gallery_init' ) );
			add_shortcode( 'crumina_image_grid', array( &$this, 'gallery_form' ) );
		}

		function gallery_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/gallery/' );

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Image gallery", 'polo_extension' ),
						"base"                    => "crumina_image_grid",
						"icon"                    => "icon-wpb-images-stack",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'default'       => $assets_dir . 'grid.png',
									'poster'        => $assets_dir . 'poster.png',
									'masonry'       => $assets_dir . 'masonry.png',
									'large_masonry' => $assets_dir . 'vertical+small.png',
								),
								'std'         => 'default',
								'group'       => esc_attr__( 'Layout', 'polo_extension' ),
							),
							array(
								'type'        => 'attach_images',
								'heading'     => esc_html__( 'Grid images', 'polo_extension' ),
								'param_name'  => 'images',
								'value'       => '',
								'description' => esc_html__( 'Select images from media library.', 'polo_extension' ),
							),
							array(
								'type'       => 'checkbox',
								'heading'    => esc_html__( 'Change images size?', 'polo_extension' ),
								'param_name' => 'custom_size',
								'value'      => array( esc_html__( 'Yes', 'polo_extension' ) => true ),
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image width', 'polo_extension' ),
								'param_name'       => 'image_width',
								'min'              => 0,
								'std'              => '180',
								'edit_field_class' => 'vc_column vc_col-sm-2 crum_vc',
								'dependency'       => array( 'element' => 'custom_size', 'value' => '1' )
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Image height', 'polo_extension' ),
								'param_name'       => 'image_height',
								'min'              => 0,
								'std'              => '180',
								'edit_field_class' => 'vc_column vc_col-sm-2 crum_vc',
								'dependency'       => array( 'element' => 'custom_size', 'value' => '1' )
							),
							array(
								'type'       => 'checkbox',
								'heading'    => esc_html__( 'Use caption instead of title?', 'polo_extension' ),
								'param_name' => 'use_caption',
								'value'      => array( esc_html__( 'Yes', 'polo_extension' ) => true ),
							),

							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Columns number', 'polo_extension' ),
								'value'            => array(
									'2 ' . esc_html__( 'columns', 'polo_extension' ) => '2',
									'3 ' . esc_html__( 'columns', 'polo_extension' ) => '3',
									'4 ' . esc_html__( 'columns', 'polo_extension' ) => '4',
									'5 ' . esc_html__( 'columns', 'polo_extension' ) => '5',

								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'std'              => '2',
								'param_name'       => 'columns_number',
								'dependency'       => array( 'element' => 'layout', 'value' => array( 'default', 'poster' ) )
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Item space', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'none', 'polo_extension' ) => 'none',
									'1%'                                   => '1',
									'2%'                                   => '2',
									'3%'                                   => '3',
									'4%'                                   => '4',

								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'std'              => 'none',
								'param_name'       => 'item_space',
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

		function gallery_form( $atts, $content = null ) {

			$layout         = $images = $columns_number = $item_space = $el_class = $use_caption = '';
			$custom_size    = $image_width = $image_height = '';
			$animation      = $animation_delay = $custom_delay = '';
			$animation_data = $animation_data_delay = '';
			extract(
				shortcode_atts(
					array(
						'layout'          => 'default',
						'images'          => '',
						'columns_number'  => '2',
						'item_space'      => 'none',
						'custom_size'     => '',
						'image_width'     => '180',
						'image_height'    => '180',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
						'use_caption'     => '',
					), $atts
				)
			);

			$images = explode( ',', $images );

			$output = '';

			if ( 'poster' === $layout ) {
				$width  = '400 ';
				$height = '600';
			} elseif ( 'masonry' === $layout ) {
				$width  = '600';
				$height = array( '400', '900' );
			} else {
				$width  = '595';
				$height = '397';
			}
			if ( $custom_size ) {
				$width  = $image_width;
				$height = $image_height;
			}

			if ( 'masonry' === $layout || 'large_masonry' === $layout ) {
				$columns_number = '4';
			}

			if ( ! ( 'none' === $item_space ) ) {
				$space = 'data-isotope-item-space="' . $item_space . '"';
			} else {
				$space = '';
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

			$output .= '<div id="isotope" class="isotope col-small-margins" data-isotope-mode="masonry" data-isotope-col="' . $columns_number . '" data-lightbox-type="gallery" ' . $space . ' ' . $animation_data . ' ' . $animation_data_delay . '>';

			if ( isset( $images ) && ! empty( $images ) && is_array( $images ) ) {

				$i         = $j = 0;
				$indexes   = array( '0', '2', '6', '7' );
				$indexes_j = array( '0', '2' );
				foreach ( $images as $singe_image_id ) {

					$image_full = wp_get_attachment_image_src( $singe_image_id, 'full' );
					if ( 'masonry' === $layout ) {
						if ( in_array( $i, $indexes ) ) {
							$image_url = polo_theme_thumb( $image_full[0], $width, $height[0], true, 'c' );
						} else {
							$image_url = polo_theme_thumb( $image_full[0], $width, $height[1], true, 'c' );
						}
					} elseif ( 'large_masonry' === $layout ) {

						if ( in_array( $j, $indexes_j ) ) {
							$image_url = polo_theme_thumb( $image_full[0], '400', '800', true, 'c' );
						} else {
							$image_url = polo_theme_thumb( $image_full[0], '600', '400', true, 'c' );
						}

					} else {
						$image_url = polo_theme_thumb( $image_full[0], $width, $height, true, 'c' );
					}

					$title  = $use_caption ? wp_get_attachment_caption( $singe_image_id ) : get_the_title( $singe_image_id );
					$output .= '<div class="isotope-item">';
					$output .= '<div class="effect effect-default">';
					$output .= '<img src="' . esc_url( $image_url ) . '" alt="' . $j . '">';
					$output .= '<div class="image-box-content">';
					$output .= '<p>';
					$output .= '<a href="' . esc_url( $image_full[0] ) . '" title="' . $title . '" data-lightbox="gallery-item"><i class="fa fa-expand"></i></a>';
					$output .= '</p>';
					$output .= '</div>';//.image-box-content
					$output .= '</div>';//.effect-default
					$output .= '</div>';//.isotope-item

					$i ++;
					$j ++;
					if ( 8 === $i ) {
						$i = 0;
					}
					if ( $j === 8 ) {
						$j = 0;
					}
				}

			}

			$output .= '</div>';//#isotope

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Image_Grid' ) ) {
	$Crumina_Image_Grid = new Crumina_Image_Grid;
}
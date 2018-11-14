<?php
if ( ! class_exists( 'Crumina_Category_Box' ) ) {

	class Crumina_Category_Box {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'box_init' ) );
			add_shortcode( 'crumina_category_box', array( &$this, 'box_form' ) );
		}

		function crumina_product_categories() {

			$product_cats = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			) );

			$output = array();

			if ( ! ( is_wp_error( $product_cats ) ) ) {

				foreach ( $product_cats as $single_category ) {
					$output[ $single_category->name ] = $single_category->term_id;
				}

			}

			return $output;

		}

		function box_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'     => esc_html__( 'Polo Product category box', 'polo_extension' ),
						'base'     => 'crumina_category_box',
						'icon'     => 'product-category',
						'category' => esc_html__( 'Polo Woocommerce', 'polo_extension' ),
						'params'   => array(
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Select category', 'polo_extension' ),
								'param_name' => 'category',
								'value'      => $this->crumina_product_categories(),
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

		function box_form( $atts, $content = null ) {

			$output = $category = $el_class = $animation = $animation_delay = $custom_delay = '';

			$categories = $this->crumina_product_categories();
			$i          = 0;
			foreach ( $categories as $cat ) {
				if ( 0 === $i ) {
					$default = $cat;
				}
				$i ++;
			}
			extract(
				shortcode_atts(
					array(
						'category'        => $default,
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
					), $atts
				)
			);

			$category_data = get_term_by( 'id', $category, 'product_cat', 'ARRAY_A' );

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

			$cat_link = get_term_link( intval($category), 'product_cat' );
			$output .= '<div class="shop-category-box ' . $el_class . '" ' . $animation_data . ' ' . $animation_data_delay . '>';

			if ( function_exists( 'get_woocommerce_term_meta' ) ) {
				$thumbnail_id       = get_woocommerce_term_meta( $category_data['term_id'], 'thumbnail_id', true );
				$category_thumbnail = wp_get_attachment_url( $thumbnail_id );
				if ( isset( $category_thumbnail ) && ! empty( $category_thumbnail ) ) {
					$image = $category_thumbnail;
				} else {
					$image = wc_placeholder_img_src();
				}
			} else {
				$image = wc_placeholder_img_src();
			}

			if (!empty($image)){
				$output .= '<img src="' . esc_url( polo_theme_thumb( $image, '263', '354', true ) ) . '">';
			}
			$output .= '<div class="shop-category-box-title text-center">';
			$output .= '<h6>' . $category_data['name'] . '</h6>';
			$output .= '<small>' . $category_data['count'] . esc_html__( 'products', 'polo_extension' ) . '</small>';
			$output .= '</div>';/*shop-category-box-title text-center*/

			if ( ! is_wp_error( $cat_link ) ) {
				$output .= '<a class="bg-span" href="' . $cat_link . '"></a>';
			}

			$output .= '</div>';//shop-category-box

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Category_Box' ) ) {
	$Crumina_Category_Box = new Crumina_Category_Box;
}
<?php
if ( ! class_exists( 'Crumina_Boxed_Slider' ) ) {

	class Crumina_Boxed_Slider {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'slider_init' ) );
			add_shortcode( 'crumina_boxed_post_slider', array( &$this, 'slider_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );

		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_boxed_posts_slider' ) ) {

				$tmp = get_option( 'crum_cached_boxed_posts_slider' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_posts_boxed_slider_transient' . $transient_id;
				update_option( 'crum_cached_boxed_posts_slider', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_posts_boxed_slider_transient' . $transient_id;

				add_option( 'crum_cached_boxed_posts_slider', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_boxed_posts_slider' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_boxed_posts_slider' );
		}

		function slider_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"     => esc_html__( "Polo Posts Boxed Slider", 'polo_extension' ),
						"base"     => "crumina_boxed_post_slider",
						"icon"     => "icon-wpb-slideshow",
						"category" => esc_html__( 'Polo Modules', 'polo_extension' ),
						"params"   => array(
							array(
								"type"       => "dropdown",
								"heading"    => esc_html__( "Which post display first?", 'polo_extension' ),
								"param_name" => "feat_sticky",
								"value"      => array(
									esc_html__( "Latest post", 'polo_extension' ) => "featured",
									esc_html__( "Sticky post", 'polo_extension' ) => "sticky",
								),
							),
							array(
								"type"        => "loop",
								"heading"     => esc_html__( "Loop parameters", 'polo_extension' ),
								"param_name"  => "loop",
								'settings'    => array(
									'size'      => array( 'hidden' => false, 'value' => 4 ),
									'post_type' => array( 'hidden' => true, 'value' => 'post' ),
									'order_by'  => array( 'value' => 'date' ),
									'tax_query' => array( 'hidden' => false, 'value' => '' ),
								),
								"description" => esc_html__( "Number of posts, Order parameters, Select category, Tags, Author, etc.", 'polo_extension' )
							),
							array(
								"type"       => "dropdown",
								"heading"    => esc_html__( "Text color", 'polo_extension' ),
								"param_name" => "text_color",
								"value"      => array(
									esc_html__( "Light", 'polo_extension' ) => "light",
									esc_html__( "Dark", 'polo_extension' )  => "dark",
								),
							),
							array(
								"type"       => "tab_id",
								"param_name" => "transient_id",
								'heading'    => esc_html__( 'Block ID', 'polo_extension' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => __( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
							),
						),
					)
				);
			}
		}

		function slider_form( $atts, $content = null ) {

			$feat_sticky = $loop = $text_color = $transient_id = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'feat_sticky'  => 'featured',
						'text_color'   => 'light',
						'loop'         => 'size:4|order_by:date|order:ASC|post_type:post',
						'transient_id' => '',
						'el_class'     => '',
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}
			$this->getLoop( $loop );


			$args = $this->loop_args;

			if ( ! ( isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'post';
			}
			if ( $feat_sticky == 'featured' ) {
				$args['ignore_sticky_posts'] = '1';
			}
			if ( function_exists( 'pll_current_language' ) ) {
				$transient_id = $transient_id . '_' . pll_current_language();
			}
			if ( false === ( $posts_boxed_slider_query = get_transient( 'crum_posts_boxed_slider_transient' . $transient_id ) ) ) {
				$posts_boxed_slider_query = new WP_Query( $args );

				set_transient( 'crum_posts_boxed_slider_transient' . $transient_id, $posts_boxed_slider_query );

				$this->update_id_option( $transient_id );
			}

			if ( $posts_boxed_slider_query->have_posts() ) {

				$output .= '<div id="slider-carousel" class="boxed-slider">';

				while ( $posts_boxed_slider_query->have_posts() ): $posts_boxed_slider_query->the_post();

					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					if ( ! empty( $post_thumbnail_id ) ) {
						$image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$image_url = polo_theme_thumb( $image_url[0], '1280', '854', true, 'c' );
					} else {
						$image_url = PLUGIN_URL . 'assets/img/no-image.png';
						$image_url = polo_theme_thumb( $image_url, '1280', '854', true, 'c' );
					}

					$output .= '<div style="background-image:url(' . esc_url( $image_url ) . ');" class="owl-bg-img background-overlay-one">';

					$output .= '<div class="container container-fullscreen">';

					$output .= '<div class="text-middle">';
					$output .= '<div class="text-center text-' . esc_attr( $text_color ) . '">';

					$post_categories = wp_get_post_categories( get_the_ID() );

					$cat = get_category( $post_categories[0] );
					$output .= '<h6>' . $cat->name . '</h6>';

					$output .= '<div class="seperator seperator-small no-padding"></div>';

					$output .= '<h1 class="text-uppercase">' . get_the_title( get_the_ID() ) . '</h1>';

					$output .= '<a class="button border rounded transparent" href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'Read more', 'polo_extension' ) . '</a>';

					$output .= '</div>';
					$output .= '</div>';/*text-middle*/

					$output .= '</div>';/*container*/

					$output .= '</div>';/*owl-bg-img*/

				endwhile;

				$output .= '</div>';

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Boxed_Slider' ) ) {
	$Crumina_Boxed_Slider = new Crumina_Boxed_Slider;
}
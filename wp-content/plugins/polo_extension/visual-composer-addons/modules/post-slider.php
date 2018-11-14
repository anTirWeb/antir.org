<?php
if ( ! class_exists( 'Crumina_Posts_Slider' ) ) {

	class Crumina_Posts_Slider {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'highlight_init' ) );
			add_shortcode( 'crumina_posts_slider', array( &$this, 'highlight_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );

		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_posts_slider' ) ) {

				$tmp = get_option( 'crum_cached_posts_slider' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_posts_slider_transient' . $transient_id;
				update_option( 'crum_cached_posts_slider', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_posts_slider_transient' . $transient_id;

				add_option( 'crum_cached_posts_slider', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_posts_slider' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_posts_slider' );
		}

		function highlight_init() {

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"     => esc_html__( "Polo Posts Slider", 'polo_extension' ),
						"base"     => "crumina_posts_slider",
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
								"type"             => "checkbox",
								"class"            => "",
								"heading"          => esc_html__( "Enable spaces", 'polo_extension' ),
								"param_name"       => "enable_spaces",
								"value"            => array(
									__( "Enable", 'polo_extension' ) => "1",
								),
								"description"      => esc_html__( 'Enable spaces between slides', 'polo_extension' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "checkbox",
								"class"            => "",
								"heading"          => esc_html__( "Show posts button", 'polo_extension' ),
								"param_name"       => "show_button",
								"value"            => array(
									__( "Enable", 'polo_extension' ) => "1",
								),
								"description"      => "",
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"heading"          => esc_html__( "Button text color", 'polo_extension' ),
								"param_name"       => "button_text_color",
								"value"            => array(
									esc_html__( "Dark", 'polo_extension' )  => "dark",
									esc_html__( "Light", 'polo_extension' ) => "light",
								),
								'dependency'       => array( 'element' => 'show_button', 'value' => '1' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"heading"          => esc_html__( "Button align", 'polo_extension' ),
								"param_name"       => "button_align",
								"value"            => array(
									esc_html__( "Left", 'polo_extension' )   => "left",
									esc_html__( "Right", 'polo_extension' )  => "right",
									esc_html__( "Center", 'polo_extension' ) => "center",
								),
								'dependency'       => array( 'element' => 'show_button', 'value' => '1' ),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								'type'       => 'textfield',
								'heading'    => __( 'Button text', 'js_composer' ),
								'param_name' => 'button_text',
								'dependency' => array( 'element' => 'show_button', 'value' => '1' ),
							),
							array(
								'type'             => 'number',
								'heading'          => esc_html__( 'Slides to show', 'polo_extension' ),
								'param_name'       => 'slides_to_show',
								'min'              => 0,
								'std'              => '3',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__( 'Enable auto-slide?', 'polo_extension' ),
                                'param_name' => 'slider_autoplay',
                                'description' => esc_html__( 'If checked, slider will auto slide with infinity loop.', 'polo_extension' ),
                                'value' => array( esc_html__( 'Yes', 'polo_extension' ) => true ),
                            ),
                            array(
                                'type' => 'number',
                                'heading' => esc_html__( 'Auto-slide delay', 'polo_extension' ),
                                'param_name' => 'slider_autoplay_delay',
                                'min'        => 0,
                                'std'        => 3,
                                'description' => esc_html__( 'Auto-slide delay between slides.', 'polo_extension' ),
                                'dependency' => array(
                                    'element' => 'slider_autoplay',
                                    'not_empty' => true,
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
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Margin after module', 'polo_extension' ),
								'value'      => array(
									esc_html__( 'None', 'polo_extension' ) => '',
									'0px'                                  => 'm-b-0',
									'5px'                                  => 'm-b-5',
									'10px'                                 => 'm-b-10',
									'15px'                                 => 'm-b-15',
									'20px'                                 => 'm-b-20',
									'25px'                                 => 'm-b-25',
									'30px'                                 => 'm-b-30',
									'35px'                                 => 'm-b-35',
									'40px'                                 => 'm-b-40',
									'50px'                                 => 'm-b-50',
									'60px'                                 => 'm-b-60',
									'70px'                                 => 'm-b-70',
									'80px'                                 => 'm-b-80',
									'90px'                                 => 'm-b-90',
									'100px'                                => 'm-b-100',
									'150px'                                => 'm-b-150',
									'200px'                                => 'm-b-200',
								),
								'param_name' => 'margin',
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

		function highlight_form( $atts, $content = null ) {

			$feat_sticky = $show_button = $slider_autoplay = $slider_autoplay_delay = $button_text_color = $button_align = $button_text = $margin = $enable_spaces = $auto_slides_delay = $slides_to_show = $loop = $transient_id = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'feat_sticky'       => 'featured',
						'show_button'       => '',
						'margin'       => '',
						'button_align'      => 'left',
						'button_text_color' => 'dark',
						'button_text'       => esc_html__( 'All stories in Highlights', 'polo_extension' ),
						'enable_spaces'     => '',
						'slides_to_show'    => '3',
						'slider_autoplay'       => '0',
						'slider_autoplay_delay'       => '0',
						'loop'              => 'size:4|order_by:date|order:ASC|post_type:post',
						'transient_id'      => '',
						'el_class'          => '',
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

			if ( false === ( $posts_slider_query = get_transient( 'crum_posts_slider_transient' . $transient_id ) ) ) {
				$posts_slider_query = new WP_Query( $args );

				set_transient( 'crum_posts_slider_transient' . $transient_id, $posts_slider_query );

				$this->update_id_option( $transient_id );
			}

			$spaces = '1' === $enable_spaces ? '' : 'data-carousel-margins="0"';

            $scroll_slides = '';
			if($slider_autoplay){
                $scroll_slides = 'data-carousel-autoplay="' . $slider_autoplay . '" data-carousel-autoplay-delay="' . $slider_autoplay_delay * 1000 . '"';
            }


			if ( $posts_slider_query->have_posts() ) {

				$output .= '<div class="grid-articles carousel post-carousel ' . $margin . ' ' . $el_class . '" ' . $scroll_slides . ' data-carousel-col="' . $slides_to_show . '" ' . $spaces . '>';

				while ( $posts_slider_query->have_posts() ): $posts_slider_query->the_post();

					$output .= '<article class="post-entry">';

					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					if ( ! empty( $post_thumbnail_id ) ) {
						$image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$image_url = polo_theme_thumb( $image_url[0], '525', '350', true, 'c' );
					} else {
						$image_url = PLUGIN_URL . 'assets/img/no-image.png';
						$image_url = polo_theme_thumb( $image_url, '525', '350', true, 'c' );
					}

					$output .= '<a href="#" class="post-image"><img alt="" src="' . esc_url( $image_url ) . '"></a>';

					$output .= '<div class="post-entry-overlay">';

					$output .= '<div class="post-entry-meta">';

					$output .= '<div class="post-entry-meta-category">';
					$post_categories = wp_get_post_categories( get_the_ID() );

					$cat = get_category( $post_categories[0] );
					$output .= '<span class="label label-danger">' . $cat->name . '</span>';
					$output .= '</div>';

					$output .= '<div class="post-entry-meta-title">';
					$output .= '<h2><a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a></h2>';
					$output .= '</div>';/*post-entry-meta-title*/

					$output .= '<span class="post-date"><i class="fa fa-clock-o"></i> ' . crumina_relative_time( get_post_time() ) . '</span>';

					$output .= '</div>';/*post-entry-meta*/

					$output .= '</div>';/*post-entry-overlay*/

					$output .= '</article>';/*post-entry*/

				endwhile;

				$output .= '</div>';/*grid-articles*/

				if ( '1' === $show_button ) {

					if ( get_option( 'show_on_front' ) == 'page' ) {
						$posts_link = get_permalink( get_option( 'page_for_posts' ) );;
					} else {
						$posts_link = get_bloginfo( 'url' );
					}

					$output .= '<div class="text-' . $button_text_color . ' text-'.$button_align.'">';
					$output .= '<a class="read-more" href="' . esc_url( $posts_link ) . '">';
					$output .= $button_text . '<i class="fa fa-long-arrow-right"></i>';
					$output .= '</a>';
					$output .= '</div>';
				}

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Posts_Slider' ) ) {
	$Crumina_Posts_Slider = new Crumina_Posts_Slider;
}
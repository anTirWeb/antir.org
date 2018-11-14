<?php
if ( ! class_exists( 'Crumina_Posts_Carousel' ) ) {
	class Crumina_Posts_Carousel {
		function __construct() {
			add_action( 'admin_init', array( &$this, 'crum_posts_carousel_init' ) );
			add_shortcode( 'posts_carousel', array( &$this, 'crum_posts_carousel_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'crum_widget_id' );

			return $uniue_id;
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_content' ) ) {

				$tmp = get_option( 'crum_cached_content' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_recent_post_transient' . $transient_id;
				update_option( 'crum_cached_content', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_recent_post_transient' . $transient_id;

				add_option( 'crum_cached_content', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_content' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_content' );
		}

		function crum_posts_carousel_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						"name"     => esc_html__( "Polo Posts Carousel", 'polo_extension' ),
						"base"     => "posts_carousel",
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
								"heading"          => esc_html__( "Show title", 'polo_extension' ),
								"param_name"       => "show_title",
								"value"            => array(
									__( "Enable", 'polo_extension' ) => "1",
								),
								"description"      => "",
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "checkbox",
								"class"            => "",
								"heading"          => esc_html__( "Show meta", 'polo_extension' ),
								"param_name"       => "show_meta",
								"value"            => array(
									__( "Enable", 'polo_extension' ) => "1",
								),
								"description"      => "",
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
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
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
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

		function crum_posts_carousel_form( $atts, $content = null ) {

			$feat_sticky  = $show_title = $show_meta = $auto_scroll = $controls_style = $slides_to_show = $loop = $transient_id = $el_class = $output = $data_dots = '';

			$slider_autoplay = $slider_autoplay_delay = '';
			extract(
				shortcode_atts(
					array(
						'feat_sticky'    => 'featured',
						'show_title'     => '',
						'show_meta'      => '',
						'auto_scroll'   => '0',
						'slides_to_show' => '3',
						'controls_style' => 'dots',
						'loop'           => 'size:4|order_by:date|order:ASC|post_type:post',
						'transient_id'   => '',
						'el_class'       => '',
						'slider_autoplay'       => '',
						'slider_autoplay_delay'       => '',
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
			if ( false === ( $latest_news_query = get_transient( 'crum_recent_post_transient' . $transient_id ) ) ) {
				$latest_news_query = new WP_Query( $args );

				set_transient( 'crum_recent_post_transient' . $transient_id, $latest_news_query );

				$this->update_id_option( $transient_id );
			}

			if ( 'dots' === $controls_style ) {
				$data_dots = 'data-carousel-dots="true"';
			}

            $scroll_slides = '';
            if($slider_autoplay){
                $scroll_slides = 'data-carousel-autoplay="' . $slider_autoplay . '" data-carousel-autoplay-delay="' . $slider_autoplay_delay * 1000 . '"';
            }

			if ( $latest_news_query->have_posts() ) {

				$output .= '<div class="grid-articles carousel post-carousel '.$el_class.'" ' . $scroll_slides . ' data-carousel-col="' . $slides_to_show . '" data-carousel-margins="0" '.$data_dots.'>';

				while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post();

					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					if ( ! empty( $post_thumbnail_id ) ) {
						$image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$image_url = polo_theme_thumb( $image_url[0], '525', '350', true, 'c' );
					} else {
						$image_url = PLUGIN_URL . 'assets/img/no-image.png';
						$image_url = polo_theme_thumb( $image_url, '525', '350', true, 'c' );
					}

					$output .= '<article class="post-entry">';

					$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '" class="post-image"><img alt="" src="' . esc_url( $image_url ) . '"></a>';

					$output .= '<div class="post-entry-overlay">';

					$output .= '<div class="post-entry-meta">';
					if ( '1' === $show_meta ) {
						$output .= '<div class="post-entry-meta-category">';

						$post_categories = wp_get_post_categories( get_the_ID() );

						$cat = get_category( $post_categories[0] );
						$output .= '<span class="label label-danger">' . $cat->name . '</span>';

						$output .= '</div>';
					}
					if ( '1' === $show_title ) {
						$output .= '<div class="post-entry-meta-title">';
						$output .= '<h2><a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a></h2>';
						$output .= '</div>';
					}
					if ( '1' === $show_meta ) {
						$output .= '<span class="post-date"><i class="fa fa-clock-o"></i>' . crumina_relative_time( get_post_time() ) . '</span>';
					}
					$output .= '</div>';//.post-entry-meta

					$output .= '</div>';//.post-entry-overlay

					$output .= '</article>';//.post-entry

				endwhile;

				$output .= '</div>';//.grid-articles

			}


			wp_reset_postdata();

			return $output;
		}

	}
}
if ( class_exists( 'Crumina_Posts_Carousel' ) ) {
	$Crumina_Posts_Carousel = new Crumina_Posts_Carousel;
}
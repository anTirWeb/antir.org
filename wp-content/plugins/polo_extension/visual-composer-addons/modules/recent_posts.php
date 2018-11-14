<?php
if ( ! class_exists( 'Crumina_Recent_Posts' ) ) {
	class Crumina_Recent_Posts {
		function __construct() {
			add_action( 'admin_init', array( &$this, 'crum_recent_posts_init' ) );
			add_shortcode( 'recent_posts', array( &$this, 'crum_recent_posts_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
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

		function crum_recent_posts_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/recent-posts/' );

			if ( function_exists( 'vc_map' ) ) {

				vc_map(
					array(
						'name'        => esc_html__( 'Polo Recent Posts', 'polo_extension' ),
						'base'        => 'recent_posts',
						'icon'        => 'recent-posts',
						'category'    => esc_html__( 'Polo Modules', 'polo_extension' ),
						'description' => esc_html__( 'Add block with several recent posts', 'polo_extension' ),
						'params'      => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'sidebar'      => $assets_dir . 'small.png',
									'blog_modern'  => $assets_dir . 'modern.png',
									'blog_classic' => $assets_dir . 'classic.png',
								),
								'std'         => 'sidebar',
							),
							array(
								'heading'     => esc_html__( 'Item style', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'item_style',
								'options'     => array(
									'with_bg'     => $assets_dir . 'with-bg.png',
									'transparent' => $assets_dir . 'trans-bg.png',
								),
								'std'         => 'with_bg',
								'dependency'  => array(
									'element' => 'layout',
									'value'   => array( 'blog_modern', 'blog_classic' )
								)
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Featured image layout', 'polo_extension' ),
								'param_name' => 'feat_img_layout',
								'value'      => array(
									esc_html__( 'Landscape', 'polo_extension' ) => 'landscape',
									esc_html__( 'Portrait', 'polo_extension' )  => 'portrait',
								),
							),
                            array(
                                'type'             => 'number',
                                'heading'          => esc_html__( 'Image width', 'polo_extension' ),
                                'param_name'       => 'image_width',
                                'value'            => '400',
                                'min'              => 0,
                                'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
                                'dependency'  => array(
                                    'element' => 'layout',
                                    'value'   => array( 'blog_modern', 'blog_classic' )
                                ),
                            ),
                            array(
                                'type'             => 'number',
                                'heading'          => esc_html__( 'Image height', 'polo_extension' ),
                                'param_name'       => 'image_height',
                                'value'            => '250',
                                'min'              => 0,
                                'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
                                'dependency'  => array(
                                    'element' => 'layout',
                                    'value'   => array( 'blog_modern', 'blog_classic' )
                                )
                            ),
							array(
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Columns number', 'polo_extension' ),
								'param_name' => 'columns_number',
								'value'      => array(
									'1 ' . esc_html__( 'columns', 'polo_extension' ) => '1',
									'2 ' . esc_html__( 'columns', 'polo_extension' ) => '2',
									'3 ' . esc_html__( 'columns', 'polo_extension' ) => '3',
									'4 ' . esc_html__( 'columns', 'polo_extension' ) => '4',
									'5 ' . esc_html__( 'columns', 'polo_extension' ) => '5',

								),
								'dependency' => array(
									'element' => 'layout',
									'value'   => array( 'blog_modern', 'blog_classic' )
								)
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Which post display first?', 'polo_extension' ),
								'param_name' => 'feat_sticky',
								'value'      => array(
									esc_html__( 'Latest post', 'polo_extension' ) => 'featured',
									esc_html__( 'Sticky post', 'polo_extension' ) => 'sticky',
								),
							),
                            array(
                                'type'       => 'checkbox',
                                'class'      => '',
                                'heading'    => esc_html__( 'Show title above image?', 'polo_extension' ),
                                'param_name' => 'title_above_image',
                                'value'            => array(
                                    esc_html__( 'Yes', 'polo_extension' ) => '1',
                                ),
                                'dependency' => array(
                                    'element' => 'layout',
                                    'value'   => array( 'blog_modern', 'blog_classic' )
                                ),
                            ),
							array(
								'type'             => 'checkbox',
								'class'            => '',
								'heading'          => esc_html__( 'Hide meta', 'polo_extension' ),
								'param_name'       => 'hide_meta',
								'value'            => array(
									esc_html__( 'Hide', 'polo_extension' ) => '1',
								),
								'description'      => '',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'checkbox',
								'class'            => '',
								'heading'          => esc_html__( 'Show excerpt', 'polo_extension' ),
								'param_name'       => 'show_excerpt',
								'value'            => array(
									esc_html__( 'Enable', 'polo_extension' ) => '1',
								),
								'description'      => '',
								'dependency'       => array(
									'element' => 'layout',
									'value'   => array( 'blog_modern', 'blog_classic' )
								),
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => esc_html__( 'Excerpt length', 'polo_extension' ),
								'param_name'       => 'excerpt_length',
								'value'            => '20',
								'min'              => 1,
								'max'              => 150,
								'suffix'           => '',
								'dependency'       => Array(
									'element' => 'show_excerpt',
									'value'   => '1'
								),
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'        => 'loop',
								'heading'     => esc_html__( 'Loop parameters', 'polo_extension' ),
								'param_name'  => 'loop',
								'settings'    => array(
									'size'      => array( 'hidden' => false, 'value' => 3 ),
									'post_type' => array( 'hidden' => true, 'value' => 'post' ),
									'order_by'  => array( 'value' => 'date' ),
									'tax_query' => array( 'hidden' => false, 'value' => '' ),
								),
								'edit_field_class' => 'vc_column vc_col-sm-8 crum_vc',
								'description' => esc_html__( 'Number of posts, Order parameters, Select category, Tags, Author, etc.', 'polo_extension' )
							),
							array(
								'type'             => 'number',
								'class'            => '',
								'heading'          => esc_html__( 'Post Offset', 'polo_extension' ),
								'param_name'       => 'offset',
								'value'            => '0',
								'min'              => 0,
								'suffix'           => '',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'       => 'tab_id',
								'param_name' => 'transient_id',
								'heading'    => esc_html__( 'Block ID', 'crum' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => __( 'Extra class name', 'js_composer' ),
								'param_name'  => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
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
								'type'       => 'dropdown',
								'class'      => '',
								'heading'    => esc_html__( 'Animation delay', 'polo_extension' ),
								'param_name' => 'animation_delay',
								'value'      => array(
									esc_html__( 'none', 'polo_extension' )   => '0',
									'0.5 sec'                                => '500',
									'1.0 sec'                                => '1000',
									'1.5 sec'                                => '1500',
									'2.0 sec'                                => '2000',
									'2.5 sec'                                => '2500',
									esc_html__( 'custom', 'polo_extension' ) => 'custom',
								),
								'group'      => esc_html__( 'Animation', 'polo_extension' ),
								'dependency' => Array(
									'element'   => 'animation',
									'not_empty' => true
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Custom animation delay', 'polo_extension' ),
								'param_name'  => 'custom_delay',
								'description' => esc_html__( 'Custom animation delay in milliseconds', 'polo_extension' ),
								'group'       => esc_html__( 'Animation', 'polo_extension' ),
								'dependency'  => Array(
									'element' => 'animation_delay',
									'value'   => 'custom'
								),
							),
						),
					)
				);
			}
		}

		function crum_recent_posts_form( $atts, $content = null ) {

			$layout       = $item_style = $feat_img_layout = $columns_number = $feat_sticky = $hide_meta = $show_excerpt = $excerpt_length = $offset ='';
			$transient_id = $el_class = $animation = $animation_delay = $custom_delay = $title_above_image = $image_width = $image_height = '';
			extract(
				shortcode_atts(
					array(
						'layout'          => 'sidebar',
						'item_style'      => 'with_bg',
						'feat_sticky'     => 'featured',
						'feat_img_layout' => 'landscape',
						'columns_number'  => '1',
						'hide_meta'       => '0',
						'show_excerpt'    => '',
						'excerpt_length'  => '20',
						'loop'            => 'size:3|order_by:date|order:ASC|post_type:post',
						'offset'=> '',
						'transient_id'    => '',
						'el_class'        => '',
						'animation'       => '',
						'animation_delay' => '0',
						'custom_delay'    => '',
                        'title_above_image' => '',
                        'image_width' => '',
                        'image_height' => '',
					), $atts
				)
			);

			$output = $animation_data = $animation_data_delay = '';

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

			if ( (!empty($offset)) && $offset !== 0 ) {
				$args['offset'] = $offset;
			}

			if ( function_exists( 'pll_current_language' ) ) {
				$transient_id = $transient_id . '_' . pll_current_language();
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

			if ( false === ( $latest_news_query = get_transient( 'crum_recent_post_transient' . $transient_id ) ) ) {
				$latest_news_query = new WP_Query( $args );

				set_transient( 'crum_recent_post_transient' . $transient_id, $latest_news_query );

				$this->update_id_option( $transient_id );
			}


			if ( $latest_news_query->have_posts() ) {

				if ( 'with_bg' === $item_style ) {
					$bg_class = 'post-light-background';
				} else {
					$bg_class = '';
				}

				if ( 'sidebar' === $layout ) {
					$output .= '<div class="post-thumbnail-list ' . $el_class . ' clearfix">';
				} else {
					if ( 'blog_modern' === $layout ) {
						$blog_class = 'post-modern';
					} else {
						$blog_class = '';
					}
					$output .= '<div class="post-content ' . $blog_class . ' post-block post-' . $columns_number . '-columns ' . $bg_class . ' clearfix">';
				}

				while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post();

					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					if ( ! empty( $post_thumbnail_id ) ) {
						$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
					}

					$post_categories = get_the_category( get_the_ID() );
					if ( isset( $post_categories ) && ! is_wp_error( $post_categories ) ) {
						$category_name = $post_categories[0]->name;
						$category_link = get_category_link( $post_categories[0]->term_id );
					} else {
						$category_name = $category_link = '';
					}


					if ( 'sidebar' === $layout ) {

						$width  = '160';
						$height = '120';

						$output .= '<div class="post-thumbnail-entry" ' . $animation_data . ' ' . $animation_data_delay . '>';
						$output .= '<a href="' . get_the_permalink( get_the_ID() ) . '" class="image">';
						if ( isset( $thumb[0] ) && ! empty( $thumb[0] ) ) {
							$image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 'c' );
							if ( ! ( 'image_not_specified' === $image_url ) ) {
								$output .= '<img src="' . $image_url . '" alt="">';
							}
						}
						$output .= '</a>';
						$output .= '<div class="post-thumbnail-content">';
						$output .= '<a href="' . get_the_permalink( get_the_ID() ) . '"><h4>' . get_the_title( get_the_ID() ) . '</h4></a>';

						if ( true != $hide_meta ) {
							$output .= '<span class="post-date"><i class="fa fa-clock-o"></i> ' . crumina_relative_time( get_post_time() ) . '</span>';
							$output .= '<span class="post-category"><a href="' . esc_url( $category_link ) . '" style="color:#999; font-size:13px"><i class="fa fa-tag"></i> ' . $category_name . '</a></span>';
						}
						$output .= '</div>';//.post-thumbnail-content

						$output .= '</div>';

					} else {

						if ( 'portrait' === $feat_img_layout ) {
							$width  = '400';
							$height = '600';
						} else {
							$width  = '400';
							$height = '267';
						}
						if(isset($image_width) && !empty($image_width))
						    $width = $image_width;
						if(isset($image_height) && !empty($image_height))
						    $height = $image_height;

						$output .= '<div class="post-item" ' . $animation_data . ' ' . $animation_data_delay . '>';
						$has_post_thumbnail = has_post_thumbnail( get_the_ID() );
						if ( $has_post_thumbnail ) {
							$output .= '<div class="post-image">';
							if($title_above_image){
                                $output .= '<div class="post-title">';
                                $output .= '<h3>';
                                $output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a>';
                                $output .= '</h3>';
                                $output .= '</div>';//post-title
                            }
							$output .= '<a href="' . get_the_permalink( get_the_ID() ) . '">';
							$image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 'c' );
							if ( ! ( 'image_not_specified' == $image_url ) ) {
								$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
							}
							$output .= '</a>';
							$output .= '</div>';//.post-image
						}

						$output .= '<div class="post-content-details">';
						if(!$has_post_thumbnail || !$title_above_image){
                            $output .= '<div class="post-title">';
                            $output .= '<h3>';
                            $output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a>';
                            $output .= '</h3>';
                            $output .= '</div>';//post-title
                        }
						if ( function_exists( 'polo_post_info' ) && ( '1' !== $hide_meta ) ) {
							$output .= polo_post_info();
						}
						if ( '1' === $show_excerpt ) {
							$output .= '<div class="post-description">';
							if ( function_exists( 'polo_post_text' ) ) {
								$output .= wpautop( polo_post_text( get_the_ID(), $excerpt_length ) );
							}
							$output .= '<div class="post-info">';
							$output .= '<a class="read-more" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">';
							$output .= esc_html__( 'read more', 'polo_extension' );
							$output .= '<i class="fa fa-long-arrow-right"></i>';
							$output .= '</a>';
							$output .= '</div>';//post-info
							$output .= '</div>';//post-description
						}
						$output .= '</div>';//post-content-details
						if ( '1' !== $hide_meta ) {
							if ( function_exists( 'polo_post_meta' ) ) {
								$output .= polo_post_meta();
							}
						}

						$output .= '</div>';//
					}

				endwhile;

				$output .= '</div>';//.post-thumbnail-list

			}

			wp_reset_postdata();

			return $output;
		}

	}
}
if ( class_exists( 'Crumina_Recent_Posts' ) ) {
	$Crumina_Recent_Posts = new Crumina_Recent_Posts;
}
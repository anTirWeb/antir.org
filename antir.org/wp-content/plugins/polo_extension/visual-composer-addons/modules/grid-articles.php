<?php
if ( ! class_exists( 'Crumina_Grid_Articles' ) ) {

	class Crumina_Grid_Articles {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'grid_init' ) );
			add_shortcode( 'crumina_grid_articles', array( &$this, 'grid_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_grid_articles' ) ) {

				$tmp = get_option( 'crum_cached_grid_articles' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_grid_articles_transient' . $transient_id;
				update_option( 'crum_cached_grid_articles', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_grid_articles_transient' . $transient_id;

				add_option( 'crum_cached_grid_articles', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_grid_articles' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_grid_articles' );
		}

		function grid_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"     => esc_html__( "Polo Grid Articles", 'polo_extension' ),
						"base"     => "crumina_grid_articles",
						"icon"     => "",
						"category" => esc_html__( 'Polo Modules', 'polo_extension' ),
						"params"   => array(
							array(
								'heading'     => esc_html__( 'Layout', 'polo_extension' ),
								'description' => '',
								'type'        => 'radio_image_select',
								'param_name'  => 'layout',
								'options'     => array(
									'layout_1' => 'http://dummyimage.com/80x80/fbc011/fff&text=1large+4small',
									'layout_2' => 'http://dummyimage.com/80x80/fbc011/fff&text=2large+4small',
								),
								'std'         => 'default',
							),
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
									'size'      => array( 'hidden' => false, 'value' => 5 ),
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

		function grid_form( $atts, $content = null ) {

			$layout = $feat_sticky = $loop = $transient_id = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'layout'       => 'featured',
						'feat_sticky'  => 'featured',
						'loop'         => 'size:5|order_by:date|order:ASC|post_type:post',
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
			if ( false === ( $grid_articles_query = get_transient( 'crum_grid_articles_transient' . $transient_id ) ) ) {
				$grid_articles_query = new WP_Query( $args );

				set_transient( 'crum_grid_articles_transient' . $transient_id, $grid_articles_query );

				$this->update_id_option( $transient_id );
			}

			if ( $grid_articles_query->have_posts() ) {

				if ( 'layout_2' === $layout ) {
					$grid_class = 'grid-articles grid-articles-v2';
				} else {
					$grid_class = 'grid-articles';
				}
				$output .= '<div class="container"><div class="row">';
				$output .= '<div class="' . esc_attr( $grid_class ) . '">';

				$i = 1;

				while ( $grid_articles_query->have_posts() ): $grid_articles_query->the_post();

					if ( 'layout_2' === $layout ) {
						if ( $i === 1 ) {
							$width_class = 'wide-article';
						} elseif ( $i === 2 ) {
							$width_class = 'wide-article';
						} else {
							$width_class = '';
						}
					} else {
						if ( $i === 1 ) {
							$width_class = 'wide-article';
						} else {
							$width_class = '';
						}
					}

					$output .= '<article class="post-entry ' . $width_class . '">';

					$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					if ( ! empty( $post_thumbnail_id ) ) {
						$image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						$image_url = polo_theme_thumb( $image_url[0], '600', '400', true, 'c' );
					} else {
						$image_url = PLUGIN_URL . 'assets/img/no-image.png';
						$image_url = polo_theme_thumb( $image_url, '600', '400', true, 'c' );
					}

					$output .= '<img alt="" src="' . esc_url( $image_url ) . '">';

					$output .= '<div class="post-entry-overlay"><a href="' . get_the_permalink( get_the_ID() ) . '" class="link"></a>';

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


					$i ++;

					if ( 'layout_2' === $layout ) {
						if ( $i === 7 ) {
							$i = 1;
						}
					} else {
						if ( $i === 6 ) {
							$i = 1;
						}
					}

				endwhile;

				$output .= '</div></div></div>';

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Grid_Articles' ) ) {
	$Crumina_Grid_Articles = new Crumina_Grid_Articles;
}
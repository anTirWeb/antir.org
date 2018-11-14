<?php
if ( ! class_exists( 'Crumina_Post_Thumbnail_List' ) ) {

	class Crumina_Post_Thumbnail_List {

		function __construct() {

			add_action( 'vc_before_init', array( &$this, 'list_init' ) );
			add_shortcode( 'crumina_post_thumbnail_list', array( &$this, 'list_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_feat_post_list' ) ) {

				$tmp = get_option( 'crum_cached_feat_post_list' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_feat_post_list_transient' . $transient_id;
				update_option( 'crum_cached_feat_post_list', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_feat_post_list_transient' . $transient_id;

				add_option( 'crum_cached_feat_post_list', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_feat_post_list' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_feat_post_list' );
		}

		function list_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"     => esc_html__( "Polo Posts List", 'polo_extension' ),
						"base"     => "crumina_post_thumbnail_list",
						"icon"     => "",
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
								'type'             => 'number',
								'heading'          => esc_html__( 'Excerpt length', 'polo_extension' ),
								'param_name'       => 'excerpt_length',
								'min'              => 0,
								'std'              => '15',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"heading"          => esc_html__( "Featured post meta position", 'polo_extension' ),
								"param_name"       => "meta_position",
								"value"            => array(
									esc_html__( "After thumbnail", 'polo_extension' ) => "top",
									esc_html__( "After excerpt", 'polo_extension' )   => "bottom",
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
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

		function list_form( $atts, $content = null ) {

			$feat_sticky = $excerpt_length = $meta_position = $loop = $transient_id = $el_class = $output = '';

			extract(
				shortcode_atts(
					array(
						'feat_sticky'    => 'featured',
						'excerpt_length' => '15',
						'meta_position'  => 'top',
						'loop'           => 'size:4|order_by:date|order:ASC|post_type:post',
						'transient_id'   => '',
						'el_class'       => '',
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
			if ( false === ( $featured_post_list_query = get_transient( 'crum_feat_post_list_transient' . $transient_id ) ) ) {
				$featured_post_list_query = new WP_Query( $args );

				set_transient( 'crum_feat_post_list_transient' . $transient_id, $featured_post_list_query );

				$this->update_id_option( $transient_id );
			}

			if ( $featured_post_list_query->have_posts() ) {

				$i = 0;

				$output .= '<div class="' . $el_class . '">';


				while ( $featured_post_list_query->have_posts() ): $featured_post_list_query->the_post();

					if ( 0 === $i ) {
						$output .= '<div class="post-thumbnail">';

						$output .= '<div class="post-thumbnail-entry">';

						$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						if ( ! empty( $post_thumbnail_id ) ) {
							$image_url = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
							$image_url = polo_theme_thumb( $image_url[0], '525', '350', true, 'c' );
						} else {
							$image_url = PLUGIN_URL . 'assets/img/no-image.png';
							$image_url = polo_theme_thumb( $image_url, '525', '350', true, 'c' );
						}
						$output .= '<a href="' . get_the_permalink( get_the_ID() ) . '">';
						$output .= '<img alt="" src="' . esc_url( $image_url ) . '">';
						$output .= '</a>';
						$output .= '<div class="post-thumbnail-content">';

						if ( 'top' === $meta_position ) {
							$output .= '<span class="post-date"><i class="fa fa-clock-o"></i> ' . crumina_relative_time( get_post_time() ) . '</span>';
							$post_categories = wp_get_post_categories( get_the_ID() );
							$cat             = get_category( $post_categories[0] );
							$output .= '<span class="post-category"><i class="fa fa-tag"></i> ' . $cat->name . '</span>';
						}

						$output .= '<h3><a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a></h3>';

						if ( function_exists( 'polo_post_text' ) ) {
							$output .= '<p>'.polo_post_text( get_the_ID(), $excerpt_length ).'</p>';
						}

						if ( 'bottom' === $meta_position ) {
							$output .= '<span class="post-date"><i class="fa fa-clock-o"></i> ' . crumina_relative_time( get_post_time() ) . '</span>';
							$post_categories = wp_get_post_categories( get_the_ID() );
							$cat             = get_category( $post_categories[0] );
							$output .= '<span class="post-category"><i class="fa fa-tag"></i> ' . $cat->name . '</span>';
						}

						$output .= '</div>';/*post-thumbnail-content*/

						$output .= '</div>';/*post-thumbnail-entry*/

						$output .= '</div>';/*post-thumbnail*/
						$output .= '<div class="post-thumbnail-list">';
						$i ++;

					} else {

						$output .= '<div class="post-thumbnail-entry">';

						$output .= '<div class="post-thumbnail-content">';

						$output .= '<h4><a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . get_the_title( get_the_ID() ) . '</a></h4>';

						$output .= '</div>';/*post-thumbnail-content*/

						$output .= '</div>';/*post-thumbnail-entry*/
					}


				endwhile;

				$output .= '</div>';/*post-thumbnail-list*/

				$output .= '</div>';/*el-class*/

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Post_Thumbnail_List' ) ) {
	$Crumina_Post_Thumbnail_List = new Crumina_Post_Thumbnail_List;
}
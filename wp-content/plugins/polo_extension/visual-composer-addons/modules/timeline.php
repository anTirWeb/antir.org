<?php
if ( ! class_exists( 'Crumina_Timeline' ) ) {

	class Crumina_Timeline {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'timeline_init' ) );
			add_shortcode( 'crumina_timeline', array( &$this, 'timeline_form' ) );

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'timeline_cached_content' ) ) {

				$tmp = get_option( 'timeline_cached_content' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',timeline_recent_post_transient' . $transient_id;
				update_option( 'timeline_cached_content', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'timeline_recent_post_transient' . $transient_id;

				add_option( 'timeline_cached_content', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'timeline_cached_content' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'timeline_cached_content' );
		}

		function timeline_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(

						"name"                    => esc_html__( "Polo Timeline", 'polo_extension' ),
						"base"                    => "crumina_timeline",
						"icon"                    => "timeline",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Starting text', 'polo_extension' ),
								'param_name' => 'starting_text',
							),
							array(
								"type"        => "loop",
								"heading"     => esc_html__( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'size'      => array( 'hidden' => false, 'value' => 7 ),
									'post_type' => array( 'hidden' => true, 'value' => 'post' ),
									'order_by'  => array( 'value' => 'date' ),
									'tax_query' => array( 'hidden' => false, 'value' => '' ),
								),
								"description" => esc_html__( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
							),
							array(
								"type"             => "dropdown",
								"heading"          => esc_html__( "Style", "crum" ),
								"param_name"       => "style",
								"value"            => array(
									esc_html__( "Default", "crum" ) => "default",
									esc_html__( "Colored", "crum" ) => "colored",
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "dropdown",
								"heading"          => esc_html__( "Which post display first?", "crum" ),
								"param_name"       => "feat_sticky",
								"value"            => array(
									esc_html__( "Latest post", "crum" ) => "featured",
									esc_html__( "Sticky post", "crum" ) => "sticky",
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
							),
							array(
								"type"             => "checkbox",
								"class"            => "",
								"heading"          => esc_html__( "Show post meta", "crum" ),
								"param_name"       => "show_post_meta",
								"value"            => array(
									esc_html__( "Yes, please", "crum" ) => "1",
								),
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								'std'              => '1',
								"description"      => "",
							),
							array(
								"type"             => "checkbox",
								"class"            => "",
								"heading"          => esc_html__( "Show excerpt", "crum" ),
								"param_name"       => "show_post_excerpt",
								"value"            => array(
									esc_html__( "Yes, please", "crum" ) => "1",
								),
								'std'              => '1',
								'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								"description"      => "",
							),
							array(
								"type"       => "number",
								"class"      => "",
								"heading"    => esc_html__( "Excerpt length", "crum" ),
								"param_name" => "except_words",
								"value"      => "20",
								"min"        => 1,
								"max"        => 100,
								"suffix"     => "",
								"dependency" => Array(
									"element" => "show_post_excerpt",
									"value"   => array( "1" )
								),
							),
							array(
								"type"       => "tab_id",
								"param_name" => "transient_id",
								'heading'    => esc_html__( 'Block ID', 'crum' ),
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

		function timeline_form( $atts, $content = null ) {

			$starting_text = $feat_sticky = $style = $show_post_meta = $show_post_excerpt = $except_words = $loop = $transient_id = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'starting_text'     => '',
						'feat_sticky'       => 'featured',
						'style'             => 'default',
						'show_post_meta'    => '1',
						'show_post_excerpt' => '1',
						'except_words'      => '20',
						'loop'              => 'size:7|order_by:date|order:ASC|post_type:post',
						'transient_id'      => '',
						'el_class'          => '',
					), $atts
				)
			);

			$output = $colored_class = '';

			if ( empty( $loop ) ) {
				return;
			}
			$this->getLoop( $loop );

			//if ( $displaying_type == '1_column' ) {
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

			if ( false === ( $timeline_query = get_transient( 'timeline_recent_post_transient' . $transient_id ) ) ) {
				$timeline_query = new WP_Query( $args );
				set_transient( 'timeline_recent_post_transient' . $transient_id, $timeline_query );

				$this->update_id_option( $transient_id );
			}

			if ( $timeline_query->have_posts() ) {

				if ( 'colored' === $style ) {
					$colored_class = 'timeline-colored';
				}

				set_query_var( 'excerpt_length', $except_words );
				set_query_var( 'show_meta', $show_post_meta );
				set_query_var( 'show_excerpt', $show_post_excerpt );

				$output .= '<div class="timeline ' . $colored_class . ' ' . $el_class . '">';

				$output .= '<ul class="timeline-circles">';

				if ( isset( $starting_text ) && ! empty( $starting_text ) ) {
					$output .= '<li class="timeline-date">' . $starting_text . '</li>';
				}else{
					$output .= '<li></li>';
				}

				while ( $timeline_query->have_posts() ) : $timeline_query->the_post();

					ob_start();
					include PLUGIN_PATH . '/visual-composer-addons/templates/format-timeline.php';
					$output .= ob_get_clean();

				endwhile;


				$output .= '</ul>';

				$output .= '</div>';//.timeline

			}
			wp_reset_query();

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Timeline' ) ) {
	$Crumina_Timeline = new Crumina_Timeline;
}
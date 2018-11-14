<?php
if ( ! class_exists( 'Crumina_Testimonials_Carousel' ) ) {

	class Crumina_Testimonials_Carousel {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'carousel_init' ) );
			add_shortcode( 'crumina_testimonials_carousel', array( &$this, 'carousel_form' ) );
		}

		function carousel_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => esc_html__( "Polo Testimonials Carousel", 'polo_extension' ),
						"base"                    => "crumina_testimonials_carousel",
						"icon"                    => "testimonial-carousel",
						"category"                => esc_html__( 'Polo Modules', 'polo_extension' ),
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Testimonials', 'polo_extension' ),
								'param_name' => 'testimonials',
								'params'     => array(
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Name', 'polo_extension' ),
										'param_name' => 'name',
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Profession', 'polo_extension' ),
										'param_name' => 'profession',
									),
									array(
										'type'       => 'textarea',
										'heading'    => esc_html__( 'Testimonial text', 'polo_extension' ),
										'param_name' => 'description',
									),
									array(
										'type'        => 'attach_image',
										'heading'     => esc_html__( 'Photo', 'polo_extension' ),
										'param_name'  => 'photo',
										'value'       => '',
										'admin_label' => true,
										'description' => esc_html__( 'Select image from media library.', 'polo_extension' ),
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Testimonial item style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Centered image', 'polo_extension' )   => 'centered',
									esc_html__( 'Image on left', 'polo_extension' )   => 'left_image',
								),
								'admin_label'      => true,
								'param_name'       => 'item_style',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__( 'Controls style', 'polo_extension' ),
								'value'            => array(
									esc_html__( 'Dots and arrows', 'polo_extension' )   => 'all',
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
								'std'              => '1',
								'edit_field_class' => 'vc_column vc_col-sm-4 crum_vc',
							),
							array(
								'type'       => 'tab_id',
								'param_name' => 'form_id',
								'heading'    => esc_html__( 'ID', 'polo_extension' ),
							),
						)
					)
				);
			}

		}

		function carousel_form( $atts ) {

			$testimonials = $controls_style = $slides_to_show = $item_style = $form_id = '';

			extract(
				shortcode_atts(
					array(
						'testimonials' => '',
						'controls_style' => 'all',
						'slides_to_show' => '1',
						'item_style' => 'centered',
						'form_id'      => '',
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$testimonials = (array) vc_param_group_parse_atts( $testimonials );
			}

			if('dots' === $controls_style){
				$dots = 'true';
				$arrows = 'false';
			}elseif('arrows' === $controls_style){
				$dots = 'false';
				$arrows = 'true';
			}else{
				$dots = 'true';
				$arrows = 'true';
			}

			if('left_image' === $item_style){
				$align_class = 'testimonials-left';
			}else{
				$align_class = '';
			}

			$output = '';

			$output .= '<div id="testimonials" class="'.$align_class.' testimonials' . $form_id . '">';

			foreach ( $testimonials as $single_testimonial ) {

				if ( isset( $single_testimonial['photo'] ) && ! empty( $single_testimonial['photo'] ) ) {
					$image_url = wp_get_attachment_image_src( $single_testimonial['photo'], 'full' );
					$image_url = polo_theme_thumb( $image_url[0], '300', '300', true, 'c' );
				}

				$output .= '<div class="testimonial-item">';

				if ( isset( $image_url ) && ! empty( $image_url ) ) {
					$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
				}
				if ( isset( $single_testimonial['description'] ) && ! empty( $single_testimonial['description'] ) ) {
					$output .= '<p>' . $single_testimonial['description'] . '</p>';
				}
				if ( isset( $single_testimonial['profession'] ) && ! empty( $single_testimonial['profession'] ) || isset( $single_testimonial['name'] ) && ! empty( $single_testimonial['name'] ) ) {
					$output .= '<span>';
					if ( isset( $single_testimonial['name'] ) && ! empty( $single_testimonial['name'] ) ) {

						$output .= '<h6>' . $single_testimonial['name'] . '</h6>';

					}
					if ( isset( $single_testimonial['profession'] ) && ! empty( $single_testimonial['profession'] ) ) {

						$output .= $single_testimonial['profession'];
					}
					$output .= '</span>';
				}
				$output .= '</div>';

			}

			$output .= '</div>';//#testimonials

			ob_start(); ?>

			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$(".testimonials<?php echo $form_id;?>").owlCarousel({
						margin            : 60,
						nav               : <?php echo $arrows;?>,
						navText           : ['<i class="fa fa-arrow-left icon-white"></i>', '<i class="fa fa-arrow-right icon-white"></i>'],
						autoplay          : false,
						autoplayHoverPause: true,
						dots              : <?php echo $dots;?>,
						singleItem        : true,
						items             : <?php echo $slides_to_show?>,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: <?php echo $slides_to_show?>
                            }
                        }

					});
				});

			</script>

			<?php return $output;

		}

	}

}

if ( class_exists( 'Crumina_Testimonials_Carousel' ) ) {
	$Crumina_Testimonials_Carousel = new Crumina_Testimonials_Carousel;
}
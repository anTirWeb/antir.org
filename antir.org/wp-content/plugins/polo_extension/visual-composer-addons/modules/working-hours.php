<?php
if ( ! class_exists( 'Crumina_Working_Hours' ) ) {

	class Crumina_Working_Hours {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'hours_init' ) );
			add_shortcode( 'crmina_working_hours', array( &$this, 'hours_form' ) );
		}

		function hours_init() {

			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'                    => esc_html__( 'Polo Working hours schedule', 'polo_extension' ),
						'base'                    => 'crmina_working_hours',
						'icon'                    => 'working-hours',
						'category'                => esc_html__( 'Polo Modules', 'polo_extension' ),
						'show_settings_on_create' => true,
						'params'                  => array(
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Accordion tabs', 'polo_extension' ),
								'param_name' => 'schedule',
								'params'     => array_merge(
									array(
										array(
											'type'       => 'textfield',
											'heading'    => esc_html__( 'Title', 'polo_extension' ),
											'param_name' => 'title',
										)
									),
									array(
										array(
											'type'       => 'textfield',
											'heading'    => esc_html__( 'Working hours', 'polo_extension' ),
											'param_name' => 'work_hours',
										),
									)
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'       => 'textarea_html',
								'heading'    => esc_html__( 'Content', 'polo_extension' ),
								'param_name' => 'content',
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

		function hours_form( $atts, $content = null ) {

			$output = $schedule = $el_class = '';

			extract(
				shortcode_atts(
					array(
						'schedule' => '',
						'el_class' => ''
					), $atts
				)
			);

			if ( function_exists( 'vc_param_group_parse_atts' ) ) {
				$schedule = (array) vc_param_group_parse_atts( $schedule );
			}

			if ( isset( $schedule ) && is_array( $schedule ) ) {

				$output .= '<div class="working-hours ' . $el_class . '">';

				$output .= '<ul>';

				foreach ( $schedule as $single_day ) {

					$output .= '<li>';

					$output .= $single_day['title'];

					$output .= '<span class="opening-hour">' . $single_day['work_hours'] . '</span>';

					$output .= '</li>';

				}

				$output .= '</ul>';

				if ( isset( $content ) && ! empty( $content ) ) {
					$output .= '<p>' . $content . '</p>';
				}

				$output .= '</div>';/*working-hours*/

			}

			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Working_Hours' ) ) {
	$Crumina_Working_Hours = new Crumina_Working_Hours;
}
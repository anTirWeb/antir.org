<?php
if ( ! class_exists( 'Crumina_Shortcode_Parameters' ) ) {

	class Crumina_Shortcode_Parameters {

		function __construct() {

			// Generate param type "number"
			if ( function_exists( 'add_shortcode_param' ) ) {
				vc_add_shortcode_param( 'number', array( &$this, 'number_settings_field' ) );

				// Generate param type "datetimepicker"

				vc_add_shortcode_param( 'datetimepicker', array( $this, 'datetimepicker' ) );

				// Generate param type "crum_fonts"

			}
		}


		// Function generate param type "number"
		function number_settings_field( $settings, $value ) {
			//$dependency = vc_generate_dependencies_attributes($settings);
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}

		//datetimepicker parameter
		function datetimepicker( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$uni        = uniqid();

			$output = '<input id="ult-date-time' . $uni . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="' . $value . '"/>';
			?>
			<script type="text/javascript">
				jQuery(document).ready(function () {
					jQuery("#ult-date-time<?php echo esc_attr($uni) ;?>").datepicker({
						dateFormat: 'yy/mm/dd'
					});
				})
			</script>
			<?php
			return $output;
		}

	}
}

if ( class_exists( 'Crumina_Shortcode_Parameters' ) ) {
	$Crumina_Shortcode_Parameters = new Crumina_Shortcode_Parameters;
}


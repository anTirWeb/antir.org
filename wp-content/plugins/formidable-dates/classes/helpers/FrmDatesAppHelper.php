<?php
class FrmDatesAppHelper {

	private static $min_formidable_version = 3.0;

	public static function plugin_file() {
		return dirname( dirname( dirname( __FILE__ ) ) ) . '/formidable-dates.php';
	}

	public static function get_path( $path = '/' ) {
		return plugin_dir_path( self::plugin_file() ) . $path;
	}

	public static function get_url( $path = '/' ) {
		return plugins_url( $path, self::plugin_file() );
	}

	public static function get_days_of_the_week( $args = null ) {
		global $wp_locale;

		$week_start = absint( get_option( 'start_of_week' ) );

		$n = $week_start;
		for ( $i = 0; $i < 7; $i++ ) {
			$week_days[ strval( ( $n + $i ) % 7 ) ] = $wp_locale->get_weekday_abbrev( $wp_locale->get_weekday( ( $n + $i ) % 7 ) );
		}

		return $week_days;
	}

	/**
	 * Check if the current version of Formidable is compatible with Dates add-on
	 * @since 1.0
	 * @return mixed
	 */
	public static function is_formidable_compatible() {
		$frm_version = is_callable( 'FrmAppHelper::plugin_version' ) ? FrmAppHelper::plugin_version() : 0;
		return version_compare( $frm_version, self::$min_formidable_version, '>=' ) && FrmAppHelper::pro_is_installed();
	}

}

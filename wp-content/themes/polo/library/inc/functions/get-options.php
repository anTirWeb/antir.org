<?php
/**
 * Reactor Get Options
 * based on get_theme_mod in wp-includes/theme.php
 * retrieves an option from the database or cache
 * can also get a value from post meta
 *
 * @package Reactor
 * @since   1.0.0
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 *
 * @param string $name    Option name in database.
 * @param mixed  $default A default value if option is avialble.
 * @param int    $meta_id Post meta id to retrieve meta from database.
 *
 * @return mixed|void
 */
function reactor_option( $name, $default = false, $meta_id = null ) {

	// if meta_id isset get post meta
	if ( isset( $meta_id ) ) {
		$post_id = absint( get_queried_object_id() );

		// get the meta from the database
		$meta = ( get_post_meta( $post_id, $meta_id, true ) ) ? get_post_meta( $post_id, $meta_id, true ) : null;

		// if meta is an array check for the name in the array
		if ( is_array( $meta ) && isset( $meta[ $name ] ) ) {
			$meta = $meta[ $name ];
		}

		// if meta isset return the value
		if ( isset( $meta ) ) {
			if ( is_string( $meta ) ) {
				$meta = do_shortcode( $meta );
			}

			return apply_filters( "reactor_option_$name", $meta );
		}

	} else {
		// else get array of options
		if ( function_exists( 'cs_get_option' ) ) {
			$option = cs_get_option( $name ) ? cs_get_option( $name ) : null;
		} else {
			$option = null;
		}
	}

	// return the option if it exists
	if ( isset( $option ) ) {
		return apply_filters( "reactor_option_$name", $option );
	}

	// return default if nothing else
	return apply_filters( "reactor_option_$name", $default );
}

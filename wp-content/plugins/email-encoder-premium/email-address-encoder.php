<?php
/*
Plugin Name: Email Address Encoder ✪
Plugin URI: https://encoder.till.im/
Description: A lightweight plugin to protect email addresses from smart email-harvesting robots.
Version: 0.1.7
Author: Till Krüss
Author URI: https://till.im/
Text Domain: email-address-encoder
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Define plugin basename.
 */
define( 'EAE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Define filter-priority constant, unless it has already been defined.
 */
if ( ! defined( 'EAE_FILTER_PRIORITY' ) ) {
    define(
        'EAE_FILTER_PRIORITY',
        (integer) get_option( 'eae_filter_priority', 1000 )
    );
}

/**
 * Load admin related code.
 */
if ( ! function_exists( 'eae_load_textdomain' ) ) {
    require_once __DIR__ . '/includes/admin.php';
}

/**
 * Load premium related code.
 */
require_once __DIR__ . '/premium/base.php';

/**
 * Register uninstall and activation hooks.
 */
register_uninstall_hook( __FILE__, 'eaep_uninstall_hook' );
register_activation_hook( __FILE__, 'eaep_activation_hook' );

/**
 * Register filters to encode plain email addresses in posts, pages, excerpts,
 * comments and text widgets.
 */
if ( get_option( 'eae_search_in', 'filters' ) === 'filters' ) {
    foreach ( array( 'the_content', 'the_excerpt', 'widget_text', 'comment_text', 'comment_excerpt' ) as $filter ) {
        add_filter( $filter, 'eae_encode_emails', EAE_FILTER_PRIORITY );
    }
}

/**
 * Attempt to register the shortcode relatively late to avoid conflicts.
 */
add_action( 'init', 'eae_register_shortcode', 1000 );

/**
 * Register the [encode] shortcode, if it doesn't exist.
 *
 * @return void
 */
if ( ! function_exists( 'eae_register_shortcode' ) ) :
function eae_register_shortcode() {
    if ( ! shortcode_exists( 'encode' ) ) {
        add_shortcode( 'encode', 'eae_shortcode' );
    }
}
endif;

if ( ! function_exists( 'eae_shortcode' ) ) :
/**
 * The [encode] shortcode callback function. Returns encoded shortcode content.
 *
 * @param array $attributes Shortcode attributes
 * @param string $string Shortcode content
 *
 * @return string Encoded given text
 */
function eae_shortcode( $attributes, $content = '' ) {
    return eae_encode_str( $content );
}
endif;

if ( ! function_exists( 'eae_encode_emails' ) ) :
/**
 * Searches for plain email addresses in given $string and
 * encodes them (by default) with the help of eae_encode_str().
 *
 * Regular expression is based on based on John Gruber's Markdown.
 * http://daringfireball.net/projects/markdown/
 *
 * @param string $string Text with email addresses to encode
 *
 * @return string Given text with encoded email addresses
 */
function eae_encode_emails( $string ) {
    // abort if `$string` isn't a string
    if ( ! is_string( $string ) ) {
        return $string;
    }

    // abort if `eae_at_sign_check` is true and `$string` doesn't contain a @-sign
    if ( apply_filters( 'eae_at_sign_check', true ) && strpos( $string, '@' ) === false ) {
        return $string;
    }

    // override encoding function with the 'eae_method' filter
    $method = apply_filters( 'eae_method', 'eae_encode_str' );

    // override regex pattern with the 'eae_regexp' filter
    $regexp = apply_filters(
        'eae_regexp',
        '{
            (?:mailto:)?
            (?:
                [-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+
            |
                ".*?"
            )
            \@
            (?:
                [-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+
            |
                \[[\d.a-fA-F:]+\]
            )
        }xi'
    );

    return preg_replace_callback( $regexp, function ( $matches ) use ( $method ) {
        return $method( $matches[0] );
    }, $string );
}
endif;

if ( ! function_exists( 'eae_encode_str' ) ) :
/**
 * Encodes each character of the given string as either a decimal
 * or hexadecimal entity, in the hopes of foiling most email address
 * harvesting bots.
 *
 * Based on Michel Fortin's PHP Markdown:
 *   http://michelf.com/projects/php-markdown/
 * Which is based on John Gruber's original Markdown:
 *   http://daringfireball.net/projects/markdown/
 * Whose code is based on a filter by Matthew Wickline, posted to
 * the BBEdit-Talk with some optimizations by Milian Wolff.
 *
 * @param string $string Text to encode
 * @param bool $hex Whether to use hex entities as well
 *
 * @return string Encoded given text
 */
function eae_encode_str( $string, $hex = false ) {
    $chars = str_split( $string );
    $seed = mt_rand( 0, (int) abs( crc32( $string ) / strlen( $string ) ) );

    foreach ( $chars as $key => $char ) {

        $ord = ord( $char );

        if ( $ord < 128 ) { // ignore non-ascii chars

            $r = ( $seed * ( 1 + $key ) ) % 100; // pseudo "random function"

            if ( $r > 75 && $char !== '@' && $char !== '.' ) ; // plain character (not encoded), except @-signs and dots
            else if ( $hex && $r < 25 ) $chars[ $key ] = '%' . bin2hex( $char ); // hex
            else if ( $r < 45 ) $chars[ $key ] = '&#x' . dechex( $ord ) . ';'; // hexadecimal
            else $chars[ $key ] = '&#' . $ord . ';'; // decimal (ascii)

        }

    }

    return implode( '', $chars );
}
endif;

/**
 * Callback that runs when the plugin is activated.
 *
 * @return void
 */
function eaep_activation_hook() {
    if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
        wp_die( sprintf(
            'Whoops! This plugin requires PHP 5.4 or greater. This server is currently running PHP %s.', phpversion()
        ) );
    }

    deactivate_plugins( 'email-address-encoder/email-address-encoder.php' );

    update_option( 'eae_search_in', 'filters' );
    update_option( 'eae_technique', 'entities' );
    update_option( 'eae_filter_priority', (integer) EAE_FILTER_PRIORITY );
}

/**
 * Callback that runs when the plugin is uninstalled.
 *
 * @return void
 */
function eaep_uninstall_hook() {
    if ( function_exists( 'eae_remote_request' ) ) {
        eae_remote_request( 'plugin/uninstall' );
    }

    delete_option( 'eae_license' );
    delete_option( 'eae_license_key' );
    delete_option( 'eae_search_in' );
    delete_option( 'eae_technique' );
    delete_option( 'eae_filter_priority' );
}

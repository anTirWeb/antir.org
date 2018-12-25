<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( get_option( 'eae_search_in', 'filters' ) === 'filters' ) {

    add_filter( 'acf/load_value', function ( $value ) {
        return eae_license_was_revoked() ? $value : eae_encode_emails( $value );
    }, EAE_FILTER_PRIORITY );

    add_filter( 'jetpack_open_graph_tags', function ( $tags ) {
        return array_map( function ( $tag ) {
            return eae_encode_emails( $tag );
        }, $tags );
    }, EAE_FILTER_PRIORITY );

}

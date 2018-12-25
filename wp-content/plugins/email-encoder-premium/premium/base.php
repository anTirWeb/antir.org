<?php

if ( ! defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/updates.php';
require_once __DIR__ . '/plugins.php';

add_filter( 'template_include', function ( $template ) {
    if ( get_option( 'eae_search_in' ) === 'output' ) {
        require_once __DIR__ . '/dom.php';

        ob_start( function ( $buffer ) {
            try {
                $encoder = new EAE_DOM_Encoder;

                return $encoder->parse( $buffer )->output();
            } catch ( Exception $exception ) {
                return $buffer . EAE_DOM_Encoder::message(
                    sprintf( '%s: %s', get_class( $exception ), $exception->getMessage() )
                );
            }
        } );
    }

    return $template;
}, EAE_FILTER_PRIORITY );

add_action( 'wp_head', function () {
    if ( get_option( 'eae_technique' ) !== 'css-direction' ) {
        return;
    }

    $styles = <<<STYLES
        <style type="text/css">
            .__eae_cssd {
                unicode-bidi: bidi-override;
                direction: rtl;
            }
        </style>
STYLES;

    printf( "\n%s\n", preg_replace( '/(\v|\s{2,})/', '', $styles ) );
}, 1 );

add_action( 'wp_head', function () {
    if ( get_option( 'eae_technique' ) !== 'rot13' ) {
        return;
    }

    $script = <<<SCRIPT
        <script type="text/javascript">
            var __eae_decode = function (str) {
                return str.replace(/[a-zA-Z]/g, function(c) {
                    return String.fromCharCode(
                        (c <= 'Z' ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26
                    );
                });
            };

            var __eae_decode_emails = function () {
                var __eae_emails = document.querySelectorAll('.__eae_r13');

                for (var i = 0; i < __eae_emails.length; i++) {
                    __eae_emails[i].textContent = __eae_decode(__eae_emails[i].textContent)
                }
            };

            if (document.readyState != 'loading') {
                __eae_decode_emails();
            } else if (document.addEventListener) {
                document.addEventListener('DOMContentLoaded', __eae_decode_emails);
            } else {
                document.attachEvent('onreadystatechange', function () {
                    if (document.readyState != 'loading') __eae_decode_emails();
                });
            }
        </script>
SCRIPT;

    printf( "\n%s\n", preg_replace( '/(\v|\s{2,})/', '', $script ) );
} );

add_action( 'admin_head', function () {
    $screen = get_current_screen();

    if ( ! isset( $screen->id ) || $screen->id !== 'settings_page_email-address-encoder' ) {
        return;
    }

    echo <<<STYLES
        <style type="text/css">
            .description .license-success,
            .description .license-success a {
                color: #46b450;
            }
            .description .license-warning,
            .description .license-warning a {
                color: #ff9700;
            }
            .description .license-danger,
            .description .license-danger a {
                color: #dc3232;
            }
        </style>
STYLES;
} );

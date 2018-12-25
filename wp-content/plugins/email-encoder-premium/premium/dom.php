<?php

require_once __DIR__ . '/../includes/simple_html_dom.php';

class EAE_DOM_Encoder
{
    const EMAIL_REGEXP = '{(?:mailto:)?(?:[-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+|".*?")\@(?:[-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+|\[[\d.a-fA-F:]+\])}xi';

    protected $dom;

    protected $emails;

    protected $message;

    public function parse( $html )
    {
        $this->dom = simplehtmldom_1_5\str_get_html(
            $html, false, true, get_bloginfo( 'charset' ), false
        );

        if ( $this->dom ) {
            $this->loop( $this->dom->root );
        } else {
            $this->message = 'Unable to parse HTML :/';
        }

        return $this;
    }

    public function output()
    {
        $html = $this->dom->root->innertext();

        if ( $this->message ) {
            $html .= static::message( $this->message );
        }

        return str_replace(
            array_keys( $this->emails ),
            array_values( $this->emails ),
            $html
        );
    }

    protected function loop( $node )
    {
        if ( $node->nodes ) {
            foreach ( $node->nodes as $child ) {
                $this->loop( $child );
            }
        }

        if ( $node->nodetype === HDOM_TYPE_ELEMENT ) {
            $this->replace_emails_in_attributes( $node );
        }

        if ( $node->nodetype === HDOM_TYPE_TEXT ) {
            $this->replace_emails_in_text( $node );
        }

        if ( $node->nodetype === HDOM_TYPE_COMMENT ) {
            $this->replace_emails_in_comment( $node );
        }
    }

    protected function find_emails( $text )
    {
        if ( apply_filters( 'eae_at_sign_check', true ) && strpos( $text, '@' ) === false ) {
            return;
        }

        preg_match_all( self::EMAIL_REGEXP, $text, $matches );

        if ( empty( $matches[ 0 ] ) ) {
            return;
        }

        $emails = array_filter( $matches[ 0 ], function ( $email ) {
            return strpos( $email, '/' ) === false
                && strpos( $email, '=' ) === false
                && ! preg_match( '/@\d{1,2}(.\d)?x\./', $email );
        });

        if ( empty( $emails ) ) {
            return;
        }

        return array_unique( $emails );
    }

    protected function replace_emails_in_inner_text( $node, $text, $emails, $type )
    {
        foreach ( $emails as $email ) {
            $key = $this->str_random();

            $this->emails[ $key ] = $this->obfuscate_email( $type, $email );

            $text = str_replace( $email, $key, $text );
        }

        $node->innertext = $text;
    }

    protected function replace_emails_in_attributes( $node )
    {
        $in_head = $this->is_inside_head( $node );

        foreach ( $node->attr as $name => $value ) {
            $trimmed = trim( $value );

            if ( empty( $trimmed ) ) {
                continue;
            }

            if ( ! $emails = $this->find_emails( $value ) ) {
                continue;
            }

            foreach ( $emails as $email ) {
                $key = $this->str_random();

                $this->emails[ $key ] = $in_head
                    ? $this->obfuscate_email( 'head', $email )
                    : $this->obfuscate_attribute( $node->tag, $name, $email );

                $node->attr[ $name ] = str_replace( $email, $key, $value );
            }
        }
    }

    protected function replace_emails_in_comment( $node )
    {
        $text = $node->innertext();
        $trimmed = trim( $text );

        if ( empty( $trimmed ) ) {
            return;
        }

        if ( ! $emails = $this->find_emails( $text ) ) {
            return;
        }

        foreach ( $emails as $email ) {
            $key = $this->str_random();

            $this->emails[ $key ] = $this->obfuscate_email( 'comment', $email );

            $text = str_replace( $email, $key, $text );
        }

        $node->innertext = $text;
    }

    protected function replace_emails_in_text( $node )
    {
        $text = $node->innertext();
        $trimmed = trim( $text );

        if ( empty( $trimmed ) ) {
            return;
        }

        if ( ! $emails = $this->find_emails( $text ) ) {
            return;
        }

        if ( in_array( $node->parent->tag, [ 'textarea', 'xmp', 'noscript' ] ) ) {
            $this->replace_emails_in_inner_text( $node->parent, $text, $emails, $node->parent->tag );
        } elseif ( $node->parent->tag === 'script' ) {
            //
        } elseif ( $this->is_inside_head( $node ) ) {
            $this->replace_emails_in_inner_text( $node->parent, $text, $emails, 'head' );
        } else {
            $this->replace_emails_in_inner_text( $node->parent, $text, $emails, 'text' );
        }
    }

    protected function obfuscate_email( $type, $email )
    {
        $user = strstr( $email, '@', true );
        $domain = strstr( $email, '@' );

        if ( in_array( $type, [ 'head', 'textarea', 'noscript' ] ) ) {
            return eae_encode_str( $email );
        }

        if ( in_array( $type, [ 'comment', 'xmp' ] ) ) {
            return $user . str_replace(
                [ '@', '.' ],
                [ ' ⟨at⟩ ', ' ⟨dot⟩ '],
                $domain
            );
        }

        if ( $type === 'text' ) {
            $technique = get_option( 'eae_technique' );

            if ( $technique === 'css-direction' ) {
                return sprintf( '<span class="__eae_cssd">%s</span>', $this->strrev( $email ) );
            }

            if ( $technique === 'rot13' ) {
                return sprintf( '<span class="__eae_r13">%s</span>', str_rot13( $email ) );
            }

            return eae_encode_str( $email );
        }

        return $email;
    }

    protected function obfuscate_attribute( $tag, $attribute, $email )
    {
        if ( $tag === 'a' && $attribute === 'href' && stripos ( $email , 'mailto:' ) === 0 ) {
            $technique = get_option( 'eae_technique' );

            if ( $technique === 'entities' ) {
                return eae_encode_str( 'mailto:' ) . eae_encode_str( substr( $email, 7 ), true );
            }

            if ( $technique === 'rot13' ) {
                return sprintf(
                    "javascript:window.location.href=__eae_decode('%s');",
                    str_rot13( $email )
                );
            }
        }

        return eae_encode_str( $email );
    }

    protected function is_inside_head( $node )
    {
        if ( $node->tag === 'head' ) {
            return true;
        }

        if ( $node->parent ) {
            return $this->is_inside_head( $node->parent );
        }

        return false;
    }

    protected function strrev( $string )
    {
        $reversed = '';

        for ( $i = mb_strlen( $string ); $i >= 0; $i-- ) {
            $reversed .= mb_substr( $string, $i, 1 );
        }

        return $reversed;
    }

    protected function str_random()
    {
        return sprintf( '__eae_%s__', mt_rand() );
    }

    public static function message( $message )
    {
        return sprintf(
            "\n<!--\n%s\n\n%s\n-->\n",
            '[Email Address Encoder]',
            $message
        );
    }
}

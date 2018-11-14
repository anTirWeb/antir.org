<?php
add_action( 'after_setup_theme', 'crum_custom_theme_widgets_and_composer' );
add_action( 'admin_menu', 'register_subscribe_menu' );

/**
 *
 */
function crum_custom_theme_widgets_and_composer() {

	//Presentation modules

	$widgets_path = PLUGIN_PATH . '/widgets';

	// activate addons one by one from modules directory

	foreach ( glob( $widgets_path . "/*.php" ) as $module ) {

		require_once( $module );
	}

	$composer_params_path = PLUGIN_PATH . '/visual-composer-addons/params';

	// activate addons one by one from modules directory

	foreach ( glob( $composer_params_path . "/*.php" ) as $param ) {
		require_once( $param );
	}

	$composer_modules_path = PLUGIN_PATH . '/visual-composer-addons/modules';

	// activate addons one by one from modules directory

	foreach ( glob( $composer_modules_path . "/*.php" ) as $module ) {
		require_once( $module );
	}

	$woo_composer_modules_path = PLUGIN_PATH . '/visual-composer-addons/woocommerce';

	// activate addons one by one from modules directory

	if ( class_exists('Woocommerce') ) {
		foreach ( glob( $woo_composer_modules_path . "/*.php" ) as $woo_module ) {
			require_once( $woo_module );
		}
	}
}

if ( ! function_exists( 'polo_theme_thumb' ) ) {
	/**
	 * @param        $url
	 * @param        $width
	 * @param int    $height
	 * @param        $crop
	 * @param string $align
	 *
	 * @return mixed
	 */
	function polo_theme_thumb( $url, $width, $height = 0, $crop = true, $align = '' ) {
//	    echo '<pre>';
//        debug_print_backtrace();
//        die();
		if ( extension_loaded( 'gd' ) ) {
			return mr_image_resize( $url, $width, $height, $crop, $align, false );
		} else {
			return $url;
		}
	}
}
/**
 * Turn all URLs in clickable links.
 *
 * @param string $value
 * @param array  $protocols  http/https, ftp, mail, twitter
 * @param array  $attributes
 * @param string $mode       normal or all
 * @return string
 */
if ( ! function_exists( 'polo_linkify' ) ) {
	function polo_linkify( $value, $protocols = array( 'http', 'https', 'mail' ), array $attributes = array() ) {
		// Link attributes
		$attr = '';
		foreach ( $attributes as $key => $val ) {
			$attr = ' ' . $key . '="' . htmlentities( $val ) . '"';
		}

		$links = array();

		// Extract existing links and tags
		$value = preg_replace_callback( '~(<a .*?>.*?</a>|<.*?>)~i', function ( $match ) use ( &$links ) {
			return '<' . array_push( $links, $match[1] ) . '>';
		}, $value );

		// Extract text links for each protocol
		foreach ( (array) $protocols as $protocol ) {
			switch ( $protocol ) {
				case 'http':
				case 'https':
					$value = preg_replace_callback( '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ( $match ) use ( $protocol, &$links, $attr ) {
						if ( $match[1] ) {
							$protocol = $match[1];
						}
						$link = $match[2] ?: $match[3];

						return '<' . array_push( $links, "<a $attr href=\"$protocol://$link\">$link</a>" ) . '>';
					}, $value );
					break;
				case 'mail':
					$value = preg_replace_callback( '~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ( $match ) use ( &$links, $attr ) {
						return '<' . array_push( $links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>" ) . '>';
					}, $value );
					break;
				case 'twitter':
					$value = preg_replace_callback( '~(?<!\w)[@#](\w++)~', function ( $match ) use ( &$links, $attr ) {
						return '<' . array_push( $links, "<a $attr href=\"https://twitter.com/" . ( $match[0][0] == '@' ? '' : 'search/%23' ) . $match[1] . "\">{$match[0]}</a>" ) . '>';
					}, $value );
					break;
				default:
					$value = preg_replace_callback( '~' . preg_quote( $protocol, '~' ) . '://([^\s<]+?)(?<![\.,:])~i', function ( $match ) use ( $protocol, &$links, $attr ) {
						return '<' . array_push( $links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>" ) . '>';
					}, $value );
					break;
			}
		}

		// Insert all link
		return preg_replace_callback( '/<(\d+)>/', function ( $match ) use ( &$links ) {
			return $links[ $match[1] - 1 ];
		}, $value );
	}
}

/**
 *
 */
function register_subscribe_menu() {
	add_menu_page( 'Subscribers', 'Subscribers', 'add_users', PLUGIN_PATH . 'inc/subscribe-form/subscrbe-page-index.php', '', PLUGIN_URL . 'inc/subscribe-form/img/sml-admin-icon.png', 58.122 );
}

/**
 * @return array
 */
function crum_do_vc_map_icon( $group = null, $dependancy = array() ) {

	if ( ! ( null === $group ) ) {
		$group_name = $group;
	} else {
		$group_name = '';
	}

	$icon_type = array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Icon library', 'polo_extension' ),
		'value'       => array(
			esc_html__( 'No icon', 'polo_extension' )      => '',
			esc_html__( 'Font Awesome', 'polo_extension' ) => 'fontawesome',
			esc_html__( 'Open Iconic', 'polo_extension' )  => 'openiconic',
			esc_html__( 'Typicons', 'polo_extension' )     => 'typicons',
			esc_html__( 'Entypo', 'polo_extension' )       => 'entypo',
			esc_html__( 'Linecons', 'polo_extension' )     => 'linecons',
			esc_html__( 'Custom icon', 'polo_extension' )  => 'custom_icon',
		),
		'admin_label' => true,
		'group'       => $group_name,
		'param_name'  => 'icon_type',
		'description' => esc_html__( 'Select icon library.', 'polo_extension' ),

	);
	if ( isset( $dependancy ) && ! empty( $dependancy ) ) {
		$icon_type['dependency'] = $dependancy;
	}

	$icon_vc_map = array(
		$icon_type,
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'polo_extension' ),
			'param_name'  => 'icon_fontawesome',
			'value'       => 'fa fa-adjust', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'group'       => $group_name,
			'dependency'  => array(
				'element' => 'icon_type',
				'value'   => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'polo_extension' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'polo_extension' ),
			'param_name'  => 'icon_openiconic',
			'value'       => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'group'       => $group_name,
			'dependency'  => array(
				'element' => 'icon_type',
				'value'   => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'polo_extension' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'polo_extension' ),
			'param_name'  => 'icon_typicons',
			'value'       => 'typcn typcn-adjust-brightness',
			// default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'group'       => $group_name,
			'dependency'  => array(
				'element' => 'icon_type',
				'value'   => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'polo_extension' ),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'polo_extension' ),
			'param_name' => 'icon_entypo',
			'value'      => 'entypo-icon entypo-icon-note',
			// default value to backend editor admin_label
			'settings'   => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'group'      => $group_name,
			'dependency' => array(
				'element' => 'icon_type',
				'value'   => 'entypo',
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'polo_extension' ),
			'param_name'  => 'icon_linecons',
			'value'       => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'group'       => $group_name,
			'dependency'  => array(
				'element' => 'icon_type',
				'value'   => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'polo_extension' ),
		),
		array(
			"type"       => "textfield",
			"class"      => "",
			"heading"    => esc_html__( "Custom icon", 'polo_extension' ),
			"param_name" => "icon_custom_icon",
			'group'      => $group_name,
			'dependency' => array(
				'element' => 'icon_type',
				'value'   => 'custom_icon',
			),
		),
	);

	return $icon_vc_map;

}

/**
 * @return array
 */
function crum_vc_animations() {
	$animatons = array(
		''                  => esc_html__( 'None', 'omni' ),
		'bounceIn'          => 'bounceIn',
		'bounceInDown'      => 'bounceInDown',
		'bounceInLeft'      => 'bounceInLeft',
		'bounceInRight'     => 'bounceInRight',
		'bounceInUp'        => 'bounceInUp',
		'fadeIn'            => 'fadeIn',
		'fadeInDown'        => 'fadeInDown',
		'fadeInDownBig'     => 'fadeInDownBig',
		'fadeInLeft'        => 'fadeInLeft',
		'fadeInLeftBig'     => 'fadeInLeftBig',
		'fadeInRight'       => 'fadeInRight',
		'fadeInRightBig'    => 'fadeInRightBig',
		'fadeInUp'          => 'fadeInUp',
		'fadeInUpBig'       => 'fadeInUpBig',
		'flipInX'           => 'flipInX',
		'flipInY'           => 'flipInY',
		'lightSpeedIn'      => 'lightSpeedIn',
		'rotateIn'          => 'rotateIn',
		'rotateInDownLeft'  => 'rotateInDownLeft',
		'rotateInDownRight' => 'rotateInDownRight',
		'rotateInUpLeft'    => 'rotateInUpLeft',
		'rotateInUpRight'   => 'rotateInUpRight',
		'rollIn'            => 'rollIn',
		'zoomIn'            => 'zoomIn',
		'zoomInDown'        => 'zoomInDown',
		'zoomInLeft'        => 'zoomInLeft',
		'zoomInRight'       => 'zoomInRight',
		'zoomInUp'          => 'zoomInUp',
		'slideInDown'       => 'slideInDown',
		'slideInLeft'       => 'slideInLeft',
		'slideInRight'      => 'slideInRight',
		'slideInUp'         => 'slideInUp',
	);

	return $animatons;
}

/**
 * @return array
 */
function crum_soc_networks_list() {
	$soc_networks_array = array(
		"facebook"     => 'Facebook',
		"twitter"      => 'Twitter',
		'vimeo-square' => 'Vimeo',
		"youtube"      => 'Youtube',
		"instagram"    => 'Instagram',
		"stumbleupon"  => 'Stumbleupon',
		"lastfm"       => 'LastFM',
		"pinterest"    => 'Pinterest',
		"google-plus"  => 'Google',
		"dribbble"     => 'Dribble',
		"skype"        => 'Skype',
		"linkedin"     => 'LinkedIN',
		"wordpress"    => 'Wordpress',
		"delicious"    => 'Delicious',
		"behance"      => 'Behance',
		"dropbox"      => 'Dropbox',
		"soundcloud"   => 'Soundcloud',
		"deviantart"   => 'Deviantart',
		"yahoo"        => 'Yahoo',
		"flickr"       => 'Flickr',
		"digg"         => 'Digg',
		"tumblr"       => 'Tumblr',
		"github"       => 'Github',
		"amazon"       => 'Amazon',
		"xing"         => 'Xing',
		"vk"           => 'Vkontakte',
		"windows"      => 'Microsoft',
		"wikipedia"    => 'Wikipedia',
		"imdb"         => 'IMDB',
		"envelope"     => 'Email',
		"rss"          => 'RSS',
		"rocket"		=> 'Rocket',
		"reddit" 		=> 'Reddit',
		"telegram" 		=> 'Telegram'
	); 

	return $soc_networks_array;
}

/**
 * @param $atts
 *
 * @return string
 */
function polo_do_button_shortcode( $atts ) {

	$button_size = $button_type = $button_style = $icon_type = $icon_fontawesome = $icon_openiconic = $icon_typicons = '';
	$icon_entypo = $icon_linecons = $animated_style = $fill_style = $icon_align = $icon_align_animated = '';
	$button_link = $button_text = $button_color = $button_bg_color = $button_text_color = '';


	extract(
		shortcode_atts(
			array(
				'button_size'         => 'default',
				'button_type'         => 'default',
				'button_style'        => 'default',
				'icon_type'           => '',
				'icon_fontawesome'    => 'fa fa-adjust',
				'icon_openiconic'     => 'vc-oi vc-oi-dial',
				'icon_typicons'       => 'typcn typcn-adjust-brightness',
				'icon_entypo'         => 'entypo-icon entypo-icon-note',
				'icon_linecons'       => 'vc_li vc_li-heart',
				'animated_style'      => 'default',
				'fill_style'          => 'default',
				'icon_align'          => 'left',
				'icon_align_animated' => 'left',
				'button_link'         => '',
				'button_text'         => '',
				'button_color'        => '',
				'button_bg_color'     => '',
				'button_text_color'   => '',
				'button_fullwidth'    => '',
				'el_class'            => '',
				'animation'           => '',
				'animation_delay'     => '0',
			), $atts
		)
	);

	$button = '';

	$button .= '[crumina_button ';

	$button .= 'button_size="' . $button_size . '" ';
	$button .= 'button_type="' . $button_type . '" ';
	$button .= 'button_style="' . $button_style . '" ';
	$button .= 'icon_type="' . $icon_type . '" ';
	$button .= 'icon_fontawesome="' . $icon_fontawesome . '" ';
	$button .= 'icon_openiconic="' . $icon_openiconic . '" ';
	$button .= 'icon_typicons="' . $icon_typicons . '" ';
	$button .= 'icon_entypo="' . $icon_entypo . '" ';
	$button .= 'icon_linecons="' . $icon_linecons . '" ';
	$button .= 'animated_style="' . $animated_style . '" ';
	$button .= 'fill_style="' . $fill_style . '" ';
	$button .= 'icon_align="' . $icon_align . '" ';
	$button .= 'icon_align_animated="' . $icon_align_animated . '" ';
	$button .= 'button_link="' . $button_link . '" ';
	$button .= 'button_text="' . $button_text . '" ';
	$button .= 'button_color="' . $button_color . '" ';
	$button .= 'button_bg_color="' . $button_bg_color . '" ';
	$button .= 'button_text_color="' . $button_text_color . '" ';

	$button .= ']';

	return $button;

}

if ( ! function_exists( '_crum_parse_text_shortcode_params' ) ) {
	/**
	 * Parse TEXT params in shortcodes.
	 *
	 * @param $string
	 * @param $tag_class
	 * @param $use_google_fonts
	 * @param $custom_fonts
	 *
	 * @return array
	 */
	function _crum_parse_text_shortcode_params( $string, $tag_class = '', $use_google_fonts = 'no', $custom_fonts = false ) {
		$parsed_param = array();
		$parsed_array = array(
			'style' => '',
			'tag'   => '',
			'class' => '',
			'color' => '',
		);
		$param_value  = explode( '|', $string );

		if ( is_array( $param_value ) ) {
			foreach ( $param_value as $single_param ) {
				$single_param = explode( ':', $single_param );
				if ( isset( $single_param[1] ) && ! empty( $single_param[1] ) ) {
					$parsed_param[ $single_param[0] ] = $single_param[1];
				} else {
					$parsed_param[ $single_param[0] ] = '';
				}
			}
		}

		if ( ! empty( $parsed_param ) && is_array( $parsed_param ) ) {
			$parsed_array['style'] = 'style="';

			if ( 'yes' === $use_google_fonts && class_exists( 'Vc_Google_Fonts' ) ) {

				$google_fonts_obj  = new Vc_Google_Fonts();
				$google_fonts_data = strlen( $custom_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( array(), $custom_fonts ) : '';

				$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
				$parsed_array['style'] .= 'font-family:' . $google_fonts_family[0] . ' !important; ';
				$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
				$parsed_array['style'] .= 'font-weight:' . $google_fonts_styles[1] . ' !important; ';
				$parsed_array['style'] .= 'font-style:' . $google_fonts_styles[2] . ' !important; ';

				$settings = get_option( 'wpb_js_google_fonts_subsets' );
				if ( is_array( $settings ) && ! empty( $settings ) ) {
					$subsets = '&subset=' . implode( ',', $settings );
				} else {
					$subsets = '';
				}

				if ( isset( $google_fonts_data['values']['font_family'] ) && function_exists( 'vc_build_safe_css_class' ) ) {
					wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
				}
			}

			foreach ( $parsed_param as $key => $value ) {

				if ( strlen( $value ) > 0 ) {
					if ( 'font_style_italic' === $key ) {
						$parsed_array['style'] .= 'font-style:italic !important; ';
					} elseif ( 'font_style_bold' === $key ) {
						$parsed_array['bold'] = true;
						$parsed_array['style'] .= 'font-weight:bold !important; ';
					} elseif ( 'font_style_underline' === $key ) {
						$parsed_array['style'] .= 'text-decoration:underline !important; ';
					} elseif ( 'color' === $key ) {
						$parsed_array['style'] .= $key . ': ' . str_replace( '%23', '#', $value ) . ' !important; ';
						$parsed_array['color'] = str_replace( '%23', '#', $value );
					} elseif ( 'tag' === $key ) {
						$parsed_array['tag'] = $value;
					} else {
						$parsed_array['style'] .= str_replace( '_', '-', $key ) . ': ' . $value . 'px; ';
					}
				}
			}
			$parsed_array['style'] .= '"';
			if ( 1 === count( $parsed_param ) && isset( $parsed_param['tag'] ) && !('yes' ===$use_google_fonts)) {
				$parsed_array['style'] = '';
			}
			if ( isset( $parsed_array['tag'] ) ) {
				$parsed_array['class'] = $tag_class;
			}
		}

		return $parsed_array;
	}
}

if ( ! ( function_exists( 'crumina_relative_time' ) ) ) {
	/**
	 * @param $a
	 *
	 * @return string
	 */
	function crumina_relative_time( $a ) {
		//get current timestampt
		$b = strtotime( "now" );
		//get timestamp when tweet created
		//get difference
		$d = $b - $a;
		//calculate different time values
		$minute = 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;
		$week   = $day * 7;

		if ( is_numeric( $d ) && $d > 0 ) {
			//if less then 3 seconds
			if ( $d < 3 ) {
				return "right now";
			}
			//if less then minute
			if ( $d < $minute ) {
				return floor( $d ) . esc_html__( " sec ago", 'polo_extension' );
			}
			//if less then 2 minutes
			if ( $d < $minute * 2 ) {
				return "about 1 minute ago";
			}
			//if less then hour
			if ( $d < $hour ) {
				return floor( $d / $minute ) . esc_html__( " min ago", 'polo_extension' );
			}
			//if less then 2 hours
			if ( $d < $hour * 2 ) {
				return esc_html__( "about 1 hour ago...", 'polo_extension' );
			}
			//if less then day
			if ( $d < $day ) {
				return floor( $d / $hour ) . esc_html__( " h ago", 'polo_extension' );
			}
			//if more then day, but less then 2 days
			if ( $d > $day && $d < $day * 2 ) {
				return esc_html__( "yesterday", 'polo_extension' );
			}
			//if less then year
			if ( $d < $day * 365 ) {
				return floor( $d / $day ) . esc_html__( " days ago", 'polo_extension' );
			}

			//else return more than a year
			return esc_html__( "over a year ago", 'polo_extension' );
		}
	}
}

function crumina_tag_cloud_size($args){

	$args['smallest'] = '8';
	$args['largest'] = '8';

	return $args;

}
add_filter('woocommerce_product_tag_cloud_widget_args','crumina_tag_cloud_size');
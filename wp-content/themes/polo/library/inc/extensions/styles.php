<?php
/*
 * Theme styles and custom CSS
 */

add_action( 'wp_enqueue_scripts', 'polo_register_styles', 1 );
add_action( 'wp_enqueue_scripts', 'polo_enqueue_styles', 15 );

//custom styles
add_action( 'wp_enqueue_scripts', 'polo_custom_styles', 99 );

//admin styles
add_action( 'admin_enqueue_scripts', 'polo_enqueue_admin_styles' );

function polo_custom_google_fonts_list() {
	$google_fonts = array();

	$tags = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'menu' );

	$google_fonts['body'] = reactor_option( 'body-typography' );
	$google_fonts['h1']   = reactor_option( 'h1-typography' );
	$google_fonts['h2']   = reactor_option( 'h2-typography' );
	$google_fonts['h3']   = reactor_option( 'h3-typography' );
	$google_fonts['h4']   = reactor_option( 'h4-typography' );
	$google_fonts['h5']   = reactor_option( 'h5-typography' );
	$google_fonts['h6']   = reactor_option( 'h6-typography' );
	$google_fonts['menu'] = reactor_option( 'menu-typography' );

	$page_meta = get_post_meta( get_the_ID(), 'meta_page_typography', true );

	foreach ( $tags as $single_tag ) {
		if (
			isset( $page_meta[ $single_tag . '-typography' ] ) &&
			! empty( $page_meta[ $single_tag . '-typography' ] ) &&
			'crum_default' !== $page_meta[ $single_tag . '-typography' ]['family'] &&
			! empty( $page_meta[ $single_tag . '-typography' ]['family'] )
		) {
			$google_fonts[ $single_tag ] = $page_meta[ $single_tag . '-typography' ];
		}
	}

	return $google_fonts;
}



/**
 * Register frontend styles
 */
function polo_register_styles() {

	wp_register_style( 'share-likely', POLO_ROOT_URL . '/assets/css/likely.css', array(), false, 'all' );
	wp_register_style( 'crum-demo', POLO_ROOT_URL . '/assets/css/demo.css', array(), false, 'all' );
	wp_register_style( 'crum-theme-elements', POLO_ROOT_URL . '/assets/css/theme-elements.css', array(), false, 'all' );

	/*
	 * Color scheme
	 */
	$metabox_source     = polo_get_metabox_source();
	$color_scheme = polo_get_theme_settings( 'theme-color-scheme', 'meta-theme-color-scheme', $metabox_source );

	if ( isset( $color_scheme ) && ! empty( $color_scheme ) && is_string( $color_scheme ) ) {
		$scheme = $color_scheme;
	} elseif( is_page() ) {
		$scheme = 'blue';
	} else {
		$scheme = '';
	}
	if ( ! empty( $scheme ) &&  'custom' !== $color_scheme ) {
		wp_register_style( 'crum-custom-' . $scheme, POLO_ROOT_URL . '/assets/css/color-variations/' . $scheme . '.css', array(), false, 'all' );
	}
}

/**
 * Enqueue frontend styles
 */
function polo_enqueue_styles() {

	/*-- Bootstrap Core CSS --*/
	wp_enqueue_style( 'bootstrap', POLO_ROOT_URL . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), '3.3.6', 'all' );
	wp_enqueue_style( 'theme-awesome', POLO_ROOT_URL . '/assets/vendor/fontawesome/css/font-awesome.min.css', array(), '4.7.0', 'all' );
	wp_enqueue_style( 'animateit', POLO_ROOT_URL . '/assets/vendor/animateit/animate.min.css', array(), false, 'all' );

	/*-- Vendor css --*/
	wp_enqueue_style( 'owl-carousel', POLO_ROOT_URL . '/assets/vendor/owlcarousel/owl.carousel.css', array(), '2.0.0', 'all' );
	wp_enqueue_style( 'magnific-popup', POLO_ROOT_URL . '/assets/vendor/magnific-popup/magnific-popup.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'share-likely' );

	wp_enqueue_style( 'crum-theme-elements' );
	wp_enqueue_style( 'theme-base-style', get_template_directory_uri() . '/style.css', array(), false, 'all' );
	wp_enqueue_style( 'crum-theme-font', polo_google_font_url(), array(), '1.0.0' );


	/*
	 * Custom color scheme
	 */
	$metabox_source     = polo_get_metabox_source();

	$color_scheme = polo_get_theme_settings( 'theme-color-scheme', 'meta-theme-color-scheme', $metabox_source );

	if ( isset( $color_scheme ) && ! empty( $color_scheme ) && is_string( $color_scheme ) ) {
		$scheme = $color_scheme;
	} else {
		$scheme = 'blue';
	}
	if ( 'custom' !== $color_scheme ) {
		wp_enqueue_style( 'crum-custom-' . $scheme );
	}
}

/**
 * Register Lato Google font.
 *
 * @param array $font_families
 *
 * @return string
 */
if ( ! function_exists( 'polo_google_font_url' ) ) {
	function polo_google_font_url() {

		$metabox_source     = polo_get_metabox_source();
		$meta_st_head_text_color = reactor_option( 'meta-color-text-typography', '', $metabox_source );

		
		$stuning_text_color = reactor_option( 'st-color-text-typography' );
		if ( isset( $stuning_text_color['family'] ) && ! empty( $stuning_text_color['family'] ) ) {
			$font_families[] = $stuning_text_color['family'].':'.$stuning_text_color['variant'];
		}
		if ( isset( $meta_st_head_text_color ) && ! empty( $meta_st_head_text_color ) ) {
			$family = _polo_get_key_value( $meta_st_head_text_color, 'family' );
			if ( ! empty( $family ) ) {
				$font_families[] = $family . ':' . _polo_get_key_value( $meta_st_head_text_color, 'variant' );
			}
		}

		$typography_custom_fonts = polo_custom_google_fonts_list();
		foreach ( $typography_custom_fonts as $tag => $single_font ) {
			if ( isset( $single_font['family'] ) && 'crum_default' !== $single_font['family'] &&
			     ! empty( $single_font['family'] ) && isset( $single_font['font'] ) && $single_font['font'] !== 'websafe'
			) {
				$font_families[] = $single_font['family'] . ':' . $single_font['variant'] . '';
			}
		}
		$font_families[]     = 'Open+Sans:400,300,800,700,600';
		$font_families[]     = 'Raleway:100,300,600,700,800';
		$custom_google_fonts = implode( '|', $font_families );
		$font_url            = esc_url( add_query_arg( 'family', urlencode( $custom_google_fonts ),
			"//fonts.googleapis.com/css" ) );
		$font_url            = str_replace( '%2B', '+', $font_url );

		return $font_url;
	}
}

/**
 * Enqueue admin styles
 */
function polo_enqueue_admin_styles() {
	wp_enqueue_style( 'crum-admin-styles', POLO_ROOT_URL . '/assets/css/admin.css', array(), false, 'all' );
}

/**
 * Inline CSS
 */
function polo_custom_styles() {
	$custom_css              = '';
	$metabox_source     = polo_get_metabox_source();
	$meta_st_head_text_color = reactor_option( 'meta-color-text-typography', '', $metabox_source );

	$stuning_text_color = reactor_option( 'st-color-text-typography' );

	if ( isset( $stuning_text_color ) && ! empty( $stuning_text_color ) ) {
		$font_style = polo_typography_variant($stuning_text_color['variant']);
		$custom_css .= '.page-title h1, .page-title span, .trail-item span, .trail-item::before';
		$custom_css .= '{color:' . $stuning_text_color['color'] . '!important; font-family:' . $stuning_text_color['family'] . '; ' . $font_style . '; line-height:' . $stuning_text_color['height'] . 'px;}';
		$custom_css .= '.page-title h1';
		$custom_css .= '{font-size:' . $stuning_text_color['size'] . 'px;}';
	}
	if ( isset( $meta_st_head_text_color ) && ! empty( $meta_st_head_text_color ) ) {
		$font_style  = '';
		$color       = _polo_get_key_value( $meta_st_head_text_color, 'color' );
		$font_family = _polo_get_key_value( $meta_st_head_text_color, 'family' );
		$size        = _polo_get_key_value( $meta_st_head_text_color, 'size' );
		$line_height = _polo_get_key_value( $meta_st_head_text_color, 'height' );
		if ( ! empty( $font_family ) ) {
			$font_style = polo_typography_variant( _polo_get_key_value( $meta_st_head_text_color, 'variant' ) );
			$custom_css .= '.page-title h1 {';
			$custom_css .= 'font-family:' . $font_family . ';';
			$custom_css .= '}';

		}
		if ( ! empty( $color ) || ! empty( $font_style ) || ! empty( $size ) || ! empty( $line_height ) ) {
			$custom_css .= '.page-title h1, .page-title span, .trail-item span, .trail-item::before{';
			if ( ! empty( $font_style ) ) {
				$custom_css .= $font_style;
			}
			if ( ! empty( $color ) ) {
				$custom_css .= 'color:' . $color . ' !important;';
			}
			if ( ! empty( $size ) ) {
				$custom_css .= 'font-size:' . $size . 'px;';
			}
			if ( ! empty( $line_height ) ) {
				$custom_css .= 'line-height:' . $line_height . 'px;';
			}
			$custom_css .= '}';
		}
	}


	/*
	 * Custom top bar styles
	 */
	$logo_height = reactor_option( 'logo_height' );

	if ( isset( $logo_height ) && ! empty ( $logo_height ) ) {
		$custom_css .= '#logo, #logo img';
		$custom_css .= '{max-height:' . $logo_height . 'px ;}';
		$custom_css .= '#header,#header-wrap,#header.header-sticky:not(.header-static) nav#mainMenu ul.main-menu,#mainMenu > ul,#header.header-sticky:not(.header-static) .nav-main-menu-responsive,#header .side-panel-button';
		$custom_css .= '{height:' . $logo_height . 'px ;}';
		$custom_css .= '#header.header-modern + section,#header.header-transparent+section, #header.header-dark-transparent+section, #header.header-light-transparent+section , #header.header-transparent + .page-title-parallax';
		$custom_css .= '{top:-' . $logo_height . 'px ;margin-bottom:-' . $logo_height . 'px ;}';
		$custom_css .= '#header #top-search a i';
		$custom_css .= '{line-height:' . $logo_height . 'px}';

	}

	$top_bar_color        = reactor_option( 'top-bar-color' );
	$top_bar_custom_bg    = reactor_option( 'top-bar-custom-bg-color' );
	$top_bar_custom_color = reactor_option( 'top-bar-custom-color' );

	$meta_top_bar_enable = reactor_option( 'meta-top-bar-enable', '', $metabox_source );
	$meta_top_bar_color = reactor_option( '_meta-top-bar-color', '', $metabox_source );
	$meta_top_bar_custom_bg = reactor_option( 'meta-top-bar-color', '', $metabox_source );
	$meta_top_bar_custom_color = reactor_option( 'meta-top-bar-custom-color', '', $metabox_source );

	if ( isset( $meta_top_bar_color ) && ! empty( $meta_top_bar_color ) && ! ( 'default' === $meta_top_bar_color ) ) {
		$top_bar_color = $meta_top_bar_color;
	}

	if ( isset( $meta_top_bar_custom_bg ) && ! empty( $meta_top_bar_custom_bg ) && ! ( 'default' === $meta_top_bar_color ) && ! ( 'default' == $meta_top_bar_enable ) ) {
		$top_bar_custom_bg = $meta_top_bar_custom_bg;
	}

	if ( isset( $meta_top_bar_custom_color ) && ! empty( $meta_top_bar_custom_color ) && ! ( 'default' === $meta_top_bar_color ) && ! ( 'default' == $meta_top_bar_enable ) ) {
		$top_bar_custom_color = $meta_top_bar_custom_color;
	}

	if ( isset( $top_bar_color ) && ( 'custom' === $top_bar_color ) ) {
		if ( isset( $top_bar_custom_bg ) && ! empty( $top_bar_custom_bg ) ) {
			$custom_css .= '#topbar';
			$custom_css .= '{background-color:' . $top_bar_custom_bg . ' !important;}';
			$custom_css .= '#topbar';
			$custom_css .= '{border-bottom-color:' . $top_bar_custom_bg . '}';
		}
		if ( isset( $top_bar_custom_color ) && ! empty( $top_bar_custom_color ) ) {
			$custom_css .= '#topbar, .topbar-custom a, .topbar-custom .social-icons li a';
			$custom_css .= '{color:' . $top_bar_custom_color . '; !important}';
			$custom_css .= '.topbar-custom .top-menu > li > a:hover ';
			$custom_css .= '{color:' . adjustBrightness( $top_bar_custom_color, - 30 ) . '}';
		}
	}


	$st_head_style    = reactor_option( 'stunning-header-style' );
	$st_head_bg_image = reactor_option( 'st-header-bg-image' );

	$meta_st_head_style = reactor_option( 'meta-stunning-header-style', '', $metabox_source );
	$meta_st_head_bg_image = reactor_option( 'meta-st-header-bg-image', '', $metabox_source );

	if ( isset( $meta_st_head_style ) && ! empty( $meta_st_head_style ) ) {
		$st_head_style = $meta_st_head_style;
	}

	if ( isset( $meta_st_head_bg_image ) && ! empty( $meta_st_head_bg_image ) ) {
		$st_head_bg_image = $meta_st_head_bg_image;
	}

	if ( isset( $st_head_bg_image ) && ! empty( $st_head_bg_image ) && isset( $st_head_style ) && ( ( 'default' === $st_head_style ) || ( 'pattern' === $st_head_style ) ) ) {
		$custom_css .= '#page-title';
		$custom_css .= '{background-image:url("' . wp_get_attachment_url( $st_head_bg_image ) . '")}';
	}

	$st_head_video_embed = reactor_option( 'st-header-embed-video-bg' );

	if ( isset( $st_head_video_embed ) && ! empty( $st_head_video_embed ) ) {
		$custom_css .= '.stunning-header-video-embed';
		$custom_css .= '{visibility: visible; margin: auto; position: absolute; z-index: -1; top: 50%; left: 0%; transform: translate(0%, -50%); width: 1905px; height: auto;}';
	}

	$st_head_height = reactor_option( 'st-header-height' );

	$meta_st_head_height = reactor_option( 'meta-st-header-height', '', $metabox_source );

	if ( isset( $meta_st_head_height ) && ! empty( $meta_st_head_height )  ) {
		$st_head_height = $meta_st_head_height;
	}

	if ( isset( $st_head_height ) && ! empty( $st_head_height ) ) {
		$classic_header_style = reactor_option( 'classic_header_style' );

		$custom_css .= '@media (min-width: 991px){';
		$custom_css .= '#page-title{';
		$custom_css .= 'padding-bottom:' . intval( ( $st_head_height - 100 )/ 2 - 25 ) . 'px !important;';
		if (strpos('transparent',$classic_header_style)){
			$custom_css .= 'padding-top:' . intval( ( $st_head_height - 100 ) / 2 + 90 ) . 'px !important;}';
		} else {
			$custom_css .= 'padding-top:' . intval( ( $st_head_height - 100 ) / 2- 25 ) . 'px !important;}';
		}
		$custom_css .= '}';
	}

	$st_head_text_color = reactor_option( 'st-header-text-color' );

	$meta_st_head_text_color = reactor_option( 'meta-st-header-text-color', '', $metabox_source );

	if ( isset( $meta_st_head_text_color ) && ! empty( $meta_st_head_text_color ) && ! is_array( $meta_st_head_text_color ) ) {
		$st_head_text_color = $meta_st_head_text_color;
	}

	if ( isset( $st_head_text_color ) && ! empty( $st_head_text_color ) ) {
		$custom_css .= '.custom-heading-colored{';
		$custom_css .= 'color:' . $st_head_text_color . '}';
		$custom_css .= '.breadcrumb a{color:inherit !important}';
		$custom_css .= '.page-title h1{color:inherit}';
	}

	$custom_css .= polo_typography_customization( 'h1' );
	$custom_css .= polo_typography_customization( 'h2' );
	$custom_css .= polo_typography_customization( 'h3' );
	$custom_css .= polo_typography_customization( 'h4' );
	$custom_css .= polo_typography_customization( 'h5' );
	$custom_css .= polo_typography_customization( 'h6' );
	$custom_css .= polo_typography_customization( 'body' );
	$custom_css .= polo_typography_customization( 'menu' );

	$boxed_body = reactor_option( 'boxed-body' );

	$meta_boxed_body = polo_metaselect_to_switch( reactor_option( 'meta-boxed-body', '', $metabox_source ) );

	if ( ! ( null === $meta_boxed_body ) ) {
		$boxed_body = $meta_boxed_body;
	}

	if ( true === $boxed_body ) {
		$boxed_body_bg = reactor_option( 'boxed_body_background' );
		$meta_boxed_body_bg = reactor_option( 'boxed_body_background', '', $metabox_source );

		if ( is_array( $boxed_body_bg ) && ! empty( $boxed_body_bg ) ) {
			foreach ( $boxed_body_bg as $attr => $value ) {
				if ( isset( $meta_boxed_body_bg[ $attr ] ) && ! empty( $meta_boxed_body_bg[ $attr ] ) ) {
					$boxed_body_bg[ $attr ] = $meta_boxed_body_bg[ $attr ];
				}
			}
		} elseif ( empty( $boxed_body_bg ) && ! empty( $meta_boxed_body_bg ) ) {
			$boxed_body_bg = $meta_boxed_body_bg;
		}

		if ( isset( $boxed_body_bg ) && ! empty( $boxed_body_bg ) ) {

			$custom_css .= '.boxed-body-custom-background{';

			if ( isset( $boxed_body_bg['color'] ) && ! empty( $boxed_body_bg['color'] ) ) {
				$custom_css .= 'background-color:' . $boxed_body_bg['color'] . ';';
				if ( empty( $meta_boxed_body_bg['image'] ) ) {
					$boxed_body_bg['image'] = '';
				}
			}
			if ( isset( $boxed_body_bg['image'] ) && ! empty( $boxed_body_bg['image'] ) ) {
				$custom_css .= 'background-image:url(' . $boxed_body_bg['image'] . ');';
			}
			if ( isset( $boxed_body_bg['repeat'] ) && ! empty( $boxed_body_bg['repeat'] ) ) {
				$custom_css .= 'background-repeat:' . $boxed_body_bg['repeat'] . ';';
			}
			if ( isset( $boxed_body_bg['position'] ) && ! empty( $boxed_body_bg['position'] ) ) {
				$custom_css .= 'background-position:' . $boxed_body_bg['position'] . ';';
			}
			if ( isset( $boxed_body_bg['attachment'] ) && ! empty( $boxed_body_bg['attachment'] ) ) {
				$custom_css .= 'background-attachment:' . $boxed_body_bg['attachment'] . ';';
			}

			$custom_css .= '}';
		}
	} elseif ( false === $boxed_body ) {
		$normal_body_bg = reactor_option( 'normal_body_background' );
		$meta_normal_body_bg = reactor_option( 'normal_body_background', '', $metabox_source );

		if ( is_array( $normal_body_bg ) && ! empty( $normal_body_bg ) ) {
			foreach ( $normal_body_bg as $key => $attribute ) {
				if ( isset( $meta_normal_body_bg[ $key ] ) && ! empty( $meta_normal_body_bg[ $key ] ) ) {
					$normal_body_bg[ $key ] = $meta_normal_body_bg[ $key ];
				}
			}
		} elseif ( empty( $normal_body_bg ) && ! empty( $meta_normal_body_bg ) ) {
			$normal_body_bg = $meta_normal_body_bg;
		}

		if ( is_array( $normal_body_bg ) ) {
			$normal_body_bg = array_filter( $normal_body_bg );
		}

		if ( isset( $normal_body_bg ) && ! empty( $normal_body_bg ) ) {

			$custom_css .= '.body-custom-background{';

			if ( isset( $normal_body_bg['color'] ) && ! empty( $normal_body_bg['color'] ) ) {
				$custom_css .= 'background-color:' . $normal_body_bg['color'] . ';';
				if ( empty( $meta_normal_body_bg['image'] ) ) {
					$normal_body_bg['image'] = '';
				}
			}
			if ( isset( $normal_body_bg['image'] ) && ! empty( $normal_body_bg['image'] ) ) {
				$custom_css .= 'background-image:url(' . $normal_body_bg['image'] . ');';
			}
			if ( isset( $normal_body_bg['repeat'] ) && ! empty( $normal_body_bg['repeat'] ) ) {
				$custom_css .= 'background-repeat:' . $normal_body_bg['repeat'] . ';';
			}
			if ( isset( $normal_body_bg['position'] ) && ! empty( $normal_body_bg['position'] ) ) {
				$custom_css .= 'background-position:' . $normal_body_bg['position'] . ';';
			}
			if ( isset( $normal_body_bg['attachment'] ) && ! empty( $normal_body_bg['attachment'] ) ) {
				$custom_css .= 'background-attachment:' . $normal_body_bg['attachment'] . ';';
			}
			$custom_css .= '}';
		}
	}

	$custom_css_code = reactor_option( 'css-code' );

	if ( isset( $custom_css_code ) && ! empty( $custom_css_code ) ) {
		$custom_css .= $custom_css_code;
	}

	wp_add_inline_style( 'theme-base-style', $custom_css );

}
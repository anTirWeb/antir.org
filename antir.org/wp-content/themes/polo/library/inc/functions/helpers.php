<?php
function polo_set_layout( $page, $width, $open = true ) {


	$page  = reactor_option( $page, '2c-r-fixed' );
	$width = reactor_option( $width, 'sidebar-3-column' );

	$sidebar_style = '';

	$classes = array();

	if ( is_singular( 'post' ) ) {
		$meta_page = reactor_option( 'meta-single-main-sidebar', '', 'meta_post_options' );
		if ( ! ( reactor_option( 'meta-single-sidebar-width', '', 'meta_post_options' ) == 'default' ) ) {
			$meta_width = reactor_option( 'meta-single-sidebar-width', '', 'meta_post_options' );
		}
		$post_style      = reactor_option( 'single_post_style' );
		$meta_post_style = reactor_option( 'single_post_style', '', 'meta_post_options' );
		if ( isset( $meta_post_style ) && ! ( 'default' === $meta_post_style ) ) {
			$post_style = $meta_post_style;
		}
		if ( 'modern' === $post_style ) {
			$style_class = 'post-modern';
		} else {
			$style_class = '';
		}
		$classes[]     = $style_class . ' post-content-single';
		$sidebar_style = reactor_option( 'single-sidebar-style' );
		if ( ! ( 'default' === reactor_option( 'meta-single-sidebar-style', '', 'meta_post_options' ) ) ) {
			$sidebar_style = reactor_option( 'meta-single-sidebar-style', '', 'meta_post_options' );
		}
	} elseif ( is_singular( 'page' ) ) {
		$meta_page = reactor_option( 'meta-page-main-sidebar', '', 'meta_page_options' );
		if ( ! ( reactor_option( 'meta-page-sidebar-width', '', 'meta_page_options' ) == 'default' ) ) {
			$meta_width = reactor_option( 'meta-page-sidebar-width', '', 'meta_page_options' );
		}
		$sidebar_style      = reactor_option( 'page-sidebar-style' );
		$meta_sidebar_style = reactor_option( 'meta-page-sidebar-style', '', 'meta_page_options' );
		if ( isset( $meta_sidebar_style ) && ! empty( $meta_sidebar_style ) && ! ( 'default' === $meta_sidebar_style ) ) {
			$sidebar_style = $meta_sidebar_style;
		}
	} elseif ( post_type_exists( 'portfolio' ) && is_singular( 'portfolio' ) ) {
		$page_layout = reactor_option( 'portfolio-single-layout', '', '_portfolio_single_options' );
		$meta_page   = reactor_option( 'meta-page-main-sidebar', '', '_portfolio_single_options' );
		if ( ! ( 'full' === $page_layout ) ) {
			$meta_page = '1col-fixed';
		}
		if ( ! ( reactor_option( 'meta-page-sidebar-width', '', '_portfolio_single_options' ) == 'default' ) ) {
			$meta_width = reactor_option( 'meta-page-sidebar-width', '', '_portfolio_single_options' );
		}
		$sidebar_style      = reactor_option( 'portfolio-sidebar-style' );
		$meta_sidebar_style = reactor_option( 'meta-page-sidebar-style', '', '_portfolio_single_options' );
		if ( isset( $meta_sidebar_style ) && ! empty( $meta_sidebar_style ) && ! ( 'default' === $meta_sidebar_style ) ) {
			$sidebar_style = $meta_sidebar_style;
		}
	} elseif ( post_type_exists( 'product' ) && is_singular( 'product' ) ) {
		$meta_page = reactor_option( 'meta-product-main-sidebar', '', 'single_product_layout' );
		$width     = 'sidebar-3-column';
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$width = 'sidebar-3-column';
	} elseif ( is_search() ) {
		$sidebar_style = reactor_option( 'search-sidebar-style' );
	} elseif ( is_archive() || is_home() ) {
		$sidebar_style = reactor_option( 'archive-main-sidebar' );
	} elseif ( is_404() ) {
		$sidebar_style = reactor_option( '404-sidebar-style' );
	}

	if ( 'modern' === $sidebar_style ) {
		$style_class = 'sidebar-modern';
	} else {
		$style_class = '';
	}

	if ( isset( $meta_page ) && ! ( $meta_page == '' ) && ! ( $meta_page == 'default' ) ) {

		$page = $meta_page;
	}

	if ( isset( $meta_width ) && ! ( $meta_width == '' ) && ! ( $meta_width == 'default' ) ) {

		$width = $meta_width;

	}

	if ( ! ( '1col-fixed' === $page ) ) {
		if ( is_singular( 'post' ) ) {
			$classes[] = 'post-content';
		} elseif ( is_singular( 'page' ) ) {
			$classes[] = 'post-content';
		} elseif ( post_type_exists( 'portfolio' ) && is_singular( 'portfolio' ) ) {
			$classes[] = 'post-content';
		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			$classes[] = 'post-content';
		}
	}

	$classes = implode( ' ', $classes );

	$content_width = $sidebar_width = $sidebar_align = '';

	if ( '1col-fixed' === $page ) {
		$content_width = 'col-xs-12';
		$sidebar_align = 'no-sidebar';
	} else {

		if ( '2c-l-fixed' === $page ) {
			$sidebar_align = 'sidebar-left';
		}
		if ( '2c-r-fixed' === $page ) {
			$sidebar_align = 'sidebar-right';
		}
		if ( '2c-b-fixed' === $page ) {
			$sidebar_align = 'sidebar-both';
		}

		if ( 'sidebar-2-column' === $width ) {
			$content_width = 'col-lg-10 col-md-10 col-sm-10 col-xs-12';
			$sidebar_width = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
		} elseif ( 'sidebar-3-column' === $width ) {
			$content_width = 'col-lg-9 col-md-9 col-sm-9 col-xs-12';
			$sidebar_width = 'col-lg-3 col-md-3 col-sm-3 col-xs-12';
		} elseif ( 'sidebar-4-column' === $width ) {
			$content_width = 'col-lg-8 col-md-8 col-sm-8 col-xs-12';
			$sidebar_width = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
		} elseif ( 'sidebar-5-column' === $width ) {
			$content_width = 'col-lg-7 col-md-7 col-sm-7 col-xs-12';
			$sidebar_width = 'col-lg-5 col-md-5 col-sm-5 col-xs-12';
		}

		if ( '2c-b-fixed' === $page ) {
			$content_width = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
			$sidebar_width = 'col-lg-3 col-md-3 col-sm-3 col-xs-12';
			$style_class   = '';
		}
	}

	if ( $open == false ) {
		if ( $page == '1col-fixed' ) {

			echo '</div></div>';

		} else {

			if ( '2c-r-fixed' === $page ) {
				$sidebar_name = 'secondary';
			} else {
				$sidebar_name = '';
			}

			echo '</div><div id="sidebar" class="' . $sidebar_width . ' sidebar ' . $style_class . '">';
			get_sidebar( $sidebar_name );
			echo '</div>';

		}

		return;
	}

	if ( '2c-l-fixed' === $page ) {
		$sidebar_float = 'float-right';
	} else {
		$sidebar_float = '';
	}

	$output = '';

	$output .= '<div class="row ' . $sidebar_align . '">';
	if ( '2c-b-fixed' === $page ) {
		$output .= '<div id="sidebar" class="' . $sidebar_width . ' sidebar ' . $style_class . '">';
		ob_start();
		get_sidebar( 'secondary' );
		$output .= ob_get_clean();
		$output .= '</div>';
	}
	$output .= '<div id="main-content" class="' . $content_width . ' ' . $classes . ' ' . $sidebar_float . '">';

	echo( $output );

}

add_filter( 'widget_tag_cloud_args', 'polo_widget_tag_cloud_args' );
function polo_widget_tag_cloud_args( $args ) {
	$args['largest']  = 11;
	$args['smallest'] = 11;
	$args['unit']     = 'px';

	return $args;
}

if ( ! ( function_exists( 'adjustBrightness' ) ) ) {
	function adjustBrightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max( - 255, min( 255, $steps ) );

		// Format the hex color string
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// Adjust number of steps and keep it inside 0 to 255
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}
}

if ( ! function_exists( 'polo_get_sidebar' ) ) {
	function polo_get_sidebar( $sidebar_name ) {

		$output = '';

		ob_start();
		dynamic_sidebar( $sidebar_name );
		$output .= ob_get_clean();

		return $output;

	}
}

if ( ! function_exists( 'polo_do_logo' ) ) {
	function polo_do_logo( $logo_image, $retina_image ) {

		$footer_top_panel_style = reactor_option( 'footer-top-panel-style' );

		if ( isset( $footer_top_panel_style ) && ( 'style_2' === $footer_top_panel_style ) ) {
			$custom_style_retina = 'margin-left: -4px; margin-bottom: 12px; margin-top: 12px;';
			$custom_style        = 'style="margin-left: -4px; margin-bottom: 12px; margin-top: 12px;"';
		} else {
			$custom_style_retina = $custom_style = '';
		}

		if ( isset( $retina_image ) && ! ( $retina_image == '' ) ) {
			$image_size = wp_get_attachment_metadata( $retina_image );
			if ( $retina_image ) {
				$image_size = absint( $image_size['width'] / 2 );
			}
			$logo_image = '<img src="' . esc_url( wp_get_attachment_url( $retina_image ) ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" style="width:' . $image_size . 'px; ' . $custom_style_retina . '">';
		} elseif ( isset( $logo_image ) && ! ( $logo_image == '' ) ) {
			$logo_image = '<img src="' . esc_url( wp_get_attachment_url( $logo_image ) ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ' . $custom_style . '>';
		} else {
			$logo_image = '';
		}

		return $logo_image;
	}
}

if ( ! function_exists( 'polo_do_multilang_text' ) ) {
	function polo_do_multilang_text( $multilang_text ) {

		if ( function_exists( 'icl_object_id' ) ) {
			$current_language = ICL_LANGUAGE_CODE;
			if ( isset( $multilang_text[ $current_language ] ) && ! empty( $multilang_text[ $current_language ] ) ) {
				$multilang_text = $multilang_text[ $current_language ];
			}
		}

		if ( is_array( $multilang_text ) ) {
			$multilang_text = array_slice( $multilang_text, 0, 1 );
			$multilang_text = implode( $multilang_text );
		}

		return $multilang_text;
	}
}

function polo_oembed_fetch_url( $provider, $url, $args ) {

	if ( strpos( $provider, 'vimeo.com' ) !== false ) {

		if ( isset( $args['autoplay'] ) ) {
			$provider = add_query_arg( 'autoplay', absint( $args['autoplay'] ), $provider );
		}

		if ( isset( $args['automute'] ) ) {
			$provider = add_query_arg( 'automute', absint( $args['automute'] ), $provider );
		}

	}

	return $provider;

}

add_filter( 'oembed_fetch_url', 'polo_oembed_fetch_url', 10, 3 );

if ( ! function_exists( 'polo_metaselect_to_switch' ) ) {

	function polo_metaselect_to_switch( $data ) {

		if ( isset( $data ) && ! empty( $data ) && ! ( 'default' === $data ) ) {
			if ( 'true' === $data ) {
				return true;
			} elseif ( 'false' === $data ) {
				return false;
			}
		}

		return null;

	}

}

add_action( 'comment_post', 'save_comment_meta_data' );

function save_comment_meta_data( $comment_id ) {
	add_comment_meta( $comment_id, 'phone', $_POST['phone'] );
}

function polo_contact_form_fields_order( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'polo_contact_form_fields_order' );

if ( ! function_exists( 'polo_theme_thumb' ) ) {
	function polo_theme_thumb( $url, $width, $height = 0, $crop, $align = '' ) {
		if ( extension_loaded( 'gd' ) ) {
			return mr_image_resize( $url, $width, $height, $crop, $align, false );
		} else {
			return $url;
		}
	}
}

function polo_body_class( $classes ) {

	$header_style = reactor_option( 'header_style' );
	if ( is_singular( 'portfolio' ) ) {
		$meta_header_style = reactor_option( 'header_style', '', 'meta_portfolio_heading_options' );
	} else {
		$meta_header_style = reactor_option( 'header_style', '', 'meta_page_options' );
	}
	if ( isset( $meta_header_style ) && ! empty( $meta_header_style ) && ! ( 'default' === $meta_header_style ) ) {
		$header_style = $meta_header_style;
	}

	if ( is_page_template( 'page-templates/shop-page.php' ) && class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce';
	}

	$boxed_body = reactor_option( 'boxed-body' );
	if ( is_singular( 'portfolio' ) ) {
		$meta_boxed_body = polo_metaselect_to_switch( reactor_option( 'meta-boxed-body', '', 'meta_portfolio_heading_options' ) );
	} else {
		$meta_boxed_body = polo_metaselect_to_switch( reactor_option( 'meta-boxed-body', '', 'meta_page_options' ) );
	}

	if ( ! ( null === $meta_boxed_body ) ) {
		$boxed_body = $meta_boxed_body;
	}

	$boxed_body_bg = reactor_option( 'boxed_body_background' );
	if ( is_singular( 'portfolio' ) ) {
		$meta_boxed_body_bg = reactor_option( 'boxed_body_background', '', 'meta_portfolio_heading_options' );
	} else {
		$meta_boxed_body_bg = reactor_option( 'boxed_body_background', '', 'meta_page_options' );
	}

	if ( is_array( $boxed_body_bg ) && ! empty( $boxed_body_bg ) ) {
		foreach ( $boxed_body_bg as $attr => $value ) {
			if ( isset( $meta_boxed_body_bg[ $attr ] ) && ! empty( $meta_boxed_body_bg[ $attr ] ) ) {
				$boxed_body_bg[ $attr ] = $meta_boxed_body_bg[ $attr ];
			}
		}
	} elseif ( empty( $boxed_body_bg ) && ! empty( $meta_boxed_body_bg ) ) {
		$boxed_body_bg = $meta_boxed_body_bg;
	}

	if ( true === $boxed_body ) {
		$classes[] = 'boxed';

		if ( isset( $boxed_body_bg ) && ! empty( $boxed_body_bg ) ) {
			$classes[] = 'boxed-body-custom-background';
		}
	}

	if ( ! ( true === $boxed_body ) ) {
		$classes[] = 'body-custom-background';
	}

	$classes[] = 'wide device-lg';

	if ( 'side' === $header_style || is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
		$classes[] = 'side-panel-static';
	}

	$disable_preloader = reactor_option( 'preloader_disable' );

	if ( true === $disable_preloader ) {
		$classes[] = 'no-page-loader';
	}

	return $classes;

}

add_filter( 'body_class', 'polo_body_class' );

if ( ! function_exists( 'polo_get_theme_settings' ) ) {
	/**
	 * @param $option_name
	 * @param $meta_name
	 * @param $meta_section
	 *
	 * @return mixed
	 */
	function polo_get_theme_settings( $option_name, $meta_name, $meta_section ) {

		$value      = reactor_option( $option_name );
		$meta_value = reactor_option( $meta_name, '', $meta_section );
		if ( isset( $meta_value ) && ! empty( $meta_value ) && ! ( 'default' === $meta_value ) ) {
			$value = $meta_value;
		}

		return $value;

	}
}

/**
 * @return array
 */
function polo_portfolio_categories() {

	$output = array();

	$terms = get_terms( 'portfolio-category' );
	if ( isset( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $single_term ) {
			$output[ $single_term->term_id ] = $single_term->name;
		}
	}

	return $output;

}

function polo_post_categories() {

	$output = array();

	$terms = get_categories();

	if ( isset( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $single_term ) {
			$output[ $single_term->term_id ] = $single_term->name;
		}
	}

	return $output;
}


function polo_typography_variant( $variant ) {
	$font_style = '';
	if ( substr_count( $variant, 'italic' ) > 0 ) {
		$custom_italic = explode( 'i', $variant );
		$font_style    .= 'font-style:italic; font-weight:' . $custom_italic[0] . ';';
	} elseif ( 'regular' !== $variant ) {
		$font_style .= 'font-weight:' . $variant . ';';
	} elseif( 'regular' !== $variant ) {
		$font_style .= 'font-weight:400;';
	}

	return $font_style;
}

/**
 * @param $tag
 *
 * @return string
 */
function polo_typography_customization( $tag ) {

	$custom_typography      = reactor_option( $tag . '-typography' );
	$meta_custom_typography = reactor_option( $tag . '-typography', '', 'meta_page_typography' );

	if ( isset( $meta_custom_typography ) && ! empty( $meta_custom_typography ) ) {
		if ( isset( $meta_custom_typography['family'] ) && ! empty( $meta_custom_typography['family'] ) && 'crum_default' !== $meta_custom_typography['family'] ) {
			$custom_typography = $meta_custom_typography;
		}
		if ( isset( $meta_custom_typography['color'] ) && ! empty( $meta_custom_typography['color'] ) ) {
			$custom_typography = $meta_custom_typography;
		}
		if ( isset( $meta_custom_typography['size'] ) && ! empty( $meta_custom_typography['size'] ) ) {
			$custom_typography = $meta_custom_typography;
		}
	}

	$custom_css = '';

	if ( 'body' === $tag ) {
		$print_tag = 'body, p';
	} elseif ( 'menu' === $tag ) {
		$print_tag = '#mainMenu a, #mainMenu > ul > li > a';
	} else {
		$print_tag = $tag;
	}

	if ( isset( $custom_typography ) && ! empty( $custom_typography ) ) {
		if ( isset( $custom_typography['variant'] ) && ! ( $custom_typography['variant'] == '' ) ) {
			if ( substr_count( $custom_typography['variant'], 'italic' ) > 0 ) {
				$custom_italic = explode( 'i', $custom_typography['variant'] );
				$custom_css .= $print_tag . '{font-style:italic; font-weight:' . $custom_italic[0] . '}';
			} elseif ( $custom_typography['variant'] == 'regular' && ! ( 'crum_default' === $custom_typography['family'] ) && ! empty( $custom_typography['family'] ) ) {
				$custom_css .= $print_tag . '{font-weight:400}';
			} elseif ( ! empty( $custom_typography['family'] ) || $custom_typography['variant'] != 'regular' ) {
				$custom_css .= $print_tag . '{font-weight:' . $custom_typography['variant'] . '}';
			}
		}

		if ( isset( $custom_typography['size'] ) && ! ( $custom_typography['size'] == '' ) ) {
			$custom_css .= $print_tag . '{font-size:' . $custom_typography['size'] . 'px}';
		}

		if ( isset( $custom_typography['height'] ) && ! ( $custom_typography['height'] == '' ) ) {
			$custom_css .= $print_tag . '{line-height:' . $custom_typography['height'] . '}';
		}

		if ( isset( $custom_typography['color'] ) && ! ( $custom_typography['color'] == '' ) ) {
			if ( 'menu' == $tag ) {
				$custom_css .= '#header #header-wrap #mainMenu a:hover, #mainMenu > ul > li > a:hover{color:' . $custom_typography['color'] . '}';
			} else {
				$custom_css .= $print_tag . '{color:' . $custom_typography['color'] . '} .h1 *, a {color:inherit;}';
			}

		}

		if ( ! empty( $custom_typography['family'] ) && ! ( $custom_typography['family'] == 'crum_default' ) ) {
			$custom_css .= $print_tag . '{font-family:' . $custom_typography['family'] . '}';
		}
	}

	return $custom_css;

}

function polo_page_links_styling( $link ) {

	preg_match_all( '/<a href="(.*)">/', $link, $matches );

	if ( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
		$link = '<li>' . $link . '</li>';
	} else {
		$link = '<li class="active"><a href="#">' . $link . '</a></li>';
	}

	return $link;

}

add_filter( 'wp_link_pages_link', 'polo_page_links_styling' );


add_filter( 'wp_list_categories', 'polo_list_categories_count' );
function polo_list_categories_count( $output ) {

	$output = preg_replace( '/\<\/a\>.\([0-9]*\)/', '</a>', $output );

	return $output;
}

function polo_theme_preloader() {
	$disable_preloader = reactor_option( 'preloader_disable' );

	$preloader_data = array();

	if ( ! ( true === $disable_preloader ) ) {
		$prelaoder_icon     = reactor_option( 'preloader_icon' );
		$reloader_animation = reactor_option( 'preoader_animation' );

		if ( isset( $prelaoder_icon ) && ! empty( $prelaoder_icon ) ) {
			$preloader_data[] = 'data-animation-icon="' . str_replace( '_', '-', $prelaoder_icon ) . '.svg"';
		}

		if ( isset( $reloader_animation ) && ! empty( $reloader_animation ) ) {
			$animations       = array(
				'fade'       => array(
					'in'  => 'fadeIn',
					'out' => 'fadeOut'
				),
				'fade_up'    => array(
					'in'  => 'fadeInUp',
					'out' => 'fadeOutUp'
				),
				'fade_down'  => array(
					'in'  => 'fadeInDown',
					'out' => 'fadeOutDown'
				),
				'fade_left'  => array(
					'in'  => 'fadeInLeft',
					'out' => 'fadeOutLeft'
				),
				'fade_right' => array(
					'in'  => 'fadeInRight',
					'out' => 'fadeOutRight'
				),
				'rotate'     => array(
					'in'  => 'rotateIn',
					'out' => 'rotateOut'
				),
				'flip_x'     => array(
					'in'  => 'flipInX',
					'out' => 'flipOutX'
				),
				'flip_y'     => array(
					'in'  => 'flipInY',
					'out' => 'flipOutY'
				),
				'zoom'       => array(
					'in'  => 'zoomIn',
					'out' => 'zoomOut'
				),
				'overlay'    => array(
					'in'  => 'overlaySlideInTop',
					'out' => 'overlaySlideOutTop'
				),
			);
			$preloader_data[] = 'data-animation-in="' . $animations[ $reloader_animation ]['in'] . '"';
			$preloader_data[] = 'data-animation-out="' . $animations[ $reloader_animation ]['out'] . '"';
		}

		$preloader_data[] = 'data-animation-icon-path="' . POLO_ROOT_URL . '/library/img/svg-loaders/' . '"';

	}

	$preloader_data = implode( ' ', $preloader_data );

	return $preloader_data;
}

/**
 * @param $content
 *
 * @return array
 */
function polo_parse_row_param( $matches, $param_name ) {

	$row_ids = array();

	if ( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
		$i = 0;
		foreach ( $matches[0] as $single_row ) {
			$pattern = '\[(.*?)\]';
			preg_match_all( '/' . $pattern . '/s', $single_row, $row_atts );
			if ( isset( $row_atts[0] ) && ! empty( $row_atts[0] ) ) {
				$row_atts_exploded = explode( ' ', $row_atts[0][0] );
				if ( is_array( $row_atts_exploded ) ) {
					foreach ( $row_atts_exploded as $single_arg ) {
						$temp = explode( '=', $single_arg );
						if ( $param_name === $temp[0] ) {
							$temp[1]       = str_replace( ']', '', $temp[1] );
							$row_ids[ $i ] = str_replace( '"', '', $temp[1] );
						}

					}
				}
			}
			$i ++;
		}
	}

	return $row_ids;

}

add_filter( 'bbp_no_breadcrumb', '__return_true' );

if ( ! function_exists( 'polo_folio_active_categories' ) ) {
	function polo_folio_active_categories( $the_query ) {
		$categories_to_display = array();

		while ( $the_query->have_posts() ):$the_query->the_post();

			$folio_categories = get_the_terms( get_the_ID(), 'portfolio-category' );
			if ( ! is_wp_error( $folio_categories ) && is_array( $folio_categories ) ) {
				foreach ( $folio_categories as $single_category ) {
					$categories_to_display[] = $single_category->term_id;
				}
			}


		endwhile;
		wp_reset_query();


		return $categories_to_display;
	}
}
function polo_get_metabox_source() {
	if ( is_singular( 'portfolio' ) ) {
		$metabox_source = 'meta_portfolio_heading_options';
	}  else {
		$metabox_source = 'meta_page_options';
	}

	return $metabox_source;
}


add_action( 'wp_ajax_polo_subscribe', 'do_polo_subscribe' );
add_action( 'wp_ajax_nopriv_polo_subscribe', 'do_polo_subscribe' );

/**
 * Send massage in contact forms by ajax.
 *
 * @return bool
 */
function do_polo_subscribe() {
	if ( isset( $_POST['crum_subscribe'] ) && $_POST['crum_subscribe'] ) {
		$email = $_POST['crum_email'];
		global $wpdb;
		if ( is_email( esc_attr( $email ) ) ) {
			$exists = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "crumsubscribe where crum_email like '" . esc_sql( $email ) . "' limit 1" );
			if ( intval( $exists ) < 1 ) {
				$wpdb->insert(
					$wpdb->prefix . 'crumsubscribe',
					array(
						'crum_email' => esc_sql( $email )
					),
					array(
						'%s'
					)
				);
			}
		}
	}
}

/**
 * get all site pages
 * @return array all site pages
 */
function polo_get_portfolio_pages(){
    $pages = (array)get_pages();

    $output = array();
    foreach ($pages as $page){
        $output[get_page_link( $page->ID )] = $page->post_title;
    }
    return $output;
}

/**
 * changes width and height if user set custom size of preview
 * @param $width
 * @param $height
 */
function polo_portfolio_force_thumb_size(&$width, &$height){

    if(cs_get_option('enable_custom_size')){
        $width = (int)cs_get_option('custom_size_width');
        $height = (int)cs_get_option('custom_size_height');
    }
}

if ( ! function_exists( '_polo_get_key_value' ) ) {
	function _polo_get_key_value( $data, $key ) {
		return isset( $data[ $key ] ) ? $data[ $key ] : null;
	}
}
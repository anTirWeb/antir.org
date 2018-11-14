<?php
//theme opttions
$top_bar_enable      = reactor_option( 'top-bar-enable', false );
$top_bar_transparent = reactor_option( 'top-bar-transparent' );
$top_bar_color       = reactor_option( 'top-bar-color' );

//Metabox options
if ( is_singular( 'portfolio' ) ) {
	$meta_top_bar_enable = reactor_option( 'meta-top-bar-enable', '', 'meta_portfolio_heading_options' );
} else {
	$meta_top_bar_enable = reactor_option( 'meta-top-bar-enable', '', 'meta_page_options' );
}
if ( is_singular( 'portfolio' ) ) {
	$meta_top_bar_color = reactor_option( '_meta-top-bar-color', '', 'meta_portfolio_heading_options' );
} else {
	$meta_top_bar_color = reactor_option( '_meta-top-bar-color', '', 'meta_page_options' );
}
if ( is_singular( 'portfolio' ) ) {
	$meta_top_bar_transparent = reactor_option( 'meta-top-bar-transparent', '', 'meta_portfolio_heading_options' );
} else {
	$meta_top_bar_transparent = reactor_option( 'meta-top-bar-transparent', '', 'meta_page_options' );
}

if ( isset( $meta_top_bar_enable ) && ! empty( $meta_top_bar_enable ) && ! ( 'default' === $meta_top_bar_enable ) ) {
	if ( 'true' === $meta_top_bar_enable ) {
		$top_bar_enable = true;
	} elseif ( 'false' === $meta_top_bar_enable ) {
		$top_bar_enable = false;
	}
}

if ( isset( $meta_top_bar_color ) && ! empty( $meta_top_bar_color ) && ! ( 'default' === $meta_top_bar_color ) ) {
	$top_bar_color = $meta_top_bar_color;
}

if ( isset( $meta_top_bar_transparent ) && ! empty( $meta_top_bar_transparent ) && ! ( 'default' === $meta_top_bar_transparent ) ) {
	if ( 'true' === $meta_top_bar_transparent ) {
		$top_bar_transparent = true;
	} elseif ( 'false' === $meta_top_bar_transparent ) {
		$top_bar_transparent = false;
	}
}

$classes = array();

if ( 'dark' === $top_bar_color ) {
	$classes[] = 'topbar-dark';
} elseif ( 'custom' === $top_bar_color ) {
	$classes[] = 'topbar-custom';
} else {
	$classes[] = '';
}

if ( isset( $top_bar_transparent ) && ( true === $top_bar_transparent ) && 'white' === $top_bar_color ) {
	$classes[] = 'topbar-transparent';
}


$topbar_left_content = reactor_option( 'top-bar-panel-left', array('enabled'=>array('polo_top_menu' => 'Menu')) );
if ( isset( $topbar_left_content ) && ! empty( $topbar_left_content ) ) {
	$enabled_modules_left = $topbar_left_content['enabled'];
}

$topbar_right_content = reactor_option( 'top-bar-panel-right',array('enabled'=>array('top_bar_social' => 'Social')) );
if ( isset( $topbar_right_content ) && ! ( $topbar_right_content == '' ) ) {
	$enabled_modules_right = $topbar_right_content['enabled'];
}

if ( ! ( class_exists( 'Polo_Top_Bar' ) ) ) {
	class Polo_Top_Bar {

		function top_bar_language() {
			$output = '';

			if ( function_exists( 'icl_get_languages' ) ) {
				$languages        = icl_get_languages( 'skip_missing=0&orderby=order' );
				$current_code = ICL_LANGUAGE_CODE;
				if (isset($languages[$current_code])){
					$current_params = $languages[$current_code];
					$current_language = $current_params['native_name'];
					$output .= '<span class="dropdown wpml-swither">';
					$output .= '<button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<img src="'.$current_params['country_flag_url'].'" alt="" />
						' . strtoupper( $current_language ) . '
					</button>';
					if ( isset( $languages ) && ! ( $languages == '' ) ) {
						$output .= '<ul class="dropdown-menu wpml-dropdown"  aria-labelledby="wpml-swither">';
						foreach ( $languages as $single_language ) {
							if ( $single_language['language_code'] !== $current_code ) {
								$output .= '<li><a href="' . $single_language['url'] . '"><img src="'. $single_language['country_flag_url'].'" alt="" /> ' . strtoupper( $single_language['native_name'] ) . '</a></li>';
							}
						}
						$output .= '</ul>';//dropdown-menu
					}
					$output .= '</span>';//dropdown
				}
			}

			return $output;
		}

		function top_bar_left_text() {
			$text = reactor_option( 'top-bar-panel-text-left' );
			if ( is_array( $text ) ) {
				$text = array_slice( $text, 0, 1 );
				$text = implode( $text );

				if ( function_exists( 'icl_object_id' ) ) {
					$current_language = ICL_LANGUAGE_CODE;
					$text             = $text[ $current_language ];
				}
			}

			$output = '';

			if ( isset( $text ) && ! ( $text == '' ) ) {
				$output .= '<ul class="top-menu inline-list"><li>';
				$output .= do_shortcode( $text );
				$output .= '</li></ul>';
			}


			return $output;
		}

		function polo_top_menu() {
			$defaults = array(
				'theme_location' => 'top-menu',
				'container'      => false,
				'menu_class'     => 'inline-list',
				'echo'           => false,
				'fallback_cb'    => '',
				'items_wrap'     => '<ul id="%1$s" class="%2$s top-menu">%3$s</ul>',
				'depth'          => 1,
				'walker'         => new Polo_Clean_Walker()
			);

			$top_menu = wp_nav_menu( $defaults );

			return $top_menu;

		}

		function top_bar_right_text() {
			$text = reactor_option( 'top-bar-panel-text-right' );

			if ( is_array( $text ) ) {
				$text = array_slice( $text, 0, 1 );
				$text = implode( $text );

				if ( function_exists( 'icl_object_id' ) ) {
					$current_language = ICL_LANGUAGE_CODE;
					$text             = $text[ $current_language ];
				}
			}

			$output = '';

			if ( isset( $text ) && ! ( $text == '' ) ) {
				$output .= '<ul class="top-menu inline-list"><li>';
				$output .= do_shortcode( $text );
				$output .= '</li></ul>';
			}

			return $output;
		}

		function top_bar_social() {
			$top_bar_socicons    = reactor_option( 'top-bar-soc-icons', '' );
			$output = '';
			if ( is_array( $top_bar_socicons ) && ! empty( $top_bar_socicons ) ) {
				$output .= '<ul class="social-icons social-icons-colored-hover inline-list">';
				foreach ( $top_bar_socicons as $single_socicon ) {
					if ( 'google-plus' === $single_socicon['social-network-icon'] ) {
						$output .= '<li class="social-google">';
					} else {
						$output .= '<li class="social-' . $single_socicon['social-network-icon'] . '">';
					}
					$output .= '<a href="' . esc_url( $single_socicon['social-network-url'] ) . '"><i class="fa fa-' . $single_socicon['social-network-icon'] . '"></i></a>';
					$output .= '</li>';
				}
				$output .= '</ul>';
			}

			return $output;
		}
	}
}
if ( true === $top_bar_enable ) {
	$top_bar = new Polo_Top_Bar;
	$output  = '';
	$output  .= '<div id="topbar" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
	$output  .= '<div class="container">';
	$output  .= '<div class="row">';

//left
	$output .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';

	if ( ! empty( $enabled_modules_left ) ) {
		foreach ( $enabled_modules_left as $module_name_left => $enabled_module_left ) {
			$output .= $top_bar->$module_name_left();
		}
	}

	$output .= '</div><!-- end col -->';

//right
	$output .= ' <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">';

	if ( isset( $enabled_modules_right ) && ! ( $enabled_modules_right == '' ) ) {
		foreach ( $enabled_modules_right as $module_name_right => $enabled_module_right ) {
			$output .= $top_bar->$module_name_right();
		}
	}

	$output .= '</div><!-- end col -->';

	$output .= '</div><!-- end row -->';
	$output .= '</div><!-- end container -->';
	$output .= '</div><!-- end #topbar -->';

	echo( $output );
}

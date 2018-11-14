<?php
$header_class = array();
//Main header options

$header_layout = reactor_option( 'main_header_layout' );

$meta_header_layout = reactor_option( 'main_header_layout', '', 'one_page_options' );

if ( isset( $meta_header_layout ) && ! empty( $meta_header_layout ) && ! ( 'default' === $meta_header_layout ) ) {
	$header_layout = $meta_header_layout;
}

$classic_header_style = reactor_option( 'classic_header_style' );

if ( ! ( 'default' === $meta_header_layout ) ) {
	$meta_classic_header_style = reactor_option( 'classic_header_style', '', 'one_page_options' );

	if ( isset( $meta_classic_header_style ) && ! ( 'default' === $meta_classic_header_style ) ) {
		$classic_header_style = $meta_classic_header_style;
	}
}

$modern_header_style = reactor_option( 'modern_header_style' );

if ( ! ( 'default' === $meta_header_layout ) ) {
	$meta_modern_header_style = reactor_option( 'modern_header_style', '', 'one_page_options' );

	if ( isset( $meta_modern_header_style ) && ! ( 'default' === $meta_modern_header_style ) ) {
		$modern_header_style = $meta_modern_header_style;
	}
}

$classic_transparent_menu = reactor_option( 'classic_transparent_menu' );

if ( ! ( 'default' === $meta_header_layout ) ) {
	$meta_classic_transparent_menu = reactor_option( 'classic_transparent_menu', '', 'one_page_options' );

	if ( isset( $meta_classic_transparent_menu ) && ! ( 'default' === $meta_classic_transparent_menu ) ) {
		$classic_transparent_menu = $meta_classic_transparent_menu;
	}
}

$full_width_header = reactor_option( 'header_full_width' );
if ( ! ( 'default' === $meta_header_layout ) ) {
	$meta_full_width_header = polo_metaselect_to_switch( reactor_option( 'header_full_width', '', 'one_page_options' ) );

	if ( ! ( null === $meta_full_width_header ) ) {
		$full_width_header = $meta_full_width_header;
	}
}
$header_mini = reactor_option( 'header_mini' );
if ( ! ( 'default' === $meta_header_layout ) ) {

	$meta_header_mini = polo_metaselect_to_switch( reactor_option( 'header_mini', '', 'one_page_options' ) );

	if ( ! ( null === $meta_header_mini ) ) {
		$header_mini = $meta_header_mini;
	}
}

$header_sticky = reactor_option( 'header_sticky' );
if ( ! ( 'default' === $meta_header_layout ) ) {

	$meta_header_sticky = polo_metaselect_to_switch( reactor_option( 'header_sticky', '', 'one_page_options' ) );

	if ( ! ( null === $meta_header_sticky ) ) {
		$header_sticky = $meta_header_sticky;
	}
}
$header_sticky_mobile     = reactor_option( 'header_sticky_mobile' );

//Logotype
$logo_image = reactor_option( 'logotype-image' );

$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'one_page_options' );

if ( isset( $meta_logo_image ) && ! empty( $meta_logo_image ) ) {
	$logo_image = $meta_logo_image;
}
//Retina logotype
$retina_image = reactor_option( 'logotype-image-retina' );

$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'one_page_options' );

if ( isset( $meta_retina_image ) && ! empty( $meta_retina_image ) ) {
	$retina_image = $meta_retina_image;
}

$hide_cart = reactor_option( 'header-cart' );

$meta_hide_cart = polo_metaselect_to_switch( reactor_option( 'meta-header-cart', '', 'one_page_options' ) );

if ( ! ( null === $meta_hide_cart ) ) {
	$hide_cart = $meta_hide_cart;
}
$hide_search = reactor_option( 'header-search' );

$meta_hide_search = polo_metaselect_to_switch( reactor_option( 'meta-header-search', '', 'one_page_options' ) );


if ( ! ( null === $meta_hide_search ) ) {
	$hide_search = $meta_hide_search;
}

$meta_header_style = reactor_option( 'header_style', '', 'one_page_options' );

$logotype_image  = $logo_image ? wp_get_attachment_url( $logo_image ) : '';
$logotype_retina = $retina_image ? wp_get_attachment_url( $retina_image ) : '';

if ( isset( $logotype_retina ) && ! ( $logotype_retina == '' ) ) {
	$image_size = wp_get_attachment_metadata( $retina_image );
	if ( $logotype_retina ) {
		$image_size = absint( $image_size['width'] / 2 );
	}
	$logo_image = '<img src="' . esc_url($logotype_retina) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" style="width:' . $image_size . 'px">';
} elseif ( isset( $logotype_image ) && ! ( $logotype_image == '' ) ) {
	$logo_image = '<img src="' . esc_url($logotype_image) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
} else {
	$logo_image = '';
}
if ( isset( $logotype_retina ) && ! empty( $logotype_retina ) ) {
	$logo_data = 'data-dark-logo="' . $logotype_retina . '"';
} elseif ( isset( $logotype_image ) && ! empty( $logotype_image ) ) {
	$logo_data = 'data-dark-logo="' . $logotype_image . '"';
} else {
	$logo_data = '';
}


if ( true === $header_sticky_mobile ) {
	$header_class[] = 'mobile-sticky';
}

if ( 'centered' === $header_layout ) {
	$header_class[] = 'header-logo-center';
} else {

	if ( 'modern' === $header_layout ) {
		if ( 'light' === $modern_header_style ) {
			$header_class[] = 'header-modern header-light-transparent';
		} elseif ( 'dark' === $modern_header_style ) {
			$header_class[] = 'header-modern header-dark';
		} elseif ( 'dark_transparent' === $modern_header_style ) {
			$header_class[] = 'header-modern header-dark header-dark-transparent';
		} else {
			$header_class[] = 'header-modern';
		}
	} else {

		if ( 'light' === $classic_header_style ) {
			$header_class[] = 'header-light';
		} elseif ( 'light_transparent' === $classic_header_style ) {
			$header_class[] = 'header-light-transparent';
		} elseif ( 'dark' === $classic_header_style ) {
			$header_class[] = 'header-dark';
		} elseif ( 'dark_transparent' === $classic_header_style ) {
			$header_class[] = 'header-dark-transparent header-dark';
		} else {
			$header_class[] = 'header-transparent';

			if ( 'light' === $classic_transparent_menu ) {
				$header_class[] = 'header-dark white-sticky';
			}
		}

	}

	if ( true === $full_width_header ) {
		$header_class[] = 'header-fullwidth';
	}

	if ( true === $header_mini ) {
		$header_class[] = 'header-mini';
	}

	if ( isset( $logo_image ) && ! empty( $logo_image ) || isset( $retina_image ) && ! empty( $retina_image ) ) {
		if ( is_singular( 'portfolio' ) ) {
			$header_logo_position = polo_get_theme_settings( 'header_logo_position', 'header_logo_position', 'meta_portfolio_heading_options' );
		} else {
			$header_logo_position = polo_get_theme_settings( 'header_logo_position', 'header_logo_position', 'one_page_options' );
		}

		if ( 'right' === $header_logo_position ) {
			$header_class[] = 'header-logo-right';
		}
	}

}

if ( is_singular( 'portfolio' ) ) {
	$meta_hide_logo = reactor_option( 'header_logo_hide', '', 'meta_portfolio_heading_options' );
} else {
	$meta_hide_logo = reactor_option( 'header_logo_hide', '', 'one_page_options' );
}

if ( true === $header_sticky ) {
	$header_class[] = '';
} else {
	$header_class[] = 'header-no-sticky';
}

$header_class = implode( ' ', $header_class );

$output = '';

$output .= '<header id="header" class="' . $header_class . '">';

$output .= '<div id="header-wrap">';

$output .= '<div class="container">';

//Logo
if ( ! ( true === $meta_hide_logo ) ) {
	$output .= '<div id="logo">';
	$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" class="logo" ' . $logo_data . '>';
	$output .= $logo_image;
	$output .= '</a>';
	$output .= '</div>';//.logo
}
//end logo

//mobile menu
$output .= '<div class="nav-main-menu-responsive">';
$output .= '<button class="lines-button x" type="button" data-toggle="collapse" data-target=".main-menu-collapse">';
$output .= '<span class="lines"></span>';
$output .= '</button>';
$output .= '</div>';
//endmobile menu

if ( ! ( true === $hide_cart ) ) {
	//cart
	if ( class_exists( 'WooCommerce' ) ) {
		$WC = new WooCommerce;
		$output .= '<div id="shopping-cart">';
		$output .= '<span class="shopping-cart-items">' . esc_attr( WC()->cart->get_cart_contents_count() ) . '</span>';
		$output .= '<a href="' . esc_url( WC()->cart->get_cart_url() ) . '"><i class="fa fa-shopping-cart"></i></a>';
		$output .= '</div>';
	}
	//end cart
}

if ( ! ( true === $hide_search ) ) {
	//search
	$output .= '<div id="top-search"> <a id="top-search-trigger"><i class="fa fa-search"></i><i class="fa fa-close"></i></a>';
	$output .= '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" role="search">';
	$output .= '<input type="search" name="s" class="form-control" value="" placeholder="' . esc_html__( 'Start typing & press ', 'polo' ) . ' &quot;' . esc_html__( 'Enter', 'polo' ) . '&quot;">';
	$output .= '</form>';
	$output .= '</div>';
	//end search
}

$output .= '<div class="navbar-collapse collapse main-menu-collapse navigation-wrap">';
$output .= '<div class="container">';

$output .= '<nav id="mainMenu" class="main-menu mega-menu">';
$menu_home   = '<li><a href="' . esc_url( home_url( '/' ) ) . '"><i class="fa fa-home"></i></a></li>';
$menu_output = str_replace( 'class="main-menu nav nav-pills">', 'class="main-menu nav nav-pills">' . $menu_home, polo_main_menu() );
$output .= $menu_output;
$output .= '</nav>';

$output .= '</div>';//container
$output .= '</div>';//.navbar-collapse
//endmenu

$output .= '</div>';//.container

$output .= '</div>';//#header-wrap

$output .= '</header>';//end header

echo apply_filters('polo_onepage_header',$output);

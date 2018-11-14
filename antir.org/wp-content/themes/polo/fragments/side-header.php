<?php

//Logotype
$logo_image = reactor_option( 'logotype-image' );
if ( is_singular( 'portfolio' ) ) {
	$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'meta_portfolio_heading_options' );
} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
	$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'meta_portfolio_page_panel_options' );
} else {
	$meta_logo_image = reactor_option( 'meta-logotype-image', '', 'meta_page_options' );
}
if ( isset( $meta_logo_image ) && ! empty( $meta_logo_image ) ) {
	$logo_image = $meta_logo_image;
}
//Retina logotype
$retina_image = reactor_option( 'logotype-image-retina' );
if ( is_singular( 'portfolio' ) ) {
	$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'meta_portfolio_heading_options' );
} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
	$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'meta_portfolio_page_panel_options' );
} else {
	$meta_retina_image = reactor_option( 'meta-logotype-image-retina', '', 'meta_page_options' );
}
if ( isset( $meta_retina_image ) && ! empty( $meta_retina_image ) ) {
	$retina_image = $meta_retina_image;
}

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

$top_bar_socicons = reactor_option( 'top-bar-soc-icons' );

$copyright_text = reactor_option( 'copyright-text' );
if ( function_exists( 'icl_object_id' ) ) {
	$current_language = ICL_LANGUAGE_CODE;
	$copyright_text   = $copyright_text[ $current_language ];
}

if ( is_array( $copyright_text ) ) {
	$copyright_text = array_slice( $copyright_text, 0, 1 );
	$copyright_text = implode( $copyright_text );
}


if ( is_singular( 'portfolio' ) ) {
	$soc_icon_style = polo_get_theme_settings( 'header_soc_icons_style', 'header_soc_icons_style', 'meta_portfolio_heading_options' );
} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
	$soc_icon_style = polo_get_theme_settings( 'header_soc_icons_style', 'header_soc_icons_style', 'meta_portfolio_page_panel_options' );
} else {
	$soc_icon_style = polo_get_theme_settings( 'header_soc_icons_style', 'header_soc_icons_style', 'meta_page_options' );
}

if ( 'dark' === $soc_icon_style ) {
	$icons_class = 'social-icons-dark';
} else {
	$icons_class = 'social-icons-colored';
}

$hide_menu = reactor_option( 'side_header_hide_menu' );
if ( is_singular( 'portfolio' ) ) {
	$meta_hide_menu = polo_metaselect_to_switch( reactor_option( 'side_header_hide_menu', '', 'meta_portfolio_heading_options' ) );
} elseif ( is_page_template('page-templates/portfolio-page-side.php') ) {
	$meta_hide_menu = polo_metaselect_to_switch( reactor_option( 'side_header_hide_menu', '', 'meta_portfolio_page_panel_options' ) );
} else {
	$meta_hide_menu = polo_metaselect_to_switch( reactor_option( 'side_header_hide_menu', '', 'meta_page_options' ) );
}

if ( ! ( null === $meta_hide_menu ) ) {
	$hide_menu = $meta_hide_menu;
}

if ( is_singular( 'portfolio' ) ) {
	$replace_logo = reactor_option( 'header_logo_replace', '', 'meta_portfolio_heading_options' );
} elseif ( is_page_template('page-templates/portfolio-page-side.php') ) {
	$replace_logo = reactor_option( 'header_logo_replace', '', 'meta_portfolio_page_panel_options' );
} else {
	$replace_logo = reactor_option( 'header_logo_replace', '', 'meta_page_options' );
}

$logo_text = reactor_option( 'header_logo_text' );
$logo_text = polo_do_multilang_text($logo_text);
if ( is_singular( 'portfolio' ) ) {
	$meta_logo_text = reactor_option( 'header_logo_text', '', 'meta_portfolio_heading_options' );
} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
	$meta_logo_text = reactor_option( 'portfolio_side_header_logo_text', '', 'meta_portfolio_page_panel_options' );
} else {
	$meta_logo_text = reactor_option( 'header_logo_text', '', 'meta_page_options' );
}
$meta_logo_text = polo_do_multilang_text($meta_logo_text);
if ( isset( $meta_logo_text ) && ! empty( $meta_logo_text ) ) {
	$logo_text = $meta_logo_text;
}

$description = reactor_option( 'header_side_description' );
$description = polo_do_multilang_text($description);
if ( is_singular( 'portfolio' ) ) {
	$meta_description = reactor_option( 'header_side_description', '', 'meta_portfolio_heading_options' );
} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {
	$meta_description = reactor_option( 'portfolio_side_header_side_description', '', 'meta_portfolio_page_panel_options' );
} else {
	$meta_description = reactor_option( 'header_side_description', '', 'meta_page_options' );
}
$meta_description = polo_do_multilang_text($meta_description);
if ( isset( $meta_description ) && ! empty( $meta_description ) ) {
	$description = $meta_description;
}

$output = '';

$output .= '<header id="header" class="header-no-sticky header-dark header-side-panel">';
$output .= '<div id="header-wrap">';
$output .= '<div class="container">';


$output .= '<div id="logo">';
$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" class="logo" ' . $logo_data . '>';
$output .= $logo_image;
$output .= '</a>';
$output .= '</div>';//.logo

$output .= '<div class="nav-main-menu-responsive">';
$output .= '<button class="lines-button x">';
$output .= '<span class="lines"></span>';
$output .= '</button>';
$output .= '</div>';

$output .= '<div id="side-panel-button" class="side-panel-button">';
$output .= '<button class="lines-button x" type="button" >';
$output .= '<span class="lines"></span>';
$output .= '</button>';
$output .= '</div>';

$output .= '<div id="side-panel" class="side-panel-dark">';
$output .= '<div class="side-panel-wrap">';

//Logo
if ( ! ( true === $replace_logo ) ) {
	$output .= '<div id="panel-logo" class="m-b-80">';
	$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" class="logo" ' . $logo_data . '>';
	$output .= $logo_image;
	$output .= '</a>';
	$output .= '</div>';//.logo
}

if ( isset( $logo_text ) && ! empty( $logo_text ) ) {
	$output .= '<div id="panel-logo" class="m-b-80 text-light">';
	$output .= $logo_text;
	$output .= '</div>';/*#panel-logo*/
}

if ( ! ( true === $hide_menu ) ) {
	$output .= '<div class="navbar-collapse collapse main-menu-collapse navigation-wrap">';
	$output .= '<div class="container">';

	$output .= '<nav id="mainMenu" class="main-menu mega-menu">';
	$menu_output = polo_main_menu();
	$output .= $menu_output;
	$output .= '</nav>';

	$output .= '</div>';//container
	$output .= '</div>';//.navbar-collapse
	//endmenu
}
if ( isset( $description ) && ! empty( $description ) ) {
	$output .= '<div class="panel-widget text-light">';
	$output .= do_shortcode( $description );
	$output .= '</div>';
}

if ( isset( $top_bar_socicons ) && is_array( $top_bar_socicons ) && ! empty( $top_bar_socicons ) ) {
	$output .= '<div class="panel-widget">';
	$output .= '<div class="social-icons ' . $icons_class . '">';

	$output .= '<ul>';

	foreach ( $top_bar_socicons as $single_socicon ) {
		if ( 'google-plus' === $single_socicon['social-network-icon'] ) {
			$output .= '<li class="social-google">';
		} else {
			$output .= '<li class="social-' . $single_socicon['social-network-icon'] . '">';
		}
		$output .= '<a href="' . esc_url($single_socicon['social-network-url']) . '"><i class="fa fa-' . $single_socicon['social-network-icon'] . '"></i></a>';
		$output .= '</li>';
	}

	$output .= '</ul>';

	$output .= '</div>';/*social-icons*/
	$output .= '</div>';/*panel-widget*/
}

$output .= '<div class="panel-widget side-panel-footer">';
$output .= '<div class="copyright-text text-center">';
$output .= $copyright_text;
$output .= '</div>';
$output .= '</div>';

$output .= '</div>';/*side-panel-wrap*/
$output .= '</div>';/*side-panel*/

$output .= '</div>';/*.container*/
$output .= '</div>';/*#header-wrap*/
$output .= '</header>';


echo apply_filters( 'polo_side_menu', $output );


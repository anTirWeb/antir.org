<?php
add_action( 'wp_enqueue_scripts', 'polo_custom_color_scheme', 99 );

function polo_custom_color_scheme(){

	$color_scheme = reactor_option('theme-color-scheme');
	if ( is_singular('portfolio') ) {
		$meta_color_scheme = reactor_option( 'meta-theme-color-scheme', '', 'meta_portfolio_heading_options' );
	} elseif( is_page() ) {
		$meta_color_scheme = reactor_option( 'meta-theme-color-scheme', '', 'meta_page_options' );
	}
	$custom_color = reactor_option( 'custom_scheme_color' );

	if ( is_singular( 'portfolio' ) ) {
		$meta_custom_color = reactor_option( 'custom_scheme_color', '', 'meta_portfolio_heading_options' );
	}  elseif( is_page() ) {
		$meta_custom_color = reactor_option( 'custom_scheme_color', '', 'meta_page_options' );
	}

	if ( isset( $meta_color_scheme ) && 'default' !== $meta_color_scheme ) {
		$color_scheme = $meta_color_scheme;

		if ( isset( $meta_custom_color ) && ! empty( $meta_custom_color ) ) {
			$custom_color = $meta_custom_color;
		}
	}
	$custom_css = '';

	if ( 'custom' === $color_scheme && isset( $custom_color ) && ! empty( $custom_color ) ) {

		$custom_css .= '::-moz-selection {
		    background: '.$custom_color.';
            color: #333;
            text-shadow: none;
		}';
		$custom_css .= '::selection {
			background: '.$custom_color.';
			text-shadow: none;
			color: #333;
		}';
		$custom_css .= '.text-colored, h1.text-colored, h2.text-colored, h3.text-colored, h4.text-colored, h5.text-colored, h6.text-colored, .color-font, .color-font a, .widget-tweeter li a, .widget-twitter li a, p.text-colored, .heading.heading-colored h1, .heading.heading-colored h2 {
			color: '.$custom_color.' !important;
		}';
		$custom_css .= '.progress-bar-container.color .progress-bar {
			background-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.blockquote-color {
			background-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.blockquote-color > small {
			color: #fff;
		}';
		$custom_css .= '.button.color, .btn.btn-primary, .gototop-button {
			background-color: '.$custom_color.';
			border-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.gototop-button {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.gototop-button {
			color: #fff;
		}';
		$custom_css .= 'nav .main-menu .dropdown-menu {
			border-color: '.$custom_color.';
		}';
		$custom_css .= '#topbar.topbar-colored {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '#vertical-dot-menu a:hover .cd-dot, #vertical-dot-menu a.active .cd-dot {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.sidebar-menu ul.nav-tabs li:hover .sidebar-menu ul.nav-tabs li a, .sidebar-menu ul.nav-tabs li a:hover, .sidebar-menu ul.nav-tabs li.active a, .sidebar-menu ul.nav-tabs li.active a:hover {
			color: #fff;
			background: '.$custom_color.';
			border: 1px solid '.$custom_color.';
		}';
		$custom_css .= '.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
			background-color: '.$custom_color.';
			border-color: #26B8F3;
		}';
		$custom_css .= '.list-group-item.active .list-group-item-text, .list-group-item.active:hover .list-group-item-text, .list-group-item.active:focus .list-group-item-text {
			color: #fff;
		}';
		$custom_css .= '.list-group-item.active > .badge, .nav-pills > .active > a > .badge {
			color: '.$custom_color.';
		}';
		$custom_css .= '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
			background-color: '.$custom_color.';
			border-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
			background-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= 'a:hover {
			color: '.$custom_color.';
		}';
		$custom_css .= '.dropcap.dropcap-colored, .dropcap.dropcap-colored a, .highlight.highlight-colored, .highlight.highlight-colored a {
			background-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.timeline.timeline-colored .timeline-circles:before, .timeline.timeline-colored .timeline-circles:after, .timeline.timeline-colored .timeline-date, .timeline.timeline-colored:before {
			background-color: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.timeline.timeline-colored li .timeline-block:before {
			border-color: transparent '.$custom_color.';
		}';
		$custom_css .= '.timeline.timeline-colored .timeline-block-image {
			border-color: '.$custom_color.';
		}';
		$custom_css .= '.timeline.timeline-colored.timeline-simple .timeline-date {
			background-color: #fff;
			border: 1px solid '.$custom_color.';
			color: '.$custom_color.';
		}';
		$custom_css .= '.border .tabs-navigation li.active a:after {
			background: '.$custom_color.';
		}';
		$custom_css .= '.breadcrumb a:hover {
			color: '.$custom_color.';
		}';
		$custom_css .= '.accordion.color .ac-item .ac-title {
			background: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.accordion.color-border-bottom .ac-item .ac-title {
			border-bottom: 1px dotted '.$custom_color.';
		}';
		$custom_css .= '.accordion.color-border-bottom .ac-item .ac-title:before {
			color: '.$custom_color.';
		}';
		$custom_css .= '.icon-box.color .icon i {
			background: '.$custom_color.';
			color: #fff;
		}';
		$custom_css .= '.icon-box.color .icon i:after {
			box-shadow: 0 0 0 3px '.$custom_color.';
		}';
		$custom_css .= '.icon-box.border.color .icon, .icon-box.border.color .icon i {
			color: '.$custom_color.';
			border-color: '.$custom_color.';
		}';
		$custom_css .= '.icon-box.fancy.color .icon i {
			color: '.$custom_color.';
			background-color: transparent;
		}';
		$custom_css .= '.fontawesome-icon-list .fa-hover a:hover {
			background-color: '.$custom_color.';
		}';
		$custom_css .= 'ul.icon-list li i {
			color: '.$custom_color.';
		}';
		$custom_css .= '.background-colored {
			background-color: '.$custom_color.' !important;
		}';
		$custom_css .= '#nanobar-progress div {
			background: '.$custom_color.' !important;
		}';
		$custom_css .= '.portfolio-filter li.ptf-active, .portfolio-filter li:hover {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.portfolio-filter li:not(.ptf-active):hover {
			color: '.$custom_color.';
		}';
		$custom_css .= '.heading-title-border-color {
			border-color: '.$custom_color.';
		}';
		$custom_css .= '.image-box-links a {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.image-box.effect.bleron {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.image-block-content .feature-icon {
			background-color: '.$custom_color.';
		}';
		$custom_css .= '.image-box.effect.bleron p.image-box-links a {
			color: '.$custom_color.';
		}';
		$custom_css .= '.product .product-wishlist a:hover {
			border-color: '.$custom_color.';
		}';

		$custom_css .= '.color .tabs-navigation li.active a{
			background: '.$custom_color.';
		}';


	}

	wp_add_inline_style('theme-base-style', $custom_css);

}
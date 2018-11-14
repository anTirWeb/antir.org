<?php

if ( ! function_exists( 'crumina_demo_homepages' ) ) {
	function crumina_demo_homepages() {

		return $demo_homepages = array(
			'corporate'  => 'Corporate v1',
			'creative'   => 'Creavite v1',
			'niche'      => 'App showcase',
			'templates'  => 'Youtube video background',
			'fashion'    => 'Polo Fashion',
			'model'      => 'Polo Model',
			'lawyer'     => 'Polo Lawyer',
			'taxi'       => 'Polo Taxi',
			'estate'     => 'Real Estate',
			'shop'       => 'Home Shop',
			'backery'    => 'Home Backery',
			'cafe'       => 'Polo Cafe',
			'restaurant' => 'Home Restaurant',
			'fitness'    => 'Home Fitness',
			'portfolio'  => 'Home Portfolio',
			'architect'  => 'Home Architecture',
			'wine'       => 'Home Wine',
		);

	}
}

if ( ! function_exists( 'crumina_corporate_variants' ) ) {

	function crumina_corporate_variants() {

		return $corporate_variants = array(
			'corporate_v1'   => 'Corporate v1',
			'corporate_v2'   => 'Corporate v2',
			'corporate_v3'   => 'Corporate v3',
			'corporate_v4'   => 'Corporate v4',
			'corporate_v5'   => 'Corporate v5',
			'corporate_v6'   => 'Corporate v6',
			'corporate_v7'   => 'Corporate v7',
			'corporate_v8'   => 'Corporate v8',
			'corporate_home' => 'Home Corporate',
			'business'       => 'Home business',
		);

	}

}

if ( ! function_exists( 'crumina_creative_variants' ) ) {

	function crumina_creative_variants() {

		return $creative_variants = array(
			'creative_v1' => 'Creavite v1',
			'creative_v2' => 'Creative v2',
			'creative_v3' => 'Creative v3',
			'creative_v4' => 'Creative v4',
			'creative_v5' => 'Creative v5',
		);

	}

}

if ( ! function_exists( 'crumina_shop_variants' ) ) {

	function crumina_shop_variants() {

		return $shop_variants = array(
			'shop_v1' => 'Home Shop',
			'shop_v2' => 'Home Shop v2',
			'shop_v3' => 'Home Shop v3',
			'shop_v4' => 'Home Shop v4',
		);

	}

}

if ( ! function_exists( 'crumina_portfolio_variants' ) ) {

	function crumina_portfolio_variants() {

		return $portfolio_variants = array(
			'portfolio_v1'  => 'Home Portfolio',
			'portfolio_v2'  => 'Home Portfolio v2',
			'portfolio_v3'  => 'Home Portfolio v3',
			'portfolio_v4'  => 'Home Portfolio v4',
			'portfolio_v5'  => 'Home Portfolio v5',
			'portfolio_v6'  => 'Home Portfolio v6',
			'portfolio_v7'  => 'Home Portfolio v7',
			'portfolio_v8'  => 'Home Portfolio v8',
			'portfolio_v9'  => 'Portfolio Side Panel',
			'portfolio_v10' => 'Home Portfolio Agency',
			'portfolio_v11' => 'Home Agency v2',
			'portfolio_v12' => 'Home Agency v3',
			'portfolio_v13' => 'Home developer',
		);

	}

}

if ( ! function_exists( 'crumina_hero_template_variants' ) ) {

	function crumina_hero_template_variants() {

		return $hero_template_variants = array(
			'hero_v1'  => 'Youtube video background',
			'hero_v2'  => 'Fullscreen parallax',
			'hero_v3'  => 'Image carousel',
			'hero_v4'  => 'Parallax',
			'hero_v5'  => 'Parallax dark',
			'hero_v6'  => 'Parallax dark fullwidth',
			'hero_v7'  => 'Particles',
			'hero_v8'  => 'Text rotator',
			'hero_v9'  => 'Text rotator dark',
			'hero_v10' => 'Video background',
			'hero_v11' => 'Video background dark',
			'hero_v12' => 'Video carousel',
		);

	}

}

if ( ! function_exists( 'crumina_niche_variants' ) ) {

	function crumina_niche_variants() {

		return $niche_variants = array(
			'niche_v1' => 'App showcase',
			'niche_v2' => 'Branding',
			'niche_v3' => 'Construction',
			'niche_v4' => 'Design studio',
			'niche_v5' => 'Nature',
			'niche_v6' => 'Resume',
			'niche_v7' => 'Web design',
		);

	}

}

if(!function_exists('crumina_magazine_variants')){
	function crumina_magazine_variants(){

		return $magazine_variants = array(
			'magazine_1'  => 'Home blog',
			'magazine_2'  => 'Home blog v2',
			'magazine_3'  => 'Home blog v3',
			'magazine_4'  => 'Home blog v4',
			'magazine_5'  => 'Home blog v5',
			'magazine_6'  => 'Home blog v6',
			'magazine_7'  => 'Home blog v7',
			'magazine_8'  => 'Home blog v8',
			'magazine_9'  => 'Home magazine',
			'magazine_10' => 'Home magazine v2',
			'magazine_11' => 'Home magazine v3',
			'magazine_12' => 'Home magazine v4',
		);

	}
}

if(!function_exists('crumina_onepage_variants')){

	function crumina_onepage_variants() {

		return $onepage_variants = array(
			'onepage_1' => 'Home One Page',
			'onepage_2' => 'Home One Page v2',
			'onepage_3' => 'Home One Page v3',
		);

	}

}

if ( ! function_exists( 'crumina_import_demo_menus' ) ) {

	function crumina_import_demo_menus() {

		return $demo_menus = array(
			'corporate'  => array(
				'top'    => '',
				'main'   => 'Primary Navigation',
				'footer' => ''
			),
			'creative'   => array(
				'top'    => '',
				'main'   => 'Creative menu',
				'footer' => ''
			),
			'niche'      => array(
				'top'    => 'Top panel menu',
				'main'   => 'Design studio',
				'footer' => ''
			),
			'templates'  => array(
				'top'    => '',
				'main'   => 'Hero Menu',
				'footer' => ''
			),
			'fashion'    => array(
				'top'    => '',
				'main'   => 'Main Fashion menu',
				'footer' => ''
			),
			'model'      => array(
				'top'    => '',
				'main'   => 'Main Model menu',
				'footer' => ''
			),
			'lawyer'     => array(
				'top'    => '',
				'main'   => 'Menu Lawyer',
				'footer' => ''
			),
			'taxi'       => array(
				'top'    => '',
				'main'   => 'Menu Taxi',
				'footer' => ''
			),
			'estate'     => array(
				'top'    => '',
				'main'   => 'Real Estate Menu',
				'footer' => ''
			),
			'shop'       => array(
				'top'    => '',
				'main'   => 'Shop menu',
				'footer' => ''
			),
			'backery'    => array(
				'top'    => '',
				'main'   => 'Main Backery Menu',
				'footer' => ''
			),
			'cafe'       => array(
				'top'    => '',
				'main'   => 'Main Cafe Menu',
				'footer' => ''
			),
			'restaurant' => array(
				'top'    => '',
				'main'   => 'Main Restaurant menu',
				'footer' => ''
			),
			'fitness'    => array(
				'top'    => '',
				'main'   => 'Menu Fitness',
				'footer' => ''
			),
			'portfolio'  => array(
				'top'    => '',
				'main'   => 'Home Portfolio Menu',
				'footer' => ''
			),
			'architect'  => array(
				'top'    => '',
				'main'   => 'Main Architecture menu',
				'footer' => ''
			),
			'wine'       => array(
				'top'    => '',
				'main'   => 'Menu Wine',
				'footer' => ''
			),
			'magazine'       => array(
				'top'    => '',
				'main'   => 'Primary Navigation',
				'footer' => ''
			),
			'onepage'       => array(
				'top'    => '',
				'main'   => 'Primary Navigation',
				'footer' => ''
			),
		);

	}

}

if ( ! function_exists( 'crumina_import_demo_sliders' ) ) {

	function crumina_import_demo_sliders() {

		return $demo_sliders = array(
			'architect'  => array( 'Polo_architect.zip' ),
			'backery'    => array( 'bakery.zip' ),
			'cafe'       => array( 'polo_cafe.zip' ),
			'corporate'  => array(
				'corporate-v3.zip',
				'corporate-v4.zip',
				'corporate-v5.zip',
				'corporate-v6.zip',
				'corporate-v7.zip',
				'corporate-v8.zip',
				'home-business.zip',
				'home_polo.zip',
				'portfolio-slider.zip',
				'Slider-Headers.zip',
				'Slider1.zip',
			),
			'creative'   => array(
				'creative-v2.zip',
				'creative-v4.zip',
				'portfolio-slider.zip',
			),
			'estate'     => array( 'real_estate.zip' ),
			'fashion'    => array( 'fashion.zip' ),
			'lawyer'     => array( 'polo_lawyer.zip' ),
			'niche'      => array(
				'home_construction.zip',
				'Polo_App_Showcase.zip',
				'Slider-Headers.zip',
			),
			'portfolio'  => array( 'portfolio-slider.zip' ),
			'restaurant' => array( 'polo_restaurant.zip' ),
			'shop'       => array( 'polo-shop-v2.zip', 'polo-shop-v3.zip' ),
		);

	}

}
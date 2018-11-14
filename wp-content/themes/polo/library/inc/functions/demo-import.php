<?php
/*
 * Functions Demo importer plugin
 */
?>
<?php


/**
 *
 * Select one of demo imports.
 *
 * @return array
 */
function ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => 'Corporate v1',
			'import_file_url'            => 'http://up.crumina.net/demo-data/polo/corporate/content.xml',
			'import_widget_file_url'     => 'http://up.crumina.net/demo-data/polo/corporate/widgets.wie',
			'import_preview_image_url'   => 'http://cdn1.crumina.net/polo/promo/img/2.jpg',
			'import_notice'              => 'corporate_v1',
		),
		array(
			'import_file_name'           => 'Corporate v2',
			'import_file_url'            => 'http://up.crumina.net/demo-data/polo/corporate/content.xml',
			'import_widget_file_url'     => 'http://up.crumina.net/demo-data/polo/corporate/widgets.wie',
			'import_preview_image_url'   => 'http://cdn1.crumina.net/polo/promo/img/3.jpg',
			'import_notice'              => 'corporate_v2',
		),
		array(
			'import_file_name'           => 'Backery',
			'import_file_url'            => 'http://up.crumina.net/demo-data/polo/backery/content.xml',
			'import_widget_file_url'     => 'http://up.crumina.net/demo-data/polo/backery/widgets.wie',
			'import_preview_image_url'   => 'http://cdn1.crumina.net/polo/promo/img/70.jpg',
			'import_notice'              => 'backery',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


function ocdi_after_import( $selected_import ) {
	$variant = $selected_import['import_notice'];

	$old_url = 'http://dev.crumina.net/polo/';
	$demo_source = 'http://up.crumina.net/demo-data/polo/';

	$importAll = new CruminaPoloImport($variant);
	$importAll->crum_copy_sliders( $variant, $demo_source  );
	$importAll->set_demo_sliders($variant);
	//$importAll->crumina_temp_cleanup( $variant );
	$importAll->update_options( $variant, $demo_source );
	$importAll->set_demo_menus( $variant );
	$importAll->set_demo_homepage( $variant );
	//$importAll->update_post_meta_urls( $variant, $old_url );



}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import' );

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );


class CruminaPoloImport{

	public function update_options( $variant, $demo_source ) {
		$file = wp_remote_fopen( $demo_source . $variant . '/options.txt' );
		$options = maybe_unserialize( $file );
		update_option( '_cs_options', $options );
	}

	public function set_demo_homepage( $variant ) {

		$pages = crumina_demo_homepages();
		$title = $pages[$variant];
		$page = get_page_by_title( $title );
		if ( isset( $page->ID ) ) {
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
		}
	}

	public function set_demo_menus( $variant ) {
		$menus = crumina_import_demo_menus();
		$demo = $menus[ $variant ];
		// Menus to Import and assign - you can remove or add as many as you want
		$top_menu    = get_term_by( 'name', $demo['top'], 'nav_menu' );
		$main_menu   = get_term_by( 'name', $demo['main'], 'nav_menu' );
		$footer_menu = get_term_by( 'name', $demo['footer'], 'nav_menu' );

		$args = array();

		if ( ! ( false === $top_menu ) ) {
			$args['top-menu'] = $top_menu->term_id;
		}
		if ( ! ( false === $main_menu ) ) {
			$args['main-menu'] = $main_menu->term_id;
		}
		if ( ! ( false === $footer_menu ) ) {
			$args['footer-links'] = $footer_menu->term_id;
		}

		set_theme_mod( 'nav_menu_locations', $args );
	}

	function update_post_meta_urls( $variant, $old_url ){
		global $wpdb;
		$old_site = $old_url . $variant . '/';
		$new_site = esc_url( home_url( '/' ) );
		$count = 0;
		$sql = $wpdb->prepare(
			"SELECT * from `{$wpdb->postmeta}` where meta_value like \"%s\"",
			'%'.untrailingslashit($old_site).'%'
		);
		$results = $wpdb->get_results($sql);
		foreach ($results as $result){
			$sql = $wpdb->prepare(
				"UPDATE `{$wpdb->postmeta}` SET meta_value=\"%s\" where meta_id = %d",
				$this->replace($old_site, $new_site, $result->meta_value) ,
				$result->meta_id
			);
			$wpdb->query($sql);
			$count++;
		}
		return $count;
	}


	public function crum_copy_sliders( $demo, $demo_source ) {

		$uploads = wp_upload_dir();
		$temp    = trailingslashit( $uploads['basedir'] ) . 'polo_import_temp/' . $demo . '/revslider';
		if ( ! is_dir( $temp ) ) {
			wp_mkdir_p( $temp );
		}
		@chmod( $temp, 0777 );

		$slider_variants = crumina_import_demo_sliders();
		$demo_sliders    = $slider_variants[ $demo ];

		if ( is_array( $demo_sliders ) ) {

			foreach ( $demo_sliders as $single_slider_name ) {

				if ( ! file_exists( $temp . $single_slider_name ) ) {
					if ( ! @copy( $demo_source . '/' . $single_slider_name, $temp . '/' . $single_slider_name ) ) {
						$errors = error_get_last();
						echo "COPY ERROR: " . $errors['type'];
						echo "<br />\n" . $errors['message'];
					} else {
						echo "File copied from remote!";
					}
				}

			}
		}
	}

	public function crumina_temp_cleanup( $folder ) {
		$uploads   = wp_upload_dir();
		$temp_path = trailingslashit( $uploads['basedir'] ) . 'polo_import_temp';
		$demo_path = trailingslashit( $uploads['basedir'] ) . 'polo_import_temp/' . $folder;
		$path      = trailingslashit( $uploads['basedir'] ) . 'polo_import_temp/' . $folder . '/revslider';
		if ( is_dir( $path ) ) {
			$objects = scandir( $path );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					unlink( $path . "/" . $object );
				}
			}
			reset( $objects );
			rmdir( $path );
		}
		if ( is_dir( $demo_path ) ) {
			rmdir( $demo_path );
		}
		if ( is_dir( $temp_path ) ) {
			rmdir( $temp_path );
		}
	}

	public function set_demo_sliders( $folder = 'corporate' ) {

		$uploads = wp_upload_dir();

		if ( class_exists( 'RevSlider' ) ) {
			$path    = trailingslashit( $uploads['basedir'] ) . 'polo_import_temp/' . $folder . '/revslider';
			$sliders = scandir( $path );
			if ( ! ( false === $sliders ) ) {
				foreach ( $sliders as $single_slider ) {
					if ( ( ! ( '.' === $single_slider ) && ! ( '..' === $single_slider ) ) ) {
						$single_slider = $path . '/' . $single_slider;
						if ( file_exists( $single_slider ) ) {
							$slider = new RevSlider();
							$slider->importSliderFromPost( true, true, $single_slider );
						}
					}
				}
			}

		}

	}


	private function replace($origin, $replaced, $value) {
		if ( is_serialized($value) ) {
			$value = maybe_unserialize($value);
			$value = $this->deep_replace($origin, $replaced, $value);
			$value = maybe_serialize($value);
		} else {
			$value = str_replace($origin, $replaced, $value);
		}
		return $value;
	}
	private function deep_replace($origin, $replaced, $datas) {
		if ( is_array($datas) || is_object($datas) ) {
			foreach ( $datas as &$data ) {
				if ( is_array($data) || is_object($data) ) {
					$data = $this->deep_replace($origin, $replaced, $data);
				} else {
					$data = str_replace($origin, $replaced, $data);
				}
			}
		}
		return $datas;
	}

}


















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
			'corporate_v1' => 'Corporate v1',
			'corporate_v2' => 'Corporate v2',
			'corporate_v3' => 'Corporate v3',
			'corporate_v4' => 'Corporate v4',
			'corporate_v5' => 'Corporate v5',
			'corporate_v6' => 'Corporate v6',
			'corporate_v7' => 'Corporate v7',
			'corporate_v8' => 'Corporate v8',
			'business'     => 'Home business',
			'creative_v1' => 'Creavite v1',
			'creative_v2' => 'Creative v2',
			'creative_v3' => 'Creative v3',
			'creative_v4' => 'Creative v4',
			'creative_v5' => 'Creative v5',
			'shop_v1' => 'Home Shop',
			'shop_v2' => 'Home Shop v2',
			'shop_v3' => 'Home Shop v3',
			'shop_v4' => 'Home Shop v4',
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
			'niche_v1' => 'App showcase',
			'niche_v2' => 'Branding',
			'niche_v3' => 'Construction',
			'niche_v4' => 'Design studio',
			'niche_v5' => 'Nature',
			'niche_v6' => 'Resume',
			'niche_v7' => 'Web design',
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
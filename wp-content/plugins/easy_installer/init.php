<?php
/**
 *
 * @package   Crumina installer
 * @author    Crumina <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2015 Crumina Team
 *
 * @wordpress-plugin
 * Plugin Name: Crumina installer plugin
 * Plugin URI:  http://crumina.net
 * Description: Install demo data just in one click
 * Version:     1.0.5
 * Author:      Crumina
 * Author URI:  http://crumina.net
 * Text Domain: crum
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EASY_F_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Don't duplicate me!
if ( ! class_exists( 'Radium_Theme_Demo_Data_Importer' ) ) {

	require_once( dirname( __FILE__ ) . '/importer/radium-importer.php' ); //load admin theme data importer
	require_once( dirname( __FILE__ ) . '/importer/constants.php' ); //load constants class

	class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

		/**
		 * Set framewok
		 *
		 * options that can be used are 'default', 'radium' or 'optiontree'
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'radium';

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name = 'my_theme_options_name'; //set theme options name here (key used to save theme options). Optiontree option name will be set automatically

		/**
		 * Set name of the theme options file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_options_file_name = 'theme_options.txt';

		/**
		 * Set name of the widgets json file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widgets_file_name = 'widgets.json';

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $content_demo_file_name = 'content.xml';

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */

		public function __construct() {

			$this->demo_files_path = dirname( __FILE__ ) . '/demo-files/'; //can

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus( $variant = 'corporate' ) {

			$demo_variant = crumina_import_demo_menus();
			$demo         = $demo_variant[ $variant ];

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

			$this->flag_as_imported['menus'] = true;

		}

		public function set_demo_homepage( $variant = 'corporate', $demo_style ) {

			if ( 'corporate' === $variant ) {
				$corporate_variants = crumina_corporate_variants();
				$demo               = $corporate_variants[ $demo_style ];
			} elseif ( 'niche' === $variant ) {
				$niche_variants = crumina_niche_variants();
				$demo           = $niche_variants[ $demo_style ];
			} elseif ( 'creative' === $variant ) {
				$creative_variants = crumina_creative_variants();
				$demo              = $creative_variants[ $demo_style ];
			} elseif ( 'portfolio' === $variant ) {
				$portfolio_variants = crumina_portfolio_variants();
				$demo               = $portfolio_variants[ $demo_style ];
			} elseif ( 'templates' === $variant ) {
				$hero_variants = crumina_hero_template_variants();
				$demo          = $hero_variants[ $demo_style ];
			} elseif ( 'shop' === $variant ) {
				$shop_variants = crumina_shop_variants();
				$demo          = $shop_variants[ $demo_style ];
			} elseif ( 'magazine' === $variant ) {
				$magazine_variants = crumina_magazine_variants();
				$demo              = $magazine_variants[ $demo_style ];
			} elseif ( 'onepage' === $variant ) {
				$onepage_variants = crumina_onepage_variants();
				$demo             = $onepage_variants[ $demo_style ];
			} else {
				$demo_variants = crumina_demo_homepages();
				$demo          = $demo_variants[ $variant ];
			}
			$page = get_page_by_title( $demo );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}

		}

		public function crum_megamenu_meta( $meta_value, $post_id, $meta_key ) {
			global $wpdb;
			$wpdb->update(
				'wp_postmeta',
				array(
					'meta_value' => $meta_value
				),
				array(
					'post_id'  => $post_id,
					'meta_key' => $meta_key,
				)
			);
		}

		public function crum_say_hello( $variant = 'corporate' ) {

			$options_file = EASY_F_PLUGIN_PATH . 'demo-files/' . $variant . '/options.txt';
			$options      = unserialize( file_get_contents( $options_file ) );
			update_option( '_cs_options', ( $options ) );

			wp_delete_post( 1, true );
			wp_delete_post( 2, true );

			if ( 'corporate' === $variant ) {
				$megamenu_image = 'http://cdn1.crumina.net/polo/wp-content/uploads/2016/03/shortcode-megamenu-bg.png';

				$this->crum_megamenu_meta( '1', '3600', '_crum_mega_menu_enabled' );//enable megamenu
				$this->crum_megamenu_meta( '4', '3600', '_crum_mega_menu_columns' );//megamenu columns
				$this->crum_megamenu_meta( '1', '3600', '_crum_mega_columns_sep' );//megamenu columns

				$this->crum_megamenu_meta( '1', '3601', '_crum_mega_menu_title' );//megamenu title
				$this->crum_megamenu_meta( '1', '3602', '_crum_mega_menu_title' );//megamenu title
				$this->crum_megamenu_meta( '1', '3603', '_crum_mega_menu_title' );//megamenu title

				$this->crum_megamenu_meta( $megamenu_image, '3600', '_crum_mega_menu_image' );//megamenu image

			}

			if('magazine' === $variant){
				$meta_file = EASY_F_PLUGIN_PATH . 'demo-files/' . $variant . '/page-meta.txt';
				$page_meta = file_get_contents($meta_file);
				$this->crum_megamenu_meta($page_meta,'231','meta_page_options');

			}
		}

		public function crum_copy_sliders( $demo ) {

			$url     = 'http://up.crumina.net/plugins/Polo/demo-files/' . $demo . '/revslider';
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
						if ( ! @copy( $url . '/' . $single_slider_name, $temp . '/' . $single_slider_name ) ) {
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

			$this->crum_copy_sliders( $folder );

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

			$this->crumina_temp_cleanup( $folder );
		}

	}

	global $installer;

	$installer = new Radium_Theme_Demo_Data_Importer;

	function crum_deactivate_installer() {

		$active_plugins = get_option( 'active_plugins' );
		if ( is_array( $active_plugins ) && in_array( 'wordpress-importer/wordpress-importer.php', $active_plugins ) ) {

			$importer_key = array_search( 'wordpress-importer/wordpress-importer.php', $active_plugins );

			unset( $active_plugins[ $importer_key ] );

			update_option( 'active_plugins', $active_plugins );
		}

	}

	add_action( 'wp_ajax_crum_deactivate_installer', 'crum_deactivate_installer' );

	function crum_dataImport() {

		global $installer;

		$installer->set_demo_data( EASY_F_PLUGIN_PATH . 'demo-files/' . $_POST['demo'] . '/' . $_POST['xml'] );

	}

	add_action( 'wp_ajax_crum_dataImport', 'crum_dataImport' );

	function crum_slidersImport() {
		global $installer;
		$demo = $_POST['demo'];
		$installer->set_demo_sliders( $demo );
	}

	add_action( 'wp_ajax_crum_slidersImport', 'crum_slidersImport' );

	function crum_menusImport() {

		global $installer;

		$demo = $_POST['demo'];

		if ( 'niche' === $demo ) {
			$demo_style = $_POST['niche_demo'];
		} elseif ( 'creative' === $demo ) {
			$demo_style = $_POST['creative_demo'];
		} elseif ( 'portfolio' === $demo ) {
			$demo_style = $_POST['portfolio_demo'];
		} elseif ( 'templates' === $demo ) {
			$demo_style = $_POST['hero_demo'];
		} elseif ( 'shop' === $demo ) {
			$demo_style = $_POST['shop_demo'];
		} elseif ( 'magazine' === $demo ) {
			$demo_style = $_POST['magazine_demo'];
		} elseif ( 'onepage' === $demo ) {
			$demo_style = $_POST['onepage_demo'];
		} else {
			$demo_style = $_POST['corporate_demo'];
		}

		$installer->set_demo_menus( $demo );
		$installer->set_demo_homepage( $demo, $demo_style );

	}

	add_action( 'wp_ajax_crum_menusImport', 'crum_menusImport' );

	function crum_otherImport() {

		global $installer;

		$demo = $_POST['demo'];

		$installer->crum_say_hello( $demo );

	}

	add_action( 'wp_ajax_crum_otherImport', 'crum_otherImport' );

	function crum_widgetsImport() {
		$demo = $_POST['demo'];

		$install_parent = new Radium_Theme_Importer;
		$widgets_file   = EASY_F_PLUGIN_PATH . 'demo-files/' . $demo . '/widgets.wie';
		delete_option( 'sidebars_widgets' );
		$install_parent->process_widget_import_file( $widgets_file );
	}

	add_action( 'wp_ajax_crum_widgetsImport', 'crum_widgetsImport' );


	add_action( 'admin_enqueue_scripts', 'crum_importer_admin_scripts' );

	if ( ! function_exists( 'crum_importer_admin_scripts' ) ) {
		function crum_importer_admin_scripts() {
			wp_register_script( 'crum-importer-admin', plugin_dir_url( __FILE__ ) . '/assets/js/admin.js' );
		}
	}

}

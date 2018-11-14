<?php
/**
 * Custom Post Types
 * Portfolio, Megamenu and custom taxonomies
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author  Eddie Machado (@eddiemachado / themeble.com/bones)
 * @since   1.0.0
 * @link    http://codex.wordpress.org/Function_Reference/register_post_type#Example
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if ( ! ( class_exists( 'Crum_Custom_Post_Types' ) ) ) {

	class Crum_Custom_Post_Types {

		function __construct() {

			// Runs when the plugin is activated
			register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );

			add_action( 'init', array( &$this, 'crum_portfolio_register' ) );
			add_action( 'init', array( &$this, 'crum_portfolio_taxonomies' ) );

		}


		/**
		 * Flushes rewrite rules on plugin activation to ensure slides posts don't 404
		 * http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
		 */
		function plugin_activation() {
			$this->crum_portfolio_register();
			flush_rewrite_rules();
		}
		/**
		 * Register portfolio post type
		 * Do not use before init
		 *
		 * @see   register_post_type
		 * @since 1.0.0
		 */
		function crum_portfolio_register() {
			if ( function_exists( 'cs_get_option' ) ) {
				$slug = cs_get_option( 'custom_portfolio_slug' ) ? cs_get_option( 'custom_portfolio_slug' ) : 'portfolio-page';
			} else {
				$slug = 'portfolio-page';
			}


			$labels = array(
				'name'               => __( 'Portfolio', 'polo_extension' ),
				'singular_name'      => __( 'Portfolio Post', 'polo_extension' ),
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'menu_icon'          => 'dashicons-format-gallery',
				'capability_type'    => 'post',
				'taxonomies'         => array( 'portfolio-category', 'portfolio-tag' ),
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 8,
				'rewrite'            => array(
					'slug'       => $slug,
					'with_front' => false,
					'feed'       => true,
					'pages'      => true
				),
				'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' )
			);

			register_post_type( 'portfolio', $args );

		}

		/**
		 * Create portfolio taxonomies
		 * Do not use before init
		 *
		 * @link  http://codex.wordpress.org/Function_Reference/register_taxonomy
		 * @see   register_taxonomy
		 * @since 1.0.0
		 */
		function crum_portfolio_taxonomies() {

			if ( function_exists( 'reactor_option' ) ) {
				$slug = reactor_option( 'custom_portfolio_slug', 'portfolio-page' );
			} else {
				$slug = 'portfolio-page';
			}

			// Add new taxonomy, make it hierarchical ( like categories )
			$labels = array(
				'name'              => __( 'Portfolio Categories', 'polo_extension' ),
				'singular_name'     => __( 'Portfolio Category', 'polo_extension' ),
			);

			register_taxonomy( 'portfolio-category', array( 'portfolio' ),
				array(
					'labels'            => $labels,
					'hierarchical'      => true,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => $slug . '-category' ),
				) );
		}

	}

}

if ( class_exists( 'Crum_Custom_Post_Types' ) ) {
	$Crum_Custom_Post_Types = new Crum_Custom_Post_Types;
}

<?php
/**
 * Register Menus
 * register menus in WordPress
 * creates menu functions for use in theme
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author  Eddie Machado (@eddiemachado / themeble.com/bones)
 * @since   1.0.0
 * @link    http://codex.wordpress.org/Function_Reference/wp_nav_menu
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */
add_action( 'init', 'polo_register_menus' );

function polo_register_menus() {

	/**
	 * Register navigation menus for a theme.
	 *
	 * @since 1.0.0
	 *
	 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
	 */
	$menus = get_theme_support( 'polo-menus' );

	if ( ! is_array( $menus[0] ) ) {
		return;
	}

	if ( in_array( 'top-menu', $menus[0] ) ) {
		register_nav_menu( 'top-menu', esc_html__( 'Top menu', 'polo' ) );
	}

	if ( in_array( 'main-menu', $menus[0] ) ) {
		register_nav_menu( 'main-menu', esc_html__( 'Main Menu', 'polo' ) );
	}

	if ( in_array( 'footer-links', $menus[0] ) ) {
		register_nav_menu( 'footer-links', esc_html__( 'Footer Links', 'polo' ) );
	}

}

/**
 * Main menu
 *
 * @since 1.0.0
 * @see   wp_nav_menu
 *
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( ! function_exists( 'polo_main_menu' ) ) {
	function polo_main_menu() {

		$meta_page_menu = reactor_option( 'meta-page-menu', '', 'page-side-metabox' );

		$defaults = array(
			'theme_location' => 'main-menu',
			'container'      => false,
			'depth'          => 5,
			'echo'           => false,
			'fallback_cb'    => 'polo_menu_fallback',
			'menu_class'     => 'main-menu nav nav-pills',
			'walker'         => new Polo_Nav_Menu_Walker()
		);

		if ( isset( $meta_page_menu ) && ! ( $meta_page_menu === 'default' ) && ! ( $meta_page_menu == '' ) ) {
			$defaults['menu'] = $meta_page_menu;
		}

		$main_menu = wp_nav_menu( $defaults );

		return $main_menu;

	}
}

if(!function_exists('polo_side_menu')){
	function polo_side_menu(){

		$meta_page_menu = reactor_option( 'meta-page-menu', '', 'page-side-metabox' );

		$defaults = array(
			'theme_location' => 'main-menu',
			'container'      => false,
			'depth'          => 1,
			'fallback_cb'    => 'polo_menu_fallback',
			'echo'           => false,
			'walker'         => new Polo_Side_Menu_walker()
		);

		if ( isset( $meta_page_menu ) && ! ( $meta_page_menu === 'default' ) && ! ( $meta_page_menu == '' ) ) {
			$defaults['menu'] = $meta_page_menu;
		}

		$main_menu = wp_nav_menu( $defaults );

		return $main_menu;

	}
}

/**
 * Footer menu
 *
 * @since 1.0.0
 * @see   wp_nav_menu
 *
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( ! function_exists( 'polo_footer_links' ) ) {
	function polo_footer_links() {
		$defaults = array(
			'theme_location' => 'footer-links',
			'container'      => false,
			'menu_class'     => 'inline-list',
			'echo'           => 0,
			'fallback_cb'    => false,
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'          => 1,
		);

		$footer_menu = get_transient( 'nav-footer' );

		if ( $footer_menu === false ) {

			$footer_menu = wp_nav_menu( $defaults );
			set_transient( 'nav-sidebar-secondary', $footer_menu );
		}

		return $footer_menu;


	}
}

/**
 * Clear menu cache
 *
 * @since 1.0.0
 * @see   wp_nav_menu
 *
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */

function polo_invalidate_nav_cache( $id ) {
	$locations = get_nav_menu_locations();
	if ( is_array( $locations ) && $locations ) {
		$locations = array_keys( $locations, $id );
		if ( $locations ) {
			foreach ( $locations as $location ) {
				delete_transient( 'nav-' . $location );
			}
		}
	}
}

add_action( 'wp_update_nav_menu', 'polo_invalidate_nav_cache' );
add_action( 'save_post', 'polo_invalidate_nav_cache' );
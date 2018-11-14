<?php
/**
 * Register Sidebar Widget Areas
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since   1.0.0
 * @link    http://codex.wordpress.org/Function_Reference/register_sidebar
 * @see     register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

function polo_register_sidebars() {

	$sidebars             = get_theme_support( 'polo-sidebars' );
	$footer_sidebar_count = reactor_option( 'footer-sidebars-position' );

	if ( ! is_array( $sidebars[0] ) ) {
		return;
	}

	if ( in_array( 'primary', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Left', 'polo' ) . ' ' . esc_html__( 'Sidebar', 'polo' ),
			'id'            => 'primary-sidebar',
			'description'   => esc_html__( 'Sidebar for layouts', 'polo' ),
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title" >',
			'after_title'   => '</h4>',
		) );
	}

	if ( in_array( 'secondary', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Right', 'polo' ) . ' ' . esc_html__( 'Sidebar', 'polo' ),
			'id'            => 'secondary-sidebar',
			'description'   => esc_html__( 'Sidebar for layouts', 'polo' ),
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title" >',
			'after_title'   => '</h4>',
		) );
	}

	if ( in_array( 'shop-1', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop', 'polo' ) . ' ' . esc_html__( 'Sidebar', 'polo' ). ' 1',
			'id'            => 'shop-1',
			'description'   => esc_html__( 'Sidebar for shop layouts', 'polo' ),
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title" >',
			'after_title'   => '</h4>',
		) );
	}

	if ( in_array( 'shop-2', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop', 'polo' ) . ' ' . esc_html__( 'Sidebar', 'polo' ). ' 2',
			'id'            => 'shop-2',
			'description'   => esc_html__( 'Sidebar for shop layouts', 'polo' ),
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title" >',
			'after_title'   => '</h4>',
		) );
	}

	$footer = '<div id="%1$s" class="widget clearfix';
	$footer .= '  %2$s">';
	register_sidebar( array(
		'name'          => 'FS 1',
		'id'            => 'sidebar-footer-1',
		'description'   => esc_html__( 'Footer widget area', 'polo' ),
		'class'         => '',
		'before_widget' => $footer,
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => 'FS 2',
		'id'            => 'sidebar-footer-2',
		'description'   => esc_html__( 'Footer widget area', 'polo' ),
		'class'         => '',
		'before_widget' => $footer,
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => 'FS 3',
		'id'            => 'sidebar-footer-3',
		'description'   => esc_html__( 'Footer widget area', 'polo' ),
		'class'         => '',
		'before_widget' => $footer,
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => 'FS 4',
		'id'            => 'sidebar-footer-4',
		'description'   => esc_html__( 'Footer widget area', 'polo' ),
		'class'         => '',
		'before_widget' => $footer,
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}

/**
 * Count Widgets
 * Count the number of widgets to add dynamic column class
 *
 * @param string $sidebar_id id of sidebar
 *
 * @return int
 */

function polo_get_widget_columns( $sidebar_id ) {
	// Default number of columns in Foundation grid is 12
	$columns = apply_filters( 'polo_columns', 12 );

	// get the sidebar widgets
	$the_sidebars = wp_get_sidebars_widgets();

	// if sidebar doesn't exist return error
	if ( ! isset( $the_sidebars[ $sidebar_id ] ) ) {
		return esc_html__( 'Invalid sidebar ID', 'polo' );
	}

	/* count number of widgets in the sidebar
	and do some simple math to calculate the columns */
	$num = count( $the_sidebars[ $sidebar_id ] );
	switch ( $num ) {
		case 1 :
			$num = $columns;
			break;
		case 2 :
			$num = $columns / 2;
			break;
		case 3 :
			$num = $columns / 3;
			break;
		case 4 :
			$num = $columns / 4;
			break;
		case 5 :
			$num = $columns / 5;
			break;
		case 6 :
			$num = $columns / 6;
			break;
		case 7 :
			$num = $columns / 7;
			break;
		case 8 :
			$num = $columns / 8;
			break;
	}
	$num = floor( $num );

	return $num;
}
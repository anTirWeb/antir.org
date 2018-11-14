<?php
/**
 * Nav Walkers
 * Customize the menu output for use with Foundation
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since   1.0.0
 * @author  Ben Word (@retlehs / rootstheme.com (nav.php))
 * @link    http://codex.wordpress.org/Function_Reference/Walker_Class
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Top Bar Walker
 *
 * @since 1.0.0
 */
class Top_Bar_Walker extends Walker_Nav_Menu {
	/**
	 * @see   Walker_Nav_Menu::start_lvl()
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"sub-menu dropdown\">\n";
	}

	/**
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param object $args
	 */

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $object, $depth, $args );

		$output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';

		$classes = empty( $object->classes ) ? array() : ( array ) $object->classes;

		if ( in_array( 'label', $classes ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
		}

		if ( in_array( 'divider', $classes ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '', $item_html );
		}

		$output .= $item_html;
	}

	/**
	 * @see   Walker::display_element()
	 * @since 1.0.0
	 *
	 * @param object $element           Data object
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args
	 * @param string $output            Passed by reference. Used to append additional content.
	 *
	 * @return null Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->has_children = ! empty( $children_elements[ $element->ID ] );
		$element->classes[]    = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		//$element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}

function polo_menu_fallback() {

	$output = '<div id="mainMenu"><ul class="main-menu nav nav-pills"><li><div class="no-menu-box">';
	// Translators 1: Link to Menus, 2: Link to Customize
	$output .= sprintf( esc_attr__( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'polo' ),
		sprintf( wp_kses(__( '<a href="%s">Menus</a>', 'polo' ),array('a' => array('href' => array()))),
			get_admin_url( get_current_blog_id(), 'nav-menus.php' )
		),
		sprintf( __( '<a href="%s">Customize</a>', 'polo' ),
			get_admin_url( get_current_blog_id(), 'customize.php' )
		)
	);
	$output .= '</div></li></ul></div>';

	return $output;
}

/*
* Walker for mobile menu
*/

class Polo_Clean_Walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
				foreach ( $children_elements[ $element->$id_field ] as $child_element ) {
					$child_element->is_child = 1;
				}
			}
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_lvl( &$output, $depth = 0, $args = array(), $current_page = 0 ) {
		// depth dependent classes
		$indent        = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0
		$prefix        = '';
		if ( $args->has_children ) {
			$menu_class = 'class="submenu"';
		} else {
			$menu_class = '';
		}
		$ul = '<ul ' . $menu_class . '>';

		$output .= "\n" . $indent . $prefix . $ul . "\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$postfix = '';

		$output .= "{$indent}</ul>{$postfix}\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$iconname = ! empty( $item->_crum_mega_menu_icon ) ? '<i class="' . $item->_crum_mega_menu_icon . '"></i>' : '';


		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$current_indicators = array( 'current-menu-parent', 'current_page_item', 'current_page_parent' );

		$newClasses = array();

		foreach ( $classes as $el ) {
			//check if it's indicating the current page, otherwise we don't need the class
			if ( in_array( $el, $current_indicators ) ) {
				array_push( $newClasses, $el );
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses ), $item ) );

		if ( $args->has_children && ( $depth = 1 ) ) {
			$class_names .= ' menu-item-has-children ';
		}
		if ( $iconname ) {
			$class_names .= ' menu-has-icon ';
		}

		if ( $class_names != '' ) {
			$class_names = ' class="' . esc_attr( $class_names ) . '"';
		}


		$output .= $indent . '<li' . $class_names . '>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		if ( $args->has_children ) {
			$attributes .= ' href="#"';
		} else {
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
		}


		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		if ( $iconname ) {
			$item_output .= $iconname;
		}
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


class Polo_Nav_Menu_Walker extends Walker_Nav_Menu {
	private $_last_ul = '';

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

			$args[0]->is_full = ( $element->_crum_mega_menu_full == 1 );

			$args[0]->is_megamenu = ( $element->_crum_mega_menu_enabled == 1 );

			$args[0]->is_title = ( $element->_crum_mega_menu_title == 1 );

			$args[0]->megamenu_bg = ( $element->_crum_mega_menu_image );

			$args[0]->megamenu_text = ( $element->_crum_mega_menu_text );

			$args[0]->number_columns = ( $element->_crum_mega_menu_columns );

			$args[0]->sep = ( $element->_crum_mega_columns_sep == 1 );

			if ( $element->_crum_mega_columns_sep == 1 && is_array( $children_elements ) ) {
				foreach ( $children_elements[ $element->$id_field ] as $single_child ) {
					$single_child->_crum_mega_child_sep = 1;
				}
			}

			if ( ! empty( $children_elements[ $element->$id_field ] ) && ( $element->_crum_mega_menu_enabled == 1 ) ) {
				foreach ( $children_elements as $child_element ) {
					$args[0]->is_megemenu_child = 1;
				}
			}
			$menu_data = array();
			if ( 0 === $depth && ! empty( $children_elements[ $element->$id_field ] ) ) {
				$menu_data['first_child'] = $children_elements[ $element->$id_field ][0]->ID;
			}

			if ( 0 === $depth && $element->_crum_mega_columns_sep == 1 ) {
				$menu_data['sep'] = true;
			}

			if ( 0 === $depth && $element->_crum_mega_menu_enabled == 1 && ! empty( $element->_crum_mega_menu_columns ) ) {
				$menu_data['columns_number'] = $element->_crum_mega_menu_columns;
			}

			update_option( 'crum_megamenu_columns_' . $element->ID, $menu_data );
		}

		if (
			$depth == 0 &&
			$element->_crum_mega_menu_enabled == 1 &&
			! empty( $children_elements[ $element->$id_field ] )
		) {
			$columns = $element->_crum_mega_menu_columns;
			$cnt     = count( $children_elements[ $element->$id_field ] );

			if ( $columns > 1 && $cnt > 1 ) {
				$delim_step                                                   = ceil( $cnt / $columns );
				$children_elements[ $element->$id_field ][0]->is_mega_submenu = true;
				for ( $i = 0; $i < $cnt; $i ++ ) {

					if ( $i == ( $cnt - 1 ) && $cnt % $delim_step !== 0 ) {

						$children_elements[ $element->$id_field ][ $i ]->is_mega_unlast = true;
					}

					if ( $i == 0 || $i % $delim_step !== 0 ) {
						continue;
					}

					$children_elements[ $element->$id_field ][ $i ]->is_mega_delim   = true;
					$children_elements[ $element->$id_field ][ $i ]->is_mega_submenu = true;


				}
			}
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_lvl( &$output, $depth = 0, $args = array(), $current_page = 0 ) {
		// depth dependent classes
		$indent        = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0

		$classes = array();

		if ( ! ( $args->is_megamenu ) ) {
			$classes[] = 'dropdown-menu';
		}

		$color_class    = '';
		$megamenu_style = 'style="';

		if ( isset( $args->megamenu_bg ) && ! ( $args->megamenu_bg == '' ) ) {
			$megamenu_style .= 'background-image: url(' . $args->megamenu_bg . '); ';
			$megamenu_style .= 'background-size: initial; ';
			$megamenu_style .= 'background-repeat: no-repeat; ';
			$megamenu_style .= 'background-position: right bottom; ';
		}


		$megamenu_style .= '"';

		$prefix = '';
		if ( $depth == 0 && $args->is_megamenu ) {
			$classes[] = '';

			$prefix .= '<ul class="dropdown-menu ' . $color_class . '" >';
			$prefix .= '<li class="mega-menu-content" ' . $megamenu_style . '>';
			$prefix .= '<div class="row">';

			switch ( $args->number_columns ) {
				case '1':
					$classes_width = 'col-md-12';
					break;
				case '2':
					$classes_width = 'col-md-6';
					break;
				case '3':
					$classes_width = 'col-md-4';
					break;
				case '4':
					$classes_width = 'col-md-3';
					break;
				case '6':
					$classes_width = 'col-md-2';
					break;
				default:
					$classes_width = 'col-md-12';
					break;
			}

		}

		$class_names = implode( ' ', $classes );

		$ul = '';

		if ( $display_depth == 1 && $args->is_megamenu ) {
			$ul .= '<div class="' . $classes_width . '"><ul>';
		} else {
			// build html
			$ul .= '<ul class="' . $class_names . '" role="menu">';
		}

		$output .= "\n" . $indent . $prefix . $ul . "\n";

		if ( $display_depth == 1 ) {
			$this->_last_ul = $ul;
		}

	}


	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = implode(' ',$classes);

		// code indent
		$indent    = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
		$item_opts = get_option( 'crum_megamenu_columns_' . $item->menu_item_parent );

		if ( isset( $item_opts['sep'] ) && true === $item_opts['sep'] ) {
			$args->sep = true;
		}

		if ( ! ( true === $args->sep ) ) {
			if ( isset( $item->is_mega_delim ) && $item->is_mega_delim ) {
				$output .= '</ul></div>' . $this->_last_ul;
			}
		}

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'dropdown' : 'dropdown-submenu' ),
			//'menu-item-depth-' . $depth,
		);


		if ( $args->has_children ) {
			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
			if ( 0 === $depth ) {
				$drop_icon = '<i class="fa fa-angle-down"></i>';
			} else {
				$drop_icon = '';
			}
		} else {
			$depth_class_names = $drop_icon = '';
		}

		if ( ! empty( $item->_crum_mega_menu_icon ) ) {
			$class_names .= " has-icon";
		}

		if ( 0 === $depth && ( $args->is_megamenu ) ) {
			$class_names .= '  mega-menu-item';
		}


		$iconname = ! empty( $item->_crum_mega_menu_icon ) ? '<i class="' . $item->_crum_mega_menu_icon . '"></i> ' : '';

		if ( $depth == 1 ) {

			if ( $args->is_title ) {
				$item_opts = get_option( 'crum_megamenu_columns_' . $item->menu_item_parent );

				if ( true === $args->sep ) {
					$columns = $item_opts['columns_number'];
					switch ( $columns ) {
						case '1':
							$classes_width = 'col-md-12';
							break;
						case '2':
							$classes_width = 'col-md-6';
							break;
						case '3':
							$classes_width = 'col-md-4';
							break;
						case '4':
							$classes_width = 'col-md-3';
							break;
						case '6':
							$classes_width = 'col-md-2';
							break;
						default:
							$classes_width = 'col-md-12';
							break;
					}
					if ( $item_opts['first_child'] === $item->ID ) {
						$classes = array_merge($classes, array('mega-menu-title'));
						$class_names = implode(' ',$classes);
						$output .= $indent . '<li class="'.$class_names.'"> ';
					} else {
						$classes = array_merge($classes, array('mega-menu-title'));
						$class_names = implode(' ',$classes);
						$output .= $indent . '</ul></div><div class="' . $classes_width . '"><ul><li class="'.$class_names.'"> ';
					}
				} else {
					$classes = array_merge($classes, array('mega-menu-title'));
					$class_names = implode(' ',$classes);
					$output .= $indent . '<li class="'.$class_names.'"> ';
				}
			} else {
				if ( ( isset( $depth_class_names ) && ! ( $depth_class_names == '' ) ) || ( isset( $class_names ) && ! ( $class_names == '' ) ) ) {
					$output_class = 'class="' . $depth_class_names . ' ' . $class_names . '"';
				} else {
					$output_class = '';
				}
				$output .= $indent . '<li ' . $output_class . '> ';
			}
		} else {
			if ( ( isset( $depth_class_names ) && ! ( $depth_class_names == '' ) ) || ( isset( $class_names ) && ! ( $class_names == '' ) ) ) {
				$output_class = 'class="' . $depth_class_names . ' ' . $class_names . '"';
			} else {
				$output_class = '';
			}
			$output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" ' . $output_class . '>';

		}

		$label_output = '';
		if ( isset( $item->_crum_mega_menu_label ) && ! empty( $item->_crum_mega_menu_label ) ) {
			$label_output .= '<span class="label label-' . $item->_crum_mega_menu_label_style . '">' . $item->_crum_mega_menu_label . '</span>';
		}

		// link attributes
		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) . '"' : '';
		$attributes .= ' class="' . ( $depth > 0 ? 'sub-menu-link' : '' ) . '"';

		if ( $depth == 1 && $args->is_title ) {
			$item_output = apply_filters( 'the_title', $item->title, $item->ID );
		} else {
			$item_output = sprintf(
				'%1$s<a%2$s>%3$s',
				$args->before, $attributes, $iconname
			);
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $label_output;
			$item_output .= $drop_icon;
			$item_output .= sprintf(
				'</a>%1$s',
				$args->after
			);
		}


		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $item->_crum_mega_menu_enabled ) {
			$output .= '</div>';//columns
			$output .= '</div>';//row
			$output .= '</li>';//mega-menu-content
			$output .= '</ul>';//mega-menu
		}
		$output .= "</li>\n";

	}
}

class Polo_Side_Menu_walker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$output .= '<li>';

		$attributes[] = ! empty( $item->attr_title ) ? 'title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes[] = ! empty( $item->target ) ? 'target="' . esc_attr( $item->target ) . '"' : '';
		$attributes[] = ! empty( $item->xfn ) ? 'rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes[] = ! empty( $item->url ) ? 'href="' . esc_url( $item->url ) . '"' : '';

		$attributes[] = 'class="scroll-to"';

		$attributes = implode( ' ', $attributes );

		$item_output = sprintf(
			'%1$s<a%2$s>',
			$args->before, $attributes
		);
		$item_output .= '<span class="cd-dot"></span>';
		$item_output .= '<span class="cd-label">';
		$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</span>';
		$item_output .= sprintf(
			'</a>%1$s',
			$args->after
		);

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}
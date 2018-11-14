<?php

if ( ! defined( 'POLO_MEGA_MENU_CLASS' ) ) {
	define( 'POLO_MEGA_MENU_CLASS', 'Polo_Mega_menu' );
}
if ( ! defined( 'POLO_EDIT_MENU_WALKER_CLASS' ) ) {
	define( 'POLO_EDIT_MENU_WALKER_CLASS', 'Polo_Edit_Menu_Walker' );
}
if ( ! defined( 'POLO_NAV_MENU_WALKER_CLASS' ) ) {
	define( 'POLO_NAV_MENU_WALKER_CLASS', 'Prum_Nav_Menu_Walker' );
}

if ( ! function_exists( 'polo_mega_menu_init' ) ) {
	function polo_mega_menu_init() {
		$class     = POLO_MEGA_MENU_CLASS;
		$mega_menu = new $class();
	}
}

if ( ! class_exists( 'Polo_Mega_menu' ) ) {
	class Polo_Mega_menu {
		var $_options;

		public function __construct() {
			$this->_options = self::options();
			$this->_add_filters();
			$this->get_megamenus();
		}

		private static function get_megamenus() {
			$args = array(
				'post_type'      => 'megamenu',
				'posts_per_page' => - 1
			);


			$post_id    = array( '0' );
			$post_title = array( esc_html__( 'No', 'polo' ) );
			$postslist  = get_posts( $args );
			foreach ( $postslist as $posts ) {
				if ( isset( $posts->ID ) ) {
					$post_id[] .= $posts->ID;
					$post_title[] .= $posts->post_title;
				}
			}

			$megamenus = array_combine( $post_id, $post_title );

			return $megamenus;
		}

		public static function options() {

			return array(
				'_crum_mega_menu_icon'        => array(
					'type'    => 'icon',
					'label'   => esc_html__( 'Icon', 'polo' ),
					'default' => '',
					'size'    => 'wide',
				),
				'_crum_mega_menu_label'       => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Item label', 'polo' ),
					'default' => '',
					'size'    => 'wide',
				),
				'_crum_mega_menu_label_style' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Label style', 'polo' ),
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'danger'  => esc_html__( 'Hot', 'polo' ),
						'success' => esc_html__( 'Popular', 'polo' ),
						'warning' => esc_html__( 'Sale', 'polo' ),
						'info'    => esc_html__( 'Info', 'polo' ),

					),
					'size'    => 'wide',
					'class'   => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_title'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Make this item column title', 'polo' ),
					'default' => 0,
					'options' => array( 1 => esc_html__( 'Yes', 'polo' ), 0 => esc_html__( 'No', 'polo' ) ),
					'size'    => 'wide',
				),
				'_crum_mega_menu_enabled'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Enable mega menu', 'polo' ),
					'default' => 0,
					'options' => array( 1 => esc_html__( 'Yes', 'polo' ), 0 => esc_html__( 'No', 'polo' ) ),
					'size'    => 'thin',
					'class'   => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_columns'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Columns', 'polo' ),
					'default' => '3',
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'size'    => 'thin',
					'class'   => 'crum-show-only-depth-0',
				),
				'_crum_mega_columns_sep'     => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Separate megemenu columns by', 'polo' ),
					'default' => 0,
					'options' => array( 0 => esc_html__( 'Equally', 'polo' ), 1 => esc_html__( 'With menu titles', 'polo' ) ),
					'size'    => 'wide',
				),
				'_crum_mega_menu_image'       => array(
					'type'    => 'image',
					'label'   => esc_html__( 'Select image for background', 'polo' ),
					'default' => '',
					'size'    => 'wide',
					'class'   => 'crum-show-only-depth-0',
				),
			);
		}


		private function _add_filters() {
			# Add custom options to menu
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_options' ) );

			# Update custom menu options
			add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_options' ), 10, 3 );

			# Set edit menu walker
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'apply_edit_walker_class' ), 10, 2 );

		}

		/**
		 * Register custom options and load options values
		 *
		 * @param obj $item Menu Item
		 *
		 * @return obj Menu Item
		 */
		public function add_custom_options( $item ) {

			foreach ( $this->_options as $option => $params ) {
				$item->$option = get_post_meta( $item->ID, $option, true );
				if ( $item->$option === false ) {
					if ( isset( $params['default'] ) && ! ( $params['default'] == '' ) ) {
						$item->$option = $params['default'];
					}
				}
			}

			return $item;
		}

		public function update_custom_options( $menu_id, $menu_item_id, $args ) {
			foreach ( $this->_options as $option => $params ) {
				$key = 'menu-item-' . $option;

				$option_value = '';

				if ( isset( $_REQUEST[ $key ], $_REQUEST[ $key ][ $menu_item_id ] ) ) {
					$option_value = $_REQUEST[ $key ][ $menu_item_id ];
				}

				update_post_meta( $menu_item_id, $option, $option_value );
			}
		}

		public function apply_edit_walker_class( $walker, $menu_id ) {
			return POLO_EDIT_MENU_WALKER_CLASS;
		}
	}
}



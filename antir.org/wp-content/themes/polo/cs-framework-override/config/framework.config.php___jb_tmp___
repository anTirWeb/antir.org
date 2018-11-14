<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title' => esc_html__( 'Theme options', 'polo' ),
	'menu_type'  => 'menu',
	'menu_slug'  => 'cs-framework',
	'ajax_save'  => true,
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$soc_networks_array = array(
	"facebook"     => esc_html__( 'Facebook', 'polo' ),
	"google-plus"  => esc_html__( 'Google', 'polo' ),
	"twitter"      => esc_html__( 'Twitter', 'polo' ),
	"instagram"    => esc_html__( 'Instagram', 'polo' ),
	"xing"         => esc_html__( 'Xing', 'polo' ),
	"lastfm"       => esc_html__( 'LastFM', 'polo' ),
	"dribbble"     => esc_html__( 'Dribble', 'polo' ),
	"vk"           => esc_html__( 'Vkontakte', 'polo' ),
	"youtube"      => esc_html__( 'Youtube', 'polo' ),
	"windows"      => esc_html__( 'Microsoft', 'polo' ),
	"deviantart"   => esc_html__( 'Deviantart', 'polo' ),
	"linkedin"     => esc_html__( 'LinkedIN', 'polo' ),
	"pinterest"    => esc_html__( 'Pinterest', 'polo' ),
	"wordpress"    => esc_html__( 'WordPress', 'polo' ),
	"behance"      => esc_html__( 'Behance', 'polo' ),
	"vimeo-square" => esc_html__( 'Vimeo', 'polo' ),
	"flickr"       => esc_html__( 'Flickr', 'polo' ),
	"rss"          => esc_html__( 'RSS', 'polo' ),
);

$animation_classes = array(
	'none'              => esc_html__( 'None', 'polo' ),
	'bounceIn'          => esc_html__( 'bounceIn', 'polo' ),
	'bounceInDown'      => esc_html__( 'bounceInDown', 'polo' ),
	'bounceInLeft'      => esc_html__( 'bounceInLeft', 'polo' ),
	'bounceInRight'     => esc_html__( 'bounceInRight', 'polo' ),
	'bounceInUp'        => esc_html__( 'bounceInUp', 'polo' ),
	'fadeIn'            => esc_html__( 'fadeIn', 'polo' ),
	'fadeInDown'        => esc_html__( 'fadeInDown', 'polo' ),
	'fadeInDownBig'     => esc_html__( 'fadeInDownBig', 'polo' ),
	'fadeInLeft'        => esc_html__( 'fadeInLeft', 'polo' ),
	'fadeInLeftBig'     => esc_html__( 'fadeInLeftBig', 'polo' ),
	'fadeInRight'       => esc_html__( 'fadeInRight', 'polo' ),
	'fadeInRightBig'    => esc_html__( 'fadeInRightBig', 'polo' ),
	'fadeInUp'          => esc_html__( 'fadeInUp', 'polo' ),
	'fadeInUpBig'       => esc_html__( 'fadeInUpBig', 'polo' ),
	'flipInX'           => esc_html__( 'flipInX', 'polo' ),
	'flipInY'           => esc_html__( 'flipInY', 'polo' ),
	'lightSpeedIn'      => esc_html__( 'lightSpeedIn', 'polo' ),
	'rotateIn'          => esc_html__( 'rotateIn', 'polo' ),
	'rotateInDownLeft'  => esc_html__( 'rotateInDownLeft', 'polo' ),
	'rotateInDownRight' => esc_html__( 'rotateInDownRight', 'polo' ),
	'rotateInUpLeft'    => esc_html__( 'rotateInUpLeft', 'polo' ),
	'rotateInUpRight'   => esc_html__( 'rotateInUpRight', 'polo' ),
	'rollIn'            => esc_html__( 'rollIn', 'polo' ),
	'zoomIn'            => esc_html__( 'zoomIn', 'polo' ),
	'zoomInDown'        => esc_html__( 'zoomInDown', 'polo' ),
	'zoomInLeft'        => esc_html__( 'zoomInLeft', 'polo' ),
	'zoomInRight'       => esc_html__( 'zoomInRight', 'polo' ),
	'zoomInUp'          => esc_html__( 'zoomInUp', 'polo' ),
	'slideInDown'       => esc_html__( 'slideInDown', 'polo' ),
	'slideInLeft'       => esc_html__( 'slideInLeft', 'polo' ),
	'slideInRight'      => esc_html__( 'slideInRight', 'polo' ),
	'slideInUp'         => esc_html__( 'slideInUp', 'polo' ),
);

$img_folder = POLO_ROOT_URL . '/library/img/admin/';

$options = array();

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[] = array(
	'name'   => 'main_options',
	'title'  => esc_html__( 'Main options', 'polo' ),
	'icon'   => 'fa fa-database',
	// begin: fields
	'fields' => array(
		array(
			'id'      => 'envato-api-key', // another unique id
			'type'    => 'text',
			'title'   => esc_html__( 'Item purchase code', 'polo' ),
			'desc'    => wp_kses( __( '<p>Insert item purchase code to receive automatic theme updates.</p>', 'polo' ), array( 'p' => array() ) ),
			'default' => '',

		),
		array(
			'id'      => 'theme-color-scheme',
			'title'   => esc_html__( 'Theme color scheme', 'polo' ),
			'type'    => 'select',
			'options' => array(
				'blue'        => esc_html__( 'Blue', 'polo' ),
				'blue-dark'   => esc_html__( 'Blue-dark', 'polo' ),
				'brown'       => esc_html__( 'Brown', 'polo' ),
				'brown-light' => esc_html__( 'Brown-light', 'polo' ),
				'custom'      => esc_html__( 'Custom', 'polo' ),
				'green'       => esc_html__( 'Green', 'polo' ),
				'green-light' => esc_html__( 'Green light', 'polo' ),
				'orange'      => esc_html__( 'Orange', 'polo' ),
				'pink'        => esc_html__( 'Pink', 'polo' ),
				'red'         => esc_html__( 'Red', 'polo' ),
				'red-dark'    => esc_html__( 'Red-dark', 'polo' ),
				'yellow'      => esc_html__( 'Yellow', 'polo' ),
			),
			'default' => 'blue',
		),
		array(
			'id'         => 'custom_scheme_color',
			'type'       => 'color_picker',
			'title'      => esc_html__( 'Custom color', 'polo' ),
			'dependency' => array( 'theme-color-scheme', '==', 'custom' ),
		),
		array(
			'id'              => 'top-bar-soc-icons',
			'type'            => 'group',
			'title'           => esc_html__( 'Social networks', 'polo' ),
			'button_title'    => esc_html__( 'Add New', 'polo' ),
			'accordion_title' => esc_html__( 'Social network', 'polo' ),
			'fields'          => array(
				array(
					'id'      => 'social-network-icon',
					'type'    => 'select',
					'options' => $soc_networks_array,
					'title'   => esc_html__( 'Select available social network', 'polo' ),
				),
				array(
					'id'    => 'social-network-url',
					'type'  => 'text',
					'title' => esc_html__( 'Link of your page', 'polo' ),
				),
			),
		),
		array(
			'id'      => 'boxed-body',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Enable boxed body', 'polo' ),
			'default' => false
		),
		array(
			'id'         => 'boxed_body_background',
			'type'       => 'background',
			'title'      => esc_html__( 'Boxed body background options', 'polo' ),
			'dependency' => array( 'boxed-body', '==', 'true' )
		),
		array(
			'id'         => 'normal_body_background',
			'type'       => 'background',
			'title'      => esc_html__( 'Body background options', 'polo' ),
			'dependency' => array( 'boxed-body', '!=', 'true' )
		),
		array(
			'id'        => 'home_title', // this is must be unique
			'type'      => 'text',
			'title'     => esc_html__( 'Title for home page', 'polo' ),
			'multilang' => true
		),
		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Preloader settings', 'polo' )

		),
		array(
			'id'      => 'preloader_disable',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Disable preloader', 'polo' ),
			'default' => false
		),
		array(
			'id'         => 'preloader_icon',
			'title'      => esc_html__( 'Icon', 'polo' ),
			'type'       => 'select',
			'options'    => array(
				'audio'            => esc_html__( 'Audio', 'polo' ),
				'ball_triangle'    => esc_html__( 'Ball triangle', 'polo' ),
				'bars'             => esc_html__( 'Bars', 'polo' ),
				'circles'          => esc_html__( 'Circles', 'polo' ),
				'grid'             => esc_html__( 'Grid', 'polo' ),
				'hearts'           => esc_html__( 'Hearts', 'polo' ),
				'oval'             => esc_html__( 'Oval', 'polo' ),
				'puff'             => esc_html__( 'Puff', 'polo' ),
				'ring'             => esc_html__( 'Ring', 'polo' ),
				'rings'            => esc_html__( 'Rings', 'polo' ),
				'spin'             => esc_html__( 'Spin', 'polo' ),
				'spinning_circles' => esc_html__( 'Spinning circles', 'polo' ),
				'three_dots'       => esc_html__( 'Three dots', 'polo' ),
			),
			'default'    => 'ring',
			'dependency' => array( 'preloader_disable', '!=', 'true' )
		),
		array(
			'id'         => 'preoader_animation',
			'title'      => esc_html__( 'Animation', 'polo' ),
			'type'       => 'select',
			'options'    => array(
				'fade'       => esc_html__( 'Fade', 'polo' ),
				'fade_up'    => esc_html__( 'Fade Up', 'polo' ),
				'fade_down'  => esc_html__( 'Fade Down', 'polo' ),
				'fade_left'  => esc_html__( 'Fade Left', 'polo' ),
				'fade_right' => esc_html__( 'Fade Right', 'polo' ),
				'rotate'     => esc_html__( 'Rotate', 'polo' ),
				'flip_x'     => esc_html__( 'Flip X', 'polo' ),
				'flip_y'     => esc_html__( 'Flip Y', 'polo' ),
				'zoom'       => esc_html__( 'Zoom', 'polo' ),
				'overlay'    => esc_html__( 'Overlay', 'polo' ),
			),
			'default'    => 'fade',
			'dependency' => array( 'preloader_disable', '!=', 'true' )
		),
	), // end: fields
);

/*
 *Header options
 */
$options[] = array(
	'name'     => 'header_options',
	'title'    => esc_html__( 'Header options', 'polo' ),
	'icon'     => 'fa fa-level-up',
	// begin: fields
	'sections' => array(
		array(
			'name'   => 'top-bar-options',
			'title'  => esc_html__( 'Top bar options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'top-bar-enable',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable top bar', 'polo' ),
					'default' => true
				),
				array(
					'id'         => 'top-bar-color',
					'title'      => esc_html__( 'Top bar color', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'white'  => esc_html__( 'White', 'polo' ),
						'dark'   => esc_html__( 'Dark', 'polo' ),
						'custom' => esc_html__( 'Custom', 'polo' ),
					),
					'default'    => 'white',
					'dependency' => array( 'top-bar-enable', '==', 'true' ),
				),
				array(
					'id'         => 'top-bar-transparent',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Enable transparency on top bar', 'polo' ),
					'default'    => false,
					'dependency' => array( 'top-bar-color', '==', 'white' ),
				),
				array(
					'id'         => 'top-bar-custom-bg-color',
					'type'       => 'color_picker',
					'title'      => esc_html__( 'Custom background color for top bar', 'polo' ),
					'dependency' => array( 'top-bar-color', '==', 'custom' ),
				),
				array(
					'id'         => 'top-bar-custom-color',
					'type'       => 'color_picker',
					'title'      => esc_html__( 'Custom text color for top bar', 'polo' ),
					'dependency' => array( 'top-bar-color', '==', 'custom' ),
				),
				array(
					'type'    => 'heading',
					'content' => esc_html__('Left panel settings','polo'),
					'dependency'      => array( 'top-bar-enable', '==', 'true' ),
				),
				array(
					'id'             => 'top-bar-panel-left',
					'type'           => 'sorter',
					'title'          => esc_html__( 'Add / Sort contents on left side of top bar', 'polo' ),
					'default'        => array(
						'enabled'  => array(
							'polo_top_menu' => esc_html__( 'Menu', 'polo' ),

						),
						'disabled' => array(
							'top_bar_social' => esc_html__( 'Social buttons', 'polo' ),
							'top_bar_left_text' => esc_html__( 'Text', 'polo' ),
							'top_bar_language'     => esc_html__( 'Language switcher', 'polo' ),
						),
					),
					'enabled_title'  => esc_html__( 'Active elements', 'polo' ),
					'disabled_title' => esc_html__( 'Disabled elements', 'polo' ),
					'dependency'     => array( 'top-bar-enable', '==', 'true' ),

				),
				array(
					'id'         => 'top-bar-panel-text-left',
					'type'       => 'textarea',
					'title'      => esc_html__( 'Text', 'polo' ),
					'multilang'  => true,
					'dependency' => array( 'top-bar-enable', '==', 'true' ),
				),
				array(
					'type'    => 'heading',
					'content' => esc_html__('Right panel settings','polo'),
					'dependency'      => array( 'top-bar-enable', '==', 'true' ),
				),
				array(
					'id'             => 'top-bar-panel-right',
					'type'           => 'sorter',
					'title'          => esc_html__( 'Add / Sort contents on right side of top bar', 'polo' ),
					'default'        => array(
						'enabled'  => array(
							'top_bar_social' => esc_html__( 'Social buttons', 'polo' ),
						),
						'disabled' => array(
							'top_bar_language'     => esc_html__( 'Language switcher', 'polo' ),
							'top_bar_right_text'   => esc_html__( 'Text', 'polo' ),
							'polo_top_menu' => esc_html__( 'Menu', 'polo' ),
						),
					),
					'enabled_title'  => esc_html__( 'Active elements', 'polo' ),
					'disabled_title' => esc_html__( 'Disabled elements', 'polo' ),
					'dependency'     => array( 'top-bar-enable', '==', 'true' ),
				),
				array(
					'id'         => 'top-bar-panel-text-right',
					'type'       => 'textarea',
					'title'      => esc_html__( 'Text', 'polo' ),
					'multilang'  => true,
					'dependency' => array( 'top-bar-enable', '==', 'true' ),
				),
			)

		),
		array(
			'name'   => 'header-main-options',
			'title'  => esc_html__( 'Header options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'         => 'logo_height',
					'type'       => 'number',
					'title'      => esc_html__( 'Logo Height ( px )', 'polo' ),
					'default' => '90',
				),
				array(
					'id'         => 'header_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Header Style', 'polo' ),
					'options'    => array(
						'standard' => $img_folder . 'header-layout-classic.png',
						'side'     => $img_folder . 'header-layout-side.png',
					),
					'default'    => 'standard',
					'radio'      => true,
					'attributes' => array(
						'data-depend-id' => 'header_style_select'
					),
				),
				array(
					'id'         => 'main_header_layout',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Header layout', 'polo' ),
					'options'    => array(
						'classic'  => $img_folder . 'header-layout-classic.png',
						'modern'   => $img_folder . 'header-menu-modern.png',
						'centered' => $img_folder . 'header-menu-center.png',
					),
					'default'    => 'classic',
					'radio'      => true,
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
					'attributes' => array(
						'data-depend-id' => 'header_layout'
					),
				),
				array(
					'id'         => 'classic_header_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Header style', 'polo' ),
					'options'    => array(
						'light'             => esc_html__( 'Light', 'polo' ),
						'light_transparent' => esc_html__( 'Light transparent', 'polo' ),
						'dark'              => esc_html__( 'Dark', 'polo' ),
						'dark_transparent'  => esc_html__( 'Dark transparent', 'polo' ),
						'transparent'       => esc_html__( 'Transparent', 'polo' ),
					),
					'default'    => 'light',
					'dependency' => array( 'header_style_select|header_layout', '==|==', 'standard|classic' )
				),
				array(
					'id'         => 'classic_transparent_menu',
					'type'       => 'select',
					'title'      => esc_html__( 'Menu color', 'polo' ),
					'options'    => array(
						'light' => esc_html__( 'Light', 'polo' ),
						'dark'  => esc_html__( 'Dark', 'polo' ),
					),
					'default'    => 'dark',
					'dependency' => array(
						'header_style_select|header_layout|classic_header_style',
						'==|==|==',
						'standard|classic|transparent'
					)
				),
				array(
					'id'         => 'modern_header_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Header style', 'polo' ),
					'options'    => array(
						'simple'           => esc_html__( 'Simple', 'polo' ),
						'light'            => esc_html__( 'Light', 'polo' ),
						'dark'             => esc_html__( 'Dark', 'polo' ),
						'dark_transparent' => esc_html__( 'Dark transparent', 'polo' ),
					),
					'default'    => 'simple',
					'dependency' => array( 'header_style_select|header_layout', '==|==', 'standard|modern' )
				),
				array(
					'id'         => 'header_logo_position',
					'type'       => 'select',
					'title'      => esc_html__( 'Logo position', 'polo' ),
					'options'    => array(
						'left'  => esc_html__( 'Left', 'polo' ),
						'right' => esc_html__( 'Right', 'polo' ),
					),
					'dependency' => array( 'header_style_select|header_layout', '==|!=', 'standard|centered' )
				),
				array(
					'id'         => 'header_full_width',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Full width header', 'polo' ),
					'default'    => false,
					'dependency' => array( 'header_style_select|header_layout', '==|!=', 'standard|centered' )
				),
				array(
					'id'         => 'header_mini',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Mini header', 'polo' ),
					'default'    => false,
					'dependency' => array( 'header_style_select|header_layout', '==|!=', 'standard|centered' )
				),
				array(
					'id'         => 'header_sticky',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Sticky header', 'polo' ),
					'default'    => true,
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
				),
				array(
					'id'         => 'header_sticky_mobile',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Sticky header on mobile devices', 'polo' ),
					'default'    => false,
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
				),
				array(
					'id'    => 'logotype-image',
					'type'  => 'image',
					'title' => esc_html__( 'Logotype pictogram', 'polo' ),
				),
				array(
					'id'    => 'logotype-image-retina',
					'type'  => 'image',
					'title' => esc_html__( 'Retina Ready Logotype pictogram', 'polo' ),
					'desc'  => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
				),
				array(
					'id'         => 'header-search',
					'type'       => 'switcher',
					'default'    => false,
					'title'      => esc_html__( 'Search', 'polo' ),
					'desc'       => esc_html__( 'Hide search panel in header', 'polo' ),
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
				),
				array(
					'id'         => 'header-cart',
					'type'       => 'switcher',
					'default'    => false,
					'title'      => esc_html__( 'Cart', 'polo' ),
					'desc'       => esc_html__( 'Hide cart in header', 'polo' ),
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
				),
				array(
					'id'         => 'header-side-menu',
					'type'       => 'switcher',
					'default'    => false,
					'title'      => esc_html__( 'Menu button', 'polo' ),
					'desc'       => esc_html__( 'Show menu button', 'polo' ),
					'dependency' => array(
						'header_style_select',
						'==',
						'standard'
					),
				),
				array(
					'id'         => 'custom_menu_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Menu style', 'polo' ),
					'options'    => array(
						'left'   => esc_html__( 'Panel on left', 'polo' ),
						'hidden' => esc_html__( 'Hidden menu', 'polo' ),
					),
					'default'    => 'left',
					'dependency' => array( 'header_style_select|header-side-menu', '==|==', 'standard|true' )
				),
				array(
					'id'         => 'header_logo_text',
					'type'       => 'wysiwyg',
					'title'      => esc_html__( 'Logotype text', 'polo' ),
					'dependency' => array( 'header_style_select', '==', 'side' ),
					'multilang'  => true
				),
				array(
					'id'         => 'side_header_hide_menu',
					'type'       => 'switcher',
					'default'    => false,
					'title'      => esc_html__( 'Hide menu', 'polo' ),
					'dependency' => array(
						'header_style_select',
						'==',
						'side'
					),
				),
				array(
					'id'         => 'header_side_description',
					'type'       => 'wysiwyg',
					'title'      => esc_html__( 'Description text', 'polo' ),
					'dependency' => array( 'header_style_select', '==', 'side' ),
					'multilang'  => true,
					'settings'   => array( 'wpautop' => false )
				),
				array(
					'id'         => 'header_soc_icons_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Soc icons style', 'polo' ),
					'options'    => array(
						'dark'    => esc_html__( 'Dark', 'polo' ),
						'colored' => esc_html__( 'Colored', 'polo' ),
					),
					'default'    => 'dark',
					'dependency' => array( 'header_style_select', '==', 'side' )
				),

			), // end: fields
		),
	),

);

/*
 * Stunning header options
 */
$options[] = array(
	'name'   => 'stunning_header_options',
	'title'  => esc_html__( 'Stunning header options', 'polo' ),
	'icon'   => 'fa fa-puzzle-piece',
	// begin: fields
	'fields' => array(
		array(
			'id'      => 'stunning_header_show',
			'type'    => 'switcher',
			'title'   => esc_html__( 'Show stunning header ', 'polo' ),
			'default' => true,
		),
		array(
			'id'      => 'show-page-title',
			'type'    => 'select',
			'title'   => esc_html__( 'Show Page Title', 'polo' ),
			'options' => array(
				'default'  => esc_html__( 'Default', 'polo' ),
				'true' => esc_html__( 'Show', 'polo' ),
				'false'    => esc_html__( 'Hide', 'polo' ),
			),
			'dependency' => array( 'stunning_header_show', '==', 'false' )
		),
		array(
			'id'         => 'stunning-header-style',
			'title'      => esc_html__( 'Style', 'polo' ),
			'type'       => 'select',
			'options'    => array(
				'default'  => esc_html__( 'Animated', 'polo' ),
				'parallax' => esc_html__( 'Parallax', 'polo' ),
				'video'    => esc_html__( 'Video', 'polo' ),
				'extended' => esc_html__( 'Extended', 'polo' ),
				'pattern'  => esc_html__( 'Pattern', 'polo' ),
				'colored'  => esc_html__( 'Colored', 'polo' ),
				'dark'     => esc_html__( 'Dark', 'polo' ),
				'light'    => esc_html__( 'Light', 'polo' ),
			),
			'default'    => 'default',
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
        array(
            'id'         => 'stunning-header-background-color',
            'type'       => 'color_picker',
            'title'      => esc_html__( 'Background color', 'polo' ),
            'dependency' => array('stunning_header_show|stunning-header-style', '==|==', 'true|default' ),
        ),
		array(
			'id'         => 'st-header-subtitle', // this is must be unique
			'type'       => 'text',
			'multilang'  => true,
			'title'      => esc_html__( 'Stunning header subtitle', 'polo' ),
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
		array(
			'id'         => 'stunning-header-align',
			'title'      => esc_html__( 'Title align', 'polo' ),
			'type'       => 'select',
			'options'    => array(
				'left'   => esc_html__( 'Left', 'polo' ),
				'right'  => esc_html__( 'Right', 'polo' ),
				'center' => esc_html__( 'Center', 'polo' ),
			),
			'default'    => 'left',
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
		array(
			'id'         => 'stunning-header-animation',
			'title'      => esc_html__( 'Stunning header animation', 'polo' ),
			'type'       => 'select',
			'options'    => $animation_classes,
			'default'    => 'none',
			'dependency' => array( 'stunning_header_show|stunning-header-style', '==|any', 'true|default' ),
		),
		array(
			'id'         => 'st-header-bg-image',
			'type'       => 'image',
			'title'      => esc_html__( 'Background image', 'polo' ),
			'dependency' => array(
				'stunning_header_show|stunning-header-style',
				'==|any',
				'true|default,parallax,extended,pattern'
			),
		),
		
//		array(
//			'id'         => 'st-header-text-color',
//			'type'       => 'color_picker',
//			'title'      => esc_html__( 'Custom text color ', 'polo' ),
//			'dependency' => array( 'stunning_header_show', '==', 'true' )
//		),
		array(
			'id'         => 'st-color-text-typography',
			'type'       => 'typography',
			'title'      => esc_html__( 'Stunning header typography', 'polo' ),
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
		array(
			'id'         => 'st-header-height',
			'type'       => 'number',
			'title'      => esc_html__( 'Custom height', 'polo' ),
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
		array(
			'id'         => 'st-header-embed-video-bg', // this is must be unique
			'type'       => 'text',
			'title'      => esc_html__( 'Embed video', 'polo' ),
			'dependency' => array( 'stunning_header_show|stunning-header-style', '==|==', 'true|video' ),
		),
		array(
			'id'         => 'st-header-bg-video-mp4',
			'type'       => 'upload',
			'title'      => 'Mp4 ' . esc_html__( 'video', 'polo' ),
			'settings'   => array(
				'upload_type'  => 'video',
				'button_title' => 'Video',
				'frame_title'  => esc_html__( 'Select a video', 'polo' ),
				'insert_title' => esc_html__( 'Use this video', 'polo' ),
			),
			'dependency' => array( 'stunning_header_show|stunning-header-style', '==|==', 'true|video' ),
		),
		array(
			'id'         => 'st-header-bg-video-webm',
			'type'       => 'upload',
			'title'      => 'Webm ' . esc_html__( 'video', 'polo' ),
			'settings'   => array(
				'upload_type'  => 'video',
				'button_title' => 'Video',
				'frame_title'  => esc_html__( 'Select a video', 'polo' ),
				'insert_title' => esc_html__( 'Use this video', 'polo' ),
			),
			'dependency' => array( 'stunning_header_show|stunning-header-style', '==|==', 'true|video' ),
		),
		array(
			'id'         => 'st-header-bg-video-ogg',
			'type'       => 'upload',
			'title'      => 'Ogg ' . esc_html__( 'video', 'polo' ),
			'settings'   => array(
				'upload_type'  => 'video',
				'button_title' => 'Video',
				'frame_title'  => esc_html__( 'Select a video', 'polo' ),
				'insert_title' => esc_html__( 'Use this video', 'polo' ),
			),
			'dependency' => array( 'stunning_header_show|stunning-header-style', '==|==', 'true|video' ),
		),
		array(
			'id'      => 'stunning-show-breadcrumbs',
			'type'    => 'select',
			'title'   => esc_html__( 'Show Breadcrumbs', 'polo' ),
			'options' => array(
				'true' => esc_html__( 'Show', 'polo' ),
				'false'    => esc_html__( 'Hide', 'polo' ),
			),
			'default' => 'true',
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),
		array(
			'id'      => 'breadcrumb_style',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Breadcrumbs style', 'polo' ),
			'options' => array(
				'simple'  => $img_folder . 'breadcrumb-default.png',
				'classic' => $img_folder . 'breadcrumb-classic.png',
				'round'   => $img_folder . 'breadcrumb-radius.png',
				'fancy'   => $img_folder . 'breadcrumb-fancy.png',
			),
			'default' => 'simple',
			'radio'   => true,
			'dependency' => array( 'stunning_header_show', '==', 'true' )
		),

	), // end: fields
);
/*
 * Post options
 */
$options[] = array(
	'name'     => 'single_post_options',
	'title'    => esc_html__( 'Post options', 'polo' ),
	'icon'     => 'fa fa-newspaper-o',
	// begin: fields
	'sections' => array(
		array(
			'name'   => 'blog_post_options',
			'title'  => esc_html__( 'Blog post options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'         => 'blog_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Blog style', 'polo' ),
					'options'    => array(
						'classic'   => $img_folder . 'blog-classic.png',
						'modern'    => $img_folder . 'blog-modern.png',
						'masonry'   => $img_folder . 'blog-masonry.png',
						'timeline'  => $img_folder . 'blog-timeline.png',
						'thumbnail' => $img_folder . 'blog-thumb.png',
					),
					'default'    => 'classic',
					'radio'      => true,
					'attributes' => array(
						'data-depend-id' => 'options-blog-style'
					),
				),
				array(
					'id'         => 'blog_columns_number',
					'type'       => 'select',
					'title'      => esc_html__( 'Columns number', 'polo' ),
					'options'    => array(
						'1' => '1 ' . esc_html__( 'column', 'polo' ),
						'2' => '2 ' . esc_html__( 'columns', 'polo' ),
						'3' => '3 ' . esc_html__( 'columns', 'polo' ),
						'4' => '4 ' . esc_html__( 'columns', 'polo' ),
						'5' => '5 ' . esc_html__( 'columns', 'polo' ),
					),
					'default'    => '2',
					'dependency' => array( 'options-blog-style', '==', 'classic' )
				),
				array(
					'id'         => 'thumbnail_blog_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Thumbnail blog style', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'options-blog-style', '==', 'thumbnail' )
				),
				array(
					'id'         => 'blog_columns_number_masonry',
					'type'       => 'select',
					'title'      => esc_html__( 'Columns number', 'polo' ),
					'options'    => array(
						'2' => '2 ' . esc_html__( 'columns', 'polo' ),
						'3' => '3 ' . esc_html__( 'columns', 'polo' ),
						'4' => '4 ' . esc_html__( 'columns', 'polo' ),
					),
					'default'    => '2',
					'dependency' => array( 'options-blog-style', 'any', 'masonry,modern' )
				),
				array(
					'id'         => 'masonry_fullwidth',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Masonry blog full width', 'polo' ),
					'dependency' => array( 'options-blog-style', '==', 'masonry' )
				),
				array(
					'id'    => 'excerpt_length',
					'type'  => 'number',
                    'default'    => '40',
					'title' => esc_html__( 'Excerpt length', 'polo' ),
				),
				array(
					'id'      => 'share_soc_networks',
					'type'    => 'checkbox',
					'title'   => esc_html__( 'Share post in:', 'polo' ),
					'options' => array(
						'twitter'       => 'Twitter',
						'facebook'      => 'Facebook',
						'linkedin'      => 'Linkedin',
						'gplus'         => 'Gplus',
						'vkontakte'     => 'Vkontakte',
						'odnoklassniki' => 'Odnoklassniki',
						'telegram'      => 'Telegram',
						'pinterest'     => 'Pinterest',
					),
					'default' => array( 'twitter', 'facebook' , 'gplus' )
				),
				array(
					'id'         => 'pagination_type',
					'type'       => 'select',
					'title'      => esc_html__( 'Pagination type', 'polo' ),
					'options'    => array(
						'pagination' => esc_html__( 'Pagination', 'polo' ),
						'pager'      => esc_html__( 'Pager', 'polo' ),
						'load_more'  => esc_html__( 'Load more button', 'polo' ),
					),
					'desc' => esc_html__('Note! Pager pagination will not be displayed if you set you blog page as a home page in Settings->Reading>Static front page. Numbered pagination will be displayed instead','polo'),
					'default'    => 'pagination',
					'dependency' => array( 'options-blog-style', '!=', 'timeline' )
				),
				array(
					'id'         => 'pagination_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pagination style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'pagination-classic.png',
						'rounded' => $img_folder . 'pagination-rounded.png',
						'simple'  => $img_folder . 'pagination-simple.png',
						'fancy'   => $img_folder . 'pagination-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'options-blog-style|pagination_type', '!=|==', 'timeline|pagination' )
				),
				array(
					'id'         => 'pager_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pager style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'pager-classic.png',
						'modern'  => $img_folder . 'pager-modern.png',
						'fancy'   => $img_folder . 'pager-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'options-blog-style|pagination_type', '!=|==', 'timeline|pager' ),
					'attributes' => array(
						'data-depend-id' => 'options-pager-style'
					),
				),
				array(
					'id'         => 'pager_fullwidth',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Enable full width', 'polo' ),
					'dependency' => array(
						'options-blog-style|pagination_type|options-pager-style',
						'!=|==|!=',
						'timeline|pager|modern'
					)
				),
			)
		),
		array(
			'name'   => 'single_post_options',
			'title'  => esc_html__( 'Single post options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'single_post_style',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Single post style', 'polo' ),
					'options' => array(
						'classic' => $img_folder . 'single-classic.png',
						'modern'  => $img_folder . 'single-modern.png',
					),
					'default' => 'classic',
					'radio'   => true,
				),
				array(
					'id'      => 'stunning_feature_image',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Use Post Image as background for stunning header', 'polo' ),
					'default' => 'false',
				),
				array(
					'id'      => 'gallery_type',
					'type'    => 'select',
					'title'   => esc_html__( 'Gallery feature type', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default gallery', 'polo' ),
						'slider'  => esc_html__( 'Slider', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'inner_pagination',
					'type'    => 'select',
					'title'   => esc_html__( 'Inner post pagination type', 'polo' ),
					'options' => array(
						'numbered'  => esc_html__( 'Numbered', 'polo' ),
						'prev_next' => esc_html__( 'Prev/next', 'polo' ),
					),
					'default' => 'numbered',
				),
			)
		)

	), // end: fields
);

/*
 *Portfolio options
 */
$options[] = array(
	'name'     => 'portfolio_options',
	'title'    => esc_html__( 'Portfolio options', 'polo' ),
	'icon'     => 'fa fa-picture-o',
	// begin: fields
	'sections' => array(
		array(
			'name'   => 'portfolio_blog_options',
			'title'  => esc_html__( 'Blog portfolio options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
			    array(
			        'id' => 'portfolio_main_page',
                    'type' => 'select',
                    'title' => esc_html__('Portfolio main page','polo'),
                    'options' => polo_get_portfolio_pages(),
                ),
				array(
					'id'      => 'custom_portfolio_slug', // another unique id
					'type'    => 'text',
					'title'   => esc_html__( 'Custom portfolio slug', 'polo' ),
					'default' => '',

				),
				array(
					'id'      => 'portfolio_blog_style',
					'type'    => 'select',
					'title'   => esc_html__( 'Portfolio blog style', 'polo' ),
					'options' => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'masonry' => esc_html__( 'Masonry', 'polo' ),
					),
					'default' => 'classic',
				),
				array(
					'id'      => 'portfolio_columns_number',
					'type'    => 'select',
					'title'   => esc_html__( 'Columns number', 'polo' ),
					'options' => array(
						'1' => '1 ' . esc_html__( 'column', 'polo' ),
						'2' => '2 ' . esc_html__( 'columns', 'polo' ),
						'3' => '3 ' . esc_html__( 'columns', 'polo' ),
						'4' => '4 ' . esc_html__( 'columns', 'polo' ),
						'5' => '5 ' . esc_html__( 'columns', 'polo' ),
						'6' => '6 ' . esc_html__( 'columns', 'polo' ),
					),
					'default' => '1',
				),
				array(
					'id'    => 'items_per_page',
					'type'  => 'number',
					'title' => esc_html__( 'Items per page', 'polo' ),
				),
				array(
					'id'      => 'enable_fullwidth',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable full width', 'polo' ),
					'default' => 'false',
				),
                array(
                    'id'      => 'enable_custom_size',
                    'type'    => 'switcher',
                    'title'   => esc_html__( 'Enable custom portfolio thumb size', 'polo' ),
                    'default' => 'false',
                ),
                array(
                    'id'      => 'custom_size_width', // another unique id
                    'type'    => 'text',
                    'title'   => esc_html__( 'Width(px)', 'polo' ),
                    'default' => '',

                ),
                array(
                    'id'      => 'custom_size_height', // another unique id
                    'type'    => 'text',
                    'title'   => esc_html__( 'Height(px)', 'polo' ),
                    'default' => '',
                ),
				array(
					'id'         => 'portfolio_hover_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Hover style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'portfolio-hover-default.png',
						'alea'    => $img_folder . 'portfolio-hover-alea.png',
						'ariol'   => $img_folder . 'portfolio-hover-areol.png',
						'dia'     => $img_folder . 'portfolio-hover-dia.png',
						'dorian'  => $img_folder . 'portfolio-hover-dorian.png',
						'emma'    => $img_folder . 'portfolio-hover-emma.png',
						'erdi'    => $img_folder . 'portfolio-hover-erdi.png',
						'juna'    => $img_folder . 'portfolio-hover-juna.png',
						'resa'    => $img_folder . 'portfolio-hover-resa.png',
						'retro'   => $img_folder . 'portfolio-hover-retro.png',
						'victor'  => $img_folder . 'portfolio-hover-victor.png',
						'bleron'  => $img_folder . 'portfolio-hover-bleron.png',
					),
					'attributes' => array(
						'data-depend-id' => 'folio_hover'
					),
					'default'    => 'default',
					'radio'      => true,
				),
				array(
					'id'         => 'show_title',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Show title', 'polo' ),
					'default'    => 'true',
					'dependency' => array( 'folio_hover', '==', 'default' ),
				),
				array(
					'id'      => 'disable_spaces',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Disable spaces between items', 'polo' ),
					'default' => 'false',
				),
				array(
					'id'      => 'enable_gray_bg',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable grey background', 'polo' ),
					'default' => 'false',
				),
				array(
					'id'         => 'show_excerpt',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Show excerpt', 'polo' ),
					'default'    => 'false',
					'dependency' => array( 'folio_hover', '==', 'default' ),
				),
			)
		),
		array(
			'name'   => 'single_portfolio_options',
			'title'  => esc_html__( 'Single portfolio options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'id'      => 'portfolio-single-layout',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Portfolio item layout', 'polo' ),
					'options' => array(
						'left'   => $img_folder . 'folio-media-left.png',
						'right'  => $img_folder . 'folio-media-right.png',
						'top'    => $img_folder . 'folio-media-top.png',
						'bottom' => $img_folder . 'folio-media-bottom.png',
						'full'   => $img_folder . 'folio-media-none.png',
					),
					'default' => 'left',
					'radio'   => true,
				),
				array(
					'id'      => 'hide_share',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Hide share buttons', 'polo' ),
					'default' => false,
				),
				array(
					'id'         => 'folio_soc_networks',
					'type'       => 'sorter',
					'title'      => esc_html__( 'Soc networks to share', 'polo' ),
					'default'    => array(
						'enabled'  => array(
							'facebook'  => 'Facebook',
							'twitter'   => 'Twitter',
							'google'    => 'Google +',
							'pinterest' => 'Pinterest',
							"xing"         => esc_html__( 'Xing', 'polo' ),
							'linkedin'  => 'LinkedIn',
							"vk"           => esc_html__( 'Vkontakte', 'polo' ),
						),
						'disabled' => array(),
					),
					'dependency' => array( 'hide_share', '!=', 'true' ),
				),
				array(
					'id'      => 'show_related',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Show related portfolios', 'polo' ),
					'default' => false,
				),
				array(
					'id'         => 'related_posts_title', // this is must be unique
					'type'       => 'text',
					'title'      => esc_html__( 'Related portfolio title', 'polo' ),
					'dependency' => array( 'show_related', '==', 'true' ),
				),
				array(
					'id'         => 'related_posts_number',
					'type'       => 'select',
					'options'    => array(
						'2' => '2 ' . esc_html__( 'items', 'polo' ),
						'3' => '3 ' . esc_html__( 'items', 'polo' ),
						'4' => '4 ' . esc_html__( 'items', 'polo' ),
						'6' => '6 ' . esc_html__( 'items', 'polo' ),
					),
					'title'      => esc_html__( 'Related posts number', 'polo' ),
					'dependency' => array( 'show_related', '==', 'true' ),
					'default'    => 4
				),
			)
		),
		array(
			'name'   => 'styling_portfolio_options',
			'title'  => esc_html__( 'Portfolio pagination', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'portfolio_pagination_type',
					'type'    => 'select',
					'title'   => esc_html__( 'Pagination type', 'polo' ),
					'options' => array(
						'pagination' => esc_html__( 'Pagination', 'polo' ),
						'pager'      => esc_html__( 'Pager', 'polo' ),
						'load_more'  => esc_html__( 'Load more button', 'polo' ),
					),
					'default' => 'pagination',
				),
				array(
					'id'         => 'portfolio_pagination_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pagination style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'pagination-classic.png',
						'rounded' => $img_folder . 'pagination-rounded.png',
						'simple'  => $img_folder . 'pagination-simple.png',
						'fancy'   => $img_folder . 'pagination-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'portfolio_pagination_type', '==', 'pagination' )
				),
				array(
					'id'         => 'portfolio_pager_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pager style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'pager-classic.png',
						'modern'  => $img_folder . 'pager-modern.png',
						'fancy'   => $img_folder . 'pager-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'portfolio_pagination_type', '==', 'pager' ),
					'attributes' => array(
						'data-depend-id' => 'portfolio-options-pager-style'
					),
				),
				array(
					'id'         => 'portfolio_pager_fullwidth',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Enable full width', 'polo' ),
					'dependency' => array(
						'portfolio_pagination_type|portfolio-options-pager-style',
						'==|!=',
						'pager|modern'
					)
				),
			)
		)

	), // end: fields
);

// -----------------------------
// begin. sidebar options        -
// -----------------------------
$options[] = array(
	'name'     => 'sidebar_options',
	'title'    => esc_html__( 'Sidebar options', 'polo' ),
	'icon'     => 'fa fa-columns',
	'sections' => array(

		array(
			'name'   => 'single-layout',
			'title'  => esc_html__( 'Single post layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Single post layout', 'polo' )

				),
				array(
					'id'         => 'single-main-sidebar',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Sidebar position', 'polo' ),
					'desc'       => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options'    => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default'    => '2c-l-fixed',
					'attributes' => array(
						'data-depend-id' => 'sidebar_position'
					),
					'radio'      => true,
				),
				array(
					'id'         => 'single-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Select width of main sidebar', 'polo' ),
					'options'    => array(
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array( 'sidebar_position', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
				),
				array(
					'id'         => 'single-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'sidebar_position', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
				),
			),
		),
		array(
			'name'   => 'page-layout',
			'title'  => esc_html__( 'Page layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Page layout', 'polo' )

				),
				array(
					'id'      => 'page-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				array(
					'id'         => 'page-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Set width of sidebar on single post', 'polo' ),
					'options'    => array(
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array( 'page-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				array(
					'id'         => 'page-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'page-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				//end: Page sidebar options
			),
		),
		array(
			'name'   => 'portfolio-layout',
			'title'  => esc_html__( 'Portfolio layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Portfolio layout', 'polo' )

				),
				array(
					'id'      => 'portfolio-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				array(
					'id'         => 'portfolio-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Set width of sidebar on single post', 'polo' ),
					'options'    => array(
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array( 'portfolio-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				array(
					'id'         => 'portfolio-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'portfolio-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				//end: Page sidebar options
			),
		),
		array(
			'name'   => 'search-layout',
			'title'  => esc_html__( 'Search page layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Search page layout', 'polo' )

				),
				array(
					'id'      => 'search-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				array(
					'id'         => 'search-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Select width of main sidebar', 'polo' ),
					'options'    => array(
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array( 'search-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				array(
					'id'         => 'search-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'search-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				//end: Page sidebar options
			),
		),
		array(
			'name'   => 'archive-layout',
			'title'  => esc_html__( 'Archive layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Archive layout', 'polo' )

				),
				array(
					'id'      => 'archive-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				array(
					'id'         => 'archive-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Select width of main sidebar', 'polo' ),
					'options'    => array(
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array( 'archive-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				array(
					'id'         => 'archive-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array( 'archive-main-sidebar_1col-fixed', '!=', 'true' ),
				),
				//end: Page sidebar options
			),
		),
		array(
			'name'   => 'shop-layout',
			'title'  => esc_html__( 'Woocommerce shop layout', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(

				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Woocommerce shop layout', 'polo' )

				),
				array(
					'id'      => 'shop-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				array(
					'id'         => 'shop_fullwidth',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Enable shop full width', 'polo' ),
					'default'    => false,
					'dependency' => array( 'shop-main-sidebar_1col-fixed', '==', 'true' ),
				),
				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Single product layout', 'polo' )

				),
				array(
					'id'      => 'single-product-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default' => '1col-fixed',
					'radio'   => true,
				),
				//end: Page sidebar options
			),
		),
	)
);
//Product Page
$options[] = array(
	'name'   => 'woo_pages_options',
	'title'  => esc_html__( 'Woocommerce options', 'polo' ),
	'icon'   => 'fa fa-dollar',
	// begin: fields
	'fields' => array(
		array(
			'id'    => 'woo_shop_title',
			'type'  => 'text',
			'multilang' => true,
			'title' => esc_html__( 'Title for shop page', 'polo' ),
		),
		array(
			'id'    => 'woo_shop_description',
			'type'  => 'textarea',
			'title' => esc_html__( 'Description for shop page', 'polo' ),
		),
		array(
			'id'      => 'woo_shop_items',
			'type'    => 'number',
			'title'   => esc_html__( 'Number of products on page', 'polo' ),
			'default' => 10
		),
		array(
			'id'    => 'woo_shortcode',
			'type'  => 'wysiwyg',
			'title' => esc_html__( 'Shortcode before footer', 'polo' ),
		),
		array(
			'id'      => 'shop_columns_number',
			'type'    => 'select',
			'title'   => esc_html__( 'Columns number', 'polo' ),
			'options' => array(
				'2' => '2 ' . esc_html__( 'columns', 'polo' ),
				'3' => '3 ' . esc_html__( 'columns', 'polo' ),
				'4' => '4 ' . esc_html__( 'columns', 'polo' ),
				'6' => '6 ' . esc_html__( 'columns', 'polo' ),
			),
			'default' => '2',
		),
	), // end: fields
);
//404 Page
$options[] = array(
	'name'   => 'page_404_options',
	'title'  => esc_html__( '404 page options', 'polo' ),
	'icon'   => 'fa fa-life-ring',
	// begin: fields
	'fields' => array(
		array(
			'id'      => 'page_404_style',
			'type'    => 'select',
			'title'   => esc_html__( 'Page style', 'polo' ),
			'options' => array(
				'default'  => esc_html__( 'Default', 'polo' ),
				'parallax' => esc_html__( 'Parallax', 'polo' ),
			),
			'default' => 'default',
		),
		array(
			'id'         => 'page_404_parallax_image',
			'type'       => 'image',
			'title'      => esc_html__( 'Parallax background', 'polo' ),
			'dependency' => array( 'page_404_style', '==', 'parallax' ),
		),
		array(
			'id'        => 'page_404_title', // another unique id
			'type'      => 'text',
			'multilang' => true,
			'title'     => esc_html__( 'Page title', 'polo' ),
			'default'   => '',
		),
		array(
			'id'        => 'page_404_description',
			'type'      => 'textarea',
			'multilang' => true,
			'title'     => esc_html__( 'Page description', 'polo' ),
		),
	), // end: fields
);
$options[] = array(
	'name'     => 'footer_options',
	'title'    => esc_html__( 'Footer options', 'polo' ),
	'icon'     => 'fa fa-level-down',
	'sections' => array(
		array(
			'name'   => 'footer-content-options',
			'title'  => esc_html__( 'Footer content ', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'footer-color-scheme',
					'title'   => esc_html__( 'Footer color scheme', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'footer-dark'    => esc_html__( 'Dark footer', 'polo' ),
						'footer-light'   => esc_html__( 'Light footer', 'polo' ),
						'footer-colored' => esc_html__( 'Colored footer', 'polo' ),
					),
					'default' => 'footer-dark',
				),
				array(
					'id'      => 'footer-content-enable',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable footer content section', 'polo' ),
					'default' => true
				),
				array(
					'id'         => 'footer-top-panel-style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer top panel style', 'polo' ),
					'options'    => array(
						'style_1' => $img_folder . 'footer-top-logo-text.png',
						'style_2' => $img_folder . 'footer-top-logo-center.png',
						'style_3' => $img_folder . 'footer-top-logo-sidebar.png',
						'style_4' => $img_folder . 'footer-top-logo-2sidebar.png',
						'style_5' => $img_folder . 'footer-top-none.png',
						'style_6' => $img_folder . 'footer-top-logo+text.png',
					),
					'default'    => 'style_1',
					'attributes' => array(
						'data-depend-id' => 'pan_style',
					),
					'radio'      => true,
					'dependency' => array( 'footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'footer-logotype-image',
					'type'       => 'image',
					'title'      => esc_html__( 'Footer logotype pictogram', 'polo' ),
					'dependency' => array( 'footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'footer-logotype-image-retina',
					'type'       => 'image',
					'title'      => esc_html__( 'Retina Ready Footer logotype pictogram', 'polo' ),
					'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
					'dependency' => array( 'footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'footer-text',
					'type'       => 'textarea',
					'multilang'  => true,
					'title'      => esc_html__( 'Footer text', 'polo' ),
					'dependency' => array( 'footer-content-enable', '==', 'true' ),
				),
				array(
					'id'      => 'hide-footer-text-separator',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Hide separator after footer text', 'polo' ),
					'default' => false
				),
				array(
					'id'         => 'footer-sidebars-layout',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer sidebars layout', 'polo' ),
					'options'    => array(
						'style_1' => $img_folder . 'sidebar-1col.png',
						'style_2' => $img_folder . 'sidebar-2col.png',
						'style_3' => $img_folder . 'sidebar-3col.png',
						'style_4' => $img_folder . 'sidebar-2s-1l.png',
						'style_5' => $img_folder . 'sidebar-1l-2s.png',
						'style_6' => $img_folder . 'sidebar-1s-1l-1s.png',
						'style_7' => $img_folder . 'sidebar-4col.png',
						'style_8' => $img_folder . 'sidebar-none.png',
					),
					'default'    => 'style_1',
					'radio'      => true,
					'dependency' => array( 'pan_style', 'any', 'style_1,style_2' ),
				),
				array(
					'id'         => 'footer-top-panel-align',
					'title'      => esc_html__( 'Panel align', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'left'  => esc_html__( 'Left', 'polo' ),
						'right' => esc_html__( 'Right', 'polo' ),
					),
					'default'    => 'left',
					'dependency' => array( 'pan_style', '==', 'style_4' ),
				),
			)

		),
		array(
			'name'   => 'footer-copyright-options',
			'title'  => esc_html__( 'Footer copyright panel', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'footer-copyright-enable',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable footer copyright section', 'polo' ),
					'default' => true
				),
				array(
					'id'        => 'copyright-text',
					'type'      => 'textarea',
					'multilang' => true,
					'title'     => esc_html__( 'Copyright text', 'polo' ),
				),
				array(
					'id'      => 'footer-soclinks-enable',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable social links', 'polo' ),
					'default' => true
				),
				array(
					'id'         => 'footer-social-link-style',
					'title'      => esc_html__( 'Social link style', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'transparent' => esc_html__( 'Transparent', 'polo' ),
						'colored'     => esc_html__( 'Colored', 'polo' ),
					),
					'dependency' => array( 'footer-soclinks-enable', '==', 'true' ),
				),
			), // end: fields
		),
	),
);
/*
 * Typography
 * */
$options[] = array(
	'name'     => 'typography_options',
	'title'    => esc_html__( 'Typography', 'polo' ),
	'icon'     => 'fa fa-font',
	'sections' => array(
		array(
			'name'   => 'typography-options',
			'title'  => esc_html__( 'Typography options', 'polo' ),
			'icon'   => 'fa  fa-angle-right',
			'fields' => array(
				array(
					'id'      => 'body-typography',
					'type'    => 'typography',
					'title'   => 'Body' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h1-typography',
					'type'    => 'typography',
					'title'   => 'H1' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h2-typography',
					'type'    => 'typography',
					'title'   => 'H2' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h3-typography',
					'type'    => 'typography',
					'title'   => 'H3' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h4-typography',
					'type'    => 'typography',
					'title'   => 'H4' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h5-typography',
					'type'    => 'typography',
					'title'   => 'H5' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'h6-typography',
					'type'    => 'typography',
					'title'   => 'H6' . esc_html__( ' Typography', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
				array(
					'id'      => 'menu-typography',
					'type'    => 'typography',
					'title'   => esc_html__( 'Menu Typography', 'polo' ),
					'desc'       => esc_html__( 'Color will be applied only for ":hover" sate of menu items', 'polo' ),
					'default' => array(
						'family' => 'Default',
					),
					'chosen'  => false,
				),
			),
		),

	)
);
$options[] = array(
	'name'   => 'advanced_options',
	'title'  => esc_html__( 'Advanced options', 'polo' ),
	'icon'   => 'fa fa-wrench',
	// begin: fields
	'fields' => array(

		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Twitter API keys', 'polo' ),
		),
		array(
			'id'      => 'tw-consumer-key', // another unique id
			'type'    => 'text',
			'title'   => esc_html__( 'Consumer key', 'polo' ),
			'default' => '',
		),
		array(
			'id'      => 'tw-consumer-secret', // another unique id
			'type'    => 'text',
			'title'   => esc_html__( 'Consumer Secret', 'polo' ),
			'default' => '',
		),
		array(
			'id'      => 'tw-access-token', // another unique id
			'type'    => 'text',
			'title'   => esc_html__( 'Access Token', 'polo' ),
			'default' => '',
		),
		array(
			'id'      => 'tw-access-token-secret', // another unique id
			'type'    => 'text',
			'title'   => esc_html__( 'Access Token Secret', 'polo' ),
			'default' => '',
		),

		array(
			'class'   => 'info',
			'type'    => 'notice',
			'content' => wp_kses( __( 'If you don\'t know, how to get api keys, please check <a target="_blank" href="http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/">Our tutorial</a>', 'polo' ), array('br' => array(),'a' => array('href' => array(), 'target' => ''),'p' => array()) ),
		),
		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Google map API key', 'polo' ),
		),
		array(
			'id'    => 'gmap_api_key',
			'type'  => 'text',
			'title' => esc_html__( 'Map api key', 'polo' ),
			'desc'  => esc_html__( 'Enter Google Map API key', 'polo' ),
		),
		array(
			'class'   => 'info',
			'type'    => 'notice',
			'content' => wp_kses( __( 'If you don\'t know, how to get api keys, please check <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Tutorial</a>', 'polo' ), array('br' => array(),'a' => array('href' => array(), 'target' => ''),'p' => array()) ),
		),
		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Custom JS Code', 'polo' )

		),
		array(
			'id'         => 'js-code',
			'type'       => 'textarea',
			'title'      => esc_html__( 'JS code field', 'polo' ),
			'desc'       => wp_kses( __( 'without &lt; script &gt; tags', 'polo' ), array(
				'br'   => array(),
				'a'    => array(),
				'p'    => array(),
				'&lt;' => array(),
				'&gt;' => array()
			) ),
			'sanitize'   => false,
			'attributes' => array(
				'placeholder' => 'jQuery( document ).ready(function() {  SOME CODE  });',
				'rows'        => 10,
			),

		),

		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Tracking Code', 'polo' )

		),

		array(
			'id'       => 'tracking-code',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Tracking Code field', 'polo' ),
			'subtitle' => esc_html__( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'polo' ),
		),

		array(
			'type'    => 'heading',
			'content' => esc_html__( 'Custom CSS Code', 'polo' )

		),

		array(
			'id'         => 'css-code',
			'type'       => 'textarea',
			'title'      => esc_html__( 'CSS code field', 'polo' ),
			'sanitize'   => false,
			'attributes' => array(
				'rows' => 10,
			),

		),
	), // end: fields

	$options[] = array(
	'name'   => 'other_backup_options',
	'title'  => esc_html__( 'Import / Export options', 'polo' ),
	'icon'   => 'fa fa-wrench',
	// begin: fields
	'fields' => array(
		array(
			'id' => 'options-backup',
			'type'  => 'backup',
			'title' => 'Import / Export',
		),
	))
);

CSFramework::instance( $settings, $options );

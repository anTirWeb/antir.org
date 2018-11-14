<?php if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

$img_folder = get_template_directory_uri() . '/library/img/admin/';

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

$theme_menus = get_terms( 'nav_menu' );
$menus_list  = array(
	'default' => esc_html__( 'Default', 'polo' ),
);
if ( isset( $theme_menus ) && ! ( $theme_menus == '' ) ) {
	foreach ( $theme_menus as $single_menu ) {
		$menus_list[ $single_menu->term_id ] = $single_menu->name;
	}
}

$page_options   = array(

	array(
		'name'   => 'meta_color_scheme',
		'title'  => esc_html__( 'Color scheme', 'polo' ),
		'icon'   => 'fa fa-asterisk',
		'fields' => array(
			array(
				'id'      => 'meta-theme-color-scheme',
				'title'   => esc_html__( 'Theme color scheme', 'polo' ),
				'type'    => 'select',
				'options' => array(
					'default'     => esc_html__( 'Default', 'polo' ),
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
				'default' => 'default',
			),
			array(
				'id'         => 'custom_scheme_color',
				'type'       => 'color_picker',
				'title'      => esc_html__( 'Custom color', 'polo' ),
				'dependency' => array( 'meta-theme-color-scheme', '==', 'custom' ),
			),
			array(
				'id'      => 'meta-boxed-body',
				'type'    => 'select',
				'title'   => esc_html__( 'Enable boxed body', 'polo' ),
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Enable', 'polo' ),
					'false'   => esc_html__( 'Disable', 'polo' ),
				),
				'default' => 'default',
			),
			array(
				'id'         => 'boxed_body_background',
				'type'       => 'background',
				'title'      => esc_html__( 'Boxed body background options', 'polo' ),
				'dependency' => array( 'meta-boxed-body', '==', 'true' )
			),
			array(
				'id'         => 'normal_body_background',
				'type'       => 'background',
				'title'      => esc_html__( 'Body background options', 'polo' ),
				'dependency' => array( 'meta-boxed-body', '==', 'false' )
			),
		)
	),
	// Meta top bar options
	array(
		'name'   => 'meta_top_bar',
		'title'  => esc_html__( 'Top bar options', 'polo' ),
		'icon'   => 'fa fa-asterisk',
		// begin: fields
		'fields' => array(
			array(
				'id'      => 'meta-top-bar-enable',
				'type'    => 'select',
				'title'   => esc_html__( 'Enable top bar', 'polo' ),
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Enable', 'polo' ),
					'false'   => esc_html__( 'Disable', 'polo' ),
				),
				'default' => 'default',
			),
			array(
				'id'         => '_meta-top-bar-color',
				'title'      => esc_html__( 'Top bar color', 'polo' ),
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'white'   => esc_html__( 'White', 'polo' ),
					'dark'    => esc_html__( 'Dark', 'polo' ),
					'custom'  => esc_html__( 'Custom', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta-top-bar-enable', '==', 'true' ),
			),
			array(
				'id'         => 'meta-top-bar-transparent',
				'type'       => 'select',
				'title'      => esc_html__( 'Enable transparency on top bar', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Enable', 'polo' ),
					'false'   => esc_html__( 'Disable', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta-top-bar-enable|_meta-top-bar-color', '==|==', 'true|white' ),
			),
			array(
				'id'         => 'meta-top-bar-color',
				'type'       => 'color_picker',
				'title'      => esc_html__( 'Custom background color for top bar', 'polo' ),
				'dependency' => array( 'meta-top-bar-enable|_meta-top-bar-color', '==|==', 'true|custom' ),
			),
			array(
				'id'         => 'meta-top-bar-custom-color',
				'type'       => 'color_picker',
				'title'      => esc_html__( 'Custom text color for top bar', 'polo' ),
				'dependency' => array( 'meta-top-bar-enable|_meta-top-bar-color', '==|==', 'true|custom' ),
			),
		), // end: fields
	), // end: a section
	// Meta header options
	array(
		'name'   => 'meta_page_header_options',
		'title'  => esc_html__( 'Header options', 'polo' ),
		'icon'   => 'fa fa-asterisk',
		// begin: fields
		'fields' => array(
			array(
				'id'         => 'header_style',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Header Style', 'polo' ),
				'options'    => array(
					'default'  => $img_folder . 'default.png',
					'standard' => $img_folder . 'header-layout-classic.png',
					'side'     => $img_folder . 'header-layout-side.png',
				),
				'default'    => 'default',
				'radio'      => true,
				'attributes' => array(
					'data-depend-id' => 'meta_header_style_select'
				),
			),
			array(
				'id'         => 'main_header_layout',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Header layout', 'polo' ),
				'options'    => array(
					'default'  => $img_folder . 'default.png',
					'classic'  => $img_folder . 'header-layout-classic.png',
					'modern'   => $img_folder . 'header-menu-modern.png',
					'centered' => $img_folder . 'header-menu-center.png',
				),
				'default'    => 'default',
				'radio'      => true,
				'dependency' => array(
					'meta_header_style_select',
					'!=',
					'side'
				),
				'attributes' => array(
					'data-depend-id' => 'meta_header_layout'
				),
			),
			array(
				'id'         => 'classic_header_style',
				'type'       => 'select',
				'title'      => esc_html__( 'Header style', 'polo' ),
				'options'    => array(
					'default'           => esc_html__( 'Default', 'polo' ),
					'transparent'       => esc_html__( 'Transparent', 'polo' ),
					'light'             => esc_html__( 'Light', 'polo' ),
					'light_transparent' => esc_html__( 'Light transparent', 'polo' ),
					'dark'              => esc_html__( 'Dark', 'polo' ),
					'dark_transparent'  => esc_html__( 'Dark transparent', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta_header_style_select|meta_header_layout', '==|==', 'standard|classic' )
			),
			array(
				'id'         => 'classic_transparent_menu',
				'type'       => 'select',
				'title'      => esc_html__( 'Menu color', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'light'   => esc_html__( 'Light', 'polo' ),
					'dark'    => esc_html__( 'Dark', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array(
					'meta_header_style_select|meta_header_layout|classic_header_style',
					'==|==|==',
					'standard|classic|transparent'
				)
			),
			array(
				'id'         => 'modern_header_style',
				'type'       => 'select',
				'title'      => esc_html__( 'Header style', 'polo' ),
				'options'    => array(
					'default'          => esc_html__( 'Default', 'polo' ),
					'simple'           => esc_html__( 'Simple', 'polo' ),
					'light'            => esc_html__( 'Light', 'polo' ),
					'dark'             => esc_html__( 'Dark', 'polo' ),
					'dark_transparent' => esc_html__( 'Dark transparent', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta_header_style_select|meta_header_layout', '==|==', 'standard|modern' )
			),
			array(
				'id'         => 'header_logo_position',
				'type'       => 'select',
				'title'      => esc_html__( 'Logo position', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'left'    => esc_html__( 'Left', 'polo' ),
					'right'   => esc_html__( 'Right', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array(
					'meta_header_style_select|meta_header_layout',
					'==|any',
					'standard|classic,modern'
				)
			),
			array(
				'id'         => 'header_full_width',
				'type'       => 'select',
				'title'      => esc_html__( 'Full width header', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'On', 'polo' ),
					'false'   => esc_html__( 'Off', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array(
					'meta_header_style_select|meta_header_layout',
					'==|any',
					'standard|classic,modern'
				)
			),
			array(
				'id'         => 'header_mini',
				'type'       => 'select',
				'title'      => esc_html__( 'Mini header', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'On', 'polo' ),
					'false'   => esc_html__( 'Off', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array(
					'meta_header_style_select|meta_header_layout',
					'==|any',
					'standard|classic,modern'
				)
			),
			array(
				'id'         => 'header_sticky',
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'On', 'polo' ),
					'false'   => esc_html__( 'Off', 'polo' ),
				),
				'title'      => esc_html__( 'Sticky header', 'polo' ),
				'dependency' => array( 'meta_header_style_select|meta_header_layout', '==|!=', 'standard|default' ),
				'default'    => 'default',
			),
			array(
				'id'      => 'header_logo_hide',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Hide logo on page', 'polo' ),
				'default' => false,
			),
			array(
				'id'         => 'meta-logotype-image',
				'type'       => 'image',
				'title'      => esc_html__( 'Logotype pictogram', 'polo' ),
				'dependency' => array( 'header_logo_hide', '!=', 'true' )
			),
			array(
				'id'         => 'meta-logotype-image-retina',
				'type'       => 'image',
				'title'      => esc_html__( 'Retina Ready Logotype pictogram', 'polo' ),
				'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
				'dependency' => array( 'header_logo_hide', '!=', 'true' )
			),
			array(
				'id'         => 'meta-header-search',
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Hide', 'polo' ),
					'false'   => esc_html__( 'Show', 'polo' ),
				),
				'default'    => 'default',
				'title'      => esc_html__( 'Search', 'polo' ),
				'desc'       => esc_html__( 'Hide search panel in header', 'polo' ),
				'dependency' => array( 'meta_header_style_select', '==', 'standard' )
			),
			array(
				'id'         => 'meta-header-cart',
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Hide', 'polo' ),
					'false'   => esc_html__( 'Show', 'polo' ),
				),
				'default'    => 'default',
				'title'      => esc_html__( 'Cart', 'polo' ),
				'desc'       => esc_html__( 'Hide cart in header', 'polo' ),
				'dependency' => array( 'meta_header_style_select', '==', 'standard' )
			),
			array(
				'id'         => 'meta-header-side-menu',
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Show', 'polo' ),
					'false'   => esc_html__( 'Hide', 'polo' ),
				),
				'default'    => 'default',
				'title'      => esc_html__( 'Menu button', 'polo' ),
				'desc'       => esc_html__( 'Show menu button', 'polo' ),
				'dependency' => array( 'meta_header_style_select', '==', 'standard' )
			),
			array(
				'id'         => 'custom_menu_style',
				'type'       => 'select',
				'title'      => esc_html__( 'Menu style', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'left'    => esc_html__( 'Panel on left', 'polo' ),
					'hidden'  => esc_html__( 'Hidden menu', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta_header_style_select|meta-header-side-menu', '==|==', 'standard|true' )
			),
			array(
				'id'         => 'header_logo_replace',
				'type'       => 'switcher',
				'title'      => esc_html__( 'Replace logo with text', 'polo' ),
				'default'    => false,
				'dependency' => array( 'meta_header_style_select|', '==', 'side' ),
			),
			array(
				'id'         => 'header_logo_text',
				'type'       => 'wysiwyg',
				'title'      => esc_html__( 'Logotype text', 'polo' ),
				'dependency' => array( 'meta_header_style_select|header_logo_replace', '==|==', 'side|true' ),
			),
			array(
				'id'         => 'side_header_hide_menu',
				'type'       => 'select',
				'title'      => esc_html__( 'Hide menu', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Hide', 'polo' ),
					'false'   => esc_html__( 'Show', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta_header_style_select', '==', 'side' ),
			),
			array(
				'id'         => 'header_side_description',
				'type'       => 'wysiwyg',
				'title'      => esc_html__( 'Description text', 'polo' ),
				'dependency' => array( 'meta_header_style_select', '==', 'side' ),
				'settings'   => array( 'wpautop' => false )
			),
			array(
				'id'         => 'header_soc_icons_style',
				'type'       => 'select',
				'title'      => esc_html__( 'Soc icons style', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'dark'    => esc_html__( 'Dark', 'polo' ),
					'colored' => esc_html__( 'Colored', 'polo' ),
				),
				'default'    => 'dark',
				'dependency' => array( 'meta_header_style_select', '==', 'side' )
			),
		), // end: fields
	), // end: a section
	// Meta sunning header
	array(
		'name'   => 'meta_stunning_header_options',
		'title'  => esc_html__( 'Stunning header options', 'polo' ),
		'icon'   => 'fa fa-bookmark',
		'fields' => array(
			array(
				'id'      => 'meta-stunning-header-show',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Show', 'polo' ),
					'false'   => esc_html__( 'Hide', 'polo' ),
				),
				'default' => 'default',
				'title'   => esc_html__( 'Show stunning_header', 'polo' ),
			),
			array(
				'id'      => 'meta-show-page-title',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Show', 'polo' ),
					'false'   => esc_html__( 'Hide', 'polo' ),
				),
				'default' => 'default',
				'title'   => esc_html__( 'Show Page Title', 'polo' ),
				'dependency' => array( 'meta-stunning-header-show', '==', 'false' ),
			),
			array(
				'id'         => 'meta-stunning-header-style',
				'title'      => esc_html__( 'Style', 'polo' ),
				'type'       => 'select',
				'options'    => array(
					''         => esc_html__( 'Default', 'polo' ),
					'default'  => esc_html__( 'Animated', 'polo' ),
					'parallax' => esc_html__( 'Parallax', 'polo' ),
					'video'    => esc_html__( 'Video', 'polo' ),
					'extended' => esc_html__( 'Extended', 'polo' ),
					'pattern'  => esc_html__( 'Pattern', 'polo' ),
					'colored'  => esc_html__( 'Colored', 'polo' ),
					'dark'     => esc_html__( 'Dark', 'polo' ),
					'light'    => esc_html__( 'Light', 'polo' ),
				),
				'default'    => '',
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' )
			),
			array(
				'id'         => 'meta-stunning-header-align',
				'title'      => esc_html__( 'Title align', 'polo' ),
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'left'    => esc_html__( 'Left', 'polo' ),
					'right'   => esc_html__( 'Right', 'polo' ),
					'center'  => esc_html__( 'Center', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' )
			),
			array(
				'id'         => 'meta_st_header_subtitle', // this is must be unique
				'type'       => 'text',
				'title'      => esc_html__( 'Stunning header subtitle', 'polo' ),
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' )
			),
			array(
				'id'      => 'meta-stunning-show-breadcrumbs',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Show', 'polo' ),
					'false'   => esc_html__( 'Hide', 'polo' ),
				),
				'default' => 'default',
				'title'   => esc_html__( 'Show Breadcrumbs', 'polo' ),
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' ),
			),
			array(
				'id'         => 'meta-stunning-header-animation',
				'title'      => esc_html__( 'Stunning header animation', 'polo' ),
				'type'       => 'select',
				'options'    => array_merge( array( '' => esc_html__( 'Default', 'polo' ) ), $animation_classes ),
				'default'    => '',
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|any',
					'false|default'
				),
			),
			array(
				'id'         => 'meta-st-header-bg-image',
				'type'       => 'image',
				'title'      => esc_html__( 'Background image', 'polo' ),
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|any',
					'false|default,parallax,extended,pattern'
				),
			),
//			array(
//				'id'         => 'meta-st-header-text-color',
//				'type'       => 'color_picker',
//				'title'      => esc_html__( 'Custom text color ', 'polo' ),
//				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' ),
//
//			),
			array(
				'id'         => 'meta-color-text-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'Stunning header typography', 'polo' ),
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' )
			),
			array(
				'id'         => 'meta-st-header-height',
				'type'       => 'number',
				'title'      => esc_html__( 'Custom height', 'polo' ),
				'dependency' => array( 'meta-stunning-header-show', '!=', 'false' )
			),
			array(
				'id'         => 'meta-st-header-embed-video-bg', // this is must be unique
				'type'       => 'text',
				'title'      => esc_html__( 'Embed video', 'polo' ),
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|==',
					'false|video'
				),
			),
			array(
				'id'         => 'meta-st-header-bg-video-mp4',
				'type'       => 'upload',
				'title'      => 'Mp4 ' . esc_html__( 'video', 'polo' ),
				'settings'   => array(
					'upload_type'  => 'video',
					'button_title' => 'Video',
					'frame_title'  => esc_html__( 'Select a video', 'polo' ),
					'insert_title' => esc_html__( 'Use this video', 'polo' ),
				),
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|==',
					'false|video'
				),
			),
			array(
				'id'         => 'meta-st-header-bg-video-webm',
				'type'       => 'upload',
				'title'      => 'Webm ' . esc_html__( 'video', 'polo' ),
				'settings'   => array(
					'upload_type'  => 'video',
					'button_title' => 'Video',
					'frame_title'  => esc_html__( 'Select a video', 'polo' ),
					'insert_title' => esc_html__( 'Use this video', 'polo' ),
				),
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|==',
					'false|video'
				),
			),
			array(
				'id'         => 'meta-st-header-bg-video-ogg',
				'type'       => 'upload',
				'title'      => 'Ogg ' . esc_html__( 'video', 'polo' ),
				'settings'   => array(
					'upload_type'  => 'video',
					'button_title' => 'Video',
					'frame_title'  => esc_html__( 'Select a video', 'polo' ),
					'insert_title' => esc_html__( 'Use this video', 'polo' ),
				),
				'dependency' => array(
					'meta-stunning-header-show|meta-stunning-header-style',
					'!=|==',
					'false|video'
				),
			),
		)
	),
	// Meta footer
	array(
		'name'   => 'meta_footer_options',
		'icon'   => 'fa fa-th-large',
		'title'  => esc_html__( 'Footer options', 'polo' ),
		// begin: fields
		'fields' => array(
			array(
				'id'      => 'meta-footer-color-scheme',
				'title'   => esc_html__( 'Footer color scheme', 'polo' ),
				'type'    => 'select',
				'options' => array(
					'default'        => esc_html__( 'Default', 'polo' ),
					'footer-dark'    => esc_html__( 'Dark footer', 'polo' ),
					'footer-light'   => esc_html__( 'Light footer', 'polo' ),
					'footer-colored' => esc_html__( 'Colored footer', 'polo' ),
				),
				'default' => 'default',
			),
			array(
				'id'      => 'meta-footer-content-enable',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Enable', 'polo' ),
					'false'   => esc_html__( 'Disable', 'polo' ),
				),
				'title'   => esc_html__( 'Enable footer content section', 'polo' ),
				'default' => 'default'
			),
			array(
				'id'         => 'meta-footer-top-panel-style',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Footer top panel style', 'polo' ),
				'options'    => array(
					'default' => $img_folder . 'default.png',
					'style_1' => $img_folder . 'footer-top-logo-text.png',
					'style_2' => $img_folder . 'footer-top-logo-center.png',
					'style_3' => $img_folder . 'footer-top-logo-sidebar.png',
					'style_4' => $img_folder . 'footer-top-logo-2sidebar.png',
					'style_5' => $img_folder . 'footer-top-none.png',
					'style_6' => $img_folder . 'footer-top-logo+text.png',
				),
				'default'    => 'default',
				'attributes' => array(
					'data-depend-id' => 'meta_pan_style',
				),
				'radio'      => true,
				'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
			),
			array(
				'id'         => 'meta-footer-logotype-image',
				'type'       => 'image',
				'title'      => esc_html__( 'Footer logotype pictogram', 'polo' ),
				'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
			),
			array(
				'id'         => 'meta-footer-logotype-image-retina',
				'type'       => 'image',
				'title'      => esc_html__( 'Retina Ready Footer logotype pictogram', 'polo' ),
				'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
				'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
			),
			array(
				'id'         => 'hide_footer_text',
				'type'       => 'switcher',
				'title'      => esc_html__( 'Hide footer text', 'polo' ),
				'default'    => false,
				'dependency' => array( 'meta-footer-content-enable|meta_pan_style', '==|!=', 'true|style_6' )
			),
			array(
				'id'         => 'meta-footer-text',
				'type'       => 'textarea',
				'multilang'  => true,
				'title'      => esc_html__( 'Footer text', 'polo' ),
				'dependency' => array(
					'meta_pan_style|hide_footer_text|meta-footer-content-enable',
					'!=|!=|==',
					'style_6|true|true'
				),
			),
			array(
				'id'         => 'hide-footer-text-separator',
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'true'    => esc_html__( 'Hide', 'polo' ),
					'false'   => esc_html__( 'Show', 'polo' ),
				),
				'title'      => esc_html__( 'Hide separator after footer text', 'polo' ),
				'default'    => 'default',
				'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
			),
			array(
				'id'         => 'meta-footer-sidebars-layout',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Footer sidebars layout', 'polo' ),
				'options'    => array(
					'default' => $img_folder . 'default.png',
					'style_1' => $img_folder . 'sidebar-1col.png',
					'style_2' => $img_folder . 'sidebar-2col.png',
					'style_3' => $img_folder . 'sidebar-3col.png',
					'style_4' => $img_folder . 'sidebar-2s-1l.png',
					'style_5' => $img_folder . 'sidebar-1l-2s.png',
					'style_6' => $img_folder . 'sidebar-1s-1l-1s.png',
					'style_7' => $img_folder . 'sidebar-4col.png',
					'style_8' => $img_folder . 'sidebar-none.png',
				),
				'default'    => 'default',
				'radio'      => true,
				'dependency' => array(
					'meta-footer-content-enable|meta_pan_style',
					'==|any',
					'true|style_1,style_2'
				),
			),
			array(
				'id'         => 'meta-footer-top-panel-align',
				'title'      => esc_html__( 'Panel align', 'polo' ),
				'type'       => 'select',
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'left'    => esc_html__( 'Left', 'polo' ),
					'right'   => esc_html__( 'Right', 'polo' ),
				),
				'default'    => 'default',
				'dependency' => array( 'meta_pan_style', '==', 'style_4' ),
			),
		), // end: fields
	), // end: a section

);
$layout_options = array(
	// Meta page layout
	array(
		'name'   => 'meta_page_layout_settings',
		'icon'   => 'fa fa-cog',
		'title'  => esc_html__( 'Page layout', 'polo' ),
		// begin: fields
		'fields' => array(
			array(
				'id'         => 'meta-page-main-sidebar',
				'type'       => 'image_select',
				'title'      => esc_html__( 'Sidebar position', 'polo' ),
				'desc'       => esc_html__( 'Please select sidebar layout', 'polo' ),
				'options'    => array(
					'default'    => $img_folder . 'default.png',
					'1col-fixed' => $img_folder . 'layout-1col.png',
					'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
					'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
					'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
				),
				'attributes' => array(
					'data-depend-id' => 'meta_page_sidebar'
				),
				'default'    => 'default',
				'radio'      => true,
			),
			array(
				'id'         => 'meta-page-sidebar-width',
				'type'       => 'select',
				'title'      => esc_html__( 'Sidebar width', 'polo' ),
				'desc'       => esc_html__( 'Set width of sidebar on single post', 'polo' ),
				'options'    => array(
					'default'          => esc_html__( 'Default', 'polo' ),
					'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
					'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
					'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
					'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
				),
				'default'    => 'sidebar-3-column',
				'dependency' => array( 'meta_page_sidebar', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
			),
			array(
				'id'         => 'meta-page-sidebar-style',
				'type'       => 'select',
				'title'      => esc_html__( 'Sidebar style', 'polo' ),
				'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
				'options'    => array(
					'default' => esc_html__( 'Default', 'polo' ),
					'classic' => esc_html__( 'Classic', 'polo' ),
					'modern'  => esc_html__( 'Modern', 'polo' ),
				),
				'default'    => 'classic',
				'dependency' => array( 'meta_page_sidebar', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
			),
			array(
				'id'      => 'top_padding_disable',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Disable page top padding', 'polo' ),
				'default' => false
			),
			array(
				'id'      => 'bottom_padding_disable',
				'type'    => 'switcher',
				'title'   => esc_html__( 'Disable page bottom padding', 'polo' ),
				'default' => false
			),
		), // end: fields
	) // end: a section
);

/*
 *Page before content
 */
$options[] = array(
	'id'        => 'before_content_shortcode_section',
	'title'     => esc_html__( 'Before content shortcode', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'large_shortcode',
			'fields' => array(
				array(
					'id'        => 'before_content_shortcode',
					'type'      => 'wysiwyg',
					'multilang' => true,
					'title'     => esc_html__( 'Before content shortcode', 'polo' ),
				),
				array(
					'id'    => 'before_content_shortcode_bg',
					'type'  => 'background',
					'title' => esc_html__( 'Before content shortcode section background', 'polo' ),
				),
				array(
					'id'      => 'content_shortcode_top_padding',
					'type'    => 'select',
					'title'   => esc_html__( 'Before content shortcode padding top', 'polo' ),
					'options' => array(
						''        => esc_html__( 'None', 'polo' ),
						'p-t-0'   => '0px',
						'p-t-5'   => '5px',
						'p-t-10'  => '10px',
						'p-t-15'  => '15px',
						'p-t-20'  => '20px',
						'p-t-25'  => '25px',
						'p-t-30'  => '30px',
						'p-t-35'  => '35px',
						'p-t-40'  => '40px',
						'p-t-50'  => '50px',
						'p-t-60'  => '60px',
						'p-t-70'  => '70px',
						'p-t-80'  => '80px',
						'p-t-90'  => '90px',
						'p-t-100' => '100px',
						'p-t-150' => '150px',
						'p-t-200' => '200px',
					),
					'default' => '',
				),
				array(
					'id'      => 'content_shortcode_bottom_padding',
					'type'    => 'select',
					'title'   => esc_html__( 'Before content shortcode padding bottom', 'polo' ),
					'options' => array(
						''        => esc_html__( 'None', 'polo' ),
						'p-b-0'   => '0px',
						'p-b-5'   => '5px',
						'p-b-10'  => '10px',
						'p-b-15'  => '15px',
						'p-b-20'  => '20px',
						'p-b-25'  => '25px',
						'p-b-30'  => '30px',
						'p-b-35'  => '35px',
						'p-b-40'  => '40px',
						'p-b-50'  => '50px',
						'p-b-60'  => '60px',
						'p-b-70'  => '70px',
						'p-b-80'  => '80px',
						'p-b-90'  => '90px',
						'p-b-100' => '100px',
						'p-b-150' => '150px',
						'p-b-200' => '200px',
					),
					'default' => '',
				),
			), // End: fields.
		), // End: a section.
	)
);
$options[] = array(
	'id'        => 'meta_page_options',
	'title'     => esc_html__( 'Page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array_merge( $page_options, $layout_options ),
);

/*
 *News page template options
 */
$options[] = array(
	'id'        => 'meta_news_page_options',
	'title'     => esc_html__( 'News page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'news_page_settings',
			'fields' => array(
				array(
					'id'         => 'blog_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Blog style', 'polo' ),
					'options'    => array(
						'default'   => $img_folder . 'default.png',
						'classic'   => $img_folder . 'blog-classic.png',
						'modern'    => $img_folder . 'blog-modern.png',
						'masonry'   => $img_folder . 'blog-masonry.png',
						'timeline'  => $img_folder . 'blog-timeline.png',
						'thumbnail' => $img_folder . 'blog-thumb.png',
					),
					'default'    => 'default',
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
						'default' => esc_attr__( 'Default', 'polo' ),
						'1'       => '1 ' . esc_html__( 'column', 'polo' ),
						'2'       => '2 ' . esc_html__( 'columns', 'polo' ),
						'3'       => '3 ' . esc_html__( 'columns', 'polo' ),
						'4'       => '4 ' . esc_html__( 'columns', 'polo' ),
						'5'       => '5 ' . esc_html__( 'columns', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'options-blog-style', '==', 'classic' )
				),
				array(
					'id'         => 'thumbnail_blog_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Thumbnail blog style', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
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
						'default' => esc_attr__( 'Default', 'polo' ),
						'2'       => '2 ' . esc_html__( 'columns', 'polo' ),
						'3'       => '3 ' . esc_html__( 'columns', 'polo' ),
						'4'       => '4 ' . esc_html__( 'columns', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'options-blog-style', 'any', 'masonry,modern' )
				),
				array(
					'id'         => 'masonry_fullwidth',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_attr__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'      => esc_html__( 'Masonry blog full width', 'polo' ),
					'dependency' => array( 'options-blog-style', '==', 'masonry' )
				),
				array(
					'id'              => 'blog_custom_categories',
					'type'            => 'group',
					'title'           => esc_html__( 'Custom categories to display', 'polo' ),
					'button_title'    => 'Add New',
					'accordion_title' => 'Add New Field',
					'fields'          => array(
						array(
							'id'      => 'cat_id',
							'type'    => 'select',
							'title'   => esc_html__( 'Category', 'polo' ),
							'options' => polo_post_categories()
						),
					),
				),
				array(
					'id'    => 'blog_custom_categories_exclude',
					'type'  => 'switcher',
					'title' => esc_html__( 'Exclude categories', 'polo' ),
				),
				array(
					'id'    => 'posts_number',
					'type'  => 'number',
					'title' => esc_html__( 'Number of posts to display', 'polo' ),
				),
				array(
					'id'    => 'excerpt_length',
					'type'  => 'number',
					'title' => esc_html__( 'Excerpt length', 'polo' ),
				),
				array(
					'id'         => 'pagination_type',
					'type'       => 'select',
					'title'      => esc_html__( 'Pagination type', 'polo' ),
					'options'    => array(
						'default'    => esc_attr__( 'Default', 'polo' ),
						'pagination' => esc_html__( 'Pagination', 'polo' ),
						'pager'      => esc_html__( 'Pager', 'polo' ),
						'load_more'  => esc_html__( 'Load more button', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'options-blog-style', '!=', 'timeline' )
				),
				array(
					'id'         => 'pagination_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pagination style', 'polo' ),
					'options'    => array(
						''        => $img_folder . 'default.png',
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
						''        => $img_folder . 'default.png',
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
					'type'       => 'select',
					'options'    => array(
						'default' => esc_attr__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'      => esc_html__( 'Enable full width', 'polo' ),
					'dependency' => array(
						'options-blog-style|pagination_type|options-pager-style',
						'!=|==|!=',
						'timeline|pager|modern'
					)
				),
			), // End: fields.
		), // End: a section.
	)
);
/*
 *Portfolio page template options
 */
$options[] = array(
	'id'        => 'meta_portfolio_page_options',
	'title'     => esc_html__( 'Portfolio page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'main',
			'title'  => esc_html__( 'Main options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'meta_portfolio_blog_style',
					'type'    => 'select',
					'title'   => esc_html__( 'Portfolio blog style', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'classic' => esc_html__( 'Classic', 'polo' ),
						'masonry' => esc_html__( 'Masonry', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'meta_portfolio_columns_number',
					'type'    => 'select',
					'title'   => esc_html__( 'Columns number', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'1'       => '1 ' . esc_html__( 'column', 'polo' ),
						'2'       => '2 ' . esc_html__( 'columns', 'polo' ),
						'3'       => '3 ' . esc_html__( 'columns', 'polo' ),
						'4'       => '4 ' . esc_html__( 'columns', 'polo' ),
						'5'       => '5 ' . esc_html__( 'columns', 'polo' ),
						'6'       => '6 ' . esc_html__( 'columns', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'    => 'meta_items_per_page',
					'type'  => 'number',
					'title' => esc_html__( 'Items per page', 'polo' ),
				),
				array(
					'id'              => 'custom_categories',
					'type'            => 'group',
					'title'           => esc_html__( 'Custom categories to display', 'polo' ),
					'button_title'    => 'Add New',
					'accordion_title' => 'Add New Field',
					'fields'          => array(
						array(
							'id'      => 'cat_id',
							'type'    => 'select',
							'title'   => esc_html__( 'Category', 'polo' ),
							'options' => polo_portfolio_categories()
						),
					),
				),
				array(
					'id'    => 'custom_categories_exclude',
					'type'  => 'switcher',
					'title' => esc_html__( 'Exclude categories', 'polo' ),
				),
				array(
					'id'         => 'meta-folio-order',
					'type'       => 'select',
					'title'      => esc_html__( 'Sort order', 'polo' ),
					'options'    => array(
						'default' => esc_html__('Default','polo'),
						'ASC' => esc_html__( 'Ascending', 'polo' ),
						'DESC' => esc_html__( 'Descending', 'polo' ),
					),
					'default'    => 'DESC',
				),
				array(
					'id'         => 'meta-folio-sort',
					'type'       => 'select',
					'title'      => esc_html__( 'Order by', 'polo' ),
					'options'    => array(
						'date' => esc_html__('Date','polo'),
						'ID' => esc_html__( 'Order by post id', 'polo' ),
						'title' => esc_html__( 'Order by title', 'polo' ),
						'name' => esc_html__( 'Order by slug', 'polo' ),
						'modified' => esc_html__( 'Last modified date', 'polo' ),
						'menu_order' => esc_html__( 'by Page Order', 'polo' ),
					),
					'default'    => 'date',
				),

				array(
					'id'      => 'meta_enable_fullwidth',
					'type'    => 'select',
					'title'   => esc_html__( 'Enable full width', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'default' => 'default',
				),
			), // end: fields
		), // end: a section
		// Meta header options
		array(
			'name'   => 'styling_options',
			'title'  => esc_html__( 'Styling options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'pagination_type',
					'type'    => 'select',
					'title'   => esc_html__( 'Pagination type', 'polo' ),
					'options' => array(
						'default'    => esc_attr__( 'Default', 'polo' ),
						'pagination' => esc_html__( 'Pagination', 'polo' ),
						'pager'      => esc_html__( 'Pager', 'polo' ),
						'load_more'  => esc_html__( 'Load more button', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'         => 'pagination_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pagination style', 'polo' ),
					'options'    => array(
						''        => $img_folder . 'default.png',
						'default' => $img_folder . 'pagination-classic.png',
						'rounded' => $img_folder . 'pagination-rounded.png',
						'simple'  => $img_folder . 'pagination-simple.png',
						'fancy'   => $img_folder . 'pagination-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'pagination_type', '==', 'pagination' )
				),
				array(
					'id'         => 'pager_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pager style', 'polo' ),
					'options'    => array(
						''        => $img_folder . 'default.png',
						'default' => $img_folder . 'pager-classic.png',
						'modern'  => $img_folder . 'pager-modern.png',
						'fancy'   => $img_folder . 'pager-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'pagination_type', '==', 'pager' ),
					'attributes' => array(
						'data-depend-id' => 'options-pager-style'
					),
				),
				array(
					'id'         => 'pager_fullwidth',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_attr__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'      => esc_html__( 'Enable full width', 'polo' ),
					'dependency' => array(
						'pagination_type|options-pager-style',
						'==|!=',
						'pager|modern'
					)
				),
				array(
					'id'         => 'meta_portfolio_hover_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Hover style', 'polo' ),
					'options'    => array(
						'none'    => $img_folder . 'default.png',
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
					'default'    => 'none',
					'radio'      => true,
				),
				array(
					'id'         => 'meta_show_title',
					'type'       => 'select',
					'title'      => esc_html__( 'Show title', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Show', 'polo' ),
						'false'   => esc_html__( 'Hide', 'polo' ),
					),
					'dependency' => array( 'folio_hover', 'any', 'none,default' ),
					'default'    => 'default',
				),
				array(
					'id'      => 'meta_disable_spaces',
					'type'    => 'select',
					'title'   => esc_html__( 'Disable spaces between items', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'On', 'polo' ),
						'false'   => esc_html__( 'Off', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'meta_enable_gray_bg',
					'type'    => 'select',
					'title'   => esc_html__( 'Enable grey background', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'         => 'meta_show_excerpt',
					'type'       => 'select',
					'title'      => esc_html__( 'Show excerpt', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Show', 'polo' ),
						'false'   => esc_html__( 'Hide', 'polo' ),
					),
					'default'    => 'default',
				),
				array(
					'id'         => 'meta_excerpt_length',
					'type'       => 'number',
					'title'      => esc_html__( 'Excerpt length', 'polo' ),
					'dependency' => array( 'folio_hover|meta_show_excerpt', 'any|!=', 'none,default' | 'false' ),
					'default' => 5
				),
			), // end: fields
		), // end: a section
	)
);
/*
 *Portfolio page with side panel template options
 */
$options[] = array(
	'id'        => 'meta_portfolio_page_panel_options',
	'title'     => esc_html__( 'Portfolio page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'meta_page_header_options_1',
			'title'  => esc_html__( 'Header options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'    => 'meta-logotype-image',
					'type'  => 'image',
					'title' => esc_html__( 'Logotype pictogram', 'polo' ),
				),
				array(
					'id'    => 'meta-logotype-image-retina',
					'type'  => 'image',
					'title' => esc_html__( 'Retina Ready Logotype pictogram', 'polo' ),
					'desc'  => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
				),
				array(
					'id'      => 'header_logo_replace',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Replace logo with text', 'polo' ),
					'default' => false,
				),
				array(
					'id'    => 'portfolio_side_header_logo_text',
					'type'  => 'wysiwyg',
					'title' => esc_html__( 'Logotype text', 'polo' ),
				),
				array(
					'id'      => 'side_header_hide_menu',
					'type'    => 'select',
					'title'   => esc_html__( 'Hide menu', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Hide', 'polo' ),
						'false'   => esc_html__( 'Show', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'       => 'portfolio_side_header_side_description',
					'type'     => 'wysiwyg',
					'title'    => esc_html__( 'Description text', 'polo' ),
					'settings' => array( 'wpautop' => false )
				),
				array(
					'id'      => 'header_soc_icons_style',
					'type'    => 'select',
					'title'   => esc_html__( 'Soc icons style', 'polo' ),
					'options' => array(
						'dark'    => esc_html__( 'Dark', 'polo' ),
						'colored' => esc_html__( 'Colored', 'polo' ),
					),
					'default' => 'dark',
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'main_options',
			'title'  => esc_html__( 'Main options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'meta_portfolio_columns_number',
					'type'    => 'select',
					'title'   => esc_html__( 'Columns number', 'polo' ),
					'options' => array(
						'2'       => '2 ' . esc_html__( 'columns', 'polo' ),
						'3'       => '3 ' . esc_html__( 'columns', 'polo' ),
						'4'       => '4 ' . esc_html__( 'columns', 'polo' ),
						'5'       => '5 ' . esc_html__( 'columns', 'polo' ),
						'6'       => '6 ' . esc_html__( 'columns', 'polo' ),
					),
					'default' => '2',
				),
				array(
					'id'    => 'meta_items_per_page',
					'type'  => 'number',
					'title' => esc_html__( 'Items per page', 'polo' ),
				),
				array(
					'id'              => 'custom_categories',
					'type'            => 'group',
					'title'           => esc_html__( 'Custom categories to display', 'polo' ),
					'button_title'    => 'Add New',
					'accordion_title' => 'Add New Field',
					'fields'          => array(
						array(
							'id'      => 'cat_id',
							'type'    => 'select',
							'title'   => esc_html__( 'Category', 'polo' ),
							'options' => polo_portfolio_categories()
						),
					),
				),
				array(
					'id'    => 'custom_categories_exclude',
					'type'  => 'switcher',
					'title' => esc_html__( 'Exclude categories', 'polo' ),
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'styling_options_1',
			'title'  => esc_html__( 'Styling options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'pagination_type',
					'type'    => 'select',
					'title'   => esc_html__( 'Pagination type', 'polo' ),
					'options' => array(
						'default'    => esc_attr__( 'Default', 'polo' ),
						'pagination' => esc_html__( 'Pagination', 'polo' ),
						'pager'      => esc_html__( 'Pager', 'polo' ),
						'load_more'  => esc_html__( 'Load more button', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'         => 'pagination_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pagination style', 'polo' ),
					'options'    => array(
						''        => $img_folder . 'default.png',
						'default' => $img_folder . 'pagination-classic.png',
						'rounded' => $img_folder . 'pagination-rounded.png',
						'simple'  => $img_folder . 'pagination-simple.png',
						'fancy'   => $img_folder . 'pagination-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'pagination_type', '==', 'pagination' )
				),
				array(
					'id'         => 'pager_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Pager style', 'polo' ),
					'options'    => array(
						''        => $img_folder . 'default.png',
						'default' => $img_folder . 'pager-classic.png',
						'modern'  => $img_folder . 'pager-modern.png',
						'fancy'   => $img_folder . 'pager-fancy.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array( 'pagination_type', '==', 'pager' ),
					'attributes' => array(
						'data-depend-id' => 'options-pager-style'
					),
				),
				array(
					'id'         => 'pager_fullwidth',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_attr__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'      => esc_html__( 'Enable full width', 'polo' ),
					'dependency' => array(
						'pagination_type|options-pager-style',
						'==|!=',
						'pager|modern'
					)
				),
				array(
					'id'         => 'meta_portfolio_hover_style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Hover style', 'polo' ),
					'options'    => array(
						'none'    => $img_folder . 'default.png',
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
					'default'    => 'none',
					'radio'      => true,
				),
				array(
					'id'      => 'meta_disable_spaces',
					'type'    => 'select',
					'title'   => esc_html__( 'Disable spaces between items', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'On', 'polo' ),
						'false'   => esc_html__( 'Off', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'         => 'meta_show_excerpt',
					'type'       => 'select',
					'title'      => esc_html__( 'Show excerpt', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Show', 'polo' ),
						'false'   => esc_html__( 'Hide', 'polo' ),
					),
					'default'    => 'default',
				),
				array(
					'id'         => 'meta_excerpt_length',
					'type'       => 'number',
					'title'      => esc_html__( 'Excerpt length', 'polo' ),
					'dependency' => array( 'folio_hover|meta_show_excerpt', 'any|!=', 'none,default' | 'false' ),
					'default' => 5
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'meta_footer_options_folio_side',
			'icon'   => 'fa fa-th-large',
			'title'  => esc_html__( 'Footer options', 'polo' ),
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'meta-footer-color-scheme',
					'title'   => esc_html__( 'Footer color scheme', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'default'        => esc_html__( 'Default', 'polo' ),
						'footer-dark'    => esc_html__( 'Dark footer', 'polo' ),
						'footer-light'   => esc_html__( 'Light footer', 'polo' ),
						'footer-colored' => esc_html__( 'Colored footer', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'meta-footer-content-enable',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'   => esc_html__( 'Enable footer content section', 'polo' ),
					'default' => 'default'
				),
				array(
					'id'         => 'meta-footer-top-panel-style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer top panel style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'default.png',
						'style_1' => $img_folder . 'footer-top-logo-text.png',
						'style_2' => $img_folder . 'footer-top-logo-center.png',
						'style_3' => $img_folder . 'footer-top-logo-sidebar.png',
						'style_4' => $img_folder . 'footer-top-logo-2sidebar.png',
						'style_5' => $img_folder . 'footer-top-none.png',
						'style_6' => $img_folder . 'footer-top-logo+text.png',
					),
					'default'    => 'default',
					'attributes' => array(
						'data-depend-id' => 'meta_pan_style',
					),
					'radio'      => true,
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-logotype-image',
					'type'       => 'image',
					'title'      => esc_html__( 'Footer logotype pictogram', 'polo' ),
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-logotype-image-retina',
					'type'       => 'image',
					'title'      => esc_html__( 'Retina Ready Footer logotype pictogram', 'polo' ),
					'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'hide_footer_text',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Hide footer text', 'polo' ),
					'default'    => false,
					'dependency' => array( 'meta-footer-content-enable|meta_pan_style', '==|!=', 'true|style_6' )
				),
				array(
					'id'         => 'meta-footer-text',
					'type'       => 'textarea',
					'multilang'  => true,
					'title'      => esc_html__( 'Footer text', 'polo' ),
					'dependency' => array(
						'meta_pan_style|hide_footer_text|meta-footer-content-enable',
						'!=|!=|==',
						'style_6|true|true'
					),
				),
				array(
					'id'         => 'hide-footer-text-separator',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Hide', 'polo' ),
						'false'   => esc_html__( 'Show', 'polo' ),
					),
					'title'      => esc_html__( 'Hide separator after footer text', 'polo' ),
					'default'    => 'default',
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-sidebars-layout',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer sidebars layout', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'default.png',
						'style_1' => $img_folder . 'sidebar-1col.png',
						'style_2' => $img_folder . 'sidebar-2col.png',
						'style_3' => $img_folder . 'sidebar-3col.png',
						'style_4' => $img_folder . 'sidebar-2s-1l.png',
						'style_5' => $img_folder . 'sidebar-1l-2s.png',
						'style_6' => $img_folder . 'sidebar-1s-1l-1s.png',
						'style_7' => $img_folder . 'sidebar-4col.png',
						'style_8' => $img_folder . 'sidebar-none.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array(
						'meta-footer-content-enable|meta_pan_style',
						'==|any',
						'true|style_1,style_2'
					),
				),
				array(
					'id'         => 'meta-footer-top-panel-align',
					'title'      => esc_html__( 'Panel align', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'left'    => esc_html__( 'Left', 'polo' ),
						'right'   => esc_html__( 'Right', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta_pan_style', '==', 'style_4' ),
				),
			), // end: fields
		), // end: a section
	)
);
/*
 * Maintenance page template options
 */
$options[] = array(
	'id'        => 'maintenance_page_options',
	'title'     => esc_html__( 'Maintenance page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'maintenance_page_settings',
			'fields' => array(
				array(
					'id'    => 'maintenance_page_header',
					'type'  => 'switcher',
					'title' => esc_html__( 'Show maintenance header', 'polo' ),
				),
				array(
					'id'    => 'maintenance_progress_bar',
					'type'  => 'switcher',
					'title' => esc_html__( 'Show maintenance progress bar', 'polo' ),
				),
				array(
					'id'         => 'progress_bar_title', // this is must be unique
					'type'       => 'text',
					'title'      => esc_html__( 'Progress bar title', 'polo' ),
					'dependency' => array( 'maintenance_progress_bar', '==', true ),
				),
				array(
					'id'         => 'progress_bar_value',
					'type'       => 'number',
					'title'      => esc_html__( 'Progress bar value', 'polo' ),
					'dependency' => array( 'maintenance_progress_bar', '==', true ),
				),
			), // End: fields.
		), // End: a section.
	)
);/*
 * One page template options
 */
$options[] = array(
	'id'        => 'one_page_options',
	'title'     => esc_html__( 'One page template options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'one_page_main',
			'icon'   => 'fa fa-th-large',
			'title'  => esc_html__( 'Page options options', 'polo' ),
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'onepage_menu_style',
					'title'   => esc_html__( 'Menu style', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'default'  => esc_html__( 'Default', 'polo' ),
						'vertical' => esc_html__( 'Vertical', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'onepage_scroll_style',
					'title'   => esc_html__( 'Scroll style', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'fixed'   => esc_html__( 'Fixed sections background', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'onepage_scroll_buttons',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable scroll to next button', 'polo' ),
					'default' => false,
				),
				array(
					'id'         => 'onepage_scroll_button_color',
					'title'      => esc_html__( 'Scroll button color', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'light' => esc_html__( 'Light', 'polo' ),
						'dark'  => esc_html__( 'Dark', 'polo' ),
					),
					'dependency' => array( 'onepage_scroll_buttons', '==', 'true' ),
					'default'    => 'light',
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'onepage_header',
			'title'  => esc_html__( 'Header options', 'polo' ),
			'icon'   => 'fa fa-asterisk',
			// begin: fields
			'fields' => array(
				array(
					'id'         => 'main_header_layout',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Header layout', 'polo' ),
					'options'    => array(
						'default'  => $img_folder . 'default.png',
						'classic'  => $img_folder . 'header-layout-classic.png',
						'modern'   => $img_folder . 'header-menu-modern.png',
						'centered' => $img_folder . 'header-menu-center.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'attributes' => array(
						'data-depend-id' => 'meta_header_layout'
					),
				),
				array(
					'id'         => 'classic_header_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Header style', 'polo' ),
					'options'    => array(
						'default'           => esc_html__( 'Default', 'polo' ),
						'transparent'       => esc_html__( 'Transparent', 'polo' ),
						'light'             => esc_html__( 'Light', 'polo' ),
						'light_transparent' => esc_html__( 'Light transparent', 'polo' ),
						'dark'              => esc_html__( 'Dark', 'polo' ),
						'dark_transparent'  => esc_html__( 'Dark transparent', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta_header_layout', '==', 'classic' )
				),
				array(
					'id'         => 'classic_transparent_menu',
					'type'       => 'select',
					'title'      => esc_html__( 'Menu color', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'light'   => esc_html__( 'Light', 'polo' ),
						'dark'    => esc_html__( 'Dark', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array(
						'meta_header_layout|classic_header_style',
						'==|==',
						'classic|transparent'
					)
				),
				array(
					'id'         => 'modern_header_style',
					'type'       => 'select',
					'title'      => esc_html__( 'Header style', 'polo' ),
					'options'    => array(
						'default'          => esc_html__( 'Default', 'polo' ),
						'simple'           => esc_html__( 'Simple', 'polo' ),
						'light'            => esc_html__( 'Light', 'polo' ),
						'dark'             => esc_html__( 'Dark', 'polo' ),
						'dark_transparent' => esc_html__( 'Dark transparent', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta_header_layout', '==', 'modern' )
				),
				array(
					'id'         => 'header_logo_position',
					'type'       => 'select',
					'title'      => esc_html__( 'Logo position', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'left'    => esc_html__( 'Left', 'polo' ),
						'right'   => esc_html__( 'Right', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array(
						'meta_header_layout',
						'any',
						'classic,modern'
					)
				),
				array(
					'id'         => 'header_full_width',
					'type'       => 'select',
					'title'      => esc_html__( 'Full width header', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'On', 'polo' ),
						'false'   => esc_html__( 'Off', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array(
						'meta_header_layout',
						'any',
						'classic,modern'
					)
				),
				array(
					'id'         => 'header_mini',
					'type'       => 'select',
					'title'      => esc_html__( 'Mini header', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'On', 'polo' ),
						'false'   => esc_html__( 'Off', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array(
						'meta_header_layout',
						'any',
						'classic,modern'
					)
				),
				array(
					'id'         => 'header_sticky',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'On', 'polo' ),
						'false'   => esc_html__( 'Off', 'polo' ),
					),
					'title'      => esc_html__( 'Sticky header', 'polo' ),
					'dependency' => array( 'meta_header_layout', '!=', 'default' ),
					'default'    => 'default',
				),
				array(
					'id'      => 'header_logo_hide',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Hide logo on page', 'polo' ),
					'default' => false,
				),
				array(
					'id'         => 'meta-logotype-image',
					'type'       => 'image',
					'title'      => esc_html__( 'Logotype pictogram', 'polo' ),
					'dependency' => array( 'header_logo_hide', '!=', 'true' )
				),
				array(
					'id'         => 'meta-logotype-image-retina',
					'type'       => 'image',
					'title'      => esc_html__( 'Retina Ready Logotype pictogram', 'polo' ),
					'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
					'dependency' => array( 'header_logo_hide', '!=', 'true' )
				),
				array(
					'id'      => 'meta-header-search',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Hide', 'polo' ),
						'false'   => esc_html__( 'Show', 'polo' ),
					),
					'default' => 'default',
					'title'   => esc_html__( 'Search', 'polo' ),
					'desc'    => esc_html__( 'Hide search panel in header', 'polo' ),
				),
				array(
					'id'      => 'meta-header-cart',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Hide', 'polo' ),
						'false'   => esc_html__( 'Show', 'polo' ),
					),
					'default' => 'default',
					'title'   => esc_html__( 'Cart', 'polo' ),
					'desc'    => esc_html__( 'Hide cart in header', 'polo' ),
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'one_page_footer',
			'icon'   => 'fa fa-th-large',
			'title'  => esc_html__( 'Footer options', 'polo' ),
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'meta-footer-color-scheme',
					'title'   => esc_html__( 'Footer color scheme', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'default'        => esc_html__( 'Default', 'polo' ),
						'footer-dark'    => esc_html__( 'Dark footer', 'polo' ),
						'footer-light'   => esc_html__( 'Light footer', 'polo' ),
						'footer-colored' => esc_html__( 'Colored footer', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'meta-footer-content-enable',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'title'   => esc_html__( 'Enable footer content section', 'polo' ),
					'default' => 'default'
				),
				array(
					'id'         => 'meta-footer-top-panel-style',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer top panel style', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'default.png',
						'style_1' => $img_folder . 'footer-top-logo-text.png',
						'style_2' => $img_folder . 'footer-top-logo-center.png',
						'style_3' => $img_folder . 'footer-top-logo-sidebar.png',
						'style_4' => $img_folder . 'footer-top-logo-2sidebar.png',
						'style_5' => $img_folder . 'footer-top-none.png',
						'style_6' => $img_folder . 'footer-top-logo+text.png',
					),
					'default'    => 'default',
					'attributes' => array(
						'data-depend-id' => 'meta_pan_style',
					),
					'radio'      => true,
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-logotype-image',
					'type'       => 'image',
					'title'      => esc_html__( 'Footer logotype pictogram', 'polo' ),
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-logotype-image-retina',
					'type'       => 'image',
					'title'      => esc_html__( 'Retina Ready Footer logotype pictogram', 'polo' ),
					'desc'       => esc_html__( 'DOUBLED size of image for best display on Retina Screens', 'polo' ),
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'hide_footer_text',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Hide footer text', 'polo' ),
					'default'    => false,
					'dependency' => array( 'meta-footer-content-enable|meta_pan_style', '==|!=', 'true|style_6' )
				),
				array(
					'id'         => 'meta-footer-text',
					'type'       => 'textarea',
					'multilang'  => true,
					'title'      => esc_html__( 'Footer text', 'polo' ),
					'dependency' => array(
						'meta_pan_style|hide_footer_text|meta-footer-content-enable',
						'!=|!=|==',
						'style_6|true|true'
					),
				),
				array(
					'id'         => 'hide-footer-text-separator',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Hide', 'polo' ),
						'false'   => esc_html__( 'Show', 'polo' ),
					),
					'title'      => esc_html__( 'Hide separator after footer text', 'polo' ),
					'default'    => 'default',
					'dependency' => array( 'meta-footer-content-enable', '==', 'true' ),
				),
				array(
					'id'         => 'meta-footer-sidebars-layout',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Footer sidebars layout', 'polo' ),
					'options'    => array(
						'default' => $img_folder . 'default.png',
						'style_1' => $img_folder . 'sidebar-1col.png',
						'style_2' => $img_folder . 'sidebar-2col.png',
						'style_3' => $img_folder . 'sidebar-3col.png',
						'style_4' => $img_folder . 'sidebar-2s-1l.png',
						'style_5' => $img_folder . 'sidebar-1l-2s.png',
						'style_6' => $img_folder . 'sidebar-1s-1l-1s.png',
						'style_7' => $img_folder . 'sidebar-4col.png',
						'style_8' => $img_folder . 'sidebar-none.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'dependency' => array(
						'meta-footer-content-enable|meta_pan_style',
						'==|any',
						'true|style_1,style_2'
					),
				),
				array(
					'id'         => 'meta-footer-top-panel-align',
					'title'      => esc_html__( 'Panel align', 'polo' ),
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'left'    => esc_html__( 'Left', 'polo' ),
						'right'   => esc_html__( 'Right', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta_pan_style', '==', 'style_4' ),
				),
			), // end: fields
		), // end: a section
	)
);
/*
 * 404 page template options
 */
$options[] = array(
	'id'        => 'page_404_options',
	'title'     => esc_html__( '404 page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'page_404_settings',
			'fields' => array(
				array(
					'id'      => 'page_404_style',
					'title'   => esc_html__( 'Page style', 'polo' ),
					'type'    => 'select',
					'options' => array(
						'default'  => esc_html__( 'Default', 'polo' ),
						'parallax' => esc_html__( 'Parallax', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'    => '404_page_title', // this is must be unique
					'type'  => 'text',
					'title' => esc_html__( 'Page title', 'polo' ),
				),
				array(
					'id'    => '404_page_description', // this is must be unique
					'type'  => 'textarea',
					'title' => esc_html__( 'Page description', 'polo' ),
				),
				array(
					'id'         => 'parallax_404_bg_image',
					'type'       => 'image',
					'title'      => esc_html__( 'Background image', 'polo' ),
					'dependency' => array( 'page_404_style', '==', 'parallax' ),
				),
			), // End: fields.
		), // End: a section.
	)
);
/*
 *Products page template options
 */
$options[] = array(
	'id'        => 'meta_products_page_options',
	'title'     => esc_html__( 'Products page options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'products_page_settings',
			'fields' => array(
				array(
					'id'    => 'woo_shop_title',
					'type'  => 'text',
					'title' => esc_html__( 'Title for shop page', 'polo' ),
				),
				array(
					'id'    => 'woo_shop_description',
					'type'  => 'textarea',
					'title' => esc_html__( 'Description for shop page', 'polo' ),
				),
				array(
					'id'    => 'woo_shop_items',
					'type'  => 'number',
					'title' => esc_html__( 'Number of products on page', 'polo' ),
				),
				array(
					'id'      => 'shop_columns_number',
					'type'    => 'select',
					'title'   => esc_html__( 'Columns number', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'2'       => '2 ' . esc_html__( 'columns', 'polo' ),
						'3'       => '3 ' . esc_html__( 'columns', 'polo' ),
						'4'       => '4 ' . esc_html__( 'columns', 'polo' ),
						'6'       => '6 ' . esc_html__( 'columns', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'shop_fullwidth',
					'type'    => 'select',
					'title'   => esc_html__( 'Enable shop full width', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'    => 'woo_shortcode',
					'type'  => 'wysiwyg',
					'title' => esc_html__( 'Shortcode before footer', 'polo' ),
				),
			), // End: fields.
		), // End: a section.
	)
);
/*
 * Single product layout
 * */
$options[] = array(
	'id'        => 'single_product_layout',
	'title'     => esc_html__( 'Layout', 'polo' ),
	'post_type' => 'product',
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'portfolio_gallery_style',
			'fields' => array(
				array(
					'id'      => 'meta-product-main-sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Sidebar position', 'polo' ),
					'desc'    => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options' => array(
						'default'    => $img_folder . 'default.png',
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default' => 'default',
					'radio'   => true,
				),
			),
		),
	),
);
/*
 *News page template options
 */
$options[] = array(
	'id'        => 'meta_page_typography',
	'title'     => esc_html__( 'Typography options', 'polo' ),
	'post_type' => 'page', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'news_page_settings',
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
			), // End: fields.
		), // End: a section.
	)
);
/*
 * Post metaboxes
 */
$options[] = array(
	'id'        => 'meta_post_options',
	'title'     => esc_html__( 'Post options', 'polo' ),
	'post_type' => 'post', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => array(
		array(
			'name'   => 'single_post_settings',
			'icon'   => 'fa fa-cog',
			'title'  => esc_html__( 'Single post settings', 'polo' ),
			// Begin: fields.
			'fields' => array(
				array(
					'id'      => 'single_post_style',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Single post style', 'polo' ),
					'options' => array(
						'default' => $img_folder . 'default.png',
						'classic' => $img_folder . 'single-classic.png',
						'modern'  => $img_folder . 'single-modern.png',
					),
					'default' => 'classic',
					'radio'   => true,
				),
			), // End: fields.
		), // End: a section.
		array(
			'title'  => esc_html__( 'Post layout', 'polo' ),
			'name'   => 'single_post_sidebar',
			'fields' => array(

				array(
					'id'         => 'meta-single-main-sidebar',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Sidebar position', 'polo' ),
					'desc'       => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options'    => array(
						'default'    => $img_folder . 'default.png',
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'attributes' => array(
						'data-depend-id' => 'meta-sidebar'
					),
				),
				array(
					'id'         => 'meta-single-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Select width of main sidebar', 'polo' ),
					'options'    => array(
						'default'          => esc_html__( 'Default', 'polo' ),
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta-sidebar', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
				),
				array(
					'id'         => 'meta-single-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'meta-sidebar', 'any', 'default,2c-l-fixed,2c-r-fixed' ),
				),
			),
		),
	)
);

$options[] = array(
	'id'        => 'post-format-video-feature',
	'title'     => esc_html__( 'Post featured media', 'polo' ),
	'post_type' => 'post',
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(

		array(
			'name'   => 'post_formats_video',
			'fields' => array(

				array(
					'id'    => 'post_video_feature',
					'type'  => 'text',
					'title' => esc_html__( 'Set link for post featured embed video', 'polo' ),
				),
			),
		),
		array(
			'name'   => 'post_formats_video_mp4',
			'fields' => array(

				array(
					'id'       => 'post_video_feature_mp4',
					'type'     => 'upload',
					'settings' => array( 'upload_type' => 'video' ),
					'title'    => esc_html__( 'Set link for post featured mp4 video', 'polo' ),
				),
			),
		),
		array(
			'name'   => 'post_formats_video_webm',
			'fields' => array(

				array(
					'id'       => 'post_video_feature_mp4_webm',
					'type'     => 'upload',
					'settings' => array( 'upload_type' => 'video' ),
					'title'    => esc_html__( 'Set link for post featured webm video', 'polo' ),
				),
			),
		),
	),
);

$options[] = array(
	'id'        => 'post-format-audio-feature',
	'title'     => esc_html__( 'Post featured media', 'polo' ),
	'post_type' => 'post',
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(

		array(
			'name'   => 'post_formats_audio',
			'fields' => array(

				array(
					'id'    => 'post_audio_feature',
					'type'  => 'text',
					'title' => esc_html__( 'Set link for post featured embed audio', 'polo' ),
				),
			),
		),
		array(
			'name'   => 'post_formats_audio_self_hosted',
			'fields' => array(

				array(
					'id'       => 'post_audio_feature_self_hosted',
					'type'     => 'upload',
					'settings' => array( 'upload_type' => 'audio' ),
					'title'    => esc_html__( 'Set link for post featured self hosted audio', 'polo' ),
				),
			),
		),

	),
);

$options[] = array(
	'id'        => 'post-format-gallery-feature',
	'title'     => esc_html__( 'Post featured media', 'polo' ),
	'post_type' => 'post',
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(

		array(
			'name'   => 'post_formats_gallery',
			'fields' => array(
				array(
					'id'    => 'post_gallery_feature',
					'type'  => 'gallery',
					'title' => esc_html__( 'Set for post featured gallery', 'polo' ),
				),
			),
		),
		array(
			'name'   => 'post_formats_gallery_style',
			'fields' => array(
				array(
					'id'      => 'gallery_type',
					'type'    => 'select',
					'title'   => esc_html__( 'Gallery feature type', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'gallery' => esc_html__( 'Gallery', 'polo' ),
						'slider'  => esc_html__( 'Slider', 'polo' ),
					),
					'default' => 'default',
				),
			),
		),


	),
);
$options[] = array(
	'id'        => 'page-side-metabox',
	'title'     => esc_html__( 'Page settings', 'polo' ),
	'post_type' => 'page',
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(

		array(
			'name'   => 'page_custom_menu',
			'fields' => array(
				array(
					'id'      => 'meta-page-menu',
					'type'    => 'select',
					'title'   => esc_html__( 'Custom menu', 'polo' ),
					'options' => $menus_list,
					'default' => 'default',
				),
			),

		),
	)
);

/*
 * Portfolio metaboxes
 */
$options[] = array(
	'id'        => 'meta_portfolio_heading_options',
	'title'     => esc_html__( 'Page options', 'polo' ),
	'post_type' => 'portfolio', // array('page','post','portfolio','product'),
	'context'   => 'normal',
	'priority'  => 'default',
	'sections'  => $page_options,
);
$options[] = array(
	'id'        => 'portfolio-size',
	'title'     => esc_html__( 'Portfolio masonry', 'polo' ),
	'post_type' => 'portfolio',
	'context'   => 'side',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'   => 'portfolio_gallery_style',
			'fields' => array(
				array(
					'id'      => 'masonry-item-size',
					'title'   => esc_html__( 'Item thumbnail size on masonry layout', 'polo' ),
					'type'    => 'image_select',
					'options' => array(
						'normal'      => $img_folder . 'masonry-small.png',
						'large'       => $img_folder . 'masonry-large.png',
						'extra_large' => $img_folder . 'masonry-extra-large.png',
					),
					'default' => 'blue',
				),
			),
		),
	),
);
$options[] = array(
	'id'        => '_portfolio_single_options',
	'title'     => esc_html__( 'Portfolio content', 'polo' ),
	'post_type' => 'portfolio',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(

		// begin: a section
		array(
			'name'   => 'meta_portfolio_layout_settings',
			'icon'   => 'fa fa-cog',
			'title'  => esc_html__( 'Item layout options', 'polo' ),
			// begin: fields
			'fields' => array(
				array(
					'id'      => 'portfolio-single-layout',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Portfolio item layout', 'polo' ),
					'options' => array(
						'default' => $img_folder . 'default.png',
						'left'    => $img_folder . 'folio-media-left.png',
						'right'   => $img_folder . 'folio-media-right.png',
						'top'     => $img_folder . 'folio-media-top.png',
						'bottom'  => $img_folder . 'folio-media-bottom.png',
						'full'    => $img_folder . 'folio-media-none.png',
					),
					'default' => 'default',
					'radio'   => true,
				),
				array(
					'id'         => 'meta-page-main-sidebar',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Sidebar position', 'polo' ),
					'desc'       => esc_html__( 'Please select sidebar layout', 'polo' ),
					'options'    => array(
						'default'    => $img_folder . 'default.png',
						'1col-fixed' => $img_folder . 'layout-1col.png',
						'2c-l-fixed' => $img_folder . 'layout-2-cl.png',
						'2c-r-fixed' => $img_folder . 'layout-2-cr.png',
						'2c-b-fixed' => $img_folder . 'layout-2-cb.png',
					),
					'default'    => 'default',
					'radio'      => true,
					'attributes' => array(
						'data-depend-id' => 'meta_page_sidebar'
					),
					'dependency' => array( 'portfolio-single-layout_full', '==', 'true' ),
				),
				array(
					'id'         => 'meta-page-sidebar-width',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar width', 'polo' ),
					'desc'       => esc_html__( 'Set width of sidebar on single post', 'polo' ),
					'options'    => array(
						'default'          => esc_html__( 'Default', 'polo' ),
						'sidebar-2-column' => esc_html__( 'Small', 'polo' ),
						'sidebar-3-column' => esc_html__( 'Normal', 'polo' ),
						'sidebar-4-column' => esc_html__( 'Large', 'polo' ),
						'sidebar-5-column' => esc_html__( 'Extra large', 'polo' ),
					),
					'default'    => 'sidebar-3-column',
					'dependency' => array(
						'portfolio-single-layout_full|meta_page_sidebar',
						'==|any',
						'true|default,2c-l-fixed,2c-r-fixed'
					),
				),
				array(
					'id'         => 'meta-page-sidebar-style',
					'type'       => 'select',
					'title'      => esc_html__( 'Sidebar style', 'polo' ),
					'desc'       => esc_html__( 'Select style of main sidebar', 'polo' ),
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'classic' => esc_html__( 'Classic', 'polo' ),
						'modern'  => esc_html__( 'Modern', 'polo' ),
					),
					'default'    => 'classic',
					'dependency' => array(
						'portfolio-single-layout_full|meta_page_sidebar',
						'==|any',
						'true|default,2c-l-fixed,2c-r-fixed'
					),
				),
				array(
					'id'         => 'top_padding_disable',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Disable page top padding', 'polo' ),
					'default'    => false,
					'dependency' => array( 'portfolio-single-layout_full', '==', 'true' ),
				),
				array(
					'type'    => 'heading',
					'content' => esc_html__( 'Item media options', 'polo' ),
				),
				array(
					'id'         => 'portfolio-single-media',
					'type'       => 'image_select',
					'title'      => esc_html__( 'Select portfolio media format', 'polo' ),
					'options'    => array(
						'image' => $img_folder . 'folio-image.png',
						'slide' => $img_folder . 'folio-slide-imges.png',
						'video' => $img_folder . 'folio-video.png',
						'audio' => $img_folder . 'folio-audio.png',
					),
					'default'    => 'image',
					'radio'      => true,
					'dependency' => array( 'portfolio-single-layout_full', '!=', 'true' ),

				),

				array(
					'type'       => 'notice',
					'class'      => 'success',
					'content'    => esc_html__( 'Will be displayed Featured Image', 'polo' ),
					'dependency' => array( 'portfolio-single-media_image', '==', 'true' ),
				),

				array(
					'id'         => 'folio_gallery_images',
					'type'       => 'gallery',
					'title'      => esc_html__( 'Images for gallery', 'polo' ),
					'dependency' => array( 'portfolio-single-media_slide', '==', 'true' ),
				),

				array(
					'id'         => 'gallery_type',
					'type'       => 'select',
					'title'      => esc_html__( 'Gallery style', 'polo' ),
					'options'    => array(
						'gallery' => esc_html__( 'Gallery', 'polo' ),
						'slider'  => esc_html__( 'Slider', 'polo' ),
					),
					'default'    => 'default',
					'dependency' => array( 'portfolio-single-media_slide', '==', 'true' ),

				),
				array(
					'id'         => 'folio_post_video_embed',
					'type'       => 'text',
					'title'      => esc_html__( 'Embed Video', 'polo' ),
					'dependency' => array( 'portfolio-single-media_video', '==', 'true' ),
				),
				array(
					'id'         => 'folio_post_video_mp4',
					'type'       => 'upload',
					'title'      => esc_html__( 'MP4 Video', 'polo' ),
					'settings'   => array(
						'upload_type'  => 'video',
						'button_title' => esc_html__( 'Add', 'polo' ),
						'frame_title'  => esc_html__( 'Select', 'polo' ),
						'insert_title' => esc_html__( 'Use this file', 'polo' ),
					),
					'dependency' => array( 'portfolio-single-media_video', '==', 'true' ),
				),
				array(
					'id'         => 'folio_post_video_webm',
					'type'       => 'upload',
					'title'      => esc_html__( 'WebM Video', 'polo' ),
					'settings'   => array(
						'upload_type'  => 'video',
						'button_title' => esc_html__( 'Add', 'polo' ),
						'frame_title'  => esc_html__( 'Select', 'polo' ),
						'insert_title' => esc_html__( 'Use this file', 'polo' ),
					),
					'dependency' => array( 'portfolio-single-media_video', '==', 'true' ),
				),
				array(
					'id'         => 'folio_post_audio_embed',
					'type'       => 'text',
					'title'      => esc_html__( 'Embed Audio', 'polo' ),
					'dependency' => array( 'portfolio-single-media_audio', '==', 'true' ),
				),
				array(
					'id'         => 'folio_post_audio_file',
					'type'       => 'upload',
					'title'      => esc_html__( 'Audio file', 'polo' ),
					'settings'   => array(
						'upload_type'  => 'video',
						'button_title' => esc_html__( 'Add', 'polo' ),
						'frame_title'  => esc_html__( 'Select', 'polo' ),
						'insert_title' => esc_html__( 'Use this file', 'polo' ),
					),
					'dependency' => array( 'portfolio-single-media_audio', '==', 'true' ),
				),
			), // end: fields
		), // end: a section
		array(
			'name'   => 'meta_portfolio_add_info',
			'icon'   => 'fa fa-cog',
			'title'  => esc_html__( 'Item additional info', 'polo' ),
			'fields' => array(
				array(
					'id'    => 'portfolio_description_title', // another unique id
					'type'  => 'text',
					'title' => esc_html__( 'Description title', 'polo' ),
				),
				array(
					'id'        => 'portfolio_description',
					'type'      => 'wysiwyg',
					'multilang' => true,
					'title'     => esc_html__( 'Portfolio description', 'polo' ),
				),
				array(
					'id'    => 'add_info_title', // another unique id
					'type'  => 'text',
					'title' => esc_html__( 'Addition info title', 'polo' ),
				),
				array(
					'id'              => 'additional_info',
					'type'            => 'group',
					'title'           => esc_html__( 'Addition info', 'polo' ),
					'button_title'    => esc_html__( 'Add New', 'polo' ),
					'accordion_title' => esc_html__( 'Add New Field', 'polo' ),
					'fields'          => array(
						array(
							'id'    => 'title',
							'type'  => 'text',
							'title' => esc_html__( 'Title', 'polo' ),
						),
						array(
							'id'    => 'description',
							'type'  => 'text',
							'title' => esc_html__( 'Description', 'polo' ),
							'desc' => esc_html__( 'URL will be automatically converted into clickable links', 'polo' ),
						),
					),
				),
				array(
					'id'      => 'meta_hide_share',
					'type'    => 'select',
					'title'   => esc_html__( 'Hide share buttons', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'      => 'meta_show_related',
					'type'    => 'select',
					'title'   => esc_html__( 'Show related portfolios', 'polo' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'true'    => esc_html__( 'Enable', 'polo' ),
						'false'   => esc_html__( 'Disable', 'polo' ),
					),
					'default' => 'default',
				),
				array(
					'id'         => 'meta_related_posts_number',
					'type'       => 'select',
					'options'    => array(
						'default' => esc_html__( 'Default', 'polo' ),
						'2'       => '2 ' . esc_html__( 'items', 'polo' ),
						'3'       => '3 ' . esc_html__( 'items', 'polo' ),
						'4'       => '4 ' . esc_html__( 'items', 'polo' ),
						'6'       => '6 ' . esc_html__( 'items', 'polo' ),
					),
					'title'      => esc_html__( 'Related posts number', 'polo' ),
					'dependency' => array( 'meta_show_related', '!=', 'false' ),
				),
			)
		)
	),
);

CSFramework_Metabox::instance( $options );

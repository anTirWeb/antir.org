<?php
/**
 * Blogger Hub Theme Customizer
 * @package Blogger Hub
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function blogger_hub_customize_register( $wp_customize ) {	

	//add home page setting pannel
	$wp_customize->add_panel( 'blogger_hub_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'TG Settings', 'blogger-hub' ),
	    'description' => __( 'Description of what this panel does.', 'blogger-hub' ),
	) );

	//layout setting
	$wp_customize->add_section( 'blogger_hub_theme_layout', array(
    	'title'      => __( 'Layout Settings', 'blogger-hub' ),
		'priority'   => 30,
		'panel' => 'blogger_hub_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('blogger_hub_layout',array(
	        'default' => __( 'Right Sidebar', 'blogger-hub' ),
	        'sanitize_callback' => 'blogger_hub_sanitize_choices'	        
	    )
    );

	$wp_customize->add_control('blogger_hub_layout',
	    array(
	        'type' => 'radio',
	        'label' => __( 'Do you want this section', 'blogger-hub' ),
	        'section' => 'blogger_hub_theme_layout',
	        'choices' => array(
	            'Left Sidebar' => __('Left Sidebar','blogger-hub'),
	            'Right Sidebar' => __('Right Sidebar','blogger-hub'),
	            'One Column' => __('One Column','blogger-hub'),
	            'Three Columns' => __('Three Columns','blogger-hub'),
	            'Four Columns' => __('Four Columns','blogger-hub'),
	            'Grid Layout' => __('Grid Layout','blogger-hub')
	        ),
	    )
    );


    $font_array = array(
        '' =>'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' =>'Acme', 
        'Anton' => 'Anton', 
        'Architects Daughter' =>'Architects Daughter',
        'Arimo' => 'Arimo', 
        'Arsenal' =>'Arsenal',
        'Arvo' =>'Arvo',
        'Alegreya' =>'Alegreya',
        'Alfa Slab One' =>'Alfa Slab One',
        'Averia Serif Libre' =>'Averia Serif Libre', 
        'Bangers' =>'Bangers', 
        'Boogaloo' =>'Boogaloo', 
        'Bad Script' =>'Bad Script',
        'Bitter' =>'Bitter', 
        'Bree Serif' =>'Bree Serif', 
        'BenchNine' =>'BenchNine',
        'Cabin' =>'Cabin',
        'Cardo' =>'Cardo', 
        'Courgette' =>'Courgette', 
        'Cherry Swash' =>'Cherry Swash',
        'Cormorant Garamond' =>'Cormorant Garamond', 
        'Crimson Text' =>'Crimson Text',
        'Cuprum' =>'Cuprum', 
        'Cookie' =>'Cookie',
        'Chewy' =>'Chewy',
        'Days One' =>'Days One',
        'Dosis' =>'Dosis',
        'Droid Sans' =>'Droid Sans', 
        'Economica' =>'Economica', 
        'Fredoka One' =>'Fredoka One',
        'Fjalla One' =>'Fjalla One',
        'Francois One' =>'Francois One', 
        'Frank Ruhl Libre' => 'Frank Ruhl Libre', 
        'Gloria Hallelujah' =>'Gloria Hallelujah',
        'Great Vibes' =>'Great Vibes', 
        'Handlee' =>'Handlee', 
        'Hammersmith One' =>'Hammersmith One',
        'Inconsolata' =>'Inconsolata',
        'Indie Flower' =>'Indie Flower', 
        'IM Fell English SC' =>'IM Fell English SC',
        'Julius Sans One' =>'Julius Sans One',
        'Josefin Slab' =>'Josefin Slab',
        'Josefin Sans' =>'Josefin Sans',
        'Kanit' =>'Kanit',
        'Lobster' =>'Lobster',
        'Lato' => 'Lato',
        'Lora' =>'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather',
        'Monda' =>'Monda',
        'Montserrat' =>'Montserrat',
        'Muli' =>'Muli',
        'Marck Script' =>'Marck Script',
        'Noto Serif' =>'Noto Serif',
        'Open Sans' =>'Open Sans',
        'Overpass' => 'Overpass', 
        'Overpass Mono' =>'Overpass Mono',
        'Oxygen' =>'Oxygen',
        'Orbitron' =>'Orbitron',
        'Patua One' =>'Patua One',
        'Pacifico' =>'Pacifico',
        'Padauk' =>'Padauk',
        'Playball' =>'Playball',
        'Playfair Display' =>'Playfair Display',
        'PT Sans' =>'PT Sans',
        'Philosopher' =>'Philosopher',
        'Permanent Marker' =>'Permanent Marker',
        'Poiret One' =>'Poiret One',
        'Quicksand' =>'Quicksand',
        'Quattrocento Sans' =>'Quattrocento Sans',
        'Raleway' =>'Raleway',
        'Rubik' =>'Rubik',
        'Rokkitt' =>'Rokkitt',
        'Russo One' => 'Russo One', 
        'Righteous' =>'Righteous', 
        'Slabo' =>'Slabo', 
        'Source Sans Pro' =>'Source Sans Pro',
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' =>  'Shadows Into Light',
        'Sacramento' =>'Sacramento',
        'Shrikhand' =>'Shrikhand',
        'Tangerine' => 'Tangerine',
        'Ubuntu' =>'Ubuntu',
        'VT323' =>'VT323',
        'Varela Round' =>'Varela Round',
        'Vampiro One' =>'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' =>'Volkhov',
        'Yanone Kaffeesatz' =>'Yanone Kaffeesatz'
    );

	//Typography
	$wp_customize->add_section( 'blogger_hub_typography', array(
    	'title'      => __( 'Typography', 'blogger-hub' ),
		'priority'   => 30,
		'panel' => 'blogger_hub_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'blogger_hub_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_paragraph_color', array(
		'label' => __('Paragraph Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_paragraph_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'Paragraph Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	$wp_customize->add_setting('blogger_hub_paragraph_font_size',array(
		'default'	=> '12px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'blogger_hub_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_atag_color', array(
		'label' => __('"a" Tag Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_atag_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( '"a" Tag Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'blogger_hub_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_li_color', array(
		'label' => __('"li" Tag Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_li_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( '"li" Tag Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h1_color', array(
		'label' => __('H1 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h1_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H1 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('blogger_hub_h1_font_size',array(
		'default'	=> '50px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h1_font_size',array(
		'label'	=> __('H1 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h2_color', array(
		'label' => __('H2 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h2_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H2 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('blogger_hub_h2_font_size',array(
		'default'	=> '45px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h2_font_size',array(
		'label'	=> __('H2 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h3_color', array(
		'label' => __('H3 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h3_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H3 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('blogger_hub_h3_font_size',array(
		'default'	=> '36px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h3_font_size',array(
		'label'	=> __('H3 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h4_color', array(
		'label' => __('H4 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h4_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H4 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('blogger_hub_h4_font_size',array(
		'default'	=> '30px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h4_font_size',array(
		'label'	=> __('H4 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h5_color', array(
		'label' => __('H5 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h5_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H5 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('blogger_hub_h5_font_size',array(
		'default'	=> '25px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h5_font_size',array(
		'label'	=> __('H5 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'blogger_hub_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogger_hub_h6_color', array(
		'label' => __('H6 Color', 'blogger-hub'),
		'section' => 'blogger_hub_typography',
		'settings' => 'blogger_hub_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('blogger_hub_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'blogger_hub_sanitize_choices'
	));
	$wp_customize->add_control(
	    'blogger_hub_h6_font_family', array(
	    'section'  => 'blogger_hub_typography',
	    'label'    => __( 'H6 Fonts','blogger-hub'),
	    'type'     => 'select',
	    'choices'  => $font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('blogger_hub_h6_font_size',array(
		'default'	=> '18px',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('blogger_hub_h6_font_size',array(
		'label'	=> __('H6 Font Size','blogger-hub'),
		'section'	=> 'blogger_hub_typography',
		'setting'	=> 'blogger_hub_h6_font_size',
		'type'	=> 'text'
	));

	//Topbar section
	$wp_customize->add_section('blogger_hub_social_link',array(
		'title'	=> __('Social Links','blogger-hub'),
		'description'	=> __('Add Social Link here','blogger-hub'),
		'priority'	=> null,
		'panel' => 'blogger_hub_panel_id',
	));

	$wp_customize->add_setting('blogger_hub_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('blogger_hub_facebook_url',array(
		'label'	=> __('Facebook url','blogger-hub'),
		'section'	=> 'blogger_hub_social_link',
		'type'		=> 'url'
	));	

	$wp_customize->add_setting('blogger_hub_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('blogger_hub_twitter_url',array(
		'label'	=> __('Twitter url','blogger-hub'),
		'section'	=> 'blogger_hub_social_link',
		'type'		=> 'url'
	));	

	$wp_customize->add_setting('blogger_hub_insta_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('blogger_hub_insta_url',array(
		'label'	=> __('Instagram url','blogger-hub'),
		'section'	=> 'blogger_hub_social_link',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('blogger_hub_linkdin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('blogger_hub_linkdin_url',array(
		'label'	=> __('Linkdin url','blogger-hub'),
		'section'	=> 'blogger_hub_social_link',
		'type'		=> 'url'
	));	

	$wp_customize->add_setting('blogger_hub_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('blogger_hub_youtube_url',array(
		'label'	=> __('Youtube url','blogger-hub'),
		'section'	=> 'blogger_hub_social_link',
		'type'		=> 'url'
	));

	//Our Blog Category section
  	$wp_customize->add_section('blogger_hub_category_post',array(
	    'title' => __('Our Blog Category Section','blogger-hub'),
	    'description' => '',
	    'priority'  => null,
	    'panel' => 'blogger_hub_panel_id',
	));

	$wp_customize->add_setting('blogger_hub_section_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('blogger_hub_section_title',array(
		'label'	=> __('Section Title','blogger-hub'),
		'section'	=> 'blogger_hub_category_post',
		'type'		=> 'text'
	));

	$categories = get_categories();
		$cats = array();
			$i = 0;
		  	foreach($categories as $category){
		  	if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cats[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('blogger_hub_our_category',array(
	    'default' => 'select',
	    'sanitize_callback' => 'sanitize_text_field',
  	));
  	$wp_customize->add_control('blogger_hub_our_category',array(
	    'type'    => 'select',
	    'choices' => $cats,
	    'label' => __('Select Category to display Latest Post','blogger-hub'),
	    'section' => 'blogger_hub_category_post',
	));
	
	//footer text
	$wp_customize->add_section('blogger_hub_footer_section',array(
		'title'	=> __('Footer Text','blogger-hub'),
		'description'	=> __('Add some text for footer like copyright etc.','blogger-hub'),
		'panel' => 'blogger_hub_panel_id'
	));
	
	$wp_customize->add_setting('blogger_hub_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('blogger_hub_text',array(
		'label'	=> __('Copyright Text','blogger-hub'),
		'section'	=> 'blogger_hub_footer_section',
		'type'		=> 'text'
	));	
}
add_action( 'customize_register', 'blogger_hub_customize_register' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Blogger_Hub_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Blogger_Hub_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Blogger_Hub_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority'   => 9,
					'title'    => esc_html__( 'Blogger Hub Pro', 'blogger-hub' ),
					'pro_text' => esc_html__( 'Go Pro', 'blogger-hub' ),
					'pro_url'  => esc_url('https://www.themesglance.com/themes/premium-blog-wordpress-theme/'),				
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'blogger-hub-customize-controls', trailingslashit( get_template_directory_uri() ) . '/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'blogger-hub-customize-controls', trailingslashit( get_template_directory_uri() ) . '/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Blogger_Hub_Customize::get_instance();
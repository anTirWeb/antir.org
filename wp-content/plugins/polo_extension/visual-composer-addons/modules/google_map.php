<?php
if ( ! class_exists( 'Crum_Google_Map' ) ) {
	class Crum_Google_Map {
		function __construct() {
			add_action( 'admin_init', array( &$this, 'crum_google_map_init' ) );
			add_shortcode( 'crumina_gmap', array( &$this, 'crum_google_map_form' ) );
		}

		function crum_google_map_custom_styles() {
			return array(
				'coy-beauty'         => array(
					esc_html__( "Coy Beauty", "crum" ),
					"[{'featureType':'all','elementType':'geometry.stroke','stylers':[{'visibility':'simplified'}]},{'featureType':'administrative','elementType':'all','stylers':[{'visibility':'off'}]},{'featureType':'administrative','elementType':'labels','stylers':[{'visibility':'simplified'},{'color':'#a31645'}]},{'featureType':'landscape','elementType':'all','stylers':[{'weight':'3.79'},{'visibility':'on'},{'color':'#ffecf0'}]},{'featureType':'landscape','elementType':'geometry','stylers':[{'visibility':'on'}]},{'featureType':'landscape','elementType':'geometry.stroke','stylers':[{'visibility':'on'}]},{'featureType':'poi','elementType':'all','stylers':[{'visibility':'simplified'},{'color':'#a31645'}]},{'featureType':'poi','elementType':'geometry','stylers':[{'saturation':'0'},{'lightness':'0'},{'visibility':'off'}]},{'featureType':'poi','elementType':'geometry.stroke','stylers':[{'visibility':'off'}]},{'featureType':'poi.business','elementType':'all','stylers':[{'visibility':'simplified'},{'color':'#d89ca8'}]},{'featureType':'poi.business','elementType':'geometry','stylers':[{'visibility':'on'}]},{'featureType':'poi.business','elementType':'geometry.fill','stylers':[{'visibility':'on'},{'saturation':'0'}]},{'featureType':'poi.business','elementType':'labels','stylers':[{'color':'#a31645'}]},{'featureType':'poi.business','elementType':'labels.icon','stylers':[{'visibility':'simplified'},{'lightness':'84'}]},{'featureType':'road','elementType':'all','stylers':[{'saturation':-100},{'lightness':45}]},{'featureType':'road.highway','elementType':'all','stylers':[{'visibility':'simplified'}]},{'featureType':'road.arterial','elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'transit','elementType':'all','stylers':[{'visibility':'off'}]},{'featureType':'water','elementType':'all','stylers':[{'color':'#d89ca8'},{'visibility':'on'}]},{'featureType':'water','elementType':'geometry.fill','stylers':[{'visibility':'on'},{'color':'#fedce3'}]},{'featureType':'water','elementType':'labels','stylers':[{'visibility':'off'}]}]"
				),
				'subtle-grayscale'   => array(
					esc_html__( "Subtle Grayscale", "crum" ),
					"[{'featureType':'landscape','stylers':[{'saturation':-100},{'lightness':65},{'visibility':'on'}]},{'featureType':'poi','stylers':[{'saturation':-100},{'lightness':51},{'visibility':'simplified'}]},{'featureType':'road.highway','stylers':[{'saturation':-100},{'visibility':'simplified'}]},{'featureType':'road.arterial','stylers':[{'saturation':-100},{'lightness':30},{'visibility':'on'}]},{'featureType':'road.local','stylers':[{'saturation':-100},{'lightness':40},{'visibility':'on'}]},{'featureType':'transit','stylers':[{'saturation':-100},{'visibility':'simplified'}]},{'featureType':'administrative.province','stylers':[{'visibility':'off'}]},{'featureType':'water','elementType':'labels','stylers':[{'visibility':'on'},{'lightness':-25},{'saturation':-100}]},{'featureType':'water','elementType':'geometry','stylers':[{'hue':'#ffff00'},{'lightness':-25},{'saturation':-97}]}]"
				),
				'pale-dawn'          => array(
					esc_html__( "Pale Dawn", "crum" ),
					"[{'featureType':'water','stylers':[{'visibility':'on'},{'color':'#acbcc9'}]},{'featureType':'landscape','stylers':[{'color':'#f2e5d4'}]},{'featureType':'road.highway','elementType':'geometry','stylers':[{'color':'#c5c6c6'}]},{'featureType':'road.arterial','elementType':'geometry','stylers':[{'color':'#e4d7c6'}]},{'featureType':'road.local','elementType':'geometry','stylers':[{'color':'#fbfaf7'}]},{'featureType':'poi.park','elementType':'geometry','stylers':[{'color':'#c5dac6'}]},{'featureType':'administrative','stylers':[{'visibility':'on'},{'lightness':33}]},{'featureType':'road'},{'featureType':'poi.park','elementType':'labels','stylers':[{'visibility':'on'},{'lightness':20}]},{},{'featureType':'road','stylers':[{'lightness':20}]}]"
				),
				'blue-water'         => array(
					esc_html__( "Blue water", "crum" ),
					"[{'featureType':'water','stylers':[{'color':'#46bcec'},{'visibility':'on'}]},{'featureType':'landscape','stylers':[{'color':'#f2f2f2'}]},{'featureType':'road','stylers':[{'saturation':-100},{'lightness':45}]},{'featureType':'road.highway','stylers':[{'visibility':'simplified'}]},{'featureType':'road.arterial','elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'administrative','elementType':'labels.text.fill','stylers':[{'color':'#444444'}]},{'featureType':'transit','stylers':[{'visibility':'off'}]},{'featureType':'poi','stylers':[{'visibility':'off'}]}]"
				),
				'shades-of-grey'     => array(
					esc_html__( "Shades of Grey", "crum" ),
					"[{'featureType':'water','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':17}]},{'featureType':'landscape','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':20}]},{'featureType':'road.highway','elementType':'geometry.fill','stylers':[{'color':'#000000'},{'lightness':17}]},{'featureType':'road.highway','elementType':'geometry.stroke','stylers':[{'color':'#000000'},{'lightness':29},{'weight':0.2}]},{'featureType':'road.arterial','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':18}]},{'featureType':'road.local','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':16}]},{'featureType':'poi','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':21}]},{'elementType':'labels.text.stroke','stylers':[{'visibility':'on'},{'color':'#000000'},{'lightness':16}]},{'elementType':'labels.text.fill','stylers':[{'saturation':36},{'color':'#000000'},{'lightness':40}]},{'elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'transit','elementType':'geometry','stylers':[{'color':'#000000'},{'lightness':19}]},{'featureType':'administrative','elementType':'geometry.fill','stylers':[{'color':'#000000'},{'lightness':20}]},{'featureType':'administrative','elementType':'geometry.stroke','stylers':[{'color':'#000000'},{'lightness':17},{'weight':1.2}]}]"
				),
				'midnight-commander' => array(
					esc_html__( "Midnight Commander", "crum" ),
					"[{'featureType':'water','stylers':[{'color':'#021019'}]},{'featureType':'landscape','stylers':[{'color':'#08304b'}]},{'featureType':'poi','elementType':'geometry','stylers':[{'color':'#0c4152'},{'lightness':5}]},{'featureType':'road.highway','elementType':'geometry.fill','stylers':[{'color':'#000000'}]},{'featureType':'road.highway','elementType':'geometry.stroke','stylers':[{'color':'#0b434f'},{'lightness':25}]},{'featureType':'road.arterial','elementType':'geometry.fill','stylers':[{'color':'#000000'}]},{'featureType':'road.arterial','elementType':'geometry.stroke','stylers':[{'color':'#0b3d51'},{'lightness':16}]},{'featureType':'road.local','elementType':'geometry','stylers':[{'color':'#000000'}]},{'elementType':'labels.text.fill','stylers':[{'color':'#ffffff'}]},{'elementType':'labels.text.stroke','stylers':[{'color':'#000000'},{'lightness':13}]},{'featureType':'transit','stylers':[{'color':'#146474'}]},{'featureType':'administrative','elementType':'geometry.fill','stylers':[{'color':'#000000'}]},{'featureType':'administrative','elementType':'geometry.stroke','stylers':[{'color':'#144b53'},{'lightness':14},{'weight':1.4}]}]"
				),
				'retro'              => array(
					esc_html__( "Retro", "crum" ),
					"[{'featureType':'administrative','stylers':[{'visibility':'off'}]},{'featureType':'poi','stylers':[{'visibility':'simplified'}]},{'featureType':'road','elementType':'labels','stylers':[{'visibility':'simplified'}]},{'featureType':'water','stylers':[{'visibility':'simplified'}]},{'featureType':'transit','stylers':[{'visibility':'simplified'}]},{'featureType':'landscape','stylers':[{'visibility':'simplified'}]},{'featureType':'road.highway','stylers':[{'visibility':'off'}]},{'featureType':'road.local','stylers':[{'visibility':'on'}]},{'featureType':'road.highway','elementType':'geometry','stylers':[{'visibility':'on'}]},{'featureType':'water','stylers':[{'color':'#84afa3'},{'lightness':52}]},{'stylers':[{'saturation':-17},{'gamma':0.36}]},{'featureType':'transit.line','elementType':'geometry','stylers':[{'color':'#3f518c'}]}]"
				),
				'light-monochrome'   => array(
					esc_html__( "Light Monochrome", "crum" ),
					"[{'featureType':'water','elementType':'all','stylers':[{'hue':'#e9ebed'},{'saturation':-78},{'lightness':67},{'visibility':'simplified'}]},{'featureType':'landscape','elementType':'all','stylers':[{'hue':'#ffffff'},{'saturation':-100},{'lightness':100},{'visibility':'simplified'}]},{'featureType':'road','elementType':'geometry','stylers':[{'hue':'#bbc0c4'},{'saturation':-93},{'lightness':31},{'visibility':'simplified'}]},{'featureType':'poi','elementType':'all','stylers':[{'hue':'#ffffff'},{'saturation':-100},{'lightness':100},{'visibility':'off'}]},{'featureType':'road.local','elementType':'geometry','stylers':[{'hue':'#e9ebed'},{'saturation':-90},{'lightness':-8},{'visibility':'simplified'}]},{'featureType':'transit','elementType':'all','stylers':[{'hue':'#e9ebed'},{'saturation':10},{'lightness':69},{'visibility':'on'}]},{'featureType':'administrative.locality','elementType':'all','stylers':[{'hue':'#2c2e33'},{'saturation':7},{'lightness':19},{'visibility':'on'}]},{'featureType':'road','elementType':'labels','stylers':[{'hue':'#bbc0c4'},{'saturation':-93},{'lightness':31},{'visibility':'on'}]},{'featureType':'road.arterial','elementType':'labels','stylers':[{'hue':'#bbc0c4'},{'saturation':-93},{'lightness':-2},{'visibility':'simplified'}]}]"
				),
				'paper'              => array(
					esc_html__( "Paper", "crum" ),
					"[{'featureType':'administrative','stylers':[{'visibility':'off'}]},{'featureType':'poi','stylers':[{'visibility':'simplified'}]},{'featureType':'road','stylers':[{'visibility':'simplified'}]},{'featureType':'water','stylers':[{'visibility':'simplified'}]},{'featureType':'transit','stylers':[{'visibility':'simplified'}]},{'featureType':'landscape','stylers':[{'visibility':'simplified'}]},{'featureType':'road.highway','stylers':[{'visibility':'off'}]},{'featureType':'road.local','stylers':[{'visibility':'on'}]},{'featureType':'road.highway','elementType':'geometry','stylers':[{'visibility':'on'}]},{'featureType':'road.arterial','stylers':[{'visibility':'off'}]},{'featureType':'water','stylers':[{'color':'#5f94ff'},{'lightness':26},{'gamma':5.86}]},{},{'featureType':'road.highway','stylers':[{'weight':0.6},{'saturation':-85},{'lightness':61}]},{'featureType':'road'},{},{'featureType':'landscape','stylers':[{'hue':'#0066ff'},{'saturation':74},{'lightness':100}]}]"
				),
				'gowalla'            => array(
					esc_html__( "Gowalla", "crum" ),
					"[{'featureType':'road','elementType':'labels','stylers':[{'visibility':'simplified'},{'lightness':20}]},{'featureType':'administrative.land_parcel','elementType':'all','stylers':[{'visibility':'off'}]},{'featureType':'landscape.man_made','elementType':'all','stylers':[{'visibility':'off'}]},{'featureType':'transit','elementType':'all','stylers':[{'visibility':'off'}]},{'featureType':'road.local','elementType':'labels','stylers':[{'visibility':'simplified'}]},{'featureType':'road.local','elementType':'geometry','stylers':[{'visibility':'simplified'}]},{'featureType':'road.highway','elementType':'labels','stylers':[{'visibility':'simplified'}]},{'featureType':'poi','elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'road.arterial','elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'water','elementType':'all','stylers':[{'hue':'#a1cdfc'},{'saturation':30},{'lightness':49}]},{'featureType':'road.highway','elementType':'geometry','stylers':[{'hue':'#f49935'}]},{'featureType':'road.arterial','elementType':'geometry','stylers':[{'hue':'#fad959'}]}]"
				),
				'greyscale'          => array(
					esc_html__( "Greyscale", "crum" ),
					"[{'featureType':'all','stylers':[{'saturation':-100},{'gamma':0.5}]}]"
				),
				'apple-maps-esque'   => array(
					esc_html__( "Apple Maps-esque", "crum" ),
					"[{'featureType':'water','elementType':'geometry','stylers':[{'color':'#a2daf2'}]},{'featureType':'landscape.man_made','elementType':'geometry','stylers':[{'color':'#f7f1df'}]},{'featureType':'landscape.natural','elementType':'geometry','stylers':[{'color':'#d0e3b4'}]},{'featureType':'landscape.natural.terrain','elementType':'geometry','stylers':[{'visibility':'off'}]},{'featureType':'poi.park','elementType':'geometry','stylers':[{'color':'#bde6ab'}]},{'featureType':'poi','elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'poi.medical','elementType':'geometry','stylers':[{'color':'#fbd3da'}]},{'featureType':'poi.business','stylers':[{'visibility':'off'}]},{'featureType':'road','elementType':'geometry.stroke','stylers':[{'visibility':'off'}]},{'featureType':'road','elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'road.highway','elementType':'geometry.fill','stylers':[{'color':'#ffe15f'}]},{'featureType':'road.highway','elementType':'geometry.stroke','stylers':[{'color':'#efd151'}]},{'featureType':'road.arterial','elementType':'geometry.fill','stylers':[{'color':'#ffffff'}]},{'featureType':'road.local','elementType':'geometry.fill','stylers':[{'color':'black'}]},{'featureType':'transit.station.airport','elementType':'geometry.fill','stylers':[{'color':'#cfb2db'}]}]"
				),
				'subtle'             => array(
					esc_html__( "Subtle", "crum" ),
					"[{'featureType':'poi','stylers':[{'visibility':'off'}]},{'stylers':[{'saturation':-70},{'lightness':37},{'gamma':1.15}]},{'elementType':'labels','stylers':[{'gamma':0.26},{'visibility':'off'}]},{'featureType':'road','stylers':[{'lightness':0},{'saturation':0},{'hue':'#ffffff'},{'gamma':0}]},{'featureType':'road','elementType':'labels.text.stroke','stylers':[{'visibility':'off'}]},{'featureType':'road.arterial','elementType':'geometry','stylers':[{'lightness':20}]},{'featureType':'road.highway','elementType':'geometry','stylers':[{'lightness':50},{'saturation':0},{'hue':'#ffffff'}]},{'featureType':'administrative.province','stylers':[{'visibility':'on'},{'lightness':-50}]},{'featureType':'administrative.province','elementType':'labels.text.stroke','stylers':[{'visibility':'off'}]},{'featureType':'administrative.province','elementType':'labels.text','stylers':[{'lightness':20}]}]"
				),
				'neutral-blue'       => array(
					esc_html__( "Neutral Blue", "crum" ),
					"[{'featureType':'water','elementType':'geometry','stylers':[{'color':'#193341'}]},{'featureType':'landscape','elementType':'geometry','stylers':[{'color':'#2c5a71'}]},{'featureType':'road','elementType':'geometry','stylers':[{'color':'#29768a'},{'lightness':-37}]},{'featureType':'poi','elementType':'geometry','stylers':[{'color':'#406d80'}]},{'featureType':'transit','elementType':'geometry','stylers':[{'color':'#406d80'}]},{'elementType':'labels.text.stroke','stylers':[{'visibility':'on'},{'color':'#3e606f'},{'weight':2},{'gamma':0.84}]},{'elementType':'labels.text.fill','stylers':[{'color':'#ffffff'}]},{'featureType':'administrative','elementType':'geometry','stylers':[{'weight':0.6},{'color':'#1a3541'}]},{'elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'poi.park','elementType':'geometry','stylers':[{'color':'#2c5a71'}]}]"
				),
				'flat-map'           => array(
					esc_html__( "Flat Map", "crum" ),
					"[{'stylers':[{'visibility':'off'}]},{'featureType':'road','stylers':[{'visibility':'on'},{'color':'#ffffff'}]},{'featureType':'road.arterial','stylers':[{'visibility':'on'},{'color':'#fee379'}]},{'featureType':'road.highway','stylers':[{'visibility':'on'},{'color':'#fee379'}]},{'featureType':'landscape','stylers':[{'visibility':'on'},{'color':'#f3f4f4'}]},{'featureType':'water','stylers':[{'visibility':'on'},{'color':'#7fc8ed'}]},{},{'featureType':'road','elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'poi.park','elementType':'geometry.fill','stylers':[{'visibility':'on'},{'color':'#83cead'}]},{'elementType':'labels','stylers':[{'visibility':'off'}]},{'featureType':'landscape.man_made','elementType':'geometry','stylers':[{'weight':0.9},{'visibility':'off'}]}]"
				),
				'shift-worker'       => array(
					esc_html__( "Shift Worker", "crum" ),
					"[{'stylers':[{'saturation':-100},{'gamma':1}]},{'elementType':'labels.text.stroke','stylers':[{'visibility':'off'}]},{'featureType':'poi.business','elementType':'labels.text','stylers':[{'visibility':'off'}]},{'featureType':'poi.business','elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'poi.place_of_worship','elementType':'labels.text','stylers':[{'visibility':'off'}]},{'featureType':'poi.place_of_worship','elementType':'labels.icon','stylers':[{'visibility':'off'}]},{'featureType':'road','elementType':'geometry','stylers':[{'visibility':'simplified'}]},{'featureType':'water','stylers':[{'visibility':'on'},{'saturation':50},{'gamma':0},{'hue':'#50a5d1'}]},{'featureType':'administrative.neighborhood','elementType':'labels.text.fill','stylers':[{'color':'#333333'}]},{'featureType':'road.local','elementType':'labels.text','stylers':[{'weight':0.5},{'color':'#333333'}]},{'featureType':'transit.station','elementType':'labels.icon','stylers':[{'gamma':1},{'saturation':50}]}]"
				),

			);
		}

		function crum_map_select_values() {
			$opts = $this->crum_google_map_custom_styles();

			$values = array(
				0 => __( 'Default', 'crum' ),
			);

			foreach ( $opts as $k => $opt ) {
				if ( ! isset( $opt[0] ) ) {
					continue;
				}

				$values[ $k ] = $opt[0];
			}

			return $values;
		}

		function crum_get_map_style( $map_style ) {
			$opts = $this->crum_google_map_custom_styles();

			if ( empty( $map_style ) ) {
				return false;
			}
			if ( ! isset( $opts[ $map_style ] ) ) {
				return false;
			}
			if ( ! isset( $opts[ $map_style ][1] ) ) {
				return false;
			}

			return $opts[ $map_style ][1];
		}

		function crum_google_map_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map( array(
					'name'     => esc_html__( 'Polo Google Maps', 'crum' ),
					"base"     => "crumina_gmap",
					"icon"     => "icon-wpb-map-pin",
					"category" => esc_html__( 'Polo Modules', 'polo_extension' ),
					"params"   => array(
						array(
							"type"       => "dropdown",
							"class"      => "",
							"heading"    => esc_html__( "Map type", "crum" ),
							"param_name" => "map_type",
							"value"      => array(
								esc_html__( "Default", "crum" )      => "default",
								esc_html__( "Embed iframe", "crum" ) => "iframe",
							),
						),
						array(
							"type"       => "dropdown",
							"heading"    => esc_html__( 'Style', 'crum' ),
							'dependency' => array( 'element' => 'map_type', 'value' => 'default' ),
							"param_name" => "map_style",
							"value"      => array(
								esc_html__( "Default", 'crum' )            => "default",
								esc_html__( "Coy Beauty", 'crum' )         => "coy-beauty",
								esc_html__( "Subtle Grayscale", 'crum' )   => "subtle-grayscale",
								esc_html__( "Pale Dawn", 'crum' )          => "pale-dawn",
								esc_html__( "Blue water", 'crum' )         => "blue-water",
								esc_html__( "Shades of Grey", 'crum' )     => "shades-of-grey",
								esc_html__( "Midnight Commander", 'crum' ) => "midnight-commander",
								esc_html__( "Retro", 'crum' )              => "retro",
								esc_html__( "Light Monochrome", 'crum' )   => "light-monochrome",
								esc_html__( "Paper", 'crum' )              => "paper",
								esc_html__( "Gowalla", 'crum' )            => "gowalla",
								esc_html__( "Greyscale", 'crum' )          => "greyscale",
								esc_html__( "Apple Maps-esque", 'crum' )   => "apple-maps-esque",
								esc_html__( "Subtle", 'crum' )             => "subtle",
								esc_html__( "Neutral Blue", 'crum' )       => "neutral-blue",
								esc_html__( "Flat Map", 'crum' )           => "flat-map",
								esc_html__( "Shift Worker", 'crum' )       => "shift-worker",

							),
						),
						array(
							"type"        => "textfield",
							"heading"     => esc_html__( "Map height", "crum" ),
							"param_name"  => "size",
							"description" => esc_html__( 'Enter map height in pixels. Example: 200.', "crum" )
						),
						array(
							"type"       => "dropdown",
							"heading"    => esc_html__( "Map Zoom", "crum" ),
							"param_name" => "zoom",
							'dependency' => array( 'element' => 'map_type', 'value' => 'default' ),
							"value"      => array(
								esc_html__( "14 - Default", "crum" ) => 14,
								1,
								2,
								3,
								4,
								5,
								6,
								7,
								8,
								9,
								10,
								11,
								12,
								13,
								15,
								16,
								17,
								18,
								19,
								20
							)
						),
						array(
							"type"        => "attach_image",
							"heading"     => esc_html__( "Marker Image", "crum" ),
							"param_name"  => "marker_image",
							"value"       => "",
							'dependency'  => array( 'element' => 'map_type', 'value' => 'default' ),
							"description" => esc_html__( "Select image from media library.", "crum" )
						),
						array(
							"type"       => "textfield",
							"heading"    => esc_html__( "Map Marker Location", "crum" ),
							"param_name" => "map_markers",
							'dependency' => array( 'element' => 'map_type', 'value' => 'default' ),
						),
						array(
							"type"       => "textfield",
							"heading"    => __( "Map Marker tooltip", "crum" ),
							"param_name" => "map_marker_tooltips",
							'dependency' => array( 'element' => 'map_type', 'value' => 'default' ),
						),
						array(
							'type'        => 'textarea_safe',
							'heading'     => __( 'Map embed iframe', 'crum' ),
							'param_name'  => 'link',
							'dependency'  => array( 'element' => 'map_type', 'value' => 'iframe' ),
							'value'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6304.829986131271!2d-122.4746968033092!3d37.80374752160443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808586e6302615a1%3A0x86bd130251757c00!2sStorey+Ave%2C+San+Francisco%2C+CA+94129!5e0!3m2!1sen!2sus!4v1435826432051" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
							'description' => sprintf( __( 'Visit %s to create your map (Step by step: 1) Find location 2) Click the cog symbol in the lower right corner and select "Share or embed map" 3) On modal window select "Embed map" 4) Copy iframe code and paste it).' ), '<a href="https://www.google.com/maps" target="_blank">' . __( 'Google maps', 'crum' ) . '</a>' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => __( 'Extra class name', 'js_composer' ),
							'param_name'  => 'el_class',
							'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),
					)
				) );
			}
		}

		function crum_google_map_form( $atts, $content = null ) {
			$map_type = $size = $img_link_target = $zoom = $marker_image = $map_markers = $map_marker_tooltips = $text_block_title = $map_style = $el_class = $link = '';
			extract( shortcode_atts( array(
				'map_type'            => 'default',
				'size'                => '300',
				"img_link_target"     => '',
				'zoom'                => '12',
				'marker_image'        => '',
				'map_markers'         => '',
				'map_marker_tooltips' => '',
				'text_block_title'    => '',
				'map_style'           => '',
				'el_class'            => '',
				'link'                => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6304.829986131271!2d-122.4746968033092!3d37.80374752160443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808586e6302615a1%3A0x86bd130251757c00!2sStorey+Ave%2C+San+Francisco%2C+CA+94129!5e0!3m2!1sen!2sus!4v1435826432051" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
			),
				$atts ) );

			$block_html = '';

			if ( 'iframe' === $map_type ) {

				$zoom   = 14; // deprecated 4.0.2. In 4.6 was moved outside from shortcode_atts
				$type   = 'm'; // deprecated 4.0.2
				$bubble = ''; // deprecated 4.0.2

				if ( '' === $link ) {
					return null;
				}
				if ( function_exists( 'vc_value_from_safe' ) ) {
					$link = trim( vc_value_from_safe( $link ) );
				}
				$size = str_replace( array( 'px', ' ' ), array( '', '' ), $size );
				$size = intval( $size );
				if ( is_numeric( $size ) ) {
					$link = preg_replace( '/height="[0-9]*"/', 'height="' . $size . '"', $link );
				}

				if ( preg_match( '/^\<iframe/', $link ) ) {
					$block_html .= $link;
				} else {
					$block_html .= '<iframe width="100%" height="' . $size . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $link . '&amp;t=' . $type . '&amp;z=' . $zoom . '&amp;output=embed' . $bubble . '"></iframe>';
				}

			} else {

				if ( function_exists( 'reactor_option' ) ) {
					$api_key = reactor_option( 'gmap_api_key' );
				}

				if ( isset( $api_key ) && ! empty( $api_key ) ) {
					$language = substr( get_locale(), 0, 2 );
					wp_enqueue_script( 'googleMaps', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&language=' . $language, null, null, true );

				}else{
					$language = substr( get_locale(), 0, 2 );
					wp_enqueue_script( 'googleMaps', 'https://maps.googleapis.com/maps/api/js?key=&libraries=places&language=' . $language, null, null, true );
				}
				wp_enqueue_script( 'gmap3', PLUGIN_URL . 'assets/js/frontend/gmap3.min.js' );

				if ( isset( $map_markers ) && ! ( $map_markers == '' ) ) {
					$markers = $map_markers;
				} else {
					$markers = 'greenwich';
				}

				$marker_image_src = 'https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png';
				if ( ! empty( $marker_image ) ) {
					$marker_image_src = wp_get_attachment_image_src( $marker_image, 'full' );
					$marker_image_src = $marker_image_src[0];
				}

				if ( isset( $map_style ) ) {
					$styleVal = $this->crum_get_map_style( $map_style );
				} else {
					$styleVal = false;
				}

				if ( isset( $size ) && ! ( $size == '' ) ) {
					$map_size = $size;
				} else {
					$map_size = '300';
				}

				$unique_id = uniqid( "map_" );

				$block_html .= '<div id="' . esc_attr( $unique_id ) . '" style="height: ' . $map_size . 'px;" class="map-holder ' . $el_class . '">';

				$block_html .= '</div>';


				$block_html .= '
	<script type="text/javascript">
				 jQuery(document).ready(function () {

						 gmap3_init();

						var $map_init;
                        jQuery("#' . esc_attr( $unique_id ) . '").parents(\'.spoiler-overflow\').on("shown.bs.collapse", function (e) {
                            if($map_init != true){
			                    $map_init  = true;
                                gmap3_init();

                                }
                         });

						 function gmap3_init() {
							 jQuery("#' . esc_attr( $unique_id ) . '").gmap3(\'destroy\');

							 jQuery("#' . esc_attr( $unique_id ) . '").gmap3({
								 marker: {
									 values: [';

				$block_html .= '{address: " ' . strip_tags( $markers ) . '" , data:"' . strip_tags( $map_marker_tooltips ) . '", options:{icon: "' . $marker_image_src . '"}}';

				$block_html .= '],
									 events:{
										 click: function(marker, event, context){
											 var map = jQuery(this).gmap3("get"),
												 infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
											 if (infowindow){
												 infowindow.open(map, marker);
												 infowindow.setContent(\'<div class="noscroll infobox">\'+context.data+\'</div>\');
											 } else {
												 jQuery(this).gmap3({
													 infowindow:{
														 anchor:marker,
														 options:{content: \'<div class="noscroll infobox">\'+context.data+\'</div>\'}
													 }
												 });
											 }
										 }
									 }
								 },
							map: {
								 options: {
									zoom: ' . $zoom . ',
									navigationControl: 1,';
				if ( $styleVal ) {
					$block_html .= 'styles:' . $styleVal . ',';
				}
				$block_html .= 'scrollwheel: false,
									streetViewControl: false,
									mapTypeControl: false
								}
							 }
						});
					}
					 });
            </script>';

			}

			return $block_html;

		}

	}

	;

	new Crum_Google_Map;
}
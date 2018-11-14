<?php
function crumina_row_additional_settings() {

	if ( function_exists( 'vc_add_param' ) ) {

        $array_conf_path = vc_path_dir( 'CONFIG_DIR' ). '/containers/shortcode-vc-row.php';
        if(file_exists($array_conf_path)){
            $vc_row_youtube_background_image = array(
                'type'       => 'attach_image',
                'heading'    => esc_html__( 'Youtube background image', 'crum' ),
                'param_name' => 'youtube_background_image',
                'description' => __( 'Background image if video can\'t be played, for example at mobile device', 'js_composer' ),
                'dependency' => array(
                    'element' => 'video_bg',
                    'not_empty' => true,
                ),
            );
            $array = include $array_conf_path;
            array_splice( $array['params'],8,0,array( $vc_row_youtube_background_image ) );
//            WPBMap::leanMap('vc_row',null,null,$array);

            $array['base'] = 'vc_row';
            vc_map($array);
        }

		//Row additional settings
		$vc_row_background_style = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Enable video background with self-hosted video", "crum" ),
			"param_name" => "enable_video_bg",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_background_style );

		$vc_row_background_youtube = array(
			"type"       => "attach_image",
			'heading'    => esc_html__( 'Video poster', 'crum' ),
			'param_name' => 'self_hosted_video_poster',
			'dependency' => array( "element" => "enable_video_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_background_youtube );

		$vc_row_background_hosted_mp4 = array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Link to the video in MP4 Format', 'crum' ),
			'param_name' => 'hosted_video_bg_mp4',
			'dependency' => array( "element" => "enable_video_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_background_hosted_mp4 );

		$vc_row_background_hosted_webm = array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Link to the video in WebM / Ogg Format', 'crum' ),
			'param_name' => 'hosted_video_bg_webm',
			'dependency' => array( "element" => "enable_video_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);
		vc_add_param( 'vc_row', $vc_row_background_hosted_webm );

		$vc_row_background_mute = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Mute video", "crum" ),
			"param_name" => "video_bg_mute",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			'dependency' => array( "element" => "enable_video_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_background_mute );

		$vc_row_background_loop = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Loop video", "crum" ),
			"param_name" => "video_bg_loop",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			'dependency' => array( "element" => "enable_video_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Video background', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_background_loop );

		$vc_row_font_color = array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => esc_html__( "Font Color", "crum" ),
			"param_name"  => "font_color",
			"description" => esc_html__( "Give it a nice paint!", "crum" ),
			'weight'      => 5
		);

		vc_add_param( 'vc_row', $vc_row_font_color );

		$vc_row_overlay_enable = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Enable overlay", "crum" ),
			"param_name" => "enable_overlay",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			"group"      => esc_html__( 'Overlay', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_overlay_enable );

		$vc_row_overlay_image = array(
			"type"       => "attach_image",
			'heading'    => esc_html__( 'Overlay background', 'crum' ),
			'param_name' => 'overlay_image',
			'dependency' => array( "element" => "enable_overlay", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Overlay', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_overlay_image );

		$vc_row_overlay_color = array(
			"type"        => "colorpicker",
			"class"       => "",
			"heading"     => esc_html__( "Color", "crum" ),
			"param_name"  => "overlay_color",
			"description" => esc_html__( "Give it a nice paint!", "crum" ),
			'dependency'  => array( "element" => "enable_overlay", "value" => array( "1" ) ),
			"group"       => esc_html__( 'Overlay', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_overlay_color );

		$vc_row_moving_bg_enable = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Enable moving background effect", "crum" ),
			"param_name" => "enable_moving_bg",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			"group"      => esc_html__( 'Bg effects', 'crum' ),
		);
		vc_add_param( 'vc_row', $vc_row_moving_bg_enable );

		$vc_row_moving_bg_direction = array(
			"type"       => "dropdown",
			"class"      => "",
			"heading"    => esc_html__( "Moving bg direction", "crum" ),
			"param_name" => "moving_bg_direction",
			"value"      => array(
				esc_html__( 'To left', 'crum' )  => 'left',
				esc_html__( 'To right', 'crum' ) => 'right',
			),
			'dependency' => array( "element" => "enable_moving_bg", "value" => array( "1" ) ),
			"group"      => esc_html__( 'Bg effects', 'crum' ),
		);

		vc_add_param( 'vc_row', $vc_row_moving_bg_direction );

		$vc_row_particle_effect = array(
			"type"       => "checkbox",
			"heading"    => esc_html__( "Enable particle background effect", "crum" ),
			"param_name" => "enable_particle_bg",
			"value"      => array( esc_html__( "Yes, please", 'crum' ) => "1" ),
			"group"      => esc_html__( 'Bg effects', 'crum' ),
		);
		vc_add_param( 'vc_row', $vc_row_particle_effect );

		$vc_row_scroll_button = array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Scroll button', 'crum' ),
			'param_name'       => 'scroll_button',
			'edit_field_class' => 'hidden',
		);
		vc_add_param( 'vc_row', $vc_row_scroll_button );

		$vc_row_scroll_id = array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Scroll id', 'crum' ),
			'param_name'       => 'scroll_id',
			'edit_field_class' => 'hidden',
		);
		vc_add_param( 'vc_row', $vc_row_scroll_id );

		$vc_row_scroll_color = array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Scroll color', 'crum' ),
			'param_name'       => 'scroll_color',
			'edit_field_class' => 'hidden',
		);
		vc_add_param( 'vc_row', $vc_row_scroll_color );
	}

}

add_action( 'vc_after_init', 'crumina_row_additional_settings' );
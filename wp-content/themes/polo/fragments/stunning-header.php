<?php
$st_head_style          = reactor_option( 'stunning-header-style' );
$st_head_align          = reactor_option( 'stunning-header-align' );
$st_head_subtitle       = reactor_option( 'st-header-subtitle' );
$st_head_subtitle       = polo_do_multilang_text( $st_head_subtitle );
$st_head_breadcrumbs    = reactor_option( 'stunning-show-breadcrumbs' );
$st_head_amination      = reactor_option( 'stunning-header-animation' );
$stunning_feature_image = reactor_option( 'stunning_feature_image', false );
$st_head_bg_image       = reactor_option( 'st-header-bg-image' );

$st_head_video_embed = reactor_option( 'st-header-embed-video-bg' );
$st_head_video_mp4   = reactor_option( 'st-header-bg-video-mp4' );
$st_head_video_webm  = reactor_option( 'st-header-bg-video-webm' );
$st_head_video_ogg   = reactor_option( 'st-header-bg-video-ogg' );
$stuning_text_color  = reactor_option( 'st-color-text-typography' );
$breadcrumb_style    = reactor_option( 'breadcrumb_style', 'simple' );

$background_color = reactor_option( 'stunning-header-background-color', '' );

$metabox_source = is_singular( 'portfolio' ) ? 'meta_portfolio_heading_options' : 'meta_page_options';

$meta_st_head_style       = reactor_option( 'meta-stunning-header-style', '', $metabox_source );
$meta_st_head_align       = reactor_option( 'meta-stunning-header-align', '', $metabox_source );
$meta_st_head_animation   = reactor_option( 'meta-stunning-header-animation', '', $metabox_source );
$meta_st_head_bg_image    = reactor_option( 'meta-st-header-bg-image', '', $metabox_source );
$meta_st_head_video_embed = reactor_option( 'meta-st-header-embed-video-bg', '', $metabox_source );
$meta_st_head_video_mp4   = reactor_option( 'meta-st-header-bg-video-mp4', '', $metabox_source );
$meta_st_head_video_webm  = reactor_option( 'meta-st-header-bg-video-webm', '', $metabox_source );
$meta_st_head_video_ogg   = reactor_option( 'meta-st-header-bg-video-ogg', '', $metabox_source );
$meta_st_head_subtitle    = reactor_option( 'meta_st_header_subtitle', '', $metabox_source );
$meta_st_head_breadcrumbs = reactor_option( 'meta-stunning-show-breadcrumbs', '', $metabox_source );
$meta_st_head_text_color  = reactor_option( 'meta-color-text-typography', '', $metabox_source );


if ( is_singular( 'post' ) && $stunning_feature_image ) {
	$st_head_bg_image = get_post_thumbnail_id();

}

if ( isset( $meta_st_head_style ) && ! empty( $meta_st_head_style ) && 'default' !== $meta_st_head_style ) {
	$st_head_style = $meta_st_head_style;
}
if ( isset( $meta_st_head_align ) && ! empty( $meta_st_head_align ) && 'default' !== $meta_st_head_align ) {
	$st_head_align = $meta_st_head_align;
}
if ( isset( $meta_st_head_breadcrumbs ) && ! empty( $meta_st_head_breadcrumbs ) && 'default' !== $meta_st_head_breadcrumbs ) {
	$st_head_breadcrumbs = $meta_st_head_breadcrumbs;
}
if ( isset( $meta_st_head_animation ) && ! empty( $meta_st_head_animation ) ) {
	$st_head_amination = $meta_st_head_animation;
}
if ( isset( $meta_st_head_bg_image ) && ! empty( $meta_st_head_bg_image ) ) {
	$st_head_bg_image = $meta_st_head_bg_image;
}
if ( isset( $meta_st_head_video_embed ) && ! empty( $meta_st_head_video_embed ) ) {
	$st_head_video_embed = $meta_st_head_video_embed;
}
if ( isset( $meta_st_head_video_mp4 ) && ! empty( $meta_st_head_video_mp4 ) ) {
	$st_head_video_mp4 = $meta_st_head_video_mp4;
}
if ( isset( $meta_st_head_video_webm ) && ! empty( $meta_st_head_video_webm ) ) {
	$st_head_video_webm = $meta_st_head_video_webm;
}
if ( isset( $meta_st_head_video_ogg ) && ! empty( $meta_st_head_video_ogg ) ) {
	$st_head_video_ogg = $meta_st_head_video_ogg;
}
if ( isset( $meta_st_head_subtitle ) && ! empty( $meta_st_head_subtitle ) ) {
	$st_head_subtitle = $meta_st_head_subtitle;
}
if ( isset( $meta_st_head_text_color ) && ! empty( $meta_st_head_text_color ) ) {
	$stuning_text_color = $meta_st_head_text_color;
}


$args = array(
	'show_browse' => false,
);

if ( 'simple' === $breadcrumb_style ) {
	$args['labels']['home'] = esc_html__( 'Home', 'polo' );
} else {
	$args['labels']['home'] = '<i class="fa fa-home"></i>';
}

if ( 'classic' === $breadcrumb_style ) {
	$args['wrap_begin'] = '<div class="breadcrumb classic text-center">';
	$args['wrap_end']   = '</div';
} elseif ( 'round' === $breadcrumb_style ) {
	$args['wrap_begin'] = '<div class="breadcrumb radius text-center">';
	$args['wrap_end']   = '</div';
} elseif ( 'fancy' === $breadcrumb_style ) {
	$args['wrap_begin'] = '<div class="breadcrumb fancy text-center">';
	$args['wrap_end']   = '</div';
}

$output = $bg_img_style = '';
$data_attribute = $section_style = $animation_class = '';

if ( ! empty( $st_head_bg_image ) ) {
	$bg_img_style = 'style="background-position: center top; background-image:url(' . wp_get_attachment_url( $st_head_bg_image ) . ');';
}
if ( $st_head_style == 'default' && ! empty( $background_color ) ) {
	$bg_img_style .= 'background-color: ' . $background_color . ';';
}
$bg_img_style .= '"';


$classes = array();

if ( ! empty( $meta_st_head_text_color ) && ! empty( $stuning_text_color ) && 'dark' === $st_head_style || 'parallax' === $st_head_style || 'colored' === $st_head_style || 'video' === $st_head_style || 'extended' === $st_head_style ) {
	$classes[] .= 'text-light';
}

if ( 'pattern' === $st_head_style ) {
	$classes[] = 'page-title-pattern';
} elseif ( 'colored' === $st_head_style ) {
	$classes[] = 'background-colored ';
} elseif ( 'dark' == $st_head_style ) {
	$classes[] = 'background-dark';
} elseif ( 'parallax' === $st_head_style ) {
	$classes[]     = 'page-title-parallax  background-overlay-dark';
	$section_style = $bg_img_style;
} elseif ( 'extended' === $st_head_style ) {
	$classes[]     = 'page-title-extended page-title-parallax ';
	$section_style = $bg_img_style;
} elseif ( 'video' === $st_head_style ) {
	$classes[] = 'page-title-video';
	if ( ! empty( $st_head_video_mp4 ) || ! empty( $st_head_video_webm ) || ! empty( $st_head_video_ogg ) && empty( $st_head_video_embed ) ) {
		$data_attribute = 'data-vide-bg="';
		if ( isset( $st_head_video_mp4 ) && ! empty( $st_head_video_mp4 ) ) {
			$data_attribute .= 'mp4: ' . $st_head_video_mp4 . ',';
		}
		if ( isset( $st_head_video_webm ) && ! empty( $st_head_video_webm ) ) {
			$data_attribute .= 'webm: ' . $st_head_video_webm . ',';
		}
		if ( isset( $st_head_video_ogg ) && ! empty( $st_head_video_ogg ) ) {
			$data_attribute .= ' ogv: ' . $st_head_video_ogg . '';
		}
		$data_attribute .= '" data-vide-options="position: 0% 50%"';
	}
} else {
	$classes[] = 'page-title-parallax';
	if ( ! ( 'none' === $st_head_amination ) ) {
		$animation_class = 'animated visible ' . $st_head_amination;
	}
	$section_style = $bg_img_style;
}
if ( 'right' === $st_head_align ) {
	$classes[] = 'page-title-right';
} elseif ( 'center' == $st_head_align ) {
	$classes[] = 'page-title-center';
} else {
	$classes[] = ' page-title-left';
}

$output .= '<section id="page-title" class="' . implode( ' ', $classes ) . '" ' . $data_attribute . ' ' . $section_style . ' >';

if ( ! empty( $bg_img_style ) ) {
	$output .= '<div class="parallax-bg-image" ' . $bg_img_style . '></div>';
}

if ( isset( $st_head_video_embed ) && ! empty( $st_head_video_embed ) && ( 'video' === $st_head_style ) ) {
	$output .= '<div class="stunning-header-video-embed">';

	$embed = wp_oembed_get( $st_head_video_embed );
	if ( ! ( false === $embed ) ) {
		if ( ! ( false === strstr( $embed, '?feature=oembed' ) ) && ! ( false === strstr( $embed, 'youtube' ) ) ) {
			$embed = str_replace( "?feature=oembed", "?feature=oembed&autoplay=1", $embed );
		} elseif ( ! ( false === strstr( $embed, 'vimeo' ) ) ) {
			$embed = wp_oembed_get( $st_head_video_embed, array( 'autoplay' => true, 'automute' => true ) );
		}
	}
	$output .= $embed;

	$output .= '</div>';
}


if ( isset( $stuning_text_color ) && ! empty( $stuning_text_color ) ) {
	$add_class = 'custom-heading-colored';
} else {
	$add_class = '';
}

$output .= '<div class="container ' . $add_class . '">';
$output .= '<div class="page-title col-md-8 ' . $animation_class . '">';

if ( ( function_exists( 'is_woocommerce' ) ) && ( is_woocommerce() || is_page( 'store' ) || is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() || is_post_type_archive( 'product' ) ) ) {
	$output .= '<h1>' . woocommerce_page_title( false ) . '</h1>';
} elseif ( is_home() ) {
	$home_title = reactor_option( 'home_title', esc_html__( 'Latest Posts', 'polo' ) );
	if ( function_exists( 'icl_object_id' ) ) {
		$current_language = ICL_LANGUAGE_CODE;
		$home_title       = $home_title[ $current_language ];
	}
	if ( is_array( $home_title ) ) {
		$home_title = array_slice( $home_title, 0, 1 );
		$home_title = implode( $home_title );
	}
	$output .= '<h1>' . $home_title . '</h1>';
} elseif ( is_author() ) {
	$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
	$output  .= '<h1>' . esc_html__( 'Posts by: ', 'polo' ) . $curauth->user_nicename . '</h1>';
} elseif ( is_search() ) {
	$output .= '<h1>' . esc_html__( 'Search results page', 'polo' ) . '</h1>';
} elseif ( is_tag() ) {
	$output .= '<h1>' . single_tag_title( '', false ) . '</h1>';
} elseif ( is_category() ) {
	$output .= '<h1>' . single_cat_title( '', false ) . '</h1>';
} elseif ( is_tax() ) {
	$output .= '<h1>' . esc_html__( 'Category', 'polo' ) . ': ' . single_term_title( '', false ) . '</h1>';
} elseif ( is_archive() ) {
	if ( is_day() ) {
		$output .= '<h1>' . esc_html__( 'Daily Archives:', 'polo' ) . get_the_date() . '</h1>';
	} elseif ( is_month() ) {
		$output .= '<h1>' . esc_html__( 'Monthly Archives:', 'polo' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'polo' ) ) . '</h1>';
	} elseif ( is_year() ) {
		$output .= '<h1>' . esc_html__( 'Yearly Archives:', 'polo' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'polo' ) ) . '</h1>';
	} else {
		$output .= '<h1>' . post_type_archive_title( '', false ) . '</h1>';
	}
} else {
	$output .= '<h1>' . get_the_title( get_the_ID() ) . '</h1>';
}

if ( is_singular( 'post' ) ) {
	$output .= polo_post_info();
} elseif ( is_author() ) {
	$author_description = get_the_author_meta( 'description' );
	if ( ! empty( $author_description ) ) {
		$output .= '<span>' . get_the_author_meta( 'description' ) . '</span>';
	}
} elseif ( isset( $st_head_subtitle ) && ! ( empty( $st_head_subtitle ) ) ) {
	$output .= '<span>' . $st_head_subtitle . '</span>';
}
$output .= '</div>';//.page-title col-md-8
if ( 'false' !== $st_head_breadcrumbs ) {
	$output .= '<div class="breadcrumb col-md-4 ' . $animation_class . '">';
	ob_start(); ?>
    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
		<?php if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		} else {
			reactor_breadcrumbs( $args );
		} ?>
    </div>
	<?php $output .= ob_get_clean();
	$output       .= '</div>';//.breadcrumb col-md-4
}
$output .= '</div>';//.container

$output .= '</section>';//#page-title

echo $output;



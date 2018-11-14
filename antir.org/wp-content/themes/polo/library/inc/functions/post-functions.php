<?php
/*
 * Functions for posts and blog
 */
?>
<?php

/**
 * @param string $width
 * @param string $height
 *
 * @return string
 */
function polo_do_feature_gallery($width  = '580',$height = '350') {
	$output = '';

	$post_meta = get_post_meta( get_the_ID(), 'post-format-gallery-feature', true );
	if ( isset( $post_meta['post_gallery_feature'] ) && ! empty( $post_meta['post_gallery_feature'] ) ) {
		$post_meta_gallery = $post_meta['post_gallery_feature'];
	}

	$gallery_style      = reactor_option( 'gallery_type' );
	$meta_gallery_style = reactor_option( 'gallery_type', '', 'post-format-gallery-feature' );

	if ( isset( $meta_gallery_style ) && ! ( 'default' === $meta_gallery_style ) ) {
		$gallery_style = $meta_gallery_style;
	}
	if ( ! ( is_singular( 'post' ) ) ) {
		$gallery_style = 'slider';
	}
	if ( isset( $post_meta_gallery ) && ! empty( $post_meta_gallery ) ) {

		$post_meta_gallery = explode( ',', $post_meta_gallery );

		if ( 'slider' === $gallery_style ) {

			$output .= '<div class="post-slider">';
			$output .= '<div class="carousel" data-carousel-col="1">';

			foreach ( $post_meta_gallery as $single_image ) {
				$gallery_img_src = wp_get_attachment_image_src( $single_image, 'full' );
				$gallery_img_url = polo_theme_thumb( $gallery_img_src[0], $width, $height, true, 'c' );
				$output .= '<img alt="image" src="' . esc_url( $gallery_img_url ) . '" title="' . esc_attr( get_the_title( $single_image ) ) . '">';
			}
			$output .= '</div>';//.carousel
			$output .= '</div>';//.post-slider

		} else {

			$output .= '<div class="post-image">';

			$output .= '<div id="isotope" class="isotope col-small-margins" data-isotope-mode="masonry" data-isotope-col="4" data-lightbox-type="gallery">';

			$i = 0;

			foreach ( $post_meta_gallery as $image_id ) {
				$isotope_img_src = wp_get_attachment_image_src( $image_id, 'full' );
				$isotope_img_url = polo_theme_thumb( $isotope_img_src[0], '400', '267', true, 'c' );

				if ( 1 === $i ) {
					$class_large = 'large-item';
				} else {
					$class_large = '';
				}

				$output .= '<div class="isotope-item ' . esc_attr( $class_large ) . '">';
				$output .= '<div class="effect effect-default">';
				$output .= '<img src="' . esc_url( $isotope_img_url ) . '" alt="">';
				$output .= '<div class="image-box-content">';
				$output .= '<p>';
				$output .= '<a href="' . esc_url( $isotope_img_src[0] ) . '" title="' . esc_attr( get_the_time( get_the_ID() ) ) . '" data-lightbox="gallery-item"><i class="fa fa-expand"></i></a>';
				$output .= '</p>';
				$output .= '</div>';//.image-box-content
				$output .= '</div>';//.effect effect-default
				$output .= '</div>';//.isotope-item

				$i ++;
				if ( 0 == $i % 5 ) {
					$i = 0;
				}
			}

			$output .= '</div>';//#isotope

			$output .= '</div>';//.post-image

		}

	} else {
		$output .= polo_do_feature_standard( get_the_ID() );
	}

	return $output;

}


/**
 * @param        $post_id
 * @param string $height
 * @param string $width
 *
 * @return string
 */
function polo_do_feature_resized( $post_id, $width = '595', $height = '350'  ) {

	$output = '';

	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( ! empty( $post_thumbnail_id ) ) {
		$thumb     = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		$image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 't' );
		if ( isset( $image_url ) && ! ( false === $image_url ) ) {
			$output .= '<div class="post-image">';
			$output .= '<img src="'.$image_url.'" alt="">';
			$output .= '</div>';//.post-image
		}
	}

	return $output;

}


/**
 * @param        $post_id
 * @param string $height
 * @param string $width
 *
 * @return string
 */
function polo_do_feature_standard( $post_id ) {

	$output = '';
		if ( has_post_thumbnail( $post_id ) ) {
			$output .= '<div class="post-image">';
			ob_start();
			the_post_thumbnail('large');
			$output .= ob_get_clean();
			$output .= '</div>';//.post-image
		}

	return $output;

}

/**
 * @return mixed|string
 */
function polo_do_feature_audio() {
	$post_meta = get_post_meta( get_the_ID(), 'post-format-audio-feature', true );
	if ( isset( $post_meta['post_audio_feature'] ) && ! empty( $post_meta['post_audio_feature'] ) ) {
		$post_audio_embed = $post_meta['post_audio_feature'];
	}
	if ( isset( $post_meta['post_audio_feature_self_hosted'] ) && ! empty( $post_meta['post_audio_feature_self_hosted'] ) ) {
		$post_audio_self_hosted = $post_meta['post_audio_feature_self_hosted'];
	}
	$feature_output = '';
	if ( isset( $post_audio_embed ) && ! empty( $post_audio_embed ) ) {
		$feature_output .= '<div class="post-audio">' . apply_filters( 'the_content', $post_audio_embed ) . '</div>';
	} elseif ( isset( $post_audio_self_hosted ) && ! empty( $post_audio_self_hosted ) ) {
		$feature_output .= '<div class="post-audio">' . do_shortcode( '[audio src="' . esc_url( $post_audio_self_hosted ) . '"]' ) . '</div>';
	} else {
		$feature_output .= polo_do_feature_standard( get_the_ID() );
	}

	return $feature_output; // WPCS: XSS OK.
}

/**
 * @return mixed|string
 */
function polo_do_feature_video() {
	$thumb = $feature_output = '';

	if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
	}

	$post_meta = get_post_meta( get_the_ID(), 'post-format-video-feature', true );
	if ( isset( $post_meta['post_video_feature'] ) && ! empty( $post_meta['post_video_feature'] ) ) {
		$post_video_embed = $post_meta['post_video_feature'];
	}
	if ( isset( $post_meta['post_video_feature_mp4'] ) && ! empty( $post_meta['post_video_feature_mp4'] ) ) {
		$post_video_mp4 = $post_meta['post_video_feature_mp4'];
	}
	if ( isset( $post_meta['post_video_feature_mp4_webm'] ) && ! empty( $post_meta['post_video_feature_mp4_webm'] ) ) {
		$post_video_webm = $post_meta['post_video_feature_mp4_webm'];
	}

	if ( isset( $post_video_embed ) && ! empty( $post_video_embed ) ) {

		$feature_output = apply_filters( 'the_content', $post_video_embed );

	} elseif ( isset( $post_video_mp4 ) && ! empty( $post_video_mp4 ) && isset( $post_video_webm ) && ! empty( $post_video_webm ) ) {

		$feature_output = do_shortcode( '[video src="' . esc_url( $post_video_mp4 ) . '"  webm="' . esc_url( $post_video_webm ) . '" poster="' . esc_url( $thumb[0] ) . '"]' );

	} elseif ( isset( $post_video_mp4 ) && ! empty( $post_video_mp4 ) ) {

		$feature_output = do_shortcode( '[video src="' . esc_url( $post_video_mp4 ) . '" poster="' . esc_url( $thumb[0] ) . '"]' );

	} elseif ( isset( $post_video_webm ) && ! empty( $post_video_webm ) ) {

		$feature_output = do_shortcode( '[video src="' . esc_url( $post_video_webm ) . '" poster="' . esc_url( $thumb[0] ) . '"]' );

	} elseif ( ! empty( $thumb ) ) {

		$feature_output = '<img src="' . polo_theme_thumb( $thumb[0], '595', '300', true, 'c' ) . '" alt="' . get_the_title( get_the_ID() ) . '">';

	}

	return $feature_output; // WPCS: XSS OK.
}

/**
 * @param $post_id
 *
 * @return string
 */
function polo_do_post_feature( $post_id ) {

	$output = '';

	if ( has_post_format( 'gallery', $post_id ) ) {

		$output .= polo_do_feature_gallery( 1200 , 600);

	} elseif ( has_post_format( 'audio', $post_id ) ) {

		$output .= polo_do_feature_audio();

	} elseif ( has_post_format( 'video', $post_id ) ) {

		$output .= '<div class="post-video">';

		$output .= polo_do_feature_video();

		$output .= '</div>';

	} else {
		$output .= polo_do_feature_standard( $post_id );
	}

	return $output;

}

if ( ! function_exists( 'polo_post_info' ) ) {

	/**
	 * @param array $args
	 *
	 * @return string
	 */
	function polo_post_info( $args = array() ) {

		$output = '';

		$defaults = array(
			'show_author'   => true,
			'show_category' => true,
		);
		$args     = wp_parse_args( $args, $defaults );

		$output .= '<div class="post-info">';

		if ( true === $args['show_author'] ) {
			$author = get_user_by( 'ID', get_post_field( 'post_author', get_the_ID() ) );

			$output .= '<span class="post-autor">';
			$output .= esc_html__( 'Post by: ', 'polo' );
			$output .= '<a href="' . esc_url( get_author_posts_url( $author->ID ) ) . '">';
			$output .= $author->display_name;
			$output .= '</a>';
			$output .= '</span>';

		}

		if ( true === $args['show_category'] ) {
			$categories = wp_get_post_categories( get_the_ID() );

			$output .= '<span class="post-category">';
			$output .= ' ' . esc_html__( 'in', 'polo' ) . ' ';
			if ( isset( $categories ) && ! empty( $categories ) ) {
				foreach ( $categories as $single_category ) {
					$cat = get_category( $single_category );

					$output .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . $cat->name . ' </a>';

				}
			}
			$output .= '</span>';

		}

		$output .= '</div>';

		return $output;

	}

}

if ( ! ( function_exists( 'polo_post_meta' ) ) ) {

	/**
	 * @param array $args
	 *
	 * @return string
	 */
	function polo_post_meta( $args = array() ) {

		$output = '';

		$defaults = array(
			'show_date'     => true,
			'show_comments' => true,
			'show_share'    => false
		);

		if ( function_exists( 'crum_soc_networks_list' ) ) {
			$defaults['show_share'] = true;
		}

		$args     = wp_parse_args( $args, $defaults );

		$output .= '<div class="post-meta">';

		if ( true === $args['show_date'] ) {

			$output .= '<div class="post-date">';
			$output .= '<span class="post-date-day">' . get_the_date( 'd', get_the_ID() ) . '</span>' . ' ';
			$output .= '<span class="post-date-month">' . get_the_date( 'M', get_the_ID() ) . '</span>' . ' ';
			$output .= '<span class="post-date-year">' . get_the_date( 'Y', get_the_ID() ) . '</span>';
			$output .= '</div>';

		}

		if ( true === $args['show_comments'] ) {

			$output .= '<div class="post-comments">';
			$output .= '<a href="' . esc_url(get_comments_link( get_the_ID() )) . '">';
			$output .= '<i class="fa fa-comments-o"></i>';
			$output .= '<span class="post-comments-number"> ' . get_comments_number( get_the_ID() ) . '</span>';
			$output .= '</a>';
			$output .= '</div>';

		}

		if ( true === $args['show_share'] ) {
			$newtworks = reactor_option( 'share_soc_networks', array( 'twitter', 'facebook', 'gplus' ) );
			if ( ! empty( $newtworks ) ) {
				wp_enqueue_script( 'crum-likely' );
				$output .= '<div class="post-comments"><div class="likely" data-url="' . get_the_permalink( get_the_ID() ) . '" data-title="' . get_the_title( get_the_ID() ) . '"  >';
				foreach ( $newtworks as $social ) {
					if ( 'pinterest' === $social ) {
						$output .= '<div class="pinterest" data-media="' . get_the_post_thumbnail_url( get_the_ID(), 'full' ) . '"></div>';
					} else {
						$output .= '<div class="' . esc_attr( $social ) . '"></div>';
					}
				}
				$output .= '</div></div>';
			}
		}

		$output .= '</div>';//.post-meta
		return $output;

	}

}

if ( ! function_exists( 'polo_post_text' ) ) {
	/**
	 * Trim excerpt length.
	 *
	 * @param int $post_id        Id of post.
	 * @param int $excerpt_length Length of excerpt.
	 *
	 * @return string
	 */
	function polo_post_text( $post_id, $excerpt_length = 20 ) {

		$post_excerpt = get_post_field( 'post_excerpt', $post_id );
		if ( isset( $post_excerpt ) && ! ( empty( $post_excerpt ) ) ) {
			$post_content = $post_excerpt;
		} else {
			$post_content = strip_tags( get_post_field( 'post_content', $post_id ) );
		}

		$post_content = strip_shortcodes( $post_content );

		$post_text = wp_trim_words( $post_content, $excerpt_length );

		return $post_text;

	}
}

if ( ! function_exists( 'polo_post_tags' ) ) {
	function polo_post_tags() {

		$themecheck_tmp = get_the_tag_list();

		$output = '';

		$tags = wp_get_post_tags( get_the_ID() );

		$output .= '<div class="post-info">';
		$output .= '<span class="post-category">';
		$output .= ' ' . esc_html__( 'Tags:', 'polo' ) . ' ';
		if ( isset( $tags ) && ! empty( $tags ) ) {
			foreach ( $tags as $single_tag ) {
				$output .= '<a href="' . esc_url( get_tag_link( $single_tag->term_id ) ) . '">' . $single_tag->name . ' </a>';
			}
		}
		$output .= '</span>';
		$output .= '</div>';

		echo apply_filters( 'polo_post_tags', $output );

	}
}
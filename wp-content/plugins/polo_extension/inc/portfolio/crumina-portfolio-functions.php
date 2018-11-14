<?php
add_filter( 'single_template', 'crumina_portfolio_single_template' );

function crumina_portfolio_single_template( $single ) {
	global $wp_query, $post;

	$post_type = 'portfolio';

	//Single Portfolio template
	if ( is_singular( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/crum_override/portfolio-single.php' ) ) {
			return get_stylesheet_directory() . '/crum_override/portfolio-single.php';
		} elseif ( file_exists( PLUGIN_PATH . 'inc/portfolio/templates/portfolio-single.php' ) ) {
			return PLUGIN_PATH . 'inc/portfolio/templates/portfolio-single.php';
		}
	}


	return $single;
}

add_filter('template_include','crumina_portfolio_taxonomy_templates');

function crumina_portfolio_taxonomy_templates($template){
	$post_type = 'portfolio';
	//Portfolio category template
	if ( is_tax( 'portfolio-category' ) ) {
		if ( file_exists( get_stylesheet_directory() . '/crum_override/portfolio-category.php' ) ) {
			return get_stylesheet_directory() . '/crum_override/portfolio-category.php';
		} elseif ( file_exists( PLUGIN_PATH . 'inc/portfolio/templates/portfolio-category.php' ) ) {
			return PLUGIN_PATH . 'inc/portfolio/templates/portfolio-category.php';
		}
	}
	//Portfolio archive template
	if ( is_post_type_archive( $post_type ) ) {
		if ( file_exists( get_stylesheet_directory() . '/crum_override/portfolio-archive.php' ) ) {
			return get_stylesheet_directory() . '/crum_override/portfolio-archive.php';
		} elseif ( file_exists( PLUGIN_PATH . 'inc/portfolio/templates/portfolio-archive.php' ) ) {
			return PLUGIN_PATH . 'inc/portfolio/templates/portfolio-archive.php';
		}
	}

	return $template;

}

/**
 * @param $icons
 *
 * @return string
 */
function crumina_do_portfolio_share( $icons ) {
	$output = '';

	wp_enqueue_script( 'crum-sharer' );
	$post_thumbnail_id  = get_post_thumbnail_id( get_the_ID() );
	$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

	$output .= '<h4>' . esc_html__( 'Share this post', 'polo_extension' ) . '</h4>';
	$output .= '<div class="social-icons social-icons-border m-t-10">';

	$output .= '<ul>';

	foreach ( $icons as $single_soc_network => $name ) {
		if ( 'google' === $single_soc_network ) {
			$output .= '<li class="social-google"><a class="sharer" data-sharer="googleplus" data-url="' . get_the_permalink( get_the_ID() ) . '"><i class="fa fa-google-plus"></i></a></li>';
		} else {
			$output .= '<li class="social-' . $single_soc_network . '"><a class="sharer" data-image="' . esc_url( $post_thumbnail_url ) . '" data-sharer="' . $single_soc_network . '" data-url="' . get_the_permalink( get_the_ID() ) . '"><i class="fa fa-' . $single_soc_network . '"></i></a></li>';
		}
	}

	$output .= '</ul>';

	$output .= '</div>';//.social-icons

	return $output;
}


/**
 * @param        $args
 * @param string $add_class
 *
 * @return string
 */
function crumina_do_portfolio_info( $args, $add_class = '' ) {

	$output = '';

	if ( 'left' === $args['align'] || 'right' === $args['align'] ) {

		if ( isset( $args['add_info_title'] ) && ! empty( $args['add_info_title'] ) ) {
			$output .= '<div class="heading-title-simple heading-title-border-bottom">';
			$output .= '<h4>' . $args['add_info_title'] . '</h4>';
			$output .= '</div>';//.heading-title-simple
		}

		$output .= '<div class="portfolio-client-info">';

		if ( isset( $args['add_info'] ) && ! empty( $args['add_info'] ) ) {
			$output .= '<ul class="list">';

			foreach ( $args['add_info'] as $single_line ) {
				$output .= '<li><span>' . $single_line['title'] . '</span>' . polo_linkify( $single_line['description'], $protocols = array( 'http', 'https', 'mail' ), $attributes = array( 'target' => '_blank' ) ) . '</li>';
			}

			$output .= '</ul>';
		}
		$output .= '</div>';
		if ( isset( $args['description_title'] ) && ! empty( $args['description_title'] ) ) {
			$output .= '<hr class="space-xs">';
			$output .= '<h4>' . $args['description_title'] . '</h4>';
		}

		if ( isset( $args['portfolio_description'] ) && ! empty( $args['portfolio_description'] ) ) {
			$output .= '<div class="portfolio-client-description">';
			$output .= $args['portfolio_description'];
			$output .= '</div>';//.portfolio-client-description
		}

		$output .= '<hr class="space-xs">';

		if ( ! ( true === $args['hide_share'] ) && isset( $args['soc_networks']['enabled'] ) && ! empty( $args['soc_networks']['enabled'] ) ) {

			$output .= crumina_do_portfolio_share( $args['soc_networks']['enabled'] );
		}

	} else {
		$output .= '<div class="row ' . esc_attr( $add_class ) . '">';

		$output .= '<div class="col-md-4">';

		if ( isset( $args['add_info_title'] ) && ! empty( $args['add_info_title'] ) ) {
			$output .= '<div class="heading-title-simple heading-title-border-bottom">';
			$output .= '<h4>' . $args['add_info_title'] . '</h4>';
			$output .= '</div>';//.heading-title-simple
		}

		$output .= '<div class="portfolio-client-info">';

		if ( isset( $args['add_info'] ) && ! empty( $args['add_info'] ) ) {
			$output .= '<ul class="list">';

			foreach ( $args['add_info'] as $single_line ) {
				$output .= '<li><span>' . $single_line['title'] . '</span>' . polo_linkify( $single_line['description'], $protocols = array( 'http', 'https', 'mail' ), $attributes = array( 'target' => '_blank' ) ) . '</li>';
			}

			$output .= '</ul>';
		}
		$output .= '</div>';

		$output .= '<hr class="space-xs">';

		if ( ! ( true === $args['hide_share'] ) && isset( $args['soc_networks']['enabled'] ) && ! empty( $args['soc_networks']['enabled'] ) ) {

			$output .= crumina_do_portfolio_share( $args['soc_networks']['enabled'] );
		}

		$output .= '</div>';//.col-md-4

		$output .= '<div class="col-md-8 col-no-margin">';

		if ( isset( $args['description_title'] ) && ! empty( $args['description_title'] ) ) {
			$output .= '<div class="heading-title-simple heading-title-border-bottom">';
			$output .= '<h4>' . $args['description_title'] . '</h4>';
			$output .= '</div>';//.heading-title-simple
		}

		if ( isset( $args['portfolio_description'] ) && ! empty( $args['portfolio_description'] ) ) {
			$output .= '<div class="portfolio-client-description">';
			$output .= $args['portfolio_description'];
			$output .= '</div>';//.portfolio-client-description
		}

		$output .= '</div>';//.col-md-8

		$output .= '</div>';//.row

	}

	return $output;

}

/**
 * Previous/next buttons for single portfolio
 */
function crumina_portfolio_prev_next() {
	$output = '';

	$main_portfolio_page = cs_get_option('portfolio_main_page');


	ob_start();
	next_post_link( '%link', '<span>' . esc_html__( 'Next', 'polo_extension' ) . '<i class="fa fa-chevron-right"></i></span>' );
	$prev_post = ob_get_clean();

	ob_start();
	previous_post_link( '%link', '<span><i class="fa fa-chevron-left"></i>' . esc_html__( 'Previous', 'polo_extension' ) . '</span>' );
	$next_post = ob_get_clean();

	$output .= '<div class="pager pager-modern text-center">';
	if ( isset( $next_post ) && ! empty( $next_post ) ) {
		$output .= str_replace( '<a ', '<a class="pager-next"', $next_post );
	}
	$output .= '<a class="pager-all" href="' . esc_url($main_portfolio_page) . '"><span><i class="fa fa-th"></i></span></a>';
	if ( isset( $prev_post ) && ! empty( $prev_post ) ) {
		$output .= str_replace( '<a ', '<a class="pager-prev"', $prev_post );
	}
	$output .= '</div>';

	if ( is_singular( 'portfolio' ) ) {
		echo $output;
	}

}

add_action( 'polo_content_after', 'crumina_portfolio_prev_next' );

/**
 * @param $image_ids
 * @param $gallery_style
 *
 * @return string
 */
function crumina_portfolio_gallery( $image_ids, $gallery_style ) {

	$image_ids = explode( ',', $image_ids );

	$output = '';

	if ( 'slider' === $gallery_style ) {

		$output .= '<div class="carousel portfolio-basic-image" data-carousel-col="1">';

		foreach ( $image_ids as $single_image ) {
			$image_full = wp_get_attachment_image_src( $single_image, 'full' );
			$image_url  = polo_theme_thumb( $image_full[0], '1140', '680', true, 'c' );
			$output .= '<img alt="image" src="' . esc_url( $image_url ) . '">';
		}

		$output .= '</div>';//.carousel


	} else {

		$output .= '<div id="isotope" class="isotope portfolio-basic-image" data-lightbox-type="gallery" data-isotope-item-space="0" data-isotope-mode="masonry" data-isotope-col="4" data-isotope-item=".portfolio-item">';

		$i = 0;

		foreach ( $image_ids as $single_image ) {
			$image_full = wp_get_attachment_image_src( $single_image, 'full' );
			$image_url  = polo_theme_thumb( $image_full[0], '600', '400', true, 'c' );

			if ( 1 === $i ) {
				$class = 'large-item';
			} else {
				$class = '';
			}

			$output .= '<div class="portfolio-item ' . $class . '">';
			$output .= '<div class="portfolio-image effect effect-default"><img src="' . $image_url . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<p>';
			$output .= '<a title="Your image title here!" data-lightbox="gallery-item" href="' . $image_full[0] . '"><i class="fa fa-expand"></i></a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
			$i ++;
			if ( 5 === $i ) {
				$i = 0;
			}
		}

		$output .= '</div>';//#isotope

	}

	return $output;

}
if ( ! function_exists( 'polo_do_multilang_text' ) ) {
	function polo_do_multilang_text( $multilang_text ) {

		if ( function_exists( 'icl_object_id' ) ) {
			$current_language = ICL_LANGUAGE_CODE;
			if ( isset($multilang_text[$current_language]) && !empty($multilang_text[$current_language]) ) {
				$multilang_text = $multilang_text[ $current_language ];
			}
		}

		if ( is_array( $multilang_text ) ) {
			$multilang_text = array_slice( $multilang_text, 0, 1 );
			$multilang_text = implode( $multilang_text );
		}

		return $multilang_text;
	}
}
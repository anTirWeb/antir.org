<?php
if ( ! ( function_exists( 'portfolio_hover_effects' ) ) ) {

	function portfolio_hover_effects( $effect_name, $thumb, $folio_excerpt, $width = '600', $height = '400' ) {
        
        $image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 'c' );

		$taxonomy             = 'portfolio-category';
		$portfolio_categories = get_the_terms( get_the_ID(), $taxonomy );

		$categories_names = array();
		if ( ! is_wp_error( $portfolio_categories ) && is_array( $portfolio_categories ) ) {
			$i = 1;
			foreach ( $portfolio_categories as $single_category ) {
				if ( $i <= 2 ) {
					$categories_names[] = '<a href="' . esc_url( get_term_link( $single_category->term_id ) ) . '" style="color:#fff">' . $single_category->name . '</a>';
				}
				$i ++;
			}
		}
		$categories_names = implode( ' / ', $categories_names );

		$output = '';

		if ( 'alea' === $effect_name ) {
			if ( isset( $folio_excerpt ) && ! empty( $folio_excerpt ) ) {
				$folio_excerpt = wp_trim_words( $folio_excerpt, 10 );
			}

			$output .= '<div class="image-box effect alea"> <img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3></a>';
			$output .= wpautop( str_replace( '&hellip;', '', $folio_excerpt ) );
			$output .= '</div>';
			$output .= '<a class="bg-span" href="' . esc_url(get_the_permalink( get_the_ID() )) . '"></a>';
			$output .= '</div>';

		} elseif ( 'ariol' === $effect_name ) {
			if ( isset( $folio_excerpt ) && ! empty( $folio_excerpt ) ) {
				$folio_excerpt = wp_trim_words( $folio_excerpt, 10 );
			}
			$output .= '<div class="image-box effect ariol"> <img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<a href="' . esc_url(get_the_permalink( get_the_ID() )) . '"><h3>' . get_the_title( get_the_ID() ) . '</h3></a>';
			$output .= wpautop( str_replace( '&hellip;', '', $folio_excerpt ) );
			$output .= '</div>';
			$output .= '</div>';
		} elseif ( 'dia' === $effect_name ) {
			$output .= '<div class="image-box effect dia">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url(get_the_permalink( get_the_ID() )) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'dorian' === $effect_name ) {

			$output .= '<div class="image-box effect dorian">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'emma' === $effect_name ) {

			$output .= '<div class="image-box effect emma">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p><i class="fa fa-tag"></i> ' . $categories_names . '</p>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'erdi' === $effect_name ) {

			$output .= '<div class="image-box effect erdi">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'juna' === $effect_name ) {

			$output .= '<div class="image-box effect juna">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p><i class="fa fa-tag"></i> ' . $categories_names . '</p>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'resa' === $effect_name ) {

			$output .= '<div class="image-box effect resa">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'retro' === $effect_name ) {

			$output .= '<div class="image-box effect retro">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'victor' === $effect_name ) {

			if ( isset( $folio_excerpt ) && ! empty( $folio_excerpt ) ) {
				$folio_excerpt = wp_trim_words( $folio_excerpt, 10 );
			}

			$output .= '<div class="image-box effect victor">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<a href="' . esc_url(get_the_permalink( get_the_ID() )) . '"><h3>' . get_the_title( get_the_ID() ) . '</h3></a>';
			$output .= wpautop( str_replace( '&hellip;', '', $folio_excerpt ) );
			$output .= '</div>';
			$output .= '</div>';

		} elseif ( 'bleron' === $effect_name ) {

			$output .= '<div class="image-box effect bleron">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="">';
			$output .= '<div class="image-box-content">';
			$output .= '<p class="image-box-links">';
			$output .= '<a href="' . esc_url( get_the_permalink( get_the_ID() ) ) . '">' . esc_html__( 'More details', 'polo' ) . '</a>';
			$output .= '<a href="' . esc_url( $thumb[0] ) . '" data-lightbox-type="image" title="' . get_the_title( get_the_ID() ) . '">' . esc_html__( 'View Larger', 'polo' ) . '</a>';
			$output .= '</p>';
			$output .= '</div>';
			$output .= '</div>';

		}


		echo apply_filters( 'polo_portfolio_hover', $output );

	}

}
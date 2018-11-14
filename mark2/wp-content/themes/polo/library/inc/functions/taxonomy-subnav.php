<?php
/**
 * Taxonomy Sub Nav
 * list taxonomy terms as a submenu
 */

if ( ! function_exists( 'polo_category_submenu' ) ) {
	function polo_category_submenu( $args = '' ) {

		$defaults = array(
			'taxonomy'     => 'category',
			'all_link'     => esc_html__( 'All', 'polo' ),
			'terms_args'   => '',
			'filter_style' => 'default',
			'show_active'  => true,
		);
		$args     = wp_parse_args( $args, $defaults );

		$count = 0;
		$terms = get_terms( $args['taxonomy'], $args['terms_args'] ) ? get_terms( $args['taxonomy'], $args['terms_args'] ) : '';
		$count = count( $terms );

		if ( 'classic' === $args['filter_style'] ) {
			$style_class = 'portfolio-filter-classic';
		} elseif ( 'transparent' === $args['filter_style'] ) {
			$style_class = 'portfolio-filter-transparent';
		} elseif('transparent_mb0' === $args['filter_style']){
			$style_class = 'portfolio-filter-transparent m-b-0';
		}else {
			$style_class = '';
		}

		if ( $count > 1 ) {

			$output = '';

			if ( true === $args['show_active'] ) {
				$output .= '<div class="filter-active-title">' . esc_html__( 'Show All', 'polo' ) . '</div>';
			}

			$output .= '<ul class="portfolio-filter ' . $style_class . '" id="portfolio-filter" data-isotope-nav="isotope">';

			$output .= '<li class="ptf-active" data-filter="*">' . esc_html__( 'Show All', 'polo' ) . '</li>';

			/*$current_category = single_cat_title('', false); $i = 2;*/
			foreach ( $terms as $term ) {
				/*$active = ( $term->name == $current_category ) ? 'active' : '';*/

				$output .= '<li data-filter=".' . $term->slug . '">' . $term->name . '</li>';

				/*$i++;*/
			}

			$output .= '</ul>';

			echo apply_filters( 'polo_category_submenu', $output, $args );
		}
	}
}
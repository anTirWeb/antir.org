<?php
/**
 * Page links
 * after the loop in page templates
 *
 * @since 1.0.0
 */
function polo_do_page_links() {

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$show_page_links = reactor_option( 'frontpage_page_links', 0 );
		if ( $show_page_links ) {
			polo_page_links( array( 'query' => 'frontpage_query', 'type' => 'numbered' ) );
		}
	} elseif ( is_page_template( 'page-templates/news-page.php' ) ) {
		$blog_style      = reactor_option( 'blog_style', 'classic' );
		$meta_blog_style = reactor_option( 'blog_style', '', 'meta_news_page_options' );
		if ( isset( $meta_blog_style ) && ! empty( $meta_blog_style ) && ! ( 'default' === $meta_blog_style ) ) {
			$blog_style = $meta_blog_style;
		}
		$pagination_type      = reactor_option( 'pagination_type', 'pagination' );
		$meta_pagination_type = reactor_option( 'pagination_type', '', 'meta_news_page_options' );
		if ( isset( $meta_pagination_type ) && ! empty( $meta_pagination_type ) && ! ( 'default' === $meta_pagination_type ) ) {
			$pagination_type = $meta_pagination_type;
		}
		if ( is_front_page() && 'pager' === $pagination_type ) {
			$pagination_type = 'pagination';
		}
		if ( isset( $blog_style ) && ! ( 'timeline' === $blog_style ) ) {
			polo_page_links( array( 'query' => 'newspage_query', 'type' => $pagination_type ) );
		}
	} elseif ( is_page_template( 'page-templates/portfolio-page.php' ) ) {
		$pagination_type      = reactor_option( 'portfolio_pagination_type', 'pagination' );
		$meta_pagination_type = reactor_option( 'pagination_type', '', 'meta_portfolio_page_options' );
		if ( isset( $meta_pagination_type ) && ! empty( $meta_pagination_type ) && ! ( 'default' === $meta_pagination_type ) ) {
			$pagination_type = $meta_pagination_type;
		}
		polo_page_links( array( 'query' => 'portfolio_query', 'type' => $pagination_type ) );
	} elseif ( is_page_template( 'page-templates/portfolio-page-side.php' ) ) {

		$pagination_type      = reactor_option( 'pagination_type', 'pagination' );
		$meta_pagination_type = reactor_option( 'pagination_type', '', 'meta_portfolio_page_panel_options' );
		if ( isset( $meta_pagination_type ) && ! empty( $meta_pagination_type ) && ! ( 'default' === $meta_pagination_type ) ) {
			$pagination_type = $meta_pagination_type;
		}
		polo_page_links( array( 'query' => 'portfolio_side_query', 'type' => $pagination_type ) );
	} elseif ( is_page_template( 'page-templates/shop-page.php' ) ) {
		polo_page_links( array( 'query' => 'product_query', 'type' => 'numbered' ) );
	} else {
		$pagination_type      = reactor_option( 'pagination_type', 'pagination' );
		polo_page_links( array( 'type' => $pagination_type ) );
	}
}

add_action( 'polo_loop_after', 'polo_do_page_links', 1 );
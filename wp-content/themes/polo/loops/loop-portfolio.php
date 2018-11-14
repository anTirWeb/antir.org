<?php

global $portfolio_query;

$portfolio_style = polo_get_theme_settings( 'portfolio_blog_style', 'meta_portfolio_blog_style', 'meta_portfolio_page_options' );
$columns_number  = polo_get_theme_settings( 'portfolio_columns_number', 'meta_portfolio_columns_number', 'meta_portfolio_page_options' );

//Portfolio per page
$items_per_page      = reactor_option( 'items_per_page', '10' );
$meta_items_per_page = reactor_option( 'meta_items_per_page', '', 'meta_portfolio_page_options' );
if ( isset( $meta_items_per_page ) && ! empty( $meta_items_per_page ) ) {
	$items_per_page = $meta_items_per_page;
}
//Show title
$show_title      = reactor_option( 'show_title' );
$meta_show_title = polo_metaselect_to_switch( reactor_option( 'meta_show_title', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_show_title ) ) {
	$show_title = $meta_show_title;
}
//Show excerpt
$show_excerpt      = reactor_option( 'show_excerpt' );
$meta_show_excerpt = polo_metaselect_to_switch( reactor_option( 'meta_show_excerpt', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_show_excerpt ) ) {
	$show_excerpt = $meta_show_excerpt;
}
$excerpt_length      = reactor_option( 'excerpt_length', '20' );
$meta_excerpt_length = reactor_option( 'meta_excerpt_length', '', 'meta_portfolio_page_options' );
if ( isset( $meta_excerpt_length ) && ! empty( $meta_excerpt_length ) ) {
	$excerpt_length = $meta_excerpt_length;
}
//Disable spaces
$disable_spaces      = reactor_option( 'disable_spaces' );
$meta_disable_spaces = polo_metaselect_to_switch( reactor_option( 'meta_disable_spaces', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_disable_spaces ) ) {
	$disable_spaces = $meta_disable_spaces;
}
if ( true === $disable_spaces ) {
	$space = 0;
} elseif ( true === $show_excerpt ) {
	if ( '5' === $columns_number || '6' === $columns_number ) {
		$space = 1;
	} else {
		$space = 3;
	}
} else {
	if ( '5' === $columns_number || '6' === $columns_number ) {
		$space = 1;
	} else {
		$space = 2;
	}
}
//Page layout
$page_layout = polo_get_theme_settings( 'portfolio-main-sidebar', 'meta-page-main-sidebar', 'meta_page_options' );


$categories_exclude = reactor_option( 'custom_categories_exclude', '', 'meta_portfolio_page_options' );
$post_meta          = get_post_meta( get_the_ID(), 'meta_portfolio_page_options', true );
$cat_ids            = $tax_query = array();
$categories_exclude = false;
if ( isset( $post_meta['custom_categories_exclude'] ) && ! empty( $post_meta['custom_categories_exclude'] ) ) {
	$categories_exclude = $post_meta['custom_categories_exclude'];
}
if ( true === $categories_exclude ) {
	$ex       = 'exclude';
	$operator = 'NOT IN';
} else {
	$ex       = 'include';
	$operator = 'IN';
}
if ( isset( $post_meta['custom_categories'] ) && ! empty( $post_meta['custom_categories'] ) ) {
	$custom_categories = $post_meta['custom_categories'];
	foreach ( $custom_categories as $single_cat ) {
		$cat_ids[] = $single_cat['cat_id'];
	}
	$tax_query = array(
		array(
			'taxonomy' => 'portfolio-category',
			'field'    => 'term_id',
			'terms'    => $cat_ids,
			'operator' => $operator,
		),
	);
}

// Order options

$order = isset($post_meta['meta-folio-order']) ? $post_meta['meta-folio-order'] : 'DESC';
$sort_by = isset($post_meta['meta-folio-sort']) ? $post_meta['meta-folio-sort'] : 'date';


//Query args
if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
} else {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
	'post_type'      => 'portfolio',
	'posts_per_page' => $items_per_page,
	'order'          => $order,
	'orderby'        => $sort_by,
	'tax_query'      => $tax_query,
	'paged'          => $paged
);

$portfolio_query = new WP_Query( $args );

if ( 'masonry' === $portfolio_style ) {
	$masonry_size = reactor_option( 'masonry-item-size', '', '_portfolio_single_options' );

}

$hover_style      = reactor_option( 'portfolio_hover_style' );
$meta_hover_style = reactor_option( 'meta_portfolio_hover_style', '', 'meta_portfolio_page_options' );
if ( isset( $meta_hover_style ) && ! empty( $meta_hover_style ) && ! ( 'none' === $meta_hover_style ) ) {
	$hover_style = $meta_hover_style;
}
//Query vars
set_query_var( 'folio_style', $portfolio_style );
set_query_var( 'column_number', $columns_number );
set_query_var( 'show_title', $show_title );
set_query_var( 'show_excerpt', $show_excerpt );
set_query_var( 'excerpt_length', $excerpt_length );
set_query_var( 'hover_style', $hover_style );

$cats_to_display = polo_folio_active_categories($portfolio_query);

$category_submenu_args = array(
	'taxonomy' => 'portfolio-category',
);
if ( isset( $cat_ids ) && ! empty( $cat_ids ) ) {
	$category_submenu_args['terms_args'] = array( $ex => $cat_ids );
}elseif (isset($cats_to_display) && is_array($cats_to_display)){
	$category_submenu_args['terms_args'] = array( 'include' => array_unique($cats_to_display) );
}
if ( isset( $page_layout ) && ! ( '1col-fixed' === $page_layout ) ) {
	$category_submenu_args['show_active'] = false;
}

polo_category_submenu( $category_submenu_args );

if ( $portfolio_query->have_posts() ) {
	?>

	<div id="isotope" class="isotope portfolio-items" data-isotope-item-space="<?php echo esc_attr( $space ); ?>" data-isotope-mode="masonry" data-isotope-col="<?php echo esc_attr( $columns_number ); ?>" data-isotope-item=".portfolio-item">

		<?php while ( $portfolio_query->have_posts() ) :
			$portfolio_query->the_post();

			include POLO_ROOT_PATH . '/post-formats/format-portfolio.php';

		endwhile; ?>
	</div><!--#isotope-->
<?php }

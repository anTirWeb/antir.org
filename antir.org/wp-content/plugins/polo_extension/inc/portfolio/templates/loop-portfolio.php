<?php

if ( function_exists( 'reactor_option' ) ) {
	$portfolio_style = reactor_option( 'portfolio_blog_style' );
	$columns_number  = reactor_option( 'portfolio_columns_number' );

	//Portfolio per page
	$items_per_page = reactor_option( 'items_per_page', '10' );

	//Show title
	$show_title = reactor_option( 'show_title' );

	//Show excerpt
	$show_excerpt = reactor_option( 'show_excerpt' );

	$excerpt_length = reactor_option( 'excerpt_length', '20' );

	//Disable spaces
	$disable_spaces = reactor_option( 'disable_spaces' );

	$hover_style = reactor_option( 'portfolio_hover_style' );
} else {

	$portfolio_style = 'classic';
	$columns_number  = '1';
	$items_per_page  = '10';
	$show_title      = true;
	$show_excerpt    = false;
	$excerpt_length  = '20';
	$disable_spaces  = false;
	$hover_style     = 'default';

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

//Query vars
set_query_var( 'folio_style', $portfolio_style );
set_query_var( 'column_number', $columns_number );
set_query_var( 'show_title', $show_title );
set_query_var( 'show_excerpt', $show_excerpt );
set_query_var( 'excerpt_length', $excerpt_length );
set_query_var( 'hover_style', $hover_style );

if ( have_posts() ) {
	?>

	<div id="isotope" class="isotope portfolio-items" data-isotope-item-space="<?php echo esc_attr( $space ); ?>" data-isotope-mode="masonry" data-isotope-col="<?php echo esc_attr( $columns_number ); ?>" data-isotope-item=".portfolio-item">

		<?php while ( have_posts() ) :
			the_post();

			include PLUGIN_PATH . 'inc/portfolio/templates/format-portfolio.php';

		endwhile; ?>
	</div><!--#isotope-->
<?php }

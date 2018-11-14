<?php
/*
 * Header content and functions
 */

function polo_do_head() { ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<?php if ( ! function_exists( '_wp_render_title_tag' ) ) { ?>
		<title><?php wp_title( ' - ', true, 'right' ); ?></title>
	<?php } ?>

	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

	<!-- mobile meta -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php }

add_action( 'wp_head', 'polo_do_head', 1 );

function do_top_bar() {
	get_template_part( 'fragments/top-bar' );
}

add_action( 'polo_header_before', 'do_top_bar', 10 );

function polo_before_header_section() {
	if ( is_page_template( 'page-templates/top-section.php' ) ) {
		get_template_part( 'fragments/before-header' );
	}
}

add_action( 'polo_header_before', 'polo_before_header_section', 5 );

function do_stunning_header() {

	$metabox_source = is_singular( 'portfolio' ) ? 'meta_portfolio_heading_options' : 'meta_page_options';

	$show_page_title = reactor_option( 'show-page-title' );

	$meta_show_page_title = reactor_option( 'meta-show-page-title', '', $metabox_source );

	if ( isset( $meta_show_page_title ) && ! empty( $meta_show_page_title ) && 'default' !== $meta_show_page_title ) {
		$show_page_title = $meta_show_page_title;
	}

	$show_stunning_header = reactor_option( 'stunning_header_show' );

	if ( is_singular( 'portfolio' ) ) {
		$meta_show_stunning_header = polo_metaselect_to_switch( reactor_option( 'meta-stunning-header-show', '', 'meta_portfolio_heading_options' ) );
	} else {
		$meta_show_stunning_header = polo_metaselect_to_switch( reactor_option( 'meta-stunning-header-show', '', 'meta_page_options' ) );
	}

	if ( null !== $meta_show_stunning_header ) {
		$show_stunning_header = $meta_show_stunning_header;
	}


	if ( null !== $show_stunning_header && $show_stunning_header && ! is_404() ) {
		get_template_part( 'fragments/stunning-header' );
	} elseif ( true == $show_page_title && 'true' === $show_page_title ) { ?>
		<div class="container page-header-title-custom">
			<h1><?php echo esc_html( get_the_title( get_the_ID() ) ) ?></h1>
		</div>
	<?php }
}

add_action( 'polo_header_after', 'do_stunning_header' );


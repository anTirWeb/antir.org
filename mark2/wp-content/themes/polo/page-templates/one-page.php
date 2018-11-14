<?php
/**
 * Template Name: One Page
 *
 */
?>

<?php
$page_layout = 'page-main-sidebar';
$page_width  = 'page-sidebar-width';
?>

<?php

$menu_style           = reactor_option( 'onepage_menu_style', '', 'one_page_options' );
$scroll_style         = reactor_option( 'onepage_scroll_style', '', 'one_page_options' );
$scroll_buttons       = reactor_option( 'onepage_scroll_buttons', '', 'one_page_options' );
$scroll_buttons_color = reactor_option( 'onepage_scroll_button_color', '', 'one_page_options' );

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>

<?php
$preloader_data = polo_theme_preloader();
?>

<body <?php body_class(); echo apply_filters('polo_preloader_data',$preloader_data);?> >
<!-- WRAPPER -->
<div class="wrapper">


	<?php if ( 'vertical' === $menu_style ) { ?>
		<!--vertical menu-->
		<nav id="vertical-dot-menu">
			<?php
			$menu = polo_side_menu();
			$menu = preg_replace( '/class="scroll-to/', 'class="scroll-to active', $menu, 1 );
			echo apply_filters( 'polo_side_menu_onepage', $menu );
			?>
		</nav>
		<?php
	} else {
		get_template_part( 'fragments/one-page-header' );
	} ?>

	<?php polo_content_before(); ?>

	<section class="content no-padding-top no-padding-bottom">

		<div class="container">

			<?php polo_set_layout( $page_layout, $page_width, true ); ?>

			<?php
			polo_inner_content_before();

			while ( have_posts() ) : the_post();

				polo_post_before();

				$content = get_the_content();

				if ( true === $scroll_buttons ) {
					preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

					$result = $row_ids = array();
					if ( isset( $matches ) && ! empty( $matches ) ) {
						$row_ids = polo_parse_row_param( $matches, 'el_id' );
					}
					if ( isset( $matches[0] ) && ! empty( $matches[0] ) && ( true === $scroll_buttons ) ) {
						$i = 0;
						foreach ( $matches[0] as $single_row ) {
							if ( isset( $row_ids[ $i + 1 ] ) && ! empty( $row_ids[ $i + 1 ] ) ) {
								$single_row = str_replace( '[vc_row_inner', '[vc_temp_inner', $single_row );
								$single_row = str_replace( '[vc_row', '[vc_row scroll_button="true" scroll_id="' . $row_ids[ $i + 1 ] . '" scroll_color="' . $scroll_buttons_color . '"', $single_row );
								$single_row = str_replace( '[vc_temp_inner', '[vc_row_inner', $single_row );
							}
							$result[] = $single_row;
							$i ++;
						}
					}
					$content = implode( '', $result );

				}

				if ( 'fixed' === $scroll_style ) {
					preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $classes_matches );
					if ( isset( $classes_matches ) && ! empty( $classes_matches ) ) {
						$row_classes = polo_parse_row_param( $classes_matches, 'el_class' );
					}

					if ( isset( $classes_matches[0] ) && ! empty( $classes_matches[0] ) ) {
						$fixed_rows = array();
						$i          = 0;
						foreach ( $classes_matches[0] as $single_row ) {
							if ( array_key_exists( $i, $row_classes ) ) {
								$fixed_rows[] = str_replace( $row_classes[ $i ], $row_classes[ $i ] . ' background-fixed', $single_row );
							} else {
								if ( false === strpos( $single_row, 'vc_row_inner' ) ) {
									$fixed_rows[] = str_replace( '[vc_row', '[vc_row el_class="background-fixed"', $single_row );
								} else {
									$single_row   = str_replace( '[vc_row_inner', '[vc_temp_inner', $single_row );
									$single_row   = str_replace( '[vc_row', '[vc_row el_class="background-fixed"', $single_row );
									$fixed_rows[] = str_replace( '[vc_temp_inner', '[vc_row_inner', $single_row );
								}
							}

							$i ++;
						}

						$content = implode( '', $fixed_rows );
					}

				}

				echo apply_filters( 'polo_onepage_content', do_shortcode( $content ) );

				polo_post_after();

			endwhile;

			polo_inner_content_after();
			?>

			<?php polo_set_layout( $page_layout, $page_width, false ); ?>

		</div>
		<!--.content-->

	</section><!--.content-->

	<?php polo_content_after(); ?>

	<?php get_footer(); ?>

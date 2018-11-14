<?php
/*
 *The loop for displaying posts on the news page template
 */
?>
<?php

global $wp_query;

$blog_style             = reactor_option( 'blog_style', 'classic' );
$columns_number         = reactor_option( 'blog_columns_number' );
$masonry_columns_number = reactor_option( 'blog_columns_number_masonry' );
$thumbnail_blog_style   = reactor_option( 'thumbnail_blog_style' );
$page_layout            = reactor_option( 'archive-main-sidebar' );

$additional_class = '';

if ( 'modern' === $blog_style ) {
	$additional_class = 'post-modern';
}

if ( have_posts() ) {

	if ( 'classic' === $blog_style || 'modern' === $blog_style ) {
		if ( ! ( '1' === $columns_number ) ) {
			?>
			<div id="news-page" class="post-content post-<?php echo esc_attr( $columns_number ); ?>-columns <?php echo esc_attr( $additional_class ); ?>">
		<?php } else { ?>
			<div id="news-page" class="post-content no-columns <?php echo esc_attr( $additional_class ); ?>">
		<?php
		}
	} elseif ( 'masonry' === $blog_style ) {
		?>
		<div class="isotope" data-isotope-item-space="3" data-isotope-col="<?php echo esc_attr( $masonry_columns_number ); ?>" data-isotope-item=".post-item">
	<?php
	} elseif ( 'timeline' === $blog_style ) {
		if ( 'masonry' === $blog_style ) {
			$next_link = get_next_posts_link( '<span>' . esc_html__( 'Next', 'polo' ) . '<i class="fa fa-chevron-right"></i></span>', $newspage_query->max_num_pages );
			$prev_link = get_previous_posts_link( '<span><i class="fa fa-chevron-left"></i>' . esc_html__( 'Previous', 'polo' ) . '</span>' );
		} else {
			$next_link = $prev_link = '';
		}?>
		<div id="news-page" class="post-content post-modern">
		<div class="timeline">
		<ul class="timeline-circles">
		<?php if ( isset( $prev_link ) && ! empty( $prev_link ) ) { ?>
			<li class="timeline-date"><?php echo esc_url( $prev_link ); ?></li>
		<?php } else { ?>
			<li class="timeline-date"><?php esc_html_e( 'Start', 'polo' ); ?></li>
		<?php } ?>

	<?php
	} elseif ( 'thumbnail' === $blog_style ) {
		if ( 'modern' === $thumbnail_blog_style ) {
			$modern_class = 'post-modern';
		}
		if ( '2c-b-fixed' === $page_layout ) {
			$both_sidebars_class = 'bothsidebar';
		}
		?>
		<div id="news-page" class="post-content post-thumbnail <?php echo esc_attr( $modern_class ); ?> <?php echo esc_attr( $both_sidebars_class ); ?>">
	<?php } ?>

	<?php while ( have_posts() ) {
		the_post();

		include POLO_ROOT_PATH . '/post-formats/format-blog.php';

	}?>

	<?php if ( 'timeline' === $blog_style ){
	if ( isset( $next_link ) && ! empty( $next_link ) ) {
		?>
		<li class="timeline-date"><?php echo esc_url( $next_link ); ?></li>
	<?php } else { ?>
		<li class="timeline-date"><?php esc_html_e( 'End', 'polo' ) ?></li>
	<?php } ?>
	</ul><!--timeline-circles-->
	</div><!--timeline-->
<?php } ?>

	</div>
<?php
}
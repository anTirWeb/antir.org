<?php
/*
 *The loop for displaying posts on the news page template
 */
?>
<?php

$blog_style             = reactor_option( 'blog_style', 'classic' );
$columns_number         = reactor_option( 'blog_columns_number' );
$masonry_columns_number = reactor_option( 'blog_columns_number_masonry' );
$thumbnail_blog_style   = reactor_option( 'thumbnail_blog_style' );
$page_layout            = reactor_option( 'page-main-sidebar' );
$custom_categories      = reactor_option('blog_custom_categories','','meta_news_page_options');
$custom_exclude         = reactor_option('blog_custom_categories_exclude','','meta_news_page_options');
$posts_number           = reactor_option('posts_number','','meta_news_page_options');

$meta_blog_style = reactor_option( 'blog_style', '', 'meta_news_page_options' );
if ( isset( $meta_blog_style ) && ! empty( $meta_blog_style ) && ! ( 'default' === $meta_blog_style ) ) {
	$blog_style = $meta_blog_style;
}
$meta_columns_number = reactor_option( 'blog_columns_number', '', 'meta_news_page_options' );
if ( isset( $meta_columns_number ) && ! empty( $meta_columns_number ) && ! ( 'default' === $meta_columns_number ) && ! ( 'default' === $meta_blog_style ) ) {
	$columns_number = $meta_columns_number;
}
$meta_masonry_columns_number = reactor_option( 'blog_columns_number_masonry', '', 'meta_news_page_options' );
if ( isset( $meta_masonry_columns_number ) && ! empty( $meta_masonry_columns_number ) && ! ( 'default' === $meta_masonry_columns_number ) && ! ( 'default' === $meta_blog_style ) ) {
	$masonry_columns_number = $meta_masonry_columns_number;
}
$meta_thumbnail_blog_style = reactor_option( 'thumbnail_blog_style', '', 'meta_news_page_options' );
if ( isset( $meta_thumbnail_blog_style ) && ! empty( $meta_thumbnail_blog_style ) && ! ( 'default' === $meta_thumbnail_blog_style ) && ! ( 'default' === $meta_blog_style ) ) {
	$thumbnail_blog_style = $meta_thumbnail_blog_style;
}
$meta_page_layout = reactor_option( 'meta-page-main-sidebar', '', 'meta_page_options' );
if ( isset( $meta_page_layout ) && ! ( $meta_page_layout == '' ) && ! ( $meta_page_layout == 'default' ) ) {
	$page_layout = $meta_page_layout;
}
$additional_class = $modern_class = $both_sidebars_class = '';

if ( 'modern' === $blog_style ) {
	$additional_class = 'post-modern';
}

if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
} else {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}

$args = array(
	'post_type' => 'post',
	'paged' => $paged
);

if(isset($posts_number) && !empty($posts_number)){
$args['posts_per_page'] = $posts_number;
}

if(isset($custom_categories) && !empty($custom_categories) && is_array($custom_categories)){

	$categories = array();

	foreach ($custom_categories as $single_category){
		if (isset($single_category['cat_id']) && !empty($single_category['cat_id'])){
			$categories[] = $single_category['cat_id'];
		}
	}

	if(true === $custom_exclude){
		$args['category__not_in'] = $categories;
	}else{
		$args['category__in'] = $categories;
	}

}

global $newspage_query;
$newspage_query = new WP_Query( $args );


if ( $newspage_query->have_posts() ) {

	if ( 'classic' === $blog_style || 'modern' === $blog_style ) {
		if ( ! ( '1' === $columns_number ) ) {
			?>
			<?php if('modern' === $blog_style){?>
			<div id="news-page" class="post-content post-<?php echo esc_attr( $masonry_columns_number ); ?>-columns <?php echo esc_attr( $additional_class ); ?>">
			<?php }else{?>
			<div id="news-page" class="post-content post-<?php echo esc_attr( $columns_number ); ?>-columns <?php echo esc_attr( $additional_class ); ?>">
			<?php }?>
		<?php } else { ?>
			<div id="news-page" class="post-content no-columns <?php echo esc_attr( $additional_class ); ?>">
		<?php
		}
	} elseif ( 'masonry' === $blog_style ) {
		?>
		<div id="news-page" class="isotope" data-isotope-item-space="3" data-isotope-col="<?php echo esc_attr( $masonry_columns_number ); ?>" data-isotope-item=".post-item">
	<?php
	} elseif ( 'timeline' === $blog_style ) {
			$next_link = get_next_posts_link( '<span>' . esc_html__( 'Next', 'polo' ) . ' <i class="fa fa-chevron-right"></i></span>', $newspage_query->max_num_pages );
			$prev_link = get_previous_posts_link( '<span><i class="fa fa-chevron-left"></i> ' . esc_html__( 'Previous', 'polo' ) . '</span>' );
		?>
		<div class="post-content post-modern">
		<div class="timeline">
		<ul class="timeline-circles">
		<?php if ( isset( $prev_link ) && ! empty( $prev_link ) ) { ?>
			<li class="timeline-date"><?php echo ($prev_link); ?></li>
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

	<?php while ( $newspage_query->have_posts() ) {
		$newspage_query->the_post();

		include POLO_ROOT_PATH . '/post-formats/format-blog.php';

	}?>

	<?php if ( 'timeline' === $blog_style ){
	if ( isset( $next_link ) && ! empty( $next_link ) ) {
		?>
		<li class="timeline-date"><?php echo ($next_link); ?></li>
	<?php } else { ?>
		<li class="timeline-date"><?php esc_html_e( 'End', 'polo' ) ?></li>
	<?php } ?>
	</ul><!--timeline-circles-->
	</div><!--timeline-->
<?php } ?>

	</div>
<?php
}
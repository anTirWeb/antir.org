<?php
/*
 *Template for page display
 */
?>

<?php
$page_layout = 'search-main-sidebar';
$page_width  = 'search-sidebar-width';
?>

<?php
$section_class = array();
$page_meta     = get_post_meta( get_the_ID(), 'meta_page_options', true );
if ( isset( $page_meta['top_padding_disable'] ) && true === $page_meta['top_padding_disable'] ) {
	$section_class[] = 'no-padding-top';
}
if ( isset( $page_meta['bottom_padding_disable'] ) && true === $page_meta['bottom_padding_disable'] ) {
	$section_class[] = 'no-padding-bottom';
}
$section_class = implode( ' ', $section_class );
?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

<section class="content <?php echo esc_attr( $section_class ); ?>">

	<div class="container">

		<?php polo_set_layout( $page_layout, $page_width, true ); ?>

		<?php
		polo_inner_content_before();

		if ( have_posts() ) : ?>
            <h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'polo' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		<?php else : ?>
            <h2 class="page-title"><?php _e( 'Nothing Found', 'polo' ); ?></h2>
		<?php endif;

		if (have_posts()){
		while ( have_posts() ) : the_post();
		get_template_part( 'post-formats/format', 'blog' );
		endwhile;
		} else { ?>
            <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'polo' ); ?></p>
			<?php
			get_search_form();
        } ?>

		<?php polo_set_layout( $page_layout, $page_width, false ); ?>

	</div>
	<!--.content-->

</section><!--.content-->

<?php polo_content_after(); ?>

<?php get_footer(); ?>

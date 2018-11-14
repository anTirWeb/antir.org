<?php
/**
 * Template Name: Maintenance Page
 *
 */
?>
<?php
$page_meta = get_post_meta( get_the_ID(), 'maintenance_page_options', true );
if ( isset( $page_meta['maintenance_progress_bar'] ) ) {
	$progress_bar_enable = $page_meta['maintenance_progress_bar'];
} else {
	$progress_bar_enable = false;
}

if ( isset( $page_meta['progress_bar_title'] ) && ! empty( $page_meta['progress_bar_title'] ) ) {
	$progress_bar_title = $page_meta['progress_bar_title'];
} else {
	$progress_bar_title = esc_html__( 'Maintenance in progress', 'polo' );
}

if ( isset( $page_meta['progress_bar_value'] ) && ! empty( $page_meta['progress_bar_value'] ) ) {
	$progress_bar_value = $page_meta['progress_bar_value'];
} else {
	$progress_bar_value = '50';
}

?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

<section class="fullscreen text-center">
	<div class="container container-fullscreen">
		<div class="text-middle text-center">
			<i class="fa fa-exclamation-triangle fa-5x" style="color: #ffd530;"></i>
			<h1 class="text-uppercase text-large"><?php the_title(); ?></h1>
			<p class="lead"><?php
				while ( have_posts() ): the_post();
					echo get_the_content();
				endwhile;
				?></p>
		</div>
	</div>

	<?php if ( true === $progress_bar_enable ) { ?>
		<div class="progress-bar-container title-up small">
			<div class="progress-bar" data-percent="<?php echo esc_attr( $progress_bar_value ); ?>" data-delay="100" data-type="%" style="background-color:#ffd530">
				<div class="progress-title"><?php echo esc_attr( $progress_bar_title ); ?></div>
			</div>
		</div>
	<?php } ?>
</section>

<?php polo_content_after(); ?>

<a class="gototop gototop-button" href="#"><i class="fa fa-chevron-up"></i></a>

<?php wp_footer(); ?>


</body>
</html>


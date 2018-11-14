<?php
/**
 * Template Name: 404 Page
 *
 */
?>

<?php
$page_meta  = get_post_meta( get_the_ID(), 'page_404_options', true );
$page_style = 'default';

if ( isset( $page_meta['page_404_style'] ) && ! empty( $page_meta['page_404_style'] ) ) {
	$page_style = $page_meta['page_404_style'];
}

if ( 'parallax' === $page_style ) {
	$section_class = 'parallax text-light fullscreen background-overlay-dark';
	if ( isset( $page_meta['parallax_404_bg_image'] ) && ! empty( $page_meta['parallax_404_bg_image'] ) ) {
		$parallax_bg_style = 'style="background:url(' . wp_get_attachment_url( $page_meta['parallax_404_bg_image'] ) . ')"';
	}
} else {
	$section_class     = 'm-t-80 p-b-150';
	$parallax_bg_style = '';
}

if ( isset( $page_meta['404_page_title'] ) && ! empty( $page_meta['404_page_title'] ) ) {
	$page_title = $page_meta['404_page_title'];
} else {
	$page_title = '';
}

if ( isset( $page_meta['404_page_description'] ) && ! empty( $page_meta['404_page_description'] ) ) {
	$page_description = $page_meta['404_page_description'];
} else {
	$page_description = '';
}

?>

<?php get_header(); ?>

<?php polo_content_before(); ?>

<!-- 404 PAGE -->
<section class="<?php echo esc_attr( $section_class ); ?>" <?php echo ($parallax_bg_style); ?>>
	<div class="container">
		<?php if ( 'parallax' === $page_style ){ ?>
		<div class="container-fullscreen">
			<div class="text-middle text-center text-light">
				<?php } ?>
				<div class="row">
					<div class="col-md-6">
						<div class="page-error-404">404</div>
					</div><!--col-md-6-->
					<div class="col-md-6">
						<div class="text-left">
							<?php if ( isset( $page_title ) && ! empty( $page_title ) ) { ?>
								<h1 class="text-medium"><?php echo ($page_title); ?></h1>
							<?php } ?>
							<?php if ( isset( $page_description ) && ! empty( $page_description ) ) { ?>
								<p class="lead"><?php echo ($page_description); ?></p>
							<?php } ?>
							<div class="seperator m-t-20 m-b-20"></div>

							<div class="search-form">
								<p><?php esc_html_e( 'Please try searching again', 'polo' ) ?></p>
								<?php
								$search_form = get_search_form( false );
								$search_form = str_replace( 'input-group', 'input-group input-group-lg', $search_form );
								$search_form = str_replace( 'input-group input-group-lg-btn', 'input-group-btn', $search_form );
								echo( $search_form );
								?>
							</div>

						</div>
					</div><!--col-md-6-->
				</div><!--row-->
				<?php if ( 'parallax' === $page_style ){ ?>
			</div><!--text-middle text-center text-light-->
		</div><!--container-fullscreen-->
	<?php } ?>

	</div><!--container-->
</section>
<!-- END:  404 PAGE -->


<?php polo_content_after(); ?>

<?php get_footer(); ?>

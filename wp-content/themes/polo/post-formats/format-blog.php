<?php
$blog_style     = reactor_option( 'blog_style' );
$excerpt_length = reactor_option( 'excerpt_length', cs_get_option('excerpt_length', '20') );

$meta_blog_style = reactor_option( 'blog_style', '', 'meta_news_page_options' );
if ( isset( $meta_blog_style ) && ! empty( $meta_blog_style ) && ! ( 'default' === $meta_blog_style ) ) {
	$blog_style = $meta_blog_style;
}
$meta_excerpt_length = reactor_option( 'excerpt_length', '', 'meta_news_page_options' );
if ( isset( $meta_excerpt_length ) && ! empty( $meta_excerpt_length ) ) {
	$excerpt_length = $meta_excerpt_length;
}
?>

<?php if ( 'timeline' === $blog_style ) { ?>
	<li>
	<div class="timeline-block">
<?php } ?>

	<div <?php post_class('post-item') ?> >
		<?php
		if ( 'timeline' === $blog_style ) {
			echo polo_do_post_feature( get_the_ID() );
		} elseif ( 'masonry' === $blog_style ) {
			$output = '';

			if ( has_post_format( 'gallery', get_the_ID() ) ) {

				$output .= polo_do_feature_gallery();

			} elseif ( has_post_format( 'audio', get_the_ID() ) ) {

				$output .= polo_do_feature_audio();

			} elseif ( has_post_format( 'video', get_the_ID() ) ) {

				$output .= '<div class="post-video">';

				$output .= polo_do_feature_video();

				$output .= '</div>';

			} else {
				$output .= polo_do_feature_resized( get_the_ID(), '580', '350' );
			}
			echo ($output);
		} elseif ( 'thumbnail' === $blog_style ) {
			$output = '';

			if ( has_post_format( 'gallery', get_the_ID() ) ) {

				$output .= polo_do_feature_gallery('525', '400');

			} elseif ( has_post_format( 'audio', get_the_ID() ) ) {

				$output .= polo_do_feature_audio();

			} elseif ( has_post_format( 'video', get_the_ID() ) ) {

				$output .= '<div class="post-video">';

				$output .= polo_do_feature_video();

				$output .= '</div>';

			} else {
				$output .= polo_do_feature_resized( get_the_ID(), '525', '400' );
			}
			echo ($output);
		} else {
			echo polo_do_post_feature( get_the_ID() );
		}
		?>
		<div class="post-content-details">
			<div class="post-title">
				<h3>
					<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ) ?>"><?php echo  get_the_title( get_the_ID() ) ; ?></a>
				</h3>
			</div>
			<?php echo polo_post_info(); ?>
			<div class="post-description">
				<?php echo polo_post_text( get_the_ID(), $excerpt_length ); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="text-center"><ul class="pagination pagination-simple">',
					'after'  => '</ul></div>',
				) );
				?>
				<div class="post-info">
					<a class="read-more" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
						<?php esc_html_e( 'read more', 'polo' ) ?>
						<i class="fa fa-long-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
		<?php echo polo_post_meta(); ?>
		<div class="clearfix"></div>
	</div>

<?php if ( 'timeline' === $blog_style ) { ?>
	</div>
	</li>
<?php } ?>
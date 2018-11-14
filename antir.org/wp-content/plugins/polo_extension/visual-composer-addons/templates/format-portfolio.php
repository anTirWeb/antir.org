<?php
$width  = '600';
$height = '400';

$portfolio_style = get_query_var( 'block_style' );
$add_class       = '';
$hover_style = get_query_var( 'hover_style' );
$post_meta = get_post_meta( get_the_ID(), '_portfolio_single_options', true );
if(isset($post_meta['portfolio_description']) && !empty($post_meta['portfolio_description'])){
	$folio_excerpt = $post_meta['portfolio_description'];
}else{
	$folio_excerpt = '';
}
if(false === $hover_style || empty($hover_style)){
	$hover_style = 'default';
}
if ( 'masonry' === $portfolio_style && 'default' === $hover_style) {
	$masonry_sizes = get_post_meta( get_the_ID(), 'portfolio-size', true );
	if ( isset( $masonry_sizes['masonry-item-size'] ) && ! empty( $masonry_sizes['masonry-item-size'] ) ) {
		$masonry_size = $masonry_sizes['masonry-item-size'];
	}
	if (isset($masonry_size) &&  'extra_large' === $masonry_size ) {
		$add_class = 'large-item';
		$width     = '';
		$height    = '';
	} elseif (isset($masonry_size) &&  'large' === $masonry_size ) {
		$width  = '';
		$height = '';
	} else{
		$width  = '';
		$height = '';
	}
}

polo_portfolio_force_thumb_size( $width, $height );

$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
if ( ! empty( $post_thumbnail_id ) ) {
	$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
} else {
	$thumb[0] = PLUGIN_URL . 'assets/img/no-image.png';
}
$image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 'c' );
$taxonomy             = 'portfolio-category';
$portfolio_categories = get_the_terms( get_the_ID(), $taxonomy );

$categories_class = array();
if ( ! is_wp_error( $portfolio_categories ) && is_array($portfolio_categories) ) {
	$i          = 1;
	$cats_count = count( $portfolio_categories );
	foreach ( $portfolio_categories as $single_category ) {
		$categories_class[] = $single_category->slug;
		$i ++;
	}
}
$categories_class = implode( ' ', $categories_class );
?>

<div class="portfolio-item <?php echo esc_attr( $categories_class . ' ' . $add_class ); ?>">
	<?php if ( 'default' === $hover_style ) { ?>
		<div class="portfolio-image effect effect-default">
			<img src="<?php echo esc_url( $image_url ) ?>" alt="">
			<div class="image-box-content">
				<p>
					<a href="<?php echo esc_url( $thumb[0] ) ?>" data-lightbox-type="image" title="<?php echo esc_attr( get_the_title( get_the_ID() ) ) ?>"><i class="fa fa-expand"></i></a>
					<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>"><i class="fa fa-link"></i></a>
				</p>
			</div>
		</div>
	<?php } else { ?>

	<?php if ( function_exists('portfolio_hover_effects') ) {
			portfolio_hover_effects( $hover_style, $thumb, $folio_excerpt );
		}?>

	<?php } ?>
</div>

<?php
$masonry_size = '';
?>

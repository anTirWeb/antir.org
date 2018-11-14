<?php

$taxonomy             = 'portfolio-category';
$portfolio_categories = get_the_terms( get_the_ID(), $taxonomy );

$categories_class = $categories_names = array();
if ( ! is_wp_error( $portfolio_categories ) ) {
	$i          = 1;
	$cats_count = count( $portfolio_categories );
	foreach ( $portfolio_categories as $single_category ) {
		$categories_class[] = $single_category->slug;
		if ( $i <= 2 ) {
			$categories_names[] = '<a href="' . esc_url( get_term_link( $single_category->term_id ) ) . '">' . $single_category->name . '</a>';
		}
		$i ++;
	}
}
$categories_class = implode( ' ', $categories_class );
$categories_names = implode( ' / ', $categories_names );

$width  = '600';
$height = '400';

$portfolio_style = get_query_var( 'folio_style' );
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
if ( 'masonry' === $portfolio_style && 'default' === $hover_style ) {
	$masonry_sizes = get_post_meta( get_the_ID(), 'portfolio-size', true );
	if ( isset( $masonry_sizes['masonry-item-size'] ) && ! empty( $masonry_sizes['masonry-item-size'] ) ) {
		$masonry_size = $masonry_sizes['masonry-item-size'];
	} else {
		$masonry_size = '';
	}
	if ( 'extra_large' === $masonry_size ) {
		$add_class = 'large-item';
		$width     = '800';
		$height    = '534';
	} elseif ( 'large' === $masonry_size ) {
		$width  = '600';
		$height = '800';
	}
}

$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
if ( ! empty( $post_thumbnail_id ) ) {
	$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
} else {
	$thumb[0] = PLUGIN_URL . 'assets/img/no-image.png';
}

$image_url = polo_theme_thumb( $thumb[0], $width, $height, true, 'c' );

$show_title     = get_query_var( 'show_title' );
$show_excerpt   = get_query_var( 'show_excerpt' );
$excerpt_length = get_query_var( 'excerpt_length' );
$column_number  = get_query_var( 'column_number' );

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
		<?php if ( true === $show_title ) { ?>
			<div class="portfolio-description">
				<h4 class="title"><?php the_title(); ?></h4>
				<p><i class="fa fa-tag"></i><?php echo( $categories_names ); ?></p>
			</div>
			<div class="portfolio-date">
				<p class="small"><i class="fa fa-calendar-o"></i><?php echo esc_attr( get_the_date( 'F d, Y' ) ); ?></p>
			</div>
		<?php } ?>
		<?php if ( true === $show_excerpt ) { ?>
			<div class="portfolio-details">
				<?php
				if ( isset( $post_meta['portfolio_description'] ) && ! empty( $post_meta['portfolio_description'] ) ) {
					$portfolio_description = $post_meta['portfolio_description'];
					$portfolio_excerpt     = strip_shortcodes( $portfolio_description );
					$post_text             = wp_trim_words( $portfolio_excerpt, $excerpt_length );
					echo( wpautop( $post_text ) );
				}

				?>
				<?php if ( '1' === $column_number ) { ?>
					<br>
					<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>" class="button color rounded button-3d effect icon-top"><span><i class="fa fa-external-link"></i><?php esc_html_e( 'More details', 'polo_extension' ) ?></span></a>
				<?php } ?>
			</div><!--portfolio-details-->
		<?php } ?>
	<?php } else { ?>

	<?php if ( function_exists('portfolio_hover_effects') ) {
			portfolio_hover_effects( $hover_style, $thumb, $folio_excerpt );
		}?>

	<?php } ?>
</div>

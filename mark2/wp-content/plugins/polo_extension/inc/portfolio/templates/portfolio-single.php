<?php
/**
 * The template for displaying single portfolio posts
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */

$items = array();

$short_description = $post_thumbnail = '';

if ( function_exists( 'reactor_option' ) ) {
	$layout       = reactor_option( 'portfolio-single-layout' );
	$hide_share   = reactor_option( 'hide_share' );
	$soc_networks = reactor_option( 'folio_soc_networks', '' );
	if ( empty( $soc_networks ) ) {
		$soc_networks = reactor_option( 'soc_networks', array() );
	}


	$media = reactor_option( 'portfolio-single-media', '', '_portfolio_single_options' );

	$meta_layout = reactor_option( 'portfolio-single-layout', '', '_portfolio_single_options' );

	if ( isset( $meta_layout ) && ! empty( $meta_layout ) && ! ( 'default' === $meta_layout ) ) {
		$layout = $meta_layout;
	}

	$meta_folio_embed_video = reactor_option( 'folio_post_video_embed', '', '_portfolio_single_options' );
	$meta_folio_webm        = reactor_option( 'folio_post_video_webm', '', '_portfolio_single_options' );
	$meta_folio_mp4         = reactor_option( 'folio_post_video_mp4', '', '_portfolio_single_options' );

	$meta_folio_embed_audio = reactor_option( 'folio_post_audio_embed', '', '_portfolio_single_options' );
	$meta_folio_file        = reactor_option( 'folio_post_audio_file', '', '_portfolio_single_options' );

	$meta_align            = reactor_option( 'add_info_position', '', '_portfolio_single_options' );
	$description_title     = reactor_option( 'portfolio_description_title', '', '_portfolio_single_options' );
	$portfolio_description = reactor_option( 'portfolio_description', '', '_portfolio_single_options' );
	$add_info_title        = reactor_option( 'add_info_title', '', '_portfolio_single_options' );
	$post_meta             = get_post_meta( get_the_ID(), '_portfolio_single_options', true );
	if ( isset( $post_meta['additional_info'] ) && ! empty( $post_meta['additional_info'] ) ) {
		$add_info = $post_meta['additional_info'];
	} else {
		$add_info = '';
	}

	if ( function_exists( 'polo_metaselect_to_switch' ) ) {
		$meta_hide_share = polo_metaselect_to_switch( reactor_option( 'meta_hide_share', '', '_portfolio_single_options' ) );
	} else {
		$meta_hide_share = null;
	}
	if ( isset( $meta_align ) && ! empty( $meta_align ) && ! ( 'default' === $meta_align ) ) {
		$align = $meta_align;
	}
	if ( ! ( null === $meta_hide_share ) ) {
		$hide_share = $meta_hide_share;
	}

	$portfolio_gallery = reactor_option( 'folio_gallery_images', '', '_portfolio_single_options' );
	$gallery_style     = reactor_option( 'gallery_type', '', '_portfolio_single_options' );

	//first getting theme main options about related projects
	$show_related      = (bool)reactor_option( 'show_related', false);
    $show_related_title = reactor_option( 'related_posts_title', esc_html__( 'Related Projects', 'polo_extension' ) );
    $show_related_title = polo_do_multilang_text( $show_related_title );
    $show_related_number = reactor_option( 'related_posts_number', '4' );

    //getting page related projects options
	$meta_show_related = reactor_option( 'meta_show_related', 'default', '_portfolio_single_options' );

	if('true' == $meta_show_related){
        $show_related = true;
    }elseif( 'false' == $meta_show_related){
	    $show_related = false;
    }


    //we are changing related projects number for default and enable cases
    if( 'false' != $meta_show_related){
        $meta_related_number = reactor_option( 'meta_related_posts_number', 'default', '_portfolio_single_options' );

        if('default' != $meta_related_number){
            $show_related_number = $meta_related_number;
        }
    }



	if ( isset( $post_meta['top_padding_disable'] ) && ! empty( $post_meta['top_padding_disable'] ) ) {
		$full_no_top = $post_meta['top_padding_disable'];
	} else {
		$full_no_top = false;
	}

} else {
	$layout              = 'left';
	$show_related        = false;
	$hide_share          = true;
	$media               = $soc_networks = $description_title = $portfolio_description = $add_info_title = $add_info = $portfolio_gallery = $gallery_style = '';
	$show_related_number = '3';
	$full_no_top         = false;
}
if ( $layout == 'left' ) {
	$content_class = 'col-md-8';
	$aside_class   = 'col-md-4';
} elseif ( $layout == 'right' ) {
	$content_class = 'col-md-8 pull-right single-folio-content';
	$aside_class   = 'col-md-4';
} else {
	$content_class = 'col-md-12';
	$aside_class   = 'col-md-12';
}
$args = array(
	'align'                 => $layout,
	'add_info_title'        => $add_info_title,
	'add_info'              => $add_info,
	'description_title'     => polo_do_multilang_text( $description_title ),
	'portfolio_description' => polo_do_multilang_text( $portfolio_description ),
	'hide_share'            => $hide_share,
	'soc_networks'          => $soc_networks
);

if ( has_post_thumbnail( get_the_ID() ) ) {
	$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
}

$encoded_url = ( get_permalink( get_the_ID() ) );
if ( has_post_thumbnail() ) {
	$encoded_thumb = ( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) );
}

if ( 'top' === $layout || 'bottom' === $layout || 'full' === $layout ) {
	$bottom_class = 'm-b-40';
} else {
	$bottom_class = '';
}
$no_top = '';
if ( 'full' === $layout && isset( $full_no_top ) && true === $full_no_top ) {
	$no_top = 'p-t-0';
}
?>

<?php get_header(); ?>

<?php if ( function_exists( 'polo_content_before' ) ) {
	polo_content_before();
} ?>

	<section class="section <?php echo( esc_attr( $no_top ) ); ?>">
		<div class="container">

			<?php if ( function_exists( 'polo_set_layout' ) && $layout == 'full' ) {
				polo_set_layout( 'portfolio-main-sidebar', 'portfolio-sidebar-width', true );
			} ?>

			<?php if ( function_exists( 'reactor_inner_content_before' ) ) {
				reactor_inner_content_before();
			} ?>

			<?php // start the loop
			while ( have_posts() ) :
			the_post(); ?>

			<?php if ( function_exists( 'reactor_post_before' ) ) {
				reactor_post_before();
			} ?>

			<div class="row <?php echo esc_attr( $bottom_class ); ?>">

				<?php if ( $layout == 'full' ) { ?>

				<div class="col-md-12">
					<?php the_content(); ?>
				</div>
			</div>
			<?php echo crumina_do_portfolio_info( $args ); ?>

			<!--<div class="row">-->
			<?php } elseif ( $layout == 'bottom' ) { ?>


			<div class="col-md-12">
				<?php the_content(); ?>
			</div>
		</div>
		<?php echo crumina_do_portfolio_info( $args, 'm-b-40' ); ?>

		<?php }
		if ( $layout != 'full' ) {
			?>

			<?php if ( 'bottom' === $layout ) { ?>
				<div class="row">
			<?php } ?>
			<div class="<?php echo esc_attr( $content_class ) ?>">


				<?php

				if ( $media == 'audio' ) {
					/*==============================================
					 *    Portfolio type - Audio
					 ==============================================*/

					if ( isset( $meta_folio_embed_audio ) && ! ( $meta_folio_embed_audio == '' ) ) { ?>
						<div class="video-container">
							<?php $embed_code = wp_oembed_get( $meta_folio_embed_audio );
							echo( $embed_code );
							?>

						</div>
						<?php
					}
					if ( ! ( $meta_folio_file == '' ) ) {
						echo do_shortcode( '[audio src="' . $meta_folio_file . '"]' );
					}

				} elseif ( $media == 'video' ) {
					/*==============================================
					 *    Portfolio type - Video
					 ==============================================*/

					if ( isset( $meta_folio_embed_video ) && ! ( $meta_folio_embed_video == '' ) ) { ?>
						<div class="video-container">
							<?php $embed_code = wp_oembed_get( $meta_folio_embed_video );
							echo( $embed_code );
							?>
							<?php echo do_shortcode( '[embed]' . $meta_folio_embed_video . '[/embed]' ); ?>
						</div>
						<?php
					}
					if ( ( isset( $meta_folio_webm ) && ! ( $meta_folio_webm == '' ) ) || isset( $meta_folio_mp4 ) && ! ( $meta_folio_mp4 == '' ) ) {
						if ( ! ( $meta_folio_mp4 == '' ) && ! ( $meta_folio_webm == '' ) ) {
							?>
							<div class="video-container">
								<?php echo do_shortcode( '[video mp4="' . $meta_folio_mp4 . '" webm="' . $meta_folio_webm . '"]' ); ?>
							</div>
							<?php
						} elseif ( ! ( $meta_folio_mp4 == '' ) ) {
							echo do_shortcode( '[video src="' . $meta_folio_mp4 . '"]' );
						}
					}


				} elseif ( $media == 'slide' ) {
					/*==============================================
					 *    Portfolio type - Slider
					==============================================*/
					if ( isset( $gallery_style ) && ! empty( $gallery_style ) && isset( $portfolio_gallery ) && ! empty( $portfolio_gallery ) ) {
						echo crumina_portfolio_gallery( $portfolio_gallery, $gallery_style );
					}

				} else {

					/*==============================================
					 *    Portfolio type - Image
					 ==============================================*/

					if ( isset( $post_thumbnail ) && ! ( $post_thumbnail == '' ) ) { ?>

						<img src="<?php echo polo_theme_thumb( $post_thumbnail[0], 1180, '', false ); ?>"
						     alt="<?php the_title() ?>" class="img-responsive ">

					<?php }
				} ?>

			</div>
			<!-- end col -->

			<?php if ( 'bottom' === $layout ) { ?>
				</div><!--row bottom-->
			<?php } ?>

			<?php if ( $layout == 'top' ) { ?>

				<div class="col-md-12 m-t-40">
					<?php the_content(); ?>
				</div>
				</div><!--row top-->
				<?php echo crumina_do_portfolio_info( $args ); ?>
			<?php }

			if ( $layout == 'left' || $layout == 'right' ) { ?>

				<div class="<?php echo esc_attr( $aside_class ); ?> single-portfolio-sidebar">

					<?php echo crumina_do_portfolio_info( $args ); ?>

				</div><!-- end col -->

				<?php if ( get_the_content() != '' ) { ?>
					<div class="col-md-12">
						<?php the_content(); ?>
					</div>

				<?php }
			} ?>
			<?php if ( ! ( 'top' === $layout ) || ! ( 'bottom' === $layout ) ) {
				?>
				</div>
				<!-- end row -->
			<?php } ?>

		<?php } ?>

		<?php if ( 'full' === $layout ) { ?>
			<!--</div>--><!--row full-->
		<?php } ?>

		<?php if ( function_exists( 'reactor_post_after' ) ) {
			reactor_post_after();
		} ?>

		<?php endwhile; // end of the loop ?>

		<?php if ( function_exists( 'reactor_inner_content_after' ) ) {
			reactor_inner_content_after();
		} ?>
		<?php if ( function_exists( 'polo_set_layout' ) && $layout == 'full' ) {
			polo_set_layout( 'portfolio-main-sidebar', 'portfolio-sidebar-width', false );
		} ?>

		</div><!--.container-->

	</section><!-- #primary -->


<?php if ( function_exists( 'polo_content_after' ) ) {
	polo_content_after();
} ?>

<?php
if ( isset( $show_related ) && true === $show_related ) {

    $taxonomy             = 'portfolio-category';
    $portfolio_categories = get_the_terms( get_the_ID(), $taxonomy );

    $related_categories_slugs = array();
    foreach ($portfolio_categories as $single_category){
        $related_categories_slugs[] = $single_category->slug;
    }

    $current_post_id = get_the_ID();

    //getting related posts by taxonomy
	$args = array(
		'post_type'    => 'portfolio',
		'orderby'      => 'rand',
		'posts_per_page'      => $show_related_number,
		'post__not_in' => array( $current_post_id ),
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio-category',
                'field'    => 'slug',
                'terms'    => $related_categories_slugs,
            )
        ),
	);
    $related_posts = get_posts($args);

    //if there not enough projects add some random
    if(count($related_posts) < $show_related_number){

        $excluded_posts = array($current_post_id);

        foreach ($related_posts as $post){
            $excluded_posts[] = $post->ID;
        }
        $args = array(
            'post_type'    => 'portfolio',
            'orderby'      => 'rand',
            'posts_per_page'      => $show_related_number - count($related_posts),
            'post__not_in' => $excluded_posts,
        );

        $related_posts = array_merge($related_posts,get_posts($args));
    }

    //if there not enough portfolios change showed number
    if(count($related_posts) < $show_related_number){
        $show_related_number = count($related_posts);
    }

	if ( '2' === $show_related_number ) {
		$columns_number = '6';
	} elseif ( '3' === $show_related_number ) {
		$columns_number = '4';
	} elseif ( '4' === $show_related_number ) {
		$columns_number = '3';
	} else {
		$columns_number = '2';
	}

	?>

	<section>

		<div class="container">

			<?php if ( isset( $show_related_title ) && ! empty( $show_related_title ) ) { ?>
				<div class="hr-title hr-long center">
					<abbr><?php echo $show_related_title; ?></abbr>
				</div><!--hr-title hr-long center-->


			<?php } ?>

			<?php
			if ( $related_posts ) {
				?>
				<div class="row" data-lightbox-type="gallery">

					<?php foreach ($related_posts as $rel_post){
                        /**
                         * @var WP_Post $rel_post
                         */
                        $categories_names = array();

                        $taxonomy             = 'portfolio-category';
                        $portfolio_categories = get_the_terms( $rel_post->ID, $taxonomy );

                        if ( ! is_wp_error( $portfolio_categories ) && is_array( $portfolio_categories ) ) {
                            $i          = 1;
                            $cats_count = count( $portfolio_categories );

                            foreach ( $portfolio_categories as $single_category ) {
                                if ( $i <= 2 ) {
                                    $categories_names[] = '<a href="' . esc_url( get_term_link( $single_category->term_id ) ) . '">' . $single_category->name . '</a>';
                                }
                                $i ++;
                            }
                        }
                        $categories_names = implode( ' / ', $categories_names );

						$post_thumbnail_id = get_post_thumbnail_id( $rel_post->ID );
						if ( ! empty( $post_thumbnail_id ) ) {
							$thumb = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
						} else {
							$thumb[0] = PLUGIN_URL . 'assets/img/no-image.png';
						}
						$image_url = polo_theme_thumb( $thumb[0], '600', '400', true, 'c' );

						?>

						<div class="col-md-<?php echo esc_attr( $columns_number ) ?> portfolio-item">

							<div class="portfolio-image effect effect-default">
								<img src="<?php echo esc_url( $image_url ) ?>" alt="">
								<div class="image-box-content">
									<p>
										<a href="<?php echo esc_url( $thumb[0] ) ?>" data-lightbox-type="image" title="<?php echo esc_attr( get_the_title( $rel_post->ID ) ) ?>"><i class="fa fa-expand"></i></a>
										<a href="<?php echo esc_url( get_the_permalink( $rel_post->ID ) ); ?>"><i class="fa fa-link"></i></a>
									</p>
								</div>
							</div>

							<div class="portfolio-description">
								<h4 class="title"><?php echo esc_attr($rel_post->post_title); ?></h4>
								<p><i class="fa fa-tag"></i><?php echo( $categories_names ); ?></p>
							</div>

						</div>

					<?php } ?>
				</div><!--row-->
			<?php } ?>

		</div><!--container-->

	</section>

<?php }
?>

<?php get_footer(); ?>
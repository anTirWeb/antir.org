<?php
/**
 * Template Name: Single Location Page
 *
 */
?>

<?php
    global $EM_Location;
     
    if( function_exists( 'get_field' ) ) {
        //echo 'acf active';
     
        $site_type = get_field('site_type');
        $amenities = get_field('site_amenities');
        $amenities_other = get_field('site_amenities_other');
        $site_rules = get_field('site_rules');
        $site_latitude = get_field('site_latitude');
        $site_longitude = get_field('site_longitude');
    
                   
    }
?>


<?php
$full_width      = reactor_option( 'enable_fullwidth' );
$meta_full_width = polo_metaselect_to_switch( reactor_option( 'meta_enable_fullwidth', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_full_width ) ) {
	$full_width = $meta_full_width;
}
if ( true === $full_width ) {
	$container_class = 'container-fluid';
} else {
	$container_class = 'container';
}
$section_class = array();
$page_meta     = get_post_meta( get_the_ID(), 'meta_page_options', true );
if ( isset( $page_meta['top_padding_disable'] ) && true === $page_meta['top_padding_disable'] ) {
	$section_class[] = 'no-padding-top';
}
if ( isset( $page_meta['bottom_padding_disable'] ) && true === $page_meta['bottom_padding_disable'] ) {
	$section_class[] = 'no-padding-bottom';
}
$section_class = implode( ' ', $section_class );
$gray_bg       = reactor_option( 'enable_gray_bg' );
$meta_gray_bg  = polo_metaselect_to_switch( reactor_option( 'meta_enable_gray_bg', '', 'meta_portfolio_page_options' ) );
if ( ! ( null === $meta_gray_bg ) ) {
	$gray_bg = $meta_gray_bg;
}
?>

<?php apply_filters( 'filter_the_content_in_the_main_loop', get_header()  ); ?>

<?php apply_filters( 'filter_the_content_in_the_main_loop', polo_content_before() ); ?>

<?php
$preloader_data = polo_theme_preloader();
//$filtered = apply_filters( 'filter_the_content_in_the_main_loop', the_content()  );
?>

<body <?php body_class(); echo apply_filters('polo_preloader_data',$preloader_data);?> >
<!-- WRAPPER -->
<div class="wrapper">

	<section class="p-t-0 p-b-0">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					
					<?php
				
					 $site_type = get_field('site_type');
        $amenities = get_field('site_amenities');
        $amenities_other = get_field('site_amenities_other');
        $site_rules = get_field('site_rules');
        $site_latitude = get_field('site_latitude');
        $site_longitude = get_field('site_longitude');
        $site_directions = get_field('site_directions');
        
				if ( $site_type ) {
                    echo "<p>&nbsp;</p><p>This is a $site_type site.</p>";
				}
    
                if ( $amenities[0] ) { ?>
                
                    <h3>Site Amenities</h3>
                    <p>The site allegedly has the following amenities:
                        <ul>
                            <?php 
                            foreach( $amenities as $amenity ) {
                                ?>
                                <li><?php echo $amenity?></li>
                                <?php
                            }
                            ?>
                            </ul>
                        </p>
                        <?php
                    if( $amenities_other ) { echo "<br/>As well as: $amenities_other";}
                }

                if ( $site_rules ) {
                    echo '<h3>Site Rules</h3>';
                    echo "<p>$site_rules</p>";
                }
                
                if ( $site_directions ) {
                    echo '<h3>Directions</h3>';
                    echo "<p>$site_directions</p>";
                }

                // TODO: Add google map/directions support
                while ( have_posts() ): the_post(); 
					
					 
						 the_content(); 
						 
						 echo "<p>&nbsp;</p>";
						
				endwhile;
					
              
?>

                <p>This page was last updated: <?php the_modified_date(); ?></p>

					<!--<p>using template: wp-content/themes/polo-child/page-templates/page-location-single.php</p>-->
				</div>
			</div>
		</div>
	</section>

</div>
<!-- END: WRAPPER -->


	<?php polo_content_after(); ?>

	<?php get_footer(); ?>

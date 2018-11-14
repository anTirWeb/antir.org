<?php
/**
 * Template Name: Single Event Page
 *
 */
?>

<?php
                
    if( function_exists( 'get_field' ) ) {
        //echo 'acf active';
        // $event_steward = get_field('event_steward');
        // $event_steward_email_address = get_field('event_steward_contact_email_address');
        $has_site_fees = get_field('add_site_fees');
        $site_fees = get_field('site_fees');
        $has_event_schedule = get_field('add_event_schedule');
        $schedule = get_field('event_schedule');
        $meal_info = get_field('meal_information');
        $pre_reg = get_field('pre_reg_reservations');
        $volunteer = get_field('volunteer_opportunities');
        $tournaments = get_field('tournaments');
        $merchants = get_field('merchants');
        $yafa = get_field('yafa');
        $classes = get_field('classes_offered');
        $event_level = get_field('event_level');
        $es_email = get_field('event_steward_email_address');
        $es_name = get_field('event_steward_sca_name');
        $es_message = '';
        
        if(!$es_email || !$es_name ) {
            
            $es_email = get_field('seneschal_email_address_from_eif');
            $es_name = get_field('senechal_sca_name_from_eif');
            
            $es_message = "Event Contact: <a href='mailto:$es_email'>$es_name</a>";
        } else {
            $es_message = "Event Steward: <a href='mailto:$es_email'>$es_name</a>";
        }
                   
    }
?>


<?php
get_header();
polo_content_before();
?>


<?php
$preloader_data = polo_theme_preloader();

?>

<body <?php body_class(); ?> >
<!-- WRAPPER -->
<div class="wrapper">

	<section class="p-t-0 p-b-0">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php while ( have_posts() ): the_post(); ?>
					
					    <p>&nbsp;</p>
					    <p><strong><?php echo $es_message; ?></strong></p>
					    <div class="event-template-default">
					    <?php
					    
						the_content(); 
						 
						 
						 ?>
						</div>
					<?php endwhile; 
					
					
				if ( $has_site_fees && $site_fees ) {
                    echo '<h3 class="event-heading">Site Fees</h3>';
    
                    echo '<p>' . $site_fees . '</p>';
                    
                }

                if ( $has_event_schedule && $schedule['body'] ) {
                    echo '<h3 class="event-heading">Event Schedule</h3>';
                     echo '<p>' . $schedule . '</p>';
                }                   

                if ( $meal_info ) {
                    echo '<h3 class="event-heading">Meal Information</h3>';
                    echo "<p>$meal_info</p>";
                }

                if ( $pre_reg ) {
                    echo '<h3 class="event-heading">Registration Information</h3>';
                    echo "<p>$pre_reg</p>";
                }
                
                if ( $tournaments ) {
                    echo '<h3 class="event-heading">Tournament Information</h3>';
                    echo "<p>$tournaments</p>";
                }
                
                if ( $yafa ) {
                    echo '<h3 class="event-heading">Youth and Family Activities</h3>';
                    echo "<p>$yafa</p>";
                }
                
                if ( $volunteer ) {
                    echo '<h3 class="event-heading">Volunteer Information</h3>';
                    echo "<p>$volunteer</p>";
                }
                
                if( $merchants ) {
                    echo '<h3 class="event-heading">Merchant Information</h3>';
                    echo "<p>$merchants</p>";
                }
                
                if( $classes ) {
                    echo '<h3 class="event-heading">Classes Offered</h3>';
                    echo "<p>$classes</p>";
                }


?>
<hr/>
<p>This page was last updated: <?php the_modified_date(); ?></p>

					<!--<p>using template: wp-content/themes/polo-child/page-templates/page-event-single.php</p>-->
				</div>
			</div>
		</div>
	</section>

</div>
<!-- END: WRAPPER -->


	<?php polo_content_after(); ?>

	<?php get_footer(); ?>

<?php
/* WARNING! This file may change in the near future as we intend to add features to the event editor. If at all possible, try making customizations using CSS, jQuery, or using our hooks and filters. - 2012-02-14 */
/* 
 * To ensure compatability, it is recommended you maintain class, id and form name attributes, unless you now what you're doing. 
 * You also must keep the _wpnonce hidden field in this form too.
 */
global $EM_Event, $EM_Notices, $EM_Location, $bp;

$user = wp_get_current_user();
//print_r($user);
$is_event_steward = in_array( 'um_event-steward', (array) $user->roles );
$is_calendar_admin = in_array( 'um_calendar-admin', (array) $user->roles );

// needed for ACF fields that will be included later
acf_form_head();

//check that user can access this page
if( is_object($EM_Event) && (!$is_event_steward) ){
	?>
	
	<div class="wrap"><h2><?php esc_html_e('Unauthorized Access','events-manager'); ?></h2><p><?php echo sprintf(__('You do not have the rights to manage this %s.','events-manager'),__('Event','events-manager')); ?></p></div>
	<?php
	return false;
}elseif( !is_object($EM_Event) ){
	$EM_Event = new EM_Event();
}
//$required = apply_filters('em_required_html','<i>*</i>');

echo $EM_Notices;
//Success notice
if( !empty($_REQUEST['success']) ){
	if(!get_option('dbem_events_form_reshow')) return false;
}
?>
<!-- START FORM -->
<p><?php //print_r(  $args ); ?></p>
<div class="frm_forms  with_frm_style frm_style_formidable-style">
<form enctype='multipart/form-data' id="event-form" class="em-event-admin-editor <?php if( $EM_Event->is_recurring() ) echo 'em-event-admin-recurring' ?> frm-show-form frm_pro_form" method="post" action="<?php echo esc_url(add_query_arg(array('success'=>null))); ?>">
	<div class="wrap frm_form_fields">
	    <div class="frm_form_field frm_section_heading form-field">
		<?php do_action('em_front_event_form_header', $EM_Event); ?>
		</div>
		
	    
		<?php 
		// we aren't allowing anonymous submissions
		if(get_option('dbem_events_anonymous_submissions') && !is_user_logged_in()): ?>
			<h3 class="event-form-submitter"><?php esc_html_e( 'Your Details', 'events-manager'); ?></h3>
			<div class="inside event-form-submitter">
				<!--<p>-->
					<label class="frm_primary_label"><?php esc_html_e('Name', 'events-manager'); ?></label>
					<input type="text" name="event_owner_name" id="event-owner-name" value="<?php echo esc_attr($EM_Event->event_owner_name); ?>" />
				<!--</p>-->
				<!--<p>-->
					<label class="frm_primary_label"><?php esc_html_e('Email', 'events-manager'); ?></label>
					<input type="text" name="event_owner_email" id="event-owner-email" value="<?php echo esc_attr($EM_Event->event_owner_email); ?>" />
				<!--</p>-->
				<?php do_action('em_front_event_form_guest'); ?>
				<?php do_action('em_font_event_form_guest'); //deprecated ?>
			</div>
		<?php endif; ?>
		
		
		<?php 
		/********************************************
		 * To simplify this for right now, Calendar Admins are using
		 * the dashboard/back end to edit events. This page is only
		 * for Event Stewards. Therefore we're going to simplify and 
		 * just show the values of the fields that they can't edit
		 * and use the acf_form() function to display the custom fields 
		 * they can edit.
		 * 
		 * ******************************************
		 * 
		 */
		
		/* Calendar Admins and System Admins can update */
		
		if( $is_calendar_admin ) {
		/* for right now just print a message saying they should use the 
		* backend editor
		*/
		
		?>
		
		<div class="frm_form_field frm_section_heading form-field">
		    <h3 class="frm_pos_top event-form-name" style="border-top: 0;">Event Information</h3>
		    
		     <div class="frm_description frm_section_spacing">Please use the back-end editor to make updates to the event information.</div>
		     
		
		<?php
		/* Event Stewards aren't allowed to change some of the information 
		   So just display the info as a read only field unless we're a calendar deputy  */
		
		} elseif( $is_event_steward ) {
		    
		    $return_url =  "//{$_SERVER['HTTP_HOST']}/events/event-management/?view=future";

            $escaped_url = htmlspecialchars( $return_url, ENT_QUOTES, 'UTF-8' );
            //echo '<a href="' . $escaped_url . '">' . $escaped_url . '</a>';
		?>
		
		<div class="frm_form_field frm_section_heading form-field">
		    
		    <div class=""><p></p><a style="color: #11768D;" class="event-description" href="<?php echo $escaped_url ?>">Return to Event Management</a></p></div>
		    <h3 class="frm_pos_top event-form-name" style="border-top: 0;">Event Information</h3>
		    
		    <div class="frm_description frm_section_spacing">Please make updates to the event information below. You may not be able to change all values. If you need to change information you do not have access to, please contact the appropriate regional calendar deputy (calendar@antir.org, calendar@tirrigh.org, summitscalendar@antir.org). </div>


		    <div id="" class="frm_form_field form-field  frm_required_field frm_top_container">
               <label for="field_eif_event_name" class="frm_primary_label"> <?php esc_html_e( 'Name of Event: ', 'events-manager'); ?>
               <span class="readonly"><?php echo esc_attr($EM_Event->event_name,ENT_QUOTES); ?></span>
                </label>
                
		    </div>
		</div>

		   
			<?php
			/********************************************
		 * FIELDS THE EVENT STEWARD CAN'T EDIT
		 * just print out the values so they can see it
		 * ******************************************
		 */
        
        em_locate_template('forms/event/es-read-only-fields.php', true);
		
		
		/********************************************
		 * DATE & TIME 
		 * 
		 * ******************************************
		 */

		?>			
    		<!--<h3 class="frm_form_title event-form-when">Event Date and Time</h3>-->
    		<!--<div class="inside event-form-when">-->
    		<?php 
    			if( empty($EM_Event->event_id) && $EM_Event->can_manage('edit_recurring_events','edit_others_recurring_events') && get_option('dbem_recurrence_enabled') ){
    				em_locate_template('forms/event/when-with-recurring.php',true);
    			}elseif( $EM_Event->is_recurring() && $EM_Event->can_manage('edit_recurring_events','edit_others_recurring_events')  ){
    				em_locate_template('forms/event/recurring-when.php',true);
    			}elseif( is_admin() && $EM_Event->can_manage('edit_events') ){
    				em_locate_template('forms/event/when.php',true);
    			} else {
    			    //em_locate_template('forms/event/when-frontend.php', true);
    			}
    		?>
    	<!--	</div>-->
    	
    		<?php
		/********************************************
		 * EVENT ACTIVITIES (TAGS)
		 * this has to be a separate form
		 * ******************************************
		 */
        
        if(get_option('dbem_tags_enabled')) { em_locate_template('forms/event/tags.php',true); }
		?>
		
		<?php 
        /* Event Steward Editable Information */
        em_locate_template('forms/event/es-editable-fields.php',true);
        ?>
    
        
        
	

</form>
</div>
<!-- END FORM -->
<?php } ?>

<p>Using template /wp-content/themes/polo-child/plugins/templates/forms/event-editor.php</p>
<?php
/*
 * This file is called by templates/forms/location-editor.php to display fields for uploading images on your event form on your website. This does not affect the admin featured image section.
* You can override this file by copying it to /wp-content/themes/yourtheme/plugins/events-manager/forms/event/ and editing it there.
*/
global $EM_Event;
$user = wp_get_current_user();
//print_r($user);
$is_event_steward = in_array( 'um_event-steward', (array) $user->roles );
$is_calendar_admin = in_array( 'um_calendar-admin', (array) $user->roles );

/* Event Stewards aren't allowed to change some of the information 
but this is the information they can change!  */
		
if( $is_event_steward ) {
    
?>
    
    <div id="frm_field_111_container" class="frm_form_field frm_section_heading form-field ">
        <h3 class="frm_pos_top">Event Details</h3>
    </div>
    
    <div id="frm_field_acf_container" class="frm_form_field form-field">
<?php
    // get the ACF fields that we can edit
    $settings = array( 
        'post_id' => $EM_Event->post_id,
	    'new_post' => false,
	    'field_groups' => array('group_5b9f2ca871f62'),
	    'post_title' => false,
	    'post_content' => true,
	    'form' => true,
	    'submit_value' => __("Update", 'acf'),
	    'updated_message' => "<strong>Thank you for your updates. Your changes will be live immediately.</strong>",
	    'html_submit_button'	=> '<input type="submit" class="acf-button button button-primary button-large" value="%s" />'
	    );
	
	acf_form($settings);    
	
}
?>
 </div>   
    
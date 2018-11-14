<?php
/*
 * This file is called by templates/forms/location-editor.php to display fields for uploading images on your event form on your website. This does not affect the admin featured image section.
* You can override this file by copying it to /wp-content/themes/yourtheme/plugins/events-manager/forms/event/ and editing it there.
*/
global $EM_Event, $EM_Location;

$user = wp_get_current_user();
//print_r($user);
$is_event_steward = in_array( 'um_event-steward', (array) $user->roles );
$is_calendar_admin = in_array( 'um_calendar-admin', (array) $user->roles );


/* @var $EM_Event EM_Event
*  @var $EM_Location EM_Location
*/ 
//$categories = EM_Categories::get(array('orderby'=>'name','hide_empty'=>0));

/* need to grab the ACF values */

//$myCustomEventVals = get_fields($EM_Event->post_id);
//print_r($myCustomEventVals);

/* Event Stewards aren't allowed to change some of the information 
		   So just display the info as a read only field unless we're a calendar deputy  */
		
if( $is_event_steward ) {
    $branch_location = get_field( "event_branch_location_from_eif", $EM_Event->post_id );
    if(is_array($branch_location)) {
        $branch_location = $branch_location[0];
    }
    
    $hosting_branches = get_field( "event_hosting_branch_from_eif", $EM_Event->post_id );
    //print_r($hosting_branches);
    
    if(is_array($hosting_branches)) {
        $hosting_branch = '';
        
        foreach($hosting_branches as $branch ) {
            $hosting_branch .= "$branch<br/>";    
        }
    }
    
    $event_level = get_field( "event_level_from_eif", $EM_Event->post_id );
    $conflicts_allowed = get_field( "event_conflict_zone_waived_from_eif", $EM_Event->post_id );
    $allowed_conflicts = get_field( "event_conflict_branches_from_eif", $EM_Event->post_id );
    
    $EM_Location = $EM_Event->get_location();
    
    $membership_expiration = get_field( "event_steward_membership_expiration", $EM_Event->post_id );
    $membership_expiration = new DateTime($membership_expiration);
    
    ?>

     <?php // Event region/location/host ?>
    <div id="frm_field_13_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_first">
        <label for="field_eif_event_region" class="frm_primary_label">Event Region:
            <span class="readonly"><?php echo get_field( "event_region_from_eif", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eig_event_branch_location" class="frm_primary_label">Branch where event will be held:
            <span class="readonly"><?php echo $branch_location ?></span>
        </label>
        <label for="field_eif_event_hosting_branch2" class="frm_primary_label">Hosting Branch(es):
        <span class="readonly"><?php echo $hosting_branch ?></span>
    </label>
    </div>
    
    <div id="frm_field_12_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_last">
        <label for="field_eif_event_start_date" class="frm_primary_label">Event starts:
            <span class="readonly"><?php echo $EM_Event->start()->format('m/d/Y g:i a'); ?></span>
        </label>
        <label for="field_eig_event_end_date" class="frm_primary_label">Event ends:
            <span class="readonly"><?php echo $EM_Event->end()->format('m/d/Y g:i a'); ?></span>
        </label>
    </div>
    
    
    <?php // Event Level & Conflicts ?>
    <div id="frm_field_17_container" class="frm_form_field form-field  frm_required_field frm_top_container">
    <label for="field_eif_event_level" class="frm_primary_label">Event Level:
        <span class="readonly"><?php echo ucfirst($event_level) ?></span>
    </label>
    
    <?php
    if( $event_level == 'level1' && ($conflicts_allowed == 'Yes') && $allowed_conflicts ){
        $conflicts = '';
        foreach( $allowed_conflicts as $ac ) {
            $conflicts .= "$ac";
            
            end($allowed_conflicts);
            if ($ac === key($allowed_conflicts)) {
                $conflicts .= '';
            } else {
                $conflicts .= ' , ';
            }
        }
    
    ?>
        <label for="field_eif_event_conflict_zone_waived" class="frm_primary_label">This is a level 1 event which allows the following branches to conflict:
            <span class="readonly"><?php echo $conflicts ?></span>
        </label>
    
    <?php
    
    } elseif( $event_level == 'level1' && ($conflicts_allowed == 'No') )  {
    ?>    
        <label for="field_eif_event_conflict_zone_waived" class="frm_primary_label">This is a level 1 event which does not allow conflicts.
        </label>
    <?php    
    }
 

   ?>
 
   <?php // Seneschal Information ?>
   
   <div id="frm_field_152_container" class="frm_form_field frm_section_heading form-field ">
        <h3 class="frm_pos_top">Seneschal Information</h3>
    </div>

    <div id="frm_field_84_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_first">
        <label for="field_eif_event_seneschal_sca_name" class="frm_primary_label">Seneschal's SCA Name:
            <span class="readonly"><?php echo get_field( "senechal_sca_name_from_eif", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_seneschal_sca_name" class="frm_primary_label">Seneschal's Facebook Name:
            <span class="readonly"><?php echo get_field( "seneschal_facebook_name_from_eif", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_seneschal_legal_name" class="frm_primary_label">Seneschal's Primary contact phone number:
            <span class="readonly"><?php echo get_field( "senechal_phone_primary_from_eif", $EM_Event->post_id ); ?></span>
        </label>
   
    
    
    </div>

    <div id="frm_field_85_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_alignright frm_half frm_two_col">
        <label for="field_eif_event_seneschal_legal_name" class="frm_primary_label">Seneschal's Legal Name:
            <span class="readonly"><?php echo get_field( "seneschal_legal_name_from_eif", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_seneschal_legal_name" class="frm_primary_label">Seneschal's Email address:
            <span class="readonly"><?php echo get_field( "seneschal_email_address_from_eif", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_seneschal_legal_name" class="frm_primary_label">Seneschal's Secondary contact phone number:
            <span class="readonly"><?php echo get_field( "seneschal_phone_secondary_from_eif", $EM_Event->post_id ); ?></span>
        </label>

    </div>
    
    <?php
    // Site/Location Information
    
    //print_r($EM_Event->get_location());
    ?>
    <div id="frm_field_92_container" class="frm_form_field frm_section_heading form-field ">
        <h3 class="frm_pos_top">Site Information</h3>
    </div>
    
    <?php
    if( $EM_Event->get_location()->location_id ) {
        ?>
        
    <div id="frm_field_95_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_first">
        <label for="field_eif_event_site_name_from_eif" class="frm_primary_label">Site:<br/>
            <span class="readonly">
                <?php echo $EM_Location->location_name; ?><br/>
                <?php echo $EM_Location->location_address; ?><br/>
                <?php echo $EM_Location->location_town; ?>, <?php echo $EM_Location->location_state; ?> <?php echo $EM_Location->location_postcode; ?> (<?php echo $EM_Location->location_country; ?>)<br/>
            </span>
        </label>
    </div>
    
    <!--
    <div id="frm_field_85_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_alignright frm_half frm_two_col">
            <label for="edit_site_button" class="frm_primary_label">Change Site:</label>
            <input id="add_site_button" type="button" class="frm_submit input[type=button] acf-button button button-secondary button-large" value = "Change Site"> 
    </div>
    -->
<?php 
    // no location yet so display the "add a location button"
    } else { ?>
    <p>Site TBD</p>
     <!--   
    <div id="frm_field_95_container" class="frm_form_field form-field  frm_required_field frm_top_container">
        
        <label for="add_site_button" class="frm_primary_label">Site:</label>
        <input id="add_site_button" type="button" class="acf-button button button-secondary button-large" value = "Add Site Information"> 
        
    </div>
    -->
    <?php
    }
    ?>
    
    <?php
    // Event Steward Information
    
    ?>
    <div id="frm_field_111_container" class="frm_form_field frm_section_heading form-field ">
        <h3 class="frm_pos_top">Event Steward Information</h3>
    </div>
    
    <div id="frm_field_113_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_first">
        <label for="field_eif_event_es_sca_name" class="frm_primary_label">Event Steward's SCA Name:
            <span class="readonly"><?php echo get_field( "event_steward_sca_name", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_es_sca_name" class="frm_primary_label">Event Steward's Facebook Name:
            <span class="readonly"><?php echo get_field( "event_steward_facebook_name", $EM_Event->post_id ); ?></span>
        </label>
        <label for="field_eif_event_es_sca_name" class="frm_primary_label">Event Steward's Phone Number:
            <span class="readonly"><?php echo get_field( "event_steward_phone_number", $EM_Event->post_id ); ?></span>
        </label>
    </div>
    
    <div id="frm_field_116_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_alignright frm_half frm_two_col">
        <label for="field_eif_event_es_legal_name" class="frm_primary_label">Event Steward's Legal Name: 
            <span class="readonly"><?php echo get_field( "event_steward_legal_name", $EM_Event->post_id ); ?></span>
        </label>
    
        <label for="field_eif_event_es_legal_name" class="frm_primary_label">Event Steward's Email Address: 
            <span class="readonly"><?php echo get_field( "event_steward_email_address", $EM_Event->post_id ); ?></span>
        </label>
        
        <label for="field_eif_event_es_legal_name" class="frm_primary_label">Event Steward's Membership Info: 
            <span class="readonly">#<?php echo get_field( "event_steward_membership_number", $EM_Event->post_id ); ?> expires: <?php echo $membership_expiration->format('m/d/Y'); ?> </span>
        </label>
    
    </div>
    
   <?php } ?>

<?php if( 0 ):  //count($categories) > 0 ): ?>

<h3>Event Host(s)</h3>
<div class="event-categories">
	<!-- START Categories -->
	<label for="event_categories[]"><?php _e ( 'Host(s):', 'events-manager'); ?></label>
	<select name="event_categories[]" multiple size="2">
	<?php
	$selected = $EM_Event->get_categories()->get_ids();
	$walker = new EM_Walker_CategoryMultiselect();
	$args_em = array( 'hide_empty' => 0, 'name' => 'event_categories[]', 'hierarchical' => true, 'id' => EM_TAXONOMY_CATEGORY, 'taxonomy' => EM_TAXONOMY_CATEGORY, 'selected' => $selected, 'walker'=> $walker);
	echo walk_category_dropdown_tree($categories, 0, $args_em);
	?></select>
	<!-- END Categories -->
</div>
<?php endif; ?>

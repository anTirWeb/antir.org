<?php
/*
 * This file is called by templates/forms/event-editor.php to display tags on your event form on your website.
* You can override this file by copying it to /wp-content/themes/yourtheme/plugins/events-manager/forms/event/ and editing it there.
*/
global $EM_Event, $EM_Location;
/* @var $EM_Event EM_Event */ 

/* Get the tags but filter out the Level 1, etc. tags */
$all_tags = EM_Tags::get(array('orderby'=>'name','hide_empty'=>0, 'exclude'=>'13'));

$my_tags = get_the_terms($EM_Event->post_id, EM_TAXONOMY_TAG);

//print_r($my_tags);

//foreach($em_tags as $tag ){
//     array_push( $em_tag_ids, $tag->id );
// }
//$em_tag_ids = $em_tags->get_ids();
//print_r($em_tag_ids);
?>

<?php if( count($all_tags) > 0 ) { 

if(!is_admin() ) {
?>

<div class="frm_form_field frm_section_heading form-field ">
    <h3 class="frm_pos_top">Event Activities</h3>
</div>

<div class="event-activities">
	<!-- START Tags/Activities -->
	 <label for="event_tags[]" class="frm_primary_label">
	     <?php _e ( 'Activities', 'events-manager'); ?></label>
	<label for="">
	<br/><span style="color: #696f6f;">
		<?php esc_html_e('Choose as many as apply. Hold down the CTRL button to choose multiple activities', 'events-manager'); ?></span><br/>
	
	<select class="frm_chzn" name="event_tags[]"  size="15" style="height: 150px !important;" multiple>
	<?php
 	 
 	$selected = array();
 	foreach($my_tags as $t ) {
 	    //echo "$t->term_id is selected | ";
 	    array_push($selected, $t->term_id);
 	}
    
	$walker = new EM_Walker_CategoryMultiselect();
	//$chk_walker = new Walker_Category_Checklist('tag');
	
	$args_em = array( 'hide_empty' => 0, 'name' => 'event_tags[]', 'hierarchical' => false, 'id' => EM_TAXONOMY_TAG, 'taxonomy' => EM_TAXONOMY_TAG, 'checked_ontop' => false, 'selected' => $selected, 'walker'=> $walker);
    echo walk_category_dropdown_tree($all_tags, 0, $args_em);
	
	
	?>
	</select>
	
	<!-- END Tags/Amenities -->
	<p class="submit">
	    <?php if( empty($EM_Event->event_id) ): ?>
	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Submit %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
	    <?php else: ?>
	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Update %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
	    <?php endif; ?>
	</p>
	<input type="hidden" name="event_id" value="<?php echo $EM_Event->event_id; ?>" />
	    <input type="hidden" name="post_id" value="<?php echo $EM_Event->post_id; ?>" />
	    <input type="hidden" name="event_name" id="event-name" value="<?php echo esc_attr($EM_Event->event_name,ENT_QUOTES); ?>" />
	    <input type="hidden" name="event_start_date" value="<?php echo $EM_Event->start()->getDate(); ?>" />
	    <input type="hidden" name="event_end_date" value="<?php echo $EM_Event->end()->getDate(); ?>" />
	    <input type="hidden" name="location_id" id='location-select-id' value="<?php echo esc_attr($EM_Location->location_id) ?>" />
	    <input type="hidden" name="location_name" id="location-name" value="<?php echo esc_attr($EM_Location->location_name, ENT_QUOTES); ?>" />
	    <input type="hidden" name="location_address" id="location-address" value="<?php echo esc_attr($EM_Location->location_address); ?>" />
	    <input type="hidden" name="location_town" id="location-town" value="<?php echo esc_attr($EM_Location->location_town); ?>" />
	    <input type="hidden" name="location_state" id="location-state"  value="<?php echo esc_attr($EM_Location->location_state); ?>" />
	    <input type="hidden" name="location_postcode" id="location-postcode" value="<?php echo esc_attr($EM_Location->location_postcode); ?>" />
	    <input type="hidden" name="location_country" id="location-country" value="<?php if($EM_Location->location_country){echo esc_attr($EM_Location->location_country);}else{ echo 'US'; ?>" />
	    
	    
	    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpnonce_event_save'); ?>" />
	    <input type="hidden" name="action" value="event_save" />
	    <?php if( !empty($_REQUEST['redirect_to']) ): ?>
	    <input type="hidden" name="redirect_to" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
	    <?php endif; ?>
	    </form>
</div>

<?php } }?>
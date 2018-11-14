<?php
global $EM_Event, $post;
$hours_format = em_get_hour_format();
$required = apply_filters('em_required_html','<i>*</i>');

//um_fetch_user( get_current_user_id() );
//$um_user_role = $ultimatemember->user->get_role();
//$um_user_role = 'event_steward';

?>
<?php 
/********************************************
 * DATE & TIME 
 * 
 * ******************************************
 * 
*/

//print_r($EM_Event);

/* Event Stewards aren't allowed to change some of the information 
		   So just display the info as a read only field unless we're a calendar deputy  */
		
if( $EM_Event->can_manage('edit_events' ) && !$EM_Event->can_manage('edit_others_events') ) {
 ?>
 
 
    <div id="frm_field_12_container" class="frm_form_field form-field  frm_required_field frm_top_container frm_two_col frm_half frm_last">
        <label for="field_eif_event_start_date" class="frm_primary_label">Event starts:
            <span class="readonly"><?php echo $EM_Event->start()->format('m/d/Y g:i a'); ?></span>
        </label>
        <label for="field_eig_event_end_date" class="frm_primary_label">Event ends:
            <span class="readonly"><?php echo $EM_Event->end()->format('m/d/Y g:i a'); ?></span>
        </label>
    </div>
    

<?php 
}
<?php
/*
 * This file is called by templates/forms/event-editor.php to display tags on your event form on your website.
* You can override this file by copying it to /wp-content/themes/yourtheme/plugins/events-manager/forms/event/ and editing it there.
*/
global $EM_Event, $EM_Location;
/* @var $EM_Event EM_Event */ 

/* Get the tags but filter out the Level 1, etc. tags */
$all_tags = EM_Tags::get(array('orderby'=>'name','hide_empty'=>0, 'exclude'=>'13'));

$tag_names = array();

foreach ($all_tags as $tag ) {
    $tag_names[$tag->term_id] = $tag->name;
}
//print_r($tag_names);

//foreach($em_tags as $tag ){
//     array_push( $em_tag_ids, $tag->id );
// }
//$em_tag_ids = $em_tags->get_ids();
//print_r($em_tag_ids);

if( count($all_tags) > 0 ) { 
    
    
    if(!is_admin() ) {
       $my_tags = array();
       
       if( $_POST['action'] == 'save_activities') {
           //echo "Getting here";
           // I'm getting Ids and I need names.
           $tags = $_POST['event_tags'];
        //   echo "<p>Before </p>";
        //   print_r($tags);
           
           $my_tag_names = array();
           foreach($tags as $tag ) {
               if($tag_names[$tag]) {
                    array_push( $my_tag_names, $tag_names[$tag]);
                }
               //print_r($my_tag_names);
           }
           $return = wp_set_post_terms( $_POST['post_id'], $my_tag_names, EM_TAXONOMY_TAG, false );
           //echo "Returned:";
           $my_tags = get_the_terms($EM_Event->post_id, EM_TAXONOMY_TAG);
           //echo "<p>After </p>";
            //print_r($my_tags);
            //print_r($return);
           if( !$return ) {
            //$my_tags = get_the_terms($EM_Event->post_id, EM_TAXONOMY_TAG);
            echo "<p>Unable to save activities. </p>";
            //print_r($my_tags);
           } 
           ?>
           <form enctype='multipart/form-data' id="event-form" class="em-event-admin-editor frm-show-form frm_pro_form" method="post" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
	
    <div class="event-activities">
	    <!-- START Tags/Activities -->
	    <div class="frm_form_field frm_section_heading form-field ">
            <h3 class="frm_pos_top">Event Activities</h3>
   
	        <span style="color: #696f6f;">
		        <?php esc_html_e('Choose as many as apply. Hold down the CTRL button and click to choose multiple activities. If you click on a single activity and clear all of the selected activities by mistake, simply reload the page to get them back.', 'events-manager'); ?>
		    </span><br/><br/>
	    </div>
	 
	  <?php
    	    $selected = array();
    	    //print_r($my_tags);
        	foreach( $my_tags as $t ) {
        	    array_push( $selected, $t->term_id );
        	}
        	?>
	    <select class="frm_chzn" name="event_tags[]"  id="event_tags" size="15" style="height: 150px !important;" multiple>
	
	   <?php
        	
        	$walker = new EM_Walker_CategoryMultiselect();
        	
        	$args_em = array( 'hide_empty' => 0, 'name' => 'event_tags[]', 'hierarchical' => false, 'id' => EM_TAXONOMY_TAG, 'taxonomy' => EM_TAXONOMY_TAG, 'checked_ontop' => false, 'selected' => $selected, 'walker'=> $walker);
            
            echo walk_category_dropdown_tree($all_tags, 0, $args_em);
    	
    	?>
    	</select>
        <!-- END Tags/Amenities -->
	
	    <p class="submit">
    	    <?php if( empty($my_tags) ): ?>
    	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Submit %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
    	    <?php else: ?>
    	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Update %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
    	    <?php endif; ?>
    	</p>
	    <input type="hidden" name="event_id" value="<?php echo $EM_Event->event_id; ?>" />
	    <input type="hidden" name="action" value="save_activities" />
	    <input type="hidden" name="post_id" value="<?php echo $EM_Event->post_id; ?>" />
	    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpnonce_event_save'); ?>" />
	    <!--<input type="hidden" name="action" value="event_save" />-->
	    <?php if( !empty($_REQUEST['redirect_to']) ): ?>
	    <input type="hidden" name="redirect_to" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
	    <?php endif; ?>
    </div>
</form>
<?php
       } else {
           $my_tags = get_the_terms($EM_Event->post_id, EM_TAXONOMY_TAG);

           ?>
            <form enctype='multipart/form-data' id="event-form" class="em-event-admin-editor frm-show-form frm_pro_form" method="post" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
	
    <div class="event-activities">
	    <!-- START Tags/Activities -->
	    <div class="frm_form_field frm_section_heading form-field ">
            <h3 class="frm_pos_top">Event Activities</h3>
   
	        <span style="color: #696f6f;">
		        <?php esc_html_e('Choose as many as apply. Hold down the CTRL button and click to choose multiple activities. If you click on a single activity and clear all of the selected activities by mistake, simply reload the page to get them back.', 'events-manager'); ?>
		    </span><br/>
	    </div>
	 
	    <select class="frm_chzn" name="event_tags[]"  id="event_tags" size="15" style="height: 150px !important;" multiple>
	
	    <?php
    	    $selected = array();
    	    //print_r($my_tags);
        	foreach( $my_tags as $t ) {
        	    array_push( $selected, $t->term_id );
        	}
        	
        	$walker = new EM_Walker_CategoryMultiselect();
        	
        	$args_em = array( 'hide_empty' => 0, 'name' => 'event_tags[]', 'hierarchical' => false, 'id' => EM_TAXONOMY_TAG, 'taxonomy' => EM_TAXONOMY_TAG, 'checked_ontop' => false, 'selected' => $selected, 'walker'=> $walker);
            
            echo walk_category_dropdown_tree($all_tags, 0, $args_em);
    	
    	?>
    	</select>
        <!-- END Tags/Amenities -->
	
	    <p class="submit">
    	    <?php if( empty($my_tags) ): ?>
    	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Submit %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
    	    <?php else: ?>
    	    <input type='submit' class='acf-button button button-primary' value='<?php echo esc_attr(sprintf( __('Update %s','events-manager'), __('Event Activities','events-manager') )); ?>' />
    	    <?php endif; ?>
    	</p>
	    <input type="hidden" name="event_id" value="<?php echo $EM_Event->event_id; ?>" />
	    <input type="hidden" name="action" value="save_activities" />
	    <input type="hidden" name="post_id" value="<?php echo $EM_Event->post_id; ?>" />
	    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpnonce_event_save'); ?>" />
	    <!--<input type="hidden" name="action" value="event_save" />-->
	    <?php if( !empty($_REQUEST['redirect_to']) ): ?>
	    <input type="hidden" name="redirect_to" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
	    <?php endif; ?>
    </div>
</form>
<?php
}
} 
}?>
<?php
	//TODO Simplify panel for events, use form flags to detect certain actions (e.g. submitted, etc)
	global $wpdb, $bp, $EM_Notices, $EM_Events;
	/* @var $args array */
	/* @var $EM_Events array */
	/* @var $events_count int */
	/* @var $future_count int */
	/* @var $past_count int */
	/* @var $pending_count int */
	/* @var $url string */
	/* @var $show_add_new bool */
	/* @var $limit int */
	//add new button will only appear if called from em_event_admin template tag, or if the $show_add_new var is set
	?>
	
	<div class="em-events-admin-list">
	    <?php 
	    /* Draft events are going to have to be hidden for now. I can't get them reliably. */
	    
	    $myobj = $obj = $myEvents = $myFutureEvents = $myPendingEvents = $myDraftEvents = [];
	    $user = wp_get_current_user();
	    //print_r($user);
	    $is_event_steward = in_array( 'um_event-steward', (array) $user->roles );
	    $is_calendar_admin = in_array( 'um_calendar-admin', (array) $user->roles );
	    
	    // Get all events - not just this user's events
	    if( $is_calendar_admin ) {
	        $welcome_msg = "<h3>Welcome Calendar Admin</h3><p>Please use the backend editor to make changes to events.</p>";
	        
	       // $myEvents = EM_Events::get( array( 'order'=>'DESC', 'orderby'=>'date', 'scope' =>'all') );
	       // //$myFutureEvents = EM_Events::get( array(  'order'=>'DESC', 'scope' =>'future', 'orderby' => 'date'));
	       // $myPendingEvents = EM_Events::get( array(  'order'=>'DESC', 'status' => 0, 'orderby' => 'date'));
	       // //$myDraftEvents = EM_Events::get( array(  'order'=>'DESC', 'status' => null, 'orderby' => 'date'));
	       // $myPastEvents = EM_Events::get( array(  'order'=>'DESC', 'scope' => 'past', 'orderby' => 'date'));
	       // //$args['owner'] = '';
	       // $args['view'] = 'future';
	        
	       //$myFuturePublishedEvents = EM_Events::get( array( 'order'=>'DESC', 'scope'=>'future', 'status'=> '1', 'orderby'=>'date') );
	       ////$myFutureDraftEvents = EM_Events::get( array( 'order'=>'DESC', 'scope'=>'future', 'status'=> null, 'orderby'=>'date') );
	       //$myFuturePendingEvents = EM_Events::get( array( 'order'=>'DESC', 'scope'=>'future', 'status'=> '0', 'orderby'=>'date') );
	       //$myFutureEvents = array_merge( $myFuturePublishedEvents, $myFuturePendingEvents );
	       //$myFutureEvents = array_map("unserialize", array_unique(array_map("serialize", $myFutureEvents)));
	       //sort( $myFutureEvents );
	       ////print_r($myFutureEvents);
	        
	       // $myEvents = $myFutureEvents;
	        
	        //print_r($args);
	       // $args['status'] = 1;
	       
	       // print_r($myEvents);
	        
	   
	    } else if( $is_event_steward ) {
	       
	       $welcome_msg = "<h3>Welcome Event Steward</h3><p>You can edit your own events and save changes but a Calendar Admin needs to approve them before they can be published. Please proceed with caution.</p>";
	       //echo "Getting here.<br/>Owner is " . $args['owner'] . "<br/>";
	       
	       //$args['view'] = 'future';
	       
	       //$myobj = EM_Events::get( array(  'event' => '798', 'orderby'=>'date', 'owner' => $args['owner'] ) );
	       //print_r($myobj);
	       
	       // Future and past published events 
	       $myEvents = EM_Events::get( array( 'order'=>'DESC', 'orderby'=>'date', 'scope'=>'all', 'status' => '1', 'owner' => $args['owner']) );
	       //echo "Found " . count($myEvents) . " events total for this user<br/>";
	       
	       // Future events published and pending
	       
	       $myFuturePublishedEvents = EM_Events::get( array( 'order'=>'DESC', 'scope'=>'future', 'status'=> '1', 'orderby'=>'date', 'owner' => $args['owner']) );
	       $myFuturePendingEvents = EM_Events::get( array( 'order'=>'DESC', 'scope'=>'future', 'status'=> '0', 'orderby'=>'date', 'owner' => $args['owner']) );
	       $myFutureEvents = array_merge( $myFuturePublishedEvents, $myFuturePendingEvents );
	       $myFutureEvents = array_map("unserialize", array_unique(array_map("serialize", $myFutureEvents)));
	       sort( $myFutureEvents );
	
	       
	       // Pending future events
	       $myPendingEvents = EM_Events::get( array( 'order'=>'DESC', 'status'=>0, 'scope'=>'future', 'orderby'=>'date', 'owner' => $args['owner']) );
	       
	       // all the events
	       $myEvents = array_merge( $myFutureEvents, $myPendingEvents );
	       $myEvents = array_map("unserialize", array_unique(array_map("serialize", $myEvents)));
	       sort( $myEvents );
	       //print_r($myEvents);
	       
	       /* Draft events aren't working right now
	       $myDraftEvents = EM_Events::get( array( 'order'=>'DESC', 'status'=>'', 'scope'=>'future', 'orderby'=>'date', 'owner' => $args['owner']) );
	       
	       // let's try getting the events another way
	       
	       $draftEvents = $wpdb->get_results( $query = 'SELECT * FROM `' . $wpdb->prefix.'em_events` where event_owner=' . $args['owner'] . ' and event_status IS NULL', ARRAY_N );
	       echo count($draftEvents) . ' draft events found in the db';
	       print_r($draftEvents);
	       // THIS DOESN'T GET A VALUE!!!
	       $obj = EM_Events::get( array( 'event' => 798 ) );
	       print_r($obj);
	       
	       $my_draft_evts = [];
	       
	       if( $draftEvents ) {
	           
	           foreach($draftEvents as $evt ) {
	               $eid = $evt[1];
	               print_r($eid);
	               $obj = EM_Events::get( array( 'post_id' => 6672 ) );
	               print_r($obj);
	               array_push($my_draft_evts, $obj);
	               print_r($obj);
	           }
	           
	       }
	       
	       */
	       
	    } else {
	       $welcome_msg = "<p>You do not seem to have permission to be here</p>";
	        //$myEvents = array();
	    }
	    
	   // how many events do we have? 
	   
	   $events_count = $future_count = $pending_count = 0;
	   
	   $events_count = count($myEvents);
	   $future_count = count($myFutureEvents);
	   $pending_count = count($myPendingEvents);
	   
	   
	   if ( $is_event_steward ) {
	       if( isset($_GET['view']) ) {
    	       if( $_GET['view'] && $_GET['view'] == 'pending' ) {
    	           $EM_Events = $myPendingEvents;
    	       } elseif ( $_GET['view'] && $_GET['view'] == 'future' ) {
    	           $EM_Events = $myFutureEvents;
    	       } else {
    	          $EM_Events = $myFutureEvents; 
    	       }
	       } else {
	           $EM_Events = $myFutureEvents;
	        //$EM_Events = $myEvents;
	       }
	   }
	    ?>
	    
		<?php
			echo $EM_Notices;
			
			// hide the add new button
			$show_add_new = 0;
			if(!empty($show_add_new) && $is_event_steward ) {
			    echo '<a class="em-button button add-new-h2" href="'.em_add_get_params($_SERVER['REQUEST_URI'],array('action'=>'edit','scope'=>null,'status'=>null,'event_id'=>null, 'success'=>null)).'">'.__('Add New','events-manager').'</a>';
			}
		?>
		<div class="frm_forms  with_frm_style frm_style_formidable-style">
		    <p><?php echo $welcome_msg; ?></p>
		    <div style='border: 1px solid darkgrey; padding: 8px; margin: 8px;'>
		        <h4>About status:</h4>
		        <p>"Published" means that the event is visible to the public on the upcoming events page.</p>
		        <p>"Pending" means that someone has made changes to a published event and it needs Admin approval to be published again. <strong>Pending events are not visible on the upcoming events page.</strong></p>
		        <p>Newly created events will not show up in this list until they are approved by an Admin.</p>
		    </div>
		<form id="posts-filter" action="" method="get">
		    <div class="frm_form_fields">
			  <div class="subsubsub frm_fields_container">
				<?php $default_params = array('em_search'=>null,'pno'=>null); //template for cleaning the link for each view below ?>
				
				<?php // Get upcoming events we can edit ?>
				<?php
				if( $future_count > 0 ) { ?>
				<a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view'=>'future')); ?>' <?php echo ( !isset($_GET['view']) ) ? 'class="current"':''; ?>><?php _e ( 'Upcoming', 'events-manager'); ?> <span class="count">(<?php echo $future_count; ?>)</span></a> 
				
				<?php 
				}
				
				if( $pending_count > 0 ) { 
				  echo '&nbsp;|&nbsp'; 
				?>
				<a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view'=>'pending')); ?>' <?php echo ( isset($_GET['view']) && $_GET['view'] == 'pending' ) ? 'class="current"':''; ?>><?php _e ( 'Pending', 'events-manager'); ?> <span class="count">(<?php echo $pending_count; ?>)</span></a> 
			
			  </div>
			  <?php
			}
				?>
	
			<?php // Search for an event ?>
			<div class="frm_form_field form-field frm_top_container">
				<label class="frm_primary_label screen-reader-text" for="post-search-input"><?php _e('Search Events','events-manager'); ?>:</label>
				<input type="text" id="post-search-input" name="em_search" value="<?php echo (!empty($_REQUEST['em_search'])) ? esc_attr($_REQUEST['em_search']):''; ?>" />
				<?php if( !empty($_REQUEST['view']) ): ?>
				<input type="hidden" name="view" value="<?php echo esc_attr($_REQUEST['view']); ?>" />
				<?php endif; ?>
				<div class="frm_submit" style="display: inline;">
				    <input type="submit" value="<?php _e('Search Events','events-manager'); ?>" class="frm_button_submit" />
				</div>
			</p>
			</div>
			
			<div class="tablenav">
				<?php
			
				if ( $events_count >= $limit ) {
					$events_nav = em_admin_paginate( $events_count, $limit, $page);
					echo $events_nav;
				}
				?>
				<br class="clear" />
			</div>
				
			<?php
			if ( empty($EM_Events) ) {
			    echo get_option ( 'dbem_no_events_message' );
			} else {
			?>
					
			<table class="widefat events-table">
				<thead>
					<tr>
						<?php /* 
						<th class='manage-column column-cb check-column' scope='col'>
							<input class='select-all' type="checkbox" value='1' />
						</th>
						*/ ?>
						<th><?php _e ( 'Name', 'events-manager'); ?></th>
						<th>Event Level</th>
						<th><?php _e ( 'Site', 'events-manager'); ?></th>
						<th colspan="2"><?php _e ( 'Date and time', 'events-manager'); ?></th>
						
						<th>Region</th>
						<th>Has EIF?</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$rowno = 0;
					foreach ( $EM_Events as $EM_Event ) {
						/* @var $EM_Event EM_Event */
						$rowno++;
						$class = ($rowno % 2) ? 'alternate' : '';
						$location_summary = "<b>" . esc_html($EM_Event->get_location()->location_name) . "</b><br/>" . esc_html($EM_Event->get_location()->location_address) . " - " . esc_html($EM_Event->get_location()->location_town);
						
						$myEventId = $EM_Event->get_id();
					    $myPostId = $wpdb->get_var( "SELECT post_id FROM {$wpdb->prefix}em_events WHERE event_id = " . $myEventId );
						
						if( $EM_Event->start()->getTimestamp() < time() && $EM_Event->end()->getTimestamp() < time() ){
							$class .= " past";
						}
						
						$status = $EM_Event->get_status();
						
						//Check pending approval events
						if ( !$status ){
							$class .= " pending";
							$status = 'Pending';
						}					
						?>
						<tr class="event <?php echo trim($class); ?>" id="event_<?php echo $EM_Event->event_id ?>">
							<?php /*
							<td>
								<input type='checkbox' class='row-selector' value='<?php echo $EM_Event->event_id; ?>' name='events[]' />
							</td>
							*/ ?>
							<td>
								<strong>
									<a class="row-title" href="<?php echo esc_url($EM_Event->get_edit_url()); ?>"><?php echo esc_html($EM_Event->event_name); ?></a>
								</strong>
								<?php 
								if( get_option('dbem_rsvp_enabled') == 1 && $EM_Event->event_rsvp == 1 ){
									?>
									<br/>
									<a href="<?php echo $EM_Event->get_bookings_url(); ?>"><?php esc_html_e("Bookings",'events-manager'); ?></a> &ndash;
									<?php esc_html_e("Booked",'events-manager'); ?>: <?php echo $EM_Event->get_bookings()->get_booked_spaces()."/".$EM_Event->get_spaces(); ?>
									<?php if( get_option('dbem_bookings_approval') == 1 ): ?>
										| <?php _e("Pending",'events-manager') ?>: <?php echo $EM_Event->get_bookings()->get_pending_spaces(); ?>
									<?php endif;
								}
								?>
								<div class="row-actions">
									<?php if( $is_calendar_admin ) : ?>
									<span class="trash"><a href="<?php echo esc_url(add_query_arg(array('action'=>'event_delete', 'event_id'=>$EM_Event->event_id, '_wpnonce'=> wp_create_nonce('event_delete_'.$EM_Event->event_id)))); ?>" class="em-event-delete"><?php _e('Delete','events-manager'); ?></a></span>
									<?php endif; ?>
								</div>
							</td>
							
							<!--<td>-->
							<!--	<a href="<?php //echo $EM_Event->duplicate_url(); ?>" title="<?php //_e ( 'Duplicate this event', 'events-manager'); ?>">-->
							<!--		<strong>+</strong>-->
							<!--	</a>-->
							<!--</td>-->
							
							<?php
							    $myEventId = $EM_Event->get_id();
							    $myEventLevel = $wpdb->get_var( "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'event_level_from_eif' and post_id = " . $myPostId );
							
							    echo "<td>$myEventLevel</td>";    
							?>
							
							<td>
								<?php echo $location_summary; ?>
							</td>
							<td>
								<?php echo $EM_Event->output_dates('m/d/Y'); ?>
								<br />
								<?php echo $EM_Event->output_times(); ?>
							</td>
							
							<td>
							<?php 
								if ( $EM_Event->is_recurrence() ) {
									$recurrence_delete_confirm = __('WARNING! You will delete ALL recurrences of this event, including booking history associated with any event in this recurrence. To keep booking information, go to the relevant single event and save it to detach it from this recurrence series.','events-manager');
									?>
							
									<strong>
									<?php echo $EM_Event->get_recurrence_description(); ?> <br />
									<a href="<?php echo esc_url($EM_Event->get_edit_reschedule_url()); ?>"><?php _e ( 'Edit Recurring Events', 'events-manager'); ?></a>
									<?php if( $is_calendar_admin ) : ?>
									<span class="trash"><a href="<?php echo esc_url(add_query_arg(array('action'=>'event_delete', 'event_id'=>$EM_Event->recurrence_id, '_wpnonce'=> wp_create_nonce('event_delete_'.$EM_Event->recurrence_id)))); ?>" class="em-event-rec-delete" onclick ="if( !confirm('<?php echo $recurrence_delete_confirm; ?>') ){ return false; }"><?php _e('Delete','events-manager'); ?></a></span>
									<?php endif; ?>										
									</strong>
								
									<?php
								}
								?>
							</td>
							
						
							<?php
							// add Region
							
							$region =  $wpdb->get_var( "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'event_region_from_eif' and post_id = " . $myPostId );
							//$region = $myEventId;
							
							echo "<td>$region</td>";
							?>
							
							
							<?php
							// check for EIF
							
							$hasEIF = $wpdb->get_var( "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'event_has_eif_from_eif' and post_id = " . $myPostId );
							
							echo "<td>$hasEIF</td>";
							
							// add Publishing Status
							
							if( $status == 1) {
							    $status_str = 'Published';
							} else if( $status == 0 ) {
							    $status_str = 'Pending';
							} else {
							    $status_str = 'Draft';
							}
							
							echo "<td>$status_str</td>";
							
							?>
						</tr>
						<?php
					}
					
					?>
				</tbody>
			</table>  
			<?php
			} // end of table
			?>
			<div class='tablenav'>
				<div class="alignleft actions">
				<br class='clear' />
				</div>
				<?php if ( $events_count >= $limit ) : ?>
				<div class="tablenav-pages">
					<?php
					echo $events_nav;
					?>
				</div>
				<?php endif; ?>
				<br class='clear' />
			</div>
		</form>
		</div>
	</div>

<?php 
global $wpdb;

function ce_change_event_slug( $result, $event_obj ) {
    global $wpdb;
    //echo 'changing slug on post_id ' . $event_obj->post_id . '<br/>';
    
    //print_r($event_obj);
    
	//if ( $result ) {
	    
		if ( $event_obj->post_id ) {
		    //echo "getting here<br/>";
		    $postID = $event_obj->post_id;
		    
		    $categories = $event_obj->event_attributes['categories'];
		    
			$author_id = '1'; # ID of non-anonymous user.
			$event_slug = $event_obj->event_slug;
			echo 'event slug: ' . $event_slug;
			$timeFormat = "Y-m-d H:i:s";
			$mod_date_gmt = get_gmt_from_date($event_obj->event_attributes['event_date_modified'], $timeFormat);
			$post_date_gmt = get_gmt_from_date($event_obj->event_attributes['event_date_created'], $timeFormat);
			
			$args = array( 'ID' => $postID,
				      'post_name' => $event_slug,
				      'post_author' => $author_id,
				      'post_status' => 'publish',
				      'post_date' => $event_obj->event_attributes['event_date_created'],
				      'post_modified' => $event_obj->event_attributes['event_date_modified'],
				      'post_date_gmt' => $post_date_gmt,
				      'post_modified_gmt' => $mod_date_gmt
				     );
			if(wp_update_post( $args )){ 
			    echo 'saved post<br/>';
			    // now do the category
			    wp_set_post_terms( $postID, $categories, EM_TAXONOMY_CATEGORY, false);
			    echo 'saved terms<br/>';
			    // try some custom fields
			    // restricted event details
    
                update_field( 'event_region_from_eif', $event_obj->event_attributes['region'] , $postID );
                update_field( 'event_branch_location_from_eif', $event_obj->event_attributes['host_branch_location'], $postID );
                update_field( 'event_hosting_branch_from_eif', $event_obj->event_attributes['host_branch'] , $postID );
	            update_field( 'event_level_from_eif', $event_obj->event_attributes['event_level'], $postID );
	            update_field( 'event_has_eif_from_eif', $event_obj->event_attributes['EIF'], $postID );
	
            	// Seneschal Info we won't know for legacy events		 
	
        
	            // Event Steward Info
	            update_field( 'event_steward_sca_name', $event_obj->event_attributes['es_sca_name'], $postID );
	            update_field( 'event_steward_legal_name', $event_obj->event_attributes['es_legal_name'], $postID );
	            update_field( 'event_steward_email_address', $event_obj->event_attributes['es_email'], $postID );
	            update_field( 'event_steward_phone_number', $event_obj->event_attributes['es_phone'], $postID );
			    
			    echo 'saved custom fields<br/>';
			    
			    // tack on an update to the created date/time and updated date/time
			    //$wpdb->update( $table, $data, $where, $format = null, $where_format = null );  
			    $update_times = array( 
			        'event_date_created' => $event_obj->event_attributes['event_date_created'],
			        'event_date_modified' =>  $event_obj->event_attributes['event_date_modified']
			    );
			    //print_r($update_times);
			    
			    $wpdb->update( 'wp_r5261em_events', $update_times, array( 'event_id' => $event_obj->event_id )  );
			    
			    $result = 1; 
			    
			}
			
			
			
		} else {
		    echo "SKIPPING: No post id<br/>";
		    log_error( $event['event_name'], $event['event_id'], 'no post id' );
		    next;
		}
//	}
	//echo "Result was: $result<br/>";
	return $result;
}


define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */

require( dirname( __FILE__ ) . '/wp-blog-header.php' );

/* Set the wp user to admin or we can't save */
wp_set_current_user( '1' );

$array = $fields = $custom_fields = array(); $i = 0;
$handle = @fopen("legacy-events-2018-2022.csv", "r");
if ($handle) {
    while (($row = fgetcsv($handle, 4096, '|')) !== false) {
        if (empty($fields)) {
            $fields = $row;
            continue;
        }
        foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value;
        }
        $i++;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
    //print_r($array);
    
    $previous_event_name = '';
    foreach($array as $event) {
        //print_r($event);
        echo "Event is: " . $event['event_name'];
        $current_event_name = $event['event_name'];
        
        if( $current_event_name != $previous_event_name ) {
            $previous_event_name = $current_event_name;
            
        
            /* Note to self. Event Host is sometimes 'An Tir'
            * and needs to be changed to 'Kingdom of An Tir' 
            * I think
            */
            
            $branch_name = $event['branch_name'];
            
            if( $branch_name == 'An Tir') { 
                $branch_name = 'Kingdom of An Tir';
                $catId = $wpdb->get_var( "SELECT term_id FROM {$wpdb->prefix}terms WHERE name LIKE '%" . substr($branch_name, 0, 6) ."%'" );
        
            } else {
                $branch_name = addslashes($branch_name);
            
                $catId = $wpdb->get_var( "SELECT term_id FROM {$wpdb->prefix}terms WHERE name LIKE '%" . substr($branch_name, 0, 6) ."%'" );
                //print_r($catId);
                $branch_name = stripslashes($branch_name);
            }
            
            $event_attributes = array();
            
            $region = '';
            $western = array( 'Aquaterra', 'Bearwood', 'Blatha An Oir', "Dragon's Laire", "Dregate", "Druim Doineann", 'Earnrokke', 'Glymm Mere', 'Madrone', 'Midhaven', "Porte de l'Eau", 'St. Bunstable', 'Wyewood');
            $inlands = array( 'Grimwithshire', 'Akornebir', 'Ambergard', 'Cranehaven', 'Lyonsmarche', 'Pendale', 'Silverhart', 'Vulcanfeldt', 'Wastekeep', 'Wealdsmere' );
            $tir_righ = array( 'Appledore', 'Coil Mhor', 'Cold Keep', 'Danescombe', 'False Isle', 'Fjordland', 'Hartwood', 'Krakafjord', 'Lions Gate', 'Lionsdale', 'Ramsgaard', 'Seagirt', 'Thornwold', 'Tir Bannog' );
            $rivers = array( "Dragon's Mist", 'Hauksgarðr', 'Kaldor Ness', 'Fire Mountain Keep', 'Mountain Edge', "River's Bend", 'Stromgard', 'Three Mountains' );
            $summits = array( 'Adiantum', 'Briaroak', 'Coeur du Val', 'Corvaria', 'Mountain Edge', 'Glyn Dwfn', 'Myrtle Holt', 'Terra Pomaria', 'Tymberhavene' );
            $avacal = array( 'Bitter End', 'Bordergate', 'Borealis', 'Montengarde', 'Myrgan Wood', 'Sigelhundas', 'Valley Wold', 'Vinjar', 'Windwyrm');
            
            
            
            if( $branch_name && ( $branch_name == 'An Tir' || $branch_name == '-Branch TBA-' || $branch_name == 'Kingdom of An Tir' ) ) {
                $region = '--';
            } elseif( $branch_name ) {
                
                if( in_array( $branch_name, $avacal ) ) {
                    $region = 'Avacal';
                } elseif( in_array( $branch_name, $inlands ) ) {
                    $region = 'Inlands';
                } elseif( in_array( $branch_name, $rivers ) ) {
                    $region = 'Rivers';
                } elseif( in_array( $branch_name, $summits ) ) {
                    $region = 'Summits';
                } elseif( in_array( $branch_name, $tir_righ ) ) {
                    $region = 'Tir Righ';
                } elseif( in_array( $branch_name, $western ) ) {
                    $region = 'Western';
                } else {
                    
                    echo "SKIPPING: Not sure where to put ". $branch_name."<br/>";
                    log_error( $event['event_name'], $event['event_id'], 'not sure which region to put branch_name in' );
                    next;
                }
            } else {
                echo "SKIPPING: No branch - event_id = " . $event['event_id'] . "<br/>";
                log_error( $event['event_name'], $event['event_id'], 'no branch' );
                next;
            }
            
            $host_branch_locations = array(
                'Adiantum' => 'Adiantum (Eugene, OR)',
                'Akornerbir' => 'Akornebir (Walla Walla, WA)',
                'Ambergard' => 'Ambergard (Grant County, WA)',
                'Appledore' => 'Appledore (Eastern British Columbia, BC)',
                'Aquaterra' => 'Aquaterra (Snohomish County, WA)',
                'Bearwood' => 'Bearwood (SE Snohomish County, WA)',
                'Bitter End' => 'Bitter End (Red Deer, AB)',
                'Blatha An Oir' => 'Blatha an Oir (Tacoma-Pierce County, WA)',
                'Bordergate' => 'Bordergate (Cold Lake, AB)',
                'Borealis' => 'Borealis (Edmonton, AB)',
                'Briaroak' => 'Briaroak (Roseburg, OR)',
                'Coeur du Val' => 'Coeur du Val (Corvallis, Benton County, OR)',
                'Coill Mhor' => 'Coill Mhor (100 Mile House, BC)',
                'Cold Keep' => 'Cold Keep (Prince George, BC)',
                'Cranehaven' => 'Cranehaven (Chelan County, WA)',
                'Corvaria' => 'Corvaria (Bend, Jefferson, Deschutes, & Crook Counties, OR)',
                'Danescombe' => 'Danescombe (Penticton and Kelowna BC)',
                "Dragon's Laire" => "Dragon's Laire (Kitsap & N Mason Counties, WA)",
                "Dragon's Mist" => "Dragon's Mist (Washington County, OR)",
                "Dregate" => 'Dregate (Omak, WA)',
                "Druim Doineann" => 'Druim Doineann (Port Angeles - Clallam & Jefferson Counties, WA)',
                'Earnrokke' => 'Earnrokke (Whidbey Island, WA)',
                'False Isle' => 'False Isle (Powell River, BC)',
                'Fire Mountain Keep' => 'Fire Mountain Keep (Lewis County, WA)',
                'Fjordland' => 'Fjordland (Sunshine Coast, BC)',
                'Glymm Mere' => 'Glymm Mere (Olympia, Tumwater & Lacey, WA)',
                'Glyn Dwfn' => 'Glyn Dwfn (Medford, Ashland, Jackson Counties, OR)',
                'Grimwithshire' => "(Grimwithshire (Pend O'Reille and Stevens Counties, WA))",
                'Hartwood' => 'Hartwood (Nanaimo,Campbell River,Courtenay, Port Alberni, BC)',
                'Hauksgardr' => 'Hauksgarðr (Hood River and Wasco Counties, OR)',
                'Hauksgarðr' => 'Hauksgarðr (Hood River and Wasco Counties, OR)',
                'Kaldor Ness' => 'Kaldor Ness (Columbia County, OR)',
                'Krakafjord' => 'Krakafjord (Vernon, BC)',
                'Lions Gate' => 'Lions Gate (Vancouver, BC)',
                'Lionsdale' => 'Lionsdale (Fraser Valley, BC)',
                'Lyonsmarche' => 'Lyonsmarche (Pullman, WA & Moscow, ID)',
                'Madrone' => 'Madrone (King County, WA)',
                'Midhaven' => 'Midhaven (Skagit and San Juan Counties, WA)',
                'Montengarde' => 'Montengarde (Calgary, AB)',
                'Mountain Edge' => 'Mountain Edge (Yamhill County, OR)',
                'Myrgan Wood' => 'Myrgan Wood (Sasatoon, SK)',
                'Myrtle Holt' => 'Myrtle Holt (Grants Pass, OR)',
                'Pendale' => 'Pendale (Sandpoint, Bonner & Boundary County, ID)',
                "Port de l'Eau" => "Porte de l'Eau (E King County, WA)",
                'Ramsgaard' => 'Ramsgaard (Kamloops, BC)',
                "River's Bend" => "River's Bend (Kelso & Longview-Cowlitz Counties, WA)",
                'St. Bunstable' => 'St. Bunstable (University of Washington, WA)',
                'Seagirt' => 'Seagirt (Victoria, BC)', 
                'Sigelhundas' => 'Sigelhundas (Regina, SK)',
                'Silverhart' => 'Silverhart (Kootenai, Shoshone, Benwah Counties, ID)',
                'Stromgard' => 'Stromgard (Vancouver, WA)',
                'Terra Pomaria' => 'Terra Pomaria (Marion, Polk & Lincoln Counties, OR)',
                'Thornwold' => 'Thornwold (Bellingham - Whatcom County, WA)',
                'Three Mountains' => 'Three Mountains (Clackamas & Multnomah Counties, OR)',
                'Tir Bannog' => 'Tir Bannog (Smithers, BC)',
                'Tymberhavene' => 'Tymberhavene (Coos & Curry Counties, OR)',
                'Valley Wold' => 'Valley Wold (Moose Jaw, SK)',
                'Vinjar' => 'Vinjar (Grand Prarie, AB and environs)',
                'Vulcanfeldt' => 'Vulcanfeldt (Yakima - Yakima County, WA)',
                'Wastekeep' => 'Wastekeep (Tri-Cities, WA)',
                'Wealdsmere' => 'Wealdsmere (Spokane - Spokane County, WA)',
                'Windwyrm' => 'Windwyrm (Lethbridge, AB)',
                'Wyewood' => 'Wyewood (South King County, WA)'
                );
                
            
            $event_attributes['host_branch'] = $branch_name;
            if( $branch_name && in_array($branch_name, $host_branch_locations ) ) {
                $event_attributes['host_branch_location'] = $host_branch_locations[$branch_name];
            } elseif ( $branch_name && !in_array($branch_name, $host_branch_locations ) ) {
                $event_attributes['host_branch_location'] = 'Kingdom of An Tir';
            } 
            
            if( !$event_attributes['host_branch_location'] ) {
                echo "SKIPPING: Couldn't find a location for branch $branch_name";
                log_error( $event['event_name'], $event['event_id'], "couldn't find a location for branch_name" );
                next;
            }
            
            $event_attributes['region'] = $region;
            
            $event_attributes['event_level'] = $event['event_type'];
            if( $event_attributes['event_level'] == 'Tier 1' ) {
                $event_attributes['event_level'] = 'level1';
            } elseif ( $event_attributes['event_level'] == 'Tier 2' ) {
                $event_attributes['event_level'] = 'level2';
            } elseif ( $event_attributes['event_level'] == 'non-An&nbsp;Tir' ) {
                $event_attributes['event_level'] = 'outofkingdom';
            } elseif ( $event_attributes['event_level'] == 'Cancelled' ) {
                $event_attributes['event_level'] = 'cancelled';
            } elseif ( $event_attributes['event_level'] == 'Open' ) {
                $event_attributes['event_level'] = 'level2';
            } elseif ( $event_attributes['event_level'] == 'Limited' ) {
                $event_attributes['event_level'] = 'level1';  
            } elseif ( $event_attributes['event_level'] == 'Non-event' ) {
                $event_attributes['event_level'] = 'other';
            } elseif ( $event_attributes['event_level'] == 'No EIF' ) {
                $event_attributes['event_level'] = 'other';    
            } elseif ( $event_attributes['event_level'] == 'Level 1 (Limited)' ) {
                $event_attributes['event_level'] = 'level1';
            } elseif ( $event_attributes['event_level'] == 'Level 2 (Open)' ) {
                $event_attributes['event_level'] = 'level2';
            } elseif ( $event_attributes['event_level'] == 'Kingdom Level' ) {
                $event_attributes['event_level'] = 'kingdom';
            } elseif ( $event_attributes['event_level'] == 'Crown Level' ) {
                $event_attributes['event_level'] = 'crown';
            } elseif ( $event_attributes['event_level'] == 'Coronet Level' ) {
                $event_attributes['event_level'] = 'coronet';
            } elseif ( $event_attributes['event_level'] == 'Principality Level' ) {
                $event_attributes['event_level'] = 'principality';
            } else {
                echo "SKIPPING: Don't know what to do with level " . $event_attributes['event_level'];
                log_error( $event['event_name'], $event['event_id'], "don't know what to do with this event level" );
                next;
            }
            
            $event_attributes['categories'] = array( $catId );
            
            if( $event['EIF'] == 'YES' ) { $event_attributes['EIF'] = 'Yes'; }
            if( $event['EIF'] == 'NO' ) { $event_attributes['EIF'] = 'No'; }
            
            $event_attributes['es_sca_name'] = $event['es_sca_name'];
            $event_attributes['es_legal_name'] = $event['es_legal_name'];
            $event_attributes['es_email'] = $event['es_email'];
            $event_attributes['es_phone'] = $event['es_phone'];
           
            
            $event_id = $event['event_id'];
            $event_name = $event['event_name'];
            $event_start_date = $event['start_date'];
            $event_end_date = $event['end_date'];
            $event_description = $event['info'];
        
            $event_time = '00:00:00';  // 12h 13m 14s
        
            $event_location = '';
            // find the Site_ID in the legacy_id field for the new locations and use the new location_id for this event
            if( $event['Site_ID'] ) {
                // get all the locations which will have new location ids
                $sites = $wpdb->get_results( 'SELECT location_name, location_id, post_id from `wp_r5261em_locations`', ARRAY_A );
                
                // go through all the location
                foreach( $sites as $site ) {
                    //echo "Site post_id is: " . $site['post_id'] . '<br/>';
                   $legacy_site_id = get_field( 'site_legacy_id', $site['post_id'] ); 
                   
                   if( $event['Site_ID'] == $legacy_site_id ) {
                       //echo "Site id matched!<br/>";
                       //echo 'legacy site id is: ' . $legacy_site_id . '<br/>';
                       $event_location = $site['location_id'];
                   } 
                   
                   
                }
                //echo 'new location id is: ' . $event_location . '<br/><br/>';
                
                
                
                
                // $site_name = '';
                // if($event['Site_ID'] == '1320' ) {
                //     $event_location = '1067';
                // } else {
                //     $event_location = $event['Site_ID'];
                // }
            } else {
                $event_location = 'NULL';
            }
            //print_r($event_location);
            if ($event_location) {
                $EM_Location = em_get_location($event_location, 'location_id');
               // print_r($EM_Location);
            }
            
            $event_start_time = $event_time;
            $event_end_time = $event_start_time;
            $event_timezone = 'America/Los_Angeles';
            //$event_owner = '1'; // set this to the admin user
            
            $event_created = $event['Created'];
            $event_last_updated = $event['Updated'];
            //echo "Event created original format: " . $event['Created'];
           
            
            $event_attributes['event_date_created'] = $event_created;
            $event_attributes['event_date_modified'] = $event_last_updated;
            
            $event_slug = sanitize_title($event['event_name']);
            
            $event_host = $event['branch_name'];
            
            echo "<br/>attempting to create new event<br/>";
            
    		
            $EM_Event = new EM_Event();
            
            //$EM_Event->event_id = $event_id;
            $EM_Event->event_name = $event_name;
            //$EM_Event->event_owner = $event_owner;
            $EM_Event->post_content = $event_description;
            $EM_Event->location_id = $event_location;
    
            
            $EM_Event->event_status = '1';
            $EM_Event->event_slug = $event_slug;
            $EM_Event->event_start_date = $event_start_date;
            $EM_Event->event_end_date = $event_end_date;
            $EM_Event->event_start_time = $event_start_time;
            $EM_Event->event_end_time = $event_end_time;
            $EM_Event->event_timezone = $event_timezone;
            $EM_Event->event_date_created = $event_created;
            $EM_Event->event_date_modified = $event_last_updated;
            $EM_Event->event_all_day = '0';
            
            $EM_Event->event_attributes = $event_attributes;
            
            // Convert start and end date/time to a Unix timestamp.
            $EM_Event->start = strtotime($EM_Event->event_start_date.' '.$EM_Event->event_start_time);
            $EM_Event->end = strtotime($EM_Event->event_end_date.' '.$EM_Event->event_end_time);
        
            $EM_Event->event_rsvp = 0;  // Set to false to fix bug introduced in Events Manager in 5.8.
            //print_r($EM_Event);
       
            add_filter( 'em_event_save', 'ce_change_event_slug', 11, 2 );
       
            $EM_Event->save();
                //$EM_Event->save_meta();
            remove_filter( 'em_event_save', 'ce_change_event_slug', 11, 2 );
            //echo 'saved post_id: ' . $EM_Event->post_id;
            
            global $EM_Notices;
            //print_r($EM_Notices);
            //
            //print_r($EM_Event);
            
            $previous_event_name = $EM_Event->event_name;
            //exit;
            //echo '<p>Event event ID: ', $EM_Event->event_id, '</p>';
        } else {
            // we have a duplicate event. Let's log it and deal with it later.
            log_error( $event['event_name'], $event['event_id'], 'duplicate' );
            next;
        }
        
    }
}

function log_error( $name, $id, $msg ) {
    file_put_contents ( 'event_add_anomoly_log.txt', '| name: '. $name . ' id: '. $id . '| msg: ' . $msg . '|' , FILE_APPEND );
}

?>
</body>
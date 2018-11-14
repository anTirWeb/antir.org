<?php 
global $EM_Notices;
//global $wpdb;

function ce_change_location_slug( $result, $location_obj ) {
	if ( $result ) {
		if ( $location_obj->post_id ) {
			$author_id = 1; # ID of non-anonymous user.
			$event_slug = sanitize_title($event_obj->event_name.' '.$event_obj->event_start_date);
			echo 'event post-Id: ' . $event_obj->post_id;
			$args = array( 'ID' => $event_obj->post_id,
				      'post_name' => $event_slug,
				      'post_author' => $author_id,
				      'post_status' => 'draft'
				     );
			wp_update_post( $args );
		} else {
		    print_r($event_obj);
		}
	}
	
	return $result;
}


define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */

require( dirname( __FILE__ ) . '/wp-blog-header.php' );

wp_set_current_user( '1');

//INSERT INTO `wp_r5261em_locations_test` (`location_id`, `post_id`, `blog_id`, `location_slug`, `location_name`, `location_owner`, `location_address`, `location_town`, `location_state`, `location_postcode`, `location_region`, `location_country`, `location_latitude`, `location_longitude`, `post_content`, `location_status`, `location_private`, `legacy_site_id`) VALUES ('0', '0', '0', 'doubletree-hilton---portland', 'DoubleTree Hilton - Portland', '1', '1000 NE Multnomah Street<br/>', 'Portland', 'OR', '97232', NULL, 'US', '45.530773', '-122.655579', NULL, '1', '0', '998');

$array = $fields = array(); $i = 0;
$handle = @fopen("legacy-sites.csv", "r");
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
    
    
    foreach($array as $loc) {
        //print_r($loc);
        echo "Location name is: " .$loc['site_name'];
    // Set location values from the array
    $loc_name = $loc['site_name'];
    $loc_slug = sanitize_title($loc['site_name']);
    $loc_owner = '1';
    $loc_address = $loc['site_address'];
    $loc_town = $loc['site_city'];
    $loc_state = $loc['site_state'];
    $loc_postcode = $loc['site_postcode'];
    
    $loc_region= '';
    
    $US = array( 'CA', 'OR', 'WA', 'ID' );
    $CA = array( 'BC', 'SK', 'AB' );
     if( in_array( $loc_state, $US ) ) {
        $loc_country = 'US';
     }elseif( in_array( $loc_state, $CA ) ) {
         $loc_country = 'CA';
     } else {
         $loc_country = 'NULL';
     }
    
    $loc_directions = $loc['site_directions'];
    $loc_lat = $loc['site_lattitude'];
    $loc_lon = $loc['site_longitude'];
    //$loc_content = $loc['post_content'];
    $loc_status = '1';
    $loc_private = '0';
    $leg_id = $loc['site_id'];
    
    //echo "<p>Location Name is: " . $loc_name;
    
    $EM_Location = new EM_Location();
    //$EM_Location->location_id = $leg_id;
    $EM_Location->location_name = $loc_name;
    $EM_Location->location_slug = $loc_slug;
    $EM_Location->location_owner = $loc_owner;
    $EM_Location->location_address = $loc_address;
    $EM_Location->location_town = $loc_town;
    $EM_Location->location_state = $loc_state;
    $EM_Location->location_postcode = $loc_postcode;
    $EM_Location->location_region = $loc_region;
    $EM_Location->location_country = $loc_country;
    $EM_Location->location_latitude = $loc_lat;
    $EM_Location->location_longitude = $loc_lon;
    //$EM_Location->location_content = $loc_content;
    $EM_Location->location_status = $loc_status;
    $EM_Location->location_private = $loc_private;
    
    
    $EM_Location->save();
   //print_r($EM_Location);
//    exit;
    
    if( $EM_Location->post_id ) {
        update_field( 'site_legacy_id', $leg_id , $EM_Location->post_id );
        update_field( 'site_latitude', $loc_lat , $EM_Location->post_id );
        update_field( 'site_longitude', $loc_lon , $EM_Location->post_id );
        update_field( 'site_directions', $loc_directions , $EM_Location->post_id );
    }
    
    
    $loc_id = $EM_Location->id;
    
    echo "Location ID: ". $loc_id;
    
    }
}
?>
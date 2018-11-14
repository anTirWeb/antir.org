<?php
/*
Plugin Name: Events Manager - Organizer Add-on
Version: 1.0
Plugin URI:
Description: Add-on for Events Manager that adds an Organizer to an Event
Author: Alyssa Harding
Author URI: http://wp-events-plugin.com
Text Domain: events-manager-organizer
*/

defined( 'ABSPATH' ) or die( 'No direct access allowed' );

function my_em_organizer_setup() {


//if ( current_user_can( 'activate_plugins' ) && !function_exists( 'em_init' ) ) {
	if ( current_user_can( 'activate_plugins' ) ) {
	    if(  !function_exists( 'em_init' ) ) {
		    // Deactivate the plugin.
		    deactivate_plugins( plugin_basename( __FILE__ ) );
		    // Throw an error in the WordPress admin console.
		    $error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'This plugin requires ', 'Event Manager' ) . '<a href="' . esc_url( 'https://wordpress.org/plugins/events-manager/' ) . '">Events Manager</a>' . esc_html__( ' plugin to be active. Please activate Events Manager and then try again.', 'events-manager-organizer' ) . '</p>';
		    die( $error_message );
	    } else {
	        //update_option( "em_organizer_label", "Event Steward");
	        //activate_plugin( plugin_basename( __FILE__ ) );
	//$error_message = "Success";
	//die($error_message);
		    }
//
    }
//file_put_contents( 'E:\Temp' , ob_get_contents() );
}
register_activation_hook( __FILE__, 'my_em_organizer_setup' );

// returns all event ids associated with an event organizer
function show_organizer_events($oid){}


// Add a meta box on the event page so we can add an event steward to the event
// TODO: add the ability to change the label/title of the event organizer from Event Steward to whatever we want
function my_em_organizer_meta_boxes(){
	add_meta_box('em-event-organizer', 'Event Steward Information', 'my_em_organizer_metabox',EM_POST_TYPE_EVENT, 'normal','low');

	// TODO: add event organizer meta box to recurring events too if we need that later
	//add_meta_box('em-event-organizer', 'Event Steward', 'my_em_organizer_metabox','event-recurring', 'side','low');
}
add_action('add_meta_boxes', 'my_em_organizer_meta_boxes');

// Display the meta box for event steward editing/choosing
function my_em_organizer_metabox(){
	global $EM_Event;
	global $wpdb;
	$my_em_organizer_id = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer'" );
	$my_em_organizer_email = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer-email'" );


	$user_args = array (
		'fields' => array( 'ID', 'display_name' )
	);
	$my_wp_users = get_users( $user_args );

//	if($my_wp_users) {
//		foreach($my_wp_users as $my_user) {
//
//			echo "ID is: " . $my_user->ID . " | Nickname is: " . $my_user->display_name;
//		}
//	}else {
//		echo "No Users Available";
//	}


	// create the dropdown of possible event organizers from active, registered users
?>
<?php
	if ( $my_wp_users ) {
		?><label>Choose an Event Steward for this event<br/>
		<select name="event_organizer">
			<option value="0">---</option>
            <?php


			foreach($my_wp_users as $my_user) { ?>

			<option value="<?php echo $my_user->ID; ?>"
				<?php if ( $my_em_organizer_id === $my_user->ID ) {
					echo 'selected ';
				} ?>
			><?php echo $my_user->display_name; ?></option>
				<?php
			}
			?></select></label>

		<!-- TODO: auto-populate the selected person's email address when event_organizer is selected -->
		<br/><br/>
		<label>Event Steward contact email address<br/> <em>This can be different for different events</em><br/>
			<input name="event_organizer_email" type="text" size="40" maxlength="100" value="<?php echo $my_em_organizer_email;?>"/>
		</label></fieldset>
		<?php
	} else {
		echo "An error has occurred. Please contact the <a href='mailto:webminister@antir.org'>Webminister</a>";
	}
		?>

	<?php
}

// Add an area to edit this in the front-end form
function my_em_organizer_frontend_form_input(){
	?>
	<fieldset>
	<legend>Event Steward Information</legend>
	<?php my_em_organizer_metabox(); ?>
	</div>
	<?php
}
add_action('em_front_event_form_footer', 'my_em_organizer_frontend_form_input');

// save the organizer information
add_filter('em_event_save','my_em_organizer_event_save',1,2);
function my_em_organizer_event_save($result,$EM_Event){
	global $wpdb;

	// Save the organizer Id
	if( $EM_Event->event_id && (($_POST['event_organizer']) != 0 ) ) {
		$my_em_organizer_id = $_POST['event_organizer'];
		$EM_Event->organizer = $my_em_organizer_id;

		//First delete any old data
		$wpdb->query( "DELETE FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer'" );

        // Now add new data
		$wpdb->query( "INSERT INTO " . EM_META_TABLE . " (object_id, meta_key, meta_value) VALUES( {$EM_Event->event_id}, 'event-organizer', $my_em_organizer_id )" );

	}

	if( $EM_Event->event_id && !empty($_POST['event_organizer_email']) ){
		$my_em_organizer_email = $_POST['event_organizer_email'];
		$EM_Event->organizer_email = $my_em_organizer_email;

		// First delete old data
		$wpdb->query("DELETE FROM ".EM_META_TABLE." WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer-email'");

		// Now add new data
		$wpdb->query("INSERT INTO " .EM_META_TABLE." (object_id, meta_key, meta_value) VALUES( {$EM_Event->event_id}, 'event-organizer-email', '$my_em_organizer_email' )");

	}

	return $result;
}


// Load any meta information into the EM_Event object so we can access it
function my_em_organizer_event_load($EM_Event){
	global $wpdb;
	$my_em_organizer_id = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer'" );
	$my_em_organizer_email = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer-email'" );
	$EM_Event->organizer_id = $my_em_organizer_id;
	$EM_Event->organizer_email = $my_em_organizer_email;
}
add_action('em_event','my_em_organizer_event_load',1,1);

// This might not work - our values aren't an array but this function adds organizer to the search.
// might not be necessary anyway since they're just wp users.
//add_filter('em_events_get_default_search','my_em_organizer_get_default_search',1,2);
//add_filter('em_calendar_get_default_search','my_em_organizer_get_default_search',1,2);
//function my_em_organizer_get_default_search($args, $array){
//	$args['organizer'] = false; //registers 'style' as an acceptable value, although set to false by default
//	if( !empty($array['organizer']) && is_numeric($array['organizer']) ){
//		$args['organizer'] = $array['organizer'];
//	}
//	return $args;
//}

// Add some custom placeholders
add_filter('em_event_output_placeholder','my_em_organizer_placeholders',1,3);

function my_em_organizer_placeholders($replace, $EM_Event, $result){
	global $wpdb;

	$my_em_organizer_id = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer'" );

	// Returns just the SCA name of the organizer
	if( $result == '#_ORGANIZERNAME' ){
		$replace = '<em>none</em>';
		if( $my_em_organizer_id > 0 ){
            $my_em_organizer = get_userdata( $my_em_organizer_id );

            // SCA Name is nickname in the wp_user table
            $my_em_organizer_name = $my_em_organizer->nickname;

            $replace = "$my_em_organizer_name";
		}
	}

	// Returns a mailto link with the organizer name
	if( $result == '#_ORGANIZEREMAILLINK' ){
		$replace = '<em>no email address listed</em>';

		if( $my_em_organizer_id > 0 ){
			$my_em_organizer = get_userdata( $my_em_organizer_id );
			$my_em_organizer_name = $my_em_organizer->nickname;
			$my_em_organizer_email = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer-email'" );

			if( $my_em_organizer_email ) {
				$replace = "<a href='mailto:$my_em_organizer_email'>$my_em_organizer_name</a>";
			} else {
			    $replace = "$my_em_organizer_name";
            }
		}
	}

	// Returns just the email address
	if( $result == '#_ORGANIZEREMAIL' ){
		$replace = '<em>no email address listed</em>';
		if( $my_em_organizer_id > 0 ){
			$my_em_organizer_email = $wpdb->get_var( "SELECT meta_value FROM " . EM_META_TABLE . " WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-organizer-email'" );

			if( $my_em_organizer_email ) {
				$replace = "$my_em_organizer_email";
			}
		}
	}
	return $replace;
}

/*
* ADMIN STUFF
* -----------------------------------------*/

// TODO: add an option for what to label organizer in the general options area

?>
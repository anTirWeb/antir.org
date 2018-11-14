<?php

global $EM_Event;

/** saves the tags using ajax when an event steward updates them 
*  this bypasses the events manager's desire to change the event's 
* status to "Pending" which just isn't necessary for a change to tags */

$errors = array();
$data = array();
echo "HI!";

if ($_POST['event_id']) {
    $EM_Event = EM_Events::get( array(  'event' => $_POST['event_id'] ) );
    print_r($EM_Event);
    exit;
}
//wp_set_post_terms( int $post_id, string|array $tags = '', string $taxonomy = 'post_tag', bool $append = false )

// return all our data to an AJAX call
echo json_encode($data);

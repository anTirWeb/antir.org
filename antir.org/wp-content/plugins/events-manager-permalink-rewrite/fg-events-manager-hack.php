<?php
/*
Plugin Name: FG Events Manager Hack
Plugin URI:
Description: Modifies the behaviour of Events Manager plugin
  Add the start event date in the permalink using the format /YYYY/mm/dd
Author: Frédéric GILLES
Version: 1.2
Change Log:
  1.1: Enable the event permalink everywhere in WordPress using the post_type_link filter hook
  1.2: Fix the double dates in the permalink
*/
 
/**
 * Add the start event date in the permalink
 *
 * @param string $permalink Permalink
 * @param object $post Post object
 * @param boolean $leavename
 * @return string Permalink
 */
function fg_events_manager_get_permalink($permalink, $post, $leavename = false) {
        if ( $post->post_type == 'event' ) {
                $event = em_get_event($post->ID, 'post_id');
                $start_date = $event->event_start_date;
                $start_date = str_replace('-', '/', $start_date);
                $event_slug = get_site_option('dbem_cp_events_slug');
                $permalink = str_replace($event_slug, $event_slug.'/'.$start_date, $permalink);
                return $permalink;
        }
        else return $permalink;
}
 
add_filter('post_type_link', 'fg_events_manager_get_permalink', 10, 3);
 
/**
 * Add a rewrite rule to accept the date in the permalink
 *
 */
function fg_events_manager_add_rules() {
        $event_slug = get_site_option('dbem_cp_events_slug');
        add_rewrite_rule($event_slug.'/\d+/\d+/\d+/(.+)$', 'index.php?post_type=event&name=$matches[1]', 'top'); // single event
       
        //flush_rewrite_rules(); // To remove
}
 
add_action('init', 'fg_events_manager_add_rules', 9); // Must be run before events manager
 
/**
 * Plugin activation
 *
 */
function fg_events_manager_activate() {
        fg_events_manager_add_rules();
        flush_rewrite_rules();
}
 
register_activation_hook( __FILE__, 'fg_events_manager_activate' );
 
/**
 * Plugin deactivation
 *
 */
function fg_events_manager_deactivate() {
        flush_rewrite_rules();
}
 
register_deactivation_hook( __FILE__, 'fg_events_manager_deactivate' );
?>
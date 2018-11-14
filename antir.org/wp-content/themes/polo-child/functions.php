<?php

/* -------------------------------------------------------
 Enqueue CSS from child theme style.css
-------------------------------------------------------- */


function crum_child_css() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'crum_child_css', 99 );


/* -------------------------------------------------------
 You can add your custom functions below
-------------------------------------------------------- */



/* -------------------------------------------------------
Add a custom post type for branches
--------------------------------------------------------*/


function sca_register_branch_post_type() {
    $labels = array(
        'name' => 'Branches',
        'singular_name' => 'Branch',
        'add_new_item'=> 'Add New Branch',
        'menu_name' => 'Branches',
        'name_admin_bar' => 'Branch',
        'new_item' => 'Branch',
        'edit_item' => 'Edit Branch',
        'view_item' => 'View Branch',
        'all_items' => 'All Branches',
        'search_items' => 'Search Branches',
        'parent_item_colon' => 'Parent Branch: ',
        'not_found' => 'No branches found',
        'not_found_in_trash' => 'No branches found in Trash'
    );
    
    $supports = array (
        'page-attributes', 
        'title',
        'revisions',
        'thumbnail',
        'custom-fields'
    );
    
    $args = array(
        'labels' => $labels,
        'description' => 'Kingdom Branches',
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-admin-multisite',
        'capability_type' => 'post',
        'hierarchical' => true,
        'supports' => $supports,
        'rewrite' => array( 'slug' => 'branches' ),
        //'taxonomies' => 'region'
    );
    
    register_post_type( 'branch', $args );
}

add_action( 'init', 'sca_register_branch_post_type' );


/* -------------------------------------------------------
Add a custom taxonomy for branches to belong to - region
--------------------------------------------------------*/
add_action( 'init', 'sca_create_branch_taxonomy', 0 );

function sca_create_branch_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => 'Regions',
		'singular_name'     => 'Region',
		'search_items'      => 'Search Regions',
		'all_items'         => 'All Regions',
		'parent_item'       => 'Parent Region',
		'parent_item_colon' => 'Parent Region: ',
		'edit_item'         => 'Edit Region',
		'update_item'       => 'Update Region',
		'add_new_item'      => 'Add New Region',
		'new_item_name'     => 'New Region Name',
		'menu_name'         => 'Regions',
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'regions' ),
	);

	register_taxonomy( 'region', array('branch'), $args );
}

/*----------------------------------------------------------------
  Add to VC Grid Builder
  not sure if this is actually being used -- 2018/10/5 - AWH
------------------------------------------------------------------*/
//Overwrite existing template
// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );
 
function vc_before_init_actions() {
     
    // Link your VC elements's folder
    if( function_exists('vc_set_shortcodes_templates_dir') ){ 
     
        vc_set_shortcodes_templates_dir( get_template_directory() . '/vc_templates' );
         
    }
     
}


// given a category name this returns an array of ids

 function get_term_id_from_cat_name( $cat_name ) {
     global $wpdb;
    
    // it would be really great to set the category from the 
    // hosting branch form field but we need the category id
    if($cat_name) {
        $evt_host = $cat_name;
        //print_r($evt_host);
        //$catId = $wpdb->get_results( "SELECT term_id FROM {$wpdb->prefix}terms WHERE name LIKE '%" . $evt_host ."%'", ARRAY_A );
        $myCatIds = [];
        if( is_array($evt_host) ) {
            foreach ($evt_host as $host){
                $catId = $wpdb->get_var( "SELECT term_id FROM {$wpdb->prefix}terms WHERE name LIKE '%" . substr($host, 0, 6) ."%'" );
                array_push($myCatIds, $catId);
            }
            
        } else {
          $catId = $wpdb->get_var( "SELECT term_id FROM {$wpdb->prefix}terms WHERE name LIKE '%" . substr($evt_host, 0, 6) ."%'");
          $myCatIds = array($catId);
        }
        //print_r($myCatIds);
        
        //$wp_post->post_content['post_category'] = $myCatIds;
        //$wp_post->post_category = $myCatIds;
    }
    return $myCatIds;
 }
 
 // given a category id this returns a category name

 function get_term_name_from_cat_id( $cat_id ) {
     global $wpdb;
    //print_r($cat_id);
    // it would be really great to set the category from the 
    // hosting branch form field but we need the category id
    if($cat_id) {
      $catName = $wpdb->get_var( "SELECT name FROM {$wpdb->prefix}terms WHERE term_id=" . $cat_id );
    } else {
        $catName = '';
    }
        //print_r($catName);
    
    
    return $catName;
 }
    
/* This function saves the name of the Hosting Branch to the custom field 'event_hosting_branch_from_eif when the event is created after event requst form submission    */

add_filter( 'frm_new_post', 'frm_save_category_to_custom_field', 10, 2 );
function frm_save_category_to_custom_field( $post, $args ) {
	if ( $args['form']->id == 3 ) { //change 25 to the ID of your form
		$myHosts = []; 
		
		$hosts = $post['taxonomies']['event-categories'];
		//print_r($hosts);
		foreach( $hosts as $host ){
		    
		    array_push($myHosts, $host);
		}
		$post['post_custom']['event_hosting_branch_from_eif'] = $myHosts;
		//$args['entry']->id;
		print_r($hosts);
	}
	return $post;
}

/**
* We need to do some custom modifications to the Formidable Form data
* when it gets submitted and before it becomes an event post. 
* - change the permalink to be the event guid /events/event-id instead of the name of the post
* - set the category (taxomomy) based on the hosting branch value (multiple choices allowed)
*/

//add_filter('frm_add_entry_meta', 'custom_change_field_value', 10, 5);
// function custom_change_field_value($new_values) {
//   $myHosts = [];    
//   if($new_values['field_id'] == 172 ) {
      
//       $hosts = maybe_unserialize($new_values['meta_value']);
      
//     foreach( $hosts as $host ){
//       //print_r(get_term_name_from_cat_id($host));
//       array_push($myHosts, get_term_name_from_cat_id($host));
//       //print_r($myHosts);
//     }
//   }
    
//   if($new_values['field_id'] == 179 ) {
//     $new_values['meta_value']  = maybe_serialize($myHosts);   
//     print_r($myHosts);
//   }
//   return $new_values;
// }

add_filter('frm_new_post', 'modify_my_event_post', 10, 2);
function modify_my_event_post($post, $args) { 
  global $EM_Event;
  
  $form_id = $args['form']->id;
  
  if( $form_id == 3) { // our event request form
  
 // print_r($args);
  
    $evt_start_date = $_POST['item_meta'][12];
    $evt_end_date = $_POST['item_meta'][13]; 
 
    if($_POST['item_meta'][130]) {
           $evt_start_time = $_POST['item_meta'][130];
    } else {
        $evt_start_time = '12:00:00';
        $_POST['item_meta'][130] = $evt_start_time;
     }
   
    if( $_POST['item_meta'][131]) {
        $evt_end_time = $_POST['item_meta'][131];
    } else {
        $evt_end_time = '12:00:00';
        $_POST['item_meta'][131] = $evt_end_time;
    }
    
    // if( $_POST['item_meta'][172]) {
    //     $hosts = $_POST['item_meta'][172];
        
    //     $myHosts = [];
    //     foreach( $hosts as $host ){
    //         $myHosts = get_term_name_from_cat_id($host);
    //     }
    //     $_POST['item_meta'][179] = $myHosts; 
        //print_r($hosts);
    //}
    
    //if( $_POST['item_meta'][179]) {
      //  print_r($_POST['item_meta'][179]);
     
        //$term_name = get_term_name_from_cat_id($_POST['item_meta'][172]);
        //$_POST['item_meta'][179] = $term_name;
        //$args['entry']['metas'][179] = $term_name;
      
    //}
    
    //print_r($args);
    
    $wp_post = $args['action'];
    $wp_post_id = $wp_post->ID;
    //print_r($wp_post_id);
    
    //$EM_Event = em_get_event($wp_post_id, 'post_id');
    
    //if($EM_Event) {
    // print_r($EM_Event);
    //}
    
    // rewrite slugs for custom post type
    //add_filter('event_rewrite_rules', 'update_event_rewrite_rule');
    

    // $EM_Event->event_start_date = $evt_start_date;
    // $EM_Event->event_end_date = $evt_end_date;
    // $EM_Event->event_start_time = $evt_start_time;
    // $EM_Event->event_end_time = $evt_end_time;
    
    // // Convert start and end date/time to a Unix timestamp.
    // $EM_Event->start = strtotime($EM_Event->event_start_date.' '.$EM_Event->event_start_time);
    // $EM_Event->end = strtotime($EM_Event->event_end_date.' '.$EM_Event->event_end_time);
    
    
    // $EM_Event->event_rsvp = false;  // Set to false to fix bug introduced in Events Manager in 5.8.

    // $EM_Event->save();
    
  }
  return $post;
    
}



function sca_remove_evt_columns( $columns ) {
    
    unset( $columns['cs_replacement'] );
    $new_columns = array(
		'region' => __('Region', 'ThemeName'),
		'event_level' => __('Event Level', 'ThemeName'),
	);
    return array_merge($columns, $new_columns);
    
}

add_filter( 'manage_events_posts_columns', 'sca_remove_evt_columns' );




/**
 * New user registrations should have display_name set 
 * to 'nickname'. This is best used on the
 * 'user_register' action.
 *
 * @param int $user_id The user ID
 */
function set_default_display_name( $user_id ) {
  $user = get_userdata( $user_id );
  
  $args = array(
    'ID'           => $user_id,
    'display_name' => $nickname
  );
  wp_update_user( $args );
}
add_action( 'user_register', 'set_default_display_name' );

/**
 * New users should be contributors by default. 
 * Might not need this
 */

// add_action('um_after_user_is_approved', 'change_wp_role_automatically', 99 );
// function change_wp_role_automatically( $user_id ) {
	
// 	$wp_user_object = new WP_User( $user_id );
// 	$wp_user_object->set_role( 'contributor' );

// }

/**
 * Customize the wordpress admin login page
 * 
 */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/anTirBadge_transp.png);
		height:80px;
		width:320px;
		background-size: 320px 80x;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


/* add a custom dashboard widget for Calendar Admins so they know what to do */
add_action( 'wp_dashboard_setup', 'sca_dashboard_add_calendar_admin_widget' );
function sca_dashboard_add_calendar_admin_widget() {
	wp_add_dashboard_widget( 'sca_dashboard_widget_calendar_admin_instructions', 'Calendar Administrators', 'sca_dashboard_calendar_admin_widget_handler' );
}

function sca_dashboard_calendar_admin_widget_handler() {
    $current_user = wp_get_current_user();
    
	echo 'Welcome to the New Kingdom Website ' . $current_user->nickname .'!';
	echo '<p>This is your dashboard. You\'ll use the navigation links at the left to manage Kingdom Events</p>';
	//echo 'Here are the basic steps for approving events:';
	//echo '<ol>';
	//echo '<li>Click on \'Events\' on the left navigation menu</li>';
//	echo '<li></li>';
	//echo '</ol>';
}

/* reorder the event edit page's metaboxes */
function my_remove_event_edit_metaboxes() {

  // restricted event info
 
  
  // Event Steward Event details
  //remove_meta_box('acf-group_5b9f2ca871f62', 'event', 'advanced');
  
  // Event Manager 'where'
  //remove_meta_box('em-event-where', 'event', 'advanced');
  
  // Slug
  remove_meta_box('slugdiv', 'event', 'normal');
  
  // Author
  remove_meta_box('authordiv', 'event', 'normal');
  
  // Revolution Slider
  remove_meta_box('mymetabox_revslider_0', 'event', 'normal');
    
  // Events Manager "When" box which has a dumb name
  //remove_meta_box('em-event-when', 'event', 'advanced');
  
  
}

add_action( 'do_meta_boxes', 'my_remove_event_edit_metaboxes' );



function my_readd_event_edit_metaboxes(){
   // add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null )
 
  // Author
  add_meta_box('authordiv', 'Author/Owner', 'post_author_meta_box', 'event', 'normal', 'high');
  
 // $screens = array('event');

  //  foreach ($screens as $screen) {

  //      add_meta_box(
  //          'event_info',
  //          'Event Information',
  //          'event_info_editor_custom_box',
   //         $screen
  //      );

  //  }
  
}
add_action( 'do_meta_boxes', 'my_readd_event_edit_metaboxes', 11, 2 );

/* remove the event content wsyiwyg so we can put it back in a different order */
//add_action('init', function () {
    //remove_post_type_support('event', 'editor');
//});

/**
 * Set Advanced Custom Fields metabox priority.
 *
 * @param  string  $priority    The metabox priority.
 * @param  array   $field_group The field group data.
 * @return string  $priority    The metabox priority, modified.
 */
function sca_set_acf_metabox_priority( $priority, $field_group ) {
    //print_r($field_group);
    //print_r($field_group['title']);
    
    if( $field_group['title'] == 'Restricted Event Details') {
        $priority = 'high';
    }
    
    if( $field_group['title'] == 'Event Seneschal Details') {
        $priority = 'high';
    }
    
    if( $field_group['title'] == 'Location Information from EIF') {
        $priority = 'high';
    }
    
    if( $field_group['title'] == 'Event Steward Details') {
        $priority = 'high';
    }
    
    if( $field_group['title'] == 'Event Steward Event Details') {
        $priority = 'low';
    }
    
	return $priority;
}
add_filter( 'acf/input/meta_box_priority', 'sca_set_acf_metabox_priority', 10, 2 );

function event_info_editor_custom_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    ?>

        <style>

            #moved_editor {
                border: none;
            }

            #moved_editor h3 {
                display: none;
            }

            #moved_editor .inside {
                padding: 0;
            }
            
            

        </style>

        <div id="postdivrich" class="postarea">

            <?php wp_editor($post->post_content, 'content', array('dfw' => true, 'tabfocus_elements' => 'sample-permalink,post-preview', 'editor_height' => 360) ); ?>

            <table id="post-status-info" cellspacing="0">

                <tbody>

                    <tr>

                        <td id="wp-word-count"><?php printf( __( 'Word count: %s' ), '<span class="word-count">0</span>' ); ?></td>
                       
                    </tr>

                </tbody>

            </table>

        </div>

 <?php 
    
} 


/* Change wysiwyg editor fonts */
function my_theme_add_editor_styles() {
//add_editor_style('css/tinymce_custom_editor.css');    
add_editor_style( get_template_directory_uri(). 'css/tinymce_custom_editor.css' );
}
add_action( 'after_setup_theme', 'my_theme_add_editor_styles' );


/* put formatting into event content */
//add_filter('em_content_pre','my_em_event_content');
function my_em_event_content($content){
    global $wp_query;
    print_r($content);
    $content = wpautop($content);
    
    //$my_em_styles = (is_array(get_option('my_em_styles'))) ? get_option('my_em_styles'):array();
    //if( is_numeric($wp_query->get('style_id')) && !empty($my_em_styles[$wp_query->get('style_id')]) ){
    //    $content = "<p>Events with the {$my_em_styles[$wp_query->get('style_id')]} style</p>";
    //    $content .= EM_Events::output(array('style'=>$wp_query->get('style_id')));
   // }elseif($wp_query->get('styles_page')){
    //    $content ='';
    //    foreach($my_em_styles as $style_id => $style_name){
    //        $content .= "<h4>$style_name</h4>";  
    //        $content .= EM_Events::output(array('style'=>$style_id));            
    //    }
    //}
    return $content;
}

/* save event tags to event */
add_filter('em_event_save','my_em_tags_event_save',1,2);
function my_em_tags_event_save($result,$EM_Event){
    global $wpdb;
    
    if( $_POST ) {
        $post_id = $EM_Event->post_id;
        
        $terms = $_POST['event-tags'];
        //wp_set_post_terms( $postID, $categories, EM_TAXONOMY_CATEGORY, false);
        //print_r($terms);
        //$taxonomy = 'event-tags';
        
        if( wp_set_post_terms( $post_id, $terms, EM_TAXONOMY_TAGS, false ) ) {
            $result = 1;
        } else {
            $result = 0;
        }
        
        //First delete any old saves
        //$wpdb->query("DELETE FROM ".EM_META_TABLE." WHERE object_id='{$EM_Event->event_id}' AND meta_key='event-style'");
        // if( $EM_Event->event_id && !empty($_POST['event_styles']) ){
        //     $my_em_styles = (is_array(get_option('my_em_styles'))) ? get_option('my_em_styles'):array();
        //     $ids_to_add = array();
        //     $EM_Event->styles = array();
        //     foreach( $_POST['event_styles'] as $style_id ){
        //         if( array_key_exists($style_id, $my_em_styles) ){
        //             $ids_to_add[] = "({$EM_Event->event_id}, 'event-style', '$style_id')";
        //             $EM_Event->styles[] = $style_id;
        //         }
        //     }
        //     if( count($ids_to_add) > 0 ){
        //         $wpdb->query("INSERT INTO ".EM_META_TABLE." (object_id, meta_key, meta_value) VALUES ".implode(',',$ids_to_add));
        //     }
        // }
        return $result;
    }
}
add_action( 'acf/save_post', 'custom_acf_save_post' );
function custom_acf_save_post( $post_id )
{
    if (! is_admin() && 'acf' != get_post_type( $post_id ) ) { // Don't run if adding/updated fields/field-groups in wp-admin
        $post_content = get_post_meta( $post_id, 'form_post_content', true);
        $post_content = wpautop($post_content);
        $post         = get_post($post_id);
        //print_r($post_content);
        $post_data = array( 
            'ID' => $post_id,
        );
        //print_r($post_data);
        
            if ( $post_content ) $post_data['post_content'] = $post_content;
            remove_action( 'acf/save_post', 'custom_acf_save_post' );
            wp_update_post( $post_data );
            add_action( 'acf/save_post', 'custom_acf_save_post' );
    }
}

add_filter('acf/prepare_field/name=event_schedule', 'custom_acf_load_event_schedule_table', 10, 3 );
function custom_acf_load_event_schedule_table( $field ) {
    $event_schedule_table = '<table style="border-collapse: collapse; width: 100%; height: 230px;" border="1">
<tbody>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"><strong>Time</strong></td>
<td style="width: 33.3333%; height: 23px;"><strong>Activity</strong></td>
<td style="width: 33.3333%; height: 23px;"><strong>Location</strong></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
<td style="width: 33.3333%; height: 23px;"></td>
</tr>
</tbody>
</table>';

if($field['value'] == '') {
       $field['value'] = $event_schedule_table;  
       //print_r($field);
  }
  
  return $field;
}
	
add_filter('acf/prepare_field/name=site_fees', 'custom_acf_load_site_fees_table', 10, 3 );

function custom_acf_load_site_fees_table ($field) {
    //print_r($field);
    
    $site_fees_table = '<table style="border-collapse: collapse; width: 100%; border: 1px solid #111;" border="">
<tbody>
<tr style="height: 23px;">
<td style="width: 50%; height: 23px;">Fee Type</td>
<td style="width: 50%; height: 23px;">Cost*</td>
</tr>
<tr style="height: 23px;">
<td style="width: 50%; height: 23px;"></td>
<td style="width: 50%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 50%; height: 23px;"></td>
<td style="width: 50%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 50%; height: 23px;"></td>
<td style="width: 50%; height: 23px;"></td>
</tr>
<tr style="height: 23px;">
<td style="width: 100%; height: 23px;" colspan="2">*SCA Members will receive a $5 member discount off the cost listed above.</td>
</tr>
</tbody>
</table>';

    

  if($field['value'] == '') {
       $field['value'] = $site_fees_table;  
       //print_r($field);
  }
  
  return $field;
}

//add_filter( 'the_content', 'wpautop', 10, 3 );
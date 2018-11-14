<?php
/* 
 * Remember that this file is only used if you have chosen to override event pages with formats in your event settings!
 * You can also override the single event page completely in any case (e.g. at a level where you can control sidebars etc.), as described here - http://codex.wordpress.org/Post_Types#Template_Files
 * Your file would be named single-event.php
 */
/*
 * This page displays a single event, called during the the_content filter if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Event;
/* @var $EM_Event EM_Event */

//get_header(); 

//echo "hello world!";

$output = $EM_Event->output_single();
print_r($args);
?>
<?php
                
    if( function_exists( 'get_field' ) ) {
        //echo 'acf active';
        $event_steward = get_field('event_steward');
        $event_steward_email_address = get_field('event_steward_contact_email_address');
        $site_fees = get_field('site_fees');
        $schedule = get_field('event_schedule');
        $meal_info = get_field('meal_information');
        $pre_reg = get_field('pre_reg_reservations');
        $volunteer = get_field('volunteer_opportunities');
        $tournaments = get_field('tournaments');
        $merchants = get_field('merchants');
        $yafa = get_field('yafa');
        $classes = get_field('classes_offered');
        $event_level = get_field('event_level');
                   
    }
?>

Event Steward: <a href="mailto:<?php echo $event_steward_email_address ?>"><?php echo $event_steward; ?></a>
<br/><br/>
<?php 

echo $output;

if ( $site_fees && $site_fees['body'] ) {
    echo '<h2>Site Fees</h2>';
    echo '<table border="0">';

        if ( $site_fees['header'] ) {

            echo '<thead>';

                echo '<tr>';

                    foreach ( $site_fees['header'] as $th ) {

                        echo '<th>';
                            echo $th['c'];
                        echo '</th>';
                    }

                echo '</tr>';

            echo '</thead>';
        }

        echo '<tbody>';

            foreach ( $site_fees['body'] as $tr ) {

                echo '<tr>';

                    foreach ( $tr as $td ) {

                        echo '<td>';
                            echo $td['c'];
                        echo '</td>';
                    }

                echo '</tr>';
            }

        echo '</tbody>';

    echo '</table>';
}

if ( $schedule && $schedule['body'] ) {
    echo '<h2>Event Schedule</h2>';
    echo '<table border="0">';

    
        if ( $schedule['header'] ) {

            echo '<thead>';

                echo '<tr>';

                    foreach ( $schedule['header'] as $th ) {

                        echo '<th>';
                            echo $th['c'];
                        echo '</th>';
                    }

                echo '</tr>';

            echo '</thead>';
        }

        echo '<tbody>';

            foreach ( $schedule['body'] as $tr ) {

                echo '<tr>';

                    foreach ( $tr as $td ) {

                        echo '<td>';
                            echo $td['c'];
                        echo '</td>';
                    }

                echo '</tr>';
            }

        echo '</tbody>';

    echo '</table>';
}

if ( $meal_info ) {
    echo '<h2>Meal Information</h2>';
    echo "<p>$meal_info</p>";
}

if ( $pre_reg ) {
    echo '<h2>Registration Information</h2>';
    echo "<p>$pre_reg</p>";
}

if ( $tournaments ) {
    echo '<h2>Tournament Information</h2>';
    echo "<p>$tournaments</p>";
}

if ( $yafa ) {
    echo '<h2>Youth and Family Activities</h2>';
    echo "<p>$yafa</p>";
}

if ( $volunteer ) {
    echo '<h2>Volunteer Information</h2>';
    echo "<p>$volunteer</p>";
}

if( $merchants ) {
    echo '<h2>Merchant Information</h2>';
    echo "<p>$merchants</p>";
}

if( $classes ) {
    echo '<h2>Classes Offered</h2>';
    echo "<p>$classes</p>";
}
?>

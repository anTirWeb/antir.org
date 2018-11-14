<?php

/*
* Latest tweets with PHP widget
*/

class Crum_Latest_Tweets extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-tweeter',
			'description' => esc_html__( "Displays your latest Tweets", 'polo_extension' )
		);
		parent::__construct( 'twitter-widget', esc_html__( 'Crumina: Latest Tweets', 'polo_extension' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_tweets';
	}

	public function convert_links( $status, $targetBlank = true, $linkMaxLen = 250, $created_at ) {

		// the target
		$target = $targetBlank ? " target=\"_blank\" " : "";
		// convert link to url

		$status = preg_replace('/http:\/\/t.co\/([a-zA-Z0-9]+)/i', '<a href="http://t.co/$1" '.$target.'>goo.gl/$1</a>', $status);
		$status = preg_replace('/https:\/\/t.co\/([a-zA-Z0-9]+)/i', '<a href="https://t.co/$1" '.$target.'>goo.gl/$1</a>', $status);

		// convert @ to follow
		$status = preg_replace( "/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>", $status );
		// convert # to search
		$status = preg_replace( "/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>", $status );


		// return the status
		return $status;
	}

	public function relative_time( $a ) {
		//get current timestampt
		$b = strtotime( "now" );
		//get timestamp when tweet created
		$c = strtotime( $a );
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;
		$week   = $day * 7;

		if ( is_numeric( $d ) && $d > 0 ) {
			//if less then 3 seconds
			if ( $d < 3 ) {
				return "right now";
			}
			//if less then minute
			if ( $d < $minute ) {
				return floor( $d ) . esc_html__( " sec ago", 'polo_extension' );
			}
			//if less then 2 minutes
			if ( $d < $minute * 2 ) {
				return "about 1 minute ago";
			}
			//if less then hour
			if ( $d < $hour ) {
				return floor( $d / $minute ) . esc_html__( " min ago", 'polo_extension' );
			}
			//if less then 2 hours
			if ( $d < $hour * 2 ) {
				return esc_html__( "about 1 hour ago...", 'polo_extension' );
			}
			//if less then day
			if ( $d < $day ) {
				return floor( $d / $hour ) . esc_html__( " h ago", 'polo_extension' );
			}
			//if more then day, but less then 2 days
			if ( $d > $day && $d < $day * 2 ) {
				return esc_html__( "yesterday", 'polo_extension' );
			}
			//if less then year
			if ( $d < $day * 365 ) {
				return floor( $d / $day ) . esc_html__( " days ago", 'polo_extension' );
			}

			//else return more than a year
			return esc_html__( "over a year ago", 'polo_extension' );
		}
	}

	//widget output
	public function widget( $args, $instance ) {
		extract( $args );

		echo( $args['before_widget'] );


		$title = '';

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];

		}

		if ( $title ) {

			echo( $args['before_title'] );
			echo( $title );
			echo( $args['after_title'] );

		}

		if ( function_exists( 'reactor_option' ) ) {
			$consumer_key         = reactor_option( 'tw-consumer-key' );
			$consumer_secret      = reactor_option( 'tw-consumer-secret' );
			$access_tocken        = reactor_option( 'tw-access-token' );
			$access_tocken_secret = reactor_option( 'tw-access-token-secret' );
		} else {
			$consumer_key         = '';
			$consumer_secret      = '';
			$access_tocken        = '';
			$access_tocken_secret = '';
		}

		//check settings and die if not set
		if ( empty( $consumer_key ) || empty( $consumer_secret ) || empty( $access_tocken ) || empty( $access_tocken_secret ) || empty( $instance['cachetime'] ) || empty( $instance['username'] ) ) {
			echo '<strong>Please fill all widget settings!</strong>' . $args['after_widget'];

			return;
		}


		//check if cache needs update
		$tp_twitter_plugin_last_cache_time = get_option( 'tp_twitter_plugin_last_cache_time' );
		$diff                              = time() - $tp_twitter_plugin_last_cache_time;
		$crt                               = $instance['cachetime'];

		//	yes, it needs update
		if ( $diff >= $crt * 3600 || empty( $tp_twitter_plugin_last_cache_time ) ) {

			if ( ! require( PLUGIN_PATH . 'inc/twitter/twitteroauth.php' ) ) {
				echo '<strong>Couldn\'t find twitteroauth.php!</strong>' . $args['after_widget'];

				return;
			}

			if ( ! function_exists( 'getConnectionWithAccessToken' ) ) {
				function getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
					$connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );

					return $connection;
				}
			}

			$connection = getConnectionWithAccessToken( $consumer_key, $consumer_secret, $access_tocken, $access_tocken_secret );


			$tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $instance['username'] . "&count=10" ) or die( 'Couldn\'t retrieve tweets! Wrong username?' );


			if ( ! empty( $tweets->errors ) ) {
				if ( $tweets->errors[0]->message == 'Invalid or expired token' ) {
					echo '<strong>' . $tweets->errors[0]->message . '!</strong><a href="https://apps.twitter.com/" target="_blank">' . esc_html__( "You will need to regenerate twitter token", 'polo_extension' ) . '</a>!' . $args['after_widget'];;
				} else {
					echo '<strong>' . $tweets->errors[0]->message . '</strong>' . $args['after_widget'];
				}

				return;
			}


			for ( $i = 0; $i <= count( $tweets ); $i ++ ) {
				if ( ! empty( $tweets[ $i ] ) ) {
					$tweets_array[ $i ]['user']       = $tweets[ $i ]->user;
					$tweets_array[ $i ]['created_at'] = $tweets[ $i ]->created_at;
					$tweets_array[ $i ]['text']       = $tweets[ $i ]->text;
					$tweets_array[ $i ]['status_id']  = $tweets[ $i ]->id_str;
				}
			}

			//save tweets to wp option
			update_option( 'tp_twitter_plugin_tweets', serialize( $tweets_array ) );
			update_option( 'tp_twitter_plugin_last_cache_time', time() );

			echo '<!-- twitter cache has been updated! -->';
		}

		$tp_twitter_plugin_tweets = maybe_unserialize( get_option( 'tp_twitter_plugin_tweets' ) );

		if ( ! empty( $tp_twitter_plugin_tweets ) ) {

			$output = '';

			$fctr = '1';

			$output .= '<ul>';

			foreach ( $tp_twitter_plugin_tweets as $tweet ) {

				$output .= '<li>';

				$output .= $this->convert_links( $tweet['text'], true, 250, $tweet['created_at'] );

				$output .= '<span class="list-tweets-date">' . $this->relative_time( $tweet['created_at'] ) . '</span>';

				if ( $fctr == $instance['tweetstoshow'] ) {
					break;
				}
				$fctr ++;

				$output .= '</li>';

			}

			$output .= '</ul>';

			echo( $output );

		}


		echo( $args['after_widget'] );
	}


	//save widget settings
	public function update( $new_instance, $old_instance ) {
		$instance                 = array();
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['cachetime']    = strip_tags( $new_instance['cachetime'] );
		$instance['username']     = strip_tags( $new_instance['username'] );
		$instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );

		if ( $old_instance['username'] != $new_instance['username'] ) {
			delete_option( 'tp_twitter_plugin_last_cache_time' );
		}

		return $instance;
	}


	//widget settings form
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'cachetime' => '', 'username' => '', 'tweetstoshow' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title     = esc_attr( $instance['title'] );
		$user_name = esc_attr( $instance['username'] );

		$cache_time = ( isset( $instance['cachetime'] ) && $instance['cachetime'] ) ? $instance['cachetime'] : '1';

		$widget_output = '';

		//Widget title
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$widget_output .= '</p>';

		//Client name
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'username' ) ) . '">' . esc_html__( 'Username:', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'username' ) ) . '" name="' . esc_attr( $this->get_field_name( 'username' ) ) . '" type="text" value="' . esc_attr( $user_name ) . '">';
		$widget_output .= '</p>';

		//Cache time
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'cachetime' ) ) . '">' . esc_html__( 'Cache time (hours)', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'cachetime' ) ) . '" name="' . esc_attr( $this->get_field_name( 'cachetime' ) ) . '" type="text" value="' . esc_attr( $cache_time ) . '">';
		$widget_output .= '</p>';

		//Tweets to display
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'tweetstoshow' ) ) . '">' . esc_html__( 'Items to display:', 'polo_extension' ) . '</label>';
		$widget_output .= '<select type="text" name="' . esc_attr( $this->get_field_name( 'tweetstoshow' ) ) . '" id="' . ( $this->get_field_id( 'tweetstoshow' ) ) . '">';

		for ( $i = 1; $i <= 10; $i ++ ) {
			$widget_output .= '<option value="' . $i . '"';
			if ( $instance['tweetstoshow'] == $i ) {
				$widget_output .= ' selected="selected"';
			}
			$widget_output .= '>' . $i . '</option>';
		}
		$widget_output .= '</select>';
		$widget_output .= '</p>';

		echo( $widget_output );
	}
}


function Crum_Latest_Tweets_init() {
	register_widget( 'Crum_Latest_Tweets' );
}

add_action( 'widgets_init', 'Crum_Latest_Tweets_init' );
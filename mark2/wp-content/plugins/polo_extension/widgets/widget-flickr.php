<?php

class Crumina_Filckr_widget extends WP_Widget {

	function __construct() {

		$widget_opts = array(
			'classname'   => 'widget-flickr',
			'description' => esc_html__( 'Your Flickr photos', 'polo_extension' ),
		);

		parent::__construct( 'crum-flickr-feed', esc_html__( 'Crumina: Flickr', 'polo_extension' ), $widget_opts );
		$this->alt_option_name = 'widget_crum_flickr_feed';

	}

	function form( $instance ) {

		$title       = isset( $instance['title'] ) ? $instance['title'] : '';
		$user_id     = isset( $instance['user_id'] ) ? $instance['user_id'] : '';
		$photo_count = isset( $instance['photo_count'] ) ? $instance['photo_count'] : '';

		$output = '';

		//Widget title
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$output .= '</p>';

		//Widget user_id
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'user_id' ) ) . '">' . esc_html__( 'User ID', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'user_id' ) ) . '" name="' . esc_attr( $this->get_field_name( 'user_id' ) ) . '" type="text" value="' . esc_attr( $user_id ) . '">';
		$output .= '</p>';

		//Widget photo number
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'photo_count' ) ) . '">' . esc_html__( 'Number of photos', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'photo_count' ) ) . '" name="' . esc_attr( $this->get_field_name( 'photo_count' ) ) . '" type="text" value="' . esc_attr( $photo_count ) . '">';
		$output .= '</p>';

		echo $output;

	}

	function update( $new_instance, $old_instance ) {

		$instance                = $old_instance;
		$instance['title']       = $new_instance['title'];
		$instance['user_id']     = $new_instance['user_id'];
		$instance['photo_count'] = $new_instance['photo_count'];

		return $instance;

	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );

		$title       = isset( $instance['title'] ) ? $instance['title'] : '';
		$user_id     = isset( $instance['user_id'] ) ? $instance['user_id'] : '';
		$photo_count = isset( $instance['photo_count'] ) ? $instance['photo_count'] : '';

		$output = '';

		$output .= $before_widget;

		if ( isset( $title ) && ! empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}

		if ( isset( $user_id ) && ! empty( $user_id ) ) {
			if ( isset( $photo_count ) && ! empty( $photo_count ) ) {
				$count = $photo_count;
			} else {
				$count = 12;
			}
			$output .= '<div data-flickr-images="' . $count . '" data-flickr-id="' . $user_id . '" class="flickr-widget"></div>';
		}

		$output .= $after_widget;

		echo $output;

	}

}

function Cruimna_Flickr_Widget_init() {
	register_widget( 'Crumina_Filckr_widget' );
}

add_action( 'widgets_init', 'Cruimna_Flickr_Widget_init' );
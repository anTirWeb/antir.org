<?php

class Cruimna_Contact_Info_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-contact-us',
			'description' => esc_html__( "Your contact information", 'polo_extension' )
		);
		parent::__construct( 'crumina-contact-info', esc_html__( 'Crumina: Contact info', 'polo_extension' ), $widget_ops );
		$this->alt_option_name = 'widget_crum_contact_info';

	}

	function form( $instance ) {

		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$address  = isset( $instance['address'] ) ? $instance['address'] : '';
		$email    = isset( $instance['email'] ) ? $instance['email'] : '';
		$phone    = isset( $instance['phone'] ) ? $instance['phone'] : '';
		$schedule = isset( $instance['schedule'] ) ? $instance['schedule'] : '';
		$image    = isset( $instance['image'] ) ? $instance['image'] : '';

		$output = '';

		//Widget title
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$output .= '</p>';

		//Widget address
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'address' ) ) . '">' . esc_html__( 'Address', 'polo_extension' ) . '</label>';
		$output .= '<textarea class="widefat" id="' . esc_attr( $this->get_field_id( 'address' ) ) . '" name="' . esc_attr( $this->get_field_name( 'address' ) ) . '">' . esc_attr( $address ) . '</textarea>';
		$output .= '</p>';

		//Widget phone number
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'phone' ) ) . '">' . esc_html__( 'Phone number', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'phone' ) ) . '" name="' . esc_attr( $this->get_field_name( 'phone' ) ) . '" type="text" value="' . esc_attr( $phone ) . '">';
		$output .= '</p>';

		//Widget email
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'email' ) ) . '">' . esc_html__( 'Email', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'email' ) ) . '" name="' . esc_attr( $this->get_field_name( 'email' ) ) . '" type="text" value="' . esc_attr( $email ) . '">';
		$output .= '</p>';

		//Widget schedule
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'schedule' ) ) . '">' . esc_html__( 'Schedule', 'polo_extension' ) . '</label>';
		$output .= '<textarea class="widefat" id="' . esc_attr( $this->get_field_id( 'schedule' ) ) . '" name="' . esc_attr( $this->get_field_name( 'schedule' ) ) . '" >' . esc_attr( $schedule ) . '</textarea>';
		$output .= '</p>';

		//Widget bg image
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'image' ) ) . '">' . esc_html__( 'Background image', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat widget_image_add" id="' . esc_attr( $this->get_field_id( 'image' ) ) . '" name="' . esc_attr( $this->get_field_name( 'image' ) ) . '" type="text" value="' . esc_attr( $image ) . '">';
		$output .= '<a href="#" class="add-item-image button">' . esc_html__( 'Add image', 'crum' ) . '</a>';
		$output .= '<a href="#" class="remove-item-image button">' . esc_html__( 'Remove image', 'crum' ) . '</a>';
		$output .= '</p>';


		echo $output;
	}

	function update( $new_instance, $old_instance ) {

		$instance             = $old_instance;
		$instance['title']    = $new_instance['title'];
		$instance['address']  = $new_instance['address'];
		$instance['email']    = $new_instance['email'];
		$instance['phone']    = $new_instance['phone'];
		$instance['schedule'] = $new_instance['schedule'];
		$instance['image']    = $new_instance['image'];

		return $instance;
	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );


		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$address  = isset( $instance['address'] ) ? $instance['address'] : '';
		$email    = isset( $instance['email'] ) ? $instance['email'] : '';
		$phone    = isset( $instance['phone'] ) ? $instance['phone'] : '';
		$schedule = isset( $instance['schedule'] ) ? $instance['schedule'] : '';
		$image    = isset( $instance['image'] ) ? $instance['image'] : '';

		$output = '';

		if(isset($image) && !empty($image)){
			$widget_style = 'style="background-image: url('.esc_url(polo_theme_thumb($image,'600','',true)).'); background-size: cover; background-position: center"';
		}else{
			$widget_style = '';
		}

		$output .= $before_widget;

		if ( isset( $title ) && ! ( empty( $title ) ) ) {
			$output .= $before_title;
			$output .= $title;
			$output .= $after_title;
		}

		$output .= '<div class="contact-widget" '.$widget_style.'>';

		if ( ( isset( $address ) && ! ( empty( $address ) ) ) || ( isset( $email ) && ! ( empty( $email ) ) ) || ( isset( $phone ) && ! ( empty( $phone ) ) ) || ( isset( $schedule ) && ! empty( $schedule ) ) ) {
			$output .= '<ul class="list-large list-icons">';
			if ( isset( $address ) && ! ( empty( $address ) ) ) {
				$output .= '<li><i class="fa fa-map-marker"></i> ' . $address . '</li>';
			}
			if ( isset( $phone ) && ! ( empty( $phone ) ) ) {
				$output .= '<li><i class="fa fa-phone"></i>' . $phone . '</li>';
			}
			if ( isset( $email ) && ! ( empty( $email ) ) ) {
				$output .= '<li><i class="fa fa-envelope"></i> ' . $email . '</li>';
			}
			if ( isset( $schedule ) && ! empty( $schedule ) ) {
				$output .= '<li><i class="fa fa-clock-o"></i> ' . $schedule . '</li>';
			}
			$output .= '</ul>';
		}

		$output .= '</div>';

		$output .= $after_widget;

		echo $output;

	}

}

function Cruimna_Contact_Info_Widget_init() {
	register_widget( 'Cruimna_Contact_Info_Widget' );
}

add_action( 'widgets_init', 'Cruimna_Contact_Info_Widget_init' );
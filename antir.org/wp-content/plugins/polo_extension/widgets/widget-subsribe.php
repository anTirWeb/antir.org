<?php

/*
 * Subscribe widget
 */


class Crum_Subscribe_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-newsletter',
			'description' => esc_html__( "Displays subscription form", 'polo_extension' )
		);
		parent::__construct( 'crum-subscription-widget', esc_html__( 'Crumina: Subscribe', 'polo_extension' ), $widget_ops );
		$this->alt_option_name = 'crum_subscribe_widget';
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title'                  => '',
			'subtitle'               => '',
			'block_style'            => '',
			'email_placeholder'      => '',
			'subscribe_thankyou_msg' => '',
		) );

		$title                  = isset($instance['title']) ? strip_tags( $instance['title'] ) : '';
		$subtitle               = isset($instance['subtitle']) ? strip_tags( $instance['subtitle'] ) : '';
		$block_style            = isset($instance['block_style']) ? strip_tags( $instance['block_style'] ) : '';
		$email_placeholder      = isset($instance['email_placeholder']) ? strip_tags( $instance['email_placeholder'] ) : '';
		$subscribe_thankyou_msg = isset($instance['subscribe_thankyou_msg']) ? strip_tags( $instance['subscribe_thankyou_msg'] ) : '';

		if ( 'style_2' === $block_style ) {
			$select_2 = 'selected="selected;"';
			$select_1 = '';
		} else {
			$select_1 = 'selected="selected;"';
			$select_2 = '';
		}

		$widget_output = '';

		//Widget title
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'subtitle' ) ) . '">' . esc_html__( 'Subtitle', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'subtitle' ) ) . '" name="' . esc_attr( $this->get_field_name( 'subtitle' ) ) . '" type="text" value="' . esc_attr( $subtitle ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'block_style' ) ) . '">' . esc_html__( 'Block style', 'polo_extension' ) . '</label>';
		$widget_output .= '<select type="text" name="' . esc_attr( $this->get_field_name( 'block_style' ) ) . '" id="' . ( $this->get_field_id( 'block_style' ) ) . '">';
		$widget_output .= '<option value="style_1" ' . $select_1 . '>' . esc_html__( 'Simple', 'polo_extension' ) . '</option>';
		$widget_output .= '<option value="style_2" ' . $select_2 . '>' . esc_html__( 'Extended', 'polo_extension' ) . '</option>';
		$widget_output .= '</select>';
		$widget_output .= '</p>';

		//Widget email paceholder
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'email_placeholder' ) ) . '">' . esc_html__( 'Email field placeholder', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'email_placeholder' ) ) . '" name="' . esc_attr( $this->get_field_name( 'email_placeholder' ) ) . '" type="text" value="' . esc_attr( $email_placeholder ) . '">';
		$widget_output .= '</p>';

		//Thankyou message
		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'subscribe_thankyou_msg' ) ) . '">' . esc_html__( 'Thanking message text', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'subscribe_thankyou_msg' ) ) . '" name="' . esc_attr( $this->get_field_name( 'subscribe_thankyou_msg' ) ) . '" type="text" value="' . esc_attr( $subscribe_thankyou_msg ) . '">';
		$widget_output .= '</p>';

		echo( $widget_output );

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']                  = $new_instance['title'];
		$instance['subtitle']               = $new_instance['subtitle'];
		$instance['block_style']            = $new_instance['block_style'];
		$instance['email_placeholder']      = $new_instance['email_placeholder'];
		$instance['subscribe_thankyou_msg'] = $new_instance['subscribe_thankyou_msg'];

		return $instance;

	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );

		$output = '';

		$block_style            = isset( $instance['block_style'] ) ? $instance['block_style'] : 'style_1';
		$title                  = isset( $instance['title'] ) ? $instance['title'] : '';
		$subtitle               = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$email_placeholder      = isset( $instance['email_placeholder'] ) ? $instance['email_placeholder'] : '';
		$subscribe_thankyou_msg = isset( $instance['subscribe_thankyou_msg'] ) ? $instance['subscribe_thankyou_msg'] : esc_html__( 'Thank you for subscribing to our mailing list', 'polo_extension' );

		wp_enqueue_script( 'crum-subscribe' );

		$output .= $before_widget;

		if ( isset( $title ) && ! empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}

		if ( isset( $subtitle ) && ! empty( $subtitle ) ) {
			$output .= '<small>' . $subtitle . '</small>';
		}

		$args = array(
			'style'       => $block_style,
			'block_class' => '',
			'emailholder' => $email_placeholder,
			'jsthanks'    => true,
			'thankyou'    => $subscribe_thankyou_msg
		);

		$subscribe_form = crum_subform( $args );

		$output .= $subscribe_form;

		$output .= $after_widget;

		echo( $output );

	}

}

function Crum_Widget_Subscribe_Register_Init() {
	register_widget( 'Crum_Subscribe_Widget' );
}

add_action( 'widgets_init', 'Crum_Widget_Subscribe_Register_Init' );
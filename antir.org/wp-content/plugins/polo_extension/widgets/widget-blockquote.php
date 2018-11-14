<?php

class Cruimna_Blockquote_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-blockquote',
			'description' => esc_html__( "Block with quote", 'polo_extension' )
		);
		parent::__construct( 'crumina-blockquote', esc_html__( 'Crumina: Quote', 'polo_extension' ), $widget_ops );
		$this->alt_option_name = 'widget_crum_quote';

	}

	function form( $instance ) {

		$title  = isset( $instance['title'] ) ? $instance['title'] : '';
		$quote  = isset( $instance['quote'] ) ? $instance['quote'] : '';
		$author = isset( $instance['author'] ) ? $instance['author'] : '';

		$output = '';

		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$output .= '</p>';

		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'quote' ) ) . '">' . esc_html__( 'Quote', 'polo_extension' ) . '</label>';
		$output .= '<textarea class="widefat" id="' . esc_attr( $this->get_field_id( 'quote' ) ) . '" name="' . esc_attr( $this->get_field_name( 'quote' ) ) . '">' . esc_attr( $quote ) . '</textarea>';
		$output .= '</p>';

		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'author' ) ) . '">' . esc_html__( 'Author', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'author' ) ) . '" name="' . esc_attr( $this->get_field_name( 'author' ) ) . '" type="text" value="' . esc_attr( $author ) . '">';
		$output .= '</p>';


		echo $output;
	}

	function update( $new_instance, $old_instance ) {

		$instance           = $old_instance;
		$instance['title']  = $new_instance['title'];
		$instance['quote']  = $new_instance['quote'];
		$instance['author'] = $new_instance['author'];

		return $instance;
	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );


		$title  = isset( $instance['title'] ) ? $instance['title'] : '';
		$quote  = isset( $instance['quote'] ) ? $instance['quote'] : '';
		$author = isset( $instance['author'] ) ? $instance['author'] : '';

		$output = '';

		$output .= $before_widget;

		if ( isset( $title ) && ! ( empty( $title ) ) ) {
			$output .= $before_title;
			$output .= $title;
			$output .= $after_title;
		}

		if ( isset( $quote ) && ! empty( $quote ) ) {
			$output .= '<blockquote class="blockquote-simple">';
			$output .= '<p>' . $quote . '</p>';
			if ( isset( $author ) && ! empty( $author ) ) {
				$output .= '<small>' . esc_html__( 'by', 'polo_extension' ) . '<cite>' . $author . '</cite></small>';
			}
			$output .= '</blockquote>';//.blockquote-simple
		}

		$output .= $after_widget;

		echo $output;

	}

}

function Cruimna_Blockquote_Widget_init() {
	register_widget( 'Cruimna_Blockquote_Widget' );
}

add_action( 'widgets_init', 'Cruimna_Blockquote_Widget_init' );
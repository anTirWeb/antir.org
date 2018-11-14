<?php

class Crumina_Slider_Widget extends WP_Widget {

	function __construct() {

		$widget_opts = array(
			'classname'   => 'widget-slider',
			'description' => esc_html__( 'Slider with images', 'polo_extension' ),
		);

		parent::__construct( 'crum-images-slider', esc_html__( 'Crumina: Images Slider', 'polo_extension' ), $widget_opts );
		$this->alt_option_name = 'widget_crum_images_slider';

	}

	function form( $instance ) {

		$title  = isset($instance['title']) ? $instance['title'] : '';
		$images = isset($instance['images']) ? $instance['images'] : '';

		$output = '';

		//Widget title
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$output .= '</p>';

		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'images' ) ) . '">' . esc_html__( 'Images', 'polo_extension' ) . '</label>';
		$output .= '<input class="widefat widget_images_add" id="' . esc_attr( $this->get_field_id( 'images' ) ) . '" name="' . esc_attr( $this->get_field_name( 'images' ) ) . '" type="text" value="' . esc_attr( $images ) . '">';
		$output .= '<a href="#" class="add-item-images button">' . esc_html__( 'Add images', 'polo_extension' ) . '</a>';
		$output .= '<a href="#" class="remove-item-images button">' . esc_html__( 'Remove images', 'polo_extension' ) . '</a>';
		$output .= '</p>';

		echo $output;
	}

	function update( $new_instance, $old_instance ) {

		$instance           = $old_instance;
		$instance['title']  = $new_instance['title'];
		$instance['images'] = $new_instance['images'];

		return $instance;

	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );

		$title  = isset($instance['title']) ? $instance['title'] : '';
		$images = isset($instance['images']) ? explode( ',', $instance['images'] ) : array();

		$output = '';

		$output .= $before_widget;

		if ( isset( $title ) && ! empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}

		if ( isset( $images ) && is_array( $images ) && ! empty( $images ) ) {

			$output .= '<div class="post-slider">';
			$output .= '<div class="carousel" data-carousel-dots="true" data-carousel-col="1" data-carousel-autoplay="true">';

			foreach ( $images as $single_image ) {
				$url = wp_get_attachment_url( $single_image );
				$output .= '<img src="' . esc_url( polo_theme_thumb( $url, 525, 350, true, 'c' ) ) . '" alt="' . get_the_title( $single_image ) . '"/>';
			}

			$output .= '</div>';
			$output .= '</div>';

		}

		$output .= $after_widget;

		echo $output;

	}

}

function Cruimna_Slider_Widget_init() {
	register_widget( 'Crumina_Slider_Widget' );
}

add_action( 'widgets_init', 'Cruimna_Slider_Widget_init' );
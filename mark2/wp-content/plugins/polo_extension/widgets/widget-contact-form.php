<?php

/*
 * Contact form widget
 */

class Crum_Contact_Form extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-contact-us-form',
			'description' => esc_html__( "Displays contact form", 'polo_extension' )
		);
		parent::__construct( 'crum-contact-form-widget', esc_html__( 'Crumina: Contact form', 'polo_extension' ), $widget_ops );
		$this->alt_option_name = 'crum_contact_widget';
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'        => '',
			'email_to'  => '',
			'holder_name'  => '',
			'holder_email' => '',
			'holder_msg'   => '',
			'button_text'  => '',
			'text_successfully'   => '',
		) );

		$title        = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : '';
		$email_to  = isset( $instance['email_to'] ) ? strip_tags( $instance['email_to'] ) : '';
		$holder_name  = isset( $instance['holder_name'] ) ? strip_tags( $instance['holder_name'] ) : '';
		$holder_email = isset( $instance['holder_email'] ) ? strip_tags( $instance['holder_email'] ) : '';
		$holder_msg   = isset( $instance['holder_msg'] ) ? strip_tags( $instance['holder_msg'] ) : '';
		$button_text  = isset( $instance['button_text'] ) ? strip_tags( $instance['button_text'] ) : '';
		$text_successfully  = isset( $instance['text_successfully'] ) ? strip_tags( $instance['text_successfully'] ) : '';

		$widget_output = '';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'email_to' ) ) . '">' . esc_html__( 'Recipient Email Address', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'email_to' ) ) . '" name="' . esc_attr( $this->get_field_name( 'email_to' ) ) . '" type="text" value="' . esc_attr( $email_to ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'holder_name' ) ) . '">' . esc_html__( 'Name field placeholder', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'holder_name' ) ) . '" name="' . esc_attr( $this->get_field_name( 'holder_name' ) ) . '" type="text" value="' . esc_attr( $holder_name ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'holder_email' ) ) . '">' . esc_html__( 'Email field placeholder', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'holder_email' ) ) . '" name="' . esc_attr( $this->get_field_name( 'holder_email' ) ) . '" type="text" value="' . esc_attr( $holder_email ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'holder_msg' ) ) . '">' . esc_html__( 'Message field placeholder', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'holder_msg' ) ) . '" name="' . esc_attr( $this->get_field_name( 'holder_msg' ) ) . '" type="text" value="' . esc_attr( $holder_msg ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'button_text' ) ) . '">' . esc_html__( 'Button text', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'button_text' ) ) . '" name="' . esc_attr( $this->get_field_name( 'button_text' ) ) . '" type="text" value="' . esc_attr( $button_text ) . '">';
		$widget_output .= '</p>';

		$widget_output .= '<p>';
		$widget_output .= '<label for="' . esc_attr( $this->get_field_id( 'text_successfully' ) ) . '">' . esc_html__( 'Thanking message', 'polo_extension' ) . '</label>';
		$widget_output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'text_successfully' ) ) . '" name="' . esc_attr( $this->get_field_name( 'text_successfully' ) ) . '" type="textarea" value="' . esc_attr( $text_successfully ) . '">';
		$widget_output .= '</p>';

		echo $widget_output;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']        = $new_instance['title'];
		$instance['email_to']  = $new_instance['email_to'];
		$instance['holder_name']  = $new_instance['holder_name'];
		$instance['holder_email'] = $new_instance['holder_email'];
		$instance['holder_msg']   = $new_instance['holder_msg'];
		$instance['button_text']  = $new_instance['button_text'];
		$instance['text_successfully']  = $new_instance['text_successfully'];

		return $instance;
	}

	function widget( $args, $instance ) {

		$before_widget = $after_widget = $before_title = $after_title = '';

		extract( $args );

		$title        = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : '';
		$emailTo  = isset( $instance['email_to'] ) ? strip_tags( $instance['email_to'] ) : '';
		$holder_name  = isset( $instance['holder_name'] ) ? strip_tags( $instance['holder_name'] ) : '';
		$holder_email = isset( $instance['holder_email'] ) ? strip_tags( $instance['holder_email'] ) : '';
		$holder_msg   = isset( $instance['holder_msg'] ) ? strip_tags( $instance['holder_msg'] ) : '';
		$button_text  = isset( $instance['button_text'] ) ? strip_tags( $instance['button_text'] ) : '';
		$text_successfully  = isset( $instance['text_successfully'] ) ? strip_tags( $instance['text_successfully'] ) : '';

		$form_id = uniqid();

		if ( isset( $button_text ) && ! empty( $button_text ) ) {
			$text = $button_text;
		} else {
			$text = esc_html__( 'Send message', 'polo_extension' );
		}

		$output = '';

		$output .= $before_widget;

		if ( isset( $title ) && ! empty( $title ) ) {
			$output .= $before_title . $title . $after_title;
		}

		$name = $email = $message = '';

		$hasError = $nameError = $emailError = $messageError = false;

		if ( isset( $_POST['submitted'] ) ) {

			//name verification
			if ( '' === trim( $_POST['senderName'] ) ) {
				$nameError  = apply_filters( 'reactor_contactform_error_name', '<small class="error">' . esc_html__( 'Please enter your name.', 'polo_extension' ) . '</small>' );
				$errorClass = 'error';
				$hasError   = true;
			} else {
				$name = sanitize_text_field( $_POST['senderName'] );
			}

			//email verification
			if ( '' === trim( $_POST['senderEmail'] ) ) {
				$emailError = apply_filters( 'reactor_contactform_error_email', '<small class="error">' . esc_html__( 'Please enter your email.', 'polo_extension' ) . '</small>' );
				$errorClass = 'error';
				$hasError   = true;
			} else {
				if ( ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', trim( $_POST['senderEmail'] ) ) ) {
					$emailError = apply_filters( 'reactor_contactform_error_email_invalid', '<small class="error">' . esc_html__( 'You entered an invalid email address.', 'polo_extension' ) . '</small>' );
					$errorClass = 'error';
					$hasError   = true;
				} else {
					$email = sanitize_text_field( $_POST['senderEmail'] );
				}
			}


			//message verification
			if ( '' === trim( $_POST['comment'] ) ) {
				$messageError = apply_filters( 'reactor_contactform_error_message', '<small class="error">' . esc_html__( 'Please enter your message.', 'polo_extension' ) . '</small>' );
				$errorClass   = 'error';
				$hasError     = true;
			} else {
				$message = sanitize_text_field( $_POST['comment'] );
			}

			if ( false === $hasError ) {

				if ( ! isset( $emailTo ) || ( $emailTo == '' ) || ( ! is_email( $emailTo ) ) || ( $emailTo == 'wwwww' ) ) {
					$emailTo = get_option( 'admin_email' );
				}

				$subject = esc_html__( 'Contact form message','polo_extension' );
				$body    = "Name: $name \n\n Email: $email \n\n Comments: $message";
				$headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;


				if ( wp_mail( $emailTo, $subject, $body, $headers ) ) {
					$emailSent = true;
				} else {
					$emailSent = false;
				}
			}

		}

		if ( isset( $emailSent ) && $emailSent == true ) {
			$msg_sent = esc_html__( $text_successfully, 'polo_extension' );

			ob_start();
			?>
			<div class="thanks">
				<?php echo apply_filters( 'reactor_contactform_success', $msg_sent ); ?>
			</div>
			<?php

			$output = ob_get_clean();

		} else {

			if ( isset( $_SERVER["REQUEST_URI"] ) ) {
				$action = $_SERVER["REQUEST_URI"];
			} else {
				$action = '';
			}

			$output .= '<form class="form-transparent-fields" role="form" method="post" action="' . $action . '" name="contactForm">';

			$output .= '<div class="row">';

			$output .= '<div class="col-md-6">';

			$output .= '<div class="form-group">';
			$output .= '<input class="form-control required" name="senderName" placeholder="' . $holder_name . '" id="name" aria-required="true" type="text" value="' . $name . '">';
			if ( ! ( false === $nameError ) ) {
				$output .= '<span class="error">' . $nameError . '</span>';
			}
			$output .= '</div>';//form-group

			$output .= '<div class="form-group">';
			$output .= '<input class="form-control required email" name="senderEmail" placeholder="' . $holder_email . '" id="email" aria-required="true" type="email" value="' . $email . '">';
			if ( ! ( false === $emailError ) ) {
				$output .= '<span class="error">' . $emailError . '</span>';
			}
			$output .= '</div>';//form-group

			$output .= '</div>';//.col-md-6

			$output .= '<div class="col-md-6">';

			$output .= '<div class="form-group">';
			$output .= '<textarea class="form-control required" name="comment" rows="3" placeholder="' . $holder_msg . '" id="comment" aria-required="true">' . $message . '</textarea>';
			if ( ! ( false === $messageError ) ) {
				$output .= '<span class="error">' . $messageError . '</span>';
			}
			$output .= '<div class="form-group m-t-10">';
			$output .= '<button class="button small right black no-margin" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;' . $text . '</button>';
			$output .= '</div>';//.form-group m-t-10

			$output .= '</div>';//.form-group

			$output .= '</div>';//.col-md-6

			$output .= '</div>';//.row

			$output .= '<input type="hidden" name="submitted" id="submitted" value="true" />';

			$output .= '</form>';//.form-transparent-fields

		}


		$output .= $after_widget;

		echo $output;

	}

}

function Crum_Widget_Contact_Register_Init() {
	register_widget( 'Crum_Contact_Form' );
}

add_action( 'widgets_init', 'Crum_Widget_Contact_Register_Init' );
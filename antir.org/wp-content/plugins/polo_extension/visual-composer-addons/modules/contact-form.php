<?php
if ( ! class_exists( 'Crumina_Contact_Form' ) ) {

	class Crumina_Contact_Form {

		function __construct() {
			add_action( 'vc_before_init', array( &$this, 'contact_form_init' ) );
			add_shortcode( 'crumina_contact_form', array( &$this, 'contact_form_form' ) );
		}

		function validate_form( $form_id ) {
			$output = array(
				'hasError' => false
			);
			if ( isset( $_POST[ 'submitted' . $form_id ] ) ) {

				if ( trim( $_POST[ 'senderName' . $form_id ] ) === '' ) {
					$output['nameError'] = true;
					$output['hasError']  = true;
				} else {
					$output['name'] = sanitize_text_field( $_POST[ 'senderName' . $form_id ] );
				}
				if ( trim( $_POST[ 'senderEmail' . $form_id ] ) === '' ) {
					$output['emailError'] = true;
					$output['hasError']   = true;
				} else {
					if ( ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', trim( $_POST[ 'senderEmail' . $form_id ] ) ) ) {
						$output['emailError'] = true;
						$output['hasError']   = true;
					} else {
						$output['email'] = sanitize_text_field( $_POST[ 'senderEmail' . $form_id ] );
					}
				}
				if ( trim( $_POST[ 'comment' . $form_id ] ) === '' ) {
					$output['commentError'] = true;
					$output['hasError']     = true;
				} else {
					$output['comment'] = sanitize_text_field( $_POST[ 'comment' . $form_id ] );
				}
				if ( isset( $_POST[ 'subject' . $form_id ] ) && ! empty( $_POST[ 'subject' . $form_id ] ) ) {
					$output['subject'] = sanitize_text_field( $_POST[ 'subject' . $form_id ] );
				}
				if ( isset( $_POST[ 'phone' . $form_id ] ) && ! empty( $_POST[ 'phone' . $form_id ] ) ) {
					$output['phone'] = sanitize_text_field( $_POST[ 'phone' . $form_id ] );
				}
				if ( isset( $_POST[ 'company' . $form_id ] ) && ! empty( $_POST[ 'company' . $form_id ] ) ) {
					$output['company'] = sanitize_text_field( $_POST[ 'company' . $form_id ] );
				}

			} // end form validation

			return $output;
		}

		function contact_form_init() {

			$assets_dir = stripslashes( PLUGIN_URL . 'assets/img/' );
			
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						'name'                    => esc_html__( 'Polo Contact form', 'polo_extension' ),
						'base'                    => 'crumina_contact_form',
						'icon'                    => 'contact_form',
						'category'                => esc_html__( 'Polo Modules', 'polo_extension' ),
						'show_settings_on_create' => true,
						'params'                  => array_merge(
							array(
								array(
									'type'       => 'radio_image_select',
									'heading'    => esc_html__( 'Layout', 'polo_extension' ),
									'options'    => array(
										'style_1' => $assets_dir . 'form-all.png',
										'style_2' => $assets_dir . 'form-no-phone.png',
										'style_3' => $assets_dir . 'form-subject.png',
										'style_4' => $assets_dir . 'form-minimal.png',
									),
									'std'        => 'style_1',
									'param_name' => 'layout',
								),
								array(
									'type'       => 'dropdown',
									'heading'    => __( 'Style', 'crum' ),
									'param_name' => 'contact_form_style',
									'value'      => array(
										esc_html__( 'Default', 'crum' )     => 'default',
										esc_html__( 'Grey', 'crum' )        => 'grey',
										esc_html__( 'Transparent', 'crum' ) => 'transparent',
									),
								),
								array(
									'type'        => 'textfield',
									'heading'     => esc_html__( 'Contact email', 'crum' ),
									'param_name'  => 'contact_form_email',
									'description' => esc_html__( 'Set contact form email address', 'crum' ),
								),
								//Name field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Name field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'name_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Name field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'name_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								//Email field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Email field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'email_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Email field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'email_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								//Subject field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Subject field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'subject_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_3' ),
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Subject field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'subject_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_3' ),
								),
								//Phone field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Phone field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'phone_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_1' ),
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Phone field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'phone_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_1' ),
								),
								//Company field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Company field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'company_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_1' ),
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Company field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'company_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'dependency'       => array( 'element' => 'layout', 'value' => 'style_1' ),
								),
								//Comment field
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Comment field', 'crum' ) . ' ' . esc_html__( 'label', 'polo_extension' ),
									'param_name'       => 'comment_label',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Comment field', 'crum' ) . ' ' . esc_html__( 'placeholder', 'polo_extension' ),
									'param_name'       => 'comment_placeholder',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
								),
								array(
									'type'             => 'textfield',
									'heading'          => esc_html__( 'Extra class name', 'polo_extension' ),
									'param_name'       => 'el_class',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'description'      => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'polo_extension' ),
								),
								array(
									'type'             => 'el_id',
									'param_name'       => 'form_id',
									'settings'         => array(
										'auto_generate' => true,
									),
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'heading'          => esc_html__( 'Form ID', 'polo_extension' ),
								),
								array(
									'type'             => 'textarea',
									'heading'          => esc_html__( 'Thanking message', 'polo_extension' ),
									'param_name'       => 'text_enter',
									'edit_field_class' => 'vc_column vc_col-sm-6 crum_vc',
									'description'      => esc_html__( '', 'polo_extension' ),
								),
							),
							array(
								array(
									'type'       => 'dropdown',
									'heading'    => esc_html__( 'Button style', 'polo_extension' ),
									'value'      => array(
										esc_html__( 'Default', 'polo_extension' )            => 'default',
										esc_html__( 'Light', 'polo_extension' )              => 'light',
										esc_html__( 'Light without icon', 'polo_extension' ) => 'light_no_icon',
										esc_html__( 'Dark without icon', 'polo_extension' )  => 'dark_no_icon',
									),
									'param_name' => 'button_style',
									'group'      => esc_html__( 'Button', 'polo_extension' ),
								),
							),
							array(
								array(
									"type"        => "textfield",
									"class"       => "",
									"heading"     => esc_html__( "Button text", 'polo_extension' ),
									"param_name"  => "button_text",
									"admin_label" => false,
									"value"       => "",
									'group'       => esc_html__( 'Button', 'polo_extension' ),
								),
								array(
									'type'       => 'dropdown',
									'heading'    => __( 'Align', 'crum' ),
									'param_name' => 'button_align',
									'value'      => array(
										esc_html__( 'Left', 'crum' )   => 'left',
										esc_html__( 'Right', 'crum' )  => 'right',
										esc_html__( 'Center', 'crum' ) => 'center',
									),
									'group'      => esc_html__( 'Button', 'polo_extension' )
								),
							)


						)
					)
				);
			}

		}

		function contact_form_form( $atts ) {

			$layout        = $contact_form_style = $contact_form_email = $name_label = $name_placeholder = $email_label = $email_placeholder = $form_id = $text_enter = '';
			$subject_label = $subject_placeholder = $phone_label = $phone_placeholder = $company_label = $company_placeholder = $comment_label = $comment_placeholder = $button_text = $button_align = '';
			$button_style  = $button_text = '';
			extract(
				shortcode_atts(
					array(
						'layout'              => 'style_1',
						'contact_form_style'  => 'default',
						'contact_form_email'  => '',
						'name_label'          => '',
						'name_placeholder'    => '',
						'email_label'         => '',
						'email_placeholder'   => '',
						'subject_label'       => '',
						'subject_placeholder' => '',
						'phone_label'         => '',
						'phone_placeholder'   => '',
						'company_label'       => '',
						'company_placeholder' => '',
						'comment_label'       => '',
						'comment_placeholder' => '',
						'button_style'        => 'default',
						'button_text'         => '',
						'button_align'        => 'left',
						'el_class'            => '',
						'form_id'             => '',
						'text_enter'          => '',
					), $atts
				)
			);


			$class = isset( $el_class ) && ! empty( $el_class ) ? $el_class : '';

			if ( 'light' === $button_style ) {
				$button = '<button class="btn btn-white" type="submit" id="form-submit"><i class="fa fa-paper-plane"></i>&nbsp;' . $button_text . '</button>';
			} elseif ( 'light_no_icon' === $button_style ) {
				if ( empty( $button_text ) ) {
					$button_text = esc_html__( 'Send message', 'polo_extension' );
				}
				$button = '<button class="btn button-light center" type="submit" id="form-submit">' . $button_text . '</button>';
			} elseif ( 'dark_no_icon' === $button_style ) {
				if ( empty( $button_text ) ) {
					$button_text = esc_html__( 'Send message', 'polo_extension' );
				}
				$button = '<button class="button border black rounded center" type="submit">' . $button_text . '</button>';
			} else {
				$button = '<button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;' . $button_text . '</button>';
			}
			$form_action = isset( $_SERVER["REQUEST_URI"] ) ? $_SERVER["REQUEST_URI"] : '';

			$output     = $icon = $color_class = '';
			$name_value = $email_value = $phone_value = $company_value = $comment_value = $subject_value = '';

			if ( 'grey' === $contact_form_style ) {
				$color_class = 'class="form-gray-fields"';
			} elseif ( 'transparent' === $contact_form_style ) {
				$color_class = 'class="form-transparent-fields text-light"';
			}
			$msg_sent         = esc_html__( $text_enter, 'crum' );

			$emailSent        = false;
			$validated_params = $this->validate_form( $form_id );

			if ( false === $validated_params['hasError'] ) {
				$emailTo       = $contact_form_email;
				$name = isset( $validated_params['name'] ) ? $validated_params['name'] : '';
				$email = isset( $validated_params['email'] ) ? $validated_params['email'] : '';
				$subject = isset( $validated_params['subject'] ) ? $validated_params['subject'] : '';
				$phone = isset( $validated_params['phone'] ) ? $validated_params['phone'] : '';
				$company = isset( $validated_params['company'] ) ? $validated_params['company'] : '';
				$comment = isset( $validated_params['comment'] ) ? $validated_params['comment'] : '';

				$email_subject = get_bloginfo( 'name' ) . esc_html__( ' - Contact Form Message', 'crum' );

				if ( ! isset( $emailTo ) || ( empty( $emailTo ) ) || ( $emailTo == 'wwwww' ) || ( $emailTo == '#' ) ) {
					$emailTo = get_option( 'admin_email' );
				}

				if ( ! isset( $subject ) || empty( $subject ) ) {
					$subject = $email_subject;
				}
				if ( isset( $name ) && ! empty( $name ) && isset( $email ) && ! empty( $email ) && isset( $comment ) && ! empty( $comment ) ) {
					$body = "Name: $name \n\n Email: $email \n\n ";
					if ( isset( $subject ) && ! empty( $subject ) ) {
						$body .= "Subject: $subject \n\n ";
					}
					if ( isset( $company ) && ! empty( $company ) ) {
						$body .= "Company: $company \n\n ";
					}
					if ( isset( $phone ) && ! empty( $phone ) ) {
						$body .= "Phone: $phone \n\n ";
					}
					$body .= "Comments: $comment";
				} else {
					$body = false;
				}
				$headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;


				if ( wp_mail( $emailTo, $subject, $body, $headers ) ) {
					$emailSent = true;
				} else {
					$emailSent = false;
				}
			}

			$output .= '<div class="contact-form-module ' . esc_attr( $class ) . '">';

			if ( isset( $emailSent ) && ( true === $emailSent ) ) {

				$output .= '<div class="row">';
				$output .= apply_filters( 'polo_contactform_success', $msg_sent );
				$output .= '</div>';//.row

			} else {
				$name_error    = ( isset( $validated_params['nameError'] ) && true === $validated_params['nameError'] ) ? 'has-error' : '';
				$email_error   = ( isset( $validated_params['emailError'] ) && true === $validated_params['emailError'] ) ? 'has-error' : '';
				$comment_error = ( isset( $validated_params['commentError'] ) && true === $validated_params['commentError'] ) ? 'has-error' : '';

				$output .= '<form
					action="' . $form_action . '"
					method="post"
					name="contactForm' . $form_id . '"
					id="contactForm' . $form_id . '"
					' . $color_class . '
			        role="form"
			        class="crumina-contact-form"
			        >';

				$output .= '<div class="row">';
				//Name field begin
				if ( isset( $_POST[ 'senderName' . $form_id ] ) && ! empty( $_POST[ 'senderName' . $form_id ] ) ) {
					$name_value = $_POST[ 'senderName' . $form_id ];
				}
				if ( 'style_4' === $layout ) {
					$output .= '<div class="col-md-12">';
				} else {
					$output .= '<div class="col-md-6">';
				}
				$output .= '<div class="form-group ' . $name_error . '">';
				if ( isset( $name_label ) && ! empty( $name_label ) ) {
					$output .= '<label class="control-label upper" for="name' . $form_id . '">' . $name_label . '</label>';
				}
				$output .= '<input type="text" class="form-control required" name="senderName' . $form_id . '" placeholder="' . esc_attr( $name_placeholder ) . '" id="name' . $form_id . '" aria-required="true" value="' . $name_value . '">';
				$output .= '</div>';//.form-group
				$output .= '</div>';//.col-md-6
				//Name field end

				//Email field begin
				if ( isset( $_POST[ 'senderEmail' . $form_id ] ) && ! empty( $_POST[ 'senderEmail' . $form_id ] ) ) {
					$email_value = $_POST[ 'senderEmail' . $form_id ];
				}
				if ( 'style_4' === $layout ) {
					$output .= '<div class="col-md-12">';
				} else {
					$output .= '<div class="col-md-6">';
				}
				$output .= '<div class="form-group ' . $email_error . '">';
				if ( isset( $email_label ) && ! empty( $email_label ) ) {
					$output .= '<label class="control-label upper" for="email' . $form_id . '">' . $email_label . '</label>';
				}
				$output .= '<input type="email" class="form-control required email" name="senderEmail' . $form_id . '" placeholder="' . $email_placeholder . '" id="email' . $form_id . '" aria-required="true" value="' . $email_value . '">';
				$output .= '</div>';//.form-group
				$output .= '</div>';//.col-md-6
				//Email field end
				$output .= '</div>';//.row

				if ( 'style_3' === $layout ) { //Subject field begin
					if ( isset( $_POST[ 'subject' . $form_id ] ) && ! empty( $_POST[ 'subject' . $form_id ] ) ) {
						$subject_value = $_POST[ 'subject' . $form_id ];
					}
					$output .= '<div class="row">';
					$output .= '<div class="col-md-12">';
					$output .= '<div class="form-group">';
					if ( isset( $subject_label ) && ! empty( $subject_label ) ) {
						$output .= '<label class="upper control-label" for="subject' . $form_id . '">' . $subject_label . '</label>';
					}
					$output .= '<input type="text" class="form-control required" name="subject' . $form_id . '" placeholder="' . $subject_placeholder . '" id="subject' . $form_id . '" aria-required="true" value="' . $subject_value . '">';
					$output .= '</div>';//.form-group
					$output .= '</div>';//.col-md-6
					$output .= '</div>';//.row
					//Subject field end
				}

				if ( 'style_1' === $layout ) {
					$output .= '<div class="row">';

					//Phone field begin
					if ( isset( $_POST[ 'phone' . $form_id ] ) && ! empty( $_POST[ 'phone' . $form_id ] ) ) {
						$phone_value = $_POST[ 'phone' . $form_id ];
					}
					$output .= '<div class="col-md-6">';
					$output .= '<div class="form-group">';
					if ( isset( $phone_label ) && ! empty( $phone_label ) ) {
						$output .= '<label class="upper control-label" for="phone' . $form_id . '">' . $phone_label . '</label>';
					}
					$output .= '<input type="text" class="form-control required" name="phone' . $form_id . '" placeholder="' . $phone_placeholder . '" id="phone' . $form_id . '" aria-required="true" value="' . $phone_value . '">';
					$output .= '</div>';//.form-group
					$output .= '</div>';//.col-md-6
					//Phone field end

					//Company field begin
					if ( isset( $_POST[ 'company' . $form_id ] ) && ! empty( $_POST[ 'company' . $form_id ] ) ) {
						$company_value = $_POST[ 'company' . $form_id ];
					}
					$output .= '<div class="col-md-6">';
					$output .= '<div class="form-group">';
					if ( isset( $company_label ) && ! empty( $company_label ) ) {
						$output .= '<label class="upper control-label" for="company' . $form_id . '">' . $company_label . '</label>';
					}
					$output .= '<input type="text" class="form-control required" name="company' . $form_id . '" placeholder="' . $company_placeholder . '" id="company' . $form_id . '" aria-required="true" value="' . $company_value . '">';
					$output .= '</div>';//.form-group
					$output .= '</div>';//.col-md-6
					//Company field end

					$output .= '</div>';//row
				}

				//Comment field begin
				if ( isset( $_POST[ 'comment' . $form_id ] ) && ! empty( $_POST[ 'comment' . $form_id ] ) ) {
					$comment_value = $_POST[ 'comment' . $form_id ];
				}
				$output .= '<div class="row">';
				$output .= '<div class="col-md-12">';
				$output .= '<div class="form-group ' . $comment_error . '">';
				if ( isset( $comment_label ) && ! empty( $comment_label ) ) {
					$output .= '<label class="control-label upper" for="comment' . $form_id . '">' . $comment_label . '</label>';
				}
				$output .= '<textarea class="form-control required" name="comment' . $form_id . '" rows="9" placeholder="' . $comment_placeholder . '" id="comment' . $form_id . '" aria-required="true">' . $comment_value . '</textarea>';
				$output .= '</div>';//.form-group
				$output .= '</div>';//.col-md-12
				$output .= '</div>';//.row
				//Comment field end

				//Send button begin
				$output .= '<div class="row">';
				$output .= '<div class="col-md-12">';
				$output .= '<div class="form-group text-' . $button_align . '">';
				$output .= $button;
				$output .= '</div>';//.form-group
				$output .= '</div>';//.col-md-12
				$output .= '</div>';//.row
				//Send button end

				$output .= '<input type="hidden" name="submitted' . $form_id . '" id="submitted" value="true" />';

				$output .= '</form>';
			}
			$output .= '</div>';
			return $output;

		}

	}

}

if ( class_exists( 'Crumina_Contact_Form' ) ) {
	$Crumina_Contact_Form = new Crumina_Contact_Form;
}
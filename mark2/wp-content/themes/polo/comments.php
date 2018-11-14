<?php
/**
 * The template for displaying comments
 * uses callback polo_comments in includes/comments.php
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */

// Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'Please do not load this page directly. Thanks!' );
} ?>

<?php if ( post_password_required() ) { ?>
	<div class="alert help">
		<p class="nocomments">
			<?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'polo' ); ?>
		</p>
	</div>
	<?php return;
} ?>

<?php if ( comments_open() || '0' != get_comments_number() ) : ?>


	<?php
	$contact_form_author_field = '';
	$contact_form_author_field .= '<div class="col-md-4">';
	$contact_form_author_field .= '<div class="form-group"><label class="upper" for="first_name">' . esc_html__( 'Your name', 'polo' ) . '</label><input aria-required="true" id="first_name" type="text" class="form-control required" autocomplete="on" name="author" placeholder="' . esc_html__( 'Enter name', 'polo' ) . '"></div>';
	$contact_form_author_field .= '</div>';

	$contact_form_email_field = '';
	$contact_form_email_field .= '<div class="col-md-4">';
	$contact_form_email_field .= '<div class="form-group"><label class="upper" for="last_name">' . esc_html__( 'Your email', 'polo' ) . '</label><input aria-required="true" id="last_name" type="text" class="form-control required" autocomplete="on" name="email" placeholder="' . esc_html__( 'Enter email', 'polo' ) . '"></div>';
	$contact_form_email_field .= '</div>';

	$contact_form_url_field = '';
	$contact_form_url_field .= '<div class="col-md-4">';
	$contact_form_url_field .= '<div class="form-group"><label class="upper" for="url">' . esc_html__( 'Your URL', 'polo' ) . '</label><input aria-required="true" id="url" type="text" class="form-control required" autocomplete="on" name="url" placeholder="' . esc_html__( 'Enter URL', 'polo' ) . '"></div>';
	$contact_form_url_field .= '</div>';

	$contact_form_comment_field = '';
	$contact_form_comment_field .= '<div class="col-md-12">';
	$contact_form_comment_field .= '<div class="form-group">';
	$contact_form_comment_field .= '<label for="comment" class="upper">' . esc_html__( 'Your comment', 'polo' ) . '</label>';
	$contact_form_comment_field .= '<textarea aria-required="true" id="comment" class="form-control required" name="comment" placeholder="' . esc_html__( 'Enter comment', 'polo' ) . '" rows="9"></textarea>';
	$contact_form_comment_field .= '</div>';
	$contact_form_comment_field .= '</div>';
	?>

	<?php if ( have_comments() ) : ?>
		<div id="comments" class="comments">
			<div class="heading">
				<h4 class="comments-title"><?php esc_html_e( 'Comments', 'polo' ); ?>
					<span class="number">(<?php echo get_comments_number( get_the_ID() ); ?>)</span>
				</h4><!--comments-title-->
			</div>
			<!--heading-->

			<?php wp_list_comments( array( 'callback' => 'polo_comments', 'style' => 'div' ) ); ?>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav id="comment-nav-below" class="navigation" role="navigation">
					<div class="nav-previous"><?php previous_comments_link( wp_kses_allowed_html( esc_html__( '&larr; Older Comments', 'polo' ) ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( wp_kses_allowed_html( esc_html__( 'Newer Comments &rarr;', 'polo' ) ) ); ?></div>
				</nav>
			<?php endif; ?>

		</div><!--comments-->
	<?php elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php esc_html_e( 'Comments are closed.', 'polo' ); ?></p>
	<?php endif; ?>
	<?php if ( comments_open() ) : ?>
		<div class="comment-form">
			<div id="cancel-comment-reply">
				<p class="small">
					<?php cancel_comment_reply_link(); ?>
				</p>
			</div>

			<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
				<div class="alert help">
					<p><?php printf( 'You must be %1$slogged in%2$s to post a comment.', '<a href="'.esc_url(wp_login_url( get_permalink() )).'">', '</a>' ); ?></p>
				</div>

			<?php
			else :
				$comment_form_output = '';

				$comment_form_output .= '<div class="heading">';
				$comment_form_output .= '<h4>' . esc_html__( 'Leave a comment', 'polo' ) . '</h4>';
				$comment_form_output .= '</div>';//.heading

				ob_start();
				comment_form( array(
					'title_reply'          => '',
					'fields'               => array(
						'author' => $contact_form_author_field,
						'email'  => $contact_form_email_field,
						'url'    => $contact_form_url_field,
					),
					'comment_notes_before' => '',
					'comment_field'        => $contact_form_comment_field,
					'comment_notes_after'  => '',
					'class_submit'         => 'btn btn-primary',
					'label_submit'         => esc_html__( ' Post comment', 'polo' )
				) );
				$comment_form_output .= ob_get_clean();
				$comment_form_output = str_replace( 'comment-form', 'form-gray-fields', $comment_form_output );
				$comment_form_output = str_replace( '<form', '<div class="row"><form', $comment_form_output );
				$comment_form_output = str_replace( '</form>', '</form></div>', $comment_form_output );
				$comment_form_output = str_replace( '<p ', '<div class="col-md-12"><div class="form-group text-center"><p', $comment_form_output );
				$comment_form_output = str_replace( '</p>', '</p></div></div>', $comment_form_output );

				echo( $comment_form_output );
			endif; ?>

		</div>

	<?php endif; ?>
<?php endif; ?>

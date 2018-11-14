<?php
/**
 * Reactor List Comments Callback
 * callback function for wp_list_comments in reactor/comments.php
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since   1.0.0
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if ( ! function_exists( 'polo_comments' ) ) :
	function polo_comments( $comment, $args, $depth ) {
		do_action( 'polo_comments', $comment, $args, $depth );


		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<div <?php comment_class( 'media' ); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php esc_html_e( 'Pingback:', 'polo' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'polo' ), '<div class="comment-edit-link"><span>', '</span></div>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post, $comment_depth;

				if ( $comment_depth == '1' ) {
					$reply_comment = '';
				} else {
					$reply_comment = ' comment-replied';
				}

				?>
				<div class="comment <?php echo esc_attr( $reply_comment ); ?> ">

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'polo' ); ?></p>
				<?php endif; ?>


				<?php
				$comment_author_email = get_comment_author_email();
				$user                 = get_user_by( 'email', $comment_author_email );
				if ( isset( $user->user_url ) && ! empty( $user->user_url ) ) {
					$user_url = $user->user_url;
				} else {
					$user_url = '#';
				}

				?>

					<a class="pull-left" href="<?php echo esc_url( $user_url ) ?>">
						<?php
						$avatar_output = get_avatar( $comment, 50 );
						$avatar_output = str_replace( 'responsive-img circle', 'avatar', $avatar_output );
						echo( $avatar_output );
						?>
					</a>

					<div class="media-body">
						<?php

						if ( ! ( $user == false ) ) {
							$author_name = $user->display_name;
						} else {
							$author_name = get_comment_author( $comment );
						}

						?>

						<h4 class="media-heading"><?php echo esc_attr( $author_name ); ?></h4>

						<p class="time"><?php echo get_comment_time( 'M d, Y \a\t g:i A', false, true ); ?></p>

						<?php comment_text(); ?>

						<?php
						$comment_reply_link = '';
						ob_start();
						comment_reply_link( array_merge( $args, array(
							'reply_text' => '<i class="fa fa-reply"></i> '.esc_html__('Reply','polo'),
							'before'     => '',
							'after'      => '',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth']
						) ) );
						$comment_reply_link .= ob_get_clean();
						$comment_reply_link = str_replace( 'comment-reply-link', 'comment-reply pull-right', $comment_reply_link );
						echo( $comment_reply_link );
						?>

					</div><!-- end media-body -->

					<!-- #comment-## -->
				<?php
				break;
		endswitch; // end comment_type check
	}
endif;
?>
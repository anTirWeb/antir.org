<?php

/**
 * Comments
 * in single.php
 *
 * @since 1.0.0
 */
function polo_do_post_comments() {
	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() && is_singular() ) {
		comments_template();
	}
}

add_action( 'polo_post_after', 'polo_do_post_comments', 10 );


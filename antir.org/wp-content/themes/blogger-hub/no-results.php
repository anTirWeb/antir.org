<?php
/**
 * The template part for displaying a message that posts cannot be found.
 * @package Blogger Hub
 */
?>

<header>
	<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'blogger-hub' ); ?></h1>
</header>

<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	
	<p><?php printf( esc_html__( 'Ready to publish your first post? Get started here.', 'blogger-hub' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php elseif ( is_search() ) : ?>
	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'blogger-hub' ); ?></p><br />
		<?php get_search_form(); ?>
<?php else : ?>
	<p><?php esc_html_e( 'Dont worry&hellip; it happens to the best of us.', 'blogger-hub' ); ?></p><br />
	<div class="read-moresec">
		<a href="<?php echo esc_url( home_url() ); ?>" class="button hvr-sweep-to-right"><?php esc_html_e( 'Back to Home Page', 'blogger-hub' ); ?></a>
	</div>
<?php endif; ?>

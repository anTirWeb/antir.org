<?php
/**
 * The template for displaying the search form
 *
 * @package   Reactor
 * @subpackge Templates
 * @since     1.0.0
 */
?>
<form class="form-inline" role="search" method="get" id="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input class="form-control" name="s" type="search" placeholder="<?php esc_html_e( 'Search for pages...', 'polo' ); ?>">
		<span class="input-group-btn">
			<button type="submit" class="btn color btn-primary"><i class="fa fa-search"></i></button>
		</span>
	</div>
</form>


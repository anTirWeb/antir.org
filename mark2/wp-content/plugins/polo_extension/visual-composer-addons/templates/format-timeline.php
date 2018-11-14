<?php

$excerpt_length = get_query_var( 'excerpt_length' );
$show_meta      = get_query_var( 'show_meta' );
$show_excerpt   = get_query_var( 'show_excerpt' );

?>

<li>
	<div class="timeline-block">


		<div class="post-item">
			<?php
			if ( function_exists( 'polo_do_post_feature' ) ) {
				echo polo_do_post_feature( get_the_ID() );
			}
			?>
			<div class="post-content-details">
				<div class="post-title">
					<h3>
						<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ) ?>"><?php echo esc_attr( get_the_title( get_the_ID() ) ); ?></a>
					</h3>
				</div>
				<?php if ( function_exists( 'polo_post_info' ) && ('1' === $show_meta)) {
					echo polo_post_info();
				} ?>
				<?php if('1' === $show_excerpt){?>
				<div class="post-description">
					<?php if ( function_exists( 'polo_post_text' ) ) {
						echo polo_post_text( get_the_ID(), $excerpt_length );
					} ?>

					<div class="post-info">
						<a class="read-more" href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
							<?php esc_html_e( 'read more', 'polo_extension' ) ?>
							<i class="fa fa-long-arrow-right"></i>
						</a>
					</div>
				</div>
				<?php }?>
			</div>
			<?php if ( function_exists( 'polo_post_meta' ) && ('1' === $show_meta)) {
				echo polo_post_meta();
			} ?>
		</div>

	</div>
</li>

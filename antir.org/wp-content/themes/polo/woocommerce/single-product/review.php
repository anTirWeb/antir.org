<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

?>
<div itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<a href="#" class="pull-left">
		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '300' ), '' ); ?>
	</a>

	<div class="media-body">

		<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) : ?>

			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating product-rate" title="<?php echo sprintf( esc_attr__( 'Rated %d out of 5', 'polo' ), $rating ) ?>">
				<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo ($rating); ?></strong> <?php esc_html_e( 'out of 5', 'polo' ); ?></span>
			</div>

		<?php endif; ?>

		<?php if ( $comment->comment_approved == '0' ) : ?>

			<p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'polo' ); ?></em></p>

		<?php else : ?>

			<h4 class="media-heading"><?php comment_author(); ?></h4>

			<?php
			if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' ) {
				if ( $verified ) {
					echo '<em class="verified">(' . esc_html__( 'verified owner', 'polo' ) . ')</em> ';
				}
			}
			?>

		<?php endif; ?>

		<?php comment_text(); ?>

	</div>

</div>
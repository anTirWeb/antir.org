<?php
/**
 * Wishlist page template
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.12
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php if ( count( $wishlist_items ) > 0 ): ?>

	<?php do_action( 'yith_wcwl_before_wishlist_form', $wishlist_meta ); ?>

	<form id="yith-wcwl-form" action="<?php echo esc_url( YITH_WCWL()->get_wishlist_url( 'view' . ( $wishlist_meta['is_default'] != 1 ? '/' . $wishlist_meta['wishlist_token'] : '' ) ) ) ?>" method="post" class="woocommerce">

		<?php wp_nonce_field( 'yith-wcwl-form', 'yith_wcwl_form_nonce' ) ?>

		<div class="shop-cart">
			<div class="table table-condensed table-striped">
				<!-- TITLE -->
				<?php
				do_action( 'yith_wcwl_before_wishlist_title' );


				if ( ! empty( $page_title ) ) :
					?>
					<?php if ( $wishlist_meta['is_default'] != 1 && $is_user_owner ): ?>
					<div class="hidden-title-form">
						<input type="text" value="<?php echo ($page_title) ?>" name="wishlist_name" />
						<button>
							<?php echo apply_filters( 'yith_wcwl_save_wishlist_title_icon', '<i class="fa fa-check"></i>' ) ?>
							<?php esc_html_e( 'Save', 'polo' ) ?>
						</button>
						<a class="hide-title-form btn button">
							<?php echo apply_filters( 'yith_wcwl_cancel_wishlist_title_icon', '<i class="fa fa-remove"></i>' ) ?>
							<?php esc_html_e( 'Cancel', 'polo' ) ?>
						</a>
					</div>
				<?php endif; ?>
					<?php
				endif;

				do_action( 'yith_wcwl_before_wishlist' ); ?>

				<!-- WISHLIST TABLE -->
				<table class="cart wishlist_table table" data-pagination="<?php echo esc_attr( $pagination ) ?>" data-per-page="<?php echo esc_attr( $per_page ) ?>" data-page="<?php echo esc_attr( $current_page ) ?>" data-id="<?php echo ( is_user_logged_in() ) ? esc_attr( $wishlist_meta['ID'] ) : '' ?>" data-token="<?php echo ( ! empty( $wishlist_meta['wishlist_token'] ) && is_user_logged_in() ) ? esc_attr( $wishlist_meta['wishlist_token'] ) : '' ?>">

					<?php $column_count = 2; ?>

					<thead>
					<tr>
						<?php if ( $show_cb ) : ?>

							<th class="cart-product-checkbox">
								<input type="checkbox" value="" name="" id="bulk_add_to_cart" />
							</th>

							<?php
							$column_count ++;
						endif;
						?>

						<?php if ( $is_user_owner ): ?>
							<th class="cart-product-remove"></th>
							<?php
							$column_count ++;
						endif;
						?>

						<th class="cart-product-thumbnail">
							<?php echo apply_filters( 'yith_wcwl_wishlist_view_name_heading', esc_html__( 'Product', 'polo' ) ) ?>
						</th>

						<th class="cart-product-name">
							<?php echo apply_filters( 'yith_wcwl_wishlist_view_description_heading', esc_html__( 'Description', 'polo' ) ) ?>
						</th>

						<?php if ( $show_price ) : ?>

							<th class="cart-product-price">
								<?php echo apply_filters( 'yith_wcwl_wishlist_view_price_heading', esc_html__( 'Price', 'polo' ) ) ?>
							</th>

							<?php
							$column_count ++;
						endif;
						?>

						<?php if ( $show_last_column ) : ?>

							<th class="cart-product-add-to-cart"></th>

							<?php
							$column_count ++;
						endif;
						?>
					</tr>
					</thead>

					<tbody>
					<?php
					if ( count( $wishlist_items ) > 0 ) :
						foreach ( $wishlist_items as $item ) :
							global $product;
							if ( function_exists( 'wc_get_product' ) ) {
								$product = wc_get_product( $item['prod_id'] );
							} else {
								$product = get_product( $item['prod_id'] );
							}

							if ( $product !== false && $product->exists() ) :
								$availability = $product->get_availability();
								$stock_status = $availability['class'];
								?>
								<tr id="yith-wcwl-row-<?php echo ($item['prod_id']) ?>" data-row-id="<?php echo ($item['prod_id']) ?>">
									<?php if ( $show_cb ) : ?>
										<td class="product-checkbox">
											<input type="checkbox" value="<?php echo esc_attr( $item['prod_id'] ) ?>" name="add_to_cart[]" <?php echo ( $product->product_type != 'simple' ) ? 'disabled="disabled"' : '' ?>/>
										</td>
									<?php endif ?>

									<?php if ( $is_user_owner ): ?>
										<td class="product-remove">
											<div>
												<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item['prod_id'] ) ) ?>" class="remove_from_wishlist" title="<?php esc_html_e( 'Remove this product', 'polo' ) ?>"><i class="fa fa-close"></i></a>
											</div>
										</td>
									<?php endif; ?>

									<td class="cart-product-thumbnail">
										<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ) ?>">
											<?php
												$wishlist_thumb = polo_do_small_image($item['prod_id'],array('width' => '380','height' => '507'));
											?>
											<img src="<?php echo esc_url($wishlist_thumb);?>">
										</a>
										<div class="cart-product-thumbnail-name"><?php echo esc_attr( $product->get_title() ); ?></div>
									</td>

									<td class="cart-product-description">
										<p><?php echo esc_attr(wp_trim_words($product->post->post_excerpt,'20',''));?></p>
										<?php do_action( 'yith_wcwl_table_after_product_name', $item ); ?>
									</td>

									<?php if ( $show_price ) : ?>
										<td class="cart-product-price">
											<?php
											if ( is_a( $product, 'WC_Product_Bundle' ) ) {
												if ( $product->min_price != $product->max_price ) {
													echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
												} else {
													echo wc_price( $product->min_price );
												}
											} elseif ( $product->price != '0' ) {
												echo ($product->get_price_html());
											} else {
												echo apply_filters( 'yith_free_text', esc_html__( 'Free!', 'polo' ) );
											}
											?>
										</td>
									<?php endif ?>

									<?php if ( $show_last_column ): ?>
										<td class="cart-product-add-to-cart">
											<!-- Date added -->
											<?php
											if ( $show_dateadded && isset( $item['dateadded'] ) ):
												echo '<span class="dateadded">' . sprintf( esc_attr__( 'Added on : %s', 'polo' ), date_i18n( get_option( 'date_format' ), strtotime( $item['dateadded'] ) ) ) . '</span>';
											endif;
											?>

											<!-- Add to cart button -->
											<?php if ( $show_add_to_cart && isset( $stock_status ) && $stock_status != 'Out' ): ?>
												<?php
												if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
													woocommerce_template_loop_add_to_cart();
												} else {
													wc_get_template( 'loop/add-to-cart.php' );
												}
												?>
											<?php endif ?>

											<!-- Change wishlist -->
											<?php if ( $available_multi_wishlist && is_user_logged_in() && count( $users_wishlists ) > 1 && $move_to_another_wishlist ): ?>
												<select class="change-wishlist selectBox">
													<option value=""><?php esc_html_e( 'Move', 'polo' ) ?></option>
													<?php
													foreach ( $users_wishlists as $wl ):
														if ( $wl['wishlist_token'] == $wishlist_meta['wishlist_token'] ) {
															continue;
														}

														?>
														<option value="<?php echo esc_attr( $wl['wishlist_token'] ) ?>">
															<?php
															$wl_title = ! empty( $wl['wishlist_name'] ) ? esc_html( $wl['wishlist_name'] ) : esc_html( $default_wishlsit_title );
															if ( $wl['wishlist_privacy'] == 1 ) {
																$wl_privacy = esc_html__( 'Shared', 'polo' );
															} elseif ( $wl['wishlist_privacy'] == 2 ) {
																$wl_privacy = esc_html__( 'Private', 'polo' );
															} else {
																$wl_privacy = esc_html__( 'Public', 'polo' );
															}

															echo sprintf( '%s - %s', $wl_title, $wl_privacy );
															?>
														</option>
														<?php
													endforeach;
													?>
												</select>
											<?php endif; ?>

											<!-- Remove from wishlist -->
											<?php if ( $is_user_owner && $repeat_remove_button ): ?>
												<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item['prod_id'] ) ) ?>" class="remove_from_wishlist button" title="<?php esc_html_e( 'Remove this product', 'polo' ) ?>"><?php esc_html_e( 'Remove', 'polo' ) ?></a>
											<?php endif; ?>
										</td>
									<?php endif; ?>
								</tr>
								<?php
							endif;
						endforeach;
					else: ?>
						<tr>
							<td colspan="<?php echo esc_attr( $column_count ) ?>" class="wishlist-empty"><?php esc_html_e( 'No products were added to the wishlist', 'polo' ) ?></td>
						</tr>
						<?php
					endif;

					if ( ! empty( $page_links ) ) : ?>
						<tr class="pagination-row">
							<td colspan="<?php echo esc_attr( $column_count ) ?>"><?php echo ($page_links) ?></td>
						</tr>
					<?php endif ?>
					</tbody>

				</table>

				<?php wp_nonce_field( 'yith_wcwl_edit_wishlist_action', 'yith_wcwl_edit_wishlist' ); ?>

				<?php if ( $wishlist_meta['is_default'] != 1 ): ?>
					<input type="hidden" value="<?php echo ($wishlist_meta['wishlist_token']) ?>" name="wishlist_id" id="wishlist_id">
				<?php endif; ?>

				<?php do_action( 'yith_wcwl_after_wishlist' ); ?>
			</div><!--table table-condensed table-striped table-responsive-->
		</div><!--shop-cart-->

	</form>

	<?php do_action( 'yith_wcwl_after_wishlist_form', $wishlist_meta ); ?>

<?php else: ?>

	<div class="p-t-10 m-b-20 text-center">

		<div class="heading-fancy heading-line text-center">

			<h4><?php esc_html_e( 'Your Wishlist is currently empty.', 'polo' ); ?></h4>

		</div><!--heading-fancy heading-line text-center-->

		<?php do_action( 'woocommerce_cart_is_empty' ); ?>

		<a class="button color button-3d rounded icon-left empty-card-button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<span><?php esc_html_e( 'Return To Shop', 'polo' ) ?></span>
		</a>

	</div><!--p-t-10 m-b-20 text-center-->

<?php endif; ?>

<?php if ( $additional_info ): ?>
	<div id="ask_an_estimate_popup">
		<form action="<?php echo ($ask_estimate_url) ?>" method="post" class="wishlist-ask-an-estimate-popup">
			<?php if ( ! empty( $additional_info_label ) ): ?>
				<label for="additional_notes"><?php echo esc_html( $additional_info_label ) ?></label>
			<?php endif; ?>
			<textarea id="additional_notes" name="additional_notes"></textarea>

			<button class="btn button ask-an-estimate-button ask-an-estimate-button-popup">
				<?php echo apply_filters( 'yith_wcwl_ask_an_estimate_icon', '<i class="fa fa-shopping-cart"></i>' ) ?>
				<?php esc_html_e( 'Ask for an estimate', 'polo' ) ?>
			</button>
		</form>
	</div>
<?php endif; ?>
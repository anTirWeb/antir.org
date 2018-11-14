<li class="frmdates_date_list_item <?php echo esc_attr( $css_classes ); ?>" data-date="<?php echo esc_attr( $date ); ?>">
	<a href="#" class="frmdates_remove_item"><span class="dashicons dashicons-dismiss"></span></a>
	<span class="frmdates_date_with_format"><?php echo esc_html( $formatted_date ); ?></span>

	<?php if ( ! empty( $input_name ) ) : ?>
	<input type="hidden" name="field_options[<?php echo esc_attr( $input_name ); ?>][]" value="<?php echo esc_attr( $date ); ?>" />
	<?php endif; ?>
</li>

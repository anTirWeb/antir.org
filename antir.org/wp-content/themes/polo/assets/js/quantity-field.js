jQuery(document).ready(function () {

	// This button will increment the value
	jQuery('.qtyplus').click(function (e) {
		// Stop acting like a button
		e.preventDefault();
		// Get the field name
		var input_field = jQuery(this).siblings('.qty');
		// Get its current value
		var currentVal = parseInt(input_field.val());
		// If is not undefined
		if (!isNaN(currentVal)) {
			// Increment
			input_field.val(currentVal + 1);
		} else {
			// Otherwise put a 0 there
			input_field.val(0);
		}
	});
	// This button will decrement the value till 0
	jQuery('.qtyminus').click(function (e) {
		// Stop acting like a button
		e.preventDefault();
		// Get the field name
		var input_field = jQuery(this).siblings('.qty');
		// Get its current value
		var currentVal = parseInt(input_field.val());
		// If it isn't undefined or its greater than 0
		if (!isNaN(currentVal) && currentVal > 0) {
			// Decrement one
			input_field.val(currentVal - 1);
		} else {
			// Otherwise put a 0 there
			input_field.val(0);
		}
	});
});
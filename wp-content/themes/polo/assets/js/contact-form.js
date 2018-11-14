jQuery(function ($) {
	"use strict";

	$('.crum-subscribe-form').on("submit", function (event) {
		// Stop form from submitting normally
		event.preventDefault();

		// Get some values from elements on the page:
		var $form = $(this),
			email = $.trim($form.find('input[name="crum_email"]').val());


		// Send the data using post
		var posting = $.post(polo_ajax_object.ajax_url, {'action': 'polo_subscribe', 'crum_email': email, 'crum_subscribe': 1 });

		// Put the results in a div
		posting.done(function () {
			$form.html('<h4>' + $form.data('msg') + '</h4>').fadeTo(300, 1);
		});

	});
});
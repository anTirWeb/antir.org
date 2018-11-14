jQuery(document).ready(function ($) {

	//Add and remove image buttons

	var widget_image = $("input.widget_image_add");
	if (0 == widget_image.siblings("a").length) {
		widget_image.after('<a href="#" class="remove-item-image button">Remove image</a>');
		widget_image.after('<a href="#" class="add-item-image button">Add image</a>');
	}

	var tgm_media_frame;
	var image_field;

	jQuery(document.body).on("click", '.add-item-image', function (e) {
		image_field = $(this).siblings("input.widget_image_add");
		e.preventDefault();
		if (tgm_media_frame) {
			tgm_media_frame.open();
			return false;
		}

		tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
			frame   : 'select',
			multiple: false,
			library : {type: 'image'}
		});

		tgm_media_frame.on("select", function () {
			var media_attachment = tgm_media_frame.state().get('selection').first().toJSON();
			var image_link = media_attachment.url;
			jQuery(image_field).val(image_link);
		});
		// Now that everything has been set, let's open up the frame.
		tgm_media_frame.open();
	});

	//Remove image button
	jQuery(".remove-item-image").on("click", function () {
		$(this).siblings('input.widget_image_add').val("");
		return false;
	});

});
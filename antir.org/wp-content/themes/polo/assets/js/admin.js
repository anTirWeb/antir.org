jQuery(document).ready(function ($) {

	var tgm_media_frame;
	var image_field;

	//Add image button
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

	//Add images
	jQuery(document.body).on("click", '.add-item-images', function (e) {
		image_field = $(this).siblings("input.widget_images_add");
		e.preventDefault();
		if (tgm_media_frame) {
			tgm_media_frame.open();
			return false;
		}

		tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
			frame   : 'select',
			multiple: true,
			library : {type: 'image'}
		});

		tgm_media_frame.on('select', function () {
			var selection = tgm_media_frame.state().get('selection');
			var ids = [];
			var i = 0;
			selection.map(function (attachment) {
				attachment = attachment.toJSON();
				ids[i] = attachment.id;
				i++;
			});
			var img_ids = ids.join(',');
			jQuery(image_field).val(img_ids);
		});

		tgm_media_frame.open();
	});

	//Remove images button
	jQuery(".remove-item-images").on("click", function () {
		$(this).siblings('input.widget_images_add').val("");
		return false;
	});

	/**Page metaboxes for loop templates**/

	jQuery('#meta_news_page_options').hide(); // Default Hide
	jQuery('#meta_page_options').show();
	jQuery('#before_content_shortcode_section').show();
	jQuery('#maintenance_page_options').hide();
	jQuery('#meta_portfolio_page_options').hide();
	jQuery('#page_404_options').hide();
	jQuery('#meta_products_page_options').hide();
	jQuery('#meta_portfolio_page_panel_options').hide();
	jQuery('#one_page_options').hide();

	if (jQuery("#page_template :selected").val() == 'page-templates/news-page.php') {
		jQuery('#meta_news_page_options').show();
		jQuery('#before_content_shortcode_section').show();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').show();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/maintenance-page.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#meta_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#maintenance_page_options').show();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/404-page.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').show();
		jQuery('#page_404_options').show();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/portfolio-page.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').show();
		jQuery('#meta_page_options').show();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/shop-page.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').show();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').show();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/portfolio-page-side.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').hide();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').show();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/page-blank.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').hide();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	} else if (jQuery("#page_template :selected").val() == 'page-templates/one-page.php') {
		jQuery('#meta_news_page_options').hide();
		jQuery('#before_content_shortcode_section').hide();
		jQuery('#maintenance_page_options').hide();
		jQuery('#meta_portfolio_page_options').hide();
		jQuery('#meta_page_options').hide();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').show();
	} else {
		jQuery('#meta_news_page_options').hide(); // Default Hide
		jQuery('#meta_portfolio_page_options').hide(); // Default Hide
		jQuery('#maintenance_page_options').hide(); // Default Hide
		jQuery('#meta_page_options').show();
		jQuery('#before_content_shortcode_section').show();
		jQuery('#page_404_options').hide();
		jQuery('#meta_products_page_options').hide();
		jQuery('#meta_portfolio_page_panel_options').hide();
		jQuery('#one_page_options').hide();
	}

	jQuery('#page_template').change(function () {

		if (jQuery("#page_template :selected").val() == 'page-templates/news-page.php') {
			jQuery('#meta_news_page_options').show();
			jQuery('#before_content_shortcode_section').show();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').show();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/maintenance-page.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').show();
			jQuery('#meta_portfolio_page_options').show();
			jQuery('#meta_page_options').hide();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/404-page.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').show();
			jQuery('#page_404_options').show();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/portfolio-page.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').show();
			jQuery('#meta_page_options').show();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/shop-page.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').show();
			jQuery('#page_404_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
			jQuery('#meta_products_page_options').show();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/portfolio-page-side.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').hide();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#one_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').show();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/page-blank.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').hide();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		} else if (jQuery("#page_template :selected").val() == 'page-templates/one-page.php') {
			jQuery('#meta_news_page_options').hide();
			jQuery('#before_content_shortcode_section').hide();
			jQuery('#maintenance_page_options').hide();
			jQuery('#meta_portfolio_page_options').hide();
			jQuery('#meta_page_options').hide();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').show();
		} else {
			jQuery('#meta_news_page_options').hide(); // Default Hide
			jQuery('#maintenance_page_options').hide(); // Default Hide
			jQuery('#meta_portfolio_page_options').hide(); // Default Hide
			jQuery('#meta_page_options').show();
			jQuery('#before_content_shortcode_section').show();
			jQuery('#page_404_options').hide();
			jQuery('#meta_products_page_options').hide();
			jQuery('#meta_portfolio_page_panel_options').hide();
			jQuery('#one_page_options').hide();
		}

	});

	/**Post featured metaboxes for different post formats**/

	if (jQuery('body').hasClass('post-type-post')) {

		var $post_format_metaboxes = jQuery('#post-format-audio-feature, #post-format-video-feature, #post-format-gallery-feature');

		var crum_pf_selected = jQuery("#post-formats-select").find('input:radio[name=post_format]:checked').val();

		$post_format_metaboxes.hide(); // Default Hide

		jQuery('#post-format-' + crum_pf_selected + '-feature').show();

		jQuery('#post-formats-select').find('input:radio[name=post_format]').change(function () {

			$post_format_metaboxes.hide(); // Hide during changing

			crum_pf_selected = jQuery("#post-formats-select").find('input:radio[name=post_format]:checked').val();

			if (this.value == crum_pf_selected) {
				jQuery('#post-format-' + crum_pf_selected + '-feature').show();
			}

		});
	}

});


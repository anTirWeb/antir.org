jQuery(document).ready(function ($) {

	jQuery('#import-niche').hide(); // Default Hide
	jQuery('#import-creative').hide(); // Default Hide
	jQuery('#import-portfolio').hide(); // Default Hide
	jQuery('#import-hero').hide(); // Default Hide
	jQuery('#import-shop').hide(); // Default Hide
	jQuery('#import-magazine').hide(); // Default Hide
	jQuery('#import-onepage').hide(); // Default Hide
	jQuery('#import-corporate').show(); // Default Hide

	if (jQuery("#import-type :selected").val() == 'corporate') {
		jQuery('#import-corporate').show();
		jQuery('#import-niche').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-shop').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'niche') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').show();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-shop').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'creative') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').show(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'portfolio') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').show(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'templates') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').show(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'shop') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').show();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'magazine') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-magazine').show(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
	} else if (jQuery("#import-type :selected").val() == 'onepage') {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').show(); // Default Hide
	} else {
		jQuery('#import-corporate').hide();
		jQuery('#import-niche').hide();
		jQuery('#import-shop').hide();
		jQuery('#import-hero').hide(); // Default Hide
		jQuery('#import-creative').hide(); // Default Hide
		jQuery('#import-portfolio').hide(); // Default Hide
		jQuery('#import-magazine').hide(); // Default Hide
		jQuery('#import-onepage').hide(); // Default Hide
	}

	jQuery('#import-type').change(function () {

		if (jQuery("#import-type :selected").val() == 'corporate') {
			jQuery('#import-corporate').show();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'niche') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').show();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-shop').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'creative') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-shop').hide(); // Default Hide
			jQuery('#import-creative').show(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'portfolio') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-shop').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
			jQuery('#import-portfolio').show(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'templates') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').hide();
			jQuery('#import-hero').show(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'shop') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').show();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
		} else if (jQuery("#import-type :selected").val() == 'magazine') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
			jQuery('#import-magazine').show(); // Default Hide
		}  else if (jQuery("#import-type :selected").val() == 'onepage') {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
			jQuery('#import-onepage').show(); // Default Hide
		} else {
			jQuery('#import-corporate').hide();
			jQuery('#import-niche').hide();
			jQuery('#import-shop').hide();
			jQuery('#import-hero').hide(); // Default Hide
			jQuery('#import-creative').hide(); // Default Hide
			jQuery('#import-portfolio').hide(); // Default Hide
			jQuery('#import-onepage').hide(); // Default Hide
			jQuery('#import-magazine').hide(); // Default Hide
		}

	});

});

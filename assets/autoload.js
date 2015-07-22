
var getFeaturedUsers = function() {
	var pf = $('.pf_featured_users');
	if (pf.length && !pf.hasClass('_pf_p_built')) {
		var auth = $('#auth-user'), image = auth.data('image'), name, payment, el = pf.find('.user_rows_mini');

		pf.addClass('_pf_p_built');

		image = image.replace(new RegExp('50_square', 'g'), '120_square');
		image = image.replace(new RegExp('_size__50', 'g'), '_size__120');

		name = '<span id="js_user_name_link_' + auth.data('user-name') + '" class="user_profile_link_span"><a href="#">' + auth.data('name') + '</a></span>';

		payment = '<a href="' + PF.url.make('/featured-users/pay') + '" class="payment-popup popup js_hover_title"><i class="fa fa-plus-circle"></i><span class="js_hover_info">Get added here</span></a>';

		// el.before('<div class="payment-featured-info"></div>');
		el.prepend('<div class="user_rows">' + payment + '<div class="user_rows_image">' + image + '</div>' + name + '</div>');
		$Core.loadInit();
	}
};

(getFeaturedUsers)();
$Ready(getFeaturedUsers);
jQuery(document).ready(function ($) {
	// Perform AJAX login/register on form submit
	jQuery('form#olam-login, form#olam-register').on('submit', function (e) {
		var curElement="#"+jQuery(this).attr('id');
		jQuery(curElement+' p.status', this).show().text(ajax_auth_object.loadingmessage);
		if (jQuery(this).attr('id') == 'olam-register') {
			action = 'olam_ajaxregister';
			username = jQuery('#reg-username').val();
			password = jQuery('#reg-password').val();
			password2 = jQuery('#reg-password2').val()
			email = jQuery('#reg-email').val();
			security = jQuery('#signonsecurity').val();
			ctrl = jQuery(this);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_auth_object.ajaxurl,
				data: {
					'action': action,
					'username': username,
					'password': password,
					'password2': password2,
					'email': email,
					'security': security,
				},
				success: function (data) {
					console.log(curElement);
					jQuery(curElement+' p.olam-msg-status').text(data.message);
					if (data.loggedin == true) {
						document.location.href = jQuery(ctrl).attr ('id') == 'register' ? ajax_auth_object.register_redirect : ajax_auth_object.redirecturl;
					}
				}
			});
		}
		else{ 
			action = 'olam_ajaxlogin';
			username = 	jQuery('form#olam-login #username').val();
			password = jQuery('form#olam-login #password').val();
			security = jQuery('form#olam-login #security').val();			
			ctrl = jQuery(this);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_auth_object.ajaxurl,
				data: {
					'action': action,
					'username': username,
					'password': password,
					'security': security,
				},
				success: function (data) {
					jQuery(curElement+' p.olam-msg-status').text(data.message);
					if (data.loggedin == true) {
						document.location.href = jQuery(ctrl).attr ('id') == 'register' ? ajax_auth_object.register_redirect : ajax_auth_object.redirecturl;
					}
				}
			});
		}
		e.preventDefault();
	});
});
(function($){

	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	function showChatButton() {
		jQuery(".rcl-menu").css("display", "block");
		jQuery("#rcl-tabs").css("height", "auto");
	}

	function setMessagesCount(count) {
		jQuery(".messages-count > a").text(count);
		if(jQuery(".messages-count > a").first().text() != "0") {
			jQuery(".messages-count").addClass("active");
		} else {
			jQuery(".messages-count").removeClass("active");
		}
	}

	function messagesCountAjax() {
		var data = {
			action: "messagesCount"
		};
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
			success: function( result ) {
				if(result) {
					setMessagesCount(result);
				}
			}
		});
	}

	function dialogNotSelectMessage() {
		jQuery("#rcl-office").html("<h5>Диалог не выбран</h5>");
		jQuery("#rcl-office").addClass("flex-center");
	}

	function isUserPageAjax() {
		debugger;
		var uid = getUrlVars()["user"];
		if(uid != undefined) {
			var data = {
				action: "isUserId",
				uid: uid
			};
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: data,
				success: function( result ) {
					if(!result) {
						showChatButton();
					} else {
						dialogNotSelectMessage();
					}
				}
			});
		}
	}

	function wpRecall() {
		if(!location.href.endsWith("/messages/")) {
			isUserPageAjax();
		} else {
			dialogNotSelectMessage();
		}
		if(jQuery(".messages-count > a").first().text() != "0") {
			jQuery(".messages-count").addClass("active");
		}
		setInterval(messagesCountAjax, 5000);
	}

	$(window).ready(function() {
		
	});

	$(window).load(function(){
		wpRecall();
	});

	$(document).on("scroll", function(){
		
	});

})(jQuery);
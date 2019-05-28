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

	function chatBoxHandler() {
		$(".contact-box").on("mousemove", function(e) {
			var relativeCPos = e.pageX - $(this).offset().left;
			var middle = $(this).width() / 2;
			var flipMiddleRange = 0;

			if( relativeCPos < (middle - flipMiddleRange) ) {
				$(this).addClass("flip-reverse");
				$(this).removeClass("flip");
				$(this).removeClass("flip-center");
			} else if(relativeCPos > (middle + flipMiddleRange)) {
				$(this).addClass("flip");
				$(this).removeClass("flip-reverse");
				$(this).removeClass("flip-center");
			} else {
				$(this).addClass("flip-center");
				$(this).removeClass("flip-reverse");
				$(this).removeClass("flip");
			}
		});

		$(".contact-box").on("mouseleave", function() {
			$(this).removeClass("flip");
			$(this).removeClass("flip-reverse");
			$(this).removeClass("flip-center");
		});
	}

	function formRedirect() {
		$('#payout').submit(function() {
			$("#payout-submit").remove();
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: { 
					payOut: $("#payOut").val(),
					type: $("#type").val(),
					purse: $("#purse").val()
				},
				success: function(json) {
				   window.location.href = "http://www.joberli.ru";
				}
			})
			return false;
		});
	}

	function postSaveHandler() {
		$(".post-save").click(function (e) {
			e.preventDefault();
			postId = $(this).data("id");

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "savePost",
					postId: postId
				},
				success: function() {
				}
			});
		});
	}

	$(window).ready(function() {

	});

	$(window).load(function(){
		postSaveHandler();
		wpRecall();
		chatBoxHandler();
		formRedirect();
	});

	$(document).on("scroll", function(){
		
	});

})(jQuery);
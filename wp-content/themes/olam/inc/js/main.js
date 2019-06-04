(function($){
	var DEBUG = true;

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
		if(!DEBUG) {
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
					success: function() {
						window.location.href = "http://www.joberli.ru";
					}
				})
				return false;
			});
		}
	}

	function payoutFormHandler() {
		payoutField = $("#payout #payOut");
		typeSelect = $("#payout #type");
		typeSelect.on("change", function() {
			if($(this).val() == "card") {
				payoutField.attr("min", 121);
				payoutField.attr("value", 121);
			} else {
				payoutField.attr("min", 11);
				payoutField.attr("value", 11);
			}
			if($(this).val() == "webmoney") {
				$("#payout").prepend("<p class='message-post'>Для WebMoney используется только R кошельки.</p>")
			} else {
				$(".message-post").remove();
			}
		});
	}

	function postSaveHandler() {
		$(".post-save").click(function (e) {
			var _this = $(this);
			e.preventDefault();
			
			if($(this).hasClass("active")) return;
			
			$(".post-save[data-id=" + _this.data("id") + "]").addClass("loader");

			postId = $(this).data("id");
			index = $(this).index();

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "savePost",
					postId: postId
				},
				success: function() {
					$(".post-save[data-id=" + _this.data("id") + "]").addClass("active");
					$(".post-save[data-id=" + _this.data("id") + "]").removeClass("loader");
				}
			});
		});
	}

	function postRemoveHandler() {
		$(".post-save").click(function (e) {
			var _this = $(this);
			e.preventDefault();
			
			if(!$(this).hasClass("active")) return;

			$(".post-save[data-id=" + _this.data("id") + "]").addClass("loader");

			postId = $(this).data("id");

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "removePost",
					postId: postId
				},
				success: function() {
					$(".post-save[data-id=" + _this.data("id") + "]").removeClass("active");
					$(".post-save[data-id=" + _this.data("id") + "]").removeClass("loader");
				}
			});
		});
	}

	function addedPostsHandler() {
		$(".post-save").each(function (i) {
			postId = $(this).data("id");

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "isPostAdded",
					postId: postId
				},
				success: function(result) {
					if(result) {
						$(".post-save:eq(" + i + ")").addClass("active");
					}
				}
			});
		});
	}

	function updateOnlineHandler() {
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "updateOnline"
			},
			success: function() {
			}
		});
		setInterval(function() {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "updateOnline"
				},
				success: function() {
				}
			});
		}, 20000);
	}

	function checkOnlineHandler() {
		setInterval(() => {
			$(".contact-box.preloader-parent").each(function() {
				var _this = $(this);

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					dataType: 'json',
					data: {
						action: "isOnline",
						uid: _this.data("contact")
					},
					success: function(result) {
						if(result) {
							_this.removeClass("offline");
							_this.addClass("online");
						} else {
							_this.removeClass("online");
							_this.addClass("offline");
						}
					}
				});
			});
		}, 30000);
	}

	function purchaseHandler() {
		$(".purchase-button").click(function(e) {
			var _this = $(this);
			var _form = _this.parent().parent().parent();

			_this.addClass("hidden");
			e.preventDefault();

			var priceNumber = _form.find("input[name='edd_options[price_id][]']:checked").val();

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: "purchase",
					postId: _this.data("download-id"),
					priceNumber: priceNumber
				},
				success: function(data) {
					_this.removeClass("hidden");
					if(DEBUG) {
						alert(data);
					}
				},
				error: function(e) {
					_this.removeClass("hidden");
					if(DEBUG) {
						alert(JSON.stringify(e.responseJSON.data));
					}
				}
			});
		});
	}

	$(window).ready(function() {
		purchaseHandler();
		addedPostsHandler();
		postRemoveHandler();
		postSaveHandler();
		formRedirect();
		payoutFormHandler();
	});

	$(window).load(function(){
		wpRecall();
		chatBoxHandler();
		updateOnlineHandler();
		checkOnlineHandler();
	});

	$(document).on("scroll", function(){
		
	});

})(jQuery);
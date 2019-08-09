(function($){
	var DEBUG = true;

	function buildPopUp(type, args, callback, callbackArgs){
		$("#universalModal .modal-title").html("");
		$("#universalModal .modal-body").html("");
		var tmp = $("#universalModal .modal-footer").html();
		$("#universalModal .modal-footer").html('<button type="button" class="btn btn-secondary close" data-dismiss="modal"></button>');
		$("#universalModal .close").html("");
		if (type == "error"){
			$("#universalModal .modal-title").html(args.title);
			$("#universalModal .modal-body").html("<p>"+args.body+"</p>");
			$("#universalModal .modal-footer").html('<button type="button" class="btn btn-secondary confirm">'+args.confirmButton+'</button>');
			//$("#universalModal .close").html("Закрыть");
		}
		if (type == "dialog"){
			$("#universalModal .modal-title").html(args.title);
			$("#universalModal .modal-body").html("<p>"+args.body+"</p>");
			var tmp = $("#universalModal .modal-footer").html();
			$("#universalModal .modal-footer").html('<button type="button" class="btn btn-secondary confirm">'+args.confirmButton+'</button>'+tmp);
			$("#universalModal .close").html(args.closeButton);
		}

		$("#universalModal").modal("show");

		$("#universalModal .confirm").click(function(e){
			$("#universalModal").modal('hide');
			if(typeof callback === "function") {
				if(callbackArgs != undefined) {
					callback(callbackArgs);
				} else {
					callback();
				}
			}
		});
	}

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
			$('#payout-submit').hide();
			$('#payout').append("<div class='loader'></div>");
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				dataType: 'json',
				data: { 
					payOut: $("#payOut").val(),
					type: $("#type").val(),
					purse: $("#purse").val()
				},
				success: function(data) {
					if(data.success != false) {
						buildPopUp("error",{title: "Уcпех!", 
						body: 'Вывод средств прошёл успешно', 
						confirmButton: "Оk"}, function(){
							window.location.href = "http://www.joberli.ru";
						});
					} else {
						buildPopUp("error",{title: "Ошибка", 
						body: data.data,
						confirmButton: "Ok"});
						$('#payout-submit').show();
						$('#payout .loader').hide();	
					}
				},
				error: function() {
					buildPopUp("error",{title: "Ошибка", 
					body: 'Произошла непредвиденная ошибка:(',
					confirmButton: "Ok"});
					$('#payout-submit').show();
					$('#payout .loader').hide();
				}
			})
			return false;
		});
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
					var current = $(".post-save[data-id=" + _this.data("id") + "]");
					var count = parseInt(current.find(".posts-count").first().text());
					count++;
					current.find(".posts-count").text(count);
					current.addClass("active");
					current.removeClass("loader");
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
					var current = $(".post-save[data-id=" + _this.data("id") + "]");
					var count = parseInt(current.find(".posts-count").first().text());
					count--;
					if(count < 0) {
						count = 0;
					}
					current.find(".posts-count").text(count);
					current.removeClass("active");
					current.removeClass("loader");
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

	function modalsHandler() {
		$(".noLoggedUser").click(function(e){
			buildPopUp("error",{title: "Упс...", 
			body: '<a href="#" class="login-button login-trigger" data-dismiss="modal">Войдите или зарегистрируйтесь</a>, чтобы продолжить', 
			confirmButton: "Закрыть"});
		});

		
		$(".sidebar .cart-box .edd-submit span").html("Купить");
		$(".sidebar .cart-box .edd-submit .edd-loading").html("");
		$(".sidebar .cart-box .edd-submit").css("display","block");

		$("#play-video-modal").on("hidden.bs.modal", function() {
			$(this).find(".modal-content").html("");
		});

		$(".video-button").click(function() {
			$("#play-video-modal .modal-content").html(getVideoSection( $(this).data("video") ));
		});
	}

	function tabsHandler() {
		$( function() {
			$("#tabs").tabs();
			$("#tabs").removeClass("hidden");
		} );
	}

	function makeDirectPurchase(downloadId, priceNumber, _this, callback, callbackArgs) {
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "purchase",
				postId: downloadId,
				priceNumber: priceNumber
			},
			success: function(data) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Покупка",
								body: "Оплата прошла успешно, номер заказа: " + data,
								confirmButton: "Ок"}, callback, callbackArgs);
				if(DEBUG) {
					alert(data);
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});
				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function makePurchase() {
		var _this = $(".purchase-button");
		
		var _form = _this.parent().parent().parent();
		
		_this.addClass("hidden");

		var priceNumber = _form.find("input[name='edd_options[price_id][]']:checked").val();

		makeDirectPurchase(_this.data("download-id"), priceNumber, _this);
	}

	function makeCartPurchase() {
		var _this = $(".cart-purchase-button");
		makeDirectPurchase(_this.data("download-id"), _this.data("price-number"), _this, function() {
			window.location = _this.parent().find(".edd_cart_remove_item_btn").attr("href");
		});
	}

	function cancelPurchase(sender) {
		_this = sender;

		_this.addClass("hidden");

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "cancelPurchase",
				orderId: _this.data("order-id"),
			},
			success: function(data) {
				buildPopUp("error",{title: "Отмена", 
								body: "Заказ отменён успешно",
								confirmButton: "Ок"});
				if(DEBUG) {
					alert(data);
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Упс, ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});

				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function confirmOrderDone(sender) {
		_this = sender;

		_this.addClass("hidden");

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "confirmOrderDone",
				orderId: _this.data("order-id"),
			},
			success: function(data) {
				buildPopUp("error",{title: "Подтверждение", 
								body: "Выполнение заказа подтверждено",
								confirmButton: "Ок"});
				if(DEBUG) {
					alert(data);
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Упс, ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});

				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function setOrderInProgress(sender) {
		_this = sender;

		_this.addClass("hidden");

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "setOrderInProgress",
				orderId: _this.data("order-id"),
			},
			success: function(data) {
				buildPopUp("error",{title: "Подтверждение", 
								body: "Заказ принят",
								confirmButton: "Ок"});
				if(DEBUG) {
					alert(data);
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Упс, ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});

				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function cancelOrderConfirm(sender) {
		_this = sender;

		_this.addClass("hidden");

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "cancelOrderConfirm",
				orderId: _this.data("order-id"),
			},
			success: function(data) {
				buildPopUp("error",{title: "Отмена", 
								body: "Заказ отменён",
								confirmButton: "Ок"});
				if(DEBUG) {
					alert(data);
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Упс, ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});

				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function setOrderDone(sender) {
		_this = sender;

		_this.addClass("hidden");

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "setOrderDone",
				orderId: _this.data("order-id"),
			},
			success: function(data) {
				buildPopUp("error",{title: "Завершение", 
								body: "Заказ завершён",
								confirmButton: "Ок"});
				if(DEBUG) {
					alert(JSON.stringify(data));
				}
			},
			error: function(e) {
				_this.removeClass("hidden");
				buildPopUp("error",{title: "Упс, ошибка!", 
								body: e.responseJSON.data,
								confirmButton: "Ок"});

				if(DEBUG) {
					alert("Error: " + JSON.stringify(e.responseJSON.data));
				}
			}
		});
	}

	function purchaseHandler() {

		$(".cart-purchase-button").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение покупки", 
								 body: "Вы действительно хотите это купить?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отменить"}, makeCartPurchase);
		});

		$(".purchase-button").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение покупки", 
								 body: "Вы действительно хотите это купить?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отменить"}, makePurchase);
		});

		$(".cancel-purchase").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение отмены", 
								 body: "Вы действительно хотите отменить заказ?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отмена"}, cancelPurchase, $(this));
		});

		$(".confirm-order-done").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение выполнения заказа", 
								 body: "Вы действительно хотите подтвердить выполнения заказа?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отмена"}, confirmOrderDone, $(this));
		});

		$(".set-order-in-progress").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение принятия заказа", 
								 body: "Вы действительно хотите принять заказ?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отмена"}, setOrderInProgress, $(this));
		});

		$(".cancel-order-confirm").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Потверждение отмены заказа", 
								 body: "Вы действительно хотите отменить заказ?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отмена"}, cancelOrderConfirm, $(this));
		});

		$(".set-order-done").click(function(e){
			e.preventDefault();
			buildPopUp("dialog",{title: "Завершение заказа", 
								 body: "Вы действительно хотите завершить заказ?", 
								 class: "confirmPurchase", 
								 confirmButton: "Да", 
								 closeButton: "Отмена"}, setOrderDone, $(this));
		});

	}

	function sendWpQuery(query, dataTemplate, dataSource, args, callback) {
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			dataType: 'json',
			data: {
				action: "wpQueryAjax",
				query: query,
				dataTemplate: dataTemplate,
				dataArgs: args
			},
			success: function(data) {
				$("*[data-items-source='" + dataSource + "']").append(data);

				if(typeof callback === "function") {
					callback(data);
				}

			}
		});
	}
	var paged = 2;
	function wpQueryAjaxHandler() {
		$(".post-ajax").click(function(e) {
			var _this = $(this);
			_this.hide();
			e.preventDefault();

			var args = _this.data("args");
			args["paged"] = paged;
			
			sendWpQuery(_this.data("query"), _this.data("template"), _this.data("source"), args, function(data) {
				if(data.trim() != "") {
					paged++;
					_this.show();
					postHandlers();
				} else {
					$("*[data-items-source='" + _this.data("source") + "']").append('<span class="clearfix"></span>');
				    $("*[data-items-source='" + _this.data("source") + "']").append("<p class='center'>Постов больше нет.</p>");
				}
			});
		});
	}

	function getYoutubeVideoId(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
	}
	
    function getVideoSection(data) {
        if(data.toLowerCase().includes("youtube.com") || data.toLowerCase().includes("youtu.be")) {
            var videoId = getYoutubeVideoId(data);
            //var iframeMarkup = '<iframe width="320" height="240" src="//www.youtube.com/embed/' 
			//	+ videoId + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
			var iframeMarkup = '<iframe frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player" src="https://www.youtube.com/embed/'+videoId+'?autoplay=1&controls=1&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;loop=0&amp;fs=0&amp;hl=ru&amp;iv_load_policy=3&amp;enablejsapi=1&amp;widgetid=1"></iframe>';

            var result = iframeMarkup;
        } else {
            var result = '<video style="background: #000;" controls="">'
				+ '<source src="' + data + '" type="video/mp4" autoplay>'
				+ 'Your browser does not support the video.'
			+ '</video>';
		}
		return result;
	}

	function matchHeightHandlers() {
		$(".product .edd_download_inner .product-name").matchHeight();
		$(".slider-item .edd_download_inner .product-name").matchHeight();
		$(".rp .rp-content-area").matchHeight();
	}

	function mmenuHandler() {
		const menu = new MmenuLight( document.querySelector( '#mmenu' ), {
			title: 'Меню',
			// theme: 'light',
			// selected: 'Selected'
		});
		menu.enable( 'all' ); // '(max-width: 900px)'
		menu.offcanvas({
			// position: 'left',// [| 'right']
			// move: true,// [| false]
			// blockPage: true,// [| false | 'modal']
		});

		//	Open the menu.
		document.querySelector( 'a[href="#mmenu"]' )
			.addEventListener( 'click', ( evnt ) => {
				menu.open();

				//	Don't forget to "preventDefault" and to "stopPropagation".
				evnt.preventDefault();
				evnt.stopPropagation();
			});

		$("#mmenu").css("z-index", "9999");
		$("#mmenu").removeClass("hidden");
	}

	function postHandlers() {
		addedPostsHandler();
		postRemoveHandler();
		postSaveHandler();
		matchHeightHandlers();
	}

	$(window).ready(function() {
		mmenuHandler();
		wpQueryAjaxHandler();
		purchaseHandler();
		postHandlers();
		formRedirect();
		payoutFormHandler();
		modalsHandler();
		tabsHandler();
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
jQuery(document).ready(function(){

	function buildToolTip(className, status){
		winWidth = jQuery(window).width();
		if(winWidth > 1022) {
			var pos = jQuery(className).offset();
			jQuery('.tooltip-blue').html(jQuery(className).data('discription'));
			jQuery('.tooltip-blue').offset({top: pos['top']+60, left: pos['left']+20});
			if (status == 'show'){
				jQuery('.tooltip-blue').css('opacity','1');
			}
			else if (status == 'hide'){
				jQuery('.tooltip-blue').css('opacity','0');
			}
		}
	}
	function showToolTip(){
		
		jQuery(".mouseHover").mouseenter(function(){
			buildToolTip(this,'show');
		}).mouseleave(function(){
			buildToolTip(this,'hide');
		});

		jQuery(".tabs-button").attr('data-toggle','tooltip');
		jQuery(".tabs-button").attr('data-placement','bottom');

		/*jQuery(".messages-count").click(function(e){
			jQuery(this).addClass("messageOpenDialog");
			jQuery('.message_popup').css("z-index","10000");
			jQuery(".message_popup").css("display","inline-flex");
			var pos = jQuery(this).offset();
			jQuery('.message_popup').html(jQuery(this).data('discription'));
			jQuery('.message_popup').offset({top: pos['top']+40, left: pos['left']-(jQuery('.message_popup').width()/2+8)});
			e.preventDefault();
			jQuery(".messages-count.messageOpenDialog").click(function(e){
				jQuery(".messages-count").removeClass("messageOpenDialog");
				jQuery(".message_popup").css("display","none");
				e.preventDefault();
			});
		});*/
		function showMes(){
			jQuery(".messages-count").click(function(e){
				jQuery(this).addClass("messageOpenDialog");
				jQuery('.message_popup').css("z-index","10000");
				jQuery(".message_popup").css("display","inline-flex");
				var pos = jQuery(this).offset();
				jQuery('.message_popup').html(jQuery(this).data('discription'));
				jQuery('.message_popup').offset({top: pos['top']+40, left: pos['left']-(jQuery('.message_popup').width()/2+8)});
				e.preventDefault();
				closeMes();
			});
		}
		function closeMes(){
			jQuery(".messages-count.messageOpenDialog").click(function(e){
				jQuery(".messages-count").removeClass("messageOpenDialog");
				jQuery(".message_popup").css("display","none");
				e.preventDefault();
				showMes();
			});
		}

		jQuery(".message_popup .mes_footer .mes_close").click(function(e){
			jQuery(".messages-count").removeClass("messageOpenDialog");
			jQuery(".messages-count").addClass("messageClosedDialog");
			jQuery(".message_popup").css("display","none");
			e.preventDefault();
			showMes();
		});
		showMes();
	}
	showToolTip();

	function tooltip(){
		jQuery('[data-toggle="tooltip"]').tooltip({delay: { show: 0, hide: 100 }});
	}
	tooltip();

	// Mobile Navigation
	jQuery('.nav-toggle').click(function(){
		jQuery('.mob-nav').slideToggle();
		jQuery('.header').toggleClass('menu-visible')
		jQuery('body').toggleClass('disable-scroll');
	});


	'use strict';
	// -------------------------------------------------------------
	//   Scroll slider
	// -------------------------------------------------------------
	function galler_slider() {
		jQuery('.product_gallery_slider_wrapper').each(function() {
			var $frame  = jQuery(this).find('.product_gallery_slider');
			var $slide 	= $frame.children('ul').eq(0);
			var $wrap   = $frame.parent();

			// Call Sly on frame
			$frame.sly({
				horizontal: 1,
				itemNav: 'basic',
				smart: 1,
				activateOn: 'click',
				mouseDragging: 1,
				touchDragging: 1,
				releaseSwing: 1,
				scrollBar: $wrap.find('.scrollbar'),
				scrollBy: 1,
				pagesBar: $wrap.find('.pages'),
				activatePageOn: 'click',
				speed: 300,
				elasticBounds: 1,
				easing: 'easeOutExpo',
				dragHandle: 1,
				dynamicHandle: 1,
				clickBar: 1,

				// Buttons
				forward: $wrap.find('.forward'),
				backward: $wrap.find('.backward'),
				prev: $wrap.find('.prev'),
				next: $wrap.find('.next'),
				prevPage: $wrap.find('.prevPage'),
				nextPage: $wrap.find('.nextPage')
			});
		});
	}
	galler_slider();


	// Testimonial Carousel
	var tc = jQuery(".testimonial-carousel");
	tc.owlCarousel({
	    margin:0,
	    nav:false,
	    dots:false,
        singleItem: true,
	    responsiveClass:true,
        URLhashListener:true,
        startPosition: 'URLHash',
        autoplay:true,
	    autoplayTimeout:5000,
	    autoplayHoverPause:true,
	    autoplaySpeed:1000,
	    items:1,
	    loop:true,
	});

	jQuery('.edd_price_options, .modal-content').find('label').each(function() {
		jQuery(this).removeAttr("for");
		if(jQuery(this).find('input').is(':checked')){
			jQuery(this).parent().addClass('checked');
		} else {			
			jQuery(this).parent().removeClass('checked');
		}
		jQuery(this).click(function() {
			if(jQuery(this).parents('.edd_price_options').hasClass('edd_multi_mode')) {
				if(jQuery(this).find('input[type="checkbox"]').is(':checked')){
					jQuery(this).parent().addClass('checked');
				} else {			
					jQuery(this).parent().removeClass('checked');
				}
			} else {
				if(jQuery(this).find('input[type="radio"]').is(':checked')){
					jQuery(this).parent().addClass('checked').siblings('li').removeClass('checked');
				} else {			
					jQuery(this).parent().removeClass('checked');
				}
			}			
		})
	});
	jQuery('label.selectit').each(function() {
		jQuery(this).removeAttr("for");
		if(jQuery(this).find('input').is(':checked')){
			jQuery(this).addClass('checked');
		} else {			
			jQuery(this).removeClass('checked');
		}
		jQuery(this).click(function() {
			if(jQuery(this).find('input[type="checkbox"]').is(':checked')){
				jQuery(this).addClass('checked');
			} else {			
				jQuery(this).removeClass('checked');
			}		
		})
	});

	//Products Carousel
	var pc = jQuery(".product-carousel");
	pc.owlCarousel({
	    //loop:false,
	    margin:0,
	    nav:false,
	    //dots:false,
	    responsiveClass:true,
        URLhashListener:true,
        startPosition: 'URLHash',
        loop:false,
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:2,
	        },
	        992:{
	            items:3,
	        },
	        1200:{
	            items:3,
	        }
	    }
	});

	//Products Carousel
	var pc = jQuery(".banner-slider");
	pc.owlCarousel({
	    loop: jQuery('.owl-carousel img').length > 1 ? true : false,
	    margin:0,
	    nav:true,
	    dots:false,
	    singleItem:true,
	    items:1,
  		rewindNav:false
	});

	var footerHeight = jQuery('#footer').outerHeight();
	jQuery('#footer').css({'margin-top':-footerHeight});
	jQuery('.middle-area').css({'padding-bottom':footerHeight})

    jQuery('.parallax-section').each(function() {
    	jQuery(this).parallax("50%", 0.1);
    });
    if( typeof(prettyPhoto) === 'function' ){
	    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
	    	allow_resize: true, slideshow:5000, autoplay_slideshow:true, social_tools:false,  hideflash: true, showTitle: false, 
	   	});
	}

   	jQuery('.sidebar-trigger').click(function(){
   		jQuery('.woocom-sidebar').toggleClass('sidebar-visible')
   	})
});
function responsiveNav() {
	winWidth = jQuery(window).width();
	if(winWidth <= 1023) {
		jQuery('.shop-nav').appendTo('.col-shop');
		jQuery('#nav').appendTo('.mob-nav');
		jQuery('.col-shop, .nav-toggle').show();
		jQuery('.header').addClass('responsive-nav');
	}
	else {		
		jQuery('#nav').appendTo('.col-nav');
		jQuery('.shop-nav').appendTo('#nav');
		jQuery("#nav ul.menu > li").mouseenter( function(){
			jQuery(this).addClass('active-nav');
			var subMenu = jQuery(this).children('.sub-menu');
			subMenu.css('z-index','2000');
			if(jQuery(this).hasClass('menu-item-has-mega-menu')){
				jQuery(this).children('.mega-menu').addClass('mega-menu-visible');
			}
		});
		jQuery("#nav ul.menu > li").mouseleave( function(){
			jQuery(this).removeClass('active-nav');
			var subMenu = jQuery(this).children('.sub-menu');
			setTimeout( function(){
				subMenu.css('z-index','0');
			},500);
		});
		jQuery('.header').removeClass('responsive-nav');
		jQuery('.col-shop, .nav-toggle').hide();
	}

}

function firstSectionPadding() {
	winWidth = jQuery(window).width();
	headerHeight = jQuery('#header').outerHeight();
	headerWraperHeight = jQuery('.header-wrapper').outerHeight();
	if(jQuery('body').hasClass('home')) {
		if(jQuery('body').hasClass('header-overlay' || 'header-sticky')) {
			jQuery('#header').next('.section').animate({'padding-top': headerHeight + 80});
			if(!jQuery('.fw-page-builder-content').find('.section:first-child').hasClass('cover-pages')){
				jQuery('.fw-page-builder-content').find('.section:first-child').animate({'padding-top': headerWraperHeight + 80});
			}
		};
	}
}
// Full  height section
function  fullHeight() {
	wnHeight = jQuery(window).height();
	winWidth = jQuery(window).width();
	//if(winWidth > 767 & wnHeight > 599) {
		jQuery('.cover-pages').each(function() {
			jQuery('.cover-pages').animate({'min-height': wnHeight}).addClass('covered');
		});

	    // Centered elements
	    jQuery('.cover-pages').each(function() {
	    	var centered 	= jQuery(this).find('.centered');
	    	var thisHeight 	= jQuery(centered).height();
	    	if(jQuery(this).hasClass('no-padding')) {
		    	var paddingTop   = 0;
		    } else {
		    	var paddingTop   = 72;
		    }
	    	if(thisHeight < wnHeight) {
	    		margin = wnHeight - thisHeight - paddingTop;
	    		centered.animate({'padding-top': margin/2})
	    	}        
	    });
	//}
}


//  quick contact form trigger
function quickContact() {
	jQuery('.qw-title').click(function() {
		jQuery(this).next('.quick-window').toggleClass('quick-window-active').slideToggle();
		jQuery(this).parent('.quick-contact').toggleClass('qw-active');
	});
}

function cartWidget() {
	winWidth = jQuery(window).width();
	if(winWidth > 1022) {
		// Do nothing
		jQuery('.cart-btn').on('touchstart', function (e) {
		    'use strict'; //satisfy code inspectors
		    var link = jQuery(this).parents('li'); //preselect the link
		    if (link.hasClass('hover')) {
		        return true;
                jQuery(this).removeClass('hover');
		    } else {
		        link.addClass('hover');
		        link.siblings('li').removeClass('hover');
		        e.preventDefault();
		        return false; //extra, and to make sure the function has consistent return points
		    }
		});
		jQuery(document).click(function() {
            jQuery('.shop-nav li').removeClass('hover');
		});
		jQuery('body').on('touchstart', function (e) {
			jQuery('.shop-nav li').removeClass('hover');
		});
	} else {
		jQuery('.cart-btn').click(function(){
			if(jQuery(this).parent('.cart-widget').hasClass('cw-active')) {
				jQuery(this).parent('.cart-widget').removeClass('cw-active');
				jQuery('body').css({"overflow":'auto'});
			} else {
				jQuery(this).parent('.cart-widget').addClass('cw-active');
				jQuery('body').css({"overflow":'hidden'});
			}
		});
	}
}
// Checking for quick contact form validation errors.
function quickContactErrorCheck(){
	var errorFlag=0;
	clearQuickContactErrors();
	if((jQuery("#qc-name").val() == null || jQuery("#qc-name").val() == "") ){
		jQuery(".olam_name").fadeIn().html("Enter your name");
		errorFlag=1;
	}
	if((jQuery("#qc-email").val() == null || jQuery("#qc-email").val() == "") ){
		jQuery(".olam_email").fadeIn().html("Enter your email");
		errorFlag=1;
	}
	if((jQuery("#qc-message").val() == null || jQuery("#qc-message").val() == "") ){
		jQuery(".olam_message").fadeIn().html("Enter your message");
		errorFlag=1;
	}
	return errorFlag;
}

// Checking for contact form validation errors.

function contactErrorCheck(){
	var errorFlag=0;
	clearContactErrors();
	if((jQuery("#c-name").val() == null || jQuery("#c-name").val() == "") ){
		jQuery(".olam-c-name").fadeIn().html("Enter your name");
		errorFlag=1;
	}
	if((jQuery("#c-email").val() == null || jQuery("#c-email").val() == "") ){
		jQuery(".olam-c-email").fadeIn().html("Enter your email");
		errorFlag=1;
	}
	if((jQuery("#c-message").val() == null || jQuery("#c-message").val() == "") ){
		jQuery(".olam-c-message").fadeIn().html("Enter your message");
		errorFlag=1;
	}
	return errorFlag;
}

// validate email function
function validateEmail(email) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(email);
}
// Clearing quick contact validation errors.
function clearQuickContactErrors(){
	jQuery(".olam_name").fadeOut().html("");
	jQuery(".olam_email").fadeOut().html("");
	jQuery(".olam_message").fadeOut().html("");
}

// Clearing contact validation errors.
function clearContactErrors(){
	jQuery(".olam-c-name").fadeOut().html("");
	jQuery(".olam-c-email").fadeOut().html("");
	jQuery(".olam-c-message").fadeOut().html("");
}

function formFields() {	
   	jQuery(this).find('#edd-user-login-wrap, #edd-user-pass-wrap').addClass('field-holder');
    jQuery('#edd-email-wrap, #edd-first-name-wrap, #edd-last-name-wrap, #edd-card-address-wrap, #edd-card-address-2-wrap, #edd-card-city-wrap, #edd-card-zip-wrap, #edd-card-number-wrap, #edd-card-cvc-wrap, #edd-card-name-wrap, #card-expiration').addClass('field-holder');
    jQuery('.comment-form-author, .comment-form-email, .comment-form-url, .comment-form-comment, .comment_form_review_title').addClass('field-holder');
    jQuery('#edd-user-login-wrap, #edd-user-pass-wrap, #edd-user-pass-confirm-wrap, #edd-user-login-wrap, #edd-user-pass-wrap, .form-row').addClass('field-holder');
    jQuery('#edd-card-country-wrap, #edd-card-state-wrap').addClass('field-holder holder-focus, .form-row.validate-state');
    

    // Keep the label out of the input field if value is not empty by default
    jQuery('input, textarea').each(function(){    	
    	var parent = jQuery(this).parent();
    	var parents = jQuery(this).parents('.fes-el');
    	if(parent.hasClass('field-holder')){
    		jQuery(this).removeAttr('placeholder');
    		if(jQuery(this).val().length === 0) {
    			parent.removeClass('holder-focus');
    		}
    		else {
    			parent.addClass('holder-focus');
    		}
    	}
    	if(parents.hasClass('field-holder')){
    		jQuery(this).removeAttr('placeholder');
    		if(jQuery(this).val().length === 0) {
    			parents.removeClass('holder-focus');
    		}
    		else {
    			parents.addClass('holder-focus');
    		}
    	}
    })
    // Placeholder animation on focus
    jQuery('.field-holder').find('input, textarea').focus(function(){
    	jQuery(this).parent('.field-holder').addClass('holder-focus');
    	jQuery(this).parents('.field-holder').addClass('holder-focus');

    });
    // Keep the label out of the input field if value is not empty
    jQuery('.field-holder').find('input, textarea').focusout(function(){
    	if(jQuery(this).val().length === 0) {
    		jQuery(this).parent('.field-holder').removeClass('holder-focus');
    		jQuery(this).parents('.field-holder').removeClass('holder-focus');
    	}
    });

    // Keep the label out of select field
    jQuery('select').each(function(){
    	var parent = jQuery(this).parent();
    	var parents = jQuery(this).parents('.fes-el');
    	var woo_parents = jQuery(this).parents('.form-row');
    	if(!jQuery(this).hasClass('multiselect')) {
	    	if(parent.hasClass('field-holder')){
	    		parent.addClass('holder-focus');
	    	}
	    	if(parents.hasClass('field-holder')){
	    		parents.addClass('holder-focus');
	    	}
	    	if(woo_parents.hasClass('field-holder')){
	    		woo_parents.addClass('holder-focus');
	    	}
	    }
    });

    jQuery('.fes-ajax-form').each(function() {
    	var heading = jQuery(this).prev('h1');
    	var fesForm = jQuery(this).find('.fes-form');
    	heading.insertBefore(fesForm)
    });

    jQuery('.fes-el').each(function() {
    	jQuery(this).find('.fes-help').insertAfter(jQuery(this));
    })
}
function megaMenuWidth() {
	winWidth = jQuery(window).width();
	// Navigation
	if(winWidth > 991) {
		/**
		 * Mega Menu
		*/
		jQuery(function ($) {
		 	function hoverIn() {
		 		var a = jQuery(this);
		 		var nav = a.closest('#nav');
		 		var mega = a.find('.mega-menu');
		 		var offset = rightSide(nav) - leftSide(a);
		 		mega.width(Math.min(rightSide(nav), columns(mega)*180));
		 		mega.css('left', Math.min(0, offset - mega.width()));
		 	}
		 	function hoverOut() {}
		 	function columns(mega) {
		 		var columns = 0;
		 		mega.children('.mega-menu-row').each(function () {
		 			columns = Math.max(columns, $(this).children('.mega-menu-col').length);
		 		});
		 		return columns;
		 	}
		 	function leftSide(elem) {
		 		return elem.offset().left;
		 	}
		 	function rightSide(elem) {
		 		return elem.offset().left + elem.width();
		 	}
		 	$('#nav .menu-item-has-mega-menu').hover(hoverIn, hoverOut);
		});
	}
}

jQuery(document).ready(function() {

	// EDD ajax cart 
	jQuery(document.body).on('click', '.edd-add-to-cart, .edd-remove-from-cart', function(){
		olamMiniCartSetDelay();
	});

	// Quick Contact Submit
	jQuery("#olam-quick-contact").submit(function(e){
		e.preventDefault();
		if(quickContactErrorCheck()==0){
			jQuery.ajax({
				type: 'POST',
				url:ajaxurl,
				data: jQuery("#olam-quick-contact").serialize()+'&action=olam_quickcontact_action',
				success: function( result ) {
					jQuery(".quickcontact-success").html("Your query submitted succesfully!");
					jQuery(".quickcontact-success").fadeIn();

				}
			});
		}
	});

	// Contact Submit
	jQuery(".olam-contact").submit(function(e){
		e.preventDefault();
		if(contactErrorCheck()==0){
			jQuery.ajax({
				type: 'POST',
				url:ajaxurl,
				data: jQuery(".olam-contact").serialize()+'&action=olam_contact_action',
				success: function( result ) {
					jQuery(".contact-success").html("Your query submitted succesfully!");
					jQuery(".contact-success").fadeIn();

				}
			});
		}
	});

	winWidth = jQuery(window).width();

    // Pie Charts
    var element = jQuery('.chart');
    jQuery(element).each(function() {		
    	jQuery(this).appear(function() {
    		jQuery('.chart').easyPieChart({
    			barColor: olam_main_ajax.piecolor, 
    			trackColor: '#f5f5f5',
    			scaleColor: false,
    			lineWidth: 65,
    			lineCap: 'butt',
    			size: 130,
    			onStep: function(from, to, percent) {
    				this.el.children[0].innerHTML = Math.round(percent) + ('%');
    			}
    		});
    	});
    });

    // Quick contact window 
    quickContact();
    
    // Padding top of first section
    firstSectionPadding();

    megaMenuWidth();

    // Lightbox login
    jQuery('.login-trigger').click(function() {
    	jQuery('#loginBox').fadeIn();
    	jQuery('body').css({'overflow':'hidden'});
    })
    jQuery('.author-contact-button').click(function() {
    	jQuery('#authorContact').fadeIn();
    	jQuery('body').css({'overflow':'hidden'});
    })
    jQuery('.toggle-signup').click(function() {
    	jQuery('.signin-area, .signup-area').slideToggle();
    	jQuery(this).toggleClass('signup-active');
    });
    jQuery('.lightbox-close').click(function(){
    	jQuery('.lightbox-wrapper').fadeOut();
    	jQuery('body').css({'overflow':'auto'});
    });

    // Cart Widget
    cartWidget();

    // Progress bar Horizontal
    jQuery('.progress-bar').each(function(){
    	jQuery(this).appear(function() {
    		var $this = jQuery(this);
    		var progressWidth = $this.attr('data-width');
    		$this.delay(100).animate({'width':progressWidth + '%', }, 200);
    	});
    });
  	// Progress bar Vertical
  	jQuery('.v-progress').each(function(){
  		jQuery(this).appear(function() {
  			var $this = jQuery(this);
  			var progressWidth = $this.attr('data-height');
  			$this.delay(100).animate({'height':progressWidth + '%',}, 200);
  		});
  	});

  	// Live counter
  	jQuery('.countdown').each(function () {
  		jQuery(this).appear(function() {
  			var $this = jQuery(this);
  			jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
  				duration: 3000,
  				easing: 'swing',
  				step: function () {
  					$this.text(Math.ceil(this.Counter));
  				}
  			});
  		});
  	});

	// Scroll to top button
	wnHeight = jQuery(window).height();
	//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > wnHeight/2) {
			jQuery('.scroll-top').fadeIn();
		} else {
			jQuery('.scroll-top').fadeOut().removeClass('scrolling');
		}
	});
	
	//Click event to scroll to top
	jQuery('.scroll-top').click(function(){
		jQuery('html, body').animate({scrollTop : 0},800);
		jQuery(this).addClass('scrolling');
	});

	// Append navigation based on window width
	responsiveNav();

	jQuery('.product-search-form').find('input[type="text"]').focus(function(){
		jQuery(this).parents('.product-search-form').addClass('search-focus');
	})
	jQuery('.product-search-form').find('input[type="text"]').focusout(function(){
		jQuery(this).parents('.product-search-form').removeClass('search-focus');
	})

	jQuery('.item-options a').tooltip()

    jQuery('.item-name').each(function(){
        var nameWidth = jQuery(this).width();
        jQuery(this).animate({'width':nameWidth});
    });

    formFields();

});

function olamMiniCartSetDelay() {

	setTimeout(function () { olamMiniCartShowContents(); }, 1000);
}

function olamMiniCartShowContents() {
	jQuery('.cart-widget').load(olam_main_ajax.ajaxurl+'?action=olam_main_ajax&_wpnonce='+olam_main_ajax.nonce);
	jQuery('.olam-cart-count').load(olam_main_ajax.ajaxurl+'?action=olam_main_ajax&cart_count=1&_wpnonce='+olam_main_ajax.nonce);
}

// Function on window resize
jQuery(window).resize(function(){
	responsiveNav();
	firstSectionPadding();
	fullHeight();
	megaMenuWidth();
});

function sendMessageClick() {
	if(jQuery(".chat-preloader-file").html()) {
		var textarea = jQuery(".chat-form form textarea");
		if(!textarea.val()) {
			textarea.attr("value", " ");
		}
	}
}

jQuery(window).load(function(){
	megaMenuWidth();
	jQuery('.fes-el').each(function() {
    	if(jQuery(this).hasClass('user_pass')) {
    		jQuery(this).css({'background':'none'});
    		jQuery(this).find('.fes-label:first-child, .fes-fields:nth-child(2)').wrapAll( "<div class='field-holder'></div>" );
    		jQuery(this).find('.fes-label:nth-child(2), .fes-fields:nth-child(3)').wrapAll( "<div class='field-holder'></div>" );
	    } else {
	    	jQuery(this).addClass('field-holder');
	    }
    });
	formFields();
    // Full height sections
    // Keep the label out of the input field if value is not empty by default
    jQuery('input, textarea').each(function(){    	
    	var parent = jQuery(this).parent(); 	
    	var parents = jQuery(this).parents('.fes-el');
    	if(parent.hasClass('field-holder')){
    		jQuery(this).removeAttr('placeholder');
    		if(jQuery(this).val().length === 0) {
    			parent.removeClass('holder-focus');
    		}
    		else {
    			parent.addClass('holder-focus');
    		}
    	}
    	if(parents.hasClass('field-holder')){
    		jQuery(this).removeAttr('placeholder');
    		if(jQuery(this).val().length === 0) {
    			parents.removeClass('holder-focus');
    		}
    		else {
    			parents.addClass('holder-focus');
    		}
    	}
    })
    // Placeholder animation on focus
    jQuery('.field-holder').find('input, textarea').focus(function(){
    	jQuery(this).parent('.field-holder').addClass('holder-focus');
    	jQuery(this).parents('.field-holder').addClass('holder-focus');

    });
    // Keep the label out of the input field if value is not empty
    jQuery('.field-holder').find('input, textarea').focusout(function(){
    	if(jQuery(this).val().length === 0) {
    		jQuery(this).parent('.field-holder').removeClass('holder-focus');
    		jQuery(this).parents('.field-holder').removeClass('holder-focus');
    	}
    });

    // Keep the label out of select field
    jQuery('select').each(function(){
    	var parent = jQuery(this).parent();
    	var parents = jQuery(this).parents('.fes-el');
    	var woo_parents = jQuery(this).parents('.form-row');
    	if(parent.hasClass('field-holder')){
    		parent.addClass('holder-focus');
    		if(jQuery(this).val().length === 0) {
    			jQuery(this).parent('.field-holder').removeClass('holder-focus');
    		}
    	}
    	if(parents.hasClass('field-holder')){
    		parents.addClass('holder-focus');
    		if(jQuery(this).val().length === 0) {
    			jQuery(this).parents('.field-holder').removeClass('holder-focus');
    		}
    	}
    	if(woo_parents.hasClass('field-holder')){
    		woo_parents.addClass('holder-focus');
    		if(jQuery(this).val().length === 0) {
    			jQuery(this).parents('.field-holder').removeClass('holder-focus');
    		}
    	}
    });


    // Dynamic form 
	jQuery("body").bind("DOMNodeInserted", function() {
		formFields();
	});
	
    jQuery('.comment-form').find('textarea').attr('rows','1');

    wnHeight = jQuery(window).height();
    fullHeight();
})

wnHeight = jQuery(window).height();
headerHeight = jQuery('#header').height();
// Bootstrap js
jQuery('body.header-sticky').find('#header').affix({
	offset: {
		top: 1,
	}
});


if( (jQuery('.preloader-wrapper').length) >0){
	jQuery(window).load(function() {
		setTimeout(function(){
			jQuery('.preloader-wrapper').fadeOut();
		}, 1000);
	});
}



//Olam Popup registration form Progress Bar
jQuery(".btn-white").on("click", function() {
	var progressBtn = jQuery('.btn-pro');
	var promain = jQuery(this);
		if (!progressBtn.hasClass("active")) {
		progressBtn.addClass("active");
		setTimeout(function() {
		  progressBtn.removeClass("active");
		}, 2000);
	};
	if (!promain.hasClass("active")) {
		promain.addClass("active");
		setTimeout(function() {
		  promain.removeClass("active");
		}, 2000);
	}
});


// multi slider
jQuery('.slider-wrapper').each(function(){
   var carousel_slider = jQuery(this).find('.carousel-slider');
   var carousel_thumb = jQuery(this).find('.thumb-nav'),
   flag = false,
   duration = 300;

   var $items = carousel_slider.data('items');
   var $items_md = $items;
   var $items_sm = $items;
   var $items_xs = $items;
   var $items_md = carousel_slider.data('items-md');
   var $items_sm = carousel_slider.data('items-sm');
   var $items_xs = carousel_slider.data('items-xs');
   var $navType = carousel_slider.data('nav');
   var $navDots = carousel_slider.data('dots');
   var $navAuto = carousel_slider.data('auto');
   var $navLoop = carousel_slider.data('loop');
   carousel_slider.owlCarousel({
       autoplayTimeout:2000,
       autoplayHoverPause:true,
       singleItem:true,
       items:$items,
       autoplay:$navAuto,
       autoplay:false,
       loop: $navLoop,//owl.children().length > 1,
       dots:$navDots,
       nav: $navType,//owl.children().length > 1,
       responsive : {
           0 : {
               items: $items_xs
           },
           600 : {
               items: $items_sm
           },
           992 : {
               items: $items_md
           },
           1199 : {
               items: $items
           }
       }
   }).on('changed.owl.carousel', syncPosition)

   var $thumb_items = carousel_thumb.data('items');
   carousel_thumb.owlCarousel({
       items:$thumb_items,
       center: false,
       responsiveClass:true,
       dots:false,
       nav:false,
       afterInit : function(el){
         el.find(".owl-item").eq(0).addClass("synced");
       }
   })
   .on('click', '.owl-item', function () {
       carousel_slider.trigger('to.owl.carousel', [jQuery(this).index(), duration, true]);
   })
   .on('changed.owl.carousel', function (e) {
       if (!flag) {
           flag = true;        
           carousel_slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
           flag = false;
       }
   });
   carousel_thumb.find('.owl-item:first-child').addClass("current");
   function syncPosition(el) {
       //if you set loop to false, you have to rmuta this next line
       //var current = el.item.index;

       //if you disable loop you have to comment this block
       if (!flag) {
           flag = true;
           carousel_thumb.trigger('to.owl.carousel', [el.item.index, duration, true]);
           flag = false;
       }
       var count = el.item.count-1;
       var current = Math.round(el.item.index);
       if(current < 0){
         current = count;
       }
       if(current > count){
         current = 0;
       }
       //end block

       carousel_thumb
         .find(".owl-item")
         .removeClass("current")
         .eq(current)
         .addClass("current");
   }


   // Custom Navigation Events
   jQuery(".nav-left").click(function(){
       var carousel_slider = jQuery(this).parents('.slider-wrapper').find(".carousel-slider");
       carousel_slider.trigger('prev.owl.carousel');
   })
   jQuery(".nav-right").click(function(){
       var carousel_slider = jQuery(this).parents('.slider-wrapper').find(".carousel-slider");
       carousel_slider.trigger('next.owl.carousel');
   });
});
<?php header("Content-type: text/css; charset=utf-8"); 

$absolute_path = __FILE__;

$path_to_file = explode( 'wp-content', $absolute_path );

$path_to_wp = $path_to_file[0];

require_once( $path_to_wp . 'wp-load.php' );

$primaryColor=get_theme_mod('olam_theme_pri_color');
$secondaryColor=get_theme_mod('olam_theme_sec_color');
$headerbgcolor=get_theme_mod('olam_header_bg_color');
$menutxtColor=get_theme_mod('olam_theme_menu_text_color');
$menuText=(isset($menutxtColor) &&(strlen($menutxtColor)>0))?$menutxtColor:"inherit";
$bodySpecs=array();
$h1Specs=array();
$h2Specs=array();
$h3Specs=array();
$h4Specs=array();
$h5Specs=array();
$h6Specs=array();
$sectionHeadSpecs=array();
$pageHeadImage=olam_replace_site_url(get_theme_mod('olam_page_banner'));

// Body specs
$bodyspecscolor=get_theme_mod('olam_bodycolor'); 
$bodyspecsfont=get_theme_mod('olam_bodyfont');
$bodyspecssize=get_theme_mod('olam_bodysize');
$bodySpecs['color']=(isset($bodyspecscolor))?$bodyspecscolor:null;//
$bodySpecs['font']=(isset($bodyspecsfont))?$bodyspecsfont:null;
$bodySpecs['size']=(isset($bodyspecssize))?$bodyspecssize:null;

// Headings Font & Size
$headfont=get_theme_mod('olam_headfont');
$headcolor=get_theme_mod('olam_headcolor');
$headSpecs['font']=(isset($headfont))?$headfont:null;
$headSpecs['color']=(isset($headcolor))?$headcolor:"inherit";


// h1 specs
$h1specssize=get_theme_mod('olam_h1size');
$h2specssize=get_theme_mod('olam_h2size');
$h3specssize=get_theme_mod('olam_h3size');
$h4specssize=get_theme_mod('olam_h4size');
$h5specssize=get_theme_mod('olam_h5size');
$h6specssize=get_theme_mod('olam_h6size');

$h1Specs['size']=(isset($h1specssize))?$h1specssize:null;
// h2 specs

$h2Specs['size']=(isset($h2specssize))?$h2specssize:null;
// h3 specs

$h3Specs['size']=(isset($h3specssize))?$h3specssize:null;
// h4 specs

$h4Specs['size']=(isset($h4specssize))?$h4specssize:null;
// h5 specs
$h5Specs['size']=(isset($h5specssize))?$h5specssize:null;
// h6 specs
$h6Specs['size']=(isset($h6specssize))?$h6specssize:null;

$olamstyle=get_theme_mod('olam_theme_style');
switch ($olamstyle) {
	case 'Style 1':
		$boxShadow="box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.06)";
		$boxShadow_hover = "-webkit-transform: translateY(-8px);
			-ms-transform: translateY(-8px);
			-o-transform: translateY(-8px);
			transform: translateY(-8px);
			-webkit-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			-moz-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			-o-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);";
	break;
	case 'Style 2':
		$boxShadow="box-shadow: none;";
		$boxShadow_hover = "";
		$product_hover = "-webkit-transform: scale(1.2);
		  -ms-transform: scale(1.2);
		  -o-transform: scale(1.2);
		  transform: scale(1.2);";
	break;
	case 'Style 3':
		$boxShadow="border:1px solid #ddd;";
		$boxShadow_hover = "";
		$product_hover = "-webkit-transform: scale(1.2);
		  -ms-transform: scale(1.2);
		  -o-transform: scale(1.2);
		  transform: scale(1.2);";
	break;
	
	default:
		$boxShadow="box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.06)";
		$boxShadow_hover = "-webkit-transform: translateY(-8px);
			-ms-transform: translateY(-8px);
			-o-transform: translateY(-8px);
			transform: translateY(-8px);
			-webkit-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			-moz-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			-o-box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
			box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);";
	break;
}


        $olamdetails=get_theme_mod('olam_hide_details');
        if(isset($olamdetails)&& $olamdetails==1 ){?> .product-details .details-bottom{
        	display:none;}
        	.product-details .product-name {padding: 5px 0 5px; font-size:16px;}
        } <?php } ?>

      <?php   $olampricedetails=get_theme_mod('olam_hide_price_details');
        if(isset($olampricedetails)&& $olampricedetails==1 ){?>  .product-details .product-price, .product-details .details-bottom{
        	display:none;}
        	.product-details .product-name {padding: 5px 0 5px; font-size:16px;}
        } <?php } ?>

        


?>
/*    Theme Dynamic Styles    */
/*
Theme name : 		Olam
Author : 			layero.com
Version : 			3.1
Primary color : 	#0ad2ac
Secondary color : 	#f8fe4c
Light color : 		#eee
Body text color : 	#797979
Body font 		: 	Roboto
Heading font	: 	Montserrat 
*/

/*--------------------------------------------------------*/
/* TABLE OF CONTENTS: */
/*--------------------------------------------------------*/
/* 	01   - TYPOGRAPHY & COMMON ELEMENTS 
1.1  - Primary font 
1.2  - Secondary font 

02   - Colors 
2.1  - Primary Background 
2.2  - Primary text colors 
2.3  - Primary border colors 
2.4  - Search & Newsletter placeholder
2.5  - Primary light color
2.6  - Secondary background color
2.7  - Secondary text color
2.8  - White color
2.9  - Light color
2.10 - Social Icons
*/

/*--------------------------------------------------------*/
/* Typography - 01 */
/*--------------------------------------------------------*/

/*body{font-family: puritan,  Arial, Helvetica;
color: #FF0000;}*/
body {
	font-family:<?php if(isset($bodySpecs['font']) && (strlen($bodySpecs['font'])>0 ) && ($bodySpecs['font']!="Select a font") ){  echo esc_html($bodySpecs['font']); } ?> , Arial, Helvetica;
	<?php if(isset($bodySpecs['size']) && (strlen($bodySpecs['size'])>0)){ ?>font-size: <?php echo esc_html($bodySpecs['size']); ?>px;	<?php } ?>
	<?php if(isset($bodySpecs['color']) && (strlen($bodySpecs['color'])>0)){ ?>color: <?php echo esc_html($bodySpecs['color']); ?>;		<?php } ?>
}

	h1 {
	font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
	<?php if(isset($h1Specs['size']) && (strlen($h1Specs['size'])>0) ){ ?>font-size: <?php echo esc_html($h1Specs['size']); ?>px;	<?php } ?>
		<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0) ){ ?>color: <?php echo esc_html($headSpecs['color']); ?>; <?php } ?>
		}
		h2,
		.section-heading h2,
		.lightbox-title,
		h1.download-name,
		.boxed-heading,
		#edd_checkout_form_wrap legend,
		table.fes-login-registration td h1,
		.fes-ajax-form h1,
		#fes-profile-form-title, #fes-submission-form-title, #fes-vendor-contact-form-title,
 #fes-login-form-title, #fes-registration-form-title {
		<?php if(isset($h2Specs['size']) && (strlen($h2Specs['size'])>0)){ ?>font-size: <?php echo esc_html($h2Specs['size']); ?>px;	<?php } ?>	
			font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
			<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>;<?php } ?>	
			}
			h3,
			.middle-area .fw-tabs-container .fw-tabs ul li a,
			table.fes-login-registration > tbody > tr > td h1, 
			form.fes-ajax-form h1,
			h1.fes-headers {
			<?php if(isset($h3Specs['size']) && (strlen($h3Specs['size'])>0)){ ?>font-size: <?php echo esc_html($h3Specs['size']); ?>px; <?php } ?>	
				font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
				<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>;<?php } ?>	
				}
				h4,
				.area-heading,
				div.fes-form fieldset .fes-section-wrap h2.fes-section-title,
				#fes-vendor-dashboard h3 {
				<?php if(isset($h4Specs['size']) && (strlen($h4Specs['size'])>0)){ ?>font-size: <?php echo esc_html($h4Specs['size']); ?>px;	<?php } ?>					/* base font size */
					font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
					<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>;<?php } ?>	
					}
					h5 {
					<?php if(isset($h5Specs['size']) && (strlen($h5Specs['size'])>0)){ ?>font-size: <?php echo esc_html($h5Specs['size']); ?>px;	<?php } ?>					/* base font size */
						font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
						<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>; <?php } ?>	
						}
						h6 {
						<?php if(isset($h6Specs['size']) && (strlen($h6Specs['size'])>0)){ ?>font-size: <?php echo esc_html($h6Specs['size']); ?>px;	<?php } ?>					/* base font size */
							font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica; 
							<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>; <?php } ?>	
							}
							/*Body text color */
							.fw-pricing .fw-package .fw-heading-row {<?php if(isset($bodySpecs['color']) && (strlen($bodySpecs['color'])>0)){ ?>color: <?php echo esc_html($bodySpecs['color']); ?>;		<?php } ?>	}

							/*Title font */
							.header #nav ul,
							.product-name,
							.wrap-nivoslider .nivo-caption span strong,
							.rp-title {font-family:<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){  echo esc_html($headSpecs['font']); } ?> , Arial, Helvetica !important; }

							/*Title text color */
							.middle-area .fw-iconbox .fw-iconbox-title h3,
							.sidebar-title,
							.fw-pricing .fw-package .fw-heading-row,
							.product-name a,
							.comment-author cite .fn,
							.edd-review-meta b,
							.rp .rp-content-area .rp-title,
							.wp_comments ul li .commenter_name {
							<?php if(isset($headSpecs['color']) && (strlen($headSpecs['color'])>0)){ ?>color: <?php echo esc_html($headSpecs['color']); ?>; <?php } ?>
							}

							.wrap-nivoslider .nivo-caption span strong{
							<?php if(isset($h1Specs['size']) && (strlen($h1Specs['size'])>0) ){ ?>font-size: <?php echo esc_html($h1Specs['size']); ?>px !important;	<?php } ?>
							}

							/* -------------------------------------------------------- */
							/* Secondary font - 1.2 */

							.title-404,
							.fw-pricing .fw-package .fw-heading-row span,
							.fw-pricing .package-price {
							<?php if(isset($headSpecs['font']) && (strlen($headSpecs['font'])>0 ) && ($headSpecs['font']!="Select a font") ){ ?>font-family: <?php echo esc_html($headSpecs['font']); ?>; , Arial, Helvetica;<?php } ?>
							}


							/* -------------------------------------------------------- */
							/* Color - 02  */
							/* -------------------------------------------------------- */
							* {outline-color: <?php echo esc_html($primaryColor); ?>;}

							a, a:focus,
							.rp .rp-content-area .rp-title:hover a {color: <?php echo esc_html($primaryColor); ?>}

							.lightbox-area .lightbox {<?php if(isset($bodySpecs['size']) && (strlen($bodySpecs['size'])>0)){ ?>font-size: <?php echo esc_html($bodySpecs['size']); ?>px;	<?php } ?> } /*Body Font size*/


							/* -------------------------------------------------------- */
							/* Primary background - 2.1 */

							.btn-primary,
							#edd_sl_license_add_site_form .button-primary.button,
							a.fw-btn-primary,
							input.fw-btn-primary,
							.comment-form input[type="submit"].submit,
							#edd-reviews-review-form-submit,
							.gal-details,
							.price-box,
							.price-box-head,
							.v-progress,
							.progress-bar,
							.newsletter-form input[type="submit"],
							.mc4wp-form input[type="submit"],
							.fw_form_fw_form  input[type="submit"],
							.fw_form_fw_form  button[type="submit"],
							.email-bg:after,
							.mc4wp-form label,
							.searchform label,
							.quick-contact,
							.quick-window .input-wrap,
							.sidebar .filter-by a:hover,
							.sidebar .filter-by a.active,	
							.cart-sidebar-widget,
							.pagination ul li a:hover, 
							.pagination ul li.active a,
							#edd_download_pagination a:hover,
							#edd_download_pagination span.current,
							.cart-box,
							.blog-sidebar h6,
							.blog-sidebar .sidebar-title,
							.posts_nav a:hover, 
							.continue_reading:hover, 
							.reade_more:hover,
							.section table thead th,
							.section table.table thead th,
							.boxed, 
							#edd_checkout_user_info, 
							#edd_cc_fields, 
							#edd_cc_address, 
							#edd_purchase_submit,
							#edd_register_fields,
							#edd_checkout_login_register,
							.preview-options a.active,
							input[type="radio"]:checked + label span:after,
							.mob-nav #nav ul:after,
							.qw-title,
							.header ul.shop-nav .cw-active .cart-btn,
							.header #nav ul li .cart-btn:after,
							.header ul.shop-nav li .cart-btn:after,
							.edd_price_options label:after,
							#calendar_wrap caption,
							.tagcloud a:hover,
							#edd_checkout_form_wrap .card-expiration select.edd-select.edd-select-small option,
							.post-password-form input[type="submit"],
							.olam-post-pagination span,
							.olam-post-pagination a:hover span,
							.sidebar .cart-box input[type="radio"]:checked + label span:before, .sidebar 
							.cart-box .edd_single_mode label:before,
							.fw-btn-secondary:hover,
							.fw-btn-light:hover,
							#header #nav ul li .mega-menu > ul > li:after,
							.owl-carousel .owl-controls .owl-dot,
							.edd_download_inner:hover .item_hover,
							.edd_download_inner .item_hover .item-dt,
							.sidebar .edd-cart .edd_checkout a,
							.quote-icon,
							.package-table-price,
							a.btn-checkout:hover,
							table.fes-login-registration > tbody > tr > td,
							.post-content .fes-vendor-menu ul li a:hover,
							.post-content .fes-vendor-menu ul li.active a,
							.sweet-alert button,
							.fes-product-list-pagination-container span,
							.fes-product-list-pagination-container a:hover,
							.fes-product-list-status-bar a:hover,
							input[type=submit].fes-delete,
							button[type=submit].fes-delete,
							table#fes-comments-table .fes-cmt-submit-form, 
							table#fes-comments-table .fes-ignore,
							.banner-slider .owl-nav .owl-prev, 
							.banner-slider .owl-nav .owl-next,
							.sweet-alert button,
							.woocommerce .woocommerce-billing-fields,
							#header #nav ul li .mega-menu ul li.mega-menu-col,
							.header #nav ul li:after, 
							.header ul.shop-nav li:after, 
							.dd-cart, #fes_login_registration_form_row_left,
							#fes_login_registration_form_row_right,
							#fes-vendor-dashboard .fes-ajax-form,
							/* --- Woocommerce --- */
							.woocommerce .woocommerce-error .button:hover, 
							.woocommerce .woocommerce-info .button:hover, 
							.woocommerce .woocommerce-message .button:hover, 
							.woocommerce ul.products li.product .button:hover,
							.woocommerce a.added_to_cart:hover,
							.woocommerce #respond input#submit.alt, 
							.woocommerce a.button.alt, 
							.woocommerce button.button.alt, 
							.woocommerce input.button.alt,
							.woocommerce-billing-fields, 
							.woocommerce-shipping-fields,
							#add_payment_method #payment ul.payment_methods, 
							#add_payment_method #payment, 
							.woocommerce form.checkout_coupon, 
							.woocommerce form.login, 
							.woocommerce form.register,
							.woocommerce #respond input#submit.alt.disabled, 
							.woocommerce #respond input#submit.alt.disabled:hover, 
							.woocommerce #respond input#submit.alt:disabled, 
							.woocommerce #respond input#submit.alt:disabled:hover, 
							.woocommerce #respond input#submit.alt:disabled[disabled], 
							.woocommerce #respond input#submit.alt:disabled[disabled]:hover, 
							.woocommerce a.button.alt.disabled, 
							.woocommerce a.button.alt.disabled:hover, 
							.woocommerce a.button.alt:disabled, 
							.woocommerce a.button.alt:disabled:hover, 
							.woocommerce a.button.alt:disabled[disabled], 
							.woocommerce a.button.alt:disabled[disabled]:hover, 
							.woocommerce button.button.alt.disabled, 
							.woocommerce button.button.alt.disabled:hover, 
							.woocommerce button.button.alt:disabled, 
							.woocommerce button.button.alt:disabled:hover, 
							.woocommerce button.button.alt:disabled[disabled], 
							.woocommerce button.button.alt:disabled[disabled]:hover, 
							.woocommerce input.button.alt.disabled, 
							.woocommerce input.button.alt.disabled:hover, 
							.woocommerce input.button.alt:disabled, 
							.woocommerce input.button.alt:disabled:hover, 
							.woocommerce input.button.alt:disabled[disabled], 
							.woocommerce input.button.alt:disabled[disabled]:hover,
							.woocom-sidebar.sidebar-visible .sidebar-trigger,
							.woocom-sidebar .sidebar-trigger,
							.woocommerce a.button.checkout,
							.post-content .woocommerce-MyAccount-navigation ul li.is-active a,
							.post-content .woocommerce-MyAccount-navigation ul li a:hover,
							.lost_reset_password, 
							.edd-wl-create, 
							.edd-wl-edit, 
							.edd-wl-wish-lists .edd-wl-button, 
							.edd-slg-social-container, 
							#edd-slg-social-container-login.edd-slg-social-container,
							.modal-dialog .modal-content,
							.fc-toolbar button,
							.middle-area .fc-event,
							.wpcf7-submit,
							.edd-wl-add-all-to-cart,
							.woocommerce-additional-fields {background-color: <?php echo esc_html($primaryColor); ?>; color: #fff;}

							/* -------------------------------------------------------- */
							/* Primary text color - 2.2 */
							.primary,
							.countdown,
							.chart .percent,
							.btn-white,
							.progress-counter,
							.newsletter-form input[type="email"],
							.newsletter-form input[type="email"], 
							.quick-window input[type="submit"],
							.sidebar .demo-icons,
							.sidebar-item .categories a:hover,
							.sidebar .fa,
							.sidebar ul li a:hover,
							.pagination ul li a,
							.edd_download_inner .item-options a.cart-added,
							.scroll-top .scrollto-icon,
							.section-heading h2 span,
							.mc4wp-form,
							#footer ul.edd-cart li.edd-cart-item .edd-cart-item-price,
							#calendar_wrap tbody td a,
							a.comment-reply-link:hover,
							.icon-box .icon-holder,
							.olam-post-pagination a span,
							.sidebar .cart-box input[type="radio"]:checked + label span:before,
							.sidebar .cart-box .edd_price_options label:before,
							.cart-added,
							.middle-area .fw-accordion .fw-accordion-title.ui-state-active,
							.middle-area .fw-tabs-container .fw-tabs ul li.ui-state-active a,
							.fw-icon .fa,
							.fw-heading span,
							.page-head h1 span,
							.posted .fa,
							.preview-options a:hover,
							.empty-cart .cart-icon,
							/* --- Woocommerce --- */
							.woocommerce .woocommerce-info:before,
							.woocom-sidebar .sidebar-trigger:hover .fa {color: <?php echo esc_html($primaryColor); ?>;}

							/* -------------------------------------------------------- */
							/* Secondary Button hover - 2.7 */
							.highlight-col a.fw-btn-primary:hover,
							.fw-pricing .highlight-col .fw-button-row .fw-btn-primary:hover,
							.edd-wl-add-all-to-cart {background: <?php echo esc_html($primaryColor); ?> !important; color:#fff !important;}

							/* -------------------------------------------------------- */
							/* Primary border color - 2.3 */
							.icon,
							.edd_price_options label:after,
							.olam-post-pagination span,
							.olam-post-pagination a:hover span,
							.middle-area div.edd-bk-builder div.edd-bk-header, 
							.middle-area div.edd-bk-builder div.edd-bk-footer {border-color: <?php echo esc_html($primaryColor); ?>; }
							.header #nav ul li a.login-button:hover{border-color: #fff;}
							/*.bottom-line .date:before {border-bottom-color: <?php echo esc_html($primaryColor); ?>}*/
							.header #nav ul li span:after,
							/* --- Woocommerce --- */
							.woocommerce .woocommerce-message,
							.woocommerce .woocommerce-info, 
							.woocommerce .woocommerce-error, 
							.woocommerce .woocommerce-info, 
							.woocommerce .woocommerce-message {border-top-color: <?php echo esc_html($primaryColor); ?>;}


							/* -------------------------------------------------------- */
							/* Search & Newsletter placeholder - 2.4 */

							.product-search-form ::-webkit-input-placeholder,
							.newsletter-form ::-webkit-input-placeholder,
							.mc4wp-form ::-webkit-input-placeholder { color:inherit; font-weight: 700}
							.product-search-form :-moz-placeholder,
							.newsletter-form :-moz-placeholder,
							.mc4wp-form :-moz-placeholder { /* Firefox 18- */ color:inherit; font-weight: 700}
							.product-search-form ::-moz-placeholder,
							.newsletter-form ::-moz-placeholder,
							.mc4wp-form ::-moz-placeholder {  /* Firefox 19+ */ color:inherit;  font-weight: 700}
							.product-search-form :-ms-input-placeholder,
							.newsletter-form :-ms-input-placeholder,
							.mc4wp-form :-ms-input-placeholder {  color:inherit; font-weight: 700}


							/* -------------------------------------------------------- */
							/* Primary light color - 2.5 */
							.boxed .boxed-head {background-color: rgba(255,255,255,0.1);}
							.boxed .boxed-head:hover,
							.boxed .field-holder {background-color: rgba(0,0,0,0.1);}


							/* -------------------------------------------------------- */
							/* Secondary background color - 2.6 */

							.btn-cart,
							.btn-secondary,
							.edd-submit, #edd-purchase-button, input[type="submit"].edd-submit,
							.preview-options a.active:hover,
							.btn-white:hover,
							.edd-submit:visited, 
							.edd-submit:focus,
							.edd-submit:hover,
							.sidebar-item .fes-vendor-contact-form div.fes-form .fes-submit input[type=submit]:hover,
							.fw-pricing .fw-button-row .fw-btn:hover,
							.edd_checkout a,
							#footer .edd_checkout a,
							.sidebar-item .mc4wp-form input[type="submit"],
							.comments-nav a,
							.fw-btn-secondary,
							.header ul.shop-nav .cart-widget .dd-cart .buttons a:hover,
							.owl-carousel .owl-controls .owl-dot.active,
							.fw_form_fw_form  input[type="submit"]:hover,
							.fw_form_fw_form  button[type="submit"]:hover,
							.comment-form input[type="submit"].submit:hover,
							#edd-reviews-review-form-submit:hover,
							.sidebar .edd-cart .edd_checkout a:hover,
							.highlight-col a.fw-btn-primary,
							a.btn-checkout,
							div.featured-badge,
							.wrapper div.fes-form .fes-submit input[type=submit],
							.wrapper div.fes-form .fes-submit input[type=submit]:focus,
							input[type=submit].fes-delete:hover,
							button[type=submit].fes-delete:hover,
							table#fes-comments-table .fes-cmt-submit-form:hover, 
							table#fes-comments-table .fes-ignore:hover,
							.fes-light-red,
							#edd_user_commissions_unpaid_total:after,
							#edd_user_commissions_paid_total:after,
							#edd_user_commissions_revoked_total:after,
							.boxed div.fes-form .fes-submit input[type=submit]:hover,
							#edd-reviews-vendor-feedback-form-submit,
							/* --- Woocommerce --- */
							.woocommerce .woocommerce-error .button, 
							.woocommerce .woocommerce-info .button, 
							.woocommerce .woocommerce-message .button, 
							.woocommerce #respond input#submit, 
							.woocommerce a.button, 
							.woocommerce button.button, 
							.woocommerce input.button,
							.woocommerce a.added_to_cart,
							.woocommerce #respond input#submit.alt:hover, 
							.woocommerce a.button.alt:hover, 
							.woocommerce button.button.alt:hover, 
							.woocommerce input.button.alt:hover, 
							.woocommerce-password-strength.bad, 
							.woocommerce-password-strength.good,
							p.demo_store,
							.woocommerce span.onsale,
							.woocom-sidebar .sidebar-trigger:hover,
							.edd-fd-button,
							.middle-area div.edd-bk-builder div.edd-bk-footer div.edd-bk-col-add-rule .button,
							.middle-area .fc-toolbar button:hover,
							.wpcf7-submit:hover {background: <?php echo esc_html($secondaryColor); ?>; color: #444;}

							.middle-area div.fes-form .fes-submit .button-primary-disabled,
							.middle-area .edd-bk-datepicker-skin td.ui-datepicker-today a.ui-state-active, 
							.middle-area .edd-bk-datepicker-skin td.ui-datepicker-today a.ui-state-hover, 
							.middle-area .edd-bk-datepicker-skin td.ui-datepicker-today.ui-state-highlight a,
							.middle-area .edd-bk-datepicker-skin td .ui-state-active, 
							.middle-area .edd-bk-datepicker-skin td.ui-state-highlight, 
							.middle-area .edd-bk-datepicker-skin td.ui-state-highlight a, 
							.middle-area .edd-bk-datepicker-skin td.ui-state-disabled.ui-state-highlight span, 
							.middle-area .edd-bk-datepicker-skin td.ui-datepicker-unselectable.ui-state-highlight span, 
							.middle-area .edd-bk-datepicker-skin td .ui-state-hover {background: <?php echo esc_html($secondaryColor); ?> !important; color: #444 !important; border: none !important;}

							.scroll-top .flame {border-top-color: <?php echo esc_html($secondaryColor); ?>;}
							.fw-btn-1:hover, 
							.fw-btn-1:focus,
							.btn-primary:hover,
							.btn-primary:focus,
							.btn-primary:active,
							a.fw-btn-primary:hover,
							input.fw-btn-primary:hover,
							.boxed .boxed-body input[type="submit"],
							.highlight-col .package-table-price,
							.fes-fields .fes-feat-image-upload a.fes-feat-image-btn:hover,
							.fes-fields .fes-avatar-image-upload a.fes-avatar-image-btn:hover, .edd-wl-create input[type='submit'], .edd-wl-edit input[type='submit'], .edd-wish-list li span.edd-wl-item-purchase .edd-wl-action, .edd_errors:not(.edd-alert), a.edd-wl-action.edd-wl-button:hover{background: <?php echo esc_html($secondaryColor); ?> !important; color:#444 !important;}


							/* -------------------------------------------------------- */
							/* Secondary text color - 2.7 */

							.edd_download_inner:hover .item-bottom a:hover,
							#footer h5 span,
							.sidebar ul.milestones li .rated span.fa,
							.product-search h1 span,
							.product-search-bottom,
							.gal-item-options a:hover,
							.gal-item:hover .cart-added,
							.edd_download_inner:hover .item-options a.cart-added,
							.sticky .posted .featured .fa,
							.dashicons-star-filled:before,
							a:hover,
							/* --- Woocommerce --- */
							.woocommerce .star-rating,
							.woocom-sidebar.sidebar-visible .sidebar-trigger .fa,
							.woocom-sidebar .sidebar-trigger .fa,
							.wrap-nivoslider .nivo-caption span strong span {color: <?php echo esc_html($secondaryColor); ?>;}


							/* -------------------------------------------------------- */
							/* White color - 2.8 */

							.header ul.shop-nav a.login-button:hover,
							.header ul.shop-nav .cw-active .cart-btn,
							#edd_checkout_user_info h1, #edd_checkout_user_info h2, #edd_checkout_user_info h3, #edd_checkout_user_info h4, #edd_checkout_user_info h5, #edd_checkout_user_info h6,
							#edd_cc_fields h1, #edd_cc_fields h2, #edd_cc_fields h3, #edd_cc_fields h4, #edd_cc_fields h5, #edd_cc_fields h6, 
							#edd_cc_address h1, #edd_cc_address h2, #edd_cc_address h3, #edd_cc_address h4, #edd_cc_address h5, #edd_cc_address h6, 
							#edd_purchase_submit h1, #edd_purchase_submit h2, #edd_purchase_submit h3, #edd_purchase_submit h4, #edd_purchase_submit h5, #edd_purchase_submit h6, 
							#edd_register_fields h1, #edd_register_fields h2, #edd_register_fields h3, #edd_register_fields h4, #edd_register_fields h5, #edd_register_fields h6, 
							#edd_checkout_login_register h1, #edd_checkout_login_register h2, #edd_checkout_login_register h3, #edd_checkout_login_register h4, #edd_checkout_login_register h5, #edd_checkout_login_register h6, 
							.dd-cart h1, .dd-cart h2, .dd-cart h3, .dd-cart h4, .dd-cart h5, .dd-cart h6,
							table.fes-login-registration > tbody > tr > td h1, 
							form.fes-ajax-form h1 {color: #fff;}
							.olam-post-pagination a span,
							.sidebar .cart-box input[type="radio"]:checked + label span:after, .sidebar .cart-box .edd_price_options label:after,
							.cart-box .edd-submit:hover,
							.sidebar ul.edd-cart  li.edd_checkout a:hover,
							.edd-cart-saving-button,
							#edd_purchase_submit input[type="submit"]:hover,
							#edd_login_fields input[type="submit"]:hover {background: #fff;}
							.sidebar .cart-box input[type="radio"]:checked + label span:after, .sidebar .cart-box .edd_price_options label:after {border-color: #fff;}

							/* -------------------------------------------------------- */
							/* Light color - 2.9 */

							.blog-sidebar ul,
							.posts_nav a, 
							.continue_reading, 
							.reade_more,
							.section table tbody td,
							.section table tbody th,
							.section table tfoot th,
							.item-details,
							.preview-area,
							input[type="radio"] + label span:before,
							.fw-btn-light,
							.blog-sidebar .textwidget,
							.blog-sidebar .tagcloud,
							.comment-form,
							.edd-fd-button:hover {background-color: #fff;}

							.page-top,
							#footer,
							.edd-cart-saving-button:hover {background-color:#1c2326;}
							.page-top,
							.edd-cart-saving-button:hover,
							.modal-content h2 {color:#fff;}
							div.fes-form fieldset .fes-section-wrap h2.fes-section-title {color: inherit;}


							/* -------------------------------------------------------- */
							/* Social Icons - 2.10 */
							.sidebar-item .social-facebook .icon,
							.sidebar-item .social-twitter .icon,
							.sidebar-item .social-linkedin .icon,
							.sidebar-item .social-youtube .icon,
							.sidebar-item .social-google .icon,
							.sidebar-item .social-pinterest .icon,
							.icon {color: #9b9b9b}
							#footer .social-icons a .icon {border: none; color:#3e5860;}

							.sidebar-item .social-facebook .icon:hover,
							.social-facebook .icon:hover,
							.social-icons .icon-facebook:hover,
							#footer .social-facebook .icon:hover {border-color: #3765a3; color: #3765a3}
							.social-twitter .icon:hover,
							.sidebar-item .social-twitter .icon:hover,
							.social-icons .icon-twitter:hover,
							#footer .social-twitter .icon:hover {border-color: #2caae1; color: #2caae1;}
							.social-linkedin .icon:hover,
							.sidebar-item .social-linkedin .icon:hover,
							.social-icons .icon-linkedin:hover,
							#footer .social-linkedin .icon:hover {border-color: #48a0cb; color: #48a0cb;}
							.social-youtube .icon:hover,
							.sidebar-item .social-youtube .icon:hover,
							.social-icons .icon-youtube:hover,
							#footer .social-youtube .icon:hover {border-color: #dd4f43; color: #dd4f43;}
							.social-google .icon:hover,
							.sidebar-item .social-google .icon:hover,
							.social-icons .icon-gplus:hover,
							#footer .social-google .icon:hover {border-color: #dd4f43; color: #dd4f43;}
							.social-pinterest .icon:hover,
							.sidebar-item .social-pinterest .icon:hover,
							.social-icons .icon-pinterest:hover,
							#footer .social-pinterest .icon:hover {color: #e55353; border-color: #e55353;}
							#footer .social-instagram .icon:hover {color:#b41184;border-color: #b41184;}


							/* -------------------------------------------------------- */
							/* Body text color */
							.edd_download_inner .item-posted,
							.edd_download_inner:hover .item-posted {<?php if(isset($bodySpecs['color']) && (strlen($bodySpecs['color'])>0)){ ?>color: <?php echo esc_html($bodySpecs['color']); ?>;		<?php } ?>}

							/* -------------------------------------------------------- */
							/* Box shadow */
							.edd_download_inner,
							#edd_checkout_cart,
							.gal-item,
							.team-item,
							.fw-pricing .fw-package,
							.paper,
							.testimonial-item,
							.sidebar,
							article.post,
							article.download,
							article.page,
							article.hentry,
							.fes-fields .fes-feat-image-upload a.fes-feat-image-btn,
							.post-content .fes-vendor-menu ul li a,
							.preview-options a,
							#edd_user_commissions_revoked_total,
							#edd_commissions_export,
							.bx-wrapper .bx-viewport,
							.middle-area div.edd-bk-service-container,
							.middle-area .edd-bk-service-session-picker,
							#edd-rp-single-wrapper, #edd-rp-checkout-wrapper,
							.edd-wl-wish-lists, ul.edd-wish-list,
							.rp,
							.blog-sidebar .sidebar-item,
							.edd-reviews-vendor-feedback-item,
							table#edd_purchase_receipt_products, table#edd_purchase_receipt,
							/* --- Woocommerce --- */
							.woocommerce-message,
							.woocommerce ul.products li.product .product-item, 
							.woocommerce-page ul.products li.product .product-item,
							.woocommerce div.product,
							.woocommerce table.shop_table, 
							.woocommerce-billing-fields,
							.woocommerce-shipping-fields,
							.woocommerce-checkout-payment,
							.woocommerce-info,
							.post-content .woocommerce-MyAccount-navigation ul li a {<?php echo $boxShadow; ?>}

							.edd_download_inner:hover,
							.gal-item:hover,
							.team-item:hover,
							.fw-pricing .fw-package:hover,
							.edd_download_inner:hover,
							.gal-item:hover,
							.rp:hover,
							/* --- Woocommerce --- */
							.woocommerce ul.products li.product .product-item:hover, 
							.woocommerce-page ul.products li.product .product-item:hover {
								<?php echo $boxShadow_hover; ?>
							}
							.edd_download_inner:hover .thumb a img,
							.woocommerce ul.products li.product:hover a img {<?php echo $product_hover; ?>}
						.quote-icon,
						.post-content .fes-vendor-menu ul li a:hover,
						.post-content .fes-vendor-menu ul li.active a,
						.post-content .woocommerce-MyAccount-navigation ul li a:hover,
						.post-content .woocommerce-MyAccount-navigation ul li.is-active a {
						-webkit-box-shadow: 2px 2px 20px rgba(0,0,0,0.3);
						box-shadow: 2px 2px 20px rgba(0,0,0,0.3);
					}
					/* -------------------------------------------------------- */
							/* Header Background color - 2.11 */

					.header-wrapper,
					.header-sticky .affix,
					.home.header-sticky .affix {background-color: <?php echo esc_html($headerbgcolor); ?>; }

					.header-wrapper.header-bg, .header-sticky .affix, .header.navbar-fixed-top.affix-top {background-image:url('<?php echo esc_url($pageHeadImage);?>'); background-size: cover;}
					.header-wrapper.header-bg.header-transparent-overlay, .header-transparent-overlay .header.navbar-fixed-top.affix-top{background:transparent;}

					/* 	===========================================================
					Responsive 
					======================================================== */
					@media (max-width:767px){
					h1 {font-size: 2.25em; }
					.product-search h1{font-size:36px;}
					h1.download-name {font-size: 2.14em; }
					h2 {font-size: 2.14em; }
					h3 {font-size: 1.5em; line-height: 1.8rem; }
					h4 {font-size: 1.427em; line-height: 1.8rem; }
					h5 {font-size: 1em; font-weight: 700; line-height: 1.8rem;}
				}
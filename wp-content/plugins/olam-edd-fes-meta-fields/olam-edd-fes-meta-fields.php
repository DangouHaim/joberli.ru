<?php
/*
Plugin Name: Olam Easy Digital Downloads FES Meta fields
Plugin URI: http://layero.com
Description: Additional meta fields for Olam WordPress theme for FES EDD extension
Author: Olam
Version: 1.0.0
*/


add_action( 'plugins_loaded', 'olam_fes_load_plugin_textdomain' );

function olam_fes_load_plugin_textdomain() {
	load_plugin_textdomain( 'olam-edd-fes-meta-fields', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

// plugin folder path
if ( ! defined( 'EDD_FES_PLUGIN_DIR' ) ) {
	define( 'EDD_FES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

add_action( 'fes_load_fields_require', 'olam_edd_add_fes_functionality' );
function olam_edd_add_fes_functionality(){ 
	if ( class_exists( 'EDD_Front_End_Submissions' ) ){
		if ( version_compare( fes_plugin_version, '2.3', '>=' ) ) { 
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-preview-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-download-item-thumbnail.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-download-item-square-img.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-download-item-audio.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-download-item-video.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-subheading.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-fb-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-youtube-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-linkedin-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-gplus-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-twitter-url.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-title.php');
			include_once( EDD_FES_PLUGIN_DIR . 'includes/olam-author-subtitle.php');
			add_filter(  'fes_load_fields_array', 'olam_fes_add_meta_fields', 10, 1 );
			function olam_fes_add_meta_fields( $fields ){

				$fields['preview_url'] = 'Olam_Preview_Url';
				$fields['download_item_thumbnail_id'] = 'Olam_Download_Item_Thumbnail';
				$fields['download_item_square_img_id'] = 'Olam_Download_Item_Square_Img';
				$fields['download_item_audio_id'] = 'Olam_Download_Item_Audio';
				$fields['download_item_video_id'] = 'Olam_Download_Item_Video';
				$fields['subheading'] = 'Olam_Subheading_Meta';
				$fields['author_fb_url'] = 'Olam_Author_Fb_Url';
				$fields['author_twitter_url'] = 'Olam_Author_Twitter_Url';
				$fields['author_gplus_url'] = 'Olam_Author_Gplus_Url';
				$fields['author_linkedin_url'] = 'Olam_Author_Linkedin_Url';
				$fields['author_youtube_url'] = 'Olam_Author_Youtube_Url';
				$fields['author_page_subtitle'] = 'Olam_Author_Subtitle';
				$fields['author_page_title'] = 'Olam_Author_Title';
				return $fields;
				
			}
		}
	}
}


// exclude from submission form in admin

add_filter( 'fes_templates_to_exclude_render_submission_form_admin',  'olam_fes_exclude_field_pp' ,10, 1  );


function olam_fes_exclude_field_pp( $fields ) {
	array_push( $fields, 'preview_url' );
	array_push( $fields, 'download_item_thumbnail_id' );
	array_push( $fields, 'download_item_square_img_id' );
	array_push( $fields, 'download_item_video_id' );
	array_push( $fields, 'download_item_audio_id' );
	array_push( $fields, 'subheading' );
	return $fields;
}


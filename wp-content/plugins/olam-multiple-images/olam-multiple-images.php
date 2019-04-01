<?php
/**
 * @package Olam multiple image
 * @version 1.2
 */
/*
Plugin Name: Olam Multiple Image
Plugin URI:  http://layero.com
Description: Olam multiple image is a plugin that provides the option for adding images to post in wordpress.
Version: 1.2
Author:      Layero
Author URI:  http://layero.com
*/

require_once("class-multi-images.php");

add_action( 'add_meta_boxes', 'olam_multiple_images_meta_box_add' );

function olam_multiple_images_meta_box_add()
{
 
	add_meta_box( 'olam-post-images', esc_html__( 'Download Gallery', 'olam' ), 'Olam_Post_Images::output', 'download', 'side', 'low' );
}

  function olam_multiple_images_admin_script_enqueue() {
    wp_enqueue_style( 'olam-admin-css', plugins_url( '/css/olam_multiple_images.css', __FILE__ ));
    wp_enqueue_script('olam-admin-scripts', plugin_dir_url( __FILE__ ) .'js/multi-images.js',array('jquery','jquery-ui-sortable'),'', true);
  }

  add_action( 'admin_enqueue_scripts', 'olam_multiple_images_admin_script_enqueue' );

add_action( 'save_post',  'Olam_Post_Images::save' ); 
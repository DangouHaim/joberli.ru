<?php
/**
 * The Template for displaying search results.
 *
 * @package Olam
 */
  get_header(); ?>

<?php 
if(get_query_var('post_type')=="download"){
	
	get_template_part("search",get_query_var('post_type')); 
}
else{
	get_template_part("archive"); 	
} ?>

<?php get_footer(); ?>
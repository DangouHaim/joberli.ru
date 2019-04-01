<?php
/**
 * The template for displaying Author Archive.
 *
 * @package Olam
 */

get_header(); ?>
<div class="section">
	<div class="container">
        <?php            
        if(!isset($_GET['author_downloads'])) { ?>
        <div class="page-head">
            <h1> 
                <?php echo get_the_author(); ?>
            </h1>
        </div>
        <?php  } ?>
                <?php
                if(isset($_GET['author_downloads']) && $_GET['author_downloads']=='true') {
                  get_template_part('includes/author-downloads'); 
              }else{ 
                ?>
                <div class="row">
                    <?php get_template_part('includes/author-default'); ?>
                </div>
                <?php	} ?>
            </div>
        </div>
        <?php get_footer(); ?>
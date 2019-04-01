<?php
/**
 * The template for displaying Archives.
 *
 * @package Olam
 */

get_header(); ?>

<div class="section">
  <div class="container">   
    <div class="page-head">
     <div class="fw-container">
      <h1><?php       if ( is_category() ) {
        echo single_cat_title( '', false );
        $catDesc=category_description();
      }
      elseif ( is_tag() ){
        echo single_tag_title( '', false );
        $catDesc=tag_description();
      }

      elseif ( is_day() ) {
        esc_html_e( 'Daily Archives: ', 'olam' ); echo get_the_date() ;
      }

      elseif ( is_month() ) {
       esc_html_e( 'Monthly Archives: ', 'olam' ); echo get_the_date( 'F Y' );
     }

     elseif ( is_year() ) {
      esc_html_e( 'Yearly Archives: ', 'olam' ); echo get_the_date( 'Y' );
    }

    elseif ( is_search() ) {
      esc_html_e( 'Search Results: ', 'olam' ); echo get_search_query();
    }

    else {
     esc_html_e( 'Archives', 'olam' );
   }

   ?></h1>
   <?php if((isset($catDesc))&& (strlen($catDesc)>0) ){ ?><div class="page_subtitle"> <?php echo wp_kses($catDesc,array('p'=>array())); ?></div> <?php } ?>
 </div>
</div>
<div class="row">
  <?php 
  $sideBarFlag=0;
  $downloadColumn=12;
  ?>
  <?php  
  if ( is_active_sidebar( 'olam-blog-page-sidebar' )){ 
   $downloadColumn=9;
   $sideBarFlag=1;
 }
 ?>
 <div class="col-md-<?php echo esc_attr($downloadColumn); ?>">
  <div class="posts-wrapper">
    <?php if ( have_posts() ) : ?>
    <?php /* The loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="post-item">
        <div class="featured-badge"><span><i class="fa fa-check-circle-o"></i></span></div>
        <div class="post-head">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <div class="posted">
            <div class="posted-item"><?php the_time(get_option('date_format')); ?><span class="separator">|</span></div>
            <div class="posted-item"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a><span class="separator">|</span></div>
            <div class="posted-item"><div class="post-single-categories"><?php the_category(); ?> </div></div>
        </div>
        <div class="post-thumbnail">
          <?php 
          if ( has_post_thumbnail() ) { 
            the_post_thumbnail();  
          } 
          ?>
        </div>
        <div class="post-content">
          <?php the_excerpt(); ?>
        </div>
      </div>
    </article>
  <?php endwhile; ?>
<?php else : ?>
  <?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
</div>
  <?php
  if (function_exists("olam_pagination")) {
    olam_pagination();
  }
  ?>
</div>
<?php if($sideBarFlag==1){ ?>
<div class="col-md-3">
  <div class="sidebar blog-sidebar">
   <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('olam-blog-page-sidebar') ) : else : ?>        
 <?php endif; ?> 
</div>
<?php } ?>
</div>
</div>
</div>
</div>

<?php get_footer(); ?>
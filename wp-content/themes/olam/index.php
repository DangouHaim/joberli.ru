<?php
/**
 * The main template file.
 *
 *
 * @package Olam
 */
get_header(); ?>
<div class="section">
    <div class="container">   
        <div class="page-head">
         <h1><?php
         $posts_page_id = get_option('page_for_posts'); 
         $altTitle=olam_get_page_option($posts_page_id,"olam_page_alttitle"); 
         if(isset($altTitle) && (strlen($altTitle)>0 ) ) { 
           echo wp_kses($altTitle,array('span'=>array('class'=>array()))); 

       } 
       else{
           echo wp_kses(get_the_title($posts_page_id),array('span'=>array('class'=>array())));           
       }
       ?></h1>
       <?php
       $pageSubs=olam_get_page_option($posts_page_id,"olam_page_subtitle"); 
       if(isset($pageSubs) && (strlen($pageSubs)>0 )) { ?>
       <div class="page_subtitle"> <?php  echo esc_html($pageSubs); ?></div>
       <?php  } ?>
   </div>
   <div class="row">
    <?php 
    $downloadColumn=12;
    $sideFlag=0;
    ?>
    <?php  
    if ( is_active_sidebar( 'olam-blog-page-sidebar' )){
        $downloadColumn=9;
        $sideFlag=1;
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
                    
                    <div class="post-thumbnail">
                        <?php 
                        if ( has_post_thumbnail() ) { 
                            the_post_thumbnail();  
                        } 
                        ?>
                    </div>
                    <div class="post-head">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div>
                    <div class="posted">
                        <div class="posted-item"><?php the_time(get_option('date_format')); ?> <span class="separator">|</span> </div>
                        <div class="posted-item"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a><span class="separator">|</span></div>
                        <div class="posted-item"><div class="post-single-categories"><?php the_category(); ?> </div></div>
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
<?php if($sideFlag==1){ ?>
<div class="col-md-3">
   <div class="sidebar blog-sidebar">
       <?php dynamic_sidebar( 'olam-blog-page-sidebar' ); ?>
   </div>
</div>
<?php } ?>
</div>
</div>
</div>
<?php get_footer(); ?>
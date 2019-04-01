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
                    <?php the_time(get_option('date_format')); ?><span class="separator">|</span>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a><span class="separator">|</span>
                    <div class="post-single-categories"><?php the_category(); ?> </div>
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
</div>
<?php } ?>
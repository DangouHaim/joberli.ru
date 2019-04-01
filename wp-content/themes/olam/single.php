<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Olam
 */

get_header(); ?>

<div class="section">
    <div class="container">   
        <?php if ( have_posts() ) : ?>
        <?php /* The loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="page-head">
            <h1>
                <?php 
                $altTitle=olam_get_page_option(get_the_ID(),"olam_post_alttitle"); 
                if(isset($altTitle) && (strlen($altTitle)>0 ) ) { 
                  echo wp_kses($altTitle,array('span'=>array('class'=>array()))); 
                } else{
                    the_title(); 
                }  
                ?> 
            </h1>
            <div class="blog_page_subtitle">
                <span><?php the_date(get_option('date_format')); ?></span><span class="separator">|</span>
                <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
                <!-- <span><i class="fa fa-folder-open"></i> <span class="post-single-categories"> </span></span> -->
            </div>
        </div>
        <div class="row">
            <?php 
            $sideBarFlag=0;
            $columnWidth=12;
            if ( is_active_sidebar( 'olam-blog-page-sidebar' )){ 
                $sideBarFlag=1;
                $columnWidth=9;
            }
            ?>
            <div class="col-md-<?php echo esc_attr($columnWidth); ?>">
                <div class="paper single-post">
                 <?php $sticky=(is_sticky())?"sticky":null; ?>
                 <div id="post-<?php the_ID(); ?>" <?php post_class($sticky); ?>>
                    <div class="featured-badge"><span><i class="fa fa-check-circle-o"></i></span></div>
                    <div class="post-item">
                        <div class="post-content">
                            <?php if ( has_post_thumbnail() ) { ?> 
                                <div class="olam-post-featured-image"><?php the_post_thumbnail();  ?></div>
                            <?php } ?>
                            <?php the_content(); ?>
                            <?php 
                            wp_link_pages( array(
                                "before"=>"<div class='olam-post-pagination'>",
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                ) );?>
                                <div class="post-cats-tags">
                                    <div class="post-cats"><?php esc_html_e("Categories:","olam");?>  <?php the_category(', '); ?></div>
                                    <div class="post-tags"><?php the_tags(); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="posts_nav">
                        <span><a href="<?php echo get_permalink(get_adjacent_post(false,'',false)); ?>"><i class="demo-icons icon-left"></i><?php esc_html_e("Previous post","olam"); ?></a></span>
                        <span class="text-right"><a href="<?php echo get_permalink(get_adjacent_post(false,'',true)); ?>"><?php esc_html_e("Next post","olam"); ?> <i class="demo-icons icon-right"></i></a></span>
                    </div>

                    <div class="wp_comments comment-list">
                        <?php comments_template( '', true ); ?>
                    </div>
                    
                </div>
            </div>
            <?php if($sideBarFlag==1){  ?>
            <div class="col-md-3">
                <div class="sidebar blog-sidebar">
                 <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('olam-blog-page-sidebar') ) : else : ?>        
             <?php endif; ?> 
         </div>
     </div>
     <?php } ?>
 </div>
<?php endwhile; ?>
<?php olam_pagination(); ?>
<?php else : ?>
    <?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
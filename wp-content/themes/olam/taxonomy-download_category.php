<?php
/**
 * The template for displaying the download categories.
 * @package Olam
 */
get_header(); ?>

<div class="section">
    <div class="container">
        <div class="row">
            <?php $downloadColumn=12; ?>
            <?php  if ( is_active_sidebar( 'olam-download-category-sidebar' )){
                $downloadColumn=9;
                ?>
                <div class="col-md-3">
                 <div class="sidebar">
                     <?php dynamic_sidebar( 'olam-download-category-sidebar' ); ?>
                 </div>
             </div>
             <?php } ?>  
             <div class="col-md-<?php echo esc_attr($downloadColumn); ?>">
                <?php   echo category_description();  ?>
                  <?php 
                  $term=get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
                  $paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1; 
                   $posts_per_page_olam=get_theme_mod('olam_product_count');
                  if ( ! isset( $wp_query->query['orderby'] ) ) { 
                    $args = array( 
                       'orderby' => 'date', 
                       'order' => 'DESC', 
                       'post_type' => 'download', 
                       'posts_per_page'=>$posts_per_page_olam,
                       'download_category'=>$term->slug, 
                       'paged' => $paged ); 
                } else { 
                    switch ($wp_query->query['orderby']) { 
                        case 'date': 
                        $args = array( 
                            'orderby' => 'date', 
                            'order' => 'DESC', 
                            'post_type' => 'download',
                            'posts_per_page'=>$posts_per_page_olam,
                            'download_category'=>$term->slug,  
                            'paged' => $paged ); 
                        break; 
                        case 'sales': 
                        $args = array( 
                            'meta_key'=>'_edd_download_sales', 
                            'order' => 'DESC', 
                            'orderby' => 'meta_value_num',
                            'posts_per_page'=>$posts_per_page_olam,
                            'download_category'=>$term->slug,  
                            'post_type' => 'download', 
                            'paged' => $paged ); 
                        break; 
                        case 'price': 
                        $args = array( 
                            'meta_key'=>'edd_price', 
                            'order' => 'ASC', 
                            'orderby' => 'meta_value_num',
                            'posts_per_page'=>$posts_per_page_olam,
                            'download_category'=>$term->slug,  
                            'post_type' => 'download', 
                            'paged' => $paged ); 
                        break; 
                    } } 
                      $temp = $wp_query; $wp_query = null; 
                      $wp_query = new WP_Query(); $wp_query->query($args); while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                      <?php get_template_part('includes/loop-shop-listings'); ?>
                <?php endwhile; ?>
            <div class="pagination">
                <?php
                if (function_exists("olam_pagination")) {
                    olam_pagination();
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>

<?php get_footer(); ?>
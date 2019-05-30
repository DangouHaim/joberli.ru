<?php
/**
 * The template for displaying download archive.
 *
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
       <div class="col-md-<?php echo esc_html($downloadColumn); ?>">
        <div class="row">
         <?php   
         $term=get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
         $termSlug=(isset($term->slug))?$term->slug:null;
         $searchTerm= (strlen(get_search_query() ) >0 )?get_search_query():null;
         $paged=( get_query_var( 'paged')) ? get_query_var( 'paged') : 1; 
         if ( ! isset( $wp_query->query['orderby'] ) ) { 
          $args = array( 
            'order' => 'ASC', 
            'post_type' => 'download', 
            'download_category'=>$termSlug, 
            's' =>$searchTerm,              
            'paged' => $paged ); 
        } else { 
          switch ($wp_query->query['orderby']) { 
            case 'date': 
            $args = array( 
              'orderby' => 'date', 
              'order' => 'DESC', 
              'post_type' => 'download',
              'download_category'=>$termSlug,
              's' =>$searchTerm,   
              'paged' => $paged ); 
            break; 
            case 'sales': 
            $args = array( 
              'meta_key'=>'_edd_download_sales', 
              'order' => 'DESC', 
              'orderby' => 'meta_value_num',
              'download_category'=>$termSlug,  
              's' =>$searchTerm, 
              'post_type' => 'download', 
              'paged' => $paged ); 
            break; 
            case 'price': 
            $args = array( 
              'meta_key'=>'edd_price', 
              'order' => 'ASC', 
              'orderby' => 'meta_value_num',
              'download_category'=>$termSlug,  
              'post_type' => 'download', 
              's' =>$searchTerm, 
              'paged' => $paged ); 
            break; 
          } } 
          $temp = $wp_query; $wp_query = null; 
          $wp_query = new WP_Query(); $wp_query->query($args); ?>
          <?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

           <?php
           $eddColumn=get_theme_mod('olam_edd_columns');
           switch ($eddColumn) {
            case '2 columns':
            $colsize=6;
            $division=2;
            $colclass="col-sm-6";
            break;
            case '3 columns':
            $colsize=4;
            $division=3;
            $colclass=null;
            break;
            case '4 columns':
            $colsize=3;
            $division=4;
            $colclass="col-sm-6";
            break;
            default:
            $colclass=null;
            break;
          }
          if(($wp_query->current_post)%($division)==0){ echo "<div class='row'>"; } ?>
          <div class="col-md-<?php echo $colsize; ?> <?php echo $colclass; ?>">
            <div class="edd_download_inner">
              <div class="thumb">
                <?php $videoCode=get_post_meta(get_the_ID(),"download_item_video_id");
                $audioCode=get_post_meta(get_the_ID(),"download_item_audio_id");
                if(isset($videoCode[0]) && (strlen($videoCode[0])>0) ){
                  // if(is_numeric($videoCode[0])){
                  //     $videoUrl=wp_get_attachment_url($videoCode[0]);
                  // }
                  // else{
                       $videoUrl=$videoCode[0];                           
                  // }
                  //$videoUrl=wp_get_attachment_url($videoCode[0]);
                  ?>
                  <div class="media-thumb">
                    <?php echo do_shortcode("[video src='".esc_url($videoUrl)."']"); ?>
                  </div> <?php
                }
                else if(isset($audioCode[0]) && (strlen($audioCode[0])>0) ){ 
                  $audioUrl=wp_get_attachment_url($audioCode[0]);
                  ?>
                  <div class="media-thumb">
                    <?php echo do_shortcode("[audio src='".$audioUrl."']"); ?>
                  </div> <?php
                } ?>
                <a href="<?php the_permalink(); ?>"><span><i class="demo-icons icon-link"></i></span>
                  <?php $square_img = get_post_meta(get_the_ID(),"download_item_square_img");
                  if (!empty($square_img) && strlen($square_img[0])>0) {
                    echo '<img src="' . esc_url($square_img[0]) .'" />';
                  }
                  elseif ( has_post_thumbnail() ) {
                    the_post_thumbnail('olam-product-thumb');
                  }
                  else {
                    echo '<img src="' . get_template_directory_uri(). '/img/thumbnail-default.jpg" />';
                  }
                  ?>
                </a>
              </div>
              
              <div class="product-details">
                <div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="product-price"><?php edd_price(get_the_ID()); ?></div>
                <?php if ( has_excerpt() ) : // Only show custom excerpts not autoexcerpts ?>
                  <p class="olam-custom-excerpt"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                <div class="details-bottom">
                  <div class="product-options"> 
                    <a href="<?php the_permalink(); ?>" title="<?php esc_html_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>                                            
                    <a href="<?php echo esc_url(add_query_arg(array('edd_action'=>'add_to_cart','download_id'=>$post->ID),edd_get_checkout_uri())); ?>" title="<?php esc_html_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
                    <?php if(!olam_check_if_added_to_cart(get_the_ID())){
                      $eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
                      $addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Добавить в корзину","olam");
                      ?>
                      <a href="<?php echo esc_url(add_query_arg(array('edd_action'=>'add_to_cart','download_id'=>$post->ID),olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?> "><i class="demo-icons icon-cart"></i></a>                                    
                      <?php } else { ?>
                      <a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_html_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
                      <?php } ?>
                    </div>
                    <div class="product-author"><a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("Автор","olam"); ?>: <?php the_author(); ?></a></div>
                  </div>
                </div>
              </div>
            </div>
            <?php if(($wp_query->current_post+1)%3==0){  echo "</div>"; }
            else if(($wp_query->current_post+1)==$wp_query->post_count ){ echo "</div>"; } ?>

          <?php endwhile; else : ?>
          <p><?php esc_html_e( 'Sorry, no posts matched your criteria.','olam'); ?></p>
        <?php endif; ?>
      </div>
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
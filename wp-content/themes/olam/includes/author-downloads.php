<?php 
$author = get_user_by( 'id', get_query_var( 'author' ) );
$authorName=get_user_meta($author->ID,'nickname');
$authorDetails=get_userdata($author->ID);
$authorTitle=get_the_author_meta( 'author_page_title', $author->ID );
$authorSubs=get_the_author_meta( 'author_page_subtitle', $author->ID );
$avatarCustom=get_the_author_meta('authorbanner', $author->ID );
$avatarFES=get_the_author_meta('user_avatar', $author->ID );
if(isset($avatarCustom) && (strlen($avatarCustom)>0) ){
  $avatarUrl=$avatarCustom;
}
else if(isset($avatarFES) && (strlen($avatarFES)>0) ){
  $avatarUrl=$avatarFES;
}
else if(olam_validate_gravatar($author->user_email)){
  $avatarUrl=get_avatar_url($author->ID);
}
?>
<div class="author-page-details">
  <div class="fw-heading fw-heading-h2 fw-heading-center text-center">
    <?php if(isset($authorTitle) && strlen($authorTitle) >0) { ?> <h1 class="fw-special-title"><?php echo $authorTitle; ?></h1><?php } ?>      
    <?php if(isset($authorSubs) && strlen($authorSubs) >0) { ?> <div class="fw-special-subtitle"><?php echo $authorSubs; ?></div><?php } ?>       
  </div>
  <div class="row">
   <div class="col-md-3">
    <div class="sidebar">		
     <div class="author-details">
      <?php if(isset($avatarUrl) && strlen($avatarUrl) >0) { ?>  <div class="author-avatar-thumb"><img src="<?php echo esc_url($avatarUrl);  ?>" alt=""></div><?php } ?>
      <strong><?php echo get_the_author_meta('display_name',$author->ID); ?></strong>
      <?php if(strlen($authorDetails->user_url) >0) { ?> <span><?php echo esc_url($authorDetails->user_url); ?></span> <?php } ?>
      <ul class="social-icons">             
        <?php if(strlen(get_the_author_meta( 'author_fb_url', $author->ID )) >0) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_fb_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon icon-facebook"></i></span></a></li><?php } ?>
        <?php if(strlen(get_the_author_meta( 'author_youtube_url', $author->ID ))>0 ) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_youtube_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon icon-youtube"></i></span></a></li><?php } ?>
        <?php if(strlen(get_the_author_meta( 'author_twitter_url', $author->ID ))>0 ) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_twitter_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon icon-twitter"></i></span></a></li><?php } ?>
        <?php if(strlen(get_the_author_meta( 'author_linkedin_url', $author->ID ))>0 ) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_linkedin_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon icon-linkedin"></i></span></a></li><?php } ?>
        <?php if(strlen(get_the_author_meta( 'author_gplus_url', $author->ID) )>0) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_gplus_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon icon-gplus"></i></span></a></li><?php } ?>
        <?php if(strlen(get_the_author_meta( 'author_instagram_url', $author->ID) )>0) { ?><li><a href="<?php echo esc_url( get_the_author_meta( 'author_instagram_url', $author->ID ) ); ?>"><span class="icon"><i class="demo-icon fa fa-instagram"></i></span></a></li><?php } ?>
      </ul>
    </div>
  </div>
  <?php 
  $sideBarFlag=0;
  $columnWidth=12;
  $columnWidth2=12;
  if ( is_active_sidebar( 'olam-author-sidebar' ))
  { 
    $sideBarFlag=1;
    $columnWidth=9;
    $columnWidth2=8;
  }

  ?>  
</div>

<div class="col-md-9">
 <?php if(strlen(get_the_author_meta( 'description', $author->ID )) >0) { ?><?php echo get_the_author_meta( 'description', $author->ID ); ?><?php } ?>
</div>
</div>
</div>

<div class="row">

 <?php if ( $sideBarFlag==1){   
  echo '<div class="col-md-3"><div class="sidebar">';
  dynamic_sidebar( 'olam-author-sidebar' );
  echo '</div></div>';
}  ?>

<div class="col-md-<?php echo $columnWidth; ?>">
 <?php   

 $term=get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
 $termSlug=(isset($term->slug))?$term->slug:null;
 $searchTerm= (strlen(get_search_query() ) >0 )?get_search_query():null;
 $args=array("post_type"=>"download","status"=>"publish","author"=> $author->ID,'posts_per_page'=>-1);
 $temp = $wp_query; $wp_query = null; 
 $wp_query = new WP_Query(); $wp_query->query($args); ?>
 <?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
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
        //$videoUrl=wp_get_attachment_url($videoCode[0]);

        //     if(is_numeric($videoCode[0])){
        //         $videoUrl=wp_get_attachment_url($videoCode[0]);
        //     }
        //     else{
                $videoUrl=$videoCode[0];//wp_get_attachment_url($videoCode[0]);                                           
        //    }  ?>
        <div class="media-thumb">
          <?php echo do_shortcode("[video src='".$videoUrl."']"); ?>
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
        <?php
        if ( has_post_thumbnail() ) {
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
          <a href="<?php the_permalink(); ?>" title="<?php esc_html_e('View','olam'); ?> "><i class="demo-icons icon-search"></i></a>                                            

          <?php if(!olam_check_if_added_to_cart(get_the_ID())){
            $eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
            $addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Add to cart","olam");
            if(edd_has_variable_prices(get_the_ID())){
              $defaultPriceID=edd_get_default_variable_price( get_the_ID() );
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID,'edd_options[price_id]'=>$defaultPriceID);
            }
            else{
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID);
            }
            $currentPage=add_query_arg(array('author_downloads'=>"true"),olam_get_current_page_url());

            ?>  
            <a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Buy Now','olam'); ?>"><i class="demo-icons icon-download"></i></a>
            <a href="<?php echo esc_url(add_query_arg($downloadArray,$currentPage)); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>
            <?php } else { ?>
            <a class="cart-added" href="<?php echo edd_get_checkout_uri(); ?>" title="<?php esc_html_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
            <?php } ?>
          </div>
          <?php $olamct=get_theme_mod('olam_show_cats');
                if(isset($olamct)&& $olamct==1 ){

                    $cat = wp_get_post_terms(get_the_ID(),'download_category');
                    $mlink = get_term_link($cat[0]->slug, 'download_category');
                    ?><div class="product-author"><a href="<?php echo $mlink; ?>"><?php echo($cat[0]->name); ?></a></div><?php
                    }
                    else{
                    ?> <div class="product-author"><a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("By","olam"); ?>: <?php the_author(); ?></a></div><?php
                    }
                    ?>
        </div>
      </div>
    </div>
  </div>
  <?php if(($wp_query->current_post+1)%$division==0){  echo "</div>"; }
  else if(($wp_query->current_post+1)==$wp_query->post_count ){ echo "</div>"; }
  endwhile; ?>

<?php endif; ?>




































<?php

  $uid = get_current_user_id();
  $array = array();

  if($uid) {
    global $wpdb;

    $results = $wpdb->get_results("SELECT postId FROM user_posts WHERE userId = " . $uid);

    foreach($results as $result) {
      array_push($array, $result->postId);
    }
  }
  var_dump($array);
  $args = array(
    'post_type' => 'any',
    'post__in'      => $array
 );
 $wp_query = new WP_Query(); $wp_query->query($args); ?>
 <h3>Сохранёные посты</h3>
 <?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
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
        //$videoUrl=wp_get_attachment_url($videoCode[0]);

        //     if(is_numeric($videoCode[0])){
        //         $videoUrl=wp_get_attachment_url($videoCode[0]);
        //     }
        //     else{
                $videoUrl=$videoCode[0];//wp_get_attachment_url($videoCode[0]);                                           
        //    }  ?>
        <div class="media-thumb">
          <?php echo do_shortcode("[video src='".$videoUrl."']"); ?>
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
        <?php
        if ( has_post_thumbnail() ) {
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
          <a href="<?php the_permalink(); ?>" title="<?php esc_html_e('View','olam'); ?> "><i class="demo-icons icon-search"></i></a>                                            

          <?php if(!olam_check_if_added_to_cart(get_the_ID())){
            $eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
            $addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Add to cart","olam");
            if(edd_has_variable_prices(get_the_ID())){
              $defaultPriceID=edd_get_default_variable_price( get_the_ID() );
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID,'edd_options[price_id]'=>$defaultPriceID);
            }
            else{
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID);
            }
            $currentPage=add_query_arg(array('author_downloads'=>"true"),olam_get_current_page_url());

            ?>  
            <a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Buy Now','olam'); ?>"><i class="demo-icons icon-download"></i></a>
            <a href="<?php echo esc_url(add_query_arg($downloadArray,$currentPage)); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>
            <?php } else { ?>
            <a class="cart-added" href="<?php echo edd_get_checkout_uri(); ?>" title="<?php esc_html_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
            <?php } ?>
          </div>
          <?php $olamct=get_theme_mod('olam_show_cats');
                if(isset($olamct)&& $olamct==1 ){

                    $cat = wp_get_post_terms(get_the_ID(),'download_category');
                    $mlink = get_term_link($cat[0]->slug, 'download_category');
                    ?><div class="product-author"><a href="<?php echo $mlink; ?>"><?php echo($cat[0]->name); ?></a></div><?php
                    }
                    else{
                    ?> <div class="product-author"><a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("By","olam"); ?>: <?php the_author(); ?></a></div><?php
                    }
                    ?>
        </div>
      </div>
    </div>
  </div>
  <?php if(($wp_query->current_post+1)%$division==0){  echo "</div>"; }
  else if(($wp_query->current_post+1)==$wp_query->post_count ){ echo "</div>"; }
  endwhile; ?>

<?php endif; ?>
<? wp_reset_query(); ?>


</div>
</div>

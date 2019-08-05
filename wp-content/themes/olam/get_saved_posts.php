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
  
  if(count($array) == 0) {
      echo "<h4 align='center'>К сожалению, вы еще не сохранили ни одного товара :(</br>Вернитесь на <a href='/'>главную</a> и выберите то, что вам нравится.</h4>";
      return;
    }
  
  $args = array(
    'post_type' => 'any',
    'post__in'      => $array
 );
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
      <div class="product-description"><?php echo get_the_excerpt(); ?></div>
      <div class="product-price"><?php edd_price(get_the_ID()); ?></div>

      <div class="loggedUser">
        <div class="user-ico">
          <?
            echo get_avatar(get_the_author_meta('ID'), 25);
          ?>
        </div>
      </div>
      <a class="product-owner" href="<?php echo esc_url(add_query_arg('author_downloads', 'true', get_author_posts_url(get_the_author_meta('ID')))); ?>"><?php esc_html_e("", "olam"); ?> <?php the_author(); ?></a>
      <div class="details-bottom">
        <div class="product-options"> 
        <a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Удалить из сохранённого','olam'); ?> "><i class="demo-icons icon-like"></i><i class="posts-count"><? echo get_saved_posts_count(get_the_ID()) ?></i></a>

          <?php if(!olam_check_if_added_to_cart(get_the_ID())){
            $eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
            $addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Добавить в корзину","olam");
            if(edd_has_variable_prices(get_the_ID())){
              $defaultPriceID=edd_get_default_variable_price( get_the_ID() );
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID,'edd_options[price_id]'=>$defaultPriceID);
            }
            else{
              $downloadArray=array('edd_action'=>'add_to_cart','download_id'=>$post->ID);
            }
            $currentPage=add_query_arg(array('author_downloads'=>"true"),olam_get_current_page_url());

            ?>  
            <a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
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
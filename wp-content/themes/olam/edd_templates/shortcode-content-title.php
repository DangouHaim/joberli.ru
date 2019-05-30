<div class="product-details">
  <div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
  <div class="product-price"><?php edd_price(get_the_ID()); ?></div>
  <div class="details-bottom">
    <div class="product-options">
      <a href="<?php the_permalink(); ?>" title="<?php esc_html_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>                                            
      <a href="<?php echo esc_url(add_query_arg(array('edd_action'=>'add_to_cart','download_id'=>$post->ID),edd_get_checkout_uri()));?>" title="<?php esc_html_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
      <?php if(!olam_check_if_added_to_cart(get_the_ID())){
        $eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
        $addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Добавить в корзину","olam");
        ?>
        <a href="<?php echo esc_url(add_query_arg(array('edd_action'=>'add_to_cart','download_id'=>$post->ID),olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>                                    
        <?php } else { ?>
        <a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_html_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
        <?php } ?>
      </div>
      <div class="product-author">Автор:<a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url($post->post_author) )); ?>"><?php esc_html_e("","olam"); ?> <?php the_author(); ?></a></div>
    </div>
  </div>
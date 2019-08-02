<div class="product-details">
  <div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
  <div class="product-price"><?php edd_price(get_the_ID()); ?></div>
  <div class="details-bottom">
    <div class="product-options">
    <?if(is_user_logged_in()):?>
								<a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i><? echo get_saved_posts_count(get_the_ID()) ?></a>
								<?else:?>
								<a href="#" data-id="<? echo get_the_ID(); ?>" class="noLoggedUser"  title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>
								<?endif?>                                            
                <?if(is_user_logged_in()):?>
															<a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
															<?else:?>
															<a href="#" class="noLoggedUser"  title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
															<?endif?>
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
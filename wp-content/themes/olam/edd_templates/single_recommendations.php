<?php
global $post;
$suggestion_data = edd_rp_get_suggestions( $post->ID );

if ( is_array( $suggestion_data ) && !empty( $suggestion_data ) ) :
	$suggestions = array_keys( $suggestion_data );

	$suggested_downloads = new WP_Query( array( 'post__in' => $suggestions, 'post_type' => 'download' ) );

	if ( $suggested_downloads->have_posts() ) : ?>
		<div id="edd-rp-single-wrapper" class="alter">
			<h5 id="edd-rp-single-header"><?php echo sprintf( __( 'Users who purchased %s, also purchased:', 'edd-rp-txt' ), get_the_title() ); ?></h5>
			<div id="edd-rp-items-wrapper" class="edd-rp-single">
				<?php $countRow = 1; // Editted: for creating 3 item rows
				while ( $suggested_downloads->have_posts() ) : ?>
					<?php $suggested_downloads->the_post();	?>

					<?php if ($countRow%3 == 1) { // Editted: for creating 3 item rows
						echo "<div class='row'>";
					}	?>

						<div class="col-md-4">
							<div class="edd-rp-item alter <?php echo ( !current_theme_supports( 'post-thumbnails' ) ) ? 'edd-rp-nothumb' : ''; ?>">
								<?php do_action( 'edd_rp_item_before' ); ?>

								<a href="<?php the_permalink(); ?>">
									<?php the_title( '<span class="edd-rp-item-title">', '</span>' ); ?>

									<?php do_action( 'edd_rp_item_after_title' ); ?>

									<?php // Editted: for square image or featured image with size = 'olam-product-thumb' instead of 125x125
									$square_img = get_post_meta(get_the_ID(),"download_item_square_img");

									$thumbID=get_post_thumbnail_id(get_the_ID());
									$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb');
									$featImage=$featImage[0]; 

									if (!empty($square_img) && strlen($square_img[0])>0) { ?>
										<div class="edd_cart_item_image">
											<img src="<?php echo esc_url($square_img[0]); ?>" />
										</div> <?php
				                 	}
									else if((isset($featImage))&&(strlen($featImage)>0)){
										$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
										<div class="edd_cart_item_image">
											<img src="<?php echo esc_url($featImage); ?>" alt="<?php echo esc_attr($alt); ?>">
										</div> <?php
									}
									/*if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( get_the_ID() ) ) :?>
										<div class="edd_cart_item_image">
											<?php echo get_the_post_thumbnail( get_the_ID(), apply_filters( 'edd_checkout_image_size', array( 125,125 ) ) ); ?>
										</div>
									<?php*/
									else { ?>
										<br /> <?php
									} ?>
								</a>

								<div class="product-details">
	   			   			<div class="product-name">
	   			   				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	   			   			</div>
					   			<div class="product-price"><?php edd_price(get_the_ID()); ?></div>
					   			<div class="details-bottom">
					   				<div class="product-options">
									   <?if(is_user_logged_in()):?>
										<a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>  
										<?else:?>
										<a href="#" data-id="<? echo get_the_ID(); ?>" class="noLoggedUser"  title="<?php esc_attr_e('Сохранить','olam'); ?> "><i class="demo-icons icon-like"></i></a>
										<?endif?>
					   					</a>
					   					<?php if(!olam_check_if_added_to_cart(get_the_ID())){ 
											$eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
											$addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Добавить в корзину","olam");
											if(edd_has_variable_prices(get_the_ID())){

												$defaultPriceID=edd_get_default_variable_price( get_the_ID() );
												$downloadArray=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID(),'edd_options[price_id]'=>$defaultPriceID);
											}
											else{
												$downloadArray=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID());
											}				
											?>
																										<?if(is_user_logged_in()):?>
															<a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
															<?else:?>
															<a href="#" class="noLoggedUser"  title="<?php esc_attr_e('Купить сейчас','olam'); ?>"><i class="demo-icons icon-download"></i></a>
															<?endif?>
											</a>
											<a href="<?php echo esc_url(add_query_arg($downloadArray,olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>">
												<i class="demo-icons icon-cart"></i>
											</a>                                    
										<?php }
										else { ?>
											<a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_attr_e('Checkout','olam'); ?> ">
												<i class="fa fa-check"></i>
											</a>    
										<?php } ?>                                  
					   				</div>
					   				<div class="product-author">
					   					<a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>">
						   					<?php esc_html_e("Автор","olam"); ?>: <?php the_author(); ?>
						   				</a>
					   				</div>
				   				</div>
				   			</div>
							</div>
						</div>

					<?php if ($countRow%3 == 0) { // Editted: for creating 3 item rows
						echo "</div>";
					}
					$countRow++; ?>

				<?php endwhile; ?>
					<?php if ($countRow%3 != 1) echo "</div>"; // Editted: for creating 3 item rows
					// This is to ensure there is no open div if the number of elements is not a multiple of 3 ?>
			</div>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
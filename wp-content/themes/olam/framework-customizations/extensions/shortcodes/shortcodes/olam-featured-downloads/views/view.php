<?php if (!defined('FW')) die('Forbidden');
if(!olam_check_edd_exists()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
?>
<?php $noposts=(isset($atts['noposts']))?$atts['noposts']:3;
$noposts=(int)$noposts;
// $videoCode=get_post_meta(get_the_ID(),"download_item_video_id"); 
// $audioCode=get_post_meta(get_the_ID(),"download_item_audio_id");
// var_dump($videoCode);
// var_dump($audioCode);//die();
//$sectionTitle= (isset($atts['title']))?$atts['title']:esc_html__("Featured Items","olam");
// the query
$args = array(
	'post_type' => 'download',
	'showposts' => $noposts,
	'orderby'   =>'date',
	'order'     =>"DESC",
	'status'	=>'publish',
	'meta_query' => array(
		array(
			'key' => 'olam_box_select',
			'value'=>'yes',
			'compare'=>'='
			)
		)
	);
	$the_query = new WP_Query( $args ); ?>
	
	<div class="product-carousel">
		<?php if ( $the_query->have_posts() ) : ?>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div class="slider-item">
					<div class="edd_download_inner">
						<div class="thumb">
							<?php  $square_img = get_post_meta(get_the_ID(),"download_item_square_img");

							$thumbID=get_post_thumbnail_id(get_the_ID());
							$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb');
							$featImage=$featImage[0]; 
							$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);

											// feat vid code start
							$videoCode=get_post_meta(get_the_ID(),"download_item_video_id"); 
							$audioCode=get_post_meta(get_the_ID(),"download_item_audio_id");		
							$itemSet=null;		
							$featFlag=null;	
							$videoFlag=null;				
							if(isset($videoCode[0]) && (strlen($videoCode[0])>0) ){
								$itemSet=1;	
								$videoUrl=$videoCode[0];
								//$videoUrl=wp_get_attachment_url($videoCode[0]); 
								
								$videoFlag=1; ?>
								<div class="media-thumb">
									<?php echo do_shortcode("[video src='".$videoUrl."']"); ?>
								</div> <?php
							}
							else if (!empty($square_img) && strlen($square_img[0])>0) {
								$featFlag=1; ?>
		               		    <a href="<?php the_permalink(); ?>">
									<span><i class="demo-icons icon-link"></i></span>
									<img src="<?php echo esc_url($square_img[0]); ?>" />
								</a> <?php
		                 	}
							else if((isset($featImage))&&(strlen($featImage)>0)){
								$featFlag=1;
								$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true); ?>
								<a href="<?php the_permalink(); ?>">
									<span><i class="demo-icons icon-link"></i></span>
									<img src="<?php echo esc_url($featImage); ?>" alt="<?php echo esc_attr($alt); ?>">
								</a><?php
							}
							if(!isset($videoFlag)){ 
								if(isset($audioCode[0]) && (strlen($audioCode[0])>0) ){
									$itemSet=1;
									$audioUrl=wp_get_attachment_url($audioCode[0]);
									?>
									<div class="media-thumb">
										<?php echo do_shortcode("[audio src='".$audioUrl."']"); ?>
									</div> <?php
								}

							} ?>
							<?php if(!(isset($featFlag))){ ?>
							<a href="<?php the_permalink(); ?>">
								<span><i class="demo-icons icon-link"></i></span>
								<img src="<?php echo get_template_directory_uri(); ?>/img/preview-image-default.jpg" alt="<?php echo esc_attr($alt); ?>">
							</a>
							<?php } ?>

						</div>
						<div class="product-details">
							<div class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<div class="product-price"><?php edd_price(get_the_ID()); ?></div>
							<a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php esc_html_e("Автор","olam"); ?>: <?php the_author(); ?></a>
							<div class="details-bottom">
								<div class="product-options">
								<a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Like','olam'); ?> "><i class="demo-icons icon-like"></i></a>  
									<?php if(!olam_check_if_added_to_cart(get_the_ID())){ 
										$eddOptionAddtocart=edd_get_option( 'add_to_cart_text' );
										$addCartText=(isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ?$eddOptionAddtocart:esc_html__("Add to cart","olam");
										if(edd_has_variable_prices(get_the_ID())){

											$defaultPriceID=edd_get_default_variable_price( get_the_ID() );
											$downloadArray=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID(),'edd_options[price_id]'=>$defaultPriceID);
										}
										else{
											$downloadArray=array('edd_action'=>'add_to_cart','download_id'=>get_the_ID());
										}				
										?>
										<a href="<?php echo esc_url(add_query_arg($downloadArray,edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Buy Now','olam'); ?>"><i class="demo-icons icon-download"></i></a>
										<a href="<?php echo esc_url(add_query_arg($downloadArray,olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>                                    
										<?php } else { ?>
										<a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_attr_e('Checkout','olam'); ?> "><i class="fa fa-check"></i></a>    
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
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.','olam' ); ?></p>
			<?php endif; ?>
		</div>	

   <?php
	$eddColumn = get_theme_mod('olam_edd_columns');
	// var_dump($eddColumn);
	switch ($eddColumn) {
		case '2 columns':
			$colsize = 6;
			$division = 2;
			$colclass = "col-sm-6";
			break;
		case '3 columns':
			$colsize = 4;
			$division = 3;
			$colclass = null;
			break;
		case '4 columns':
			$colsize = 3;
			$division = 4;
			$colclass = "col-sm-6";
			break;
		default:
			$colclass = null;
			break;
	}
	if (($wp_query->current_post) % ($division) == 0) {
		echo "<div class='row'>";
	} ?>
   <div class="col-md-<?php echo $colsize; ?> <?php echo $colclass; ?>">
   	<div class="edd_download_inner">
   		<div class="thumb">
		   <?
				$video_url = get_post_meta(get_the_ID(), "video_url", true);
			?>
			<? if( !empty($video_url)) : ?>
				<div class="lf-head video-icon-on video-button" data-video='<? echo $video_url ?>'>
				<a class="watch-video" href="#" data-video="" data-toggle="modal" data-target="#play-video-modal" style="color: white;">
						<i class="fa fa-play" data-toggle="tooltip" data-placement="bottom" data-original-title="Видео"></i>
					</a>
				</div>
			<? endif ?>
   			<?php $videoCode = get_post_meta(get_the_ID(), "download_item_video_id");
				$audioCode = get_post_meta(get_the_ID(), "download_item_audio_id");
				if (isset($videoCode[0]) && (strlen($videoCode[0]) > 0)) {
					// if(is_numeric($videoCode[0])){
					//     $videoUrl=wp_get_attachment_url($videoCode[0]);
					// }
					// else{
					$videoUrl = $videoCode[0];
					// }
					//$videoUrl=wp_get_attachment_url($videoCode[0]);  

					?>
   				<div class="media-thumb">
   					<?php echo do_shortcode("[video src='" . $videoUrl . "']"); ?>
   				</div> <?php
						} else if (isset($audioCode[0]) && (strlen($audioCode[0]) > 0)) {
							$audioUrl = wp_get_attachment_url($audioCode[0]);
							?>
   				<div class="media-thumb">
   					<?php echo do_shortcode("[audio src='" . $audioUrl . "']"); ?>
   				</div><?php
						} ?>
   			<a href="<?php the_permalink(); ?>"><span><i class="demo-icons icon-link"></i></span>
   				<?php $square_img = get_post_meta(get_the_ID(), "download_item_square_img");
					if (!empty($square_img) && strlen($square_img[0]) > 0) {
						echo '<img src="' . esc_url($square_img[0]) . '" />';
					} elseif (has_post_thumbnail()) {
						the_post_thumbnail('olam-product-thumb');
					} else {
						echo '<img src="' . get_template_directory_uri() . '/img/thumbnail-default.jpg" />';
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
   					<? if (is_user_logged_in()) : ?>
   						<a href="#" data-id="<? echo get_the_ID(); ?>" class="post-save" title="<?php esc_attr_e('Сохранить', 'olam'); ?> "><i class="demo-icons icon-like"></i><i class="posts-count"><? echo get_saved_posts_count(get_the_ID()) ?></i></a>
   					<? else : ?>
   						<a href="#" data-id="<? echo get_the_ID(); ?>" class="noLoggedUser" title="<?php esc_attr_e('Сохранить', 'olam'); ?> "><i class="demo-icons icon-like"></i></a>
   					<? endif ?>
   					<?php if (!olam_check_if_added_to_cart(get_the_ID())) {
							$eddOptionAddtocart = edd_get_option('add_to_cart_text');
							$addCartText = (isset($eddOptionAddtocart) && $eddOptionAddtocart  != '') ? $eddOptionAddtocart : esc_html__("Добавить в корзину", "olam");
							if (edd_has_variable_prices(get_the_ID())) {
								$defaultPriceID = edd_get_default_variable_price(get_the_ID());
								$downloadArray = array('edd_action' => 'ade_to_cart', 'download_id' => get_the_ID(), 'edd_options[price_id]' => $defaultPriceID);
							} else {
								$downloadArray = array('edd_action' => 'ade_to_cart', 'download_id' => get_the_ID());
							}
							?>
   						<? if (is_user_logged_in()) : ?>
   							<a href="<?php echo esc_url(add_query_arg($downloadArray, edd_get_checkout_uri())); ?>" title="<?php esc_attr_e('Купить сейчас', 'olam'); ?>"><i class="demo-icons icon-download"></i></a>
   						<? else : ?>
   							<a href="#" class="noLoggedUser" title="<?php esc_attr_e('Купить сейчас', 'olam'); ?>"><i class="demo-icons icon-download"></i></a>
   						<? endif ?>
   						<a href="<?php echo esc_url(add_query_arg($downloadArray, olam_get_current_page_url())); ?>" title="<?php echo esc_html($addCartText); ?>"><i class="demo-icons icon-cart"></i></a>
   					<?php } else { ?>
   						<a class="cart-added" href="<?php echo esc_url(edd_get_checkout_uri()); ?>" title="<?php esc_attr_e('Checkout', 'olam'); ?> "><i class="fa fa-check"></i></a>
   					<?php } ?>
   				</div>
   				<?php $olamct = get_theme_mod('olam_show_cats');
					if (isset($olamct) && $olamct == 1) {

						$cat = wp_get_post_terms(get_the_ID(), 'download_category');
						$mlink = get_term_link($cat[0]->slug, 'download_category');
						?><div class="product-author"><a href="<?php echo $mlink; ?>"><?php echo ($cat[0]->name); ?></a></div><?php
																																} else {
																																	?> <div class="product-author"><a href="<?php echo esc_url(add_query_arg('author_downloads', 'true', get_author_posts_url(get_the_author_meta('ID')))); ?>"><?php esc_html_e("By", "olam"); ?>: <?php the_author(); ?></a></div><?php
																																																															}
																																																															?>
   			</div>
   		</div>
   	</div>
   </div>
   <?php if (($wp_query->current_post + 1) % ($division) == 0) {
		echo "</div>";
	} else if (($wp_query->current_post + 1) == $wp_query->post_count) {
		echo "</div>";
	}

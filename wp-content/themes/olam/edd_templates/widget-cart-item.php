<tr class="edd-cart-item">
	<td class="edd_cart_item_name">
		<div class="edd_cart_item_image">
			<?php $featImage=null;
			$theDownloadImage=get_post_meta($item['id'],'download_item_thumbnail_id'); 
			if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
				$thumbID=$theDownloadImage[0];
				$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
				$featImage=$featImage[0];
			}
			else{
				$thumbID=get_post_thumbnail_id($item['id']);
				$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
				$featImage=$featImage[0];
			}           
			?>
			<?php if((isset($featImage))&&(strlen($featImage)>0)){ ?>
				<span class="edd_cart_item_image_thumb">
					<img src="<?php echo esc_url($featImage); ?>" alt="Cart Item">
				</span><?php
			} 
			else{ ?>
				<span class="edd_cart_item_image_thumb">
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/product-thumb-small.jpg" alt="Cart Item">
				</span>
			<?php	} ?>
			<span class="edd_checkout_cart_item_title">{item_title}</span>
		</div>
	</td>
	<td class="edd_cart_quantity">&nbsp;{item_quantity}&nbsp;</td>
	<td class="edd_cart_item_price">&nbsp;{item_amount}&nbsp;</td>
	<td class="edd_cart_actions">
		<a href="{remove_url}" data-cart-item="{cart_item_id}" data-download-id="{item_id}" data-action="edd_remove_from_cart" class="edd_cart_remove_item_btn"><?php esc_html_e( 'remove', 'olam' ); ?></a>
	</td>
</tr>

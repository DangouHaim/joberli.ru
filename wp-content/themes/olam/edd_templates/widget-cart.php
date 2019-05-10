<?php
/**
 * This template is used to display the Downloads cart widget.
 */
$cart_items    = edd_get_cart_contents();
$cart_quantity = edd_get_cart_quantity();
$display       = $cart_quantity > 0 ? '' : ' style="display:none;"';
$cartclass     = $cart_quantity > 0 ? null : 'empty-cart-table';
?>
<p class="edd-cart-number-of-items"<?php echo esc_attr($display); ?>><?php esc_html_e( 'Количество товаров в корзине', 'olam' ); ?>: <span class="edd-cart-quantity"><?php echo esc_html($cart_quantity); ?></span></p>
<table id="edd_checkout_cart" class="ajaxed <?php echo esc_attr($cartclass); ?>">
	<thead>
		<tr class="edd_cart_header_row">
			<th class="edd_cart_item_name"><?php esc_html_e("Название товара","olam"); ?></th>
			<th class="edd_cart_quantity"><?php esc_html_e("Количество","olam"); ?></th>
			<th class="edd_cart_item_price"><?php esc_html_e("Цена","olam"); ?></th>
			<th class="edd_cart_actions"><?php esc_html_e("Действия","olam"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if( $cart_items ) : ?>
			<?php foreach( $cart_items as $key => $item ) : ?>
				<?php //echo edd_get_cart_item_template( $key, $item, false );
				$id = is_array($item) ? $item['id'] : $item;
			    $remove_url = edd_remove_item_url($key);
			    $title = get_the_title($id);
			    $options = !empty($item['options']) ? $item['options'] : array();
			    $quantity = edd_get_cart_item_quantity($id, $options);
			    $price = edd_get_cart_item_price($id, $options);
			    if (!empty($options)) {
			        $title .= edd_has_variable_prices($item['id']) ? ' <span class="edd-cart-item-separator">-</span> ' . edd_get_price_name($id, $item['options']) : edd_get_price_name($id, $item['options']);
			    } ?>
				<tr>
					<td>
						<div class="edd_cart_item_image">
							<?php $featImage=null;
							$theDownloadImage=get_post_meta($id,'download_item_thumbnail_id'); 
							if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
								$thumbID=$theDownloadImage[0];
								$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
								$featImage=$featImage[0];
							}
							else{
								$thumbID=get_post_thumbnail_id($id);
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
							<span class="edd_checkout_cart_item_title"><?php echo $title; ?></span>
						</div>
					</td>
					<td class="edd_cart_quantity">&nbsp;<?php echo $quantity; ?>&nbsp;</td>
					<td class="edd_cart_item_price">&nbsp;<?php echo edd_currency_filter(edd_format_amount($price)); ?>&nbsp;</td>
					<td class="edd_cart_actions">
						<a class="edd_cart_remove_item_btn" href="<?php echo esc_url( wp_nonce_url( edd_remove_item_url( $key ), 'edd-remove-from-cart-' . $key, 'edd_remove_from_cart_nonce' ) ); ?>"><?php _e( 'Remove', 'easy-digital-downloads' ); ?></a>
					</td>
				</tr>
				<?php //$subtotal = '';
			 //    if ($ajax) {
			 //        $subtotal = edd_currency_filter(edd_format_amount(edd_get_cart_subtotal()));
			 //    }
			 //    $item = str_replace('{subtotal}', $subtotal, $item);
			 //    return apply_filters('edd_cart_item', $item, $id); ?>

			<?php endforeach; ?>
			<?php edd_get_template_part( 'widget', 'cart-checkout' ); ?>
		<?php else : ?>
			<?php edd_get_template_part( 'widget', 'cart-empty' ); ?>
		<?php endif; ?>
	</tbody>
</table>
<div class="text-right">
	<a href="<?php echo edd_get_checkout_uri(); ?>" class="btn btn-checkout right"><?php esc_html_e( 'Оплатить', 'olam' ); ?></a>
	<span class="clearfix"></span>
</div>
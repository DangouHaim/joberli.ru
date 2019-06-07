<?php global $products; ?>
<h1 class="fes-headers" id="fes-products-page-title"><?php echo EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = true ) ?></h1>
<?php echo EDD_FES()->dashboard->product_list_status_bar(); ?>
<div id="tabs">
  <ul>
    <li><a href="#fragment-1">Мои товары</a></li>
	<li><a href="#fragment-2">Мои покупки</a></li>
	<li><a href="#fragment-3">Мои задачи</a></li>
  </ul>

  <div id="fragment-1">
	<table class="table fes-table table-condensed  table-striped" id="fes-product-list">
		<thead>
			<tr>
				<th><?php _e( 'Картинка', 'edd_fes' ); ?></th>
				<th><?php _e( 'Имя', 'edd_fes' ); ?></th>
				<th><?php _e( 'Статус', 'edd_fes' ); ?></th>
				<th><?php _e( 'Цена', 'edd_fes' ); ?></th>
				<th><?php _e( 'Покупки', 'edd_fes' ) ?></th>
				<th><?php _e( 'Действия','edd_fes') ?></th>
				<th><?php _e( 'Дата', 'edd_fes' ); ?></th>
				<?php do_action('fes-product-table-column-title'); ?>
			</tr>
		</thead>
		<tbody>
			<?php
			if (count($products) > 0 ){
				foreach ( $products as $product ) : ?>
				<tr>
					<td class = "fes-product-list-td"><?php
					$featImage=null;
					$theDownloadImage=get_post_meta($product->ID,'download_item_thumbnail_id'); 
					if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
						$thumbID=$theDownloadImage[0];
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}
					else{
						$thumbID=get_post_thumbnail_id($product->ID);
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}           
					?>
					<?php if(isset($featImage)&&strlen($featImage)>0) { 
						$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
						?> 
						<img src="<?php echo esc_url($featImage);  ?>" class="attachment-shop_thumbnail wp-post-image" alt="<?php echo esc_attr($alt); ?>">
						<?php } ?>
					</td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_title($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_status($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_price($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_sales_esc($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php EDD_FES()->dashboard->product_list_actions($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_date($product->ID); ?></td>
					<?php do_action('fes-product-table-column-value'); ?>
				</tr>
				<?php endforeach;
			} else {
				echo '<tr><td colspan="7" class = "fes-product-list-td" >'. sprintf( _x('No %s found', 'FES lowercase plural setting for download','edd_fes'), EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = false ) ).'</td></tr>';
			}
			?>
		</tbody>
	</table>
	<?php EDD_FES()->dashboard->product_list_pagination(); ?>
  </div>

  <div id="fragment-2">
  	<table class="table fes-table table-condensed  table-striped" id="fes-product-list">
		<thead>
			<tr>
				<th><?php _e( 'Картинка', 'edd_fes' ); ?></th>
				<th><?php _e( 'Имя', 'edd_fes' ); ?></th>
				<th><?php _e( 'Статус', 'edd_fes' ); ?></th>
				<th><?php _e( 'Цена', 'edd_fes' ); ?></th>
				<th><?php _e( 'Действия','edd_fes') ?></th>
				<th><?php _e( 'Дата', 'edd_fes' ); ?></th>
				<?php do_action('fes-product-table-column-title'); ?>
			</tr>
		</thead>
		<tbody>
			<?php
			$orders = array();

			$purchases = getUserPurchases();

			foreach ( $purchases as $purchase ) {
				$download = edd_get_download($purchase->postId);
				$download->purchase = $purchase;
				array_push($orders, $download);
			}

			if (count($orders) > 0 ){
				foreach ( $orders as $product ) : ?>
				<tr>
					<td class = "fes-product-list-td"><?php
					$featImage=null;
					$theDownloadImage=get_post_meta($product->ID,'download_item_thumbnail_id'); 
					if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
						$thumbID=$theDownloadImage[0];
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}
					else{
						$thumbID=get_post_thumbnail_id($product->ID);
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}
					$orderId = $product->purchase->id;
					?>
					<?php if(isset($featImage)&&strlen($featImage)>0) { 
						$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
						?> 
						<img src="<?php echo esc_url($featImage);  ?>" class="attachment-shop_thumbnail wp-post-image" alt="<?php echo esc_attr($alt); ?>">
						<?php } ?>
					</td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_title($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo getOrderStatus($product->purchase->id); ?></td>
					<td class = "fes-product-list-td"><?php echo $product->purchase->sum; ?></td>
					
					<td class = "fes-product-list-td">
						<?php EDD_FES()->dashboard->product_list_actions($product->ID); ?>
						<?php if( !isCancelledOrder($orderId) && !isOrderHasCancelRequest($orderId) && !isOrderDone($orderId) ): ?>
							<a href="#" class="cancel-purchase" data-order-id="<?php echo $orderId; ?>">Отменить</a>
						<?php endif; ?>
					</td>

					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_date($product->ID); ?></td>
					<?php do_action('fes-product-table-column-value'); ?>
				</tr>
				<?php endforeach;
			} else {
				echo '<tr><td colspan="7" class = "fes-product-list-td" >'. sprintf( _x('No %s found', 'FES lowercase plural setting for download','edd_fes'), EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = false ) ).'</td></tr>';
			}
			?>
		</tbody>
	</table>
  </div>

  <div id="fragment-3">
  	<table class="table fes-table table-condensed  table-striped" id="fes-product-list">
		<thead>
			<tr>
				<th><?php _e( 'Картинка', 'edd_fes' ); ?></th>
				<th><?php _e( 'Имя', 'edd_fes' ); ?></th>
				<th><?php _e( 'Статус', 'edd_fes' ); ?></th>
				<th><?php _e( 'Цена', 'edd_fes' ); ?></th>
				<th><?php _e( 'Покупки', 'edd_fes' ) ?></th>
				<th><?php _e( 'Действия','edd_fes') ?></th>
				<th><?php _e( 'Дата', 'edd_fes' ); ?></th>
				<?php do_action('fes-product-table-column-title'); ?>
			</tr>
		</thead>
		<tbody>
			<?php
			$orders = array();

			$purchases = getUserOrders();

			foreach ( $purchases as $purchase ) {
				$download = edd_get_download($purchase->postId);
				$download->purchase = $purchase;
				array_push($orders, $download);
			}

			if (count($orders) > 0 ){
				foreach ( $orders as $product ) : ?>
				<tr>
					<td class = "fes-product-list-td"><?php
					$featImage=null;
					$theDownloadImage=get_post_meta($product->ID,'download_item_thumbnail_id'); 
					if(is_array($theDownloadImage) && (count($theDownloadImage)>0) ){
						$thumbID=$theDownloadImage[0];
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}
					else{
						$thumbID=get_post_thumbnail_id($product->ID);
						$featImage=wp_get_attachment_image_src($thumbID,'olam-product-thumb-small');
						$featImage=$featImage[0];
					}           
					?>
					<?php if(isset($featImage)&&strlen($featImage)>0) { 
						$alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
						?> 
						<img src="<?php echo esc_url($featImage);  ?>" class="attachment-shop_thumbnail wp-post-image" alt="<?php echo esc_attr($alt); ?>">
						<?php } ?>
					</td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_title($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo getOrderStatus($product->purchase->id); ?></td>
					<td class = "fes-product-list-td"><?php echo $download->purchase->sum; ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_sales_esc($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php EDD_FES()->dashboard->product_list_actions($product->ID); ?></td>
					<td class = "fes-product-list-td"><?php echo EDD_FES()->dashboard->product_list_date($product->ID); ?></td>
					<?php do_action('fes-product-table-column-value'); ?>
				</tr>
				<?php endforeach;
			} else {
				echo '<tr><td colspan="7" class = "fes-product-list-td" >'. sprintf( _x('No %s found', 'FES lowercase plural setting for download','edd_fes'), EDD_FES()->helper->get_product_constant_name( $plural = true, $uppercase = false ) ).'</td></tr>';
			}
			?>
		</tbody>
	</table>
  </div>

</div>
<?php
/**
 * This template is used to display the purchase history of the current user.
 */
if ( is_user_logged_in() ):
	$purchases = edd_get_users_purchases( get_current_user_id(), 20, true, 'any' );
	if ( $purchases ) :
		do_action( 'edd_before_purchase_history' ); ?>
		<table id="edd_user_history">
			<thead>
				<tr class="edd_purchase_row">
					<?php do_action('edd_purchase_history_header_before'); ?>
					<th class="edd_purchase_id"><?php esc_html_e('ID', 'olam'); ?></th>
					<th class="edd_purchase_date"><?php esc_html_e('Date', 'olam'); ?></th>
					<th class="edd_purchase_amount"><?php esc_html_e('Amount', 'olam'); ?></th>
					<th class="edd_purchase_details"><?php esc_html_e('Details', 'olam'); ?></th>
					<?php do_action('edd_purchase_history_header_after'); ?>
				</tr>
			</thead>
			<?php foreach ( $purchases as $post ) : setup_postdata( $post ); ?>
				<?php $purchase_data = edd_get_payment_meta( $post->ID ); ?>
				<tbody>
					<tr class="edd_purchase_row">
						<?php do_action( 'edd_purchase_history_row_start', $post->ID, $purchase_data ); ?>
						<td class="edd_purchase_id">#<?php echo edd_get_payment_number( $post->ID ); ?></td>
						<td class="edd_purchase_date"><?php echo date_i18n( get_option('date_format'), strtotime( get_post_field( 'post_date', $post->ID ) ) ); ?></td>
						<td class="edd_purchase_amount">
							<span class="edd_purchase_amount"><?php echo edd_currency_filter( edd_format_amount( edd_get_payment_amount( $post->ID ) ) ); ?></span>
						</td>
						<td class="edd_purchase_details">
							<?php if( $post->post_status != 'publish' ) : ?>
							<span class="edd_purchase_status <?php echo esc_html($post->post_status); ?>"><?php echo esc_html(edd_get_payment_status( $post, true )); ?></span>
							<a href="<?php echo esc_url( add_query_arg( 'payment_key', edd_get_payment_key( $post->ID ), edd_get_success_page_uri() ) ); ?>">&raquo;</a>
							<?php else: ?>
							<a href="<?php echo esc_url( add_query_arg( 'payment_key', edd_get_payment_key( $post->ID ), edd_get_success_page_uri() ) ); ?>"><?php esc_html_e( 'View Details and Downloads', 'olam' ); ?></a>
							<?php endif; ?>
						</td>
						<?php do_action( 'edd_purchase_history_row_end', $post->ID, $purchase_data ); ?>
					</tr>
				</tbody>
			<?php endforeach; ?>
		</table>
		<div id="edd_purchase_history_pagination" class="edd_pagination navigation">
			<?php
			$big = 999999;
			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, get_query_var( 'paged' ) ),
				'total'   => ceil( edd_count_purchases_of_customer() / 20 ) // 20 items per page
			) );
			?>
		</div>
		<?php do_action( 'edd_after_purchase_history' ); ?>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<p class="edd-no-purchases"><?php esc_html_e('You have not made any purchases', 'olam'); ?></p>
	<?php endif;
endif;

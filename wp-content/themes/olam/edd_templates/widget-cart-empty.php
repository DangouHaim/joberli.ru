<tr class="cart_item empty">
	<td colspan="4">		
		<?php echo esc_html__e("Карзина пуста!", "olam"); ?>
	</td>
</tr>
<?php if ( edd_use_taxes() ) : ?>
<tr class="cart_item edd-cart-meta edd_subtotal">
	<td colspan="4" style="display:none;"><?php echo esc_html__( 'Итого:', 'olam' ). " <span class='subtotal'>" . edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() ) ); ?></span></td>
</tr>
<tr class="cart_item edd-cart-meta edd_cart_tax"><?php esc_html_e( 'Приблизительный налог:', 'olam' ); ?>
	<td colspan="4" style="display:none;"><span class="cart-tax"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_tax() ) ); ?></span></td>
</tr>
<?php endif; ?>
<tr class="cart_item edd-cart-meta edd_total" style="display:none;">
	<td colspan="4"><?php esc_html_e( 'Всего:', 'olam' ); ?><span class="cart-total"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_total() ) ); ?></span></td>
</tr>
<tr class="cart_item edd_checkout" style="display:none;">
	<td colspan="4"><a href="<?php echo edd_get_checkout_uri(); ?>"><?php esc_html_e( 'Оплатить', 'olam' ); ?></a></td>
</tr>

<?php if ( edd_use_taxes() ) : ?>
<tr class="cart_item edd-cart-meta edd_subtotal edd_cart_footer_row text-right">
	<th class="edd_cart_total" colspan="4"><?php echo esc_html__( 'Subtotal:', 'olam' ). " <span class='subtotal'>" . edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() ) ); ?></span></td>
</tr>
<tr class="cart_item edd-cart-meta edd_cart_tax edd_cart_footer_row text-right">
	<td colspan="4"><?php esc_html_e( 'Estimated Tax:', 'olam' ); ?> <span class="cart-tax"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_tax() ) ); ?></span></td>
</tr>
<?php endif; ?>
<tr class="cart_item edd-cart-meta edd_total edd_cart_footer_row text-right">
	<th class="edd_cart_total" colspan="4"><?php esc_html_e( 'Total:', 'olam' ); ?> <span class="edd_cart_amount"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_total() ) ); ?></span></tH>
</tr>
<!-- <tr class="cart_item edd_checkout edd_cart_footer_row text-right">
	<td colspan="4"></td>
</tr> -->

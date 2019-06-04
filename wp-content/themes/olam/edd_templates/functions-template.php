<?php

function get_purchase_cart_link( $args = array() ) {
	global $post, $edd_displayed_form_ids;

	$purchase_page = edd_get_option( 'purchase_page', false );
	if ( ! $purchase_page || $purchase_page == 0 ) {

		global $no_checkout_error_displayed;
		if ( ! is_null( $no_checkout_error_displayed ) ) {
			return false;
		}


		edd_set_error( 'set_checkout', sprintf( __( 'No checkout page has been configured. Visit <a href="%s">Settings</a> to set one.', 'easy-digital-downloads' ), admin_url( 'edit.php?post_type=download&page=edd-settings' ) ) );
		edd_print_errors();

		$no_checkout_error_displayed = true;

		return false;

	}

	$post_id = is_object( $post ) ? $post->ID : 0;
	$button_behavior = edd_get_download_button_behavior( $post_id );

	$defaults = apply_filters( 'edd_purchase_link_defaults', array(
		'download_id' => $post_id,
		'price'       => (bool) true,
		'price_id'    => isset( $args['price_id'] ) ? $args['price_id'] : false,
		'direct'      => $button_behavior == 'direct' ? true : false,
		'text'        => $button_behavior == 'direct' ? edd_get_option( 'buy_now_text', __( 'Buy Now', 'easy-digital-downloads' ) ) : edd_get_option( 'add_to_cart_text', __( 'Purchase', 'easy-digital-downloads' ) ),
		'checkout'    => edd_get_option( 'checkout_button_text', _x( 'Оплатить', 'text shown on the Add to Cart Button when the product is already in the cart', 'easy-digital-downloads' ) ),
		'style'       => edd_get_option( 'button_style', 'button' ),
		'color'       => edd_get_option( 'checkout_color', 'blue' ),
		'class'       => 'edd-submit'
	) );

	$args = wp_parse_args( $args, $defaults );

	// Override the straight_to_gateway if the shop doesn't support it
	if ( ! edd_shop_supports_buy_now() ) {
		$args['direct'] = false;
	}

	$download = new EDD_Download( $args['download_id'] );

	if( empty( $download->ID ) ) {
		return false;
	}

	if( 'publish' !== $download->post_status && ! current_user_can( 'edit_product', $download->ID ) ) {
		return false; // Product not published or user doesn't have permission to view drafts
	}

	// Override color if color == inherit
	$args['color'] = ( $args['color'] == 'inherit' ) ? '' : $args['color'];

	$options          = array();
	$variable_pricing = $download->has_variable_prices();
	$data_variable    = $variable_pricing ? ' data-variable-price="yes"' : 'data-variable-price="no"';
	$type             = $download->is_single_price_mode() ? 'data-price-mode=multi' : 'data-price-mode=single';

	$show_price       = $args['price'] && $args['price'] !== 'no';
	$data_price_value = 0;
	$price            = false;

	if ( $variable_pricing && false !== $args['price_id'] ) {

		$price_id            = $args['price_id'];
		$prices              = $download->prices;
		$options['price_id'] = $args['price_id'];
		$found_price         = isset( $prices[$price_id] ) ? $prices[$price_id]['amount'] : false;

		$data_price_value    = $found_price;

		if ( $show_price ) {
			$price = $found_price;
		}

	} elseif ( ! $variable_pricing ) {

		$data_price_value = $download->price;

		if ( $show_price ) {
			$price = $download->price;
		}

	}

	$data_price  = 'data-price="' . $data_price_value . '"';

	$button_text = ! empty( $args['text'] ) ? '&nbsp;&ndash;&nbsp;' . $args['text'] : '';

	if ( false !== $price ) {

		if ( 0 == $price ) {
			$args['text'] = __( 'Free', 'easy-digital-downloads' ) . $button_text;
		} else {
			$args['text'] = edd_currency_filter( edd_format_amount( $price ) ) . $button_text;
		}

	}

	if ( edd_item_in_cart( $download->ID, $options ) && ( ! $variable_pricing || ! $download->is_single_price_mode() ) ) {
		$button_display   = 'style="display:none;"';
		$checkout_display = '';
	} else {
		$button_display   = '';
		$checkout_display = 'style="display:none;"';
	}

	// Collect any form IDs we've displayed already so we can avoid duplicate IDs
	if ( isset( $edd_displayed_form_ids[ $download->ID ] ) ) {
		$edd_displayed_form_ids[ $download->ID ]++;
	} else {
		$edd_displayed_form_ids[ $download->ID ] = 1;
	}

	$form_id = ! empty( $args['form_id'] ) ? $args['form_id'] : 'edd_purchase_' . $download->ID;

	// If we've already generated a form ID for this download ID, append -#
	if ( $edd_displayed_form_ids[ $download->ID ] > 1 ) {
		$form_id .= '-' . $edd_displayed_form_ids[ $download->ID ];
	}

	$args = apply_filters( 'edd_purchase_link_args', $args );

	ob_start();
?>
	<form id="<?php echo $form_id; ?>" class="edd_download_purchase_form edd_purchase_<?php echo absint( $download->ID ); ?>" method="post">

		<?php do_action( 'edd_purchase_link_top', $download->ID, $args ); ?>

		<div class="edd_purchase_submit_wrapper">
			<?php
			$class = implode( ' ', array( $args['style'], $args['color'], trim( $args['class'] ) ) );

			if ( ! edd_is_ajax_disabled() ) {
				echo "<div class='wrap'>";
				echo '<a href="#" class="edd-add-to-cart without-content ' . esc_attr( $class ) . '" data-nonce="' .  wp_create_nonce( 'edd-add-to-cart-' . $download->ID ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download->ID ) . '" ' . $data_variable . ' ' . $type . ' ' . $data_price . ' ' . $button_display . '><span class="edd-add-to-cart-label">' . $args['text'] . '</span> <span class="edd-loading" aria-label="' . esc_attr__( 'Loading', 'easy-digital-downloads' ) . '"></span></a>';
				echo '<a href="#" class="no-icon purchase-button after-cart ' . esc_attr( $class ) . '" data-nonce="' .  wp_create_nonce( '-' . $download->ID ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download->ID ) . '" ' . $data_variable . ' ' . $type . ' ' . $data_price . ' ' . $button_display . '><span class="-label">' . $args['text'] . '</span> <span class="edd-loading" aria-label="' . esc_attr__( 'Loading', 'easy-digital-downloads' ) . '"></span></a>';
				echo "</div>";

			}

			echo '<input type="submit" class=" edd-no-js ' . esc_attr( $class ) . '" name="edd_purchase_download" value="' . esc_attr( $args['text'] ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download->ID ) . '" ' . $data_variable . ' ' . $type . ' ' . $button_display . '/>';
			//echo '<a href="' . esc_url( edd_get_checkout_uri() ) . '" class="edd_go_to_checkout ' . esc_attr( $class ) . '" ' . $checkout_display . '>' . $args['checkout'] . '</a>';
			?>

			<?php if ( ! edd_is_ajax_disabled() ) : ?>
				<span class="edd-cart-ajax-alert" aria-live="assertive">
					<span class="edd-cart-added-alert" style="display: none;">
						<svg class="edd-icon edd-icon-check" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" aria-hidden="true">
							<path d="M26.11 8.844c0 .39-.157.78-.44 1.062L12.234 23.344c-.28.28-.672.438-1.062.438s-.78-.156-1.06-.438l-7.782-7.78c-.28-.282-.438-.673-.438-1.063s.156-.78.438-1.06l2.125-2.126c.28-.28.672-.438 1.062-.438s.78.156 1.062.438l4.594 4.61L21.42 5.656c.282-.28.673-.438 1.063-.438s.78.155 1.062.437l2.125 2.125c.28.28.438.672.438 1.062z"/>
						</svg>
						<?php echo __( 'Added to cart', 'easy-digital-downloads' ); ?>
					</span>
				</span>
			<?php endif; ?>
			<?php if( ! $download->is_free( $args['price_id'] ) && ! edd_download_is_tax_exclusive( $download->ID ) ): ?>
				<?php if ( edd_display_tax_rate() && edd_prices_include_tax() ) {
					echo '<span class="edd_purchase_tax_rate">' . sprintf( __( 'Includes %1$s&#37; tax', 'easy-digital-downloads' ), edd_get_tax_rate() * 100 ) . '</span>';
				} elseif ( edd_display_tax_rate() && ! edd_prices_include_tax() ) {
					echo '<span class="edd_purchase_tax_rate">' . sprintf( __( 'Excluding %1$s&#37; tax', 'easy-digital-downloads' ), edd_get_tax_rate() * 100 ) . '</span>';
				} ?>
			<?php endif; ?>
		</div><!--end .edd_purchase_submit_wrapper-->

		<input type="hidden" name="download_id" value="<?php echo esc_attr( $download->ID ); ?>">
		<?php if ( $variable_pricing && isset( $price_id ) && isset( $prices[$price_id] ) ): ?>
			<input type="hidden" name="edd_options[price_id][]" id="edd_price_option_<?php echo $download->ID; ?>_1" class="edd_price_option_<?php echo $download->ID; ?>" value="<?php echo $price_id; ?>">
		<?php endif; ?>
		<?php if( ! empty( $args['direct'] ) && ! $download->is_free( $args['price_id'] ) ) { ?>
			<input type="hidden" name="edd_action" class="edd_action_input" value="straight_to_gateway">
		<?php } else { ?>
			<input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart">
		<?php } ?>

		<?php if( apply_filters( 'edd_download_redirect_to_checkout', edd_straight_to_checkout(), $download->ID, $args ) ) : ?>
			<input type="hidden" name="edd_redirect_to_checkout" id="edd_redirect_to_checkout" value="1">
		<?php endif; ?>

		<?php do_action( 'edd_purchase_link_end', $download->ID, $args ); ?>

	</form><!--end #<?php echo esc_attr( $form_id ); ?>-->
<?php
	$purchase_form = ob_get_clean();


	return apply_filters( 'edd_purchase_download_form', $purchase_form, $args );
}
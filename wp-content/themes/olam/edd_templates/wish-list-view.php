<?php
/**
 * Wish List template
*/

// get list ID
$list_id = edd_wl_get_list_id();

// get the downloads from the wish list
$downloads = edd_wl_get_wish_list( $list_id );

// get list post object
$list = get_post( $list_id );

// title
$title = get_the_title( $list_id );

//status
$privacy = get_post_status( $list_id );

?>

<?php if ( $list_id && $list->post_content ) : ?>
	<p><?php echo $list->post_content; ?></p>
<?php endif; ?>

<?php if ( $downloads ) : ?>

	<?php // All all items in list to cart
		echo edd_wl_add_all_to_cart_link( $list_id );
	?>

	<ul class="edd-wish-list">
		<?php foreach ( $downloads as $key => $item ) : ?>
			<li class="wl-row">
				<?php // item title
					//echo edd_wl_item_title( $item );
					//********* edd_wl_item_title() function editted
						$item_id 			= $item['id'];
						$item_option 		= ! empty( $item['options'] ) ? apply_filters( 'edd_wl_item_title_options', '<span class="edd-wl-item-title-option">' . edd_get_cart_item_price_name( $item ) . '</span>' ) : '';
						$variable_price_id 	= isset( $item['options']['price_id'] ) ? $item['options']['price_id'] : '';
						$already_purchased 	= apply_filters( 'edd_wl_item_title_already_purchased', edd_wl_has_purchased( $item_id, $variable_price_id ) );
						if ( current_theme_supports( 'post-thumbnails' ) ) {
							
							if( has_post_thumbnail( $item_id ) ){
								$item_image = apply_filters( 'edd_wl_item_image', '<span class="edd-wl-item-image">' . get_the_post_thumbnail( $item_id, apply_filters( 'edd_checkout_image_size', array( 50, 50 ) ) ) . '</span>' );
							}
							else
							{
								$item_image = apply_filters( 'edd_wl_item_image', '<span class="edd-wl-item-image"><img src="'.esc_url(get_template_directory_uri()).'/img/product-thumb-small.jpg" alt="Wishlist item"></span>' );
							}
						}
						$defaults = apply_filters( 'edd_wl_item_title_defaults',
							array(
								'wrapper_class'	=> '',
								'wrapper' 		=> 'span',
								'class'			=> ''
							)
						);
						$args = wp_parse_args( $args, $defaults );
						extract( $args, EXTR_SKIP );
						// add our default class
						$default_wrapper_class = ' edd-wl-item-title';
						$wrapper_class .= $wrapper_class ? $default_wrapper_class : trim( $default_wrapper_class );
						$class = $class ? 'class="' . trim( $class ) . '"' : '';
						ob_start();
						$html = '';
						$link = '<a href="' . apply_filters( 'edd_wl_item_title_permalink', get_permalink( $item_id ), $item_id ) . '" ' . $class . ' title="' . get_the_title( $item_id ) . '">' . get_the_title( $item_id ) . '</a>';
						$output = $link . $item_option . $already_purchased . $item_image;
						if ( $wrapper ) {
							$html = '<' . $wrapper . ' class="' . $wrapper_class . '"' . '>' . $output . '</' . $wrapper . '>';
						}
						else {
							$html .= $output;
						}
						echo $html;
						$html = ob_get_clean();
						echo apply_filters( 'edd_wl_item_title', $html );
					//********
				?>

				<?php // item price
					echo edd_wl_item_price( $item['id'], $item['options'] );
				?>

				<?php // purchase link
					echo edd_wl_item_purchase( $item );
				?>

				<?php // remove item link
					echo olam_edd_wl_item_remove_link( $item['id'], $key, $list_id );
				?>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php
	/**
	 * Sharing - only shown for public lists
	*/
	if ( 'private' !== get_post_status( $list_id ) && apply_filters( 'edd_wl_display_sharing', true ) ) : ?>
		<div class="edd-wl-sharing">
			<h3 class="edd-wl-heading"><?php _e( 'Share', 'edd-wish-lists' ); ?></h3>
			<p><?php echo wp_get_shortlink( $list_id ); // Shortlink to share ?></p>

			<?php
				// Share via email
				echo edd_wl_share_via_email_link();

				// Social sharing services
				echo edd_wl_sharing_services();
			?>
		</div>
	<?php endif; ?>

<?php endif; ?>

<?php // edit settings
	echo edd_wl_edit_settings_link( $list_id );
?>

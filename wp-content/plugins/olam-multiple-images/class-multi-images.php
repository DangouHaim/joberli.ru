<?php 

class Olam_Post_Images {


	public static function output( $post ) {
		?>
		<div id="olam_post_images_container">
			<ul class="olam_post_images">
				<?php
				if ( metadata_exists( 'post', $post->ID, '_olam_post_image_gallery' ) ) {
					$olam_post_image_gallery = get_post_meta( $post->ID, '_olam_post_image_gallery', true );
					$attachments = array_filter( explode( ',', $olam_post_image_gallery ) );
				} 				

				$update_meta = false;

				if ( ! empty( $attachments ) ) { 
					foreach ( $attachments as $attachment_id ) {
						$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
						if ( empty( $attachment ) ) {
							$update_meta = true;

							continue;
						}

						echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
						' . $attachment . '
						<ul class="actions">
						<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'olam' ) . '">' . esc_html__( 'Delete', 'olam' ) . '</a></li>
						</ul>
						</li>';

						$updated_gallery_ids[] = $attachment_id;
					}

					if ( $update_meta ) {
						update_post_meta( $post->ID, '_olam_post_image_gallery', implode( ',', $updated_gallery_ids ) );
					}
				}
				?>
			</ul>

			<input type="hidden" id="olam_post_image_gallery" name="olam_post_image_gallery" value="<?php if(isset($olam_post_image_gallery)){echo esc_attr( $olam_post_image_gallery );} ?>" />

		</div>
		<p class="olam_add_post_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( 'Add Images to Download Gallery', 'olam' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'olam' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'olam' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'olam' ); ?>"><?php _e( 'Add download gallery images', 'olam' ); ?></a>
		</p>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id ) {
		$attachment_ids = isset( $_POST['olam_post_image_gallery'] ) ? array_filter( explode( ',', self::clean_id( $_POST['olam_post_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_olam_post_image_gallery', implode( ',', $attachment_ids ) );
	}

	public static function clean_id( $var ) {

		return is_array( $var ) ? array_map( 'wc_clean', $var ) : sanitize_text_field( $var );

	}
}

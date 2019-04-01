<?php
/**
 * This template is used to display the profile editor with [edd_profile_editor]
 */
global $current_user;
if ( is_user_logged_in() ):
	$user_id      = get_current_user_id();
	$first_name   = get_user_meta( $user_id, 'first_name', true );
	$last_name    = get_user_meta( $user_id, 'last_name', true );
	$display_name = $current_user->display_name;
	$address      = edd_get_customer_address( $user_id );
	if ( edd_is_cart_saved() ): ?>
		<?php $restore_url = add_query_arg( array( 'edd_action' => 'restore_cart', 'edd_cart_token' => edd_get_cart_token() ), edd_get_checkout_uri() ); ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php esc_html_e( 'Saved cart', 'olam'); ?>:</strong> <?php printf( wp_kses(__( 'You have a saved cart, <a href="%s">click here</a> to restore it.', 'olam' ),array('a'=>array('href'=>array()))), esc_url( $restore_url ) ); ?></div>
	<?php endif; ?>
	<?php if ( isset( $_GET['updated'] ) && $_GET['updated'] == true && ! edd_get_errors() ): ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php esc_html_e( 'Success', 'olam'); ?>:</strong> <?php esc_html_e( 'Your profile has been edited successfully.', 'olam' ); ?></div>
	<?php endif; ?>
	<?php edd_print_errors(); ?>
	<?php do_action( 'edd_profile_editor_before' ); ?>
<div class="boxed">
    <div class="boxed-body">
        <div class="lightbox-title"><?php esc_html_e( 'Profile', 'olam' ); ?></div>
		<form id="edd_profile_editor_form" class="edd_form" action="<?php echo edd_get_current_page_url(); ?>" method="post">
			
				<h5 id="edd_profile_name_label"><?php esc_html_e( 'Change your Name', 'olam' ); ?></h5>
                <div class="field-holder">
					<label for="edd_first_name"><?php esc_html_e( 'First Name', 'olam' ); ?></label>
					<input name="edd_first_name" id="edd_first_name" class="text edd-input" type="text" value="<?php echo esc_attr( $first_name ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_last_name"><?php esc_html_e( 'Last Name', 'olam' ); ?></label>
					<input name="edd_last_name" id="edd_last_name" class="text edd-input" type="text" value="<?php echo esc_attr( $last_name ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_display_name"><?php esc_html_e( 'Display Name', 'olam' ); ?></label>
					<select name="edd_display_name" id="edd_display_name" class="select edd-select">
						<?php if ( ! empty( $current_user->first_name ) ): ?>
						<option <?php selected( $display_name, $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->first_name ); ?>"><?php echo esc_html( $current_user->first_name ); ?></option>
						<?php endif; ?>
						<option <?php selected( $display_name, $current_user->user_nicename ); ?> value="<?php echo esc_attr( $current_user->user_nicename ); ?>"><?php echo esc_html( $current_user->user_nicename ); ?></option>
						<?php if ( ! empty( $current_user->last_name ) ): ?>
						<option <?php selected( $display_name, $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->last_name ); ?>"><?php echo esc_html( $current_user->last_name ); ?></option>
						<?php endif; ?>
						<?php if ( ! empty( $current_user->first_name ) && ! empty( $current_user->last_name ) ): ?>
						<option <?php selected( $display_name, $current_user->first_name . ' ' . $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->first_name . ' ' . $current_user->last_name ); ?>"><?php echo esc_html( $current_user->first_name . ' ' . $current_user->last_name ); ?></option>
						<option <?php selected( $display_name, $current_user->last_name . ' ' . $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->last_name . ' ' . $current_user->first_name ); ?>"><?php echo esc_html( $current_user->last_name . ' ' . $current_user->first_name ); ?></option>
						<?php endif; ?>
					</select>
					<?php do_action( 'edd_profile_editor_name' ); ?>
				</div>
				<?php do_action( 'edd_profile_editor_after_name' ); ?>
                <div class="field-holder">
					<label for="edd_email"><?php esc_html_e( 'Email Address', 'olam' ); ?></label>
					<input name="edd_email" id="edd_email" class="text edd-input required" type="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" />
					<?php do_action( 'edd_profile_editor_email' ); ?>
				</div>
				<?php do_action( 'edd_profile_editor_after_email' ); ?>
				<h5 id="edd_profile_billing_address_label"><?php esc_html_e( 'Change your Billing Address', 'olam' ); ?></h5>
                <div class="field-holder">
					<label for="edd_address_line1"><?php esc_html_e( 'Line 1', 'olam' ); ?></label>
					<input name="edd_address_line1" id="edd_address_line1" class="text edd-input" type="text" value="<?php echo esc_attr( $address['line1'] ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_address_line2"><?php esc_html_e( 'Line 2', 'olam' ); ?></label>
					<input name="edd_address_line2" id="edd_address_line2" class="text edd-input" type="text" value="<?php echo esc_attr( $address['line2'] ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_address_city"><?php esc_html_e( 'City', 'olam' ); ?></label>
					<input name="edd_address_city" id="edd_address_city" class="text edd-input" type="text" value="<?php echo esc_attr( $address['city'] ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_address_zip"><?php esc_html_e( 'Zip / Postal Code', 'olam' ); ?></label>
					<input name="edd_address_zip" id="edd_address_zip" class="text edd-input" type="text" value="<?php echo esc_attr( $address['zip'] ); ?>" />
				</div>
                <div class="field-holder">
					<label for="edd_address_country"><?php esc_html_e( 'Country', 'olam' ); ?></label>
					
					<select name="edd_address_country" id="edd_address_country" class="select edd-select" data-nonce="<?php echo wp_create_nonce( 'edd-country-field-nonce' ); ?>">
						<?php foreach( edd_get_country_list() as $key => $country ) : ?>
						<option value="<?php echo esc_attr($key); ?>"<?php selected( $address['country'], $key ); ?>><?php echo esc_html( $country ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
                <div class="field-holder">
					<label for="edd_address_state"><?php esc_html_e( 'State / Province', 'olam' ); ?></label>
					<input name="edd_address_state" id="edd_address_state" class="text edd-input" type="text" value="<?php echo esc_attr( $address['state'] ); ?>" />
				</div>
				<?php do_action( 'edd_profile_editor_address' ); ?>
				<?php do_action( 'edd_profile_editor_after_address' ); ?>
				<h5 id="edd_profile_password_label"><?php esc_html_e( 'Change your Password', 'olam' ); ?></h5>
                <div class="field-holder">
					<label for="edd_user_pass"><?php esc_html_e( 'New Password', 'olam' ); ?></label>
					<input name="edd_new_user_pass1" id="edd_new_user_pass1" class="password edd-input" type="password"/>
				</div>
                <div class="field-holder">
					<label for="edd_user_pass"><?php esc_html_e( 'Re-enter Password', 'olam' ); ?></label>
					<input name="edd_new_user_pass2" id="edd_new_user_pass2" class="password edd-input" type="password"/>
					<?php do_action( 'edd_profile_editor_password' ); ?>
				</div>
				<p class="edd_password_change_notice"><?php esc_html_e( 'Please note after changing your password, you must log back in.', 'olam' ); ?></p>
				<?php do_action( 'edd_profile_editor_after_password' ); ?>
				<input type="hidden" name="edd_profile_editor_nonce" value="<?php echo wp_create_nonce( 'edd-profile-editor-nonce' ); ?>"/>
				<input type="hidden" name="edd_action" value="edit_user_profile" />
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( edd_get_current_page_url() ); ?>" />
				<input name="edd_profile_editor_submit" id="edd_profile_editor_submit" type="submit" class="btn btn-white btn-md" value="<?php esc_html_e( 'Save Changes', 'olam' ); ?>"/>
			
		</form><!-- #edd_profile_editor_form -->
	</div>
</div>
	<?php do_action( 'edd_profile_editor_after' ); ?>
		
	<?php
else:
	echo '<h6 class="text-center">' . esc_html__( 'You need to login to edit your profile.', 'olam' ) . '</h6> <p>&nbsp;</p>';
	echo edd_login_form();
endif;

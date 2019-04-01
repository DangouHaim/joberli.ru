<?php
/**
 * This template is used to display the login form with [edd_login]
 */
global $edd_login_redirect;
if ( ! is_user_logged_in() ) :

	// Show any error messages after form submission
	edd_print_errors(); ?>
		
		<div class="boxed">
	        <div class="boxed-body">
	            <div class="lightbox-title"><?php esc_html_e( 'Login', 'olam' ); ?></div>
	            <?php do_action( 'edd_login_fields_before' ); ?>
	            <form id="edd_login_form" class="edd_form" method="post">
	                <div class="field-holder">
	                    <label for="edd_user_login"><i class="demo-icon icon-mail-alt"></i> <?php esc_html_e( 'Username', 'olam' ); ?></label>
	                    <input name="edd_user_login" id="edd_user_login" class="required edd-input" type="text" title="<?php esc_html_e( 'Username', 'olam' ); ?>"/>
	                </div>
	                <div class="field-holder">
	                    <label for="edd_user_pass"><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e( 'Password', 'olam' ); ?></label>
	                    <input name="edd_user_pass" id="edd_user_pass" class="password required edd-input" type="password"/>
	                </div>
	                <div class="btn-pro-frame">
					<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_login_redirect ); ?>"/>
					<input type="hidden" name="edd_login_nonce" value="<?php echo wp_create_nonce( 'edd-login-nonce' ); ?>"/>
					<input type="hidden" name="edd_action" value="user_login"/>
					<input id="edd_login_submit" type="submit" class="btn btn-md btn-white" value="<?php esc_html_e( 'Log In', 'olam' ); ?>"/>
					<span class="btn-pro"><img src="<?php echo get_template_directory_uri(); ?>/img/reload.gif"></span>
					</div>
	            </form>

				<p class="edd-lost-password">
					<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_html_e( 'Lost Password', 'olam' ); ?>">
						<?php esc_html_e( 'Lost Password?', 'olam' ); ?>
					</a>
				</p>
				<?php do_action( 'edd_login_fields_after' ); ?>
				</div>
			</div>

<?php else : ?>
		<h6 class="text-center">
        	<?php esc_html_e( 'You are already logged in', 'olam' ); ?>
	    </h6>
<?php endif; ?>

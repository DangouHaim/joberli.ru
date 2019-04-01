<?php
/**
 * This template is used to display the registration form with [edd_register]
 */
global $edd_register_redirect;

edd_print_errors(); ?>

<div class="boxed">
    <div class="boxed-body">
        <div class="lightbox-title"><?php esc_html_e( 'Register', 'olam' ); ?></div>
        <form id="edd_register_form" class="edd_form" method="post">
        	<?php do_action( 'edd_register_form_fields_top' ); ?>
			<?php do_action( 'edd_register_form_fields_before' ); ?>
            <!-- additional fields end - LJ -->  
            <div class="field-holder">
                <label for="edd-user-login"><i class="demo-icon icon-mail-alt"></i> <?php esc_html_e( 'Username', 'olam' ); ?></label>
                <input id="edd-user-login" class="required edd-input" type="text" name="edd_user_login" title="<?php esc_attr_e( 'Username', 'olam' ); ?>" />
            </div>
            <div class="field-holder">
                <label for="edd-user-email"><i class="demo-icon icon-mail-alt"></i> <?php esc_html_e( 'Email', 'olam' ); ?></label>
				<input id="edd-user-email" class="required edd-input" type="email" name="edd_user_email" title="<?php esc_attr_e( 'Email Address', 'olam' ); ?>" />
            </div>
            <div class="field-holder">
                <label for="edd-user-pass"><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e( 'Password', 'olam' ); ?></label>
				<input id="edd-user-pass" class="password required edd-input" type="password" name="edd_user_pass" />
            </div>
            <div class="field-holder">
                <label for="edd-user-pass2"><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e( 'Confirm Password', 'olam' ); ?></label>
				<input id="edd-user-pass2" class="password required edd-input" type="password" name="edd_user_pass2" />
            </div>
			<input type="hidden" name="edd_honeypot" value="" />
			<input type="hidden" name="edd_action" value="user_register" />
			<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_register_redirect ); ?>"/>
			<input class="btn btn-md btn-white" name="edd_register_submit" type="submit" value="<?php esc_attr_e( 'Register', 'olam' ); ?>" />
			<?php do_action( 'edd_register_form_fields_after' ); ?>
			<?php do_action( 'edd_register_form_fields_bottom' ); ?>
        </form>
    </div>
</div>
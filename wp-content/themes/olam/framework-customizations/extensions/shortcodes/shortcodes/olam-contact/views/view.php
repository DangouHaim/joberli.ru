<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<form class="olam-contact">
	<div class="contact-success alert alert-success">
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="input-holder field-holder">
				<div class="olam-c-name form-alert"></div>
				<label><i class="demo-icon icon-user"></i> <?php esc_html_e('Name','olam'); ?> </label>
				<input name="c-name" id="c-name" type="text" placeholder="<?php esc_html_e('Name','olam'); ?> ">
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-holder field-holder">
				<div class="olam-c-email form-alert"></div>
				<label><i class="demo-icon icon-mail-alt"></i> <?php esc_html_e('Email','olam'); ?> </label>
				<input name="c-email" id="c-email" type="email" placeholder="<?php esc_html_e('Email','olam'); ?> ">
			</div>
		</div>
		<div class="col-md-12">
			<div class="input-holder field-holder">
				<div class="olam-c-message form-alert"></div>
				<textarea name="c-message" id="c-message" cols="30" rows="3" placeholder="<?php esc_html_e('Message','olam'); ?> "></textarea>
				<label><i class="demo-icon icon-comment-alt"></i> <?php esc_html_e('Message','olam'); ?> </label>
			</div>
		</div>
		<div class="col-md-12"><input type="submit" value="<?php esc_html_e('Send','olam'); ?> " class="btn btn-primary"></div>
	</div>
</form>
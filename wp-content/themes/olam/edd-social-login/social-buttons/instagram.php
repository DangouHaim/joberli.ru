<?php
/**
 * Instagram Button Template
 * 
 * Handles to load instagram button template
 * 
 * Override this template by copying it to yourtheme/edd-social-login/social-buttons/instagram.php
 * 
 * @package Easy Digital Downloads - Social Login
 * @since 1.4.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
//show instagram button
?>
<div class="edd-slg-login-wrapper">
	<a title="<?php _e( 'Connect with Instagram', 'eddslg');?>" href="javascript:void(0);" class="edd-slg-social-login-instagram">
		<img src="<?php echo get_template_directory_uri();?>/img/instagram.png" alt="<?php _e( 'Instagram', 'eddslg');?>" />
	</a>
</div>
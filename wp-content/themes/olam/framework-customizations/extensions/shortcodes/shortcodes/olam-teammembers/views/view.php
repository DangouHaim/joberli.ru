<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<div class="team-member">
	<div class="team-item featured">
	<?php 
	if(isset($atts['teamimage']['url'])){ $altTag= get_post_meta($atts['teamimage']['attachment_id'], '_wp_attachment_image_alt', true); ?>	<div class="team-img"><img src="<?php echo esc_url($atts['teamimage']['url']); ?>" alt="<?php echo esc_attr($altTag); ?>"></div><?php } ?>
		<div class="member-details">
			<?php if(isset($atts['teamname'])){ ?><h5><?php echo esc_html($atts['teamname']); ?></h5><?php } ?>
			<?php if(isset($atts['teamdesig'])){ ?><span><?php echo esc_html($atts['teamdesig']); ?></span><?php } ?>
			<ul class="social">
			<?php if(isset($atts['teamfb'])){ ?>	<li class="social-facebook"><a href="<?php echo esc_url($atts['teamfb']); ?>" ><span class="icon"><i class="demo-icon icon-facebook"></i></span></a></li><?php } ?>
			<?php if(isset($atts['teamtwitter'])){ ?>	<li class="social-twitter"><a href="<?php echo esc_url($atts['teamtwitter']); ?>" ><span class="icon"><i class="demo-icon icon-twitter"></i></span></a></li><?php } ?>
			<?php if(isset($atts['teamgplus'])){ ?>	<li class="social-google"><a href="<?php echo esc_url($atts['teamgplus']); ?>" ><span class="icon"><i class="demo-icon icon-gplus"></i></span></a></li><?php } ?>
			</ul>
		</div>
	</div>
</div>
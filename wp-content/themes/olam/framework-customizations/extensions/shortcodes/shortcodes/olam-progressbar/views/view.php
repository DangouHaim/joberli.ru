<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<?php if(isset($atts['progresstitle'])){ ?> <h5><?php echo esc_html($atts['progresstitle']); ?></h5> <?php } ?>
<?php if(isset($atts['progressdesc'])){ ?><p><?php echo esc_html($atts['progressdesc']); ?></p> <?php } ?>
<p>&nbsp;</p>
<?php foreach ($atts['progress'] as $progress => $progressValue) { ?>
<div class="progress-bars">
	<div class="progress">
		<div class="progress-bar" data-width="<?php echo esc_attr(($progressValue['percentage'])); ?>">
		</div>
	</div>
	<?php if(isset($progressValue['title'])) { ?><p><?php echo esc_html($progressValue['title']) ; ?></p> <?php } ?>
</div>
<?php } ?>

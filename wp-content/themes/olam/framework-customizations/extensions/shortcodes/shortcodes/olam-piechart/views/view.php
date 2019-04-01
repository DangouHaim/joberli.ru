<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<div class="chart-wrap">
	<div class="chart" data-percent="<?php echo esc_attr($atts['piechartvalue']);?>"><span class="percent"><?php echo esc_html($atts['piechartvalue']);?> %</span></div>
	<?php if(isset($atts['title'])){ ?><h5><?php echo esc_html($atts['title']); ?> </h5> <?php } ?>
	<?php if(isset($atts['description'])){ ?><p><?php echo esc_html($atts['description']); ?> </p><?php } ?>
</div>
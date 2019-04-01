<?php if (!defined('FW')) die( 'Forbidden' ); ?>
<?php $color_class = !empty($atts['color']) ? "fw-btn-{$atts['color']}" : ''; ?>
<?php $align_class = !empty($atts['align']) ? $atts['align']: ''; ?>
<a href="<?php echo esc_url($atts['link']); ?>" target="<?php echo esc_attr($atts['target']); ?>" class="fw-btn <?php echo esc_attr($color_class)." ".$align_class; ?>">
	<span><?php echo esc_html($atts['label']); ?></span>
</a>
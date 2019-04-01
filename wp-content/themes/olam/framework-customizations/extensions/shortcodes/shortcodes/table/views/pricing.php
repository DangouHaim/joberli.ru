<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var array $atts
 */
$class_width = 'fw-col-md-' . ceil(12 / count($atts['table']['cols']));
?>
<div class="fw-pricing">
	<?php foreach ($atts['table']['cols'] as $col_key => $col): ?>
	<?php $colattr=$class_width . ' ' . $col['name']; ?>
		<div class="fw-package-wrap <?php echo esc_attr($colattr); ?> ">
			<div class="fw-package">
				<?php
				 foreach ($atts['table']['rows'] as $row_key => $row): ?>
					<?php if( $col['name'] == 'desc-col' ) : ?>
						<div class="fw-default-row">
							<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
							<?php echo esc_html($value); ?>
						</div>
					<?php continue; endif; ?>
					<?php if ($row['name'] === 'heading-row'): ?>
						<div class="fw-heading-row">
							<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
							<span>
								<?php echo (empty($value) && $col['name'] === 'desc-col') ? '&nbps;' : $value; ?>
							</span>
						</div>
					<?php elseif ($row['name'] === 'pricing-row'): ?>
						<div class="fw-pricing-row">
							<div class="package-table-price">
								<?php $amount = $atts['table']['content'][$row_key][$col_key]['amount'] ?>
								<?php $desc   = $atts['table']['content'][$row_key][$col_key]['description']; ?>
								<?php $currency   = $atts['table']['content'][$row_key][$col_key]['currency']; ?>
								<div class="package-price">
									<span><?php echo (empty($value) && $col['name'] === 'desc-col') ? '&nbps;' : $currency; ?></span><!-- 
									--><?php echo (empty($value) && $col['name'] === 'desc-col') ? '&nbps;' : $amount; ?>
								</div>
								<p>
									<?php echo (empty($value) && $col['name'] === 'desc-col') ? '&nbps;' : $desc; ?>
								</p>
							</div>
						</div>
					<?php elseif ( $row['name'] == 'button-row' ) : ?>
						<?php $button = fw_ext( 'shortcodes' )->get_shortcode( 'button' ); ?>
							<div class="fw-button-row">
								<?php if ( false === empty( $atts['table']['content'][ $row_key ][ $col_key ]['button'] ) and false === empty($button) ) : ?>
									<?php //echo esc_html($button->render($atts['table']['content'][ $row_key ][ $col_key ]['button'])); ?>
								<?php echo wp_kses($button->render($atts['table']['content'][ $row_key ][ $col_key ]['button']),array('a'=>array('href'=>array(),'target'=>array(),"class"=>array(),"title"=>array()),'span'=>array()) ); ?>
								<?php else : ?>
									<span>&nbsp;</span>
								<?php endif; ?>
							</div>
					<?php elseif ($row['name'] === 'switch-row') : ?>
						<div class="fw-switch-row">
							<?php $value = $atts['table']['content'][$row_key][$col_key]['switch']; ?>
							<span>
								<i class="fa fw-price-icon-<?php echo esc_attr($value); ?>"></i>
							</span>
						</div>
					<?php elseif ($row['name'] === 'default-row') : ?>
						<div class="fw-default-row">
							<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
							<?php echo wp_kses_post($value); ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
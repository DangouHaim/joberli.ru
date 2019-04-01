<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<div class="row">
	<div id="testimonials">
		<ul class="slides testimonial-carousel">
			<?php foreach ($atts['testimonials'] as $testKey => $testValue) { ?>
			<li class="slider-item">
				<div class="testimonial-item">

					<?php if(isset($testValue['author_avatar']['url'])){ ?><div class="tc-avatar"><img src="<?php echo esc_url($testValue['author_avatar']['url']); ?>" alt=""></div> <?php } ?>
					<div class="tc-content">
						<div class="testimonial-contens">
							<span class="quote-icon"><i class="fa fa-quote-left"></i></span>
							<?php if(isset($testValue['content'])){ ?><p>"<?php echo strip_tags($testValue['content']);  ?>"</p> <?php } ?>
							<?php if(isset($testValue['author_name'])){ ?><div class="tc-name"><?php echo esc_html($testValue['author_name']); ?></div> <?php } ?>
							<?php if(isset($testValue['designation'])){ ?><span><?php echo esc_html($testValue['designation']); ?></span> <?php } ?>
						</div>
					</div>

				</div>
			</li>
			<?php }  ?>             	
		</ul>
	</div>
</div>
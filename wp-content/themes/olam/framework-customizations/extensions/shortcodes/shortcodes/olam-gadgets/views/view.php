<?php if (!defined('FW')) die('Forbidden');
/**

 * @var $atts The shortcode attributes

 */
?>
<?php if(isset($atts['gadgettitle'])&& (strlen($atts['gadgettitle'])>0) ){ ?> <h5><?php echo esc_html($atts['gadgettitle']); ?></h5> <?php } ?>
<?php if(isset($atts['gadgetdesc']) && (strlen($atts['gadgetdesc'])>0)){ ?><p><?php echo esc_html($atts['gadgetdesc']); ?></p> <?php } ?>
<div class="system-bars-wrap">
<?php foreach ($atts['gadgets'] as $gadget => $gadgetValue) { ?>
    <div class="system-bars <?php echo esc_attr($gadgetValue['gadgettype']);?>-bar">
        <div class="progress-counter"><?php echo ($gadgetValue['percentage']) ; ?>%</div>
        <div class="bar-wrap">
            <div class="v-progress-holder">
                <div class="v-progress" data-height="<?php echo ($gadgetValue['percentage']) ; ?>" style="height: <?php echo ($gadgetValue['percentage']) ; ?>%;"></div>
            </div>
        </div>
        <p><?php echo ($gadgetValue['title']) ; ?></p>
    </div>
    <?php } ?>
    <span class="clearfix"></span>
</div>



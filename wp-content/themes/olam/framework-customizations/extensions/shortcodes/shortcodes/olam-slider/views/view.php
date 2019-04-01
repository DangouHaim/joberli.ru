<?php if (!defined('FW')) die('Forbidden');
/**
 * @var $atts The shortcode attributes
 */
?>
<?php
if(strlen($atts['slider_shortcode'])>0 && $atts['rev_priority']==1 ){
	echo do_shortcode($atts['slider_shortcode']);
}
else if(strlen($atts['slider'])>0 ){
	$slider=$atts['slider'];
	echo do_shortcode('[rev_slider alias="'.$slider.'"]');
}







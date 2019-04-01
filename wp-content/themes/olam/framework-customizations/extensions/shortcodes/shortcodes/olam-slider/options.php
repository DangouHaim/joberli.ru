<?php if (!defined('FW')) die('Forbidden');
  
$sliderArray=olam_get_rev_sliders();

$slideDesc=(isset($sliderArray)&& count($sliderArray)>0)?esc_html__("Select the rev slider to insert","olam"):esc_html__("You have not set any slider!","olam");

$options= array(
	'slider'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Rev-Slider', 'olam'),
		'choices' => $sliderArray,
		'desc'    => $slideDesc,
		),
	'slider_shortcode'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Slider ShortCode', 'olam'),
		'desc'    =>  esc_html__('Enter the Slider ShortCode', 'olam'),
		),
	'rev_priority' =>array(
		'type'  => 'checkbox',
		'label' => esc_html__("Use Slider ShortCode instead of Rev Slider","olam"),
		'desc'  => esc_html__('If checked, Slider shortcode get more priority than Rev Slider.(Unchecked means priority for Rev slider)','olam'),
		),
	'fluid' =>array(
		'type'  => 'checkbox',
		'label' => esc_html__("Fluid Navigation","olam"),
		'desc'  => esc_html__('Enable Fluid Navigation','olam')
		)
	);


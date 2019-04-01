<?php if (!defined('FW')) {
	die('Forbidden');
}
$options = array(
	
	'title' => array(
		'label' => esc_html__('Section Title', 'olam'),
		'desc'  => esc_html__('Please type the section title', 'olam'),
		'type'  => 'text',
		),
	'smalltitle' => array(
		'label' => esc_html__('Make this a small title', 'olam'),
		'desc'  => esc_html__('Make this a small title', 'olam'),
		'type'  => 'checkbox',
		),
	'dark_overlay' => array(
		'label' => esc_html__('Check this to enable dark overlay', 'olam'),
		'desc'  => esc_html__('Check this to enable dark overlay', 'olam'),
		'type'  => 'checkbox',
		),
	'parallax_section' => array(
		'label' => esc_html__('Check this to enable parallax section', 'olam'),
		'desc'  => esc_html__('Check this to enable parallax section', 'olam'),
		'type'  => 'checkbox',
		),
	'full_height' => array(
		'label' => esc_html__('Make this section a full height section', 'olam'),
		'desc'  => esc_html__('Make this section a full height section', 'olam'),
		'type'  => 'checkbox',
		),
	'remove_padding' => array(
		'label' => esc_html__('Remove top and bottom padding', 'olam'),
		'desc'  => esc_html__('Check this to remove top and bottom padding', 'olam'),
		'type'  => 'checkbox',
		),
	'description' => array(
		'label' => esc_html__('Section Description', 'olam'),
		'desc'  => esc_html__('Please type  section description', 'olam'),
		'type'  => 'textarea',
		),
	'is_fullwidth' => array(
		'label'        => esc_html__('Full Width', 'olam'),
		'type'         => 'switch',
		),
	'background_color' => array(
		'label' => esc_html__('Background Color', 'olam'),
		'desc'  => esc_html__('Please select the background color', 'olam'),
		'type'  => 'color-picker',
		),
	'textcolor' => array(
		'label' => esc_html__('Text Color', 'olam'),
		'desc'  => esc_html__('Please select the text color', 'olam'),
		'type'  => 'color-picker',
		),
	'background_image' => array(
		'label'   => esc_html__('Background Image', 'olam'),
		'desc'    => esc_html__('Please select the background image', 'olam'),
		'type'    => 'background-image',
		'choices' => array(//	in future may will set predefined images
			)
		),
	'video' => array(
		'label' => esc_html__('Background Video', 'olam'),
		'desc'  => esc_html__('Insert Video URL to embed this video', 'olam'),
		'type'  => 'text',
		),
	'customcss' => array(
		'label' => esc_html__('Custom Css Class', 'olam'),
		'desc'  => esc_html__('Please type the custom css class', 'olam'),
		'type'  => 'text',
		),
	);

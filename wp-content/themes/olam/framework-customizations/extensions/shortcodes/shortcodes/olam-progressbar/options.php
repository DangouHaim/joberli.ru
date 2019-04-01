<?php if (!defined('FW')) die('Forbidden');
$options = array(
		'progresstitle'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Title', 'olam'),
		'desc'  =>esc_html__("Section Title","olam"),
		),
	'progressdesc'   => array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'olam'),
		'desc'  =>esc_html__("Section Description","olam"),
		),    
	'progress' => array(
		'label'         => esc_html__( 'Progress Bar', 'olam' ),
		'popup-title'   => esc_html__( 'Add/Edit Progress Bar', 'olam' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your Progress Bar.', 'olam' ),
		'type'          => 'addable-popup',
		'template'      => '{{=title}}',
		'popup-options' => array(
	'title'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Title', 'olam'),
		'desc'  =>esc_html__("Progress Bar Title","olam"),
		),
	'percentage'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Percentage', 'olam'),
		'desc'  =>esc_html__("Percentage","olam"),
		),
	)
));

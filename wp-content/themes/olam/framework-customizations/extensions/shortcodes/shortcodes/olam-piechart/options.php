<?php if (!defined('FW')) die('Forbidden');
$options= array(
	'piechartvalue'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Pie Chart Value', 'olam'),
		'desc'  =>esc_html__("Pie Chart Value","olam"),
		),
	'title'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Title', 'olam'),
		'desc'  =>esc_html__("Title","olam"),
		),
	'description'   => array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'olam'),
		'desc'  =>esc_html__("Description","olam"),
		),
	);

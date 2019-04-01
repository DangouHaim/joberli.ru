<?php if (!defined('FW')) die('Forbidden');
$options= array(
	'title'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Title', 'olam'),
		'desc'  =>esc_html__("Search Section Title","olam"),
		),
	'description'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Description', 'olam'),
		'desc'  =>esc_html__("Search Section Description","olam"),
		),
	'counter1title'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Counter 1 Title', 'olam'),
		'desc'  =>esc_html__("Counter 1 Title","olam"),
		),
	'counter1count'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Counter 1 Count', 'olam'),
		'desc'  =>esc_html__("Counter 1 Count","olam"),
		),
	'counter2title'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Counter 2 Title', 'olam'),
		'desc'  =>esc_html__("Counter 2 Title","olam"),
		),
	'counter2count'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Counter 2 Count', 'olam'),
		'desc'  =>esc_html__("Counter 2 Count","olam"),
		),
	'searchtext'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Search Box Text', 'olam'),
		'desc'  =>esc_html__("Search Box Text","olam"),
		"value"=>esc_html__("Search","olam")
		),
	'enablecats'   => array(
		'type'    => 'checkbox',
		'label'   => esc_html__('Enable Categories Dropdown', 'olam'),
		'desc'  =>esc_html__("Enable Categories Dropdown","olam"),
		"value"=>esc_html__("Enable Categories Dropdown","olam")
		),
	);

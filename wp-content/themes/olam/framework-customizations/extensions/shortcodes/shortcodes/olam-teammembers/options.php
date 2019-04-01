<?php if (!defined('FW')) die('Forbidden');



$options= array(

	'teamname'   => array(

		'type'    => 'text',

		'label'   => esc_html__('Name', 'olam'),

		'desc'  =>esc_html__("Team Member Name","olam"),

		),

	'teamdesig'   => array(

		'type'    => 'text',

		'label'   => esc_html__('Designation', 'olam'),

		'desc'  =>esc_html__("Team Member Name","olam"),

		),

	'teamimage'   => array(

		'type'    => 'upload',

		'label'   => esc_html__('Image', 'olam'),

		'desc'  =>esc_html__("Team Member Image","olam"),

		),

	'teamfb'   => array(

		'type'    => 'text',

		'label'   => esc_html__('Facebook', 'olam'),

		'desc'  =>esc_html__("Team Member Facebook Url","olam"),

		),

	'teamtwitter'   => array(

		'type'    => 'text',

		'label'   => esc_html__('Twitter', 'olam'),

		'desc'  =>esc_html__("Team Member Twitter Url","olam"),

		),

	'teamgplus'   => array(

		'type'    => 'text',

		'label'   => esc_html__('Google Plus', 'olam'),

		'desc'  =>esc_html__("Team Member Google Plus Url","olam"),

		),

	

	);




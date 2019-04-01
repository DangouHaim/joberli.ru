<?php if (!defined('FW')) die('Forbidden');
$options = array(
	'gadgettitle'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Title', 'olam'),
		'desc'  =>esc_html__("Gadget Section Title","olam"),
		),
	'gadgetdesc'   => array(
		'type'    => 'textarea',
		'label'   => esc_html__('Description', 'olam'),
		'desc'  =>esc_html__("Gadget Section Description","olam"),
		),                   
	'gadgets' => array(
		'label'         => esc_html__( 'Gadgets', 'olam' ),
		'popup-title'   => esc_html__( 'Add/Edit Gadgets', 'olam' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your Gadgets.', 'olam' ),
		'type'          => 'addable-popup',
		'template'      => '{{=title}}',
		'popup-options' => array(
			'title'   => array(
				'type'    => 'text',
				'label'   => esc_html__('Title', 'olam'),
				'desc'  =>esc_html__("Gadgets Title","olam"),
				),
			'percentage'   => array(
				'type'    => 'text',
				'label'   => esc_html__('Percentage', 'olam'),
				'desc'  =>esc_html__("Percentage","olam"),
				),                   
			'gadgettype'   => array(
				'type'    => 'select',
				'label'   => esc_html__('Product Listing Type', 'olam'),
				'choices' => array(
					'pc' => esc_html__('PC', 'olam'),
					'tab' => esc_html__('Tablet', 'olam'),                    	
					'mob' => esc_html__('Mobile', 'olam'),
					)
				),
			)
	));

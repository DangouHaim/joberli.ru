<?php if (!defined('FW')) die('Forbidden');

$options= array(
	'producttype'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Product Listing Type', 'olam'),
		'choices' => array(
			'best_selling' 	   => esc_html__('Best Selling', 'olam'),
			'featured' => esc_html__('Featured Products', 'olam'),
			'top_rated' 		   => esc_html__('Top Rated Products', 'olam'),
			'recent'  => esc_html__('Recent Products', 'olam'),
			'sale' 		   => esc_html__('On Sale', 'olam')
			)
		),
	'productcount' => array(
		'label'   => esc_html__('Product Count', 'olam'),
		'desc'    => esc_html__('Product Count', 'olam'),
		'type'    => 'text',
		'value'	  => '',
		)

	);

<?php if (!defined('FW')) die('Forbidden');
$options = array(
	'testimonials' => array(
		'label'         => esc_html__( 'Testimonials', 'olam' ),
		'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'olam' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your Testimonials.', 'olam' ),
		'type'          => 'addable-popup',
		'template'      => '{{=author_name}}',
		'popup-options' => array(
			'content'       => array(
				'label' => esc_html__( 'Quote', 'olam' ),
				'desc'  => esc_html__( 'Enter the testimonial here', 'olam' ),
				'type'  => 'wp-editor',
				'teeny' => true
				),
			'author_avatar' => array(
				'label' => esc_html__( 'Image', 'olam' ),
				'desc'  => esc_html__( 'Either upload a new, or choose an existing image from your media library', 'olam' ),
				'type'  => 'upload',
				),
			'author_name'   => array(
				'label' => esc_html__( 'Name', 'olam' ),
				'desc'  => esc_html__( 'Enter the Name of the Person to quote', 'olam' ),
				'type'  => 'text'
				),
			'designation'   => array(
				'label' => esc_html__( 'Designation', 'olam' ),
				'desc'  => esc_html__( 'Enter the designation of the Person to quote', 'olam' ),
				'type'  => 'text'
				),
			'date'    => array(
				'label' => esc_html__( 'Date', 'olam' ),
				'desc'  => esc_html__( 'Date', 'olam' ),
				'type'  => 'date-picker',
				'min-date'=>'10-10-1990'
				),
			)
		)
);
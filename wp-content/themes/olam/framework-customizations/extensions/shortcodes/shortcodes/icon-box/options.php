<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Box Style', 'olam'),
		'choices' => array(
			'olam-iconbox-1' => esc_html__('Icon above title', 'olam'),
			'olam-iconbox-2' => esc_html__('Icon in line with title', 'olam')
			)
		),
	'icon'    => array(
		'type'  => 'icon',
		'label' => esc_html__('Choose an Icon', 'olam'),
		),
	'iconcolor'    => array(
		'type'  => 'color-picker',
		'label' => esc_html__('Icon Color', 'olam'),
		'value' =>"#333"
		),
	'title'   => array(
		'type'  => 'text',
		'label' => esc_html__( 'Title of the Box', 'olam' ),
		),

	'content' => array(
		'type'  => 'textarea',
		'label' => esc_html__( 'Content', 'olam' ),
		'desc'  => esc_html__( 'Enter the desired content', 'olam' ),
		),
	);
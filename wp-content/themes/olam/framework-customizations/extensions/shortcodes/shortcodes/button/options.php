<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'label'  => array(
		'label' => esc_html__( 'Button Label', 'olam' ),
		'desc'  => esc_html__( 'This is the text that appears on your button', 'olam' ),
		'type'  => 'text',
		'value' => 'Submit'
	),
	'link'   => array(
		'label' => esc_html__( 'Button Link', 'olam' ),
		'desc'  => esc_html__( 'Where should your button link to', 'olam' ),
		'type'  => 'text',
		'value' => '#'
	),
	'target' => array(
		'type'  => 'switch',
		'label'   => esc_html__( 'Open Link in New Window', 'olam' ),
		'desc'    => esc_html__( 'Select here if you want to open the linked page in a new window', 'olam' ),
		'right-choice' => array(
			'value' => '_blank',
			'label' => esc_html__('Yes', 'olam'),
		),
		'left-choice' => array(
			'value' => '_self',
			'label' => esc_html__('No', 'olam'),
		),
	),
	'color'  => array(
		'label'   => esc_html__( 'Button Color', 'olam' ),
		'desc'    => esc_html__( 'Choose a color for your button', 'olam' ),
		'type'    => 'select',
		'choices' => array(
			'primary' => esc_html__( 'Primary', 'olam' ),
			'secondary'  => esc_html__( 'Secondary', 'olam' ),
			'light' => esc_html__( 'Light', 'olam' ),
		)
	),
		'align'  => array(
		'label'   => esc_html__( 'Button Align', 'olam' ),
		'desc'    => esc_html__( 'Choose the alignment of your button', 'olam' ),
		'type'    => 'select',
		'choices' => array(		
			'left' => esc_html__( 'Left', 'olam' ),
			'right'  => esc_html__( 'Right', 'olam' ),
			'center' => esc_html__( 'Center', 'olam' ),
		)
	),
);
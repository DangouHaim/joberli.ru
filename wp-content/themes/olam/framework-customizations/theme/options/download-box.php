<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'downloadoptions' => array(
		'title'   => esc_html__( 'Download Options', 'olam' ),
		'type'    => 'tab',
		'options' => array(
			fw()->theme->get_options( 'download-options' ),
			),
		),
	);
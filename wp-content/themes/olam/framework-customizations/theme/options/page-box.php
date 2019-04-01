<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'pageoptions' => array(
		'title'   => esc_html__( 'Page Options', 'olam' ),
		'type'    => 'tab',
		'options' => array(
			fw()->theme->get_options( 'page-options' ),
			),
		),
	);
<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'postoptions' => array(
		'title'   => esc_html__( 'Post Options', 'olam' ),
		'type'    => 'tab',
		'options' => array(
			fw()->theme->get_options( 'post-options' ),
			),
		),
	);
<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'main' => array(
		'title'   => 'Page Options',
		'type'    => 'box',
		'options' => array(
			fw()->theme->get_options( 'page-box' ),
		),
	),
);
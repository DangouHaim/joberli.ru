<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$cfg = array();
$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Table', 'olam' ),
	'description' => esc_html__( 'Add a Table', 'olam' ),
	'tab'         => esc_html__( 'Content Elements', 'olam' ),
	'popup_size'  => 'large'
);
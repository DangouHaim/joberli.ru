<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'olam_post_alttitle' => array(
		'label' => esc_html__( 'Post Alternate title', 'olam' ),
		'type'  => 'text',
		'desc'  => esc_html__( 'Alternate post title. This will override the default post title, keep blank if not needed','olam' ),
		),
	);

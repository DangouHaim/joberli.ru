<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

		'download_features' => array(
			'label'         => esc_html__( 'Item Features', 'olam' ),
			'type'          => 'addable-popup',
			'desc'          => esc_html__( 'Download item features that should be shown in the item download feature sidebar widget',
				'olam' ),
			'template'      => '{{- feature_name }}',
			'popup-options' => array(
				'feature_name'  => array(
					'label' => esc_html__( 'Feature Name', 'olam' ),
					'type'  => 'text',				
					'desc'  => esc_html__( 'Add a feature name',
						'olam' ),
					),
				'feature_value'         => array(
					'label' => esc_html__( 'Feature Value', 'olam' ),
					'type'  => 'text',
					'desc'  => esc_html__( 'Add a feature value',
						'olam' ),
					),

				),
		),
		'olam_download_alttitle' => array(
		'label' => esc_html__( 'Download Alternate title', 'olam' ),
		'type'  => 'text',
		'desc'  => esc_html__( 'Alternate download title. This will override the default download title, keep blank if not needed','olam' ),
		),

	);

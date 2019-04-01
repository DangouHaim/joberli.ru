<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'olam_page_subtitle' => array(
		'label' => esc_html__( 'Page Subtitle', 'olam' ),
		'type'  => 'text',
		'desc'  => esc_html__( 'Enter the subtitle','olam' ),
		),
	'olam_page_alttitle' => array(
		'label' => esc_html__( 'Page Alternate title', 'olam' ),
		'type'  => 'text',
		'desc'  => esc_html__( 'Alternate page title. This will override the default page title, keep blank if not needed','olam' ),
		),
	'olam_enable_header_search' => array(
		'label' => esc_html__( 'Enable header search section', 'olam' ),
		'type'  => 'checkbox',
		'desc'  => esc_html__( 'Enter header search section','olam' ),
		),
	'olam_disable_inner_page_heading' => array(
		'label' => esc_html__( 'Disable Page Heading', 'olam' ),
		'type'  => 'checkbox',
		'desc'	=> esc_html__( 'Hide "inner_page_heading" class, which is used for page Heading','olam' ),
		),
	'olam_transparent_header_overlay' => array(
		'label' => esc_html__( 'Header overlay', 'olam' ),
		'type'  => 'checkbox',
		'desc'  => esc_html__( 'Enable Header overlay 
					(Normally we use this option with - page builder "section" and its option "Remove top and bottom padding" as checked,    
					section backgeround or image,slider etc.. element inside this section - as the first page element.
				    Then the Header Lay above the first page element, also it removes Header bottom section.)','olam' ),
		),
	);

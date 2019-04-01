<?php if (!defined('FW')) die('Forbidden');

$downloadCategories=get_terms('download_category');
$catArray=array();
$catArray['all']=esc_html__("All","olam");
foreach ($downloadCategories as $dkey => $dvalue) {
	$catArray[$dvalue->term_id]=$dvalue->name;
}

$options= array(
	'noposts'   => array(
		'type'    => 'text',
		'label'   => esc_html__('Number of Posts', 'olam'),
		'desc'  =>esc_html__("Number Of posts","olam"),
	),
	'viewmore'   => array(
		'type'    => 'text',
		'label'   => esc_html__('View More Link', 'olam'),
		'desc'  =>esc_html__("View More Link","olam"),
	),
	'viewmoretext'   => array(
		'type'    => 'text',
		'label'   => esc_html__('View More Text', 'olam'),
		'desc'  =>esc_html__("View More Text","olam"),
	),
	'listingorslider'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Download Listing Type', 'olam'),
		'choices' => array(
			'listing'  => esc_html__('Listing', 'olam'),
			'slider' => esc_html__('Slider', 'olam'),
		)
	),
	'listingcolumn'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Download Listing Column', 'olam'),
		'choices' => array(
			'col-1'  	=> esc_html__('Column 1', 'olam'),
			'col-2' 	=> esc_html__('Column 2', 'olam'),
			'col-3'  	=> esc_html__('Column 3', 'olam'),
			'col-4' 	=> esc_html__('Column 4', 'olam'),
			'col-5'  	=> esc_html__('Column 5', 'olam'),
			'col-6' 	=> esc_html__('Column 6', 'olam'),
		)
	),
	'thumbordetail'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Download Listing Style', 'olam'),
		'choices' => array(
			'thumb'  => esc_html__('Thumb', 'olam'),
			'details' => esc_html__('Details', 'olam'),
			)
	),
	'category'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Download Category', 'olam'),
		'choices' =>$catArray
	),

);

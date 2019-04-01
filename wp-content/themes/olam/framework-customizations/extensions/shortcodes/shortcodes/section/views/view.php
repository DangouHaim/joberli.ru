<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$bg_color = '';
if ( ! empty( $atts['background_color'] ) ) {
	$bg_color = 'background-color:' . $atts['background_color'] . ';';
}
$bg_image = '';
if ( ! empty( $atts['background_image'] ) && ! empty( $atts['background_image']['data']['icon'] ) ) {
	$bg_image = 'background-image:url(' . esc_url($atts['background_image']['data']['icon']) . ');';
}
$bg_video_data_attr    = '';
$section_extra_classes = '';
$text_color = '';
if ( ! empty( $atts['textcolor'] ) ){
	$text_color = 'color:' . $atts['textcolor'] . ';';
	$section_extra_classes .= 'colored-section';
}
if ( ! empty( $atts['video'] ) ) {
	$filetype           = wp_check_filetype( $atts['video'] );
	$filetypes          = array( 'mp4' => 'mp4', 'ogv' => 'ogg', 'webm' => 'webm', 'jpg' => 'poster' );
	$filetype           = array_key_exists( (string) $filetype['ext'], $filetypes ) ? $filetypes[ $filetype['ext'] ] : 'video';
	$bg_video_data_attr = 'data-wallpaper-options="' . fw_htmlspecialchars( json_encode( array( 'source' => array( $filetype => $atts['video'] ) ) ) ) . '"';
	$section_extra_classes .= ' background-video';
}
$section_style   = ( $bg_color || $bg_image || $text_color ) ? 'style="' . $bg_color . $bg_image . $text_color .'"' : '';
$container_class = ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) ? 'fw-container-fluid' : 'fw-container';
$fullHeightFlag=0;
if(isset($atts['full_height']) && ($atts['full_height']==1)){
	$section_extra_classes .= ' cover-pages';
	$fullHeightFlag=1;
}
if(isset($atts['remove_padding']) && ($atts['remove_padding']==1)){
	$section_extra_classes .= ' no-padding';
	$fullHeightFlag=1;
}
if(isset($atts['customcss']) && (strlen($atts['customcss'])>1) ){
	$section_extra_classes .= ' '.$atts['customcss'].'';
}

$darkOverlay=null;
$sectionBG=null;

if(isset($atts['dark_overlay']) && ($atts['dark_overlay']==1) ) { 
	$sectionBG=' section-bg';
	$section_extra_classes .=$sectionBG;
	$darkOverlay='<div class="dark-overlay"></div>';
}

if(isset($atts['parallax_section']) && ($atts['parallax_section']==1) ) { 
	$section_extra_classes .=" parallax-section";
}


if ( ! empty( $atts['background_image'] ) && !isset($sectionBG) ){
	$sectionBG=' section-bg';
	$section_extra_classes .=$sectionBG;
}
?>
<div  class="fw-main-row section <?php echo esc_attr($section_extra_classes); ?>" <?php echo ($section_style); ?> <?php echo ($bg_video_data_attr); ?>>	
	<?php  echo wp_kses($darkOverlay,array('div'=>array('class'=>array())));
		if($fullHeightFlag==1){
			echo '<div class="centered">';
		}
		$smallFlag=0;	
		if(isset($atts['smalltitle']) && ($atts['smalltitle']==1) ) { 
		$smallFlag=1;
	?>
	<div class="container">
		<?php if(isset( $atts['title']) && (strlen( $atts['title'])>0) ){ ?><h5><?php echo wp_kses($atts['title'],array('span'=>array('class'=>array()))); ?></h5><?php } ?>
	</div>
	<?php } ?>   
	<div class="<?php echo esc_attr($container_class); ?>">
		<?php if(isset($atts['title']) && (strlen($atts['title'])>0) && ($smallFlag==0)){ ?>
		<div class="section-heading">				
			<h2><?php echo esc_html($atts['title']); ?> </h2>		
			<?php if(isset($atts['description'])){ ?>
			<p><?php echo esc_html($atts['description']); ?> </p>
			<?php } ?>
		</div>
		<?php } ?>
		<?php echo do_shortcode( $content ); ?>
	</div>
	<?php 	if($fullHeightFlag==1){
		echo '</div>';
	} ?>
</div>

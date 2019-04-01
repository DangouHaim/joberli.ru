<?php
if(!olam_check_edd_exists()){
	return;
}

add_action('widgets_init', 'olam_download_features_widget');

function olam_download_features_widget()
{
	register_widget('olam_download_features_widget');
}

class olam_download_features_widget extends WP_Widget {
	
	function __construct()
	{
		$widget_ops = array('classname' => 'olam_download_features_widget', 'description' => esc_html__('Displays download item features. Used in Single Download Sidebar','olam') );
		$control_ops = array('id_base' => 'olam_download_features_widget');
		parent::__construct('olam_download_features_widget', esc_html__('Olam download features widget','olam'), $widget_ops, $control_ops);
		
	}
	function widget($args, $instance)
	{
		extract($args);
	
		$title = $instance['title'];
		echo $before_widget;
		?>
		<?php global $wp_query;
		$postID = $wp_query->post->ID; ?>
		<div class="sidebar-title"><i class="demo-icons icon-menu"></i> <?php echo esc_html($title); ?> </div>
		<div class="details-table">
			<?php $downloadDetails=olam_get_page_option($postID,'download_features'); 
			if($downloadDetails){ ?>	
			<ul>
				<?php foreach ($downloadDetails as $downloadDetailsKey => $downloadDetailsValue) { ?>
				<li><?php if(isset($downloadDetailsValue['feature_name']) && (strlen($downloadDetailsValue['feature_name'])>0) ) { ?><span><?php echo esc_html($downloadDetailsValue['feature_name']); ?></span> <?php } ?><?php if(isset($downloadDetailsValue['feature_value']) && (strlen($downloadDetailsValue['feature_name'])>0 ) ) { ?> <span class="right"><?php echo esc_html($downloadDetailsValue['feature_value']); ?></span><?php } ?></li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance)
	{
		$defaults = array('title' => esc_html__('Details','olam') );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','olam');?>:</label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<?php }
	}